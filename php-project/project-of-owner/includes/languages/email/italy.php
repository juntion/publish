<?php
/****************************公共头部***********************************/
define('EMAIL_HEAHER_RIGHT', 'To Be the World-class Supplier in <br> Optical Communications');
define('EMAIL_MENU_HOME','Home');
define('EMAIL_HOME_URL',zen_href_link('index'));
define('EMAIL_MENU_SUPPORT','Support');
define('EMAIL_SUPPORT_URL',zen_href_link('support'));
define('EMAIL_MENU_TUTORIAL','Tutorial');
define('EMAIL_TUTORIAL_URL',zen_href_link('tutorial'));
define('EMAIL_MENU_ABOUT_US','About Us');
define('EMAIL_ABOUT_US_URL',zen_href_link('about_us'));
define('EMAIL_MENU_SERVICE','Service');
define('EMAIL_SERVICE_URL',zen_href_link('service'));
define('EMAIL_MENU_CONTACT_US','Contact Us');
define('EMAIL_CONTACT_US_URL',zen_href_link('contact_us'));
define('EMAIL_MENU_MY_ACCOUNT','My account');
define('EMAIL_MY_ACCOUNT_URL',zen_href_link('my_dashboard'));
define('EMAIL_MENU_CHECK_ORDER','Check Order Status');
define('EMAIL_CHECK_ORDER_URL',zen_href_link('manage_orders'));

/****************************公共底部****************************************/
define('EMAIL_MENU_PURCHASE_HELP','Purchase Help');
define('EMAIL_PURCHASE_HELP_URL',zen_href_link('how_to_buy'));
define('EMAIL_FOOTER_PROMPT','This mailbox is unattended, so please do not reply to this message.<br>  For other inquiries, contact us via FS Support or Email to sales@fs.com.');
define('EMAIL_FOOTER_FS_COPYRIGHT','Copyright &copy; 2002-'.date('Y',time()).' fs.com  All Rights Reserved.');

// fairy add
define('EMAIL_FOOTER_FACEBOOK','FS on Facebook');
define('EMAIL_FOOTER_TWITTER','Twitter');
// fairy add 2017.11.28
define('EMAIL_FOOTER_SINCERELY','Sincerely,');
define('EMAIL_FOOTER_FS_SERVICE','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Customer Service');

/**************************************content common text**************************************/
define('EMAIL_BODY_COMMON_FSCOM','FS.COM');
define('EMAIL_BODY_COMMON_DEAR','Gentile');
define('EMAIL_BODY_COMMON_THANKS','Thanks');
define('EMAIL_BODY_COMMON_PHONE','Phone : ');
define('EMAIL_BODY_COMMON_PARTNER','Partner');
define('EMAIL_BODY_COMMON_URL_BASE',zen_href_link('index'));

// fairy add 2017.11.28
define('EMAIL_BODY_COMMON_PLATFORM','Platform');
define('EMAIL_BODY_COMMON_BROWSER','Browser');
define('EMAIL_BODY_COMMON_IP_ADDRESS','IP address');
define('EMAIL_BODY_COMMON_UNKNOWN','Unknown');
define('EMAIL_BODY_COMMON_EAMIL_USER','Security info used: ');
define('EMAIL_BODY_COMMON_EAMIL_COUNTRY','Country/region');
define('EMAIL_BODY_COMMON_CUSTOMER_NAME','Customer Name: ');
define('EMAIL_BODY_COMMON_CUSTOMER_EMAIL','Customer Email: ');

/*********************************contact us to customer*************************************/
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1','We\'ve received your question. You will receive a response within 12 hours. Also, check your email spam folder if you do not get the reply within 12 hours.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT2','Need quick help? Check FAQs, you may find answers here.<br>Or, contact your professional sales representatives or customer service for support. They are always ready to answer your question.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT3','8 am.- 5 pm. PST. Mon. to Fri. ：+1 (877) 205 5306');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT4','PS. Please do not reply to this email. Emails sent to this address will not be answered.');
define('EMAIL_CONTACT_US_TO_SUBJECT','We appriciate your message  -- FS.COM');

