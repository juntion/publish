<?php


namespace Modules\Base\Entities\Company;


use Modules\Base\Entities\Model;

class CompanyStatusLog extends Model
{
    protected $table = "company_status_logs";

    protected $fillable = ['admin_uuid', 'admin_name', 'action_name', 'old_status', 'new_status', 'comment', 'uuid', 'model_uuid', 'model_type', 'created_at', 'updated_at'];

    public function logAble()
    {
        return $this->morphTo('model', 'model_type' , 'model_uuid');
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
