<?php 
/*
 *在线写码系统调用接口文件相关函数
*/
function get_box_request_url_from_host(){
	$param_http = parse_url($_SERVER['HTTP_REFERER']);
	if(in_array($param_http['host'],array('www.fs.com','fs.com'))){
		return 'https://fsbox.com';
	}else{
		return 'http://54.245.72.232';
	}
}

/**
 * 请求FS-BOX平台获取数据或执行操作
 * @param $type 操作类型
 * @param $current 第几页
 * @param $size 数据条数
 * @return object
 */
function get_coding_request($type,$current = 1,$size = 10,$search_num = ''){
	//参数设置
	$post_data = array();
	$key= 'boxHuoshen2019' ;
	$api_url = get_box_request_url_from_host();
	$applyNoOrder = $search_num;      //申请编号or订单号
	$applyNo = $search_num;
	$post_data["key"] = md5($key);
	$post_data["param"] = '{"applyNo":"'.$applyNo.'"}';
	$post_data["sign"] = md5($key.$post_data["param"]);
	switch ($type){
		//获取客户申请记录列表
		case "list":
			//用户ID
			$fsUserId = fs_get_data_from_db_fields('customers_number_new',TABLE_CUSTOMERS,'customers_id='.$_SESSION['customer_id'],'limit 1');
			$post_data["param"] = '{"fsUserId":"'.$fsUserId.'","applyNoOrder":"'.$applyNoOrder.'","current":"'.$current.'","size":"'.$size.'"}';
			$post_data["sign"] = md5($key.$post_data["param"]);
			$url = $api_url.'/api/fsapi/CustomService/GetAllRequestData?requestAction=getApplyRecordPage';
			break;

		//获取客户申请记录详情
		case "details":
			$url = $api_url.'/api/fsapi/CustomService/GetAllRequestData?requestAction=applyWriteCodeDetail';
			break;

		//客户取消申请记录
		case "cancel":
			$url = $api_url.'/api/fsapi/CustomService/GetAllRequestData?requestAction=modifyApplyStatus';
			break;

		default:
			return array('msg'=>false,'data'=>'');
			break;
	}
	$result = curl_post_https($url,$post_data);
	if(!$result['success']){
        return array('msg'=>false,'data'=>$result);
	}
	$data = json_decode($result['data']);
	if($data->code == 1){
		return array('msg'=>$data->success,'data'=>$data->obj);
	}else{
		//-2：凭证不通过
		//-1：异常
		return array('msg'=>false,'data'=>$data);
	}
}

//发送一个POST请求获取返回结果
function curl_post_https($url,$post_data){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	$result = curl_exec($curl);
	//curl_close ($curl);

	if (curl_errno($curl)) {
		$json = array(
			'success'=>false,
			'data'=> 'Errno'.curl_error($curl) //捕抓异常
		);
	}else{
		curl_close($curl); // 关闭CURL会话
		$json = array(
			'success'=>true,
			'data'=> $result    //JSON字符串
		);
	}
	return $json;// 返回数组
}

