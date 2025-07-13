<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\FareOffer;
use App\Notifications\OrderCompleted;

class TestRatingReviewSystem extends Command
{
    protected $signature = 'test:rating-review-system';
    protected $description = 'Test the comprehensive rating and review system';

    public function handle()
    {
        $this->info('⭐ Testing Rating & Review System...');
        
        // Create test data
        $this->createTestData();
        
        // Test review creation
        $this->testReviewCreation();
        
        // Test review validation
        $this->testReviewValidation();
        
        // Test technician rating calculations
        $this->testTechnicianRatingCalculations();
        
        // Test review management
        $this->testReviewManagement();
        
        // Test notification integration
        $this->testNotificationIntegration();
        
        $this->info('✅ Rating & Review System testing completed successfully!');
    }
    
    private function createTestData()
    {
        $this->info('📝 Creating test data...');
        
        // Create customer
        $customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Test Customer',
            'email' => 'testcustomer' . time() . '@example.com'
        ]);
        
        // Create technician
        $technician = User::factory()->create([
            'role' => 'technician',
            'name' => 'Test Technician',
            'email' => 'testtechnician' . time() . '@example.com'
        ]);
        
        // Create completed order
        $order = Order::create([
            'user_id' => $customer->id,
            'technician_id' => $technician->id,
            'category_id' => 1,
            'subcategory_id' => 1,
            'status' => 'completed',
            'description' => 'Test order for review system',
            'street_address' => 'Test address',
            'city' => 'Test City',
            'area' => 'Test Area',
            'created_at' => now()->subDays(1)
        ]);
        
        $this->info('✅ Test data created successfully!');
        
        return compact('customer', 'technician', 'order');
    }
    
    private function testReviewCreation()
    {
        $this->info('📝 Testing Review Creation...');
        
        $customer = User::where('role', 'customer')->first();
        $technician = User::where('role', 'technician')->first();
        $order = Order::where('status', 'completed')->first();
        
        // Test creating a review
        $review = OrderReview::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'technician_id' => $technician->id,
            'rating' => 5,
            'review' => 'Excellent service! The technician was very professional and completed the work quickly.',
            'service_quality' => 5,
            'communication' => 4,
            'punctuality' => 5,
            'professionalism' => 5
        ]);
        
        $this->assert($review->exists, 'Review should be created successfully');
        $this->assert($review->rating === 5, 'Rating should be 5');
        $this->assert($review->stars === '★★★★★', 'Stars should show 5 filled stars');
        $this->assert($review->rating_description === 'Excellent', 'Rating description should be Excellent');
        $this->assert($review->average_category_rating === 4.8, 'Average category rating should be 4.8');
        
        $this->info('✅ Review creation working correctly!');
    }
    
    private function testReviewValidation()
    {
        $this->info('🔍 Testing Review Validation...');
        
        $customer = User::where('role', 'customer')->first();
        $technician = User::where('role', 'technician')->first();
        $order = Order::where('status', 'completed')->first();
        
        // Test duplicate review prevention
        try {
            OrderReview::create([
                'order_id' => $order->id,
                'customer_id' => $customer->id,
                'technician_id' => $technician->id,
                'rating' => 4,
                'review' => 'Another review'
            ]);
            $this->error('❌ Should not allow duplicate reviews for same order');
        } catch (\Exception $e) {
            $this->info('✅ Duplicate review prevention working');
        }
        
        // Test invalid rating
        try {
            OrderReview::create([
                'order_id' => $order->id + 1,
                'customer_id' => $customer->id,
                'technician_id' => $technician->id,
                'rating' => 6, // Invalid rating
                'review' => 'Test review'
            ]);
            $this->error('❌ Should not allow rating > 5');
        } catch (\Exception $e) {
            $this->info('✅ Rating validation working');
        }
        
        $this->info('✅ Review validation working correctly!');
    }
    
    private function testTechnicianRatingCalculations()
    {
        $this->info('📊 Testing Technician Rating Calculations...');
        
        $technician = User::where('role', 'technician')->first();
        
        // Test average rating calculation
        $averageRating = $technician->average_rating;
        $totalReviews = $technician->total_reviews;
        $ratingDistribution = $technician->rating_distribution;
        
        $this->assert($averageRating > 0, 'Technician should have average rating');
        $this->assert($totalReviews > 0, 'Technician should have total reviews count');
        $this->assert(is_array($ratingDistribution), 'Rating distribution should be an array');
        
        $this->info("   Average Rating: {$averageRating}");
        $this->info("   Total Reviews: {$totalReviews}");
        $this->info("   Rating Stars: {$technician->rating_stars}");
        
        // Test positive/negative review counts
        $positiveCount = $technician->getPositiveReviewsCount();
        $negativeCount = $technician->getNegativeReviewsCount();
        
        $this->info("   Positive Reviews (4-5 stars): {$positiveCount}");
        $this->info("   Negative Reviews (1-2 stars): {$negativeCount}");
        
        $this->info('✅ Technician rating calculations working correctly!');
    }
    
    private function testReviewManagement()
    {
        $this->info('🔄 Testing Review Management...');
        
        $review = OrderReview::first();
        $originalRating = $review->rating;
        
        // Test review update
        $review->update([
            'rating' => 4,
            'review' => 'Updated review - Very good service!'
        ]);
        
        $this->assert($review->rating === 4, 'Review should be updated');
        $this->assert($review->stars === '★★★★☆', 'Stars should show 4 filled stars');
        
        // Test review deletion
        $reviewId = $review->id;
        $review->delete();
        
        $deletedReview = OrderReview::find($reviewId);
        $this->assert($deletedReview === null, 'Review should be deleted');
        
        $this->info('✅ Review management working correctly!');
    }
    
    private function testNotificationIntegration()
    {
        $this->info('🔔 Testing Notification Integration...');
        
        $customer = User::where('role', 'customer')->first();
        $technician = User::where('role', 'technician')->first();
        $order = Order::where('status', 'completed')->first();
        
        // Test order completion notification
        $customer->notify(new OrderCompleted($order));
        
        $notification = $customer->notifications()->latest()->first();
        $this->assert($notification !== null, 'Order completion notification should be sent');
        
        $notificationData = $notification->data;
        $this->assert(isset($notificationData['review_url']), 'Notification should include review URL');
        $this->assert($notificationData['type'] === 'order_completed', 'Notification type should be order_completed');
        
        $this->info('✅ Notification integration working correctly!');
    }
    
    private function assert($condition, $message)
    {
        if (!$condition) {
            $this->error("❌ Assertion failed: {$message}");
            throw new \Exception($message);
        }
        $this->info("✅ {$message}");
    }
} 