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
        <div class=" pt-10 pb-21"></div>
        <div class="container-fluid mt-n22 ml-0">
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


  </body>

</html>