<?php
/*************************content*************************/
//ery		2014-9-14		add
define('HEADING_TITLE', 'Merci! Nous apprécions vos affaires!');
define('FS_SUCCESS_CART','Panier');
define('FS_SUCCESS_CHECKOUT','Caisse');
define('FS_SUCCESS_SUCCESS','Succès');
define('FS_SUCCESS_LIVE','Chat en Ligne');
define('FS_SUCCESS_THANK','Merci de faire des achats avec nous ! Votre commande est en traitement.');
define('FS_SUCCESS_SUMMARY','Récapitulatif de la Commande');
define('FS_SUCCESS_NUMBER','Numéro de Commande ');
define('FS_SUCCESS_TOTAL','Montant Total ');
define('FS_SUCCESS_ITEM','Article (s) ');
define('FS_SUCCESS_METHOD','Méthode d\'Expédition ');
define('FS_SUCCESS_DATE','Date de la Commande ');
define('FS_SUCCESS_PAYMENT','Moyen de Paiement ');
define('FS_SUCCESS_CREDIT','Carte de Crédit / Débit');
define('FS_SUCCESS_IF','Si vous avez des doutes ou questions, veuillez nous contacter par Tél : +1-425-226-2035      E-mail :  ');
define('FS_SUCCESS_SALES','sales@fiberstore.com');
define('FS_SUCCESS_SUPPORT','Support@fiberstore.com');
define('FS_SUCCESS_YOU_CAN','Commandes soumises avec succès, vous pouvez');
define('FS_SUCCESS_VIEW','Voir Mes Commandes');
define('FS_SUCCESS_CHANGE','Modifier Mon Profil');
define('FS_SUCCESS_SHIPPING','Adresse de Livraison');
define('FS_SUCCESS_BACK','Rentrer à la Page d\'Accueil');
/*****************html_checkout_success_hsbc.php*****************/
define('FS_SUCCESS_YOUR_NEXT','Votre prochaine étape consiste à effectuer votre paiement par Virement Bancaire et soumettre vos informations de paiement.');
define('FS_SUCCESS_WIRE','Virement Bancaire');
define('FS_SUCCESS_ORDER','Imprimer la Commande');
define('FS_SUCCESS_DETAIL','Détail de Bénéficiaire de Virement Bancaire');

define('FS_SUCCESS_BANK_NAME','Nom du Compte Bénéficiaire ');
define('FS_SUCCESS_HSBC',FS_DE_COMPANY_NAME);
define('FS_SUCCESS_AC_NAME','Banque Bénéficiaire ');
define('FS_SUCCESS_CO','Sparkasse Freising');
define('FS_SUCCESS_AC_NO','IBAN ');
define('FS_SUCCESS_TEL','DE16 7005 1003 0025 6748 88');
define('FS_SUCCESS_SWIFT','BIC ');
define('FS_SUCCESS_HK','BYLADEM1FSI');
define('FS_SUCCESS_BANK_ADRESS','Numéro de Compte ');
define('FS_SUCCESS_ROAD','25674888');
define('FS_SUCCESS_OUR','Adresse de la Banque Bénéficiaire ');
define('FS_SUCCESS_NO','Untere Hauptstr.29, 85354, Freising');
/******************html_checkout_success_paypalwpp.php*******************/
define('FS_SUCCESS_PAYPAL','Paypal');
define('FS_SUCCESS_TRANSFER','Détails du Virement Bancaire des bénéficiaires');
define('FS_SUCCESS_TRANS_CODE','Code de Transaction Paypal');
define('FS_SUCCESS_YOU','Maintenant, vous pouvez revenir à');
define('FS_SUCCESS_HOME','la page d\'Accueil');
define('FS_SUCCESS_OR','ou voir');
define('FS_SUCCESS_MY','mes commandes');
/*****************html_checkout_success_westernunion.php******************/
define('FS_SUCCESS_WES_YOUR','Votre prochaine étape consiste à effectuer votre paiement de Western Union et soumettre vos informations de paiement.');
define('FS_SUCCESS_WES_BENE','Détails des Bénéficiaires');
define('FS_SUCCESS_BENEFICIARY','Bénéficiaire');
define('FS_SUCCESS_ZYX','ZongYun Xu');
define('FS_SUCCESS_FIRST','Prénom');
define('FS_SUCCESS_ZY','ZongYun');
define('FS_SUCCESS_LAST','Nom');
define('FS_SUCCESS_X','Xu');
define('FS_SUCCESS_WES_RECEIVER','Numéro de téléphone du destinataire');
define('FS_SUCCESS_PHONE','13926572260');
define('FS_SUCCESS_ADDRESS','Adresse');
define('FS_SUCCESS_SZ','Shenzhen 518045, China');
define('FS_SUCCESS_WU','Western Union');
define('FS_SUCCESS_NOTE','Remarque');
define('FS_SUCCESS_YOUR_ORDER','Votre statut de la commande passera à « Paiement Confirmé » dans les 2 jours ouvrables après la vérification de votre paiement. Certaines commandes prendraient plus de temps pour vérifier.');
define('FS_CHECKOUT_SUCCESS_05','Pour toute question, veuillez  nous contacter par téléphone '.fs_new_get_phone().' ou par e-mail');
define('FS_CHECKOUT_SUCCESS_05_1','Pour toute question, veuillez  nous contacter par téléphone $PHONE ou par e-mail $EMAIL.');

