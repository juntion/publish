<?php

use App\Services\Rma\RmaService;
use App\Services\RmaOffline\RmaOfflineService;
use App\Request\RmaApplyRequest;
use App\Services\Common\ApiResponse;
use App\Services\Address\AddressBookService;

//语言包可以单独调用
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require_once($language_page_directory . 'views/validation.common.php');
$api = new ApiResponse();

if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
    $_SESSION['login_timeout'] = 1;
    echo json_encode(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login')));die;
}

$action = $_GET['ajax_request_action'];
$validate = new RmaApplyRequest();
$type = $_POST['orders_type'];
if ($type == 2) {
    $rma_c = new RmaOfflineService();
} else {
    $rma_c = new RmaService();
}
$ads = new AddressBookService();

switch ($action) {

    case 'rma_apply':
        $rma_data = $_POST;
        $products_cont = $rma_data['products'];
        $orders_id = $rma_data['orders_id'];
        $products_arr = [];
        $images = '';
        if($_FILES['refund_img']){
            //上传退换货附件
            $upload_image = $rma_c->uploadRmaPic($_FILES['refund_img']);
            if($upload_image['code'] == 1){
                foreach ($upload_image['path'] as $path){
                    $images .= $path.';';
                    $file_path = DIR_FS_CATALOG.'images/'.$path;
                    @unlink($file_path);
                }
                $images = rtrim($images,';');
            }
        }
        foreach ($products_cont as $opid) {

            if (!empty($opid)) {
                $products_data = array(
                    'products_num' => $rma_data['qty'][$opid],
                    'reasons_type' => $rma_data['reason'],
                    'customers_service_content' => $rma_data['reason_comments'],
                    'service_number' => $rma_data['serial_number'][$opid],
                    'images' => $images,
                );
                $check_data = array_merge(array('service_type_id' => $rma_data['rma_type']), $products_data);
                $validate->data = $check_data;
                $error = $validate->checkData();

                if (!empty($error)) {
                    $api->setStatus(406)->setMessage('error')->response($error);
                }

                $op_arr = explode('_',$opid);
                $products_id = $op_arr[1];
                //特殊组合产品组装数据--已废除，但暂时保留代码
                if(in_array($products_id, [96375,96376]) && $rma_data['rma_type'] == 1 && false){

                    $products_composite = fs_get_data_from_db_fields('composite_products','products_composite','products_id = '.$products_id);
                    if(!empty($products_composite)){
                        $fms_arr = explode(',',$products_composite);
                        foreach ($fms_arr as $val){
                            $son_arr = explode(':',$val);
                            $son_id = $son_arr[0];
                            $op_sid = str_replace($products_id,$son_id,$opid);
                            $products_arr[] = array_merge(array('op_id' => $op_sid), $products_data);
                        }
                    }else{
                        $products_arr[] = array_merge(array('op_id' => $opid), $products_data);
                    }

                }else{
                    $products_arr[] = array_merge(array('op_id' => $opid), $products_data);
                }

            }
        }

        //数据格式化
        $rma_data['products'] = $products_arr;
        unset($rma_data['qty']);
        unset($rma_data['reason']);
        unset($rma_data['comments']);
        unset($rma_data['serial_number']);

        try {
            if ($type == 2) {
                $rma_res = $rma_c->getRmaOfflineApply($rma_data);
            } else {
                $rma_res = $rma_c->getRmaApply($rma_data);
            }

            $cs_num = $rma_res['data']['s_number'];
            $email_data = $rma_res['data']['email_data'];
            unset($rma_res['data']['email_data']);

            $msg = $rma_res['msg'];
            $status = $rma_res['status'];
            $data = $rma_res['data'];
            $data['audit_type'] = $email_data['audit_type'];

            if($status == 1) {//数据插入成功则发送售后邮件
                sendRmaEmail($email_data, $orders_id, $cs_num);
            }
            $api->setMessage($msg)->setStatus($status)->response($data);
        } catch (Exception $e) {
            $api->setStatus(406)->setMessage($e->getMessage())->response();
        }

        break;
    case 'rma_apply_ads':
        $ads_data = $_POST;

        $ads_data['address_type'] = 2;//运输地址
        $ads_data['customers_id'] = $_SESSION['customer_id'];
        $ads_data['entry_email'] = $_SESSION['customers_email_address'];
        $ads_data['entry_country_id'] = $_POST['tagcountry'];
        unset($ads_data['tagcountry']);

        $ads_id = $ads->insertOneAddress($ads_data);

        $api->setStatus(1)->setMessage('')->response($ads_id);
        break;
    case 'rma_send_ads':
        $return = array('flag' => 0, 'msg' => '');
        $service_id = $_POST['service_id'];
        $insert_data = array(
            'customers_service_id' => $_POST['service_id'],
            'entry_company' => $_POST['entry_company'],
            'entry_company_type' => $_POST['entry_company_type'],
            'entry_firstname' => $_POST['entry_firstname'],
            'entry_lastname' => $_POST['entry_lastname'],
            'entry_street_address' => $_POST['entry_street_address'],
            'entry_suburb' => $_POST['entry_suburb'],
            'entry_postcode' => $_POST['entry_postcode'],
            'entry_city' => $_POST['entry_city'],
            'entry_state' => $_POST['state'],
            'entry_country_id' => $_POST['tagcountry'],
            'entry_telephone' => $_POST['entry_telephone'],
            'entry_tel_prefix' => $_POST['entry_tel_prefix'],
            'entry_email' => $_SESSION['customers_email_address'],
            'type' => 2
        );

        $res_ads = $rma_c->insertRmaLabelAddress($insert_data, $service_id);
        $return = array('flag' => 1, 'msg' => 'success');

        $api->setStatus($return['flag'])->setMessage($return['msg'])->response();
        break;
    case 'rma_create_label':

        $service_id = $_POST['service_id'];
        $orders_id = $_POST['order_id'];
        $label_type = $_POST['label_type'];
        $orders_info = $rma_c->getOrderInfo($orders_id);

        $res = [];
        switch ($label_type){
            case 1:
                require DIR_WS_MODULES . "pages/print_shipping_label/fedexLabel.php";
                $fedex = new fedexLabel($service_id, $orders_id, $orders_info);
                $res = $fedex->action();
                break;
            case 2:
                function Auto($class){
                    $class = str_replace("\\", '/', ltrim($class, '\\'));
                    $bese = DIR_WS_MODULES.'pages/print_shipping_label/';
                    $path = $bese.$class.'.php';
                    if(file_exists($path)){
                        require $path;
                    }
                }
                spl_autoload_register('Auto');

                $_POST['ups_id'] = $service_id;
                require DIR_WS_MODULES . "pages/print_shipping_label/Ups/Soap/Implement.php";
                $ups = new \Ups\Soap\Implement($orders_id);
                $ups_data = $ups->action();

                $res['flag'] = $ups_data['status'] == 'fail' ? 0 : 1;
                $res['msg'] = $ups_data['description'];
                break;
            case 3:
                require DIR_WS_MODULES . "pages/print_shipping_label/SimplyPost.php";
                $simplypost = new SimplyPost($service_id, $orders_id, $orders_info);
                $res = $simplypost->action();
                break;
            case 4:
                require DIR_WS_MODULES . "pages/print_shipping_label/AusPost.php";
                $AuPost = new ShipTrack($service_id, $orders_id, $orders_info);
                $res = $AuPost->action();
                break;
        }

        //更新售后标签状态
        if($res['flag'] == 1){
            $rma_c->updateLabelStatus(['customers_service_id' => $service_id]);
        }
        $api->setStatus($res['flag'])->setMessage($res['msg'])->response();
        break;
}