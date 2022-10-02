<?php

namespace App\Traits;

trait TestingTrait
{
    public $successStructure = ['status' => 'success'];
    public $errorStructure = ['status' => 'error'];
    public $headers = [
        'Accept' => 'application/json',
    ];

    // 成功结构
    public function successStructure(array $merge = [])
    {
        return sizeof($merge) ? array_merge($this->successStructure, $merge) : $this->successStructure;
    }

    // 失败结构
    public function errorStructure(array $merge = [])
    {
        return sizeof($merge) ? array_merge($this->errorStructure, $merge) : $this->errorStructure;
    }
}
