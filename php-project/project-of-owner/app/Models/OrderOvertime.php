<?php
namespace App\Models;

class OrderOvertime extends BaseModel
{
    protected $table = 'orders_overtime';
    protected $primaryKey = 'id';

    public $timestamps = false;

//    protected $connection = "write";
}
