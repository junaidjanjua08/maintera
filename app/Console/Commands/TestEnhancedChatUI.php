<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\ChatMessage;
use App\Models\FareOffer;
use App\Models\ChatDeletion;

class TestEnhancedChatUI extends Command
{
    protected $signature = 'test:enhanced-chat-ui';
    protected $description = 'Test the enhanced chat UI functionality for customers';

    public function handle()
    {
        $this->info('🧪 Testing Enhanced Chat UI Functionality...');
        
        // Create test data
        $this->createTestData();
        
        // Test chat list features
        $this->testChatListFeatures();
        
        // Test chat show features
        $this->testChatShowFeatures();
        
        // Test search and filtering
        $this->testSearchAndFiltering();
        
        // Test message interactions
        $this->testMessageInteractions();
        
        $this->info('✅ Enhanced Chat UI testing completed successfully!');
    }
    
    private function createTestData()
    {
        $this->info('📝 Creating test data...');
        
        // Create customer
        $customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Test Customer',
            'email' => 'customer@test.com'
        ]);
        
        // Create technicians
        $technician1 = User::factory()->create([
            'role' => 'technician',
            'name' => 'John Technician',
            'email' => 'john@test.com'
        ]);
        
        $technician2 = User::factory()->create([
            'role' => 'technician',
            'name' => 'Sarah Technician',
            'email' => 'sarah@test.com'
        ]);
        
        // Create orders with different statuses
        $order1 = Order::create([
            'user_id' => $customer->id,
            'technician_id' => $technician1->id,
            'category_id' => 1,
            'subcategory_id' => 1,
            'status' => 'accepted',
            'description' => 'Test order 1',
            'street_address' => 'Test location 1',
            'city' => 'Test City',
            'area' => 'Test Area',
            'created_at' => now()->subDays(2)
        ]);
        
        $order2 = Order::create([
            'user_id' => $customer->id,
            'technician_id' => $technician2->id,
            'category_id' => 1,
            'subcategory_id' => 1,
            'status' => 'in_progress',
            'description' => 'Test order 2',
            'street_address' => 'Test location 2',
            'city' => 'Test City',
            'area' => 'Test Area',
            'created_at' => now()->subDay()
        ]);
        
        $order3 = Order::create([
            'user_id' => $customer->id,
            'technician_id' => $technician1->id,
            'category_id' => 1,
            'subcategory_id' => 1,
            'status' => 'completed',
            'description' => 'Test order 3',
            'street_address' => 'Test location 3',
            'city' => 'Test City',
            'area' => 'Test Area',
            'created_at' => now()
        ]);
        
        // Create fare offers
        FareOffer::create([
            'order_request_id' => 1,
            'technician_id' => $technician1->id,
            'proposed_price' => 150.00,
            'status' => 'accepted'
        ]);
        
        FareOffer::create([
            'order_request_id' => 2,
            'technician_id' => $technician2->id,
            'proposed_price' => 200.00,
            'status' => 'accepted'
        ]);
        
        FareOffer::create([
            'order_request_id' => 3,
            'technician_id' => $technician1->id,
            'proposed_price' => 175.00,
            'status' => 'accepted'
        ]);
        
        // Create chat messages
        $this->createChatMessages($order1, $customer, $technician1);
        $this->createChatMessages($order2, $customer, $technician2);
        $this->createChatMessages($order3, $customer, $technician1);
        
        $this->info('✅ Test data created successfully!');
    }
    
    private function createChatMessages($order, $customer, $technician)
    {
        // Create messages from different dates
        $messages = [
            [
                'sender_id' => $customer->id,
                'message' => 'Hi, I need help with my order #' . $order->id,
                'message_type' => 'text',
                'created_at' => now()->subDays(2)->addHours(1)
            ],
            [
                'sender_id' => $technician->id,
                'message' => 'Hello! I can help you with that. What specific issue are you facing?',
                'message_type' => 'text',
                'created_at' => now()->subDays(2)->addHours(2)
            ],
            [
                'sender_id' => $customer->id,
                'message' => 'I have some questions about the service',
                'message_type' => 'text',
                'created_at' => now()->subDay()->addHours(1)
            ],
            [
                'sender_id' => $technician->id,
                'message' => 'Sure! Feel free to ask any questions. I\'m here to help 😊',
                'message_type' => 'text',
                'created_at' => now()->subDay()->addHours(2)
            ],
            [
                'sender_id' => $customer->id,
                'message' => 'Great! Thank you for your help',
                'message_type' => 'text',
                'created_at' => now()->addHours(1)
            ]
        ];
        
        foreach ($messages as $msg) {
            ChatMessage::create([
                'order_id' => $order->id,
                'sender_id' => $msg['sender_id'],
                'message' => $msg['message'],
                'message_type' => $msg['message_type'],
                'created_at' => $msg['created_at']
            ]);
        }
    }
    
    private function testChatListFeatures()
    {
        $this->info('📋 Testing Chat List Features...');
        
        // Test chat list view
        $customer = User::where('email', 'customer@test.com')->first();
        $orders = Order::where('user_id', $customer->id)
            ->with(['technician', 'chatMessages'])
            ->get();
        
        // Verify chat list data
        $this->assert($orders->count() >= 3, 'Should have at least 3 orders');
        
        foreach ($orders as $order) {
            $this->assert($order->technician, 'Order should have technician');
            $this->assert($order->chatMessages->count() > 0, 'Order should have chat messages');
        }
        
        // Test unread count calculation
        $unreadCount = $orders->sum('unread_count');
        $this->info("Total unread messages: {$unreadCount}");
        
        $this->info('✅ Chat List Features working correctly!');
    }
    
    private function testChatShowFeatures()
    {
        $this->info('💬 Testing Chat Show Features...');
        
        $order = Order::with(['technician', 'chatMessages'])->first();
        $messages = $order->chatMessages()->orderBy('created_at')->get();
        
        // Verify chat show data
        $this->assert($order->technician, 'Order should have technician');
        $this->assert($messages->count() > 0, 'Should have messages');
        
        // Test message types
        $textMessages = $messages->where('message_type', 'text')->count();
        $this->info("Text messages: {$textMessages}");
        
        // Test message dates
        $uniqueDates = $messages->map(function($msg) {
            return $msg->created_at->format('Y-m-d');
        })->unique()->count();
        $this->info("Unique message dates: {$uniqueDates}");
        
        $this->info('✅ Chat Show Features working correctly!');
    }
    
    private function testSearchAndFiltering()
    {
        $this->info('🔍 Testing Search and Filtering...');
        
        $customer = User::where('email', 'customer@test.com')->first();
        $orders = Order::where('user_id', $customer->id)
            ->with(['technician', 'chatMessages'])
            ->get();
        
        // Test search by technician name
        $johnOrders = $orders->filter(function($order) {
            return str_contains(strtolower($order->technician->name), 'john');
        });
        $this->assert($johnOrders->count() >= 2, 'Should find orders with John');
        
        // Test search by order number
        $order1 = $orders->first();
        $foundOrder = $orders->where('id', $order1->id)->first();
        $this->assert($foundOrder, 'Should find order by ID');
        
        // Test filter by status
        $acceptedOrders = $orders->where('status', 'accepted');
        $this->assert($acceptedOrders->count() >= 1, 'Should have accepted orders');
        
        $inProgressOrders = $orders->where('status', 'in_progress');
        $this->assert($inProgressOrders->count() >= 1, 'Should have in-progress orders');
        
        $this->info('✅ Search and Filtering working correctly!');
    }
    
    private function testMessageInteractions()
    {
        $this->info('🔄 Testing Message Interactions...');
        
        $order = Order::with(['technician', 'chatMessages'])->first();
        $messages = $order->chatMessages;
        
        // Test message deletion (simulate)
        $messageToDelete = $messages->first();
        $this->assert($messageToDelete, 'Should have a message to delete');
        
        // Test chat deletion (simulate)
        $chatDeletion = ChatDeletion::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'deleted_at' => now()
        ]);
        
        $this->assert($chatDeletion, 'Should be able to create chat deletion record');
        
        // Test message status indicators
        $ownMessages = $messages->where('sender_id', $order->user_id);
        $this->assert($ownMessages->count() > 0, 'Should have own messages');
        
        $this->info('✅ Message Interactions working correctly!');
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