<?php

namespace App\Notifications;

use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeviceIsCheckedNotification extends Notification
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
            'تحية طيبة سيد ' . $notifiable->name,
            'الجهاز ذات نوع ' . $this->device->model,
            'التاريخ المتوقع للتسليم هو '.$this->device->Expected_date_of_delivery,
            'وتم اكتشاف العطل '.$this->device->problem,
            'وتكلفة تصليح هذا العطل '.$this->device->cost_to_client,
            'هل تريد ان نبدأ العمل؟',
        ];
        return [
            'title' => 'اشعار بعطل جهاز',
            'body' => $message,
            'Replyable' => true,
            'data' => [
                'device_id' => $this->device->id,
            ],
            'actions' => [
                [
                    'title' => 'نعم',
                    'url' => 'api/devices/' . $this->device->id,
                    'method' => 'PUT',
                    'request_body' => [
                        'status' => 'قيد العمل',
                        'client_approval' => true
                    ]
                ],
                [
                    "title" => "لا",
                    'url' => 'api/devices/' . $this->device->id,
                    'method' => 'PUT',
                    'request_body' => [
                        'status' => 'لم يوافق على العمل به',
                        'client_approval' => false
                    ]
                ]
            ],
        ];
    }
}
