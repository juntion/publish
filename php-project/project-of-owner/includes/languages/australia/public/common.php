<?php
// 公共的语言包都放到这里

// classic/breadcrumb.php
define('FALLWIND','fallwind');


// classic/order.info.php
//Content in My_dashboard
//2016-9-6 add by frankie
define('FIBERSTORE_ORDER_STATUS','Order Status');
define('FIBERSTORE_VIEW_DETAILS','View Details');
define('FIBERSTORE_ORDER_NUMBER','Order Number');
define('FIBERSTORE_ORDER_CUSTOMER_NAME','Customer Name');
define('FIBERSTORE_ORDER_TOTAL','Order Total');
define('FIBERSTORE_ORDER_PAYMENT','Payment');
define('FIBERSTORE_DASHBOARD_NO_ORDER','You don not have order.');


// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Ask ');
define('FS_DIALOG_A',' a question');
define('FS_DIALOG_TITLE','Title');
define('FS_DIALOG_YOUR','Your question subject is required');
define('FS_DIALOG_CONTENT','Content');
define('FS_DIALOG_PLEASE','Please enter your questions');
define('FS_DIALOG_YOUR2','Your content is required');
define('FS_DIALOG_PLEASE1',"Please don't exceed 3,000 characters.");
define('FS_DIALOG_EMAIL','E-mail address');
define('FS_DIALOG_AGAIN','This specified e-mail is invalid , please correct it and try again');
define('FS_DIALOG_COMMENTS','Comments/Questions');
define('FS_DIALOG_THIS','This field is required, Please write at least 10 characters.');



//common/account_left_slide.php
//Content in account left slide
//2016-9-8      add by Frankie
define('MY_ACCOUNT','My Account');
define('ORDER_CENTER','Order Center');
define('ALL_ORDER','All Orders');
define('PENDING_ORDER','Pending Orders');
define('TRANSACTION','Transaction Orders');
define('CANCELED_ORDER','Canceled Orders');
define('EXCHANGE','Returns');

define('MY_ADDRESS','My Address');
define('NEWSLETTER','Newsletter');
define('CHANGE_PASSWORD','Change Your Password');
define('MY_REVIEWS','My Reviews');
define('MY_QUESTION','My Questions');
define('MY_SALES_REPRESENTIVE','My Sales Representive');
define('MY_CONTACT','Contact');
define('FS_CONTACT_HELP','How can we help <br> you today?');
define('FS_CONTACT_CHAT','Chat Live Now');
//2017.5.12   add  by ery
define('ACCOUNT_LEFT_ADDRESS','Address');
define('ACCOUNT_LEFT_QUESTION','Questions');
define('ACCOUNT_LEFT_MANAGE','Manage Subscriptions');
define('ACCOUNT_LEFT_QUOTATION','Valid Quotation');
define('ACCOUNT_LEFT_QUOTATION_DETAIL','Valid Quotation Details');
define('ACCOUNT_LEFT_ORDER','Order History');


// 2018.11.29 fairy 个人中心改版
define('FS_MY_ACCOUNT','My Account');
define('ACCOUNT_SETTING','Account Settings');
define('FS_RETURN_ORDERS','Return Orders');
define('FS_MY_QUOTES','My Quotes');
define('FS_WISH_LIST','Wish List');
define('FS_ADDRESS_BOOK','Address Book');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">Back to</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">Homepage</a>');

// english.php
define("FS_COMMON_CONTINUE",'Continue');
define("FS_COMMON_OPERATION",'Operation');
define('FS_COMMON_VIEW','View');
define('FS_PURCHASE_ORDER_NUMBER','Purchase Order Number');
define('FS_FILE_UPLOADED_SUCCESS','File Uploaded Success');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","Allowed file types: PDF, JPG, PNG.");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Allowed file types: PDF, JPG, PNG. <br/>Max filesize is 4MB.");
define("FS_UPLOAD_PO_FILE",'Upload PO File');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Thank you for your shopping in FS, waiting for your next visiting.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Street address, c/o");
define("ADDRESS_PLACE_HODLER2","Apt, Suite, floor, etc.");
define("FS_ZIP_CODE","Zip Code");
define("FS_ADDRESS","Address");
define("FS_ADDRESS2","Address 2");
define('FS_CHECK_COUNTRY_REGION','Country/Region');
define("FS_CHECKOUT_ERROR1","Your First Name is required.");
define("FS_CHECKOUT_ERROR2","Your Last Name is required.");
define("FS_CHECKOUT_ERROR3","Your Address is required.");
define("FS_CHECKOUT_ERROR4","Your Zip Code is required.");
define("FS_CHECKOUT_ERROR5","Your City is required.");
define("FS_CHECKOUT_ERROR6","Your State is required.");
define("FS_CHECKOUT_ERROR7","Your Phone Number is required.");
define("FS_CHECKOUT_ERROR8","Your VAT/TAX NUMBER is required.");
define("FS_CHECKOUT_ERROR9","Your State is required.");
define("FS_CHECKOUT_ERROR10","Your Company Name is required.");
define("FS_CHECKOUT_ERROR11","Valid TAX/VAT eg:DE123456789");
define("FS_CHECKOUT_ERROR12","Address line 1 must be between 4 and 300 characters long.");
define("FS_CHECKOUT_ERROR13","Your first name must contain a minimum of 2 characters.");
define("FS_CHECKOUT_ERROR14","Your last name must contain a minimum of 2 characters.");
define("FS_CHECKOUT_ERROR15","Your ZIP/postal code should be at least 3 characters long.");
define("FS_CHECKOUT_ERROR16","We do not ship to PO Boxes.");
define("FS_CHECKOUT_ERROR17","Your Address Type is required.");
define("FS_CHECKOUT_ERROR28","Please enter a valid Postal Code");
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","Address line 2 must be between 4 and 35 characters long.");
define("FS_CITY_MIN_MAX_TIP","Address line 2 must be between 1 and 50 characters long.");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','All Orders');
define('FS_ORDER_PENDING','Pending');
define('FS_ORDER_COMPLETED','Completed');
define('FS_ORDER_CANCELLED','Canceled');
define('FS_ORDER_PURCHASE','Credit Order');
define('FS_ORDER_PROGRESSING','Progressing');
define('FS_ORDER_RETURN_ITEM','Returned Items');

