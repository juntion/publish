<?php

/**
 * caution: 
 * 
 * A) if customer login through linkin account before, just set his customers_id in session, let him go
 * B) if it's the first time of one customer login by linkin, then we need to store his information into 3 tables
 * 
 * 		1. customers [important: social_media_id]
 * 		2. customers_info
 * 		3. customers_LinkedIn_account_info
 */


// if no data transfer here , exit
if (!zen_not_null($_POST))
// 	output 0 for error
	exit('0');

// processing data from linkedin

$in_id = $_POST['in_id'];
$in_firstName = $_POST['in_firstName'];
$in_lastName = $_POST['in_lastName'];
$in_phoneNumber = $_POST['in_phoneNumber'];
$in_emailAddress = $_POST['in_emailAddress'];
$in_address = $_POST['in_address'];
$in_country_code = $_POST['in_country_code'];

//if email address is null , exit
if(!zen_not_null($in_emailAddress)){
// 	output 0 for error
	exit('0');
}





require DIR_WS_CLASSES.'linkedin.php';
$linkedin = new linkedin();

//if this customer use linkedin login before,  let him go
if ($linkedin->already_have_an_account_or_not($in_emailAddress)) {
	$customers_info = $linkedin->get_customers_info_who_login_by_linkedin_acount_before($in_emailAddress);
	$_SESSION['customer_id'] = $customers_info[0][0]; 
	require_once DIR_WS_CLASSES .'set_cookie.php';
		        	$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
	$_SESSION['name'] 		 = $customers_info[0][1]. ' '. $customers_info[0][2];
	
}else {
// processing the first time customer login through LinkedIn account

	//generate new password like password forgotten page
	$new_password = zen_create_random_value( (ENTRY_PASSWORD_MIN_LENGTH > 0 ? ENTRY_PASSWORD_MIN_LENGTH : 5) );
	$crypted_password = zen_encrypt_password($new_password);
	
	//--------------------fill data in table customers columns 
	$customers_table_array = array(
			'customers_firstname' => zen_db_prepare_input($in_firstName),
			'customers_lastname' => zen_db_prepare_input($in_lastName),
			'customers_email_address' => zen_db_prepare_input($in_emailAddress),
			'customers_password' => $crypted_password,
			'email_is_active' => 1, //fairy 2017.11.2
			'social_media_id' => 3, //here is linkedin login
            'from_where' => isMobile() ? 2 : 1,        // 客户来源
            'language_id' => (int)$_SESSION['languages_id'],
             'language_code'=>$_SESSION['languages_code'],
			);
	
	//set telephone number 
	if (zen_not_null($in_phoneNumber)) {
		$customers_table_array['customers_telephone'] = zen_db_prepare_input($in_phoneNumber);
	}
	
	// set country id
	if (zen_not_null($in_country_code)){
		$country_id = $linkedin->get_country_id_by_country_code($in_country_code);
		
		if ($country_id)
			$customers_table_array['customer_country_id'] = $country_id;
	}
	
	
	
	zen_db_perform(TABLE_CUSTOMERS, $customers_table_array);
	
	
	//get customers_id
	$customers_id = $db->insert_ID();
	
	
	//---------------------fill data in table customers_info columns
	$customers_info_table_array = array(
			'customers_info_id' => $customers_id,
			'customers_info_date_account_created' => 'now()',
			
			);
	
	zen_db_perform(TABLE_CUSTOMERS_INFO, $customers_info_table_array);

	
	//set customer_id, name to session
	$_SESSION['customer_id'] = $customers_id;
	require_once DIR_WS_CLASSES .'set_cookie.php';
		        	$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
	$_SESSION['name'] 		 = $in_firstName. ' '. $in_lastName;
	
	
	//send mail 
}

// output 1 for success
exit('1');

