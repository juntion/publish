<?php

namespace Modules\Base\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Base\Exceptions\BaseException;
use Modules\Base\Http\Requests\ListRequest;
use Modules\Base\Contracts\ListServiceInterface;

class ListService implements ListServiceInterface
{
    private $builder;
    private $request;

    public function setBuilder($builder)
    {
        if ($builder instanceof Model) {
            $this->builder = $builder->newQuery();
            return;
        }

        if ($builder instanceof Relation || $builder instanceof Builder || $builder instanceof QueryBuilder) {
            $this->builder = $builder;
            return;
        }

        throw new BaseException(__('base::error.listSetBuilderException'));
    }

    public function setRequest(ListRequest $request)
    {
        $this->request = $request;
    }

    public function getResource()
    {
        if (!$this->builder || !$this->request) {
            throw new BaseException(__('base::error.listException'));
        }

        $this->setFilterAndSortByRequest();

        if ($this->request->isPaginate()) {
//            $page = $this->request->query('page') ? (int)$this->request->query('page') : null;
            $limit = $this->request->query('limit') ? (int)$this->request->query('limit') : null;
            $paginate = $limit ? $this->builder->paginate($limit) : $this->builder->paginate();

            return $paginate;
        } else {
            return $this->builder->get();
        }
    }

    /**
     * 设置过滤和排序
     */
    private function setFilterAndSortByRequest()
    {
        $filter = $this->request->query('filter') ?: [];
        $sort = $this->request->query('sort') ?: [];
        $allowFilter = $this->request->allowFilter();
        $allowSort = $this->request->allowSort();

        if (sizeof($filter)) {
            foreach ($filter as $key => $value) {
                if (in_array($key, $allowFilter)) $this->builder->where($key, $value);
            }
        }
        if (sizeof($sort)) {
            foreach ($sort as $key => $value) {
                if (in_array($key, $allowSort)) $this->builder->orderBy($key, $value);
            }
        }
    }
}
