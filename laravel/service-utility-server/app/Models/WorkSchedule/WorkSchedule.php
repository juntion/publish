<?php

namespace App\Models\WorkSchedule;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use WorkScheduleTrait, DateFormatTrait;

    protected $guarded = ['id', 'created_at'];

    protected $casts = [
        'morning_to_work' => 'date:H:i',
        'morning_off_work' => 'date:H:i',
        'noon_to_work' => 'date:H:i',
        'noon_off_work' => 'date:H:i',
    ];
}
