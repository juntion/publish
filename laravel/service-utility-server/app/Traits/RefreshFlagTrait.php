<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait RefreshFlagTrait
{
    public $FLAG_PERMISSION = 1;
    public $FLAG_SIDEBAR = 2;

    /**
     * @return int
     */
    public function getRefreshFlag()
    {
        if ($userId = Auth::id()) {
            return $this->refreshFlagCache()->get($userId) ?? 0;
        }
        return 0;
    }

    /**
     * @return \Illuminate\Cache\TaggedCache
     */
    public function refreshFlagCache()
    {
        return Cache::tags('refresh_flag_cache');
    }

    /**
     * @param int|array $userIds 用户id集合
     * @param int $flag 刷新标志：1：权限，2：侧边栏
     * @param int $expire 过期时间，默认24小时
     */
    public function addRefreshFlag($userIds, $flag, $expire = 86400)
    {
        $userIds = Arr::wrap($userIds);
        foreach ($userIds as $userId) {
            $this->refreshFlagCache()->put($userId, $flag, $expire);
        }
    }

    /**
     * @param $userId
     */
    public function removeRefreshFlag($userId)
    {
        $this->refreshFlagCache()->forget($userId);
    }
}
