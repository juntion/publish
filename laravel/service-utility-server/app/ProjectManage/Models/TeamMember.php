<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_team_members';

    protected $fillable = ['team_id', 'user_id', 'user_name', 'dept_id', 'dept_name', 'type'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
