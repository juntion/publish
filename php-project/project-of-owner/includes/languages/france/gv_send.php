<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: gv_send.php 3421 2006-04-12 04:16:14Z drbyte $
 */

define('HEADING_TITLE', 'Envoyer ' . TEXT_GV_NAME);
define('HEADING_TITLE_CONFIRM_SEND', 'Envoyer ' . TEXT_GV_NAME . ' Confirmation');
define('HEADING_TITLE_COMPLETED', TEXT_GV_NAME . ' Envoyer');
define('NAVBAR_TITLE', 'Envoyer ' . TEXT_GV_NAME);
define('EMAIL_SUBJECT', 'Message DE ' . STORE_NAME);
define('HEADING_TEXT','Entrez le nom, l\'adresse e-mail et la quantité de ' . TEXT_GV_NAME . ' vous voulez envoyer. Pour plus d\'informations, voyez notre<a href="' . zen_href_link(FILENAME_GV_FAQ, '', 'NONSSL').'">' . GV_FAQ . '.</a>');
define('ENTRY_NAME', 'Nom de Destinataire:');
define('ENTRY_EMAIL', 'E-mail de Destinataire:');
define('ENTRY_MESSAGE', 'Votre Message:');
define('ENTRY_AMOUNT', 'Montant à Envoyer:');
define('ERROR_ENTRY_TO_NAME_CHECK', 'On n\'a pas eu le nom de destinataire. Remplissez ci-dessous, s\'il vous plaît. ');
define('ERROR_ENTRY_AMOUNT_CHECK', 'Le ' . TEXT_GV_NAME . ' montant ne semble pas être correct. Réessayez, s\'il vous plaît.');
define('ERROR_ENTRY_EMAIL_ADDRESS_CHECK', 'Est-ce que l\'adresse email est correcte? Réessayez, s\'il vous plaît.');
define('MAIN_MESSAGE', 'Vous envoyez un ' . TEXT_GV_NAME . ' valeur %s to %s,  dont l\'adresse email est %s. Si ces détails ne sont pas correctes, vous pouvez modifier votre message en cliquant sur le <strong>édition</strong> bouton.<br /><br />Le message que vous envoyez est:<br /><br />');
define('SECONDARY_MESSAGE', 'Cher %s,<br /><br />' . 'Vous avez envoyé un ' . TEXT_GV_NAME . ' valeur %s par %s');
define('PERSONAL_MESSAGE', '%s dit:');
define('TEXT_SUCCESS', 'Félicitations, votre ' . TEXT_GV_NAME . ' a été envoyé.');
define('TEXT_SEND_ANOTHER', 'Voulez-vous envoyer un autre ' . TEXT_GV_NAME . '?');
define('TEXT_AVAILABLE_BALANCE',  'Compte de Chèque-Cadeau');

define('EMAIL_GV_TEXT_SUBJECT', 'Un cadeau de %s');
define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');
define('EMAIL_GV_TEXT_HEADER', 'Félicitations, vous avez reçu un' . TEXT_GV_NAME . ' valeur %s');
define('EMAIL_GV_FROM', 'Ce ' . TEXT_GV_NAME . ' a été envoyé par %s');
define('EMAIL_GV_MESSAGE', 'avec un message disant: ');
define('EMAIL_GV_SEND_TO', 'Salut, %s');
define('EMAIL_GV_REDEEM', 'Pour échanger cela ' . TEXT_GV_NAME . ', cliquez sur le lien ci-dessous, s\'il vous plaît. Notez également le ' . TEXT_GV_REDEEM . ': %s  au cas où vous avez des problèmes.');
define('EMAIL_GV_LINK', 'Cliquez ici pour échanger, s\'il vous plaît.');
define('EMAIL_GV_VISIT', ' ou visitez ');
define('EMAIL_GV_ENTER', ' et entrez le ' . TEXT_GV_REDEEM . ' ');
define('EMAIL_GV_FIXED_FOOTER', 'Si vous avez des problèmes sur l\'achat de ' . TEXT_GV_NAME . ' utilisez le lien automatisé ci-dessus, ' . "\n" .
                                'vous pouvez également entrer le ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' pendant le processus de paiement dans notre boutique.');
define('EMAIL_GV_SHOP_FOOTER', '');
?>