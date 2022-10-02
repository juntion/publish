<?php
/****************************公共头部***********************************/
define('EMAIL_HEAHER_RIGHT', '+49 (0) 8165 80 90 517');
define('EMAIL_MENU_HOME','Live Chat');
define('EMAIL_MENU_SUPPORT','mit Berater');
define('EMAIL_HOME_URL','http://www.fs.com/de/');


/****************************公共底部****************************************/
define('EMAIL_SUPPORT_URL','Facebook');
define('EMAIL_MENU_TUTORIAL','Twitter');
define('EMAIL_TUTORIAL_URL','Kontakt ');
define('EMAIL_MENU_ABOUT_US','Mein Konto');
define('EMAIL_ABOUT_US_URL','Einkaufshilfe');
define('EMAIL_MENU_SERVICE','Datenschutz');
define('EMAIL_SERVICE_URL','Dies ist eine automatisch erstellte E-Mail. Antworten Sie bitte nicht.');
define('EMAIL_MENU_CONTACT_US','kontaktieren ');
define('EMAIL_CONTACT_US_URL','FS.COM');
define('EMAIL_MENU_PURCHASE_HELP','  Alle Rechte vorbehalten.');
define('EMAIL_PURCHASE_HELP_URL','http://www.fs.com/de/how_to_buy.html');
define('EMAIL_FOOTER_PROMPT','https://www.fs.com/de/index.php?main_page=my_dashboard');
define('EMAIL_FOOTER_FS_COPYRIGHT',zen_href_link('fs_single_pages','name=privacy_policy','SSL'));
define('EMAIL_FOOTER_FS_CONTACT','http://www.fs.com/de/contact_us.html');

// fairy add
define('EMAIL_FOOTER_FACEBOOK','FS.COM Facebook');
define('EMAIL_FOOTER_TWITTER','Twitter');
// fairy add 2017.11.28
define('EMAIL_FOOTER_SINCERELY','Mit freundlichen Grüßen');
define('EMAIL_FOOTER_FS_SERVICE','<a href="'.HTTPS_SERVER.'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Service-Team');

/**************************************content common text**************************************/
define('EMAIL_BODY_COMMON_FSCOM','FS.COM');
define('EMAIL_BODY_COMMON_DEAR','Hallo');
define('EMAIL_BODY_COMMON_THANKS','Mit freundlichen Grüßen');
define('EMAIL_BODY_COMMON_PHONE','Telefon : ');
define('EMAIL_BODY_COMMON_PARTNER','Partner');
define('EMAIL_BODY_COMMON_URL_BASE','http://www.fs.com/de');

/*
 *客户保留购物车产品，邮件发给自己
 */
define('FS_EMAIL_CART','Ihre Einkaufslisten bei FS.COM.');
define('FS_EMAIL_PAST','Sie haben einige Produkte bei ');
define('FS_EMAIL_FS','FS.COM');
define('FS_EMAIL_SAVED','durchgesehen und die Einkaufsliste gespeichert. Für mehr Produktinformationen klicken Sie bitte auf den folgenden Link');
define('FS_EMAIL_FSCOM','https://www.fs.com/de/');
define('FS_EMAIL_MESSAGE','Ihre Nachricht:');
define('FS_EMAIL_LIST','https://www.fs.com/de/index.php?main_page=save_shopping_list');
define('FS_EMAIL_SIN','Mit freundlichen Grüßen');
define('FS_EMAIL_TEAM','Kundenservice-Team');
define('FS_EMAIL_SENT','Diese E-Mail wurde von Ihnen selbst mit dem ');
define('FS_EMAIL_SHARE',' Teilen-Service gesendet. ');
define('FS_EMAIL_WERDEN','Sie werden keine unerwünschte Nachricht aus ');

define('FS_EMAIL_OUR'," erhalten. Erfahren Sie mehr über unseren ");
define('FS_EMAIL_POLICY',"Datenschutz");
define('EMAIL_CUSTOMER_SHOPPING_LIST',"https://www.fs.com/de/index.php?main_page=share_shopping_list");
define('FS_EMAIL_TO_US_DEAR','Hallo ');
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','Eine Webseite aus FS.COM wurde mit Ihnen geteilt.');
/*
*客户分享购物车邮件（不同部分）
*/
define('FS_EMAIL_SENT_1','Diese E-Mail wurde aus ');
define('FS_EMAIL_CART_1','Ihr(e) Freund(e)');
define('FS_EMAIL_CARTS_1','hat eine Einkaufsliste mit Ihnen geteilt.');
define('FS_EMAIL_PAST_1',' dachte, dass Sie Interesse an den Produkten aus FS.COM haben. Hier ist die Liste für Sie. Für mehr Produktinformationen klicken Sie bitte auf den folgenden Link ');
define('FS_EMAIL_MESSAGE_1',"Nachricht:");
define('FS_EMAIL_THIS_1','Diese E-Mail wurde aus Ihren Freund gesendet');
define('FS_EMAIL_USING_1','per ');
define('FS_EMAIL_URL_1','http://www.fs.com/de/privacy_policy.html');

