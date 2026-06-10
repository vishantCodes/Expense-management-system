@extends('layouts.app')

@section('app-content')
    <div class="mb-4">
        <h4>Department #{{ $department->id }}</h4>
        <p class="text-muted">Details for {{ $department->title }}</p>
    </div>

    <div class="card p-3">
        <p><strong>Title:</strong> {{ $department->title }}</p>
        <p><strong>Manager:</strong> {{ $department->manager?->name ?? '-' }}</p>
        <p><strong>Annual Budget:</strong> ₹{{ number_format($department->budget, 2) }}</p>
        <p><strong>Staff Count:</strong> {{ $department->staff()->count() }}</p>

        <a href="{{ route('admin.department.index') }}" class="btn btn-light">Back</a>
    </div>
@endsection
