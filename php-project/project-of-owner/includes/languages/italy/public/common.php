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
define('FIBERSTORE_ORDER_PAYMENT','Payment');
define('FIBERSTORE_DASHBOARD_NO_ORDER','You don not have order.');

// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Ask ');
define('FS_DIALOG_A',' a question');
define('FS_DIALOG_TITLE','Title');
define('FS_DIALOG_YOUR','Your question subject is required');
define('FS_DIALOG_CONTENT','Contenuto');
define('FS_DIALOG_PLEASE','Please enter your questions');
define('FS_DIALOG_YOUR2','Your content is required');
define('FS_DIALOG_PLEASE1',"Please don't exceed 3,000 characters.");
define('FS_DIALOG_EMAIL','E-mail address');
define('FS_DIALOG_AGAIN','This specified e-mail is invalid , please correct it and try again');
define('FS_DIALOG_COMMENTS','Comments/Questions');
define('FS_DIALOG_THIS','This field is required, Please write at least 10 characters.');


// common/account_left_slide.php
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
define('FS_MY_ACCOUNT','Mio Account');
define('ACCOUNT_SETTING','Impostazioni account');
define('FS_RETURN_ORDERS','Return Orders');
define('FS_WISH_LIST','Wish List');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">Back to</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">Homepage</a>');

// english.php
define("FS_COMMON_CONTINUE",'Continue');
define("FS_COMMON_OPERATION",'Operation');
define('FS_COMMON_VIEW','Visualizza');
define('FS_PURCHASE_ORDER_NUMBER','Purchase Order Number');
define('FS_FILE_UPLOADED_SUCCESS','File Uploaded Success');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","Allowed file types: PDF, JPG, PNG.");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Allowed file types: PDF, JPG, PNG. <br/>Max filesize is 4MB.");
define("FS_UPLOAD_PO_FILE",'Upload PO File');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Grazie per aver fatto shopping in FS, speriamo di rivederti di nuovo.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Indirizzo, c/o");
define("ADDRESS_PLACE_HODLER2","Appartamento, Suite, piano, etc.");
define("FS_ZIP_CODE","Codice postale");
define("FS_ADDRESS","Indirizzo");
define("FS_ADDRESS2","Indirizzo 2");
define('FS_CHECK_COUNTRY_REGION','Paese/Zona');
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
define('FS_ORDER_ALL','Tutti gli ordini');
define('FS_ORDER_PENDING','In sospeso');
define('FS_ORDER_COMPLETED','Completato');
define('FS_ORDER_CANCELLED','Annullato');
define('FS_ORDER_PURCHASE','Ordine credito');
define('FS_ORDER_PROGRESSING','In elaborazione');
define('FS_ORDER_RETURN_ITEM','Articoli restituiti');
define('FIBERSTORE_ORDER_TOTAL','Totale ordine');

define('FS_COUNTRY_REGION','Paese/Regione');
define('FS_NEW_LANGUAGE_CURRENCY','Lingua/Valuta');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Il file è stato caricato con successo.');


// common/common_service.php
define('COMMON_SERVICE_01', 'Contattaci ora');
define('COMMON_SERVICE_02', 'FS è focalizzata sulla soluzione di centro dati, enterprise e rete di trasmissione ottica per aiutarti a costruire esattamente ciò che ti occorre.<br> Contattaci, siamo a tua disposizione 24 ore al giorno, 7 giorni su 7.');
define('COMMON_SERVICE_03', 'Scopri gli altri modi per contattarci');
define('COMMON_SERVICE_04', 'Chat online');
define('COMMON_SERVICE_05', 'Siamo a tua disposizione 24 ore al giorno, 7 giorni su 7. Inviaci un messaggio ora per una risposta.');
define('COMMON_SERVICE_06', 'Chatta ora');
define('COMMON_SERVICE_07', 'Effettua una chiamata');
define('COMMON_SERVICE_08', 'Chiama il numero ');
define('COMMON_SERVICE_09', ' oppure lascia che ti richiamiamo.');
define('COMMON_SERVICE_10', 'Effettua una chiamata');
define('COMMON_SERVICE_11', 'Invia un\'e-mail');
define('COMMON_SERVICE_12', 'Il nostro team del servizio clienti ti risponderà il più presto possibile.');
define('COMMON_SERVICE_13', 'Invia un\'e-mail ora');
define('COMMON_SERVICE_14', 'Supporto soluzione');
define('COMMON_SERVICE_15', 'Ottieni la progettazione e il supporto gratuiti della soluzione per il tuo progetto online.');
define('COMMON_SERVICE_16', 'Ottieni il supporto');
define('COMMON_SERVICE_17', 'Team show eccellente');
define('COMMON_SERVICE_18', 'FS accetta di buon grado l\'ispirazione dei dipendenti e incoraggia sempre ogni singola persona a esprimere le proprie idee. Questa è la motivazione');
define('COMMON_SERVICE_19', 'FS è in grado di servire sempre meglio i clienti di tutto il mondo.');
define('COMMON_SERVICE_20', 'Per iniziare');
define('FS_SHOP_CART_ALERT_JS_13', 'Da*');
define('FS_SHOP_CART_ALERT_JS_14', 'A*');
define('FS_SHOP_CART_ALERT_JS_15', 'Messaggio Personale ( Opzionale )');
define('FS_VIEW_QUOTE_SHEET', 'Visualizza scheda preventivo');
define('FS_PRODUCT_HAS_BEEN_ADDED', 'Il prodotto è stato aggiunto.');
define('FS_SAVE_CSRT_LIMIT_TIP', 'Inserisci il nome del carrello massimo 50 parole.');
define('FS_QUOTE', 'Preventivo');
define('FS_SAVED_CART_EMAIL', 'E-mail');

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

