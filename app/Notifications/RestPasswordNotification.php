<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestPasswordNotification extends Notification
{
    use Queueable;
    public $secret;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
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

        $link = route('guest.account.reset-password',['email'=>$notifiable->email,'secret'=>$this->secret]);
        return (new MailMessage)
                    ->line('Follow given link to reset your password!')
                    ->action('Rest Password', url($link))
                    ->line('Thank you for using our application!');
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
