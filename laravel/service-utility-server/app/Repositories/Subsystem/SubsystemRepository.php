<?php

namespace App\Repositories\Subsystem;

use App\Models\Subsystem;
use App\Repositories\BaseRepository;

class SubsystemRepository extends BaseRepository
{
    protected $model;

    protected $allowedSearches = ['id', 'name', 'guard_name'];

    public function __construct(Subsystem $subsystem)
    {
        $this->model = $subsystem;
    }
}
