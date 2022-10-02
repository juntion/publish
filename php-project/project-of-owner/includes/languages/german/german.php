<?php

  define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="http://www.zen-cart.cn" target="_blank">Zen Cart</a>');
  /*bof language for my_account*/
  define('FIBERSTORE_ORDER_HELLO','Hallo ,');
  define('FIBERSTORE_ORDER_LOGIN_AS','Logg ein');
  define('SIGN_REGISTER','Anmelden');
  define('SIGN_OUT','Abmelden');
  define('MY_ORDER','Meine Bestellungen');
  define('MY_DASHBOARD','Mein Instrumentenbrett');
  
  //******************body box menu***********************/
  define('F_BODY_HEADER_BACK','Zurück zur Startseite');
  define('F_BODY_HEADER_GS','Globaler<br>Versand');
  define('F_BODY_HEADER_ITEMS','Artikel');
  define('F_BODY_MENU_CATEG','Alle Kategorien');
  define('F_BODY_MENU_HOME','Homepage');
  define('F_BODY_MENU_PROD','Produkte');
  define('F_BODY_MENU_WHOLESALES','Großhandel');
  define('F_BODY_MENU_TUTORIAL','Anleitung');
  define('F_BODY_MENU_ABOUT','Über uns');
  define('F_BODY_MENU_SUPP','Unterstützung');
  define('F_BODY_MENU_CONTANT','Kontakt');
  define('FIBERSTORE_SHOPPING_HELP','Ihr Einkaufswagen ist leer.');
  //******************Product List************************/
  define('F_PRODUCT_IMAGES','Bilder');
  define('F_PRODUCT_STATUS','Status');
  define('F_PRODUCT_WAVELENGTH','Wellenlänge');
  define('F_PRODUCT_DISTANCE','Distanz');
  define('F_PRODUCT_DATERATE','Datenrate');
  define('F_PRODUCT_SHIPDATE','Versanddatum');
  define('F_VOLUME_PRICE','Großhandelpreis');
  define('F_VOLUME_PRICE_GET','Wenn Sie großes Auftragsvolumen brauchen, bewerben Sie sich für einen Rabattt<a href="<?php echo $href;?>" target="_blank">Betriebskonto</a> oder <a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>" target="_blank">Kontakt</a>, um begünstigte Richtlinien zu bekommen.');
  define('F_OPTION_ARRAY1','Preis von hoch bis niedrig');
  define('F_OPTION_ARRAY2','Preis von niedrig bis hoch');
  define('F_OPTION_ARRAY3','Bestsellers');
  define('F_OPTION_ARRAY4','Höchst beurteilt Produkte');
  define('F_OPTION_ARRAY5','Neue Produkte');
  
  define('F_PRODUCT_RECOMMEND','Empfohlene Produkte');
  define('F_PRODUCT_RESULTS','<div class="results_font">Entschuldigung, Wir haben <s>0</s> Ergebnis(se)gefunden!  <a href="<?php echo zen_href_link(FILENAME_DEFAULT, cPath='.(int)$current_category_id.');?>">Andere Produkte nachsehen</a>.</div>');
  define('F_PRODUCT_REVIEWS','Kommentare');
//******************LEFT_sidebar************************/

  define('MY_ACCOUNT','Mein Konto');
  define('ORDER_CENTER','Auftragszentrum');
  define('ALL_ORDER','Alle Bestellungen');
  define('PENDING_ORDER','Ausstehende Bestellungen');
  define('TRANSACTION','Geschäftsabschluss der Auftrags');
  define('CANCELED','Zurückgezogene Bestellungen');
  define('EXCHANGE','Austausch & Retouren Auftrgas');
  define('ACCOUNT_SETTING','Einrichtung der Konto');
  define('MY_ADDRESS','Meine Adresse');
  define('NEWSLETTER','Newsletter');
  define('CHANGE_PASSWORD','Ihr Passwort ändern');
  define('MY_FAVORITES','Meine Favoriten');
  define('MY_REVIEWS','Meine Kommentare');
/*******************Checkout***********************************/
  define('NAVBAR_TITLE_1','Bezahlung');
  define('F_SHIPPING_ADDRESS','Versandadresse ');
  define('F_M_BILLING_ADDRESS','Ihre Zahlungsadresse zu verwalten');
  define('F_NEW_SHIPPING_ADDRESS','Eine neue Verandadresse hinzufügen');
  define('F_SHIPPING_METHOD','Versandmethode');
  define('F_CART','Einkaufswagen');
  define('F_SUCCESS','Erfolg');
  define('F_SHIPPINGTIME_COST','<th width="500">Versandmethode
                      </th>
                    <th width="230">Geschäzte Versandzeit
                      </th>
                    <th width="118">Kosten
                      </th>');
  define('F_FEDEX_IP','FedEx IP');
  define('F_PRIORITY','Priorität');
  define('F_FREIGHT_COLLECT','Fracht vom Empfänger einzuziehen');
  define('F_WARNING','Falls Sie Ihr eigenes Expresskonto bevorzugen, bieten Sie uns bitte Ihre Kontonummer. Fiberstore wird Ihnen für die Frachtgeld nicht berechnen.');
  define('F_SHIPPING_METHOD','Versandmethode: ');
  define('F_EXPRESS_ACCOUNT','Expresskonto: ');
  define('F_NO_SHIPPING','Für das gewählte Land ist keine Lieferung verfügbar. Für genauere Informationen, bitte');
  define('F_CONTACT_US','Kontaktieren Sie uns');
  define('F_TIPS','Hinweise');
  define('F_TIPS_MSG','Bitte geben Sie Ihre Versandadresse ein, und unser System wird Ihnen alle möglichen Versandmethoden zeigen');
  define('F_WHEN_ORDER_ARRIVE','Wenn wird mein Auftrag ankommen ?');
  define('F_PROCESSING','Bearbeitungszeit und Versandzeit');
  define('F_MORE_INFORMATION','Weitere Information');
  define('F_PROCESSING_TIME','Bearbeitungszeit:');
  define('F_ALL_PRODUCTS','Alle Produkte verlangen Bearbeitungszeit bevor Lieferung. Die Bearbeitung enthält Auswählen der Produkte, Überprüfen der Qualitätssicherung und sorgfältige Verpackung für Lieferung.<br />
                <b>Durchschnittliche Bearbeitungszeit:</b>Durchschnittlich 2-5 Tage<br />
                <b>Ausnahmen:</b> Für weitere Information sollen Sie unsere Verkäufer kontaktieren.<br />
                <br />
                <span>Lieferung:</span><br />
                Die Versandzeit kommt auf die Versandmethode an:<br />
                <b>Schnelle Lieferung:</b> 1-4 Arbeitstage<br />
                <b>Standard-Versendung:</b> 2-6 Arbeitstage<br />
                <b>Super sparende Versendung:</b> 10-30 Arbeitstage <br />
                FiberStore.com wird den besten Träger auf der Grundlage von der Aufforderungen Ihres Auftrags und dem Zielpunkt der Versendung wählen. Und in besonderen Umständen werden wir Sie kontaktieren.<br />');
  define('F_PAYMENT_METHOD','Zahlungsmethode');
  define('F_WE_CURRENTLY','Zurzeit akzeptieren wir telegrafische Geldüberweisung für alle Bestellungen. Auch neheme wir Sicherheit sehr ernst, deshalb sind Ihre Detailsinformationen bei uns ganz sicher');
  define('F_CART_SUMMARY','Überblick des Einkaufswagens');
  define('F_ITTEM','Artikel');
  define('F_QTY','Menge');
  define('F_WEIGHT','Gewicht');
  define('F_PRICE','Preis');
  define('F_TOTA_AMOUNT','Gesamtsumme');
  define('F_TOTAL','Gesamtsumme:');
  define('F_SHIPPING_COST','(+)Versandkosten:');
  define('F_EXCLUDING_TAXES','Steuer ausgeschlossen?');
  define('F_PO','Ihre Auftragsnummer');
  define('FIBERSTORE_WAIT_PROCESSING','Bearbeitung');



 /************************end_checkout******************************/
  
  define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> News )');
  define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Anleitungen )');
  /*eof*/
// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
  @setlocale(LC_TIME, 'en_US.UTF-8');
  define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
  define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
  define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
  define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
 // define('FIBERSTORE_REGIST_ERROR','Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');
  define('FIBERSTORE_REGIST_ERROR','Unser System hat schon eine Rekode von dieser E-Mailadrsse - Bitte versuchen Sie, mit dieser E-Mailadrsse einzuloggen. Falls Sie diese Adresse nicht mehr benutzen werden, können Sie in Mein Konto korrigiren.');
  define('FIBERSTORE_LOGIN_ERROR','Die E-Mailadresse oder Passwort ist falsch.');
  
  /*bof language contact_us email time:2012_12_17*/
  //define('FIBERSTORE_WELCOME_MEAASGE','This email message was sent from a notification-only address that cannot accept incoming email. PLEASE DO NOT REPLY to this message. If you have any questions please contact us.');
  define('FIBERSTORE_WELCOME_MEAASGE','Diese Nachricht wurde von einer E-only-Adresse gesendet, die eingehenden Nachrichten nicht empfangen kann. Bitte antworten Sie nicht auf diese Nachricht. Wenn Sie Fragen haben, kontaktieren Sie uns bitte..');
  
  define('FIBERSTORE_REVIEW_NO','Noch keine Kommentare vorhanden.');
  define('FIBERSTORE_WELCOME_TO','Sehr geehrter Kunde,');
  define('FIBERSTORE_WELCOME_CART','Permanenter Einkaufswagen');
  //define('FIBERSTORE_WELCOME_CART','Permanent Cart');
  define('FIBERSTORE_CONTACT_ABOUT','sobre nosotros contenido de ecoptical.com');
  define('FIBERSTORE_CUSTOMER_NAME','Kundenname:');
  define('FIBERSTORE_CUSTOMER_EMAIL','Kunde E-Mail:');
  define('FIBERSTORE_CONTACT_SUBJECT','Thema');
  define('FIBERSTORE_CONTACT_CONTENTS','Inhalt:');
  define('FIBERSTORE_CONTACT_FROM','De http://www.fs.com');
  
  define('FIBERSTORE_SELECT','Bitte wählen Sie...');
  //  define('FIBERSTORE_SELECT','Please select ...');
  
  
  define('COPY_RIGHT', 'derechos de autor @ 2009-'.date('Y',time()).' Fiberstore Co., Ltd. Todos los Derechos Reservados.');
