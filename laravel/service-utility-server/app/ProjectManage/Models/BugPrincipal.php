<?php

namespace App\ProjectManage\Models;

use App\Models\Department;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class BugPrincipal extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_bug_principal';

    protected $fillable = ['dept_id', 'dept_name', 'backend_program_user_id', 'backend_program_user_name',
        'frontend_program_user_id', 'frontend_program_user_name', 'backend_product_user_id', 'backend_product_user_name',
        'frontend_product_user_id', 'frontend_product_user_name', 'test_user_id', 'test_user_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
