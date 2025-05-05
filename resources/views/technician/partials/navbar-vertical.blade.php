<!-- Sidebar -->
<nav class="navbar-vertical navbar bg-light shadow-sm border-end">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand d-flex align-items-center px-4 py-3" href="@@webRoot/index.html">
            <img src="@@webRoot/assets/images/brand/logo/logo.svg" alt="" class="me-2" height="24" />
            <span class="fw-bold text-dark">Technician Panel</span>
        </a>

        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.dashboard') ? 'active' : '' }}"
                   href="{{ route('technician.dashboard') }}">
                    <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Section: Orders -->
            <li class="nav-item mt-3 px-4 text-muted small text-uppercase">Orders</li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.orders.requests') ? 'active' : '' }}"
                   href="{{ route('technician.orders.requests') }}">
                    <i data-feather="inbox" class="nav-icon icon-xs me-2"></i>
                    Order Requests
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.orders.pending') ? 'active' : '' }}"
                   href="{{ route('technician.orders.pending') }}">
                    <i data-feather="clock" class="nav-icon icon-xs me-2"></i>
                    Pending Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.orders.completed') ? 'active' : '' }}"
                   href="{{ route('technician.orders.completed') }}">
                    <i data-feather="check-circle" class="nav-icon icon-xs me-2"></i>
                    Completed Orders
                </a>
            </li>

            <!-- Section: Pages -->
            <li class="nav-item mt-3 px-4 text-muted small text-uppercase">Account</li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.404') ? 'active' : '' }}"
                   href="{{ route('technician.404') }}">
                    <i data-feather="user" class="nav-icon icon-xs me-2"></i>
                    Profile
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.settings') ? 'active' : '' }}"
                   href="{{ route('technician.settings') }}">
                    <i data-feather="settings" class="nav-icon icon-xs me-2"></i>
                    Settings
                </a>
            </li>

            <!-- Layout Section -->
            <li class="nav-item mt-3 px-4 text-muted small text-uppercase">Layout</li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.layouts') ? 'active' : '' }}"
                   href="{{ route('technician.404') }}">
                    <i data-feather="sidebar" class="nav-icon icon-xs me-2"></i>
                    Layouts
                </a>
            </li>

            <!-- Documentation -->
            <li class="nav-item mt-3 px-4 text-muted small text-uppercase">Documentation</li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.docs') ? 'active' : '' }}"
                   href="{{ route('technician.404') }}">
                    <i data-feather="clipboard" class="nav-icon icon-xs me-2"></i>
                    Docs
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .nav-item {
        color: rgb(23, 23, 23) !important;
    }

    .nav-link {
        color: rgb(20, 20, 20) !important;
    }

    .nav-item:hover {
        background-color: #c4c0c0 !important;
        border-radius: 5px !important;
    }

    .active {
        background-color: #007bff !important;
        color: #ffffff !important;
        font-weight: 600 !important; /* Make the active tab more prominent */
        border-left: 4px solid #ffffff !important; /* Adds a left border for extra emphasis */
    }

    li{
        font-size: 20px !important;
    }
</style>
