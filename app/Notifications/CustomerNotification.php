<?php

namespace App\Notifications;

use App\Models\CompletedDevice;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerNotification extends Notification
{
    use Queueable;
    private Device $device;

    /**
     * Create a new notification instance.
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $customer = $this->device->customer;
        return (new MailMessage)
            ->mailer('smtp')
            ->subject('اشعار تسليم جهاز')
            ->greeting('تحية طيبة سيد '. $customer->name . $customer->last_name)
            ->line( 'الجهاز ذات نوع ' . $this->device->model)
            ->line('تم استلامه بتاريخ ' . now())
            ->line(' تنتهي كفالة هذا الجهاز في تاريخ' . $this->device->customer_date_warranty);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
