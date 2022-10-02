<?php 
function zen_get_order_has_admin_of_id($oid){
global $db;
$sql = "select order_to_admin_id,admin_id from order_to_admin where orders_id=".(int)$oid;
$orders = $db->Execute($sql);
if($orders->fields['order_to_admin_id']){
return $orders->fields['admin_id'];
}
}

function zen_get_order_create_time($oid){
global $db;
$sql = " select date_purchased from orders where orders_id=".(int)$oid;
$orders = $db->Execute($sql);
return $orders->fields['date_purchased'];
}

function zen_get_create_order_to_customers_admin_id($oid){
global $db;
 $sql ="select * from create_order_to_customer where orders_id='".$oid ."' order by create_orders_id desc limit 1 ";
 $order = $db->Execute($sql);
 return $order->fields['admin_id'];
}

function zen_get_create_order_to_customers_create_time($oid){
global $db;
 $sql ="select * from create_order_to_customer where orders_id='".$oid ."' order by create_orders_id desc limit 1 ";
 $order = $db->Execute($sql);
 return $order->fields['create_time'];
}
function zen_get_product_payment_customers_admin_id($oid){
global $db;
 $sql ="select * from payment_link where order_id='".$oid ."' order by id desc limit 1 ";
 $order = $db->Execute($sql);
 return $order->fields['admin_id'];
}


function zen_get_create_order_to_customers_po_no($oid){
global $db;
 $sql ="select * from create_order_to_customer where orders_id='".$oid ."' order by create_orders_id desc limit 1 ";
 $order = $db->Execute($sql);
 return $order->fields['po_no'];
}

function zen_get_order_to_customers_po_no($oid){
 global $db;
 $sql ="select customers_po from orders where orders_id='".$oid ."'  limit 1 ";
 $order = $db->Execute($sql);
 return $order->fields['customers_po'];
}


function zen_get_order_payment_method($oid){
global $db;
$sql = "select payment_method from orders where orders_id =".$oid;
$order = $db->Execute($sql);
return $order->fields['payment_method'];
}

function zen_get_order_shipping_method($oid){
global $db;
$sql = "select shipping_module_code from orders where orders_id =".$oid;
$order = $db->Execute($sql);
return $order->fields['shipping_module_code'];
}


function zen_get_order_currency($oid){
global $db;
$sql = "select currency from orders where orders_id =".$oid;
$order = $db->Execute($sql);
return $order->fields['currency'];
}
function zen_get_customer_name_email($cid){
	global $db;
	$get_info = $db->Execute("select customers_email_address from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$cid); 
	
	return $get_info->fields['customers_email_address'];
}

function zen_get_customers_firstname($cid){
	global $db;
	$get_info = $db->Execute("select customers_firstname from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$cid); 
	
	return $get_info->fields['customers_firstname'];
}

function zen_get_customers_lastname($cid){
	global $db;
	$get_info = $db->Execute("select customers_lastname from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$cid); 
	
	return $get_info->fields['customers_lastname'];
}

function zen_get_customer_telephone($cid){
    global $db;
    $get_info = $db->Execute("select customers_telephone from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$cid);

    return $get_info->fields['customers_telephone'];
}
?>