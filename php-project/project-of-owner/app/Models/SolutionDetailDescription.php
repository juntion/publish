<?php

namespace App\Models;

class SolutionDetailDescription extends BaseModel
{
    protected $table= "solution_new_detail_description";
    protected $primaryKey = "id";

    //翻译对应关系
    public function SolutionOtherTransDe()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransDe',
            'relate_id',
            'description'
        );
    }

    public function SolutionOtherTransEn()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransEn',
            'relate_id',
            'description'
        );
    }

    public function SolutionOtherTransEs()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransEs',
            'relate_id',
            'description'
        );
    }

    public function SolutionOtherTransFr()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransFr',
            'relate_id',
            'description'
        );
    }

    public function SolutionOtherTransIt()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransIt',
            'relate_id',
            'description'
        );
    }

    public function SolutionOtherTransJp()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransJp',
            'relate_id',
            'description'
        );
    }

    public function SolutionOtherTransRu()
    {
        return $this ->hasOne(
            'App\Models\SolutionOtherTransRu',
            'relate_id',
            'description'
        );
    }
}
