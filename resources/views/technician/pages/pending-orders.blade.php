@extends('technician.index')

@section('content')
<style>
    body {
        background: #f9fafb;
    }

    .order-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .order-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .order-desc {
        font-size: 0.95rem;
        color: #4b5563;
    }

    .order-location {
        font-size: 0.75rem;
        font-weight: 600;
        background: #e0f2fe;
        color: #0369a1;
        padding: 6px 14px;
        border-radius: 9999px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .view-btn {
        font-size: 0.85rem;
        padding: 8px 16px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(to right, #facc15, #eab308);
        color: #1f2937;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(234, 179, 8, 0.2);
    }

    .view-btn:hover {
        background: linear-gradient(to right, #eab308, #ca8a04);
        box-shadow: 0 6px 15px rgba(202, 138, 4, 0.3);
    }

    .order-badge {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 0.75rem;
        font-weight: bold;
        padding: 6px 14px;
        border-radius: 0 16px 0 16px;
        color: white;
    }

    .badge-pending {
        background: #facc15;
        color: #1f2937;
    }

    h2 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1f2937;
        margin-bottom: 2rem;
    }
</style>

<div class="row">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>⏳ Pending Orders</h2>
        <span class="badge bg-success text-white px-3 py-2" style="border-radius: 12px; font-size: 0.9rem;">
            {{ count($pending_orders) }} Orders Pending
        </span>
    </div>

    @foreach ($pending_orders as $order)
    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge badge-new">New</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">{{ $order->order->subcategory->name }}</div>
                    <div class="order-desc">{{ $order->order->description }}</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location">{{ $order->order->area . $order->order->city }}</div>

                    <form method="POST" action="{{ route('technician.order.view') }}">
                        @csrf
                        <input type="hidden" name="subcategory_name" value="{{ $order->order->subcategory->name }}">
                        <input type="hidden" name="description" value="{{ $order->order->description }}">
                        <input type="hidden" name="area" value="{{ $order->order->area }}">
                        <input type="hidden" name="order_id" value="{{ $order->order->id }}">
                        <input type="hidden" name="city" value="{{ $order->order->city }}">
                        <input type="hidden" name="customer_name" value="{{ $order->order->customer->name }}">
                        <input type="hidden" name="email" value="{{ $order->order->customer->email }}">
                        <input type="hidden" name="phone" value="{{ $order->order->customer->phone }}">
                        <input type="hidden" name="address" value="{{ $order->order->street_address }}">
                        <input type="hidden" name="status" value="{{ $order->order->status }}">
                        <input type="hidden" name="route" value="{{ route('technician.orders.pending') }}">
                        
                        <button type="submit" class="view-btn">View Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

</div>
@endsection
