    @extends('index')

@section('content')
<style>
    .chat-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 20px 0;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        height: 85vh;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        background: linear-gradient(135deg, #FDA12B 0%, #FF8C42 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .chat-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .chat-header-content {
        position: relative;
        z-index: 1;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
        scroll-behavior: smooth;
    }
    
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .chat-messages::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .message-bubble {
        max-width: 75%;
        margin-bottom: 1.5rem;
        padding: 1rem 1.25rem;
        border-radius: 20px;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .message-bubble:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .message-own {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 6px;
        position: relative;
    }
    
    .message-own::before {
        content: '';
        position: absolute;
        bottom: 0;
        right: -8px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-left-color: #667eea;
        border-bottom: none;
        border-right: none;
    }

    .message-other {
        background: white;
        color: #333;
        border: 1px solid #e9ecef;
        margin-right: auto;
        border-bottom-left-radius: 6px;
        position: relative;
    }
    
    .message-other::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: -8px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-right-color: white;
        border-bottom: none;
        border-left: none;
    }

    .chat-input {
        background: white;
        border-top: 1px solid #e9ecef;
        padding: 1.25rem;
        flex-shrink: 0;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .input-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f9fa;
        border-radius: 25px;
        padding: 8px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .input-container:focus-within {
        border-color: #FDA12B;
        background: white;
        box-shadow: 0 0 0 3px rgba(253, 161, 43, 0.1);
    }

    .file-upload-btn {
        background: #e9ecef;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .file-upload-btn:hover {
        background: #FDA12B;
        color: white;
        transform: scale(1.1);
    }

    .message-input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 12px 16px;
        font-size: 14px;
        outline: none;
        resize: none;
        max-height: 100px;
        min-height: 20px;
    }

    .send-btn {
        background: linear-gradient(135deg, #FDA12B 0%, #FF8C42 100%);
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(253, 161, 43, 0.3);
    }

    .send-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 16px rgba(253, 161, 43, 0.4);
    }
    
    .send-btn:disabled {
        opacity: 0.6;
        transform: none;
        cursor: not-allowed;
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .message-time {
        font-size: 11px;
        opacity: 0.7;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .message-status {
        font-size: 10px;
        margin-left: 4px;
    }

    .file-message {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.1);
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 8px;
    }

    .file-icon {
        font-size: 28px;
        opacity: 0.8;
    }
    
    .file-info {
        flex: 1;
    }
    
    .file-name {
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .file-size {
        font-size: 12px;
        opacity: 0.7;
    }

    .image-message img {
        max-width: 250px;
        border-radius: 12px;
        margin-bottom: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .image-message img:hover {
        transform: scale(1.02);
    }

    .typing-indicator {
        display: none;
        padding: 12px 20px;
        background: white;
        border-radius: 20px;
        margin-bottom: 15px;
        max-width: 80px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .typing-dots {
        display: flex;
        gap: 4px;
        justify-content: center;
    }

    .typing-dot {
        width: 8px;
        height: 8px;
        background: #6c757d;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }

    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes typing {
        0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
        40% { transform: scale(1); opacity: 1; }
    }

    .unread-badge {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        position: absolute;
        top: -5px;
        right: -5px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .message-actions {
        position: absolute;
        top: 8px;
        right: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        gap: 4px;
    }

    .message-bubble:hover .message-actions {
        opacity: 1;
    }

    .delete-message-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: rgba(255, 255, 255, 0.9);
        font-size: 12px;
        padding: 4px 6px;
        border-radius: 4px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .delete-message-btn:hover {
        color: white;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .message-bubble {
        position: relative;
    }
    
    .message-date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    
    .message-date-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e9ecef;
        z-index: 1;
    }
    
    .message-date-divider span {
        background: #f8f9fa;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
        position: relative;
        z-index: 2;
        border: 1px solid #e9ecef;
    }
    
    .chat-info-panel {
        background: rgba(255, 255, 255, 0.1);
        padding: 12px 16px;
        border-radius: 12px;
        margin-top: 12px;
        backdrop-filter: blur(10px);
    }
    
    .chat-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .chat-info-item:last-child {
        margin-bottom: 0;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-accepted {
        background: #d4edda;
        color: #155724;
    }
    
    .status-in-progress {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .emoji-picker {
        position: absolute;
        bottom: 100%;
        left: 0;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        display: none;
        z-index: 1000;
        max-width: 300px;
    }
    
    .emoji-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 8px;
    }
    
    .emoji-btn {
        background: none;
        border: none;
        font-size: 20px;
        padding: 4px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    
    .emoji-btn:hover {
        background: #f8f9fa;
    }
    
    @media (max-width: 768px) {
        .chat-container {
            margin: 10px;
            height: 90vh;
            border-radius: 16px;
        }
        
        .message-bubble {
            max-width: 85%;
        }
        
        .image-message img {
            max-width: 200px;
        }
        
        .chat-input {
            padding: 1rem;
        }
        
        .input-container {
            padding: 6px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="chat-container">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="chat-header-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('customer.chat.index') }}" class="back-btn me-3">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <div>
                                    <h4 class="mb-0">Order #{{ $order->id }}</h4>
                                    <p class="mb-0 opacity-75">{{ $order->technician->name ?? 'Technician' }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="chat-info-panel">
                                    <div class="chat-info-item">
                                        <span>Status:</span>
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                    <div class="chat-info-item">
                                        <span>Price:</span>
                                        <span>${{ $acceptedOffer->proposed_price }}</span>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-light delete-chat-btn" 
                                        data-order-id="{{ $order->id }}" 
                                        title="Delete entire chat">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="chat-messages" id="chat-messages">
                    @php
                        $currentDate = null;
                    @endphp
                    
                    @foreach($messages as $message)
                        @php
                            $messageDate = $message->created_at->format('Y-m-d');
                            if ($currentDate !== $messageDate) {
                                $currentDate = $messageDate;
                                echo '<div class="message-date-divider"><span>' . $message->created_at->format('F j, Y') . '</span></div>';
                            }
                        @endphp
                        
                        <div class="d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3" data-message-id="{{ $message->id }}">
                            <div class="message-bubble {{ $message->sender_id === auth()->id() ? 'message-own' : 'message-other' }}">
                                @if($message->sender_id === auth()->id())
                                    <div class="message-actions">
                                        <button class="delete-message-btn" 
                                                data-message-id="{{ $message->id }}" 
                                                title="Delete message">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                @endif
                                
                                @if($message->message_type === 'text')
                                    <p class="mb-0">{{ $message->message }}</p>
                                @elseif($message->message_type === 'image')
                                    <div class="image-message">
                                        <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image" class="img-fluid">
                                        @if($message->message)
                                            <p class="mb-0">{{ $message->message }}</p>
                                        @endif
                                    </div>
                                @elseif($message->message_type === 'file')
                                    <div class="file-message">
                                        <span class="file-icon">{{ $message->getFileIcon() }}</span>
                                        <div class="file-info">
                                            <div class="file-name">{{ $message->file_name }}</div>
                                            <div class="file-size">{{ $message->file_size }}</div>
                                        </div>
                                        <a href="{{ route('customer.chat.download', $message) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                    @if($message->message)
                                        <p class="mb-0 mt-2">{{ $message->message }}</p>
                                    @endif
                                @endif
                                
                                <div class="message-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $message->created_at->format('g:i A') }}
                                    @if($message->sender_id === auth()->id())
                                        <span class="message-status">
                                            <i class="fas fa-check-double"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Typing Indicator -->
                    <div class="typing-indicator" id="typing-indicator">
                        <div class="typing-dots">
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="chat-input">
                    <form id="chat-form">
                        <div class="input-container">
                            <button type="button" id="file-btn" class="file-upload-btn" title="Attach file">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <textarea id="message-input" name="message" 
                                      class="message-input" 
                                      placeholder="Type your message..." 
                                      rows="1"
                                      maxlength="1000"></textarea>
                            <button type="button" id="emoji-btn" class="file-upload-btn" title="Add emoji">
                                <i class="fas fa-smile"></i>
                            </button>
                            <button type="submit" class="send-btn" id="send-btn" disabled>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <input type="file" id="file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.txt">
                    </form>
                    
                    <!-- Emoji Picker -->
                    <div class="emoji-picker" id="emoji-picker">
                        <div class="emoji-grid">
                            😀 😃 😄 😁 😆 😅 🤣 😂 😊 😇 🙂 🙃 😉 😌 😍 🥰 😘 😗 😙 😚 😋 😛 😝 😜 🤪 🤨 🧐 🤓 😎 🤩 🥳 😏 😒 😞 😔 😟 😕 🙁 ☹️ 😣 😖 😫 😩 🥺 😢 😭 😤 😠 😡 🤬 🤯 😳 🥵 🥶 😱 😨 😰 😥 😓 🤗 🤔 🤭 🤫 🤥 😶 😐 😑 😯 😦 😧 😮 😲 🥱 😴 🤤 😪 😵 🤐 🥴 🤢 🤮 🤧 😷 🤒 🤕
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};
let isTyping = false;

// Scroll to bottom of chat
function scrollToBottom() {
        const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Send message
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
        const formData = new FormData(this);
        const messageInput = document.getElementById('message-input');
        const fileInput = document.getElementById('file-input');
        
        if (!messageInput.value.trim() && !fileInput.files.length) return;
        
        // Add file if selected
        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
            formData.append('message_type', fileInput.files[0].type.startsWith('image/') ? 'image' : 'file');
        }
        
        fetch('{{ route("customer.chat.send", $order) }}', {
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
    .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                fileInput.value = '';
                addMessage(data.message);
                scrollToBottom();
            } else {
            Swal.fire({
                icon: 'error',
                title: 'Send Error',
                text: 'Failed to send message. Please try again.'
            });
            }
        })
        .catch(error => {
        console.error('Error sending message:', error);
        Swal.fire({
            icon: 'error',
            title: 'Send Error',
            text: 'Failed to send message. Please try again.'
        });
    });
});

// File upload
document.getElementById('file-btn').addEventListener('click', function() {
    document.getElementById('file-input').click();
});

document.getElementById('file-input').addEventListener('change', function() {
    if (this.files.length > 0) {
        const file = this.files[0];
        const messageInput = document.getElementById('message-input');
        messageInput.placeholder = `File selected: ${file.name}`;
    }
});

// Add message to chat (comprehensive version for all message additions)
function addMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    const isOwnMessage = message.sender_id === {{ auth()->id() }};
    const messageDate = new Date(message.created_at).toDateString();
    
    // Check if we need to add a date divider
    const lastMessage = chatMessages.lastElementChild;
    if (lastMessage && !lastMessage.classList.contains('message-date-divider')) {
        const lastMessageDate = lastMessage.querySelector('.message-time');
        if (lastMessageDate) {
            const lastDate = new Date(lastMessageDate.textContent).toDateString();
            if (messageDate !== lastDate) {
                const dateDivider = `
                    <div class="message-date-divider">
                        <span>${new Date(message.created_at).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</span>
                    </div>
                `;
                chatMessages.insertAdjacentHTML('beforeend', dateDivider);
            }
        }
    }
    
    const deleteButton = isOwnMessage ? `
        <div class="message-actions">
            <button class="delete-message-btn" 
                    data-message-id="${message.id}" 
                    title="Delete message">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    ` : '';
    
    const messageStatus = isOwnMessage ? `
        <span class="message-status">
            <i class="fas fa-check-double"></i>
        </span>
    ` : '';
    
    const messageHtml = `
        <div class="d-flex ${isOwnMessage ? 'justify-content-end' : 'justify-content-start'} mb-3" data-message-id="${message.id}">
            <div class="message-bubble ${isOwnMessage ? 'message-own' : 'message-other'}">
                ${deleteButton}
                ${getMessageContent(message)}
                <div class="message-time">
                    <i class="fas fa-clock"></i>
                    ${new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}
                    ${messageStatus}
                </div>
            </div>
        </div>
    `;
    
    chatMessages.insertAdjacentHTML('beforeend', messageHtml);
    lastMessageId = message.id;
    
    // Add hover effects to new message
    const newMessage = chatMessages.lastElementChild;
    newMessage.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-1px)';
    });
    
    newMessage.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
}

// Get message content based on type
function getMessageContent(message) {
    switch(message.message_type) {
        case 'text':
            return `<p class="mb-0">${message.message}</p>`;
        case 'image':
            return `
                <div class="image-message">
                    <img src="/storage/${message.file_path}" alt="Image" class="img-fluid">
                    ${message.message ? `<p class="mb-0">${message.message}</p>` : ''}
                </div>
            `;
        case 'file':
            return `
                <div class="file-message">
                    <span class="file-icon">${getFileIcon(message.file_name)}</span>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-bold">${message.file_name}</p>
                        <small class="opacity-75">${formatFileSize(message.file_size)}</small>
                    </div>
                    <a href="/customer/chat/message/${message.id}/download" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                ${message.message ? `<p class="mb-0 mt-2">${message.message}</p>` : ''}
            `;
        default:
            return `<p class="mb-0">${message.message}</p>`;
    }
}

// Get file icon
function getFileIcon(filename) {
    const extension = filename.split('.').pop().toLowerCase();
    const icons = {
        'pdf': '📄',
        'doc': '📝', 'docx': '📝',
        'xls': '📊', 'xlsx': '📊',
        'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️',
        'txt': '📄',
        'zip': '📦', 'rar': '📦'
    };
    return icons[extension] || '📎';
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Poll for new messages
function pollNewMessages() {
    fetch(`{{ route('customer.chat.messages', $order) }}?last_message_id=${lastMessageId}`)
    .then(response => response.json())
    .then(data => {
        if (data.messages.length > 0) {
            data.messages.forEach(message => {
                addMessage(message);
            });
            scrollToBottom();
            // Update navbar notification count
            updateNavbarNotificationCount();
        }
    })
    .catch(error => {
        console.error('Error polling messages:', error);
    });
}

// Update navbar notification count
function updateNavbarNotificationCount() {
    fetch('{{ route("customer.chat.notification-count") }}')
    .then(response => response.json())
    .then(data => {
        const chatLink = document.querySelector('a[href="{{ route("customer.chat.index") }}"]');
        let badge = chatLink.querySelector('.badge');
        
        if (data.count > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                badge.style.cssText = 'font-size: 0.6rem; transform: translate(-50%, -50%);';
                chatLink.appendChild(badge);
            }
            badge.textContent = data.count;
        } else if (badge) {
            badge.remove();
        }
    })
    .catch(error => {
        console.error('Error updating notification count:', error);
    });
}

// Poll every 3 seconds
setInterval(pollNewMessages, 3000);

// Delete message functionality
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-message-btn')) {
        e.preventDefault();
        const messageId = e.target.closest('.delete-message-btn').dataset.messageId;
        deleteMessage(messageId);
    }
    
    if (e.target.closest('.delete-chat-btn')) {
        e.preventDefault();
        const orderId = e.target.closest('.delete-chat-btn').dataset.orderId;
        deleteEntireChat(orderId);
    }
});

