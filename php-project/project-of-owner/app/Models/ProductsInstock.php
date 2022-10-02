<?php


namespace App\Models;

class ProductsInstock extends BaseModel
{
    protected $table = 'products_instock';
    public $timestamps = false;
    /**
     * @Notes:前台库存锁定表关联
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author: aron
     * @Date: 2020-11-24
     * @Time: 17:39
     */
    public function frontLock()
    {
        return $this->hasMany(
            ProductsInstockOrder::class,
            'instock_id',
            'products_instock_id'
        );
    }

    /**
     * @Notes:后台录单锁定
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author: aron
     * @Date: 2020-11-24
     * @Time: 17:39
     */
    public function backLock()
    {
        return $this->hasMany(
            ProductsInstockHistoryTemp::class,
            'products_instock_id',
            'products_instock_id'
        );
    }
}
