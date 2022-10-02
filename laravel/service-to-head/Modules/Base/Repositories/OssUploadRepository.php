<?php


namespace Modules\Base\Repositories;


use Modules\Base\Entities\Base\OssTempUpload;

class OssUploadRepository
{
    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getTempInfo($uuid)
    {
        return OssTempUpload::query()->find($uuid);
    }

    /**
     * @param $uuid
     * @return bool
     * @throws \Exception
     */
    public function deleteTemp($uuid)
    {
        OssTempUpload::query()->find($uuid)->delete();
        return true;
    }
}
