<?php
// fairy 2017.12.18 整理
// 语言包中用双引号，考虑到小语种尤其是法语中经常出现单引号的情况。
// 用户登录、注册、企业注册、修改资料。
define('FS_SIGN_IN',"Sign in");
define('FS_NEW_CUSTOMER',"New customer?");
define('FS_CREATE_ACCOUNT',"Create an account");
define('FS_REGIST_BUSINESS_ACCOUNT',"Register Business Account");
define('FS_SUBMIT_UPDATE_TO_BUSINESS_ACCOUNT','Upgrade to a Business Account');
define('FS_ALREADY_HAS_ACCOUNT',"Already have an account?");
define('FS_UPGRADE_NEW',"Upgrade");
define('FS_JOIN_NOW',"Join now");
define('FS_WELCOME_BACK',"Welcome Back");
define('FS_WELCOME',"Welcome");
//密码
define('FS_FORGOT_YOUR_PASSWORD',"Forgot your password?");
//同意协议
define('FS_REIGST_AGREE',"By creating an account, you agree to our <a href=\"terms_of_use.html\" class=\"black\">Conditions of Use</a> and <a href=\"privacy_policy.html\" class=\"black\">Privacy Notice</a>.");
//其他登录
define('FS_LOGIN_BY_OTHER',"Sign in with other ways");
define('FS_SIGN_IN_GOOGLE',"Sign in with google");
define('FS_SIGN_IN_PAYPAL',"Sign in with Paypal");
define('FS_SIGN_IN_FACEBOOK',"Sign in with Facebook");
define('FS_SIGN_IN_LINKEDIN',"Sign in with Linkedin");

// 企业注册
define('FS_COMPANY_INFO',"Company Information");
define('FS_CONTACT_INFO',"Contact Information");
define('FS_BUSINESS_REGIST_SUCCESS_TIP', 'Congratulations, you have registered a business account successfully.');
// 行业选择
define('FS_INDUSTRY_SELECT_COM',"Communications, Telecommunications");
define('FS_INDUSTRY_SELECT_CONSTRUCT',"Construction, Engineering");
define('FS_INDUSTRY_SELECT_CONSULT',"Consulting, Solution Providers");
define('FS_INDUSTRY_SELECT_ENERGY',"Energy, Power, Petroleum");
define('FS_INDUSTRY_SELECT_GOVERNMENT',"Government");
define('FS_INDUSTRY_SELECT_HEALTH',"Healthcare, Medical");
define('FS_INDUSTRY_SELECT_IT',"High Tech, IT");
define('FS_INDUSTRY_SELECT_MANU',"Manufacturing, Chemicals");
define('FS_INDUSTRY_SELECT_MEDIA',"Media, Publishing, Advertising");
define('FS_INDUSTRY_SELECT_NON',"Non-Profit, Association");
define('FS_INDUSTRY_SELECT_RETAIL',"Retail, Distribution, Trade, Wholesale");
define('FS_INDUSTRY_SELECT_SERVICE',"Service");
define('FS_INDUSTRY_SELECT_TRANS',"Transportation, Logistics");
// 企业升级
define('FS_APPLY_BUSINESS_SUCCESS_TIP',"Your application has been received, please wait for verification and validation.");
define('FS_APPLY_BUEINESS_EXIST_TIP',"Sorry! The mailbox has been registered as a business account or has been applied for a business account.");
define('FS_APPLY_BUSINESS_SUCCESS_JUMP_TIP',"Click here to enter your account center.");
// 第3方登录
define('FS_THIRD_PARTY_BIND_TIP',"If you already have a FS.COM account, you may link it for helping us better maintian your personal data and preferences.");
define('FS_LINK_NOW',"Link Now");
define('FS_HAVE_FS_ACCOUNT',"Don't have a FS.COM account?");
define('FS_GOOGLE_USER_DEAR',"Dear");
define('FS_GOOGLE_USER_USER',"user");
define('FS_GOOGLE_USER_WELCOME',", welcome");
define('FS_SKIP',"skip");

