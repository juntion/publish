<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: shopping_cart.php 3183 2006-03-14 07:58:59Z birdbrain $
 */
//festival tip
define('HAPPY_NEW_YEAR','Frohes neues Jahr!');
define('FESTIVAL_TIP','Produkte aus unserem globalen Lager werden aufgrund unseres Feiertags (23. Januar - 2. Februar) verzögert, aber Produkte aus unserem Seattle-Lager können mit Lieferung am selben Tag verfügbar sein.');
define('FS_WISH','FS.COM bitten um Ihr Verständnis und wünschen Ihnen ein glückliches neues Jahr!');

define('NAVBAR_TITLE', 'Die Inhalte in Ihrem Einkaufswagen');
define('HEADING_TITLE', 'Die Inhalte in Ihrem Einkaufswagen');
define('HEADING_TITLE_EMPTY', 'Ihr Einkaufswagen');
define('TEXT_INFORMATION', 'Vielleicht brauchen Sie einige Anweisungen für das Benutzen von Einkaufswagen hier. (defined in includes/languages/english/shopping_cart.php)');
define('TABLE_HEADING_REMOVE', 'Beseitigen');
define('TABLE_HEADING_QUANTITY', 'Menge.');
define('TABLE_HEADING_MODEL', 'Modell');
define('TABLE_HEADING_PRICE','Unit');
define('TEXT_CART_EMPTY', 'Ihr Einkaufswagen ist leer !');
define('SUB_TITLE_SUB_TOTAL', 'Zwischensumme:');
define('SUB_TITLE_TOTAL', 'Gesamtsumme:');

define('FIBERSTORE_ITEMS',' Artikel');
define('FIBERSTORE_PROTECT_CHECKOUT','Zur Kasse gehen');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Produkte, die mit ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' makiert werden, sind ausverkauft oder nicht genug für Ihren Auftrag. <br /> Bitte verändern Sie die Menge von den mit (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ') markierten Produkten. Vielen Dank!');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Produkte, die mit' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' makiert werden, sind ausverkauft.<br />Die ausverkauften Artikel werden im Auftragsrückstand gelegt.');

define('TEXT_TOTAL_ITEMS', 'Gesamte Artikel: ');
define('TEXT_TOTAL_WEIGHT', '&nbsp;&nbsp;Gewicht: ');
define('TEXT_TOTAL_AMOUNT', '&nbsp;&nbsp;Menge: ');

define('TEXT_VISITORS_CART', '<a href="javascript:session_win();">[help (?)]</a>');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');

/***********BOF SHOPPING CART LANGUAGE************************/
define('FIBERSTORE_CART_HAVE','Sie haben');
define('FIBERSTORE_CART_ITEM','Artikel in Ihrem Einkaufswagen');

define('FIBERSTORE_REMOVE_ITEMS','Nicht Ihr Einkauswagen? Artikel löschen');
define('FIBERSTORE_CART_CHECKOUT','ZUR KASSE GEHEN');
define('FIBERSTORE_CART_CURRENTLY','Zurzeit in Ihrem Einkaufswagen');

define('FIBERSTORE_CART_OPERATE','Operieren');
define('FIBERSTORE_CART_BUY','Einkaufen Bei FiberStore.com ist sicher. Ihr Auftrag wird auf unseren sicheren Servern behandelt.');
define('FIBERSTORE_CART_ACTUALIZAR','Update');
define('FIBERSTORE_CART_BORRAR','Beseitigen');
define('FIBERSTORE_CART_APPLY','We automatically apply all eligible promotions to offer you the lowest possible price.');
define('FIBERSTORE_CARTTOTAL','Gesamtsumme im Einkaufswagen');
define('FIBERSTORE_SHIPPING_COST','Geschäzte Versandkosten');
define('FIBERSTORE_TOTAL_GENERAL','Gesamtsumme:');

define('FIBERSTORE_CART','Einkaufswagen');

define('FIBERSTORE_SUCCESS','Erfolg');
define('FIBERSTORE_ALL','Alles');
define('FIBERSTORE_DELETE','Löschen');

