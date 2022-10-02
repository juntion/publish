<?php
namespace Modules\ERP\Contracts;

interface RechnungInvoiceRepository
{
    /**
     * 根据id获取账期客户数据
     * @param $id
     * @return mixed
     */
    public function getRechnungInfoById($id);

    /**
     * 获取账期订单信息
     * @param $id
     * @return mixed
     */
    public function getRechnungOrderInfoById($id);

    /**
     * 修改账期数据
     * @param array $fields
     * @param array $updateFields
     * @return mixed
     */
    public function rechnungUpdate(array $fields, array $updateFields);

    /**
     * 修改账期订单数据
     * @param array $fields
     * @param array $updateFields
     * @return mixed
     */
    public function rechnungOrderUpdate(array $fields, array $updateFields);
}