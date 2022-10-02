<?php

namespace App\Exceptions\QueryBuilder;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;

class InvalidMustQuery extends InvalidQuery
{
    public static function mustNotAllowed(Collection $unknownMust, Collection $allowedMust)
    {
        $unknownMust = $unknownMust->implode(', ');
        $allowedMust = $allowedMust->implode(', ');
        $message = "Given column(s) `{$unknownMust}` are not allowed. Allowed column(s) are `{$allowedMust}`.";
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }


    public static function mustValueInvalid($name)
    {
        $message = "传值错误！{$name} 该筛选条件下 必须是包含有‘,’ 的字符串类型";
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }

    public static function mustTypeInvalid($name, $type)
    {
        $message = "传值错误！{$name} 不支持{$type}类型的筛选";
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }

    public static function mustTypeMiss($name)
    {
        $message = "传值错误！{$name} 缺少类型约束";
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }

    public static function mustKeyAndTypeError($name)
    {
        $message = "传值错误！筛选的键必须是 [a,b]形式,所传键为 {$name}";
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }
}
