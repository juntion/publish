<?php
// 公共的语言包都放到这里

// classic/order.info.php
//Content in My_dashboard
//2016-9-6 add by frankie
define('FIBERSTORE_ORDER_STATUS','Bestellstatus');
define('FIBERSTORE_VIEW_DETAILS','Sehen die Details');
define('FIBERSTORE_ORDER_NUMBER','Bestellnummer');
define('FIBERSTORE_ORDER_CUSTOMER_NAME','Kundenname');
define('FIBERSTORE_ORDER_TOTAL','Gesamtsumme');
define('FIBERSTORE_ORDER_PAYMENT','Bezahlung');
define('FIBERSTORE_DASHBOARD_NO_ORDER','Sie haben noch keine Bestellung.');


// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Stellen');
define('FS_DIALOG_A',' eine Frage');
define('FS_DIALOG_TITLE','Titel');
define('FS_DIALOG_YOUR','Das Thema Ihrer Frage ist erfordlich');
define('FS_DIALOG_CONTENT','Inhalt');
define('FS_DIALOG_PLEASE','Bitte geben Sie Ihre Fragen ein');
define('FS_DIALOG_YOUR2','Ihre Inhalte sind erforderlich');
define('FS_DIALOG_PLEASE1',"Schriftzeichens überschreiten bitte nicht mehr als 3.000.");
define('FS_DIALOG_EMAIL','E-mail Adresse');
define('FS_DIALOG_AGAIN','Diese angegebene E-Mail Adresse ist ungültig. Bitte korrigieren Sie die Adresse und probieren Sie noch einmal');
define('FS_DIALOG_COMMENTS','Kommentare/Fragen');
define('FS_DIALOG_THIS','Dieses Feld ist erforderlich, bitte schreiben Sie mindestens 10 Schrifteichens.');


// common/account_left_slide.php
//2017.5.12   add  by ery
define('ACCOUNT_LEFT_EDIT','Konto bearbeiten');
define('ACCOUNT_LEFT_ORDER','Bestellhistorie');
define('ACCOUNT_LEFT_ADDRESS','Adresse');
define('ACCOUNT_LEFT_QUESTION','Fragen');
define('ACCOUNT_LEFT_CASES','Meine Fragen');
define('ACCOUNT_LEFT_MANAGE','Verwaltung von Abonnements');
define('ACCOUNT_LEFT_MY_QUOTES','Meine Angebote');

define('ACCOUNT_LEFT_QUOTATION','Gültiges Angebot');
define('ACCOUNT_LEFT_QUOTATION_DETAIL','Details des gültigen Angebotes');
define('FS_CART_ORDER_PRICE','Preis der gültigen Bestellung');
define('FS_CART_QUOTATION_PRICE','Preis des gültigen Angebotes');
define('FS_REMOVED_QUOTATION','Wegen der Entfernung wird Sonderangebot im Angebot durch den Online-Preis ersetzt.');


// 2018.11.29 fairy 个人中心改版
define('FS_MY_ACCOUNT','Mein Konto');
define('ACCOUNT_SETTING','Kontoeinstellungen');
define('FS_RETURN_ORDERS','Zurückgeschickte Bestellungen');
define('FS_MY_QUOTES','Meine Angebote');
define('FS_WISH_LIST','Merkzettel');
define('FS_ADDRESS_BOOK','Adressbuch');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">Zurück zur</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">Startseite</a>');

// english.php
define("FS_COMMON_CONTINUE",'Weiter');
define("FS_COMMON_OPERATION",'Betrieb');
define('FS_COMMON_VIEW','Anzeigen');
define('FS_PURCHASE_ORDER_NUMBER','Bestellnummer');
define('FS_FILE_UPLOADED_SUCCESS','Datei wurde erfolgreich hochgeladen');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","Unterstützte Dateitypen: PDF, JPG, PNG.");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Unterstützte Dateitypen: PDF, JPG, PNG. <br/>Maximale Dateigröße ist 4MB.");
define("FS_UPLOAD_PO_FILE",'Auftragsdatei hochladen');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Vielen Dank für Ihren Einkauf bei FS.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Hausnummer");
define("ADDRESS_PLACE_HODLER2","Zimmernummer, Stockwerk usw.");
define("FS_ZIP_CODE","Postleitzahl");
define("FS_ADDRESS","Straße");
define("FS_ADDRESS2","Adresszeile 2");
define('FS_CHECK_COUNTRY_REGION','Land/Region');
// 这里没有验证语言包是因为german.php里面已经有了。其他语种等后期在整理
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","Adresszeile 2 muss zwischen 4 und 35 Zeichen lang sein.");
define("FS_CITY_MIN_MAX_TIP","Adresszeile 2 muss zwischen 1 und 50 Zeichen lang sein.");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','Alle Bestellstatus');
define('FS_ORDER_PENDING','Ausstehend');
define('FS_ORDER_COMPLETED','Abgeschlossen');
define('FS_ORDER_CANCELLED','Storniert');
define('FS_ORDER_PURCHASE','Kreditauftrag');
define('FS_ORDER_PROGRESSING','Bearbeitet');
define('FS_ORDER_RETURN_ITEM','Zurückgesandt');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Die Datei wurde erfolgreich hochgeladen.');


