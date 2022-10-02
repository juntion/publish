<?php
/**
 * customer_account_info class
 */
class customer_account_info{
	/**
	 * 
	 * construct here ...
	 */
	function __construct(){
	}
	/**
	 * 
	 * check billing address exist
	 * @param int $address_book_id
	 */
	function billing_address_exist($address_book_id){
		global $db;
		$get_total = $db->Execute("select count(address_book_id) as total from " .TABLE_ADDRESS_BOOK . " where address_book_id = ". intval($address_book_id));
		return ($get_total->fields['total'] > 0) ? true : false;
	}
	/**
	 * get customer profile...
	 */
	function get_customer_profile(){
		global $db;
		$profile = array();
		$query_account_info = "SELECT customers_gender,customers_firstname,customers_lastname,customers_telephone,customer_country_id,
		customers_email,customers_type_id,customers_company,customers_email_address  
		 FROM ".TABLE_CUSTOMERS . " WHERE customers_id = :customers_id";
		$get_customer_info = $db->Execute($db->bindVars($query_account_info, ':customers_id',   intval($_SESSION['customer_id']), 'integer'));
		if ($get_customer_info->RecordCount()){
			$profile['customers_gender'] = $get_customer_info->fields['customers_gender'];
			$profile['customers_firstname'] = $get_customer_info->fields['customers_firstname'];
			$profile['customers_lastname'] = $get_customer_info->fields['customers_lastname'];
			$profile['customers_email'] = $get_customer_info->fields['customers_email'];
			$profile['customers_telephone'] = $get_customer_info->fields['customers_telephone'];
			$profile['customer_country_id'] = $get_customer_info->fields['customer_country_id'];
			$profile['customers_type_id'] = $get_customer_info->fields['customers_type_id'];
			$profile['customers_company'] = $get_customer_info->fields['customers_company'];
			$profile['customers_email_address'] = $get_customer_info->fields['customers_email_address'];
			
		}
		return $profile;
	}
	/**
	 * get customers type
	 */
	function get_customers_types(){
		global $db;
		$types = array();
		$query_types_info = "SELECT customers_type_id,customers_type_name  
		 FROM ".TABLE_CUSTOMERS_TYPE ." where language_id = '" . (int)$_SESSION['languages_id'] . "'  ORDER BY customers_type_id ";
		
		$get_customer_info = $db->Execute($query_types_info);
		if ($get_customer_info->RecordCount()){
			while (!$get_customer_info->EOF){
				$types [] = array(
					'id' => $get_customer_info->fields['customers_type_id'],
					'text' => $get_customer_info->fields['customers_type_name']
				);
				$get_customer_info->MoveNext();
			}
		}
		return $types;
	}
	
	/**
	 *update customer profile 
	 */
	function update_customer_profile(array $account_info){
		zen_db_perform(TABLE_CUSTOMERS, $account_info,'update','customers_id='.(int)$_SESSION['customer_id']);
	}
	
	/*function update_customer*/
	function get_customers_shipping_address($has_default = true){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,company_type,
			entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number, ticket_number FROM " . TABLE_ADDRESS_BOOK ."  as ab 
			INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id) 
			WHERE (entry_firstname != '' and  c.customers_id = :customers_id and ab.address_type!=2  and ab.entry_country_id NOT IN (54,199,101,205,112,102,224,121,20,41,118,154,192,229,235,239) )";
		