define('FS_FILE_UPLOADED_SUCCESS_TXT','File has been uploaded successfully.');



// common/common_service.php
define('COMMON_SERVICE_01','Contact Us Now');
define('COMMON_SERVICE_02','FS focuses on data centre, enterprise and optical transmission network solution to help you build exactly what you need. <br> Get in touch, we are here to help 24/7. ');
define('COMMON_SERVICE_03','Find more ways to contact us');
define('COMMON_SERVICE_04','Online Chat');
define('COMMON_SERVICE_05','We are here to help 24/7. Message us now for a quick response.');
define('COMMON_SERVICE_06','Chat Now');
define('COMMON_SERVICE_07','Get a Call');
define('COMMON_SERVICE_08','Call ');
define('COMMON_SERVICE_09',', Or have us call you back.');
define('COMMON_SERVICE_10','Get a Call');
define('COMMON_SERVICE_11','Email');
define('COMMON_SERVICE_12','Our Customer Service Team will respond as soon as possible.');
define('COMMON_SERVICE_13','Email Now');
define('COMMON_SERVICE_14','Technical Support');
define('COMMON_SERVICE_15','Get free support &amp; solution design for your project online.');
define('COMMON_SERVICE_16','Request Support');
define('FS_SHOP_CART_ALERT_JS_13','From*');
define('FS_SHOP_CART_ALERT_JS_14','To*');
define('FS_SHOP_CART_ALERT_JS_15','Comments (optional) :');
//quote
define('FS_VIEW_QUOTE_SHEET','View Quote Sheet');
define('FS_PRODUCT_HAS_BEEN_ADDED','The product has been added.');
define('FS_SAVE_CSRT_LIMIT_TIP','Please enter the basket name maximum 50 words.');
define('FS_QUOTE','Quote');
define('FS_SAVED_CART_EMAIL','Email');



// common/create_account.php文件
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 15405 2010-02-03 06:29:33Z drbyte $
 */

//define('NAVBAR_TITLE', 'Create an Account');

define('HEADING_TITLE', 'My Account Information');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTE:</strong> If you already have an account with us, please login at the <a href="%s">login page</a>.');