/************************************regist to customer*********************************************/
define('EMAIL_REGIST_TO_CUSTOMER_SUBJECT','FS.COM - Consumer Account Creation');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT1','Thank you for registering with FS.COM. Your account has been created and you may check via<a href="'.zen_href_link(FILENAME_MY_DASHBOARD,'','SSL').'">\'My Account\'</a>.');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT2','With the account, you will enjoy the following services now:<br />
1. Easy tracking your order history<br />
2. Faster checkout with an address book<br />
3. Emails updates upon new arrivals and promotions<br />
4. Free&Immediate technical support<br />
<br />
If you would like to contact us for any reason please get in touch through our <a href="'.zen_href_link(FILENAME_SUPPORT).'" target="_blank">help desk</a>. They will tell you everything you need to know about your account, delivery options, returns policy and anything else on your mind.');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT3','Tips: If your e-mail is found into the trash, please add <a href="mialto:sales@fs.com">sales@fs.com</a> as your friend. <br />
Once again, welcome to <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">FS.COM</a>. 
<br />
<br /> Sincerely<br /><br />
FS.COM Customer Service<br />
820 SW 34th Street Bldg W7 Suite H, Renton, WA 98057, United States <br />
Phone: +1 (877) 205 5306<br />');

//fairy
// 个人、企业激活邮件内容
define('EMAIL_REGIST_COMMON_VERIFY_EMAIL','Verify Email');
define('EMAIL_REGIST_COMMON_VERIFYT_TITLE2','If the link does not work, please try copying this URL in your browser\'s address bar:');
define('EMAIL_REGIST_COMMON_VERIFYT_TIME','This link will expire 3days after this email was sent.');
define('EMAIL_REGIST_COMMON_SINCERELY','Sincerely');
define('EMAIL_REGIST_COMMON_FS','FS.COM Customer Service');
// 个人、企业激活邮件内容
define('EMAIL_REGIST_TO_CUSTOMER_THANK','Thank you for setting up your FS.COM account !');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO','Your FS.COM account is your destination for all the great features FS.COM has to offer registered users, including:');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO_DES','<li>Easy tracking your order history</li>
                  <li>Faster checkout with an address book</li>
                  <li>Emails updates upon new arrivals and promotions</li>
                  <li>Free&Immediate technical support</li>');
define('EMAIL_REGIST_TO_CUSTOMER_VERIFYT_TITLE','In order to avail these features we request you to verify your email address by clicking the link below.');
// 企业激活邮件
define('EMAIL_REGIST_TO_COMPANY_THANK','Thank you for applying for business account with FS.COM!');
define('EMAIL_REGIST_TO_COMPANY_INTRO','Your request is currently under review. We will send you an email message in 24 hours about the result once it verified.');
define('EMAIL_REGIST_TO_COMPANY_VERIFYT_TITLE','To finish setting up your account, please verify your email address by clicking the link below.');
define('EMAIL_REGIST_TO_COMPANY_THANK_AGAIN','We appreciate your cooperation and thanks again for your trust with FS.COM.');
// 个人用户升级企业用户邮件
define('EMAIL_UPGRADE_TO_COMPANY_CONSULT','If you have any further questions, please feel free to <a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">contact us</a>.');

//fairy 个人注册
define('EMAIL_REGIST_TO_CUSTOMER_THANK_AGAIN','Now you could get access to your account. If you need any further assistance, please feel free to <a href="http://www.fs.com/contact_us.html" style="color:#0070BC; text-decoration:none;">contact us.</a>');

/***************************** password forgotten to customer ***************************************/
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_SUBJECT','FS.COM - Password Reset Request');

