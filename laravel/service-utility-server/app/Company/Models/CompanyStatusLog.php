<?php


namespace App\Company\Models;


use Illuminate\Database\Eloquent\Model;

class CompanyStatusLog extends Model
{
    protected $table = "company_status_logs";

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
