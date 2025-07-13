@extends('technician.index')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Order Requests Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-inbox fa-3x mb-3 text-primary-soft"></i>
                        <h5 class="card-title text-dark font-weight-bold">Order Requests</h5>
                        <p class="card-text text-muted">You have {{ $orderRequests }} order requests pending.</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-primary-soft" style="width: {{ $orderRequests }}%;" role="progressbar" aria-valuenow="{{ $orderRequests }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="{{ route('technician.orders.requests') }}" class="btn btn-primary-soft btn-lg">Order Requests</a>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3 text-warning-soft"></i>
                        <h5 class="card-title text-dark font-weight-bold">Pending Orders</h5>
                        <p class="card-text text-muted">You have {{ $pendingOrders }} orders still pending.</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-warning-soft" style="width: {{ $pendingOrders }}%;" role="progressbar" aria-valuenow="{{ $pendingOrders }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="{{ route('technician.orders.pending') }}" class="btn btn-warning-soft btn-lg">Pending Orders</a>
                    </div>
                </div>
            </div>

            <!-- Completed Orders Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-lg hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success-soft"></i>
                        <h5 class="card-title text-dark font-weight-bold">Completed Orders</h5>
                        <p class="card-text text-muted">You have completed {{ $completedOrders }} orders.</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success-soft" style="width: {{ $completedOrders }}%;" role="progressbar" aria-valuenow="{{ $completedOrders }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="{{ route('technician.orders.completed') }}" class="btn btn-success-soft btn-lg">Completed Orders</a>
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
            border-radius: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(44, 62, 80, 0.15);
        }

        .hover-shadow {
            transition: box-shadow 0.3s ease;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .progress-bar {
            transition: width 0.5s ease;
            border-radius: 10px;
        }

        /* Professional Theme Colors */
        .text-primary-soft {
            color: #2c3e50 !important;
        }

        .text-warning-soft {
            color: #e67e22 !important;
        }

        .text-success-soft {
            color: #27ae60 !important;
        }

        .bg-primary-soft {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%) !important;
        }

        .bg-warning-soft {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%) !important;
        }

        .bg-success-soft {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%) !important;
        }

        /* Professional Button Styles */
        .btn-primary-soft {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.2) !important;
        }

        .btn-primary-soft:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3) !important;
            color: white !important;
        }

        .btn-warning-soft {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(230, 126, 34, 0.2) !important;
        }

        .btn-warning-soft:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(230, 126, 34, 0.3) !important;
            color: white !important;
        }

        .btn-success-soft {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(39, 174, 96, 0.2) !important;
        }

        .btn-success-soft:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3) !important;
            color: white !important;
        }
    </style>