define('FIBERSTORE_CART_RETURNS','<a href="'.zen_href_link(FILENAME_RMA_SOLUTION).'">Richtlinie von Lieferung und Rückgabe</a> | <a href="'.zen_href_link(FILENAME_PRIVACY_POLICY).'">Datenschutzrichtlinie</a>');
define('FIBERSTORE_CART_QUESTION','Haben Sie Frage? Das kundentreue Team bei FiberStore freut sich sehr, Ihnen zu helfen!');
define('FIBERSTORE_CART_CALL','Rufen Sie unseres kundentreue Team 24 Stunden am Tag - 365 Tage im Jahr an.');
define('FIBERSTORE_CALL_EMAIL','Rufen Sie unter dieser Nummer(+86) 755-83003611 oder<a href="'.zen_href_link(FILENAME_CONTACT_US).'">schicken Sie eine E-Mail an unserem kundentreuen Team</a>');
define('FIBERSTORE_CART_NOTE','* NOTIZ: FiberStore Co., Ltd ist von dem Gesetz verlangt, Umsatzsteuer für Bestellungen zu bestimmten Ländern zu erheben. Mehr erfahren. Angemessene Kosten wird zu Ihrer Gesamtsumme von Waren hinzugefügt und Ihnen bevor der Zahlung zeigen. (Die auf dieser Seite gezeigte Steuer wird sich vieleicht ändern, wenn Sie Ihre Lieferungsadresse erneut haben.).');
define('FIBERSTORE_CART_UNLESS','Sofern nicht anders angegeben, alle Produkte sind von FiberStore Co., Ltd verkauft');
/***********EOF **********************/



/********************************/
define('TEXT_FIBERSTORE_REGIST_RESPECTS','FS.COM respektiert Ihre private Daten，Wir werden niemandem Ihre private Informationen mieten oder verkaufen.');

define('TEXT_LOGIN_GUARANTEED','GARANTIERT!');

define('ACCOUNT_FOOTER_TITLE','Einkaufen mit Vertrauen');

define('ACCOUNT_FOOTER_SHOPPING','EINKAUFEN BEI FIBERSTORE.COM');

define('ACCOUNT_FOOTER_SECURE','IST SICHER.');

define('ACCOUNT_FOOTER_PAY','Sie brauchen nichts zu zahlen,wenn Sie unautorisierte Rechnung wegen des Einkaufens bei fiberstore.com in Kreditkarte erhalten');

define('ACCOUNT_FOOTER_SAFE','Gesichertes Einkauf');

define('ACCOUNT_FOOTER_INFORMATION','Alle Informationen sind durch das Secure Sockets Layer (SSL) Protokoll ohne Risiko verschlüsselt und gesendet.');

define('ACCOUNT_FOOTER_HOW','Wie schützen wir Ihre privaten Daten?');

define('ACCOUNT_FOOTER_FREE','LIEFERUNG UND RÜCKGABE SIND KOSTENLOS');

define('ACCOUNT_FOOTER_SHOP','Wenn Sie unzufrieden mit dem bei FiberStore Co.Ltd gekauften Produkt sind, können Sie das Produkt in seiner Originalbedingung innerhalb sieben Tagen für eine Erstattung zurückgeben. Wir werden auch für die Lieferung der Rücksendung zahlen!');

define('ACCOUNT_FOOTER_DELIVER','FiberStore liefert eine lebenslange Garantie als ein standardmäßiges Merkmal für alle Hauptproduktlinien, um eine sorgefreie Operation zu bieten und die Reparaturkosten außerhalb der Garantiezeit zu beseitigen.');

define('ACCOUNT_FOOTER_LEARN','Mehr erfahren?');