//标题
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT_1','FS.COM - Sie erhalten eine Einkaufsliste aus ');

// fairy add 2017.11.28
define('EMAIL_BODY_COMMON_PLATFORM','Platform');
define('EMAIL_BODY_COMMON_BROWSER','Browser');
define('EMAIL_BODY_COMMON_IP_ADDRESS','IP Adresse');
define('EMAIL_BODY_COMMON_UNKNOWN','Unbekannte');
define('EMAIL_BODY_COMMON_EAMIL_USER','Sicherheitsinformationen verwendet: ');
define('EMAIL_BODY_COMMON_EAMIL_COUNTRY','Land / Region');
define('EMAIL_BODY_COMMON_CUSTOMER_NAME','Customer Name: ');
define('EMAIL_BODY_COMMON_CUSTOMER_EMAIL','E-Mail des Kunden: ');

/*********************************contact us to customer*************************************/
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1','Wir haben Ihre Frage erhalten. Sie werden eine Antwort innerhalb von 12 Stunden bekommen. Überprüfen Sie auch Ihre Spam, wenn Sie die Antwort innerhalb von 24 Stunden nicht erhalten.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT2','Brauchen Sie schnelle Hilfe? Überprüfen Sie die FAQ, können Sie vielleicht hier die Antworten finden.<br>Oder wenden Sie sich an professionelle Handelsvertreter oder den Kundendienst für die Unterstützung. Wir sind immer bereit, um Ihre Frage zu beantworten.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT3','Mo-Fr.: 8:00- 17:00 Uhr '.FS_PHONE_DE);
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT4','PS. Antworten Sie bitte NICHT per Antwort-Button in Ihrem E-Mail-Programm. Dies ist eine automatisch erstellte E-Mail.');
define('EMAIL_CONTACT_US_TO_SUBJECT','Wir freuen uns über Ihre Nachricht  -- Ihr FS-Service-Team');

/************************************regist to customer*********************************************/
define('EMAIL_REGIST_TO_CUSTOMER_SUBJECT','Herzlichen Glückwunsch, Sie haben ein neues Konto bei FS.COM');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT1','Herzlichen Glückwunsch. Sie haben sich erfolgreich bei FS.COM als Kunde registriert und wir richten gerne für Sie ein Kundenkonto ein.<br />Ihr Benutzername in Form Ihrer E-Mail-Adresse lautet:');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT2','Mit Ihrem Kundenkonto können Sie ab sofort folgende Services nutzen:<br />
1. Online-Shopping<br />
2. Verschiedene Zahlungsmethoden nutzen<br />
3. Bestellstatus verfolgen<br />
4. Online-Support nach Kauf nutzen<br />
5. Kontoinformationen verwalten  <br />
<br />
Sie können jetzt Ihre Kontoinformationen vervollständingen und mit Ihrem Konto in unserem Online-Shop einkaufen.');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT3','Tipp: Sollte unsere E-Mail in Ihren Spam-Filter verschoben worden sein, setzen Sie einfach unsere E-Mail-Adresse sales@fs.com auf die Liste der vertrauenswürdigen Absender.
<br />
FS.COM, Nova Gewerbepark, Gebäude 7, Am Gfild 7, 85375 Neufahrn b. München, Deutschland <br />
Telefon: +49 8165 9904 326<br />');

//fairy
// 个人、企业激活邮件内容
define('EMAIL_REGIST_COMMON_VERIFY_EMAIL','Verifizierungsmail');
define('EMAIL_REGIST_COMMON_VERIFYT_TITLE2','Wenn der Link nicht funktioniert, versuchen Sie, diese URL in der Adressleiste Ihres Browsers zu kopieren:');
define('EMAIL_REGIST_COMMON_VERIFYT_TIME','Die Laufzeit des Linkes ist 3 Tage.');
define('EMAIL_REGIST_COMMON_SINCERELY','Mit freundlichen Grüßen');
define('EMAIL_REGIST_COMMON_FS','Ihr FS-Service-Team');
// 个人、企业激活邮件内容
define('EMAIL_REGIST_TO_CUSTOMER_THANK','Vielen Dank für die Einstellung Ihres Kontos bei FS.COM.');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO','Ein Konto bei FS.COM, um die Vorteile nutzen zu können:');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO_DES','<li>Bestellstatus online einsehen</li>
                  <li>Auftragshistorie verwalten</li>
                  <li>Professionelle Sonderanfertigungen</li>
                  <li>Rabatt und Zusatzinformationen erhalten</li>');
