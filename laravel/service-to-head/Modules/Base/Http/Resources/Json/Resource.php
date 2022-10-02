<?php


namespace Modules\Base\Http\Resources\Json;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    use PoolTrait;

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request);
    }
}
