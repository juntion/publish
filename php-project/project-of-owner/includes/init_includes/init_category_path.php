<?php
/**
 * pre-calculate the category path
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_category_path.php 16941 2010-07-21 19:59:44Z drbyte $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// get category path from new rewrite type
if (zen_not_null($_GET['cPath'])) {
	if (!strpos($_GET['cPath'],'_')){
		$_GET['cPath'] = zen_get_path_by_categories_id((int)$_GET['cPath']);
	}else {
		$acture_category_id = substr($_GET['cPath'], (strrpos($_GET['cPath'], '_')+1));
		$_GET['cPath'] = zen_get_path_by_categories_id((int)$acture_category_id);
	}
}
$show_welcome = false;
if (isset($_GET['cPath'])) {
  $cPath = $_GET['cPath'];
} elseif (isset($_GET['products_id']) ) {
  $cPath = zen_get_product_path($_GET['products_id']);
} else {
  if (SHOW_CATEGORIES_ALWAYS == '1' ) {
    $show_welcome = true;
    $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
  } else {
    $show_welcome = false;
    $cPath = '';
  }
}
if (zen_not_null($cPath)) {
  $cPath_array = zen_parse_category_path($cPath);
  $cPath = implode('_', $cPath_array);
  $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
} else {
  $current_category_id = 0;
  $cPath_array = array();
}
// determine whether the current page is the home page or a product listing
//$this_is_home_page = ($current_page=='index' && ((int)$cPath == 0 || $show_welcome == true));
$this_is_home_page = ($current_page=='index' && (!isset($_GET['cPath']) || $_GET['cPath'] == '') && (!isset($_GET['manufacturers_id']) || $_GET['manufacturers_id'] == '') && (!isset($_GET['typefilter']) || $_GET['typefilter'] == '') );