//获取该用户的线上订单产品数据
function get_customer_orders($customers_id,$is_related = 0,$is_have_box = 0){
	if($customers_id){
		global $db;
		$redis_prefix = 'code_orders';
		$redis_key = $customers_id.'_'.$is_related.'_'.$is_have_box;
		$orders_res = get_redis_key_value($redis_key,$redis_prefix);
		if(!$orders_res){
//		if(true){
			//获取当前客户关联的其他客户信息
			$customerData = box_get_related_account($customers_id,$is_related);
			$onCustomer = $customerData['onCustomer'];		//关联的线上客户customer_id
			$customerEmail = $customerData['customerEmail'];	//关联的线上线下客户email
			$allCustomersNumberNew = $customerData['allCustomersNumberNew']; //关联所有客户编号
			$email_str = '';
			if(sizeof($customerEmail)>1){
				foreach($customerEmail as $kk=>$vv){
					$email_str .= "'".$vv."',";
				}
				$email_str = trim($email_str, ',');
			}
			$customers_email = $customerData['customers_email'];	//当前客户邮箱

			/************* 获取该用户的线上订单产品数据 *********************/
			$customer_where = ' AND o.customers_id='.$customers_id.' ';
			if(sizeof($onCustomer)>1){
				$customer_where = ' AND o.customers_id IN ('.join(',',$onCustomer).') ';
			}
			//根据customers_id查找订单
			$order_sql = "SELECT o.orders_id,o.orders_number,o.orders_status,o.date_purchased,ota.admin_id FROM orders o left join order_to_admin ota using(orders_id) WHERE o.main_order_id!=1 and o.orders_status in(3,12,4,7) ".$customer_where." ORDER BY o.orders_id desc ";
			$get_orders = $db->Execute($order_sql);
			$online_orders = $all_online_orders = $all_orders_id = $admins = [];
			while(!$get_orders->EOF){
				$all_online_orders[$get_orders->fields['orders_id']] = array(
					'orders_number' => $get_orders->fields['orders_number'],
					'date_purchased' => $get_orders->fields['date_purchased'],
					'admin_id' => $get_orders->fields['admin_id'],
				);
				if($get_orders->fields['admin_id']){
					$admins[$get_orders->fields['admin_id']] = $get_orders->fields['admin_id'];
				}
				$all_orders_id[] = $get_orders->fields['orders_id'];
				$get_orders->MoveNext();
			}
			//根据客户邮箱查找客户未注册前的游客单 即orders表中customers_id字段为0 的订单
			$guest_email_where = ' AND o.customers_id=0 AND o.customers_email_address="'.$customers_email.'" ';
			if($email_str){
				$guest_email_where = ' AND o.customers_id=0 AND o.customers_email_address IN ('.$email_str.') ';
			}
			$orders_guest_sql = "SELECT o.orders_id,o.orders_number,o.orders_status,o.date_purchased,ota.admin_id FROM orders o left join order_to_admin ota using(orders_id) WHERE o.main_order_id!=1 and o.orders_status in(3,12,4,7) ".$guest_email_where." ORDER BY o.orders_id desc ";
			$get_guest_orders = $db->Execute($orders_guest_sql);
			while(!$get_guest_orders->EOF){
				$all_online_orders[$get_guest_orders->fields['orders_id']] = array(
					'orders_number' => $get_guest_orders->fields['orders_number'],
					'date_purchased' => $get_guest_orders->fields['date_purchased'],
					'admin_id' => $get_guest_orders->fields['admin_id'],
				);
				if($get_guest_orders->fields['admin_id']){
					$admins[$get_guest_orders->fields['admin_id']] = $get_guest_orders->fields['admin_id'];
				}
				$all_orders_id[] = $get_guest_orders->fields['orders_id'];
				$get_guest_orders->MoveNext();
			}
			if(sizeof($all_orders_id)){
				//获取满足写码限制的订单产品
				$allow_orders = get_products_info_by_online_orders($all_orders_id,$is_have_box);
				if(sizeof($allow_orders)){
					//有满足的订单且有对应的销售ID 才去查销售名称
					$admin_name = get_box_admin_name($admins);
					foreach($all_online_orders as $oID=>$order){
						if(isset($allow_orders[$oID])){
							$online_orders[] = array(
								'orderNumber' => $order['orders_number'],
								'orderStatus' => 'Completed',
								'orderDate' => $order['date_purchased'],
								'orderAdmin' => $admin_name[$order['admin_id']]['name'],
								'orderAdminEmail' => $admin_name[$order['admin_id']]['email'],
								'orderProducts' => array_values($allow_orders[$oID])	//重置数组索引
							);
						}
					}
				}
			}
			//线上单结束

			/*************** 获取该用户所有的线下单 ********************/
			$offline_where = ' AND customers_emails="'.$customers_email.'" ';
			if($email_str){
				$offline_where = ' AND customers_emails IN ('.$email_str.') ';
			}
			$all_offline_orders = $offline_orders = $products_instock_id = $sales = [];
			//获取转运单，以及1样品单，2赠品单，3备件单，4为未知样品分类单,5调仓赠品单
			$other_where = '';
			if ($allCustomersNumberNew) {
				$other_where = ' or ((is_sample>0 or (is_not_transport in (5,4,3,8,9,2) and transport_update=1))  and No in ('.join(",",$allCustomersNumberNew).'))';
			}

			$cw_sql = "select ps.products_instock_id,ps.order_number,ps.order_invoice,ps.sales_update_time,ps.sales_admin,ps.shipping_number,ps.is_pickup from products_instock_shipping ps  where (ps.orders_id=0 ".$offline_where.") ".$other_where." order by ps.products_instock_id desc";
			$cw_query = $db->Execute($cw_sql);
			if($cw_query->RecordCount()) {
				while (!$cw_query->EOF) {
					$instock_id = $cw_query->fields['products_instock_id'];
					$trackFlag = false;        //线下单是否已经发货
					if ($cw_query->fields['shipping_number'] || $cw_query->fields['is_pickup'] == 1) {
						$trackFlag = true;
					} else {
						$order_tracking_id = fs_get_data_from_db_fields('order_tracking_id', 'order_tracking_info', 'products_instock_id=' .$instock_id, 'limit 1');
						if ($order_tracking_id)  $trackFlag = true;
					}
					if ($trackFlag) {    //该线下单已经发货则可以获取订单产品
						$order_number = $cw_query->fields['order_number'];
						$order_invoice = $cw_query->fields['order_invoice'];
						$all_offline_orders[$instock_id] = array(
							'order_number' => $order_number ? $order_number : $order_invoice,
							'order_date' => $cw_query->fields['sales_update_time'],
							'sales_admin' => $cw_query->fields['sales_admin']
						);
						$products_instock_id[] = $instock_id;
						if ($cw_query->fields['sales_admin']) {
							$sales[] = $cw_query->fields['sales_admin'];
						}
					}
					$cw_query->MoveNext();
				}
				//查找线下单允许写码的产品数据
				$cw_products = get_products_info_by_offline_instock($products_instock_id,$is_have_box);
				if (sizeof($cw_products)) {
					$sales_name = get_box_admin_name($sales);
					foreach ($all_offline_orders as $instockID => $orders) {
						if (isset($cw_products[$instockID])) {
							$offline_orders[] = array(
								'orderNumber' => $orders['order_number'],
								'orderStatus' => 'completed',
								'orderDate' => $orders['order_date'],
								'orderAdmin' => $sales_name[$orders['sales_admin']]['name'],
								'orderAdminEmail' => $sales_name[$orders['sales_admin']]['email'],
								'orderProducts' => array_values($cw_products[$instockID])	//重置数组索引
							);
						}
					}
				}
			}//线下单结束
			$orders = array_merge($online_orders,$offline_orders);
			if(sizeof($orders)){
				set_redis_key_value($redis_key,$orders,1*24*3600,$redis_prefix);
			}
		}else{
			$orders = $orders_res;
		}
		return $orders;
	}else{
		return [];
	}
}
/**
 * 获取线上订单支持FS BOX使用的产品订单
 * @param array $orders，一维数组存放orders_id
 * @return array
 */
