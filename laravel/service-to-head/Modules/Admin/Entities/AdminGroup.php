<?php

namespace Modules\Admin\Entities;

use Modules\Base\Entities\Model;

class AdminGroup extends Model
{
    public function admins()
    {
        return $this->hasMany('Modules\Admin\Entities\Admin', 'group_uuid');
    }
}
