@extends('technician.index')

@section('content')
<style>
    .chat-card {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease-in-out;
        margin-bottom: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .chat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease-in-out;
    }

    .chat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        border-color: #667eea;
    }

    .chat-card:hover::before {
        transform: scaleX(1);
    }

    .chat-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease-in-out;
    }

    .chat-card:hover .chat-avatar {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        transform: scale(1.05);
    }

    .unread-badge {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
    }

    .chat-card:hover .unread-badge {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        transform: scale(1.1);
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        border: none;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    .page-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: white;
        margin: 0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0.25rem 0 0 0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .chat-count-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
        font-weight: 500;
        backdrop-filter: blur(10px);
    }

    .chat-message-preview {
        font-size: 0.8rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
        transition: color 0.3s ease-in-out;
    }

    .chat-card:hover .chat-message-preview {
        color: #667eea;
    }

    .chat-time {
        font-size: 0.75rem;
        color: #adb5bd;
        transition: color 0.3s ease-in-out;
    }

    .chat-card:hover .chat-time {
        color: #764ba2;
    }

    .customer-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057;
        margin: 0;
        transition: color 0.3s ease-in-out;
    }

    .chat-card:hover .customer-name {
        color: #667eea;
    }

    .order-number {
        font-size: 0.8rem;
        color: #6c757d;
        margin: 0.125rem 0 0 0;
        transition: color 0.3s ease-in-out;
    }

    .chat-card:hover .order-number {
        color: #764ba2;
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center position-relative">
                <div>
                    <h1 class="page-title">💬 My Chats</h1>
                    <p class="page-subtitle">Communicate with your customers</p>
                </div>
                <div class="text-end">
                    <span class="chat-count-badge">
                        {{ count($orders) }} Active Chats
                    </span>
                </div>
            </div>
        </div>

        @if($orders->count() > 0)
            @foreach($orders as $order)
            <div class="chat-card">
                <a href="{{ route('technician.chat.show', $order) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="chat-avatar me-3">
                                {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="customer-name">
                                    {{ $order->customer->name }}
                                    
                                </h6>
                                <p class="order-number">Order #{{ $order->id }}</p>
                                @if($order->chatMessages->count() > 0)
                                    <p class="chat-message-preview">
                                        {{ Str::limit($order->chatMessages->first()->message, 40) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            @if($order->unread_count > 0)
                                <div class="unread-badge mb-1">{{ $order->unread_count }}</div>
                            @endif
                            @if($order->chatMessages->count() > 0)
                                <small class="chat-time d-block">
                                    {{ $order->chatMessages->first()->created_at->diffForHumans() }}
                                </small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        @else
            <div class="text-center py-4">
                <div class="mb-3">
                    <i class="fe fe-message-circle fs-2 text-muted"></i>
                </div>
                <h5 class="text-muted mb-2">No chats yet</h5>
                <p class="text-muted small">
                    You'll see chats here once a customer accepts your fare offer.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection 