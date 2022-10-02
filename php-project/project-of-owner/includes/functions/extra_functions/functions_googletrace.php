<?php 
  function zen_get_order_products_of_id($oid){
  global $db;
  $products_info = array();
  $products_sql="select orders_products_id,products_id,products_price,products_quantity FROM orders_products WHERE  orders_id ='". $oid ."' ";
  $products = $db->Execute($products_sql);
  
  while(!$products->EOF){
   $products_info [] = array(
             'products_id' =>  $products->fields['products_id'],
             'products_price' =>  $products->fields['products_price'],
             'products_quantity' =>  $products->fields['products_quantity']
      );
    $products->MoveNext();
   }
   return $products_info;
  }  
  
  function zen_get_order_date_purchased_of_id($oid){
  global $db;
  $order_info = "select date_purchased from orders where orders_id=".$oid;
  $order = $db->Execute($order_info);
  return $order->fields['date_purchased'];
  
  }
  
  function zen_get_shipping_time_of_order($oid){
  global $db;
  $order_info ="select addtime from orders_shipping where orders_id=".$oid;
  $order = $db->Execute($order_info);
  return $order->fields['addtime'];
  }
  
  function zen_get_order_products_qty_of_order_id($oid){
   global $db;
    $customer_query = "select  products_quantity  from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$oid . "' ";
    $customer = $db->Execute($customer_query);
   return $customer->fields['products_quantity'];
  }
  //delivery_country
   function zen_get_order_delivery_country_of_order_id($oid){
   global $db;
    $customer_query = "select  delivery_country  from " . TABLE_ORDERS . " where orders_id = '" . (int)$oid . "' ";
    $customer = $db->Execute($customer_query);
   return $customer->fields['delivery_country'];
  }
  
  function zen_get_order_number_of_order_id($oid){
   
  global $db;
      $customer_query = "select orders_number from orders where orders_id='".(int)$oid."' ";
    $customer = $db->Execute($customer_query);
    
    return $customer->fields['orders_number'];
  }
  
  function zen_get_customer_email_address_of_id($oid){
    global $db;
      $customer_query = "select customers_email_address from orders where orders_id='".(int)$oid."' ";
      $customer = $db->Execute($customer_query);
    
    return $customer->fields['customers_email_address'];
  }
 
  function zen_get_customer_country_of_id($cid){
    global $db;
      $customer_query = "select customer_country_id from customers where customers_id='".(int)$cid."' ";
    $customer = $db->Execute($customer_query);
    
    return $customer->fields['customer_country_id'];
  }
  
  function zen_get_customer_lasted_order_currency_of_id($oid){
    global $db;
      $customer_query = "select currency from orders where orders_id=".$oid;
    $customer = $db->Execute($customer_query);
    
    return $customer->fields['currency'];
 
  }
  
    function zen_get_customer_lasted_order_total_of_id($oid){
    global $db;
      $customer_query = "select order_total from orders where orders_id='".(int)$oid."' ";
    $customer = $db->Execute($customer_query);
    
    return $customer->fields['order_total'];
 
  }

?>