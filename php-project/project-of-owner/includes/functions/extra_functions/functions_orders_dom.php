<?php
/**
 * 账户中心订单相关 buy more再次加购产品层级定制产品 或者 关闭产品 弹窗结构 2019.11.14 ery
 * @param $products 该参数是OrderProductService中getOrderProductsInfo()获取的数组元素
 * @param string $type, 值支持两种 custom：定制产品/close：关闭产品/clearance:清仓产品库存不足/clearance_no:清仓产品无库存
 * @return string
 */
function custom_close_product_tip_html($products, $type='custom'){
    $html = '';
    if(sizeof($products)){
        //提示语
        $title_message = FS_MANAGE_CUSTOM_TIP;
        $link_title = FS_PRODUCT_OFF_TEXT_3;
        $close_tip_html = '';   //关闭产品的气泡提示语
        if($type=='close'){
            $title_message = FS_MANAGE_CLOSE_TIP;
            $link_title = FS_SHOP_CART_SIMILAR;
            $close_tip_html = '<div class="public_white_bg"></div>
                            <div class="defective-product"><div class="bubble-popover-wap">
                                <div class="bubble-popover">
                                    <span class="iconfont icon bubble-icon"></span>
                                    <div class="bubble-frame left-left-middle">
                                        <div class="bubble-arrow"></div>
                                        <div class="bubble-content">
                                            <p>'.FS_PRODUCT_OFF_TEXT.'</p>
                                        </div>
                                    </div>
                                </div>
                            </div></div>';
        }elseif($type=='clearance'){
            if (isset($products[0]['products_clearance_tip']) && $products[0]['products_clearance_tip']) {
                $title_message = $products[0]['products_clearance_tip'];
            } else {
                $title_message = FS_PRODUCT_CLEARANCE_TEXT_1;
            }
        }elseif($type=='clearance_no'){
            if (isset($products[0]['products_clearance_tip']) && $products[0]['products_clearance_tip']) {
                $title_message = $products[0]['products_clearance_tip'];
            } else {
                $title_message = FS_PRODUCT_CLEARANCE_TEXT;
            }
        }
        $html .= '<div class="public_Prompt">
					<i class="iconfont icon">&#xf228;</i>
					'.$title_message.'
				</div>';
        foreach($products as $key=>$product){
            $attributeHtml = '';
            if(!empty($product['orders_products_attributes'])){
                foreach($product['orders_products_attributes'] as $ak=>$aval){
                    $attributeHtml .= '<dd>'.$aval['options_name'].' - '.$aval['values_name'].'</dd>';
                }
            }
            if(!empty($product['orders_products_length'])){
                $attributeHtml .= '<dd>'.FS_LENGTH_NAME.' - '.$product['orders_products_length']['length_name'].'</dd>';
            }
            $html .= '<div class="failure_order_container">
					<dl class="failure_order_dl after">
						<dt>
						'.$close_tip_html.'
						<img src="'.$product['image'].'">
						</dt>
						<dd>
							<p class="addCrat_item_list_tit" id="video_array_title">'.$product['products_name'].'</p>
							'.$attributeHtml.'
							<p class="Qty_num02">#'.$product['products_id'].'</p>';
            if($type=='custom' || $type=='close'){
                //清仓产品没有该板块
                $html .= '<p class="clearance-a">
                                <a class="alone_a" href="'.reset_url($product['products_href']).'">'. $link_title.'</a>
                                <i class="iconfont icon">&#xf089;</i>
                            </p>';
            }
            $html .= '</dd>
					</dl>
				</div>';
        }
        $html .='<div class="alone_text_align_right">
					<a class="account_alone_a" href="javscript:;" onclick="hide_buy_more_window();">'.FS_COMMON_CANCEL.'</a>
				</div>';
    }
    return $html;
}


/**
 * 生成订单列表页和详情页产品板块的DOM结构
 * @param $orders
 * @param $page， list代表列表页，details代表详情页
 * @param $is_offline 是否为线下单
 * @return string
 */
function create_order_list_products_html($orders, $page='list', $is_offline = false){
    $html = '';
    if(sizeof($orders['products'])){
        if ($page == 'po_details') {
            $html .= '<div class="Quote_Details_dl_container">';
        } else {
            $html .= '<div class="order_list_dl_container">';
        }
        $see_more = false;  //列表页最多只展示3个产品
        //循环展示订单产品
        foreach($orders['products'] as $pKey=>$products){
            //订单列表页最多只展示3个产品
            if($page=='list'){
                if($pKey>2){
                    $see_more = true;
                    break;
                }
            }
            $close_tip = $close_class = $close_bg = '';
            //失效产品气泡提示
            if($products['is_close']){
                $close_tip = '<div class="defective-product">
                                    <div class="bubble-popover-wap m_account_bubble">
                                        <div class="m-bubble-bg"></div>
                                        <div class="bubble-popover">
                                            <span class="iconfont icon bubble-icon"></span>
                                            <div class="m-bubble-container">
                                                <div class="bubble-frame left-top">
                                                    <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;" onclick="$(\'.m_account_bubble .m-bubble-bg,.m_account_bubble .m-bubble-container,.m_account_bubble .m-bubble-containerm-bubble-container\').hide()" >
                                                        <i class="iconfont icon">&#xf092;</i>
                                                    </a>
                                                    <div class="bubble-arrow"></div>
                                                    <div class="bubble-content">
                                                        <p>'.FS_PRODUCT_OFF_TEXT.'</p>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                $close_class = ' class="public_position"';
                $close_bg = '<div class="public_white_bg"></div>';
            }
            $attrHtml = '';     //属性板块
            if($products['is_custom']){
                $attrHtml .= '<div class="order_Custom_container">';
                $attrHtml .= '<dl class="order_Custom_dl">';
                $attrNum = 0;
                if(sizeof($products['orders_products_attributes'])){
                    foreach($products['orders_products_attributes'] as $akey=>$attr){
                        $attrNum++;
                        if($page=='list' && $attrNum>1){
                            $attrHtml .= '<dd>'.$attr['options_name'].': '.$attr['values_name'].'</dd>';
                        }else{
                            $attrHtml .= '<dt>'.$attr['options_name'].': '.$attr['values_name'].'</dt>';
                        }
                    }
                }
                //长度属性
                if(!empty($products['orders_products_length'])){
                    $attrNum++;
                    if($page=='list' && $attrNum>1){
                        $attrHtml .= '<dd>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dd>';
                    }else{
                        $attrHtml .= '<dt>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dt>';
                    }
                }
                $attrHtml .= '</dl>';
                //多个属性是有More板块
                if($page=='list' && $attrNum>1){
                    $attrHtml .= '<p class="order_Custom_a_container">
                        <a class="alone_a" href="javascript:;"><span>'.FS_MANAGE_ORDERS_MORE.'</span><i class="iconfont icon"></i></a>
                        
                    </p>';
                }
                $attrHtml .= '</div>';
            }
            $bottom_class = '';
            //组合产品子产品板块 在详情页展示
            $sonProductHtml = '';
            if(in_array($page,array('details','po_details')) && !empty($products['son_products_info'])){
                $sonProductHtml .= '<div class="Combination_container">
                        <dl class="Combination_dl">
                            <dt class="Combination_dl_dt active">
                                '.FS_ITEM_INCLUDES_PRODUCTS.' <i class="iconfont icon"></i>
                            </dt>';
                foreach($products['son_products_info'] as $son_product){
//                    $son_products_name = zen_get_products_name($son_product['products_id']);
                    $sonProductHtml .= '<dd class="Combination_dd">
                                <img src="'.$son_product['image'].'">
                                <div class="Combination_a_container">
                                  <p class="composite_product"> '.$son_product['products_name'].'</p>
                                  <p class="Combination_price">'.$son_product['qty'];
                    if(!in_array($products['products_id'],[108704,108706])){
                        $sonProductHtml .= ' x '.$son_product['products_price_str'].FS_PRODUCT_PRICE_EA;
                    }
                    $sonProductHtml .= '</p></div>
                            </dd>';
                }
                $sonProductHtml .= '</dl></div>';
                $bottom_class = ' not-border-bottom';
            }
            if ($page == 'po_details') {
                $html .= '<dl class="fs_account_order_dl">';
            } else {
                $html .= '<dl class="order_list_dl'.$bottom_class.' after">';
            }
            //左边图片板块
            $html .= '<dt '.$close_class.'>'.$close_bg.$close_tip.'<a href="'.reset_url($products['products_href']).'">
                            <img src="'.$products['image'].'">
                            </a></dt>';
            //右边产品标题板块
            $html .= '<dd>';
            $html .= '<a class="alone_a order_list_dl_tit" href="'.reset_url($products['products_href']).'">'.$products['products_name'].'</a>
                '.$attrHtml.'';
            //价格板块 详情页有
            if($page!='list'){
                $html .= '<div class="Standard_Return_price_container"><span class="Standard_Return_price">'.$products['products_quantity'].'&nbsp;&nbsp;x&nbsp;&nbsp;<span>'.$products['final_price_currency'].'</span>';
                $html .= '</div>';
            }
            $html .= '<p class="fs_account_order_pn">FS P/N: '.$products['products_model'].' <span>#'.$products['products_id'].'</span></p>';
            //$html .='<p class="order_list_qty">'.FS_MANAGE_QTY.': '.$products['products_quantity'].'</p>';
            // MUX产品
            if ($products['is_mux'] && $orders['orders_status'] !== 1) {
                $arr = [
                    2 => [FS_ORDER_CUSTOMIZED, '', $orders['history'][2]['date_added'] ? local_date_time(strtotime($orders['history'][2]['date_added'])) : ''],
                    7 => [FS_ORDER_MANUFACTURING, '', $orders['history'][7]['date_added'] ? local_date_time(strtotime($orders['history'][7]['date_added'])) : ''],
                    11 => [FS_ORDER_TEST_PASS, '', $orders['history'][11]['date_added'] ? local_date_time(strtotime($orders['history'][11]['date_added'])) : ''],
                    12 => [FS_ORDER_SHIPPED, '', $orders['history'][12]['date_added'] ? local_date_time(strtotime($orders['history'][12]['date_added'])) : ''],
                ];
                // PO上传点亮第一个节点
                if ($orders['history'][8]) $arr[2] = [FS_ORDER_CUSTOMIZED, '', $orders['history'][8]['date_added'] ? local_date_time(strtotime($orders['history'][8]['date_added'])) : ''];
                if ($arr[12][2]) {
                    $arr[12][1] = 'active';
                } elseif ($arr[11][2]) {
                    $arr[11][1] = 'active';
                } elseif ($arr[7][2]) {
                    $arr[7][1] = 'active';
                } elseif ($arr[2][2]) {
                    $arr[2][1] = 'active';
                }
                $html .= '<div class="mux_container">
						<ul class="mux_ul after">';
                foreach ($arr as $key => $val) {
                $html .= '<li class="'.$val[1].'">
								<span class="mux_point">
									<div class="mux_con">
										<div class="mux_top">'.$val[0].'</div>
										<div class="mux_bottom">'.$val[2].'</div>
									</div>
								</span>
							</li>';
                }
                $html .= '</ul>';
                if ($orders['file_path'][$products['products_id']] && in_array($orders['orders_status'], [11, 12])) {
				$html .=	'<div class="mux_download">
								<span class="after">
								<i class="iconfont icon">&#xf349;</i>
								<a href="javascript:;" onclick="download_zip('.$orders['orders_id'].', ' . $products['products_id'] . ')">'.FS_ORDER_TEST_REPORT.'</a>
								</span>
							</div>';
                }
				$html .= '</div>';
            }
            //详情页展示评论入口
            /*if($page != 'po_details' && !$is_offline){
                $html .= '<div class="Standard_Return_container">
                            <a class="Standard_Return" href="JavaScript:;" onclick="buy_more(\''.$orders['orders_id'].'\', \''.$products['orders_products_id'].'\',\''.$orders['orders_number'].'\', 1, this)"><span>'.FS_BUY_MORE_01.'</span>
                            </a>
                        </div>';
            }*/

            if(in_array($page,array('details','po_details')) && $products['review_allow']){
                $html .= '<a href="'.zen_href_link('orders_review', 'orders_id='.$orders['orders_id'].'&orders_products_id='.$products['orders_products_id']).'" class="account_alone_a a_height">
                            <span>'.MANAGE_ORDER_WRITE.'</span>
                        </a>';
            } elseif($products['is_reviewed']) {
                $html .= '<a href="'.zen_href_link('view_reviews').'" class="account_alone_a a_height">
                            <span>'.FS_ACCOUNT_VIEW_REVIEWS.'</span>
                        </a>';
            }

            $html .= '</dd>';
            $html .= '</dl>'.$sonProductHtml;
        }
        $html .= '</div>';

        if($see_more){
            $html .= '<div class="order_history_more after">
            <a class="alone_a" href="'.zen_href_link('account_history_info','&orders_id='.$orders['orders_id'],'SSL').'">
            '.FS_SEE_MORE.'</a></div>';
        }
    }else{
        //没有订单产品是补款链接
        $html = '<div class="order_payment_container">
                    <p class="order_payment">'.PAYMENT_LINK_FOR.' <a class="alone_a" href="'.($orders['payment_link_data']['origin_orders_id'] ? zen_href_link('account_history_info', 'orders_id='.$orders['payment_link_data']['origin_orders_id']) : 'javascript:;').'">'.$orders['payment_link_data']['order_num'].'</a></p>
                    <p class="order_remark">'.FS_ORDER_LINK_REMARK.':</p>	
                    <p class="order_test">'.$orders['payment_link_data']['reamrk'].'</p>
                </div>';
    }
    return $html;
}

/**
 * 获取订单 不同状态下的操作按钮
 * 列表页只有在pending[1]状态 有po订单的upload file，其他订单的PayNow操作按钮
 * 详情页 pending[1]状态下有 PayNow、cancel order，以及Delivered[4]状态下有Return/Replace
 * @param $order
 * @param string $page, 列表页是list,详情页是details
 * @param bool $returnFlag, 是否允许申请退换货
 * @return string
 */
function get_order_status_button_new($order, $page = 'list', $returnFlag = false){
    /*
     * orders_id,orders_status_id,main_order_id，payment_module_code,is_reviewd,products
     */
    $orders_id = $order['orders_id'];
    $actionHtml = '';

    //新加坡上门安装服务 暂时取消
    $sgInstallHtml = '';
    /*if($page=='details'){
        //订单详情页要求pending状态下展示所有分单数据 所以这里需要对子单循环判断处理
        foreach($order['son_orders'] as $son){
            if($son['sg_install_info']['is_sg_install'] && !$son['sg_install_info']['sg_install_selected']){
                $sgInstallHtml .= '<a href="javascript:void(0)" class="account_alone_a" onclick="showInstallForm('.$son['orders_id'].',this); " data-disable="1">'.FS_ORDER_HISTORY_INSTALL.'</a>';
            }
        }
    }*/
    //详情页 pending状态下的操作按钮顺序是 cancel、install、PayNow
    switch($order['orders_status']) {
        case 1://pending 状态
            if($page=='details'){
                $actionHtml .= '<a href="javascript:void(0)" class="account_alone_a a_height public_a_secondary" onclick="showCancelWindow('.$orders_id.')">'.FS_CANCEL.'</a>';
            }
            $actionHtml .= $sgInstallHtml;
            if($order['payment_module_code']=='purchase' || $order['payment_module_code']=='alfa'){
                //po订单和俄罗斯对公支付 不需要paynow按钮
                $actionHtml .= '';
            }else if($order['payment_module_code']=='echeck'){
                //echeck支付方式 后台审核通过后不需要给PayNow按钮
                $echeck_result = fs_get_data_from_db_fields('id', 'fs_electrical_check_apply', 'orders_id ='.$orders_id.'', 'limit 1');
                if($echeck_result){
                    $actionHtml .= "";
                }else{
                    $actionHtml .= '<a class="account_alone_a a_border_red a_height"  href="javascript:void(0)" onclick="justPayNow('.$orders_id.')">'.MANAGE_ORDER_PAY.'</a>';
                }
            }else{
                $actionHtml .= '<a class="account_alone_a a_border_red a_height"  href="javascript:void(0)" onclick="justPayNow('.$orders_id.')">'.MANAGE_ORDER_PAY.'</a>';
            }
            break;
        case 12: //In Transit
            if($page=='details'){
                $actionHtml .= '<span class="account_alone_a a_height received_account">
                                    '.F_RECEIPT_CONFIRMATION.'
									<div class="removed_window_container" style="display: none;">
	                                    <div class="removed_bg"></div>
	                                    <div class="removed_window">
	                                        <div class="bubble-arrow"></div>
	                                        <p class="removed_window_tit">'.MANAGE_ORDER_ARE.'</p>
	                                        <div class="removed_window_a_container">
	                                            <button class="account_alone_a a_height" href="javascript:;">'.FS_COMMON_CANCEL.'</button>
	                                            <button class="account_alone_a a_height new_handle_one_hide" href="javascript:;" onclick="confirm_recepit('.$orders_id.')">'.FS_CONFIRM.'</button>
	                                        </div>
	                                    </div>
	                                </div>
									</span>';
            }
            break;
        case 4://完成状态 退换货入口
            if($page=='details' && $returnFlag){
                $actionHtml .= '<a href="'.zen_href_link('sales_service_info', '&orders_id='.$orders_id).'" class="account_alone_a a_height" onclick="">'.MANAGE_ORDER_RETURN.'</a>';
            }
            break;
    }
    return $actionHtml;
}

//订单列表页和详情页获取 订单倒计时展示
function get_order_show_end_time_html($order, $page='list'){
    $html = '';
    if($order['orders_status']==1){
        if($order['payment_module_code']=='purchase' || $order['payment_module_code']=='alfa'){
            //订单倒计时
            $html = get_show_end_time_str($order['orders_id'],$order['payment_module_code'],$page);
        }else if($order['payment_module_code']!='echeck'){
            //订单倒计时
            $html .= get_show_end_time_str($order['orders_id'],$order['payment_module_code'],$page);
        }
    }
    return $html;
}

/**
 * 生成订单详情页的shipping address和billing address板块的HTML
 * @param $orders
 * @param $po_pay,po账户的额度，po展示对应额度
 * @return array
 */
function create_orders_details_shipping_billing_html($orders, $po_pay=''){
    $deliveryInstruction = '';//运输说明板块
    if (!empty($orders['order_fields'])) {
        $html = '';
        if ($orders['order_fields']['delivery_ticket_number'] && $orders['order_fields']['other_delivery']) {
            $html .= $orders['order_fields']['delivery_ticket_number'];
            $html .= ', ';
            $html .= $orders['order_fields']['other_delivery'];

        } elseif (!$orders['order_fields']['delivery_ticket_number'] && $orders['order_fields']['other_delivery']) {
            $html .= $orders['order_fields']['other_delivery'];
        } else {
            $html .= $orders['order_fields']['delivery_ticket_number'];
        }

        if (!empty($html)) {
            $deliveryInstruction = '<dd class="more-content-box">';
            $deliveryInstruction .= '<span>'. FS_DELIVERY_INSTRUCTIONS .': ' . $html . '</span>';
            $deliveryInstruction .= '<div class="more-content-childFilter" style="display: block;"></div>';
            $deliveryInstruction .= '</dd>';
            $deliveryInstruction .= '<p class="leave_a_message_more"><a href="javascript:;">'.FS_READ_MORE.'</a><i class="iconfont icon"></i></p>';
        }
    }
    $shippingHtml = $billingHtml = '';
    $sgInstallHtml = '';    //展示上门安装信息

    foreach($orders['son_orders'] as $key=>$value) {
        if($value['sg_install_info']['sg_install_selected']){
            $sgInstalled = $value['sg_install_info']['sg_install_data'];
            //改上门安装服务申请没有取消就展示上门安装信息
            if ($sgInstalled['status']!=5) {
                $sgInstallHtml .= '<dd>' . FS_SG_CALENDAR_114 . ': ';
                require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
                $sgInstalledTime = SGInstallerServiceClass::sgInstallTimeTrans($sgInstalled['appointment_start_time']);
                $sgInstallHtml .= $sgInstalledTime;
                if (zen_not_null($sgInstalled['customer_remark'])) {
                    if (zen_not_null($sgInstalled['customer_remark_file'])) {
                        $file = zen_get_img_change_src(DIR_WS_IMAGES . $sgInstalled['customer_remark_file']);
                    } else {
                        $file = "";
                    }
                    $sgInstallHtml .= '<a href="javascript:;" class="new_alone_a" onclick="showSgInstallDetail(
                                                        \'' . $sgInstalled['appointment_second_type'] . '\',
                                                        \'' . $sgInstalledTime . '\',
                                                        \'' . $sgInstalled['customer_remark'] . '\',
                                                        \'' . $file . '\',
                                                        )">' . MANAGE_ORDER_SEE . '</a>';
                }
                $sgInstallHtml .= '</dd>';
            }
        }
    }

    $d_company = $orders['delivery_company'] ? '<dd>'.$orders['delivery_company'].'</dd>' : '';
    $b_company = $orders['billing_company'] ? '<dd>'.$orders['billing_company'].'</dd>' : '';
    if (strlen($orders['delivery_company']) > 50) {
        $d_company = '<dd title="'.$orders['delivery_company'].'">'.mb_substr($orders['delivery_company'], 0, 50, 'utf-8').'...</dd>';
    }
    if (strlen($orders['billing_company']) > 50) {
        $b_company = '<dd title="'.$orders['billing_company'].'">'.mb_substr($orders['billing_company'], 0, 50, 'utf-8').'...</dd>';
    }
    if($_GET['main_page']=="account_offline_history_info"){
        $deliveryNum = 0;
        if ($orders['orders_split_products']) {
            $deliveryNum = $deliveryNum + 1;
        }
        $deliveryNum = count($orders['son_orders']) + $deliveryNum;
        if($deliveryNum > 1){
            //线下单详情 如果delivery条数超过1 则运输方式为默认
            $shipping_method_str = FS_OFFINE_TRANSACTION_2;
        }else{
            $shipping_method_str = $orders['shipping_method_str'];
            //运输方式表达
            if (!empty($orders['shipping_local_method_code']) && !empty($orders['shipping_delay_method_code'])) {
                $shipping_method_str = zen_get_order_shipping_method_by_code($orders['shipping_local_method_code']) . ' & ' . zen_get_order_shipping_method_by_code($orders['shipping_delay_method_code']);
            }else{
                $shipping_method_str = !empty($orders['shipping_local_method_code']) ?zen_get_order_shipping_method_by_code($orders['shipping_local_method_code']) : zen_get_order_shipping_method_by_code($orders['shipping_delay_method_code']);
            }
        }
        $shippingHtml .= '<dl class="Order_Detail_middle_dl">
							<dt>'.$orders['delivery_name'].' '.$orders['delivery_lastname'].'</dt>
							'.$d_company.'
							<dd>'.$orders['delivery_street_address'].($orders['delivery_suburb'] ? ', '.$orders['delivery_suburb'] : '').', '.$orders['delivery_city'].', '.$orders['delivery_postcode'].','.($orders['delivery_state'] ? $orders['delivery_state'].'</br> ':'').$orders['delivery_country'].'</dd>
							<dd>'.$orders['d_tel_prefix'].' '.$orders['delivery_telephone'].'</dd>
							'.($orders['delivery_tax_number'] ? '<dd>'.$orders['delivery_tax_number'].'</dd>':'').'
							<dd>'.FIBERSTORE_SHIPPING_METHOD.': '.$shipping_method_str.'</dd>
							'.$sgInstallHtml.'
						</dl>';
    }else{
        $shippingHtml .= '<dl class="Order_Detail_middle_dl">
							<dt>'.$orders['delivery_name'].' '.$orders['delivery_lastname'].'</dt>
							'.$d_company.'
							<dd>'.$orders['delivery_street_address'].($orders['delivery_suburb'] ? ', '.$orders['delivery_suburb'] : '').', '.$orders['delivery_city'].', '.$orders['delivery_postcode'].', '.($orders['delivery_state'] ? $orders['delivery_state'].', ':'').$orders['delivery_country'].'</dd>
							<dd>'.$orders['d_tel_prefix'].' '.$orders['delivery_telephone'].'</dd>
							'.($orders['delivery_tax_number'] ? '<dd>'.$orders['delivery_tax_number'].'</dd>':'').'
							<dd>'.FIBERSTORE_SHIPPING_METHOD.': '.$orders['shipping_method_str'].'</dd>
							'.$deliveryInstruction.'
							'.$sgInstallHtml.'
						</dl>';
    }

    if($_GET['main_page']=="account_offline_history_info") {
        $payment_str = FS_OFFINE_TRANSACTION;
        if($orders['payment_module_code']=='purchase'){
            $payment_str = $po_pay;
        } elseif ($orders['payment_module_code'] == 'hsbc') {
            $payment_str = $orders['payment_module_code_str'] ? $orders['payment_module_code_str'] : '--';
            $payment_str .= '<a href="javascript:;" class="alone_a" onclick="$(\'#fs_popup_hsbc\').show();">'.MANAGE_ORDER_SEE.'</a>';
        } else {
            if ($orders['is_offline'] == 0) {
                $payment_str = $orders['payment_module_code_str'] ? $orders['payment_module_code_str'] : '--';
            }
            if ($orders['process_type'] == 4) {
                $payment_str = '--';
            }
        }
        $billingHtml .= '<dl class="Order_Detail_middle_dl">
							<dt>' . $orders['billing_name'] . ' ' . $orders['billing_lastname'] . '</dt>
							' . $b_company . '
							<dd>' . $orders['billing_street_address'] . ($orders['billing_suburb'] ? ', ' . $orders['billing_suburb'] : '') .', '.($orders['billing_city'] ? $orders['billing_city'] . ', ' : '') . $orders['billing_postcode']. ', '.($orders['billing_state'] ? $orders['billing_state'] . '</br>' : '') . $orders['billing_country'].'</dd>
							<dd>' . $orders['b_tel_prefix'] . ' ' . $orders['billing_telephone'] . '</dd>
							' . ($orders['billing_tax_number'] ? '<dd>' . $orders['billing_tax_number'] . '</dd>' : '') . '
							<dd>' . MANAGE_ORDER_PAYMENT . ': ' . $payment_str . '</dd>
						</dl>';
    }else{
        $payment_str = $orders['payment_module_code_str'];
        if($orders['payment_module_code']=='purchase' && $po_pay){
            $payment_str = $po_pay;
        }
        if ($orders['payment_module_code'] == 'hsbc'){
            $payment_str .= '<a href="javascript:;" class="alone_a" onclick="$(\'#fs_popup_hsbc\').show();">'.MANAGE_ORDER_SEE.'</a>';
        }
        $billingHtml .= '<dl class="Order_Detail_middle_dl">
							<dt>' . $orders['billing_name'] . ' ' . $orders['billing_lastname'] . '</dt>
							' . $b_company . '
							<dd>' . $orders['billing_street_address'] . ($orders['billing_suburb'] ? ', ' . $orders['billing_suburb'] : '') .', '.($orders['billing_city'] ? $orders['billing_city'] . ', ' : '') . $orders['billing_postcode'] .', '. ($orders['billing_state'] ? $orders['billing_state'] . ', ' : '') . $orders['billing_country'] . '</dd>
							<dd>' . $orders['b_tel_prefix'] . ' ' . $orders['billing_telephone'] . '</dd>
							' . ($orders['billing_tax_number'] ? '<dd>' . $orders['billing_tax_number'] . '</dd>' : '') . '
							<dd>' . MANAGE_ORDER_PAYMENT . ': ' . $payment_str . '</dd>
						</dl>';
    }
    $data = array('shippingHtml'=>$shippingHtml, 'billingHtml'=>$billingHtml);
    return $data;
}

/**
 * @param $orders
 * @param string $page,值为list：列表页、details：详情页，track：物流详情页
 * @param int $main_orders_id 主单号
 * @return string
 */
function create_order_tracking_html($orders, $page = 'list', $main_orders_id = 0){
    $html = $merge_html = '';
    if($orders['orders_status']==12 || $orders['orders_status']==4){
        if (in_array($page, ['list','details'])) {
            if (count($orders['merge_arr']) > 0) {
                $merge_html = '<span class="removal_delivery_txt removal_delivery_txt_'. $orders['orders_id'] .'" onclick="show_method_merge('.$orders['orders_id'].', '.$main_orders_id.')"><i class="iconfont icon">&#xf385;</i> '. FS_OFFLINE_POPUP .' </span>';
            }
        }
        if($orders['sg_install_info']['sg_install_selected'] && $orders['sg_install_info']['sg_install_data']['case_numbers']['status']!=5){
            //选择了新加坡上门安装服务
            $html = '<p class="order_list_middle_Tracking">'.FS_SG_DELIVERY_INSTALLATION.$merge_html.'</p>';
        }else{
            if(!empty($orders['orders_track_info'])){
                $track_href = zen_href_link('track_package', 'from='.$page.'&orders_id=' . $orders['orders_id']);
                if($page=='list') {
                    //列表页只展示一条订单号
                    $shipping_method = get_short_shippind_method($orders['orders_track_info'][0]['shipping_method']);
                    $html = '<p class="order_list_middle_Tracking">' . FS_ORDERS_TRACKING . ': 
                        <a class="alone_a" href="' .$track_href. '">' . $shipping_method . '-' . $orders['orders_track_info'][0]['tracking_number'] . '</a>'
                        .$merge_html.
                '</p>';
                }else{
                    $new_track_info = [];
                    //对运单号重新处理，同类型的放一起
                    foreach($orders['orders_track_info'] as $info){
                        $shipping_method = get_short_shippind_method($info['shipping_method']);
                        $new_track_info[$shipping_method][] = $info['tracking_number'];
                    }//var_dump($new_track_info);exit;
                    $number_str = '';
                    foreach($new_track_info as $key=>$value){
                        $number_str .= $key.' - '.implode('; ',$value).'; ';
                    }
                    $number_str = trim($number_str);
                    $number_str = trim($number_str, ';');
                    if($page=='details'){
                        $html = '<p class="order_list_middle_Tracking">' . FS_ORDERS_TRACKING . ': 
                            <a class="alone_a" href="' .$track_href. '">' .$number_str. '</a>
                            '.$merge_html.'
                    </p>';
                    }else{
                        //物流详情页不给A链接
                        $html = FS_ORDERS_TRACKING.': '.$number_str;
                    }
                }
            }
        }
    }
    return $html;
}

