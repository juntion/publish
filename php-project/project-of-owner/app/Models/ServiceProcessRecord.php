<?php

namespace App\Models;

class ServiceProcessRecord extends BaseModel
{
    protected $table = "service_process_record";
    protected $primaryKey = "id";
    protected $guarded = [];
    public $timestamps = false;
}