function get_products_info_by_online_orders($orders=[],$is_have_box = 0){
	global $db;
	$orders_num = count($orders);
	$orders_products = $allow_orders_products_id = $allow_orders_id = [];
	if($orders_num){
		//获取支持写码的分类数组
		$allow_categories = get_box_validate_categories($is_have_box);
		if($orders_num==1){
			$where = ' op.orders_id='.(int)$orders[0].' ';
		}else{
			$where = ' op.orders_id IN ('.implode(',', $orders).') ';
		}
		$sql = "SELECT op.orders_products_id,op.orders_id,op.products_id,op.products_model,op.products_name,op.products_quantity,ptc.categories_id FROM `orders_products` op LEFT JOIN `products_to_categories` ptc using(products_id) WHERE ".$where." ORDER BY orders_products_id";
		$query = $db->Execute($sql);
		while(!$query->EOF){
			//判断当前产品对应的分类是否允许写码
			if(isset($allow_categories[$query->fields['categories_id']])){
				$orders_products_id = $query->fields['orders_products_id'];
				$orders_products[$query->fields['orders_id']][$orders_products_id] = array(
					'proId' => $query->fields['products_id'],			//产品ID
					'proModel' => $query->fields['products_model'],		//产品型号
					'proName' => $query->fields['products_name'],		//产品名称
					'proQty' => $query->fields['products_quantity'],	//产品数量
					'proInfoId' => 0,									//产品订单流程info表的主ID
					'proCompatible' => '',								//产品品牌
					'proFactory' => '',									//产品厂商
					'proSeriesNumber' => '',							//产品序列号
					'proComment' => '',									//产品流程信息描述
					'proDetails' => '',									//产品参数
					'proTagDescription' => ''							//产品特性备注
				);
				$allow_orders_products_id[] = $orders_products_id;
				$allow_orders_id[$query->fields['orders_id']] = $query->fields['orders_id'];
				$allow_products_id[$query->fields['products_id']] = $query->fields['products_id'];
			}
			$query->MoveNext();
		}
		/**
		 * 为了不再循环中多次查询数据库， 将products_instock_shipping_info,products_details,orders_products_attributes表中数据一次查出
		 */
		if(sizeof($allow_orders_products_id)){
			//查找满足订单产品在订单流程表中 序列号以及厂商名等信息
			$info_query = $db->Execute("SELECT psi.products_shipping_info_id as id,psi.manufacturer,psi.products_first_serial_num,psi.products_last_serial_num,psi.products_tag,psi.orders_products_id,ps.orders_id FROM products_instock_shipping_info psi LEFT JOIN `products_instock_shipping` ps using(products_instock_id) WHERE ps.orders_id IN (".join(',',$allow_orders_id).") AND psi.orders_products_id IN (".join(',',$allow_orders_products_id).") ");
			while(!$info_query->EOF){
				$orders_id = $info_query->fields['orders_id'];
				$orders_products_id = $info_query->fields['orders_products_id'];
				$seriesNumber = $info_query->fields['products_first_serial_num'].'--'.$info_query->fields['products_last_serial_num'];
				$orders_products[$orders_id][$orders_products_id]['proInfoId'] = $info_query->fields['id'];
				$orders_products[$orders_id][$orders_products_id]['proFactory'] = $info_query->fields['manufacturer'];
				$orders_products[$orders_id][$orders_products_id]['proSeriesNumber'] = $seriesNumber;
				$orders_products[$orders_id][$orders_products_id]['proComment'] = $info_query->fields['products_tag'];
				$info_query->MoveNext();
			}
		}
		//获取产品的detail参数数据
		$allow_details = get_products_detail($allow_products_id);
		//获取订单中定制模块的品牌属性
		$allow_compatible = get_orders_products_compatible($allow_orders_products_id);
		if(sizeof($orders_products)){
			foreach($orders_products as $oID=>$products){
				foreach($products as $opID=>$product ){
					//获取对应产品的detail参数数据
					if(isset($allow_details[$product['proId']])){
						$orders_products[$oID][$opID]['proDetails'] = $allow_details[$product['proId']]['details'];
					}
					//获取对应产品的定制品牌属性数据
					if(isset($allow_compatible[$opID])){
						$orders_products[$oID][$opID]['proCompatible'] = $allow_compatible[$opID];
					}
				}
			}
		}
	}
	return $orders_products;
}

