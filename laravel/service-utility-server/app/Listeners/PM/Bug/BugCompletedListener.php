<?php

namespace App\Listeners\PM\Bug;

use App\Enums\WsGateway\WsNotificationType;
use App\Events\PM\Bug\BugCompleted;
use App\Mail\SendMail;
use App\Models\User;
use App\Support\WsGateway;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class BugCompletedListener implements ShouldQueue
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
     * @param BugCompleted $event
     * @return void
     */
    public function handle(BugCompleted $event)
    {
        $bug = $event->bug;
        $user = User::query()->find($bug->promulgator_id);
        if (empty($user)) {
            info('User id:' . $bug->promulgator_id . ' not found');
            return;
        }

        // 消息推送
        $messageData = [
            'type' => WsNotificationType::NOTIFICATION,
            'title' => 'pms有bug进展提醒',
            'content' => "您发布的一个bug，被标记为{$bug->status_desc}，可前往pms进行查看！",
        ];
        WsGateway::sendToUid($user->id, $messageData);


        $url = config('app.frontend_url') . '/RDmanagement/bug/bugProduct?number=' . $bug->number;

        $data['content'] = <<<EOF
        编号为"{$bug->number}"的Bug，程序标记({$bug->status_desc})，请前往Bug生产版本操作验收！
EOF;

        $data['link'] = <<<EOF
        点击下方链接，可查看此Bug详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        // 2020.10.27 取消订阅bug处理结果的邮件通知
        /*Mail::to($user->email)
            ->send(new SendMail("PMS-Bug进展提醒（{$bug->status_desc}）", 'mail.email_pms', $data));*/
    }
}
