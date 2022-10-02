<?php

use App\Services\Common\ApiResponse;
use App\Services\OrderSplit\OrderSplitService;
use App\Services\Orders\OrderService;

$api = new ApiResponse();
$action = $_GET['ajax_request_action'];
// 语言包
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require_once($language_page_directory . 'views/validation.common.php');
require_once($language_page_directory . 'views/manage_orders.php');
switch($action){
    case 'editConfirmReceipt':
        if (empty($_SESSION['customer_id'])) {
            $api->response(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login')));
        }
        $orders_id = $_POST['orders_id']?(int)zen_db_prepare_input($_POST['orders_id']):0;
        if(!$orders_id){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        $orderSplitService = new OrderSplitService();
        // 不是自己的订单，没有权限查看
        if(!$orderSplitService->setCustomerVisit($orders_id)){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        $result = $orderSplitService->editOrderStatus($orders_id);
        if ($result) {
            $data = array('status' => 1, 'info' => F_RECEIPT_CONFIRMATION_SUCCESS_TIP, 'data' => '');
        } else {
            $data = array('status' => 0, 'info' => 'fail', 'data' => '');
        }
        $api->response($data);
        break;
    case 'addServicePopup':
        $order_id = (int)zen_db_prepare_input($_POST['orders_id']);
        if (empty($order_id)) {
            $api->setMessage('error')->setStatus(403)->response();
        } else {
            $orderSplitService = new OrderSplitService();
            $son_order = $orderSplitService->getSonOrdersInfo($order_id,'1',true);
            if ($son_order) {
                $popupOrderNumber = $son_order[0]['orders_number'];
                $popupHtml = '';
                if(sizeof($son_order[0]['products'])){
                    $see_more = false;
                    $show = '';
                    $popupHtml .= '<input type="hidden" name="service_order_number" value="' . $son_order[0]['orders_number'] . '">';
                    $popupHtml .= '<ul class="new_technical_support_ul">';
                    foreach ($son_order[0]['products'] as $p_key => $p_val) {
                        if ($p_key > 2) {
                            $see_more = true;
                            $show = 'show';
                            $style = 'style="display: none;"';
                        }
                        if ($p_key > 2)
                        $popupHtml .= '<li class="new_technical_support_li ' . $show . '" ' . $style . '>';
                        $popupHtml .= '<dl class="new_technical_support_dl after">';
                        $popupHtml .= '<dt class="new_technical_support_dt">';
                        $popupHtml .= '<input type="checkbox" hidden=""  name="service_pid" value="' . $p_val['products_id'] .'">';
                        $popupHtml .= '<a href="javascript:;" class="iconfont icon new_tech_radio">
                                            &#xf134;
                                        </a>';
                        $popupHtml .= '<img src="' . $p_val['image'] . '">';
                        $popupHtml .= '</dt>';
                        $popupHtml .= '<dd class="new_technical_support_dd">';
                        $popupHtml .= '<p class="new_technical_support_dd_txt">';
                        $popupHtml .= '<a href="' . reset_url($p_val['products_href']) . '">' . $p_val['products_name'] . '</a>';
                        $popupHtml .= '</p>';
                        $popupHtml .= '<p class="new_technical_support_id">#' . $p_val['products_id'] .'</p>';
                        if ($p_val['son_products_info']) {
                            $popupHtml .= '<div class="new_technical_support_subproducts">';
                            $popupHtml .= '<div class="new_te_su_tit_container">
                                                <p class="new_te_su_tit">
                                                    ' . FS_ITEM_INCLUDES_PRODUCTS .'
                                                    <i class="iconfont icon">&#xf087;</i>
                                                </p>
                                            </div>';
                            foreach ($p_val['son_products_info'] as $son_p_val) {
                                $popupHtml .= ' <div class="new_te_su_dl_container">
                                                    <dl class="new_te_su_dl">
                                                        <dt>
                                                            <img src="' . $son_p_val['image'] . '">
                                                        </dt>
                                                        <dd>
                                                            <p class="new_te_su_dl_tit">
                                                                '. $son_p_val['products_name'] .'
                                                            </p>
                                                            <p class="new_te_su_dl_txt">
                                                                '. $son_p_val['qty'] .' x '. $son_p_val['products_price_str'] .'/ea
                                                            </p>
                                                        </dd>
                                                    </dl>
                                                </div>';
                            }
                            $popupHtml .= '</div>';
                        }
                        $popupHtml .= '</dd>';
                        $popupHtml .= '</dl>';
                        $popupHtml .= '</li>';
                    }
                    $popupHtml .= '</ul>';
                    if ($see_more) {
                        $popupHtml .= '<p class="new_technical_support_more">
                            <a class="alone_a" href="javascript:;"> ' . FS_SEE_MORE . ' </a>
                            <i class="iconfont icon">&#xf087;</i>
                        </p>';
                    }
                    $popupHtml .= '<div class="new_technical_support_upload">
                                <p class="new_technical_support_upload_tit"><em>*</em> '.FS_DIALOG_CONTENT.'</p>
                                <textarea class="account_alone_textarea" id="comments_content" name="comments_content" placeholder="'.FS_ORDERS_SERVICE_O7.'" rows="0" cols="0"></textarea>
                                <p class="error_prompt service_pro_textarea_error">'.FS_PLEASE_ENTER_COMMENTS.'</p>

                                <div class="file_input_container after public_position">
                                    <div class="public_Mask" style="display: none;"></div>
                                    <div class="write_review_from">
                                        <div class="write_review_fromonly">
                                            <div class="write_review_increase_newBtn write_sc">
                                                <span class="wr_newSpan iconfont icon"></span>
                                                <i>'.FS_COMMON_FILE.'</i>
                                                <div id="hidden_input_block" class="file_input_alone">
                                                    <input type="file" class="input_file file_arr" onchange="newPreviewImage(this,1)" id="file1" name="reviews_newImg[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alone_Bubble">
                                        <div class="bubble-popover-wap">
                                            <div class="m-bubble-bg"></div>
                                            <div class="bubble-popover">
                                                <span class="iconfont icon bubble-icon"></span>
                                                <div class="m-bubble-container">
                                                    <div class="bubble-frame left-left-middle">
                                                        <div class="m-bubble-Close-container">
                                                            <span class="iconfont icon m-bubble-Close"></span>
                                                        </div>
                                                        <div class="bubble-arrow"></div>
                                                        <div class="bubble-content">
                                                            <p class="alone_bubble_txt">'.FS_SALES_INFO_ALLOW.'<br>'.FS_UPLOAD_SIZE_DEFAULT_TIP.'</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="type_msg" class="error_prompt" style="display: none"></div>
                                    <div id="review_newImg_show" class="review_newImg_show_newOnly">
                                    </div>
                                </div>
                            </div>
                            <div class="alone_text_align_right">
                                <a class="account_alone_a public_a_secondary" onclick="$(\'#add_order_service\').hide()">'.FS_COMMON_CANCEL.'</a>
                                <a class="account_alone_a technology_a" href="javascript:;" id="submit_service_history">
                                    <span>'.FS_COMMON_SUBMIT.'</span>
                                    <div id="loader_order_alone" class="loader_order" style="display: none;">
                                        <svg class="circular" viewBox="25 25 50 50">
                                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                        </svg>
                                    </div>
                                </a>
                            </div>';
                    $result = [
                        'orderNumber' => $popupOrderNumber,
                        'popupHtml' => $popupHtml
                    ];
                    $api->setMessage('success')->setStatus(200)->response($result);
                } else {
                    $api->setMessage('error')->setStatus(403)->response();
                }
            } else {
                $api->setMessage('error')->setStatus(403)->response();
            }
        }
        break;
    case 'merger_order':
        // 当前订单触发的订单id
        $orders_id = (int)zen_db_prepare_input($_POST['orders_id']);
        // 当前订单主id
        $split_main_id = (int)zen_db_prepare_input($_POST['split_main_id']);
        if ($split_main_id) {
            $orderService = new OrderService();
            $mergeData = $orderService->getSplitMerge($orders_id, ['orders_id', 'orders_number', 'type']);
            if ($mergeData) {
                foreach ($mergeData as $k=> $v) {
                    $mergeData[$k]['orders_number'] = explode('-', $v['orders_number'])[0];
                    if ($orders_id == $v['orders_id']){
                        $mergeData[$k]['orders_link'] = 'javascript:void(0);';
                    } else {
                        $oId = $v['orders_id'];
                        if ($v['type'] == 1) {
                            $orderService->setField('main_order_id')->setOrder($v['orders_id']);
                            if (!empty($orderService->currentOrder)) {
                                $ordersInfo = $orderService->currentOrder->toArray();
                                if (!in_array($ordersInfo['main_order_id'],[0,1])){
                                    $oId = $ordersInfo['main_order_id'];
                                }
                            }
                            $mergeData[$k]['orders_link'] = zen_href_link('account_history_info', 'orders_id=' . $oId);
                        } else {
                            $orderSplitService = new OrderSplitService();
                            $orderSplitService->setField('split_main_id')->setOrder($v['orders_id']);
                            if (!empty($orderSplitService->currentOrder)) {
                                $ordersInfo = $orderSplitService->currentOrder->toArray();
                                if (!in_array($ordersInfo['split_main_id'],[0,1])){
                                    $oId = $ordersInfo['split_main_id'];
                                }
                            }
                            $mergeData[$k]['orders_link'] = zen_href_link('account_offline_history_info', 'orders_id=' . $oId);
                        }
                    }

                }
                $api->setMessage('success')->setStatus(200)->response($mergeData);
            } else {
                $api->setMessage('error')->setStatus(403)->response();
            }
        } else {
            $api->setMessage('error')->setStatus(403)->response();
        }
        break;
    case 'merge_order_info':    //获取合发单信息
        // 当前订单id
        $orders_id = (int)zen_db_prepare_input($_POST['orders_id']);
        //当前订单类型 1是线上单 2是线下单
        $type = (int)zen_db_prepare_input($_POST['type']);
        if($orders_id && $type){
            $orderService = new OrderService();
            $mergeData = $orderService->getSplitMerge($orders_id, ['orders_id', 'orders_number', 'type'], $type);
            if($mergeData){
                foreach ($mergeData as $k=> $v) {
                    $mergeData[$k]['orders_number'] = explode('-', $v['orders_number'])[0];
                    if ($orders_id == $v['orders_id']){
                        $mergeData[$k]['orders_link'] = 'javascript:void(0);';
                    } else {
                        $oId = $v['orders_id'];
                        if ($v['type'] == 1) {
                            $orderService->setField('main_order_id')->setOrder($v['orders_id']);
                            if (!empty($orderService->currentOrder)) {
                                $ordersInfo = $orderService->currentOrder->toArray();
                                if (!in_array($ordersInfo['main_order_id'],[0,1])){
                                    $oId = $ordersInfo['main_order_id'];
                                }
                            }
                            $mergeData[$k]['orders_link'] = zen_href_link('account_history_info', 'orders_id=' . $oId);
                        } else {
                            $orderSplitService = new OrderSplitService();
                            $orderSplitService->setField('split_main_id')->setOrder($v['orders_id']);
                            if (!empty($orderSplitService->currentOrder)) {
                                $ordersInfo = $orderSplitService->currentOrder->toArray();
                                if (!in_array($ordersInfo['split_main_id'],[0,1])){
                                    $oId = $ordersInfo['split_main_id'];
                                }
                            }
                            $mergeData[$k]['orders_link'] = zen_href_link('account_offline_history_info', 'orders_id=' . $oId);
                        }
                    }

                }
                $api->setMessage('success')->setStatus(200)->response($mergeData);
            } else {
                $api->setMessage('error')->setStatus(403)->response();
            }
        }else {
            $api->setMessage('error')->setStatus(403)->response();
        }
        break;
}