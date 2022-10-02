<?php
/**
 * create the breadcrumb trail
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_add_crumbs.php 16607 2010-06-03 12:37:20Z drbyte $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$breadcrumb->add(HEADER_TITLE_CATALOG, zen_href_link(FILENAME_DEFAULT),'');
/**
 * add category names or the manufacturer name to the breadcrumb trail
 */
$robotsNoIndex = false;

if($_GET['categories'] && $_GET['main_page'] == FILENAME_PRODUCTS_SEARCH){
	$cPath_array = (array_reverse(get_category_parent_id($_GET['categories'],array())));
}


// might need isset($_GET['cPath']) later ... right now need $cPath or breaks breadcrumb from sidebox etc.
if (isset($cPath_array) && isset($cPath)) {
	if(isset($_SESSION['fiber_connector']) && $_SESSION['fiber_connector'] && $cPath[0] == 209){
        if($_GET['main_page'] == 'product_info'){
            $breadcrumb->add($_SESSION['fiber_categories_name'][1],$_SESSION['fiber_categories_name'][2],$_SESSION['fiber_categories_name'][3]);
            $breadcrumb->add($_SESSION['fiber_connector'],$_SESSION['fiber_connector_url'],$_SESSION['fiber_connector_id']);
        }
    }else{
        if($_GET['main_page']!='products_support'){
            for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
                $categories_query = "select categories_name
                           from " . TABLE_CATEGORIES_DESCRIPTION . "
                           where categories_id = '" . (int)$cPath_array[$i] . "'
                           and language_id = '" . (int)$_SESSION['languages_id'] . "'";

                $categories = $db->Execute($categories_query);
                //echo 'I SEE ' . (int)$cPath_array[$i] . '<br>';
                if ($categories->RecordCount() > 0) {
//      	        $breadcrumb->add($categories->fields['categories_name'], zen_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
//			        $breadcrumb->add($categories->fields['categories_name'], HTTP_SERVER.'/'.preg_replace('/(\/|[[:space:]]{1,})/i', '-', $categories->fields['categories_name']).'-c' . implode('_', array_slice($cPath_array, 0, ($i+1))));
    		        $categories_name = $categories->fields['categories_name'];
                    if (4 < $n && isset($_GET['products_id'])) {
                        $categories_name = (isset($categories_name{16})) ? mb_substr($categories_name,0,20,'utf-8').'...' : $categories_name;
                    }
                    $breadcrumb->add($categories_name, zen_href_link(FILENAME_DEFAULT,'cPath='.$cPath_array[$i]), $cPath_array[$i]);
                } elseif(SHOW_CATEGORIES_ALWAYS == 0) {
                    // if invalid, set the robots noindex/nofollow for this page
                    $robotsNoIndex = true;
                    break;
                }
            }
        }
    }
}
