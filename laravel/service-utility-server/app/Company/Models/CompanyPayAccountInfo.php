<?php


namespace App\Company\Models;


use Illuminate\Database\Eloquent\Model;

class CompanyPayAccountInfo extends Model
{
    protected $table = "company_pay_account_info";

    protected $fillable = ['pay_id', 'account_number', 'currency', 'other_info'];
}
