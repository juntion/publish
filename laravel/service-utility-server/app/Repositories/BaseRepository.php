<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Support\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class BaseRepository extends EloquentRepository
{
    protected $allowedIncludes = [];
    protected $allowedFilters = [];
    protected $allowedSorts = [];
    protected $allowedFields = [];
    protected $allowedAppends = [];
    protected $shouldAppends = [];
    protected $allowedSearches = [];
    protected $allowedScopeSearches = [];

    protected $allowedPartialFilters = [];
    protected $allowedExactFilters = [];
    protected $allowedCustomFilters = [];

    protected $allowedBetweenFilters = [];

    protected $allowedMust = [];
    protected $allowedScopeMust = [];
    protected $allowedMay = [];

    /**
     * @return QueryBuilder
     * @author: King
     * @version: 2019/5/9 11:28
     */
    public function queryBuilder()
    {
        if (request()->has('may') || request()->has('must')){ // may,must时需要保留部分的 search
            $search = request()->input('search', []);
            if (array_key_exists('related_project', $search)){
                $related_project = $search['related_project'];
                $search = [];
                $search['related_project'] = $related_project;
            }
            request()->offsetSet('search', $search);
        }
        $model = QueryBuilder::builder($this->getQuery());

        if (is_array($this->allowedPartialFilters)){
            collect($this->allowedPartialFilters)->each(function ($value, $key){
                $this->allowedFilters[] = AllowedFilter::partial($value, is_numeric($key) ? null : $key);
            });
        }

        if (is_array($this->allowedExactFilters)){
            collect($this->allowedExactFilters)->each(function ($value, $key){
                $this->allowedFilters[] = AllowedFilter::exact($value, is_numeric($key) ? null : $key);
            });
        }

        if (is_array($this->allowedCustomFilters)){
            collect($this->allowedCustomFilters)->each(function ($value, $class){
                if (is_array($value)){
                    collect($value)->each(function ($column) use ($class){
                        $this->allowedFilters[] = AllowedFilter::custom($column, $class);
                    });
                }else{
                    $this->allowedFilters[] = AllowedFilter::custom($value, $class);
                }
            });
        }

        if (is_array($this->allowedBetweenFilters)){
            collect($this->allowedBetweenFilters)->each(function ($val){
                $this->allowedFilters[] = AllowedFilter::scope($val);
            });
        }

        if (is_array($this->allowedScopeSearches)){
            collect($this->allowedScopeSearches)->each(function ($val){
                $this->allowedSearches[] = AllowedFilter::scope($val);
            });
        }

        if (is_array($this->allowedScopeMust)){
            collect($this->allowedScopeMust)->each(function ($val){
               $this->allowedMust[] = AllowedFilter::scope($val);
            });
        }
        //dd($this->allowedFilters);

        if (request()->has('may')){ // 存在may 不查询其他的
            $model = $model->allowedSearches($this->allowedSearches)
                ->allowedMay($this->allowedMust)
                ->allowedSorts($this->allowedSorts);
            return $model;
        }

        if (request()->has('must')){ // 存在must 不查询其他的
            $model = $model->allowedSearches($this->allowedSearches)
                ->allowedMust($this->allowedMust)
                ->allowedSorts($this->allowedSorts);
            return $model;
        }
        $model = $model->allowedFilters($this->allowedFilters)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts($this->allowedSorts)
            ->allowedSearches($this->allowedSearches);

        return $model;
    }

    /**
     * @param $limit
     * @param array $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author: King
     * @version: 2019/5/9 11:50
     */
    public function getModelsList($limit, $column = [], $operator = null, $value = null, $boolean = 'and')
    {
        $limit = intval($limit) ?: 20;
        $result = $this->queryBuilder()
            ->where($column, $operator, $value, $boolean)
            ->paginate($limit);
        $this->resetQuery();
        return $result;
    }

    public function perPage()
    {
        return 20;
    }
    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return \Illuminate\Database\Eloquent\Collection|QueryBuilder[]
     * @author: King
     * @version: 2019/5/9 11:51
     */
    public function getModels($column = [], $operator = null, $value = null, $boolean = 'and')
    {
        $result = $this->queryBuilder()
            ->where($column, $operator, $value, $boolean)
            ->get();
        $this->resetQuery();
        return $result;
    }

    /**
     * 处理 append
     * @param $collection
     */
    public function handleAppends($collection)
    {
        foreach ($this->shouldAppends as $append) {
            $this->loadAppend($collection, $append);
        }
    }

    /**
     * 加载 append
     * @param $collection
     * @param $append
     */
    public function loadAppend($collection, $append)
    {
        if (($index = strpos($append, '.')) === false) {
            if ($collection instanceof Model) {
                $collection->append($append);
            } else {
                $collection->each(function ($item) use ($append) {
                    $item->append($append);
                });
            }
        } else {
            $relation = mb_substr($append, 0, $index);
            $nextAppend = mb_substr($append, ($index + 1));
            $collection->each(function ($item) use ($relation, $nextAppend) {
                if (!empty($item->$relation)) {
                    $this->loadAppend($item->$relation, $nextAppend);
                }
            });
        }
    }
}
