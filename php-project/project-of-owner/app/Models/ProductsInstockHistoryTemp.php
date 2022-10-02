<?php

namespace App\Models;


class ProductsInstockHistoryTemp extends BaseModel
{
    /**
     * 后台库存锁定表
     *
     * @var string
     */
    protected $table = 'products_instock_history_temp';

    /**
     * @Notes:
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author: aron
     * @Date: 2020-11-24
     * @Time: 17:43
     */
    public function productsInstock()
    {
        return $this->belongsTo(
            ProductsInstock::class,
            'instock_id',
            'products_instock_id'
        );
    }
}
