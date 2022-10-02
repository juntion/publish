<?php


namespace App\Support\QueryBuilder\Filters;


use App\Enums\ProjectManage\QueryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\Filters\Filter;
use Spatie\QueryBuilder\Filters\FiltersExact;

class MustFilter extends FiltersExact implements Filter
{
    protected $colTimeType = ['created_at', 'finish_time', 'verify_time'];
    public function __invoke(Builder $query, $value, string $property) : Builder
    {
        $property = unserialize($property);
        $type = $value[0];
        $mustValues = $value[1];
        collect($property)->each(function ($key) use ($query, $type, $mustValues, $value){
            if ($this->isRelationProperty($query, $key)){
                $this->withRelationConstraint($query, $value, $key);
            } else {
                $this->getSqlByTypeAndVal($query, $type, $mustValues, $key);
            }
        });
        return $query;
    }


    public function getSqlByTypeAndVal($query, $type, $val, $name)
    {
        switch ($type){
            case QueryType::EQUAL_TYPE:
            case QueryType::IN_LIST_TYPE:
                if (is_array($val)){
                    return $query->whereIn($name, $val);
                } else {
                    return $query->where($name, $val);
                }
            case QueryType::NOT_EQUAL_TYPE:
            case QueryType::NOT_IN_LIST_TYPE:
                if (is_array($val)){
                    return $query->whereNotIn($name, $val);
                } else {
                    return $query->where($name, "!=", $val);
                }
            case QueryType::GREAT_THAN_TYPE:
                $str = '>';
                $this->returnSQLByTypeStr($query, $name, $val, $str);
                break;
            case QueryType::GREAT_EQUAL_THAN_TYPE:
                $str = '>=';
                $this->returnSQLByTypeStr($query, $name, $val, $str);
                break;
            case QueryType::LESS_THAN_TYPE:
                $str = '<';
                $this->returnSQLByTypeStr($query, $name, $val, $str);
                break;
            case QueryType::LESS_EQUAL_THAN_TYPE:
                $str = '<=';
                $this->returnSQLByTypeStr($query, $name, $val, $str);
                break;
            case QueryType::LIKE_TYPE:
                $str = 'like';
                $this->returnSQLByTypeStr($query, $name, $val, $str);
                break;
            case QueryType::NOT_LIKE_TYPE:
                $str = 'not like';
                $this->returnSQLByTypeStr($query, $name, $val, $str);
                break;
            case QueryType::BETWEEN_TYPE:
                collect($val)->chunk(2)->each(function ($item, $key)use($query, $name){
                    $item = collect($item);
                    if (in_array($name, $this->colTimeType)){
                        if ($item->first() != ""){
                            $query->where($name, ">=", trim($item->first()) . " 00:00:00");
                        }
                        if ($item->last() != ''){
                            $query->where($name, "<=",trim($item->last()). " 23:59:59");
                        }
                    } else {
                        if ($item->first() != ""){
                            $query->where($name, ">=", $item->first());
                        }
                        if ($item->last() != ''){
                            $query->where($name, "<=", $item->last());
                        }
                    }
                });
                break;
        }
    }

    protected function returnSQLByTypeStr($query, $name, $val, $str)
    {
        if (is_array($val)){
            collect($val)->each(function ($item)use ($query, $name, $str){
                $query->where($name, $str, $item);
            });
        } else {
            return $query->where($name, $str , $val);
        }
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

        return $query->WhereHas($relation, function (Builder $query) use ($value, $relation, $property) {
            $this->relationConstraints[] = $property = $query->getModel()->getTable().'.'.$property;

            $query->where(function (Builder $query) use ($value, $property){
                $this->__invoke($query, $value, serialize(collect($property)));
            });
        });
    }
}
