<?php


namespace Modules\Base\Http\Resources\Json;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as PRR;
use Modules\Base\Support\Response\ResponseStatusTrait;

class PaginatedResourceResponse extends PRR
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
                'data' => $this->wrap(
                    $this->resource->resolve($request),
                    array_merge_recursive(
                        $this->paginationInformation($request),
                        $this->resource->with($request),
                        $this->resource->additional
                    )
                ),
            ],
            $this->calculateStatus()
        ), function ($response) use ($request) {
            $response->original = $this->resource->resource->map(function ($item) {
                return is_array($item) ? Arr::get($item, 'resource') : ($item->resource ?? $item);
            });

            $this->resource->withResponse($request, $response);
        });
    }

    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginate = $this->resource->resource;

        return [
            'paginate' => [
                'current_page' => $paginate->currentPage(),
                'first_page_url' => $paginate->url(1),
                'from' => $paginate->firstItem(),
                'last_page' => $paginate->lastPage(),
                'last_page_url' => $paginate->url($paginate->lastPage()),
                'next_page_url' => $paginate->nextPageUrl(),
                'path' => $paginate->path(),
                'per_page' => $paginate->perPage(),
                'prev_page_url' => $paginate->previousPageUrl(),
                'to' => $paginate->lastItem(),
                'total' => $paginate->total(),
            ]
        ];
    }
}
