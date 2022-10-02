<?php


namespace Modules\Finance\Entities\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Base\Entities\Model;

trait UpdateLogTrait
{
    public static function bootUpdateLogTrait()
    {
        static::updated(function (Model $model) {
            $dirtyData = $model->getDirty();
            $dirtyKeys = array_keys($dirtyData);
            $originData = [];
            foreach ($dirtyKeys as $dirtyKey) {
                $originData[$dirtyKey] = $model->getOriginal($dirtyKey);
            }
            $log = compact('dirtyData', 'originData');
            if ($user = Auth::user()) {
                $log['admin_uuid'] = $user->uuid;
                $log['admin_name'] = $user->name;
            } elseif (request()->input('admin_id')) {
                $log['admin_id'] = request()->input('admin_id');
            }
            $log['route_name'] = Route::currentRouteName();
            $insertData = [
                'uuid' => $model->uuid,
                'log' => $log
            ];
            $model->logs()->create($insertData);
        });
    }
}
