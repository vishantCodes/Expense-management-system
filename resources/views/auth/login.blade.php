@extends('layouts.guest')

@section('guest-content')

    <div class="auth-card">

        <div class="text-center mb-4">
            <h2 class="fw-bold purple_primary">
                Expense Manager
            </h2>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control auth-input" required autofocus
                    placeholder="john@example.com">
                @error('email')
                    <div class="form-label mt-4 mb-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control auth-input" placeholder="••••••••">
                @error('password')
                    <div class="label -mt-4 mb-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <button class="btn btn-primary w-100">
                Sign In
            </button>
        </form>
    </div>

@endsection