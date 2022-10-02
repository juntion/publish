<?php 
function zen_get_orders_tracking_number($oid,$number_id = 1){
 global $db;
  $orders = $db->Execute("select tracking_number from order_tracking_info where orders_id='".(int)$oid ."' and number_id = '" . (int)$number_id ."' order by order_tracking_id desc limit 1");
 return  $orders->fields['tracking_number'];
}

function zen_get_orders_shipping_method($oid,$number_id = 1){
    global $db;
    $orders = $db->Execute("select shipping_method from order_tracking_info where orders_id='".(int)$oid ."' and number_id = '" . (int)$number_id ."' order by order_tracking_id desc limit 1");
    return  $orders->fields['shipping_method'];
}
?>