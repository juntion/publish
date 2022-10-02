<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\BugExamineStatus;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

// bug 审批日志
class BugExamineLog extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_bug_examine_logs';

    protected $fillable = ['user_id', 'user_name', 'action_name', 'old_status', 'new_status', 'comment', 'created_at'];

    public function getNewStatusDescAttribute()
    {
        return BugExamineStatus::getDesc($this->new_status);
    }
}
