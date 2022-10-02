<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2021-03-26
 * Time: 18:50
 */

namespace Modules\ERP\Entities;


class PaymentRelateOrders extends Model
{


    /**
     * @var string
     */
    protected $table = 'payment_relate_orders';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['id', 'products_instock_id', 'related_id', 'related_price', 'value1', 'value2','relate_time','relate_id','is_del','fee'];
    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'id'=>$this->id,
            'products_instock_id'=>$this->products_instock_id,
            'related_id'=>$this->related_id,
            'related_price'=>$this->related_price,
            'value1'=>$this->value1,
            'value2'=>$this->value2,
            'relate_time'=>$this->relate_time,
            'relate_id'=>$this->relate_id,
            'is_del'=>$this->is_del,
            'fee'=>$this->fee
        ];
    }
}