function deleteMessage(messageId) {
    Swal.fire({
        title: 'Delete Message?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/customer/chat/message/${messageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the message with animation
                    const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
                    if (messageElement) {
                        messageElement.style.transition = 'all 0.3s ease';
                        messageElement.style.transform = 'translateX(-100%)';
                        messageElement.style.opacity = '0';
                        
                        setTimeout(() => {
                            messageElement.remove();
                        }, 300);
                    }
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Message has been deleted.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    throw new Error(data.error || 'Failed to delete message');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Failed to delete message'
                });
            });
        }
    });
}

function deleteEntireChat(orderId) {
    Swal.fire({
        title: 'Delete Entire Chat?',
        text: "This will delete the entire chat conversation. This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/customer/chat/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Chat has been deleted successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Redirect to chat list
                        window.location.href = '{{ route("customer.chat.index") }}';
                    });
                } else {
                    throw new Error(data.error || 'Failed to delete chat');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Failed to delete chat'
                });
            });
        }
    });
}

// Enhanced message input functionality
const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');

messageInput.addEventListener('input', function() {
    // Auto-resize textarea
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 100) + 'px';
    
    // Enable/disable send button
    sendBtn.disabled = !this.value.trim();
    
    // Show typing indicator
    if (this.value.trim()) {
        showTypingIndicator();
    } else {
        hideTypingIndicator();
    }
});

messageInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        if (!sendBtn.disabled) {
            document.getElementById('chat-form').dispatchEvent(new Event('submit'));
        }
    }
});

// Emoji picker functionality
const emojiBtn = document.getElementById('emoji-btn');
const emojiPicker = document.getElementById('emoji-picker');

emojiBtn.addEventListener('click', function() {
    emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
});

// Close emoji picker when clicking outside
document.addEventListener('click', function(e) {
    if (!emojiBtn.contains(e.target) && !emojiPicker.contains(e.target)) {
        emojiPicker.style.display = 'none';
    }
});

// Add emoji to message
emojiPicker.addEventListener('click', function(e) {
    if (e.target.textContent && e.target.textContent.trim()) {
        const emoji = e.target.textContent.trim();
        const cursorPos = messageInput.selectionStart;
        const textBefore = messageInput.value.substring(0, cursorPos);
        const textAfter = messageInput.value.substring(cursorPos);
        
        messageInput.value = textBefore + emoji + textAfter;
        messageInput.selectionStart = messageInput.selectionEnd = cursorPos + emoji.length;
        
        // Trigger input event to update UI
        messageInput.dispatchEvent(new Event('input'));
        messageInput.focus();
    }
});

// Typing indicator functions
function showTypingIndicator() {
    if (!isTyping) {
        isTyping = true;
        const indicator = document.getElementById('typing-indicator');
        indicator.style.display = 'block';
        scrollToBottom();
    }
}

