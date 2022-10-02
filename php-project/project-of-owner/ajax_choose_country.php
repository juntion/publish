<?php
require 'includes/application_top.php';


switch ($_GET['request_type']){

	case 'choose_country':
	$In_country =$_POST['country'];
	$currency =$_POST['currency'];
	$no_us =array('be','de la_de','at','ch la_de','be la_de','es','br','ar','cl','pa','pe','co','gt','hn','ve','uy','py','ec','cr','bo','do','mx','fr','lu','ca la_fr','ch la_fr','be la_fr','mc la_fr','tn','mc','cf','gn','mg','ma','ru','kz','ee','lv','lt','ua','by','ge','cn','hk','mo','tw');
	if(!in_array($In_country,$no_us)){
		$country =substr($In_country ,0,2);
		require_once DIR_WS_CLASSES .'set_cookie.php';
		$Encryption = new Encryption;
		$countryCode_encrypt = $Encryption->_encrypt($country);
		setcookie("countries_iso_code",$countryCode_encrypt,time()+86400 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
		$_SESSION['currency'] =$currency;
		$_SESSION['countries_iso_code'] = $country ;
	}
	echo json_encode($In_country);
	exit;
	break;
	
	case 'choose_newcurrency':
	$in_currency =zen_db_prepare_input($_POST['currency']);
	$_SESSION['currency'] =$in_currency;
	echo json_encode($in_currency);
	exit;
	break;
	
	case 'choose_newcountry':
	require_once DIR_WS_CLASSES .'set_cookie.php';
    $Encryption = new Encryption;
	$in_currency =zen_db_prepare_input($_POST['currency']);
	$in_country =zen_db_prepare_input($_POST['country']);
	$in_website =zen_db_prepare_input($_POST['website']);
	//验证获取到的货币是和选择的国家相匹配的
	if($in_country){
		//根据选择的国家匹配该国家支持的货币
        $currency_result = getWebsiteData(['currency'],"country_code ='".strtoupper($in_country)."'",'','group by currency');
        $allow_currency = [];
        foreach($currency_result as $val){
            $allow_currency[] = $val[0];
        }

		//根据选择的国家匹配该国家支持的站点
        $website_result = getWebsiteData(['website'],"country_code ='".strtoupper($in_country)."'",'','group by website');
        $allow_website = [];
        foreach($website_result as $val){
            $allow_website[] = $val[0];
        }

		//如果接收到的货币是在所选国家匹配到的货币数组中,则最终选择的货币为接收到的货币,否则取默认货币
		if(in_array($in_currency,$allow_currency)){
			$last_currency = $in_currency;
		}else{
			$last_currency = $allow_currency[0];
		}
		//切换的站点同理
		if(in_array($in_website,$allow_website)){
			$last_website = $in_website;
		}else{
			$last_website = $allow_website[0];
		}
		if($last_website == 'de-en'){
			$last_website = 'dn';	//德语英文站de-en的languages_code是dn
		}
		$sCountryCode = 'countries_iso_code_'.trim($last_website);
		$sCurrencyCode = 'currency_'.trim($last_website);
		$_SESSION[$sCountryCode] = $in_country;
		$_SESSION[$sCurrencyCode] = $last_currency;
		$_SESSION['currency'] = $_SESSION[$sCurrencyCode];
        $_SESSION['currency_type'] = true;
		$_SESSION['countries_iso_code'] = $_SESSION[$sCountryCode];
		$countryCode = $countries_code_2 =strtoupper($_SESSION['countries_iso_code']);
		$countryCode_encrypt = $Encryption->_encrypt(strtolower($countryCode));
		setcookie($sCountryCode,$countryCode_encrypt,time()+86400*30,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
		$_COOKIE[$sCountryCode] = $countryCode_encrypt; 
	}
	delCache(DIR_FS_CATALOG . 'cache/products' , 1);
	echo json_encode([$in_currency,$last_website]);
	exit;
	break;
	

	case 'remember_word':
	$keyword = strip_tags(trim($_POST['keyword']));
	$keyword = preg_replace('/select|insert|update|delete|\'|\(|\)|$|^|%|"|\*|union|into|load_file|outfile/i','',$keyword);
	$keyword = str_replace('#', '', $keyword);
	if($keyword){
		require_once DIR_WS_CLASSES .'set_cookie.php';
		$Encryption = new Encryption;
		$word = $Encryption->_encrypt($keyword);
		if(isset($_COOKIE['keyword_code'])){
			if(isset($_COOKIE['keyword_code']) && !in_array($word,unserialize($_COOKIE['keyword_code']))){
				$cookie_word= unserialize($_COOKIE['keyword_code']);
				$cookie_word[]= $word;
				$cookie_words = serialize($cookie_word);
				setcookie('keyword_code',$cookie_words,time()+86400,"/");	
			}else{
				  if(in_array($word,unserialize($_COOKIE['keyword_code']))){
					  $cookie_words = $_COOKIE['keyword_code'];
					  setcookie('keyword_code',$cookie_words,time()+86400,"/");   
				  }else{
					$cookie_word[]= $word;
					$cookie_words = serialize($cookie_word);
					setcookie('keyword_code',$cookie_words,time()+86400,"/");  
				  }
			} 
		}else{
			$cookie_word[]= $word;
			$cookie_words = serialize($cookie_word);
			setcookie('keyword_code',$cookie_words,time()+86400,"/");	
		}
		if(sizeof(unserialize($_COOKIE['keyword_code']))>9){
			 $arr = unserialize($_COOKIE['keyword_code']);
			 if(!in_array($word,unserialize($_COOKIE['keyword_code']))){
				array_shift($arr);
				$arr[] =$word; 
			 }
			 $new_search =serialize($arr);
			 setcookie('keyword_code',$new_search,time()+86400,"/");	 
		}
		echo json_encode($keyword);
    }
	exit;
	break;
	
	case 'del_word':
	$arr =serialize(array());
	setcookie("keyword_code",$arr,time()+86400,"/");
	echo json_encode($arr);
	exit;
	break;

	case 'match_languages':
	$country_code=zen_db_prepare_input(zen_db_prepare_input($_POST['country']));
    if($country_code){
        $mc_languages = getWebsiteData(array('currency','default_site','website'),'country_code="'.strtoupper($country_code).'"','ORDER BY sort ASC','');
    }
	if($mc_languages){
		$current_symbol_var = fs_get_data_from_db_fields('symbol_var','currencies','code="'.$mc_languages[0][0].'"','');
	    foreach($mc_languages as $lang){
			$symbol_var = fs_get_data_from_db_fields('symbol_var','currencies','code="'.$lang[0].'"','');
            if($lang[0] == 'RUB' && isMobile()){
                $symbol_var = '<i class="icon iconfont currency_rub">&#xf401;</i>';
            }
			$html_arr[] =array(
			   'website'=>$lang[2],
			   'currency'=>$lang[0],
			   'default_site'=>$lang[1],
			   'symbol_var'=>$symbol_var,
			);
		} 
			
	}
	echo json_encode($html_arr);
	exit;
	break;
	
	case 'choose_newcountry_wap':
	$wap_country =zen_db_prepare_input($_POST['country']);
	$_SESSION['countries_iso_code'] =$wap_country;
	echo json_encode($wap_country);
	exit;
	break;

    case "get_redirect_url":
        /**
         * type 1 产品详情 2 产品列表
         */
        require_once DIR_WS_CLASSES .'set_cookie.php';
        require_once DIR_WS_CLASSES .'shipping_info.php';
        $type = $_POST['type'] ? zen_db_prepare_input((int)$_POST['type']) : "";
        $country_code = zen_db_prepare_input($_POST['country']);
        $pid = zen_db_prepare_input((int)$_POST['pid']);
        $state = zen_db_prepare_input($_POST['state']);
        $origin_url = $_SERVER['HTTP_REFERER'];
        $in_country = $country_code;
        $default_country = strtoupper($_SESSION['countries_iso_code']);
        if(!$origin_url || !$country_code){
            echo json_encode(array("status"=>"error","data"=>FS_SYSTME_BUSY));
            exit;
        }
        $parse_url = parse_url($origin_url);
        $scheme = $parse_url['scheme'];
        $host = $parse_url['host'];
        $path = $parse_url['path'];
        $query = $parse_url['query'] ? "?".$parse_url['query']:"";
        $fragment = $parse_url['fragment'] ? "#".$fragment:""; //后面根的锚点
        $in_website = "en";
        $in_currency = "USD";
        $product_status = true;
        $redirect_url =  HTTPS_SERVER;
        $language_code = $_SESSION['languages_code'];
        $post_code = $_POST['post_code'] ? zen_db_prepare_input($_POST['post_code']):"";
        $is_current = false;
        $pure_price = zen_db_input($_POST['products_price']) ? $_POST['products_price'] : 0;
        $purchase_qty = (int)$_POST['purchase_qty'] ? (int)$_POST['purchase_qty']:1;
        $weight = $_POST['weight'] ? $_POST['weight']:0;
        $shipping_methods = $_POST['shipping_methods'] ? zen_db_input($_POST['shipping_methods']) : "";
        $address_id = zen_db_input((int)$_POST['address_book_id']);
        if($address_id && isset($_SESSION['customer_id'])){
            $get_customer_info=$db->Execute("select entry_street_address,entry_suburb,entry_country_id from ".TABLE_ADDRESS_BOOK." where customers_id = ".
                (int)$_SESSION['customer_id'] . " and  address_book_id=".$address_id." limit 1");
            //英文站港澳台国家地址栏不能包含中文字符判断
            if(!empty($get_customer_info->fields['entry_country_id'])){
                if(in_array($get_customer_info->fields['entry_country_id'],array(96,125,206)) && in_array($_SESSION['languages_id'],array(1,9,10,13))){
                    if(preg_match ("/[\x{4e00}-\x{9fa5}]/u", $get_customer_info->fields['entry_street_address'].$get_customer_info->fields['entry_suburb'])){
                        //包含汉字
                        echo json_encode(array("status" => error, "data" => FS_ADDRESSES_REGULAR_2));
                        exit;
                    }
                }
            }
        }


        $ip_info = "";
        $shipping_info = "";
        if(!in_array($host,array("www.fs.com","test.whgxwl.com","tx.fs.com","aron.test.com","local.fs.quest","local.fs.com","dylan.whgxwl.com","rebirth.whgxwl.com","quest.whgxwl.com","jeremy.fs.com","liang.whgxwl.com"))){
            echo json_encode(array("status"=>"error","data"=>FS_SYSTME_BUSY));
            exit;
        }
        if($type == 1){
            if(!$_POST['pid']){
                echo json_encode(array("status"=>"error","data"=>FS_SYSTME_BUSY));
                exit;
            }
            $shipping_info = new ShippingInfo(array("pid" => $pid, 'post_code' => $post_code, 'purchase_qty' => $purchase_qty));
            $pure_price = $pure_price * $purchase_qty;
            $shipping_info->weight = $weight ? $weight : $shipping_info->get_weight_for_prdoucts_id();
            $product_status = $shipping_info->products_status(strtoupper($country_code));
            $attr_str = $_POST['attr_str'] ? $_POST['attr_str'] : "";
            $length = $_POST['length'] ? $_POST['length'] : "";
            $attr_arr = array();
            if($attr_str){
                $attr_arr = explode(',',$attr_str);
            }
            if($length){
                $attr_arr['length'] = $length;
            }
            if(sizeof($attr_arr)){
                $shipping_info->attr_option_arr = $attr_arr;
            }
        }
        if(!empty($post_code)){
            switch (strtoupper($country_code)) {
                case "US":
                    if (empty($post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT zip FROM `countries_to_zip`  WHERE zip = '$post_code' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['zip'])) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
                case "AU":
                    if (empty($post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT postcode FROM `countries_au_zip`  WHERE postcode = '$post_code' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['postcode'])) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
                case "DE":
                    if (empty($post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT postcode FROM `countries_de_zip`  WHERE postcode = '$post_code' AND country='Germany' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['postcode'])) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
                case "GB":
                    if (empty($post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT postcode FROM `countries_de_zip`  WHERE replace(`postcode`,' ','') = '".str_replace(" ","",$post_code)."' 
                    or replace(`postcode`,' ','') LIKE '".substr(str_replace(" ","",$post_code),0,3)."%' AND country='United Kingdom' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['postcode'])  || strlen($post_code)<3 || strlen($post_code)>8) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
            }
        }

        $mc_languages = getWebsiteData(array('currency','default_site','website'),'country_code="'.strtoupper($country_code).'"','order by sort','');

        if($mc_languages){
            $current_symbol_var = fs_get_data_from_db_fields('symbol_var','currencies','code="'.$mc_languages[0][0].'"','');
            foreach($mc_languages as $lang){
                $symbol_var = fs_get_data_from_db_fields('symbol_var','currencies','code="'.$lang[0].'"','');
                $html_arr[] =array(
                    'website'=>str_replace("/","-",$lang[2]),
                    'currency'=>$lang[0],
                    'default_site'=>$lang[1],
                    'symbol_var'=>$symbol_var,
                );
            }
            $in_website = $html_arr[0]['website'] ? $html_arr[0]['website'] : "en";
            $in_currency = $html_arr[0]['currency'] ? $html_arr[0]['currency'] : "USD";
            $chocie_lang = $_SESSION['languages_code'] == "dn" ? "de-en" :  $_SESSION['languages_code'];
            foreach ($html_arr as $v){
                if($v['website'] == $chocie_lang && $v['currency']==$_SESSION['currency']){
                    $in_website = $v['website'];
                    $in_currency = $v['currency'];
                    break;
                }
            }
        }
        if($in_country){
            //根据选择的国家匹配该国家支持的货币
            $currency_result = getWebsiteData(['currency'],"country_code ='".strtoupper($in_country)."'",'','group by currency');
            $allow_currency = [];
            foreach($currency_result as $val){
                $allow_currency[] = $val[0];
            }

            //根据选择的国家匹配该国家支持的站点
            $website_result = getWebsiteData(['website'],"country_code ='".strtoupper($in_country)."'",'','group by website');
            $allow_website = [];
            foreach($website_result as $val){
                $allow_website[] = $val[0];
            }

            //如果接收到的货币是在所选国家匹配到的货币数组中,则最终选择的货币为接收到的货币,否则取默认货币
            if(in_array($in_currency,$allow_currency)){
                $last_currency = $in_currency;
            }else{
                $last_currency = $allow_currency[0];
            }
            //切换的站点同理
            if(in_array($in_website,$allow_website)){
                $last_website = $in_website;
            }else{
                $last_website = $allow_website[0];
            }
			if($last_website=="de-en"){
				$last_website = "dn";
			}
            $sCountryCode = 'countries_iso_code_'.trim($last_website);
            $sCurrencyCode = 'currency_'.trim($last_website);
            $_SESSION[$sCountryCode] = $in_country;
            $_SESSION[$sCurrencyCode] = $last_currency;
            $_SESSION['currency'] = $_SESSION[$sCurrencyCode];
            $_SESSION['countries_iso_code'] = $_SESSION[$sCountryCode];
            $countryCode = $countries_code_2 =strtoupper($_SESSION['countries_iso_code']);
            $countryCode_encrypt = $Encryption->_encrypt(strtolower($countryCode));
            setcookie($sCountryCode,$countryCode_encrypt,time()+86400*30,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
            $_COOKIE[$sCountryCode] = $countryCode_encrypt;
        }
        delCache(DIR_FS_CATALOG . 'cache/products' , 1);
        if($post_code){
            $_SESSION['shipping_postCode_'.$in_website] = $post_code;
        }else{
            if($_SESSION['shipping_postCode_'.$in_website]){
                unset($_SESSION['shipping_postCode_'.$in_website]);
            }
        }

        $path = $path ? str_replace("/".$language_code,"",$path) :"";
		if($language_code=="dn"){
			$path = $path ? str_replace("/de-en","",$path) :"";
		}
        $param = $path.$query.$fragment;
        if (!$product_status) {
            if ($in_website == "en") {
                $url = $redirect_url;
            } else {
                $url = $redirect_url . "/" . $in_website;
                if($country_code == 'cn'){
                    $url = "https://www." . $in_website;
                }
            }
        } else {
            if($in_website == "en"){
                $url = $redirect_url . $param;
            }else{
                $url = $redirect_url . "/" . $in_website . $param;
                if($country_code == 'cn'){
                    $url = "https://www." . $in_website . $param;
                }
            }
        }
        if($url == $origin_url.$query && strtoupper($country_code) == $default_country){
            $is_current = true;
        }
        $settingDay=0;

        if($type==1){
            $shipping_info->shipping_postCode = $_SESSION['shipping_postCode_'.$in_website];
            $ip_info = $shipping_info->showShippingAddress($pure_price);
            $add_to_cart_shipping = $shipping_info->getDefaultAddressInfo();

            if(in_array($shipping_info->country_id,array(38,138))){
                $shipping_info->state = $state;
            }
            $customized_price = $_POST['product_price'];
            if($customized_price){
                $pure_price = $customized_price;
            }else{
                $product_price = zen_get_products_final_price((int)$pid);
                $pure_price = $product_price;
            }
            $settingDay = $shipping_info->getSettingDay($shipping_methods);
            if($settingDay == 0){
                $settingDay = $shipping_info->getProductShippingDays($settingDay);
            }
            $shipping_info = $shipping_info->getShippingDayInfo($pure_price,$shipping_methods);
        }
      
        if($_SESSION['customer_id'] && is_numeric($address_id)){
            $address_book_id = validationAddressBookId($address_id);
            if($address_book_id){
                $_SESSION['checkout_default_ads'] = $address_id;
            }
        }
        echo json_encode(array("status"=>"success","data"=>$url,"is_current"=>$is_current,"ip_info"=>$ip_info,"shipping_info"=>$shipping_info,'add_to_cart_shipping'=>$add_to_cart_shipping,'settingDay'=>$settingDay));
        break;

    case "get_instock_html":
        $pid = zen_db_prepare_input($_POST['pid']);
        if(empty($pid)){
            exit(json_encode(array('code'=>1,'error_msg'=>'no pid')));
        }
        $pid = rtrim($pid,',');
        $pids = explode(",",$pid);
        require_once DIR_WS_CLASSES .'shipping_info.php';
        $retu = [];
        foreach ($pids as $pid){
            $pid = abs((int)$pid);
            if(empty($pid)){
                exit(json_encode(array('code'=>1,'error_msg'=>'no pid')));
            }
            $shipping_info = new ShippingInfo(array('pid'=>$pid));
            $instockHtml = $shipping_info->showIntockTagDate();
            $retu[] = [
                'html'=>$instockHtml,
                'pid'=>$pid
            ];
        }
        exit(json_encode(array('code'=>2,'retu'=>$retu)));
        break;
}

?>