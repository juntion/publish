<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/22
 * Time: 11:31
 */

namespace App\Models;

class ProductsInstockAddModel extends BaseModel
{
    protected $table = "products_instock_add_model";
    protected $primaryKey = "model_id";
    public $timestamps = false;

    /**
     * @Notes:
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author: aron
     * @Date: 2020-11-24
     * @Time: 17:42
     */
    public function relatedProducts()
    {
        return $this->hasMany(ProductsInstockAddRelated:: class, 'model_id', 'model_id');
    }
}