function hideTypingIndicator() {
    if (isTyping) {
        isTyping = false;
        const indicator = document.getElementById('typing-indicator');
        indicator.style.display = 'none';
    }
}

// Enhanced getMessageContent function
function getMessageContent(message) {
    switch(message.message_type) {
        case 'text':
            return `<p class="mb-0">${message.message}</p>`;
        case 'image':
            return `
                <div class="image-message">
                    <img src="/storage/${message.file_path}" alt="Image" class="img-fluid">
                    ${message.message ? `<p class="mb-0">${message.message}</p>` : ''}
                </div>
            `;
        case 'file':
            return `
                <div class="file-message">
                    <span class="file-icon">${getFileIcon(message.file_name)}</span>
                    <div class="file-info">
                        <div class="file-name">${message.file_name}</div>
                        <div class="file-size">${formatFileSize(message.file_size)}</div>
                    </div>
                    <a href="/customer/chat/message/${message.id}/download" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                ${message.message ? `<p class="mb-0 mt-2">${message.message}</p>` : ''}
            `;
        default:
            return `<p class="mb-0">${message.message}</p>`;
    }
}

// Enhanced scroll to bottom with smooth animation
function scrollToBottom() {
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.scrollTo({
        top: chatMessages.scrollHeight,
        behavior: 'smooth'
    });
}

// Add hover effects to existing messages
document.querySelectorAll('.message-bubble').forEach(bubble => {
    bubble.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-1px)';
    });
    
    bubble.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Initialize UI
messageInput.focus();
scrollToBottom();

// Auto-hide typing indicator after 3 seconds
setTimeout(hideTypingIndicator, 3000);
</script>
@endsection 