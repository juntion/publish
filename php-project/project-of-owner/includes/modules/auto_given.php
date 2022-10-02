<?php

//$customers_country_id  客户国家
//$allot_type  询盘类型
//$language_id  语种
//$email_address  客户邮箱
//$continent    所属大洲：1亚洲、2北美洲、3欧洲、4非洲、5大洋洲、6南美洲、7南极洲
//$customerArea 所属区域：1. 美洲区。2. 欧洲区 。3. 亚非区。4. 大洋洲
/*if($customers_country_id){
    $continents = $db->Execute("select continents from countries where countries_id = ".$customers_country_id);
    $continent = $continents->fields['continents'] ? $continents->fields['continents'] : 2;
}else{
    $continent = 2;
}*/
if ($language) {
    $language_id = $language;
} else {
    $language_id = $_SESSION['languages_id'];
}

if (!in_array($language_id, ['1', '2', '3', '4', '5', '8', '14'])) {
    $language_id = '1';
}
$orders_id = isset($orders_id) ? $orders_id : '';


if (!empty($email_address)){
    // 无效客户的类型为1、3的时候不分配 不是的时候重新分配；同时考虑线上表和线上表同时有数据的情况
    $customers_info = fs_get_data_from_db_fields_array(['customers_number_new', 'is_disabled', 'customers_id'], 'customers', "customers_email_address = '" .$email_address."'", 'limit 1');
    $offline_info = fs_get_data_from_db_fields_array(['admin_id', 'customers_number_new', 'is_disabled', 'customers_id'], 'customers_offline', "customers_email_address = '" .$email_address."'", 'limit 1');
    $customers_customers_number_new = $customers_info[0][0] ? $customers_info[0][0] : '';
    $offline_customers_number_new = $offline_info[0][1] ? $offline_info[0][1]: '';
    $invalidSign = 0;  //标记当前客户是否是无效客户
// 线上线下表都有数据，并且一种一个是无效、一个是有效客户
    if ($customers_info[0][1] > 0 && $offline_info[0][2] > 0) {
        $invalidSign = 1;
        $cus_number_new = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', "customers_number_new = '" . $customers_customers_number_new . "'", 'limit 1');
        $off_number_new = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', "customers_number_new = '" . $offline_customers_number_new . "'", 'limit 1');
        if (in_array($cus_number_new, [1, 3])) {
            $arr1 = ['admin_id' => 0];
            $ret2 = zen_db_perform('admin_to_customers', $arr1, 'update', 'customers_id="' . $customers_info[0][2] . '"');
            $arr = ['is_disabled' => 0];
            $ret = zen_db_perform('customers', $arr, 'update', 'customers_email_address="' . $email_address . '"');
        }
        if (in_array($off_number_new, [1, 3])) {
            $arr = ['is_disabled' => 0, 'admin_id' => 0];
            $ret = zen_db_perform('customers_offline', $arr, 'update', 'customers_email_address="' . $email_address . '"');
        }
    } elseif (($customers_info[0][1] > 0 && $offline_info[0][2] == 0 && !empty($offline_info))) {
        $invalidSign = 1;
        $arr = ['is_disabled' => 0];
        $customers_number_new = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', "customers_number_new = '" . $customers_customers_number_new . "'", 'limit 1');

        if (in_array($customers_number_new, [1, 3])) {
            $arr = ['is_disabled' => 0];
            $arr1 = ['admin_id' => 0];
            $ret = zen_db_perform('customers', $arr, 'update', 'customers_email_address="' . $email_address . '"');
            $ret2 = zen_db_perform('admin_to_customers', $arr1, 'update', 'customers_id="' . $customers_info[0][2] . '"');
        }
    } elseif ($customers_info[0][1] == 0 && $offline_info[0][2] > 0 && !empty($customers_info)) {
        $invalidSign = 1;
        $arr = ['admin_id' => 0, 'is_disabled' => 0];
        $customers_number_new = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', "customers_number_new = '" . $offline_customers_number_new . "'", 'limit 1');
        //$ret = zen_db_perform('customers_offline', $arr, 'update', 'customers_email_address="' . $email_address . '"');
        if (in_array($customers_number_new, [1, 3])) {
            //$arr = ['admin_id' => 0];
            $ret = zen_db_perform('customers_offline', $arr, 'update', 'customers_email_address="' . $email_address . '"');
        }
    } elseif ($customers_info[0][1] > 0 && empty($offline_info)) {
        $invalidSign = 1;
        $customers_number_new = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', "customers_number_new = '" . $customers_customers_number_new . "'", 'limit 1');
        if (in_array($customers_number_new, [1, 3])) {
            $arr = ['is_disabled' => 0];
            $ret = zen_db_perform('customers', $arr, 'update', 'customers_email_address="' . $email_address . '"');
            $arr1 = ['admin_id' => 0];
            $ret2 = zen_db_perform('admin_to_customers', $arr1, 'update', 'customers_id="' . $customers_info[0][2] . '"');
        }
    } elseif ($offline_info[0][2] > 0 && empty($customers_info)) {
        $invalidSign = 1;
        $offline_number_new = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', "customers_number_new = '" . $offline_customers_number_new . "'", 'limit 1');
        if (in_array($offline_number_new, [1, 3])) {
            $arr = ['is_disabled' => 0, 'admin_id' => 0];
            $ret = zen_db_perform('customers_offline', $arr, 'update', 'customers_email_address="' . $email_address . '"');
        }
    }
}
/*switch ($continent){
    case '1':
        $customerArea = 3;
        break;
    case '2':
        $customerArea = 1;
        break;
    case '3':
        $customerArea = 2;
        break;
    case '4':
        $customerArea = 3;
        break;
    case '5':
        $customerArea = 4;
        break;
    case '6':
        $customerArea = 1;
        break;
    case '7':
        $customerArea = 1;
        break;
    default:
        $customerArea = 1;
}*/

