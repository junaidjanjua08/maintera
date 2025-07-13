<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Models\ServiceCategory;
use App\Models\OrderRequest;

class TestOrderMatching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:order-matching {order_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test order matching system for technicians';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        if ($orderId) {
            $order = Order::find($orderId);
            if (!$order) {
                $this->error("Order #{$orderId} not found!");
                return 1;
            }
            $this->testSpecificOrder($order);
        } else {
            $this->testAllOrders();
        }
        
        return 0;
    }
    
    private function testSpecificOrder($order)
    {
        $this->info("Testing Order #{$order->id}");
        $this->info("Category: " . ($order->category ? $order->category->name : 'Unknown'));
        $this->info("Location: {$order->latitude}, {$order->longitude}");
        $this->info("Status: {$order->status}");
        
        if (!$order->latitude || !$order->longitude) {
            $this->error("Order doesn't have location data!");
            return;
        }
        
        $technicians = User::technicians()
            ->whereHas('technicianProfile', function ($q) {
                $q->where('is_available', true)
                  ->whereNotNull('latitude')
                  ->whereNotNull('longitude');
            })
            ->with('technicianProfile')
            ->get();
            
        $this->info("Found " . $technicians->count() . " available technicians with location data");
        
        // Define occupation to category mapping
        $occupationToCategory = [
            'Electrician' => 'Electrical',
            'Plumber' => 'Plumbing',
            'Housekeeping' => 'Cleaning',
            'Carpenter' => 'Carpentry',
            'Painter' => 'Painting',
            'AC Technician' => 'AC Services',
            'Appliance Repair' => 'Appliance Repair',
        ];
        
        $matchedCount = 0;
        foreach ($technicians as $technician) {
            $profile = $technician->technicianProfile;
            $distance = $this->calculateDistance(
                $order->latitude, 
                $order->longitude, 
                $profile->latitude, 
                $profile->longitude
            );
            
            $this->info("Technician: {$technician->name} - Distance: {$distance}km");
            
            if ($distance <= 30) {
                $this->info("  ✓ Within 30km range");
                
                $technicianOccupations = $profile->occupation ?? [];
                $hasRequiredSkill = false;
                
                if (is_array($technicianOccupations)) {
                    foreach ($technicianOccupations as $occupation) {
                        // Check if occupation name matches the category
                        if (isset($occupationToCategory[$occupation]) && $occupationToCategory[$occupation] === $order->category->name) {
                            $hasRequiredSkill = true;
                            $this->info("  ✓ Has required skill for category {$order->category->name}");
                            break;
                        }
                    }
                }
                
                if ($hasRequiredSkill) {
                    $matchedCount++;
                    $this->info("  ✓ MATCHED - Should receive order request");
                    
                    // Check if order request exists
                    $existing = OrderRequest::where('order_id', $order->id)
                        ->where('technician_id', $technician->id)
                        ->first();
                        
                    if ($existing) {
                        $this->info("  ✓ Order request already exists");
                    } else {
                        $this->warn("  ✗ Order request NOT created!");
                    }
                } else {
                    $this->warn("  ✗ Doesn't have required skill");
                    $this->info("  Technician occupations: " . json_encode($technicianOccupations));
                }
            } else {
                $this->warn("  ✗ Too far away");
            }
        }
        
        $this->info("Total matched technicians: {$matchedCount}");
    }
    
    private function testAllOrders()
    {
        $orders = Order::where('status', 'pending')->get();
        $this->info("Testing " . $orders->count() . " pending orders");
        
        foreach ($orders as $order) {
            $this->testSpecificOrder($order);
            $this->line('---');
        }
    }
    
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the earth in km

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta/2) * sin($latDelta/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta/2) * sin($lonDelta/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance; // Distance in km
    }
}
