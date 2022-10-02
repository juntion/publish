<?php


namespace Modules\Base\Contracts\Number;

/**
 * 编号器工厂
 * @package Modules\Base\Contracts\Number
 */
interface Factory
{
    /** 创建不同类型的编号器
     * @param null $type
     * @return Number
     */
    public function create($type = null): Number;
}