// common_service.php
define('COMMON_SERVICE_01','Kontaktieren Sie uns');
define('COMMON_SERVICE_02','FS konzentriert sich darauf, Rechenzentren, Unternehmen und optische Übertragungsnetzwerke, dank modernster Produktlösungen, beim Aufbau Ihrer Glasfaserinfrastruktur zu unterstützen. <br> Unser FS.COM Kundenservice freut sich Ihnen zu helfen – 24 Stunden täglich an 365 Tagen im Jahr. ');
define('COMMON_SERVICE_03','Weitere Kontaktmöglichkeiten');
define('COMMON_SERVICE_04','Live-Chat');
define('COMMON_SERVICE_05','Chatten Sie direkt mit einem unserer Mitarbeiter und Sie erhalten sofort alle nötigen Informationen.');
define('COMMON_SERVICE_06','Jetzt chatten');
define('COMMON_SERVICE_07','Anrufen');
define('COMMON_SERVICE_08','Rufen Sie uns unter ');
define('COMMON_SERVICE_09','. an oder klicken Sie auf den Button um einen Rückruf anzufordern.');
define('COMMON_SERVICE_10','Jetzt Rückruf anfordern');
define('COMMON_SERVICE_11','E-Mail');
define('COMMON_SERVICE_12','Senden Sie uns Ihre Fragen per E-Mail und Sie erhalten umgehend eine Antwort.');
define('COMMON_SERVICE_13','Jetzt E-Mail senden');
define('COMMON_SERVICE_14','Technischer Support');
define('COMMON_SERVICE_15','Fordern Sie online ein kostenloses Support- und Lösungsdesign für Ihre persönlichen Projekte an.');
define('COMMON_SERVICE_16','Support anfragen');
define('COMMON_SERVICE_17','Unser Team');
define('COMMON_SERVICE_18','FS sucht ständig nach neuen inspirierenden Ideen von Mitarbeitern und ermutigt jedes Teammitglied, seine Ideen uneingeschränkt auszusprechen.');
define('COMMON_SERVICE_19','So können wir unseren Service für Kunden auf der ganzen Welt konsequent ausweiten und verbessern.');
define('COMMON_SERVICE_20','Lernen Sie uns kennen');
define('FS_SHOP_CART_ALERT_JS_13','Aus*');
define('FS_SHOP_CART_ALERT_JS_14','An*');
define('FS_SHOP_CART_ALERT_JS_15',' Anmerkung (optional)');
//quote
define('FS_VIEW_QUOTE_SHEET','Angebotsblatt anzeigen');
define('FS_PRODUCT_HAS_BEEN_ADDED','Das Produkt wurde hinzugefügt.');
define('FS_SAVE_CSRT_LIMIT_TIP','Bitte geben Sie den Namen des Warenkorbs maximal 50 Wörter ein.');
define('FS_QUOTE','Angebot');
define('FS_SAVED_CART_EMAIL','E-Mail');



// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','Das Unternehmen');
define('FS_SUPPORT','Support');
define('FS_ABOUT_FS_COM','Über FS.COM');	//About FS.COM
define('FS_FOOTER_WHY_US','Warum uns wählen');
define('LATEST_NEWS','News');
define('FS_FOOTER_LATEST','News');
define('FS_FOOTER_CONTACT_US','Kontakt');
define('FS_QUALITY_COMMITMENT','Qualitätsverpflichtung');
// Frankie 2018.1.22
define('FS_LEGAL','Recht');
define('FS_IMPRINT','Impressum');
define('FS_PRIVACY_POLICY','Datenschutz');
define('FS_WITHDRAWAL','Widerrufsrecht');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','Kundenservice');
define('FS_FOOTER_OEM','OEM & Kunden');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM','OEM & Kunden');
define('FS_FOOTER_WARRANTY','Garantie');
define('FS_FOOTER_POLICY','Widerrufsrecht');
define('FS_RETURN_POLICY','Rückgaberecht');
define('FS_FOOTER_QUALITY','Qualitätsverpflichtung');
define('FS_FOOTER_PARTNER','Geschäftskonto');

// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','Zahlung & Lieferung');
define('FS_PAYMENT_METHODS','Zahlungsarten');
define('FS_NET_AMP_W',"Beschaffungsaufträge");
define('FS_FOOTER_DELIVERY','Versand & Lieferung');

// footer Quick Help
define('FS_FOOTER_QUICK_HELP','Schnelle Hilfe');
define('FS_FOOTER_PURCHASE_HELP','Einkaufshilfe');
define('FS_FORGOT_YOUR_PASSWORD','Passwort vergessen?');
define('FS_FOOTER_FAQ','FAQ');
define('FS_TRACK_YOUR_PACKAGE','Sendungsverfolgung');

// footer Questions? Aron 2017.8.6
define("FS_YAO1","Fragen? Wir sind 24h für Sie da.");
define("FS_YAO2","Wir sind 24h für Sie da");
define("FS_YAO3","Live-Chat");
define("FS_YAO4","Live Chat mit Berater");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Beliebte Seiten:');    //小语种没有这个

// 手机站切换版本
define('FS_FOOTER_LIVE_CHAT','Live Chat');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_HIGH_QUALITY","Hohe Qualität");
define("FS_SAFE_SHOPPING","Sicher einkaufen");
define("FS_FAST_DELIVERY","RETURN_DAYS Tage Rückgabe");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"Datenschutz");
define('FS_TERMS_OF_USE_DE',"AGB");
define('FS_SITE_MAP','Sitemap');
define('FS_FOOTER_FEEDBACK','Feedback');
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_FOOTER_COPYRIGHT",'Copyright © 2009-YEAR '.FS_LOCAL_COMPANY_NAME.', NOVA Gewerbepark, Building 7, Am Gfild 7, 85375 Neufahrn, Germany.');
define("FS_FOOTER_COPYRIGHT_M","Copyright © 2009-YEAR <span>".FS_LOCAL_COMPANY_NAME."</span>, NOVA Gewerbepark, Gebäude 7, Am Gfild 7, 85375 Neufahrn, Deutschland.");

// 德语站不一样
define("NEW_FOOTER_05",'Unsere Versandarten:');
define("NEW_FOOTER_06",'Akzeptierte Zahlungsmittel:');
define('NEW_FOOTER_COPY','Copyright &copy; 2009-'.date('Y',time()).' FS.COM GmbH, NOVA Gewerbepark, Gebäude 7, Am Gfild 7, 85375 Neufahrn, Deutschland.');
define('FS_FOOTER_HELP_CENTER','Hilfecenter');
define('FS_FOOTER_RETURN_POLICY','Rückgaberecht');
define('FS_FOOTER_REQUEST_A_SAMPLE','Eine Probe anfordern');
define("FS_FOOTER_SUPPORT","Support");



