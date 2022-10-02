<?php


namespace Modules\Share\Repositories\Traits;


use Modules\Share\Entities\Collection;
use Modules\Share\Entities\Resource;
use Modules\Share\Entities\ResourceDownload;
use Modules\Share\Entities\UserStats;
use Modules\Share\Entities\Viewed;

trait UpdateRedisTrait
{
    public function getStatsBySql($key)
    {
        $collection = Collection::query()->where('admin_uuid', $key)->count();
        $upload = Resource::query()->where('creator_uuid', $key)->count();
        $download = ResourceDownload::query()->where('admin_uuid', $key)->count();
        $viewed = Viewed::query()->where('admin_uuid', $key)->count();
        $stats = compact('collection', 'upload', 'download', 'viewed');
        return $stats;
    }

    // 查询 并将 数据 插入redis
    public function pushUserStatsIntoRedis(UserStats $cache, $key)
    {
        $stats = $this->getStatsBySql($key);
        $cache->save($key, $stats);
        return $stats;
    }

    public function pushDataIntoRedis(UserStats $cache, $key, $data)
    {
        $cache->save($key, $data);
    }

    public function updateStatsData($adminUuid, $index, $num = 1)
    {
        $cache = new UserStats();
        if ($cache->exists($adminUuid)) {
            $data = $cache->find($adminUuid);
            $data[$index] = $data[$index] + $num;
            $this->pushDataIntoRedis($cache, $adminUuid, $data);
        } else {
            $this->pushUserStatsIntoRedis($cache, $adminUuid);
        }
    }
}
