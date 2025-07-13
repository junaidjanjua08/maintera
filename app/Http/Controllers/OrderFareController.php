<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\FareOffer;
use App\Models\User;
use App\Notifications\OrderAccepted;
use App\Notifications\OrderCancelled;

class OrderFareController extends Controller
{
    /**
     * Display all pending fares for the customer
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all orders with pending fare offers
        $ordersWithFares = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->whereHas('fareOffers', function($query) {
                $query->where('status', 'pending');
            })
            ->with(['fareOffers' => function($query) {
                $query->where('status', 'pending')
                      ->with(['technician' => function($techQuery) {
                          $techQuery->with('technicianProfile');
                      }]);
            }, 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($order) {
                // Add fare count and best price
                $order->fare_count = $order->fareOffers->count();
                $order->best_price = $order->fareOffers->min('proposed_price');
                $order->lowest_fare = $order->fareOffers->where('proposed_price', $order->best_price)->first();
                return $order;
            });

        return view('customer.order-fares.index', compact('ordersWithFares'));
    }

    /**
     * Display fares for a specific order
     */
    public function show($orderId)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->where('id', $orderId)
            ->with(['fareOffers' => function($query) {
                $query->where('status', 'pending')
                      ->with(['technician' => function($techQuery) {
                          $techQuery->with('technicianProfile');
                      }]);
            }, 'subcategory'])
            ->firstOrFail();

        // Sort fares by price (lowest first)
        $order->fareOffers = $order->fareOffers->sortBy('proposed_price');

        return view('customer.order-fares.show', compact('order'));
    }

    /**
     * Accept a fare offer
     */
    public function acceptFare(Request $request, $orderId, $fareId)
    {
        $user = Auth::user();
        
        // Validate the fare offer belongs to the user's order
        $order = Order::where('user_id', $user->id)
            ->where('id', $orderId)
            ->where('status', 'pending')
            ->firstOrFail();

        $fareOffer = FareOffer::where('id', $fareId)
            ->where('order_id', $orderId)
            ->where('status', 'pending')
            ->with('technician')
            ->firstOrFail();

        try {
            // Start transaction
            DB::beginTransaction();

            // Accept the selected fare offer
            $fareOffer->update(['status' => 'accepted']);

            // Assign technician to order
            $order->update([
                'technician_id' => $fareOffer->technician_id,
                'status' => 'pending' // Keep as pending so it appears in technician's dashboard
            ]);

            // Reject all other fare offers for this order
            FareOffer::where('order_id', $orderId)
                ->where('id', '!=', $fareId)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            // Send notifications
            $fareOffer->technician->notify(new OrderAccepted($order));
            
            // Notify other technicians that their offers were rejected
            $rejectedOffers = FareOffer::where('order_id', $orderId)
                ->where('id', '!=', $fareId)
                ->where('status', 'rejected')
                ->with('technician')
                ->get();

            foreach ($rejectedOffers as $rejectedOffer) {
                $rejectedOffer->technician->notify(new OrderCancelled($order, 'Another offer was accepted'));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Fare offer accepted successfully!',
                'redirect' => route('customer.orders')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to accept fare offer. Please try again.'
            ], 500);
        }
    }

    /**
     * Get fare statistics for dashboard
     */
    public function getFareStats()
    {
        $user = Auth::user();
        
        $stats = [
            'pending_orders' => Order::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'pending_fares' => FareOffer::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'pending');
            })->where('status', 'pending')->count(),
            'accepted_orders' => Order::where('user_id', $user->id)
                ->where('status', 'accepted')
                ->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereHas('fareOffers', function($query) {
                    $query->where('status', 'accepted');
                })
                ->join('fare_offers', 'orders.id', '=', 'fare_offers.order_id')
                ->where('fare_offers.status', 'accepted')
                ->sum('fare_offers.proposed_price')
        ];

        return response()->json($stats);
    }
} 