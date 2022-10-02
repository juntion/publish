<?php


namespace Modules\Finance\Repositories\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Base\Entities\Model;

trait UploadTrait
{
    public function addMedia(Model $model, array $files, $prefix = "" ,$type = 0)
    {
        $mediaCollection = $model->getMediaCollection();
        $disk = 'finance';
        foreach ($files as $file) {
            $uuid = Str::uuid()->getHex()->toString();
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storageName = $uuid . '.' . $extension;
            $path = $prefix.$mediaCollection.'/'.substr($uuid, 0, 2).'/'.substr($uuid, 2, 2);
            Storage::disk($disk)->putFileAs($path, $file, $storageName);
            $fileData = [
                'uuid'         => $uuid,
                'name'         => $name,
                'storage_name' => $storageName,
                'path'         => $path,
                'created_at'   => Carbon::now(),
            ];

            if ($type > 0) {
                $fileData['type'] = $type;
            }
            $model->media()->create($fileData);
        }
    }

    public function deleteMedia(Model $model)
    {
        $model->media()->get()->map(function ($item){
            $item->delete();
        });
    }

}
