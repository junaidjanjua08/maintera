@extends('admin.app')

@section('content')
<div class="flex h-[80vh] bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200">
    <!-- Left Panel: Chat List -->
    <div class="w-1/3 border-r border-gray-300 bg-gray-50 overflow-y-auto">
        <div class="p-4 text-lg font-semibold bg-green-600 text-white">Technician Queries</div>
        @php
            $technicians = [
                ['id' => 1, 'name' => 'Ali Raza', 'last_message' => 'Having an issue with wiring...'],
                ['id' => 2, 'name' => 'Sana Iqbal', 'last_message' => 'Need help with AC installation.'],
            ];
        @endphp
        <ul>
            @foreach($technicians as $tech)
                <li class="px-4 py-3 hover:bg-green-100 cursor-pointer border-b border-gray-200" onclick="loadChat({{ $tech['id'] }})">
                    <div class="font-semibold text-gray-800">{{ $tech['name'] }}</div>
                    <div class="text-sm text-gray-500 truncate">{{ $tech['last_message'] }}</div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Right Panel: Chat Window -->
    <div class="w-2/3 flex flex-col">
        <div class="p-4 border-b bg-green-600 text-white font-bold text-lg">
            <span id="chat-user-name">Select a technician to view chat</span>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-100">
            <!-- Messages will be loaded here -->
        </div>

        <div class="p-4 border-t bg-white flex gap-2">
            <input type="text" id="chat-input" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Type your message...">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Send</button>
        </div>
    </div>
</div>

<script>
    function loadChat(id) {
        // You can make an AJAX request here to load real data
        const names = {1: 'Ali Raza', 2: 'Sana Iqbal'};
        const dummyMessages = {
            1: [
                {from: 'Technician', msg: 'Having an issue with wiring...'},
                {from: 'Admin', msg: 'Sure, I’ll help you with that.'}
            ],
            2: [
                {from: 'Technician', msg: 'Need help with AC installation.'},
                {from: 'Admin', msg: 'Please explain the issue in detail.'}
            ]
        };

        document.getElementById('chat-user-name').innerText = names[id];
        let messages = dummyMessages[id] || [];
        let chatBox = document.getElementById('chat-messages');
        chatBox.innerHTML = '';

        messages.forEach(m => {
            let align = m.from === 'Admin' ? 'text-right' : 'text-left';
            let bg = m.from === 'Admin' ? 'bg-green-200' : 'bg-white';
            chatBox.innerHTML += `<div class="${align}"><span class="inline-block px-4 py-2 ${bg} rounded-lg shadow">${m.msg}</span></div>`;
        });
    }
</script>
@endsection