define('EMAIL_TEXT', 'You are now registered with our store and have account privileges:  With your account, you can now take part in the <strong>various services</strong> we have to offer you. Some of these many services include:' . "\n\n<ul>" . '<li><strong>Order History</strong> - View the details of orders you have completed with us.' . "\n\n" . '<li><strong>Permanent Cart</strong> - Any products added to your online cart remain there until you remove them, or check them out.' . "\n\n" . '<li><strong>Address Book</strong> - We can deliver your products to an address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.' . "\n\n" . '<li><strong>Products Reviews</strong> - Share your opinions on our products with other customers.' . "\n\n</ul>");
define('EMAIL_CONTACT', 'For help with any of our online services, please email the store-owner: <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE', "\n" . 'Sincerely,' . "\n\n" . STORE_OWNER . "\nStore Owner\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'This email address was given to us by you or by one of our customers. If you did not signup for an account, or feel that you have received this email in error, please send an email to %s ');



// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','About FS.COM');
define('FS_ABOUT_FS_COM','About Us');
define('FS_FOOTER_WHY_US','Why Us');
define('FS_FOOTER_CONTACT_US','Contact Us');
// Frankie 2018.1.22
define('FS_LEGAL','Legal');
define('FS_IMPRINT','Legal Notice');
define('FS_PRIVACY_POLICY','Privacy Policy');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','Quick Access');
define('FS_FOOTER_OEM','OEM & Custom');
define('LATEST_NEWS','Latest News');
define('SG_LATEST_NEWS','Press Room');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM',"OEM & Custom");

define('FS_FOOTER_POLICY','Return Policy');
define('FS_FOOTER_QUALITY',' Impegno Verso Qualità');
define('FS_FOOTER_PARTNER','Account aziendale');

// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','Payment & Shipping');

define('FS_NET_AMP_W',"Ordine d'acquisto");


// footer Quick Help
define('FS_FOOTER_QUICK_HELP','Quick Access');
define('FS_FOOTER_REQUEST_A_SAMPLE','Richiedi un campione');
define('FS_FOOTER_PURCHASE_HELP','Purchase Help');
define('FS_FORGOT_YOUR_PASSWORD', 'Password dimenticata?');
define('FS_FOOTER_FAQ','FAQ');
define('FS_TRACK_YOUR_PACKAGE','Tieni Traccia del Tuo Pacco');

// footer Questions? Aron 2017.8.6
define("FS_YAO1","Questions? We are here 24/7");
define("FS_YAO2","We're here to help 24/7");
define("FS_YAO4","Chat with a live representative");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Popular Pages:');    //小语种没有这个

// 手机站切换版本
define('FS_FULL_SITE','Inviaci un\'email');
define('FS_MOBILE_SITE','Sito per dispositivo mobile');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_HIGH_QUALITY","Alta qualità");
define("FS_SAFE_SHOPPING","Acquisti sicuri");
define("FS_FAST_DELIVERY","Resi Entro RETURN_DAYS Giorni");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"Privacy e Cookies");
define('FS_TERMS_OF_USE_DE',"Termini e Condizioni");
define('FS_SITE_MAP','Mappa sito');
define('FS_FOOTER_FEEDBACK','Lascia un feedback');
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_FOOTER_COPYRIGHT","Copyright  2009-YEAR ".FS_LOCAL_COMPANY_NAME." Tutti i diritti riservati.");
define("FS_FOOTER_COPYRIGHT_M","Copyright  2009-YEAR <span>".FS_LOCAL_COMPANY_NAME."</span> Tutti i diritti riservati.");
//新版底部导航栏
define("FS_SUPPORT",'Supporto');
define("FS_HLEP_CENTER",'Supporto FS');
define('FS_FOOTER_WARRANTY','Garanzia');
define('FS_RETURN_POLICY',' Politica di Reso');
define('FS_FOOTER_DELIVERY','Spedizione & Consegna');
define('FS_PAYMENT_METHODS','Metodi di pagamento');