/**
 * 获取线下单支持FS BOX使用的产品订单
 * @param array $instock 以为数组，存放products_instock_shipping的主键products_instock_id
 * @return array
 */
function get_products_info_by_offline_instock($instock=[], $is_have_box = 0){
	global $db;
	$cw_products = [];
	if(sizeof($instock)){
		//获取支持写码的分类数组
		$allow_categories = get_box_validate_categories($is_have_box);
		$sql = "SELECT psi.products_shipping_info_id as info_id,psi.products_instock_id,psi.products_id,psi.products_num,psi.local_porduct_model,psi.manufacturer,psi.products_first_serial_num,psi.products_last_serial_num,psi.products_tag,ptc.categories_id FROM products_instock_shipping_info psi LEFT JOIN `products_to_categories` ptc using(products_id) WHERE products_instock_id IN (".join(',',$instock).")";
		$query = $db->Execute($sql);
		while(!$query->EOF){
			if(isset($allow_categories[$query->fields['categories_id']])){
				$cw_products[$query->fields['products_instock_id']][$query->fields['info_id']] = array(
					'proId' => $query->fields['products_id'],
					'proInfoId' =>	$query->fields['info_id'],
					'proModel' => $query->fields['local_porduct_model'],
					'proQty' => $query->fields['products_num'],
					'proFactory' => $query->fields['manufacturer'],
					'proSeriesNumber' => $query->fields['products_first_serial_num'].'--'.$query->fields['products_last_serial_num'],
					'proComment' => $query->fields['products_tag'],
					'proTagDescription' => '',
					'proName' => '',
					'proDetails' => '',
					'proCompatible' => '',
				);
				$info_id[] = $query->fields['info_id'];
				$products_id[$query->fields['info_id']] = $query->fields['products_id'];
			}
			$query->MoveNext();
		}
		//获取产品的detail参数数据
		$allow_details = get_products_detail($products_id);
		//获取订单中定制模块的品牌属性
		$allow_compatible = get_offline_orders_products_compatible($info_id);
		if(sizeof($cw_products)){
			foreach($cw_products as $sID=>$products){
				foreach($products as $inID=>$product){
					//获取产品标题和detail参数
					if(isset($allow_details[$product['proId']])){
						$cw_products[$sID][$inID]['proName'] = $allow_details[$product['proId']]['products_name'];
						$cw_products[$sID][$inID]['proDetails'] = $allow_details[$product['proId']]['details'];
					}
					//获取定制模块的品牌属性
					if(isset($allow_compatible[$inID])){
						$cw_products[$sID][$inID]['proCompatible'] = $allow_compatible[$inID];
					}
				}
			}
		}
	}
	return $cw_products;
}

/**
 * 获取订单定制模块产品的品牌属性
 * @param array $orders_products_id  一维数组，orders_products表中的orders_products_id
 * @return array
 */
function get_orders_products_compatible($orders_products_id=[]){
	global $db;
	$compatible = [];
	if(sizeof($orders_products_id)){
		$result = $db->Execute("SELECT orders_products_id,products_options_values FROM `orders_products_attributes` WHERE `orders_products_id` IN (".join(',',$orders_products_id).") AND `products_options_id`=2");
		while(!$result->EOF){
			$compatible[$result->fields['orders_products_id']] = $result->fields['products_options_values'];
			$result->MoveNext();
		}
	}
	return $compatible;
}

/**
 * 获取订单定制模块产品的品牌属性
 * @param array $info_id  一维数组，products_instock_shipping_info表中的主键ID
 * @return array
 */
function get_offline_orders_products_compatible($info_id=[]){
	global $db;
	$compatible = [];
	if(sizeof($info_id)){
		$result = $db->Execute("SELECT psa.products_shipping_info_id as info_id,pov.products_options_values_name FROM `products_instock_shipping_products_attributes` psa LEFT JOIN `products_options_values` pov ON(psa.options_values_id=pov.products_options_values_id) WHERE psa.products_shipping_info_id IN (".join(',',$info_id).") AND psa.options_id=2 AND pov.language_id=1");
		while(!$result->EOF){
			$compatible[$result->fields['info_id']] = $result->fields['products_options_values_name'];
			$result->MoveNext();
		}
	}
	return $compatible;
}

/**
 * @param array $products, 存放产品ID的一维数组
 * @return array
 */
function get_products_detail($products=[]){
	global $db;
	$details = [];
	if(sizeof($products)){
		$des_query = $db->Execute("SELECT `products_id`,`module_status`,`product_details`,`products_name` FROM `products_description` WHERE products_id IN(".join(',', $products).")");
		while(!$des_query->EOF){
			$product_details = $des_query->fields['product_details'];
			$module_status = $des_query->fields['module_status'];
			$details[$des_query->fields['products_id']] = array(
				'products_name' => $des_query->fields['products_name'],
				'details' => zen_get_products_details_info($product_details,$module_status),
			);
			$des_query->MoveNext();
		}
	}
	return $details;
}

