<?php
namespace App\Models;

use App\Models\BaseModel;

class SampleApply extends BaseModel
{
    protected $table = 'sample_apply';
    protected $primaryKey = 'sample_apply_id';
    public $timestamps = false;
}
