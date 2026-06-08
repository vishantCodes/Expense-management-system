@extends('layouts.app')
@section('app-content')
    <div class="mb-4">
        <h4>Edit Vendor</h4>
    </div>

    <form action="{{ route('admin.vendor.update', $vendor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container-fluid mb-4">
            <div class="row mb-3 border rounded-2 p-2">
                <h6 class="mb-4 p-1 fw-bold">Vendor Details</h6>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $vendor->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Contact Person</label>
                    <input name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $vendor->contact_person) }}">
                    @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $vendor->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Phone</label>
                    <input name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $vendor->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">GST No</label>
                    <input name="gst_no" class="form-control @error('gst_no') is-invalid @enderror" value="{{ old('gst_no', $vendor->gst_no) }}">
                    @error('gst_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Bank Name</label>
                    <input name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name', $vendor->bank_name) }}">
                    @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Account Number</label>
                    <input name="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ old('account_number', $vendor->account_number) }}">
                    @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">IFSC</label>
                    <input name="ifsc" class="form-control @error('ifsc') is-invalid @enderror" value="{{ old('ifsc', $vendor->ifsc) }}">
                    @error('ifsc') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $vendor->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <label class="form-label">City</label>
                    <input name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $vendor->city) }}">
                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <label class="form-label">State</label>
                    <input name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state', $vendor->state) }}">
                    @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <label class="form-label">Postal Code</label>
                    <input name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" value="{{ old('postal_code', $vendor->postal_code) }}">
                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Country</label>
                    <input name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $vendor->country ?? 'India') }}">
                    @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3 form-check align-items-center d-flex">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input me-2" {{ old('is_active', $vendor->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>
            </div>

            <div class="row mb-3 p-2">
                <div class="col-md-12 text-end">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.vendor.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </div>
    </form>
@endsection
