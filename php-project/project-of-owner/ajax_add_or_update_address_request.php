<?php




if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){
			case 'update_address':
					$customer_name = zen_db_prepare_input  (trim($_POST ['entry_firstname'])) ;
		
					if (strpos($customer_name, ' ')) {
						$entry_lastname = substr($customer_name, strrpos($customer_name,' ')+1);
						$entry_firstname  =  substr($customer_name, 0,-strlen($entry_lastname));
					}else{
						$entry_lastname = $customer_name;
						$entry_lastname = '';
					}

//			 		$entry_firstname = $_POST['entry_firstname'];
//					$entry_lastname = $_POST['entry_lastname'];
					$entry_street_address = $_POST['entry_street_address'];
					$entry_suburb  = $_POST['entry_suburb'];
					$entry_postcode = $_POST['entry_postcode'];
					$entry_state = $_POST['entry_state'];
					$entry_city = $_POST['entry_city'];
					$entry_country_id = $_POST['entry_country_id'];
					$entry_zone_id = $_POST['entry_zone_id'];
					$entry_telephone = $_POST['entry_telephone'];
									
					$customer_address = array(
						'entry_company' => zen_db_prepare_input($entry_company),
						'entry_firstname' => zen_db_prepare_input($entry_firstname),
						'entry_lastname' => zen_db_prepare_input($entry_lastname),
						'entry_street_address' => zen_db_prepare_input($entry_street_address),
						'entry_suburb' => zen_db_prepare_input($entry_suburb),
						'entry_postcode' => zen_db_prepare_input($entry_postcode),
						'entry_state' => zen_db_prepare_input($entry_state),
						'entry_country_id' => (int)$entry_country_id,
						'entry_zone_id' => (int)$entry_zone_id,
						'entry_city' =>zen_db_prepare_input($entry_city),
						'entry_telephone' => zen_db_prepare_input($entry_telephone)
					);
					
						if (!$address_book_id || !$customer_info->billing_address_exist($address_book_id)){
							$customer_info->add_new_billing_address($customer_address);
							exit('success');
						}else{
							$customer_info->update_address($customer_address,$address_book_id);
						exit('success');
						}
						
						if (1 == $_POST['update_address']){
						if (!$address_book_id || !$customer_info->billing_address_exist($address_book_id)){
							$customer_info->add_new_billing_address($customer_address);
							exit('success');
						}else{
							$customer_info->update_address($customer_address,$address_book_id);
							exit('success');
						}
					}				
				break;
			case 'add_address':
					$customer_name = zen_db_prepare_input  (trim($_POST ['entry_firstname'])) ;
		
					if (strpos($customer_name, ' ')) {
						$entry_lastname = substr($customer_name, strrpos($customer_name,' ')+1);
						$entry_firstname  =  substr($customer_name, 0,-strlen($entry_lastname));
					}else{
						$entry_lastname = $customer_name;
						$entry_lastname = '';
					}

//			 		$entry_firstname = $_POST['entry_firstname'];
//					$entry_lastname = $_POST['entry_lastname'];
					$entry_street_address = $_POST['entry_street_address'];
					$entry_suburb  = $_POST['entry_suburb'];
					$entry_postcode = $_POST['entry_postcode'];
					$entry_state = $_POST['entry_state'];
					$entry_city = $_POST['entry_city'];
					$entry_country_id = $_POST['entry_country_id'];
					$entry_zone_id = $_POST['entry_zone_id'];
					$entry_telephone = $_POST['entry_telephone'];
									
					$customer_address = array(
						'entry_company' => zen_db_prepare_input($entry_company),
						'entry_firstname' => zen_db_prepare_input($entry_firstname),
						'entry_lastname' => zen_db_prepare_input($entry_lastname),
						'entry_street_address' => zen_db_prepare_input($entry_street_address),
						'entry_suburb' => zen_db_prepare_input($entry_suburb),
						'entry_postcode' => zen_db_prepare_input($entry_postcode),
						'entry_state' => zen_db_prepare_input($entry_state),
						'entry_country_id' => (int)$entry_country_id,
						'entry_zone_id' => (int)$entry_zone_id,
						'entry_city' =>zen_db_prepare_input($entry_city),
						'entry_telephone' => zen_db_prepare_input($entry_telephone)
					);
					
					if ( 1 == $_POST['new_address']){
					if ($customer_info->get_address_records()){
						$customer_info->add_new_shipping_address($customer_address);
						exit('success');
					}else{
						$customer_info->add_new_shipping_address($customer_address);
						$customer_info->add_new_billing_address($customer_address);
						exit('success');
					}
				  }
				break;
		}
	}
}