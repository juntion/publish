<?php

/*************************content*************************/
//ery		2014-9-14		add
define('FS_SUCCESS_CART','Cart');
define('FS_SUCCESS_CHECKOUT','Checkout');
define('FS_SUCCESS_SUCCESS','Success');
define('FS_SUCCESS_LIVE','Live Chat');
define('FS_SUCCESS_THANK','Thank you for shopping with us! Your order has been received.');
define('FS_SUCCESS_SUMMARY','Order Summary');
define('FS_SUCCESS_NUMBER','Order Number');
define('FS_SUCCESS_TOTAL','Total Amount');
define('FS_SUCCESS_PURCHASE','Your purchase has been divided into');
define('FS_SUCCESS_ORDER_01','orders.');
define('FS_SUCCESS_ITEM','Item(s)');
define('FS_SUCCESS_ORDER_DINGDAN','Order #');
define('FS_SUCCESS_METHOD','Shipping Method');
define('FS_SUCCESS_DELIVERY','Expected Delivery');
define('FS_SUCCESS_SHIP_FROM','Ship From');
define('FS_SUCCESS_ORDER_DINGDAN','Order #');
define('FS_SUCCESS_DATE','Order Date');
define('FS_SUCCESS_PAYMENT','Payment Method');
define('FS_SUCCESS_CREDIT','Credit/Debit Card');
define('FS_SUCCESS_IF','If in doubt please contact us:    Tel :+1 (253) 277 3058      E-mail:  ');
define('FS_SUCCESS_SALES','sales@fs.com');
define('FS_SUCCESS_SUPPORT','Support@fiberstore.com');
define('FS_SUCCESS_YOU_CAN','Orders submitted successfully, you can');
define('FS_SUCCESS_VIEW','View My Orders');
define('FS_SUCCESS_CHANGE','Change My Profile');
define('FS_SUCCESS_SHIPPING','Shipping Address');
define('FS_SUCCESS_BACK','Back Home');
/*****************html_checkout_success_hsbc.php*****************/
define('FS_SUCCESS_YOUR_NEXT','Your next step is to complete your Bank Transfer payment and submit your payment details.');
define('FS_SUCCESS_WIRE','Bank Transfer');
define('FS_SUCCESS_ORDER','Print Order');
define('FS_SUCCESS_DETAIL','Bank Transfer beneficiary details');
define('FS_SUCCESS_BANK_NAME','Beneficiary Bank Name');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','Beneficiary A/C Name');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','Beneficiary A/C NO');
define('FS_SUCCESS_TEL','817-888472-838');
define('FS_SUCCESS_SWIFT','SWIFT Address');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','Beneficiary Bank Address');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','Our Company Address');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
/******************html_checkout_success_paypalwpp.php*******************/
define('FS_SUCCESS_PAYPAL','Paypal');
define('FS_SUCCESS_TRANSFER','Transfer Details beneficiaries');
define('FS_SUCCESS_TRANS_CODE','Paypal Transaction code');
define('FS_SUCCESS_YOU','You can now return to the');
define('FS_SUCCESS_HOME','home page');
define('FS_SUCCESS_OR','or view');
define('FS_SUCCESS_MY','my order');
/*****************html_checkout_success_westernunion.php******************/
define('FS_SUCCESS_WES_YOUR','Your next step is to complete your Western Union payment and submit your payment details.');
define('FS_SUCCESS_WES_BENE','Beneficiaries Details');
define('FS_SUCCESS_BENEFICIARY','Beneficiary');
define('FS_SUCCESS_ZYX','ZongYun Xu');
define('FS_SUCCESS_FIRST','First Name');
define('FS_SUCCESS_ZY','ZongYun');
define('FS_SUCCESS_LAST','Last Name');
define('FS_SUCCESS_X','Xu');
define('FS_SUCCESS_WES_RECEIVER','Receiver’s telephone number');
define('FS_SUCCESS_PHONE','13926572260');
define('FS_SUCCESS_ADDRESS','Address');
define('FS_SUCCESS_SZ','Shenzhen 518045, China');
define('FS_SUCCESS_WU','Western Union');
define('FS_SUCCESS_NOTE','Note');
define('FS_SUCCESS_YOUR_ORDER','Your order status will change to “Payment Confirmed” within 2 working days after we verify your payment. Some orders may take additional time to verify.');

//add by Aron 2017.7.18
define('FS_SUCCESS_PURCHASE_YOUR_NEXT','Your next step is to upload your PO, we will not ship until PO received.');
define('FS_SUCCESS_PAYMENT_DATE','Payment Date');

