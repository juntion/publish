<?php
/**
 * Notes:
 * File name:reviews_comments
 * Create by: Jay.Li
 * Created on: 2020/5/12 0012 10:34
 */


namespace App\Models;

class ReviewsComment extends BaseModel
{
    protected $table = 'reviews_comments';

    protected $primaryKey = 'comments_id';

    public $timestamps = false;

    public function reviewsCommentsDescription()
    {
        return $this->hasOne('App\Models\ReviewsCommentsDescription', 'comments_id', 'comments_id');
    }
}
