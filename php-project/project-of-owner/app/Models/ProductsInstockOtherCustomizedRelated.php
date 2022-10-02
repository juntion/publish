<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/16
 * Time: 18:19
 */

namespace App\Models;

class ProductsInstockOtherCustomizedRelated extends BaseModel
{
    protected $table = "products_instock_other_customized_related";
    protected $primaryKey = "customized_related_id";
    public $timestamps = false;
}
