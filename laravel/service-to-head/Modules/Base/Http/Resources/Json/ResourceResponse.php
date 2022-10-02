<?php


namespace Modules\Base\Http\Resources\Json;

use Illuminate\Http\Resources\Json\ResourceResponse as RR;
use Modules\Base\Support\Response\ResponseStatusTrait;

class ResourceResponse extends RR
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return tap(response()->json(
            [
                'status' => ResponseStatusTrait::$successStatus,
                'code' => $this->calculateStatus(),
                'message' => __('base::base.successDo'),
                'data' => $this->wrap(
                    $this->resource->resolve($request),
                    $this->resource->with($request),
                    $this->resource->additional
                ),
            ],
            $this->calculateStatus()
        ), function ($response) use ($request) {
            $response->original = $this->resource->resource;

            $this->resource->withResponse($request, $response);
        });
    }
}
