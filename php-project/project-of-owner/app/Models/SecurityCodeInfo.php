<?php


namespace App\Models;


class SecurityCodeInfo extends BaseModel
{
    protected $table = 'security_code_info';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}