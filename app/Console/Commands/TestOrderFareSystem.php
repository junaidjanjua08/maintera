<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\FareOffer;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ServiceCategoryService;
use App\Models\TechnicianProfile;
use App\Notifications\TechnicianFareOffer;

class TestOrderFareSystem extends Command
{
    protected $signature = 'test:order-fare-system';
    protected $description = 'Test the order fare system functionality';

    public function handle()
    {
        $this->info('🧪 Testing Order Fare System...');
        
        try {
            // Create test data
            $this->createTestData();
            
            // Test the fare system
            $this->testFareSystem();
            
            $this->info('✅ Order Fare System test completed successfully!');
            
        } catch (\Exception $e) {
            $this->error('❌ Test failed: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    private function createTestData()
    {
        $this->info('📝 Creating test data...');
        
        // Create customer
        $customer = User::firstOrCreate([
            'email' => 'customer.fare@test.com'
        ], [
            'name' => 'Test Customer',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'status' => 'active'
        ]);
        
        // Create technicians
        $technicians = [];
        for ($i = 1; $i <= 3; $i++) {
            $technician = User::firstOrCreate([
                'email' => "technician.fare{$i}@test.com"
            ], [
                'name' => "Test Technician {$i}",
                'password' => bcrypt('password'),
                'role' => 'technician',
                'status' => 'active'
            ]);
            
            // Create technician profile
            TechnicianProfile::firstOrCreate([
                'user_id' => $technician->id
            ], [
                'phone' => "0300-123456{$i}",
                'address' => "Test Address {$i}",
                'occupation' => json_encode(['Plumber', 'Electrician']),
                'experience' => rand(2, 8),
                'bio' => "Experienced technician with {$i} years of service",
                'hourly_rate' => rand(500, 1500),
                'is_available' => true
            ]);
            
            $technicians[] = $technician;
        }
        
        // Create service category and service
        $category = ServiceCategory::firstOrCreate([
            'name' => 'Test Category'
        ], [
            'description' => 'Test category for fare system'
        ]);
        
        $service = Service::firstOrCreate([
            'name' => 'Test Service'
        ], [
            'description' => 'Test service for fare system',
            'base_price' => 1000
        ]);
        
        ServiceCategoryService::firstOrCreate([
            'service_category_id' => $category->id,
            'service_id' => $service->id
        ]);
        
        // Create order
        $order = Order::firstOrCreate([
            'user_id' => $customer->id,
            'category_id' => $category->id,
            'subcategory_id' => $service->id
        ], [
            'description' => 'Test order for fare system',
            'street_address' => 'Test Address, Test City',
            'city' => 'Test City',
            'area' => 'Test Area',
            'sub_area' => 'Test Sub Area',
            'status' => 'pending',
            'scheduled_at' => now()->addDays(2)
        ]);
        
        // Create fare offers
        $prices = [800, 950, 1200];
        foreach ($technicians as $index => $technician) {
            $fareOffer = FareOffer::firstOrCreate([
                'order_id' => $order->id,
                'technician_id' => $technician->id
            ], [
                'proposed_price' => $prices[$index],
                'note' => "Professional service offer from {$technician->name}",
                'status' => 'pending'
            ]);
            
            // Send notification
            $customer->notify(new TechnicianFareOffer($fareOffer));
        }
        
        $this->info("✅ Created test data:");
        $this->info("   - Customer: {$customer->name}");
        $this->info("   - Technicians: " . count($technicians));
        $this->info("   - Order: #{$order->id}");
        $this->info("   - Fare offers: " . FareOffer::where('order_id', $order->id)->count());
    }
    
    private function testFareSystem()
    {
        $this->info('🔍 Testing fare system functionality...');
        
        // Test 1: Check if orders with fares exist
        $ordersWithFares = Order::where('status', 'pending')
            ->whereHas('fareOffers', function($query) {
                $query->where('status', 'pending');
            })
            ->with(['fareOffers' => function($query) {
                $query->where('status', 'pending')
                      ->with(['technician' => function($techQuery) {
                          $techQuery->with('technicianProfile');
                      }]);
            }])
            ->get();
        
        if ($ordersWithFares->count() > 0) {
            $this->info("✅ Found {$ordersWithFares->count()} orders with pending fares");
            
            foreach ($ordersWithFares as $order) {
                $this->info("   Order #{$order->id}: {$order->fareOffers->count()} offers");
                
                // Test fare statistics
                $bestPrice = $order->fareOffers->min('proposed_price');
                $highestPrice = $order->fareOffers->max('proposed_price');
                $this->info("   - Best price: PKR {$bestPrice}");
                $this->info("   - Highest price: PKR {$highestPrice}");
                
                // Test technician information
                foreach ($order->fareOffers as $offer) {
                    $this->info("   - {$offer->technician->name}: PKR {$offer->proposed_price}");
                }
            }
        } else {
            $this->warn("⚠️ No orders with pending fares found");
        }
        
        // Test 2: Check notification system
        $customer = User::where('email', 'customer.fare@test.com')->first();
        if ($customer) {
            $unreadNotifications = $customer->unreadNotifications->count();
            $this->info("✅ Customer has {$unreadNotifications} unread notifications");
            
            $fareNotifications = $customer->unreadNotifications()
                ->where('type', 'App\\Notifications\\TechnicianFareOffer')
                ->count();
            $this->info("✅ {$fareNotifications} fare offer notifications");
        }
        
        // Test 3: Check fare acceptance functionality
        $this->info('🧪 Testing fare acceptance...');
        
        $order = Order::where('status', 'pending')->first();
        if ($order) {
            $lowestFare = $order->fareOffers()
                ->where('status', 'pending')
                ->orderBy('proposed_price')
                ->first();
            
            if ($lowestFare) {
                $this->info("✅ Found lowest fare: PKR {$lowestFare->proposed_price} by {$lowestFare->technician->name}");
                
                // Simulate acceptance
                $lowestFare->update(['status' => 'accepted']);
                $order->update([
                    'technician_id' => $lowestFare->technician_id,
                    'status' => 'accepted'
                ]);
                
                // Reject other offers
                FareOffer::where('order_id', $order->id)
                    ->where('id', '!=', $lowestFare->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'rejected']);
                
                $this->info("✅ Simulated fare acceptance - Order status: {$order->status}");
                
                // Check remaining pending fares
                $remainingPending = FareOffer::where('order_id', $order->id)
                    ->where('status', 'pending')
                    ->count();
                $this->info("✅ Remaining pending fares: {$remainingPending}");
            }
        }
        
        // Test 4: Check routes and views
        $this->info('🔗 Testing routes...');
        
        $routes = [
            'customer.order.fares.index' => route('customer.order.fares.index'),
            'customer.order.fares.show' => route('customer.order.fares.show', 1),
            'customer.order.fares.accept' => route('customer.order.fares.accept', [1, 1]),
        ];
        
        foreach ($routes as $name => $url) {
            $this->info("   {$name}: {$url}");
        }
        
        $this->info('✅ Route testing completed');
    }
} 