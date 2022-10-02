<?php
class fs_orders {
	function get_kevin_orders(){
		global $db;
		
		$get_info = $db->Execute("select orders_id from  " . TABLE_ORDERS . " where customers_name = 'kevin qin'");
		
		$orders = array();
		if($get_info->RecordCount()){
			while (!$get_info->EOF) {
				$orders [] = $get_info->fields['orders_id'];
				$get_info->MoveNext();
			}
		}
		return $orders;
	}
	
	
	function delete_orders(){
		global $db;
		$ids = $this->get_kevin_orders();
		if (sizeof($ids)){
			if (sizeof($ids) > 1){
				
				$ids_str = implode(',', $ids);
				$where_str = " where orders_id in(".$ids_str.")";
			}else if (1 == sizeof($ids)){
				$where_str = " where orders_id = ".(int)$ids[0].")";
			}
			$db->Execute("delete from " . TABLE_ORDERS . $where_str);
			$db->Execute("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . $where_str);
			$db->Execute("delete from " . TABLE_ORDERS_TOTAL . $where_str);
			$db->Execute("delete from " . TABLE_ORDERS_PRODUCTS . $where_str);
			$db->Execute("delete from " . TABLE_ORDERS_STATUS_HISTORY . $where_str);
			
		}
	}
}