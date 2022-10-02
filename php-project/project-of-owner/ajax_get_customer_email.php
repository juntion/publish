<?php 
require 'includes/application_top.php';

if($_POST['customer_number']){//获取邮箱
	$customer_number = zen_db_prepare_input($_POST['customer_number']);
	$online_email = fs_get_data_from_db_fields('customers_email_address','customers','customers_number_new="'.$customer_number.'"','limit 1');
	//$offline_email = fs_get_data_from_db_fields('customers_email_address','customers_offline','customers_number_new='.$customer_number,'limit 1');
	if($online_email){
		echo $online_email;
	}else{
	    echo 0;
		//echo '未查询到客户邮箱,请填写';
	}
	exit();
}
if(!empty($_POST['customer_email'])){
	$customer_email = zen_db_prepare_input($_POST['customer_email']);
	$online_email = fs_get_data_from_db_fields('customers_number_new','customers','customers_email_address="'.$customer_email.'"','limit 1');
	if($online_email){
		echo $online_email;
	}else{
	    echo 0;
		//echo 'Please ensure email address is registered and correct.';
	}
}
$action = $_GET['action'];
switch ($action){
    case 'orders_number':
        if($_POST['orders_number'] && $_POST['currency_id']){
            $orders_number = zen_db_prepare_input($_POST['orders_number']);
            $currency_id = zen_db_prepare_input($_POST['currency_id']);
            $customer_email = zen_db_prepare_input($_POST['customer_email']);
            $delivery_country = fs_get_data_from_db_fields('delivery_country','orders','orders_number="'.$orders_number.'"','limit 1');
            $code = fs_get_data_from_db_fields('code','currencies','currencies_id="'.$currency_id.'"','limit 1');
            $quest_option_show = false;
            if ($delivery_country) {  //线上单根据订单编号获取运输国家跟提交货币进行判断
                $is_show_payeezy = is_show_payeezy($code,$delivery_country,true);
                if ($delivery_country == 'United States' && $code == 'USD') {
                    $is_show_check = 0;
                } else {
                    $is_show_check = 1;
                }
                $quest_option_show = true;
            } else { //线下单逻辑1 根据订单编号获取运输国家跟提交货币进行判断
                $products_instock_id = $db->Execute("select products_instock_id from products_instock_shipping where order_number= '".$orders_number."' limit 1");
                if($products_instock_id->RecordCount()>0){
                    $delivery_country_id = $db->Execute("select entry_country_id from products_instock_shipping_OrderAddress where products_instock_id= '".$products_instock_id->fields['products_instock_id']."' limit 1");
                    if($delivery_country_id){
                        $is_show_payeezy = is_show_payeezy($code,$delivery_country_id->fields['entry_country_id']);
                        if($delivery_country_id->fields['entry_country_id'] == 223 && $code == 'USD'){
                            $is_show_check = 0;
                        }else{
                            $is_show_check = 1;
                        }
                        $quest_option_show = true;
                    }else{
                        $reslut = $db->Execute("select customers_id,customers_default_billing_address_id from customers where customers_email_address = '".$customer_email."' limit 1");
                        if($reslut->fields['customers_id']){
                            $entry_country_id = $db->Execute("select entry_country_id from " . TABLE_ADDRESS_BOOK .  " where address_book_id = ". (int)$reslut->fields['customers_default_billing_address_id']);
                            if(isset($entry_country_id) && $entry_country_id->RecordCount()>0){
                                $is_show_payeezy = is_show_payeezy($code,$entry_country_id->fields['entry_country_id']);
                                if($entry_country_id->fields['entry_country_id'] == 223 && $code == 'USD'){
                                    $is_show_check = 0;
                                }else{
                                    $is_show_check = 1;
                                }
                                $quest_option_show = true;
                            }
                        }
                    }
                }else{ //线下单逻辑2  根据订单编号获取运输国家跟提交货币进行判断
                    $manage_address_info = $db->Execute("select address_id from manage_customer_inquiry_PI_info where order_invoice = '".$orders_number."' limit 1");
                    if ($manage_address_info->fields['address_id']) {
                        $inquiry_PI_address_info = $db->Execute("select pi_country_id from manage_customer_inquiry_PI_address_info where id = '".$manage_address_info->fields['address_id']."' limit 1");
                        if(isset($inquiry_PI_address_info) && $inquiry_PI_address_info->RecordCount()>0){
                            $is_show_payeezy = is_show_payeezy($code,$inquiry_PI_address_info->fields['pi_country_id']);
                            if($inquiry_PI_address_info->fields['pi_country_id'] == 223 && $code == 'USD'){
                                $is_show_check = 0;
                            }else{
                                $is_show_check = 1;
                            }
                            $quest_option_show = true;
                        }
                    } else {
                        $reslut = $db->Execute("select customers_id,customers_default_billing_address_id from customers where customers_email_address = '".$customer_email."' limit 1");
                        if($reslut->fields['customers_id']){
                            $entry_country_id = $db->Execute("select entry_country_id from " . TABLE_ADDRESS_BOOK .  " where address_book_id = ". (int)$reslut->fields['customers_default_billing_address_id']);
                            if(isset($entry_country_id) && $entry_country_id->RecordCount()>0){
                                $is_show_payeezy = is_show_payeezy($code,$entry_country_id->fields['entry_country_id']);
                                if($entry_country_id->fields['entry_country_id'] == 223 && $code == 'USD'){
                                    $is_show_check = 0;
                                }else{
                                    $is_show_check = 1;
                                }
                                $quest_option_show = true;
                            }
                        }
                    }
                }
            }
            if($quest_option_show == true){
                exit(json_encode(array('status' => 1, 'info' => '', 'data' => array('is_show_payeezy'=>$is_show_payeezy,'is_show_check'=>$is_show_check,'ss'=>$reslut->fields['customers_id']))));
            }else{
                exit(json_encode(array('status' => 0, 'info' => '', 'data' => '')));
            }
        }
        break;

}