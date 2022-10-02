<?php
/**
 * initialise language handling
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @todo ICW(SECURITY) is it worth having a sanitizer for $_GET['language'] ?
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_languages.php 2753 2005-12-31 19:17:17Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
  $lng = new language();
  if (isset($_GET['language']) && zen_not_null($_GET['language'])) {
    $lng->set_language($_GET['language']);
  } else {
    if (LANGUAGE_DEFAULT_SELECTOR=='Browser') {
      $lng->get_browser_language();
    } else {
      $lng->set_language(DEFAULT_LANGUAGE);
    }
  }
  /* $_SESSION['language'] = (zen_not_null($lng->language['directory']) ? $lng->language['directory'] : 'english');
  $_SESSION['languages_id'] = (zen_not_null($lng->language['id']) ? $lng->language['id'] : 1);
  $_SESSION['languages_code'] = (zen_not_null($lng->language['code']) ? $lng->language['code'] : 'en'); */

//网站所有小语种站点
$fs_all_site = ['au','uk','sg','es','mx','fr','ru','jp','de','de-en','it'];
//不同站点语言包标识配置
if(!empty($_GET['lang'])){
	switch($_GET['lang']){
		case 'ru':
		    $_SESSION['language'] = 'russian';
			$_SESSION['languages_id'] = 4;
			$_SESSION['languages_code'] = 'ru';
			break;
		case 'fr':
			$_SESSION['language'] = 'france';
			$_SESSION['languages_id'] = 3;
			$_SESSION['languages_code'] = 'fr';
			break;
		case 'es':
		case 'mx':
			$_SESSION['language'] = 'Spanish';
			$_SESSION['languages_id'] = 2;
			$_SESSION['languages_code'] = $_GET['lang'];
			break;
		case 'jp':
			$_SESSION['language'] = 'japan';
			$_SESSION['languages_id'] = 8;
			$_SESSION['languages_code'] = 'jp';
			break;
		case 'sg':
			$_SESSION['language'] = 'english';
			$_SESSION['languages_id'] = 1;
			$_SESSION['languages_code'] = 'sg';
			break;
		case 'au':
			$_SESSION['language'] = 'australia';
			$_SESSION['languages_id'] = 9;
			$_SESSION['languages_code'] = 'au';
			break;	
		case 'uk':
			$_SESSION['language'] = 'britain';
			$_SESSION['languages_id'] = 9;
			$_SESSION['languages_code'] = 'uk';
			break;	
		case 'de':
			$_SESSION['language'] = 'german';
			$_SESSION['languages_id'] = 5;
			$_SESSION['languages_code'] = 'de';
			break;
			//de-en 专题 分类 产品树与uk一致 故修改languages_id=9
		case 'de-en':
			$_SESSION['language'] = 'german_en';
			$_SESSION['languages_id'] = 9;
			$_SESSION['languages_code'] = 'dn';
			break;
		case 'it':
			$_SESSION['language'] = 'italy';
			$_SESSION['languages_id'] = 14;
			$_SESSION['languages_code'] = 'it';
			break;
        default :
            $_SESSION['language'] = 'english';
            $_SESSION['languages_id'] = 1;
            $_SESSION['languages_code'] = 'en';
            break;
	}
}else{
	//针对ajax请求
    if(isAjax()){
        $origin_url = $_SERVER['HTTP_REFERER'];
        $parse_url = parse_url($origin_url);
        $host = $parse_url['host'];
//        if(!in_array($host,array("www.fs.com","test.whgxwl.com","tx.fs.com","aron.test.com","local.fs.quest","local.fs.com","fsbox.com"))){
//            echo json_encode(array("status"=>"error","data"=>FS_SYSTME_BUSY));
//            exit;
//        }
        if(!empty($origin_url)){
            $origin_url = explode("/",$origin_url);
            foreach ($origin_url as $current_path){
                if(in_array($current_path, $GLOBALS['fs_all_site'])){
					switch($current_path){
						case 'ru':
							$_SESSION['language'] = 'russian';
							$_SESSION['languages_id'] = 4;
							$_SESSION['languages_code'] = 'ru';
							$_GET['lang'] = 'ru'; 
							break;
						case 'fr':
							$_SESSION['language'] = 'france';
							$_SESSION['languages_id'] = 3;
							$_SESSION['languages_code'] = 'fr';
							$_GET['lang'] = 'fr'; 
							break;
						case 'es':
						case 'mx':
							$_SESSION['language'] = 'Spanish';
							$_SESSION['languages_id'] = 2;
							$_SESSION['languages_code'] = $current_path;
							$_GET['lang'] = $current_path; 
							break;
						case 'jp':
							$_SESSION['language'] = 'japan';
							$_SESSION['languages_id'] = 8;
							$_SESSION['languages_code'] = 'jp';
							$_GET['lang'] = 'jp';
							break;
						case 'sg':
							$_SESSION['language'] = 'english';
							$_SESSION['languages_id'] = 1;
							$_SESSION['languages_code'] = 'sg';
							$_GET['lang'] = 'sg';
							break;
						case 'au':
							$_SESSION['language'] = 'australia';
							$_SESSION['languages_id'] = 9;
							$_SESSION['languages_code'] = 'au';
							$_GET['lang'] = 'au';
							break;
						case 'uk':
							$_SESSION['language'] = 'britain';
							$_SESSION['languages_id'] = 9;
							$_SESSION['languages_code'] = 'uk';
							$_GET['lang'] = 'uk';
							break;
						case 'de':
							$_SESSION['language'] = 'german';
							$_SESSION['languages_id'] = 5;
							$_SESSION['languages_code'] = 'de';
							$_GET['lang'] = 'de';
							break;
                        //de-en 专题 分类 产品树与uk一致 故修改languages_id=9
						case 'de-en':
							$_SESSION['language'] = 'german_en';
							$_SESSION['languages_id'] = 9;
							$_SESSION['languages_code'] = 'dn';
							$_GET['lang'] = 'de-en';
							break;
						case 'it':
							$_SESSION['language'] = 'italy';
							$_SESSION['languages_id'] = 14;
							$_SESSION['languages_code'] = 'it';
							$_GET['lang'] = 'it';
							break;
						default :
							$_SESSION['language'] = 'english';
							$_SESSION['languages_id'] = 1;
							$_SESSION['languages_code'] = 'en';
							break;
					}
                }
            }
        }
    }else{
        $_SESSION['language'] = 'english';
        $_SESSION['languages_id'] = 1;
        $_SESSION['languages_code'] = 'en';
    }
}
if(empty($_SESSION['languages_id'])){
    $_SESSION['language'] = 'english';
    $_SESSION['languages_id'] = 1;
    $_SESSION['languages_code'] = 'en';
}
//TABLE_PRODUCTS_DESCRIPTION  不同语种的产品描述表不同，放在此处定义
switch($_SESSION['languages_id']){
	case 1:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description');
	break;
	case 2:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_es');
	break;
	case 3:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_fr');
	break;
	case 4:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_ru');
	break;
	case 5:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_de');
	break;
	case 8:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_jp');
	break;
	case 9:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_uk');
	break;
	case 14:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description_it');
		break;
	default:
		define('TABLE_PRODUCTS_DESCRIPTION', DB_PREFIX . 'products_description');
		break;
}

//获取当前国家对应的发货仓库
$warehouse_data = fs_products_warehouse_where();
$fsCommonWarehouseCode = $warehouse_data['code'];
//当前国家对应的询价字段
$fsCurrentInquiryField = 'is_'.$fsCommonWarehouseCode.'_inquiry';