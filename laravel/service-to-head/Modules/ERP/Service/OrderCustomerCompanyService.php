<?php

namespace Modules\ERP\Service;

use Modules\ERP\Contracts\OrderCustomerCompanyService as ContractsOrderCustomerCompanyService;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\OrderRepository;
use Modules\ERP\Contracts\OrderPIRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\Share\Entities\Collection;


class OrderCustomerCompanyService implements ContractsOrderCustomerCompanyService
{
    public $instockShippingRepository;
    public $orderRepository;
    public $customerRepository;
    public $orderPiRepository;

    public function __construct(InstockShippingRepository $instockShippingRepository, OrderRepository $orderRepository, CustomerRepository $customerRepository, OrderPIRepository $orderPIRepository)
    {
        $this->instockShippingRepository = $instockShippingRepository;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->orderPiRepository = $orderPIRepository;
    }

    public function getCustomerAndCompanyInfoByOrderNumber($orderNumber)
    {
        // 优先从订单流程表中找 若没有则再从线上线下单中找
        $orderInfo = $this->instockShippingRepository->getOrderInfoByOrderNumber($orderNumber);

        $customerInfo = new Collection();

        $customerNum = $orderInfo->No ?? "";
        $customerInfo->customerNumber = $customerNum;

        if (empty($customerNum)) {
            $orderNumber = explode('-', $orderNumber)[0];

            // 线上单查找
            $orderInfo = $this->orderRepository->getOrderInfoByOrderNumber($orderNumber);

            if (!empty($orderInfo->customers_id)) {
                $customerNum = $this->customerRepository->getCustomerOnByID($orderInfo->customers_id);
                $customerInfo->customerNumber = $customerNum->customers_number_new ?? "";
                $customerInfo->Info = $customerInfo->customerNumber ? $customerNum : "";
            } else if (!empty($orderInfo->customers_email_address)) {
                $customerNum = $this->customerRepository->getCustomerOffByEmail($orderInfo->customers_email_address);
                $customerInfo->customerNumber = $customerNum->customers_number_new ?? "";
                $customerInfo->Info = $customerInfo->customerNumber ? $customerNum : "";
            }

            if (empty($customerInfo->customerNumber)) {
                // 线下单查找
                $piInfo = $this->orderPiRepository->getOrderInfoByOrderNumber($orderNumber);
                $piCustomerId = $piInfo->pi_customers_id ?? ($piInfo->customers_id ?? 0);
                $customersType = $piInfo->pi_customers_type ?? ($piInfo->customers_type ?? "");
                if (!empty($customersType) && $customersType == 1 && $piCustomerId) {
                    $customerNum = $this->customerRepository->getCustomerOnByID($piCustomerId);
                    $customerInfo->customerNumber = $customerNum->customers_number_new ?? "";
                    $customerInfo->Info = $customerInfo->customerNumber ? $customerNum : "";
                } else if (!empty($customersType) && $customersType == 2 && $piCustomerId) {
                    $customerNum = $this->customerRepository->getCustomerOffByID($piCustomerId);
                    $customerInfo->customerNumber = $customerNum->customers_number_new ?? "";
                    $customerInfo->Info = $customerInfo->customerNumber ? $customerNum : "";
                }
            }
        }

        return $customerInfo;
    }
}