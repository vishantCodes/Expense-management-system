@extends('layouts.app')

@section('app-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Department Budgets</h3>
            <p class="text-muted mb-0">Manage monthly budget allocations for departments.</p>
        </div>
    </div>

    <div class="card p-3 mb-4">
        <h5 class="mb-3">Add / Update Budget</h5>
        <form action="{{ route('admin.department.budget.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Year</label>
                    <input type="number" name="year" min="2000" max="2099" value="{{ old('year', now()->year) }}" class="form-control @error('year') is-invalid @enderror">
                    @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Month</label>
                    <select name="month" class="form-select @error('month') is-invalid @enderror">
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ old('month', now()->month) == $month ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                        @endforeach
                    </select>
                    @error('month') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" name="amount" step="0.01" min="0" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror">
                    </div>
                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-primary w-100">Save Budget</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budgets as $budget)
                    <tr>
                        <td>{{ $budget->department->title }}</td>
                        <td>{{ $budget->year }}</td>
                        <td>{{ DateTime::createFromFormat('!m', $budget->month)->format('F') }}</td>
                        <td>{{ number_format($budget->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