//获取销售名字
function get_box_admin_name($admins=[]){
	global $db;
	$admin_name = [];
	if(sizeof($admins)){
		$admin_query = $db->Execute("SELECT `admin_name`,`admin_id`,`admin_email` FROM `admin` WHERE `admin_id` IN (".join(',',$admins).")");
		while(!$admin_query->EOF){
			$admin_name[$admin_query->fields['admin_id']] = array('name'=>$admin_query->fields['admin_name'],'email'=>$admin_query->fields['admin_email']);
			$admin_query->MoveNext();
		}
	}
	return $admin_name;
}

function zen_get_products_details_info($details_str,$status=0){
	$details_data = array();
	$allow = array('Cisco Genuine','Vendor Name','Wavelength','Max Cable Distance','Interface');
	if($status==1){
		//新版结构
		$detail = str_replace("{", "{", $details_str);
		$detail_sh = explode("{", $detail);
		$detail = $detail_sh[0];
		$detail = str_replace("；", ";", $detail);
        $detail = str_replace("：", ":", $detail);
		$detail_info = explode(";", $detail);
		if(sizeof($detail_info)){
			foreach($detail_info as $des){
				$des_arr = explode(':',$des);
				$di_num = sizeof($des_arr);
				if($di_num>1){
					for($di=0;$di<$di_num;$di++){
						$kk = trim($des_arr[$di*2]);
						$vv = trim($des_arr[$di*2+1]);
						if($kk && in_array($kk,$allow)){
							$details_data[$kk] = $vv;
						}
					}
				}
			}
		}
	}else{
		
		$product_details = compress_html($details_str);
		$product_details =str_replace('</div>', '', $product_details);
		$product_details =str_replace('<div class="p_con_02">', '{', $product_details);
		$product_details_arr = explode('{',$product_details);
		$product_details = $product_details_arr[0];

		$product_details =str_replace('<table border="0" cellpadding="0" cellspacing="0" class="solu_table01" width="100%">', '', $product_details);
		$product_details =str_replace('</tr></tbody></table>', '', $product_details);
		$product_details =str_replace('<table border="0" cellpadding="0" cellspacing="0" class="solu_table01" width="100%">', '', $product_details);
		$product_details =str_replace('<table border="0"cellpadding="0"cellspacing="0"class="solu_table01"width="100%">', '', $product_details);
		$product_details =str_replace('<tbody>', '', $product_details);
		$product_details =str_replace('<tr>', '', $product_details);
		$product_details =str_replace('<td>', '', $product_details);
		$product_details =str_replace('<td >', '', $product_details);
		$product_details =str_replace('<td bgcolor="#f4f4f4">', '', $product_details);
		$product_details =str_replace('<b>', '', $product_details);
		$product_details =str_replace('</b>', '', $product_details);
		$product_details =str_replace('</td>', ' :', $product_details);
		$product_details =str_replace('</tr>', ' ; '."\n", $product_details);
		$product_details =str_replace('</tbody>', '', $product_details);
		$product_details =str_replace('</table>', '', $product_details);
		$product_details =str_replace(': :', '', $product_details);
		$product_details =str_replace(': ;', ' ; ', $product_details);
		$product_details = substr($product_details,0,strlen($product_details)-2);
		
		$detailsArr = explode(' ;',$product_details);
		if(sizeof($detailsArr)){
			foreach($detailsArr as $key=>$val){
				$varArr = explode(':',$val);
				$varArr_num = sizeof($varArr);
				for($m=0;$m<$varArr_num;$m++){
					$detail_key = trim($varArr[$m*2]);
					$detail_val = trim($varArr[$m*2+1]);
					if($detail_key && in_array($detail_key,$allow)){
						$details_data[$detail_key] = $detail_val;
					}
				}
			}
		}
	}
	return $details_data;
}

function compress_html($string) {
	$string = str_replace("\r\n", '', $string); //清除换行符
	$string = str_replace("\n", '', $string); //清除换行符
	$string = str_replace("\t", '', $string); //清除制表符
	$pattern = array (
		"/> *([^ ]*) *</", //去掉注释标记
		"/[\s]+/",
		"/<!--[^!]*-->/",
		"/\" /",
		"/ \"/",
		"'/\*[^*]*\*/'"
	);
	$replace = array (
		">\\1<",
		" ",
		"",
		"\"",
		"\"",
		""
	);
	return preg_replace($pattern, $replace, $string);
}


/**
 * 查找当前客户关联的是否有其他账户
 * @param $customers_id
 * @param $is_related
 * @return array
 */
