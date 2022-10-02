<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/16
 * Time: 18:21
 */

namespace App\Models;

class ProductsInstockAddRelated extends BaseModel
{
    protected $table = "products_instock_add_related";
    protected $primaryKey = "related_id";
    public $timestamps = false;

    /**
     * @Notes:
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author: aron
     * @Date: 2020-11-24
     * @Time: 17:43
     */
    public function relatedMainId()
    {
        return $this->belongsTo(ProductsInstockAddModel::class, 'model_id', 'model_id');
    }
}
