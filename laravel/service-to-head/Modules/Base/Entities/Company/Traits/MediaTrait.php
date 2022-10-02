<?php


namespace Modules\Base\Entities\Company\Traits;


use Modules\Base\Entities\Company\CompanyMedia;

trait MediaTrait
{
    public function mediaData($media = 'media')
    {
        $medias = $this->$media()->orderBy('created_at', 'desc')->get();
        $result = $medias->map(function ($item) {
            $data['uuid'] = $item->uuid;
            $data['name'] = $item->name;
            $data['path'] = $item->path;
            $data['size'] = $item->size;
            return $data;
        });
        return $result;
    }

    public function media()
    {
        return $this->morphMany(CompanyMedia::class, 'model', 'model_type', 'model_uuid');
    }
}
