<?php

namespace App\Exceptions\QueryBuilder;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;

class InvalidEitherQuery extends InvalidQuery
{
    /**
     * @param Collection $unknownEither
     * @param Collection $allowedEither
     * @return InvalidEitherQuery
     * @author: King
     * @version: 2019/12/19 14:09
     */
    public static function eitherNotAllowed(Collection $unknownEither, Collection $allowedEither)
    {
        $unknownEither = $unknownEither->implode(', ');
        $allowedEither = $allowedEither->implode(', ');
        $message = "Given column(s) `{$unknownEither}` are not allowed. Allowed column(s) are `{$allowedEither}`.";
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }

    /**
     * @param Collection $paramKeys
     * @param Collection $paramValues
     * @return InvalidEitherQuery
     * @author: King
     * @version: 2019/12/19 14:14
     */
    public static function eitherParametersValuesLengthError(Collection $paramKeys, Collection $paramValues)
    {
        $paramKeys = $paramKeys->implode(',');
        $paramValues = $paramValues->implode(';');
        $message = 'The correspondence between parameters (' . $paramKeys . ') and values (' . $paramValues . ')  does not match';
        return new static(Response::HTTP_BAD_REQUEST, $message);
    }
}
