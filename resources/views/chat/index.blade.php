@extends('index')

@section('content')
<style>
    .chat-list-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 20px 0;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .chat-header {
        background: linear-gradient(135deg, #FDA12B 0%, #FF8C42 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
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
    
    .search-container {
        background: white;
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .search-input {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        padding-left: 45px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .search-input:focus {
        border-color: #FDA12B;
        background: white;
        box-shadow: 0 0 0 3px rgba(253, 161, 43, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 2;
    }
    
    .chat-item {
        padding: 1.25rem;
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .chat-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: translateX(4px);
    }
    
    .chat-item:last-child {
        border-bottom: none;
    }
    
    .chat-item.active {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 4px solid #FDA12B;
    }
    
    .chat-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 20px;
        position: relative;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        background: #28a745;
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .chat-info {
        flex: 1;
        min-width: 0;
    }
    
    .chat-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .chat-order {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 6px;
        font-weight: 500;
    }
    
    .chat-last-message {
        font-size: 14px;
        color: #495057;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
        line-height: 1.4;
    }
    
    .chat-time {
        font-size: 12px;
        color: #6c757d;
        text-align: right;
        font-weight: 500;
    }
    
    .unread-badge {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border-radius: 50%;
        min-width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        margin-left: 10px;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-in-progress {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 24px;
        opacity: 0.3;
        color: #FDA12B;
    }
    
    .empty-state h5 {
        color: #495057;
        margin-bottom: 12px;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 24px;
        font-size: 16px;
    }
    
    .chat-stats {
        background: #f8f9fa;
        padding: 12px 20px;
        border-bottom: 1px solid #e9ecef;
        font-size: 14px;
        color: #6c757d;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .filter-buttons {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }
    
    .filter-btn {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        background: white;
        border-radius: 20px;
        font-size: 12px;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-btn.active {
        background: #FDA12B;
        color: white;
        border-color: #FDA12B;
    }
    
    .filter-btn:hover {
        background: #e9ecef;
        border-color: #adb5bd;
    }
    
    .filter-btn.active:hover {
        background: #FDA12B;
        color: white;
    }
    
    @media (max-width: 768px) {
        .chat-list-container {
            margin: 10px;
            border-radius: 12px;
        }
        
        .chat-item {
            padding: 1rem;
        }
        
        .chat-avatar {
            width: 48px;
            height: 48px;
            font-size: 18px;
        }
        
        .chat-last-message {
            max-width: 150px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="chat-list-container">
                <!-- Header -->
                <div class="chat-header">
                    <div class="chat-header-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('home') }}" class="back-btn me-3">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <div>
                                    <h4 class="mb-0">My Chats</h4>
                                    <p class="mb-0 opacity-75">Communicate with your technicians</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-comments me-2"></i>
                                    <span>{{ $orders->count() }} {{ $orders->count() == 1 ? 'Chat' : 'Chats' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="search-container">
                    <div class="position-relative">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="form-control search-input" 
                               placeholder="Search chats by technician name or order number...">
                    </div>
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="unread">Unread</button>
                        <button class="filter-btn" data-filter="recent">Recent</button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="chat-stats">
                    <span>Total Chats: {{ $orders->count() }}</span>
                    <span>Unread: {{ $orders->sum('unread_count') }}</span>
                </div>

                <!-- Chat List -->
                <div class="chat-list" id="chatList">
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <div class="chat-item" data-order-id="{{ $order->id }}" 
                             data-technician="{{ strtolower($order->technician->name ?? '') }}"
                             data-order-number="{{ $order->id }}"
                             data-unread="{{ $order->unread_count > 0 ? 'true' : 'false' }}"
                             onclick="window.location.href='{{ route('customer.chat.show', $order) }}'">
                            <div class="d-flex align-items-center">
                                <div class="chat-avatar me-3">
                                    {{ strtoupper(substr($order->technician->name ?? 'T', 0, 1)) }}
                                    <div class="online-indicator"></div>
                                </div>
                                <div class="chat-info">
                                    <div class="chat-name">
                                        {{ $order->technician->name ?? 'Technician' }}
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                    <div class="chat-order">Order #{{ $order->id }}</div>
                                    @if($order->chatMessages->count() > 0)
                                        <div class="chat-last-message">
                                            <i class="fas fa-comment me-1"></i>
                                            {{ Str::limit($order->chatMessages->first()->message, 50) }}
                                        </div>
                                    @else
                                        <div class="chat-last-message text-muted">
                                            <i class="fas fa-plus me-1"></i>
                                            Start a conversation
                                        </div>
                                    @endif
                                </div>
                                <div class="chat-time">
                                    @if($order->chatMessages->count() > 0)
                                        <div>{{ $order->chatMessages->first()->created_at->format('M j') }}</div>
                                        <div>{{ $order->chatMessages->first()->created_at->format('g:i A') }}</div>
                                    @endif
                                    @if($order->unread_count > 0)
                                        <div class="unread-badge mt-2">{{ $order->unread_count }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <h5>No chats yet</h5>
                            <p>You'll see your chats here once you accept a technician's offer.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Go to Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        const technician = item.dataset.technician;
        const orderNumber = item.dataset.orderNumber;
        
        if (technician.includes(searchTerm) || orderNumber.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
    
    updateStats();
});

// Filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const chatItems = document.querySelectorAll('.chat-item');
        
        chatItems.forEach(item => {
            let show = true;
            
            if (filter === 'unread') {
                show = item.dataset.unread === 'true';
            } else if (filter === 'recent') {
                // Show chats with messages in the last 24 hours
                const timeElement = item.querySelector('.chat-time div');
                if (timeElement && timeElement.textContent.includes('Today')) {
                    show = true;
                } else {
                    show = false;
                }
            }
            
            item.style.display = show ? 'block' : 'none';
        });
        
        updateStats();
    });
});

function updateStats() {
    const visibleChats = document.querySelectorAll('.chat-item[style="display: block"], .chat-item:not([style*="display: none"])').length;
    const visibleUnread = Array.from(document.querySelectorAll('.chat-item[style="display: block"], .chat-item:not([style*="display: none"])'))
        .reduce((sum, item) => sum + (parseInt(item.dataset.unread) || 0), 0);
    
    const statsElement = document.querySelector('.chat-stats');
    if (statsElement) {
        statsElement.innerHTML = `<span>Visible: ${visibleChats}</span><span>Unread: ${visibleUnread}</span>`;
    }
}

// Add hover effects and animations
document.querySelectorAll('.chat-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(4px) scale(1.01)';
    });
    
    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0) scale(1)';
    });
});

// Initialize stats
updateStats();
</script>
@endsection 