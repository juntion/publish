<?php

namespace App\Support\QueryBuilder\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\Filters\Filter;
use Spatie\QueryBuilder\Filters\FiltersExact;

class SearchFilter extends FiltersExact implements Filter
{
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        $property = unserialize($property);

        if ($value instanceof Collection || is_array($value)) {
            $partial = collect($value)->filter(function ($item){
                return $this->fuzzyMatching($item);
            });
            $exact = collect($value)->diff($partial);
        }else{
            $partial = collect();
            $exact = collect([$value]);
            if ($this->fuzzyMatching($value)){
                $partial = collect([$value]);
                $exact = collect();
            }
        }

        collect($property)->each(function ($key) use ($query, $value, $partial, $exact){
            if ($this->isRelationProperty($query, $key)) {
                $this->withRelationConstraint($query, $value, $key);
            }else{
                if ($partial->count()){
                    $wrappedProperty = $query->getQuery()->getGrammar()->wrap($key);

                    $sql = "LOWER({$wrappedProperty}) LIKE ?";

                    $partial->each(function ($partialValue) use ($query, $wrappedProperty, $sql){
                        $partialValue = mb_strtolower($partialValue, 'UTF8');

                        $query->orWhereRaw($sql, [$partialValue]);
                    });
                }

                if ($exact->count() > 1){
                    $query->orWhereIn($key, $exact);
                }elseif ($exact->count() === 1){
                    $query->orWhere($key, $exact->first());
                }
            }
        });

        return $query;
    }

    protected function withRelationConstraint(Builder $query, $value, string $property) : Builder
    {
        [$relation, $property] = collect(explode('.', $property))
            ->pipe(function (Collection $parts) {
                return [
                    $parts->except(count($parts) - 1)->map([Str::class, 'camel'])->implode('.'),
                    $parts->last(),
                ];
            });

        return $query->orWhereHas($relation, function (Builder $query) use ($value, $relation, $property) {
            $this->relationConstraints[] = $property = $query->getModel()->getTable().'.'.$property;

            $query->where(function (Builder $query) use ($value, $property){
                $this->__invoke($query, $value, serialize(collect($property)));
            });
        });
    }

    /**
     * 是否使用模糊匹配
     * @param $value
     * @return bool
     * @author: King
     * @version: 2019/12/20 14:54
     */
    protected function fuzzyMatching($value)
    {
        return Str::startsWith($value, '%') || Str::endsWith($value, '%');
    }
}
