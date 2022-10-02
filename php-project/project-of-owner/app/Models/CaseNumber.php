<?php

namespace App\Models;

class CaseNumber extends BaseModel
{
    protected $table = "case_number";
    protected $guarded = [];
    public $timestamps = false;

    const CREATED_AT = null;
    const UPDATED_AT = null;
}
