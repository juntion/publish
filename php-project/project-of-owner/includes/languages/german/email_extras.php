<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>von:</strong>');
  define('OFFICE_EMAIL','<strong>E-Mail:</strong>');

  define('OFFICE_SENT_TO','<strong>Schicken zu:</strong>');
  define('OFFICE_EMAIL_TO','<strong>E-Mail an:</strong>');

  define('OFFICE_USE','<strong>Nur im Büro benutzen:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>Name für Anmelden:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>E-Mail für Anmelden:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>Telefonnummer:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>Fax:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>IP Adresse:</strong>');
  define('OFFICE_HOST_ADDRESS','<strong>Host-Adresse:</strong>');
  define('OFFICE_DATE_TIME','<strong>Datum und Zeit:</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'zu');

// email disclaimer
//  define('EMAIL_DISCLAIMER', 'This email address was given to us by you or by one of our customers. If you feel that you have received this email in error, please send an email to %s ');
//  define('EMAIL_SPAM_DISCLAIMER','This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.');
//  define('EMAIL_FOOTER_COPYRIGHT','Copyright (c) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>');
  define('TEXT_UNSUBSCRIBE', "\n\n Um die zukunftigen Newsletters und Werbepost abzubestellen, klicken Sie einfach auf die verbindung darunter: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANT:</strong>Alle von diser Webseite gesandten E-Mails werden protokolliert und ihre Inhalte sind für die Ladenbesitzer verfügbar sind, damit Ihre private Daten geschützt und nicht böswillg benutzt werden. Wenn es Ihrer Meinung nach ein Fehler ist, diese E-Mail bekommen zu haben, schicken Sie bitte eine E-Mail an ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>Diese Meldung enthält alle von diser Webseite gesandten E-Mails :</strong>');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT','[Ein Konto anlegen]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT','[Einen Freund informieren]');
  define('SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT','[GV CUSTOMER SENT]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT','[Neue Bestellung]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[Zusätzlich CC Bestellinformation] #');

// Low Stock Emails
  define('EMAIL_TEXT_SUBJECT_LOWSTOCK','Achtung:kleine Vorräte');
  define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE','Bericht von kleinen Vorräten: ');

// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Beschädigt');
?>