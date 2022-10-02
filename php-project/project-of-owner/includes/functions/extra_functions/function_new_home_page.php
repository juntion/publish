<?php
//新首页的相关函数	fallwind	2017.4.26

//首页顶部，根据所选国家展示不同仓库位置
function zen_get_news_Room(){
   require_once DIR_WS_CLASSES .'set_cookie.php';
   $Encryption = new Encryption;
   $countryCode =strtoupper($_SESSION['countries_iso_code']);
	$href = "shipping_policy.html";
   if(seattle_warehouse('country_code',$countryCode)){
       $html ='<p class ="top_main_left_news"><em class="icon iconfont">&#xf148;</em><a href="'.$href.'" >'.FS_WAREHOSE_CA_TIP.'</a></p>';
   }elseif($countryCode=="GB"){
	   $html ='<p class ="top_main_left_news"><em class="icon iconfont">&#xf148;</em><a href="'.$href.'" >'.FS_WAREHOSE_GB_TIP.'</a></p>';
   }elseif(all_german_warehouse('country_code',$countryCode)){
       $html ='<p class ="top_main_left_news"><em class="icon iconfont">&#xf148;</em><a href="'.$href.'" >'.FS_WAREHOSE_EU_TIP.'</a></p>';
   }elseif($countryCode=="AU"){
	   $html ='<p class ="top_main_left_news"><em class="icon iconfont">&#xf148;</em><a href="/shipping_delivery.html" >'.FS_WAREHOSE_AU_TIP.'</a></p>';
   }else{
         $html ='<p class ="top_main_left_news"><em class="icon iconfont">&#xf148;</em><a href="'.$href.'" >'.FS_WAREHOSE_OTHER_TIP.$countryCode.'</a></p>';
   }

	return $html;
}
function zen_get_contact_phone_number_ajax($countryCode){
	$first_time= strtotime("05:00:00");
	$morning_time =strtotime("08:00:00");
	$time=date('Y-m-d H:i:s',time());
	$nowtime=time();
	$last_time= strtotime("17:00:00");
	$date=date('w',$nowtime);
	$current_time=date('Y-m-d H:i:s',mktime());
	/* $first_kindom_time=strtotime("00:00:00");
	$last_kindom_time=strtotime("05:00:00"); */
	$first_es_time=strtotime("06:30:00")-24*3600;
	$last_es_time=strtotime("03:00:00");
	$countryCode =strtoupper($countryCode);

	if($countryCode=="CN"){
		$phone_number = FS_PHONE_CHECKOUT_US;
	}
	if($countryCode=="HK"){
		$phone_number = FS_PHONE_HK;
	}
	if($countryCode=="US"){
		if($nowtime>$first_time && $nowtime<$last_time  ){
			$phone_number = FS_PHONE_CHECKOUT_US;
		}else{
			$phone_number = FS_PHONE_CHECKOUT_US;
		}
		if(US_WAREHOUSE_UP){
                  $phone_number = FS_PHONE_US_EAST;
              }
	}

	if($countryCode=="MX"){
		$phone_number = FS_PHONE_MX;
	}
	if($countryCode=="CA"){
		$phone_number = FS_PHONE_CA;
	}
	if($countryCode=="BR"){
		$phone_number = FS_PHONE_BR;
	}

	if($countryCode=="GB"){
		$phone_number = FS_PHONE_GB;
	}

	if($countryCode=="FR"){
		$phone_number = FS_PHONE_FR;
	}
	if($countryCode=="NL"){
		$phone_number = FS_PHONE_NL;
	}
	if($countryCode=="DE"){
		$phone_number = FS_PHONE_DE;
	}
	if($countryCode=="AU"){
		if($nowtime>$first_es_time && $nowtime<$last_es_time){
			$phone_number = FS_PHONE_AU;
		}else{
			$phone_number = FS_PHONE_AU;
		}
	}
	if($countryCode=="ES"){
		$phone_number = FS_PHONE_ES;
	}
	if($countryCode=="RU"){
		$phone_number = FS_PHONE_RU;
	}
	if(in_array($countryCode,array("SG","KH","LA","MY","TL","ID","BN","MM","PH","TH","VN"))){
		$phone_number = FS_PHONE_SG;
	}
	if($countryCode==="AR"){
		$phone_number = FS_PHONE_AR;
	}
	/* if($countryCode==IT){
         $phone_number = FS_PHONE_IT;
	} */
	if($countryCode=="CH"){
		$phone_number = FS_PHONE_CH;
	}
	if($countryCode=="TW"){
		$phone_number = FS_PHONE_TW;
	}
	if($countryCode=="DK"){
		$phone_number = FS_PHONE_DK;
	}
	if($countryCode=="NZ"){
		$phone_number = FS_PHONE_NZ;
	}
	if($countryCode=="JP"){
        $phone_number = FS_PHONE_JP;
    }
    if($countryCode=="BE"){
        $phone_number = FS_PHONE_SITE_FR;
    }
	if(!in_array($countryCode,array("SG","KH","LA","MY","TL","ID","BN","MM","PH","TH","VN")) && $countryCode!="RU" && $countryCode!="ES" && $countryCode!=AU && $countryCode!="DE" && $countryCode!="NL" && $countryCode!="FR" && $countryCode!="GB" && $countryCode!="BR" && $countryCode!="BR" && $countryCode!="CA" && $countryCode!="MX" && $countryCode!="US" && $countryCode!="HK" && $countryCode!="CN" && $countryCode!="CH" && $countryCode!="AR" && $countryCode!="TW" && $countryCode!="DK" && $countryCode!="NZ" && $countryCode!="JP" && $countryCode!="BE"){
		$phone_number = FS_PHONE_US;
	}
	return $phone_number;
}
//首页顶部，获取fs的联系电话
function zen_get_contact_phone_number(){
	$first_time= strtotime("05:00:00");
	$morning_time =strtotime("08:00:00");
	$time=date('Y-m-d H:i:s',time());
	$nowtime=time();
	$last_time= strtotime("17:00:00");
	$date=date('w',$nowtime);
	$current_time=date('Y-m-d H:i:s',mktime());
	/* $first_kindom_time=strtotime("00:00:00");
	$last_kindom_time=strtotime("05:00:00"); */
	$first_es_time=strtotime("06:30:00")-24*3600;
	$last_es_time=strtotime("03:00:00");
	$countryCode =strtoupper($_SESSION['countries_iso_code']);

	if($countryCode=="CN"){
		$phone_number = FS_PHONE_US;
	}
	if($countryCode=="HK"){
       $phone_number = FS_PHONE_HK;
	}
    if($countryCode=="US"){
		if($nowtime>$first_time && $nowtime<$last_time  ){
			$phone_number = FS_PHONE_US;
		}else{
			$phone_number = FS_PHONE_US;
		}
    }

	if($countryCode=="MX"){
		$phone_number = FS_PHONE_MX;
	}
	if($countryCode=="CA"){
		$phone_number = FS_PHONE_CA;
	}
	if($countryCode=="BR"){
		$phone_number = FS_PHONE_BR;
	}

	if($countryCode=="GB"){
		$phone_number = FS_PHONE_GB;
	}

	if($countryCode=="FR"){
		$phone_number = FS_PHONE_FR;
	}
    if($countryCode=="NL"){
		$phone_number = FS_PHONE_NL;
	}
	if($countryCode=="DE"){
         $phone_number = FS_PHONE_DE;
 	}
    if($countryCode=="AU"){
		if($nowtime>$first_es_time && $nowtime<$last_es_time){
			$phone_number = FS_PHONE_AU;
		}else{
			$phone_number = FS_PHONE_AU;
		}
	}
	if($countryCode=="ES"){
         $phone_number = FS_PHONE_ES;
	}
    if($countryCode=="RU"){
         $phone_number = FS_PHONE_RU;
	}
    if($countryCode=="SG"){
         $phone_number = FS_PHONE_SG;
	}
	if($countryCode=="AR"){
         $phone_number = FS_PHONE_AR;
	}
	/* if($countryCode==IT){
         $phone_number = FS_PHONE_IT;
	} */
	if($countryCode=="CH"){
         $phone_number = FS_PHONE_CH;
	}
	if($countryCode=="TW"){
         $phone_number = FS_PHONE_TW;
	}
	if($countryCode=="DK"){
         $phone_number = FS_PHONE_DK;
	}
    if($countryCode=="NZ"){
		$phone_number = FS_PHONE_NZ;
	}
    if($countryCode=="JP"){
		$phone_number = FS_PHONE_JP;
	}
	if($countryCode!="SG" && $countryCode!="RU" && $countryCode!="ES" && $countryCode!="AU" && $countryCode!="DE" && $countryCode!="NL" && $countryCode!="FR" && $countryCode!="GB" && $countryCode!="BR" && $countryCode!="BR" && $countryCode!="CA" && $countryCode!="MX" && $countryCode!="US" && $countryCode!="HK" && $countryCode!="CN" && $countryCode!="CH" && $countryCode!="AR" && $countryCode!="TW" && $countryCode!="DK" && $countryCode!="NZ" && $countryCode!="JP" ){
	   $phone_number = FS_PHONE_US;
	}
	return $phone_number;
}

//首页顶部，切换小语种网站，获取当前的链接，保证切换到对应小语种后，访问的链接还是和英文站一致
function zen_get_others_language_link(){
	if(in_array($_GET['main_page'],array(FILENAME_IN_THE_NEWS,'news','news_article','news_archive','Popular','Product_List','Popular_detail','tutorial_tag_search','fiber_transceivers',FILENAME_TUTORIAL,FILENAME_TUTORIAL_LIST,FILENAME_TUTORIAL_DETAIL,'all_review','comments_review','products_detail'))){
		$language_url='/';
	}else{
		$language_url = $this_is_home_page ? '/': $_SERVER['REQUEST_URI'];
		$language_url = str_replace("fr/", "", $language_url);
		$language_url = str_replace("ru/", "", $language_url);
		$language_url = str_replace("es/", "", $language_url);
		$language_url = str_replace("de/", "", $language_url);

	}
	return $language_url;
}

//首页顶部，切换国家，获取当前的链接，保证切换到对应小语种后，访问的链接还是和英文站一致
function zen_get_appoint_language_link($code){
	if(in_array($_GET['main_page'],array(FILENAME_IN_THE_NEWS,'news','news_article','news_archive','Popular','Product_List','Popular_detail','tutorial_tag_search','fiber_transceivers',FILENAME_TUTORIAL,FILENAME_TUTORIAL_LIST,FILENAME_TUTORIAL_DETAIL,'all_review','comments_review'))){
		$language_url='/';
	}else{
		$language_url = $this_is_home_page ? '/': $_SERVER['REQUEST_URI'];
		$language_url = str_replace($code, "", $language_url);

	}
	return $language_url;
}

//首页顶部，选择网站商品的货币切换--旧
function zen_get_ship_currency_type(){
	switch(1){
		case in_array($_SESSION['currency'], array('USD','CAD','AUD','HKD','NZD')):
			$currency_symbol = '$';
		break;

		case ('GBP' == $_SESSION['currency']):
			$currency_symbol = '&pound;';
		break;

		case ('SGD' == $_SESSION['currency']):
			$currency_symbol = 'S$';
		break;

		case ('EUR' == $_SESSION['currency']):
			$currency_symbol = '&#8364;';
		break;

		case ('CHF' == $_SESSION['currency']):
			$currency_symbol = '₣';
		break;

		case ('JPY' == $_SESSION['currency']):
			$currency_symbol = '¥';
		break;

		case ('BRL' == $_SESSION['currency']):
			$currency_symbol = 'R$&nbsp;';
		break;

		case ('NOK' == $_SESSION['currency']):
			$currency_symbol = 'kr.';
		break;

		case ('DKK' == $_SESSION['currency']):
			$currency_symbol = 'kr.';
		break;

		case ('SEK' == $_SESSION['currency']):
			$currency_symbol = 'Kr.';
		break;

		case ('MXN' == $_SESSION['currency']):
			$currency_symbol = '$';
		break;
	}
	return $currency_symbol;
}

//首页顶部，登录，注册html代码--旧
function zen_sigin_register_html(){
	$html = '';
	if( !isset($_SESSION['customer_id']) ){
		$html .='<li class="top_02"><a rel="nofollow" href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">'.FS_SIGN_IN.'</a> </li>';
	}else{
		$html .='<li class="top_11"><span class="top_06">'.FS_HELLO.', '.zen_get_customer_fname_of_id($_SESSION['customer_id']).' '.zen_get_customer_lname_of_id($_SESSION['customer_id']).' </span></li>';
	}
	return $html;
}

//首页顶部，我的账户中心html代码--旧
function zen_myAccount_center_html(){
	$html = '';
	$html .='<li class="top_04 top_my_acc"><a rel="nofollow" href="'.zen_href_link(FILENAME_MY_DASHBOARD,'','SSL').'">'.FS_MY_ACCOUNT.'<i></i></a> <b></b>';
	$html .='<ul>';
	$html .='<li><a href="'.zen_href_link(FILENAME_MY_DASHBOARD,'','SSL').'">'.FS_MY_DASHBOARD.'</a></li>';
	$html .='<li><a href="'.zen_href_link(FILENAME_MANAGE_ORDERS,'','SSL').'">'.FS_MY_ORDERS.'</a></li>';
	$html .='<li><a href="'.zen_href_link(FILENAME_MANAGE_ADDRESSES,'','SSL').'">'.FS_MY_ADDRESS.'</a></li>';
	if(isset($_SESSION['customer_id'])){
		$html .='<li><a rel="nofollow" class="top_12" href="'.zen_href_link(FILENAME_LOGOFF,'','NONSSL').'">'.FS_SIGN_OUT.'</a></li>';
	}
	$html .='</ul>';
	$html .='</li>';
	return $html;
}

//首页顶部，在线聊天html代码--旧
function zen_chat_now(){
	$html = '';
	$html .='<li class="top_05">';

	$hour = date('H',time()+13*3600);
	$hours = date('H',time()+28.5*3600);

	if( ($hour > 7 && $hour < 18 && date("w",time()+13*3600) != '6' && date("w",time()+13*3600) != '0') || ($hours > 9 && $hours < 19 && date("w",time()+28.5*3600) != '0') || (date("w",time()+28.5*3600) == '6' && $hours>9 && $hours < 13) ){
		$html .='<div id="ciKH1a" style="z-index:100;position:absolute"></div>';
		$html .='<div id="scKH1a" style="display:inline"></div>';
		$html .='<div id="sdKH1a" style="display:none"></div>';

		$html .='<script src="/includes/templates/fiberstore/jscript/home_page_chat_now.js"></script>';

		$html .='<noscript>';
			$html .='<a href="https://www.providesupport.com?messenger=1vc93rc9z32rz0pyuigv77l5tr">'.FS_ONLINE_CAHT.'</a>';
		$html .='</noscript>';

		//END ProvideSupport.com Text Chat Link Code
	}else{
		$html .='<a href="'.reset_url('service/fs_support.html').'" target="_blank" rel="nofollow" class="top_05">'.FS_LIVE_CAHT.'<i></i></a>';
	}

	$html .='<ul>';
	$html .='<div class="cart_em"></div>';
	$html .='<li>';
	$html .='<dt><s></s>'.FS_PRE_SALE.'</dt>';
	$html .='<dd>'.FS_CHAT_WITH.'</dd>';
	$html .='<dd class="livechat_xian"><a href="'.reset_url('service/fs_support.html').'" target="_blank" rel="nofollow">'.FS_STAR.'</a></dd>';
	$html .='</li>';
	$html .='<li>';
	$html .='<dt><i></i>'.FS_AFTER_SALE.'</dt>';
	$html .='<dd>'.FS_PL_GO.' <a href="'.zen_href_link(FILENAME_UNPAID_ORDERS,'','SSL').'">'.FS_MY_ORDER.'</a> '.FS_PAGE_TO.'</dd>';
	$html .='</li>';
	$html .='</ul>';
	$html .='</li>';
	return $html;
}

//新增电话号码
function zen_contact_phone_html(){
	$html = '';
	$html .='<div class="top_contact_phone">';
	$html .=  "<em>".FS_CALL_US."</em>  <a href='tel:".zen_get_contact_phone_number()."'>".zen_get_contact_phone_number();
	$html .='</a></div>';
	return $html;
}


//首页顶部，联系我们html代码块---新版首页
function zen_need_help_html(){
	$html = '';
	$html .='<div class="top_main_right_help">';
	$html .='<a class="top_main_right_help_a" href="javascript:;">'.FS_NEED_HELP.'</a><i></i>';
	$html .='<div class="top_main_right_help_more">';
	$html .='<div class="top_main_right_help_more_arrow"></div>';
	$html .='<dl class="top_main_right_help_more_chat">';
	$html .='<dt></dt>';
	if(get_curr_time_section()==1){
		$html .='<dd><p>'.FS_CHAT_LIVE_WITH_US.'</p><a class="contact_01" href="live_chat_service_mail.html" target="_blank">'.FS_LIVE_CAHT.'</a></dd>';
	}else{
		$html .='<dd><p>'.FS_CHAT_LIVE_WITH_US.'</p><a class="contact_01" href="javascript:;" onClick="LC_API.open_chat_window();return false;">'.FS_LIVE_CAHT.'</a></dd>';
	}
	$html .='</dl>';
	$html .='<dl class="top_main_right_help_more_chat"> ';
	$html .='<dt style="background: url('.HTTPS_IMAGE_SERVER.'images/index_icon.png) -90px -29px no-repeat;"></dt>';
	$html .='<dd><p>'.FS_SEND_US_A_MESSAGE.'</p><a href="live_chat_service_mail.html">'.FS_EMAIL_NOW.'</a></dd>';
	$html .='</dl>';
	$html .='<dl class="top_main_right_help_more_chat" style="border: none;" >';
	$html .='<dt style="background: url('.HTTPS_IMAGE_SERVER.'images/index_icon.png) -128px -29px no-repeat;"></dt>';
	$html .='<dd>';
	$html .='<p>'.FS_WANT_A_CALL.'</p>';
	$html .='<em>'.zen_get_contact_phone_number().'</em>';
	$html .='</dd>';
	$html .='</dl>';
	$html .='</div>';
	$html .='</div>';
	return $html;
}

//首页顶部，小语种链接切换html代码块---新版首页
function zen_Language_link_switch_html(){
	$link = zen_get_others_language_link();
	if($link=="/support/stock-list/fs-com-seattle-stock-list-1"){
		$link = '';
	}

	$html = '';
	$html .='<div class="top_main_right_language">';
	$html .='<a class="top_main_right_language_a" href="javascript:;">'.FS_LANGUAGE.'</a><i></i>';
	$html .='<div class="top_main_right_language_more">';
	$html .='<div class="top_main_right_language_more_arrow"></div>';
	$html .='<ul>';
	$html .='<li><a ctr="{\'to_lan\':\'es\'}" href="/es'.$link.'">'.FS_ES.'</a></li>';
	$html .='<li><a ctr="{\'to_lan\':\'de\'}" href="/de'.$link.'">'.FS_DE.'</a></li>';
	$html .='<li><a ctr="{\'to_lan\':\'fr\'}" href="/fr'.$link.'">'.FS_FR.'</a></li>';
	$html .='<li><a ctr="{\'to_lan\':\'ru\'}" href="/ru'.$link.'">'.FS_RU.'</a></li>';
	$html .='<li><a href="'.$link.'">'.FS_US.'</a></li>';
	$html .='</ul>';
	$html .='</div>';
	$html .='</div>';
	return $html;
}

//获取默认选取的国家
function zen_get_default_country_name($countries_iso_code='us'){
	$countries_iso_code = !empty($countries_iso_code) ? strtolower($countries_iso_code) : 'us';
	$countries_name = get_countries_iso_code_name(strtoupper($countries_iso_code));
	return $countries_name;
}

//首页顶部，国家及货币选择html代码块---新版首页
function zen_choice_country_currency_html(){
	require_once DIR_WS_CLASSES .'set_cookie.php';
	$Encryption = new Encryption;
	$html = '';

	$country_arr = array(
	   'us'=>'United States',
	   'gb'=>'United Kingdom',
	   'ca'=>'Canada',
	   'au'=>'Australia',
	   'fr'=>'France',
	   'de'=>'Germany',
	   'es'=>'Spain',
	   'nl'=>'Netherlands',
	   'in'=>'India',
	   'br'=>'Brazil',
	   'ch'=>'Switzerland',
	   'it'=>'Italy',
	   'sg'=>'Singapore',
	   'ax'=>'Aland Island',
	   'af'=>'Afghanistan',
	   'al'=>'Albania',
	   'dz'=>'Algeria',
	   'as'=>'American Samoa',
	   'ad'=>'Andorra',
	   'ao'=>'Angola',
	   'ai'=>'Anguilla',
	   'aq'=>'Antarctica',
	   'ag'=>'Antigua and Barbuda',
	   'ar'=>'Argentina',
	   'am'=>'Armenia',
	   'aw'=>'Aruba',
	   'at'=>'Austria',
	   'az'=>'Azerbaijan',
	   'bs'=>'Bahamas',
	   'bh'=>'Bahrain',
	   'bd'=>'Bangladesh',
	   'bb'=>'Barbados',
	   'by'=>'Belarus',
	   'be'=>'Belgium',
	   'bz'=>'Belize',
	   'bj'=>'Benin',
	   'bm'=>'Bermuda',
	   'bt'=>'Bhutan',
	   'bo'=>'Bolivia',
	   'ba'=>'Bosnia and Herzegovina',
	   'bw'=>'Botswana',
	   'bv'=>'Bouvet Island',
	   'io'=>'British Indian Ocean Territory',
	   'bn'=>'Brunei Darussalam',
	   'bg'=>'Bulgaria',
	   'bf'=>'Burkina Faso',
	   'bi'=>'Burundi',
	   'kh'=>'Cambodia',
	   'cm'=>'Cameroon',
	   'cv'=>'Cape Verde',
	   'ky'=>'Cayman Islands',
	   'cf'=>'Central African Republic',
	   'td'=>'Chad',
	   'cl'=>'Chile',
	   'cn'=>'China',
	   'cx'=>'Christmas Island',
	   'cc'=>'Cocos (Keeling) Islands',
	   'co'=>'Colombia',
	   'km'=>'Comoros',
	   'cg'=>'Congo',
	   'ck'=>'Cook Islands',
	   'cr'=>'Costa Rica',
	   'ci'=>"Cote D'Ivoire",
	   'hr'=>'Croatia',
	   'cu'=>'Cuba',
	   'cy'=>'Cyprus',
	   'cz'=>'Czech Republic',
	   'dk'=>'Denmark',
	   'dj'=>'Djibouti',
	   'dm'=>'Dominica',
	   'do'=>'Dominican Republic',
	   'ec'=>'Ecuador',
	   'eg'=>'Egypt',
	   'sv'=>'El Salvador',
	   'gq'=>'Equatorial Guinea',
	   'er'=>'Eritrea',
	   'ee'=>'Estonia',
	   'et'=>'Ethiopia',
	   'fk'=>'Falkland Islands (Malvinas)',
	   'fo'=>'Faroe Islands',
	   'fj'=>'Fiji',
	   'fi'=>'Finland',
	   'gf'=>'French Guiana',
	   'pf'=>'French Polynesia',
	   'tf'=>'French Southern Territories',
	   'ga'=>'Gabon',
	   'gm'=>'Gambia',
	   'ge'=>'Georgia',
	   'gh'=>'Ghana',
	   'gi'=>'Gibraltar',
	   'gr'=>'Greece',
	   'gl'=>'Greenland',
	   'gd'=>'Grenada',
	   'gp'=>'Guadeloupe',
	   'gu'=>'Guam',
	   'gt'=>'Guatemala',
	   'gg'=>'Guernsey',
	   'gn'=>'Guinea',
	   'gw'=>'Guinea-bissau',
	   'gy'=>'Guyana',
	   'ht'=>'Haiti',
	   'hm'=>'Heard and Mc Donald Islands',
	   'hn'=>'Honduras',
	   'hk'=>'Hong Kong',
	   'hu'=>'Hungary',
	   'is'=>'Iceland',
	   'id'=>'Indonesia',
	   'ir'=>'Iran (Islamic Republic of)',
	   'iq'=>'Iraq',
	   'ie'=>'Ireland',
	   'im'=>'Isle of Man',
	   'il'=>'Israel',
	   'jm'=>'Jamaica',
	   'jp'=>'Japan',
	   'je'=>'Jersey',
	   'jo'=>'Jordan',
	   'kz'=>'Kazakhstan',
	   'ke'=>'Kenya',
	   'ki'=>'Kiribati',
	   'kr'=>'Korea, Republic of',
	   'kp'=>'Korea,D.P.R.O.K',
	   'kw'=>'Kuwait',
	   'kg'=>'Kyrgyzstan',
	   'la'=>'Lao,P.D.R.L',
	   'lv'=>'Latvia',
	   'lb'=>'Lebanon',
	   'ls'=>'Lesotho',
	   'lr'=>'Liberia',
	   'ly'=>'Libyan Arab Jamahiriya',
	   'li'=>'Liechtenstein',
	   'lt'=>'Lithuania',
	   'lu'=>'Luxembourg',
	   'mo'=>'Macao',
	   'mk'=>'Macedonia,F.Y.R.o.M',
	   'mg'=>'Madagascar',
	   'mw'=>'Malawi',
	   'my'=>'Malaysia',
	   'mv'=>'Maldives',
	   'ml'=>'Mali',
	   'mt'=>'Malta',
	   'mh'=>'Marshall Islands',
	   'mq'=>'Martinique',
	   'mr'=>'Mauritania',
	   'mu'=>'Mauritius',
	   'yt'=>'Mayotte',
	   'mx'=>'Mexico',
	   'fm'=>'Micronesia,F.S.O.M',
	   'md'=>'Moldova',
	   'mc'=>'Monaco',
	   'mn'=>'Mongolia',
	   'me'=>'Montenegro',
	   'ms'=>'Montserrat',
	   'ma'=>'Morocco',
	   'mz'=>'Mozambique',
	   'mm'=>'Myanmar',
	   'na'=>'Namibia',
	   'nr'=>'Nauru',
	   'np'=>'Nepal',
	   'an'=>'Netherlands Antilles',
	   'nc'=>'New Caledonia',
	   'nz'=>'New Zealand',
	   'ni'=>'Nicaragua',
	   'ne'=>'Niger',
	   'ng'=>'Nigeria',
	   'nu'=>'Niue',
	   'nf'=>'Norfolk Island',
	   'mp'=>'Northern Mariana Islands',
	   'no'=>'Norway',
	   'om'=>'Oman',
	   'pk'=>'Pakistan',
	   'pw'=>'Palau',
	   'ps'=>'Palestinian Territory',
	   'pa'=>'Panama',
	   'pg'=>'Papua New Guinea',
	   'py'=>'Paraguay',
	   'pe'=>'Peru',
	   'ph'=>'Philippines',
	   'pn'=>'Pitcairn',
	   'pl'=>'Poland',
	   'pt'=>'Portugal',
	   'pr'=>'Puerto Rico',
	   'qa'=>'Qatar',
	   're'=>'Reunion',
	   'ro'=>'Romania',
	   'ru'=>'Russian Federation',
	   'rw'=>'Rwanda',
	   'kn'=>'Saint Kitts and Nevis',
	   'lc'=>'Saint Lucia',
	   'vc'=>'Saint Vincent and the Grenadines',
	   'ws'=>'Samoa',
	   'sm'=>'San Marino',
	   'st'=>'Sao Tome and Principe',
	   'sa'=>'Saudi Arabia',
	   'sn'=>'Senegal',
	   'rs'=>'Serbia',
	   'sc'=>'Seychelles',
	   'sl'=>'Sierra Leone',
	   'sk'=>"Slovakia (Slovak Republic)",
	   'si'=>'Slovenia',
	   'sb'=>'Solomon Islands',
	   'so'=>'Somalia',
	   'za'=>'South Africa',
	   'gs'=>'South Georgia &amp; T.S.S.I',
	   'lk'=>'Sri Lanka',
	   'sh'=>'St. Helena',
	   'pm'=>'St. Pierre and Miquelon',
	   'sd'=>'Sudan',
	   'sr'=>'Suriname',
	   'sj'=>"Svalbard &amp; J.M.I",
	   'sz'=>'Swaziland',
	   'se'=>'Sweden',
	   'sy'=>'Syrian Arab Republic',
	   'tw'=>'Taiwan',
	   'tj'=>'Tajikistan',
	   'tz'=>'Tanzania,U.R.O.T',
	   'th'=>'Thailand',
	   'tl'=>'Timor-Leste',
	   'tg'=>'Togo',
	   'tk'=>'Tokelau',
	   'to'=>'Tonga',
	   'tt'=>'Trinidad and Tobago',
	   'tn'=>'Tunisia',
	   'tr'=>'Turkey',
	   'tm'=>'Turkmenistan',
	   'tc'=>"Turks &amp; Caicos Islands",
	   'tv'=>'Tuvalu',
	   'ug'=>'Uganda',
	   'ua'=>'Ukraine',
	   'ae'=>'United Arab Emirates',
	   'um'=>'United States M.O.I',
	   'uy'=>'Uruguay',
	   'uz'=>'Uzbekistan',
	   'vu'=>'Vanuatu',
	   'va'=>"Vatican City State (Holy See)",
	   've'=>'Venezuela',
	   'vn'=>'Viet Nam',
	   'vg'=>'Virgin Islands (British)',
	   'vi'=>"Virgin Islands (U.S.)",
	   'wf'=>"Wallis and Futuna Islands",
	   'eh'=>'Western Sahara',
	   'ye'=>'Yemen',
	   'zm'=>'Zambia',
	   'zw'=>'Zimbabwe'
	);

	$current_arr = array(
		"USD"=>"$",
		"EUR"=>"€",
		"GBP"=>"£",
		"CAD"=>"$",
		"AUD"=>"$",
		"CHF"=>"₣",
		"HKD"=>"$",
		"JPY"=>"¥",
		"BRL"=>"R$",
		"NOK"=>"kr.",
		"DKK"=>"kr.",
		"SEK"=>"Kr.",
		"MXN"=>"$",
		"NZD"=>"$",
		"SGD"=>"$",
		"RUB"=>"руб"
	);

	$default_country_code = $_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us';
	$currency = $_SESSION['currency'] ? $currency_symbol.$_SESSION['currency'] : '$USD';

	$country_code = strtoupper($default_country_code);
	$currency_code = $_SESSION['currency'];

	//选择货币
	$html .='<div class="top_main_right_currency">';
	$html .='<a class="top_main_right_currency_a" href="javascript:;">$'.$currency.'</a><i></i>';
	$html .='<div class="top_main_right_currency_more">';
	$html .='<div class="top_main_right_currency_more_arrow"></div>';
	$html .='<ul class="choose_currency_list">';
	foreach($current_arr as $_k=>$_v){
		$html .='<li onclick="save_select_info(\''.$country_code.'\',\''.$_k.'\')"><a href="javascript:;">'.$_v.'<em>'.$_k.'</em></a></li>';
	}
	$html .='</ul></div></div>';

	//选择国家
	$html .='<div class="top_main_right_country">';
	$html .='<a class="top_main_right_country_a" href="javascript:;">'.zen_get_default_country_name($_SESSION['countries_iso_code']).'</a><i></i><em class="'.$default_country_code.'"></em>';
	$html .='<div class="searchCountry">';
	$html .='<div class="top_main_right_country_more_arrow"></div>';
	$html .='<ul class="countryList">';
	$html .='<p class="country_prompt">Search your country</p><input type="text" class="search_input"/>';
	foreach($country_arr as $k=>$v){
		$html .='<li class="" onclick="save_select_info(\''.strtoupper($k).'\',\''.$currency_code.'\')"><a href="javascript:void(0);"><em class="flag '.$k.'"></em>'.$v.'</a></li>';
	}
	$html .='</ul></div></div>';
	return $html;
}


//首页meta标签加载
function zen_choice_meta_to_howpage(){
	global $db;
	$meta_html = '';

	if(in_array($_GET['main_page'], array('tutorial_detail'))){
		$meta_html .='<meta name="twitter:card" content="summary_large_image">';
		$meta_html .='<meta name="twitter:site" content="@Fiberstore">';
		$meta_html .='<meta name="twitter:title" content="'.META_TAG_KEYWORDS.'">';
		$meta_html .='<meta name="twitter:description" content="'.META_TAG_DESCRIPTION.'">';

		if(isset($_GET['a_id']) && intval($_GET['a_id'])){
			$doc_article_content = fs_get_data_from_db_fields('doc_article_content',TABLE_DOC_ARTICLE_DESCRIPTION,'doc_article_id = "'.intval($_GET['a_id']).'" and language_id ='.$_SESSION['languages_id'],'');
		}
		//$NowUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		//$text=file_get_contents($NowUrl);
		//取得所有img标签，并储存至二维数组 $match 中
		preg_match_all('/<img[^>]*>/i', stripslashes($doc_article_content), $tutorial_article_match);
		$test_img_text = explode("src=\"",$tutorial_article_match[0][0]) ;
		$img_bak = zen_get_image_bak($test_img_text[1]);
		if($img_bak){
			$test_img_url = explode($img_bak,$test_img_text[1]) ;
			//echo $test_img_url[0].$img_bak;
			$tutorial_detail_content = $test_img_url[0].$img_bak;
		}
		$meta_html .='<meta name="twitter:image" content="'.$tutorial_detail_content.'">';
		$meta_html .='<meta name="twitter:url" content="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />';
		$meta_html .='<meta name="twitter:creator" content="@Fiberstore">';
	}else{
		if( in_array($_GET['main_page'],array('products_detail')) ){
			$meta_html .='<meta name="twitter:card" content="summary_large_image">';
			$meta_html .='<meta name="twitter:site" content="@Fiberstore">';
			$meta_html .='<meta name="twitter:title" content="'.META_TAG_KEYWORDS.'">';
			$meta_html .='<meta name="twitter:description" content="'.META_TAG_DESCRIPTION.'">';

			if (isset($_GET['s_id']) && intval($_GET['s_id'])){
				$support_article_content = fs_get_data_from_db_fields('doc_article_content',TABLE_SOLUTION_ARTICLE_DESCRIPTION,'doc_article_id = "'.intval($_GET['s_id']).'" and language_id ='.$_SESSION['languages_id'],'');
			}
			preg_match_all('/<img[^>]*>/i',stripslashes($support_article_content), $support_article_match);
			$support_img_text = explode("src=\"",$support_article_match[0][0]) ;
			$img_bak2 = zen_get_image_bak($support_img_text[1]);
			if($img_bak2){
				$support_img_url = explode($img_bak2,$support_img_text[1]) ;
				//echo $support_img_url[0].$img_bak2;
				$products_detail_content = $support_img_url[0].$img_bak2;
			}
			$meta_html .='<meta name="twitter:image" content="'.$products_detail_content.'">';

			$meta_html .='<meta name="twitter:url" content="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />';
			$meta_html .='<meta name="twitter:creator" content="@Fiberstore">';

		}else{
			if(in_array($_GET['main_page'], array('news_article'))){
				$meta_html .='<meta name="twitter:card" content="summary_large_image">';
				$meta_html .='<meta name="twitter:site" content="@Fiberstore">';
				$meta_html .='<meta name="twitter:title" content="'.META_TAG_KEYWORDS.'">';
				$meta_html .='<meta name="twitter:description" content="'.META_TAG_DESCRIPTION.'">';

				if (isset($_GET['article_id']) && intval($_GET['article_id'])){
					$new_content_query = "select news_article_text from " .TABLE_NEWS_ARTICLES_TEXT . "
										where article_id = ".intval($_GET['article_id'])." and language_id = ".(int)$_SESSION['languages_id'];
					$new_article_text = $db->Execute($new_content_query);
				}
				preg_match_all('/<img[^>]*>/i',stripslashes($new_article_text->fields['news_article_text']), $new_article_match);
				$new_img_text = explode("src=\"",$new_article_match[0][0]) ;
				$img_bak3 = zen_get_image_bak($new_img_text[1]);
				if($img_bak3){
					$new_img_url = explode($img_bak3,$new_img_text[1]) ;
					//echo $new_img_url[0].$img_bak3;
					$news_article_content = $new_img_url[0].$img_bak3;
				}
				$meta_html .='<meta name="twitter:image" content="'.$news_article_content.'">';
				$meta_html .='<meta name="twitter:url" content="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />';
				$meta_html .='<meta name="twitter:creator" content="@Fiberstore">';
			}
		}
	}

	return $meta_html;
}

function zen_country_curreny($type){
	require_once DIR_WS_CLASSES .'set_cookie.php';
	$Encryption = new Encryption;
	$html = '';

	$country_arr = array(
	   'us'=>'United States',
	   'gb'=>'United Kingdom',
	   'ca'=>'Canada',
	   'au'=>'Australia',
	   'fr'=>'France',
	   'de'=>'Germany',
	   'es'=>'Spain',
	   'nl'=>'Netherlands',
	   'in'=>'India',
	   'br'=>'Brazil',
	   'ch'=>'Switzerland',
	   'it'=>'Italy',
	   'sg'=>'Singapore',
	   'ax'=>'Aland Island',
	   'af'=>'Afghanistan',
	   'al'=>'Albania',
	   'dz'=>'Algeria',
	   'as'=>'American Samoa',
	   'ad'=>'Andorra',
	   'ao'=>'Angola',
	   'ai'=>'Anguilla',
	   'aq'=>'Antarctica',
	   'ag'=>'Antigua and Barbuda',
	   'ar'=>'Argentina',
	   'am'=>'Armenia',
	   'aw'=>'Aruba',
	   'at'=>'Austria',
	   'az'=>'Azerbaijan',
	   'bs'=>'Bahamas',
	   'bh'=>'Bahrain',
	   'bd'=>'Bangladesh',
	   'bb'=>'Barbados',
	   'by'=>'Belarus',
	   'be'=>'Belgium',
	   'bz'=>'Belize',
	   'bj'=>'Benin',
	   'bm'=>'Bermuda',
	   'bt'=>'Bhutan',
	   'bo'=>'Bolivia',
	   'ba'=>'Bosnia and Herzegovina',
	   'bw'=>'Botswana',
	   'bv'=>'Bouvet Island',
	   'io'=>'British Indian Ocean Territory',
	   'bn'=>'Brunei Darussalam',
	   'bg'=>'Bulgaria',
	   'bf'=>'Burkina Faso',
	   'bi'=>'Burundi',
	   'kh'=>'Cambodia',
	   'cm'=>'Cameroon',
	   'cv'=>'Cape Verde',
	   'ky'=>'Cayman Islands',
	   'cf'=>'Central African Republic',
	   'td'=>'Chad',
	   'cl'=>'Chile',
	   'cn'=>'China',
	   'cx'=>'Christmas Island',
	   'cc'=>'Cocos (Keeling) Islands',
	   'co'=>'Colombia',
	   'km'=>'Comoros',
	   'cg'=>'Congo',
	   'ck'=>'Cook Islands',
	   'cr'=>'Costa Rica',
	   'ci'=>"Cote D'Ivoire",
	   'hr'=>'Croatia',
	   'cu'=>'Cuba',
	   'cy'=>'Cyprus',
	   'cz'=>'Czech Republic',
	   'dk'=>'Denmark',
	   'dj'=>'Djibouti',
	   'dm'=>'Dominica',
	   'do'=>'Dominican Republic',
	   'ec'=>'Ecuador',
	   'eg'=>'Egypt',
	   'sv'=>'El Salvador',
	   'gq'=>'Equatorial Guinea',
	   'er'=>'Eritrea',
	   'ee'=>'Estonia',
	   'et'=>'Ethiopia',
	   'fk'=>'Falkland Islands (Malvinas)',
	   'fo'=>'Faroe Islands',
	   'fj'=>'Fiji',
	   'fi'=>'Finland',
	   'gf'=>'French Guiana',
	   'pf'=>'French Polynesia',
	   'tf'=>'French Southern Territories',
	   'ga'=>'Gabon',
	   'gm'=>'Gambia',
	   'ge'=>'Georgia',
	   'gh'=>'Ghana',
	   'gi'=>'Gibraltar',
	   'gr'=>'Greece',
	   'gl'=>'Greenland',
	   'gd'=>'Grenada',
	   'gp'=>'Guadeloupe',
	   'gu'=>'Guam',
	   'gt'=>'Guatemala',
	   'gg'=>'Guernsey',
	   'gn'=>'Guinea',
	   'gw'=>'Guinea-bissau',
	   'gy'=>'Guyana',
	   'ht'=>'Haiti',
	   'hm'=>'Heard and Mc Donald Islands',
	   'hn'=>'Honduras',
	   'hk'=>'Hong Kong',
	   'hu'=>'Hungary',
	   'is'=>'Iceland',
	   'id'=>'Indonesia',
	   'ir'=>'Iran (Islamic Republic of)',
	   'iq'=>'Iraq',
	   'ie'=>'Ireland',
	   'im'=>'Isle of Man',
	   'il'=>'Israel',
	   'jm'=>'Jamaica',
	   'jp'=>'Japan',
	   'je'=>'Jersey',
	   'jo'=>'Jordan',
	   'kz'=>'Kazakhstan',
	   'ke'=>'Kenya',
	   'ki'=>'Kiribati',
	   'kr'=>'Korea, Republic of',
	   'kp'=>'Korea,D.P.R.O.K',
	   'kw'=>'Kuwait',
	   'kg'=>'Kyrgyzstan',
	   'la'=>'Lao,P.D.R.L',
	   'lv'=>'Latvia',
	   'lb'=>'Lebanon',
	   'ls'=>'Lesotho',
	   'lr'=>'Liberia',
	   'ly'=>'Libyan Arab Jamahiriya',
	   'li'=>'Liechtenstein',
	   'lt'=>'Lithuania',
	   'lu'=>'Luxembourg',
	   'mo'=>'Macao',
	   'mk'=>'Macedonia,F.Y.R.o.M',
	   'mg'=>'Madagascar',
	   'mw'=>'Malawi',
	   'my'=>'Malaysia',
	   'mv'=>'Maldives',
	   'ml'=>'Mali',
	   'mt'=>'Malta',
	   'mh'=>'Marshall Islands',
	   'mq'=>'Martinique',
	   'mr'=>'Mauritania',
	   'mu'=>'Mauritius',
	   'yt'=>'Mayotte',
	   'mx'=>'Mexico',
	   'fm'=>'Micronesia,F.S.O.M',
	   'md'=>'Moldova',
	   'mc'=>'Monaco',
	   'mn'=>'Mongolia',
	   'me'=>'Montenegro',
	   'ms'=>'Montserrat',
	   'ma'=>'Morocco',
	   'mz'=>'Mozambique',
	   'mm'=>'Myanmar',
	   'na'=>'Namibia',
	   'nr'=>'Nauru',
	   'np'=>'Nepal',
	   'an'=>'Netherlands Antilles',
	   'nc'=>'New Caledonia',
	   'nz'=>'New Zealand',
	   'ni'=>'Nicaragua',
	   'ne'=>'Niger',
	   'ng'=>'Nigeria',
	   'nu'=>'Niue',
	   'nf'=>'Norfolk Island',
	   'mp'=>'Northern Mariana Islands',
	   'no'=>'Norway',
	   'om'=>'Oman',
	   'pk'=>'Pakistan',
	   'pw'=>'Palau',
	   'ps'=>'Palestinian Territory',
	   'pa'=>'Panama',
	   'pg'=>'Papua New Guinea',
	   'py'=>'Paraguay',
	   'pe'=>'Peru',
	   'ph'=>'Philippines',
	   'pn'=>'Pitcairn',
	   'pl'=>'Poland',
	   'pt'=>'Portugal',
	   'pr'=>'Puerto Rico',
	   'qa'=>'Qatar',
	   're'=>'Reunion',
	   'ro'=>'Romania',
	   'ru'=>'Russian Federation',
	   'rw'=>'Rwanda',
	   'kn'=>'Saint Kitts and Nevis',
	   'lc'=>'Saint Lucia',
	   'vc'=>'Saint Vincent and the Grenadines',
	   'ws'=>'Samoa',
	   'sm'=>'San Marino',
	   'st'=>'Sao Tome and Principe',
	   'sa'=>'Saudi Arabia',
	   'sn'=>'Senegal',
	   'rs'=>'Serbia',
	   'sc'=>'Seychelles',
	   'sl'=>'Sierra Leone',
	   'sk'=>"Slovakia (Slovak Republic)",
	   'si'=>'Slovenia',
	   'sb'=>'Solomon Islands',
	   'so'=>'Somalia',
	   'za'=>'South Africa',
	   'gs'=>'South Georgia &amp; T.S.S.I',
	   'lk'=>'Sri Lanka',
	   'sh'=>'St. Helena',
	   'pm'=>'St. Pierre and Miquelon',
	   'sd'=>'Sudan',
	   'sr'=>'Suriname',
	   'sj'=>"Svalbard &amp; J.M.I",
	   'sz'=>'Swaziland',
	   'se'=>'Sweden',
	   'sy'=>'Syrian Arab Republic',
	   'tw'=>'Taiwan',
	   'tj'=>'Tajikistan',
	   'tz'=>'Tanzania,U.R.O.T',
	   'th'=>'Thailand',
	   'tl'=>'Timor-Leste',
	   'tg'=>'Togo',
	   'tk'=>'Tokelau',
	   'to'=>'Tonga',
	   'tt'=>'Trinidad and Tobago',
	   'tn'=>'Tunisia',
	   'tr'=>'Turkey',
	   'tm'=>'Turkmenistan',
	   'tc'=>"Turks &amp; Caicos Islands",
	   'tv'=>'Tuvalu',
	   'ug'=>'Uganda',
	   'ua'=>'Ukraine',
	   'ae'=>'United Arab Emirates',
	   'um'=>'United States M.O.I',
	   'uy'=>'Uruguay',
	   'uz'=>'Uzbekistan',
	   'vu'=>'Vanuatu',
	   'va'=>"Vatican City State (Holy See)",
	   've'=>'Venezuela',
	   'vn'=>'Viet Nam',
	   'vg'=>'Virgin Islands (British)',
	   'vi'=>"Virgin Islands (U.S.)",
	   'wf'=>"Wallis and Futuna Islands",
	   'eh'=>'Western Sahara',
	   'ye'=>'Yemen',
	   'zm'=>'Zambia',
	   'zw'=>'Zimbabwe'
	);

	$current_arr = array(
		"USD"=>"$",
		"EUR"=>"€",
		"GBP"=>"£",
		"CAD"=>"$",
		"AUD"=>"$",
		"CHF"=>"₣",
		"HKD"=>"$",
		"JPY"=>"¥",
		"BRL"=>"R$",
		"NOK"=>"kr.",
		"DKK"=>"kr.",
		"SEK"=>"Kr.",
		"MXN"=>"$",
		"NZD"=>"$",
		"SGD"=>"$",
		"RUB"=>"руб"
	);

	$default_country_code = $_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us';
	$currency = $_SESSION['currency'] ? $currency_symbol.$_SESSION['currency'] : '$USD';

	$country_code = strtoupper($default_country_code);
	$currency_code = $_SESSION['currency'];

	switch($type){
		case 'country':
			foreach($country_arr as $k=>$v){
				$html .='<li onclick="save_select_info(\''.strtoupper($k).'\',\''.$currency_code.'\')"><label><em class="'.$k.'"></em><b>'.$v.'</b></label></li>';
			}
		break;

		case 'currency':
			foreach($current_arr as $_k=>$_v){
				if($_k==$currency_code){
					$html .='<li onclick="save_select_info(\''.$country_code.'\',\''.$_k.'\')"><label><input type="radio" name="LOP" value="" checked=""><span class="icon iconfont">&#xf021;</span>'.$_v.' - '.$_k.'</label></li>';
				}else{
					$html .='<li onclick="save_select_info(\''.$country_code.'\',\''.$_k.'\')"><label><input type="radio" name="LOP" value=""><span class="icon iconfont">&#xf022;</span>'.$_v.' - '.$_k.'</label></li>';
				}
			}
		break;

		default:
			$html = '';
	}
	return $html;
}

//首页欧洲国家节假日提示
//add by aron
function eu_festival_message(){
	$current_page = $_GET['main_page'];
	$this_is_home_page = ($current_page=='index' && (!isset($_GET['cPath']) || $_GET['cPath'] == '') && (!isset($_GET['manufacturers_id']) || $_GET['manufacturers_id'] == '') && (!isset($_GET['typefilter']) || $_GET['typefilter'] == '') );
	$html = "";
	$code = strtoupper($_SESSION['countries_iso_code']);

	$start = 3;//提前3天开始展示
	$site = $_SESSION['languages_code'];
	//只在首页展示
	if(!$this_is_home_page){
		return $html;
	}

	$code = strtoupper($code);
	$area = fs_get_data_from_db_fields('time_zone','country_time_zone','code = "'.$code.'" limit 1');

	$now = getTime("Y-m-d","",$code,'',true,$area);

	$year = getTime("Y","",$code,'',true,$area);
	$years = getTime("Y",strtotime('+1years'),$code,'',true,$area);

	// $festival_date_star 数组中存储的是，$key：放假开始时间；$val：放假天数；
	if(other_eu_warehouse($code,"country_code")||german_warehouse("country_code",$code)){
		//欧洲放假日期及放假天数
		$is_eu = true;
		$festival_date_star = array(
            "$year-1-6"=>1,//三圣节
            "$year-4-2"=>4,//耶稣受难节+复活节
            //"$year-5-1"=>2,//劳动节
            "$year-5-13"=>1,//升天节
            "$year-5-24"=>1,//周一圣灵降临节
            "$year-5-21"=>1,//耶稣升天日
            "$year-6-3"=>1,//基督圣体节
            "$year-11-1"=>1,//万圣节
			"$year-12-24"=>4,//圣诞节          //  修改放假天数  tim  20201222
			"$year-12-30"=>5,//元旦
			//以下放假时间均在周末,不进行展示
//			"$year-8-15"=>1,
//			"$year-10-3"=>1,
//			"$year-11-1"=>3,
		);

		$text_one = FS_FESTIVAL1;
		$text_two = FS_FESTIVAL3;
		$text_three = FS_FESTIVAL8;
	}elseif (seattle_warehouse("country_code",$code)){
		//美国放假日期及放假天数
		$is_eu = false;
		$festival_date_star = array(
            "$years-1-1"=>3,        //  New Year's Day
            "$year-1-1"=>3,        //  New Year's Day
            "$year-5-31"=>1,        //  Memorial Day
            "$year-7-5"=>1,         //  Independence Day
            "$year-9-6"=>1,         //  Labor Day
            "$year-11-25"=>1,       //  Thanksgiving
			"$year-12-24"=>4    //  修改放假天数  tim  20201222
		);
		$text_one = FS_FESTIVAL6;
		$text_two = FS_FESTIVAL7;
		$text_three = FS_FESTIVAL8_01;
	}elseif($code =="AU" ||  $code =="NZ"){
        //澳洲放假日期及放假天数
        $is_eu = false;
        $festival_date_star = array(
			"$years-1-1"=>3,        //  New Year's Day
			"$year-1-1"=>3,        //  New Year's Day
			"$year-1-26"=>1,        //  Australia Day
			"$year-3-8"=>1,         //  Labour Day
			"$year-4-2"=>4,        //  Good Friday* Easter Monday
			//"$year-4-25"=>2,
			"$year-7-14"=>1,         //  Queen's Birthday
			//"$year-9-25"=>3,        //
			"$year-11-2"=>1,        //  Melbourne Cup
			"$year-12-25"=>4        //  修改放假天数  tim  20201222
		);
        $text_one = FS_FESTIVAL13;
        $text_two = FS_FESTIVAL14;
        $text_three = FS_FESTIVAL15;
    }elseif (singapore_warehouse("country_code", $code)){
        // 新加坡放假日期及放假天数
        $festival_date_star = array(
            "$year-2-12" => 3,      //  Chinese New Year
            "$year-4-2" => 3,       //  Good Friday
            //"$year-5-1" => 3,
            "$year-5-13" => 1,       //  Hari Raya Puasa
            "$year-5-26" => 1,      //  Vesak Day
            "$year-7-20" => 1,      //  Hari Raya Haji
            "$year-8-9" => 1,       //  National Day
            "$year-11-4" => 1,     //  Deepavali
            "$year-12-25" => 3      //  修改圣诞节放假天数  tim  20201222
        );
        $text_one = FS_FESTIVAL16;
        $text_two = FS_FESTIVAL17;
        $text_three = FS_FESTIVAL8;
	}elseif (ru_warehouse("country_code", $code)){
        // 俄罗斯放假日期及放假天数
        $is_eu = true;
        $festival_date_star = array(
            "$years-1-1"=>10,        //  New Year's Day
            "$year-1-1"=>10,        //  New Year's Day
            "$year-2-22"=>2,        //  Defenders' Day
            "$year-3-8"=>1,        //  Women's day
            "$year-5-3"=>1,        //  Day of Labour and Spring
            "$year-5-10"=>1,        //  Victory's Day
            "$year-7-14"=>1,         //  Day of Russia
            "$year-11-4"=>4,         //  Day of People's Unity
        );
        $text_one = FS_FESTIVAL18;
        $text_two = FS_FESTIVAL19;
        $text_three = FS_FESTIVAL8;
    }else{
		return $html;
	}
	$is_show=false;
    $day = '';
	foreach ($festival_date_star as $k=>$v){
		//欧洲与美国时间顺序表达不一致
		if($is_eu || in_array($site,array('de','ru','fr','es','mx'))){


			//3天前开始展示
			if($code == "GB"){
				$of = FIBERSTORE_OF;
			}else{
				$of = "";
			}
			if(in_array($site,array('ru','fr'))){
				$beigin_time =  getTime("j",strtotime($k),$code,'',true,$area)." ".get_date_translate(getTime("F",strtotime($k),$code,'',true,$area),$_SESSION['languages_id'])." ".getTime("Y",strtotime($k),$code,'',true,$area);
				//结束时间
				$end_time = getTime("j",strtotime("$k +$v days"),$code,'',true,$area)." ".get_date_translate(getTime("F",strtotime("$k +$v days"),$code,'',true,$area),$_SESSION['languages_id']);
			}elseif (in_array($site,array('es','mx'))){
				$beigin_time = getTime("d.m.Y", strtotime($k), $code,'',true,$area);
				//结束时间
				$end_time = getTime("d.m.Y.", strtotime("$k +$v days"), $code,'',true,$area);
			} elseif(in_array($site,array('it'))) {
				$beigin_time = getTime("j", strtotime($k), $code,'',true,$area) . getLast(getTime("j", strtotime($k), $code,'',true,$area)) . " " . get_date_translate(getTime("F", strtotime($k), $code,'',true,$area), $_SESSION['languages_id']) . " " . getTime("Y", strtotime($k), $code,'',true,$area);

				//结束时间
				$end_time = getTime("j", strtotime("$k +$v days"), $code,'',true,$area) . getLast(getTime("j", strtotime("$k +$v days"), $code,'',true,$area)) . " " . get_date_translate(getTime("F", strtotime("$k +$v days"), $code,'',true,$area), $_SESSION['languages_id']). " " . getTime("Y", strtotime("$k +$v days"), $code,'',true,$area);

			}else {
				$beigin_time = getTime("j", strtotime($k), $code,'',true,$area) . getLast(getTime("j", strtotime($k), $code,'',true,$area)) . " " . get_date_translate(getTime("F", strtotime($k), $code,'',true,$area), $_SESSION['languages_id']) . ", " . getTime("Y", strtotime($k), $code,'',true,$area);

				//结束时间
				$end_time = getTime("j", strtotime("$k +$v days"), $code,'',true,$area) . getLast(getTime("j", strtotime("$k +$v days"), $code,'',true,$area)) . " " . get_date_translate(getTime("F", strtotime("$k +$v days"), $code,'',true,$area), $_SESSION['languages_id']);
                if ($code == 'RU') {
                    $end_time .=  ", " . getTime("Y", strtotime($k), $code,'',true,$area);
                }
			}
		}elseif($site == 'au'){
			//3天前开始展示
			$beigin_time = getTime("j",strtotime($k),$code,'',true,$area).getLast(getTime("j",strtotime($k),$code,'',true,$area))." ".getTime("F",strtotime($k),$code,'',true,$area).", ".getTime("Y",strtotime($k),$code,'',true,$area);
			//结束时间
			$end_time =getTime("j",strtotime("$k +$v days"),$code,'',true,$area).getLast(getTime("j",strtotime("$k +$v days"),$code,'',true,$area))." ".getTime("F",strtotime("$k +$v days"),$code,'',true,$area);
		}else{
		    if ($site == 'sg') {
                $mon = 'M';
            } else {
		        $mon = 'F';
            }
			//3天前开始展示
			$beigin_time = getTime($mon,strtotime($k),$code,'',true,$area)." ".getTime("d",strtotime($k),$code,'',true,$area).", ".getTime("Y",strtotime($k),$code,'',true,$area);
			//结束时间
			$end_time =getTime($mon,strtotime("$k +$v days"),$code,'',true,$area)." ".getTime("d",strtotime("$k +$v days"),$code,'',true,$area);
		}
		for($i=0;$i<=$start;$i++){
			$show_time = getTime("Y-m-d",strtotime("$k -$i days"),$code,'',true,$area);
			if($show_time==$now){
				$is_show=true;
                $day = $k;
				break 2;
			}
		}
		//持续时间
		for($d=0;$d<$v;$d++){
			$during_time = getTime("Y-m-d",strtotime("$k +$d days"),$code,'',true,$area);
			if($now==$during_time){
				$is_show=true;
                $day = $k;
				break 2;
			}
		}
	}
	if($site == "ru"){
		$str_dian = ' ';
	}else{
		$str_dian = '. ';
	}
	if($is_show){
	    if (intval($_COOKIE['holiday_c'.$day]) == 0) {
            $html = '<div class="eu_holiday">
                <div class="eu_holiday_main">
                    <p>' . $text_one . " " . $beigin_time . $str_dian . $text_three . ' ' . $end_time . $text_two . '</p>
                    <span class="eu_holiday_main_close icon iconfont" data-holiday="'.$day.'">&#xf092;</span>
                </div>
            </div>';
        }
	}
	return $html;
}

//de首页欧洲国家节假日提示
//add by aron
function de_eu_festival_message(){
	$current_page = $_GET['main_page'];
	$this_is_home_page = ($current_page=='index' && (!isset($_GET['cPath']) || $_GET['cPath'] == '') && (!isset($_GET['manufacturers_id']) || $_GET['manufacturers_id'] == '') && (!isset($_GET['typefilter']) || $_GET['typefilter'] == '') );
	$html = "";
	$code = strtoupper($_SESSION['countries_iso_code']);


	$start = 3;//提前3天开始展示

	$code = strtoupper($code);
	$area = fs_get_data_from_db_fields('time_zone','country_time_zone','code = "'.$code.'" limit 1');

	$now = getTime("Y-m-d","",$code,'',true,$area);
	$year = getTime("Y","",$code,'',true,$area);
	$years = getTime("Y",strtotime('+1years'),$code,'',true,$area);

	//只在首页展示
	if(!$this_is_home_page){
		return $html;
	}

	// $festival_date_star 数组中存储的是，$key：放假开始时间；$val：放假天数；
	//只有欧洲仓覆盖国家展示
	if(other_eu_warehouse($code,"country_code")||german_warehouse("country_code",$code)){
        $festival_date_star = array(
			"$year-1-6"=>1,//三圣节
			"$year-4-2"=>4,//耶稣受难节+复活节
			//"$year-5-1"=>2,//劳动节
			"$year-5-13"=>1,//升天节
			"$year-5-24"=>1,//周一圣灵降临节
			"$year-5-21"=>1,//耶稣升天日
			"$year-6-3"=>1,//基督圣体节
			"$year-11-1"=>1,//万圣节

			"$year-12-24"=>4,//圣诞节
			"$year-12-30"=>5,//元旦
			//以下放假时间均在周末,不进行展示
//			"$year-8-15"=>1,
//			"$year-10-3"=>1,
//			"$year-11-1"=>3,
		);
        $text_one = FS_FESTIVAL2;
		$text_two = FS_FESTIVAL3;
	}elseif (seattle_warehouse("country_code",$code)){
		$festival_date_star = array(
			"$years-1-1"=>3,        //  New Year's Day
			"$year-1-1"=>3,        //  New Year's Day
			"$year-5-31"=>1,        //  Memorial Day
			"$year-7-5"=>1,         //  Independence Day
			"$year-9-6"=>1,         //  Labor Day
			"$year-11-25"=>1,       //  Thanksgiving
			"$year-12-24"=>4        //  Christmas Day
		);
		$text_one = FS_FESTIVAL6;
		$text_two = FS_FESTIVAL7;
	}else{
		return $html;
	}
	$is_show=false;
	$day = '';
	foreach ($festival_date_star as $k=>$v){
		//3天前开始展示
		$beigin_time =  getTime("j",strtotime($k),$code,'',true,$area).". ".get_date_display_month_new(getTime("n",strtotime($k),$code,'',true,$area),$_SESSION['languages_id'])." ".getTime("Y",strtotime($k),$code,'',true,$area);
		//结束时间
		$end_time = getTime("j",strtotime("$k +$v days"),$code,'',true,$area).". ".get_date_display_month_new(getTime("n",strtotime("$k +$v days"),$code,'',true,$area),$_SESSION['languages_id']);
		for($i=0;$i<=$start;$i++){
			$show_time = getTime("Y-m-d",strtotime("$k -$i days"),$code,'',true,$area);
			if($show_time==$now){
			    $day = $k;
				$is_show=true;
				break 2;
			}
		}
		//持续时间
		for($d=0;$d<$v;$d++){
			$during_time = getTime("Y-m-d",strtotime("$k +$d days"),$code,'',true,$area);
			if($now==$during_time){
                $day = $k;
				$is_show=true;
				break 2;
			}
		}
	}
	if($is_show){
        if (intval($_COOKIE['holiday_c'.$day]) == 0) {
            $str_dian = '. ';
            $html = '<div class="eu_holiday">
			<div class="eu_holiday_main">
				<p>' . FS_FESTIVAL12 . " " . $beigin_time . $str_dian . $text_one . ' ' . $end_time . $text_two . '</p>
				<span class="eu_holiday_main_close icon iconfont" data-holiday="'.$day.'">&#xf092;</span>
			</div>
		    </div>';
        }
	}
	return $html;
}


//获取节假日放假天数
function get_festival_day($default_code,$day=0){
	$html = "";
	$code = isset($default_code) ? strtoupper($default_code) : strtoupper($_SESSION['countries_iso_code']);
        $now = getTime("Y-m-d",strtotime("+".$day." days"),$code);
	$year = getTime("Y","",$code);
	//$years = getTime("Y",strtotime('+1years'),$code);
	$is_festival = false;
	if(other_eu_warehouse($code,"country_code")||german_warehouse("country_code",$code)){
		//欧洲放假日期及放假天数
		$festival_date_star = array(
            "$year-1-6"=>1,//三圣节
            "$year-4-10"=>4,//耶稣受难节+复活节
            "$year-5-1"=>3,//劳动节
            "$year-6-1"=>1,//圣灵降临节
            "$year-5-21"=>1,//耶稣升天日
            "$year-6-11"=>1,//基督圣体节
            "$year-12-24"=>3,//圣诞节
            "$year-12-31"=>2,//元旦
            //以下放假时间均在周末,不进行展示
//			"$year-8-15"=>1,
//			"$year-10-3"=>1,
//			"$year-11-1"=>3,
		);
	}elseif (seattle_warehouse("country_code",$code)){
		//美国放假日期及放假天数
		$festival_date_star = array(
            "$year-1-1"=>1,
            "$year-5-25"=>1,
            "$year-7-3"=>3,
            "$year-9-7"=>1,
            "$year-11-26"=>1,
            "$year-12-24"=>2
        );
	}elseif (au_warehouse($code,"country_code")){
		$festival_date_star = array(
            "$year-1-1"=>1,
            "$year-1-27"=>1,
            "$year-3-9"=>1,
            "$year-4-10"=>4,
            "$year-4-25"=>2,
            "$year-6-8"=>1,
            "$year-9-25"=>3,
            "$year-11-3"=>1,
            "$year-12-25"=>2,
        );
    }elseif (singapore_warehouse("country_code", $code)){
        // 新加坡放假日期及放假天数
        $festival_date_star = array(
            "$year-1-1" => 1,
            "$year-1-25" => 3,
            "$year-4-10" => 3,
            "$year-5-1" => 3,
            "$year-5-7" => 1,
            "$year-5-24" => 2,
            "$year-7-31" => 3,
            "$year-8-9" => 2,
            "$year-10-27" => 2,
            "$year-12-25" => 1
        );
    }elseif (ru_warehouse("country_code", $code)){
        // 俄罗斯放假日期及放假天数
        $festival_date_star = array(
            "$year-1-1" => 10,
            "$year-2-22" => 1,
            "$year-3-8" => 1,
            "$year-5-3" => 3,
            "$year-5-10" => 1,
            "$year-5-24" => 2,
            "$year-7-14" => 1,
            "$year-11-4" => 4
        );
    }else{
		return 0;
	}

	foreach ($festival_date_star as $k=>$v){
		//持续时间
		$setInterval = $v;
		for($d=0;$d<$v;$d++){
			$during_time = getTime("Y-m-d",strtotime("$k +$d days"),$code);
			if($now==$during_time){
				$setInterval-=$d;
				$is_festival = true;
				break 2;
			}
		}
	};
	if($is_festival){
		$setInterval = $setInterval>0 ? $setInterval : 0;
		return $setInterval;
	}else{
		return 0;
	}
}


function getLast($day){
       $code = strtoupper($_SESSION['countries_iso_code']);
       $site = $_SESSION['languages_code'];
        if($code!="GB" && in_array($site,array("es",'de','fr','mx','ru'))){
            return "";
        }
       if(in_array($day,array(11,12,13))){
            return  FS_FESTIVAL9;
       }
	$day = (int)substr($day,-1);
	switch ($day){
		case 1:
			return FS_FESTIVAL4;
			break;
		case 2:
			return FS_FESTIVAL5;
			break;
		case 3:
			return FS_FESTIVAL10;
			break;
		default:
			return FS_FESTIVAL9;
	}
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 获取州
function get_all_country_area(){
    global $db;
    $result = $db->Execute("select area_type_id,area_name from country_to_website_area where language_id =".$_SESSION['languages_id']);
    $area_arr =array();
    if($result ->RecordCount()){
        while(!$result->EOF){
            $area_arr []=array(
                'id'=>$result->fields['area_type_id'],
                'area_name'=>$result->fields['area_name'],

            );
            $result->MoveNext();
        }
    }
    return $area_arr;

}

/*
 * 2019.8.8 yang add
 * 缓存国家信息
 */
function all_info_country(){
    define('PRODUCT_DETAIL_RELATED_ATTRIBUTE_REDIS_KEY_COUNTRY', 'country');
    $related_attribute_redis_key = $_SESSION['languages_code'].'country';
    $related_attributes_array = get_redis_key_value($related_attribute_redis_key,PRODUCT_DETAIL_RELATED_ATTRIBUTE_REDIS_KEY_COUNTRY);
    if (!$related_attributes_array) {
        $countries = zen_get_countries_by_code();
        set_redis_key_value($related_attribute_redis_key, $countries, 24 * 3600, PRODUCT_DETAIL_RELATED_ATTRIBUTE_REDIS_KEY_COUNTRY);
        return $countries;
    } else {
        return $related_attributes_array;
    }
}
//首页下拉框国家信息
function get_all_country_info($languages_code,$is_moblie_type =false){
    $file_path = DIR_FS_SQL_CACHE.'/htmls/'.$languages_code.'/';
    $file_name = 'country_select_list_'.$is_moblie_type.'.html';
    $file_path_name = $file_path.$file_name;
    //获取各站点默认放在最前面的国家
    $default_countries = zen_get_default_countries();
    if(in_array($languages_code,array('en','sg','au','uk'))){
        $main_country =array(
            138 => 'México',
            81  =>'Deutschland',
            195 =>'España',
            107 =>'日本',
            176 => 'Россия',
            105 => 'Italia'
        );
        $main_key =array_keys($main_country);
        $en_flag = true;
    }else{
        //定义主流国家数组
        $main_key = array(223,38,138,222,73,81,105,150,195,107,13,30,99,176,188);
        $en_flag = false;
    }
    $default_keys = array_keys($default_countries);
    // M端不进行缓存
    if ($is_moblie_type == true) {
        // M端拿缓存数据
        $countries = all_info_country();
        foreach ($default_countries as $k => $v) {
            $main_code = '';
            $country_name = zen_get_countries_name_by_id($k);
            if (in_array($k, $main_key)) {
                if ($en_flag) {
                    $main_code = " (" . $main_country[$k] . ")";
                } else {
                    if ($country_name != $v) {
                        $main_code = " (" . $v . ")";
                    }
                }
            }
            // 当前选择国家提示
            $str .= '<li class="index_wap_country_list';
            if ($_SESSION['countries_iso_code'] == strtolower(zen_get_country_iso_code($k))){
                $str .= ' active default';
            }
            $str .= '"><a href="javascript:;"><span class="index_wap_country_list_name"><i class="m-countryFlag-icon"><img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/mCountry-flag/ic_'.strtolower(zen_get_country_iso_code($k)).'.png" height="18"></i><i data-country="' . strtolower(zen_get_country_iso_code($k)) . '">' . $country_name . $main_code . '</i></span><icon class="icon iconfont">&#xf158;</icon></a></li>';
		}
        foreach ($countries as $i => $country) {
            $main_code = '';
            if (in_array($country['countries_id'], $default_keys)) {
                continue;
            }
            if (in_array($country['countries_id'], $main_key)) {
                if ($en_flag) {
                    $main_code = " (" . $main_country[$country['countries_id']] . ")";
                } else {
                    if ($country['countries_name'] != $country['english_countries_name']) {
                        $main_code = " (" . $country['english_countries_name'] . ")";
                    }
                }
            }
            // 当前选择国家提示
            $str .= '<li class="index_wap_country_list';
            if ($_SESSION['countries_iso_code'] == strtolower($country['countries_iso_code_2'])){
                $str .= ' active default';
            }
            $str .= '"> <a href="javascript:;"><span class="index_wap_country_list_name"><i class="m-countryFlag-icon"><img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/mCountry-flag/ic_'.strtolower($country['countries_iso_code_2']).'.png" height="18"></i><i data-country="' . strtolower($country['countries_iso_code_2']) . '">' . $country['countries_name'] . $main_code . '</i></span><icon class="icon iconfont">&#xf158;</icon></a></li>';
        }
        return $str;
    } else {
        if (!file_exists($file_path_name)) {
            //获取所有国家信息
            $countries = zen_get_countries_by_code();
            foreach ($default_countries as $k => $v) {
                $main_code  ='';
                $country_name = zen_get_countries_name_by_id($k);
                if(in_array($k,$main_key)){
                    if($en_flag){
                        $main_code =" (".$main_country[$k].")";
                    }else{
                        if($country_name != $v){
                            $main_code =" (".$v.")";
                        }
                    }
                }
                $str .= '<li class="unique"><a class="aclass" href="javascript:void(0);" tag="' . $k . '"  tag_name="' . $country_name . '" data-name="'.$v.'"><em class="' . strtolower(zen_get_country_iso_code($k)) . '"></em>' . $country_name . $main_code . '</a></li>';
            }
            $str .= '<div class="divider"></div>';
            foreach ($countries as $i => $country) {
                $main_code  ='';
                if(in_array($country['countries_id'],$main_key)){
                    if($en_flag){
                        $main_code =" (".$main_country[$country['countries_id']].")";
                    }else{
                        if($country['countries_name']!=$country['english_countries_name']){
                            $main_code =" (".$country['english_countries_name'].")";
                        }
                    }
                }
                $str .= '<li><a class="aclass" href="javascript:void(0);" tag="' . $country['countries_id'] . '"  tag_name="' . $country['countries_name'] . '" data-name="'.$country['english_countries_name'].'"><em class="' . strtolower($country['countries_iso_code_2']) . '"></em>' . $country['countries_name'] . $main_code . '</a></li>';
            }
            cacheFactory::save_caching_file_contents($file_name, $file_path, $str);
            return $str;
        }else{
            $buffer = file_get_contents($file_path_name);
            return $buffer;
        }
    }
}




// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新增获取当前站点
function get_fs_site_country($lanuages_code='',$countries_iso_code=''){
    if(!$lanuages_code){
        $languages_code = $_SESSION['languages_code'];
    }
    $countries_iso_code = $countries_iso_code?$countries_iso_code:$_SESSION['countries_iso_code'];
    $countryCode =strtoupper($countries_iso_code);
    switch ($languages_code){
        case 'de': $str = 'FS Deutschland';break;
        case 'es': $str = 'FS España';break;
		case 'fr':
			if($countryCode == 'CA'){
				$str = 'FS Canada';
			}else{
				$str = 'FS Français';
			}
			break;
		case 'mx':
			if($countryCode=='MX'){$str = 'FS México';}else{$str = '';}
			break;
        case 'uk': $str = 'FS United Kingdom';break;
        case 'au': $str = 'FS Australia';break;
        case 'sg': $str = 'FS Singapore';break;
        case 'jp': $str = 'FS 日本';break;
        case 'ru': $str = 'FS Россия';break;
        case 'en': // de站和其他语种不一样
            if($countryCode == 'US'){
                $str = 'FS United States';
            }elseif($countryCode == 'MX'){
				$str = 'FS Mexico';
			}elseif($countryCode == 'CA'){
                $str = 'FS Canada';
            }else{
				$str = '';//FS Global 去掉了 2019/5/6
			}
            break;
		case 'dn':	//de-en
			$str = 'FS Germany';break;
        default:   $str = '';break;//FS Global 去掉了 2019/5/6
    }
    return $str;
}

/**
 * add by Quest 2020.04.07
 * 获取顶部公共通告
 * @return mixed
 */
function get_header_common_notice(){

    $warehouse = get_country_belong_to_warehouse($_SESSION['languages_code'], $_SESSION['countries_iso_code']);
    $country_code = $_SESSION['countries_iso_code'];
    $country_name = get_code_tran_country_name($country_code, $_SESSION['languages_code']);

    switch ($warehouse){
        case 'us':
            $free_money = get_ori_free_shipping_money('us');
            $html = str_replace('$MONEY', $free_money['TextPri'], FS_NOTICE_FREE_SHIPPING);
            break;
        case 'de':
            $free_money = get_ori_free_shipping_money('de');
            if (in_array($_SESSION['languages_code'], ['fr','de','it'])) {
                $str_free_money = $free_money['TextPri'];
            } else {
                $str_free_money = $_SESSION['currency'] == 'EUR' ? 'EUR '.$free_money['free_price'] : $free_money['TextPri'];
            }
            if ($_SESSION['languages_code'] == 'de' && $_SESSION['countries_iso_code'] != 'ch') {
                $str_free_money .= ' (exkl. MwSt.)';
            }
            $html = str_replace('$MONEY', $str_free_money, FS_NOTICE_FREE_DELIVERY);

            if (in_array($country_code, ['mq', 'gf', 'yt', 'gp', 'bl', 'mf'])) {
                $html = str_replace('$COUNTRY', $country_name, FS_NOTICE_FAST_SHIPPING);
            }
            break;
        case 'au':
            $free_money = get_ori_free_shipping_money('au');
            if($country_code == 'au') {
                $html = str_replace('$MONEY', $free_money['TextPri'], FS_NOTICE_FREE_DELIVERY);
            }else{
                $html = str_replace('$COUNTRY', $country_name, FS_NOTICE_FAST_SHIPPING);
            }
            break;
        case 'sg':
            if($country_code == 'sg') {
                $html = str_replace('$MONEY', 'S$ 99', FS_NOTICE_FREE_SHIPPING);
            }else{
                $html = str_replace('$COUNTRY', $country_name, FS_NOTICE_FAST_SHIPPING);
            }
            break;
        case 'wh':
            if($country_code == 'ru') {
                $html = str_replace('$MONEY', '20 000 ₽', FS_NOTICE_FREE_SHIPPING);
            }else{
                $html = str_replace('$COUNTRY', $country_name, FS_NOTICE_FAST_SHIPPING);
            }
            break;
    }

    return $html;
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 获取免运费提示信息
function zen_free_shipping_str($position='header'){
    $str = get_country_belong_to_warehouse($_SESSION['languages_code'],$_SESSION['countries_iso_code']);
    if($str == 'us') {
		if( in_array($_SESSION['languages_code'],['en','fr']) && $_SESSION['countries_iso_code'] == 'ca' && $_SESSION['currency'] == 'CAD'){
			$html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_USFR_CA : FS_HEADER_FREE_SHIPPING_USFR_CA;
		}elseif(in_array($_SESSION['languages_code'],['en','mx']) && $_SESSION['countries_iso_code'] == 'mx' && $_SESSION['currency'] == 'MXN'){
			$html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_USMX_MX : FS_HEADER_FREE_SHIPPING_USMX_MX;
		}else{
			$html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_US_TIP : FS_HEADER_FREE_SHIPPING_US_TIP;
		}
    }elseif ($str == 'de'){
        $free_money = get_ori_free_shipping_money('de');
        if ($_SESSION['languages_code'] == 'fr') { //法语站点,德国仓时去掉EUR
            $str_free_money = $free_money['TextPri'];
        } else {
            //$str_free_money = $_SESSION['currency'] == 'EUR' ? 'EUR '.$free_money['TextPri'] : $free_money['TextPri'];
            if ($_SESSION['languages_code'] == 'de') {
                $str_free_money = $free_money['TextPri'];
            } else {
                $str_free_money = $_SESSION['currency'] == 'EUR' ? 'EUR '.$free_money['free_price'] : $free_money['TextPri'];
            }
        }
        $html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_DE_TIP : str_replace('$MONEY', $str_free_money, FS_HEADER_FREE_SHIPPING_DE_TIP);
    }elseif ($str == 'au'){
        if($_SESSION['languages_code']== "au" && $_SESSION['countries_iso_code']=="nz"){
            $html = ($position == 'footer')?FS_FOOTER_FREE_SHIPPING_NZ_TIP:FS_HEADER_FREE_SHIPPING_NZ_TIP;
        }else{
            $html = ($position == 'footer')?FS_FOOTER_FREE_SHIPPING_AU_TIP:FS_HEADER_FREE_SHIPPING_AU_TIP;
        }
    }elseif ($str == 'wh'){//武汉仓
        if ($_SESSION['languages_code'] == 'mx'){
            $html = ($position == 'footer')?FS_FOOTER_FREE_SHIPPING_CNMX_TIP:FS_HEADER_FREE_SHIPPING_CNMX_TIP;
        }elseif ($_SESSION['languages_code'] == 'ru'){
            if($_SESSION['countries_iso_code'] !='ru') {
                $html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_CNRU_TIP : FS_HEADER_FREE_SHIPPING_CNRU_TIP;
            }else{
                $html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_CN_TIP : '';
            }
        }elseif ($_SESSION['languages_code'] == 'jp') {
            $html = ($position == 'footer') ? FS_FOOTER_FREE_SHIPPING_CNJP_TIP : FS_HEADER_FREE_SHIPPING_CNJP_TIP;
        }elseif($_SESSION['countries_iso_code'] == 'sg'){
            if ($position == 'header') {
                $html = FS_BANNER_FREE_SHIPPING_CNSG_TIP;
            } else {
                $html = FS_FOOTER_FREE_SHIPPING_CN;
            }
        }else{ //输入英文
            //ru的例外
            if($_SESSION['countries_iso_code'] =='ru'){
                $html = ($position == 'header')?FS_FOOTER_FREE_SHIPPING_RU_TIP:FS_HEADER_FREE_SHIPPING_CNRU_TIP;
            }else{
                $html = ($position == 'footer')?FS_FOOTER_FREE_SHIPPING_CN_TIP:FS_HEADER_FREE_SHIPPING_CN_TIP;
            }
        }
        //拼接国家参数
        if ($position == 'header'){
            if ($_SESSION['languages_code'] == 'jp'){
                $html = get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']).$html;
            }elseif ($_SESSION['languages_code'] =='ru'){
                if($_SESSION['countries_iso_code'] !='ru'){
                    $html .= ' ' . get_code_tran_country_name($_SESSION['countries_iso_code'], $_SESSION['languages_code']);
                }else{//针对俄罗斯再添加其他
                   $html .= FS_SHIPPING_DELIVERY_RU;
                }
            }elseif($_SESSION['countries_iso_code'] == 'sg'){
                $html .= '';
            }else {
                    $html .= ' ' . get_code_tran_country_name($_SESSION['countries_iso_code'], $_SESSION['languages_code']);
                    if($_SESSION['countries_iso_code'] =='ru'){
                        $html .= FS_SHIPPING_DELIVERY_RU;
                    }
            }
        }
    }else{
        $html = ($position == 'footer')?FS_FOOTER_FREE_SHIPPING_OTHER_TIP:FS_HEADER_FREE_SHIPPING_OTHER_TIP;
    }
    return $html;
}

//M端获取免运费提示信息
function zen_free_shipping_str_mobile(){
    $str = get_country_belong_to_warehouse($_SESSION['languages_code'],$_SESSION['countries_iso_code']);
    if($str == 'us') {
		if( in_array($_SESSION['languages_code'],['en','fr']) && $_SESSION['countries_iso_code'] == 'ca' && $_SESSION['currency'] == 'CAD'){
			$html = FS_M_FREE_SHIPPING_USFR_CA;
		}elseif(in_array($_SESSION['languages_code'],['en','mx']) && $_SESSION['countries_iso_code'] == 'mx' && $_SESSION['currency'] == 'MXN'){
			$html = FS_M_FREE_SHIPPING_USMX_MX;
		}else{
			$html = FS_M_SHIPPING_US_TIP;
		}
    }elseif ($str == 'de'){
        $free_money = get_ori_free_shipping_money('de');
        if ($_SESSION['languages_code'] == 'fr') { //法语站点,德国仓时去掉EUR
            $str_free_money = $free_money['TextPri'];
        } else {
            if ($_SESSION['languages_code'] == 'de') {
                $str_free_money = $free_money['TextPri'];
            } else {
                $str_free_money = $_SESSION['currency'] == 'EUR' ? 'EUR '.$free_money['free_price'] : $free_money['TextPri'];
            }
        }
        $html = str_replace('$MONEY', $str_free_money, FS_M_FREE_SHIPPING_DE_TIP);
    }elseif ($str == 'au'){
        if($_SESSION['languages_code']== "au" && $_SESSION['countries_iso_code']=="nz"){
            $html = FS_M_FREE_SHIPPING_NZ_TIP;
        }else{
            $html = FS_M_FREE_SHIPPING_AU_TIP;
        }
    } elseif ($str == 'sg'){
        if ($_SESSION['countries_iso_code'] != 'sg'){
            $html = FS_M_FREE_SHIPPING_FAST_SHIPPING.get_code_tran_country_name($_SESSION['countries_iso_code'], $_SESSION['languages_code']);
        }else{
            $html = FS_M_BANNER_FREE_SHIPPING_CNSG_TIP;
        }
    } elseif ($str == 'wh'){//武汉仓
        if ($_SESSION['languages_code'] == 'mx'){
            $html = FS_HEADER_FREE_SHIPPING_CNMX_TIP;
        }elseif ($_SESSION['languages_code'] == 'ru'){
            if($_SESSION['countries_iso_code'] !='ru') {
                $html = FS_HEADER_FREE_SHIPPING_CNRU_TIP;
            }else{
                $html = '';
            }
        }elseif ($_SESSION['languages_code'] == 'jp') {
            $html = FS_HEADER_FREE_SHIPPING_CNJP_TIP;
        }elseif($_SESSION['countries_iso_code'] == 'sg'){
            $html = FS_M_BANNER_FREE_SHIPPING_CNSG_TIP;
        }else{ //输入英文
            //ru的例外
            if($_SESSION['countries_iso_code'] =='ru'){
                $html = FS_FOOTER_FREE_SHIPPING_RU_TIP;
            }else{
                $html = FS_HEADER_FREE_SHIPPING_CN_TIP;
            }
        }
        //拼接国家参数
		if ($_SESSION['languages_code'] == 'jp'){
			$html = get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']).$html;
		}elseif ($_SESSION['languages_code'] =='ru'){
			if($_SESSION['countries_iso_code'] !='ru'){
				$html .= ' ' . get_code_tran_country_name($_SESSION['countries_iso_code'], $_SESSION['languages_code']);
			}else{//针对俄罗斯再添加其他
				$html .= FS_M_SHIPPING_DELIVERY_RU;
			}
		}elseif($_SESSION['countries_iso_code'] == 'sg'){
			$html .= '';
		}else {
				$html .= ' ' . get_code_tran_country_name($_SESSION['countries_iso_code'], $_SESSION['languages_code']);
				if($_SESSION['countries_iso_code'] =='ru'){
					$html = FS_M_SHIPPING_DELIVERY_RU;
				}
		}
    }else{
		if($_SESSION['countries_iso_code'] == 'jp'){
			$html = get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']).' '.FS_M_FREE_SHIPPING_FAST_SHIPPING;
		}else{
			$html = FS_M_FREE_SHIPPING_FAST_SHIPPING.' '.get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']);
		}
    }

    return $html;
}

//2019/5/3 banner 提示需要
function zen_banner_tip(){
    $html = '';
    $html_end = '';
    if ($_SESSION['languages_code'] == 'mx'){
        $html = FS_BANNER_FREE_SHIPPING_CNMX_TIP;
        $html_end = FS_BANNER_FREE_SHIPPING_CNMX_TIP_END;
    }elseif ($_SESSION['languages_code'] == 'ru'){
        $html = FS_BANNER_FREE_SHIPPING_CNRU_TIP;
    }elseif ($_SESSION['languages_code'] == 'jp'){
        $html = FS_BANNER_FREE_SHIPPING_CNJP_TIP;
    }else{ //输入英文
        $html = FS_BANNER_FREE_SHIPPING_CN_TIP;
    }
    //拼接国家参数
    if ($_SESSION['languages_code'] == 'jp'){
        $html = get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']).$html;
    }elseif ($_SESSION['languages_code'] == 'mx'){
        $html = $html . ' ' . get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']).' '.$html_end;
    } elseif ($_SESSION['languages_code'] == 'ru' && get_warehouse_by_code($_SESSION['countries_iso_code']) == 'cn') {
        switch (strtoupper($_SESSION['countries_iso_code'])) {
            case 'UA':
                $html = $html . '<br/>по ' . 'Украине';
                break;
            case 'KZ':
                $html = $html . '<br/>по ' . 'Казахстану';
                break;
            case 'KG':
                $html = $html . '<br/>по ' . 'Киргизии';
                break;
            case 'TM':
                $html = $html . '<br/>по ' . 'Туркменистану';
                break;
            case 'UZ':
                $html = $html . '<br/>по ' . 'Узбекистану';
                break;
            case 'TJ':
                $html = $html . '<br/>по ' . 'Таджикистану';
                break;
            case 'GE':
                $html = $html . '<br/>по ' . 'Грузии';
                break;
            case 'AM':
                $html = $html . '<br/>по ' . 'Армении';
                break;
            case 'AZ':
                $html = $html . '<br/>по ' . 'Азербайджану';
                break;
        }

    }else{
        $html = get_code_tran_country_name($_SESSION['countries_iso_code'],$_SESSION['languages_code']).' '.$html;
    }
    return $html;
}

/***
 * @param $code
 * @return mixed|string
 * 获取国家名称
 */
function get_code_tran_country_name($countries_iso_code,$languages_code='en'){
    $name = '';
    global $db;
    $countrys = $db ->Execute("SELECT `countries_name`,`de_countries_name`,`fr_countries_name`,`es_countries_name`,`ru_countries_name`,`jp_countries_name` FROM countries WHERE `countries_iso_code_2`= '{$countries_iso_code}' LIMIT 1");
    if ($languages_code == 'de') {
        $name = $countrys ->fields['de_countries_name'];
    }elseif ($languages_code == 'fr'){
        $name = $countrys ->fields['fr_countries_name'];
    }elseif ($languages_code == 'ru'){
        $name = $countrys ->fields['ru_countries_name'];
    }elseif ($languages_code == 'jp'){
        $name = $countrys ->fields['jp_countries_name'];
    }elseif($languages_code == 'mx' || $languages_code == 'es'){
        $name = $countrys ->fields['es_countries_name'];
    }else{
        $name = $countrys ->fields['countries_name'];
    }
    return $name;
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 获取站点所有banner $str为banner编号
function get_warehouse_banner_str(){
	$str = get_country_belong_to_warehouse($_SESSION['languages_code'],$_SESSION['countries_iso_code']);
	//武汉仓
    if($str == 'wh'){
		if($_SESSION['countries_iso_code'] == 'ru'){
			$str = 'ru';
		}else{
			$str = 'cn';
		}
	}
	//德国仓
	if($str == 'de'){
		if($_SESSION['countries_iso_code'] == 'de' && in_array($_SESSION['languages_code'],['de','dn'])){
			$str = 'de';
		}elseif($_SESSION['countries_iso_code'] == 'va'){
            $str = 'de';
        }else{
			$str = 'eu';
		}
	}
    if($_SESSION['languages_code']=='uk'){
		if($_SESSION['countries_iso_code'] == 'je'){
			$str = 'je';
		}elseif($_SESSION['countries_iso_code'] == 'gg'){
			$str = 'gg';
		}elseif($_SESSION['countries_iso_code'] == 'im'){
			$str = 'im';
		}else{
			$str = 'uk';
		}
	}
	//澳洲仓
	if($str == 'au'){
		if($_SESSION['languages_code'] == 'au' && $_SESSION['countries_iso_code'] == 'nz'){
			$str = 'nz';
		}else{
			$str = 'au';
		}
	}
	if($_SESSION['languages_code'] == 'en'){
		if($_SESSION['countries_iso_code'] == 'ca'){
			$str = 'ca';
		}elseif($_SESSION['countries_iso_code'] == 'mx'){
			$str = 'mx';
		}elseif($_SESSION['countries_iso_code'] == 'us'){
			$str = 'us';
		}elseif($_SESSION['countries_iso_code'] == 'cn'){
			$str = 'cn';
		}elseif($_SESSION['countries_iso_code'] == 'jp'){
			$str = 'jp';
		}elseif($_SESSION['countries_iso_code'] == 'in'){
			$str = 'in';
		}elseif($_SESSION['countries_iso_code'] == 'br'){
			$str = 'br';
		}elseif($_SESSION['countries_iso_code'] == 'xb'){
		    $str = 'xb';
        }elseif($_SESSION['countries_iso_code'] == 'xc'){
            $str = 'xc';
        }elseif($_SESSION['countries_iso_code'] == 'xm'){
            $str = 'xm';
        }elseif($_SESSION['countries_iso_code'] == 'bq'){
            $str = 'bq';
        }elseif($_SESSION['countries_iso_code'] == 'xe'){
            $str = 'xe';
        }

	}
	if($_SESSION['languages_code'] == 'mx'){
		if($_SESSION['countries_iso_code'] == 'mx'){
			$str = 'mx';
		}else{
			$str = 'cn';
		}
	}

	if($_SESSION['languages_code'] == 'fr') {
		if($_SESSION['countries_iso_code'] == 'ca'){
			$str = 'ca';
		}else{
			$str = 'fr';
		}

	}

	if($_SESSION['languages_code'] == 'es'){
		$str = 'es';
	}

	if($_SESSION['languages_code'] == 'jp'){
		$str = 'jp';
	}

	if($_SESSION['languages_code'] == 'sg'){
		if($_SESSION['countries_iso_code'] == 'sg'){
			$str = 'sg';
		}elseif($_SESSION['countries_iso_code'] == 'my'){
			$str = 'my';
		}elseif($_SESSION['countries_iso_code'] == 'id'){
			$str = 'id';
		}elseif($_SESSION['countries_iso_code'] == 'ph'){
			$str = 'ph';
		}else{
			$str = 'cn';
		}
	}

	if($_SESSION['languages_code'] == 'it'){
        $str = 'it';
    }


    return $str;
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 获取站点仓库
function get_site_warehouse_str(){
    $str = get_warehouse_by_code($_SESSION['countries_iso_code']);
    $str = change_warsehouse_code_to_id($str);
    return $str;
}

// 2018.7.31 获取属于哪个仓库
function get_country_belong_to_warehouse($languages_code,$countries_iso_code){
    $languages_code = $languages_code ? $languages_code : $_SESSION['languages_code'];
    $countries_iso_code = $countries_iso_code ? $countries_iso_code : $_SESSION['countries_iso_code'];
    $countryCode = strtoupper($countries_iso_code);
    $str = '';
    if($countryCode){
        if (seattle_warehouse('country_code', $countryCode)) { //西雅图
            $str = 'us';
        }elseif (all_german_warehouse('country_code', $countryCode)) {
            $str = 'de';
        }elseif (get_warehouse_by_code($countryCode) == 'cn'){//武汉
            $str = 'wh';
        }elseif (get_warehouse_by_code($countryCode) == 'sg'){//武汉
            $str = 'sg';
        }else{
            // 除了上述情况。站点默认为
            if($languages_code == 'au'){
                $str = 'au';
            }elseif($languages_code == 'es' || $languages_code == 'de' || $languages_code == 'uk' || $languages_code == 'fr' || $languages_code == 'dn'){ //德语站这里不太一样
                $str = 'de';
            }else{
                $str = 'wh';
            }
        }
    }
    return $str;
}

// 2018.7.31 fairy 把仓库code转换成id
function change_warsehouse_code_to_id($warsehouse_code){
    $str = '';
    switch ($warsehouse_code){
        case 'us':$str ='1';break;
        case 'de':$str ='2';break;
        case 'au':$str ='3';break;
        case 'cn':$str ='4';break;
        case 'sg':$str ='5';break;
        case 'ru':$str ='6';break;
    }
    return $str;
}

//2018.10.5 helun 网站左上角免运费板块
function get_free_shipping_herf($lanuages_code = ''){
    if(!$lanuages_code){
        $languages_code = $_SESSION['languages_code'];
    }
    $warsehouse_code = get_country_belong_to_warehouse($_SESSION['languages_code'],$_SESSION['countries_iso_code']);
    if($languages_code == 'fr'){
        if($warsehouse_code == 'de'){
            $free_href = reset_url('shipping_delivery.html');
        }elseif ($warsehouse_code == 'us'){
            $free_href = reset_url('shipping_delivery.html');
        }
    }elseif ($languages_code == 'mx'){
        $free_href = zen_href_link('shipping_delivery');
    }elseif ($languages_code == 'ru'){
        if($warsehouse_code == 'de'){
            $free_href = reset_url('shipping_delivery.html');
        }elseif ($warsehouse_code == 'wh'){
            $free_href = reset_url('shipping_delivery.html');
        }
    }elseif($languages_code == 'au'){
        $free_href = reset_url('shipping_delivery.html');
    }elseif(in_array($languages_code,array('en','uk','sg','de','es'))){
        $free_href = reset_url('shipping_delivery.html');
    }elseif($languages_code == 'jp'){
        $free_href = reset_url('shipping_delivery.html');
    }
    return $free_href;
}


//2018.10.5  ery  网站左上角免运费板块
function get_free_shipping_message(){
	$currency_code = $free_html = $free_cost = '';
	$countries_iso_code = $_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us';
	$countryCode = strtoupper($countries_iso_code);
	if($countryCode=='GB'){
		//英镑版,英国也是欧盟国家，所以判断加在最前面
		$currency_code = 'GBP';
		$free_cost = '£79';
	}elseif(seattle_warehouse('country_code', $countryCode)) {
		//美元版
		$currency_code = 'USD';
		$free_cost = 'USD $79';
		if($countryCode=='MX' && $_SESSION['languages_code']=='mx') $free_cost = 'USD $79/MXN$1,506';
	}elseif (all_german_warehouse('country_code', $countryCode)) {
		//欧元版
		$currency_code = 'EUR';
		$free_cost = '79 €';
	}elseif($countryCode=='AU'){
		//澳元版
		$currency_code = 'AUD';
		$free_cost = 'A$99';
	}

	$policy_bg01 = '';
	if(in_array($currency_code,['USD'])){
		$free_title = HEADER_FREE_SHIPPINH_01;
		$free_h2_1 = sprintf(HEADER_FREE_SHIPPINH_02,$free_cost);
		$free_p_1 = HEADER_FREE_SHIPPINH_03;
		$free_h2_2 = HEADER_FREE_SHIPPINH_04;
		$free_content_1 = HEADER_FREE_SHIPPINH_08;
	}elseif(in_array($currency_code,['GBP','EUR','AUD'])){
		$free_title = HEADER_FREE_SHIPPINH_10;
		$free_h2_1 = sprintf(HEADER_FREE_SHIPPINH_11,$free_cost);
		$free_p_1 = HEADER_FREE_SHIPPINH_12;
		$free_h2_2 = HEADER_FREE_SHIPPINH_13;
		$free_content_1 = HEADER_FREE_SHIPPINH_14;

	}else{
		//国际版
		$policy_bg01 = 'policy_bg01';
		if($countryCode=='NZ'){
			//New Zealand在au站是英式英语
			$free_title = HEADER_FREE_SHIPPINH_10;
			$free_content_1 = HEADER_FREE_SHIPPINH_19;
		}else{
			$free_title = HEADER_FREE_SHIPPINH_01;
			$free_content_1 = HEADER_FREE_SHIPPINH_18;
		}
		$free_h2_1 = HEADER_FREE_SHIPPINH_16;
		$free_p_1 = HEADER_FREE_SHIPPINH_17;
		$free_h2_2 = HEADER_FREE_SHIPPINH_04;
	}
	$free_p_2 = HEADER_FREE_SHIPPINH_05;
	$free_h2_3 = HEADER_FREE_SHIPPINH_06;
	$free_p_3 = HEADER_FREE_SHIPPINH_07;
	$free_content_2 = HEADER_FREE_SHIPPINH_09;

	$other_class = '';
	if(strlen($free_h2_1)>26){$other_class = 'pupop_more';}

	$free_html = '<div class="new_popup policy_window" id="free_shipping_window">
			<div class="new_popup_bg"></div>
			<div class="new_popup_main popup_width680 Policy_window_02 '.$other_class.'">
				<h2 class="new_popup_tit">
					<strong>'.$free_title.'</strong><span onclick="$(\'.policy_window\').hide()" class="icon iconfont"></span>
				</h2>
				<div class="new_popup_content">
					<div class="policy_dl_wap">
						<dl class="policy_dl">
							<dt>
								<span class="policy_bg '.$policy_bg01.'"></span>
							</dt>
							<dd>
								<h2 class="policy_tit">'.$free_h2_1.'</h2>
								<p class="policy_txt">'.$free_p_1.'</p>
							</dd>
						</dl>
						<dl class="policy_dl">
							<dt>
								<span class="policy_bg policy_bg02"></span>
							</dt>
							<dd>
								<h2 class="policy_tit">'.$free_h2_2.'</h2>
								<p class="policy_txt">'.$free_p_2.'</p>
							</dd>
						</dl>
						<dl class="policy_dl">
							<dt>
								<span class="policy_bg policy_bg03"></span>
							</dt>
							<dd>
								<h2 class="policy_tit">'.$free_h2_3.'</h2>
								<p class="policy_txt">'.$free_p_3.'</p>
							</dd>
						</dl>	
					</div>
					<p class="policy_txt02">*'.$free_content_1.'</p>
					<p class="policy_txt03">'.$free_content_2.'</p>
				</div>
			</div>
		</div>';
	return $free_html;
}

function fs_get_site_tag_title(){
	 $languages_code = $_SESSION['languages_code'];
	 switch ($languages_code){
        case 'de': $str = ' - FS Deutschland';break;
        case 'es': $str = ' - FS España';break;
		case 'fr': $str = ' - FS France';break;
        case 'mx': $str = ' - FS México';break;
        case 'uk': $str = ' - FS United Kingdom';break;
        case 'au': $str = ' - FS Australia';break;
        case 'sg': $str = ' - FS Singapore';break;
        case 'jp': $str = ' - FS 日本';break;
        case 'ru': $str = ' - FS Россия';break;
        case 'dn': $str = ' - FS Germany'; break;
        case 'en': $str = ' - FS'; break;
        case 'it': $str = ' - FS Italia'; break;
        default:   $str = ' - FS';break;
    }
	return $str;
}

function fs_new_get_phone($checkout_countrycode=''){
    if($checkout_countrycode){
        $countries_code =strtolower($checkout_countrycode);
    }else{
        $countries_code = $_SESSION['countries_iso_code'];
    }
    $languages_code = $_SESSION['languages_code'];
    //已经存在专线的国家
    $isset_phone =array(
        'us' => FS_PHONE_SITE_US,
        'mx' => FS_PHONE_MX,
        'ca' => FS_PHONE_CA,
        'br' => FS_PHONE_BR,
        'ar' => FS_PHONE_AR,
        'gb' => FS_PHONE_GB,
        'fr' => FS_PHONE_FR,
        'de' => FS_PHONE_DE,
        'nl' => FS_PHONE_NL,
        'es' => FS_PHONE_ES,
        'it' => FS_PHONE_IT,
        'ch' => FS_PHONE_CH,
        'dk' => FS_PHONE_DK,
        'ru' => FS_PHONE_RU,
        'sg' => FS_PHONE_SG,
        'hk' => FS_PHONE_HK,
        'tw' => FS_PHONE_TW,
        'jp' => FS_PHONE_JP,
        'au' => FS_PHONE_AU,
        'nz' => FS_PHONE_NZ,
        'lv' => FS_PHONE_DE,
        'ee' => FS_PHONE_DE,
        'lt' => FS_PHONE_DE,
        'md' => FS_PHONE_DE
    );
    $isset_code =array_keys($isset_phone);
    if(in_array($countries_code,$isset_code)){
        foreach ($isset_phone as $k=>$v){
            if($countries_code == $k){
                $current_phone = $v;
            }
        }
    }else{
        switch ($languages_code){
            case 'en':
            $current_phone =FS_PHONE_SITE_US;
            break;

            case 'au':
                $current_phone =FS_PHONE_AU;
                break;

            case 'sg':
                $current_phone =FS_PHONE_SG;
                break;

            case 'uk':
                $current_phone =FS_PHONE_GB;
                break;

            case 'fr':
                $current_phone =FS_PHONE_FR;
                break;

            case 'ru':
                $current_phone =FS_PHONE_RU;
                break;

            case 'es':
                $current_phone =FS_PHONE_ES;
                break;

            case 'mx':
                $current_phone =FS_PHONE_MX;
                break;

            case 'jp':
                $current_phone =FS_PHONE_JP;
                break;

			case 'dn':
                $current_phone =FS_PHONE_GB;
                break;

            case 'de':
                $current_phone =FS_PHONE_DE;
                break;

            case 'it':
                $current_phone =FS_PHONE_GB;
                break;

            default:
                $current_phone =FS_PHONE_US;
                if(US_WAREHOUSE_UP){
                    $current_phone = FS_PHONE_US_EAST;
                }
                break;

        }
    }
    if($countries_code == "us" && US_WAREHOUSE_UP){
        $current_phone = FS_PHONE_US_EAST;
    }
    return $current_phone;

}

function fs_get_warehouse_phone($checkout_countrycode){
    if($checkout_countrycode){
        $countries_code =strtolower($checkout_countrycode);
    }else{
        $countries_code = $_SESSION['countries_iso_code'];
    }
    if (in_array($countries_code,['lv','ee','lt','md'])){
        return true;
    }else{
        return false;
    }
}

function printShopingCartOrEmail($type = '')
{
    $cartFun = function ($type) {
        if (empty($type)) {
            $temp = '<a class="print_button" data-type="cart" onclick="open_view_window(this)" href="javascript:void(0);">'.FS_QUOTE_INQUIRY_17.'</a>';
        } else {
            $lists_str =substr($_SESSION['user_save_cart'][$type], 0, -1);
            $href = zen_href_link(FILENAME_PRINT_SHOPPING_LIST,'&type=1&list='.$lists_str.'&saveId='.$type);
            $temp = '<a class="print_button" href="'. $href .'">'.FS_QUOTE_INQUIRY_17.'</a>';
        }

        $html = '';
        $html = '<div class="bubble-popover-wap">';
        $html .= '<div class="m-bubble-bg" style="display: none;"></div>';
        $html .= '<div class="bubble-popover">';
        $html .= '<span class="iconfont icon bubble-icon">&#xf100;</span>';
        $html .= '<div class="m-bubble-container">';
        $html .= '<div class="bubble-frame right-top">';
        $html .= '<a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:void(0);">';
        $html .= '<i class="iconfont icon"></i>';
        $html .= '</a>';
        $html .= '<div class="bubble-arrow"></div>';
        $html .= '<div class="bubble-content">';
        $html .= '<span class="print_button_container">';
        $html .= $temp;
        $html .= '</span>';
        $html .= '<span class="print_button_container">';
        $html .= '<a class="print_button" data-type="inquiry" onclick="open_view_window(this)" href="javascript:void(0);">'.FS_QUOTE_INQUIRY_18.'</a>';
        $html .= '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    };

    $class = 'print-box-pc';
    $print = $cartFun($type);

    $email = '<a href="javascript:void(0)" title="'.FS_SHOP_CART_ALERT_JS_73.'" onclick="$(\'#share_cart,#share_cart_main\').show();">';
    if ($type != '') {
        $email = '<a href="javascript:void(0)" title="' . FS_SHOP_CART_ALERT_JS_73 . '" onclick="open_email_windows(' . $type . ')">';
    }

    if(isMobile()){
        $print = '';
        $class = 'print-box-m';
    }

    $html = '<div class="shopcart-type-print-box '.$class.'">
                <div class="shopcart-type-print-main after">
                    '.$email.' 
                    <div class="iconfont icon">&#xf130;</div></a>
                       '.$print.'
                </div>
            </div>';

    return $html;
}

//2019.9.2 Jeremy  购物车打印和邮箱按钮
function get_email_print_icon_html($type=''){
    $class = 'print-box-pc';
    if(isMobile()){
        $class = 'print-box-m';
    }
    $print = '<a href="javascript:void(0)" title="'.FS_SHOP_CART_ALERT_JS_74.'" onclick="open_view_window(this)">
                    <div class="iconfont icon">&#xf100;</div>
              </a>';
    $email = '<a href="javascript:void(0)" title="'.FS_SHOP_CART_ALERT_JS_73.'" onclick="$(\'#share_cart,#share_cart_main\').show();">';
    if($type != ''){
        $lists_str =substr($_SESSION['user_save_cart'][$type], 0, -1);
        $print = '<a target="_blank" title="'.FS_SHOP_CART_ALERT_JS_74.'" href="'.zen_href_link(FILENAME_PRINT_SHOPPING_LIST,'&type=1&list='.$lists_str.'&saveId='.$type).'">
                    <div class="iconfont icon">&#xf100;</div>
                  </a>';
        $email = '<a href="javascript:void(0)" title="'.FS_SHOP_CART_ALERT_JS_73.'" onclick="open_email_windows('.$type.')">';
    }
    if(isMobile()){
        $print = '';
    }
    $html = '<div class="shopcart-type-print-box '.$class.'">
                <div class="shopcart-type-print-main after">
                    '.$email.'
                        <div class="iconfont icon">&#xf130;</div>
                       '.$print.'
                    </a>
                </div>
            </div>';
    return $html;
}
//2019.9.2 Jeremy  购物车页添加产品
function get_add_product_html($items=0){
    $icon_html = '';
    $html = '';
    if($items > 0 && !isMobile()){
        $icon_html = get_email_print_icon_html();
    }
    /*
    $html = '<div class="shopcart-type-wrap shopcart-type-itemMbt">
                        <div class="shopcart-type-itemBox after">
                            <div class="shopcart-type-idLeft">
                                <div class="after">
                                    <input class="shopcart-type-idInput big_input" placeholder="'.FS_INQUIRY_INFO_54.'" type="text" id="product_id" onkeyup="submit_id(this)" maxlength="5"/>
                                    <div class="cart_basket_btn">
                                    <input type="text" value="1" id="product_num"  onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="enterKey(this)" class="shopping_cart_01" autocomplete="off" min="1" placeholder="" onblur="check_product_num(2,this);">
                                        <div class="pro_mun">
                                            <a href="javascript:void(0);" onclick="add_cart_change(this,1)" class="shopping_add"></a>
                                            <a href="javascript:void(0);" onclick="add_cart_change(this,0)" class="cart_reduce shopping_minus choosez"></a>
                                        </div>
                                    </div>
                                    <div class="shopcart-type-addCart-btnBox">
                                        <button class="shopcart-type-addCart-btn fs-comSub-loadBtn" onclick="add_cart_product()">
                                            <div class="fs-comSub-loadBtn_txt"><span class="iconfont icon">&#xf057;</span>'.PRODUCT_INFO_ADD.'</div>
                                            <div class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></svg></div>
                                        </button>
                                    </div>
                                </div>
                                <div class="shopcart-type-error-txt after" style="display: none;"></div>
                            </div>
                            '.$icon_html.'
                        </div>
                    </div>';
    */
    if($items > 0){
        return $html;
    }else{
        return '<div class="cart_no_title">
                    <div class="cart-title-lg">
                        '.FILENAME_HOME_CART.'
                    </div>
                    '.$html.'
                </div>';
    }
}
//2019.9.2 Jeremy  购物车列表标题
function get_cart_list_html(){
    $price = $_SESSION['languages_code'] == 'de' ? FS_WAREHOUSE_AREA_9 : FS_WAREHOUSE_AREA_11;
    $html = '<dd class="shipment-shopcart-list new-cart-list-title">
                <div class="shipment-shopcart-list-box new-shopcart-tablePc after shopping_cart_pro_con">
					<div class="new-shopcart-tableBox-parent">
						<div class="new-shopcart-boxz01 new-shopcart-tableBox">
							<div class="shopcart-products-pic">
								<div class="new-shopcart-tableHe-txt">'.FS_WAREHOUSE_AREA_8.'</div>
							</div>
							<div class="shopcart-products-info"></div>
							<div class="shopcart-products-quantity">
								<div class="new-shopcart-tableHe-txt">'.FS_INQUIRY_INFO_45.'</div>
							</div>
							<div class="shopcart-products-panel">
								<div class="new-shopcart-tableHe-txt">'.$price.'</div>
							</div>
						</div>
					</div>
                </div>
            </dd>';
    return $html;
}

//新版购物车列表结构
function get_cart_products_list_html($product,$type=''){
    global  $currencies;
    $decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
    $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
    $cart_html = '';
    $product_category_status = $product['show_type'];
    if($type == 'add_to_save'){
        $image = '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="120" height="120">';
        if(!$product_category_status) {
            $cart_html .= '<div class="new-shopcart-boxz01 new-shopcart-tableBox"><div class="shopcart-products-pic"><a href="' . $product['link'] . '">' . $image . '</a></div>';
            $cart_html .= '<div class="shopcart-products-info"> <a class="shopcart-products-name" href="' . $product['link'] . '">' . $product['productsName'] . '</a>';
        }else{
            $cart_html .= '<div class="new-shopcart-boxz01 new-shopcart-tableBox"><div class="shopcart-products-pic">' . $image . '</div>';
            $cart_html .= '<div class="shopcart-products-info">' . $product['productsName'] . '';
        }
    }else{
        $cart_html .= '<div class="new-shopcart-tableBox-parent"><div class="new-shopcart-boxz01 new-shopcart-tableBox">';
        //左边图片展示板块
        $cart_html .= '<div class="shopcart-products-pic">';
        $cart_html .= '<span class="shipment-shopcart-checkpro-eachicbox '.($product["is_checked"] ? 'choosez' : '').'" onclick="shipcart_checkeachPro(this)">
                            <i class="iconfont shipment-shopcart-checkpro-eachic">'.($product["is_checked"] ? '&#xf431;' : '&#xf022;').'</i>
                        </span>';
        if(!$product_category_status){
            $cart_html .= '<a href="'.$product['link'].'">'.$product['resourceImage'].'</a>';
        }else{
            $cart_html .= '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="120" height="120">';
        }
        $cart_html .= '</div>';

        $cart_html .= '<div class="shopcart-products-info">';
    }
    //中间产品标题及库存等
    if($product_category_status==1){
        $cart_html .= $product['productsName'];
    }else{
        $cart_html .= '<a class="shopcart-products-name" href="'.$product['link'].'">'.$product['productsName'].'</a>';
    }
    $cart_html .= '<div><span class="product_modelid_txt">FS P/N: '.$product['productsModel'].'   <span class="product_sku"><span>&nbsp;#'.(int)$product['id'].'</span></span></span></div>';
    //$cart_html .= $product['attributeHiddenField'];
    $Length = '';
    if (isset($product['attributes']) && is_array($product['attributes'])) {
        $cart_html .= '<div class="cartAttribsList"><ul>';
        foreach ($product['attributes'] as $option => $value) {
            if($option == 'length'){
                $Length = trim($value['length']);
                $cart_html .= '<li>'.FS_LENGTH_NAME.' - '. zen_show_product_length($Length,(int)$product['id']).'</li>';
            }else{
                $cart_html .= '<li>'.$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']).'</li>';
            }
        }
        $cart_html .= '</ul></div>';
    }

    //组合子产品start
    $attr_str = '';
    if($product['attr_str']){
        $attr_str = reorder_options_values($product['attr_str']);
    }
    if (!isMobile()) { //pc端子产品展示
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts(intval($product['id']),'',$attr_str);
            $composite_son_product_arr = $CompositeProducts->show_products_composite($product['quantity'],0,'');
            if($composite_son_product_arr){
                $cart_html .= '<div class="shopcart_newPro_box01 shopcart-products-demPc">
                                <p class="shopcart_newOrder_item01" onclick="_theSlide($(this))">
                                    '.FS_ITEM_INCLUDES_PRODUCTS.'<span class="iconfont icon"></span>
                                </p>
                                <div class="shopcart_newPro_main01 choosez">';
                foreach ($composite_son_product_arr as $composite_son_product_key => $composite_son_product_val ){
                    $cart_html .= '<div class="shopcart_newPro_cont01">
                                 <div class="shopcart_newPro_imgBox01">'.$composite_son_product_val['products_image_str'].'</div>
                                 <div class="shopcart_newPro_itemBox01"><p class="shopcart_newOrder_txt">'.$composite_son_product_val['products_name'].'</p>
                                 <p class="shopcart_newOrder_txt01 composite_son_product composite_product_'.$composite_son_product_val['products_id'].'">
                                 <em style="display:none;">'.$composite_son_product_val['one_product_corr_number'].'</em>
                                 <span>'.(in_array($product['id'], [108704, 10706]) ? MANAGE_ORDER_QTY.' : ' : '').$composite_son_product_val['buy_number'].'</span>';
                    //XQ20201114001 AP组合产品子ID价格隐藏 ery 2020.11.14
                    if(!in_array($product['id'],[108704,108706])){
                        $cart_html .= 'x <span>'.$composite_son_product_val['products_price_str'].'</span>'.FS_PRODUCT_PRICE_EA;
                    }
                    $cart_html .='</p></div></div>';
                }
                $cart_html .= '</div></div>';
            }
        }
    }
    //组合子产品end

    //库存数量以及交期
    $clearance_qty = $product['clearance_qty'] ? $product['clearance_qty'] : 0;
    $clearance_html = '';
    $choosez = '';
    if($product['is_clearance']==1){
        if($product['quantity'] >= $clearance_qty){
            $choosez .= ' choosez';
        }
        $clearance_html .= zen_draw_hidden_field("is_clearance",$product['is_clearance']);
        $clearance_html .= zen_draw_hidden_field("clearance_qty",$clearance_qty);
    }
	$attr_imp = $product['instockAttr'] ? implode(',',$product['instockAttr']) : '';
    $cart_html .= '<div class="shopping_cart_sku"><span class="products_in_stock"></span>
                            '.$product['instockHtml'].'
                            <input type="hidden" name="attr_arr_'.$product['id'].'" value="'.$attr_imp.'">
                            <input type="hidden" name="attr_length_'.$product['id'].'" value="'.$Length.'"></div>';
    //加购产品展示账户中心来源订单号板块
    if($product['orders_number']){
        $orderTitle = sprintf(FS_BUY_MORE_03, '<a href="'.reset_url('/index.php?main_page=manage_orders&search='.$product['orders_number']).'" target="_blank">#'.$product['orders_number'].'</a>');
        $cart_html .= '<div class="shopping_cart_tips_conta"><i class="iconfont icon">&#xf228;</i> '.$orderTitle.'</div>';
    }
    /*if(!$product_category_status){
        require_once DIR_WS_CLASSES.'fs_reviews.php';
        $fs_reviews =new fs_reviews();
        $cart_html .= '<div class="shopcart-products-reviews after">'.$fs_reviews->get_product_list_review_show((int)$product['id']).'</div>';
    }*/
    $quote_type = 0;
    if (isset($product['reoder_type']) && $product['reoder_type'] == 'quotation' && $product['price']<$product['products_price']){
        $quote_type = 1;
    }
    //save for later 和remove 板块
    $add_btn = '<a href="javascript:;" class="shopping_cp_cell_save" value="'.$product['id'].'" onclick="add_to_save(\''.$product['id'].'\',this)">'.FS_SHOP_CART_SAVE.'</a>';
    $remove_btn = '<a href="javascript:;" class="shopcart-remove shopping_cp_cell_remove"  name="products[]" value="'.$product['id'].'">
                        <i class="icon iconfont">&#xf027;</i>
                        <input type="hidden" name="quote_type" value="'.$quote_type.'">
                        <span>'.FS_REMOVED.'</span>
                    </a>';
    if($type == 'move'){
        $add_btn = '<a class="shopping_cp_cell_move" value="'.$product['id'].'" onclick="add_to_cart(\''.$product['id'].'\',this)" href="javascript:void(0);">'.FS_SHOP_CART_MOVE.'</a>';
        $remove_btn = '<a name="products[]" value="'.$product['id'].'" href="javascript:;" class="shopcart-remove save_for_late_remove" >
                            <i class="icon iconfont">&#xf027;</i>
                            <span>'.FS_REMOVED.'</span>
                        </a>';
    }
    //暂时屏蔽 save for later
//    $cart_html .= '<div class="shopcart-products-panel-op shopcart-products-demPc">'.$add_btn.$remove_btn.'</div>';
    $cart_html .= '</div>';


    if(false) {//暂时屏蔽单价板块
        //产品单价板块
        $cart_html .= '<div class="shopcart-products-pricez shopcart-products-demPc">';
        $before_discount = $currencies->display_price_rate(zen_round(($product['products_price'] * $currency_value), $currencies->currencies[$_SESSION['currency']]['decimal_places'], 2), 0, 1);
        if ($type != 'move' && $_SESSION['member_level'] == 2 && $product['products_price_total'] != "0.00") {
            if ($product['reoder_type'] != 'quotation' && $before_discount != $product['productsPriceEach']) {
                $cart_html .= '<p class="before-discount-price">' . $before_discount . '</p>';
            }
        }
        if ($quote_type == 1) {
            $reoder_info_length = count($product['reoder_info']);
            if ($product['quantity'] >= $product['reoder_info'][$reoder_info_length - 1]['products_quantity']) {
                $cart_html .= '<span class="icon iconfont shopping_NDiscountIcon">&#xf217;</span>';
            } else {
                $cart_html .= '<span class="icon iconfont shopping_NDiscountIcon" style="display:none">&#xf217;</span>';
            }
        } else {
            $cart_html .= '<span class="icon iconfont shopping_NDiscountIcon" style="display:none">&#xf217;</span>';
        }

        if ($type != 'move' && ($_SESSION['member_level'] > 1 || $product['reoder_type']) && $currencies->display_price_rate(zen_round(($product['products_price'] * $currency_value), $decimal), 0, 1) != $product['productsPriceEach']) {
            $cart_html .= '<span class="shopcart-products-pricez-txt originalPrice_' . $product['id'] . '">' . $currencies->display_price_rate(zen_round(($product['price'] * $currency_value), $decimal), 0, 1) . '</span><br/>
                                <input type="hidden" class="ws_price" value="' . zen_round(($product['products_price'] * $currency_value), $decimal) . '">';
        } else {
            $cart_html .= '<span class="shopcart-products-pricez-txt originalPrice_' . $product['id'] . '">' . $before_discount . '</span>';
        }
        $cart_html .= '</div>';
        //单价板块结束
    }
    //库存板块
    /*
    $cart_html .= '<div class="shopcart-products-quantity shopcart-products-demPc">
                                            <input type="hidden" class="shopping_price  shopping_price_'.$product['id'].'"   value="'.zen_round(($product['price']*$currency_value),$decimal).'">
                                            <input type="hidden" class="shopping_price_us shopping_price_us_'.$product['id'].'"  value="'.zen_round($product['price'],$currencies->currencies['USD']['decimal_places']).'">
                                            <input type="hidden" class="shopping_weight "  value="'.$product['pure_weight'].'">
                                            <input type="hidden" class="original_price original_price_'.$product['id'].'"  value="'.zen_round(($product['products_price']*$currency_value),$decimal).'">';
    $number_class ='shopcart-products-panel-count after reset_shopcart_btn_'.$product['id'].'';
    if($product_category_status==1){
        $number_class="shopcart-products-panel-count prevent after";
    }
    $cart_html .= '<div class="'.$number_class.'"><div class="cart_basket_btn">';
    $cart_html .= $clearance_html;
    if($type == 'move'){
        $cart_html .= '<input type="hidden" name="product_min_qty">';
        $cart_html .= '<input type="hidden" name="products_id[]" value="'.$product["id"].'">';
        if (isset($product['products_clearance_tips']) && $product['products_clearance_tips']) {
            $cart_html .= '<input data-replace-products-tip="'.$product['products_clearance_tips']['replace_products_tip'].'" data-replace-products-id="'.$product['products_clearance_tips']['replace_products_id'].'" type="text" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
        } else {
            $cart_html .= '<input type="text" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
        }
    }else{
        $cart_html .= $product['quantityField'];
    }
    $class = '';
    if($product['quantity'] == 1){
        $class = 'choosez';
    }
    if ($product_category_status==1){
        $cart_html .= '<div class="pro_mun">
                                            <a href="javascript:void(0);" class="shopping_add"></a>
                                            <a href="javascript:void(0);" class="cart_reduce shopping_minus '.$class.'"></a>
                                        </div>';
    }else{
        if($type == 'move'){

            $cart_html .= '<div class="pro_mun">
                                <a href="javascript:void(0);" onclick="save_list_cart_change(\'1\',\''.$product['id'].'\',this)" class="shopping_add cart_qty_add '.$choosez.'"></a>
                                <a href="javascript:void(0);" onclick="save_list_cart_change(\'0\',\''.$product['id'].'\',this)" class="cart_reduce shopping_minus '.$class.'"></a>
                                </div>';
        }else{
            $cart_html .= '<div class="pro_mun">
                                <a href="javascript:void(0);" onclick="list_cart_change(\'1\',\''.$product['id'].'\',this)" class="shopping_add cart_qty_add '.$choosez.'"></a>
                                <a href="javascript:void(0);" onclick="list_cart_change(\'0\',\''.$product['id'].'\',this)" class="cart_reduce shopping_minus '.$class.'"></a>
                                </div>';
        }
    }
    $cart_html .= '<a class="remove_cart" href="'.zen_href_link(FILENAME_SHOPPING_CART,'&action=remove_product&product_id='.$product['id']).'"><i></i></a></div></div></div>';
    */



    //产品单价板块
    $cart_html .= '<div class="shopcart-products-panel">';
    $cart_html .= '<div class="shopcart-products-panel-pay shopcart-products-panel-count">';
    $before_discount = $currencies->display_price_rate(zen_round(($product['products_price'] * $currency_value), $currencies->currencies[$_SESSION['currency']]['decimal_places'], 2), 0, 1);
    if ($type != 'move' && $_SESSION['member_level'] == 2 && $product['products_price_total'] != "0.00") {
        if ($product['reoder_type'] != 'quotation' && $before_discount != $product['productsPriceEach']) {
            $cart_html .= '<p class="shopcart-products-panel-oldprice">' . $before_discount . '<span class="shopcart-products-panel-priceline"></span></p><br>';
        }
    }
    if ($quote_type == 1) {
        $reoder_info_length = count($product['reoder_info']);
        if ($product['quantity'] >= $product['reoder_info'][$reoder_info_length - 1]['products_quantity']) {
            $cart_html .= '<span class="icon iconfont shopping_NDiscountIcon">&#xf217;</span>';
        } else {
            $cart_html .= '<span class="icon iconfont shopping_NDiscountIcon" style="display:none">&#xf217;</span>';
        }
    } else {
        $cart_html .= '<span class="icon iconfont shopping_NDiscountIcon" style="display:none">&#xf217;</span>';
    }

    if ($type != 'move' && ($_SESSION['member_level'] > 1 || $product['reoder_type']) && $currencies->display_price_rate(zen_round(($product['products_price'] * $currency_value), $decimal), 0, 1) != $product['productsPriceEach']) {
        $cart_html .= '<span class="shopcart-products-pricez-txt originalPrice_' . $product['id'] . '">' . $currencies->display_price_rate(zen_round(($product['price'] * $currency_value), $decimal), 0, 1) . '</span><br/>
                    <input type="hidden" class="ws_price" value="' . zen_round(($product['products_price'] * $currency_value), $decimal) . '">';
    } else {
        $cart_html .= '<span class="shopcart-products-pricez-txt originalPrice_' . $product['id'] . '">' . $before_discount . '</span><br>';
    }
    if($product['is_gsp_vat']){
        $cart_html .= get_gsp_detail_html().'<br>';
    }
    $cart_html .= '<input type="hidden" class="shopping_price  shopping_price_'.$product['id'].'"   value="'.zen_round(($product['price']*$currency_value),$decimal).'">
                   <input type="hidden" class="shopping_price_us shopping_price_us_'.$product['id'].'"  value="'.zen_round($product['price'],$currencies->currencies['USD']['decimal_places']).'">
                   <input type="hidden" class="shopping_weight "  value="'.$product['pure_weight'].'">
                   <input type="hidden" class="original_price original_price_'.$product['id'].'"  value="'.zen_round(($product['products_price']*$currency_value),$decimal).'">';
    $number_class ='shopcart-products-panel-count after reset_shopcart_btn_'.$product['id'].'';
    if($product_category_status==1){
        $number_class="shopcart-products-panel-count prevent after";
    }
    $cart_html .= '<div class="'.$number_class.'"><div class="cart_basket_btn newDetail_addCart_box">';
    $cart_html .= $clearance_html;
    if($type == 'move'){
        $cart_html .= '<input type="hidden" name="product_min_qty">';
        $cart_html .= '<input type="hidden" name="products_id[]" value="'.$product["id"].'">';
        if (isset($product['products_clearance_tips']) && $product['products_clearance_tips']) {
            $cart_html .= '<input data-replace-products-tip="'.$product['products_clearance_tips']['replace_products_tip'].'" data-replace-products-id="'.$product['products_clearance_tips']['replace_products_id'].'" type="text" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
        } else {
            $cart_html .= '<input type="text" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
        }
    }else{
        $cart_html .= $product['quantityField'];
    }
    $class = '';
    if($product['quantity'] == 1){
        $class = 'choosez';
    }
    if ($product_category_status==1){
        $cart_html .= '<div class="pro_mun">
                                            <a href="javascript:void(0);" class="cart_qty_add"><i class="iconfont icon">&#xf088;</i></a>
                                            <a href="javascript:void(0);" class="cart_qty_reduce '.$class.'"><i class="iconfont icon">&#xf087;</i></a>
                                        </div>';
    }else{
        if($type == 'move'){

            $cart_html .= '<div class="pro_mun">
                                <a href="javascript:void(0);" onclick="save_list_cart_change(\'1\',\''.$product['id'].'\',this)" class="cart_qty_add '.$choosez.'"><i class="iconfont icon">&#xf088;</i></a>
                                <a href="javascript:void(0);" onclick="save_list_cart_change(\'0\',\''.$product['id'].'\',this)" class="cart_qty_reduce '.$class.'"><i class="iconfont icon">&#xf087;</i></a>
                                </div>';
        }else{
            $cart_html .= '<div class="pro_mun">
                                <a href="javascript:void(0);" onclick="list_cart_change(\'1\',\''.$product['id'].'\',this)" class="cart_qty_add '.$choosez.'"><i class="iconfont icon">&#xf088;</i></a>
                                <a href="javascript:void(0);" onclick="list_cart_change(\'0\',\''.$product['id'].'\',this)" class="cart_qty_reduce '.$class.'"><i class="iconfont icon">&#xf087;</i></a>
                                </div>';
        }
    }
    $cart_html .= '<a class="remove_cart" href="'.zen_href_link(FILENAME_SHOPPING_CART,'&action=remove_product&product_id='.$product['id']).'"><i></i></a></div></div>';

    if (!isMobile()) { //pc
        if($type == 'move'){
            $cart_html .= '<div class="iconfont shipment-shopcart-newdeleteIc shopping_cp_cell_remove" value="'.$product['id'].'">&#xf027;</div>';
        }else{
            $cart_html .= '<div class="iconfont shipment-shopcart-newdeleteIc shopping_cp_cell_remove" value="'.$product['id'].'">&#xf027;</div>';
            $cart_html .= '<input type="hidden" name="quote_type" value="'.$quote_type.'">';
        }
    }


    $cart_html .= '</div></div>';

    /* M端结构 */
    $cart_html .= '<div class="shopcart-products-demM">
                                                <div class="shopcart-products-playTa">
                                                    <div class="shopcart-products-playTd">
                                                        <div class="shopcart-products-panel-pay panel-pay-m shopcart-products-panel-count">
                                                        <span class="originalPrice originalPrice_'.$product['id'].'">'.$currencies->display_price_rate(zen_round(($product['price'] * $currency_value), $decimal), 0, 1).'</span><br>';
    if($product['is_gsp_vat']){//M端GSP结构
        $cart_html .= '<div class="fs-gspType-tipsBox">
                            <div class="fs-gspType-tipsWrap">
                                <p class="fs-gspType-tipsTxt01">'.FS_COMMON_GSP_2.'</p>
                                <div class="fs-gspType-tipsTxt02">'.FS_COMMON_GSP_3.'<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                                        <div class="question_bg_icon question_bg_grayIcon iconfont icon"></div>
                                        <div class="new_m_bg1" style="display: none;"></div>
                                        <div class="new_m_bg_wap" style="display: none;">
                                            <div class="question_text_01 leftjt">
												<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                                                <div class="arrow"></div>
                                                <div class="popover-content">
                                                   '.FS_COMMON_GSP_4.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>';
    }
    $cart_html .= '</div></div></div>';

    $cart_html .= '<div class="shopcart-products-playTa"><div class="shopcart-products-playTd"><div class="shopcart-products-panel-op">';
    //$cart_html .= '<a href="javascript:;" class="shopping_cp_cell_save" value="'.$product['id'].'" onclick="add_to_save(\''.$product['id'].'\',this)">'.FS_SHOP_CART_SAVE.'</a><a href="javascript:;" class="shopcart-remove shopping_cp_cell_remove"  name="products[]" value="'.$product['id'].'">';
    $cart_html .= $add_btn.$remove_btn.'</div></div>';
    //$cart_html .=;
    if($type == 'move'){
        $quantityField_m = '<input type="hidden" name="product_min_qty">';
        $quantityField_m .= '<input type="hidden" name="products_id[]" value="'.$product["id"].'">';
        if (isset($product['products_clearance_tips']) && $product['products_clearance_tips']) {
            $quantityField_m .= '<input data-replace-products-tip="'.$product['products_clearance_tips']['replace_products_tip'].'" data-replace-products-id="'.$product['products_clearance_tips']['replace_products_id'].'" type="text" class="shopcart-type-idInput big_input" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
        } else {
            $quantityField_m .= '<input type="text" class="shopcart-type-idInput big_input" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
        }
    }else{
        $quantityField_m = str_replace('input','input class="shopcart-type-idInput big_input"',$product['quantityField']);
    }
    $cart_html .= '<div class="shopcart-products-playTd">'.$clearance_html.$quantityField_m.'</div></div></div>';
    $cart_html .= '</div>';
    if (isMobile()) { //m端
        if($type == 'move'){
            $cart_html .= '<div class="iconfont shipment-shopcart-newdeleteIc shopping_cp_cell_remove" value="'.$product['id'].'">&#xf027;</div>';
        }else{
            $cart_html .= '<div class="iconfont shipment-shopcart-newdeleteIc shopping_cp_cell_remove" value="'.$product['id'].'">&#xf027;</div>';
            $cart_html .= '<input type="hidden" name="quote_type" value="'.$quote_type.'">';
        }
    }
    $cart_html .= '</div>';

    if (isMobile()) { //M端子产品展示
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts(intval($product['id']),'',$attr_str);
            $composite_son_product_arr = $CompositeProducts->show_products_composite($product['quantity'],0,'');
            if($composite_son_product_arr){
                $cart_html .= '<div class="shopcart_newPro_box01 shopcart-products-demM">
                                <p class="shopcart_newOrder_item01" onclick="_theSlide($(this))">
                                    '.FS_ITEM_INCLUDES_PRODUCTS.'<span class="iconfont icon"></span>
                                </p>
                                <div class="shopcart_newPro_main01 choosez">';
                foreach ($composite_son_product_arr as $composite_son_product_key => $composite_son_product_val ){
                    $cart_html .= '<div class="shopcart_newPro_cont01">
                                 <div class="shopcart_newPro_imgBox01">'.$composite_son_product_val['products_image_str'].'</div>
                                 <div class="shopcart_newPro_itemBox01"><p class="shopcart_newOrder_txt">'.$composite_son_product_val['products_name'].'</p>
                                 <p class="shopcart_newOrder_txt01 composite_son_product composite_product_'.$composite_son_product_val['products_id'].'">
                                 <em style="display:none;">'.$composite_son_product_val['one_product_corr_number'].'</em>
                                 <span>'.(in_array($product['id'], [108704, 10706]) ? MANAGE_ORDER_QTY.' : ' : '').$composite_son_product_val['buy_number'].'</span>';
                    //XQ20201114001 AP组合产品子ID价格隐藏 ery 2020.11.14
                    if(!in_array($product['id'],[108704,108706])){
                        $cart_html .= 'x <span>'.$composite_son_product_val['products_price_str'].'</span>'.FS_PRODUCT_PRICE_EA;
                    }
                    $cart_html .='</p></div></div>';
                }
                $cart_html .= '</div></div>';
            }
        }
    }

    return $cart_html;
}

//获取公司名称
function get_company_name(){
    $company_name = '';
    switch ($_SESSION['languages_code']){
        case 'sg':
            $company_name = ' '.FS_SG_COMPANY_NAME.' ';
            break;

        case 'jp':
            $company_name = ' '.FS_CN_COMPANY_NAME.' ';
            break;

        case 'de':
        case 'dn':
        case 'es':
        $company_name = ' '.FS_DE_COMPANY_NAME.' ';
            break;

        case 'en':
        case 'mx':
            if(seattle_warehouse('country_code',$_SESSION['countries_iso_code'])){
                $company_name = ' '.FS_US_COMPANY_NAME.' ';
            }else{
                $company_name = ' '.FS_CN_COMPANY_NAME.' ';
            }
            break;

        case 'fr':
        case 'ru':
            if(all_german_warehouse('country_code',$_SESSION['countries_iso_code'])) {
                $company_name = ' '.FS_DE_COMPANY_NAME.' ';
            }elseif(seattle_warehouse('country_code',$_SESSION['countries_iso_code'])) {
                $company_name = ' '.FS_US_COMPANY_NAME.' ';
            }else{
                $company_name = ' '.FS_RU_COMPANY_NAME.' ';
            }
            break;

        default:
            $company_name = ' '.FS_LOCAL_COMPANY_NAME.' ';
            break;
    }
    return $company_name;
}

