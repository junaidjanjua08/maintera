@extends('index')

@section('content')
<style>
    .profile-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .profile-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .technician-avatar-large {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        font-weight: 700;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .technician-name {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .technician-title {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .rating-section {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 1.5rem;
    }

    .rating-text {
        color: #6c757d;
        font-size: 1rem;
        font-weight: 600;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #667eea;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1rem;
    }

    .bio-section {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-left: 4px solid #667eea;
    }

    .reviews-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .review-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #28a745;
        transition: all 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reviewer-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .reviewer-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .review-date {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .review-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .review-stars {
        color: #ffc107;
        font-size: 1rem;
    }

    .review-text {
        color: #495057;
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    .review-service {
        color: #6c757d;
        font-size: 0.85rem;
        font-style: italic;
    }

    .no-reviews {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .no-reviews-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .back-btn {
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

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        color: white;
        text-decoration: none;
    }

    .contact-btn {
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
        margin-left: 1rem;
    }

    .contact-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<div class="profile-container">
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="technician-avatar-large">
                {{ strtoupper(substr($technician->name, 0, 1)) }}
            </div>
            
            <h1 class="technician-name">{{ $technician->name }}</h1>
            <p class="technician-title">
                <i class="fas fa-tools me-2"></i>
                {{ is_array($technician->technicianProfile->occupation ?? null)
    ? implode(', ', $technician->technicianProfile->occupation)
    : ($technician->technicianProfile->occupation ?? 'Professional Technician') }}
            </p>
            
            <div class="rating-section">
                <div class="rating-stars">
                    @php
                        $rating = $technician->average_rating ?? 0;
                        $totalReviews = $technician->total_reviews ?? 0;
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
            
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalReviews }}</div>
                    <div class="stat-label">Total Reviews</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $technician->getPositiveReviewsCount() }}</div>
                    <div class="stat-label">Positive Reviews</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $technician->technicianProfile->experience ?? '0' }} years</div>
                    <div class="stat-label">Experience</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $technician->receivedReviews()->count() }}</div>
                    <div class="stat-label">Completed Jobs</div>
                </div>
            </div>
        </div>
        
        <!-- Profile Information -->
        <div class="profile-content">
            <h3 class="section-title">
                <i class="fas fa-user-circle"></i>
                Professional Information
            </h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $technician->email }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $technician->technicianProfile->phone ?? 'Not provided' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Occupation</div>
                    <div class="info-value">{{ is_array($technician->technicianProfile->occupation ?? null)
                        ? implode(', ', $technician->technicianProfile->occupation)
                        : ($technician->technicianProfile->occupation ?? 'Not specified') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Experience</div>
                    <div class="info-value">{{ $technician->technicianProfile->experience ?? '0' }} years</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Qualification</div>
                    <div class="info-value">{{ $technician->technicianProfile->qualification ?? 'Not specified' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div class="info-value">{{ $technician->technicianProfile->city ?? 'Not specified' }}</div>
                </div>
            </div>
            
            @if($technician->technicianProfile->bio)
                <div class="bio-section">
                    <h5 class="mb-2">
                        <i class="fas fa-quote-left me-2"></i>
                        About Me
                    </h5>
                    <p class="mb-0">{{ $technician->technicianProfile->bio }}</p>
                </div>
            @endif
        </div>
        
        <!-- Reviews Section -->
        <div class="reviews-section">
            <h3 class="section-title">
                <i class="fas fa-star"></i>
                Customer Reviews ({{ $totalReviews }})
            </h3>
            
            @php
                $reviews = $technician->receivedReviews()->with(['customer', 'order'])->orderBy('created_at', 'desc')->get();
            @endphp
            
            @if($reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="reviewer-name">{{ $review->customer->name ?? 'Anonymous' }}</div>
                                    <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="review-rating">
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-text">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        
                        @if($review->review)
                            <div class="review-text">{{ $review->review }}</div>
                        @endif
                        
                        @if($review->order)
                            <div class="review-service">
                                <i class="fas fa-tools me-1"></i>
                                Service: {{ $review->order->subcategory->name ?? 'N/A' }}
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="no-reviews">
                    <div class="no-reviews-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5>No Reviews Yet</h5>
                    <p class="text-muted">This technician hasn't received any reviews yet.</p>
                </div>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="text-center">
            <a href="javascript:history.back()" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
            
            @if($technician->technicianProfile->phone)
                <a href="tel:{{ $technician->technicianProfile->phone }}" class="contact-btn">
                    <i class="fas fa-phone"></i>
                    Contact Technician
                </a>
            @endif
        </div>
    </div>
</div>

<script>
// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on load
    const elements = document.querySelectorAll('.profile-header, .profile-content, .reviews-section');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Add hover effects to review cards
    const reviewCards = document.querySelectorAll('.review-card');
    reviewCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection 