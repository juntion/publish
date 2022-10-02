<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: login.php 14280 2009-08-29 01:33:18Z drbyte $
 */

define('NAVBAR_TITLE', 'Anmelden');
define('HEADING_TITLE', 'Willkommen, bitte melden Sie sich an');

define('HEADING_NEW_CUSTOMER', 'Neuer Kunde? Bitte geben Sie uns Ihre Zahlungsinformationen');
define('HEADING_NEW_CUSTOMER_SPLIT', 'Neuer Kunde');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Errichten Sie ein Kundeprofil bei <strong>' . STORE_NAME . '</strong> damit werden Sie ermöglicht, schneller zu kaufen, den Status Ihrer gegenwärtigen Bestellungen zu verfolgen, Ihre vorherigen Bestellungen anzuschauen.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'Haben Sie ein PayPal Konto? Möchten Sie mit einer Kreditkarte schnell zahlen? Wählen Sie die Auswahl von Express Checkout durch ein Klicken auf den Knopf darunter.');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">Oder</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'Errichten Sie ein Kundeprofil bei <strong>' . STORE_NAME . '</strong> damit werden Sie ermöglicht, schneller zu kaufen, den Status Ihrer gegenwärtigen Bestellungen zu verfolgen, Ihre vorherigen Bestellungen anzuschauen und weitere Günstigkeiten für Mitglieder zu genießen.');

define('HEADING_RETURNING_CUSTOMER', 'Wiederholungskäufer: Bitte einloggen');
define('HEADING_RETURNING_CUSTOMER_SPLIT', 'Wiederholungskäufer');

define('TEXT_RETURNING_CUSTOMER_SPLIT', 'Um den Auftrag fortzuführen, melden Sie sich bitte zu Ihrem <strong>' . STORE_NAME . '</strong> Konto an.');

define('TEXT_PASSWORD_FORGOTTEN', 'Haben Sie Ihr Passwort vergessen?');

define('TEXT_LOGIN_ERROR_NO_RECORD', 'Fehler: Entschuldigung, es gibt keine entsprechende E-Mailadresse! Wenn Sie schon angemeldet haben, prüfen Sie bitte noch einmal nach! Ansonsten können Sie ein neues Konto rechts anlegen!');define('TEXT_LOGIN_ERROR_PASSWORD_NOT_MATCH', 'Fehler: Entschuldigung, Ihr Passwort ist nicht richtig, bitte prüfen Sie noch einmal!');
define('TEXT_VISITORS_CART', '<strong>Notiz:</strong> Falls Sie schon mal bei uns eingekauft haben und es noch etwas im Einkaufswagen gibt, werden sich alle Produkte der Einfachheit halber vereinigen, wenn Sie sich wieder angemeldet haben. <a href="javascript:session_win();">[Mehr Info]</a>');

define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">Datenschutzerklärung</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">Bitte erkennen Sie Unsere Datenschutzerklärung durch ein Klicken auf den folgenden Knopf an. Die Datenschutzerklärung ist </span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">hier</span></a> zu lesen.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">Ich haben die Datenschutzerklärung gelesen und bin damit einverstanden. </span>');

define('ERROR_SECURITY_ERROR', 'Es gibt einen Sicherheitsfehler während des Verlaufes vom Anmelden.');

define('TEXT_LOGIN_BANNED', 'Fehler: Zugang verweigert.');




/************BOF LOGIN LANGUAGE****************/


define('TEXT_SIGN_REGIST','Anmelden oder ein neues Konto anlegen');

define('TEXT_SIGN_FIBERSTORE','Anmelden zu Fiberstore:');

define('TEXT_EMIAL','E-Mail:');

define('TEXT_PASSWORD','Passwort:');

//define('TEXT_LOGIN_MSG','Please make sure you filled out your email.');
define('TEXT_LOGIN_MSG','Die von Ihnen eingegebene E-Mailadresse ist ungültig. Bitte prüfen Sie nach und geben Sie sie noch einmal ein.');
define('TEXT_LOGIN_ENTER','Bitte geben Sie eine E-Mailadresse ein.');
//define('TEXT_PASSWORD_MSG','Your password must be at least 7 characters long.');
define('TEXT_PASSWORD_MSG','Ihr Passwort muss mindestens 7 Schriftzeichen enthalten.');
define('TEXT_PASSWORD_ENTER','Bitte geben Sie Ihr Passwort ein.');

define('TEXT_FORGET_PSD','Haben Sie Ihr Passwort vergessen?');

define('TEXT_LOGIN_PLACE','Bestellungen online aufgeben');

define('TEXT_LOGIN_TRACK','Ihre Bestellungen online verfolgen');

define('TEXT_LOGIN_VIEW','Ihre Auftragshistorie anschauen');

define('TEXT_LOGIN_CREATE','Favoriten, Wunschzettel und so weiter errichten!');

