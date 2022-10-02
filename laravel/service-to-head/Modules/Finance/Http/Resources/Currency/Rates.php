<?php


namespace Modules\Finance\Http\Resources\Currency;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class Rates extends ResourceCollection
{
    static public $wrap = "rates";

    public function toArray($request)
    {
        return $this->collection->map(function ($rate) {
            return [
                "base_currency" => $rate->base_currency,
                "source_currency" => $rate->source_currency,
                "value" => $rate->value,
            ];
        })->all();
    }
}
