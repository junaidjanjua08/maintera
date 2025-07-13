<nav
class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0"
>
<a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
  <h1 class="m-0">
    <i class="fa fa-building text-primary me-3"></i>Maintera
  </h1>
</a>
<button
  type="button"
  class="navbar-toggler"
  data-bs-toggle="collapse"
  data-bs-target="#navbarCollapse"
>
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarCollapse">
  <div class="navbar-nav ms-auto py-3 py-lg-0">
    <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
    <a href="{{ route('about-us') }}" class="nav-item nav-link">About Us</a>
    <a href="{{ route('getservices') }}" class="nav-item nav-link">Services</a>
    @if(Auth::user() && Auth::user()->role === 'customer')
        <a href="{{ route('customer.chat.index') }}" class="nav-item nav-link position-relative">
            <i class="fas fa-comments me-1"></i>Chats
            @php $unreadChats = Auth::user()->getUnreadChatMessagesCount(); @endphp
            @if($unreadChats > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; transform: translate(-50%, -50%);">{{ $unreadChats }}</span>
            @endif
        </a>
    @endif
    {{-- <div class="nav-item dropdown">
      <a
        href="#"
        class="nav-link dropdown-toggle"
        data-bs-toggle="dropdown"
        >Pages</a
      >
      <div class="dropdown-menu bg-light m-0">
        <a href="feature.html" class="dropdown-item">Features</a>
        <a href="appointment.html" class="dropdown-item">Appointment</a>
        <a href="team.html" class="dropdown-item">Our Team</a>
        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
        <a href="{{ route('404') }}" class="dropdown-item">404 Page</a>
      </div>
    </div> --}}
    {{-- <a href="{{ route('contact-us') }}" class="nav-item nav-link">Contact Us</a> --}}
    @php
    $user = Auth::user();
@endphp
@if(Auth::user() && Auth::user()->role === 'customer')
<!-- Notification Bell Icon for Customer -->
<li class="nav-item dropdown" style="list-style:none;">
  <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell fa-lg"></i>
    @php $unread = Auth::user()->unreadNotifications->count(); @endphp
    @if($unread > 0)
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unread }}</span>
    @endif
  </a>
  <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notificationDropdown" style="min-width: 320px; max-width: 350px;">
    <li class="dropdown-header bg-light fw-bold py-2 px-3">Notifications</li>
    <li>
      <div style="max-height: 350px; overflow-y: auto;">
        @php
          // Get all order IDs that have an accepted fare offer
          $acceptedOrderIds = \App\Models\FareOffer::where('status', 'accepted')->pluck('order_id')->toArray();
        @endphp
        @forelse(Auth::user()->unreadNotifications->take(20) as $notification)
          @php
            // Handle both array and JSON string data
            $notificationData = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
          @endphp
          @php
            $orderId = $notificationData['order_id'] ?? null;
            $type = $notificationData['type'] ?? '';
            $message = $notificationData['message'] ?? 'Notification';
            $technicianName = $notificationData['technician_name'] ?? '';
            $serviceName = $notificationData['service_name'] ?? '';
            
            // Get icon and color based on notification type
            $icon = match($type) {
                'technician_fare_offer' => 'fas fa-dollar-sign text-success',
                'order_accepted' => 'fas fa-check-circle text-success',
                'order_in_progress' => 'fas fa-tools text-info',
                'order_completed' => 'fas fa-check-double text-success',
                'order_cancelled' => 'fas fa-times-circle text-danger',
                'order_status_updated' => 'fas fa-info-circle text-primary',
                default => 'fas fa-bell text-secondary'
            };
          @endphp
          
          @if($notification->type === 'App\\Notifications\\TechnicianFareOffer')
            @if($orderId && !in_array($orderId, $acceptedOrderIds))
              <div class="dropdown-item border-bottom small notification-dropdown-item" data-notification-id="{{ $notification->id }}">
                <div class="d-flex align-items-start">
                  <i class="{{ $icon }} me-2 mt-1"></i>
                  <div class="flex-grow-1">
                    <span class="fw-bold">Fare Offer:</span> {{ $message }}<br>
                    <span>Price: PKR {{ $notificationData['proposed_price'] ?? '' }}</span><br>
                    <a href="{{ route('customer.order.fares', $orderId) }}" class="text-primary">View Offers</a>
                    <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                  </div>
                </div>
              </div>
            @endif
          @elseif($notification->type === 'App\\Notifications\\OrderAccepted')
            <div class="dropdown-item border-bottom small notification-dropdown-item" data-notification-id="{{ $notification->id }}">
              <div class="d-flex align-items-start">
                <i class="{{ $icon }} me-2 mt-1"></i>
                <div class="flex-grow-1">
                  <span class="fw-bold">Order Accepted:</span> {{ $message }}<br>
                  @if($technicianName)
                    <small class="text-muted">Technician: {{ $technicianName }}</small><br>
                  @endif
                  <a href="{{ route('customer.orders') }}" class="text-primary">View Order</a>
                  <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
              </div>
            </div>
          @elseif($notification->type === 'App\\Notifications\\OrderInProgress')
            <div class="dropdown-item border-bottom small notification-dropdown-item" data-notification-id="{{ $notification->id }}">
              <div class="d-flex align-items-start">
                <i class="{{ $icon }} me-2 mt-1"></i>
                <div class="flex-grow-1">
                  <span class="fw-bold">Work Started:</span> {{ $message }}<br>
                  @if($technicianName)
                    <small class="text-muted">Technician: {{ $technicianName }}</small><br>
                  @endif
                  <a href="{{ route('customer.orders') }}" class="text-primary">View Order</a>
                  <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
              </div>
            </div>
          @elseif($notification->type === 'App\\Notifications\\OrderCompleted')
            <div class="dropdown-item border-bottom small notification-dropdown-item" data-notification-id="{{ $notification->id }}">
              <div class="d-flex align-items-start">
                <i class="{{ $icon }} me-2 mt-1"></i>
                <div class="flex-grow-1">
                  <span class="fw-bold">Order Completed:</span> {{ $message }}<br>
                  @if($technicianName)
                    <small class="text-muted">Technician: {{ $technicianName }}</small><br>
                  @endif
                  <div class="mt-2">
                    <a href="{{ route('customer.orders') }}" class="text-primary me-3">
                      <i class="fas fa-eye me-1"></i>View Order
                    </a>
                    <a href="{{ route('customer.reviews.create', $orderId) }}" class="text-success">
                      <i class="fas fa-star me-1"></i>Rate & Review
                    </a>
                  </div>
                  <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
              </div>
            </div>
          @elseif($notification->type === 'App\\Notifications\\OrderCancelled')
            <div class="dropdown-item border-bottom small notification-dropdown-item" data-notification-id="{{ $notification->id }}">
              <div class="d-flex align-items-start">
                <i class="{{ $icon }} me-2 mt-1"></i>
                <div class="flex-grow-1">
                  <span class="fw-bold">Order Cancelled:</span> {{ $message }}<br>
                  @if($notificationData['reason'])
                    <small class="text-muted">Reason: {{ $notificationData['reason'] }}</small><br>
                  @endif
                  <a href="{{ route('customer.orders') }}" class="text-primary">View Order</a>
                  <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
              </div>
            </div>
          @elseif($notification->type === 'App\\Notifications\\OrderStatusUpdated')
            <div class="dropdown-item border-bottom small notification-dropdown-item" data-notification-id="{{ $notification->id }}">
              <div class="d-flex align-items-start">
                <i class="{{ $icon }} me-2 mt-1"></i>
                <div class="flex-grow-1">
                  <span class="fw-bold">Status Updated:</span> {{ $message }}<br>
                  @if($notificationData['old_status'] && $notificationData['new_status'])
                    <small class="text-muted">{{ ucfirst($notificationData['old_status']) }} → {{ ucfirst($notificationData['new_status']) }}</small><br>
                  @endif
                  <a href="{{ route('customer.orders') }}" class="text-primary">View Order</a>
                  <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
              </div>
            </div>
          @else
            <div class="dropdown-item border-bottom small">
              <div class="d-flex align-items-start">
                <i class="{{ $icon }} me-2 mt-1"></i>
                <div class="flex-grow-1">
                  {{ $message }}
                  <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
              </div>
            </div>
          @endif
        @empty
          <div class="dropdown-item text-muted">No unread notifications</div>
        @endforelse
      </div>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li class="text-center py-2"><a href="{{ route('customer.notifications.index') }}" class="text-primary">View All Notifications</a></li>
  </ul>
