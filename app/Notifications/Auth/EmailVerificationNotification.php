<?php

namespace App\Notifications\Auth;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification
{
    use Queueable;
    /**
     * Create a new message instance.
     */
    public function __construct()
    {
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
        $verifibleToken = $notifiable->tokens->first()->token;
        return (new MailMessage)
            ->mailer('smtp')
            ->subject('Email Verification Required')
            ->greeting("Greetings, {$notifiable->name}!")
            ->line('Your security is important to us. Please click the button below to complete the email verification process:')
            ->action('Verify My Email', "https://haidarjaded787.serv00.net/email/verify/confirm/" . $verifibleToken)
            ->line('Thank you for taking the time to confirm your email. We appreciate your prompt attention to this matter.')
            ->salutation('Warm regards,')
            ->salutation('The MyPhone Team');
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