// greeting salutation
define('EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', 'We wish to welcome you to <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations! To make your next visit to our online shop a more rewarding experience, listed below are details for a Discount Coupon created just for you!' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'To use the Discount Coupon, enter the ' . TEXT_GV_REDEEM . ' code during checkout:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>The coupon is valid between %s and %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Just for stopping by today, we have sent you a ' . TEXT_GV_NAME . ' for %s!' . "\n");
define('EMAIL_GV_REDEEM', 'The ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' is: %s ' . "\n\n" . 'You can enter the ' . TEXT_GV_REDEEM . ' during Checkout, after making your selections in the store. ');
define('EMAIL_GV_LINK', ' Or, you may redeem it now by following this link: ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','Once you have added the ' . TEXT_GV_NAME . ' to your account, you may use the ' . TEXT_GV_NAME . ' for yourself, or send it to a friend!' . "\n\n");

define('EMAIL_TEXT', 'You are now registered with our store and have account privileges:  With your account, you can now take part in the <strong>various services</strong> we have to offer you. Some of these many services include:' . "\n\n<ul>" . '<li><strong>Order History</strong> - View the details of orders you have completed with us.' . "\n\n" . '<li><strong>Permanent Basket</strong> - Any products added to your online basket remain there until you remove them, or check them out.' . "\n\n" . '<li><strong>Address Book</strong> - We can deliver your products to an address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.' . "\n\n" . '<li><strong>Products Reviews</strong> - Share your opinions on our products with other customers.' . "\n\n</ul>");
define('EMAIL_CONTACT', 'For help with any of our online services, please email the store-owner: <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE', "\n" . 'Sincerely,' . "\n\n" . STORE_OWNER . "\nStore Owner\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'This email address was given to us by you or by one of our customers. If you did not signup for an account, or feel that you have received this email in error, please send an email to %s ');



// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','About Us');
define('FS_ABOUT_FS_COM','About Us');
define('FS_FOOTER_WHY_US','Why Us');
define('LATEST_NEWS','News Room');
define('FS_FOOTER_LATEST','News Room');
define('FS_FOOTER_CONTACT_US','Contact Us');
// Frankie 2018.1.22
define('FS_IMPRINT','Legal Notice');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','Customer Service');
define('FS_FOOTER_OEM','OEM & Custom');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM',"OEM & Custom");
define('FS_FOOTER_WARRANTY','Warranty');
define('FS_FOOTER_POLICY','Return Policy');
define('FS_RETURN_POLICY','Return Policy');
define('FS_FOOTER_QUALITY','Quality Commitment');
define('FS_FOOTER_PARTNER','Business Account');

// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','Payment & Shipping');
define('FS_PAYMENT_METHODS','Payment Methods');
define('FS_NET_AMP_W',"Purchase Order");
define('FS_FOOTER_DELIVERY','Shipping & Delivery');

// footer Quick Help
define('FS_FOOTER_QUICK_HELP','Quick Help');
define('FS_FOOTER_PURCHASE_HELP','Purchase Help');
define('FS_FORGOT_YOUR_PASSWORD','Forgot Your Password?');
define('FS_FOOTER_FAQ','FAQ');
define('FS_TRACK_YOUR_PACKAGE','Track Your Package');

// footer Questions? Aron 2017.8.6
define("FS_YAO1","Questions? Talk to an expert");
define("FS_YAO2","We're here to help 24/7");
define("FS_YAO3","Live Chat");
define("FS_YAO4","Chat with a live representative");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Popular Pages:');    //小语种没有这个

// 手机站切换版本
define('FS_FULL_SITE','Email Us');
define('FS_MOBILE_SITE','Mobile Site');
define('FS_FOOTER_LIVE_CHAT','Live Chat');
define('FS_FOOTER_PHONE','+61 (2) 8317 1119');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新增
define("FS_HIGH_QUALITY","High Quality");
define("FS_SAFE_SHOPPING","Safe Shopping");
define("FS_FAST_DELIVERY","RETURN_DAYS-Day Return");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"Privacy and Cookies");
define('FS_TERMS_OF_USE_DE',"Terms and Conditions");
define('FS_SITE_MAP','Site Map');
define('FS_FOOTER_FEEDBACK','Leave Feedback');
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新增
define("FS_FOOTER_COPYRIGHT","Copyright 2009-".date('Y',time())." ".FS_LOCAL_COMPANY_NAME." All Rights Reserved.");
define("FS_FOOTER_COPYRIGHT_M","Copyright © 2009-YEAR <span>".FS_LOCAL_COMPANY_NAME."</span> All Rights Reserved.");
define("FS_FOOTER_SUPPORT","Support");
define("FS_FOOTER_COMMITMENT","Quality Commitment");
define("FS_FOOTER_INFORMATION","Information");
define("FS_FOOTER_POLICY_TO","Privacy Policy");
define('FS_FOOTER_REQUEST_A_SAMPLE','Request a Sample');
define('FS_HLEP_CENTER','FS Support');
//2018.11.28  au和uk站独有板块
define('FS_FOOTER_FOLLOW_US','Follow us');
define('FS_FOOTER_TRUSTED','Payment Methods:');


// common/header.php文件
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','10');
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','Chat Now');
define('FS_ONLINE_CAHT','Online Chat');
define('FS_LIVE_CAHT','Live Chat');
define('FS_PRE_SALE','Pre-Sale Service');
define('FS_CHAT_WITH','Chat with Online Sales for more information before purchase.');
define('FS_STAR','Start Chatting');
define('FS_AFTER_SALE','After-Sale Service');
define('FS_PL_GO','If you have made a purchase, please go to ');
define('FS_PAGE_TO','page to request Live Help for order details.');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','Search');
define('HOT_PRODUCTS','Hot Products');
define('FS_HEADER_01','Search...');
define('FS_HEADER_02','Hot Search');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','MTP MPO Cable');
define('FS_HEADER_09','LC Patch cables');
define('FS_HEADER_10','Attenuators');
define('FS_HEADER_11','Search History');
define('FS_HEADER_12','Clear the history');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新增
// top
define('FS_HELP_SUPPORT', 'Help & Support');
define('FS_CALL_US', 'Call Us');
define('FS_SAVED_CARTS', 'Saved Baskets');
// 用户相关
define('FS_ACCOUNT', 'Account');
define('FS_SIGN_IN','Sign in');
define('FS_NEW_CUSTOMER','New Customer?');
define('FS_REGISTER_ACCOUNT','Create an account');
define('FS_SIGN_OUT','Sign Out');
define('FS_MY_ACCOUNT','My Account');
define('FS_MY_ORDERS','My Orders');
define('FS_MY_ORDER','My Order');
define('FS_MY_ADDRESS','My Address');
define('FS_SOLUTIONS','Solutions');
define('FS_ALL_CATEGORIES','All Categories');
define('FS_HEADER_SEARCH','Search');
define('FS_PROJECT_INQUIRY','Project Inquiry');
define('FS_SEE_ALL_OFFERINGS','See all offers');
define('FS_RESOURCES','Resources');
define('FS_RELATED_INFO','Related Info');
define('FS_CONTACT_US','Contact Us');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Products may have different prices and availability based on country/region.');
define('FS_NEW_LANGUAGE_CURRENCY','Language/Currency');
define('FS_COUNTRY_REGION','Country/Region');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','Main Menu');
define('FS_NETWORKING','Networking');
define('FS_ORDER_HISTORY','Order History');
define('FS_ADDRESS_BOOK','Address Book');
define('FS_MY_CASES','Support Tickets');
define('FS_MY_QUOTES','My Quotes');
define('FS_ACCOUNT_SETTING','Account Setting');
define('FS_VIEW_ALL','View all');

// 搜索
define('FS_SEARCH_PRODUCTS','Search Products');
define('FS_NEW_CHOOESE_CURRENCY','Choose Currency');
// 2018.7.23 fairy help
define('FS_NEED_HELP_BIG','Need Help');
define('FS_CHAT_LIVE_WITH_US','Live chat with us');
define('FS_SEND_US_A_MESSAGE','Send us a message');
define('FS_E_MAIL_NOW','Email Now');
define("FS_LIVE_CHAT","Live Chat");
define("FS_WANT_TO_CALL","Want to call?");
define("FS_BREADCRUMB_HOME","Home");
/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Get technical support');
define('FS_CHAT_LIVE_WITH_GET_A','Ask an Expert');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Fast Shipping & Easy Returns');
define('HEADER_FREE_SHIPPINH_02','FREE Shipping over %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','and more shipping options to fit your time schedule and budget.');
define('HEADER_FREE_SHIPPINH_04','SAME Day Shipping');
define('HEADER_FREE_SHIPPINH_05','with large inventories based on our multi-warehouses system.');
define('HEADER_FREE_SHIPPINH_06','30-DAY Return');
define('HEADER_FREE_SHIPPINH_07','on most orders if something is not quite right.');
define('HEADER_FREE_SHIPPINH_08','Any item with “Free Shipping” messaging on the product page is eligible for Free Shipping. FS.COM reserves the right to change this offer at any time. Read more on <a href="'.reset_url("information/shipping_delivery.html").'">shipping policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');
define('HEADER_FREE_SHIPPINH_09','Shipping outside your country? Switch to the destination country on website to check out the proper policies.');
define('HEADER_FREE_SHIPPINH_10','Fast Delivery & Easy Returns');
define('HEADER_FREE_SHIPPINH_11','FREE Delivery over %s');//%s不用翻译替换的是价格,如79€
define('HEADER_FREE_SHIPPINH_12','and more delivery options to fit your time schedule and budget.');
define('HEADER_FREE_SHIPPINH_13','SAME Day Shipping');
define('HEADER_FREE_SHIPPINH_14','Any item with “Free Delivery” messaging on the product page is eligible for Free Delivery. Orders delivered to remote districts are unable to enjoy free delivery service. FS.COM reserves the right to change this offer at any time. Read more on <a href="'.reset_url("information/shipping_delivery.html").'">delivery policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');
define('HEADER_FREE_SHIPPINH_15','Delivery outside your country? Switch to the destination country on website to check out the proper policies.');
define('HEADER_FREE_SHIPPINH_16','310,000+ Inventory');
define('HEADER_FREE_SHIPPINH_17','for optic and networking products to support your needs.');
define('HEADER_FREE_SHIPPINH_18','Shipping time may be influenced by inventories. Read more on <a href="'.reset_url("information/shipping_delivery.html").'">shipping policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');
define('HEADER_FREE_SHIPPINH_19','Shipping time may be influenced by inventories. Read more on <a href="'.reset_url("information/shipping_delivery.html").'">delivery policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Help & Setting');

// 浏览器
define('FS_UPGRADE','UPGRADE YOUR BROWSER');
define('FS_UPGRADE_TIP','You are running an older browser. Please upgrade your browser for better experience.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','Explore Solutions');
define('FS_INDEX_CATE_PRODUCTS','Products');


// common/left_side_bar_for_tag.php
define('FIBERSTORE_TRANS1','Find by Network Device');
define('FIBERSTORE_TRANS2','Find by Orignal Model');
define('FIBERSTORE_CLEAR','Clear Selections');


// common/patch_panel.php
define('PATCH_PANEL_01','How to get more support?');
define('PATCH_PANEL_02','FS focus on data centre, enterprise and optical transmission network solution to help you build exactly what you need.');
define('PATCH_PANEL_03','Email us at <a href="mailto:tech@fs.com">tech@fs.com</a> or <a href="mailto:au@fs.com">au@fs.com</a>.');


// common/phone.php
//各国电话语言包 2017.8.18  ery
define('FS_PHONE_US','+61 3 9693 3488');		// United States
define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 5808 7203');		// Hong Kong
define('FS_PHONE_MX','+52 (55) 3098 7566');		// Mexico
define('FS_PHONE_CA','+1 (647) 243 6342');		// Canada
define('FS_PHONE_BR','+55 (11) 4349 6175');		// Brazil
define('FS_PHONE_AR','+54 (11) 5031 9542');		// Argentina
define('FS_PHONE_GB','+44 (0) 121 716 1755');	// United Kingdom
define('FS_PHONE_FR','+33 (1) 82 884 336');		// France
define('FS_PHONE_NL','+31 (20) 241 4029');		// Netherlands
define('FS_PHONE_AU','+61 3 9693 3488');		// Australia
define('FS_PHONE_ES','+34 (91) 123 7299');		// Spain
define('FS_PHONE_RU','+7 (499) 643 4876');		// Russian Federation
define('FS_PHONE_SG','+(65) 3163 0003');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+44 (0) 121 716 1755');	// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_WH','+86 (027) 87639823');         //wuhan
define('FS_PHONE_US_TWO','+1 (253) 277 3058');		// United States2
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_SITE_EU','+49 (0) 8165 80 90 517');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 3 9693 3488');
define('FS_PHONE_SITE_JP','+1 (877) 205 5306');
define('FS_PHONE_SITE_SG','+(65) 3163 0003');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}
define('FS_PHONE_PO_AU','+61 3 9693 3488');
if($_SESSION['languages_code']=='sg'){
    define('FS_COMMON_PHONE','+(65) 6443 7951');
}else{
    define('FS_COMMON_PHONE','+61 3 9693 3488');
}
define('FS_PHONE_US_EAST','+1(888) 468 7419');


