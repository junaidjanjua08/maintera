@extends('index')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Checkout</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <h5>Order Summary</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Order ID:</strong> {{ $order['id'] ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Amount:</strong> Rs. {{ $order['amount'] ?? 'N/A' }}</li>
                        <!-- Add more order details as needed -->
                    </ul>

                    <form action="{{ route('payment.easypaisa') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            Pay with Easypaisa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 