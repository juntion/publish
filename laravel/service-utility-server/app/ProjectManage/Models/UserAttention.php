<?php

namespace App\ProjectManage\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttention extends Model
{
    protected $table = 'pm_user_attentions';
    protected $fillable = ['user_id', 'user_name', 'dept_id', 'dept_name'];
    public $timestamps = false;

    public function attentionAble()
    {
        return $this->morphTo('model');
    }
}
