<?php

  //$Id: ENETS.php v3.2  Henly $

  define('MODULE_PAYMENT_ENETS_TEXT_ADMIN_TITLE', 'ENETS Online Payment');
  define('MODULE_PAYMENT_ENETS_TEXT_CATALOG_TITLE', 'ENETS Online Payment');
  define('MODULE_PAYMENT_ENETS_TEXT_DESCRIPTION', 'ENETS\'s core service is an escrow service');

  define('MODULE_PAYMENT_ENETS_ENTRY_STATE', 'Notification:');
  define('MODULE_PAYMENT_ENETS_ENTRY_MODATE', 'Date:');

  define('MODULE_PAYMENT_ENETS_MARK_BUTTON_IMG', DIR_WS_MODULES . '/payment/ENETS/ENETS.gif');
  define('MODULE_PAYMENT_ENETS_MARK_BUTTON_ALT', 'Checkout with ENETS');
  define('MODULE_PAYMENT_ENETS_ACCEPTANCE_MARK_TEXT', 'ENETS.com online payment gateway');

  define('MODULE_PAYMENT_ENETS_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_ENETS_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_ENETS_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_ENETS_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_ENETS_ACCEPTANCE_MARK_TEXT . '</span>');


  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_1_1', 'Enable ENETS Module');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_1_2', 'Do you want to accept ENETS payments?');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_2_1', 'ENETS KeyId');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_2_2', 'ENETS KeyId');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_3_1', 'ENETS  key');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_3_2', 'ENETS  key');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_4_1', 'ENETS ID');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_4_2', 'ENETS ID');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_5_1', 'Payment Zone');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_5_2', 'If a zone is selected, only enable this payment method for that zone.');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_6_1', 'Set Order Status');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_6_2', 'Set the status of orders made with this payment module that have completed payment to this value<br />(Processing recommended)');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_7_1', 'Set Pending Notification Status');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_7_2', 'Set the status of orders made with this payment module to this value<br />(Pending recommended)');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_8_1', 'Sort order of display');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_8_2', 'Sort order of display. Lowest is displayed first.');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_9_1', 'ENETS transaction URL<br />Default: <code>https://api.globalcollect.com</code><br />');  
  define('MODULE_PAYMENT_ENETS_TEXT_CONFIG_9_2', 'ENETS transaction URL');  

?>