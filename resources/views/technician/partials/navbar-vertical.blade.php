<!-- Sidebar -->
<nav class="navbar-vertical navbar bg-light shadow-sm border-end">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand d-flex align-items-center px-4 py-3" href="@@webRoot/index.html">
           
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
                <a class="nav-link {{ Route::is('technician.orders.requests') || (session('order_view_source') === 'technician.orders.requests') ? 'active' : '' }}"
                   href="{{ route('technician.orders.requests') }}">
                    <i data-feather="inbox" class="nav-icon icon-xs me-2"></i>
                    Order Requests
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.orders.pending') || (session('order_view_source') === 'technician.orders.pending') ? 'active' : '' }}"
                   href="{{ route('technician.orders.pending') }}">
                    <i data-feather="clock" class="nav-icon icon-xs me-2"></i>
                    Pending Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.orders.completed') || (session('order_view_source') === 'technician.orders.completed') ? 'active' : '' }}"
                   href="{{ route('technician.orders.completed') }}">
                    <i data-feather="check-circle" class="nav-icon icon-xs me-2"></i>
                    Completed Orders
                </a>
            </li>

            <!-- Section: Communication -->
            <li class="nav-item mt-3 px-4 text-muted small text-uppercase">Communication</li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.chat.*') ? 'active' : '' }} position-relative"
                   href="{{ route('technician.chat.index') }}">
                    <i data-feather="message-circle" class="nav-icon icon-xs me-2"></i>
                    Chats
                    @php $unreadChats = Auth::user()->getUnreadChatMessagesCountForTechnician(); @endphp
                    @if($unreadChats > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; transform: translate(-50%, -50%);">{{ $unreadChats }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.notifications.*') ? 'active' : '' }}"
                   href="{{ route('technician.notifications.index') }}">
                    <i data-feather="bell" class="nav-icon icon-xs me-2"></i>
                    Notifications
                </a>
            </li>

            <!-- Section: Pages -->
            <li class="nav-item mt-3 px-4 text-muted small text-uppercase">Account</li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('technician.editprofile') ? 'active' : '' }}"
                   href="{{ route('technician.editprofile') }}">
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

        </ul>
    </div>
</nav>

<style>
    .nav-item {
        color: rgb(23, 23, 23) !important;
    }

    .nav-link {
        color: rgb(20, 20, 20) !important;
        transition: all 0.3s ease !important;
        border-radius: 8px !important;
        margin: 2px 8px !important;
        padding: 12px 16px !important;
    }

    .nav-item:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%) !important;
        border-radius: 8px !important;
        margin: 2px 8px !important;
        transition: all 0.3s ease !important;
    }

    .active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        border-left: 4px solid #ffffff !important;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3) !important;
        border-radius: 8px !important;
        margin: 2px 8px !important;
    }

    li{
        font-size: 20px !important;
    }
</style>
