<?php
//banner图部分
define('PAYMENT_METHODS_BANNER_TITLE', 'Payment Methods');
define('PAYMENT_METHODS_BANNER_CONTENT', 'Mind your business with a variety of trusted payment options');

define('PAYMENT_METHODS_ACCOUNT_NUMBERS_AND_INSTRUCTIONS', 'Account numbers & Instructions');
define('PAYMENT_METHODS_LEARN_MORE_AND_APPLY', 'Learn more & Apply');
define('PAYMENT_METHODS_LEARN_MORE_AND_INSTRUCTIONS', 'Learn more & Instructions');

//美国仓政策
define('PAYMENT_METHODS_PAYMENT_OPTIONS', 'Payment Options');
//paypal
define('PAYMENT_METHODS_PAYPAL', 'PayPal');
define('PAYMENT_METHODS_PAYPAL_CONTENT_01', 'Redirect to PayPal via a secure online connection, and pay with the balance of your paypal account or Credit/Debit Card.');
define('PAYMENT_METHODS_PAYPAL_CONTENT_02', 'Our PayPal account is <a href="mailto:paypal@fs.com"><span>paypal@fs.com</span></a>.');
//Credit Card
define('PAYMENT_METHODS_CREDIT_CARD', 'Credit/Debit Card');
define('PAYMENT_METHODS_CREDIT_CARD_CONTENT_01', 'Pay online with Visa, Master, American Express, Discover, Diners, and JCB Card.');
define('PAYMENT_METHODS_CREDIT_CARD_CONTENT_01_01', 'Pay online with Visa, Master, American Express, Discover, Diners, JCB Card,and government credit cards.');
//Wire Transfer
define('PAYMENT_METHODS_WIRE_OR_ACH_TRANSFER', 'Wire/ACH Transfer');
define('PAYMENT_METHODS_WIRE_TRANSFER', 'Wire Transfer');
define('PAYMENT_METHODS_WIRE_TRANSFER_CONTENT_01', 'Transact using a financial institution wire service.');
define('PAYMENT_METHODS_WIRE_TRANSFER_CONTENT_02', '<a href="javascript:;" onclick="payAlertCheck(\'transfer-txt\')"><span>'.PAYMENT_METHODS_ACCOUNT_NUMBERS_AND_INSTRUCTIONS.'</span> <span class="icon iconfont">&#xf451;</span></a>');
//Net Terms
define('PAYMENT_METHODS_NET_TERM', 'Net Terms');
define('PAYMENT_METHODS_NET_TERM_CONTENT_01', 'Pay for purchases with an approved Net Terms account in FS, like Net 30 account, no fees attached.');
define('PAYMENT_METHODS_NET_TERM_CONTENT_02', '<a href="'.reset_url('/policies/net_30.html').'"><span>'.PAYMENT_METHODS_LEARN_MORE_AND_APPLY.'</span><span class="icon iconfont">&#xf451;</span></a>');

//Check
define('PAYMENT_METHODS_ECHECK_OR_CHECK', 'E-check/Check');
define('PAYMENT_METHODS_ECHECK', 'E-check');
define('PAYMENT_METHODS_ECHECK_CONTENT_01', 'Pay with an Electronic Check online at Checkout page, or send a check to us for you order.');
define('PAYMENT_METHODS_CHECK', 'Check');
define('PAYMENT_METHODS_CHECK_CONTENT_01', 'Support to pay with Check to make the purchase convenient for you at any time, just send it to us.');
define('PAYMENT_METHODS_CHECK_CONTENT_02', '<a href="javascript:;" onclick="payAlertCheck(\'check-txt\')"><span>'.PAYMENT_METHODS_LEARN_MORE_AND_INSTRUCTIONS.'</span><span class="icon iconfont">&#xf451;</span></a>');
//Order by Phone
define('PAYMENT_METHODS_ORDER_BY_PHONE', 'Order by Phone');
define('PAYMENT_METHODS_ORDER_BY_PHONE_CONTENT_01', ' Call our customer service center at '.fs_new_get_phone($_SESSION['countries_iso_code']).' during office hours to complete order payment via Credit Card.');


