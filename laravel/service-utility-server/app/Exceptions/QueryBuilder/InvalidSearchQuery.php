<?php

namespace App\Exceptions\QueryBuilder;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;

class InvalidSearchQuery extends InvalidQuery
{
    /** @var \Illuminate\Support\Collection */
    public $unknownSearches;

    /** @var \Illuminate\Support\Collection */
    public $allowedSearches;

    public function __construct(Collection $unknownSearches, Collection $allowedSearches)
    {
        $this->unknownSearches = $unknownSearches;
        $this->allowedSearches = $allowedSearches;

        $unknownSearches = $this->unknownSearches->implode(', ');
        $allowedSearches = $this->allowedSearches->implode(', ');
        $message = "Given search(es) `{$unknownSearches}` are not allowed. Allowed search(es) are `{$allowedSearches}`.";

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    public static function searchesNotAllowed(Collection $unknownSearches, Collection $allowedSearches)
    {
        return new static(...func_get_args());
    }
}
