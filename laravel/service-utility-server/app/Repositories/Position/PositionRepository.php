<?php

namespace App\Repositories\Position;

use App\Models\Position;
use App\Repositories\BaseRepository;

class PositionRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['id', 'number', 'is_system', 'name'];

    protected $allowedIncludes = ['posts',];

    public function __construct(Position $position)
    {
        $this->model = $position;
    }

}