// common/footer_keyword_tags.php文件
define('FS_FOOTER_EASTERN_SIDE','Eastern Side, Second Floor, Science & Technology Park, No.6, Keyuan Road');
define('FS_FOOTER_NANSHAN','Nanshan District');
define('FS_FOOTER_SHENZHEN','Shenzhen');
//define('FS_FOOTER_COPYRIGHT','&copy; 2009-');
define('FS_FOOTER_FS','FS.COM');
define('FS_FOOTER_ALL_RIGHTS','Alle Rechte vorbehalten');
define('FS_FOOTER_PRIVACY','Datenschutz');
define('FS_FOOTER_TERMS','Nutzungsbedingungen');
define('FS_FOOTER_MOBILE_SITE','Mobile Site');



// common/header.php文件
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
define('FS_SAVED_CARTS', 'Gespeicherte Warenkörbe');
// 用户相关
define('FS_ACCOUNT', 'Konto');
define('FS_SIGN_IN','Anmelden');
define('FS_NEW_CUSTOMER','Neu bei FS.COM?');
define('FS_REGISTER_ACCOUNT','Konto eröffnen');
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
define('FS_RELATED_INFO','Verwandte Informationen');
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
define('FS_MY_CASES','Meine Anfragen');
define('FS_MY_QUOTES','Meine Angebote');
define('FS_ACCOUNT_SETTING',' Kontoeinstellungen');
define('FS_VIEW_ALL','Alles anzeigen');

// 搜索
define('FS_SEARCH_PRODUCTS','Produkt suchen');
define('HOT_PRODUCTS','Bestseller-Produkte');
define('FS_NEED_HELP','Hilfe');
define('FS_NEW_CHOOESE_CURRENCY','Währung wählen');
// 2018.7.23 fairy help
define('FS_NEED_HELP_BIG','Hilfe');
define('FS_CHAT_LIVE_WITH_US','Mit uns chatten');
define('FS_SEND_US_A_MESSAGE','Uns eine Nachricht senden');
define('FS_E_MAIL_NOW','Per E-Mail senden');
define("FS_LIVE_CHAT","Live Chat");
define("FS_WANT_TO_CALL","Uns anrufen");
define("FS_BREADCRUMB_HOME","Home");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Tech-Support erhalten');
define('FS_CHAT_LIVE_WITH_GET_A','Einen Experten fragen');

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


define('FS_TAGIMG_TITLE','Unsere Lösungen');
define('FS_INDEX_CATE_PRODUCTS','Produkte');


// common/patch_panel.php
define('PATCH_PANEL_01','Wo bekomme ich mehr technische Unterstützung?');
define('PATCH_PANEL_02','FS konzentriert sich auf Netzwerklösung der Datenzentren, Enterprise und optische Übertragung, um Ihre Bedürfnisse zu erfüllen.');
define('PATCH_PANEL_03','Bitte kontaktieren Sie uns unter  <a href="mailto:tech@fs.com">tech@fs.com</a> oder <a href="mailto:sales@fs.com">sales@fs.com</a>.');



// common/phone.php
//各国电话语言包 2017.8.18  ery
define('FS_PHONE_US','+1 (877) 205 5306');		// United States
define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 8176 3606');		// Hong Kong
define('FS_PHONE_MX','+52 (55) 3098 7566');		// Mexico
define('FS_PHONE_CA','+1 (647) 243 6342');		// Canada
define('FS_PHONE_BR','+55 (11) 4349 6175');		// Brazil
define('FS_PHONE_AR','+54 (11) 5031 9542');		// Argentina
define('FS_PHONE_GB','+44 (0) 121 716 1755');	// United Kingdom
define('FS_PHONE_FR','+33 (1) 82 884 336');		// France
define('FS_PHONE_NL','+31 (20) 241 4029');		// Netherlands
define('FS_PHONE_AU','+61 3 9693 3488');	// Australia
define('FS_PHONE_ES','+34 (91) 123 7299');		// Spain
define('FS_PHONE_RU','+7 (499) 643 4876');		// Russian Federation
define('FS_PHONE_SG','+(65) 3163 0003');		// Singapore
define('FS_PHONE_TW','+886 (2) 6630 3968');		// Taiwan
define('FS_PHONE_IT','+44 (0) 121 716 1755');	// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_WH','+86 (027) 87639823');     //wuhan
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_SITE_EU','+49 (0) 8165 80 90 517');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 (2) 8317 1119');
define('FS_PHONE_SITE_JP','+1 (877) 205 5306');
define('FS_PHONE_SITE_SG','+(65) 3163 0003');
define('FS_PHONE_SITE_US','+1 (877) 205 5306');
define('FS_PHONE_US_EAST','+1(888) 468 7419');

define('FS_COMMON_PHONE','+49 (0) 8165 80 90 517');



// common/resources.php
//catalog
define('PRODCUT_CATALOGS_01','Kataloge der Produkte');
define('PRODCUT_CATALOGS_02','Wissensbasis');
define('PRODCUT_CATALOGS_03','Lösungen');
define('TUTORIAL_ALL','All');
define('TUTORIAL_ALL_ATGS','Alle Zeichen');
define('FS_LOAD_MORE','Mehr');
define('FS_SUPPORT_CASE','Fallstudien');

//support
define('SUPPORT_SEC_01','Verbindungslösung');
define('SUPPORT_SEC_02','Verkabelungslösung');
define('SUPPORT_SEC_03','Enterprise-Lösung');
define('SUPPORT_SEC_04','WDM-Lösung');
define('SUPPORT_SEC_05','FTTX-Lösung');


