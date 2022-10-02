<?php
// 公共的语言包都放到这里

// classic/order.info.php
//Content in My_dashboard
//2016-9-6 add by frankie
define('FIBERSTORE_ORDER_STATUS','Statut');
define('FIBERSTORE_VIEW_DETAILS','Voir les Détails');
define('FIBERSTORE_ORDER_NUMBER','Numéro');
define('FIBERSTORE_ORDER_CUSTOMER_NAME','Nom de client');
define('FIBERSTORE_ORDER_TOTAL','Total ');
define('FIBERSTORE_ORDER_PAYMENT','paiement');
define('FIBERSTORE_DASHBOARD_NO_ORDER','Votre panier est vide..');

// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Posez à ');
define('FS_DIALOG_A',' une question');
define('FS_DIALOG_TITLE','Titre');
define('FS_DIALOG_YOUR','Le sujet de votre question est obligatoire');
define('FS_DIALOG_CONTENT','Contenu');
define('FS_DIALOG_PLEASE','Veuillez entrer vos questions');
define('FS_DIALOG_YOUR2','Votre contenu est obligatoire');
define('FS_DIALOG_PLEASE1',"Ne dépassez pas 3000 caractères.");
define('FS_DIALOG_EMAIL','Adresse e-mail');
define('FS_DIALOG_AGAIN','Ce courriel spécifié est invalide, veuillez le corriger et réessayer');
define('FS_DIALOG_COMMENTS','Commentaires/Questions');
define('FS_DIALOG_THIS','Ce champ est OBLIGATOIRE, Veuillez écrire au moins 10 caractères.');


// common/account_left_slide.php
//Content in account left slide
//2016-9-8      add by Frankie
define('MY_ACCOUNT','Mon Compte');
define('ORDER_CENTER','Centre de Commande');
define('ALL_ORDER','Toutes Mes Commandes');
define('PENDING_ORDER','Commandes en Cours');
define('TRANSACTION','Transaction de Commandes');
define('CANCELED_ORDER','Commandes Annulées');
define('EXCHANGE','Commandes d\'Échange & de Retour');
define('MY_ADDRESS','Mon Adresse');
define('NEWSLETTER','Bulletin');
define('CHANGE_PASSWORD','Modifier Votre Mot de Passe');
define('MY_REVIEWS','Mes Commentaires');
define('MY_QUESTION','Mes Questions');
define('MY_SALES_REPRESENTIVE','Ma Représentante de Ventes');
define('MY_CONTACT','Contactez');
define('FS_CONTACT_HELP','Avez-vous besoin de <br> renseignements ?');
define('FS_CONTACT_CHAT','Chat en Ligne');
//2017.5.12   add  by ery
define('ACCOUNT_LEFT_EDIT','Modifier Votre Compte');
define('ACCOUNT_LEFT_ORDER','Historique des Commandes');
define('ACCOUNT_LEFT_ADDRESS','Adresse');
define('ACCOUNT_LEFT_QUESTION','Questions');
define('ACCOUNT_LEFT_MANAGE','Gérer les Abonnements');
define('ACCOUNT_LEFT_QUOTATION','Devis Valide');
define('ACCOUNT_LEFT_QUOTATION_DETAIL','Détails du Devis Valide');
define('FS_CART_ORDER_PRICE','Prix de Commande Valide');
define('FS_CART_QUOTATION_PRICE','Prix de Référence Valide');
define('FS_REMOVED_QUOTATION','L\'offre spécial dans le devis sera remplacé par le prix en ligne à cause de la suppression.');

// 2018.11.29 fairy 个人中心改版
define('FS_MY_ACCOUNT','Mon Compte');
define('ACCOUNT_SETTING','Paramètres du Compte');
define('FS_RETURN_ORDERS','Commandes de Retour');
define('FS_MY_QUOTES','Mes Devis');
define('FS_WISH_LIST','Liste d\'Envies');
define('FS_ADDRESS_BOOK','Carnet d\'Adresses');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">Retour à la </span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">Page d\'Accueil</a>');

// english.php
define("FS_COMMON_CONTINUE",'Continuer');
define("FS_COMMON_OPERATION",'Opération');
define('FS_COMMON_VIEW','Voir');
define('FS_PURCHASE_ORDER_NUMBER','Numéro de Bon de Commande');
define('FS_FILE_UPLOADED_SUCCESS','Fichier Ajouté avec Succès');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","Types de fichiers autorisés : PDF, JPG, PNG.");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","Types de fichiers autorisés : PDF, JPG, PNG. <br/>La taille maximale du fichier est de 4MB.");
define("FS_UPLOAD_PO_FILE",'Ajouter un Fichier de Bon de Commande');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Merci pour vos achats chez FS, en attente de votre prochaine visite.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Adresse de Rue, c/o");
define("ADDRESS_PLACE_HODLER2","Appartement, Chambre, Étage, etc.");
define("FS_ZIP_CODE","Code Postal");
define("FS_ADDRESS","Adresse");
define("FS_ADDRESS2","Adresse 2");
define('FS_CHECK_COUNTRY_REGION','Pays/Région');
define("FS_CHECKOUT_ERROR1","Votre Prénom est requis");
define("FS_CHECKOUT_ERROR2","Votre Nom est requis");
define("FS_CHECKOUT_ERROR3","Votre Adresse est requise");
define("FS_CHECKOUT_ERROR4","Votre Code Postal est requis");
define("FS_CHECKOUT_ERROR5","Votre Ville est requise");
define("FS_CHECKOUT_ERROR6","Votre Pays est requis");
define("FS_CHECKOUT_ERROR7","Votre Numéro de Téléphone est requis");
define("FS_CHECKOUT_ERROR8","Votre Numéro de TVA est requis");
define("FS_CHECKOUT_ERROR9","Votre État est requis.");
define("FS_CHECKOUT_ERROR10","Le Nom de Votre Entreprise est requis.");
define("FS_CHECKOUT_ERROR11","TVA Valide par exemple : FR12345678987");
define("FS_CHECKOUT_ERROR12","L'Adresse de Livraison devrait contenir au moins 4 caractères.");
define("FS_CHECKOUT_ERROR13","Votre nom devrait contenir au moins 2 caractères.");
define("FS_CHECKOUT_ERROR14","Votre prénom devrait contenir au moins 2 caractères.");
define("FS_CHECKOUT_ERROR15","Votre code postal devrait contenir au moins 3 caractères.");
define("FS_CHECKOUT_ERROR16","Nous ne livrons pas aux Boîtes Postales");
define("FS_CHECKOUT_ERROR17","Votre Type d'Adresse est requis.");
define("FS_CHECKOUT_ERROR28","Veuillez entrer un Code Postal valide");
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","L'adresse ligne 2 doit comporter entre 4 et 35 caractères.");
define("FS_CITY_MIN_MAX_TIP","L'adresse ligne 2 doit comporter entre 1 et 50 caractères.");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','Toutes les Commandes');
define('FS_ORDER_ALL_M','Tout');
define('FS_ORDER_PENDING','En Attente');
define('FS_ORDER_COMPLETED','Complétée');
define('FS_ORDER_CANCELLED','Annulée');
define('FS_ORDER_PURCHASE','Commande de PO');
define('FS_ORDER_PROGRESSING','Traitement');
define('FS_ORDER_RETURN_ITEM','Retour');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Le fichier a été ajouté avec succès.');


// common_service.php
define('COMMON_SERVICE_01','Contactez-Nous Maintenant');
define('COMMON_SERVICE_02','FS se concentre sur la solution de centre de données, de réseau d\'entreprise et de transmission optique pour vous aider à créer exactement ce dont vous avez besoin.  <br> Contactez-nous, nous sommes là pour vous aider 24 heures sur 24. ');
define('COMMON_SERVICE_03','Trouver d\'autres façons de nous contacter');
define('COMMON_SERVICE_04','Chat en ligne');
define('COMMON_SERVICE_05','Nous sommes là pour vous aider 24/7. Envoyez-nous un message maintenant pour une réponse rapide.');
define('COMMON_SERVICE_06','Chat en Ligne');
define('COMMON_SERVICE_07','Appelez-nous');
define('COMMON_SERVICE_08','Appelez le ');
define('COMMON_SERVICE_09',', ou nous vous rappelons.');
define('COMMON_SERVICE_10','Appelez-nous');
define('COMMON_SERVICE_11','E-mail');
define('COMMON_SERVICE_12','Notre équipe de service à la clientèle vous répondra dès que possible.');
define('COMMON_SERVICE_13','Écrivez-nous');
define('COMMON_SERVICE_14','Support Technique');
define('COMMON_SERVICE_15','Bénéficiez d\'un support et d\'une conception de solution gratuits en ligne pour votre projet.');
define('COMMON_SERVICE_16','Demande de Support');
define('COMMON_SERVICE_17','Présentation d\'une Équipe Excellente');
define('COMMON_SERVICE_18','FS ne refuse jamais la bonne inspiration des employés et encourage toujours chaque personne à s\'exprimer. C\'est pourquoi ');
define('COMMON_SERVICE_19','FS fournit un excellent service à ses clients dans le monde entier et vise à les améliorer constamment.');
define('COMMON_SERVICE_20','Commencer');
define('FS_SHOP_CART_ALERT_JS_13','De*');
define('FS_SHOP_CART_ALERT_JS_14','À*');
define('FS_SHOP_CART_ALERT_JS_15','Message Personnel (optionnel) :');
//quote
define('FS_VIEW_QUOTE_SHEET','Voir le Devis');
define('FS_PRODUCT_HAS_BEEN_ADDED','Le produit a été ajouté.');
define('FS_SAVE_CSRT_LIMIT_TIP','Veuillez entrer le nom du panier, au maximum 50 mots.');
define('FS_QUOTE','Devis');
define('FS_SAVED_CART_EMAIL','E-mail');



// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','À Propos de Nous');
define('FS_ABOUT_FS_COM','A Propos de FS.COM');
define('FS_FOOTER_WHY_US','Pourquoi Nous');
define('LATEST_NEWS','Salle des Nouvelles');
define('FS_FOOTER_LATEST','Salle des Nouvelles');
define('FS_FOOTER_CONTACT_US','Contactez-Nous');
// Frankie 2018.1.22
define('FS_IMPRINT','Avis Légal');
define('FS_FOOTER_LEGAL','Légal');
define('FS_FOOTER_LEGAL_NOTICE','Mentions Légales');
define('FS_FOOTER_PRIVACY_POLICY','Politique de Confidentialité');
define('FS_FOOTER_TERMS_OF_USE','Termes et Conditions');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','Service Clients');
define('FS_FOOTER_OEM','OEM & Personnalisation');
define('FS_FOOTER_PROPOS_DE_FS','À Propos de Nous');
define('FS_FOOTER_CONTACT','Contact');
define('FS_FOOTER_QUALITY_CONTROL','Contrôle de Qualité');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM','OEM & Personnalisation');
define('FS_FOOTER_WARRANTY','Garantie');
define('FS_FOOTER_POLICY','Politique de Retour');
define('FS_RETURN_POLICY','Politique de Retour');
define('FS_FOOTER_QUALITY','Engagement de Qualité');
define('FS_FOOTER_PARTNER','Compte d\'Entreprise');

// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','Paiement & Livraison');
define('FS_PAYMENT_METHODS','Moyens de Paiement');
define('FS_NET_AMP_W','Bon de Commande');
define('FS_FOOTER_DELIVERY','Expédition & Livraison');

// footer Quick Help
define('FS_FOOTER_QUICK_HELP','Aide Rapide');
define('FS_FOOTER_PURCHASE_HELP','Aide à l\'Achat');
define('FS_FORGOT_YOUR_PASSWORD','Mot de Passe Oublié ?');
define('FS_FOOTER_FAQ','FAQ');
define('FS_TRACK_YOUR_PACKAGE','Suivi de Votre Colis');

// footer Questions? Aron 2017.8.6
define("FS_YAO1","Des questions ? Parlez avec un expert");
define("FS_YAO2","Nous restons à votre disposition 24/7");
define("FS_YAO3","Chat en Ligne");
define("FS_YAO4","Communiquez avec une représentante");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Pages Populaires:');    //小语种没有这个

// 手机站切换版本
define('FS_FULL_SITE','E-mail');
define('FS_MOBILE_SITE','Site Mobile');
define('FS_FOOTER_LIVE_CHAT','Chat en Ligne');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_HIGH_QUALITY","Haute Qualité");
define("FS_SAFE_SHOPPING","Achat Sécurisé");
define("FS_FAST_DELIVERY","Retour sous RETURN_DAYS Jours");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"Confidentialité et Cookies");
define('FS_TERMS_OF_USE','Conditions d’Utilisation');
define('FS_TERMS_OF_USE_DE','Conditions d’Utilisation');
define('FS_SITE_MAP','Plan du Site');
define('FS_FOOTER_FEEDBACK','Donner Votre Avis');
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_FOOTER_COPYRIGHT","Copyright © 2009-YEAR ".FS_LOCAL_COMPANY_NAME." Tous Droits Réservés.");
define("FS_FOOTER_COPYRIGHT_M","Copyright © 2009-YEAR <span>".FS_LOCAL_COMPANY_NAME."</span> Tous Droits Réservés.");
//底部类目
define('FS_SUPPORT','Support');
define('FS_FOOTER_CUSTOMER_SERVICE','Service Clients');
define('FS_FOOTER_DELIVERY','Expédition & Livraison');
define('FS_FOOTER_WARRANTY','Garantie');
define('FS_FOOTER_REQUEST_A_SAMPLE','Demander un Echantillon');
define("FS_HLEP_CENTER","FS Support");

