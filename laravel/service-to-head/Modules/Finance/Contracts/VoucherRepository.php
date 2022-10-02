<?php

namespace Modules\Finance\Contracts;

use Modules\Finance\Entities\PaymentVoucher;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface VoucherRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 创建
     * @param  array  $data
     * @return mixed
     */
    public function storeVoucher(array $data);


    /**
     * 关联指定的DK
     * @param  PaymentVoucher  $paymentVoucher
     * @param  array  $data
     * @return mixed
     */
    public function relateReceipt(PaymentVoucher $paymentVoucher, array $data);


    /**
     * 获取指定类型的首页数据
     * @param  int  $type
     * @param $limit
     * @param  array  $adminIds
     * @return mixed
     */
    public function getTypeIndex(int $type, $limit ,$adminIds = [], $sort = "DESC");

    /**
     * 通过订单号获取凭证
     * @param  string  $orderNumber
     * @return mixed
     */
    public function getInfoByOrderNumber(string $orderNumber);

    /**
     * 通过凭证号获取凭证
     * @param  string  $number
     * @return mixed
     */
    public function getInfoByVoucherNumber(string $number);

    /**
     * 生成对应的 凭证使用详情 并更新 voucher used 字段
     * @param  PaymentVoucher  $voucher
     * @param  array  $data
     * @return mixed
     */
    public function storeVoucherDetail(PaymentVoucher $voucher, array $data);

    /**
     * 返还指定凭证的指定金额
     * @param  string  $uuid
     * @param  int  $use
     * @return mixed
     */
    public function revokeUse(string $uuid, int $use);


    /**
     * 通过单号更新Used
     * @param  string  $number
     * @param  int  $used
     * @return mixed
     */
    public function updateUsedByNumber(string $number, int $used);

    /**
     * 通过model创建对应的voucher
     * @param  PaymentVoucher  $paymentVoucher
     * @return mixed
     */
    public function createByModel(PaymentVoucher $paymentVoucher);
}
