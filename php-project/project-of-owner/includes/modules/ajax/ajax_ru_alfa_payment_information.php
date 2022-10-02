<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2020/6/2 0002 12:07
 */

use App\Services\Common\ApiResponse;
use App\Services\Payments\RuPaymentServices;
use App\Request\AlfaSettingRequest;

$api = new ApiResponse();

$validate = new AlfaSettingRequest();

$services = new RuPaymentServices();

$services->setInformationAddress();

//语言包
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require_once($language_page_directory . 'views/checkout_common.php'); // 表单验证语言包

if (empty($_POST)) {
    $api->setStatus(406)->setMessage('error')->response(FS_ACCESS_DENIED);
}
if (!isset($_SESSION['customer_id'])) {
    $api->setStatus(403)->setMessage('error')->response(FS_ACCESS_DENIED);
}
$action = isset($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : '';
$config = [
    'savePath' => 'rualfa/' . $_SESSION['customer_id'],
    'isChangeName' => false,
    'fileExtension' => [
        'png',
        'jpg',
        'jpeg',
        'doc',
        'xls',
        'docx',
        'xlsx',
        'pdf'
    ]
];
switch ($action) {
    case 'uploadFile':
        if (!$_FILES['paymentUploadFile']['size'] && !$_FILES['paymentUploadFile']['tmp_name']  && empty($_POST['cardPath'])) {
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }

        $path = $services->uploadCard($config, 'paymentUploadFile');

        if (empty($path) && empty($_POST['cardPath'])) {
            //没有图片上传
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }

        $path = empty($path) ? $_POST['cardPath'] : $path;


        $data = [
            'primaryKeyId' => zen_db_prepare_input($_POST['primaryKeyId']),
            'alfa_phone' => '',
        ];

        if (empty($path)) {
            $data['card_path'] = $_POST['cardPath'];
        } else {
            $data['card_path'] = $path;
            $data['card_path_name'] = $_FILES['paymentUploadFile']['name'];
        }

        $res = $services->createRuOrderInfo($data);

        if ($res) {
            $api->response();
        } else {
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }
        break;
    case 'updateText':
    case 'createText':
        $data = [
            'alfa_organization' => zen_db_prepare_input($_POST['alfa_account_organization']),
            'alfa_legal_address' => zen_db_prepare_input($_POST['alfa_account_legal']),
            'alfa_inn' => zen_db_prepare_input($_POST['alfa_account_inn']),
            'alfa_kpp' => zen_db_prepare_input($_POST['alfa_account_kpp']),
            'alfa_bic' => zen_db_prepare_input($_POST['alfa_account_bic']),
            'alfa_bank_name' => zen_db_prepare_input($_POST['alfa_account_bank']),
            'alfa_email' => zen_db_prepare_input($_POST['alfa_account_email']),
            'alfa_phone' => zen_db_prepare_input($_POST['alfa_account_phone']),
            'card_path' => ''
        ];

        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(407)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }

        if ($action == 'updateText') {
            $data['primaryKeyId'] = zen_db_prepare_input($_POST['primaryKeyId']);
        }

        $res = $services->createRuOrderInfo($data);

        if ($res) {
            $api->response();
        } else {
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }
        break;
    case 'createFile':
        if (!$_FILES['paymentUploadFile']['size'] && !$_FILES['paymentUploadFile']['tmp_name']) {
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }
        $path = $services->uploadCard($config, 'paymentUploadFile');

        if (empty($path)) {
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }
        $data = [
            'card_path' => $path,
            'card_path_name' => $_FILES['paymentUploadFile']['name'],
            'alfa_phone' => '',
        ];

        $res = $services->createRuOrderInfo($data);

        if ($res) {
            $api->response();
        } else {
            $api->setStatus(400)->setMessage('error')->response(FS_SYSTME_BUSY);
        }
        break;
    case 'deleteRuPayment':
        $result = $services->deletePaymentInformation(zen_db_prepare_input($_POST['id']), $_SESSION['customer_id']);
        $api->response();
        break;
}