define("NEW_FOOTER_05",'Partenaires de Logistique :');
define("NEW_FOOTER_06",'Moyens de Paiement :');
define('FS_FOOTER_PARTNERS','Partenaires');




// common/footer_keyword_tag.php文件
define('FS_FOOTER_EASTERN_SIDE','Eastern Side, Second Floor, Science & Technology Park, No.6, Keyuan Road');
define('FS_FOOTER_NANSHAN','Nanshan District');
define('FS_FOOTER_SHENZHEN','Shenzhen');
//define('FS_FOOTER_COPYRIGHT','Copyright © 2009-');
define('FS_FOOTER_FS','FS.COM');
define('FS_FOOTER_ALL_RIGHTS','Tous Droits Réservés.');
define('FS_FOOTER_PRIVACY','Politique de Confidentialité');
define('FS_FOOTER_TERMS','Conditions d’Utilisation');
define('FS_FOOTER_MOBILE_SITE','Site Mobile');




// common/header.php文件
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','3');
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','Chat en Ligne');
define('FS_ONLINE_CAHT','Online Chat');
define('FS_LIVE_CAHT','Chat en Ligne');
define('FS_PRE_SALE','Service Avant-Vente');
define('FS_CHAT_WITH','Dialoguer avec Ventes en Ligne pour plus d\'informations avant l\'achat !');
define('FS_STAR','Commencer à Dialoguer');
define('FS_AFTER_SALE','Service Après-Vente');
define('FS_PL_GO','Si vous avez effectué un achat, s\'il vous plaît aller à ');
define('FS_MY_ORDER','la page de Mes commandes');
define('FS_PAGE_TO','à demander de l\'Aide en Ligne pour des détails de la commande.');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','Cherchez');
define('FS_HEADER_01','Rechercher...');
define('FS_HEADER_02','Recherche Chaude');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','Câbles MTP MPO');
define('FS_HEADER_09','Jarretières Optqiues LC');
define('FS_HEADER_10','Atténuateurs');
define('FS_HEADER_11','Historique de Recherche');
define('FS_HEADER_12','Effacer l\'historique');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'Aide & Support');
define('FS_CALL_US', 'Appelez-nous au');
define('FS_SAVED_CARTS', 'Paniers Enregistrés');
// 用户相关
define('FS_ACCOUNT', 'Compte');
define('FS_SIGN_IN','Se connecter');
define('FS_NEW_CUSTOMER','Nouveau Client ?');
define('FS_REGISTER_ACCOUNT','Créer un Compte');
define('FS_SIGN_OUT','Se Déconnecter');
define('FS_MY_ACCOUNT','Mon Compte');
define('FS_MY_ORDERS','Mes Commandes');
define('FS_MY_ORDER','Ma Commande');
define('FS_MY_ADDRESS','Mon Adresse');
define('FS_SOLUTIONS','Solutions');
define('FS_ALL_CATEGORIES','Catégories');
define('FS_PROJECT_INQUIRY','Consultez Nos Experts');
define('FS_SEE_ALL_OFFERINGS','Voir tous les produits');
define('FS_RESOURCES','Ressources');
define('FS_RELATED_INFO','Informations Connexes');
define('FS_CONTACT_US','Contact');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','Les prix et les disponibilités des produits peuvent varier selon le pays/la région.');
define('FS_NEW_LANGUAGE_CURRENCY','Langue/Monnaie');
define('FS_COUNTRY_REGION','Pays/Région');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','Menu');
define('FS_NETWORKING','Mise en Réseau');
define('FS_ORDER_HISTORY','Historique de Commandes');
define('FS_ADDRESS_BOOK',"Carnet d'Adresses");
define('FS_MY_CASES','Centre de Cas');
define('FS_MY_QUOTES','Mes Devis');
define('FS_ACCOUNT_SETTING','Paramètres de Compte');
define('FS_VIEW_ALL','Voir Tout');

// 搜索
define('FS_SEARCH_PRODUCTS','Chercher les Produits');
define('FS_NEW_CHOOESE_CURRENCY','Sélectionnez la Monnaie');
// 2018.7.23 fairy help
define('FS_NEED_HELP','Besoin d\'Aide');
define('FS_NEED_HELP_BIG','Besoin d\'Aide');
define('FS_CHAT_LIVE_WITH_US','Chattez en direct avec nous');
define('FS_SEND_US_A_MESSAGE','Envoyez-nous un message');
define('FS_E_MAIL_NOW','Écrivez-nous');
define("FS_LIVE_CHAT","Chat en Ligne");
define("FS_WANT_TO_CALL","Appelez-nous ");
define("HOT_PRODUCTS","Meilleures Ventes");
define("FS_BREADCRUMB_HOME","Accueil");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Obtenir le support technique');
define('FS_CHAT_LIVE_WITH_GET_A','Demander à un expert');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','Expédition Rapide et Retours Faciles');
define('HEADER_FREE_SHIPPINH_02','Livraison GRATUITE à partir de %s');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','et plus d\'options d\'expédition pour s\'adapter à votre emploi du temps et à votre budget.');
define('HEADER_FREE_SHIPPINH_04','Expédition le Jour Même');
define('HEADER_FREE_SHIPPINH_05','avec des stocks importants basés sur notre système multi-entrepôts.');
define('HEADER_FREE_SHIPPINH_06','Retour de 30 Jours');
define('HEADER_FREE_SHIPPINH_07','pour la plupart des commandes s\'il existe des problèmes.');
define('HEADER_FREE_SHIPPINH_08','Tout article avec le message « Livraison Gratuite » sur la page du produit est éligible à la Livraison Gratuite. FS.COM se réserve le droit de modifier cette offre à tout moment. En savoir plus sur la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');
define('HEADER_FREE_SHIPPINH_09','Expédition en dehors de votre pays ? Basculez vers le pays de destination sur notre site Web pour consulter les politiques appropriées.');
define('HEADER_FREE_SHIPPINH_10','Livraison Rapide et Retours Faciles');
define('HEADER_FREE_SHIPPINH_11','Livraison GRATUITE à partir de %s');//%s不用翻译替换的是价格,如79€
define('HEADER_FREE_SHIPPINH_12','et plus d\'options de livraison pour s\'adapter à votre emploi du temps et à votre budget.');
define('HEADER_FREE_SHIPPINH_13','Expédition le Jour Même');
define('HEADER_FREE_SHIPPINH_14','Tout article avec le message « Livraison Gratuite » sur la page du produit est éligible à la Livraison Gratuite. FS.COM se réserve le droit de modifier cette offre à tout moment. En savoir plus sur la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');
define('HEADER_FREE_SHIPPINH_15','Livraison en dehors de votre pays ? Basculez vers le pays de destination sur notre site Web pour consulter les politiques appropriées.');
define('HEADER_FREE_SHIPPINH_16','Inventaire de 310,000+');
define('HEADER_FREE_SHIPPINH_17','articles optiques et du réseau pour satisfaire vos besoins');
define('HEADER_FREE_SHIPPINH_18','Le temps d\'expédition peut être influencé par les stocks. Pour en savoir plus, consultez la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');
define('HEADER_FREE_SHIPPINH_19','Le temps d\'expédition peut être influencé par les stocks. Pour en savoir plus, consultez la <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a> ou la <a href="'.zen_href_link('day_return_policy').'">politique de retour</a>.');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','Aide & Paramètres');