//knowledge
define('KNOWLEDGE_01','Faseroptik 1');
define('KNOWLEDGE_02','Wissensbasis, um IT-Profis zu helfen und die Zukunft des Geschäfts zu gestalten');
define('KNOWLEDGE_03','VERWANDT');
define('KNOWLEDGE_04','Teilen');
define('KNOWLEDGE_05','Verwandte Blogs');
define('KNOWLEDGE_06','THEMEN');

define('PRODCUT_CATALOGS_04','Videos der Produkte');
define('PRODCUT_CATALOGS_05','All');
define('PRODCUT_CATALOGS_06','Networking');
define('PRODCUT_CATALOGS_07','Verkabelung');
define('PRODCUT_CATALOGS_08','WDM & FTTx');
define('PRODCUT_CATALOGS_09','Unternehmensnetz');
define('PRODCUT_CATALOGS_10','Test & Werkzeug');




// common/save_shopping_list.php
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','Eine Webseite aus FS.COM wurde mit Ihnen geteilt!');
define('EMAIL_SAVE_DEAR','Liebe(r) Kundin(e)');
//2017.5.30		add		ery
define('FS_AJAX_PAST','Sie machten ein Einkaufen bei FS.COM und wollten diese Seite & Nachricht für selbst speichern!');
define('FS_AJAX_THIS','Diese E-Mail wurde von Ihnen mit Teilenservice von FS.COM gesendet. Als Ergebnis des Empfangens dieser Nachricht erhalten Sie keine unerwünschte Nachricht von FS.COM. Erfahren Sie mehr über unsere ');
define('FS_AJAX_PRIVACY','Datenschutzrichtlinie');
define('FS_AJAX_WAS',' hat bei FS.COM eingekauft und wollte diese Seite und Nachricht mit Ihnen teilen!');
define('FS_AJAX_SENT','Diese E-Mail wurde von Ihrem Freund gesendet ');
define('FS_AJAX_USING',' Verwenden Sie bitte Teilenservice von FS.COM. Als Ergebnis des Empfangens dieser Nachricht erhalten Sie keine unerwünschte Nachricht von FS.COM, erfahren Sie mehr über unsere ');


// common/tracking_info.php
define('MY_ORDER_SUCCESSFULLY','Order submitted successfully, wait for your payment.');
define('MY_ORDER_WAIT','You have paid successfully, please wait for shipment.');
define('FIBERSTORE_BY_SYSTEM','by the system');
define('FIBERSTORE_SESTEM','FS.COM system');
define('FIBERSTORE_INFO_TIME','Processing Time');
define('FIBERSTORE_INFO_PROCESS','Process Information');
define('FIBERSTORE_INFO_OPERATOR','Process Operator');



// functions/product_instock.php
define('FS_SHIP_PC',' Stk.');
define('FS_SHIP_PCS',' Stk.');
define('FS_SHIP_AVAI','erhältlich');
define('FS_SHIP_STOCK',' auf Lager');
define('FS_SHIP_DEVE','Entwicklung');
define('FS_SHIP_ESTIMATED','Versand am ');
define('FS_SHIP_INVENTORY','Der Mangel an Vorrat,Versand erhältlich am ');
define('FS_SHIP_ROLL',' Rolle');
define('FS_SHIP_ROLLS',' Rollen');
define('FS_SHIP_ROLL_1KM',' (1Rolle = 1KM)');
define('FS_SHIP_ROLL_2KM',' (1Rolle = 2KM)');
define('FS_SHIP_TODAY_BEFOR','Der Mangel an Vorrat,Versand erhältlich am ');

//2017.6.13 add by Frankie
define('FS_SHIP_PLACE','Wenn Sie den Auftrag heute bestellen, wird das Artikel innerhalb von ');
define('FS_SHIP_DAYS',' Werktagen versandt.');



define("CREDIT_HOLDER_NAME_ERROR1","Der Name des Karteninhabers ist Pflichtfeld.");
define("CREDIT_HOLDER_NAME_ERROR2","Der Name des Karteninhabers ist falsch. Bitte geben Sie ihn erneut ein.");
define("CREDIT_CARD_NUMBER_ERROR1","Die Kartennummer ist Pflichtfeld.");
define("CREDIT_CARD_NUMBER_ERROR2","Die Kartennummer existiert nicht. Bitte geben Sie eine gültige Kartennummer ein.");
define("CREDIT_CARD_DATE_ERROR1","Das Ablaufdatum ist Pflichtfeld.");
define("CREDIT_CARD_DATE_ERROR2","Das Ablaufdatum ist falsch. Bitte geben Sie es erneut ein.");
define("CREDIT_CARD_CODE_ERROR1","Der Sicherheitscode ist Pflichtfeld.");
define("CREDIT_CARD_CODE_ERROR2","Der Sicherheitscode ist falsch. Bitte geben Sie ihn erneut ein.");


//首页

//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', 'Leistungstest');
define('NEW_PATCH_PANEL_02', 'Alle unsere Ethernet-Netzwerkkabel bestehen den Fluke Channel Test.');
define('NEW_PATCH_PANEL_03', 'Qualitätskontrolle');
define('NEW_PATCH_PANEL_04', 'Garantierte Qualitätszertifizierung durch CE, RoHS und ISO9001.');
define('NEW_PATCH_PANEL_05', 'Großer Lagerbestand');
define('NEW_PATCH_PANEL_06', 'Ausreichender Lagerbestand für Versand am selben Tag.');
define('NEW_PATCH_PANEL_07', 'Hervorragende Preis-Leistung');
define('NEW_PATCH_PANEL_08', 'Wir bieten den besten Preis und schonen Ihr Budget.');

define('NEW_PATCH_PANEL_01_209', 'Strenges Testprogramm');
define('NEW_PATCH_PANEL_02_209', 'Endflächeninspektion &amp; IL-Verlust &amp; RL-Verlust.');

