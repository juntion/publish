<?php

namespace App\Traits\Loader\Payment;

use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Models\PaymentMethod;
use App\Models\ProuctsInstockShippingPaymentInvoice;
use App\Models\ProuctsInstockShippingPaymentInvoiceOrders;
use App\Models\ProuctsInstockShippingPaymentInvoiceService;
use App\Models\ProuctInstockShippingApply;
use App\Services\Customers\CustomerService;

trait PurchaseLoader
{

    /**
     * @var  CustomerService
     */
    private $customerService;

    /**
     * @var ProuctInstockShippingApply;
     */
    private $pisaModel;

    /**
     * @var PaymentMethod;
     */
    private $pmModel;

    /**
     * @var Currency
     */
    private $currencyModel;

    /**
     * @var Order
     */
    private $orderModel;

    /**
     * @var orders_split
     */
    private $orderSplitModel;

    /**
     * @var ProuctsInstockShippingPaymentInvoice
     */
    private $pispiModel;

    /**
     * @var ProuctsInstockShippingPaymentInvoiceService
     */
    private $pispisModel;

    /**
     * @var ProuctsInstockShippingPaymentInvoiceOrders
     */
    private $pispioModel;

    /**
     * @return CustomerService
     */
    private function loadCustomerService()
    {
        if (!$this->customerService) {
            $this->customerService = new CustomerService();
        }
        return $this->customerService;
    }

    /**
     * @return ProuctInstockShippingApply
     */
    private function loadPisaModel()
    {
        if (!$this->pisaModel) {
            $this->pisaModel = new ProuctInstockShippingApply();
        }
        return $this->pisaModel;
    }

    /**
     * @return PaymentMethod
     */
    private function loadPMModel()
    {
        if (!$this->pmModel) {
            $this->pmModel = new PaymentMethod();
        }
        return $this->pmModel;
    }

    /**
     * @return Currency
     */
    private function loadCurrencyModel()
    {
        if (!$this->currencyModel) {
            $this->currencyModel = new Currency();
        }
        return $this->currencyModel;
    }

    /**
     * @return Order
     */
    private function loadOrderModel()
    {
        if (!$this->orderModel) {
            $this->orderModel = new Order();
        }
        return $this->orderModel;
    }

    /**
     * @return Order
     */
    private function loadOrderSplitModel()
    {
        if (!$this->orderSplitModel) {
            $this->orderSplitModel = new OrderSplit();
        }
        return $this->orderSplitModel;
    }

    /**
     * @return ProuctsInstockShippingPaymentInvoice
     */
    private function loadPispiModel()
    {
        if (!$this->pispiModel) {
            $this->pispiModel = new ProuctsInstockShippingPaymentInvoice();
        }
        return $this->pispiModel;
    }

    /**
     * @return ProuctsInstockShippingPaymentInvoiceService
     */
    private function loadPispisModel()
    {
        if (!$this->pispisModel) {
            $this->pispisModel = new ProuctsInstockShippingPaymentInvoiceService();
        }
        return $this->pispisModel;
    }

    /**
     * @return ProuctsInstockShippingPaymentInvoiceOrders
     */
    private function loadPispioModel()
    {
        if (!$this->pispisModel) {
            $this->pispioModel = new ProuctsInstockShippingPaymentInvoiceOrders();
        }
        return $this->pispioModel;
    }
}
