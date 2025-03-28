    @extends('index')
    @section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="w-100" src="img/carousel-1.jpg" alt="Image" />
              <div class="carousel-caption">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                      <h5
                        class="text-light text-uppercase mb-3 animated slideInDown"
                      >
                        Welcome to Maintera
                      </h5>
                      <h1 class="display-2 text-light mb-3 animated slideInDown">
                        A Making & Maintenance Company
                      </h1>
                      <ol class="breadcrumb mb-4 pb-2">
                        <li class="breadcrumb-item fs-5 text-light">
                          Commercial
                        </li>
                        <li class="breadcrumb-item fs-5 text-light">
                          Residential
                        </li>
                        <li class="breadcrumb-item fs-5 text-light">
                          Industrial
                        </li>
                      </ol>
                      <a href="" class="btn btn-primary py-3 px-5"
                        >More Details</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <img class="w-100" src="img/carousel-2.jpg" alt="Image" />
              <div class="carousel-caption">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                      <h5
                        class="text-light text-uppercase mb-3 animated slideInDown"
                      >
                        Welcome to Maintera
                      </h5>
                      <h1 class="display-2 text-light mb-3 animated slideInDown">
                        Professional Tiling & Painting Services
                      </h1>
                      <ol class="breadcrumb mb-4 pb-2">
                        <li class="breadcrumb-item fs-5 text-light">
                          Commercial
                        </li>
                        <li class="breadcrumb-item fs-5 text-light">
                          Residential
                        </li>
                        <li class="breadcrumb-item fs-5 text-light">
                          Industrial
                        </li>
                      </ol>
                      <a href="" class="btn btn-primary py-3 px-5"
                        >More Details</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#header-carousel"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#header-carousel"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <!-- Carousel End -->
  
      <!-- About Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div
                class="position-relative overflow-hidden ps-5 pt-5 h-100"
                style="min-height: 400px"
              >
                <img
                  class="position-absolute w-100 h-100"
                  src="img/about.jpg"
                  alt=""
                  style="object-fit: cover"
                />
                <div
                  class="position-absolute top-0 start-0 bg-white pe-3 pb-3"
                  style="width: 200px; height: 200px"
                >
                  <div
                    class="d-flex flex-column justify-content-center text-center bg-primary h-100 p-3"
                  >
                    <h1 class="text-white">15</h1>
                    <h2 class="text-white">Years</h2>
                    <h5 class="text-white mb-0">In Service</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="h-100">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                  <h6 class="text-body text-uppercase mb-2">About Us</h6>
                  <h1 class="display-6 mb-0">
                    Professional Maintenance Solutions for Homes & Industries!
                  </h1>
                </div>
                <p>
                  At Maintera, we deliver top-quality maintenance services
                  tailored to your needs. From home repairs to industrial servicing, our team
                  ensures every task is handled with precision and care.
                </p>
                <p class="mb-4">
                  With over 15 years of experience, we are dedicated to maintaining the
                  functionality of your property, ensuring your peace of mind.
                </p>
                <div class="border-top mt-4 pt-4">
                  <div class="row g-4">
                    <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.1s">
                      <i
                        class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                      ></i>
                      <h6 class="mb-0">On-time Services</h6>
                    </div>
                    <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.3s">
                      <i
                        class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                      ></i>
                      <h6 class="mb-0">24/7 Availability</h6>
                    </div>
                    <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.5s">
                      <i
                        class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                      ></i>
                      <h6 class="mb-0">Certified Technicians</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- About End -->
  
      <div class="container">
        <hr>
       </div>
  
      <!-- Features Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-body text-uppercase mb-2">Why Choose Maintera!</h6>
                <h1 class="display-6 mb-0">
                  Our Specializations and Key Features
                </h1>
              </div>
              <p class="mb-5">
                Maintera specializes in providing reliable and cost-effective maintenance services. From urgent repairs to scheduled inspections, we cover a wide range of solutions to keep your home and business running smoothly.
              </p>
              <div class="row gy-5 gx-4">
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">Extensive Range of Services</h6>
                  </div>
                  <span
                    >From plumbing to electrical repairs, we cover it all.</span
                  >
                </div>
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.2s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">15+ Years of Expertise</h6>
                  </div>
                  <span
                    >Serving homes and industries with excellence.</span
                  >
                </div>
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">Thousands of Happy Clients</h6>
                  </div>
                  <span
                    >We take pride in our customer satisfaction.</span
                  >
                </div>
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">Competitive Pricing</h6>
                  </div>
                  <span
                    >Get the best services at affordable prices.</span
                  >
                </div>
              </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
              <div
                class="position-relative overflow-hidden ps-5 pt-5 h-100"
                style="min-height: 400px"
              >
                <img
                  class="position-absolute w-100 h-100"
                  src="img/feature.jpg"
                  alt=""
                  style="object-fit: cover"
                />
                <div
                  class="position-absolute top-0 start-0 bg-white pe-3 pb-3"
                  style="width: 200px; height: 200px"
                >
                  <div
                    class="d-flex flex-column justify-content-center text-center bg-primary h-100 p-3"
                  >
                    <h1 class="text-white">15</h1>
                    <h2 class="text-white">Years</h2>
                    <h5 class="text-white mb-0">Experience</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Features End -->

      <div class="container">
        <hr>
       </div>
      <!-- Service Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="border-start border-5 border-primary ps-4">
                {{-- <h6 class="text-body text-uppercase mb-2">Our Services</h6> --}}
                <h1 class="display-6 mb-0">
                  Services
                </h1>
              </div>
            </div>
    
          </div>
          <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="img/service-1.jpg" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Plumbing Services</h5>
                  <p>
                    Our professional plumbers handle all types of pipe and water-related
                    issues, ensuring your home systems are in perfect working order.
                  </p>
                  <a class="small" href="">READ MORE<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
              </div>
            </div>
          
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="img/service-2.jpg" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Electrical Services</h5>
                  <p>
                    Certified electricians ready to install, repair, and maintain your
                    electrical systems safely and efficiently.
                  </p>
                  <a class="small" href="">READ MORE<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
              </div>
            </div>
          
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="img/service-3.jpg" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Painting & Renovation</h5>
                  <p>
                    From small touch-ups to full renovations, we transform your spaces
                    with precision and care.
                  </p>
                  <a class="small" href="">READ MORE<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
              </div>
            </div>
          
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="img/service-4.jpg" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">AC Installation & Repair</h5>
                  <p>
                    Keep your home cool and comfortable with our AC installation and
                    maintenance services, done by qualified technicians.
                  </p>
                  <a class="small" href="">READ MORE<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
              </div>
            </div>
          
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="img/service-5.jpg" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Tiling & Flooring</h5>
                  <p>
                    Our expert team ensures the perfect installation of tiles and
                    flooring, bringing durability and style to your space.
                  </p>
                  <a class="small" href="">READ MORE<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
              </div>
            </div>
          
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="img/service-6.jpg" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Interior Design</h5>
                  <p>
                    Create beautiful and functional spaces with our professional interior
                    design services tailored to your needs.
                  </p>
                  <a class="small" href="{{ route('subservices') }}">READ MORE<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <!-- Service End -->
  
      <!-- Appointment Start -->
      {{-- <div
        class="container-fluid appointment my-5 py-5 wow fadeIn"
        data-wow-delay="0.1s"
      >
        <div class="container py-5">
          <div class="row g-5">
            <div class="col-lg-5 col-md-6 wow fadeIn" data-wow-delay="0.3s">
              <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-white text-uppercase mb-2">Appointment</h6>
                <h1 class="display-6 text-white mb-0">
                  A Company Involved In Service And Maintenance
                </h1>
              </div>
              <p class="text-white mb-0">
                Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu
                diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet
                lorem sit clita duo justo magna dolore erat amet
              </p>
            </div>
            <div class="col-lg-7 col-md-6 wow fadeIn" data-wow-delay="0.5s">
              <form>
                <div class="row g-3">
                  <div class="col-sm-6">
                    <div class="form-floating">
                      <input
                        type="text"
                        class="form-control bg-dark border-0"
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
                        class="form-control bg-dark border-0"
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
                        class="form-control bg-dark border-0"
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
                        class="form-control bg-dark border-0"
                        id="cage"
                        placeholder="Child Age"
                      />
                      <label for="cage">Service Type</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating">
                      <textarea
                        class="form-control bg-dark border-0"
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
      </div> --}}
      <!-- Appointment End -->
 <div class="container">
  <hr>
 </div>
   <!-- Team Start -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5 align-items-end mb-5">
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="border-start border-5 border-primary ps-4">
          <h6 class="text-body text-uppercase mb-2">Our Team</h6>
          <h1 class="display-6 mb-0">Expert Technicians</h1>
        </div>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="team-item position-relative">
          <img class="img-fluid" src="img/team-1.jpg" alt="" />
          <div class="team-text bg-white p-4">
            <h5>John Smith</h5>
            <span>Electrical Engineer</span>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
        <div class="team-item position-relative">
          <img class="img-fluid" src="img/team-2.jpg" alt="" />
          <div class="team-text bg-white p-4">
            <h5>Sarah Johnson</h5>
            <span>Plumbing Specialist</span>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
        <div class="team-item position-relative">
          <img class="img-fluid" src="img/team-3.jpg" alt="" />
          <div class="team-text bg-white p-4">
            <h5>Michael Lee</h5>
            <span>Home Renovation Expert</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Team End -->

