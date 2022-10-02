<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: document_general_info.php 6371 2007-05-25 19:55:59Z ajeh $
 */

define('TEXT_PRODUCT_NOT_FOUND', 'すみません、この商品が見つかりませんでした。');
define('TEXT_CURRENT_REVIEWS', '現在のレビュー状況:');
define('TEXT_MORE_INFORMATION', 'もっと見るために、どうぞ、以下をご覧ください。商品<a href="%s" target="_blank">ウェブページ</a>.');
define('TEXT_DATE_ADDED', 'この商品は以下のカテゴリになり：%s.');
define('TEXT_DATE_AVAILABLE', 'この商品は以下の日付に在庫予定：%s.');
define('TEXT_ALSO_PURCHASED_PRODUCTS', 'これを買ったお客様はまた購買した...');
define('TEXT_PRODUCT_OPTIONS', '選んでください:  ');
define('TEXT_PRODUCT_MANUFACTURER', '製造元： ');
define('TEXT_PRODUCT_WEIGHT', '積荷重量: ');
define('TEXT_PRODUCT_QUANTITY', ' 在庫ユニット');
define('TEXT_PRODUCT_MODEL', '機種： ');



// previous next product
define('PREV_NEXT_PRODUCT', '商品 ');
define('PREV_NEXT_FROM', ' より ');
define('IMAGE_BUTTON_PREVIOUS','前の項目');
define('IMAGE_BUTTON_NEXT','次の項目');
define('IMAGE_BUTTON_RETURN_TO_PRODUCT_LIST','商品リストに戻る');

// missing products
//define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

define('TEXT_ATTRIBUTES_PRICE_WAS',' [was: ');
define('TEXT_ATTRIBUTE_IS_FREE',' now is: Free]');
define('TEXT_ONETIME_CHARGE_SYMBOL', ' *');
define('TEXT_ONETIME_CHARGE_DESCRIPTION', ' 一時費用がかかります');
define('TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK','この数量には割引が適用されたです');
define('ATTRIBUTES_QTY_PRICE_SYMBOL', zen_image(DIR_WS_TEMPLATE_ICONS . 'icon_status_green.gif', TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK, 10, 10) . '&nbsp;');

define('ATTRIBUTES_PRICE_DELIMITER_PREFIX', ' ( ');
define('ATTRIBUTES_PRICE_DELIMITER_SUFFIX', ' )');
define('ATTRIBUTES_WEIGHT_DELIMITER_PREFIX', ' (');
define('ATTRIBUTES_WEIGHT_DELIMITER_SUFFIX', ') ');

?>