<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tell_a_friend.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Dire à un ami');

define('HEADING_TITLE', 'Dire à un ami sur \'%s\'');

define('FORM_TITLE_CUSTOMER_DETAILS', 'Votre Détails');
define('FORM_TITLE_FRIEND_DETAILS', 'Détails de votre ami');
define('FORM_TITLE_FRIEND_MESSAGE', 'Votre Message:');

define('FORM_FIELD_CUSTOMER_NAME', 'Votre nom:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Votre Email:');
define('FORM_FIELD_FRIEND_NAME', 'Nom de votre ami:');
define('FORM_FIELD_FRIEND_EMAIL', 'Email de votre ami:');

define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Votre email sur <strong>%s</strong> a été envoyé avec succès à <strong>%s</strong>.');

define('EMAIL_TEXT_HEADER','Notice Importante!');

define('EMAIL_TEXT_SUBJECT', 'Votre ami %s a recommandé cet excellent produit à partir de %s');
define('EMAIL_TEXT_GREET', 'Salut %s!' . "\n\n");
define('EMAIL_TEXT_INTRO', 'Votre ami, %s, a pensé que vous devrais être interessé par %s de %s.');

define('EMAIL_TELL_A_FRIEND_MESSAGE','%s envoyé un note disant:');

define('EMAIL_TEXT_LINK', 'Pour voir le produit, cliquez sur le lien ci-dessous ou copier et coller le lien dans votre navigateur:' . "\n\n" . '%s');
define('EMAIL_TEXT_SIGNATURE', 'Cordialement,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'Erreur: Le nom de votre ami ne doit pas être vide.');
define('ERROR_TO_ADDRESS', 'Erreur: L\'adresse email de votre ami ne semble pas être valide. Essayez à nouveau, s\'il vous plaît.');
define('ERROR_FROM_NAME', 'Erreur: Votre nom ne doit pas être vide.');
define('ERROR_FROM_ADDRESS', 'Erreur: Votre adresse email ne semble pas être valide. Essayez à nouveau, s\'il vous plaît.');
?>