// 浏览器
define('FS_UPGRADE','MISE À NIVEAU DE VOTRE NAVIGATEUR');
define('FS_UPGRADE_TIP','Vous utilisez un navigateur ancien. Veuillez mettre à jour votre navigateur pour une meilleure expérience.');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','Découvrir les Solutions');
define('FS_INDEX_CATE_PRODUCTS','Produits');


// common/phone.php
//各国电话语言包 2017.8.18  ery

define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 8176 3606');		// Hong Kong
define('FS_PHONE_MX','+52 (55) 3098 7566');		// Mexico
define('FS_PHONE_CA','+1 (647) 243 6342');		// Canada
define('FS_PHONE_BR','+55 (11) 4349 6175');		// Brazil
define('FS_PHONE_AR','+54 (11) 5031 9542');		// Argentina
define('FS_PHONE_GB','+44 (0) 121 716 1755');	// United Kingdom
define('FS_PHONE_FR','+33 (1) 82 884 336');		// France
define('FS_PHONE_NL','+31 (20) 241 4029');		// Netherlands
define('FS_PHONE_AU','+61 3 9693 3488');		// Australia
define('FS_PHONE_ES','+34 (91) 123 7299');		// Spain
define('FS_PHONE_RU','+7 (499) 643 4876');		// Russian Federation
define('FS_PHONE_SG','+(65) 6443 7951');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+44 (0) 121 716 1755');		// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_WH','+86 (027) 87639823');     //wuhan
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_SITE_EU','+49 (0) 89 414176412');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 (3) 9693 3488');
define('FS_PHONE_SITE_JP','+81 345888332');
define('FS_PHONE_SITE_SG','+(65) 6443 7951');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_US','+1 (888) 468 7419');		// United States
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_US','+1 (877) 205 5306');		// United States
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}
//美东电话
define('FS_PHONE_US_EAST','+1 (888) 468 7419');
//武汉仓电话
define('FS_PHONE_CN','+86 (027) 87639823');



// common/resources.php
//catalog
define('PRODCUT_CATALOGS_01','Catalogues de Produits');
define('PRODCUT_CATALOGS_02','Base de Connaissance');
define('PRODCUT_CATALOGS_03','Solutions');
define('TUTORIAL_ALL','Tous');
define('TUTORIAL_ALL_ATGS','Toutes les Étiquettes');
define('FS_LOAD_MORE','En Savoir Plus');
define('FS_SUPPORT_CASE','Études de Cas');

//support
define('SUPPORT_SEC_01','Solution d\'Interconnexion');
define('SUPPORT_SEC_02','Solution de Câblage');
define('SUPPORT_SEC_03','Solution d\'Entreprise');
define('SUPPORT_SEC_04','Solution WDM');
define('SUPPORT_SEC_05','Solution FTTX');


//knowledge
define('KNOWLEDGE_01','fibres optiques');
define('KNOWLEDGE_02','La base de connaissance aide les professionnels informatiques à démarrer et à façonner l\'avenir de l\'entreprise');
define('KNOWLEDGE_03','CONNEXE');
define('KNOWLEDGE_04','Partager');
define('KNOWLEDGE_05','Blogs Connexes');
define('KNOWLEDGE_06','SUJETS');

define('PRODCUT_CATALOGS_04','Vidéos de Produit');
define('PRODCUT_CATALOGS_05','Tous');
define('PRODCUT_CATALOGS_06','Réseautage');
define('PRODCUT_CATALOGS_07','Câblage');
define('PRODCUT_CATALOGS_08','WDM & FTTx');
define('PRODCUT_CATALOGS_09','Réseau d\'Entreprise');
define('PRODCUT_CATALOGS_10','Testeur & Outil');




// common/save_shopping_list.php
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','Une page web de FS.COM a été partagée avec vous !');
define('EMAIL_SAVE_DEAR','Chère Madame, Cher Monsieur');
//2017.5.30		add		ery
define('FS_AJAX_PAST','Vous avez fait du shopping sur FS.COM et vous vouliez sauvegarder cette page & ce message pour vous même !');
define('FS_AJAX_THIS','Cet e-mail est envoyé par vous même en utilisant le service de FS.COM Partager Avec Un(e) Ami(e). A la suite de la réception de ce message, vous ne recevrez aucun message spontané de FS.COM. Veuillez savoir plus sur notre ');
define('FS_AJAX_PRIVACY','Politique de Confidentialité');
define('FS_AJAX_WAS',' a fait du shopping sur FS.COM et voulait partager cette page & ce message avec vous !');
define('FS_AJAX_SENT','Cet e-mail est envoyé par votre ami(e) ');
define('FS_AJAX_USING',' en utilisant le service de FS.COM Partager Avec Un(e) Ami(e). A la suite de la réception de ce message, vous ne recevrez aucun message spontané de FS.COM. Veuillez savoir plus sur notre ');



