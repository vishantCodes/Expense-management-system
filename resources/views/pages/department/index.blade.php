@extends('layouts.app')

@section('app-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Departments</h3>
            <p class="text-muted mb-0">Manage departments and assign monthly budgets.</p>
        </div>
        <a href="{{ route('admin.department.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i>
            New Department
        </a>
    </div>

    <div class="card p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Manager</th>
                    <th>Budget</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td>#{{ $department->id }}</td>
                        <td>{{ $department->title }}</td>
                        <td>{{ $department->manager?->name ?? '-' }}</td>
                        <td>{{ number_format($department->budget, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.department.show', $department->id) }}" class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('admin.department.edit', $department->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.department.destroy', $department->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete department?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
