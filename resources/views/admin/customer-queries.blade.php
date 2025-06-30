@extends('admin.app')

@section('content')
<div class="flex flex-col flex-grow">
    <!-- Main Chat Container -->
    <div class="flex-1 flex bg-white overflow-hidden">
        <!-- Left Panel: Chat List -->
        <div class="w-80 border-r border-gray-300 bg-gray-50 flex flex-col flex-shrink-0">
            <!-- Search Bar -->
            <div class="p-4 bg-white border-b border-gray-200">
                <div class="relative">
                    <input type="text" placeholder="Search customers..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Chat List -->
            <div class="flex-1 overflow-y-auto">
                @php
                    $customers = [
                        ['id' => 1, 'name' => 'Umair Khan', 'last_message' => 'My AC is not working...', 'time' => '11:00 AM', 'unread' => 3, 'status' => 'online'],
                        ['id' => 2, 'name' => 'Aisha Bibi', 'last_message' => 'Service request for plumbing.', 'time' => 'Yesterday', 'unread' => 0, 'status' => 'offline'],
                        ['id' => 3, 'name' => 'Fahad Ahmed', 'last_message' => 'Query about oven repair.', 'time' => 'Tuesday', 'unread' => 1, 'status' => 'online'],
                    ];
                @endphp
                <ul>
                    @foreach($customers as $customer)
                        <li class="px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-200 transition-colors duration-200" onclick="loadChat({{ $customer['id'] }})">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold text-lg">
                                        {{ substr($customer['name'], 0, 1) }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full {{ $customer['status'] === 'online' ? 'bg-green-500' : 'bg-gray-400' }} border-2 border-white"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div class="font-semibold text-gray-800">{{ $customer['name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $customer['time'] }}</div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-500 truncate">{{ $customer['last_message'] }}</div>
                                        @if($customer['unread'] > 0)
                                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">{{ $customer['unread'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Right Panel: Chat Window -->
        <div class="flex-1 flex flex-col bg-gray-100">
            <!-- Chat Header -->
            <div class="p-4 bg-white border-b flex items-center gap-3 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold text-lg" id="chat-user-avatar">
                    U
                </div>
                <div class="flex-1">
                    <div class="font-semibold text-gray-800" id="chat-user-name">Select a customer to view chat</div>
                    <div class="text-sm text-gray-500" id="chat-user-status">offline</div>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-4">
                <!-- Messages will be loaded here -->
            </div>

            <!-- Chat Input -->
            <div class="p-4 bg-white border-t">
                <div class="flex items-center gap-2">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </button>
                    <input type="text" id="chat-input" class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </button>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadChat(id) {
        const names = {1: 'Umair Khan', 2: 'Aisha Bibi', 3: 'Fahad Ahmed'};
        const statuses = {1: 'online', 2: 'offline', 3: 'online'};
        const dummyMessages = {
            1: [
                {from: 'Customer', msg: 'My AC is not working properly.', time: '11:00 AM'},
                {from: 'Admin', msg: 'Could you please describe the issue in more detail?', time: '11:01 AM'},
                {from: 'Customer', msg: 'It\'s blowing warm air.', time: '11:02 AM'},
                {from: 'Admin', msg: 'Alright, I\'ve scheduled a technician to inspect it.', time: '11:03 AM'}
            ],
            2: [
                {from: 'Customer', msg: 'I need a plumber for a leaky faucet.', time: 'Yesterday'},
                {from: 'Admin', msg: 'Sure, can you confirm your address and preferred time?', time: 'Yesterday'},
                {from: 'Customer', msg: 'Yes, 123 Main St, tomorrow at 2 PM.', time: 'Yesterday'}
            ],
            3: [
                {from: 'Customer', msg: 'My oven is making a strange noise.', time: 'Tuesday'},
                {from: 'Admin', msg: 'Is it a buzzing or grinding sound?', time: 'Tuesday'}
            ]
        };

        // Update header
        document.getElementById('chat-user-name').innerText = names[id];
        document.getElementById('chat-user-status').innerText = statuses[id];
        document.getElementById('chat-user-avatar').innerText = names[id][0];

        // Update messages
        let messages = dummyMessages[id] || [];
        let chatBox = document.getElementById('chat-messages');
        chatBox.innerHTML = '';

        messages.forEach(m => {
            let isAdmin = m.from === 'Admin';
            let messageHtml = `
                <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'}">
                    <div class="flex flex-col max-w-[70%]">
                        <div class="flex items-end gap-2 ${isAdmin ? 'flex-row-reverse' : 'flex-row'}">
                            ${!isAdmin ? `<div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold text-sm">${names[id][0]}</div>` : ''}
                            <div class="${isAdmin ? 'bg-blue-500 text-white' : 'bg-white'} rounded-2xl px-4 py-2 shadow-sm">
                                ${m.msg}
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 ${isAdmin ? 'text-right' : 'text-left'}">
                            ${m.time}
                        </div>
                    </div>
                </div>
            `;
            chatBox.innerHTML += messageHtml;
        });

        // Scroll to bottom
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
@endsection
