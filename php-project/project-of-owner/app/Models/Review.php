<?php


namespace App\Models;

use App\Models\BaseModel;

class Review extends BaseModel
{
    protected $table = 'reviews';
    protected $primaryKey = 'reviews_id';
    public $timestamps = false;
    protected $fillable = [
        'products_id',
        'customers_id',
        'reviews_rating',
        'reviews_type',
        'date_added',
        'last_modified',
        'reviews_read',
        'orders_products_id',
        'languages_id',
        'product_quality',
        'price',
        'pre_sale_service',
        'logistics_service',
        'others',
        'check_status',
        'equipment_mode',
    ];

    public function customers()
    {
        return $this->hasOne('App\Models\Customer', 'customers_id', 'customers_id');
    }

    public function productDescription()
    {
        return $this->hasOne('App\Models\ProductDescription', 'products_id', 'products_id');
    }

    public function productThumbImage()
    {
        return $this->hasMany('App\Models\ProductThumbImage', 'products_id', 'products_id');
    }

    public function reviewDescription()
    {
        return $this->hasOne('App\Models\ReviewsDescription', 'reviews_id', 'reviews_id');
    }

    public function reviewsImageThumb()
    {
        return $this->hasMany('App\Models\ReviewsImageThumb', 'reviews_id', 'reviews_id');
    }

    public function reviewsVirtualCustomer()
    {
        return $this->hasOne('App\Models\ReviewsVirtualCustomer', 'id', 'v_customers_id');
    }

    public function reviewLikeOrNot()
    {
        return $this->hasOne('App\Models\ReviewLikeOrNot', 'reviews_id', 'reviews_id');
    }

    public function reviewsComment()
    {
        return $this->hasMany('App\Models\ReviewsComment', 'reviews_id', 'reviews_id');
    }

    public function reviewsImage()
    {
        return $this->hasMany('App\Models\ReviewsImage', 'reviews_id', 'reviews_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'products_id', 'products_id');
    }
}