define('EMAIL_REGIST_TO_CUSTOMER_VERIFYT_TITLE','Um die Vorteile nutzen zu können, verifizieren Sie Ihre E-Mail-Adresse, indem Sie auf den folgenden Link klicken.');
// 企业激活邮件
define('EMAIL_REGIST_TO_COMPANY_THANK','Vielen Dank, dass Sie sich um ein Geschäftskonto bei FS.COM beworben haben.');
define('EMAIL_REGIST_TO_COMPANY_INTRO','Ihr Antrag wird derzeit überprüft. Wir werden Ihnen innerhalb von 24 Stunden eine E-Mail über das Ergebnis senden.');
define('EMAIL_REGIST_TO_COMPANY_VERIFYT_TITLE','Um die Einstellung Ihres Kontos abzuschließen, verifizieren Sie bitte Ihre E-Mail-Adresse, indem Sie auf den folgenden Link klicken.');
define('EMAIL_REGIST_TO_COMPANY_THANK_AGAIN','Wir danken Ihnen für Ihre Kooperation und Ihr Vertrauen.');
// 个人用户升级企业用户邮件
define('EMAIL_UPGRADE_TO_COMPANY_CONSULT','Wenn Sie irgendwelche Frage haben, zögern Sie bitte nicht, <a href="http://www.fs.com/de/contact_us.html" style="color:#0070BC; text-decoration:none;">uns zu kontaktieren</a>.');
define('FS_SUBMIT_SUB1','Absenden');

//fairy 个人注册
define('EMAIL_REGIST_TO_CUSTOMER_THANK_AGAIN','Jetzt können Sie sich anmelden. Wenn Sie weitere Hilfe benötigen, wenden Sie sich bitte <a href="http://www.fs.com/de/contact_us.html" style="color:#0070BC; text-decoration:none;">an uns.</a>');

/***************************** password forgotten to customer ***************************************/
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_SUBJECT','FS.COM - Neues Passwort');

// fairy 2017.11.28
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TITLE','Wie setzt man das Passwort für <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>-Konto zurück?');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT1','Nach Ihrer Anforderung haben wir Ihnen das Email gesendet, um Ihr Passwort für <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>-Konto zu ändern.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT2','Klicken Sie auf den folgenden Link, um zur <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>-Site zu gehen und Ihr Passwort zurückzusetzen: ');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_RESET_BUTTON','Ihr Passwort zurücksetzen');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT3','Bitte beachten Sie, dass der oben genannte Link nur eine Lebensdauer von 3 Tagen hat.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT4','Wenn Sie diese Änderung nicht vorgenommen haben oder wenn Sie glauben, dass eine nicht autorisierte Person auf Ihr Konto zugegriffen hat, <a href="RESET_PWD_LINK" target="_blank" style="color:#0070BC; text-decoration:none;">setzen Sie Ihr Passwort sofort zurück</a>. Dann <a href="'.HTTPS_SERVER.'/login.html" target="_blank" style="color:#0070BC; text-decoration:none;">melden Sie sich an,</a> um Ihre Sicherheitseinstellungen zu überprüfen und zu aktualisieren.');

/***************************** 修改密码成功之后发的邮件 ***************************************/
// fairy 修改密码成功之后的邮件 add 2017.11.28
define('FS_PWD_UPDATE_SUCCESS_EAMIL_THEME','FS.COM - Konto-Passwort geändert');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_TITLE','Ihr Passwort wurde erfolgreich geändert.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON1','Das Passwort für Ihre <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) wurde erfolgreich geändert <b>EMAIL_TIME</b>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_USER','Ihr neues Passwort: ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_COUNTRY','Land/Region: ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON2','Jetzt können Sie Ihr neues Passwort verwenden, um sich in Ihrem Konto anzumelden. Wenn Sie noch Fragen haben, zögern Sie bitte nicht, <a href="'.HTTPS_SERVER.'/contact_us.html" target="_blank" style="color:#0070BC; text-decoration:none;">uns zu kontaktieren</a>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON3','Wenn Sie diese Änderung nicht vorgenommen haben oder wenn Sie glauben, dass eine nicht autorisierte Person auf Ihr Konto zugegriffen hat, <a href="'.HTTPS_SERVER.'/password_forgotten.html" target="_blank" style="color:#0070BC; text-decoration:none;">setzen Sie Ihr Passwort sofort zurück</a>. Dann <a href="'.HTTPS_SERVER.'/login.html" target="_blank" style="color:#0070BC; text-decoration:none;">melden Sie sich an,</a> um Ihre Sicherheitseinstellungen zu überprüfen und zu aktualisieren.');


