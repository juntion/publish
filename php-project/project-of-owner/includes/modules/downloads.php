<?php
/**
 * downloads module - prepares information for use in downloadable files delivery
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: downloads.php 3018 2006-02-12 21:04:04Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
if (!($_GET['main_page']==FILENAME_ACCOUNT_HISTORY_INFO)) {
  // Get last order id for checkout_success
  $orders_lookup_query = "select orders_id
                     from " . TABLE_ORDERS . "
                     where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                     order by orders_id desc limit 1";

  $orders_lookup = $db->Execute($orders_lookup_query);
  $last_order = $orders_lookup->fields['orders_id'];
} else {
  $last_order = $_GET['order_id'];
}
				 
?>