define('PAYMENT_METHODS_COMPARE_FEATURES', 'Compare Features');
define('PAYMENT_METHODS_TABLE_CONTENT_01', 'When is payment due?');
define('PAYMENT_METHODS_TABLE_CONTENT_02', '2 Business Days');
define('PAYMENT_METHODS_TABLE_CONTENT_03', '7 Business Days');
define('PAYMENT_METHODS_TABLE_CONTENT_04', '/');
define('PAYMENT_METHODS_TABLE_CONTENT_05', 'Immediately');
define('PAYMENT_METHODS_TABLE_CONTENT_06', 'How long is the application period?');
define('PAYMENT_METHODS_TABLE_CONTENT_07', 'N/A');
define('PAYMENT_METHODS_TABLE_CONTENT_08', 'Varies');
define('PAYMENT_METHODS_TABLE_CONTENT_09', 'What is the processing time for the payment?');
define('PAYMENT_METHODS_TABLE_CONTENT_10', 'Instant');
define('PAYMENT_METHODS_TABLE_CONTENT_11', '1-3 Business Days Upon Receipt');
define('PAYMENT_METHODS_TABLE_CONTENT_12', '1-2 Business Days Upon Receipt');
define('PAYMENT_METHODS_TABLE_CONTENT_13', 'Which third-party partners are involved?');
define('PAYMENT_METHODS_TABLE_CONTENT_14', 'Bank of America');
define('PAYMENT_METHODS_TABLE_CONTENT_15', 'None');
define('PAYMENT_METHODS_TABLE_CONTENT_16', '1-3 Business Days Upon Receipt');
define('PAYMENT_METHODS_TABLE_CONTENT_17', '1-2 Business Days Upon Receipt');
define('PAYMENT_METHODS_TABLE_CONTENT_18', '1-2 Business Days');
define('PAYMENT_METHODS_TABLE_CONTENT_19', '15 Business Days');
define('PAYMENT_METHODS_TABLE_CONTENT_20', 'ALFA-BANK');

define('PAYMENT_METHODS_PAY_WITH_WIRE_OR_ACH_TRANSFER', 'Pay with Wire/ACH Transfer');
define('PAYMENT_METHODS_PAY_WITH_WIRE_TRANSFER', 'Pay with Wire Transfer');
define('PAYMENT_METHODS_PAY_WITH_ECHECK_OR_CHECK', 'Pay with E-check/Check');
define('PAYMENT_METHODS_PAY_WITH_CHECK', 'Pay with Check');

define('PAYMENT_METHODS_PAY_WITH_CONTENT_01', 'To pay for your order with wire transfer, please send the remittance to the account below. Once you have wired the payment, please kindly send the bank slip to <a href="mailto:finance@fs.com" style="color:#0070bc">finance@fs.com</a> or your account manager.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_02', 'Account Name:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_03', 'FS COM INC');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_04', 'Account #:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_05', '138 119 625 329');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_06', 'Wire Routing #:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_07', '026 009 593');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_08', 'Swift Code:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_09', 'BOFAUS3N');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_09_01', 'BOFAUS6S');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_10', 'Address:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_11', '380 Centerpoint Blvd, New Castle, DE 19720');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_12', 'We accept Check as the payment to make the purchase convenient for you at any time.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_13', 'Please send your Check to the following address:<br/>
                    FS.COM Inc.<br/>
                    380 Centerpoint Blvd<br/>
                    New Castle, DE 19720<br/>
                    United States');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_14', 'To pay for your order with wire/ACH transfer, please send the remittance to the account below. Once you have wired the payment, please kindly send the bank slip to <a href="mailto:finance@fs.com" style="color:#0070bc">finance@fs.com</a> or your account manager.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_15', 'Via Wire Transfer');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_16', 'Bank Name:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_17', 'Via ACH');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_18', 'ACH Routing #:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_19', '125 000 024');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_20', 'We accept E-Check or Check as the payment to make the purchase convenient for you at any time.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_21', 'Pay with E-check');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_22', 'Only U.S. bank accounts are accepted for payment by e-check. To use your Check account as a payment option, please provide the following at Checkout page:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_23', 'Your bank routing number');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_24', 'Your bank account number (typically a checking account)');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_25', 'The name on your bank account');


//武汉仓政策
define('PAYMENT_METHODS_CREDIT_CARD_CONTENT_01_CN', 'Pay online with Visa, Master, American Express, Discover, Diners, JCB Card and P-Card.');

define('PAYMENT_METHODS_BANK_TRANSFER', 'Bank Transfer');