// common/header.php文件
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','14');

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
define('FS_HEADER_SEARCH','Cerca');
define('FS_HEADER_01','Cerca...');
define('FS_HEADER_02','Ricerca veloce');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','Cavo MTP MPO');
define('FS_HEADER_09','Cavi Patch LC');
define('FS_HEADER_10','Attenuatori');
define('FS_HEADER_11','Cronologia ricerche');
define('FS_HEADER_12','Cancella cronologia');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'Help & Support');
define('FS_CALL_US', 'Call Us');
define('FS_SAVED_CARTS', 'Carrelli salvati');
// 用户相关
define('FS_ACCOUNT', 'Account');
define('FS_SIGN_IN','Sign in');
define('FS_NEW_CUSTOMER', 'Nuovo cliente?');
define('FS_REGISTER_ACCOUNT','Crea un account');
define('FS_SIGN_OUT','Sign out');
define('FS_MY_ORDERS','My Orders');
define('FS_MY_ORDER','My Order');
define('FS_MY_ADDRESS','My Address');
define('FS_SOLUTIONS','Solutions');
define('FS_ALL_CATEGORIES','Tutte le categorie');
define('FS_PROJECT_INQUIRY','Project Inquiry');
define('FS_SEE_ALL_OFFERINGS','See All Offers');
define('FS_RESOURCES','Risorse');
define('FS_RELATED_INFO','Info correlate');
define('FS_CONTACT_US','Contact Us');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_NETWORKING','Networking');
define('FS_ORDER_HISTORY','Storico ordini');
define('FS_ADDRESS_BOOK','Rubrica');
define('FS_MY_CASES','Ticket di assistenza');
define('FS_MY_QUOTES','I miei preventivi');
define('FS_ACCOUNT_SETTING','Impostazioni account');
define('FS_VIEW_ALL','Vedi tutto');

// 搜索
define('FS_SEARCH_PRODUCTS','Search Products');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Products may have different prices and availability based on country/region.');
define('FS_NEW_CHOOESE_CURRENCY','Choose Currency');
define('FS_NEW_LANGUAGE_CURRENCY','Language/Currency');
define('FS_COUNTRY_REGION','Country/Region');
// 浏览器
define('FS_UPGRADE','UPGRADE YOUR BROWSER');
define('FS_UPGRADE_TIP','You are running an older browser. Please upgrade your browser for better experience.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');
// 2018.7.23 fairy help
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
define('FS_SHIPPING_DELIVERY_RU',' on Orders over 20 000 ₽');

define('FS_TAGIMG_TITLE','Cartelle Applicazioni');
define('FS_INDEX_CATE_PRODUCTS','Products');


// common/left_side_bar_for_tag.php
define('FIBERSTORE_TRANS1','Find by Network Device');
define('FIBERSTORE_TRANS2','Find by Orignal Model');
define('FIBERSTORE_CLEAR','Clear Selections');


// common/patch_panel.php
define('PATCH_PANEL_01','Come ottenere più supporto?');
define('PATCH_PANEL_02','FS si concentra su data center, soluzioni aziendali e reti di trasmissione ottica, siamo disponibili per aiutarti a costruire tuto ciò di cui hai bisogno.');
define('PATCH_PANEL_03','Scrivici a <a href="mailto:tech@fs.com">tech@fs.com</a> o <a href="mailto:sales@fs.com">italy@fs.com</a>.');

// common/phone.php
//各国电话语言包 2017.8.18  ery
define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 5808 7203');		// Hong Kong
define('FS_PHONE_MX','+52 (55) 3098 7566');		// Mexico
define('FS_PHONE_CA','+1 (647) 243 6342');		// Canada
define('FS_PHONE_BR','+55 (11) 4349 6175');		// Brazil
define('FS_PHONE_AR','+54 (11) 5031 9542');		// Argentina
define('FS_PHONE_GB','+44 (0) 121 716 1755');	// United Kingdom
define('FS_PHONE_FR','+33 (1) 82 884 336');		// France
define('FS_PHONE_NL','+31 (20) 241 4029');		// Netherlands
define('FS_PHONE_AU','+61 (3) 9693 3488');		// Australia
define('FS_PHONE_ES','+34 (91) 123 7299');		// Spain
define('FS_PHONE_RU','+7 (499) 643 4876');		// Russian Federation
define('FS_PHONE_SG','+(65) 6443 7951');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+49 8165 7076169');	// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_WH','+86 (027) 87639823');         //wuhan
define('FS_PHONE_JP','+81 345888332');			//japan
define('FS_PHONE_US_TWO','+1 (253) 277 3058');		// United States2