//ery    2016-9-1          add
/*************************content****************************/
define('FS_CART','Einkaufswagen');
define('FS_CART_CONTINUE','Einkauf fortsetzen');
define('FS_CART_PROCESSING','Verarbeitung ...');
define('FS_CART_CHECKOUT','Zur Kasse');
define('FS_CART_YOUR_ITEM','Ihre Artikel');
define('FS_CART_PRICE','Einzelpreis');
define('FS_CART_QTY','Menge');
define('FS_CART_WEIGHT','Gewicht');
define('FS_CART_TOTAL','Gesamtsumme');
define('FS_CART_MOQ','MOQ (Das MOQ (Mindestbestellmenge ) dieses Kabeles ist 1 km. Bitte erhöhen die Gesamtlänge dann wieder überprüfen. Jede mögliche Frage, kontaktieren Sie uns unter Sales@fs.com.');
define('FS_CART_SHIPPING_HTML1','Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the same day.<br/>
                                 There may be some difference between the estimated time and the actual time.');
define('FS_CART_SHIPPING_HTML2','Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.<br/>
                                 There may be some difference between the estimated time and the actual time.');
define('FS_CART_SHIPPING_HTML','Es kann eine gewisse Differenz zwischen der geschätzten Zeit und der aktuellen Zeit.');
define('FS_CART_EMPTY','Ihr Einkaufswagen ist leer !');
define('FS_BASE_ON','basierend auf ');
define('FS_REVIEWS','Bewertungen');
define('FS_CART_BUSINESS','Betriebskonto');
define('FS_CART_SAVE','Gesamtersparnis:');
define('FS_CART_ALL','Alles');
define('FS_CART_DELETE','Löschen');
define('FS_CART_HELP','Lassen uns Ihnen zu helfen,');
define('FS_CART_CHAT','chatten mit uns jetzt!');
define('FS_CART_CART_TOTAL','Summe');
define('FS_CART_ITEM','');
define('FS_CART_ITEMS','');
define('FS_CART_ESTIMATED','Geschätzte Versandkosten');
define('FS_CART_AMOUNT','Gesamtsumme:');
/************************JS**************************/
define('FS_CART_JS_DELETE','Das Produkt Löschen?');
define('FS_CART_JS_YES','ja');
define('FS_CART_JS_NO','nein');
define('FS_CART_JS_SORRY','Sorry, try again please !');
define('FS_CART_ENTER','Please enter a number here !');
/****************************tpl_account_right_default.php********************************/
define('FS_CART_CONFIDENCE','Sicher einkaufen');
define('FS_CART_SECURE','Einkaufen bei FS.COM ist sicher Und Sicherheit.Garantie!<br />Sie werden nichts bezahlen, wenn unberechtigte Gebühren von Ihrer Kreditkarte als Folge der Einkauf bei FS.COM gemacht werden.');
define('FS_CART_FREE','Kostenloser Versand und kostenlose Retouren');
define('FS_CART_DELIVER','Sorgen Bedienung nach dem Prinzip und die Kosten, die mit aus Garantie-Reparaturen im Zusammenhang beseitigen, bietet FS.COM eine Garantie als Standard-Feature in allen wichtigen Produktlinien .');
define('FS_CART_BBB','FS.COM wird von BBB beglaubigt');
define('FS_CART_QUALITY','Qualität und Standards sind die Grundlage für FS.COM. Unser Ziel ist es, die besten Service und Produkte von höchster Qualität für Kunden zu bieten seit dem Tag der Gründung.');
define('FS_CART_SAFE','Garantie für sicheres Einkaufen');
define('FS_CART_SSL','Alle Informationen werden verschlüsselt und übertragen, ohne Risiko mit einem Secure Sockets Layer (SSL) Protokoll.');
//add ery 2017.4.17
define('FS_SAVE','Speichern');
define('FS_SAVE_MESSAGE','Diesen Wagen für einen späteren Zugang speichern');
define('FS_SHOPPING_SHARE','Teilen');
define('FS_SHARE_MESSAGE','Diesen Wagen mit einem Freund teilen');
define('FS_OR','oder ');
define('FS_PRINT','Drucken');
define('FS_PRINT_MESSAGE','Diesen Wagen für eine Referenz drucken');
define('FS_THIS','das mit einem freund');
define('FIBERSTORE_DASHBOARD_HISTORY',' Zuletzt angesehen');
define('FS_CART_ADD_TO_CART','Hinzufügen');
//2017.5.30		ery		add
define('FS_CART_HOW','Wie schätzt Versand?');
define('FS_TAXES',' (Ohne Versandkosten und Steuern)');
define('FS_CART_YOUR','Ihre Versandschätzung basiert auf der Versandoption mit niedrigstem Preis, die Ihnen zur Verfügung steht. Sie können auch weitere Versandoptionen & Geschwindigkeiten an der Kasse auswählen.');
define('FS_CART_YOU','Sie können weitere Versandoptionen & Geschwindigkeiten an der Kasse auswählen.');
//2017.8.29  ery   add
define('FS_SHOP_CART_SAVE','Den Artikel speichern');
define('FS_SHOP_CART_MOVE','In den Warenkorb hinzufügen');
define('FS_SHOP_CART_WAS_SAVED',' hat gespeichert.');
define('FS_SHOP_CART_WAS_MOVED',' hat in Ihren Warenkorb hinzugefügt.');
define('FS_SHOP_CART_ITEM','Artikel');
define('FS_SHOP_CART_ITEMS','Artikel');

//2018 //1.25.Ternence
define('FS_SHOP_CART_ALERT_JS_4','Gespeicherte Warenkörbe');
define('FS_SHOP_CART_ALERT_JS_5','Warenkorb speichern');
define('FS_SHOP_CART_ALERT_JS_6','Gespeicherter Warenkorb kann problemlos auf allen Geräten gemeinsam geteilt werden und verbleiben auf der Website, bis Sie den Wagen entfernen. Artikel werden nur entfernt, wenn sie nicht mehr verfügbar sind.');
define('FS_SHOP_CART_ALERT_JS_7','Name Ihres geschpeicherten Warenkorbs:');
define('FS_SHOP_CART_ALERT_JS_8','Stornieren');
define('FS_SHOP_CART_ALERT_JS_9','Ihr Einkaufswagen hat gespeichert');
define('FS_SHOP_CART_ALERT_JS_10','wurde zu Ihrem gespeicherten Einkaufswagen hinzugefügt.');
define('FS_SHOP_CART_ALERT_JS_11','Zurück zum Warenkorb');
define('FS_SHOP_CART_ALERT_JS_12','Warenkorb teilen');
define('CART_TO_NAME','Namen');
define('CART_TO_EMAIL','E-Mail-Adresse');
define('FS_SHOP_CART_ALERT_JS_16','Senden Sie mir eine Kopie dieser E-Mail.');
define('FS_SHOP_CART_ALERT_JS_17','Stornieren');
define('FS_SHOP_CART_ALERT_JS_18','Die E-Mail wurde erfolgreich versandt');
define('FS_SHOP_CART_ALERT_JS_19','Wir haben diese E-Mail in Ihrem Namen erfolgreich gesendet. Wenn Sie diese Liste an einen neuen Empfänger senden möchten, klicken Sie bitte auf');
define('FS_SHOP_CART_ALERT_JS_20','wieder teilen');
//Items
define('FS_SHOP_CART_ALERT_JS_21','Alle gespeicherte Artikel');
define('FS_SHOP_CART_ALERT_JS_22','Den Artikel speichern');
define('FS_SHOP_CART_ALERT_JS_23','Ihr Einkaufswagen hat keine Artikel.');
define('FS_SHOP_CART_ALERT_JS_24','Gehen zu ');
define('FS_SHOP_CART_ALERT_JS_25','Gespeichertem Einkaufswagen');
define('FS_SHOP_CART_ALERT_JS_26','Homepage');
define('FS_SHOP_CART_ALERT_JS_27','Nachdem Sie Artikel zum Einkaufswagen hinzugefügt haben, klicken Sie auf „Einkaufswagen speichern“, um die Artikel zu speichern.');
define('FS_SHOP_CART_ALERT_JS_28','Gespeicherte Einkaufswagen bleiben auf der Webseite für die weitere Verwendung, bis Sie sie löschen. Sie können viele gespeicherte Einkaufswagen nach Ihrer Anforderung erstellen, und Sie können gespeicherte Einkaufswagen für die Artikel wieder bestellen.');
define('FS_SHOP_CART_ALERT_JS_29','Mehr');
//details
define('FS_SHOP_CART_ALERT_JS_31','Einkaufswagen auswählen:');
define('FS_SHOP_CART_ALERT_JS_32','Gespeicherte Einkaufswagen');
define('FS_SHOP_CART_ALERT_JS_33','Gespeicherte Einkaufswagen stornieren');
define('FS_SHOP_CART_ALERT_JS_34','Stornieren Sie den ');
define('FS_SHOP_CART_ALERT_JS_35','gespeicherten Einkaufswagen ');
define('FS_SHOP_CART_ALERT_JS_36','Alle in den Wagen verschieben');
define('FS_SHOP_CART_ALERT_JS_37','Stornieren');
define('FS_SHOP_CART_ALERT_JS_38','Gespeicherter Einkaufswagen kann problemlos auf allen Geräten gemeinsam geteilt werden und verbleiben auf der Website, bis Sie den Wagen entfernen. Artikel werden nur entfernt, wenn sie nicht mehr verfügbar sind.');
define('FS_SHOP_CART_ALERT_JS_39','Name Ihres gespeicherten Einkaufswagens:');
//shopping_cart
define('FS_SHOP_CART_ALERT_JS_40','Ihr Einkaufswagen wurde gesendet!');
define('FS_SHOP_CART_ALERT_JS_41',"Wir haben Ihren Warenkorb per E-Mail an den von Ihnen angegebenen Empfänger gesandt.");
define('FS_SHOP_CART_ALERT_JS_42','Zurückgehen');
define('FS_SHOP_CART_ALERT_JS_45','Ungültige E-Mail, bitte überprüfen Sie Ihre E-Mail-Adresse und versuchen es erneut.');
define('FS_SHOP_CART_ALERT_JS_46',"Der Name des Einkaufswagens darf keine Sonderzeichen enthalten (# & ?).");
define('FS_SHOP_CART_ALERT_JS_47','Geben Sie den Namen Ihres Einkaufswagens ein.');
define('FS_SHOP_CART_ALERT_JS_48','Ungültiger Name. Bitte geben Sie den Namen Ihres Einkaufswagens erneut ein.');
define('FS_SHOP_CART_ALERT_JS_49','Wiederholter Name, bitte versuchen Sie es erneut.');
define('FS_SHOP_CART_ALLOW','Maximal 500 Schriftzeichens');
define('FS_GO_SAVE_CART','Gehen zu gespeichertem Wagen');
define('FS_SHARE_AGAIN','Wieder Teilen');
define('FS_SHOP_CART_VAT_COST','MwSt. 19% der Produkte : ');
define('FS_SHOP_CART_VAT_COST_FR','MwSt. 20% der Produkte : ');
define('FS_SHOP_CART_TOTAL','Summe (Inkl. Steuern) : ');
define('FS_SHOP_CART_WAS_UD','Alle Artikel wurden erfolgreich zum Einkaufswagen hinzugefügt.');
define('FILENAME_SHOPPING_UNIT',' Stk. ');
define('FILENAME_SHOPPING_UNITS',' Stk. ');
define('FS_SHOP_CART_ALERT_JS_54_NEW','Die Steuer hängt von der Lieferadresse ab');
define('FS_SHOP_CART_ALERT_JS_NEW','Ihre Steuer hängt von der Lieferadresse ab, es gibt unterschiedliche Steuerrichtlinien in verschiedene Länder.');

define('FS_CART_UNIT','Stk.');
define('FS_CART_UNITS',' Stk.');
define('FS_GOOGLE_REVIEWS','basierend auf $NUMBER+ Bewertungen');

define('FS_SHOP_CART_VAT_NOTICE','Die genaue Mehrwertsteuer wird anhand der Lieferadresse an der Kasse berechnet.');
define('FS_SHOP_CART_DELIVERY_COST','(Die Versandkosten werden an der Kasse berechnet.)');
define('FS_DOUBLE_QUOTES_LEFT','„');
define('FS_DOUBLE_QUOTES_RIGHT','"');

define('FS_SHOPPING_TAX','(Shipping & Tax not included)');
define('FS_SHOPPING_CART_CHECKBOX_EMPTY_ERROR', 'Bitte wählen Sie mindestens einen Artikel aus.');
define('FS_SHOPPING_CART_SELECT_ALL', 'Alle');