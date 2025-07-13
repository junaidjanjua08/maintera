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
        text-align: center;
    }

    .page-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-card {
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

    .order-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .order-info h4 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .order-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .order-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .fare-summary {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-left: 4px solid #667eea;
    }

    .fare-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .fare-stat {
        text-align: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 10px;
    }

    .fare-stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .fare-stat-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .best-offer {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        border-left: 4px solid #28a745;
    }

    .best-offer-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .best-offer-title {
        font-weight: 600;
        color: #155724;
        margin: 0;
    }

    .best-offer-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #155724;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-view-fares {
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

    .btn-view-fares:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-view-order {
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

    .btn-view-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        font-size: 5rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .empty-description {
        color: #6c757d;
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .refresh-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .refresh-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .urgent-badge {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .fare-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="fares-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-dollar-sign"></i>
                Order Fares
                <span class="badge bg-warning fs-6">{{ $ordersWithFares->count() }}</span>
            </h1>
            <p class="text-muted mb-0">Review and accept the best offers from qualified technicians</p>
            
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $ordersWithFares->count() }}</div>
                    <div class="stat-label">Pending Orders</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-number">{{ $ordersWithFares->sum('fare_count') }}</div>
                    <div class="stat-label">Total Offers</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-number">{{ $ordersWithFares->where('best_price', '>', 0)->count() }}</div>
                    <div class="stat-label">Best Prices</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $ordersWithFares->flatMap->fareOffers->unique('technician_id')->count() }}</div>
                    <div class="stat-label">Technicians</div>
                </div>
            </div>
        </div>

        <!-- Orders with Fares -->
        @if($ordersWithFares->count() > 0)
            @foreach($ordersWithFares as $order)
                <div class="order-card">
                    <!-- Order Header -->
                    <div class="order-header">
                        <div class="order-info">
                            <h4>
                                <i class="fas fa-clipboard-list me-2"></i>
                                Order #{{ $order->id }}
                                @if($order->created_at->diffInHours(now()) < 2)
                                    <span class="urgent-badge ms-2">New</span>
                                @endif
                            </h4>
                            <div class="order-meta">
                                <div class="order-meta-item">
                                    <i class="fas fa-tools"></i>
                                    {{ $order->subcategory->name ?? 'Service' }}
                                </div>
                                <div class="order-meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $order->street_address }}
                                </div>
                                <div class="order-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    {{ $order->created_at->format('M d, Y') }}
                                </div>
                                <div class="order-meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ $order->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-status">
                            <span class="badge bg-warning fs-6">Pending Offers</span>
                        </div>
                    </div>

                    <!-- Order Description -->
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Description:</h6>
                        <p class="mb-0">{{ $order->description }}</p>
                    </div>

                    <!-- Fare Summary -->
                    <div class="fare-summary">
                        <h6 class="mb-3">
                            <i class="fas fa-chart-bar me-2"></i>
                            Fare Offers Summary
                        </h6>
                        
                        <div class="fare-stats">
                            <div class="fare-stat">
                                <div class="fare-stat-number">{{ $order->fare_count }}</div>
                                <div class="fare-stat-label">Total Offers</div>
                            </div>
                            
                            <div class="fare-stat">
                                <div class="fare-stat-number">PKR {{ number_format($order->best_price) }}</div>
                                <div class="fare-stat-label">Best Price</div>
                            </div>
                            
                            <div class="fare-stat">
                                <div class="fare-stat-number">PKR {{ number_format($order->fareOffers->max('proposed_price')) }}</div>
                                <div class="fare-stat-label">Highest Price</div>
                            </div>
                            
                            <div class="fare-stat">
                                <div class="fare-stat-number">{{ $order->fareOffers->unique('technician_id')->count() }}</div>
                                <div class="fare-stat-label">Technicians</div>
                            </div>
                        </div>

                        <!-- Best Offer Highlight -->
                        @if($order->lowest_fare)
                            <div class="best-offer">
                                <div class="best-offer-header">
                                    <i class="fas fa-trophy"></i>
                                    <h6 class="best-offer-title mb-0">Best Offer</h6>
                                </div>
                                <div class="best-offer-price">
                                    PKR {{ number_format($order->lowest_fare->proposed_price) }}
                                </div>
                                <small class="text-muted">
                                    by {{ $order->lowest_fare->technician->name }}
                                    @if($order->lowest_fare->technician->average_rating)
                                        • ⭐ {{ number_format($order->lowest_fare->technician->average_rating, 1) }}
                                    @endif
                                </small>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('customer.order.fares.show', $order->id) }}" class="btn-view-fares">
                            <i class="fas fa-eye"></i>
                            View All Offers ({{ $order->fare_count }})
                        </a>
                        
                        <a href="{{ route('customer.orders') }}" class="btn-view-order">
                            <i class="fas fa-clipboard-list"></i>
                            View Order Details
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="empty-title">No Pending Fares</h3>
                <p class="empty-description">
                    You don't have any pending fare offers at the moment. 
                    When technicians submit offers for your service requests, 
                    they will appear here for you to review and accept.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary">
                        <i class="fas fa-clipboard-list me-2"></i>
                        View My Orders
                    </a>
                    <button class="refresh-btn" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.order-card, .stat-card');
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

// Auto-refresh every 30 seconds
setInterval(function() {
    // Only refresh if user is on this page and not interacting
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 30000);
</script>
@endsection 