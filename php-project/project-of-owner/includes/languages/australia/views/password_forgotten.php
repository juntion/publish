<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Basket Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Login');
define('NAVBAR_TITLE_2', 'Forgotten password');

define('HEADING_TITLE', 'Forgotten password');

define('TEXT_MAIN', 'Enter your email address below and we will send you an email message containing your new password.');

define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Error: The Email Address was not found in our records; please try again.');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - New Password');
define('EMAIL_PASSWORD_REMINDER_BODY', 'A new password was requested from ' . $_SERVER['REMOTE_ADDR']  . '.' . "\n\n" . 'Your new password to \'' . STORE_NAME . '\' is:' . "\n\n" . '   %s' . "\n\nAfter you have logged in using the new password, you may change it by going to the 'My Account' area.");

define('SUCCESS_PASSWORD_SENT', 'A new password has been sent to your email address.');





/**********BOF PASSWORD_FORGOTTEN LANGUAGE************/
define('FIBERSTORE_NEW_PWD','New password from FS.COM');

define('FIBERSTORE_FORGOTTEN_RESET', 'Reset Your Password');

define('FIBERSTORE_FORGOTTEN_EMAIL', '*Email Address:');

define('FIBERSTORE_FORGOTTEN_SEND', ' Enter your email address below and we will send you an email message containing your new password.');

define('FIBERSTORE_FORGOTTEN_RETURN', 'Return to Login');

define('FIBERSTORE_FORGOTTEN_OR', 'OR');

define('FIBERSTORE_FORGOTTEN_PLACE', 'Place order online');

define('FIBERSTORE_FORGOTTEN_TRACK', 'Track your orders online');

define('FIBERSTORE_FORGOTTEN_VIEW', 'View your order history');

define('FIBERSTORE_FORGOTTEN_CREATE', 'Create favorites, wish lists, and more!');

define('FIBERSTORE_FORGOTTEN_MAKE', 'Make project budget using wish lists');

define('FIBERSTORE_FORGOTTEN_SUPPORT', 'Technical Team Support');

define('FIBERSTORE_FORGOTTEN_HELP', 'Need Help?');

define('TEXT_LOGIN_GUARANTEED','GUARANTEED!');

define('TEXT_LOGIN_HELP','Need Help?');

define('TEXT_LOGIN_OR','Or');

define('FIBERSTORE_PWD_OF','Your new Password of FS.COM');

define('FIBERSTORE_A_NEWPWD','A new password of your FS.COM account.');
define('FIBERSTORE_PWD_IS','Your new password is: ');
define('FIBERSTORE_LOGGED_RECOMMEND','After you have logged in using the new password, we recommend you go to My Account and enter Account Settings to change it.');
define('FIBERSTORE_FORGET_SINCERELY','Sincerely,');
define('FIBERSTORE_THANKS_AGAIN','Thanks again for choosing us.');
define('FIBERSTORE_FORGET_NOTE','Please note:');
define('FIBERSTORE_SEND_EMAIL','This email message was sent from a notification-only address that cannot accept incoming email.');
define('FIBERSTORE_NOT_REPLY','PLEASE DO NOT REPLY');
define('FIBERSTORE_CONTACT_US','to this message. If you have  any questions please contact us.');
/**********EOF****************************************/






/*********************************/


define('TEXT_LOGIN_HELP_WITH','Need Help with');

define('TEXT_LOGIN_RETURNING','Returning an item');

define('TEXT_LOGIN_VIEW_THE','View the');

define('TEXT_LOGIN_RMA','RMA Solution');

define('TEXT_LOGIN_PAGE','page or Email us at');

define('TEXT_LOGIN_EMAIL','service@fiberstore.com');

define('TEXT_LOGIN_CONTACT','Contact us');

define('TEXT_VIEW_FAQ','View the FAQs page');

define('TEXT_LOGIN_QUESTIONS','Have questions about Shipping and Delivery?');

