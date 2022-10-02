<?php

namespace Modules\Share\Transformers\Resource;

use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Base\Support\Facades\OssService;

class BatchDownloadResource extends ResourceCollection
{

    public static $wrap = 'urls';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $is_watermark = $request->input('is_watermark') ?? 0;
        return $this->collection->map(function ($resource) use ($is_watermark) {
            if ($resource->type == 'picture' && $is_watermark) {
                return OssService::imageWatermark($resource->object, config('oss.watermark_base64'), 'fill_1');
            }
            return OssService::getSignUrl($resource->object);
        })->all();
    }
}
