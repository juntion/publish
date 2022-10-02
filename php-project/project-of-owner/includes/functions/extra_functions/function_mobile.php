<?php

function order_status_name($status_id){
     global $db;
	  
	  $result= $db->Execute("select * from orders_status where orders_status_id = '$status_id'");

	  return $result->fields['orders_status_name'];
}


function isPhone() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        //找不到为flase,否则为true
        if(stristr($_SERVER['HTTP_VIA'], "wap"))
        {
            return true;
        }
    }
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array (
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile',
            'phone',
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}
function CheckSubstrs($substrs,$text){
	foreach($substrs as $substr)
		if(false!==strpos($text,$substr)){
			return true;
		}
	return false;
}
function isMobile(){  
	$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
	$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
	$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
	$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');
	$is_app = (isset($_GET['sorce']) && $_GET['sorce']=="MobilePhoneApp") ? true:false;
	$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||  
			  CheckSubstrs($mobile_token_list,$useragent)||$is_app;
		  
	if($found_mobile){  
		return true;  
	}else{  
		return false;  
	}  
}

/**
*获取手机站访问是ios还是Android
*/
function get_device_type(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$type = 'other';
	if(strpos($agent, 'iphone') || strpos($agent, 'ipad')){
		$type = 'ios';
	}

	if(strpos($agent, 'android')){
		$type = 'android';
	}
	return $type;
}

//fallwind	2017.3.1
function getDeviceType(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(strpos($agent, 'iphone')){
		$type = 'ios';
	}elseif(strpos($agent, 'ipad')){
		$type = 'ipad';
	}elseif(strpos($agent, 'android')){
		$type = 'android';
	}else{
		$type = 'other';
	}
	return $type;
}
//返回当前浏览器内核信息
function my_get_browser(){
	 if(empty($_SERVER['HTTP_USER_AGENT'])){
	  return 'robot！';
	 }
	 if( (false == strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident')!==FALSE) ){
	  return 'Internet Explorer 11.0';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 10.0')){
	  return 'Internet Explorer 10.0';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 9.0')){
	  return 'Internet Explorer 9.0';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.0')){
	  return 'Internet Explorer 8.0';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
	  return 'Internet Explorer 7.0';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
	  return 'Internet Explorer 6.0';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Edge')){
	  return 'Edge';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')){
	  return 'Firefox';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')){
	  return 'Chrome';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Safari')){
	  return 'Safari';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Opera')){
	  return 'Opera';
	 }
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'360SE')){
	  return '360SE';
	 }
	 //微信浏览器
	 if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessage')){
	  return 'MicroMessage';
	 }
}

?>