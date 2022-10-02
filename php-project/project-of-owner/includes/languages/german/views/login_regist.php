<?php
// fairy 2017.12.18 整理
// 语言包中用双引号，考虑到小语种尤其是法语中经常出现单引号的情况。
// 用户登录、注册、企业注册、修改资料。
define('FS_SIGN_IN',"Anmelden");
define('FS_JOIN_NOW',"Jetzt registrieren");
define('FS_WELCOME_BACK',"Willkommen zurück ");
define('FS_WELCOME',"Willkommen");
define('FS_NEW_CUSTOMER',"Neukunde?");
define('FS_CREATE_ACCOUNT',"Konto eröffnen");
define('FS_REGIST_BUSINESS_ACCOUNT',"Geschäftskonto eröffnen");
define('FS_SUBMIT_UPDATE_TO_BUSINESS_ACCOUNT',"Auf Geschäftskonto upgraden");
define('FS_ALREADY_HAS_ACCOUNT',"Haben Sie schon ein Konto?");
define('FS_UPGRADE_NEW',"Registrierung einreichen");
//密码
define('FS_FORGOT_YOUR_PASSWORD',"Passwort vergessen?");
//同意协议
define('FS_REIGST_AGREE',"Mit Ihrer Anmeldung erklären Sie sich mit unseren <a href=\"terms_of_use.html\">AGB</a> sowie unserer <a href=\"privacy_policy.html\">Datenschutzerklärung</a> einverstanden.");
//其他登录
define('FS_LOGIN_BY_OTHER',"Andere Wahlen");
define('FS_SIGN_IN_GOOGLE',"Mit Google anmelden");
define('FS_SIGN_IN_PAYPAL',"Mit Paypal anmelden");
define('FS_SIGN_IN_FACEBOOK',"Mit Facebook anmelden");
define('FS_SIGN_IN_LINKEDIN',"Mit Linkedin anmelden");
// 企业注册
define('FS_COMPANY_INFO',"Information der Firma");
define('FS_CONTACT_INFO',"KONTAKTINFORMATION");
define('FS_BUSINESS_REGIST_SUCCESS_TIP', 'Herzlichen Glückwunsch, Sie haben sich ein Geschäftskonto erfolgreich registriert.');
// 行业选择
define('FS_INDUSTRY_SELECT_COM','Kommunikation, Telekommunikation');
define('FS_INDUSTRY_SELECT_CONSTRUCT','Architektur, Engineering');
define('FS_INDUSTRY_SELECT_CONSULT','Beratung, Lösungsanbieter');
define('FS_INDUSTRY_SELECT_ENERGY','Energie, Strom, Erdöl');
define('FS_INDUSTRY_SELECT_GOVERNMENT','Regierung');
define('FS_INDUSTRY_SELECT_HEALTH','Gesundheitspflege');
define('FS_INDUSTRY_SELECT_IT','Hightech, IT');
define('FS_INDUSTRY_SELECT_MANU','Herstellung, Chemieindustrie');
define('FS_INDUSTRY_SELECT_MEDIA','Medien, Verlag, Werbung');
define('FS_INDUSTRY_SELECT_NON','Gemeinnütziger Verein');
define('FS_INDUSTRY_SELECT_RETAIL','Einzelhandel, Distribution, Handel, Großhandel');
define('FS_INDUSTRY_SELECT_SERVICE','Service');
define('FS_INDUSTRY_SELECT_TRANS','Transport, Logistik');
// 企业升级
define('FS_APPLY_BUSINESS_SUCCESS_TIP','Wir haben Ihre Bewerbung erhalten. Warten Sie bitte auf Bestätigung und Überprüfung!');
define('FS_APPLY_BUEINESS_EXIST_TIP','Die E-Mail-Adresse war Geschäftskonto oder hat um ein Geschäftskonto beworben.');
define('FS_APPLY_BUSINESS_SUCCESS_JUMP_TIP','Klicken Sie hier, um Ihr Kontozentrum eingeben.');

// 游客登录页面
define('FS_LOGIN_REGIST_GUEST','Als Besucher zur Kasse gehen');
define('FS_LOGIN_REGIST','Neues Konto eröffen');
define('FS_LOGIN_REGIST_1','Ohne Anmeldung kaufen');
define('FS_LOGIN_REGIST_2','Neuer Kunde?');
define('FS_LOGIN_REGIST_3','Um den Einkauf zu erleichtern:');
define('FS_LOGIN_REGIST_4','Gespeicherte Lieferadressen');
define('FS_LOGIN_REGIST_5','Einkaufslisten');
define('FS_LOGIN_REGIST_6','Bestellhistorie anzeigen');
define('FS_LOGIN_REGIST_7','Ich möchte mich nicht registrieren');
define('FS_LOGIN_REGIST_8','Zur Kasse gehen und später registrieren.');

// fairy 2018.8.8 改版
define('FS_MY_FS_ADVANTAGE',"Die Vorteile mit einem Konto bei FS");
define('FS_MY_FS_ADVANTAGE0',"Um den Einkauf zu erleichtern");
define('FS_MY_FS_ADVANTAGE1',"Bestellen Sie<br/> schnell und einfach");
define('FS_MY_FS_ADVANTAGE2',"Verfolgen Sie<br/> Ihre Bestellungen<br/> und den Lieferstatus");
define('FS_MY_FS_ADVANTAGE3',"Senden Sie Angebotsanfragen / Beschaffungsaufträge");
define('FS_MY_FS_ADVANTAGE4',"Erhalten Sie<br/> Tech-Support und<br/> Lösungsentwürfe");
define('FS_DONT_HAVE_FS_ACCOUNT',"Sie haben noch kein Konto bei FS?");
define('FS_QUICKLY_SET_UP_ACCOUNT',"Schnell ein sicheres Konto eröffnen.");
define('FS_LOG_ADVANTAGE',"Melden Sie sich für schnellere Kaufabwicklung mit Ihren Kontoinformationen an. ");
define('FS_SIGN_OR_LOGIN','Bei FS anmelden oder <a href="'.zen_href_link('regist','','SSL').'">Konto eröffnen</a>');
define('FS_HAVE_ACCOUNT','Haben Sie schon ein Konto? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Anmelden</a>');
// tom 2018.12.3改版
define('FS_LOG_RE_01',"Neuer Kunde?");
define('FS_LOG_RE_02',"Später registrieren");
define('FS_LOG_RE_03',"Ohne Konto können Sie auch eine Bestellung aufgeben.");
define('FS_LOG_RE_04',"Jetzt registrieren");
define('FS_LOG_RE_05',"Um den Einkauf bei FS.COM zu erleichtern.");

//2018-10-9carr m端游客入口
define('FS_LOG_ChecGuest',"Ohne Anmeldung kaufen");


// 登录页面remember me和气泡
define('FS_REMEMBER_ME',"Angemeldet bleiben ");
define('FS_SIGN_IN_REMEMBER_ME_01',"Um Ihr Konto zu schützen, wählen Sie diese ");
define('FS_SIGN_IN_REMEMBER_ME_02',"Option nur auf Ihrem persönlichen Gerät. ");

// 2020-02-25 登录注册页文案优化
define('FS_LOGIN_RIGHT_TITLE', 'Bei FS anmelden oder');
define('FS_FORGOT_PASSWORD',"Passwort vergessen?");
define('FS_LOGIN_KEEP_ME_SIGNED_IN', 'Angemeldet bleiben');
define('FS_LOGIN_OTHER_NEW', 'Oder sich anmelden mit');
define('FS_EMAIL_ADDRESS_NEW',"E-Mail-Adresse");

// 2020-10-12 第三方登陆
define('FS_3RD_01','Passwort');
define('FS_3RD_02','Passwort bestätigen');
define('FS_3RD_03','Konto eröffnen');
define('FS_3RD_04','Haben Sie schon ein Konto bei FS?');
define('FS_3RD_05','Konto verknüpfen');
define('FS_3RD_06','E-Mail-Adresse Ihres @@@-Kontos:');
define('FS_3RD_07','Wir verwenden die Informationen Ihres @@@-Kontos, um Ihr FS-Konto zu erstellen.');
define('FS_3RD_08','Konto eröffnen');

define('FS_3RD_09','Konto verknüpfen');
define('FS_3RD_10','Melden Sie sich bei FS an, um Ihr FS-Konto mit Ihrem @@@-Konto zu verknüpfen.');
define('FS_3RD_11','E-Mail Ihres FS-Kontos');
define('FS_3RD_12','Passwort Ihres FS-Kontos');
define('FS_3RD_14','Bestätigen');
define('FS_3RD_15','Sie können auch:');

define('FS_3RD_16','Erfolgreich verknüpft!');
define('FS_3RD_17','Sie haben Ihr @@@-Konto erfolgreich mit Ihrem FS-Konto verknüpfen.');
define('FS_3RD_18','Konto eröffnen');

// 2020-10-27 忘记密码
define('FS_PS_PASSWORD_FORGOTTEN_TOO_FREQUENT','Ihre Anfrage ist zu häufig. Bitte versuchen Sie es in mindestens 1 Minute später erneut.');