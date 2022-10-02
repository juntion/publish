<?php
/**
 * Created by PhpStorm.
 * User: rebirth
 * Date: 2019/08/19
 */

$action = zen_not_null($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : "";
/**
 * code
 * 0 请求成功
 * 1 请求失败
 */
switch ($action) {
    case "check_order_overtime":
        require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '.php'); // 调用公共的语言包
        $order_id = abs((int)$_POST['mid']); //主单id
        $reload = true;
        $str = '';
        $notice = '';
        $orderOvertime = fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $order_id, "*");
        if (zen_not_null($orderOvertime['addtime'])) {
            $reload = false;
            $timeless = $orderOvertime['addtime'] - time();
            $str = get_order_countdowm_str($timeless);
//            selectRedisDB(2);
//            $code = get_redis_key_value($order_id . "_orders_payment_module_code");
//            selectRedisDB(0);
//            if ($code) {
//                $notice = get_payment_notice_string($code);
//            }
        }
        echo json_encode([
            "code"   => 1,
            "reload" => $reload,
            "str"    => $str,
            "notice" => $notice
        ]);
        break;
    case "just_pay_now":
        require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '.php'); // 调用公共的语言包
        $order_id = abs((int)$_POST['mid']); //主单id
        $button = zen_db_prepare_input($_POST['button']);
        $jump = false;
        $url = zen_href_link('manage_orders', '', 'SSL');
        if (can_change_order_status($order_id) && set_cancel_order_key($order_id)) {
            $jump = true;
            if ($button == "pay") {
                $url = zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST, '', 'SSL');
                $url .= '&orders_id=' . intval($order_id);
            }
            del_cancel_order_key($order_id);
        }
        echo json_encode([
            "code" => 1,
            "jump" => $jump,
            "url"  => $url
        ]);
        break;
    case "cancel_order":
        set_time_limit(0);
        $key = zen_db_prepare_input($_POST["key"] ?: "");
        if (defined("USE_CANCEL_ORDER_SECRET") && USE_CANCEL_ORDER_SECRET === true) {
            if (CANCEL_ORDER_SECRET_KET !== $key) {
                set_data(2);
            }
            $ip = getIp();
            if (CANCEL_ORDER_ACCESS_IP !== $ip) {
                set_data(3);
            }
        }
        $id = abs((int)($_POST['id'] ?: 0));
        $orders_id = abs((int)($_POST['orders_id'] ?: 0));
        $type = abs((int)($_POST['type'] ?: 0));
        $orderOvertime = fs_get_one_data(TABLE_ORDERS_OVERTIME, " id=" . $id);
        if ($orders_id != $orderOvertime['orders_id'] || $type != $orderOvertime['type']) {
            set_data(4);
        }
        $fields = "orders_id,orders_status,purchase_order_num,language_id,customers_id,orders_number,currency,currency_value,shipping_method,language_code,delivery_country_id,payment_module_code";
        $where = "( main_order_id = $orders_id or orders_id = $orders_id ) ORDER BY orders_id DESC ";
        $allOrders = fs_get_datas(TABLE_ORDERS, $where, $fields);
        $son_order = array();
        if (!count($allOrders)) {
            set_data(5);
        }
        $time = time();
        $cancel_request = [];
        $order_status_history = [];
        $orders_overtime_change_logo = [];
        $order_data = [];
        $orders_number = [];
        foreach ($allOrders as $oneOrder) {
            if (strcmp($oneOrder['orders_status'], 1)) {
                set_data(6);
            }
            $son_order[$oneOrder['orders_id']] = $oneOrder['orders_id'];
            if ($oneOrder['orders_id'] == $orders_id) {
                $purchase_order_num = $oneOrder['purchase_order_num'];
                $_SESSION['languages_id'] = $oneOrder['language_id'];
                $customers_id = $oneOrder['customers_id'];
                $order_data = $oneOrder;
            } else {
                $orders_number[$oneOrder['orders_id']] = $oneOrder['orders_number'];
            }
            $cancel_request[] = array(
                'orders_id'     => $oneOrder['orders_id'],
                'reason'        => "Others",
                'cancel_reason' => "order is canceled by system automatically for timeout unpaid 处理人:system",
                'languages_id'  => $oneOrder['language_id'],
                'request_date'  => 'now()',
                'reason_type'   => 9
            );
            // fairy 2019.2.21 添加订单状态流程的取消流程
            $order_status_history[] = array(
                'orders_id'         => $oneOrder['orders_id'],
                'orders_status_id'  => 5,
                'date_added'        => 'now()',
                'customer_notified' => "",
                'comments'          => "order is canceled by system automatically for timeout unpaid 处理人:system",
            );
            $orders_overtime_change_logo[] = [
                'orders_id' => $oneOrder['orders_id'],
                'addtime'   => $time,
                'datetime'  => 'now()',
                'old'       => $oneOrder['orders_status'],
                'new'       => 5,
            ];
        }
        $son_order_str = implode(',', $son_order);
        if (empty($orders_number)) {
            $orders_number[$order_data['orders_id']] = $order_data['orders_number'];
        }
        $orders_number_str = implode(' & ', $orders_number);
        $customerInfo = fs_get_one_data(TABLE_CUSTOMERS, " customers_id =" . $customers_id, "customer_country_id,customers_email_address,customers_firstname,customers_lastname");
        $customer_email = $customerInfo['customers_email_address'];
        $customer_name = $customerInfo['customers_firstname'];
        $customer_last_name = $customerInfo['customers_lastname'];
        require_once(DIR_WS_LANGUAGES . getLanguages($order_data['language_code']) . '.php'); // 调用公共的语言包
        $country = fs_get_one_data(TABLE_COUNTRIES, " countries_id=" . $order_data['delivery_country_id'], "countries_iso_code_2");
        $_SESSION["countries_code_21"] = strtoupper($country['countries_iso_code_2']);
        $_SESSION["customer_id"] = $customers_id;
        $_GET['lang'] = ($order_data['language_code'] == "dn") ? "de-en" : $order_data['language_code'];
        if ($type === 1) {
//            $order =   fs_get_one_data(TABLE_ORDERS, " orders_id= " . $orders_id, "orders_status");
            $res = set_cancel_order_key($orders_id);
            if (!$res) {
                set_data(7);
            }
            global $db;
            //开启事务
            $db->Execute("START TRANSACTION");
            $update_sql = "  update " . TABLE_ORDERS . " set orders_status = 5 where orders_id in (" . $son_order_str . ")";
            $update = $db->Execute($update_sql);
            $ins1 = zen_db_inserts(TABLE_ORDERS_CANCEL_REQUEST, $cancel_request);
            $ins2 = zen_db_inserts(TABLE_ORDERS_STATUS_HISTORY, $order_status_history);
            $ins3 = zen_db_inserts(TABLE_ORDERS_OVERTIME_CHANGE_LOGO, $orders_overtime_change_logo);
            //恢复前台的库存锁定
            $del_sql = "DELETE FROM products_instock_orders  WHERE orders_id in (" . $son_order_str . ")";
            //取消新加坡上门服务的流程
            require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
            (new SGInstallerServiceClass())->cancelCase($orders_id, 2);
            $del = $db->Execute($del_sql);
            $final = ($update && $ins1 && $ins2 && $ins3 && $del);
            if (!$final) {
                $db->Execute("ROLLBACK");
                del_cancel_order_key($orders_id);
                set_data(8);
            } else {
                del_cancel_order_key($orders_id);
                $db->Execute("COMMIT");
            }
            $admin_id = 0;
            if ($customers_id) {
                $admin_id = zen_get_customer_has_allot_to_admin($customers_id);
                $customers_country_id = $customerInfo['customer_country_id'];
                if (!$admin_id) {
                    $email_address = $customer_email;
                    $allot_type = 'customer_broke';
                    require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                    $is_go_auto_given = 1;
                    // fairy 2018.8.30 add 针对进行经过自动分配的用户，如果该项分配当前销售。则也要把该用户分配给当前销售
                    if ($admin_id && $customers_id && $is_go_auto_given) {
                        auto_given_customers_to_admin(array(
                            'admin_id'            => $admin_id,
                            'email_address'       => $customerInfo['customers_email_address'],
                            'admin_id_from_table' => $admin_id_from_table,
                            'customer_id'         => $customers_id, // 注册用户
                            'is_make_up'          => $is_make_up ?: 0,
                            'from_auto_file'      => 'auto_given',
                            'is_old'              => $is_old ? $is_old : 0,     // 标注新、老客户
                            'customer_number' => $customers_customers_number_new,
                            'customer_offline_number' => $offline_customers_number_new,
                            'invalidSign' => $invalidSign,
                        ));
                    }
                }
            }
            $tx = " ";
            if ($order_data['language_code'] == "jp") {
                $tx = '';
            }
            $tx_html = FS_SEND_EMAIL_135;
            if ($order_data['language_code'] == "es") {
                $tx_html = ' ha sido cancelado. Lamentamos cualquier tipo de incoveniencia.';
            }
            $title = FS_SEND_EMAIL_160 . $orders_number_str . str_replace('.', '', $tx_html);
            get_email_langpac();
            $html = common_email_header_and_footer(FS_SEND_EMAIL_139, FS_SEND_EMAIL_140 . $orders_number_str . $tx_html);
            $html_msg['EMAIL_HEADER'] = $html['header'];
            $html_msg['EMAIL_FOOTER'] = $html['footer'];
            $po_html = "";
            if (!empty($purchase_order_num[0]['purchase_order_num'])) {
                $po_html = '(' . FS_SEND_EMAIL_71 . '#<a href="javascript:;" style="color: #232323;text-decoration: none">' . $purchase_order_num[0]['purchase_order_num'] . '</a>)';
            }
            // 给客户发的邮件
            $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                                    ' . FS_SEND_EMAIL_141 . '
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
                                        ' . FS_MODIFY_EMAIL_MY_CASE_08 . " " . $tx . ucwords($customer_name) . ' ' . ucwords($customer_last_name) . '' . FS_EMAIL_COMMA . ' 
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
                                    <span>' . FS_SEND_EMAIL_160 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $orders_id) . '" >' . $orders_number_str . '</a>' . $tx . $po_html . $tx_html . '</span>
                                    <br>
                                    <span>' . FS_SEND_EMAIL_142 . '</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
            $products = fs_get_datas(TABLE_ORDERS_PRODUCTS, "orders_id in (" . $son_order_str . ")", "products_id,products_name,final_price,products_quantity");
            if ($products) {
                $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                                    ' . FS_SEND_EMAIL_143 . '
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
                global $currencies;
                $num = count($products) - 1;
                foreach ($products as $k => $v) {
                    $price = $currencies->total_format($v['final_price'] * getVat($order_data["language_code"]), true, $order_data["currency"], $order_data["currency_value"]);
                    $product_category_status = get_product_category_status((int)$v['products_id']);
                    if ($product_category_status == 1) {
                        $image_stock = '<img src="' . HTTPS_IMAGE_SERVER . 'includes/templates/fiberstore/images/logo_trad.jpg" width="60" height="60">';
                    } else {
                        $image_stock = get_resources_img($v['products_id'], 60, 60, '', '', '', ' style="" ');
                    }
                    $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;padding-left:20px;" width="60">
                                    <a style="text-decoration: none;" href="' . zen_href_link('product_info', 'products_id=' . $v['products_id']) . '">
                                        ' . $image_stock . '
                                    </a>
                                </td>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" height="20">
                                    <a style="text-decoration: none;color: #232323;" href="' . zen_href_link('product_info', 'products_id=' . $v['products_id']) . '">
                                        <span>' . $v['products_name'] . '<span style="text-decoration: none;color: #999;"> #' . $v['products_id'] . '</span></span>
                                    </a>                                    <br>
                                    <span>' . FS_SEND_EMAIL_8 . '<span>' . $v['products_quantity'] . '</span></span>
                                    <br>
                                    <span>' . FS_SEND_EMAIL_83 . '<span>' . $price . '</span></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                    if ($k < $num) {
                        $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                    } else {
                        $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
            } else {
                $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                            ' . REGIST_EMAIL_SEND_14 . '
                        </td>
                    </tr>
                    </tbody>
                </table>';
            }
            sendwebmail($customer_name, $customer_email, '订单取消成功邮件发送给客户' . $customer_name . date('Y-m-d H:i:s', $time), STORE_NAME, $title, $html_msg, 'default');
            if ($admin_id) { //给销售发的邮件
                $adminInfo = fs_get_one_data(TABLE_ADMIN, "admin_id=" . $admin_id, "admin_name,admin_email");
                /* email content  helun 客户进行创建问题后发送邮箱给指定销售*/
                sendwebmail($adminInfo['admin_name'], $adminInfo["admin_email"], '订单取消成功邮件发送给销售' . $adminInfo['admin_name'] . date('Y-m-d H:i:s', $time), STORE_NAME, $title, $html_msg, 'default');
            }
            // 发送取消订单得推送到APP
            foreach($son_order as $order_id){
                send_app_message($order_id, $customers_id, 5);
            }
        } else if ($order_data['payment_module_code'] != 'echeck') {
            //发送提醒邮件
            if (count($son_order) >= 2) { //如果只有一单，则认为该单是整单，否则删除分单里的主单id
                unset($son_order[$orders_id]);
            }
            $totals = fs_get_datas(TABLE_ORDERS_TOTAL, " class='ot_total' and orders_id in (" . implode(",", $son_order) . ")", "orders_id,text");
            $ordersStr = [];
            foreach ($totals as $total) {
                $ordersStr[] = "#" . $orders_number[$total['orders_id']] . " (" . trim($total['text']) . ")";
            }
            $noticeTime = get_payment_notice_string_notice_time($order_data["payment_module_code"], "notice");
            $link = zen_href_link(FILENAME_MANAGE_ORDERS, '&order_status=pending', 'SSL');
            //邮件主题
            $title = FS_ORDERS_OVERTIMES_36;
            //设置语言包
            get_email_langpac();
            //邮件头尾
            $html = common_email_header_and_footer(FS_ORDERS_OVERTIMES_23, $title);
            $html_msg['EMAIL_HEADER'] = $html['header'];
            $html_msg['EMAIL_FOOTER'] = $html['footer'];
            if (in_array($order_data['language_code'],array('es','mx')) || in_array($_SESSION['languages_code'],array('es','mx'))) {
                $html_msg['EMAIL_BODY'] = '
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0;background-color: #fff" align="left">
                            ' . FS_MODIFY_EMAIL_MY_CASE_08 . " " . $tx . ucwords($customer_name) . ' ' . ucwords($customer_last_name) . '' . FS_EMAIL_COMMA . '
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="15">
        
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                            ' . FS_ORDERS_OVERTIMES_24 . implode(", ", $ordersStr) . FS_ORDERS_OVERTIMES_28 . $link . FS_ORDERS_OVERTIMES_29 . $noticeTime . '.' . '
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="15">
        
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDERS_OVERTIMES_25 . '
                        </td>
                    </tr>
                </tbody>
            </table>';
            } else {
            $html_msg['EMAIL_BODY'] = '
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0;background-color: #fff" align="left">
                            ' . FS_MODIFY_EMAIL_MY_CASE_08 . " " . $tx . ucwords($customer_name) . ' ' . ucwords($customer_last_name) . '' . FS_EMAIL_COMMA . '
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="15">
        
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                            ' . FS_ORDERS_OVERTIMES_24 . implode(", ", $ordersStr) . FS_ORDERS_OVERTIMES_27 . $noticeTime . FS_ORDERS_OVERTIMES_28 . $link . FS_ORDERS_OVERTIMES_29 . '
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="15">
        
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDERS_OVERTIMES_25 . '
                        </td>
                    </tr>
                </tbody>
            </table>';
            }
            if ($order_data["language_code"] != "jp" && $_SESSION['languages_code'] != 'jp') {
                $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="15">

                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDERS_OVERTIMES_26 . '
                        </td>
                    </tr>
                </tbody>
            </table>';
            }
            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="15">

                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                            ' . REGIST_COM_EMAIL_UPGRADE_04 . '
                        </td>
                    </tr>
                    </tbody>
            </table>
            ';
            sendwebmail($customer_name, $customer_email, '订单取消提醒邮件发送给客户' . $customer_name . date('Y-m-d H:i:s', $time), STORE_NAME, $title, $html_msg, 'default');
        }
        set_data(1);
        break;
    default:
        echo json_encode([
            "code" => 0,
        ]);
}

/**
 * 针对订单取消脚本设置统一返回
 *
 * @param int $code
 */
function set_data($code = 0)
{
    $messages = [
        '2' => "key值不對",
        '3' => "ip值不對",
        '4' => "未从数据库找到对应的id与type值",
        '5' => "未从订单表里找到对应订单",
        '6' => "订单状态不是1，不能更改",
        '7' => "当前订单正在被别的流程处理",
        '8' => "数据库更新失败",
    ];
    echo json_encode(
        [
            "code"    => $code,
            "message" => isset($messages[$code]) ? $messages[$code] : "success",
            "ip"      => getIp(),
        ]
    );
    exit();
}

/**
 * 获取下单的语言包
 *
 * @param string $code
 * @return string
 */
function getLanguages($code = "en")
{
    $languages = [
        'ru'      => "russian",
        'fr'      => "france",
        'es'      => "Spanish",
        'mx'      => "Spanish",
        'jp'      => "japan",
        'sg'      => "english",
        'au'      => "australia",
        'uk'      => "britain",
        'de'      => "german",
        'de-en'   => "german_en",
        'en'      => "english",
        'default' => "english",
    ];
    if ($code == "dn") {
        $code = "de-en";
    }
    return (isset($languages[$code])) ? $languages[$code] : $languages["en"];

}

/**
 * 获取站点的vat值
 *
 *
 * @param $code
 * @return int
 */
function getVat($code)
{
    $languages = [
        'de' => 1.19,
        'dn' => 1.19,
        'au' => 1.10,
        'uk' => 1.05,
    ];
    if ($code == "de-en") {
        $code = "dn";
    }
    return (isset($languages[$code])) ? $languages[$code] : 1;
}