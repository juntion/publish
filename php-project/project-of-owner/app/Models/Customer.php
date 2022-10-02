<?php


namespace App\Models;

use App\Models\BaseModel;

/**
 * customer model
 *
 * @author aron
 * @date 2019.11.8
 * Class Customer
 * @package App\Models
 */
class Customer extends BaseModel
{
    protected $table = 'customers';
    protected $primaryKey = "customers_id";
    protected $fillable = ['customers_firstname','customers_lastname','customer_photo','customers_newsletter'];
    public $timestamps = false;

    public function admin()
    {
        return $this->belongsTo('AdminToCustomer', 'customers_id', "customers_id");
    }

    public function country()
    {
        return  $this->hasOne('\App\Models\Country', "countries_id", 'customer_country_id');
    }

    public function position()
    {
        return  $this->hasOne(
            '\App\Models\ManageCustomerPosition',
            "position_id",
            'office'
        );
    }

    public function adminToCustomer()
    {
        return $this->belongsToMany('App\Models\Admin', 'admin_to_customers', 'customers_id', 'admin_id');
    }
}