// fairy 2017.11.28
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TITLE','How to reset your <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> account password?');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT1','This email was sent to you in response to your request to modify your <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> account.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT2','Click the link below to go to the <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> site and reset your password: ');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_RESET_BUTTON','Reset your password');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT3','Please note that the above link has a life span of 3 days only.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT4','If you didn\'t make this change or if you believe an unauthorized person has accessed your account, please <a href="RESET_PWD_LINK" target="_blank" style="color:#0070BC; text-decoration:none;">reset your password</a> immediately. Then <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">sign in</a> to review and update your security settings.');

/***************************** 修改密码成功之后发的邮件 ***************************************/
// fairy 修改密码成功之后的邮件 add 2017.11.28
define('FS_PWD_UPDATE_SUCCESS_EAMIL_THEME','FS.COM - Account Password Changed');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_TITLE','Your password changed successfully.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON1','The password for your <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) has been successfully changed on <b>EMAIL_TIME</b>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON2','You can now use your new security info to sign in to your account. If you need additional help, please <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contact us</a>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON3','If you didn\'t make this change or if you believe an unauthorized person has accessed your account, please <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">reset your password</a> immediately. Then <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">sign in</a> to review and update your security settings.');


/**************************************** company_regist *****************************************************/
define('EMAIL_COMPANY_REGIST_SUBJECT','FS.COM - Business Account Application');
define('EMAIL_COMPANY_REGIST_TEXT1','Thanks for your application for a business account to build more business relations with us. <br><br>
Your request is under review. We will email to you in 24 hours about the result once it verified.');
define('EMAIL_COMPANY_REGIST_TEXT2','Best regards,');
define('EMAIL_COMPANY_REGIST_TEXT3','FS.COM Customer Service');

/********************************************* checkout common ****************************************************************/
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT','FS.COM Order# %s ');
// add by Aron
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT1','confirmed for FS.COM Order# %s ');
define('EMAIL_CHECKOUT_COMMON_TO_PURCHASE_CUSTOMER_SUBJECT','FS.COM Purchase Order# %s ');

define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_NO','Order No');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDERED_ON','Ordered on');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_BILL_TO','Billing address');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PAYMENT_METHOD','Payment Method');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO','Shipping address');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_VIA','Ship via');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_NAME','Item');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FSID','FS ID#');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_PRICE','Item Price');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_QTY','Qty');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PRICE','Price');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBTOTAL','Subtotal');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_CHARGE','Shipping Charges');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_GRAND_TOTAL','Grand Total');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FS_SKU','FS SKU#');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_PAYPAL','Paypal');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_CARD','Credit/Debit Card');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER','View or manage order');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY','Order summary');
//2017-12-7  add   ery 
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - Order %s received, please complete payment');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE_PO','FS.COM - Order %s received, waiting for PO confirmation');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE','FS.COM - Order %s Payment Received');
define('EMAIL_CHECKOUT_PO','uploaded successfully');

/***************************************checkout_westernunion_or_wiretransfer*************************************************/
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT1','Frequently Asked Questions');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT2','When will I get my items ?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT3','Once we confirm your payment and finish processing your order, your items will be immediately packaged and shipped to your destination.
			You can use your order number to check this order\'s status at any time in My Orders. For details regarding processing and delivery times, please contact us.
			For all other questions, visit our FAQ.');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT4','How can I contact you?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT5','For any help, please send us an email at <a target="_blank" href="mailto:sales@fs.com" style="color:#3E6EC1;">sales@fs.com</a>
      or give us a call at <a style="color:#363636;" target="_blank" value="+1 877 205 5306">+1 877 205 5306</a> or click live chat to chat on line or leave a message, we will deal with it  within 12 hours. ');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WESTERN_UNION','Thank you for ordering from FS.COM! We have received your order and are awaiting payment confirmation.<br>

							Please visit <a target="_blank" href="'.zen_href_link('manage_orders').'" style="color:#363636;">My Orders</a> to view our Western Union account information if you have not taken down the account information during the check out process .<br><br>

							Submitting Your Western Union Payment Confirmation

							Once you have completed your Western Union transaction, please send the MTCN number to us at <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> or click the link below to submit your transaction details: <a target="_blank" href="$URL" style="color:#363636;">Click to submit your transaction details </a>

							We cannot process your order until your payment has been confirmed. Once your payment has been confirmed, we will send a "Payment Confirmation" email and then begin to process your order.<br>

							Need more help paying for your order? Just contact us at <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> for help. We will get back to you within 12 hours.<br>');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WIRE_TRANSFER','<p>Thank you for ordering from FS.COM! We have received your order and   are awaiting payment confirmation.<br>

      Please visit <a target="_blank" href="'.zen_href_link('manage_orders').'" style="color:#363636;">My Orders</a> to view our Bank Transfer account information if you have not taken down the   account information during the check out process .</p>

      <p>Submitting Your Bank Transfer Payment Confirmation<br>

        Once   you have completed your Bank Transfer transaction, please send the Bank Transfer   transaction to us at <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> or   click the link below to submit your transaction details: <a target="_blank" href="$URL" style="color:#363636;">Click to submit your transaction details </a><br>

        We cannot process   your order until your payment has been confirmed. Once your payment has been   confirmed, we will send a "Payment Confirmation" email and then begin to process   your order.</p>

      <p>Need more help paying for your order? Just contact us at <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> for help. We will get back to you   within 12 hours.</p>');


