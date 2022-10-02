<?php 

class save_customer_info
{
	
	function save_customer_info($info)
	{
		global $db;
		$state = 0;
		if (is_array($info))
		{
			$query = "select zone_id from " . TABLE_ZONES . " where 	zone_name = '" . $info['shipping_state'] . "'";
			$zones = $db->Execute($query);
			if ($zones->RecordCount() > 0)
			{
				$state = $zones->fields['zoneid'];
			}
			
			$shipping_info = array('customers_id'=>$_SESSION['customer_id'],
									'entry_gender'=>'0',
									'entry_company'=>$info['shipping_company'],
									'entry_firstname'=>$info['shipping_firstname'],
									'entry_lastname'=>$info['shipping_lastname'],
									'entry_street_address'=>$info['shipping_address'],
									'entry_suburb'=>$info['shipping_address2'],
									'entry_postcode'=>$info['shipping_address2'],
									'entry_city'=>$info['shipping_city'],
									'entry_state'=>$info['shipping_state'],
									'entry_country_id'=>(int)$info['shipping_country'],
									'entry_zone_id'=>$state);
			
			
			
			$query = "select zone_id from " . TABLE_ZONES . " where 	zone_name = '" . $info['billing_state']. "'";
			$zones = $db->Execute($query);
			if ($zones->RecordCount() > 0)
			{
				$state = $zones->fields['zoneid'];
			}
			
			$billing_info = array('customers_id'=>$_SESSION['customer_id'],
									'entry_gender'=>'0',
									'entry_company'=>$info['billing_company'],
									'entry_firstname'=>$info['billing_firstname'],
									'entry_lastname'=>$info['billing_lastname'],
									'entry_street_address'=>$info['billing_address'],
									'entry_suburb'=>$info['billing_address2'],
									'entry_postcode'=>$info['billing_address2'],
									'entry_city'=>$info['billing_city'],
									'entry_state'=>$info['billing_state'],
									'entry_country_id'=>(int)$info['billing_country'],
									'entry_zone_id'=>$state);
			
			
			zen_db_perform(TABLE_ADDRESS_BOOK,$shipping_info);
			$_SESSION['sendto'] = $db->insert_ID();
			zen_db_perform(TABLE_ADDRESS_BOOK,$billing_info);
			$_SESSION['billto'] = $db->insert_ID();
		}
	}	
}