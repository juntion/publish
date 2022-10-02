<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 15405 2010-02-03 06:29:33Z drbyte $
 */

define('NAVBAR_TITLE', 'Ein Konto errichten');

define('HEADING_TITLE', 'Information meines Kontos');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTIZ:</strong> Wenn Sie ein Konto bei uns schon gehabt haben, loggen Sie bitte auf die <a href="%s">Seite von Einloggen</a> ein.');




// greeting salutation
define('EMAIL_SUBJECT', 'Willkommen zu' . STORE_NAME);
define('EMAIL_GREET_MR', 'Lieber Herr %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Liebe Frau %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Liebe/Lieber %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', 'Wir begrüßen Sie im Name von <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Gratulation! Die Details der unten aufgelisteten Rabatt-Gutscheine sind speziell für Sie erstellt, um Ihr Erlebnis bei dem nächsten Besuch in unserem online Laden besser zu machen' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'Um den Rabatt-Gutschein zu benutzen, geben Sie die' . TEXT_GV_REDEEM . ' Kode während der Zahlung:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Dieser Rabatt-Gutschein ist gültig für einen Betrag zwischen %s und %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Für Ihren Einkauf heute bei uns haben wir Ihnen ein' . TEXT_GV_NAME . ' gesandt für %s!' . "\n");
define('EMAIL_GV_REDEEM', 'Die ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' ist: %s ' . "\n\n" . 'Sie können die' . TEXT_GV_REDEEM . 'eingeben während Zahlung nach Ihrer Auswähle bei uns. ');
define('EMAIL_GV_LINK', ' Oder Sie können durch die gefolgte Verbindung einlösen : ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','Wenn Sie die ' . TEXT_GV_NAME . 'zu Ihrem Konto hinzugefügt haben, können Sie dann die' . TEXT_GV_NAME . ' selbst benutzen oder zu einem Freund senden. ' . "\n\n");

define('EMAIL_TEXT', 'Sie haben jeztz bei uns angemeldet und die Privilegien gehabt: Mit Ihrem Konto können Sie jetzt an <strong> verschiedenen Services </strong> teilnehmen. Einige Services davon enthalten:' . "\n\n<ul>" . '<li><strong>Bestellhistorie</strong> - Die Details der von Ihnen erledigten Bestellungen bei uns anzeigen.' . "\n\n" . '<li><strong>Permanenter Einkaufswagen</strong> - Jedes von Ihnen zu Ihrem online Einkaufswagen hinzugefügtes Produkt wird dort bleiben, bis Sie es beseitigen oder Sie für es zahlen.' . "\n\n" . '<li><strong>Adressebuch</strong> - Wir können die gekaufte Produkte zu Ihrer oder einer anderen Adersse senden! Das ist perfekt für eine Methode, wenn man jemandem ein Geburtstagsgeschenk direkt schicken möchte. ' . "\n\n" . '<li><strong>Kommentare der Produkte</strong> - Bitte teilen Sie Ihre Meinungen über unsere Produkte mit anderen Kunden.' . "\n\n</ul>");
define('EMAIL_CONTACT', 'Wenn Sie Hilfe mit irgendwelchen online Services von uns benötigen, schicken Sie eine E-Mail zum Ladenbesitzer: <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE', "\n" . 'Mit freundlichen Grüßen,' . "\n\n" . STORE_OWNER . "\nStore Owner\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Diese E-Mailadresse ist von Ihnen oder einer unserer Kunden gegeben. Wenn Sie nicht für ein Konto angemeldet haben, oder wenn es Ihrer Meinung nach ein Fehler ist, schicken Sie bitte eine E-Mail an %s ');