define('FS_PHONE_SITE_EU','+49 (0) 89 414176412');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 (3) 9693 3488');
define('FS_PHONE_SITE_JP','+1 (877) 205 5306');
define('FS_PHONE_SITE_SG','+(65) 6443 7951');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_US','+1 (888) 468 7419');		// United States
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_US','+1 (877) 205 5306');		// United States
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}


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
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','FS.COM - You have saved a cart list for yourself');
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT_1','FS.COM - You have a Cart List from ');
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

define('FS_SHIP_ESTIMATED','Spedizione ');
define('FS_SHIP_INVENTORY','Inventory Shortage, Shipment Available on ');
define('FS_SHIP_PLACE','Orders placed today will ship within ');
define('FS_SHIP_DAYS',' business days');
//左上角  俄罗斯国家展示邮箱
define('FS_HEADER_EMAIL','<span>Email Us: <a href="mailto:'.get_mail_site_and_country().'">'.get_mail_site_and_country().'</a></span>');

//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', 'Test delle prestazioni');
define('NEW_PATCH_PANEL_02', 'Tutti i cavi di rete Ethernet superato il test Fluke dei canali.');
define('NEW_PATCH_PANEL_03', 'Garanzia di qualità');
define('NEW_PATCH_PANEL_04', 'Tutti i prodotti sono stati sottoposti a rigorosi test.');
define('NEW_PATCH_PANEL_05', 'Ampio stock');
define('NEW_PATCH_PANEL_06', 'Stock sufficiente per la spedizione in giornata');
define('NEW_PATCH_PANEL_07', 'Offerta conveniente');
define('NEW_PATCH_PANEL_08', 'Cavi a prezzi all\'ingrosso per risparmiare sul budget del proprio progetto.');

define('NEW_PATCH_PANEL_01_209', 'Programma di test rigoroso');
define('NEW_PATCH_PANEL_02_209', 'Ispezione end-face & perdita IL & perdita RL');

define('NEW_PATCH_PANEL_01_1', 'Grande flessibilità');
define('NEW_PATCH_PANEL_02_1', 'Supporta più interfacce per soddisfare le diverse esigenze delle applicazioni aziendali.');
define('NEW_PATCH_PANEL_04_1', 'Certificazioni di qualità CE, FCC e RoHS garantite.');

define('NEW_PATCH_PANEL_01_911', 'Consegne veloci');
define('NEW_PATCH_PANEL_02_911', 'I depositi locali che coprono i mercati globali fanno risparmiare tempo prezioso.');

define('NEW_PATCH_PANEL_01_9', 'Ampia compatibilità');
define('NEW_PATCH_PANEL_02_9', 'Compatibile con tutti i principali fornitori e sistemi.');
define('NEW_PATCH_PANEL_04_9', 'Certificazioni di qualità CE, RoHS, IEC, FCC, ISO9001, FDA garantite.');

define('NEW_PATCH_PANEL_02_4', 'Tutti i prodotti sono testati per soddisfare i requisiti standard.');
define('NEW_PATCH_PANEL_08_4', 'Prezzi all\'ingrosso per risparmiare sul budget di diversi progetti.');

//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0"><tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">Questa email è stata inviata da <a style="color: #232323;text-decoration: none;" href="javascript:;"></a> utilizzando <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>. In conseguenza del ricevimento di questo messaggio, non riceverai alcun messaggio non richiesto da <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>. Per saperne di più sul nostro <a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Politica di Privacy</a>.</td></tr></table>');

define('HEADER_TITLE_CATALOG', 'Home');

//sample_application页面中的邮件
//邮件
define('SAMPLE_EMAIL_DEAR','Gentile');
define('SAMPLE_EMAIL_01', 'Abbiamo ricevuto la tua richiesta e il nostro team ti contatterà presto.');
define('SAMPLE_EMAIL_02', 'Il numero del suo caso è <a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>. È possibile fare riferimento a questo numero per le successive comunicazioni relative a questa richiesta.');
define('SAMPLE_EMAIL_03', 'Info contatto: ');
define('SAMPLE_EMAIL_04', 'Email: ');
define('SAMPLE_EMAIL_05', 'Paese: ');
define('SAMPLE_EMAIL_06', 'Numero di telefono: ');
define('SAMPLE_EMAIL_07', 'I suoi commenti aggiuntivi: ');
define('SAMPLE_EMAIL_08', 'Grazie');
define('SAMPLE_EMAIL_09', 'Il Team di FS');
define('SAMPLE_EMAIL_30', 'Il numero del suo caso è  <a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>. È possibile fare riferimento a questo numero per le successive comunicazioni tramite il <a style="color: #0070bc;text-decoration: none" href="$HREF">Centro Casi online</a> relative a questa richiesta.');

define('FS_CONTACT_GET_SUPPORT','Contattaci via e-mail. Vorremmo aiutarti con qualsiasi domanda tu abbia.');;
define('FS_CONTACT_LEAVE','Lascia un messaggio');