function box_get_related_account($customers_id,$is_related = 0){
	global $db;
	$onCustomer = $customerEmail = $allCustomersNumberNew = array();
	$customers_email = '';
	if((int)$customers_id){
		$customer_fields = array('customers_email_address', 'customer_link_account', 'customers_number_new');
		$customer_data = fs_get_data_from_db_fields_array($customer_fields, 'customers', 'customers_id='.(int)$customers_id, 'limit 1');
		$customers_email = $customer_data[0][0];
		$customer_link_account = $is_related ? $is_related : $customer_data[0][1];
		//判断该客户是否展示关联客户的所有订单
		if($customer_link_account==1){
			$customers_number = $customer_data[0][2];
			$company_number = fs_get_data_from_db_fields('company_number','manage_customer_company_to_customers','customers_number_new="'.$customers_number.'"','limit 1');
			if($company_number){
				$all_result = $db->getAll("SELECT `customers_number_new` FROM `manage_customer_company_to_customers` WHERE `company_number`='".$company_number."'");
				foreach($all_result as $value){
					$first_number = substr($value['customers_number_new'],0,1);
					$allCustomersNumberNew[] = $value['customers_number_new'];
					if($first_number<6){
						//线上客户
						if($value['customers_number_new']!=$customers_number){
							$online_data = $db->getAll("SELECT `customers_id`,`customers_email_address` FROM `customers` WHERE `customers_number_new`='{$value['customers_number_new']}' LIMIT 1");
							if($online_data[0]['customers_id']){
								$onCustomer[] = $online_data[0]['customers_id'];
							}
							if($online_data[0]['customers_email_address']){
								$customerEmail[] = $online_data[0]['customers_email_address'];
							}
						}
					}else{
						//线下客户
						$customerEmail[] = fs_get_data_from_db_fields('customers_email_address','customers_offline','customers_number_new="'.$value['customers_number_new'].'"','limit 1');
					}
				}
			}
		}
		$onCustomer[] = $customers_id;
		$customerEmail[] = $customers_email;
	}
	$customerData = array(
		'customers_email' => $customers_email,	//当前客户的邮箱
		'onCustomer' => $onCustomer,			//关联的线上客户ID
		'customerEmail' => $customerEmail,		//关联的线上线下客户邮箱
		'allCustomersNumberNew' => $allCustomersNumberNew,  //关联所有客户编号
	);
	return $customerData;
}

/*
 * 验证访问写码接口权限
 */
function customer_box_auth_check($data){
	$key = 'szYUxuanFS2018';
	$t = $data['t'];
	$sign = $data['sign'];
	$param = $data['param'];
	if(md5($key.$t.$param)== $sign && $data['key'] == $key){
		return true;
	}else{
		return false;
	}
}

/*
 * 生成token
 */
function box_token_create($customer_id,$time=''){
	$key = 'szYUxuanFS2018';
	if(!$time)	$time = time();
	$token = md5($customer_id.$time.$key);
	return $token;
}

function check_refresh_token_validate($token,$refresh_token){
	if(md5(substr($token, 0, 2).$token)==$refresh_token){
		return true;
	}else{
		return false;
	}
}

/**
 * 验证token是否有效并更新有效时间
 * @param $token
 * @param int $valid_time
 * @param int $type,默认为1 验证token是否还有效， type=2若是token超时，验证通过需要返回新的token
 * @return mixed
 */
function check_and_refresh_token_time($token,$valid_time=7200,$type=1){
	$status = $customers_id = 0;
	$result = false;
	$msg = '';
	if($token){
		$upData = fs_get_data_from_db_fields_array(array('id','update_time','customers_id'),'customers_auth_token','token="'.$token.'"','limit 1');
		if($upData){
			$upStamp = $upData[0][1] + $valid_time;
			$customers_id = $upData[0][2];
			if($upStamp > time()){
				//token有效更新时间
				$up_arr = array("update_time"=>time());
				zen_db_perform('customers_auth_token', $up_arr, 'update', 'id='.$upData[0][0]);
				$msg = "token有效";
				$status = 1;	//有效
				$result = "true";
			}else{
				//token已经过期
				$msg = "token已经过期";
				$status = 2;	//过期
				if($type==2){
					//需要返回新的token
					$stamp = time();
					$token = box_token_create($upData[0][2],$stamp);
					$up_arr = array("start_time"=>$stamp,"update_time"=>$stamp,"token"=>$token);
					zen_db_perform('customers_auth_token', $up_arr, 'update', 'id='.$upData[0][0]);
					$msg = "Token Refresh Success";
					$result = "true";
				}
			}
			if($type==2){
				$box_id = fs_get_data_from_db_fields('customers_number_new',TABLE_CUSTOMERS,'customers_id='.$customers_id,'limit 1');
				if($box_id){
					$is_probation = fs_get_data_from_db_fields('is_probation','fs_box_customers','box_id = "'.$box_id.'"','limit 1');
					if($is_probation == 1){
						box_login($box_id,1);
					}
				}
			}
		}else{
			$msg = "该账号有其他人登录token无效";
		}
	}
	$data['info'] = array("result"=>$result,"status"=>$status,"message"=>$msg,"token"=>$token);
	$data['customers_id'] = $customers_id;
	return $data;
}

