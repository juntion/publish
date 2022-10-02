<?php

namespace App\Listeners\Mail;

use App\Events\Mail\PasswordRestEvent;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class PasswordResetListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(PasswordRestEvent $event)
    {
        $user = $event->user;
        $token = $event->token;

        $url = config('app.frontend_url') . '/auth/password/reset/' . $token . '?username=' . urlencode($user->name);
        $data['content'] = '
              <tr>
                <td  style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; line-height:18px;">' . __('We have received your request for password reset. If this is your request, please follow the instructions below.') . '<br /><br />
                      ' . __('Click the link below to reset the password through our secure server:') . '<br /><br />
                      <a href="' . $url . '">' . $url . '</a><br /><br />
                      ' . __('If you did not request a password reset, you can ignore this email. Please be assured that your business account is safe.') . '<br />
                      <br />
                      ' . __('If clicking the link is invalid, please copy the link and paste it into the address bar of your browser, or enter the link in the address bar via the keyboard.') . '<br /><br />
                      </td>
                </tr>';
        Mail::to($user->receiveCodeEmail)
            ->send(new SendMail(__('User password recovery'), 'mail.email_template_common', $data));
    }
}