/**
 * 订单详情页 不同订单状态的提示语
 * @param $status
 * @param int $is_reissue
 * @return string
 */
function get_orders_details_status_message($status, $is_reissue = 1){
    switch($status){
        case 1://pending
            $message = FS_ORDER_HISTORY_SUBMIT;
            break;
        case 2://Payment Received
            $message = FS_ORDER_HISTORY_PAYMENT;
            break;
        case 8://PO Received
            $message = FS_ORDER_HISTORY_PO;
            break;
        case 7://processing
            $message = FS_ORDER_HISTORY_PROCESSING;
            break;
        case 10://Order Picking
            $message = FS_ORDER_HISTORY_PICK;
            break;
        case 11://Order Packed
            $message = FS_ORDER_HISTORY_PACK;
            break;
        case 12://In Transit
            $message = FS_ORDER_HISTORY_TRANSIT;
            break;
        case 13://Back Ordering
            $warehouse = FS_MANAGE_WAREHOUSE_US;
            if(in_array($is_reissue, [6, 7, 8, 19, 20])){
                $warehouse = FS_MANAGE_WAREHOUSE_EU;
            }elseif(in_array($is_reissue, [9, 10, 11, 17, 18])){
                $warehouse = FS_MANAGE_WAREHOUSE_AU;
            } elseif ($_SESSION['languages_code'] == 'ru' && in_array($is_reissue, [4])) {
                $warehouse = 'RU.';
            }
            $message = sprintf(FS_ORDER_HISTORY_BACK, $warehouse);
            break;
        case 4://Delivered completed
            $message = FS_ORDER_HISTORY_DELIVERED;
            break;
        case 5://cancel
            $message = FS_ORDER_HISTORY_CANCEL;
            break;
        case 17:  //pending review
            $message = FS_ORDER_HISTORY_PENDING_REVIEW;
            break;
    }
    return $message;
}

/**
 * track package页面的流程轴 2019.11.20
 * @param $orders
 * @return string
 */
