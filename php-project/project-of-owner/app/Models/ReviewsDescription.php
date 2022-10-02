<?php


namespace App\Models;

use App\Models\BaseModel;

class ReviewsDescription extends BaseModel
{
    protected $table = 'reviews_description';
    public $timestamps = false;
    protected $primaryKey = "review_id";
    protected $fillable = [
        'reviews_id',
        'languages_id',
        'reviews_text',
        'reviews_headline'
    ];
}
