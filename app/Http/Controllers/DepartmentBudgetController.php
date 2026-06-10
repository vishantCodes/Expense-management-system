<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentBudget;
use Illuminate\Http\Request;

class DepartmentBudgetController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        $departments = Department::all();
        $budgets = DepartmentBudget::with('department')
            ->orderByDesc('year')
            ->orderBy('month')
            ->get();

        return view('pages.department.budget', compact('departments', 'budgets'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'year' => ['required', 'integer', 'digits:4'],
            'month' => ['required', 'integer', 'between:1,12'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        DepartmentBudget::updateOrCreate(
            [
                'department_id' => $data['department_id'],
                'year' => $data['year'],
                'month' => $data['month'],
            ],
            ['amount' => $data['amount']]
        );

        return redirect()->route('admin.department.budget.index')
            ->with('success', 'Department budget saved successfully!');
    }
}
