<?php

namespace Modules\Base\Criteria;

use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Modules\Base\Http\Requests\ListRequest;

class ListRequestCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(ListRequest $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $filter = $this->request->query('filter') ?: [];
        $sort = $this->request->query('sort') ?: [];
        $allowFilter = $this->request->allowFilter();
        $allowSort = $this->request->allowSort();

        if (sizeof($filter)) {
            foreach ($filter as $key => $value) {
                if (is_null($value)) {
                    continue;
                }
                if (in_array($key, $allowFilter)) {
                    if ($this->request->isScopeQuery($key)) {
                        $model = $model->where(function ($q)use ($key, $value){
                            return $this->request->mappingScopeQuery($q, $key, $value);
                        });
                    } else {
                        $model = $model->where($this->mappingKey($key) ?? $key, $value);
                    }
                }
            }
        }
        if (sizeof($sort)) {
            foreach ($sort as $key => $value) {
                if (in_array($key, $allowSort)) $model = $model->orderBy($this->mappingKey($key) ?? $key, $value);
            }
        }

        return $model;
    }

    /**
     * @param $key
     * @return string|void
     */
    protected function mappingKey($key)
    {
//        当请求的键 和 sql 的字段不一样时，在子类中将请求的字段映射过去,例：
//        switch ($key) {
//            case 'customer_uuid':
//                return 'customer_resources.uuid';
//                break;
//            case 'customer_number':
//                return 'customer_resources.number';
//                break;
//        }
//        return;
    }

    protected function mappingScopeQuery(Builder $query)
    {

    }

    protected function isScopeQuery($key)
    {

    }
}
