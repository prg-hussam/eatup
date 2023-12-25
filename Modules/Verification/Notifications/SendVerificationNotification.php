<?php

namespace Modules\Verification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Verification\Entities\Verification;

class SendVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new Verification instance.
     *
     * @var \Modules\Verification\Entities\Verification
     */
    public Verification $verification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Verification $verification)
    {
        $this->verification = $verification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->verification->channel];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__("mail.verification.subject"))
            ->line(__("mail.verification.line_1", ["code" => $this->verification->code]))
            ->line(__("mail.verification.line_2"));
    }
}
