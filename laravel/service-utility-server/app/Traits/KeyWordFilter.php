<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait KeyWordFilter
{
    public function scopeKeyword(Builder $builder, $data)
    {
        $start = substr($data, 0 ,1);
        $end = substr($data, -1);
        if ($start == "%" || $end == "%"){
            $builder->where(function ($query)use ($data){
               $query->where('name', 'like', $data)->orWhere('content', 'like', $data)->orWhere('number', 'like', $data);
            });
        } else {
            $builder->where(function ($query)use ($data){
                $query->where('name', $data)->orWhere('content', $data)->orWhere('number', $data);
            });
        }
        return $builder;
    }

}
