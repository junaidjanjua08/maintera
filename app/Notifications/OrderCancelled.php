<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderCancelled extends Notification implements ShouldQueue
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
        $message = (new MailMessage)
            ->subject('Order Cancelled')
            ->line('An order has been cancelled.')
            ->line('Order Details:')
            ->line('Service: ' . optional($this->order->service)->name ?? 'N/A')
            ->line('Location: ' . $this->order->street_address);

        if ($this->order->cancellation_reason) {
            $message->line('Reason: ' . $this->order->cancellation_reason);
        }

        return $message->action('View Order', url('/technician/orders/' . $this->order->id))
                      ->line('If you have any questions, please contact support.');
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
            'message' => 'Order has been cancelled',
            'type' => 'order_cancelled',
            'location' => $this->order->street_address,
            'reason' => $this->order->cancellation_reason,
            'service_name' => optional($this->order->service)->name ?? 'N/A'
        ];
    }
} 