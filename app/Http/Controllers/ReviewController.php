<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\User;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Show the review form for a completed order
     */
    public function showReviewForm($orderId)
    {
        $order = Order::with(['technician', 'subcategory', 'review'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        // Check if order is completed
        if ($order->status !== 'completed') {
            return redirect()->route('customer.orders')
                ->with('error', 'You can only review completed orders.');
        }

        // Check if already reviewed
        if ($order->review) {
            return redirect()->route('customer.orders')
                ->with('info', 'You have already reviewed this order.');
        }

        return view('customer.reviews.create', compact('order'));
    }

    /**
     * Store a new review
     */
    public function store(Request $request, $orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($orderId);

        // Validate order can be reviewed
        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'You can only review completed orders.'
            ], 400);
        }

        if ($order->review) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this order.'
            ], 400);
        }

        // Validate request
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
            'service_quality' => 'nullable|integer|between:1,5',
            'communication' => 'nullable|integer|between:1,5',
            'punctuality' => 'nullable|integer|between:1,5',
            'professionalism' => 'nullable|integer|between:1,5',
        ]);

        try {
            // Create the review
            $review = OrderReview::create([
                'order_id' => $order->id,
                'customer_id' => Auth::id(),
                'technician_id' => $order->technician_id,
                'rating' => $request->rating,
                'review' => $request->review,
                'service_quality' => $request->service_quality,
                'communication' => $request->communication,
                'punctuality' => $request->punctuality,
                'professionalism' => $request->professionalism,
            ]);

            // Update technician's average rating
            $this->updateTechnicianRating($order->technician_id);

            // Send notification to technician (optional)
            $this->notifyTechnician($review);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! Your feedback helps us improve our service.',
                'review' => $review->load('customer')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit review. Please try again.'
            ], 500);
        }
    }

    /**
     * Show edit review form
     */
    public function edit($orderId)
    {
        $order = Order::with(['technician', 'subcategory', 'review'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        if (!$order->review) {
            return redirect()->route('customer.orders')
                ->with('error', 'No review found for this order.');
        }

        return view('customer.reviews.edit', compact('order'));
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, $orderId)
    {
        $order = Order::with('review')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        if (!$order->review) {
            return response()->json([
                'success' => false,
                'message' => 'No review found for this order.'
            ], 400);
        }

        // Validate request
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
            'service_quality' => 'nullable|integer|between:1,5',
            'communication' => 'nullable|integer|between:1,5',
            'punctuality' => 'nullable|integer|between:1,5',
            'professionalism' => 'nullable|integer|between:1,5',
        ]);

        try {
            // Update the review
            $order->review->update([
                'rating' => $request->rating,
                'review' => $request->review,
                'service_quality' => $request->service_quality,
                'communication' => $request->communication,
                'punctuality' => $request->punctuality,
                'professionalism' => $request->professionalism,
            ]);

            // Update technician's average rating
            $this->updateTechnicianRating($order->technician_id);

            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully!',
                'review' => $order->review->fresh()->load('customer')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update review. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete a review
     */
    public function destroy($orderId)
    {
        $order = Order::with('review')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        if (!$order->review) {
            return response()->json([
                'success' => false,
                'message' => 'No review found for this order.'
            ], 400);
        }

        try {
            $technicianId = $order->technician_id;
            $order->review->delete();

            // Update technician's average rating
            $this->updateTechnicianRating($technicianId);

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review. Please try again.'
            ], 500);
        }
    }

    /**
     * Show technician's reviews
     */
    public function technicianReviews($technicianId)
    {
        $technician = User::where('role', 'technician')->findOrFail($technicianId);
        
        $reviews = OrderReview::with(['customer', 'order'])
            ->where('technician_id', $technicianId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = $this->getTechnicianReviewStats($technicianId);

        return view('customer.reviews.technician', compact('technician', 'reviews', 'stats'));
    }

    /**
     * Get review statistics for a technician
     */
    private function getTechnicianReviewStats($technicianId)
    {
        $reviews = OrderReview::where('technician_id', $technicianId);
        
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
        
        // Rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $reviews->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => $averageRating,
            'rating_distribution' => $ratingDistribution
        ];
    }

    /**
     * Update technician's average rating
     */
    private function updateTechnicianRating($technicianId)
    {
        $technician = User::find($technicianId);
        if ($technician) {
            $averageRating = OrderReview::where('technician_id', $technicianId)->avg('rating');
            $technician->update([
                'average_rating' => round($averageRating, 1),
                'total_reviews' => OrderReview::where('technician_id', $technicianId)->count()
            ]);
        }
    }

    /**
     * Notify technician about new review
     */
    private function notifyTechnician($review)
    {
        // You can implement this later with a notification class
        // For now, we'll just log it
        \Log::info("New review received for technician {$review->technician_id}");
    }
} 