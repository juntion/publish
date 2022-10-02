<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
//  $Id: index.php 001 2009-05-02 00:00:00 Jack $
//

  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_ADMIN_TITLE', 'Global Collect Online Payment');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CATALOG_TITLE', 'Globalcollect');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_DESCRIPTION', 'Credit Card Payment');

  define('MODULE_PAYMENT_GLOBALCOLLECT_MARK_BUTTON_IMG', DIR_WS_MODULES . 'payment/globalcollect/globalcollect.jpg');
  define('MODULE_PAYMENT_GLOBALCOLLECT_MARK_BUTTON_ALT', 'Online Credit Card Processing');
  define('MODULE_PAYMENT_GLOBALCOLLECT_ACCEPTANCE_MARK_TEXT', 'Online Credit Card Processing');

  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_GLOBALCOLLECT_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_GLOBALCOLLECT_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_GLOBALCOLLECT_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_GLOBALCOLLECT_ACCEPTANCE_MARK_TEXT . '</span>');

  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_1_1', 'Enable Global Collect Module');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_1_2', 'Do you want to accept Global Collect payments?');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_2_1', 'Global Collect ID');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_2_2', 'Global Collect ID');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_3_1', 'Global Collect MD5 key');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_3_2', 'Global Collect MD5 key');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_4_1', 'Payment Zone');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_4_2', 'If a zone is selected, only enable this payment method for that zone.');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_5_1', 'Set Order Status');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_5_2', 'Set the status of orders made with this payment module that have completed payment to this value<br />(Processing recommended)');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_6_1', 'Set Pending Notification Status');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_6_2', 'Set the status of orders made with this payment module to this value<br />(Pending recommended)');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_7_1', 'Sort order of display');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_7_2', 'Sort order of display. Lowest is displayed first.');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_8_1', 'Global Collect transaction');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_8_2', 'Live or Test');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_9_1', 'Anti-Fraud System');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_9_2', 'False: Disable<br />True: Enabled');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_10_1', 'Debug Mode');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_10_2', 'Enable debug logging? <br />NOTE: This can REALLY clutter your email inbox!<br />Logging goes to the /includes/modules/payment/globalcollect/logs folder<br />Email goes to the Debug Email Address.<br /><strong>Leave OFF for normal operation.</strong>');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_11_1', 'Debug Email Address');  
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_11_2', 'The email address to use for Global Collect debugging');  

  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_GATEWAY_TYPE', 'Payment option ');

  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_SELECTION_1', 'Debit Card');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_SELECTION_2', 'Credit Card');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_SELECTION_3', 'Global Collect Balance');
  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_SELECTION_4', 'EPOS');

  define('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_SELECTION_5', ' Purchase');

?>