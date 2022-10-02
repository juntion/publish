<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/16
 * Time: 18:24
 */

namespace App\Models;

class ReviewsToPidRelatedPid extends BaseModel
{
    protected $table = "reviews_to_pid_related_pid";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
