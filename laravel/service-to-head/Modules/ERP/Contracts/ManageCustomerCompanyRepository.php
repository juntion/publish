<?php

namespace Modules\ERP\Contracts;

interface ManageCustomerCompanyRepository
{

    /**
     * @param string $companyNumber
     * @return mixed
     */
    public function getCustomerCompanyByCompanyNumber(string $companyNumber);
}
