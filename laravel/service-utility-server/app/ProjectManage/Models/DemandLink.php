<?php

namespace App\ProjectManage\Models;

use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class DemandLink extends Model
{
    use DateFormatTrait;

    protected $table = 'pm_demand_links';

    protected $fillable = ['demand_id', 'type', 'group', 'principal_user_id', 'principal_user_name', 'comment'];

    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }
}
