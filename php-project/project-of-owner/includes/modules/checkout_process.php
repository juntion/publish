<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEGIN');
use App\Services\Quote\QuoteService;

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
// if the customer is not logged on, redirect them to the time out page
//if(!in_array($_SESSION['payment'],array('globalcollect','paypal'))){
//  if (!$_SESSION['customer_id']) {
//	  if(!$_SESSION['customers_guest_id']){
//		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
//	  }
//  }
//}


//// confirm where link came from
//if (!strstr($_SERVER['HTTP_REFERER'], FILENAME_CHECKOUT_CONFIRMATION)) {
//  //    zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT,'','SSL'));
//}

// BEGIN CC SLAM PREVENTION
//if (!isset($_SESSION['payment_attempt'])) $_SESSION['payment_attempt'] = 0;
//$_SESSION['payment_attempt']++;
//$zco_notifier->notify('NOTIFY_CHECKOUT_SLAMMING_ALERT');
//if ($_SESSION['payment_attempt'] > 3) {
//  $zco_notifier->notify('NOTIFY_CHECKOUT_SLAMMING_LOCKOUT');
//  $_SESSION['cart']->reset(TRUE);
//  zen_session_destroy();
//  zen_redirect(zen_href_link(FILENAME_TIME_OUT));
//}
// END CC SLAM PREVENTION

//if (!isset($credit_covers)) $credit_covers = FALSE;


/*if ($_GET['o_id'])
{
	$orders_id = urldecode($_GET['o_id']);
	$db->Execute("update " . TABLE_ORDERS . ' set orders_status = 1 where orders_id = ' . $orders_id);
	zen_redirect(zen_href_link("checkout_success", '', 'SSL'));
}else
{
	zen_redirect(zen_href_link("shopping_cart",'','SSL'));
}*/


$quotes_s = new QuoteService();
//
//// load selected payment module
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($_SESSION['payment']);
//// load the selected shipping module
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

require(DIR_WS_CLASSES . 'order.php');
if(isset($_SESSION['req_qreoid']) && $_SESSION['payment'] != 'hsbc' &&  $_SESSION['payment'] != 'paypalwpp' && $_SESSION['payment']!="purchase" && $_SESSION['payment']!="echeck" && $_SESSION['payment']!="alfa"){
	$order = new order($_SESSION['req_qreoid']);
}else{
    $sendTo = (int)$_GET['sendTo'];
    $billTo = (int)$_GET['billTo'];
    $quotes_id = (int)$_GET['quotes_id'];
    $inquiry_id = (int)$_GET['inquiry_id'];

    switch (true)
    {
        case $quotes_id > 0:
            $is_products = $quotes_s->getQuotesDataForCheckout($quotes_id);
            $order = new order('', $is_products, $sendTo, $billTo);
            break;
        case $inquiry_id > 0:
            require_once(DIR_WS_CLASSES . 'inquiry.class.php');
            $inquiry = new inquiry($currencies);
            $is_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$_GET['inquiry_id']);
            $order = new order('', $is_products, $sendTo, $billTo);
            break;
        default:
            $order = new order('', '', $sendTo, $billTo);
            $is_products = $_SESSION['cart']->get_checked_products()['checkedProducts'];
            break;
    }

    if (!zen_not_null($order->info['subtotal'])){
        zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
        exit;
    }
}

//// prevent 0-entry orders from being generated/spoofed
if(in_array($_SESSION['payment'],array("hsbc","paypalwpp"))){
	if (empty($is_products)) {
	 zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
	}
}
//
require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total;
//
//
//
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PRE_CONFIRMATION_CHECK');
if (strpos($GLOBALS[$_SESSION['payment']]->code, 'paypal') !== 0) {
  $order_totals = $order_total_modules->pre_confirmation_check();
}
//if ($credit_covers === TRUE)
//{
//	$order->info['payment_method'] = $order->info['payment_module_code'] = '';
//}
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PROCESS');
$order_totals = $order_total_modules->process();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_TOTALS_PROCESS');

//if (!isset($_SESSION['payment']) && $credit_covers === FALSE) {
//  zen_redirect(zen_href_link(FILENAME_DEFAULT));
//}

