<?php

namespace App\Listeners\PM;

use App\Events\PM\CreateProject;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CreateProjectListener implements ShouldQueue
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
     * @param CreateProject $event
     * @return void
     */
    public function handle(CreateProject $event)
    {
        $project = $event->project;
        $principalUser = User::query()->find($project->principal_user_id);
        $promulgator = User::query()->find($project->promulgator_id);
        $url = config('app.frontend_url') . '/RDmanagement/project/proDetails?id=' . $project->id;

        $data['content'] = <<<EOF
        {$promulgator->name}创建了"{$project->name}"的项目需要你负责，编号为"{$project->number}"
EOF;

        $data['link'] = <<<EOF
        点击下方链接，可查看此项目详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        Mail::to($principalUser->email)
            ->send(new SendMail('PMS-项目进展', 'mail.email_pms', $data));
    }
}
