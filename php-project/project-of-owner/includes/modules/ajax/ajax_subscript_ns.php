<?php

use App\Services\Common\ApiResponse;
use App\Services\NsManages\NsSubscriptService;
use App\Services\Customers\CustomerService;

$api = new ApiResponse();
$action = $_GET['ajax_request_action'];
if (empty($action) || empty($_SESSION['customer_id'])) {
    $api->setStatus(403)->setMessage(FS_SYSTME_BUSY)->response();
}

switch ($action) {
    case "subscript":
        $customer = new CustomerService();
        $companyNumber = $customer->setCustomer()->getCompanyNumber();
        //通知ns 数据发生了变化
        $nsSubscribe = new NsSubscriptService();
        $nsSubscribe->subscript($companyNumber);
        $api->response();
        break;
}
