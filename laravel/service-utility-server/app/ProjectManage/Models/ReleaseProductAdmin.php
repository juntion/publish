<?php

namespace App\ProjectManage\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 发版产品管理员
 */
class ReleaseProductAdmin extends Model
{
    protected $table = 'pm_release_product_has_admin';

    protected $fillable = [
        'release_product_id', 'user_id', 'user_name',
    ];

    public $timestamps = false;
}