define('NEW_PATCH_PANEL_01_1', 'Hohe Flexibilität');
define('NEW_PATCH_PANEL_02_1', 'Unterstützt mehrere Schnittstellen und erfüllt unterschiedliche Anforderungen an die Glasfaserübertragung.');
define('NEW_PATCH_PANEL_04_1', 'Alle Produkte wurden strengen Tests unterzogen.');

define('NEW_PATCH_PANEL_01_911', 'Schnelle Lieferung');
define('NEW_PATCH_PANEL_02_911', 'Mit unseren lokalen Lagerhäusern decken wir die Märkte weltweit ab und sparen Ihnen wertvolle Zeit.');

define('NEW_PATCH_PANEL_01_9', 'Breite Kompatibilität');
define('NEW_PATCH_PANEL_02_9', 'Kompatibel mit allen gängigen Anbietern und Systemen.');
define('NEW_PATCH_PANEL_04_9', 'Garantierte Qualitätszertifizierung durch CE, RoHS, IEC, FCC und ISO9001.');

define('NEW_PATCH_PANEL_02_4', 'Alle Produkte werden eingehend getestet, um die Erfüllung von Standardanforderungen sicherzustellen.');
define('NEW_PATCH_PANEL_08_4', 'Wir bieten den besten Preis und schonen Ihr Budget.');


//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
    Diese E-Mail wurde <a style="color: #232323;text-decoration: none;" href="javascript:;"></a> über <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a> gesandt. Sie werden keine unangeforderte Nachrichten von <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS</a>
                            erhalten. Klicken Sie <a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">hier</a> für mehr Informationen über unsere Datenschutzerklärung.
                        </td></tr></table>');


//邮件
define('SAMPLE_EMAIL_DEAR','Hallo');
define('SAMPLE_EMAIL_01', 'Wir haben Ihre Anfrage erhalten und werden uns in Kürze bei Ihnen melden.');
define('SAMPLE_EMAIL_02', ' Hier ist Ihre Anfragenummer <a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>.  Sie können mit dieser Nummer alle nachfolgenden Mitteilungen zu dieser Anfrage finden.');
define('SAMPLE_EMAIL_03', 'Anfrager(in): ');
define('SAMPLE_EMAIL_04', 'E-Mail-Adresse: ');
define('SAMPLE_EMAIL_05', 'Land: ');
define('SAMPLE_EMAIL_06', 'Telefonnummer: ');
define('SAMPLE_EMAIL_07', 'Ihre Anmerkung: ');
define('SAMPLE_EMAIL_08', 'Mit freundlichen Grüßen');
define('SAMPLE_EMAIL_09', 'FS Team');
define('SAMPLE_EMAIL_30', 'Die Anfragenummer ist <a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>. Mit dieser Nummer können Sie alle zusätzliche Anmerkungen oder Fragen davon auf der Seite <a style="color: #0070bc;text-decoration: none" href="$HREF">Anfragedetails</a> finden.');

define('FS_CONTACT_GET_SUPPORT','Wir helfen Ihnen gerne bei jeder Frage.');
define('FS_CONTACT_LEAVE','Nachricht hinterlassen');

define('CUSTOMER_SERVICE_OTHERS_46', 'Haben Sie schon ein Konto bei FS? Sie können sich hier <a style="color: #0070bc;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Anmelden</a> oder ein <a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Konto eröffnen</a>.');
define('CUSTOMER_SERVICE_OTHERS_47', 'Sie können sich <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Anmelden</a> oder <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Ein Konto eröffnen</a>, um personalisierten Service zu erhalten.');
define('CUSTOMER_SERVICE_OTHERS_48', 'Sie können hier sich <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Anmelden</a> oder ein <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Konto eröffnen</a>.');

