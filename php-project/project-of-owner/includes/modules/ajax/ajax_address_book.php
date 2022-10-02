<?php

use App\Request\AddressSettingRequest;
use App\Services\Address\AddressBookService;
use App\Services\Common\ApiResponse;
use App\Services\Customers\CustomerService;

$validate = new AddressSettingRequest();
$api = new ApiResponse();
$address = new AddressBookService();
$customer = new CustomerService();


//语言包
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require_once($language_page_directory . 'views/checkout_common.php'); // 表单验证语言包
require_once($language_page_directory . 'views/validation.common.php');

if (!$_POST) {
    $api->setStatus(406)->setMessage('error')->response(FS_ACCESS_DENIED);
}
if (!isset($_SESSION['customer_id'])) {
    $api->setStatus(403)->setMessage('error')->response(FS_ACCESS_DENIED);
}
$action = isset($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : '';
switch ($action) {
    case 'delete_address_book' :
        $address_id = zen_db_input($_POST['address_book_id']);
        $address_type = zen_db_input($_POST['address_type']);
        $data = [
            'address_book_id' => $address_id,
            'type' => 1,
        ];
        //检测该用户是否有操作该地址的权限
        $check_audit = $address->checkPermissionAddress($_SESSION['customer_id'], $address_id);
        if(!$check_audit){//该用户无权操作该地址
            $api->setStatus(406)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }

        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }
        // 单条记录删除,查询地址的类型
        $address_id_type = $address->getAddressInfo(
            ['address_book_id' => $address_id],
            ['address_book_id', 'address_type']
        );
        if (!isset($address_id_type)) {
            $api->setStatus(403)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }
        // 执行删除地址操作
        $delete_addres_info = $address->deleteAddressBook($address_id_type[0]['address_book_id']
            , $address_id_type[0]['address_type']);
        if (!$delete_addres_info) $api->setStatus(422)->setMessage(FS_SYSTME_BUSY)->response(FS_FORM_REQUEST_ERROR);
        $api->setStatus(200)->response();
        break;
    case 'create_update_new_address' :
        $address_id = (int)zen_db_input($_POST['ship_bill_address_id']);
        $company_type = strip_tags(zen_db_input($_POST['company_type']));
        $entry_company = strip_tags(zen_db_input($_POST['entry_company']));
        $entry_firstname = strip_tags(zen_db_input($_POST['entry_firstname']));
        $entry_lastname = strip_tags(zen_db_input($_POST['entry_lastname']));
        $entry_street_address = strip_tags(zen_db_input($_POST['entry_street_address']));
        $entry_suburb = strip_tags(zen_db_input($_POST['entry_suburb']));
        $entry_postcode = zen_db_input($_POST['entry_postcode']);
        $entry_city = strip_tags(zen_db_input($_POST['entry_city']));
        $entry_country_id = zen_db_input((int)$_POST['tagcountry']);
        $entry_state = strip_tags(zen_db_input($_POST['entry_state']));
        $entry_telephone = zen_db_input($_POST['entry_telephone']);
        $entry_tax_number = zen_db_input($_POST['entry_tax_number']);  // entry_tax_number
        $address_type = zen_db_input($_POST['add_ship_bill']); // address_type  地址类型
        //$ticket_number = isset($_POST['entry_ticket_number']) ? zen_db_input($_POST['entry_ticket_number']) : ''; // sg站点添加
        $data = [
            'address_type' => $address_type,
            'company_type' => $company_type,
            'entry_company' => $entry_company,
            'entry_firstname' => $entry_firstname,
            'entry_lastname' => $entry_lastname,
            'entry_street_address' => $entry_street_address,
            'entry_suburb' => $entry_suburb,
            'entry_postcode' => $entry_postcode,
            'entry_city' => $entry_city,
            'entry_telephone' => $entry_telephone,
            'entry_state' => $entry_state,
            'entry_tax_number' => $entry_tax_number,
            'entry_country_id' => $entry_country_id,
            'customers_id' => $_SESSION['customer_id'],
            'is_avaTax_check' => 0,
            'type' => 2,
            //'ticket_number' => $ticket_number
        ];
        //验证税号
        if($company_type == 'BusinessType' || $entry_tax_number){
            require_once DIR_WS_CLASSES . 'class.checkout.php';
            $checkout = Checkout::getInstance([
                "validate_format" => "php",
                "main_page" => "checkout",
                "state_format" => "php"
            ]);
            $vatValidate = $checkout::validate($data);
            if (!empty($vatValidate)) {
                $api->setStatus(408)->setMessage('error')->response($vatValidate['entry_tax_number']['remote_validate_tax_number']);
            }
        }
        $validate->data = $data;
        $error = $validate->checkData();
        //验证 entry_postcode 有效性
        $is_valid_zip = $address->isValidZipCode($entry_country_id,$entry_postcode);
        if(!empty($is_valid_zip['message'])){
            $error['entry_postcode'] = $is_valid_zip['message'];
        }
        if (!empty($error)) {
            $api->setStatus(407)->setMessage('error')->response($error);
        }
        unset($data['type']);  // 该变量只是用来定义传递参数的，不需要执行插入
        if ($address_id) {
            $result = $address->updateAddress($data, $address_id);
            if ($result) {
                $result['address_id'] = $address_id;
                $html = $address->addressHtmlUpdate($result);
                $result['html'] = $html;
                $api->setStatus(1)->setMessage('success')->response($result);
            }
            $api->setStatus(404)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        } else {
            $result = $address->createNewAddress($data);
            $default = isset($result['is_default']) ? $result['is_default'] : '';
            $html = $address->addressHtml($result, $default);
            $result['html'] = $html;
                if (!$result) {
                $api->setStatus(406)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
            }
            $api->setStatus(200)->setMessage('success')->response($result);
        }
        break;

    case  'select_default_address' :
        $address_id = zen_db_input($_POST['address_book_id']);
        $where = ['address_book_id' => $address_id, 'customers_id' => $_SESSION['customer_id']];
        $field = ['address_book_id', 'address_type'];
        $data = [
            'address_book_id' => $address_id,
            'type' => 1,
        ];
        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(404)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }
        // 核对修改地址是否正确
        // 修改默认地址
        $address_info = $address->getAddressInfo($where, $field);
        $default_address_info = $address->getDefaultAddress();
        if ($address_info[0]['address_type'] !== 2) {
            $default_address_id = $address_info[0]['customers_default_address_id'];
        }else{
            $default_address_id = $address_info[0]['customers_default_billing_address_id'];
        }
        if ($default_address_id == $address_id) {
            $api->setStatus(422)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }
        if (!$address_info) $api->setStatus(405)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        $result = $address->selectAddressBook($address_id, $address_info[0]['address_type'], $customer_id);
        if (!$result) {
            $api->setStatus(406)->setMessage('error')->response(FS_FORM_REQUEST_ERROR);
        }
        $api->setStatus(200)->setMessage('success')->response($res);
        break;
}