define('PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER', 'Pay with Bank Transfer');
define('PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_RU', 'Alfa Bank Information');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_01_CN', 'To pay for your order with bank transfer, please send the remittance to the account below. Once you have wired the payment, please kindly send the bank slip to <a href="mailto:finance@feisu.com" style="color:#0070bc">finance@feisu.com</a> or your account manager.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_02_CN', 'Beneficiary Bank Name:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_03_CN', 'HSBC Hong Kong');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_04_CN', 'Beneficiary A/C Name:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_05_CN', 'FS.COM LIMITED');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_06_CN', 'Beneficiary A/C NO:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_07_CN', '817-888472-838');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_08_CN', 'SWIFT Address:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_09_CN', 'HSBCHKHHHKH');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_10_CN', 'Beneficiary Bank Address:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_11_CN', '1 Queen\'s Road Central, Hong Kong');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_12_CN', '2-3 Business Days');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_13_CN', 'HSBC Hong Kong');


//sg政策
define('PAYMENT_METHODS_CREDIT_CARD_CONTENT_01_SG', 'Pay online with Visa and Master Credit/Debit card, American Express, Discover, JCB and Diners Club as well as P-Card.');

define('PAYMENT_METHODS_BANK_TRANSFER_CONTENT_01_SG', 'Transact using a financial institution wire service.');

define('PAYMENT_METHODS_ENETS', 'ENETS');
define('PAYMENT_METHODS_ENETS_CONTENT_01', ' Redirect to eNETS and pay through major banks including Citibank Singapore Ltd, DBS/POSB Bank, OCBC Bank / Plus! with Singapore dollar.');

define('PAYMENT_METHODS_BANK_OF_SINGAPORE', 'Bank of Singapore');

define('PAYMENT_METHODS_PAY_WITH_CONTENT_01_SG', 'To pay for your order with bank transfer, please send the remittance to the account below. Once you have wired the payment, please kindly send the bank slip to <a href="mailto:finance@feisu.com" style="color:#0070bc">finance@feisu.com</a> or your account manager.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_02_SG', 'FS TECH PTE. LTD.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_03_SG', 'OCBC SGD Account Number:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_04_SG', '712885193001');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_05_SG', 'OCBCSGSG');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_06_SG', 'Bank Code:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_07_SG', '7339');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_08_SG', 'Branch Code:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_09_SG', 'First 3 digits of your account no.');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_10_SG', 'Branch Name: ');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_11_SG', 'NORTH Branch');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_12_SG', 'Bank Address:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_13_SG', '65 Chulia Street, OCBC Centre, Singapore 049513');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_14_SG', 'OCBC USD Account Number:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_15_SG', '503468316301');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_16_SG', 'Intermediary Bank (for TT in USD):');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_17_SG', 'JP MORGAN CHASE BANK, NEW YORK, USA');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_18_SG', 'CHASUS33');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_19_SG', 'Please post your Check to the following address:');
define('PAYMENT_METHODS_PAY_WITH_CONTENT_20_SG', '<p>FS TECH PTE. LTD.<br/>30A Kallang Place # 11-10/11/12<br/>Singapore 339213</p>');

define('PAYMENT_METHODS_CASHLESS_PAYMENT', 'Cashless Payment');
define('PAYMENT_METHODS_CASHLESS_PAYMENT_CONTENT_01', 'To pay for an order by Cashless Payment, you need to provide details of your company when placing an order on the website.');

define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT', 'Pay with Cashless Payment');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_01', 'The manager will respond to your email within 24 hours and issue an invoice for payment. Also, he will clarify the terms, delivery conditions and other important points.');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_02', 'After the order has been paid, the company manager will contact you to clarify the conditions of delivery (when paying for the delivery) or the date when the order is received from the warehouse.');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_03', 'Together with the goods you will receive all the necessary documents.');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_04', 'ООО "ФС.КОМ"');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_05', 'АО "АЛЬФА-БАНК" Г. МОСКВА');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_06', 'INN:');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_07', '7707419568');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_08', 'KPP:');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_09', '772501001');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_10', 'BIC:');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_11', '044525593');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_12', 'Correspondent account:');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_13', '30101810200000000593');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_14', 'Settlement account:');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_15', '40702810002620003749');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_16', 'Legal address:');
define('PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_17', '115432, Moscow, Russia, Proektiruemyy proezd № 4062, d.6, str.16');
define('PAYMENT_METHODS_PAYMENT_TIP','For pending orders via different payment option, there are different time limits to make a payment before orders will be canceled automatically.');

define('PAYMENT_CREDIT_TIP','International transaction fee might be charged by card issuing bank. You may contact your bank to know details of the possible fees incurred. ');