/**************************************** company_regist *****************************************************/
define('EMAIL_COMPANY_REGIST_SUBJECT','Bewerbung um Geschäftskonto von Fiberstore');
define('EMAIL_COMPANY_REGIST_TEXT1','Vielen Dank für Ihre Bewerbung um das Geschäftskonto, um mehr Zusammenarbeit von Unternehmen zu bauen. <br><br>
Die Bewerbung ist in der Prüfung und wir werden Ihnen eine E-Mail innerhalb von 48 Stunden über das Ergebnis senden, sobald die Bewerbung der Firmenmitgliedschaft verifiziert wurde.');
define('EMAIL_COMPANY_REGIST_TEXT2','Mit freundlichen Grüßen,');
define('EMAIL_COMPANY_REGIST_TEXT3','Ihr FS-Service-Team');

/********************************************* checkout common ****************************************************************/
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT','Fiberstore Bestellung# %s ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_NO','Bestellnummer');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDERED_ON','Bestelldatum:');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_BILL_TO','Rechnungsadresse');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PAYMENT_METHOD','Zahlungsmethode');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO','Lieferadresse');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_VIA','Zustellung durch');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_NAME','Artikel');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FSID','FS ID#');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_PRICE','Preis/Stück');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_QTY','Anz.');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PRICE','Gesamtpreis');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBTOTAL','Zwischensumme');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_CHARGE','Versandkosten');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_GRAND_TOTAL','Endsumme');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FS_SKU','FS SKU#');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_PAYPAL','PayPal');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_CARD','Kredit- / Debitkarte');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER','Bestellung verwalten');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY','Bestellzusammenfassung');

/***************************************checkout_westernunion_or_wiretransfer*************************************************/
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT1','Häufig gestellte Fragen');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT2','Wann kann ich meine Bestellung erhalten?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT3','Sobald erhalten wir Ihren Betrag, werden Ihre Bestellung sofort verpackt und nach dem Bestimmungsort versendet.
			Sie können diesen Status der Bestellung jederzeit in Meinen Bestellungen überprüfen. Für Details in Bezug auf die Verarbeitung und Lieferzeiten, kontaktieren Sie uns bitte.
			Für alle weiteren Fragen finden Sie auf unserer FAQ.');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT4','Wie kann ich mit Ihnen Kontakt aufnehmen?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT5','Für jede Hilfe, bitte senden Sie uns eine E-Mail an <a target="_blank" href="mailto:sales@fs.com" style="color:#3E6EC1;">sales@fs.com</a>
      oder rufen Sie uns an <a style="color:#363636;" target="_blank" value="+49 8165 9904 326">+49 8165 9904 326</a> oder klicken Sie auf Live-Chat, auf Linie zu chatten oder eine Nachricht hinterlassen, werden wir es innerhalb von 12 Stunden behandeln. ');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WESTERN_UNION','Vielen Dank für Ihren Einkauf bei FiberStore! Wir haben Ihre Bestellung erhalten und warten auf Zahlungsbestätigung.<br>

							Bitte besuchen Sie <a target="_blank" href="http://www.fs.com/de/manage_orders.html" style="color:#363636;">Meine Bestellungen</a> um unsere Kontoinformation der Western Union zu erfahren, wenn Sie die Kontoinformation während des Zahlungsprozesses nicht aufgeschrieben haben .<br><br>

							Ihre Zahlungsbestätigung der Western Union einreichen

							Sobald Sie Ihre Transaktion der Western Union abgeschlossen haben, senden Sie bitte uns die MTCN Nummer an <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> oder klicken Sie auf den folgenden Link, die Transaktionsdetails einzureichen: <a target="_blank" href="$URL" style="color:#363636;">Klicken Sie, Ihre Transaktionsdetails einzureichen </a>

							Wir können Ihre Bestellung nicht bearbeiten, bis Ihren Betrag erhalten wurde. Sobald den Betrag erhalten worden ist, werden wir ein E-Mail der Zahlungsbestätigung senden und dann beginnen, Ihre Bestellung zu verarbeiten.<br>

							Brauchen Sie weitere Hilfe für die Bezahlung Ihrer Bestellung? Kontaktieren Sie uns einfach an <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> für Hilfe. Wir werden Ihnen eine Rückantwort innerhalb von 12 Stunden geben.<br>');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WIRE_TRANSFER','<p>Vielen Dank für Ihren Einkauf bei FiberStore! Wir haben Ihre Bestellung erhalten und warten auf Zahlungsbestätigung.<br>

      Bitte besuchen Sie <a target="_blank" href="http://www.fs.com/de/manage_orders.html" style="color:#363636;">Meine Bestellungen</a> um unsere Kontoinformation zu erfahren, Wenn Sie die Kontoinformation während des Zahlungsprozesses nicht aufgeschrieben haben .</p>

      <p>Ihre Zahlungsbestätigung der Banküberweisung einreichen<br>

        Sobald Sie Ihre Transaktion der Banküberweisung abgeschlossen haben, senden Sie bitte uns die Transaktionsnummer der Banküberweisung  an <a target="_blank" href="mailto:service.us@fs.com" style="color:#363636;">service.us@fs.com</a> oder klicken Sie auf den folgenden Link, die Transaktionsnummer einzureichen: <a target="_blank" href="$URL" style="color:#363636;">Klicken Sie, Ihre Transaktionsnummer einzureichen </a><br>

        Wir können Ihre Bestellung nicht bearbeiten, bis Ihren Betrag erhalten wurde. Sobald den Betrag erhalten worden ist, werden wir ein E-Mail der Zahlungsbestätigung senden und dann beginnen, Ihre Bestellung zu verarbeiten.</p>

      <p>Brauchen Sie weitere Hilfe für die Bezahlung Ihrer Bestellung? Kontaktieren Sie uns einfach an <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> für Hilfe. Wir werden Ihnen eine Rückantwort innerhalb von 12 Stunden geben.</p>');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER','<p>Vielen Dank für Ihren Einkauf bei uns. Hier ist die Details Ihrer Bestellung: </p>');

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT1","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Bitte gehen Sie auf die Seite von <a  href='http://www.fs.com/de/index.php?main_page=manage_orders'>'Meine Bestellungen'</a> , um die PO-Datei hochzuladen, falls Sie dies noch nicht getan haben. Wir können Ihre Bestellung nicht verarbeiten, bis Ihre PO-Datei bestätigt wurde. </p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT2","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Wenn Sie irgendwelche Frage nach Ihrer Bestellung haben, kontaktieren Sie uns unter <a target='_blank' href='http://sales@fs.com'>sales@fs.com</a> . Wir werden Ihnen eine Antwort innerhalb 12 Stunden geben.</p>");
/************************************* checkout paypal or credit card ****************************************/
define('EMAIL_CHECKOUT_PAYPAL_TEXT1','Bestellung erhalten, auf Zahlungsbestätigung wartend');
/*************************************** checkout payment success ******************************/
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TEXT1','Vielen Dank für Ihren Einkauf bei Fiberstore. Wir haben den Betrag erhalten und werden Ihre Bestellung so schnell wie möglich versenden. Wenn Sie irgendwelche Fragen haben, zögern Sie nicht <a href="http://www.fs.com/de/customer_service.html" target="_blank">uns zu kontaktieren</a>.');

