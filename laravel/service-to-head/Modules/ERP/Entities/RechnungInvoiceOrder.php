<?php
namespace Modules\ERP\Entities;


class RechnungInvoiceOrder extends Model
{
    /**
     * @var string
     */
    protected $table = 'products_instock_shipping_payment_invoice_orders';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'is_delete'=>$this->is_delete,
            'products_instock_id'=>$this->products_instock_id,
            'orders_num'=>$this->orders_num,
            'orders_number'=>$this->orders_number,
            'customers_NO'=>$this->customers_NO,
            'apply_money'=>$this->apply_money,
            'use_money'=>$this->use_money,
            'currencies_id'=>$this->currencies_id,
            'is_payment'=>$this->is_payment,
            'parent_id'=>$this->parent_id,
        ];
    }
}