<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait HasSourceProjectTrait
{
    public function scopeRelatedProject(Builder $builder, $data)
    {
        if ($data == 0) {
            return $builder->where('source_project_id', 0);
        }
        return $builder->where('source_project_id', '>', 0);
    }
}