define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER','<p>Thank you for shopping with us, here is your Purchase Order details: </p>');

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT1","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Please go to <a  href='".zen_href_link('manage_orders')."'>'My Orders'</a> page to upload the PO file if you have not already done so. We're not able to process your order until your PO has been confirmed. </p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT2","<p style='color:rgb(51,51,51);margin:0;padding:0;'>If you have any further questions regarding your order, please contact us at <a target='_blank' href='http://sales@fs.com'>sales@fs.com</a> for help. We will get back to you within 12 hours.</p>");


/************************************* checkout purchase ****************************************/

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT3","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Thank you again for your order!</p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT4","<p style='color:rgb(51,51,51);margin:0;padding:0;'>FS.COM Customer Service</p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START1","Thank you for the PO documents, you could view the PO via  <a href='".zen_href_link('manage_orders')."'  target='_blank'>'My orders'</a>.");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START2","Your order will be processed soon, tracking number will be sent to you once the goods shipped out.");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START3","If you have any question, please feel free to <a href='".zen_href_link('contact_us')."'  target='_blank'>contact us</a>.");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START4","Thank you!");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START_NO","PO NO  ");


/************************************* checkout paypal or credit card ****************************************/
define('EMAIL_CHECKOUT_PAYPAL_TEXT1','Order Received, Awaiting Payment Confirmation');
define('EMAIL_CHECKOUT_PAYPAL_TEXT2','Thanks for shopping in ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT3','FS.COM');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4','. Below is the summary of your order, please confirm and <a href=\''.zen_href_link('manage_orders').'\' target=\'_blank\' style=\'color:#0070BC; text-decoration:none;\'>complete the payment</a> in a good time.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4_1','. Below is the summary of your order, please confirm and complete the payment in a good time.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT5','Expected Delivery');
define('EMAIL_CHECKOUT_PAYPAL_TEXT6','If you have any further questions regarding your order, please feel free to ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT7','<a style="color: #0070BC;text-decoration: none;" href="'.zen_href_link('contact_us').'">contact us</a>');
define('EMAIL_CHECKOUT_PAYPAL_TEXT8',' Customer Service Team ');
//define('EMAIL_CHECKOUT_PAYPAL_TEXT9','<td width="35%" bgcolor="#d4e4f6" style="font-size:11px; border-top:1px solid #a6c5e8;" colspan="2">');
//define('EMAIL_CHECKOUT_PAYPAL_TEXT10','<td bgcolor="#d4e4f6" style="font-size:11px; border-top:1px solid #a6c5e8;">');
//define('EMAIL_CHECKOUT_PAYPAL_TEXT11','</td>');
//define('EMAIL_CHECKOUT_PAYPAL_TEXT12','<td width="35%" bgcolor="#d4e4f6" style="font-size:11px; border-top:1px solid #a6c5e8;" colspan="2">');
//define('EMAIL_CHECKOUT_PAYPAL_TEXT13','<td bgcolor="#d4e4f6" style="font-size:11px; border-top:1px solid #a6c5e8;">');
//define('EMAIL_CHECKOUT_PAYPAL_TEXT14','</td>');
/*************************************** checkout payment success ******************************/
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TEXT1','Thanks for shopping with Fiberstore. We have received the payment and will process your order as soon as possible. If you have any question, please feel free to <a href="'.reset_url('http://www.fiberstore.com/service/fs_support.html').'" target="_blank">contact us</a>.');

