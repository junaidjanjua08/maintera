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
        @forelse(Auth::user()->notifications->take(20) as $notification)
          @if($notification->type === 'App\\Notifications\\TechnicianFareOffer')
            @php
              $orderId = $notification->data['order_id'] ?? null;
            @endphp
            @if($orderId && !in_array($orderId, $acceptedOrderIds))
              <div class="dropdown-item border-bottom small">
                <span class="fw-bold">Fare Offer (Pending):</span> {{ $notification->data['message'] ?? '' }}<br>
                <span>Price: PKR {{ $notification->data['proposed_price'] ?? '' }}</span><br>
                <a href="{{ route('customer.order.fares', $orderId) }}" class="text-primary">View Offers</a>
                <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
              </div>
            @endif
          @else
            <div class="dropdown-item border-bottom small">
              {{ $notification->data['message'] ?? 'Notification' }}
              <div class="text-muted mt-1" style="font-size: 0.8em;">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
          @endif
        @empty
          <div class="dropdown-item text-muted">No notifications</div>
        @endforelse
      </div>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li class="text-center py-2"><a href="{{ route('customer.order.fares', Auth::user()->order->last()->id ?? 0) }}" class="text-primary">View All</a></li>
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
          <a class="dropdown-item" href="{{ route('profile.edit')}}">Profile</a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
          </form>
      </div>
  </li>
  
      @endif





      


  </div>
</div>
</nav>