//服务页面公用
define('FS_SUPPORT_FORM_TXT','Füllen Sie bitte die Info aus. Wir werden uns möglichst schnell Ihnen melden.');
define('FS_SUPPORT_FORM_PLACEHOLDER','Ihre Anmerkungen helfen FS bei schneller Antworten.');
define('FS_PLEASE_ENTER_COMMENTS','Bitte geben Sie den Anfrageinhalt ein.');
define('FS_COMMON_AT_LEAST','Der Inhalt muss mindestens 3 Zeichen lang sein.');
define('FS_COMMON_AT_MOST','Der Inhalt darf maximal 10 Zeichen lang sein.');
define("FS_SUPPORT_EMAIL","E-Mail");
define('FS_SUPPORT_PHONE','Telefon');
define('FS_FIRST_NAME_PLEASE','Bitte geben Sie Ihren Vornamen ein.');
define('FS_LAST_NAME_PLEASE','Bitte geben Sie Ihren Nachnamen ein.');
define('FS_SUPPORT_COMMENTS','Anmerkung');
define('FS_SUPPORT_FIRST_NAME','Vorname');
define('FS_SUPPORT_LAST_NAME','Nachname');
define('SOLUTION_PRIVACY_POLICY','Ich stimme <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>Datenschutzerklärung</a> und <a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'>AGB</a> von FS zu.');
define('FS_SERVICE_SUBMIT','Absenden');
define('FS_SUPPORT_EMAIL_TOUCH_SOON','Wir haben Ihre Supportanfrage erhalten und unser Team wird Sie in Kürze kontaktieren.');

//shopping_cart save_items 页面的 meta标签 2019.12.23
define('META_TAGS_SHOPPING_CART_TITLE', 'Warenkorb');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', 'Hier erhalten Sie die besten Produkte für Rechenzentren, Unternehmensnetzwerke und Internetzugänge. Wir bieten einfache und kostengünstige Unternehmenslösung an.');
define('META_TAGS_SAVED_ITEMS_TITLE', 'Gespeicherte Warenkörbe');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', 'Nachdem Sie Artikel zum Warenkorb hinzugefügt haben, klicken Sie auf "Warenkorb speichern", um alle Artikeln des Warenkorbs zu speichern. Sie können mehrere Warenkörbe speichern und sie für wiederholte Bestellungen verwenden.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Lagerliste der 10G CWDM/DWDM SFP+');
define('META_TAGS_SFP_DESCRIPTION', 'Bei dem vollständige Produktportfolio von 10G CWDM/DWDM SFP+ Transceivern (DWDM SFP+ 80km/40km, CWDM SFP+ 80km/40km/20km/10km) können Sie einen schnellen Überblick über den Produktbestand und Hilfe bei den WDM-Lösungen erhalten.');


//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','So realisieren wir Ihre Ziele');
define('FS_SPECIAL_DESIGN_CENTER','Design Center');
define('FS_SPECIAL_DESIGN_CENTER_DES','Kompetenz in der Umsetzung von Anforderungsprofilen und<br/>der Bereitstellung einer innovativen, kostengünstigen<br/>und zuverlässigen Komplettlösung.');
define('FS_SPECIAL_QUALITY','Quality Center');
define('FS_SPECIAL_QUALITY_DES','Bereitstellung hochwertiger Produkte mit strengen Tests<br/>und Zertifizierungen nach Industriestandards.');
define('FS_SPECIAL_TEC','Support anfragen');
define('FS_SPECIAL_TEC_SMALL','Support anfragen');
define('FS_SPECIAL_TEC_DES','Erhalten Sie kostenlosen Support & Lösungsdesigns für Ihr<br/>Projekt online.');

define('FS_SUBMIT_SUCCESS','Ihre Anfrage ##number## wurde erfolgreich übermittelt.');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','Wir werden Ihnen innerhalb von 1 bis 3 Stunden während der Arbeitszeit telefonisch oder per E-Mail antworten');

define('SAMPLE_EMAIL_31', 'Adresse: ');
define('SAMPLE_EMAIL_32', 'Menge: ');
define('SAMPLE_EMAIL_33', 'Angeforderte Proben');

define('FS_BROWSING_HISTORY','Zuletzt angesehene Produkte');

define('FS_PRODUCT_DOWNLOAD', 'Downloads');
define('FS_PRODUCT_MORE', 'Mehr erfahren');
define('FS_PRODUCT_SUPPORT','Produktsupport');

//结算页、订单确认成功页、银行转账邮件、订单详情
define("PAYMENT_BANK_ACH","Überweisung/ACH-Überweisung");
define("PAYMENT_BANK_ACH_CA","Überweisung");
define("PAYMENT_BANK_OF_US","Bank of America");
define("PAYMENT_BANK_VIA","Per Überweisung");
define("PAYMENT_BANK_ACCOUNT_NAME","FS COM INC");
define("PAYMENT_BANK_WIRE_ROUTING","Bankleitzahl:");
define("PAYMENT_BANK_SWIFT_CODE","Swift-Code:");
define("PAYMENT_BANK_ACH_ROUTING","ACH Routing Nummer:");
define("PAYMENT_BANK_VIA_ACH","Per ACH");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",FIBER_CHECK_COMMON_ACCOUNT_NAME);
define("PAYMENT_BANK_ACCOUNT",'Kontonummer:');
define("PAYMENT_BANK_ADDRESS",FS_ADDRESS_ADDRESS.':');

// QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL','Menge');
define('FS_QV_QUICK_VIEW','Schnellansicht');
define('FS_SEE_FULL_DETAILS','Produktdetails anzeigen');
define('FS_CUSTOMIZED','In den Warenkorb');
define('FS_PRODUCTS_INFORMATION','Produktinformationen');
define('FS_CUSTOMER_ALSO_VIEWED','Andere Kunden haben die folgenden Produkte durchsucht');

// fairy 2019.1.15 add 公共标题需要
define('FS_TITLE_COMPATIBLE','Kompatibel');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'Wieder kaufen');
define('FS_BUY_MORE_02', 'Die erneut gekauften Produkte entsprechen genau den Produkten Ihrer Bestellung %s.');	//%s会替换成订单号
define('FS_BUY_MORE_03', 'Das Produkt entspricht genau dem Produkt der Bestellung %s.');		//%s会替换成订单号

