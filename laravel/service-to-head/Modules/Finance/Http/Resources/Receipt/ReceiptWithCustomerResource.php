<?php


namespace Modules\Finance\Http\Resources\Receipt;


use Modules\Base\Http\Resources\Json\Resource;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;

class ReceiptWithCustomerResource extends Resource
{

    protected $customerRepository;
    protected $companyRepository;

    public function __construct($resource, CustomerRepository $customerRepository, CustomerCompanyRepository $companyRepository)
    {
        parent::__construct($resource);
        $this->customerRepository = $customerRepository;
        $this->companyRepository = $companyRepository;
    }

    public function toArray($request)
    {
        $customer_data = [
            "company_number"  => "",
            "company_name"    => "",
            "customer_number" => "",
            "customer_name"   => "",
            "manage_type"     => "",
            "manage_name"     => ""
        ];

        if ($this->customer_number) {
            $customer = $this->customerRepository->getCustomerByNumber($this->customer_number);
            if ($customer) {
                // 获取公司信息
                $company =  $this->companyRepository->getCompanyByCustomerNumber($this->customer_number);

                $customer_data['customer_number'] = $customer->customers_number_new;
                $customer_data['customer_name'] = ($customer->customers_firstname) ? ($customer->customers_firstname . ' ' . $customer->customers_lastname) : $customer->customers_lastname;
                $customer_data['manage_name'] = ($customer->manage_type == '1') ? __('erp::customer.companyManage') : __('erp::customer.personalManage');
                $customer_data['manage_type'] = $customer->manage_type;
                if ($company) {
                    $customer_data["company_number"] = $company->company_number;
                    $customer_data["company_name"] = $company->customerOfCompany->customers_company;
                }
            }
        }
        return [
            "uuid"                      => $this->uuid,
            "number"                    => $this->number,
            "transaction_serial_number" => $this->transaction_serial_number,
            "is_match"                  => $this->is_match == 1,
            "currency"                  => $this->currency,
            "amount"                    => $this->amount,
            "fee"                       => $this->fee,
            "fee_fs"                    => $this->fee_fs,
            "float"                     => $this->float,
            "usable"                    => $this->usable,
            "used"                      => $this->used,
            "cleared"                   => $this->cleared,
            "company_uuid"              => $this->company_uuid,
            "company_name"              => $this->company_name,
            "customer_company_number"   => $this->customer_company_number,
            "customer_company_name"     => $this->customer_company_name,
            "customer_number"           => $this->customer_number,
            "payer_name"                => $this->payer_name,
            "payer_email"               => $this->payer_email,
            "payment_method_id"         => $this->payment_method_id,
            "payment_method_name"       => $this->payment_method_name,
            "payment_remark"            => $this->payment_remark,
            "payment_time"              => $this->getZoneDatetime($this->payment_time),
            "claim_uuid"                => $this->claim_uuid,
            "claim_name"                => $this->claim_name,
            "claim_status"              => $this->claim_status,
            "claim_type"                => $this->claim_type,
            "claim_time"                => $this->claim_time,
            "create_from"               => $this->create_from,
            "creator_uuid"              => $this->creator_uuid,
            "creator_name"              => $this->creator_name,
            "deleted_at"                => $this->deleted_at,
            "created_at"                => $this->created_at,
            "updated_at"                => $this->updated_at,
            "customer"                  => $customer_data
        ];
    }
}
