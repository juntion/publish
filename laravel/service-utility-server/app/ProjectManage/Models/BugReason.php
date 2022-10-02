<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class BugReason extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_bug_reason';

    protected $fillable = ['reason', 'required_analyse'];

    public function bugs()
    {
        return $this->hasMany(Bug::class, 'reason_id');
    }
}
