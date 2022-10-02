<?php
use App\Services\Common\ApiResponse;
$api = new ApiResponse();
//关闭接口
$api->setStatus(404)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);

$ajaxRequestAction = zen_db_prepare_input($_GET['ajax_request_action'] ?: '');

switch ($ajaxRequestAction){
    case "header_nav":
        $cid =  $_POST['cid'] ? (int)zen_db_prepare_input($_POST['cid']) : 0;
        $page =  $_POST['page'] ? zen_db_prepare_input($_POST['page']) : 0;
        if($cid && $page){
            $new_products = get_products_by_cid($cid,'new_products_tag = 1',3,$page);
            $products_html = get_header_new_products_html($new_products);
            $api->setStatus(200)->setMessage("success")->response(['html' => $products_html]);
        }else{
            $api->setStatus(401)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        }
        break;
    default:
        $api->setStatus(404)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        break;
}
?>