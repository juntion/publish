<?php

namespace App\Models;

use App\Traits\ToolsTrait;

class ServiceProcessSolution extends BaseModel
{
    protected $table = "service_process_solution";
    protected $primaryKey = "id";
    protected $guarded = [];
    public $timestamps = false;

    use ToolsTrait;

    public function getContentAttribute($value)
    {
        return self::autoLink(self::autoNextLine($value));
    }

    public function solutionFile()
    {
        return $this->hasMany('App\Models\ServiceProcessSolutionFile', 'solution_id', 'id');
    }
}