define('CUSTOMER_SERVICE_OTHERS_46', 'Hai già un account? <a style="color: #0070bc;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Accedi</a> o <a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Crea un account</a>');
define('CUSTOMER_SERVICE_OTHERS_47', '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Accedi</a> o <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Crea un Account</a> per ottenere servizi personalizzati.');

//服务页面公用

define('FS_SUPPORT_FORM_TXT','Si prega di completare le informazioni. Ci metteremo in contatto con lei al più presto.');
define("FS_SUPPORT_EMAIL","Email");
define('FS_PLEASE_ENTER_COMMENTS','Si prega di scrivere aggiuntivi commenti sulla sua richiesta.');
define('FS_SUPPORT_FORM_PLACEHOLDER','I suoi commenti aiuteranno FS a rispondere più rapidamente.');
define('FS_COMMON_AT_LEAST','Si prega di scrivere un contenuto con più di 3 caratteri.');
define('FS_COMMON_AT_MOST','Il contenuto deve deve essere di al massimo 1000 caratteri.');
define('FS_SUPPORT_PHONE','Telefono');
define('FS_FIRST_NAME_PLEASE','Si prega di inserire il proprio nome.');
define('FS_LAST_NAME_PLEASE','Si prega di inserire il proprio cognome.');
define('FS_SUPPORT_COMMENTS','Commenti');
define('FS_SUPPORT_FIRST_NAME','Nome');
define('FS_SUPPORT_LAST_NAME','Cognome');
// 2019-8-7 potato 隐私政策
define('SOLUTION_PRIVACY_POLICY','Dichiaro di essere d\'accordo con le Politiche di FS riguardo <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>la Privacy</a> e <a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'>le Condizioni d\'uso</a>.');
define('FS_SUPPORT_EMAIL_TOUCH_SOON','Abbiamo ricevuto la sua richiesta di supporto e il nostro team sarà presto in contatto con lei.');

define('FS_CONTACT_56',' Ottieni supporto gratuito e progettazione di soluzioni per il tuo progetto online.');
define('FS_SUBMIT_SUCCESS','La tua richiesta ##number## è stato inviata correttamente.');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','Ti risponderemo entro 1-3 ore via telefono o e-mail durante i giorni lavorativi.');

//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','Scopri come realizziamo i tuoi obiettivi');
define('FS_SPECIAL_DESIGN_CENTER','Centro Design');
define('FS_SPECIAL_DESIGN_CENTER_DES','Competenza nell\'incorporare requisiti e<br> provvedere una innovativa, economica<br> e affidabile soluzione one-stop.');
define('FS_SPECIAL_QUALITY','Centro di qualità');
define('FS_SPECIAL_QUALITY_DES','Fornire prodotti di alta qualità sottoposti a test rigorosi<br> e certificazioni standard del settore. ');
define('FS_SPECIAL_TEC','Supporto Tecnico');
define('FS_SPECIAL_TEC_SMALL','Richiedi assistenza');
define('FS_SPECIAL_TEC_DES','Ottieni supporto gratuito e progettazione di soluzioni per il tuo<br/progetto online.');

//shopping_cart save_items 页面的 meta标签 2019.12.23
define('META_TAGS_SHOPPING_CART_TITLE', 'Carrello');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', 'Acquista i migliori prodotti per Centri Dati, reti aziendali e per l\'accesso ad Internet. Rendiamo più facile ed economico, ai professionisti informatici, l\'implementazione di soluzioni aziendali.');
define('META_TAGS_SAVED_ITEMS_TITLE', 'Carrelli salvati');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', 'Dopo aver aggiunto gli articoli al carrello, fai clic su "Salva carrello" per conservarlo. Puoi creare e salvare un qualsiasi carrello e utilizzarlo per ordini ripetuti.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Stock List of 10G CWDM/DWDM SFP+');
define('META_TAGS_SFP_DESCRIPTION', 'The full product portfolio of 10G CWDM/DWDM SFP+ Transceivers (DWDM SFP+ 80km/40km,CWDM SFP+ 80km/40km/20km/10km) gives quick overview of product inventory and provides help with the WDM Solutions.');


define('FS_BROWSING_HISTORY','Storico di navigazione');
define('SAMPLE_EMAIL_31', 'Indirizzo: ');
define('SAMPLE_EMAIL_32', 'Quantità richiesta: ');
define('SAMPLE_EMAIL_33', 'Elenco campione');


define('FS_PRODUCT_DOWNLOAD', 'Download');
define('FS_PRODUCT_MORE', 'Scopri di più');
define('FS_PRODUCT_SUPPORT','Supporto prodotto');

