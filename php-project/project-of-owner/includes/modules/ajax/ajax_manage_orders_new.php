<?php

use App\Services\Common\ApiResponse;
use App\Services\Orders\OrderProductService;
use App\Services\Orders\OrderService;
use App\Services\Customers\CustomerService;
use App\Services\Admins\AdminService;
use App\Services\Common\Download\DownloadService;
use App\Services\Products\ProductAttributeService;
use App\Services\OrderSplit\OrderSplitService;
use App\Services\OrderSplit\OrderSplitProductService;

require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/manage_orders.php');
require_once(DIR_WS_CLASSES . 'fs_reviews.php');
$fs_reviews = new fs_reviews();

$api = new ApiResponse();
$action = $_GET['ajax_request_action'];
if (!check_login_id()) {
    $_SESSION['navigation']->set_snapshot();
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
switch($action){
    case 'buy_more':    //加购订单下的某个产品
        $orders_id = (int)$_POST['orders_id'];
        $order_products_id = (int)$_POST['order_products_id'];
        $orders_number = zen_db_input($_POST['orders_number']);
        //$addType=1是点击buy more按钮允许加购的展示QV弹窗，$addType=2是1的QV弹窗中的add to cart按钮加购，两种情况加购成功后的弹窗展示不一样
        $addType = $_POST['type'] ? $_POST['type'] : 1;
        $qty = (int)$_POST['qty'];
        if($orders_id && $order_products_id){
            require_once(DIR_WS_CLASSES.'shipping_info.php');
            $column_products = $close_products = $clearance_products = $clearance_products_no = [];   //不能直接加购的产品
            $is_add = true;
            $add_products = []; //加入购物车的产品ID
            $opService = new OrderProductService();
            //设置产品图片尺寸
            $opService->setImageSize(['size_w'=>80,'size_h'=>80]);
            $productsData = $opService->getOrderProductsInfo($orders_id, $order_products_id);
            $cart_other_info = array('from_orders_number'=>$orders_number);
            if(sizeof($productsData)){
                foreach($productsData as $key=>$products){
                    if($addType==2 && $qty){
                        //点击QV弹窗中的add to cart
                        $products['products_quantity'] = $qty;
                    }
                    if($products['is_close']){
                        //关闭产品不能加入购物车
                        $is_add = false;
                        $close_products[] = $products;
                    }else{
                        //为了防止订单中定制产品丢失属性的再次加购仍然属性丢失的情况 针对没有属性产品查询其是否有属性
                        if(!$products['is_custom']){
                            $paService = new ProductAttributeService();
                            $lengthTotal = $paService->getProductLengthTotal($products['products_id']);
                            $attributeTotal = $paService->getProductAttributeTotal($products['products_id']);
                            //任意一个属性总数不为0 即为定制产品
                            if($lengthTotal || $attributeTotal){
                                $products['is_custom'] = true;
                            }
                        }
                        if(!$products['is_custom']){
                            //判断是否是清仓产品
                            //$is_clearance = get_current_pid_if_is_clearance($products['products_id']);

                            //获取清仓产品的提示
                            $sql = "select replace_products,replace_products_tip from products_clearance where products_id=".intval($products['products_id']);
                            $query = $db->Execute($sql);
                            $products_clearance = $query->fields;
                            if ($products_clearance) {
                                $is_clearance = true;
                            } else {
                                $is_clearance = false;
                            }

                            if($is_clearance){
                                $config['pid'] = $products['products_id'];
                                $shipping_info = new ShippingInfo($config);
                                $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存

                                //判断当前产品是否已经在购物车中
                                if($_SESSION['cart']->in_cart($products['products_id'])){
                                    $cart_qty = $_SESSION['cart']->contents[$products['products_id']]['qty'];//加购数量
                                    if($clearance_qty>=$cart_qty){
                                        //清仓产品数量 需要减掉购物车中已加购的产品数据
                                        $clearance_qty = $clearance_qty - $cart_qty;
                                    }else{
                                        $clearance_qty = 0;
                                    }
                                }

                                //清仓产品的提示语
                                if ($products_clearance) {
                                    $products_clearance['replace_products'] = explode(';', $products_clearance['replace_products']);
                                    $products_clearance['replace_products'] = array_filter($products_clearance['replace_products']);
                                    if (count($products_clearance['replace_products'])) {
                                        $products_clearance_replace = current($products_clearance['replace_products']);
                                        //有替代产品
                                        if ($clearance_qty > 0 ) {
                                            $products_clearance_tip = FS_CLEARANCE_TIP_01_01.' '.FS_CLEARANCE_TIP_01_02;
                                            $products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($cn_local_qty, $products_clearance_replace), $products_clearance_tip);
                                        } else {
                                            $products_clearance_tip = FS_CLEARANCE_TIP_02_01.' '.FS_CLEARANCE_TIP_02_02;
                                            $products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($cn_local_qty, $products_clearance_replace), $products_clearance_tip);
                                        }

                                    } else {
                                        //对于无替代或者不可定制产品
                                        if ($cn_local_qty > 0 ) {
                                            $products_clearance_tip = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                                            $products_clearance_tip = str_replace(array('$QTY'), array($cn_local_qty), $products_clearance_tip);
                                        } else {
                                            $products_clearance_tip = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
                                        }
                                    }

                                } else {
                                    //对于无替代或者不可定制产品
                                    if ($cn_local_qty > 0 ) {
                                        $products_clearance_tip = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                                        $products_clearance_tip = str_replace(array('$QTY'), array($cn_local_qty), $products_clearance_tip);
                                    } else {
                                        $products_clearance_tip = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
                                    }
                                }
                                $products['products_clearance_tip'] = $products_clearance_tip;


                                if($clearance_qty>=$products['products_quantity']){
                                    //清仓产品库存大于或者等于当前产品个数允许直接加购
                                    if($addType==2){
                                        $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0, $cart_other_info);
                                    }
                                    $add_products[] = $products;
                                }else{
                                    $is_add = false;
                                    if($clearance_qty==0){
                                        //清仓产品无库存
                                        $clearance_products_no[] = $products;
                                    }else{
                                        //清仓产品库存不足
                                        $clearance_products[] = $products;
                                        //将现有的库存数量的清仓产品加入购物车
                                        $_SESSION['cart']->add_cart($products['products_id'], $clearance_qty, '', true, [], 0, $cart_other_info);
                                    }
                                }
                            }else{
                                //标准产品直接加入购物车
                                if($addType==2) {
                                    $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0, $cart_other_info);
                                }
                                $add_products[] = $products;
                            }
                        }else{
                            //针对缺少属性的定制产品直接不让加购
                            if(empty($products['orders_products_length']) && empty($products['orders_products_attributes'])){
                                $is_add = false;
                                $column_products[] = $products;
                            }else{
                                //判断是否是层级属性定制产品
                                $column_id = zen_get_products_column_id($products['products_id']);
                                //验证当前产品的属性是否发生变化
                                $newAttr = $opService->resetAttributesInfo($products);
                                $attrService = new App\Services\Products\ProductAttributeService;
                                $isValid = $attrService->checkProductsAttributesValid($products['products_id'], $newAttr);
                                if(!$column_id && $isValid){
                                    //不是层级属性产品且当前属性都存在才可以加购
                                    if($addType==2) {
                                        $real_ids = $opService->createAttributeForAddCart($products);
                                        $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], $real_ids, true, [], 0, $cart_other_info);
                                    }
                                    $add_products[] = $products;
                                }else{
                                    $is_add = false;
                                    $column_products[] = $products;
                                }
                            }
                        }
                    }
                }
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                $shopping_cart_help = new shopping_cart_help();
                $topCartHtml = '';
                if($is_add){//产品加购成功 展示加购弹窗
                    //头部购物车板块数据更新
                    $topCartHtml = $shopping_cart_help->show_cart_products_block();
                    $isMobile = isMobile();
                    //$addType=1代表是账户中心订单相关页面第一次点击buy more 需要展示QV弹窗
                    if($addType==1){
                        /********* 加购成功后展示QV弹窗 start *********/
                        $products_id = $add_products[0]['products_id'];
                        //获取QV弹窗需要展示的产品相关数据
                        $product = get_orders_product_other_data($add_products[0]);//echo json_encode($product);exit;

                        //记录订单号数据
                        $product['from_orders_number'] = $orders_number;
                        $product['from_orders_id'] = $orders_id;
                        $product['from_orders_products_id'] = $order_products_id;
                        $html = get_orders_product_qv_show_str($product, $isMobile);
                        /********* 加购成功后展示QV弹窗 end *********/
                    }else{
                        //通过点击$addType=1buy more 的QV弹窗中的add to cart按钮再次加购 加购成功后直接展示所有购物车产品弹窗
                        $html = products_add_cart_new_popup();
                    }
                    $data = array('result' => true, 'type'=>1, 'html' => $html, 'topCartHtml' => $topCartHtml,'real_ids'=>$real_ids,'isMobile'=>$isMobile);
                }else{
                    //层级定制产品不能直接加购 给出弹窗提示
                    $columnHtml = custom_close_product_tip_html($column_products);
                    $closeHtml = custom_close_product_tip_html($close_products, 'close');
                    //库存不足的清仓产品
                    $clearanceHtml = custom_close_product_tip_html($clearance_products, 'clearance');
                    //完全无库存的清仓产品
                    $clearanceNoHtml = custom_close_product_tip_html($clearance_products_no, 'clearance_no');
                    $html = $columnHtml.$closeHtml.$clearanceHtml.$clearanceNoHtml;
                    //库存不足的清仓产品 也实现了产品加购 需要刷新头部购物车板块数据
                    if($clearanceHtml){
                        //头部购物车板块数据更新
                        $topCartHtml = $shopping_cart_help->show_cart_products_block();
                    }
                    $data = array('result' => true, 'type'=>2, 'html' => $html, 'topCartHtml'=>$topCartHtml);
                }
                $api->response($data);
            }
        }
        break;

    case 'update_po':
        //上传po附件
        $orders_id = $_POST['orders_id'] ? (int)zen_db_prepare_input($_POST['orders_id']):0;
        $po_num= $_POST["purchase_order_num"]?zen_db_prepare_input($_POST["purchase_order_num"]):'';
        if(!$orders_id){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        if (empty($_SESSION['customer_id'])) {
            $api->response(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login')));
        }

        if (!can_change_order_status($orders_id) || !set_cancel_order_key($orders_id)){
            $api->response(array('status'=>3,'url' =>zen_href_link('manage_orders', '', 'SSL')));
        }
        $orderService = new OrderService();
        // 该用户有权限查看的所有订单
        $orders_arr = get_customer_can_visit_orders();
        // 不是自己的订单，没有权限查看
        if(!$orderService->checkCustomerVisitOrdersLimit($orders_id)){
            del_cancel_order_key($orders_id);
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }

        //pending状态的po订单才可以上传附件
        $orderData = $orderService->getOrdersFieldsInfo($orders_id, ['orders_status', 'main_order_id', 'payment_module_code']);
        if ($orderData['orders_status']!=1 || !in_array($orderData['main_order_id'], [0,1]) || !$orderData['payment_module_code']=='purchase') {
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }

        if(!$po_num){
            del_cancel_order_key($orders_id);
            $api->response(array('status' => 0, 'info' => FS_MANAGE_ORDERS_PURCHASE, 'data' => ''));
        }

        if($_FILES["orders_img"]['name']){

            $data = $orderService->updatePurchaseOrderFile($orders_id, $po_num, 'orders_img');
            if($data['code']==1){
                //send_email($orders_id);
                require_once DIR_WS_CLASSES.'order.php';
                $order = new order($orders_id);
                $order->send_fs_order_email($orders_id,true);
            }else{
                del_cancel_order_key($orders_id);
                $api->response(array('status' => 2, 'info' => FS_UPLOAD_NEW_NOTICE_ONE, 'data' => array()));
            }
        }else{
            del_cancel_order_key($orders_id);
            $api->response(array('status' => 0, 'info' => FS_MANAGE_ORDERS_FILE, 'data' => array()));
        }

        //$from_page = $_POST['from_page']?zen_db_prepare_input($_POST['from_page']):'order_list';
        //$href = $from_page=='order_list'?zen_href_link(FILENAME_MANAGE_ORDERS,'&order_status=purchase','SSL'):'';
        $href = zen_href_link('checkout_success_purchase','orders_id=' . $orders_id,'SSL');
        del_order_key_for_payment($orders_id);
        $api->response(array('status' => 1, 'info' => FS_FILE_UPLOADED_SUCCESS_TXT, 'data' => array(),'href'=>$href));
        break;

    case 'cancel_order'://取消订单
        $orders_id = $_POST['cancel_orderid'] ? (int)zen_db_prepare_input($_POST['cancel_orderid']):0;
        $reason = $_POST['cancel_order_reason'] ? zen_db_prepare_input($_POST['cancel_order_reason']):'';
        $reason_type = $_POST['cancel_order_reason_type'] ? (int)zen_db_prepare_input($_POST['cancel_order_reason_type']) : 0;
        $cancel_reason = $_POST['cancel_order_reason_text'] ? zen_db_prepare_input($_POST['cancel_order_reason_text']) : '';
        if (empty($_SESSION['customer_id'])) {
            $api->response(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login')));
        }

        if(!($orders_id && $reason_type && $reason)){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }

        $orderService = new OrderService();
        // 不是自己的订单，没有权限查看
        if(!$orderService->checkCustomerVisitOrdersLimit($orders_id)){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        $reason_data = array(
            'reason' => $reason,
            'reason_type' => $reason_type,
            'cancel_reason' => $cancel_reason
        );
        //取消订单相关操作
        $cancel_result = $orderService->updateCancelOrderStatus($orders_id, $reason_data);
        if(!$cancel_result){
            $api->response(array('status' => 0, 'info' => FS_SYSTME_BUSY, 'data' => ''));
        }

        //取消新加坡上门服务的流程
        require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
        (new SGInstallerServiceClass())->cancelCase($orders_id,1);

        //获取客户的相关数据
        $customerService = new CustomerService();
        $customerService->setCustomer();
        $customerData = [];
        if(!empty($customerService->currentCustomer)){
            $customerData = $customerService->currentCustomer->toArray();
        }
        //获取客户对应的销售
        $adminService = new AdminService();
        $admin_data = $adminService->getAdminByCustomer($_SESSION['customer_id']);
        $admin_id = 0;
        if(!empty($admin_data)){
            $admin_data = $admin_data->toArray();
            $admin_id = $admin_data['admin_id'];
        }
        $customer_email = $customerData['customers_email_address'];
        $customer_name = $customerData['customers_firstname'];
        $customer_last_name = $customerData['customers_lastname'];
        $customers_country_id = $customerData['customer_country_id'];
        if(!$admin_id){
            $email_address = $customer_email;
            $allot_type='customer_broke';
            require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
            $is_go_auto_given = 1;
            // fairy 2018.8.30 add 针对进行经过自动分配的用户，如果该项分配当前销售。则也要把该用户分配给当前销售
            if ($admin_id && $_SESSION['customer_id'] && $is_go_auto_given) {
                auto_given_customers_to_admin(array(
                    'admin_id' => $admin_id,
                    'email_address' => $customer_email,
                    'admin_id_from_table' => $admin_id_from_table,
                    'customer_id' => $_SESSION['customer_id'], // 注册用户
                    'is_make_up' => $is_make_up ? : 0,
                    'from_auto_file' => 'auto_given',
                    'is_old' => $is_old ? $is_old : 0,     // 标注新、老客户
                    'customer_number' => $customers_customers_number_new,
                    'customer_offline_number' => $offline_customers_number_new,
                    'invalidSign' => $invalidSign,
                ));
            }
        }
        $ordersInfo = $orderService->getOrderInfoByOrderId($orders_id);
        $orders_number = [];
        $products = []; //订单所有产品
        foreach($ordersInfo['son_orders'] as $key=>$orders){
            $orders_number[] = $orders['orders_number'];
            $products = array_merge($orders['products'], $products);
        }
        $tx=" ";
        if($_SESSION['languages_code']=="jp"){
            $tx='';
        }
        $orders_number = implode(' & ',$orders_number);
        $poNum = '';
        if ($ordersInfo['purchase_order_num']) {
            $poNum = '('.FS_ACCOUNT_PO_NUMBER.$ordersInfo['purchase_order_num'].')';
        } elseif($ordersInfo['customers_po']) {
            $poNum = '('.FS_ACCOUNT_PO_NUMBER.$ordersInfo['customers_po'].')';
        }
        $tx_html=FS_SEND_EMAIL_135;
        $title =  FS_SEND_EMAIL_160_01.$orders_number.$poNum.str_replace('.','',$tx_html);
        if ($_SESSION['languages_code'] == "es") {
            $title = FS_SEND_EMAIL_160_01 . $orders_number .$poNum. str_replace('.', '', ' ha sido cancelado');
        }
        get_email_langpac();
        $html = common_email_header_and_footer(FS_SEND_EMAIL_139,FS_SEND_EMAIL_140.$orders_number.$tx_html);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $po_html="";
        if(!empty($ordersInfo['purchase_order_num'])){
            $po_html= '('.FS_SEND_EMAIL_71.'#<a href="javascript:;" style="color: #232323;text-decoration: none">'.$ordersInfo['purchase_order_num'].'</a>)';
        }
        // 给客户发的邮件
        $html_msg['EMAIL_BODY']= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;font-weight:600;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding:0 20px;" align="center">
                                    '.FS_SEND_EMAIL_141.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                                        '.FS_MODIFY_EMAIL_MY_CASE_08.$tx.ucwords($customer_name).' '.ucwords($customer_last_name).''.FS_EMAIL_COMMA.'
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                    <span>'.FS_SEND_EMAIL_160.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('account_history_info','orders_id='.$orders_id).'" >'.$orders_number.'</a>'.$tx.$po_html.$tx_html.'</span>
                                    <br>
                                    <span>'.FS_SEND_EMAIL_142.'</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
        if($products){
            $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;font-weight:600;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;" align="center">
                                    '.FS_SEND_EMAIL_143.'
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20" >
                                </td>
                            </tr>
                            </tbody>
                        </table>';
            $num=count($products)-1;
            foreach ($products as $k=>$v){
                $price = $v['final_price_currency'];
                if($v['products']['show_type']==1){
                    $image_stock= '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="60" height="60">';
                }else{
                    $image_stock = get_resources_img($v['products_id'],60,60,'','','',' style="" ');
                }
                $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;padding-left:20px;" width="60">
                                        <a style="text-decoration: none;" href="'.zen_href_link('product_info','products_id='.$v['products_id']).'">
                                            '.$image_stock.'
                                        </a>
                                    </td>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" height="20">
                                        <a style="text-decoration: none;color: #232323;" href="'.zen_href_link('product_info','products_id='.$v['products_id']).'">
                                            <span>'.$v['products_name'].'<span style="text-decoration: none;color: #999;"> #'.$v['products_id'].'</span></span>
                                        </a>                                    <br>
                                        <span>'.FS_SEND_EMAIL_8.'<span>'.$v['products_quantity'].'</span></span>
                                        <br>
                                        <span>'.FS_SEND_EMAIL_83.'<span>'.$price.'</span></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                if($k<$num){
                    $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="20">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20">
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                }else{
                    $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30">
    
                                    </td>
                                </tr>
                                </tbody>
                            </table>
    
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';
                    }
                }
        }else{
            $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" height="30" >
                                </td>
                            </tr>
                            </tbody>
                        </table><table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse:collapse;font-size:14px;color:#232323;line-height:22px;font-family:Open Sans,arial,sans-serif;padding:0 20px 30px" align="left">
                            '.REGIST_EMAIL_SEND_14.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
        }
        sendwebmail($customer_name, $customer_email, '订单评价成功邮件发送给客户'.$customer_name.date('Y-m-d H:i:s', time()),STORE_NAME,$title,$html_msg,'default');
        if($admin_id){ //给销售发的邮件
            $adminService->setAdmin($admin_id);
            $adminData = [];
            if(!empty($adminService->currentAdmin)){
                $adminData = $adminService->currentAdmin->toArray();
                $admin_name = $adminData['admin_name'];
                $admin_email = $adminData['admin_email'];
                /* email content  helun 客户进行创建问题后发送邮箱给指定销售*/
                sendwebmail($admin_name, $admin_email,'订单评价成功邮件发送给销售'.$admin_name.date('Y-m-d H:i:s', time()), STORE_NAME,  $title, $html_msg,'default');
            }
        }
        send_app_message($orders_id, $_SESSION['customer_id'], 5);
        $api->response(array('status' => 1, 'info' => MANAGE_ORDER_MSG, 'data' => array(),'href'=>''));
        break;

    case 'receipt_confirm'://确认收货
        if (empty($_SESSION['customer_id'])) {
            $api->response(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login')));
        }
        $orders_id = $_POST['orders_id']?(int)zen_db_prepare_input($_POST['orders_id']):0;
        $type = (int)zen_db_prepare_input($_POST['type']);  //type值为1或者1 1是线上单，2是线下单
        if(!$orders_id || !in_array($type,[1,2])){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        if($type==1){   //线上单确认收货
            $orderService = new OrderService();
            // 不是自己的订单，没有权限查看
            if(!$orderService->checkCustomerVisitOrdersLimit($orders_id)){
                $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
            }
            $ordersFields = ['customers_id', 'customers_name', 'customers_email_address', 'language_code'];
            $orderService->setField($ordersFields)->setOrder($orders_id);
            $ordersData = [];
            if(!empty($orderService->currentOrder)){
                $ordersData = $orderService->currentOrder->toArray();
            }
            if($ordersData['main_order_id']==1 || !in_array($ordersData['orders_status'], [3, 12])){
                //如果是有分单的主单，不能确认收货, 订单状态不是已发货状态的也不能确认收货  新版流程已发货状态12，旧版3
                $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
            }
            //确认收货操作
            $result = $orderService->updateReceiptConfirmOrderStatus($orders_id);
            $result = true;
            if($result){//确认收货成功
                //给客户发送评论邀约邮件  邀约邮件取消 2020.11.19 dylan
                /*include(DIR_WS_CLASSES . 'order.php');
                send_customer_and_admin_reviews_email(array(
                    'orders_id' => $orders_id,
                    'language_code' => $ordersData['language_code'],
                    'customers_id' => $ordersData['customers_id'],
                    'customers_name' => $ordersData['customers_name'],
                    'customers_email_address' => $ordersData['customers_email_address'],
                    'order_number' => $ordersData['orders_number']
                ));*/
                $data = array('status' => 1, 'info' => F_RECEIPT_CONFIRMATION_SUCCESS_TIP, 'data' => '');
            }else{
                $data = array('status' => 0, 'info' => 'fail', 'data' => '');
            }
        }else{  //线下单确认收货
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

        }
        $api->response($data);
        break;
    case 'download_mux_pdf': // 下载mux产品pdf
        if (empty($_SESSION['customer_id'])) {
            $api->response(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login')));
        }
        $order_id = (int)zen_db_prepare_input($_POST['order_id']);
        $product_id = (int)zen_db_prepare_input($_POST['product_id']);
        if (!$order_id || !$product_id) {
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        $orderService = new OrderService();
        $file = $orderService->getMuxFile($order_id, $product_id);
        if (empty($file)) {
            $api->response(array('status' => -2, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        $down = new DownloadService();
        $file = $down->packZip($file);
        if (!$file) {
            $api->setStatus(400)->setMessage('error')->response();
        }
        $file_path = HTTPS_IMAGE_SERVER . $file;
        $api->setStatus(200)->setMessage('success')->response($file_path);
        break;

    case 'buy_again':    //整单加购
        $orders_id = (int)zen_db_prepare_input($_POST['orders_id']);
        $type = (int)zen_db_prepare_input($_POST['type']);
        $status = (int)zen_db_prepare_input($_POST['status']);  //status标识客户操作 1点击buy again按钮 2:Skip and Continue 3:Add to Cart
        $cart_quantity = $_POST['cart_quantity'];
        if(!$orders_id || !in_array($type,[1,2])){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        if($status==3 && !count($cart_quantity)){
            //确认加购 却没有产品
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        require_once(DIR_WS_CLASSES.'shipping_info.php');
        $column_products = $close_products = $clearance_products = $clearance_products_no = [];   //不能直接加购的产品
        $is_add = true; //  是否可以整单加入购物车
        $add_products = []; //加入购物车的产品ID
        if($type==1){   //线上单整单加购
            $opService = new OrderProductService();
            //设置产品图片尺寸
            $opService->setImageSize(['size_w'=>80,'size_h'=>80]);
            $productsData = $opService->getOrderProductsInfo($orders_id);
            //获取订单信息
            $orderService = new OrderService();
            $orderData = $orderService->getOrdersFieldsInfo($orders_id, ['orders_id', 'orders_number']);
            $cart_other_info = array('from_orders_number'=>$orderData['orders_number']);
            if(sizeof($productsData)){
                if($status == 3){
                    $productsDataNew = [];
                    //确认加购产品 只加购客户选中的产品
                    $add_key = array_keys($cart_quantity);  //key是orders_products表中的orders_products_id
                    foreach($productsData as $kk=>$vv){
                        if(in_array($vv['orders_products_id'],$add_key)){
                            $vv['products_quantity'] = $cart_quantity[$vv['orders_products_id']];
                            $productsDataNew[] = $vv;
                        }
                    }
                    $productsData = $productsDataNew;
                }
                foreach($productsData as $key=>$products){
                    $products['is_clearance'] = 0;      //是否是清仓产品
                    $products['clearance_qty'] = 0;     //清仓产品数量
                    $config = [];
                    if($products['is_close']){
                        //关闭产品不能加入购物车
                        $is_add = false;
                        $close_products[] = $products;
                    }else{
                        //为了防止订单中定制产品丢失属性的再次加购仍然属性丢失的情况 针对没有属性产品查询其是否有属性
                        if(!$products['is_custom']){
                            $paService = new ProductAttributeService();
                            $lengthTotal = $paService->getProductLengthTotal($products['products_id']);
                            $attributeTotal = $paService->getProductAttributeTotal($products['products_id']);
                            //任意一个属性总数不为0 即为定制产品
                            if($lengthTotal || $attributeTotal){
                                $products['is_custom'] = true;
                            }
                        }
                        if(!$products['is_custom']){
                            //判断是否是清仓产品
                            $is_clearance = get_current_pid_if_is_clearance($products['products_id']);
                            if($is_clearance){
                                $products['is_clearance'] = 1;
                                $config['pid'] = $products['products_id'];
                                $shipping_info = new ShippingInfo($config);
                                $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存
                                $products['clearance_qty'] = $clearance_qty;
                                //判断当前产品是否已经在购物车中
                                if($_SESSION['cart']->in_cart($products['products_id'])){
                                    $cart_qty = $_SESSION['cart']->contents[$products['products_id']]['qty'];//加购数量
                                    if($clearance_qty>=$cart_qty){
                                        //清仓产品数量 需要减掉购物车中已加购的产品数据
                                        $clearance_qty = $clearance_qty - $cart_qty;
                                    }else{
                                        $clearance_qty = 0;
                                    }
                                }
                                if($clearance_qty>=$products['products_quantity']){
                                    //清仓产品库存大于或者等于当前产品个数允许直接加购
                                    if($status==3){
                                        $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0, $cart_other_info);
                                    }
                                    $add_products[] = $products;
                                }else{
                                    $is_add = false;
                                    if($clearance_qty==0){
                                        //清仓产品无库存
                                        $clearance_products_no[] = $products;
                                    }else{
                                        //清仓产品库存不足
                                        $products['products_quantity'] = $clearance_qty;
                                        $clearance_products[] = $products;
                                        $add_products[] = $products;
                                        //将现有的库存数量的清仓产品加入购物车
                                        if($status==3){
                                            $_SESSION['cart']->add_cart($products['products_id'], $clearance_qty, '', true, [], 0, $cart_other_info);
                                        }
                                    }
                                }
                            }else{
                                //标准产品直接加入购物车
                                if($status==3) {
                                    $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0, $cart_other_info);
                                }
                                $add_products[] = $products;
                            }
                        }else{
                            //针对缺少属性的定制产品直接不让加购
                            if(empty($products['orders_products_length']) && empty($products['orders_products_attributes'])){
                                $is_add = false;
                                $column_products[] = $products;
                            }else{
                                //判断是否是层级属性定制产品
                                $column_id = zen_get_products_column_id($products['products_id']);
                                //验证当前产品的属性是否发生变化
                                $newAttr = $opService->resetAttributesInfo($products);
                                $attrService = new App\Services\Products\ProductAttributeService;
                                $isValid = $attrService->checkProductsAttributesValid($products['products_id'], $newAttr);
                                if(!$column_id && $isValid){
                                    //不是层级属性且当前属性都存在的才可以加购
                                    if($status==3) {
                                        $real_ids = $opService->createAttributeForAddCart($products);
                                        $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], $real_ids, true, [], 0, $cart_other_info);
                                    }
                                    $add_products[] = $products;
                                }else{
                                    $is_add = false;
                                    $column_products[] = $products;
                                }
                            }
                        }
                    }
                }
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                $shopping_cart_help = new shopping_cart_help();
                $html = $topCartHtml = '';
                $noAddProducts = [];
                if($status==1){
                    $noAddProducts['close'] = $close_products;
                    $noAddProducts['custom'] = $column_products;
                    $noAddProducts['clearance'] = $clearance_products;
                    $noAddProducts['clearance_no'] = $clearance_products_no;
                   //客户第一次点击订单列表页的buy again按钮
                    if($is_add){
                        //可以整单加购 展示加购弹框
                        $html = createBuyAgainAddProductsHtml($add_products,$orderData,$type);
                    }else{
                        //有不能加购的产品
                        if(!count($add_products)){
                            //整单产品都不能加购
                            $html = createBuyMoreProductsHtml($noAddProducts,$orders_id,$type,false);
                        }else{
                            //部分产品不能加购
                            $html = createBuyMoreProductsHtml($noAddProducts,$orders_id,$type);
                        }
                    }
                }elseif($status==2){
                    //给客户展示不能加购的产品 客户点击skip and continue按钮确认加购 展示可以加购的产品弹窗 供客户修改数量
                    $html = createBuyAgainAddProductsHtml($add_products,$orderData,$type);
                }else{
                    //客户点击add to cart按钮加购
                    $topCartHtml = $shopping_cart_help->show_cart_products_block();
                    //产品加购成功弹窗
                    $html = products_add_cart_new_popup();
                }
                $data = array('result' => true, 'type'=>2, 'html' => $html, 'topCartHtml'=>$topCartHtml);
                $api->response($data);
            }
        }else { //线下单整单加购 线下单暂时没给buy again入口
            $opService = new OrderProductService();
            $spService = new OrderSplitProductService();
            $spService->setImageSize(['size_w'=>80,'size_h'=>80]);
            $productsData = $spService->getOrderProductsInfo($orders_id);
            //获取订单信息
            $splitService = new OrderService();
            $orderData = $splitService->getOrdersFieldsInfo($orders_id, ['orders_id', 'orders_number']);
            $cart_other_info = array('from_orders_number'=>$orderData['orders_number']);
            if(sizeof($productsData)){
                if($status == 3){
                    $productsDataNew = [];
                    //确认加购产品 只加购客户选中的产品
                    $add_key = array_keys($cart_quantity);  //key是orders_products表中的orders_products_id
                    foreach($productsData as $kk=>$vv){
                        if(in_array($vv['orders_products_id'],$add_key)){
                            $vv['products_quantity'] = $cart_quantity[$vv['orders_products_id']];
                            $productsDataNew[] = $vv;
                        }
                    }
                    $productsData = $productsDataNew;
                }
                foreach($productsData as $key=>$products){
                    $products['is_clearance'] = 0;      //是否是清仓产品
                    $products['clearance_qty'] = 0;     //清仓产品数量
                    $config = [];
                    if($products['is_close']){
                        //关闭产品不能加入购物车
                        $is_add = false;
                        $close_products[] = $products;
                    }else{
                        //为了防止订单中定制产品丢失属性的再次加购仍然属性丢失的情况 针对没有属性产品查询其是否有属性
                        if(!$products['is_custom']){
                            $paService = new ProductAttributeService();
                            $lengthTotal = $paService->getProductLengthTotal($products['products_id']);
                            $attributeTotal = $paService->getProductAttributeTotal($products['products_id']);
                            //任意一个属性总数不为0 即为定制产品
                            if($lengthTotal || $attributeTotal){
                                $products['is_custom'] = true;
                            }
                        }
                        if(!$products['is_custom']){
                            //判断是否是清仓产品
                            $is_clearance = get_current_pid_if_is_clearance($products['products_id']);
                            if($is_clearance){
                                $products['is_clearance'] = 1;
                                $config['pid'] = $products['products_id'];
                                $shipping_info = new ShippingInfo($config);
                                $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存
                                $products['clearance_qty'] = $clearance_qty;
                                //判断当前产品是否已经在购物车中
                                if($_SESSION['cart']->in_cart($products['products_id'])){
                                    $cart_qty = $_SESSION['cart']->contents[$products['products_id']]['qty'];//加购数量
                                    if($clearance_qty>=$cart_qty){
                                        //清仓产品数量 需要减掉购物车中已加购的产品数据
                                        $clearance_qty = $clearance_qty - $cart_qty;
                                    }else{
                                        $clearance_qty = 0;
                                    }
                                }
                                if($clearance_qty>=$products['products_quantity']){
                                    //清仓产品库存大于或者等于当前产品个数允许直接加购
                                    if($status==3){
                                        $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0, $cart_other_info);
                                    }
                                    $add_products[] = $products;
                                }else{
                                    $is_add = false;
                                    if($clearance_qty==0){
                                        //清仓产品无库存
                                        $clearance_products_no[] = $products;
                                    }else{
                                        //清仓产品库存不足
                                        $products['products_quantity'] = $clearance_qty;
                                        $clearance_products[] = $products;
                                        $add_products[] = $products;
                                        //将现有的库存数量的清仓产品加入购物车
                                        if($status==3){
                                            $_SESSION['cart']->add_cart($products['products_id'], $clearance_qty, '', true, [], 0, $cart_other_info);
                                        }
                                    }
                                }
                            }else{
                                //标准产品直接加入购物车
                                if($status==3) {
                                    $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0, $cart_other_info);
                                }
                                $add_products[] = $products;
                            }
                        }else{
                            //针对缺少属性的定制产品直接不让加购
                            if(empty($products['orders_products_length']) && empty($products['orders_products_attributes'])){
                                $is_add = false;
                                $column_products[] = $products;
                            }else{
                                //判断是否是层级属性定制产品
                                $column_id = zen_get_products_column_id($products['products_id']);
                                if(!$column_id){
                                    //层级属性产品不允许直接加入购物车
                                    if($status==3) {
                                        $real_ids = $opService->createAttributeForAddCart($products);
                                        $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], $real_ids, true, [], 0, $cart_other_info);
                                    }
                                    $add_products[] = $products;
                                }else{
                                    $is_add = false;
                                    $column_products[] = $products;
                                }
                            }
                        }
                    }
                }
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                $shopping_cart_help = new shopping_cart_help();
                $html = $topCartHtml = '';
                $noAddProducts = [];
                if($status==1){
                    $noAddProducts['close'] = $close_products;
                    $noAddProducts['custom'] = $column_products;
                    $noAddProducts['clearance'] = $clearance_products;
                    $noAddProducts['clearance_no'] = $clearance_products_no;
                    //客户第一次点击订单列表页的buy again按钮
                    if($is_add){
                        //可以整单加购 展示加购弹框
                        $html = createBuyAgainAddProductsHtml($add_products,$orderData,$type);
                    }else{
                        //有不能加购的产品
                        if(!count($add_products)){
                            //整单产品都不能加购
                            $html = createBuyMoreProductsHtml($noAddProducts,$orders_id,$type);
                        }else{
                            //部分产品不能加购
                            $html = createBuyMoreProductsHtml($noAddProducts,$orders_id,$type);
                        }
                    }
                }elseif($status==2){
                    //给客户展示不能加购的产品 客户点击skip and continue按钮确认加购 展示可以加购的产品弹窗 供客户修改数量
                    $html = createBuyAgainAddProductsHtml($add_products,$orderData,$type);
                }else{
                    //客户点击add to cart按钮加购
                    $topCartHtml = $shopping_cart_help->show_cart_products_block();
                    //产品加购成功弹窗
                    $html = products_add_cart_new_popup();
                }
                $data = array('result' => true, 'type'=>2, 'html' => $html, 'topCartHtml'=>$topCartHtml);
                $api->response($data);
            }
        }
        break;
    case 'get_track_info':
        $shipping_method = $_POST["shipping_method"] ? zen_db_prepare_input($_POST["shipping_method"]):'';
        $track_number = $_POST["track_number"] ? zen_db_prepare_input($_POST["track_number"]):'';
        $orders_id = (int)zen_db_prepare_input($_POST["orders_id"]);
        $type = (int)zen_db_prepare_input($_POST["type"]);
        if($orders_id && $shipping_method && $track_number){
            $html = getOrdersTrackInfo($shipping_method,$track_number, $orders_id, $type);
            $data = array('result' => true, 'html' => $html);
            $api->response($data);
        }else{
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        break;
    case 'get_more_orders':
        $type = zen_db_prepare_input($_POST["type"]);
        $more = zen_db_prepare_input($_POST["more"]);   //为1 代表获取第一条订单 2代表获取除第一条以外的所有订单
        if(!in_array($type,['pending','shipping','transit','completed'])){
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }
        $orderService = new OrderService();
        $orderParam = ['orders_status'=>$type];
        $limit = [];
        $moreHtml = '';
        //当前订单的总数量
        $ordersTotal = $orderService->getOrdersList($orderParam, [], true);
        if($more==1){   //只展示第一条
            $limit['num'] = 1;
            if($ordersTotal>1){
                $moreHtml = '<a  href="javascript:;" onclick="showMoreOrders(\''.$type.'\',2)">
													<span>'.FS_ACCOUNT_TW_SHOW_MORE.'</span>
													<i class="iconfont icon">&#xf087;</i>
												</a>';
            }
        }else{
            $limit['start'] = 1;
            $limit['num'] = 4;
            if($ordersTotal>5){
                $moreHtml = '<a class="fs_public_a" href="'.zen_href_link('manage_orders','order_status='.$type).'"><span>'.FS_ACCOUNT_TW_VIEW_ORDERS.'</span><i class="iconfont icon">&#xf089;</i></a>';
            }
        }
        $ordersData = $orderService->getOrdersList($orderParam, $limit, false, false , true);
        $ordersCount = count($ordersData);
        if($ordersCount){
            $html = createCommonOrdersHtml($ordersData);
        }else{
            //没有满足条件的订单
            if($more==1) {
                $html = '<div class="RMA_empty">
                            <p class="empty_tit">'.FS_ACCOUNT_TW_NO_ORDER.'</p>
                            <a class="fs_account_btn account_gray" href="'.zen_href_link('index').'">'.QUOTE_EMPTY_2.'</a>
                        </div>';
            }
        }
        $data = array('result' => true, 'html' => $html, 'moreHtml'=>$moreHtml, 'number'=>$ordersCount);
        $api->response($data);
        break;
}