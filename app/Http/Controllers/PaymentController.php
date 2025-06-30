<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    // Show the checkout page
    public function checkout(Request $request)
    {
        $order = $request->session()->get('order');
        return view('checkout', compact('order'));
    }

    // Initiate Stripe payment
    public function payWithStripe(Request $request)
    {
        $order = $request->session()->get('order');
        $amount = $order['amount'] ?? 100;
        $orderId = $order['id'] ?? uniqid('order_');

        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pkr',
                    'product_data' => [
                        'name' => 'Service Booking',
                    ],
                    'unit_amount' => $amount * 100, // Stripe expects amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.stripe.success'),
            'cancel_url' => route('payment.stripe.cancel'),
            'metadata' => [
                'order_id' => $orderId,
            ],
        ]);

        // Redirect to Stripe Checkout
        return redirect($session->url);
    }

    // Stripe success callback
    public function stripeSuccess(Request $request)
    {
        // Retrieve booking details from session
        $orderData = session('order');
        if ($orderData) {
            // Create the order in the database
            // Order::create([...]); // Uncomment and map fields as needed
            session()->forget('order');
        }
        return redirect()->route('checkout')->with('success', 'Payment and booking successful!');
    }

    // Stripe cancel callback
    public function stripeCancel(Request $request)
    {
        return redirect()->route('checkout')->with('error', 'Payment was cancelled.');
    }
} 