// common/tpl_left_side_bar_for_categories_narrow_by.php
/*content*/
//fallwind	2016.8.22	add
define('CATEGORIES','catégories');
define('COMPATIBLE_BRANDS','Marques Compatibles');
define('MORE_BRANDS','Montrer Plus de Marques');
define('LESS_BRANDS','Montrer Moins de Marques');
define('CLEAR_SELECTIONS','Effacer les sélections');


// functions/functions_shipping.php
define('FS_SHIP_IN_PERSON','Retirer Moi-Même ');


// functions/product_instock.php
define('FS_SHIP_PC',' pc');
define('FS_SHIP_PCS',' pcs');
define('FS_SHIP_AVAI','Disponible');
define('FS_SHIP_STOCK',' en stock');
define('FS_SHIP_DEVE','Développement');
define('FS_SHIP_ESTIMATED','Expédition prévue pour le ');
define('FS_SHIP_INVENTORY','En rupture de stock, sera disponible le ');
define('FS_SHIP_ROLL',' Rouleau');
define('FS_SHIP_ROLLS',' Rouleaux');
define('FS_SHIP_ROLL_1KM',' (1Rouleau = 1KM)');
define('FS_SHIP_ROLL_2KM',' (1Rouleau = 2KM)');
define('FS_SHIP_TODAY_BEFOR','En rupture de stock, sera disponible le ');
define('FS_THEA_CTUAL_SHIPPING_TIME','Nous sommes toujours dévoués à offrir la livraison la plus rapide avec le système multi-entrepôt. En savoir plus sur notre <a href="'.zen_href_link('shipping_delivery').'">politique de livraison</a>.');



//2017.6.13 add by Frankie
define('FS_SHIP_PLACE','Les commandes passées aujourd\'hui seront expédiées dans les ');
define('FS_SHIP_DAYS',' jours ouvrables.');


define("CREDIT_HOLDER_NAME_ERROR1","Le Nom du Titulaire de la Carte est requis.");
define("CREDIT_HOLDER_NAME_ERROR2","Le Nom du Titulaire de la Carte est incorrect, veuillez le réintroduire s'il vous plait.");
define("CREDIT_CARD_NUMBER_ERROR1","Le Numéro de Carte est requis.");
define("CREDIT_CARD_NUMBER_ERROR2","Le Numéro de Carte n'existe pas. Veuillez entrer un numéro valide.");
define("CREDIT_CARD_DATE_ERROR1","La Date d'Expiration est requise");
define("CREDIT_CARD_DATE_ERROR2","La Date d'Expiration est incorrecte, veuillez la réintroduire s'il vous plait.");
define("CREDIT_CARD_CODE_ERROR1","Le Code de Sécurité est requis.");
define("CREDIT_CARD_CODE_ERROR2","Le Code de Sécurité est incorrect, veuillez le réintroduire s'il vous plait.");

//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', 'Système de Test Parfait');
define('NEW_PATCH_PANEL_02', 'Tous les câbles passent le Test de Canal Fluke.');
define('NEW_PATCH_PANEL_03', 'Certification de Qualité');
define('NEW_PATCH_PANEL_04', 'Certification de qualité CE, RoHS, ISO9001 garantie.');
define('NEW_PATCH_PANEL_05', 'Stock Important');
define('NEW_PATCH_PANEL_06', 'Inventaire suffisant pour l\'expédition le jour même.');
define('NEW_PATCH_PANEL_07', 'Prix Avantageux');
define('NEW_PATCH_PANEL_08', 'Câbles de prix de gros pour économiser votre budget de projet.');

define('NEW_PATCH_PANEL_01_209', 'Programme d\'essais rigoureux');
define('NEW_PATCH_PANEL_02_209', 'Inspection de face, perte IL et perte RL.');

define('NEW_PATCH_PANEL_01_1', 'Beaucoup de Flexibilité');
define('NEW_PATCH_PANEL_02_1', 'Supporter de multiples interfaces pour répondre aux différents besoins d\'application d\'entreprise.');
define('NEW_PATCH_PANEL_04_1', 'Tous les produits ont passé des tests stricts.');

define('NEW_PATCH_PANEL_01_911', 'Livraison Rapide');
define('NEW_PATCH_PANEL_02_911', 'Les entrepôts globaux couvrent les marchés mondiaux pour économiser vos temps précieux.');

define('NEW_PATCH_PANEL_01_9', 'Large Compatibilité');
define('NEW_PATCH_PANEL_02_9', 'Compatible à 100% avec les fournisseurs et les systèmes principaux.');
define('NEW_PATCH_PANEL_04_9', 'Certification de qualité CE, RoHS, IEC, FCC, ISO9001 et FDA garantie.');

define('NEW_PATCH_PANEL_02_4', 'Tous les produits sont testés pour répondre à l\'exigence standard.');
define('NEW_PATCH_PANEL_08_4', 'Le prix de gros peut économiser beaucoup de budget de projet.');


//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
    Cet e-mail a été envoyé par <a style="color: #232323;text-decoration: none;" href="javascript:;"></a> en utilisant le service Partager Avec Un Ami de <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>.
                            À la suite de la réception de ce message, vous ne recevrez aucun message non sollicité de <a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>,
                            en savoir plus sur notre <a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Politique de Confidentialité</a>.
                        </td></tr></table>');


if ($_SESSION['countries_iso_code'] == 'ca'){
    define('FS_COMMON_PHONE', FS_PHONE_CA);//加拿大
}elseif($_SESSION['countries_iso_code'] == 'ch'){
    define('FS_COMMON_PHONE', FS_PHONE_CH);//瑞士
} else{
    define('FS_COMMON_PHONE', FS_PHONE_FR);
}

//邮件
define('SAMPLE_EMAIL_DEAR','Cher/Chère');
define('SAMPLE_EMAIL_01', 'Nous avons reçu votre demande et notre équipe vous contactera dans le plus bref délai.');
define('SAMPLE_EMAIL_02', 'Voici votre numéro de cas <a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>. Vous pouvez vous référer à ce numéro dans toutes les communications de suivi concerant cette demande.');
define('SAMPLE_EMAIL_03', 'Nom : ');
define('SAMPLE_EMAIL_04', 'E-mail : ');
define('SAMPLE_EMAIL_05', 'Pays : ');
define('SAMPLE_EMAIL_06', 'N° de Téléphone : ');
define('SAMPLE_EMAIL_07', 'Vos Notes Supplémentaires : ');
define('SAMPLE_EMAIL_08', 'Merci');
define('SAMPLE_EMAIL_09', 'L\'Équipe FS');
define('SAMPLE_EMAIL_30', 'Voici votre numéro de cas <a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>. Vous pouvez vous référer à ce numéro dans toutes les communications de suivi concernant cette demande via le <a style="color: #0070bc;text-decoration: none" href="$HREF">centre de cas en ligne</a>.');

