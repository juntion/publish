<?php

namespace Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public $name;
    public $email;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;

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
            ->line(__('admin::notice.update_info'))
            ->line(__('admin::notice.address', ['address' => config('app.client_admin_url')]))
            ->line(__('admin::notice.name', ['name' => $notifiable->name]) . ' (' . __('admin::notice.name_old', ['name' => $this->name]) . ')')
            ->line(__('admin::notice.email', ['email' => $notifiable->email]) . ' (' . __('admin::notice.email_old', ['email' => $this->email]) . ')');
    }
}
