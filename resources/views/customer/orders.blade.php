@extends('index')

@section('content')
<style>
    .orders-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 20px 0;
    }
    
    .page-header {
        background: #FDA12B;
        color: white;
        padding: 20px;
    }
    
    .order-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        background: white;
    }
    
    .order-card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .order-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0;
    }
    
    .order-body {
        padding: 20px;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending {
        background: #fff8e1;
        color: #f57c00;
    }
    
    .status-accepted {
        background: #e3f2fd;
        color: #1565c0;
    }
    
    .status-completed {
        background: #e8f5e8;
        color: #2e7d32;
    }
    
    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }
    
    .chat-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        color: white;
        padding: 8px 16px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .chat-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .technician-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="orders-container">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">My Orders</h4>
                            <p class="mb-0 opacity-75">Track and manage your service orders</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-dark px-3 py-2" style="font-size: 0.9rem;">
                                {{ count($orders) }} Orders
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="p-4">
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <div class="order-card">
                            <div class="order-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Order #{{ $order->id }}</h6>
                                        <small class="text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        @if($order->technician_id && in_array($order->status, ['pending', 'accepted', 'in_progress']))
                                            <a href="{{ route('customer.chat.show', $order) }}" class="chat-btn">
                                                <i class="fas fa-comments me-1"></i> Chat
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="order-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="mb-2">Service Details</h6>
                                        <p class="mb-1"><strong>Service:</strong> {{ $order->subcategory->name ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Category:</strong> {{ $order->category->name ?? 'N/A' }}</p>
                                        @if($order->description)
                                            <p class="mb-1"><strong>Description:</strong> {{ $order->description }}</p>
                                        @endif
                                        @if($order->status === 'cancelled' && $order->cancellation_reason)
                                            <div class="alert alert-danger mt-2 mb-2">
                                                <strong>Cancellation Reason:</strong><br>
                                                {{ $order->cancellation_reason }}
                                            </div>
                                        @endif
                                        <p class="mb-1"><strong>Address:</strong> {{ $order->street_address }}, {{ $order->city }}</p>
                                        @if($order->scheduled_at)
                                            <p class="mb-1"><strong>Scheduled:</strong> {{ $order->scheduled_at->format('M d, Y h:i A') }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-4">
                                        @if($order->technician_id)
                                            <h6 class="mb-2">Assigned Technician</h6>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="technician-avatar me-2">
                                                    {{ strtoupper(substr($order->technician->name ?? 'T', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-bold">{{ $order->technician->name ?? 'N/A' }}</p>
                                                    <small class="text-muted">{{ $order->technician->email ?? '' }}</small>
                                                </div>
                                            </div>
                                            @if($order->fareOffers->count() > 0)
                                                <p class="mb-1"><strong>Accepted Price:</strong> ${{ $order->fareOffers->first()->proposed_price ?? 'N/A' }}</p>
                                            @endif
                                        @else
                                            <h6 class="mb-2">Fare Offers</h6>
                                            @if($order->fareOffers->count() > 0)
                                                <p class="mb-1">You have {{ $order->fareOffers->count() }} pending offer(s)</p>
                                                <a href="{{ route('customer.order.fares', $order) }}" class="btn btn-outline-primary btn-sm">
                                                    View Offers
                                                </a>
                                            @else
                                                <p class="mb-1 text-muted">No offers received yet</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                @if($order->technician_id && in_array($order->status, ['pending', 'accepted', 'in_progress']))
                                    <div class="mt-3 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Ready to communicate?</h6>
                                                <p class="mb-0 text-muted">Chat with your technician to discuss service details</p>
                                            </div>
                                            <a href="{{ route('customer.chat.show', $order) }}" class="chat-btn">
                                                <i class="fas fa-comments me-1"></i> Open Chat
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <h5>No orders yet</h5>
                            <p>You haven't placed any service orders yet.</p>
                            <a href="{{ route('customer.services') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Book a Service
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 