@extends('index')

@section('content')
<style>
    .review-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 20px 0;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .review-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .review-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .review-header-content {
        position: relative;
        z-index: 1;
    }

    .review-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .review-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .order-info {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 12px;
        margin-top: 1rem;
        backdrop-filter: blur(10px);
    }

    .order-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .order-info-item:last-child {
        margin-bottom: 0;
    }

    .review-form {
        padding: 2rem;
    }

    .rating-section {
        margin-bottom: 2rem;
    }

    .rating-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .star-rating {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .star {
        font-size: 2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #e9ecef;
    }

    .star:hover,
    .star.active {
        color: #ffc107;
        transform: scale(1.1);
    }

    .star.filled {
        color: #ffc107;
    }

    .rating-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 0.5rem;
        font-style: italic;
    }

    .category-ratings {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .category-rating {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .category-rating:hover {
        border-color: #667eea;
        background: #f0f2ff;
    }

    .category-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-stars {
        display: flex;
        gap: 0.25rem;
    }

    .category-star {
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #e9ecef;
    }

    .category-star:hover,
    .category-star.active {
        color: #ffc107;
        transform: scale(1.05);
    }

    .category-star.filled {
        color: #ffc107;
    }

    .review-textarea {
        width: 100%;
        min-height: 120px;
        padding: 1rem;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 1rem;
        resize: vertical;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .review-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .char-count {
        text-align: right;
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .char-count.near-limit {
        color: #ffc107;
    }

    .char-count.at-limit {
        color: #dc3545;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
    }

    .btn {
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .rating-summary {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        border-left: 4px solid #667eea;
    }

    .summary-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .summary-stars {
        font-size: 2rem;
        color: #ffc107;
        margin-bottom: 0.5rem;
    }

    .summary-description {
        color: #6c757d;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .review-container {
            margin: 10px;
            border-radius: 16px;
        }

        .review-header {
            padding: 1.5rem;
        }

        .review-header h1 {
            font-size: 1.5rem;
        }

        .review-form {
            padding: 1.5rem;
        }

        .category-ratings {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="review-container">
                <!-- Header -->
                <div class="review-header">
                    <div class="review-header-content">
                        <h1>⭐ Rate Your Experience</h1>
                        <p>Help us improve our service by sharing your feedback</p>
                        
                        <div class="order-info">
                            <div class="order-info-item">
                                <span>Order #{{ $order->id }}</span>
                                <span>{{ $order->subcategory->name ?? 'Service' }}</span>
                            </div>
                            <div class="order-info-item">
                                <span>Technician</span>
                                <span>{{ $order->technician->name ?? 'N/A' }}</span>
                            </div>
                            <div class="order-info-item">
                                <span>Location</span>
                                <span>{{ $order->street_address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Form -->
                <div class="review-form">
                    <form id="reviewForm">
                        @csrf
                        
                        <!-- Overall Rating -->
                        <div class="rating-section">
                            <div class="rating-title">
                                <i class="fas fa-star text-warning"></i>
                                Overall Rating
                            </div>
                            <div class="star-rating" id="overallRating">
                                <span class="star" data-rating="1">☆</span>
                                <span class="star" data-rating="2">☆</span>
                                <span class="star" data-rating="3">☆</span>
                                <span class="star" data-rating="4">☆</span>
                                <span class="star" data-rating="5">☆</span>
                            </div>
                            <div class="rating-description" id="ratingDescription">
                                Click on the stars to rate your experience
                            </div>
                        </div>

                        <!-- Category Ratings -->
                        <div class="rating-section">
                            <div class="rating-title">
                                <i class="fas fa-chart-bar text-primary"></i>
                                Rate by Category (Optional)
                            </div>
                            <div class="category-ratings">
                                <div class="category-rating">
                                    <div class="category-title">
                                        <i class="fas fa-tools text-info"></i>
                                        Service Quality
                                    </div>
                                    <div class="category-stars" data-category="service_quality">
                                        <span class="category-star" data-rating="1">☆</span>
                                        <span class="category-star" data-rating="2">☆</span>
                                        <span class="category-star" data-rating="3">☆</span>
                                        <span class="category-star" data-rating="4">☆</span>
                                        <span class="category-star" data-rating="5">☆</span>
                                    </div>
                                </div>

                                <div class="category-rating">
                                    <div class="category-title">
                                        <i class="fas fa-comments text-success"></i>
                                        Communication
                                    </div>
                                    <div class="category-stars" data-category="communication">
                                        <span class="category-star" data-rating="1">☆</span>
                                        <span class="category-star" data-rating="2">☆</span>
                                        <span class="category-star" data-rating="3">☆</span>
                                        <span class="category-star" data-rating="4">☆</span>
                                        <span class="category-star" data-rating="5">☆</span>
                                    </div>
                                </div>

                                <div class="category-rating">
                                    <div class="category-title">
                                        <i class="fas fa-clock text-warning"></i>
                                        Punctuality
                                    </div>
                                    <div class="category-stars" data-category="punctuality">
                                        <span class="category-star" data-rating="1">☆</span>
                                        <span class="category-star" data-rating="2">☆</span>
                                        <span class="category-star" data-rating="3">☆</span>
                                        <span class="category-star" data-rating="4">☆</span>
                                        <span class="category-star" data-rating="5">☆</span>
                                    </div>
                                </div>

                                <div class="category-rating">
                                    <div class="category-title">
                                        <i class="fas fa-user-tie text-primary"></i>
                                        Professionalism
                                    </div>
                                    <div class="category-stars" data-category="professionalism">
                                        <span class="category-star" data-rating="1">☆</span>
                                        <span class="category-star" data-rating="2">☆</span>
                                        <span class="category-star" data-rating="3">☆</span>
                                        <span class="category-star" data-rating="4">☆</span>
                                        <span class="category-star" data-rating="5">☆</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Text -->
                        <div class="rating-section">
                            <div class="rating-title">
                                <i class="fas fa-edit text-success"></i>
                                Share Your Experience (Optional)
                            </div>
                            <textarea 
                                id="reviewText" 
                                name="review" 
                                class="review-textarea" 
                                placeholder="Tell us about your experience with this technician. What went well? What could be improved? Your feedback helps us provide better service."
                                maxlength="1000"
                            ></textarea>
                            <div class="char-count" id="charCount">0 / 1000 characters</div>
                        </div>

                        <!-- Rating Summary -->
                        <div class="rating-summary" id="ratingSummary" style="display: none;">
                            <div class="summary-title">Your Rating Summary</div>
                            <div class="summary-stars" id="summaryStars"></div>
                            <div class="summary-description" id="summaryDescription"></div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('customer.orders') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back to Orders
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-paper-plane"></i>
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let overallRating = 0;
let categoryRatings = {
    service_quality: 0,
    communication: 0,
    punctuality: 0,
    professionalism: 0
};

// Overall rating functionality
document.querySelectorAll('#overallRating .star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = parseInt(this.dataset.rating);
        setOverallRating(rating);
    });

    star.addEventListener('mouseenter', function() {
        const rating = parseInt(this.dataset.rating);
        highlightStars('#overallRating', rating);
    });
});

document.getElementById('overallRating').addEventListener('mouseleave', function() {
    highlightStars('#overallRating', overallRating);
});

// Category rating functionality
document.querySelectorAll('.category-stars').forEach(container => {
    const category = container.dataset.category;
    
    container.querySelectorAll('.category-star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            setCategoryRating(category, rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            highlightCategoryStars(category, rating);
        });
    });

    container.addEventListener('mouseleave', function() {
        highlightCategoryStars(category, categoryRatings[category]);
    });
});

// Review text character count
document.getElementById('reviewText').addEventListener('input', function() {
    const count = this.value.length;
    const maxLength = 1000;
    const charCount = document.getElementById('charCount');
    
    charCount.textContent = `${count} / ${maxLength} characters`;
    
    if (count > maxLength * 0.9) {
        charCount.className = 'char-count near-limit';
    } else if (count >= maxLength) {
        charCount.className = 'char-count at-limit';
    } else {
        charCount.className = 'char-count';
    }
});

// Form submission
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (overallRating === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Rating Required',
            text: 'Please provide an overall rating before submitting.'
        });
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

    const formData = new FormData();
    formData.append('rating', overallRating);
    formData.append('review', document.getElementById('reviewText').value);
    formData.append('service_quality', categoryRatings.service_quality);
    formData.append('communication', categoryRatings.communication);
    formData.append('punctuality', categoryRatings.punctuality);
    formData.append('professionalism', categoryRatings.professionalism);

    fetch('{{ route("customer.reviews.store", $order->id) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Review Submitted!',
                text: data.message,
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '{{ route("customer.orders") }}';
            });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Failed to submit review. Please try again.'
        });
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Review';
    });
});