/*********************************** orders status *************************************/
define('EMAIL_ORDERS_STATUS_SUBJECT','Order Update # ');
define('EMAIL_ORDERS_STATUS_FOR_ORDER','For Order No:');
define('EMAIL_ORDERS_STATUS_TEXT1','the status is changed. Please go to <a href="'.zen_href_link('account_history_info').'&orders_id=$ORDER_ID">My orders</a> on www.fs.com to check the	details.');
define('EMAIL_ORDERS_STATUS_TEXT2','For any help, please send us an email at	sales@fs.com or give us a call at +1 (877) 205 5306, we	will deal with it within 12 hours.');
define('EMAIL_ORDERS_STATUS_TEXT3','Thanks for all support.');
define('EMAIL_ORDERS_STATUS_TEXT4','Kindest regards,');
define('EMAIL_ORDERS_STATUS_TEXT5','FiberStore Service Team');



/************************************** sales manager to customer *********************************************/
define('EMAIL_SALES_MANAGER_SUBJECT','Administrator assign a purchasing consultant for you -- FS.COM');
define('EMAIL_SALES_MANAGER_TEXT1','Good day! <br><br>Thanks for joining Fiberstore. ');
define('EMAIL_SALES_MANAGER_TEXT2','I am');
define('EMAIL_SALES_MANAGER_TEXT3',' your sales representative. ');
define('EMAIL_SALES_MANAGER_TEXT4','Should you have any needs or questions on our products or other related information about Fiberstore, please feel free to contact me. It is my pleasure to be on service with you.<br><br><br>
			<span style="font-family:Calibri;font-size:13px;">Here is my contact information: </span>');
define('EMAIL_SALES_MANAGER_TEL','Tel: ');
define('EMAIL_SALES_MANAGER_MOBILE','Mobile: ');
define('EMAIL_SALES_MANAGER_EMAIL','Email: ');
define('EMAIL_SALES_MANAGER_TEXT5','(12/7 Sales &amp; Support)');
define('EMAIL_SALES_MANAGER_TEXT6','<span style="font-family:Calibri;font-size:13px;">Room 301, Third Floor, Weiyong Building, No. 10, Kefa Road, Nanshan District, Shenzhen, 518057, CHINA</span>');
define('EMAIL_SALES_MANAGER_TEXT7','Yours sincerely');

/************************************ backend common *********************************************/
//update orders status 
define('EMAIL_BACKEND_COMMON_PAYMENT_RECEIVED',' Payment Received');
define('EMAIL_BACKEND_COMMON_YOUR_ORDER','Your Order:');
define('EMAIL_BACKEND_COMMON_TEXT1','status has been updated to:');
define('EMAIL_BACKEND_COMMON_TRACK_INFORMATION','Track information:');
define('EMAIL_BACKEND_COMMON_PROCESSING',' Processing');
define('EMAIL_BACKEND_COMMON_TRACKING_INFO',' Tracking Info');
define('EMAIL_BACKEND_COMMON_TEXT2',' All products in your order have been shipped , it will take 3-4 days to arrive your address, and you could get the track information in your account on FiberStore.');
define('EMAIL_BACKEND_COMMON_SHIPPING_METHOD','Shipping Method:');
define('EMAIL_BACKEND_COMMON_TACKINF_NUMBER','Tacking Number:');
define('EMAIL_BACKEND_COMMON_TEXT3','has been shipped out.');
define('EMAIL_BACKEND_COMMON_REFUNDED',' Refunded');
define('EMAIL_BACKEND_COMMON_IS_CANCELED',' is canceled');
define('EMAIL_BACKEND_COMMON_CANCELED','Canceled');
define('EMAIL_BACKEND_COMMON_COMPLETED',' Completed');
define('EMAIL_BACKEND_COMMON_NO_INFO','no info');
define('EMAIL_BACKEND_COMMON_TEXT4','Tips: For detail, please login your account on fiberstore. If you have any question, please');
//reviews to customer
define('EMAIL_BACKEND_COMMON_REVIEWS_REPLY_SUBJECT','New review reply from Fiberstore.');
define('EMAIL_BACKEND_COMMON_YOUR_REVIEW','Your review:');
define('EMAIL_BACKEND_COMMON_PRODUCTS_NAME_URL','Products Name|Review Url:');
define('EMAIL_BACKEND_COMMON_REPLY_BY','Reply by:');
define('EMAIL_BACKEND_COMMON_REPLY_CONTENT','Reply content:');

/*********************************** business account success to customer *************************************************/
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_SUBJECT','Your Business Account Application has been accepted.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT1','Congratulations, your application for the business account has been accepted.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT2','With the business account, you could enjoy the following services now:');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT3','1. Enjoy $PER discount<br>
        2. The best shipping method<br>
        3. Professional sales representative and technical support<br>
        <br><br>Best regards<br><br>
        Fiberstore Co., Limited');

/************************    customer question to customer     *********************/
define('EMAIL_CUSTOMER_QUESTION_TC_SUBJECT','Your Questions Have Been Responsed by FiberStore');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT1','Thanks for your feedback of the questions.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT2','We \'ll do our best updating you comprehensive solutions.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT3','Yours Sincerley');