//add by Aron 2017.7.18
define('FS_SUCCESS_PURCHASE_YOUR_NEXT','La prochaine étape est de télécharger votre Bon de Commande, nous n\'expédierons les articles que nous le recevons.');
define('FS_SUCCESS_PAYMENT_DATE','Date de Paiement');

//add by Aron 2017.7.25
define("FS_UPLOAD_TITLE","Ajouter le Bon de Commande");
//define("FS_UPLOAD_TEXT","Ajouter votre Bon de Commande et économisez le temps. Nous allons traiter votre commande dès la réception de ce document.  Veuillez vous assurer que toutes les signatures et informations nécessaires sont fournies. ");
define("FS_UPLOAD_TEXT","Ajouter votre Bon de Commande et gagnez du temps. Nous traiterons votre commande dès la réception de ce document.  Veuillez vous assurer que toutes les signatures et informations nécessaires sont fournies. ");


//add by aron 2017.11.18
//add by frankie 2018.1.2. 
define("FS_SUCCESS_GLOABL_THANK","Le paiement est réussi ! Votre commande est en cours.");
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","L'adresse de livraison ne correspond pas à l'adresse de votre formulaire de demande de crédit. Nous examinerons la commande et vous enverrons le résultat par e-mail dans les 12 heures. Veuillez télécharger le document de bon de commande dans un délai de 7 jours ouvrables, sinon la commande sera automatiquement annulée en raison de la modification de l'inventaire des articles.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","Votre crédit disponible a été dépassé. Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes pour récupérer le crédit, ou vous pouvez vous rendre à <a href ='".zen_href_link('my_dashboard')."'>”Mon Crédit”</a> pour demander l'augmentation de la limite de crédit. Veuillez télécharger le documentde bon de commande dans un délai de 7 jours ouvrables, sinon la commande sera automatiquement annulée en raison de la modification de l'inventaire des articles.");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","L'adresse de livraison ne correspond pas à l'adresse de votre formulaire de demande de crédit et votre crédit disponible est également dépassé. Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes pour récupérer le crédit, ou vous pouvez vous rendre à <a href ='".zen_href_link('my_dashboard')."'>”Mon Crédit”</a> pour demander l'augmentation de la limite de crédit. Nous examinerons la commande et vous enverrons le résultat par e-mail dans les 12 heures. Veuillez télécharger le document de bon commande dans un délai de 7 jours ouvrables. Sinon, la commande sera automatiquement annulée en raison de la modification de l'inventaire des articles.");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE_1","Veuillez télécharger votre fichier de bon de commande dans les 7 jours ouvrables. Sinon, la commande sera automatiquement annulée en raison de la modification de l'inventaire des articles.");
define('FIBER_CHECK_SPARK','Compte Bancaire Sparkasse :');
define("PICK_UP_ALERT1","désolé, le nom sur la photo d'identité est requis.");
define("PICK_UP_ALERT2",'désolé, le numéro de téléphone est requis.');
define("PICK_UP_ALERT4",'le temps de ramassage est requis.');
define('FS_CHECKOUT_SUCCESS_SALES','.');