/*********************************** orders status *************************************/
define('EMAIL_ORDERS_STATUS_SUBJECT','Bestellung aktualisieren # ');
define('EMAIL_ORDERS_STATUS_FOR_ORDER','Für Bestellnummer:');
define('EMAIL_ORDERS_STATUS_TEXT1','der Status wird geändert. Bitte gehen Sie zu <a href="http://www.fs.com/de/index.php?main_page=account_history_info&orders_id=$ORDER_ID">Meiner Bestellungen</a> auf www.fs.com, die Details zu überprüfen.');
define('EMAIL_ORDERS_STATUS_TEXT2','Für jede Hilfe, bitte senden Sie uns eine E-Mail an	sales@fs.com oder rufen Sie uns an +49 8165 9904 326. Wir werden es innerhalb von 12 Stunden behandeln.');
define('EMAIL_ORDERS_STATUS_TEXT3','Vielen Dank für Ihre alle Unterstützung.');
define('EMAIL_ORDERS_STATUS_TEXT4','Mit freundlichen Grüßen');
define('EMAIL_ORDERS_STATUS_TEXT5','Ihr FS-Service-Team');

/************************************** sales manager to customer *********************************************/
define('EMAIL_SALES_MANAGER_SUBJECT','Administrator weist einen Einkaufsberater für Sie bei -- FS.COM');
define('EMAIL_SALES_MANAGER_TEXT1','Schönen Tag! <br><br>Vielen Dank für Ihren Besuch bei Fiberstore. ');
define('EMAIL_SALES_MANAGER_TEXT2','Ich bin');
define('EMAIL_SALES_MANAGER_TEXT3','Ihre Handelsvertreterin. ');
define('EMAIL_SALES_MANAGER_TEXT4','Falls Sie irgendwelche Bedürfnisse oder Fragen zu unseren Produkten oder anderen verwandten Informationen über Fiberstore haben,zögern Sie nicht, uns zu kontaktieren. Es ist mir eine Freude, mit Ihnen behilflich zu sein.<br><br><br>
			<span style="font-family:Calibri;font-size:13px;">Hier ist meine Kontaktinformation:</span>');
define('EMAIL_SALES_MANAGER_TEL','Tel.: ');
define('EMAIL_SALES_MANAGER_MOBILE','Handy: ');
define('EMAIL_SALES_MANAGER_EMAIL','Email: ');
define('EMAIL_SALES_MANAGER_TEXT5','(12/7 Vertrieb &amp; Support)');
define('EMAIL_SALES_MANAGER_TEXT6','<span style="font-family:Calibri;font-size:13px;">Building 7, NOVA Neufahrn Gewerbepark, Am Gfild 1-11, 85375, Neufahrn bei Freising, München, Deutschland</span>');
define('EMAIL_SALES_MANAGER_TEXT7','Mit freundlichen Grüßen');

/************************************ backend common *********************************************/
//update orders status 
define('EMAIL_BACKEND_COMMON_PAYMENT_RECEIVED',' Zahlung erhalten');
define('EMAIL_BACKEND_COMMON_YOUR_ORDER','Ihre Bestellung:');
define('EMAIL_BACKEND_COMMON_TEXT1','Der Status wurde aktualisiert zu:');
define('EMAIL_BACKEND_COMMON_TRACK_INFORMATION','Track-Informationen:');
define('EMAIL_BACKEND_COMMON_PROCESSING',' Verarbeitung');
define('EMAIL_BACKEND_COMMON_TRACKING_INFO',' Tracking-Informationen');
define('EMAIL_BACKEND_COMMON_TEXT2',' Alle Produkte Ihrer Bestellung versandt wurde. Die Lieferung dauert 3-4 Werktage. Sie können die Track-Informationen in Ihrem Konto bei FiberStore erhalten.');
define('EMAIL_BACKEND_COMMON_SHIPPING_METHOD','Versandmethode:');
define('EMAIL_BACKEND_COMMON_TACKINF_NUMBER','Sendungsnummer:');
define('EMAIL_BACKEND_COMMON_TEXT3','versendet wurde.');
define('EMAIL_BACKEND_COMMON_REFUNDED',' Zurückerstattet');
define('EMAIL_BACKEND_COMMON_IS_CANCELED',' wird storniert');
define('EMAIL_BACKEND_COMMON_CANCELED','Storniert');
define('EMAIL_BACKEND_COMMON_COMPLETED',' Fertiggestellt');
define('EMAIL_BACKEND_COMMON_NO_INFO','keine Informationen');
define('EMAIL_BACKEND_COMMON_TEXT4','Tipps: Für Detail, bitte melden Sie Ihr Konto auf Fiberstore an. Wenn Sie irgendeine Frage haben, bitte');
//reviews to customer
define('EMAIL_BACKEND_COMMON_REVIEWS_REPLY_SUBJECT','Neue Antwort zur Bewertung aus Fiberstore.');
define('EMAIL_BACKEND_COMMON_YOUR_REVIEW','Ihre Bewertung:');
define('EMAIL_BACKEND_COMMON_PRODUCTS_NAME_URL','Name der Produkte|Bewertung URL:');
define('EMAIL_BACKEND_COMMON_REPLY_BY','Antwort auf:');
define('EMAIL_BACKEND_COMMON_REPLY_CONTENT','Inhalt der Antwort:');

/*********************************** business account success to customer *************************************************/
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_SUBJECT','Ihr Antrag des Geschäftskontos wurde akzeptiert.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT1','Herzlichen Glückwunsch, Ihr Antrag für das Geschäftskonto wurde akzeptiert.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT2','Mit dem Geschäftskonto würden Sie jetzt die folgenden Dienste genießen:');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT3','1. Rabatt jeder Bestellung genießen<br>
        2. Die beste Versandart<br>
        3. Professionelle Handelsvertreter und technische Unterstützung<br>
        <br><br>Mit freundlichen Grüßen<br><br>
        Ihr FS-Service-Team');

/************************    customer question to customer     *********************/
define('EMAIL_CUSTOMER_QUESTION_TC_SUBJECT','Ihre Fragen wurden aufgegeben.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT1','Vielen Dank für Ihr Feedback der Fragen.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT2','Wir werden unser Bestes tun, um die Fragen zu lösen.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT3','Mit freundlichen Grüßen');
//西雅图发货延迟通知邮件 2017.8.2  ery
define('EMAIL_BODY_COMMON_TAX_NUMBER','MwSt. Identifikationsnummer');
define('ORDER_DELAY_TITLE','Produkte der Ihrer Express-Bestellung# sind auf Lager || FS.COM');
define('ORDER_DELAY_EMAIL_WE',"Vielen Dank für Ihre Bestellung %s bei FS.COM.");
define('ORDER_DELAY_EMAIL_THIS',"Das Produkt %s in Ihrer Bestellung ist gerade in unserem Lager angekommen. Unsere Abteilung für Qualitätsüberwachung braucht etwas Zeit, um die angekommende Produkte zu überprüfen. So wird es ein bisschen Verzögerung für Express-Versand am nächsten Werktag.");
define('ORDER_DELAY_EMAIL_PLEASE',"Nach der Überprüfung werden wir sofort versednen und Ihnen die Sendungsnummer senden. Bitte entschuldigen Sie die Unannehmlichkeiten!");
define('ORDER_DELAY_EMAIL_THANKS','Vielen Dank im Voraus für Ihre Geduld.');

// add by Aron
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT1','Bestellung# %s bei FS.com bestätigen');
define('EMAIL_CHECKOUT_COMMON_TO_PURCHASE_CUSTOMER_SUBJECT','Bestellung# %s bei FS.com');
/************************************* checkout purchase ****************************************/
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT3","<p style='color:rgb(51,51,51);margin:0;padding:0;'> Nochmals vielen Dank für Ihren Einkauf bei FS.com! </p>");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT4","<p style='color:rgb(51,51,51);margin:0;padding:0;'> FS.COM Kundenservice </p>");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START1","Vielen Dank für das PO-Dokument! Sie könnne das PO sehen in <a href='http://www.fs.com/de/index.php?main_page=manage_orders'  target='_blank'>'Meine Bestellung'</a>.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START2","Ihre Bestellung wird verarbeitet. Wir werden Ihnen die Sendungsnummer senden, nachdem Ihre Bestellung versandt wird.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START3","Falls Sie Fragen oder Anregungen haben oder weitere Informationen benötigen, können Sie gerne jederzeit direkt mit <a href='http://www.fs.com/de/contact_us.html'  target='_blank'>uns kontaktieren</a>.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START4","Mit freundlichen Grüßen");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START_NO","PO NO.  ");

