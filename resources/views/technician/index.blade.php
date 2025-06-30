<!DOCTYPE html>
<html lang="en">

  <head>
    @include('technician.partials.head')
    <title>Homepage | Maintera - Technicians 5 Admin Dashboard Template</title>
  </head>

  <body>
   
    <div id="db-wrapper">
      <!-- navbar vertical -->
      @include('technician/partials/navbar-vertical')
       <!-- Page content -->
      <div id="page-content">
        @include('technician/partials/header')
        <!-- Container fluid -->
        <div class="pt-10 pb-21"></div>
        <div class="container-fluid mt-n22 ml-0">
            @if(!auth()->user()->technicianProfile && !request()->routeIs('technician.editprofile'))
                @if(request()->routeIs('technician.orders.requests','technician.orders.pending','technician.orders.completed'))
                    <div class="alert alert-warning alert-dismissible fade show mx-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fe fe-alert-triangle fs-3 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="alert-heading mb-1">Profile Incomplete!</h4>
                                <p class="mb-0">Please complete your profile to view Orders. <a href="{{ route('technician.editprofile') }}" class="alert-link">Click here to complete your profile</a>.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning alert-dismissible fade show mx-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fe fe-alert-triangle fs-3 me-2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="alert-heading mb-1">Profile Incomplete!</h4>
                                <p class="mb-0">Please complete your profile to Activate your Account. <a href="{{ route('technician.editprofile') }}" class="alert-link">Click here to complete your profile</a>.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            @endif
            @yield('content')
        </div>
      </div>
    </div>

    <!-- Scripts -->
    @include("technician/partials/scripts ")
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert session handler -->
    <x-alerts.sweet-alert />
    <x-toast-messages />

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
  </body>

</html>