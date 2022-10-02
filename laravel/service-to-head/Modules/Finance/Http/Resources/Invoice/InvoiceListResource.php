<?php


namespace Modules\Finance\Http\Resources\Invoice;


use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Finance\Contracts\InvoiceService;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\ERP\Repositories\CustomerRepository;

class InvoiceListResource extends ResourceCollection
{
    public static $wrap = 'invoices';

    protected $service;
    protected $invoiceRepository;

    public function __construct($resource, InvoiceService $service, InvoiceRepository $invoiceRepository)
    {
        parent::__construct($resource);
        $this->service = $service;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return self::toInvoiceDetail($item, 0);
        })->all();
    }


    public function toInvoiceDetail($item, $type)
    {
        $productsInstockRes = $this->invoiceRepository->getErpProductsInstockShippingData($item->relate_id, $item->relate_type);
        $ordersInfo = $this->service->getInvoiceRelates($productsInstockRes);
        $instockIds = $ordersInfo['instock_ids'];//发票管理的订单id数组
        $data = [
            'uuid'           => $item->uuid,
            'number'         => $item->number,
            'type'           => $item->type,
            'assistant_uuid' => $item->assistant_uuid,
            'assistant_name' => $item->assistant_name,
            'currency'       => $item->currency,
            'amount'         => $item->amount,
            'cleared'        => $item->cleared,
            'cleared_status' => $item->cleared_status,
            'to_void'        => $item->to_void,
            'relate_id'      => $item->relate_id,
            'created_at'      => $item->created_at,
            'risk'           => $this->service::RISK_EN[$this->service->getInvoiceRisk($item->created_at, date('Y:m:d H:i:s'), $item->account_days)],
            'relates'        => $ordersInfo['relates_info'],
            'customer'       => [
                'company_number' => $item->customer_company_number,
                'company_name' => $item->customer_company_name,
                'number' => $item->customer_number,
                'email' => CustomerRepository::getCustomerByNumber($item->customer_number)->customers_email_address??'',
            ],
        ];
        if ($type) {
            $data['offset_infos'] = $this->service->getInvoiceOffsetInfos($instockIds, $item->uuid, $this->invoiceRepository);
        }
        return $data;
    }
}
