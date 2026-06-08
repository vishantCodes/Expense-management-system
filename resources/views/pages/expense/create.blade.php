@extends('layouts.app')
@section('app-content')
    <div class="mb-4">
        <h4>
            <i>Create Expense Request</i>
        </h4>
    </div>

    <form action="{{ route('admin.expense.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="container-fluid mb-4">
            {{-- Basic information --}}
            <div class="row mb-3 border rounded-2 p-2">
                <h6 class="mb-4 p-1 fw-bold">Basic information</h6>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for="expense_request_type_id" class="form-label">Request Type</label>
                    <select class="form-select @error('expense_request_type_id') is-invalid @enderror"
                        name="expense_request_type_id" id="expense_request_type_id">
                        <option value="">Select Request Type</option>
                        @foreach ($requestTypeOptions as $type)
                            <option value="{{ $type->id }}"
                                {{ old('expense_request_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('request_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for="expense_category_id" class="form-label">Category</label>
                    <select class="form-select @error('expense_category_id') is-invalid @enderror"
                        name="expense_category_id" id="expense_category_id">
                        <option value="">Select Category</option>
                        @foreach ($requestCategories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('expense_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for="department_id" class="form-label">Department</label>
                    <select class="form-select @error('department_id') is-invalid @enderror"
                        name="department_id" id="department_id">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label for="amount" class="form-label">Amount</label>
                    <input placeholder="Enter Expense Amount"
                        class="form-control @error('amount') is-invalid @enderror"
                        id="amount" name="amount"
                        value="{{ old('amount') }}">
                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Expense Details --}}
            <div class="row mb-3 border rounded-2 p-2">
                <h6 class="mb-4 p-1 fw-bold">Expense Details</h6>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter Description" id="description" name="description"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="justification" class="form-label">Justification</label>
                        <textarea class="form-control @error('justification') is-invalid @enderror"
                        placeholder="Enter Justification" id="justification" name="justification"
                        rows="3">{{ old('justification') }}</textarea>
                    @error('justification') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                    <label class="form-label d-block">Is Pre-Authorized?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('is_pre_authorized') is-invalid @enderror"
                            type="radio" name="is_pre_authorized" id="preAuthorizedYes" value="1"
                            {{ old('is_pre_authorized', '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="preAuthorizedYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"
                            name="is_pre_authorized" id="preAuthorizedNo" value="0"
                            {{ old('is_pre_authorized', '0') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="preAuthorizedNo">No</label>
                    </div>
                    @error('is_pre_authorized') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Payment / Reimbursement --}}
            <div class="row mb-3 border rounded-2 p-2">
                <h6 class="mb-4 p-1 fw-bold">Payment/Reimbursement Information</h6>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                name="payment_method" id="payment_method">
                                <option value="">Select Payment Method</option>
                                @foreach (['any' => 'Any', 'online' => 'Online', 'cash' => 'Cash', 'cheque' => 'Cheque'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('payment_method') == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                            <label for="vendor_id" class="form-label">Vendor</label>
                            <select class="form-select @error('vendor_id') is-invalid @enderror"
                                id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label for="transaction_reference" class="form-label">Transaction Reference</label>
                            <input class="form-control @error('transaction_reference') is-invalid @enderror"
                                placeholder="Enter Transaction Reference" id="transaction_reference"
                                name="transaction_reference"
                                value="{{ old('transaction_reference') }}">
                            @error('transaction_reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input class="form-control @error('payment_date') is-invalid @enderror"
                                id="payment_date" type="date" name="payment_date"
                                value="{{ old('payment_date') }}">
                            @error('payment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="attachments" class="form-label">Attachments</label>
                            <input type="file" name="attachments[]"
                                class="form-control @error('attachments') is-invalid @enderror @error('attachments.*') is-invalid @enderror"
                                multiple id="attachments">
                            @error('attachments') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @error('attachments.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 p-2">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.expense.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </form>
@endsection