/*邮箱完全匹配开始*/
// fairy 2018.8.30 修改,只根据线上客户和线下客户来判断。
// 业务因为：如果一个客户提问一个QA，把这个客户分配一个销售，该销售把一个客户丢到公海。下次分配不想再次在把该客户分配给当时的销售。
// 2019.1.26 fairy add 排除无效客户
if (!$admin_id) {
    $email_sql = 'SELECT c.customers_id,atc.admin_id  FROM customers c inner join admin_to_customers atc on(c.customers_id=atc.customers_id) where atc.admin_id is not null and c.customers_email_address ="' . $email_address . '" and c.is_disabled = 0';
    $email_res = $db->Execute($email_sql);
    $admin_id = $email_res->fields['admin_id'];
    $admin_id_from_table = 'admin_to_customers';
}

if (!$admin_id) {
    $email_sql = 'SELECT admin_id  FROM customers_offline where admin_id != 0 and customers_email_address = "' . $email_address . '" and is_disabled = 0';
    $email_res = $db->Execute($email_sql);
    $admin_id = $email_res->fields['admin_id'];
    $admin_id_from_table = 'customers_offline';
}

// 暂时屏蔽，先不要删除
//if (!$admin_id) {
//    $sql = "select customers_id from  customers_enquiry where customers_email='" . $email_address . "' order by customers_id desc limit 1 ";
//    $customer_a = $db->Execute($sql);
//    if ($customer_a->fields['customers_id']) {
//        $sql = "select admin_id from  admin_to_enquiry where customers_id='" . (int)$customer_a->fields['customers_id'] . "' order by admin_to_enquiry_id desc limit 1";
//        $order = $db->Execute($sql);
//        $admin_id = $order->fields['admin_id'];
//        $admin_id_from_table = 'customers_enquiry';
//    };
//}
//
////在线留言 https://www.fs.com/live_chat_service.html
//if (!$admin_id) {
//    $sql = "select live_chat_service_id from live_chat_service where live_chat_service_email='" . $email_address . "' order by live_chat_service_id desc limit 1 ";
//    $customer_a = $db->Execute($sql);
//    if ($customer_a->fields['live_chat_service_id']) {
//        $sql = "select admin_id from  live_chat_assign_for_phone where customers_id='" . (int)$customer_a->fields['live_chat_service_id'] . "' order by live_chat_phone_id desc limit 1";
//        $order = $db->Execute($sql);
//        $admin_id = $order->fields['admin_id'];
//        $admin_id_from_table = 'live_chat_service';
//    };
//};
//
////游客订单
//if (!$admin_id) {
//    $sql = "select o.orders_id,ota.admin_id from  orders o inner join order_to_admin ota on(o.orders_id=ota.orders_id) where ota.admin_id is not null and o.customers_email_address='" . $email_address . "' order by orders_id desc limit 1 ";
//    $customer_a = $db->Execute($sql);
//    $admin_id = $customer_a->fields['admin_id'];
//    $admin_id_from_table = 'orders';
//}
//
////产品询价 http://www.fs.com/products/65320.html
//if (!$admin_id) {
//    $email_sql = "SELECT admin_id  FROM products_price_inquiry where products_price_inquiry_email='" . $email_address . "' order by products_price_inquiry_id desc limit 1";
//    $email_res = $db->Execute($email_sql);
//    $admin_id = $email_res->fields['admin_id'];
//    $admin_id_from_table = 'products_price_inquiry';
//}
//
////定制记录 https://www.fs.com/custom-fiber-cable-assemblies.html
//if (!$admin_id) {
//    $email_sql = "SELECT admin_id FROM custom_record WHERE email='" . $email_address . "' order by record_id desc limit 1";
//    $email_res = $db->Execute($email_sql);
//    $admin_id = $email_res->fields['admin_id'];
//    $admin_id_from_table = 'custom_record';
//}
//
////产品Q管理
//// fairy改动表结构 2017.12.12
//if (!$admin_id) {
//    $email_sql = 'SELECT bind_admin_id  FROM question_answer_questions where email = "' . $email_address . '" order by id desc limit 1';
//    $email_res = $db->Execute($email_sql);
//    $admin_id = $email_res->fields['bind_admin_id'];
//    $admin_id_from_table = 'question_answer_questions';
//}
//
//if (!$admin_id) {
//    $email_sql = 'SELECT bind_admin_id  FROM question_answer_answers where email = "' . $email_address . '" order by id desc limit 1';
//    $email_res = $db->Execute($email_sql);
//    $admin_id = $email_res->fields['bind_admin_id'];
//    $admin_id_from_table = 'question_answer_answers';
//}
//
////前台申请报价
//if (!$admin_id) {
//    $email_sql = "SELECT admin_id FROM customer_inquiry WHERE email='" . $email_address . "' order by id desc limit 1";
//    $email_res = $db->Execute($email_sql);
//    $admin_id = $email_res->fields['admin_id'];
//    $admin_id_from_table = 'customer_inquiry';
//}
//
////前台solution & my case
//if (!$admin_id) {
//    $email_sql = "SELECT sales_id FROM customers_broker WHERE customer_email='" . $email_address . "' order by broker_id desc limit 1";
//    $email_res = $db->Execute($email_sql);
//    $admin_id = $email_res->fields['sales_id'];
//    $admin_id_from_table = 'customers_broker';
//}
//
////前台request stock
//if (!$admin_id) {
//    $email_sql = "SELECT case_number FROM products_request_stock WHERE email='" . $email_address . "' order by request_stock_id desc limit 1";
//    $email_res = $db->Execute($email_sql);
//    $case_number = $email_res->fields['case_number'];
//    if ($case_number) {
//        $case_res = $db->Execute("SELECT admin_id FROM case_number WHERE case_number='" . $case_number . "' order by case_number desc limit 1");
//        $admin_id = $case_res->fields['admin_id'];
//    }
//    $admin_id_from_table = 'products_request_stock';
//}
/*邮箱完全匹配结束*/

