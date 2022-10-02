<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: gv_send.php 3421 2006-04-12 04:16:14Z drbyte $
 */

define('HEADING_TITLE', 'Senden ' . TEXT_GV_NAME);
define('HEADING_TITLE_CONFIRM_SEND', 'Senden ' . TEXT_GV_NAME . 'Bestätigung ');
define('HEADING_TITLE_COMPLETED', TEXT_GV_NAME . ' Gesendet');
define('NAVBAR_TITLE', 'Senden ' . TEXT_GV_NAME);
define('EMAIL_SUBJECT', 'Nachricht von ' . STORE_NAME);
define('HEADING_TEXT','Bitte geben Sie den name, die E-maladresse und die Menge von' . TEXT_GV_NAME . ' die Sie senden möchten. Für weitere Informationen sehen Sie mal bitte unsere <a href="' . zen_href_link(FILENAME_GV_FAQ, '', 'NONSSL').'">' . GV_FAQ . '.</a>');
define('ENTRY_NAME', 'Name des Empfängers:');
define('ENTRY_EMAIL', 'E-mail des Empfängers:');
define('ENTRY_MESSAGE', 'Ihre meldung:');
define('ENTRY_AMOUNT', 'Menge für Sendung:');
define('ERROR_ENTRY_TO_NAME_CHECK', 'Wir haben den Name des Empfängers nicht. Bitte füllen Sie ihn aus darunter. ');
define('ERROR_ENTRY_AMOUNT_CHECK', 'Die Menge von ' . TEXT_GV_NAME . ' scheint nicht richtig. Bitte geben Sie noch einmal ein.');
define('ERROR_ENTRY_EMAIL_ADDRESS_CHECK', 'Ist die E-maladresse richti? Bitte geben Sie noch einmal ein.');
define('MAIN_MESSAGE', 'Sie werden  ' . TEXT_GV_NAME . ' zu %s senden, deren Wert %s ist,  dessen/deren E-maladresse %s ist. Wenn die Details nicht richtig sind, können Sie Ihre Meldung bearbeiten durch ein Klicken auf den Knopf <strong>edit</strong> .<br /><br />Die von Ihnen zu sendene Meldung ist:<br /><br />');
define('SECONDARY_MESSAGE', 'Liebe/Liber %s,<br /><br />' . ' Sie haben einen ' . TEXT_GV_NAME . ' gesendet  %s by %s');
define('PERSONAL_MESSAGE', '%s sagt:');
define('TEXT_SUCCESS', 'Gratulieren, Ihre ' . TEXT_GV_NAME . ' ist schon gesendet.');
define('TEXT_SEND_ANOTHER', 'Möchten Sie eine andere ' . TEXT_GV_NAME . '? senden');
define('TEXT_AVAILABLE_BALANCE',  'Konto für geschenkgutschein');

define('EMAIL_GV_TEXT_SUBJECT', 'Ein Geschenk von %s');
define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');
define('EMAIL_GV_TEXT_HEADER', 'Gratulieren, Sie haben einen ' . TEXT_GV_NAME . ' bekommen, dessen Wert ist %s ');
define('EMAIL_GV_FROM', 'This ' . TEXT_GV_NAME . ' has been sent to you by %s');
define('EMAIL_GV_MESSAGE', 'with a message saying: ');
define('EMAIL_GV_SEND_TO', 'Hallo, %s');
define('EMAIL_GV_REDEEM', 'Um den Gutschein' . TEXT_GV_NAME . ' einzulösen, klicken Sie bitte die Verbindung darunter. Bitte schreiben Sie auch die ' . TEXT_GV_REDEEM . ' auf: %s  falls Sie Probleme haben.');
define('EMAIL_GV_LINK', 'Für Einlösen klicken Sie hier');
define('EMAIL_GV_VISIT', ' oder besuchen ');
define('EMAIL_GV_ENTER', ' und geben Sie ein die Kode ' . TEXT_GV_REDEEM . ' ');
define('EMAIL_GV_FIXED_FOOTER', 'Wenn Sie Probleme beim Einlösen von den Gutschein' . TEXT_GV_NAME . ', benutzen Sie die automatische Verbindung droben, ' . "\n" .
                                'Sie können auch ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' während der Zahlung bei unserem Laden eingeben.');
define('EMAIL_GV_SHOP_FOOTER', '');
?>