define('FS_CONTACT_GET_SUPPORT','Contactez-nous par e-mail. Nous sommes à votre disposition pour répondre à toutes vos questions.');
define('FS_CONTACT_LEAVE','Laissez un Message');

define('CUSTOMER_SERVICE_OTHERS_46', 'Déjà un compte enregistré ? <a style="color: #0070bc;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Connectez-vous</a> ou <a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Créez un compte</a>');
define('CUSTOMER_SERVICE_OTHERS_47', '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Connectez-vous</a> ou <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Créez un Compte</a> pour obtenir des services personnalisés.');
define('CUSTOMER_SERVICE_OTHERS_48', 'Déjà un compte enregistré ? <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Connectez-vous</a> ou <a href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">Créez un Compte</a>');

define('FS_SUPPORT_FORM_TIT','Nous vous invitons à communiquer avec nous');
define('FS_SUPPORT_FORM_TXT','Veuillez remplir le formulaire ci-dessous. Nous vous contacterons dès que possible.');
define('FS_SUPPORT_FORM_PLACEHOLDER','Vos commentaires aident FS à fournir un service plus rapide.');
define('FS_PLEASE_ENTER_COMMENTS','Veuillez ajouter des remarques supplémentaires sur votre demande.');
define('FS_COMMON_AT_LEAST','Le contenu doit être composé d\'au moins 3 caractères.');
define('FS_COMMON_AT_MOST','Le contenu doit être inférieur à 1000 caractères.');
define("FS_SUPPORT_EMAIL","E-mail");
define('FS_SUPPORT_PHONE','Téléphone');
define('FS_FIRST_NAME_PLEASE','Veuillez entrer votre prénom.');
define('FS_LAST_NAME_PLEASE','Veuillez entrer votre nom.');
define('FS_SUPPORT_COMMENTS','Commentaires');
define('FS_SUPPORT_FIRST_NAME','Prénom');
define('FS_SUPPORT_LAST_NAME','Nom');
define('SOLUTION_PRIVACY_POLICY',' J\'accepte la <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>Politique de Confidentialité</a> et les<a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'> Conditions d\'Utilisation </a> de FS.');
define('FS_SUPPORT_EMAIL_TOUCH_SOON','Nous avons reçu votre demande de support et notre équipe vous contactera bientôt.');

//shopping_cart save_items 页面的 meta标签 2019.12.23
define('META_TAGS_SHOPPING_CART_TITLE', 'Panier');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', 'Acheter les meilleurs produits pour les Centres de Données, Réseau d\'Entreprise et Accès d\'Internet. Ils permettent aux professionnels IT de réaliser leur solution de débit de manière simple et rentable.');
define('META_TAGS_SAVED_ITEMS_TITLE', 'Paniers Enregistrés');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', 'Après avoir ajouté des articles au panier, vous pouvez cliquer sur "Enregistrer le Panier" pour sauvegarder l\'ensemble des articles. Vous pouvez créer plusieurs paniers enregistrés selon vos besoins et les utiliser pour passer de nouvelles commandes.');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', 'Liste de Stock SFP+ 10G CWDM/DWDM');
define('META_TAGS_SFP_DESCRIPTION', 'La gamme complète de produits du module SFP+ 10G CWDM/DWDM (SFP+ DWDM  80km/40km, SFP+ CWDM 80km/40km/20km/10km) donne un aperçu rapide de l\'inventaire des produits et fournit une aide avec les solutions WDM.');


//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','Explorez Comment Nous Atteignons vos Objectifs');
define('FS_SPECIAL_DESIGN_CENTER','Centre de Design');
define('FS_SPECIAL_DESIGN_CENTER_DES','Expert dans l\'intégration des exigences et fournissant une <br/>solution complète fiable, rentable et innovante.');
define('FS_SPECIAL_QUALITY','Centre de Qualité');
define('FS_SPECIAL_QUALITY_DES','Fournir des produits de haute qualité avec des tests rigoureux et <br/>des certifications standard de l\'industrie.');
define('FS_SPECIAL_TEC','Support Technique');
define('FS_SPECIAL_TEC_SMALL','Demander un Support');
define('FS_SPECIAL_TEC_DES','Obtenir un support et une conception de solution gratuits en<br/> ligne pour votre projet.');
define('FS_SUBMIT_SUCCESS','Votre demande ##number## est déjà envoyée avec succès.');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','Nous vous contactera dans les 1-3 heures par téléphone ou e-mail pendant les jours ouvrables.');

define('SAMPLE_EMAIL_31', 'Adress : ');
define('SAMPLE_EMAIL_32', 'Qté. : ');
define('SAMPLE_EMAIL_33', "Liste d'Échantillons");

define('FS_BROWSING_HISTORY','Historique de Navigation');

define('FS_PRODUCT_DOWNLOAD', 'Téléchargements');
define('FS_PRODUCT_MORE', 'En savoir plus');
define('FS_PRODUCT_SUPPORT','Support Produit');

//结算页、订单确认成功页、银行转账邮件、订单详情
define("PAYMENT_BANK_ACH","Virement Bancaire/ACH");
define("PAYMENT_BANK_ACH_CA","Virement Bancaire");
define("PAYMENT_BANK_OF_US","Bank of America");
define("PAYMENT_BANK_VIA","Par Virement Bancaire");
define("PAYMENT_BANK_ACCOUNT_NAME","FS COM INC");
define("PAYMENT_BANK_WIRE_ROUTING"," N° de Routage # :");
define("PAYMENT_BANK_SWIFT_CODE","Code Swift :");
define("PAYMENT_BANK_ACH_ROUTING","ACH Routing # :");
define("PAYMENT_BANK_VIA_ACH","Par ACH");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",FIBER_CHECK_COMMON_ACCOUNT_NAME);
define("PAYMENT_BANK_ACCOUNT",FS_COMMON_HEADER_ACCOUNT.' # :');
define("PAYMENT_BANK_ADDRESS",FS_ADDRESS_ADDRESS.' :');

// QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL','Qté');
define('FS_QV_QUICK_VIEW','Vue Rapide');
define('FS_SEE_FULL_DETAILS','Voir les détails');
define('FS_CUSTOMIZED','Ajouter au panier');
define('FS_PRODUCTS_INFORMATION','Informations de produits');
define('FS_CUSTOMER_ALSO_VIEWED','Produits Connexes');

