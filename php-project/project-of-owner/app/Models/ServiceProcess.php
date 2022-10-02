<?php

namespace App\Models;

class ServiceProcess extends BaseModel
{
    protected $table = "service_process";
    protected $guarded = [];
    public $timestamps = false;

    public function file()
    {
        return $this->hasMany('App\Models\ServiceProcessFile', 'service_process_number', 'number');
    }

    public function solution()
    {
        return $this->hasOne('App\Models\ServiceProcessRj', 'number', 'number');
    }
}