/*邮箱后缀匹配开始,排除公共邮箱后缀*/
if (!$admin_id) {
    //如果是销售帮客户下单注册,那么分给自己的后台账号,其他分给测试账号
    $company_mail = array('@fiberstore.com', '@fs.com', '@szyuxuan.com', '@feisu.com');
    $company_email_tail = strrchr($email_address, '@');
    $company_email_tail = strtolower($company_email_tail);
    if (in_array($company_email_tail, $company_mail)) {
        $res = $db->Execute("select admin_id,admin_level from admin where admin_email = '" . $email_address . "' and admin_level in (2,5,13) ");
        if ($res->fields['admin_id']) {
            $admin_id = $res->fields['admin_id'];
        } else {
            $email_prefix = substr($email_address, 0, (stripos($email_address, '@') + 1));
            $res2 = $db->Execute("select admin_id,admin_level from admin where admin_email like '" . $email_prefix . "%' and admin_level in (2,5,13) ");
            if ($res2->fields['admin_id']) {
                $admin_id = $res2->fields['admin_id'];
            } else {
                $admin_id = 117; //测试账号
            }
        }
        $admin_id_from_table = 'admin_fs';
    }

    $pub_mail = zen_get_public_mail_suffix(); //获取公共邮箱后缀
    $email_tail = strrchr($email_address, '@');
    $email_tail = strtolower($email_tail);
    if ($email_tail && !in_array($email_tail, $pub_mail)) {

        if (!$admin_id) {//验证customers是否有类似邮箱
            $email_sql = 'SELECT c.customers_id ,atc.admin_id FROM customers c inner join admin_to_customers atc on(c.customers_id=atc.customers_id) where atc.admin_id >0 and c.is_disabled = 0 and c.customers_email_address like "%' . $email_tail . '" and c.is_disabled=0 order by customers_id desc limit 1 ';
            $email_res = $db->Execute($email_sql);
            $admin_id = $email_res->fields['admin_id'];
            $admin_id_from_table = 'customers_like';
        }

        if (!$admin_id) {//验证线下客户是否有类似邮箱
            $email_sql = 'SELECT admin_id  FROM customers_offline where admin_id !=0 and customers_email_address like "%' . $email_tail . '" and is_disabled = 0 order by customers_id desc limit 1 ';
            $email_res = $db->Execute($email_sql);
            $admin_id = $email_res->fields['admin_id'];

            $admin_id_from_table = 'customers_offline_like';
        }

        //暂时屏蔽，先不要删除
//        if (!$admin_id) {//验证询单客户是否有类似邮箱
//            $email_sql = 'SELECT customers_id  FROM customers_enquiry where customers_email like "%' . $email_tail . '" order by customers_id desc limit 1 ';
//            $email_res = $db->Execute($email_sql);
//            if ($email_res->fields['customers_id']) {
//                $sql = "select admin_id from  admin_to_enquiry where customers_id='" . $email_res->fields['customers_id'] . "' order by admin_to_enquiry_id desc limit 1";
//                $order = $db->Execute($sql);
//                $admin_id = $order->fields['admin_id'];
//            };
//            $admin_id_from_table = 'customers_enquiry_like';
//        }
//
//        if (!$admin_id) {//验证livechat是否有类似邮箱
//            $email_sql = 'SELECT live_chat_service_id  FROM live_chat_service where live_chat_service_email like "%' . $email_tail . '" order by live_chat_service_id desc limit 1 ';
//            $email_res = $db->Execute($email_sql);
//            if ($email_res->fields['live_chat_service_id']) {
//                $sql = "select admin_id from  live_chat_assign_for_phone where customers_id='" . (int)$email_res->fields['live_chat_service_id'] . "' order by live_chat_phone_id desc limit 1";
//                $order = $db->Execute($sql);
//                $admin_id = $order->fields['admin_id'];
//            }
//            $admin_id_from_table = 'live_chat_service_like';
//        }
//
//
//        //游客订单
//        if (!$admin_id) {
//            $sql = "select o.orders_id,ota.admin_id from  orders o inner join order_to_admin ota on(o.orders_id=ota.orders_id) where ota.admin_id is not null and o.customers_email_address like '%" . $email_tail . "' order by orders_id desc limit 1 ";
//            $customer_a = $db->Execute($sql);
//            $admin_id = $customer_a->fields['admin_id'];
//            $admin_id_from_table = 'orders_like';
//        }
//
//        //产品询价 http://www.fs.com/products/65320.html
//        if (!$admin_id) {
//            $email_sql = "SELECT admin_id  FROM products_price_inquiry where products_price_inquiry_email like '%" . $email_tail . "' order by products_price_inquiry_id desc limit 1";
//            $email_res = $db->Execute($email_sql);
//            $admin_id = $email_res->fields['admin_id'];
//            $admin_id_from_table = 'products_price_inquiry_like';
//        }
//
//        //定制记录
//        if (!$admin_id) {
//            $email_sql = 'SELECT admin_id  FROM custom_record where email like "%' . $email_tail . '" order by record_id desc limit 1';
//            $email_res = $db->Execute($email_sql);
//            $admin_id = $email_res->fields['admin_id'];
//            $admin_id_from_table = 'custom_record_like';
//        }
//
//        //产品Q管理
//        // fairy改动表结构 2017.12.12
//        if (!$admin_id) {
//            $email_sql = 'SELECT bind_admin_id  FROM question_answer_questions where email like "%' . $email_tail . '" order by id desc limit 1';
//            $email_res = $db->Execute($email_sql);
//            $admin_id = $email_res->fields['bind_admin_id'];
//            $admin_id_from_table = 'question_answer_questions_like';
//        }
//        if (!$admin_id) {
//            $email_sql = 'SELECT bind_admin_id  FROM question_answer_answers where email like "%' . $email_tail . '" order by id desc limit 1';
//            $email_res = $db->Execute($email_sql);
//            $admin_id = $email_res->fields['bind_admin_id'];
//            $admin_id_from_table = 'question_answer_answers_like';
//        }
//
//        //前台申请报价
//        if (!$admin_id) {
//            $email_sql = "SELECT admin_id FROM customer_inquiry WHERE email like '%" . $email_tail . "' order by id desc limit 1";
//            $email_res = $db->Execute($email_sql);
//            $admin_id = $email_res->fields['admin_id'];
//            $admin_id_from_table = 'customer_inquiry_like';
//        }
//
//        //前台solution & my case
//        if (!$admin_id) {
//            $email_sql = "SELECT sales_id FROM customers_broker WHERE customer_email LIKE '%" . $email_tail . "' order by broker_id desc limit 1";
//            $email_res = $db->Execute($email_sql);
//            $admin_id = $email_res->fields['sales_id'];
//            $admin_id_from_table = 'customers_broker_like';
//        }
//
//        //前台request stock
//        if (!$admin_id) {
//            $email_sql = "SELECT case_number FROM products_request_stock WHERE email LIKE '%" . $email_tail . "' order by request_stock_id desc limit 1";
//            $email_res = $db->Execute($email_sql);
//            $case_number = $email_res->fields['case_number'];
//            if ($case_number) {
//                $case_res = $db->Execute("SELECT admin_id FROM case_number WHERE case_number='" . $case_number . "' order by case_number desc limit 1");
//                $admin_id = $case_res->fields['admin_id'];
//            }
//            $admin_id_from_table = 'products_request_stock_like';
//        }
    }
};
/*邮箱后缀匹配结束*/

