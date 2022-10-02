<?php

namespace App\Traits\QueryBuilder;

use App\Exceptions\QueryBuilder\InvalidSearchQuery;
use App\Support\QueryBuilder\Filters\SearchFilter;
use App\Support\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;

trait SearchesQuery
{
    /** @var \Illuminate\Support\Collection */
    protected $allowedSearches;

    /** @var \Illuminate\Support\Collection */
    protected $allowedScopeSearches;

    protected $allowedScopeSearchesNames;

    /**
     * @param $searches
     * @return SearchesQuery
     * @author: King
     * @version: 2019/5/21 11:32
     */
    public function allowedSearches($searches): self
    {
        $this->allowedSearches = collect(is_array($searches) ? $searches : func_get_args());

        $this->allowedScopeSearches = $this->allowedSearches->filter(function ($item){
            return $this->instanceofFilter($item);
        });

        $this->allowedScopeSearchesNames = $this->allowedScopeSearches->map->getName()->toArray();

        $this->guardAgainstUnknownSearches();

        $this->addSearchesToQuery($this->searches());

        return $this;
    }

    /**
     * @param Collection $searches
     * @author: King
     * @version: 2019/5/21 11:32
     */
    protected function addSearchesToQuery(Collection $searches)
    {
        $searches->each(function (Collection $item){
            $this->where(function (Builder $query) use ($item){
                $keys = $this->findSearchesKeys($item['keys']);

                if (in_array($keys->first(), $this->allowedScopeSearchesNames)){
                    $filter = $this->allowedScopeSearches->first(function ($item) use ($keys){
                        return $item->getName() === $keys->first();
                    });
                    $item->get('values')->each(function (Collection $val) use ($query, $filter){
                        $query->orWhere(function (Builder $query) use ($val, $filter){
                            $filter->filter(QueryBuilder::builder($query), $val->toArray());
                        });
                    });
                }else{
                    $filter = AllowedFilter::custom(serialize($keys), new SearchFilter());
                    $filter->filter(QueryBuilder::builder($query), $item['values']);
                }

            });
        });
    }

    /**
     * @param Collection $property
     * @return Collection
     * @author: King
     * @version: 2019/12/21 10:42
     */
    protected function findSearchesKeys(Collection $property)
    {
        $allowedSearches = $this->allowedSearches->mapWithKeys(function ($item, $key){
            return [$key => $this->getFilterName($item)];
        });

        return $property->map(function ($item) use ($allowedSearches){
            $key = $allowedSearches->flip()->get($item);

            return is_numeric($key) ? $item : $key;
        });
    }

    /**
     * @return Collection
     * @author: King
     * @version: 2019/5/21 11:32
     */
    protected function searches()
    {
        $searchParameter = config('query-builder.parameters.search');

        $searchParts = $this->request->query($searchParameter, []);

        if (is_string($searchParts)) {
            return collect();
        }

        $searches = collect($searchParts);

        return $searches->map(function ($value, $key){
            return $this->getSearchesKeyAndValue($value, $key);
        });
    }

    /**
     * @param $value
     * @param $key
     * @return Collection
     * @author: King
     * @version: 2019/12/21 10:42
     */
    protected function getSearchesKeyAndValue($value, $key)
    {
        $keys = getExplodeValue($key);

        if (in_array($keys->first(), $this->allowedScopeSearchesNames)){
            $scopeGroupValues = getExplodeValue($value, ';');
            $values = $scopeGroupValues->map(function ($value){
                return getExplodeValue($value);
            });
        }else{
            $values = getExplodeValue($value);
        }

        return collect(['keys' => $keys, 'values' => $values]);
    }

    /**
     * @author: King
     * @version: 2019/5/21 10:29
     */
    protected function guardAgainstUnknownSearches()
    {
        $searchNames = $this->searches()->map(function ($value){
            return $value['keys'];
        })->flatten()->unique()->values();

        $allowedSearchesNames = $this->allowedSearches->map(function ($item){
            return $this->getFilterName($item);
        });

        $diff = $searchNames->diff($allowedSearchesNames);

        if ($diff->count()) {
            throw InvalidSearchQuery::searchesNotAllowed($diff, $this->allowedSearches);
        }
    }
}