define('ACCOUNT_FOOTER_TITLE','SHOP WITH CONFIDENCE');

define('ACCOUNT_FOOTER_SHOPPING','SHOPPING ON FS.COM ');

define('ACCOUNT_FOOTER_SECURE','IS SAFE AND SECURE.');

define('ACCOUNT_FOOTER_PAY','You ll pay nothing if unauthorized charges are made to your credit card as a result of shopping at FS.COM.');

define('ACCOUNT_FOOTER_SAFE','SAFE SHOPPING GUARANTEE');

define('ACCOUNT_FOOTER_INFORMATION','All information is encrypted and transmitted without risk using a Secure Sockets Layer (SSL) protocol.');

define('ACCOUNT_FOOTER_HOW','How We Protect Your Personal Data ?');

define('ACCOUNT_FOOTER_FREE','FREE SHIPPING AND FREE RETURNS');

define('ACCOUNT_FOOTER_SHOP','If, you are unsatisfied with your purchase from FS.COM Co.,Ltd you may return it in its original condition within 7 days for a refund. We WIll even pay for return shipping!');

define('ACCOUNT_FOOTER_DELIVER','To deliver worry free operation and eliminate the cost associated with out of warranty repairs, FS.COM offers a Lifetime Warranty as a standard feature across all major product lines.');

define('ACCOUNT_FOOTER_LEARN','Learn More ?');
/**********************************/



// reason block
define('FS_PS_FORGOTTEN_WHY','Why can\'t you sign in?');
define('FS_PS_FORGOTTEN_REASON1','I forgot my password');
define('FS_PS_FORGOTTEN_REASON2','I know my password, but it’s not working');
define('FS_PS_FORGOTTEN_REASON2_TIP','Tip: please double check the account you\'re trying to sign in to. Sometimes people mistype the email address. Please also make sure to use the correct domain for your account, such as hotmail.com, live.com, or outlook.com.');
define('FS_PS_FORGOTTEN_REASON3','I think someone else is using my FS.COM account');
define('FS_PS_FORGOTTEN_REASON3_TIP','Optional: why do you think someone else has access to your account?');
define('FS_PS_FORGOTTEN_REASON3_OPTION1','Select reason');
define('FS_PS_FORGOTTEN_REASON3_OPTION2','Someone else is sending email from my account');
define('FS_PS_FORGOTTEN_REASON3_OPTION3','I see unusual sign-ins on my recent activity page');
define('FS_PS_FORGOTTEN_REASON3_OPTION4','Someone told me that my account has been hacked');
define('FS_PS_FORGOTTEN_REASON3_OPTION5','Purchases are showing up on my account that I did not authorize');
define('FS_PS_FORGOTTEN_REASON3_OPTION6','Other (please explain)');
define('FS_PS_FORGOTTEN_REASON3_TEXTAREA','Please write your reasons');
define('FS_PS_FORGOTTEN_NEXT','Next');

// tpl_password_forgotten_default.php
define('FS_PS_PROCESSING','Processing...');
define('FS_PS_RESET_MY_PASSWORD','Reset My Password');
define('FS_PS_BACK','Back');
define('FS_PS_ENTER_YOUR_EMAIL','Please enter the email address for your FS account & we’ll email you a link to reset your password.');
define('FS_PS_EMAIL_ADDRESS','Email Address:');
define('FS_PS_PLEASE_ENTER_ACCOUNT_MAIL','Please enter your account e-mail');
define('FS_PS_SUBMIT','Submit');
define('FS_PS_FORGOTTEN_ALSO','You can also:');
define('FS_PS_FORGOTTEN_REGISTER','Register for a new account?');
define('FS_PS_FORGOTTEN_CONTACT','Contact us?');

// error tip
define('FS_PS_FORGOTTEN_TIP_CHOOSE_REASON','Please choose your reason.');
define('FS_PS_FORGOTTEN_TIP_NOT_FIND_EMAIL','This email isn\'t associated with an account. Please try a different email.');






?>
