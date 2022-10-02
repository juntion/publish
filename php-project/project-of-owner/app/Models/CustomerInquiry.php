<?php

namespace App\Models;

class CustomerInquiry extends BaseModel
{
    protected $table = 'customer_inquiry';
    protected $primaryKey = 'id';

    public $fillable = [
        'customers_id', 'inquiry_number', 'status', 'firstname', 'lastname', 'email', 'created_person',
        'updated_person', 'created_at', 'updated_at', 'country_id', 'language_id', 'language_code', 'admin_id',
        'from_place', 'service_admin', 'area', 'comment', 'point_ids', 'is_old', 'service_process_number'
    ];

    public $timestamps = false;

    public function customerInquiryProducts()
    {
        return $this->hasMany('App\Models\CustomerInquiryProducts', 'inquiry_id', 'id');
    }

    public function customerInquiryInfo()
    {
        return $this->hasMany('App\Models\CustomerInquiryInfo', 'inquiry_id', 'id');
    }

    public function customers()
    {
        return $this->hasOne('App\Models\Customer', 'customers_id', 'customers_id');
    }
}