//美东电话
define('FS_PHONE_US_EAST','+1 (888) 468 7419');
//武汉仓电话
define('FS_PHONE_CN','+86 (027) 87639823');
if($_SESSION['languages_code']=='sg'){
    define('FS_COMMON_PHONE','+(65) 6443 7951');
}else{
    if(US_WAREHOUSE_UP){
        define('FS_COMMON_PHONE','+1 (888) 468 7419');
    }else{
        define('FS_COMMON_PHONE','+1 (877) 205 5306');
    }

}



// common/save_shopping_list.php
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','FS.COM - You have saved a basket list for yourself');
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT_1','FS.COM - You have a Basket List from ');
define('EMAIL_SAVE_DEAR','Dear Present You');
//2017.5.30		add		ery
define('FS_AJAX_PAST','Past you was shopping on FS.COM and wanted to save this page & message for your own!');
define('FS_AJAX_THIS','This email was sent by your own using FS.COM\'s Share With A Friend service. As a result of receiving this message, you will not receive any unsolicited message from FS.COM, learn more about our ');
define('FS_AJAX_PRIVACY','Privacy Policy');
define('FS_AJAX_WAS',' was shopping on FS.COM and wanted to share this page & message with you!');
define('FS_AJAX_SENT','This email was sent by your friend ');
define('FS_AJAX_USING',' using FS.COM\'s Share With A Friend service. As a result of receiving this message, you will not receive any unsolicited message from FS.COM, learn more about our ');


