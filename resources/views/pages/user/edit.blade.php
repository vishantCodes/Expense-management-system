@extends('layouts.app')
@section('app-content')
    <div class="mb-4">
        <h4>Edit User</h4>
    </div>

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container-fluid mb-4">
            <div class="row mb-3 border rounded-2 p-2">
                <h6 class="mb-4 p-1 fw-bold">User Information</h6>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Password (leave blank to keep)</label>
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="form-control">
                </div>
            </div>

            <div class="row mb-3 border rounded-2 p-2">
                <h6 class="mb-4 p-1 fw-bold">Organization</h6>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                        <option value="">-- Select --</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" {{ old('department_id', $user->department_id) == $d->id ? 'selected' : '' }}>{{ $d->title }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Roles</label>
                    <select name="roles[]" class="form-select" multiple>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" {{ in_array($r->name, old('roles', $user->getRoleNames()->toArray())) ? 'selected' : '' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3 p-2">
                <div class="col-md-12 text-end">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </div>
    </form>
@endsection