function setOverallRating(rating) {
    overallRating = rating;
    highlightStars('#overallRating', rating);
    updateRatingDescription(rating);
    updateSubmitButton();
    updateRatingSummary();
}

function setCategoryRating(category, rating) {
    categoryRatings[category] = rating;
    highlightCategoryStars(category, rating);
}

function highlightStars(container, rating) {
    const stars = document.querySelectorAll(`${container} .star`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.textContent = '★';
            star.classList.add('filled');
        } else {
            star.textContent = '☆';
            star.classList.remove('filled');
        }
    });
}

function highlightCategoryStars(category, rating) {
    const stars = document.querySelectorAll(`[data-category="${category}"] .category-star`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.textContent = '★';
            star.classList.add('filled');
        } else {
            star.textContent = '☆';
            star.classList.remove('filled');
        }
    });
}

function updateRatingDescription(rating) {
    const descriptions = {
        1: 'Poor - Very dissatisfied with the service',
        2: 'Fair - Below average experience',
        3: 'Good - Satisfactory service',
        4: 'Very Good - Above average experience',
        5: 'Excellent - Outstanding service!'
    };
    
    document.getElementById('ratingDescription').textContent = descriptions[rating] || 'Click on the stars to rate your experience';
}

function updateSubmitButton() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = overallRating === 0;
}

function updateRatingSummary() {
    if (overallRating > 0) {
        const summary = document.getElementById('ratingSummary');
        const summaryStars = document.getElementById('summaryStars');
        const summaryDescription = document.getElementById('summaryDescription');
        
        summaryStars.textContent = '★'.repeat(overallRating) + '☆'.repeat(5 - overallRating);
        summaryDescription.textContent = `Overall Rating: ${overallRating}/5 - ${updateRatingDescription(overallRating).split(' - ')[1]}`;
        summary.style.display = 'block';
    }
}
</script>
@endsection 