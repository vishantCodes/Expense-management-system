@extends('layouts.app')
@section('app-content')
    <h4>User #{{ $user->id }}</h4>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Department:</strong> {{ $user->department?->title ?? '-' }}</p>
    <p><strong>Roles:</strong> {{ implode(', ', $user->getRoleNames()->toArray()) }}</p>
    <a href="{{ route('admin.user.index') }}" class="btn btn-light">Back</a>
@endsection
