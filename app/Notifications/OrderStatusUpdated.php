<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
        $statusMessages = [
            'pending' => 'Your order is pending and waiting for technician action.',
            'accepted' => 'Your order has been accepted by the technician.',
            'in_progress' => 'Your technician has started working on your order.',
            'completed' => 'Your order has been completed successfully.',
            'cancelled' => 'Your order has been cancelled.',
            'offer_received' => 'You have received fare offers for your order.'
        ];

        $message = $statusMessages[$this->newStatus] ?? 'Your order status has been updated.';

        return (new MailMessage)
            ->subject('Order Status Updated')
            ->line('Your order status has been updated.')
            ->line('Order Details:')
            ->line('Service: ' . optional($this->order->subcategory)->name ?? 'N/A')
            ->line('Location: ' . $this->order->street_address)
            ->line('Previous Status: ' . ucfirst($this->oldStatus))
            ->line('New Status: ' . ucfirst($this->newStatus))
            ->line($message)
            ->action('View Order', url('/customer/orders'));
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
            'message' => 'Your order status has been updated to ' . ucfirst($this->newStatus),
            'type' => 'order_status_updated',
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'location' => $this->order->street_address,
            'technician_name' => optional($this->order->technician)->name ?? 'N/A',
            'service_name' => optional($this->order->subcategory)->name ?? 'N/A'
        ];
    }
}
