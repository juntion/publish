<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>От:</strong>');
  define('OFFICE_EMAIL','<strong>Эл. адрес:</strong>');

  define('OFFICE_SENT_TO','<strong>Кому:</strong>');
  define('OFFICE_EMAIL_TO','<strong>Эл. адрес:</strong>');

  define('OFFICE_USE','<strong>Только для офисного использования:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>Логин:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>Логин Email:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>Телефон:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>Факс:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>IP-адрес:</strong>');
  define('OFFICE_HOST_ADDRESS','<strong>Адрес Хоста:</strong>');
  define('OFFICE_DATE_TIME','<strong>Дата и Время</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'OFF');

// email disclaimer
//  define('EMAIL_DISCLAIMER', 'Этот адрес электронной почты нам была дана вами или одним из наших клиентов. Если вы считаете, что получили данное письмо по ошибке, пожалуйста, отправьте письмо на %s ');
//  define('EMAIL_SPAM_DISCLAIMER','Это письмо будет отправлено в соответствии с US CAN-SPAM законом в силу 01/01/2004. Запросы на удаление могут быть отправлены на этот адрес и будут почитаемы и уважаемы.');
//  define('EMAIL_FOOTER_COPYRIGHT','Авторское право (C) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Питаться от <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>');
  define('TEXT_UNSUBSCRIBE', "\n\nЧтобы отписаться от будущих рассылок и рекламных сообщений, просто нажмите следующую ссылку: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANT:</strong>Для вашей безопасности и предотвращения злонамеренного использования все письма, отправленные через этот веб-сайт записались и их содержания доступены для владельца магазина. Если вы считаете, что получили данное письмо по ошибке, пожалуйста, отправьте письмо ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>Это сообщение входит в состав всех сообщений, отправленных с этого сайта</strong>');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT','[CREATE ACCOUNT]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT','[TELL A FRIEND]');
  define('SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT','[GV CUSTOMER SENT]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT','[NEW ORDER]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[EXTRA CC ORDER info] #');

// Low Stock Emails
  define('EMAIL_TEXT_SUBJECT_LOWSTOCK','Предупреждение:недостаточные наличные запасы ');
  define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE',' Отчет недостаточных наличных запасов: ');

// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Отключено');
?>