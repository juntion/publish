<?php

namespace Modules\Admin\Entities;

use Illuminate\Notifications\Notifiable;
use Modules\Base\Entities\User;
use Modules\Admin\Entities\Traits\CanResetPassword;
use Modules\Permission\Entities\Traits\HasRoles;

class Admin extends User
{
    use Notifiable, CanResetPassword, HasRoles;

    protected $fillable = [
        'uuid', 'name', 'email', 'password', 'avatar', 'id'
    ];

    protected $hidden = [
        'password',
    ];

    public function group()
    {
        return $this->belongsTo('Modules\Admin\Entities\AdminGroup', 'group_uuid');
    }

    protected static function newFactory()
    {
        return \Modules\Admin\Database\Factories\AdminFactory::new();
    }
}