//ery 2017.4.18
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','A webpage from FS.COM has been shared with you!');
define('EMAIL_SAVE_DEAR','Dear Present You');
define('EMAIL_BODY_COMMON_TAX_NUMBER','VAT Number');
//西雅图发货延迟通知邮件 2017.8.2  ery
define('ORDER_DELAY_TITLE','Products for Your Overnight Order# is in Transferring || FS.COM');
define('ORDER_DELAY_EMAIL_WE',"We’re happy to receive your order %s on FS.COM.");
define('ORDER_DELAY_EMAIL_THIS',"This email is to update you that the items %s are being transferred from another warehouse as the stocks are temporarily not enough in our local warehouse. It will take 2-3 business days more for the overnight shipment due to the inventory location.");
define('ORDER_DELAY_EMAIL_PLEASE',"Pls bear with us, we will arrange the shipment via overnight service once we receive the transferred items. Sincerely sorry for this inconvenience.");
define('ORDER_DELAY_EMAIL_THANKS','Thanks for your patience in advance.');

// fairy 异地登录邮件 add 2017.11.28
define('FS_OFFSITE_LOGIN_EAMIL_THEME','FS.COM - Account New Activity Notification');
define('FS_OFFSITE_LOGIN_EAMIL_TITLE','New sign-in on EMAIL_USER_DEVICE');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT1','Your FS Account <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a> just sign-in on a new device.');
define('FS_OFFSITE_LOGIN_EAMIL_LOCATION','Approximate Location');
define('FS_OFFSITE_LOGIN_EAMIL_TIME','Time');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT2','if you don\'t recognize this activity or if you believe an unauthorized person has accessed your account, please reset your password immediately.');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT3','If you have any more questions, please feel free to <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contact us</a>.');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","Thank you for shopping on");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","Live Chat");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH"," with an expert");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","Sincerely,");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","Gentile");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","Customer Service Team ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","Shipping address: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","If you have any further questions regarding your order, please feel free to ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","Your PO#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","has been uploaded successfully.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","Thank you for the PO documents, you could now view the PO and print the invoice via");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","My orders");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","now.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","Shipping Charges");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","Grand Total");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","Subtotal");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","Your order will be processed soon, if you have any further questions regarding your order, please feel free to");
//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Your order payment confirmed here.');
define('EMAIL_CHECKOUT_SUCCESS_WE','We have received your payment for order ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',', thank you for your great support here.');

