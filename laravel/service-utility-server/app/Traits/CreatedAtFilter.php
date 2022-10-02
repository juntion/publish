<?php


namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait CreatedAtFilter
{
    public function scopeCreatedAt(Builder $builder, ...$data)
    {
        if ($data[0] != "")
        {
            $builder->where('created_at', ">=", trim($data[0]) . " 00:00:00");
        }

        if ($data[1] != "")
        {
            $builder->where('created_at', "<=", trim($data[1]) . " 23:59:59");
        }
        return $builder;
    }
}
