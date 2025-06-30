@extends('admin.app')

@section('content')
<div class="h-screen flex flex-col">
    <!-- Main Chat Container -->
    <div class="flex-1 flex bg-white overflow-hidden w-full">
        <!-- Left Panel: Chat List -->
        <div class="w-1/4 border-r border-gray-300 bg-gray-50 flex flex-col">
            <!-- Search Bar -->
            <div class="p-4 bg-white border-b border-gray-200">
                <div class="relative">
                    <input type="text" placeholder="Search technicians..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
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
                    $technicians = [
                        ['id' => 1, 'name' => 'Ali Raza', 'last_message' => 'Having an issue with wiring...', 'time' => '10:30 AM', 'unread' => 2, 'status' => 'online'],
                        ['id' => 2, 'name' => 'Sana Iqbal', 'last_message' => 'Need help with AC installation.', 'time' => '9:45 AM', 'unread' => 0, 'status' => 'offline'],
                    ];
                @endphp
                <ul>
                    @foreach($technicians as $tech)
                        <li class="px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-200 transition-colors duration-200" onclick="loadChat({{ $tech['id'] }})">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold text-lg">
                                        {{ substr($tech['name'], 0, 1) }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full {{ $tech['status'] === 'online' ? 'bg-green-500' : 'bg-gray-400' }} border-2 border-white"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div class="font-semibold text-gray-800">{{ $tech['name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $tech['time'] }}</div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-500 truncate">{{ $tech['last_message'] }}</div>
                                        @if($tech['unread'] > 0)
                                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{ $tech['unread'] }}</span>
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
        <div class="w-3/4 flex flex-col bg-gray-100">
            <!-- Chat Header -->
            <div class="p-4 bg-white border-b flex items-center gap-3 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold text-lg" id="chat-user-avatar">
                    S
                </div>
                <div class="flex-1">
                    <div class="font-semibold text-gray-800" id="chat-user-name">Select a technician to view chat</div>
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
                    <input type="text" id="chat-input" class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Type your message...">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </button>
                    <button class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full">
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
        // You can make an AJAX request here to load real data
        const names = {1: 'Ali Raza', 2: 'Sana Iqbal'};
        const statuses = {1: 'online', 2: 'offline'};
        const dummyMessages = {
            1: [
                {from: 'Technician', msg: 'Having an issue with wiring...', time: '10:30 AM'},
                {from: 'Admin', msg: 'Sure, I\'ll help you with that.', time: '10:31 AM'},
                {from: 'Technician', msg: 'The circuit breaker keeps tripping.', time: '10:32 AM'},
                {from: 'Admin', msg: 'Have you checked the load on the circuit?', time: '10:33 AM'}
            ],
            2: [
                {from: 'Technician', msg: 'Need help with AC installation.', time: '9:45 AM'},
                {from: 'Admin', msg: 'Please explain the issue in detail.', time: '9:46 AM'},
                {from: 'Technician', msg: 'The unit is not cooling properly.', time: '9:47 AM'},
                {from: 'Admin', msg: 'Let me check the specifications.', time: '9:48 AM'}
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
                            ${!isAdmin ? `<div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-semibold text-sm">${names[id][0]}</div>` : ''}
                            <div class="${isAdmin ? 'bg-green-500 text-white' : 'bg-white'} rounded-2xl px-4 py-2 shadow-sm">
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
