<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderRequest extends Notification implements ShouldQueue
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
            ->subject('New Service Request')
            ->line('You have received a new service request.')
            ->line('Service Details:')
            ->line('Location: ' . $this->order->street_address)
            ->line('Scheduled for: ' . $this->order->scheduled_at->format('M d, Y h:i A'))
            ->action('View Request', url('/technician/orders/requests'))
            ->line('Please respond to this request as soon as possible.');
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
            'message' => 'New service request received',
            'type' => 'new_request',
            'scheduled_at' => $this->order->scheduled_at,
            'location' => $this->order->street_address
        ];
    }
} 