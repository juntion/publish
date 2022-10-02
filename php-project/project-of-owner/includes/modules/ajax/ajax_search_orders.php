<?php

use App\Models\CountryTimeZone;
use App\Services\Orders\OrderService;
use App\Services\OrderSplit\OrderSplitService;
use App\Services\OrderSplit\OrderSplitProductService;
use App\Services\Common\ApiResponse;

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require($language_page_directory . 'views/manage_orders.php'); // 调用公共的语言包
require($language_page_directory . 'views/service_view_order_online.php'); // 调用公共的语言包

$api = new ApiResponse();
$action = $_GET['ajax_request_action'];

if ($action == 'search_order') {

    /**
     * 线上订单、线下订单
     * 线上单是两位年份+月份+日期+6位随机数字
     * 线下单是4位年份+月份+日期+4位随机数字
     * 所以截取参照线下单的月份做判断，月份不可能超过20,避免既要查线上单也要查线下单
     */
    $orders_number = zen_db_prepare_input($_POST['orders_number']);
    $orders_email = zen_db_prepare_input($_POST['orders_email']);
    $orders_id = '';
    $orders_split_id = '';
    $products_instock_id = '';
    $orders_real_email = '';
    $timezone = new CountryTimeZone();
    $orderService = new OrderSplitService();
    $orderProductService = new OrderSplitProductService();
    //判断该单为线下单还是线上单
    if (substr($orders_number, 4, 2) >= 20) {//线下单
        $is_offline_orders = true;
        $is_intransit = true;//该单是否已同步到前台
        $orders_split_info = fs_get_data_from_db_fields_array(['orders_id', 'split_main_id', 'customers_email_address'], 'orders_split', 'orders_number ="' . $orders_number . '" AND split_main_id IN (0,1)');
        $orders_split_id = $orders_split_info[0][0];
        $split_main_id = $orders_split_info[0][1];
        $orders_real_email = $orders_split_info[0][2];
        if (empty($orders_split_id)) {
            $is_intransit = false;
            $products_instock = $orderService->getProductsInstockMain($orders_number);
            if (empty($products_instock)) {
                $is_offline_orders = false;
            } else {
                $products_instock_id = $products_instock['products_instock_id'];
                $products_instock_time = $products_instock['sales_update_time'];
            }
        }
    } else {//线上单
        $orderOnline = new OrderService();
        $orders_obj = $orderOnline->setField(['customers_email_address'])
            ->setOrder(0, $orders_number)->currentOrder;
        if (!empty($orders_obj)) {
            $orders_arr = $orders_obj->toArray();
            $orders_id = $orders_arr['orders_id'];
            $orders_real_email = $orders_arr['customers_email_address'];
            $orders_split_arr = $orderOnline->getSplitMain($orders_id);
            if (!empty($orders_split_arr)) {//线上单是否拆单
                $is_online_split = true;
                $is_intransit = true;
            } else {
                $is_online_split = false;
                $is_intransit = false;
            }
            $orders_split_id = $orderService->getSplitMainOId($orders_split_arr[0]);
        }
    }

    if ($orders_id && !$is_online_split) {//线上单且未拆单
        $action = 'search_order_online';
    } elseif ($is_offline_orders || $is_online_split) {//线下单或线上已拆单
        $action = 'search_order_offline';
    } else {
        $api->setStatus(404)->setMessage(FS_NO_RESULT)->response();
    }

    if($orders_real_email !== $orders_email){
        $api->setStatus(401)->setMessage(FS_TRACKING_SEARCH_NO_MATCH)->response();
    }

}

