@extends('index')

@section('content')
<style>
    .fares-detail-container {
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

    .controls-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .controls-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: #2c3e50;
        font-weight: 600;
    }

    .controls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .control-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .control-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .control-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem;
        background: white;
        transition: all 0.3s ease;
    }

    .control-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .comparison-table {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .comparison-table h5 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
    }

    .comparison-table .table {
        margin-bottom: 0;
    }

    .comparison-table .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-align: center;
    }

    .comparison-table .table td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #f8f9fa;
        text-align: center;
        vertical-align: middle;
    }

    .comparison-table .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .best-value {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
        font-weight: 600;
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

    .fare-offer-card.best-price::before {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .fare-offer-card.best-rating::before {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }

    .fare-offer-card.best-experience::before {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
    }

    .badge-container {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 1;
    }

    .offer-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white;
    }

    .badge-best-price {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .badge-best-rating {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }

    .badge-best-experience {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
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
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .technician-info h5 {
        margin: 0;
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .technician-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }

    .technician-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 1rem;
    }

    .rating-text {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .technician-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .technician-stat {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        border-left: 3px solid #667eea;
    }

    .stat-number {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .price-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 2rem;
        margin: 1.5rem 0;
        text-align: center;
        position: relative;
    }

    .price-amount {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .price-label {
        color: #6c757d;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
    }

    .price-comparison {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .price-comp-item {
        text-align: center;
    }

    .price-comp-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .price-comp-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .offer-note {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-left: 4px solid #667eea;
    }

    .note-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: #2c3e50;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn-accept {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 25px;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
    }

    .btn-accept:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .btn-profile {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
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
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
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

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
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

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    @media (max-width: 768px) {
        .technician-header {
            flex-direction: column;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .price-comparison {
            flex-direction: column;
            gap: 1rem;
        }
        
        .technician-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .controls-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="fares-detail-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-dollar-sign"></i>
                Fare Offers
                <span class="order-number">#{{ $order->id }}</span>
            </h1>
            <p class="text-muted mb-0">Compare and select the best offer from qualified technicians</p>
        </div>

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
                        <label class="form-label text-muted">Location</label>
                        <p class="mb-0">{{ $order->street_address }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted">Description</label>
                <p class="mb-0">{{ $order->description }}</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">Created</label>
                        <p class="mb-0">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">Offers Received</label>
                        <p class="mb-0 fw-bold">{{ $order->fareOffers->count() }} offers</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Section -->
        @if($order->fareOffers->count() > 0)
            <div class="controls-section">
                <div class="controls-header">
                    <i class="fas fa-filter"></i>
                    Sort & Filter Offers
                </div>
                <div class="controls-grid">
                    <div class="control-group">
                        <label class="control-label">Sort By</label>
                        <select class="control-select" id="sortSelect" onchange="sortOffers()">
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="rating">Rating: High to Low</option>
                            <option value="experience">Experience: High to Low</option>
                            <option value="reviews">Most Reviews</option>
                        </select>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Filter by Rating</label>
                        <select class="control-select" id="ratingFilter" onchange="filterOffers()">
                            <option value="">All Ratings</option>
                            <option value="4.5">4.5+ Stars</option>
                            <option value="4.0">4.0+ Stars</option>
                            <option value="3.5">3.5+ Stars</option>
                        </select>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Filter by Experience</label>
                        <select class="control-select" id="experienceFilter" onchange="filterOffers()">
                            <option value="">All Experience Levels</option>
                            <option value="5">5+ Years</option>
                            <option value="3">3+ Years</option>
                            <option value="1">1+ Years</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="comparison-table">
                <h5>
                    <i class="fas fa-table"></i>
                    Quick Comparison
                </h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Technician</th>
                                <th>Price</th>
                                <th>Rating</th>
                                <th>Experience</th>
                                <th>Reviews</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $lowestPrice = $order->fareOffers->min('proposed_price');
                                $highestRating = $order->fareOffers->max(function($offer) {
                                    return $offer->technician->average_rating ?? 0;
                                });
                                $highestExperience = $order->fareOffers->max(function($offer) {
                                    return $offer->technician->technicianProfile->experience ?? 0;
                                });
                            @endphp
                            @foreach($order->fareOffers as $offer)
                                @php
                                    $rating = $offer->technician->average_rating ?? 0;
                                    $experience = $offer->technician->technicianProfile->experience ?? 0;
                                    $isBestPrice = $offer->proposed_price == $lowestPrice;
                                    $isBestRating = $rating == $highestRating && $rating > 0;
                                    $isBestExperience = $experience == $highestExperience && $experience > 0;
                                @endphp
                                <tr class="offer-row" 
                                    data-price="{{ $offer->proposed_price }}"
                                    data-rating="{{ $rating }}"
                                    data-experience="{{ $experience }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="technician-avatar me-2" style="width: 40px; height: 40px; font-size: 1rem;">
                                                {{ strtoupper(substr($offer->technician->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $offer->technician->name }}</strong>
                                                @if($isBestPrice)
                                                    <span class="badge bg-success ms-1">Best Price</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="{{ $isBestPrice ? 'best-value' : '' }}">
                                        <strong>PKR {{ number_format($offer->proposed_price) }}</strong>
                                    </td>
                                    <td class="{{ $isBestRating ? 'best-value' : '' }}">
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $rating)
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </div>
                                        <small>{{ number_format($rating, 1) }}</small>
                                    </td>
                                    <td class="{{ $isBestExperience ? 'best-value' : '' }}">
                                        <strong>{{ $experience }} years</strong>
                                    </td>
                                    <td>
                                        {{ $offer->technician->total_reviews ?? 0 }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" onclick="acceptFare({{ $offer->id }})">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Processing your selection...</p>
        </div>

        <!-- Fare Offers -->
        @if($order->fareOffers->count() > 0)
            @php
                $lowestPrice = $order->fareOffers->min('proposed_price');
                $highestPrice = $order->fareOffers->max('proposed_price');
                $highestRating = $order->fareOffers->max(function($offer) {
                    return $offer->technician->average_rating ?? 0;
                });
                $highestExperience = $order->fareOffers->max(function($offer) {
                    return $offer->technician->technicianProfile->experience ?? 0;
                });
            @endphp
            
            <div id="offersContainer">
                @foreach($order->fareOffers as $index => $offer)
                    @php
                        $rating = $offer->technician->average_rating ?? 0;
                        $experience = $offer->technician->technicianProfile->experience ?? 0;
                        $isBestPrice = $offer->proposed_price == $lowestPrice;
                        $isBestRating = $rating == $highestRating && $rating > 0;
                        $isBestExperience = $experience == $highestExperience && $experience > 0;
                        $priceDifference = $highestPrice - $offer->proposed_price;
                        $savingsPercentage = $highestPrice > 0 ? round(($priceDifference / $highestPrice) * 100, 1) : 0;
                        
                        $cardClasses = 'fare-offer-card';
                        if ($isBestPrice) $cardClasses .= ' best-price';
                        if ($isBestRating) $cardClasses .= ' best-rating';
                        if ($isBestExperience) $cardClasses .= ' best-experience';
                    @endphp
                    
                    <div class="{{ $cardClasses }}" data-offer-id="{{ $offer->id }}" 
                         data-price="{{ $offer->proposed_price }}"
                         data-rating="{{ $rating }}"
                         data-experience="{{ $experience }}">
                        
                        <!-- Badges -->
                        <div class="badge-container">
                            @if($isBestPrice)
                                <div class="offer-badge badge-best-price">
                                    <i class="fas fa-trophy me-1"></i>
                                    Best Price
                                </div>
                            @endif
                            @if($isBestRating)
                                <div class="offer-badge badge-best-rating">
                                    <i class="fas fa-star me-1"></i>
                                    Top Rated
                                </div>
                            @endif
                            @if($isBestExperience)
                                <div class="offer-badge badge-best-experience">
                                    <i class="fas fa-award me-1"></i>
                                    Most Experienced
                                </div>
                            @endif
                        </div>

                        <!-- Technician Header -->
                        <div class="technician-header">
                            <div class="technician-avatar">
                                {{ strtoupper(substr($offer->technician->name, 0, 1)) }}
                            </div>
                            <div class="technician-info">
                                <h5>{{ $offer->technician->name }}</h5>
                                <div class="technician-meta">
                                    <div class="technician-rating">
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $rating)
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="rating-text">
                                            {{ number_format($rating, 1) }} ({{ $offer->technician->total_reviews ?? 0 }})
                                        </span>
                                    </div>
                                    
                                    @if($offer->technician->technicianProfile)
                                        <div class="technician-meta-item">
                                            <i class="fas fa-tools"></i>
                                            {{ is_array($offer->technician->technicianProfile->occupation ?? null)
                                                ? implode(', ', $offer->technician->technicianProfile->occupation)
                                                : ($offer->technician->technicianProfile->occupation ?? 'Technician') }}
                                        </div>
                                        <div class="technician-meta-item">
                                            <i class="fas fa-clock"></i>
                                            {{ $experience }} years exp.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Technician Stats -->
                        <div class="technician-stats">
                            <div class="technician-stat">
                                <div class="stat-number">{{ $offer->technician->total_reviews ?? 0 }}</div>
                                <div class="stat-label">Reviews</div>
                            </div>
                            <div class="technician-stat">
                                <div class="stat-number">{{ $offer->technician->getPositiveReviewsCount() }}</div>
                                <div class="stat-label">Positive</div>
                            </div>
                            <div class="technician-stat">
                                <div class="stat-number">{{ $experience }}</div>
                                <div class="stat-label">Years</div>
                            </div>
                            <div class="technician-stat">
                                <div class="stat-number">{{ $offer->technician->receivedReviews()->count() }}</div>
                                <div class="stat-label">Jobs</div>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="price-section">
                            <div class="price-amount">PKR {{ number_format($offer->proposed_price) }}</div>
                            <div class="price-label">Proposed Price</div>
                            
                            <div class="price-comparison">
                                <div class="price-comp-item">
                                    <div class="price-comp-label">Lowest</div>
                                    <div class="price-comp-value">PKR {{ number_format($lowestPrice) }}</div>
                                </div>
                                <div class="price-comp-item">
                                    <div class="price-comp-label">Highest</div>
                                    <div class="price-comp-value">PKR {{ number_format($highestPrice) }}</div>
                                </div>
                                @if($priceDifference > 0)
                                    <div class="price-comp-item">
                                        <div class="price-comp-label">You Save</div>
                                        <div class="price-comp-value text-success">PKR {{ number_format($priceDifference) }} ({{ $savingsPercentage }}%)</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Offer Note -->
                        @if($offer->note)
                            <div class="offer-note">
                                <div class="note-header">
                                    <i class="fas fa-comment"></i>
                                    Technician's Note
                                </div>
                                <p class="mb-0">{{ $offer->note }}</p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('technician.profile.view', $offer->technician_id) }}" class="btn-profile">
                                <i class="fas fa-user"></i>
                                View Profile
                            </a>
                            
                            <button type="button" class="btn-accept" onclick="acceptFare({{ $offer->id }})">
                                <i class="fas fa-check"></i>
                                Accept This Offer
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="empty-title">No Fare Offers Yet</h3>
                <p class="empty-description">
                    Technicians are reviewing your service request. 
                    You'll receive offers soon! Check back later or refresh the page.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('customer.order.fares.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Back to Fares
                    </a>
                    <button class="btn btn-primary" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh
                    </button>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="{{ route('customer.order.fares.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back to All Fares
            </a>
        </div>
    </div>
</div>

<script>
// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.fare-offer-card, .order-details-card, .comparison-table, .controls-section');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
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

// Sorting function
function sortOffers() {
    const sortBy = document.getElementById('sortSelect').value;
    const offersContainer = document.getElementById('offersContainer');
    const offers = Array.from(offersContainer.children);
    
    offers.sort((a, b) => {
        const aPrice = parseFloat(a.dataset.price);
        const bPrice = parseFloat(b.dataset.price);
        const aRating = parseFloat(a.dataset.rating);
        const bRating = parseFloat(b.dataset.rating);
        const aExperience = parseFloat(a.dataset.experience);
        const bExperience = parseFloat(b.dataset.experience);
        
        switch(sortBy) {
            case 'price-low':
                return aPrice - bPrice;
            case 'price-high':
                return bPrice - aPrice;
            case 'rating':
                return bRating - aRating;
            case 'experience':
                return bExperience - aExperience;
            case 'reviews':
                const aReviews = parseInt(a.querySelector('.technician-stat .stat-number').textContent);
                const bReviews = parseInt(b.querySelector('.technician-stat .stat-number').textContent);
                return bReviews - aReviews;
            default:
                return 0;
        }
    });
    
    // Re-append sorted offers
    offers.forEach(offer => offersContainer.appendChild(offer));
}

// Filtering function
function filterOffers() {
    const ratingFilter = document.getElementById('ratingFilter').value;
    const experienceFilter = document.getElementById('experienceFilter').value;
    const offers = document.querySelectorAll('.fare-offer-card');
    
    offers.forEach(offer => {
        const rating = parseFloat(offer.dataset.rating);
        const experience = parseFloat(offer.dataset.experience);
        
        let show = true;
        
        if (ratingFilter && rating < parseFloat(ratingFilter)) {
            show = false;
        }
        
        if (experienceFilter && experience < parseFloat(experienceFilter)) {
            show = false;
        }
        
        offer.style.display = show ? 'block' : 'none';
    });
}

// Accept fare function
function acceptFare(fareId) {
    Swal.fire({
        title: 'Accept This Offer?',
        text: "This will assign the technician to your order and reject all other offers.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Accept Offer!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading spinner
            document.getElementById('loadingSpinner').style.display = 'block';
            
            // Disable all accept buttons
            document.querySelectorAll('.btn-accept').forEach(btn => {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            });
            
            // Send AJAX request
            fetch(`{{ route('customer.order.fares.accept', ['order' => $order->id, 'fare' => 'FARE_ID']) }}`.replace('FARE_ID', fareId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Offer Accepted!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Failed to accept offer. Please try again.'
                });
                
                // Re-enable buttons
                document.querySelectorAll('.btn-accept').forEach(btn => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check"></i> Accept This Offer';
                });
                
                document.getElementById('loadingSpinner').style.display = 'none';
            });
        }
    });
}

// Auto-refresh every 30 seconds
setInterval(function() {
    if (document.visibilityState === 'visible') {
        location.reload();
    }
}, 30000);
</script>
@endsection 