// common/tracking_info.php
define('MY_ORDER_SUCCESSFULLY','Order submitted successfully, wait for your payment.');
define('MY_ORDER_WAIT','You have paid successfully, please wait for shipment.');
define('FIBERSTORE_BY_SYSTEM','by the system');
define('FIBERSTORE_SESTEM','FS.COM system');
define('FIBERSTORE_INFO_TIME','Processing Time');
define('FIBERSTORE_INFO_PROCESS','Process Information');
define('FIBERSTORE_INFO_OPERATOR','Process Operator');


// functions/functions_tutorial.php
//fallwind	2016.8.22	fallwind_test	add
define('ABC','abcabc');


// functions/product_instock.php
define('FS_SHIP_PC',' pc');
define('FS_SHIP_PCS',' pcs');
define('FS_SHIP_ROLL',' Roll');
define('FS_SHIP_ROLLS',' Rolls');
define('FS_SHIP_ROLL_1KM',' <em>(1Roll = 1KM)</em>');
define('FS_SHIP_ROLL_2KM',' <em>(1Roll = 2KM)</em>');
define('FS_SHIP_AVAI','Available');
define('FS_SHIP_STOCK',' in stock');
define('FS_SHIP_DEVE','Development');
//define('FS_SHIP_ESTIMATED','Estimated on ');

define('FS_SHIP_ESTIMATED','Ship on ');
define('FS_SHIP_INVENTORY','Inventory Shortage, Shipment Available on ');
define('FS_SHIP_PLACE','Orders placed today will ship within ');
define('FS_SHIP_DAYS',' business days');
define('FS_SHIP_TIP',' Items will be shipped to you upon arrival at Melbourne warehouse from our oversea warehouses.');


/*
 * author aron
 * date 2019.6.28
 * 信用卡提示语
 */

define("CREDIT_HOLDER_NAME_ERROR1","The Cardholder Name is required.");
define("CREDIT_HOLDER_NAME_ERROR2","The Cardholder Name is wrong, please enter it again.");
define("CREDIT_CARD_NUMBER_ERROR1","The Card Number is required.");
define("CREDIT_CARD_NUMBER_ERROR2","The Card Number does not exist. Please enter a valid one.");
define("CREDIT_CARD_DATE_ERROR1","The Expiration Date is required");
define("CREDIT_CARD_DATE_ERROR2","The Expiration Date is wrong, please enter it again.");
define("CREDIT_CARD_CODE_ERROR1","The Security Code is required.");
define("CREDIT_CARD_CODE_ERROR2","The Security Code is wrong, please enter it again.");

//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', 'Performance Test');
define('NEW_PATCH_PANEL_02', 'All Ethernet network cables pass Fluke Channel Test.');
define('NEW_PATCH_PANEL_03', 'Quality Assurance');
define('NEW_PATCH_PANEL_04', 'CE, RoHS, ISO9001 quality certification guaranteed.');
define('NEW_PATCH_PANEL_05', 'Large Stock');
define('NEW_PATCH_PANEL_06', 'Sufficient inventory for same day shipping.');
define('NEW_PATCH_PANEL_07', 'Cost-Efficient');
define('NEW_PATCH_PANEL_08', 'We offer the best price to help saving your budget.');

define('NEW_PATCH_PANEL_01_209', 'Rigorous Test Program');
define('NEW_PATCH_PANEL_02_209', 'End-Face Inspection &amp; IL Loss &amp; RL Loss.');

define('NEW_PATCH_PANEL_01_1', 'High Flexibility');
define('NEW_PATCH_PANEL_02_1', 'Flexible to meet various fiber transmission needs.');
define('NEW_PATCH_PANEL_04_1', 'We set rigid test standards to guarantee the highest quality.');

define('NEW_PATCH_PANEL_01_911', 'Fast Delivery');
define('NEW_PATCH_PANEL_02_911', 'Local warehouses covering global markets save your valuable time.');

define('NEW_PATCH_PANEL_01_9', 'Wide Compatibility');
define('NEW_PATCH_PANEL_02_9', 'Compatible with all major vendors and systems.');
define('NEW_PATCH_PANEL_04_9', 'CE, RoHS, IEC, FCC, ISO9001, FDA quality certification guaranteed.');

define('NEW_PATCH_PANEL_02_4', 'All products are tested to meet the standard requirement.');
define('NEW_PATCH_PANEL_08_4', 'We offer the best price to help saving your budget.');


//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0"><tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">This email was sent by <a style="color: #232323;text-decoration: none;" href="javascript:;"></a> using <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>. As a result of receiving this message, you will not receive any unsolicited message from <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>. learn more about our <a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Privacy Policy</a>.</td></tr></table>');


//sample_application页面
//邮件
define('SAMPLE_EMAIL_DEAR','Dear');
define('SAMPLE_EMAIL_01', 'We\'ve received your request and our team will be in touch soon.');
define('SAMPLE_EMAIL_02', 'Here is your case number <a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>. You can refer to this number in all follow-up communications regarding this request.');
define('SAMPLE_EMAIL_03', 'Contact Info: ');
define('SAMPLE_EMAIL_04', 'Email: ');
define('SAMPLE_EMAIL_05', 'Country: ');
define('SAMPLE_EMAIL_06', 'Phone No: ');
define('SAMPLE_EMAIL_07', 'Your additional comments: ');
define('SAMPLE_EMAIL_08', 'Thanks');
define('SAMPLE_EMAIL_09', 'The FS Team');
define('SAMPLE_EMAIL_30', 'Here is your case number <a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>. You can refer to this number in all follow-up communications through <a style="color: #0070bc;text-decoration: none" href="$HREF">online case center</a> regarding this request.');

