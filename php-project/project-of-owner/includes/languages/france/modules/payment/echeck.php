<?php

  define('MODULE_PAYMENT_ECHECK_TEXT_RECEIVER', 'Receiver ');
  define('MODULE_PAYMENT_ECHECK_TEXT_SENDER', 'Sender ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_AMOUNT', 'Amount : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_CURRENCY', 'Currency : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_FIRST_NAME', 'First Name : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_LAST_NAME', 'Last Name : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_ADDRESS', 'Address : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_ZIP', 'Zip Code : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_CITY', 'City : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_COUNTRY', 'Country : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_PHONE', 'Phone : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_QUESTION', 'Question : ');
  define('MODULE_PAYMENT_ECHECK_ENTRY_ANSWER', 'Answer : ');
  
  define('MODULE_PAYMENT_ECHECK_RECEIVER_LAST_NAME', 'Last Name');
  define('MODULE_PAYMENT_ECHECK_RECEIVER_ADDRESS', 'Address');
  define('MODULE_PAYMENT_ECHECK_RECEIVER_ZIP', 'Zip Code');
  define('MODULE_PAYMENT_ECHECK_RECEIVER_CITY', 'City');
  define('MODULE_PAYMENT_ECHECK_RECEIVER_COUNTRY', 'Country');
  define('MODULE_PAYMENT_ECHECK_RECEIVER_PHONE', 'Phone');

  define('MODULE_PAYMENT_ECHECK_TEXT_CONFIG_1_1','Enable echeck Order Module');
  define('MODULE_PAYMENT_ECHECK_TEXT_CONFIG_1_2','Do you want to accept echeck Order payments?');
  define('MODULE_PAYMENT_ECHECK_TEXT_CONFIG_2_1','Sort order of display.');
  define('MODULE_PAYMENT_ECHECK_TEXT_CONFIG_2_2','Sort order of display. Lowest is displayed first.');
  define('MODULE_PAYMENT_ECHECK_TEXT_CONFIG_3_1','Set Order Status');
  define('MODULE_PAYMENT_ECHECK_TEXT_CONFIG_3_2','Set the status of orders made with this payment module to this value');
  
  define('MODULE_PAYMENT_ECHECK_TEXT_TITLE', 'echeck');
  define('MODULE_PAYMENT_ECHECK_TEXT_DESCRIPTION', 'Make Payable To:<br><br>' .  '<b>'. MODULE_PAYMENT_ECHECK_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_ECHECK_RECEIVER_FIRST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_ECHECK_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_ECHECK_RECEIVER_LAST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_ECHECK_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_ECHECK_RECEIVER_ADDRESS . '<br>'  .   '<b>'. MODULE_PAYMENT_ECHECK_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_ECHECK_RECEIVER_ZIP . '<br>'  .   '<b>'. MODULE_PAYMENT_ECHECK_ENTRY_CITY .   '</b>'.  MODULE_PAYMENT_ECHECK_RECEIVER_CITY . '<br>'  .  '<b>'.  MODULE_PAYMENT_ECHECK_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_ECHECK_RECEIVER_COUNTRY . '<br>'  .   '<b>'.  MODULE_PAYMENT_ECHECK_ENTRY_PHONE . '</b>'.   MODULE_PAYMENT_ECHECK_RECEIVER_PHONE . '<br>' . '<font size=2 color="red"><b>After the payment, plese tell us your Firstname, Lastname, amount, currency and country.</b></font>');
  
  define('MODULE_PAYMENT_ECHECK_TEXT_EMAIL_FOOTER', "Make Payable To:\n\n" . MODULE_PAYMENT_ECHECK_ENTRY_FIRST_NAME . MODULE_PAYMENT_ECHECK_RECEIVER_FIRST_NAME . " - " . MODULE_PAYMENT_ECHECK_ENTRY_LAST_NAME . MODULE_PAYMENT_ECHECKE_RECEIVER_LAST_NAME . " - "  . MODULE_PAYMENT_ECHECK_ENTRY_ADDRESS . MODULE_PAYMENT_ECHECK_RECEIVER_ADDRESS . " - "  . MODULE_PAYMENT_ECHECK_ENTRY_ZIP . MODULE_PAYMENT_ECHECK_RECEIVER_ZIP . " - "  . MODULE_PAYMENT_ECHECK_ENTRY_CITY . MODULE_PAYMENT_ECHECK_RECEIVER_CITY . " - "  . MODULE_PAYMENT_ECHECK_ENTRY_COUNTRY . MODULE_PAYMENT_ECHECK_RECEIVER_COUNTRY . " - "  . MODULE_PAYMENT_ECHECK_ENTRY_PHONE . MODULE_PAYMENT_ECHECK_RECEIVER_PHONE . "\n\n" . '<b>After the payment, plese tell us your first name, last name, amount, currency and country.</b>' . "\n\n" .  '<b>Your order will not be shipped until we receive the MTCN payment number provided by ECHECK Money Transfer.</b>');

  define('MODULE_PAYMENT_ECHECK_MARK_BUTTON_IMG', DIR_WS_MODULES . '/payment/PURCHASE/PURCHASE.gif');
  define('MODULE_PAYMENT_ECHECK_MARK_BUTTON_ALT', 'Checkout with echeck');
  define('MODULE_PAYMENT_ECHECK_ACCEPTANCE_MARK_TEXT', 'Send Money with echeck-us');

  define('MODULE_PAYMENT_ECHECK_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_ECHECK_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_ECHECK_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_ECHECK_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_ECHECK_ACCEPTANCE_MARK_TEXT . '</span>');

?>
