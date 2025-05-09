<!DOCTYPE html>
<html lang="en">

  <head>
     @include('technician.partials.head')
    <title>404 error | Dash Ui - Bootstrap 5 Admin Dashboard Template </title>
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
            <h1 class="display-4 fw-bold">Oops! the page not found.</h1>
            <p class="mb-4">Or simply leverage the expertise of our consultation
              team.</p>
              <!-- button -->
            <a href="../index.html" class="btn btn-primary">Go Home</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
   @include('technician.partials.scripts')
  </body>

</html>