<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseQuery;
use Illuminate\Http\Request;

class ExpenseQueryController extends Controller
{
    public function store(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'expense_query_category_id' => ['required', 'exists:expense_query_categories,id'],
            'status' => ['required', 'in:open,awaiting_response,resolved'],
            'remarks' => ['required', 'string'],
        ]);

        $data['expense_id'] = $expense->id;
        $data['requester_id'] = auth()->id();

        ExpenseQuery::create($data);

        return response()->json(['message' => 'Query submitted successfully.']);
    }
}
