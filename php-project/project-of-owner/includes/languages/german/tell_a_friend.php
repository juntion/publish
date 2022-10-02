<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tell_a_friend.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Einem Freund Bescheid sagen');

define('HEADING_TITLE', 'Einem Freund Bescheid über \'%s\' sagen');

define('FORM_TITLE_CUSTOMER_DETAILS', 'Ihre Details');
define('FORM_TITLE_FRIEND_DETAILS', 'Details von einem Freund');
define('FORM_TITLE_FRIEND_MESSAGE', 'Ihre Meldung:');

define('FORM_FIELD_CUSTOMER_NAME', 'Ihr Name:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Ihre E-Mail:');
define('FORM_FIELD_FRIEND_NAME', 'Name einem Freund:');
define('FORM_FIELD_FRIEND_EMAIL', 'E-Mail einem Freund:');

define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Ihre E-Mail über <strong>%s</strong> ist mit Erfolg an <strong>%s</strong> gesandt worden.');

define('EMAIL_TEXT_HEADER','Wichtige Notiz!');

define('EMAIL_TEXT_SUBJECT', 'Ein Freund von Ihnen hat dieses tolle Produkt von %s empfohlen');
define('EMAIL_TEXT_GREET', 'Hi %s!' . "\n\n");
define('EMAIL_TEXT_INTRO', 'Ein Freund von Ihnen, %s, findet, dass Sie vielleicht Interesse an %s von %s haben.');

define('EMAIL_TELL_A_FRIEND_MESSAGE','%s schickte einen Zettel:');

define('EMAIL_TEXT_LINK', 'Um das Produkt anzusehen, können Sie auf die Verbindung darunter klicken oder die Verbindung kopieren und in den Browser Web-Adresse Fenster ankleben:' . "\n\n" . '%s');
define('EMAIL_TEXT_SIGNATURE', 'Grüße,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'Fehler: Der Name eines Freundes soll nicht leer sein.');
define('ERROR_TO_ADDRESS', 'Fehler: Die E-Mailadresse eines Freundes scheint nicht gültig zu sein. Bitte versuchen Sie noch einmal.');
define('ERROR_FROM_NAME', 'Fehler: Ihr Name soll nicht leer sein.');
define('ERROR_FROM_ADDRESS', 'Fehler: Ihre E-Mailadresse scheint nicht gültig zu sein. Bitte versuchen Sie noch einmal.');
?>
