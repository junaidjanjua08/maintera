@extends('admin.app')

@section('content')
<div class="h-screen flex flex-col bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Customer Support Chat</h1>
                    <p class="text-sm text-gray-600">Manage and respond to customer queries in real-time</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Online: <span id="online-count">2</span></span>
                </div>
                <button onclick="refreshChats()" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Main Chat Container -->
    <div class="flex-1 flex bg-white overflow-hidden">
        <!-- Left Panel: Chat List -->
        <div class="w-1/3 border-r border-gray-200 bg-white flex flex-col">
            <!-- Enhanced Search Bar -->
            <div class="p-4 bg-gray-50 border-b border-gray-200">
                <div class="relative">
                    <input type="text" id="search-customers" placeholder="Search customers..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Filter Tabs -->
                <div class="flex space-x-1 mt-3">
                    <button class="filter-tab active px-3 py-1 text-sm font-medium rounded-lg transition-colors" data-filter="all">
                        All
                    </button>
                    <button class="filter-tab px-3 py-1 text-sm font-medium rounded-lg transition-colors" data-filter="online">
                        Online
                    </button>
                    <button class="filter-tab px-3 py-1 text-sm font-medium rounded-lg transition-colors" data-filter="unread">
                        Unread
                    </button>
                </div>
            </div>

            <!-- Enhanced Chat List -->
            <div class="flex-1 overflow-y-auto" id="chat-list">
                @php
                    $customers = [
                        [
                            'id' => 1, 
                            'name' => 'Umair Khan', 
                            'last_message' => 'My AC is not working properly...', 
                            'time' => '11:00 AM', 
                            'unread' => 3, 
                            'status' => 'online',
                            'avatar' => 'UK',
                            'typing' => false,
                            'last_seen' => 'Just now'
                        ],
                        [
                            'id' => 2, 
                            'name' => 'Aisha Bibi', 
                            'last_message' => 'Service request for plumbing.', 
                            'time' => 'Yesterday', 
                            'unread' => 0, 
                            'status' => 'offline',
                            'avatar' => 'AB',
                            'typing' => false,
                            'last_seen' => '2 hours ago'
                        ],
                        [
                            'id' => 3, 
                            'name' => 'Fahad Ahmed', 
                            'last_message' => 'Query about oven repair.', 
                            'time' => 'Tuesday', 
                            'unread' => 1, 
                            'status' => 'online',
                            'avatar' => 'FA',
                            'typing' => true,
                            'last_seen' => 'Just now'
                        ],
                        [
                            'id' => 4, 
                            'name' => 'Sara Khan', 
                            'last_message' => 'Need help with electrical wiring.', 
                            'time' => 'Monday', 
                            'unread' => 0, 
                            'status' => 'offline',
                            'avatar' => 'SK',
                            'typing' => false,
                            'last_seen' => '1 day ago'
                        ],
                        [
                            'id' => 5, 
                            'name' => 'Ahmed Ali', 
                            'last_message' => 'Thank you for the excellent service!', 
                            'time' => 'Sunday', 
                            'unread' => 0, 
                            'status' => 'online',
                            'avatar' => 'AA',
                            'typing' => false,
                            'last_seen' => 'Just now'
                        ]
                    ];
                @endphp
                
                <div class="space-y-1 p-2">
                    @foreach($customers as $customer)
                        <div class="chat-item p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200 border-l-4 border-transparent hover:border-blue-500" 
                             data-id="{{ $customer['id'] }}" 
                             data-name="{{ $customer['name'] }}" 
                             data-status="{{ $customer['status'] }}"
                             onclick="loadChat({{ $customer['id'] }}, '{{ $customer['name'] }}', '{{ $customer['status'] }}', '{{ $customer['avatar'] }}')">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center text-blue-600 font-semibold text-lg shadow-sm">
                                        {{ $customer['avatar'] }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full {{ $customer['status'] === 'online' ? 'bg-green-500' : 'bg-gray-400' }} border-2 border-white shadow-sm"></span>
                                    @if($customer['typing'])
                                        <div class="absolute -top-1 -left-1 w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center">
                                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-semibold text-gray-800 truncate">{{ $customer['name'] }}</div>
                                        <div class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $customer['time'] }}</div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600 truncate flex-1">
                                            @if($customer['typing'])
                                                <span class="text-blue-600 italic">typing...</span>
                                            @else
                                                {{ $customer['last_message'] }}
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2 ml-2">
                                            @if($customer['unread'] > 0)
                                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full min-w-[20px] text-center">{{ $customer['unread'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $customer['last_seen'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Panel: Enhanced Chat Window -->
        <div class="flex-1 flex flex-col bg-gray-50">
            <!-- Enhanced Chat Header -->
            <div class="p-4 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center text-blue-600 font-semibold text-lg shadow-sm" id="chat-user-avatar">
                                <span>👤</span>
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-gray-400 border-2 border-white" id="chat-user-status-indicator"></span>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-800 text-lg" id="chat-user-name">Select a customer to start chatting</div>
                            <div class="text-sm text-gray-500 flex items-center gap-2" id="chat-user-status">
                                <span>Choose from the list</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors" title="Voice Call">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors" title="Video Call">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors" title="More Options">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Chat Messages -->
            <div id="chat-messages" class="flex-1 p-6 overflow-y-auto space-y-4 bg-gradient-to-b from-gray-50 to-white">
                <!-- Welcome Message -->
                <div class="text-center py-8" id="welcome-message">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Welcome to Customer Support</h3>
                    <p class="text-gray-600">Select a customer from the list to start chatting and provide support.</p>
                </div>
            </div>

            <!-- Enhanced Chat Input -->
            <div class="p-4 bg-white border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors" title="Emoji">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors" title="Attach File">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </button>
                    <div class="flex-1 relative">
                        <input type="text" id="chat-input" 
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="Type your message..." 
                               disabled>
                        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600" title="Voice Message">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                            </svg>
                        </button>
                    </div>
                    <button id="send-button" 
                            class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-xl transition-colors disabled:opacity-50 disabled:cursor-not-allowed" 
                            disabled>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Typing Indicator -->
                <div id="typing-indicator" class="hidden mt-2 text-sm text-gray-500">
                    <span class="typing-dots">
                        <span class="dot">●</span>
                        <span class="dot">●</span>
                        <span class="dot">●</span>
                    </span>
                    <span class="ml-2">Customer is typing...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.filter-tab {
    @apply text-gray-600 hover:text-gray-800 hover:bg-gray-200;
}

