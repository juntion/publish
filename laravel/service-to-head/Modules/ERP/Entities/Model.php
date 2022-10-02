<?php

namespace Modules\ERP\Entities;

use Illuminate\Database\Eloquent\Model as LaravelModel;

abstract class Model extends LaravelModel
{
    protected $connection = 'erp';
    public $timestamps = false;

    /**
     * 导出数据的数组格式
     * @return array
     */
    abstract public function export(): array;
}
