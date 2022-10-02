<?php

namespace App\Models;

class SolutionSiteSpecialDescription extends BaseModel
{
    protected $table= "solution_new_site_special_description";
    protected $primaryKey = "id";

    public function SolutionSpeTrans()
    {
        return $this->hasOne('App\Models\SolutionOtherTransEn', 'relate_id', 'title');
    }
}
