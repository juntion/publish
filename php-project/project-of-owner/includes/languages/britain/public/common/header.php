<?php
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','9');
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

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
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
define('FS_PROJECT_INQUIRY','Project Inquiry');
define('FS_SEE_ALL_OFFERINGS','See all offers');
define('FS_RESOURCES','Resources');
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
define('FS_MY_CASES','My Cases');
define('FS_MY_QUOTES','My Quotes');
define('FS_ACCOUNT_SETTING','Account Setting');
define('FS_VIEW_ALL','View all');

// 搜索
define('FS_SEARCH_PRODUCTS','Search Products');
define('HOT_PRODUCTS','Hot Products'); 
define('FS_NEW_CHOOESE_CURRENCY','Choose Currency');
// 2018.7.23 头部 need help
define('FS_NEED_HELP_BIG','Need Help?');
define('FS_CHAT_LIVE_WITH_US','Chat live with us');
define('FS_SEND_US_A_MESSAGE','Send us a message');
define('FS_E_MAIL_NOW','E-mail Now');
define("FS_LIVE_CHAT","Live Chat");
define("FS_WANT_TO_CALL","Want to call?");
define("FS_BREADCRUMB_HOME","Home");
/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Get technical support');
define('FS_CHAT_LIVE_WITH_GET_A','Ask an expert');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Fast Shipping & Easy Returns');
define('HEADER_FREE_SHIPPINH_02','FREE Shipping over %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','and more shipping options to fit your time schedule and budget.');
define('HEADER_FREE_SHIPPINH_04','SAME Day Shipping');
define('HEADER_FREE_SHIPPINH_05','with large inventories based on our multi-warehouses system.');
define('HEADER_FREE_SHIPPINH_06','30-DAY Return');
define('HEADER_FREE_SHIPPINH_07','on most orders if something is not quite right.');
define('HEADER_FREE_SHIPPINH_08','Any item with “Free Shipping” messaging on the product page is eligible for Free Shipping. FS.COM reserves the right to change this offer at any time. Read more on <a href="'.zen_href_link('shipping_delivery').'">shipping policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');
define('HEADER_FREE_SHIPPINH_09','Shipping outside your country? Switch to the destination country on website to check out the proper policies.');
define('HEADER_FREE_SHIPPINH_10','Fast Delivery & Easy Returns');
define('HEADER_FREE_SHIPPINH_11','FREE Delivery over %s');//%s不用翻译替换的是价格,如79€ 
define('HEADER_FREE_SHIPPINH_12','and more delivery options to fit your time schedule and budget.');
define('HEADER_FREE_SHIPPINH_13','SAME Day Shipping');
define('HEADER_FREE_SHIPPINH_14','Any item with “Free Delivery” messaging on the product page is eligible for Free Delivery. FS.COM reserves the right to change this offer at any time. Read more on <a href="'.zen_href_link('shipping_delivery').'">delivery policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');
define('HEADER_FREE_SHIPPINH_15','Delivery outside your country? Switch to the destination country on website to check out the proper policies.');
define('HEADER_FREE_SHIPPINH_16','310,000+ Inventory');
define('HEADER_FREE_SHIPPINH_17','for optic and networking products to support your needs.');
define('HEADER_FREE_SHIPPINH_18','Shipping time may be influenced by inventories. Read more on <a href="'.zen_href_link('shipping_delivery').'">shipping policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');
define('HEADER_FREE_SHIPPINH_19','Shipping time may be influenced by inventories. Read more on <a href="'.zen_href_link('shipping_delivery').'">delivery policy</a> or <a href="'.zen_href_link('day_return_policy').'">return policy</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Help & Setting');

// 浏览器
define('FS_UPGRADE','UPGRADE YOUR BROWSER');
define('FS_UPGRADE_TIP','You are running an older browser. Please upgrade your browser for better experience.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','Featured Portfolios');
define('FS_INDEX_CATE_PRODUCTS','Products');