if ($admin_id) {//判断管理员是否存在
    $admin_sql = "SELECT admin_name FROM admin WHERE admin_id=" . $admin_id . "";
    $res = $db->Execute($admin_sql);
    if (!$res->fields['admin_name']) {
        $admin_id = null;
        $admin_id_from_table = '';
    }
}

//邮箱匹配到了 标记老客户 用于统计
if ($admin_id) {
    $is_old = 1;
} else {
    $is_old = 0;
}

/*新客户分配开始*/
$is_make_up = 0;
if($customers_country_id == 176){
    $language_id = 4;
}
$language_limit = " and language_id = '" . $language_id . "'";


//注册新客户不走分配,半小时后走脚本文件,只有老客户立马分配
if (!$admin_id && in_array($allot_type, array('register_order_one','app_login','app_register','third_register','email','live_chat', 'price_inquiry', 'custom_record', 'product_question', 'product_request_stock', 'customer_broke', 'register_order', 'visitor_regist_order', 'visitor_order','third_party_login_order','sample_apply','visit_us','on_site_service','net_30_apply','feedback','solution_support','customers_q','e_rate','network_solution', 'quotes', 'customers_a', 'customers_c', 'request_demo'))) {
    if (in_array($allot_type, array('register_order', 'visitor_regist_order', 'visitor_order','third_party_login_order','register_order_one'))) {
        $field = 'is_beforeadmin_order';
        $more_num = 'more_num_order';
    } elseif (in_array($allot_type, array('email','live_chat', 'price_inquiry', 'custom_record', 'product_question', 'product_request_stock', 'customer_broke','visit_us','on_site_service','feedback','solution_support','customers_q','e_rate','network_solution', 'quotes', 'customers_a', 'customers_c', 'request_demo'))) {
        $field = 'is_beforeadmin_two';
        $more_num = 'more_num_two';
        //如果客户下单未分配来询盘,算下单客户
        if ($email_address) {
            $getCustomerIdInquiry = fs_get_data_from_db_fields('customers_id', 'customers', 'customers_email_address="' . $email_address . '"', '');
            if ($getCustomerIdInquiry) {
                $field = 'is_beforeadmin';  // 注册但是未分配的改成注册客户
                $more_num = 'more_num';
                $result = $db->Execute("select orders_id from orders left join order_to_admin using(orders_id) where customers_id=" . $getCustomerIdInquiry . " and admin_id is null");
                if ($result->fields['orders_id']) {
                    $field = 'is_beforeadmin_order';
                    $more_num = 'more_num_order';
                }
            }
        }
    }elseif(in_array($allot_type, array('register', 'third_register'))){
        //注册客户
        $field = 'is_beforeadmin';
        $more_num = 'more_num';
    }else {
        $field = 'is_beforeadmin_two';
        $more_num = 'more_num_two';
    }

    //todo:补客户
    $repeat_type = '';
    switch ($more_num) {
        case 'more_num_order':
            $repeat_type = 8;  //默认补D级客户
            //不同等级补客户
            if ($email_address) {
                $getCustomerIdForRepeat = fs_get_data_from_db_fields('customers_id', 'customers', 'customers_email_address="' . $email_address . '"', ' order by customers_id desc limit 1');
                if ($getCustomerIdForRepeat) {
                    //新注册客户下单
                    $orderResult = $db->getAll("select order_total from orders where main_order_id in (0,1) and customers_id=" . $getCustomerIdForRepeat);
                } else {
                    //游客下单
                    $orderResult = $db->getAll("select orders.order_total from orders LEFT JOIN order_to_admin using(orders_id) where orders.main_order_id in (0,1) and orders.customers_email_address ='" . $email_address . "' and order_to_admin.admin_id is null");
                }
                if (sizeof($orderResult)) {
                    $customerLastTotalOrder = 0;
                    foreach ($orderResult as $value) {
                        $customerLastTotalOrder += $value['order_total'];
                    }
                    if ($customerLastTotalOrder >= 5000) {
                        $repeat_type = 5;  //A级客户
                    }
                    if ($customerLastTotalOrder >= 2000 && $customerLastTotalOrder < 5000) {
                        $repeat_type = 6;  //B级客户
                    }
                    if ($customerLastTotalOrder >= 500 && $customerLastTotalOrder < 2000) {
                        $repeat_type = 7;  //C级客户
                    }
                }
            }
            break;
        case 'more_num':
            $repeat_type = 10;
            break;
        case 'more_num_two':
            $repeat_type = 11;
            break;
        default:
            $repeat_type = null;
            break;
    }

    $compensate_at = date("Y-m-d H:i:s");
    //有申请补客户 且通过  且客户类型满足的
    $applyDepartment = '';
    switch ($language_id){
        case '1':
            //英语
            $applyDepartment = ' AND a.department not in (850,857,858,851,859,860,848,853,854,849,855,856,628,844,852,861,862) ';
            break;
        case '2':
            //西语站
            $applyDepartment = ' AND a.department in (850,857,858) ';
            break;
        case '3':
            //法语站
            $applyDepartment = ' AND a.department in (851,859,860) ';
            break;
        case '4':
            //俄语站
            $applyDepartment = ' AND a.department in (848,853,854) ';
            break;
        case '5':
            //德语站
            $applyDepartment = ' AND a.department in (849,855,856) ';
            break;
        case '8':
            //日语站
            $applyDepartment = ' AND a.department in (852,861,862) ';
            break;
        case '14':
            //意大利站
            $applyDepartment = ' AND a.department in (1112) ';
            break;
        default:
            $applyDepartment = '';
            break;
    }
    $is_apply = $db->Execute("SELECT r.`id`,r.`sale_id` FROM `repeat_custom_distribution` as r INNER JOIN admin as a ON r.sale_id = a.admin_id WHERE r.`examine_status`=1 AND r.`is_over`=0 AND r.`custom_type`={$repeat_type}".$applyDepartment);
    //E($is_apply);
    date_default_timezone_set("Asia/Shanghai");
    $transChinaTime = date("Y-m",time());  //转换为国内时间
    date_default_timezone_set("America/Los_Angeles");

    if($is_apply->fields['id']){
        $db->Execute("UPDATE `repeat_custom_distribution` SET `compensate_at`='{$compensate_at}',`is_over`=1, `compensate_email`='{$email_address}',`phone`= '{$tel}' WHERE `id`=".$is_apply->fields['id']);
        $admin_id = $is_apply->fields['sale_id'];
        $admin_id_from_table = 'repeat_custom_distribution';
        $is_make_up = 1;
    }else{
        $admin_id_from_table = 'live_chat_admin';
        if($language_id == 1){
            //英语销售
            //查询当前循环到哪个销售
            $now_loc = $db->getAll('select lca.id,lca.admin_id,lca.this_remain_num 
                    from live_chat_admin as lca right join admin as a on lca.admin_id = a.admin_id
                    where lca.is_new = 1 AND lca.language_id = 1 AND lca.this_remain_num > 0 
                    order by lca.group_sort asc,lca.id asc limit 2');
            if(!$now_loc){  //未查询到销售，重置分配序列，重新查询
                newCustomerAssignmentEn();
                $now_loc = $db->getAll('select lca.id,lca.admin_id,lca.this_remain_num 
                        from live_chat_admin as lca right join admin as a on lca.admin_id = a.admin_id
                        where lca.is_new = 1 AND lca.language_id = 1 AND lca.this_remain_num > 0 
                        order by lca.group_sort asc,lca.id asc limit 2');
            }
            $admin_id = $now_loc[0]['admin_id'];
            $db->Execute('update live_chat_admin set this_already_num = this_already_num+1,
                        this_remain_num = this_remain_num-1 where id = '.$now_loc[0]['id']);
            if($now_loc[0]['this_remain_num'] <= 1 && empty($now_loc[1])){
                //如果不存在下一个可分配销售，代表此轮分配已结束，重置分配数据
                newCustomerAssignmentEn();
            }
        }else{
            //其它语种销售
            $now_loc = $db->getAll('select lca.id,lca.admin_id,lca.customer_ceiling,lca.this_remain_num 
                        from live_chat_admin as lca 
                        right join admin as a on lca.admin_id = a.admin_id 
                        where lca.is_new = 1 and lca.this_remain_num > 0 and lca.language_id = '.$language_id.'
                        order by lca.id asc limit 2');
            if(!$now_loc){    //如果该语种未查询出可以分配的销售
                //重置分配序列
                newCustomerAssignmentOther($language_id);
                //重新获取分配销售
                $now_loc = $db->getAll('select lca.id,lca.admin_id,lca.customer_ceiling,lca.this_remain_num 
                        from live_chat_admin as lca 
                        right join admin as a on lca.admin_id = a.admin_id 
                        where lca.is_new = 1 and lca.this_remain_num > 0 and lca.language_id = '.$language_id.'
                        order by lca.id asc limit 2');
            }
            //客户分配处理
            $admin_id = $now_loc[0]['admin_id'];
            //查询该销售的客户数(以公司为单位)
            $total_customers = $db->getAll('select count(distinct mcc.company_number) as num 
                                                        from manage_customer_company as mcc 
                                                        left join manage_customer_company_to_customers as mcctc on mcc.company_number = mcctc.company_number
                                                        where mcctc.admin_id = '.$admin_id);
            $total_customers_num = $total_customers[0]['num'];
            //如果分配此客户后，达到分配数上限，则关闭分配状态
            if($total_customers_num + 1 >= $now_loc[0]['customer_ceiling']){
                $db->Execute('update live_chat_admin set this_already_num = this_already_num + 1,this_remain_num = 0,
                        all_total_num = all_total_num + 1,stop_auto = 1 
                        where id = '.$now_loc[0]['id']);
            }else{
                $db->Execute('update live_chat_admin set this_already_num = this_already_num + 1,
                        this_remain_num = this_remain_num - 1,all_total_num = all_total_num + 1 
                        where id = '.$now_loc[0]['id']);
            }
            if($now_loc[0]['this_remain_num'] <= 1 && empty($now_loc[1])){
                //如果不存在下一个可分配销售，代表此轮分配已结束，重置分配数据
                newCustomerAssignmentOther($language_id);
            }
        }
    }
}
/*新客户分配结束*/
$allot_log = array(
    'customers_email' => $email_address,
    'admin_id' => $admin_id,
    'admin_id_from_table' => $admin_id_from_table,
    'type' => $allot_type,
    'add_time' => date('Y-m-d H:i:s', time()),
    'loop_field' => $field,
    'is_old' => $is_old,
    'is_make_up' => $is_make_up,
    'customers_country_id' => $customers_country_id,
    'language_id' => $language_id,
    'record_id' => $orders_id,
    'time_flow' => time(),
);
zen_db_perform('allot_log', $allot_log);
?>
