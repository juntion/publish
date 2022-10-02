<?php


namespace Modules\ERP\Entities;


class OrdersOfDKDataDetails extends Model
{
    protected $table = 'orders_of_dk_data_details';

    protected $primaryKey = 'id';

    public function export(): array
    {
        return [
            'id'=>$this->id,
            'dk_number'=>$this->dk_number,
            'create_time'=>$this->create_time,
            'orders_num'=>$this->orders_num,
            'order_number'=>$this->order_number,
            'dk_symbol'=>$this->dk_symbol,
            'actual_symbol'=>$this->actual_symbol,
            'dk_out_of_ns'=>$this->dk_out_of_ns,
            'dk_out_of_order'=>$this->dk_out_of_order,
            'order_out_of_dk'=>$this->order_out_of_dk,
            'cw_finally_total'=>$this->cw_finally_total,
            'all_total_finally'=>$this->all_total_finally,
            'data_type'=>$this->data_type,
            'vouch_id'=>$this->vouch_id,
            'admin_id'=>$this->admin_id,
            'is_delete'=>$this->is_delete,
            'parent_id'=>$this->parent_id,
            'origin_id'=>$this->origin_id,
            'products_instock_id'=>$this->products_instock_id
        ];
    }
}
