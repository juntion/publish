<?php
/**
 * Notes:
 * File name:ReviewsImageThumb
 * Create by: Jay.Li
 * Created on: 2020/5/11 0011 9:55
 */


namespace App\Models;

class ReviewsImageThumb extends BaseModel
{
    protected $table = 'reviews_image_thumb';

    protected $primaryKey = 'id';

    /**
     * create save 方法时，注意这两个字段的时间格式
     */
    const CREATED_AT = 'create_at';

    const UPDATED_AT = 'update_at';
}
