
@extends('index')
@section('content')

    <!-- Page Header Start -->
    <div
      class="container-fluid page-header py-5 mb-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4">
          Services
        </h1>
        <nav aria-label="breadcrumb animated slideInDown">
          <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item">
              <a class="text-white" href="#">Home</a>
            </li>
            <li class="breadcrumb-item">
              <a class="text-white" href="#">Pages</a>
            </li>
            <li class="breadcrumb-item text-primary active" aria-current="page">
              Service
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
      <div class="container">
        <!-- Heading -->
        <div class="row g-5 align-items-end mb-5">
          <div class="col-lg-6">
            <div class="border-start border-5 border-primary ps-4">
              <h6 class="text-body text-uppercase mb-2">Our Services</h6>
              <h1 class="display-6 mb-0">Selected Service: <span id="selected-service-name">Service Name</span></h1>
            </div>
          </div>
        </div>



        <!-- Sub-services grid -->
        <div class="row g-4">
          <!-- Sub-service 1 -->
          <div class="col-lg-4 col-md-6">
            <div class="team-item position-relative">
               <img class="img-fluid" src="img/service-5.jpg" alt="" />
            <div class="service-text position-relative text-center h-100 p-4">
              <h5 class="mb-3">Tiling & Flooring</h5>
              <p>
                Our expert team ensures the perfect installation of tiles and
                flooring, bringing durability and style to your space.
              </p>
                <a href="{{ route('booking') }}" class="btn btn-primary mt-3">Book Now</a>

              </div>
            </div>
          </div>

          <!-- Sub-service 2 -->
          <div class="col-lg-4 col-md-6">
            <div class="team-item position-relative">
              <img class="img-fluid" src="img/sub-service-2.jpg" alt="" />
              <div class="team-text bg-white p-4">
                <h5>Sub Service 2</h5>
                <p>Description of sub-service 2 goes here. This service covers...</p>
                <a href="{{ route('booking') }}" class="btn btn-primary mt-3">Book Now</a>

              </div>
            </div>
          </div>

          <!-- Sub-service 3 -->
          <div class="col-lg-4 col-md-6">
            <div class="team-item position-relative">
              <img class="img-fluid" src="img/sub-service-3.jpg" alt="" />
              <div class="team-text bg-white p-4">
                <h5>Sub Service 3</h5>
                <p>Description of sub-service 3 goes here. This service covers...</p>
                <a href="{{ route('booking') }}" class="btn btn-primary mt-3">Book Now</a>

              </div>
            </div>
          </div>

          <!-- Additional sub-services -->
          <div class="col-lg-4 col-md-6">
            <div class="team-item position-relative">
              <img class="img-fluid" src="img/sub-service-4.jpg" alt="" />
              <div class="team-text bg-white p-4">
                <h5>Sub Service 4</h5>
                <p>Description of sub-service 4 goes here. This service covers...</p>
                <a href="{{ route('booking') }}" class="btn btn-primary mt-3">Book Now</a>

              </div>
            </div>
          </div>

          <!-- Add more sub-services as needed -->
        </div>
      </div>
    </div>

    <style>
      .team-item {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }

      .team-item:hover {
        transform: translateY(-10px);
      }

      .team-text {
        text-align: center;
      }

      .btn-primary {
        border-radius: 50px;
      }

      .team-text img {
        max-height: 200px;
        object-fit: cover;
      }
    </style>

@endsection
