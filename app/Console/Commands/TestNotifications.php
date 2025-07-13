<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Notifications\NewOrderRequest;
use App\Notifications\OrderCompleted;
use App\Notifications\OrderCancelled;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications {type=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notification system for technicians';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        
        // Get a technician user
        $technician = User::where('role', 'technician')->first();
        
        if (!$technician) {
            $this->error('No technician found in the system.');
            return 1;
        }
        
        // Get a sample order
        $order = Order::first();
        
        if (!$order) {
            $this->error('No orders found in the system.');
            return 1;
        }
        
        $this->info("Testing notifications for technician: {$technician->name}");
        
        switch ($type) {
            case 'new_request':
                $this->testNewOrderRequest($technician, $order);
                break;
            case 'completed':
                $this->testOrderCompleted($technician, $order);
                break;
            case 'cancelled':
                $this->testOrderCancelled($technician, $order);
                break;
            case 'all':
            default:
                $this->testNewOrderRequest($technician, $order);
                $this->testOrderCompleted($technician, $order);
                $this->testOrderCancelled($technician, $order);
                break;
        }
        
        $this->info('Notification tests completed successfully!');
        $this->info("Check the notification count: {$technician->unreadNotifications->count()}");
        
        return 0;
    }
    
    private function testNewOrderRequest($technician, $order)
    {
        $this->info('Testing NewOrderRequest notification...');
        $technician->notify(new NewOrderRequest($order));
        $this->info('✓ NewOrderRequest notification sent');
    }
    
    private function testOrderCompleted($technician, $order)
    {
        $this->info('Testing OrderCompleted notification...');
        $technician->notify(new OrderCompleted($order));
        $this->info('✓ OrderCompleted notification sent');
    }
    
    private function testOrderCancelled($technician, $order)
    {
        $this->info('Testing OrderCancelled notification...');
        $technician->notify(new OrderCancelled($order));
        $this->info('✓ OrderCancelled notification sent');
    }
} 