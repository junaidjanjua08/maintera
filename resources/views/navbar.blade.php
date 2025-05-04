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