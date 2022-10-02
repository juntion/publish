<?php
//2018-9-17   ery  add 
define('FS_CUSTOMER_SERVICE_01','Le numéro de commande ne peut pas être vide.');
define('FS_CUSTOMER_SERVICE_02','Veuillez entrer un numéro de commande valide. Ex. : FS180808001234');
define('FS_CUSTOMER_SERVICE_03','Veuillez expliquer votre (vos) raison (s) pour le retour.');
define('FS_CUSTOMER_SERVICE_04','La raison doit être 5000 caractères maximum.');
define('FS_CUSTOMER_SERVICE_05','Formulaire de Retour de Produit');
define('FS_CUSTOMER_SERVICE_06','Veuillez compléter ce formulaire pour commencer le traitement de votre retour (RMA). Si vous avez des questions, veuillez lire notre <a href="'.reset_url('policies/day_return_policy.html').'">politique de retour</a> ou <a href="'.zen_href_link('contact_us').'">nous contacter</a>.');
define('FS_CUSTOMER_SERVICE_07','Sélectionnez le type de service');
define('FS_CUSTOMER_SERVICE_08','Type de Service');
define('FS_CUSTOMER_SERVICE_09','ID & Quantité de Produit Retourné');
define('FS_CUSTOMER_SERVICE_10','Ajoutez un Numéro de Série');
define('FS_CUSTOMER_SERVICE_11','Veuillez remplir le numéro de série du module optique<br>afin que nous puissions rapidement trouver le module dont<br>vous avez besoin d\'un service après-vente.');
define('FS_CUSTOMER_SERVICE_12','Raison (s) du retour');
define('FS_CUSTOMER_SERVICE_13','Décrivez brièvement le problème afin que votre demande puisse être traitée rapidement.');
define('FS_CUSTOMER_SERVICE_14','Autoriser le type de fichier JPG, PDF, PNG <br>Taille maximale du fichier 5M.');
define('FS_CUSTOMER_SERVICE_15','Coordonnées');
define('FS_CUSTOMER_SERVICE_16','En cliquant sur le bouton ci-dessous, vous acceptez notre <a href="'.reset_url('policies/privacy_policy.html').'">Politique de Confidentialité & Cookies</a> et <a href = "'.reset_url('policies/terms_of_use.html').'">Conditions d’Utilisation</a>.');
define('FS_CUSTOMER_SERVICE_17','Différents numéros de série peuvent être séparés par  "/".');
define('FS_CUSTOMER_SERVICE_18','Votre soumission de RMA a réussi !');
define('FS_CUSTOMER_SERVICE_19','Après vérification, un représentant de vente vous contactera dès que possible pour traiter votre demande.');
define('FS_CUSTOMER_SERVICE_20','Votre Demande de RMA Approuvée !');
define('FS_CUSTOMER_SERVICE_21','Le Centre d\'Après-Vente FS a approuvé cette demande de RMA. Veuillez suivre votre commande de RMA et suivre les instructions pour la traiter.');
define('FS_CUSTOMER_SERVICE_22','Veuillez entrer l\'ID de produit.');
define('FS_CUSTOMER_SERVICE_23','Le N° d\'article (###KEYWORD###) n\'a pas été <br/>trouvé dans nos records.');
define('FS_CUSTOMER_SERVICE_24','Veuillez entrer le quantité de produit.');
define('FS_CUSTOMER_SERVICE_25','C\'est une commande en ligne. Veuillez demander le retour dans votre <a href="'.zen_href_link('manage_orders').'">centre de compte</a>.');
define('FS_CUSTOMER_SERVICE_26','Numéro de Commande');
//邮件
define('FS_CUSTOMER_SERVICE_27','Votre demande de RMA # %s est en cours de révision.');	//submit 状态邮件标题
define('FS_CUSTOMER_SERVICE_35','Votre demande de RMA # %s a été approuvée.');	//approved 状态邮件标题
define('FS_CUSTOMER_SERVICE_36','Votre demande de RMA a été approuvée. Pour plus d\'informations sur le processus, votre représentant de vente vous contactera rapidement.');	//approved 状态邮件内容
define('FS_CUSTOMER_SERVICE_28','Cher %s,');
define('FS_CUSTOMER_SERVICE_29','Nous avons reçu votre demande de RMA et nous la vérifierons rapidement. Pour plus d\'informations sur le processus, votre représentant de vente vous contactera rapidement.');  //submit 状态邮件内容
define('FS_CUSTOMER_SERVICE_30','Pour une aide immédiate, n\'hésitez pas à <a href="'.zen_href_link('contact_us').'"> nous contacter </a>.');
//申请成功提示语
define('FS_CUSTOMER_SERVICE_31','Votre RMA a été envoyée.');	//submit 状态
define('FS_CUSTOMER_SERVICE_32','Nous vous répondrons dans les 12~24 heures.');	//submit 状态
define('FS_CUSTOMER_SERVICE_33','Votre demande de RMA a été approuvée.');	//approved 状态
define('FS_CUSTOMER_SERVICE_34','Le Centre d\'Après-Vente de FS a approuvé cette demande de RMA. Veuillez contacter votre responsable de compte pour obtenir le numéro RMA et suivre les instructions pour le traiter.');	//approved 状态

define('FS_LAST_NAME_PLEASE','Veuillez entrer votre nom.');
define('FS_FIRST_NAME_PLEASE','Veuillez entrer votre prénom.');
define('FS_SELECT_ADDRESS', 'Veuillez Sélectionner un État ');
?>