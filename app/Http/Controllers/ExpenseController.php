<?php

namespace App\Http\Controllers;

use App\Enums\ExpenseStatusEnum;
use App\Enums\ExpenseTypeEnum;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Department;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\ExpenseQueryCategory;
use App\Models\ExpenseRejectionCategory;
use App\Models\ExpenseRequestType;
use App\Models\Vendor;
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
        return view('pages.expense.create', compact(
            'requestTypeOptions',
            'requestCategories',
            'departments',
            'vendors'
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

        return view('pages.expense.edit', compact(
            'expense',
            'requestTypeOptions',
            'requestCategories',
            'departments',
            'vendors'
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
    private function getDepartments()
    {
        if (auth()->user()->hasRole(['super-admin', 'accounts'])) {
            return Department::all();
        }
        return auth()->user()->department;
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
