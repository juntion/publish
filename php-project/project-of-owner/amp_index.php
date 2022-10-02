<?php
require_once 'includes/application_top.php';
$default_country_code = $_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us';
$default_country_id = fs_get_data_from_db_fields('countries_id','countries','countries_iso_code_2="'.strtoupper($default_country_code).'"','limit 1');
$default_country_name = zen_get_countries_name_by_id($default_country_id);
$country_code = strtolower($default_country_code);
if($_SESSION['currency']){
	$symbol_var = fs_get_data_from_db_fields('symbol_var','currencies','code="'.$_SESSION['currency'].'"','');
	$default_currency = $symbol_var.' '.$_SESSION['currency'];
}else{
	$default_currency = '$ USD';
}
switch($_SESSION['languages_code']){
	case 'ru':
		$amp_code = 'ru';
		$title = 'FS - Россия';
	break;
	case 'fr':
		$amp_code = 'fr';
		$title = 'FS - France';
	break;
	case 'mx':
		$amp_code = $_SESSION['languages_code'];
		$title = 'FS - México';
	break;
	case 'es':
		$amp_code = $_SESSION['languages_code'];
		$title = 'FS - España';
	break;
	case 'jp':
		$amp_code = 'jp';
		$title = 'FS - 日本';
	break;
	case 'sg':
		$amp_code = 'sg';
		$title = 'FS - Singapore | Data Center, Enterprise, ISP Network Solutions';
	break;
	case 'au':
		$amp_code = 'au';
		$title = 'FS - Australia | Data Centre, Enterprise, ISP Network Solutions';
	break;
	case 'uk':
		$amp_code = 'uk';
		$title = 'FS - United Kingdom | Data Centre, Enterprise, ISP Network Solutions';
	break;
	case 'de':
		$amp_code = 'de';
		$title = 'FS - Deutschland';
	break;
	case 'dn':
		$amp_code = 'de-en';
		$title = 'FS - Germany';
	break;
	case 'en':
		$amp_code = '';
		$title = 'FS - Fiberstore | Data Center, Enterprise, Internet Access';
	break;
	default :
		$amp_code = '';
		$title = 'FS - Fiberstore | Data Center, Enterprise, Internet Access';
	break;
}
if ($_SESSION['languages_code'] != 'en') {
//只要不是英文站就把对应站点code值赋给$code,有的语种language_id一样所以用languages_code区分
	if($_SESSION['languages_code']=='dn'){
		$code = '/de-en';
	}else{
		$code = '/'.$_SESSION['languages_code'];
	}
} else {
	$code = '';
}
$common_current_username = $_SESSION['customer_first_name'].' '.$_SESSION['customer_last_name'];
$common_phone = fs_new_get_phone($_SESSION['countries_iso_code']);
$footer_copyright_str = str_replace('YEAR', date('Y', time()), FS_FOOTER_COPYRIGHT_M);
?>
<!doctype html>
<html ⚡ lang="en">
  <head>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js"></script>
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
	<script async custom-element="amp-list" src="https://cdn.ampproject.org/v0/amp-list-0.1.js"></script>
	<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
	<script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
	<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
	<script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
	<!-- <script async custom-element="amp-position-observer" src="https://cdn.ampproject.org/v0/amp-position-observer-0.1.js"></script> -->
	<!-- <script async custom-element="amp-animation" src="https://cdn.ampproject.org/v0/amp-animation-0.1.js"></script> -->
    <title><?php echo $title;?></title>
    <link rel="canonical" href="https://www.fs.com">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "headline": "Open-source framework for publishing content",
        "datePublished": "2015-10-07T12:02:41Z",
        "image": [
          "logo.jpg"
        ]
      }
    </script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<style amp-custom>
