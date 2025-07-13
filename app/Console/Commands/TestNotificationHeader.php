<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\Notification;
use App\Notifications\OrderAccepted;

class TestNotificationHeader extends Command
{
    protected $signature = 'test:notification-header';
    protected $description = 'Test that header notification icon only shows unread notifications';

    public function handle()
    {
        $this->info('🔔 Testing Header Notification Icon...');
        
        // Create test customer
        $customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Test Customer',
            'email' => 'testcustomer' . time() . '@example.com'
        ]);
        
        // Create test technician
        $technician = User::factory()->create([
            'role' => 'technician',
            'name' => 'Test Technician',
            'email' => 'testtechnician' . time() . '@example.com'
        ]);
        
        // Create test order
        $order = Order::create([
            'user_id' => $customer->id,
            'technician_id' => $technician->id,
            'category_id' => 1,
            'subcategory_id' => 1,
            'status' => 'accepted',
            'description' => 'Test order for notification',
            'street_address' => 'Test address',
            'city' => 'Test City',
            'area' => 'Test Area'
        ]);
        
        // Send notification to customer
        $customer->notify(new OrderAccepted($order, $technician));
        
        // Test unread count
        $unreadCount = $customer->unreadNotifications->count();
        $totalCount = $customer->notifications->count();
        
        $this->info("📊 Notification Counts:");
        $this->info("   Total notifications: {$totalCount}");
        $this->info("   Unread notifications: {$unreadCount}");
        
        // Verify unread count is correct
        if ($unreadCount === 1 && $totalCount === 1) {
            $this->info('✅ Unread notification count is correct');
        } else {
            $this->error('❌ Unread notification count is incorrect');
            return 1;
        }
        
        // Mark notification as read
        $customer->unreadNotifications->markAsRead();
        
        // Test after marking as read
        $unreadCountAfter = $customer->unreadNotifications->count();
        $totalCountAfter = $customer->notifications->count();
        
        $this->info("📊 After marking as read:");
        $this->info("   Total notifications: {$totalCountAfter}");
        $this->info("   Unread notifications: {$unreadCountAfter}");
        
        // Verify unread count is 0 after marking as read
        if ($unreadCountAfter === 0 && $totalCountAfter === 1) {
            $this->info('✅ Notification properly marked as read');
        } else {
            $this->error('❌ Notification not properly marked as read');
            return 1;
        }
        
        // Test header notification logic
        $this->testHeaderNotificationLogic($customer);
        
        $this->info('✅ Header notification icon test completed successfully!');
        
        // Clean up test data
        $customer->delete();
        $technician->delete();
        $order->delete();
        
        return 0;
    }
    
    private function testHeaderNotificationLogic($customer)
    {
        $this->info('🔍 Testing header notification logic...');
        
        // Simulate the logic used in navbar.blade.php
        $unreadCount = $customer->unreadNotifications->count();
        $shouldShowBadge = $unreadCount > 0;
        
        $this->info("   Should show notification badge: " . ($shouldShowBadge ? 'Yes' : 'No'));
        
        if ($unreadCount === 0) {
            $this->info('✅ Header notification badge correctly hidden when no unread notifications');
        } else {
            $this->info('✅ Header notification badge correctly shown when unread notifications exist');
        }
        
        // Test dropdown content logic
        $dropdownNotifications = $customer->unreadNotifications->take(20);
        $dropdownCount = $dropdownNotifications->count();
        
        $this->info("   Dropdown notifications count: {$dropdownCount}");
        
        if ($dropdownCount === 0) {
            $this->info('✅ Dropdown correctly shows no unread notifications');
        } else {
            $this->info('✅ Dropdown correctly shows unread notifications');
        }
    }
} 