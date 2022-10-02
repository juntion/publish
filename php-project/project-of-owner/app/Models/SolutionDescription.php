<?php

namespace App\Models;

class SolutionDescription extends BaseModel
{
    protected $table= "solution_new_description";
    protected $primaryKey = "id";

    //翻译对应关系
    public function SolutionTransDe()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransDe',
            'relate_id',
            'description'
        );
    }

    public function SolutionTransEn()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransEn',
            'relate_id',
            'description'
        );
    }

    public function SolutionTransEs()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransEs',
            'relate_id',
            'description'
        );
    }

    public function SolutionTransFr()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransFr',
            'relate_id',
            'description'
        );
    }

    public function SolutionTransIt()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransIt',
            'relate_id',
            'description'
        );
    }

    public function SolutionTransJp()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransJp',
            'relate_id',
            'description'
        );
    }

    public function SolutionTransRu()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransRu',
            'relate_id',
            'description'
        );
    }
}
