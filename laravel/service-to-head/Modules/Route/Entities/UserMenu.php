<?php

namespace Modules\Route\Entities;

use Modules\Base\Contracts\CacheAble\Cache;

/**
 * 缓存用户对应的侧边栏
 *
 * 缓存的field  为用户的uuid
 * 缓存的value  为用户的侧边栏结构数组
 *
 * [
 * 'userUuid'=>[
 *                 [
 *                     'uuid'=>'',
 *                     'parent_uuid'=>'',
 *                     'node_type'=>'',
 *                     'sort'=>'',
 *                     'children'=>[],
 *                 ]
 *             ]
 * ]
 */
class UserMenu extends Cache
{
    /** 将侧边栏树的数据 转换成需要存的数据
     * @param $value
     * @return array|mixed
     */
    protected function dataBuild($value)
    {
        return $this->getRelateByTree($value);
    }

    /** 将缓存数据转换成 侧边栏树
     * @param $value
     * @return array|mixed
     */
    protected function dataResolve($value)
    {
        return $this->getTreeByRelate($value);
    }

    private function getRelateByTree($tree)
    {
        $relate = [];
        foreach ($tree as $node) {
            $n = [];
            $n['uuid'] = $node['uuid'];
            $n['parent_uuid'] = $node['parent_uuid'];
            $n['node_type'] = $node['node_type'];
            $n['sort'] = $node['sort'];

            if ($node['node_type'] == 'menu') {
                $n['children'] = [];
                if (sizeof($node['children'])) {
                    $n['children'] = $this->getRelateByTree($node['children']);
                }
            }

            $relate[] = $n;
        }

        return $relate;
    }

    private function getTreeByRelate($relate)
    {
        $tree = [];

        foreach ($relate as $node) {
            $modal = null;
            if ($node['node_type'] == 'menu') {
                $modal = $this->getMenuByUuid($node['uuid']);
            }
            if ($node['node_type'] == 'route') {
                $modal = $this->getRouteByUuid($node['uuid']);
            }

            if ($node['node_type'] == 'menu' && sizeof($node['children'])) {
                $node['children'] = $this->getTreeByRelate($node['children']);
            }

            $tree[] = array_merge($node, $modal->attributesToArray());
        }

        return $tree;
    }

    private function getMenuByUuid($uuid)
    {
        if (method_exists(RouteMenu::class, 'findFromCache')) {
            return RouteMenu::findFromCache($uuid);
        }
        return RouteMenu::find($uuid);
    }

    private function getRouteByUuid($uuid)
    {
        if (method_exists(Route::class, 'findFromCache')) {
            return Route::findFromCache($uuid);
        }
        return Route::find($uuid);
    }
}
