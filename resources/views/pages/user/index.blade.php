@extends('layouts.app')
@section('app-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Users</h3>
        @if(auth()->user()->hasRole('super-admin'))
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">New User</a>
        @endif
    </div>

    <div class="card p-3">
        <table class="table">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Department</th><th>Roles</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>#{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->department?->title ?? '-' }}</td>
                        <td>{{ implode(', ', $u->getRoleNames()->toArray()) }}</td>
                        <td>
                            <a href="{{ route('admin.user.show', $u->id) }}" class="btn btn-sm btn-secondary">View</a>
                            @if(auth()->user()->hasRole('super-admin') && $u->id !== auth()->user()->id)
                                <a href="{{ route('admin.user.edit', $u->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
