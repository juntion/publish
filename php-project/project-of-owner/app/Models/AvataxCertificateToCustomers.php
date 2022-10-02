<?php

namespace App\Models;

class AvataxCertificateToCustomers extends BaseModel
{
    protected $table = 'avatax_certificate_to_customers';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public $timestamps = false;
}
