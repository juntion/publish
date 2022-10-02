<?php

namespace Modules\ERP\Entities;


class ManageCustomerInquiryPIProducts extends Model
{
    protected $table = "manage_customer_inquiry_pi_products";

    protected $primaryKey = "id";

    public function export(): array
    {
        return [];
    }
}