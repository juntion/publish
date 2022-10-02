<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/30
 * Time: 19:39
 */

namespace App\Models;

class ProductRelatedAttributesRelation extends BaseModel
{
    protected $table = "product_related_attributes_relation";
    protected $primaryKey = "id";

    public function tableColumnLanguages()
    {
        return $this->hasOne('App\Models\TableColumnLanguages', 'unique_id', 'attribute_val_language_id');
    }

    public function ProductRelatedAttributes()
    {
        return $this->belongsTo('App\Models\ProductRelatedRelation', 'related_attribute_id', 'id');
    }
}