// load the before_process function from the payment modules
if ('paypalwpp' != $_SESSION['payment']){
$payment_modules->before_process();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_BEFOREPROCESS');
}
$payment_arr = array("paypal","globalcollect","skrill","bpay","eNETS","iDEAL","SOFORT","YANDEX","WEBMONEY");
if (!in_array($_SESSION['payment'],$payment_arr)) {
		if (in_array($_SESSION['payment'],array('paypalwpp','hsbc','purchase','echeck','alfa'))){

            switch (true)
            {
                case (int)$_GET['quotes_id'] > 0:
                    $products_s = $quotes_s->getQuotesDataForCheckout((int)$_GET['quotes_id']);
                    break;
                case (int)$_GET['inquiry_id'] > 0:
                    $products_s = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$_GET['inquiry_id']);
                    break;
                default:
                    $products_s = $_SESSION['cart']->get_checked_products()['checkedProducts'];
                    break;
            }

            if(sizeof($products_s)<= 0){
				zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
            }
			// create the order record
            $insertData = ['install' => $_SESSION['install'],'remarks' => $_SESSION['remarks']];
            $insert_id = $order->create_order_new($order_totals, $order_total_modules, $insertData);

            /*客户分配开始*/
            customerOrderToAdmin($insert_id);
            /*客户分配结束*/

			//更新echeck信息
			$order->update_echeck_info($insert_id);
            //更新俄罗斯对公支付alfa信息
            $order->update_alfa_info($insert_id);
            if(isset($_SESSION['install'])){
                unset($_SESSION['install']);
            }
            if(isset($_SESSION['remarks'])){
                unset($_SESSION['remarks']);
            }
			//订单生成后及时删除运输信息
            if(isset($_SESSION['related_email'])){
                unset($_SESSION['related_email']);
            }
			if(isset($_SESSION['customzones_info'])){
				unset($_SESSION['customzones_info']);
			}
			//订单生成后及时删除客户remark信息
			if(isset($_SESSION['customer_remarks'])){
				unset($_SESSION['customer_remarks']);
			}
			if(isset($_SESSION['customers_po'])){
				unset($_SESSION['customers_po']);
			}
			if(isset($_SESSION['echeck_info'])){
                unset($_SESSION['echeck_info']);
            }

//			$customers_po = $_SESSION['customer_po'];
//				if($customers_po && $insert_id){
//				$sql= " update orders set customers_po = '". $customers_po ."' where orders_id =".$insert_id;
//				$db->Execute($sql);
//			}

//			$customers_remarks=$_SESSION['customer_remarks'];
//			if($customers_remarks && $insert_id){
//				$sql= 'update orders set customers_remarks = "'.$customers_remarks.'" where orders_id ='.$insert_id;
//				$db->Execute($sql);
//			}

			$products_custom = $_SESSION['products_custom'];
			if($products_custom && $insert_id){
				$sql= 'update orders set products_custom = "'.$products_custom.'" where orders_id ='.$insert_id;
				$db->Execute($sql);
			}

			$need_invoice = $_SESSION['need_invoice'];
			if($insert_id && $need_invoice!=""){
				$sql= 'update orders set is_need_invoice = '.$need_invoice.' where orders_id ='.$insert_id;
				$db->Execute($sql);
			}
			//订单生成后及时删除客户自提信息
			if(isset($_SESSION['photo_name'] )){
				unset($_SESSION['photo_name'] );
			}
			if(isset($_SESSION["pick_email"])){
				unset($_SESSION["pick_email"]);
			}
			if(isset($_SESSION['pick_phone'] )){
				unset($_SESSION['pick_phone'] );
			}
			if(isset($_SESSION["pick_time"])){
				unset($_SESSION["pick_time"]);
			}
			if ('paypalwpp' == $_SESSION['payment']) {
				if($insert_id){
					$orderNmber = $db->getAll("select orders_number from orders where orders_id = '$insert_id'");
					$orderNmber = $orderNmber ? $orderNmber[0]['orders_number'] : "";
				}
				$payment_modules->before_process();
				$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_BEFOREPROCESS');
			}
			$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE');
			$payment_modules->after_order_create($insert_id);
			$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_AFTER_ORDER_CREATE');
			// store the product info to the order
			$_SESSION['order_number_created'] = $insert_id;
			$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE_ADD_PRODUCTS');

            //send email notifications 发送下单邮件放在客户分配下面 不然获取不到客户对应的销售
            $order = new order($insert_id);

            if (strtolower($order->info['payment_module_code']) == 'hsbc'){
                $order->sendTTOrderPendingEmail($insert_id);

            }elseif (strtolower($order->info['payment_module_code']) == 'purchase'){
                $order->send_fs_order_email($insert_id,false);
            }else{
                $order->send_order_email($insert_id, 2);
            }

			$_SESSION['order_number_created'] = $order->info['orders_number'];
			$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_SEND_ORDER_EMAIL');


			// clear slamming protection since payment was accepted
			if (isset($_SESSION['payment_attempt'])) unset($_SESSION['payment_attempt']);

			/**
			 * Calculate order amount for display purposes on checkout-success page as well as adword campaigns etc
			 * Takes the product subtotal and subtracts all credits from it
			 */
			//   $ototal = $order_subtotal = $credits_applied = 0;
			//   for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
			//     if ($order_totals[$i]['code'] == 'ot_subtotal') $order_subtotal = $order_totals[$i]['value'];
			//     if ($$order_totals[$i]['code']->credit_class == true) $credits_applied += $order_totals[$i]['value'];
			//     if ($order_totals[$i]['code'] == 'ot_total') $ototal = $order_totals[$i]['value'];
			//     if ($order_totals[$i]['code'] == 'ot_tax') $otax = $order_totals[$i]['value'];
			//     if ($order_totals[$i]['code'] == 'ot_shipping') $oshipping = $order_totals[$i]['value'];
			//   }
			//   $commissionable_order = ($order_subtotal - $credits_applied);
			//   $commissionable_order_formatted = $currencies->format($commissionable_order);

		      $_SESSION['order_summary']['orders_number'] = $order->info['orders_number'];
			//   $_SESSION['order_summary']['order_subtotal'] = $order->info['subtotal'];
			//   $_SESSION['order_summary']['credits_applied'] = $credits_applied;
			 // $_SESSION['order_summary']['orders_total'] = $order->info['total'];
			  $_SESSION['order_summary']['orders_total'] = $order_totals['ot_total']['text'];
			  $_SESSION['order_summary']['items'] = $order->info['items'];
			$_SESSION['order_main_id'] = $insert_id;
			//   $_SESSION['order_summary']['commissionable_order'] = $commissionable_order;
			//   $_SESSION['order_summary']['commissionable_order_formatted'] = $commissionable_order_formatted;
			//   $_SESSION['order_summary']['coupon_code'] = $order->info['coupon_code'];
			//   $_SESSION['order_summary']['currency_code'] = $order->info['currency'];
			//   $_SESSION['order_summary']['currency_value'] = $order->info['currency_value'];
			//   $_SESSION['order_summary']['payment_module_code'] = $order->info['payment_module_code'];
			  $_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $order->info['shipping_method']);
			  $_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
			//   $_SESSION['order_summary']['tax'] = $otax;
			//   $_SESSION['order_summary']['shipping'] = $oshipping;
			 // $_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
			  if($_SESSION['payment'] == 'paypalwpp' || $_SESSION['payment'] == "echeck" || $_SESSION['payment'] == "alfa"){
				  $_SESSION['order_summary']['payment_method'] = $order->info['payment_module_code'];
			  }else{
				  $_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
			  }
            if($_SESSION['payment'] == "alfa"){
                $_SESSION['order_summary']['alfa_phone'] = $_SESSION['alfa_info']['alfa_phone'];
                $_SESSION['order_summary']['alfa_email'] = $_SESSION['alfa_info']['alfa_email'];
            }
            if(isset($_SESSION['alfa_info'])){
                unset($_SESSION['alfa_info']);
            }
            if(isset($_SESSION['shipping_delay'])){
                unset($_SESSION['shipping_delay']);
            }
            if(isset($_SESSION['shipping_local'])){
                unset($_SESSION['shipping_local']);
            }
            if(isset($_SESSION['useUpsDefaultAddress'])){
                unset($_SESSION['useUpsDefaultAddress']);
            }
}
}


$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_HANDLE_AFFILIATES');