//获取父分类下所有分类包括开启和关闭
function box_get_all_subcategories(&$subcategories_array, $parent_id = 9) {
	global $db;
	$subcategories_query = "select categories_id
                            from " . TABLE_CATEGORIES . "
                            where parent_id = " . (int)$parent_id;
	$subcategories_query .= " order by sort_order ";

	$subcategories = $db->Execute($subcategories_query);

	while (!$subcategories->EOF) {
		$subcategories_array[sizeof($subcategories_array)] = $subcategories->fields['categories_id'];
		if ($subcategories->fields['categories_id'] != $parent_id) {
			box_get_all_subcategories($subcategories_array, $subcategories->fields['categories_id']);
		}
		$subcategories->MoveNext();
	}
}

/**
 * 获取FS BOX支持写码的分类，1.一级分类9下除了二级分类3389和三级分类3058都支持写码 2.特殊定制一级分类3433下的四级分类3286,3287也支持写码
 */
function get_box_validate_categories($is_have_box = 0){
	$subcategories_query_md5 = md5('transceivers_subcategories_by_parent_id_9_'.$is_have_box);
	$redis_categories = get_redis_key_value($subcategories_query_md5,'box_sub_categories_all');
	$subcategories_array = [];
	if(!$redis_categories){
		//当前分类下的所有子分类若没有存入redis中就查询数据库
		box_get_all_subcategories($subcategories_array, 9);
		set_redis_key_value($subcategories_query_md5,$subcategories_array,24*3600,'box_sub_categories_all');
	}else{
		foreach($redis_categories as $key=>$value){
			$subcategories_array[sizeof($subcategories_array)] = $value;
		}
	}
	//Special Custom[3433]以及分类下的四级分类3286和3287下的产品也支持改码
	$subcategories_array[] = 3286;$subcategories_array[] = 3287;
	//将数组中重复的分类id去掉
	$subcategories_array = array_flip($subcategories_array);
	//光模块下的三级分类3389和3058下的产品不支持写码
	if($is_have_box != 1){
		unset($subcategories_array['3389']);//FS BOX
	}
	unset($subcategories_array['3058']);
	//返回的数组key是分类ID
	return $subcategories_array;
}
function getMicrotime(){
	list($usec, $sec) = explode(' ', microtime());    return (float)$usec + (float)$sec;
}

function getBoxAccountInfo($email){
	$result = array();
	if($email){
		$fields = [
			'account_type',
			'is_probation',
			'account_status',
			'apply_status',
			'close_time',
			'code_warning',
			'code_limit',
			'online_count',
			'boxPro_count',
			'diagnosing_count',
			'afterSale_count',
		];
		$box_info = fs_get_data_from_db_fields_array($fields,'fs_box_customers','box_email = "'.trim($email).'"','order by id desc limit 1');
		if($box_info){
			foreach ($fields as $k=>$v){
				$result[$v] = (int)$box_info[0][$k];
			}
		}
	}
	return $result;
}

//登录权限和写码权限
function checkAccount($email,$is_visited = 0){
	if(empty($email)){
		return 0;
	}
	$box_info = getBoxAccountInfo($email);
	$stuff_email = explode('@',$email);
	if($box_info){
		//有记录
		$result = $box_info['account_status'];
		if($result == 2 && $box_info['close_time'] > time()){
			//五天限制未到
			$result = 1;
		}
		if($box_info['is_probation'] == 1){
			$result = 11;
		    //试用期内判断是否自动转为普通
            $customer_fields = array('customers_id', 'customers_number_new');
            $customer_data = fs_get_data_from_db_fields_array($customer_fields, 'customers', 'customers_email_address="'.$email.'"', 'limit 1');
            $customers_id = $customer_data[0][0];
            $orders = get_customer_orders($customers_id,1,1);
            $check_box = checkOrderProducts($orders);
            if($check_box){
                //BOX和模块都有，试用期账号转为普通账号
				$box_id = $customer_data[0][1];
				$company_number = fs_get_data_from_db_fields(
					'company_number',
					'manage_customer_company_to_customers',
					'customers_number_new = "'.$box_id.'"',
					'limit 1'
				);
				$account_status = 1;
				$close_time = $box_info['close_time'];
				$error_info = fs_get_data_from_db_fields_array(
					['apply_status', 'close_time'],
					'fs_box_error_records',
					'company_number = "'.$company_number.'"',
					'order by id desc limit 1'
				);
				if($error_info){
					if($error_info[0][0] != 2){
						$account_status = 2;
						$close_time = $error_info['close_time'];
					}
				}
                zen_db_perform('fs_box_customers', array(
                    'is_probation' => 2,
					'online_count' => 0,
					'boxPro_count' => 0,
					'diagnosing_count' => 0,
					'afterSale_count' => 0,
                    'account_status' => $account_status,
					'close_time' => $close_time,
					'comments' => '系统自动同步',
                    'updated_at' => date("Y-m-d H:i:s",time())
                ), 'update', 'box_email = "'.$email.'"');
                $apply_id = fs_get_data_from_db_fields(
                    'id',
                    'fs_box_apply_records',
                    'box_email = "'.$email.'" and apply_type = 1 and apply_status = 1 ',
                    'order by id desc limit 1'
                );
                if($apply_id){
                    zen_db_perform('fs_box_apply_records', array(
                        'apply_status' => 2,
                        'apply_comments' => '系统自动同步',
                        'updated_at' => date("Y-m-d H:i:s",time())
                    ), 'update', 'id = "'.$apply_id.'"');
                }
				$result = 1;
            }elseif ($box_info['close_time'] < time()){
                //试用期7天试用时间已过
                $result = 12;
            }
		}
		$code_times = $box_info['online_count'] + $box_info['boxPro_count'] + $box_info['diagnosing_count'];
		if($box_info['account_type'] == 2 && $code_times >= $box_info['code_limit']){
			$result = 0;
		}
	}elseif(!in_array($stuff_email[1],array('feisu.com','fs.com','szyuxuan.com'))){
		//新增记录
		$result = newBoxAccount($email,$is_visited);
	}else{
		$result = 0;
	}
	return $result;
}

