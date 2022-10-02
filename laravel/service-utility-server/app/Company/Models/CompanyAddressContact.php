<?php


namespace App\Company\Models;


use Illuminate\Database\Eloquent\Model;

class CompanyAddressContact extends Model
{
    protected $table = "company_address_contacts";

    protected $fillable = ['address_id', 'type', 'contacts', 'tel'];

}
