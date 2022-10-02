<?php
namespace Modules\ERP\Service;

use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\RechnungInvoiceRepository;
use Modules\ERP\Contracts\RechnungInvoiceService as ContractsRechnungInvoiceService;
use Modules\ERP\Entities\RechnungInvoice;
use Modules\ERP\Entities\RechnungInvoiceOrder;
use Modules\Finance\Entities\PaymentVoucher;

class RechnungInvoiceService implements ContractsRechnungInvoiceService
{
    private $instockShippingRepository;
    private $rechnungInvoice;
    private $rechnungInvoiceOrder;
    private $rechnungInvoiceRepository;

    public function __construct
    (InstockShippingRepository $instockShippingRepository,
     RechnungInvoice $rechnungInvoice,
     RechnungInvoiceOrder $rechnungInvoiceOrder,
     RechnungInvoiceRepository $rechnungInvoiceRepository)
    {
        $this->instockShippingRepository = $instockShippingRepository;
        $this->rechnungInvoice = $rechnungInvoice;
        $this->rechnungInvoiceOrder  = $rechnungInvoiceOrder;
        $this->rechnungInvoiceRepository  = $rechnungInvoiceRepository;
    }

    public function revokeRechnungInvoice(PaymentVoucher $paymentVoucher,array $data){
        if (!$data['products_instock_id'] && !$data['origin_id']) {
            return true;
        }
        $returnMoney = $paymentVoucher->usable/100;
        //账期订单数据
        $rechnungOrderShippingId = $data['origin_id']??$data['products_instock_id'];
        $rechnungOrderInfo = $this->rechnungInvoiceRepository->getRechnungOrderInfoById($rechnungOrderShippingId);
        if (!is_null($rechnungOrderInfo) && $rechnungOrderInfo->parent_id) {
            //获取账期账号数据
            $returnMoney = round($returnMoney*$rechnungOrderInfo->use_money/$rechnungOrderInfo->apply_money,2);
            $rechnungInfo = $this->rechnungInvoiceRepository->getRechnungInfoById($rechnungOrderInfo->parent_id);
            if (!is_null($rechnungInfo) && $rechnungInfo->id) {
                $returnMoneyNew = $returnMoney+$rechnungOrderInfo->return_monry;
                $upRechnungOrder = [
                    'return_money' => $returnMoneyNew,
                ];
                if (bccomp($returnMoneyNew,$rechnungOrderInfo->use_money,4) != -1) {//整单结清  标记结清状态
                    $returnMoney = $rechnungOrderInfo->use_money - $rechnungOrderInfo->return_monry;//超额结清，只需要归还未结清部分
                    $upRechnungOrder['return_money'] = $rechnungOrderInfo->use_money;
                    $upRechnungOrder['is_payment'] = 1;
                    $upRechnungOrder['payment_remarks'] = '自动标记回款';
                }
                $upRechnung = [
                    'apply_money' => $returnMoney+$rechnungInfo->apply_money,
                ];
                $this->rechnungInvoiceRepository->rechnungOrderUpdate(
                    ['id'=>$rechnungOrderInfo->id], $upRechnungOrder);
                $this->rechnungInvoiceRepository->rechnungUpdate(
                    ['id'=>$rechnungInfo->id], $upRechnung);
            }
        }
        return true;
    }

    /**
     * 判断是否是账期单、临时额度单
     * @param $instockArr
     * @return int
     */
    public function instocKIsAccount($instockArr)
    {
        $isAccount = 0;
        foreach ($instockArr as $val) {
            if (preg_match('/^BK/i', $val['orders_num'])) {
                $isAccount = 2;//补款单默认账期=30
                break;
            }
            $splitOrder = $val['split_order'];
            $productHeight = $val['product_height'];
            $originId = $val['origin_id'];
            $oldId = $splitOrder;
            if ($productHeight) {
                $oldId = ($oldId < $productHeight && $oldId > 0)?$oldId:$productHeight;
            }
            if ($originId) {
                $oldId = ($oldId < $originId && $oldId > 0)?$oldId:$originId;
            }
            $rechnungOrderShippingId = $oldId??$val['products_instock_id'];
            $rechnungOrderInfo = $this->rechnungInvoiceRepository->getRechnungOrderInfoById($rechnungOrderShippingId);
            if (isset($rechnungOrderInfo->parent_id) && !empty($rechnungOrderInfo->parent_id)) {
                $isAccount = 1;
                break;
            }
        }
        if (empty($isAccount)) {
            foreach ($instockArr as $val) {
                if ($val['order_payment'] == 99) {
                    $isAccount = 2;
                    break;
                }
            }
        }
        return $isAccount;
    }
}
