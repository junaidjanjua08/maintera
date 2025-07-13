<?php

namespace App\Http\Controllers;

use App\Models\FareOffer;
use App\Models\Order;
use App\Models\OrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order_requests()
    {
        // Clear the order view source session when navigating to order requests
        session()->forget('order_view_source');

       $requested_orders = OrderRequest::with(['order','order.subcategory'])->whereHas('order', function ($query) {
    $query->where('status', 'pending');
})->where('technician_id', auth()->id())
->where('fare_offer',null)
    ->orderBy('created_at', 'desc')
    ->get();
    // dd($requested_orders);
        return view('technician.pages.order-requests', compact('requested_orders'));
    }

    public function pending_orders()
    {
        // Clear the order view source session when navigating to pending orders
        session()->forget('order_view_source');
       
        $technicianId = auth()->id(); // or Auth::user()->id

        $pending_orders = FareOffer::with('order')
        ->where('technician_id', $technicianId)
        ->where('status', 'accepted')
        ->whereHas('order', function ($query) {
            $query->where('status', 'pending');
        })
        ->get();


        return view('technician.pages.pending-orders', compact('pending_orders'));
    }

    public function completed_orders()
    {
        // Clear the order view source session when navigating to completed orders
        session()->forget('order_view_source');
        
        $technicianId = auth()->id(); // or Auth::user()->id
        $completed_orders = FareOffer::with(['order', 'order.subcategory', 'order.customer'])
            ->where('technician_id', $technicianId)
            ->where('status', 'accepted')
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->get();
        
        // Ensure we always return a collection, even if empty
        if (!$completed_orders) {
            $completed_orders = collect();
        }
        
        return view('technician.pages.completed-orders', compact('completed_orders'));
    }


    public function view_order(Request $request)
    {
        $subcategory_name = $request->subcategory_name;
        $description = $request->description;
        $area = $request->area;
        $order_id = $request->order_id;
        $city = $request->city;
        $customer_name = $request->customer_name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $status = $request->status;
        $route = $request->route;

        // Check if the order is assigned to the current technician
        $order = Order::find($order_id);
        $isAssignedToTechnician = $order && $order->technician_id == auth()->id();

        // Determine the source route for sidebar highlighting
        $sourceRoute = 'technician.orders.requests'; // default
        if (str_contains($route, 'pending')) {
            $sourceRoute = 'technician.orders.pending';
        } elseif (str_contains($route, 'completed')) {
            $sourceRoute = 'technician.orders.completed';
        } elseif (str_contains($route, 'requests')) {
            $sourceRoute = 'technician.orders.requests';
        }
        
        // Store the source route in session for sidebar highlighting
        session(['order_view_source' => $sourceRoute]);

        $statuses = Order::distinct('status')->pluck('status');
       
        return view('technician.pages.orderview', compact(
            'subcategory_name',
            'description',
            'area',
            'city',
            'customer_name',
            'email',
            'phone',
            'address',
            'status',
            'order_id',
            'route',
            'statuses',
            'isAssignedToTechnician',
            'sourceRoute',
            'order'
        ));
    }


public function updateStatus(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'status' => 'required|in:pending,offer_received,accepted,in_progress,completed,cancelled',
    ]);

    $order = Order::findOrFail($request->order_id);
    
    // Check if the order is assigned to the current technician
    if ($order->technician_id != auth()->id()) {
        return response()->json(['error' => 'You are not authorized to update this order status.'], 403);
    }
    
    $oldStatus = $order->status;
    $order->status = $request->status;
    $order->save();

    // Send notifications based on status change
    if ($oldStatus !== $request->status) {
        // Notify customer about status change
        switch ($request->status) {
            case 'accepted':
                $order->user->notify(new \App\Notifications\OrderAccepted($order));
                break;
            case 'in_progress':
                $order->user->notify(new \App\Notifications\OrderInProgress($order));
                break;
            case 'completed':
                $order->user->notify(new \App\Notifications\OrderCompleted($order));
                break;
            case 'cancelled':
                // For cancellation through status update, we need to check if cancellation_reason is provided
                if ($request->has('cancellation_reason')) {
                    $order->cancellation_reason = $request->cancellation_reason;
                    $order->save();
                }
                $order->user->notify(new \App\Notifications\OrderCancelled($order));
                break;
            default:
                // For other status changes, send a general status update notification
                $order->user->notify(new \App\Notifications\OrderStatusUpdated($order, $oldStatus, $request->status));
                break;
        }
        
        // Notify admin about all status changes
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\OrderStatusUpdated($order, $oldStatus, $request->status));
        }
    }

    return response()->json(['message' => 'Status updated successfully']);
    }

    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'cancellation_reason' => 'required|string|min:10|max:500',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        // Check if the order is assigned to the current technician
        if ($order->technician_id != auth()->id()) {
            return response()->json(['error' => 'You are not authorized to cancel this order.'], 403);
        }
        
        // Check if the order is in pending state
        if ($order->status !== 'pending') {
            return response()->json(['error' => 'Only pending orders can be cancelled.'], 400);
        }
        
        $oldStatus = $order->status;
        $order->status = 'cancelled';
        $order->cancellation_reason = $request->cancellation_reason;
        $order->save();

        // Notify customer that order is cancelled
        $order->user->notify(new \App\Notifications\OrderCancelled($order));
        
        // Notify admin about cancelled order
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\OrderCancelled($order));
        }

        return response()->json(['message' => 'Order cancelled successfully']);
    }

    // Customer: View all fare offers for an order
    public function viewOrderFares($orderId)
    {
        // dd($orderId);
        $order = \App\Models\Order::with('user')->findOrFail($orderId);
        $fareOffers = \App\Models\FareOffer::with('technician.technicianProfile')->where('order_id', $orderId)->get();
        return view('customer.order-fares', compact('order', 'fareOffers'));
    }

    // Customer: View technician profile
    public function viewTechnicianProfile($technicianId)
    {
        $technician = \App\Models\User::with('technicianProfile')->findOrFail($technicianId);
        return view('customer.technician-profile', compact('technician'));
    }

    // Customer: View all orders
    public function customerOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['technician', 'category', 'subcategory', 'fareOffers' => function($query) {
                $query->where('status', 'accepted');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.orders', compact('orders'));
    }

    // Customer: Accept a fare offer (assign order to technician)
    public function acceptFareOffer($orderId, $fareOfferId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        $fareOffer = \App\Models\FareOffer::findOrFail($fareOfferId);
        
        // Check if order belongs to the authenticated customer
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        // Assign order to technician and update status to 'pending' so it appears in technician's pending orders
        $order->technician_id = $fareOffer->technician_id;
        $order->status = 'pending';
        $order->save();
        
        // Mark this fare offer as accepted
        $fareOffer->status = 'accepted';
        $fareOffer->save();
        
        // Reject all other fare offers for this order
        \App\Models\FareOffer::where('order_id', $orderId)
            ->where('id', '!=', $fareOfferId)
            ->update(['status' => 'rejected']);
       
        $technician = $fareOffer->technician;
        
        // Notify customer that order has been accepted
        $order->user->notify(new \App\Notifications\OrderAccepted($order));
        
        // Notify technician that order has been accepted
        $technician->notify(new \App\Notifications\OrderAccepted($order));
        
        // Notify admin about accepted order
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\OrderStatusUpdated($order, 'pending', 'accepted'));
        }
        
        return redirect()->route('customer.order.fares', $orderId)
            ->with('sweet_success', 'You have accepted the fare offer. The order is now assigned to the technician and will appear in their pending orders. You can now chat with them!');
    }
}