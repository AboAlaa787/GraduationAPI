<?php

namespace App\Notifications\DevicesStatus;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotAgreeNotification extends Notification
{
    use Queueable;
    public $devive_id;
    public $user_id;
    public $clirnt_id;
    public $problem;
    public $cost;
    /**
     * Create a new notification instance.
     */
    public function __construct($devive_id, $user_id, $clirnt_id,  $problem, $cost)
    {
        $this->devive_id = $devive_id;
        $this->user_id = $user_id;
        $this->clirnt_id = $clirnt_id;
        $this->problem = $problem;
        $this->cost = $cost;
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
        return [
            'devive_id' => $this->devive_id,
            'user_id' => $this->user_id,
            'clirnt_id' =>  $this->clirnt_id,
            'message' => 'The device was examined and found a malfunction:' .  $this->problem . 'repair cost:' .  $this->cost . 'Do you agree',
        ];
    }
}