// fairy 2019.1.15 add 公共标题需要
define('FS_TITLE_COMPATIBLE','Compatible');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'Acheter à Nouveau');
define('FS_BUY_MORE_02', 'Les articles achetés par Acheter à Nouveau seront totalement identiques à votre commande %s.'); //%s会替换成订单号
define('FS_BUY_MORE_03', 'L\'article identique à la commande précédente %s.');  //%s会替换成订单号

//头部下拉版块
define('FS_HEADER_SUPPORT','Support');
define('FS_HEADER_TEC_SUPPORT','Support Technique');
define('FS_HEADER_CUSTOMER_SUPPORT','Support Client');
define('FS_HEADER_SERVICE_SUPPORT','Support du Service');
define('FS_HEADER_TEC_DES',' Trouvez des documents, études de cas, vidéos et autres informations dans notre bibliothèque de ressources, ou demandez une assistance technique pour obtenir des solutions personnalisées.');
define('FS_HEADER_TEC_URL_01','Documents Techniques');
define('FS_HEADER_TEC_URL_02','Banc d\'Essai');
define('FS_HEADER_TEC_URL_03','Téléchargement de Logiciel');
define('FS_HEADER_TEC_URL_04','Engagement de Qualité');
define('FS_HEADER_TEC_URL_05','Études de Cas ');
define('FS_HEADER_TEC_URL_06','Recherche de Garantie');
define('FS_HEADER_TEC_URL_07','Vidéothèque');
define('FS_HEADER_SUPPORT_RIGHT_DES','Service d\'Experts de FS');
define('FS_HEADER_SUPPORT_RIGHT_URL','Contactez-Nous');
define('FS_HEADER_CUSTOMER_DES','Obtenez une assistance immédiate avant et après-vente : demander une commande, passer une commande, suivre l\'état d\'une commande ou autres besoins connexes.');
define('FS_HEADER_CUSTOMER_URL_01','Obtenir un Devis');
define('FS_HEADER_CUSTOMER_URL_02','Demander un Retour & Remboursement');
define('FS_HEADER_CUSTOMER_URL_03','Demander un Échantillon');
define('FS_HEADER_CUSTOMER_URL_04','Bon de Commande');
define('FS_HEADER_CUSTOMER_URL_05','Envoyer un PO');
define('FS_HEADER_CUSTOMER_URL_07','Suivre vos Articles');
define('FS_HEADER_CUSTOMER_URL_08','Nouveaux Produits');
define('FS_HEADER_CUSTOMER_URL_09','Déstockage');
define('FS_HEADER_CUSTOMER_URL_10','Vérification du Produit');
define('FS_HEADER_CUSTOMER_URL_11','Demander une Démonstration');
define('FS_HEADER_SERVICE_DES','Découvrez des sujets populaires sur le compte, l\'expédition, les retours, etc., FS s\'engage à vous offrir l\'expérience d\'achat la plus simple.');
define('FS_HEADER_SHIPPING_DELIVERY','Expédition & Livraison');
define('FS_HEADER_RETURN_POLICY','Politique de Retour');
define('FS_HEADER_PAYMENT','Moyens de Paiement');
define('FS_HEADER_HELP_CENTER','FS Support');
define('FS_HEADER_COMPANY','Entreprise');
define('FS_HEADER_ABOUT_US',' À Propos de Nous');
define('FS_HEADER_CONTACT_US','Contactez-Nous');
define('FS_HEADER_NEWS','Partenaires');
define('FS_HEADER_ABOUT_DES','FS est l\'un des principaux fournisseurs mondiaux de matériel de communication et de solutions de projet. Nous sommes là pour vous aider à concevoir, connecter, protéger et optimiser votre infrastructure optique.');
define('FS_HEADER_ABOUT_EXPLORE','Explorer FS');
define('FS_HEADER_CONTACT_DES','Nous sommes ici pour vous aider. Bienvenue à nous contacter à tout moment pour le support technique et service client rapide.');
define('FS_HEADER_LEARN_MORE','En savoir plus');
//以下部分 因分仓、站点各异
define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('company/fiberstore_with_partners.html').'"><span>Nos Partenaires</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_DES','<dd>FS fournit des solutions réseau personnalisées et rentables pour votre entreprise. Nos produits et services bénéficient de la confiance des entreprises les plus influentes du monde.</dd>');
define('FS_HEADER_NEWS_RIGHT_DES','FS Obtient une Série de Certifications Internationales Autoritaires');
define('FS_HEADER_NEWS_RIGHT_DATE','8, juin, 2020');