		if($default_bill_id = $this->get_default_billing_address_id()){
			//$query_addresses .= " AND address_book_id != ".(int)$default_bill_id;
		}
		$query_addresses .= " Group by address_book_id order by address_book_id DESC; ";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		if ($get_customer_info->RecordCount()) {
			while (!$get_customer_info->EOF){
				/*set default shipping address flag*/
				$is_default_shipping_address = false;
				if (intval($this->get_default_shipping_address_id()) == (int)$get_customer_info->fields['address_book_id']){
					$is_default_shipping_address = true;
				}
				if($has_default || (!$has_default && !$is_default_shipping_address)){ // 没有默认值时候，当时是默认值不展示
                    $entry_country_name = zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']);
                    $tel_prefix = zen_get_prefix($get_customer_info->fields['entry_country_id']);
                    $country_code = zen_get_country_iso_code($get_customer_info->fields['entry_country_id']);
                    $shipping_address [] = array(
                        'is_default' => $is_default_shipping_address,
                        'address_book_id' => $get_customer_info->fields['address_book_id'],
                        'entry_company' => $get_customer_info->fields['entry_company'],
                        'entry_firstname' => $get_customer_info->fields['entry_firstname'],
                        'entry_lastname' => $get_customer_info->fields['entry_lastname'],
                        'entry_street_address' => $get_customer_info->fields['entry_street_address'],
                        'entry_suburb' => $get_customer_info->fields['entry_suburb'],
                        'entry_postcode' => $get_customer_info->fields['entry_postcode'],
                        'entry_city' => $get_customer_info->fields['entry_city'],
                        'entry_state' => $get_customer_info->fields['entry_state'],
                        'entry_tax_number' => $get_customer_info->fields['entry_tax_number'],
                        'entry_country' => array(
                            'entry_country_id' => $get_customer_info->fields['entry_country_id'],
                            'entry_country_name' => $entry_country_name,
                            'tel_prefix' => $tel_prefix,
                            'country_code' => $country_code
                        ),
                        'entry_country_id' => $get_customer_info->fields['entry_country_id'],
                        'entry_country_name' => $entry_country_name,
                        'tel_prefix' => $tel_prefix,
                        'country_code' => $country_code,
                        'entry_zone_id' => $get_customer_info->fields['entry_zone_id'],
                        'entry_telephone' => $get_customer_info->fields['entry_telephone'],
                        "company_type" => $get_customer_info->fields['company_type'],
                        "address_type" => 0
                        //"ticket_number" => $get_customer_info->fields['ticket_number']
                    );
                }

				$get_customer_info->MoveNext();
			}
		}
		
