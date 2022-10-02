<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use DateFormatTrait;
}
