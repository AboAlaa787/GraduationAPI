<?php

namespace App\Notifications;

use App\Models\Device;
use Illuminate\Bus\Queueable;
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
        $client = $this->device->client;
        return (new MailMessage)
            ->mailer('smtp')
            ->subject('اشعار تسليم جهاز')
            ->greeting( ' تحية طيبة سيد')
            ->line($customer->name . ' ' . $customer->last_name)
            ->line($this->device->model . ' الجهاز ذات نوع')
            ->line( ' تم استلامه من قبل حضرتكم بتاريخ '.now()->format('Y-m-d H:i:s'))
            ->lineIf($this->device->customer_date_warranty != null,' تنتهي كفالة هذا الجهاز بتاريخ '. $this->device->customer_date_warranty  )
            ->line(' شكراً لزيارتكم مركز ')
            ->line($client->center_name);
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
