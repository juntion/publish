<?php

use App\Services\Payments\PurchaseService;
use App\Request\MyCreditSettingRequest;
use App\Services\Common\ApiResponse;

//导入语言包
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/validation.common.php'); // 表单验证语言包
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/my_dashboard.php');

//
$action = trim(isset($_GET['ajax_request_action']) ? zen_db_prepare_input($_GET['ajax_request_action']) : '');
$api = new ApiResponse();
if (!isAjax() || $_SERVER['REQUEST_METHOD'] != 'POST' || !in_array($action, ['applyCreditLimit'])) {
    $api->setStatus(403)->setMessage(FS_ACCESS_DENIED)->response('');
}
if (!isset($_SESSION['customer_id'])) {
    $api->setStatus(401)->setMessage(FS_ACCESS_DENIED)->response(zen_href_link('login'));
}
$purchase = new PurchaseService();
$info = $purchase->getPurchaseInfo();
if (!$info['is_po_account'] || $info['is_frozen']) {
    $api->setStatus(401)->setMessage(FS_ACCESS_DENIED)->response(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
}

switch ($action) {
    case 'applyCreditLimit' :
        $apply_money = zen_db_prepare_input($_POST['apply_money'] ?: '');
        $apply_reason = zen_db_prepare_input($_POST['apply_reason'] ?: '');
        $data = [
            'type'         => 2,
            'apply_reason' => $apply_reason,
            'apply_money'  => $apply_money
        ];
        $validate = new MyCreditSettingRequest();
        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage($error[0])->response();
        }
        if ($purchase->applyCreditLimit($apply_money, $apply_reason)) {
            $api->setMessage(FS_APPLY_CREDIT_SUCCESS_TIP1)->response('');
        } else {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response('');
        }
        break;
    default:
        $api->setStatus(403)->setMessage(FS_ACCESS_DENIED)->response('');
        break;
}
exit();