.filter-tab.active {
    @apply bg-blue-100 text-blue-700;
}

.chat-item.active {
    @apply bg-blue-50 border-l-blue-500;
}

.typing-dots .dot {
    animation: typing 1.4s infinite ease-in-out;
    display: inline-block;
}

.typing-dots .dot:nth-child(1) { animation-delay: -0.32s; }
.typing-dots .dot:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% { opacity: 0.3; }
    40% { opacity: 1; }
}

.message-bubble {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
let currentChatId = null;
let currentCustomerName = '';
let currentCustomerStatus = '';

// Enhanced chat loading function
function loadChat(id, name, status, avatar) {
    currentChatId = id;
    currentCustomerName = name;
    currentCustomerStatus = status;
    
    // Update active chat item
    document.querySelectorAll('.chat-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelector(`[data-id="${id}"]`).classList.add('active');
    
    // Update header
    document.getElementById('chat-user-name').innerText = name;
    document.getElementById('chat-user-status').innerText = status === 'online' ? 'Online' : 'Offline';
    document.getElementById('chat-user-avatar').innerText = avatar;
    document.getElementById('chat-user-status-indicator').className = 
        `absolute bottom-0 right-0 w-3 h-3 rounded-full ${status === 'online' ? 'bg-green-500' : 'bg-gray-400'} border-2 border-white`;
    
    // Enable input
    document.getElementById('chat-input').disabled = false;
    document.getElementById('send-button').disabled = false;
    
    // Load messages
    loadMessages(id);
    
    // Hide welcome message
    document.getElementById('welcome-message').style.display = 'none';
}

// Load messages for a specific chat
function loadMessages(chatId) {
    const dummyMessages = {
        1: [
            {from: 'customer', msg: 'Hello, my AC is not working properly.', time: '11:00 AM', status: 'read'},
            {from: 'admin', msg: 'Hi Umair! Could you please describe the issue in more detail?', time: '11:01 AM', status: 'read'},
            {from: 'customer', msg: 'It\'s blowing warm air instead of cold air.', time: '11:02 AM', status: 'read'},
            {from: 'admin', msg: 'I understand. This could be a refrigerant issue or compressor problem.', time: '11:03 AM', status: 'read'},
            {from: 'customer', msg: 'Can you send a technician to check it?', time: '11:04 AM', status: 'delivered'},
            {from: 'admin', msg: 'Absolutely! I\'ve scheduled a technician for tomorrow at 2 PM. Is that convenient?', time: '11:05 AM', status: 'sent'}
        ],
        2: [
            {from: 'customer', msg: 'I need a plumber for a leaky faucet.', time: 'Yesterday', status: 'read'},
            {from: 'admin', msg: 'Hello Aisha! Sure, can you confirm your address and preferred time?', time: 'Yesterday', status: 'read'},
            {from: 'customer', msg: 'Yes, 123 Main St, tomorrow at 2 PM would be perfect.', time: 'Yesterday', status: 'read'},
            {from: 'admin', msg: 'Perfect! I\'ve booked the appointment. The technician will call you 30 minutes before arrival.', time: 'Yesterday', status: 'read'}
        ],
        3: [
            {from: 'customer', msg: 'My oven is making a strange noise when I turn it on.', time: 'Tuesday', status: 'read'},
            {from: 'admin', msg: 'Hi Fahad! Is it a buzzing or grinding sound?', time: 'Tuesday', status: 'read'},
            {from: 'customer', msg: 'It\'s more like a buzzing sound.', time: 'Tuesday', status: 'read'},
            {from: 'admin', msg: 'That sounds like a fan motor issue. Let me schedule a technician for you.', time: 'Tuesday', status: 'delivered'}
        ],
        4: [
            {from: 'customer', msg: 'Need help with electrical wiring in my kitchen.', time: 'Monday', status: 'read'},
            {from: 'admin', msg: 'Hello Sara! What specific electrical issue are you experiencing?', time: 'Monday', status: 'read'},
            {from: 'customer', msg: 'The outlets are not working properly and there\'s a burning smell.', time: 'Monday', status: 'read'},
            {from: 'admin', msg: 'That sounds serious! I\'ll send an electrician immediately for safety inspection.', time: 'Monday', status: 'read'}
        ],
        5: [
            {from: 'customer', msg: 'Thank you for the excellent service! The technician was very professional.', time: 'Sunday', status: 'read'},
            {from: 'admin', msg: 'Thank you Ahmed! We\'re glad to hear that. How is everything working now?', time: 'Sunday', status: 'read'},
            {from: 'customer', msg: 'Perfect! Everything is working great. Will definitely recommend your services.', time: 'Sunday', status: 'read'},
            {from: 'admin', msg: 'That\'s wonderful to hear! Thank you for choosing our services.', time: 'Sunday', status: 'delivered'}
        ]
    };

    const messages = dummyMessages[chatId] || [];
    const chatBox = document.getElementById('chat-messages');
    chatBox.innerHTML = '';

    messages.forEach(m => {
        const isAdmin = m.from === 'admin';
        const messageHtml = createMessageHTML(m, isAdmin);
        chatBox.innerHTML += messageHtml;
    });

    // Scroll to bottom
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Create message HTML
function createMessageHTML(message, isAdmin) {
    const statusIcon = getStatusIcon(message.status);
    const timeClass = isAdmin ? 'text-right' : 'text-left';
    const messageClass = isAdmin ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200';
    
    return `
        <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'} message-bubble">
            <div class="flex flex-col max-w-[70%]">
                <div class="flex items-end gap-2 ${isAdmin ? 'flex-row-reverse' : 'flex-row'}">
                    ${!isAdmin ? `<div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center text-blue-600 font-semibold text-sm shadow-sm">${currentCustomerName.charAt(0)}</div>` : ''}
                    <div class="${messageClass} rounded-2xl px-4 py-3 shadow-sm">
                        <div class="text-sm">${message.msg}</div>
                        <div class="flex items-center justify-end gap-1 mt-1">
                            <span class="text-xs ${isAdmin ? 'text-blue-200' : 'text-gray-400'}">${message.time}</span>
                            ${isAdmin ? statusIcon : ''}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Get status icon
function getStatusIcon(status) {
    switch(status) {
        case 'sent':
            return '<svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>';
        case 'delivered':
            return '<svg class="w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
        case 'read':
            return '<svg class="w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
        default:
            return '';
    }
}

// Send message
function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    if (!message || !currentChatId) return;
    
    const chatBox = document.getElementById('chat-messages');
    const newMessage = {
        from: 'admin',
        msg: message,
        time: new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true }),
        status: 'sent'
    };
    
    const messageHtml = createMessageHTML(newMessage, true);
    chatBox.innerHTML += messageHtml;
    
    // Clear input
    input.value = '';
    
    // Scroll to bottom
    chatBox.scrollTop = chatBox.scrollHeight;
    
    // Simulate message delivery and read
    setTimeout(() => {
        updateMessageStatus(chatBox.lastElementChild, 'delivered');
    }, 1000);
    
    setTimeout(() => {
        updateMessageStatus(chatBox.lastElementChild, 'read');
    }, 2000);
}

// Update message status
function updateMessageStatus(messageElement, status) {
    const statusIcon = messageElement.querySelector('svg');
    if (statusIcon) {
        statusIcon.outerHTML = getStatusIcon(status);
    }
}

// Search functionality
document.getElementById('search-customers').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        const name = item.querySelector('.font-semibold').textContent.toLowerCase();
        if (name.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});

// Filter functionality
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const chatItems = document.querySelectorAll('.chat-item');
        
        chatItems.forEach(item => {
            const status = item.dataset.status;
            const unread = item.querySelector('.bg-red-500');
            
            let show = true;
            if (filter === 'online' && status !== 'online') show = false;
            if (filter === 'unread' && !unread) show = false;
            
            item.style.display = show ? 'block' : 'none';
        });
    });
});

// Send message on Enter key
document.getElementById('chat-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

// Send button click
document.getElementById('send-button').addEventListener('click', sendMessage);

// Refresh chats
function refreshChats() {
    // Simulate refresh
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    
    button.innerHTML = `
        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Refreshing...
    `;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        // Here you would typically reload chat data
    }, 1000);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set initial online count
    const onlineCount = document.querySelectorAll('[data-status="online"]').length;
    document.getElementById('online-count').textContent = onlineCount;
});
</script>
@endsection
