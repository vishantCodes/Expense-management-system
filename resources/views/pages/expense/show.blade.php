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

        @if($expense->approvals && $expense->approvals->isNotEmpty())
            <hr>
            <h6>Approvals</h6>
            <div class="list-group mb-3">
                @foreach($expense->approvals as $approval)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Approved By:</strong> {{ $approval->approver?->name ?? '-' }}
                            </div>
                            <span class="badge bg-success text-capitalize">{{ $approval->status }}</span>
                        </div>
                        <p class="mb-1"><strong>Amount:</strong> ₹{{ number_format($approval->approved_amount, 2) }}</p>
                        <p class="mb-0"><strong>Remarks:</strong> {{ $approval->remarks }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if($expense->rejections && $expense->rejections->isNotEmpty())
            <hr>
            <h6>Rejections</h6>
            <div class="list-group mb-3">
                @foreach($expense->rejections as $rejection)
                    <div class="list-group-item border-danger">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Rejected By:</strong> {{ $rejection->rejecter?->name ?? '-' }}
                            </div>
                            <span class="badge bg-danger text-capitalize">Rejected</span>
                        </div>
                        <p class="mb-1"><strong>Category:</strong> {{ $rejection->category?->title ?? '-' }}</p>
                        <p class="mb-0"><strong>Remarks:</strong> {{ $rejection->remarks }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if($expense->queries && $expense->queries->isNotEmpty())
            <hr>
            <h6>Queries</h6>
            <div class="list-group mb-3">
                @foreach($expense->queries as $query)
                    <div class="list-group-item border-warning">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Raised By:</strong> {{ $query->requester?->name ?? '-' }}
                            </div>
                            <span class="badge bg-warning text-dark text-capitalize">{{ $query->status }}</span>
                        </div>
                        <p class="mb-1"><strong>Category:</strong> {{ $query->category?->title ?? '-' }}</p>
                        <p class="mb-0"><strong>Remarks:</strong> {{ $query->remarks }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if($expense->comments && $expense->comments->isNotEmpty())
            <hr>
            <h6>Comments</h6>
            <div class="list-group mb-3">
                @foreach($expense->comments as $comment)
                    <div class="list-group-item border-secondary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $comment->user?->name ?? 'System' }}</strong>
                            </div>
                            <small class="text-muted">{{ $comment->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                        <p class="mb-0">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif

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
