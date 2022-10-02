<?php


namespace App\Models;

use App\Models\BaseModel;

class ReviewsImage extends BaseModel
{
    protected $table = 'reviews_image';
    public $timestamps = false;
    protected $primaryKey = "review_image_id";
    protected $fillable = [
        'reviews_id',
        'reviews_image',
        'products_id'
    ];

    public function reviewsImageAnchor()
    {
        return $this->hasMany('App\Models\ReviewsImageAnchor', 'reviews_image_id', 'reviews_image_id');
    }

    public function reviewsImageThumb()
    {
        return $this->hasMany('App\Models\ReviewsImageThumb', 'reviews_image_id', 'reviews_image_id');
    }
}
