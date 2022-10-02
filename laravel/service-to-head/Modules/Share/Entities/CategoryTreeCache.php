<?php


namespace Modules\Share\Entities;

use Modules\Base\Contracts\CacheAble\Cache;
use Modules\Share\Transformers\Categories\CategoryResource;

class CategoryTreeCache extends Cache
{
    public function dataBuild($value) // 存对应的树状结构
    {
        $delete = 'null';
        if ($filter = request()->input('filter')) {
            $delete = $filter['deleted_at'];
        }
        return $this->getRelateByTree($value, $delete);
    }


    public function dataResolve($value) // 释放对应的树状结构
    {
        $delete = 'null';
        if ($filter = request()->input('filter')) {
            $delete = $filter['deleted_at'];
        }

        return $this->getTreeByRelate($value, $delete);
    }

    public function getRelateByTree($tree, $delete)
    {
        $relate = [];
        foreach ($tree as $item) {
            $n = [
                'uuid'     => $item->uuid,
                'children' => [],
            ];
            $child = $item->children()->withTrashed()->orderBy('sort','ASC')->get();
            if ($child->isNotEmpty()) {
                $n['children'] = $this->getRelateByTree($child, $delete);
            }
            $relate[] = $n;
        }
        return $relate;
    }

    public function getTreeByRelate($val, $delete)
    {
        $tree = [];
        foreach ($val as $cate) {
            $modal = $this->getCateByUuid($cate['uuid']);
            if ($delete == 'not_null' && is_null($modal->deleted_at)){ // 未关闭的剔除
                continue;
            } elseif ($delete == 'null' && !is_null($modal->deleted_at)) { // 已关闭的剔除
                continue;
            }
            if (!empty($cate['children'])) {
                $cate['children'] = $this->getTreeByRelate($cate['children'], $delete);
            }
            $res = collect(new CategoryResource($modal));
            $tree[] = $res->merge(collect($cate))->toArray();
        }
        return $tree;
    }

    private function getCateByUuid($uuid)
    {
        if (method_exists(ResourceCategory::class, 'findFromCache')) {
            return ResourceCategory::findFromCache($uuid);
        }
        return ResourceCategory::query()->withTrashed()->find($uuid);
    }
}
