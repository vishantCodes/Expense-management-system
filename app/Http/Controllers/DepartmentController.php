<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $this->authorizeSuperAdmin();
        $departments = Department::with('manager')->get();
        return view('pages.department.index', compact('departments'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();
        $managers = User::role('manager')->get();
        return view('pages.department.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'budget' => ['required', 'numeric', 'min:0'],
        ]);

        Department::create($data);

        return redirect()->route('admin.department.index')->with('success', 'Department created successfully!');
    }

    public function show(Department $department)
    {
        $this->authorizeSuperAdmin();
        return view('pages.department.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $this->authorizeSuperAdmin();
        $managers = User::role('manager')->get();
        return view('pages.department.edit', compact('department', 'managers'));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorizeSuperAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'budget' => ['required', 'numeric', 'min:0'],
        ]);

        $department->update($data);

        return redirect()->route('admin.department.index')->with('success', 'Department updated successfully!');
    }

    public function destroy(Department $department)
    {
        $this->authorizeSuperAdmin();

        $department->delete();

        return redirect()->route('admin.department.index')->with('success', 'Department deleted successfully!');
    }

    private function authorizeSuperAdmin()
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }
    }
}
