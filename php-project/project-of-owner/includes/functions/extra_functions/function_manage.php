<?php

//判断是否为主订单
function  fs_orders_products_is_main($oid){

        global  $db;
        $list = $db->Execute("select main_order_id from orders where  orders_id = '".$oid."'");
        if($list->fields['main_order_id']){
            return true;
        }else{
            return  false;
        }

}
?>