switch ($action) {
    case"search_order_online"://线上单且未拆单
        //查询该订单的运单信息
        $tracking_arr = $trackingArr = $instock_arr = array();
        $tracking_sql = "select order_tracking_id,shipping_method,tracking_number,delivery_time,products_instock_id from order_tracking_info where orders_id=" . $orders_id . "	order by order_tracking_id";
        $tracking = $db->Execute($tracking_sql);
        if ($tracking->RecordCount()) {
            while (!$tracking->EOF) {
                $instock_arr[$tracking->fields['order_tracking_id']] = $tracking->fields['products_instock_id'];
                $trackingArr[$tracking->fields['order_tracking_id']] = array(
                    'order_tracking_id' => $tracking->fields['order_tracking_id'],
                    'shipping_method' => $tracking->fields['shipping_method'],
                    'tracking_number' => $tracking->fields['tracking_number'],
                    'delivery_time' => $tracking->fields['delivery_time'],
                    'products_instock_id' => $tracking->fields['products_instock_id']
                );
                $tracking->MoveNext();
            }
        }
        if (sizeof($instock_arr)) {
            //去除重复订单信息
            $instock_arr = array_unique($instock_arr);
            $keys = array_keys($trackingArr);
            foreach ($instock_arr as $k => $v) {
                if (in_array($k, $keys)) {
                    $tracking_arr[] = $trackingArr[$k];
                }
            }
        }

        $mianOrder = zen_get_order_info_by_order_id($orders_id);
        // 订单所对应的颜色
        $status_color = get_order_state_color_str($mianOrder['orders_status_id']);

        //flow
        $transFlag = false;
        if (in_array($mianOrder['is_reissue'], array(2, 8, 20, 18, 10))) {
            $transFlag = true;
        }
        if (in_array($mianOrder['is_reissue'], array(14, 15)) && strtotime($mianOrder['date_purchased']) > 1588867200) {
            //2020年5月8日之后的数据转运
            $transFlag = true;
        }
        $country_code_new = fs_get_data_from_db_fields('countries_iso_code_2', 'countries', 'countries_id = "' . $mianOrder['delivery_country_id'] . '"', 'limit 1');
        $deliverHtml = '';
        if (in_array($mianOrder['orders_status_id'], array(7, 8))) {
            $deliveryQuery = $db->Execute("SELECT max(delivery_date) as delivery_time FROM orders_products WHERE orders_id=" . $orders_id . " and delivery_date!='0000-00-00' limit 1");
            $delivery_time = $deliveryQuery->fields['delivery_time'];
            if ($delivery_time) {
                $deliverHtml = zen_show_local_time($delivery_time, $country_code_new, 'default2', 'Asia/Shanghai');
                $deliverHtml = $_SESSION['languages_code'] == 'jp' ? $deliverHtml . FS_INFO_EST : FS_INFO_EST . $deliverHtml;
            }
        } else {
            $deliverStatus = 10;
            if ($transFlag) $deliverStatus = 13;
            $time = zen_get_order_history_status($orders_id, $deliverStatus);
            // $deliverHtml = zen_get_country_stand_time($orders_id, $deliverStatus, $country_code_new,'default2');
            $deliverHtml = zen_show_local_time($time, $country_code_new, 'default2', 'Asia/Shanghai');
        }
        //获取订单所有状态信息
        $statusArray = zen_get_order_all_status($orders_id);
        $statusID = array();
        $statusQuery = $db->Execute("SELECT orders_status_id FROM orders_status_history WHERE orders_id=" . $orders_id);
        while (!$statusQuery->EOF) {
            $statusID[] = $statusQuery->fields['orders_status_id'];
            $statusQuery->MoveNext();
        }
        $oldFlag = false;
        if (($mianOrder['orders_status_id'] == 3 || in_array(3, $statusID)) && !in_array(11, $statusID)) {
            $oldFlag = true;
        }
        $html_flow_text = get_order_flow_html($mianOrder, $oldFlag, $transFlag, $country_code_new, $deliverHtml, $statusID);

        $html_flow = '<div class="alone_left_top new_alone_padding new_alone_margin_bottom products_schedule_details ">
				<h2 class="details_schedule ">
					<span class="new_Point ' . $status_color . ' setalis_point order_sta_color_' . $orders_id . '"></span> <span class="order_sta_' . $orders_id . '">' . $mianOrder['orders_status_name'] . '</span>
				</h2>
				' . $html_flow_text . '
				</div>';

        $li = '';
        if (!$oldFlag) {
            foreach ($statusArray as $status_key => $status) {
                $status_time = $status['date_added'];
                $process_flow_tip_time = zen_show_local_time($status_time, $country_code_new, 'default2', 'Asia/Shanghai');
                $process_flow_tip_time = str_replace_once('<br/>', '', $process_flow_tip_time);
                $process_flow_tip_info = '';
                $before_other_info = '';
                $after_other_info = '';
                switch ($status['id']) {
                    case 1:
                        //pending
                        $process_flow_tip_info = FS_INFO_MSG_PENDING;
                        break;
                    case 2:
                        //Payment Received
                        if ($mianOrder['payment_module_code'] == 'purchase') {
                            $process_flow_tip_info = FS_INFO_PUR_MSG_PEYMENT;
                        } else {
                            $process_flow_tip_info = FS_INFO_MSG_PEYMENT;
                        }
                        break;
                    case 8:
                        //Po Received
                        $process_flow_tip_info = FS_INFO_MSG_PO;
                        break;
                    case 10:
                        //Order Picking 清点
                        $process_flow_tip_info = FS_INFO_MSG_PICKING;
                        break;
                    case 11:
                        //Order Packed 打包
                        if ($tracking_arr[0]) {
                            $delivery_time = $tracking_arr[0]['delivery_time'];
                            $delivery_time = zen_show_local_time($delivery_time, $country_code_new, 'default2', 'Asia/Shanghai');
                            $delivery_time = str_replace_once('<br/>', '', $delivery_time);

                            $before_other_info = '<li>
										<span class="details_Point"><em></em></span>
										<div class="details_schedule_left">' . $delivery_time . '</div>
										<p class="details_schedule_right new_alone_padding_left">' . FS_INFO_MSG_CREATED . '</p></li>';
                        }
                        $process_flow_tip_info = FS_INFO_MSG_PACKED;
                        break;
                    case 12:
                        //In Transit 运输
                        $tracking_info = fs_order_shipping_info_kuaidi100_handle($tracking_arr[0]['shipping_method'], $tracking_arr[0]['tracking_number']);
                        if ($tracking_info) {
                            $before_other_info = $tracking_info;
                        }
                        $process_flow_tip_info = FS_INFO_MSG_TRANSIT;

                        if ($tracking_arr[0]) {
                            $after_other_info = '<li>
											<span class="details_Point"><em></em></span>
											<div class="details_schedule_left"></div>
											<p class="details_schedule_right new_alone_padding_left">' . FIBERSTORE_SHIPPING_METHOD . ': ' . $tracking_arr[0]['shipping_method'] . '<br/>' . FS_TRACKING_NUMBER . ': ' . $tracking_arr[0]['tracking_number'] . '</p></li>';
                        }
                        break;
                    case 13:
                        //Back Ordering
                        $process_flow_tip_info = FS_INFO_MSG_BACK;
                        break;
                    case 14:
                        //Transferred 已转运
                        $process_flow_tip_info = sprintf(FS_INFO_MSG_TRANSFERRED, $ware);
                        break;
                    case 15:
                        //Received 转运海外仓的包裹收货
                        $process_flow_tip_info = sprintf(FS_INFO_MSG_RECEIVED, $ware);
                        break;
                    case 4:
                        //completed
                        if ($mianOrder['payment_module_code'] == 'purchase') {
                            $process_flow_tip_info = FS_INFO_PUR_MSG_COMPLETED;
                        } else {
                            $process_flow_tip_info = FS_INFO_MSG_COMPLETED;
                        }
                        break;
                    case 5:
                        //Invoice Comfirmed
                        $process_flow_tip_info = FS_ORDERS_TRACK_CANCELED;
                        break;
                    case 16:
                        //Invoice Comfirmed
                        $process_flow_tip_info = FS_INFO_MSG_COMFIRMED;
                        break;
                    case 17:
                        //pending reviewed
                        $process_flow_tip_info = FIBERSTORE_STATUS_PAYMENT_PENDING_REVIEW_MESSAGE;
                        break;
                }
                if ($before_other_info) {
                    $li .= $before_other_info;
                }
                if ($process_flow_tip_info) {
                    $li .= '<li data="new">
							<span class="details_Point"><em></em></span>
							<div class="details_schedule_left">' . $process_flow_tip_time . '</div>
							<p class="details_schedule_right new_alone_padding_left">' . $process_flow_tip_info . '</p>
							</li>';
                }
                if ($after_other_info) {
                    $li .= $after_other_info;
                }
            }
        } else {
            if ($tracking_arr) {
                $tracking_info = $tracking_arr[0];
                $method = $tracking_info['shipping_method'];
                $num = $tracking_info['tracking_number'];
                $productsInstockId = $tracking_info['products_instock_id'];
                switch ($method) {
                    case 'Fedex':
                    case 'FEDEX IP':
                    case 'FEDEX IE':
                        $shipping_com = FS_METHOD . ': <a target="_blank" style="color:#a10000;" href="https://www.fedex.com/fedextrack/">Fedex</a>&nbsp;&nbsp;&nbsp;<br>' . SALES_DETAILS_TRACKING . ':  ' . $num . ' ';
                        break;
                    case 'DHL':
                        $shipping_com = FS_METHOD . ': <a target="_blank" style="color:#a10000;" href="http://www.dhl.com/en/express/tracking.html">DHL</a>&nbsp;&nbsp;&nbsp;' . SALES_DETAILS_TRACKING . ':  ' . $num . ' ';
                        break;
                    case 'AIRMAIL':
                        $shipping_com = FS_METHOD . ': <a target="_blank" style="color:#a10000;" href="http://app3.hongkongpost.com/CGI/mt/enquiry.jsp">AIRMAIL</a>&nbsp;&nbsp;&nbsp;' . SALES_DETAILS_TRACKING . ': ' . $num . ' ';
                        break;
                    case 'EMS':
                        $shipping_com = FS_METHOD . ': <a target="_blank" style="color:#a10000;" href="http://www.ems.com.cn/english.html">EMS</a>&nbsp;&nbsp;&nbsp;' . SALES_DETAILS_TRACKING . ': ' . $num . ' ';
                        break;
                    case 'USPS':
                    case 'UPS':
                        $shipping_com = FS_METHOD . ': <a target="_blank" style="color:#a10000;" href="https://www.usps.com/">USPS</a>&nbsp;&nbsp;&nbsp;' . SALES_DETAILS_TRACKING . ': ' . $num . ' ';
                        break;
                    case 'TNT':
                        $shipping_com = FS_METHOD . ': <a target="_blank" style="color:#a10000;" href="http://www.tnt.com/express/en_ca/site/home.html">TNT</a>&nbsp;&nbsp;&nbsp;' . SALES_DETAILS_TRACKING . ': ' . $num . ' ';
                        break;
                }
            }
            $li = '';
            foreach ($statusArray as $status) {
                $shipping_comments = '';
                if ($status['id'] == 3) {
                    $shipping_comments = $shipping_com;
                }
                $refundHtml = '';    //退款申请提示语
                switch ($status['id']) {
                    case 1:
                        $pro_info = MY_ORDER_SUCCESSFULLY;
                        break;
                    case 2:
                        $pro_info = MY_ORDER_WAIT;
                        break;
                    case 4:
                        if ($refund_num) {
                            $pro_info = FS_REFUND_FAIL_MSG;
                        } else {
                            $pro_info = $status['orders_status_name'] . ' ' . FIBERSTORE_BY_SYSTEM . '.';
                        }
                        break;
                    case 6:
                        $pro_info = FS_REFUND_SUCCESS_MSG;
                        break;
                    case 7:
                        $pro_info = $status['orders_status_name'] . ' ' . FIBERSTORE_BY_SYSTEM . '.';
                        if ($refund_num) {
                            $refundHtml = '<li>
									<span class="details_Point"><em></em></span>
									<div class="details_schedule_left">' . get_order_flow_time_show(strtotime($refund_arr['refund_date'])) . '</div>
									<p class="details_schedule_right new_alone_padding_left">' . FS_REFUND_APPMSG . '<br/>' . FIBERSTORE_FS_COM . '</li>';
                        }
                        break;
                    default:
                        $pro_info = $status['orders_status_name'] . ' ' . FIBERSTORE_BY_SYSTEM . '.';
                        break;
                }
                //运单信息
                if ($status['id'] == 3) {
                    $tracking_info = fs_order_shipping_info_kuaidi100_handle($method, $num);
                    if ($tracking_info) {
                        $li .= $tracking_info;
                    }
                }
                $li .= $refundHtml;
                $li .= ' <li data="old">
									<span class="details_Point"><em></em></span>
									<div class="details_schedule_left">' . get_order_flow_time_show(strtotime($status['date_added'])) . '</div>
									<p class="details_schedule_right new_alone_padding_left">' . ($shipping_comments ? $shipping_comments : $pro_info) . '</p>
								</li>';
            }
        }

        $html_order_track = '<div class="details_shipment new_alone_margin_bottom">
										<div class="details_shipment_right new_alone_padding">
											<h2 class="details_shipment_tit ">' . FS_TRACKING_HISTORY . '</h2>
											<div class="details_ul_wap query_ul_wap">
												<ul class="details_ul ">
													' . $li . '
												</ul>
											</div>
										</div>
									</div>';

        $return_data = array(
            'flow' => $html_flow,
            'order_track' => $html_order_track,
            'is_offline' => 0,
            'orders_id' => $orders_id
        );
        $api->setStatus(200)->response($return_data);
        break;
    case"search_order_offline":// 线下单或线上单拆单
        //状态提示语
        $process_flow_tip_info = [
            1 => FS_ORDERS_TRACK_PENDING,
            2 => FS_ORDERS_TRACK_PAYMENT,
            8 => FS_ORDERS_TRACK_PO,
            10 => FS_ORDERS_TRACK_PICKING,
            11 => FS_ORDERS_TRACK_PACKED,
            13 => FS_ORDERS_TRACK_BACK,
            4 => FS_ORDERS_TRACK_COMPLETED,
            5 => FS_ORDERS_TRACK_CANCELED,
            16 => FS_INFO_MSG_COMFIRMED,
            17 => FS_ORDERS_TRACK_PENDING_REVIEW
        ];
        $orders_status_arr = $orderService->getOrdersStatusProcessText();

        if ($is_intransit) {
            //线下单已同步到前台
            $all_orders_id = fs_get_data_from_db_fields_array(['orders_id'], 'orders_split', 'split_main_id ="' . $orders_split_id . '"');
            $all_orders_id = array_column($all_orders_id, 0);
            $is_complete = $orderProductService->getSplitCompleteStatus($orders_split_id, $all_orders_id);

            $flow_html = '';
            $all_orders_num = $is_complete ? count($all_orders_id) : count($all_orders_id) + 1;
            foreach ($all_orders_id as $k => $orders_id) {

                $cross_flow = '';
                $vertical_flow = '';
                $single_key = $k + 1;
                $orderData = $orderService->getOrdersTrackPackageInfo($orders_id);
                $status_color = $orderData['status_class'];
                $orders_status_his = $orderData['orders_status_history'];
                $orders_num_percent = $single_key . '/' . $all_orders_num;
                // 订单当前的状态
                $orders_now_status = $orders_status_arr[$orderData['orders_status']];

                //获取流程轴节点
                $flow_point_num = $orderData['payment_module_code'] == 'purchase' ? 7 : 6;
                $cross_flow_point = get_order_split_track_flow_html($orderData, 2);
                //横轴HTML结构
                $cross_flow = get_order_split_cross_flow_html($cross_flow_point, $orders_num_percent, $status_color, $orders_now_status, $flow_point_num);

                //竖轴
                $vertical_point = '';
                $track_info = $orderData['orders_track_info'][0]['shipping_method'] . '-' . $orderData['orders_track_info'][0]['tracking_number'];
                //状态提示语
                $process_flow_tip_info[12] = sprintf(FS_ORDERS_TRACK_LABEL, $track_info);
                $process_flow_tip_info[14] = sprintf(FS_ORDERS_TRACK_TRANSFERRED, $warehouse);
                $process_flow_tip_info[15] = sprintf(FS_ORDERS_TRACK_RECEIVED, $warehouse);
                $orders_status_his = array_reverse($orders_status_his);
                foreach ($orders_status_his as $os_v) {
                    $time = get_order_country_stand_time($os_v['date_added'], $orderData['delivery_country_code'], $orderData['delivery_country_zone'], 'default2');
                    $tips = $process_flow_tip_info[$os_v['id']];
                    $vertical_point .= '<li data="new">';
                    $vertical_point .= '    <span class="details_Point"><em></em></span>';
                    $vertical_point .= '    <div class="details_schedule_left">' . $time . '</div>';
                    $vertical_point .= '    <p class="details_schedule_right new_alone_padding_left">' . $tips . '</p>';
                    $vertical_point .= '</li>';
                }
                //竖轴HTML结构
                $vertical_flow = get_order_split_vertical_flow_html($vertical_point);

                //html结构汇总
                $flow_html .= $cross_flow . $vertical_flow;
            }

            if (!$is_complete) {
                $orderCountryCode = $orderData['delivery_country_code'];
                $orderCountryZone = $orderData['delivery_country_zone'];
                $sub_time = $orderData['orders_status_history']['1']['date_added'];
                $pay_time = $orderData['orders_status_history']['1']['date_added'];
                $flow_html .= getOfflineFixedShaft(
                    $sub_time,
                    $pay_time,
                    $orderCountryCode,
                    $orderCountryZone,
                    $orders_status_arr,
                    $process_flow_tip_info,
                    $all_orders_num
                );
            }

        } else {

            //线下单未同步到前台
            $orderCountryId = fs_get_data_from_db_fields('entry_country_id', 'products_instock_shipping_OrderAddress', 'products_instock_id ="' . $products_instock_id . '"');
            $orderCountryCode = fs_get_country_code_of_id($orderCountryId);
            //查找delivery_country国家对应时区
            $orderCountryZone = $timezone->where('code', $orderCountryCode)
                ->pluck('time_zone');
            //构造线下单未发货的虚拟数据
            $flow_html .= getOfflineFixedShaft(
                $products_instock_time,
                '',
                $orderCountryCode,
                $orderCountryZone,
                $orders_status_arr,
                $process_flow_tip_info
            );
        }

        $return_data = array(
            'flow' => $flow_html,
            'order_track' => '',
            'is_offline' => 1,
            'orders_id' => $orders_split_id
        );
        $api->setStatus(200)->response($return_data);

        break;
}