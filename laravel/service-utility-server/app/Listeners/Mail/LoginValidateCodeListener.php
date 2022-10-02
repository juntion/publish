<?php

namespace App\Listeners\Mail;

use App\Events\Mail\LoginValidateCodeEvent;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class LoginValidateCodeListener implements ShouldQueue
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
    public function handle(LoginValidateCodeEvent $event)
    {
        $user = $event->user;
        $code = $event->code;

        $data['content'] = '<tr>
                              <td  style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; line-height:18px;">
                                ' . __('Captcha') . '：' . $code . '。<br /><br />
                                ' . __('If you do not have a login request and your account is at risk, please change your password in time.') . '<br /><br />
                              </td>
                            </tr>';
        Mail::to($user->receiveCodeEmail)
            ->send(new SendMail(__('User login verification'), 'mail.email_template_common', $data));
    }
}