define('FS_CONTACT_GET_SUPPORT','Get in touch with us via email. We\'d like to help with any questions you have.');
define('FS_CONTACT_LEAVE','Leave a Message');

define('CUSTOMER_SERVICE_OTHERS_46', 'Already have an account? <a style="color: #0070bc;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Sign in</a> or <a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Create an account</a>');
define('CUSTOMER_SERVICE_OTHERS_47', '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Sign in</a> or <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Create an Account</a> to get personalized services.');
define('CUSTOMER_SERVICE_OTHERS_48', 'Already have an account? <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Sign in</a> or <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Create an account</a>');


//服务页面公用
define('FS_SUPPORT_FORM_TXT','Please fill out the info. We’ll get in touch ASAP.');
define("FS_SUPPORT_EMAIL","Email");
define('FS_PLEASE_ENTER_COMMENTS','Please write down more comments about your request.');
define('FS_SUPPORT_FORM_PLACEHOLDER','Your comments will help FS respond more quickly.');
define('FS_COMMON_AT_LEAST','Please write the content with more than 3 characters.');
define('FS_COMMON_AT_MOST','Your content must be 1000 characters maximum.');
define('FS_SUPPORT_PHONE','Phone');
define('FS_FIRST_NAME_PLEASE','Please enter your first name.');
define('FS_LAST_NAME_PLEASE','Please enter your last name.');
define('FS_SUPPORT_COMMENTS','Comments');
define('FS_SUPPORT_FIRST_NAME','First Name');
define('FS_SUPPORT_LAST_NAME','Last Name');
define('SOLUTION_PRIVACY_POLICY',' I agree to FS\'s <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>Privacy Policy</a> and <a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'>Terms of Use</a>.');
define('FS_SUPPORT_EMAIL_TOUCH_SOON','We\'ve received your support request and our team will be in touch soon.');

//shopping_cart save_items 页面的 meta标签 2019.12.23 
define('META_TAGS_SHOPPING_CART_TITLE', 'Shopping Basket');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', 'Shop for best Data Centre, Enterprise Network, and Internet Access products. We make it easy and cost-effective for IT professionals to enable their business solution.');
define('META_TAGS_SAVED_ITEMS_TITLE', 'Saved Baskets');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', 'After you add items to basket, click "Save Basket" to save collections of items. You can create as many saved baskets as you would like, and you can use saved baskets for repeated orders.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Stock List of 10G CWDM/DWDM SFP+');
define('META_TAGS_SFP_DESCRIPTION', 'The full product portfolio of 10G CWDM/DWDM SFP+ Transceivers (DWDM SFP+ 80km/40km,CWDM SFP+ 80km/40km/20km/10km) gives quick overview of product inventory and provides help with the WDM Solutions.');


//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','Explore How We Reach Your Goals');
define('FS_SPECIAL_DESIGN_CENTER','Design Centre');
define('FS_SPECIAL_DESIGN_CENTER_DES','Expertise in incorporating requirements and<br> providing an innovative, cost-effective<br> and reliable one-stop solution.');
define('FS_SPECIAL_QUALITY','Quality Centre');
define('FS_SPECIAL_QUALITY_DES','Provide high quality products with strict tests<br> and industry standard certifications. ');
define('FS_SPECIAL_TEC','Technical Support');
define('FS_SPECIAL_TEC_SMALL','Request support');
define('FS_SPECIAL_TEC_DES','Get free support & solution design for your<br/>project online.');
define('FS_SUBMIT_SUCCESS','Your request ##number## has been submitted successfully.');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','We will reply you within 1-3 hours via phone or email during working days.');

define('SAMPLE_EMAIL_31', 'Address: ');
define('SAMPLE_EMAIL_32', 'Request Qty: ');
define('SAMPLE_EMAIL_33', 'Sample List');

define('FS_BROWSING_HISTORY','Recently Viewed');

define('FS_PRODUCT_DOWNLOAD', 'Downloads');
define('FS_PRODUCT_MORE', 'Learn more');
define('FS_PRODUCT_SUPPORT','Product Support');

//结算页、订单确认成功页、银行转账邮件、订单详情
define("PAYMENT_BANK_ACH","Wire/ACH Transfer");
define("PAYMENT_BANK_ACH_CA","Wire Transfer");
define("PAYMENT_BANK_OF_US","Bank of America");
define("PAYMENT_BANK_VIA","Via Wire Transfer");
define("PAYMENT_BANK_ACCOUNT_NAME","FS COM INC");
define("PAYMENT_BANK_WIRE_ROUTING","Wire Routing #:");
define("PAYMENT_BANK_SWIFT_CODE","Swift Code:");
define("PAYMENT_BANK_ACH_ROUTING","ACH Routing #:");
define("PAYMENT_BANK_VIA_ACH","Via ACH");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",FIBER_CHECK_COMMON_ACCOUNT_NAME);
define("PAYMENT_BANK_ACCOUNT",FS_COMMON_HEADER_ACCOUNT.' #:');
define("PAYMENT_BANK_ADDRESS",FS_ADDRESS_ADDRESS.':');

// QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL','Qty');
define('FS_QV_QUICK_VIEW','Quickview');
define('FS_SEE_FULL_DETAILS','View details');
define('FS_CUSTOMIZED','Add to Basket');
define('FS_PRODUCTS_INFORMATION','Products Information');
define('FS_CUSTOMER_ALSO_VIEWED','Customers Also Viewed');

// fairy 2019.1.15 add 公共标题需要
define('FS_TITLE_COMPATIBLE','Compatible');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'Buy Again');
define('FS_BUY_MORE_02', 'Items purchased through Buy Again will be totally the same as your order %s.');
define('FS_BUY_MORE_03', 'Item is the same as previous order %s.');


