<?php


namespace Modules\Base\Contracts\Number;

/**
 * 编号器
 * @package Modules\Base\Contracts\Number
 */
interface Number
{
    /**
     * 获取一个新编号，推荐编号为16位定长，两位前缀 + 年月日 + 流水号 + 两位随机数 例如：CW 20200101 0001 58
     * @return mixed
     */
    public function get();
}
