<?php
function zen_get_orders_shipping_total($oid){
  global $db;
  $order = $db->Execute("select value from orders_total where orders_id ='". $oid ."' and sort_order = 200 ");
  return ($order->fields['value']);
}

function zen_order_tracking_number_exist($orders_id){
	global $db;
	
	$result = $db->Execute("select count(order_tracking_id) as total from " . TABLE_ORDERS_TRACKING_INFO . " where language_id = ".(int)$_SESSION['languages_id']." and  
	                       orders_id = '" . (int)$orders_id ."' order by order_tracking_id desc limit 1");
	
	return ($result->fields['total'] > 0) ? true  : false;
	
}

function zen_get_order_tracking_info($orders_id,$number_id = 1){
	global $db;
	$result = $db->Execute("select * from ".TABLE_ORDERS_TRACKING_INFO." 
	                        where language_id = ".(int)$_SESSION['languages_id']." 
	                        and  orders_id = '" . (int)$orders_id ."' and number_id = '" . (int)$number_id ."' order by order_tracking_id desc limit 1");
	return array('shipping_method' => $result->fields['shipping_method'],'tracking_number'=>$result->fields['tracking_number']);
}

//是否有额外订单号信息
function zen_get_extra_order_tracking_info($orders_id,$number_id = 2){
    global $db;
    $result = $db->Execute("select count(order_tracking_id) as total from ".TABLE_ORDERS_TRACKING_INFO."
	                        where language_id = ".(int)$_SESSION['languages_id']."
	                        and  orders_id = '" . (int)$orders_id ."' and number_id = '" . (int)$number_id ."' order by order_tracking_id ");
    return ($result->fields['total'] > 0) ? true  : false;
}
//根据订单ID获取订单的所有状态
function zen_get_order_all_status($order_id){
	global $db;
	$statusArray = array();
	$id = array();
	$statuses_query = "SELECT os.orders_status_name, osh.date_added, osh.comments,osh.admin_id,os.orders_status_id as id
					   FROM   " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh
					   WHERE      osh.orders_id = :ordersID
					   AND        osh.orders_status_id = os.orders_status_id
					   AND        os.language_id = :languagesID
					   AND        osh.customer_notified >= 0
					   ORDER BY   osh.date_added desc";

	$statuses_query = $db->bindVars($statuses_query, ':ordersID', intval($order_id), 'integer');
	$statuses_query = $db->bindVars($statuses_query, ':languagesID', $_SESSION['languages_id'], 'integer');
	$statuses = $db->Execute($statuses_query);
	while (!$statuses->EOF) {
		if(!in_array($statuses->fields['id'],$id)){
			$statusArray[$statuses->fields['id']] = array(
				'id'=>$statuses->fields['id'],
				'date_added'=>$statuses->fields['date_added'],
				'orders_status_name'=>$statuses->fields['orders_status_name'],
				'comments'=>$statuses->fields['comments'],
				'admin_id'=>$statuses->fields['admin_id']
			  );
		}
		$id[] = $statuses->fields['id'];
		$statuses->MoveNext();
	}
	//由于转运单在更新运单号的时候同时触发11[Order Packed]和12[In Transit]状态，两节点时间一样11对应的状态记录会在12后面，需调整为11操作应该在12前面
	if(in_array(11,$id) && in_array(12,$id)){
		$packed = $statusArray[11];
		$transit = $statusArray[12];
		$i=0;
		foreach($statusArray as $key=>$val){
			$i++;
			//找到11和12 在数组中出现的顺序
			if($key==11){$packed_key = $i;}
			if($key==12){$transit_key = $i;}
		}
		if($packed_key<$transit_key){
			//11在12后面 需要调整顺序
			$statusArray[11] = $transit;
			$statusArray[12] = $packed;
		}
	}
	return $statusArray;
}

function zen_get_order_tracking_info_by_num($num){
	$shipping_method = fs_get_data_from_db_fields('shipping_method','order_tracking_info','tracking_number="'.$num.'"','limit 1');
	switch ($shipping_method){
		case 'DHL':
		$compare = 'dhlen';
		break;
		
		case 'EMS':
		$compare = 'emsinten';
		break;
		
		case 'Fedex':
        case 'FEDEX IP':
        case 'FEDEX IE':
		case 'FedEx 2Day':
		$compare = 'fedexus';
		break;
		
		case 'AIRMAIL':
		$compare = 'hkpost';
		break;
		
		case 'USPS':
        case 'UPS':
		case 'UPS 2nd DAY Air':
		case 'UPS Day Air':
		case 'UPS Ground':
		$compare = 'upsen';
		break;
		
		case 'TNT':
		$compare = 'tnten';
		break;
	}
	
	$AppKey='7df3c3830e9806ec';//申请到的KEY
	$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$compare.'&nu='.$num.'&show=2&muti=1&order=asc';
	$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';

	//优先使用curl模式发送数据
	if (function_exists('curl_init') == 1){
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_HEADER,0);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		curl_setopt ($curl, CURLOPT_TIMEOUT,5);
		$tracking_info = curl_exec($curl);
		curl_close ($curl); 
	}else{
		include(DIR_WS_CLASSES.'fiberstore_tracking_info.php');
		$snoopy = new snoopy();
		$snoopy->referer = 'http://www.google.com/';
		$snoopy->fetch($url);
		$tracking_info = $snoopy->results; 
	}
	$old_time =array('时间');
	$old_fields =array('地点和跟踪进度');
	$new_time =array('Time');
	$new_fields =array('Location and tracking progress');
 
	$number_o = array('单号');
	$number_o_re = array('Tracking Number ');
	$no_info = array('，没有查到相关信息。单号暂未收录或已过期');
	$no_info_re = array(',Did not check the related information. Tracking Number were not included temporarily or has expired');
 
	$no_error = array('快递公司网络异常，请稍后查询.');
	$no_error_re = array('Express company network abnormal, please check later.');

	$parameter_error = array('公司参数不正确,请核查相关代码。');
	//$parameter_error_re = array('It seemed that something was wrong');
	$parameter_error_re = array('');
 
	$no_data = array('<p style=line-height:28px;margin:0px;padding:0px;color:#F21818;>快递公司网络异常，请稍后查询. http://ckd.im/app</p>');
	$no_data_re = array('<p style="line-height:28px;margin:0px;padding:0px;color:#F21818;">Express company network abnormal, please check later</p>');

	$table_style = array('<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px;margin-top:-26px;" id="showtablecontext">');
	$table_style_re = array('<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px;margin-top:-6px;" id="showtablecontext">');
 
	$old_width = array('163');
	$new_width = array('20%');
	$old_width2= array('354');
	$new_width2= array('60%');
	$old_width3= array('520px');
	$new_width3= array('100%');
	$line_old = array('border:1px solid #e5e5e5;font-size:12px;line-height:22px;padding:3px 5px;');
	$line_new = array('');
	$hidde_old = array('border-collapse:collapse;border-spacing:0;');
	$hidde_new = array('border-collapse:collapse;border-spacing:0px;padding-top:-26px;');
 
	$re_style = array('background:#64AADB;border:1px solid #75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;');
	$re_style_new = array('background:#64AADB;border:1px solid #75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;display:none;');
 
	$tracking_info = str_replace($old_time, $new_time, $tracking_info);
	$tracking_info = str_replace($old_fields, $new_fields, $tracking_info);
	$tracking_info = str_replace($old_width, $new_width, $tracking_info);
	$tracking_info = str_replace($old_width2, $new_width2, $tracking_info);
	$tracking_info = str_replace($old_width3, $new_width3, $tracking_info);
	$tracking_info = str_replace($line_old, $line_new, $tracking_info);
  
	$tracking_info = str_replace($re_style, $re_style_new, $tracking_info);
	$tracking_info = str_replace($hidde_old, $hidde_new, $tracking_info);
  
	$tracking_info = str_replace($no_info, $no_info_re, $tracking_info);
  
	$tracking_info = str_replace($no_data, $no_data_re, $tracking_info);
	$tracking_info = str_replace($no_error, $no_error_re, $tracking_info);
	$tracking_info = str_replace($number_o, $number_o_re, $tracking_info);

	$tracking_info = str_replace($parameter_error, $parameter_error_re, $tracking_info);
	$tracking_info = str_replace($table_style, $table_style_re, $tracking_info);
	return $tracking_info ;
}

/*
 * 获取物流信息
 * 2019.4.1 fairy add dhl物流接口不用快递100的
 * @para $is_handle_html：是否处理html结构 2018.1.7 fairy add
 */
function fs_order_shipping_info_kuaidi100($shipping_method,$num,$is_handle_html=true){
	$tracking_company = '';
	switch (1) {
		case preg_match('/dhl/i', $shipping_method):
			//$tracking_company = 'dhlen'; //快递100是这个
			$tracking_company = 'dhl';
			break;

		case preg_match('/ems/i', $shipping_method):
			$tracking_company = 'emsinten';
			break;

		case preg_match('/fedex/i', $shipping_method):
			$tracking_company = 'fedex';
			break;

		case preg_match('/airmail/i', $shipping_method):
			$tracking_company = 'hkpost';
			break;

		case preg_match('/ups/i', $shipping_method):
			$tracking_company = 'ups';
			break;

		case preg_match('/tnt/i', $shipping_method):
			$tracking_company = 'tnt';
			break;

        case preg_match('/startrack/i', $shipping_method):
            $tracking_company = 'startrack';
            break;

        case preg_match('/ninja/i', $shipping_method):
            $tracking_company = 'ninjavan';
            break;

        case preg_match('/simplypost/i', $shipping_method):
            $tracking_company = 'simplypost';
            break;

        case preg_match('/Australia Post/i', $shipping_method):
            $tracking_company = 'aupost';
            break;
	}

	$num = trim($num);
	$html = array();
	if(in_array($tracking_company,['ups','fedex','dhl','startrack','tnt','simplypost','aupost','ninjavan'])){
		$html = zen_get_express_tracking_info($tracking_company,$num,$is_handle_html=true);
	}else{
		//参数设置
		$post_data = array();
		$post_data["customer"] = '548CC53DDD98BE5CD213967C8936A20F';
		$key= 'ukdrjQpp6200' ;
		$post_data["param"] = '{"com":"'.$tracking_company.'","num":"'.$num.'"}';

		$url='http://poll.kuaidi100.com/poll/query.do';
		$post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
		$post_data["sign"] = strtoupper($post_data["sign"]);
		$o=""; 
		foreach ($post_data as $k=>$v)
		{
			$o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
		}
		$post_data=substr($o,0,-1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$result = curl_exec($ch);
		curl_close ($ch);
		$data = str_replace("\&quot;",'"',$result );
		$data = json_decode($data);
		if($data->message=="ok"){
			$info = $data->data;
			if($is_handle_html){
                $html['data'] = '';
                $html['data'] .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px;padding-top:-26px;margin-top:-6px;" id="showtablecontext">';
                $html['data'] .= '<tbody>';
                $html['data'] .= '<tr>';
                $html['data'] .= '<td width="20%" style="background:#64AADB;border:1px solid
								#75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;display:none;">Time</td>
							  <td width="60%" style="background:#64AADB;border:1px solid #75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;display:none;">Location and tracking progress</td>
							  </tr>';
                foreach($info as $k=>$v){
                    $html['data'] .= '<tr>';
                    $html['data'] .= '<td width="20%">' . $v->time . '</td>';
                    $html['data'] .= '<td width="60%">' . $v->context . '</td>';
                    $html['data'] .= '</tr>';
                    $info[$k]->time = strtotime($v->time); //统一成时间戳
                }
                $html['data'] .= '</tbody></table>';
            }else{
				foreach($info as $k=>$v){
					$info[$k]->time = strtotime($v->time); //统一成时间戳
				}
			}
			$html['info'] = $data;
            $html['info']->current_status = preg_replace('/\[.*\]/','',$info[0]->context);  // 运输的当前状态 2019.3.26 fairy add
			$html['info_str'] = $info; //处理之后的
		}
	}
	return $html;
}

/*
 * 把fs_order_shipping_info_kuaidi100方法的html结构处理单独分离出来，方便修改。暂时是订单详情页面使用
 * fairy 2018.12.7 add
 * @return：展示的html字符串
 */
function fs_order_shipping_info_kuaidi100_handle($shipping_method,$num){
    $html = '';
    $data = fs_order_shipping_info_kuaidi100($shipping_method,$num,false);
    if($data && $data['info_str'] && sizeof($data['info_str'])){
        foreach ($data['info_str'] as $key => $val){
            $time = $val->time;
            $html .= '<li>
                <span class="details_Point"><em></em></span>
                <div class="details_schedule_left">'.get_all_languages_date_display($time,'default2').'</div>
                <p class="details_schedule_right new_alone_padding_left">'.$val->context.'</p>
            </li>';
        }
    }
    return $html;
}

/*
 * 获取不同快递的物流信息
 * @param1 string $comCode,快递公司对应的code值,eg：ups/fedex 
 * @param2 string $num,快递号
 * @para $is_handle_html：是否处理html结构 2018.1.7 fairy add
 */
function zen_get_express_tracking_info($comCode,$num,$is_handle_html){
	$data = array();
	if($comCode && $num){
		// 接口换了新地址
        $baseUrl = 'http://arms.whgxwl.com:8080/express/track?';
        //$baseUrl = 'http://arms-dev.whgxwl.com:8080/express/track?';//测试站接口
		$paramsArr = [
			'express' => $comCode,
			'location' => 'delaware',
			'tracking_number' => $num
		];
		switch ($comCode){
            case 'startrack':
            case 'aupost':
                $paramsArr['location'] = 'australia';
                break;
            case 'ninjavan':
                $paramsArr['location'] = 'singapore';
                break;
            case 'tnt':
                $paramsArr['location'] = 'germany';
                break;
        }
		$params = http_build_query($paramsArr);
		$headers = [
			'Accept:application/prs.armory.v1+json'
		];
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $baseUrl . $params);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);

		$res = curl_exec($curl);
		curl_close($curl);
		$res = json_decode($res);
		if($res->status_code=='200'){
			$resData = $res->data->details;
			$html = '';
			if(sizeof($resData)){
			    if($is_handle_html){
                    $html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px;padding-top:-26px;margin-top:-6px;" id="showtablecontext">';
                    $html .= '<tbody>';
                    $html .= '<tr>';
                    $html .= '<td width="20%" style="background:#64AADB;border:1px solid
									#75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;display:none;">Time</td>
								  <td width="60%" style="background:#64AADB;border:1px solid #75C2EF;color:#FFFFFF;font-size:14px;font-weight:bold;height:28px;line-height:28px;text-indent:15px;display:none;">Location and tracking progress</td>
								  </tr>';
                }
                $new_resData = array();
                $is_ninja_way = false;
                $is_ninja_time = 0;
                foreach ($resData as $time_val){
                    if(in_array($time_val->Status, ['PARCEL_ROUTING_SCAN', 'DRIVER_INBOUND_SCAN'])){
                        $is_ninja_time = $time_val->Timestamp;
                    }
                }
				foreach($resData as $val){
					if($val->Timestamp){
                        if($comCode == 'ninjavan') {
                            switch ($val->Status) {
                                case 'DRIVER_PICKUP_SCAN':
                                    $val->Status = FS_ORDERS_TRACKING_NINJA_STATUS1;
                                    break;
                                case 'PARCEL_ROUTING_SCAN':
                                case 'DRIVER_INBOUND_SCAN':
                                    if(!$is_ninja_way) {
                                        $val->Timestamp = $is_ninja_time;
                                        $val->Status = FS_ORDERS_TRACKING_NINJA_STATUS3;
                                        $is_ninja_way = true;
                                    }else{
                                        continue 2;
                                    }
                                    break;
                                case 'HUB_INBOUND_SCAN':
                                    $val->Status = FS_ORDERS_TRACKING_NINJA_STATUS2;
                                    break;
                                case 'DELIVERY_SUCCESS':
                                    $val->Status = FS_ORDERS_TRACKING_NINJA_STATUS4;
                                    break;
                            }
                        }

						$content = '';
						$content .= $val->Address->City ? $val->Address->City . ', ' : '';
						$content .= $val->Address->StateProvinceCode ? $val->Address->StateProvinceCode . ', ' : '';
						if($comCode=='ups'){
							if($val->Address->CountryCode){
								$CountryCode = strtoupper($val->Address->CountryCode);
								$countryName = fs_get_data_from_db_fields('countries_name','countries','countries_iso_code_2="'.$CountryCode.'"','limit 1');
								$content .= $countryName ? $countryName : '';
							}
						}
						$content = trim($content);
						$content = trim($content,',');
						$content = $content ? '['.$content.'] '.$val->Status : $val->Status;

                        $time = gmdate('Y-m-d H:i:s', $val->Timestamp);
                        if($is_handle_html){
                            $html .= '<tr>';
                            $html .= '<td width="20%">' . $time . '</td>';
                            $html .= '<td width="60%">' . $content . '</td>';
                            $html .= '</tr>';
                        }
                        $val->context = $content; //把处理之后的
                        $val->time = strtotime($time); //把处理之后的
                        $new_resData[] = $val;
					}
				}
                if($is_handle_html) {
                    $html .= '</tbody></table>';
                }
			}
            if($is_handle_html) {
                $data['data'] = $html;
            }
			$data['info'] = $res->data;
            $data['info']->current_status = $new_resData[0]->Status;  // 运输的当前状态 2019.3.26 fairy add
			$data['info_str'] = $new_resData; //处理之后的
		}
	}
	return $data;
}

/**
 * 注意：该函数没有什么大的逻辑，就是看对接人要显示成什么。
 * @function: 由于订单状态处于12时（in transit）,会有一个预计送达时间，以及预计送达时间是谁提供的。所以：下面的函数就是获取物流公司
 * @param $shipping_method,它是order_tracking_info表中的shipping_method字段
 * @return string 同事Clain要显示的公司名称
 * @author:liang.zhu
 * 2019-06-22 10:56:01
 */
function get_shippging_method_company($shipping_method)
{
    $temp = $shipping_method;
    switch (1) {
        case preg_match('/dhl/i', $shipping_method):
            //$tracking_company = 'dhlen'; //快递100是这个
            $temp = 'DHL';
            break;
        case preg_match('/ems/i', $shipping_method):
            $temp = 'EMS';
            break;
        case preg_match('/fedex/i', $shipping_method):
            $temp = 'Fedex';
            break;
        case preg_match('/airmail/i', $shipping_method):
            $temp = 'hkpost';
            break;
        case preg_match('/ups/i', $shipping_method):
            $temp = 'UPS';
            break;
        case preg_match('/tnt/i', $shipping_method):
            $temp = 'TNT';
            break;
        case preg_match('/Forwarder(\s+)Shipping/i', $shipping_method):
            $temp = 'Forwarder Shipping';
            break;
       case preg_match('/StarTrack(\s+)Premium/i', $shipping_method):
            $temp = 'StarTrack';
    }
    return $temp;
}

/**
 * @function:由快递方式和快递单号发送curl请求
 * @param $comCode快递方式
 * @param $num快递单号
 * @param $warehouse是订单的发货仓，目前利用的是orders表中的warehouse字段。
 * @return mixed curl请求回来的结果
 * @author:liang.zhu
 * 2019-06-18 11:40:27
 */
function get_tracking_info($comCode, $num, $warehouse)
{
    // 接口换了新地址
    $baseUrl = 'http://arms.whgxwl.com:8080/express/track?';
    //$baseUrl = 'http://arms-dev.whgxwl.com:8080/express/track?';//测试站接口
    $paramsArr = [
        'express'         => $comCode,
        'location'        => 'delaware',
        'tracking_number' => $num
    ];
    //下面的转化，其实是接口传参的要求：$paramsArr['express']只能是以下的值
    //dhl fedex ups tnt startrack   这是kaka 提供的目前几个
    switch (1) {
        case preg_match('/dhl/i', $paramsArr['express']):
            //$tracking_company = 'dhlen'; //快递100是这个
            $paramsArr['express'] = 'DHL';
            break;
        case preg_match('/ems/i', $paramsArr['express']):
            $paramsArr['express'] = 'emsinten';
            break;
        case preg_match('/fedex/i', $paramsArr['express']):
            $paramsArr['express'] = 'Fedex';
            break;
        case preg_match('/airmail/i', $paramsArr['express']):
            $paramsArr['express'] = 'hkpost';
            break;
        case preg_match('/ups/i', $paramsArr['express']):
            $paramsArr['express'] = 'UPS';
            break;
        case preg_match('/tnt/i', $paramsArr['express']):
            $paramsArr['express'] = 'TNT';
            break;
        case preg_match('/startrack/i', $paramsArr['express']):
            $paramsArr['express'] = 'startrack';
            break;
        case preg_match('/simplypost/i', $paramsArr['express']):
            $paramsArr['express'] = 'simplypost';
            break;

        case preg_match('/Australia Post/i', $paramsArr['express']):
            $paramsArr['express'] = 'aupost';
            break;
    }
    if (strtolower($paramsArr['express']) == 'tnt' || strtolower($paramsArr['express']) == 'dhl') {
        //这个是接口参数的需要
        $paramsArr['location'] = 'germany';
    }
    if (strtolower($paramsArr['express']) == 'startrack') {
        $paramsArr['location'] = 'australia';
    }
    if (strtolower($paramsArr['express']) == 'fedex') {
        if ($warehouse == 2) {//武汉仓
            $paramsArr['location'] = 'wuhan';
        } else {
            $paramsArr['location'] = 'delaware';
        }
    }
    if (strtolower($paramsArr['express']) == 'ups') {
        if ($warehouse == 20) { //德国仓
            $paramsArr['location'] = 'germany';
        } else {
            $paramsArr['location'] = 'delaware';
        }
    }

    $paramsArr['express'] = strtolower($paramsArr['express']);
    $params = http_build_query($paramsArr);
    $headers = [
        'Accept:application/prs.armory.v1+json'
    ];

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $baseUrl . $params);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);

    $res = curl_exec($curl);
    curl_close($curl);
    $res = json_decode($res, true);

    return $res;
}