//OP下单成功后提示语
define('FS_CHECKOUT_PURCHASE_ADDRESS','L\'adresse de livraison ne correspond pas à celle indiquée sur votre formulaire de demande de crédit. Nous examinerons la commande et vous enverrons le résultat par e-mail dans un délai de 12 heures.');
define('FS_CHECKOUT_PURCHASE_EXCESS','Votre crédit disponible a été dépassé. Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes afin de récupérer le crédit, ou vous pouvez vous rendre à "Mon Crédit" dans votre compte, pour demander une augmentation de la limite de crédit.');
define('FS_CHECKOUT_PURCHASE_ALL','L\'adresse de livraison ne correspond pas à celle indiquée sur votre formulaire de demande de crédit. Votre crédit disponible a également été dépassé. Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes afin de récupérer le crédit, ou vous pouvez vous rendre à "Mon Crédit" dans votre compte, pour demander une augmentation de la limite de crédit. Nous examinerons la commande et vous enverrons le résultat par e-mail dans un délai de 12 heures.');

//下单成功优化 add time 2020-04-06 jay
define('FS_CHECKOUT_SUCCESS_NEW_01', "Merci pour votre achat");
define('FS_CHECKOUT_SUCCESS_NEW_02', "La commande sera annulée après 7 jours en raison du changement de stock des articles. Veuillez compléter le paiement dans un délai de 1 à 3 jours ouvrables et indiquer le numéro de commande FS ou le nom de votre entreprise, ce qui aidera notre Équipe de Gestion Financière à identifier votre versement et à traiter la commande dans les plus brefs délais.
");
define('FS_CHECKOUT_SUCCESS_NEW_03', "Informations sur la Commande");
define('FS_CHECKOUT_SUCCESS_NEW_PO_NUMBER_04', "N° de PO");
define('FS_CHECKOUT_SUCCESS_NEW_DELIERY_ADDRESS_05', "Adresse de Livraison");
define('FS_CHECKOUT_SUCCESS_NEW_PAYMENT_INSTRUCTIONS_06', "Instructions de Paiement");
define('FS_CHECKOUT_SUCCESS_NEW_07', "Une fois le paiement effectué avec succès, veuillez envoyer un bordereau de virement bancaire à l'adresse suivante ");
define('FS_CHECKOUT_SUCCESS_NEW_08', " ou votre responsable de compte. Cela permettra de libérer votre commande en priorité et d'éviter son annulation. Veuillez effectuer votre paiement sur le compte suivant.");
define('FS_CHECKOUT_SUCCESS_NEW_BSB_09', "BSB");
define('FS_CHECKOUT_SUCCESS_NEW_ACCOUNT_NO_10', "N° de Compte");
define('FS_CHECKOUT_SUCCESS_NEW_SWIFT_CODE_11', "Code SWIFT");
define('FS_CHECKOUT_SUCCESS_NEW_BANK_ADDRESS_12', "Adresse de la Banque");
define('FS_CHECKOUT_SUCCESS_NEW_13', "Veuillez laisser votre numéro de commande ");
define('FS_CHECKOUT_SUCCESS_NEW_14', " et votre adresse e-mail dans la note de transfert bancaire.");
define('FS_CHECKOUT_SUCCESS_NEW_DELIVERY_POLICY_15', "Politique de Livraison");
define('FS_CHECKOUT_SUCCESS_NEW_16', "Le délai de livraison estimé prend effet à partir du moment où nous avons reçu votre paiement.");
define('FS_CHECKOUT_SUCCESS_NEW_17', "Votre commande sera livrée entre 9h et 17h, du Lundi au Vendredi (hors jours fériés). Une personne devra être présente à l'adresse indiquée pour accepter et confirmer la livraison.");
define('FS_CHECKOUT_SUCCESS_NEW_PRINT_18', "Imprimer");
define('FS_CHECKOUT_SUCCESS_NEW_DOWNLOAD_19', "Télécharger");
define('FS_CHECKOUT_SUCCESS_NEW_ORDER_DETAILS_20', "Détails de la Commande");
define('FS_CHECKOUT_SUCCESS_NEW_BILLING_ADDRESS_21', "Adresse de Facturation");
//账期
define('FS_CHECKOUT_SUCCESS_PURCHASE_THINK_YOU_01', "Merci, ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_YOUR_ORDER_02', "Votre commande ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_05', "Nous allons procéder au traitement du bon de commande dès la réception du fichier PO. Veuillez vous assurer que toutes les signatures et informations nécessaires sont fournies. Vous pouvez également télécharger votre fichier PO dans ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_LATER_06', " plus tard.");
define('FS_CHECKOUT_SUCCESS_PURCHASE_ORDER_AMOUNT_07', "Montant de la Commande");
define('FS_CHECKOUT_SUCCESS_PURCHASE_TOTAL_08', "Total");
define('FS_CHECKOUT_SUCCESS_PURCHASE_09', "Le délai de livraison estimé prend effet à partir du moment où nous avons reçu votre fichier PO.");
define('FS_CHECKOUT_SUCCESS_PURCHASE_10', "Votre commande sera livrée entre 9h et 17h, du Lundi au Vendredi (hors jours fériés). Une personne devra être présente à l'adresse indiquée pour accepter et confirmer la livraison.");
define('FS_CHECKOUT_SUCCESS_PURCHASE_ACCOUNT_CENTER_11', "centre de compte");
define('FS_CHECKOUT_SUCCESS_PURCHASE_12', "Un résumé et une confirmation de votre commande vous ont été envoyés par e-mail. Si vous avez des questions, veuillez appeler le ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_13', "Mon compte");
define('FS_CHECKOUT_SUCCESS_PURCHASE_14', "Découvrez comment FS simplifie votre expérience d'achat en ligne");
define('FS_CHECKOUT_SUCCESS_PURCHASE_15', "Voir Mon PO");
define('FS_CHECKOUT_SUCCESS_PURCHASE_16', "Suivi de Vos Articles");
define('FS_CHECKOUT_SUCCESS_PURCHASE_17', "Historique de Commandes");

define('FS_CHECKOUT_SUCCESS_PURCHASE_18', "Paiement");
define('FS_CHECKOUT_SUCCESS_PURCHASE_19', "fr@fs.com");
define('FS_CHECKOUT_SUCCESS_PURCHASE_20', "Livraison Prévue");
define('FS_CHECKOUT_SUCCESS_PURCHASE_21', ".");
define('FS_CHECKOUT_SUCCESS_PURCHASE_22', "Date de la Commande ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_23', "N° de Commande ");
define('FS_CHECKOUT_SUCCESS_PURCHASE_24', "Informations sur le Bon de Commande");
define('FS_CHECKOUT_SUCCESS_PURCHASE_25', "Imprimer PI");

// 武汉仓
define('FS_COMMON_WAREHOUSE_CN_CHECKOUT_SUCCESS','ATTN : FS. COM LIMITED<br> 
			Address : A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China');
define('FS_COMMON_WAREHOUSE_CN_NEW_CHECKOUT_SUCCESS','FS.COM LIMITED<br> 
			A115 Jinhetian Business Centre <br> 
			No.329, Longhuan Third Rd <br> 
			Longhua District <br>
			Shenzhen, 518109, <br> Chine');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU_CHECKOUT_SUCCESS','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Allemagne');
define('FS_COMMON_WAREHOUSE_US_CHECKOUT_SUCCESS','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			États-Unis');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST_CHECKOUT_SUCCESS','ATTN: FS.COM Inc.<br>
					Adresse : 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					États Unis');
define('FS_COMMON_WAREHOUSE_SG_CHECKOUT_SUCCESS','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapour');

// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU_CHECKOUT_SUCCESS','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175, Australie');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG_CHECKOUT_SUCCESS','ATTN: FS Tech Pte Ltd.<br>
				Adresse : 30A Kallang Place #11-10/11/12<br>
				Singapour 339213<br>
				Singapour');

define('FS_COMMON_FEEDBACK_TIP','Pour nous aider à vous offrir une meilleure expérience d\'achat lors de votre prochaine visite, nous aimerions connaître votre avis. Veuillez <a href="javascript:;" style="color:#0070BC;" onclick="$(\'.have_feedback\').show()" id="have_checkout_feedback">cliquer ici</a> pour laisser vos commentaires.');
?>