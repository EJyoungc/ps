<div>
    <aside class="main-sidebar sidebar-dark-primary bg-purple elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">Procurement System</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/'.Auth::user()->profile_photo_path) : asset('face-0.jpg') }}"
                        width="60" height="60" class="rounded-circle" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('profile.show') }}" class="d-block text-capitalize">{{ Auth::user()->name }}</a>
                    <span class="badge bg-success ">{{ Auth::user()->email }}</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @role('admin')
                    <li class="nav-header">ADMINISTRATION</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.departments') }}" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Departments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.notifications') }}" class="nav-link">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    @endrole

                    @role('procurement_officer')
                    <li class="nav-header">PROCUREMENT</li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.suppliers') }}" class="nav-link">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Suppliers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.requests') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>Purchase Requests</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.tenders') }}" class="nav-link">
                            <i class="nav-icon fas fa-gavel"></i>
                            <p>Tenders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.bids') }}" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Bids</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.orders') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-contract"></i>
                            <p>Purchase Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.contracts') }}" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Contracts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.shipments') }}" class="nav-link">
                            <i class="nav-icon fas fa-shipping-fast"></i>
                            <p>Shipments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement.inventory') }}" class="nav-link">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Inventory</p>
                        </a>
                    </li>
                    @endrole

                    @role('department_head')
                    <li class="nav-header">DEPARTMENT</li>
                    <li class="nav-item">
                        <a href="{{ route('department.requests') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-import"></i>
                            <p>Purchase Requests</p>
                        </a>
                    </li>
                    @endrole

                    @role('supplier')
                    <li class="nav-header">SUPPLIER PORTAL</li>
                    <li class="nav-item">
                        <a href="{{ route('supplier.bids') }}" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>My Bids</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('supplier.orders') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-purchase"></i>
                            <p>Purchase Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('supplier.invoices') }}" class="nav-link">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Invoices</p>
                        </a>
                    </li>
                    @endrole

                    @role('finance_officer')
                    <li class="nav-header">FINANCE</li>
                    <li class="nav-item">
                        <a href="{{ route('finance.invoices') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Invoice Matching</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.payments') }}" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Payments</p>
                        </a>
                    </li>
                    @endrole

                    @hasanyrole('procurement_officer|department_head|finance_officer')
                    <li class="nav-header">REPORTS</li>
                    <li class="nav-item">
                        <a href="{{ route('reports') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Analytics & Reports</p>
                        </a>
                    </li>
                    @endhasanyrole

                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout').submit();"
                           class="nav-link">
                            <i class="nav-icon fas fa-door-open text-danger"></i>
                            <p class="text-danger">Logout</p>
                        </a>
                        <form id="logout" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</div>
