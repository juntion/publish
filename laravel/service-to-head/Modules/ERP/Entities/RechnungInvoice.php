<?php
namespace Modules\ERP\Entities;


class RechnungInvoice extends Model
{

    /**
     * @var string
     */
    protected $table = 'products_instock_shipping_payment_invoice';

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
            'is_delete'=>$this->is_delete,
            'type'=>$this->type,
            'status'=>$this->status,
            'customers_NO'=>$this->customers_NO,
            'apply_money'=>$this->apply_money,
            'apply_moneys'=>$this->apply_moneys,
            'currencies_id'=>$this->currencies_id,
            'company_number'=>$this->company_number,
            'parent_id'=>$this->parent_id,
        ];
    }
}