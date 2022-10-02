<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_status_logs';

    protected $fillable = ['user_id', 'user_name', 'action_name', 'old_status', 'new_status', 'comment', 'created_at'];

    public function logAble()
    {
        return $this->morphTo('model');
    }

    public function getNewStatusDescAttribute()
    {
        $model = new $this->model_type;
        return $model->getStatus($this->new_status);
    }

    public function getOldStatusDescAttribute()
    {
        $model = new $this->model_type;
        return $model->getStatus($this->old_status);
    }
}
