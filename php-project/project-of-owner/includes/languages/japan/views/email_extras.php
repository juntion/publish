<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>より:</strong>');
  define('OFFICE_EMAIL','<strong>Eメール:</strong>');

  define('OFFICE_SENT_TO','<strong>受信元:</strong>');
  define('OFFICE_EMAIL_TO','<strong>受信Eメール:</strong>');

  define('OFFICE_USE','<strong>オフィスのみの使用:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>ログイン名:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>ログインEメール:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>電話番号:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>ファックス:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>ＩＰアドレス:</strong>');
  define('OFFICE_HOST_ADDRESS','<strong>ホストアドレス:</strong>');
  define('OFFICE_DATE_TIME','<strong> 日付と時間:</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'オフ');

// email disclaimer
//  define('EMAIL_DISCLAIMER', 'This email address was given to us by you or by one of our customers. If you feel that you have received this email in error, please send an email to %s ');
//  define('EMAIL_SPAM_DISCLAIMER','This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.');
//  define('EMAIL_FOOTER_COPYRIGHT','Copyright (c) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>');
  define('TEXT_UNSUBSCRIBE', "\n\nメールマガジンとプロモーションメールの購読を取消す場合、以下のリンクをクリックするだけです: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>重要なお知らせ:</strong>お客様を保護するために不正利用を防止し、このウェブサイトを介して送信されたすべての電子メールはログに記録され、そして、記録されたコンテンツが店舗の所有者に入手可能です。このメールは間違い投稿すれば、どうぞ以下に送信します ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>このメッセージは、サイトから送信されたすべてのメールに含まれています:</strong>');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT','[アカウントを作成する]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT','[友達に伝える]');
  define('SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT','[顧客に送信する]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT','[新しい注文]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[また注文情報をCCより送信する]  #');

// Low Stock Emails
  define('EMAIL_TEXT_SUBJECT_LOWSTOCK','警告：Low Stock');
  define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE','Low Stock報告: ');

// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', '無効');
?>