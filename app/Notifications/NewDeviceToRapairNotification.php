<?php

namespace App\Notifications;

use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceToRapairNotification extends Notification
{
    use Queueable;
    private Device $device;
    /**
     * Create a new notification instance.
     */
    public function __construct(Device $device)
    {
        $this->device=$device;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = [
            'تم اضافة جهاز جديد بحاجة صيانة الرجاء مراجعة الاجهزة.',
        ];
        return [
            'title' => 'اشعار جهاز جديد',
            'body' => $message,
            'Replyable' => false,
            'data' => [
                'device_id' => $this->device->id,
            ],
        ];
    }
}
