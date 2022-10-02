<?php

namespace Modules\ERP\Entities;


class ManageCustomerInquiryPIInfo extends Model
{
    protected $table = "manage_customer_inquiry_PI_info";

    protected $primaryKey = "id";

    public function export(): array
    {
        return [];
    }

    public function piProducts()
    {
        return $this->hasMany(ManageCustomerInquiryPIProducts::class, 'pi_info_id', 'id');
    }
}