function newBoxAccount($email,$is_visited){
	if(empty($email)){
		return 0;
	}
	//获取订单信息判断是否为试用期
	//判断此账号所在G编号和此G编号关联的其他G编号下的全部订单是否包含FS BOX和模块类产品
	$customer_fields = array('customers_id', 'customers_number_new');
	$customer_data = fs_get_data_from_db_fields_array($customer_fields, 'customers', 'customers_email_address="'.$email.'"', 'limit 1');
	$customers_id = $customer_data[0][0];
	$orders = get_customer_orders($customers_id,1,1);
	$check_box = checkOrderProducts($orders);
	$now = date("Y-m-d H:i:s",time());

	$box_id = $customer_data[0][1];
	if(!$box_id){
		return 0;
	}
	//查询G编号限制情况  如果G编号已被限制
	$company_number = fs_get_data_from_db_fields(
		'company_number',
		'manage_customer_company_to_customers',
		'customers_number_new = "'.$box_id.'"',
		'limit 1'
	);
	$error_info = fs_get_data_from_db_fields_array(
		['apply_status', 'close_time'],
		'fs_box_error_records',
		'company_number = "'.$company_number.'"',
		'order by id desc limit 1'
	);
	$account_status = 1;
	$status = 1;
	$is_probation = 0;
	if($error_info){
		if($error_info[0][0] != 2){
			$account_status = 2;
			if($error_info[0][1] <= time()){
				//普通账号异常后到期
				$status = 2;
			}
		}
	}else{
		//查询是否白名单
		$id = fs_get_data_from_db_fields(
			'id',
			'fs_box_apply_records',
			'apply_type = 2 and apply_status = 2 and company_number = "'.$company_number.'"',
			'order by id desc limit 1'
		);
		if($id){
			$is_probation = 3;
		}
	}

	$box_arr = array(
		'box_id' => $box_id,
		'box_email' => $email,
		'account_type' => 1,
		'account_status' => $account_status,
		'close_time' => $error_info[0][1] ? $error_info[0][1] : 0,
		'created_at' => $now,
		'updated_at' => $now,
	);

	if(!$is_visited){
		//没登录过BOX
		if(!$check_box){
			//创建试用期账号
			$is_probation = 1;
			$box_arr['close_time'] = time() + 3600*24*7;
			$status = 11;
		}
	}

	$box_arr['is_probation'] = $is_probation;
	zen_db_perform('fs_box_customers', $box_arr);
	return $status;
}

function checkOrderProducts($orders){
	if(sizeof($orders) >= 1){
		foreach ($orders as $order){
			$pidArr = array_column($order['orderProducts'], 'proId');
			if (sizeof($orders) == 1) {
				if (sizeof($pidArr)>1) {
					if(in_array(96657,$pidArr) || in_array(75866,$pidArr)){
						return true;
					}
				}
			} else {
				if(in_array(96657,$pidArr) || in_array(75866,$pidArr)){
					return true;
				}
			}
		}
	}
	return false;
}

//记录登录时长
function box_login($box_id,$logoff = 0,$time = ''){
    if($box_id){
        if($time == ''){
            $time = time();
        }
        if($logoff == 0){
            //登录
            zen_db_perform(
                'fs_box_login_log',
                ['box_id' => $box_id, 'login_time' => $time]
            );
        }else{
            $log_id = fs_get_data_from_db_fields(
                'id',
                'fs_box_login_log',
                'box_id='.$box_id,
                'order by id desc limit 1'
            );
            if($log_id){
                //登出
                zen_db_perform(
                    'fs_box_login_log',
                    ['box_id' => $box_id, 'logoff_time' => $time],
                    'update',
                    'id = "'.$log_id.'"'
                );
            }
        }
    }
}


//获取所有可写码型号名
function getAllModelName(){
	$result = [];
	$all_categories = get_box_validate_categories();
	if(sizeof($all_categories)){
		global $db;
		$all_categories = implode(',',$all_categories);
		$sql = "SELECT o.products_model FROM `products` o LEFT JOIN `products_to_categories` ptc using(products_id) WHERE o.products_model != '' and ptc.categories_id in (".$all_categories.") GROUP BY o.products_model";
		$query = $db->Execute($sql);
		while(!$query->EOF){
			$result[] = $query->fields['products_model'];
			$query->MoveNext();
		}
	}
	return $result;
}
?>