define('FOOTER', '<tr>
        <td bgcolor="#E2E2E2"></td>
        <td bgcolor="#E2E2E2" height="160" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Información</strong><br />
                <a href="http://www.fiberstore.com/contact_us.html" target="_blank" style=" color:#616265; text-decoration:none;">Contacte con nosotros</a><br />
                <a href="http://www.fiberstore.com/about_us.html" target="_blank" style=" color:#616265; text-decoration:none">Acerca de nosotros</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=why_us" target="_blank" style=" color:#616265; text-decoration:none">Por qué nosotros</a><br />
                <a href="http://www.fiberstore.com/privacy_policy.html" target="_blank" style=" color:#616265; text-decoration:none">Política de Privacidad</a><br />
                <a href="http://www.fiberstore.com/site_map.html" target="_blank" style=" color:#616265; text-decoration:none">Mapa del Sitio</a><br />
                <a href="http://www.fiberstore.com/blog/" target="_blank" style=" color:#616265; text-decoration:none">FiberStore Blog</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Servicio al Cliente</strong><br />
                <a href="http://www.fiberstore.com/index.php?main_page=get_a_quick_quote" target="_blank" style=" color:#616265; text-decoration:none">Obtener una cotización rápida</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=oem" target="_blank" style=" color:#616265; text-decoration:none">OEM</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=payment_methods" target="_blank" style=" color:#616265; text-decoration:none">Formas de Pago</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=shipping_guide" target="_blank" style=" color:#616265; text-decoration:none">Guía de envío</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=custom_OEM" target="_blank" style=" color:#616265; text-decoration:none">Solución</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=estimated_lead_time" target="_blank" style=" color:#616265; text-decoration:none">Tiempo estimado</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Mi cuenta</strong><br />
                <a href="http://www.fiberstore.com/login.html" target="_blank" style=" color:#616265; text-decoration:none">Inicie sesión o Regístrese</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=manage_orders" target="_blank" style=" color:#616265; text-decoration:none">Mis pedidos</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=manage_wishlists" target="_blank" style=" color:#616265; text-decoration:none">Mis Favoritos</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; padding:0 5px;"><strong>Ayuda rápida</strong><br />
                <a href="http://www.fiberstore.com/how_to_buy.html" target="_blank" style=" color:#616265; text-decoration:none">Cómo comprar</a><br />
                <a href="http://www.fiberstore.com/password_forgotten.html" target="_blank" style=" color:#616265; text-decoration:none">Olvidaste tu contraseña?</a><br />
                <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl(\'http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=\', \'chatbox152062\', globalWindowAttribute);" style=" color:#616265; text-decoration:none">Chat en Vivo</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=faq" target="_blank" style=" color:#616265; text-decoration:none">Preguntas más frecuentes</a></div></td>
        <td bgcolor="#E2E2E2"></td>
    </tr>');
  
  
  define('EMAIL_HEADER_INFO', '
	<table width="650" cellspacing="0" cellpadding="0" border="0" align="center" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
  		<tbody>
  		<tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:16px; border:0;">
        <tbody><tr>
          <td height="" bgcolor="#f4f4f4" colspan="4">&nbsp;</td>
        </tr>
        <tr>
        <td width="10" bgcolor="#f4f4f4" style="height:8px; line-height:8px;"></td>
         <td background="http://www.fiberstore.com/images/imagesOfEmail/hander_top.jpg" style="height:8px; line-height:8px; background-repeat:no-repeat;" colspan="2"></td>
         <td width="9" bgcolor="#f4f4f4" style="height:8px; line-height:8px;"></td>
        </tr>
        <tr>
          <td width="10" bgcolor="#f4f4f4">&nbsp;</td>
          <td style="padding-left:26px;"><a href="http://www.fiberstore.com/"><img border="0" alt="fiberstore_logo" src="http://www.fiberstore.com/images/logo.jpg"></a></td>
          <td style="color:#8d8d8f; overflow:hidden;text-align:right; padding-right:30px;border-right:1px solid #d2d2d2;"><span style="font-size:12px; ">Fiber Network Solution,&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>All in FiberStore</span></td>
          <td width="9" bgcolor="#f4f4f4" style="border-left:1px solid #e9e9e9;">&nbsp;</td>
        </tr>
       
    </tbody></table></td>
  </tr>
  	<tr>
   <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
    <td width="8" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
    <td width="10" background="http://www.fiberstore.com/images/imagesOfEmail/top_left.jpg" rowspan="2">&nbsp;</td>
    <td height="4" style="line-height:4px;"></td>
    <td width="10" background="http://www.fiberstore.com/images/imagesOfEmail/top_right.jpg" rowspan="2">&nbsp;</td>
    <td width="9" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" bgcolor="#a10000" style=" padding:0 10px;font-size:11px; text-align:center; font-weight:bold;"><a style="color:#fff; padding:0 5px; text-decoration:none;" target="_blank" href="http://www.fiberstore.com/">Home</a><span style="color:#ffffff;">|</span><a style="color:#fff;  padding:0 5px; text-decoration:none;" target="_blank" href="http://www.fiberstore.com/products.html">Products</a><span style="color:#ffffff;">|</span>
            <a href="http://www.fiberstore.com/tutorial.html" target="_blank" style="color:#fff; padding:0 5px; text-decoration:none;">Tutorial</a>
          <span style="color:#ffffff;">|</span><a href="http://www.fiberstore.com/about_us.html" target="_blank" style="color:#fff; padding:0 5px; text-decoration:none;">About Us</a><span style="color:#ffffff;">|</span><a style="color:#fff; padding:0 5px; text-decoration:none;" target="_blank" href="http://www.fiberstore.com/support.html">Support</a><span style="color:#ffffff;">|</span><a style="color:#fff; padding:0 5px; text-decoration:none;" target="_blank" href="http://www.fiberstore.com/contact_us.html">Contact Us</a></td>
    </tr>
</tbody></table>
</td>
  </tr>
  		
  		
  		
  		');

  
  
  
  define('EMAIL_FOOTER_INFO', '<tr>
			       <td><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
			  <tbody><tr>
			    <td width="10" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
			    <td style="border-top:1px solid #e2e2e2; border-right:1px solid #dedede; font-size:11px; ">
			    <div style="text-align:center; padding-top:10px;padding-bottom:10px; margin:0;"><a style="color:#232323;text-decoration:none;" target="_blank" href="http://www.fiberstore.com/contact_us.html">Contact Us</a>  |  <a href="http://www.fiberstore.com/about_us.html" target="_blank" style="color:#232323;text-decoration:none;">About Us</a>  |  <a href="http://www.fiberstore.com/products.html" target="_blank" style="color:#232323;text-decoration:none;">Products</a>  |  <a style="color:#232323; text-decoration:none;" target="_blank" href="http://www.fiberstore.com/support.html">Support</a><br>
			    <span style="color:#999999; ">Copyright @ 2002-'.date('Y',time()).' Fiberstore Co., Ltd. Alle Rechte vorbehalten.</span>
			    </div>
			    
			    </td>
			    <td width="9" bgcolor="#f4f4f4" style="border-left:1px solid #e9e9e9;">&nbsp;</td>
			  </tr>
			  <tr>
			    <td bgcolor="#f4f4f4" background="http://www.fiberstore.com/images/imagesOfEmail/footer_bottom.jpg " style="line-height:8px; height:23px; background-repeat:no-repeat;"></td>
			    <td width="9" bgcolor="#f4f4f4">&nbsp;</td>
			    </tr>
			
			</tbody></table>
			</td>
  		</tr>
  		</tbody></table>
  		');

 define('ACCOUNT_FOOTER_TITLE','Einkaufen mit Zuversicht');
 
 define('ACCOUNT_FOOTER_SHOPPING','EINKAUFEN BEI FS.COM ');
 
 define('ACCOUNT_FOOTER_SECURE','IST ZUVERLÄSSIG UND GESICHERT.');
 
 define('TEXT_LOGIN_GUARANTEED','GARANTIERT!');
 
 define('ACCOUNT_FOOTER_PAY','Sie brauchen nichts zu zahlen,wenn Sie unautorisierte Rechnung wegen des Einkaufens bei fs.com in Kreditkarte erhalten.');
 
 define('ACCOUNT_FOOTER_SAFE','Zuverlässiges Einkaufen garantiert');
 
 define('ACCOUNT_FOOTER_INFORMATION','Alle Informationen sind durch das Secure Sockets Layer (SSL) Protokoll ohne Risiko verschlüsselt und gesendet.');
 
 define('ACCOUNT_FOOTER_HOW','Wie schützen wir Ihre privaten Daten?');
 
 define('ACCOUNT_FOOTER_FREE','Lieferung und Retouren sind kostenlos');
 
 define('ACCOUNT_FOOTER_SHOP','Wenn Sie unzufrieden mit der bei FiberStore Co.Ltd gekauften Erwerbung, können Sie die Erwerbung in ihrer Originalbedingung innerhalb sieben Tagen für eine Erstattung zurückgeben. Wir werden sogar für die Lieferung der Rücksendung zahlen!');
 
 define('ACCOUNT_FOOTER_DELIVER','FiberStore liefert eine lebenslängliche Garantie als ein standardmäßiges Merkmal für alle Hauptproduktlinien, um eine sorgefreie Operation zu bieten und die Reparaturkosten außerhalb der Garantiezeit zu beseitigen.');
 
 define('ACCOUNT_FOOTER_LEARN','Erfahren Sie mehr...');
 
 define('TEXT_FIBERSTORE_REGIST_RESPECTS','Fiberstore.com respektiert Ihre Privatsphäre. Wir werden niemandem Ihre private Informationen nicht mieten oder verkaufen.');

define('TEXT_FIBERSTORE_REGIST_PRIVACY','Die Datenschutzrichtlinie.');
  
////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
  if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false) {
      if ($reverse) {
        return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
      } else {
        return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
      }
    }
  }

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
  define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
  define('HTML_PARAMS','dir="ltr" lang="en"');

// charset for web pages and emails
  define('CHARSET', 'UTF-8');

// footer text in includes/footer.php
  define('FOOTER_TEXT_REQUESTS_SINCE', 'Anforderungen seit');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
  define('TEXT_GV_NAME','Geschenkgutschein');
  define('TEXT_GV_NAMES','Geschenkgutschein');

// used for redeem code, redemption code, or redemption id
  define('TEXT_GV_REDEEM','Bestätigungskode');

// used for redeem code sidebox
  define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
  define('BOX_GV_REDEEM_INFO', 'Bestätigungskode: ');

// text for gender
  define('MALE', 'Herr.');
  define('FEMALE', 'Frau.');
  define('MALE_ADDRESS', 'Herr.');
  define('FEMALE_ADDRESS', 'Frau.');

// text for date of birth example
  define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

//text for sidebox heading links
  define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[mehr]');

// categories box text in sideboxes/categories.php
  define('BOX_HEADING_CATEGORIES', 'Katagorien');

// manufacturers box text in sideboxes/manufacturers.php
  define('BOX_HEADING_MANUFACTURERS', 'Hersteller');

// whats_new box text in sideboxes/whats_new.php
  define('BOX_HEADING_WHATS_NEW', 'Neue Produkte');
  define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Neue Produkte ...');

  define('BOX_HEADING_FEATURED_PRODUCTS', 'Featured');
  define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Hauptprodukte ...');
  define('TEXT_NO_FEATURED_PRODUCTS', 'Mehr Hauptprodukte werden bald im Angebot sein. Bitte kommen Sie später zurück.');

  define('TEXT_NO_ALL_PRODUCTS', 'Mehr Produkte werden bald hinzugefügt. Bitte kehren Sie zurück und mal nachprüfen.');
  define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Alle Produkte ...');

// quick_find box text in sideboxes/quick_find.php
  define('BOX_HEADING_SEARCH', 'Suchen');
  define('BOX_SEARCH_ADVANCED_SEARCH', 'Advanced Suchen');
   define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'Geben Sie Ihre zu suchenden Wörter hier ein...');
// specials box text in sideboxes/specials.php
  define('BOX_HEADING_SPECIALS', 'Sonderangebote');
  define('CATEGORIES_BOX_HEADING_SPECIALS','Sonderangebote...');

// reviews box text in sideboxes/reviews.php
  define('BOX_HEADING_REVIEWS', 'Kommentare');
  define('BOX_REVIEWS_WRITE_REVIEW', 'Einen Kritik über dieses Produkt zu schreiben.');
  define('BOX_REVIEWS_NO_REVIEWS', 'Zurzeit gibt es noch keine ProduktKommentare.');
  define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s von 5 Sterne!');

// shopping_cart box text in sideboxes/shopping_cart.php
  define('BOX_HEADING_SHOPPING_CART', 'Einkaufswagen');
  define('BOX_SHOPPING_CART_EMPTY', 'Ihr Einkaufswagen ist leer.');
  define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
  define('BOX_HEADING_CUSTOMER_ORDERS', 'Schnell wieder zu bestellen');

// best_sellers box text in sideboxes/best_sellers.php
  define('BOX_HEADING_BESTSELLERS', 'Bestsellers');
  define('BOX_HEADING_BESTSELLERS_IN', 'Bestsellers in<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
  define('BOX_HEADING_NOTIFICATIONS', 'Benachrichtigungen');
  define('BOX_NOTIFICATIONS_NOTIFY', 'Informieren mich über die Updates zu <strong>%s</strong>');
  define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Informieren mich über die Updates zu <strong>%s</strong>');

// manufacturer box text
  define('BOX_HEADING_MANUFACTURER_INFO', 'Informationen der Herstller');
  define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
  define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Andere Produkte');

// languages box text in sideboxes/languages.php
  define('BOX_HEADING_LANGUAGES', 'Sprachen');

// currencies box text in sideboxes/currencies.php
  define('BOX_HEADING_CURRENCIES', 'Währungen');

// information box text in sideboxes/information.php
  define('BOX_HEADING_INFORMATION', 'Information');
  define('BOX_INFORMATION_PRIVACY', 'Mitteilung der Datenschutzes');
  define('BOX_INFORMATION_CONDITIONS', 'Einsatzbedingungen');
  define('BOX_INFORMATION_SHIPPING', 'Lieferung &amp; Retouren');
  define('BOX_INFORMATION_CONTACT', 'Kontakt');
  define('BOX_BBINDEX', 'Forum');
  define('BOX_INFORMATION_UNSUBSCRIBE', 'Newsletter abbestellen');

  define('BOX_INFORMATION_SITE_MAP', 'Webseitekarte');

// information box text in sideboxes/more_information.php - were TUTORIAL_
  define('BOX_HEADING_MORE_INFORMATION', 'Weitere Informationen');
  define('BOX_INFORMATION_PAGE_2', 'Seite 2');
  define('BOX_INFORMATION_PAGE_3', 'Seite 3');
  define('BOX_INFORMATION_PAGE_4', 'Seite 4');

// tell a friend box text in sideboxes/tell_a_friend.php
  define('BOX_HEADING_TELL_A_FRIEND', 'Einen Freund zu informieren');
  define('BOX_TELL_A_FRIEND_TEXT', 'Ihre Bekannte über dieses Produkt zu informieren.');

// wishlist box text in includes/boxes/wishlist.php
  define('BOX_HEADING_CUSTOMER_WISHLIST', 'Meine Wunschliste');
  define('BOX_WISHLIST_EMPTY', 'Sie haben noch keine Artikel auf Ihrer Wunschliste');
  define('IMAGE_BUTTON_ADD_WISHLIST', 'Zur Wunschliste hinzuzufügen');
  define('TEXT_WISHLIST_COUNT', 'Zurzeit sind Artikel %s auf Ihrer Wunschliste.');
  define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (of <strong>%d</strong> Artikel auf Ihrer Wunschliste)');

//New billing address text
  define('SET_AS_PRIMARY' , 'Als bevorzugte Adresse einzurichten.');
  define('NEW_ADDRESS_TITLE', 'Zahlungsadresse');

// javascript messages
  define('JS_ERROR', 'Es gibt Fehler während der Bearbeitung ihrer Form.\n\nBitte bessern Sie aus wie unten aufgelistet:\n\n');

  define('JS_REVIEW_TEXT', '* Bitte schreiben Sie die Kritik ein bisschen mehr. Eine Kritik soll mindestens ' . REVIEW_TEXT_MIN_LENGTH . ' Schriftzeichens.');
  define('JS_REVIEW_RATING', '* Bitte nehmen Sie für diesen Artikel eine Einstufung vor.');

  define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte wählen Sie eine Zahlungsmethode für Ihren Auftrag.');

  define('JS_ERROR_SUBMITTED', 'Diese Form ist schon eingereicht worden. Bitte drücken Sie Ok und warten sie auf die Beendung diser Bearbeitung.');

  define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Bitte wählen Sie eine Zahlungsmethode für Ihren Auftrag.');
  define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Bitte bestätigen Sie die mit diesem Auftrag verbundenen Bedingungen und Konditionen durch eien Klicken auf den Kasten darunter.');
  define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Bitte bestätigen Sie die Datenschuzterklärung durch einen Klicken auf den Kasten darunter.');

  define('CATEGORY_COMPANY', 'Details der Firma');
  define('CATEGORY_PERSONAL', 'Ihre persönliche Details');
  define('CATEGORY_ADDRESS', 'Ihre Adresse');
  define('CATEGORY_CONTACT', 'Ihre Kontaktinformation');
  define('CATEGORY_OPTIONS', 'Auwähle');
  define('CATEGORY_PASSWORD', 'Ihr Passwort');
  define('CATEGORY_LOGIN', 'Eingeloggt');
  define('PULL_DOWN_DEFAULT', 'Bitte wählen Sie Ihr Vaterland');
  define('PLEASE_SELECT', 'Bitte wählen Sie ...');
  define('TYPE_BELOW', 'Geben Sie ihre Auswahl darunter ein...');

  define('ENTRY_COMPANY', 'Name der Firma:');
  define('ENTRY_COMPANY_ERROR', 'Bitte geben Sie einen Name einer Firma.');
  define('ENTRY_COMPANY_TEXT', '');
  define('ENTRY_GENDER', 'Anrede');
  define('ENTRY_GENDER_ERROR', 'Bitte wählen Sie eine Anrede.');
  define('ENTRY_GENDER_TEXT', '*');
  define('ENTRY_FIRST_NAME', 'Vorname:');
  define('ENTRY_FIRST_NAME_ERROR', 'Ist Ihr Vorname richtig? Unser System verlängt ein Minimum von ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Schriftzeichens. Bitte geben Sie noch einmal ein.');
  define('ENTRY_FIRST_NAME_TEXT', '*');
  define('ENTRY_LAST_NAME', 'Nachname:');
  define('ENTRY_LAST_NAME_ERROR', 'Ist Ihr Nachname richtig? Unser System verlängt ein Minimum von ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Schriftzeichens. Bitte geben Sie noch einmal ein.');
  define('ENTRY_LAST_NAME_TEXT', '*');
  define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');
  define('ENTRY_DATE_OF_BIRTH_ERROR', 'Ist Ihr geburtsdatum richtig? Unser System verlängt das Datum in dieser Form: MM/DD/YYYY (z.B. 05/21/1970)');
  define('ENTRY_DATE_OF_BIRTH_TEXT', '* (z.B. 05/21/1970)');
  define('ENTRY_EMAIL_ADDRESS', 'Emailadresse:');
  define('ENTRY_EMAIL_ADDRESS_ERROR', 'Ist Ihre E-Mailadrsse richtig? Sie soll mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Schriftzeichen enthalten. Bitte geben Sie noch einmal ein.');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Entschuldigung, das System kann Ihre E-Mailadrsse nicht verstehen, bitte geben Sie noch ein mal ein.');
 // define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este E-Mail ya existe en nuestra base de datos - por favor, entre con otro E-Mail o cree otra cuenta con una dirección de E-Mail diferen.');
  define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Unser System hat schon eine Rekode von dieser E-Mailadrsse - Bitte versuchen Sie, mit dieser E-Mailadrsse einzuloggen. Falls Sie diese Adresse nicht mehr benutzen werden, können Sie in Mein Konto korrigiren.');
  
  define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
  define('ENTRY_NICK', 'Kurzname im Forum:');
  define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
  define('ENTRY_NICK_DUPLICATE_ERROR', 'Dieser Kurzname ist schon benutzt. Bitte versuchen Sie mit einem anderen Kurzname.');
  define('ENTRY_NICK_LENGTH_ERROR', 'Bitte versuchen Sie noch einmal. Ihr Kurzname soll mindestens ' . ENTRY_NICK_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_STREET_ADDRESS', 'Straßeadresse:');
  define('ENTRY_STREET_ADDRESS_ERROR', 'Ihre Straßeadresse soll mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_STREET_ADDRESS_TEXT', '*');
  define('ENTRY_SUBURB', 'Adresselinie 2:');
  define('ENTRY_SUBURB_ERROR', '');
  define('ENTRY_SUBURB_TEXT', '');
  define('ENTRY_POST_CODE', 'Postleitzahl:');
  define('ENTRY_POST_CODE_ERROR', 'Ihre Postleitzahl soll mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_POST_CODE_TEXT', '*');
  define('ENTRY_CITY', 'Stadt:');
  define('ENTRY_CUSTOMERS_REFERRAL', 'Empfehlungskode:');

  define('ENTRY_CITY_ERROR', 'Ihre Stadt soll mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_CITY_TEXT', '*');
  define('ENTRY_STATE', 'Bundesland/Provinz:');
  define('ENTRY_STATE_ERROR', 'Ihr Bundesland soll mindestens ' . ENTRY_STATE_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_STATE_ERROR_SELECT', 'Bitte wählen Sie ein Bundesland von dem Pull-down Menü.');
  define('ENTRY_STATE_TEXT', '*');
  define('JS_STATE_SELECT', '-- Bitte wählen Sie --');
  define('ENTRY_COUNTRY', 'Land:');
  define('ENTRY_COUNTRY_ERROR', 'Sie sollen ein land von dem Pull-down Menü auswählen.');
  define('ENTRY_COUNTRY_TEXT', '*');
  define('ENTRY_TELEPHONE_NUMBER', 'Telefon:');
  define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Ihre Telefonnummer soll mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Schriftzeichen enthalten.');
  define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
  define('ENTRY_FAX_NUMBER', 'Fax Nummer:');
  define('ENTRY_FAX_NUMBER_ERROR', '');
  define('ENTRY_FAX_NUMBER_TEXT', '');
  define('ENTRY_NEWSLETTER', 'Unser Newsletter zu bestellen.');
  define('ENTRY_NEWSLETTER_TEXT', '');
  define('ENTRY_NEWSLETTER_YES', 'Bestellen');
  define('ENTRY_NEWSLETTER_NO', 'Abbestellen');
  define('ENTRY_NEWSLETTER_ERROR', '');
  define('ENTRY_PASSWORD', 'Passwort:');
  define('ENTRY_PASSWORD_ERROR', 'Ihr Passwort soll mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Die Passwortbestätigung soll mit Ihrem Passwort übereinstimmen.');
  define('ENTRY_PASSWORD_TEXT', '* (mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Schriftzeichen)');
  define('ENTRY_PASSWORD_CONFIRMATION', 'Passwortbestätigung:');
  define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT', 'Gegenwärtiges Passwort:');
  define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT_ERROR', 'Ihr Passwort soll mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Schriftzeichens enthalten.');
  define('ENTRY_PASSWORD_NEW', 'Neues Passwort:');
  define('ENTRY_PASSWORD_NEW_TEXT', '*');
  define('ENTRY_PASSWORD_NEW_ERROR', 'Ihr neues Passwort soll mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . 'Schriftzeichens enthalten.');
  define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Die Passwortbestätigung soll mit Ihrem Passwort übereinstimmen.');
  define('PASSWORD_HIDDEN', '--VERDECKT--');

  define('FORM_REQUIRED_INFORMATION', '* Erforderliche Informationen');
  define('ENTRY_REQUIRED_SYMBOL', '*');

  // constants for use in zen_prev_next_display function
  define('TEXT_RESULT_PAGE', '');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Gesamtsumme: <strong>%d</strong> Artikel &nbsp;&nbsp; <strong>%d</strong> / %d');
    
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Produkten)');
  define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Bestellungen)');
  define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Kommentaren)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> neuen Produkten)');
  define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Sonderangeboten)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Hauptprodukten)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Produkten)');
  define('TEXT_TOTAL_NUMBER_OF_REVIEWS','(<strong>%d</strong>)');
  
  
  define('PREVNEXT_TITLE_FIRST_PAGE', 'Erste Seite');
  define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Vorige Seite');
  define('PREVNEXT_TITLE_NEXT_PAGE', 'Nächste Seite');
  define('PREVNEXT_TITLE_LAST_PAGE', 'Letzte Seite');
  define('PREVNEXT_TITLE_PAGE_NO', 'Seite %d');
  define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Vorige Setzung von %d Seiten');
  define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Nächste Setzung von %d Seiten');
  define('PREVNEXT_BUTTON_FIRST', 'Erst');
  define('PREVNEXT_BUTTON_PREV', 'Vorig');
  define('PREVNEXT_BUTTON_NEXT', 'Nächst');
  define('PREVNEXT_BUTTON_LAST', 'Letzt');

  define('TEXT_BASE_PRICE','Beginnen mit: ');

  define('TEXT_CLICK_TO_ENLARGE', 'Bild vergrößen');

  define('TEXT_SORT_PRODUCTS', 'Produkte sortieren ');
  define('TEXT_DESCENDINGLY', 'Absteigend');
  define('TEXT_ASCENDINGLY', 'Aufsteigend');
  define('TEXT_BY', ' durch ');

  define('TEXT_REVIEW_BY', 'durch %s');
  define('TEXT_REVIEW_WORD_COUNT', '%s Worte');
  define('TEXT_REVIEW_RATING', 'Einstufung: %s [%s]');
  define('TEXT_REVIEW_DATE_ADDED', 'Datum hinzuzufügen: %s');
  define('TEXT_NO_REVIEWS', 'Es gibt zurzeit noch keine ProduktKommentare.');

  define('TEXT_NO_NEW_PRODUCTS', 'Mehr neue Produkte werden bald hinzugefügt. Bitte kehren Sie zurück und Schauen Sie mal an.');

  define('TEXT_UNKNOWN_TAX_RATE', 'Unsatzsteuer');

  define('TEXT_REQUIRED', '<span class="errorText">Erforderlich</span>');

  define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Achtung: Installationsverzeichnis steht in: %s. Bitte beseitigen Sie dieses Verzeichnis aus Sicherheitsgründen.');
  define('WARNING_CONFIG_FILE_WRITEABLE', 'Achtung: Ich kann die Konfigurationsdatei schreiben: %s. Das ist ein potenzielles Sicherheitsrisiko - Bitte setzen Sie die richtige Anwenderzulassung in diser Datei(Schreibgeschützt, CHMOD 644 oder 444 sind tzpisch). Sie können das Bedienungsfeld/den Dateimanager Ihres Webhostes benutzen, um die Zulassung erfolgreich zu ändern. Kontaktieren Sie Ihren Webhost für Hilfe. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">Schauen Sie mal FAQ an</a>');
  define('ERROR_FILE_NOT_REMOVEABLE', 'Fehler: Sie können die genau angegebene Datei nicht beseitigen. Sie werden vielleicht FTP benutzen müssen wegen der Konfigurationseinschränkung von der Serverlizenz, um diese Datei zu beseitigen.');
  define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Achtung: Das Sessionverzeichnis existiert nicht: ' . zen_session_save_path() . '. Sessions werden erst funktionieren, wenn dieses Verzeichnis errichtet ist.');
  define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Achtung: Ich kann das Sessionverzeichnis nicht schreiben: ' . zen_session_save_path() . '.Sessions werden erst funktionieren, wenn die richtigen Anwenderzulassungen gesetzt sind.');
  define('WARNING_SESSION_AUTO_START', 'Achtung: session.auto_start ist ermöglcht - Bitte blockieren Sie PHP feature in php.ini, und  schalten Sie den Web-Server wieder an.');
  define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Achtung: Das herunterladbare Produktverzeichnis existiert nicht: ' . DIR_FS_DOWNLOAD . '. Die herunterladbaren Produkte werden erst funktionieren, wenn dieses Verzeichnis gültig ist.');
  define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Achtung: Das SQL Cache-Verzeichnis existiert nicht: ' . DIR_FS_SQL_CACHE . '. SQL Cache wird erst funktionieren, wenn dieses Verzeichnis errichtet ist.');
  define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Achtung: Ich kann das SQL Cache-Verzeichnis nicht schreiben: ' . DIR_FS_SQL_CACHE . '. SQL Cache wird erst funktionieren, wenn die richtigen Anwenderzulassungen gesetzt sind.');
  define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Es scheint, dass Ihre Datenbank Flecken benötigt, um zu einer höheren Ebene zu reichen. Durch Admin->Tools->Server Information überprüfen Sie die Ebene des Patchs.');
  define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'Achtung: Die Sprachendatei sind nicht zu finden: ');

  define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Das für die Kreditkarte eingegebene Ablaufdatum ist ungültig. Bitte prüfen Sie das Datum und geben Sie noch einmal ein.');
  define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Die eingegebne Nummer der Kreditkarte ist ungültig. Bitte prüfen Sie die Nummer und geben Sie noch einmal ein.');
  define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Die mit %s begonnene Nummer Ihrer Kreditkarte war nicht richtig eingegeben, oder wir akzeptieren die Karte von dieser Sorte nicht. Bitte versuchen Sie noch einmal oder benutzen Sie eine andere Karte..');

  define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Rabatt-Gutscheinen');
  define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
  define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Ausgeglichenheit ');
  define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Konto');
  define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
  define('ERROR_REDEEMED_AMOUNT', 'Gratulation! Sie haben eingelöst');
  define('ERROR_NO_REDEEM_CODE', 'Sie haben keine ' . TEXT_GV_REDEEM . 'eingegeben.');
  define('ERROR_NO_INVALID_REDEEM_GV', 'Ungültig ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
  define('TABLE_HEADING_CREDIT', 'verfügbare Kredite');
  define('GV_HAS_VOUCHERA', 'Sie haben Fonds in Ihrem ' . TEXT_GV_NAME . ' Konto. Wenn Sie <br /> möchten,
                           Sie können diese Fonds durch<a class="pageResults" href=" senden');

  define('GV_HAS_VOUCHERB', '"><strong>E-Mail</strong></a> zu jemandem');
  define('ENTRY_AMOUNT_CHECK_ERROR', 'Die Fonds sind nicht genug, wenn Sie diese Menge senden möchten.');
  define('BOX_SEND_TO_FRIEND', 'Senden ' . TEXT_GV_NAME . ' ');

  define('VOUCHER_REDEEMED',  TEXT_GV_NAME . ' Eingelöst');
  define('CART_COUPON', 'Geschenkgutschein:');
  define('CART_COUPON_INFO', 'Mehr Informationen');
  define('TEXT_SEND_OR_SPEND','Sie haben verfügbare Ausgeglichenheit in Ihrem ' . TEXT_GV_NAME . 'Konto. Sie können sie einfach ausgeben oder sie zu jemandem schicken. Um sie zu schicken, klicken Sie auf den Knopf darunter.');
  define('TEXT_BALANCE_IS', 'Ihre' . TEXT_GV_NAME . ' Ausgeglichenheit ist: ');
  define('TEXT_AVAILABLE_BALANCE', 'Ihr ' . TEXT_GV_NAME . ' Konto');

// payment method is GV/Discount
  define('PAYMENT_METHOD_GV', 'Geschenkgutschein');
  define('PAYMENT_MODULE_GV', 'GV/DC');

  define('TABLE_HEADING_CREDIT_PAYMENT', 'Kredite verfügbar');

  define('TEXT_INVALID_REDEEM_COUPON', 'Ungültiger Gutscheinkode');
  define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Sie sollen mindestens %s ausgeben, um diesen Gutschein einzulösen');
  define('TEXT_INVALID_STARTDATE_COUPON', 'Dieser Gutschein ist noch nicht verfügbar');
  define('TEXT_INVALID_FINISHDATE_COUPON', 'Dieser Gutschein ist schon abgelaufen');
  define('TEXT_INVALID_USES_COUPON', 'Dieser Gutschein kann nur benutzt werden ');
  define('TIMES', ' Zeit.');
  define('TIME', ' Zeit.');
  define('TEXT_INVALID_USES_USER_COUPON', 'Sie haben Gutscheinkode : %s benutzt für die meisten Male, die für jeden Kunden erlaubt sind.. ');
  define('REDEEMED_COUPON', 'Ein Gutschein wert ');
  define('REDEEMED_MIN_ORDER', 'Für Auftragssumme mehr als ');
  define('REDEEMED_RESTRICTIONS', ' [Produkt-Katagorie Einschränkungen gelten ]');
  define('TEXT_ERROR', 'Ein Fehler ist aufgetreten');
  define('TEXT_INVALID_COUPON_PRODUCT', 'Diese Gutscheinkode ist ungültig für jedes Produkt in Ihrem Einkaufswagen.');
  define('TEXT_VALID_COUPON', 'Gratulieren! Sie haben diesen Rabatt-Gutschein eingelöst');
  define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Die von Ihnen eingegebene Gutscheinkode ist ungültig für die von Ihnen ausgewählte Adresse.');

// more info in place of buy now
  define('MORE_INFO_TEXT','... mehr Informationen');

// IP Address
  define('TEXT_YOUR_IP_ADDRESS','Ihre IP Adresse ist: ');

//Generic Address Heading
  define('HEADING_ADDRESS_INFORMATION','Information von Adressen');

// cart contents
  define('PRODUCTS_ORDER_QTY_TEXT_IN_CART','Menge im Einkaufswagen: ');
  define('PRODUCTS_ORDER_QTY_TEXT','In den Einkaufswagen: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Erfolgreich in den Einkaufswagen gelegte Produkte ...');
// only for where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Ausgewählte Produkte erfolgreich in den Einkaufswagen gelegt...');

  define('TEXT_PRODUCT_WEIGHT_UNIT','kg');

// Shipping
  define('TEXT_SHIPPING_WEIGHT','kg');
  define('TEXT_SHIPPING_BOXES', 'Kasten');

// Discount Savings
  define('PRODUCT_PRICE_DISCOUNT_PREFIX','Sparen:&nbsp;');
  define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE','% ab');
  define('PRODUCT_PRICE_DISCOUNT_AMOUNT','&nbsp;ab');

// Sale Maker Sale Price
  define('PRODUCT_PRICE_SALE','Rabatt:&nbsp;');

//universal symbols
  define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
  define('BOX_HEADING_BANNER_BOX','Sponsoren');
  define('TEXT_BANNER_BOX','Bitte besuchen Sie unsere Sponsoren ...');

// banner box 2
  define('BOX_HEADING_BANNER_BOX2','Haben Sie schon gesehen, dass ...');
  define('TEXT_BANNER_BOX2','Zieh dir das mal rein!');

// banner_box - all
  define('BOX_HEADING_BANNER_BOX_ALL','Sponsoren');
  define('TEXT_BANNER_BOX_ALL','Bitte besuchen Sie unsere Sponsoren ...');

// boxes defines
  define('PULL_DOWN_ALL','Bitte wählen Sie');
  define('PULL_DOWN_MANUFACTURERS','- Rücksetzen -');
// shipping estimator
  define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Bitte wählen Sie');

// general Sort By
  define('TEXT_INFO_SORT_BY','Sortieren durch: ');

// close window image popups
  define('TEXT_CLOSE_WINDOW',' - Klicken Sie auf das Foto, um es zu schließen');
// close popups
  define('TEXT_CURRENT_CLOSE_WINDOW','[ Fenster schließen ]');

// iii 031104 added:  File upload error strings
  define('ERROR_FILETYPE_NOT_ALLOWED', 'Fehler:  Dateityp nicht erlaubt.');
  define('WARNING_NO_FILE_UPLOADED', 'Warnung:  Keine Datei hochgeladen.');
  define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Erfolg:  Datei erfolgreich gespeichert.');
  define('ERROR_FILE_NOT_SAVED', 'Fehler:  Datei nicht gespeichert.');
  define('ERROR_DESTINATION_NOT_WRITEABLE', 'Fehler: Zieladresse nicht schreibbar.');
  define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Fehler: Zieladresse existiert nicht.');
  define('ERROR_FILE_TOO_BIG', 'Warnung: Datei zu groß herunterzuladen!<br /> Auftrag kann plaziert werden, bitte kontaktieren Sie die Seite für Hilfe mit dem Hochladen.');
// End iii added

  define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'NOTIZ: Diese Webseite wird nach Plan für Instandhaltung geschlossen am: ');
  define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'NOTIZ: Diese Webseite ist zurzeit wegen der Insatandhaltung zum Publikum geschlossen');

  define('PRODUCTS_PRICE_IS_FREE_TEXT','Es ist kostenlos!');
  define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT','Anrufen für Preis');
  define('TEXT_CALL_FOR_PRICE','Anrufen für Preis');

  define('TEXT_INVALID_SELECTION',' Sie haben eine ungültige Selektion gewählt: ');
  define('TEXT_ERROR_OPTION_FOR',' Eine Auswahl treffen: ');
  define('TEXT_INVALID_USER_INPUT', 'Inpur vom Benutzer verlangt<br />');

