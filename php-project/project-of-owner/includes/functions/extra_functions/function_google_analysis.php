<?php
/**
*获取客户端ip fallwind  2016.10.13
*/
function getCustomersIP(){
	global $ip;
	if(getenv("HTTP_CLIENT_IP")){
		$ip = getenv("HTTP_CLIENT_IP");
	}elseif(getenv("HTTP_X_FORWARDED_FOR")){
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}elseif(getenv("REMOTE_ADDR")){
		$ip = getenv("REMOTE_ADDR");
	}else{
		$ip = "Unknow";
	}
    if (strpos($ip, ',') !== false) {
        $ip_arr = explode(',', $ip);
        return trim($ip_arr[0]);
    }
	return $ip;
}

/**
*根据ip获取访问客户所在的国家 fallwind  2016.10.20
*/
function getCountryByIp($ip){
	$ip_data = @json_decode(file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip));
	$customers_country='';
	if($ip_data && $ip_data->ret ==1){
		$customers_country = $ip_data->country;
	}
	return $customers_country;
}


/**
 *将通过Google广告进入网站的客户ip及一些信息保存---fs_google_analysis表
 *@params	string	$customer_ip	客户端ip	
 */
function setIpInfoToGoogleAdsTal($customer_ip){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_country = getCountryByIp($customer_ip);
	//先要查询数据库中是否已经有该条ip
	$get_ip_sql = "SELECT customer_ip,acess_num,by_google_adwords,by_google_shopping,by_ebay_shopping FROM `fs_google_analysis` WHERE `customer_ip` = '$customer_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	
	if($res->EOF==1){
		//如果没有，就添加
		$set_ip_arr = array(
			'customer_ip' =>$customer_ip,
			'country_from'=>$customers_country,
			'acess_num'=>1,
			$_SESSION['google_ads']=>1,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis', $set_ip_arr);
	}else{
		//如果有，就更新
		$acess_num = $res->fields['acess_num']+1;
		$google_adwords_num = $res->fields['by_google_adwords'];
		$google_shopping_num = $res->fields['by_google_shopping'];
		$ebay_shopping_num = $res->fields['by_ebay_shopping'];
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$google_adwords_num++;
			break;
			case 'by_google_shopping':
				$google_shopping_num++;
			break;
			default:
				$ebay_shopping_num++;
		}
		$set_ip_arr = array(
			'customer_ip' =>$customer_ip,
			'country_from'=>$customers_country,
			'acess_num'=>$acess_num,
			'by_google_adwords'=>$google_adwords_num,
			'by_google_shopping'=>$google_shopping_num,
			'by_ebay_shopping'=>$ebay_shopping_num,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis', $set_ip_arr,'update','customer_ip="'.$customer_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
}

/**
 *通过Google广告进入网站同时注册了--保存信息到fs_google_analysis_son表
 *@params	string	$customer_ip	客户端ip	
 *@params	string	$firstname		姓名
 *@params	string	$email_address	邮箱
 *@return	void
 *@author	fallwind				2016.10.24
 */
function setComeIpByRegis($customer_come_ip,$firstname,$email_address){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_country = getCountryByIp($customer_come_ip);
	
	//根据客户注册时的邮箱和name查询客户id
	$get_customers_id_sql = "SELECT customers_id FROM `customers` WHERE `customers_firstname` = '$firstname' AND `customers_email_address` = '$email_address'";
	$customers_id_res = $db->Execute($get_customers_id_sql);
	$customers_id = $customers_id_res->fields['customers_id'];
	
	//先查询是否有相同的ip
	$get_ip_sql = "SELECT customer_come_ip,regis_info,regis_num,by_type FROM `fs_google_analysis_son` WHERE `customer_come_ip` = '$customer_come_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	
	if($res->EOF==1){
		//没有重复的ip，执行添加
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type = '1,0,0';
			break;
			case 'by_google_shopping':
				$by_type = '0,1,0';
			break;
			default:
				$by_type = '0,0,1';
			break;
		}
		$regis_info = $customers_id.','.$firstname.','.$email_address.','.$by_type;
		$set_ip_arr = array(
			'customer_come_ip' =>$customer_come_ip,
			'regis_info'=>$regis_info,
			'regis_num'=>1,
			'country'=>$customers_country,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son', $set_ip_arr);	
	}else{
		//如果已经有相同ip，执行更新
		$regis_info_old = explode(',',$res->fields['regis_info']);
		$regis_num = $res->fields['regis_num']+1;
		$by_type_old = explode(',',$res->fields['by_type']);
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type_fnum = $by_type_old[0]+1;
				$by_type = $by_type_fnum.','.$by_type_old[1].','.$by_type_old[2];
				
				$f = $regis_info_old[3]+1;
				$s = !empty($regis_info_old[4]) ? $regis_info_old[4] : 0;
				$t = !empty($regis_info_old[5]) ? $regis_info_old[5] : 0;
			break;
			case 'by_google_shopping':
				$by_type_snum = $by_type_old[1]+1;
				$by_type = $by_type_old[0].','.$by_type_snum.','.$by_type_old[2];
			
				$f = !empty($regis_info_old[3]) ? $regis_info_old[5] : 0;
				$s = $regis_info_old[4]+1;
				$t = !empty($regis_info_old[5]) ? $regis_info_old[5] : 0;
			break;
			default:
				$by_type_tnum = $by_type_old[2]+1;
				$by_type = $by_type_old[0].','.$by_type_old[1].','.$by_type_tnum;
				
				$f = !empty($regis_info_old[3]) ? $regis_info_old[3] : 0;
				$s = !empty($regis_info_old[4]) ? $regis_info_old[4] : 0;
				$t = $regis_info_old[5]+1;
			break;
		}
		$regis_info = $customers_id.','.$firstname.','.$email_address.','.$f.','.$s.','.$t;
		$set_ip_arr = array(
			'regis_info'=>$regis_info,
			'regis_num'=>$regis_num,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son',$set_ip_arr,'update','customer_come_ip="'.$customer_come_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
	
}

/**
 *通过Google广告进入网站同时询盘了--保存信息到fs_google_analysis_son表
 *@params	string	$customer_ip	客户端ip	
 *@params	string	$name			询盘时填写的姓名
 *@params	string	$email			询盘时填写的邮箱
 *@params	string	$phone			询盘时填写的手机号
 *@return	void
 *@author	fallwind				2016.10.24
 */
function setComeIpByInquiry($customer_come_ip,$name,$email,$phone){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_country = getCountryByIp($customer_come_ip);
	
	//先查询是否有相同的ip
	$get_ip_sql = "SELECT customer_come_ip,inquiry,inquiry_num,by_type FROM `fs_google_analysis_son` WHERE `customer_come_ip` = '$customer_come_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	if($res->EOF==1){
		//没有重复的ip，执行添加
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type = '1,0,0';
			break;
			case 'by_google_shopping':
				$by_type = '0,1,0';
			break;
			default:
				$by_type = '0,0,1';
			break;
		}
		$inquiry_info = $name.','.$email.','.$phone.','.$by_type;
		$set_ip_arr = array(
			'customer_come_ip' =>$customer_come_ip,
			'inquiry'=>$inquiry_info,
			'inquiry_num'=>1,
			'country'=>$customers_country,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son', $set_ip_arr);	
	}else{
		//如果已经有相同ip，执行更新
		$inquiry_info_old = explode(',',$res->fields['inquiry']);
		$inquiry_num = $res->fields['inquiry_num']+1;
		$by_type_old = explode(',',$res->fields['by_type']);
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type_fnum = $by_type_old[0]+1;
				$by_type = $by_type_fnum.','.$by_type_old[1].','.$by_type_old[2];
				
				$f = $inquiry_info_old[3]+1;
				$s = !empty($inquiry_info_old[4]) ? $inquiry_info_old[4] : 0;
				$t = !empty($inquiry_info_old[5]) ? $inquiry_info_old[5] : 0;
			break;
			case 'by_google_shopping':
				$by_type_snum = $by_type_old[1]+1;
				$by_type = $by_type_old[0].','.$by_type_snum.','.$by_type_old[2];
				
				$f = !empty($inquiry_info_old[3]) ? $inquiry_info_old[3] : 0;
				$s = $inquiry_info_old[4]+1;
				$t = !empty($inquiry_info_old[5]) ? $inquiry_info_old[5] : 0;
			break;
			default:
				$by_type_tnum = $by_type_old[2]+1;
				$by_type = $by_type_old[0].','.$by_type_old[1].','.$by_type_tnum;
				
				$f = !empty($inquiry_info_old[3]) ? $inquiry_info_old[3] : 0;
				$s = !empty($inquiry_info_old[4]) ? $inquiry_info_old[4] : 0;
				$t = $inquiry_info_old[5]+1;
			break;
		}
		
		$inquiry_info = $name.','.$email.','.$phone.','.$f.','.$s.','.$t;
		$set_ip_arr = array(
			'inquiry'=>$inquiry_info,
			'inquiry_num'=>$inquiry_num,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son',$set_ip_arr,'update','customer_come_ip="'.$customer_come_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
}


/**
 *通过Google广告进入网站同时live chat-online询问了--保存信息到fs_google_analysis_son表
 *@params	string	$customer_ip	客户端ip	
 *@return	void
 *@author	fallwind				2016.10.24
 */
function setComeIpByLivechatOnline($customer_come_ip){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_country = getCountryByIp($customer_come_ip);
	//先查询是否有相同的ip
	$get_ip_sql = "SELECT customer_come_ip,live_chat_onlie,live_chat_onlie_num,by_type FROM `fs_google_analysis_son` WHERE `customer_come_ip` = '$customer_come_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	
	if($res->EOF==1){
		//没有重复的ip，执行添加
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type = '1,0,0';
			break;
			case 'by_google_shopping':
				$by_type = '0,1,0';
			break;
			default:
				$by_type = '0,0,1';
			break;
		}
		$lc_onlie_info = $by_type;
		$set_ip_arr = array(
			'customer_come_ip' =>$customer_come_ip,
			'live_chat_onlie'=>$lc_onlie_info,
			'live_chat_onlie_num'=>1,
			'country'=>$customers_country,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son', $set_ip_arr);	
	}else{
		//如果已经有相同ip，执行更新
		$lc_onlie_info_old = explode(',',$res->fields['live_chat_onlie']);
		$lc_onlie_num = $res->fields['live_chat_onlie_num']+1;
		$by_type_old = explode(',',$res->fields['by_type']);
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type_fnum = $by_type_old[0]+1;
				$by_type = $by_type_fnum.','.$by_type_old[1].','.$by_type_old[2];
				
				$f = $lc_onlie_info_old[0]+1;
				$s = !empty($lc_onlie_info_old[1]) ? $lc_onlie_info_old[1] : 0;
				$t = !empty($lc_onlie_info_old[2]) ? $lc_onlie_info_old[2] : 0;
			break;
			case 'by_google_shopping':
				$by_type_snum = $by_type_old[1]+1;
				$by_type = $by_type_old[0].','.$by_type_snum.','.$by_type_old[2];
				
				$f = !empty($lc_onlie_info_old[0]) ? $lc_onlie_info_old[0] : 0;
				$s = $lc_onlie_info_old[1]+1;
				$t = !empty($lc_onlie_info_old[2]) ? $lc_onlie_info_old[2] : 0;
			break;
			default:
				$by_type_tnum = $by_type_old[2]+1;
				$by_type = $by_type_old[0].','.$by_type_old[1].','.$by_type_tnum;
				
				$f = !empty($lc_onlie_info_old[0]) ? $lc_onlie_info_old[0] : 0;
				$s = !empty($lc_onlie_info_old[1]) ? $lc_onlie_info_old[1] : 0;
				$t = $lc_onlie_info_old[2]+1;
			break;
		}
		$lc_onlie_info = $f.','.$s.','.$t;
		$set_ip_arr = array(
			'live_chat_onlie'=>$lc_onlie_info,
			'live_chat_onlie_num'=>$lc_onlie_num,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son',$set_ip_arr,'update','customer_come_ip="'.$customer_come_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
	
	
}


/**
 *通过Google广告进入网站同时live chat-email询问了--保存信息到fs_google_analysis_son表
 *@params	string	$customer_ip	客户端ip	
 *@params	string	$name			姓名
 *@params	string	$email			邮箱
 *@params	string	$phone			手机号
 *@return	void
 *@author	fallwind				2016.10.24
 */
function setComeIpByLivechatEmail($customer_come_ip,$name,$email,$phone){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_country = getCountryByIp($customer_come_ip);
	//先查询是否有相同的ip
	$get_ip_sql = "SELECT customer_come_ip,live_chat_email,live_chat_email_num,by_type FROM `fs_google_analysis_son` WHERE `customer_come_ip` = '$customer_come_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	
	if($res->EOF==1){
		//没有重复的ip，执行添加
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type = '1,0,0';
			break;
			case 'by_google_shopping':
				$by_type = '0,1,0';
			break;
			default:
				$by_type = '0,0,1';
			break;
		}
		$lc_email_info = $name.','.$email.','.$phone.','.$by_type;
		$set_ip_arr = array(
			'customer_come_ip' =>$customer_come_ip,
			'live_chat_email'=>$lc_email_info,
			'live_chat_email_num'=>1,
			'country'=>$customers_country,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son', $set_ip_arr);	
	}else{
		//如果已经有相同ip，执行更新
		$lc_email_info_old = explode(',',$res->fields['live_chat_email']);
		$lc_email_num = $res->fields['live_chat_email_num']+1;
		$by_type_old = explode(',',$res->fields['by_type']);
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type_fnum = $by_type_old[0]+1;
				$by_type = $by_type_fnum.','.$by_type_old[1].','.$by_type_old[2];
				
				$f = $lc_email_info_old[3]+1;
				$s = !empty($lc_email_info_old[4]) ? $lc_email_info_old[4] : 0;
				$t = !empty($lc_email_info_old[5]) ? $lc_email_info_old[5] : 0;
			break;
			case 'by_google_shopping':
				$by_type_snum = $by_type_old[1]+1;
				$by_type = $by_type_old[0].','.$by_type_snum.','.$by_type_old[2];
				
				$f = !empty($lc_email_info_old[3]) ? $lc_email_info_old[3] : 0;
				$s = $lc_email_info_old[4]+1;
				$t = !empty($lc_email_info_old[5]) ? $lc_email_info_old[5] : 0;
			break;
			default:
				$by_type_tnum = $by_type_old[2]+1;
				$by_type = $by_type_old[0].','.$by_type_old[1].','.$by_type_tnum;
				
				$f = !empty($lc_email_info_old[3]) ? $lc_email_info_old[3] : 0;
				$s = !empty($lc_email_info_old[4]) ? $lc_email_info_old[4] : 0;
				$t = $lc_email_info_old[5]+1;
			break;
		}
		$lc_email_info = $name.','.$email.','.$phone.','.$f.','.$s.','.$t;
		$set_ip_arr = array(
			'live_chat_email'=>$lc_email_info,
			'live_chat_email_num'=>$lc_email_num,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son',$set_ip_arr,'update','customer_come_ip="'.$customer_come_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
	
	
}


/**
 *通过Google广告进入网站同时live chat-phone询问了--保存信息到fs_google_analysis_son表
 *@params	string	$customer_ip	客户端ip	
 *@params	string	$name			姓名
 *@params	string	$email			邮箱
 *@params	string	$phone			手机号
 *@return	void
 *@author	fallwind				2016.10.24
 */
function setComeIpByLivechatPhone($customer_come_ip,$name,$email,$phone){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_country = getCountryByIp($customer_come_ip);
	//先查询是否有相同的ip
	$get_ip_sql = "SELECT customer_come_ip,live_chat_phone,live_chat_phone_num,by_type FROM `fs_google_analysis_son` WHERE `customer_come_ip` = '$customer_come_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	
	if($res->EOF==1){
		//没有重复的ip，执行添加
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type = '1,0,0';
			break;
			case 'by_google_shopping':
				$by_type = '0,1,0';
			break;
			default:
				$by_type = '0,0,1';
			break;
		}
		$lc_phone_info = $name.','.$email.','.$phone.','.$by_type;
		$set_ip_arr = array(
			'customer_come_ip' =>$customer_come_ip,
			'live_chat_phone'=>$lc_phone_info,
			'live_chat_phone_num'=>1,
			'country'=>$customers_country,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son', $set_ip_arr);	
	}else{
		//如果已经有相同ip，执行更新
		$lc_phone_info_old = explode(',',$res->fields['live_chat_phone']);
		$lc_phone_num = $res->fields['live_chat_phone_num']+1;
		$by_type_old = explode(',',$res->fields['by_type']);
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type_fnum = $by_type_old[0]+1;
				$by_type = $by_type_fnum.','.$by_type_old[1].','.$by_type_old[2];
				
				$f = $lc_phone_info_old[3]+1;
				$s = !empty($lc_phone_info_old[4]) ? $lc_phone_info_old[4] : 0;
				$t = !empty($lc_phone_info_old[5]) ? $lc_phone_info_old[5] : 0;
			break;
			case 'by_google_shopping':
				$by_type_snum = $by_type_old[1]+1;
				$by_type = $by_type_old[0].','.$by_type_snum.','.$by_type_old[2];
				
				$f = !empty($lc_phone_info_old[3]) ? $lc_phone_info_old[3] : 0;
				$s = $lc_phone_info_old[4]+1;
				$t = !empty($lc_phone_info_old[5]) ? $lc_phone_info_old[5] : 0;
			break;
			default:
				$by_type_tnum = $by_type_old[2]+1;
				$by_type = $by_type_old[0].','.$by_type_old[1].','.$by_type_tnum;
				
				$f = !empty($lc_phone_info_old[3]) ? $lc_phone_info_old[3] : 0;
				$s = !empty($lc_phone_info_old[4]) ? $lc_phone_info_old[4] : 0;
				$t = $lc_phone_info_old[5]+1;
			break;
		}
		$lc_phone_info = $name.','.$email.','.$phone.','.$f.','.$s.','.$t;
		$set_ip_arr = array(
			'live_chat_phone'=>$lc_phone_info,
			'live_chat_phone_num'=>$lc_phone_num,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son',$set_ip_arr,'update','customer_come_ip="'.$customer_come_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
}


/**
 *通过Google广告进入网站同时下单了--保存信息到fs_google_analysis_son表
 *@params	string	$customer_ip	客户端ip	
 *@params	string	$name			姓名
 *@params	string	$email			邮箱
 *@params	string	$phone			手机号
 *@return	void
 *@author	fallwind				2016.10.24
 */
function setComeIpByOrders($customer_come_ip,$order_id){
	global $db;
	$language_id = $_SESSION['languages_id'];
	$customers_id = $_SESSION['customer_id'];
	$customers_country = getCountryByIp($customer_come_ip);
	//先查询是否有相同的ip
	$get_ip_sql = "SELECT customer_come_ip,order_info,order_num,by_type FROM `fs_google_analysis_son` WHERE `customer_come_ip` = '$customer_come_ip'  AND `language_id` = $language_id";
	$res = $db->Execute($get_ip_sql);
	
	if($res->EOF==1){
		//没有重复的ip，执行添加
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type = '1,0,0';
			break;
			case 'by_google_shopping':
				$by_type = '0,1,0';
			break;
			default:
				$by_type = '0,0,1';
			break;
		}
		$order_info = $order_id.','.$customers_id.','.$by_type;
		$set_ip_arr = array(
			'customer_come_ip' =>$customer_come_ip,
			'order_info'=>$order_info,
			'order_num'=>1,
			'country'=>$customers_country,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son', $set_ip_arr);	
	}else{
		//如果已经有相同ip，执行更新
		$order_info_old = explode(',',$res->fields['order_info']);
		$order_num = $res->fields['order_num']+1;
		$by_type_old = explode(',',$res->fields['by_type']);
		switch($_SESSION['google_ads']){
			case 'by_google_adwords':
				$by_type_fnum = $by_type_old[0]+1;
				$by_type = $by_type_fnum.','.$by_type_old[1].','.$by_type_old[2];
				
				$f = $order_info_old[2]+1;
				$s = !empty($order_info_old[3]) ? $order_info_old[3] : 0;
				$t = !empty($order_info_old[4]) ? $order_info_old[4] : 0;
			break;
			case 'by_google_shopping':
				$by_type_snum = $by_type_old[1]+1;
				$by_type = $by_type_old[0].','.$by_type_snum.','.$by_type_old[2];
				
				$f = !empty($order_info_old[2]) ? $order_info_old[2] : 0;
				$s = $order_info_old[3]+1;
				$t = !empty($order_info_old[4]) ? $order_info_old[4] : 0;
			break;
			default:
				$by_type_tnum = $by_type_old[2]+1;
				$by_type = $by_type_old[0].','.$by_type_old[1].','.$by_type_tnum;
				
				$f = !empty($order_info_old[2]) ? $order_info_old[2] : 0;
				$s = !empty($order_info_old[3]) ? $order_info_old[3] : 0;
				$t = $order_info_old[4]+1;
			break;
		}
		$order_info = $order_id.','.$customers_id.','.$f.','.$s.','.$t;
		$set_ip_arr = array(
			'order_info'=>$order_info,
			'order_num'=>$order_num,
			'by_type'=>$by_type,
			'create_time'=>time(),
			'language_id'=>$language_id
		);
		zen_db_perform('fs_google_analysis_son',$set_ip_arr,'update','customer_come_ip="'.$customer_come_ip.'" and language_id = '.$_SESSION['languages_id']);
	}
}

/**
 * 图形验证码  reCAPTCHA v2（google验证）
 * @param $graph_validate_code_response
 * @param $url 后端验证请求地址
 * @param string $new 隐式人机验证码
 * @return bool
 * @author  potato
 */
function graph_validate_code($graph_validate_code_response, $url, $new = '')
{
    $request['response'] = $graph_validate_code_response;
    $request['secret'] = '6Lek17MUAAAAANgl8OUauxsSst6EvbkIljLaU6dr';
    if ($new) {
        $request['secret'] = '6Lfn2LMUAAAAAORty6IkQGwsiMtPAjQr0qzXH4Rc';
    }
    $res = curl_post($request, $url);
    if ($res && $res['success']) return true;
    return false;
}

/**
 *  curl post请求
 * @param $data 配置参数
 * @param string $url 请求的url
 * @return mixed
 * @author potato
 */
function curl_post($data, $url = '')
{

    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $res = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    return json_decode($res, true);
}








