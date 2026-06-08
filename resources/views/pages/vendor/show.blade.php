@extends('layouts.app')
@section('app-content')
    <h4>Vendor #{{ $vendor->id }}</h4>
    <p><strong>Name:</strong> {{ $vendor->name }}</p>
    <p><strong>Active:</strong> {{ $vendor->is_active ? 'Yes' : 'No' }}</p>
    <a href="{{ route('admin.vendor.index') }}" class="btn btn-light">Back</a>
@endsection
