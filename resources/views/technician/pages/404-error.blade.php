<!DOCTYPE html>
<html lang="en">

  <head>
     @include('technician.partials.head')
    <title>404 error | Maintera - Technicians 5 Admin Dashboard Template </title>
  </head>

  <body>
    <!-- Error page -->
    <div class="container min-vh-100 d-flex justify-content-center
      align-items-center">
      <!-- row -->
      <div class="row">
        <!-- col -->
        <div class="col-12">
          <!-- content -->
          <div class="text-center">
            <div class="mb-3">
              <!-- img -->
              <img src="../assets/images/error/404-error-img.png" alt=""
                class="img-fluid">
            </div>
            <!-- text -->
            <h1 class="display-4 fw-bold">The page is in Development Process</h1>
            <p class="mb-4">Or simply leverage the expertise of our consultation
              team.</p>
              <!-- button -->
            <a href="{{ route('technician.dashboard') }}" class="btn btn-primary">Go Home</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
   @include('technician.partials.scripts')
  </body>

</html>