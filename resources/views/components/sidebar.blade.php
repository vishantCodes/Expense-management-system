<div class="l-navbar position-fixed vh-100" id="nav-bar">
    <nav class="nav">
        <div>
            <div class="px-3 mb-2 text-muted small fw-bold"></div>

            <div class="nav_list">
                <a href="#" class="nav_logo">
                    <i class='bx bx-layer nav_logo-icon'></i>
                    <span class="nav_logo-name">EMS</span>

                </a>

                <button type="button"
                    class="nav_link d-flex justify-content-between align-items-center w-100 border-0 bg-transparent"
                    data-bs-toggle="collapse" data-bs-target="#expenseSubmenu" aria-expanded="false"
                    aria-controls="expenseSubmenu">
                    <div>
                        <i class='bx bx-file nav_icon'></i>
                        <span class="nav_name">Expense Request</span>
                    </div>
                    <i class='bx bx-chevron-down nav_arrow_icon small'></i>
                </button>

                <ul class="collapse list-unstyled ps-4 ms-2 border-start" id="expenseSubmenu">
                    <li class="py-1">
                        <a href={{ route('admin.expense.create') }}
                            class="nav_link text-decoration-none py-1 small">Add</a>
                    </li>
                    <li class="py-1">
                        <a href={{ route('admin.expense.index') }}
                            class="nav_link text-decoration-none py-1 small">List</a>
                    </li>
                    @role(['super-admin', 'manager', 'accounts'])
                    <li class="py-1">
                        <a href={{ route('admin.expense.pendingApprovals') }}
                            class="nav_link text-decoration-none py-1 small">Pending Approvals</a>
                    </li>
                    @endrole
                </ul>

                {{-- <a href="#" class="nav_link d-flex justify-content-between align-items-center">
                    <div>
                        <i class='bx bx-tachometer nav_icon'></i>
                        <span class="nav_name">Budget Control</span>
                    </div>
                    <i class='bx bx-chevron-down small text-muted'></i>
                </a> --}}

                <button type="button"
                    class="nav_link d-flex justify-content-between align-items-center w-100 border-0 bg-transparent"
                    data-bs-toggle="collapse" data-bs-target="#departmentSubmenu" aria-expanded="false"
                    aria-controls="departmentSubmenu">
                    <div>
                        <i class='bx bx-building nav_icon'></i>
                        <span class="nav_name">Departments</span>
                    </div>
                    <i class='bx bx-chevron-down nav_arrow_icon small'></i>
                </button>

                <ul class="collapse list-unstyled ps-4 ms-2 border-start" id="departmentSubmenu">
                    @role('super-admin')
                    <li class="py-1">
                        <a href="{{ route('admin.department.create') }}"
                            class="nav_link text-decoration-none py-1 small">Add</a>
                    </li>
                    <li class="py-1">
                        <a href="{{ route('admin.department.index') }}"
                            class="nav_link text-decoration-none py-1 small">List</a>
                    </li>
                    <li class="py-1">
                        <a href="{{ route('admin.department.budget.index') }}"
                            class="nav_link text-decoration-none py-1 small">Budgets</a>
                    </li>
                    @endrole
                </ul>

                <button type="button"
                    class="nav_link d-flex justify-content-between align-items-center w-100 border-0 bg-transparent"
                    data-bs-toggle="collapse" data-bs-target="#userSubmenu" aria-expanded="false"
                    aria-controls="userSubmenu">
                    <div>
                        <i class='bx bx-group nav_icon'></i>
                        <span class="nav_name">Users</span>
                    </div>
                    <i class='bx bx-chevron-down nav_arrow_icon small'></i>
                </button>

                <ul class="collapse list-unstyled ps-4 ms-2 border-start" id="userSubmenu">
                    @role('super-admin')
                    <li class="py-1">
                        <a href="{{ route('admin.user.create') }}"
                            class="nav_link text-decoration-none py-1 small">Add</a>
                    </li>
                    @endrole
                    <li class="py-1">
                        <a href="{{ route('admin.user.index') }}"
                            class="nav_link text-decoration-none py-1 small">List</a>
                    </li>
                </ul>

                {{-- <a href="#" class="nav_link">
                    <i class='bx bx-cog nav_icon'></i>
                    <span class="nav_name">Settings</span>
                </a> --}}
            </div>
        </div>

        <a href={{ route('logout') }} class="nav_link">
            <i class='bx bx-log-out nav_icon'></i>
            <span class="nav_name">SignOut</span>
        </a>
    </nav>
</div>