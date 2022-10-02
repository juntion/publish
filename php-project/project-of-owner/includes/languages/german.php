<?php

  define('FOOTER_TEXT_BODY', ' &copy; 2009-'. date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">FS.COM</a> Alle Rechte vorbehalten. <a href="/de/privacy_policy.html"> Datenschutz </a> <a href="/de/terms_of_use.html">&nbsp;&nbsp;Nutzungsbedingungen</a> ');
  /*bof language for my_account*/

  define('FIBERSTORE_CDN_IMAGES','https://www.fs.com');
  //define('FIBERSTORE_CDN_IMAGES','/images/');

//夏令时--冬令时
define('SUMMER_TIME',true);
if(SUMMER_TIME){
    define('FS_SUMMER_OR_WINTER_TIME','16:30 (UTC/GMT+2)');
}else{
    define('FS_SUMMER_OR_WINTER_TIME','16:30 (UTC/GMT+1)');
}

define('MY_ORDER_SUCCESSFULLY','Die Bestellung wurde erfolgreich eingereicht, warten auf Ihre Bezahlung.');
define('MY_ORDER_WAIT','Die Bestellung hat erfolgreich eingereicht, warten Sie auf Ihre Zahlung.');

//account info breadcrumb
define('FS_MY_ACCOUNT','Mein Konto');
define('FS_ALL_ORDER','Alle Bestellungen');
define('FS_PENDING_ORDERS','Ausstehende Bestellungen');
define('FS_TRANSACTION_ORDERS','Transaktionsaufträge');
define('FS_CANCELED_ORDERS','Stornierten die Bestellungen');
define('FS_EXCHANGE','Umtausch & Rückgabe der Bestellungen');
define('FS_MY_ADDRESS','Meine Adresse');
define('FS_ACCOUNT_SETTINGS','Kontoeinstellungen');
define('FS_NEWSLETTER','Newsletter');
define('FS_CHANGE_PASSWORD','Transaktionsaufträge');
define('FS_MY_REVIEWS','Meine Bewertungen');
define('FS_HAVE_SERVICE','Sie haben derzeit keinen Bestellservice.');
define('FS_EMAIL_FSCOM','https://www.fs.com/de');
  //******************body box menu***********************/
  define('F_BODY_HEADER_BACK','Zurück zu der Startseite');
  define('F_BODY_HEADER_GS','Globaler<br>Versand');

  define('F_BODY_MENU_CATEG','Alle Kategorien');
  define('F_BODY_MENU_HOME','Homepage');
  define('F_BODY_MENU_PROD','Produkte');
  define('F_BODY_MENU_WHOLESALES','Großhandel');
  define('F_BODY_MENU_TUTORIAL','Anleitung');
  define('F_BODY_MENU_ABOUT','Über uns');
  define('F_BODY_MENU_SUPP','Unterstützung');
  define('F_BODY_MENU_CONTANT','Kontakt');
  define('FIBERSTORE_SHOPPING_HELP','Ihr Warenkorb ist leer.');



  //***************shop cart******************************/
  define('FIBERSTORE_REMOVE','Entfernen');
define('FIBERSTORE_CART_TOTAL','Gesamtsumme:');
define('FIBERSTORE_EDITE_ORDER','Zum Warenkorb');
define('FIBERSTORE_CHECK_YOU_ORDER','Zur Kasse');

define('FS_PROCEED_TO_CHECKOUT','ZUR KASSE GEHEN');
define('FS_ITEMS','Artikel');
define('FS_VIEW_ALL','Alles anzeigen');
define('FS_FILTER', 'Filter');
  //******************Product List************************/
  //*****************产品列表页标题******************************
define('FIBERSTORE_LIST_BIAO','Default');
define('FIBERSTORE_LIST_BIAO2','Umsatz');
define('FIBERSTORE_LIST_BIAO3','Preis');
define('FIBERSTORE_LIST_BIAO4','Neu eingetroffen');
define('FIBERSTORE_LIST_BIAO5','Bilder');
define('FIBERSTORE_LIST_BIAO6','status');
define('FIBERSTORE_LIST_BIAO7','Versanddatum');
define('FIBERSTORE_LIST_BIAO8','Preis');
define('FIBERSTORE_LIST_BIAO9','Menge');
define('FIBERSTORE_LIST_BIAO10','Großhandelspreis');
define('FIBERSTORE_LIST_BIAO11','Geschätzt am selben Tag');
define('FIBERSTORE_LIST_BIAO12','Kaufen');
define('FIBERSTORE_LIST_BIAO13','Wenn Sie große Auftragsvolumen benötigen, können Sie ein');
define('FIBERSTORE_LIST_BIAO131','Betriebskonto </a> beantragen oder mit uns ');
define('FIBERSTORE_LIST_BIAO132',' Kontakt</a> ufnehmen, um mehr Vergünstigungen zu genießen.');
define('FIBERSTORE_LIST_BIAO14','Geschätzt am nächsten Tag');
define('FIBERSTORE_LIST_BIAO15','Geschätzt am');
define('FIBERSTORE_LIST_BIAO16','Siehe Details');
define('FIBERSTORE_LIST_BIAO17',' Kundenbewertunge');
define('FIBERSTORE_LIST_BIAO18','Wellenlänge');
define('FIBERSTORE_LIST_BIAO19','Distanz');
define('FIBERSTORE_LIST_BIAO20','Datenrate');
define('FIBERSTORE_LIST_BIAO21','Ein Angebot erhalten');
define('FIBERSTORE_LIST_BIAO22','Name');
define('FIBERSTORE_LIST_BIAO23','Währung');
define('FIBERSTORE_LIST_BIAO24','Optische Dämpfungsglieder :');
define('FIBERSTORE_LIST_BIAO25','LWL-Modems :');
define('FIBERSTORE_LIST_BIAO26','Operating Wavelengths :');
define('FIBERSTORE_LIST_BIAO27','Kompatible Marken:');
define('FIBERSTORE_LIST_BIAO28','Mehr');
define('FIBERSTORE_LIST_BIAO29','Weitere Marken anzeigen');
define('FIBERSTORE_LIST_BIAO31','Weniger Marken anzeigen');
define('FIBERSTORE_LIST_BIAO30','Kategorien');

define('F_PRODUCT_IMAGES','Bilder');
  define('F_PRODUCT_STATUS','Status');
  define('F_PRODUCT_WAVELENGTH','Wellenlänge');
  define('F_PRODUCT_DISTANCE','Distanz');
  define('F_PRODUCT_DATERATE','Datenrate');
  define('F_PRODUCT_SHIPDATE','Versanddatum');
  define('F_VOLUME_PRICE','Großhandelpreis');
  define('F_VOLUME_PRICE_GET','Wenn Sie großes Auftragsvolumen brauchen, bewerben Sie sich für einen Rabatt<a href="<?php echo $href;?>" target="_blank">Betriebskonto</a> oder <a href="<?php echo zen_href_link(FILENAME_CONTACT_US)?>" target="_blank">Kontakt</a>, um begünstigte Richtlinien zu bekommen.');
  define('F_OPTION_ARRAY1','Preis von hoch bis niedrig');
  define('F_OPTION_ARRAY2','Preis von niedrig bis hoch');
  define('F_OPTION_ARRAY3','Bestsellers');
  define('F_OPTION_ARRAY4','Höchst beurteilt Produkte');
  define('F_OPTION_ARRAY5','Neue Produkte');

  define('F_PRODUCT_RECOMMEND','Empfohlene Produkte');
  define('F_PRODUCT_RESULTS','<div class="results_font">Entschuldigung, Wir haben <s>0</s> Ergebnis(se)gefunden!  <a href="<?php echo zen_href_link(FILENAME_DEFAULT, cPath='.(int)$current_category_id.');?>">Andere Produkte nachsehen</a>.</div>');
  define('F_PRODUCT_REVIEWS','Kommentare');
//******************LEFT_sidebar************************/

 
/*******************Checkout***********************************/
  define('NAVBAR_TITLE_1','Bezahlung');
  define('F_SHIPPING_ADDRESS','Versandadresse ');
  define('F_M_BILLING_ADDRESS','Ihre Zahlungsadresse verwalten');
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
  define('F_FREIGHT_COLLECT','Fracht vom Empfänger einziehen');
  define('F_WARNING','Falls Sie Ihr eigenes Expresskonto bevorzugen, bieten Sie uns bitte Ihre Kontonummer. Dann wird Fiberstore die Frachtgeld nicht von Ihnen einziehen.');
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
                Die Lieferzeit ist von der Versandmethode abhängig:<br />
                <b>Schnelle Lieferung:</b> 1-4 Arbeitstage<br />
                <b>Standard-Versendung:</b> 2-6 Arbeitstage<br />
                <b>Super sparende Versendung:</b> 10-30 Arbeitstage <br />
                FiberStore.com wird den besten Träger auf der Grundlage von der Aufforderungen Ihres Auftrags und dem Zielpunkt der Versendung wählen. Und in besonderen Umständen werden wir Sie kontaktieren.<br />');
  define('F_PAYMENT_METHOD','Zahlungsarten');
  define('F_WE_CURRENTLY','Zurzeit akzeptieren wir telegrafische Geldüberweisung für alle Bestellungen. Auch neheme wir Sicherheit sehr ernst, deshalb sind Ihre Detailsinformationen bei uns ganz sicher');
  define('F_CART_SUMMARY','Überblick des Einkaufswagens');
  define('F_ITTEM','Artikel');
  define('F_QTY','Menge');
  define('F_WEIGHT','Gewicht');
  define('F_PRICE','Preis');
  define('F_TOTA_AMOUNT','Gesamtsumme');
  define('F_TOTAL','Gesamtsumme:');
  define('F_SHIPPING_COST','(+)Versandkosten:');
  define('F_EXCLUDING_TAXES','Ohne Steuern');
  define('F_PO','Ihre Auftragsnummer');
  define('FIBERSTORE_WAIT_PROCESSING','Verarbeitung');
  define('FS_CHECK_PAYTIT','Zurzeit akzeptieren wir PayPal,Kredit- und Debitkarte und telegrafische Geldüberweisung für alle Bestellungen. Wir nehmen Sicherheit sehr ernst, Ihre Detailinformationen sind sicher bei uns.');
define('FS_CHECK_PAY1','Kredit- und Debitkarte');
define('FS_CHECK_PAY2','Telegrafische Überweisung');
define('FS_CHECK_NOTE','Wechsel');
define('CHECK_PAY1_TIT','Angemeldete PayPalbenutzer können Ihre Zahlung durch Ihr PayPalkonto fertigmachen');
define('CHECK_PAY1_CON','Neue Benutzer können erstens ein PayPalKonto registrieren, und dann führen die Zahlung auf  die Webseite von Paypal fort.');
define('CHECK_PAY1_FOT','Sie können uns das Geld durch PayPal direkt senden, unser Konto ist:');
define('CHECK_PAY2_TIT','Die von uns akzeptierten Kredit- und Debitkarten findet man darunter:');
define('CHECK_PAY2_CON','Aus Sicherheitsgründen werden wir keinesfalls Ihre Kreditkartendaten speichern.');
define('CHECK_PAY3_TIT','Details der Empfänger von der telegrafischen Geldüberweisung:');
define('CHECK_PAY3_ADD1','Der Bankname der Empfänger:');
define('CHECK_PAY3_ADD2','Name des Kontokorrent von der Empfänger:');
define('CHECK_PAY3_ADD3','Nummer des Kontokorrent von der Empfänger :');
define('CHECK_PAY3_ADD4','SWIFT Adresse:');
define('CHECK_PAY3_ADD5','Bankadresse der Empfänger:');
define('CHECK_PAY3_ADD6','Adersse unserer Firma:');
define('CHECK_PAY3_ADD7','Östliche Seite, Wissenschaft & Technologie Park, Nr.6, Keyuan Straße, Nanshan Bezirk, Shenzhen, China');
define('CHECK_PAY3_CON','Die Kunden, die die Banküberweisung ausgewählt haben, sind für alle Provisionen und Bearbeitungsgebühren von lokalen Banken verantwortlich.');
define('FS_CHECK_TOTAL','<b>HAFTUNGSAUSSCHLUSS für internationale Bestellungen </b><br /><br />

Einfuhrzölle, Steuern und Vermittlungsgebühren sind nicht in den Produktpreis oder Versandkosten enthalten, und es wird von den Trägern für bestimmte Pakete nach Anlieferung eingezogen. Die Zollstelle zieht Zoll auf die Pakete einfach zufällig ein, deshalb sind wir nicht in der Lage, den Betrag auf unserer Seite vorherzusagen.<br /><br />

Diese Gebühren sind Empfängers Verantwortung, denn wir ziehen nur Transportgebühr für die Pakete ein. Sie können das Zollamt in Ihrem Land befragen, um festzustellen, wie viel die zusätzlichen Kosten sein werden.');
define('FS_CHECK_EDIT','Meine Bestellung bearbeiten');
define('FS_CHECK_SUB1','Zu PayPal weitergehen');
define('FS_CHECK_SUB2','Eine Bestellung aufgeben');
define('FS_ADDRESS_TIT','Pflichtfeld');
define('FS_ADDRESS_TIT1','Rechnungsadresse');
define('FS_ADDRESS_TIT2','Eine neue Rechnungsadresse hinzufügen');
define('FS_ADDRESS_LI1','Vorname:');
define('FS_ADDRESS_LI2','Nachname:');
define('FS_ADDRESS_LI3','Adressenzeile:');
define('FS_ADDRESS_LI4','Stadt::');
define('FS_ADDRESS_LI5','Land:');
define('FS_ADDRESS_LI6','Bitte wählen Sie');
define('FS_ADDRESS_LI7','Bundesland / Provinz/ Region:');
define('FS_ADDRESS_LI8','Postleitzahl:');
define('FS_ADDRESS_LI9','Telefonnummer:');
define('FS_ADDRESS_LI10','Speichern');
define('FS_ADDRESS_LI11','Stornieren');
define('FS_ADDRESS_LI12','Ablauf...');
define('FS_CHECK_COLLECT','Fracht beim Empfänger einziehen');
define('FS_COLLECT_TIT','Versandmethode:');
define('FS_COLLECT_TIT1','Express-Konto:');

define('FIBERSTORE_CREDIT_CARD','Mit Kreditkarte Bezahlen ');
define('FIBERSTORE_CREDIT_CARD2','
          <td width="20%"><div align="left" class="pay_lc_01">Einkaufswagen</div></td>
          <td width="25%"><div align="center" class="pay_lc_03">Bezahlung</div></td>
          <td width="25%"><div align="right" class="pay_lc_04">Erfolg</div></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="login_new_03">
  <div class="login_new_04">
    <div class="transfer">
      <div class="credit_card_left">
	  <div class="login_title">Kredit-/Debitkarte Zahlungszentrum</div>
        <div class="credit_card_title">Rechnungsinformationen</div>
        <div class="credit_card_content"><span>Bitte stellen Sie sicher, dass die unten von Ihnen eingegebene Rechnungsadresse mit dem Namen und Adresse übereinstimmt, die im Zusammenhang mit der Kreditkarte stehen, die Sie für diesen Kauf verwenden. Bitte beachten Sie, dass die Rechnungsadresse und Lieferadresse gleich sein müssen.');

define('FIBERSTORE_CREDIT_CARD3','Vorname:');
define('FIBERSTORE_CREDIT_CARD4','Nachname:');
define('FIBERSTORE_CREDIT_CARD5','Rechnungsadresse');
define('FIBERSTORE_CREDIT_CARD6','Land/Region von Empfänger:');
define('FIBERSTORE_CREDIT_CARD7','Bundesland/Landkreis/Region:');
define('FIBERSTORE_CREDIT_CARD8','Stadt:');
define('FIBERSTORE_CREDIT_CARD9','Postleitzahl:');
define('FIBERSTORE_CREDIT_CARDT','Telefonnummer:');
define('FIBERSTORE_CREDIT_CARD10','Ihre Zahlung wurde abgelehnt. Bitte verwenden Sie eine andere Kreditkarte oder wechseln Sie die Zahlungsarten in PayPal oder Überweisung.');
define('FIBERSTORE_CREDIT_CARD11','Kredit-/Debitkarte Informationen
<div class="track_orders_wenhao">
		<div class="question_bg"></div>
			<div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">Wir nehmen die folgenden Kredit-/Debitkarten. Bitte wählen Sie einen Kartentyp, füllen die folgende Informationen aus, und klicken Sie auf Weiter. <span>(Hinweis: Aus Sicherheitsgründen werden wir keinesfalls Ihre Kreditkartendaten speichern.)');
define('FIBERSTORE_CREDIT_CARD12','Wählen Kredit-/Debitkarte aus:');
define('FIBERSTORE_CREDIT_CARD13','Kartennummer:');
define('FIBERSTORE_CREDIT_CARD14','Gültig bis:');
define('FIBERSTORE_CREDIT_CARD15','Monat');
define('FIBERSTORE_CREDIT_CARD16','Jahr');
define('FIBERSTORE_CREDIT_CARD17','Sicherheitscode:');
define('FIBERSTORE_CREDIT_CARD18','Weiter');
define('FIBERSTORE_CREDIT_CARD19','Bestellübersicht');
define('FIBERSTORE_CREDIT_CARD20','Zwischensumme:');
define('FIBERSTORE_CREDIT_CARD21','Versandkosten:');
define('FIBERSTORE_CREDIT_CARD22','Gesamtmenge:');
define('FIBERSTORE_CREDIT_CARD23','Zusätzliche Zahlungssicherheit mit:');


 /************************end_checkout******************************/

  define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> News )');
  define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Anleitung )');
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
  define('FIBERSTORE_REGIST_ERROR','Nuestro sistema ya tiene un registro de dicha dirección de correo electrónico - por favor intenta acceder a dicha dirección de correo electrónico. Si usted no usa esa dirección por más tiempo se puede corregir en el area Mi Cuenta');
  define('FIBERSTORE_LOGIN_ERROR','La dirección de email o la contrase?a es incorrecta.');

  /*bof language contact_us email time:2012_12_17*/
  //define('FIBERSTORE_WELCOME_MEAASGE','This email message was sent from a notification-only address that cannot accept incoming email. PLEASE DO NOT REPLY to this message. If you have any questions please contact us.');
  define('FIBERSTORE_WELCOME_MEAASGE','Este mensaje fue enviado desde una dirección exclusivamente de notificación que no puede recibir mensajes entrantes. Por favor no responda a este mensaje. Si usted tiene alguna pregunta, por favor póngase en contacto con nosotros.');

  define('FIBERSTORE_REVIEW_NO','Ninguna revisión actualmente .');
  define('FIBERSTORE_WELCOME_TO','Estimado cliente,');
  define('FIBERSTORE_WELCOME_CART','Carrito Permanente');
  //define('FIBERSTORE_WELCOME_CART','Permanent Cart');
  define('FIBERSTORE_CONTACT_ABOUT','sobre nosotros contenido de ecoptical.com');
  define('FIBERSTORE_CUSTOMER_NAME','Nombre del cliente:');
  define('FIBERSTORE_CUSTOMER_EMAIL','Cliente E-mail:');
  define('FIBERSTORE_CONTACT_SUBJECT','sujeto');
  define('FIBERSTORE_CONTACT_CONTENTS','Contenido:');
  define('FIBERSTORE_CONTACT_FROM','De http://www.fs.com/');

  define('FIBERSTORE_SELECT','Por favor seleccione...');
  //  define('FIBERSTORE_SELECT','Please select ...');


  define('COPY_RIGHT', 'derechos de autor @ 2009-'.date('Y',time()).' Fiberstore Co., Ltd. Todos los Derechos Reservados.');
define('FOOTER', '<tr>
        <td bgcolor="#E2E2E2"></td>
        <td bgcolor="#E2E2E2" height="160" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Información</strong><br />
                <a href="http://www.fs.com/de/contact_us.html" target="_blank" style=" color:#616265; text-decoration:none;">Contacte con nosotros</a><br />
                <a href="http://www.fs.com/de/about_us.html" target="_blank" style=" color:#616265; text-decoration:none">Acerca de nosotros</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=why_us" target="_blank" style=" color:#616265; text-decoration:none">Por qué nosotros</a><br />
                <a href="http://www.fs.com/de/privacy_policy.html" target="_blank" style=" color:#616265; text-decoration:none">Política de Privacidad</a><br />
                <a href="http://www.fs.com/de/site_map.html" target="_blank" style=" color:#616265; text-decoration:none">Mapa del Sitio</a><br />
                <a href="http://www.fs.com/de/blog/" target="_blank" style=" color:#616265; text-decoration:none">FiberStore Blog</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Servicio al Cliente</strong><br />
                <a href="http://www.fs.com/de/index.php?main_page=get_a_quick_quote" target="_blank" style=" color:#616265; text-decoration:none">Obtener una cotización rápida</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=oem" target="_blank" style=" color:#616265; text-decoration:none">OEM</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=payment_methods" target="_blank" style=" color:#616265; text-decoration:none">Formas de Pago</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=shipping_guide" target="_blank" style=" color:#616265; text-decoration:none">Guía de envío</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=custom_OEM" target="_blank" style=" color:#616265; text-decoration:none">Solución</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=estimated_lead_time" target="_blank" style=" color:#616265; text-decoration:none">Tiempo estimado</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Mi cuenta</strong><br />
                <a href="http://www.fs.com/de/login.html" target="_blank" style=" color:#616265; text-decoration:none">Inicie sesión o Regístrese</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=manage_orders" target="_blank" style=" color:#616265; text-decoration:none">Mis pedidos</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=manage_wishlists" target="_blank" style=" color:#616265; text-decoration:none">Mis Favoritos</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; padding:0 5px;"><strong>Ayuda rápida</strong><br />
                <a href="http://www.fs.com/de/how_to_buy.html" target="_blank" style=" color:#616265; text-decoration:none">Cómo comprar</a><br />
                <a href="http://www.fs.com/de/password_forgotten.html" target="_blank" style=" color:#616265; text-decoration:none">Olvidaste tu contraseña?</a><br />
                <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl(\'http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=\', \'chatbox152062\', globalWindowAttribute);" style=" color:#616265; text-decoration:none">Chat en Vivo</a><br />
                <a href="http://www.fs.com/de/index.php?main_page=faq" target="_blank" style=" color:#616265; text-decoration:none">Preguntas más frecuentes</a></div></td>
        <td bgcolor="#E2E2E2"></td>
    </tr>');

  define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="https://www.fs.com/">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
				</a>		
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="https://www.fs.com/de/support/Data-Center-Products.html">Rechenzentrum</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="https://www.fs.com/de/support/Enterprise-Small-Business.html">Enterprise Network</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="https://www.fs.com/de/support/ISP-Networks.html">Optisches Transportnetz</a>
			</div>');
  define('EMAIL_FOOTER_INFO','
			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">Ihre Nutzungserfahrung teilen <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="https://www.fs.com/de/">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="https://www.fs.com/de/contact_us.html">Kontakt</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="https://www.fs.com/de/index.php?main_page=account_newsletters">Mein Konto</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="https://www.fs.com/de/shipping_delivery.html">Versand & Lieferung</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="https://www.fs.com/policies/day_return_policy.html">Rückgaberecht</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">Sie haben diese E-Mail als $user_email abonniert.</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="https://www.fs.com/de/index.php?main_page=account_newsletters">Klicken Sie hier, um Ihre Einstellungen zu ändern oder den Newsletter abzubestellen.</a>
			</div>');

/* 产品、分类公用 */
define('FS_ADD_TO_CART', 'In den Warenkorb');
define('CATEGORIES_HEADING_DETAILS','Details anzeigen');
define('FS_VIEW_CART', 'Zum Warenkorb');
define('FS_VIEW', 'Zeigen');
define('FS_REVIEWS', 'Bewertungen');
define('FS_REVIEWS_SMALL', 'Bewertungen');
define('FS_REVIEW', 'Bewertung');
define('FS_SHARE', 'Teilen');
//define('FS_NEED_HELP', 'Hilfe Brauchen');
define('FS_COMPATIBLE', 'Kompatibel');
define('FS_LENGTH', 'Länge');
define('FS_TOTAL_LENGTH', 'Gesamtlänge');
define('FS_CUSTOM_LENGTH', 'Kundenindividuelle Länge');
define('FS_SHIPPING_COST', 'Versandkosten');
define('FS_SHIP_SAME_DAY', 'sofort lieferbar');
define('FS_SHIP_NEXT_DAY', 'Geschätzt am nächsten Tag');
define('FS_OUT_OF_STOCK', 'Nicht auf Lager');
define('FS_DELETE_PRODUCT', 'Löschen das Produkt');
define('FS_AVAILABILTY', 'Verfügbarkeit');
//2017.11.24  ery  add  产品详情页属性名称
define('FS_CHOOSE_LENGTH','Gesamtlänge');
define('FS_LENGTH_NAME','Länge');
define('FS_OPTION_NAME','Gerätenummer');
define('FS_PRODUCTS_ORDERS_RECEIVED','Erhaltene Bestellungen von 13.00 Uhr von PST (Pacific Standard Time) Mo-Fr (außer an Feiertagen ) würden am nächsten Werktag versendet werden.');
define('FS_PRODUCTS_ACTUAL_TIME','Es kann eine gewisse Differenz zwischen der geschätzten Zeit und der aktuellen Zeit.');
define('PRODUCT_INFO_ADD','hinzufügen');
define('PRODUCT_INFO_ADDED','Hinzugefügt');
define('FS_TRANSCEIVER_TYPE','Typ des Transceivers:');

 define('ACCOUNT_FOOTER_TITLE','Einkaufen mit Zuversicht');

 define('ACCOUNT_FOOTER_SHOPPING','EINKAUFEN BEI FIBERSTORE.COM ');

 define('ACCOUNT_FOOTER_SECURE','IST ZUVERLÄSSIG UND GESICHERT.');

 define('TEXT_LOGIN_GUARANTEED','GARANTIERT!');

 define('ACCOUNT_FOOTER_PAY','Sie brauchen nichts zu zahlen,wenn Sie unautorisierte Rechnung wegen des Einkaufens bei fiberstore.com in Kreditkarte erhalten.');

 define('ACCOUNT_FOOTER_SAFE','Zuverlässiges Einkaufen garantiert');

 define('ACCOUNT_FOOTER_INFORMATION','Alle Informationen sind durch das Secure Sockets Layer (SSL) Protokoll ohne Risiko verschlüsselt und gesendet.');

 define('ACCOUNT_FOOTER_HOW','Wie schützen wir Ihre privaten Daten?');

 define('ACCOUNT_FOOTER_FREE','Lieferung und Retouren sind kostenlos');

 define('ACCOUNT_FOOTER_SHOP','Wenn Sie unzufrieden mit der bei FiberStore Co.Ltd gekauften Erwerbung, können Sie die Erwerbung in ihrer Originalbedingung innerhalb sieben Tagen für eine Erstattung zurückgeben. Wir werden sogar für die Lieferung der Rücksendung zahlen!');

 define('ACCOUNT_FOOTER_DELIVER','FiberStore liefert eine lebenslängliche Garantie als ein standardmäßiges Merkmal für alle Hauptproduktlinien, um eine sorgefreie Operation zu bieten und die Reparaturkosten außerhalb der Garantiezeit zu beseitigen.');

 define('ACCOUNT_FOOTER_LEARN','Erfahren Sie mehr...');

 define('TEXT_FIBERSTORE_REGIST_RESPECTS','Fiberstore.com respektiert Ihre Privatsphäre. Wir werden niemandem Ihre private Informationen nicht mieten oder verkaufen.');

define('TEXT_FIBERSTORE_REGIST_PRIVACY','Die Datenschutzrichtlinie.');

//2018.9.6 Yoyo  add 产品详情  shipping&returns
define('FS_ASK_EXPERT','Fragen Sie unsere Experten:');
define('FS_ASK_EXPERT_1','Inquiry');
define('SOLUTION_SUB_PAGE_05','Technischer Support');

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
  define('BOX_HEADING_CATEGORIES', 'Kategorie');

// manufacturers box text in sideboxes/manufacturers.php
  define('BOX_HEADING_MANUFACTURERS', 'Hersteller');

// whats_new box text in sideboxes/whats_new.php
  define('BOX_HEADING_WHATS_NEW', 'Neue Produkte');
  define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Neue Produkte ...');

  define('BOX_HEADING_FEATURED_PRODUCTS', 'Hauptprodukte');
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
  define('BOX_REVIEWS_WRITE_REVIEW', 'Einen Kommentar über dieses Produkt verfassen.');
  define('BOX_REVIEWS_NO_REVIEWS', 'Zurzeit gibt es noch keine Kommentare.');
  define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s von 5 Sterne!');

// shopping_cart box text in sideboxes/shopping_cart.php
  define('BOX_HEADING_SHOPPING_CART', 'Warenkorb');
define('FS_SAVED_ITEMS', 'Alle gespeicherte Artikel');

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



// currencies box text in sideboxes/currencies.php
  define('BOX_HEADING_CURRENCIES', 'Währungen');

// information box text in sideboxes/information.php
  define('BOX_HEADING_INFORMATION', 'Information');
  define('BOX_INFORMATION_PRIVACY', 'Mitteilung des Datenschutzes');
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
  define('BOX_HEADING_TELL_A_FRIEND', 'Einen Freund informieren');
  define('BOX_TELL_A_FRIEND_TEXT', 'Ihre Bekannte über dieses Produkt informieren.');

// wishlist box text in includes/boxes/wishlist.php
  define('BOX_HEADING_CUSTOMER_WISHLIST', 'Meine Wunschliste');
  define('BOX_WISHLIST_EMPTY', 'Sie haben noch keine Artikel auf Ihrer Wunschliste');
  define('IMAGE_BUTTON_ADD_WISHLIST', 'Zur Wunschliste hinzuzufügen');
  define('TEXT_WISHLIST_COUNT', 'Zurzeit sind Artikel %s auf Ihrer Wunschliste.');
  define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Zeigen <strong>%d</strong> zu <strong>%d</strong> (von <strong>%d</strong> Artikel auf Ihrer Wunschliste)');

//New billing address text
  define('SET_AS_PRIMARY' , 'Als bevorzugte Adresse einzurichten.');
  define('NEW_ADDRESS_TITLE', 'Rechnungsanschrift');

// javascript messages
  define('JS_ERROR', 'Es gibt Fehler während der Bearbeitung ihrer Form.\n\nBitte bessern Sie aus wie unten aufgelistet:\n\n');

  define('JS_REVIEW_TEXT', '* Bitte schreiben Sie die Kritik ein bisschen mehr. Eine Kritik soll mindestens ' . REVIEW_TEXT_MIN_LENGTH . ' Schriftzeichens.');
  define('JS_REVIEW_RATING', '* Bitte nehmen Sie für diesen Artikel eine Einstufung vor.');

  define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte wählen Sie eine Zahlungsarten für Ihren Auftrag.');

  define('JS_ERROR_SUBMITTED', 'Diese Form ist schon eingereicht worden. Bitte drücken Sie Ok und warten sie auf die Beendung diser Bearbeitung.');

  define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Bitte wählen Sie eine Zahlungsarten für Ihren Auftrag.');
  define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Bitte bestätigen Sie die mit diesem Auftrag verbundenen Bedingungen und Konditionen durch eien Klicken auf den Kasten darunter.');
  define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Bitte bestätigen Sie die Datenschuzterklärung durch einen Klicken auf den Kasten darunter.');

  define('CATEGORY_COMPANY', 'Details der Firma');
  define('CATEGORY_PERSONAL', 'Ihre persönliche Details');
  define('CATEGORY_ADDRESS', 'Ihre Adresse');
  define('CATEGORY_CONTACT', 'Ihre Kontaktinformation');
  define('CATEGORY_OPTIONS', 'Optionen');
  define('CATEGORY_PASSWORD', 'Ihr Passwort');
  define('CATEGORY_LOGIN', 'Anmelden');
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
  define('ENTRY_EMAIL_ADDRESS_ERROR', 'Ist Ihre E-mailadrsse richtig? Sie soll mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Schriftzeichen enthalten. Bitte geben Sie noch einmal ein.');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Entschuldigung, das System kann Ihre E-mailadrsse nicht verstehen, bitte geben Sie noch ein mal ein.');
 // define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este e-mail ya existe en nuestra base de datos - por favor, entre con otro e-mail o cree otra cuenta con una dirección de e-mail diferen.');
  define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Unser System hat schon eine Rekode von dieser E-mailadrsse - Bitte versuchen Sie, mit dieser E-mailadrsse einzuloggen. Falls Sie diese Adresse nicht mehr benutzen werden, können Sie in Mein Konto korrigiren.');

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
  define('PREVNEXT_BUTTON_PREV', 'Früher');
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
  define('TEXT_NO_REVIEWS', 'Es gibt zurzeit noch keine Kommentare.');

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

  define('GV_HAS_VOUCHERB', '"><strong>E-mail</strong></a> zu jemandem');
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
  define('TEXT_VALID_COUPON', 'Gratulation! Sie haben diesen Rabatt-Gutschein eingelöst');
  define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Die von Ihnen eingegebene Gutscheinkode ist ungültig für die von Ihnen ausgewählte Adresse.');

// more info in place of buy now
  define('MORE_INFO_TEXT','... mehr Informationen');

// IP Address
  define('TEXT_YOUR_IP_ADDRESS','Ihre IP Adresse ist: ');

//Generic Address Heading
  define('HEADING_ADDRESS_INFORMATION','Information von Adressen');

// cart contents
  define('PRODUCTS_ORDER_QTY_TEXT_IN_CART','Menge im Einkaufswagen: ');
  define('PRODUCTS_ORDER_QTY_TEXT','Zum Einkaufswagen hinzuzufügen: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Erfolgreich zum Einkaufswagen hinzugefügte Produkte ...');
// only for where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Ausgewählte Produkte erfolgreich zum Einkaufswagen hinzugefügt...');

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
  define('PULL_DOWN_MANUFACTURERS','- Zurücksetzen -');
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
  define('TEXT_INVALID_USER_INPUT', 'Eingang vom Benutzer verlangt<br />');

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
  define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG','NOTIZ: Das Herunterladen ist erst möglich nach der Bestätigung der Zahlung.');
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

  //meta_tags  新模板 2016-9-26 frankie
  //模块
define('MODEL_META_DES_01','Einkaufen');
define('MODEL_META_DES_02','Kaufen Sie kostengünstige');
define('MODEL_META_DES_03','bei FS.COM heute. Lebenslange Garantie, ROHS-konform, 100% sicherer Test. OEM/ODM-Bestellung ist verfügbar.');

//跳线
define('FIBER_META_DES_01','Große Auswahl an');
define('FIBER_META_DES_02','erfüllen Ihre Bedürfnisse. Vor dem Versand haben wir 100% optischen Test und lebenslange Garantie. Individueller Service ist verfügbar.');

//其他
define('OTHER_META_DES_01','Weltweiter Versand für');
define('MODEL_META_DES_02','Kaufen Sie kostengünstige');
define('OTHER_META_DES_02','von FS.COM, Genießen Sie günstigen Preis und erstklassigen Service.');



// customer login
  define('TEXT_SHOWCASE_ONLY',' Uns kontaktieren');
// set for login for prices
  define('TEXT_LOGIN_FOR_PRICE_PRICE','Preis fehlend');
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE','Einloggen für Preis');
// set for show room only
  define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM','Raum nur für Ausstellung');

// authorization pending
  define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Preis fehlend');
  define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'unerledigte Genehmigung');
  define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE','Logg ein');

// text pricing
  define('TEXT_CHARGES_WORD','Calculated Charge:');
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
  define('CART_SHIPPING_METHOD_TO','Schicken nach: ');
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
  define('ERROR_CART_UPDATE', '<strong>Bitte erneuen Ihren Auftrag.</strong> ');
  define('IMAGE_BUTTON_UPDATE_CART', 'In Kürze');
  define('EMPTY_CART_TEXT_NO_QUOTE', 'Whoops! Ihre Anmeldung ist abgelaufen...Bitte erneuen Sie Ihren Einkaufswagen für das Preisangebot vom Versand ...');
  define('CART_SHIPPING_QUOTE_CRITERIA', 'Die Preisangebote vom Versand sind von Ihrer Adresseinformation abhängig.');

// multiple product add to cart
  define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'In den Warenkorb: ');
  define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'In den Warenkorb: ');
  define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'In den Warenkorb: ');
  define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'In den Warenkorb: ');
  //moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
  define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Menge  Rabattpreis');
  define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'menge neuer Rabattpreis');
  define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Menge Rabattpreis');
  define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Rabattpreise können auf Grund von Auswahl droben unterschiedlich sein');
  define('TEXT_HEADER_DISCOUNTS_OFF', 'Menge Rabattpreis nicht verfügbar ...');

// sort order titles for dropdowns
  define('PULL_DOWN_ALL_RESET','- ZURÜCKSETZEN - ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Produktname');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Produktname - desc');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Preis - niedrig bis hoch');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Preis - hoch bis niedrig');
  define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Modell');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Datum im Angebot - neu bis alt ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Datum im Angebot - alt bis neu');
  define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Standardanzeige');

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
  define('EMAIL_SEND_FAILED','FEHLER: Misslungene Sendung von E-mail an: "%s" <%s> mit dem Thema: "%s"');

  define('DB_ERROR_NOT_CONNECTED', 'Fehler - kann nicht mit der Datenbank verbinden');

  // EZ-PAGES Alerts
  define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNUNG: EZ-PAGES HEADER - auf nur für Admin IP');
  define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNUNG: EZ-PAGES FOOTER - auf nur für Admin IP');
  define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNUNG: EZ-PAGES SIDEBOX - auf nur für Admin IP');

// extra product listing sorter
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Artikel beginnen mit ...');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Zurücksetzen --');

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

  define('FS_CART','Warenkorb');
  define('FIBERSTORE_VIEW_MORE', 'Mehr anzeigen');
  define('FIBERSTORE_WISHLIST_ADD_TO_CART','In den Warenkorb');
  define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS','Zum Wunschzettel mit Erfolg hinzugefügt');
  define('FIBERSTORE_DELETE','Löschen');
  define('FIBERSTORE_PRICE','PREIS');
  define('FIBERSTORE_VIEW_MORE_ORDERS','Alle Bestellungen anzusehen »');
  define('FIBERSTORE_ORDER_IMAGE','Produktbild');
  define('FIBERSTORE_POST','Post');
  define('FIBERSTORE_CANCEL_ORDER','Bestellung stornieren');
  define('FIBERSTORE_PRODTCTS_DETAILS','Produktdetails');

  define('FIBERSTORE_OEM_CUSTOM','Benutzerdefinierter Artikel');
  define('FIBERSTORE_ANY_TYPE','Jeder Typ');
  define('FIBERSTORE_ANY_LENGTH','Jede Länge');
  define('FIBERSTORE_ANY_COLOR','Jede Farbe');
  define('FIBERSTORE_WORK_PROJECT','Lassen Sie mit uns zusammen an Ihrem Programm arbeiten');

  define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
  define('TEXT_PREFIX','text_prefix_');
//live chat begin
define('EMAIL_SUBJECT', 'Meldung von ' . STORE_NAME);
define('LIVE_CHAT_TIT','Alle Unterstützung beim Einkaufen kriegen');
define('LIVE_CHAT_TIT1','Professionelle Service & Unterstützung ist auf drei verschiedenen Weisen verfügbar.');
define('LIVE_CHAT_TIT2','Sie haben Ihre Meldung zu Fiberstore mit Erfolg gesendet. Vielen Dank!');
define('LIVE_CHAT_CON1','Live-Chat mit Fiberstore');
define('LIVE_CHAT_CON2','Sprechen Sie mit uns, und erhalten Sie sofort die bezüglichen informationen.');
define('LIVE_CHAT_CON3','8 am. bis Mitternacht, Pacific Normalzeit, Montag bis Freitag.');
define('LIVE_CHAT_CON4','Bitte hinterlassen Sie uns eine Meldung, und wir werden Ihnen eine Antwort so schnell wie möglich geben.');
define('LIVE_CHAT_CON5','Eine Meldung hinterlassen');
define('LIVE_CHAT_CON6','Eine E-mail zu Fiberstore schicken');
define('LIVE_CHAT_CON7','Antworten innerhalb von 12 Stunden');
define('LIVE_CHAT_CON8','Eine Anfrage richten und eine schnelle Antwort von Fiberstore bekommen');
define('LIVE_CHAT_CON9','E-mail jetzt');
define('LIVE_CHAT_CON10','erhältlich');
define('LIVE_CHAT_CON11','Nicht erreichbar');
define('LIVE_CHAT_CON12','Anrufen');
define('LIVE_HEAD_CON1','Oder klicken Sie auf den Knopf darunter, dann werden wir Sie anrufen.<br /> 8 am.- 5 pm. CEDT.  Montag bis Freitag.');
define('LIVE_HEAD_CON2','Oder klicken Sie auf den Knopf darunter, dann werden wir Sie anrufen.<br /> 8 am.- 5 pm. EST.  Montag bis Freitag.');
define('LIVE_HEAD_CON3','Oder klicken Sie auf den Knopf darunter, dann werden wir Sie anrufen.<br /> 8 am.- 5 pm. BST.  Montag bis Freitag.');
define('LIVE_HEAD_CON4','Oder klicken Sie auf den Knopf darunter, dann werden wir Sie anrufen.<br />8 am.- 5 pm. PST.  Montag bis Freitag.');
define('LIVE_BUTTON_HTML','Offline');
//live chat end
  define('LEFT_SLIDE_TIT1','Firmeninfo');
  define('LEFT_SLIDE_TIT2','Kundenservice');
  define('LEFT_SLIDE_TIT3','Zahlung & Versand');
  define('LEFT_SLIDE_TIT4','Schnelle Hilfe');
  define('LEFT_SLIDE_CON1','Kontakt');
  define('LEFT_SLIDE_CON2','Über Fiberstore');
  define('LEFT_SLIDE_CON3','Warum uns');
  define('LEFT_SLIDE_CON4','News');
  define('LEFT_SLIDE_CON5','Betriebskonto');

  define('LEFT_SLIDE_CON7','OEM & Custom');
  define('LEFT_SLIDE_CON8','Qualitätskontrolle');
  define('LEFT_SLIDE_CON9','ISO Standard');
  define('LEFT_SLIDE_CON10','Garantie');
  define('LEFT_SLIDE_CON11','RMA-Lösung');
  define('LEFT_SLIDE_CON12','Rückgaberecht');
  define('LEFT_SLIDE_CON13','Geld-zurück-Garantie');
  define('LEFT_SLIDE_CON14','Zahlungsarten');
  define('LEFT_SLIDE_CON15','Net 30 & W9');
  define('LEFT_SLIDE_CON16','Versandhilfe');
  define('LEFT_SLIDE_CON17',' Versand & Lieferung');
  define('LEFT_SLIDE_CON18','Einkaufshilfe');
  define('LEFT_SLIDE_CON19','FAQ');



  // LANGUAGE FOR COMMON FOOTER
  define('FOOTER_TIT_FIR','Fiberstore Unterstützung');
  define('FOOTER_FILENAME_SUPPORT','Alles anzeigen »');
  define('FOOTER_MTP_HREF','MTP/MPO Verbindungselement');
  define('FOOTER_MTP_CON','MTP/MPO Faser Systeme sind tatsächlich eine innovative Gruppe von Produkten wie Multifaser...');
  define('FOOTER_TIT_SEC','Kunden-Feedback');
  define('FOOTER_CON_SEC','Wir haben einige mux\'s und dwdm xfps, und manche sfps davon funktionieren ganz gut. Ich weiß, dass viele von ISPS ihr Gerät auch verwenden.<i></i><b>-- Angryceo</b>');
  define('FOOTER_TIT_TIR',' Aktuelle News');
  define('FOOTER_PAGE_SEA','Populäre Seiten:');
  define('FOOTER_SHARE_TIT','Willkommen Sie in unsere Gemeinschaft:');
  define('FOOTER_RIGHT_CON','<span>Wie können wir Ihnen helfen heute?</span><br>
        <p>Professionelle Service & Unterstützung ist auf drei verschiedenen Weisen verfügbar.</p>');
  define('FOOTER_RIGHT_IMG','Live-Chat jetzt');
  define('FOOTER_ABOUT_FIR','<span>Information der Firma</span><br>
        <a itemprop="url"  href='. zen_href_link(FILENAME_ABOUT_US).'>Über Fiberstore</a><br>
        <a itemprop="url"  rel="nofollow"  href='.  zen_href_link(FILENAME_WHY_US).'>Warum uns</a><br>
        <!--
        <a itemprop="url"  href='. zen_href_link(FILENAME_PRIVACY_POLICY).'>Datenschutzrichtlinie</a><br>
        -->
        <a itemprop="url" href='. zen_href_link(FILENAME_SITE_MAP).'>Sitemap</a><br>
        <a itemprop="url"  target="_blank"  href="http://www.fs.com/news.html" target="_blank">Aktuelle News</a><br>
        <a itemprop="url" href="http://www.fs.com/blog/">Fiberstore Blog</a>');
  define('FOOTER_ABOUT_SEC','<span>Kundenservice</span><br>

        <a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_OEM).'>OEM & Custom</a><br>
        <a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_RMA_SOLUTION).'>RMA-Lösung</a><br>
		<a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_DAY_RETURN_POLICY).'>Rückgaberecht</a><br>
		<a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_WARRANTY).'>Garantie</a><br>
		<a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_ISO_STANDARD).'>ISO Standard</a><br>');
  define('FOOTER_ABOUT_TIR','<span>Zahlung & Lieferung</span><br>
        <a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_PAYMENT_METHODS).'>Zahlungsarten</a><br>
        <a itemprop="url"  rel="nofollow" href='.zen_href_link("net_30").'>Net 30 & W9</a><br>
        <a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_GLOBAL_SHIPPING).'>Versandhilfe</a><br>
        <a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_ESTIMATED_TIME).'>Versand & Lieferung</a><br>
      </div>
      <div class="footer_04"> <span>Schnelle Hilfe</span><br>
        <a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_CONTACT_US).'>Kontakt</a><br>
        <a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_HOW_TO_BUY).'>Einkaufshilfe</a><br>');
  define('FOOTER_ABOUT_TIR1','<a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_PASSWORD_FORGOTTEN).'>Haben Sie Ihr Passwort vergessen?</a><br>') ;
  define('FOOTER_ABOUT_TIR2',' <a itemprop="url" rel="nofollow" href='.zen_href_link(FILENAME_CHANGE_PASSWORD).'>Haben Sie Ihr Passwort vergessen?</a><br>');
  define('FOOTER_ABOUT_TIR3','<a itemprop="url" rel="nofollow" href='.zen_href_link(FILENAME_LIVE_CHAT_SERVICE).'>Live-Chat</a><br>
        <a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_FAQ).'>FAQ</a><br>');
  //FOOTER END

  //TPL INDEX
  define('FIBERSTORE_INDEX_HELP','<dd><b>Wie können wir Ihnen<br />heute helfen?</b><i>Live-Chat jetzt</i></dd>');
  define('FIBERSTORE_INDEX_SIDER','<p class="sidebar_03_02 "><b>Partnerprogramm</b> Ihre Geschäft entwickeln</p>');
  define('FIBERSTORE_INDEX_SIDER1','<p class="sidebar_03_02 "><b>Globale Lieferung</b> 2 bis 3 Tage weltweite Lieferung</p>');
  define('FIBERSTORE_INDEX_SIDER2','<p class="sidebar_03_02"><b>ISO Standard</b> Konzentration auf Qualität und Genauigkeit</p>');
  define('FIBERSTORE_INDEX_SIDER3','<p class="sidebar_03_02"><b>Zahlungsarten</b> Gesicherte Zahlung</p>');
  define('FIBERSTORE_INDEX_SIDER4','<p class="sidebar_03_02"><b>lebenslange Garantie</b> unter normalen Betriebsbedingungen </p>');
  define('FIBERSTORE_INDEX_OEM','<span class="oem_02">OEM & Custom</span> <span class="oem_03 "><ul><li>Jedes Produkt </li><li>Jede Größe</li><li>Jeder Typ</li><li>Jede Farbe</li></ul></span> <span class="oem_03 oem_04">Ausgezeichnete Qualität & Service, um alle Ihrer Anforderungen zu erfüllen</span>');
  //INDEX END
  //2016-5-19购物车结账页面
define('F_EDIT','bearbeiten');
define('F_PROCEED_TO_PAYPAL','gehen zu Paypal');
define('F_CONFIRM_TO_PAYMENT','Bestätigen die Bezahlung');
define('F_SUBMIT_ORDER','Absenden die Bestellung');
define('F_SHIP_SAME_DAY','Versand am selben Tag');
define('F_SHIP_NEXT_DAY','Es wird geschätzt am nächsten Tag');
define('F_SHIP_TIME','Geschätzt auf');
define('F_WENHAO','Es kann eine gewisse Differenz zwischen der geschätzten Zeit und der aktuellen Zeit');
define('F_CHAT_NOW','chatten jetzt');
define('F_PLEASE_SELECT','bitte auswählen');
define('F_PLEASE_ENTER_FIRST_NAME','bitte geben Sie Ihren Vornamen ein');
define('F_PLEASE_ENTER_LAST_NAME','bitte geben Sie ihren Nachnamen ein');
define('F_PLEASE_ENTER_STREET_ADDRESS','bitte geben Sie Ihre Straße-Adresse ein');
define('F_PLEASE_ENTER_CITY','bitte geben Sie Ihre Stadt ein');
define('F_PLEASE_ENTER_POSTAL_CODE','bitte geben Sie Ihre Postleitzahl ein');
define('F_PLEASE_ENTER_COUNTRY','bitte geben Sie Ihre Land ein');
define('F_PLEASE_ENTER_STATE','bitte geben Ihre Bundesland/ Provinz / Region ein');
define('F_PLEASE_ENTER_TELEPHONE_NUMBER','bitte geben Sie Ihre Telefonnummer ein');
define('FIBERSTORE_SHOP_CART_BUTTON1','
Sicher einkaufen
</b>
      <dt>Einkaufen bei FS.COM ist sicher Und Sicherheit.Garantie!<br />Sie werden nichts bezahlen, wenn unberechtigte Gebühren von Ihrer Kreditkarte als Folge der Einkauf bei FS.COM gemacht werden.</dt>
      <div class="ccc"></div>
       <b>Kostenloser Versand und kostenlose Retouren</b>
      <dt>Sorgen Bedienung nach dem Prinzip und die Kosten, die mit aus Garantie-Reparaturen im Zusammenhang beseitigen, bietet FS.COM eine Garantie als Standard-Feature in allen wichtigen Produktlinien .');
define('FIBERSTORE_SHOP_CART_BUTTON2','FS.COM wird von BBB beglaubigt </b><dt><i class="login_018"></i>
Qualität und Standards sind die Grundlage für FS.COM. Unser Ziel ist es, die besten Service und Produkte von höchster Qualität für Kunden zu bieten seit dem Tag der Gründung.
 </dt></li>
      <li><b>Garantie für sicheres Einkaufen</b>
      <dd><i class="login_016" style=" height:68px; margin-bottom:5px;"></i>Alle Informationen werden verschlüsselt und übertragen, ohne Risiko mit einem Secure Sockets Layer (SSL) Protokoll.');

//2016-7-29 frankie
define('FS_PROCESSING','Bearbeitet');
define('FS_DELETE_PRODUCT','Das Produkt Löschen');
define('FS_YES','ja');
define('FS_NO','nein');
define('FS_ADD','hinzufügen...');
define('FS_ADDED','hinzugefügt');

define('FS_CHECKOUT','Kasse');
define('F_BODY_HEADER_ITEM',' Artikel');
define('F_BODY_HEADER_ITEM_TWO','Artikel');
define('F_BODY_HEADER_ITEMS','Artikel');
define('FS_BUSINESS','Werktage');
define('FS_TOTAL','Gesamtsumme');
define('FS_PROCEED','Weiter zum Paypal');
define('FS_CONFIRM','Bestätigen');
//define('FS_SUBMIT','die Bestellung einreichen');


//支付页面
define('F_USE_CREDIT','Die Zahlung wurde abgelehnt. Bitte verwenden Sie eine andere Kreditkarte oder die Zahlungsarten in PayPal oder Überweisung auf einer offenen Bestellung');
define('F_MAKE_SURE','Bitte stellen Sie sicher, dass Sie die Rechnungsadresse unten eingeben, stimmt mit dem Namen und Adresse im Zusammenhang mit der Kreditkarte, die Sie für diesen Kauf verwenden. Bitte beachten Sie Ihre Rechnungsadresse und Lieferadresse - Land gleich sein müssen');
define('F_COUNTRY','Empfängerland');
define('F_ZIP','ZIP');
define('F_ORDER_SUMMARY','Bestellübersicht');
define('F_ORDER_NUMBER','Bestellnummer');
define('F_TOTAL_AMOUNT','Gesamtmenge');
define('F_CREDIT','Kredit');
define('F_DEBIT','Payment Center der Debitkarte ');
define('F_ACCEPT','Wir nehmen die folgenden Kredit- / Debitkarten');
define('F_SELECT_CARD_TYPE','Bitte wählen Sie einen Kartentyp , füllen Sie die folgenden Informationen ein, und klicken Sie auf Weiter');
define('F_NOTE','Hinweis: Aus Sicherheitsgründen werden wir irgendwelche Ihre Kreditkartendaten nicht speichern');
define('F_SELECT_SELECT_CREDIT','Wählen Sie Kredit');
define('F_DEBIT_CARD','Debitkarte');
define('F_CARD_NUMBER','Kartennummer');
define('F_EXPIRATION_DATE','Ablaufdatum');
define('F_MONTH','Monat');
define('F_YEAR','Jahr');
define('F_SECURITY_CODE','Sicherheitscode');
define('F_LOADING','Laden');


//define('FS_CHOOSE','Wählen');

//列表页
define('FIBERSTORE_SHOW_RESULTS','<b>Zeigen die Ergebnisse für</b>');
define('FIBERSTORE_SHOW_BRANDS','zeigen mehr Marken');
define('FIBERSOTER_SHOW_MORE_BRANDS','Zeigen Weitere Marken');
define('FIBERSOTER_COMPATIBLE_BRANDS','Kompatible Marken');
define('FIBERSOTER_SHOW_LESS_BRANDS','Zeigen Weniger Marken');
define('FIBERSTORE_QUICKFINDER','schnellsuche');
define('FIBERSTORE_PAGE','Seite');
Define('FIBERSTORE_REVIEWS_ALL','Bewertungen');
define('FIBERSTORE_P_LOW_TO_HIGH','Preis:vom niedrigsten zum höchsten');
define('FIBERSTORE_P_HIGH_TO_LOW','Preis:vom höchsten zum niedrigsten');
define('FIBERSTORE_R_HIGH_TO_LOW','Rate:vom höchsten zum niedrigsten');
define('FIBERSTORE_NEWEST_F','Neueste zuerst');
define('FIBERSTORE_POPU','Popularität');
define('LET_US_HELP_YOU','12.Lassen uns, Ihnen zu helfen');
define('CHAT_WITH_US_NOW','chatten mit uns jetzt');
define('CATR_TOTAL','15.Die Endsumme des WarenKorbs');
define('THE_MQQ','MOQ (Das MOQ (Mindestbestellmenge ) dieses Kabeles ist 1 km. Bitte erhöhen die Gesamtlänge dann wieder überprüfen. Jede mögliche Frage, kontaktieren Sie uns unter Sales@fs.com');
define('FIBERSTORE_TRANSCEIVER','Transceiver module für');
define('FIBERSTORE_WORKING_ON','Voll getestet in unserem Testfeld und 100% arbeiten an');
define('FIBERSTORE_SHOP_BY','Einkaufen nach Kategorie');
//2016-8-3 frankie
define('MODULE_FILTER','Filter');
define('MODULE_VIEW','Alles anzeigen');
define('MODULE_FINDER','Sehen das Produkt schnell');
define('MODULE_QTY','MENGE');
define('MODULE_ADD','Hinzufügen');
define('MODULE_CART','Sehen den Einkaufswagen');
define('FS_NEXT_DAY','Am nächsten Tag geschätzt');
define('F_SHIP_TIME','Erhaltene Bestellungen von 13.00 Uhr von PST (Pacific Standard Time) Mo-Fr (außer an Feiertagen ) würde am nächsten Werktag versendet werden.');
define('F_SHIP_DISTIN','Es kann eine gewisse Differenz zwischen der geschätzten Zeit und der aktuellen Zeit.');
define('F_SHIP_TO','nach');
define('F_SHIP_VIA','per');
define('F_SHIP_OUT','Vergriffen');
define('FS_CUSTOM','Benutzerdefiniert');





//写产品评论页面
define('FIBERSTORE_REQUIRED_QUESTION','Benötigte Frage');
define('FIBERSTORE_REVIEW_HEADLINE','Die Überschrift der Bewertung');
define('FIBERSTORE_EXAMPLE','Titel *');
define('FIBERSTORE_REVIEWS_ATTACH','Anfügen das Bild +');
define('FIBERSTORE_REVIEWS_SUBMIT_REVIEW','Einreichen die Bewertung');
//推广文章页面
define('FIBERSOTER_SUPPORT1','Faserkommunikationswelt');
define('FIBERSOTER_SUPPORT2','Fiberstore ist ein globaler Anbieter von umfassenden Faseroptikprodukte. <br />Wir sind stolz auf die äußersten wettbewerbsfähigen Preisen, hervorragende Qualität, schnelle Reaktion, die uns abheben. ');
define('FIBERSOTER_SUPPORT3','Promotionsprojekt');
define('FIBERSOTER_SUPPORT4','Produktkatalog');
define('FIBERSOTER_SUPPORT5','Lösungsvorschlag');
define('FIBERSOTER_SUPPORT6','Erfahren Sie mehr');

//客户中心页面






define('FIBERSTORE_ORDER_CONFIRM','Bestätigen');
define('FIBERSTORE_SALES_MESSAGES','1.Sie könnten nur den After-Sales-Service beantragen , wenn Ihre Bestellung abgeschlossen ist. Wir bitten Sie auf das "Empfangsbestätigung" in der Seite der Bestelldetails zu klicken, um die Bestellung zu beenden.<br>
2.Bitte, beantragen Sie den After-Sales-Service in Ihrer Seite der fertigen Bestelldetails .');
define('FIBERSTORE_WRITE_REVIEW','schreiben Sie eine Bewertung');

//2016-5-23新增一级分类
define('FIBERSTORE_TRANS1','Suchen per Netzwerkgerät ');
define('FIBERSTORE_TRANS2','Suchen per Originalmodul ');
define('FIBERSTORE_TRANS3','LWL- Patchkabel</h1>
      </div>
      <div class="title_small">FS.COM bietet hochwertige Glasfaserkabel-Baugruppen wie Pach Cords, Pigtails, MCPs, Breakout Kabel usw. Alle unsere Faserkabel können als Monomode 9/125, Multimode- 62,5 / 125 OM1, Multimode- 50/125 OM2 und Multimode- 10 Gig 50/125 OM3 / OM4-Fasern bestellt werden. </div>
      
      <div class="sidebar_find">
          <span>Beliebte Glasfaserkabel');
define('FIBERSTORE_TRANS4','Kaufen per Steckverbinder');
define('FIBERSTORE_TRANS5','Alle Glasfaserkabel-Baugruppen');
define('FIBERSTORE_TRANS6','Kaufen nach Kategorien');
//2016-7-1 checkout
define('FS_CHECKOUT_ORDER_REMARKS','Bemerkung zur Bestellung');
define('FS_CHECKOUT_ORDER_ADVISE','Bitte geben Sie die Modellnummer Ihres Gerätes an, um die Kompatibilität zu gewährleisten.');
define('FS_CHECKOUT_REMARKS','Remarks');



//tpl_header.php   melo



//2016-7-28 frankie

define('FS_LIVE_CHAT','Live-Chat');
//2016-7-29 frankie
define('ACCOUNT_CANCEL_ORDER','Bestellung stornieren');
define('ACCOUNT_BE_RECOVERED','Sobald Sie eine Bestellung stornieren, kann diese nicht wiederhergestellt werden.');
define('ACCOUNT_PROVIDE_REASON','Wenn Sie diese Bestellung wirklich stornieren möchten, geben Sie uns bitte mindestens einen Grund dafür an.');
define('ACCOUNT_SHIPPING','Zu hohe Versandkosten');
define('ACCOUNT_DUPLICATE','Doppelte Bestellung');
define('ACCOUNT_FAILING','Probleme bei der Zahlung');
define('ACCOUNT_WRONG','Information falsch angegeben');
define('ACCOUNT_OUT','Produkt nicht auf Lager');
define('ACCOUNT_OFFLINE','Offline-Kauf');
define('ACCOUNT_NO_NEED','Produkt nicht mehr benötigt');
define('ACCOUNT_OTHERS','Andere');
define('ACCOUNT_CONFIRM','Bestätigen');
define('ACCOUNT_CANCEL','Stornieren');
define('ACCOUNT_TIP','Geben Sie bitte mindestens einen Grund für die Stornierung an.');
//page_not_found  2016-7-29
define('PAGE_NUT_EXIST',"Entschuldigung, die Seite existiert nicht ");
define('PAGE_NUT_UPL','- Es kann ein Fehler in der URL sein, die Sie eingegeben haben ');
define('PAGE_NUT_AVAIlABLE','- Vielleicht die besuchende Seite oder Datei wurde verschoben, versteckt, oder es war nicht mehr verfügbar .');
define('PAGE_NUT_BACK','Zurückgehen zu');
define('PAGE_NUT_HOME','Homepage');
define('PAGE_NUT_EMAIL','oder uns eine E-Mail an');
define('PAGE_NUT_HELP','für weitere Hilfe');
define('PAGE_NUT_BACK','Zurück');
define('PAGE_NUT_OR','oder');
define('PAGE_NUT_ALL','Alle Kategorien');
define('PAGE_NUT_HOT','Heiße Produkte');
define('PAGE_NUT_CISCO','Cisco SFP');
define('PAGE_NUT_SFP','Cisco 10G SFP');
define('PAGE_NUT_FIBER','LC-LC LWL-Kabel');
define('PAGE_NUT_SPLITTER','PON-Splitter');
define('PAGE_NU_INSTOCK','Erhältlich');
//跳线模块 2016-7-30
define('SHORT_TEXT','FS.COM bietet hochwertige Glasfaserkabel-Baugruppen wie Patchkabel, Pigtails, MCPs, Breakout-Kabel usw. Alle unsere Glasfaserkabel können als Monomode 9/125, Multimode- 62,5 / 125 OM1, Multimode- 50/125 OM2 und Multimode- 10 Gig 50/125 OM3 / OM4-Fasern bestellt werden');
define('SHORT_DES','LWL-Patchkabel');

//2016-8-1 frankie
//module shipping   运费模块
define('FS_SHIP_ORDER','Versenden meine Bestellung (en) nach');
define('FS_CHOOSE_SHIP','Wählen die Versandmethode ');
define('FS_COMPANY','Versandunternehmen');
define('FS_TIME','Versanddauer');
define('FS_COST','Versandkosten');
define('FS_TO','nach');
define('FS_VIA','per');
define('FS_PREFER','Wenn Sie Ihr eigenes Express-Konto lieber verwenden, geben Sie bitte die Kontonummer,  dann berechnet Fiberstore die Fracht nicht.');
define('FS_METHOD','Versandmethode');
define('FS_ACCOUNt','Express-Konto');
define('FS_NO_SHIPPING','Kein Versand nach dem ausgewählten Land');
define('FS_BUSINESS_DAYS','Business Days');
define('FS_BUSINESS_DAY','Business Day');
define('FS_SHIP_CONFIRM','Bestätigen');
define('FS_FREE_SHIP', 'Kostenloser Versand');
define('FS_WORK_DAYS_SERVICE', 'Working Days');

define('TEXT_CONTINUE','Weiter einkaufen');
define('FIBERSTORE_SERVICE1','Herzlich willkommen zum Service von Fiberstore');
define('FIBERSTORE_SERVICE2','Spezialisiertes Team, Fortschrittliche Technologie, Perfekte Lösungen');
define('FIBERSTORE_SERVICE3',' Bekommen alle Unterstützung');
define('FIBERSTORE_SERVICE4',' Professioneller Service & Unterstützung ist auf drei verschiedene Arten verfügbar');
define('FIBERSTORE_SERVICE5',' Live-Chat Jetzt');
define('FIBERSTORE_SERVICE6','Lösungen');
define('FIBERSTORE_SERVICE7','Tutorial');
define('FIBERSTORE_SERVICE8','Einkaufshilfe');
define('FIBERSTORE_SERVICE9','Andere');
define('FIBERSTORE_SERVICE10','Service');
define('FIBERSTORE_SERVICE11','Online');
define('FS_OURFACTORY_MORE','Mehr');
define('FIBERSTORE_CONTACT_BU12','Ein Angebot erhalten');


define('FS_LIVE_SUBMIT','einreichen');
//2016-8-4
define('FIBERSTORE_OR_PRINT','Drucken');
define('FIBERSTORE_SESTEM','Das System von Fiberstore');
define('FIBERSTORE_YOUR','Sie');
define('FIBERSTORE_CANCEL_SUCCESS','Die  Anforderung von Stornierung der Bestellung wurde erfolgreich eingereicht');
define('FIBERSTORE_CE_SUCCESS','Die Bestellung wurde erfolgreich Storniert');

//2016-8-2 frankie
define('F_CREDIT_OR_DEBIT','Kredit- / Debitkarte Payment Center ');
define('F_SELECT_CREDIT','Wählen Kredit-' );
define('F_CONTINUE','Fortsetzen');

/*fallwind	2016.8.2	tpl_live_chat_service_mail_default.php*/
define('FS1_GET_A_QUICK','Erhalten ein schnelles Angebot');

define('FS2_TO_HELP_SERVE','Um Sie schnell zu dienen, füllen Sie bitte und senden Sie die folgenden Informationen, so kann Ihre Frage / Problem durch die richtige Abteilung lösen.');

define('FS3_PLEASE_KINDLY','Bitte füllen Sie die unten angeforderten Felder aus und unsere professionellen Vertrieb werden Sie bald innerhalb der nächsten 12 Stunden kontaktieren.');

define('FS4_ENTER_YOUR_NAME','Geben Ihren Namen ein:');

define('FS5_BACK','Zurück');

define('FS6_PLEASE_MAKE_SURE','Bitte stellen Sie sicher, dass Sie Ihren Namen ausgefüllt haben.');

define('FS7_YOUR_EMAIL_ADDRESS','Ihre E-Mail-Adresse:');

define('FS8_SORRY','Entschuldigung, Sie wurden auf die schwarze Liste hinzugefügt!');

define('FS9_THE_EMAIL_ADDRESS','Die E-Mail-Adresse wird nicht erkannt.(Zum Beispiel: someone@example.com).');

define('FS10_YOUR_COUNTRY','Ihr Land:');

define('FS11_SELECT_YOUR_COUNTRY','Bitte stellen Sie sicher, dass Sie Ihr Land wählen.');

define('FS12_REGARDING','Bezüglich :');

define('FS13_PHONE_NUMBER','Telefonnummer:');

define('FS14_A_VALID_PHONE_NUMBER','Bitte geben Sie eine gültige Telefonnummer ein.');

define('FS15_MUST_BE_AT_LEAST','Ihre Telefonnummer muss mindestens 7 Ziffern lang sein.');

define('FS16_MESSAGE_SUBJECT','Betreff der Nachricht:');

define('FS17_COMMENTS_QUESTION','Kommentare / Fragen:');

define('FS18_PLEASE_ENTER_A_QUESTION','Bitte geben Sie eine Frage ein.');

/*fallwind	2016.8.2	tpl_live_chat_service_phone_default.php*/
define('FS1_FIBERSTORE_CALL_BACK','Fiberstore Rückruf');

define('FS2_PLEASE_CALL','Rufen Sie bitte');

define('FS3_OR_LEAVE','Oder lassen Sie Ihre Kontaktinformationen unten, und wir rufen Sie zurück während 8 a.m.&ndash; 5 p.m PST von Montag bis Freitag.');

define('FS4_BACK','Zurück');

define('FS5_POST_YOUR_MESSAGE','Senden Ihre Nachricht erfolgreich an Fiberstore, Vielen Dank!');

define('FS6_ENTER_YOUR_NAME','Geben Ihren Namen ein:');

define('FS7_FILLED_IN_YOUR_NAME','Bitte stellen Sie sicher, dass Sie Ihren Namen ausgefüllt haben.');

define('FS8_EMAIL_ADDRESS','Ihre E-Mail-Adresse:');

define('FS9_FILLED_IN_EMAIL_ADDRESS','Bitte stellen Sie sicher, dass Sie die E-Mail-Adresse ausgefüllt haben.');

define('FS10_YOUR_COMPANY_NAME','Ihr Firmenname:');

define('FS11_YOUR_COUNTRY','Ihr Land:');

define('FS12_SELECT_YOUR_COUNTRY','Bitte stellen Sie sicher, dass Sie Ihr Land wählen.');

define('FS13_YOUR_TELEPHONE','Ihr Telefon:');

define('FS14_ENTER_A_VALID_PHONE_NUMBER','Bitte geben Sie eine gültige Telefonnummer ein.');

define('FS15_PHONE_NUMBER_MUST','Ihre Telefonnummer muss mindestens 7 Ziffern lang sein.');

define('FS16_BEST_TIME_TO_DIAL_BACK','Bestzeit zum Rückruf:');

define('DISCLAIMER_ORDERS','HAFTUNGSAUSSCHLUSS für internationale Bestellungen');
define('DISCLAIMER_ORDERS_CONMENT',"Importzölle , Steuern und Vermittlungsgebühren sind nicht im Produktpreis oder Versandkosten inbegriffen und es wird von den Trägern für bestimmte Pakete bei der Anlieferung erhoben werden. Da die Zollstelle die Zollgebühren bei den ankommenden Pakete zufällig durchführt, sind wir nicht in der Lage, es auf unserer Seite zu prognostizieren.<br />
            <br />
            Diese Gebühren sind die Verantwortung des Empfängers, da wir nur die Transportgebühr für die Pakete berechnen. Sie können mit dem Zollamt in Ihrem Land überprüfen, um festzustellen, was diese zusätzlichen Kosten sind.");
define('FREE_COLLECT','Unfrei');

//2016-8-3 frankie
define('MANAGE_ADDRESS_DEL','Löschen die Adresse erfolgreich!');
define('MANAGE_ADDRESS_DEFAULT','Als Standardadresse erfolgreich einstellen.');
define('MANAGE_ADDRESS_ADD','Adresse erfolgreich hinzufügen.');
define('MANAGE_ADDRESS_UPDATE','Adresse erfolgreich aktualisieren.');


//2016-8-4 frankie fiberstore_with_partner
define('FS_PARTNER','Weltweite Partnern von Fiberstore');
define('FS_THANKS','Fiberstore bedankt sich bei jedem Partner aus 50 Ländern auf der ganzen Welt.<br />
	Mit Ihrer Unterstützung wird Fiberstore Team immer mehr Vertrauen in Glasfaser- <br />Kommunikationsnetzen gewinnen.');
define('FS_CLOUDFLARE','Was ist CloudFlare?');
define('FS_CLOUDFLARE_IS','<b>CloudFlare</b> ist Hauptsitz in der Welt und bietet die Leistung und Sicherheit für jede Website.
		Hunderttausende von Websites verwenden CloudFlare. Sie arbeitet mit einem erheblichen Umfang, 
		Jeden Monat behandelt es mehr als eine Billion Anfragen durch ihr Netzwerk.');
define('FIBER_CHOOSE','Warum wählen Fiberstore?');
define('FS_CHOOSE_REASON','“ Obwohl 10Gbps Ethernet über Standard CAT5/6-Kabel laufen können, wählten wir, SFP+Steckverbinder zu verwenden.
		Wir wählen diese mit der Flexibilität zwischen den optischen (Faser) und Kupferverbindungen.
		Einige Netzwerkkarte und Switch-Anbietern codieren ihre Ausrüstung, nur proprietäre SFP+s zu unterstützen, So verkaufen sie sehr teuer.
		Wir verbrachten viel Zeit, eine Kombination von SFP-Anbieter zu testen, bevor wir <b>Fiberstore finden</b>, 
		ein SFP-Hersteller, von dem könnten wir SFP+s zu einem vernünftigen Preis direkt erhalten und arbeitete in der Netzwerkausrüstung, die wir verwenden wollten. ”');
define('FS_CEO','-- CloudFlare CEO');
define('FS_TO_CLOUDFLARE','Fiberstore zu CloudFlare');
define('FS_CLOUDFLARE_THANKS','“ Vielen Dank für hohe Wertschätzung von CloudFlare zu Fiberstore.
		Wir werden mehr leistungsfähigere Produkte betrachten und umfassenderen Service als Feedback zu Ihnen.
		Ich glaube, dass unsere Zusammenarbeit sich gegenseitig fördern wird, um eine höhere Ebene zu erreichen.
		Lassen Sie uns auf den Glanz in dem Gebiet der optischen Kommunikation freuen. ”');
define('FS_SERVICE_SAY','“ Wir möchten den Service von FiberStore. Wir haben die falschen Artikel aufgrund unserer Fehler bei der Beurteilung für ein dringendes Projekt bestellt, 
		FiberStore hilft uns, neu anordnen und versenden, den Artikel innerhalb kürzester Zeit aufzuholen. Es ist wunderbar. ”');
define('FS_SERVICE_TEAM','- IBM Research Team');
 define('FS_ENGINEER_SAY','“ Schätzen wir umfassendes technisches Netzwerk von Fiberstore，wir sind überrascht, dass sie nicht nur die perfekteste Lösung entwerfen,
		sondern sie auch die wirtschaftlichste Form wählen, das gleiche Ziel zu erreichen. ”');
define('FS_ENGINEER','- Norma Gudelj, Electrical Engineer, Raytheon');
define('FS_MANAGER_SAY','“ Großartiges Testergebnis der SFP-Transceiver, wir verwendeten kompatible Serie zum ersten Mal, seine 100%  Kompatibilität interessiert mich viel, 
		das ist das gleiche mit original, aber hat kostengünstiger Preis. ”');
define('FS_MANAGER','- Lab Manager, Dellteam');
define('FS_SUPPORT_SAY'," Dies ist der Anbieter mit den umfassendsten Produkte, die ich je gesehen habe, wir brauchen oft viele Arten von Produkten, ein Projekt zu beenden, 
		so bestellen wir in der Regel separat vor dem Treffen mit fiberstore,
		es dauerte viel Zeit.Die reichliche Serie ist der Hauptgrund für uns, ohne zu zögern, sie zu wählen. ");
//define('FS_PARTNER_SUPPORT','- Hyacinth Olih ,IT & IDC Support Engineer,China Telecom Global ');
define('FS_PURCHASE_SAY','“ Wenn wir eine einfache und schnelle Shopping-Plattform mit internationaler Präsenz brauchten, 
		wir sahen keine bessere Wahl als fiberstore, die Faser Networking-Baugruppen zu liefern, die wir brauchten. Ihre Produkte sind erstaunlich. ”');
define('FS_PURCHASE','- Purchase Manager, Google Fiber');
define('FS_INTEL_ENGINEER_SAY','“ Vielen Dank für die professionelle und hoch qualifizierte Weise, in der Sie Ihre Faseroptikbaugruppen implementieren. 
		Wir haben keine so makellose Vertrieb und Unterstützung in einer sehr langen Zeit. ”');
define('FS_INTEL_ENGINEER','- Steve Salter, Engineer, Intel');
define('FS_MARKETING_SAY','“ FiberStore Optik und Ihr Team haben unsere Netzwerkanforderungen eine ganz neue Bedeutung nehmen gelassen. 
		Ihre prompte, freundliche und auf den Punkt Service ließ Sie einen unverzichtbaren Verbündeten werden. ”');
define('FS_MARKETING','- Marketing, Sony');
define('FS_DEPARTMENT_SAY','“ Wir sind dankbar für Ihre schnelle Lieferung, die eine äußerst dringende Sache für uns gelöst haben.
		Ihre Produktionsfähigkeit überrascht mich.Ich muss meine Freunde sagen, dass Sie die beste Wahl in LWL-Bereiche sind. ”');
define('FS_DEPARTMENT','- Network support Department, Netflix ');
define('FIBERSTORE_YOUR_RECENT_HISTOR','Ihre zuletzt angesehenen Artikel');
//wholesale 2016-8-8 frankie

define('F_PARTNER_ACCOUNT','Haben Sie ein Geschäftskonto ?');
define('F_PARTNER_LOGIN','Einloggen in');
define('FS_ADD_TO_CART','Add to Cart');

//fallwind	2016.9.3	tpl_footer.php
define('FS_ABOUT_FS_COM','Über uns');	//About FS.COM
define('FS_OEM_CUSTOM','OEM & Custom');	//OEM Custom
define('FS_PAYMENT_METHODS','Zahlungsarten');	//Payment Methods
define('FS_CONTACT_US','Kontakt');	//Contact Us
define('FS_SITE_MAP','Sitemap');	//Site Map

define('FS_ISO_STANDARD','ISO Standard');	//ISO Standard
define('FS_FORGOT_YUOR_PASSWORD','Haben Sie Ihr Passwort vergessen?');	//Forgot Your Password?
define('FS_FULL_SITE','E-Mail senden');
define('FS_MOBILE_SITE','Mobile Site');

// Content  in  order page
//2016-9-8 add by  Frankie
define('ALL_ORDER','Alle Bestellungen');
define('UNPAID_ORDER','Ausstehende Bestellungen');
define('TRADING_ORDERS','Transaktionsaufträge');
define('CLOSED_ORDERS','Stornierten die Bestellungen');

define('FIBERSTORE_QUESTION','Fragen erfolgreich eingereicht');
define('FIBERSTORE_ORDER_PRIVATE','Privataufträge');
define('FIBERSTORE_ORDER_COMPANY','Alle Betriebsaufträge');
define('FIBERSTORE_ORDER_SELECT','Nach Bestelldatum suchen');
define('PLEASE','Bitte wählen Sie');
define('WEEK','Letzte Woche');
define('MONTH','Letzter Monat');
define('THREE_MONTH','Letzte drei Monate');
define('FIBERSTORE_ORDER_ENTER','Geben Sie Ihre Bestellnummer ein');
define('FIBERSTORE_ORDER_NO','Bestellnummer');
define('SEARCH','Suchen');
define('FIBERSTORE_ORDER_PROMT',' Kein Ergebnis');
define('FIBERSTORE_ORDER_PROMT2','Sie haben keine Bestellungen aufgegeben.');
define('FIBERSTORE_ORDER_PICTURE','Produktbild');
define('FIBERSTORE_ORDER_DATE','Bestelldatum');
define('CANCELED','Storniert');
define('FIBERSTORE_ORDER_OPERATE','Operieren');
define('PREVIOUS','Vorheriges');
define('NEXT','Nächst');
define('PAYMENT','Zahlung');
define('FIBERSTORE_ORDER_PAGE','Seite');
define('FIBERSTORE_ORDER_OF','von');
define('FS_LEARN_MORE','Mehr erfahren');
define('CONNECTING_PAYPAL','Verbindung zu Paypal');
define('ARE_YOU_SURE','Sind Sie sicher, diese Bestellung zu stornieren?');
define('ONCE_YOU_DO','Wenn Sie das mal gemacht haben, können Sie ihn nicht wieder finden.');
define('HOWEVER','Aber wenn Sie dazu entschlossen sind, geben Sie uns bitte einen Grund für das Stornieren der Bestellung');
define('EXPENSIVE','Teuere Versandgebühren');
define('DUPLICATE','Diese Bestellung noch einmal machen');
define('FAILING','Misslungene Zahlung');
define('WRONG','Falsche Information');
define('OUT','Ausverkauft');
define('NO_NEED','Nicht nötig');
define('OFFLINE','Offline Handel');
define('FIBERSTORE_ORDER_CONFIRM','Bestätigen');
define('OTHERS','Anderes');
define('BEFORE_SUBMITTING','Bitte füllen Sie die Gründe für das Stornieren der Bestellung aus, bevor Sie diese Bestellung einreichen');
define('CANCEL','Stornieren');

//fallwind	2016.9.9	add
define('FIBERSTORE_PROCESSING','Verarbeitung');
define('FIBERSTORE_LIVE_CHAT','Live-Chat');
define('FIBERSTORE_EDIT_CART','bearbeiten den Warenkorb');
define('FIBERSTORE_ALL_RIGHTS_RESERVED','Alle Rechte vorbehalten');
// 公用搜索、分类页面,公用常量，不要随意删除
define('FIBERSTORE_IMAGES','Bilder');
define('FIBERSTORE_DETAILS','Details');
define('FIBERSTORE_SHOWING','zeigen');
define('FIBERSTORE_RESULTS_BY',' Ergebnis von ');
define('FIBERSTORE_YOUR_PRICE','Ihr Preis');
define('FIBERSTORE_ADD_TO_CART','In den Warenkorb');
define('FIBERSTORE_QUANTITY','Menge');
define('FIBERSTORE_OF','');
define('FS_COMMON_CLEAR','Auswahl löschen');
define('FS_COMMON_COMPLIANT','Compliant with IEEE 802.3z standards for Fast Ethernet and Gigabit Ethernet applications');
define('FS_COMMON_ADD','hinzufügen');
define('FS_COMMON_ADDED','Hinzugefügt');
define('FS_COMMON_PROCESSING','Bearbeitet');
define('FS_COMMON_PLEASE_WAIT','Please wait');
define('FS_COMMON_PRODUCT','Sehen das Produkt schnell');
define('FS_COMMON_NEXT','Nächst');
define('FS_COMMON_PREVIOUS','Früher');
define('FS_PRICE_LOW_HIGH', 'Preis aufsteigend');
define('FS_PRICE_HIGH_LOW', 'Preis absteigend');
define('FS_RATE_HOGH', 'Bewertungen');
define('FS_NEWEST_FIRST', 'Neu eingetroffen');
define('FS_POPULARITY', 'Popularität');
define('FS_PROCESSING', 'Verarbeitung');
define('FS_WAIT', 'Bitte warten Sie');
define('FS_COMMON_EDIT','Bearbeiten');
define('FS_COMMON_LESS',"Verkürzen");
//update 2016.10.27 frankie
define('FS_QUICK_VIEW', 'Produkt schnell sehen');
define('FS_WAIT', 'Moment mal bitte');
//update 2016.12.5 frankie
define('FS_VERIFIED_PUR','Verifizierter Kauf');
define('FS_COMMENTS','Anmerkung');
define('FS_SUBMIT','Bestätigen');
define('FS_CANCEL','Stornieren');
define('FS_DELETE','Löschen');
define('FS_REVIEWS9','Per ');
define('FS_REVIEWS26',' auf ');

define('FS_REVIEWS10','Teilen');
define('FS_REVIEWS11','Bewerten');
/******************end 公用常量******************/


//ery	2016.9.22	checkout系列页面
define('FIBERSTORE_CART','Warenkorb');
define('FIBERSTORE_CHECKOUT','Kasse');
define('FIBERSTORE_SUCCESS','Erfolg');
define('FIBERSTORE_BILLING_ADDRESS','Rechnungsadresse');
define('FIBERSTORE_FIRST_NAME','Vorname');
define('FIBERSTORE_LAST_NAME','Nachname');
define('FIBERSTORE_STATE','Bundesland');
define('FIBERSTORE_PROVINCE','Provinz');
define('FIBERSTORE_REGION','Region');
define('FIBERSTORE_CITY','Stadt');
define('FIBERSTORE_TELEPHONE_NUMBER','Telefonnummer');
define('FIBERSTORE_POSTAL_CODE','Postleitzahl');


//frankie  stock_list
define('STOCK_LIST_FILTER','Filter');
define('STOCK_LIST_MODEL','Modell');
define('STOCK_LIST_DESCRIPTION','Beschreibung');
define('STOCK_LIST_PRICE','Preis');
define('STOCK_LIST_WUHAN','Stock');
define('STOCK_LIST_QUANTITY','Anzahl');
//评论相关页面编辑头像 2017.4.10  ery
define('FS_ADAPTER_TYPE', 'Typ des Adapters');
define('FS_TRANS_RELATED', 'Type');

define('FS_REVIEWS_REPLACE','Wechseln Sie das Benutzerbild');
define('FS_REVIEWS_EDIT','Edit Your Profile');
define('FS_REVIEWS_RECOMMENDED','Empfohlenes Benutzerbild');
define('FS_REVIEWS_LOCAL','Lokaler Upload');
define('FS_REVIEWS_ONLY','Nur unterstützt JPG, GIF, PNG, JPEG, BMP-Format, die Datei ist kleiner als 300KB');
define('FS_REVIEWS_SAVE','speichern');
//2017.6.9 add by frankie
define('FS_PANEL_REQUEST','Aufforderung A Zitat');
define('FS_PANEL_YOUR','Ihr Name');
define('FS_PANEL_PHONE','Telefonummer');
define('FS_PANEL_COUNTRY','Ihr Staat');
define('FS_PANEL_SEARCH','Suchen Sie bitte Ihren Staat');
define('FS_PANEL_EMAIL','Ihre Email Adresse');
define('FS_PANEL_COMMENTS','Kommentare/Antworten');
define('FS_PANEL_UPLOAD','Daten hochladen');
define('FS_PANEL_COMPLETE','Hochladen abgeschlossen!');
define('FS_PANEL_PLEASE','Bitte füllen Sie die korrekte Information aus!');

//2017.6.7 frankie  新增语言包
define('FS_THEA_CTUAL_SHIPPING_TIME','Die tatsächliche Versandzeit kann mit der geschätzten Zeit variieren. Sie hängt von der Bearbeitungszeit, dem Bestimmungsort, dem ausgewählten Versanddienst und Erhalt der gebuchten Zahlung.');

//账户中心相关页面公用向量   2017.5.12  ery  add
/*edit_my_account页面*/
define('ACCOUNT_MY_ACCOUNT','Mein Konto');
define('ACCOUNT_EDIT_ACCOUNT','Kontoeinstellungen');
define('ACCOUNT_EDIT_BELOW','Bitte bearbeiten Sie unten Ihre Informationen und klicken Sie dann auf den Update-Button, um die Änderungen zu speichern.');
define('ACCOUNT_EDIT_FOLLOW','Bitte überprüfen Sie folgende…');
define('ACCOUNT_EDIT_ACCOUNT_INFO','Kontoinformationen');
define('ACCOUNT_EDIT_UPDATE','Bestätigen');
define('ACCOUNT_EDIT_EMAIL','E-Mail-Adresse');
define('ACCOUNT_EDIT_NEW','Neues Passwort');
define('ACCOUNT_EDIT_REENTER','Passwort erneut eingeben');
define('ACCOUNT_EDIT_ADDRESS','Informationen der Adresse');
define('ACCOUNT_EDIT_FIRST','Vorname');
define('ACCOUNT_EDIT_LAST','Nachname');
define('ACCOUNT_EDIT_COMPANY','Name der Firma');
define('ACCOUNT_EDIT_STREET','Straße');
define('ACCOUNT_EDIT_LINE','Adresszusatz');
define('ACCOUNT_EDIT_POSTAL','Postleitzahl');
define('ACCOUNT_EDIT_CITY','Stadt');
define('ACCOUNT_EDIT_COUNTRY','Land/Region');
define('ACCOUNT_EDIT_STATE','Bundesland / Provinz / Region');
define('ACCOUNT_EDIT_PHONE','Telefonnummer');
define('ACCOUNT_EDIT_EMIAL_MSG','Die von Ihnen angegebene E-Mail Adresse wird nicht anerkannt.(zB.:someone@example.com).');
define('ACCOUNT_EDIT_PASS_MSG','Ihr Passwort muss mindestens 7 Schriftzeichens lang sein.');
define('ACCOUNT_EDIT_CONFIRM_MSG',"Das Bestätigungspasswort stimmt nicht mit dem neuen Passwort überein. Sie sollten identisch sein.");
define('ACCOUNT_EDIT_FIRST_MSG','Bitte geben Sie Ihren Vornamen ein.');
define('ACCOUNT_EDIT_LAST_MSG','Bitte geben Sie Ihren Nachnamen ein.');
define('ACCOUNT_EDIT_STREET_MSG','Bitte geben Sie Ihre Straße ein.');
define('ACCOUNT_EDIT_POSTAL_MSG','Bitte geben Sie Ihre Postleitzahl ein.');
define('ACCOUNT_EDIT_CITY_MSG','Bitte geben Sie Ihre Stadt ein.');
define('ACCOUNT_EDIT_COUNTRY_MSG','Bitte geben Sie Ihr Land ein.');
define('ACCOUNT_EDIT_STATE_MSG','Bitte geben Sie Ihr/e Bundesland / Provinz / Region ein.');
define('ACCOUNT_EDIT_PHONE_MSG','Bitte geben Sie Ihre Telefonnummer ein.');
define('ACCOUNT_EDIT_HEADER_OUR','Unser System hat bereits eine Aufzeichnung dieser E-Mail Adresse.');
define('ACCOUNT_EDIT_HEADER_EDIT','Nickname erfolgreich bearbeiten.');
define('ACCOUNT_EDIT_HEADER_FILE','Datei ist zu groß!');
define('ACCOUNT_EDIT_HEADER_CUSTOMER','Kundenfoto wird geändert.');
define('ACCOUNT_EDIT_HEADER_THANKS','Danke');
define('ACCOUNT_EDIT_HEADER_FS','Kundenservice von FS.COM');
define('ACCOUNT_EDIT_HEADER_INFO','FS.COM:Update der Kontoinformationen');
define('ACCOUNT_EDIT_HEADER_YOUR','Ihre Kontoinformationen von FS.COM wurden aktualisiert. Verweisen Sie bitte unten, um Ihre Kontoinformationen zu überprüfen');
/*my_questions和my_questions_details页面*/
define('FS_QUSTION','Fragen');
define('FS_QUSTI','Frage');
define('FS_QUSTION_TELL','Nennen Sie uns Ihre Probleme, dann werden wir unser Bestes tun, um Ihnen zu helfen.');
define('FS_QUSTION_ASK','Eine Frage stellen');
define('FS_DIALOG_ASK','Stellen ');
define('FS_QUSTION_DATE','Datum');
define('FS_QUSTION_STATUS','Status');
define('FS_QUSTION_VIEW','Meinung');
define('FS_QUSTION_REMOVE','Entfernen');
define('FS_QUSTION_ENTRIES','Einträge');
define('FS_QUSTION_NO','Kein Titel ausgefüllt.');
define('FS_QUSTION_ANSWERS','Antworten');
define('FS_QUSTION_REPLY','Fragen waren in Bearbeitung, Seien Sie bitte geduldig.');
define('FS_QUSTION_JS','Löschen Sie diese Informationen?');
/*manage_address页面*/
define('FS_ADDRESS_BOOK','Adressbuch');
define('FS_ADDRESS_NAME','Name');
define('FS_ADDRESS_COMPANY','Firma');
define('FS_ADDRESS_ADDRESS','Adresse');
define('FS_ADDRESS_NO','Keine Adresse gefunden');
define('FS_ADDRESS_DEFAULT','Standardadresse');
define('FS_ADDRESS_SET','Als Standard einsttellen');
define('FS_ADDRESS_EDIT','Bearbeiten');
define('FS_ADDRESS_CREATE','Adresse erstellen');
define('FS_ADDRESS_UPDATE','Adresseintrag aktualisieren');
define('FS_ADDRESS_PLEASE','Bitte füllen Sie dieses Formular aus, um diese Adresse zu bearbeiten, dann klicken Sie den Update-Botton.');

define('FS_ADDRESS_FIRST_REQUIRED_TIP','Ihr Vorname ist Pflichtfeld.');
define('FS_ADDRESS_FIRST_MSG','Ihr Vorname muss mindestens 2 Schriftzeichens enthalten.');

define('FS_ADDRESS_LAST_REQUIRED_TIP','Ihr Nachname ist Pflichtfeld.');
define('FS_ADDRESS_LAST_MSG','Ihr Nachname muss mindestens 2 Schriftzeichens enthalten.');

define('FS_ADDRESS_SORRY','Entschuldigung, Versandadresse ist erforderlich.');
define('FS_ADDRESS_STREET_FORMAT_TIP','Adresszeile 1 muss zwischen 4 und 35 Zeichen lang sein.');
define("FS_ADDRESS_STREET_PO_BOX_TIP","Wir liefern nicht an Postfächer");

define('FS_ADDRESS_POSTAL_REQUIRED_TIP','Ihre Postleitzahl ist Pflichtfeld.');
define('FS_ADDRESS_POSTAL_MSG','Ihre PLZ / Postleitzahl sollte mindestens 3 Schriftzeichens lang sein.');

define('FS_ADDRESS_PHONE_REQUIRED_TIP','Ihre Telefonnummer ist Pflichtfeld.');
define('FS_ADDRESS_COUNTRY_MSG','Ihr Land ist erforderlich.');

define('FS_ADDRESS_STATE_MSG','Ihr Bundesland ist erforderlich.');
define('FS_ADDRESS_PHONE_MSG','Ihre Telefonnummer muss mindestens 6 Ziffern sein.');

define('FS_ADDRESS_UP_ADDRESS','Die Adresse updaten');
define('FS_ADDRESS_NEW','Neue Adresse');
define('FS_ADDRESS_NEW_PLEASE','Bitte füllen Sie dieses Formular aus, um eine neue Adresse hinzufügen, dann klicken Sie den Hinzufügen-Botton.');
define('FS_ADDRESS_ADD','Adresse hinzufügen');
define('FS_ADDRESS_DELETE','Adresse erfolgreich löschen !');
define('FS_ADDRESS_SET_SUCCESS','Standardadresse erfolgreich einstellen !');
define('FS_ADDRESS_UP_SUCCESS','Adresse erfolgreich aktualisieren .');
define('FS_ADDRESS_ADD_SUCCESS','Adresse erfolgreich hinzufügen .');

//留言部分
define('MY_CASE_UPLOAD_1','Ihre Lösungsanfrage ');
define('MY_CASE_UPLOAD_2',' wurde gesendet.');
define('MY_CASE_UPLOAD_3','Hallo ');
define('MY_CASE_UPLOAD_4','Vielen Dank für die Kontaktaufnahme mit unserem Programmunterstützung-Team. Wir haben Ihre Anfrage erhalten. Die Nummer Ihrer Anfrage ist ');
define('MY_CASE_UPLOAD_5',' .');
define('MY_CASE_UPLOAD_6','Wir werden uns innerhalb von 24 Stunden bei Ihnen melden. Bitte überprüfen Sie Ihre E-Mail.');
define('MY_CASE_UPLOAD_7','Die folgenden Ressourcen können hilfreich für Sie sein: ');
define('MY_CASE_UPLOAD_8','https://www.fs.com/de/Data-Center-Cabling.html');
define('MY_CASE_UPLOAD_9','https://www.fs.com/de/Enterprise-Networks.html');
define('MY_CASE_UPLOAD_10','https://www.fs.com/de/Long-haul-Transmission.html');
define('MY_CASE_UPLOAD_11','https://www.fs.com/de/Optic-OEM-Solution.html');
define('MY_CASE_UPLOAD_12','Rechenzentrum-Verkabelung');
define('MY_CASE_UPLOAD_13','Unternehmensnetzwerk');
define('MY_CASE_UPLOAD_14','Fernübertragung');
define('MY_CASE_UPLOAD_15','Optische OEM-Lösung');
define('MY_CASE_UPLOAD_16','Mit freundlichen Grüßen');
define('MY_CASE_UPLOAD_17','https://www.fs.com/de/');
define('MY_CASE_UPLOAD_18','FS.COM');
define('MY_CASE_UPLOAD_19',' Programmunterstützung-Team');
define('MY_CASE_UPLOAD_20','FS.COM - Programmunterstützung & Anfrage-Nummer: ');
/*manage_order相关页面*/
define('MANAGE_ORDER_STATUS','Bestellstatus');
define('MANAGE_ORDER_ORDER','Bestellnummer:');
define('MANAGE_ORDER_SHIPMENT','Lieferung');
define('MANAGE_ORDER_INFORMATION','Bestellinformation');
define('MANAGE_ORDER_DATE','Bestelldatum');
define('MANAGE_ORDER_PAYMENT','Zahlungsart');
define('MANAGE_ORDER_SEE','Mehr anzeigen');
define('MANAGE_ORDER_PO','Auftragsnummer');
define('MANAGE_ORDER_RMA_NO','RMA-Nummer');
define('MANAGE_ORDER_TEL','Telefon');
define('MANAGE_ORDER_NOT','Noch nicht eingestellt');
define('MANAGE_ORDER_SHIPPING','Versandinformationen');
define('MANAGE_ORDER_PRODUCT','Produkt');
define('MANAGE_ORDER_ITEM','Artikelpreis');
define('MANAGE_ORDER_QUANTITY','Menge');
define('MANAGE_ORDER_TOTAL','Gesamtsumme');
define('MANAGE_ORDER_QTY','Menge');
define('MANAGE_ORDER_WRITE','Bewertung schreiben');
define('MANAGE_ORDER_PRINT','Rechnungen drucken');
define('MANAGE_ORDER_REORDER','Nachbestellen');
define('MANAGE_ORDER_TIME','Verarbeitungszeit');
define('MANAGE_ORDER_INFO','Prozessinformationen');
define('MANAGE_ORDER_OPERATOR','Prozessoperator');
define('MANAGE_ORDER_COMMODITY','Rohstoffverarbeitung');
define('MANAGE_ORDER_MSG','Ihre Bestellung wurde erfolgreich storniert.');
define('MANAGE_ORDER_ALL','Alle Zeiträume');
define('MANAGE_ORDER_PENDING','Ausstehende Bestellungen');
define('MANAGE_ORDER_COMPLETED','Abgeschlossene Bestellungen');
define('MANAGE_ORDER_CANCELLED','Stornierte Bestellungen');
define('MANAGE_ORDER_RMA','RMA');
define('MANAGE_ORDER_PLACED','Bestelldatum');
define('MANAGE_ORDER_SHIPING','Liefern an');
define('MANAGE_ORDER_DETAILS','Bestelldetails');
define('MANAGE_ORDER_INVOICE','Rechnung');
define('MANAGE_ORDER_DOWNLOAD_INVOICE','Rechnung herunterladen');
define('MANAGE_ORDER_BUY','Wieder kaufen');
define('MANAGE_ORDER_VIEW','Mehr Waren in Bestellung sehen');
define('MANAGE_ORDER_PAY','Jetzt bezahlen');
define('MANAGE_ORDER_CANCEL','Bestellung stornieren');
define('MANAGE_ORDER_RETURN','RMA beantragen');
define('MANAGE_ORDER_RESTORE','Bestellung wiederherstellen');
define('MANAGE_ORDER_MONTH','Spätestens 1 Monat');
define('MANAGE_ORDER_THREE_MONTHS','Spätestens 3 Monate');
define('MANAGE_ORDER_YEAR','Spätestens 1 Jahr');
define('MANAGE_ORDER_YEAR_AGO','Vor einem Jahr');
define('MANAGE_ORDER_NO','Bestellnummer');
define('MANAGE_ORDER_HEADER','Anforderung von Stornierung der Bestellung wurde erfolgreich eingereicht, warten Sie bitte auf Bearbeitung');
define('MANAGE_ORDER_EA','je Stk.');
/*sales_service页面*/
define('FS_SALES_CHOOSE','Wählen Sie die zurückzusendenden Artikel aus');
define('FS_SALES_ALL','Alle');
define('FS_SALES_RETURN','Rücksendung');
define('FS_SALES_CONTINUE','Fortsetzen');
define('FS_SALES_SELECT','Wählen Sie bitte Ihre Produkte aus');
define('FS_SALES_CONFIRM','Stornieren Sie die Bestellung?');
/*sales_service_info页面*/
define('FS_SALES_REASONS','RMA BESTÄTIGUNG');
define('FS_SALES_PLEASE','Wählen Sie bitte den Servicetyp.');
define('FS_SALES_REFUND','Rückgabe & Rückerstattung');
define('FS_SALES_REPLACE','Umtausch');
define('FS_SALES_MAINTENANCE','Reparatur');
define('FS_SALES_WHY','Warum retournieren Sie das Produkt?');
define('FS_SALES_NO','Nicht mehr benötigt');
define('FS_SALES_INCORRECT','Falsches Produkt oder Größe bestellen');
define('FS_SALES_MATCH',"Mit der Produktbeschreibung nicht übereinstimmen");
define('FS_SALES_DAMAGED','Beschädigt bei der Ankunft');
define('FS_SALES_RECEIVED','Falsche Artikel erhalten');
define('FS_SALES_NOT','Nicht wie erwartet');
define('FS_SALES_NO_REASON','Kein Grund');
define('FS_SALES_OTHER','Andere');
define('FS_SALES_COMMENTS','Inhalten (erforderlich)');
define('FS_SALES_NOTE','HINWEIS');
define('FS_SALES_WE',"Wir sind nicht in der Lage, politische Ausnahmen als Antwort auf Kommentare zu bieten");
define('FS_SALES_WRITE','Schreiben Sie bitte Ihre Probleme.');
define('FS_SALES_SUCCESSFUL','erfolgreich');
define('RMA_TRACK_STATUS','Status verfolgen');
define('RMA_SERVICE_TYPE','Service-Typ');
define('RMA_REASON','Gründe für Service');
/*sales_service_details*/
define('SALES_DETAILS_CONFIRM','Empfang bestätigen ');
define('SALES_DETAILS_RECEIPT','Empfangsbestätigung');
define('SALES_DETAILS_SUBMIT','Einreichen RMA Antrag');
define('SALES_DETAILS_REJECT','Abgelehnt');
define('SALES_DETAILS_APPROVED','Genehmigt');
define('SALES_DETAILS_RETURN','Rücksendung');
define('SALES_DETAILS_RMA','RMA Erhaltet');
define('SALES_DETAILS_NEW','Neuer Versand');
define('SALES_DETAILS_REFUND','Rückerstattung');
define('SALES_DETAILS_COMPLETE','Komplett');
define('SALES_DETAILS_SEND','Wie man ein Produkt zurückschickt ');
define('SALES_DETAILS_SEND_MSG',' Bitte folgen Sie unten Flußdiagramm, um Artikel zurückzugeben. Über "Erstellen des Versandetiketts", können Sie es auf Website eines Express-Unternehmens bekommen oder von einem Kurierort erhalten. Wenn Sie denken, dass das Versandetikett von FS.COM erstellt und bezahlt werden soll, rufen Sie bitte an +1 253 2773058 oder mailen service.us@fs.com.');
define('SALES_DETAILS_FROM','Rückkehr von');
define('SALES_DETAILS_EDIT','Bearbeiten');
define('SALES_DETAILS_DELIVER','Liefern an');
define('SALES_DETAILS_FILL','Füllen Sie den Luftfrachtbrief aus');
define('SALES_DETAILS_AWB','Bitte füllen Sie den Luftfrachtbrief aus, damit unsere Logistikabteilung zurückgesendet(e) Paket(e) verfolgt, sobald wir sie erhalten haben, werden Umtausch, Rückerstattung oder Wartung sofort bearbeitet.');
define('SALES_DETAILS_TRACKING','Trackingnummer');
define('SALES_DETAILS_PLEASE','Notieren Sie bitte die Trackingnummer.');
define('SALES_DETAILS_PRINT','RMA drucken');
define('SALES_DETAILS_PRINT_MSG','RMA kann uns helfen, Ihr Paket zu unterscheiden, um Ihre RMA-Anfrage zum nächsten Schritt schneller zu verarbeiten. Bitte drucken Sie es aus und fügen Sie es mit dem zurückgesandten Paket.');
define('SALES_DETAILS_STEP_CONFIRM','Adresse bestätigen');
define('SALES_DETAILS_STEP_PRINT','RMA-Formular drucken');
define('SALES_DETAILS_STEP_ATTACH','RMA-Formular anhängen');
define('SALES_DETAILS_STEP_CREATE','Versandetikett erstellen');
define('SALES_DETAILS_STEP_SHIP','Paket versenden');
define('SALES_DETAILS_CANCEL','Stornieren');

/*售后流程状态提示*/
define('SALES_MSG_APPROVED','Ihr RMA-Antrag wurde akzeptiert, schicken Sie uns Paket(e) zurück.');
define('SALES_MSG_SUBMIT','Ihr RMA-Antrag wurde eingereicht, warten Sie bitte auf Ergebnis der Überprüfung.');
define('SALES_MSG_RETURN','Vielen Dank für die Rücksendung von Paket an uns. Unsere Logistikabteilung werden auf den Versandstatus achten.');
define('SALES_MSG_COMPLETE','Die RMA ist abgeschlossen.');

//manage_orders & sales_service_list  2017.6.10		add 	ery
define('MANAGE_ORDER_SEARCH','Alle Bestellungen suchen');
define('MANAGE_ORDER_FILTER','Bestellungen filtern');
define('MANAGE_ORDER_BACK','Zurück');
define('MANAGE_ORDER_APPLY','Verwendung');
define('MANAGE_ORDER_TYPE','Typ der Bestellung');
define('MANAGE_ORDER_TIME_FILTER','Zeit filtern');

//2017.6.6		add		ery   manage_orders & account_history_info
define('F_RECEIPT_CONFIRMATION','Empfang bestätigen');
define('F_REFUNDED_PROCESSING','Bearbeitung der Rückerstattung');
define('MANAGE_ORDER_ARE','Sind Sie sicher, dass Sie die Artikel erhalten haben?');
define('MANAGE_ORDER_YES','Ja');
define('MANAGE_ORDER_JS_NO','Nein');
define('FIBERSTORE_REFUND','Bestätigung der Erstattung');
define('FIBERSTORE_ONCE_RECOVERED','Sobald es bestätigt ist, wird es nicht mehr wiederhergestellt werden.');
define('FIBERSTORE_PLEASE_KINDLY','Füllen Sie bitte die Gründe für die Stornierung der Bestellung aus, wenn Sie darauf bestehen.');

//2017.7.5. add by frankie
define('ACCOUNT_EDIT_SUCCESS','Erfolgreich');
define('FS_REMOVED_CART','wurde erfolgreich aus Ihrem Warenkorb entfernt');
define('FS_REMOVED','Entfernen');
define('FS_UPDATE','aktualisieren');
//2017.7.11  add by frankie
define('ACCOUNT_TOTAL','Zwischensumme');
define('ACCOUNT_OF_SHIPPING','(+)Versandkosten:');
define('ACCOUNT_OF_TOTAL','Gesamtsumme:');
define('ACCOUNT_OF_GSP_TOTAL_AU','Gesamtsumme inkl. GST');
define('FS_ORDERS_DETAILS_TAX_AU','Gesamt-GST');
//2017.8.3 add by frankie
define('TITLE_RELARED_DES',"Jeder Transceiver ist auf entsprechende Ausrüstung, wie Cisco, Arista, Juniper, Dell, Brocade und andere Marken individuell getestet und passt zu der Überwachung des intelligenten Qualitätskontrollsystems von Fiberstore.");
define('TITLE_RELARED_01','40GBASE-SR4 QSFP+ 850nm 150m MTP/MPO Transceiver für MMF');
define('TITLE_RELARED_02','QSFP28 100GBASE-SR4 850nm 100m Transceiver');
define('TITLE_RELARED_03','40GBASE-LR4 und OTU3 QSFP+ 1310nm 10km LC Transceiver für SMF');
define('TITLE_RELARED_04','QSFP28 100GBASE-LR4 1310nm 10km Transceiver');
define('TITLE_RELARED_05','Kompatible Marken');
//2017.8.15 add  全站通用常量
define('FS_SER_COMMON_EMALl','Sales@fs.com');
//2017.8.24  add  ery checkout页面地址公司类型
define('FS_CHECK_OUT_SELECT','Wählen Sie bitte aus');
define('FS_CHECK_OUT_BUSINESS','Geschäftskunde');
define('FS_CHECK_OUT_INDIVIDUAL','Privatkunde');
define("MANAGE_ORDER_VIEW_PO","Mein PO sehen");
define("MANAGE_PO_NUMBER","PO#");
//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS','UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS','UPS Express Next Day 12:00');
//2017.8.9 		add 	ery  税号
define('FS_VAT_PLEASE','Bitte geben Sie eine gültige USt-IdNr. ein.');
define('FS_VAT_NO','Keine USt-IdNr.');
define('FS_CHECK_OUT_STATE','Bundesland auswählen');
define('FS_CHECK_OUT_PLEASE','Ihr Land eingeben');
define('FS_CHECK_OUT_INVALID','Ungültige Telefonnummer, probieren Sie noch einmal.');
define('FS_CHECK_OUT_NEED','Hilfe brauchen');
define('FS_CHECK_OUT_LIVE','Live Chat');
define('FS_CHECK_OUT_EMAIL','Email schreiben');
define('FS_CHECK_OUT_TAX','MwSt.');
define('FS_CHECK_OUT_TAX_RU','MwSt. 20%');
define('FS_CHECK_OUT_TAX_CN','MwSt. 17%');
define('FS_CHECK_OUT_ORDER','Bestellzusammenfassung');
define('FS_CHECK_OUT_REMARKS','Bestellhinweis hinzufügen');
define('FS_CHECK_OUT_CHANGE','ändern');
define('FS_CHECK_OUT_ADD','Eine neue Adresse hinzufügen');
define('FS_CHECK_OUT_REVIEW','Produkte und Versandart sehen');
define('FS_CHECK_OUT_YOUR','Ihre Produkte');
define('FS_CHECK_OUT_ADDRESS','Ihre Adresse');
define('EMAIL_CHECKOUT_COMMON_VAT_COST','MwSt.');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2','MwSt.');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR','MwSt.');
define('FS_CHECK_OUT_INCLUDEING','(Inkl. MwSt.)');
define('FS_CHECK_OUT_EXCLUDING','(Exkl. Steuern)');

define('FS_CHECK_OUT_EXCLUDING_CA','(Die obige Summe enthält keine möglichen <a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">Steuern</a>)');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE','(Exkl. Steuern)');

define('FS_ADDRESS_INVOCE','Ich möchte die Bestellrechnung per E-Mail erhalten');
define('FS_LOADING','Wird geladen');
define('FS_CHECK_ADDRESS_TYPE',"Adresstyp");
define('FS_CHECK_OUT_ADTYPE_TIT',"Der Adresstyp ist Pflichtfeld");
define('FS_CHECK_OUT_COMPANY_TIT',"Name der Firma ist Pflichtfeld");
// add by aron 2017.7.17
define("MANAGE_ORDER_PURCHASE_ORDER",'Bestellung');
define("MANAGE_ORDER_UPLOAD_PO_FILE",'Auftragsdatei hochladen');
define("MANAGE_ORDER_UPLOAD_PURCHASE_ORDER",'Auftrag hochladen');
define("MANAGE_ORDER_UPLOAD_MESAAGE",'werden nicht versenden, bis das PO-Dokument erhalten haben. Hochladen Sie bitte das PO-Dokument innerhalb von 5 Tagen. Bestellung# in PO-DOkument enthalten.');
define("MANAGE_ORDER_UPLOAD_FILE_TEXT",' Dokument auswählen ');
define("MANAGE_ORDER_UPLOAD_ERROR","Unterstützte Dateitypen: PDF, JPG, PNG. Maximale Dateigröße: 4MB");
define("MANAGE_ORDER_UPLOAD_SUBMIT","Hochladen");
define("MANAGE_ORDER_UPLOAD_LABEL",'Dokument hochladen');

define('FS_DHLG','DHL Express deutschlandweit');
define('FS_DHLE','DHL Economy');
define('FS_DHLEE','DHL Express weltweit');
define('FS_WAREHOSE_CA_TIP','Kostenloser Versand bei Bestellung über US$ 79, die aus dem Warenlager in den U.S.A. versandt wird');
define('FS_WAREHOSE_EU_TIP','Kostenloser Versand bei Bestellung über 79,00 €, die aus dem Warenlager in Deutschland versandt wird');
define('FS_WAREHOSE_OTHER_TIP','FS.COM Multi-Warenlager-System sorgt für die schnellste Lieferung nach ');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 免运费提示信息（每个站点显示不一样。不是直接翻译的）
define('FS_HEADER_FREE_SHIPPING_US_TIP','Kostenloser Versand bei Bestellung von geeigneten Artikeln über USD $79');
define('FS_FOOTER_FREE_SHIPPING_US_TIP','Kostenloser Versand');
define('FS_HEADER_FREE_SHIPPING_DE_TIP','Kostenloser Versand bei Bestellung von geeigneten Artikeln über $MONEY');
define('FS_FOOTER_FREE_SHIPPING_DE_TIP','Kostenloser Versand');
define('FS_HEADER_FREE_SHIPPING_AU_TIP','Kostenloser Versand bei Bestellung von geeigneten Artikeln über A$99');
define('FS_FOOTER_FREE_SHIPPING_AU_TIP','Kostenloser Versand');
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP','Same Day Shipping on a Broad Selection of Stock Items');
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP','Same Day Shipping');

define('FS_M_FREE_SHIPPING_DE_TIP','Kostenloser Versand ab $MONEY');
define('FS_M_FREE_SHIPPING_AU_TIP','Kostenloser Versand ab A$99');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','Schneller Versand in');
define('FS_M_SHIPPING_US_TIP','Kostenloser Versand ab US$ 79');

//add  by  ery  2017-10-12    产品详情页stock list板块
define('FS_STOCK_LIST_OTHER_ID','Produkt-ID');
define('FS_STOCK_LIST_CENTER','Mittenwellenlänge (nm)');
define('FS_STOCK_LIST_CHANNEL','Kanal');
define('FS_STOCK_LIST_CWDM','CWDM SFP/SFP+');
define('FS_STOCK_LIST_DWDM','10G DWDM SFP+ 80km');
define('FS_DOWNLOAD','Herunterladen');
define('FS_DOWNLOADS', 'Downloads');
define('FS_STOCK_LIST','Lagerbestand');
define('FS_STOCK_LIST_RECOM','Passende Produkte');
define('FS_STOCK_LIST_ADD_TO_CART','In den Warenkorb hinzufügen');
define('FS_STOCK_LIST_PIC','Bilder');
define('FS_STOCK_LIST_ID','ID#');
define('FS_STOCK_LIST_DESC','Beschreibung');
define('FS_STOCK_LIST_PRICE','Preis');
define('FS_STOCK_LIST_STOCK','erhältlich');
define('FS_STOCK_OPTION','Option');
//2017.9.26  ery  add
define('FS_PRODUCT_INFO_PREIS','Preis: ');
define('FS_PRODUCT_INFO_TAX','(inkl. 19 % <a href="javascript:;" class="vat_info">MwSt</a>.)');
//2017-9-12  ery   add 层级属性定制提示语
define('PROINFO_CUSTOM_WAVE','Schreiben Sie andere Wellenlängen nach Ihren Bedürfnissen auf.');
define('PROINFO_CUSTOM_GRID','Schreiben Sie anderen Gitter-Kanal nach Ihren Bedürfnissen auf.');
define('PROINFO_CUSTOM_RATIO','Schreiben Sie anderes Kopplungsverhältnis nach Ihren Bedürfnissen auf.');
define('FS_WRITE_OTHER_DEVICES','z.B:Cisco N9K-C9396PX');
define('HPE_LIMIT', 'Bitte wählen Sie „VAL_XXX“-Kompatibilität für Ihre Bestellung aufgrund des speziellen Materials und schreiben Sie die Modellnummern auf.');
define('HPE_LIMIT2', 'Die Kompatibilität mit VAL_XXX ist aufgrund des speziellen Materials für Ihre Bestellung nicht verfügbar.');
define('model_number_empty','Bitte geben Sie die Modellnummer Ihres Geräts ein.');

//2017.10.12 add by  frankie 自提
define("CHECKOUT_ONESELF_PICH","Selbstabholung");
define('FIBER_CHECK_USE','Mein eigenes Versandkonto benutzen');
define('FIBER_CHECK_MORE','Mehr');
define('FIBER_CHECK_LESS','Verkürzen');
//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_INSTALLATION','Installation:');
define('FS_PRODUCT_INSTALLATION_TEXT','Geeignet für <a href="'.zen_href_link('product_info','products_id=30408','SSL').'" style="color: #0070BC;">FMU-1UFMX-N-Chassis</a>, das in einem Rack montiert wird');
define('FS_PRODUCT_INSTALLATION_TEXT2','Geeignet für ');
define('FS_PRODUCT_INSTALLATION_TEXT3','FMT04-CH1U-Chassis,');
define('FS_PRODUCT_INSTALLATION_TEXT4',' das in einem Rack montiert wird');
define('FS_PRODUCT_INSTALLATION_TEXT5','Die LGX-Kassette passt in ein <a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a>, das in einem Rack montiert werden kann');
//define('FS_PRODUCT_CUSTOMIZATION','Hinweis:');
//define('FS_PRODUCT_CUSTOMIZATION_TEXT','Typische Eingangsleistung=Ausgangsleistung-Verstärkung');
define('FS_PRODUCT_CUSTOMIZATION_TEXT','FMU Einsteckmodul passt auf ein ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1','FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2','Steckbares Modul passt auf ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3','FUD Einsteckmodul passt auf ein ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4','FMU-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5',' Gehäuse, das auf einem Rack montiert werden kann');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6','FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7','Plug-in Typ passt auf ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8','FS-2U-RC001');
define('FS_PRODUCT_ITEM','Artikelnummer: ');
//2017-11-2   add  ery  国家下拉框搜索提示语
define('FS_COUNTRY_SEARCH','Land/Region suchen');

//2017.11.28 dylan 产品详情页图标描述
define('PRO_AUTHENTICATION_ICON_PLEASE','Für weitere Informationen können Sie <a href="'.zen_href_link('contact_us').'" target="_blank">uns kontaktieren</a>.');
define('PRO_AUTHENTICATION_ICON_01','Dieses Produkt erfüllt die geltenden Anforderungen der Richtlinie (EU) 2015/863 von RoHS, die die Verwendung von 10 gefährlichen Materialien bei der Herstellung elektronischer und elektrischer Geräte beschränkt: Blei, Quecksilber, Cadmium, sechswertigem Chrom, polybromierter Biphenyle, polybromierter Diphenylether und vier verschiedenen Phthalaten.');
define('PRO_AUTHENTICATION_ICON_02','Das Produkt bietet die lebenslange Garantie an, die unsere größte Aufrichtigkeit reflektiert. ');
define('PRO_AUTHENTICATION_ICON_03','Das Produkt ist in Übereinstimmung mit ISO9001. Das System gilt für ein Unternehmen, das sich mit Entwicklung, Produktion und Lieferung von faseroptischen Produkten befasst. ');
define('PRO_AUTHENTICATION_ICON_04','Das Produkt wurde gemäß den Anforderungen von CE hergestellt, um die Übereinstimmung mit der grundlegenden Gesundheit und Sicherheit anzuzeigen. ');
define('PRO_AUTHENTICATION_ICON_05','Das Produkt stimmt vollständig mit dem FCC überein, was darauf abzielt, die Funkwellen und Magnetfelder vernünftiger zu verwalten. ');
define('PRO_AUTHENTICATION_ICON_06','FDA ist für die Regulierung von strahlungsemittierenden elektronischen Produkten zuständig. Es schützt der Bevölkerung vor gefährlicher und unnötiger Strahlenbelastung aus elektronische Produkte. ');
define('PRO_AUTHENTICATION_LEARN','um mehr zu erfahren.');
//new
define('PRO_AUTHENTICATION_ICON_07','Dieses Produkt entspricht vollständig der ETL, was die Komformität mit den relevanten Industriestandards für jedes elektrische oder mechanische Produkt anzeigt.  ');
define('PRO_AUTHENTICATION_ICON_08','Dieses Produkt wurde unter den Anforderungen von UL für globale Sicherheitsberatung und -zertifizierung hergestellt.  ');
define('PRO_AUTHENTICATION_ICON_09','CB ist ein von IECEE betriebenes internationales System. Dieses Produkt entspricht der IEC-Normen, mit denen die Sicherheitsleistung elektrischer Produkte gerüft wird. ');
//
define('PRO_AUTHENTICATION_ICON_10','REACH ist eine Verordnung der Europäischen Union, die zur Verbesserung des Schutzes der menschlichen Gesundheit und der Umwelt durch eine bessere und frühere Ermittlung der inhärenten Eigenschaften chemischer Stoffe erlassen wurde. ');
define('PRO_AUTHENTICATION_ICON_11','Dieses Produkt ist RCM-konform, was die Komformität mit den gesetzlichen Anforderungun an elektrische Sicherheit, EMV, EME und Telekommunikationen anzeigt. ');
define('PRO_AUTHENTICATION_ICON_12', 'Dieses Produkt entspricht voll und ganz der WEEE, einer Umweltvorschrift der Europäischen Union zur Verbesserung der Sammlung, Entsorgung und des Recyclings von Produkten, wenn diese verschrottet werden. ');
define('PRO_AUTHENTICATION_ICON_13', 'Dieses Produkt erfüllt die 3C-Zertifizierung, die von der Regierung eingeführt wurde, um die persönliche Sicherheit der Verbraucher sowie die nationale Sicherheit zu schützen und das Produktqualitätsmanagement in Übereinstimmung mit den Gesetzen und Vorschriften zur Umsetzung eines Bewertungssystems für die Produktkonformität zu verbessern. ');
define('PRO_AUTHENTICATION_ICON_14', 'Das VCCI-Zeichen (Voluntary Control Council for Interference) ist eine obligatorische Zertifizierung für Multimedia-Geräte (MME) in Japan, insbesondere für IT-Geräte. Dieses Produkt ist vollständig mit der japanischen VCCI-Zertifizierung konform. ');
define('PRO_AUTHENTICATION_ICON_15', 'TELEC ist die obligatorische Zertifizierung von drahtlosen Produkten in Japan, auch MIC-Zertifizierung genannt. Dieses Produkt erfüllt die TELEC-Zertifizierung, die für drahtlose Produkte (Bluetooth-Produkte, Mobiltelefone, WIFI-Router, Drohnen usw.) erforderlich ist, die nach Japan exportiert werden. ');
define('PRO_AUTHENTICATION_ICON_16', 'Dieses Produkt ist konform mit ISO14001. Diese Zertifizierung richtet sich an Organisationen, die ihre Umweltverantwortung systematisch managen wollen, um einen Beitrag zur ökologischen Nachhaltigkeit zu leisten. ');
define('PRO_AUTHENTICATION_ICON_17', 'Dieses Produkt entspricht voll und ganz dem russischen TR CU-Zertifikat (EAC-Zertifikat), das die Einhaltung der Standards der Mitgliedsländer der Zollunion sowie der Qualitäts- und Sicherheitsanforderungen anzeigt. ');
define('PRO_AUTHENTICATION_ICON_18', 'Dieses Produkt entspricht vollständig den Sicherheitsanforderungen von UL (Underwriters Laboratories Inc.). ');
//2017-12-2  add   ery  产品无库存是的提示语
define('FS_PRODUCTS_CUSTOMIZED','erhältlich');
define('FS_COMMON_LEVEL_WAS','war');
//2017-12-13  add  ery 公用的tt账号语言包
define('FS_COMMON_TT_BANK','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Name der Bank: </td>
							<td><b>Sparkasse Freising</b></td>
						  </tr>
						  <tr>
							<td>Empfänger: </td>
							<td><b>FS.COM GmbH</b></td>
						  </tr>
						  <tr>
							<td>IBAN: </td>
							<td><b>DE16 7005 1003 0025 6748 88</b></td>
						  </tr>
						  <tr>
							<td>BIC: </td>
							<td><b>BYLADEM1FSI</b></td>
						  </tr>
						  <tr>
							<td>Konto-Nr.: </td>
							<td><b>25674888</b></td>
						  </tr>
					  </table>');
//2017-12-14  ery  add  manage_orders和account_history_info页面reorder提示语
define('FS_COMMON_REORDER_CLOSE','Entschuldigung, der folgende Artikel wurde möglicherweise entfernt und ist zurzeit nicht erhältlich bei uns.');
define('FS_COMMON_REORDER_CUSTOM','Der folgende Artikel ist individuell. Bitte wählen Sie die Parameter erneut aus.');
define('FS_COMMON_REORDER_SKIP','Übergehen und fortsetzen');

define("FS_POPUP_TIT_ALERT","Für die Lieferung ist eine Unterschrift erforderlich. Wir liefern nicht an Postfächer.");
define("FS_POPUP_TIT_ALERT_NOT_PO","Für die Lieferung ist eine Unterschrift erforderlich.");
define("FS_POPUP_TIT_ALERT2","Wir liefern nicht an Postfächer");

//2017-12-15  ery  add  前台相关打印发票页面的公司地址
// 武汉仓
define('FS_COMMON_WAREHOUSE_CN','Empfänger: FS. COM LIMITED<br> 
			Adresse: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China<br>
			Tel.: +86-0755-83571351');
define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> China');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany<br>
			Tel.: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States <br>
			Tel: +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','Empfänger: FS.COM Inc.<br>
					Adresse: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States<br>
					Tel.: +1 (888) 468 7419');
// 澳洲仓
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Tel: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: (65) 6443 7951<br>
				GST-Reg.-Nr.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','Empfänger: FS Tech Pte Ltd.<br>
				Adresse: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel.: +(65) 6443 7951');
define("QTY_SHOW_ZERO","Stk. auf");
define("QTY_SHOW_MORE","Stk. auf");
define("QTY_SHOW_NEW","Stk.");
define("QTY_SHOW_ZERO_STOCK","Stk.");
define("QTY_SHOW_MORE_STOCK","Stk.");
define("QTY_SHOW_ZERO_STOCK_1"," Stk. auf Lager");
define("QTY_SHOW_MORE_STOCK_2"," Stk. auf Lager");
define("QTY_SHOW_AVAILABLE","erhältlich");
define('QTY_SHOW_IN_CN_STOCK_1','Auf Lager');
//add by quest 2019-03-08
define("QTY_SHOW_AVAILABLE_NEW_INFO","Auf dem Transport");
define("QTY_SHOW_AVAILABLE_TAG_NEW_INFO","Transport erforderlich");

define("QTY_SHOW_ZERO3","Stk. in");
define("CHECKOUT_EIDT_TIT_FS","* Bitte bearbeiten und aktualisieren Sie Ihre Adresse");
define("CHECKOUT_EIDT_TIT_FS1","Bitte bearbeiten Sie Ihre Lieferadresse");
define("CHECKOUT_EIDT_TIT_FS2","Bitte bearbeiten Sie Ihre Rechnungsadresse");
define("CHECKOUT_EIDT_TIT_FS3","* Bitte bearbeiten und aktualisieren Sie Ihre Rechnungsadresse");


//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","Vielen Dank für Ihren Einkauf bei");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","Live Chat");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH","mit Berater");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","​Mit freundlichen Grüßen");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","Hallo");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","Kundenservice-Team ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","Lieferadresse: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","Wenn Sie irgendwelche Fragen zu Ihrer Bestellung haben, zögern Sie nicht, uns zu ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","Ihr Kaufauftrag");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","wurde erfolgreich hochgeladen.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","Vielen Dank für Ihren Einkauf bei FS.COM. Sie können jetzt die Bestellung ansehen und die Rechnung in");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","Meine Bestellungen");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","ausdrucken.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","Versandkosten");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","Endsumme");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","Zwischensumme");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","Ihre Bestellung wird sofort bearbeitet. Wenn Sie irgendwelche Fragen haben, zögern Sie nicht");




define("FS_WAREHOUSE_AREA_SG","Versand aus dem Lager in Singapur");
define("FS_WAREHOUSE_AREA_PR",'Versand von FS USA');
//分仓分库语言包
define("FS_WAREHOUSE_AREA_1"," Versand aus dem Lager in Asien");
define("FS_WAREHOUSE_AREA_2"," Versand aus dem Lager in den USA");
define("FS_WAREHOUSE_AREA_3","Versand aus dem Lager in Deutschland");
define("FS_WAREHOUSE_AREA_4","- sofort lieferbar");
define("FS_WAREHOUSE_AREA_5","- erhältlich, versandfertig am ");
define("FS_WAREHOUSE_AREA_6","Nach dem Lagerbestand werden Ihre bestellte Artikel in ");
define("FS_WAREHOUSE_AREA_7","Paketen aufgeteilt. ");
define("FS_WAREHOUSE_AREA_8","Artikel");
define("FS_WAREHOUSE_AREA_9","Stückpreis");
define("FS_WAREHOUSE_AREA_10","Menge");
define("FS_WAREHOUSE_AREA_11","Stückpreis");
define("FS_WAREHOUSE_AREA_12","Bitte gehen Sie auf die Seite '");
define("FS_WAREHOUSE_AREA_13","Meine Bestellungen,");
define("FS_WAREHOUSE_AREA_14","' um die Kaufauftrag-Datei hochzuladen, falls Sie dies noch nicht getan haben. Wir können Ihre Bestellung nicht bearbeiten, bis Ihren Kaufauftrag bestätigt wurde.");
define("FS_WAREHOUSE_AREA_15","Vielen Dank für Ihren Einkauf bei ");
define("FS_WAREHOUSE_AREA_16",". Wir haben Ihre Bestellung erhalten und warten auf die Zahlungsbestätigung.");
define("FS_WAREHOUSE_AREA_17","Vielen Dank für Ihren Einkauf bei FS.COM. Wir erhalten Ihre Bestellung und warten auf die Zahlungsbestätigung. ");
define("FS_WAREHOUSE_AREA_18","Vielen Dank für Ihren Einkauf bei FS.COM. Ihre Bestellung");
define("FS_WAREHOUSE_AREA_19"," bei ");
define("FS_WAREHOUSE_AREA_20"," wurde erhalten. Aber die Bestellung ist noch nicht bezahlt. Wenn Sie diese Waren noch kaufen möchten, könnten Sie die Zahlung direkt an das Paypal-Konto unseres Unternehmens senden: paypal@fs.com.");
define("FS_WAREHOUSE_AREA_21","Wenn Sie Fragen zur Zahlung per PayPal haben, kontaktieren Sie uns bitte unter ");
define("FS_WAREHOUSE_AREA_22","Noch nicht eingestellt");
define("FS_WAREHOUSE_AREA_23","Bestellung erhalten, auf Zahlungsbestätigung warten");
define("FS_WAREHOUSE_AREA_24","wurde erhalten, auf Zahlungsbestätigung warten.");
define("FS_WAREHOUSE_AREA_25","Wenn Sie Fragen zur Zahlung per Kredit-/Debitkarte haben, kontaktieren Sie uns bitte unter");
define("FS_WAREHOUSE_AREA_26","Bestellung erhalten, auf Zahlungsbestätigung warten");
define("FS_WAREHOUSE_AREA_27","Wenn Sie Fragen zur");
define("FS_WAREHOUSE_AREA_28","kontaktieren Sie uns bitte unter");
define("FS_WAREHOUSE_AREA_29","Bestellnummer:");
define("FS_WAREHOUSE_AREA_30","Versandart:");
define("FS_WAREHOUSE_AREA_31","Bestellung bei FS.COM...");

/*结算页交期气泡提示语*/
define("FS_WAREHOUSE_AREA_TIME_36","Der Versand hat sich aufgrund des Feiertags in den USA verzögert.");
define("FS_WAREHOUSE_AREA_TIME_37","Der Versand hat sich aufgrund des Feiertags in Australien verzögert.");
define("FS_WAREHOUSE_AREA_TIME_38","Der Versand hat sich aufgrund des Feiertags in Deutschland verzögert.");
define("FS_WAREHOUSE_AREA_TIME_39","Der Versand hat sich aufgrund des Feiertags in Singapur verzögert.");
define("FS_WAREHOUSE_AREA_TIME_42","Der Versand hat sich aufgrund des Feiertags in China verzögert.");
define("FS_WAREHOUSE_AREA_TIME_40","Der Versand hat sich aufgrund des Wochenendes verzögert.");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">Schließen</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","Abholung zur gewünschten Zeit im Lager in den USA");
define("FS_WAREHOUSE_AREA_TIME_44","Abholung zur gewünschten Zeit im Lager in Deutschland");
define("FS_WAREHOUSE_AREA_TIME_45","Abholung zur gewünschten Zeit im Lager in Australien");
define("FS_WAREHOUSE_AREA_TIME_46","Abholung zur gewünschten Zeit im Lager in Asien");
define("FS_WAREHOUSE_AREA_TIME_47","Abholung zur gewünschten Zeit im Lager in Singapur");
define("FS_WAREHOUSE_AREA_SHIP_CN"," aus dem Lager in Asien");
define("FS_WAREHOUSE_AREA_SHIP_US"," aus dem Lager in den USA");
define("FS_WAREHOUSE_AREA_SHIP_AU"," aus dem Lager in Australien");
define("FS_WAREHOUSE_AREA_SHIP_DE"," aus dem Lager in Deutschland");
define("FS_WAREHOUSE_AREA_SHIP_SG"," aus dem Lager in Singapur");
define("FS_PICK_UP_WAREHOUSE", "Selbstabholung im Lager");
//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Hier ist Ihre Zahlungsinformationen.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Wir haben Ihren Betrag für die Bestellung erhalten ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',' Vielen Dank für Ihren Einkauf bei uns.');
define('FIBER_CHECK_TWO','UPS 2 Werktage');
define('FIBER_CHECK_TWO_AM','UPS 2 Werktage');
define('FIBER_CHECK_STAND','UPS Ground<sup>®</sup> ');
define('FIBER_CHECK_ONE','UPS 1 Werktag');
define('FIBER_FEDEX_CHECK_OVER','FedEX 1 Werktag');
define('FIBER_FEDEX_CHECK_TWO','FedEX 2 Werktage');

define('FIBER_FEDEX_CHECK_GROUND','FedEX Ground<sup>®</sup> ');
define('FIBER_CHECK_USE','Benutze mein eigenes Versandkonto');
define('FIBER_CHECK_FREE','Kostenfrei');
define('FIBER_CHECK_FREE_SHIPPING','Kostenlos');
define("FS_WAREHOUSE_AREA_32","Vielen Dank für Ihren Kaufauftrag. Hier sind Ihre Bestelldaten. Es wartet jetzt auf die Bestellbestätigung.");
define("FS_WAREHOUSE_AREA_33","Vielen Dank für Ihre Purchase Order! Hier sind Ihre Bestelldaten.</br>Hinweis: Die Lieferadresse stimmt nicht mit den Adressen auf Ihrem Kreditantragsformular überein. Diese Bestellung muss überprüft werden und das Ergebnis wird innerhalb von 12 Stunden per E-Mail an Sie gesandt.");
define("FS_WAREHOUSE_AREA_34",'Vielen Dank für Ihre Purchase Order! Hier sind Ihre Bestelldaten.</br>Hinweis: Die Lieferadresse stimmt nicht mit den Adressen in Ihrem Kreditantragsformular überein und der Bestellbetrag übersteigt Ihr Kreditlimit bei FS.COM. Um diese Bestellung schnell zu bearbeiten, zahlen Sie bitte die vorherigen Bestellungen aus, um das Kreditlimit wiederzuherstellen, oder gehen Sie zu "Mein Konto" und klicken auf "Purchase Order", um Ihr Kreditlimit zu erhöhen. Das Ergebnis wird innerhalb per E-Mail an Sie gesandt.');
define("FS_WAREHOUSE_AREA_35",'Vielen Dank für Ihre Purchase Order! Hier sind Ihre Bestelldaten.</br>Hinweis: Der Bestellbetrag übersteigt Ihr Kreditlimit bei FS.COM. Um diese Bestellung schnell zu bearbeiten, zahlen Sie bitte die vorherigen Bestellungen aus, um das Kreditlimit wiederzuherstellen, oder gehen Sie zu "Mein Konto" und klicken auf "Purchase Order", um Ihr Kreditlimit zu erhöhen. Das Ergebnis wird innerhalb per E-Mail an Sie gesandt.');

define('EMAIL_CHECKOUT_PAYPAL_TEXT1','Wir erhalten Ihre Bestellung und warten auf die Zahlungsbestätigung');
define('EMAIL_CHECKOUT_PAYPAL_TEXT2','Vielen Dank für Ihren Einkauf bei ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT3','FS.COM');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4','. Im Folgenden finden Sie die Bestellinformationen Ihrer letzten Bestellung. Die Bestellung wartet auf Ihre Zahlungsbestätigung.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4_1','. Im Folgenden finden Sie die Bestellinformationen Ihrer letzten Bestellung. Die Bestellung wartet auf Ihre Zahlungsbestätigung.');
define('EMAIL_CHECKOUT_PAYPAL_TEXT5','Erwartete Lieferzeit');
define('EMAIL_CHECKOUT_PAYPAL_TEXT6','Wenn Sie irgendwelche Fragen zu Ihrer Bestellung haben, zögern Sie nicht, ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT7',' kontaktieren');
define('EMAIL_CHECKOUT_PAYPAL_TEXT8',' Kundenservice-Team ');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - Bestellung %s');


define("FS_IN_STOCK","auf Lager");
define('FS_SUCCESS_METHOD','Versandart');
define('FS_SUCCESS_DELIVERY','Erwartete Lieferzeit');
define('FS_SUCCESS_SHIP_FROM','Versand aus');
define('FS_SUCCESS_ORDER_DINGDAN','Bestellnummer #');
define('FS_SUCCESS_ORDER_QUESTION','Bei Fragen rufen Sie uns bitte +49 (0) 89 4141 76412 an oder kontaktieren Sie uns unter der E-Mail Adresse');

define("FS_WAREHOUSE_EU","in Deutschland");
define("FS_WAREHOUSE_US","in den USA");
define("FS_WAREHOUSE_CN","China");
define("FS_W_DE","in Deutschland");
define("FS_W_US","in U.S.");
define("FS_W_CN","in CN");

define("FS_CANLED_CK","stornieren");
define("FS_SAVE_CK","speichern");
define("FS_ITEMS_CK","Ihr(e) Artikel");
define("FS_QUANITY_CK","Menge");
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Hier ist Ihre Zahlungsinformationen.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Wir haben Ihren Betrag für die Bestellung erhalten ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',' Vielen Dank für Ihren Einkauf bei uns.');

//再次付款
/**************************html_checkout_payment_against_paypal.php**************************/
define('FS_AGAINST_PROCEED','Weiter zu PayPal');
/************************** add by Aron html_checkout_gloabal**************************/
define("GLOBAL_FIRSTNAME","Vorname");
define("GLOBAL_LASTNAME","Nachname");
define("GLOBAL_ADDRESS1","Adresszeile 1");
define("GLOBAL_ADDRESS2","Adresszeile 2(wahlfrei)");
define("GLOBAL_POSTAL","Postleitzahl");
define("GLOBAL_CITY","Stadt");
define("GLOBAL_COUNTRY","Land/Region");
define("GLOBAL_PHONE","Telefonnummer");
define("GLOBAL_STATE","Bundesland/Provinz/Region");
define("GLOABL_VAT","USt-IdNr.");
define("GLOABL_COMPANY","Name der Firma");
define("GLOABL_ADRESSTYPE","Geschäftskunde/Privatkunde");
define("GLOABL_CART","Einkaufswagen");
define("GLOABL_EDIT_BILLING","Bitte bearbeiten Sie Ihre Rechnungsadresse");
define("GLOABL_CHECK_FOLLOWING","Bitte überprüfen Sie die folgende Informationen…");
define("GLOABL_CHECKETOUT","Zur Kasse");
define("GLOABL_SUCCESS","Erfolgreich");
define("GLOABL_LIVECHAT","Live Chat");
define("GLOBAL_TEXT1","Wenn Sie Fragen zur Zahlung haben, kontaktieren Sie bitte Ihren zuständigen Vertriebsmitarbeiter. ");
define("GLOBAL_TEXT2","Die Zahlung wurde abgelehnt. Bitte verwenden Sie eine andere Kreditkarte oder ändern Sie die Zahlungsmethode auf PayPal oder Überweisung.");
define("GLOBAL_TEXT3","Bitte stellen Sie sicher, dass die unten angegebene Rechnungsadresse mit dem Namen und der Adresse übereinstimmt, die mit der Kreditkarte für diesen Kauf verknüpft sind. Bitte beachten Sie, dass Ihr Land in Rechnungsadresse und Lieferadresse muss gleich sein. ");

define("GLOBAL_TEXT4","Zahlung per Kredit- oder Debitkarte");
define("GLOBAL_TEXT5","Wir akzeptieren folgende Kredit- und Debitkarten. Bitte wählen Sie einen Kartentyp aus, füllen Sie die Informationen unten aus und klicken Sie auf Weiter.
         (Hinweis: Aus Sicherheitsgründen werden wir keinesfalls Ihre Kreditkartendaten speichern.)");

define("GLOBAL_TEXT6","Wählen Sie Kredit-/Debitkarte aus:");

define("GLOBAL_TEXT7","Bestellzusammenfassung");
define("GLOBAL_TEXT8","Bestellnummer:");
define("GLOBAL_TEXT9","Brauchen Sie Hilfe? ");
define("GLOBAL_TEXT10"," Bitte schauen Sie unsere Hilfeseite oder  ");
define("GLOBAL_TEXT11"," Rechnungsadresse  ");
define("GLOBAL_TEXT12","ändern");
define("GLOBAL_TEXT13","Kreditkartennummer");
define("GLOBAL_TEXT14","Ablaufdatum");
define("GLOBAL_TEXT15","Monat");
define("GLOBAL_TEXT16","Jahr");
define("GLOBAL_TEXT17","Sicherheitscode");
define("ADDRESS_TYPE1","Geschäftskunde");
define("ADDRESS_TYPE2","Privatkunde");
define("CHECKOUT_PLEASE1","wählen Sie bitte aus");
define("GLOABL_VAT_PLEASE2","Gültige USt-IdNr. z.B.:DE123456789");
define("ADDRESS_TYPE_TIT1","Der Adresstyp darf nicht leer sein");
define("ADDRESS_TYPE_TIT2","Der Name der Firma darf nicht leer sein");
define('FS_SUCCESS_ORDER_DINGDAN','Bestellnummer');
define("FS_QUESTION","Wenn Sie irgendwelche Frage haben, rufen Sie uns unter");
define("FS_EMAIL_US","an oder kontaktieren Sie uns per E-Mail an");
define("FS_NOT_NULL","Kaufauftrag-Nummer darf nicht leer sein");
define("FS_SYSTEM_ERROR_TIT","Wenn Sie Fragen zur Zahlung haben, kontaktieren Sie bitte Ihren zuständigen Vertriebsmitarbeiter.");

define('EMAIL_CHECKOUT_SUCCESS_YOUR',' Hier sind Ihre Zahlungsinformationen.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Wir haben Ihren Betrag für Bestellung ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',' erhalten. Vielen Dank für Ihren Einkauf bei uns.');


//2018 1-9.aRON 游客邮件
define("FS_GUEST_EMAIL_THANK","als Gast");
define("FS_GUEST_EMAIL_CONTACT","Wir werden Ihren Bestellstatus an diese E-Mail senden. Wenn Sie irgendwelche Fragen zu Ihrer Bestellung haben, zögern Sie nicht uns zu ");

define("CHECKOUT_TAXE_US_TIT","Über Umsatzsteuer & Über Zoll und Steuern");
define("CHECKOUT_TAXE_US_FRONT","Wenn die Artikel aus unserem Lagerhaus in den USA an eine Lieferadresse innerhalb des Staates Washington versandt werden, wird gemäß den Steuergesetzen des Staates Washington eine Umsatzsteuer von 10% erhoben. Wenn Sie jedoch eine gültige Steuerbefreiungsbescheinigung für das Land vorlegen können, in dem Sie ansässig sind, wird keine Umsatzsteuer erhoben. Artikel, die nach Kanada und Mexiko geliefert werden, sind umsatzsteuerfrei. Aber der Käufer ist für die Zollabfertigung und die Zollsteuer verantwortlich. Bei einer Online-Bestellung berechnen wir nur die Versandkosten und schließen den Tarif von der Gesamtsumme der Bestellung aus (FS.COM Standard). Bei Bedarf hilft FS.COM bei der Vorauszahlung der Zollsteuer.");
define("CHECKOUT_TAXE_US_BACK","Für den Versand von CN Lagerhaus berechnet FS.COM nur die Artikel und Versandkosten bei der Bestellung. Diese Pakete können jedoch als Import bewertet werden. Zollgebühren, abhängig von den Gesetzen der einzelnen Länder. Zoll- oder Einfuhrzölle werden erhoben, sobald das Paket das Zielland erreicht. Zusätzliche Gebühren für die Zollabfertigung müssten vom Empfänger getragen werden. Wir haben keine Kontrolle über diese Gebühren und können nicht vorhersagen, was sie sein könnten. Da die Zollpolitik von Land zu Land sehr unterschiedlich ist, sollten Sie sich für weitere Informationen an Ihr örtliches Zollamt wenden. Bei Bedarf kann FS.COM mithelfen, die DUTY TAX vorzufinanzieren.");

define("CHECKOUT_TAXE_CN_TIT","Informationen zu Zoll und Steuern");
define("CHECKOUT_TAXE_CN_TIT1","Über Zölle & Steuern");
define("CHECKOUT_TAXE_CN_FRONT","Für Bestellungen, die direkt aus unserem Lagerhaus in China versandt werden, berechnen wir nur den Warenwert und die Versandkosten. Wir berechnen keine Mehrwertsteuer. Bei diesen Paketen können jedoch Zollgebühren erhoben werden, abhängig von den Gesetzen der jeweiligen Länder. <b>Zollgebühren, die durch die Zollabfertigung entstehen, müssen vom Empfänger getragen werden.</b> Wenn Sie Hilfe benötigen, um den Zoll voraus zu bezahlen, bitte kontaktieren Sie uns.");

//define("CHECKOUT_TAXE_DE_TIT"," Über Mehrwertsteuer & Zollsatz");
define("CHECKOUT_TAXE_DE_TIT"," Informationen zu Mehrwertsteuer und Zollsatz");
define(" CHECKOUT_TAXE_DE_FRONT","FS.COM GmbH ist nach den Gesetzen der Europäischen Union verpflichtet, für alle Bestellungen, die an Bestimmungsorte in Mitgliedstaaten der EU und Großbritannien geliefert werden, Mehrwertsteuer zu berechnen.");
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>Bestimmungsland</div><div>Mehrwertsteuer & Zollsatz</div></div><div class=\"help-center-taTr\"><div>Deutschland</div><div>Es wird eine Mehrwertsteuer von 19% erhoben.</div></div><div class=\"help-center-taTr\"><div>Frankreich und Monaco</div><div>Es wird eine Mehrwertsteuer von 20% erhoben. Wenn eine gültige EU-Umsatzsteuer-Identifikationsnummer angegeben wird, wird keine Mehrwertsteuer erhoben.</div></div><div class=\"help-center-taTr\"><div>Niederlande, Spanien, Belgien</div><div>Es wird eine Mehrwertsteuer von 21% erhoben. Wenn eine gültige EU-Umsatzsteuer-Identifikationsnummer angegeben wird, wird keine Mehrwertsteuer erhoben.</div></div><div class=\"help-center-taTr\"><div>Italien</div><div>Es wird eine Mehrwertsteuer von 22% erhoben. Wenn eine gültige EU-Umsatzsteuer-Identifikationsnummer angegeben wird, wird keine Mehrwertsteuer erhoben.
</div></div><div class=\"help-center-taTr\"><div>Schweden</div><div>Es wird eine Mehrwertsteuer von 25% erhoben. Wenn eine gültige EU-Umsatzsteuer-Identifikationsnummer angegeben wird, wird keine Mehrwertsteuer erhoben.</div></div><div class=\"help-center-taTr\"><div>Andere EU-Mitglieder</div><div>Es wird eine Mehrwertsteuer von 19% erhoben. Wenn eine gültige EU-Umsatzsteuer-Identifikationsnummer angegeben wird, wird keine Mehrwertsteuer erhoben.</div></div><div class=\"help-center-taTr\"><div>Nicht-EU-Länder</div><div> Es wird keine Mehrwertsteuer erhoben, aber die Zollabfertigung wird von Ihnen selbst geleistet. </div></div></div>");

define("CHECKOUT_TAXE_NEW_CN_CONTENT","Produkte, die auf unserem US-Lager sind, werden direkt aus Delaware nach allen Bestimmungsorte in den USA verschickt. FS.COM berechnet NUR den Produktwert und die Versandkosten. Es wird keine Umsatzsteuer erhoben.<br/><br/>Wenn die Bestellungen Artikel enthalten, die nicht auf unserem US-Lager sind, werden wir sie direkt aus unserem Asien-Lagerhaus verschicken, um Sie diese Artikel schneller zu erhalten. Wenn das Produkt auf der Produktseite „Kostenloser Versand“ anzeigt, trägt FS.COM alle möglichen Zölle , die durch die Einfuhrabfertigung verursacht werden.<br/><br/>Artikel, die NICHT die Meldung \"Kostenloser Versand\" auf der Produktseite enthalten, gehören zu schweren oder übergroßen Artikel. Diese Artikel werden direkt aus unserem Asien-Lagerhaus verschickt und können den kostenlosen Versand nicht genießen. Eventuelle Gebühren, die durch die Zollabfertigung entstehen, müssen von Ihnen selbst getragen werden.");

define("CHECKOUT_TAXE_NEW_CA_CONTENT", 'Produkte, die in unserem U.S.-Lager vorrätig sind, werden direkt von Delaware aus an jeden beliebigen Bestimmungsort in Kanada versandt.<br/><br/>Wenn die Bestellung Artikel enthält, die im US-Lager vorübergehend nicht vorrätig sind, versenden wir sie direkt von unserem Asien-Lager an Sie, um die Liefergeschwindigkeit zu beschleunigen.<br/><br/>
Wenn Sie die Bestellung online aufgeben, berechnet FS.COM NUR den Produktwert und die Versandgebühren. Eventuelle Zölle und Gebühren, die durch die Zollabfertigung entstehen, müssen von Ihnen selbst getragen werden.');

define("CHECKOUT_TAXE_NEW_MX_CONTENT","Produkte, die auf unserem US-Lager sind, werden direkt aus Delaware nach allen Bestimmungsorte in Mexiko verschickt. <br/><br/>Wenn die Bestellungen Artikel enthalten, die nicht auf unserem US-Lager sind, werden wir sie direkt aus unserem Asien-Lagerhaus verschicken, um Sie diese Artikel schneller zu erhalten. Wenn das Produkt auf der Produktseite ,Kostenloser Versand“ anzeigt, trägt FS.COM alle möglichen Zölle , die durch die Einfuhrabfertigung verursacht werden.<br/><br/>Artikel, die NICHT die Meldung \"Kostenloser Versand\" auf der Produktseite enthalten, gehören zu schweren oder übergroßen Artikel. Diese Artikel werden direkt aus unserem Asien-Lagerhaus verschickt und können den kostenlosen Versand nicht genießen. Eventuelle Gebühren, die durch die Zollabfertigung entstehen, müssen von Ihnen selbst getragen werden.");


//游客页面注册
define("REGITS_FROM_GUEST_EMAIL_ERROR1","E-Mail-Addresse wird benötigt.");
define("REGITS_FROM_GUEST_EMAIL_ERROR2","Bitte geben Sie eine gültige E-Mail-Addresse ein. (z.B.:someone@gmail.com)");
define("REGITS_FROM_GUEST_PASSWORD_ERROR1","mindestens 6 Schriftzeichens, einschließlich mindestens eines Buchstabens und einer Nummer");
define("REGITS_FROM_GUEST_PASSWORD_ERROR2","Die Bestätigungspasswort muss mit dem Passwort übereinstimmen.");
define("REGITS_FROM_GUEST_ASK","Möchten Sie ein Konto erstellen?");
define("REGITS_FROM_GUEST_CAN","Nur noch ein Schritt, um einen besseren Service zu bekommen. Mit einem Konto bei FS.COM können Sie:");
define("REGITS_FROM_GUEST_EASY","Bestellstatus online einsehen");
define("REGITS_FROM_GUEST_FASTER","Auftragshistorie verwalten");
define("REGITS_FROM_GUEST_NO","Nein, danke.");
define("REGITS_FROM_GUEST_YES","Ja, Ich möchte ein Konto erstellen.");
define("REGITS_FROM_GUEST_USE","Meine Checkout-E-Mail verwenden");
define("REGITS_FROM_GUEST_OR","Oder");
define("REGITS_FROM_GUEST_HISTORY","Wenn Ihre Checkout- und registrierten E-Mail-Adressen unterschiedlich sind, werden sie automatisch zugeordnet. Bestellbestätigungsmail wird an Ihre registrierte E-Mail-Adresse gesendet. Mit dieser registrierten E-Mail-Adresse können Sie sich jederzeit in Ihrem Konto bei FS.COM anmelden, um Bestellungen zu verwalten und zu verfolgen.");
define("REGITS_FROM_GUEST_PASWORD","Passwort");
define("REGITS_FROM_GUEST_CPASWORD","Das Passwort bestätigen");
define("REGITS_FROM_GUEST_NOTE",'Hinweis: Ihre Telefonnummer wird nur verwendet, um Sie bei der Lieferung zu kontaktieren, sowie Ihre E-Mail-Adresse, um den Bestellstatus zu senden.<br>Klicken Sie auf den <a href="privacy_policy.html">Datenschutz</a>, um mehr Informationen zu erfahren.');
define("REGITS_FROM_GUEST_EXSIT1","Diese E-mail ist schon registriert, bitte melden Sie sich direkt an. &nbsp;&nbsp;&nbsp;&nbsp;");
define("REGITS_FROM_GUEST_EXSIT2","Anmelden »");
define("REGIST_NUM_LENGTH","mindestens 6 Schriftzeichens");
define("REGIST_NUM_LEAST","mindestens 6 Schriftzeichens, einschließlich mindestens eines Buchstabens und einer Nummer.");

//2018-1-23    ery   add 属性未勾选加入购物车的提示语
define('FS_PRODUCT_INFO_ATTR_PLEASE','Bitte wählen Sie einen Parameter für jedes Attribut.');
//产品详情页长度定制框语言包
define('FS_LENGTH_CUSTOM_FEET','Feet Or');
define('FS_LENGTH_CUSTOM_METER','Meter');
define('FS_PRODUCTS_AOC_LENGTH_ERROR','Die Kabellänge kann je nach Bedarf von 0,5m bis 100m (1,64ft to 328,084ft) angepasst werden.');

//春节设置,请勿乱修改,1->开启春节分仓 0->关闭春节分仓
define("FS_IS_SPRING",0);
define("CN_SPRING_WAREHOUSE_MESSAGE","Die Artikel, die nur Lagerbestand in China haben, werden in den Frühlingsferien (10.02.2018 - 20.02.2018) nicht versandt");
define("FS_EMPTY_COST","Zurzeit unterstützen wir nur Versand per DHL und UPS. Wenn Sie andere Versandarten benötigen, bitte geben Sie Ihr eigenes Konto ein. Falls Sie mehr Informationen erfahren möchten, zögern Sie bitte nicht, <a href='https://www.fs.com/de/contact_us.html'>uns zu kontaktieren</a>.");
define("CN_SPRING_WAREHOUSE_MESSAGE1","Hinweis: Die Bestellung ");
define("CN_SPRING_WAREHOUSE_MESSAGE2","wird aus China versandt. Unsere Frühlingsfestferien sind von 6.2.2018 bis 20.2.2018. Während dieser Zeit wird China mit dem Versand aufhören.");


define("FS_QTY_CHANGED","Bitte bezahlen Sie Ihre Bestellung so schnell wie möglich, damit Ihre Bestellung rechtzeitig bearbeitet werden kann. Anderenfalls könnte sich Ihre Bestellung bei der Lieferung verzögern.");

define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | Mo.- Fr.');
define("FS_JS_TIT_CHECK1","</br>Zeit für die Selbstabholung: ");
define("FS_JS_TIT_CHECK2","Mitteleuropäische Zeit：");
define("FS_JS_TIT_CHECK3","Montag-Freitag");
define("FS_JS_TIT_CHECK4","10:00am - 12:00pm");
define("FS_JS_TIT_CHECK5",", 2:00pm - 5:00pm ");
define("FS_JS_TIT_CHECK6","Name auf Personalausweis");
define("FS_JS_TIT_CHECK7","E-Mail-Adresse");
define("FS_JS_TIT_CHECK8","Telefonnummer");
define("FS_JS_TIT_CHECK9","Abholzeit");
define("FS_JS_TIT_CHECK_US","9:30 - 17:30 Uhr");
define("PICK_UP_ALERT1",'Name auf Personalausweis ist erforderlich.');
define("PICK_UP_ALERT2",'Personalausweis-Nummer ist erforderlich.');
define("PICK_UP_ALERT4",'Abholzeit ist erforderlich.');
define("REGITS_FROM_GUEST_EMAIL_ERROR3","Geben Sie eine gültige E-Mail Adresse ein.");

/*
 * 客户分享产品邮件
 */
define('FS_EMAIL_PRODUCT_SHARE1','Ihr Freund teilt diesen Artikel mit Ihnen nur über ');
define('FS_EMAIL_PRODUCT_SHARE2','FS.COM.');
define('FS_EMAIL_PRODUCT_SHARE3','Ich glaube, dass Sie sich für diese Seite interessieren ');
define('FS_EMAIL_PRODUCT_SHARE4','Mehr erfahren');
define('FS_EMAIL_PRODUCT_SHARE5','Mit freundlichen Grüßen,');
define('FS_EMAIL_PRODUCT_SHARE6','FS.COM');
define('FS_EMAIL_PRODUCT_SHARE7',' Kundenservice-Team ');
define('FS_EMAIL_PRODUCT_SHARE8','Diese E-Mail wurde geschickt von ');
define('FS_EMAIL_PRODUCT_SHARE9','\'s Teilen mit einem Freund-Service. Als Ergebnis dieser Nachricht erhalten Sie keine unerwünschte Nachricht von ');
define('FS_EMAIL_PRODUCT_SHARE10','https://www.fs.com/de/');
define('FS_EMAIL_SHARE_TITLE_ONE','FS.COM - Ihr Freund ');
define('FS_EMAIL_SHARE_TITLE_TWO',' möchte, dass Sie diesen Artikel sehen.');
define('FS_EMAIL_PRODUCT_SHARE11','Nachricht von ');
define('FS_PRO_SHARE_EMAIL','Ihre Nachricht wurde versendet.');
define('FS_EMAIL_PRODUCT_SHARE13',',erfahren mehr zu');
define('FS_EMAIL_POLICY_2',"");
define('FS_EMAIL_PRODUCT_USING',' using ');


//客户追问成功
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_01','Neue Rückantwort aus');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_02','Case-Nummer');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_03','Guten Tag,');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_04','Kunde');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_05','hatte den Case beantwortet:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_06','-Vertriebsmitarbeiterin:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_07','-Ingenieur:');

//helun 客户提出问提成功
define('FS_MODIFY_EMAIL_MY_CASE_01','Ihre Frage');
define('FS_MODIFY_EMAIL_MY_CASE_02','wurde erhalten.');
define('FS_MODIFY_EMAIL_MY_CASE_03','Vielen Dank für Ihre Nachricht an <a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>. Wir haben Ihre Nachricht erhalten. Die Nummer Ihrer Frage ist');
define('FS_MODIFY_EMAIL_MY_CASE_04','Unser <a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Verkaufsteam wird Ihre Frage überprüfen und sich innerhalb von 12 Stunden bei Ihnen melden.');
define('FS_MODIFY_EMAIL_MY_CASE_05','Wenn Sie noch Fragen haben, rufen Sie uns bitte unter Tel. <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (888) 468 7419</a> (USA), oder <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Deutschland). Sie können auch live chatten, um eine schnelle Antwort zu erhalten.');
define('FS_MODIFY_EMAIL_MY_CASE_06','Mit freundlichen Grüßen');
define('FS_MODIFY_EMAIL_MY_CASE_07','<a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Kundenservice-Team ');
define('FS_MODIFY_EMAIL_MY_CASE_08','Hallo');
define('FS_MODIFY_EMAIL_MY_CASE_09','FS.COM - Die Nummer der Frage: ');

//2017-12-29   ery  add  sales_service_details
define('SALES_DETAILS_PRINT_LABEL','Das vorausbezahlte Rücksendeetikett ausdrucken');
define('SALES_DETAILS_LABEL_MSG','Sie können vorausbezahlte Versandetiketten von jedem Computer mit Internetzugang ausdrucken. 
Bitte fügen Sie das Etikett in der Originalverpackung bei und legen Sie das Paket an einem UPS-Versandort in Ihrer Nähe ab.');
define('SALES_DETAILS_PSL','Rücksendeetikett ausdrucken');
define('FS_SALES_DETAILS_COMMENT','Zurückgegebener Grund (erforderlich)');
define('FS_SALES_DETAILS_REVIEW','Informationen von Rückgabe oder Umtausch');
define('FS_SALES_DETAILS_NO','RMA Nr.');
define('FS_SALES_DETAILS_STATUS','RMA Status');
define('FS_SALES_DETAILS_AMOUNT','Menge');
define('FS_SALES_DETAILS_RPI','Informationen zur Rückzahlung');
define('FS_SALES_DETAILS_RA','Erstattungsbetrag');
define('FS_SALES_DETAILS_RM','Rückzahlungsmethode');
define('FS_SALES_DETAILS_SAME','Gleiche Zahlungsmethode');
define('FS_SALES_DETAILS_NOTE','Hinweis: In Ihrer Rückgabe-E-Mail können Sie den Erstattungsbetrag finden.');
define('FS_SALES_DETAILS_PROCESS','RMA Prozess');
define('FS_SALES_DETAILS_AWB','Tracking-Informationen updaten');
define('FS_SALES_DETAILS_ADDRESS','Adresse bestätigen');

//第三方登录提示语
define("REDIRECT_DEAR","Lieber ");
define("REDIRECT_USER"," Benutzer ");
define("REDIRECT_WELCOME"," Herzlich willkommen");
define("REDIRECT_NOTICE","Sie haben ein FS-Konto mit derselben E-Mail-Adresse <br>registriert. Um Ihnen eine bessere Kontoverwaltung zu ermöglichen, werden Sie <br>sich bei Ihrem FS-Konto anmelden. Wenn Sie dieses Konto nicht kennen.");
define("REDIRECT_ACCOUNT","leiten Sie in ");

//2017-12-30  ery    add
define('FS_SALES_INFO_REQUEST','RMA-Anfrage');
define('FS_SALES_INFO_A','Eine Anfrage für eine Rückgabe garantiert keine Autorisierungsnummer, da einige Artikel nicht zurückgesandt werden können und überprüft werden müssen.');
define('FS_SALES_INFO_PLEASE','Bitte lesen Sie das Rückgaberecht und Widerrufsrecht. Sie werden innerhalb von 24 Stunden eine Email erhalten, wenn Ihre Rückkehr genehmigt oder verweigert wurde.');
define('FS_SALES_INFO_YOU','Sie können senden zu ');
define('FS_SALES_INFO_WHAT','Warum möchten Sie die Ware zurückschiken?');
define('FS_SALES_INFO_QI','Qualitätsprobleme');
define('FS_SALES_INFO_SI','Service-Probleme');
define('FS_SALES_INFO_OI','Andere');
define('FS_SALES_INFO_WE',"Bitte befolgen Sie unsere Rückgabebedingungen, um das Produkt zurückzusenden");
define('FS_SALES_INFO_ATTA','Anlage');
define('FS_SALES_INFO_ALLOW','Dateien vom Typ PDF, JPG, PNG erlauben.');
define('FS_SALES_INFO_ADD','Foto hinzufügen');
define('FS_SALES_INFO_VERIFY','Rückgabe-Adresse bestätigen');
define('FS_SALES_INFO_KIND','Hinweis');
define('FS_SALES_INFO_OUR','Unser Kundenservice-Team rufen Sie vielleicht an. Bitte halten Sie Ihr Telefon frei.');
define('FS_SALES_INFO_I','Ich akzeptiere das ');
define('FS_SALES_INFO_RP','Rückgaberecht');
define('FS_SALES_INFO_PLEASE_AGREE','Bitte akzeptieren Sie das Rückgaberecht, um fortzusetzen.');
define('FS_SALES_INFO_PLEASE_WRITE','Bitte schreiben Sie das Produktproblem auf.');
define('FS_SALES_INFO_ITEMS','Artikel funktioniert falsch');
define('FS_SALES_INFO_MIS','Abweichung in der Größe');
define('FS_SALES_INFO_DID','Beschreibung stimmt nicht überein');
define('FS_SALES_INFO_RE','Falsche Artikel erhalten');
define('FS_SALES_INFO_UN','Lange Lieferzeit');
define('FS_SALES_INFO_DA','Beschädigt bei der Lieferung');
define('FS_SALES_INFO_NO','Nicht mehr gebraucht');
define('FS_SALES_INFO_NOT','Nicht wie erwartet');
define('FS_SALES_INFO_WRONG','Falsche Artikel bestellen');
define('FS_MANAGE_ORDERS_PO','Auftragsnummer');
define('FS_MANAGE_ORDERS_RE','Geprüft');
define('FS_MANAGE_ORDERS_TN','Verfolgungsnummer');
define('FS_MANAGE_ORDERS_MORE','Mehr');
define('FS_MANAGE_ORDERS_RECORDA','Datensätze pro Seite');
define('FS_MANAGE_ORDERS_PURCHASE',"Kaufauftrag-Nummer darf nicht leer sein");
define('FS_MANAGE_ORDERS_OC',"Bestellhinweis");
define("FS_MANAGE_ORDERS_FILE","Bitte laden Sie Ihren Auftrag hoch.");
define('FS_ORDER_COMMENTS',"Bestellhinweis");
//2018-1-3   ery    add
define('FS_SALES_DETAILS_RAE','Zurücksendung ist leicht');
define('FS_SALES_DETAILS_NO_LABEL','Gehen Sie bitte folgendermaßen vor, um einen Artikel zurückzusenden. Nachdem Sie den Artikel zurückgesendet haben, aktualisieren Sie die Tracking-Nummer. Sollten Sie Fragen haben, stehen wir Ihnen gerne zur Verfügung.');
define('FS_SALES_DETAILS_LABEL','Gehen Sie bitte folgendermaßen vor, um einen Artikel zurückzusenden. Wir liefern Ihnen ein vorausbezahltes Versandetikett für Ihr Rücksendungs-Paket. Bitte bringen Sie das Paket zu einem autorisierten UPS-Versandort.');
define('FS_SALES_DETAILS_CR','RMA stornieren');
define('FIBERSTORE_ORDER_PROMT_RMA','No RMA request.');
define('MANAGE_ORDER_SEARCH_NO','Bestell-/PO-Nr. / ID');
//2018-1-22    ery  add   sales_service_info页面
define('FS_SALES_INFO_NUMBER','Seriennummer');
define('FS_SALES_INFO_FOR','Für Transceiver&nbsp;geben Sie bitte die Seriennummer an, damit wir das Problem besser identifizieren und lösen können.');
define('FS_SALES_INFO_BRIEFLY','Bitte erzählen Sie kurz das Problem');
define('FS_REFUND_PROCESSING','Bearbeitung der Erstattung');
define('FS_REFUND_APPLICATION','Die Erstattung beantragen');
define('FS_REFUND_SUCCESS_MSG','Wir haben die Erstattung auf Ihr Zahlungskonto überwiesen. Überprüfen Sie bitte.');
define('FS_REFUND_FAIL_MSG','Entschuldigung, Ihr Antrag auf Erstattung wird abgelehnt. Wenn Sie Fragen haben, wenden Sie sich bitte an uns.');
define('FS_REFUND_APPMSG','Ihr Antrag auf Erstattung ist in Bearbeitung. Das Ergebnis wird hier bald aktualisiert.');

//fairy 整理公共的
// 公共表单
define('FS_TAX_ERROR_EMPTY','Please enter a valid tax number.');
define('FS_SECURITY_ERROR', 'Es gibt einen Sicherheitsfehler.');  // token验证不正确
define('FS_SYSTME_BUSY', 'Das System ist beschäftigt. Bitte versuchen Sie es später erneut.'); //异步提交，连接服务器出现error情况
define('FS_ACCESS_DENIED', 'Fehler: Zugriff abgelehnt.'); //没有权限访问
define('FS_ACCESS_DENIED_1', 'Fehler: Code 999.');
define('FS_FORM_REQUEST_ERROR','Das System ist beschäftigt. Bitte versuchen Sie es später erneut.');
define('FS_NON_MANDAROTY',"kein Pflichtfeld");
define('FS_COMMON_SAVE',"Speichern");
define('FS_COMMON_CANCEL',"Stornieren");
define('FS_COMMON_CANCEL1',"Nein");

//验证码 start
define('FS_ENTER_CHARACTER',"Bitte geben Sie die Zeichen ein");
define('FS_IMAGE_REQUIRED_TIP',"Bitte geben Sie die Zeichen in das Bild ein.");
//验证码-服务器端的验证
define('FS_IMAGE_ERROR_TIP',"Die Zeichen sind falsch. Bitte versuchen Sie es erneut.");
define('FS_IMAGE_EXPIRE_TIP',"Bitte aktualisieren Sie die Zeichen und geben Sie die neuen Zeichen ein.");
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP',"Um Ihr Konto besser zu schützen, geben Sie Ihr Passwort erneut ein und geben Sie dann die Zeichen ein, die im folgenden Bild angezeigt werden.");
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP',"Um Ihr Konto besser zu schützen, geben Sie Ihre E-Mail-Adresse erneut ein und geben Sie dann die Zeichen ein, die im folgenden Bild angezeigt werden.");
//验证码 end

// 公共的
define('FS_USERNAME','Nutzername');
define('FS_FIRST_NAME',"Vorname");
define('FS_LAST_NAME',"Nachname");
define('FS_PASSWORD',"Passwort");
define('FS_EMAIL_ADDRESS',"E-Mail-Adresse");
define('FS_EMAIL_ADDRESS1',"E-Mail-Addresse");
define('FS_COMPANY_WEBSITE',"Webseite Ihrer Firma");
define('FS_INDUSTRY',"Branche");
define('FS_COMPANY_NAME',"Firmenname");
define('FS_ENTERPRISE_OWNER_NAME',"Geschäftsführer");
define('FS_YOUR_COUNTRY',"Land/Region");
define('FS_COUNTRY','Land/Region:');
define('FS_OTHER_COUNTRIES','Andere Länder/Regionen');
define('FS_SELECT_YOUR_COUNTRY_REGION','Land/Region wählen');
define('FS_SELECT_COUNTRY_REGION','Land/Region wählen');
define('FS_COMMON_COUNTRY_REGION','Land/Region');
define('CURRENT','aktuell');
define('MAIN_MENU','Hauptmenü');
define('FS_SELECT_CURRENCY','Wählen Sprache/Währung');
define('FS_LANGUAGE_CURRENCY','Sprache/Währung');
define('FS_VAT_NUMBER',"USt-IdNr.");
define('FS_PHONE_NUMBER',"Telefonnummer");
define('FS_COMMON_COMPANY','Firma');
define('FS_FOOTER_COMPANY_INFO',"Firma");
define('FS_QTY','Menge');
define('FS_OPTIONAL_COMPANY',' (optional)');
// 公共的
define('FS_OR', 'Oder');
define('FS_OTHERS','Andere');
define('FS_LOADING',"wird geladen");
define('FS_SHOW',"Zeigen");
define('FS_HIDE',"Verbergen");
define('FS_HELLO','Hallo');
define('FS_SORT','Sortieren');
define('FS_COMMON_MORE','Mehr');
define('FS_COMMON_CUSTOMIZED','Maßgeschneidert');
define('FS_NEXT_DAY','am nächsten Werktag');
define('FS_COMMON_CLOSE','Schließen');
define('FS_COMMON_FS_PN', 'FS P/N: ');
// 公共的
define('FS_COPY',"Copyright");
define('FS_RIGHTS',"Alle Rechte vorbehalten");
define('FS_TERMS_OF_USE',"AGB");
define('FS_POLICY',"Datenschutzerklärung");
define('FS_AGREE_POLICY','Durch Klicken auf die Schaltfläche unten stimmen Sie unsere  <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">Datenschutzerklärung</a> und  <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">AGB</a> zu.');
define('FS_FOOTER_COOKIE_TIP','Wir verwenden Cookies, um Ihnen ein besseres Einkaufserlebnis zu bieten. Durch den weiteren Zugriff auf diese Website stimmen Sie der Verwendung von Cookies gemäß unsere <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie-Richtlinien</a> zu.');
define('FS_FOOTER_COOKIE_MOBILE_TIP','Wir verwenden Cookies, um Ihnen ein besseres Einkaufserlebnis zu bieten. Sehen Sie <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie-Richtlinie</a>.');
define('FS_I_ACCEPT','Einverstanden');

//运费
define("FS_SHIPPING_AREA_BY_WAREHOUSE_CN","Sofort lieferbar aus Lager in China");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_US","Sofort lieferbar aus Lager in den USA");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_EU","Sofort lieferbar aus Lager in Deutschland");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_CN","aus Lager in China");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_US","aus Lager in den USA");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_EU","aus Lager in Deutschland");
define("FS_BULK_WAREHOUSE","versandfertig am");

define("FREE_SHIPPING_TEXT1","Kostenloser Versand bei Bestellung über 79,00 € (übergroße oder schwere Waren nicht erhalten).");
define("FREE_SHIPPING_TEXT2","Kostenloser Versand bei Bestellung über US$ 79,00 (übergroße oder schwere Waren nicht erhalten).");
define("FS_TIME_ZONE_RULE_US","(UTC/GMT+1)");
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}
//2018-3-7   add   ery  产品详情页Compatible Brands属性未勾选的提示语
define('FS_PRODUCT_INFO_BRAND_PLEASE','Wählen Sie bitte eine Marke aus.');
define('FS_PRODUCT_INFO_BRAND_CHOOSE','Eine Marke auswählen');
define('FS_MOBILE_CLOSE','Schließen');

define('FS_LIMIT_MONEY',"Der Gesamtbetrag überschreitet die Limitierung. Bitte teilen Sie die Bestellung oder wählen Sie eine andere Zahlungsmethode!");
define('FS_LIMIT_MONEY_15000','Der Gesamtbetrag überschreitet die Begrenzung (€ 15000). Bitte teilen Sie die Bestellung auf oder wählen Sie eine andere Zahlungsart!');
define('FS_LIMIT_MONEY_10000','Der Gesamtbetrag überschreitet die Begrenzung (€ 10000). Bitte teilen Sie die Bestellung auf oder wählen Sie eine andere Zahlungsart!');

//2018-3-15  ery  add  订单上传logo
define('FS_ATTRIBUTE_OEM','OEM/ODM Service');
define('FS_ATTRIBUTE_NONE','Nein');
define('FS_ATTRIBUTE_DESIGN','Benutzerdefiniertes Etikett');

define('FS_ORDER_LOGO_DESIGN',"Ihr benutzerdefiniertes Etikett hochladen");
define('FS_ORDER_LOGO_YOUR',"Laden Sie bitte Ihr benutzerdefiniertes Etikett oder Ihren spezifischen Herstellernamen und Teilenummer als Referenz hoch.");
define('FS_ORDER_LOGO_WE',"Wir werden mit Ihnen das Etikett bestätigen. Sie können uns auch Ihr Etikett per Email senden.");
define('FS_ORDER_LOGO_UPLOAD',"Etikett hochladen");
define('FS_ORDER_LOGO_DELETE',"Löschen Sie das Bild?");
define('FS_ORDER_LOGO_UP_SUCCESS','Die Datei wurde erfolgreich hochgeladen.');
define('FS_ORDER_LOGO_DEL_SUCCESS','Das Bild wurde erfolgreich gelöscht.');
//产品详情页
//产品详情页
define("FS_FOR_FREE_SHIPPING","Kostenloser Versand");
define("FS_SG_FREE_SHIPPING","Kostenlose Versand und Installation ");
define("FS_SG_NO_FREE_SHIPPING","Kostenlose Installation ");
define("FS_FOR_FREE_SHIPPING_US",'bei Bestellung über $MONEY');
define("FS_FOR_FREES_SHIPPING_ONE","morgen erhalten ");
define("FS_FOR_FREES_SHIPPING_TWO","Bestellen Sie vor ");
define("FS_FOR_FREES_SHIPPING_TIME","16:00 Uhr (PST)");
define("FS_FOR_FREES_SHIPPING_THREE","und wählen Sie den Versand per Overnight Shipping.");
define("FS_FOR_FREES_SHIPPING_FOUR","Lieferung:");
define("FS_FOR_FREES_SHIPPING_FIVE","Lieferung innerhalb 1-3 Werktagen, wenn Sie vor <span>16:00 Uhr (PST)</span> bestellen.");
define("FS_FOR_FREES_SHIPPING_SIX","Erhalten am Dienstag? Wählen Sie den Versand per Overnight Shipping.");
define("FS_FOR_FREE_SHIPPING_DE","Kostenloser Versand");
define("FS_FOR_FREE_SHIPPING_DE_MONEY",' für Bestellung ab $MONEY');
define("FS_FOR_FREES_SHIPPING_FIVE_DE1"," <span>16:00 Uhr (UTC/GMT +1)</span> und wählen Sie den Versand per DHL Express.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE2"," <span>16:00 Uhr (UTC/GMT +2)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE3","Schneller liefern? Bestellen Sie vor <span>17:00 Uhr (UTC/GMT +2)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE4"," <span>15:00 Uhr (UTC/GMT +1)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE5"," <span>15:00 Uhr (UTC/GMT +1)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE6","Schneller liefern? Bestellen Sie vor <span>11:00 Uhr (UTC/GMT -3)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE7","Schneller liefern? Bestellen Sie vor <span>18:00 Uhr (UTC/GMT +4)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE8","Schneller liefern? Bestellen Sie vor <span>15:00 Uhr (UTC/GMT +1)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE9","Schneller liefern? Bestellen Sie vor <span>17:00 Uhr (UTC/GMT +3)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE10","<span>16:00 Uhr (UTC/GMT +3)</span> und wählen Sie den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE11","Schneller liefern? Bestellen Sie vor <span>12:00 Uhr (UTC/GMT -2)</span> und wählen Sie den Versand per DHL Express.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE12","Versand am Dienstag und Lieferung innerhalb 1-3 Werktagen.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE13","Erhalten am Dienstag? Wählen Sie bitte den Versand per DHL Express.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE14","Erhalten am Dienstag? Wählen Sie bitte den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE15","Schneller liefern? Wählen Sie bitte den Versand per UPS Express Saver.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE16","Schneller liefern? Wählen Sie bitte den Versand per DHL Express.");
define("FS_FOR_FREE_SHIPPING_GB1","Kostenloser Versand");
define("FS_FOR_FREE_SHIPPING_GB3","bei Bestellung über £79");
define("FS_FOR_FREE_SHIPPING_GB4","in Vereinigtes Königreich");
define('FS_ITEM_LOCATION','Lagerhaus:');
define('FS_SEATTLE_WASHINGTON','Seattle, USA');
define('FS_SEATTLE_EU','München, Deutschland');
define('FS_SEATTLE_CN','Wuhan, China');

//详情页Compatible Brands提示 dylan 2019.11.18
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01','eg: Cisco N9K-C9396PX auf Juniper MX960');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02','eg: Cisco N9K-C9396PX QSFP+ auf Juniper MX960 SFP+');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03','eg: Cisco N9K-C9396PX QSFP+ auf Juniper EX4200 XFP');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04','eg: Cisco N9K-C9396PX QSFP28 auf Juniper QFX5200 SFP28');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05','eg: Cisco Nexus 5696Q CXP auf Juniper MX960 QSFP+');

define('FS_SELECT_TYPE','Die gängigsten Spezifikationen, die unsere Kunden gekauft haben.');
define('FS_SELECT_DEFAULT','Standard');
define('FS_SELECT_CUSTOMIZE','Maßgeschneidert');
define('FSCHOOSE_SPECI','Spezifikation:');

define("FS_SHIPPING_POLICY_US","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 17:00 Uhr EST gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_CA","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 17:00 Uhr gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_MX","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 16:00 Uhr gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_NZ","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 15:00 Uhr (AEST/AEDT) gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_AU","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 15:00 Uhr (AEST/AEDT) gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_GB","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor ".FS_SUMMER_OR_WINTER_TIME." Uhr gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_DE","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor ".(SUMMER_TIME ? '16:30 Uhr (UTC/GMT+2)' : '16:30 Uhr (UTC/GMT+1)')." gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_CN","Der Liefertermin gilt für Artikel, die an Werktagen bis 17.00 Uhr (GMT+8) gekauft wurden. Wenn Ihre angeforderte Menge den Lagerbestand überschreitet, wird diese ohne zusätzliche Kosten in einer anderen Sendung versandt. Weitere Details finden Sie auf der Kasse-Seite.");
define("FS_SHIPPING_POLICY_SG","Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 15:30 Uhr (GMT+8) gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, wird ein weiteres Paket ohne zusätzliche Kosten versandt. Weitere Informationen finden Sie auf der Kassen-Seite.");
define("FS_SHIPPING_POLICY_RU","Der Liefertermin gilt für Artikel, die an Werktagen bis 10:30 Uhr (UTC/GMT+3) gekauft wurden. Wenn Ihre angeforderte Menge den Lagerbestand überschreitet, wird diese ohne zusätzliche Kosten in einer anderen Sendung versandt. Weitere Details finden Sie auf der Kasse-Seite.");
//add by quest 2019-03-11   // 2019 3.18 po产品 shipping弹窗 pico
define("FS_FOR_FREE_SHIPPING_PRE_ORDER","bei Bestellung über MONEY");
define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', "Kostenloser Versand bei Vorbestellung über MONEY");
define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Wir liefern kostenlos bei Bestellung über MONEY für alle Produkte, die mit 'KOSTENLOSEM Versand' gekennzeichnet sind.");
define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "Die Bearbeitungszeit für Vorbestellungen beträgt ca. 15 Werktage. Nach dem Test werden wir die Bestellungen sofort verschicken. Die Lieferzeit wird von Ihre gewählten Versandoption bestimmt.");
define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "Der Fokus des Vorbestellservices liegt darauf, Ihnen zu helfen, Projektbudget zu sparen und frühzeitig einen Projektplan erstellen zu können. Mehr Informationen über den <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>Vorbestellservice</a>.");


//Lieferung & Rückgabe Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Garantie & Rückgaben');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Schneller Versand nach Südostasien');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','<p>Wenn die Artikel nicht wie erwartet funktionieren, kann die Garantie von FS die Rücksendung, den Umtausch oder die Reparatur der Artikel ermöglichen.</p><br/>
<p>Wir bieten einen 30-tägigen Rückgabe- und Umtauschservice für die meisten vorrätigen Artikel. Und innerhalb der Garantiezeit bieten wir immer noch kostenlose Reparaturen an.</p><br/>
<p>Für Verbrauchsartikel gibt es keinen Garantiezeit und kostenlose Reparaturservice. Wenn es nach der Lieferung Qualitätsprobleme gibt, können Sie sich gerne an uns wenden. Wir werden uns umgehend darum kümmern. Weitere Informationen finden Sie auf der Seite <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">Rückgaberecht</a> und <a href="'.reset_url("/policies/warranty.html").'" target="_blank">Garantie</a>.</p>');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Bestellungen von geeigneten Artikeln über $MONEY oder mehr qualifizieren sich für Kostenloser Versand. Für weitere Informationen zur Qualifizierung, besuchen Sie bitte <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Versand & Lieferung</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS bietet mehrere Lieferoptionen, um Ihren Zeitplan oder Ihr Budget zu erfüllen. Bestellungen, die auf Lager sind, werden innerhalb von 24 Geschäftsstunden nach Bestelldatum versandt. Für weitere Informationen, besuchen Sie bitte <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Versand & Lieferung</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Für Vorbestellte Produkte, die Bestellungen über $MONEY oder mehr qualifizieren sich für Kostenloser Versand. Für weitere Informationen zur Qualifizierung, besuchen Sie bitte <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Versand & Lieferung</a>.</div>');


define('FS_CHECKOUT_EDIT',"Bearbeiten");
define('FS_CHECKOUT_USE_ADDRESS',"Meine Lieferanschrift als Rechnungsanschrift übernehmen");

define("FS_LOCAL_URL_MESSAGE","Kostenlosen Versand aus deutschem Warenlager bei einem Bestellwert in Höhe von 79,00 € oder darüber");
define("FS_ADDERSS_LIMIT","Entschuldigung, der Artikel kann nicht an Ihre ausgewählte Adresse gesendet werden. Sie können zu der Region in Ihrer Nähe wechseln, um mit dem Einkauf fortzufahren.");
define("FS_FESTIVAL1","Der");
define("FS_FESTIVAL2","Gerne nehmen wir in dieser Zeit Ihre Online-Bestellungen entgegen, die wir am ");
define("FS_FESTIVAL3"," an Sie verschicken werden.");
define("FS_FESTIVAL4","st");
define("FS_FESTIVAL5","nd");
define("FS_FESTIVAL6","ist Feiertag in den USA. FS.COM wird");
define("FS_FESTIVAL7","gerne wieder Ihre Bestellungen entgegen.");
define("FS_FESTIVAL12","Es sind Feiertage in Deutschland ab dem");
// 2018.4.3 fairy 报价
define('FS_GET_A_QUOTE_BIG', 'Ein Angebot erhalten');
define('FS_GET_A_QUOTE_FREE', 'Eine Box anfordern');
define('FS_GET_A_QUOTE', 'Angebot anfragen');
define('GET_A_QUOTE', 'Ein Angebot erhalten');
define('FS_COMMON_SUBMIT', 'Bestätigen');
define('FS_REQUEST_DEADLINE','Der Antrag wurde wie geplant geschlossen. Die aktualisierte Version wird im November veröffentlicht, bitte bleiben Sie dran.');

//产品详情页新增aron
define("FS_FOR_FREE_SHIPPING_TO_FREE","Kostenlos");
define("FS_FOR_FREE_SHIPPING_TO"," Deliver to");
define("FS_FOR_FREE_SHIPPING_TO_CN","Ship on ");
define("FS_FOR_FREE_SHIPPING_TO2","Shipping to ");
define("FS_FOR_FREE_SHIPPING_ON","on");
define("FS_FOR_FREE_SHIPPING_TO3","to");
define("FS_FOR_FREE_SHIPPING_GET","get it by");

//修改2018 5.8
define("FS_DE_SHIPPING_RESET1"," <span>4pm (UTC/GMT +2)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET2"," Want it next Tuesday? Choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET3"," <span>5:00 pm (UTC/GMT +3)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET4","Want it delivery faster? Order by <span>3pm (UTC/GMT +1)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET5","Want it delivery faster? Choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET6","Want it delivery faster? Order by <span>4:00 pm (UTC/GMT +2)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET7","Want it delivery faster? Order by <span>3:00 pm (UTC/GMT +1)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET8","morning");
//guest
define("FS_GUEST_HAVA",'Die E-Mail-Adresse existiert in unserem System. Bitte loggen Sie sich direkt ein.');
define("FS_GUEST_LOGIN",'einloggen');

//公用头部账户板块
define('FS_COMMON_HEADER_ACCOUNT','Mein Konto');
define('FS_COMMON_HEADER_CASES','Meine Fragen');
define('MANAGE_ORDER_HISTORY','Meine Bestellungen');
define('FS_COMMON_HEADER_NOT','Nicht Ihr Konto? ');
define('FS_COMMON_HEADER_OUT','Abmelden');
define('FS_ACCOUNT_NO','');
define('FS_ACCOUNT_NO_01','');

define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG','(Inkl. GST)');


define('FS_COMMON_ACCOUNT', 'Kontonummer');
//新增加
define('FS_CHECK_OUT_TAX_AU','GST');
define('FS_CHECK_OUT_EXCLUDING_AU','(exkl. GST)');
define('FS_CHECK_OUT_INCLUDING_AU','(Inkl. GST)');
define("FS_WAREHOUSE_AREA_AU","Versand aus dem Lager in Australien");
define("CHECKOUT_TAXE_AU_TIT","Über GST und Zölle");
define("CHECKOUT_TAXE_AU_CONTENT", "Durch den <em class='alone_font_italic'>A New Tax System (Goods and Services Tax) Act 1999</em> ist FS.COM PTY LTD für den Versand aus dem Lager in Melbourne verpflichtet, GST für alle Bestellungen zu berechnen, die an Standorte in Australien geliefert werden. Daher beträgt der reguläre GST-Steuersatz für alle unsere Waren 10%. Nachdem Sie die Bestellinformationen vollständig ausgefüllt haben, können Sie die Gesamtsumme einschließlich der entsprechenden GST in der Bestellübersicht sehen.</br></br>Für Bestellungen mit Artikeln, die in unserem Lager in Melbourne nicht verfügbar sind, versenden wir diese nach der Ankunft in Melbourne, die vom Lager in Asien übertragen wurde.</br></br>Für Bestellungen mit schweren oder übergroßen Artikeln senden wir diese direkt aus dem Lager in Asien an Sie. In diesem Fall wird bei der Bestellung keine GST berechnet. Für die Pakete können jedoch je nach Gesetz Import- oder Zollgebühren erhoben werden. Alle durch Zollabfertigung verursachten Kosten sind von Ihnen selbst abzuwickeln und zu tragen.");
define("FREE_SHIPPING_TEXT3","Kostenloser Versand bei Bestellung über AU$ 99.");
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU','GST');
define('PRODUCTS_SHIP_TODAY','Heute Versand');
define('ITEM_LOCATION_AU','Melbourne, Australien ');
define('FS_COMMON_WAREHOUSE_AU','FS.COM Pty Ltd<br>
ABN 71 620 545 502 <br>
57-59 Edison Rd,<br>
Dandenong South,<br>
VIC 3175,<br>
Australien
Tel.: +61 (2) 8317 1119');

define('FS_SHARE_CART_06','Account Manager. ');
//add ternence 2018-7-9

define('FS_SHOP_CART_ALERT_JS_50','Artikel');
define('FS_SHOP_CART_ALERT_JS_51','Zwischensumme (');
define('FS_SHOP_CART_ALERT_JS_52',') : ');
define('FS_SHOP_CART_ALERT_JS_53','Warenkorb');
define('FS_SHOP_CART_ALERT_JS_54','( Exkl. Versandkosten )');
define('FS_SHOP_CART_ALERT_JS_55','Ihr Name');
define('FS_SHOP_CART_ALERT_JS_55_1','Name des Empfängers');
define('FS_SHOP_CART_ALERT_JS_56','Ihre E-Mail-Adresse');
define('FS_SHOP_CART_ALERT_JS_56_1',"Trennen Sie mehrere Empfänger durch ein Semikolon (;)");
define('FS_SHOP_CART_ALERT_JS_57','Maximal 500 Schriftzeichen');
define('FS_SHOP_CART_ALERT_JS_58','Gespeicherter Warenkorb');
define('FS_SHOP_CART_ALERT_JS_59','Ihre Bestellung gilt als kostenlosen Versand. ');
define('FS_SHOP_CART_ALERT_JS_60','Lieferung nach');
define('FS_SHOP_CART_ALERT_JS_61','Kostenloser Versand bei Bestellung über US$79 für alle Artikel, die in unserer Politik von kostenlosem Versand enthalten sind.');
define('FS_SHOP_CART_ALERT_JS_62','Um den kostenlosen Versand zu bekommen, fügen Sie bitte die gültige Artikel von ');
define('FS_SHOP_CART_ALERT_JS_63',' hinzu. ');
define('FS_SHOP_CART_ALERT_JS_64','Ihre Bestellung gilt als KOSTENLOSEN Versand. ');
define('FS_SHOP_CART_ALERT_JS_65','Kostenloser Versand bei Bestellung über 79,00 € für alle Artikel, die in unserer Politik von kostenlosem Versand enthalten sind.');
define('FS_SHOP_CART_ALERT_JS_66','Kostenloser Versand bei Bestellung über £79 für alle Artikel, die in unserer Politik von kostenlosem Versand enthalten sind.');
define('FS_SHOP_CART_ALERT_JS_67','Kostenloser Versand bei Bestellung über 79,00 € für alle Artikel, die in unserer Politik von kostenlosem Versand enthalten sind.');
define('FS_SHOP_CART_ALERT_JS_68','Kostenloser Versand bei Bestellung über £79 für alle Artikel, die in unserer Politik von kostenlosem Versand enthalten sind.');
define('FS_SHOP_CART_ALERT_JS_69','Sichere Bezahlung');
define('FS_SHOP_CART_ALERT_JS_70','Kaufen weiter');
define('FS_SHOP_CART_ALERT_JS_71','Kostenloser Versand bei Bestellung über AUD$99 für alle Artikel, die in unserer Politik von kostenlosem Versand enthalten sind.');
define('FS_SHOP_CART_ALERT_JS_72','Warenkorb speichern');
define('FS_SHOP_CART_ALERT_JS_72_1','Warenkorb speichern');
define('FS_SHOP_CART_ALERT_JS_73','Ihren Warenkorb per E-Mail senden');
define('FS_SHOP_CART_ALERT_JS_74','Drucken');
define('FS_SHOP_CART_ALERT_JS_75','Wieder Teilen');
define("FS_SHOP_CART_ALERT_JS_76_1","E-Mail senden");
define("FS_AJAX_DELETE1","wurde aus Ihrem Warenkorb erfolgreich entfernt.");
define("FS_AJAX_DELETE2","Wiederherstellen");

// 2018.7.23 fairy 底部反馈弹窗
define('FS_GIVE_FEEDBACK',' Feedback von FS');
define('FS_GIVE_FEEDBACK_TIP','Vielen Dank für Ihren Besuch bei FS. Ihr Feedback ist für uns sehr wichtig.');
define('FS_RATE_THIS_PAGE','Bewerten Sie Ihre Erfahrung bei FS.*');
define('FS_NOT_LIKELY','Ungenügend');
define('FS_VERY_LIKELY','Ausgezeichnet');
define('FS_TELL_US_SUGGESTIONS','Bitte wählen Sie ein Thema für Ihr Feedback*');
define('FS_ENTER_COMMENTS','Teilen Sie uns bitte Ihre Vorschläge oder Kommentare mit.');
define('FS_PROVIDE_EMAIL','Wenn Sie eine Rückantwort von uns erhKontaktdatenalten möchten, hinterlassen Sie bitte Ihre Kontaktdaten.');
define('FS_PROVIDE_EMAIL_TIP','Hinweis: Diese Informationen werden NICHT für andere Zwecke verwendet. Wir achten auf Ihre Privatsphäre.');
define('FS_FEEDBACK_THANKYOU','Sie haben dieses Produkt erfolgreich geteilt.');
define('FS_PRO_SHARE_EMAIL','Ihre Nachricht wurde gesendet.');
define('FS_FEEDBACK_THANKYOU_TIP_01','Ihre Meinung ist uns wichtig. Wir werden das Feedback nutzen, um Ihnen ein besseres Besuchserlebnis zu bieten.');
define('FS_FEEDBACK_THANKYOU_TIP_02','Ihre Zufriedenheit ist unser unermüdliches Streben und wir werden Ihnen weiterhin einen besseren Service und ein besseres Einkaufserlebnis bieten.');
define('FS_SHOP_CART_WAS_ACCOUNT','war');
define('FS_CHOOSE_ONE','Bitte wählen Sie');
define('FS_WEB_ERROR','Fehler der Webseite');
define('FS_FEEDBACK_PRODUCT','Produkt');
define('FS_ORDER_SUPPORT','Bestellunterstützung');
define('FS_TECH_SUPPORT','Technische Unterstützung ');
define('FS_SITE_SEARCH','Seitensuche');
define('FS_FEEDBACK_OTHER','Anderes');
define('FS_FEEDBACK_NAME','Name');
define('FS_FEEDBACK_EMAIL','E-Mail-Adresse');
define("FS_WAREHOUSE_AU","in Australien");
define("FS_WAREHOUSE_SG","in Singapur");
define('FS_LOGIN_REGIST_PWD_REQUIRED_TIP_COMMON',"Passwort ist Pflichtfeld.");
define('FS_LOGIN_REGIST_EMAIL_FORMAT_TIP_COMMON',"Bitte geben Sie eine gültige E-Mail-Adresse ein.(z.B.: someone@gmail.com)");
define('FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_COMMON',"E-Mail-Adresse ist Pflichtfeld.");
define('FS_LOGIN_REGIST_PWD_ERROR_TIP_COMMON',"Entschuldigung, Ihr Passwort ist nicht richtig, überprüfen Sie bitte noch einmal.");
define('FS_LOGIN_REGIST_EMAIL_NOT_FOUND_ERROR_COMMON',"Fehler: Die E-Mail-Adresse wurde in unseren Rekorde nicht gefunden. Bitte versuchen Sie es erneut.");
define('FS_LOGIN_REGIST_LOGIN_BANNED_COMMON', 'Fehler: Zugriff abgelehnt.');
define("FS_LOGIN_POPUP1","Zeitüberschreitung");
define("FS_LOGIN_POPUP2","Es ist abgelaufen und Sie wurden abgemeldet.");
define("FS_LOGIN_POPUP3","Geben Sie Ihr Passwort erneut ein, um zu weiter.");
define("FS_LOGIN_POPUP4","E-Mail-Adresse");
define("FS_LOGIN_POPUP5","Nicht Ihr Konto?");
define("FS_LOGIN_POPUP6","Passwort");
define("FS_LOGIN_POPUP7","Passwort vergessen?");
define("FS_LOGIN_POPUP8","Zeigen");
define("FS_LOGIN_POPUP9","Verbergen");
define("FS_ADDRESS_EDIT_TITLE","Aderesse bearbeiten");
define('FS_CHECK_OUT_TAX_DE','MwSt.');
define('FS_COMMON_WAREHOUSE_US_ES','FS.COM INC<br>
			380 Centerpoint Blvd<br>
			New Castle, DE 19720,<br>
			Vereinigte Staaten<br>
			Tel.: +1 425-326-8461
			');
define("GLOBAL_TEXT_NAME","Name des Karteninhabers");






//新增
define("FS_CHECKOUT_ERROR1","Ihr Vorname ist Pflichtfeld");
define("FS_CHECKOUT_ERROR2","Ihr Nachname ist Pflichtfeld");
define("FS_CHECKOUT_ERROR3","Dies ist ein Pflichtfeld.");
define("FS_CHECKOUT_ERROR4","Dies ist ein Pflichtfeld.");
define("FS_CHECKOUT_ERROR5","Dies ist ein Pflichtfeld.");
define("FS_CHECKOUT_ERROR6","Ihr Land ist Pflichtfeld");
define("FS_CHECKOUT_ERROR7","Ihre Telefonnummer ist Pflichtfeld");
define("FS_CHECKOUT_ERROR8","Ihre USt-IdNr. ist Pflichtfeld");
define("FS_CHECKOUT_ERROR9","Ihr Verwaltungsbezirk ist Pflichtfeld.");
define("FS_CHECKOUT_ERROR10","Name Ihrer Firma ist Pflichtfeld.");

define("FS_CHECKOUT_ERROR11","Gültige USt-IdNr. z.B.: DE123456789");
define("FS_CHECKOUT_ERROR12","Adresszeile 1 muss zwischen 4 und 300 Zeichen lang sein.");
define("FS_CHECKOUT_ERROR13","Ihr Vorname muss mindestens 2 Schriftzeichens enthalten.");
define("FS_CHECKOUT_ERROR14","Ihr Nachname muss mindestens 2 Schriftzeichens enthalten.");
define("FS_CHECKOUT_ERROR15","Ihre Postleitzahl sollte mindestens 3 Schriftzeichens sein.");
define("FS_CHECKOUT_ERROR16","Wir liefern nicht an Postfächer");
define("FS_CHECKOUT_ERROR17","Der Adresstyp ist Pflichtfeld.");
define("FS_CHECKOUT_ERROR18","Bitte wählen Sie eine Adresse.");
define("FS_CHECKOUT_ERROR19","Ihre gewählte Adresse fehlt Land. Bearbeiten Sie bitte erneut");
define("FS_CHECKOUT_ERROR20","Ihre gewählte Adresse fehlt Telefonnummer");
define("FS_CHECKOUT_ERROR21","Bitte aktualisieren Sie Ihre Lieferadresse ( füllen Sie Ihren Adresstyp und Ihre USt-IdNr. ).");

define("FS_CHECKOUT_DEFAULT","Standard");
define("FS_CHECKOUT_EDIT","Bearbeiten");
define("FS_CHECK_ACCOUNT","Versandkonto");
define("FS_CHECK_SELF","Meine Lieferanschrift als Rechnungsanschrift übernehmen");
define("FS_NETWORK_ERROR","Entschuldigung, es liegt ein Netzwerkfehler vor.");
define("FS_CHECKOUT_ERROR22","Ihr Versandkonto darf nicht leer sein");
define('FIBER_CHECK_SPARK','Bankkonto:');
define("FS_CHECKOUT_ERROR23",'Name auf Personalausweis ist Pflichtfeld.');
define("FS_CHECKOUT_ERROR24",'Telefonnummer ist Pflichtfeld.');
define("FS_CHECKOUT_ERROR25",'Abholzeit ist Pflichtfeld.');
define("FS_CHECKOUT_ERROR26",'E-Mail-Adresse ist Pflichtfeld.');
define("FS_CHECKOUT_ERROR27","Bitte aktualisieren Sie Ihre Lieferadresse ( Geben Sie Ihre Postleitzahl ein).");
define("FS_CHECKOUT_ERROR28","Geben Sie eine gültige Postleitzahl ein");
define("FS_CHECKOUT_NEW1",'Warenkorb');
define("FS_CHECKOUT_NEW2",'Zur Kasse');
define("FS_CHECKOUT_NEW3",'Erfolgreich');
define("FS_CHECKOUT_NEW4",'Lieferadresse');
define("FS_CHECKOUT_NEW6",'Standard einstellen');
define("FS_CHECKOUT_NEW7",' Eine neue Adresse hinzufügen');
define("FS_CHECKOUT_NEW8",'Eine neue Rechnungsadresse hinzufügen');
define("FS_CHECKOUT_NEW9",'Rechnungsadresse');
define("FS_CHECKOUT_NEW10",'Bitte geben Sie Ihre Rechnungsadresse ein.');
define("FS_CHECKOUT_NEW11",'Zahlungsarten');
define("FS_CHECKOUT_NEW12",'Zahlungsbedingungen: ');
define("FS_CHECKOUT_NEW13",'Produkte und Versandart sehen');
define("FS_CHECKOUT_NEW14",'Versandkosten');
define("FS_CHECKOUT_NEW15",'Ihre Artikel');
define("FS_CHECKOUT_NEW16",'Bestellkommentar hinzufügen');
define("FS_CHECKOUT_NEW17",'Kommentar');
define("FS_CHECKOUT_NEW18",'Auftrags-Nr.');
define("FS_CHECKOUT_NEW19",'Bitte geben Sie die Modellnummer Ihrer Geräte an, um die Kompatibilität zu gewährleisten.');
define("FS_CHECKOUT_NEW20",'Hinweise zum Versand, Paket oder andere Informationen sind für die Auftragsabwicklung hilfreich.');
define("FS_CHECKOUT_NEW21",'Bestellübersicht ');
define("FS_CHECKOUT_NEW22",'Zwischensumme:');
define("FS_CHECKOUT_NEW23",'Versandkosten:');
define("FS_CHECKOUT_NEW24",'Ihre Bestellung wird kostenlos versandt');
define("FS_CHECKOUT_NEW25","Durch Klicken auf die Schaltfläche oben stimmen Sie unseren ");
define("FS_CHECKOUT_NEW26","AGB");
define("FS_CHECKOUT_NEW27","Bestellung abschicken");
define('FS_CHECKOUT_NEW27_01','und');
define('FS_CHECKOUT_NEW27_02','Widerrufsrecht');
define('FS_CHECKOUT_NEW27_03','zu.');
define("FS_CHECKOUT_NEW28_NEW","Copyright &copy; 2009-".date('Y',time())." FS.COM GmbH Alle Rechte vorbehalten.");
define("FS_CHECKOUT_NEW29","Weiter");
define("FS_CHECKOUT_NEW30","Warenkorb bearbeiten ");
define("FS_CHECKOUT_NEW31","PayPal");
define("FS_CHECKOUT_NEW32","Kredit- oder Debitkarte");
define("FS_CHECKOUT_NEW33","Vorkasse");
define("FS_CHECKOUT_NEW34","Rechnung");
define("FS_CHECKOUT_NEW35"," BPAY");
define("FS_CHECKOUT_NEW36"," eNETS");
define("FS_CHECKOUT_NEW37","YANDEX");
define("FS_CHECKOUT_NEW38","WEBMONEY");
define("FS_CHECKOUT_NEW39","iDEAL");
define("FS_CHECKOUT_NEW40","SOFORT");
define("FS_CHECKOUT_NEW41","Gesamtsumme");
define("FS_CHECKOUT_NEW42"," und ");
define("FS_CHECKOUT_NEW43","Widerrufsrecht ");
define("FS_CHECKOUT_NEW44","zu.");
define('FIBERSTORE_FIRST_NAME','Vorname');
define('FIBERSTORE_LAST_NAME','Nachname');
define('FIBERSTORE_COUNTRY','Land/Region');
define("FS_CHECKOUT_ERROR30","Ihre E-Mail-Adresse ist Pflichtfeld.");
define("FS_CHECKOUT_ERROR31","Ihre E-Mail-Adresse ist nicht korrekt.");
define("FS_CHECKOUT_EXPIRED","Ist Ihre Anmeldung abgelaufen?");
define("FS_CHECKOUT_EXPIRED_CONFIRM","bestätigen");
define("FS_ADDRESS_MESSAGE3","Straßenadresse, c/o");
define("FS_ADDRESS_MESSAGE4","Wohnung, Suite, Einheit, Gebäude, Boden, usw.");define("CHECKOUT_TAXE_CN_FRONT1","Alle Bestellungen, die von unserem CN Warehouse nach Festlandchina, HK, Macao und Taiwan versandt werden, können KOSTENLOSE Versandkosten erhalten (nach Festland ist SF Express standardmäßig und Fedex IE ist standardmäßig nach HK, Macao und Taiwan).");
define("CHECKOUT_TAXE_CN_FRONT2","In Übereinstimmung mit dem Gesetz der Volksrepublik China über die Verwaltung der Steuererhebung (im Folgenden als LATC bezeichnet) ist FS.COM verpflichtet, 13% Mehrwertsteuer auf alle Bestellungen, die an Festlandchina geliefert werden, zu berechnen. Und für Bestellungen, die nach HK, Macao und Taiwan versandt werden, wird keine Mehrwertsteuer erhoben, aber diese Pakete können Einfuhr- oder Zollgebühren unterliegen, abhängig von den Gesetzen/Vorschriften der jeweiligen Destinationen. Zusätzliche Gebühren für die Zollabfertigung müssen vom Empfänger getragen werden.");
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","Die Lieferadresse stimmt nicht mit der Ihres Kreditantragsformulars überein. Bitte laden Sie Ihre Bestellung hoch, damit wir sie überprüfen können. Das Ergebnis wird innerhalb von 12 Stunden an Sie geschickt werden.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","Der Bestellbetrag übersteigt Ihr Kreditlimit in FS.COM. Um diese Bestellung schnell zu bearbeiten, zahlen Sie bitte die vorherigen Bestellungen aus, um das Kreditlimit zu revolvieren, oder gehen Sie zu <a href ='index.php?main_page=my_dashboard'>”Mein Konto”</a> und klicken Sie auf “Bestellung” , um die Erhöhung Ihres Kreditlimits zu beantragen. Wir senden Ihnen die Ergebnisse nach der Überprüfung per E-Mail.");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","Die Lieferadresse stimmt nicht mit den Adressen in Ihrem Kreditantragsformular überein und der Bestellbetrag übersteigt Ihr Kreditlimit in FS.COM.Diese Bestellung muss überprüft werden.Um diese Bestellung schnell zu bearbeiten, zahlen Sie bitte die vorherigen Bestellungen aus, um das Kreditlimit zu revolvieren, oder gehen Sie zu <a href ='index.php?main_page=my_dashboard'>”Mein Konto”</a> und klicken auf “Bestellung” um die Erhöhung Ihres Kreditlimits zu beantragen. Wir senden Ihnen die Ergebnisse nach der Überprüfung per E-Mail.");

define("FS_CHECKOUT_ERROR29","Bearbeiten Sie Ihre Adresse(geben Sie die gültige Postleitzahl).");
define("FS_CHECKOUT_ERROR35","Bearbeiten Sie Ihre Adresse(wählen Sie das gültige Land).");
define("CHECK_SEARCH","Suchen");
define("FS_PO_ADDRESS_04","Nachdem Sie diese Bestellung erfolgreich aufgegeben haben, müssen Sie die Sicherheit Ihrer Bestellung überprüfen, da die Lieferadresse nicht mit dem Icon \"PO\" markiert ist.");
define("FS_HSBC_INFO1","Name der Bank");
define("FS_HSBC_INFO2","Empfänger");
define("FS_HSBC_INFO3","IBAN:");
define("FS_HSBC_INFO4","BIC:");
define("FS_HSBC_INFO5","Konto-Nr:");
define("FS_HSBC_INFO6","Kontakt:");
define("FIBERSTORE_PRODUCTS","Produkte");
define("FIBERSTORE_PRODUCT","Produkt");
define("FIBERSTORE_RESULTS_BY01","Sortieren nach:");
define("FIBERSTORE_RESULTS_VIEW","Zeigen:");
//add by helun
define("FS_CHECKOUT_NEW16_NEW",'Bestellkommentar hinzufügen (Optional)');
define("FS_CHECKOUT_NEW17_NEW",'Hinterlassen Sie Kommentar, wenn Sie Forderung nach Versand, Verpackung, anpassbaren Produkten usw. haben.');
define("FS_CHECKOUT_NEW17_NEW_BLIND",'Hinterlassen Sie Anmerkungen bei Anforderungen an z.B. Blind-Shipment und maßgeschneiderte Produkte.');
define("FS_RELATED_EMAIL_TITLE_NEW","Der Lieferavis teilen (Optional)");
define('FS_AGAINST_BPAY_01','Bestelldatum:');
define('FS_AGAINST_BPAY_02','Gesamtbetrag:');
define('FS_AGAINST_BPAY_03','Ihr Einkauf werden in');
define('FS_AGAINST_BPAY_04','Bestellungen aufgeteilt.');
define('FS_AGAINST_BPAY_05','Voraussichtliche Lieferung');
define('FS_AGAINST_BPAY_06','Versand aus');
define('FS_AGAINST_BPAY_07','Bestellung');
define('FS_AGAINST_BPAY_08','von');
define('FS_AGAINST_BPAY_09','Weiter zu');
define('FS_AGAINST_BPAY_10','Sparkasse Freising');
define('FS_AGAINST_BPAY_11','FS.COM GmbH');
define('FS_AGAINST_BPAY_12','DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13','BYLADEM1FSI');
define('FS_AGAINST_BPAY_14','25674888');
define('FS_AGAINST_BPAY_15','Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16','817-888472-838');
define('FS_AGAINST_BPAY_17','HSBCHKHHHKH');
define('FS_CART_ITEM','Artikel)');
define('FS_CART_ITEMS','Artikel)');
define("CREDIT_CARD_NUMBER","Kartennummer");
define("CREDIT_CARD_DATE","Verfallsdatum ");
define("CREDIT_CARD_CVV","CVV");
define("CREDIT_CARD_PAY","Weiter");
define("FS_FESTIVAL9","");
define("FS_FESTIVAL10","");
/******meta标签语言包*****/
define("FS_META_PRO_01","Kaufen Sie ");
define("FS_META_PRO_02"," beim Hersteller für Rechenzentrums-, Enterprise- und ISP-Netzwerklösungen mit bestem Preis.");

define('FS_CHECKOUT_TIP_01','FS.COM akzeptiert verschiedene Zahlungsarten. Weitere Details finden Sie auf unserer Webseite ');
define('FS_CHECKOUT_TIP_02','Zahlungsarten');

define("FS_WAREHOUSE_SEA","Lager in Seattle");
define("FS_WAREHOUSE_DEL"," Lager in Delaware");
define("FS_COMMON_CHECKOUT_HSBC","Nachdem Sie die Zahlung überwiesen haben, erhalten wir sie normalerweise innerhalb von 1-3 Werktagen. Wir werden die Bestellung bearbeiten, sobald die Überweisung bestätigt wurde.");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","Bitte geben Sie bei der Zahlung Ihre FS-Bestellnummer an, damit Ihre Bestellung rechtzeitig bearbeitet werden kann. In der Regel erhalten wir das Geld innerhalb von 1-3 Werktagen. Das Inventar wird nicht reserviert, bis die Überweisung bestätigt ist.");
define("FS_WAREHOUSE_AREA_36","Versand aus dem Lager in Seattle");
define("FS_WAREHOUSE_AREA_37","Versand aus dem Lager in Delaware");
define("FS_LIVE_CHAT_CHECKOUT","Brauchen Sie Hilfe?  <a  href='javascript:;' onclick='LC_API.open_chat_window();return false;'>Live Chat</a> oder telefonisch unter");

//加購彈窗
define("FS_NEW_POPUP_01","Sie haben");
define("FS_CART_QTY","Menge:");
define("FS_CONTINUE_SHOPPING","Weiter einkaufen");
define("FS_NEW_POPUP_04","Zum Warenkorb");
define('FS_CUSTOMERS_ALSO','Kunden haben diese Produkte auch gekauft.');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'Warenkorb teilen');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'Warenkorb drucken');
define("FS_SHOP_CART_ALERT_JS_77","Zum Warenkorb");


define('FIBER_CHECK_ANZ','ANZ Bankkonto:');
define('FIBER_CHECK_ACCOUNT','Empfänger:');
define('FIBER_CHECK_PTY','FS.COM Pty Ltd');
define('FIBER_CHECK_BSB','BSB:');
define('FIBER_CHECK_013','013160');
define('FIBER_CHECK_ACCOUNT_NO','Kontonummer:');
define('FIBER_CHECK_4167','416794959');
define('FIBER_CHECK_SWIFT_CODE','SWIFT-Code:');
define('FIBER_CHECK_ANZBAU3M','ANZBAU3M');
define('FIBER_CHECK_BANK','Kontakt:');
define('FIBER_CHECK_ST_VIC','230 Swanston St, Melbourne, VIC, 3000');
define('FIBER_CHECK_TITLE_AU','Unsere Bankverbindung lautet:');

define('FS_SUCCESS_YOUR_NEXT','Im nächsten Schritt überweisen Sie uns bitte den Rechnungsbetrag an unser Bankkonto.');
define('FS_SUCCESS_WIRE','Banküberweisung');
define('FS_SUCCESS_ORDER','Drucken die Bestellung');
define('FS_SUCCESS_DETAIL','Unsere Bankverbindung lautet:');
define('FS_SUCCESS_BANK_NAME','Empfänger');
define('FS_SUCCESS_HSBC','FS.COM GmbH');
define('FS_SUCCESS_AC_NAME','Name der Bank');
define('FS_SUCCESS_CO','Sparkasse Freising');
define('FS_SUCCESS_AC_NO','IBAN');
define('FS_SUCCESS_TEL','DE16 7005 1003 0025 6748 88');
define('FS_SUCCESS_SWIFT','BIC');
define('FS_SUCCESS_HK','BYLADEM1FSI');
define('FS_SUCCESS_BANK_ADRESS','Kontakt');
define('FS_SUCCESS_ROAD','Untere Hauptstr.29, 85354, Freising');
define('FS_SUCCESS_OUR','Konto-Nr.');
define('FS_SUCCESS_NO','25674888');

define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07','FS.COM GmbH');
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');




define("FS_LOGIN_THIRD1","Liebe(r) ");
define("FS_LOGIN_THIRD2","-Benutzer");
define("FS_LOGIN_THIRD3","");

define("FS_LOGIN_THIRD4", "Wir bemerken, dass es ein registriertes FS.COM-Konto mit derselben E-Mail-Adresse gibt. Wir werden Ihr FS.COM-Konto verknüpfen, um Ihre persönlichen Daten und Präferenzen besser zu verwalten. Wenn Sie dieses FS.COM-Konto nicht kennen, kontaktieren Sie uns bitte.");
define("FS_LOGIN_THIRD5"," Redirect zu Ihrem FS.COM Konto in ");
define("FS_LOGIN_THIRD6","Sekunden");

/*
 * 新版详情页
 */
define('FS_PLEASE_SELECT','Bitte wählen Sie...');
define('FS_JUST_ADD','Sie haben ');
define('FS_POPUP_ITEM',' Artikel zum Warenkorb hinzugefügt.');
define('FS_COUNTINUE_SHOPPING','Weiter einkaufen');
define('FS_PRODUCT_SHIPPING','Versand');
define('FS_PRODUCT_RETURNS','Rückgabe');
define('FS_PRODUCT_LIVE_CHAT','Live-Chat');
define('FS_PRODUCT_EXPERT','Fragen Sie unsere Experten: ');
define('FS_PRODUCT_QUESTIONS','Fragen');
define('FS_PRODUCT_QUESTION','Frage');
define('FS_REVIEWS_PLACE','Geben Sie bitte Ihre Antwort ein.');
define('FS_REVIEWS_BY','Aus');
define('FS_REPLY_REVIEWS','1 Kommentar zeigen');
define('FS_PRODUCT_CART_POPUP','Kunden haben diese Produkte auch gekauft.');
define('FS_REVIEWS_REPORT','Fehler senden');

define("FS_PICK_UP_AT_WAREHOUSE","Selbstabholung ");
define("FS_TIME_ZONE_RULE_US_ES"," (EST)");
define("FS_TIME_ZONE_ADDRESS_US","<span>Lagerstandort:</span> 820 SW 34th Street Bldg W7 Suite H Renton, WA 98057, United States | +1 (877) 205 5306 ");
define("FS_TIME_ZONE_ADDRESS_DE","<span>Lagerstandort:</span> NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany | +49 (0) 8165 80 90 517 ");
define("FS_TIME_ZONE_ADDRESS_US_ES","<span>Lagerstandort:</span> 380 Centerpoint Blvd, New Castle, DE 19720, United States | +1 (425) 326 8461 ");
define("FS_TIME_ZONE_RULE_AU","(AEST)");
define("FS_JS_TIT_CHECK_AU","9:30am - 5pm ");

//checkout语言包
define('FS_UNITED','Vereinigte Staaten');
define('FS_AUSTRALIA','Australien');
define('FS_GERMANY','Deutschland');
//2018-9-15  add  ery  游客结算页面账号已存在提示语
define('FS_CHECKOUT_GUEST_LOG_MSG','Diese E-Mail-Adresse ist bereits registriert. Bitte melden Sie sich direkt an.<a href="'.zen_href_link('login').'">anmelden »</a>');
//装箱页面新增
define("FS_PRODUCT_INFO_SIZE","Packung:");
define("FS_PRODUCT_INFO_PIECE","nach Stück bestellen");
define("FS_PRODUCT_INFO_CASE","nach Kasten bestellen(");
define("FS_PRODUCT_INFO_PIS","Stk. /Kasten)");
define("FS_PRODUCT_INFO_PIS_1","Stk. /");
define('FS_PRODUCT_PRICE_EA','/Stk.');

//详情页政策弹窗
define('FS_PRODUCTS_INFO_VAT_05','Über Mehrwertsteuer');
define('FS_PRODUCTS_INFO_VAT_01','In Übereinstimmung mit den Gesetzen der Mitgliedsstaaten der Europäischen Union und demdeutschen Steuergesetz ist die FS.COM GmbH verpflichtet, für alle Bestellungen, die an Bestimmungsorte in Mitgliedsländern der Europäischen Union geliefert werden, 19% Mehrwertsteuer zu erheben (Für Frankreich beträgt der Mehrwertsteuersatz 20%).');
define('FS_PRODUCTS_INFO_VAT_02','Mehrwertsteuerbefreiung');
define('FS_PRODUCTS_INFO_VAT_03','Wenn Sie zu einem Unternehmen in European Union gehören und eine gültige USt-Identifikationsnummer haben, und die Bestellungen an der Europäischen Union außerhalb Deutschlands geliefert werden, wird keine Mehrwertsteuer erhoben.');
define('FS_PRODUCTS_INFO_VAT_04','Nachdem Sie die Lieferadresse auf der Checkout-Seite ausgefüllt haben, können Sie in der Bestellzusammenfassung den genauen Gesamtbetrag inklusive der entsprechenden Mehrwertsteuer sehen. <a href="shipping_delivery.html
">Mehr erfahren</a>');

//live chat留言邮件
define('FS_LIVE_CHAT_MAIL','Vielen Dank für Ihre Nachricht an <a href="'.zen_href_link('index','','SSL').'">FS.COM</a>. Das ist eine Bestätigungs-E-Mail, die Sie darüber informiert, dass wir Ihre Supportanfrage erhalten haben. Wir werden Ihre Nachricht überprüfen und uns innerhalb von 12 Stunden bei Ihnen melden.');
define('FS_LIVE_CHAT_MAIL_1','FS.COM - Nachricht bestätigen ');
define('FS_LIVE_CHAT_MAIL_2','Servicetyp:');
define('FS_LIVE_CHAT_MAIL_3','Ihre Nachricht:');

define("FS_OVERNIGHT_TITLE","Wenn wir Ihre Zahlung nach dem Annahmeschluss (17.00 EST) erhalten, wird Ihre Bestellung am nächsten Werktag versandt. Die Lieferung erfolgt nur an Werktagen.");
define("FS_OVERNIGHT_TITLE_UP","Wenn wir Ihre Zahlung nach dem Annahmeschluss (17.00 EST) erhalten, wird Ihre Bestellung am nächsten Werktag versandt. Die Lieferung erfolgt nur an Werktagen.");
define("CHECKOUT_TAX_NZ_CONTENT","Bei Bestellungen, die an Bestimmungsorte außerhalb Australiens geliefert werden, berechnet FS.COM nur die Artikel und den Versandkostenanteil. Für diese Pakete können jedoch Einfuhr- oder Zollgebühren anfallen, je nach den Gesetzen der Zielländer.<br/><br/> Etwaige Zoll- oder Einfuhrgebühren werden erhoben, sobald das Paket das Zielland erreicht. Zusätzliche Gebühren für die Zollabfertigung müssten von Ihnen selbst getragen werden.");
define("FS_TIME_ZONE_ADDRESS_AU","<span'>FS Melbourne Lagerhaus:</span> 57-59 Edison Rd, Dandenong South, VIC 3175, Australia | +61 3 9693 3488 ");
define("FS_RELATED_EMAIL_TITLE","Der Lieferavis teilen");
define("FS_RELATED_EMAIL_DESPRECTION","Die Versandbenachrichtigung wird an die E-Mail-Adresse (Standard) und die eingegebene E-Mail-Adresse gesendet.");
define("FS_RELATED_EMAIL_ERROR","Bitte geben Sie eine gültige E-Mail-Adresse ein");
define("FS_RELATED_EMAIl","E-Mail-Adresse");
define("FS_RELATED_NAME","Name");

// 税号模板 start
define("FS_CHECKOUT_VAX_CH","Bitte geben Sie eine gültige USt-IdNr. ein. z.B.: 00.000.000-0.");
define("FS_CHECKOUT_VAX_AR","Bitte geben Sie eine gültige USt-IdNr. ein. z.B.: 00-00000000-0.");
define("FS_CHECKOUT_VAX_BR_BS","Bitte geben Sie eine gültige USt-IdNr. ein. z.B.: 00.000.000/0000-00.");
define("FS_CHECKOUT_VAX_BR_IN","Bitte geben Sie eine gültige USt-IdNr. ein. z.B.: 000.000.000/00.");
define("FS_TAXT_TITLE_NOTICE","Ihre Bestellung kann die Mehrwertsteuer nicht berechnet wird, indem Sie eine korrekte und gültige USt-IdNr. angeben.");
define("FS_TAXT_TITLE_NOTICE_OTHER","Um die Zollabfertigung zu beschleunigen, geben Sie bitte eine gültige Steuernummer ein.");
// 税号模块 end

//2018-10-30  quest
define('FS_EMAIL_PAUSE',',&nbsp;');  //日语中的逗号有时是顿号
define("FS_NO_FREE_SHIPPING_US_HEAVY","Bestellungen mit schweren oder übergroßen Artikeln können nicht kostenfrei versandt werden.");
define("FS_NO_FREE_SHIPPING_DEAU_HEAVY","Bestellungen mit schweren oder übergroßen Artikeln können nicht kostenfrei geliefert werden.");
define("FS_NO_FREE_SHIPPING_AU_REMOTE","Wir berechnen die Versandkosten für die Bestellung, die an einen abgelegenen Bezirk geliefert wird.");
//request_stock
define("FS_EMAIL_REQUEST_STOCK_01","FS.COM - Lagerbestand anfragen  & Frage-Nummer: ");
define("FS_EMAIL_REQUEST_STOCK_02","Wir haben Ihre Anfrage nach mehr Lagerbestand für den Artikel #");
define('FS_EMAIL_REQUEST_STOCK_11',' erhalten.<br />Frage-Nr. :');
define("FS_EMAIL_REQUEST_STOCK_03","Hallo ");
define("FS_EMAIL_REQUEST_STOCK_04","Vielen Dank für die Übermittlung der Lageranforderung. Ihre Lageranforderung ist für uns sehr wichtig. Unser Verkäufer wird sich mit Ihnen in Verbindung setzen, um Ihre detaillierten Anforderungen zu verfolgen. ");
define("FS_EMAIL_REQUEST_STOCK_05"," Lagerverwaltungsteam wird auf Ihre Lageranforderung nehmen und unseren Bestandsplan optimieren. ");
define('FS_EMAIL_REQUEST_STOCK_06','Wenn Sie noch Fragen haben, rufen Sie uns bitte unter Tel. <a href="tel:+1 (877) 205 5306" style="color:#232323; text-decoration:none;">+1 (877) 205 5306</a> (USA), oder <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Deutschland). Sie können auch live chatten, um eine schnelle Antwort zu bekommen.');
define('FS_EMAIL_REQUEST_STOCK_07','Mit freundlichen Grüßen');
define('FS_EMAIL_REQUEST_STOCK_08','<a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Kundenservice-Team ');
define('FS_EMAIL_REQUEST_STOCK_09','Hallo');
define('FS_EMAIL_REQUEST_STOCK_10','FS.COM - Frage-Nummer: ');

define("FS_SURBSTREET_MAXLENGTH_ERROR","Adresszeile 2 enthält maximal 35 Zeichen.");
define("FS_TELEPHONE_MAXLENGTH_ERROR","Telefonnummer enthält maximal 15 Zeichen.");
define("FS_COMPANY_MAXLENGTH_ERROR","Der Firmenname muss zwischen 1 und 100 Zeichen lang sein.");
define("FS_FIRSTNAME_MAXLENGTH_ERROR","Vorname enthält maximal 35 Zeichen.");
define("FS_LASTNAME_MAXLENGTH_ERROR","Nachname enthält maximal 35 Zeichen.");
//2018.11.21   产品详情页价格税收提示
define('FS_PRICE_EXCL_VAT',' (exkl. MwSt.)');
define('FS_PRICE_INCL_VAT',' (inkl. MwSt.)');
define('FS_DE_TAX_TEXT', 'Je nach Ihrer Lieferadresse kann die Steuer an der Kasse variieren.');

//产品详情页新增弹窗语言包
define("FS_PRODUCTS_REORDERING","Umordnung");
define("FS_FOR_FREE_SHIPPING_GET_AROUND","Get it around");
define("FS_CHOOSE_LOCATION","Ihren Standort wählen");
define("FS_DELIVERY_OPTION","Lieferoptionen und Lieferzeit können für verschiedene Standorte variieren.");
define("FS_SHIP_OUTSIDE","Versand außerhalb ");
define("FS_SHIP_CONTINUE_SEE","Die genaue Versandkosten und der Liefertermin werden beim Kasse angezeigt.");
define("FS_SHIP_DONE","Bestätigen");
define("FS_REDIRECT_PART1","Kaufen Sie weiter in  ");
define("FS_REDIRECT_PART2"," und prüfen Sie die spezifischen Inhalte mit dem lokalen Preis und der Lieferung?");
define("FS_SHIP_TO","Versand nach");
define("FS_SHIP_CHANGE","ändern");
define("FS_SHIP_OR","oder");
define("FS_SHIP_ENTER","oder geben Sie eine ");
define("FS_SHIP_ZIP_CODE"," Postleitzahl ein");
define("FS_SHIP_APPLY"," Absenden");
define("FS_SHIP_ADD_NEW_ADDRESS","Eine neue Adresse hinzufügen");
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'">Anmelden</a> und Ihre Adressen ansehen');
define("FS_SHIP_MANAGE","Adressbuch bearbeiten");
define("FS_SHIP_TODAY","Versand am selben Tag");
define("FS_SHIP_GET_TODAY","Erhalten Sie das Paket vor dem Ende des heutigen Tages");
define("FS_PRODUCTS_POST_CODE_EMPTY_INVALID","Bitte geben Sie eine gültige Postleitzahl ein");
define('FS_PRODUCTS_CUSTOMIZE','maßgeschneidert');
define('SEARCH_OFFINE_7','Diese Webseite kann nicht gefunden werden.');
define('SEARCH_OFFINE_8','Dies kann daran liegen:');
define('SEARCH_OFFINE_9','Der Link zu dieser Seite wurde aktualisiert.');
define('SEARCH_OFFINE_10','Die Webadresse wurde falsch eingegeben.');
define('SEARCH_OFFINE_11','Prüfen Sie bitte die URL, oder besuchen Sie die <a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">Homepage</a>.');
define('SEARCH_OFFINE_12','Startseite zurück.');
define('FS_OUTDATED_LINK','Der Link ist veraltet.');

define("FS_SHIP_LIST_COUNTRY","Land/Region");
define("FS_SHIP_LIST_POST","Postleitzahl");
define("FS_SHIP_DELIVEY_TO","Liefern an");

define("FS_CN_HUBEI","Wuhan, Hubei");
define("FS_CN_APAC","in Asien");
define("FS_DE_MUNICH","München, Bayern");
define("FS_AU_VIC","Melbourne, Victoria");
define("FS_US_WA","Washington/Delaware");
define("FS_FOR_FREE_SHIPPING_GET_ARRIVE","Zustellung ca. am");
define("FS_APAC_NOTICE","Das FS Asien-Lagerhaus unterstützt den weltweiten Direktversand nach Singapur, Brasilien, China, Japan, Malaysia, Südkorea, den Vereinigten Arabischen Emiraten und anderen Gebieten.<a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define("FS_US_NOTICE","Das US-amerikanische Lager von FS befindet sich in Delaware und unterstützt den schnellen Versand am selben Tag. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define("FS_US_OTHER_NOTICE","FS USA-Lagerhäuse, die sich in Seattle und Delaware befinden, unterstützen den Versand am selben Tag nach der USA, Kanada und Mexiko.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define("FS_DE_OTHER_NOTICE","FS EU-Lagerhaus, die sich in München Bayern befindet, unterstützt den internationale Versand nach dem Vereinigte Königreich, der Europäische Union (EU) und den meisten europäischen Länder. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define("FS_DE_NOTICE","Artikel in dem Lager in München können schnell versandt werden. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define("FS_AU_OTHER_NOTICE","FS AU-Lagerhaus, die sich in Melbourne Victoria befindet, unterstützt den inländischen Versand am selben Tag und internationalen Versand nach Neuseeland.");
define("FS_NZ_OTHER_NOTICE","FS AU-Lagerhaus, die sich in Melbourne Victoria befindet, unterstützt den internationale Versand nach Neuseeland am selben Tag. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define("FS_CN_NOTICE","Das internationale Lager von FS befindet sich in Asien und unterstützt den schnellen Versand am selben Tag. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Die Artikel werden sofort versendet, sobald sie vorbereitet sind. Es kann zu Vorlaufzeiten bei der Herstellung kommen. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>erhältlich, Auf dem Transport</p> Die Artikel befinden sich auf dem Weg zu unserem Lager und werden nach Eintreffen versendet. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>erhältlich, Transport erforderlich</p> Die Artikel werden sofort versendet, sobald sie vorbereitet sind. Es kann zu Vorlaufzeiten bei der Herstellung kommen. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define('FS_AU_NOTICE',"Das AU Lager von FS befindet sich in Melbourne und unterstützt den schnellen Versand am selben Tag. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Mehr erfahren</a>");
define('FS_BUCK_NOTICE',"Schwere oder übergroße Artikel werden aus Lager in Asien versandt.");
define('FS_SG_NOTICE',"Das FS SG-Lager in Singapur unterstützt den schnellen Versand am selben Tag. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Mehr erfahren</a>");

//add by quest 2019-03-08
define("FS_NO_QTY_NOTICE","Ihre bestellte Artikel wurden aus unserem globalen Lagerhaus umgeladen.");
define("FS_NO_QTY_TAG_NOTICE","Die Artikel bereiten sich auf den Versand aus unserem globalen Lagerhaus vor.");
define("FS_NO_QTY_TAG_NOTICE_NEW","Der Artikel bereitet sich auf den Transport aus unserem Lagerhaus in Asien vor.");
define("FS_NO_QTY_NOTICE_NEW","Der Artikel bereitet sich auf den Transport aus unserem Lagerhaus in Asien vor.");

define("FS_SHIP_OR_OTHER","oder anderes Land wechseln");
define("FS_PRODUCTS_POST_CODE_EMPTY_ERROR","Ihre Postleitzahl ist Pflichtfeld");

//forward 运费
define("FS_FORWARD_SHIPPING","Spediteur (mit vorausbezahlten Zöllen und Steuern)");
define("FS_FORWARD_SHIPPING_NOTICE","Der angegebene Preis enthält die Versandkosten und eventuelle Zölle. Die erforderliche Versicherung wird ebenfalls berechnet und in der Bestellübersicht angezeigt.");
define('FS_CHECK_OUT_INSURANCE','Versicherung');

//postbank
define('FIBER_CHECK_COMMON_ACCOUNT','Konto-Nr.:');
define('FIBER_CHECK_COMMON_CODE','Bankleitzahl:');
define('FIBER_CHECK_COMMON_IBAN','IBAN:');
define('FIBER_CHECK_COMMON_BIC','BIC:');

define('FIBER_CHECK_DO_TITLE','US-$ Konto');
define('FIBER_CHECK_DO_ACCOUNT_VALUE','0902543668');
define('FIBER_CHECK_DO_CODE_VALUE','590 100 66');
define('FIBER_CHECK_DO_IBAN_VALUE','DE98 5901 0066 0902 5436 68');
define('FIBER_CHECK_DO_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_GB_TITLE','Britisch Pound GBP');
define('FIBER_CHECK_GB_ACCOUNT_VALUE','0902544661');
define('FIBER_CHECK_GB_CODE_VALUE','590 100 66');
define('FIBER_CHECK_GB_IBAN_VALUE','DE59 5901 0066 0902 5446 61');
define('FIBER_CHECK_GB_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_CH_TITLE','Swiss Franc CHF');
define('FIBER_CHECK_CH_ACCOUNT_VALUE','0902545664');
define('FIBER_CHECK_CH_CODE_VALUE','590 100 66');
define('FIBER_CHECK_CH_IBAN_VALUE','DE41 5901 0066 0902 5456 64');
define('FIBER_CHECK_CH_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_POST_TITLE','Postbank-Konto');
define('FIBER_CHECK_COMMON_ACCOUNT_NAME','Empfänger:');
define('FIBER_CHECK_COMMON_BANK','Name der Bank:');
define('FIBER_CHECK_COMMON_ADDRESS','Kontakt:');

define('FIBER_CHECK_SG_TITLE','OCBC Bankkonto');
define('FIBER_CHECK_SG_OCBC_USD','OCBC USD-Kontonummer:');
define('FIBER_CHECK_SG_OCBC_SGD','OCBC SGD-Kontonummer:');
define('FIBER_CHECK_SG_INT_BANK','Zwischengeschaltete Bank (für TT in USD)');
define('FIBER_CHECK_SG_SWIFT','SWIFT-Code:');
define('FIBER_CHECK_SG_BANK_CODE','Bankleitzahl:');
define('FIBER_CHECK_SG_BRANCH_CODE','Filialcode:');
define('FIBER_CHECK_SG_BRANCH_CODE_CONTENT','Die ersten 3 Ziffern Ihrer Kontonummer');
define('FIBER_CHECK_SG_BRANCH_NAME','Filialname:');
define('FIBER_CHECK_SG_BRANCH_NAME_CONTENT','Filiale NORTH');
define('FIBER_CHECK_SG_BANK_ADDRESS','Bankanschrift:');
define('FIBER_CHECK_SG_BANK_ADDRESS_CONTENT','65 Chulia Street, OCBC Centre, Singapore 049513');

define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE','FS.COM GmbH');
define('FIBER_CHECK_COMMON_BANK_VALUE','Postbank');
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE','Eckenheimer Landstr. 242 60320 Frankfurt');
define('FIBERSTORE_INFO_WIRE_DE','Sparkasse Bankkonto');
define('FS_COMMON_TT_BANK_DO','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Empfänger:  </td>
							<td><b>FS.COM GmbH</b></td>
						  </tr>
						  <tr>
							<td>Name der Bank: </td>
							<td><b>Postbank</b></td>
						  </tr>
						  <tr>
							<td>IBAN: </td>
							<td><b>DE98 5901 0066 0902 5436 68</b></td>
						  </tr>
						  <tr>
							<td>BIC: </td>
							<td><b> PBNKDEFF590</b></td>
						  </tr>
						  <tr>
							<td>Konto-Nr.: </td>
							<td><b>0902543668</b></td>
						  </tr>
						  <tr>
							<td>Bankleitzahl: </td>
							<td><b>590 100 66</b></td>
						  </tr>
                          <tr>
							<td>Kontakt: </td>
							<td><b>Eckenheimer Landstr. 242 60320 Frankfurt</b></td>
						  </tr>
					  </table>');
define('FS_COMMON_TT_BANK_GB','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Empfänger:  </td>
							<td><b>FS.COM GmbH</b></td>
						  </tr>
						  <tr>
							<td>Name der Bank: </td>
							<td><b>Postbank</b></td>
						  </tr>
						  <tr>
							<td>IBAN: </td>
							<td><b>DE59 5901 0066 0902 5446 61</b></td>
						  </tr>
						  <tr>
							<td>BIC: </td>
							<td><b> PBNKDEFF590</b></td>
						  </tr>
						  <tr>
							<td>Konto-Nr.: </td>
							<td><b>0902544661</b></td>
						  </tr>
						  <tr>
							<td>Bankleitzahl: </td>
							<td><b>590 100 66</b></td>
						  </tr>
                          <tr>
							<td>Kontakt: </td>
							<td><b>Eckenheimer Landstr. 242 60320 Frankfurt</b></td>
						  </tr>
					  </table>');
define('FS_COMMON_TT_BANK_CH','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Empfänger:  </td>
							<td><b>FS.COM GmbH</b></td>
						  </tr>
						  <tr>
							<td>Name der Bank: </td>
							<td><b>Postbank</b></td>
						  </tr>
						  <tr>
							<td>IBAN: </td>
							<td><b>DE41 5901 0066 0902 5456 64</b></td>
						  </tr>
						  <tr>
							<td>BIC: </td>
							<td><b> PBNKDEFF590</b></td>
						  </tr>
						  <tr>
							<td>Konto-Nr.: </td>
							<td><b>0902545664</b></td>
						  </tr>
						  <tr>
							<td>Bankleitzahl: </td>
							<td><b>590 100 66</b></td>
						  </tr>
                          <tr>
							<td>Kontakt: </td>
							<td><b>Eckenheimer Landstr. 242 60320 Frankfurt</b></td>
						  </tr>
					  </table>');
define('FS_COMMON_TT_BANK_DE','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Beneficiary Bank Name:  </td>
							<td><b>Sparkasse Freising</b></td>
						  </tr>
						  <tr>
							<td>Beneficiary A/C Name: </td>
							<td><b> FS.COM GmbH</b></td>
						  </tr>
						  <tr>
							<td>IBAN: </td>
							<td><b>DE16 7005 1003 0025 6748 88</b></td>
						  </tr>
						  <tr>
							<td>BIC: </td>
							<td><b> BYLADEM1FSI</b></td>
						  </tr>
						  <tr>
							<td>Account Number: </td>
							<td><b>25674888</b></td>
						  </tr>
                          <tr>
							<td>Beneficiary Bank Address: </td>
							<td><b>Untere Hauptstr.29, 85354, Freising</b></td>
						  </tr>
					  </table>');
//新版邮件
define("SEND_MAIL_1","Kostenloser Versand bei Bestellung über £79");
define("SEND_MAIL_2","Fiberstore Ltd, Part 7th Floor, 45 CHURCH STREET, Birmingham, B3 2RT");
define("SEND_MAIL_3","Kostenloser Versand bei Bestellung über $79");
define("SEND_MAIL_4","FS.COM INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");
define("SEND_MAIL_5","Kostenloser Versand bei Bestellung über 79,00 €");
define("SEND_MAIL_6","FS.COM GmbH, NOVA Gewerbepark, Gebäude 7, Am Gfild 7, 85375 Neufahrn, Deutschland");
define("SEND_MAIL_7","Kostenloser Versand bei Bestellung über A$99");
define("SEND_MAIL_8","FS.COM Pty Ltd, ABN 71 620 545 502,57-59 Edison Rd, Dandenong South, VIC 3175, Australien");
define("SEND_MAIL_9","Versand am selben Tag für vorrätige Artikel");
define("SEND_MAIL_10","FS.COM INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");

//超时取消订单
define('MANAGE_ORDER_RESTORE_1','Endet in 0 St.');
define('MANAGE_ORDER_RESTORE_2','Endet in. ');
define('MANAGE_ORDER_RESTORE_3','Bitte schließen Sie die Zahlung innerhalb von 30 Minuten ab. Andernfalls wird die Bestellung aufgrund von Änderungen der Bestände automatisch storniert.');
define('MANAGE_ORDER_RESTORE_4','Erneut kaufen');
define('MANAGE_ORDER_RESTORE_5','Bitte laden Sie Ihre Bestelldatei innerhalb von 7 tage hoch. Andernfalls wird die Bestellung aufgrund von Änderungen der Bestände automatisch storniert.');
define('MANAGE_ORDER_RESTORE_6','Bitte schließen Sie die Zahlung innerhalb von 2 tage ab. Andernfalls wird die Bestellung aufgrund von Änderungen der Bestände automatisch storniert.');
define('MANAGE_ORDER_RESTORE_7','Bitte schließen Sie die Zahlung innerhalb von 7 Tage ab. Andernfalls wird die Bestellung aufgrund von Änderungen der Bestände automatisch storniert.');
define('FS_SEARCH_YOUR_COUNTRY','Suchen Sie Ihr Land/Region');
define("FS_INQUIRY_SUBMITED",'Eingereicht');
define("FS_INQUIRY_QUOTED",'Notiert');
define("FS_INQUIRY_DEALED",'Bestellt');
define("FS_INQUIRY_CANCELED",'Storniert');
define("FS_INQUIRY_REVIEWING",'Wird geprüft');

// 个人中心详情页面
define("FS_INQUIRY_SUBTOTAL",'Gesamtsumme');
define("FS_INQUIRY_CHECKOUT",'Zur Kasse');
define("FS_INQUIRY_ADD_FILE",'Eine Datei hinzufügen');
define("FS_INQUIRY_CANCEL_SUCCESS",'Erfolgreich stornieren');
define("FS_NOTES",'Hinweise');

// 个人中心列表页面
define("FS_INQUIRY_TOTAL_QUOTE_NUMBER",'QUOTE_NUMBER Angebotsanfragen');
define("FS_INQUIRY_VIEW",'Ansehen');
define("FS_INQUIRY_CANCEL_THIS_QUOTE",'Stornieren Sie das Angebot?');
define("FS_INQUIRY_CANCEL_QUOTE_TIP1",'Sobald Sie das tun, kann es nicht wiederhergestellt werden.');
define("FS_INQUIRY_CANCEL_QUOTE_TIP2",'Wenn Sie das Angebot wirklich stornieren möchten, könnten Sie uns den Grund mitteilen? ');
define("FS_INQUIRY_CANCEL_REASON1",'Bereits von anderen gekauft');
define("FS_INQUIRY_CANCEL_REASON2",'Doppeltes Angebot');
define("FS_INQUIRY_CANCEL_REASON3",'Nicht mein gewünschtes Produkt');
define("FS_INQUIRY_CANCEL_REASON4",'Problem zur Garantie');
define("FS_INQUIRY_CANCEL_REASON5",'Lange Lieferzeit');
define("FS_INQUIRY_CANCEL_REASON6",'Zu teuer');
define("FS_INQUIRY_CANCEL_REASON7",'Brauchen nicht mehr');
define("FS_INQUIRY_CANCEL_REQUIRED_TIP",'Bitte füllen Sie vor dem Absenden die Gründe für die Stornierung des Angebots aus.');
define('FS_INQUIRY_EMPTY_PAGE_TIP','Es gibt noch keine Angebotsanfrage. Sie können eine Anfrage auf der Produktseite erstellen. ');
define('FS_INQUIRY_LIST_TIP','Sie können den Status Ihrer Anfrage überprüfen und direkt mit den Vorzugspreisen kaufen.');
define('FS_CANCEL_QUOTE','Anfrage stornieren');

//UK
define('FIBER_CHECK_ANZ_UK','HSBC Bank Account');
define('FS_SUCCESS_BANK_NAME_UK','Beneficiary Bank Name');
define('FS_SUCCESS_HSBC_UK','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME_UK','Beneficiary A/C Name');
define('FS_SUCCESS_CO_UK','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO_UK','Beneficiary A/C NO');
define('FS_SUCCESS_TEL_UK','817-888472-838');
define('FS_SUCCESS_SWIFT_UK','SWIFT Address');
define('FS_SUCCESS_HK_UK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS_UK','Beneficiary Bank Address');
define('FS_SUCCESS_ROAD_UK','1 Queen\'s Road Central, Hong Kong');
// 添加购物车成功弹窗
define('FS_ADDED_ONE_ITEM','Sie haben [ADDITEM] Artikel hinzugefügt.');
define('FS_ADDED_MORE_ITEM','Sie haben [ADDITEM] Artikel hinzugefügt.');
define('FS_ADDED_TO_CART','Hinzugefügt');

//站点融合整理 邮件标点符号整理成常量
define('FS_EMAIL_COMMA',',');   //逗号
define('FS_EMAIL_POINT','.'); //句号
define('FS_EMAIL_PERIOD','.');

//print_order & print_main_order
define('FS_PRINT_ORDER_TEL','Tel.: ');
define('FS_PRINT_ORDER_NUM','USt-IdNr.:');
define('FS_PRINT_ORDER_CREDIT','Kredit- oder Debitkarte');
define('FS_PRINT_ORDER_PURCHASE','Purchase Order');
define('FS_PRINT_ORDER_BANK','Banküberweisung');
define('FS_PRINT_ORDER_WESTERN','Western Union');
define('FS_PRINT_ORDER_FREE','Kostenlos');

//2018-8-29  credit付款页面
define('FS_CREDIT_CARD_NUMBER','Kartennummer');
define('FS_CREDIT_EXPIRY_DATE','Ablaufdatum');
define('FS_CREDIT_CONTINUE','Weiter');
//2018-8-31   shoppint_cart 页面分享
define('FS_SHARE_AGAIN','Wieder senden');
//manage_orders
define('FS_MANAGE_ORDERS_PUR','Auftragsnummer');
define('FS_PAGE_NOT_FOUND','Seite nicht gefunden');
define('FS_CUSTOMILIZED_ADD_TO_CART','In den Warenkorb');
define('FS_REQUIRED_DATE','Lieferdatum');
define("FS_EMAIL_ERROR","Ihre E-Mail-Adresse ist nicht korrekt");
define('FS_TOTAL_SAVINGS','Total Savings');

/**
 *评论邮件
 */
define('FS_EMAIL_TO_US_DEAR','Hallo ');
define('EMAIL_MESSAGE_TITLE_REVIEWS',' Bewertung erhalten');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS - Vielen Dank für Ihre Bewertung.');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','Wir sind so dankbar für Ihre freundlichen Worte und freuen uns, dass wir Ihnen eine gute Benutzererfahrung geboten haben.');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','Ihre Bewertung hilft uns dabei, die Benutzererfahrung ständig zu verbessern, indem wir wissen, was wir richtig gemacht haben und was wir sonst noch tun können.');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','Es tut uns leid, dass Ihre Erfahrung nicht Ihren Erwartungen entspricht. Hoffentlich ist diese Situation sehr selten und wir werden uns weiter verbessern.');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','Ihr Account Manager wird Sie innerhalb von 48 Stunden kontaktieren. Wir hoffen aufrichtig, alle Ihre Probleme möglichst schnell lösen zu können.');
define('FS_EMAIL_REVIEWS_THANKS','Vielen Dank');
define('FS_EMAIL_REVIEWS_TEAM','FS-Team');
define('FS_EMAIL_REVIEWS_WELL_HEADER','Vielen Dank für Ihre Bewertung und wir werden weiterhin wie gewohnt die optimierten Produkte anbieten.');
define('FS_EMAIL_REVIEWS_BAD_HEADER','Vielen Dank für Ihre Bewertung und wir werden Ihnen helfen, möglichst schnell Ihre Probleme zu lösen.');

//客户取消订单邮件
define('FS_CANCEL_ORDER',"Your order#");
define('FS_CANCEL_ORDER_1',"has been canceled");
define('FS_CANCEL_ORDER_2',"As you requested, we've canceled your reserved order# ");
define('FS_CANCEL_ORDER_3',". We're sorry it didn't work out and hope you'll shop with us again soon.");
define('FS_CANCEL_ORDER_4',"If you have any questions, please <a href='contact_us.html'>contact us</a>. Hope to see you again soon!");
define('FS_CANCEL_ORDER_5',"Customer Email Address:");
define('FS_CANCEL_ORDER_6',"Bestellnummer: ");
define('FS_CANCEL_ORDER_7',"Reason:");
define('FS_CANCEL_ORDER_8','Order# ');
define('FS_PRODUCTS_JS_MOQ','Das MOQ dieser Produkte ist');
define('FS_PRODUCTS_JS_UPPER','Keine Obergrenze');
define('NEWS_FS_ATTRIBUTE_OEM','Beschriftungsservice');
//2019-1-9
define('FS_EMAIL','de@fs.com');
define('FS_PAY_WAY_PAYPAL','Paypal');
define('FS_PRODUCT_INFO_STEP','Schritt');
define('FS_REVIEWS_COMMENT_DEACRIPTION','Schreiben Sie bitte Ihren Kommentar...');

define('FS_REVIEWS34',' Hilfreich');
define('FS_REVIEWS35',' Hilfreich');
define('FS_REVIEW_REPORT','Fehler senden');
define('FS_REVIEWS31','');
define('FS_REVIEWS32','Antwort(en)');
define('FS_BY','Aus');
define('FS_REVIEWS36','Antwort(en)');
define('FS_REVIEWS_STARS_TITLE','von 5 Sternen');
define('FS_READ_MORE','Mehr');
define('FS_SEE_LESS','Weniger');


//四级分类名称
define('FS_CATEGORIES_01','Produkttyp');
define('FS_CATEGORIES_02','Klassifikation der Produkte');
define('FS_CATEGORIES_03','Werkzeugtyp');
define('FS_CATEGORIES_04','Typ der Medienkonverter');
define('FS_CATEGORIES_05','Kabeltyp');
define('FS_CATEGORIES_06','Typ der KVM Switche');
define('FS_CATEGORIES_07','Type de Convertisseurs de Vidéo');
define('FS_CATEGORIES_08','Anwendung');

define("FS_ECHECK_NOTICE","* Wir akzeptieren nur elektronische Schecks der Banken von den USA. Normalerweise dauert die Bearbeitung der Zahlung 1-2 Werktage.");
define("FS_ECHECK_BANK_ACCOUNT","Empfänger");
define("FS_ECHECK_BANK_ACCOUNT_NUMBER","Bankkontonummer");
define("FS_ECHECK_BANK_ACCOUNT_TYPE","Konto-Typ");
define("FS_ECHECK_BANK_ACCOUNT_CHECK","Checking");
define("FS_ECHECK_BANK_ACCOUNT_SAVE","Saving");
define("FS_ECHECK_BANK_ACCOUNT_CONFIRM","Bankkontonummer bestätigen");
define("FS_ECHECK_BANK_ACCOUNT_ROUTE","ABA /ACH routing Nummer");
define("FS_ECHECK_ERROR_1","Empfänger ist Pflichtfeld.");
define("FS_ECHECK_ERROR_2","Bankkontonummer ist Pflichtfeld.");
define("FS_ECHECK_ERROR_3","Konto-Typ ist Pflichtfeld.");
define("FS_ECHECK_ERROR_4","Bestätigen Sie bitte die Bankkontonummer.");
define("FS_ECHECK_ERROR_5","Bank ABA /ACH routing Nummer ist Pflichtfeld.");


define("FS_PRODUCTS_PICK_UP","Selbstabholung, Abholdatum Mo - Fr ");
define("FS_PRODUCTS_VIA","durch");

//new_cart
define('FS_NEW_SHIPPING_FREE','Die Bestellung gilt als KOSTENLOSEN Versand!');
define('FS_GO_SHOPPING','Weiter einkaufen');
define('FS_ENTERPRISE_NETWORK','Unternehmensnetzwerk');
define('FS_OTN_SOLUTION',' OTN-Lösung ');
define('FS_DATA_CENTER_SOLUTION','Lösung für Rechenzentrum');
define('FS_OEM_SOLUTION',' OEM-Lösung');
define('FS_RECENTLY_VIEWED','Zuletzt angesehen');
define('FS_CART_TIP','Haben Sie schon ein Konto bei FS? Sie können sich <a target="_blank" href="'.zen_href_link('login','','SSL').'" class="cart_no_23Link">anmelden</a>, um die Artikel im Warenkorb zu sehen oder zu bearbeiten.');
define('FS_ADDED_TO_CART','Zum Warenkorb hinzufügen');
define('FS_REMOVED','Entfernen');
define('FS_SHOP_CART_MOVE','In den Warenkorb');
define('FS_SHOP_CART_SAVE','Für später speichern');
define('FS_SHOP_CART_SIMILAR','Ähnliche Produkte anzeigen');
define('FS_SHOP_CART_SAVED','Gespeicherte Artikel');
define('FS_CART_EMPTY','Ihr Warenkorb ist leer.');
define('FS_SVAE_FOR_LATER_TIP',' wurde für später gespeichert.');
define('FS_MOVE_TO_CART_TIP',' wurde in Ihren Warenkorb gelegt.');
define('FS_DELETE_FOR_LATER','Gespeicherte Artikel löschen');
define('FS_DELETE_SURE_SAVE','Möchten Sie diese gespeicherte Artikel wirklich löschen?');
define('FS_DELETE_SURE','Löschen Sie ');
define('FS_DELETE_CART_TITLE','Gespeicherten Warenkorb löschen');
define('FS_SYMBOL',',');
define('FS_SHOP_CART_ALERT_JS_43','Ihr Name ist Pflichtfeld.');
define('FS_SHOP_CART_ALERT_JS_43_01',"Der Name des Empfängers ist Pflichtfeld.");
define('FS_SHOP_CART_ALERT_JS_44','Ihre E-Mail-Adresse ist Pflichtfeld.');
define('FS_SHOP_CART_ALERT_JS_44_01',"Die E-Mail-Adresse des Empfängers ist Pflichtfeld.");
define('FS_SHOP_CART_ALERT_JS_45','Bitte geben Sie eine gültige E-Mail-Adresse ein.');
define('FS_SHOP_CART_ALERT_JS_46','An den Account Manager senden');
define('FS_PLACEHOLDER','Maximal 500 Schriftzeichens');

define('FS_PURCHASE_NUMBER','Auftragsnummer');

//下架产品气泡，提示
define('FS_PRODUCT_OFF_TEXT','Der Artikel wurde entfernt und kann nicht mehr verfügerbar sein.');
define('FS_PRODUCT_OFF_TEXT_2','Die folgenden Artikel wurden entfernt und können nicht mehr verfügbar bei FS.COM sein.');
define('FS_PRODUCT_OFF_TEXT_3','Attribute auswählen');
define('FS_PRODUCT_OFF_TEXT_4','Die Attribute der folgenden maßgeschneiderten Artikel haben sich geändert. Gehen Sie bitte zur Produktdetailseite, um Attribute auszuwählen.');
define('FS_PRODUCT_OFF_TEXT_5','*Einige Artikel in dieser Bestellung können nicht in den Warenkorb gelegt werden.');
define('FS_PRODUCT_OFF_TEXT_6','Ihre Bestellung enthält die nicht verfügbaren Artikel, überspringen Sie und laden Sie die Bestelldatei hoch.');
define('FS_PRODUCT_OFF_TEXT_7','Die folgenden Artikel sind nicht mehr verfügbar und werden beim Kasse nicht im Gesamtpreis berechnet.');
define('FS_PRODUCT_OFF_TEXT_8','Ein Artikel in Ihrem Warenkorb ist nicht verfügbar und wird auf der Kassen-Seite nicht angezeigt.');
define('FS_PRODUCT_OFF_TEXT_9','Diese Artikel in Ihrem Warenkorb sind nicht verfügbar. Sie werden nicht auf der Kassen-Seite angezeigt.');

define('FS_PRODUCT_CLEARANCE_TEXT','Dieses Produkt ist möglicherweise nicht auf Lager. Bitte wenden Sie sich an Ihren Account Manager für die Verfügbarkeit.');
define('FS_PRODUCT_CLEARANCE_TEXT_1','Die von Ihnen angegebene Menge übersteigt den verfügbaren Bestand und wurde entsprechend angepasst. Bitte wenden Sie sich an Ihre Vertriebsmitarbeiterin, um weitere Mengen zu erhalten.');

//fairy 2019.1.15 add
define('FS_COLOR_RED','Rot');
define('FS_COLOR_BLUR','Blau');
define('FS_COLOR_GREEN','Grün');

//账户中心
define('FS_MANAGE_ORDERS_1','Die folgenden Informationen beziehen sich alle auf Endbenutzer oder Switch Operator. Dies ist für die Bereitstellung technischer Supportleistungen unerlässlich. Bitte stellen Sie sicher, dass alle Informationen wahr und effektiv sind.');
define('FS_MANAGE_ORDERS_2','Bewerbung eingereicht');
define('FS_MANAGE_ORDERS_3','Lizenzschlüssel : ');
define('FS_MANAGE_ORDERS_4','Schritte : ');
define('FS_MANAGE_ORDERS_5','Lizenzschlüssel erhalten');
define('FS_MANAGE_ORDERS_6','Aktivierung abgeschlossen');
define('FS_MANAGE_ORDERS_7','Informationen wurden erfolgreich abgesandt. Wir werden Ihnen in Kürze eine E-Mail mit dem Lizenzschlüssel senden, um den Switch zu aktivieren.');
define('FS_MANAGE_ORDERS_8','N Serie Cumulus Switches');
define('FS_MANAGE_ORDERS_9','Lizenzschlüssel der N Serie Cumulus Switches');
define('FS_MANAGE_ORDERS_10','Hallo ');
define('FS_MANAGE_ORDERS_11','Ihr Lizenzschlüssel ist ');
define('FS_MANAGE_ORDERS_12','Hinweis: Die Bestätigung des Lizenzschlüssels dauert ca. 3 Tage. Nachdem die Überprüfung abgeschlossen ist, können Sie den Schlüssel in den Switch importieren. ');
define('FS_MANAGE_ORDERS_13','1. Lizenznutzung und Einschränkungen');
define('FS_MANAGE_ORDERS_14','Der Lizenzschlüssel ist langfristig und effektiv.');
define('FS_MANAGE_ORDERS_15','Ab dem Datum der Aktivierung können Sie 1 Jahr sowie 45 Tage technischen Support-Service genießen. (Der zusätzliche kostenlose Service wäre überfällig, wenn Sie ihn nicht innerhalb von 45 Tagen nutzen.).');
define('FS_MANAGE_ORDERS_16','Wenn der Service abläuft, können Sie den Service weiterhin bestellen.');
define('FS_MANAGE_ORDERS_17','2. Lizenzschlüssel-Importvorgang');
define('FS_MANAGE_ORDERS_18','Bitte überprüfen Sie die folgenden Ressourcen, um die Lizenz zu importieren:');
define('FS_MANAGE_ORDERS_19','Wir heißen Sie herzlich willkommen, wenn Sie während des Lizenzierungsvorgangs Fragen haben oder den technischen Support erweitern möchten. Unsere Kontaktinformationen lauten wie folgt:');
define('FS_MANAGE_ORDERS_20','E-Mail: ');
define('FS_MANAGE_ORDERS_21','Telefon: +1 (877) 205 5306 (PST)');
define('FS_MANAGE_ORDERS_22','+1 (888) 468 7419 (EST)');
define('FS_MANAGE_ORDERS_23','Stellen Sie sicher, dass dieser Lizenzschlüssel in sicheren Händen ist, und importieren Sie ihn bei Bedarf in den Switch.');
define('FS_MANAGE_ORDERS_24','mit freundlichen Grüßen');
define('FS_MANAGE_ORDERS_25','FS.COM IT-Abteilung');
define('FS_MANAGE_ORDERS_26','Video: ');
define('FS_MANAGE_ORDERS_26_1','Video');
define('FS_MANAGE_ORDERS_27','PDF: ');
define('FS_MANAGE_ORDERS_28','Telefon: ');
define('FS_MANAGE_ORDERS_29','Kostenloser Versand bei Bestellung über 79,00 €');
define('FS_MANAGE_ORDERS_30','Lizenzschlüssel erhalten');
define('FS_MANAGE_ORDERS_31','Hallo ');
define('FS_MANAGE_ORDERS_32','Ihr Lizenzschlüssel ist ');
define('FS_MANAGE_ORDERS_33','Leaf(10G/25G): 556688 <br />Spine(40G/100G): 335521');
define('FS_MANAGE_ORDERS_34','Hinweis: ');
define('FS_MANAGE_ORDERS_35','1. Der Lizenzschlüssel ist langfristig und effektiv. Bitte stellen Sie sicher, dass dieser Lizenzschlüssel sicher bleibt. Die Bestätigung des Lizenzschlüssels dauert ca. 3 Tage.');
define('FS_MANAGE_ORDERS_36','2. Nachdem die Überprüfung abgeschlossen ist, können Sie den Schlüssel in den Switch importieren. Ab dem Datum der Aktivierung können Sie 1 Jahr sowie 45 Tage technischen Support-Service genießen. Der zusätzliche kostenlose Service wäre überfällig, wenn Sie ihn nicht innerhalb von 45 Tagen nutzen. Wenn der Service abläuft, können Sie den Service weiterhin bestellen.');
define('FS_MANAGE_ORDERS_37','Wie importieren Sie einen Lizenzschlüssel');
define('FS_MANAGE_ORDERS_38','Bitte überprüfen Sie die folgenden Ressourcen, um zu helfen:');
define('FS_MANAGE_ORDERS_39','Wir heißen Sie herzlich willkommen, wenn Sie während des Lizenzierungsvorgangs Fragen haben oder den technischen Support erweitern möchten. Unsere Kontaktinformationen lauten wie folgt:');
define('FS_MANAGE_ORDERS_40','E-Mail: <a style="text-decoration: none;color: #232323;">tech@fs.com</a> <br />Telefon: +33 (1) 82 884 336');
define('FS_MANAGE_ORDERS_41','Mit freundlichen Grüßen');
define('FS_MANAGE_ORDERS_42','FS.COM Technisches Team');
define('FS_MANAGE_ORDERS_43','Ihr Firmenname ist Pflichtfeld');
define('FS_MANAGE_ORDERS_44','Ihr Name ist Pflichtfeld');
define('FS_MANAGE_ORDERS_45','Ihre Telefonnummer ist Pflichtfeld');
define('FS_MANAGE_ORDERS_46','Ihre E-Mail-Adresse ist Pflichtfeld');
define('FS_MANAGE_ORDERS_47','Ihre angegebene E-Mail-Adresse wird nicht erkannt.(z.B.: someone@example.com).');
define('FS_MANAGE_ORDERS_48','Bitte klicken Sie auf die Schaltfläche des EULA-Vertrages');
define('FS_MANAGE_ORDERS_49','Ihre Web-Adresse ist Pflichtfeld');
define('FS_MANAGE_ORDERS_50','Diese Nachricht wurde an gesendet ');
define('FS_MANAGE_ORDERS_51','Kostenloser Versand: Es gelten einige Ausschlussklauseln.');
define('FS_MANAGE_ORDERS_52','Mehr Informationen über unsere ');
define('FS_MANAGE_ORDERS_53','Versandbedingungen');
define('FS_MANAGE_ORDERS_54','FS.COM GmbH');
define("CULUMS_OFF64","Die Informationen wurden bereits erfolgreich übermittelt. Sie müssen nicht erneut senden.");
define("CULUMS_OFF65","Informationen des Artikels");
define("CULUMS_OFF1","Die Aktivierung beantragen");
define("CULUMS_OFF2","Die folgenden Informationen beziehen sich alle auf Endbenutzer oder Switch Operator. Dies ist für die Bereitstellung technischer Supportleistungen unerlässlich. Bitte stellen Sie sicher, dass alle Informationen wahr und effektiv sind. ");
define("CULUMS_OFF3","Firmenname");
define("CULUMS_OFF4","Benutzername");
define("CULUMS_OFF5","Telefon");
define("CULUMS_OFF6","E-Mail-Adresse");
define("CULUMS_OFF7","Webadresse");
define("CULUMS_OFF8","EULA-Vereinbarung.");
define("CULUMS_OFF9","Cumulus Networks®");
define("CULUMS_OFF10","Die Aktivierung beantragen");
define("CULUMS_OFF11","Endbenutzer-Software-Lizenzvertrag");
define("CULUMS_OFF12","Diese Lizenzbedingungen sowie die Ihnen (“Lizenznehmer”) von Cumulus Networks, Inc. (“Cumulus”) oder einem von Cumulus autorisierten Wiederverkäufer zum Vertrieb von Cumulus-Software (“Autorisierter Wiederverkäufer”) erteilte Bestellbestätigung sind eine Vereinbarung zwischen Cumulus und Ihnen. Diese Bedingungen gelten für die Software, mit der sie vertrieben werden, einschließlich der Medien, auf denen Sie sie erhalten haben. Die Bedingungen gelten auch für alle Aktualisierungen, Ergänzungen und Supportleistungen von Cumulus für die Software, die Cumulus Ihnen zur Verfügung stellt, sofern diese Bedingungen nicht durch andere Bestimmungen ergänzt werden. Wenn ja, gelten diese Bedingungen. Durch die Verwendung der Software bestätigen Sie, dass Sie über eine gültige Auftragsbestätigung für jede von Ihnen verwendete Kopie der Software verfügen und dass Sie diese Bedingungen in Verbindung mit jeder Kopie akzeptieren.");
define("CULUMS_OFF13","BENUTZEN SIE DIE SOFTWARE NICHT, WENN SIE DIESE BEDINGUNGEN NICHT ANNEHMEN. DURCH DIE NUTZUNG DER SOFTWARE AKZEPTIEREN SIE DIE VORLIEGENDEN LIZENZVEREINBARUNGEN (“Vereinbarung”) UND ERKLÄREN SICH DAMIT EINVERSTANDEN.");
define("CULUMS_OFF14","BEWERTUNGS-, BETA- UND NFR-LIZENZEN. Wenn Sie eine Lizenz für das Produkt erhalten, die von Cumulus als Evaluierungs- oder Beta-Lizenz bezeichnet wird, gelten für Ihre Lizenz die folgenden zusätzlichen Einschränkungen: Sofern nicht ausdrücklich von Cumulus schriftlich genehmigt, ist Ihre Verwendung des Produkts (i) nur zulässig für eine Dauer von 30 Tagen in einer internen Nichtproduktionsumgebung (nur Test und Bewertung); und (ii) ist auf höchstens fünf gleichzeitige Instanzen des Produkts beschränkt, die ausschließlich auf Hardware laufen, die sich im Besitz von Ihnen befindet oder von Ihnen allein kontrolliert wird, sofern keine anderweitige Genehmigung von Cumulus vorliegt. Wenn Sie eine Lizenz für das Produkt erhalten, die von Cumulus als Not-For-Resale (NFR) -Lizenz gekennzeichnet ist, gelten für Ihre Lizenz die folgenden zusätzlichen Einschränkungen: Ihre Verwendung des Produkts ist (i) nur für Nutzung auf Hardware zulässig, die sich im Besitz von Ihnen befindet oder von Ihnen allein kontrolliert wird, und Sie sind ein angesehener Partner im Rahmen des geltenden Cumulus Partnerprogramms, durch das Sie die NFR-Lizenz erhalten haben. (ii) beschränkt auf Produktdemonstrationen, Tests und Schulungen (keine Produktion, Informationsverarbeitung oder Nutzung der Infrastruktur erlaubt). Ungeachtet anders lautender Bestimmungen werden Evaluierungs-, Beta-Lizenz-, NFR-lizenzierte Produkte und alle von Cumulus als Early Access identifizierten Produkte (oder Teile davon) “AS-IS” ohne Entschädigung, Support oder Garantien jeglicher Art, weder ausdrücklich noch stillschweigend, zur Verfügung gestellt. Sie übernehmen alle Risiken, die mit der Verwendung von Evaluierungs-, Beta-Lizenz- und NFR-Produkten verbunden sind. DIESE VEREINBARUNG KANN NUR DURCH EINE SEPARATE UNTERZEICHNETE SCHRIFTLICHE VEREINBARUNG MIT CUMULUS NETWORKS, INC. ERSETZT WERDEN, DIE AUSDRÜCKLICH AUF DIESE VEREINBARUNG VERWEIST UND DIESE ERSETZT (“ERSATZVEREINBARUNG”).");
define("CULUMS_OFF15","Die Parteien vereinbaren Folgendes:");
define("CULUMS_OFF16","1. Definitionen");
define("CULUMS_OFF17","a. “Produkt” bezeichnet die ausführbare(n) Version(en) der Netzwerksoftware, die von Cumulus zur Verfügung gestellt wird, wie in der Auftragsbestätigung (siehe Abschnitt 3a) ausdrücklich definiert und für den Lizenznehmer bestimmt, einschließlich aller Updates und neuen Versionen des Produkts, die dem Lizenznehmer im Rahmen dieser Vereinbarung und der entsprechenden Endbenutzer-Dokumentation zur Verfügung gestellt werden.");
define("CULUMS_OFF18","b. “Geschützte Informationen” sind alle Erfindungen, Algorithmen, Know-how und Ideen sowie alle anderen geschäftlichen, technischen und finanziellen Informationen, die eine Partei von der anderen Partei erhält, wenn: a) sie bei oder vor der Offenlegung als vertraulich oder urheberrechtlich geschützt identifiziert wurden oder b) eine vernünftige Person davon ausgehen würde, dass diese Informationen angesichts des Inhalts oder der Umstände der Offenbarung vertraulich sind.");
define("CULUMS_OFF19","c. “Eigentumsrechte” sind Patentrechte, Urheberrechte, Geschäftsgeheimnisrechte, Datenbankrechte und alle anderen geistigen und gewerblichen Schutzrechte jeglicher Art.");
define("CULUMS_OFF20","2. Lizenzvergabe");
define("CULUMS_OFF21","a. Vorbehaltlich der vollständigen Zahlung gemäß Abschnitt 3 und der Einhaltung der anderen Bestimmungen und Bedingungen durch den Lizenznehmer gewährt Cumulus dem Lizenznehmer und nur der Lizenznehmer unter allen Eigentumsrechten von Cumulus eine eingeschränkte, nicht ausschließliche, voll bezahlte Lizenz. Die Menge der erworbenen Lizenzen des Produkts darf nur für die jeweils gültige Lizenzlaufzeit (“Lizenzlaufzeit”), ausschließlich auf dem jeweiligen Switchesilicon und nur bis zu den in jeder Auftragsbestätigung (wie in Abschnitt 3a definiert) angegebenen maximalen Portgeschwindigkeiten.");
define("CULUMS_OFF22","b. Die vorstehende Lizenz erlaubt keine Unterlizenzen, Verteilung oder Offenlegung des Produkts an Dritte, und der Lizenznehmer erklärt sich damit einverstanden, dass eine solche Unterlizenzierung, Offenlegung oder Verteilung nicht vorgenommen wird.");
define("CULUMS_OFF23","c. Der Lizenznehmer darf nicht (und darf seinem Personal oder Dritten nicht erlauben): (i) das Produkt zu verändern oder abgeleitete Produkte zu erstellen; (ii) Reverse Engineering betreiben oder versuchen, Quellcode oder zugrunde liegende Ideen oder Algorithmen des Produkts zu ermitteln (außer in dem Umfang, in dem geltendes Recht Reverse Engineering-Beschränkungen verbietet); (iii) Produktkennzeichnungen, Marken-, Urheberrechts- oder andere Hinweise entfernen oder ändern, die in oder auf dem Produkt eingebettet sind oder erscheinen; oder (iv) die Ergebnisse von Benchmarking- oder Leistungsstudien ohne vorherige schriftliche Zustimmung von Cumulus veröffentlichen oder anderweitig an Dritte weitergeben. Der Lizenznehmer trägt die alleinige Verantwortung für die Einhaltung aller hier enthaltenen Bedingungen durch seine Mitarbeiter, Auftragnehmer, Dienstleister und Vertreter sowie sonstige Dritte, denen der Zugriff auf das Produkt aufgrund von Handlung oder Untätigkeit des Lizenznehmers gestattet wurde. Der Lizenznehmer stellt Cumulus und seine Lizenzgeber von allen Ansprüchen oder Klagen, einschließlich Anwaltskosten und -kosten, frei, die sich aus einer unbefugten oder illegalen Nutzung oder Verteilung des Produkts ergeben oder ergeben.");
define("CULUMS_OFF24","d. Das Produkt enthält Open-Source-Softwarepakete. Jedes im Produkt enthaltene Open-Source-Softwarepaket wird dem Lizenznehmer gemäß seiner gültigen Open-Source-Softwarepaketlizenz zur Verfügung gestellt. Im Falle eines Konflikts zwischen einer Open-Source-Softwarepaketlizenz und dem Text dieser Vereinbarung gilt die Open-Source-Softwarepaketlizenz nur für dieses spezifische Open-Source-Paket.");
define("CULUMS_OFF25","e. Das Produkt unterliegt den Exportgesetzen, Beschränkungen und Vorschriften der Vereinigten Staaten. Der Lizenznehmer wird das Produkt unter Verstoß gegen diese Gesetze, Beschränkungen oder Vorschriften nicht exportieren oder reexportieren oder den Export oder reexportieren lassen.");
define("CULUMS_OFF26","f. Das Produkt (i) wurde auf private Kosten entwickelt und enthält Geschäftsgeheimnisse und vertrauliche Informationen; (ii) ist ein kommerzieller Gegenstand, der aus kommerzieller Computersoftware und kommerzieller Computersoftware-Dokumentation besteht, die gemäß DFARS Abschnitt 227.7202 und FAR Abschnitt 12.212 geregelt ist und nicht als nicht-kommerzielle Computersoftware oder nicht-kommerzielle Computersoftware-Dokumentation gemäß einer Bestimmung von DFARS angesehen wird; und (iii) wird den US-Regierungsbehörden NICHT unter der in FAR 52.227-19 dargelegten Commercial Computer Software License angeboten. In Übereinstimmung mit 48 CFR 12.212 und 48 CFR 227.7202 wird das Produkt an staatliche Endverbraucher ausschließlich als kommerzielles Objekt mit den Rechten, die anderen Endverbrauchern gemäß den Bedingungen dieser Vereinbarung gewährt werden, lizenziert. Dieser Abschnitt 2f ersetzt jede Klausel in den FAR-, DFAR- oder anderen Ergänzungsklauseln. Unveröffentlichte Rechte sind nach den Urheberrechtsgesetzen der Vereinigten Staaten vorbehalten.");
define("CULUMS_OFF27","3. Preis; Zahlung; Aufzeichnung");
define("CULUMS_OFF28","a. Während der Laufzeit dieses Vertrages kann der Lizenznehmer weitere erworbene Lizenzen anfordern, indem er Bestellungen entweder an Cumulus oder einen autorisierten Wiederverkäufer sendet. Cumulus oder der autorisierte Wiederverkäufer antworten mit einer formalisierten und akzeptierten Bestellung, in der die Anzahl der erworbenen Lizenzen, die Lizenzdauer, der Gesamtpreis, die anfallenden Steuern und alle zusätzlichen Bedingungen in Bezug auf erworbene Lizenzen (“Auftragsbestätigung”) bestätigt werden. Jede Auftragsbestätigung wird hiermit in die Vereinbarung in ihrer Gesamtheit aufgenommen. Jede gekaufte Lizenz, die in einer Auftragsbestätigung aufgeführt ist, ermöglicht es dem Lizenznehmer, eine einzige Kopie des Produkts zu erstellen und die Kopie des Produkts in Übereinstimmung mit der in Abschnitt 2 genannten Lizenzerteilung zu verwenden.");
define("CULUMS_OFF29","b. Während der Laufzeit dieses Vertrages ist der Lizenznehmer berechtigt, gekaufte Lizenzen gemäß den von Cumulus an den Lizenznehmer übermittelten Auftragsbestätigungen (ohne Steuern, falls vorhanden) zu erwerben. Wenn dies in der entsprechenden Auftragsbestätigung angegeben ist, enden bereits erworbene Lizenzen mit sofortiger Wirkung, wie in der Auftragsbestätigung festgelegt, und werden durch neue erworbene Lizenzen ersetzt (“Conversion”). Die für eine Conversion geltenden Bedingungen werden in der entsprechenden Auftragsbestätigung und/oder einem Zeitplan, der die Besonderheiten dieser Umwandlungen beschreibt (“Conversion Notice”), festgelegt.");
define("CULUMS_OFF30","c. Der Lizenznehmer zahlt Cumulus (oder einem autorisierten Wiederverkäufer) alle anwendbaren Gebühren, die in jeder Auftragsbestätigung (unter “Gebühren”) aufgeführt sind, innerhalb von dreißig (30) Tagen nach Erhalt der Auftragsbestätigung oder wie zwischen dem Lizenznehmer und einem autorisierten Wiederverkäufer anders vereinbart. Die jeweilige Währung wird auf der Auftragsbestätigung angegeben – ansonsten immer in US-Dollar. Die Gebühren sind nicht rückerstattungsfähig. Sofern in der Auftragsbestätigung nicht ausdrücklich als Steuern bezeichnet, sind alle fälligen Beträge ohne Steuern, Quellensteuern, Zölle, Abgaben, Tarife und andere staatliche Abgaben (einschließlich, aber nicht beschränkt auf Mehrwertsteuer), ohne Steuern auf den Jahresüberschuss von Cumulus (zusammenfassend als “Steuern” bezeichnet), und der Lizenznehmer ist für die Zahlung aller Steuern verantwortlich. Die Parteien werden zusammenarbeiten, um die Steuern rechtmäßig zu minimieren. Für den Fall, dass der Lizenznehmer Cumulus oder einem autorisierten Wiederverkäufer bei Fälligkeit einen Teil der Gebühren nicht zahlt, hat der Lizenznehmer an Cumulus oder den autorisierten Wiederverkäufer Verzugszinsen in Höhe von 1,5% des ausstehenden Gesamtbetrags pro Monat für den Zeitraum, in dem diese Gebühren überfällig sind, zu zahlen, sofern zwischen dem Lizenznehmer und dem autorisierten Wiederverkäufer nichts anderes vereinbart wurde.");
define("CULUMS_OFF31","d. Während der Laufzeit dieses Vertrages und für ein (1) Jahr nach seiner Beendigung erstellt und pflegt der Lizenznehmer Aufzeichnungen über die Nutzung des Produkts durch den Lizenznehmer, die ohne Einschränkung jede Installation einer Kopie des Produkts und eine eindeutige Kennung für die Hardware, auf der es installiert ist (zusammenfassend “Aufzeichnungen”), enthalten. Auf Verlangen von Cumulus wird der Lizenznehmer Cumulus diese Aufzeichnungen unverzüglich zur Verfügung stellen, um die Einhaltung dieser Vereinbarung zu überprüfen. Für den Fall, dass der Lizenznehmer es unterlässt, Aufzeichnungen gemäß diesem Abschnitt zu erstellen, zu pflegen oder zu liefern oder im Falle von Streitigkeiten über die Richtigkeit der entsprechenden Aufzeichnungen, kann Cumulus die Nutzung des Produkts durch den Lizenznehmer (z.B. durch Überprüfung von Kopien anwendbarer Protokolldateien usw.) an jedem Ort, an dem das Produkt installiert ist oder wurde oder anderweitig vom Lizenznehmer genutzt wird, überprüfen.");
define("CULUMS_OFF32","4. Lieferung und Support");
define("CULUMS_OFF33","a. Nach Erhalt der ersten Auftragsbestätigung im Rahmen dieses Vertrages wird Cumulus dem Lizenznehmer unverzüglich eine Kopie des Produkts in funktionsfähiger Form liefern.");
define("CULUMS_OFF34","b. Der Lizenznehmer kann Supportleistungen von Cumulus gemäß der entsprechenden Auftragsbestätigung bestellen, vorbehaltlich der Zahlung der anfallenden Supportgebühren durch den Lizenznehmer. Der Lizenznehmer erkennt an und stimmt zu, dass der Cumulus Support den Bedingungen unterliegt, die unter der folgenden URL: <a href='javascript:;'>https://cumulusnetworks.com/support/overview/</a> (“Cumulus Support Programm”) aufgeführt sind.");
define("CULUMS_OFF35","c. Sofern dies nicht vertraglich oder rechtlich untersagt ist, stellt Cumulus dem Lizenznehmer Updates und neue Versionen des Produkts zur Verfügung, die Cumulus den Kunden allgemein kommerziell zur Verfügung stellt, vorausgesetzt, der Lizenznehmer hat eine oder mehrere erworbene Lizenzen, die sich in gutem Einvernehmen unter diesem Vertrag befinden, und der Lizenznehmer hat das Cumulus Support-Programm gemäß der entsprechenden Auftragsbestätigung bestellt und bezahlt.");
define("CULUMS_OFF36","5. Bekanntmachungen; Vertragsoffenlegung; Markenzeichen");
define("CULUMS_OFF37","a. Cumulus hat das Recht, den Lizenznehmer als Kunden zu benennen, ohne die Bedingungen dieses Vertrages offenzulegen. Sofern nicht gesetzlich vorgeschrieben oder anderweitig in dieser Vereinbarung festgelegt, werden alle öffentlichen Bekanntmachungen über die Bedingungen dieser Vereinbarung zwischen Cumulus und dem Lizenznehmer im gegenseitigen Einvernehmen abgestimmt.");
define("CULUMS_OFF38","b. Sofern hierin nicht anders angegeben, darf keine Partei die Marken und Dienstleistungsmarken (“Markenzeichen”) der anderen Partei verwenden, es sei denn, dies geschieht in Übereinstimmung mit der schriftlichen (einschließlich elektronischer Kommunikation) Genehmigung der anderen Partei. Der Lizenznehmer gewährt Cumulus eine beschränkte Lizenz zur Verwendung der Markenzeichen des Lizenznehmers in Übereinstimmung mit den Richtlinien zur Verwendung der Markenzeichen des Lizenznehmers, um den Lizenznehmer ausschließlich als Kunden zu identifizieren. Die Parteien werden die Markenzeichen der anderen Partei nirgendwo auf der Welt anderweitig verwenden oder registrieren (oder eine Anmeldung in Bezug auf sie vornehmen). Keine der Parteien wird irgendwo auf der Welt die Verwendung oder Autorisierung der Markenzeichen einer solchen Partei durch die andere Partei bestreiten. Im Rahmen dieser Vereinbarung werden keine weiteren Rechte oder Lizenzen in Bezug auf Marken, Handelsnamen oder andere Bezeichnungen gewährt.");
define("CULUMS_OFF39","6. Verbot der Abtretung. Weder dieser Vertrag noch Rechte, Lizenzen oder Verpflichtungen aus diesem Vertrag dürfen von einer der Parteien ohne die vorherige schriftliche Zustimmung der nicht abtretenden Partei abgetreten werden; eine verbotene angebliche Abtretung ist nichtig. Ungeachtet des Vorstehenden kann jede Partei diese Vereinbarung abtreten oder ihre Rechte und Pflichten an einen Erwerber des gesamten oder wesentlichen Vermögens oder der Geschäfts- oder Beteiligungspapiere dieser Partei im Zusammenhang mit dem Gegenstand dieser Vereinbarung delegieren, vorausgesetzt jedoch, dass im Falle einer solchen Abtretung die nicht abtretende Partei nach Erhalt der Abtretungsmitteilung eine Frist von dreißig Tagen hat, um diese Vereinbarung schriftlich zu kündigen.");
define("CULUMS_OFF40","7. Vertragsdauer. Die Laufzeit dieser Vereinbarung läuft bis zum Ende der letzten auslaufenden Lizenzdauer. Diese Vereinbarung endet automatisch, einschließlich der in Abschnitt 2 gewährten Lizenzen, wenn der Lizenznehmer eine der Bedingungen in Abschnitt 2 nicht erfüllt. Diese Vereinbarung kann gekündigt werden, wenn eine der Parteien diese Vereinbarung oder eine der wesentlichen Bestimmungen dieser Vereinbarung wesentlich nicht erfüllt oder einhält. Die Kündigung wird nach dreißig (30) Tagen wirksam, wenn die säumigen Beträge nicht innerhalb dieser dreißig (30) Tage getilgt worden sind.");
define("CULUMS_OFF41","8. Kündigung. Zahlungsrechte, Abschnitte 1, 2b-2e, 3b, 6, 7, 8, 9, 10, 11, 12, 13b-d und 14 und, sofern hierin nicht ausdrücklich etwas anderes bestimmt ist, ein Klagerecht wegen Verletzung dieser Vereinbarung vor der Kündigung bestehen über die Beendigung dieser Vereinbarung hinaus. Im Falle einer Kündigung wegen Verletzung durch Cumulus bleiben alle erworbenen Lizenzen bis zum Ende der jeweiligen Lizenzlaufzeit bestehen. Im Falle einer Kündigung wegen Verletzung des Lizenznehmers enden alle erworbenen Lizenzen mit sofortiger Wirkung.");
define("CULUMS_OFF42","9. Hinweise und Anfragen. Alle Mitteilungen, Zustimmungen, Genehmigungen und Anfragen im Zusammenhang mit dieser Vereinbarung gelten als sofort nach ihrer Versendung per Express-Kurier und unter Beachtung der rechtlichen Bestimmungen an die in der letzten in dieser Vereinbarung festgelegten Auftragsbestätigung genannte Adresse oder an eine andere Adresse, die die Partei, die die Mitteilung erhält oder anfordert, durch schriftliche Mitteilung gemäß diesem Abschnitt 9 bestimmt.");
define("CULUMS_OFF43","10. Rechtsbeistand; Anwaltskosten. Diese Vereinbarung unterliegt den Gesetzen des Staates Kalifornien und der Vereinigten Staaten ohne Rücksicht auf seine Kollisionsnormen und ohne Rücksicht auf UCITA oder das Übereinkommen der Vereinten Nationen über Verträge über den internationalen Warenkauf. Ausschließlicher Gerichtsstand für Klagen im Zusammenhang mit dem vorliegenden Gegenstand sind die Bundesgerichte des Staates Kalifornien und der USA in Santa Clara County, Kalifornien. Beide Parteien stimmen der Gerichtsbarkeit und dem Standort solcher Gerichte zu und vereinbaren, dass der Prozess in der hierin vorgesehenen Weise für die Abgabe von Mitteilungen oder anderweitig, wie von Kalifornien oder dem Bundesgesetz erlaubt, durchgeführt werden kann.Die in einem Streitfall vorherrschende Partei ist berechtigt, ihre angemessenen Anwaltskosten und sonstigen Kosten zu erstatten.");
define("CULUMS_OFF44","11. Vertraulichkeit");
define("CULUMS_OFF45","Die Preisbedingungen dieser Vereinbarung, das Produkt und die zugrunde liegenden Erfindungen, Algorithmen, Know-how und Ideen sind geschützte Informationen von Cumulus. Sofern nicht ausdrücklich und unmissverständlich gestattet, wird der Lizenznehmer vertraulich handeln und keine geschützten Informationen verwenden oder offenlegen; seine Mitarbeiter und Auftragnehmer sind ebenfalls schriftlich dazu verpflichtet. Nichts in dieser Vereinbarung darf es der empfangenden Partei gestatten, vertrauliche Informationen einer Partei offenzulegen oder zu verwenden, es sei denn, dies ist an anderer Stelle in dieser Vereinbarung ausdrücklich gestattet, und zwar nur auf einer “nach Bedarf”-Basis für die Zwecke dieser Vereinbarung. Bei einer Kündigung dieser Vereinbarung wird der Lizenznehmer unverzüglich alle urheberrechtlich geschützten Informationen sowie alle Kopien, Auszüge und Derivate davon zurückgeben oder vernichten, sofern in dieser Vereinbarung nichts anderes bestimmt ist. Darüber hinaus wird der Lizenznehmer unverzüglich alle Kopien des Produkts löschen, (i) sobald die geltende gekaufte Lizenz in Bezug auf diese Kopie des Produkts abläuft; und (ii) vor jeder Verteilung von Hardware, bei der das Produkt an Dritte, einschließlich eines Hardware-Händlers oder -Herstellers, installiert wird. Jede Partei erkennt an, dass ein Verstoß gegen diesen Abschnitt 11 zu einer irreparablen Schädigung der anderen Partei führen würde, für die monetärer Schadensersatz kein angemessener Rechtsbehelf sind. Dementsprechend ist eine Partei berechtigt, im Falle einer solchen Verletzung durch die andere Partei Unterlassungsklagen und andere angemessene Rechtsmittel zu erwirken.");
define("CULUMS_OFF46","12. Eingeschränkte Haftung. SOFERN NACHSTEHEND NICHTS ANDERES BESTIMMT IST, UND UNGEACHTET ANDERER BESTIMMUNGEN IN DIESER VEREINBARUNG, IST KEINE DER PARTEIEN HAFTBAR ODER VERPFLICHTET GEMÄß EINEM ABSCHNITT DIESER VEREINBARUNG ODER GEMÄß VERTRAG, FAHRLÄSSIGKEIT, VERSCHULDENSUNABHÄNGIGER HAFTUNG ODER EINER ANDEREN RECHTLICHEN REGELUNG (A) FÜR BETRÄGE, DIE ÜBER DIE SUMME DER AN SIE GEZAHLTEN LIZENZGEBÜHREN (IM FALLE VON CUMULUS) HINAUSGEHEN ODER (IM FALLE DES LIZENZNEHMERS) VON IHR IM RAHMEN DIESER VEREINBARUNG BEZAHLT ODER GESCHULDET WERDEN, ODER (B) ZUFÄLLIGE ODER FOLGESCHÄDEN, ENTGANGENE GEWINNE (MIT AUSNAHME DER NACH ABSCHNITT 3 ZU ZAHLENDEN BETRÄGE), VERLORENE ODER BESCHÄDIGTE DATEN, UNTERBROCHENE NUTZUNG ODER (C) KOSTEN FÜR DIE BESCHAFFUNG VON ERSATZLEISTUNGEN, TECHNOLOGIEN ODER DIENSTEN. DIE BESCHRÄNKUNGEN IN DIESEM ABSCHNITT 12 GELTEN NICHT FÜR VERSTÖßE GEGEN DIE ABSCHNITTE 2b-e UND 11 ODER FÜR HANDLUNGEN DES LIZENZNEHMERS, DIE ÜBER DEN UMFANG DER LIZENZERTEILUNG HINAUSGEHEN.");
define("CULUMS_OFF47","13. Gewährleistung");
define("CULUMS_OFF48","a. Cumulus garantiert dem Lizenznehmer, dass das Produkt von guter Qualität ist und in guter Verarbeitung nach den höchsten professionellen Standards entwickelt wird. Das einzige Rechtsmittel des Lizenznehmers bei Verletzung dieser Garantie oder bei Produktmängeln sind seine Rechte gemäß Abschnitt 4b. Cumulus übernimmt keine Garantie für die Freiheit von Fehlern oder die ununterbrochene Nutzung.");
define("CULUMS_OFF49","b. Das Produkt ist nicht für die Verwendung in Komponenten oder Systemen konzipiert, bestimmt oder zertifiziert, die für den Betrieb gefährlicher Systeme oder Anwendungen bestimmt sind (z.B. Waffen, Waffensysteme, Kernanlagen, Massenverkehrsmittel, Luftfahrt, lebenserhaltende Computer oder medizinische Geräte (einschließlich Reanimationsausrüstung und chirurgische Implantate), Umweltschutz, Gefahrstoffmanagement oder für jede andere gefährliche Anwendung), bei denen das Versagen des Produkts eine Situation schaffen könnte, in der es zu Verletzungen oder zum Tod von Personen kommen kann. Der Lizenznehmer versteht, dass die Nutzung des Produkts in solchen Anwendungen vollständig auf das Risiko des Lizenznehmers erfolgt, und der Lizenznehmer übernimmt hiermit all dieses Risiko.");
define("CULUMS_OFF50","c. MIT AUSNAHME DER OBEN AUSDRÜCKLICH GENANNTEN BESTIMMUNGEN ÜBERNIMMT CUMULUS KEINE GARANTIEN GEGENÜBER NATÜRLICHEN ODER JURISTISCHEN PERSONEN IN BEZUG AUF DAS PRODUKT UND LEHNT ALLE STILLSCHWEIGENDEN GARANTIEN AB, EINSCHLIESSLICH UND OHNE EINSCHRÄNKUNG DER GARANTIEN DER MARKTGÄNGIGKEIT UND EIGNUNG FÜR EINEN BESTIMMTEN ZWECK UND DER NICHTVERLETZUNG VON RECHTEN.");
define("CULUMS_OFF51","d. JEDE PARTEI ERKENNT AN UND STIMMT ZU, DASS DIE GEWÄHRLEISTUNGSAUSSCHLÜSSE UND DIE HAFTUNGSBESCHRÄNKUNGEN UND RECHTSBEHELFE IN DIESER VEREINBARUNG WESENTLICH FÜR DIE GRUNDLAGEN DIESER VEREINBARUNG SIND UND DASS SIE BEI DER BESTIMMUNG DER VON JEDER PARTEI IM RAHMEN DIESER VEREINBARUNG ZU ERBRINGENDEN GEGENLEISTUNG UND BEI DER ENTSCHEIDUNG JEDER PARTEI, DIESE VEREINBARUNG ABZUSCHLIEßEN, BERÜCKSICHTIGT UND BERÜCKSICHTIGT WURDEN.");
define("CULUMS_OFF52","14. Allgemeines. Diese Vereinbarung stellt die gesamte Vereinbarung zwischen den Parteien in Bezug auf den Gegenstand dieser Vereinbarung dar und führt alle vorherigen und gleichzeitigen Mitteilungen zusammen. Sie darf nur durch eine schriftliche Vereinbarung geändert werden, die nach dem Datum dieser Vereinbarung datiert und im Namen des Lizenznehmers und von Cumulus von ihren ordnungsgemäß bevollmächtigten Vertretern unterzeichnet wurde. Wenn eine Bestimmung dieser Vereinbarung von einem Gericht der zuständigen Gerichtsbarkeit für illegal, ungültig oder nicht durchsetzbar befunden wird, wird diese Bestimmung auf das erforderliche Mindestmaß beschränkt oder aufgehoben, so dass diese Vereinbarung ansonsten in vollem Umfang in Kraft und Wirkung bleibt und durchsetzbar ist. Kein Verzicht auf einen Verstoß gegen eine Bestimmung dieser Vereinbarung stellt einen Verzicht auf einen vorherigen, gleichzeitigen oder nachfolgenden Verstoß gegen dieselbe oder eine andere Bestimmung dieser Vereinbarung dar, und kein Verzicht ist wirksam, es sei denn, er wird schriftlich erklärt und von einem autorisierten Vertreter der verzichtenden Partei unterzeichnet.");
define("CULUMS_OFF53","Absenden");
define("CULUMS_OFF54","Copyright &copy; 2009-".date('Y',time())." FS.COM GmbH Alle Rechte vorbehalten.");
define("CULUMS_OFF55","Datenschutz");
define("CULUMS_OFF56","Diese Informationen wurden erfolgreich übermittelt. Wir werden eine E-Mail mit dem Lizenzcode an Sie senden, um den Switch innerhalb von 10 Minuten zu aktivieren.");
define("CULUMS_OFF57","Firmenname ist Pflichtfeld");
define("CULUMS_OFF58","Telefon-Nummer ist Pflichtfeld");
define("CULUMS_OFF59","E-Mail-Adresse ist Pflichtfeld");
define("CULUMS_OFF60","Bitte geben Sie eine gültige E-Mail-Adresse ein.(z.B.: someone@example.com).");
define("CULUMS_OFF61","Bitte kreuzen Sie die EULA-Vereinbarung an");
define("CULUMS_OFF62","Webadresse ist Pflichtfeld");
define("CULUMS_OFF63","Sie haben Bestätigungsinformationen übermittelt. Bitte senden Sie diese Informationen nicht erneut.");
define("CULUMS_OFF66","Ihre Nutzungserfahrung teilen ");

//2019-01-07 继续付款，再次付款，付款成功
define('FS_PAYMENT_CONFIRM','Bestätigen');
define('PAYMENT_AGAINST_PAYPAL_SECURITY','Sie werden zum PayPal weitergeleitet, um diese Bestellung abzuschließen.');
define('PAYMENT_AGAINST_BANK_SENTENCE01','Normalerweise wird das Geld innerhalb von 1-3 Werktagen erhalten. Wir werden die Bestellung bearbeiten, sobald wir den betrag erhalten haben.');
define('PAYMENT_AGAINST_BANK_SENTENCE02','Wenn Sie bezahlt haben, teilen Sie bitte uns mit. Damit können wir Ihre Zahlung prüfen und Ihre Bestellung rechtzeitig bearbeiten.');
define('PAYMENT_AGAINST_BANK_FILL','Ihre Banküberweisung-Informationen eingeben');
define('PAYMENT_AGAINST_PAYPAL','PayPal');
define('PAYMENT_AGAINST_BANK','Banküberweisung');
define('PAYMENT_AGAINST_EDIT','Bearbeiten');
define('PAYMENT_AGAINST_BANK_EMAIL','E-Mail-Adresse des Zahlers');

define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP','Auftrag-Nummer ist Pflichtfeld.');
define("FS_ORDER_UPLOAD_PO_MESSAGE",'Ihre Bestellung wird versandt, nachdem wir eine gültige Auftragsdatei innerhalb von 7 Werktagen erhalten haben.');

define('FS_AGAINST_PAYER','Name des Zahlers');
define('FS_AGAINST_PAY_TIME','Zahlungszeit');
define('FS_AGAINST_PAY_AMOUNT','Zahlungsbetrag');
define('FS_AGAINST_COUNTRY','Land');
define('FS_AGAINST_PHONE','Telefonnummer des Zahlers');
define('FS_AGAINST_OR','Bitte geben Sie den vollständigen Namen ein, den Sie für die Überweisung verwenden, entweder als Einzelperson oder als Firma');
define('FS_AGAINST_YOUR','Ihre Zahlungszeit ist Pflichtfeld (z.B.: 20.01.2019)');
define('FS_AGAINST_MUST','Es muss eine gültige Telefonnummer sein, unter der wir Sie bei Bedarf erreichen können');

define('FS_BT_SUCCESSFULLY','Update erfolgreich!');
define('FS_BT_SUCCESSFULLY_SENTENCE_01','Normalerweise wird das Geld zwischen 1-3 Werktagen erhalten. Wir werden uns so schnell wie möglich damit befassen. Klicken Sie auf');
define('FS_BT_SUCCESSFULLY_SENTENCE_02',' Bestellverlauf, ');
define('FS_BT_SUCCESSFULLY_SENTENCE_03','um die Bestellung anzuzeigen.');

define("FS_CHECKOUT_NEW28","Copyright © 2009-".date("Y", time())." FS.COM GmbH Alle Rechte vorbehalten.");

define('GLOBAL_GS_SENTENCE1','Ihre Kreditkartendaten werden nicht gespeichert.');
define('GLOBAL_GS_SENTENCE2','Wir akzeptieren die folgenden Kredit- oder Debitkarten sowie die von diesen Unternehmen  ausgestellten P-Cards. Bitte wählen Sie einen Kartentyp, geben Sie die nötigen Informationen ein und klicken Sie auf Bestätigen.');
define('GLOBAL_GS_SENTENCE3','Wir akzeptieren die folgenden Kredit-/Debitkarten. Aus Sicherheitsgründen werden Ihre Kreditkartendaten nicht gespeichert.');
define('FS_AGAINST_WE','Wir akzeptieren die folgenden Kredit- oder Debitkarten sowie die von diesen Unternehmen ausgestellten P-Cards. Bitte wählen Sie einen Kartentyp, geben Sie die nötigen Informationen ein und klicken Sie auf Bestätigen.');
define("GLOBAL_GC_TEXT6","Kredit- / Debitkarte Auswählen:");
define("GLOBAL_GC_TEXT7","Bestellübersicht");
define("GLOBAL_GC_TEXT8","Bestellnummer");
define("GLOBAL_GC_TEXT11","Rechnungsadresse");
define("GLOABL_GC_LIVECHAT","Live-Chat");
define("GLOABL_CART","Warenkorb");
define("GLOABL_CHECKETOUT","Zur Kasse");
define("GLOABL_SUCCESS","Erfolgreich");
define("GLOBAL_EXPECTED_SHIPPING","Versanddatum");
define("GLOBAL_EXPECTED_DELIVERY","Zustellung");
define('FS_ALLOWED_FILE_TYPES','Zulässige Dateitypen: ');
define('CHECKOUT_BILLING_CREDIT','Zahlung per Kredit- oder Debitkarte');
define('FS_GC_TIPS_01','Entschuldigung, Ihre Anfrage wurde abgelehnt. Bitte überprüfen Sie die folgenden Gründe und versuchen Sie es erneut oder wählen Sie eine andere Zahlungsart.');
define('FS_GC_TIPS_02','1. Der Gesamtbetrag überschreitet die Begrenzung (€ 15000) ;');
define('FS_GC_TIPS_03','2. Die Karte unterstützt die Währung nicht;');
define('FS_GC_TIPS_04','3. Netzwerkfehler, versuchen Sie es später erneut.');

//加购弹窗
define('FS_ADD_CART_PROCHUSE','Zwischensumme ');

//地址模块 start
define("FS_ADD_NEW_ADDRESS","Eine neue Adresse hinzufügen");
define('FS_ADD_SHIPPING_ADDRESSES','Eine neue Adresse hinzufügen');
define("FS_ADD_BILLING_ADDRESS","Eine neue Rechnungsadresse hinzufügen");
//地址模块 end

define('FS_REGIST','Registrieren');

//询价弹窗
define("FS_INQUIRY_YOUR_ITEM",'Artikel');

define('FS_SAMPLE_APPLICATION_SUBMIT','Einreichen...');
define("CHECKOUT_TAXE_CLEARANCE_CN_FRONT","Für Bestellungen, die von unserem asiatischen Lagerhaus versandt werden, wird keine Mehrwertsteuer berechnet. Je nach den Gesetzen der jeweiligen Länder können diese Pakete jedoch Einfuhr- oder Zollgebühren erhoben werden. Alle durch die Zollabfertigung verursachten Gebühren sollten vom Empfänger getragen werden. Für Bestellungen, die nach Malaysia, Indonesien und die Philippinen verschickt werden, bieten wir jetzt die Versandart „Spediteurversand“ an, mit der Kunden die im Rahmen der Online-Zollabfertigung generierten Abgaben und Steuern vorab zahlen können. Für Kunden aus anderen Bereichen wenden Sie sich bitte an uns, wenn Sie Hilfe bei der Vorauszahlung des Zolls benötigen.");

// 上传 start
//2018-9-20 ery add
define('FS_COMMON_FILE','Datei');
//服务器端的提示
define("FS_UPLOAD_ERROR1",'Der erste Anhang hat einen Fehler: ');
define("FS_UPLOAD_ERROR2",'Der zweite Anhang hat einen Fehler: ');
define("FS_UPLOAD_ERROR3",'Der dritte Anhang hat einen Fehler: ');
define("FS_UPLOAD_ERROR4",'Der vierte Anhang hat einen Fehler: ');
define("FS_UPLOAD_ERROR5",'Der fünfte Anhang hat einen Fehler: ');
// 2019.2.26 fairy add
define("FS_UPLOAD_FORMAT_TIP",'Dateitypen von $FILE_TYPE erlauben');
define("FS_UPLOAD_SIZE_DEFAULT_TIP",'Maximale Dateigröße 5M.');
// 上传 end

//信用卡新加坡渠道弹窗
define("GLOABL_TEXT_DECLINED_1","Es tut uns leid, dass Ihre Karte aus einem der folgenden Gründe abgelehnt wurde:");
define("GLOABL_TEXT_DECLINED_2","1.Bitte stellen Sie sicher, dass nicht mehr als zwei verschiedene Rechnungsadressen per Karte oder per E-Mail-Adresse innerhalb 30 Tagen angezeigt wird.");
define("GLOABL_TEXT_DECLINED_3","2.Bitte stellen Sie sicher, dass das Land, in dem Ihre Kreditkarte ausgestellt wird, mit dem Land in Ihrer Lieferadresse übereinstimmt.");
define("GLOABL_TEXT_DECLINED_8","3.Bitte stellen Sie sicher, dass die Rechnungsadresse in Ihrer Bestellung mit der Rechnungsadresse Ihrer Kreditkarte übereinstimmt.");
define("GLOABL_TEXT_DECLINED_4","Bitte kontaktieren Sie die Bank, um das Problem zu lösen. Oder verwenden Sie eine andere Kreditkarte oder ändern Sie die Zahlungsmethode auf PayPal oder Banküberweisung.");
define("GLOABL_TEXT_DECLINED_5","Ihre Kreditkarte wurde von der ausstellenden Bank abgelehnt");
define("GLOABL_TEXT_DECLINED_6","Ihre Kreditkarte wurde abgelehnt. Gemeinsame Gründe sind wie folgt:");

define("GLOABL_TEXT_DECLINED_7","Bitte kontaktieren Sie die Bank, um das Problem zu lösen. Oder verwenden Sie eine andere Kreditkarte oder ändern Sie die Zahlungsmethode auf PayPal oder Banküberweisung.");
define("GLOABL_TEXT_DECLINED_9","Klicken Sie hier, um per eine andere Zahlungsmethode zu bezahlen.");
define("GLOABL_TEXT_DECLINED_10","Wenn der Gesamtbetrag mehr als 15.000,00 € beträgt, teilen Sie bitte die Zahlung auf oder");
define("GLOABL_TEXT_DECLINED_11"," klicken Sie hier, ");
define("GLOABL_TEXT_DECLINED_12","um per eine andere Zahlungsmethode zu bezahlen.");

define('FS_CLEARACNE_05','Alle anzeigen');
define('FS_CLEARACNE_06','Mehr laden');

//退换货提示
define('FS_ACCOUNT_HISTORY_1','Bitte bestätigen Sie den Erhalt des Pakets. Die Rücksendung oder der Umtausch wird aktiviert.');

//详情页定制产品加购弹窗
define('FS_CUSTOMIZED_INFORMATION','Maßgeschneiderte Informationen');
define('FS_CUSTOMIZED','Maßgeschneidert');
define('FS_PROCESSING','Bearbeitet');
define('FS_SHIPPING','Verschickt');
define('FS_DELIVERED','Geliefert');
define('FS_PROCESSING_EST','Bearbeitungszeit: ');
define('FS_SHIPPING_EST','Lieferzeit: ');
define('FS_DELIVERED_EST','Liefertermin: ');
define('FS_BUSINESS_DAYS_ADD',' Werktage');
define('FS_BUSINESS_DAYS_DELIVER_TO',' Werktage, Lieferung an ');
define('FS_EST','ca. ');
define('FS_CUSTOMIZED_ADD_TO_CART','Bestätigen');
define('FS_KEEP_SHOPPING','Weiter kaufen');
define('FS_CONTINUE_TO_CART','Zum Warenkorb');

define('FS_PRODCUTS_INFO_VIEW','Mehr Detail:');
define('FS_PRODUCTS_INFO_VIEW_NEW','Mehr');

//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"Ihre Nutzungserfahrung teilen #");
define('EMAIL_COMMON_FOOTER_NEW_02',"Sie haben diese E-Mail als %s abonniert.");
define('EMAIL_COMMON_FOOTER_NEW_03',"Klicken Sie hier, um Ihre Einstellungen zu ändern oder den Newsletter abzubestellen.");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS GmbH, NOVA Gewerbepark, Gebäude 7, Am Gfild 7, 85375 Neufahrn, Deutschland");
define('EMAIL_COMMON_FOOTER_NEW_05',"Kontakt");
define('EMAIL_COMMON_FOOTER_NEW_06',"Mein Konto");
define('EMAIL_COMMON_FOOTER_NEW_07',"Versand &amp; Lieferung");
define('EMAIL_COMMON_FOOTER_NEW_08',"Rückgaberecht");
define('EMAIL_COMMON_FOOTER_NEW_09'," Alle Rechte vorbehalten.");
define('EMAIL_COMMON_FOOTER_NEW_10',"Copyright &copy; ");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"Sie haben Ihr Passwort erfolgreich geändert. Sie können sich jetzt mit dem neuen Passwort bei FS anmelden.");
define('RESET_PASS_SUCCESS_02','Jetzt anmelden');
define('RESET_PASS_SUCCESS_03',"Wenn Sie nicht eine Änderung Ihres Passworts angefordert haben, antworten Sie bitte auf diese E-Mail oder rufen Sie uns unter +49 (0) 8165 80 90 517 an.");
define('RESET_PASS_SUCCESS_04','Mit freundlichen Grüßen<br>FS Team');
define('RESET_PASS_SUCCESS_05','Hallo');
define('RESET_PASS_SUCCESS_TITLE','Ihr Passwort wurde geändert');
define('RESET_PASS_SUCCESS_THEME','Ihr Passwort wurde geändert');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"Wir haben eine Anfrage zum Zurücksetzen Ihres Passworts erhalten. Wenn Sie diese Anfrage nicht gesandt haben, ignorieren Sie bitte diese E-Mail. Wenn Sie Ihr Passwort zurücksetzen möchten, klicken Sie auf die Schaltfläche unten, um ein neues Passwort zu setzen.");
define('RESET_PASS_SEND_02',"Neues Passwort setzen");
define('RESET_PASS_SEND_03',"Hinweis: Wenn Sie Probleme beim Klicken auf die Schaltfläche haben, kopieren Sie bitte den folgenden Code und fügen Sie ihn in Ihre Seite zum Zurücksetzen ein.");
define('RESET_PASS_SEND_04',"Mit freundlichen Grüßen<br>FS Team");
define('RESET_PASS_SEND_05',"Hallo");
define('RESET_PASS_SEND_06',"Kein Passwort? Kein Problem. Wir setzen Ihr Passwort für Sie zurück.");
define('RESET_PASS_SEND_TITLE','Passwort zurücksetzen');
define('RESET_PASS_SEND_THEME','Passwort zurücksetzen');
define('RESET_PASS_EXPIRE_TIME','Dieser Rücksetzcode läuft in 4 Stunden ab. Einen neuen Code erhalten Sie unter <a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>');

//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"Ihre E-Mail-Adresse wurde auf %s geändert.");
define('RESET_EMAIL_SUCCESS_02','Hallo');
define('RESET_EMAIL_SUCCESS_03','Mehr Informationen klicken Sie auf ');
define('RESET_EMAIL_SUCCESS_04',"Mein Konto");
define('RESET_EMAIL_SUCCESS_05',"");
define('RESET_EMAIL_SUCCESS_06',"Wenn Sie um eine Änderung Ihrer Daten nicht gebeten haben, bitte besuchen Sie ");
define('RESET_EMAIL_SUCCESS_07',"Mit freundlichen Grüßen<br>FS Service-Team");
define('RESET_EMAIL_SUCCESS_TITLE','E-Mail-Adresse umstellen');
define('RESET_EMAIL_SUCCESS_THEME','FS - Ihre E-Mail-Adresse wurde geändert');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"Ihr Konto wurde erfolgreich erstellt. Jetzt können Sie sich mit Ihrer E-Mail-Adresse und Ihrem Passwort anmelden.");
define('REGIST_EMAIL_SEND_02',"Hallo");
define('REGIST_EMAIL_SEND_03',"Ihr Konto wurde erfolgreich erstellt. Jetzt können Sie sich mit Ihrer E-Mail-Adresse und Ihrem Passwort ");
define('REGIST_EMAIL_SEND_04',"anmelden.");
define('REGIST_EMAIL_SEND_05',"");
define('REGIST_EMAIL_SEND_06',"Nach der Anmeldung können Sie:");
define('REGIST_EMAIL_SEND_07',"Die");
define('REGIST_EMAIL_SEND_08'," Kontoeinstellungen");
define('REGIST_EMAIL_SEND_09'," einfach ändern und mehr Services von FS genießen;");
define('REGIST_EMAIL_SEND_10',"");
define('REGIST_EMAIL_SEND_11',"Support anfragen");
define('REGIST_EMAIL_SEND_12'," und eine kostenlose Antwort erhalten;");
define('REGIST_EMAIL_SEND_13',"Bestellung online aufgeben und den Bestellstatus jederzeit verfolgen.");
define('REGIST_EMAIL_SEND_14',"Mit freundlichen Grüßen<br>FS Team");
define('REGIST_EMAIL_SEND_15',"Ihr Konto wurde erfolgreich eröffnet, die Kontonummer ist ");
define('REGIST_EMAIL_SEND_16',". Jetzt können Sie sich ");
define('REGIST_EMAIL_SEND_TITLE','Neues Konto eröffnet');
define('REGIST_EMAIL_SEND_THEME','Ihr FS-Konto ist einsatzbereit');

//企业用户注册(新用户注册)
define('REGIST_COM_EMAIL_SEND_01','Wir haben Ihre Anfrage für ein Geschäftskonto erhalten. Derzeit wird es überprüft und dieser Vorgang dauert ca. 1-3 Werktage.');
define('REGIST_COM_EMAIL_SEND_03','Wir haben Ihre Anfrage für ein Geschäftskonto erhalten. Derzeit wird es überprüft und dieser Vorgang dauert ca. 1-3 Werktage.
Später werden wir eine Email an Sie senden.');
define('REGIST_COM_EMAIL_SEND_02','Hallo');
define('REGIST_COM_EMAIL_SEND_04','Vor der Genehmigung können Sie sich mit Ihrer E-Mail-Adresse und Ihrem Passwort ');
define('REGIST_COM_EMAIL_SEND_05','anmelden');
define('REGIST_COM_EMAIL_SEND_06',' und FS-Services genießen.');
define('REGIST_COM_EMAIL_SEND_07','Nach dem Einloggen können Sie:');
define('REGIST_COM_EMAIL_SEND_08','');
define('REGIST_COM_EMAIL_SEND_09','Ihr FS-Konto');
define('REGIST_COM_EMAIL_SEND_10',' einfach verwalten und mehr FS-Services genießen.');
define('REGIST_COM_EMAIL_SEND_11','');
define('REGIST_COM_EMAIL_SEND_12','Technischer Support absenden');
define('REGIST_COM_EMAIL_SEND_13',' und Sofortige Antwort erhalten.');
define('REGIST_COM_EMAIL_SEND_14','Bestellung online aufgeben und den Bestellstatus jederzeit verfolgen.');
define('REGIST_COM_EMAIL_SEND_15','Mit freundlichen Grüßen<br>FS Service-Team');
define('REGIST_COM_EMAIL_SEND_TITLE','Supportanfrage');
define('REGIST_COM_EMAIL_SEND_THEME','FS - Auf ein Geschäftskonto umstellen');

//企业用户注册(新用户注册)
define('REGIST_EMAIL_SEND_NEW_01',"Konto erstellt");
define('REGIST_EMAIL_SEND_NEW_02',"Willkommen bei FS");
define('REGIST_EMAIL_SEND_NEW_03',"Führender Anbieter von Kommunikationshardware und Lösungen für die optischen Infrastruktur.");
define('REGIST_EMAIL_SEND_NEW_04',"Qualitätsverpflichtung");
define('REGIST_EMAIL_SEND_NEW_05',"Höchste Qualität, Kundenorientierung und nachhaltige Herstellung");
define('REGIST_EMAIL_SEND_NEW_06',"Maßgeschneiderte Lösungen");
define('REGIST_EMAIL_SEND_NEW_07',"Bereitstellung von innovativen, kostengünstigen und zuverlässigen One-Stop-Lösungen");
define('REGIST_EMAIL_SEND_NEW_08',"Schneller Versand");
define('REGIST_EMAIL_SEND_NEW_09',"Logistikzentrum in Deutschland, ausreichender Lagerbestand und kostenloser Versand");
define('REGIST_EMAIL_SEND_NEW_10',"Wir bieten professionellen technischen Support und helfen Ihnen bei der Umsetzung Ihrer Projekte.");
define('REGIST_EMAIL_SEND_NEW_11',"In unserem Blog und den Case Studies zu erfolgreichen Projekten erfahren Sie mehr über unsere Lösungen.");
define('REGIST_EMAIL_SEND_NEW_12',"FS-Startseite");
define('REGIST_EMAIL_SEND_NEW_13',"Tech-Support von FS");
define('REGIST_EMAIL_SEND_NEW_14',"FS Community");

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','Wir haben Ihre Anfrage für ein Geschäftskonto erhalten. Derzeit wird es überprüft und dieser Vorgang dauert ca. 1-3 Werktage.');
define('REGIST_COM_EMAIL_UPGRADE_02','Hallo');
define('REGIST_COM_EMAIL_UPGRADE_03','Wir haben Ihre Anfrage für ein Geschäftskonto erhalten. Derzeit wird es überprüft und dieser Vorgang dauert ca. 1-3 Werktage. Später werden wir eine Email an Sie senden.');
define('REGIST_COM_EMAIL_UPGRADE_04','Mit freundlichen Grüßen<br>FS Team');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','Supportanfrage');
define('REGIST_COM_EMAIL_UPGRADE_THEME','FS - Auf ein Geschäftskonto umstellen');

//订单邮件语言包
define('FS_ORDER_EMAIL_01','Vielen Dank für Ihren Einkauf bei FS. Wir haben Ihre ausstehende Bestellung ');
define('FS_ORDER_EMAIL_02',' erhalten. Wir werden Ihre Bestellung bearbeiten, sobald Sie die Zahlung abgeschlossen haben.');
define('FS_ORDER_EMAIL_03','Details zu Ihrer Bestellung ');
define('FS_ORDER_EMAIL_04',' sind wie unten. Wir werden Ihnen eine E-Mail senden, sobald Ihr Bestellstatus aktualisiert wird.');
define('FS_ORDER_EMAIL_05','Details zu Ihrer Bestellung ');
define('FS_ORDER_EMAIL_06','finden Sie unten. Weil Sie "Selbstabholung" gewählt haben, senden wir Ihnen die Abholanleitung per E-Mail zu, sobald Ihre Bestellung vorbereitet ist.');
define('FS_ORDER_EMAIL_07','Vielen Dank für Ihren Einkauf bei FS. Wir haben Ihre ausstehende Bestellung erhalten. Sobald wir den Betrag erhalten, werden wir Ihre Bestellung so schnell wie möglich bearbeiten.');
define('FS_ORDER_EMAIL_08','Details zu Ihrer Bestellung finden Sie unten. Weil Sie "Selbstabholung" gewählt haben, senden wir Ihnen die Abholanleitung per E-Mail zu, sobald Ihre Bestellung vorbereitet ist.');
define('FS_ORDER_EMAIL_09','Vielen Dank für Ihren Einkauf bei uns. Details zu Ihrer Bestellung finden Sie unten. Sobald Ihre Bestellung versandt wird, senden wir Ihnen Tracking-Informationen.');
define('FS_ORDER_EMAIL_10','Bestellung');
define('FS_ORDER_EMAIL_11','Ihre bestellte Produkte wurden in ');
define('FS_ORDER_EMAIL_12',' Bestellungen aufgeteilt.');
define('FS_ORDER_EMAIL_13','Bestellungen verwalten');
define('FS_ORDER_EMAIL_14','Bestellnummer');
define('FS_ORDER_EMAIL_15','Bestellt');
define('FS_ORDER_EMAIL_16','Geschätzter Versand');
define('FS_ORDER_EMAIL_17','Erwartete Lieferung');
define('FS_ORDER_EMAIL_18','Wir werden Sie informieren, sobald Ihre Artikel versandt werden. Für einen aktuellen Status Ihrer Bestellung können Sie in ');
define('FS_ORDER_EMAIL_19','Mein Konto');
define('FS_ORDER_EMAIL_20',' jederzeit überprüfen.');
define('FS_ORDER_EMAIL_21','Sie können in  ');
define('FS_ORDER_EMAIL_22',' die Artikel ändern oder die Bestellung stornieren. Bitte beachten Sie, dass Sie nach dem Versand Ihrer Artikel keine Änderungen mehr vornehmen können.');
define('FS_ORDER_EMAIL_23','Wir werden Sie informieren, sobald Ihre Artikel versandt werden. Für einen aktuellen Status Ihrer Bestellung können Sie sich jederzeit gerne an uns wenden.');
define('FS_ORDER_EMAIL_24','Wenn Sie Ihre Bestellung ändern oder stornieren müssen, wenden Sie sich bitte an Ihren Vertriebsmitarbeiter. Bitte beachten Sie, dass Sie nach dem Versand Ihrer Artikel keine Änderungen mehr vornehmen können.');
define('FS_ORDER_EMAIL_25','Sobald wir den Betrag erhalten, werden wir Ihre Bestellung so schnell wie möglich bearbeiten.');
define('FS_ORDER_EMAIL_26','Bestellung erhalten');
define('FS_ORDER_EMAIL_27','Bearbeite Bestellung');
define('FS_ORDER_EMAIL_28','Hallo ');
define('FS_ORDER_EMAIL_29','Lieferdetails');
define('FS_ORDER_EMAIL_30','Lieferadresse');
define('FS_ORDER_EMAIL_31','Kontaktinformationen');
define('FS_ORDER_EMAIL_32','FAQ');
define('FS_ORDER_EMAIL_33','Wann werden die bestellte Artikel versandt?');
define('FS_ORDER_EMAIL_34','Wie ändere ich meine Bestellung?');
define('FS_ORDER_EMAIL_35','Zahlungsdetails');
define('FS_ORDER_EMAIL_36','Zwischensumme:');
define('FS_ORDER_EMAIL_37','Versandkosten:');
define('FS_ORDER_EMAIL_38',' Gesamtsumme:');
define('FS_ORDER_EMAIL_39','Zahlungsart:');
define('FS_ORDER_EMAIL_40','Alle Gebühren werden angezeigt als <a style="color: #0070BC;text-decoration: none" href="javascript:;">FS COM</a>.');
define('FS_ORDER_EMAIL_41','Rechnungsadresse');
define('FS_ORDER_EMAIL_42','Vielen Dank für Ihre Bestellung. Mehr Details zu Ihrer Bestellung.');
define('FS_ORDER_EMAIL_43','FS - Wir haben Ihre Bestellung %s erhalten');
define('FS_ORDER_EMAIL_44','Abholadresse');
define('FS_ORDER_EMAIL_45','Abholer');
define('FS_ORDER_EMAIL_46','. Sobald wir die Auftragsdatei erhalten, werden wir Ihre Bestellung so schnell wie möglich bearbeiten.');
define('FS_ORDER_EMAIL_47','FS - Vielen Dank für Ihre Bestellung %s');
define('FS_ORDER_EMAIL_48','Purchase Order');
define('FS_ORDER_EMAIL_49','bereit');
define('FS_ORDER_EMAIL_50','Verschickt');
//2019.4.9 新增俄罗斯对公支付 邮件语言包 [ORDERNUMBER]不需要翻译保留即可，只有一单时会替换成对应的订单号，多单时会替换为空
define('FS_ORDER_EMAIL_51', "Vielen Dank, dass Sie sich für FS entschieden haben. Wir haben Ihre ausstehende Bestellung[ORDERNUMBER] erhalten. Der Account Manager wird die Rechnung an Sie per E-Mail so schnell wie möglich schicken.");
define('FS_ORDER_EMAIL_52','Bitte überprüfen Sie Ihre Zahlungsdetails:');
define('FS_ORDER_EMAIL_53','Ansprechpartner');
define('FS_ORDER_EMAIL_54','Telefonnummer*');
define('FS_ORDER_EMAIL_55','E-mail*');
define('FS_ORDER_EMAIL_56','Name der Organisation*');
define('FS_ORDER_EMAIL_57','INN*');
define('FS_ORDER_EMAIL_58','KPP*');
define('FS_ORDER_EMAIL_59','OKPO');
define('FS_ORDER_EMAIL_60','BIC*');
define('FS_ORDER_EMAIL_61','Gültige Adresse*');
define('FS_ORDER_EMAIL_62','Postadresse');
define('FS_ORDER_EMAIL_63','Korrespondenzkonto');
define('FS_ORDER_EMAIL_64','Bank name*');
define('FS_ORDER_EMAIL_65','Verrechnungskonto*');
define('FS_ORDER_EMAIL_66','Vollständiger Name des Inhabers');
define('FS_ORDER_EMAIL_67','Zahlungsinformationen');
define('FS_ORDER_EMAIL_68','Länge');
define('FS_ORDER_EMAIL_09_1','Ihr Einkauf wurde in 2 Bestellungen ');
define('FS_ORDER_EMAIL_09_2','Details sind wie unten. Wir senden Ihnen eine E-Mail, sobald Ihre Bestellung aktualisiert wird.');
define('FS_ORDER_EMAIL_09_3',' aufgeteilt');
define('FS_ORDER_EMAIL_69','Sie können sich anmelden und in ');
define('FS_ORDER_EMAIL_70','Meine Bestellungen');
define('FS_ORDER_EMAIL_71',' den Status Ihrer Bestellung verfolgen.');
define('FS_ORDER_EMAIL_72','Zahlung erhalten');
define('FS_ORDER_EMAIL_73','Bearbeitet');
define('FS_ORDER_EMAIL_74','Unterwegs');
define('FS_ORDER_EMAIL_75','Geliefert');
define('FS_ORDER_EMAIL_76','PO Bestätigen');
//邮件系统改版语言包
//在线询价(A)
define('FS_SEND_EMAIL','FS - Ihre Angebotsanfrage ');
define('FS_SEND_EMAIL_1',"Wir haben Ihre Angebotsanfrage ");
define('FS_SEND_EMAIL_2'," erhalten und werden innerhalb von 1 Werktag eine E-Mail mit den Angebotsdetails an Sie senden.");
define('FS_SEND_EMAIL_3',"Angebotsanfrage");
define('FS_SEND_EMAIL_3_1','Wir haben Ihre Probenanforderung $CASENUMBER erhalten');
define('FS_SEND_EMAIL_4'," erhalten und werden innerhalb von 1 Werktag eine E-Mail mit den Angebotsdetails an Sie senden.");
define('FS_SEND_EMAIL_5'," Zusätzliche Anmerkung");
define('FS_SEND_EMAIL_6',"Angebotsliste");
define('FS_SEND_EMAIL_7',"Ihre zusätzlichen Notizen");
define('FS_SEND_EMAIL_8',"Menge: ");
//在线技术咨询A
define('FS_SEND_EMAIL_8_1','FS - Wir haben Ihre Supportanfrage ');
define('FS_SEND_EMAIL_8_2', 'FS - Wir haben Ihre produkttechnische Anfrage ### erhalten ');//product_support页面，发送邮件
define('FS_SEND_EMAIL_9',"Vielen Dank für Ihren Kontakt. Ihre Frage-Nummer lautet ");
define('FS_SEND_EMAIL_10',". Unser technisches Support-Team wird sich innerhalb von 6-18 Stunden bei Ihnen melden.");
define('FS_SEND_EMAIL_10_1',". Wir werden Sie innerhalb von 6-18 Stunden kontaktieren.");//product_support页面，发送邮件
//产品QA邮件
define('FS_SEND_EMAIL_11',"FS - Ihre Frage zum Artikel #");
define('FS_SEND_EMAIL_12',"Frage wurde erhalten");
define('FS_SEND_EMAIL_12_1',"Wir haben Ihre Frage zum Artikel #");
define('FS_SEND_EMAIL_13'," erhalten und werden uns innerhalb von 1 Werktag mit Ihnen in Verbindung setzen.");
define('FS_SEND_EMAIL_14',"Wir haben Ihre Frage zum Artikel ");
define('FS_SEND_EMAIL_15'," erhalten und werden uns innerhalb von 1 Werktag mit Ihnen in Verbindung setzen.");
//退换货all
define('FS_SEND_EMAIL_16',"Wir sind hier, um Ihnen zu helfen");
define('FS_SEND_EMAIL_17',"Wir haben Ihren RMA-Antrag der Bestellung ");
define('FS_SEND_EMAIL_18',"Wir hoffen, dass wir Ihre Probleme lösen können.");
define('FS_SEND_EMAIL_19',"FS - Ihre Supportanfrage ");
define('FS_SEND_EMAIL_20',"Vielen Dank für Ihren Kontakt. Wir haben Ihre Supportanfrage erhalten und werden uns innerhalb von 1 Werktag bei Ihnen melden.");
define('FS_SEND_EMAIL_21',"Vielen Dank für Ihren Kontakt. Wir haben Ihre Supportanfrage erhalten und werden uns innerhalb von 1 Werktag bei Ihnen melden. Ihre Case-Nummer ist");
define('FS_SEND_EMAIL_22',"Wir haben Ihre Lagerbestand-Anfrage zum Artikel #");
define('FS_SEND_EMAIL_23'," erhalten und werden uns innerhalb von 1 Werktag mit Ihnen in Verbindung setzen.");
define('FS_SEND_EMAIL_24',"Wir haben Ihre Lagerbestand-Anfrage zum Artikel ");
define('FS_SEND_EMAIL_25'," erhalten und werden uns innerhalb von 1 Werktag mit Ihnen in Verbindung setzen. Ihre Case-Nummer ist ");
define('FS_SEND_EMAIL_26',". Sie können auf diese Nummer in alle nachfolgende Kommunikation bezüglich dieser Anfrage verweisen.");
define('FS_SEND_EMAIL_27',"Artikel");
define('FS_SEND_EMAIL_28',"Anmerkung");
define('FS_SEND_EMAIL_29',"Gewünschte Menge: ");
define('FS_SEND_EMAIL_30'," Gewünschter Liefertermin: ");
define('FS_SEND_EMAIL_31',"FS - Ihre Lagerbestand-Anfrage ");
define('FS_SEND_EMAIL_32',"FS - Ihr Antrag auf Rückerstattung");
define('FS_SEND_EMAIL_33',"Wir haben Ihre Rückerstattung-Anfrage erhalten und werden innerhalb von 1 Werktag weitere Informationen per E-Mail an Sie senden.");
define('FS_SEND_EMAIL_34',"FS - Ihr Antrag auf Umtausch");
define('FS_SEND_EMAIL_35',"Wir haben Ihre Umtausch-Anfrage erhalten und werden innerhalb von 1 Werktag weitere Informationen per E-Mail an Sie senden.");
define('FS_SEND_EMAIL_36',"FS - Ihr Antrag auf Reparatur");
define('FS_SEND_EMAIL_37',"Wir haben Ihre Reparatur-Anfrage erhalten und werden innerhalb von 1 Werktag weitere Informationen per E-Mail an Sie senden.");
define('FS_SEND_EMAIL_38'," Anweisungen für Ihre Rücksendung");
define('FS_SEND_EMAIL_39',"Folgen Sie diesen Schritten, um Ihre Rücksendung abzuschließen für Ihre Bestellung #");
define('FS_SEND_EMAIL_40',"Rücksendung");
define('FS_SEND_EMAIL_41'," erhalten und werden Ihnen innerhalb von 1 Wertag weitere Informationen per E-Mail senden.");
define('FS_SEND_EMAIL_42'," erhalten und werden Ihnen innerhalb von 1 Wertag weitere Informationen per E-Mail senden.");
define('FS_SEND_EMAIL_43'," erhalten und werden Ihnen innerhalb von 1 Wertag weitere Informationen per E-Mail senden.");
define('FS_SEND_EMAIL_44',"Rückerstattung");
define('FS_SEND_EMAIL_45',"Umtausch");
define('FS_SEND_EMAIL_46',"Reparatur");
define('FS_SEND_EMAIL_47',"Erstattung");
define('FS_SEND_EMAIL_48',"Es tut uns leid, dass Sie ein Problem mit Ihrer Bestellung");
define('FS_SEND_EMAIL_49'," Führen Sie die folgenden Schritte aus, um die Rückgabe abzuschließen:");
define('FS_SEND_EMAIL_50',"Nach Erhalt der zurückgesandten Artikel wird die Rückerstattung von ");
define('FS_SEND_EMAIL_51'," innerhalb von 1 Werktag in der Form von der ursprünglichen Zahlungsmethode ausgegeben werden. Die Rückerstattung wird innerhalb von 1 Woche gutgeschrieben.");
define('FS_SEND_EMAIL_52'," Überblick");
define('FS_SEND_EMAIL_53',"Produktpreis:");
define('FS_SEND_EMAIL_54',"Versandkosten:");
define('FS_SEND_EMAIL_55',"Gesamtsumme:");
define('FS_SEND_EMAIL_56',"Rückerstattungsmethode:");
define('FS_SEND_EMAIL_57',"Ursprüngliche Zahlungsmethode ");
define('FS_SEND_EMAIL_58',"Mehr Informationen zu unserer Rückgaberecht ");
define('FS_SEND_EMAIL_59',"klicken Sie hier");
define('FS_SEND_EMAIL_60',"Umtausch");
define('FS_SEND_EMAIL_61',"Es tut uns leid, dass Sie ein Problem mit Ihrer Bestellung");
define('FS_SEND_EMAIL_62'," haben. Führen Sie die folgenden Schritte aus, um den Umtausch abzuschließen:");
define('FS_SEND_EMAIL_63',"Nach Erhalt der zurückgesandten Artikel wird das Ersatzprodukt möglichst schnell versenden und wir werden Ihnen die Tracking-Informationen senden.");
define('FS_SEND_EMAIL_64',"Übersicht über die zu ");
define('FS_SEND_EMAIL_67',"Nach Erhalt der zurückgesandten Artikel wird das reparierte Produkt möglichst schnell versenden und wir werden Ihnen die Tracking-Informationen senden.");
define('FS_SEND_EMAIL_68',"reparierende Artikel");
define('FS_SEND_EMAIL_69',"Lieferadresse");
define('FS_SEND_EMAIL_70',"Kontaktinformationen");
define('FS_SEND_EMAIL_71',"Auftragsnummer: ");
define('FS_SEND_EMAIL_83',"Preis: ");
//样品申请邮件
define('FS_SEND_EMAIL_84',"Wir haben Ihre Probe-Anfrage erhalten und werden Ihnen die Ergebnisse innerhalb von 24 Stunden mitteilen.");
define('FS_SEND_EMAIL_85',"Wir haben Ihre Probe-Anfrage erhalten. Wir werden uns in Kürze mit Ihnen in Verbindung setzen. Ihre Case-Nummer ist ");
define('FS_SEND_EMAIL_86',". Sie können auf diese Nummer in alle nachfolgende Kommunikation bezüglich dieser Anfrage verweisen.");
define('FS_SEND_EMAIL_87',"Probe-Liste");
define('FS_SEND_EMAIL_88',"Gewünschte Menge: ");
define('FS_SEND_EMAIL_89',"Ihre zusätzlichen Notizen");
define('FS_SEND_EMAIL_90',"Ihre Probenanforderung ");
//cumlums交换机发送激活码邮件
define('FS_SEND_EMAIL_91',"Lizenzschlüssel");
define('FS_SEND_EMAIL_92',"Ihre Aktivierungsinformationen wurden erfolgreich übermittelt.");
define('FS_SEND_EMAIL_94',"Ihren Lizenzschlüssel sowie Ihre Bestelldaten finden Sie unten. Sie müssen diesen Lizenzschlüssel auf dem Switch installieren, um die Software zu aktivieren. Dieser Lizenzschlüssel ist ausschließlich für Ihr Konto bestimmt. Wir werden etwa 3 Tage brauchen, um Ihnen zu helfen, das Produkt zu aktivieren. Bitte kopieren und fügen Sie den Text des Lizenzschlüssels zu dem entsprechenden Zeitpunkt während der Lizenzinstallation ein.");
define('FS_SEND_EMAIL_95',"Bitte beachten Sie: Der Lizenzschlüssel ist zeitlich unbegrenzt und sofort wirksam. Der Zeitraum des technischen Supports beträgt ein Jahr, aber Sie können zusätzliche 45 Tage kostenlosen Support genießen, wenn Sie die Installation innerhalb von 45 Tagen durchführen.");
define('FS_SEND_EMAIL_96',"Wenn Sie Fragen haben oder Hilfe benötigen, kontaktieren Sie uns bitte unter ");
define('FS_SEND_EMAIL_97',"Lizenzschlüssel");
define('FS_SEND_EMAIL_98',"Für Cumulus Linux 2.5.3 oder höher:");
define('FS_SEND_EMAIL_99',"Bestellnummer: ");
define('FS_SEND_EMAIL_100',"Datum: ");
define('FS_SEND_EMAIL_101',"Mehr anzeigen");
define('FS_SEND_EMAIL_102',"FS - Lizenzschlüssel");
//付款链接
define('FS_SEND_EMAIL_103',"<br>Hinweis:");
define('FS_SEND_EMAIL_104'," hat Ihnen eine Zahlungsanfrage geschickt");
define('FS_SEND_EMAIL_105',"Bestellnummer: ");
define('FS_SEND_EMAIL_106',"Jetzt bezahlen");
define('FS_SEND_EMAIL_107',"FS - Sie haben eine Zahlungsanfrage aus ");
//分享购物车
define('FS_SEND_EMAIL_108',"Geteilter Warenkorb");
define('FS_SEND_EMAIL_109',"Ihr(e) Freund*in ");
define('FS_SEND_EMAIL_110'," hat eine Einkaufsliste mit Ihnen geteilt.");
define('FS_SEND_EMAIL_111',"Ihr(e) Freund(e) ");
define('FS_SEND_EMAIL_112'," hat Ihnen einen Warenkorb geteilt. Sie können auf den Knopf unten klicken, um den geteilten Warenkorb zu sehen und die Produkte Ihrem eigenen Warenkorb hinzuzufügen.");
define('FS_SEND_EMAIL_113'," Produktliste");
define('FS_SEND_EMAIL_115',"Diese E-Mail wurde von ");
define('FS_SEND_EMAIL_116'," über ");
define('FS_SEND_EMAIL_117'," Teilen-Service gesendet.");
define('FS_SEND_EMAIL_118'," Sie werden keine unangeforderte Nachrichten von ");
define('FS_SEND_EMAIL_119'," erhalten. Klicken Sie ");
define('FS_SEND_EMAIL_120',"hier");
define('FS_SEND_EMAIL_121',"FS -  Ihr(e) Freund*in ");
define('FS_SEND_EMAIL_122'," hat Ihnen einen Warenkorb geteilt");
//分享产品
define('FS_SEND_EMAIL_123',"Geteiltes Produkt");
define('FS_SEND_EMAIL_124',"Vielleicht sind Sie an diesem Produkt interessiert");
define('FS_SEND_EMAIL_125',"Details anzeigen");
define('FS_SEND_EMAIL_126'," Teilen-Service gesendet. Sie erhalten keine unerwünschte Nachricht aus ");
define('FS_SEND_EMAIL_127'," Mehr Informationen zu unseren ");
define('FS_SEND_EMAIL_129'," hat Ihnen ein Produkt geteilt");
//RMA取消订单邮件
define('FS_SEND_EMAIL_130',"RMA-Informationen");
define('FS_SEND_EMAIL_131',"Ihr RMA-Antrag für die Bestellung # ");
define('FS_SEND_EMAIL_132'," wurde storniert. Wir sind hier, um Ihr Problem zu lösen.");
define('FS_SEND_EMAIL_133',"RMA wurde storniert");
define('FS_SEND_EMAIL_135'," wurde storniert.");
define('FS_SEND_EMAIL_136',"Wir sind hier, um Ihr Problem zu lösen.");
define('FS_SEND_EMAIL_137',"RMA");
//订单评价成功邮件
define('FS_SEND_EMAIL_138'," hat Ihnen eine Zahlungsanfrage geschickt.");
define('FS_SEND_EMAIL_139',"Bestellstatus");
define('FS_SEND_EMAIL_140',"Ihre Bestellung #");
define('FS_SEND_EMAIL_141',"Stornierte Bestellung");
define('FS_SEND_EMAIL_142',"Vielen Dank, dass Sie sich für FS entschieden haben. Wir hoffen, Sie bald wiederzusehen.");
define('FS_SEND_EMAIL_143',"Bestelldetails");
//留言入口客户调查问卷
define('FS_SEND_EMAIL_144',"Feedback teilen");
define('FS_SEND_EMAIL_145',"Möchten Sie FS.COM an Ihre Freunde weiterempfehlen?");
define('FS_SEND_EMAIL_146',"Um sicherzustellen, dass Sie das beste Einkaufserlebnis genießen,<br>beantworten Sie bitte die obige Frage. Wenn Sie auf diese Frage antworten, werden Sie aufgefordert, eine<br>kurze Erklärung für Ihre Bewertung abzugeben. Alle Feedbacks sind sehr hilfreich.");
//live_chat留言
define('FS_SEND_EMAIL_147',"Thema des Feedbacks");
define('FS_SEND_EMAIL_148',"Vielen Dank für Ihren Kontakt. Wir haben Ihre E-Mail erhalten und werden uns innerhalb von 12 Stunden bei Ihnen melden.\"");
define('FS_SEND_EMAIL_149',"FS - Wir haben Ihre E-Mail erhalten");
define('FS_SEND_EMAIL_150',"Vielen Dank für Ihren Kontakt. Wir haben Ihre E-Mail erhalten und werden uns innerhalb von 12 Stunden bei Ihnen melden. Ihre Case-Nummer ist ");
define('FS_SEND_EMAIL_151',"Artikel teilen");
define('FS_SEND_EMAIL_152',"Vielleicht sind Sie an diesem Produkt interessiert");
define('FS_SEND_EMAIL_153',"Ihr(e) Freund(e) ");
define('FS_SEND_EMAIL_154'," Diese E-Mail wurde gesendet von ");
define('FS_SEND_EMAIL_155'," teilte diese Artikel mit Ihnen über ");
define('FS_SEND_EMAIL_156',"FS - Ihre RMA wurde storniert");
define('FS_SEND_EMAIL_157',"FS - Ihre Angebot-Anfrage  ");
define('FS_SEND_EMAIL_158',"Anmerkung von");
define('FS_SEND_EMAIL_159',"Geteilter Warenkorb");
//退换货
define('FS_SEND_EMAIL_160',"Ihre Bestellung #");
define('FS_SEND_EMAIL_160_01',"FS - Ihre Bestellung #");
define('FS_SEND_EMAIL_161',"FS - Ihre Bestellung ");
define('FS_SEND_EMAIL_162',"Anweisung für die Rücksendung");
define('FS_SEND_EMAIL_163',"1. RMA-Formular drucken");
define('FS_SEND_EMAIL_164',"Das RMA-Formular kann uns dabei helfen, Ihr Paket zu identifizieren. Drucken Sie bitte das RMA-Formular und es in das Paket legen.");
define('FS_SEND_EMAIL_165',"2. Artikel verpacken");
define('FS_SEND_EMAIL_166',"Wenn Sie den ursprünglichen Versandkarton verwenden, reißen Sie bitte das vorherige Versandetikett ab.");
define('FS_SEND_EMAIL_167',"3. Paket zurücksenden");
define('FS_SEND_EMAIL_168',"Senden Sie uns das Paket zurück.");
define('FS_SEND_EMAIL_169',"4. Erstattung erhalten");
define('FS_SEND_EMAIL_170',"Vielen Dank für Ihren Kontakt. Wir haben Ihre Anruf-Anfrage erhalten und werden uns so schnell wie möglich mit Ihnen in Verbindung setzen.");
define('FS_SEND_EMAIL_171',"FS - Wir haben Ihre Anruf-Anfrage erhalten");
define('FS_SEND_EMAIL_3_1',"Zahlung-Link");
define('FS_PRE_ORDER','Vorbestellung');
define('FS_DAY_PROCESSING','<span class="process_time_dylan">$DAYNUMBER</span> Tage Bearbeitungszeit');
define('FS_DAY_PROCESSING_SEARCH','<span class="process_time_dylan">$DAYNUMBER</span> Tage Bearbeitungszeit');
define("PREORDER_DESPRCTION","Der FS Vorbestellservice ist ein Produktionsprozess, bei dem die Fertigung erst nach Eingang der Bestellung eines Kunden beginnt. Der Fokus liegt darauf, Ihnen zu helfen, Projektbudget zu sparen und frühzeitig einen Projektplan erstellen zu können.");

define("PRERDER_PROCESSIONG","<i class='popover_i'></i>Die Bearbeitungszeit bezieht sich auf den Werktag, schließt Herstellung und Tests ein. Es enthaltet nicht die Lieferzeit, da die Lieferzeit von Ihre gewählten Versandoption bestimmt wird.");
define("PRERER_SAVE","um Projektbudget zu sparen");

//quest add 2019-03-01
define('CHECKOUT_CUSTOMER_ACCOUNT1','Bitte geben Sie ein gültiges Konto ein, das aus 9 Ziffern besteht.');
define('CHECKOUT_CUSTOMER_ACCOUNT2','Bitte geben Sie ein gültiges Konto ein, das aus 6 Zeichen besteht');

// fairy 2019.1.17 组合子产品
define("FS_ITEM_INCLUDES_PRODUCTS","Der Artikel umfasst die folgenden Produkte");


define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total general');
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');

define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+)Shipping Cost:');
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Total');
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');

//2019.3.9   ery  add 专题询价板块
define('FS_SPECILA_INQUIRY_QUESTION', 'Haben Sie noch Fragen?');
define('FS_SPECILA_INQUIRY_ASK', 'Fragen zu dem Preis, der Lieferung oder anderen Informationen. Wir sind hier, um Ihnen zu helfen.');

//rebirth.ma  2019.03.12  上传错误定义
define("FS_FILE_TOO_LARGE","Datei ist zu groß, Upload ist fehlgeschlagen");

define('FIBERSTORE_PRODUCT_DETAIL','Produktdetails');
//rebirth.ma  2019.03.22  购物车样式调整
define("FS_Summary","Bestellübersicht");

//liang.zhu 2019.04.02 定义tpl_modules_index_product_list_old_style.php
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'In der Gitterdarstellung');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'In einer Liste anzeigen');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'Schnellsuche');

//faq问题汇总
define('FS_FAQ_HELPFUL_01',"Ist diese Antwort hilfreich?");
define('FS_FAQ_HELPFUL_02',"Ja");
define('FS_FAQ_HELPFUL_03',"Nein");
define('FS_FAQ_HELPFUL_04',"Vielen Dank für Ihr Feedback!");
define('FS_FAQ_HELPFUL_05',"Was können wir verbessern?");
define('FS_FAQ_HELPFUL_06',"Das war verwirrend");
define('FS_FAQ_HELPFUL_07',"Das hat meine Frage nicht beantwortet");
define('FS_FAQ_HELPFUL_08',"Ich mag Ihre Politik nicht");
define('FS_FAQ_HELPFUL_09',"Absenden");

//2019.4.4  ery  ADD俄罗斯对公支付方式名
define("FS_CHECKOUT_NEW_CASHLESS","Bargeldlose Zahlung");
define("SHIPPING_COURIER_DELIVERY","Kurierlieferung");
define("SHIPPING_DELIVERY","Lieferung");
define("SHIPPING_COURIER_DELIVERY_01"," for Nature Person");
//2019.4.11  ery add  俄罗斯对公支付收税政策文字表达优化
define('CHECKOUT_TAXE_RU_TIT', 'In Übereinstimmung mit Kapitel 21 der Abgabenordnung der Russischen Föderation ist FS.COM GmbH verpflichtet, für alle Bestellungen, die an Russland geliefert werden, Mehrwertsteuer zu erheben. Alle Produkte aus unserem Katalog unterliegen der Mehrwertsteuer in Höhe von 20% der Kosten gemäß dem allgemeinen Steuergesetz Russlands. Sie kennen den Gesamtbetrag inklusive der Mehrwertsteuer vor der Zahlung, wenn Sie alle erforderlichen Informationen über die Bestellung eingeben (einschließlich der Art des Unternehmens und der Lieferadresse).');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","Für Bestellungen, die von unserem internationalen Lager versandt werden, berechnen wir NUR den Produktwert und die Versandkosten. Eventuelle Zoll- oder Einfuhrabgaben, die durch die Zollabfertigung verursacht werden, müssen vom Empfänger deklariert und getragen werden. Ab dem 1. Januar 2020 wurde die Schwelle für zollfreie Einkäufe auf 200€ und bis zu 31kg pro Paket gesenkt. Wenn Sie an anderen Versandmethoden interessiert sind oder bargeldlos bezahlen möchten, wenden Sie sich bitte an Ihren Kundenbetreuer.");
define("FS_CREDIT_CARD_NOTICE","Bitte geben Sie Ihre Rechnungsadresse für die Zahlung ein");
//ternence
define('FS_CREDIT','Mein Kreditkonto');

//Jeremy.Wu 2019.4.17 定义本地取货
define('FS_LOCAL_PICKUP','Selbstabholung');

//报价改版 ternence 2019.04.17
define("FS_INQUIRY_INFO","Zitatblatt");
define("FS_INQUIRY_INFO_1","Neue Produkte hinzufügen");
define("FS_INQUIRY_INFO_2","Hinzufügen");
define("FS_INQUIRY_INFO_3","Geben Sie bitte eine Produkt-ID ein.");
define("FS_INQUIRY_INFO_4","Stückpreis");
define("FS_INQUIRY_INFO_5"," Nachricht hinterlassen ");
define("FS_INQUIRY_INFO_6","bearbeiten");
define("FS_INQUIRY_INFO_7","Haben Sie ein bestehendes Konto?");
define("FS_INQUIRY_INFO_8","Melden Sie sich an</a> oder ");
define("FS_INQUIRY_INFO_9","Konto eröffnen");
define("FS_INQUIRY_INFO_10",", um Ihre Anfrage online zu verfolgen.");
define("FS_INQUIRY_INFO_11","Informationen, die Sie sich möglicherweise über das Angebot interessieren");
define("FS_INQUIRY_INFO_12","Logo");
define("FS_INQUIRY_INFO_13","Garantie");
define("FS_INQUIRY_INFO_14","Vorlaufzeit");
define("FS_INQUIRY_INFO_15","Mengenpreis");
define("FS_INQUIRY_INFO_16","Beschaffungsauftrags-Nr.");
define("FS_INQUIRY_INFO_17","Zusätzliche Anmerkungen");
define("FS_INQUIRY_INFO_18","Datei");
define("FS_INQUIRY_INFO_19","Zulässiger Dateityp sind JPG, PDF, PNG , PDF, XLS, XLSX <br> Maximale Dateigröße ist 5M");
define("FS_INQUIRY_INFO_20","Anfrage einreichen");
define("FS_INQUIRY_INFO_21","Die Angebotsliste ist leer.");
define("FS_INQUIRY_INFO_22","Weiter kaufen");
define("FS_INQUIRY_INFO_24","Die Antwort dauert etwa 12 Stunden.");
define("FS_INQUIRY_INFO_25","Angebot anfragen");
define("FS_INQUIRY_INFO_26","Der Artikel unten ist ein maßgeschneidertes Produkt. Bitte wählen Sie das Attribut auf der Produktseite aus und fügen Sie es der Angebotsliste hinzu.");
define("FS_INQUIRY_INFO_26_2","Die Artikelnummer");
define("FS_INQUIRY_INFO_26_3","wurde in unserem Datensatz nicht gefunden.");
define("FS_INQUIRY_INFO_27","Ihre Angebotsanfrage ");
define("FS_INQUIRY_INFO_28"," wurde eingereicht.");
define("FS_INQUIRY_INFO_29","Wir werden innerhalb von 12 bis 24 Stunden die Anfrage bearbeiten und Ihnen antworten. Sie können den Angebotsstatus unter <b>Mein Konto</b> > <b>Meine Angebote</b> nachsehen.");
define("FS_INQUIRY_INFO_30","Hallo Kunde! ");
define("FS_INQUIRY_INFO_30_1","Attribut auswählen ");
define("FS_INQUIRY_INFO_31","Mit einem Konto können Sie das Angebot in „Mein Konto“ einfach sehen und auch einen besseren FS-Service erhalten:");
define("FS_INQUIRY_INFO_32","- Leichter Überblick über Ihre Bestellungen");
define("FS_INQUIRY_INFO_33","- Schnellere Kasse mit einem Adressbuch");
define("FS_INQUIRY_INFO_34","Möchten Sie jetzt ein Konto eröffnen?");
define("FS_INQUIRY_INFO_35","Nein, Danke. (Wir antworten auf Ihr Angebot per E-Mail )");
define("FS_INQUIRY_INFO_36","Ja, ich möchte jetzt ein Konto eröffnen.");

define("FS_INQUIRY_INFO_37","Meine Angebote");
define("FS_INQUIRY_INFO_38","Sie können den Status Ihrer Anfrage überprüfen und direkt mit den Vorzugspreisen kaufen. ");
define("FS_INQUIRY_INFO_39","Kontaktieren Sie Kundenservice");
define("FS_INQUIRY_INFO_40","Angebotsdatum");
define("FS_INQUIRY_INFO_41","Angebotsnummer");
define("FS_INQUIRY_INFO_42","Gesamtsumme");
define("FS_INQUIRY_INFO_43","Name der Angebot");
define("FS_INQUIRY_INFO_43_1","Mehr");
define("FS_INQUIRY_INFO_43_2","Angebot stornieren");

define("FS_INQUIRY_INFO_44","Angebotsanfragen hinzugefügt");
define("FS_INQUIRY_INFO_45","Menge");
define("FS_INQUIRY_INFO_46","Liste sehen");
define("FS_INQUIRY_INFO_47","Angebot anfragen");
define("FS_INQUIRY_INFO_48","Angebotsanfrage");
define("FS_INQUIRY_INFO_23","Ihre Angebotsanfrage ");
define("FS_INQUIRY_INFO_23_1"," wurde gesandt.");
define("FS_INQUIRY_INFO_49","Name des Angebots:");
define("FS_INQUIRY_INFO_50","Dieses Angebot werden in X Tage verfallen. Wenn Sie diese Artikel in dem Angebot bestellen möchten, bezahlen Sie so schnell wie möglich.");
define("FS_INQUIRY_INFO_51","Ihr Angebot ist verfällt.");
define("FS_INQUIRY_INFO_52","Hinweis");
define("FS_INQUIRY_INFO_54","Produkt-ID");
define("FS_INQUIRY_INFO_55","Geben Sie bitte eine Produkt-ID ein.");
define("FS_INQUIRY_INFO_56","Name*");
define("FS_INQUIRY_INFO_57","E-Mail-Adresse*");
define("FS_INQUIRY_INFO_58","Telefonnummer*");
define("FS_INQUIRY_INFO_59","Die Produkt-ID ");
define("FS_INQUIRY_INFO_60","  kann nicht gefunden werden.");
define("FS_INQUIRY_INFO_61","Benennen Sie Ihr Angebot");
define("FS_INQUIRY_INFO_62","Angebotsnummer");
define("FS_INQUIRY_INFO_63","Bitte wählen Sie die Produktparameter in der schwarzen Rahmen aus.");
define("FS_INQUIRY_BUY_TIP",'Dieses Angebot gilt nur für 15 Tage und die Abnahmemenge muss mindestens der Anfrage entsprechen. Bitte machen Sie Kasse so schnell wie möglich.');
define("FS_INQUIRY_INFO_53","ANGEBOTSANFRAGE");
define("FS_INQUIRY_INFO_64","Alle Angebote");
define("FS_INQUIRY_INFO_65","Dieses Angebot gilt nur für 15 Tage. Bitte machen Sie Kasse so schnell wie möglich.");
define("FS_INQUIRY_INFO_66","Ihr Angebot ist abgelaufen.");

define('FS_INQUIRY_EMPTY_TXT','Sie haben noch keine Angebote angefragt.');
define('FS_INQUIRY_EMPTY_TXT_01','Sie können ein Angebot auf der Produktdetailseite anfragen oder direkt hier eine Produkt-ID eingeben.');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">Wenn Sie bereits ein FS-Konto haben, können Sie sich <a href="'.zen_href_link('login','','SSL').'">Anmelden</a>, um Ihre Angebotsanfrage nachzusehen.</p>');

define('FS_ACCOUNT_NEW_01','Hilfe');
define('FS_ACCOUNT_NEW_02','Montag - Freitag');
define('FS_ACCOUNT_NEW_03','Bestellungen');
define('FS_ACCOUNT_NEW_04','Meine Bestellungen');
define('FS_ACCOUNT_NEW_05','Zurückgesandt');
define('FS_ACCOUNT_NEW_06','Verfügbare Kreditlinie:');
define('FS_ACCOUNT_NEW_07','Letzte Bestellung');
define('FS_ACCOUNT_NEW_08','Meine Bestellungen anzeigen');
define('FS_ACCOUNT_NEW_09','Sie haben in letzter Zeit keinen Kauf getätigt.');
define('FS_ACCOUNT_NEW_10','Zuletzt angesehene Produkte');
define('FS_ACCOUNT_NEW_11','Letztes Angebot');
define('FS_ACCOUNT_NEW_12',' Meine Angebote anzeigen');
define('FS_ACCOUNT_NEW_13','Sie haben in einiger Zeit kein Angebot erstellt.');

//2019.5.3 pico 企业账号注册

define("FS_BUSINESS_ACCOUNT_01","Die Vorteile des Geschäftskontos");
define("FS_BUSINESS_ACCOUNT_02","Jetzt eröffnen Sie ein Geschäftskonto dann können mindestens 2% Rabatt bei jeder Bestellung und unseren kostenlosen Beratungsservice genießen.");
define("FS_BUSINESS_ACCOUNT_03","Vorzugspreis");
define("FS_BUSINESS_ACCOUNT_04","Schnelle Lieferung");
define("FS_BUSINESS_ACCOUNT_05","Einfache Online-Angebote");
define("FS_BUSINESS_ACCOUNT_06","Professionelle Sonderanfertigungen");
define("FS_BUSINESS_ACCOUNT_07",'Haben Sie schon ein Konto bei FS? <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">Upgrade Ihr Konto</a>');
define("FS_BUSINESS_ACCOUNT_08",'Brauchen Sie Hilfe? Wir sind täglich rund um die Uhr für Sie da');
define("FS_BUSINESS_ACCOUNT_09",'Live Chat');
define("FS_BUSINESS_ACCOUNT_10",'+49 (0) 8165 80 90 517');
define("FS_BUSINESS_ACCOUNT_11",'de@fs.com');
define("FS_BUSINESS_ACCOUNT_12",'Das Geschäftskonto wurde beantragt.');
define("FS_BUSINESS_ACCOUNT_13",'Willkommen bei FS. Ihre Anmeldung ist empfangen. Der Account Manager überprüft Ihr Konto als Geschäftskonto so bald wie möglich.');
define("FS_BUSINESS_ACCOUNT_14",'Ihre Anmeldung ist empfangen. Bitte warten Sie auf die Überprüfung und Bestätigung.');
define("FS_BUSINESS_ACCOUNT_15",'Klicken Sie hier, um Ihr Kontocenter zu betreten');
define("FS_BUSINESS_ACCOUNT_15_1",'<a class="lr_right_href" href="'.zen_href_link('my_dashboard').'">Klicken Sie hier</a>, um Ihr Kontocenter zu betreten');
define("FS_BUSINESS_ACCOUNT_16",'Ihr Geschäftskonto-Antrag wird derzeit geprüft.');
define("FS_BUSINESS_ACCOUNT_17",'Haben Sie kein Konto? <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '">  Registrieren Sie ein Geschäftskonto</a>');
define("FS_BUSINESS_ACCOUNT_18",'Geschäftskonto eröffnen');
define("FS_BUSINESS_ACCOUNT_19",'Konto upgraden');
define("FS_BUSINESS_ACCOUNT_20",'Ihr Geschäftskonto wird jetzt registriert.');
//add by rebirth  结算页超重超大标签
define('FS_HEAVY','Schwer');

define('FS_OVERSIZED','Übergroß');

//add by jeremy 各语种公司名称
define('FS_LOCAL_COMPANY_NAME','FS.COM GmbH');
define('FS_US_COMPANY_NAME','FS.COM Inc.');
define('FS_DE_COMPANY_NAME','FS.COM GmbH');
define('FS_UK_COMPANY_NAME','FIBERSTORE Ltd.');
define('FS_AU_COMPANY_NAME','FS.COM Pty Ltd');
define('FS_SG_COMPANY_NAME','FS Tech Pte Ltd.');
define('FS_RU_COMPANY_NAME','FS.COM Ltd.');
define('FS_CN_COMPANY_NAME','FS.COM LIMITED');

//amp语言包
//十个专题模块
define('FS_AMP_CATE_01','25G/100G');
define('FS_AMP_CATE_02','40G');
define('FS_AMP_CATE_03','10G');
define('FS_AMP_CATE_04','DAC/AOC');
define('FS_AMP_CATE_05','Switches');
define('FS_AMP_CATE_06','WDM<br>MUX');
define('FS_AMP_CATE_07','Optische <br>Kabel');
define('FS_AMP_CATE_08','MTP/MPO Kabel');
define('FS_AMP_CATE_09','Modulare Verkabelung');
define('FS_AMP_CATE_10','Kupfer Netzwerk');
//Interconnection产品模块
define('FS_AMP_INTERCONNECT_01','Zusammenschaltung');
//Optical Transport Network产品模块
define('FS_AMP_OPTICAL_TRANS_01','Optische Übertragungsnetzwerke');
//Network Cable Assemblies产品模块
define('FS_AMP_NETWORK_CABLE_01','Kabelkonfektion');
//Space Management产品模块
define('FS_AMP_SPACE_MANAGE_01','Management für Datenzentren');
//Solution模块
define('FS_AMP_SOLUTION_01','Lösungen');
//公共底部模块
define('FS_AMP_FOOTER_01','E-Mail senden');
define('FS_AMP_FOOTER_02','Live-Chat');
define('FS_AMP_FOOTER_03','Live ChaSupport');
define('FS_AMP_FOOTER_04','Company');
define('FS_AMP_FOOTER_05','Quick Access');
define('FS_AMP_FOOTER_06','Copyright © 2009-2019 FS.COM Inc All Rights Reserved.');
define('FS_AMP_FOOTER_07','Privacy policy');
define('FS_AMP_FOOTER_08','Terms of use');
//第一级侧边栏
define('FS_AMP_FIRST_SIDEBAR_01','Konto / Anmelden');
define('FS_AMP_FIRST_SIDEBAR_02','Alle Kategorien');
define('FS_AMP_FIRST_SIDEBAR_03','Unternehmensnetzwerk');
define('FS_AMP_FIRST_SIDEBAR_04','Optische Transceiver');
define('FS_AMP_FIRST_SIDEBAR_05','LWL-Kabel');
define('FS_AMP_FIRST_SIDEBAR_06','Rack & Gehäuse');
define('FS_AMP_FIRST_SIDEBAR_07','WDM & Optical Access');
define('FS_AMP_FIRST_SIDEBAR_08','Cat 5e/Cat 6/Cat 7/Cat 8');
define('FS_AMP_FIRST_SIDEBAR_09','Tester & Werkzeuge');
define('FS_AMP_FIRST_SIDEBAR_10','Support');
define('FS_AMP_FIRST_SIDEBAR_11','Company');
define('FS_AMP_FIRST_SIDEBAR_12','Quick Access');
define('FS_AMP_FIRST_SIDEBAR_13','Hilfe & Einstellung');
//所有二级分类侧边栏
define('FS_AMP_SECOND_SIDEBAR_01','Hauptmenü');
define('FS_AMP_SECOND_SIDEBAR_02','Unternehmensnetzwerk');
define('FS_AMP_SECOND_SIDEBAR_03','Network Switches');
define('FS_AMP_SECOND_SIDEBAR_04','Data Center Switches');
define('FS_AMP_SECOND_SIDEBAR_05','PDU, UPS, Power System');
define('FS_AMP_SECOND_SIDEBAR_06','Network Adapters');
define('FS_AMP_SECOND_SIDEBAR_07','Routers, Servers');
define('FS_AMP_SECOND_SIDEBAR_08','Medienkonverter, KVM, TAP');
define('FS_AMP_SECOND_SIDEBAR_09','Optische Transceiver');
define('FS_AMP_SECOND_SIDEBAR_10','40G/100G Transceivers');
define('FS_AMP_SECOND_SIDEBAR_11','SFP+ Transceivers');
define('FS_AMP_SECOND_SIDEBAR_12','SFP Transceivers');
define('FS_AMP_SECOND_SIDEBAR_13','Direct Attach Kabel');
define('FS_AMP_SECOND_SIDEBAR_14','Aktive Optische Kabel');
define('FS_AMP_SECOND_SIDEBAR_15','XFP Transceiver');
define('FS_AMP_SECOND_SIDEBAR_16','Digital Video Transceiver');
define('FS_AMP_SECOND_SIDEBAR_17','Andere Transceiver');
define('FS_AMP_SECOND_SIDEBAR_18','FS Box');
define('FS_AMP_SECOND_SIDEBAR_19','LWL-Kabel');
define('FS_AMP_SECOND_SIDEBAR_20','MTP LWL-Patchkabel');
define('FS_AMP_SECOND_SIDEBAR_21','LWL-Kabel');
define('FS_AMP_SECOND_SIDEBAR_22','Robuste LWL-Kabel');
define('FS_AMP_SECOND_SIDEBAR_23','MPO LWL-Patchkabel');
define('FS_AMP_SECOND_SIDEBAR_24','Ultra HD LWL-Patchkabel');
define('FS_AMP_SECOND_SIDEBAR_25','Vorkonfektionierte LWL-Patchkabel');
define('FS_AMP_SECOND_SIDEBAR_26','LWL Pigtails');
define('FS_AMP_SECOND_SIDEBAR_27','LWL-Patchkabelbaugruppen');
define('FS_AMP_SECOND_SIDEBAR_28','Kabel Meterware');
define('FS_AMP_SECOND_SIDEBAR_29','Rack & Gehäuse');
define('FS_AMP_SECOND_SIDEBAR_30','Racks & Netzwerkschränke');
define('FS_AMP_SECOND_SIDEBAR_31','LWL-Gehäuse');
define('FS_AMP_SECOND_SIDEBAR_32','LWL-Patchpanel');
define('FS_AMP_SECOND_SIDEBAR_33','MTP LWL-Kassetten');
define('FS_AMP_SECOND_SIDEBAR_34','MPO LWL-Kassetten');
define('FS_AMP_SECOND_SIDEBAR_35','LWL-Kassetten');

define('FS_AMP_SECOND_SIDEBAR_57','MTP-LC Breakout Panels');
define('FS_AMP_SECOND_SIDEBAR_58','Kabelmanagement');
define('FS_AMP_SECOND_SIDEBAR_59','Raceway System');

define('FS_AMP_SECOND_SIDEBAR_36','WDM & Optical Access');
define('FS_AMP_SECOND_SIDEBAR_37','Mux Demux & OADM');
define('FS_AMP_SECOND_SIDEBAR_38','Passive Komponenten');
define('FS_AMP_SECOND_SIDEBAR_39','Faserverteilungsanschluss');
define('FS_AMP_SECOND_SIDEBAR_40','FMT WDM Transport Platform');
define('FS_AMP_SECOND_SIDEBAR_41','FMT Infrastrukturmodule');
define('FS_AMP_SECOND_SIDEBAR_42','Reiniger & Tester');
define('FS_AMP_SECOND_SIDEBAR_43','Cat 5e/Cat 6/Cat 7/Cat 8');
define('FS_AMP_SECOND_SIDEBAR_44','Patchkabel');
define('FS_AMP_SECOND_SIDEBAR_45','Vorkonfektionierte Trunkkabel');
define('FS_AMP_SECOND_SIDEBAR_46','Verlegekabel');
define('FS_AMP_SECOND_SIDEBAR_47','Patchpanel');
define('FS_AMP_SECOND_SIDEBAR_48','Kabelmanagement');
define('FS_AMP_SECOND_SIDEBAR_49','Netzwerk-Tools & Tester');
define('FS_AMP_SECOND_SIDEBAR_50','Tester & Werkzeuge');
define('FS_AMP_SECOND_SIDEBAR_51','LWL-Reinigung');
define('FS_AMP_SECOND_SIDEBAR_52','Grundlegende Fasertests');
define('FS_AMP_SECOND_SIDEBAR_53','Fortschrittliche Faserprüfung');
define('FS_AMP_SECOND_SIDEBAR_54','Fiber Polish & Splice');
define('FS_AMP_SECOND_SIDEBAR_55','LWL-Werkzeuge');
define('FS_AMP_SECOND_SIDEBAR_56','Netzwerk-Tools & Tester');
//三级分类侧边栏
define('FS_AMP_THIRD_SIDEBAR_01','Go back');
//登陆后侧边栏
define('FS_AMP_LOGIN_SIDEBAR_01','My Account');
define('FS_AMP_LOGIN_SIDEBAR_02','Account Setting');
define('FS_AMP_LOGIN_SIDEBAR_03','Order History');
define('FS_AMP_LOGIN_SIDEBAR_04','Address Book');
define('FS_AMP_LOGIN_SIDEBAR_05','My Cases');
define('FS_AMP_LOGIN_SIDEBAR_06','My Quotes');
define('FS_AMP_LOGIN_SIDEBAR_07','Sign out');
//搜索侧边栏
define('FS_AMP_SEARCH_01','Beliebtes Suchen');
//语言选择
define('FS_AMP_SELECT_LANG_01','Land/Region wählen');
define('FS_AMP_SELECT_LANG_02','Speichern');
//订阅功能语言包(单页面，账户中心)
define('FS_EMAIL_SUBSCRIPTION_01','E-Mail-Abonnement');
define('FS_EMAIL_SUBSCRIPTION_02','Verwalten Sie Ihre E-Mail-Abonnementeinstellungen und erhalten Sie die neuesten Nachrichten von FS.');
define('FS_EMAIL_SUBSCRIPTION_03','E-Mail-Abonnement');
define('FS_EMAIL_SUBSCRIPTION_04','Geben Sie die E-Mail-Adresse ein, deren Abonnenment Sie verwalten möchten.');
define('FS_EMAIL_SUBSCRIPTION_05','Indem Sie FS-E-Mails abonnieren, können Sie mehr neuesten Informationen über Sonderangebote, Warenbestand, technischen Support usw. erfahren. Von neuen Produkten bis zu Datenzentrumslösungen, die Sie möglicherweise nicht kennen, werden Sie von E-Mails aus FS informiert!');
define('FS_EMAIL_SUBSCRIPTION_06','E-Mails über Ihr Konto und Bestellungen sind wichtig. Wir senden diese E-Mails auch dann, wenn Sie Abonnements deaktivieren. ');
define('FS_EMAIL_SUBSCRIPTION_07','Beachten Sie bitte, dass es bis zu 48 Stunden dauern kann, bis die Änderung aktiv ist. Sie erhalten unabhängig von Ihren Abonnement-Einstellungen weiterhin E-Mails mit Informationen über Bestellungen, Sondenangebote, Warenbestand und technischen Support.');
define('FS_EMAIL_SUBSCRIPTION_08','Wie oft möchten Sie Abonier-Nachrichten erhalten?');
define('FS_EMAIL_SUBSCRIPTION_09','Regelmäßig');
define('FS_EMAIL_SUBSCRIPTION_10','Nicht mehr als einmal pro Woche');
define('FS_EMAIL_SUBSCRIPTION_11','Nicht mehr als einmal pro Monat');
define('FS_EMAIL_SUBSCRIPTION_12','Niemals');
define('FS_EMAIL_SUBSCRIPTION_13','Bestätigen');
define('FS_EMAIL_SUBSCRIPTION_14','Stornieren');
define('FS_EMAIL_SUBSCRIPTION_15','Ihre Anfrage wurde erfolgreich übermittelt!');
define('FS_EMAIL_SUBSCRIPTION_16','Wir werden Ihnen innerhalb von 24 Stunden antworten.');
define('FS_EMAIL_SUBSCRIPTION_17','Bitte geben Sie Ihre eigene E-Mail-Adresse ein.');
define('FS_EMAIL_SUBSCRIPTION_18','Abonnements anzeigen, ändern oder kündigen.');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span>Sie haben sich erfolgreich abgemeldet.');
define('FS_EMAIL_SUBSCRIPTION_20','Sie werden keine Werbe-E-Mails von FS mehr erhalten.');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>Sie haben sich erfolgreich angemeldet.');
define('FS_EMAIL_SUBSCRIPTION_22','Vielen Dank, dass Sie FS-E-Mails abonniert haben.');
define('FS_EMAIL_SUBSCRIPTION_23','Senden Sie mir einmal im Monat eine E-Mail mit den neuesten Nachrichten über FS.');
define('FS_EMAIL_SUBSCRIPTION_24','Sie erhalten keine Bewertungserinnerung von FS mehr.');
define('FS_EMAIL_SUBSCRIPTION_25','Sie erhalten keine Newsletter oder Bewertungserinnerung von FS mehr.');

//底部订阅语言包
define('FS_EMAIL_SUBSCRIPTION_FOOTER_01','Abonnieren');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02','Erhalten Sie die neuesten Nachrichten von FS');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03','Ihre E-Mail-Adresse');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04','Bitte geben Sie Ihre E-Mail-Adresse ein.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05','Bitte geben Sie eine gültige E-Mail-Adresse ein.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06','Vielen Dank für Ihr Abonnement!');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','Mobile Apps');
//2019.5.27 新政策弹窗 pico
define('FS_SHIPPING_RETURNS','<a class="info_returns" href="javascript:;">'.FS_DELIVERY_RETURN.'</a>');
define('FS_SHIPPING_WARRANTY','<a class="info_warranty" href="javascript:;">Garantie</a>');
define('FS_SHIPPING_SUPPORT','<a class="" href="'.reset_url('product_support.html?products_id=###').'" target="_blank">Produktsupport</a>');
define('FS_SHIPPING_RETURNS_TITLE','30-tägige Rückgabe');
define('FS_SHIPPING_RETURNS_PART',"FS bietet einen 30-tägigen Rückgabe- & Austauschservice, um Ihnen ein wirklich sorgenfreies Einkaufserlebnis zu garantieren. Wenn es unser Grund ist, die Rücksendung zu veranlassen oder zu ersetzen, sind wir für alle anfallenden Versandkosten und Steuern verantwortlich. Besuchen Sie <a href ='".zen_href_link('index')."policies/day_return_policy.html' target='_blank'>die Rückgaberichtlinie,</a> um Details zu verschiedenen Produkten zu erfahren.");
define('FS_SHIPPING_WARRANTY_TITLE','Garantie auf die gesamte Produktpalette');
define('FS_SHIPPING_WARRANTY_PART',"Machen Sie sich keine Sorgen, wenn mit dem Produkt etwas schief geht, aber Sie das Rückgabefenster überschritten haben. Solange sich das Produkt in der Garantiezeit befindet, können Sie kostenlosen Wartungsservice in Anspruch nehmen. Suchen Sie nach einer bestimmten Garantiezeit für Produkte in den <a href ='".zen_href_link('index')."policies/warranty.html' target='_blank'>Garantierichtlinien</a>.");
define('FS_SHIPPING_SUPPORT_TITLE','Kostenlose Technische Unterstützung');
define('FS_SHIPPING_SUPPORT_PART',"FS hat sich zum Ziel gesetzt, vertrauenswürdige Partner unserer Kunden zu werden und ein umfassendes Portfolio an digitalen Infrastrukturprodukten sowie eine umfassende One-Stop digitale Lösung anzubieten.");
define('FS_SHIPPING_SUPPORT_PART_BR',"Sie können <a href='".reset_url('solution_support.html')."' target='_blank'>Technischen Support</a> anfordern, um rechtzeitige Hilfe bei Fragen zu den Artikeln oder bei der Gestaltung einer kostenlosen Konnektivitätslösung zu bekommen.");

//add by ternence 询价产品弹窗
define('FS_PRODUCT_INQUIRY_3','Ihre Anfrage wurde bei FS eingegangen. Wir werden Ihnen später eine Rückmeldung geben.');
define('FS_PRODUCT_INQUIRY_1','Wir werden Ihnen innerhalb von 24 Stunden antworten.');
define('FS_PRODUCT_INQUIRY_2','Durch Klicken auf die Schaltfläche unten stimmen Sie den Datenschutz- <a href="javascript:;" class="">und Cookie-Richtlinien</a> sowie <a href="javascript:;">AGB</a> von FS zu.');

//add by ternence 结算页面地址提示
define('FS_SALES_INFO_MODAL_ZIP_CODE','Postleitzahl*');
//退换货指引入口
define('FS_RETURN_BUTTON','Artikel zurücksenden');

//登陆超时
define('LOING_TIMEOUT','Aus Sicherheitsgründen ist Ihre Sitzung abgelaufen. Melden Sie sich bitte erneut an.');
//产品详情AOC
define('PRODUCT_AOC','Die Kabellänge kann je nach Bedarf von 1m bis 300m (3ft bis 984,252ft) maßgeschneidert werden.');
define('PRODUCT_AOC_1','Die Kabellänge kann je nach Bedarf von 1m bis 30m (3 ft bis 98,43 ft) maßgeschneidert werden.');
//报价列表
define('QUOTE_EMPTY_1','Sie haben noch keine Angebotsanfrage gestellt.');
define('QUOTE_EMPTY_2','Jetzt einkaufen');
define('QUOTE_EMPTY_3','Es wurden keine Angebotsanfragen gefunden.');

define("ATTRIBUTE_MESSAGE",'Vollständig kompatibel mit Cisco Switches. Für eine kompatible Matrix <a target="_blank" href="https://tmgmatrix.cisco.com"> klicken Sie hier</a> bitte.');

//首页cart sign in翻译
define('FILENAME_SIGN_IN','Anmelden');
define('FILENAME_HOME_CART','Warenkorb');

//购物车登陆且为空的状态 添加save cart入口
define('FS_SAVE_CART_ENTRANCE','Kaufen Sie weiter bei FS ein oder sehen Sie Ihre <a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">gespeicherten Warenkörbe</a>.');

//报价添加打印
define('INQUIRY_GET_A_QUOTE','Benötigen Sie Hilfe bei Ihrem Einkauf?');
define('INQUIRY_GET_A_QUOTE_1',"Wir sind immer bemüht, Ihnen Produkte von bester Qualität, günstige Preise bei Sammelbestellungen und schnellem Bearbeitungsprozess anzubieten, sobald die Bestellung aufgegeben wurde. Wenden Sie sich bitte an ");
define('INQUIRY_GET_A_QUOTE_2',' oder mailen Sie uns an ');
define('INQUIRY_GET_A_QUOTE_3','Angebot drucken');
define('INQUIRY_GET_A_QUOTE_4',' ANGEBOTSDETAILS');
define('INQUIRY_GET_A_QUOTE_5','Menge');
define('INQUIRY_GET_A_QUOTE_6','Angebotspreis');


//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', 'Kundenkonto');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', 'erhältlich, Transport erforderlich');
define('QV_SHOW_AVAILABLE_02', 'erhältlich, Auf dem Transport');

//清仓产品加购限制 Dylan 2019.8.27
define('FS_CLEARANCE_TIPS_TITLE','Unzureichende Vorräte');
define('FS_CLEARANCE_TIPS_CONTENT','Die von Ihnen angegebene Menge übersteigt das verfügbare Inventar <span class="clearance_total_qty">$QTY</span>. Bitte wenden Sie sich an Ihre Vertriebsmitarbeiterin, um weitere Mengen zu erhalten.');
define('QV_CLEARANCE_TIPS','Die von Ihnen angegebene Menge übersteigt das verfügbare Inventar <span class="clearance_total_qty">$QTY</span>.');
define('QV_CLEARANCE_EMPTY_QTY_TIPS','Dieses Produkt ist möglicherweise nicht auf Lager. Bitte wenden Sie sich an Ihren Account Manager für die Verfügbarkeit.');


//case studies分类
define('CASE_STUDIES_01','Standort');
define('CASE_STUDIES_02','Nordamerika');
define('CASE_STUDIES_03','Lateinamerika');
define('CASE_STUDIES_04','Europa');
define('CASE_STUDIES_05','Ozeanien');
define('CASE_STUDIES_06','Afrika');
define('CASE_STUDIES_07','Mittlerer Osten');
define('CASE_STUDIES_08','Asien');
define('CASE_STUDIES_09','Typ');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','Unternehmensnetzwerk');
define('CASE_STUDIES_12','Rechenzentrum-Verkabelung');
define('CASE_STUDIES_13','Industrie');
define('CASE_STUDIES_14','Finanzen');
define('CASE_STUDIES_15','Bildung');
define('CASE_STUDIES_16','Gesundheitspflege');
define('CASE_STUDIES_17','ISP');
define('CASE_STUDIES_18','Herstellung');
define('CASE_STUDIES_19','Transport');
define('CASE_STUDIES_20','Einzelhandel');
define('CASE_CLEAR_ALL','Alles löschen');
define("FS_PRODUCTS","Ergebnisse");
define("FS_PRODUCT","Ergebnis");
define('CASE_CATEGORY_MENU_CASE_STUDIES','Case Studies');

define('FS_TEST_TOOL','Testwerkzeug');
define('FS_ADDRESS_PO','PO');



// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','Passt zum <a href="de/c/fhd-rack-mount-45" style="color: #0070BC;">FHD Rack Mount</a> und <a href="de/c/fhd-wall-mount-3358" style="color: #0070BC;">FHD Wandmontage</a> Fasergehäuse');
define('FS_PRODUCT_INSTALLATION_TEXT_2','Passt zum <a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> Glasfasergehäuse, das in 19\'\' Rack eingebaut werden kann');
define('FS_PRODUCT_INSTALLATION_TEXT_3','Passt zum <a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> Glasfasergehäuse, das in 19\'\' Rack eingebaut werden kann');
define('FS_PRODUCT_INSTALLATION_TEXT_4','Passt zum <a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a> Glasfasergehäuse, das in 19\'\' Rack eingebaut werden kann');
define('FS_ADDRESS_PO','PO');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','Passt in Netzwerk- und Serverschränke der <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Serie</a> und der <a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;">HR800-Serie</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_6','Passt in Serverschränke der <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600-Serie</a> und der <a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;">HR600-Serie</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_7','Passt in Schränke der <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Serie</a> und der <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600-Serie</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_8','Passt in Netzwerk- und Serverschränke der <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Serie</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_9','Die FMX 100G Module passen auf das <a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color: #0070BC;">FMX-100G-CH2U-Chassis</a>, das in ein Rack eingebaut werden kann.');

// add by pico
define('CHECKOUT_ERROR_01', 'Bitte wählen Sie die Zahlungsart.');
define('CHECKOUT_ERROR_02', 'Der Name des Karteninhabers ist erforderlich.');
define('CHECKOUT_ERROR_03', 'Die Kartennummer ist erforderlich.');
define('CHECKOUT_ERROR_04', 'Der Sicherheitscode ist erforderlich.');
define("GLOBAL_GC_TEXT13","Kartennummer");
define("GLOBAL_GC_TEXT14","Ablaufdatum");
define("GLOBAL_GC_TEXT17","Sicherheitscode");


//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'Unsere Lösungen');
define('FS_BEST_SELLERS', 'Top Produkte');
define('FS_CASE_STUDIES', 'Case Studies');


//add ternence
define('INQUIRY_TITLE','Mailen Ihre Angebotsanfrage-Liste');
define('INQUIRY_TITLE_1','Mitgeteilte Angebotsanfrage');
define('INQUIRY_TITLE_2','E-Mail gesandt');
define('INQUIRY_TITLE_3','Ihre Angebotsanfrage wurde erfolgreich gesandt.');
define('INQUIRY_TITLE_4','Zurück zur Angebotsanfrage');
define('INQUIRY_TITLE_5','E-Mail wird erfolgreich gesendet');
define('INQUIRY_TITLE_6','Jemand hat seine Angebotsanfrage-Liste an Sie gesandt. Wenn Sie Hilfe benötigen, können Sie jederzeit ');
define('INQUIRY_TITLE_7','„Zur Angebotsanfrage hinzufügen“');
define('INQUIRY_TITLE_8',' klicken, um die Artikel auf dieser Seite zu Ihrer eigenen Angebotsanfrage-Liste hinzuzufügen.');
define('INQUIRY_TITLE_9','Teilen Sie die Angebot-Liste');
define('INQUIRY_TITLE_10','Angebot-Liste');
define('INQUIRY_TITLE_11',' hat eine Angebot-Liste mit Ihnen geteilt. Sie können auf die Schaltfläche unten klicken, um vollständige Details anzuzeigen und Ihrer eigenen Angebotsliste hinzuzufügen.');
define('INQUIRY_TITLE_12',' hat eine Angebot-Liste mit Ihnen geteilt');
define('INQUIRY_TITLE_13','Zur Angebotsanfrage hinzufügen');
define("FS_INQUIRY_INFO_67",'Ihre Angebotsanfrage ist leer.Wenn Sie bereits ein FS-Konto haben, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">Melden Sie sich an,</a> um Ihr Angebot zu sehen.');
define("FS_INQUIRY_INFO_68",'E-Mail');
define("FS_INQUIRY_INFO_69",'Stk.');

//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','Steuernummer');
define('CHECKOUT_TAX_2','Sie können von der Mehrwertsteuer befreit werden, wenn Sie eine gültige Umsatzsteueridentifikationsnummer haben.');


// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"Brauchen Sie Hilfe?");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"Kundenservice kontaktieren");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','Der folgende Artikel ist ein Geschenk und wird beim Bezahlen nicht zum Gesamtpreis berechnet.');
define('FS_GIFT_TITLE_ARE','Die folgende Artikel sind Geschenke und werden beim Bezahlen nicht zum Gesamtpreis berechnet.');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">Freies Geschenk</div></div>');
define('FS_GIFT_CHECK_TITLE','Geschenke sind für die aktuelle Lieferadresse nicht verfügbar. Wählen Sie bitte bei Bedarf das Test-Tool auf der Produktseite aus.');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">Freies Geschenk</div></div>');

// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY','Ich stimme der <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">Datenschutzerklärung</a> und den <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">AGBs</a> von FS zu.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Bitte stimmen Sie unsere Datenschutzerklärung und AGB zu.');

define('NEW_PRODUCTS_TAG','Neu');

define('HOT_PRODUCTS_TAG','Angesagt');


define("INVALID_CVV_ERROR",'Der Sicherheitscode ist falsch. Geben Sie bitte den richtigen Code ein und versuchen Sie es erneut.');

define('FS_ACCOUNT_CODING_REQUESTS','Codierungsanträge');
define('FS_ACCOUNT_MY_CODING_REQUESTS','Meine Codierungsanträge');
define('FS_ACCOUNT_CODING_REQUEST_BTN','Codierung beantragen');
define('CODING_REQUESTS_LIST','Codierungsantrag-Liste');
define('CODING_REQUESTS_CODING_DETAILS','Antragsdetails');

// 2019-7-19 potato 地址编辑提示修改
define("FS_POST_CODE_TITLE_ERROR","Ihre Postleitzahl ist erforderlich.");
define("FS_CITY_TITLE_ERROR","Ihr Vorort ist erforderlich.");
define("FS_CHECKOUT_ERROR28_AU","Bitte geben eine gültige Postleitzahl ein.");
define("ACCOUNT_EDIT_CITY_AU","Vorort");
define("ACCOUNT_EDIT_STATE_AU","Bundesstaat");
define("FS_ZIP_CODE_AU_NEW","Postleitzahl");


//add by liang.zhu 2019.09.02
define('FS_COMMON_LEARN_MORE', 'Mehr erfahren');
define('FS_COMMON_SEE_MORE', 'Mehr');
define('FS_COMMON_SEE_LESS', 'Weniger');

//模块标签属性
define('FS_PLACEHOLDER_EG','z.B:');
define('FS_OPTIONAL',' (optional)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','MwSt.');
define('FS_CHECK_OUT_INCLUDEING_RU','(inkl. MwSt.)');
define('FS_CHECK_OUT_EXCLUDING_RU','(exkl. MwSt.)');

//2019-9-7 Jeremy 购物车改版
define("FS_CART_ITEM_TOTAL","Gesamtpreis");
define("FS_CART_ATTR_BTN","Attribut(e) auswählen");
define("FS_CART_ATTR_CONTENT","Dies ist ein maßgeschneidertes Produkt. Bitte wählen Sie zuerst die Attribut(e) aus.");

// 表单次数提交频繁
define ('FS_SUBMIT_TOO_OFTEN', 'Sie versuchen es zu oft. Bitte versuchen Sie es später noch einmal.');
define ('FS_ROBOT_VERIFY_PROMOPT', 'Bitte folgen Sie den Anweisungen, um die Überprüfung abzuschließen.');

//2019-09-17 add by liang.zhu
define("CHECKOUT_TAXE_SG_TIT", "Informationen zu GST und Gebühren");
define("CHECKOUT_TAXE_SG_FRONT", " Für Bestellungen, die vom Lager in Singapur versandt und an Standorte innerhalb Singapurs geliefert werden, ist FS verpflichtet, GST auf den Produktwert und Versandgebühren in Höhe von 7% zu erheben.<br/><br/> Wenn das/die von Ihnen bestellte(n) Produkt(e) derzeit nicht vorrätig ist/sind, versenden wir sie direkt vom Lager in Asien (China) und berechnen KEINE GST. Für diese Pakete können jedoch Einfuhr- oder Zollgebühren erhoben werden. Alle Zoll- oder Einfuhrgebühren, die durch die Zollabfertigung verursacht werden, müssen vom Empfänger deklariert und getragen werden.");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "Über Pflicht und Steuer");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "Für Bestellungen, die an Standorte außerhalb Singapurs geliefert werden, berechnen wir nur den Produktwert und die Versandkosten. Es wird keine Umsatzsteuer (exkl. VAT Oder GST) erhoben. Abhängig von den Gesetzen/Vorschriften des jeweiligen Landes können den Paketen jedoch Einfuhr- oder Zollgebühren erhoben werden. Alle durch die Zollabfertigung verursachten Zölle sind vom Empfänger anzugeben und zu tragen.");

//mtp退货货提示语
define('FS_RETURN_ALL_MTP_PRODUCTS','Bitte senden Sie alles Zubehör zusammen zurück.');
//2019-09-17 add by liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', 'Nordamerika');
//澳洲
define('FS_STATE_OCEANIA', 'Oceanien');
//亚洲
define('FS_STATE_ASIA', ' Asien');
//欧洲
define('FS_STATE_EUROPE', 'Europa');
define('FS_PORTFOLIOS','Anwendungen');
define('FS_ORDER_LINK_REMARK','Anmerkung');
define('FS_VIEW_INVOICE_BUBBLE','Wenden Sie sich bitte an Ihre Vertriebsmitarbeiterin für die aktualisierte Rechnung dieser Bestellung.');

define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00am - 5:00pm ");
define("FS_SHIPPING_SG_GRAB_TIPS","Dieser Service ist für Bestellungen verfügbar, die ab dem SG-Lager versendet und vor 15:00 Uhr bezahlt werden.");
define("FS_TIME_ZONE_ADDRESS_SG","<span>Lager in Singapur:</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");

define('FS_SG_VAT_NUMBER',"GST-Registrierungsnummer");
//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','Ihr Angebot per E-Mail senden');
define("FS_INQUIRY_REVIEWING_1",'Eingereicht');
define("FS_INQUIRY_QUOTED_1",'Genehmigt');
define('FS_QUOTE_INFO_1','Angebotsdetails');
define("FS_INQUIRY_CANCELED_1",'Abgelaufen');
define('FS_QUOTE_INFO_2','Stückpreis');
define('FS_QUOTE_INFO_3','Zielpreis');
define('FS_QUOTE_INFO_4','Angebotspreis');
define('FS_QUOTE_INFO_5','(Dieser Preis beinhaltet keine Steurn oder Versandkosten.)');
define('FS_QUOTE_INFO_6','Alle');
define('FS_QUOTE_INFO_8','Wählen Sie bitte zuerst einen Artikel.');
define('FS_QUOTE_INFO_9','Vielen Dank. Wir haben Ihr Angebot per E-Mail an Ihre Empfängerliste gesandt.');
define('FS_QUOTE_INFO_10','Zurück zu Angebotsdetails');
define('FS_QUOTE_INFO_11','Angebot wieder anfragen');
define('FS_QUOTE_INFO_12','Schnellangebot');
define('FS_QUOTE_INFO_13','Übersicht (');
define('FS_QUOTE_INFO_14',' Artikel');
define('FS_QUOTE_INFO_15','Zielpreis:');
define('FS_QUOTE_INFO_16','Dieser Preis beinhaltet keine Steurn oder Versandkosten.');
define('FS_QUOTE_INFO_17','Dieses Angebot gilt nur für eine vollständige Produktliste. Wenn Sie nur einige Produkte davon bezahlen, wird der Rabatt ungültig.');
define('FS_QUOTE_INFO_18','Dieses Angebot basiert auf der Menge jedes Produkts. Wenn Sie die Anzahl der Produkte reduzieren, die Sie bezahlen, wird der Rabatt für die ausgewählte Produkte ungültig.');
define('FS_SEND_EMAIL_2019_1',"wir haben Ihre Angebotsanfrage ");
define('FS_SEND_EMAIL_2019_2'," erhalten, Ihr Account Manager wird Ihnen innerhalb von 30 Minuten ein Angebot machen. Sehen Sie es bitte später in ");
define('FS_SEND_EMAIL_2019_3',"Meine Angebote");
define('FS_SEND_EMAIL_2019_4'," nach.");
define('FS_SEND_EMAIL_2019_5',"Ihr Kunde ");
define('FS_SEND_EMAIL_2019_6',"Angebotsnummer");
define('FS_SEND_EMAIL_2019_7',"Artikel");
define('FS_SEND_EMAIL_2019_8',"Menge: ");
define('FS_SEND_EMAIL_2019_9',"Artikel");
define('FS_SEND_EMAIL_2019_10',"Menge");
define('FS_SEND_EMAIL_2019_11',"Zielpreis");
define('FS_SEND_EMAIL_2019_12',"Stückpreis");
define('FS_SEND_EMAIL_2019_13',"Zwischensumme:");
define('FS_SEND_EMAIL_2019_14',"Ziel:");
define('FS_SEND_EMAIL_2019_15',"Angebot machen");
define('FS_QUOTE_INFO_19','Datum');
define("FS_INQUIRY_INFO_65_1","Dieses Angebot ist nur 15 Tage gültig und läuft am XX ab.");
define("FS_INQUIRY_INFO_65_2",", läuft am XX ab");
define("FS_INQUIRY_INFO_65_3","Gesamtsumme");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01','Bitte schließen Sie die Zahlung innerhalb von ');
define('FS_ORDERS_OVERTIMES_02',' ab');
define('FS_ORDERS_OVERTIMES_03',' ab');
define('FS_ORDERS_OVERTIMES_02_PO',' hoch');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO',' hoch');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04',' Ihre Bestellung wird andernfalls automatisch storniert.');
define('FS_ORDERS_OVERTIMES_05','Laden Sie bitte die Auftragsdatei innerhalb von ');
define('FS_ORDERS_OVERTIMES_06','Hinweis: Wenn Sie bei der Überweisung die FS-Bestellnummer angeben, wird Ihre Bestellung rechtzeitig bearbeitet. In der Regel erhalten wir den Betrag innerhalb von 1-3 Werktagen.');
define('FS_ORDERS_OVERTIMES_07','Ihre Bestellung muss aus folgendem Grund überprüft werden:');
define('FS_ORDERS_OVERTIMES_08','Die Lieferadresse stimmt nicht mit den Adressen auf Ihrem Kreditantragsformular überein');
define('FS_ORDERS_OVERTIMES_09','Ihr verfügbares Guthaben wurde ebenfalls überschritten');
define('FS_ORDERS_OVERTIMES_10','Bitte zahlen Sie die vorherigen Bestellungen aus, um das Guthaben wiederherzustellen. Oder Sie können eine Erhöhung des Kreditlimits auf der Seite „Mein Kredit" beantragen. Wir werden die Bestellung prüfen und Ihnen das Ergebnis per E-Mail zusenden.');
define('FS_ORDERS_OVERTIMES_11','Wir werden die Bestellung prüfen und Ihnen das Ergebnis innerhalb von 12 Stunden per E-Mail zusenden.');
define('FS_ORDERS_OVERTIMES_12','Um diese Bestellung rechtzeitig zu bearbeiten, zahlen Sie bitte die vorherigen Bestellungen aus, um das Guthaben wiederzugewinnen. Oder Sie können eine Erhöhung des Kreditlimits auf der Seite „Mein Kredit" beantragen.');
define('FS_ORDERS_OVERTIMES_13','Endet in');
define('FS_ORDERS_OVERTIMES_14',' T.'); //天  这三个是英文的 day  hour minute 首字母缩写
define('FS_ORDERS_OVERTIMES_15',' Std.'); //时
define('FS_ORDERS_OVERTIMES_16',' Min.'); //分
define('FS_ORDERS_OVERTIMES_17','Entschuldigung, Ihre Bestellung wurde geschlossen, da die Zahlungsfrist abgelaufen ist.');
define('FS_ORDERS_OVERTIMES_18','Sie finden es in „Meine Bestellungen" und klicken auf „Wieder kaufen", um eine weitere Bestellung aufzugeben.');
define('FS_ORDERS_OVERTIMES_19','Mit der Bestellung ist etwas schiefgelaufen......');
define('FS_ORDERS_OVERTIMES_20','Wir haben Ihre Überweisung von'); //后边跟支付方式,加一个空格以隔开
define('FS_ORDERS_OVERTIMES_21','erhalten! Die Bestellung wurde jedoch geschlossen, da die Zahlungsfrist (angezeigt bei ausstehenden FS-Bestellungen) abgelaufen ist. Bitte wenden Sie sich an Ihre Vertriebsmitarbeiterin, um die Bestellung wiederherzustellen. Bitte entschuldigen Sie die Unannehmlichkeiten.');
define('FS_ORDERS_OVERTIMES_22','In Ihrem Kreditkonto gibt es überfällige Bestellungen. Bitte zahlen Sie die vorherigen Bestellungen aus. Oder Ihre Vertriebsmitarbeiterin wird sich mit Ihnen in Verbindung setzen und zusätzliche Dokumente zur Überprüfung anfordern.');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36', 'FS - Zahlungserinnerung ');
define('FS_ORDERS_OVERTIMES_23', 'Zahlungserinnerung');
define('FS_ORDERS_OVERTIMES_24', 'Vielen Dank, dass Sie sich für FS entschieden haben. Ihre Bestellung <b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25', '<b style="font-weight: 600;">Hinweis</b>: Wenn Sie die Bestellung bezahlt haben, ignorieren Sie bitte diese E-Mail. Wir werden Ihre Bestellung bald bearbeiten. Wenn Sie diese Bestellung nicht mehr benötigen, ignorieren Sie diese E-Mail. Die Bestellung wird später vom System automatisch storniert, wenn sie nicht bezahlt wird.');
define('FS_ORDERS_OVERTIMES_26', 'Wir wünschen Ihnen einen schönen Tag!');
define('FS_ORDERS_OVERTIMES_27', '</b>  ist noch nicht bezahlt. Wir möchten Sie daran erinnern, dass die Bestellung in ');
define('FS_ORDERS_OVERTIMES_28', ' automatisch storniert wird. Klicken Sie <a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29', '">hier</a>, um den Kauf abzuschließen.');


//by rebirth 2019.10.18 新版上传提示 德语
define("FS_UPLOAD_NEW_NOTICE_ONE","Fügen Sie bitte eine PDF-, JPG-, PNG-, DOC-, DOCX-, XLS-, XLSX- oder TXT-Datei hinzu.");
define("FS_UPLOAD_NEW_NOTICE_TWO","Fügen Sie bitte eine JPG-, GIF-, PNG-, JPEG-, oder BMP-Datei hinzu.");
define("FS_UPLOAD_NEW_NOTICE_THREE","Dateigröße bis zu 5M.");
define("FS_UPLOAD_NEW_NOTICE_FOUR","Dateigröße bis zu 300KB.");
define("FS_UPLOAD_NEW_ERROR_1","Die hochgeladene Datei ist unzulässig!"); //该文件不允许上传
define("FS_UPLOAD_NEW_ERROR_2","Die Datei existiert bereits!");  //文件已存在
define("FS_UPLOAD_NEW_ERROR_3","Das Hochladen auf den Cloud-Server ist fehlgeschlagen."); //文件上传云服务器失败
define('FS_UPLOAD_NEW_ERROR_4', 'Datei ist zu groß!');//文件大小超过php.ini的限制

define('FS_SHOP_CART_SG_INSTALL','Kostenlose Installation für Artikel im SG-Lager. Sie können nach der Zahlung mehr erfahren.');

define('FS_CHECKOUT_SGINSTALL_CC','Sie haben den Installationsservice ausgewählt. Stellen Sie bitte sicher, dass die Zahlung vor der geplanten Installationszeit abgeschlossen ist, andernfalls kann sich der Service verzögern.');
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','FS bietet kostenlosen Installationsservice für alle Produkte auf Lager an. Sie können den Service an der Kasse auswählen.');
define('FS_SG_DELIVERY_RETURN','Kostenlose Installation');

define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','Sie haben den Installationsservice ausgewählt. Wenn die Bestellung versandbereit ist, wird unser technischer Spezialist Sie vor der Abfahrt kontaktieren.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','Sie haben den Installationsservice ausgewählt. Stellen Sie bitte sicher, dass die Zahlung vor der geplanten Installationszeit abgeschlossen ist, andernfalls kann sich der Service verzögern.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','Sie haben den Installationsservice ausgewählt. Stellen Sie bitte sicher, dass die PO-Datei vor der geplanten Installationszeit hochgeladen ist, andernfalls kann sich der Service verzögern.');

define('FS_SG_CALENDAR_1',"Zeitraum für Installation auswählen");
define('FS_SG_CALENDAR_2',"Verfügbare Installationszeit anzeigen");
define('FS_SG_CALENDAR_3',"Wählen Sie bitte FS-Lieferung & Installation aus.");
define('FS_SG_CALENDAR_4',"Wählen Sie bitte die gewünschte Installationszeit aus.");
define("FS_SG_CALENDAR_5","Vor-Ort-Installation");
define("FS_SG_CALENDAR_6",'Lieferänderung');
define("FS_SG_CALENDAR_7","Sie haben alle Installationsanforderungen storniert. Wir arrangieren die Packtzustellung für Sie.");
define("FS_SG_CALENDAR_8","stornieren");
define("FS_SG_CALENDAR_9","Ja, bitte");
define("FS_SG_CALENDAR_10",'Nur ausgewählte Artikel werden nach der Lieferung installiert.');
define("FS_SG_CALENDAR_11",'* Der Installationsservice ist derzeit für Artikel verfügbar, die ab dem SG-Lager ausgeliefert werden. Bitte entschuldigen Sie die Unannehmlichkeiten.');
//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","Installation anfordern");
define("FS_SG_CALENDAR_101","Servicetyp auswählen");
define("FS_SG_CALENDAR_102","Wählen Sie bitte");
define("FS_SG_CALENDAR_103","Projektunterstützung");
define("FS_SG_CALENDAR_104","Fehlersuche und Reparatur");
define("FS_SG_CALENDAR_105","Wählen Sie bitte den Servicetyp aus.");
define("FS_SG_CALENDAR_106","Geben Sie die Anforderungsdetails ein*");
define("FS_SG_CALENDAR_107","Beschreiben Sie bitte Ihre Anforderungen.");
define("FS_SG_CALENDAR_108","Es enthält hier mindestens 4 schriftzeichen.");
define("FS_SG_CALENDAR_109","Es enthält hier höchstens 500 schriftzeichen.");
define("FS_SG_CALENDAR_110","Installationsanforderung");
define("FS_SG_CALENDAR_111","Servicetyp");
define("FS_SG_CALENDAR_112","Installationstermin");
define("FS_SG_CALENDAR_113","Anforderungsdetails");
define("FS_SG_CALENDAR_114","Installationstermin");
define("FS_SG_CALENDAR_115","Wir haben Ihre Installationsanforderung erhalten.");
define("FS_SG_CALENDAR_116","Unser technischer Spezialist wird Sie vor der Abfahrt kontaktieren.");

define('FS_FESTIVAL16','Feiertag in Singapur am');
define('FS_FESTIVAL17',' im SG-Lager.');


//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","Vielen Dank, dass Sie sich für FS Singapur entschieden haben. Wir haben Ihre ausstehende Bestellung ");
define("FS_SG_EMAIL_1","Nach der Zahlung erhalten Sie erneut unsere Nachricht, sobald die kostenlose Installation der Bestellung geplant ist.");
define("FS_SG_EMAIL_2","Einige Produkte können konstenlos installiert wernden. Sie können bei Bedarf <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">Installationsservice anfordern</a>. Nach der Zahlung erhalten Sie erneut unsere Nachricht.");
define("FS_SG_EMAIL_3","Sie haben den Installationsservice Ihre Bestellung ");
define("FS_SG_EMAIL_4"," ausgewählt. Wir werden Sie kontaktieren, wenn unser technischer Spezialist zu Ihrer Lieferadresse abfährt.");
define("FS_SG_EMAIL_5","Melden Sie sich bitte bei Ihrem Konto an und verfolgen Sie den Bestellstatus in ");
define("FS_SG_EMAIL_6","Die Details Ihrer Bestellung ");
define("FS_SG_EMAIL_7","sind wie unten. Wir senden Ihnen eine E-Mail, sobald Ihre Bestellung aktualisiert wird.");
define("FS_SG_EMAIL_8","Sie können den Bestellstatus verfolgen, indem Sie sich bei Ihrem Konto anmelden und in");
define("FS_SG_EMAIL_9"," Bitte beachten Sie, dass Sie bei dieser Bestellung einen kostenlosen Installationsservice haben können. Sie können sich <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">hier</a> etwas Zeit nehmen.");
define("FS_SG_EMAIL_10","Ihre Bestellung ");
define("FS_SG_EMAIL_11"," ist einbaufertig. Unser technischer Spezialist wird rechtzeitig zu Ihrer Adresse abfahren.");
define("FS_SG_EMAIL_12","Bei Änderungen kontaktieren Sie uns bitte unter <a style=\"color: #0070bc;text-decoration: none\" href=\"tel:+(65) 6443 7951\">+(65) 6443 7951</a> oder senden Sie ein E-mail an <a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>.");
define("FS_SG_EMAIL_13","Mit freundlichen Grüßen");
define("FS_SG_EMAIL_14","FS-Team");
define("FS_SG_EMAIL_15","Kontaktinfo:");
define("FS_SG_EMAIL_16","Telefonnummer:");
define("FS_SG_EMAIL_17","Adresse:");
define("FS_SG_EMAIL_18","Installationstermin:");
define("FS_SG_EMAIL_19","Zahlungserinnerung der FS-Bestellung ");
define("FS_SG_EMAIL_20","");
define("FS_SG_EMAIL_21","Vielen Dank, dass Sie sich für FS Singapur entschieden haben. Sie haben die Bestellung");
define("FS_SG_EMAIL_22"," mit Vor-Ort-Installationsservice noch nicht bezahlt. Wir möchten Sie daran erinnern, dass der Service storniert wurde.");
define("FS_SG_EMAIL_23","Klicken Sie einfach <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">hier</a>, um den Kauf abzuschließen. Und Sie können in Mein Konto erneut eine geeignete Zeit für den Installationsservice auswählen.");
define("FS_SG_EMAIL_24","Ihre Bestellung FS #");
define("FS_SG_EMAIL_25"," wurde versandt");
define("FS_SG_EMAIL_26","Installationserinnerung");
define("FS_SG_EMAIL_27","Installation Storniert");
define("FS_SG_EMAIL_28","Zahlungserinnerung");

define('FS_SHIPPING_SG_INSTALL_TIPS','Für diese Lieferung können Sie die bevorzugte Installationszeit auswählen. Installationsservices sind nur mit FS Lieferung & Kostenlose Installation.');

define('FS_SG_DELIVERY_INSTALLATION', 'FS Lieferung & Kostenlose Installation');
define('FS_SG_NEXT_WORKING_DAY', 'FS Lieferung am nächsten Werktag');
define('FS_SG_SAME_WORKING_DAY', 'FS Lieferung am gleichen Werktag');
define('FS_ACCOUNT_DETELE','Das Konto wurde aufgelöst.');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 Werktage');

define('FS_ORDERS_OVERTIMES_30','Minute');
define('FS_ORDERS_OVERTIMES_31','Minuten');
define('FS_ORDERS_OVERTIMES_32','Werktag');
define('FS_ORDERS_OVERTIMES_33','Werktagen');
define('FS_ORDERS_OVERTIMES_34','');
define('FS_ORDERS_OVERTIMES_35','');

define('FS_COMMON_YES',"Ja");
define('FS_COMMON_NO',"Nein");

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'Support-Typ');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', 'Produktnutzung');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'Verbindungskonnektivität');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'Installation & Konfiguration');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'Andere');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","Einkaufserlebnis mitteilen");
define("EMAIL_MESSAGE_01","Wie ist Ihr Einkaufserlebnis?");
define("EMAIL_MESSAGE_02","Bestellung bewerten");
define('EMAIL_MESSAGE_CONTENT', 'Würden Sie sich bitte eine Minute Zeit nehmen, um die Produkte von der Bestellung <a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a> zu bewerten? Dies wird uns und anderen Kunden sehr helfen. Klicken Sie auf die Schaltfläche unten, um Ihren Bewertung zu hinterlassen!');
define('EMAIL_MESSAGE_SUBTITLE', 'Haben Sie Fragen zu Ihrer Bestellung?');
define('EMAIL_MESSAGE_SUB_CONTENT', 'Alle Ihre Fragen zu technischem Support, Produktgarantie, Lieferung usw. können im <a style="color: #0070bc;text-decoration: none;" href="javascript:;">Hilfecenter</a> schnell und effizient beantwortet werden.');
define('EMAIL_TO_LICENSE_5','Mehr anzeigen');
define('EMAIL_TO_LICENSE_6','Bewerten Sie Ihre Bestellung bei FS');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'Vielen Dank für Ihre Unterstützung');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'Vielen Dank, dass Sie Ihr Einkaufserlebnis bei Trustpilot geteilt haben. Bitte nehmen Sie sich einen Moment Zeit, um FS zu bewerten.');
define('EMAIL_REVIEWS_FOUR_FIVE_03', 'Bewerten');
define('EMAIL_REVIEWS_FOUR_FIVE_04', 'Ihre Bewertung, ob diese gut oder schlecht ist, wird sofort auf Trustpilot.com veröffentlicht, um anderen Personen bei Entscheidungen zu helfen.');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'Vielen Dank für Ihre Zeit. Wir freuen uns auf ein Wiedersehen!<br>FS Team.');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'FS bewerten');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'Ihre Bewertung ist wichtig - Erlebnis mitteilen');


//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Technischer Support');
define('FS_REQUEST_SUPPORT','Support anfragen');

// manage address
define("FS_CREATE_NEW_ADDRESS", 'Adresse hinzufügen');
define("FS_DEFAULT", 'Standardadresse');
define("FS_SAVE_ADDRESSES", 'Gespeicherte Adresse');
define("FS_EDIT_REMOVE", 'Optionen');
define("FS_EDIT", 'Bearbeiten');
define("FS_REMOVE", 'Entfernen');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", 'Sie haben noch keine Lieferadresse gespeichert.');
define("FS_NO_BILLING_ADDRESS_HISTORY", 'Sie haben noch keine Rechnungsadresse gespeichert.');
//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'Meine Angebote');
define("FS_INQUIRY_LIST_2",'Gültige Angebote');
define("FS_INQUIRY_LIST_3",'Kundenservice kontaktieren');
define("FS_INQUIRY_LIST_4",'Angebot suchen:');
define("FS_INQUIRY_LIST_5",'Angebotsnummer');
define("FS_INQUIRY_LIST_6",'Suchen');
define("FS_INQUIRY_LIST_7",'Anfragedatum:');
define("FS_INQUIRY_LIST_8",'Zwischensumme');
define("FS_INQUIRY_LIST_9",'Menge:');
define("FS_INQUIRY_LIST_10",'Mehr');
define("FS_INQUIRY_LIST_11",'Das Angebot gilt bis zum ');
define("FS_INQUIRY_LIST_12",'Das Angebot ist am XX abgelaufen.');
define("FS_INQUIRY_LIST_13",'Kein Ergebnis');
define("FS_INQUIRY_LIST_14",'Jetzt kaufen');
define("FS_INQUIRY_LIST_15",'Wenn Sie Ihr Angebot nicht finden können, probieren Sie bitte, andere Zeitraum zu wählen.');
define("FS_INQUIRY_LIST_16",'Anfragedetails');
define("FS_INQUIRY_LIST_17",'Benennung:');
define("FS_INQUIRY_LIST_18",'Erneut anfragen');
define("FS_INQUIRY_LIST_19",'In den Warenkorb');
define("FS_INQUIRY_LIST_20",'Angebot drucken');
define("FS_INQUIRY_LIST_21",'ANGEBOTSANFRAGE');
define("FS_INQUIRY_LIST_22",'Produkt');
define("FS_INQUIRY_LIST_23",'Stückpreis');
define("FS_INQUIRY_LIST_24",'Menge');
define("FS_INQUIRY_LIST_25",'Zielpreis');
define("FS_INQUIRY_LIST_26",'Kunden-ID:');
define("FS_INQUIRY_LIST_28",'Kontaktnummer:');
define("FS_INQUIRY_LIST_29",'Gesamtsumme:');
define("FS_INQUIRY_LIST_30",'Im Folgenden ist die eingereichte Angebotsanfrage. Ihr Account Manager wird Ihnen innerhalb von 24 Stunden antworten.');
define("FS_INQUIRY_LIST_30_1",'Das Angebot wird zurzeit geprüft. Ihr Account Manager wird Ihnen innerhalb von 24 Stunden antworten.');
define("FS_INQUIRY_LIST_31",'Das Anfrage wird zurzeit geprüft. Ihr Account Manager wird Ihnen innerhalb von 24 Stunden antworten.');
define("FS_INQUIRY_LIST_32",'Im Folgenden sind die Angebotsdetails. Dieses Angebot gilt bis zum XX.');
define("FS_INQUIRY_LIST_33",'Dieses Angebot ist am ');
define("FS_INQUIRY_LIST_34",'abgelaufen. Sie können es bei Bedarf erneut anfragen.');

define("FS_INQUIRY_LIST_35",'Angebotsnummer');
define("FS_INQUIRY_LIST_36",'Anfragedatum:');
define("FS_INQUIRY_LIST_37",'Angebotsnummer:');
define("FS_INQUIRY_LIST_38",'Produkt-ID: ');
define("FS_INQUIRY_LIST_38_1",'Produkt-ID: ');
define("FS_INQUIRY_LIST_39",'Nachfolgend ist das von Ihnen angefragte Angebot..');
define("FS_INQUIRY_LIST_40",'REFRENZ');
define("FS_INQUIRY_LIST_41",'Diese Seite drucken');
define("FS_INQUIRY_LIST_42",'Angebotsdatum:');

//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', 'Dies ist ein maßgeschneidertes Produkt. Treffen Sie bitte auf der Produktdetailseite Ihre Auswahl.');
define('FS_MANAGE_CLOSE_TIP', 'Dieses Produkt ist nicht mehr online verfügbar. Sie können Ihren Account Manager kontaktieren oder das ähnliche Produkt sehen.');

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','Zahlungsbedingung');
define('FS_NEW_ACCOUNT_MY_CREDIT_02',' Tage');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','Verwendetes kreditlimit');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','Gesamtkreditlimit');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','Kreditlimit ändern');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','Bestellung suchen');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','Bestell-, Auftrags-Nr.');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','Datum');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','Kein Ergebnis');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','Jetzt kaufen');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','Kein Ergebnis.');
define('FS_NEW_ACCOUNT_MY_CREDIT_12', 'Suchen');

// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",'Kontoinformationen');
define("FS_ACCOUNT_NEW",'Kontonummer:');
define("FS_NAME",'Name');
define("FS_ACCOUNT_MANAGE_CONTACT",'Account Manager');
define("FS_ACCOUNT_PHONE",'Telefon:');
define("FS_ACCOUNT_ORDERS_PENDING",'Ausstehende Bestellungen');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'Bearbeitet');
define("FS_ACCOUNT_ORDERS_COMPLETED",'Abgeschlossen');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'Gültige Angebote');
define("FS_ACCOUNT_ORDERS_RMA",'Zurückgesandte Artikel');
define("FS_ACCOUNT_ORDERS",'Bestellungen');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'Bestellungen ansehen und verfolgen');
define("FS_ACCOUNT_HISTORY",'Meine Bestellungen');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'Angebot anfragen');
define("FS_ACCOUNT_QUOTE_STATUS",'Meine Angebote');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'RMA anfordern');
define("FS_ACCOUNT_RMA_STATUS",'Zurückgesandte Artikel');
define("FS_ACCOUNT_REVIEW_PURCHASES",'Bestellungen bewerten');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'Bestellungen nachsehen und Status verfolgen');
define("FS_ACCOUNT_VIEW_ORDERS",'Bestellungen anzeigen');
define("FS_ACCOUNT_SEARCH_ORDERS",'Bestellung suchen:');
define("FS_ACCOUNT_PO_ORDER_ID",'Bestell-, Auftragsnummer, Produkt-ID');
define("FS_ACCOUNT_SEARCH",'Suchen');
define("FS_ACCOUNT_NET_TERMS",'Kreditkonto');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'Jetzt kaufen, später zahlen');
define("FS_ACCOUNT_CURRENT_BALANCE",'Verwendetes kreditlimit:');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'Details anzeigen');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'Kontoeinstellungen');
define("FS_ACCOUNT_PASSWORD_MAIL",'Passwort und E-Mail');
define("FS_ACCOUNT_USER_PHOTO",'Benutzerbild');
define("FS_ACCOUNT_USER_NAME",'Benutzername');
define("FS_ACCOUNT_EMAIL_ADDRESS",' E-Mail-Adresse');
define("FS_ACCOUNT_EMAIL_PASSWORD",'Passwort');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'E-Mail-Abonnement');
define("FS_ACCOUNT_SHOPPING_TOOLS",'HILFSMITTELN');
define("FS_ACCOUNT_USEFUL_SHOPPING",'Support und Feedback');
define("FS_ACCOUNT_REQUEST_SAMPLE",'Probe anfordern');
define("FS_ACCOUNT_WRITE_REVIEW",'Feedback');
define("FS_ACCOUNT_USER_INFORMATION",'Informationen');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'Fragen und Antworten');
define("FS_ACCOUNT_ADDRESS_BOOK",'Adressbuch');
define("FS_ACCOUNT_CASE_CENTER",'Meine Anfragen');
define("FS_ACCOUNT_CASE_E_MAIL",'E-Mail:');
define("FS_CREATE_SHIPPING_ADDRESS",'Lieferadresse hinzufügen');
define("FS_CREATE_BILLING_ADDRESS",'Rechnungsadresse hinzufügen');
define("FS_EDIT_SHIPPING_ADDRESS",'Lieferadresse bearbeiten');
define("FS_EDIT_BILLING_ADDRESS",'Rechnungsadresse bearbeiten');
define("FS_CONFIRMATION",'Adresse entfernen');
define("FS_DELETE_THIS_ADDRESS",'Möchten Sie diese Adresse entfernen?');
define("FS_SAVED_ADDRESSES",'Gespeicherte Adresse');
define("FS_SAVE_AS_DEFAULT",'Standardadresse');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click "<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');


define('FS_SALES_INFO_MODAL_TITLE','Neue Adresse hinzufügen');
define('FS_SALES_INFO_MODAL_FNAME','Vorname');
define('FS_SALES_INFO_MODAL_LNAME','Nachname');
define('FS_SALES_INFO_MODAL_COUNTRY','Land/Region');
define('FS_SALES_INFO_MODAL_ADS_TYPE','Adresstyp');
define('FS_SALES_INFO_MODAL_COMPANT','Name der Firma');
define('FS_SALES_INFO_MODAL_VAT','Mehrwertsteuer/Steuernummer');
define('FS_SALES_INFO_MODAL_ADS1','Adresse');
define('FS_SALES_INFO_MODAL_ADS2','Adresse 2');
define('FS_SALES_INFO_MODAL_CITY','Stadt');
define('FS_SALES_INFO_MODAL_SPR','Land/Provinz/Region');
define('FS_SALES_INFO_MODAL_STATE','Bitte Bundesland ausw?hlen');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','Postleitzahl');
define('FS_SALES_INFO_MODAL_PHONE_NUM','Telefonnummer');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','Stornieren');
define('FS_SALES_INFO_MODAL_BTN_SAVE','Speichern');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','Straße, Hausnummer');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','Etage, Zimmernummer usw.');

define('FS_SALES_DETILS_TYPE1','Rückgabe');
define('FS_SALES_DETILS_TYPE2','Umtausch');
define('FS_SALES_DETILS_TYPE3','Reparatur');
define('FS_RMA_NAVI1','RMA bestätigen');
define('FS_RMA_NAVI2','Zurückgesandte Artikel');
define('FS_RMA_NAVI3','RMA-Details');
define('FS_RMA_NAVI4','RMA');
define('FS_RMA_NAVI5','RMA anfordern');
define('FS_RMA_DETAILS_NAVI1','Rückgabe- & Rückerstattungsdetails');
define('FS_RMA_DETAILS_NAVI2','Umtauschdetails');
define('FS_RMA_DETAILS_NAVI3','Reparaturdetails');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', 'Überweisen Sie den Betrag bitte auf das folgende Konto.');

define('FS_RMA_SEARCH_TIPS','Alle Antrage');

define("FS_CONFIRMATION",'Adresse entfernen');
define("FS_DELETE_THIS_ADDRESS",'Durch das Entfernen werden keine ausstehenden Bestellungen an diese Adresse storniert.');
define("FS_SAVED_ADDRESSES",'Gespeicherte Adresse');
define("FS_SAVE_AS_DEFAULT",'Standardadresse');
define("FS_ACCOUNT_REQUEST_A_SAMPLE",'Produktproben anfordern');
define("FS_ACCOUNT_USEFUL_TOOLS",'Hilfe');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Support und Feedback');
define("FS_ACCOUNT_CANCEL",'Bestätigen');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'Lieferadresse');
define("FS_ACCOUNT_BILLING_ADDRESS",'Rechnungsadresse');
define('ACCOUNT_MY_HOME','Startseite');
define("FS_REVIEW_PURCHASE_10",'Bestellnummer, Produkt-ID');

//add by liang.zhu 2019.11.23

define('FS_EMAIL_POLICY',"Datenschutz");

define('FS_INDEX_FPE_TITLE','Unsere Top Produkte');
define('FS_INDEX_ETN_TITLE','Erfahren Sie mehr über unsere Lösungen');
define('FS_INDEX_SERVICE_TITLE','Service');
define('FS_ACCOUNT_TITLE','Bestellstatus');
define('FS_ACCOUNT_BTN','Bestellungen anzeigen');
define('FS_ACCOUNT_CONTENT','Verfolgen Sie Ihre Bestellung, um den neuesten Paketstatus und den voraussichtlichen Liefertermin zu erhalten.');
define('FS_ACCOUNT_TITLE_REGISTER','Konto eröffnen');

define('FIBER_SPARKASSE_BANK_NAME','Name der Bank:');


//订单详情
define('FS_PRINT_QTY','Menge');
define('FS_PRINT_UNIT_PRICE','Stückpreis');
define('FS_PRINT_TOTAL','Gesamt');
define('FS_PRINT_SHIPMENT','Versand');
define('FS_PRINT_SUBTOTAL','Zwischensumme:');
define('FS_PRINT_SHIPPING_COST','Versandkosten:');
define('FS_PRINT_SHIPPING_TAX','MwSt.:');
define('FS_PRINT_TOTAL_WIDTH_COLON','Gesamtsumme:');
define('FS_PRINT_ITEM','Artikel');

//税后价公用语言包 add dylan 2020.5.13
define('FS_BLANKET_32','Versandkosten');
define('FS_BLANKET_33','Gesamt-GST');
define('FS_BLANKET_34','Gesamtsumme');
define('FS_BLANKET_35','Inkl. GST');

define('ACCOUNT_EDIT_CITY_FROMAT_TIP','Der Stadtname muss mindestens 2 Zeichen lang sein.');
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP','Der Adresszusatz muss mindestens 2 Zeichen lang sein.');

//报价相关
define('INQUIRY_QUOTE_LIST_1','Angebot anzeigen');
define('INQUIRY_QUOTE_LIST_2','Meine Angebote');

define('FS_CHECKOUT_ERROR_VAT','Bitte geben Sie eine gültige USt-IdNr. ein. z.B.: $VAT');
define('FS_CHECKOUT_POPUP_TIPS','Möchten Sie zu Ihrem Warenkorb zurückkehren? ');
define('FS_CHECKOUT_POPUP_TIPS_QUOTE','Möchten Sie zu „Meine Angebote“ zurückkehren?');
define('FS_CHECKOUT_POPUP_BUTTON1','Stornieren');
define('FS_CHECKOUT_POPUP_BUTTON2','Bestätigen');
define('FS_CHECKOUT_PAYMENT','Zahlung');
define('FS_CHECKOUT_PAYMENT_PO','Auftragsdatei hochladen');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','Maßgeschneidert');
define('FS_ORDER_MANUFACTURING','Hergestellt');
define('FS_ORDER_TEST_PASS','Test bestanden');
define('FS_ORDER_SHIPPED','Versandt');
define('FS_ORDER_TEST_REPORT','Testbericht');

define('FS_PRODUCTS_INFO_NOTE_TITLE','Hinweis: ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','Der kohärente CFP-Transceiver kann nicht separat verkauft werden.');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','Ihr Kreditkonto befindet sich in einem Status „Ausgesetzt“ und Sie können zurzeit nicht auf Rechnung zahlen. Begleichen Sie bitte auf der Seite „<a href="'.zen_href_link('manage_orders','','SSL').'">Meine Bestellungen</a>“ die unbezahlte Rechnungen oder wählen Sie andere Zahlungsarten.');
define('FS_PO_FORZEN_NOTICE_02','Ihr Kreditkonto befindet sich in einem Status „Ausgesetzt“. Klicken Sie auf „Details anzeigen“ unten, um mehr Informationen zu finden.');

define('FS_PO_FORZEN_NOTICE_03','Ihr Kreditkonto befindet sich in einem Status „Ausgesetzt“. Begleichen Sie bitte auf der Seite „<a href="'.zen_href_link('manage_orders','','SSL').'">Meine Bestellungen</a>“ die unbezahlte Rechnungen oder kontaktieren Sie Ihren Account Manager für mehr Informationen.');


define("FS_ACCOUNT_RMA_ORDERS",'RMA-Anträge');
define("FS_ACCOUNT_PO_NUMBER",'Auftragsnummer: ');
define("FS_ACCOUNT_REQUEST_RMA",'RMA beantragen');
define("FS_ACCOUNT_RMA_HISTORY",'Zurückgesandte Artikel');
define("FS_ACCOUNT_PO_ORDER",'Beschaffungsaufträge');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'Bestellung bewerten');
define("FS_ACCOUNT_QUOTES",'Angebote');
define("FS_ACCOUNT_QUICK_QUOTE",'Angebote ansehen und anfragen');
define("FS_ACCOUNT_ACTIVE",'Gültige Angebote');
define("FS_ACCOUNT_QUOTE_HISTORY",'Meine Angebote');
define("FS_ACCOUNT_REQUEST_QUOTE",'Angebot anfragen');
define("FS_ACCOUNT_ORDER_PENDING",'Ausstehende Bestellungen');
define("FS_ACCOUNT_ORDER_PROGRESSING",'Bearbeitete Bestellungen');
define("FS_ACCOUNT_ORDER_COMMENTS",'Hinzugefügte Anmerkung:');

//support
define("SUPPORT_PAGE","FS hilft Ihnen weiter");
define("SUPPORT_PAGE_1","Sofortige Unterstützung");
define("SUPPORT_PAGE_2","Live-Chat");
define("SUPPORT_PAGE_3","Downloads");
define("SUPPORT_PAGE_4","Mehr erfahren");
define("SUPPORT_PAGE_4_1","Angebot anfragen");
define("SUPPORT_PAGE_5","Tech-Support anfragen");
define("SUPPORT_PAGE_6","Angebot anfragen");
define("SUPPORT_PAGE_7","Case Studies");
define("SUPPORT_PAGE_8","Supportvideos");
define("SUPPORT_PAGE_9","Community");
define("SUPPORT_PAGE_10","Andere Support-Ressourcen");
define("SUPPORT_PAGE_11","Rückgaberecht");
define("SUPPORT_PAGE_12","Paket verfolgen");
define("SUPPORT_PAGE_13","Produktprobe anfordern");
define("SUPPORT_PAGE_14","Hilfecenter");
define('FS_SUPPORT','Support');

define('FS_SEND_EMAIL_PAYMENT',"Zahlung-Link");
define('FS_BY_CLICKING','Durch Klicken auf „Bestellung bestätigen“ stimmen Sie unseren');
define('FS_TERMS_AND_CONDITIONS','AGBs');
define('FS_CHECKOUT_AND',', der ');
// Durch Klicken auf „Bestellung bestätigen“ stimmen Sie unseren AGBs, der Datenschutzerklärung und dem Wiederrufsrecht zu.
define('FS_PRIVACY_AND_COOKIES','Datenschutzerklärung');
define('FS_AND_RIGHT_OF_WITHDRAWL',' und dem Wiederrufsrecht zu.');

define("FS_ZIP_CODE_EU","PLZ");
define("FS_ADDRESS_EU","Straße und Hausnummer");
define("FS_ADDRESS2_EU","Adresszusatz");
define('ACCOUNT_EDIT_CITY_EU','Ort');

//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','Vielen Dank für Ihren Besuch bei FS. Für schnelle Unterstützung finden Sie unter');
define('FS_GIVE_FEEDBACK_TIP_2','FS-Support');//链接
define('FS_GIVE_FEEDBACK_TIP_3','oder kontaktieren Sie uns per');
define('FS_GIVE_FEEDBACK_TIP_4','Live-Chat');//链接
define('FS_GIVE_FEEDBACK_TIP_5','.');
define('FS_FEEDBACK_SELECT_1', 'Design der Webseite');
define('FS_FEEDBACK_SELECT_2', 'Suche und Navigation');
define('FS_FEEDBACK_SELECT_3', 'Produkte');
define('FS_FEEDBACK_SELECT_4', 'Zahlung');
define('FS_FEEDBACK_SELECT_5', 'Versand und Lieferung');
define('FS_FEEDBACK_SELECT_6', 'Rückgabe und Umtausch');
define('FS_FEEDBACK_SELECT_7', 'Service und Support');
define('FS_FEEDBACK_SELECT_8', 'Vorschläge für Webseite');


define('FS_AND',' und dem ');
define('FS_RIGHT_OF_WITHDRAWL','Wiederrufsrecht');
define('FS_RIGHT_OF_WITHDRAWL_01',' zu');
define('FS_CHECKOUT_ERROR3_EU','Dies ist ein Pflichtfeld.');

//报价语言包
define('INQUIRY_LISTS_1','Alle Angebote');
define('INQUIRY_LISTS_2','Gültig');
define('INQUIRY_LISTS_3','Bestellt');
define('INQUIRY_LISTS_4','Das Angebot wurde generiert und erfolgreich bestellt.');
define('INQUIRY_LISTS_5','ANGEBOT');
define('INQUIRY_LISTS_6','Angebotsdetails');
define('FS_INQUIRY_INFO_66_1','Die Angebotsanfrage ist am XX abgelaufen. ');
define('FS_INQUIRY_INFO_66_6','Die Angebotsanfrage ist am XX abgelaufen. ');
define('FS_INQUIRY_INFO_66_2',' Sie können bei Bedarf erneut ein Angebot anfragen.');
define('FS_INQUIRY_INFO_66_3','Dieses Angebot ist am XX abgelaufen. ');
define('FS_INQUIRY_INFO_66_7','Dieses Angebot ist am XX abgelaufen. ');
define('FS_INQUIRY_INFO_66_4','Diese Angebotsanfrage gilt bis zum ');
define("FS_INQUIRY_LIST_27",'Account Manager:');
define('FS_INQUIRY_INFO_66_5','Nach Erhalt des Angebotes von Ihrem Account Manager können Sie direkt die Bestellung bezahlen.');
define('FS_QUOTE','Angebot');
define('INQUIRY_LISTS_7','Alle Zeiträume');
define('INQUIRY_LISTS_8','Meine Angebote');
define('INQUIRY_LISTS_9','Meine Angebote');
define('INQUIRY_LISTS_10','Angebotsanfrage');
define('INQUIRY_LISTS_11','Anfragenummer');
define('INQUIRY_LISTS_12','Ablaufdatum: ');
define('INQUIRY_LISTS_13','Anfrager(in): ');
define('INQUIRY_LISTS_14','Account Manager: ');
define('INQUIRY_LISTS_15','Bestätigen');

// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate for Education & Learning');
define('FS_ERate_03','Server Room');
define('FS_ERate_04','Classroom');
define('FS_ERate_05','Lecture Hall');
define('FS_ERate_06','Laboratory');
define('FS_ERate_07','Contact an EDU specialist today');
define('FS_ERate_08','Mon - Fri, 9:00am-5:00pm EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','E-rate Discounts');
define('FS_ERate_11','Take advantage of E-rate funding to receive discounts on networking equipment. Most public, private, and charter schools & libraries qualify. We proudly serve teachers, principals, and IT support staff by sourcing the best technology solutions for classrooms—at every level of education.');
define('FS_ERate_12','FS SPIN (Form 498 ID): 143051712');
define('FS_ERate_13','Get Started for E-rate');
define('FS_ERate_14','Leave your contact or call us for assistant');
define('FS_ERate_15','Please enter your email address.');
define('FS_ERate_16','Please enter a valid email address.');
define('FS_ERate_17','Thank you. We will get in touch with you ASAP.');
define('FS_ERate_18','10G DWDM Interconnections Over 120km in Campus Network');
define('FS_ERate_19','FS FMU DWDM and FMT series enable good quality transmission over long distance in a simple way.');
define('FS_ERate_20','Read more');
define('FS_ERate_21','Sir/Madam');
define('FS_ERate_22','We\'ve received your E-Rate request and will get in touch with you soon. Here is your case number $CNxxxxxxx, you can refer to this number in all follow-up communications regarding this request.');
define('FS_ERate_23','FS - We received your E-Rate request ');
define('FS_ERate_24','Featured Case');
define('FS_ERate_25','Laboratory');
define('FS_ERate_26','Your Email Address');
define('FS_ERate_27','E-rate for Education ');
define('FS_ERate_28','E-rate Support');
define('FS_ERate_29','Receive discounts with E-rate funding');

define('CART_SHIPPING_METHOD_CHECKOUT_PRE','Versandkosten:');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT','Angezeigt an der Kasse');
define('FS_COMMON_GSP_1','Versand aus FS Asien');
define('FS_COMMON_GSP_2','Importgebühren');
define('FS_COMMON_GSP_3','einschließlich');
define('FS_COMMON_GSP_4','Eingeschlossen sind die Importgebühren zum Zeitpunkt des Kaufs und die von FS abgewickelte Zollabfertigung.');
define('FS_COMMON_5','Schließen');

define("FS_SHOP_CART_LIST_SUB","Zwischensumme");

//详情页定制弹窗文字 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'Maßgeschneidert');
define('FS_DETAIL_CUSTOM_2', 'Hergestellt');
define('FS_DETAIL_CUSTOM_3', 'Versandt');
define('FS_DETAIL_CUSTOM_4', 'Zugestellt');
define('FS_DETAIL_CUSTOM_5', 'Herstellungszeit: ca. ');
define('FS_DETAIL_CUSTOM_6', 'Versandt ca. am: ');
define('FS_DETAIL_CUSTOM_7', 'Zugestellt ca. am: ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Customized');
define('FS_GSP_STOCK_2', 'Transnationales Produkt');
define('FS_GSP_STOCK_3', 'ship from ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Import Fees Deposit');
define('FS_GSP_STOCK_6', 'included');
define('FS_GSP_STOCK_7', 'Der Artikel wird beim <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global-Shipping-Programm (GSP)</a> aus dem Global-Lager in Asien versandt. Die zum Zeitpunkt des Kaufs enthaltenen Importgebühren und Zollabfertigung werden von FS abgewickelt. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Mehr erfahren</a>');
define('FS_GSP_STOCK_8', 'Close');
define('FS_GSP_STOCK_9', 'Der Artikel wird beim <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global-Shipping-Programm (GSP)</a> aus dem Global-Lager in Asien versandt. Die zum Zeitpunkt des Kaufs enthaltenen Importgebühren und Zollabfertigung werden von FS abgewickelt. Die Mehrwertsteuer ist in der Gesamtsumme enthalten. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Mehr erfahren</a>');
define('FS_AVAILABLE', 'erhältlich');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW','Das Produkt wird vom globalen Lager in Asien versandt.');

define('FS_OUTBREAK_NOTICE', 'Wir sind hier, Ihnen zu helfen - Ein Brief von FS über COVID-19');
define('FS_OUTBREAK_NOTICE_M', 'Ein Brief von FS über COVID-19');
define('FS_OUTBREAK_READ_MORE', 'Mehr erfahren');

//Zwischensumme(有税收的带上税收)
define('FS_SHOP_CART_SUBTOTAL','Zwischensumme exkl. MwSt.:');
define('FS_SHOP_CART_EXCL_VAT','MwSt. ($VAT)');
define('FS_SHOP_CART_EXCL_SG_VAT','GST (7%)');
define('FS_SHOP_CART_EXCL_AU_VAT','GST in Australien (10%)');
define('FS_SHOP_CART_EXCL_DE_VAT','MwSt. ($VAT)');

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','Der Liefertermin gilt für Artikel, die auf Lager sind und an Werktagen vor 17:00 Uhr EST gekauft wurden. Danach wird Ihre Bestellung am nächsten Werktag versandt. Wenn die angeforderte Menge den Lagerbestand überschreitet, ein weiteres Paket wird gemäß dem <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global-Shipping-Programm (GSP)</a> aus unserem Lager in Asien versandt.');
define('FS_GSP_COVID_TIPS','Die Lieferung kann sich aufgrund der Auswirkungen von COVID-19 verzögern. Die Tracking-Informationen sind in <a href="'.reset_url('/login.html').'" target="_blank">Mein Konto</a> zu sehen. ');

define('PRODUCTS_WARRANTY','Transceiver');
define('PRODUCTS_WARRANTY_1','');
define('PRODUCTS_WARRANTY_2','Assurance-Programm');
define('PRODUCTS_WARRANTY_3',' für ');
define('PRODUCTS_WARRANTY_4','Versand & Lieferung');
define('PRODUCTS_WARRANTY_5','WARRANTY_YEARS Jahre Garantie');
define('PRODUCTS_WARRANTY_5_1','WARRANTY_YEARS Jahre Garantie');
define('PRODUCTS_WARRANTY_6','Lebenslange Garantie');
define('PRODUCTS_WARRANTY_7','Kostenlose Rücksendung');

//打印发票 VAT No 本地化
define('FS_VAT_NO_EU','USt-IdNr.: ');
define('FS_VAT_NO_AU','ABN: ');
define('FS_VAT_NO_SG','GST-Reg.-Nr.: ');
define('FS_VAT_NO_BR','CNPJ: ');
define('FS_VAT_NO_CL','RUT: ');
define('FS_VAT_NO_AR','CUIT: ');
define('FS_VAT_NO_DEFAULT','Steuernummer: ');

//购物车saved_items、saved_cart_details
define('FS_SAVED_CARTS','Gespeicherte Warenkörbe');
define('FS_ALL_SAVED_CARTS','Alle Zeiträume');
define('FS_ADD_ALL_TO_CARTS','Alle in den Warenkorb');
define('FS_GO','Wählen');
define('FS_SHOW_CART','Zeitraum');
define('FS_SEARCH','Suchen');
define('FS_CART_NAME','Name des Warenkorbs');
define('FS_SEARCH_SAVED_CARTS','Gespeicherten Korb suchen');
define('FS_DATE_SAVED','Datum');
define('FS_CUSTOMER_ID','Kunden-ID');
define('FS_ACCOUNT_MANAGER','Account Manager');
define('FS_PHONE','Telefonnummer');
define('FS_SUBTOTAL','Gesamtsumme');
define('FS_VIEW_SHIPPING_CART','Details anzeigen');
define('FS_SAVE_CART_CONDITIONS','Wenn Sie Ihren gespeicherten Warenkorb nicht finden können, probieren Sie bitte, anderen Zeitraum zu wählen.');
define('FS_NO_SAVED_CART_FOUND','Kein Ergebnis');
define('FS_CRET_REFERENCE','Produkt');
define('FS_CART_DELETE','Entfernen');
define('FS_CART_NEW_ITEMS','Neue Artikel hinzugefügt zu Ihrem');
define('FS_CART_SUCCESSFULLY_UPDATED','Ihr Warenkorb wurde erfolgreich aktualisiert.');
define('FS_CART_SAVED_CART_NAME','Name des Warenkorbs');
define('FS_CART_NEW_CART_CREATE','Sie haben einen Warenkorb gespeichert.');
define('FS_CART_HAS_BEEN_ADD','wurde erfolgreich gespeichert.');
define('FS_CART_NAME_ALREADY_EXISTED','Dieser Name existiert bereits. Bitte speichern Sie ihn unter einem anderen Namen.');
define('FS_ADD_TO_SAVED_CART','Hinzufügen');
define('FS_SAVE_CART_SELECT','Gespeicherten Warenkorb wählen');
define('FS_ADD_THE_ITEMS','Oder fügen Sie die Artikel einem vorhandenen gespeicherten Warenkorb hinzu.');
define('FS_NAME_YOUR_SAVED_CART','Benennen Sie den gespeicherten Warenkorb');
define('FS_ADD_TO_CART','In den Warenkorb');
define('FS_EMIAL_YOUR_CART','Warenkorb teilen');
define('FS_PRINT_THIS_PAGE','Warenkorb drucken');
define('FS_SAVED_CART_DETAILS','Details zum Warenkorb');
define('FS_BELOW_IS_THE_CART','Unten finden Sie die Informationen dieses gespeicherten Warenkorbs.');
define('FS_CART_CONTACT_CUSTOMER_SERVICE','Kundenservice kontaktieren');
define('FS_UPDATED_SUCCESSFULLY','Ihr Warenkorb wurde aktualisiert.');
define('FS_NEW_ITEM_CART','Neue Artikel wurden Ihrem gespeicherten Warenkorb hinzugefügt.');
define('FS_CART_ALL_ITEMS','Alle Artikel in diesem Warenkorb sind nicht mehr zum Kauf verfügbar. Bitte wenden Sie sich an Ihren Account Manager für die Verfügbarkeit.');
define('FS_CART_SOME_CUSTOMIZED','Einige maßgeschneiderte Artikel in diesem Warenkorb wurden modifiziert. Bitte wählen Sie erneut die Produktattribute auf der Produktdetailseite.');
define('FS_CART_ALL_CUSTOMEIZED_ITEMS','Alle Artikel in diesem Warenkorb wurden modifiziert. Bitte wählen Sie erneut die Produktattribute auf der Produktdetailseite.');
define('FS_CART_THE_QUANTITY','Die angegebene Menge überschreitet die Bestandsmenge und wurde entsprechend angepasst. Bitte wenden Sie sich an Ihren Account Manager für eine größere Menge dieses Produkts.');
define('FS_CART_SHOPPING_CART_DIRECTLY','Die Artikel in diesem Warenkorb sind zum Online-Kauf nicht mehr verfügbar. Bitte wenden Sie sich an Ihren Account Manager für die Verfügbarkeit. Zugleich wurden die verfügbaren Artikel direkt in den Warenkorb gelegt.');
define('FS_CART_QUANTITY_ADDITIONAL','Die angegebene Menge überschreitet die Bestandsmenge und wurde entsprechend angepasst. Bitte wenden Sie sich an Ihren Account Manager für eine größere Menge dieses Produkts.');
define('FS_CART_CUSTOMIZED_SHOPPING_CART','Die maßgeschneiderte Artikel in diesem Warenkorb wurden modifiziert. Bitte wählen Sie erneut die Produktattribute auf der Produktdetailseite. Zugleich wurden die verfügbaren Artikel direkt in den Warenkorb gelegt.');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','Bitte geben Sie den Namen des Warenkorbs maximal 150 Wörter ein.');
define('FS_FROM','Aus');
define('FS_TO_EMAIL','An');
define('FS_SELECT_SAVE_CART','Bitte wählen Sie einen gespeicherten Warenkorb.');


define('FS_NOTICE_FREE_SHIPPING','Kostenloser Versand für Bestellungen über $MONEY');
define('FS_NOTICE_FREE_DELIVERY','Kostenloser Versand bei Bestellung über $MONEY');
define('FS_NOTICE_FAST_SHIPPING','Schneller Versand nach $COUNTRY');
define('FS_NOTICE_HEADER_COMMON_TIPS',' Aufgrund der Auswirkung von COVID-19 kann es zu Verzögerungen bei der Lieferung kommen.');

define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 Business Day Service');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early® service');
define('FS_SERVICE_WORD', 'Service');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'Zahlung abschließen');
define('FS_EMAIL_OPTIMIZE_02', 'Hinweis: Wenn Sie bereits die Zahlung getätigt haben, ignorieren Sie bitte diese E-Mail.');
define('FS_EMAIL_OPTIMIZE_03', 'Wir bearbeiten jetzt Ihre Bestellung.');
define('FS_EMAIL_OPTIMIZE_04', 'Details zu Ihrer Bestellung #ORDER_NUMBER finden Sie weiter unten. Wir werden Ihnen Nachrichten über die Aktualisierungen des Bestellstatus senden.');
define('FS_EMAIL_OPTIMIZE_05', 'Bestellung überprüfen');
define('FS_EMAIL_OPTIMIZE_06', 'Hinweis: Wenn Sie bereits die Auftragsdatei hochgeladen haben, ignorieren Sie bitte diese E-Mail.');
define('FS_EMAIL_OPTIMIZE_07', 'Vielen Dank für Ihre Bestellung.');
define('FS_EMAIL_OPTIMIZE_08', 'Bitte schließen Sie die Zahlung innerhalb von 7 Werktagen ab. Andernfalls wird die Bestellung aufgrund der Bestandsänderung der Artikel storniert. Nach Abschluss der Zahlung erhalten Sie eine Benachrichtigung darüber, dass wir Ihre Bestellung bestätigt und die Zahlung erhalten haben.');
define('FS_EMAIL_OPTIMIZE_09', 'Zahlungsanweisungen');
define('FS_EMAIL_OPTIMIZE_10', 'Nachdem die Zahlung erfolgreich überwiesen wurde, senden Sie bitte den Bankbeleg an $FS_EMAIL oder Ihren Account Manager. Dies hilft dabei, Ihre Bestellung vorrangig zu bearbeiten und die Stornierung Ihrer Bestellung zu vermeiden. Bitte überweisen Sie den Betrag auf das folgende Konto.');
define('FS_EMAIL_OPTIMIZE_11', 'Hinweis: Bitte geben Sie bei der Überweisung Ihre Bestellnummer $ORDER_NUMBER und E-Mail-Adresse an.');
define('FS_EMAIL_OPTIMIZE_12', 'Lieferungsrichtlinie');
define('FS_EMAIL_OPTIMIZE_13', 'Die voraussichtliche Lieferzeit wird erst geschätzt, wenn wir Ihre Auftragsdatei erhalten haben.');
define('FS_EMAIL_OPTIMIZE_14', 'Ihre Bestellung wird montags bis freitags (außer an Feiertagen) zwischen 9:00 und 17:00 Uhr geliefert. Jemand muss an der angegebenen Adresse die Lieferung annehmen und unterschreiben können.');

define('FS_PLEASE_CHECK_THE_URL','Bitte überprüfen Sie die URL oder gehen Sie auf die ');
define('FS_HOMEPAGE','Startseite.');
define('FS_GO_TO_HOMEPAGE','Startseite');

define('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 Business Days');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 Business Days');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 Business Days');

define("FS_WORD_CLOSE", 'Schließen');

//报价购物车
define('FS_NEW_OTHER_LENGTH','Andere Länge');
define('FS_INQUIRY_CART_1',"Angebot anfragen");
define('FS_INQUIRY_CART_2',"Kontaktinformationen");
define('FS_INQUIRY_CART_3',"Vorname*");
define('FS_INQUIRY_CART_4',"Nachname*");
define('FS_INQUIRY_CART_5',"E-Mail-Adresse*");
define('FS_INQUIRY_CART_6',"Telefon");
define('FS_INQUIRY_CART_7',"Anmerkung");
define('FS_INQUIRY_CART_8',"Datei hochladen");
define('FS_INQUIRY_CART_9',"Zulässige Dateitypen: PDF, JPG, PNG.<br>Dateigröße bis zu 5M.");
define('FS_INQUIRY_CART_10',"Geben Sie bitte Produkt-ID und Menge ein.");
define('FS_INQUIRY_CART_11',"Hinzufügen");
define('FS_INQUIRY_CART_12',"Angebot anfragen");
define('FS_INQUIRY_CART_13',"Bitte hinterlassen Sie Anmerkungen, wenn Sie spezielle Anforderungen haben.");
define('FS_INQUIRY_CART_14',"Produkt-ID eingeben");
define('FS_INQUIRY_CART_15',"Geben Sie bitte eine Produkt-ID ein.");



define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'UPS Express Saver® Next Day Service');
define("FS_BLANK", ' ');

// 结算页美国、澳大利亚跳转
define('AUSTRALIA_HREF_1',"Auf dieser Seite abgeschickte Bestellungen können nicht nach Australien geliefert werden. Wenden Sie sich bitte an ");
define('FS_AUSTRALIA_CHECKOUT',"FS Australien");
define('AUSTRALIA_HREF_2',", wenn Sie die Bestellung nach Australien liefern möchten.");
define('UNITED_STATES_SITE_HREF_1',"Auf dieser Seite abgeschickte Bestellungen können nicht in die USA geliefert werden. Wenden Sie sich bitte an ");
define('FS_UNITED_STATES_SITE',"FS USA");
define('UNITED_STATES_SITE_HREF_2',", wenn Sie die Bestellung in die USA liefern möchten.");
define('RUSSIAN_SITE_HREF_1',"Für juristische Personen müssen Bestellungen bargeldlos in Rubel bezahlt werden. Wenden Sie sich bitte an ");
define('FS_RUSSIAN_SITE',"FS Russland");
define('RUSSIAN_SITE_HREF_2',", wenn Sie die Bestellung aufgeben möchten.");


//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'Wird geladen...');


define('FS_VAX_TITLE_US','Geschätzte MwSt.');
define('FS_VAX_TITLE_US_TAX','Umsatzsteuer');

define('FS_VAX_US_TIPS','Nach den staatlichen Steuergesetzen ist FS verpflichtet, Verkaufssteuer von nicht befreiten Parteien zu erheben. <a href="https://www.fs.com/service/sales_tax.html" target="_blank">Mehr erfahren</a>');


//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "Meine bewertungen");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "Bewertung schreiben");
define('FS_VIEW_REVIEWS_SEARCH', "Suchen");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "Bewertung suchen:");
define('FS_VIEW_REVIEWS_ITEM', "Produkt-ID");
define('FS_VIEW_REVIEWS_1', "Kein Ergebnis");
define('FS_VIEW_REVIEWS_2', "Finden Sie Ihre Bestellung und schreiben Sie eine Bewertung dafür.");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "Datum: ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "Sehr zufrieden");
define('FS_VIEW_REVIEWS_READ_MORE', "Mehr anzeigen");
define('FS_VIEW_REVIEWS_MORE', "More");
define('FS_VIEW_REVIEWS_SHOW', "Anzeigen");
define('FS_VIEW_REVIEWS_COMMENTS', "Anmerkung");


define('FS_SRVICE_WORD', "Service");


define('FS_PRODUCT_MATERIAL_M','m');
define('FS_PRODUCT_MATERIAL_CABLE',' Kabelmaterialien');
define('FS_PRODUCT_MATERIAL_TIP','Die Lieferzeit ist etwas länger, da die angeforderte Menge den verfügbaren Lagerbestand überschreitet. Wenn Sie eine separate Lieferung der vorrätigen Artikel wünschen, wenden Sie sich bitte an Ihren Account Manager.');


define('FS_INQUIRY_PRODUCTS_NUM',"Bitte überprüfen Sie die Produkte Ihres Angebots.");

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'Bitte geben Sie Ihren vollen Namen ein.');
define('FS_NET_30_02', 'Bitte laden Sie Ihr Antragsformular hoch.');
define('FS_NET_30_03', 'Das Kreditkonto existiert bereits.');
define('FS_NET_30_04', 'FS - Wir haben Ihren Kreditantrag erhalten');
define('FS_NET_30_05', 'Wir haben Ihren Kreditantrag erhalten. Der Antrag wird derzeit geprüft und die Prüfung dauert ca. 2 bis 3 Werktage. Beim Treffen einer Entscheidung werden Sie rechtzeitig per FS-E-Mail von FS benachrichtigt.');
define('FS_NET_30_06', 'Kreditantrag');
define('FS_NET_30_07', 'Eingereicht');
define('FS_NET_30_08', 'Geprüft');
define('FS_NET_30_09', 'Genehmigt');
define('FS_NET_30_10', 'Abgelehnt');
define('FS_NET_30_11', 'Antragsformular einreichen');
define('FS_NET_30_12', 'Voller Name');
define('FS_NET_30_13', 'E-Mail-Adresse');
define('FS_NET_30_14', 'Telefonnummer');
define('FS_NET_30_15', 'Datei hochladen');
define('FS_NET_30_16', 'Datei wählen');
define('FS_NET_30_17', 'Ihr Antragsformular wurde erfolgreich eingereicht.');
define('FS_NET_30_18', 'Wir werden Ihnen das Ergebnis innerhalb von 2-3 Werktagen per E-Mail senden. Sie können auch sich anmelden und die Aktualisierungen unter „#CASE_CENTER“ verfolgen.');
define('FS_NET_30_19', 'Ihr Antragsformular wurde erfolgreich eingereicht!');
define('FS_NET_30_20', 'Ihr Kreditantrag wird derzeit geprüft. Die Prüfung dauert ca. 2 bis 3 Werktage.');
define('FS_NET_30_21', 'Wir freuen uns Ihnen mitteilen zu können, dass Ihr Kreditantrag genehmigt wurde! Jetzt können Sie über Ihr Kreditkonto Bestellungen bei FS aufgeben.');
define('FS_NET_30_22', 'Sie können auch die Details unter „#FS_CREDIT“ sehen.');
define('FS_NET_30_23', 'Es tut uns leid, Ihnen mitteilen zu müssen, dass Ihr Kreditantrag abgelehnt wurde. ');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', 'Möchten Sie ein Kreditkonto erneut beantragen?');
define('FS_NET_30_25', 'Füllen Sie das Antragsformular unter „#NET_TERMS“ aus und senden Sie es ab.');
define('FS_NET_30_26', 'Bei Fragen wenden Sie sich bitte an Ihren Account Manager #ACCOUNT_MANAGER.');
define('FS_NET_30_27', 'Land/Region');
define('FS_NET_30_28', 'Anmerkung');
define('FS_NET_30_29', 'Einreichen');
define('FS_NET_30_30','Mit freundlichen Grüßen<br>FS Team');
define('FS_NET_30_31','Antrag erhalten');
define('FS_NET_30_32','Kauf auf Rechnung');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','Entdecken Sie unsere neuesten Innovationen');

//取消订阅
define('FS_UNSUBSCRIBE_MAIL_1',' FS-Newsletter');
define('FS_UNSUBSCRIBE_MAIL_2','Sie erhalten neuesten Informationen über Sonderangebote, Warenbestand, Tech-Support usw.');
define('FS_UNSUBSCRIBE_MAIL_3','Bewertungserinnerung');
define('FS_UNSUBSCRIBE_MAIL_4','Die Bewertungserinnerung wird 7 Tage nach Zustellung gesandt.');
define('FS_UNSUBSCRIBE_MAIL_5','Verwalten Sie Ihre Abonnementeinstellungen für FS-Newsletter bzw. Bewertungserinnerung.');
define('FS_UNSUBSCRIBE_MAIL_6','Wenn Sie sich vom Newsletter abgemeldet order die Bewertungserinnerung deaktiviert haben, erhalten Sie weiterhin E-Mails über wichtige Informationen zu Konto, Bestellungen usw.');

//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', 'Firmen');

/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','Wellenlänge (nm)');

//100G产品提示语
define("FS_COHERENT_CFP","Der kohärente CFP-Transceiver kann nicht separat verkauft werden.");


//checkout 账单地址邮编验证提示
define('FS_ZIP_VALID_1','Die ausgewählte Adresse stimmt nicht mit dem Post-Datensatz überein. Bitte überprüfen Sie die Adresse erneut.');
define('FS_ZIP_VALID_2','Bitte geben Sie eine gültige Postleitzahl ein.');


define("FS_SOLUTION_CLICK_OPEN_VIEW","Klicken Sie auf das Bild, um es zu vergrößern.");
define("FS_CUSTOMIZE_YOUR_SOLUTION","Maßgeschneiderte Lösung wählen");
define("FS_TECH_SPEC_CUSTOMOZATION","Technische Spezifikationen");
define("FS_SOLUTION_OVERVIEW",'Übersicht');
define("FS_SOLUTION_CUSTOMIZED",'In den Warenkorb');
define("FS_SOLUTION_EDIT",'Bearbeiten');
define("FS_SOLUTION_CONFIGURATION",'Lösungskonfiguration');
define("FS_SOLUTION_MORE",'Mehr anzeigen');
define("FS_SOLUTION_LESS",'Weniger anzeigen');
define("FS_SOLUTION_DEVICES",'Geräte');
define("FS_SOLUTION_TRANSCEIVER",'Transceiver');
define("FS_SOLUTION_WAVE_COM_BAR",'Wellenlänge & kompatible Marke');
define("FS_SOLUTION_ACCESSORIES",'Zubehör');
define("FS_SOLUTION_CHOOSE_LENGTH",'Länge');
define("FS_SOLUTION_INFO",'Lösungsdetails');

define('FS_SOLUTION_PERSONALIZATION','Maßgeschneidert');
define('FS_SOLUTION_MANUFACTURING','Hergestellt');
define('FS_SOLUTION_SHIPPED','Versandt');
define('FS_SOLUTION_ARRIVED','Zugestellt');
define('FS_SOLUTION_CON_LIST',' Lösungskonfigurationen');
define('FS_SOLUTION_QUANTITY','Menge');
define('FS_SOLUTION_TOTAL','Gesamtsumme');

define('FS_SOLUTION_SITEA','Standort A');
define('FS_SOLUTION_SITEB','Standort B');

define('FS_SOLUTION_NAV_01','Optisches Transportnetz');
define('FS_SOLUTION_NAV_02','Campusnetzwerk');
define('FS_SOLUTION_NAV_03','Rechenzentrum');
define('FS_SOLUTION_NAV_04','Strukturierte Verkabelung');
define('FS_SOLUTION_NAV_05','Nach Anwendung');
define('FS_SOLUTION_NAV_06','10G CWDM Doppelfaser-Netzwerk');
define('FS_SOLUTION_NAV_07','10G CWDM Einzelfaser-Netzwerk');
define('FS_SOLUTION_NAV_08','10G DWDM Doppelfaser-Netzwerk');
define('FS_SOLUTION_NAV_09','10G DWDM Einzelfaser-Netzwerk');
define('FS_SOLUTION_NAV_10','25G DWDM Doppelfaser-Netzwerk');
define('FS_SOLUTION_NAV_11','25G DWDM Einzelfaser-Netzwerk');
define('FS_SOLUTION_NAV_12','Kohärentes 40/100G-Netzwerk');
define('FS_SOLUTION_NAV_13','Unternehmens-Netzwerk');
define('FS_SOLUTION_NAV_14','Wireless und Mobilität');
define('FS_SOLUTION_NAV_15','Multi-Branch-Netzwerk');
define('FS_SOLUTION_NAV_16','Cloud-Managed-Netzwerk');
define('FS_SOLUTION_NAV_17','Strukturierte Verkabelung in Rechenzentren');
define('FS_SOLUTION_NAV_18','High-Density MTP®/MPO Verkabelung');
define('FS_SOLUTION_NAV_19','40G/100G-Migration');
define('FS_SOLUTION_NAV_20','Vorkonfektionierte Kupferverkabelung');
define('FS_SOLUTION_NAV_21','Multi-Service-CWDM-Lösung');
define('FS_SOLUTION_NAV_22','10G DWDM Langstreckenübertragung');
define('FS_SOLUTION_NAV_23','25G WDM für 5G-Fronthaul');
define('FS_SOLUTION_NAV_24','Kohärente 100G DWDM-Lösung');
define('FS_SOLUTION_NAV_25','Optimierungslösung für MLAG-Netze');
define('FS_SOLUTION_NAV_26','Kernnetzwerk-Switching in Rechenzentren');
define('FS_SOLUTION_NAV_27','Power-over-Ethernet-Lösung');
define('FS_SOLUTION_NAV_28','Sichere Wireless-Lösung');
define('FS_SOLUTION_NAV_29','Strukturierte Verkabelung in Rechenzentren');
define('FS_SOLUTION_NAV_30','High-Density MTP®/MPO Verkabelung');
define('FS_SOLUTION_NAV_31','40G/100G-Migration');
define('FS_SOLUTION_NAV_32','Vorkonfektionierte Kupferverkabelung');
define('FS_SOLUTION_NAV_33','Tech-Team und -Support für professionelle Lösungen');
define('FS_SOLUTION_NAV_34','Unternehmens-Rechenzentrum');
define('FS_SOLUTION_NAV_35','Rechenzentrum der Dienstleister');
define('FS_SOLUTION_NAV_36','Hyperscale- und Cloud-Rechenzentrum');
define('FS_SOLUTION_NAV_37','Multi-Tenant-Rechenzentrum');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','Langstrecken-10G-DWDM der M6200-Serie');
define('FS_SOLUTION_NAV_M6500','100G/200G Hohe Bandbreite der M6500-serie');
define('FS_SOLUTION_NAV_M6800','1,6T-DCI-Lösung der M6800-Serie');
define('FS_SOLUTION_NAV_WiFi6','Wi-Fi 6 Netzwerklösungen');

define('FS_PLEASE_W_REVIEW','Geben Sie bitte Ihren Kommentar ein.');
//新加坡
define("FS_CHECKOUT_ERROR_SG_01","Dies ist ein Pflichtfeld.");
define("FS_CHECKOUT_ERROR_SG_02","Apartment-, Wohnungs-, Zimmernummer, Stockwerk");
define("FS_CHECKOUT_ERROR_SG_03","Lieferscheinnummer");
define("FS_CHECKOUT_ERROR_SG_04","Zur Gewährleistung einer reibungslosen Lieferung geben Sie bitte eine Lieferscheinnummer für die Pakete an, die an Equinix gesandt werden.");
define("FS_CHECKOUT_ERROR_SG_05","*Während der besonderen Zeit von COVID-19 wird es empfohlen, Ihre Wohnadresse einzugeben, um eine pünktliche Lieferung zu gewährleisten.");
define("FS_CHECKOUT_ERROR_SG_06","Bitte geben Sie eine vollständige Lieferadresse ein.");

define('FS_CHECKOUT_ERROR_001','Die Anzahl der ausgewählten Artikel hat die Obergrenze erreicht, und alle verfügbaren Produkte wurden dem Warenkorb hinzugefügt.');
define('FS_CHECKOUT_ERROR_002','Wählen Sie bitte <span>4</span> verschiedene Kanäle.');

define("FS_SEE_ALL_RESULTS","Alle Ergebnisse");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD'," Software-Downloads");
define('FS_CHECK',"Laden Sie die neueste Softwareversion für Ihre Switches herunter.");
define('FS_SOFWARE','Software-Downloads');
define('FS_SOFWARE_1','Kundenservice kontaktieren');
define('FS_SOFWARE_2','Hier finden Sie die neuesten Software-Versionen für die von Ihnen gekauften Switches. Weitere Software-Versionen finden Sie in unserem');
define('FS_SOFWARE_4','Download Center');
define('FS_SOFWARE_5','Switch-Typ:');
define('FS_SOFWARE_6','Netzwerk-Switches');
define('FS_SOFWARE_7','1G/10G Switches');
define('FS_SOFWARE_8','25G Switches');
define('FS_SOFWARE_9','40G Switches');
define('FS_SOFWARE_10','100G Switches');
define('FS_SOFWARE_11','400G Switches');
define('FS_SOFWARE_12','Produkt-ID suchen:');
define('FS_SOFWARE_13','Suchen');
define('FS_SOFWARE_14','Neueste Version');
define('FS_SOFWARE_15','Produkt-ID');
define('FS_SOFWARE_16','Versionsdatum');
define('FS_SOFWARE_17','Größe');
define('FS_SOFWARE_18','Software');
define('FS_SOFWARE_19','Update-Benachrichtigung');
define('FS_SOFWARE_20','Neueste Version');
define('FS_SOFWARE_22','Versionshinweis');
define('FS_SOFWARE_23','Version');
define('FS_SOFWARE_24','Software');
define('FS_SOFWARE_25','Herunterladen');
define('FS_SOFWARE_26','Update-Benachrichtigung');
define('FS_SOFWARE_27','Abonnement kündigen');
define('FS_SOFWARE_28','Abonnieren');
define('FS_SOFWARE_29','Möchten Sie das Abonnement kündigen?');
define('FS_SOFWARE_30','Möchten Sie ein Abonnement für die neue Softwareversion erstellen?');
define('FS_SOFWARE_31','Wenn Sie Ihre Bestellung nicht finden können, probieren Sie bitte mit anderen Switch-Typen bzw. Produkt-IDs.');
define('FS_SOFWARE_32','Sie haben noch keine Switches von FS gekauft.');
define('FS_SOFWARE_33','Jetzt kaufen');
define('FS_SOFWARE_34','Sie haben erfolgreich abonniert!');
define('FS_SOFWARE_35','Sie werden die E-Mail-Benachrichtigungen über die neue Softwareversion erhalten.');
define('FS_SOFWARE_36','Sie haben erfolgreich abonniert!');
define('FS_SOFWARE_37','Sie haben das Abonnement gekündigt.');
define('FS_SOFWARE_38','Sie erhalten keine E-Mail-Benachrichtigung mehr über die neue Softwareversion.');
define('FS_SOFWARE_39','Produkt-ID');
define('FS_SOFWARE_40','Kein Ergebnis');
define('FS_SOFWARE_41','Erfolgreich abonniert');
define('FS_SOFWARE_42','Sie haben ein Update-Abonnement für die Software des folgenden Switches erfolgreich erstellt. Wir senden Ihnen eine Benachrichtigung, sobald die neueste Version verfügbar ist.');
define('FS_SOFWARE_43','Sie sind vielleicht auch interessiert an...');
define('FS_SOFWARE_44','Erfahren Sie, was wir unseren Kunden auf der ganzen Welt anbieten können.');
define('FS_SOFWARE_45','Erfahren Sie unsere neuesten innovativen Produkte und Firmenveranstaltungen.');
define('FS_SOFWARE_46','FS - Update-Abonnement für die Software');
define('FS_SOFWARE_47','Abonnement gekündigt');
define('FS_SOFWARE_48','Sie erhalten keine Benachrichtigungen über Softwareupdates für den folgenden Switch mehr.');
define('FS_SOFWARE_49','Wenn es Fehler gibt, klicken Sie auf die Schaltfläche unten und abonnieren Sie es erneut.');
define('FS_SOFWARE_50','Erneut abonnieren');
define('FS_SOFWARE_51','Wir bleiben in Kontakt');
define('FS_SOFWARE_52','Update-Abonnement');
define('FS_SOFWARE_53','Case Studies');
define('FS_SOFWARE_54','Nachrichtenmeldung');


define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','Keine Versandoption gefunden?');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','Aufgrund der Beschränkungen des Spediteurs hinsichtlich der Größe der Artikel können Bestellungen mit dem Produkt #73579 oder #73958 nicht per Express versandt werden. Sie können Ihren eigenen Spediteur auswählen oder Ihren Account Manager bezüglich des Speditionsversands konsultieren. Wir entschuldigen uns für die Unannehmlichkeiten.');

define('FS_CHECKOUT_FOOTER_NEW_01', 'Feedback');
define('FS_CHECKOUT_FOOTER_NEW_02', '<a href="' . reset_url('service/fs_support.html'). '" target="_blank" >Hilfecenter</a> oder <a target="_blank" href="' . reset_url('contact_us.html') . '">Kontakt</a>.');
define('FS_CHECKOUT_FOOTER_NEW_03', 'Sofortige Unterstützung finden Sie unter ');
define('FS_CHECKOUT_FOOTER_NEW_04', 'Gegenstand wählen*');
define('FS_CHECKOUT_FOOTER_NEW_05', 'Gegenstand');
define('FS_CHECKOUT_FOOTER_NEW_06', 'Anmelden / Konto eröffnen');
define('FS_CHECKOUT_FOOTER_NEW_07', 'Warenkorb');
define('FS_CHECKOUT_FOOTER_NEW_08', 'Steuer');
define('FS_CHECKOUT_FOOTER_NEW_09', 'Liefer-/Rechnungsadresse');
define('FS_CHECKOUT_FOOTER_NEW_10', 'Versand & Lieferung');
define('FS_CHECKOUT_FOOTER_NEW_11', 'Zahlung');
define('FS_CHECKOUT_FOOTER_NEW_12', 'Andere');
define('FS_CHECKOUT_FOOTER_NEW_13', 'Wählen Sie bitte einen Gegenstand.');
define('FS_CHECKOUT_FOOTER_NEW_14', 'Was können wir tun, um Ihre Erfahrung zu verbessern?');
define('FS_CHECKOUT_FOOTER_NEW_15', 'Geben Sie die Anmerkung ein. Dies hilft uns, schneller auf Ihr Feedback zu reagieren.');
define('FS_CHECKOUT_FOOTER_NEW_16', 'Geben Sie bitte mehr als 10 Zeichen ein.');
define('FS_CHECKOUT_FOOTER_NEW_17', 'Einreichen');
define('FS_CHECKOUT_FOOTER_NEW_18', 'Vielen Dank für Ihr Feedback!');
define('FS_CHECKOUT_FOOTER_NEW_19', 'Wir werden Ihr Feedback überprüfen und es verwenden, um unsere Webseite für zukünftige Besuche zu verbessern.');
define('FS_CHECKOUT_SUCCESS_EMAIL_01', 'Sie haben ein neues Feedback erhalten');
define('FS_CHECKOUT_SUCCESS_EMAIL_02', 'Ein Kunde hat nach dem Aufgeben der Bestellung ein Feedback eingereicht. Beachten Sie es bitte gegebenenfalls.');
define('FS_CHECKOUT_SUCCESS_EMAIL_03', 'Kundenname:');
define('FS_CHECKOUT_SUCCESS_EMAIL_04', 'E-Mail-Adresse:');
define('FS_CHECKOUT_SUCCESS_EMAIL_05', 'Bestellnummer:');
define('FS_CHECKOUT_SUCCESS_EMAIL_06', 'Gegenstand:');
define('FS_CHECKOUT_SUCCESS_EMAIL_07', 'Details:');
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'Neues Feedback');

define('FS_PRINT',"Zum Schutz von Kundendaten geben Sie bitte das FS-Konto des Benutzers ein, der diese Bestellung aufgegeben hat, um die Bestelldetails nachzusehen:");
define('FS_PRINT_1',"Bestätigen");
define('FS_PRINT_2',"Die eingegebene E-Mail stimmt nicht mit den Bestellinformationen überein. Bitte überprüfen Sie die Adresse und sie erneut eingeben.");
define('FS_PRINT_3',"Geben Sie bitte die E-Mail-Adresse ein.");




//评论改版
define('FS_REVIEW_07','Gerätemodell');
define('FS_REVIEW_08','Dies kann anderen beim Kauf helfen.');
define('FS_REVIEW_09','Zulässige Dateitypen: JPG, JPEG, PNG. Dateigröße bis zu 5MB.');
define('FS_REVIEW_11','Optional');

define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Kompatibilität');


//2020.08.03 liang.zhu
define('FS_CLEARANCE_TIP_01_01', 'Von diesem Sonderangebot sind nur noch $QTY Stück übrig. Sobald sie ausverkauft sind, wird es entfernt.');
define('FS_CLEARANCE_TIP_01_02', 'Wenn Sie mehr brauchen, wird das Ersatzprodukt <a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a> empfohlen.');
define('FS_CLEARANCE_TIP_02_01', 'Dieses Sonderangebot ist nicht vorrätig und wird in Kürze entfernt.');
define('FS_CLEARANCE_TIP_02_02', 'Wenn Sie es brauchen, wird das Ersatzprodukt <a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a> empfohlen.');
define('FS_CLEARANCE_TIP_03_01', 'Von diesem Sonderangebot sind nur noch $QTY Stück übrig. Sobald sie ausverkauft sind, wird es entfernt.');
define('FS_CLEARANCE_TIP_03_02', 'Wenn Sie mehr brauchen, wenden Sie sich bitte an Ihren Account Manager.');
define('FS_CLEARANCE_TIP_04_01', 'Dieses Sonderangebot ist nicht vorrätig und wird in Kürze entfernt.');
define('FS_CLEARANCE_TIP_04_02', 'Wenn Sie es brauchen, wenden Sie sich bitte an Ihren Account Manager.');


define('CHECKOUT_COMPANY_TYPE', 'Der Adresstyp ist falsch.');

## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "Lieferanweisungen (optional)");
define("FS_DELIVERY_TICKET_NUMBER", "Lieferscheinnummer, Sicherheitscode usw.");
define("FS_DELIVERY_OTHER_INFO", "Lieferzeit oder andere Lieferanweisungen");
define("FS_DELIVERY_PROMPT", "Ihre Anweisungen helfen uns bei der Lieferung Ihres Pakets.");
define('FS_DELIVERY_INSTRUCTIONS', 'Lieferanweisungen');

//PO
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', ' wurde bestätigt. Laden Sie bitte die Auftragsdatei innerhalb von 7 Werktagen hoch. Andernfalls wird die Bestellung aufgrund der Bestandsänderung der Artikel automatisch storniert.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', 'Auftragsdatei hochladen');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', 'Was ist eine Auftragsdatei?');
define('FS_PO_FILE','Beschaffungsauftrag');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','Beschaffungsauftrag');
define('FS_PO_FILE_4','Datum: 08.08.2020<br />Auftrags-Nr.: PO0001');
define('FS_PO_FILE_5','Lieferant');
define('FS_PO_FILE_6','Lieferadresse');
define('FS_PO_FILE_7','Rechnungsadresse');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','Account Manager: ');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','E-Mail: ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','Telefonnummer: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','z. Hd.: ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','Telefonnummer: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','z. Hd.: ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','Zahlungsart');
define('FS_PO_FILE_27','Im Auftrag von');
define('FS_PO_FILE_28','Abteilung');
define('FS_PO_FILE_29','Banküberweisung');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','Einkauf');
define('FS_PO_FILE_32','FS-Angebotsnummer: RQC2008010003');
define('FS_PO_FILE_33','<th>Produktdetails</th><th>Produkt-ID</th><th>Menge</th><th>Stückpreis</th><th>Gesamtpreis</th>');
define('FS_PO_FILE_36','Zwischensumme:');
define('FS_PO_FILE_38','Versandkosten:');
define('FS_PO_FILE_39','MwSt.:');
define('FS_PO_FILE_40','Gesamtsumme:');
define('FS_PO_FILE_41',"Was ist eine Auftragsdatei?");
define('FS_PO_FILE_42',"Die Auftragsdatei (PO-Datei) wird als Beleg für Beschaffungsaufträge verwendet und enthält normalerweise die folgende Elemente: ");
define('FS_PO_FILE_43',"Auftragsdatum und Auftragsnummer;");
define('FS_PO_FILE_44',"Unternehmensinformationen des Käufers und des Lieferanten;");
define('FS_PO_FILE_45',"Liefer- und Rechnungsadresse; Zahlungsbedingung;");
define('FS_PO_FILE_46',"Artikelinformationen und -preise von FS.");
define('FS_PO_FILE_47',"Beispieldatei anzeigen");

//线下订单列表
define('FS_OFFLINE_01','Rechnung anzeigen');
define('FS_OFFLINE_02','Bestelldatum: ');
define('FS_OFFLINE_03','Bestellnummer: ');
define('FS_OFFLINE_04','Zwischensumme: ');
define('FS_OFFLINE_05','Versandkosten: ');
define('FS_OFFLINE_06','GST: ');
define('FS_OFFLINE_07','Versicherung: ');
define('FS_OFFLINE_08','Gesamtsumme: ');
define('FS_OFFLINE_09','Ihre Bestellung wurde gemäß der ausgewählten Versandart auf der Kassen-Seite versandt. Sie können den Lieferstatus verfolgen, indem Sie unten bzw. in der Benachrichtigungs-E-Mail auf die Tracking-Nummer klicken. Einige Spediteure aktualisieren die Tracking-Informationen jedoch nicht immer sofort, sodass der Lieferstatus möglicherweise nicht als der aktuelle angezeigt wird.');
define('FS_OFFLINE_10','Die Lieferung wurde durch eine neue Bestellung ');
define('FS_OFFLINE_10_1',' ersetzt.');
define('FS_OFFLINE_11','Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power ');
define('FS_OFFLINE_12','Empfang bestätigen');
define('FS_OFFLINE_13','Diese Lieferung wurde storniert. Bei Fragen wenden Sie sich bitte an Ihren Account Manager.');
define('FS_OFFLINE_14','Sehen Sie ');
define('FS_OFFLINE_15',' andere Sendung(en)');
define('FS_OFFLINE_16',' von dieser Bestellung.');
define('FS_OFFLINE_17','Bearbeitet');
define('FS_OFFLINE_18','Bestätigen');
define('FS_OFFLINE_19','Bestellung ');
define('FS_OFFLINE_20','(Aktuelle Bestellung)');
define('FS_OFFLINE_21','Kein Ergebnis');
define('FS_OFFLINE_22','Wenn Sie Ihre Bestellung nicht finden können, probieren Sie bitte, andere Bestellart bzw. Zeitraum zu wählen, oder überprüfen Sie die Bestellnummer.<br/>Offline-Bestellungen können erst nach dem Versand gesucht werden. Sie können sich davor an Ihren Account Manager wenden.');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','Offline-Bestellung');
define('FS_OFFLINE_COMBINED_SHIPMENT','Kombinierter Versand');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','Um die Menge der Pakete zu verringern und die Umwelt zu schützen, werden Ihre Bestellungen unten zusammen versandt. Klicken Sie auf die Bestellnummer, um die Details der jeweiligen Bestellung nachzusehen.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','Wenn der Bestellstatus nicht aktualisiert wurde, wenden Sie sich bitte an Ihren Account Manager. Sie können unter "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','"  die Bestellung sehen, wenn sie versandt wurde.');
define('FS_OFFINE_TRANSACTION','Offline-Transaktion');
define('FS_OFFINE_TRANSACTION_1','Diese Lieferung wurde storniert. Bei Fragen wenden Sie sich bitte an Ihren Account Manager.');
define('FS_OFFLINE_POPUP','Artikel aus anderen Bestellung(en) werden in diesem Versand kombiniert.');
define('FS_OFFINE_TRANSACTION','Offline-Kauf');
define('FS_OFFINE_TRANSACTION_2','Sehen Sie die Tracking-Informationen unten.');
define('FS_OFFINE_TRANSACTION_4','Ihre Bestellung wird derzeit bearbeitet.');
//my credit orders 页面
define('FS_VIEW_CONTENT','Diese Bestellung wird über mehrere Pakete geliefert. Sie können alle Rechnungen unter Bestelldetails überprüfen, die für jede Lieferung getrennt sind. Alle Rechnungen finden Sie ');
define('FS_VIEW_LINK','hier.');
define('FS_MY_CREDIT_01','Bestellart:');
define('FS_MY_CREDIT_02','Online-Bestellung');
define('FS_MY_CREDIT_03','Offline-Bestellung');
define('FS_MY_CREDIT_04','Wählen');
define('FS_OFFINE_TRACK_INFO_1','Wenn der Bestellstatus nicht aktualisiert wurde, wenden Sie sich bitte an Ihren Account Manager. Sie können unter „<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">Meine Bestellungen</a>“ die Bestellung sehen, wenn sie versandt wurde.');
define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');
//结算页
define('FS_CHECK_OUT_EXCLUDING1','Exkl. Zölle und Steuern');


//搜索V2版本
define('FS_SEARCH_NEW','Suchergebnis(se) für ');
define('FS_SEARCH_NEW_1','Produkte');
define('FS_SEARCH_NEW_2','Dokumente & Ressourcen');
define('FS_SEARCH_NEW_3','Lösungen');
define('FS_SEARCH_NEW_4','Case Studies');
define('FS_SEARCH_NEW_5','Download');
define('FS_SEARCH_NEW_6','Alles löschen');
define('FS_SEARCH_NEW_7','Lösungen');
define('FS_SEARCH_NEW_8','Case Studies');
define('FS_SEARCH_NEW_9','Datei');
define('FS_SEARCH_NEW_10','Typ');
define('FS_SEARCH_NEW_11','Datum');
define('FS_SEARCH_NEW_12','Herunterladen');
define('FS_SEARCH_NEW_13','Nachrichten');
define('FS_SEARCH_NEW_13_1','Das Produkt');
define('FS_SEARCH_NEW_14',' ist online nicht mehr verfügbar. Das ähnliche Produkt ');
define('FS_SEARCH_NEW_15',' wird wie folgt empfohlen.');
define('FS_SEARCH_NEW_16',' ist online nicht mehr verfügbar. Sie können ein Angebot anfragen.');

define('FS_ACCOUNT_SEARCH_ALL_TIMES', 'Alle Zeiträume');

define('FS_MY_SHOPPING_CART','Mein Warenkorb');
define('GET_A_QUOTE_TIP_1',"*Wenn Sie Fragen zur Vorlaufzeit oder zum Versand haben, füllen Sie bitte die folgenden Informationen aus und reichen Sie das Angebot ein. Wir werden Ihnen so schnell wie möglich antworten.");

define("FS_INQUIRY_NEW_EMAIL"," hat eine Änderung des Angebots #");
define("FS_INQUIRY_NEW_EMAIL_1_1"," angefordert");
define("FS_INQUIRY_NEW_EMAIL_1","Änderung des Angebots");
define("FS_INQUIRY_NEW_EMAIL_2"," hat eine Änderung des Angebots");
define("FS_INQUIRY_NEW_EMAIL_3"," angefordert. Bitte prüfen Sie die folgenden Details und senden Sie erneut ein Angebot so schnell wie möglich.");
define("FS_INQUIRY_NEW_EMAIL_4","Anfragenummer:");
define("FS_INQUIRY_NEW_EMAIL_5","Artikel");
define("FS_INQUIRY_NEW_EMAIL_6","Menge");
define("FS_INQUIRY_NEW_EMAIL_7","Stückpreis");
define("FS_INQUIRY_NEW_EMAIL_8","Angebotspreis");
define("FS_INQUIRY_NEW_EMAIL_9","Ursprüngliche Summe:");
define("FS_INQUIRY_NEW_EMAIL_10","Angebotssumme:");
define("FS_INQUIRY_NEW_EMAIL_11","Bitte antworten Sie ");
define("FS_INQUIRY_NEW_EMAIL_12"," oder senden Sie das Angebot daran.");
define("FS_INQUIRY_NEW_EMAIL_13","Ihre Anfrage wurde eingereicht.");
define("FS_INQUIRY_NEW_EMAIL_14","Wir haben Ihre Anfrage erhalten. Ihr Account Manager wird Ihnen innerhalb von 12 bis 24 Stunden antworten.");


define('FS_QUOTE_INQUIRY_01', 'Datei auswählen');
define('FS_QUOTE_INQUIRY_02', 'Produktliste hochladen');
define('FS_QUOTE_INQUIRY_03', 'Geben Sie bitte die Produkt-ID ein oder laden Sie die Produktliste für Ihre Angebotsanfrage hoch.');
define('FS_QUOTE_INQUIRY_04', 'Ihr Angebot wurde erfolgreich eingereicht.');
define('FS_QUOTE_INQUIRY_05', 'Ihr Account Manager wird dieses Angebot innerhalb von 12 bis 24 Stunden bearbeiten und Ihnen eine E-Mail senden, wenn es gültig ist.');
define("FS_QUOTE_EDIT_QUOTE", "Angebot bearbeiten");
define("FS_QUOTE_QUOTE_REQUEST", "Angebotsanfrage");
define("FS_QUOTE_INQUIRY_06", "Angebot per E-Mail an Ihren Account Manager senden");
define("FS_QUOTE_INQUIRY_07", "Ihr Angebot ");
define("FS_QUOTE_INQUIRY_08", "ist jetzt gültig, ");
define("FS_QUOTE_INQUIRY_09", "Sie können direkt eine Bestellung aufgeben.");
define("FS_QUOTE_INQUIRY_10", "Wenn Sie dieses Angebot ändern möchten oder Fragen dazu haben, können Sie die folgenden Informationen eingeben. Basierend auf Ihrer Nachricht wird eine E-Mail an Ihren Account Manager gesandt.");
define("FS_QUOTE_INQUIRY_11", "Aus:");
define("FS_QUOTE_INQUIRY_12", "Ihr Account Manager wird auf diese E-Mail-Adresse antworten.");
define("FS_QUOTE_INQUIRY_13", "An:");
define("FS_QUOTE_INQUIRY_14", "Zusätzliche Anmerkung");
define("FS_QUOTE_INQUIRY_15", "Wenn Sie Artikel hinzufügen oder ändern möchten, wird empfohlen, die Produkt-ID (z.B. 11552) und Menge einzugeben.");
define("FS_QUOTE_INQUIRY_16", "E-Mail senden");
define("FS_QUOTE_INQUIRY_17", "Warenkorb drucken");
define("FS_QUOTE_INQUIRY_18", "Als Angebot drucken");
define("FS_QUOTE_INQUIRY_19", "Möchten Sie dieses Angebot bearbeiten?");
define("FS_QUOTE_INQUIRY_20", "Artikel");
define("FS_QUOTE_INQUIRY_21", "Produktliste hochladen");
define("FS_QUOTE_INQUIRY_22", "Produktliste:");
define("FS_QUOTE_INQUIRY_23", "Der Status der Angebotsanfrage ");
define("FS_QUOTE_INQUIRY_24", " wurde aktualisiert. Bitte überprüfen Sie es nochmals.");
define("FS_QUOTE_INQUIRY_25", "Laden Sie bitte die entsprechende Auftragsdatei hoch.");
define("FS_QUOTE_INQUIRY_26", "Anmerkung (optional)");
define("FS_QUOTE_INQUIRY_27", "Geben Sie bitte die Produkt-ID ein oder laden Sie die Produktliste für Ihre Angebotsanfrage hoch.");
define("FS_JUST_ITEM", "Produkt-ID");
define("FS_QUOTE_INQUIRY_28", "Zusätzliche Anmerkung");

//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_COMMON_DHL','DHL Economy Select®');
define("SHIPPING_COURIER_DELIVERY_01"," for Nature Person");

define('FS_CHECKOUT_PAY_01','Bezahlen');

//详情页新文件标记
define('FS_NEW_FILE_TAG','Neu');

//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','Ihre Angebotsanfrage ');
define('FS_INQUIRY_EDIT_SUCCESS_2',' wurde erfolgreich geändert.');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','Mein offizielles Angebot');

define('FS_XING_HAO', '*');

//下单邮件公司信息底部展示
// 深圳仓
define('FS_CHECKOUT_FS_NAME_CN', "FS.COM LIMITED");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_CN','
			Unit 1, Warehouse No. 7,
			South China International Logistics Center, 
			Longhua District,
			Shenzhen, 518109, China');
// 德国仓
define('FS_CHECKOUT_FS_NAME_EU', "FS.COM GmbH");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_EU','  
			NOVA Gewerbepark, Building 7,
			Am Gfild 7,
			85375, Neufahrn bei Munich,
			Germany');
define('FS_CHECKOUT_EMAIL_TEL_EU', '+49 (0) 8165 80 90 517');
define('FS_CHECKOUT_EMAIL_EU', 'de@fs.com');

// 美东仓
define('FS_CHECKOUT_FS_NAME_US', "FS.COM Inc.");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			Adresse: 380 Centerpoint Blvd,
					New Castle, DE 19720,
					United States');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Tel.: +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australia,
				ABN: 71 620 545 502
');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Tel: +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapore,
				GST-Reg.-Nr.: 201818919D
');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Tel: (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');


define('FS_ORDERS_TRACKING_NINJA_STATUS1', 'Das Paket wurde abgeholt - FS');
define('FS_ORDERS_TRACKING_NINJA_STATUS2', 'Das Paket wird derzeit im Lager von Ninja Van bearbeitet - Ninja Van Sortierabteilung');
define('FS_ORDERS_TRACKING_NINJA_STATUS3', 'Das Paket ist auf dem Weg.');
define('FS_ORDERS_TRACKING_NINJA_STATUS4', 'Das Paket wurde erfolgreich zugestellt.');

//账户中心确认收货弹窗
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'Bestellung bewerten');
define('FS_ACCOUNT_HISTORY_INFO_THANK', "Vielen Dank, dass Sie sich für uns entschieden haben.");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "Ihre Bewertung ist für andere Kunden wertvoll und wir würden gerne von Ihnen hören.<br />Klicken Sie auf die Schaltfläche unten und hinterlassen Sie Ihre Bewertung!");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "Nicht jetzt");
define('FS_FOOTER_COOKIE_TIP_NEW','Wir verwenden Cookies, um Ihnen ein optimales Erlebnis bieten zu können. Wenn Sie auf „Akzeptieren“ klicken oder diese Website weiterhin nutzen, stimmen Sie der Verwendung von Cookies <br/>gemäß unserer <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie-Richtlinie</a> zu. Die Verwendung von Cookies können Sie <a href="javascript:;" class="refuse_cookie_btn_google">hier ablehnen</a>.');
define('FS_FOOTER_COOKIE_TIP_BTN','Akzeptieren');


//新增俄罗斯仓库
define("FS_WAREHOUSE_RU","in Russland");
define('FS_RU_NOTICE',"Artikel in dem Lager in Moskau können am selben Tag versandt werden. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Mehr erfahren</a>");
define('FS_COMMON_WAREHOUSE_RU','FS.COM Ltd.<br>
            No.4062, d. 6, str. 16<br>
            Proektiruemyy proezd<br>
            Moscow 115432<br>
            Russian Federation<br>
            Tel.: +7 (499) 643 4876');
define("FS_WAREHOUSE_AREA_TIME_48","Abholung zur gewünschten Zeit im Lager in Russland");
define("FS_WAREHOUSE_AREA_SHIP_RU","aus dem Lager in Russland");
define("FS_WAREHOUSE_AREA_RU","ship from RU Warehouse");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', '%s Stk. verkauft');
define('FS_PRODUCTS_SALES_REVIEW', '%s Bewertung');
define('FS_PRODUCTS_SALES_REVIEWS', '%s Bewertungen');



define('FS_REVIEWS_TAG_01', 'Kundenbewertung');
define('FS_REVIEW_NEW_15', 'Klicken Sie auf das Bild, um Etiketten hinzuzufügen. Sie können noch');
define('FS_REVIEW_NEW_16', 'Etiketten hinzufügen.');
define('FS_REVIEW_NEW_17', 'Speichern');
define('FS_REVIEW_NEW_18', 'Etikett bearbeiten');
define('FS_REVIEW_NEW_19', 'Letzte Bestellung');
define('FS_REVIEW_NEW_20', 'Keine letzten Bestellungen');
define('FS_REVIEW_NEW_21', 'Bestätigen');
define('FS_REVIEW_NEW_22', 'Produkt-ID bzw. -name eingeben');
define('FS_REVIEW_NEW_23', 'Geben Sie bitte die Produkt-ID bzw. den -name ein.');
define('FS_REVIEW_NEW_23', 'Introduce el ID o el título del producto.');
define('FS_REVIEW_NEW_24', 'Etikett hinzufügen');
define('FS_REVIEW_NEW_25', 'Zurück');
define('FS_REVIEW_NEW_26', 'Etikett hinzufügen.');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', 'Produktmerkmale');
define('FS_PRODUCT_COMMUNITY_01', 'Community');
define('FS_PRODUCT_COMMUNITY_02', 'Ideen');
define('FS_PRODUCT_COMMUNITY_03', 'Unboxing des Switches S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_04', 'Ixia RFC2544 Test für Switch S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_05', 'S5860-20SQ: Produktvorstellung | FS');
define('FS_PRODUCT_COMMUNITY_06', 'So verbinden Sie den FS Switch mit einem Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_07', 'Unboxing the S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_08', 'Ixia RFC2544 Test for S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_09', 'S3910-24TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_10', 'Unboxing the S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_11', 'Unboxing the S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_12', 'Ixia RFC2544 Test for S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_13', 'S3910-48TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_14', 'First Look at S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_15', 'S5860-24XB-U Multi-Gig L3 Switch Ixia RFC2544 Test | FS');
define('FS_PRODUCT_COMMUNITY_16', 'Uninterruptible Power Supply Test on S5860-24XB-U | FS');
define('FS_PRODUCT_COMMUNITY_17', 'How to Connect FS Multi-Gig L3 Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_18', 'Unboxing L2+ PoE+ Switch S3410-24TS-P | FS');
define('FS_PRODUCT_COMMUNITY_19', 'Take You to Know S3410-24TS-P in Short | FS');
define('FS_PRODUCT_COMMUNITY_20', 'How to Check Power Status of PoE Port via Web | FS');
define('FS_PRODUCT_COMMUNITY_21', 'IXIA RFC2544 Test on S3410-24TS-P PoE Switch | FS');
define('FS_PRODUCT_COMMUNITY_22', 'How to Replace Power Supplies and Fans | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', 'Produkt-Highlights');

define('FS_PRODUCT_HIGHLIGHTS_01', 'Produkt-Highlights');


//报价PDF语言包
define('FS_QUOTES_PDF_01', 'Offizielles Angebot');
define('FS_QUOTES_PDF_01_TAX', 'Offizielles Angebot');
define('FS_QUOTES_PDF_02', 'Angebotsnummer');
define('FS_QUOTES_PDF_03', 'Erstellt von');
define('FS_QUOTES_PDF_04', '1. Das Angebot ist nur 15 Tage gültig. Bitte kontaktieren Sie Ihren Account Manager nach Ablauf für ein neues Angebot.');
define('FS_QUOTES_PDF_05', '2. Bitte hinterlassen Sie bei Zahlung dieser Bestellung die Angebotsnummer oder Ihren Firmennamen.');
define('FS_QUOTES_PDF_TOTAL_TAX', 'Gesamtsumme');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "Wir haben Ihre Angebotsanfrage ");
define('EMAIL_QUOTES_SUCCESS_02', ' erhalten und werden innerhalb von einem Werktag eine E-Mail mit den Angebotsdetails an Sie senden.');
define('EMAIL_QUOTES_SUCCESS_03', 'Zusätzliche Anmerkung');
define('EMAIL_QUOTES_SUCCESS_04', 'Request quote, please give me your best offer.');
define('EMAIL_QUOTES_SUCCESS_05', 'Angebotsdetails');
define('EMAIL_QUOTES_SUCCESS_06', 'PDF drucken');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'Unter „Mein Konto - Meine Angebote“ können Sie diese Angebotsanfrage ansehen und damit eine Bestellung aufgeben.');
define('EMAIL_QUOTES_SHARE_02', 'Wenn Sie Fragen haben, wenden Sie sich bitte an Ihren Account Manager.');
define('EMAIL_QUOTES_SHARE_03', '');
define('EMAIL_QUOTES_SHARE_04', 'Angebot');
define('EMAIL_QUOTES_SHARE_05', 'Eine neue Angebotsanfrage für Produkte von FS.');


//报价详情页语言包
define('FS_QUOTES_DETAILS_01', 'Lagerbestand, Zustellungszeit, Steuern und Versandkosten werden auf der Kassen-Seite entsprechend angezeigt.');
define('FS_QUOTES_DETAILS_02', 'Bestellen');
define('FS_QUOTES_DETAILS_03', 'Dieses Angebot ist am $TIME abgelaufen.');
define('FS_QUOTES_DETAILS_04', 'Anfragenummer:');
define('FS_QUOTES_DETAILS_05', 'Angebot herunterladen');
define('FS_QUOTES_DETAILS_06', 'Anfragedatum:');
define('FS_QUOTES_DETAILS_07', 'Angebotsdatum:');
define('FS_QUOTES_DETAILS_08', 'Kunden-ID:');
define('FS_QUOTES_DETAILS_09', '#');
define('FS_QUOTES_DETAILS_10', 'Account Manager:');
define('FS_QUOTES_DETAILS_11', 'Telefonnummer:');
define('FS_QUOTES_DETAILS_12', 'Lieferadresse');
define('FS_QUOTES_DETAILS_13', 'Versandart: ');
define('FS_QUOTES_DETAILS_14', 'Rechnungsadresse');
define('FS_QUOTES_DETAILS_15', 'Zahlungsart:');
define('FS_QUOTES_DETAILS_16', 'Mehr anzeigen');
define('FS_QUOTES_DETAILS_17', 'Angebot');
define('FS_QUOTES_DETAILS_18', 'Entschuldigung! Der Artikel ist nicht mehr verfügbar.');
define('FS_QUOTES_DETAILS_19', 'Länge: ');
define('FS_QUOTES_DETAILS_20', 'Mehr');
define('FS_QUOTES_DETAILS_21', 'Der Artikel umfasst die folgenden Produkte');
define('FS_QUOTES_DETAILS_22', 'MwSt.:');
define('FS_QUOTES_DETAILS_23', 'Die Angebotsanfrage ist am $TIME abgelaufen. Sie können erneut ein Angebot anfragen.');
define('FS_QUOTES_DETAILS_24', 'Das Angebot wurde generiert und erfolgreich bestellt.');


//报价列表页语言包
define('QUOTES_LIST_BRED_CRUMBS','Meine Angebote');

define('QUOTES_LIST_TIME_TYPE_1', 'Alle Zeiträume');
define('QUOTES_LIST_TIME_TYPE_2', 'Spätestens 1 Monat');
define('QUOTES_LIST_TIME_TYPE_3', 'Spätestens 3 Monate');
define('QUOTES_LIST_TIME_TYPE_4', 'Spätestens 1 Jahr');
define('QUOTES_LIST_TIME_TYPE_5', 'Vor einem Jahr');

define('QUOTES_LIST_STATUS_TYPE_1', 'Online-Angebote ');
define('QUOTES_LIST_STATUS_TYPE_2', 'Gültig');
define('QUOTES_LIST_STATUS_TYPE_3', 'Bestellt');
define('QUOTES_LIST_STATUS_TYPE_4', 'Abgelaufen');
define('QUOTES_LIST_STATUS_TYPE_5', 'Offline-Angebot');
define('QUOTES_LIST_STATUS_TYPE_6', 'Angebotsstatus');

define('QUOTES_LIST_RESULT_SINGULAR', 'Ergebnis');
define('QUOTES_LIST_RESULT_PLURAL', 'Ergebnisse');
define('QUOTES_LIST_UPDATE_TIME', 'Angebot aktualisiert am $TIME');
define('QUOTES_LIST_EXPIRE_TIME', 'Abgelaufen am $TIME');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', 'Abgelaufen am $TIME');
define('QUOTES_LIST_QUOTE_AGAIN', 'Wieder anfragen');
define('QUOTES_LIST_VIEW_ORDERS', 'Bestelldetails');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', 'Angebotsnummer, Bestellnummer usw.');

define('FS_SHOPPING_CART_CREATE_QUOTE', 'Angebot anfragen');
define('FS_QUOTES_ORDERS_NUMBER', 'Bestellnummer');
define('QUOTES_LIST_EMPTY_TIPS', 'Kein Ergebnis');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - Wir haben Ihre Angebotsanfrage $NUM erhalten');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS - Ihr(e) Freund*in $EMAIL hat Ihnen eine Angebotsanfrage geteilt');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', 'Versandkosten und Steuern werden auf der Kassen-Seite angezeigt.');


define('FS_RECENT_SEARCH', 'Suchverlauf');
define('FS_HOT_SEARCH', 'Angesagt');
define('FS_CHANGE', 'Ändern');

define('FS_VIEW_WORD', 'Ansehen');

//一级分类页
define('FS_CATEGORIES_POPULAR', 'Angesagte Kategorien');
define('FS_CATEGORIES_BEST_SELLERS', 'Meistverkaufte Produkte');
define('FS_CATEGORIES_NETWORK', 'Netzwerkaufbau');
define('FS_CATEGORIES_DISCOVERY', 'Entdeckung');


define('CARD_NOT_SUPPORT', 'Diese Karte ist nicht unterstützt. Bitte wählan Sie eine andere aus.');
//全站help center 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','FS-Support');

define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '<span class="new_proList_proListNtit">Es wurden keine Ergebnisse für</span> „###SEARCH_WORD###“ <span class="new_proList_proListNtit">gefunden. Hier sind die Ergebnisse für</span> „###RECOMMEND_WORD###“<span class="new_proList_proListNtit">.</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', 'Meinen Sie <a target="_blank" href="###HREF_LINK###">###RECOMMEND_WORD###</a>?');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', 'Das neue Produkt wird wie folgt empfohlen.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', 'Das ähnliche Produkt wird wie folgt empfohlen.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', 'Das maßgeschneiderte Produkt wird wie folgt empfohlen.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', 'Sie haben die gewünschten Informationen nicht gefunden? Dann kontaktieren Sie uns.');
define('SEARCH_OFFLINE_PRODUCT_TIP', 'Das Produkt KEYWORD ist online nicht mehr verfügbar, aber wird noch von FS unterstützt. Weitere Informationen finden Sie unter <a  style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">End-of-Sale-Richtlinie</a>.');
//信用卡语言包
define("CREDIT_CARD_ERROR_303","Generische Ablehnung - Es werden keine weiteren Informationen vom Herausgeber zur Verfügung gestellt");
define("CREDIT_CARD_ERROR_606","Der Herausgeber erlaubt diese Art von Transaktion nicht");
define("CREDIT_CARD_ERROR_08","CVV2/CID/CVC2 Daten nicht verifiziert");
define("CREDIT_CARD_ERROR_22","Ungültige Kreditkartennummer");
define("CREDIT_CARD_ERROR_25","Ungültiges Ablaufdatum");
define("CREDIT_CARD_ERROR_26","Ungültiger Betrag");
define("CREDIT_CARD_ERROR_27","Ungültiger Karteninhaber");
define("CREDIT_CARD_ERROR_28","Ungültige Autorisierungs-Nr.");
define("CREDIT_CARD_ERROR_31","Ungültige Verifizierungszeichenfolge");
define("CREDIT_CARD_ERROR_32","Ungültiger Transaktionscode");
define("CREDIT_CARD_ERROR_57","Ungültige Referenz-Nr.");
define("CREDIT_CARD_ERROR_58","Ungültiger AVS-String: Die Länge des AVS-Strings überschreitet max. 40 Zeichen");
define('CREDIT_CARD_ERROR_260','Der Dienst ist aufgrund eines Netzwerkfehlers vorübergehend nicht verfügbar. Bitte versuchen Sie es später oder kontaktieren Sie Ihren Kundenbetreuer.');
define('CREDIT_CARD_ERROR_301','Der Dienst ist aufgrund eines Netzwerkfehlers vorübergehend nicht verfügbar. Bitte versuchen Sie es später oder kontaktieren Sie Ihren Kundenbetreuer.');
define('CREDIT_CARD_ERROR_304','Das Konto wurde nicht gefunden. Bitte überprüfen Sie Ihre Angaben oder wenden Sie sich an die ausstellende Bank.');
define('CREDIT_CARD_ERROR_401','Herausgeber wünscht mündlichen Kontakt mit Karteninhaber. Bitte rufen Sie Ihre kartenausgebende Bank an.');
define('CREDIT_CARD_ERROR_502','Karte ist als verloren/gestohlen gemeldet. Bitte kontaktieren Sie Ihre ausstellende Bank. Hinweis: Gilt nicht für American Express.');
define('CREDIT_CARD_ERROR_505','Ihr Konto ist in der Negativdatei. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_509','Abhebungs- oder Aktivitätsbetragslimit ist überschritten. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_510','Das Auszahlungs- oder Aktivitätszählungslimit wurde überschritten. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_519','Ihr Konto ist in der Negativdatei. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_521','Der Gesamtbetrag übersteigt das Kreditlimit. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_522','Ihre Karte ist abgelaufen. Bitte prüfen Sie das Ablaufdatum oder versuchen Sie eine andere Zahlungsmethode.');
define('CREDIT_CARD_ERROR_530','Fehlende Informationen von der ausstellenden Bank zur Verfügung gestellt. Bitte kontaktieren Sie die Bank oder versuchen Sie eine andere Zahlungsmethode.');
define('CREDIT_CARD_ERROR_531','Der Herausgeber hat die Autorisierungsanfrage abgelehnt. Bitte wenden Sie sich an Ihre ausstellende Bank oder versuchen Sie eine andere Zahlungsmethode.');
define('CREDIT_CARD_ERROR_591','Herausgeber-Fehler. Bitte kontaktieren Sie die ausstellende Bank oder versuchen Sie eine andere Karte.');
define('CREDIT_CARD_ERROR_592','Herausgeber-Fehler. Bitte kontaktieren Sie die ausstellende Bank oder versuchen Sie eine andere Karte.');
define('CREDIT_CARD_ERROR_594','Herausgeber-Fehler. Bitte kontaktieren Sie die ausstellende Bank oder versuchen Sie eine andere Karte.');
define('CREDIT_CARD_ERROR_776','Duplizierte Transaktion. Bitte kontaktieren Sie Ihren Kundenbetreuer, um den Transaktionsstatus zu bestätigen.');
define('CREDIT_CARD_ERROR_787','Die Transaktion wird aufgrund eines hohen Risikos abgelehnt. Bitte versuchen Sie eine andere Zahlungsmethode.');
define('CREDIT_CARD_ERROR_806','Ihre Karte wurde gesperrt. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_825','Das Konto wurde nicht gefunden. Bitte überprüfen Sie die Informationen und versuchen Sie es erneut.');
define('CREDIT_CARD_ERROR_902','Der Dienst ist aufgrund eines Netzwerkfehlers vorübergehend nicht verfügbar. Bitte versuchen Sie es später oder kontaktieren Sie Ihren Kundenbetreuer.');
define('CREDIT_CARD_ERROR_904','Ihre Karte ist nicht aktiv. Bitte wenden Sie sich an Ihre Herausgeber-Bank.');
define('CREDIT_CARD_ERROR_201','Ungültige Kontonummer/falsches Format. Bitte prüfen Sie die Nummer und versuchen Sie es erneut.');
define('CREDIT_CARD_ERROR_204','Nicht identifizierbarer Fehler. Bitte versuchen Sie es später oder wechseln Sie zu einer anderen Zahlungsmethode.');
define('CREDIT_CARD_ERROR_233','Kreditkartennummer stimmt nicht mit der Zahlungsart überein oder ungültige BIN. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('CREDIT_CARD_ERROR_239','Die Karte wird nicht unterstützt. Bitte versuchen Sie eine andere Karte oder wählen Sie eine andere Zahlungsmethode.');
define('CREDIT_CARD_ERROR_261','Ungültige Kontonummer/falsches Format. Bitte prüfen Sie die Nummer und versuchen Sie es erneut.');
define('CREDIT_CARD_ERROR_351','Der Dienst ist aufgrund eines Netzwerkfehlers vorübergehend nicht verfügbar. Bitte versuchen Sie es später oder kontaktieren Sie Ihren Kundenbetreuer.');
define('CREDIT_CARD_ERROR_755','Das Konto wird nicht gefunden. Bitte überprüfen Sie die Informationen oder kontaktieren Sie die ausstellende Bank.');
define('CREDIT_CARD_ERROR_758','Konto ist eingefroren. Bitte wenden Sie sich an Ihre ausstellende Bank oder versuchen Sie eine andere Zahlungsmethode.');
define('CREDIT_CARD_ERROR_834','Die Karte wird nicht unterstützt. Bitte versuchen Sie eine andere Karte oder Zahlungsmethode.');
define('HISTORY_TIPS', 'Hier können Sie die von Ihrem Account Manager erstellte Offline-Angebote auswählen.');
define('TIPS_BUTTON', 'Bestätigen');

define('FS_CHECKOUT_EPIDEMIC_TIPS', 'Aufgrund behördlicher Maßnahmen kann es zu Verzögerung oder Einschränkung bei der Lieferung kommen.
Bitte stellen Sie sicher, dass jemand die Lieferung annehmen kann, andernfalls wird das Paket zurückgesandt.');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', 'Augrund der Zollabfertigung kann sich die Lieferung verzögern.');

//quote成功发送邮件新增
define('QUOTES_NOTE_TITLE','Hinweis:');
define('QUOTES_NOTE_TIPS','Lagerbestand, Zustellungszeit, Steuern und Versandkosten werden auf der Kassen-Seite entsprechend angezeigt.');
define('QUOTES_RQN_NUMBER_TITLE','Angebotsnummer:');
define('QUOTES_TRADE_TERM_TITLE','Handelsklausel:');
define('QUOTES_PAYMENT_TERM_TITLE','Zahlungsart:');
define('QUOTES_SHIP_VIA_TITLE','Versandart:');
define('QUOTES_DATE_ISSUED_TITLE','Angebotsdatum:');
define('QUOTES_EXPIRES_TITLE','Ablaufdatum:');
define('QUOTES_ACCOUNT_MANAGER_TITLE','Account Manager:');
define('QUOTES_ACCOUNT_EMAIL_TITLE','E-Mail:');
define('QUOTES_DELIVER_TO','Lieferadresse');
define('QUOTES_BILLING_TO','Rechnungsadresse');
define('QUOTES_QUOTE_TITLE1','Artikel');
define('QUOTES_QUOTE_TITLE2','Menge');
define('QUOTES_QUOTE_TITLE3','Stückpreis');
define('QUOTES_QUOTE_TITLE4','Angebotspreis');

define('FS_WHAT_IS_DIFFERENCE', "Produktvergleich");
define('FS_AVAILABILITY', 'Status');
define('FS_ON_SALE', 'Verfügbar');
define('FS_END_SALE', 'Nicht verfügbar');
define('FS_DIFFERENCES', 'Bitte prüfen Sie sorgfältig die Parameter der Produkte und deren Unterschiede, bevor Sie einen Kauf tätigen.');

define('FS_CN_LIMIT_TIPS', 'Dieses Artikel kann nicht nach China geliefert werden.');
define('QUOTE_MESSAGE_TXT_1', 'Zusätzliche Anmerkungen (von '. $_SESSION['customer_first_name'].')');
define('QUOTE_MESSAGE_TXT_2', 'Zusätzliche Anmerkungen (vom Account Manager | FS)');
