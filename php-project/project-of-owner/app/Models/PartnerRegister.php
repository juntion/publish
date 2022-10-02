<?php


namespace App\Models;

use App\Models\BaseModel;

class PartnerRegister extends BaseModel
{
    protected $table = "partner_register";
    protected $primaryKey = "parent_id";
    public $timestamps = false;
}
