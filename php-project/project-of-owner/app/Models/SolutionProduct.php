<?php

namespace App\Models;

class SolutionProduct extends BaseModel
{
    protected $table= "solution_new_product";
    protected $primaryKey = "id";

    public function ShortDesc()
    {
        return $this->hasOne('App\Models\SolutionOtherTransEn', 'relate_id', 'short_desc');
    }
}
