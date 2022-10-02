<?php

class live_chat_service_email{

	function live_chat_service_send_email($name,$email_address,$country,$number,$question,$subject,$message_subject){

		$html_msg = array();  //the email content
		define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);
		$html=zen_get_corresponding_languages_email_common();

		$html_msg['EMAIL_HEADER'] = $html['html_header'];
		$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
		$html_msg['NAME']=$name;
		$html_msg['EMAIL_ADDRESS']=$email_address;
		$html_msg['COUNTRY']=$country;
		$html_msg['NUMBER']=$number;
		$html_msg['SUBJECT']=$subject;
		$html_msg['MESSAGE_SUBJECT']=$message_subject;
		$html_msg['QUESTION']=$question;
		
		$text_message = 'New message from live chat service page of Fiberstore !';
		$send_to_email = 'legal@fs.com';	

		$send_to_name =  trim(STORE_NAME);

		//send email to our support@fiberstore.com
		zen_mail_contact_us_or_bulk_order_inquiry($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $send_to_name, $email_address, $html_msg,'contact_us_to_us');

	}
	/**
	 * live_chat_service_send_phone_email
	 * Enter description here ...
	 * @param unknown_type $name
	 * @param unknown_type $email_address
	 * @param unknown_type $company_name
	 * @param unknown_type $country
	 * @param unknown_type $number
	 * @param unknown_type $dial_back
	 */
	function live_chat_service_send_phone_email($name,$email_address,$company_name,$country,$number,$dial_back){

		$html_msg = array();  //the email content
		define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);
		$html=zen_get_corresponding_languages_email_common();

		$html_msg['EMAIL_HEADER'] = $html['html_header'];
		$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
		$html_msg['NAME'] = $name;
		$html_msg['EMAIL_ADDRESS'] = $email_address;
		$html_msg['COMPANY_NAME'] = $company_name;
		$html_msg['COUNTRY'] = $country;
		$html_msg['NUMBER'] = $number;
		$html_msg['DIAL_BACK'] = $dial_back;
		
		$text_message = 'New message from live chat service page of Fiberstore !';
		$send_to_email = 'legal@fs.com';
		$send_to_name =  trim(STORE_NAME);

		//send email to our support@fiberstore.com
		zen_mail_contact_us_or_bulk_order_inquiry($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $send_to_name, $email_address, $html_msg,'contact_us_phone_to_us');

	}

	/**
	 * live_chat_service_email_to_customers @author tom
	 * Enter description here ...
	 * @param unknown_type $name
	 * @param unknown_type $email_address
	 */
	function live_chat_service_email_to_customers($name,$email_address){

		$html_msg = array();  //the email content
		define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);
		$html=zen_get_corresponding_languages_email_common();

		$html_msg['EMAIL_BODY_COMMON_DEAR']=EMAIL_BODY_COMMON_DEAR;
		$html_msg['NAME']=$name;
		$html_msg['EMAIL_BODY_COMMON_DEAR']=EMAIL_BODY_COMMON_DEAR;
		$html_msg['NAME']=$name;
		$html_msg['FS_EMAIL_MY_PO_UP_SIN']=FS_EMAIL_MY_PO_UP_SIN;
		$html_msg['FS_EMAIL_FS']=FS_EMAIL_FS;
		$html_msg['FS_EMAIL_TO_US_FHONE']=FS_EMAIL_TO_US_FHONE;
		$html_msg['FS_EMAIL_TO_US_OR']=FS_EMAIL_TO_US_OR;
		$html_msg['FS_EMAIL_TO_US_TEL']=FS_EMAIL_TO_US_TEL;
		$html_msg['FS_EMAIL_TO_US_URL']=FS_EMAIL_TO_US_URL;
		$html_msg['FS_EMAIL_TO_US_LIVE']=FS_EMAIL_TO_US_LIVE;
		$html_msg['FS_EMAIL_TO_US_GET']=FS_EMAIL_TO_US_GET;
		$html_msg['FS_EMAIL_TO_US_TEAM']=FS_EMAIL_TO_US_TEAM;
		$html_msg['FS_EMAIL_TO_US_CONTACT']=FS_EMAIL_TO_US_CONTACT;
		$html_msg['FS_EMAIL_TO_US_SYSTEM']=FS_EMAIL_TO_US_SYSTEM;
		$html_msg['FS_EMAIL_TO_US_REQUIRE']=FS_EMAIL_TO_US_REQUIRE;
		$html_msg['FS_EMAIL_TO_US_YOU']=FS_EMAIL_TO_US_YOU;
		$html_msg['FS_EMAIL_TO_US_SALES']=FS_EMAIL_TO_US_SALES;
		$html_msg['FS_EMAIL_TO_US_PHONES']=FS_EMAIL_TO_US_PHONES;

		$html_msg['EMAIL_HEADER'] = $html['html_header'];
		$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
		$auto_reply_subject = "FS.COM - Customer Service Auto Response Email";

		$text_message = 'New message from live chat service page of Fiberstore !';
		$send_to_email = 'support@fiberstore.com';
		$send_to_name =  trim(STORE_NAME);
	    zen_mail_contact_us_or_bulk_order_inquiry($name, $email_address, $auto_reply_subject, $text_message, $send_to_name, $send_to_email, $html_msg,'contact_us_to_customer');
	}



}