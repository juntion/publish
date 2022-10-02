<?php


namespace App\Traits;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait IsUpdateTrait
{
    public function getCacheInstance()
    {
        return Cache::tags(['pm','isUpdated', $this->cacheName]);
    }

    public function getIsUpdatedAttribute()
    {
        $key = $this->cacheName ."_id_" . $this->id . '_user_id_' . Auth::id();
        return intval($this->getCacheInstance()->get($key));
    }

    /**
     * @param $userId array,Collection,id
     * @param int $expiration
     */
    public function setIsUpdated($userId = "",int $expiration = 30)
    {
        if ($userId instanceof Collection){
            $userId->map(function ($item)use ($expiration){
                $this->setIsUpdated($item, $expiration);
            });
        }else if (is_array($userId)){
            foreach ($userId as $v){
                $this->setIsUpdated($v, $expiration);
            }
        } else {
            $userId = $userId == "" ? Auth::id() : $userId;
            $key = $this->cacheName ."_id_" . $this->id . '_user_id_' .$userId;
            $expiration = now()->addDays($expiration); // 默认30天过期
            $this->getCacheInstance()->put($key, 1, $expiration);
        }
    }

    /**
     * @param mixed ...$id
     */
    public function deleteIsUpdated()
    {
        $key = $this->cacheName ."_id_" . $this->id . '_user_id_' . Auth::id();
        $this->getCacheInstance()->forget($key);
    }
}