// product_listing
  define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING','Minimum: ');
  define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING','Mengeneinheit: ');
  define('PRODUCTS_QUANTITY_IN_CART_LISTING','In Einkaufswagen:');
  define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING','Zusätzlich addieren:');

  define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING','Maximum:');

  define('TEXT_PRODUCTS_MIX_OFF','*Gemischt zu');
  define('TEXT_PRODUCTS_MIX_ON','*Gemischt auf');

  define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART','<br />*Sie können leider dieses Produkt nicht wählen, um die Anforderung von der Minimum der Menge zu erreichen.*<br />');
  define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART','*Gemischt Optionswert ist AUF<br />');

  define('ERROR_MAXIMUM_QTY','Die Menge in Ihrem Einkaufswagen ist wegen der Beschränkung von Ihrer erlaubten Maximummenge geändert worden. Dieses Produkt zu sehen: ');
  define('ERROR_CORRECTIONS_HEADING','Bitte korrigiren Sie das Folgende : <br />');
  define('ERROR_QUANTITY_ADJUSTED', 'Die Menge des Produktes ist geändert worden. Die von Ihnen verlangte Produktmenge ist teilweise nicht erreichbar. Die Menge vom Produkt: ');
  define('ERROR_QUANTITY_CHANGED_FROM', ', ist geändert von : ');
  define('ERROR_QUANTITY_CHANGED_TO', ' zu ');