//头部下拉版块
define('FS_HEADER_SUPPORT','Support');
define('FS_HEADER_TEC_SUPPORT','Technical Support');
define('FS_HEADER_CUSTOMER_SUPPORT','Customer Support');
define('FS_HEADER_SERVICE_SUPPORT','Service Support');
define('FS_HEADER_TEC_DES',' Find documents, case studies, videos, and more in our resource library, or request technical support to get tailored solutions.');
define('FS_HEADER_TEC_URL_01','Technical Documents');
define('FS_HEADER_TEC_URL_02','Test Bed');
define('FS_HEADER_TEC_URL_03','Software Download');
define('FS_HEADER_TEC_URL_04','Quality Commitment');
define('FS_HEADER_TEC_URL_05','Case Studies ');
define('FS_HEADER_TEC_URL_06','Warranty Query');
define('FS_HEADER_TEC_URL_07','Video Library');
define('FS_HEADER_SUPPORT_RIGHT_DES','FS Experts Service Offerings');
define('FS_HEADER_SUPPORT_RIGHT_URL','Get in touch');
define('FS_HEADER_CUSTOMER_DES','Get instant help before or after purchasing: order inquiry, order placing, order tracking, or other related issues.');
define('FS_HEADER_CUSTOMER_URL_01','Request Quote');
define('FS_HEADER_CUSTOMER_URL_02','Request Return & Refund');
define('FS_HEADER_CUSTOMER_URL_03','Request Sample');
define('FS_HEADER_CUSTOMER_URL_04','Net Terms');
define('FS_HEADER_CUSTOMER_URL_05','Submit a PO');
define('FS_HEADER_CUSTOMER_URL_07','Track Your Items');
define('FS_HEADER_CUSTOMER_URL_08','New Products');
define('FS_HEADER_CUSTOMER_URL_09','Deals');
define('FS_HEADER_CUSTOMER_URL_10','Product Verification');
define('FS_HEADER_CUSTOMER_URL_11','Request Demo');
define('FS_HEADER_SERVICE_DES','Explore popular topics on account, shipping, returns, etc, FS is committed to bringing you the simplest buying experience.');
define('FS_HEADER_SHIPPING_DELIVERY','Shipping & Delivery');
define('FS_HEADER_RETURN_POLICY','Return Policy');
define('FS_HEADER_PAYMENT','Payment Methods');
define('FS_HEADER_HELP_CENTER','FS Support');
define('FS_HEADER_COMPANY','Company');
define('FS_HEADER_ABOUT_US','About Us');
define('FS_HEADER_CONTACT_US','Contact Us');
define('FS_HEADER_NEWS','Partners');
define('FS_HEADER_ABOUT_DES','FS is a global leading communications hardware and project solutions provider. We are dedicated to helping you build, connect, protect and optimize your optical infrastructure.');
define('FS_HEADER_ABOUT_EXPLORE','Explore FS');
define('FS_HEADER_CONTACT_DES','We\'re here to help. Welcome to contact us at any time for the quick & best technical support & customer service.');
define('FS_HEADER_LEARN_MORE','Learn more');
define('FS_HEADER_NEWS_DES','FS provides tailored, cost-effective network solutions for your business. Our products and service is trusted by some of the world\'s most influential corporations.');
define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('company/fiberstore_with_partners.html').'"><span>Meet Our Partners</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_RIGHT_DES','FS Achieves a Series of Authoritative International Certification');
define('FS_HEADER_NEWS_RIGHT_DATE','June 8, 2020');

define('FS_CUSTOMER_SUPPORT_TIP','The item#XXX is customized, please contact your account manager for details.');

