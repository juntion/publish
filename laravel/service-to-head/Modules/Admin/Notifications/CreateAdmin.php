<?php

namespace Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CreateAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;

        $this->onQueue('emails');
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->greeting(__('admin::notice.greeting'))
            ->subject(__('admin::notice.subject'))
            ->line(__('admin::notice.create_info'))
            ->line(__('admin::notice.address', ['address' => config('app.client_admin_url')]))
            ->line(__('admin::notice.name', ['name' => $notifiable->name]))
            ->line(__('admin::notice.email', ['email' => $notifiable->email]))
            ->line(__('admin::notice.password', ['password' => $this->password]));
    }
}