// fairy 异地登录邮件 add 2017.11.28
define('FS_OFFSITE_LOGIN_EAMIL_THEME','FS.COM - Neue Aktivität Ihres Kontos');
define('FS_OFFSITE_LOGIN_EAMIL_TITLE','Neue Anmeldung auf EMAIL_USER_DEVICE');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT1','Ihr FS-Konto <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a> ist gerade auf einem neuen Gerät angemeldet.');
define('FS_OFFSITE_LOGIN_EAMIL_LOCATION','Ort');
define('FS_OFFSITE_LOGIN_EAMIL_TIME','Zeit');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT2','Wenn Sie diese Änderung nicht vorgenommen haben oder wenn Sie glauben, dass eine nicht autorisierte Person auf Ihr Konto zugegriffen hat, setzen Sie Ihr Passwort sofort zurück.');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT3','Wenn Sie noch Fragen haben, zögern Sie bitte nicht, <a href="'.HTTPS_SERVER.'/contact_us.html" target="_blank" style="color:#0070BC; text-decoration:none;">uns zu kontaktieren</a>.');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","Vielen Dank für Ihren Einkauf bei");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","Live Chat");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH","mit Berater");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","Mit freundlichen Grüßen");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","Hallo");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","Kundenservice-Team ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","Lieferadresse: ");
define("EMAIL_CHECKOUT_WAREHOUSE_BILLING","Rechnungsadresse: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","Wenn Sie noch Fragen zu Ihrer Bestellung haben, zögern Sie bitte nicht, ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","Ihre Auftrags-Nr.");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","wurde erfolgreich hochgeladen.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","Vielen Dank für Ihren Auftrag. Sie können jetzt die Bestellung einsehen und die Rechnung auf der Seite");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","Meine Bestellungen");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","ausdrucken.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","Versandkosten");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","Endsumme");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","Zwischensumme");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","Ihre Bestellung wird so schnell wie möglich bearbeitet. Wenn Sie noch Fragen zu Ihrer Bestellung haben, zögern Sie bitte nicht,");
//checkout_payment_success
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE','FS.COM - Bestellung %s Zahlung erhalten');
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Hier ist Ihre Zahlungsinformationen.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Wir haben Ihren Betrag für die Bestellung erhalten ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',' vielen Dank für Ihren Einkauf bei uns.');
//rma_success   售后单申请成功邮件
define('EMAIL_RMA_SUCCESS_APPROVED_YRR','Ihr RMA-Antrag # %s wurde genehmigt.');
define('EMAIL_RMA_SUCCESS_APPROVED_YOUR','Ihr RMA-Antrag # %s wurde genehmigt. Bitte folgen Sie dem Flussdiagramm online und senden Sie das Paket an die angegebene Adresse zurück.');
define('EMAIL_RMA_SUCCESS_APPROVED_WE','Wir werden die %s bearbeiten, sobald wir das Paket erhalten haben. Wenn Sie noch Fragen haben, zögern Sie bitte nicht, ');
define('EMAIL_RMA_SUCCESS_SUBMIT_YOUR','Ihr RMA-Antrag # %s wird geprüft.');
define('EMAIL_RMA_SUCCESS_SUBMIT_WE','Ihre zuständige Vertriebsmitarbeiterin werden Ihnen die weitere Informationen über den Prozess rechtzeitig mitteilen.');
define('EMAIL_RMA_SUCCESS_SUBMIT_FOR','Für sofortige Hilfe, zögern Sie nicht ');
define('EMAIL_RMA_SUCCESS_TITLE','FS.COM - RMA-Antrag # %s');
define('EMAIL_RMA_SUCCESS_APPROVED_CONTACT_US','uns zu kontaktieren');