html{color:rgba(0,0,0,.87)}::-moz-selection{background:none;text-shadow:none}::selection{background:none;text-shadow:none}.hidden{display:none}@media print{*,*:before,*:after{background:transparent;color:#000;box-shadow:none}tr{page-break-inside:avoid}p{orphans:3;widows:3}}.mdl-button{-webkit-tap-highlight-color:transparent;-webkit-tap-highlight-color:rgba(255,255,255,0)}html{width:100%;height:100%;-ms-touch-action:manipulation;touch-action:manipulation}body{width:100%;min-height:100%;}html,body{font-family:"Open Sans","Arial",sans-serif;font-size:14px;font-weight:400;line-height:20px;}h5,h6,p{padding:0}h5{font-size:20px;font-weight:500;line-height:1;letter-spacing:.02em}h5,h6{font-family:"Open Sans","Helvetica","Arial",sans-serif;margin:24px 0 16px}h6{font-size:16px;letter-spacing:.04em}h6,p{font-weight:400;line-height:24px}p{font-size:14px;letter-spacing:0; margin:0;}
div,h1,h2{ margin:0; padding:0px; }ul,li{list-style: none; margin:0; padding:0;}
input,textarea{font-family:"Open Sans","Arial",sans-serif;padding: 0}
a { color:#232323; text-decoration:none; }
amp-img { max-height:inherit; max-width:inherit; }
.header{display: block;width: 100%;box-sizing: border-box;position: relative;top: 0;z-index: 100;height: 96px;}
.header_main {width: 100%;position: fixed;box-sizing: border-box;padding: 0 15px;background-color: #fff;border-bottom: 2px solid #dfdfdf;}
.header_top{height: 50px;text-align: center;position: relative;z-index: 100;}
.header_top_list{position: absolute;color: #888;text-decoration: none;top: 16px;left: 0;font-size: 30px;}
.header_top_list .line{width: 23px;height: 2px;background-color: #3b3e40;display: block;margin: 6px auto;-webkit-transition: all .3s ease-in-out;-o-transition: all .3s ease-in-out;transition: all .3s ease-in-out;border-radius: 2px;}
.header_top_list .line:first-child{margin-top: 0;}
.is-open{position: absolute;color: #888;text-decoration: none;top: 16px;left: 0;font-size: 30px;}
.is-open .line{width: 23px;height: 2px;background-color: #3b3e40;display: block;margin: 6px auto;-webkit-transition: all .3s ease-in-out;-o-transition: all .3s ease-in-out;transition: all .3s ease-in-out;border-radius: 2px;}
.is-open .line:first-child{margin-top: 0;transform: translateY(8px) rotate(45deg);}
.is-open .line:nth-child(2){opacity: 0;}
.is-open .line:last-child{transform: translateY(-8px) rotate(-45deg);}
.header_logo{display: inline-block;width: 75px;height: 36px;margin: 7px 0;background: url(https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/logo.svg) 50% 50% no-repeat;background-size: cover;}
.header_sidebar{width: 100%;max-width: 100%;top:50px;background-color: #fff;border-top: 2px solid #dedede;}
.header_cart{position: absolute;z-index: 1;top: 9px;right: -3px;}
.header_cart a{display: inline-block;width: 32px;height: 32px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//Cart.svg);background-size: cover;}
[class*="amphtml-sidebar-mask"]{display: none;}
.sidebar_first_country_account{padding: 10px 0;border-bottom: 1px solid #e5e5e5;}
.sidebar_first_country, .sidebar_first_account{height: 48px;line-height: 48px;padding: 0 15px;}
.af{background-position:0 0}.WW{background-position:-20px 0}.WW{background-position:-40px 0}.al{background-position:-60px 0}.WW{background-position:-80px 0}.dz{background-position:-100px 0}.as{background-position:-120px 0}.ad{background-position:-140px 0}.ao{background-position:-160px 0}.ai{background-position:-180px 0}.aq{background-position:-200px 0}.ag{background-position:-220px 0}.WW{background-position:-240px 0}.ar{background-position:-260px 0}.am{background-position:-280px 0}.aw{background-position:-300px 0}.WW{background-position:-320px 0}.au,.hm{background-position:-340px 0}.at{background-position:-360px 0}.az{background-position:-380px 0}.bs{background-position:-400px 0}.bh{background-position:-420px 0}.bd{background-position:-440px 0}.bb{background-position:-460px 0}.WW{background-position:-480px 0}.by{background-position:0 -20px}.be{background-position:-20px -20px}.bz{background-position:-40px -20px}.bj{background-position:-60px -20px}.bm{background-position:-80px -20px}.bt{background-position:-100px -20px}.bo{background-position:-120px -20px}.ba{background-position:-140px -20px}.bw{background-position:-160px -20px}.WW{background-position:-180px -20px}.br{background-position:-200px -20px}.io{background-position:-220px -20px}.bn{background-position:-240px -20px}.bg{background-position:-260px -20px}.bf{background-position:-280px -20px}.bi{background-position:-300px -20px}.kh{background-position:-320px -20px}.cm{background-position:-340px -20px}.ca{background-position:-360px -20px}.cv{background-position:-380px -20px}.WW{background-position:-400px -20px}.WW{background-position:-420px -20px}.ky{background-position:-440px -20px}.cf{background-position:-460px -20px}.td{background-position:-480px -20px}.cl{background-position:0 -40px}.cn{background-position:-20px -40px}.cx{background-position:-40px -40px}.WW{background-position:-60px -40px}.cc{background-position:-80px -40px}.co{background-position:-100px -40px}.WW{background-position:-120px -40px}.km{background-position:-140px -40px}.cg{background-position:-160px -40px}.WW{background-position:-180px -40px}.ck{background-position:-200px -40px}.cr{background-position:-220px -40px}.ci{background-position:-240px -40px}.hr{background-position:-260px -40px}.cu{background-position:-280px -40px}.WW{background-position:-300px -40px}.cy{background-position:-320px -40px}.cz{background-position:-340px -40px}.dk{background-position:-360px -40px}.dj{background-position:-380px -40px}.dm{background-position:-400px -40px}.do{background-position:-420px -40px}.ec{background-position:-440px -40px}.eg{background-position:-460px -40px}.sv{background-position:-480px -40px}.WW{background-position:0 -60px}.gq{background-position:-20px -60px}.er{background-position:-40px -60px}.ee{background-position:-60px -60px}.et{background-position:-80px -60px}.eu{background-position:-100px -60px}.fk{background-position:-120px -60px}.WW{background-position:-140px -60px}.WW{background-position:-160px -60px}.fj{background-position:-180px -60px}.fi,.ax{background-position:-200px -60px}.fr{background-position:-220px -60px}.tf{background-position:-240px -60px}.gf{background-position:-260px -60px}.ga{background-position:-280px -60px}.WW{background-position:-300px -60px}.gm{background-position:-320px -60px}.ge{background-position:-340px -60px}.de{background-position:-360px -60px}.gh{background-position:-380px -60px}.gi{background-position:-400px -60px}.gr{background-position:-420px -60px}.gl{background-position:-440px -60px}.gd{background-position:-460px -60px}.WW{background-position:-480px -60px}.gt{background-position:0 -80px}.gu{background-position:-20px -80px}.gg{background-position:-40px -80px}.gn{background-position:-60px -80px}.gw{background-position:-80px -80px}.gy{background-position:-100px -80px}.ht{background-position:-120px -80px}.WW{background-position:-140px -80px}.hn{background-position:-160px -80px}.hk{background-position:-180px -80px}.hu{background-position:-200px -80px}.WW{background-position:-220px -80px}.is{background-position:-240px -80px}.WW{background-position:-260px -80px}.in{background-position:-280px -80px}.id{background-position:-300px -80px}.ir{background-position:-320px -80px}.iq{background-position:-340px -80px}.ie{background-position:-360px -80px}.WW{background-position:-380px -80px}.WW{background-position:-400px -80px}.il{background-position:-420px -80px}.it{background-position:-440px -80px}.jm{background-position:-460px -80px}.jp{background-position:-480px -80px}.je{background-position:0 -100px}.jo{background-position:-20px -100px}.kz{background-position:-40px -100px}.ke{background-position:-60px -100px}.ki{background-position:-80px -100px}.WW{background-position:-100px -100px}.kw{background-position:-120px -100px}.kg{background-position:-140px -100px}.WW{background-position:-160px -100px}.lv{background-position:-180px -100px}.lb{background-position:-200px -100px}.ls{background-position:-220px -100px}.lr{background-position:-240px -100px}.WW{background-position:-260px -100px}.li{background-position:-280px -100px}.lt{background-position:-300px -100px}.lu{background-position:-320px -100px}.WW{background-position:-340px -100px}.mk{background-position:-360px -100px}.mg{background-position:-380px -100px}.mw{background-position:-400px -100px}.my{background-position:-420px -100px}.mv{background-position:-440px -100px}.ml{background-position:-460px -100px}.mt{background-position:-480px -100px}.mh{background-position:0 -120px}.mq{background-position:-20px -120px}.mr{background-position:-40px -120px}.mu{background-position:-60px -120px}.yt{background-position:-80px -120px}.mx{background-position:-100px -120px}.fm{background-position:-120px -120px}.md{background-position:-140px -120px}.mc{background-position:-160px -120px}.mn{background-position:-180px -120px}.me{background-position:-200px -120px}.ms{background-position:-220px -120px}.ma{background-position:-240px -120px}.mz{background-position:-260px -120px}.mm{background-position:-280px -120px}.na{background-position:-300px -120px}.WW{background-position:-320px -120px}.nr{background-position:-340px -120px}.np{background-position:-360px -120px}.an{background-position:-380px -120px}.nl{background-position:-400px -120px}.WW{background-position:-420px -120px}.nz{background-position:-440px -120px}.ni{background-position:-460px -120px}.ne{background-position:-480px -120px}.ng{background-position:0 -140px}.nu{background-position:-20px -140px}.nf{background-position:-40px -140px}.WW{background-position:-60px -140px}.WW{background-position:-80px -140px}.WW{background-position:-100px -140px}.mp{background-position:-120px -140px}.no,.bv{background-position:-140px -140px}.WW{background-position:-160px -140px}.WW{background-position:-180px -140px}.WW{background-position:-200px -140px}.om{background-position:-220px -140px}.WW{background-position:-240px -140px}.pk{background-position:-260px -140px}.pw{background-position:-280px -140px}.ps{background-position:-300px -140px}.pa{background-position:-320px -140px}.pg{background-position:-340px -140px}.py{background-position:-360px -140px}.pe{background-position:-380px -140px}.ph{background-position:-400px -140px}.pn{background-position:-420px -140px}.pl{background-position:-440px -140px}.pt{background-position:-460px -140px}.pr{background-position:-480px -140px}.qa{background-position:0 -160px}.WW{background-position:-20px -160px}.WW{background-position:-40px -160px}.ro{background-position:-60px -160px}.ru{background-position:-80px -160px}.rw{background-position:-100px -160px}.WW{background-position:-120px -160px}.WW{background-position:-140px -160px}.lc{background-position:-160px -160px}.WW{background-position:-180px -160px}.WW{background-position:-200px -160px}.ws{background-position:-220px -160px}.sm{background-position:-240px -160px}.st{background-position:-260px -160px}.sa{background-position:-280px -160px}.WW{background-position:-300px -160px}.sn{background-position:-320px -160px}.rs{background-position:-340px -160px}.sc{background-position:-360px -160px}.sl{background-position:-380px -160px}.sg{background-position:-400px -160px}.WW{background-position:-420px -160px}.sk{background-position:-440px -160px}.si{background-position:-460px -160px}.sb{background-position:-480px -160px}.so{background-position:0 -180px}.xs{background-position:-20px -180px}.za{background-position:-40px -180px}.WW{background-position:-60px -180px}.kp{background-position:-80px -180px}.WW{background-position:-100px -180px}.es{background-position:-120px -180px}.lk{background-position:-140px -180px}.kn{background-position:-160px -180px}.vc{background-position:-180px -180px}.sd{background-position:-200px -180px}.sr{background-position:-220px -180px}.sj{background-position:-240px -180px}.sz{background-position:-260px -180px}.se{background-position:-280px -180px}.ch{background-position:-300px -180px}.sy{background-position:-320px -180px}.WW{background-position:-340px -180px}.tw{background-position:-360px -180px}.tj{background-position:-380px -180px}.tz{background-position:-400px -180px}.th{background-position:-420px -180px}.tl{background-position:-440px -180px}.tg{background-position:-460px -180px}.tk{background-position:-480px -180px}.to{background-position:0 -200px}.tt{background-position:-20px -200px}.WW{background-position:-40px -200px}.tn{background-position:-60px -200px}.tr{background-position:-80px -200px}.tm{background-position:-100px -200px}.tc{background-position:-120px -200px}.tv{background-position:-140px -200px}.ug{background-position:-160px -200px}.ua{background-position:-180px -200px}.WW{background-position:-200px -200px}.WW{background-position:-220px -200px}.ae{background-position:-240px -200px}.gb,.gs,.im{background-position:-260px -200px}.WW{background-position:-280px -200px}.WW{background-position:-300px -200px}.us,.um{background-position:-320px -200px}.uy{background-position:-340px -200px}.uz{background-position:-360px -200px}.vu{background-position:-380px -200px}.va{background-position:-400px -200px}.ve{background-position:-420px -200px}.vn{background-position:-440px -200px}.vg{background-position:-460px -200px}.vi{background-position:-480px -200px}.WW{background-position:0 -220px}.WW{background-position:-20px -220px}.eh{background-position:-40px -220px}.WW{background-position:-60px -220px}.WW{background-position:-80px -220px}.ye{background-position:-100px -220px}.zm{background-position:-120px -220px}.zw{background-position:-140px -220px}.tp{background-position:-160px -220px}.fo{background-position:-180px -220px}.gp{background-position:-200px -220px}.kr{background-position:-220px -220px}.la{background-position:-240px -220px}.ly{background-position:-260px -220px}.mo{background-position:-280px -220px}.ic{background-position:-320px -220px}.cd{background-position:-340px -220px}.xy{background-position:-360px -220px}.pf{background-position:-380px -220px}.sh{background-position:-400px -220px}.re{background-position:-220px -60px}.pm{background-position:-220px -60px}.wf{background-position:-220px -60px}.nc{background-position:-220px -60px}
.sidebar_first_country em,.country_list_close em,.footer-country em{width: 16px;height: 16px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/country.png);background-repeat: no-repeat;float: left;margin-top: 16px;margin-right: 8px;}
.sidebar_first_country span{font-size: 14px;color: #3b3e40;}
.arrow-right{font-style: normal;float: right;text-align: center;width: 14px;height: 48px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//right.svg);background-size: 100%;background-position: center;background-repeat: no-repeat;}
.arrow-left{font-style: normal;float: left;text-align: center;width: 14px;height: 48px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//left.svg);background-size: 100%;background-position: center;background-repeat: no-repeat;}
.sidebar_first_account a{display: block;height: 48px;}
.sidebar_first_account em{display: inline-block;vertical-align:middle;margin-right: 5px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//Account.svg);background-size: 100%;width: 16px;height: 48px;background-repeat: no-repeat;background-position: center;}
.sidebar_first_account span,.sidebar-account-list span,.sidebar-account-sign-out span{font-size: 14px;color:#3b3e40;display: inline-block;vertical-align: middle;}
.country_region_sidebar{width: 100%;height: 100%;max-width: 100%;background-color: #f7f7f7;}
.country_region_sidebar_tit{padding: 0 15px;height: 50px;background-color: #fff;position: relative;}
.country_region_sidebar_close{line-height: 50px;z-index: 1;left: 15px;}
.country_region_sidebar_tit h1{font-size: 18px;font-weight: 400;position: absolute;width: 100%;height: 100%;top: 0;left: 0;text-align: center;line-height: 50px;color: #232323;}
.country_list_close{padding:15px;border-bottom: none;box-sizing: border-box;background-color: #fff;border: none;}
.country_list_close i{display: inline-block;font-style: normal;color: #616265;font-size: 14px;vertical-align: middle;line-height: 22px;}
.country_list_close em{margin-top: 4px;}
.country_region_sidebar_main:after{content: "";left: 0;top: 0;position: absolute;width: 100%;height: 50px;pointer-events: none;background: transparent;-webkit-box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);}
.country_list_close b{width: 20px;height: 20px;float: right;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//bottom.svg);background-size: 100%;background-position: center;background-repeat: no-repeat;transition: all .2s;}
.country_list_close b.show{transform: rotate(180deg);}
.country_list_all_search{padding: 0 15px 15px;background-color: #fff;border-bottom: 1px solid #e5e5e5;box-sizing: border-box;}
.country_list_all_search input{height: 34px;border: none;border-radius: 2px;background-color: #e5e5e5;width: 100%;text-indent: 15px;font-size: 13px;color: #232323;-webkit-appearance: none;outline: none;display: block;}
.country-list{background-color: #fff;}
.country-list li{padding: 0 15px;border-bottom: none;box-sizing: border-box;}
.country-list-name{display: block;border-bottom: 1px solid #e5e5e5;padding: 15px 0;}
.country-list-name em{display: inline-block;width: 16px;height: 16px;padding-left: 0;margin-right: 6px;vertical-align: middle;    background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/country.png);background-repeat: no-repeat;}
.country-list-name i{display: inline-block;font-style: normal;color: #616265;font-size: 14px;vertical-align: middle;line-height: 22px;}
.country-list li:last-child .country-list-name{border: none;}
.sidebar_first_categories{padding: 10px 0;border-bottom: 1px solid #e5e5e5;}
.sidebar_first_categories_tit,.sidebar_third_toSecond{font-size: 16px;color: #232323;font-weight: 400;line-height: 48px;padding: 0 15px;}
.sidebar_categories_list{padding: 0 15px;line-height: 48px;font-size: 14px;color: #3b3e40;}
.categories-sidebar{width: 100%;max-width: 100%;top:50px;background-color: #fff;border-top: 2px solid #dedede;}
.categories-sidebar-back-first{padding: 10px 15px;font-size: 14px;color: #616265;line-height: 48px;border-bottom: 1px solid #e5e5e5;}
.sidebar_second_categories_tit{font-size: 16px;color: #232323;font-weight: 400;padding: 10px 15px 0;line-height: 48px;}
.sidebar_third_toSecond{padding-top: 10px;}
.sidebar_categories_list a{display: block;}
.sidebar_first_help{padding: 10px 0;height:350px;}
#sidebar-second-help ul{padding: 10px 0;}
.sidebar-account-list{padding: 10px 0;}
.sidebar-account-list em,.sidebar-account-sign-out em{display: inline-block;vertical-align: middle;margin-right: 15px;background-size: 100%;width: 18px;height: 48px;background-repeat: no-repeat;background-position: center;}
.sidebar-account-list li:first-child em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//Account.svg)}
.sidebar-account-list li:nth-child(2) em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//setting.svg)}
.sidebar-account-list li:nth-child(3) em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//Order.svg)}
.sidebar-account-list li:nth-child(4) em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//address.svg)}
.sidebar-account-list li:nth-child(5) em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//Cases.svg)}
.sidebar-account-list li:nth-child(6) em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//quotes.svg)}
.sidebar-account-sign-out{padding: 10px 15px;border-top: 1px solid #e5e5e5;font-size: 14px;color: #616265;line-height: 48px;}
.sidebar-account-list a,.sidebar-account-sign-out a{display: block;}
.sidebar-account-sign-out em{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//warning.svg);}
amp-img { max-height:inherit; max-width:inherit; }
.banner{width: 100%;height: auto;}
.dot{position: absolute;bottom: 10px;width: 100%;text-align: center;}
.dot span { margin: 0 5px; width: 25px; height: 2px; display: inline-block; border-radius: 0; background: #fff; opacity: .3; }
amp-selector [option][selected] { cursor: auto; outline: none; display: inline-block;background: #fff; opacity: 1; }
.dot span.active { background: #fff; opacity: 1; }
.amp-carousel-button{display: none;}
.header_search{padding: 0 0 10px;transition: all .3s;width: 100%;box-sizing: border-box;margin: 0 auto;position: relative;z-index: 100;}
.header_search span,.search_top_ipt span{position: absolute;left: 9px;top: 7px;width: 20px;height: 20px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp//Search.svg);background-size: 100%;}
.header_search input,.search_top_ipt input{height: 34px;border: none;outline: none;background-color: #e5e5e5;width: 100%;border-radius: 3px;text-indent: 35px;color: #616265;font-size: 14px;}
.search-sidebar{width: 100%;max-width: 100%;background-color: #fff;position: relative;}
.search_top{box-sizing: border-box;padding: 8px 10px;position: relative;height: 50px;border-bottom: 2px solid #dfdfdf;margin-bottom: 20px;}
.search_top em{position: absolute;top: 14px;left: 15px;z-index: 10;width: 24px;height: 32px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/left.svg);background-size: 100%;background-repeat: no-repeat;}
.search_top_ipt{padding-left: 34px;height: 100%;position: relative;}
.search_top_ipt span{left: 40px;}
.search_top_ipt i{position: absolute;right: 5px;top: 6px;width: 22px;height: 22px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/close.svg);background-size: 100%;}
.search-result{display: block;position:absolute;top:50px;left:0;width: 100%;box-sizing: border-box;padding: 0 15px;background-color: #fff;z-index: 1;}
.search-result-con{line-height: 48px;border-bottom: 1px solid #e5e5e5;box-sizing: border-box;padding: 0 15px}
.search-result-con a{display: block;font-size: 14px;color: #232323;}
.noSearch{display: none;}
.hot-search{padding: 0 10px 10px;}
.hot-search-tit{font-size: 16px;color: #232323;font-weight: 400;margin-bottom: 24px;}
.hot-search-all-con{padding: 0 8px;float: left;line-height: 32px;border: 1px solid #dedede;border-radius: 3px;color: #999;text-decoration: none;margin-right: 10px;margin-bottom: 10px;}
.index-special-topic{background-color: #fff;padding: 10px 0 15px 0;overflow: hidden;}
.index-special-topic-one{width: 20%;float: left;text-align: center;}
.index-special-topic-one a{display: block}
.index-special-topic-one span{display:inline-block;width: 40px;height:40px;background-size: 100%;}
.index-special-topic-one.one span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-one.svg);}
.index-special-topic-one.two span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-two.svg);}
.index-special-topic-one.three span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-three.svg);}
.index-special-topic-one.four span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-four.svg);}
.index-special-topic-one.five span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-five.svg);}
.index-special-topic-one.six span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-six.svg);}
.index-special-topic-one.seven span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-seven.svg);}
.index-special-topic-one.eight span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-eight.svg);}
.index-special-topic-one.nine span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-nine.svg);width: 35px;background-position: center;background-repeat: no-repeat;}
.index-special-topic-one.ten span{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-special-ten.svg);}
.index-special-topic-one p{font-size: 12px;color: #707473;line-height: 14px;height: 34px;}
.index-video{padding: 15px 15px 20px;background-color: #f7f7f7;}
.notBanner span{background-color: #e2e2e4;opacity: 1;}
.notBannerSelector [option][selected]{background-color: #ccc}
.notBanner{bottom: -16px}
.index-video-con{position: relative;}
.index-video-con-btn{position: absolute;width: 46px;height:46px;left: 50%;margin-left: -23px;top:50%;margin-top: -23px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-video-btn.png);background-size: 100%;}
.product-module,.index-solution{background-color: #f7f7f7;}
.product-module-tit{font-size: 16px;color: #232323;font-weight: 600;padding: 25px 15px 15px;}
.product-module-mainProduct{width: 100%;background-color: #fff;box-sizing: border-box;padding: 0 40px 20px;margin-bottom: 12px;}
.product-module-mainProduct-pic{padding-top: 10px;text-align: center;width:150px;height:150px;margin:0 auto}
.product-module-mainProduct-pic img{width:auto;height:auto;}
.product-module-mainProduct-information{text-align: center;}
.product-module-mainProduct-information-tit{font-size: 16px;color: #232323;font-weight: 600;margin-bottom: 10px;}
.product-module-mainProduct-information p{font-size: 13px;color: #707473;line-height: 18px;margin-bottom: 15px;max-height: 54px;overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;}
.product-module-mainProduct-information span{display: block;color: #232323;font-size: 14px;font-weight: 400;}
.product-module-goods-con{overflow: hidden;padding: 0 15px}
.product-module-goods-con-one{width: 48%;background-color: #fff;padding-bottom: 15px;}
.product-module-goods-con-one:first-child{float: left;}
.product-module-goods-con-one:last-child{float:right;}
.product-module-goods-con-one-name{font-size: 14px;color: #232323;font-weight: 400;text-align: center;height: 32px;margin-bottom: 10px;line-height: 16px;padding: 0 10px;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;overflow: hidden;}
.product-module-goods-con-one-price{font-size: 13px;color: #232323;text-align: center;}
.product-module-goods-con-one-stock{font-size: 13px;color: #8d8d8f;text-align: center;}
.product-module .dot{bottom: -13px;}
.product-module .dot span{background-color: #e2e2e4;opacity: 1;}
.product-module amp-selector [option][selected]{background-color: #ccc}
.index-solution-main{overflow: hidden;padding: 0 15px 20px;}
.index-solution-main-con{float: left;position: relative;width: 49%;margin-right: 2%;margin-bottom: 2%;}
.index-solution-main-con:nth-child(2n){margin-right: 0}
.index-solution-main-con-font{position: absolute;width: 100%;box-sizing: border-box;line-height: 14px;font-size: 12px;color: #fff;background-color: rgba(51, 51, 51, .5);padding: 5px;left: 0;bottom: 0;}
.index-solution-main-con-font span{position: absolute;width: 13px;height: 11px;right: 5px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/new_index_wap/wap_Solution_icon.png);top: 50%;margin-top: -5.5px;}
.index-solution-main-con:nth-child(3), .index-solution-main-con:nth-child(4){margin-bottom: 0}
.footer{background: #f4f4f4;}
.footer-link{border-bottom: 1px solid #dedede;overflow: hidden;display: block;}
.footer-link a{width: 50%;text-align: center;padding: 18px 0;float: left;font-weight: 600;}
.footer-link a:first-child,.footer-link a:last-child{width: 25%}
.footer-single-pages{margin-bottom: 15px;}
.footer-single-pages-accordion{padding: 0 15px;border-bottom: 1px solid #dedede;}
.footer-single-pages-tit{padding: 12px 0;overflow: hidden;font-size: 13px;}
.footer-single-pages-tit span{float: right;width: 13px;height:20px;background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/add.svg);background-size: 100%;background-repeat: no-repeat;background-position: center;transition: all .2s;}
.footer-single-pages-tit span.show{transform: rotate(45deg)}
.footer-single-pages-header{background: none;padding-right: 0;border: none;}
.footer-single-pages-content{padding-bottom: 10px;}
.footer-single-pages-content a{padding: 5px 15px;color: #616265;display: block;font-size: 13px;}
.footer-share{text-align: center;margin-bottom: 15px;}
.footer-share a{display: inline-block;width: 16px;height: 16px;margin-right: 15px;background-position: center;background-size: 100%;background-repeat: no-repeat}
.footer-share a:first-child{background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/linkedin.svg)}
.footer-share a:nth-child(2){background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/instagram-fill.svg)}
.footer-share a:nth-child(3){background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/facebook.svg)}
.footer-share a:nth-child(4){background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/twitter.svg)}
.footer-share a:nth-child(5){background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/youtube.svg)}
.footer-share a:nth-child(6){background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/blog.svg)}
.footer-share a:nth-child(7){background-image: url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/phone.svg);margin-right: 0}
.footer-country{text-align: center;margin-bottom: 10px;}
.footer-country em{margin-top: 2px;margin-right: 8px;float: none;display: inline-block;vertical-align: middle}
.footer-country span{font-size: 13px;color: #616265;display: inline-block;vertical-align: middle}
.footer-policy{font-size: 12px;padding: 5px 15px 15px;color: #616265;text-align: center;}
.footer-policy div{margin-top: 5px;}
.footer-policy a{color: #232323;}
</style>
  </head>
  <body>
	<amp-state id="open-close-side">
   <script type="application/json">
    {
         "changeClass": ""
    }
   </script>
	</amp-state>
	<!-- <amp-animation id="header-input-move" layout="nodisplay">
		<script type="application/json">
			{
			"duration": "300ms",
			"fill": "both",
			"easing": "ease-in",
			"delay": "0",
			"animations": [{
				"selector": ".header_search",
				"keyframes": [{
					"transform": "translateY(-43px)"
				}]
			}]
			}
		</script>
	</amp-animation>
	<amp-animation id="page-scroll" layout="nodisplay">
		<script type="application/json">
			{
			"duration": "300ms",
			"fill": "both",
			"easing": "ease-in",
			"delay": "0",
			"animations": [{
				"selector": ".header_main",
				"keyframes": [{
					
				}]
			}]
			}
		</script>
	</amp-animation> -->
	<!-- 公共头部模块 -->
  	<header class="header">
		<!-- <amp-position-observer on="scroll:page-scroll.seekTo(percent=event.percent)" intersection-ratios="1" layout="nodisplay"></amp-position-observer> -->
  		<div class="header_main">
  			<div class="header_top">
  				<div class="header_top_list" [class]="visible ? 'is-open' : 'header_top_list'" tabindex="0" role='button' on="tap:AMP.setState({visible: !visible}),sidebar-first.toggle,sidebar-second-networking.close,sidebar-second-FOT.close,sidebar-second-FOC.close,sidebar-second-RE.close,sidebar-second-WO.close,sidebar-second-CCCC.close,sidebar-second-TT.close">
  					<span class="line header_top_list_first_line"></span>
					<span class="line header_top_list_second_line"></span>
					<span class="line header_top_list_third_line"></span>
  				</div>
  				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_index.php" class="header_logo">
  					
  				</a>
  				<div class="header_cart">
  					<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=shopping_cart"></a>
  				</div>
			</div>
			<!-- <amp-position-observer on="scroll:header-input-move.seekTo(percent=event.percent)" intersection-ratios="1" layout="nodisplay"></amp-position-observer> -->
			<div class="header_search" tabindex="0" role='button' on="tap:sidebar-search.open">
				<span></span>
				<input type="text" placeholder="Search..." disabled="disabled">
			</div>
  		</div>
	</header>
	
	<!-- 轮播图组件 -->
	<amp-list layout="responsive" width="960" height="540" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=index_banners">
		<template type="amp-mustache">
			<amp-carousel type="slides" id="index-banner" layout="responsive" autoplay loop class="banner" width="960" height="540" on="slideChange:index-banner-selector.toggle(index=event.index, value=true)">
				{{#values}}
					<a href="{{url_str}}">
						<amp-img layout="responsive" src="{{img_mobile_path}}" width="960" height="540"></amp-img>
					</a>
				{{/values}}
			</amp-carousel>
		</template>
	</amp-list>
	<?php 
		$banner_warehouse_str = get_warehouse_banner_str();
		if(!$home_custom_model){
			require_once('includes/classes/home_custom.php');
			$home_custom_model = new homeCustomModel();
			$banner = $home_custom_model->get_index_banners_data($banner_warehouse_str);
			$banner_count = count($banner);
		}

	?>
	<amp-selector id="index-banner-selector" on="select:index-banner.goToSlide(index=event.targetOption)">
		<div class="dot">
			<?php 
				for($i=0;$i<$banner_count;$i++){
					$banner_select = '';
					if($i==0){
						$banner_select = 'selected';
					}
			?>
				<span option="<?php echo $i;?>" <?php echo $banner_select;?>></span>
				
			<?php } ?>
		</div>
	</amp-selector>
	<!-- 轮播图组件结束 -->

	<!-- 十个专题模块 -->
	<div class="index-special-topic">
		<div class="index-special-topic-one one">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/25g-100g-transceivers-63.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_01;?></p>
			</a>
		</div>
		<div class="index-special-topic-one two">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/40g-transceivers-69.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_02;?></p>
			</a>
		</div>
		<div class="index-special-topic-one three">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/10g-sfp-series-fiber-optic-transceivers-49.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_03;?></p>
			</a>
		</div>
		<div class="index-special-topic-one four">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/dac-aoc-67.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_04;?></p>
			</a>
		</div>
		<div class="index-special-topic-one five">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/data-center-switches-68.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_05;?></p>
			</a>
		</div>
		<div class="index-special-topic-one six">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/wdm-otn-system-70.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_06;?></p>
			</a>
		</div>
		<div class="index-special-topic-one seven">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/fiber-patch-cables-65.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_07;?></p>
			</a>
		</div>
		<div class="index-special-topic-one eight">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/mtp-mpo-fiber-cabling-64.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_08;?></p>
			</a>
		</div>
		<div class="index-special-topic-one nine">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/high-density-fiber-patching-solutions-62.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_09;?></p>
			</a>
		</div>
		<div class="index-special-topic-one ten">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/specials/copper-cabling-systems-60.html">
				<span></span>
				<p><?php echo FS_AMP_CATE_10;?></p>
			</a>
		</div>
	</div>

	<!-- 视频模块 -->
	<div class="index-video">
		<amp-carousel id="index-video" type="slides" layout="responsive" loop width="1920" height="1080" on="slideChange:index-video-selector.toggle(index=event.index, value=true)">
			<div class="index-video-con">
				<amp-video id="index-video-player01" layout="responsive" width="1920" height="1080" controls src="https://img-en.fs.com/includes/templates/fiberstore/video/MG-1116-final.mp4" poster="https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-video01.jpg" controlslist="nodownload"></amp-video>
				<div class="index-video-con-btn" id="index-video-player-btn01" tabindex="1" role="button" on="tap:index-video-player-btn01.hide,index-video-player01.play"></div>
			</div>
			<div class="index-video-con">
				<amp-video id="index-video-player02" layout="responsive" width="1920" height="1080" controls src="https://img-en.fs.com/includes/templates/fiberstore/video/FHX-1u-fiber-enclosure.mp4" poster="https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-video02.jpg" controlslist="nodownload"></amp-video>
				<div class="index-video-con-btn" id="index-video-player-btn02" tabindex="1" role="button" on="tap:index-video-player-btn02.hide,index-video-player02.play"></div>
			</div>
			<div class="index-video-con">
				<amp-video id="index-video-player03" layout="responsive" width="1920" height="1080" controls src="https://img-en.fs.com/includes/templates/fiberstore/video/dwdm-mux-demux-solution.mp4" poster="https://img-en.fs.com/includes/templates/fiberstore/images/amp/index-video03.jpg" controlslist="nodownload"></amp-video>
				<div class="index-video-con-btn" id="index-video-player-btn03" tabindex="1" role="button" on="tap:index-video-player-btn03.hide,index-video-player03.play"></div>
			</div>
		</amp-carousel>
		<amp-selector class="notBannerSelector" id="index-video-selector" on="select:index-video.goToSlide(index=event.targetOption)">
			<div class="dot notBanner">
				<span option="0" selected></span>
				<span option='1'></span>
				<span option='2'></span>
			</div>
		</amp-selector>
	</div>

	<!-- Interconnection产品模块 -->
	<div class="product-module">
		<h2 class="product-module-tit"><?php echo FS_AMP_INTERCONNECT_01;?></h2>
		<amp-list layout="responsive" width="414" height="540" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=index_products&group=0">
			<template type="amp-mustache">
				{{#first}}
					<div class="product-module-mainProduct">
						<div class="product-module-mainProduct-pic">
							<a href="{{link}}">
								<amp-img layout="responsive" width="150" height="150" src="https://img-en.fs.com{{img_mobile_path}}"></amp-img>
							</a>
						</div>
						<div class="product-module-mainProduct-information">
							<a href="{{link}}">
								<h2 class="product-module-mainProduct-information-tit">{{title}}</h2>
								<p>{{content}}</p>
								<span>{{price}}</span>
							</a>
						</div>
					</div>
				{{/first}}
				<div class="product-module-goods">
					<amp-carousel id="product-module-carousel-interconnection" type="slides" layout="responsive" width="384" height="220" on="slideChange:product-module-carousel-interconnection-selector.toggle(index=event.index, value=true)">
						{{#parentEle}}
							<div class="product-module-goods-con">
								{{#childEle}}
									<div class="product-module-goods-con-one">
										<a href="{{link}}">
											<amp-img layout="responsive" width="186" height="120" src="https://img-en.fs.com{{img}}"></amp-img>
											<h2 class="product-module-goods-con-one-name">{{title}}</h2>
											<p class="product-module-goods-con-one-price">{{price}}</p>
											<p class="product-module-goods-con-one-stock">{{stock}}</p>
										</a>
									</div>
								{{/childEle}}
							</div>
						{{/parentEle}}
					</amp-carousel>
					<amp-selector id="product-module-carousel-interconnection-selector" on="select:product-module-carousel-interconnection.goToSlide(index=event.targetOption)">
						<div class="dot">
								<span option="0" selected></span>
								<span option='1'></span>
								<span option='2'></span>
								<span option='3'></span>
						</div>
					</amp-selector>
				</div>
			</template>
		</amp-list>
	</div>

	<!-- Optical Transport Network产品模块 -->
	<div class="product-module">
		<h2 class="product-module-tit"><?php echo FS_AMP_OPTICAL_TRANS_01;?></h2>
		<amp-list layout="responsive" width="414" height="540" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=index_products&group=1">
			<template type="amp-mustache">
				{{#first}}
					<div class="product-module-mainProduct">
						<div class="product-module-mainProduct-pic">
							<a href="{{link}}">
								<amp-img layout="responsive" width="150" height="150" src="https://img-en.fs.com{{img_mobile_path}}"></amp-img>
							</a>
						</div>
						<div class="product-module-mainProduct-information">
							<a href="{{link}}">
								<h2 class="product-module-mainProduct-information-tit">{{title}}</h2>
								<p>{{content}}</p>
								<span>{{price}}</span>
							</a>
						</div>
					</div>
				{{/first}}
				<div class="product-module-goods">
					<amp-carousel id="product-module-carousel-OTN" type="slides" layout="responsive" width="384" height="220" on="slideChange:product-module-carousel-OTN-selector.toggle(index=event.index, value=true)">
						{{#parentEle}}
							<div class="product-module-goods-con">
								{{#childEle}}
									<div class="product-module-goods-con-one">
										<a href="{{link}}">
											<amp-img layout="responsive" width="186" height="120" src="https://img-en.fs.com{{img}}"></amp-img>
											<h2 class="product-module-goods-con-one-name">{{title}}</h2>
											<p class="product-module-goods-con-one-price">{{price}}</p>
											<p class="product-module-goods-con-one-stock">{{stock}}</p>
										</a>
									</div>
								{{/childEle}}
							</div>
						{{/parentEle}}
					</amp-carousel>
					<amp-selector id="product-module-carousel-OTN-selector" on="select:product-module-carousel-OTN.goToSlide(index=event.targetOption)">
						<div class="dot">
								<span option="0" selected></span>
								<span option='1'></span>
								<span option='2'></span>
								<span option='3'></span>
						</div>
					</amp-selector>
				</div>
			</template>
		</amp-list>
	</div>

	<!-- Network Cable Assemblies产品模块 -->
	<div class="product-module">
		<h2 class="product-module-tit"><?php echo FS_AMP_NETWORK_CABLE_01;?></h2>
		<amp-list layout="responsive" width="414" height="540" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=index_products&group=2">
			<template type="amp-mustache">
				{{#first}}
					<div class="product-module-mainProduct">
						<div class="product-module-mainProduct-pic">
							<a href="{{link}}">
								<amp-img layout="responsive" width="150" height="150" src="https://img-en.fs.com{{img_mobile_path}}"></amp-img>
							</a>
						</div>
						<div class="product-module-mainProduct-information">
							<a href="{{link}}">
								<h2 class="product-module-mainProduct-information-tit">{{title}}</h2>
								<p>{{content}}</p>
								<span>{{price}}</span>
							</a>
						</div>
					</div>
				{{/first}}
				<div class="product-module-goods">
					<amp-carousel id="product-module-carousel-NCA" type="slides" layout="responsive" width="384" height="220" on="slideChange:product-module-carousel-NCA-selector.toggle(index=event.index, value=true)">
						{{#parentEle}}
							<div class="product-module-goods-con">
								{{#childEle}}
									<div class="product-module-goods-con-one">
										<a href="{{link}}">
											<amp-img layout="responsive" width="186" height="120" src="https://img-en.fs.com{{img}}"></amp-img>
											<h2 class="product-module-goods-con-one-name">{{title}}</h2>
											<p class="product-module-goods-con-one-price">{{price}}</p>
											<p class="product-module-goods-con-one-stock">{{stock}}</p>
										</a>
									</div>
								{{/childEle}}
							</div>
						{{/parentEle}}
					</amp-carousel>
					<amp-selector id="product-module-carousel-NCA-selector" on="select:product-module-carousel-NCA.goToSlide(index=event.targetOption)">
						<div class="dot">
								<span option="0" selected></span>
								<span option='1'></span>
								<span option='2'></span>
								<span option='3'></span>
						</div>
					</amp-selector>
				</div>
			</template>
		</amp-list>
	</div>

	<!-- Space Management产品模块 -->
	<div class="product-module">
		<h2 class="product-module-tit"><?php echo FS_AMP_SPACE_MANAGE_01;?></h2>
		<amp-list layout="responsive" width="414" height="540" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=index_products&group=3">
			<template type="amp-mustache">
				{{#first}}
					<div class="product-module-mainProduct">
						<div class="product-module-mainProduct-pic">
							<a href="{{link}}">
								<amp-img layout="responsive" width="150" height="150" src="https://img-en.fs.com{{img_mobile_path}}"></amp-img>
							</a>
						</div>
						<div class="product-module-mainProduct-information">
							<a href="{{link}}">
								<h2 class="product-module-mainProduct-information-tit">{{title}}</h2>
								<p>{{content}}</p>
								<span>{{price}}</span>
							</a>
						</div>
					</div>
				{{/first}}
				<div class="product-module-goods">
					<amp-carousel id="product-module-carousel-SM" type="slides" layout="responsive" width="384" height="220" on="slideChange:product-module-carousel-SM-selector.toggle(index=event.index, value=true)">
						{{#parentEle}}
							<div class="product-module-goods-con">
								{{#childEle}}
									<div class="product-module-goods-con-one">
										<a href="{{link}}">
											<amp-img layout="responsive" width="186" height="120" src="https://img-en.fs.com{{img}}"></amp-img>
											<h2 class="product-module-goods-con-one-name">{{title}}</h2>
											<p class="product-module-goods-con-one-price">{{price}}</p>
											<p class="product-module-goods-con-one-stock">{{stock}}</p>
										</a>
									</div>
								{{/childEle}}
							</div>
						{{/parentEle}}
					</amp-carousel>
					<amp-selector id="product-module-carousel-SM-selector" on="select:product-module-carousel-SM.goToSlide(index=event.targetOption)">
						<div class="dot">
								<span option="0" selected></span>
								<span option='1'></span>
								<span option='2'></span>
								<span option='3'></span>
						</div>
					</amp-selector>
				</div>
			</template>
		</amp-list>
	</div>

	<!-- Solution模块 -->
	<div class="index-solution">
		<h2 class="product-module-tit"><?php echo FS_AMP_SOLUTION_01;?></h2>
		<div class="index-solution-main">
			<amp-list layout="responsive" width="384" height="246" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=solution">
				<template type="amp-mustache">
					<div class="index-solution-main-con">
						<a href="https://www.fs.com{{url}}">
							<amp-img layout="responsive" width="190" height="120" src="{{img}}"></amp-img>
							<p class="index-solution-main-con-font">
								{{title}}
								<span></span>
							</p>
						</a>
					</div>
				</template>
			</amp-list>
		</div>
	</div>

	<!-- 公共底部模块 -->
	<div class="footer">
		<div class="footer-link">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/live_chat_service_mail.html"><?php echo FS_AMP_FOOTER_01;?></a>
			<a href="tel:+1 (888) 468 7419"><?php echo $common_phone; ?></a>
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/service/help_center.html"><?php echo FS_AMP_FOOTER_02;?></a>
		</div>
		<div class="footer-single-pages">
			<?php 
				if(!$home_custom_model){
					require_once('includes/classes/home_custom.php');
					$home_custom_model = new homeCustomModel();
				}
				$warehouse = '';
				if($_SESSION['languages_code'] == 'fr'){
					if(seattle_warehouse($code = "country_code",$_SESSION['countries_code_21'])){
						$warehouse = 1;
					}else{
						$warehouse = 2;
					}
				}
				if($_SESSION['languages_code'] == 'ru'){
					if(all_german_warehouse($code="country_code",$_SESSION['countries_code_21'])){
						$warehouse = 2;
					}else{
						$warehouse = 4;
					}
				}
				$footer_data = $home_custom_model->get_footer_data($footer_is_german_warehouse,$warehouse);
				$footer_help_string_data = $home_custom_model->get_footer_data($footer_is_german_warehouse,$warehouse,'80/82',1);
				//var_dump(333333);
//				exit();
			?>
				<?php foreach($footer_data as $key => $val){ ?>
					<amp-accordion animate id="footer-single-pages<?php echo $key?>" class="footer-single-pages-accordion">
						<section id="footer-single-pages<?php echo $key?>-section">
							<header class="footer-single-pages-header">
								<div class="footer-single-pages-tit" tabindex="0" role='button' on="tap:footer-single-pages<?php echo $key?>.toggle(section=footer-single-pages<?php echo $key?>-section),AMP.setState({show<?php echo $key?>:!show<?php echo $key?>})">
									<?php echo $val['title'];?><span [class]="show<?php echo $key?> ? 'show' : 'hide'"></span>
								</div>
							</header>
							<div class="footer-single-pages-content">
								<amp-list layout="responsive" width="384" height="120" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=footer&group=<?php echo $key;?>">
									<template type="amp-mustache">
										<a href="https://www.fs.com{{link}}">{{title}}</a>
									</template>
								</amp-list>
							</div>
						</section>
					</amp-accordion>
				<?php } ?>
		</div>
		<div class="footer-share">
			<a href="<?php sourceHtml('linkedin'); ?>"></a>
			<a href="<?php sourceHtml('instagram'); ?>"></a>
			<a href="<?php sourceHtml('facebook'); ?>"></a>
			<a href="<?php sourceHtml('twitter'); ?>"></a>
			<a href="<?php sourceHtml('youtube'); ?>"></a>
			<a href="https://community.fs.com/blog/"></a>
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/appdownload.html"></a>
		</div>
		<div class="footer-country">		
			<a href="<?php echo ($amp_code ? '/'.$amp_code : '').'/amp_country_select.php';?>">
				<em class="<?php echo $country_code;?>"></em>
				<span><?php echo $default_country_name; ?> / <?php echo $default_currency;?></span>
			</a>
		</div>
		<div class="footer-policy">
			<?php echo $footer_copyright_str; ?>
			<?php if ($_SESSION['languages_code'] == 'en') { ?>
				<div>
					<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/policies/privacy_policy.html">
						<?php echo FS_AMP_FOOTER_07;?>
					</a> 
					| 
					<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/policies/terms_of_use.html">
						<?php echo FS_AMP_FOOTER_08;?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>

	<!-- 第一级侧边栏 -->
  	<amp-sidebar id='sidebar-first' class="header_sidebar" layout='nodisplay' side='left'>
  		<div class="sidebar_first_country_account">
  			<div class="sidebar_first_country">
  				<!-- <amp-list layout="responsive" width="384" height="48" src="">
						<template type="amp-mustache">
							<em class="us"></em>
  						<span>United States / $ USD</span>
						</template>
					</amp-list> -->
					<a href="<?php echo ($amp_code ? '/'.$amp_code : '').'/amp_country_select.php';?>">
						<em class="<?php echo $country_code;?>"></em>
						<span><?php echo $default_country_name; ?> / <?php echo $default_currency;?></span>
						<i class="arrow-right"></i>
					</a>
  			</div>
  			<div class="sidebar_first_account">
					<?php if(!$_SESSION['customer_id']){ ?>
  				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=login">
  					<em></em>
  					<span><?php echo FS_AMP_FIRST_SIDEBAR_01;?></span>
  					<i class="arrow-right"></i>
					</a>
					<?php }else{ ?>
					<div tabindex="0" role="button" on="tap:sidebar-account.open">
						<em></em>
							<span><?php echo $_SESSION['customer_first_name'].' '.$_SESSION['customer_last_name'];?></span>
							<i class="arrow-right"></i>
					</div>
					<?php } ?>
  			</div>
  		</div>
  		<div class="sidebar_first_categories">
  			<h2 class="sidebar_first_categories_tit"><?php echo FS_AMP_FIRST_SIDEBAR_02;?></h2>
  			<ul>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-networking.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_03;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-FOT.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_04;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-FOC.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_05;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-RE.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_06;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-WO.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_07;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-CCCC.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_08;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-TT.open">
  					<?php echo FS_AMP_FIRST_SIDEBAR_09;?>
  					<i class="arrow-right"></i>
  				</li>
  			</ul>
  		</div>
  		<div class="sidebar_first_help">
  			<h2 class="sidebar_first_categories_tit"><?php echo FS_AMP_FIRST_SIDEBAR_13;?></h2>
  			<ul>
				<?php
					$json_str = '';
					foreach($footer_help_string_data as $one_k => $one_v){ 
						if(strtolower($one_v['title']) == 'support')	{
							$json_str = 'support';
						}elseif(strtolower($one_v['title']) == 'company'){
							$json_str = 'company';
						}elseif(strtolower($one_v['title']) == 'quick access'){
							$json_str = 'quick';
						}
				?>
					<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-help.open,AMP.setState({helpSrc:'https://mc471066223.github.io/AMP/api/help/<?php echo $json_str;?>.json'})">
						<?php echo $one_v['title'];?>
						<i class="arrow-right"></i>
  					</li>
				<?php } ?>
  				<!-- <li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-help.open,AMP.setState({helpSrc:'https://mc471066223.github.io/AMP/api/help/support.json'})">
  					<?php echo FS_AMP_FIRST_SIDEBAR_11;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-help.open,AMP.setState({helpSrc:'https://mc471066223.github.io/AMP/api/help/company.json'})">
  					<?php echo FS_AMP_FIRST_SIDEBAR_11;?>
  					<i class="arrow-right"></i>
  				</li>
  				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-second-help.open,AMP.setState({helpSrc:'https://mc471066223.github.io/AMP/api/help/quick.json'})">
  					<?php echo FS_AMP_FIRST_SIDEBAR_12;?>
  					<i class="arrow-right"></i>
  				</li> -->
  			</ul>
  		</div>
	</amp-sidebar>
	  
	<!-- 国家选择侧边栏 -->
  	<!-- <amp-sidebar id='sidebar-country' layout='nodisplay' side='left' class="country_region_sidebar">
  		<div class="country_region_sidebar_tit">
  			<div class="country_region_sidebar_close is-open" tabindex="0" role='button' on="tap:sidebar-country.close">
  				<span class="line header_top_list_first_line"></span>
				<span class="line header_top_list_second_line"></span>
				<span class="line header_top_list_third_line"></span>
  			</div>
  			<h1>Select Country/Region</h1>
  		</div>
  		<div class="country_region_sidebar_main">
  			<amp-accordion animate class="country-choose" id='accordion-country-choose'>
  				<section id='accordion-country-choose-section'>
  					<header class="country_list_close">
	  					<div tabindex="0" role='button' on="tap:accordion-country-choose.toggle(section=accordion-country-choose-section),AMP.setState({countryShow:!countryShow})">
	  						<em class="us"></em>
		  					<i>United States</i>
		  					<b [class]="countryShow ? 'show' : 'hide'"></b>
	  					</div>
	  				</header>
	  				<div class="country_list_all">
	  					<div class="country_list_all_search">
	  						<input type="text" placeholder="Select Country/Region" />
	  					</div>
	  					<ul class="country-list">
	  						<li class="">
	  							<span class="country-list-name">
	  								<em class="us"></em>
	  								<i>United States</i>
	  							</span>
	  						</li>
	  					</ul>
	  				</div>
  				</section>
  			</amp-accordion>
  		</div>
  	</amp-sidebar> -->
  
	<!-- 所有二级分类侧边栏 -->
  	<amp-sidebar id='sidebar-second-networking' layout='nodisplay' side='right' class='categories-sidebar'>
  		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-networking.close">
  			<i class="arrow-left"></i>
  			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
  		</div>
  		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_02;?></h2>
  		<ul>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3079'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_03;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1017'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_04;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=2962'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_05;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3376'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_06;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3265'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_07;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3396'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_08;?>
				<i class="arrow-right"></i>
			</li>
		</ul>
	</amp-sidebar>
	  
	<amp-sidebar id='sidebar-second-FOT' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-FOT.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_09;?></h2>
		<ul>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=889'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_10;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=56'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_11;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=57'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_12;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1113'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_13;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=2688'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_14;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=58'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_15;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=2757'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_16;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=61'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_17;?>
					<i class="arrow-right"></i>
				</li>
				<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3388'})">
					<?php echo FS_AMP_SECOND_SIDEBAR_18;?>
					<i class="arrow-right"></i>
				</li>
			</ul>
	</amp-sidebar>
	  
	<amp-sidebar id='sidebar-second-FOC' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-FOC.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_19;?></h2>
		<ul>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=899'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_20;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=261'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_21;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1080'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_22;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3471'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_23;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1416'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_24;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1120'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_25;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1130'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_26;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1414'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_27;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=573'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_28;?>
				<i class="arrow-right"></i>
			</li>
		</ul>
	</amp-sidebar>

	<amp-sidebar id='sidebar-second-RE' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-RE.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_29;?></h2>
		<ul>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3091'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_30;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=2977'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_31;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1068'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_32;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=2961'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_33;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3533'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_34;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3522'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_35;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3531'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_57;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_58;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3319'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_59;?>
				<i class="arrow-right"></i>
			</li>
		</ul>
	</amp-sidebar>

	<amp-sidebar id='sidebar-second-WO' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-WO.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_36;?></h2>
		<ul>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=6'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_37;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1309'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_38;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1334'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_39;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3390'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_40;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=894'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_41;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=4'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_42;?>
				<i class="arrow-right"></i>
			</li>
		</ul>
	</amp-sidebar>

	<amp-sidebar id='sidebar-second-CCCC' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-CCCC.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_43;?></h2>
		<ul>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=960'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_44;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=2974'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_45;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=629'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_46;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1097'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_47;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_48;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=979'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_49;?>
				<i class="arrow-right"></i>
			</li>
		</ul>
	</amp-sidebar>

	<amp-sidebar id='sidebar-second-TT' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-TT.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<h2 class="sidebar_second_categories_tit"><?php echo FS_AMP_SECOND_SIDEBAR_50;?></h2>
		<ul>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=23'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_51;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=18'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_52;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=1317'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_53;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3368'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_54;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=20'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_55;?>
				<i class="arrow-right"></i>
			</li>
			<li class="sidebar_categories_list" tabindex="0" role='button' on="tap:sidebar-third-categories.open,AMP.setState({categories:'https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=979'})">
				<?php echo FS_AMP_SECOND_SIDEBAR_56;?>
				<i class="arrow-right"></i>
			</li>
		</ul>
		
	</amp-sidebar>

	<!-- 单页面侧边栏 -->
	<amp-sidebar id='sidebar-second-help' layout='nodisplay' side='right' class='categories-sidebar'>
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-help.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<ul>
			<amp-list layout='responsive' width="300" height="100" [src]="helpSrc" src="https://mc471066223.github.io/AMP/api/help/support.json">
				<template type='amp-mustache'>
					<li class="sidebar_categories_list">
						<a href="{{url}}">
							{{name}}
						</a>
					</li>
				</template>
			</amp-list>
		</ul>
	</amp-sidebar> 

	<!-- 三级分类侧边栏 -->
  	<amp-sidebar id='sidebar-third-categories' layout='nodisplay' side='right' class="categories-sidebar">
  		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-second-networking.close">
  			<i class="arrow-left"></i>
  			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
  		</div>
  		<h2 class="sidebar_third_toSecond" tabindex="0" role='button' on='tap:sidebar-third-categories.close'>
  			<i class="arrow-left"></i>
  			<?php echo FS_AMP_THIRD_SIDEBAR_01;?>
  		</h2>
  		<ul>
	  		<amp-list layout='responsive' width="300" height="300" [src]="categories" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=left_bar_category&cid=3079">
	  			<template type='amp-mustache'>
	  				<li class="sidebar_categories_list">
	  					<a href="{{url}}">
	  						{{name}}
	  					</a>
	  				</li>
	  			</template>
	  		</amp-list>
  		</ul>
	</amp-sidebar>
	  
	<!-- 登陆后侧边栏 -->
	<amp-sidebar id="sidebar-account" layout='nodisplay' side="right" class="categories-sidebar">
		<div class="categories-sidebar-back-first" tabindex="0" role='button' on="tap:sidebar-account.close">
			<i class="arrow-left"></i>
			<?php echo FS_AMP_SECOND_SIDEBAR_01;?>
		</div>
		<ul class="sidebar-account-list">
			<li class="sidebar_categories_list">
				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=my_dashboard">
					<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_01;?></span>
				</a>
			</li>
			<li class="sidebar_categories_list">
				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=edit_my_account">
					<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_02;?></span>
				</a>
			</li>
			<li class="sidebar_categories_list">
				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=manage_orders">
					<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_03;?></span>
				</a>
			</li>
			<li class="sidebar_categories_list">
				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=manage_addresses">
					<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_04;?></span>
				</a>
			</li>
			<li class="sidebar_categories_list">
				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=my_cases">
					<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_05;?></span>
				</a>
				
			</li>
			<li class="sidebar_categories_list">
				<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=inquiry_list">
					<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_06;?></span>
				</a>
				
			</li>
		</ul>
		<div class="sidebar-account-sign-out">
			<a href="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/index.php?main_page=logoff">
				<em></em><span><?php echo FS_AMP_LOGIN_SIDEBAR_07;?></span>
			</a>
		</div>
	</amp-sidebar>
	<!-- 搜索侧边栏 -->
	<amp-sidebar id='sidebar-search' layout='nodisplay' side='left' class="search-sidebar">
		<div class="search_top">
			<em tabindex="0" role="button" on="tap:sidebar-search.close"></em>
			<div class="search_top_ipt">
				<span></span>
				<form action="https://www.fs.com" method="GET" target="_top">
					<input type="hidden" name="main_page" value="advanced_search_result">
					<input type="text" name="keyword" placeholder="Search..." [value]="searchState.inputValue" on="input-throttled:AMP.setState({searchState:{inputValue:event.value}})" autofocus autocomplete="off">
				</form>
				<i tabindex="0" role="button" on="tap:AMP.setState({searchState:{inputValue:''}})"></i>
			</div>
		</div>
		<div class="noSearch" [class]="searchState.inputValue ? 'search-result' : 'noSearch'">
			<amp-list class="search-result-list" layout="responsive" width="300" height="300" [src]="searchState.inputValue ? searchAPI.autoSearchAPI + encodeURIComponent(searchState.inputValue) : searchAPI.emptyAndInitialTemplateJson">
				<template type="amp-mustache">
					<div class="search-result-con">
						<a href="{{link}}">
							{{fs_search_words}}
						</a>
					</div>
				</template>	
			</amp-list >
		</div>
		<div class="hot-search">
			<h2 class="hot-search-tit"><?php echo FS_AMP_SEARCH_01;?></h2>
			<div class="hot-search-all">
				<amp-list layout="responsive" width="300" height="300" src="https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=hot_search">
					<template type="amp-mustache">
						<a class="hot-search-all-con" href="{{link}}">
							{{name}}
						</a>
					</template>
				</amp-list>
			</div>
		</div>
	</amp-sidebar>
	<!-- 搜索API -->
	<amp-state id="searchState">
		<script type="application/json">
			{
				"inputValue": ""
			}
		</script>
	</amp-state>
	<amp-state id='searchAPI'>
		<script type="application/json">
			{
				"autoSearchAPI": "https://www.fs.com<?php echo $amp_code ? '/'.$amp_code : '';?>/amp_categories.php?action=search&search_key=",
				"emptyAndInitialTemplateJson": [{
						"query": "",
						"results": []
				}]
			}
		</script>
	</amp-state>
  </body>
</html>