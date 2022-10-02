<?php


namespace Modules\ERP\Contracts;

interface FinanceCurrencyRepository
{
    /**
     * 更据生效时间 获取当时的所有汇率
     *
     * @param $time
     * @return mixed 返回汇率的集合
     */
    public function getExchangeRatesByTime($time);

    /**
     * 获取某一时间的两个币种的汇率
     *
     * @param string $time 汇率时间
     * @param string $originCode 原币种
     * @param string $aimCode 目标币种
     * @return mixed  返回汇率对象    汇率,精确到小数点八位,  $originAmount * rate() = $aimAmount
     */
    public function getExchangeRate($time, $originCode, $aimCode);
}
