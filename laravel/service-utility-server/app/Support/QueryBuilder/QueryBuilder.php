<?php

namespace App\Support\QueryBuilder;

use App\Traits\QueryBuilder\MayQuery;
use App\Traits\QueryBuilder\MustQuery;
use App\Traits\QueryBuilder\SearchesQuery;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class QueryBuilder extends \Spatie\QueryBuilder\QueryBuilder
{
    use SearchesQuery, MustQuery, MayQuery;

    public static function builder($baseQuery, ?Request $request = null): QueryBuilder
    {
        if (is_string($baseQuery)) {
            $baseQuery = ($baseQuery)::query();
        }

        return new static($baseQuery, $request ?? request());
    }

    public function allowedFilters($filters): \Spatie\QueryBuilder\QueryBuilder
    {
        $filters = is_array($filters) ? $filters : func_get_args();
        $this->allowedFilters = collect($filters)->map(function ($filter, $key) {
            if ($this->instanceofFilter($filter)) {
                return $filter;
            }

            return AllowedFilter::partial($filter, is_numeric($key) ? null : $key);
        });

        $this->ensureAllFiltersExist();

        $this->addFiltersToQuery();

        return $this;
    }

    /**
     * @param $object
     * @return bool
     */
    public function instanceofFilter($object)
    {
        return $object instanceof AllowedFilter;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function getFilterName($property)
    {
        if ($this->instanceofFilter($property)) {
            return $property->getName();
        }

        return $property;
    }
}
