
@extends('index')
@section('content')

    <!-- Page Header Start -->
    <div
      class="container-fluid page-header py-5 mb-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4">
          Our Services
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
              Our Services
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- Page Header End -->
    @php
    $icons = [
        'Electrical'     => 'fa-bolt',
        'Plumbing'       => 'fa-faucet',
        'AC Repair'      => 'fa-wind',
        'Painting'       => 'fa-paint-roller',
        'Carpentry'      => 'fa-hammer',
        'Cleaning'       => 'fa-broom',
        'Appliance Repair' => 'fa-tools',
        'Pest Control'   => 'fa-bug',
        'Roofing'        => 'fa-house-chimney',
        'Masonry'        => 'fa-bricks',
        'Landscaping'    => 'fa-seedling',
        'Gardening'      => 'fa-leaf',
        'Security'       => 'fa-shield-halved',
        'Flooring'       => 'fa-border-all',
        'Glass Repair'   => 'fa-window-maximize',
        'Locksmith'      => 'fa-key',
        'Moving'         => 'fa-truck-moving',
        'HVAC'           => 'fa-fan',
        'Home Automation'=> 'fa-house-signal',
        'Interior Design'=> 'fa-couch',
        'Furniture Assembly' => 'fa-screwdriver-wrench',
        'Solar Installation' => 'fa-solar-panel',
        'Water Purification' => 'fa-water',
        'Welding'        => 'fa-fire',
        'Computer Repair'=> 'fa-computer',
        'Mobile Repair'  => 'fa-mobile-screen',
        'Laundry'        => 'fa-shirt',
        'CCTV Installation' => 'fa-video',
        'Disinfection'   => 'fa-pump-soap',
        'Window Cleaning'=> 'fa-spray-can-sparkles',
    ];
@endphp
    <!-- Service Start -->
    <div class="container">
      <div class="row g-5 align-items-end mb-5">
          <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="border-start border-5 border-primary ps-4">
                  <h1 class="display-6 mb-0">Services</h1>
              </div>
          </div>
      </div>
     
  
      <div class="row g-4 justify-content-center">
          @foreach($serviceCategories as $category)
        
          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="service-item bg-light overflow-hidden h-100">
                <div class="service-text position-relative text-center h-100 p-4">
                    {{-- Font Awesome Icon --}}
                    <div class="mb-3">
                      <i class="fa {{ $icons[$category->name] ?? 'fa-tools' }} fa-3x text-primary"></i>

                    </div>
        
                    <h5 class="mb-3">{{ $category->name }}</h5>
                    <p>{{ $category->description ?? 'Description for the category goes here.' }}</p>
                    <a class="small" href="{{ route('subservices', ['category' => $category->id]) }}">
                        Book Service <i class="fa fa-arrow-right ms-3"></i>
                    </a>
                </div>
            </div>
        </div>
        
          @endforeach
      </div>
  </div>
    <!-- Service End -->

    <!-- Appointment Start -->
    <div class="container-xxl py-5">
      <div class="container">
        <div class="row g-5">
          <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="border-start border-5 border-primary ps-4 mb-5">
              <h6 class="text-body text-uppercase mb-2">Appointment</h6>
              <h1 class="display-6 mb-0">
                A Company Involved In Service And Maintenance
              </h1>
            </div>
            <p class="mb-0">
              Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu
              diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet
              lorem sit clita duo justo magna dolore erat amet
            </p>
          </div>
          <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
            <form>
              <div class="row g-3">
                <div class="col-sm-6">
                  <div class="form-floating">
                    <input
                      type="text"
                      class="form-control bg-light border-0"
                      id="gname"
                      placeholder="Gurdian Name"
                    />
                    <label for="gname">Your Name</label>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-floating">
                    <input
                      type="email"
                      class="form-control bg-light border-0"
                      
                      id="gmail"
                      placeholder="Gurdian Email"
                    />
                    <label for="gmail">Your Email</label>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-floating">
                    <input
                      type="text"
                      class="form-control bg-light border-0"
                      id="cname"
                      placeholder="Child Name"
                    />
                    <label for="cname">Your Mobile</label>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-floating">
                    <input
                      type="text"
                      class="form-control bg-light border-0"
                      id="cage"
                      placeholder="Child Age"
                    />
                    <label for="cage">Service Type</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea
                      class="form-control bg-light border-0"
                      placeholder="Leave a message here"
                      id="message"
                      style="height: 100px"
                    ></textarea>
                    <label for="message">Message</label>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100 py-3" type="submit">
                    Get Appointment
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Appointment End -->

  @endsection