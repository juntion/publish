<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	include (DIR_WS_CLASSES.'customers_service_email.php');
	$customers_service_email = new customers_service_email();
	
	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':

			if(isset($_POST['orders_id'])){
				$orders_id = $_POST['orders_id'];
				$result = $db->Execute("select refund_number from ".TABLE_CUSTOMERS_SERVICE_REFUND." order by service_refund_id desc limit 1");

			    if ($result->RecordCount() > 0)
			    {
			    	$number = (int)substr($result->fields['refund_number'],10) + 1;
			    	$rs_num = 'RS' . date('Ymd',time()). $number ;
			    }
			    else $rs_num = 'RS' . date('Ymd',time()) . '1000';
			    $reason = $_POST['content'];
                $reason = zen_db_input($reason);
			    
				$sql =" insert into ".TABLE_CUSTOMERS_SERVICE_REFUND." (orders_id,refund_reason,refund_date,customers_id,refund_number) 
						values ('".$_POST['orders_id']."','".$reason."',now(),'".$_SESSION['customer_id']."','".$rs_num."') ";
				$db->query($sql);
				
				$admin_email = $customers_service_email->admin_email_by_customers_id($_SESSION['customer_id']);
				$service_date = date('Y/m/d H:i');
				$orders_num = zen_get_orders_number_by_id($_POST['orders_id']);

                if($admin_email){
                    $customers_service_email->customers_service_send_email($admin_email,$rs_num,$service_date,$reason,$orders_num,'Refund');
                }
                $customers_email = fs_get_data_from_db_fields_array(array('customers_email_address','orders_status','customers_name','customers_lastname'),'orders','orders_id='.$_POST['orders_id'],'limit 1');
                //春节邮件
                if($customers_email[0][0]){
                    $name = $customers_email[0][2].' '.$customers_email[0][3];
                    //$customers_service_email->customers_service_email_to_customers($orders_num,$customers_email[0][0],$customers_email[0][1],$name);
                }

				/* $his_sql = "insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added ,comments)
	            		   values ('".$_POST['orders_id']."', '2', now(),'".$reason."')";
				$db->query($his_sql); */
				
			exit('ok');
			}
			break;
		
		}
	}
}