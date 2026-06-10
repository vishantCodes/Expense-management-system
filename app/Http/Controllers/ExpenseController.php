<?php

namespace App\Http\Controllers;

use App\Enums\ExpenseStatusEnum;
use App\Enums\ExpenseTypeEnum;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Department;
use App\Models\DepartmentBudget;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\ExpenseQueryCategory;
use App\Models\ExpenseRejectionCategory;
use App\Models\ExpenseRequestType;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Expense::with([
                'requestType:id,label',
                'user:id,name',
                'category:id,title',
                'department:id,title',
                'vendor:id,name'
            ])->get();
            // dd($data);
            return DataTables::of($data)->make(true);
        }
        return view('pages.expense.index');
    }

    public function create()
    {
        $requestTypeOptions  = ExpenseRequestType::select(['id', 'label'])->get();
        $requestCategories   = ExpenseCategory::select(['id', 'title'])->get();
        $departments         = $this->getDepartments();
        $vendors             = Vendor::where('is_active', true)->get();
        $departmentBudgets   = $this->buildBudgetMap($departments);
        return view('pages.expense.create', compact(
            'requestTypeOptions',
            'requestCategories',
            'departments',
            'vendors',
            'departmentBudgets'
        ));
    }

    public function store(StoreExpenseRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status']  = ExpenseStatusEnum::PENDING->value;

        unset($data['attachments']);

        $expense = Expense::create($data);

        $this->handleAttachments($request, $expense);

        return redirect()->route('admin.expense.index')
            ->with('success', 'Expense created successfully!');
    }

    public function show(Expense $expense)
    {
        return view('pages.expense.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $requestTypeOptions  = ExpenseRequestType::select(['id', 'label'])->get();
        $requestCategories   = ExpenseCategory::select(['id', 'title'])->get();
        $departments         = $this->getDepartments();
        $vendors             = Vendor::where('is_active', true)->get();
        $departmentBudgets   = $this->buildBudgetMap($departments);

        return view('pages.expense.edit', compact(
            'expense',
            'requestTypeOptions',
            'requestCategories',
            'departments',
            'vendors',
            'departmentBudgets'
        ));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $data = $request->validated();
        unset($data['attachments']);
        $expense->update($data);
        $this->handleAttachments($request, $expense);
        return redirect()->route('admin.expense.index')
            ->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        //
    }

    public function pendingApprovals()
    {
        if (request()->ajax()) {
            $query = Expense::where('status', 'pending')
                ->with([
                    'requestType:id,label',
                    'user:id,name',
                    'category:id,title',
                    'department:id,title',
                    'vendor:id,name'
                ]);

            return DataTables::of($query)->make(true);
        }
        $rejectionCategories = ExpenseRejectionCategory::select('id', 'title')->get();
        $queryCategories = ExpenseQueryCategory::select('id', 'title')->get();
        return view('pages.expense.pending-approvals', compact('rejectionCategories', 'queryCategories'));
    }
    private function getDepartments(): Collection
    {
        if (auth()->user()->hasRole(['super-admin', 'accounts'])) {
            return Department::all();
        }

        return Department::where('id', auth()->user()->department_id)->get();
    }

    private function buildBudgetMap($departments): array
    {
        if ($departments instanceof Department) {
            $departments = collect([$departments]);
        }

        $year = now()->year;
        $month = now()->month;

        $approvedExpenseSums = Expense::where('status', ExpenseStatusEnum::APPROVED->value)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('department_id')
            ->selectRaw('department_id, SUM(amount) as total')
            ->pluck('total', 'department_id')
            ->toArray();

        $budgetRecords = DepartmentBudget::where('year', $year)
            ->where('month', $month)
            ->whereIn('department_id', $departments->pluck('id'))
            ->get()
            ->keyBy('department_id');

        return $departments->mapWithKeys(function ($department) use ($approvedExpenseSums, $budgetRecords) {
            $budget = $budgetRecords->has($department->id) ? $budgetRecords->get($department->id)->amount : 0;
            $approved = $approvedExpenseSums[$department->id] ?? 0;
            return [$department->id => max(0, $budget - $approved)];
        })->toArray();
    }

    private function handleAttachments(Request $request, Expense $expense): void
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $expense->attachments()->create([
                    'file_path'   => $path,
                    'file_name'   => $file->getClientOriginalName(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }
    }
}
