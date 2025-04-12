<!DOCTYPE html>
<html lang="en">

  <head>
    @include('technician.partials.head')
    <title>Homepage | Dash Ui - Bootstrap 5 Admin Dashboard Template</title>
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


  </body>

</html>