define('FS_CUSTOMER_SUPPORT_TIP','#XXX est un article personnalisé, veuillez contacter votre responsable de compte pour plus de détails.');
define('FS_RMA_WAREHOUSE_RU','<dt>《FiberStore.COM》Ltd.</dt>
            <dd>No.4062, d. 6, str. 16, Proektiruemyy proezd, Moscow 115432, Russian Federation</dd>
            <dd>Tél : +7 (499) 643 4876</dd>');
// 武汉仓
define('FS_RMA_WAREHOUSE_CN','<dt>ATTN : FS. COM LIMITED</dt>
			<dd>Address : A115 Jinhetian Business Centre No.329, Longhuan Third Rd Longhua District Shenzhen, 518109, China</dd>
			<dd>Tél : +86-0755-83571351</dd>');
// 德国仓
define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH</dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Allemagne</dd>
			<dd>Tél : +49 (0) 8165 80 90 517</dd>');
define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC </dt>
			<dd>380 CENTERPOINT BLVD, NEW CASTLE, DE 19720, États-Unis</dd>
			<dd>Tél : +1 (888) 468 7419</dd>');
// 美东仓
define('FS_RMA_WAREHOUSE_US_EAST','<dt>ATTN: FS.COM Inc.</dt>
					<dd>Adresse : 380 Centerpoint Blvd, New Castle, DE 19720, États Unis</dd>
					<dd>Tél : +1 (888) 468 7419</dd>');

// 澳洲仓 （澳大利亚）
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australie</dd>
				<dd>Tél : +61 3 9693 3488</dd>
				<dd>ABN : 71 620 545 502</dd>');
// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>ATTN: FS Tech Pte Ltd.</dt>
				<dd>Adresse : 30A Kallang Place #11-10/11/12, Singapour 339213</dd>
				<dd>Tél : +(65) 6443 7951</dd>');

//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','Devis');
define('FS_ACCOUNT_TW_CREDIT','Compte de Crédit');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','Détails du Crédit');
define('FS_ACCOUNT_TW_USER','Information de l\'Utilisateur');
define('FS_ACCOUNT_TW_SUPPORT','Centre de Cas');
define('FS_ACCOUNT_TW_TAX','Demande d\'Exonération Fiscale');
define('FS_ACCOUNT_TW_USEFUL','Outils Utiles');
define('FS_ACCOUNT_TW_ACCOUNT','Information du Compte');
define('FS_ACCOUNT_TW_YOU','Vous avez des commandes qui n\'ont pas encore été payées.');
define('FS_ACCOUNT_TW_ORDERS','Commandes');
define('FS_ACCOUNT_TW_MOST_ORDER','Commande la Plus Récente');
define('FS_ACCOUNT_TW_VIEW_ORDERS','Voir Toutes les Commandes');
define('FS_ACCOUNT_TW_ORDERS_SEARCH','Commandes #, PO #, Article #, P/N, Commentaires...');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','Paiement en Attente');
define('FS_ACCOUNT_TW_WAIT','Attendre l\'Expédition');
define('FS_ACCOUNT_TW_TRANSIT','En Transit');
define('FS_ACCOUNT_TW_DELIVERED','Livrée');
define('FS_ACCOUNT_TW_PENDING_REVIEW','Commentaires de Commandes');
define('FS_ACCOUNT_TW_NO_ORDER','Aucune Commande Trouvée.');
define('FS_ACCOUNT_TW_VIEW_CART','Voir le Panier');
define('FS_ACCOUNT_TW_VIEW_TICKETS','Voir Tous les Cas');
define('FS_ACCOUNT_TW_CREATE_TICKET','Créer un Nouveau Cas');
define('FS_ACCOUNT_TW_SEARCH_TICKET','Cas #, Contenu…');
define('FS_ACCOUNT_TW_TICKET','Cas #');
define('FS_ACCOUNT_TW_TICKET_TYPE','Type de Support');
define('FS_ACCOUNT_TW_TICKET_COMMENT','Contenu');
define('FS_ACCOUNT_TW_TICKET_DATE','Date de Soumission');
define('FS_ACCOUNT_TW_TICKET_STATUS','État');
define('FS_ACCOUNT_TW_TICKET_ACTION','Action');
define('FS_ACCOUNT_TW_NO_TICKET','Aucun Cas Historique.');
define('FS_ACCOUNT_TW_ORDER','Commande #');
define('FS_ACCOUNT_TW_SPLIT_ORDER','Division des Commandes');
define('FS_ACCOUNT_TW_DELIVERY','Livraison');
define('FS_ACCOUNT_TW_DELIVERY_ON','Livrée le ');
define('FS_ACCOUNT_TW_THE','Le(s) produit(s) suivant(s) ne peuvent pas être commandés à nouveau directement pour la raison spécifique ci-dessous. Cliquez sur le bouton "Passer et Continuer" pour ajouter à nouveau le(s) produit(s) restant(s) au panier.');
define('FS_ACCOUNT_TW_THE_NO','Le(s) produit(s) suivant(s) ne peuvent pas être commandés à nouveau directement pour la raison spécifique ci-dessous.');
define('FS_ACCOUNT_TW_ITEMS','Les articles achetés par Acheter à Nouveau seront totalement identiques à votre commande #%s.');
define('FS_ACCOUNT_TW_YOU_CAN','Vous pouvez utiliser ce bouton pour remettre tous les produits de cette commande dans le panier.');
define('FS_ACCOUNT_TW_ORDER_AGAIN','Commander à Nouveau');
define('FS_ACCOUNT_TW_CREATE_TICKET','Créer un Nouveau Cas');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','Type de Support');
define('FS_ACCOUNT_TW_ATTACH_PO','Ajouter le PO');
define('FS_ACCOUNT_TW_SHOW_MORE','En Savoir Plus');
define('FS_ACCOUNT_TW_BASIC_INFO','Information de Base');
define('FS_ACCOUNT_TW_ADDRESS_INFO','Informations d\'Adresse');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','Ajouter le(s) produit(s) ci-dessous au Panier et Créer un Devis.');
define('FS_ACCOUNT_TW_MOST_QUOTE','Devis le Plus Récent');
define('FS_ACCOUNT_TW_VIEW_QUOTES','Voir Tous les Devis');
define('FS_ACCOUNT_TW_NO_QUOTE','Aucun Devis Trouvé.');
define('FS_ACCOUNT_TW_QUOTE_ITEM','Devis #, Article # ');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','Un nouveau devis pour le(s) produit(s) suivant(s) n\'est pas possible pour les raisons spécifiques indiquées ci-dessous.');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','Un nouveau devis pour le(s) produit(s) suivant(s) n\'est pas possible pour les raisons spécifiques indiquées ci-dessous. Cliquez sur le bouton "Ignorer et Continuer" pour ajouter à nouveau le(s) produit(s) restant(s) au panier et créer le devis.');

define('FS_FOOTER_EXPLORE','EXPLORER');
define('FS_HEADER_NEW_PRODUCT','Nouveau Produit');
define('FS_HEADER_CHANGE','Changer');
define('FS_COMMON_VIEW_MORE','En Savoir Plus');
define('FS_CART_EMPTY_TIP','Connectez-vous pour voir ce que vous avez ajouté, ou continuez vos achats.');
define('BIllS_TIPS1','Vous pouvez vérifier toutes vos factures ici.');
define('BIllS_TIPS2','Vous pouvez vérifier l\'état de votre compte de crédit et toutes les factures ici.');
define('TIPS_BUTTON', 'Confirmer');
define('TIPS_NEW', 'Nouveau');
define('FS_ATTRIBUTE_CUSTOMIZED','Personnalisation');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' ans');
define('FS_WARRANTY_YEAR',' an');
define('FS_WARRANTY_DAYS',' jours');
define('FS_WARRANTY_CONSUMABLE','Consommable');
define('FS_WARRANTY_UNAVAILABLE','Indisponible');
define('FS_WARRANTY_SUB_CATEGORY','Sous-catégorie');
define('FS_WARRANTY_RETURN','Délai pour<br>Retour');
define('FS_WARRANTY_CHANGE','Délai pour<br>Remplacement');
define('FS_WARRANTY_PERIOD','Période de<br>Garantie');

define('FS_WARRANTY_NOTE','Remarques');

define('ORDER_PAYMENT_TIPS','Veuillez vous assurer que l\'adresse de facturation ci-dessous correspond à celle qui figure sur les relevés de cette carte de crédit.');
define('ORDER_PAYMENT_SAFE','Sécurisé et Crypté');
define('ORDER_PAYMENT_TIPS_2','Vos données ne seront utilisées que pour traiter cette commande et ne seront pas conservées par FS.');
