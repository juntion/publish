<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_teams';

    protected $fillable = ['product_id', 'user_id', 'user_name', 'dept_id', 'dept_name', 'type', 'is_default'];

    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }
}
