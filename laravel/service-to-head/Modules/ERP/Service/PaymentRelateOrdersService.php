<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2021-03-26
 * Time: 18:55
 */

namespace Modules\ERP\Service;

use Modules\Admin\Entities\Admin;
use Modules\Finance\Entities\PaymentVoucher;
use Illuminate\Support\Carbon;
use Modules\ERP\Contracts\PaymentRelateOrdersRepository;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\PaymentRelateOrdersService as ContractsPaymentRelateOrdersService;
use Modules\ERP\Entities\PaymentRelateOrders;

class PaymentRelateOrdersService implements ContractsPaymentRelateOrdersService
{

    protected $paymentRelateOrders;
    protected $paymentRelateOrdersRepository;
    protected $instockShippingRepository;

    public function __construct
    (PaymentRelateOrdersRepository $paymentRelateOrdersRepository,
     PaymentRelateOrders $paymentRelateOrders,
     InstockShippingRepository $instockShippingRepository)
    {
        $this->paymentRelateOrders = $paymentRelateOrders;
        $this->paymentRelateOrdersRepository = $paymentRelateOrdersRepository;
        $this->instockShippingRepository = $instockShippingRepository;
    }


    public function createByVoucher(PaymentVoucher $paymentVoucher, Admin $admin,array $data){
        $paymentRelateOrders = $this->paymentRelateOrders;
        if (!$data['related_id'] || !$data['products_instock_id']) {
            return $paymentRelateOrders;//没有订单或者到款的  不需要生成
        }
        //汇率  实际已经无用   目前支出结清与订单是同一币种  无需美元中间换算  存储为兼容旧流程
        $paymentRelateOrders->products_instock_id = $data['products_instock_id'];
        $paymentRelateOrders->related_id = $data['related_id'];
        $paymentRelateOrders->related_price = $paymentVoucher->usable/100;
        $paymentRelateOrders->value1 = 1;
        $paymentRelateOrders->value2 = 1;
        $paymentRelateOrders->relate_time = Carbon::now();
        $paymentRelateOrders->relate_id = $admin->id;
        $paymentRelateOrdersRes = $this->paymentRelateOrdersRepository->createByModel($paymentRelateOrders);
        if ($paymentRelateOrdersRes->id) {
            $shippingData = $this->instockShippingRepository->getOrderInfoByProductsInstockId($paymentRelateOrders->products_instock_id);
            $this->instockShippingRepository->shippingUpdate(['products_instock_id'=>$paymentRelateOrders->products_instock_id],['amount_use'=>$shippingData->amount_use+$paymentRelateOrders->related_price]);
        }
        return $paymentRelateOrdersRes;
    }
}