// 游客登录页面
define('FS_LOGIN_REGIST_GUEST','Checkout as guest');
define('FS_LOGIN_REGIST','Create an account');
define('FS_LOGIN_REGIST_1','Checkout as a guest');
define('FS_LOGIN_REGIST_2','Not a customer yet?');
define('FS_LOGIN_REGIST_3','Your purchase will become easier by:');
define('FS_LOGIN_REGIST_4','Saved shipping addresses');
define('FS_LOGIN_REGIST_5','Shopping lists');
define('FS_LOGIN_REGIST_6','Easy access to order history');
define('FS_LOGIN_REGIST_7','Don\'t want to register?');
define('FS_LOGIN_REGIST_8','Proceed to checkout and create an account later.');

// fairy 2018.8.8 改版
define('FS_MY_FS_ADVANTAGE',"Benefits of FS Account");
define('FS_MY_FS_ADVANTAGE0',"To make shopping easier");
define('FS_MY_FS_ADVANTAGE1',"Checkout quickly and easily");
define('FS_MY_FS_ADVANTAGE2',"View order history and track shipping status");
define('FS_MY_FS_ADVANTAGE3',"Get quotes or submit a purchase order efficiently");
define('FS_MY_FS_ADVANTAGE4',"Get technical support and solution design");
define('FS_DONT_HAVE_FS_ACCOUNT',"Don't have an account?");
define('FS_QUICKLY_SET_UP_ACCOUNT',"Quickly set up a secure account.");
define('FS_LOG_ADVANTAGE',"Log on to checkout faster with your account info. ");
define('FS_SIGN_OR_LOGIN','Sign in to FS or <a href="'.zen_href_link('regist','','SSL').'">Create an account</a>');
define('FS_HAVE_ACCOUNT','Already have an account? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Sign in</a>');
// tom 2018.12.3改版
define('FS_LOG_RE_01',"New Customer");
define('FS_LOG_RE_02',"Save time now.");
define('FS_LOG_RE_03',"You don't need an account to check out.");
define('FS_LOG_RE_04',"Save time later.");
define('FS_LOG_RE_05',"Create a FS.COM account for fast checkout<br>and easy access to order history.");

//2018-10-9carr m端游客入口
define('FS_LOG_ChecGuest',"Check out as a guest");

// 登录页面remember me和气泡
define('FS_REMEMBER_ME',"Remember me");
define('FS_SIGN_IN_REMEMBER_ME_01',"To keep your account secure, use this ");
define('FS_SIGN_IN_REMEMBER_ME_02',"option only on your personal devices. ");

// 2020-02-25 登录注册页文案优化
define('FS_LOGIN_RIGHT_TITLE', 'Sign in to FS or');
define('FS_FORGOT_PASSWORD',"Forgot password?");
define('FS_LOGIN_KEEP_ME_SIGNED_IN', 'Keep me signed in');
define('FS_LOGIN_OTHER_NEW', 'or sign in with');
define('FS_EMAIL_ADDRESS_NEW',"Email Address");

// 2020-10-12 第三方登陆
define('FS_3RD_01','Password');
define('FS_3RD_02','Confirm Password');
define('FS_3RD_03','Submit');
define('FS_3RD_04','Already using FS?');
define('FS_3RD_05','Link to an existing account');
define('FS_3RD_06','@@@ Email Address:');
define('FS_3RD_07','We\'ll use your @@@ detail to create your FS account.');
define('FS_3RD_08','Creat an account');

define('FS_3RD_09','Link an existing account');
define('FS_3RD_10','Sign into FS to finish linking your account with @@@.');
define('FS_3RD_11','FS Email');
define('FS_3RD_12','FS password');
define('FS_3RD_14','Link your accounts');
define('FS_3RD_15','You can also:');

define('FS_3RD_16','Associated successfully.');
define('FS_3RD_17','You can now quilckly log in to your FS ID using your @@@ account.');
define('FS_3RD_18','Create a new account');

// 2020-10-27 忘记密码
define('FS_PS_PASSWORD_FORGOTTEN_TOO_FREQUENT','Your request is too frequent. Please try again in at least 1minute later.');
