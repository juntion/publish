<?php

namespace Modules\Finance\Contracts;

use Modules\Finance\Entities\PaymentReceipt;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ReceiptRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /** 创建到款
     * @param PaymentReceipt $paymentReceipt
     * @return PaymentReceipt
     */
    public function createByModel(PaymentReceipt $paymentReceipt);

    /**
     * 创建到款
     * @param  array  $paymentReceipt
     * @return mixed
     */
    public function store(array $paymentReceipt);

    /**
     * 回滚状态到未申请
     * @param  PaymentReceipt  $paymentReceipt
     * @return mixed
     */
    public function resetStatus2Unclaimed(PaymentReceipt $paymentReceipt);

    /**
     * 回归状态到已申请
     * @param  PaymentReceipt  $paymentReceipt
     * @return mixed
     */
    public function resetStatus2Claimed(PaymentReceipt $paymentReceipt);

    /**
     * 查询自己的or未申请的
     * @param  string  $uuid
     * @param  string  $adminUuid
     * @return mixed
     */
    public function findSelf(string $uuid, string $adminUuid);

    /**
     * 查询组内人员的 or 未申请的
     * @param  string  $uuid
     * @param  array  $adminIds
     * @return mixed
     */
    public function findGroup(string $uuid, array $adminIds);

    /**
     * 获取指定到款的用款信息
     * @param  string  $uuid
     * @return mixed
     */
    public function getReceiptVouchers(string $uuid);

    /**
     * 获取指定到款的信息
     * @param  string  $uuid
     * @param  string  $voucherUuid
     * @return mixed
     */
    public function getVouchersDetails(string $uuid, string $voucherUuid);

    /**
     * 通过number 查询
     * @param  string  $number
     * @param  int  $type
     * @return mixed
     */
    public function findByNumber(string $number, int $type, $adminIds = []);

    /**
     * 不同权限下的首页数据sql
     * @param  int  $type
     * @param $limit
     * @param  array  $adminIds
     * @return mixed
     */
    public function getTypeIndex(int $type, $limit ,$adminIds = [], $sort = "DESC");

    /**
     * 通过ES查询首页数据
     * @param  int  $type
     * @param $limit
     * @param $key
     * @param  array  $admins
     * @return mixed
     */
    public function getTypeIndexByES(int $type, $limit, $key, $admins = [], $sort = "DESC");

    /**
     * 使用金额
     * @param  PaymentReceipt  $paymentReceipt
     * @param  int  $amount
     * @return mixed
     */
    public function useAmount(PaymentReceipt $paymentReceipt, int $amount);

    /**
     * @param  PaymentReceipt  $paymentReceipt
     * @param  int  $float
     * @return mixed
     */
    public function updateFloat(PaymentReceipt $paymentReceipt, int $float);

    /**
     * 退还使用金额
     * @param  string  $uuid
     * @param  int  $used
     * @return mixed
     */
    public function revokeUsed(string $uuid, int $used);

    /**
     * 获取指定单号的到款
     * @param  string  $number
     * @return mixed
     */
    public function getReceiptByNumber(string $number);

    /**
     * 通过订单号及单号查询到款
     * @param  string  $orderNumber
     * @param  string  $number
     * @param  int  $type
     * @return mixed
     */
    public function findByOrderNumberAndNumber(string $orderNumber, string $number, int $type, $admins);

    /**
     * 更新fee
     * @param  PaymentReceipt  $receipt
     * @param  int  $fee
     * @return mixed
     */
    public function updateFee(PaymentReceipt $receipt, int $fee);

    /**
     * @param  string  $uuid
     * @param  int  $used
     * @param  int  $cleared
     * @return mixed
     */
    public function updateUsedAndClearByUuid(string $uuid, int $used);

    /**
     * 更新指定的清账金额
     * @param  string  $uuid
     * @param  int  $cleared
     * @return mixed
     */
    public function updateCleared(string $uuid, int $cleared);


    public function getReceiptByNumberAndType(string $number, $type, $admins);

    public function getReceiptByNumbersAndType(array $number, $type, $admins);

    public function getReceiptByTransaction(string $transaction_serial_number);

    /**
     * 通过G编号查询对应的可用DK
     * @param  string  $companyNumber
     * @return mixed
     */
    public function getUnusedReceiptByGNumber(string $companyNumber);
}
