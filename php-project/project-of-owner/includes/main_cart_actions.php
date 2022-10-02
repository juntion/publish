<?php
/**
 * Main shopping Cart actions supported.
 *
 * The main cart actions supported by the current shoppingCart class.
 * This can be added to externally using the extra_cart_actions directory.
 *
 * @package initSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_cart_actions.php 6644 2007-07-27 09:12:36Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * include the list of extra cart action files  (*.php in the extra_cart_actions folder)
 */
if ($za_dir = @dir(DIR_WS_INCLUDES . 'extra_cart_actions')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/\.php$/', $zv_file) > 0) {
      /**
       * get user/contribution defined cart actions
       */
      include(DIR_WS_INCLUDES . 'extra_cart_actions/' . $zv_file);
    }
  }
  $za_dir->close();
}
switch ($_GET['action']) {
  /**
   * customer wants to update the product quantity in their shopping cart
   * delete checkbox or 0 quantity removes from cart
   */
  case 'update_product' :
  $_SESSION['cart']->actionUpdateProduct($goto, $parameters);
  break;
  /**
   * customer adds a product from the products page
   */
  case 'add_product' :
  /*bof remove products from wish list*/
  	/*if ($_POST&& $_POST['type'] == "remove_from_list")
  	{
  		$db->Execute("delete from " . TABLE_WISHLIST . " where products_id = " .$_POST['products_id']);
  	}*/
  /*eof remove products from wish list*/
  $cn_local_qty='';
  if($_GET['cn_local_qty']){
      $cn_local_qty = $_GET['cn_local_qty'];
  }
  if($_GET['custom_product'] ==1 && isset($_GET['custom_product'])){
      $parameters = $_GET['custom_product'];
  }else{
      $parameters = '';
  }
  //var_dump($goto);//shopping_cart
  //exit;
  $_SESSION['cart']->actionAddProduct($goto, $parameters, $cn_local_qty);
//  $cart_popup = '';
//  if(isset($_POST['products_id']) && $_POST['cart_quantity']>0){
//      $cart_popup = products_add_cart_popup($_POST['products_id'],$_POST['cart_quantity']);
//  }
//  exit(json_encode(array('cart_popup'=>$cart_popup)));
  break;
  case 'buy_now' :
  /**
   * performed by the 'buy now' button in product listings and review page
   */
  $_SESSION['cart']->actionBuyNow($goto, $parameters);
  break;
  case 'multiple_products_add_product' :
  /**
   * performed by the multiple-add-products button
   */
  $_SESSION['cart']->actionMultipleAddProduct($goto, $parameters);
  break;
  case 'cust_order' :
  $_SESSION['cart']->actionCustomerOrder($goto, $parameters);
  break;
  case 'remove_product' :
  $_SESSION['cart']->actionRemoveProduct($goto, $parameters);
  break;
    //delete all shopping cart products
  case 'remove_all':
  $_SESSION['cart']->actionRemoveAllProduct($goto, $parameters);
  break;
  
  case 'cart' :
  $_SESSION['cart']->actionCartUserAction($goto, $parameters);
  break;
  case 'empty_cart' :
  $_SESSION['cart']->reset(true);
  break;
  case 'ajax_update_product' :
    $_SESSION['cart']->AjaxUpdateProduct($goto, $parameters);
    exit;
  break;
  case 'ajax_update_save_product' :
    $_SESSION['save_cart']->AjaxUpdateSaveProduct($goto, $parameters);
    exit;
    break;
  case 'ajax_solution_add_products';
      $_SESSION['cart']->solutionAddProducts();
      exit;
      break;
}
?>