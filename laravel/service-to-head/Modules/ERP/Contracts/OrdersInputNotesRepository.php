<?php


namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\OrdersInputNotes;


interface OrdersInputNotesRepository
{
    /**
     * 记录线上订单推送日志
     * @param OrdersInputNotes $ordersInputNotes
     * @return mixed
     */
    public function store(OrdersInputNotes $ordersInputNotes);

}
