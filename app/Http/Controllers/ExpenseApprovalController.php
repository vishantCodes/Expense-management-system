<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseApprovals;
use Illuminate\Http\Request;

class ExpenseApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Expense $expense)
    {

        $data = $request->validate([
            'approved_amount' => ['required', 'numeric', 'lte:' . $expense->amount,],
            'remarks' => ['nullable', 'string']
        ]);
        $data['approver_id'] = auth()->id();
        $data['expense_id'] = $expense->id;
        $data['status'] = 'approved';
        ExpenseApprovals::create($data);
        $expense->status = 'approved';
        $expense->save();
        return redirect()->back()->with('success', 'Expense Approved successfully!');
        // dd(['request' => $request->all(), 'expense' => $expense]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseApprovals $expenseApprovals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseApprovals $expenseApprovals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseApprovals $expenseApprovals)
    {
        //
    }
}
