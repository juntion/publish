<?php

class customers_service_email{
	
	function customers_service_send_email($email_address,$service_number,$service_date,$service_reason,$orders_num,$service_type){

		$html_msg = array(); 
		$html=zen_get_corresponding_languages_email_common('admin');
		
		$html_msg['EMAIL_HEADER'] = $html['html_header'];
		$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
		$html_msg['SERVICE_TYPE'] = $service_type;
		$html_msg['ORDERS_NUM'] = $orders_num;
		$html_msg['SERVICE_NUMBER'] = $service_number;
		$html_msg['SERVICE_DATE'] = $service_date;
		$html_msg['SERVICE_REASON'] = $service_reason;
		
		$auto_reply_subject = 'New message from customers service';
		$send_to_email = 'support@fiberstore.com';
		$send_to_name =  trim(STORE_NAME);
		
		zen_mail_contact_us_or_bulk_order_inquiry('', $email_address, $auto_reply_subject, $text_message, $send_to_name, $send_to_email, $html_msg,'customers_service_to_us');
	}

    function customers_service_email_to_customers($orders_num,$email_address,$orders_status,$name){

        $html_msg = array();  //the email content
        $html=zen_get_corresponding_languages_email_common();

        $html_msg['EMAIL_BODY_COMMON_DEAR']= EMAIL_BODY_COMMON_DEAR.' '.$name.',';

        if($orders_status==2){
            $html_msg['EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1']='<p style="margin: 10px 0;">For Order No '.$orders_num.', the status is changed. Please go to <a href="https://www.fs.com/index.php?main_page=manage_orders">My Orders</a> on www.fs.com to check the details.</p><p style="margin: 10px 0;">About the items you canceled, we will arrange refund when we get back from holiday on Feb 3rd, 2017, thanks for your understanding.</p><p style="margin: 10px 0;">If you have any question, please send us an email at sales@fs.com or give us a call at 1-253-277-3058, we will deal with it within 12 hours.</p>';
        }else{
            $html_msg['EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1']='We are happy to inform you that the order application is in processing. Once the cancellation has been approved, you can contact us on live chat or email sales@fs.com or call 1-253-277-3058 to get the RMA and complete the return process.Any question is welcomed.';
        }

        $html_msg['EMAIL_BODY_COMMON_THANKS']='Kind regards,';

        $html_msg['EMAIL_HEADER'] = $html['html_header'];
        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];


        $auto_reply_subject = "Cancellation for FS.COM Order ".$orders_num."";
        $text_message = "";

        $send_to_email = 'legal@fs.com';
        $send_to_name =  trim(STORE_NAME);
        //send email to our customers
        zen_mail_contact_us_or_bulk_order_inquiry($name, $email_address, $auto_reply_subject, $text_message, $send_to_name, $send_to_email, $html_msg,'customers_service_to_customer');
    }
	
	function admin_email_by_customers_id($cid){
	
		global $db;
		$sql = "SELECT ad.admin_email FROM ".TABLE_ADMIN." as ad join ".TABLE_ADMIN_TO_CUSTOMERS." as atc on ad.admin_id = atc.admin_id WHERE atc.customers_id = ".(int)$cid;
		$result = $db->Execute($sql);
		return $result->fields['admin_email'];
	
	}

}