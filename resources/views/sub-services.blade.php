@extends('index')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-4">
                Services in {{ $category->name }}
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-white" href="">Services</a>
                    </li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">
                        {{ $category->name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-end mb-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="border-start border-5 border-primary ps-4">
                        <h6 class="text-body text-uppercase mb-2">Our Services</h6>
                        <h1 class="display-6 mb-0">
                            Services in {{ $category->name }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item bg-light overflow-hidden h-100">
                            <img class="img-fluid" src="{{ asset('path/to/your/image.jpg') }}" alt="{{ $service->name }}" />
                            <div class="service-text position-relative text-center h-100 p-4">
                                <h5 class="mb-3">{{ $service->name }}</h5>
                                <p>
                                    {{ Str::limit($service->description, 100) }}
                                </p>
                                <a class="small" href="{{ route('service.booking', $service->id) }}">
                                    READ MORE <i class="fa fa-arrow-right ms-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Service End -->

@endsection
