<?php


namespace App\Traits\QueryBuilder;

use App\Exceptions\QueryBuilder\InvalidMustQuery;
use App\Support\QueryBuilder\Filters\MayFilter;
use App\Support\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;

trait MayQuery
{
    /** @val \Illuminate\Support\Collection */
    protected $allowedMay;
    /**
     * @val \Illuminate\Support\Collection
     */
    protected $allowedScopeMay;

    protected $mayKeyTypeAndVal;
    public function allowedMay($searches) :self
    {
        $this->allowedMay = collect(is_array($searches) ? $searches : func_get_args());

        $this->allowedScopeMay = $this->allowedMay->filter(function ($item){
            return $this->instanceofFilter($item);
        });

        $this->guardAgainstUnknownMay();
        $this->addMayToQuery($this->mayKeyTypeAndVal);
        return $this;

    }

    /**
     * 获取request 数据并格式化
     * @return \Illuminate\Support\Collection
     */
    public function may()
    {
        $mayParameter = config('query-builder.parameters.may');

        $mayParts = $this->request->query($mayParameter, []);

        if (is_string($mayParts)) {
            return collect();
        }

        $may = collect($mayParts);
        $new_may = [];
        $may->map(function ($value, $key)use (&$new_may){
            $new_may[] = $this->getMustKeyAndValue($value, $key);
        });
        $new_may = collect($new_may);
        $this->mayKeyTypeAndVal = $new_may;
        return $new_may;
    }

    /**
     * 字段验证
     */
    protected function guardAgainstUnknownMay()
    {
        $mayNames = $this->may()->map(function ($value){
            return $value['key'];
        })->flatten()->unique()->values();
        $allowedMayNames = $this->allowedMay->map(function ($item){
            return $this->getFilterName($item);
        });
        $diff = $mayNames->diff($allowedMayNames);

        if ($diff->count()) {
            throw InvalidMustQuery::mustNotAllowed($diff, $allowedMayNames);
        }
    }

    /**
     * 添加至SQL
     * @param Collection $collection
     */
    protected function addMayToQuery(Collection $collection)
    {
        $this->where(function ($q)use($collection){
            $collection->each(function ($item)use($q){
                $q->orWhere(function (Builder $query) use ($item){
                    $keys = $this->findMayKeys($item['key']);
                    if (in_array($keys->first(), $this->allowedScopeMay->map->getName()->toArray())){
                        $filter = $this->allowedScopeMay->first(function ($item) use ($keys){
                            return $item->getName() === $keys->first();
                        });
                        $val = $item->get('value')->toArray();
                        $val[] = 'may';
                        $filter->filter(QueryBuilder::builder($query),$val);
                    }else{
                        $filter = AllowedFilter::custom(serialize($keys), new MayFilter());
                        $filter->filter(QueryBuilder::builder($query), $item['value']);
                    }

                });
            });
        });
    }

    protected function findMayKeys(Collection $property)
    {
        $allowedMay = $this->allowedMay->mapWithKeys(function ($item, $key){
            return [$key => $this->getFilterName($item)];
        });

        return $property->map(function ($item) use ($allowedMay){
            $key = $allowedMay->flip()->get($item);

            return is_numeric($key) ? $item : $key;
        });
    }
}
