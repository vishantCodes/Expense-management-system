@extends('layouts.app')
@section('app-content')

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Expense Receipt</h4>
            <small class="text-muted">Receipt for expense request #{{ $expense->id }}</small>
        </div>
        <div>
            <a href="{{ route('admin.expense.index') }}" class="btn btn-light">Back</a>
            <button class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
    </div>

    <div class="card p-4">
        <div class="row">
            <div class="col-md-6">
                <h5>Request Details</h5>
                <table class="table table-borderless">
                    <tr><th>Request ID:</th><td>#{{ $expense->id }}</td></tr>
                    <tr><th>Requested By:</th><td>{{ $expense->user?->name ?? '-' }}</td></tr>
                    <tr><th>Department:</th><td>{{ $expense->department?->title ?? '-' }}</td></tr>
                    <tr><th>Category:</th><td>{{ $expense->category?->title ?? '-' }}</td></tr>
                    <tr><th>Vendor:</th><td>{{ $expense->vendor?->name ?? '-' }}</td></tr>
                    <tr><th>Amount:</th><td>{{ number_format($expense->amount, 2) }}</td></tr>
                    <tr><th>Payment Method:</th><td>{{ $expense->payment_method ?? '-' }}</td></tr>
                    <tr><th>Type:</th><td>{{ $expense->request_type?->value ?? $expense->request_type ?? '-' }}</td></tr>
                    <tr><th>Status:</th><td class="text-capitalize">{{ $expense->status }}</td></tr>
                </table>
            </div>

            <div class="col-md-6">
                <h5>Notes</h5>
                <p><strong>Description:</strong><br>{{ $expense->description ?? '-' }}</p>
                <p><strong>Justification:</strong><br>{{ $expense->justification ?? '-' }}</p>
                <p><strong>Payment Date:</strong> {{ optional($expense->payment_date)->format('Y-m-d') ?? '-' }}</p>
                <p><strong>Pre-Authorized:</strong> {{ $expense->is_pre_authorized ? 'Yes' : 'No' }}</p>
            </div>
        </div>

        @if($expense->attachments && $expense->attachments->isNotEmpty())
            <hr>
            <h6>Attachments</h6>
            <ul>
                @foreach($expense->attachments as $att)
                    <li><a href="{{ asset('storage/' . $att->file_path) }}" target="_blank">{{ $att->file_name }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>

@endsection
