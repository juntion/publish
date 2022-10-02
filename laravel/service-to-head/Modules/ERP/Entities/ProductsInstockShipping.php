<?php

namespace Modules\ERP\Entities;

class ProductsInstockShipping extends Model
{


    /**
     * @var string
     */
    protected $table = 'products_instock_shipping';

    /**
     * @var string
     */
    protected $primaryKey = 'products_instock_id';

    /**
     * @var array
     */
    protected $fillable = ['order_payment', 'symbol_left', 'amount_recived', 'amount_date', 'orders_num', 'finance_admin','finance_info','finance_time','sales_admin',
        'check_status','is_inspection','renling','is_clientArea','order_invoice','sales_update_time','assistant_id','order_invoice','order_number','orders_id','amount_use','delete_orders_payment'];
    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'products_instock_id'=>$this->products_instock_id,
            'orders_id'=>$this->orders_id,
            'shipping_price'=>$this->shipping_price,
            'order_number'=>$this->order_number,
            'order_invoice'=>$this->order_invoice,
            'trade_term'=>$this->trade_term,
            'symbol_left'=>$this->symbol_left,
            'order_products_price'=>$this->order_products_price,
            'order_price'=>$this->order_price,
            'sales_admin'=>$this->sales_admin,
            'sales_assistant'=>$this->sales_assistant,
            'assistant_id'=>$this->assistant_id,
            'ns_internal_id'=>$this->ns_internal_id,
            'No'=>$this->No,
            'is_seattle'=>$this->is_seattle,
            'is_return'=>$this->is_return,
            'orders_num'=>$this->orders_num,
            'finance_admin'=>$this->finance_admin,
            'is_not_transport'=>$this->is_not_transport,
            'is_split'=>$this->is_split,
            'cancel_order_status'=>$this->cancel_order_status,
            'order_payment'=>$this->order_payment,
            'amount_recived'=>$this->amount_recived,
            'amount_use'=>$this->amount_use,
            'vat_tax'=>$this->vat_tax,
            'paypal_fee'=>$this->paypal_fee,
            'purchase_time'=>$this->purchase_time,
            'product_height'=>$this->product_height,
            'delete_orders_payment'=>$this->delete_orders_payment,
            'sales_add_time'=>$this->sales_add_time,
            'sales_update_time'=>$this->sales_update_time,
            'finance_time'=>$this->finance_time,
            'is_packing'=>$this->is_packing,
            'shipping_method'=>$this->shipping_method,
            'shipping_number'=>$this->shipping_number,
            'click_status'=>$this->click_status,
        ];
    }

    public function instockShippingField()
    {
        return $this->hasOne(ProductsInstockShippingFields::class, 'products_instock_id', 'products_instock_id');
    }
}
