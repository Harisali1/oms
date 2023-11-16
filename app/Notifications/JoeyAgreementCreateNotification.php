<?php

namespace App\Notifications;

use App\Classes\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class JoeyAgreementCreateNotification extends Notification
{
    use Queueable;



    /**
     * Create a new notification instance.
     * @param string $status
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage
    {
        //$email = base64_encode($notifiable->email);
        $mailMessage = (new MailMessage)->greeting($notifiable->full_name);

        $mailMessage = (new MailMessage)->greeting('Hello, ' . $notifiable->full_name);
        $mailMessage = $mailMessage->subject(Email::makeSubject('Successfully Agreement'));
        $mailMessage = $mailMessage->line('Welcome to JoeyCo!');
        $mailMessage = $mailMessage->line('You have successfully agree on joey agreement ');
        $mailMessage = $mailMessage->line('Thank you for using our application!');
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) : array
    {
        return [
            //
        ];
    }
}
