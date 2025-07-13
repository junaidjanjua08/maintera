<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Models\FareOffer;
use App\Notifications\OrderAccepted;
use App\Notifications\OrderInProgress;
use App\Notifications\OrderCompleted;
use App\Notifications\OrderCancelled;
use App\Notifications\OrderStatusUpdated;

class TestOrderCancellation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:order-cancellation {type=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the order cancellation functionality and all order notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        
        $this->info('Testing Order Notifications System...');
        
        // Find a pending order with a technician assigned
        $order = Order::where('status', 'pending')
            ->whereNotNull('technician_id')
            ->first();
            
        if (!$order) {
            $this->error('No pending orders with assigned technicians found. Creating a test scenario...');
            
            // Create a test customer if not exists
            $customer = User::where('role', 'customer')->first();
            if (!$customer) {
                $customer = User::create([
                    'name' => 'Test Customer',
                    'email' => 'testcustomer@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'customer',
                    'phone' => '1234567890'
                ]);
            }
            
            // Create a test technician if not exists
            $technician = User::where('role', 'technician')->first();
            if (!$technician) {
                $technician = User::create([
                    'name' => 'Test Technician',
                    'email' => 'testtechnician@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'technician',
                    'phone' => '0987654321'
                ]);
            }
            
            // Create a test order
            $order = Order::create([
                'user_id' => $customer->id,
                'category_id' => 1, // Assuming category 1 exists
                'subcategory_id' => 1, // Assuming subcategory 1 exists
                'description' => 'Test order for notification testing',
                'street_address' => '123 Test Street',
                'city' => 'Test City',
                'area' => 'Test Area',
                'status' => 'pending',
                'technician_id' => $technician->id,
                'payment_mode' => 'cash'
            ]);
            
            $this->info("Created test order #{$order->id}");
        }
        
        $this->info("Testing with Order #{$order->id}");
        $this->info("Current status: {$order->status}");
        $this->info("Technician ID: {$order->technician_id}");
        $this->info("Customer ID: {$order->user_id}");
        
        switch ($type) {
            case 'accepted':
                $this->testOrderAccepted($order);
                break;
            case 'in_progress':
                $this->testOrderInProgress($order);
                break;
            case 'completed':
                $this->testOrderCompleted($order);
                break;
            case 'cancelled':
                $this->testOrderCancelled($order);
                break;
            case 'status_updated':
                $this->testOrderStatusUpdated($order);
                break;
            case 'all':
            default:
                $this->testOrderAccepted($order);
                $this->testOrderInProgress($order);
                $this->testOrderCompleted($order);
                $this->testOrderCancelled($order);
                $this->testOrderStatusUpdated($order);
                break;
        }
        
        $this->info('✅ All notification tests completed successfully!');
        
        return 0;
    }
    
    private function testOrderAccepted($order)
    {
        $this->info("\n📋 Testing OrderAccepted notification...");
        
        // Send notification
        $order->user->notify(new OrderAccepted($order));
        
        $this->info("✅ OrderAccepted notification sent to customer: {$order->user->name}");
        
        // Verify notification was created
        $notification = $order->user->notifications()->latest()->first();
        if ($notification && $notification->type === 'App\Notifications\OrderAccepted') {
            $this->info("✅ Notification verified in database");
        } else {
            $this->error("❌ Notification not found in database");
        }
    }
    
    private function testOrderInProgress($order)
    {
        $this->info("\n🔧 Testing OrderInProgress notification...");
        
        // Send notification
        $order->user->notify(new OrderInProgress($order));
        
        $this->info("✅ OrderInProgress notification sent to customer: {$order->user->name}");
        
        // Verify notification was created
        $notification = $order->user->notifications()->latest()->first();
        if ($notification && $notification->type === 'App\Notifications\OrderInProgress') {
            $this->info("✅ Notification verified in database");
        } else {
            $this->error("❌ Notification not found in database");
        }
    }
    
    private function testOrderCompleted($order)
    {
        $this->info("\n✅ Testing OrderCompleted notification...");
        
        // Send notification
        $order->user->notify(new OrderCompleted($order));
        
        $this->info("✅ OrderCompleted notification sent to customer: {$order->user->name}");
        
        // Verify notification was created
        $notification = $order->user->notifications()->latest()->first();
        if ($notification && $notification->type === 'App\Notifications\OrderCompleted') {
            $this->info("✅ Notification verified in database");
        } else {
            $this->error("❌ Notification not found in database");
        }
    }
    
    private function testOrderCancelled($order)
    {
        $this->info("\n❌ Testing OrderCancelled notification...");
        
        // Set cancellation reason
        $order->cancellation_reason = 'Test cancellation reason - This is a system test to verify the cancellation functionality works properly.';
        $order->save();
        
        // Send notification
        $order->user->notify(new OrderCancelled($order));
        
        $this->info("✅ OrderCancelled notification sent to customer: {$order->user->name}");
        
        // Verify notification was created
        $notification = $order->user->notifications()->latest()->first();
        if ($notification && $notification->type === 'App\Notifications\OrderCancelled') {
            $this->info("✅ Notification verified in database");
        } else {
            $this->error("❌ Notification not found in database");
        }
    }
    
    private function testOrderStatusUpdated($order)
    {
        $this->info("\n🔄 Testing OrderStatusUpdated notification...");
        
        // Send notification
        $order->user->notify(new OrderStatusUpdated($order, 'pending', 'accepted'));
        
        $this->info("✅ OrderStatusUpdated notification sent to customer: {$order->user->name}");
        
        // Verify notification was created
        $notification = $order->user->notifications()->latest()->first();
        if ($notification && $notification->type === 'App\Notifications\OrderStatusUpdated') {
            $this->info("✅ Notification verified in database");
        } else {
            $this->error("❌ Notification not found in database");
        }
    }
}
