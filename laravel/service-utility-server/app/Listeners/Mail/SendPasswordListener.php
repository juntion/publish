<?php

namespace App\Listeners\Mail;

use App\Events\Mail\SendPasswordEvent;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordListener implements ShouldQueue
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
     * @param SendPasswordEvent $event
     * @return void
     */
    public function handle(SendPasswordEvent $event)
    {
        $user = $event->user;
        $data = $event->data;
        $url = config('app.frontend_url');

        $data['content'] = '<tr>
                              <td  style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; line-height:18px;">
                                您的账户已创建成功, 请点击下方链接登录(Your account has been successfully created, please click the link below to log in) <br />
                                <a href="' . $url . '">' . $url . '</a><br /><br />
                                用户名(username)：' . $data['name'] . '<br />
                                邮箱(email)：' . $data['email'] . '<br />
                                密码(password)：' . $data['password'] . '<br />
                              </td>
                            </tr>';
        Mail::to($user->email)
            ->send(new SendMail('账户创建成功(Account created successfully)', 'mail.email_template_common', $data));
    }
}