//rma_success   售后单申请成功邮件
define('EMAIL_RMA_SUCCESS_APPROVED_YRR','Your RMA request # %s has been approved.');
define('EMAIL_RMA_SUCCESS_APPROVED_YOUR','Your RMA request # %s has been approved, please follow the flowchart online and return the parcel to the indicating address.');
define('EMAIL_RMA_SUCCESS_APPROVED_WE','We\'ll process the %s once we receive the package. For immediate help, please feel free to <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contact us</a>.');
define('EMAIL_RMA_SUCCESS_SUBMIT_YOUR','Your RMA request # %s is under review.');
define('EMAIL_RMA_SUCCESS_SUBMIT_WE','We have received your RMA application and will have a quick review. For further information about the process, your dedicated sales representatives will update you timely.');
define('EMAIL_RMA_SUCCESS_SUBMIT_FOR','For immediate help, please feel free to <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contact us</a>.');
define('EMAIL_RMA_SUCCESS_TITLE','FS.COM - RMA Request # %s');

// fairy 修改密码成功
define('FS_MODIFY_PWD_EAMIL_SUCCESS_THEME','FS.COM - Account Password Changed');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_TITLE','Your password changed successfully.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT1','The password for your <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) has been successfully changed on <b>EMAIL_TIME</b>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT2','You can now use your new security info to sign in to your account. If you need additional help, please <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contact us</a>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT3','If you didn\'t make this change or if you believe an unauthorized person has accessed your account, please <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">reset your password</a> immediately.  Then <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">sign in</a> and update your security settings.');

// fairy 修改邮件成功
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_THEME','FS.COM - Email Address Changed');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_TITLE','Your email address changed successfully.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT1','The email address has been successfully changed on <b>EMAIL_TIME</b>. Your new email address is <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT2','You can now use your new address to sign in to your account. If you need additional help, please <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">contact us</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT3','If you didn\'t make this change or if you believe an unauthorized person has accessed your account, please <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">reset your password</a> immediately.  Then <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">sign in</a> and update your security settings.');

// fairy 修改邮件给销售的
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_THEME','FS.COM - L\'indirizzo email del tuo cliente è cambiato');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_TITLE','Il tuo cliente (CUSTOMER_NAME） ha cambiato l\'indirizzo email.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT1','L\'indirizzo email del tuo cliente(CUSTOMER_NAME）è stato modificato con successo il <b>EMAIL_TIME</b>.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT2','L\'indirizzo email precedente è OLD_EMAIL.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT3','L\'indirizzo email nuovo è NEW_EMAIL.');

// fairy 申请报价之后的邮件
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_THEME','FS.COM - Quote Request INQUIRY_NUMBER');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE','Your request for quote INQUIRY_NUMBER received.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE_SALE','You have a new request for quote INQUIRY_NUMBER.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT1','Please find below the details of your quote request. One of our sales associates will contact you as soon as possible with the information you requested.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT2','Request Details');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT3','If you\'re a registered member, you could track and review the quote details via <a href="'.zen_href_link('inquiry_list').'" style="color: #0070BC;">account center</a>.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT4','Thank you for submitting a quote request. One of our sales associates will contact you as soon as possible with the information you requested.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_RQ_NUMBER','RQ Number');
define('FS_EMAIL_MY_PO_UP_URLS',zen_href_link('contact_us'));

//fairy 个人中心用户添加评论，给对应销售发的邮件
define('FS_PRODUCT_REVIEW_SUCCESS_SALE_EMAIL_THEME','New customer review from product of FS.');
define('FS_CUSTOMER_REVIEWS', 'Customer reviews');
define('FS_REVIEWS_URL', 'Products Name|Reviews Url');
define('FS_REVIEW_RATING', 'Review rating');
define('FS_REVIEW_CONTENT', 'Review Content');
