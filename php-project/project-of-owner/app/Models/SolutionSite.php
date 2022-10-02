<?php

namespace App\Models;

class SolutionSite extends BaseModel
{
    protected $table= "solution_new_site";
    protected $primaryKey = "id";

    public function SolutionSiteProductType()
    {
        return $this->hasMany('App\Models\SolutionSiteProductType', 'site_id', 'id');
    }
}
