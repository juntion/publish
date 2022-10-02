<?php

namespace App\Models;

class AddressBook extends BaseModel
{
    protected $table= "address_book";

    protected $primaryKey = "address_book_id";

    protected $fillable = ['address_book_id', 'address_type', 'company_type', 'entry_company', 'entry_firstname',
        'entry_lastname', 'entry_street_address', 'entry_suburb', 'entry_postcode', 'entry_city', 'entry_telephone'
        , 'entry_state', 'entry_tax_number', 'entry_country_id', 'customers_id','is_avaTax_check', 'ticket_number'];

    const UPDATED_AT = null;
    const CREATED_AT = null;


    public static function getOne()
    {
        return self::find(1);
    }
}
