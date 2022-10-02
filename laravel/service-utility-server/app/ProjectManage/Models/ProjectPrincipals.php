<?php


namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectPrincipals extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_project_principals';

    protected $fillable = ['project_id', 'user_id', 'user_name', 'dept_id', 'dept_name', 'type'];

    // 类型；0：产品；1：设计；2：开发；3：业务；4：测试；
    public function getTypeDesc()
    {
        switch ($this->type) {
            case 0:
                return '产品';
            case 1:
                return '设计';
            case 2:
                return '开发';
            case 3:
                return '业务';
            case 4:
                return '测试';
            default:
                return '';
        }
    }
}
