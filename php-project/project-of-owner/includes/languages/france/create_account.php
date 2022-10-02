<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 15405 2010-02-03 06:29:33Z drbyte $
 */

define('NAVBAR_TITLE', 'Créer un Compte');

define('HEADING_TITLE', 'Informations de Mon Compte');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">REMARQUE:</strong> Si vous possédez un compte chez nous, merci de vous identifier à la <a href="%s">page de connextion</a>.');




// greeting salutation
define('EMAIL_SUBJECT', 'Bienvenue Chez ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Cher Monsieur. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Chère Madame. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Cher/Chère %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', 'Nous vous souhaitons la bienvenue chez <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Félicitations ! Pour vous rendre une expérience plus enrichissante lors de votre prochaine visite dans notre boutique en ligne, les détails sur le coupon de réduction spécialement pour vous se trouvent ci-dessous !' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'Pour utiliser le coupon de réduction, Indiquez le code de ' . TEXT_GV_REDEEM . ' durant la procédure de paiement :  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Le coupon est valable entre %s et %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Seulement pour aujourd\'hui, nous vous avons envoyé un ' . TEXT_GV_NAME . ' pour %s !' . "\n");
define('EMAIL_GV_REDEEM', 'Le ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' est: %s ' . "\n\n" . 'Vous pouvez indiquer ' . TEXT_GV_REDEEM . ' durant la procédure de paiement, après avoir effectué vos sélections dans la boutique. ');
define('EMAIL_GV_LINK', ' Vous pouvez maintenant l\'utiliser via ce lien : ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','Une fois que vous avez ajouté ' . TEXT_GV_NAME . ' dans votre compte, vous pouvez utiliser ' . TEXT_GV_NAME . ' pour vous même, ou l\'envoyer à un ami ' . "\n\n");

define('EMAIL_TEXT', 'Vous êtes maintenant enregistré sur notre site et possédez un compte privilégié : Avec votre compte, vous pouvez prendre part aux <strong>divers services</strong> que nous vous offrons. Certains de ces services comprennent :' . "\n\n<ul>" . '<li><strong>Historique des Commandes</strong> - Voir les détails de vos commandes effectuées.' . "\n\n" . '<li><strong>Panier permanent</strong> - Les articles ajoutés resteront là jusqu\'à ce que vous les supprimiez ou bien décidiez de les acheter.' . "\n\n" . '<li><strong>Carnets d\'Adresses</strong> - Nous pouvons envoyer votre commande à une adresse différente de celle de votre domicile ! C\'est parfait pour envoyer directement des cadeaux à la personne qui fête son anniversaire.' . "\n\n" . '<li><strong>Commentaires de Produits</strong> - Partagez vos opinions sur nos produits avec d\'autres clients.' . "\n\n</ul>");
define('EMAIL_CONTACT', 'Pour demander l\'aide sur nos services en ligne, veuillez envoyer un mél à Fiberstore : <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE', "\n" . 'Sincèrement,' . "\n\n" . STORE_OWNER . "\nStore Owner\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Cette adresse e-mail a été donnée par vous ou par un de nos clients. Si vous n\'avez pas vous inscrit, ou si vous estimez que ce courriel est une erreur, veuillez contacter %s ');
