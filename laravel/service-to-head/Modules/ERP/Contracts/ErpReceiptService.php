<?php


namespace Modules\ERP\Contracts;


interface ErpReceiptService
{
    /**
     * 退款记录
     * @param  string  $number
     * @return mixed
     */
    public function getRefunds(string $number);

    /**
     * 手续费用申请记录
     * @param  string  $number
     * @return mixed
     */
    public function getFees(string $number);

    /**
     * 的汇率浮动，币种转换单
     * @param  string  $number
     * @return mixed
     */
    public function getFloats(string $number);

    /**
     * 到款的垫付申请
     * @param  string  $number
     * @return mixed
     */
    public function getPrepays(string $number);
}
