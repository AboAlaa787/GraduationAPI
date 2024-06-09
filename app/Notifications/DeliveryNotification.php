<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliveryNotification extends Notification
{
    use Queueable;
    private Order $order;
    /**
     * Create a new notification instance.
     */
    public function __construct($order)
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = [
            'تم اضافة طلب جديد الرجاء مراجعة الطلبات.',
        ];
        return [
            'title' => 'اشعار طلب جديد',
            'body' => $message,
            'Replyable' => false,
            'data' => [
                'order_id' => $this->order->id,
            ],
        ];
    }
}
