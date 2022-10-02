<?php

namespace App\Models;

class Solution extends BaseModel
{
    protected $table= "solution_new";
    protected $primaryKey = "id";

    public function SolutionAttrBind()
    {
        return $this->hasMany('App\Models\SolutionAttrBind', 'solution_id', 'id');
    }

    public function SolutionAttrNameValueBind()
    {
        return $this->hasManyThrough(
            'App\Models\SolutionAttrNameValueBind',
            'App\Models\SolutionAttrBind',
            'attr_bind_id',
            'id'
        );
    }

    public function SolutionAttrName()
    {
        return $this->hasManyThrough(
            'App\Models\SolutionAttrName',
            'App\Models\SolutionAttrNameValueBind',
            'name_id',
            'id'
        );
    }


    //翻译对应关系
    public function SolutionTransDe()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransDe',
            'relate_id',
            'title'
        );
    }

    public function SolutionTransEn()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransEn',
            'relate_id',
            'title'
        );
    }

    public function SolutionTransEs()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransEs',
            'relate_id',
            'title'
        );
    }

    public function SolutionTransFr()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransFr',
            'relate_id',
            'title'
        );
    }

    public function SolutionTransIt()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransIt',
            'relate_id',
            'title'
        );
    }

    public function SolutionTransJp()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransJp',
            'relate_id',
            'title'
        );
    }

    public function SolutionTransRu()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransRu',
            'relate_id',
            'title'
        );
    }

    //翻译对应关系
    public function SolutionModelTransDe()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransDe',
            'relate_id',
            'model'
        );
    }

    public function SolutionModelTransEn()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransEn',
            'relate_id',
            'model'
        );
    }

    public function SolutionModelTransEs()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransEs',
            'relate_id',
            'model'
        );
    }

    public function SolutionModelTransFr()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransFr',
            'relate_id',
            'model'
        );
    }

    public function SolutionModelTransIt()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransIt',
            'relate_id',
            'model'
        );
    }

    public function SolutionModelTransJp()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransJp',
            'relate_id',
            'model'
        );
    }

    public function SolutionModelTransRu()
    {
        return $this ->hasOne(
            'App\Models\SolutionTransRu',
            'relate_id',
            'model'
        );
    }
}
