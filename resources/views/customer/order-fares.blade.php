@extends('index')

@section('content')
<style>
    .fares-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .order-number {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .order-details-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .order-details-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .order-details-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-accepted { background: #d4edda; color: #155724; }
    .status-completed { background: #cce5ff; color: #004085; }
    .status-cancelled { background: #f8d7da; color: #721c24; }

    .chat-alert {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .chat-alert-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .chat-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chat-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .fare-offer-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .fare-offer-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .fare-offer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .technician-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f8f9fa;
    }

    .technician-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .technician-info h5 {
        margin: 0;
        color: #2c3e50;
        font-weight: 700;
    }

    .technician-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.25rem;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .rating-text {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .price-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1rem 0;
        text-align: center;
    }

    .price-amount {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .price-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .offer-note {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin: 1rem 0;
        border-left: 4px solid #667eea;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-profile {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-accept {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-accept:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .btn-reject {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
    }

    .accepted-alert {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .rejected-alert {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .chat-alert-content {
            flex-direction: column;
            align-items: stretch;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .technician-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="fares-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-handshake"></i>
                Fare Offers
                <span class="order-number">#{{ $order->id }}</span>
            </h1>
            <p class="text-muted mb-0">Review and accept offers from qualified technicians</p>
        </div>

        @if(session('sweet_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('sweet_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Chat Alert (if order has technician assigned) -->
        @if($order->technician_id && in_array($order->status, ['pending', 'accepted', 'in_progress']))
            <div class="chat-alert">
                <div class="chat-alert-content">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-comments me-2"></i>
                            Order Connected!
                        </h5>
                        <p class="mb-0 text-muted">You can now chat with your assigned technician</p>
                    </div>
                    <a href="{{ route('customer.chat.show', $order) }}" class="chat-btn">
                        <i class="fas fa-comments"></i>
                        Open Chat
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Order Details Card -->
        <div class="order-details-card">
            <div class="order-details-header">
                <div class="order-details-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h4 class="mb-1">Order Details</h4>
                    <p class="text-muted mb-0">Service request information</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">Service Category</label>
                        <p class="mb-0 fw-bold">{{ $order->subcategory->name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">Status</label>
                        <div>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted">Description</label>
                <p class="mb-0">{{ $order->description }}</p>
            </div>
            
            @if($order->technician_id)
                <div class="mb-3">
                    <label class="form-label text-muted">Assigned Technician</label>
                    <p class="mb-0 fw-bold">{{ $order->technician->name ?? 'N/A' }}</p>
                </div>
            @endif
        </div>
        
        <!-- Fare Offers -->
        <div class="row">
            @forelse($fareOffers as $offer)
                <div class="col-lg-6 mb-4">
                    <div class="fare-offer-card">
                        <!-- Technician Header -->
                        <div class="technician-header">
                            <div class="technician-avatar">
                                {{ strtoupper(substr($offer->technician->name ?? 'T', 0, 1)) }}
                            </div>
                            <div class="technician-info">
                                <h5>{{ $offer->technician->name ?? 'N/A' }}</h5>
                                <div class="technician-rating">
                                    <div class="rating-stars">
                                        @php
                                            $rating = $offer->technician->average_rating ?? 0;
                                            $totalReviews = $offer->technician->total_reviews ?? 0;
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-text">
                                        {{ number_format($rating, 1) }} ({{ $totalReviews }} reviews)
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price Section -->
                        <div class="price-section">
                            <div class="price-amount">PKR {{ number_format($offer->proposed_price) }}</div>
                            <div class="price-label">Proposed Price</div>
                        </div>
                        
                        <!-- Offer Note -->
                        @if($offer->note)
                            <div class="offer-note">
                                <strong><i class="fas fa-comment me-2"></i>Technician's Note:</strong>
                                <p class="mb-0 mt-2">{{ $offer->note }}</p>
                            </div>
                        @endif
                        
                        <!-- Offer Status -->
                        <div class="mb-3">
                            <label class="form-label text-muted">Offer Status</label>
                            <div>
                                <span class="status-badge status-{{ $offer->status }}">
                                    {{ ucfirst($offer->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <!-- View Profile Button -->
                            <a href="{{ route('technician.profile.view', $offer->technician_id) }}" class="btn-profile">
                                <i class="fas fa-user"></i>
                                View Profile & Reviews
                            </a>
                            
                            @if($offer->status === 'pending' && $order->status === 'pending')
                                <form action="{{ route('customer.fare.accept', [$order->id, $offer->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-accept" onclick="return confirm('Are you sure you want to accept this offer?')">
                                        <i class="fas fa-check"></i>
                                        Accept Offer
                                    </button>
                                </form>
                            @elseif($offer->status === 'accepted')
                                <div class="accepted-alert">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Offer Accepted!
                                            </h6>
                                            <p class="mb-0 text-muted">You can now start chatting with your technician</p>
                                        </div>
                                        <a href="{{ route('customer.chat.show', $order) }}" class="chat-btn">
                                            <i class="fas fa-comments"></i>
                                            Chat Now
                                        </a>
                                    </div>
                                </div>
                            @elseif($offer->status === 'rejected')
                                <div class="rejected-alert">
                                    <h6 class="mb-1">
                                        <i class="fas fa-times-circle me-2"></i>
                                        Offer Rejected
                                    </h6>
                                    <p class="mb-0 text-muted">This offer has been rejected</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h4 class="mb-3">No Fare Offers Yet</h4>
                        <p class="text-muted mb-4">
                            Technicians are reviewing your service request. You'll receive offers soon!
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Orders
                            </a>
                            <button class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-sync-alt me-2"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.fare-offer-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Add hover effects
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection 