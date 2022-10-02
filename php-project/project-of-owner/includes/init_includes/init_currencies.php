<?php
/**
 * initialise currencies
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_currencies.php 6300 2007-05-11 15:49:41Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

//include("geoip.inc");
// 引入 PHP ip库文件
//require_once 'vendor/autoload.php';
use GeoIp2\Database\Reader;

// This creates the Reader object, which should be reused across
// lookups.
// 打开本地数据库, 数据保存在 GeoLite2-City.mmdb 文件中.
//$geoData = geoip_open('GeoIP.dat', GEOIP_STANDARD);
$reader = new Reader('GeoLite2-City.mmdb');
$country_input = $_GET['country'] ? strval(strip_tags($_GET['country'])) : null;
$isMainPage = ($_GET['main_page']=='index' || ($_GET['main_page']=='verify' && empty($_GET['code']))) && empty($_GET['cPath']) ? true : false;
if (!empty($country_input)) {
    $_SESSION['countryTagConfig'] = $country_input;
    setcookie('countryTagConfig', $country_input, time() + 86400 * 1, "/");
}
/**
 * add by aron 2020.10.5
 * 中文站访问标示，当该标示不存在时中国ip 自动跳转中文站
 */
$countryTagConfig = $_SESSION['countryTagConfig'] ? $_SESSION['countryTagConfig'] :
    ($_COOKIE['countryTagConfig'] ? strval(strip_tags($_COOKIE['countryTagConfig'])) : null);
try{
    //$customerIP = $_GET['testIP'] ? strval($_GET['testIP']) : getCustomersIP();
    $record = @$reader->city(getCustomersIP());
}catch(Exception $e){
    $ipCountryCode = 'us';
    //获取国家 名称
    $ipCountryName = "";
    //获取城市
    $ipCity = "";
    //获取邮编
    $ipPostal = "";
    $_SESSION['user_ip_info'] = array(
        "ipCountryCode" => $ipCountryCode,
        "ipCountryName" => $ipCountryName,
        "ipCity" => $ipCity,
        "ipPostal" => $ipPostal,
        "ipCode" => 'us',
        "ipTimeZone" => 'America/Los_Angeles'
    );
}

if(!empty($record)){
    // 获取国家 code
    $ipCountryCode = $record->country->isoCode ? $record->country->isoCode : 'us';
//获取国家 名称
    $ipCountryName = $record->country->name ? $record->country->name : "";
//获取城市
    $ipCity = $record->city->name ? $record->city->name : "";
//获取邮编
    $ipPostal = $record->postal->code ? $record->postal->code : "";
    $_SESSION['user_ip_info'] = array(
        "ipCountryCode" => $ipCountryCode,
        "ipCountryName" => $ipCountryName,
        "ipCity" => $ipCity,
        "ipPostal" => $ipPostal,
        "ipCode" => $record->country->isoCode ? $record->country->isoCode : 'us',
        "ipTimeZone" => $record->location->timeZone ? $record->location->timeZone : 'America/Los_Angeles',
    );
}
@$reader->close();

// 2019-8-28 potato 人机验证码语言切换
$language_code_verify = strtolower($ipCountryCode);
$language_recaptcha = [
    'cn' => 'en',
    'fr' => 'fr',
    'de' => 'de',
    'jp' => 'ja',
    'es' => 'es',
    'ru' => 'ru',
];
$language_google_code = isset($language_recaptcha[$language_code_verify]) ? $language_recaptcha[$language_code_verify] : 'en';

require_once DIR_WS_CLASSES .'set_cookie.php';
$Encryption = new Encryption;

//受限制的国家IP
$limit_Countryarr=array('CU','IR','KP','SD','SY','IQ','LY','BY','CF','LB','SO','VE','YE','ZW','NI');
//各个站点自适应的国家
$Is_NewLand =false;
$au_Countryarr =array("AU",'NZ');
$sg_Countryarr =array('SG','KH','LA','MY','TL','ID','BN','MM','PH','TH','VN');
$de_Countryarr =array('DE','CH','LU','AT','LI');
$fr_Countryarr =array('FR','MC','GF','GP','MQ','YT', 'BL', 'MF');
$mx_Countryarr =array('MX','AR','CL','PE','PA','PE','CO','GT','HN','JM','VE','UY','BO','DO','EC','PY','NI','GQ','CR','DM','SV');
$ru_Countryarr =array('RU','UA','BY','MD','KZ','KG','UZ','TJ','TM','AZ','GE','AM','LV');
$es_Countryarr =array("ES","IC");
$de_en_Countryarr =array("NL","DK","IE","GR","PT","SE","FI","MT","CY","PL","HU","CZ","SK","SI","RO","BG","HR","IS","BA","RS","ME","MK","AL","NO","AD","SM","FO","GL","AW","LT",'EE','BE','VA');
$uk_Countryarr =array("GB","GG","IM","JE");
$it_Countryarr = array("IT");
$cn_Countryarr = ['CN', 'TW', 'HK', 'MO'];

$sCountryCode = 'countries_iso_code_'.trim($_SESSION['languages_code']);
//解密为FALSE,则cooike重新加密
$is_check_cooike = true;
if(isset($_COOKIE[$sCountryCode])) {
    $check_sc_cooike = $Encryption->_decrypt($_COOKIE[$sCountryCode]);
    if (!$check_sc_cooike || strlen(strval($check_sc_cooike)) >= 4) {
        $is_check_cooike = false;
    }
}

$sCurrencyCode = 'currency_'.trim($_SESSION['languages_code']);
if($_SESSION[$sCountryCode] && $is_check_cooike){
    $_SESSION['countries_iso_code']= $_SESSION[$sCountryCode];
    $countryCode = $_SESSION['countries_code_21'] = $countries_code_2 =strtoupper($_SESSION['countries_iso_code']);

    $countryCode_encrypt = $Encryption->_encrypt(strtolower($countryCode));
    setcookie($sCountryCode,$countryCode_encrypt,time()+86400*30,"/");
    $_COOKIE[$sCountryCode] = $countryCode_encrypt;
    if($_SESSION[$sCurrencyCode]){
        $sCurrencyCode_encrypt = $Encryption->_encrypt($_SESSION[$sCurrencyCode]);
        setcookie($sCurrencyCode,$sCurrencyCode_encrypt,time()+86400*30,"/");
    }
    /* $countryCode = $_SESSION['countries_code_21'] = $countries_code_2 = strtoupper($Encryption->_decrypt($_COOKIE['countries_iso_code'])); */
}else{
    if(isset($_COOKIE[$sCountryCode]) && $is_check_cooike){
        $countries_iso_code_decrypt = $Encryption->_decrypt($_COOKIE[$sCountryCode]);
        $_SESSION[$sCountryCode]=strtolower($countries_iso_code_decrypt);
        $_SESSION['countries_iso_code'] =$_SESSION[$sCountryCode];
        $countries_code_2 = $countryCode=strtoupper($_SESSION['countries_iso_code']);
        if($_COOKIE[$sCurrencyCode]){
            $_SESSION[$sCurrencyCode] = strtoupper($Encryption->_decrypt($_COOKIE[$sCurrencyCode]));
        }
    }else{
        switch($_SESSION['languages_code']){
            case 'fr':
                if((all_german_warehouse("country_code",$ipCountryCode) && $ipCountryCode != "GB") || $ipCountryCode =="CA"){
                    $_SESSION[$sCountryCode] = strtolower($ipCountryCode); //如果是德国仓覆盖国并且不是英国,或者是加拿大则自适应为IP获取的国家
                }else{
                    $_SESSION[$sCountryCode] ='fr'; //如果不是德国仓覆盖国家或者是英国 侧自适应为法国
                }
                break;
            case 'es':
                if(all_german_warehouse("country_code",$ipCountryCode) && $ipCountryCode != "GB"){
                    $_SESSION[$sCountryCode]=strtolower($ipCountryCode); //如果是德国仓覆盖国并且不是英国,则自适应为IP获取的国家
                }else{
                    $_SESSION[$sCountryCode] ='es'; //如果不是德国仓覆盖国家或者是英国 侧自适应为西班牙
                }
                break;
            case 'mx':
                $_SESSION[$sCountryCode]= (in_array($ipCountryCode,$mx_Countryarr)) ? strtolower($ipCountryCode):'mx';
                break;
            case 'jp':
                $_SESSION[$sCountryCode]= 'jp';
                break;
            case 'sg':
                $_SESSION[$sCountryCode]= 'sg';
                break;
            case 'ru':
                $_SESSION[$sCountryCode]= 'ru';
                break;
            case 'au':
                $_SESSION[$sCountryCode]= 'au';
                break;
            case 'uk':
                $_SESSION[$sCountryCode]= 'gb';
                break;
            case 'de':
            case 'dn':
                $_SESSION[$sCountryCode] = $ipCountryCode;
                if(seattle_warehouse("country_code",$ipCountryCode )||(!german_warehouse("country_code",$ipCountryCode)&&!other_eu_warehouse($ipCountryCode,"country_code")) || $ipCountryCode=="GB"){
                    $_SESSION[$sCountryCode] = 'de';
                }
                break;
            case 'it':
                $_SESSION[$sCountryCode]= 'it';
                break;
            default:
                if($ipCountryCode =='CN'){
                    $_SESSION[$sCountryCode]= 'us'; //如果是中国IP访问则展示为美国
                }else{
                    $_SESSION[$sCountryCode]= $ipCountryCode ? strtolower($ipCountryCode):'us';
                }

                break;
        }

        $_SESSION['countries_iso_code']= $_SESSION[$sCountryCode];
        $countryCode = $countries_code_2 =strtoupper($_SESSION['countries_iso_code']);
        $countryCode_encrypt = $Encryption->_encrypt(strtolower($countryCode));
        setcookie($sCountryCode,$countryCode_encrypt,time()+86400*30,"/");
        $_COOKIE[$sCountryCode] = $countryCode_encrypt;
    }


}
if($_SESSION['countries_iso_code']){
    $check_cookie =checkout_code($_SESSION['countries_iso_code']);
    if(!$check_cookie){
        $_SESSION['countries_code_21'] = $_SESSION['countries_iso_code']= 'us';
    }
}



if(isset($_GET['fr_site']) && $_GET['fr_site'] == 1){
    //$_SESSION['fr_site'] = 1;
}
if($countryCode == 'FR' && $_SESSION['fr_site'] != 1 && empty($_SESSION['countries_iso_code'])){
    //zen_redirect('https://www.fs.com/fr');
}

/* if($countryCode == 'GB' && !$_SESSION['default_requestion']){
	$_SESSION['default_requestion'] = true;
    zen_redirect('https://www.fs.com/uk');
} */
$current_request =	HTTPS_SERVER; //当前访问地址
$quest_url = $_SERVER['REQUEST_URI']; //当前访问地址参数
$home_page = HTTPS_SERVER.'/';  //首页
//根据ip获取的国家 跳转到相对应的站点
if($_GET['modules']!="phone" && strtolower($_SERVER['REQUEST_METHOD'])=='get'){
    if(in_array($countryCode,$limit_Countryarr)){
        $countryCode ='US';
    }
    if(in_array($countryCode,$uk_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/uk".str_replace('/uk','',$quest_url);
        if(strpos($quest_url,'/uk/')===false){
            zen_redirect($redirect_url);
        }
    }

    if($countryCode == 'JP' && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/jp".str_replace('/jp','',$quest_url);
        if(strpos($quest_url,'/jp/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$au_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/au".str_replace('/au','',$quest_url);
        if(strpos($quest_url,'/au/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$de_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/de".str_replace('/de','',$quest_url);
        if(strpos($quest_url,'/de/')===false && strpos($quest_url,'/de-en/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$fr_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/fr".str_replace('/fr','',$quest_url);
        if(strpos($quest_url,'/fr/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$mx_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/mx".str_replace('/mx','',$quest_url);
        if(strpos($quest_url,'/mx/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$ru_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/ru".str_replace('/ru','',$quest_url);
        if(strpos($quest_url,'/ru/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$es_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/es".str_replace('/es','',$quest_url);
        if(strpos($quest_url,'/es/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$de_en_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/de-en".str_replace('/de-en','',$quest_url);
        if(strpos($quest_url,'/de-en/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$sg_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/sg".str_replace('/sg','',$quest_url);
        if(strpos($quest_url,'/sg/')===false){
            zen_redirect($redirect_url);
        }
    }

    if(in_array($countryCode,$it_Countryarr) && !isset($_SESSION['currency_type']) && $_SERVER['HTTP_REFERER'] == NUll){
        $redirect_url = $current_request."/it".str_replace('/it','',$quest_url);
        if(strpos($quest_url,'/it/')===false){
            zen_redirect($redirect_url);
        }
    }

    $lang = $_GET['lang'] ? strip_tags($_GET['lang']) : '';
    if(!in_array($_GET['handler'],['cloudAuth'])){
        if (in_array($ipCountryCode, ['CN']) && $isMainPage && ($_SERVER['HTTP_REFERER'] == NUll || (strstr($_SERVER['HTTP_REFERER'], 'baidu.com') && in_array($_GET['main_page'], ['index', 'verify']))) &&
            (empty($lang) || $lang == 'en') && empty($countryTagConfig)) {
            $redirect_url = 'https://cn.fs.com';
            header('location:'. $redirect_url);
            exit;
        }
    }
}

if(in_array($countryCode,$it_Countryarr) && $current_request == $home_page && $_SERVER['HTTP_REFERER'] == NUll && strtolower($_SERVER['REQUEST_METHOD'])=='get'){
    $redirect_url = $current_request."it";
    zen_redirect($redirect_url);
}

$eur_array=array('IT','FR','DE','NL','AT','LU','IE','MC','FI','ES','GR','PT','MT','LV','EE','LT','SK','SI','BM','SM','AD','ME','BE');//德国仓使用欧元国家
$gbp_array=array('GB','GG','IM','JE');//使用英镑国家

if(in_array($countryCode,$eur_array)){
    $default_currency = 'EUR';
}elseif($countryCode == 'AU'){
    $default_currency = 'AUD';
}elseif(in_array($countryCode,$gbp_array)){
    $default_currency = 'GBP';
}elseif($countryCode == 'HK'){
    $default_currency = 'HKD';
}elseif($countryCode == 'BR'){
    $default_currency = 'BRL';
}elseif($countryCode == 'DK'){
    $default_currency = 'DKK';
}elseif($countryCode == 'MX'){
    $default_currency = 'MXN';
}elseif($countryCode == 'SG'){
    $default_currency = 'SGD';
}elseif($countryCode == 'CA'){
    $default_currency = 'CAD';
}elseif($countryCode == 'CH'){
    $default_currency = 'CHF';
}elseif($countryCode == 'JP'){
    $default_currency = 'JPY';
}elseif($countryCode == 'NO'){
    $default_currency = 'NOK';
}elseif($countryCode == 'SE'){
    $default_currency = 'SEK';
}elseif($countryCode == 'NZ'){
    $default_currency = 'NZD';
}elseif($countryCode == 'RU'){
    $default_currency = 'RUB';
}elseif($countryCode == 'HR'){
    $default_currency = 'EUR';
}else{
    $default_currency ='USD';
}

// If no currency is set, use appropriate default
if (!isset($_SESSION[$sCurrencyCode]) && !isset($_GET['currency']) ) $_SESSION[$sCurrencyCode] = $default_currency;


// Validate selected new currency, if any. Is false if valid not found.
$new_currency = (isset($_GET['currency'])) ? zen_currency_exists($_GET['currency']) : zen_currency_exists($_SESSION[$sCurrencyCode]);

// Validate language-currency and default-currency if relevant. Is false if valid not found.
if ($new_currency == false || isset($_GET['language'])) $new_currency = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? zen_currency_exists(LANGUAGE_CURRENCY) : $new_currency;

// Final check -- if selected currency is bad and the "default" is bad, default to the first-found currency in order of exch rate.
if ($new_currency == false) $new_currency = zen_currency_exists($default_currency, true);
//echo '<br />NEW = ' . $new_currency . '<br />';

// Now apply currency update
if (
    // Has new currency been selected?
    (isset($_GET['currency'])) ||

    // Does language change require currency update?
    (isset($_GET['language']) && USE_DEFAULT_LANGUAGE_CURRENCY == 'true' && LANGUAGE_CURRENCY != $_SESSION['currency']  )

) {
    $_SESSION[$sCurrencyCode] = $new_currency;
    // redraw the page without the currency/language info in the URL
}



/*if(isset($_GET['admitad_uid'])){
    setcookie("admitad_uid",$_GET['admitad_uid'],time()+86400*60,"/");
}*/
$_SESSION['currency'] = $_SESSION[$sCurrencyCode];
if(isset($country_input)){
    $in_country = $country_input;
    //$_SESSION['countries_iso_code']=$in_country;
    $_SESSION[$sCountryCode]=$in_country;
    $_SESSION['countries_iso_code']= $_SESSION[$sCountryCode];
}
//放在$_SESSION['countries_iso_code']最终值下进行判断
if($_SESSION['languages_code']== "au" && $_SESSION['countries_iso_code']=="nz"){
    $Is_NewLand =true ;
}
if(empty($_GET['paid']) && empty($_GET['gclid'])){
    if(isset($_GET['country']) && isset($_GET['currency'])){
        $_SERVER['REQUEST_URI'] =str_replace('?country='.$_GET['country'].'&currency='.$_GET['currency'],'',$_SERVER['REQUEST_URI']);
        $_SERVER['REQUEST_URI'] =str_replace('&country='.$_GET['country'].'&currency='.$_GET['currency'],'',$_SERVER['REQUEST_URI']);
        $_SERVER['REQUEST_URI'] =str_replace('?currency='.$_GET['currency'].'&country='.$_GET['country'],'',$_SERVER['REQUEST_URI']);
        $_SERVER['REQUEST_URI'] =str_replace('&currency='.$_GET['currency'].'&country='.$_GET['country'],'',$_SERVER['REQUEST_URI']);
        zen_redirect($_SERVER['REQUEST_URI']);
    }
}
