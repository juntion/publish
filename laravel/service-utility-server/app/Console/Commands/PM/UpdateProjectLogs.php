<?php

namespace App\Console\Commands\PM;

use App\ProjectManage\Models\Project;
use Illuminate\Console\Command;

class UpdateProjectLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projectLogs:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project生成初始记录';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Project::query()->get()->map(function ($item){
            $hasInit = $item->statusLogs()->orderBy('id','ASC')->first();
            if($hasInit){
                $old_status = $hasInit->old_status;
                if(is_null($old_status)){
                    return false;
                } else {
                    $initStatus = $old_status;
                }
            } else {
                $initStatus = $item->status;
            }
            $item->statusLogs()->create([
                'user_id' => $item->promulgator_id,
                'user_name' => $item->promulgator_name,
                'new_status'  => $initStatus,
                'comment'     => "",
                'created_at'  => $item->created_at,
            ]);
        })->reject();
    }
}
