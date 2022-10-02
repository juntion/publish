<?php

/**

 * load css files according to the page

 */

//echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . 'style.css' . '" />'."\n";



switch (1){

	case in_array($_GET['main_page'], array('login',FILENAME_CHECKOUT_SUCCESS, FILENAME_CHECKOUT_SUCCESS_PURCHASE)):

			$css_array = array('style','help','login');

		break;

	case in_array($_GET['main_page'], array('index')):

		$css_array = array('style','list','easydialog','label','p_style','help');

		break;

	case in_array($_GET['main_page'], array('shopping_cart')):

		$css_array = array('shopping_cart','login','style','list','easydialog','label');

		break;

	case in_array($_GET['main_page'], array(FILENAME_CHECKOUT)):

		$css_array = array('popup','login','style');

		break;

	case in_array($_GET['main_page'], array(FILENAME_ACCOUNT,FILENAME_MY_DASHBOARD)):

		$css_array = array('style','help','address','login');

		break;

	case in_array($_GET['main_page'], array(FILENAME_ACCOUNT_HISTORY_INFO,FILENAME_MANAGE_ORDERS,FILENAME_MANAGE_ADDRESSES,FILENAME_MANAGE_COUPONS,FILENAME_MANAGE_WISHLISTS,FILENAME_MANAGE_PROFILE,FILENAME_PRIVACY_POLICY,FILENAME_FREE_SHIPPING,FILENAME_GLOBAL_SHIPPING,FILENAME_ISO_STANDARD,FILENAME_FREE_SHIPPING

,FILENAME_ACCOUNT_PASSWORD,FILENAME_ACCOUNT_NEWSLETTERS,FILENAME_REGIST,FILENAME_WHY_US,FILENAME_GET_A_QUICK_QUOTE,FILENAME_PAYMENT_METHODS,FILENAME_CUSTOM_OEM,FILENAME_RMA_SOLUTION,FILENAME_ESTIMATED_TIME,FILENAME_DEFINE_SITE_MAP,FILENAME_CONTACT_US,FILENAME_HOW_TO_BUY,FILENAME_TUTORIAL,FILENAME_TUTORIAL_LIST,

FILENAME_TUTORIAL_DETAIL,FILENAME_PURCHASING_HELP,FILENAME_LOW_COST_CWDM_SOLUTION,FILENAME_SHIPPING_GUIDE,FILENAME_FAQ,FILENAME_PASSWORD_FORGOTTEN,FILENAME_NEWS_ARTICLE,FILENAME_FAQ_DETAIL,FILENAME_FTTH_CABLING_SYSTEM,FILENAME_TIME_OUT)):

		$css_array = array('style','address','p_style','help','login','list');

		break;

	case in_array($_GET['main_page'], array(FILENAME_PRODUCT_INFO,FILENAME_MANAGE_REVIEWS,FILENAME_ALL_REVIEW)):

		$css_array = array('style','help','address','login','list','p_style','label','jquery-ui-1.9.1.custom.min','jquery.fancybox-1.3.4');

		break;



	case in_array($_GET['main_page'], array(FILENAME_ADVANCED_SEARCH_RESULT)):

		//$css_array = array('style','p_content','list');

		$css_array = array('style','help','address','login','list','p_style','label','jquery-ui-1.9.1.custom.min');

		break;

	case in_array($_GET['main_page'], array(FILENAME_PRINT_ORDER)):

		$css_array = array('style','help','address');

		break;

	case in_array($_GET['main_page'], array(FILENAME_CHECKOUT_WESTERUNION_COMPLETE,FILENAME_CHECKOUT_WIRETRANSFER_COMPLETE)):

		$css_array = array('style','shopping_cart',FILENAME_CHECKOUT);

		break;

	case in_array($_GET['main_page'], array(FILENAME_PAGE_NOT_FOUND)):

		$css_array = array('style','help');

		break;

	case in_array($_GET['main_page'], array(FILENAME_SUBMIT_REVIEW,FILENAME_SUBMIT_EDIT,REVIEW)):

		$css_array = array('style','help','address','p_style','login');

		break;

	case in_array($_GET['main_page'], array(FILENAME_NEWS)):

		$css_array = array('style','help','login','list');

		break;

	default:

		$css_array = array('style','help','list');

		break;

}

//method 1

//foreach ($css_array as $value){

//	$ext = '?v=6';

// 	if ('style' == $value) $ext = '?v=5';

//	echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . $value . '.css'.$ext.'" />'."\n";

//}



//method 2

// function compress_css($buffer)

// {

// 	/* remove comments */

// 	$buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer) ;

// 	/* remove tabs, spaces, newlines, etc. */

// 	$arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ") ;

// 	$buffer = str_replace($arr, "", $buffer) ;

// 	return $buffer;

// }

// $filename = 'fs_'.$_GET['main_page'].'.min.css';

// $path = $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/';

// // $real_path = DIR_FS_CATALOG.'includes/templates/fiberstore/css/';

// if (!file_exists($path.$filename)){

// 	$css_page_contents = '';

// 	foreach ($css_array as $value){

// 		$css_page_contents .= file_get_contents($path . $value.'.css');

// 	// 	echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . $value . '.css" />'."\n";

// 	}

// 	//compress css

// 	$css_page_contents = compress_css($css_page_contents);

// 	$fs_handler = fopen($path.$filename, 'a+');

// 	fwrite($fs_handler, $css_page_contents);

// 	fclose($fs_handler);

// }

// echo '<link rel="stylesheet" type="text/css" href="' . $path. $filename . '" />'."\n";