</li>
@endif
@if(!Auth::check() || (Auth::check() && $user->role !== 'customer'))
    <a href="{{ Auth::check() && $user->role === 'technician' ? route('technician.dashboard') : route('login', ['role' => 'technician']) }}" class="nav-item nav-link">
        Technician
    </a>
@endif

    @if(Auth::user() && Auth::user()->role === 'customer')
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          | {{ Auth::user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{ route('profile.edit')}}">
              <i class="fas fa-user me-2"></i>Profile
          </a>
          <a class="dropdown-item" href="{{ route('customer.orders')}}">
              <i class="fas fa-clipboard-list me-2"></i>My Orders
          </a>
          <a class="dropdown-item" href="{{ route('customer.order.fares.index')}}">
              <i class="fas fa-dollar-sign me-2"></i>Order Fares
              @php 
                  $pendingFares = \App\Models\FareOffer::whereHas('order', function($query) {
                      $query->where('user_id', Auth::id())->where('status', 'pending');
                  })->where('status', 'pending')->count(); 
              @endphp
              @if($pendingFares > 0)
                  <span class="badge bg-warning ms-2">{{ $pendingFares }}</span>
              @endif
          </a>
          <a class="dropdown-item" href="{{ route('customer.notifications.index')}}">
              <i class="fas fa-bell me-2"></i>Notifications
              @php $unread = Auth::user()->unreadNotifications->count(); @endphp
              @if($unread > 0)
                  <span class="badge bg-danger ms-2">{{ $unread }}</span>
              @endif
          </a>
          <a class="dropdown-item" href="{{ route('customer.chat.index')}}">
              <i class="fas fa-comments me-2"></i>Chats
          </a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">
                  <i class="fas fa-sign-out-alt me-2"></i>Logout
              </button>
          </form>
      </div>
  </li>
  
      @endif





      


  </div>
</div>
</nav>