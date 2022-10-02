<?php

namespace App\Traits\Task;

use App\ProjectManage\Models\DesignTask;
use Illuminate\Database\Eloquent\Builder;

trait TaskKeywordFilter
{
    /**
     * task 类型的keyword
     * @param Builder $builder
     * @param $data
     * @return Builder
     */
    public function scopeKeyword(Builder $builder, $data)
    {
        $start = substr($data, 0, 1);
        $end = substr($data, -1);
        if ($start == "%" || $end == "%") {
            $builder->where(function ($query) use ($data) {
                $query->orWhere('content', 'like', $data)
                    ->orWhere('number', 'like', $data)
                    ->orWhere('title', 'like', $data)
                    ->orWhereHas('demand', function ($q) use ($data) {
                        $q->where('number', 'like', $data)->orWhere('name', 'like', $data);
                    })
                    ->orWhereHas('subTasks', function ($q) use ($data) {
                        $q->where('number', 'like', $data);
                    });
                if ($this instanceof DesignTask) {
                    $query->orWhereHas('parts', function ($q) use ($data) {
                        $q->where('number', 'like', $data);
                    });
                }
            });
        } else {
            $builder->where(function ($query) use ($data) {
                $query->orWhere('content', $data)
                    ->orWhere('number', $data)
                    ->orWhere('title', $data)
                    ->orWhereHas('demand', function ($q) use ($data) {
                        $q->where($q->qualifyColumn('number'), $data)->orWhere($q->qualifyColumn('name'), $data);
                    })
                    ->orWhereHas('subTasks', function ($q) use ($data) {
                        $q->where($q->qualifyColumn('number'), $data);
                    });
                if ($this instanceof DesignTask) {
                    $query->orWhereHas('parts', function ($q) use ($data) {
                        $q->where($q->qualifyColumn('number'), $data);
                    });
                }
            });
        }
        return $builder;
    }
}
