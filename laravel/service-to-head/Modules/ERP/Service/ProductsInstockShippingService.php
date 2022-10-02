<?php

namespace Modules\ERP\Service;

use Illuminate\Support\Carbon;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Repositories\ProductsInstockShippingFieldsRepository;
use Modules\ERP\Contracts\CurrencyRepository;
use Modules\ERP\Contracts\ProductsInstockShippingService as ContractsInstockShippingService;
use Modules\Finance\Entities\PaymentVoucher;
use Modules\ERP\Entities\ProductsInstockShipping;
use Modules\ERP\Entities\ProductsInstockShippingFields;
use Modules\Admin\Contracts\AdminRepository;


class ProductsInstockShippingService implements ContractsInstockShippingService
{
    private $instockShippingRepository;
    private $productsInstockShippingFieldsRepository;

    public function __construct
    (InstockShippingRepository $instockShippingRepository,
     ProductsInstockShippingFieldsRepository $productsInstockShippingFieldsRepository)
    {
        $this->instockShippingRepository = $instockShippingRepository;
        $this->productsInstockShippingFieldsRepository = $productsInstockShippingFieldsRepository;
    }

    public function createByVoucher(PaymentVoucher $paymentVoucher, array $data)
    {
        $admin_info = app()->make(AdminRepository::class)->getAdminByUuid($paymentVoucher->creator_uuid)->first();
        $instock = new ProductsInstockShipping();
        $instock->order_payment = $paymentVoucher->order_payment ?? 101;//支付方式
        $instock->symbol_left = app()->make(CurrencyRepository::class)->getCurrenciesIdByCode($paymentVoucher->currency)['currencies_id']; //币种ID;
        $instock->amount_recived = $paymentVoucher->usable / 100;
        $instock->amount_date = Carbon::now();
        $instock->orders_num = $paymentVoucher->number;//CW单号
        $instock->finance_admin = 1;
        $instock->order_invoice = $paymentVoucher->order_number;
        $instock->assistant_id = $admin_info->id ?? 1;
        $instock->finance_info = $paymentVoucher->remark;
        $instock->finance_time = Carbon::now();
        $instock->sales_admin = $admin_info->id ?? 1;
        $instock->check_status = 1;
        $instock->is_inspection = 0;
        $instock->renling = $data['renling'] ?? 1;
        $instock->is_clientArea = isset($data['isCustomerZone']) &&  $data['isCustomerZone'] ? 2 : 0;
        $instock->orders_id = $data['orders_id'] ?? 0;
        $instock->delete_orders_payment = isset($data['products_instock_id']) && $data['products_instock_id'] > 0 ? 2 : 0;
        $instock->amount_use = isset($data['products_instock_id']) && $data['products_instock_id'] > 0 ? $paymentVoucher->usable / 100 : 0;
        $shipping = $this->instockShippingRepository->createByModel($instock);

        //插入fileds表数据
        $shippingFileds = new ProductsInstockShippingFields();
        $shippingFileds->products_instock_id = $shipping->products_instock_id;
        $shippingFileds->company_number = $paymentVoucher->customer_company_number;
        $this->productsInstockShippingFieldsRepository->createByModel($shippingFileds);
        return $shipping;
    }
}