// Downloads Controller
  define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG','NOTIZ: Das Herunterladen ist erst möglich nachdem Bestätigung der Zahlung.');
  define('TEXT_FILESIZE_BYTES', ' Bytes');
  define('TEXT_FILESIZE_MEGS', ' Megabyte');

// shopping cart errors
  define('ERROR_PRODUCT','Das Produkte: ');
  define('ERROR_PRODUCT_STATUS_SHOPPING_CART','<br />Tut uns leid, dieses Produkt ist zurzeit von unserem Lager weggelassen worden.<br /> Dieses produkt ist schon von Ihrem Einkaufswagen weggelassen worden.');
  define('ERROR_PRODUCT_QUANTITY_MIN',',  ...Fehler von Minimum der Menge  - ');
  define('ERROR_PRODUCT_QUANTITY_UNITS',' ... Fehler von der Mengeneinheit - ');
  define('ERROR_PRODUCT_OPTION_SELECTION','<br /> ... Ungültige Auswahl ');
  define('ERROR_PRODUCT_QUANTITY_ORDERED','<br /> Die von Ihnen bestllte Gesamtsumme ist: ');
  define('ERROR_PRODUCT_QUANTITY_MAX',' ... Fehler von Maximum der Menge - ');
  define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART',', Es gibt eine Beschränkung von Minimum der Menge.');
  define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART',' ...Fehler von der Mengeneinheit - ');
  define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART',' ...  Fehler von Maximum der Menge - ');

  define('WARNING_SHOPPING_CART_COMBINED', 'NOTIZ: For your convenience, your current shopping cart has been combined with your shopping cart from your last visit. Please review your shopping cart before checking out.');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
  define('ERROR_CUSTOMERS_ID_INVALID', 'Kundeninformation kann nicht bestätigt werden!<br />Bitte loggen ein und legen Ihr Konto ab...');

  define('TABLE_HEADING_FEATURED_PRODUCTS','Hauptprodukte');

  define('TABLE_HEADING_NEW_PRODUCTS', 'Neue Produkte für %s');
  define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Kommend Produkte');
  define('TABLE_HEADING_DATE_EXPECTED', 'Erwartetes Datum');
  define('TABLE_HEADING_SPECIALS_INDEX', 'Monatliche Sonderangebote für %s');

  define('CAPTION_UPCOMING_PRODUCTS','Diese Artikel werden bald im Angebot sein.');
  define('SUMMARY_TABLE_UPCOMING_PRODUCTS','table contains a list of products that are due to be in stock soon and the dates the items are expected');

