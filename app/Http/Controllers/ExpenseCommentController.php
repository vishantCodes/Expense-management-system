<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseComments;
use Illuminate\Http\Request;

class ExpenseCommentController extends Controller
{
    public function store(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'comment' => ['required', 'string'],
        ]);

        ExpenseComments::create([
            'expense_id' => $expense->id,
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
        ]);

        return response()->json(['message' => 'Comment posted successfully.']);
    }
}
