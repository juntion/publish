<?php


namespace Modules\ERP\Contracts;


interface FinanceExchangeRateService
{
    /**
     * @param string $time 汇率时间
     * @param string $originCode 原币种
     * @param string $aimCode 目标币种
     * @return float                     汇率,精确到小数点八位,  $originAmount * rate() = $aimAmount
     */
    public function rate($time, $originCode, $aimCode): float;

    /**
     * @param string $time 汇率时间
     * @param string $originCode 原币种
     * @param int $originAmount 原币种值，单位：分
     * @param string $aimCode 目标币种
     * @return int                       目标币种值，单位：分
     */
    public function exchange($time, $originCode, int $originAmount, $aimCode): int;
}
