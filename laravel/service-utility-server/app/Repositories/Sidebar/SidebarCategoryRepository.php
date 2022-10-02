<?php

namespace App\Repositories\Sidebar;

use App\Models\Sidebar\SidebarCategory;
use App\Repositories\BaseRepository;

class SidebarCategoryRepository extends BaseRepository
{
    protected $model;

    public function __construct(SidebarCategory $sidebarCategory)
    {
        $this->model = $sidebarCategory;
    }

}