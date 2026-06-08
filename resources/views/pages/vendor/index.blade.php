@extends('layouts.app')
@section('app-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Vendors</h3>
        <a href="{{ route('admin.vendor.create') }}" class="btn btn-primary">New Vendor</a>
    </div>

    <div class="card p-3">
        <table class="table">
            <thead><tr><th>ID</th><th>Name</th><th>Active</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($vendors as $v)
                    <tr>
                        <td>#{{ $v->id }}</td>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.vendor.show', $v->id) }}" class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('admin.vendor.edit', $v->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.vendor.destroy', $v->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete vendor?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