/**
 * @function: 由于order_tracking_info中保存的shipping_method有的超长，展示在页面中UPS Express Plus Next day 9:00（111，222，333）时会影响样式好看，
 * 所以用户流程分析部的同事Clain为每个快递一个简称。所以需要匹配分析。最终展示如下：UPS Next day 9:00 （111，222， 333）
 * @param $shipping_method转化之前order_tracking_info中的shipping_method字段
 * @return string 转化后的简称
 * @author:liang.zhu
 * 2019-06-18 16:11:34
 */
function get_short_shippind_method($shipping_method)
{
    switch (1) {
        case preg_match('/UPS(\s+)2nd(\s+)Day(.*)/i', $shipping_method):
            $temp = 'UPS 2nd Day';
            break;
        case preg_match('/UPS(\s+)Ground(.*)/i', $shipping_method):
            $temp = 'UPS Ground';
            break;
        case preg_match('/UPS(\s+)Next(\s+)Day(.*)/i', $shipping_method):
            $temp = 'UPS Next Day';
            break;
        case preg_match('/UPS(\s+)Express(\s+)1-3(.*)/i', $shipping_method):
            $temp = 'UPS';
            break;
        case preg_match('/UPS(\s+)Standard(.*)/i', $shipping_method):
            $temp = 'UPS Standard';
            break;
        case preg_match('/UPS(.*)Saver(.*)/i', $shipping_method):
            $temp = 'UPS Saver Next Day';
            break;
        case preg_match('/UPS(.*)9:00(.*)/i', $shipping_method):
            $temp = 'UPS Next day 9:00';
            break;
        case preg_match('/UPS(.*)12:00(.*)/i', $shipping_method):
            $temp = 'UPS Next day 12:00';
            break;

        case preg_match('/FedEx(\s+)Overnight(.*)/i', $shipping_method):
            $temp = 'FedEx Overnight';
            break;
        case preg_match('/FedEX(\s+)2Day(.*)/i', $shipping_method):
            $temp = 'FedEX 2Day';
            break;
        case preg_match('/FedEX(\s+)Ground(.*)/i', $shipping_method):
            $temp = 'FedEX Ground';
            break;
        case preg_match('/FedEx(\s+)same(\s+)day/i', $shipping_method):
            $temp = 'FedEx same day';
            break;
        case preg_match('/FedEx(\s+)International(\s+)Economy/i', $shipping_method):
            $temp = 'FedEx IE';
            break;
        case preg_match('/FedEx(\s+)International(\s+)Priority/i', $shipping_method):
            $temp = 'FedEx IP';
            break;
        case preg_match('/FedEx(\s+)Priority(\s+)Overnight/i', $shipping_method):
            $temp = 'FedEx Priority Overnight';
            break;

        case preg_match('/DHL(.*)Business(\s+)Days/i', $shipping_method):
            $temp = 'DHL';
            break;
        case preg_match('/DHL(.*)Domestic(.*)/i', $shipping_method):
            $temp = 'DHL Domestic';
            break;
        case preg_match('/DHL(.*)9:00(.*)/i',$shipping_method):
            $temp = 'DHL 9:00';
            break;
        case preg_match('/DHL(.*)Worldwide(.*)/i', $shipping_method):
            $temp = 'DHL Worldwide';
            break;

        case preg_match('/TNT(\s+)Express(.*)/i', $shipping_method):
            $temp = 'TNT Express';
            break;
        case preg_match('/TNT(\s+)Economy(\s+)Express(.*)/i', $shipping_method):
            $temp = 'TNT Economy';
            break;
        case preg_match('/TNT(\s+)Road(\s+)Express(.*)/i', $shipping_method):
            $temp = 'TNT Road Express';
            break;
        case preg_match('/TNT(\s+)Overnight(.*)/i', $shipping_method):
            $temp = 'TNT Overnight';
            break;

        case preg_match('/EMS/i', $shipping_method):
            $temp = 'EMS';
            break;

        case preg_match('/Forwarder(\s+)Shipping/i', $shipping_method):
            $temp = 'Forwarder Shipping';
            break;
        case preg_match('/StarTrack(\s+)Premium(.*)/', $shipping_method):
            $temp = 'StarTrack Premium';
			break;
		default:
			$temp = $shipping_method;
			break;
    }

    return $temp;
}
     
?>