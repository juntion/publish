<?php
// fairy 2017.12.18 整理
// 语言包中用双引号，考虑到小语种尤其是法语中经常出现单引号的情况。
// 用户登录、注册、企业注册、修改资料。
define('FS_SIGN_IN',"Se connecter");
define('FS_JOIN_NOW',"Inscrivez-vous");
define('FS_WELCOME_BACK',"Bon Retour");
define('FS_WELCOME',"Bienvenue");
define('FS_NEW_CUSTOMER',"Nouveau client ?");
define('FS_CREATE_ACCOUNT',"Créez un nouveau compte");
define('FS_REGIST_BUSINESS_ACCOUNT',"Créez Un Compte d'Entreprise");
define('FS_SUBMIT_UPDATE_TO_BUSINESS_ACCOUNT','Compte d\'Entreprise');
define('FS_ALREADY_HAS_ACCOUNT',"Déjà un compte enregistré ?");
define('FS_UPGRADE',"Soumettre l'Inscription");
define('FS_UPGRADE_NEW',"Mettre à Jour");
//密码
define('FS_FORGOT_YOUR_PASSWORD',"Mot de passe oublié ?");
//其他登录
define('FS_LOGIN_BY_OTHER',"Par d'autres moyens");
define('FS_SIGN_IN_GOOGLE',"Connectez-vous avec Google");
define('FS_SIGN_IN_PAYPAL',"Connectez-vous avec Paypal");
define('FS_SIGN_IN_FACEBOOK',"Connectez-vous avec Facebook");
define('FS_SIGN_IN_LINKEDIN',"Connectez-vous avec Linkedin");
// 企业注册
define('FS_COMPANY_INFO',"Information d'Entreprise");
define('FS_CONTACT_INFO',"COORDONNÉES");
define('FS_BUSINESS_REGIST_SUCCESS_TIP', 'Félicitations, vous avez enregistré un compte d\'entreprise avec succès.');
// 行业选择
define('FS_INDUSTRY_SELECT_COM','Communications, Télécommunications');
define('FS_INDUSTRY_SELECT_CONSTRUCT','Construction, Ingénierie');
define('FS_INDUSTRY_SELECT_CONSULT','Consultation, Fournisseurs de Solutions');
define('FS_INDUSTRY_SELECT_ENERGY','Énergie, Alimentation, Pétrole');
define('FS_INDUSTRY_SELECT_GOVERNMENT','Gouvernement');
define('FS_INDUSTRY_SELECT_HEALTH','Soins de Santé, Médicale');
define('FS_INDUSTRY_SELECT_IT','Haute Technologie, IT');
define('FS_INDUSTRY_SELECT_MANU','Fabrication, Chemiques');
define('FS_INDUSTRY_SELECT_MEDIA','Média, Édition, Publicité');
define('FS_INDUSTRY_SELECT_NON','Non-Profit, Association');
define('FS_INDUSTRY_SELECT_RETAIL','Vente au détail, Distribution, Commerce, En gros');
define('FS_INDUSTRY_SELECT_SERVICE','Service');
define('FS_INDUSTRY_SELECT_TRANS','Transport, Logistique');
// 企业升级
define('FS_APPLY_BUSINESS_SUCCESS_TIP','Nous avons reçu votre demande, veuillez attendre la vérification et la validation.');
define('FS_APPLY_BUEINESS_EXIST_TIP','Désolé ! C\'est déjà un compte d\'entreprise ou vous avez déjà envoyé une demande de compte d\'entreprise par cet e-mail.');
define('FS_APPLY_BUSINESS_SUCCESS_JUMP_TIP','Cliquez ici pour entrer dans votre centre de compte.');

// 第3方登录
define('FS_THIRD_PARTY_BIND_TIP',"Si vous possédez déjà un compte FS.COM, vous pouvez le lier pour nous aider à mieux gérer vos données personnelles et préférences.");
define('FS_LINK_NOW',"Lier Maintenant");
define('FS_HAVE_FS_ACCOUNT',"Nouveau client ?");
define('FS_GOOGLE_USER_DEAR',"Cher");
define('FS_GOOGLE_USER_USER',"utilisateur");
define('FS_GOOGLE_USER_WELCOME',", bienvenue");
define('FS_SKIP',"ignorer");

