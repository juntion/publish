<?php
class order_help_for_google{
	function get_country_iso_code2_by_country_name($country_name){
		$sql = "SELECT countries_iso_code_2 FROM countries 
				WHERE countries_name = '".$country_name."';";
		$result =  zen_get_data_from_db($sql, array('countries_iso_code_2'));
		return $result[0][0];
	}
}