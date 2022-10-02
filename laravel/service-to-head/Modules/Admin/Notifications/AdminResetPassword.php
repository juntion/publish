<?php

namespace Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as Notification;

class AdminResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct($token)
    {
        $this->token = $token;

        $this->onQueue('emails');
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(__('admin::auth.reset_password_email.greeting'))
            ->subject(__('admin::auth.reset_password_email.subject'))
            ->line(__('admin::auth.reset_password_email.first_info'))
            ->action(__('admin::auth.reset_password_email.reset_button'), config('admin.client_admin_url') . '/auth/password/reset/'
                . $this->token . '?email=' . urlencode($notifiable->email))
            ->line(__('admin::auth.reset_password_email.link_expire', ['count' => config('auth.passwords.admin.expire')]))
            ->line(__('admin::auth.reset_password_email.last_info'));
    }
}
