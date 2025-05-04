@extends('technician.index')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Order Requests Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-inbox fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title text-dark font-weight-bold">Order Requests</h5>
                        <p class="card-text text-muted">You have {{ $orderRequests }} order requests pending.</p>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width: {{ $orderRequests }}%;" role="progressbar" aria-valuenow="{{ $orderRequests }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="{{ route('technician.orders.requests') }}" class="btn btn-primary btn-lg">Order Requests</a>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3 text-warning"></i>
                        <h5 class="card-title text-dark font-weight-bold">Pending Orders</h5>
                        <p class="card-text text-muted">You have {{ $pendingOrders }} orders still pending.</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-warning" style="width: {{ $pendingOrders }}%;" role="progressbar" aria-valuenow="{{ $pendingOrders }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="{{ route('technician.orders.pending') }}" class="btn btn-warning btn-lg">Pending Orders</a>
                    </div>
                </div>
            </div>

            <!-- Completed Orders Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <h5 class="card-title text-dark font-weight-bold">Completed Orders</h5>
                        <p class="card-text text-muted">You have completed {{ $completedOrders }} orders.</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: {{ $completedOrders }}%;" role="progressbar" aria-valuenow="{{ $completedOrders }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="{{ route('technician.orders.completed') }}" class="btn btn-success btn-lg">Completed Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


    <style>
        /* Custom styles for the cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .hover-shadow {
            transition: box-shadow 0.3s ease;
        }

        .progress {
            height: 8px;
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

       
    </style>