// meta tags special defines
  define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT','Es ist kostenlos!');

// customer login
  define('TEXT_SHOWCASE_ONLY','Kontaktieren Sie uns');
// set for login for prices
  define('TEXT_LOGIN_FOR_PRICE_PRICE','Preis fehlend');
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE','Einloggen für Preis');
// set for show room only
  define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM','Raum nur für Ausstellung');

// authorization pending
  define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Preis fehlend');
  define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'Ausstehende Genehmigung');
  define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE','Logg ein');

// text pricing
  define('TEXT_CHARGES_WORD','Berechnete Kosten:');
  define('TEXT_PER_WORD','<br />Preis jedes Wortes: ');
  define('TEXT_WORDS_FREE',' Wörter frei ');
  define('TEXT_CHARGES_LETTERS','Berechnete Kosten:');
  define('TEXT_PER_LETTER','<br />Preis pro Wort: ');
  define('TEXT_LETTERS_FREE',' Letter(s) frei ');
  define('TEXT_ONETIME_CHARGES','*Einmal-Ausgabe = ');
  define('TEXT_ONETIME_CHARGES_EMAIL',"\t" . '*Einmal-Ausgabe= ');
  define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Auswahl Mengenrabatte ');
  define('TABLE_ATTRIBUTES_QTY_PRICE_QTY','Menge');
  define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE','PREIS');
  define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Auswahl Mengenrabatte Einmal-Ausgabe');

