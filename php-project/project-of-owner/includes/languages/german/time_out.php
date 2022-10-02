<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

// define('NAVBAR_TITLE', 'Login Time Out');
// define('HEADING_TITLE', 'Whoops! Your session has expired.');
// define('HEADING_TITLE_LOGGED_IN', 'Whoops! Sorry, but you are not allowed to perform the action requested. ');
// define('TEXT_INFORMATION', '<p>If you were placing an order, please login and your shopping cart will be restored. You may then go back to the checkout and complete your final purchases.</p><p>If you had completed an order and wish to review it' . (DOWNLOAD_ENABLED == 'true' ? ', or had a download and wish to retrieve it' : '') . ', please go to your <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">My Account</a> page to view your order.</p>');

// define('TEXT_INFORMATION_LOGGED_IN', 'You are still logged in to your account and may continue shopping. Please choose a destination from a menu.');

// define('HEADING_RETURNING_CUSTOMER', 'Login');
// define('TEXT_PASSWORD_FORGOTTEN', 'Forgot Your Password?')
define('NAVBAR_TITLE', 'Einloggszeit abgelaufen');
define('HEADING_TITLE', 'Los! Ihr Anmelden ist abgelaufen.');
define('HEADING_TITLE_LOGGED_IN', 'Los! Entschuldigung, wir sind nicht autorisiert, die verlangte Aktion durchzuführen.');
define('TEXT_INFORMATION', '<p>Wenn Sie eine Bestellung aufgeben möchten, sollen Sie erst anmelden, und Ihr Einkaufswagen wird dann wiederhergestellt sein. Sie können dann zurück zu dem Textfeld gehen und das Einkauf erledigen.</p><p> Wenn Sie eine Bestellung erledigt haben und einen Kommentar verfassen möchten' . (DOWNLOAD_ENABLED == 'richtig' ? ', oder gibt es einen Kalkulationsfehler und Sie möchten das Geld zurückhaben' : '') . ',bitte gehen Sie zur Seite <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mein Konto</a> und schauen Sie Ihre Bestellungen an.</p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Sie sind noch immer zu Ihrem Konto angemeldet und Sie können den den Einkauf weiter fortsetzen. Wählen Sie einen Bestimmungsort vom Menü.');

define('HEADING_RETURNING_CUSTOMER', 'Anmelden');
define('TEXT_PASSWORD_FORGOTTEN', 'Haben Sie Ihr Passwort vergessen?')
?>