//结算页、订单确认成功页、银行转账邮件、订单详情
define("PAYMENT_BANK_ACH","Bonifico bancario/ACH");
define("PAYMENT_BANK_ACH_CA","Bonifico bancario");
define("PAYMENT_BANK_OF_US","Bank of America");
define("PAYMENT_BANK_VIA","Tramite bonifico bancario");
define("PAYMENT_BANK_ACCOUNT_NAME","FS COM INC");
define("PAYMENT_BANK_WIRE_ROUTING","Routing bonifico bancario #:");
define("PAYMENT_BANK_SWIFT_CODE","Codice SWIFT:");
define("PAYMENT_BANK_ACH_ROUTING","Routing ACH #:");
define("PAYMENT_BANK_VIA_ACH","Tramite ACH");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",FIBER_CHECK_COMMON_ACCOUNT_NAME);
define("PAYMENT_BANK_ACCOUNT",FS_COMMON_HEADER_ACCOUNT.' #:');
define("PAYMENT_BANK_ADDRESS",FS_ADDRESS_ADDRESS.':');

//QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL', 'Qtà');
define('FS_PRODUCT_ID_NOT_FILL_TIP', 'Nessun ID prodotto');
define('FS_PRODUCT_OFFLINE_TIP', 'Prodotto non in linea.');
define('FS_QV_QUICK_VIEW', 'Vista rapida');
define('FS_SEE_FULL_DETAILS','Visualizza dettagli');
define('FS_CUSTOMIZED', 'Aggiungi al carrello');
define('FS_PRODUCTS_INFORMATION', 'Informazioni sui prodotti');
define('FS_CUSTOMER_ALSO_VIEWED', 'I clienti hanno visualizzato anche');
define('FS_TITLE_COMPATIBLE', 'Compatibile');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'Acquista di nuovo');
define('FS_BUY_MORE_02', 'Gli articoli acquistati tramite Acquista di nuovo saranno totalmente gli stessi del tuo ordine %s.');	//%s会替换成订单号
define('FS_BUY_MORE_03', 'L\'articolo è uguale all\'ordine precedente %s.');		//%s会替换成订单号

//头部下拉版块
define('FS_HEADER_SUPPORT','Supporto');
define('FS_HEADER_TEC_SUPPORT','Supporto Tecnico');
define('FS_HEADER_CUSTOMER_SUPPORT','Support Clienti');
define('FS_HEADER_SERVICE_SUPPORT','Support Servizio');
define('FS_HEADER_TEC_DES',' Trova documenti, casi studio, video e altro ancora nella nostra libreria di risorse o richiedi supporto tecnico per ottenere le soluzioni su misura.');
define('FS_HEADER_TEC_URL_01','Documenti Tecnici');
define('FS_HEADER_TEC_URL_02','Banco di Prova');
define('FS_HEADER_TEC_URL_03','Download del Software');
define('FS_HEADER_TEC_URL_04','Impegno alla Qualità');
define('FS_HEADER_TEC_URL_05','Casi Studio ');
define('FS_HEADER_TEC_URL_06','Richiesta di Garanzia');
define('FS_HEADER_TEC_URL_07','Libreria Video');
define('FS_HEADER_SUPPORT_RIGHT_DES','Servizi Offerte da Esperti FS');
define('FS_HEADER_SUPPORT_RIGHT_URL','Mettiti in Contatto');
define('FS_HEADER_CUSTOMER_DES','Ottieni assistenza immediata prima o dopo l\'acquisto: richiesta di ordine, effettuabilita dell\'ordine, traccio dell\'ordine o altri problemi correlati.');
define('FS_HEADER_CUSTOMER_URL_01','Richiedi un Preventivo');
define('FS_HEADER_CUSTOMER_URL_02','Richiedi Reso & Rimborso');
define('FS_HEADER_CUSTOMER_URL_03','Richiedi un Campione');
define('FS_HEADER_CUSTOMER_URL_04','Termini Netti');
define('FS_HEADER_CUSTOMER_URL_05','Invia un Ordine d\'acquisto');
define('FS_HEADER_CUSTOMER_URL_07','Traccia i Tuoi Ordini');
define('FS_HEADER_CUSTOMER_URL_08','Nuovi Arrivi');
define('FS_HEADER_CUSTOMER_URL_09','Saldi');
define('FS_HEADER_CUSTOMER_URL_10','Verifica del Prodotto');
define('FS_HEADER_CUSTOMER_URL_11','Richiedi una Dimostrazione');
define('FS_HEADER_SERVICE_DES','Esplora argomenti popolari su account, spedizione, resi, ecc., FS si impegna a offrirti l\'esperienza di acquisto più semplice.');
define('FS_HEADER_SHIPPING_DELIVERY','Spedizione & Consegne');
define('FS_HEADER_RETURN_POLICY','Politiche di Reso');
define('FS_HEADER_PAYMENT','Modalità di Pagamento');
define('FS_HEADER_HELP_CENTER','FS Supporto');
define('FS_HEADER_COMPANY','Azienda');
define('FS_HEADER_ABOUT_US','Su di Noi');
define('FS_HEADER_CONTACT_US','Contattaci');
define('FS_HEADER_NEWS','Avviso Legale');
define('FS_HEADER_ABOUT_DES','FS è un fornitore leader mondiale di hardware per comunicazioni e soluzioni di progetto. Ci dedichiamo ad aiutarti a costruire, connettere, proteggere e ottimizzare la tua infrastruttura ottica.');
define('FS_HEADER_ABOUT_EXPLORE','Esplora FS');
define('FS_HEADER_CONTACT_DES','Siamo qui per aiutare. Non esitare a contattarci in qualsiasi momento per il supporto tecnico e il servizio clienti rapidi e migliori.');
define('FS_HEADER_LEARN_MORE','Scopri di più');
define('FS_HEADER_NEWS_DES','<dd>Questa nota legale fornisce informazioni generali su FS.</dd>');
define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('legal_notice.html').'"><span>Per saperne di più</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_RIGHT_DES','FS Ottiene una Serie di Certificazioni Internazionali Autorevoli');
define('FS_HEADER_NEWS_RIGHT_DATE','8 giugno, 2020');
define('FS_CUSTOMER_SUPPORT_TIP','L\'articolo#XXX è personalizzato, contatta il tuo account manager per i dettagli.');