// textarea attribute input fields
  define('TEXT_MAXIMUM_CHARACTERS_ALLOWED',' Maximum Schriftzeichens erlaubt');
  define('TEXT_REMAINING','Übrig');

// Shipping Estimator
  define('CART_SHIPPING_OPTIONS', 'Geschäzte Lieferungskosten');
  define('CART_SHIPPING_OPTIONS_LOGIN', 'Bitte <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">logg ein</span></a>, zeigt Ihre eigene Lieferungskosten.');
  define('CART_SHIPPING_METHOD_TEXT', 'verfügbare Lieferungsmethoden');
  define('CART_SHIPPING_METHOD_RATES', 'Quoten');
  define('CART_SHIPPING_METHOD_TO','Schicken zu: ');
  define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Schicken zu: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Logg ein</span></a>');
  define('CART_SHIPPING_METHOD_FREE_TEXT','Lieferung kostenfrei');
  define('CART_SHIPPING_METHOD_ALL_DOWNLOADS','- Downloads');
  define('CART_SHIPPING_METHOD_RECALCULATE','nachrechnen');
  define('CART_SHIPPING_METHOD_ZIP_REQUIRED','Wahr');
  define('CART_SHIPPING_METHOD_ADDRESS','Adresse:');
  define('CART_OT','geschätzte Gesamtsumme:');
  define('CART_OT_SHOW','Wahr'); // set to false if you don't want order totals
  define('CART_ITEMS','Artikel im Einkaufswagen: ');
  define('CART_SELECT','Wählen');
  define('ERROR_CART_UPDATE', '<strong>Bitte erneuen Ihre Bestellung.</strong> ');
  define('IMAGE_BUTTON_UPDATE_CART', 'Update');
  define('EMPTY_CART_TEXT_NO_QUOTE', 'Whoops! Ihre Anmeldung ist abgelaufen...Bitte erneuen Sie Ihren Einkaufswagen für das Preisangebot vom Versand ...');
  define('CART_SHIPPING_QUOTE_CRITERIA', 'Die Preisangebote vom Versand sind von Ihrer Adresseinformation abhängig.');

// multiple product add to cart
  define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'In den Einkaufswagen: ');
  define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'In den Einkaufswagen: ');
  define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'In den Einkaufswagen: ');
  define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'In den Einkaufswagen: ');
  //moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
  define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Menge von Rabattpreis');
  define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Menge neuer Rabattpreis');
  define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Menge von Rabattpreis');
  define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Rabattpreise können auf Grund von Auswahl droben unterschiedlich sein');
  define('TEXT_HEADER_DISCOUNTS_OFF', 'Rabattpreis nicht verfügbar ...');

// sort order titles for dropdowns
  define('PULL_DOWN_ALL_RESET','- RÜCKSETZEN - ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Produktname');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Produktname - desc');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Preis - niedrig bis hoch');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Preis - hoch bis niedrig');
  define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Modell');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Datum im Angebot - neu bis alt ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Datum im Angebot - alt bis neu');
  define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'vorgegebene Anzeige');

// downloads module defines
  define('TABLE_HEADING_DOWNLOAD_DATE', 'Verbindung abgelaufen');
  define('TABLE_HEADING_DOWNLOAD_COUNT', 'Rest');
  define('HEADING_DOWNLOAD', 'Klicken Sie auf den Knopf und Wählen Sie "auf der Diskette zu speichern" von dem Pop-up-Menü.');
  define('TABLE_HEADING_DOWNLOAD_FILENAME','Filename');
  define('TABLE_HEADING_PRODUCT_NAME','Artikelname');
  define('TABLE_HEADING_BYTE_SIZE','Dateigröße');
  define('TEXT_DOWNLOADS_UNLIMITED', 'Schrankenlos');
  define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
  define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
  define('TABLE_HEADING_QUANTITY', 'Menge.');
  define('TABLE_HEADING_PRODUCTS', 'Name des Artikels');
  define('TABLE_HEADING_TOTAL', 'Gesamtsumme');

// create account - login shared
  define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Datenschuzterklärung');
  define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Bitte erkennen Sie Unsere Datenschutzerklärung durch ein Klicken auf den folgenden Knopf an. Die Datenschutzerklärung ist <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">hier</span></a>zu lesn.');
  define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'Ich habe Ihre Datenschuzterklärung gelesen und bin damit einverstanden..');
  define('TABLE_HEADING_ADDRESS_DETAILS', 'Adressedetails');
  define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Zusätzliche Kontaktdetails');
  define('TABLE_HEADING_DATE_OF_BIRTH', 'Ihr Alter nachprüfen');
  define('TABLE_HEADING_LOGIN_DETAILS', 'Details von Einloggen');
  define('TABLE_HEADING_REFERRAL_DETAILS', 'Bezihen Sie sich auf uns?');

  define('ENTRY_EMAIL_PREFERENCE','Newsletter und Email Details');
  define('ENTRY_EMAIL_HTML_DISPLAY','HTML');
  define('ENTRY_EMAIL_TEXT_DISPLAY','TEXT-Only');
  define('EMAIL_SEND_FAILED','FEHLER: Misslungene Sendung von E-Mail an: "%s" <%s> mit dem Thema: "%s"');

  define('DB_ERROR_NOT_CONNECTED', 'Fehler - kann nicht mit der Datenbank verbinden');

  // EZ-PAGES Alerts
  define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNUNG: EZ-PAGES HEADER - auf nur für Admin IP');
  define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNUNG: EZ-PAGES FOOTER - auf nur für Admin IP');
  define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNUNG: EZ-PAGES SIDEBOX - auf nur für Admin IP');

// extra product listing sorter
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Artikel beginnen mit ...');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Rücksetzen --');

///////////////////////////////////////////////////////////
// include email extras
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select. FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