//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','Quotes');
define('FS_ACCOUNT_TW_CREDIT','Credit Account');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','Credit Details');
define('FS_ACCOUNT_TW_USER','User Information');
define('FS_ACCOUNT_TW_SUPPORT','Support Tickets');
define('FS_ACCOUNT_TW_TAX','Tax Exempt Apply');
define('FS_ACCOUNT_TW_USEFUL','Useful Tools');
define('FS_ACCOUNT_TW_ACCOUNT','Account Information');
define('FS_ACCOUNT_TW_YOU','You have order(s) that has not been paid yet.');
define('FS_ACCOUNT_TW_ORDERS','Orders');
define('FS_ACCOUNT_TW_MOST_ORDER','Most Recent Order');
define('FS_ACCOUNT_TW_VIEW_ORDERS','View All Orders');
define('FS_ACCOUNT_TW_ORDERS_SEARCH','Order #, PO #, Item #, P/N, Comments...');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','Pending Payment');
define('FS_ACCOUNT_TW_WAIT','Wait For Shipping');
define('FS_ACCOUNT_TW_TRANSIT','In Transit');
define('FS_ACCOUNT_TW_DELIVERED','Delivered');
define('FS_ACCOUNT_TW_PENDING_REVIEW','Pending Review');
define('FS_ACCOUNT_TW_NO_ORDER','No Orders Found.');
define('FS_ACCOUNT_TW_VIEW_CART','View Basket');
define('FS_ACCOUNT_TW_VIEW_TICKETS','View All Tickets');
define('FS_ACCOUNT_TW_CREATE_TICKET','Create New Ticket');
define('FS_ACCOUNT_TW_SEARCH_TICKET','Ticket #, Content…');
define('FS_ACCOUNT_TW_TICKET','Ticket #');
define('FS_ACCOUNT_TW_TICKET_TYPE','Support Type');
define('FS_ACCOUNT_TW_TICKET_COMMENT','Content');
define('FS_ACCOUNT_TW_TICKET_DATE','Submition Date');
define('FS_ACCOUNT_TW_TICKET_STATUS','Status');
define('FS_ACCOUNT_TW_TICKET_ACTION','Action');
define('FS_ACCOUNT_TW_NO_TICKET','No Ticket History.');
define('FS_ACCOUNT_TW_ORDER','Order #');
define('FS_ACCOUNT_TW_SPLIT_ORDER','Split Order');
define('FS_ACCOUNT_TW_DELIVERY','Delivery');
define('FS_ACCOUNT_TW_DELIVERY_ON','Delivered on ');
define('FS_ACCOUNT_TW_THE','The following product(s) cannot be ordered again directly for the specific reason below.Click the button "Skip and Continue" to add the remaining product(s) to basket again.');
define('FS_ACCOUNT_TW_THE_NO','The following product(s) cannot be ordered again directly for the specific reason below.');
define('FS_ACCOUNT_TW_ITEMS','Items purchased through Buy Again will be totally the same as your order #%s.');
define('FS_ACCOUNT_TW_YOU_CAN','You can use this button to bring all the products in this order into basket again.');
define('FS_ACCOUNT_TW_ORDER_AGAIN','Order Again');
define('FS_ACCOUNT_TW_CREATE_TICKET','Create a New Ticket');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','Support Type');
define('FS_ACCOUNT_TW_ATTACH_PO','Attach PO');
define('FS_ACCOUNT_TW_SHOW_MORE','Show More');
define('FS_ACCOUNT_TW_BASIC_INFO','Basic Information');
define('FS_ACCOUNT_TW_ADDRESS_INFO','Address Information');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','Add the below product(s) to Basket, and Create Quote.');
define('FS_ACCOUNT_TW_MOST_QUOTE','Recent Quotes');
define('FS_ACCOUNT_TW_VIEW_QUOTES','View All Quotes');
define('FS_ACCOUNT_TW_NO_QUOTE','No Quotes Found.');
define('FS_ACCOUNT_TW_QUOTE_ITEM','Quote #, Item #');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','The following product(s) cannot be quoted again directly for the specific reason below.');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','The following product(s) cannot be quoted again directly for the specific reason below. Click the botton "Skip and Continue" to add the remaining product(s) to basket again and create quote.');

//售后发货仓
define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH</dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Germany</dd>
			<dd>Tel: +49 (0) 8165 80 90 517</dd>');

define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC</dt>
			<dd>Address: 380 Centerpoint Blvd, New Castle, DE 19720, United States</dd>
			<dd>Tel: +1 (888) 468 7419</dd>');
// 美东仓
define('FS_RMA_WAREHOUSE_US_EAST','<dt>ATTN: FS.COM Inc.</dt>
					<dd>Address: 380 Centerpoint Blvd, New Castle, DE 19720, United States</dd>
					<dd>Tel: +1 (888) 468 7419</dd>');
// 澳洲仓 （澳大利亚）
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australia</dd>
				<dd>Tel: +61 3 9693 3488</dd>
				<dd>ABN: 71 620 545 502</dd>');
// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>ATTN: FS Tech Pte Ltd.</dt>
				<dd>Address: 30A Kallang Place #11-10/11/12, Singapore 339213</dd>
				<dd>Tel: +(65) 6443 7951</dd>');
//俄罗斯仓
define('FS_RMA_WAREHOUSE_RU','<dt>《FiberStore.COM》Ltd.</dt>
             <dd>o.4062, d. 6, str. 16, Proektiruemyy proezd, Moscow 115432, Russian Federation</dd>  
            <dd>Tel: +7 (499) 643 4876</dd>');

// 武汉仓
define('FS_RMA_WAREHOUSE_CN','<dt>ATTN: FS. COM LIMITED</dt> 
			<dd>Address: A115 Jinhetian Business Centre No.329, Longhuan Third Rd Longhua District Shenzhen, 518109, China</dd>
			<dd>Tel: +86-0755-83571351</dd>');

define('FS_FOOTER_EXPLORE','EXPLORE');
define('FS_HEADER_NEW_PRODUCT','New Product');
define('FS_HEADER_CHANGE','Change');
define('FS_COMMON_VIEW_MORE','View More');
define('FS_CART_EMPTY_TIP','Sign in to see if you have any saved items. Or continue shopping.');
define('BIllS_TIPS1','You can check all your invoices here.');
define('BIllS_TIPS2','You can check your credit account status and all invoices here.');
define('TIPS_BUTTON', 'I got it!');
define('TIPS_NEW', 'New');
define('FS_ATTRIBUTE_CUSTOMIZED','Customised');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' years');
define('FS_WARRANTY_YEAR',' year');
define('FS_WARRANTY_DAYS',' days');
define('FS_WARRANTY_CONSUMABLE','Consumable');
define('FS_WARRANTY_UNAVAILABLE','Unavailable');
define('FS_WARRANTY_SUB_CATEGORY','Sub-category');
define('FS_WARRANTY_RETURN','Return<br>Window');
define('FS_WARRANTY_CHANGE','Exchange <br> Window');
define('FS_WARRANTY_PERIOD','Warranty<br>Period');

define('FS_WARRANTY_NOTE','Notes');

define('ORDER_PAYMENT_TIPS','Please make sure the billing address above matches what appears on this credit card\'s statements.');
define('ORDER_PAYMENT_SAFE','Secure and Encrypted');
define('ORDER_PAYMENT_TIPS_2','Your data will only be used to process this order and will not be saved by FS .');
