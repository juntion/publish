<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>De:</strong>');
  define('OFFICE_EMAIL','<strong>Courriel:</strong>');

  define('OFFICE_SENT_TO','<strong>Envoyer à:</strong>');
  define('OFFICE_EMAIL_TO','<strong>Au courriel:</strong>');

  define('OFFICE_USE','<strong>L\'utilisation seule pour le bureau:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>Identifiant:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>Courriel de connexion:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>Téléphone:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>Fax:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>Adresse IP:</strong>');
  define('OFFICE_HOST_ADDRESS','<strong>Adresse de l\'hôte:</strong>');
  define('OFFICE_DATE_TIME','<strong>Date et Heure:</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'OFF');

// email disclaimer
//  define('EMAIL_DISCLAIMER', 'Cette adresse de courriel est donnée par vous ou par un de nos clients. Si vous sentez que vous recevez ce courriel par erreur, envoyez un courriel à %s ');
//  define('EMAIL_SPAM_DISCLAIMER','Ce courriel est envoyé en conformité avec la loi CAN-SPAM américaine en vigueur le 01/01/2004. Demandes de suppression peuvent être envoyées à cette adresse.');
//  define('EMAIL_FOOTER_COPYRIGHT','Copyright (c) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>');
  define('TEXT_UNSUBSCRIBE', "\n\nPour vous désinscrire des envois promotionnels, cliquez simplement sur le lien suivant: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
//  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANT:</strong> Pour votre protection et d'empêcher l'utilisation malveillante, tous les courriels envoyés par ce site sont enregistrés et le contenu enregistré est disponible pour le propriétaire du magasin. Si vous sentez que vous avez reçu ce courriel par erreur, envoyez un courriel à ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>Ce message est inclus avec tous les courriels envoyés à partir de ce site:</strong>');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT','[CREATE ACCOUNT]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT','[TELL A FRIEND]');
  define('SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT','[GV CUSTOMER SENT]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT','[NEW ORDERS]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[EXTRA CC ORDER info] #');

// Low Stock Emails
  define('EMAIL_TEXT_SUBJECT_LOWSTOCK','Attention: Stock Faible');
  define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE','Rapport de Stock Faible: ');

// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Désactivé');
?>