define('TEXT_LOGIN_MAKE','Mit Hilfe des Wunschzettels ein Projekt-Budget machen');

define('TEXT_LOGIN_TECHNICAL','Technische Teamunterstützung');

define('TEXT_LOGIN_HELP','Benötigen Sie Hilfe?');

define('TEXT_LOGIN_HELP_WITH','Ich benötige Hilfe bei');

define('TEXT_LOGIN_RETURNING','Ein Artikel zurückgeben');

define('TEXT_LOGIN_VIEW_THE','anzeigen');

define('TEXT_LOGIN_RMA','RMA Lösungen');

define('TEXT_LOGIN_PAGE','Kontaktieren Sie uns auf dieser Seite oder durch E-Mail');

define('TEXT_LOGIN_EMAIL','service.us@fs.com');

define('TEXT_LOGIN_CONTACT','Kontaktieren Sie uns');

define('TEXT_VIEW_FAQ','Sehen die Seite von FAQs');

define('TEXT_LOGIN_QUESTIONS','Haben Sie Probleme mit Auslieferung?');

define('TEXT_LOGIN_SHOP','Einkaufen mit Vertrauen');

define('TEXT_SHOPPING_ON','EINKAUFEN BEI FS.COM');

define('TEXT_IS_SAFE','IST ZUVERLÄSSIG UND GESICHERT.');

define('TEXT_LOGIN_GUARANTEED','GARANTIERT!');

define('TEXT_LOGIN_FIBERSTORE','Sie brauchen nichts zu zahlen,wenn Sie unautorisierte Rechnung wegen des Einkaufens bei fs.com in Kreditkarte erhalten.');

define('TEXT_LOGIN_SAFE','Zuverlässiges Einkaufen garantiert');

define('TEXT_LOGIN_INFORMATION','Alle Informationen sind durch das Secure Sockets Layer (SSL) Protokoll ohne Risiko verschlüsselt und gesendet.');

define('TEXT_LOGIN_PROTECT','Wie schützen wir Ihre privaten Daten?');

define('TEXT_LOGIN_FREE','Lieferung und Rückgabe sind kostenlos');

define('TEXT_LOGIN_UNSA','Wenn Sie unzufrieden mit dem bei FiberStore Co.Ltd gekauften Artikel sind, können Sie den Artikel in ihrer Originalbedingung innerhalb sieben Tagen für eine Erstattung zurückgeben. Wir werden auch für die Lieferung der Rücksendung zahlen!');

define('TEXT_LOGIN_DELIVER','FiberStore liefert eine lebenslange Garantie als ein standardmäßiges Merkmal für alle Hauptproduktlinien, um eine sorgefreie Operation zu bieten und die Reparaturkosten außerhalb der Garantiezeit zu beseitigen.');

define('TEXT_LOGIN_MORE','Mehr erfahren?');

define('TEXT_LOGIN_OR','Oder');

define('TEXT_LOGIN_CASE','Für Passwort achten Sie bitte unbedingt auf Groß-/Kleinschreibung');







define('ACCOUNT_FOOTER_TITLE','Einkaufen mit Vertrauen');

define('ACCOUNT_FOOTER_SHOPPING','EINKAUFEN BEI FS.COM ');

define('ACCOUNT_FOOTER_SECURE','IST ZUVERLÄSSIG UND GESICHERT.');

define('ACCOUNT_FOOTER_PAY','Sie brauchen nichts zu zahlen,wenn Sie unautorisierte Rechnung wegen des Einkaufens bei fs.com in Kreditkarte erhalten.');

define('ACCOUNT_FOOTER_SAFE','Zuverlässiges Einkaufen garantiert');

define('ACCOUNT_FOOTER_INFORMATION','Alle Informationen sind durch das Secure Sockets Layer (SSL) Protokoll ohne Risiko verschlüsselt und gesendet.');

define('ACCOUNT_FOOTER_HOW','Wie schützen wir Ihre privaten Daten?');

define('ACCOUNT_FOOTER_FREE','Lieferung und Rückgabe sind kostenlos');

define('ACCOUNT_FOOTER_SHOP','Wenn Sie unzufrieden mit dem bei FiberStore Co.Ltd gekauften Artikel, können Sie den Artikel in ihrer Originalbedingung innerhalb sieben Tagen für eine Erstattung zurückgeben. Wir werden auch für die Lieferung der Rücksendung zahlen!');

define('ACCOUNT_FOOTER_DELIVER','FiberStore liefert eine lebenslange Garantie als ein standardmäßiges Merkmal für alle Hauptproduktlinien, um eine sorgefreie Operation zu bieten und die Reparaturkosten außerhalb der Garantiezeit zu beseitigen.');

define('ACCOUNT_FOOTER_LEARN','Mehr erfahren?');

/***********EOF LOGIN LANGUAGUE***************/























































