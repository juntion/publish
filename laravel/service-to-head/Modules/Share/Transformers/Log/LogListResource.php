<?php

namespace Modules\Share\Transformers\Log;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class LogListResource extends ResourceCollection
{
    public static $wrap = 'logs';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($log) {
            return [
                'created_at' => $this->getZoneDatetime($log->created_at),
                'log'        => $log->log,
            ];
        })->all();
    }
}
