<?php
/**
 * Multi Cross Sell products
 *
 * Derived from:
 * Original Idea From Isaac Mualem im@imwebdesigning.com <mailto:im@imwebdesigning.com>
 * Portions Copyright (c) 2002 osCommerce
 * Complete Recoding From Stephen Walker admin@snjcomputers.com
 * license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 *
 * Adapted to Zen Cart by Merlin - Spring 2005
 * Reworked for Zen Cart v1.3.0  03-30-2006
 *
 * Add Multi Cross Sells by Gilby 2010-06-26
 */


// in case admin switches aren't added properly, assume default settings:
if (!defined('MAX_DISPLAY_XSELL'.$mxsell)) define('MAX_DISPLAY_XSELL'.$mxsell,6);
if (!defined('MIN_DISPLAY_XSELL'.$mxsell)) define('MIN_DISPLAY_XSELL'.$mxsell,1);
if (!defined('XSELL'.$mxsell.'_DISPLAY_NAME')) define('XSELL'.$mxsell.'_DISPLAY_PRICE','true');
if (!defined('XSELL'.$mxsell.'_DISPLAY_MODEL')) define('XSELL'.$mxsell.'_DISPLAY_MODEL','true');
if (!defined('XSELL'.$mxsell.'_DISPLAY_PRICE')) define('XSELL'.$mxsell.'_DISPLAY_PRICE','false');
if (!defined('XSELL'.$mxsell.'_DISPLAY_BUY_NOW')) define('XSELL'.$mxsell.'_DISPLAY_PRICE','false');
if (!defined('SHOW_PRODUCT_INFO_COLUMNS_XSELL'.$mxsell.'_PRODUCTS')) define('SHOW_PRODUCT_INFO_COLUMNS_XSELL'.$mxsell.'_PRODUCTS',3);

// collect information on available cross-sell products for the current product-id
if (isset($_GET['products_id']) && constant(SHOW_PRODUCT_INFO_COLUMNS_XSELL . $mxsell . _PRODUCTS) > 0 ) {
  $xsell_sort_by = constant(XSELL_SORT_ORDER . $mxsell)=="sort_order"?" order by xp.sort_order asc ": " order by rand() ";
  $xsell_query = $db->Execute("select distinct p.products_id, p.products_image, pd.products_name
                   from " . TABLE_PRODUCTS_MXSELL . $mxsell . " xp, " . TABLE_PRODUCTS . " p, " .
                   TABLE_PRODUCTS_DESCRIPTION . " pd
                   where xp.products_id = '" . $_GET['products_id'] . "'
                   and xp.xsell_id = p.products_id
                   and p.products_id = pd.products_id
                   and pd.language_id = '" . $_SESSION['languages_id'] . "'
                   and p.products_status = 1 ".
                   $xsell_sort_by." limit " . constant(MAX_DISPLAY_XSELL . $mxsell) );

  $num_products_xsell = $xsell_query->RecordCount();

  // don't display if less than the minimum amount set in Admin->Config->Minimum Values->Cross-Sell
  if ($num_products_xsell >= constant(MIN_DISPLAY_XSELL . $mxsell) && $num_products_xsell > 0) {
?>
<!-- multi cross sell_products //-->
<?php
$row = 0;
$col = 0;
$list_box_contents = array();
$title='';
if ($num_products_xsell < constant(SHOW_PRODUCT_INFO_COLUMNS_XSELL . $mxsell . _PRODUCTS) || constant(SHOW_PRODUCT_INFO_COLUMNS_XSELL . $mxsell . _PRODUCTS)==0) {
  $col_width = floor(100/$num_products_xsell);
} else {
  $col_width = floor(100/constant(SHOW_PRODUCT_INFO_COLUMNS_XSELL . $mxsell . _PRODUCTS));
}
while (!$xsell_query->EOF) {
  if (zen_has_product_attributes((int)$xsell_query->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {    
    $lc_button = '<br /><a href="' . zen_href_link(zen_get_info_page((int)$xsell_query->fields['products_id']),  '&products_id=' . (int)$xsell_query->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a><br />';
   } else {
     $lc_button = '<br /><a href="' . zen_href_link($_GET['main_page'], 'action=buy_now&products_id=' . (int)$xsell_query->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
}

  $xsell_query->fields['products_name'] = zen_get_products_name($xsell_query->fields['products_id']);
  $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsCrossSell centeredContent back"' . ' ' .  'style="width:' . $col_width . '%;"',
'text' => '<div class="listingProductImage" style="margin-top: 5px; margin-bottom: 5px;"><a href="' . zen_href_link(zen_get_info_page($xsell_query->fields['products_id']), 'products_id=' . (int)$xsell_query->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $xsell_query->fields['products_image'], $xsell_query->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>'. 

  (constant(XSELL.$mxsell._DISPLAY_NAME)=='true'? '<div class="itemTitle"><h4 class="itemTitle"><a href="' . zen_href_link(zen_get_info_page($xsell_query->fields['products_id']), 'products_id=' . (int)$xsell_query->fields['products_id']) . '">' . $xsell_query->fields['products_name'] . '</a></h4></div>':'').

  (constant(XSELL.$mxsell._DISPLAY_MODEL)=='true'? '<div class="itemModel"><h4 class="itemTitle"><a href="' . zen_href_link(zen_get_info_page($xsell_query->fields['products_id']), 'products_id=' . (int)$xsell_query->fields['products_id']) . '">' . zen_products_lookup($xsell_query->fields['products_id'], 'products_model') . '</a></h4></div>':'').

  (constant(XSELL.$mxsell._DISPLAY_PRICE)=='true'? '<div class="price">'.zen_get_products_display_price($xsell_query->fields['products_id']).'</div>':'') .

  (constant(XSELL.$mxsell._DISPLAY_BUY_NOW)=='true'? '<div class="listingBuyNowButton">'.$lc_button.'</div>':'') );
      
  $col ++;
  if ($col > (constant(SHOW_PRODUCT_INFO_COLUMNS_XSELL . $mxsell . _PRODUCTS) -1)) {
    $col = 0;
    $row ++;
  }
  $xsell_query->MoveNext();
}
// store data into array for display later where desired:
$xsell_data = $list_box_contents;
  }
}
?>