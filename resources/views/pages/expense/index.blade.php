@extends('layouts.app')

@section('app-content')

    <div class="expense-page">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="expense-title mb-1">Expense Requests</h3>
                <p class="text-muted mb-0">Manage and track all expense requests</p>
            </div>

            <a href="{{ route('admin.expense.create') }}" class="btn btn-primary">
                <i class='bx bx-plus'></i>
                New Request
            </a>
        </div>

        <div class="card expense-card border-0 shadow-sm">
            <div class="card-body">
                <table id="expense-requests-table" class="my-data-table table align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Request By</th>
                            <th>Department</th>
                            <th>Category</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Pre-Authorized</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            $('#expense-requests-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('admin.expense.index') }}",
                    type: "GET",
                    dataSrc: "data"
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        render: function (data) {
                            return `<span class="fw-bold text-primary">#${data}</span>`;
                        }
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'

                    },
                    {
                        data: 'department.title',
                        name: 'department.title',
                        defaultContent: ''
                    },
                    {
                        data: 'category.title',
                        name: 'category.title',
                        defaultContent: ''
                    },
                    {
                        data: 'vendor.name',
                        name: 'vendor.name',
                        defaultContent: ''
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'request_type.label',
                        name: 'request_type.label',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data) {
                            let badgeClass = 'bg-warning';
                            if (data === 'approved')
                                badgeClass = 'bg-success';
                            if (data === 'rejected')
                                badgeClass = 'bg-danger';
                            return `<span class="badge ${badgeClass} px-3 py-2 text-capitalize">${data}</span>`;
                        }
                    },
                    {
                        data: 'is_pre_authorized',
                        name: 'is_pre_authorized',
                        render: function (data) {
                            let badgeClass = 'bg-warning';
                            if (data === 1) {
                                badgeClass = 'bg-success';
                                dsiplayText = 'Yes';
                            }
                            else if (data === 0) {
                                badgeClass = 'bg-danger';
                                dsiplayText = 'No';
                            }
                            return `<span class="badge ${badgeClass} px-3 py-2 text-capitalize">${dsiplayText}</span>`;
                        }
                    },

                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            // DataTable
                            let viewUrl = @json(route('admin.expense.show', ['expense' => '__ID__']));
                            viewUrl = viewUrl.replace('__ID__', row.id);
                            let editUrl = @json(route('admin.expense.edit', ['expense' => '__ID__']));
                            editUrl = editUrl.replace('__ID__', row.id);
                            return `
                                                            <div class="d-flex gap-1">
                                                                <a href="${viewUrl}" class="btn btn-sm btn-secondary">View</a>
                                                                <a href="${editUrl}" class="btn btn-sm btn-primary">Edit</a>
                                                            </div>
                                                        `;
                        }
                    },

                ]
            });

        });
    </script>
@endpush