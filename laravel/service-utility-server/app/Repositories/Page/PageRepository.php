<?php

namespace App\Repositories\Page;

use App\Models\Page;
use App\Repositories\BaseRepository;

class PageRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['id', 'name', 'guard_name', 'type'];

    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    public function homepages($guardName)
    {
        return $this->model->homepage()->where('guard_name', $guardName)->get();
    }

}
