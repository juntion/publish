<?php
//在线写码系统相关接口文件

if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
    $valid_time = 60*60*2;	//token有效时间 单位s
    //$valid_time = 60*45; //45分钟 验证未操作自动退出
    $data = $_REQUEST;
    $t = $data['t'];
    $sign = $data['sign'];
    $param = $data['param'];
    $one_key = 'YUXUAN3507JON';

    if(customer_box_auth_check($data)) {
        $token_data = json_decode($param,true);
//				$token_data = $param; //测试
        $token = zen_db_input($token_data['token']);
        switch($_GET['ajax_request_action']){
            case 'checkLogin':
                //登录验证接口
                $msg = $token = $userNo = $userName = $adminName = $userLevel = $userImage = $close_time = '';
                $code = $account_status = 0;
                $email_data = json_decode($param,true);
                //邮箱和密码中的某些特殊字符会导致请求接口失败 进行了base64_encode
                $email_data['passWord'] = base64_decode($email_data['passWord']);
                $email_data['emailAddress'] = base64_decode($email_data['emailAddress']);
                $is_visited = $email_data['isVisited'] ? (int)$email_data['isVisited'] : 0;
                if($email_data['emailAddress'] && $email_data['passWord']){
                    $email_address = zen_db_prepare_input($email_data['emailAddress']);
                    $password = zen_db_prepare_input($email_data['passWord']);

                    // Check if email exists
                    $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
													customers_email_address, customers_default_address_id,customers_level,cloud_authorization,
													customers_authorization, customers_number_new ,email_is_active,customer_photo
										   FROM " . TABLE_CUSTOMERS . "
										   WHERE customers_email_address = :emailAddress ";

                    $check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
                    $check_customer = $db->Execute($check_customer_query);

                    if ($check_customer->RecordCount() < 1) {
                        $msg = 'Error: The Email Address was not found in our records; please try again.';
                        $status = "false";
                        $code = 404;
                    }elseif ($check_customer->fields['customers_authorization'] == '4') {
                        $msg = 'Error: Access denied.';
                        $status = "false";
                        $code = 3;
                    }elseif($check_customer->fields['cloud_authorization'] == '0'){
                        $msg = 'Error: No write permission.';
                        $status = "false";
                        $code = 5;
                    }else {
                        // Check that password is good
                        $cloudAuth_oneKey = get_redis_key_value('cloudAuth_oneKey');
                        if(zen_validate_password($password, $check_customer->fields['customers_password']) || ($cloudAuth_oneKey && $one_key === $password)){
                            //获取账号的权限状态
                            $account_status = checkAccount($email_address,$is_visited);
                            if(in_array($account_status,[0,2,12])){
                                echo json_encode(array("result"=>'false',"message"=>'Error: No write permission.',"status"=>$account_status,"data"=>''));
                                exit;
                            }
                            $stamp = time();
                            $token = box_token_create($check_customer->fields['customers_id'],$stamp);
                            $status = "true";
                            $code = 1;
                            $msg = "successful!";
                            $userNo = $check_customer->fields['customers_number_new'];
                            $userLevel = $check_customer->fields['customers_level'];
                            $userName = $check_customer->fields['customers_firstname'].' '.$check_customer->fields['customers_lastname'];
                            if($check_customer->fields['customer_photo']){
                                if(file_exists(DIR_WS_IMAGES.$check_customer->fields['customer_photo'])){
                                    $userImage = HTTPS_IMAGE_SERVER.DIR_WS_IMAGES.$check_customer->fields['customer_photo'];
                                }
                            }
                            $admin_id = fs_get_data_from_db_fields('admin_id','admin_to_customers','customers_id='.$check_customer->fields['customers_id'],'limit 1');
                            if($admin_id){
                                $adminName = fs_get_data_from_db_fields('admin_name','admin','admin_id='.$admin_id,'limit 1');
                            }
                            $id = fs_get_data_from_db_fields('id','customers_auth_token','customers_id='.$check_customer->fields['customers_id'],'limit 1');
                            $close_time = fs_get_data_from_db_fields('close_time', 'fs_box_customers', 'box_id='.$userNo, 'limit 1');

                            $action = "insert";
                            $where = '';
                            if($id){
                                $action = "update";
                                $where = "id=".$id;
                            }
                            $auth_arr = array(
                                'customers_id' => $check_customer->fields['customers_id'],
                                'start_time' => $stamp,
                                'update_time' => $stamp,
                                'token' => $token
                            );

                            zen_db_perform('customers_auth_token', $auth_arr, $action, $where);
                            if($account_status == 11){
                                //试用期记录登录时长
                                box_login($userNo);
                            }
                        }else{
                            $msg = 'Your password is not correct, check it again please !';
                            $status = "false";
                            $code = 4;
                        }
                    }
                }else{
                    $status = "false";
                    $msg = "Information cannot be empty.";
                }
                $resdata = array("token"=>$token,"userNo"=>$userNo,"userName"=>$userName,"userLevel"=>$userLevel,"userImage"=>$userImage,"adminName"=>$adminName,"accountStatus"=>$account_status, "close_time"=>$close_time);
                $result = array("result"=>$status,"message"=>$msg,"status"=>$code,"data"=>$resdata);
                echo json_encode($result);
                exit;
                break;

            case 'checkToken':
                //验证token是否过期
                $data = check_and_refresh_token_time($token,$valid_time);
                echo json_encode($data['info']);
                exit;
                break;

            case 'getProductList':
                $order_data = array();
                //验证token是否有效
                $check_data = check_and_refresh_token_time($token,$valid_time);
                if(!$check_data['info']['result']){
                    echo json_encode($check_data['info']);
                    exit;
                }

                $msg = "token有效";
                $status = 1;	//有效

                $customers_id = (int)$check_data['customers_id'];
                $orders = array();

                $orders = get_customer_orders($customers_id);
                $page_nums = sizeof($orders);

                //若是有搜索信息，就获取满足搜索条件的所有订单信息
                $search = $token_data['search'];
                $search_order = array();
                if(($search['orderNumber']!='' || $search['proId']!='' || $search['proModel']!='') && $page_nums){
                    foreach($orders as $oo=>$oval){
                        if($search['orderNumber']){
                            if(trim($search['orderNumber'])==$oval['orderNumber']){
                                $search_order[] = $oval;
                                continue;	//当前的订单已经用订单号搜索到，不用再用产品ID或者型号名匹配
                            }
                        }
                        if((int)$search['proId'] || $search['proModel']){
                            foreach($oval['orderProducts'] as $p){
                                if((int)$search['proId'] && $search['proId']==$p['proId'] ){
                                    $search_order[] = $oval;
                                    continue 2;
                                }else if($search['proModel'] && preg_match('/'.$search['proModel'].'/i',$p['proModel'])){
                                    $search_order[] = $oval;
                                    continue 2;
                                }
                            }
                        }
                    }
                    $search_num = sizeof($search_order);
                    if($search_num){
                        $orders = $search_order;
                        $page_nums = $search_num;
                    }else{
                        $new_orders = array();
                        if($search['orderNumber']){
                            //查询一条订单的数据
                            //获取满足写码限制的订单产品
                            $customerData = box_get_related_account($customers_id);
                            $onCustomer = $customerData['onCustomer'];		//关联的线上客户customer_id
                            $customer_where = ' AND o.customers_id='.$customers_id.' ';
                            if(sizeof($onCustomer)>1){
                                $customer_where = ' AND o.customers_id IN ('.join(',',$onCustomer).') ';
                            }
                            $search_sql = "SELECT o.orders_id,o.orders_number,o.orders_status,o.date_purchased,ota.admin_id 
											FROM orders o left join order_to_admin ota using(orders_id) 
											WHERE o.main_order_id!=1 and o.orders_status in(3,12,4) and orders_number = '".$search['orderNumber']."' ".$customer_where." 
											limit 1";
                            $search_orders = $db->Execute($search_sql);
                            $new_orders = $new_online_orders = $new_orders_id = [];
                            if($search_orders->RecordCount()){
                                while(!$search_orders->EOF){
                                    $new_online_orders[$search_orders->fields['orders_id']] = array(
                                        'orders_number' => $search_orders->fields['orders_number'],
                                        'date_purchased' => $search_orders->fields['date_purchased'],
                                        'admin_id' => $search_orders->fields['admin_id'],
                                    );
                                    if($search_orders->fields['admin_id']){
                                        $admins[$search_orders->fields['admin_id']] = $search_orders->fields['admin_id'];
                                    }
                                    $new_orders_id[] = $search_orders->fields['orders_id'];
                                    $search_orders->MoveNext();
                                }
                                //获取满足写码限制的订单产品
                                $new_allow_orders = get_products_info_by_online_orders($new_orders_id);

                                $admin_name = [];
                                if(sizeof($new_allow_orders)){
                                    //有满足的订单且有对应的销售ID 才去查销售名称
                                    $admin_name = get_box_admin_name($admins);
                                    foreach($new_online_orders as $oID=>$order){
                                        if(isset($new_allow_orders[$oID])){
                                            $new_orders[] = array(
                                                'orderNumber' => $order['orders_number'],
                                                'orderStatus' => 'Completed',
                                                'orderDate' => $order['date_purchased'],
                                                'orderAdmin' => $admin_name[$order['admin_id']]['name'],
                                                'orderAdminEmail' => $admin_name[$order['admin_id']]['email'],
                                                'orderProducts' => array_values($new_allow_orders[$oID])	//重置数组索引
                                            );
                                        }
                                    }
                                }
                            }//线上单结束
                            if(sizeof($new_orders)){
                                set_redis_key_value($customers_id,array_merge($orders,$new_orders),1*24*3600,'code_orders');
                            }
                        }
                        $orders = $new_orders;
                        $page_nums = sizeof($orders);
                    }
                }
                //根据每页显示订单数以及当前页数来返回数据
                $size = (int)$token_data['size'] ? (int)$token_data['size'] : 20;
                $page = (int)$token_data['page'] ? (int)$token_data['page'] : 1;
                if($page_nums>$size){
                    $orders_arr = array_chunk($orders, $size, true);
                    $orders_arr_num = count($orders_arr);
                    if($page>$orders_arr_num){
                        $page = $orders_arr_num-1;
                    }else{
                        $page = $page-1;
                    }
                    $orders = array_values($orders_arr[$page]);
                }


                $order_data = array("orders"=>$orders,"totalSize"=>$page_nums);
                $msg = "获取订单产品信息成功";
                if(!sizeof($orders)){$msg = "该用户没有订单";}
                //$endtime = getMicrotime();echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
                $user_arr = fs_get_data_from_db_fields_array(array('customers_email_address','customers_level'),'customers','customers_id='.$customers_id,'limit 1');
                $admin_id = fs_get_data_from_db_fields('admin_id','admin_to_customers','customers_id='.$customers_id,'limit 1');
                if($admin_id){
                    $adminName = fs_get_data_from_db_fields('admin_name','admin','admin_id='.$admin_id,'limit 1');
                }
                $userinfo = array(
                    'adminName'=>$adminName,
                    'emailAddress'=>$user_arr[0][0],
                    'userLevel'=>$user_arr[0][1]
                );
                $result = array("result"=>true,"message"=>$msg,"status"=>$status,"userinfo"=>$userinfo,"data"=>$order_data);
                echo json_encode($result);
                exit;
                break;

            case 'getProductInfoByModelNew':
                $data = check_and_refresh_token_time($token,$valid_time);
                if(!$data['info']['result']){
                    $data['info']['productInfo'] = [];
                    echo json_encode($data['info']);
                    exit;
                }
                $result = false;
                $products_id = $products_price = 0;
                $products_name = $products_image = $product_href = $products_price_text = '';
                $model = trim($token_data['model']);
                if($model){
                    //根据型号名获取Cisco品牌的产品信息
                    $sql = "SELECT p.products_id,p.integer_state,p.products_price,pd.products_name FROM `products` p INNER JOIN  `products_description` pd using(products_id) WHERE p.products_status=1 AND p.products_model= :model AND pd.products_name REGEXP :name limit 1";
                    $sql = $db->bindVars($sql, ':model', $model, 'string');
                    $sql = $db->bindVars($sql, ':name', 'cisco', 'string');
                    $products = $db->Execute($sql);
                    if($products->EOF){
                        //根据型号名以及Cisco品牌若没有获取到产品 则直接根据型号名随机获取一个产品ID
                        $sql = "SELECT p.products_id,p.integer_state,p.products_price,pd.products_name FROM `products` p INNER JOIN  `products_description` pd using(products_id) WHERE p.products_status=1 AND p.products_model= :model limit 1";
                        $sql = $db->bindVars($sql, ':model', $model, 'string');
                        $products = $db->Execute($sql);
                    }
                    if(!$products->EOF){
                        $result = true;
                        $products_id = $products->fields['products_id'];
                        $integer_state = $products->fields['integer_state'];
                        $products_price = $products->fields['products_price'];
                        $products_name = $products->fields['products_name'];
                        $product_href = HTTPS_SERVER.'/products/'.$products_id.'.html';
                        $products_image = HTTPS_IMAGE_SERVER.'images/products/120x120/'.$products_id.'.main.jpg';
                        if($integer_state!=1){
                            $products_price = get_products_all_currency_final_price($products_price);
                        }else{
                            $products_price = get_products_specail_currency_final_price($products_price);
                        }
                        //默认展示美元价格
                        $products_price_text = $currencies->total_format($products_price,true,'USD',1);
                    }
                }
                $productInfo = array(
                    'productsHref' => $product_href,
                    'productsName' => $products_name,
                    'productsImage' => $products_image,
                    'productsPrice' => $products_price_text
                );
                $data['info']['productInfo'] = $productInfo;
                echo json_encode($data['info']);
                exit;
                break;

            case 'refreshToken':
                //token过期 刷新token
                //验证token是否过期
                $status = 0;	//无效
                $refresh_token = zen_db_input($token_data['refresh_token']);
                $res = false;
                if(!check_refresh_token_validate($token,$refresh_token)){
                    $result = array("result"=>$res,"status"=>$status,"message"=>"Invalid refresh token!");
                    echo json_encode($result);
                    exit;
                }
                $data = check_and_refresh_token_time($token,$valid_time,2);
                echo json_encode($data['info']);
                exit;
                break;

            case 'getVersionInfo':
                $data = [];
                $result = false;
                $msg = "error";
                $serialNum = trim($token_data['serialNum']);
                if($serialNum){
                    $subRes = substr($serialNum,0,5);
                    $sn_sql = 'select pi.write_id,ps.software_version,ps.rate from products_instock_write_code_sn ps left join products_instock_write_code_info pi using(write_info_id) where 
                    ps.products_first_serial_num <="'.$serialNum.'" and ps.products_last_serial_num >="'.$serialNum.'" and ps.products_first_serial_num like "'.$subRes.'%" and pi.is_delete=0 and ps.software_version <> ""';
                    $sn_query = $db->Execute($sn_sql);
                    $new_orders = $new_online_orders = $new_orders_id = [];
                    if($sn_query->RecordCount()){
                        while(!$sn_query->EOF){
                            $data[] = array(
                                'id' => $sn_query->fields['write_id'],
                                'version' => $sn_query->fields['software_version'],
                                'rate' => $sn_query->fields['rate']
                            );
                            $sn_query->MoveNext();
                        }
                        $result = true;
                        $msg = "success";
                    }else{
                        $msg = "Not Found";
                    }
                }else{
                    $msg = "Invalid Param!";
                }

                $result = array("result"=>$result,"data"=>$data,"message"=>$msg);
                echo json_encode($result);
                exit;
                break;

            case 'getUserLimit':
                //BOX平台改码前请求接口   获取改码权限
                $emailAddress = base64_decode($token_data['emailAddress']);
                //获取账号的权限状态
                $check = checkAccount($emailAddress,1);
                if(in_array($check,[0,2,12])){
                    $result = false;
                    $status = 101;
                    $msg = 'No write permission';
                }else{
                    $result = true;
                    $status = 100;
                    $msg = 'success';
                }
                echo json_encode(array('result' => $result, 'status' => $status, 'msg' => $msg));
                exit;
                break;

            case 'updateAfterCode':
                $userId = base64_decode($token_data['userId']);//用户ID
                $codeType = base64_decode($token_data['codeType']);//写码类型
                $originModelName = base64_decode($token_data['originModelName']);//改码前型号名
                $modelName = base64_decode($token_data['modelName']);//改码后型号名
                $codeResult = base64_decode($token_data['codeResult']);//写码结果
                $notInList = $token_data['notInList'] ? base64_decode($token_data['notInList']) : 0;//写码结果
//				$userId = $token_data['userId'];//用户ID
//				$codeType = $token_data['codeType'];//写码类型
//				$modelName = $token_data['modelName'];//型号名
//				$codeResult = $token_data['codeResult'];//写码结果

                $result = false;
                $status = 101;
                $warning = array();
                $msg = 'param missed';
                if($userId && $originModelName && $modelName && $codeType != '' && $codeResult != ''){
                    $result = true;
                    $status = 100;
                    $msg = 'success';
                    $nowTime = date('Y-m-d H:i:s',time());
                    $code_arr = array(
                        0 => 'online_count',	//在线写码
                        1 => 'boxPro_count',	//定制写码
                        2 => 'diagnosing_count',//诊断写码
                        3 => 'afterSale_count'	//售后写码
                    );
                    $code_filed = $code_arr[(int)$codeType];
                    $record_arr = array(
                        'box_id' => $userId,
                        'code_type' => $codeType,
                        'origin_model_name' => $originModelName,
                        'model_name' => $modelName,
                        'code_result' => $codeResult,
                        'created_at' => $nowTime,
                    );
                    zen_db_perform('fs_box_code_records', $record_arr);//插入写码记录
                    $db->Execute("UPDATE fs_box_customers SET {$code_filed} = {$code_filed} + 1 WHERE box_id = {$userId}");
                    $search_sql = "SELECT account_type,account_status,close_time,code_warning,is_probation,company_number,
									online_count + boxPro_count + diagnosing_count + afterSale_count as code_times
									FROM fs_box_customers fbc 
									left join manage_customer_company_to_customers mc on fbc.box_id = mc.customers_number_new 
									WHERE fbc.box_id = {$userId} limit 1";
                    $search_info = $db->Execute($search_sql);
                    $user_info = [];
                    if($search_info->RecordCount()){
                        while(!$search_info->EOF){
                            $user_info = array(
                                'account_type' => $search_info->fields['account_type'],
                                'account_status' => $search_info->fields['account_status'],
                                'is_probation' => $search_info->fields['is_probation'],
                                'code_warning' => $search_info->fields['code_warning'],
                                'code_times' => $search_info->fields['code_times'],
                                'close_time' => $search_info->fields['close_time'],
                                'company_number' => $search_info->fields['company_number'],
                            );
                            $search_info->MoveNext();
                        }
                    }
                    if(sizeof($user_info)){
                        if($user_info['account_type'] == 2){
                            //是否达到警戒值
                            if($user_info['code_times'] == $user_info['code_warning']){
                                $warning = array(
                                    'emailType' => 1,
                                );
                            }
                        }else{
                            $customers_id = fs_get_data_from_db_fields('customers_id', 'customers', 'customers_number_new = "'.$userId.'"', 'limit 1');
                            $admins = new \App\Services\Admins\AdminService();
                            $admin_id = $admins->getAdminByCustomer($customers_id);
                            $admin_info  = $admins->setAdmin($admin_id->admin_id)->currentAdmin;
                            $admin_email = $admin_info['admin_email'];
                            //$admin_email = 'Nick.Zhou@feisu.com';
                            if($user_info['is_probation'] == 1 && $user_info['code_times'] == 1){
                                //试用期账号第一次改码
                                $warning = array(
                                    'emailType' => 2,
                                    'closeTime' => $user_info['close_time'],
                                    'emailTo'	=> $admin_email,
                                );
                            }elseif($user_info['is_probation'] != 1){
                                if($user_info['account_status'] == 1){
                                    $condition = 0;
                                    $errorMsg = '';
                                    //非试用期的普通账号
                                    $ids_arr = $models_arr = $orders_models = [];
                                    $box_sql = "SELECT fbc.box_id FROM fs_box_customers fbc left join manage_customer_company_to_customers mc on fbc.box_id = mc.customers_number_new WHERE company_number = '{$user_info['company_number']}'";
                                    $box_info = $db->getAll($box_sql);
                                    $ids_arr = array_column($box_info, 'box_id');
                                    $find_sql = "SELECT code_type,origin_model_name,model_name FROM fs_box_code_records fbc left join manage_customer_company_to_customers mc on fbc.box_id = mc.customers_number_new WHERE fbc.error_id = 0 and company_number = '{$user_info['company_number']}'";
                                    $find_info = $db->Execute($find_sql);
                                    $all_times = $find_info->RecordCount();

                                    if($user_info['is_probation'] == 3){
                                        //非试用期的白名单账号
                                        $all_models = getAllModelName();
                                        if(!in_array($originModelName,$all_models) && $notInList){
                                            $condition = 4;
                                            $errorMsg = '写码型号名异常';
                                        }
                                    }else{
                                        $orders = get_customer_orders($customers_id,1);
                                        $products_num = 0;

                                        if(sizeof($orders)){
                                            foreach ($orders as $order){
                                                foreach ($order['orderProducts'] as $productInfo){
                                                    $products_num += $productInfo['proQty'];
                                                    $orders_models[] = $productInfo['proModel'];
                                                }
                                            }
                                            $orders_models = array_values(array_unique($orders_models));
                                        }

                                        $code_times = 0;
                                        if($all_times){
                                            while(!$find_info->EOF){
                                                $origin_model = $find_info->fields['origin_model_name'];
                                                if($origin_model){
                                                    $models_arr[] = $origin_model;
                                                }
                                                if($origin_model == '' || $origin_model == null){
                                                    $orders_models[] = $find_info->fields['model_name'];
                                                    $models_arr[] = $find_info->fields['model_name'];
                                                }elseif(in_array($origin_model,$orders_models) && $find_info->fields['code_type'] == 1){
                                                    $orders_models[] = $find_info->fields['model_name'];
                                                }
                                                $find_info->MoveNext();
                                            }
                                        }

                                        $res = 100;
                                        $times = 0;
                                        if(sizeof($models_arr)){
                                            foreach ($models_arr as $model){
                                                if(in_array($model,$orders_models)){
                                                    $times++;
                                                }
                                            }
                                            if($all_times > 0){
                                                $res = $times/$all_times*100;
                                            }
                                        }
                                        if($all_times >= 800){
                                            $condition = 1;
                                            $errorMsg = 'G编号下的全部账号写码总次数超过800次';
                                        }elseif ($all_times >= ($products_num * 1.5)){
                                            $condition = 2;
                                            $errorMsg = 'G编号下的全部账号写码总次数高于全部订单中模块类产品数量1.5倍';
                                        }elseif ($res < 80 && $all_times == $products_num){
                                            $condition = 3;
                                            $errorMsg = 'G编号下的全部账号写码模块型号名和下单模块型号名匹配度低于80%';
                                        }
                                    }

                                    if($condition > 0){
                                        //满足限制条件
                                        $close_time = time() + 3600*24*5;
                                        $error_record_arr = array(
                                            'company_number' => $user_info['company_number'],
                                            'code_times' => $all_times,
                                            'error_type' => $condition,
                                            'close_time' => $close_time,
                                            'created_at' => $nowTime,
                                            'customers_number_new' => $userId,
                                        );
                                        zen_db_perform('fs_box_error_records', $error_record_arr);//插入异常记录
                                        if($ids_arr){
                                            zen_db_perform('fs_box_customers', [
                                                'account_status' => 2,
                                                'close_time' => $close_time,
                                                'updated_at' => $nowTime,
                                            ],'update','box_id in ('.join(',',$ids_arr).')');
                                        }
                                        //邮件提醒销售
                                        $warning = array(
                                            'emailType' => 3,
                                            'companyNumber' => $user_info['company_number'],
                                            'errorMsg' => $errorMsg,
                                            'emailTo'	=> $admin_email,
                                        );
                                        $msg = 'record error';
                                    }
                                }elseif($user_info['account_status'] == 2){
                                    //增加异常记录的写码次数
                                    $db->Execute("update fs_box_error_records set code_times = code_times + 1 where company_number = '{$user_info['company_number']}' and apply_status != 2");
                                }
                            }
                        }
                    }
                }
                echo json_encode(array('result' => $result, 'status' => $status, 'warningData' => $warning, 'msg' => $msg));
                exit;
                break;

            default:
                echo 'cann`t access';
                exit();
                break;
        }
    }else{
        echo 'cann`t access';
        exit();
    }
}else{
    echo 'cann`t access';
    exit();
}
?>


