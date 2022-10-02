<?php
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','5');
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','chatten jetzt');
define('FS_ONLINE_CAHT','Chat Jetzt');
define('FS_LIVE_CAHT','Chat jetzt');
define('FS_PRE_SALE','Service vor dem Verkauf');
define('FS_CHAT_WITH','Chat mit Online-Verkäufer für weitere Informationen vor dem Verkauf.');
define('FS_STAR','Chat starten');
define('FS_AFTER_SALE','Service nach dem Verkauf');
define('FS_PL_GO','Wenn Sie etwas gekauft haben, gehen Sie bitte die Seite');
define('FS_PAGE_TO','zur Live-Hilfe für die Bestelldetails.');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','Suchen');
define('FS_HEADER_01','Suchen...');
define('FS_HEADER_02','Beliebtes Suchen');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','MTP MPO Kabel');
define('FS_HEADER_09','LC Patchkabel');
define('FS_HEADER_10','Dämpfungsglieder');
define('FS_HEADER_11','Suchhistorie');
define('FS_HEADER_12','Suchhistorie löschen');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'Hilfe & Support');
define('FS_CALL_US', 'Supporthotline');
define('FS_SAVED_CARTS', 'Gespeicherte Einkaufswagen');
// 用户相关
define('FS_ACCOUNT', 'Konto');
define('FS_SIGN_IN','Anmelden');
define('FS_NEW_CUSTOMER','Neu bei FS.COM?');
define('FS_REGISTER_ACCOUNT','Jetzt registrieren');
define('FS_SIGN_OUT','Abmelden');
define('FS_MY_ACCOUNT','Mein Konto');
define('FS_MY_ORDERS','Meine Bestellungen');
define('FS_MY_ORDER','Meine Bestellung');
define('FS_MY_ADDRESS','Meine Adresse');
define('FS_SOLUTIONS','Lösungen');
define('FS_ALL_CATEGORIES','Alle Kategorien');
define('FS_PROJECT_INQUIRY','Anfrage zum Projekt');
define('FS_SEE_ALL_OFFERINGS','Alle Angebote anzeigen');
define('FS_RESOURCES','Ressourcen');
define('FS_CONTACT_US','Kontakt');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Je nach Land/Region können die Produkte unterschiedliche Preise und Verfügbarkeiten anzeigen.');
define('FS_NEW_LANGUAGE_CURRENCY','Sprache/Währung');
define('FS_COUNTRY_REGION','Land/Region');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','Hauptmenü');
define('FS_NETWORKING','Unternehmensnetzwerk');
define('FS_ORDER_HISTORY','Meine Bestellungen');
define('FS_ADDRESS_BOOK','Adressbuch');
define('FS_MY_CASES','Meine Fragen');
define('FS_MY_QUOTES','Meine Angebote');
define('FS_ACCOUNT_SETTING','Konto bearbeiten');
define('FS_VIEW_ALL','Alles anzeigen');

// 搜索
define('FS_SEARCH_PRODUCTS','Produkt suchen');
define('HOT_PRODUCTS','Bestseller-Produkte');
define('FS_NEED_HELP','Hilfe');
define('FS_NEW_CHOOESE_CURRENCY','Währung wählen');
// 2018.7.23 fairy help
define('FS_NEED_HELP_BIG','Hilfe');
define('FS_CHAT_LIVE_WITH_US','Chatten Sie mit uns');
define('FS_SEND_US_A_MESSAGE','Eine Nachricht schicken');
define('FS_E_MAIL_NOW','Jetzt E-Mail senden');
define("FS_LIVE_CHAT","Live Chat");
define("FS_WANT_TO_CALL","Rufen Sie uns an");
define("FS_BREADCRUMB_HOME","Home");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Technischer Support');
define('FS_CHAT_LIVE_WITH_GET_A','Fragen Sie unsere Experten');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Schnelle Lieferung & Einfache Rückgabe');
define('HEADER_FREE_SHIPPINH_02','Kostenloser Versand über %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','Mehr Versandoptionen, um Ihren Zeitplan und Ihr Budget anzupassen.');
define('HEADER_FREE_SHIPPINH_04','Versand am gleichen Tag');
define('HEADER_FREE_SHIPPINH_05','Große Lagerestände basierend auf unserem Multi-Lagerhaus-System.');
define('HEADER_FREE_SHIPPINH_06','30-Tage Rückkehr');
define('HEADER_FREE_SHIPPINH_07','Für die meiste Bestellungen ab Erhalt der Ware.');
define('HEADER_FREE_SHIPPINH_08','Jeder Artikel mit "Kostenloser Versand" auf der Produktseite ist zum kostenlosen Versand berechtigt. FS.COM behält sich das Recht vor, dieses Angebot jederzeit zu ändern. Mehr Informationen über <a href="'.zen_href_link('shipping_delivery').'">Versand</a> oder <a href="'.zen_href_link('day_return_policy').'">Rückgaberecht</a>.');
define('HEADER_FREE_SHIPPINH_09','Lieferung nach anderen Ländern? Wechseln Sie auf der Website zum Zielland, um die richtigen Richtlinien zu erhalten.');
define('HEADER_FREE_SHIPPINH_10','Schnelle Lieferung & Einfache Rückgabe');
define('HEADER_FREE_SHIPPINH_11','Kostenloser Versand über<br> %s');//%s不用翻译替换的是价格,如79€ 
define('HEADER_FREE_SHIPPINH_12','Mehr Versandoptionen, um Ihren Zeitplan und Ihr Budget anzupassen.');
define('HEADER_FREE_SHIPPINH_13','Versand am gleichen Tag');
define('HEADER_FREE_SHIPPINH_14','Jeder Artikel mit "Kostenloser Versand" auf der Produktseite ist zum kostenlosen Versand berechtigt. FS.COM behält sich das Recht vor, dieses Angebot jederzeit zu ändern. Mehr Informationen über <a href="'.zen_href_link('shipping_delivery').'">Versand</a> oder <a href="'.zen_href_link('day_return_policy').'">Rückgaberecht</a>.');
define('HEADER_FREE_SHIPPINH_15','Lieferung nach anderen Ländern? Wechseln Sie auf der Website zum Zielland, um die richtigen Richtlinien zu erhalten.');
define('HEADER_FREE_SHIPPINH_16','310.000+ Vorräte');
define('HEADER_FREE_SHIPPINH_17','für optische und Netzwerkprodukte, um Ihre Bedürfnisse zu erfüllen.');
define('HEADER_FREE_SHIPPINH_18','Die Lieferzeit kann durch Lagerbestände beeinflusst werden. Mehr Informationen über <a href="'.zen_href_link('shipping_delivery').'">Versand</a> oder <a href="'.zen_href_link('day_return_policy').'">Rückgaberecht</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Hilfe & Einstellung');

// 浏览器
define('FS_UPGRADE','UPGRADE IHREN BROWSER');
define('FS_UPGRADE_TIP','Sie betreiben einen älteren Browser. Bitte upgrade Sie Ihren Browser für eine bessere Erfahrung.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','Empfohlene Portfolios');
define('FS_INDEX_CATE_PRODUCTS','Produkte');
?>