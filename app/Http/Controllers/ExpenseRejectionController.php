<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseRejection;
use Illuminate\Http\Request;

class ExpenseRejectionController extends Controller
{
    public function store(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'rejection_category_id' => ['required', 'exists:expense_rejection_categories,id'],
            'remarks' => ['required', 'string'],
        ]);

        ExpenseRejection::create([
            'expense_id' => $expense->id,
            'rejecter_id' => auth()->id(),
            'rejection_category_id' => $data['rejection_category_id'],
            'remarks' => $data['remarks'],
        ]);

        $expense->status = 'rejected';
        $expense->save();

        return response()->json(['message' => 'Expense rejected successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseRejection $expenseRejection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseRejection $expenseRejection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseRejection $expenseRejection)
    {
        //
    }
}