// fairy 修改密码成功
define('FS_MODIFY_PWD_EAMIL_SUCCESS_THEME','FS.COM - Ihr Passwort wurde geändert');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_TITLE','Ihr Passwort wurde erfolgreich geändert.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT1','Das Passwort für Ihre <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) wurde erfolgreich geändert am <b>EMAIL_TIME</b>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT2','Jetzt können Sie Ihr neues Passwort verwenden, um sich in Ihrem Konto anzumelden. Wenn Sie noch Fragen haben, zögern Sie bitte nicht, <a href="'.HTTPS_SERVER.'/contact_us.html" target="_blank" style="color:#0070BC; text-decoration:none;">uns zu kontaktieren</a>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT3','Wenn Sie diese Änderung nicht vorgenommen haben oder wenn Sie glauben, dass eine nicht autorisierte Person auf Ihr Konto zugegriffen hat, <a href="'.HTTPS_SERVER.'/password_forgotten.html" target="_blank" style="color:#0070BC; text-decoration:none;">setzen Sie Ihr Passwort sofort zurück</a>. Dann <a href="'.HTTPS_SERVER.'/login.html" target="_blank" style="color:#0070BC; text-decoration:none;">melden Sie sich an</a>, um Ihre Sicherheitseinstellungen zu überprüfen und zu aktualisieren.');

