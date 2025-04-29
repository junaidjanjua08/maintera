@extends('admin.app')

@section('content')
<div class="flex h-[80vh] bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200">
    <!-- Left Panel: Chat List -->
    <div class="w-1/3 border-r border-gray-300 bg-gray-50 overflow-y-auto">
        <div class="p-4 text-lg font-semibold bg-blue-600 text-white">Customer Queries</div>
        @php
            $customers = [
                ['id' => 1, 'name' => 'Hassan Khan', 'last_message' => 'I need to schedule a maintenance...'],
                ['id' => 2, 'name' => 'Maria Shah', 'last_message' => 'Can someone check my AC unit?'],
            ];
        @endphp
        <ul>
            @foreach($customers as $customer)
                <li class="px-4 py-3 hover:bg-blue-100 cursor-pointer border-b border-gray-200" onclick="loadCustomerChat({{ $customer['id'] }})">
                    <div class="font-semibold text-gray-800">{{ $customer['name'] }}</div>
                    <div class="text-sm text-gray-500 truncate">{{ $customer['last_message'] }}</div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Right Panel: Chat Window -->
    <div class="w-2/3 flex flex-col">
        <div class="p-4 border-b bg-blue-600 text-white font-bold text-lg">
            <span id="customer-chat-user-name">Select a customer to view chat</span>
        </div>

        <div id="customer-chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-100">
            <!-- Messages will be loaded here -->
        </div>

        <div class="p-4 border-t bg-white flex gap-2">
            <input type="text" id="customer-chat-input" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Send</button>
        </div>
    </div>
</div>

<script>
    function loadCustomerChat(id) {
        const names = {1: 'Hassan Khan', 2: 'Maria Shah'};
        const dummyMessages = {
            1: [
                {from: 'Customer', msg: 'I need to schedule a maintenance...'},
                {from: 'Admin', msg: 'Sure, I’ll help you with that.'}
            ],
            2: [
                {from: 'Customer', msg: 'Can someone check my AC unit?'},
                {from: 'Admin', msg: 'Yes, we’ll send a technician shortly.'}
            ]
        };

        document.getElementById('customer-chat-user-name').innerText = names[id];
        let messages = dummyMessages[id] || [];
        let chatBox = document.getElementById('customer-chat-messages');
        chatBox.innerHTML = '';

        messages.forEach(m => {
            let align = m.from === 'Admin' ? 'text-right' : 'text-left';
            let bg = m.from === 'Admin' ? 'bg-blue-200' : 'bg-white';
            chatBox.innerHTML += `<div class="${align}"><span class="inline-block px-4 py-2 ${bg} rounded-lg shadow">${m.msg}</span></div>`;
        });
    }
</script>
@endsection
