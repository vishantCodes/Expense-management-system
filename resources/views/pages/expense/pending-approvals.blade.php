@extends('layouts.app')

@section('app-content')

    <div class="expense-page">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="expense-title mb-1">Pending Approvals</h3>
                <p class="text-muted mb-0">Review and take action on pending expense requests</p>
            </div>
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

    {{-- ===================== APPROVE MODAL ===================== --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="approveModalLabel">
                        <i class='bx bx-check-circle me-2'></i>Approve Expense
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="approveForm">
                    @csrf
                    <input type="hidden" name="expense_id" id="approve_expense_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Approved Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="approved_amount" id="approve_amount" class="form-control"
                                    placeholder="Enter approved amount" required min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Remarks <span class="text-danger">*</span></label>
                            <textarea name="remarks" id="approve_remarks" class="form-control" rows="3"
                                placeholder="Add approval remarks..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class='bx bx-check me-1'></i>Approve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== REJECT MODAL ===================== --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class='bx bx-x-circle me-2'></i>Reject Expense
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="rejectForm">
                    @csrf
                    <input type="hidden" name="expense_id" id="reject_expense_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rejection Category <span
                                    class="text-danger">*</span></label>
                            <select name="rejection_category_id" id="reject_category" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($rejectionCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Remarks <span class="text-danger">*</span></label>
                            <textarea name="remarks" id="reject_remarks" class="form-control" rows="3"
                                placeholder="State reason for rejection..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class='bx bx-x me-1'></i>Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== QUERY MODAL ===================== --}}
    <div class="modal fade" id="queryModal" tabindex="-1" aria-labelledby="queryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="queryModalLabel">
                        <i class='bx bx-question-mark me-2'></i>Raise Query
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="queryForm">
                    @csrf
                    <input type="hidden" name="expense_id" id="query_expense_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Query Category <span class="text-danger">*</span></label>
                            <select name="expense_query_category_id" id="query_category" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($queryCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" id="query_status" class="form-select" required>
                                <option value="">-- Select Status --</option>
                                <option value="open">Open</option>
                                <option value="awaiting_response">Awaiting Response</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Remarks <span class="text-danger">*</span></label>
                            <textarea name="remarks" id="query_remarks" class="form-control" rows="3"
                                placeholder="Describe your query..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-dark">
                            <i class='bx bx-send me-1'></i>Submit Query
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== COMMENT MODAL ===================== --}}
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="commentModalLabel">
                        <i class='bx bx-comment-detail me-2'></i>Add Comment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="commentForm">
                    @csrf
                    <input type="hidden" name="expense_id" id="comment_expense_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comment <span class="text-danger">*</span></label>
                            <textarea name="comment" id="comment_text" class="form-control" rows="4"
                                placeholder="Write your comment here..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">
                            <i class='bx bx-comment-add me-1'></i>Post Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            // ── DataTable ──────────────────────────────────────────────
            $('#expense-requests-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('admin.expense.pendingApprovals') }}",
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
                    { data: 'user.name', name: 'user.name' },
                    { data: 'department.title', name: 'department.title', defaultContent: '' },
                    { data: 'category.title', name: 'category.title', defaultContent: '' },
                    { data: 'vendor.name', name: 'vendor.name', defaultContent: '' },
                    { data: 'amount', name: 'amount' },
                    { data: 'payment_method', name: 'payment_method' },
                    { data: 'request_type.label', name: 'request_type.label' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data) {
                            let badgeClass = 'bg-warning';
                            if (data === 'approved') badgeClass = 'bg-success';
                            if (data === 'rejected') badgeClass = 'bg-danger';
                            return `<span class="badge ${badgeClass} px-3 py-2 text-capitalize">${data}</span>`;
                        }
                    },
                    {
                        data: 'is_pre_authorized',
                        name: 'is_pre_authorized',
                        render: function (data) {
                            let badgeClass = data === 1 ? 'bg-success' : 'bg-danger';
                            let displayText = data === 1 ? 'Yes' : 'No';
                            return `<span class="badge ${badgeClass} px-3 py-2 text-capitalize">${displayText}</span>`;
                        }
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            let viewUrl = @json(route('admin.expense.show', ['expense' => '**ID**']));
                            viewUrl = viewUrl.replace('**ID**', row.id);

                            let editUrl = @json(route('admin.expense.edit', ['expense' => '**ID**']));
                            editUrl = editUrl.replace('**ID**', row.id);

                            let approveUrl = @json(route('admin.expense.approve', ['expense' => '**ID**']));
                            approveUrl = approveUrl.replace('**ID**', row.id);

                            let rejectUrl = @json(route('admin.expense.reject', ['expense' => '**ID**']));
                            rejectUrl = rejectUrl.replace('**ID**', row.id);

                            let queryUrl = @json(route('admin.expense.store.query', ['expense' => '**ID**']));
                            queryUrl = queryUrl.replace('**ID**', row.id);

                            let commentUrl = @json(route('admin.expense.store.comment', ['expense' => '**ID**']));
                            commentUrl = commentUrl.replace('**ID**', row.id);
                            return `
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                             <ul class="dropdown-menu shadow border-0 p-2" style="min-width: 220px;">
                                                 <li>
                                                        <button
                                                            class="dropdown-item text-success btn-approve"
                                                            data-id="${row.id}"
                                                            data-amount="${row.amount}">
                                                            <i class="bx bx-check-circle me-2"></i>
                                                            Approve
                                                        </button>
                                                    </li>
                                                 <li>
                                                        <button
                                                            class="dropdown-item text-danger btn-reject"
                                                            data-id="${row.id}">
                                                            <i class="bx bx-x-circle me-2"></i>
                                                            Reject
                                                        </button>
                                                    </li>
                                                 <li>
                                                        <button
                                                            class="dropdown-item text-warning btn-query"
                                                            data-id="${row.id}">
                                                            <i class="bx bx-help-circle me-2"></i>
                                                            Raise Query
                                                        </button>
                                                    </li>
                                                 <li>
                                                        <button
                                                            class="dropdown-item text-secondary btn-comment"
                                                            data-id="${row.id}">
                                                            <i class="bx bx-comment-detail me-2"></i>
                                                            Comment
                                                        </button>
                                                    </li>
                                                 <li><hr class="dropdown-divider"></li>
                                                 <li>
                                                        <a href="${viewUrl}" class="dropdown-item">
                                                            <i class="bx bx-show me-2"></i>
                                                            View
                                                        </a>
                                                    </li>
                                                 <li>
                                                        <a href="${editUrl}" class="dropdown-item">
                                                            <i class="bx bx-edit me-2"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                             </ul>
                                            </div>
                                        `;
                        }
                    }
                ]
            });

            // ── Open modals ────────────────────────────────────────────
            $(document).on('click', '.btn-approve', function () {
                const id = $(this).data('id');
                let url = @json(route('admin.expense.approve', ['expense' => '__ID__']));
                $('#approve_expense_id').val(id);
                $('#approve_amount').val($(this).data('amount'));
                $('#approveForm').data('url', url.replace('__ID__', id));
                new bootstrap.Modal(document.getElementById('approveModal')).show();
            });

            $(document).on('click', '.btn-reject', function () {
                const id = $(this).data('id');
                let url = @json(route('admin.expense.reject', ['expense' => '__ID__']));
                $('#reject_expense_id').val(id);
                $('#rejectForm').data('url', url.replace('__ID__', id));
                new bootstrap.Modal(document.getElementById('rejectModal')).show();
            });

            $(document).on('click', '.btn-query', function () {
                const id = $(this).data('id');
                let url = @json(route('admin.expense.store.query', ['expense' => '__ID__']));
                $('#query_expense_id').val(id);
                $('#queryForm').data('url', url.replace('__ID__', id));
                new bootstrap.Modal(document.getElementById('queryModal')).show();
            });

            $(document).on('click', '.btn-comment', function () {
                const id = $(this).data('id');
                let url = @json(route('admin.expense.store.comment', ['expense' => '__ID__']));
                $('#comment_expense_id').val(id);
                $('#commentForm').data('url', url.replace('__ID__', id));
                new bootstrap.Modal(document.getElementById('commentModal')).show();
            });

            // Reset forms on modal close — use native BS event
            document.querySelectorAll('.modal').forEach(function (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    this.querySelector('form')?.reset();
                    const btn = this.querySelector('[type=submit]');
                    if (btn) btn.disabled = false;
                });
            });

            // ── Form helpers ───────────────────────────────────────────
            function submitForm(formId, modalId) {
                $(formId).on('submit', function (e) {
                    e.preventDefault();
                    const url = $(this).data('url');
                    const $btn = $(this).find('[type=submit]');
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Processing...');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (res) {
                            bootstrap.Modal.getInstance(document.querySelector(modalId))?.hide();
                            $(formId)[0].reset();
                            $('#expense-requests-table').DataTable().ajax.reload(null, false);
                            toastr.success(res.message ?? 'Action completed successfully.');
                        },
                        error: function (xhr) {
                            const errors = xhr.responseJSON?.errors;
                            if (errors) {
                                toastr.error(Object.values(errors).flat().join('<br>'));
                            } else {
                                toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');
                            }
                        },
                        complete: function () {
                            $btn.prop('disabled', false);
                        }
                    });
                });
            }

            submitForm('#approveForm', '#approveModal');
            submitForm('#rejectForm', '#rejectModal');
            submitForm('#queryForm', '#queryModal');
            submitForm('#commentForm', '#commentModal');

            // Reset forms on modal close
            $('.modal').on('hidden.bs.modal', function () {
                $(this).find('form')[0]?.reset();
                $(this).find('[type=submit]').prop('disabled', false);
            });

        });
    </script>
@endpush