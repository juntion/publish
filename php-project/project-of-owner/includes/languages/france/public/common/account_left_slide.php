<?php 
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
define('ACCOUNT_SETTING','Paramètres de Compte');
define('FS_RETURN_ORDERS','Commandes de Retour');
define('FS_MY_QUOTES','Mes Devis');
define('FS_WISH_LIST','Liste d\'Envies');
define('FS_MY_CASES','Mes Cas');
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
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','Merci pour vos achats chez FS.COM, en attente de votre prochaine visite.');

// 表单验证
define("ADDRESS_PLACE_HODLER","Adresse de Rue, c/o");
define("ADDRESS_PLACE_HODLER2","Appartement, Chambre, Étage, etc.");
define("FS_ZIP_CODE","Code Postal");
define("FS_ADDRESS","Adresse");
define("FS_ADDRESS2","Adresse 2");
define('FS_CHECK_COUNTRY_REGION','Pays/Région');
define("FS_CHECKOUT_ERROR1","Votre Nom est requis");
define("FS_CHECKOUT_ERROR2","Votre Prénom est requis");
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
define('FS_ORDER_PENDING','En attente');
define('FS_ORDER_COMPLETED','Complétée');
define('FS_ORDER_CANCELLED','Annulée');
define('FS_ORDER_PURCHASE','PO');
define('FS_ORDER_PROGRESSING','Traitement');
define('FS_ORDER_RETURN_ITEM','Retour');

define('FS_FILE_UPLOADED_SUCCESS_TXT','Le fichier a été ajouté avec succès.');