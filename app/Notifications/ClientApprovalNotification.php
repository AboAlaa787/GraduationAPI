<?php

namespace App\Notifications;

use App\Enums\DeviceStatus;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientApprovalNotification extends Notification
{
    use Queueable;
    private Device $device;
    /**
     * Create a new notification instance.
     */
    public function __construct($device)
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
        $model = $this->device->model;
        $code = $this->device->code;
        $status = $this->device->status;
        $clientName = $this->device->client->name;
        $message = [
            'تحية طيبة سيد ' . $notifiable->name,
            'الجهاز ذات نوع ' . $model,
            'والذي كوده هو ' . $code,
            $status==DeviceStatus::NotAgree->value?
            'تم رفض العمل به من قبل السيد '.$clientName:'تم الموافقة العمل به من قبل السيد '.$clientName
        ];
        return [
            'title' => 'اشعار بحالة جهاز',
            'body' => $message,
            'Replyable' => false
        ];
    }
}
