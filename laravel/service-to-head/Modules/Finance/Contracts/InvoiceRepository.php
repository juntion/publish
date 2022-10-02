<?php

namespace Modules\Finance\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;

interface InvoiceRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * 查询ERP发票
     *
     * @param string $invoiceNumber
     * @return mixed
     */
    public function getErpProductsInvoice(string $invoiceNumber);

    /**
     * 根据发票查询ERP订单
     * @param int $relateId
     * @param int $relateType
     * @return mixed
     */
    public static function getErpProductsInstockShippingData(int $relateId, int $relateType);

    /**
     * 查询销售
     *
     * @param int $id
     * @return mixed
     */
    public function getErpAssistantData(int $id);

    /**
     * @param array $fields
     * @return mixed
     */
    public function toSave(array $fields);

    /**
     * @param array $fields
     * @param array $updateFields
     * @param bool $isSoftDelete
     * @return mixed
     */
    public function toUpdate(array $fields, array $updateFields, bool $isSoftDelete = false);

    /**
     * @param array $whereFields
     * @param int $cleared
     * @return mixed
     */
    public function invoiceClearedUpdate(array $whereFields, int $cleared);

    /**
     * @param array $fields
     * @return mixed
     */
    public function softDelete(array $fields);

    /**
     * @param string $uuid
     * @return mixed
     */
    public function getDataByUuid(string $uuid);

    /**
     * 根据发票编号返回发票信息
     * @param string $number
     * @return mixed
     */
    public function getDataByNumber(string $number);

    /**
     * 查询拆单
     *
     * @param array $orderIds
     * @return mixed
     */
    public function getPaymentReceiptsVouchersDetails(array $orderIds);

    /**
     * 生成一条核销记录
     * @param array $fields
     * @return mixed
     */
    public function toSaveInvoicesToReceipts(array $fields);

    /**
     * 生成一条清账记录
     * @param array $fields
     * @return mixed
     */
    public function toSaveClearAccounts(array $fields);


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
     * 不同权限下的首页数据sql
     * @param  int  $type
     * @param $limit
     * @param  array  $adminIds
     * @return mixed
     */
    public function getTypeIndex(int $type, $limit ,$adminIds = []);

    /**
     * 查询发票信息
     * @param  string  $uuid
     * @return mixed
     */
    public function findSelf(string $uuid);

    /**
     * 查询发票信息
     * @param  array  $fields
     * @return mixed
     */
    public function getInvoiceByIdType($fields);

    /**
     * 查询发票信息
     * @param  array  $fields
     * @return mixed
     */
    public function getInvoiceAllByIdType($fields);

    /**
     * 查询清账记录信息
     * @param  array  $fields
     * @param  array  $fieldsIn
     * @return mixed
     */
    public function getClearAccounts(array $fields, array $fieldsIn);

    /**
     * 查询核销记录信息
     * @param  array  $fields
     * @return mixed
     */
    public function getInvoicesToReceipts(array $fields);

    /**
     * 修改核销记录
     * @param array $fields
     * @param array $updateFields
     * @return mixed
     */
    public function invoiceToReceiptUpdate(array $fields, array $updateFields);

}