//add by Aron 2017.7.25
define("FS_UPLOAD_TITLE","Purchase Order Uploading");
define("FS_UPLOAD_TEXT","Upload your Purchase Order and save time. we'll start to process purchase order as soon as PO file received. Please make sure all necessary signatures and information is provided. ");
//add by aron 2017.11.18
define("FS_SUCCESS_GLOABL_THANK","Payment is successful! Your order is in process.");
//add by frankie 2018.1.2. 
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","The shipping address does not match addresses on your credit application form. We will review the order and email you the result within 12 hours. Please upload the PO document in 7 business days, or the order will be cancelled automatically due to the inventory change of items.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","Your available credit has been overrun. To get this order processed quickly, please pay off the previous orders to recover the credit, or you can go to <a href ='".zen_href_link('my_dashboard')."'>”My Credit”</a> to apply for increasing the credit limit. Please upload the PO document in 7 business days, or the order will be cancelled automatically due to the inventory change of items.");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","The shipping address does not match addresses on your credit application form and your available credit has also been overrun. To get this order processed quickly, please pay off the previous orders to recover the credit, or you can go to <a href ='".zen_href_link('my_dashboard')."'>”My Credit”</a> to apply for increasing the credit limit. We will review the order and email you the result within 12 hours. Please upload the PO document in 7 business days, or the order will be cancelled automatically due to the inventory change of items.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE_1","Please upload your purchase order file in 7 business days, otherwise, The order will be cancelled automatically due to the inventory change of items.");
define('FIBER_CHECK_SPARK','Sparkasse Bank Account:');
define("PICK_UP_ALERT1",'Sorry, Name on photo ID is required.');
define("PICK_UP_ALERT2",'Sorry, Phone NO. is required.');
define("PICK_UP_ALERT4",'pick up time is required.');
//add by helun 2018.5.15
define('FS_CHECKOUT_SUCCESS_01','orders.');
define('FS_CHECKOUT_SUCCESS_02','Print Order');
define('FS_CHECKOUT_SUCCESS_03','Order');
define('FS_CHECKOUT_SUCCESS_04','of');
define('FS_CHECKOUT_SUCCESS_05','If any question, please call us '.fs_new_get_phone().' or email us');
define('FS_CHECKOUT_SUCCESS_05_1','If any question, please call us $PHONE or email us $EMAIL.');
define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07',FS_DE_COMPANY_NAME);
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');
define('FS_CHECKOUT_SUCCESS_12','Purchase Order');
define('FS_CHECKOUT_SUCCESS_13','DAYS');
define('FS_CHECKOUT_SUCCESS_14','Upload PO File');
//echeck
define("FS_SUCCESS_ECHECK","Electronic Check");
define('FS_SUCCESS_YOUR_NEXT_ECHECK','We\'ll start to process purchase order as soon as received your payment. By choosing Electronic Check payment method, the shipping of your order maybe delayed about 1~2 business days.');
define('FS_CHECKOUT_SUCCESS_SALES','.');

//OP下单成功后提示语
define('FS_CHECKOUT_PURCHASE_ADDRESS','The shipping address does not match addresses on your credit application form. We will review the order and email you the result within 12 hours.');
define('FS_CHECKOUT_PURCHASE_EXCESS','Your available credit has been overrun. To get this order processed quickly, please pay off the previous orders to recover the credit, or you can go to "My Credit" to apply for increasing the credit limit.');
define('FS_CHECKOUT_PURCHASE_ALL','The shipping address does not match addresses on your credit application form and your available credit has also been overrun. To get this order processed quickly, please pay off the previous orders to recover the credit, or you can go to "My Credit" to apply for increasing the credit limit. We will review the order and email you the result within 12 hours.');

define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','You\'ve selected installation service. When the order is ready to ship, our technical specialist will contact your before heading to your place.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','You\'ve selected installation service. Please make sure to complete the payment before scheduled installation time, or the service may be delayed.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','You\'ve selected installation service. Please make sure to upload PO file before scheduled installation time, or the service may be delayed.');

