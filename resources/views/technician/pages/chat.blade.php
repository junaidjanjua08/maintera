@extends('technician.index')

@section('content')
<style>
    .chat-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin: 20px 0;
    }

    .chat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        color: white;
        padding: 1.5rem;
    }

    .chat-messages {
        height: 60vh;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f8fafc;
    }

    .message-bubble {
        max-width: 70%;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
    }

    .message-own {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .message-other {
        background: white;
        color: #333;
        border: 1px solid #e9ecef;
        margin-right: auto;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .chat-input {
        background: white;
        border-top: 1px solid #e9ecef;
        padding: 1rem;
    }

    .file-upload-btn {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 8px 12px;
        cursor: pointer;
        transition: all 0.2s;
        color: #6c757d;
    }

    .file-upload-btn:hover {
        background: #e9ecef;
        color: #495057;
    }

    .send-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        color: white;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .send-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .message-time {
        font-size: 11px;
        opacity: 0.7;
        margin-top: 4px;
    }

    .file-message {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-icon {
        font-size: 24px;
    }

    .image-message img {
        max-width: 200px;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .typing-indicator {
        display: none;
        padding: 10px 16px;
        background: #e9ecef;
        border-radius: 18px;
        margin-bottom: 15px;
        max-width: 70px;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
    }

    .typing-dot {
        width: 6px;
        height: 6px;
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
        background: #dc3545;
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
    }

    .message-actions {
        position: absolute;
        top: 5px;
        right: 10px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .message-bubble:hover .message-actions {
        opacity: 1;
    }

    .delete-message-btn {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        font-size: 12px;
        padding: 2px 4px;
        border-radius: 3px;
        transition: all 0.2s ease;
    }

    .delete-message-btn:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
    }

    .message-bubble {
        position: relative;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="chat-container">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('technician.chat.index') }}" class="back-btn me-3">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <div>
                                <h4 class="mb-0">Order #{{ $order->id }}</h4>
                                <p class="mb-0 opacity-75">{{ $order->customer->name }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success">Accepted: ${{ $acceptedOffer->proposed_price }}</span>
                            <button class="btn btn-sm btn-outline-light delete-chat-btn" 
                                    data-order-id="{{ $order->id }}" 
                                    title="Delete entire chat">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="chat-messages" id="chat-messages">
                    @foreach($messages as $message)
                    <div class="d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3" data-message-id="{{ $message->id }}">
                        <div class="message-bubble {{ $message->sender_id === auth()->id() ? 'message-own' : 'message-other' }}">
                            @if($message->sender_id === auth()->id())
                                <div class="message-actions">
                                    <button class="btn btn-sm btn-link text-white p-0 me-2 delete-message-btn" 
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
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-bold">{{ $message->file_name }}</p>
                                        <small class="opacity-75">{{ $message->file_size }}</small>
                                    </div>
                                    <a href="{{ route('technician.chat.download', $message) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                @if($message->message)
                                    <p class="mb-0 mt-2">{{ $message->message }}</p>
                                @endif
                            @endif
                            <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
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
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-grow-1 position-relative">
                                <input type="text" id="message-input" name="message" 
                                       class="form-control" 
                                       placeholder="Type your message..." required>
                                
                                <button type="button" id="file-btn" class="file-upload-btn position-absolute" 
                                        style="right: 10px; top: 50%; transform: translateY(-50%);">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                            </div>
                            <input type="file" id="file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.txt">
                            <button type="submit" class="send-btn">
                                <i class="fas fa-paper-plane me-1"></i> Send
                            </button>
                        </div>
                    </form>
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
    
    fetch('{{ route("technician.chat.send", $order) }}', {
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

// Add message to chat
function addMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    const isOwnMessage = message.sender_id === {{ auth()->id() }};
    
    const messageHtml = `
        <div class="d-flex ${isOwnMessage ? 'justify-content-end' : 'justify-content-start'} mb-3">
            <div class="message-bubble ${isOwnMessage ? 'message-own' : 'message-other'}">
                ${getMessageContent(message)}
                <div class="message-time">${new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}</div>
            </div>
        </div>
    `;
    
    chatMessages.insertAdjacentHTML('beforeend', messageHtml);
    lastMessageId = message.id;
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
                    <a href="/chat/message/${message.id}/download" class="btn btn-sm btn-outline-primary">
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
    fetch(`{{ route('technician.chat.messages', $order) }}?last_message_id=${lastMessageId}`)
    .then(response => response.json())
    .then(data => {
        if (data.messages.length > 0) {
            data.messages.forEach(message => {
                addMessage(message);
            });
            scrollToBottom();
            updateNavbarNotificationCount();
        }
    })
    .catch(error => {
        console.error('Error polling messages:', error);
    });
}

// Update navbar notification count
function updateNavbarNotificationCount() {
    fetch('{{ route("technician.chat.notification-count") }}')
    .then(response => response.json())
    .then(data => {
        const chatLink = document.querySelector('a[href="{{ route("technician.chat.index") }}"]');
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
            fetch(`/technician/chat/message/${messageId}`, {
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
            fetch(`/technician/chat/${orderId}`, {
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
                        window.location.href = '{{ route("technician.chat.index") }}';
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

// Update addMessage function to include delete button for own messages
function addMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    const isOwnMessage = message.sender_id === {{ auth()->id() }};
    
    const deleteButton = isOwnMessage ? `
        <div class="message-actions">
            <button class="btn btn-sm btn-link text-white p-0 me-2 delete-message-btn" 
                    data-message-id="${message.id}" 
                    title="Delete message">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    ` : '';
    
    const messageHtml = `
        <div class="d-flex ${isOwnMessage ? 'justify-content-end' : 'justify-content-start'} mb-3" data-message-id="${message.id}">
            <div class="message-bubble ${isOwnMessage ? 'message-own' : 'message-other'}">
                ${deleteButton}
                ${getMessageContent(message)}
                <div class="message-time">${new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}</div>
            </div>
        </div>
    `;
    
    chatMessages.insertAdjacentHTML('beforeend', messageHtml);
    lastMessageId = message.id;
}

// Initial scroll to bottom
scrollToBottom();
</script>
@endsection 