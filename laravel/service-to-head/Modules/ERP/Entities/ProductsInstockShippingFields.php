<?php

namespace Modules\ERP\Entities;

class ProductsInstockShippingFields extends Model
{
    /**
     * @var string
     */
    protected $table = 'products_instock_shipping_fields';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['id','products_instock_id','company_number'];

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'id'=>$this->id,
            'products_instock_id'=>$this->products_instock_id,
            'company_number'=>$this->company_number
        ];
    }

    public function instockShipping() {
        return $this->belongsTo(ProductsInstockShipping::class, 'products_instock_id', 'products_instock_id');
    }
}
