<?php 

class get_shipping_address
{
//	var $contact_info,$shipping_address,$billing_address;
	
	
	function get_shipping_address($customers_id,$from_order = false)
	{
		    //init array
//			$this->contact_info = array();
//			$this->shipping_address = array();
//			$this->billing_address = array();
			
			// fill info to array
			$this->contact_info = $this->get_contact_info($customers_id);
			
			//use the second parameter to judge which function to use
			if ($from_order) {
				$this->shipping_address = $this->get_shipping_address_from_order($customers_id);
				$this->billing_address = $this->get_billing_address_from_order($customers_id);				
			}else
			{
					$this->shipping_address = $this->get_shipping_address_from_address_book($customers_id);
					
					/*check if the billing address exist*/
				
					if (!isset($_SESSION['billto']))
					{
						$this->billing_address = array(
										'billing_name' => $this->shipping_address['delivery_name'],
										'billing_street_address' => $this->shipping_address['delivery_street_address'],
										'billing_suburb' => $this->shipping_address['delivery_suburb'],
										'billing_city' => $this->shipping_address['delivery_city'],
										'billing_state' => $this->shipping_address['delivery_state'],
										'billing_country' => $this->shipping_address['delivery_country'],
										'billing_postcode' => $this->shipping_address['delivery_postcode']							
						);
					}else 
					{
						$this->billing_address = $this->get_billing_address_from_address_book();
					}
			}
	}
	
	function get_contact_info($customers_id)
	{
		global $db;
		$information = array();
		$cusomter_info = $db->Execute("select customers_firstname,customers_lastname ,customers_email_address,customers_telephone,customers_fax from " . TABLE_CUSTOMERS . " where customers_id = " . $customers_id);
		$information['customers_firstname'] = $cusomter_info->fields['customers_firstname'];
		$information['customers_lastname'] = $cusomter_info->fields['customers_lastname'];
		$information['customers_email_address'] = $cusomter_info->fields['customers_email_address'];
		if ($cusomter_info->fields['customers_telephone']) {
			$information['customers_telephone'] = $cusomter_info->fields['customers_telephone'];
		}
		if ($cusomter_info->fields['customers_fax']) {
			$information['customers_fax'] = $cusomter_info->fields['customers_fax'];
		}	
		
		return $information;
	}
	
