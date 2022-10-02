<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class BugLabel extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_bugs_has_labels';

    protected $fillable = ['bug_id', 'name', 'user_id', 'user_name', 'comment'];

    const LABEL_NAMES = [
        '财务审批通过',
        '财务审批驳回',
        '内控审批通过',
        '内控审批驳回',
        '验收不合格',
        '已验收',
        'Bug已关闭'
    ];
}