// END OF EXTERNAL LANGUAGE LINKS

  define('FIBERSTORE_VIEW_MORE', 'Mehr Artikel im Einkaufswagen...');
  define('FIBERSTORE_WISHLIST_ADD_TO_CART','In den Einkaufswagen');
  define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS','Zum Wunschzettel mit Erfolg hinzugefügt');
  define('FIBERSTORE_DELETE','Beseitigen');
  define('FIBERSTORE_PRICE','PREIS');
  define('FIBERSTORE_VIEW_MORE_ORDERS','Alle Bestellungen anzeigen »');
  define('FIBERSTORE_ORDER_IMAGE','Produktbild');
  define('FIBERSTORE_POST','Post');
  define('FIBERSTORE_CANCEL_ORDER','Bestellungen stornieren');
  define('FIBERSTORE_PRODTCTS_DETAILS','Produktdetails');
  
  define('FIBERSTORE_OEM_CUSTOM','OEM & Custom');
  define('FIBERSTORE_ANY_TYPE','Jeder Typ');
  define('FIBERSTORE_ANY_LENGTH','Jede Länge');
  define('FIBERSTORE_ANY_COLOR','Jede Farbe');
  define('FIBERSTORE_WORK_PROJECT','Lassen Sie mit uns zusammen an Ihrem Programm arbeiten');

  define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
  define('TEXT_PREFIX','text_prefix_');

  define('LEFT_SLIDE_TIT1','Firmeninfo');
  define('LEFT_SLIDE_TIT2','Kundenservice');
  define('LEFT_SLIDE_TIT3','Zahlung & Versand');
  define('LEFT_SLIDE_TIT4','Schnelle Hilfe');
  define('LEFT_SLIDE_CON1','Kontakt');
  define('LEFT_SLIDE_CON2','Über Fiberstore');
  define('LEFT_SLIDE_CON3','Warum uns');
  define('LEFT_SLIDE_CON4','Aktuelle News');
  define('LEFT_SLIDE_CON5','Betriebskonto');

  define('LEFT_SLIDE_CON7','OEM & Custom');
  define('LEFT_SLIDE_CON8','Qualitätskontrolle');
  define('LEFT_SLIDE_CON9','ISO Standard');
  define('LEFT_SLIDE_CON10','Garantie');
  define('LEFT_SLIDE_CON11','RMA-Lösung');
  define('LEFT_SLIDE_CON12','Rückgaberecht');
  define('LEFT_SLIDE_CON13','Geld-zurück-Garantie');
  define('LEFT_SLIDE_CON14','Zahlungsmethode');
  define('LEFT_SLIDE_CON15','Net 30 & W9');
  define('LEFT_SLIDE_CON16','Versandhilfe');
  define('LEFT_SLIDE_CON17',' Versand & Lieferung');
  define('LEFT_SLIDE_CON18','Einkaufshilfe');
  define('LEFT_SLIDE_CON19','FAQ');
  
  
  
  // LANGUAGE FOR COMMON FOOTER
  define('FOOTER_TIT_FIR','Fiberstore Unterstützung');
  define('FOOTER_FILENAME_SUPPORT','Alles anzeigen »');
  define('FOOTER_MTP_HREF','MTP/MPO Verbindungselement');
  define('FOOTER_MTP_CON','MTP/MPO Faser Systeme sind tatsächlich eine innovative Gruppe von Produkten wie Vielfaserkabel...');
  define('FOOTER_TIT_SEC','Kundenreaktionen');
  define('FOOTER_CON_SEC','Wir haben einige mux\'s und dwdm xfps, und manche sfps davon funktionieren ganz gut. Ich weiß, dass viele von ISPS ihr Gerät auch verwenden.<i></i><b>-- Angryceo</b>');
  define('FOOTER_TIT_TIR',' Aktuelle News');
  define('FOOTER_PAGE_SEA','Populäre Seiten:');
  define('FOOTER_SHARE_TIT','Willkommen Sie in unsere Gemeinschaft:');
  define('FOOTER_RIGHT_CON','<span>Wie können wir Ihnen helfen heute?</span><br>
        <p>Professionelle Service & Unterstützung ist auf drei verschiedenen Weisen verfügbar.</p>');
  define('FOOTER_RIGHT_IMG','Live-Chat jetzt');
  define('FOOTER_ABOUT_FIR','<span>Information der Firma</span><br>
        <a itemprop="url"  href='. zen_href_link(FILENAME_ABOUT_US).'>Über Fiberstore</a><br>
        <a itemprop="url"  href='.  zen_href_link(FILENAME_WHY_US).'>Warum uns</a><br>
        <!--  
        <a itemprop="url"  href='. zen_href_link(FILENAME_PRIVACY_POLICY).'>Datenschutzrichtlinie</a><br>
        -->
        <a itemprop="url" href='. zen_href_link(FILENAME_SITE_MAP).'>Sitemap</a><br>
        <a itemprop="url" href='. zen_href_link(FILENAME_NEWS).'>Aktuelle News</a><br>
        <a itemprop="url" href="http://www.fiberstore.com/blog/">Fiberstore Blog</a>');
  define('FOOTER_ABOUT_SEC','<span>Kundenservice</span><br>
       
        <a itemprop="url"  href='.zen_href_link(FILENAME_OEM).'>OEM & Custom</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_RMA_SOLUTION).'>RMA-Lösung</a><br>
		<a itemprop="url"  href='.zen_href_link(FILENAME_DAY_RETURN_POLICY).'>Rückgaberecht</a><br>
		<a itemprop="url"  href='.zen_href_link(FILENAME_WARRANTY).'>Garantie</a><br>
		<a itemprop="url"  href='.zen_href_link(FILENAME_ISO_STANDARD).'>ISO Standard</a><br>');
  define('FOOTER_ABOUT_TIR','<span>Zahlung & Lieferung</span><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_PAYMENT_METHODS).'>Zahlungsmethode</a><br>
        <a itemprop="url"  href='.zen_href_link("net_30").'>Net 30 & W9</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_GLOBAL_SHIPPING).'>Versandhilfe</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_ESTIMATED_TIME).'>Versand & Lieferung</a><br>
      </div>
      <div class="footer_04"> <span>Schnelle Hilfe</span><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_CONTACT_US).'>Kontaktieren Sie uns</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_HOW_TO_BUY).'>Einkaufshilfe</a><br>');        
  define('FOOTER_ABOUT_TIR1','<a itemprop="url"  href='.zen_href_link(FILENAME_PASSWORD_FORGOTTEN).'>Haben Sie Ihr Passwort vergessen?</a><br>') ;       
  define('FOOTER_ABOUT_TIR2',' <a itemprop="url"  href='.zen_href_link(FILENAME_CHANGE_PASSWORD).'>Haben Sie Ihr Passwort vergessen?</a><br>');       
  define('FOOTER_ABOUT_TIR3','<a itemprop="url"  href='.zen_href_link(FILENAME_LIVE_CHAT_SERVICE).'>Live-Chat</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_FAQ).'>FAQ</a><br>');
  //FOOTER END
  //HEADER LIVE
  define('HEADER_LIVE_TIT','Chat jetzt');
  define('HEADER_LIVE_FIR','Service vor dem Verkauf');
  define('HEADER_LIVE_SEC','Chat mit Online Verkäufer für weitere Informationen vor dem Verkauf!');
  define('HEADER_LIVE_TIR','Chat starten');
  define('HEADER_LIVE_FOUR','Service nach dem Verkauf');
  define('HEADER_LIVE_FIVE','Wenn Sie etwas gekauft haben, bitte gehen Sie');
  define('HEADER_LIVE_SIX','Meine Bestellung');
  define('HEADER_LIVE_SEV','Seite von Aufforderungen zur Live Hilfe für Bestelldetails.');
  //HEADER END
  //TPL INDEX
  define('FIBERSTORE_INDEX_HELP','<dd><b>Wie können wir Ihnen<br />heute helfen?</b><i>Live-Chat jetzt</i></dd>');
  define('FIBERSTORE_INDEX_SIDER','<p class="sidebar_03_02 "><b>Partnerprogramm</b> Ihre Geschäft entwickeln</p>');
  define('FIBERSTORE_INDEX_SIDER1','<p class="sidebar_03_02 "><b>Globale Lieferung</b> 2 bis 3 Tage weltweite Lieferung</p>');
  define('FIBERSTORE_INDEX_SIDER2','<p class="sidebar_03_02"><b>ISO Standard</b> Konzentration auf Qualität und Genauigkeit</p>');
  define('FIBERSTORE_INDEX_SIDER3','<p class="sidebar_03_02"><b>Zahlungsmethode</b> Gesicherte Zahlung</p>');
  define('FIBERSTORE_INDEX_SIDER4','<p class="sidebar_03_02"><b>lebenslange Garantie</b> unter normalen Betriebsbedingungen</p>');
  define('FIBERSTORE_INDEX_OEM','<span class="oem_02">OEM & Custom</span> <span class="oem_03 "><ul><li>Jedes Produkt </li><li>Jede Größe</li><li>Jeder Typ</li><li>Jede Farbe</li></ul></span> <span class="oem_03 oem_04">Ausgezeichnete Qualität & Service, um alle Ihrer Anforderungen zu erfüllen</span>');
  //INDEX END