<?php

namespace App\Repositories\Sidebar;

use App\Models\Sidebar\SidebarTemplate;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class SidebarsTemplateRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['id', 'name', 'guard_name'];

    public function __construct(SidebarTemplate $sidebarTemplate)
    {
        $this->model = $sidebarTemplate;
    }

    public function all($guardName)
    {
        return $this->model->where('guard_name', $guardName)->get();
    }

    public static function getTree(Collection $collection, $keySub = 'children')
    {
        $tree = $list = [];
        foreach ($collection as $item) {
            $list[] = $item->toArray();
            $tmp = self::getTree($item->children, $keySub);
            $data = array_merge(collect($item->toArray())->forget('children')->toArray(), [$keySub => $tmp['tree']]);
            $tree[] = $data;
            $list = array_merge($list, $tmp['list']);
        }
        return ['tree' => $tree, 'list' => $list];
    }
}
