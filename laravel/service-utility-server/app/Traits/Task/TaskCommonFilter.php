<?php

namespace App\Traits\Task;

use Illuminate\Database\Eloquent\Builder;

trait TaskCommonFilter
{
    public function scopePrincipalUserId(Builder $builder, $data)
    {
        $builder = $builder->where('main_principal_user_id', $data)
            ->orWhere('principal_user_id', $data);
        return $builder;
    }

    public function scopeSubTaskStatus(Builder $builder, $data)
    {
        $searchData = request()->input('search');
        if (isset($searchData['subTasks.handler_id'])) {
            $builder = $builder->whereHas('subTasks', function ($query) use ($searchData, $data) {
                $query->where($query->qualifyColumn('status'), $data)
                    ->where($query->qualifyColumn('handler_id'), $searchData['subTasks.handler_id']);
            });
        } else {
            $builder = $builder->whereHas('subTasks', function ($query) use ($searchData, $data) {
                $query->where($query->qualifyColumn('status'), $data);
            });
        }
        return $builder;
    }

    /**
     * 完成时间搜索
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeFinishTime(Builder $builder, ...$data)
    {
        $startTime = $data[1][0] . " 00:00:00";
        $endTime = $data[1][1] . " 23:59:59";
        $searchType = $data[2];
        if ($searchType == 'may') {
            $builder = $this->searchFinishTime($builder, request()->input('may'), $startTime, $endTime);
        } else {
            $builder = $this->searchFinishTime($builder, request()->input('must'), $startTime, $endTime);
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param array $searchData
     * @param string $startTime
     * @param string $endTime
     * @return Builder
     */
    protected function searchFinishTime(Builder $builder, array $searchData, string $startTime, string $endTime): Builder
    {
        if (isset($searchData['subTasks.handler_id,is'])) {
            $builder = $builder->whereHas('subTasks', function ($query) use ($startTime, $endTime, $searchData) {
                $query->whereBetween($query->qualifyColumn('finish_time'), [$startTime, $endTime])
                    ->where($query->qualifyColumn('handler_id'), $searchData['subTasks.handler_id,is']);
            });
        } else {
            $builder = $builder->whereBetween($builder->qualifyColumn('finish_time'), [$startTime, $endTime]);
        }
        return $builder;
    }
}
