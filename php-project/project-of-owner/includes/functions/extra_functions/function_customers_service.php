<?php

function  zen_get_fs_orders_name($oid){

	global $db;

	$list = $db->Execute("select orders_number from orders where orders_id = '".$oid."'");

	if($list->fields['orders_number']){

		return $list->fields['orders_number'];
	}
}



?>