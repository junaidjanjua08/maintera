<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderInProgress extends Notification implements ShouldQueue
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
            ->subject('Order Work Started')
            ->line('Your technician has started working on your service request.')
            ->line('Order Details:')
            ->line('Service: ' . optional($this->order->subcategory)->name ?? 'N/A')
            ->line('Location: ' . $this->order->street_address)
            ->line('Technician: ' . optional($this->order->technician)->name ?? 'N/A')
            ->action('View Order', url('/customer/orders'))
            ->line('The work is now in progress. You can chat with your technician for updates.');
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
            'message' => 'Your technician has started working on your order',
            'type' => 'order_in_progress',
            'location' => $this->order->street_address,
            'technician_name' => optional($this->order->technician)->name ?? 'N/A',
            'service_name' => optional($this->order->subcategory)->name ?? 'N/A'
        ];
    }
}