define('FS_RMA_WAREHOUSE_CN','<dt>FS.COM Limited</dt>
			<dd>NO.6,Li Miao Road Canglong  Island, Jiangxia Distric Wuhan, 430205, China</dd>
			<dd>Tel: +86 (027) 87639823</dd>');

define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH</dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Germania</dd>
			<dd>Tel: +49 (0) 8165 80 90 517</dd>');
define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC</dt>
			<dd>380 CENTERPOINT BLVD, NEW CASTLE, DE 19720 Stati Uniti</dd>
			<dd>Tel: +1 (888) 468 7419</dd>');
define('FS_RMA_WAREHOUSE_US_EAST','<dt>FS.COM INC</dt>
					<dd>380 Centerpoint Blvd, New Castle, DE 19720, United States</dd>
					<dd>Tel: +1 (888) 468 7419</dd>');
// 澳洲仓 （澳大利亚）
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australia</dd>
				<dd>Tel: +61 3 9693 3488</dd>
				<dd>ABN: 71 620 545 502</dd>');
// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>ATTN: FS Tech Pte Ltd.</dt>
				<dd>Indirizzo: 30A Kallang Place #11-10/11/12, Singapore 339213</dd>
				<dd>Tel: +(65) 6443 7951</dd>');

//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','Preventivi');
define('FS_ACCOUNT_TW_CREDIT','Conto di credito');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','Dettagli di credito');
define('FS_ACCOUNT_TW_USER','Informazioni di cliente');
define('FS_ACCOUNT_TW_SUPPORT','Ticket di assistenza');
define('FS_ACCOUNT_TW_TAX','Richiedi l\'esenzione dall\'imposta');
define('FS_ACCOUNT_TW_USEFUL','Strumenti utili');
define('FS_ACCOUNT_TW_ACCOUNT','Informazioni sul conto');
define('FS_ACCOUNT_TW_YOU',' Hai ordini che non sono ancora stati pagati.');
define('FS_ACCOUNT_TW_ORDERS','Ordini');
define('FS_ACCOUNT_TW_MOST_ORDER','Ordine più recente');
define('FS_ACCOUNT_TW_VIEW_ORDERS','Visualizza tutti gli ordini');
define('FS_ACCOUNT_TW_ORDERS_SEARCH',' #Ordine,#Ordine di acquisto, # Articolo,P/N,Commenti...');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','In attesa di pagamento');
define('FS_ACCOUNT_TW_WAIT','In attesa di spedizione');
define('FS_ACCOUNT_TW_TRANSIT','In transito');
define('FS_ACCOUNT_TW_DELIVERED','Consegnato');
define('FS_ACCOUNT_TW_PENDING_REVIEW','In attesa di recensione');
define('FS_ACCOUNT_TW_NO_ORDER','Nessun ordine trovato.');
define('FS_ACCOUNT_TW_VIEW_CART','Visualizza il carrello');
define('FS_ACCOUNT_TW_VIEW_TICKETS','Visualizza tutti i ticket');
define('FS_ACCOUNT_TW_CREATE_TICKET','Crea un nuovo ticket');
define('FS_ACCOUNT_TW_SEARCH_TICKET','#Ticket, contenuto…');
define('FS_ACCOUNT_TW_TICKET',' #Ticket');
define('FS_ACCOUNT_TW_TICKET_TYPE','Tipo di assitenza');
define('FS_ACCOUNT_TW_TICKET_COMMENT','Contenuto');
define('FS_ACCOUNT_TW_TICKET_DATE','Data di invio');
define('FS_ACCOUNT_TW_TICKET_STATUS','Stato');
define('FS_ACCOUNT_TW_TICKET_ACTION','Azione');
define('FS_ACCOUNT_TW_NO_TICKET','Nessun ticket storico.');
define('FS_ACCOUNT_TW_ORDER','Ordine #');
define('FS_ACCOUNT_TW_SPLIT_ORDER','Ordine separato');
define('FS_ACCOUNT_TW_DELIVERY','Consegna');
define('FS_ACCOUNT_TW_DELIVERY_ON','Consegnato il ');
define('FS_ACCOUNT_TW_THE','I seguenti prodotti non possono essere ordinati di nuovo direttamente per il motivo specifico qui sotto. Clicca il pulsante "Salta e continua" per aggiungere il(i) prodotto(i) del resto al carrello di nuovo.');
define('FS_ACCOUNT_TW_THE_NO','I seguenti prodotti non possono essere ordinati di nuovo direttamente per il motivo specifico qui sotto.');
define('FS_ACCOUNT_TW_ITEMS','Gli articoli acquisti tramite Acquista di nuovo saranno identici al tuo ordine #%s.');
define('FS_ACCOUNT_TW_YOU_CAN','È possibile utilizzare questo pulsante per riportare nel carrello tutti i prodotti di questo ordine.');
define('FS_ACCOUNT_TW_ORDER_AGAIN','Ordina di nuovo');
define('FS_ACCOUNT_TW_CREATE_TICKET','Crea un nuovo ticket');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','Tipo di assitenza');
define('FS_ACCOUNT_TW_ATTACH_PO','Allega l\'ordine di acquisto');
define('FS_ACCOUNT_TW_SHOW_MORE','Mostra di più');
define('FS_ACCOUNT_TW_BASIC_INFO','Informazione di base');
define('FS_ACCOUNT_TW_ADDRESS_INFO','Informazione indirizzo');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','Aggiungi il(i) seguente(i) prodotto(i) al carrello e crea preventivo.');
define('FS_ACCOUNT_TW_MOST_QUOTE','I preventivi più recenti');
define('FS_ACCOUNT_TW_VIEW_QUOTES','Visualizza tutti i preventivi');
define('FS_ACCOUNT_TW_NO_QUOTE','Nessun preventivo trovato.');
define('FS_ACCOUNT_TW_QUOTE_ITEM','Preventivo #, articolo #');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','Il preventivo per il(i) prodotto(i) di sotto non possono essere creato direttamente per motivo di seguito.');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','Il preventivo per il(i) prodotto(i) di sotto non possono essere creato direttamente per motivo di seguito. Fai clic sul pulsante "Salta e continua" per aggiungere il(i) prodotto(i) di resto al carrello e creare un preventivo.');

define('FS_FOOTER_EXPLORE','Explora');
define('FS_HEADER_NEW_PRODUCT','Nuovi Arrivi');
define('FS_HEADER_CHANGE','Cambia');
define('FS_COMMON_VIEW_MORE','Vedi altro');
define('FS_CART_EMPTY_TIP','Accedi per vedere se hai degli articoli salvati. Oppure continua con gli acquisti.');
define('BIllS_TIPS1','Puoi controllare tutte le tue fatture qui.');
define('BIllS_TIPS2','Puoi controllare lo stato del tuo conto di credito e tutte le fatture qui.');
define('TIPS_BUTTON', 'Vai!');
define('TIPS_NEW', 'Nuovo');
define('FS_ATTRIBUTE_CUSTOMIZED','Personalizza');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' anni');
define('FS_WARRANTY_YEAR',' anno');
define('FS_WARRANTY_DAYS',' giorni');
define('FS_WARRANTY_CONSUMABLE','consumabile');
define('FS_WARRANTY_UNAVAILABLE','Non disponibile');
define('FS_WARRANTY_SUB_CATEGORY','Sotto-categoria');
define('FS_WARRANTY_RETURN','Periodo<br>Reso');
define('FS_WARRANTY_CHANGE','Periodo <br>Sostituzione');
define('FS_WARRANTY_PERIOD','Periodo <br>Garanzia');

define('FS_WARRANTY_NOTE','Nota');

define('ORDER_PAYMENT_TIPS','Assicurati che l\'indirizzo di fatturazione sopra riportato corrisponda a quello che appare sull\'estratto della carta di credito.');
define('ORDER_PAYMENT_SAFE','Sicuro e crittografato');
define('ORDER_PAYMENT_TIPS_2','I tuoi dati verranno utilizzati solo per elaborare questo ordine e non saranno salvati da FS.');
