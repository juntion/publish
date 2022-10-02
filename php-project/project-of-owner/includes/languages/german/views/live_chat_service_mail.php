<?php
/*tpl_live_chat_service_mail_default.php*/

//fallwind	2016.9.5	add
define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER1','Erhalten ein schnelles Angebot');	//Get a Quick Quote
define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER2','Um Sie schnell zu dienen, füllen Sie bitte und senden Sie die folgenden Informationen, so kann Ihre Frage Problem durch die richtige Abteilung lösen.'); //To help serve you quickly, please complete and submit the following information so your question/issue can be addressed by the proper department.
//define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER3','Ihre Nachricht an FS.COM ist erfolgreich. Vielen Dank!');	//Post your message to Fiberstore successfully, Thank you!
define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER3','Ihre Nachricht wurde übermittelt.');
define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER3_01','Wir werden Ihnen innerhalb von 12 bis 24 Stunden antworten.');
define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER4','Zurück');	//Back
define('FS_LIVE_CHAT_SERVICE_MAIL_HEADER5','Bitte füllen Sie die unten angeforderten Felder aus und unsere professionellen Vertrieb werden Sie bald innerhalb der nächsten 12 Stunden kontaktieren.');	//Please kindly fill in the requested fields below and our professional sales will contact you soon within next 12 hours.

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT1','Geben Ihren Namen ein:'); //Enter Your Name:
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT2','Bitte stellen Sie sicher, dass Sie Ihren Namen ausgefüllt haben.'); //Please make sure you filled in your name.

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT3','Ihre E-Mail-Adresse:'); //Your Email Address:
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT4','Entschuldigung, Sie wurden auf die schwarze Liste hinzugefügt!'); //Sorry,you have been added to the blacklist!
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT5','Die E-Mail-Adresse wird nicht erkannt.(Zum Beispiel: someone@example.com).'); //The email address you submitted is not recognized.(example: someone@example.com).

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT6','Ihr Land:'); //Your Country:
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT7','Bitte stellen Sie sicher, dass Sie Ihr Land wählen.'); //Please make sure you select your country.

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT8','Bezüglich :'); //Regarding :

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT9','Telefonnummer:'); //Phone Number:
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT10','Bitte geben Sie eine gültige Telefonnummer ein.'); //Please enter a valid phone number.
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT11','Ihre Telefonnummer muss mindestens 6 Ziffern lang sein.'); //Your phone number must be at least 6 digits.

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT12','Betreff der Nachricht:'); //Message Subject:

//define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT13','Kommentare/Fragen:'); //Comments/Question:
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT14','Der Inhalt muss mindestens 30 Zeichen lang sein.');//Please enter a question.
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT15','einreichen'); //Submit

define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT16','Bitte wählen Sie ein aus'); //Please select one
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT17','Bestellungen'); //Orders
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT18','Mengenpreis'); //Bulk Price
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT19','Bezahlung'); //Payment
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT20','Lieferzeit'); //Lead time
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT21','Garantie'); //Warranty
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT22','Nach dem Kauf'); //After-sale
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT23','Technologielösung'); //Technology Solution
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT24','Informationen der Produkte'); //Products Information
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT25','Allgemeine Informationen'); //General Information

define('FS_LIVE_CHAT_SERVICE_MAIL_FOOTER1','Copyright'); //Copyright
define('FS_LIVE_CHAT_SERVICE_MAIL_FOOTER2',' Alle Rechte vorbehalten.'); //All Rights Reserved.

define('FS_LIVE_CHAT_SERVICE_MAIL_CUSTOMER','Kundenservice');

//2017-10-12   ery   add  
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE','Serviceumfang');
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE_PLEASE','Bitte wählen Sie den Servicetyp');
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE1','Bestellung & Bezahlung');
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE2','Bestellstatus');
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE3','After-Sale-Service & Rücksendung');
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE4','Produkt- und technischer Support');

//2017-11-2  ERY  ADD 
define('FS_LIVE_CHAT_SERVICE_MAIL_CONTENT13','Frage / Anregung');
define('FS_MAIL_US','Uns ein Email senden');
define('FS_MAIL_PLEASE','Bitte füllen Sie die folgenden Informationen aus. Innerhalb 12 Stunden werden Sie eine Rückantwort aus FS.COM bekommen.');
define('FS_MAIL_NAME','Name');
define('FS_MAIL_EMAIL','E-Mail-Adresse');
define('FS_MAIL_COUNTRY','Land/Region');
define('FS_MAIL_TEL','Telefonnummer');
define('FS_MAIL_I','Ich akzeptiere den');
define('FS_MAIL_PRIVACY','Datenschutz von FS.COM');
define('FS_MAIL_OUR','Datenschutz von FS.COM verpflichtet sich, Ihre Privatsphäre zu schützen.');
define('FS_MAIL_AGREE_MSG','Bitte akzeptieren Sie den Datenschutz, um fortzufahren.');

define('FS_COMMON_PRIVACY_POLICY_ERROR','Bitte stimmen Sie unsere Datenschutzerklärung und AGB zu.');

//改版新增
define('FS_LIVE_CHAT_SUPPORT','Kundensupport von FS');
define('FS_LIVE_CHAT_CALL','Kontaktieren: <span id="country_telephone">##phone##</span>');
define('FS_LIVE_CHAT_ADVANTAGE_01','Einkaufshilfe');
define('FS_LIVE_CHAT_ADVANTAGE_DES_01','Direkte Auskunft zu Produktpreisen, Zahlung, Lieferung usw.');
define('FS_LIVE_CHAT_ADVANTAGE_02','Bestellhilfe');
define('FS_LIVE_CHAT_ADVANTAGE_DES_02','Unterstützung zum Bestellstatus, zu Retouren, Rechnungen oder anderen Problemen.');
define('FS_LIVE_CHAT_ADVANTAGE_03','Technischer Support');
define('FS_LIVE_CHAT_ADVANTAGE_DES_03','Unterstützung bei der Fehler-, Problembehebung oder maßgeschneiderten Lösungen.');
define('FS_LIVE_CHAT_ADVANTAGE_04','Produktberatung');
define('FS_LIVE_CHAT_ADVANTAGE_DES_04','Alle Antworten zu Produkte, Garantie, Datenblätter usw.');
define('FS_LIVE_CHAT_SUBJECT','Gegenstand');
define('FS_LIVE_CHAT_PLEASE','Gegenstand wählen');
define('FS_LIVE_CHAT_SERVICE_MAIL_TYPE5','Andere');
define('FS_LIVE_CHAT_PLACEHOLDER','Ihre Anmerkungen helfen FS bei schneller Antworten.');
define('FS_LIVE_CHAT_MUST_SELECT','Wählen Sie bitte einen Gegenstand.');
define('FS_LIVE_CHAT_SUBJECT_WIDTH_COLON','Gegenstand: ');

define('FS_SUBMIT_SUCCESS','Ihre Anfrage ##number## wurde erfolgreich übermittelt.');
define('FS_SUBMIT_SUCCESS_TIP_TXT','Wir werden Ihnen innerhalb von 1 bis 3 Stunden während Werktage antworten. Sie können die Anfrage auch online mit unserem Team besprechen und die Aktualisierungen auf der Seite „<a href="'.zen_href_link('my_cases').'" style="color:#0070bc;">Meine Fragen</a>“ in „Mein Konto“ verfolgen.');

