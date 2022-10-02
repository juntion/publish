<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ManageCustomerCompanyRepository as ManageCustomerCompanyMain;
use Modules\ERP\Entities\ManageCustomerCompany;

class ManageCustomerCompanyRepository implements ManageCustomerCompanyMain
{

    /**
     * @param string $companyNumber
     * @return mixed
     */
    public function getCustomerCompanyByCompanyNumber(string $companyNumber)
    {
        return ManageCustomerCompany::where('company_number', $companyNumber)->first();
    }
}
