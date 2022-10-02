<?php

define('PURCHASE_TITLE_01', 'Envoyer un Bon de Commande');
define('PURCHASE_TITLE_02', 'Rend le processus de PO efficace, automatique et facile à suivre');

define('PURCHASE_FORM_01', 'Veuillez fournir les informations suivantes pour que votre commande de PO soit traitée rapidement et facilement.');
define('PURCHASE_FORM_02', 'Informations de Contact');
define('PURCHASE_FORM_03', 'Prénom ');
define('PURCHASE_FORM_04', 'Nom de Famille');
define('PURCHASE_FORM_05', 'Adresse E-mail');
define('PURCHASE_FORM_06', 'N° de Téléphone');
define('PURCHASE_FORM_07', 'Informations de PO');
define('PURCHASE_FORM_08', 'N° de PO');
define('PURCHASE_FORM_09', 'N° de Devis/PI');
define('PURCHASE_FORM_10', 'Ajouter des Fichiers');
define('PURCHASE_FORM_11', 'Commentaires');
define('PURCHASE_FORM_12', 'Envoyer le PO');
define('PURCHASE_FORM_13', 'Choisir un Fichier');

define('PURCHASE_FORM_TIP_01', 'Veuillez enter votre numéro de PO.');
define('PURCHASE_FORM_TIP_02', 'Si vous avez déjà obtenu un devis officiel de FS, vous pouvez laisser des informations connexes comme RQC2001020006/RQ2001300199/FS20200128000.');
define('PURCHASE_FORM_TIP_03', 'Si vous avez déjà obtenu un devis officiel de FS, vous pouvez ajouter des fichiers connexes et le PO en tant que confirmation.');
define('PURCHASE_FORM_TIP_04', 'Veuillez ajouter des fichiers connexes de PO.');
define('PURCHASE_FORM_TIP_05', 'Laissez une remarque si vous avez d\'autres demandes, telles que l\'expédition en aveugle, le numéro de ticket, les besoins de personnalisation des produits, etc. ');
define('PURCHASE_FORM_TIP_06', 'Le contenu ne doit pas dépasser 500 caractères.');

define('PURCHASE_FORM_TIP_07', 'Votre PO a été envoyé avec succès.');
define('PURCHASE_FORM_TIP_08', 'Nous traiterons la commande dans les 12-24 heures, et vous pouvez également consulter le statut de mise à jour dans <a href="'.zen_href_link('purchase_order_list').'">Envoyer/Voir le Bon de Commande</a>.');

define('PURCHASE_LIST_01','Envoyer un Nouveau PO');
define('PURCHASE_LIST_02','Liste de PO');
define('PURCHASE_LIST_03','N° de PO');
define('PURCHASE_LIST_04','Date');
define('PURCHASE_LIST_05','Statut');
define('PURCHASE_LIST_06','N° de Commande');
define('PURCHASE_LIST_07','Envoyé');
define('PURCHASE_LIST_07_TIP','Vous trouverez ci-dessous les informations de PO que vous avez envoyées, nous vous répondrons dans les 12-24 heures.');
define('PURCHASE_LIST_08','Approuvé');
define('PURCHASE_LIST_08_TIP','Votre PO a été approuvé, nous le traiterons pour vous créer une commande maintenant.');
define('PURCHASE_LIST_09','Commande Créée');
define('PURCHASE_LIST_09_TIP','Votre commande de PO a été créée avec succès, veuillez cliquer sur le bouton « Payer Maintenant » pour compléter le paiement et voir plus de statuts de commande par le numéro de commande « FSXXX ».');
define('PURCHASE_LIST_09_TIP1','Votre commande de PO a été créée avec succès et est en traitement maintenant, vous pouvez vérifier le statut de commande par le numéro de commande « FSXXX ».');
define('PURCHASE_LIST_EMPTY_01','AUCUN HISTORIQUE DE PO.');
define('PURCHASE_LIST_EMPTY_02','AUCUN PO TROUVÉ.');
define('PURCHASE_LIST_FORM_01','Veuillez assurer que votre PO inclut toutes les informations requises pour accélérer le traitement de votre commande.');
define('PURCHASE_LIST_FORM_02','N° de PO');
define('PURCHASE_LIST_FORM_03','ex : RQC2001020006');
define('PURCHASE_LIST_FORM_04','Laissez une remarque si vous avez d\'autres demandes, telles que l\'expédition en aveugle, le numéro de ticket, les besoins de personnalisation des produits, etc. ');

define('PURCHASE_PO_DETAILS','Détails de Bon de Commande');
define('PURCHASE_PO_DETAILS_DATE','Date de Demande de PO :');
define('PURCHASE_PO_DETAILS_QT','N° de Devis :');
define('PURCHASE_PO_DETAILS_REQUEST','Demande de PO');
define('PURCHASE_PO_DETAILS_FILES','Fichiers :');

//邮件
define('PURCHASE_EMAIL_REVIEWING','Révision du PO');
define('PURCHASE_EMAIL_TITLE','FS - Votre PO #POXXX est en Cours de Révision');
define('PURCHASE_EMAIL_CONTENT_01','Nous avons reçu votre PO : #POXXX. Il est actuellement en cours de révision et ce processus peut prendre 12-24 heures.');
define('PURCHASE_EMAIL_CONTENT_02','Vous pouvez suivre la progression en vous connectant à votre compte et en vous rendant sur la page <a href="'.zen_href_link('purchase_order_list').'" target="_blank" style="color: #0070bc;text-decoration: none;">Envoyer/Voir le Bon de Commande</a> .');

define('PURCHASE_PROCESS_TIP','Connectez-vous ou créez un compte pour envoyer un fichier PO et suivre son statut en ligne en temps opportun.');
define('PURCHASE_PROCESS_TITLE','Comment Fonctionne le Processus du Bon de Commande ?');
define('PURCHASE_PROCESS_01','Envoyer un PO');
define('PURCHASE_PROCESS_01_TIP','Envoyer votre fichier du bon de commande (PO).');
define('PURCHASE_PROCESS_02','Traitement du PO');
define('PURCHASE_PROCESS_02_TIP','FS crée une commande en ligne pour vous une fois le PO approuvé.');
define('PURCHASE_PROCESS_03','Paiement et Expédition de la Commande');
define('PURCHASE_PROCESS_04','Une fois la commande en attente créée, veuillez effectuer le paiement en ligne afin que nous puissions la traiter et l\'expédier. Pour le Client ayant un Compte de Crédit, votre commande sera traitée directement une fois le PO approuvé, et la commande de crédit sera expédiée en premier et le client pourra effectuer le paiement plus tard.');
define('PURCHASE_PROCESS_05','Pour suivre l\'état des commandes, vous pouvez consulter “<a href="'.zen_href_link('manage_orders').'" class="alone_a">l\'Historique de Commandes</a>”.');