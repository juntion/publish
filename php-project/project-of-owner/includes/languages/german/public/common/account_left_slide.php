<?php 

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
define('ACCOUNT_SETTING','Konto bearbeiten');
define('FS_RETURN_ORDERS','Zurückgeschickte Bestellungen');
define('FS_MY_QUOTES','Meine Angebote');
define('FS_WISH_LIST','Merkzettel');
define('FS_MY_CASES','Meine Fragen');
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
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Vielen Dank für Ihren Einkauf bei FS.COM.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Straße Nr., c/o");
define("ADDRESS_PLACE_HODLER2","Hausnr.");
define("FS_ZIP_CODE","Postleitzahl");
define("FS_ADDRESS","Straße");
define("FS_ADDRESS2","Adresszeile 2");
define('FS_CHECK_COUNTRY_REGION','Land/Region');
// 这里没有验证语言包是因为german.php里面已经有了。其他语种等后期在整理
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","Adresszeile 2 muss zwischen 4 und 35 Zeichen lang sein.");
define("FS_CITY_MIN_MAX_TIP","Adresszeile 2 muss zwischen 1 und 50 Zeichen lang sein.");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','Alle Bestellungen');
define('FS_ORDER_PENDING','Ausstehend');
define('FS_ORDER_COMPLETED','Abgeschlossen');
define('FS_ORDER_CANCELLED','Storniert');
define('FS_ORDER_PURCHASE','Purchase');
define('FS_ORDER_PROGRESSING','Bearbeitet');
define('FS_ORDER_RETURN_ITEM','Zurückgeschickte Artikel');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Die Datei wurde erfolgreich hochgeladen.');