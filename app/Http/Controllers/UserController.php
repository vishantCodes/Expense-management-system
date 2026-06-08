<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('department')->get();
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        $departments = Department::all();
        $roles = Role::all();
        return view('pages.user.create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'roles' => ['nullable', 'array'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'department_id' => $data['department_id'] ?? null,
        ]);

        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return redirect()->route('admin.user.index')->with('success', 'User created');
    }

    public function show(User $user)
    {
        return view('pages.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        if ($user->is(auth()->user())) {
            abort(403);
        }

        $departments = Department::all();
        $roles = Role::all();
        return view('pages.user.edit', compact('user', 'departments', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        if ($user->is(auth()->user())) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'department_id' => 'nullable|exists:departments,id',
            'roles' => 'nullable|array',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->department_id = $data['department_id'] ?? null;
        $user->save();

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return redirect()->route('admin.user.index')->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            abort(403);
        }

        if ($user->is(auth()->user())) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User deleted');
    }
}
