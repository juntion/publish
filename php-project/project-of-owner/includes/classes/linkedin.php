<?php
class linkedin{
	
	/**
	 * 
	 * @param unknown_type $emailAdress
	 * @return boolean
	 * @todo current email address have a record in db
	 */
	function already_have_an_account_or_not($emailAddress){
		$sql = "SELECT COUNT(customers_id) as total FROM customers WHERE customers_email_address = '".$emailAddress."'";
		$result = zen_get_data_from_db($sql, array('total'));
		return (0 < $result[0][0]) ? true : false; 
	}
	
	
	function get_customers_info_who_login_by_linkedin_acount_before($emailAddress){
		$sql = "SELECT 
				customers_id,
				customers_firstname,
				customers_lastname,
				customers_default_address_id,
				customer_country_id 
				FROM customers 
				WHERE customers_email_address = '".$emailAddress."'";
		$result = zen_get_data_from_db($sql, array('customers_id','customers_firstname','customers_lastname','customers_default_address_id','customer_country_id'));
		return $result;
	}
	
	function get_country_id_by_country_code($iso_code_2){
		$sql ="SELECT countries_id FROM countries WHERE countries_iso_code_2 = '".$iso_code_2."'";
		$result = zen_get_data_from_db($sql, array('countries_id'));
		return $result[0][0];
	}
	function get_country_name_by_country_code($iso_code_2){
		$sql ="SELECT countries_name FROM countries WHERE countries_iso_code_2 = '".$iso_code_2."'";
		$result = zen_get_data_from_db($sql, array('countries_name'));
		return $result[0][0];
	}
}