		return $shipping_address;
	}
		function get_customers_guest_shipping_address(){
		global $db;
		$query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,company_type,
				entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number,email_address
				FROM " . TABLE_ADDRESS_BOOK ."  as ab 
				INNER JOIN " .TABLE_CUSTOMER_OF_GUEST . " as c ON ab.address_book_id = c.customers_default_address_id 
				WHERE entry_firstname != '' and  c.guest_id = :guest_id 
				";
		
		$query_addresses .= " Group by address_book_id order by address_book_id; ";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':guest_id', (int)$_SESSION['customers_guest_id'], 'integer'));
		if ($get_customer_info->RecordCount()) {
			while (!$get_customer_info->EOF){
				/*set default shipping address flag*/

				$shipping_address [] = array(
					'address_book_id' => $get_customer_info->fields['address_book_id'],
					'entry_company' => $get_customer_info->fields['entry_company'],
					'entry_firstname' => $get_customer_info->fields['entry_firstname'],
					'entry_lastname' => $get_customer_info->fields['entry_lastname'],
					'entry_street_address' => $get_customer_info->fields['entry_street_address'],
					'entry_suburb' => $get_customer_info->fields['entry_suburb'],
					'entry_postcode' => $get_customer_info->fields['entry_postcode'],
					'entry_city' => $get_customer_info->fields['entry_city'],
					'entry_state' => $get_customer_info->fields['entry_state'],
					'entry_tax_number' => $get_customer_info->fields['entry_tax_number'],
					'entry_country_id' => $get_customer_info->fields['entry_country_id'],
					'entry_country' => array(
						'entry_country_id' => $get_customer_info->fields['entry_country_id'],
						'entry_country_name' => zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']),
						'tel_prefix' => zen_get_prefix($get_customer_info->fields['entry_country_id'])
					),
					'entry_zone_id' => $get_customer_info->fields['entry_zone_id'],
					'entry_telephone' => $get_customer_info->fields['entry_telephone'],
					'entry_email' => $get_customer_info->fields['email_address'],
					"company_type" => $get_customer_info->fields['company_type']
				);
				$get_customer_info->MoveNext();
			}
		}
		
		return $shipping_address;
	}

	function get_customers_guest_billing_address(){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,company_type,
		entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number,c.email_address 
				FROM " . TABLE_ADDRESS_BOOK ."  as ab 
				INNER JOIN " .TABLE_CUSTOMER_OF_GUEST . " as c  ON ab.customers_guest_id = c.guest_id 
				WHERE entry_firstname != '' and  c.guest_id = :guest_id 
				and (address_type = 2 or address_book_id = customers_default_billing_address_id)
				";

		$query_addresses .= " Group by address_book_id order by address_book_id; ";
//		exit($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':guest_id', (int)$_SESSION['customers_guest_id'], 'integer'));
		if ($get_customer_info->RecordCount()) {
			while (!$get_customer_info->EOF){						
				$shipping_address [] = array(
					'address_book_id' => $get_customer_info->fields['address_book_id'],
					'entry_company' => $get_customer_info->fields['entry_company'],
					'entry_firstname' => $get_customer_info->fields['entry_firstname'],
					'entry_lastname' => $get_customer_info->fields['entry_lastname'],
					'entry_street_address' => $get_customer_info->fields['entry_street_address'],
					'entry_suburb' => $get_customer_info->fields['entry_suburb'],
					'entry_postcode' => $get_customer_info->fields['entry_postcode'],
					'entry_city' => $get_customer_info->fields['entry_city'],
					'entry_state' => $get_customer_info->fields['entry_state'],
					'entry_tax_number' => $get_customer_info->fields['entry_tax_number'],
					'entry_country' => array(
						'entry_country_id' => $get_customer_info->fields['entry_country_id'],
						'entry_country_name' => zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']),
						'tel_prefix' => zen_get_prefix($get_customer_info->fields['entry_country_id']),
						'country_code' =>  zen_get_country_iso_code($get_customer_info->fields['entry_country_id'])
					),
					'entry_country_id' => $get_customer_info->fields['entry_country_id'],
					'entry_zone_id' => $get_customer_info->fields['entry_zone_id'],
					'entry_telephone' => $get_customer_info->fields['entry_telephone'],
					'email_address' => $get_customer_info->fields['email_address'],
					'company_type' => $get_customer_info->fields['company_type']
				);
				$get_customer_info->MoveNext();
			}
		}
		
		return $shipping_address;
	}
	
	function get_customers_billing_address($has_default = true){
		global $db;
		$shipping_address = array();
//		$query_addresses = "SELECT distinct address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,company_type,
//				entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number
//				FROM " . TABLE_ADDRESS_BOOK ."  as ab
//				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id)
//				WHERE entry_firstname != '' and  c.customers_id = :customers_id
//				and (address_type = 2)
//				";
//		$query_addresses .= " Group by address_book_id order by address_book_id; ";

        // 新版 2018.12.11  账单地址可以多个
        $query_addresses = "SELECT  address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,company_type,
				entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number , ticket_number
				FROM " . TABLE_ADDRESS_BOOK ." 
				WHERE entry_firstname != '' and  customers_id = :customers_id 
				and (address_type = 2)";
//		exit($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		if ($get_customer_info->RecordCount()) {
			while (!$get_customer_info->EOF){
				$is_default_shipping_address = false;
				if (intval($this->get_default_billing_address_id()) == (int)$get_customer_info->fields['address_book_id']){
					$is_default_shipping_address = true;
				}
                if($has_default || (!$has_default && !$is_default_shipping_address)) { // 没有默认值时候，当时是默认值不展示
                    $entry_country_name = zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']);
                    $tel_prefix = zen_get_prefix($get_customer_info->fields['entry_country_id']);
                    $country_code = zen_get_country_iso_code($get_customer_info->fields['entry_country_id']);
                    $shipping_address [] = array(
                        'is_default' => $is_default_shipping_address,
                        'address_book_id' => $get_customer_info->fields['address_book_id'],
                        'entry_company' => $get_customer_info->fields['entry_company'],
                        'entry_firstname' => $get_customer_info->fields['entry_firstname'],
                        'entry_lastname' => $get_customer_info->fields['entry_lastname'],
                        'entry_street_address' => $get_customer_info->fields['entry_street_address'],
                        'entry_suburb' => $get_customer_info->fields['entry_suburb'],
                        'entry_postcode' => $get_customer_info->fields['entry_postcode'],
                        'entry_city' => $get_customer_info->fields['entry_city'],
                        'entry_state' => $get_customer_info->fields['entry_state'],
                        'entry_tax_number' => $get_customer_info->fields['entry_tax_number'],
                        'entry_country' => array(
                            'entry_country_id' => $get_customer_info->fields['entry_country_id'],
                            'entry_country_name' => $entry_country_name,
                            'tel_prefix' => $tel_prefix,
                            'country_code' => $country_code
                        ),
                        'entry_country_id' => $get_customer_info->fields['entry_country_id'],
                        'entry_zone_id' => $get_customer_info->fields['entry_zone_id'],
                        'entry_country_name' => $get_customer_info->fields['entry_zone_id'],
                        'entry_telephone' => $get_customer_info->fields['entry_telephone'],
                        'entry_country_name' => $entry_country_name,
                        'tel_prefix' => $tel_prefix,
                        'country_code' => $country_code,
                        'company_type' => $get_customer_info->fields['company_type'],
                        'address_type' => 2
                        //'ticket_number' => $get_customer_info->fields['ticket_number']
                    );
                }
				$get_customer_info->MoveNext();
			}
		}
		
		return $shipping_address;
	}
	
	/*get_default_shipping_address_id*/
	function get_default_shipping_address_id(){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT address_book_id FROM " . TABLE_ADDRESS_BOOK ." as ab  
				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id) 
				WHERE address_book_id = customers_default_address_id 
				AND c.customers_id = :customers_id";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		return $get_customer_info->fields['address_book_id'];
	}
	
	/*get_shipping_address_id*/
   function zen_get_shipping_address_id(){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT customers_default_address_id FROM  " .TABLE_CUSTOMERS . " as c 
				WHERE  c.customers_id = :customers_id";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		return $get_customer_info->fields['customers_default_address_id'];
	}
	 function zen_get_guest_shipping_address_id(){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT customers_default_address_id FROM  " .TABLE_CUSTOMER_OF_GUEST . " as c 
				WHERE  c.guest_id = :guest_id";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':guest_id', (int)$_SESSION['customers_guest_id'], 'integer'));
		return $get_customer_info->fields['customers_default_address_id'];
	}
	
	
	
	/*get_default_billing_address_id*/
	function get_default_billing_address_id(){
		global $db;
//		$query_addresses = "SELECT address_book_id FROM " . TABLE_ADDRESS_BOOK ." as ab
//				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id)
//				WHERE ab.entry_firstname != '' and  c.customers_id = :customers_id
//				and (address_type = 2) Group by address_book_id order by address_book_id";
//		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));

		// 新版 2018.12.11  账单地址可以多个
        $query_addresses = "SELECT address_book_id FROM " . TABLE_ADDRESS_BOOK ." as ab  
				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id) 
				WHERE address_book_id = customers_default_billing_address_id 
				AND c.customers_id = :customers_id";
        $get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));

        return $get_customer_info->fields['address_book_id'];
	}
	
		function get_default_guest_billing_address_id(){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT customers_default_billing_address_id FROM  " .TABLE_CUSTOMER_OF_GUEST . " as c 
				WHERE  c.guest_id = :guest_id";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':guest_id', (int)$_SESSION['customers_guest_id'], 'integer'));
		return $get_customer_info->fields['customers_default_billing_address_id'];
	}
	/**
	 * get default shipping address
	 */
	function get_default_shipping_address(){
		global $db;
		$shipping_address = array();
		$query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,entry_postcode,company_type,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number 
				FROM " . TABLE_ADDRESS_BOOK ." as ab  
				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id) 
				WHERE address_book_id = customers_default_address_id 
				AND c.customers_id = :customers_id";
		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		if ($get_customer_info->RecordCount()){
            $entry_country_name = zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']);
            $tel_prefix = zen_get_prefix($get_customer_info->fields['entry_country_id']);
			$shipping_address['address_book_id'] = $get_customer_info->fields['address_book_id'];
			$shipping_address['entry_gender'] = $get_customer_info->fields['entry_gender'];
			$shipping_address['entry_company'] = $get_customer_info->fields['entry_company'];
			$shipping_address['entry_firstname'] = $get_customer_info->fields['entry_firstname'];
			$shipping_address['entry_lastname'] = $get_customer_info->fields['entry_lastname'];
			$shipping_address['entry_street_address'] = $get_customer_info->fields['entry_street_address'];
			$shipping_address['entry_suburb'] = $get_customer_info->fields['entry_suburb'];
			$shipping_address['entry_postcode'] = $get_customer_info->fields['entry_postcode'];
			$shipping_address['entry_state'] = $get_customer_info->fields['entry_state'];
			$shipping_address['entry_country'] = array(
				'entry_country_id' => $get_customer_info->fields['entry_country_id'],
				'entry_country_name' => $entry_country_name,
				'tel_prefix' => $tel_prefix
			);
			$shipping_address['entry_zone_id'] = $get_customer_info->fields['entry_zone_id'];
			$shipping_address['entry_telephone'] = $get_customer_info->fields['entry_telephone'];
            $shipping_address['entry_country_id'] = $get_customer_info->fields['entry_country_id'];
			$shipping_address['entry_country_name'] = $entry_country_name;
			$shipping_address['tel_prefix'] = $tel_prefix;
			$shipping_address['entry_tax_number'] = $get_customer_info->fields['entry_tax_number'];
			$shipping_address['entry_city'] = $get_customer_info->fields['entry_city'];
            $shipping_address['company_type'] = $get_customer_info->fields['company_type'];
			$shipping_address['address_type'] = 0;

		}
		return $shipping_address;
	}
	
	/**
	 * get default billing address
	 */
	function get_default_billing_address(){
		global $db;
		$billing_address = array();
//		$query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone
//				FROM " . TABLE_ADDRESS_BOOK ."  as ab
//				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id)
//				WHERE entry_firstname != '' and  c.customers_id = :customers_id
//				and (address_type = 2) order by address_book_id limit 1";

        // 新版 2018.12.11  账单地址可以多个
        $query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number 
                FROM " . TABLE_ADDRESS_BOOK ." as ab  
				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id) 
				WHERE ab.address_book_id = c.customers_default_billing_address_id 
				AND c.customers_id = :customers_id and ab.address_type = 2";

		$get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
		if ($get_customer_info->RecordCount()){
            $entry_country_name = zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']);
            $tel_prefix = zen_get_prefix($get_customer_info->fields['entry_country_id']);
			$billing_address['address_book_id'] = $get_customer_info->fields['address_book_id'];
			//$billing_address['entry_gender'] = $get_customer_info->fields['entry_gender'];
			//$billing_address['entry_company'] = $get_customer_info->fields['entry_company'];
			$billing_address['entry_firstname'] = $get_customer_info->fields['entry_firstname'];
			$billing_address['entry_lastname'] = $get_customer_info->fields['entry_lastname'];
			$billing_address['entry_street_address'] = $get_customer_info->fields['entry_street_address'];
			$billing_address['entry_suburb'] = $get_customer_info->fields['entry_suburb'];
			$billing_address['entry_postcode'] = $get_customer_info->fields['entry_postcode'];
			$billing_address['entry_state'] = $get_customer_info->fields['entry_state'];
			$billing_address['entry_city'] = $get_customer_info->fields['entry_city'];
			$billing_address['entry_country'] = array(
				'entry_country_id' => $get_customer_info->fields['entry_country_id'],
				'entry_country_name' => $entry_country_name,
				'tel_prefix' => $tel_prefix
			);
			$billing_address['entry_zone_id'] = $get_customer_info->fields['entry_zone_id'];	
			$billing_address['entry_telephone'] = $get_customer_info->fields['entry_telephone'];

            $billing_address['entry_country_id'] = $get_customer_info->fields['entry_country_id'];
			$billing_address['entry_country_name'] = $entry_country_name;
			$billing_address['tel_prefix'] = $tel_prefix;
			$billing_address['address_type'] = 2;
			$billing_address['entry_tax_number'] = $get_customer_info->fields['entry_tax_number'];
		}
		return $billing_address;
	}
	
	/**
	 * add new shipping address
	 */
	function add_new_shipping_address($customer_address,$set_default=true,$type=1){
		global $db;
		$customer_address['customers_id'] = intval($_SESSION['customer_id']);
		
		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address);
		$shipping_id = $db->insert_ID();
		$customer = $db->Execute("select customers_default_address_id from customers where customers_id = ". intval($_SESSION['customer_id']));
		$default_id = $customer->fields['customers_default_address_id'];
			/** update customers default address id*/
               if ($type == 1) {
                    if($set_default){
                        $db->Execute("update " . TABLE_CUSTOMERS . " 
                                                 SET customers_default_address_id = " . $shipping_id . " 
                                                 WHERE customers_id = " . intval($_SESSION['customer_id']));
                    }
               }else if($type == 2) {
                   $db->Execute("update " . TABLE_CUSTOMERS . " 
							SET customers_default_billing_address_id = " .$shipping_id ." 
							WHERE customers_id = ". intval($_SESSION['customer_id']));
               }
		return $shipping_id;

	}
	function add_guest_shipping_address($customer_address,$set_default=false){
		global $db;
		$customer_address['customers_guest_id'] = intval($_SESSION['customers_guest_id']);
		
		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address);
		$default_shipping_id = $db->insert_ID();
		
			$db->Execute("update " . TABLE_CUSTOMER_OF_GUEST . " 
							SET customers_default_address_id = " .$default_shipping_id ." 
							WHERE guest_id = ". intval($_SESSION['customers_guest_id']));
		
		return $default_shipping_id;
		
	}
	
	
	/**
	*select address
	*/
	function get_select_address($address_book_id){
		global $db;
		$get_customer_info=$db->Execute("select * from ".TABLE_ADDRESS_BOOK." where customers_id = ".
            (int)$_SESSION['customer_id'] . " and  address_book_id=".$address_book_id);
		if ($get_customer_info->EOF){  //未获取到数据
		    return [];
        }

        $entry_country_name = zen_get_country_name_with_code($get_customer_info->fields['entry_country_id']);
        $tel_prefix = zen_get_prefix($get_customer_info->fields['entry_country_id']);
        $country_code = zen_get_country_iso_code($get_customer_info->fields['entry_country_id']);

        $shipping_address['address_book_id'] = $get_customer_info->fields['address_book_id'];
        $shipping_address['entry_gender'] = $get_customer_info->fields['entry_gender'];
        $shipping_address['entry_company'] = $get_customer_info->fields['entry_company'];
        $shipping_address['entry_firstname'] = $get_customer_info->fields['entry_firstname'];
        $shipping_address['entry_lastname'] = $get_customer_info->fields['entry_lastname'];
        $shipping_address['entry_street_address'] = $get_customer_info->fields['entry_street_address'];
        $shipping_address['entry_suburb'] = $get_customer_info->fields['entry_suburb'];
        $shipping_address['entry_postcode'] = $get_customer_info->fields['entry_postcode'];
        $shipping_address['entry_city'] = $get_customer_info->fields['entry_city'];
        $shipping_address['entry_state'] = $get_customer_info->fields['entry_state'];
        $shipping_address['entry_country'] = array(
            'entry_country_id' => $get_customer_info->fields['entry_country_id'],
            'entry_country_name' => $entry_country_name,
            'tel_prefix' => $tel_prefix,
            "country_code"=> $country_code
        );
        $shipping_address['entry_zone_id'] = $get_customer_info->fields['entry_zone_id'];
        $shipping_address['entry_telephone'] = $get_customer_info->fields['entry_telephone'];
        $shipping_address['entry_tax_number'] = $get_customer_info->fields['entry_tax_number'];
        $shipping_address['company_type'] = $get_customer_info->fields['company_type'];

        $shipping_address['entry_country_id'] = $get_customer_info->fields['entry_country_id'];
        $shipping_address['entry_country_name'] = $entry_country_name;
        $shipping_address['tel_prefix'] = $tel_prefix;
        $shipping_address["country_code"] = $country_code;
        $shipping_address['is_avaTax_check'] =  $get_customer_info->fields['is_avaTax_check'];
        $shipping_address["address_type"] =  $get_customer_info->fields['address_type'];
        /**
         * 新加坡添加字段
         */
        if ($shipping_address['entry_country_id'] == 188) {
            $shipping_address['ticket_number'] = $get_customer_info->fields['ticket_number'];
        }
        if($shipping_address["address_type"] == 2){
            $is_default_address = false;
            $default_billing_address_id = $this->get_default_billing_address_id();
            if ($default_billing_address_id && $default_billing_address_id == $address_book_id){
                $is_default_address = true;
            }
            $shipping_address['is_default'] = $is_default_address;
        }else{
            $is_default_address = false;
            $default_shipping_address_id = $this->get_default_shipping_address_id();
            if ($default_shipping_address_id && $default_shipping_address_id == $address_book_id){
                $is_default_address = true;
            }
            $shipping_address['is_default'] = $is_default_address;
        }

		return $shipping_address;
	}
	
	
	
/**
	 * add new billing address
	 */
	function add_new_billing_address($customer_address,$is_set_default=true){
		global $db;
		$customer_address['customers_id'] = intval($_SESSION['customer_id']);
		
		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address);
		$default_billing_id = $db->insert_ID();
		/** update customers default address id*/
		if($is_set_default){
			$db->Execute("update " . TABLE_CUSTOMERS . " 
						SET customers_default_billing_address_id = " .$default_billing_id ." 
						WHERE customers_id = ". intval($_SESSION['customer_id']));
		}
		return $default_billing_id;
		
	}


	function add_guest_billing_address($customer_address,$customer_guest){
		global $db;
		$re = $db->getAll("select guest_id from customer_of_guest where email_address = '".trim($customer_guest['email_address'])."' order by guest_id DESC limit 1");
		if($re){
			zen_db_perform(TABLE_CUSTOMER_OF_GUEST, $customer_guest,'update','guest_id = '.intval($re[0]['guest_id']));
			$customers_guest_id = $re[0]['guest_id'];
		}else{
			zen_db_perform(TABLE_CUSTOMER_OF_GUEST, $customer_guest);
			$customers_guest_id = $db->insert_ID();
		}
		$customer_address['customers_guest_id'] = intval($customers_guest_id);
		$_SESSION['customers_guest_id'] = $customers_guest_id;
		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address);
		$default_billing_id = $db->insert_ID();
		/** update customers default address id*/
		$db->Execute("update ".TABLE_CUSTOMER_OF_GUEST." 
						SET customers_default_billing_address_id = " .$default_billing_id ." 
						WHERE guest_id = ". intval($customers_guest_id));
						return $default_billing_id;
		

	}

	
	function update_billing_address_type($id){
	  global $db;
	  $billing_address = array('address_type' => 2);
	  zen_db_perform(TABLE_ADDRESS_BOOK, $billing_address,'update','address_book_id = '.intval($id));
	}
	
	/**
	 * update address
	 */
	function update_address($customer_address,$address_book_id){
		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address,'update','address_book_id = '.intval($address_book_id));
	}
	
	/*get customer's newsletter*/
	function get_customers_newsletter(){
		global $db;
		$query_newsletter = "SELECT customers_newsletter from " .TABLE_CUSTOMERS . " 
			WHERE customers_id = :customers_id";
		
		$get_customer_info = $db->Execute($db->bindVars($query_newsletter, ':customers_id', intval($_SESSION['customer_id']),'integer'));
		if ($get_customer_info->RecordCount()){
			return $get_customer_info->fields['customers_newsletter'];
		}
		
		return 0;
	}
	
	function update_customer_newsletter($newsletter){
		global $db;
		$db->Execute("update " . TABLE_CUSTOMERS . " 
						SET customers_newsletter = " .intval($newsletter) ." 
						WHERE customers_id = ". intval($_SESSION['customer_id']));
		
	}
	/**
	 * 
	 * delete address ...
	 * @param int $address_book_id
	 */
	function remove_shipping_address($address_book_id){
		global $db;
		$rest = $db->getAll("select  customers_id from customers where customers_id = '".$_SESSION['customer_id']."' and (customers_default_address_id = '".$address_book_id."' OR customers_default_billing_address_id = '".$address_book_id."')");
		if($rest){
		}else{
		$db->Execute("delete from " . TABLE_ADDRESS_BOOK . " 
						WHERE address_book_id = ". intval($address_book_id));
		}
	}
	/**
	 * 
	 * get all address records
	 */
	function get_address_records(){
		global $db;
		$get_customer_info = $db->Execute("select count(address_book_id) as total from " .TABLE_ADDRESS_BOOK . " WHERE customers_id = " . intval($_SESSION['customer_id']));
		return $get_customer_info->fields['total'];
	}
	
	
	
	/**
	 *
	 * @param int $address_book_id
	 * @todo set customer default address
	 */
	function set_default_shipping_address($address_book_id){
		global $db;
		$sql = "update " .TABLE_CUSTOMERS ." set customers_default_address_id = :default_address_book_id: where customers_id = :customers_id:";
		$sql = $db->bindVars($sql,':default_address_book_id:',$address_book_id,'integer');
		$sql = $db->bindVars($sql,':customers_id:',(int)$_SESSION['customer_id'],'integer');
		$db->Execute($sql);
	
	}
	function set_default_billing_address($address_book_id){
		global $db;
		$sql = "update " .TABLE_CUSTOMERS ." set customers_default_billing_address_id = :default_address_book_id: where customers_id = :customers_id:";
		$sql = $db->bindVars($sql,':default_address_book_id:',$address_book_id,'integer');
		$sql = $db->bindVars($sql,':customers_id:',(int)$_SESSION['customer_id'],'integer');
		$db->Execute($sql);
	
	}

	function set_new_shipping_address_bill($address_book_id){
		global $db;
		$sql = "update " .TABLE_CUSTOMERS ." set customers_default_address_id = '".$address_book_id."' where customers_id = '".$_SESSION['customer_id']."'";
		$db->Execute($sql);
	}
		function set_guest_shipping_address_bill($address_book_id){
		global $db;
		$sql = "update ".TABLE_CUSTOMER_OF_GUEST." set customers_default_address_id = '".$address_book_id."' where guest_id = '".$_SESSION['customers_guest_id']."'";
		$db->Execute($sql);
		
			}
			
	// add by Aron 8.8
	/**
	 * 
	 * 新游客页面添加运输地址
	 * return (init) address_book_id
	 */
	function add_guest_shipping_address_new($customer_address,$customer_guest){
		global $db;
		$re = $db->getAll("select guest_id from customer_of_guest where email_address = '".trim($customer_guest['email_address'])."' order by guest_id DESC limit 1");
		if($re){
			zen_db_perform(TABLE_CUSTOMER_OF_GUEST, $customer_guest,'update','guest_id = '.intval($re[0]['guest_id']));
			$customers_guest_id = $re[0]['guest_id'];
		}else{
			zen_db_perform(TABLE_CUSTOMER_OF_GUEST, $customer_guest);
			$customers_guest_id = $db->insert_ID();
		}
		$customer_address['customers_guest_id'] = intval($customers_guest_id);
		$_SESSION['customers_guest_id'] = $customers_guest_id;
		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address);
		$default_shipping_id=$db->insert_ID();
		/** update customers default address id*/
		$db->Execute("update ".TABLE_CUSTOMER_OF_GUEST." 
						SET customers_default_address_id = " .$default_shipping_id ." 
						WHERE guest_id = ". intval($customers_guest_id));
		return $default_shipping_id;
	}
	/**
	 * 
	 * 新游客页面添加账单地址
	 * return (init) address_book_id
	 */
	function add_guest_billing_address_new($customer_address){
		global $db;
		$customer_address['customers_guest_id'] = intval($_SESSION['customers_guest_id']);

		zen_db_perform(TABLE_ADDRESS_BOOK, $customer_address);
		$default_shipping_id = $db->insert_ID();

		$db->Execute("update " . TABLE_CUSTOMER_OF_GUEST . " 
							SET customers_default_billing_address_id = " .$default_shipping_id ." 
							WHERE guest_id = ". intval($_SESSION['customers_guest_id']));

		return $default_shipping_id;

	}

	//
    /*
     * 展示一条地址
     * fairy 2018.12.10 modify
     * @para $address: 地址数据数组
     * @para $is_has_outer_div: 是否包含最外面的div。异步是不包含的
     * @return: html字符串
     */
    function get_ship_address_show_one($address,$is_has_outer_div=true){
        $address_type = $address['address_type'];
        $html = '';
	    // 删除
        // 没有直接放进去。可能有时候需求：默认地址的删除，非默认地址的删除，不一样
        $del_str = '<a href="javascript:void(0);" class="del_one" onclick="click_open_del_window('.$address['address_book_id'].')">'.FIBERSTORE_DELETE.'</a>';

        // 设置默认地址
        if($address_type==2){
            $set_default_str = '';
        }else{
            $set_default_str = '<span class="manage_span01 set_one_address" data-id="'.$address['address_book_id'].'" ><em class="manage_radio"><i></i></em> '.FS_MANAGE_ADDRESS_PREFERRED.'</span>';
        }

        // 税号 账期地址中的税号也展示出来  SQ20190912001
//        if( $address_type != 2){
            $entry_tax_number_str = $address['entry_tax_number'] ? $address['entry_tax_number'] : '';
//        }else{
//            $entry_tax_number_str = '';
//        }
		if($address['entry_country_id'] == 223){
			$info_entry_state = zen_get_countries_us_states_code($address['entry_state']);
		}else{
			$info_entry_state = $address['entry_state'];
		}
		if($address['is_default']){
            $active_str = 'active';
        }else{
            $active_str = '';
		}

		if($is_has_outer_div){
            $html .= '<div id="new17address_'.$address["address_book_id"].'"  class="manage_li '.$active_str.'" >';
        }

		$entry_suburb = $address['entry_suburb']?$address['entry_suburb'].',':'';
        $html .= '
        <div class="manage_top_wap"><div class="manage_border01">
            <h2 class="manage_tit">'.$address['entry_firstname'].' '.$address['entry_lastname'].'</h2>
            <div class="manage_txt">'.($address['entry_company']?$address['entry_company']:'').'<div class="manage_txt_detail">'
                .$address['entry_street_address'] .', '.$entry_suburb.$address['entry_city'].' '.$info_entry_state.' '.$address['entry_postcode'].', '.$address['entry_country_name'].'</div>'
                .$address['tel_prefix'].' '.$address['entry_telephone'].' <br />'
                .$entry_tax_number_str.'</div>
            <div class="manage_bottom">
                '.$set_default_str.'
                <span class="manage_span_right">
                    <a href="javascript:;" onclick="add_edit_address(this,'.$address_type.','.$address['address_book_id'].')">'.FS_ADDRESS_EDIT.'</a>
                    <i></i>
                     '.$del_str.'
                </span>
            </div>
        </div></div><div class="add_edit_block"></div>';
        if($is_has_outer_div){
            $html .= '</div>';
        }

        return $html;
    }
 }
