<?php

namespace Modules\Base\Http\Resources\Json;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Modules\Admin\Entities\Traits\AdminPool;

trait PoolTrait
{
    use AdminPool;

    public function getZoneDatetime($datetime)
    {
        return $datetime ? Carbon::instance(Date::createFromFormat('Y-m-d H:i:s', $datetime))->toJSON() : $datetime;
    }
}
