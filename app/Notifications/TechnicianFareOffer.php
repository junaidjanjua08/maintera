<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FareOffer;

class TechnicianFareOffer extends Notification implements ShouldQueue
{
    use Queueable;

    protected $fareOffer;

    /**
     * Create a new notification instance.
     */
    public function __construct(FareOffer $fareOffer)
    {
        $this->fareOffer = $fareOffer;
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
            ->subject('New Fare Offer from Technician')
            ->line('A technician has offered a fare for your service request.')
            ->line('Proposed Price: PKR ' . $this->fareOffer->proposed_price)
            ->line('Technician: ' . optional($this->fareOffer->technician)->name)
            ->action('View Offers', url('/customer/orders/' . $this->fareOffer->order_id . '/fares'))
            ->line('You can review and accept the offer.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->fareOffer->order_id,
            'fare_offer_id' => $this->fareOffer->id,
            'technician_id' => $this->fareOffer->technician_id,
            'proposed_price' => $this->fareOffer->proposed_price,
            'note' => $this->fareOffer->note,
            'message' => 'A technician has offered a fare for your order.',
            'type' => 'technician_fare_offer',
        ];
    }
} 