<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\FacebookPoster\FacebookPosterChannel;
use NotificationChannels\FacebookPoster\FacebookPosterPost;
use Illuminate\Notifications\Notification;

class FacebookPostNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $link)
    {
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FacebookPosterChannel::class];
    }

    public function toFacebookPoster($notifiable) {
        return (new FacebookPosterPost($this->title))->withLink($this->link);
    }
}
