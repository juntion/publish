<?php
/**
 * Notes:
 * File name:AttributeCustomColumn
 * Create by: Jay.Li
 * Created on: 2020/8/27 0027 16:46
 */


namespace App\Models;

class AttributeCustomColumn extends BaseModel
{
    protected $table = 'attribute_custom_column';

    protected $primaryKey = 'column_id';

    public $timestamps = false;

    public function child()
    {
        return $this->hasOne('App\Models\AttributeCustomColumn', 'parent_id', 'column_id');
    }
}