function get_order_track_flow_html($orders){
    $oldFlag = false;   //旧版流程轴
    $all_status = array_keys($orders['orders_status_history']);
    if(($orders['orders_status']==3 || in_array(3,$all_status)) && !in_array(11,$all_status)){
        $oldFlag = true;
    }
    $transFlag = false; //转运单
    if(in_array($orders['is_reissue'], [2,8,10,13,16,18,20])){
        $transFlag = true;
    }
    $country_code_new = $orders['delivery_country_code'];
    $country_timezone = $orders['delivery_country_zone'];
    $oID = $orders['orders_id'];
    $statusArray = $orders['orders_status_history'];
    $flow_str = '';
    if(!$oldFlag){//新版流程轴
        $flow_str .= '<div class="track_schedule">
			    <ul class="schedule">';
        if(!in_array($orders['payment_module_code'],array("purchase","rechnung"))){
            //Order Submitted[1] 节点
            $time = get_order_country_stand_time($statusArray[1]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status']==1 ? true:false);
            $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_SUBMITTED, 'schedule_start active', $statusFlag);
            if('5' == $orders['orders_status']){//取消订单流程轴
                $time = get_order_country_stand_time($statusArray[5]['date_added'], $country_code_new, $country_timezone, 'default2');
                $flow_str .= get_order_flow_one_new($time, CANCELED, "schedule_end active", true);
            }else{
                // Pending Review[17]节点 如果为echck付款需要财务审核
                if ($orders['payment_module_code'] == "echeck") {
                    $active_str = in_array($orders['orders_status'],array(2,10,11,12,13,4,6,7,17)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[17]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==17 ? true:false);
                    $flow_str .= get_order_flow_one_new($time,FIBERSTORE_STATUS_PAYMENT_PENDING_REVIEW, $active_str, $statusFlag);
                }

                //Payment Received[2] 节点
                $active_str = in_array($orders['orders_status'],array(2,10,11,12,13,4,6,7)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[2]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status']==2 ? true:false);
                $flow_str .= get_order_flow_one_new($time,FIBERSTORE_STATUS_PAYMENT_RECEIVED, $active_str, $statusFlag);

                //Back Ordering[13] 节点 转运单 或者 Order Picking[10] 节点 直发单
                if($transFlag){ //转运
                    $active_str = in_array($orders['orders_status'],array(13,11,12,4)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[13]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==13 ? true:false);
                    $flow_str .= get_order_flow_one_new($time, FS_INFO_BACK_ORDERING, $active_str, $statusFlag);
                }else{
                    $active_str = in_array($orders['orders_status'],array(10,11,12,4)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[10]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==10 ? true:false);
                    $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_PICKING, $active_str, $statusFlag);
                }

                //Order Packed[11] 节点
                $active_str = in_array($orders['orders_status'],array(11,12,4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[11]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status']==11 ? true:false);
                $flow_str .= get_order_flow_one_new($time,FS_INFO_ORDER_PACKED, $active_str, $statusFlag);

                //In Transit[12] 节点
                $active_str = in_array($orders['orders_status'],array(12,4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[12]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status']==12 ? true:false);
                $flow_str .= get_order_flow_one_new($time,FS_INFO_IN_TRANSIT, $active_str, $statusFlag);

                //completed[4] 节点
                $active_str = in_array($orders['orders_status'],array(4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[4]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status']==4 ? true:false);
                $flow_str .= get_order_flow_one_new($time,FS_INFO_DELIVER_COMPLETE,"schedule_end".$active_str, $statusFlag);
            }
        }else{
            //Order Submitted[1] 节点
            $time = get_order_country_stand_time($statusArray[1]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status']==1 ? true:false);
            $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_SUBMITTED, 'schedule_start active', $statusFlag);
            if('5' == $orders['orders_status']){//取消订单流程轴
                $time = get_order_country_stand_time($statusArray[5]['date_added'], $country_code_new, $country_timezone, 'default2');
                $flow_str .= get_order_flow_one_new($time, CANCELED, "schedule_end active", true);
            }else{
                //PO Received[8] po订单节点 或者 Invoice Comfirmed[16] rechnung订单节点
                if($orders['payment_module_code']=='purchase'){
                    $active_str = in_array($orders['orders_status'],array(7,8,13,10,11,12,2,4)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[8]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==8 ? true:false);
                    $flow_str .= get_order_flow_one_new($time,FS_INFO_PO_RECEIVED, $active_str, $statusFlag);
                }else{
                    $active_str = in_array($orders['orders_status'],array(7,16,13,10,11,12,2,4)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[16]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==16 ? true:false);
                    $flow_str .= get_order_flow_one_new($time,FS_INFO_INVOICE_COMFIRMED, $active_str, $statusFlag);
                }

                //Back Ordering[13] 节点 转运单 或者 Order Picking[10] 节点 直发单
                if($transFlag){
                    $active_str = in_array($orders['orders_status'],array(13,11,12,4,2)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[13]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==13 ? true:false);
                    $flow_str .= get_order_flow_one_new($time, FS_INFO_BACK_ORDERING, $active_str, $statusFlag);
                }else{
                    $active_str = in_array($orders['orders_status'],array(10,11,12,4,2)) ? " active" : '';
                    $time = get_order_country_stand_time($statusArray[10]['date_added'], $country_code_new, $country_timezone, 'default2');
                    $statusFlag = ($orders['orders_status']==10 ? true:false);
                    $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_PICKING, $active_str, $statusFlag);
                }

                //Order Packed[11] 节点
                $active_str = in_array($orders['orders_status'],array(11,12,4,2)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[11]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status']==11 ? true:false);
                $flow_str .= get_order_flow_one_new($time,FS_INFO_ORDER_PACKED, $active_str, $statusFlag);

                //In Transit[12] 节点
                $active_str = in_array($orders['orders_status'],array(12,4,2)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[12]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = $orders['orders_status']==12 ? true:false;
                $flow_str .= get_order_flow_one_new($time,FS_INFO_IN_TRANSIT, $active_str, $statusFlag);

                //completed[4] 节点
                $active_str = in_array($orders['orders_status'],array(4,2)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[4]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = $orders['orders_status']==4 ? true:false;
                $flow_str .= get_order_flow_one_new($time, FS_INFO_DELIVER_COMPLETE, $active_str, $statusFlag);

                //Payment Received[2] 节点
                $active_str = in_array(2, $all_status) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[4]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = in_array(2, $all_status) ? true:false;
                $flow_str .= get_order_flow_one_new($time,FIBERSTORE_STATUS_PAYMENT_RECEIVED,"schedule_end".$active_str, $statusFlag);

            }
        }
        $flow_str .= '</ul></div>';
    }else{//旧版流程轴
        $flow_str .= '<div class="track_schedule">
			    <ul class="schedule">';
        if($orders['payment_module_code'] != 'purchase'){
            //Order Received[1] 节点
            $statusFlag = ($orders['orders_status']==1 ? true:false);
            $flow_str .= get_order_flow_one_new($statusArray[1]['date_added'],FIBERSTORE_STATUS_ORDER_RECIVED, "schedule_start active", $statusFlag);

            if('5' == $orders['orders_status']){//取消订单流程轴
                $flow_str .= get_order_flow_one($statusArray[5]['date_added'], CANCELED, "schedule_end active withB45", true);
            }else{
                //Payment Received[2] 节点
                $active_str = in_array($orders['orders_status'],array(2,3,4,6,7)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==2 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[2]['date_added'], FIBERSTORE_STATUS_PAYMENT_RECEIVED, $active_str, $statusFlag);

                //Commodity Processing[7] 节点
                $active_str = in_array($orders['orders_status'],array(3,4,6,7)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==7 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[7]['date_added'], MANAGE_ORDER_COMMODITY, $active_str, $statusFlag);

                //Shipped Out[3]
                $active_str = in_array($orders['orders_status'],array(3,4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==3 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[3]['date_added'],FIBERSTORE_SHIPPED_OUT, $active_str, $statusFlag);

                //completed[4]
                $active_str = in_array($orders['orders_status'],array(4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==4 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[4]['date_added'],FIBERSTORE_STATUS_DELIVERY, 'schedule_end'.$active_str, $statusFlag);
            }
        }else{
            //Order Received[1] 节点
            $statusFlag = ($orders['orders_status']==1 ? true:false);
            $flow_str .= get_order_flow_one_new($statusArray[1]['date_added'],FIBERSTORE_STATUS_ORDER_RECIVED, "schedule_start active", $statusFlag);

            if('5' == $orders['orders_status']){//取消订单流程轴
                $flow_str .= get_order_flow_one($statusArray[5]['date_added'], CANCELED, "schedule_end active withB45", true);
            }else{
                $active_str = in_array($orders['orders_status'],array(7,8,3,9,2,4)) ? " active" : '';
                $flow_str .= get_order_flow_one_new( zen_get_order_history_status($oID,8),FIBERSTORE_STATUS_PO_COMFIRMED, $active_str );

                //Commodity Processing[7] 节点
                $active_str = in_array($orders['orders_status'],array(7,3,9,2,4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==7 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[7]['date_added'],MANAGE_ORDER_COMMODITY, $active_str, $statusFlag);

                //Shipped Out[3]
                $active_str = in_array($orders['orders_status'],array(3,9,2,4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==3 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[3]['date_added'],FIBERSTORE_SHIPPED_OUT,$active_str,$statusFlag);

                //delivered[9]
                $active_str = in_array($orders['orders_status'],array(9,2,4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==9 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[2]['date_added'],FIBERSTORE_STATUS_DELIVERED,$active_str,$statusFlag);

                //Payment Received[2] 节点
                $active_str = in_array($orders['orders_status'],array(2,4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==2 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[2]['date_added'],FIBERSTORE_STATUS_PAYMENT_RECEIVED,$active_str, $statusFlag);

                //completed[4]
                $active_str.= in_array($orders['orders_status'],array(4)) ? " active" : '';
                $statusFlag = ($orders['orders_status']==4 ? true:false);
                $flow_str .= get_order_flow_one_new($statusArray[4]['date_added'],FIBERSTORE_STATUS_DELIVERY,'schedule_end'.$active_str, $statusFlag);
            }
        } //旧版流程轴end
        $flow_str .= '</ul></div>';
    }
    return $flow_str;
}

/**
 * track package页面的线下单流程轴 2020.08.07
 * @param $orders
 * @param $is_dom 1 为订单流程轴页面, 2 为track info 单页面
 * @return string
 */
function get_order_split_track_flow_html($orders, $is_dom = 1)
{
    $all_status = array_keys($orders['orders_status_history']);
    //流程轴类型
    $process_type = $orders['process_type'];
    $transFlag = false; //转运单
    if (in_array($orders['is_reissue'], [2, 8, 10, 13, 14, 16, 18, 20])) {
        $transFlag = true;
    }
    $country_code_new = $orders['delivery_country_code'];
    $country_timezone = $orders['delivery_country_zone'];
    $statusArray = $orders['orders_status_history'];
    $flow_str = '';

    if($is_dom == 1) {
        $flow_str .= '<div class="track_schedule">
            <ul class="schedule">';
    }

    //Order Submitted[1] 节点
    $time = get_order_country_stand_time($statusArray[1]['date_added'], $country_code_new, $country_timezone, 'default2');
    $statusFlag = ($orders['orders_status'] == 1 ? true : false);
    $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_SUBMITTED, 'schedule_start active', $statusFlag, $is_dom);

    if('5' == $orders['orders_status']){//取消订单流程轴
        $time = get_order_country_stand_time($statusArray[5]['date_added'], $country_code_new, $country_timezone, 'default2');
        $flow_str .= get_order_flow_one_new($time, CANCELED, "schedule_end active", true, $is_dom);
    }else{
        if($orders['payment_module_code'] == 'purchase' && $process_type == 1){//普通账期订单

            //PO Received[8] po订单节点 或者 Invoice Comfirmed[16] rechnung订单节点
            if ($orders['payment_module_code'] == 'purchase') {
                $active_str = in_array($orders['orders_status'], array(7, 8, 13, 10, 11, 12, 2, 4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[8]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 8 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FS_INFO_PO_RECEIVED, $active_str, $statusFlag, $is_dom);
            } else {
                $active_str = in_array($orders['orders_status'], array(7, 16, 13, 10, 11, 12, 2, 4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[16]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 16 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FS_INFO_INVOICE_COMFIRMED, $active_str, $statusFlag, $is_dom);
            }

            //Back Ordering[13] 节点 转运单 或者 Order Picking[10] 节点 直发单
            if ($transFlag) {
                $active_str = in_array($orders['orders_status'], array(13, 11, 12, 4, 2)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[13]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 13 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FS_INFO_BACK_ORDERING, $active_str, $statusFlag, $is_dom);
            } else {
                $active_str = in_array($orders['orders_status'], array(10, 11, 12, 4, 2)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[10]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 10 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_PICKING, $active_str, $statusFlag, $is_dom);
            }

            //Order Packed[11] 节点
            $active_str = in_array($orders['orders_status'], array(11, 12, 4, 2)) ? " active" : '';
            $time = get_order_country_stand_time($statusArray[11]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status'] == 11 ? true : false);
            $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_PACKED, $active_str, $statusFlag, $is_dom);

            //In Transit[12] 节点
            $active_str = in_array($orders['orders_status'], array(12, 4, 2)) ? " active" : '';
            $time = get_order_country_stand_time($statusArray[12]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = $orders['orders_status'] == 12 ? true : false;
            $flow_str .= get_order_flow_one_new($time, FS_INFO_IN_TRANSIT, $active_str, $statusFlag, $is_dom);

            //completed[4] 节点
            $active_str = in_array($orders['orders_status'], array(4, 2)) ? " active" : '';
            $time = get_order_country_stand_time($statusArray[4]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = $orders['orders_status'] == 4 ? true : false;
            $flow_str .= get_order_flow_one_new($time, FS_INFO_DELIVER_COMPLETE, $active_str, $statusFlag, $is_dom);

            //Payment Received[2] 节点
            $active_str = in_array(2, $all_status) ? " active" : '';
            $time = get_order_country_stand_time($statusArray[4]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = in_array(2, $all_status) ? true : false;
            $flow_str .= get_order_flow_one_new($time, FIBERSTORE_STATUS_PAYMENT_RECEIVED, "schedule_end" . $active_str, $statusFlag, $is_dom);

        }else{

            $active_str = in_array($orders['orders_status'], $all_status) ? " active" : '';
            //Payment Received[2] 节点
            if($process_type == 3){
                $active_str = $orders['orders_status'] == 2 ? "schedule_end active" : 'schedule_end';
            }

            $time = get_order_country_stand_time($statusArray[2]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status'] == 2 ? true : false);
            $payment_str = get_order_flow_one_new($time, FIBERSTORE_STATUS_PAYMENT_RECEIVED, $active_str, $statusFlag, $is_dom);

            // Pending Review[17]节点 如果为echck付款需要财务审核
            if ($orders['payment_module_code'] == "echeck") {
                $active_str = in_array($orders['orders_status'], array(2, 10, 11, 12, 13, 4, 6, 7, 17)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[17]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 17 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FIBERSTORE_STATUS_PAYMENT_PENDING_REVIEW, $active_str, $statusFlag, $is_dom);
            }

            if($process_type == 1) {
                $flow_str .= $payment_str;
            }

            //Back Ordering[13] 节点 转运单 或者 Order Picking[10] 节点 直发单
            if ($transFlag) { //转运
                $active_str = in_array($orders['orders_status'], array(13, 11, 12, 4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[13]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 13 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FS_INFO_BACK_ORDERING, $active_str, $statusFlag, $is_dom);
            } else {
                $active_str = in_array($orders['orders_status'], array(10, 11, 12, 4)) ? " active" : '';
                $time = get_order_country_stand_time($statusArray[10]['date_added'], $country_code_new, $country_timezone, 'default2');
                $statusFlag = ($orders['orders_status'] == 10 ? true : false);
                $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_PICKING, $active_str, $statusFlag, $is_dom);
            }

            //Order Packed[11] 节点
            $active_str = in_array($orders['orders_status'], array(11, 12, 4)) ? " active" : '';
            $time = get_order_country_stand_time($statusArray[11]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status'] == 11 ? true : false);
            $flow_str .= get_order_flow_one_new($time, FS_INFO_ORDER_PACKED, $active_str, $statusFlag, $is_dom);

            if($process_type == 2) {
                $flow_str .= $payment_str;
            }

            //In Transit[12] 节点
            $active_str = in_array($orders['orders_status'], array(12, 4)) ? " active" : '';
            $time = get_order_country_stand_time($statusArray[12]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status'] == 12 ? true : false);
            $flow_str .= get_order_flow_one_new($time, FS_INFO_IN_TRANSIT, $active_str, $statusFlag, $is_dom);

            //completed[4] 节点
            $active_str = in_array($orders['orders_status'], array(4)) ? " active" : '';
            if($process_type != 3){
                $active_str = "schedule_end" . $active_str;
            }
            $time = get_order_country_stand_time($statusArray[4]['date_added'], $country_code_new, $country_timezone, 'default2');
            $statusFlag = ($orders['orders_status'] == 4 ? true : false);
            $flow_str .= get_order_flow_one_new($time, FS_INFO_DELIVER_COMPLETE, $active_str, $statusFlag, $is_dom);

            if($process_type == 3) {
                $flow_str .= $payment_str;
            }

        }
    }

    if($is_dom == 1) {
        $flow_str .= '</ul></div>';
    }

    return $flow_str;
}

/**
 * @param $cross_flow_point 横轴流程节点
 * @param $orders_num_percent 订单数字分数
 * @param $status_color 状态颜色
 * @param $orders_now_status 当前状态
 * @param $flow_point_num 节点总数
 * @param $isTransit 是否为发货单
 * @return string
 */
function get_order_split_cross_flow_html($cross_flow_point, $orders_num_percent, $status_color, $orders_now_status, $flow_point_num, $isTransit = true)
{
    $cross_flow = '';
    $cross_flow .= '<div>';
    $cross_flow .= '    <div class="alone_left_top new_alone_padding new_alone_margin_bottom products_schedule_details">';
    $cross_flow .= '        <h2 class="details_schedule">';
    if($isTransit){
        $cross_flow .= '            <span class="track_package_delivery">'.MANAGE_ORDER_SHIPMENT.' '.$orders_num_percent.'</span>';
    }
    $cross_flow .= '            <span class="new_Point '.$status_color.' setalis_point order_sta_color"></span>';
    $cross_flow .= '            <span class="order_sta_' . $status_color . '">' . $orders_now_status . '</span>';
    if(!$isTransit){
        $cross_flow .= '        <p class="track_package_prompt">'.FS_OFFINE_TRACK_INFO_1.'</p>';
    }
    $cross_flow .= '        </h2>';
    $cross_flow .= '        <div class="products_schedule products_schedule_deta products_schedule_'.$flow_point_num.'">';
    $cross_flow .= '           <ul class="products_ul products_ul_other">';
    $cross_flow .= $cross_flow_point;
    $cross_flow .= '           </ul">';
    $cross_flow .= '        </div>';
    $cross_flow .= '    </div>';
    $cross_flow .= '</div>';

    return $cross_flow;
}

/**
 * @param $vertical_point 竖轴流程节点
 * @return string
 */
function get_order_split_vertical_flow_html($vertical_point)
{
    $vertical_flow = '';
    $vertical_flow .= '<div>';
    $vertical_flow .= '    <div class="details_shipment new_alone_margin_bottom">';
    $vertical_flow .= '        <div class="details_shipment_right new_alone_padding">';
    $vertical_flow .= '            <h2 class="details_shipment_tit">' . FS_TRACKING_HISTORY . '</h2>';
    $vertical_flow .= '            <div class="details_ul_wap query_ul_wap">';
    $vertical_flow .= '                <ul class="details_ul">';
    $vertical_flow .= '                <ul>';
    $vertical_flow .= $vertical_point;
    $vertical_flow .= '            </div>';
    $vertical_flow .= '        </div>';
    $vertical_flow .= '    </div>';
    $vertical_flow .= '</div>';

    return $vertical_flow;
}

/**
 * 本地化展示订单时间
 * @param $time
 * @param $code
 * @param $codeZone
 * @param string $format
 * @return bool|mixed|string
 */
function get_order_country_stand_time($time, $code, $codeZone, $format='m/d/Y g:i a'){
    if($_SERVER['HTTP_HOST']=='www.fs.com'){
        //线上mysql时区是UTC标准时区
        $timezone = 'Etc/GMT';
    }else{
        //测试站mysql时区是北京时间
        $timezone = 'Asia/Shanghai';
    }
    $local_time = zen_show_local_time($time,'',$format,$timezone,$codeZone);
    if($code=='US' && $local_time){
        //订单详情页节点时间 美国展示华特拉州时间 后面加上EST标识
        $local_time .= ' EST';
    }
    return $local_time;
}

/**
 * @param $time
 * @param $status_str， 节点标题
 * @param $class，当前节点样式
 * @param bool $statusFlag， 当前订单状态是否和该节点状态一致
 * @param int $is_dom 1 为订单流程轴页面, 2 为track info 单页面
 * @return string
 */
function get_order_flow_one_new($time, $status_str, $class, $statusFlag = false ,$is_dom = 1){

    if($is_dom == 1){
        $html = '<li class="'.$class.'">
                <div class="schedule_point">
                    <i class="Hollow"></i>
                    '.($statusFlag ? '<span class="Current"><i class="iconfont icon">&#xf186;</i></span>' : '').'
                    <div class="schedule_time">'.$time.'                
                    </div>
                    <div class="schedule_state">'.$status_str.'</div>
                </div>
            </li>';
    }else{
        $html = '<li class="'.$class.'">
                    <div class="schedule_proint">
                        <i class="Hollow"></i>
                        <div class="current_progress" style="display: block">'.$time.'</div>  
                        <div class="new_details_schedule" style="display: block">'.$status_str.'</div>
                    </div>
                </li>';
    }


    return $html;
}

/**
 * track package 页面运单物流信息结构
 * @param $shipping_method
 * @param $num
 * @return string
 */
function fs_order_track_info_html($shipping_method,$num){
    $html = '';
    $data = fs_order_shipping_info_kuaidi100($shipping_method,$num,false);
    if($data && $data['info_str'] && sizeof($data['info_str'])){
        foreach ($data['info_str'] as $key => $val){
            $time = get_all_languages_date_display($val->time, 'default2');
            $time = str_replace('<br>', ' ', $time);
            $time = str_replace('<br/>', ' ', $time);
            $html .= '<li>
                        <span class="Tracking_li_left">'.$time.'</span>
                        <span class="Tracking_li_right">'.$val->context.'</span>
                     </li>';
        }
    }
    return $html;
}

/**
 *  线下单转线上单列表页面
 * @param $orders
 * @param string $number 线下单分单数
 * @param string $total_number 线下单分单总数
 * @return string
 */
function create_offline_order_tracking_html($orders, $number = '', $total_number = '')
{
    $html = '';
    $page = '';
    if ($orders['orders_status'] == 12 || $orders['orders_status'] == 4) {
        if (!empty($orders['orders_track_info'])) {
            $track_href = zen_href_link('track_package', 'from=' . $page . '&orders_id=' . $orders['orders_id']);
            //列表页只展示一条订单号
            $shipping_method = get_short_shippind_method($orders['orders_track_info'][0]['shipping_method']);
            $html = '<p class="order_list_middle_Tracking">' . FS_ORDERS_TRACKING . ': 
                        <a class="alone_a" href="' . $track_href . '">' . $shipping_method . '-' . $orders['orders_track_info'][0]['tracking_number'] . '</a>
                </p>';
        }
    }
    return $html;
}

/**
 * 生成线下订单列表页和详情页产品板块的DOM结构
 * @param $orders
 * @param $page， list代表列表页，details代表详情页
 * @param $orders array $orders_link
 * @return string
 */
function create_order_offline_list_products_html($ordersProducts, $page='list', $orders_link=[]){
    $html = '';
    if(sizeof($ordersProducts)){
        $html .= '<div class="order_list_dl_container">';
        $see_more = false;  //列表页最多只展示3个产品
        //循环展示订单产品
        foreach($ordersProducts as $pKey=>$products){
            //订单列表页最多只展示3个产品
            if($page=='list'){
                if($pKey>2){
                    $see_more = true;
                    break;
                }
            }
            $close_tip = $close_class = $close_bg = '';
            //失效产品气泡提示
            if($products['is_close']){
                $close_tip = '<div class="defective-product">
                                    <div class="bubble-popover-wap m_account_bubble">
                                        <div class="m-bubble-bg"></div>
                                        <div class="bubble-popover">
                                            <span class="iconfont icon bubble-icon"></span>
                                            <div class="m-bubble-container">
                                                <div class="bubble-frame left-top">
                                                    <div class="m-bubble-Close-container">
                                                        <span class="iconfont icon m-bubble-Close"></span>
                                                    </div>
                                                    <div class="bubble-arrow"></div>
                                                    <div class="bubble-content">
                                                        <p>'.FS_PRODUCT_OFF_TEXT.'</p>
                                                        <div class="new__mdiv_block" onclick="$(\'.m_account_bubble .m-bubble-bg,.m_account_bubble .m-bubble-container,.m_account_bubble .m-bubble-containerm-bubble-container\').hide()">
                                                            <span class="new_m_icon_Close">
                                                               '.FS_MOBILE_CLOSE.'
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                $close_class = ' class="public_position"';
                $close_bg = '<div class="public_white_bg"></div>';
            }
            $attrHtml = '';     //属性板块
            if($products['is_custom']){
                $attrHtml .= '<div class="order_Custom_container">';
                $attrHtml .= '<dl class="order_Custom_dl">';
                $attrNum = 0;
                if(sizeof($products['orders_products_attributes'])){
                    foreach($products['orders_products_attributes'] as $akey=>$attr){
                        $attrNum++;
                        if($page=='list' && $attrNum>1){
                            $attrHtml .= '<dd>'.$attr['options_name'].': '.$attr['values_name'].'</dd>';
                        }else{
                            $attrHtml .= '<dt>'.$attr['options_name'].': '.$attr['values_name'].'</dt>';
                        }
                    }
                }
                //长度属性
                if(!empty($products['orders_products_length'])){
                    $attrNum++;
                    if($page=='list' && $attrNum>1){
                        $attrHtml .= '<dd>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dd>';
                    }else{
                        $attrHtml .= '<dt>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dt>';
                    }
                }
                $attrHtml .= '</dl>';
                //多个属性是有More板块
                if($page=='list' && $attrNum>1){
                    $attrHtml .= '<p class="order_Custom_a_container">
                        <a class="alone_a" href="javascript:;">'.FS_MANAGE_ORDERS_MORE.'</a>
                        <i class="iconfont icon"></i>
                    </p>';
                }
                $attrHtml .= '</div>';
            }
            $bottom_class = '';
            //组合产品子产品板块 在详情页展示
            $sonProductHtml = '';
            if(in_array($page,array('details','po_details')) && !empty($products['son_products_info'])){
                $sonProductHtml .= '<div class="Combination_container">
                        <dl class="Combination_dl">
                            <dt class="Combination_dl_dt active">
                                '.FS_ITEM_INCLUDES_PRODUCTS.' <i class="iconfont icon"></i>
                            </dt>';
                foreach($products['son_products_info'] as $son_product){
//                    $son_products_name = zen_get_products_name($son_product['products_id']);
                    $sonProductHtml .= '<dd class="Combination_dd">
                                <img src="'.$son_product['image'].'">
                                <div class="Combination_a_container">
                                  <p class="composite_product"> '.$son_product['products_name'].'</p>
                                    <p class="Combination_price">'.$son_product['qty'].' x '.$son_product['products_price_str'].'/ea</p>
                                </div>
                            </dd>';
                }
                $sonProductHtml .= '</dl></div>';
                $bottom_class = ' not-border-bottom';
            }
            $html .= '<dl class="order_list_dl'.$bottom_class.' after">';
            //左边图片板块
            $html .= '<dt '.$close_class.'>'.$close_bg.$close_tip.'<a href="'.reset_url($products['products_href']).'">
                            <img src="'.$products['image'].'">
                            </a></dt>';
            //右边产品标题板块
            $html .= '<dd>';
            $html .= '<a class="alone_a order_list_dl_tit" href="'.reset_url($products['products_href']).'">'.$products['products_name'].'</a>
                '.$attrHtml.'';
            //价格板块 详情页有
            if($page!='list'){
                $html .= '<div class="Standard_Return_price_container"><span class="Standard_Return_price">'.$products['products_quantity'].' x <span>'.$products['final_price_currency'].'</span></span>';
                //产品个数大于1的时候才展示单价板块
                /*if($products['products_quantity']>1){
                    $html .= '<span class="Standard_Unit_price">('.$products['final_price_currency'].' '.MANAGE_ORDER_EA.')</span>';
                }*/
                $html .= '</div>';
            }
            $html .= '<p class="fs_account_order_pn">FS P/N: '.$products['products_model'].' (#'.$products['products_id'].')</p>';
            //$html .='<p class="order_list_qty">'.FS_MANAGE_QTY.': '.$products['products_quantity'].'</p>';

            $html .= '</dd>';
            $html .= '</dl>'.$sonProductHtml;
        }
        $html .= '</div>';

        if($see_more && $orders_link){
            $html .= '<div class="order_history_more after">
            <a class="alone_a" href="'.zen_href_link($orders_link['orderSplitLink'],'&orders_id='.$orders_link['orders_id'],'SSL').'">
            '.FS_SEE_MORE.'</a></div>';
        }
    }
    return $html;
}



/**
 * 提前发货状态、提前备货状态
 * @param $productsInstockId int  products_instock_shipping表ID
 * @param $advanceStocking int 先发货状态 默认0
 */
function zen_get_advance_status($productsInstockId, &$advanceStocking = 0)
{
    $status = $advanceStocking = 0;
    $instockArr = array();
    $instockArr[] = $productsInstockId;
    $originId = fs_get_data_from_db_fields("origin_id", "products_instock_shipping", "products_instock_id='{$productsInstockId}'", "");
    if ($originId) {
        $instockArr[] = $originId;
    } else {
        $splitOrder = fs_get_data_from_db_fields("split_order", "products_instock_shipping", "products_instock_id='{$productsInstockId}'", "");
        if ($splitOrder) {
            $instockArr[] = $splitOrder;
        }
    }
    /*是否有审核通过的提前发货申请*/
    $advanceApply = fs_get_data_from_db_fields("id", "products_instock_shipping_apply", "apply_type=1 and is_delete=0 and status=1 and products_instock_id IN (" . join(",", $instockArr) . ")", "");
    /*是否有审核通过的提前备货且提前发货的申请*/
    $advanceDelivery = fs_get_data_from_db_fields("advance_delivery", "products_instock_shipping_apply", "advance_delivery='1' and is_delete=0 and apply_type='5' and status='3' and products_instock_id IN (" . join(",", $instockArr) . ")", "");
    /*是否提前备货*/
    $advanceStockingApply = fs_get_data_from_db_fields("id", "products_instock_shipping_apply", "apply_type='5' and is_delete=0 and status='3' and products_instock_id IN (" . join(",", $instockArr) . ")", "");
    if ($advanceStockingApply) {
        $advanceStocking = 1;
    }
    if ($advanceApply || $advanceDelivery) {
        $status = 1;
    } else {
        $status = 0;
    }
    return $status;
}

function get_finance_str($time,$country_code_new){
    $status_arr['status'] = 2;
    if ($time) {
        $status_arr['time'] = zen_show_local_time($time, $country_code_new, 'default2', '');
        $status_arr['flow_time'] = str_replace_once('<br/>', '', $status_arr['time']);
    }
    return $status_arr;
}

/**
 * $Notes:
 *
 * $author: Quest
 * $Date: 2020/8/21
 * $Time: 15:32
 * @param $products_instock_time
 * @param $orderCountryCode
 * @param $orderCountryZone
 * @param $orders_status_arr
 * @param $process_flow_tip_info
 * @return string
 */
function getOfflineFixedShaft($sub_time, $pay_time, $orderCountryCode, $orderCountryZone,
                              $orders_status_arr, $process_flow_tip_info, $final_num = 0)
{
    //构造线下单未发货的虚拟数据
    $orderData = array(
        'is_reissue' => 1,//随便定义一个非转运的值
        'orders_status' => 2,
        'delivery_country_code' => $orderCountryCode,
        'delivery_country_zone' => $orderCountryZone,
        'payment_module_code' => '',
        'process_type' => 1
    );
    $orders_status_his = array(
        1 => array(
            'id' => 1,
            'date_added' => $sub_time,
            'orders_status_name' => $orders_status_arr[1]
        ),
        2 => array(
            'id' => 2,
            'date_added' => $pay_time,
            'orders_status_name' => $orders_status_arr[2]
        )
    );
    $orderData['orders_status_history'] = $orders_status_his;

    $cross_flow = '';
    $vertical_flow = '';
    // 订单当前的状态
    $isTransit = false;
    $status_color = 'green';
    $orders_num_percent = '1/1';
    $orders_now_status = $orders_status_arr[7];
    if($final_num != 0){
        $orders_num_percent = $final_num . '/' . $final_num;
        $isTransit = true;
    }

    //获取流程轴节点
    $flow_point_num = 6;
    $cross_flow_point = get_order_split_track_flow_html($orderData, 2);
    //横轴HTML结构
    $cross_flow = get_order_split_cross_flow_html($cross_flow_point, $orders_num_percent, $status_color, $orders_now_status, $flow_point_num, $isTransit);

    //竖轴
    $vertical_point = '';
    //状态提示语
    $orders_status_his = array_reverse($orders_status_his);
    foreach ($orders_status_his as $os_v) {
        $time = get_order_country_stand_time($os_v['date_added'], $orderCountryCode,$orderCountryZone,'default2');
        $tips = $process_flow_tip_info[$os_v['id']];
        $vertical_point .= '<li data="new">';
        $vertical_point .= '    <span class="details_Point"><em></em></span>';
        $vertical_point .= '    <div class="details_schedule_left">' . $time . '</div>';
        $vertical_point .= '    <p class="details_schedule_right new_alone_padding_left">' . $tips . '</p>';
        $vertical_point .= '</li>';
    }
    //竖轴HTML结构
    $vertical_flow = get_order_split_vertical_flow_html($vertical_point);

    return $cross_flow.$vertical_flow;
}

function createOrderProductsHtml($orders,$page='list'){
    $html = '';
    if(sizeof($orders['products'])){
        if(isset($orders['split_main_id'])){
            //线下单
            $oId = $orders['orders_id'];
            if(!in_array($orders['split_main_id'],[0,1])) $oId = $orders['split_main_id'];
            $ordersHref = zen_href_link('account_offline_history_info','&orders_id='.$oId,'SSL');
            $isOnline = false;
        }else{
            $ordersHref = zen_href_link('account_history_info','&orders_id='.$orders['orders_id'],'SSL');
            $isOnline = true;
        }
        $see_more = false;
        foreach($orders['products'] as $pKey=>$products){
            //订单列表页最多只展示3个产品
            if($page=='list'){
                if($pKey>2){
                    $see_more = true;
                    break;
                }
            }
            $close_tip = $close_class = $close_bg = '';
            //失效产品气泡提示
            if($products['is_close']){
                $close_tip = '<div class="defective-product">
                                    <div class="bubble-popover-wap m_account_bubble">
                                        <div class="m-bubble-bg"></div>
                                        <div class="bubble-popover">
                                            <span class="iconfont icon bubble-icon"></span>
                                            <div class="m-bubble-container">
                                                <div class="bubble-frame left-top">
                                                    <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;" onclick="$(\'.m_account_bubble .m-bubble-bg,.m_account_bubble .m-bubble-container,.m_account_bubble .m-bubble-containerm-bubble-container\').hide()" >
                                                        <i class="iconfont icon">&#xf092;</i>
                                                    </a>
                                                    <div class="bubble-arrow"></div>
                                                    <div class="bubble-content">
                                                        <p>'.FS_PRODUCT_OFF_TEXT.'</p>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                $close_class = ' class="public_position"';
                $close_bg = '<div class="public_white_bg"></div>';
            }
            //定制产品属性展示板块
            $attrHtml = '';
            if($products['is_custom']){
                $attrHtml .= '<div class="fs_custom_attributes_dl_container">';
                $attrHtml .= '<dl class="fs_custom_attributes_dl">';
                $attrNum = 0;
                if(sizeof($products['orders_products_attributes'])){
                    foreach($products['orders_products_attributes'] as $akey=>$attr){
                        $attrNum++;
                        if($page=='list' && $attrNum>1){
                            $attrHtml .= '<dd>'.$attr['options_name'].': '.$attr['values_name'].'</dd>';
                        }else{
                            $attrHtml .= '<dt>'.$attr['options_name'].': '.$attr['values_name'].'</dt>';
                        }
                    }
                }
                //长度属性
                if(!empty($products['orders_products_length'])){
                    $attrNum++;
                    if($page=='list' && $attrNum>1){
                        $attrHtml .= '<dd>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dd>';
                    }else{
                        $attrHtml .= '<dt>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dt>';
                    }
                }
                $attrHtml .= '</dl>';
                //多个属性是有More板块
                if($page=='list' && $attrNum>1){
                    $attrHtml .= '<div class="fs_custom_attributes_btn fs_public_a">
                                <span data-more="'.FS_MANAGE_ORDERS_MORE.'" data-less="'.FS_COMMON_LESS.'"><em>'.FS_MANAGE_ORDERS_MORE.'</em><i class="iconfont icon">&#xf087;</i>
                                </span>
                            </div>';
                }
                $attrHtml .= '</div>';
            }
            // MUX产品
            $muxHtml = '';
            if ($products['is_mux']) {
                $arr = [
                    2 => [FS_ORDER_CUSTOMIZED, '', $orders['history'][2]['date_added'] ? local_date_time(strtotime($orders['history'][2]['date_added'])) : ''],
                    7 => [FS_ORDER_MANUFACTURING, '', $orders['history'][7]['date_added'] ? local_date_time(strtotime($orders['history'][7]['date_added'])) : ''],
                    11 => [FS_ORDER_TEST_PASS, '', $orders['history'][11]['date_added'] ? local_date_time(strtotime($orders['history'][11]['date_added'])) : ''],
                    12 => [FS_ORDER_SHIPPED, '', $orders['history'][12]['date_added'] ? local_date_time(strtotime($orders['history'][12]['date_added'])) : ''],
                ];
                // PO上传点亮第一个节点
                if ($orders['history'][8]) $arr[2] = [FS_ORDER_CUSTOMIZED, '', $orders['history'][8]['date_added'] ? local_date_time(strtotime($orders['history'][8]['date_added'])) : ''];
                if ($arr[12][2]) {
                    $arr[12][1] = 'active';
                } elseif ($arr[11][2]) {
                    $arr[11][1] = 'active';
                } elseif ($arr[7][2]) {
                    $arr[7][1] = 'active';
                } elseif ($arr[2][2]) {
                    $arr[2][1] = 'active';
                }
                $muxHtml .= '<div class="mux_container">
                    <ul class="mux_ul after">';
                foreach ($arr as $key => $val) {
                    $muxHtml .= '<li class="'.$val[1].'">
                            <span class="mux_point">
                                <div class="mux_con">
                                    <div class="mux_top">'.$val[0].'</div>
                                    <div class="mux_bottom">'.$val[2].'</div>
                                </div>
                            </span>
                        </li>';
                }
                $muxHtml .= '</ul>';
                if ($orders['file_path'][$products['products_id']] && in_array($orders['orders_status'], [11, 12])) {
                    $muxHtml .=	'<div class="mux_download">
                            <span class="after">
                            <i class="iconfont icon">&#xf349;</i>
                            <a href="javascript:;" onclick="download_zip('.$orders['orders_id'].', ' . $products['products_id'] . ')">'.FS_ORDER_TEST_REPORT.'</a>
                            </span>
                        </div>';
                }
                $muxHtml .= '</div>';
            }
            $html .= '<dl class="fs_account_order_dl">
                <dt '.$close_class.'>'.$close_bg.$close_tip.'
                    <a href="'.reset_url($products['products_href']).'"><img src="'.$products['image'].'"></a>                 
                </dt>
                <dd>
                    <h3 class="fs_account_order_tit">
                        <a class="fs_account_a_hidden" href="'.reset_url($products['products_href']).'">'.$products['products_name'].'</a>
                    </h3>
                    '.$attrHtml.'
                    '.$muxHtml.'
                    <p class="fs_account_order_pn">FS P/N: '.$products['products_model'].' <span>#'.$products['products_id'].'</span></p>
                    <p class="fs_account_order_price">'.$products['products_quantity'].'&nbsp;&nbsp;x&nbsp;&nbsp;<span>'.$products['final_price_currency'].'</span></p>
                    '.(($isOnline && $products['review_allow']) ? '<a class="fs_account_btn account_secondary" href="'.zen_href_link('orders_review', 'orders_id='.$orders['orders_id'].'&orders_products_id='.$products['orders_products_id']).'">'.MANAGE_ORDER_WRITE.'</a>':'').
                (($products['is_reviewed']) ? '<a class="fs_account_btn account_secondary" href="'.zen_href_link('view_reviews').'">'.FS_ACCOUNT_VIEW_REVIEWS.'</a>':'') . '
                </dd>
            </dl>';
        }
        if($see_more && $ordersHref){
            $html .= '<div class="fs_account_list_order_number fs_see_more">
                <a href="'.$ordersHref.'">'.FS_SEE_MORE.'</a>
            </div>';
        }
    }else{
        //没有订单产品是补款链接
        $html .= '<div class="fs_account_orderpayment_container">
                    <p class="fs_account_orderpayment_tit">'.PAYMENT_LINK_FOR.' 
                        <span><a class="alone_a" href="'.($orders['payment_link_data']['origin_orders_id'] ? zen_href_link('account_history_info', 'orders_id='.$orders['payment_link_data']['origin_orders_id']) : 'javascript:;').'">'.$orders['payment_link_data']['order_num'].'</a></span>
                    </p>
                    <span class="fs_account_orderpayment_txt">'.FS_ORDER_LINK_REMARK.':</span>
                    <p class="fs_account_orderpayment_tit">'.$orders['payment_link_data']['reamrk'].'</p>
                </div>';
    }
    return $html;
}

/**
 * 线下单未录单产品结构HTML
 * @param $products
 * @param string $page
 * @param string $href  主单详情页链接
 * @return string
 */
function createNoSplitOrdersHtml($products,$page='list',$href=''){
    $html = '';
    if(sizeof($products)){
        $see_more = false;
        foreach($products as $pKey=>$products){
            //订单列表页最多只展示3个产品
            if($page=='list'){
                if($pKey>2){
                    $see_more = true;
                    break;
                }
            }
            //定制产品属性展示板块
            $attrHtml = '';
            if($products['is_custom']){
                $attrHtml .= '<div class="fs_custom_attributes_dl_container">';
                $attrHtml .= '<dl class="fs_custom_attributes_dl after">';
                $attrNum = 0;
                if(sizeof($products['orders_products_attributes'])){
                    foreach($products['orders_products_attributes'] as $akey=>$attr){
                        $attrNum++;
                        if($page=='list' && $attrNum>1){
                            $attrHtml .= '<dd>'.$attr['options_name'].': '.$attr['values_name'].'</dd>';
                        }else{
                            $attrHtml .= '<dt>'.$attr['options_name'].': '.$attr['values_name'].'</dt>';
                        }
                    }
                }
                //长度属性
                if(!empty($products['orders_products_length'])){
                    $attrNum++;
                    if($page=='list' && $attrNum>1){
                        $attrHtml .= '<dd>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dd>';
                    }else{
                        $attrHtml .= '<dt>'.FS_LENGTH_NAME.': '.$products['orders_products_length']['length_name'].'</dt>';
                    }
                }
                $attrHtml .= '</dl>';
                //多个属性是有More板块
                if($page=='list' && $attrNum>1){
                    $attrHtml .= '<div class="fs_custom_attributes_btn fs_public_a">
                                    <span>'.FS_MANAGE_ORDERS_MORE.'<i class="iconfont icon"></i>
                                    </span>
                                </div>';
                }
                $attrHtml .= '</div>';
            }
            $html .= '<dl class="fs_account_order_dl">
                    <dt>
                        <a href="'.reset_url($products['products_href']).'"><img src="'.$products['image'].'"></a>                 
                    </dt>
                    <dd>
                        <h3 class="fs_account_order_tit">
                            <a href="'.reset_url($products['products_href']).'">'.$products['products_name'].'</a>
                        </h3>
                        '.$attrHtml.'
                        <p class="fs_account_order_pn">FS P/N: '.$products['products_model'].' <span>#'.$products['products_id'].'></span></p>
                        <p class="fs_account_order_price">'.$products['products_quantity'].'&nbsp;&nbsp;x&nbsp;&nbsp;<span>'.$products['final_price_currency'].'</span></p>
                    </dd>
                </dl>';
        }
        if($see_more && $href){
            $html .= '<div class="fs_account_list_order_number">
                    <a href="'.$href.'">'.FS_SEE_MORE.'</a>
                </div>';
        }
    }
    return $html;
}

/**
 * @param $order
 * @param int $type 订单类型 1线上单 2线下单
 * @param string $page list:订单列表页 details：线上单详情页 offline_details：线下单详情页
 * @return string
 */
function getOrderStatusActionButton($order, $type=1, $page = 'list'){
    $orders_id = $order['orders_id'];
    $payHtml = $payPoHtml = $cancelHtml = $receiptHtml = $buyHtml = $returnHtml = '';
    $actionHtml = '';
    $payOrdersId = $orders_id;
    //详情页 pending状态下的操作按钮顺序是 cancel、install、PayNow
    switch($order['orders_status']) {
        case 1://pending 状态
            if(!in_array($order['main_order_id'],[0,1])){
                $payOrdersId = $order['main_order_id'];
            }
            if($page=='details'){
                $cancelHtml = '<a href="javascript:void(0)" class="account_alone_a a_height public_a_secondary" onclick="showCancelWindow('.$payOrdersId.')">'.FS_CANCEL.'</a>';
            }
            if($order['payment_module_code']=='alfa'){
                //俄罗斯对公支付 不需要paynow按钮
                $payHtml = '';
            }else if($order['payment_module_code']=='purchase'){
                $poClass = 'fs_account_btn_txt attach_po';
                $iHtml = '<i class="iconfont icon">&#xf438;</i>';
                if($page=='details'){
                    $poClass = 'account_alone_a a_height attach_po';
                    $iHtml = '';
                }
                $payHtml = '<a class="'.$poClass.'" onclick="showPoUpload('.$payOrdersId.')" href="javascript:;">'.$iHtml.'<span>'.FS_ACCOUNT_TW_ATTACH_PO.'</span></a>';
            }else if($order['payment_module_code']=='echeck'){
                //echeck支付方式 后台审核通过后不需要给PayNow按钮
                $echeck_result = fs_get_data_from_db_fields('id', 'fs_electrical_check_apply', 'orders_id ='.$orders_id.'', 'limit 1');
                if($echeck_result){
                    $payHtml = "";
                }else{
                    $payHtml = '<a class="fs_account_btn account_alone_a"  href="javascript:void(0)" onclick="justPayNow('.$payOrdersId.')">'.MANAGE_ORDER_PAY.'</a>';
                }
            }else{
                $payHtml= '<a class="fs_account_btn account_alone_a"  href="javascript:void(0)" onclick="justPayNow('.$payOrdersId.')">'.MANAGE_ORDER_PAY.'</a>';
            }
            break;
        case 12: //In Transit
            //$actionHtml .= '<a class="fs_account_btn account_gray" href="javascript:;">'.F_RECEIPT_CONFIRMATION.'</a>';
            $receiptHtml = '<span class="fs_account_btn account_gray received_account">
                                    '.F_RECEIPT_CONFIRMATION.'
									<div class="removed_window_container" style="display: none;">
	                                    <div class="removed_bg"></div>
	                                    <div class="removed_window">
	                                        <div class="bubble-arrow"></div>
	                                        <p class="removed_window_tit">'.MANAGE_ORDER_ARE.'</p>
	                                        <div class="removed_window_a_container">
	                                            <button class="account_alone_a a_height" href="javascript:;">'.FS_COMMON_CANCEL.'</button>
	                                            <button class="account_alone_a a_height new_handle_one_hide" href="javascript:;" onclick="confirm_recepit('.$orders_id.', '.$type.')">'.FS_CONFIRM.'</button>
	                                        </div>
	                                    </div>
	                                </div>
									</span>';
            break;
        case 4:
            //deliver和payment receive状态给整单加购按钮buy again
            if($type==1){
                $buyHtml = '<div class="fs_bubble_popover_wap">
                        <div class="bubble-popover-wap m_account_bubble">
                            <div class="m-bubble-bg"></div>
                            <div class="bubble-popover">
                                <button class="fs_account_btn account_gray" href="javascript:void(0);" onclick="buy_again('.$orders_id.','.$type.',1,this)"><span>'.FS_ACCOUNT_TW_ORDER_AGAIN.'</span></button>
                                <div class="m-bubble-container">
                                    <div class="bubble-frame bubble-middle">
                                        <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;"><i class="iconfont icon"></i></a>
                                       
                                        <div class="bubble-arrow"></div>
                                        <div class="bubble-content">
                                            <p>'.FS_ACCOUNT_TW_YOU_CAN.'</p>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                       </div>
                    </div>';
            }
            break;
    }
    //退换货入口
    if($order['returnRes']){
        $returnClass = 'fs_account_btn_txt';
        $iHtml = '<i class="iconfont icon">&#xf437;</i>';
        if($page=='details'){
            $returnClass = 'account_alone_a a_height';
            $iHtml = '';
        }
        //完成状态 退换货入口
        $returnHtml = '<a class="'.$returnClass.'" href="'.zen_href_link('sales_service_info', '&orders_id='.$orders_id.'&type='.$type).'">'.$iHtml.'<span>'.MANAGE_ORDER_RETURN.'</span></a>';
    }
    //列表页 po单附件展示
    $poHref = '';
    if($order['purchase_order_num'] && $order['pdf_file']) {
        $poHref = '<a class="fs_account_btn_txt" target="_blank" href="' . $order['pdf_file'] . '"><i class="iconfont icon">&#xf438;</i>' . $order['purchase_order_num'] . '</a>';
    }
    //发票展示入口
    if($page=='details'){
        if(isMobile()){
            $actionHtml .= $payHtml.$cancelHtml.$receiptHtml.$buyHtml.$returnHtml;
        }else{
            $actionHtml .= $cancelHtml.$payHtml.$receiptHtml.$buyHtml.$returnHtml;
        }
    }elseif($page=='offline_details'){
        $actionHtml .= ($receiptHtml ? '<div>'.$receiptHtml.'</div>':'').($returnHtml ? '<div>'.$returnHtml.'</div>':'');
    }else{
        $actionHtml .= ($payHtml ? '<div>'.$payHtml.'</div>':'').($receiptHtml ? '<div>'.$receiptHtml.'</div>':'').($buyHtml ? '<div>'.$buyHtml.'</div>':'').($returnHtml ? '<div>'.$returnHtml.'</div>':'').($poHref ? '<div>'.$poHref.'</div>':'');;
    }
    //发票入口
    if($page!='details'){
        $type_str = 'orders';
        $status_href = '';
        if($type==2){
            $type_str = 'orders_split';
            $status_href = '&status=orders_split';
        }
        if($order['orders_status']==1 && !in_array($order['main_order_id'],[0,1])){
            $downloadHref = zen_href_link('account_history_info','orders_id='.$orders_id);
        }else{
        $invoiceData = get_show_definite_invoice($orders_id, $order['orders_number'], $order['date_purchased'], $type_str);
        $downloadHref = 'javascript:void(0);';
        $downloadTip = '';
        if ($invoiceData['show_invoice'] == 1) {
            $downloadHref = zen_href_link(FILENAME_PRINT_BLANKET_ORDER, '&orders_id=' . intval($invoiceData['oId']).$status_href);
        } elseif ($invoiceData['show_invoice'] == 2) {
            $downloadHref = zen_href_link(FILENAME_PRINT_DEFINITE_INVOICE, '&orders_id=' . intval($invoiceData['oId']).$status_href);
        } else {
            //重开票的灰色展示提示不给入口
            $downloadTip = '<div class="bubble-popover-wap">
                        <div class="m-bubble-bg"></div>
                        <div class="bubble-popover">
                            <span class="iconfont icon bubble-icon">&#xf228;</span>
                            <div class="m-bubble-container">
                                <div class="bubble-frame middle-top">
                                <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                                    <div class="bubble-arrow"></div>
                                    <div class="bubble-content">
                                        <p>' . FS_VIEW_INVOICE_BUBBLE . '</p>
                                    </div>
                                </div>	
                            </div>
                        </div>
                    </div>';
        }
        }

        //订单没有产品的为补款链接，不显示发票下载按钮
        if(sizeof($order['products'])>0){
            $actionHtml .= '<div><a class="fs_account_btn_txt" target="_blank" href="'.$downloadHref.'"><i class="iconfont icon">&#xf184;</i><span>'.MANAGE_ORDER_DOWNLOAD_INVOICE.'</span>'.$downloadTip.'</a></div>';
        }

    }
    return $actionHtml;
}

/**
 * 展示线上单重录单数据提示HTML
 * @param array $retake
 * @return string
 */
function createOrdersRetakeHtml($retake=[]){
    $html = '';
    if($retake['orders_split_id'] && $retake['orders_number']){
        $onlineRetakeTip = FS_OFFLINE_10.' <a href="'.zen_href_link('account_offline_history_info','orders_id='.$retake['orders_split_id']).'">'.$retake['orders_number'].'</a>';
        $html = createCommonBubbleHtml($onlineRetakeTip);
    }
    return $html;
}

//订单列表页和详情页获取 订单倒计时展示
function getPendingOrderShowEndTimeHtml($order, $page='list'){
    $html = '';
    if($order['orders_status']==1){
        if($order['payment_module_code']!='echeck'){
            //订单倒计时
            $html .= get_show_end_time_str_new($order['orders_id'],$order['payment_module_code'],$page);
        }
    }
    return $html;
}

/**
 * 合发单信息展示HTML
 * @param array $merge_data
 * @param $orders_id
 * @param int $type 1代表线上单 2代表线下单
 * @return string
 */
function createMergeOrderHtml($merge_data=[],$orders_id,$type=1){
    $merge_html = '';
    if (count($merge_data) > 0) {
        $merge_html = '<p class="shipped_package"><a onclick="show_method_merge('.$orders_id.', '.$type.',this)" href="javascript:;">'.FS_OFFLINE_POPUP.'</a></p>';
    }
    return $merge_html;
}

/**
 * 公用的气泡弹窗HTML
 * @param $tip
 * @return string
 */
function createCommonBubbleHtml($tip){
    $html = '<div class="bubble-popover-wap m_account_bubble">
                <div class="m-bubble-bg"></div>
                <div class="bubble-popover">
                    <i class="iconfont icon bubble-icon">&#xf229;</i>
                    <div class="m-bubble-container">
                        <div class="bubble-frame middle-top">
                            <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;"><i class="iconfont icon"></i></a>
                           
                            <div class="bubble-arrow"></div>
                            <div class="bubble-content">
                                <p>'.$tip.'</p>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>';
    return $html;
}

/**
 * buy again展示关闭、定制、清仓产品HTML
 * @param $products
 * @param string $type
 * @return string
 */
function customCloseProductHtml($products, $type='custom'){
    $html = '';
    if(sizeof($products)){
        //提示语
        $title_message = FS_MANAGE_CUSTOM_TIP;
        $link_title = FS_PRODUCT_OFF_TEXT_3;
        $close_tip_html = '';   //关闭产品的气泡提示语
        if($type=='close'){
            $title_message = FS_MANAGE_CLOSE_TIP;
            $link_title = FS_SHOP_CART_SIMILAR;
            $close_tip_html = '<div class="public_white_bg"></div>
                            <div class="defective-product"><div class="bubble-popover-wap">
                                <div class="bubble-popover">
                                    <span class="iconfont icon bubble-icon"></span>
                                    <div class="bubble-frame left-left-middle">
                                        <div class="bubble-arrow"></div>
                                        <div class="bubble-content">
                                            <p>'.FS_PRODUCT_OFF_TEXT.'</p>
                                        </div>
                                    </div>
                                </div>
                            </div></div>';
        }elseif($type=='clearance'){
            $title_message = FS_PRODUCT_CLEARANCE_TEXT_1;
        }elseif($type=='clearance_no'){
            $title_message = FS_PRODUCT_CLEARANCE_TEXT;
        }
        $html .= '<div class="order_again_tr">';
        $html .= '<div class="order_again_prompt">'.$title_message.'</div>';
        foreach($products as $key=>$product){
            $attributeHtml = '';
            $attrNum = 0;
            if(!empty($product['orders_products_attributes'])){
                foreach($product['orders_products_attributes'] as $ak=>$aval){
                    $attrNum ++;
                    if($attrNum>1){
                        $attributeHtml .= '<dd>'.$aval['options_name'].' - '.$aval['values_name'].'</dd>';
                    }else{
                        $attributeHtml .= '<dt>'.$aval['options_name'].' - '.$aval['values_name'].'</dt>';
                    }
                }
            }
            if(!empty($product['orders_products_length'])){
                if($attrNum>1){
                    $attributeHtml .= '<dd>'.FS_LENGTH_NAME.' - '.$product['orders_products_length']['length_name'].'</dd>';
                }else{
                    $attributeHtml .= '<dt>'.FS_LENGTH_NAME.' - '.$product['orders_products_length']['length_name'].'</dt>';
                }
            }
            if($attributeHtml){
                $attributeHtml = '<dl class="order_again_attributes">'.$attributeHtml.'</dl>';
            }
            //清仓产品库存不足是展示库存数量
            $stockHtml = '';
            if($type=='clearance'){
                $stockHtml = '<i class="order_again_stock">'.$product['clearance_qty'].' '.QTY_SHOW_IN_CN_STOCK_1.'</i>';
            }
            $customHtml = '';
            if($type=='custom' || $type=='close'){
                $customHtml = '<a class="fs_public_a order_again_a" href="'.reset_url($product['products_href']).'" target="_blank">
                                    <span>'.$link_title.'</span>
                                    <i class="iconfont icon">&#xf089;</i>
                                </a>';
            }
            $html .= '<div class="order_again_flex">
                    <div class="order_again_td order_again_one">
                        <div class="public_position">'.$close_tip_html.'
                            <img src="'.$product['image'].'"/>
                        </div>
                        <div class="order_again_txt_container">
                            <h3 class="fs_account_order_tit"><a href="'.reset_url($product['products_href']).'">'.$product['products_name'].'</a></h3>
                            <p class="fs_account_order_pn">FS P/N: '.$product['products_model'].' <span>#'.$product['products_id'].'</span></p>
                            '.$attributeHtml.$customHtml.'
                        </div>
                    </div>
                    <div class="order_again_td order_again_three">
                        <p class="order_again_price">'.$product['final_price_currency'].$stockHtml.'</p>	
                    </div>	
                </div>	';
        }
        $html .= '</div>';
    }
    return $html;
}

/**
 * @param $noProducts
 * @param $orders_id
 * @param $type
 * @param $status 是否给skip and continue按钮
 * @param $is_quote
 * @return string
 */
function createBuyMoreProductsHtml($noProducts,$orders_id,$type,$status=true, $is_quote = false){
    $html = '';
    $html .= '<div class="alert_popup_width">';
    $html .= '<div class="fs_public_warnings">
					<i class="iconfont icon warnings_mark">&#xf228;</i> 
					'.($status ? ($is_quote ? FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2 : FS_ACCOUNT_TW_THE) : ($is_quote ? FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1 : FS_ACCOUNT_TW_THE_NO)).'
				</div>';
    $html .= '<div class="order_again_product_list">
					<div class="order_again_table">';
    foreach($noProducts as $key=>$products){
        $html .= customCloseProductHtml($products,$key);
    }
    $html .= '</div></div>';
    $html .= '</div>';
    //按钮板块
    $html .= '<div class="alone_text_align_right">
                <a class="account_alone_a public_a_secondary" href="javascript:void(0);" onclick="cancel_buy_again()">'.FS_COMMON_CANCEL.'</a>
                '.($status ? '<a class="account_alone_a a_red" href="javascript:void(0);" onclick="buy_again('.$orders_id.','.$type.',2,this)"><span>'.FS_COMMON_REORDER_SKIP.'</span></a>':'').'
            </div>';
    return $html;
}

/**
 * buy again弹窗 展示确认可以加购的产品HTML
 * @param $products
 * @param array $orders_data 数组包含orders_id和orders_number
 * @param $type
 * @return string
 */
function createBuyAgainAddProductsHtml($products,$orders_data=[],$type){
    $html = '';
    $orders_number = $orders_data['orders_number'] ? $orders_data['orders_number'] : $orders_data['quotes_number'];
    $orders_id = $orders_data['orders_id'] ? $orders_data['orders_id'] : $orders_data['quotes_id'];
    if(count($products)){
        $html .= '<div class="alert_popup_width">';
        //提示语板块
        $html .= '<div class="fs_public_warnings">
					<i class="iconfont icon warnings_mark">&#xf228;</i>'.($orders_data['orders_number'] ? sprintf(FS_ACCOUNT_TW_ITEMS, $orders_number) : FS_ACCOUNT_TW_QUOTES_LIST_TIPS).'</div>';
        //产品展示板块start
        $html .= '<div class="order_again_product_list">
					<div class="order_again_table">';
        foreach($products as $key=>$product){
            $attributeHtml = '';
            $attrNum = 0;
            if(!empty($product['orders_products_attributes'])){
                foreach($product['orders_products_attributes'] as $ak=>$aval){
                    $attrNum ++;
                    if($attrNum>1){
                        $attributeHtml .= '<dd>'.$aval['options_name'].' - '.$aval['values_name'].'</dd>';
                    }else{
                        $attributeHtml .= '<dt>'.$aval['options_name'].' - '.$aval['values_name'].'</dt>';
                    }
                }
            }
            if(!empty($product['orders_products_length'])){
                if($attrNum>1){
                    $attributeHtml .= '<dd>'.FS_LENGTH_NAME.' - '.$product['orders_products_length']['length_name'].'</dd>';
                }else{
                    $attributeHtml .= '<dt>'.FS_LENGTH_NAME.' - '.$product['orders_products_length']['length_name'].'</dt>';
                }
            }
            if($attributeHtml){
                $attributeHtml = '<dl class="order_again_attributes">'.$attributeHtml.'</dl>';
            }
            $html .= '<div class="order_again_tr">';
            //产品数量框展示板块
            $choosez = '';
            if($product['is_clearance'] && $product['products_quantity']>=$product['clearance_qty']){
                $choosez = ' choosez';
            }
            $qtyHtml ='<div class="cart_basket_btn">
                        <input type="text" id="img_quantity3_'.$product['products_id'] .'" name="cart_quantity['.$product['orders_products_id'].']" onkeyup=this.value=this.value.replace(/[^0-9]/g,"") maxlength="5" onafterpaste=this.value=this.value.replace(/[^0-9]/g,"") min="1" onblur=add_check_min_qty(this,"'.$product['products_id'] .'","'.$product['is_clearance'].'","'.$product['clearance_qty'].'"); onfocus="q_enterKey(this,'.$product['products_id'] .')" value="'.$product['products_quantity'].'" autocomplete="off" class="p_07 product_list_qty">
                        <div class="pro_mun">
                            <a href="javascript:void(0);" onclick=change_product_num(1,"'.$product['products_id'] .'",this,"'.$product['is_clearance'].'","'.$product['clearance_qty'].'") class="cart_qty_add '.$choosez.'"></a>
                            <a href="javascript:void(0);" onclick=change_product_num(0,"'.$product['products_id'] .'",this,"'.$product['is_clearance'].'","'.$product['clearance_qty'].'") class="cart_qty_reduce cart_reduce"></a>
                        </div>
                    </div>
                    <span class="iconfont icon order_again_delete" onclick="removeAgainProducts(this)">&#xf027;</span>';
            $html .= '<div class="order_again_flex">
								<div class="order_again_td order_again_one">
									<div class="public_position">
										<img src="'.$product['image'].'"/>
									</div>
									<div class="order_again_txt_container">
                                        <h3 class="fs_account_order_tit"><a href="'.reset_url($product['products_href']).'">'.$product['products_name'].'</a></h3>
                                        '.$attributeHtml.'									
                                        <p class="fs_account_order_pn">FS P/N: '.$product['products_model'].' <span>#'.$product['products_id'].'</span></p>
                                    </div>
								</div>
								<div class="order_again_td order_again_three">
									<p class="order_again_price">'.$product['final_price_currency'].'</p>
									
									<div class="cart_basket_btn_container">
										'.$qtyHtml.'
									</div>
								
								</div>	
							</div>';
            $html .= '</div>';
        }
        $html .= '</div></div>';//产品展示板块end
        $html .= '</div>';

        //操作按钮展示板块
        $html .= '<div class="alone_text_align_right">
				<a class="account_alone_a public_a_secondary" href="jaascript:void(0);" onclick="cancel_buy_again()">'.FS_COMMON_CANCEL.'</a>
				<a class="account_alone_a a_red" href="javascript:void(0);" onclick="buy_again('.$orders_id.','.$type.',3,this)"><span><i class="iconfont icon">&#xf142;</i> '.FS_ADD_TO_CART.'</span></a>
			</div>';
    }
    return $html;
}

function getOrdersTrackInfo($shipping_method,$num,$orders_id,$type=1){
    $html = '';
    $data = fs_order_shipping_info_kuaidi100($shipping_method,$num,false);
    if($type==1) {
        $href = zen_href_link('track_package','from=list&orders_id='.$orders_id);
    }else{
        $href = zen_href_link('track_package','from=list&orders_id='.$orders_id.'&is_offline=1');
    }
    if($data && $data['info_str'] && sizeof($data['info_str'])){
        $html .= '<div class="ups_express">
                    <span>'.$shipping_method.'</span>
                    <span>'.$num.' </span>
                </div>';

        $html .= '<div class="ups_express_content">
            <ul class="ups_express_ul">';
        foreach ($data['info_str'] as $key => $val){
            if($key>=2){
                break;
            }
            $class = '';
            if($key==1){
                $class = ' class="express_gray" ';
            }
            $time = get_all_languages_date_display($val->time, 'default1');
            $html .= '<li '.$class.'>
                <span class="ups_express_point_conatiner">
                    <span class="ups_express_point"></span>
                </span>
                <div class="ups_express_txt_conatiner">
                    <strong class="">'.$val->context.'</strong>
                    <span><i class="iconfont icon">&#xf072;</i>'.$time.'</span>	
                </div>
            </li>';
        }
        $html .= '</ul></div>';
        $html .= '<div class="ups_express_a"><a href="'.$href.'">'.FS_VIEW_ALL.'</a> </div>';

    }else{
        $track_info = $shipping_method.' - '.$num;
        $process_flow_tip_info = sprintf(FS_ORDERS_TRACK_LABEL, $track_info);
        $html .= '<div class="ups_express">
                    <span>'.$shipping_method.'</span>
                    <span>'.$num.' </span>
                </div><div class="ups_express_content"><p class="logistics_tips">'.$process_flow_tip_info.'</p></div>
                <div class="ups_express_a"><a href="'.$href.'">'.FS_VIEW_ALL.'</a> </div>';
    }
    return $html;
}

/**
 * 订单列表结构 账户首页和订单列表页公用
 * @param $ordersData
 * @return string
 */
function createCommonOrdersHtml($ordersData){
    $ordersHtml = '';
    $is_mobile = isMobile();
    foreach($ordersData as $key=>$orders) {
        $sonOrdersNum = count($orders['son_orders']);
        $li_class = '';
        $m_pending_class = '';
        if($sonOrdersNum>1){
            $li_class = 'separate_document_m';
            if($orders['orders_status']==1){
                $m_pending_class = ' m_pending ';
            }
        }else{
            if($orders['son_orders'][0]['is_split_order']){
                $li_class = 'separate_document_m';
            }
        }
        $ordersHtml .= '<li class="fs_account_order_li '.$li_class.$m_pending_class.'">';
        //订单倒计时
        $orderEndTime = getPendingOrderShowEndTimeHtml($orders);
        $orderCreateTime = zen_show_local_time($orders['date_purchased'],$orders['delivery_country_code'],'default1','America/Los_Angeles');
        $ordersHtml .= '<div class="fs_account_order_li_border">';
        if($orders['payment_module_code']=='purchase'){
            //PO订单独有板块
            $ordersHtml .='<div class="fs_public_Prompt_container"><div class="fs_public_Prompt">'.FS_ORDER_PURCHASE.'</div></div>';
        }
        /*** 总单最上面订单号、po号、总价格、下单日期展示板块 start***/
        //线上取消状态的订单的重录单和合发单提示语展示
        $onlineRetakeTipHtml = $mergeOrderTipHtml = $mainMobileStatusHtml = '';
        if($orders['main_order_id']==0){
            //总单直接展示单号
            if($orders['is_split_order']){
                //拆单点击订单号跳转至线下单详情页面
                $ordersHref = zen_href_link('account_offline_history_info','orders_id='.$orders['split_order_info']['split_main_id']);
            }else{
                if(!$orders['is_payment_link']){
                    $ordersHref = zen_href_link('account_history_info', 'orders_id=' . $orders['orders_id']);
                    $onlineRetakeTipHtml = createOrdersRetakeHtml($orders['son_orders'][0]['retake_arr']);
                    $mergeOrderTipHtml = createMergeOrderHtml($orders['son_orders'][0]['merge_arr'],$orders['orders_id']);
                }
                //M端订单状态展示
                $mainMobileStatusHtml = '<span class="fs_account_state"><i class="fs_point fs_point_'.$orders['son_orders'][0]['status_class'].'"></i> '.$orders['order_status']['orders_status_name'].'</span>';
            }
            if($orders['is_payment_link']){
                $orderTitleHtml = FS_ACCOUNT_TW_ORDER.': <strong>'.$orders['orders_number'].$onlineRetakeTipHtml.'</strong>';
            }else{
                $orderTitleHtml = FS_ACCOUNT_TW_ORDER.': <a class="" href="'.$ordersHref.'">'.$orders['orders_number'].$onlineRetakeTipHtml.'</a>'.$mergeOrderTipHtml;
            }
        }else{
            //有多个分单展示Spilt Order
            $orderTitleHtml = '<i class="">'.FS_ACCOUNT_TW_SPLIT_ORDER.'</i>';
        }
        $poNumberHtml = '';
        if($orders['purchase_order_num']){
            $poNumberHtml = '<div class="fs_account_order_number_alone fs_account_po_number">'.FS_ACCOUNT_PO_NUMBER.': <span title="'.$orders['purchase_order_num'].'">'.$orders['purchase_order_num'].'</span></div>';
        }elseif($orders['son_orders'][0]['customers_po']){
            $poNumberHtml = '<div class="fs_account_order_number_alone fs_account_po_number">'.FS_ACCOUNT_PO_NUMBER.': <span title="'.$orders['son_orders'][0]['customers_po'].'">'.$orders['son_orders'][0]['customers_po'].'</span></div>';
        }
        $ordersHtml .= '<div class="fs_account_order_top">
                                    <div class="fs_account_order_top_left">
                                        <div class="fs_account_order_number_alone fs_account_order_number">'.$orderTitleHtml.'</div>
                                        '.$poNumberHtml.'
                                        <div class="fs_account_order_number_alone fs_account_total_number">'.FIBERSTORE_ORDER_TOTAL.': <span>'.$orders['order_total']['ot_total']['text'].'</span></div>
                                    </div>
                                    <div class="fs_account_order_top_right">
                                        <span class="fs_account_order_number_alone fs_account_sep_number">'.MANAGE_ORDER_PLACED.': <i>'.$orderCreateTime.'</i></span>
                                        '.$mainMobileStatusHtml.'
                                    </div>
                                </div>';
        /*** 总单最上面订单号、po号、总价格、下单日期展示板块 end***/
        $ordersHtml .= '<div class="fs_account_list_separate_document">';
        /****  单个子单产品展示板块HTML start****/
        foreach($orders['son_orders'] as $sKey=>$order){
            if($order['is_split_order']){
                //订单被拆成多个线下单
                $ordersHtml .= '<div class="fs_account_list_separate_alone">';
                //分单的订单号展示板块
                $ordersNumberHtml = '';
                $sonOrdersHref = zen_href_link('account_offline_history_info','orders_id='.$order['split_order_info']['split_main_id']);
                if($sonOrdersNum>1){
                    $ordersNumberHtml = '<div class="fs_account_list_order_number delivery">'.FS_ACCOUNT_TW_ORDER.': <span><a href="'.$sonOrdersHref.'">'.$order['orders_number'].'</a></span></div>';
                }
                if($order['orders_status']!=1){
                    $ordersHtml .= $ordersNumberHtml;
                }
                $ordersHtml .= '<div class="fs_account_order_li_border">				
                                                    <div class="fs_account_list_separate_document">';
                //展示所有拆单数据
                $splitNum = $sonSplitNum = count($order['split_order_info']['son_orders']);
                if(!empty($order['split_order_info']['orders_split_products'])){
                    $splitNum +=1;
                }
                foreach($order['split_order_info']['son_orders'] as $splitKey=>$splitVal){
                    //M端订单状态展示
                    $sonMobileStatusHtml = '<span class="fs_account_state"><i class="fs_point fs_point_'.$splitVal['status_class'].'"></i> '.$splitVal['order_status']['orders_status_name'].'</span>';
                    if($splitKey<5){
                        $retakeTip = $retakeTipHtml = '';
                        if($splitVal['orders_status']==5 ){ //取消状态的拆单如果有重录单数据需要展示提示
                            if($splitVal['retake_id'] && $splitVal['retake_number']){
                                $retakeTip = FS_OFFLINE_10.' <a href="'.zen_href_link('account_offline_history_info', 'orders_id='.$splitVal['retake_id']).'">'.$splitVal['retake_number'].'</a>';
                                $retakeTipHtml = createCommonBubbleHtml($retakeTip);
                            }
                        }
                        $sonMergeTipHtml = createMergeOrderHtml($splitVal['merge_arr'],$splitVal['orders_id'],2);

                        $ordersHtml .= '<div class="fs_account_list_separate_alone">';
                        $ordersHtml .= '<div class="fs_account_list_order_number delivery"><i class="delivery">'.FS_ACCOUNT_TW_DELIVERY.' '.($splitKey+1).'/'.$splitNum.'</i>'.$retakeTipHtml.$sonMergeTipHtml.$sonMobileStatusHtml.'</div>';
                        //订单产品、状态、以及操作按钮展示HTML
                        $ordersLeftHtml = $ordersRightHtml = $productHtml = '';
                        $productHtml = createOrderProductsHtml($splitVal);
                        $ordersLeftHtml .= '<div class="fs_account_order_top_left after">
                                                        <div class="fs_account_order_dl_container">'.$productHtml.'</div></div>';

                        //右边订单状态和操作板块start
                        $cancelTip = '';    //付款后的取消单的提示语
                        if($splitVal['orders_status']==5) {
                            $splitCancelTip = FS_OFFLINE_13;
                            $cancelTip = createCommonBubbleHtml($splitCancelTip);
                        }
                        $inTransitHtml = '';
                        if($splitVal['orders_status']==12 && $splitVal['orders_track_info'][0]){
                            $inTransitHtml = createTransitHtml($splitVal['orders_id'],$splitVal['orders_track_info'][0],2);
                        }
                        $statusActionHtml = getOrderStatusActionButton($splitVal,2);
                        $rightClass = 'empty';
                        if(!$is_mobile || ($is_mobile && $statusActionHtml)){
                            //m端有操作按钮才展示fs_account_order_transit_right的HTML
                            $statusActionHtml = '<div class="fs_account_order_transit_right">'.$statusActionHtml.' </div>';
                            $rightClass = '';
                        }
                        $ordersRightHtml .= '<div class="fs_account_order_top_right '.$rightClass.'">
                                                            <div class="fs_account_order_right">
                                                                <div class="fs_account_order_transit_left">
                                                                    <div class="fs_account_state">
                                                                        <i class="fs_point fs_point_'.$splitVal['status_class'].'"></i> '.$splitVal['order_status']['orders_status_name'].$cancelTip.'
                                                                    </div>'.$inTransitHtml.'
                                                                </div>
                                                                '.$statusActionHtml.'
                                                            </div>
                                                        </div>';

                        $ordersHtml .= '<div class="fs_account_order_bottom">'.$ordersLeftHtml.$ordersRightHtml.'</div>';
                        $ordersHtml .= '</div>';    //class=fs_account_list_separate_alone 对应的结束div
                    }
                }
                //展示未推送的产品
                if(!empty($order['split_order_info']['orders_split_products']) && $sonSplitNum<5){
                    $noSplitProductsHtml = createNoSplitOrdersHtml($order['split_order_info']['orders_split_products'],'list',$sonOrdersHref);
                    $spiltRightHtml = '';
                    $rightClass = 'empty';
                    if(!$is_mobile){
                        $rightClass = '';
                        $spiltRightHtml = '<div class="fs_account_order_transit_right"></div>';
                    }
                    $ordersHtml .= '<div class="fs_account_list_separate_alone">
                                                        <div class="fs_account_list_order_number delivery">
															<i class="delivery">'.FS_ACCOUNT_TW_DELIVERY.' '.$splitNum.'/'.$splitNum.'</i>
														</div>
														<div class="fs_account_order_bottom">
                                                            <div class="fs_account_order_top_left after">
                                                                <div class="fs_account_order_dl_container">
                                                                    '.$noSplitProductsHtml.'
                                                                </div>
                                                            </div>
                                                            <div class="fs_account_order_top_right '.$rightClass.'">
                                                                <div class="fs_account_order_right">
                                                                    <div class="fs_account_order_transit_left">
                                                                        <div class="fs_account_state"><i class="fs_point fs_point_green"></i> '.FS_OFFLINE_17.'</div>
                                                                    </div>
                                                                    '.$spiltRightHtml.'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                }
                $ordersHtml .= '</div></div>';    //class=fs_account_order_li_border 对应的结束div
                //拆单子单最多只展示5个，大于5个给跳转至详情页链接
                if($splitNum>5){
                    $ordersHtml .= '<div class="fs_account_list_order_number more_deliveries"><p class="">'.FS_OFFLINE_14.'<a href="'.$sonOrdersHref.'">'.FS_OFFLINE_15.'</a>'.FS_OFFLINE_16.'</p></div>';
                }

                $ordersHtml .= '</div>';    //class=fs_account_list_separate_alone 对应的结束div

            }else{
                //子单重录单信息提示板块
                $sonRetakeHtml = '';
                if($order['retake_arr']){
                    $sonRetakeHtml = createOrdersRetakeHtml($order['retake_arr']);
                }
                //M端订单状态展示
                $sonMobileStatusHtml = '<span class="fs_account_state"><i class="fs_point fs_point_'.$order['status_class'].'"></i> '.$orders['order_status']['orders_status_name'].'</span>';
                //子单合发单信息展示板块
                $sonMergeTipHtml = createMergeOrderHtml($order['merge_arr'],$order['orders_id']);
                //分单的订单号展示板块
                $ordersNumberHtml = '';
                $sonOrdersHref = zen_href_link('account_history_info','orders_id='.$order['orders_id']);
                if($sonOrdersNum>1){
                    $ordersNumberHtml = '<div class="fs_account_list_order_number"><p>'.FS_ACCOUNT_TW_ORDER.': <span><a href="'.$sonOrdersHref.'">'.$order['orders_number'].'</a>'.$sonRetakeHtml.'</span></p>'.$sonMergeTipHtml.$sonMobileStatusHtml.'</div>';
                }
                $ordersHtml .= '<div class="fs_account_list_separate_alone">';
                //主单下有多个分单 且当前订单是付款后状态时 展示的子单的订单号HTML
                if($orders['orders_status']!=1){
                    $ordersHtml .= $ordersNumberHtml;
                }
                //订单产品、状态、以及操作按钮展示HTML
                $ordersHtml .= '<div class="fs_account_order_bottom">';
                //订单产品展示板块
                $ordersLeftHtml = $ordersRightHtml = $productHtml = '';
                $productHtml = createOrderProductsHtml($order);
                $ordersLeftHtml .= '<div class="fs_account_order_top_left after"><div class="fs_account_order_dl_container">';
                if($sonOrdersNum>1){
                    $ordersLeftHtml .= '<div class="fs_account_order_dl_alone">'.($orders['orders_status']==1 ? $ordersNumberHtml:'').$productHtml.'</div>';
                }else{
                    $ordersLeftHtml .= $productHtml;
                }
                $ordersLeftHtml .= '</div></div>';  //class=fs_account_order_dl_container 对应的结束div
                //右边订单状态和操作板块start
                $ordersRightHtml .= '';
                $statusHtml = $actionHtml = '';
                $inTransitHtml = '';    //in transit发货状态运单号展示
                if($order['orders_status']==12 && $order['orders_track_info'][0]){
                    $inTransitHtml = createTransitHtml($order['orders_id'],$order['orders_track_info'][0]);
                }
                $cancelTip = '';    //付款后的取消单的提示语
                if($order['orders_status']==5 && $order['is_payment']){
                    $splitCancelTip = FS_OFFLINE_13;
                    $cancelTip = createCommonBubbleHtml($splitCancelTip);
                }
                $deliverTimeHtml = '';  //deliver状态的时间
                if($order['orders_status']==4){
                    $deliverTime = zen_show_local_time($order['history'][4]['date_added'],$orders['delivery_country_code'],'default1','America/Los_Angeles');
                    if($deliverTime){
                        $deliverTimeHtml = '<div class="fs_account_order_transit_expire">'.FS_ACCOUNT_TW_DELIVERY_ON.$deliverTime.'</div>';
                    }
                }
                $rightClass = 'empty';
                if($orders['orders_status']==1 && $sKey>=1){
                    //多个分单pending状态时，状态板块和操作板块只有第一个子单展示
                    $statusHtml .= '<div class="fs_account_order_transit_left"></div>';
                    if(!$is_mobile){
                        //右边操作版块为空时M端不需要该结构
                        $actionHtml .= '<div class="fs_account_order_transit_right"></div>';
                        $rightClass = '';
                    }else{
                        //pending状态的每个分单都给操作按钮
                        $actionHtml .='<div class="fs_account_order_transit_right">'.getOrderStatusActionButton($order).'</div>';
                    }
                }else{
                    $statusHtml .= '<div class="fs_account_order_transit_left">
                                                        <div class="fs_account_state">
                                                            <i class="fs_point fs_point_'.$order['status_class'].'"></i> '.$order['order_status']['orders_status_name'].$cancelTip.'
                                                        </div>'.$orderEndTime.$inTransitHtml.$deliverTimeHtml.'
                                                    </div>';
                    $statusActionHtml = getOrderStatusActionButton($order);
                    if(!$is_mobile || ($is_mobile && $statusActionHtml)){
                        //m端有操作按钮才展示fs_account_order_transit_right的HTML
                        $actionHtml .= '<div class="fs_account_order_transit_right">'.$statusActionHtml.' </div>';
                        $rightClass = '';
                    }
                }
                $ordersRightHtml .= '<div class="fs_account_order_top_right '.$rightClass.'">
                                                        <div class="fs_account_order_right">
                                                            '.$statusHtml.$actionHtml.'
                                                        </div>
                                                    </div>';
                //右边订单状态和操作板块end
                $ordersHtml .= $ordersLeftHtml.$ordersRightHtml;
                $ordersHtml .= '</div>';    //class=fs_account_order_bottom 对应的结束div
                $ordersHtml .= '</div>';    //class=fs_account_list_separate_alone 对应的结束div
            }
        }
        $ordersHtml .= '</div>';    //class=fs_account_list_separate_document 对应的结束div

        $ordersHtml .= '</div>';    //class=fs_account_order_li_border 对应的结束div
        $ordersHtml .= '</li>';
    }
    return $ordersHtml;
}

/**
 * 物流单号展示HTML
 * @param $orders_id
 * @param array $track_data
 * @param int $type 1是线上单 2是线下单
 * @return string
 */
function createTransitHtml($orders_id,$track_data=[],$type=1){
    $html = '';
    $shipping_method = $track_data['shipping_method'];
    $track_number = $track_data['tracking_number'];
    $shipping_method_new = get_short_shippind_method($shipping_method);
    if($orders_id && $shipping_method && $track_number){
        if($type==1) {
            $href = zen_href_link('track_package','from=list&orders_id='.$orders_id);
        }else{
            $href = zen_href_link('track_package','from=list&orders_id='.$orders_id.'&is_offline=1');
        }
        $html = '<div class="bubble-popover-wap m_account_bubble fs_txt_bubble_popover ">
                    <div class="m-bubble-bg"></div>
                    <div class="bubble-popover">
                       <a href="'.$href.'" onmouseover="getTrackInfo('.$orders_id.',\''.$shipping_method.'\',\''.$track_number.'\','.$type.',this)" class="fs_txt_bubble">'.$shipping_method_new.'-'.$track_number.'</a>
                        <div class="m-bubble-container">
                            <div class="bubble-frame middle-top">
                                <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;"><i class="iconfont icon"></i></a>
                                <div class="bubble-arrow"></div>
                                <div class="bubble-content">
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>';
    }
    return $html;
}

/**
 * 线下单详情页运单号HTML
 * @param array $track_data
 * @param $orders_id
 * @return string
 */
function createOfflineOrdersTrackHtml($track_data=[],$orders_id){
    $html = '';
    if(count($track_data)){
        foreach($track_data as $key=>$track){
            //对运单号重新处理，同类型的放一起
            $shipping_method = get_short_shippind_method($track['shipping_method']);
            $new_track_info[$shipping_method][] = $track['tracking_number'];

            foreach($new_track_info as $key=>$value){
                $html .= $key.' - '.implode('; ',$value).'; ';
            }
            $html = trim($html);
            $html = trim($html, ';');
        }
        $html = '<span class="removal_popup_container">
                    <a class="alone_a" href="'.zen_href_link('track_package', 'orders_id=' . $orders_id.'&is_offline=1').'">'.$html.'</a></span>';
    }
    return $html;
}