//头部下拉版块
define('FS_HEADER_SUPPORT','Support');
define('FS_HEADER_TEC_SUPPORT','Technischer Support');
define('FS_HEADER_CUSTOMER_SUPPORT','Kundensupport');
define('FS_HEADER_SERVICE_SUPPORT','Service Support');
define('FS_HEADER_TEC_DES','In unserer Ressourcenbibliothek finden Sie Dokumente, Case Studies, Videos und mehr. Außerdem können Sie technische Unterstützung anfordern, um maßgeschneiderte Lösungen zu erhalten.');
define('FS_HEADER_TEC_URL_01','Technische Dokumente');
define('FS_HEADER_TEC_URL_02','Prüfstand (Assurance-Programm)');
define('FS_HEADER_TEC_URL_03','Software-Downloads');
define('FS_HEADER_TEC_URL_04','Qualitätsverpflichtung');
define('FS_HEADER_TEC_URL_05','Case Studies');
define('FS_HEADER_TEC_URL_06','Produktgarantie');
define('FS_HEADER_TEC_URL_07','Videos');
define('FS_HEADER_SUPPORT_RIGHT_DES','Erhalten Sie Tech-Support von FS-Experten');
define('FS_HEADER_SUPPORT_RIGHT_URL','Support anfragen');
define('FS_HEADER_CUSTOMER_DES','Erhalten Sie umgehend Hilfe vor oder nach dem Kauf: Bestellanfrage, Auftragserteilung, Sendungsverfolgung oder andere verwandte Themen.');
define('FS_HEADER_CUSTOMER_URL_01','Angebote anfragen');
define('FS_HEADER_CUSTOMER_URL_02','Rückgabe & Rückerstattung');
define('FS_HEADER_CUSTOMER_URL_03','Produktprobe anfordern');
define('FS_HEADER_CUSTOMER_URL_04','Kauf auf Rechnung');
define('FS_HEADER_CUSTOMER_URL_05','Beschaffungsauftrag');
define('FS_HEADER_CUSTOMER_URL_07','Sendungsverfolgung');
define('FS_HEADER_CUSTOMER_URL_08','Neue Produkte');
define('FS_HEADER_CUSTOMER_URL_09','Sonderangebote');
define('FS_HEADER_CUSTOMER_URL_10','Produkt-Authentifizierung');
define('FS_HEADER_CUSTOMER_URL_11','Produkt-Demonstration');
define('FS_HEADER_SERVICE_DES','Informieren Sie sich über häufig nachgefragte Themen zu Konto, Versand, Rücksendungen usw. FS ist bestrebt, Ihnen das Kauferlebnis so einfach wie möglich zu gestalten.');
define('FS_HEADER_SHIPPING_DELIVERY','Versand & Lieferung');
define('FS_HEADER_RETURN_POLICY','Rückgaberecht');
define('FS_HEADER_PAYMENT','Zahlungsarten');
define('FS_HEADER_HELP_CENTER','FS Support');
define('FS_HEADER_COMPANY','Firma');
define('FS_HEADER_ABOUT_US','Über Uns');
define('FS_HEADER_CONTACT_US','Kontakt');
define('FS_HEADER_NEWS','Unsere Partner');
define('FS_HEADER_ABOUT_DES','FS ist einer der weltweit führenden Anbieter von Kommunikationshardware und Projektlösungen. Wir unterstützen Sie bei Aufbau, Anschluss, Schutz und Optimierung Ihrer optischen Infrastruktur.');
define('FS_HEADER_ABOUT_EXPLORE','Mehr erfahren');
define('FS_HEADER_CONTACT_DES','Wir sind für Sie da. Gerne können Sie sich jederzeit mit uns in Verbindung setzen, um schnellen und kompetenten technischen Support und Kundendienst zu erhalten.');
define('FS_HEADER_LEARN_MORE','Mehr erfahren');

define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('company/fiberstore_with_partners.html').'"><span>Mehr erfahren</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_DES','<dd>FS bietet maßgeschneiderte, kostengünstige Netzwerklösungen für viele Unternehmen. Auf unsere Produkte und Dienstleistungen vertrauen weltweit führende Unternehmen.</dd>');
define('FS_HEADER_NEWS_RIGHT_DES','FS hat eine Reihe internationaler maßgeblicher Zertifizierungen erhalten');
define('FS_HEADER_NEWS_RIGHT_DATE','8. Juni 2020');

define('FS_CUSTOMER_SUPPORT_TIP','XXX ist ein maßgeschneiderter Artikel. Für Details kontaktieren Sie bitte Ihren Account Manager.');

