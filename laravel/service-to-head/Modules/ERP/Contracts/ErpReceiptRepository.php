<?php


namespace Modules\ERP\Contracts;


interface ErpReceiptRepository
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

}
