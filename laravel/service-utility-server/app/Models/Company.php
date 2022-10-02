<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use DateFormatTrait;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
