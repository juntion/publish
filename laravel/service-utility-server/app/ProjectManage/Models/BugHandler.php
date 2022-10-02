<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class BugHandler extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_bugs_has_handler';

    protected $fillable = ['handler_id', 'handler_name'];
}
