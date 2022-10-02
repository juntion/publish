<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/22
 * Time: 17:46
 */

namespace App\Models;

class ReviewsVirtualCustomer extends BaseModel
{
    protected $table = 'reviews_virtual_customer';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