//下单成功优化 add time 2020-04-06 jay
define('FS_CHECKOUT_SUCCESS_NEW_01', 'Thanks for your order');
define('FS_CHECKOUT_SUCCESS_NEW_02', 'Order will be canceled to after 7 days due to the inventory change, please complete payment within 1-3 business days and remark  FS order number or your company name, which will help our Financial Team identify your remittance and process the order timely.');
define('FS_CHECKOUT_SUCCESS_NEW_03', 'Payment Information');
define('FS_CHECKOUT_SUCCESS_NEW_PO_NUMBER_04', 'PO Number');
define('FS_CHECKOUT_SUCCESS_NEW_DELIERY_ADDRESS_05', 'Deliery Address');
define('FS_CHECKOUT_SUCCESS_NEW_PAYMENT_INSTRUCTIONS_06', 'Payment Instructions');
define('FS_CHECKOUT_SUCCESS_NEW_07', 'After the payment is remitted successfully, please send bank slip to ');
define('FS_CHECKOUT_SUCCESS_NEW_08', ' or your account manager. This will help release your order on priority and avoid cancellation of your order. Please send your payment to the following account.');
define('FS_CHECKOUT_SUCCESS_NEW_BSB_09', 'BSB');
define('FS_CHECKOUT_SUCCESS_NEW_ACCOUNT_NO_10', 'Account No.');
define('FS_CHECKOUT_SUCCESS_NEW_SWIFT_CODE_11', 'SWIFT Code');
define('FS_CHECKOUT_SUCCESS_NEW_BANK_ADDRESS_12', 'Bank Address');
define('FS_CHECKOUT_SUCCESS_NEW_13', 'Please leave your order number ');
define('FS_CHECKOUT_SUCCESS_NEW_14', ' and email address in the bank transfer memo.');
define('FS_CHECKOUT_SUCCESS_NEW_DELIVERY_POLICY_15', 'Delivery Policy');
define('FS_CHECKOUT_SUCCESS_NEW_16', 'Estimated delivery time does not commence until your payment has been received by us.');
define('FS_CHECKOUT_SUCCESS_NEW_17', 'Your order will be delivered between 9am and 5pm, Monday to Friday (excluding public holidays). Someone will need to be at the nominated address to accept and sign for delivery.');
define('FS_CHECKOUT_SUCCESS_NEW_PRINT_18', 'Print');
define('FS_CHECKOUT_SUCCESS_NEW_DOWNLOAD_19', 'Download');
define('FS_CHECKOUT_SUCCESS_NEW_ORDER_DETAILS_20','Order Details');
define('FS_CHECKOUT_SUCCESS_NEW_BILLING_ADDRESS_21', 'Billing Address');
//账期
define('FS_CHECKOUT_SUCCESS_PURCHASE_THINK_YOU_01', 'Thank you, ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_YOUR_ORDER_02', 'Your order ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_05', "We'll start to process purchase order as soon as PO file received. Please make sure all necessary signatures and information is provided. You could also upload your PO file in ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_LATER_06', ' later.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ORDER_AMOUNT_07', 'Order Amount');
define('FS_CHECKOUT_SUCCESS_PURCHASE_TOTAL_08', 'Total');
define('FS_CHECKOUT_SUCCESS_PURCHASE_09', 'Estimated delivery time does not commence until your PO file has been received by us.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_10', 'Your order will be delivered between 9am and 5pm, Monday to Friday (excluding public holidays). Someone will need to be at the  nominated address to accept and sign for delivery.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ACCOUNT_CENTER_11', 'Account Center');
define('FS_CHECKOUT_SUCCESS_PURCHASE_12', 'We have emailed you an order summary and confirmation. If you have any questions, please call ');
define('FS_CHECKOUT_SUCCESS_PURCHASE_13', 'My Account');
define('FS_CHECKOUT_SUCCESS_PURCHASE_14', 'Find out how FS makes your online shopping experience easier');
define('FS_CHECKOUT_SUCCESS_PURCHASE_15', 'View My PO');
define('FS_CHECKOUT_SUCCESS_PURCHASE_16', 'Track Your Items');
define('FS_CHECKOUT_SUCCESS_PURCHASE_17', 'Order History');

define('FS_CHECKOUT_SUCCESS_PURCHASE_18', "Order Payment");
define('FS_CHECKOUT_SUCCESS_PURCHASE_19', "us@fs.com");
define('FS_CHECKOUT_SUCCESS_PURCHASE_20', "Expected Delivery");
define('FS_CHECKOUT_SUCCESS_PURCHASE_21', ".");
define('FS_CHECKOUT_SUCCESS_PURCHASE_22', "Order Date");
define('FS_CHECKOUT_SUCCESS_PURCHASE_23', "Order Number");
define('FS_CHECKOUT_SUCCESS_PURCHASE_24', "Purchase Order Information");
define('FS_CHECKOUT_SUCCESS_PURCHASE_25', "Print PI");

// 武汉仓
define('FS_COMMON_WAREHOUSE_CN_CHECKOUT_SUCCESS','ATTN: FS. COM LIMITED<br> 
			Address: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China');
// 深圳仓
define('FS_COMMON_WAREHOUSE_CN_NEW_CHECKOUT_SUCCESS','FS.COM LIMITED<br> 
			A115 Jinhetian Business Centre <br> 
			No.329, Longhuan Third Rd <br> 
			Longhua District <br>
			Shenzhen, 518109, <br> China');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU_CHECKOUT_SUCCESS','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany');
define('FS_COMMON_WAREHOUSE_US_CHECKOUT_SUCCESS','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST_CHECKOUT_SUCCESS','ATTN: FS.COM Inc.<br>
					Address: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU_CHECKOUT_SUCCESS','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175, Australia');
define('FS_COMMON_WAREHOUSE_SG_CHECKOUT_SUCCESS','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG_CHECKOUT_SUCCESS','ATTN: FS Tech Pte Ltd.<br>
				Address: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore');

define('FS_COMMON_FEEDBACK_TIP','To help us provide you with better shopping experience next time, we\'d like to hear you more. <a href="javascript:;" style="color:#0070BC;" onclick="$(\'.have_feedback\').show()" id="have_checkout_feedback">Click</a>');

?>