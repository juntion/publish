<?php


namespace App\Company\Models;


use Illuminate\Database\Eloquent\Model;

class CompanyTaxInfo extends Model
{
    protected $table = "company_tax_info";

    protected $fillable = ['company_id', 'country', 'tax_number'];
}