<!-- Testimonial Start -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="border-start border-5 border-primary ps-4 mb-5">
          <h6 class="text-body text-uppercase mb-2">Testimonial</h6>
          <h1 class="display-6 mb-0">What Our Clients Say!</h1>
        </div>
        <p class="mb-4">
          Our clients trust us for their home maintenance needs. Here’s what
          they say about our services.
        </p>
        <div class="row g-4">
          <div class="col-sm-6">
            <div class="d-flex align-items-center mb-2">
              <i class="fa fa-users fa-2x text-primary flex-shrink-0"></i>
              <h1 class="ms-3 mb-0">200+</h1>
            </div>
            <h5 class="mb-0">Satisfied Clients</h5>
          </div>
          <div class="col-sm-6">
            <div class="d-flex align-items-center mb-2">
              <i class="fa fa-check fa-2x text-primary flex-shrink-0"></i>
              <h1 class="ms-3 mb-0">300+</h1>
            </div>
            <h5 class="mb-0">Completed Projects</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.5s">
        <div class="owl-carousel testimonial-carousel">
          <div class="testimonial-item">
            <img
              class="img-fluid mb-4"
              src="img/testimonial-1.jpg"
              alt="Client Testimonial"
            />
            <p class="fs-5">
              "Maintera provided exceptional service! Their team was
              professional and finished the job ahead of schedule."
            </p>
            <div
              class="bg-primary mb-3"
              style="width: 60px; height: 5px"
            ></div>
            <h5>Emily Watson</h5>
            <span>Homeowner</span>
          </div>
          <div class="testimonial-item">
            <img
              class="img-fluid mb-4"
              src="img/testimonial-2.jpg"
              alt="Client Testimonial"
            />
            <p class="fs-5">
              "I highly recommend Maintera for any home repairs. Their attention
              to detail and quality of work is unmatched."
            </p>
            <div
              class="bg-primary mb-3"
              style="width: 60px; height: 5px"
            ></div>
            <h5>James Anderson</h5>
            <span>Business Owner</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Testimonial End -->

      @endsection