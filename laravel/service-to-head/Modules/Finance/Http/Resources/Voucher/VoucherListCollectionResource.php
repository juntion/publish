<?php


namespace Modules\Finance\Http\Resources\Voucher;


use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\PaymentMethodService;
use Modules\Finance\Entities\Traits\CompanyNameTrait;
use Modules\Finance\Entities\Traits\CustomerTrait;

class VoucherListCollectionResource extends ResourceCollection
{
    use CompanyNameTrait, CustomerTrait;

    protected $companyService;
    protected $customerRepository;
    protected $companyRepository;
    protected $instockShippingRepository;
    protected $orderCompanyRepository;
    protected $paymentMethodService;
    protected $paymentPool = [];
    protected $companyCodePool = [];

    public function __construct(
        $resource,
        OrderCustomerCompanyService $companyService,
        CustomerRepository $customerRepository,
        CustomerCompanyRepository $companyRepository,
        InstockShippingRepository $instockShippingRepository,
        CompanyRepository $orderCompanyRepository,
        PaymentMethodService $paymentMethodService
    ) {
        parent::__construct($resource);
        $this->companyService = $companyService;
        $this->customerRepository = $customerRepository;
        $this->companyRepository = $companyRepository;
        $this->instockShippingRepository = $instockShippingRepository;
        $this->orderCompanyRepository = $orderCompanyRepository;
        $this->paymentMethodService = $paymentMethodService;
    }

    public static $wrap = 'vouchers';

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            $orderNumber = $item->order_number;

            if ($item->customer_number) {
                $customer_number = $item->customer_number;
                $company_number = $item->customer_company_number;
                $company_name = $item->customer_company_name;
                $customer_email = "";
                $customer = $this->getCustomerInfoByPool($item->customer_number);
                if($customer) {
                    $customer_email = $customer->customers_email_address;
                }
            } else {
                // 获取客户编号
                $orderInfo = $this->companyService->getCustomerAndCompanyInfoByOrderNumber($orderNumber);

                $customerNumber = $orderInfo->customerNumber;
                if (empty($customerNumber)) {
                    $customer_number = "";
                    $company_number = "";
                    $customer_email = "";
                    $company_name = "";
                } else {
                    $customerData = $this->getCustomerFormPool($customerNumber, $orderInfo);

                    // 获取客户信息
                    $customer_number = $customerData['customer_number'];
                    $company_number = $customerData['company_number'];
                    $customer_email = $customerData['customer_email'];
                    $company_name = $customerData['company_name'];
                }
            }



            $orderCompanyName = "";

            $details = $item->details->first();

            if ($details) {
                $productsInstockId = $details->order_id;
                $productsInstock = $this->instockShippingRepository->getOrderInfoByProductsInstockId($productsInstockId);
            } else {
                $productsInstock = $this->instockShippingRepository->getOrderInfoByOrderNumber($item->order_number);
            }

            if(!is_null($productsInstock)) {
                $orderCompanyName = $this->getCompanyName($productsInstock);
            }

            $receipts = [];
            if ($item->receiptsToVoucher->isNotEmpty()) {
                $receipts = $item->receiptsToVoucher->map(function ($to){
                    return [
                        'uuid'                => $to->receipt_uuid,
                        'number'              => $to->receipt_number,
                        'currency'            => $to->receipt_currency,
                        'receipt_use'         => $to->receipt_use,
                        'payment_method_name' => $to->receipt->payment_method_name,
                        'company_name'        =>  $to->receipt->company_uuid ? $this->getCodeByUuidFromPool($to->receipt->company_uuid) : "",
                    ];
                });
            } else if(!is_null($productsInstock)) {
                $receipts[] = [
                    'uuid' => '',
                    'number'              => "",
                    'currency'            => "",
                    'receipt_use'         => "",
                    'payment_method_name' => $this->geyPaymentNameByPool($productsInstock->order_payment),
                    'company_name'        => "",
                ];
            }
            $appendUri = "&searchType=2&click_status=all";
            $url = "/products_instock_shipping_sales_process.php";
            if($productsInstock && $productsInstock->is_seattle > 0) {
                $url = "/products_instock_shipping_sales_seattle.php";
                $appendUri = "&searchType=2";
            }

            return [
                'uuid'                    => $item->uuid,
                'creator_uuid'            => $item->creator_uuid,
                'creator_name'            => $item->creator_name,
                'created_at'              => $item->created_at,
                'number'                  => $item->number,
                'number_url'              => config('app.service_erp_url') . $url . '?search='.$item->number . $appendUri,
                'order_number'            => $item->order_number,
                'order_number_url'        => config('app.service_erp_url') . $url . '?search='.$item->order_number . $appendUri,
                'order_company'           => $orderCompanyName,
                'currency'                => $item->currency,
                "usable"                  => $item->usable,
                "used"                    => $item->used,
                "remark"                  => $item->remark,
                "type"                    => $item->type,
                'customer'               => [
                    'company_number' => $company_number,
                    'company_name'   => $company_name,
                    'number'         => $customer_number,
                    'email'          => $customer_email
                ],
                'receipts'                => $receipts
            ];
        })->all();
    }


    protected function geyPaymentNameByPool($id)
    {
        if(!array_key_exists($id, $this->paymentPool)){
            $payment = $this->paymentMethodService->getPaymentMethodName($id);
            if (is_null($payment)) {
                $this->paymentPool[$id] = '';
            } else {
                $this->paymentPool[$id] = $payment;
            }
        }
        return $this->paymentPool[$id];
    }

    protected function getCodeByUuidFromPool($uuid)
    {
        if(!array_key_exists($uuid, $this->companyCodePool)){
            $companyRes = $this->orderCompanyRepository->find($uuid);
            if (is_null($companyRes)) {
                $this->companyCodePool[$uuid] = '';
            } else {
                $this->companyCodePool[$uuid] = $companyRes->code;
            }
        }
        return $this->companyCodePool[$uuid];
    }
}