// 游客登录页面   
define('FS_LOGIN_REGIST_GUEST','Commander en tant qu\'invité');
define('FS_LOGIN_REGIST','Créer un compte');
define('FS_LOGIN_REGIST_1','Commander en tant qu\'invité');
define('FS_LOGIN_REGIST_2','Pas de compte ?');
define('FS_LOGIN_REGIST_3','Votre achat sera facilité par :');
define('FS_LOGIN_REGIST_4','Adresses de livraison enregistrées');
define('FS_LOGIN_REGIST_5','Listes d\'achats');
define('FS_LOGIN_REGIST_6','Accès facile à l\'historique des commandes');
define('FS_LOGIN_REGIST_7','Vous ne voulez pas vous inscrire ?');
define('FS_LOGIN_REGIST_8','Passez à la caisse et créez un compte plus tard.');

// fairy 2018.8.8 改版 
define('FS_MY_FS_ADVANTAGE',"Avantages du Compte FS");
define('FS_MY_FS_ADVANTAGE0',"Pour faciliter vos achats");
define('FS_MY_FS_ADVANTAGE1',"Paiement rapide et facile");
define('FS_MY_FS_ADVANTAGE2',"Consulter l'historique et le suivi de commandes");
define('FS_MY_FS_ADVANTAGE3',"Demander des devis ou envoyer un bon de commande efficacement");
define('FS_MY_FS_ADVANTAGE4',"Obtenir un support technique et une conception de solution");
define('FS_DONT_HAVE_FS_ACCOUNT',"Nouveau client ?");
define('FS_QUICKLY_SET_UP_ACCOUNT',"Créez rapidement un compte sécurisé.");
define('FS_LOG_ADVANTAGE',"Connectez-vous pour réaliser vos paiements plus rapidement depuis votre compte.");
define('FS_SIGN_OR_LOGIN','Connectez-vous à FS ou <a href="'.zen_href_link('regist','','SSL').'">Créez un nouveau compte</a>');
define('FS_HAVE_ACCOUNT','Déjà un compte enregistré ? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Se connecter</a>');
//2018-10-9carr m端游客入口
define('FS_LOG_ChecGuest',"Commander en tant qu'invité");

//2018 12 4 helun
define('FS_LOG_RE_01',"Nouveau Client");
define('FS_LOG_RE_02',"Économisez du temps maintenant.");
define('FS_LOG_RE_03',"Vous n'avez pas besoin d'un compte pour effectuer le paiement.");
define('FS_LOG_RE_04',"Économisez du temps plus tard.");
define('FS_LOG_RE_05',"Créez un compte de FS.COM pour un paiement rapide et un accès facile à l'historique des commandes.");

// 登录页面remember me和气泡
define('FS_REMEMBER_ME',"Se souvenir de moi");
define('FS_SIGN_IN_REMEMBER_ME_01',"Pour sécuriser votre compte, utilisez cette option");
define('FS_SIGN_IN_REMEMBER_ME_02',"uniquement sur vos appareils personnels. ");

// 2020-02-25 登录注册页文案优化
define('FS_LOGIN_RIGHT_TITLE', 'Connectez-vous à FS ou');
define('FS_FORGOT_PASSWORD',"Mot de passe oublié ?");
define('FS_LOGIN_KEEP_ME_SIGNED_IN', 'Se souvenir de moi');
define('FS_LOGIN_OTHER_NEW', "Par d'autres moyens");
define('FS_EMAIL_ADDRESS_NEW',"Adresse E-mail");

// 2020-10-12 第三方登陆
define('FS_3RD_01','Mot de Passe');
define('FS_3RD_02','Confirmer le Mot de Passe');
define('FS_3RD_03','Envoyer');
define('FS_3RD_04','Avez-vous un compte FS ?');
define('FS_3RD_05','Lien vers un compte existant');
define('FS_3RD_06','Adresse E-mail @@@ :');
define('FS_3RD_07','Nous utiliserons vos informations de @@@ pour créer votre compte de FS.');
define('FS_3RD_08','Créer un compte');

define('FS_3RD_09','Lier un compte existant');
define('FS_3RD_10','Connectez-vous à FS pour finir de lier votre compte avec @@@.');
define('FS_3RD_11','E-mail de FS');
define('FS_3RD_12','Mot de Passe de FS');
define('FS_3RD_14','Lier votre compte');
define('FS_3RD_15','Vous pouvez également :');

define('FS_3RD_16','Associé avec succès.');
define('FS_3RD_17','Vous pouvez maintenant vous connecter à FS en utilisant votre compte @@@.');
define('FS_3RD_18','Créer un nouveau compte');

// 2020-10-27 忘记密码
define('FS_PS_PASSWORD_FORGOTTEN_TOO_FREQUENT','Votre demande est trop fréquente. Veuillez réessayer au moins une minute plus tard.');
