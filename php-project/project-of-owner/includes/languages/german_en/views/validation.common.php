<?php
// 公共表单验证
// firstname
define('FS_FIRST_REQUIRED_TIP',"Please enter your first name.");
define('FS_FIRST_MIN_TIP',"First name must be 2 characters minimum.");
define('FS_FIRST_MAX_TIP',"First name must be 32 characters maximum.");
// lastname
define('FS_LAST_REQUIRED_TIP',"Please enter your last name.");
define('FS_LAST_MIN_TIP',"Last name must be 2 characters minimum.");
define('FS_LAST_MAX_TIP',"Last name must be 32 characters maximum.");
// email
define('FS_YOUR_EMAIL_ADDRESS',"Your Email address");
define('FS_EMAIL_REQUIRED_TIP',"Please enter your email address.");
define('FS_EMAIL_FORMAT_TIP',"Please enter a valid email address.");
define('FS_EMAIL_HAS_REGISTERED_TIP',"This email is already registered.");
define('FS_EMAIL_HAS_REGISTERED_TIP1',"Sorry, the email have been registered. Please Sign in.");
define('FS_EMAIL_NOT_FOUND_TIP',"This email address is not registered.");
define('FS_EMAIL_NOT_ACTIVED_TIP','Sorry! Your mailbox is not activated, please log in to activate.');
define('FS_EMAIL_HAS_REGISTERED_TIP_01',"Account already exists. Click here to <a href='".zen_href_link(FILENAME_LOGIN,'','SSL')."'>sign in</a>.");
// new email
define('FS_NEW_EMAIL_ADDRESS','New Email Address');
define('FS_NEW_EMAIL_REQUIRED_TIP',"New email address cannot be empty.");
// confirm new email
define('FS_CONFIRM_NEW_EMAIL','Re-enter new email');
define('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP',"Please re-enter your email address.");
define('FS_NEW_EMAIL_MATCH_TIP',"New email address must match.");
// password
define('FS_PASSWORD_REQUIRED_TIP',"Please enter your password.");
define('FS_CURRENT_PASSWORD_REQUIRED_TIP',"Please enter your current password.");
define('FS_PASSWORD_FORMAT_TIP',"6 characters minimum; at least one letter and one number.<br/>Special characters(_ ? @ ! # $ % & * .) allowed.");
define('FS_PASSWORD_ERROR_TIP',"The password is incorrect. Please try again.");
define('FS_OLD_PASSWORD_ERROR_TIP',"Your old password is not correct, check it again please !");
// confirm password
define('FS_CONFIRM_PASSWORD',"Confirm password"); // 只有注册表单才需要
define('FS_CONFIRM_PASSWORD_REQUIRED_TIP',"Please confirm your new password.");
define('FS_PASSWORD_MATCH_TIP',"New password must match.");
// new password
define('FS_NEW_PASSWORD','New password');
define('FS_NEW_PASSWORD_REQUIRED_TIP',"Please enter your new password.");
define('FS_PASSWORD_REQUIREMENT',"Your password must be:");
define('FS_PASSWORD_REQUIREMENT1',"6 characters minimun");
define('FS_PASSWORD_REQUIREMENT2',"at least one letter and one number");
// confirm new password
define('FS_CONFIRM_NEW_PASSWORD','Confirm new password');
define('FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP',"Confirm new password cannot be empty.");
define('FS_PASSWORD_DIFFERENT','The new password must be different from your old password');
define('FS_NEW_PASSWORD_MATCH_TIP',"New password must match.");
//验证码
define('FS_IMAGE',"Image");
define('FS_TRY_DIFFERENT_IMAGE',"Try a different image");
define('FS_TYPE_CHAR',"Type characters");
define('FS_IMAGE_FORM_TIP',"Enter the characters as they are shown in the image.");
// AGREE
define('FS_AGREE_REQUIRED_TIP',"Please agree to the Privacy Policy.");
//Company name
define('FS_COMPANY_NAME_REQUIRED_TIP',"Please enter your company name.");
define('FS_COMPANY_NAME_MIN_TIP',"Company name must be 2 characters minimum.");
define('FS_COMPANY_NAME_MAX_TIP',"Company name must be 300 characters maximum.");
//industry
define('FS_SELECT_INDUSTRY','Select Industry');
define('FS_INDUSTRY_REQUIRED_TIP',"Please select which industry your company belongs to.");
//TAX/VAT
define('FS_TAX_PLACEHOLDER','eg:DE123456789');
define('FS_TAX_REQUIRED_TIP','Please enter a TAX Number.');
define('FS_TAX_FORMAT_TIP','Please enter a valid VAT Number. eg: DE123456789');
define('FS_TAX_FORMAT_ARGENTINA_TIP','Please enter valid Tax Number eg: 00.000.000/0000-00.');
define('FS_TAX_FORMAT_BRAZIL_TIP','Please enter valid Tax Number eg: 00-00000000-0.');
define('FS_TAX_FORMAT_CHILE_TIP','Tax Number should be 7 digits minimum.');
//phone
define('FS_PHONE_REQUIRED_TIP','Please enter your phone number.');
define('FS_PHONE_FORMAT_TIP','Allow digits only, at least 7 ones.');
//国家
define('FS_SEARCH_YOUR_COUNTRY','Search your country');
define('FS_COUNTRY_REQUIRED_TIP','Please select your country/region.');
//QTY
define('FS_PRODUCT_QTY_REQUIRED_TIP','The product QTY cannot be empty.');
define('FS_PRODUCT_QTY_FORMAT_TIP','This product qty is invalid, please correct it and try again');
// get a quote
define('COMMENTS_OR_QUESTIONS_REQUIRED_TIP','Comments/Questions cannot be empty.');
// feedback
define('FEEDBACK_RATE_REQUIRED_TIP','Please rate your experience.');
define('FEEDBACK_TOPIC_REQUIRED_TIP','Please select a topic.');
define('FEEDBACK_CONTENT_REQUIRED_TIP','Please enter more than 10 characters.');
// review
define('FS_REVIEW_RATING_REQUIRED_TIP','Please rate this product.');
define('FS_REVIEW_TITLE_REQUIRED_TIP','Your review title is required.');
define('FS_REVIEW_TITLE_MIN_TIP','Please write a title of review with more than 3 characters.');
define('FS_REVIEW_TITLE_MAX_TIP','Your review title must be 200 characters maximum.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP','Your review content is required.');
define('FS_REVIEW_CONTENT_MIN_TIP','Please write a review with more than 10 characters.');
define('FS_REVIEW_CONTENT_MAX_TIP',"Please reduce the length of your review below 5,000 characters.");
// my case
define('FS_CASE_TYPE_REQUIRED_TIP','Please choose the service type.');
define('FS_CASE_CONTENT_REQUIRED_TIP','Please describe your questions so that we can handle your request quicker.');
define('FS_CASE_CONTENT_MAX_TIP','Please don\'t exceed 3,000 characters.');
// apply money
define('FS_APPLY_MONEY_REQUIRED_TIP','Please enter the amount you expect.');
define('FS_APPLY_MONEY_FORMAT_TIP','Please enter valid amount of up to 2 decimals.');
define('FS_APPLY_MONEY_REASON_TIP','Your comments will help FS handle your request quickly.');

//review new
define("FS_REVIEW_TITLE_REQUIRED_TIP_NEW",'Please fill in your review title.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP_NEW','Please fill in your review.');

define('FS_OLD_PASSWORD_REASON','Your old password is not correct, check it again please.');
define('FS_SUBMIT_TOO_FREQUENT','Submission is too frequent');
