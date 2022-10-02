<?php

namespace App\Traits;

use App\ProjectManage\Models\UserAttention;

trait AttentionTrait
{
    public function attentionAble()
    {
        return $this->morphMany(UserAttention::class, 'model');
    }
}
