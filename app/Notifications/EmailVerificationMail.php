<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Info;

class EmailVerificationMail extends Notification
{
    use Queueable;

    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('emailVerifyCheck', $this->user_id) . '?token=' . Hash::make(time());
        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'), 'Sepalin Canada')
            // ->bcc([env('ADMIN_NOTIFY_MAIL'), env('SALES_NOTIFY_MAIL')])
            ->subject('Sepalin Canada account verification')
            ->line('Thanks for your registration. Please click the verify now button for login to your account')
            ->action('Verify Now', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
