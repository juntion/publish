<?php


namespace Modules\Finance\Http\Resources\Voucher;


use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\Base\Http\Resources\Json\Resource;

class VoucherListReceiptResource extends Resource
{

    protected $companyPool = [];

    protected $orderCompanyRepository;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->orderCompanyRepository = app()->make(CompanyRepository::class);
    }

    public function toArray($request)
    {
        return [
            'uuid'                => $this->receipt_uuid,
            'number'              => $this->receipt_number,
            'currency'            => $this->receipt_currency,
            'receipt_use'         => $this->receipt_use,
            'payment_method_name' => $this->receipt->payment_method_name,
            'company_name'        =>  $this->receipt->company_uuid ? $this->getNameByIdFromPool($this->receipt->company_uuid) : "",
        ];
    }

    protected function getNameByIdFromPool($uuid)
    {
        if(!array_key_exists($uuid, $this->companyPool)){
            $companyRes = $this->orderCompanyRepository->find($uuid);
            if (is_null($companyRes)) {
                $this->companyPool[$uuid] = '';
            } else {
                $this->companyPool[$uuid] = $companyRes->code;
            }
        }
        return $this->companyPool[$uuid];
    }
}
