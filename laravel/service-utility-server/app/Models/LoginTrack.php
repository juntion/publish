<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginTrack extends Model
{
    protected $fillable = ['user_id', 'guard_name', 'ip_address', 'city', 'browser'];

    public $timestamps = false;
}