define('FS_RMA_WAREHOUSE_CN','<dt>Empfänger: FS. COM LIMITED</dt>
			<dd>Adresse: A115 Jinhetian Business Centre No.329, Longhuan Third Rd Longhua District Shenzhen, 518109, China</dd>
			<dd>Tel.: +86-0755-83571351</dd>');
// 德国仓
define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH </dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Germany</dd>
			<dd>Tel.: +49 (0) 8165 80 90 517</dd>');
define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC </dt>
			<dd>380 CENTERPOINT BLVD, NEW CASTLE, DE 19720, United States</dd>
			<dd>Tel: +1 (888) 468 7419</dd>');
// 美东仓
define('FS_RMA_WAREHOUSE_US_EAST','<dt>Empfänger: FS.COM Inc.</dt>
					<dd>Adresse: 380 Centerpoint Blvd, New Castle, DE 19720, United States</dd>
					<dd>Tel.: +1 (888) 468 7419</dd>');
// 澳洲仓
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australia</dd>
				<dd>Tel: +61 3 9693 3488</dd>
				<dd>ABN: 71 620 545 502</dd>');
// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>Empfänger: FS Tech Pte Ltd.</dt>
				<dd>Adresse: 30A Kallang Place #11-10/11/12, Singapore 339213</dd>
				<dd>Tel.: +(65) 6443 7951</dd>');

define('FS_RMA_WAREHOUSE_RU','<dt>FS.COM Ltd.</dt>
            <dd>No.4062, d. 6, str. 16, Proektiruemyy proezd, Moscow 115432, Russian Federation</dd>
            <dd>Tel.: +7 (499) 643 4876</dd>');

//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','Angebote');
define('FS_ACCOUNT_TW_CREDIT','Kreditkonto');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','Details über Kreditkonto');
define('FS_ACCOUNT_TW_USER','Informationen');
define('FS_ACCOUNT_TW_SUPPORT','Meine Anfragen');
define('FS_ACCOUNT_TW_TAX','Tax Exempt Apply');
define('FS_ACCOUNT_TW_USEFUL','Hilfe');
define('FS_ACCOUNT_TW_ACCOUNT','Kontoinformationen');
define('FS_ACCOUNT_TW_YOU','Sie haben Bestellungen, die noch nicht bezahlt wurden.');
define('FS_ACCOUNT_TW_ORDERS','Bestellungen');
define('FS_ACCOUNT_TW_MOST_ORDER','Letzte Bestellung');
define('FS_ACCOUNT_TW_VIEW_ORDERS','Alle Bestellungen');
define('FS_ACCOUNT_TW_ORDERS_SEARCH','Bestell-, Auftrags-Nr., Produkt-ID, Artikel-Nr., Anmerkung');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','Ausstehend');
define('FS_ACCOUNT_TW_WAIT','Warten auf Versand');
define('FS_ACCOUNT_TW_TRANSIT','Unterwegs');
define('FS_ACCOUNT_TW_DELIVERED','Geliefert');
define('FS_ACCOUNT_TW_PENDING_REVIEW','Bestellung bewerten');
define('FS_ACCOUNT_TW_NO_ORDER','Keine Bestellung');
define('FS_ACCOUNT_TW_VIEW_CART','Zum Warenkorb');
define('FS_ACCOUNT_TW_VIEW_TICKETS','Alle Anfragen');
define('FS_ACCOUNT_TW_CREATE_TICKET','Neue Anfrage erstellen');
define('FS_ACCOUNT_TW_SEARCH_TICKET','Anfragenummer, Beschreibung');
define('FS_ACCOUNT_TW_TICKET','Anfragenummer');
define('FS_ACCOUNT_TW_TICKET_TYPE','Anfragetyp');
define('FS_ACCOUNT_TW_TICKET_COMMENT','Beschreibung');
define('FS_ACCOUNT_TW_TICKET_DATE','Erstellungsdatum');
define('FS_ACCOUNT_TW_TICKET_STATUS','Status');
define('FS_ACCOUNT_TW_TICKET_ACTION','Optionen');
define('FS_ACCOUNT_TW_NO_TICKET','Keine Anfrage');
define('FS_ACCOUNT_TW_ORDER','Bestellnummer');
define('FS_ACCOUNT_TW_SPLIT_ORDER','Geteilte Lieferung');
define('FS_ACCOUNT_TW_DELIVERY','Lieferung');
define('FS_ACCOUNT_TW_DELIVERY_ON','Zustellung am ');
define('FS_ACCOUNT_TW_THE','Die folgenden Produkte können aus dem unten angegebenen Grund nicht direkt wieder bestellt werden. Klicken Sie auf „Überspringen“, um die anderen Produkte dem Warenkorb hinzuzufügen.');
define('FS_ACCOUNT_TW_THE_NO','Die folgenden Produkte können aus dem unten angegebenen Grund nicht direkt wieder bestellt werden. Klicken Sie auf „Überspringen“, um die anderen Produkte dem Warenkorb hinzuzufügen.');
define('FS_ACCOUNT_TW_ITEMS','Die erneut gekauften Produkte entsprechen genau den Produkten Ihrer Bestellung #%s.');
define('FS_ACCOUNT_TW_YOU_CAN','Fügen Sie alle Produkte dieser Bestellung dem Warenkorb erneut hinzu.');
define('FS_ACCOUNT_TW_ORDER_AGAIN','Wieder kaufen');
define('FS_ACCOUNT_TW_CREATE_TICKET','Neue Anfrage erstellen');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','Anfragetyp');
define('FS_ACCOUNT_TW_ATTACH_PO','Auftragsdatei hochladen');
define('FS_ACCOUNT_TW_SHOW_MORE','Mehr anzeigen');
define('FS_ACCOUNT_TW_BASIC_INFO','Basisinformationen');
define('FS_ACCOUNT_TW_ADDRESS_INFO','Addresse');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','Sie können die Artikel dem Warenkorb hinzufügen und dann ein Angebot anfragen.');
define('FS_ACCOUNT_TW_MOST_QUOTE','Meine Angebote');
define('FS_ACCOUNT_TW_VIEW_QUOTES','Alle Angebote');
define('FS_ACCOUNT_TW_NO_QUOTE','Kein Ergebnis');
define('FS_ACCOUNT_TW_QUOTE_ITEM','Angebotsnummer, Produkt-ID');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','Aus dem unten angegebenen Grund kann ein Angebot nicht direkt wieder für die folgenden Artikel erstellt werden.');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','Aus dem unten angegebenen Grund kann ein Angebot nicht direkt wieder für die folgenden Artikel erstellt werden. Klicken Sie auf „Weiter“, um die anderen Produkte dem Warenkorb hinzuzufügen und ein Angebot anfragen.');

define('FS_FOOTER_EXPLORE','Community');
define('FS_HEADER_NEW_PRODUCT','Neue Produkte');
define('FS_HEADER_CHANGE','Ändern');
define('FS_COMMON_VIEW_MORE','Mehr anzeigen');
define("FS_HLEP_CENTER",'FS-Support');
define('FS_CART_EMPTY_TIP','Ihr Warenkorb ist leer. Melden Sie sich an oder kaufen Sie weiter.');
define('BIllS_TIPS1','Hier können Sie alle Ihre Rechnungen ansehen.');
define('BIllS_TIPS2','Hier können Sie den Status Ihres Kreditkontos und alle Rechnungen ansehen.');
define('TIPS_BUTTON', 'Bestätigen');
define('TIPS_NEW', 'Neu');
define('FS_ATTRIBUTE_CUSTOMIZED','Maßgeschneidert');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' Jahre');
define('FS_WARRANTY_YEAR',' Jahr');
define('FS_WARRANTY_DAYS',' Tage');
define('FS_WARRANTY_CONSUMABLE','Verbrauchsartikel');
define('FS_WARRANTY_UNAVAILABLE','Nicht verfügbar');
define('FS_WARRANTY_SUB_CATEGORY','Kategorie');
define('FS_WARRANTY_RETURN','Rückgabe');
define('FS_WARRANTY_CHANGE','Umtausch');
define('FS_WARRANTY_PERIOD','Garantiezeit');

define('FS_WARRANTY_NOTE','Anmerkung');

define('ORDER_PAYMENT_TIPS','Bitte stellen Sie sicher, dass die unten angegebene Rechnungsadresse mit der auf Ihren Kreditkartenabrechnungen übereinstimmt.');
define('ORDER_PAYMENT_SAFE','Sicher & Verschlüsselt');
define('ORDER_PAYMENT_TIPS_2','Ihre Kartendaten werden nur zur Bestellbearbeitung verwendet und nicht gespeichert.');
