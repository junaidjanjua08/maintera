@extends('index')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Fare Offers for Order #{{ $order->id }}</h2>
    @if(session('sweet_success'))
        <div class="alert alert-success">{{ session('sweet_success') }}</div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <h5>Order Details</h5>
            <p><strong>Service:</strong> {{ $order->subcategory_id }}</p>
            <p><strong>Description:</strong> {{ $order->description }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
        </div>
    </div>
    <div class="row">
        @forelse($fareOffers as $offer)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Technician: <a href="{{ route('technician.profile.view', $offer->technician_id) }}">{{ $offer->technician->name ?? 'N/A' }}</a></h5>
                        <p><strong>Proposed Price:</strong> PKR {{ $offer->proposed_price }}</p>
                        <p><strong>Note:</strong> {{ $offer->note }}</p>
                        <form action="{{ route('customer.fare.accept', [$order->id, $offer->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Accept Offer</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No fare offers yet.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection 