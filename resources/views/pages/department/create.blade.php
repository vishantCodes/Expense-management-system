@extends('layouts.app')

@section('app-content')
    <div class="mb-4">
        <h4>New Department</h4>
    </div>

    <form action="{{ route('admin.department.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Department Title</label>
                <input name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Manager</label>
                <select name="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
                    <option value="">-- Select Manager --</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>{{ $manager->name }} ({{ $manager->email }})</option>
                    @endforeach
                </select>
                @error('manager_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Annual Budget</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input name="budget" type="number" min="0" step="0.01" value="{{ old('budget') }}" class="form-control @error('budget') is-invalid @enderror">
                </div>
                @error('budget') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 text-end">
                <button class="btn btn-primary">Create</button>
                <a href="{{ route('admin.department.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </div>
    </form>
@endsection
