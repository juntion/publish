<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/16
 * Time: 18:25
 */

namespace App\Models;

class ProductsInstockCustomizedRelated extends BaseModel
{
    protected $table = "products_instock_customized_related";
    protected $primaryKey = "id";
    public $timestamps = false;
}