	function get_shipping_address_from_order($customers_id)
	{
		global $db;
		$shipping_address_temp = array();
		
		$customer_order_info = $db->Execute("select delivery_name,
													delivery_street_address,
													delivery_suburb,
													delivery_city,
													delivery_postcode,
													delivery_state,
													delivery_country
													from " . TABLE_ORDERS . " where customers_id = " . $customers_id . " order by orders_id desc limit 1");
		$shipping_address_temp['delivery_name'] = $customer_order_info->fields['delivery_name'];
		$shipping_address_temp['delivery_street_address'] = $customer_order_info->fields['delivery_street_address'];
		$shipping_address_temp['delivery_suburb'] = $customer_order_info->fields['delivery_suburb'];
		$shipping_address_temp['delivery_city'] = $customer_order_info->fields['delivery_city'];
		$shipping_address_temp['delivery_postcode'] = $customer_order_info->fields['delivery_postcode'];
		$shipping_address_temp['delivery_state'] = $customer_order_info->fields['delivery_state'];
		$shipping_address_temp['delivery_country'] = $customer_order_info->fields['delivery_country'];
		return  $shipping_address_temp;
	}
	
	
	function get_billing_address_from_order($customers_id)
	{
		global $db;
		$billing_address_temp = array();
		
		$customer_order_info = $db->Execute("select billing_name,
													billing_street_address,
													billing_suburb,
													billing_city,
													billing_postcode,
													billing_state,
													billing_country
													from " . TABLE_ORDERS . " where customers_id = " . $customers_id . " order by orders_id desc limit 1");
		
		$billing_address_temp['billing_name'] = $customer_order_info->fields['billing_name'];
		$billing_address_temp['billing_street_address'] = $customer_order_info->fields['billing_street_address'];
		$billing_address_temp['billing_suburb'] = $customer_order_info->fields['billing_suburb'];
		$billing_address_temp['billing_city'] = $customer_order_info->fields['billing_city'];
		$billing_address_temp['billing_postcode'] = $customer_order_info->fields['billing_postcode'];
		$billing_address_temp['billing_state'] = $customer_order_info->fields['billing_state'];
		$billing_address_temp['billing_country'] = $customer_order_info->fields['billing_country'];
		
		return $billing_address_temp;
		
	}
	
	function get_shipping_address_from_address_book($customers_id)
	{
		global $db;
		$shipping_address_temp = array();
		$customer_address = $db->Execute("select entry_firstname,
												 entry_lastname,
												 entry_street_address,
												 entry_suburb,
												 entry_postcode,
												 entry_city,
												 entry_state,
												 entry_country_id,
												 entry_zone_id
												 from " . TABLE_ADDRESS_BOOK . " as ab, " . TABLE_CUSTOMERS . " as c where ab.address_book_id = c.customers_default_address_id and c.customers_id = " . $customers_id);
		/*$shipping_address_temp['entry_firstname'] = $customer_address->fields['entry_firstname'];
		$shipping_address_temp['entry_lastname'] = $customer_address->fields['entry_lastname'];*/
		$shipping_address_temp['delivery_name'] = $customer_address->fields['entry_firstname'] . ' ' . $customer_address->fields['entry_lastname'];
		$shipping_address_temp['delivery_street_address'] = $customer_address->fields['entry_street_address'];
		$shipping_address_temp['delivery_suburb'] = $customer_address->fields['entry_suburb'];
		$shipping_address_temp['entry_postcode'] = $customer_address->fields['entry_postcode'];
		$shipping_address_temp['delivery_city'] = $customer_address->fields['entry_city'];
		$shipping_address_temp['delivery_state'] = $customer_address->fields['entry_state'];
		
		$countries = $db->Execute("select countries_name from " . TABLE_COUNTRIES . " where countries_id = " . $customer_address->fields['entry_country_id']);
		$shipping_address_temp['delivery_country'] = $countries->fields['countries_name'];
		
		return $shipping_address_temp;
	}
	
	function get_billing_address_from_address_book()
	{
		global $db;
		$billing_address_temp = array();
		$customer_address = $db->Execute("select entry_firstname,
												 entry_lastname,
												 entry_street_address,
												 entry_suburb,
												 entry_postcode,
												 entry_city,
												 entry_state,
												 entry_country_id,
												 entry_zone_id
												 from " . TABLE_ADDRESS_BOOK ." where address_book_id = " . $_SESSION['billto']);
		/*$shipping_address_temp['entry_firstname'] = $customer_address->fields['entry_firstname'];
		$shipping_address_temp['entry_lastname'] = $customer_address->fields['entry_lastname'];*/
		$billing_address_temp['billing_name'] = $customer_address->fields['entry_firstname'] . ' ' . $customer_address->fields['entry_lastname'];
		$billing_address_temp['billing_street_address'] = $customer_address->fields['entry_street_address'];
		$billing_address_temp['billing_suburb'] = $customer_address->fields['entry_suburb'];
		$billing_address_temp['entry_postcode'] = $customer_address->fields['entry_postcode'];
		$billing_address_temp['billing_city'] = $customer_address->fields['entry_city'];
		$billing_address_temp['billing_state'] = $customer_address->fields['entry_state'];
		
		$countries = $db->Execute("select countries_name from " . TABLE_COUNTRIES . " where countries_id = " . $customer_address->fields['entry_country_id']);
		$billing_address_temp['billing_country'] = $countries->fields['countries_name'];
		
		return $billing_address_temp;
	}
}