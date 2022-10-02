<?php

switch ($_GET['ajax_request_action']){
    case 'checkout_transfer_ns_data':
        set_time_limit(0);
        $id = abs((int)($_POST['id'] ?: 0));
        $orders_id = abs((int)($_POST['orders_id'] ?: 0));
        
        $orderOvertime = fs_get_one_data('customer_ns_transfer_queue', " id=" . $id);
        if ($orders_id != $orderOvertime['orders_id']) {
            echo json_encode(
                [
                    "code"    => 301,
                    "message" => '未从数据库找到要处理的数据',
                ]
            );
            exit();
        }
        $admin_id = fs_get_data_from_db_fields('admin_id', 'order_to_admin', 'orders_id=' . $orders_id, '');
        $orders_query_data = fs_get_data_from_db_fields_array(['currency','customers_email_address'],'orders','orders_id='.$orders_id,'limit 1');
        $email_address = $orders_query_data[0][1];
        $orders_currency = $orders_query_data[0][0];
        $currencies_id = fs_get_data_from_db_fields('currencies_id','currencies','code = "'.$orders_currency.'"','limit 1');
        
        $us_db = new queryFactory();
        if (!$us_db->connect(C_DB_SERVER, C_DB_SERVER_USERNAME, C_DB_SERVER_PASSWORD, C_DB_DATABASE, C_USE_PCONNECT, false)) {
        // if (!$us_db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false)) {
            //链接失败再链接一次
            if (!$us_db->connect(C_DB_SERVER, C_DB_SERVER_USERNAME, C_DB_SERVER_PASSWORD, C_DB_DATABASE, C_USE_PCONNECT, false)) {
            // if (!$us_db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false)) {
                echo json_encode(
                    [
                        "code"    => 301,
                        "message" => '连接数据库失败',
                    ]
                );
                exit();
            }
        }


        $theCustomerNumberSql = $us_db->Execute("select customers_number_new,manage_type,customers_firstname,customer_country_id,customers_level from customers WHERE customers_email_address = '".$email_address."'");
        $cus_table = 'customers';
        $theCustomerNumber = $theCustomerNumberSql->fields['customers_number_new'];
        if(!$theCustomerNumber){
            $theCustomerNumberSql = $us_db->Execute("select customers_number_new,manage_type,customers_firstname,customer_country_id,customers_level from customers_offline WHERE customers_email_address = '".$email_address."'");
            $cus_table = 'customers_offline';
            $theCustomerNumber = $theCustomerNumberSql->fields['customers_number_new'];
        }

        $is_send_success = 0;
        $flag = false;
        if($theCustomerNumber){
            $company_number_data = $us_db->Execute("select company_number from manage_customer_company_to_customers WHERE customers_number_new = '".$theCustomerNumber."'");
            $company_number = $company_number_data->fields['company_number'];
            //$company_number = '';
            if($company_number){
                if($currencies_id){
                    $currenciesSql1 = $us_db->Execute("select currencies from manage_customer_company WHERE company_number = '".$company_number."'");
                    $currencies = $currenciesSql1->fields['currencies'];
                    if(!$currencies){
                        $us_db->Execute('update manage_customer_company set currencies = "'.$currencies_id.'" where company_number = "'.$company_number.'"');
                    }
                }
            }else{

                //$pub_mail = zen_get_public_mail_suffix(); //获取公共邮箱后缀
                $pub_mail = array();
                $all_mail = $us_db->getAll("select mail_suffix from public_mail_suffix");
                if($all_mail){
                    foreach($all_mail as $mail){
                        $pub_mail[] = $mail['mail_suffix'];
                    }
                }
    
                $email_tail = strrchr($email_address, '@');
                $email_tail = strtolower($email_tail);
                if(($email_tail && !in_array($email_tail, $pub_mail) && $admin_id) ){
                    //非公共邮箱
                    $numberArr = array();
                    //线上同后缀的客户
                    $cus_sql = 'SELECT c.customers_number_new FROM customers c left join admin_to_customers atc on (c.customers_id=atc.customers_id) where c.customers_email_address like "%' . $email_tail . '" and admin_id = '.$admin_id.' and c.manage_type<>0';
                    $cus_res = $us_db->Execute($cus_sql);
                    if($cus_res->RecordCount()){
                        while (!$cus_res->EOF){
                            $numberArr[]=$cus_res->fields['customers_number_new'];
                            $cus_res->MoveNext();
                        }
                    }
                    //线下同后缀的客户
                    $cus_off_sql = 'SELECT customers_number_new FROM customers_offline  where customers_email_address like "%' . $email_tail . '" and admin_id = '.$admin_id.' and manage_type<>0';
                    $cus_off_rst = $us_db->Execute($cus_off_sql);
                    if($cus_off_rst->RecordCount()){
                        while (!$cus_off_rst->EOF){
                            $numberArr[]=$cus_off_rst->fields['customers_number_new'];
                            $cus_off_rst->MoveNext();
                        }
                    }
                    if(sizeof($numberArr)){
                        $sql = 'SELECT company_number FROM manage_customer_company_to_customers where customers_number_new in('.join(',',$numberArr).') group by company_number';
                        $resultCompany = $us_db->getAll($sql);
                        if(sizeof($resultCompany) == 1){
                            $flag = true;
                            $company_number = $resultCompany[0]['company_number'];

                            //添加后台管理
                            $sql_manage_cus_sql = 'SELECT company_number FROM manage_customer_company_to_customers where customers_number_new = "'.$theCustomerNumber.'"';
                            $res_manage_cus = $us_db->query($sql_manage_cus_sql);
                            if(empty($res_manage_cus->fields['company_number'])){
                                $defaultCompanyLevel = $theCustomerNumberSql->fields['customers_level'] ? $theCustomerNumberSql->fields['customers_level'] : 'E';
                                $sql = 'INSERT INTO manage_customer_company_to_customers ( 
                                    company_number,
                                    customers_number_new,
                                    admin_id,
                                    created_at
                                    ) VALUES (
                                    "'.$company_number.'",
                                    "'.$theCustomerNumber.'",
                                    "'.$admin_id.'",
                                    "'.date("Y-m-d H:i:s").'"
                                    )';
                                $us_db->query($sql);
                                $us_db->Execute('update '.$cus_table.' set manage_type = 2,customers_level = "'.$defaultCompanyLevel.'" where customers_number_new = "'.$theCustomerNumber.'"');
                            }
                            
                            //插入币种
                            $sql_manage_currency = 'SELECT currencies FROM manage_customer_company WHERE company_number = "'.$company_number.'"';
                            $manage_currency = $us_db->Execute($sql_manage_currency);
                            if(empty( $manage_currency->fields['currencies'] )){
                                if($currencies_id){
                                    $us_db->Execute('update manage_customer_company set currencies = "'.$currencies_id.'" where company_number = "'.$company_number.'"');
                                }
                            }
                        }
                    }
                }

                if(empty($company_number)){
                    if(in_array($email_tail, ['fs.com', 'feisu.com'])){
                        return false;
                    }
                    //创建新公司关联
                    $chinaTime = get_common_cn_time();
                    $defaultCompanyNumber = 'G' . '00000' . RAND(1000,9999);
                    $defaultCompanyLevel = $theCustomerNumberSql->fields['customers_level'] ? $theCustomerNumberSql->fields['customers_level'] : 'E';
                    $sql1 = 'INSERT INTO manage_customer_company (
                                        company_number,
                                        created_at,
                                        customers_country_id,
                                        customers_company,
                                        company_type,
                                        currencies
                                        ) VALUES (
                                        "'.$defaultCompanyNumber.'",
                                            "'.$chinaTime.'",
                                        "'.$theCustomerNumberSql->fields['customer_country_id'].'",
                                        "'.$theCustomerNumberSql->fields['customers_firstname'].'",
                                        "1",
                                        "'.$currencies_id.'"
                                        )';
                    $us_db->query($sql1);
    
                    $newCompanyId = $us_db->insert_ID();
    
                    if ($newCompanyId) {
                        $newCompanyNumber = set_company_number($newCompanyId);//生成新的公司编号
                        $us_db->query("UPDATE `manage_customer_company` SET `company_number` = '{$newCompanyNumber}',`customers_company` = '{$newCompanyNumber}' WHERE `id` = '{$newCompanyId}'");
                        $sql = 'INSERT INTO manage_customer_company_to_customers ( 
                                        company_number,
                                        customers_number_new,
                                        admin_id,
                                        created_at
                                        ) VALUES (
                                        "'.$newCompanyNumber.'",
                                        "'.$theCustomerNumber.'",
                                        "'.$admin_id.'",
                                        "'.date("Y-m-d H:i:s").'"
                                        )';
                        $us_db->query($sql);
                        $us_db->Execute('update '.$cus_table.' set manage_type = 2,customers_level = "'.$defaultCompanyLevel.'" where customers_number_new = "'.$theCustomerNumber.'"');
                    }
                    //同步客户信息到对应的公司（如果请求参数都满足条件）下，请求NS接口
                    $company_number = $newCompanyNumber;
                }

            }
            if(!empty($company_number)){
                $orders_id_array = zen_get_all_son_order_id($orders_id);
                $orders_id_array[] = $orders_id;
                foreach($orders_id_array as $orders_id_v){
                    if(!empty($orders_id_v)){
                        $db->Execute('update orders set company_number = "'.$company_number.'" where orders_id = "'.$orders_id_v.'"');
                        $sql_timed_push_status = "select timed_push_status  from orders where orders_id = ".$orders_id_v;
                        $res_status = $db->Execute($sql_timed_push_status);
                        if($res_status->fields['timed_push_status'] == 3){
                            $db->Execute('update orders set timed_push_status = 0 where orders_id = "'.$orders_id_v.'"');
                        }
                    }
                }

                $ret = execute_curl_post_request($company_number);
                $ret = json_decode($ret);
                if(!isset($ret->status) || $ret->status != 'success'){
                    echo json_encode(
                        [
                            "code"    => 304,
                            "message" => $ret->status.' '.$ret->msg,
                        ]
                    );
                    exit();  
                }
                $is_send_success = 1;

            }else{
                echo json_encode(
                    [
                        "code"    => 302,
                        "message" => '没有公司编号',
                    ]
                );
                exit();
            }
            
        }else{
            echo json_encode(
                [
                    "code"    => 303,
                    "message" => '没有客户编号',
                ]
            );
            exit();
        }

        if($us_db){
            $us_db->close();
            unset($us_db);
        }


        if($is_send_success == 1){
            //执行成功
            $ns_success_log[] = [
                'orders_id'     => $orders_id,
                'addtime'       => time(),
                'datetime'      => 'now()',
            ];
            zen_db_inserts('ns_success_log', $ns_success_log);
            echo json_encode(
                [
                    "code"    => 1,
                    "message" => 'success',
                ]
            );
            exit();
        }

        break;
}
