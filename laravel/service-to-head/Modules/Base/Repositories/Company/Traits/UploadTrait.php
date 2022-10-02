<?php


namespace Modules\Base\Repositories\Company\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Base\Entities\Model;

trait UploadTrait
{
    public function deleteMedia(Model $model, array $uuids)
    {
        if(empty($uuids)){
            $model->media()->get()->map(function ($item){
                $item->delete();
            });
        } else {
            $model->media()->whereNotIn('uuid',$uuids)->get()->map(function ($item){
                $item->delete();
            });
        }
    }

    public function addMedia(Model $model, array $files)
    {
        $mediaCollection = $model->getMediaCollection();
        $disk = 'base';
        $user = Auth::user();
        foreach ($files as $file){
            $name = $file->getClientOriginalName();
            $hashName = md5($name . time());
            $path = 'company/'. $mediaCollection . '/'. substr($hashName, 0, 2) .'/'. substr($hashName, 2, 2);
            $path = Storage::disk($disk)->putFile($path, $file);
            $fileData = [
                'uuid'       => Str::uuid()->getHex()->toString(),
                'admin_uuid' => $user->uuid,
                'admin_name' => $user->name,
                'size'       => $file->getSize(),
                'name'       => $name,
                'path'       => $path
            ];
            $model->media()->create($fileData);
        }
    }
}
