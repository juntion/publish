<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/30
 * Time: 19:41
 */

namespace App\Models;

class ProductRelatedRelation extends BaseModel
{
    protected $table = "product_related_attributes";
    protected $primaryKey = "id";

    public function productRelatedAttributesRelation()
    {
        return $this->hasOne('App\Models\ProductRelatedAttributesRelation', 'related_attribute_id', 'id');
    }

    public function tableColumnLanguages()
    {
        return $this->hasOne('App\Models\TableColumnLanguages', 'unique_id', 'name_language_id');
    }
}
