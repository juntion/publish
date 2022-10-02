<?php


namespace App\Models;


class SecurityCodeSearchLog extends BaseModel
{
    protected $table = 'security_code_search_log';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;
}