// fairy 修改邮件成功
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_THEME','FS.COM - Ihre E-Mail-Addresse wurde geändert');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_TITLE','Ihre E-Mail-Addresse wurde erfolgreich geändert.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT1','Ihre E-Mail-Addresse wurde erfolgreich geändert am <b>EMAIL_TIME</b>. Ihre neue E-Mail-Adresse ist <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT2','Jetzt können Sie Ihre neue E-Mail-Adresse verwenden, um sich in Ihrem Konto anzumelden. Wenn Sie noch Fragen haben, zögern Sie bitte nicht, <a href="'.HTTPS_SERVER.'/contact_us.html" target="_blank" style="color:#0070BC; text-decoration:none;">uns zu kontaktieren</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT3','Wenn Sie diese Änderung nicht vorgenommen haben oder wenn Sie glauben, dass eine nicht autorisierte Person auf Ihr Konto zugegriffen hat, <a href="'.HTTPS_SERVER.'/password_forgotten.html" target="_blank" style="color:#0070BC; text-decoration:none;">setzen Sie Ihr Passwort sofort zurück</a>.  Dann <a href="'.HTTPS_SERVER.'/login.html" target="_blank" style="color:#0070BC; text-decoration:none;">melden Sie sich an</a>, um Ihre Sicherheitseinstellungen zu überprüfen und zu aktualisieren.');

// fairy 修改邮件给销售的
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_THEME','FS.COM - Die E-Mail-Adresse Ihres Kunden wurde geändert');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_TITLE','Ihr Kunde(CUSTOMER_NAME）hat seine E-Mail-Adresse geändert.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT1','Die E-Mail-Adresse Ihres Kunden(CUSTOMER_NAME）wurde erfolgreich geändert am <b>EMAIL_TIME</b>.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT2','Die alte E-Mail-Addresse ist OLD_EMAIL.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT3','Die neue E-Mail-Addresse ist NEW_EMAIL.');

// fairy 申请报价之后的邮件
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_THEME','FS.COM - Angebotsanfrage INQUIRY_NUMBER');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE','Ihre Anfrage INQUIRY_NUMBER wurde erhalten.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE_SALE','Sie haben eine neue Angebotsanfrage INQUIRY_NUMBER.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT1','Folgend können Sie die Details Ihrer Angebotsanfrage finden. Ihr Vertriebsmitarbeiter aus FS.COM wird sich in Kürze per E-Mail mit Ihnen in Verbindung setzen.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT2','Details Ihrer Angebotsanfrage');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT3','Wenn Sie ein registriertes Mitglied sind, können Sie die Angebotsdetails in <a href="'.HTTPS_SERVER.'/inquiry_list.html" style="color: #0070BC;">meinem Konto</a> verfolgen und überprüfen.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT4','Vielen Dank für Ihre Anfrage. Ihr Vertriebsmitarbeiter aus FS.COM wird sich in Kürze per E-Mail mit Ihnen in Verbindung setzen.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_RQ_NUMBER','Angebotsanfrage-Nr.');

//2017-12-7  add   ery 
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - Order %s received, please complete payment');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE_PO','FS.COM - Order %s received, waiting for PO confirmation');
define('EMAIL_CHECKOUT_PO','uploaded successfully');

//fairy 个人中心用户添加评论，给对应销售发的邮件
define('FS_PRODUCT_REVIEW_SUCCESS_SALE_EMAIL_THEME','Neue Kundenbewertung vom Produkt aus FS.');
define('FS_CUSTOMER_REVIEWS', 'Kundenbewertungen');
define('FS_REVIEWS_URL', 'Produktname|Bewertungen Url');
define('FS_REVIEW_RATING', 'Sterne');
define('FS_REVIEW_CONTENT', 'Inhalt der Bewertung');