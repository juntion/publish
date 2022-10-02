<?php


namespace App\Models;

use App\Models\BaseModel;

class ReviewLikeOrNot extends BaseModel
{
    protected $table = 'reviews_like_or_not';
    public $timestamps = false;
    protected $primaryKey = 'reviews_id';
    protected $fillable = [
        'reviews_id',
        'r_like'
    ];
}
