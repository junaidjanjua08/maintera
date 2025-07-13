<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Order Completed Successfully!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! Your service has been completed successfully.')
            ->line('**Order Details:**')
            ->line('📍 Location: ' . $this->order->street_address)
            ->line('👨‍🔧 Technician: ' . optional($this->order->technician)->name ?? 'N/A')
            ->line('📅 Completed: ' . now()->format('M d, Y h:i A'))
            ->action('Rate & Review Your Experience', url('/customer/orders/' . $this->order->id . '/review'))
            ->line('We hope you had a great experience! Please take a moment to rate and review your technician.')
            ->line('Your feedback helps us maintain quality service and helps other customers make informed decisions.')
            ->salutation('Thank you for choosing our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message' => '🎉 Your order has been completed successfully! Rate your experience.',
            'type' => 'order_completed',
            'location' => $this->order->street_address,
            'technician_name' => optional($this->order->technician)->name ?? 'N/A',
            'service_name' => optional($this->order->subcategory)->name ?? 'N/A',
            'completed_at' => now()->toISOString(),
            'review_url' => url('/customer/orders/' . $this->order->id . '/review')
        ];
    }
} 