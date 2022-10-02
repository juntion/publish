<?php


namespace App\Traits\QueryBuilder;


use App\Enums\ProjectManage\QueryType;
use App\Exceptions\QueryBuilder\InvalidMustQuery;
use App\Support\QueryBuilder\Filters\MustFilter;
use App\Support\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;

trait MustQuery
{
    /** @val \Illuminate\Support\Collection */
    protected $allowedMust;
    /**
     * @val \Illuminate\Support\Collection
     */
    protected $allowedScopeMust;

    protected $mustKeyTypeAndVal;
    public function allowedMust($searches) :self
    {
        $this->allowedMust = collect(is_array($searches) ? $searches : func_get_args());

        $this->allowedScopeMust = $this->allowedMust->filter(function ($item){
            return $this->instanceofFilter($item);
        });

        $this->guardAgainstUnknownMust();
        $this->addMustToQuery($this->mustKeyTypeAndVal);
        return $this;

    }

    /**
     * 获取request 数据并格式化
     * @return \Illuminate\Support\Collection
     */
    public function must()
    {
        $mustParameter = config('query-builder.parameters.must');

        $mustParts = $this->request->query($mustParameter, []);

        if (is_string($mustParts)) {
            return collect();
        }

        $must = collect($mustParts);
        $new_must = [];
        $must->map(function ($value, $key)use (&$new_must){
           $new_must[] = $this->getMustKeyAndValue($value, $key);
        });
        $new_must = collect($new_must);
        $this->mustKeyTypeAndVal = $new_must;
        return $new_must;
    }

    /**
     * 格式化字段，条件及数据
     * @param $val
     * @param $key
     * @return \Illuminate\Support\Collection
     */
    public function getMustKeyAndValue($val, $key)
    {
        if (!Str::contains($key, ',')){
            throw InvalidMustQuery::mustTypeMiss($key);
        }
        $keys = explode(',', $key);
        if (count($keys) > 2){
            throw InvalidMustQuery::mustKeyAndTypeError($key);
        }
        $keys[1] = trim($keys[1]);
        $val = $this->checkTypeAndValue($keys[1], $keys[0], $val);
        return collect([
            'key' => collect($keys[0]),
            'value'  => collect([
                $keys[1], $val
            ]),
        ]);
    }

    /**
     * type类型验证并格式化数据
     * @param $type
     * @param $name
     * @param $val
     * @return array|\Illuminate\Support\Collection|string
     */
    protected function checkTypeAndValue($type, $name ,$val){
        switch ($type){
            case QueryType::EQUAL_TYPE:
            case QueryType::NOT_EQUAL_TYPE:
            case QueryType::GREAT_THAN_TYPE:
            case QueryType::GREAT_EQUAL_THAN_TYPE:
            case QueryType::LESS_THAN_TYPE:
            case QueryType::LESS_EQUAL_THAN_TYPE:
                if (Str::contains($val,',')){
                    return explode(',' , $val);
                }
                return $val;
            case QueryType::LIKE_TYPE:
            case QueryType::NOT_LIKE_TYPE:
                if (Str::contains($val,',')){
                    $val = collect(explode(',' , $val))->map(function ($item){
                        return '%' . $item . '%';
                    });
                    return $val->all();
                } else {
                    return "%" . $val ."%";
                }
            case QueryType::IN_LIST_TYPE:
            case QueryType::NOT_IN_LIST_TYPE:
            case QueryType::BETWEEN_TYPE:
                if (Str::contains($val,',')){
                    return explode(',' , $val);
                } else {
                    throw InvalidMustQuery::mustValueInvalid($name);
                }
            default:
                throw InvalidMustQuery::mustTypeInvalid($name, $type);
        }
    }

    /**
     * 字段验证
     */
    protected function guardAgainstUnknownMust()
    {
        $mustNames = $this->must()->map(function ($value){
            return $value['key'];
        })->flatten()->unique()->values();
        $allowedMustNames = $this->allowedMust->map(function ($item){
            return $this->getFilterName($item);
        });

        $diff = $mustNames->diff($allowedMustNames);

        if ($diff->count()) {
            throw InvalidMustQuery::mustNotAllowed($diff, $allowedMustNames);
        }
    }

    /**
     * 添加至SQL
     * @param Collection $collection
     */
    protected function addMustToQuery(Collection $collection)
    {
        $collection->each(function ($item){
            $this->where(function (Builder $query) use ($item){
                $keys = $this->findMustKeys($item['key']);
                if (in_array($keys->first(), $this->allowedScopeMust->map->getName()->toArray())){
                    $filter = $this->allowedScopeMust->first(function ($item) use ($keys){
                        return $item->getName() === $keys->first();
                    });
                    $val = $item->get('value')->toArray();
                    $val[] = 'must';
                    $filter->filter(QueryBuilder::builder($query),$val);
                }else{
                    $filter = AllowedFilter::custom(serialize($keys), new MustFilter());
                    $filter->filter(QueryBuilder::builder($query), $item['value']);
                }

            });
        });
    }

    protected function findMustKeys(Collection $property)
    {
        $allowedMust = $this->allowedMust->mapWithKeys(function ($item, $key){
            return [$key => $this->getFilterName($item)];
        });

        return $property->map(function ($item) use ($allowedMust){
            $key = $allowedMust->flip()->get($item);

            return is_numeric($key) ? $item : $key;
        });
    }
}
