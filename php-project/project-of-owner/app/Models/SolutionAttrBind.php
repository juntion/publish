<?php

namespace App\Models;

class SolutionAttrBind extends BaseModel
{
    protected $table= "solution_new_attr_bind";
    protected $primaryKey = "id";

    public function SolutionAttrNameValueBind()
    {
        return $this->hasMany('App\Models\SolutionAttrNameValueBind', 'attr_bind_id', 'id');
    }
}
