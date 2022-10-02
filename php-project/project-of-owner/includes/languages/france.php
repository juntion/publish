<?php

define('FOOTER_TEXT_BODY', 'Copyright &copy; 2009-' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">FS.COM</a>. Tous Droits Réservés. <a href="' . zen_href_link('privacy_policy') . '">Politique de Confidentialité</a><a href="' . zen_href_link('terms_of_use') . '">&nbsp;&nbsp;Conditions d\’Utilisation</a>');
/*bof language for my_account*/

//夏令时--冬令时
define('SUMMER_TIME',true);
if(SUMMER_TIME){
    define('FS_SUMMER_OR_WINTER_TIME','16h30 (UTC/GMT + 2)');
    define('FS_CHECKOUT_TIME','16h30 UTC/GMT + 2');
}else{
    define('FS_SUMMER_OR_WINTER_TIME','16h (UTC/GMT + 1)');
    define('FS_CHECKOUT_TIME','16h30 UTC/GMT + 1');
}

//define('FIBERSTORE_CDN_IMAGES','https://d2gwt4r5cjfqmi.cloudfront.net/');
define('FIBERSTORE_CDN_IMAGES', '/images/');

define('F_HAVE_NO_SHOPCART', 'Votre panier est vide.');
define('FS_EMAIL_FSCOM', 'https://www.fs.com/fr');

define('FIBERSTORE_SAVE', 'Sauvegarder');
define('FIBERSTORE_WRITE_REVIEW', 'Écrire un Commentaire');

//装箱页面新增
define("FS_PRODUCT_INFO_SIZE", "Paquet :");
define("FS_PRODUCT_INFO_PIECE", "1 Pièce");
define("FS_PRODUCT_INFO_CASE", "Commande par Paquet (");
define("FS_PRODUCT_INFO_PIS", "pcs/paquet");
define("FS_PRODUCT_INFO_PIS_1", "pcs/");

//******************country_name************************/
define('FS_COUNTRY_NAME1', 'États Unis');
define('FS_COUNTRY_NAME2', 'Canada');
define('FS_COUNTRY_NAME3', 'Australie');
define('FS_COUNTRY_NAME4', 'United Kingdom');
define('FS_COUNTRY_NAME5', 'Royaume-Uni');
define('FS_COUNTRY_NAME6', 'Singapour');
define('FS_COUNTRY_NAME7', 'Italy');
define('FS_COUNTRY_NAME8', 'Italie');
define('FS_COUNTRY_NAME9', 'France');
define('FS_COUNTRY_NAME10', 'Brésil');
define('FS_COUNTRY_NAME11', 'Allemagne');
define('FS_COUNTRY_NAME12', 'l' . "'" . 'Espagne');

//******************body box menu***********************/
define('F_BODY_HEADER_BACK', 'Retour à la page d\'accueil de Fiberstore');
define('F_BODY_HEADER_GS', 'Livraison Mondiale');
define('F_BODY_HEADER_ITEMS', 'Articles');
define('F_BODY_HEADER_ITEM_TWO', 'Articles');
define('F_BODY_HEADER_ITEM', 'Article');
define('FIBERSTORE_ITEMS', ' Articles');
//manege address
define('FIBER_DEFAULT_Address', 'Adresse par défaut');
define('F_BODY_MENU_CATEG', 'Les Catégories');
define('F_BODY_MENU_HOME', 'Accueil');
define('F_BODY_MENU_WHOLESALES', 'Achat en Gros');
define('F_BODY_MENU_PROD', 'Support');
define('F_BODY_MENU_TUTORIAL', 'Tutoriel');
define('F_BODY_MENU_ABOUT', 'A propos de Nous');
define('F_BODY_MENU_SUPP', 'Service');
define('F_BODY_MENU_CONTANT', 'Contactez-Nous');

//******************new_product***********************/
define('FS_NET_PRODUCT1', 'Produits Récemment Lancés');
define('FS_NET_PRODUCT2', 'Suivez la technologie de pointe du réseau optique, profitez de fruits des innovations illimitées');
define('FS_NET_PRODUCT3', 'Nouveaux Produits');
define('FS_NET_PRODUCT4', 'Revenez périodiquement à cette page Nouveaux Produits pour suivre notre dernière offre');
define('FS_NET_PRODUCT5', 'Trier par :');
define('FS_NET_PRODUCT6', 'Produits vedettes');
define('FS_NET_PRODUCT7', 'Dernière Nouveauté');
define('FS_NET_PRODUCT8', 'Nouveaux Produits');
define('FS_NET_PRODUCT9', 'Catégories');
define('FS_NET_PRODUCT10', 'MOQ faible aux prix de gros');
define('FS_NET_PRODUCT11', 'Pour les petits et moyens acheteurs.');
define('FS_NET_PRODUCT12', 'Transactions en ligne sécurisées');
define('FS_NET_PRODUCT13', 'Divers moyens de paiement en ligne sécurisées pour vous.');
define('FS_NET_PRODUCT14', 'Commandez maintenant pour une expédition rapide');
define('FS_NET_PRODUCT15', 'Les articles en stock peuvent être expédiés le même jour.');
define('FS_NET_PRODUCT16', 'Revenez périodiquement à cette page pour suivre notre dernière offre');
define('FS_NET_PRODUCT17', 'Prix : par ordre croissant');
define('FS_NET_PRODUCT18', 'Prix : par ordre décroissant');
define('FS_NET_PRODUCT19', 'Trier par :');
define('FS_NET_PRODUCT20', 'Produits Vedettes');
define('FS_NET_PRODUCT21', '');
define('FS_NET_PRODUCT22', '');
define('FS_NET_PRODUCT23', '');
define('FS_NET_PRODUCT24', 'Effacer la sélection');

//***************shop cart******************************/
define('FIBERSTORE_REMOVE', 'Supprimer');
define('FIBERSTORE_CART_TOTAL', 'Total du Panier');
define('FIBERSTORE_EDITE_ORDER', 'Modifier Mon Panier');
define('FIBERSTORE_CHECK_YOU_ORDER', 'Commander');
define('FS_FILTER', 'Filtrer');
define('FS_PROCEED_TO_CHECKOUT', 'PASSER A LA CAISSE');
define('FS_ITEMS', 'Articles');
define('FS_CART', 'Panier');
define('FS_VIEW_ALL', 'Voir Tout');
//******************Product List************************/
//*****************产品列表页标题******************************
define('FIBERSTORE_LIST_BIAO', 'Par Défaut');
define('FIBERSTORE_LIST_BIAO2', 'Ventes');
define('FIBERSTORE_LIST_BIAO3', 'Prix');
define('FIBERSTORE_LIST_BIAO4', 'Nouveau');
define('FIBERSTORE_LIST_BIAO5', 'Image');
define('FIBERSTORE_LIST_BIAO6', 'Statut');
define('FIBERSTORE_LIST_BIAO7', 'Date d\'Expédition Estimée');
define('FIBERSTORE_LIST_BIAO8', 'Prix');
define('FIBERSTORE_LIST_BIAO9', 'Qté');
define('FIBERSTORE_LIST_BIAO10', 'Prix de volume');
define('FIBERSTORE_LIST_BIAO11', 'Le jour même');
define('FIBERSTORE_LIST_BIAO12', 'Acheter');
define('FIBERSTORE_LIST_BIAO13', 'Si vous avez besoin d’un grand volume de commande, veuillez demander un');
define('FIBERSTORE_LIST_BIAO131', 'compte d\'affaires </a> ou');
define('FIBERSTORE_LIST_BIAO132', 'contactez-nous </a> pour bénéficier des politiques préférentielles.');
define('FIBERSTORE_LIST_BIAO14', 'Estimated the next day');
define('FIBERSTORE_LIST_BIAO15', 'Estimated on');
define('FIBERSTORE_LIST_BIAO16', 'Voir les Détails');
define('FIBERSTORE_LIST_BIAO17', ' Commentaires');
define('FIBERSTORE_LIST_BIAO18', 'Longueur d\'Onde');
define('FIBERSTORE_LIST_BIAO19', 'Distance');
define('FIBERSTORE_LIST_BIAO20', 'Débit de Données');
define('FIBERSTORE_LIST_BIAO21', 'Obtenir un Devis');
define('FIBERSTORE_LIST_BIAO22', 'Nom');
define('FIBERSTORE_LIST_BIAO23', 'Monnaie');
define('FIBERSTORE_LIST_BIAO24', 'Atténuateurs Optiques :');
define('FIBERSTORE_LIST_BIAO25', 'Modems Fibres Optiques :');
define('FIBERSTORE_LIST_BIAO26', 'Longueurs d\'Onde de Fonctionnement:');
define('FIBERSTORE_LIST_BIAO27', 'Marques Compatibles:');
define('FIBERSTORE_LIST_BIAO28', 'Plus');
define('FIBERSTORE_LIST_BIAO29', 'Voir Plus de Marques');
define('FIBERSTORE_LIST_BIAO31', 'Voir Moins de Marques');
define('FIBERSTORE_LIST_BIAO30', 'Catégories');

define('FIBERSTORE_LIST_BIAO32', 'Application');
define('FIBERSTORE_LIST_BIAO33', 'Description');
define('FIBERSTORE_LIST_BIAO34', 'Numéro de Pièce');
define('FIBERSTORE_LIST_BIAO35', 'Diamètre du Câble (mm)');
define('FIBERSTORE_LIST_BIAO36', 'Poids du Câble (kg/km)');
define('FIBERSTORE_LIST_BIAO37', 'Prix Unitaire ($/m)');

define('FS_WAIT', 'Veuillez attendre...');
define('FS_PROCESSING', 'En Traitement');
//*****************新增产品列表页常量2016-05-16******************************


define('F_PRODUCT_IMAGES', 'Images');
define('F_PRODUCT_STATUS', 'Status');
define('F_PRODUCT_WAVELENGTH', 'Longueur d\'onde');
define('F_PRODUCT_DISTANCE', 'Distance');
define('F_PRODUCT_DATERATE', 'Vitesse');
define('F_PRODUCT_SHIPDATE', 'Date de livraison');
define('F_VOLUME_PRICE', 'Prix en volume');
define('F_VOLUME_PRICE_GET', 'Si vous avez besoin d\'un grand volume de commande, s\'il vous plaît demander un<a href="<?php echo $href;?>" target="_blank">Compte d\'affaires</a> ou <a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">contactez-nous</a>  pour profiter des politiques préférentielles.');
define('F_OPTION_ARRAY1', 'Prix : décroissant ');
define('F_OPTION_ARRAY2', 'Prix : croissant');
define('F_OPTION_ARRAY3', 'Meilleures ventes');
define('F_OPTION_ARRAY4', 'Produits évalués supérieurs');
define('F_OPTION_ARRAY5', 'Nouveaux articles');

define('F_PRODUCT_RECOMMEND', 'Produits recommandés');
define('F_PRODUCT_RESULTS', '<div class="results_font">Désolé, nous avons trouvé  <s>0</s> résultat !  <a href="<?php echo zen_href_link(FILENAME_DEFAULT, cPath=' . (int)$current_category_id . ');?>">Vérifiez d\'autres produits</a>.</div>');
define('F_PRODUCT_REVIEWS', 'Commentaires');
//******************LEFT_sidebar************************/


/*******************Checkout***********************************/
define('NAVBAR_TITLE_1', 'Caisse');
define('FIBERSTORE_PROTECT_CHECKOUT', 'Passez à la Caisse');
define('F_SHIPPING_ADDRESS', 'Adresse de Livraison');
define('F_M_BILLING_ADDRESS', 'Gérer votre adresse de facturation');
define('F_NEW_SHIPPING_ADDRESS', 'Ajouter une nouvelle adresse de livraison');
define('F_SHIPPING_METHOD', 'Moyen de Livraison');
define('F_CART', 'Panier');
define('F_SUCCESS', 'Succès');
define('F_SHIPPINGTIME_COST', '<th width="500">Moyen de Livraison
                      </th>
                    <th width="230">Délai de Livraison Estimé
                      </th>
                    <th width="118">Coût
                      </th>');
define('F_FEDEX_IP', 'FedEx IP');
define('F_PRIORITY', 'Priorité');
define('F_FREIGHT_COLLECT', 'Fret Payable');
define('F_WARNING', 'Si vous préférez utiliser votre propre compte Express, veuillez fournir le numéro de compte, puis Fiberstore ne facture pas les frais de transport.');
define('F_SHIPPING_METHOD', 'Moyen de Livraison : ');
define('F_EXPRESS_ACCOUNT', 'Compte Express : ');
define('F_NO_SHIPPING', 'Pas de livraison disponible pour le pays sélectionné, pour plus de détails, s\'il vous plaît');
define('F_CONTACT_US', 'contactez-nous');
define('F_TIPS', 'Astuse');
define('F_TIPS_MSG', 'S\'il vous plaît entrez votre adresse de livraison ci-dessus, alors le système Fiberstore va vous montrer toutes les modes de livraison à votre pays.');
define('F_WHEN_ORDER_ARRIVE', 'Quand ma commande va-t-elle arriver ?');
define('F_PROCESSING', 'Temps de Traitement et d\'Expédition');
define('F_MORE_INFORMATION', 'Plus d\'Informations');
define('F_PROCESSING_TIME', 'Temps de traitement :');
define('F_ALL_PRODUCTS', 'Tous les produits nécessitent un traitement avant expédition. Le traitement consiste à la sélection de produits, le contrôle d\'assurance de la qualité et l\'emballage soigné pour l\'expédition.<br />
                <b>Délai Moyen de Traitement :</b> 2-5 jours en moyenne<br />
                <b>Exceptions :</b>Ça Dépend. Vous devez contacter notre service commercial pour savoir plus d\'informations.<br />
                <br />
                <span>Livraison :</span><br />
                Le temps d\'expédition dépend du moyen d\'expédition :<br />
                <b>Expédition rapide :</b> 1-4 jours ouvrables<br />
                <b>Expédition standard :</b> 2-6 jours ouvrables<br />
                <b>Livraison super-économique :</b> 10-30 jours ouvrables<br />
                FiberStore.com choisit le meilleur transporteur en fonction des exigences de votre commande et la destination d\'expédition. En cas de circonstances spéciales, nous vous contacterons.<br />');
define('F_PAYMENT_METHOD', 'Mode de Paiement');
define('F_WE_CURRENTLY', 'Nous assistons actuellement le virement télégraphique pour toutes les commandes. Nous prenons très au sérieux la sécurité, de sorte que vos informations sont en sécurité avec nous.');
define('F_CART_SUMMARY', 'Résumé de Panier');
define('F_ITTEM', 'Article');
define('F_QTY', 'Quantité');
define('F_WEIGHT', 'Poids');
define('F_PRICE', 'Prix');
define('F_TOTA_AMOUNT', 'Compte Total');
define('F_TOTAL', 'Total');
define('F_SHIPPING_COST', '(+)Frais de Livraison :');
define('F_EXCLUDING_TAXES', 'Hors taxes ?');
define('F_PO', 'Remplissez votre numéro PO');
define('FIBERSTORE_WAIT_PROCESSING', 'Traitement');
define('DISCLAIMER_ORDERS', 'DISCLAIMER pour les commandes internationales');
define('DISCLAIMER_ORDERS_CONMENT', 'Les droits d\'importation, les taxes et les frais de courtage ne sont pas inclus dans le prix du produit ou du coût de transport et de manutention, ils seront recueillis lors de la livraison des transporteurs pour certains paquets. Comme le bureau de douane applique les frais de douane au hasard lorsque vos colis arrivent, nous ne pouvons pas prédire.<br />
            <br />
            Ces frais sont la responsabilité de destinataire, nous ne facturons que les frais de transport pour les paquets. Vous pouvez vérifier auprès de bureau de douane de votre pays pour déterminer ces coûts supplémentaires.');
define('FS_CHECK_PAYTIT', 'Nous acceptons les paiements via Paypal, Carte de Crédit / Débit et Virement Bancaire pour toutes les commandes. Veuillez prendre la sécurité au sérieux, afin que vos informations sont en sécurité avec nous.');
define('FS_CHECK_PAY1', 'Carte de Crédit / de Débit');
define('FS_CHECK_PAY2', 'Virement Bancaire');
define('FS_CHECK_NOTE', 'Remarque');
define('CHECK_PAY1_TIT', 'Les utilisateurs de PayPal peuvent effectuer le paiement via votre compte PayPal.');
define('CHECK_PAY1_CON', 'Les nouveaux utilisateurs peuvent enregistrer un compte PayPal d’abord, puis continuer à payer sur le site PayPal.');
define('CHECK_PAY1_FOT', 'vous pouvez payer directement par PayPal, notre compte est  :');
define('CHECK_PAY2_TIT', 'Nous acceptons les cartes de  crédit et de débit suivantes :');
define('CHECK_PAY2_CON', 'Pour des raisons de sécurité, nous ne conservons aucune de vos données de carte de crédit.');
define('CHECK_PAY3_TIT', 'Détails de Bénéficiaire de Virement Bancaire :');
define('CHECK_PAY3_ADD1', 'Nom de la Banque Bénéficiaire :');
define('CHECK_PAY3_ADD2', 'Nom du Bénéficiaire A/C :');
define('CHECK_PAY3_ADD3', 'Numéro de Bénéficiaire A/C :');
define('CHECK_PAY3_ADD4', 'Adresse SWIFT :');
define('CHECK_PAY3_ADD5', 'Adresse de la Banque Bénéficiaire :');
define('CHECK_PAY3_ADD6', 'Adresse de Notre Société :');
define('CHECK_PAY3_ADD7', 'Eastern Side, Second Floor, Science & Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
define('CHECK_PAY3_CON', 'Les clients qui choisissent le virement bancaire est responsable de tous les frais de manutention et les frais de traitement des banques intermédiaires locales.');
define('FS_CHECK_TOTAL', '<b>Clause de Non-Responsabilité pour les Commandes Internationales</b><br /><br />

Les droits d\'importation, les taxes et les frais de courtage ne sont pas inclus dans le prix du produit ou du coût de transport et de manutention, ils seront recueillis lors de la livraison des transporteurs pour certains paquets. Comme le bureau de douane applique les frais de douane au hasard quand le colis arrive, nous ne pouvons pas prédire.<br /><br />

Ces frais sont la charge du destinataire, nous ne facturons que les frais de transport pour les colis. Vous pouvez vérifier auprès de bureau de douane de votre pays pour déterminer ces coûts supplémentaires.');
define('FS_CHECK_EDIT', 'Modifier Ma Commande');
define('FS_CHECK_SUB1', 'Payer avec PayPal');
define('FS_CHECK_SUB2', 'Soumettre la Commande');
define('FS_ADDRESS_TIT', 'Indique un champ obligatoire.');
define('FS_ADDRESS_TIT1', 'Adresse de Facturation');
define('FS_ADDRESS_TIT2', 'Ajouter une Nouvelle Adresse de Facturation');
define('FS_ADDRESS_LI1', 'Prénom :');
define('FS_ADDRESS_LI2', 'Nom :');
define('FS_ADDRESS_LI3', 'Ligne d\'Adresse :');
define('FS_ADDRESS_LI4', 'Ville :');
define('FS_ADDRESS_LI5', 'Pays :');
define('FS_ADDRESS_LI6', 'Veuillez Sélectionner');
define('FS_ADDRESS_LI7', 'Pays / Région / Département:');
define('FS_ADDRESS_LI8', 'ZIP / Code Postal :');
define('FS_ADDRESS_LI9', 'Numéro de Téléphone :');
define('FS_ADDRESS_LI10', 'Sauvegarder');
define('FS_ADDRESS_LI11', 'Annuler');
define('FS_ADDRESS_LI12', 'Traitement ...');
define('FS_CHECK_COLLECT', 'Fret Payable');
define('FS_COLLECT_TIT', 'Méthode d\'Expédition :');
define('FS_COLLECT_TIT1', 'Compte Express :');

define('FIBERSTORE_CREDIT_CARD', 'Payer par Carte de Crédit ');
define('FIBERSTORE_CREDIT_CARD2', '
          <td width="20%"><div align="left" class="pay_lc_01">&nbsp;Panier</div></td>
          <td width="25%"><div align="center" class="pay_lc_03">Caisse</div></td>
          <td width="25%"><div align="right" class="pay_lc_04">Réussi</div></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="login_new_03">
  <div class="login_new_04">
    <div class="transfer">
      <div class="credit_card_left">
	  <div class="login_title">Centre de Paiement de Carte de Crédit / Débit</div>
        <div class="credit_card_title">Information de Facturation</div>
        <div class="credit_card_content"><span>S\'il vous plaît vérifier que l\'adresse de facturation que vous avez entré ci-dessous correspond au nom et l\'adresse associée à la carte de crédit que vous utilisez pour cet achat. S\'il vous plaît noter que le pays de votre adresse de facturation et adresse de livraison doit être le même.');

define('FIBERSTORE_CREDIT_CARD3', 'Prénom :');
define('FIBERSTORE_CREDIT_CARD4', 'Nom :');
define('FIBERSTORE_CREDIT_CARD5', 'Adresse de Facturation');
define('FIBERSTORE_CREDIT_CARD6', 'Pays / Région Destinataire :');
define('FIBERSTORE_CREDIT_CARD7', 'Pays / Région / Département:');
define('FIBERSTORE_CREDIT_CARD8', 'Ville :');
define('FIBERSTORE_CREDIT_CARD9', 'ZIP / Code Postal :');
define('FIBERSTORE_CREDIT_CARDT', 'Numéro de Téléphone :');
define('FIBERSTORE_CREDIT_CARD10', 'Votre paiement a été refusé. S\'il vous plaît utiliser une autre carte de crédit ou modifier le mode de paiement à PayPal ou Virement Bancaire sur une commande ouverte.');
define('FIBERSTORE_CREDIT_CARD11', 'Information de Carte de Crédit / Débit
<div class="track_orders_wenhao">
		<div class="question_bg"></div>
			<div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">Nous acceptons les cartes de crédit / débit suivantes. S\'il vous plaît sélectionner un type de carte, compléter les informations ci-dessous et cliquez sur Continuez. <span>(Remarque : Pour des raisons de sécurité, nous ne conservons aucune de vos données de carte de crédit.)');
define('FIBERSTORE_CREDIT_CARD12', 'Selectionnez la Carte de Crédit / Débit:');
define('FIBERSTORE_CREDIT_CARD13', 'Numéro de Carte :');
define('FIBERSTORE_CREDIT_CARD14', 'Date d\'Expiration :');
define('FIBERSTORE_CREDIT_CARD15', 'Mois ');
define('FIBERSTORE_CREDIT_CARD16', 'Année');
define('FIBERSTORE_CREDIT_CARD17', 'Code de Sécurité :');
define('FIBERSTORE_CREDIT_CARD18', 'Continuez');
define('FIBERSTORE_CREDIT_CARD19', 'Récapitulatif de Commande');
define('FIBERSTORE_CREDIT_CARD20', 'Sous-total :');
define('FIBERSTORE_CREDIT_CARD21', 'Frais d\'Expédition :');
define('FIBERSTORE_CREDIT_CARD22', 'Montant Total :');
define('FIBERSTORE_CREDIT_CARD23', 'Sécurité des paiements supplémentaires avec :');

/*****************checkout_success update by king on 2016.6.13 *******************/

/******************* update END 2016.6.13 ***************************/

/************************end_checkout******************************/

define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Montrer<strong>%d</strong> à <strong>%d</strong> (des <strong>%d</strong> Nouvelles )');
define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Montrer<strong>%d</strong> à <strong>%d</strong> (du <strong>%d</strong> Tutoriel )');
/*eof*/
// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'en_US.UTF-8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
// define('FIBERSTORE_REGIST_ERROR','Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');
define('FIBERSTORE_REGIST_ERROR', 'Nuestro sistema ya tiene un registro de dicha dirección de correo electrónico - por favor intenta acceder a dicha dirección de correo electrónico. Si usted no usa esa dirección por más tiempo se puede corregir en el area Mi Cuenta');
define('FIBERSTORE_LOGIN_ERROR', 'La dirección de email o la contrase?a es incorrecta.');

/*bof language contact_us email time:2012_12_17*/
//define('FIBERSTORE_WELCOME_MEAASGE','This email message was sent from a notification-only address that cannot accept incoming email. PLEASE DO NOT REPLY to this message. If you have any questions please contact us.');
define('FIBERSTORE_WELCOME_MEAASGE', 'Este mensaje fue enviado desde una dirección exclusivamente de notificación que no puede recibir mensajes entrantes. Por favor no responda a este mensaje. Si usted tiene alguna pregunta, por favor póngase en contacto con nosotros.');

define('FIBERSTORE_REVIEW_NO', 'Ninguna revisión actualmente .');
define('FIBERSTORE_WELCOME_TO', 'Estimado cliente,');
define('FIBERSTORE_WELCOME_CART', 'Carrito Permanente');
//define('FIBERSTORE_WELCOME_CART','Permanent Cart');
define('FIBERSTORE_CONTACT_ABOUT', 'sobre nosotros contenido de ecoptical.com');
define('FIBERSTORE_CUSTOMER_NAME', 'Nombre del cliente:');
define('FIBERSTORE_CUSTOMER_EMAIL', 'Cliente E-mail:');
define('FIBERSTORE_CONTACT_SUBJECT', 'sujeto');
define('FIBERSTORE_CONTACT_CONTENTS', 'Contenido:');
define('FIBERSTORE_CONTACT_FROM', 'De ' . zen_href_link('index'));

define('FIBERSTORE_SELECT', 'Por favor seleccione...');
//  define('FIBERSTORE_SELECT','Please select ...');


define('FIBERSTORE_PROCESSING', 'Traitement en cours');
define('FIBERSTORE_CONTINUE_TO_PAYMENT', 'Procéder au Paiement');
define('F_UNIT_PRICE', 'Prix Unitaire');

define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="'.zen_href_link('index').'">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
				</a>		
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="' . HTTPS_SERVER.reset_url('support/Data-Center-Products.html') . '">Centre de Données</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="' . HTTPS_SERVER.reset_url('support/Enterprise-Small-Business.html') . '">Réseau d\'Entreprise</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="' . HTTPS_SERVER.reset_url('support/ISP-Networks.html') . '">Réseau de Transport Optique </a>
			</div>');
define('EMAIL_FOOTER_INFO', '
			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">Partager Votre Expérience d\'Utilisation <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="' . zen_href_link('index') . '">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="' . zen_href_link('contact_us') . '">Contactez-Nous</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="' . zen_href_link('account_newsletters') . '">Mon Compte</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="' . zen_href_link('shipping_delivery') . '">Expédition & Livraison</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="' . HTTPS_SERVER.reset_url('policies/day_return_policy.html') . '">Politique de Retour</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">Vous êtes abonné à cet email en tant que $user_email.</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="' . zen_href_link('account_newsletters') . '">Cliquez ici pour modifier vos préférences ou vous désabonner.</a>
			</div>');


/* 产品、分类公用 */
define('FS_CUSTOMILIZED_ADD_TO_CART','Ajouter au panier');
define('FS_ADD_TO_CART', 'Ajouter au panier');
define('FS_ADD_TO_CART1', 'Voir le Panier');
define('CATEGORIES_HEADING_DETAILS', 'Affichez les Détails');
define('FS_VIEW_CART', 'Voir le Panier');
define('FS_REVIEWS', 'Commentaires');
define('FS_REVIEWS_SMALL', 'Commentaires');
define('FS_REVIEW', 'Commentaire');
define('FS_SHARE', 'Partager');
define('FS_NEED_HELP1', 'Chat en Ligne');
define('FS_COMPATIBLE', 'Compatible');
define('FS_LENGTH', 'Longueur');
define('FS_TOTAL_LENGTH', 'Longueur Totale');
define('FS_CUSTOM_LENGTH', 'Longueur sur mesure');
define('FS_SHIPPING_COST', 'Frais d\'Expédition ');
define('FS_PRODUCT_NEED_HELP', 'Besoin d\'Aide ?');
//2017.11.24  ery  add  产品详情页属性名称
define('FS_CHOOSE_LENGTH', 'Choisissez la Longueur');
define('FS_LENGTH_NAME','Longueur');
define('FS_OPTION_NAME','Numéro d\'Appareil');

define('FS_OUT_OF_STOCK', 'En Rupture de Stock');
define('FS_DELETE_PRODUCT', 'Supprimer le Produit');
define('FS_AVAILABILTY', 'Disponibilité');

define('PRODUCT_INFO_ADD', 'Ajouter');
define('PRODUCT_INFO_ADDED', 'Ajouté');
define('FS_TRANSCEIVER_TYPE', 'Type de Module Optique :');

define('ACCOUNT_FOOTER_TITLE', 'ACHAT EN TOUTE CONFIANCE');

define('ACCOUNT_FOOTER_SHOPPING', 'ACHATS SUR FIBERSTORE.COM ');

define('ACCOUNT_FOOTER_SECURE', 'EN SURETÉ ET EN SECURITÉ.');

define('TEXT_LOGIN_GUARANTEED', 'GARANTI !');

define('ACCOUNT_FOOTER_PAY', 'Vous ne payez rien si un montant non-autorisé est débité de votre carte bancaire dans le cadre d\'un achat sur fiberstore.com.');

define('ACCOUNT_FOOTER_SAFE', 'ACHATS GARANTIS EN TOUTE SECURITÉ');

define('ACCOUNT_FOOTER_INFORMATION', 'Toutes les informations sont cryptées et transmises sans risque en utilisant le protocole SSL.');

define('ACCOUNT_FOOTER_HOW', 'Comment Nous Protégeons Vos Renseignements Personnels ?');

define('ACCOUNT_FOOTER_FREE', 'LIVRAISON GRATUITE ET RETOUR GRATUIT');

define('ACCOUNT_FOOTER_SHOP', 'Si vous n\'êtes pas satisfait de votre achat de FiberStore Co., Ltd, vous pouvez le retourner dans son état original dans les 7 jours pour un remboursement. Nous prenons en charge les frais de retour !');

define('ACCOUNT_FOOTER_DELIVER', 'Pour offrir un fonctionnement sans souci et d\'éliminer les coûts associés à des réparations hors garantie, FiberStore offre une garantie à vie comme une caractéristique standard pour les principales lignes de produits.');

define('ACCOUNT_FOOTER_LEARN', 'En Savoir Plus');

define('TEXT_FIBERSTORE_REGIST_RESPECTS', 'Fiberstore respecte votre vie privée. Nous ne vendrons ni ne prêterons vos renseignements personnels à personne.');

define('TEXT_FIBERSTORE_REGIST_PRIVACY', 'Politique de Confidentialité.');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false)
    {
        if ($reverse) {
            return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
        } else {
            return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
        }
    }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="en"');

// charset for web pages and emails
define('CHARSET', 'UTF-8');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'requêtes depuis');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME', 'Cadeau certifié');
define('TEXT_GV_NAMES', 'Cadeaux certifiés');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM', 'Code de Réduction');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
define('BOX_GV_REDEEM_INFO', 'Code de Réduction : ');

// text for gender
define('MALE', 'M.');
define('FEMALE', 'Mme.');
define('MALE_ADDRESS', 'M.');
define('FEMALE_ADDRESS', 'Mme.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'DD/MM/YYYY');

//text for sidebox heading links
define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[more]');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Catégories');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Fabricants');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Nouveaux Produits');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Nouveaux Produits ...');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Sélection');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Produits en vedette ...');
define('TEXT_NO_FEATURED_PRODUCTS', 'Plus de produits en vedette seront bientôt ajoutés. S\'il vous plaît revenez plus tard.');

define('TEXT_NO_ALL_PRODUCTS', 'Plus de produits seront ajoutés bientôt. S\'il vous plaît revenez plus tard.');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Tous les produits...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Rechercher');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Recherche Avancée');
define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'Entrez vos mots de recherche ici ...');
// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Spécials');
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Spécials ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Commentaires');
define('BOX_REVIEWS_WRITE_REVIEW', 'Donnez votre commentaire sur ce produit.');
define('BOX_REVIEWS_NO_REVIEWS', 'Il n\'y a aucun commentaire sur ce produit.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s de 5 Étoiles!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Panier');
define('FS_SAVED_ITEMS', 'Tous les projets de conservation');
define('BOX_SHOPPING_CART_EMPTY', 'Votre panier est vide.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Re-Commande rapide');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Meilleures ventes');
define('BOX_HEADING_BESTSELLERS_IN', 'Meilleures ventes dans<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Notifications');
define('BOX_NOTIFICATIONS_NOTIFY', 'Notifiez-moi des mises à jour de<strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Ne me notifier pas de mises à jour de <strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Infos Fabricants');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Page d\'Accueil');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Autres produits');

// languages box text in sideboxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Langages');

// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Devises');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_PRIVACY', 'Remarque de Confidentialité');
define('BOX_INFORMATION_CONDITIONS', 'Conditions d\'Utilisation');
define('BOX_INFORMATION_SHIPPING', 'Livraison &amp; Retour');
define('BOX_INFORMATION_CONTACT', 'Contactez-Nous');
define('BOX_BBINDEX', 'Forum');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Désabonnement du Bulletin');

define('BOX_INFORMATION_SITE_MAP', 'Plan du site');
define('BOX_INFORMATION_SITE_MAP_TITLE', 'Plan du Site de Fiberstore');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'Plus d\'Informations');
define('BOX_INFORMATION_PAGE_2', 'Page 2');
define('BOX_INFORMATION_PAGE_3', 'Page 3');
define('BOX_INFORMATION_PAGE_4', 'Page 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Dire à un ami');
define('BOX_TELL_A_FRIEND_TEXT', 'Parlez de ce produit à quelqu\'un que vous connaissez.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'Ma liste de voeux');
define('BOX_WISHLIST_EMPTY', 'Vous n\'avez pas d\'articles sur votre liste de voeux.');
define('IMAGE_BUTTON_ADD_WISHLIST', 'Ajoutez à la liste de voeux');
define('TEXT_WISHLIST_COUNT', 'Actuellement %s articles dans votre liste de voeux');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Exposez <strong>%d</strong> à <strong>%d</strong> (des <strong>%d</strong> articles sur votre liste de voeux)');

//New billing address text
define('SET_AS_PRIMARY', 'Définir comme adresse principale');
define('NEW_ADDRESS_TITLE', 'Adresse de Facturation ');

// javascript messages
define('JS_ERROR', 'Les erreurs se sont produites lors du traitement de votre formulaire.\n\n Veuillez apporter les corrections suivantes :\n\n');

define('JS_REVIEW_TEXT', '* S\'il vous plaît ajouter quelques mots à vos commentaires. Le commentaire doit avoir au moins ' . REVIEW_TEXT_MIN_LENGTH . ' caractères.');
define('JS_REVIEW_RATING', '* S\'il vous plaît choisir une note à cet article.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* S\'il vous plaît sélectionner un mode de paiement de votre commande.');

define('JS_ERROR_SUBMITTED', 'Ce formulaire a été soumis. S\'il vous plaît appuyez sur OK et attendez que ce processus soit achevé.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'S\'il vous plaît sélectionner un mode de paiement de votre commande.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'S\'il vous plaît confirmer les termes et conditions liés à cet ordre en cochant la case ci-dessous.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'S\'il vous plaît confirmer la déclaration de confidentialité en cochant la case ci-dessous.');

define('CATEGORY_COMPANY', 'Détails de l\'Entreprise');
define('CATEGORY_PERSONAL', 'Vos Informations Personnelles');
define('CATEGORY_ADDRESS', 'Votre Adresse');
define('CATEGORY_CONTACT', 'Vos Informations de Contact');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Votre Mot de Passe');
define('CATEGORY_LOGIN', 'S\'identifier');
define('PULL_DOWN_DEFAULT', 'S\'il vous plaît Choisissez votre pays');
define('PLEASE_SELECT', 'Veuillez sélectionner ...');
define('TYPE_BELOW', 'Tapez un choix ci-dessous ...');

define('ENTRY_COMPANY', 'Nom de l\'Entreprise :');
define('ENTRY_COMPANY_ERROR', 'S\'il vous plaît entrer un nom de l\'entreprise.');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Civilité :');
define('ENTRY_GENDER_ERROR', 'Veuillez renseigner votre civilité.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Prénom :');
define('ENTRY_FIRST_NAME_ERROR', 'Votre prénom est correct ? Notre système requiert un minimum de  ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caractères. Veuillez réessayer.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Nom :');
define('ENTRY_LAST_NAME_ERROR', 'Votre Nom est correct ? Notre système requiert un minimum de  ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caractères. Veuillez réessayer.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date d\'Anniversaire :');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Votre date de naissance est correcte ? Notre système nécessite la date dans ce format : DD/MM/YYYY (ex 20/05/1980)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (ex 20/05/1980)');
define('ENTRY_EMAIL_ADDRESS', 'Adresse E-mail :');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Votre adresse e-mail est correcte ? Il doit contenir au moins ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . 'caractères. Veuillez réessayer.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Désolé, notre système ne comprend pas votre adresse email. Veuillez réessayer.');
// define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este e-mail ya existe en nuestra base de datos - por favor, entre con otro e-mail o cree otra cuenta con una dirección de e-mail diferen.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Notre système a déjà un enregistrement de cette adresse e-mail - s\'il vous plaît essayez de vous connecter à cette adresse e-mail. Si vous n\'utilisez pas cette adresse il y a longtemps, vous pouvez la corriger dans la zone Mon Compte.');

define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', 'Pseudo sur le forum:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
define('ENTRY_NICK_DUPLICATE_ERROR', 'Ce pseudo est déjà utilisé. S\'il vous plaît essayer une autre.');
define('ENTRY_NICK_LENGTH_ERROR', 'Veuillez réessayer. Votre pseudo doit contenir au moins ' . ENTRY_NICK_MIN_LENGTH . ' caractères.');
define('ENTRY_STREET_ADDRESS', 'Adresse de la rue :');
define('ENTRY_STREET_ADDRESS_ERROR', 'Votre adresse de la rue doit contenir au moins ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caractères.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Adresse Ligne 2 :');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Code postal :');
define('ENTRY_POST_CODE_ERROR', 'Votre code postal doit contenir au moins ' . ENTRY_POSTCODE_MIN_LENGTH . ' caractères.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Ville :');
define('ENTRY_CUSTOMERS_REFERRAL', 'Code de référence :');

define('ENTRY_CITY_ERROR', 'Votre ville doit contenir au moins ' . ENTRY_CITY_MIN_LENGTH . 'caractères.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'État / Province:');
define('ENTRY_STATE_ERROR', 'Votre État / Province doit contenir au moins ' . ENTRY_STATE_MIN_LENGTH . 'caractères.');
define('ENTRY_STATE_ERROR_SELECT', 'S\'il vous plaît sélectionner un État des États dans le menu déroulant.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- SVP choisir --');
define('ENTRY_COUNTRY', 'Pays :');
define('ENTRY_COUNTRY_ERROR', 'Vous devez sélectionner le pays dans les pays dans le menu déroulant.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Téléphone :');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Votre numéro de téléphone doit contenir au moins ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caractères.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Numéro de fax :');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Abonnez-vous à notre bulletin.');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Abonné');
define('ENTRY_NEWSLETTER_NO', 'Désabonné');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Mot de passe :');
define('ENTRY_PASSWORD_ERROR', 'Votre mot de passe doit contenir au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'La confirmation de mot de passe doit correspondre à votre mot de passe.');
define('ENTRY_PASSWORD_TEXT', '* (au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Confirmer le mot de passe :');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Mot de passe actuel :');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Votre mot de passe doit contenir au moins' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.');
define('ENTRY_PASSWORD_NEW', 'Nouveau mot de passe :');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Votre nouveau mot de passe doit contenir au moins' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'La confirmation de mot de passe doit correspondre à votre nouveau mot de passe.');
define('PASSWORD_HIDDEN', '--CACHÉ--');

define('FORM_REQUIRED_INFORMATION', '* Information requise');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Total : <strong>%d</strong> Acticles &nbsp;&nbsp; <strong>%d</strong> / %d');

define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> produits)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> commandes)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> commentaires)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> nouveau produits)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> spécials)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> Produits en vedette)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Displaying <strong>%d</strong> to <strong>%d</strong> (de <strong>%d</strong> produits)');
define('TEXT_TOTAL_NUMBER_OF_REVIEWS', '(<strong>%d</strong>)');


define('PREVNEXT_TITLE_FIRST_PAGE', 'Première page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Page précédente');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Page suivante');
define('PREVNEXT_TITLE_LAST_PAGE', 'Dernière Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'page précédente %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'page suivante %d Pages');
define('PREVNEXT_BUTTON_FIRST', 'Premier');
define('PREVNEXT_BUTTON_PREV', 'Précédent');
define('PREVNEXT_BUTTON_NEXT', 'Suivant');
define('PREVNEXT_BUTTON_LAST', 'Dernier');

define('TEXT_BASE_PRICE', 'À partir de : ');

define('TEXT_CLICK_TO_ENLARGE', 'Agrandir l\'image');

define('TEXT_SORT_PRODUCTS', 'Trier les produits ');
define('TEXT_DESCENDINGLY', 'Décroissant');
define('TEXT_ASCENDINGLY', 'Croissant');
define('TEXT_BY', ' Par ');

define('TEXT_REVIEW_BY', 'par %s');
define('TEXT_REVIEW_WORD_COUNT', '%s mots');
define('TEXT_REVIEW_RATING', 'Évaluation : %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date ajoutée : %s');
define('TEXT_NO_REVIEWS', 'Il n\'y a aucun commentaire sur ce produit.');

define('TEXT_NO_NEW_PRODUCTS', 'Plus de nouveaux produits seront bientôt ajoutés. S\'il vous plaît revenez plus tard.');

define('TEXT_UNKNOWN_TAX_RATE', 'Taxe de vente');

define('TEXT_REQUIRED', '<span class="errorText">Champs obligatoires</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Attention : le répertoire d\'installation existe à: %s.  S\'il vous plaît supprimer ce répertoire pour des raisons de sécurité.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Attention : je suis capable d\'écrire dans le fichier de configuration : %s. Ceci est un risque potentiel pour la sécurité - s\'il vous plaît définir les bonnes permissions sur ce fichier (en lecture seule, CHMOD 644 ou 444).  Vous devrez peut-être utiliser votre panneau de contrôle d\'hébergeur / gestionnaire de fichiers pour changer les permissions efficacement. Contactez votre hébergeur pour obtenir de l\'aide.<a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">Voir cette FAQ</a>');
define('ERROR_FILE_NOT_REMOVEABLE', 'Erreur : Impossible de supprimer le fichier spécifié. Vous pourriez avoir à utiliser FTP pour supprimer le fichier, en raison d\'une configuration serveur-limitation des autorisations.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Attention : Le répertoire de session n\'existe pas : ' . zen_session_save_path() . '. Les sessions ne fonctionneront pas tant que ce répertoire est créé.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Attention : je ne suis pas en mesure d\'écrire dans le répertoire de session: ' . zen_session_save_path() . '. Les sessions ne fonctionneront pas jusqu\'à ce que les bonnes permissions sont définies.');
define('WARNING_SESSION_AUTO_START', 'Attention : session.auto_start est activé - s\'il vous plaît désactiver cette fonction PHP dans le fichier php.ini et redémarrez le serveur Web.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Attention : Le répertoire de téléchargement n\'existe pas : ' . DIR_FS_DOWNLOAD . '. Le téléchargement de produits ne fonctionnera qu\'avec un répertoire valide.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Attention : Le répertoire cache SQL n\'existe pas : ' . DIR_FS_SQL_CACHE . '. Le cache SQL ne fonctionnera pas tant que ce répertoire est créé.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Attention : je ne suis pas capable d\'écrire dans le répertoire de cache SQL : ' . DIR_FS_SQL_CACHE . '. Le cache SQL ne fonctionnera pas jusqu\'à ce que les bonnes permissions sont définies.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Votre base de données semble avoir besoin de rapiéçage à un niveau supérieur. Voir Admin-> Outils> Information Server pour examiner les niveaux de patch.');
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'AVERTISSEMENT : Impossible de localiser le fichier de langue : ');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'La date d\'expiration entrée pour la carte de crédit est invalide. S\'il vous plaît vérifier la date et essayez à nouveau.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Le numéro de carte de crédit entré est invalide. S\'il vous plaît vérifier le nombre et essayez à nouveau.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Le numéro de carte de crédit à partir de% s n\'a pas été entré correctement, ou nous n\'acceptons pas ce genre de carte. S\'il vous plaît essayer de nouveau ou utiliser une autre carte de crédit.');

define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Coupons de réduction');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Solde ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Compte');
define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
define('ERROR_REDEEMED_AMOUNT', 'Félicitations, vous avez racheté');
define('ERROR_NO_REDEEM_CODE', 'Vous n\'avez pas entré' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalide ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
define('TABLE_HEADING_CREDIT', 'Crédits disponibles');
define('GV_HAS_VOUCHERA', 'Vous avez des fonds dans votre ' . TEXT_GV_NAME . ' Compte. Si vous voulez <br />
                            vous pouvez envoyer ces fonds par <a class="pageResults" href="');

define('GV_HAS_VOUCHERB', '"><strong>e-mail</strong></a> à quelqu\'un');
define('ENTRY_AMOUNT_CHECK_ERROR', 'Vous ne disposez pas suffisamment de fonds pour envoyer ce montant.');
define('BOX_SEND_TO_FRIEND', 'Envoyer ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' Racheté');
define('CART_COUPON', 'Coupon :');
define('CART_COUPON_INFO', 'Plus d\'infos');
define('TEXT_SEND_OR_SPEND', 'Vous avez un solde disponible dans votre ' . TEXT_GV_NAME . ' Compte. Vous pouvez le dépenser ou l\'envoyer à quelqu\'un d\'autre. Pour envoyer, cliquez sur le bouton ci-dessous.');
define('TEXT_BALANCE_IS', 'Votre ' . TEXT_GV_NAME . 'solde est: ');
define('TEXT_AVAILABLE_BALANCE', 'Votre ' . TEXT_GV_NAME . ' Compte');

// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Chèque Cadeau / Coupon');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Crédits disponibles');

define('TEXT_INVALID_REDEEM_COUPON', 'Code de coupon invalide');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Vous devez passer au moins % s de racheter ce coupon');
define('TEXT_INVALID_STARTDATE_COUPON', 'Ce coupon n\'est pas encore disponible');
define('TEXT_INVALID_FINISHDATE_COUPON', 'Ce coupon a expiré');
define('TEXT_INVALID_USES_COUPON', 'Ce coupon ne peut pas être utilisé ');
define('TIMES', ' fois.');
define('TIME', ' fois.');
define('TEXT_INVALID_USES_USER_COUPON', 'Vous avez utilisé le code de coupon : le nombre maximum de % de fois autorisé par client. ');
define('REDEEMED_COUPON', 'Valeur de coupon ');
define('REDEEMED_MIN_ORDER', 'En savoir plus ');
define('REDEEMED_RESTRICTIONS', ' [Product-Category restrictions apply]');
define('TEXT_ERROR', 'Une erreur est survenue');
define('TEXT_INVALID_COUPON_PRODUCT', 'Ce coupon n\'est pas valable pour tout produit actuellement dans votre panier.');
define('TEXT_VALID_COUPON', 'Félicitations, vous avez racheté le Coupon de Réduction');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Le code de coupon n\'est pas valide pour l\'adresse que vous avez sélectionnée.');

// more info in place of buy now
define('MORE_INFO_TEXT', '... plus d\'infos');

// IP Address
define('TEXT_YOUR_IP_ADDRESS', 'Votre adresse IP est : ');

//Generic Address Heading
define('HEADING_ADDRESS_INFORMATION', 'Adresse de l\'information');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Quantité dans panier : ');
define('PRODUCTS_ORDER_QTY_TEXT', 'Ajouter au panier : ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Vous avez joint l\'article au panier...');
// only for where multiple add to cart is used:
define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Vous avez joint produit (s) sélectionné pour le panier...');

define('TEXT_PRODUCT_WEIGHT_UNIT', 'kg');

// Shipping
define('TEXT_SHIPPING_WEIGHT', 'kg');
define('TEXT_SHIPPING_BOXES', 'Boîtes');

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX_1', 'Sauvegarder &nbsp;');
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Sauvegarder :&nbsp;');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '% off');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', '&nbsp;off');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE', 'Vente :&nbsp;');

//universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX', 'Sponsors');
define('TEXT_BANNER_BOX', 'S\'il vous plaît Visitez nos Sponsors ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2', 'Avez-vous vu ...');
define('TEXT_BANNER_BOX2', 'Visiter le site aujourd\'hui!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL', 'Sponsors');
define('TEXT_BANNER_BOX_ALL', 'S\'il vous plaît Visitez nos Sponsors ...');

// boxes defines
define('PULL_DOWN_ALL', 'SVP choisir');
define('PULL_DOWN_MANUFACTURERS', '- Réinitialiser -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'SVP choisir');

// general Sort By
define('TEXT_INFO_SORT_BY', 'Trier par: ');

// close window image popups
define('TEXT_CLOSE_WINDOW', ' - Cliquez sur l\'image pour la fermer');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Close Window ]');

// iii 031104 added:  File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Erreur : Type de fichier non autorisé.');
define('WARNING_NO_FILE_UPLOADED', 'Attention : aucun fichier téléchargé.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Succès : fichier enregistré avec succès.');
define('ERROR_FILE_NOT_SAVED', 'Erreur : fichier non enregistré.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Erreur : destination pas accessible en écriture.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Erreur : destination n\'existe pas.');
\
    define('ERROR_FILE_TOO_BIG', 'Attention : fichier trop grand pour télécharger !<br />Commande peut être passée, mais s\'il vous plaît contacter le site de l\'aide pour le téléchargement');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'REMARQUE : Ce site est prévu pour être arrêté pour maintenance sur: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'REMARQUE : Ce site est actuellement en maintenance au public');

define('PRODUCTS_PRICE_IS_FREE_TEXT', 'C\'est gratuit!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Appel à Prix');
define('TEXT_CALL_FOR_PRICE', 'Appel à Prix');

define('TEXT_INVALID_SELECTION', ' Vous avez choisi une sélection non valide : ');
define('TEXT_ERROR_OPTION_FOR', ' Sur l\'option pour: ');
define('TEXT_INVALID_USER_INPUT', 'Entrée utilisateur requise<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Min : ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Unités : ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'Dans panier :');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Ajouter :');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Max :');

define('TEXT_PRODUCTS_MIX_OFF', '*Mixed OFF');
define('TEXT_PRODUCTS_MIX_ON', '*Mixed ON');

define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br />*Vous ne pouvez pas mélanger les options sur ce point pour répondre à l\'exigence de quantité minimale.*<br />');
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '*Options mixtes valeurs est ON<br />');

define('ERROR_MAXIMUM_QTY', 'La quantité ajouté à votre panier a été ajusté en raison d\'une restriction maximale que vous êtes autorisé. Voir cet article : ');
define('ERROR_CORRECTIONS_HEADING', 'S\'il vous plaît corriger les suivantes: <br />');
define('ERROR_QUANTITY_ADJUSTED', 'La quantité ajouté à votre panier a été ajusté. L\'article que vous vouliez ne sont pas disponibles en quantités fractionnaires. La quantité de l\'article : ');
define('ERROR_QUANTITY_CHANGED_FROM', ', a été modifié à partir de: ');
define('ERROR_QUANTITY_CHANGED_TO', ' à ');

// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'NOTE: Les téléchargements ne sont pas disponibles tant que le paiement a été confirmé');
define('TEXT_FILESIZE_BYTES', ' bytes');
define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
define('ERROR_PRODUCT', 'L\'article : ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br />Nous sommes désolés mais ce produit a été retiré de notre inventaire en ce moment.<br />L\'article a été retiré de votre panier.');
define('ERROR_PRODUCT_QUANTITY_MIN', ',  ... Erreurs de quantité minimale - ');
define('ERROR_PRODUCT_QUANTITY_UNITS', ' ... Erreurs de quantité d\'Unité - ');
define('ERROR_PRODUCT_OPTION_SELECTION', '<br /> ... Option non valide valeurs sélectionnées ');
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br /> Vous avez commandé un total de : ');
define('ERROR_PRODUCT_QUANTITY_MAX', ' ... Erreurs de quantité maximale - ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ', a une restriction de quantité minimum.');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', ' ... Erreurs de quantité d\'Unité- ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', ' ... Erreurs de quantité maximale - ');

define('WARNING_SHOPPING_CART_COMBINED', 'REMARQUE : Pour votre commodité, votre panier actuel a été combinée avec votre panier de votre dernière visite. S\'il vous plaît consulter votre panier avant de vérifier.');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
define('ERROR_CUSTOMERS_ID_INVALID', 'L\'information de client ne peut pas être validée !<br />S\'il vous plaît vous identifier ou de recréer votre compte ...');

define('TABLE_HEADING_FEATURED_PRODUCTS', 'Produits Vedettes');

define('TABLE_HEADING_NEW_PRODUCTS', 'Nouveau Produits Pour %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Prochains Produits');
define('TABLE_HEADING_DATE_EXPECTED', 'Date Prévue ');
define('TABLE_HEADING_SPECIALS_INDEX', 'Promotions Mensuelles Pour %s');

define('CAPTION_UPCOMING_PRODUCTS', 'Ces produits seront en stock bientôt');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS', 'Le tableau contient une liste de produits qui sont prévus en stock bientôt et les dates sont attendues');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'C\'est gratuit !');
//meta_tags  新模板 2016-9-26 frankie
//模块
define('MODEL_META_DES_01', 'en vente. Achetez les');
define('MODEL_META_DES_03', ' rentables chez FS.COM aujourd’hui ! Garantie à vie, conforme à RoHS, test assuré 100%. Les services OEM et ODM sont disponibles.');

//跳线
define('FIBER_META_DES_01', 'Grand choix de');
define('FIBER_META_DES_02', 'pour répondre à vos besoins. Test optique 100% avant d’expédier avec une garantie à vie.');

//其他
define('OTHER_META_DES_01', 'Livraison mondiale pour les');
define('MODEL_META_DES_02', 'Achetez les');
define('OTHER_META_DES_02', 'rentables chez FS.COM, bénéficiez d’un bon prix et d’un service de haute qualité.');


// customer login
define('TEXT_SHOWCASE_ONLY', 'Contactez-Nous');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Prix non disponible');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Connectez-vous pour le prix');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'Show Room Only');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Prix non disponible');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'EN ATTENTE D\'APPROBATION');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Connectez-vous à la boutique');

// text pricing
define('TEXT_CHARGES_WORD', 'Charge calculée :');
define('TEXT_PER_WORD', '<br />Prix par mot: ');
define('TEXT_WORDS_FREE', ' Mot (s) gratuit ');
define('TEXT_CHARGES_LETTERS', 'Redevance calculée :');
define('TEXT_PER_LETTER', '<br />Prix par lettre : ');
define('TEXT_LETTERS_FREE', ' Lettre (s) gratuit ');
define('TEXT_ONETIME_CHARGES', '*les frais ponctuels = ');
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*les frais ponctuels = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Rebais de quantité d\'option ');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'Quantité');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'PRIX');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Rebais de quantité d\'option charges non récurrentes');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', ' caractères maximum autorisés');
define('TEXT_REMAINING', 'restant');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Estimer les coûts de transport');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Veuillez <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Connecter</span></a>, pour afficher vos coûts personnels d\'expédition.');
define('CART_SHIPPING_METHOD_TEXT', 'Méthodes d\'Expédition Disponible ');
define('CART_SHIPPING_METHOD_RATES', 'Taux');
define('CART_SHIPPING_METHOD_TO', 'Envoyer à : ');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Envoyer à : <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Connecter</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Livraison gratuite');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Téléchargements');
define('CART_SHIPPING_METHOD_RECALCULATE', 'Recalculer');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'vrai');
define('CART_SHIPPING_METHOD_ADDRESS', 'Adresse :');
define('CART_OT', 'Estimation du coût total :');
define('CART_OT_SHOW', 'true'); // set to false if you don't want order totals
define('CART_ITEMS', 'Articles dans le panier : ');
define('CART_SELECT', 'Sélectionner');
define('ERROR_CART_UPDATE', '<strong>S\'il vous plaît mettre à jour votre commande.</strong> ');
define('IMAGE_BUTTON_UPDATE_CART', 'en préparation');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Oups ! Votre session a expiré ... S\'il vous plaît mettre à jour votre panier pour un devis d\'expédition ...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Les devis d\'expédition sont basés sur les informations d\'adresse que vous avez sélectionnée :');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter : ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter : ');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter : ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Ajouter : ');
//moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Prix remisé de quantité');
define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Nouveau prix remisé de quantité');
define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Prix remisé de quantité');
define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Les remisés peuvent varier en fonction des options ci-dessus');
define('TEXT_HEADER_DISCOUNTS_OFF', 'Remisé de quantité indisponible ...');

// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET', '- RÉINITIALISER - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Nom du produit');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Nom du produit - desc');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Prix : décroissant ');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Prix : croissant ');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Modèle');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Publication - Nouveau vers Ancien');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Publication - Ancien vers Nouveau');
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Affichage par défaut');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Lien Expire');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Restant');
define('HEADING_DOWNLOAD', 'Pour télécharger vos fichiers, cliquez sur le bouton de téléchargement et choisir "Enregistrer sur le disque" dans le menu contextuel.');
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Nom de fichier');
define('TABLE_HEADING_PRODUCT_NAME', 'Nom de l\'article');
define('TABLE_HEADING_BYTE_SIZE', 'Taille du fichier');
define('TEXT_DOWNLOADS_UNLIMITED', 'Illimité');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Quantité.');
define('TABLE_HEADING_PRODUCTS', 'Nom de l\'article');
define('TABLE_HEADING_TOTAL', 'Total');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Déclaration de confidentialité');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'S\'il vous plaît reconnaissez-vous d\'accord avec notre déclaration de confidentialité en cochant la case ci-dessous. La déclaration de confidentialité peut être lu <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">ici</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'Je l\'ai lu et accepté votre déclaration de confidentialité.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Détails de l\'adresse');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Détails de contact supplémentaires');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Vérifier votre âge');
define('TABLE_HEADING_LOGIN_DETAILS', 'Détails de connexion');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Étiez-vous a référé à nous ?');

define('ENTRY_EMAIL_PREFERENCE', 'Détails des lettres d\'information et de l\'email ');
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY', 'TEXT-Only');
define('EMAIL_SEND_FAILED', 'Erreur : Échec d\'envoyer un courriel à : "%s" <%s> avec sujet : "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Erreur - Impossible de se connecter à la base de données');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - On for Admin IP Only');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Articles commençant par ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- RÉINITIALISER --');

///////////////////////////////////////////////////////////
// include email extras
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

// END OF EXTERNAL LANGUAGE LINKS

define('FIBERSTORE_VIEW_MORE', 'Plus d\'articles dans le panier...');
define('FIBERSTORE_WISHLIST_ADD_TO_CART', 'Ajouter dans le panier');
define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS', 'Ajouter à la liste de voeux avec succès');
define('FIBERSTORE_DELETE', 'Supprimer');
define('FIBERSTORE_PRICE', 'PRIX');
define('FIBERSTORE_VIEW_MORE_ORDERS', 'Consulter toutes les commandes»');
define('FIBERSTORE_ORDER_IMAGE', 'Photo des Produits');
define('FIBERSTORE_POST', 'Poster');
define('FIBERSTORE_CANCEL_ORDER', 'Annuler la commande');
define('FIBERSTORE_PRODTCTS_DETAILS', 'Détails Produits');

define('FIBERSTORE_OEM_CUSTOM', 'OEM & PERSONNALISATION');
define('FIBERSTORE_ANY_TYPE', 'N\'importe quel type');
define('FIBERSTORE_ANY_LENGTH', 'N\'importe quelle Longueur');
define('FIBERSTORE_ANY_COLOR', 'N\'importe quelle couleur');
define('FIBERSTORE_WORK_PROJECT', 'Allons travailler avec vous sur votre projet personnalisé');

define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
define('TEXT_PREFIX', 'text_prefix_');
// LANGUAGE FOR COMMON FOOTER
define('FOOTER_TIT_FIR', 'Support Fiberstore');
define('FOOTER_FILENAME_SUPPORT', 'Voir tout »');
define('FOOTER_MTP_HREF', 'MTP/MPO Composants de raccordement');
define('FOOTER_MTP_CON', 'Les systèmes de fibres MTP/MPO sont vraiment un groupe de produits innovants comme le multi-fibres ...');
define('FOOTER_TIT_SEC', 'Commentaires des Clients');
define('FOOTER_CON_SEC', 'Nous avons plusieurs MUX, DWDM, XFP et SFP, ils fonctionnent très bien. Je sais que beaucoup d\'ISPS qui utilisent aussi très bien les équipements de Fiberstore.<i></i><b>-- Angryceo</b>');
define('FOOTER_TIT_TIR', 'Dernières Nouvelles');
define('FOOTER_PAGE_SEA', 'Pages populaires :');
define('FOOTER_SHARE_TIT', 'Bienvenue rejoindre notre communauté :');
define('FOOTER_RIGHT_CON', '<span>Comment pouvons-nous vous aider aujourd\'hui ? </span><br>
        <p>Le Support & Service Professionnel est disponible en trois différentes façons</p>');

  define('FOOTER_RIGHT_IMG','Chat en Ligne');
  define('FOOTER_ABOUT_FIR','<span>Infos d\'Entreprise</span><br>
        <a itemprop="url"  href='. HTTPS_SERVER.reset_url('company/about_us.html').'>A propos de Fiberstore</a><br>
        <a itemprop="url" rel="nofollow"  href='.  zen_href_link(FILENAME_WHY_US).'>Pourquoi Nous</a><br>

        <!--
        <a itemprop="url"  href=' . zen_href_link(FILENAME_PRIVACY_POLICY) . '>Politique de Confidentialité</a><br>
        -->
        <a itemprop="url" href=' . zen_href_link(FILENAME_SITE_MAP) . '>Plan du Site</a><br>
        <a itemprop="url" target="_blank"  href="http://www.fs.com/news.html">Dernières Nouvelles</a><br>
        <a itemprop="url" href="http://www.fs.com/blog/">Blog de Fiberstore</a>');
define('FOOTER_ABOUT_SEC', '<span>Service Clients</span><br>

        <a itemprop="url" rel="nofollow"  href=' . zen_href_link(FILENAME_OEM) . '>OEM & Personnalisation</a><br>
        <a itemprop="url" rel="nofollow"  href=' . zen_href_link(FILENAME_RMA_SOLUTION) . '>Solution RMA</a><br>
		<a itemprop="url" rel="nofollow"  href=' . zen_href_link(FILENAME_DAY_RETURN_POLICY) . '>Politique de Retour</a><br>
		<a itemprop="url" rel="nofollow"  href=' . zen_href_link(FILENAME_WARRANTY) . '>Garantie</a><br>
		<a itemprop="url"  rel="nofollow" href=' . zen_href_link(FILENAME_ISO_STANDARD) . '>Norme ISO</a><br>');
define('FOOTER_ABOUT_TIR', '<span>Paiement & Livraison</span><br>
        <a itemprop="url" rel="nofollow"  href=' . zen_href_link(FILENAME_PAYMENT_METHODS) . '>Moyens de Paiement</a><br>
        <a itemprop="url" rel="nofollow"  href=' . zen_href_link("net_30") . '>Net 30 & W9</a><br>
        <a itemprop="url"  rel="nofollow" href=' . zen_href_link(FILENAME_GLOBAL_SHIPPING) . '>Guide de Livraison</a><br>
        <a itemprop="url" rel="nofollow"  href=' . zen_href_link(FILENAME_ESTIMATED_TIME) . '>Livraison & Expédition</a><br>
      </div>
      <div class="footer_04"> <span>Aide Rapide</span><br>
        <a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_CONTACT_US).'>Contactez-Nous</a><br>
        <a itemprop="url"  rel="nofollow" href='.zen_href_link(FILENAME_HOW_TO_BUY).'>Aide à l\'Achat</a><br>');
  define('FOOTER_ABOUT_TIR1','<a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_PASSWORD_FORGOTTEN).'>Mot de Passe Oublié ?</a><br>') ;
  define('FOOTER_ABOUT_TIR2',' <a itemprop="url" rel="nofollow"  href='.zen_href_link(FILENAME_CHANGE_PASSWORD).'>Mot de Passe Oublié ?</a><br>');
  define('FOOTER_ABOUT_TIR3','<a itemprop="url"  rel="nofollow" href='.reset_url('service/fs_support.html').'>Chat en Ligne</a><br>
        <a itemprop="url"  href='.zen_href_link(FILENAME_FAQ).'>FAQ</a><br>');
  define('FOOTER_ABOUT_TIR4','Tous Droits Réservés.');
  define('FOOTER_ABOUT_TIR5','Politique de Confidentialité');
  define('FOOTER_ABOUT_TIR6','Conditions d’Utilisation');
  //FOOTER END
  
  
  //LIVE_CHAT
define('LIVE_CHAT_TIT','Recevez Tout Soutien de l\'Achat');
define('LIVE_CHAT_TIT1','Le Service & Support Professionel est disponible en trois différentes façons');
define('LIVE_CHAT_TIT2','Postez votre message à Fiberstore avec succès, Merci !');
define('LIVE_CHAT_CON1','Dialoguez en direct avec Fiberstore');
define('LIVE_CHAT_CON2','Contactez-nous et obtenez des informations connexes immédiatement.');
define('LIVE_CHAT_CON3','8 am. à Minuit, heure normale du Pacifique, Lun-Ven.');
define('LIVE_CHAT_CON4','S\'il vous plaît laissez-nous un message, nous vous répondrons dès que possible.');
define('LIVE_CHAT_CON5','Laissez un Message');
define('LIVE_CHAT_CON6','E-mail à Fiberstore');
define('LIVE_CHAT_CON7','Réponse dans les 12 heures');
define('LIVE_CHAT_CON8','Envoyez une demande de renseignements et obtenez une réponse rapide de Fiberstore.');
define('LIVE_CHAT_CON9','E-mail');
define('LIVE_CHAT_CON10','Disponible');
define('LIVE_CHAT_CON11','Indisponible');
define('LIVE_CHAT_CON12','Appelez');
define('LIVE_HEAD_CON1','Ou cliquez sur le bouton ci-dessous pour qu\'on vous appelle.<br /> 8 am.- 5 pm. CET. Lun-Ven.');
define('LIVE_HEAD_CON2','Ou cliquez sur le bouton ci-dessous pour qu\'on vous appelle.<br /> 8 am.- 5 pm. EST. Lun-Ven.');
define('LIVE_HEAD_CON3','Ou cliquez sur le bouton ci-dessous pour qu\'on vous appelle.<br /> 8 am.- 5 pm. BST. Lun-Ven.');
define('LIVE_HEAD_CON4','Ou cliquez sur le bouton ci-dessous pour qu\'on vous appelle.<br /> 8 am.- 5 pm. PST. Lun-Ven.');
define('LIVE_BUTTON_HTML','Chat en Ligne');

define('LIVE_CHAT_MAIL','Obtenir un Devis Rapide');
define('LIVE_CHAT_MAIL1','Afin de vous répondre rapidement, s\'il vous plaît remplir et soumettre les informations suivantes afin que votre question / problème peut être résolu par le service approprié.');
define('LIVE_CHAT_MAIL2','S\'il vous plaît remplir les champs demandés ci-dessous et notre équipe de ventes professionnelle vous contacteras rapidement dans les 12 prochaines heures.');
define('LIVE_CHAT_MAIL3','Entrez Votre Nom :');
define('LIVE_CHAT_MAIL4','Votre Address E-mail :');
define('LIVE_CHAT_MAIL5','Votre Pays :');
define('LIVE_CHAT_MAIL6','A propos de :');
define('LIVE_CHAT_MAIL7','Numéro de Téléphone :');
define('LIVE_CHAT_MAIL8','Sujet du Message :');
define('LIVE_CHAT_MAIL9','Commentaires / Questions :');
define('LIVE_CHAT_MAIL10','Veuillez choisir une réponse');
define('LIVE_CHAT_MAIL11','Commandes');
define('LIVE_CHAT_MAIL12','Prix de Gros');
define('LIVE_CHAT_MAIL13','Paiement');
define('LIVE_CHAT_MAIL14','Délai');
define('LIVE_CHAT_MAIL15','Garantie');
define('LIVE_CHAT_MAIL16','Service Après-Vente');
define('LIVE_CHAT_MAIL17','Solution Technologique');
define('LIVE_CHAT_MAIL18','Information des Produits');
define('LIVE_CHAT_MAIL19','Informations Générales');

define('LIVE_CHAT_PHONE','Fiberstore vous rappelle');
define('LIVE_CHAT_PHONE1','S\'il vous plaît appelez + 1-425-226-2035 ou laisser vos coordonnées ci-dessous, et nous vous rappellerons pendant 8 h am. et 5 h pm., heure PST, du lundi au vendredi.');
define('LIVE_CHAT_PHONE3','Entrez Votre Nom :');
define('LIVE_CHAT_BACK','Retour');
define('LIVE_CHAT_PHONE5','Votre Address E-mail :');
define('LIVE_CHAT_PHONE7','Nom de Votre Société:');
define('LIVE_CHAT_PHONE8','Your Country:');
define('LIVE_CHAT_PHONE10','Votre Pays :');
define('LIVE_CHAT_PHONE13','Meilleur Moment pour Vous Rappeler :');
define('LIVE_CHAT_SUBMIT','Soumettre');

  //LIVE_CHAT END
  //HEADER LIVE
  define('HEADER_LIVE_TIT','Chat en Ligne');
 
  

  define('HEADER_LIVE_FOUR','Service Après-Vente');
  define('HEADER_LIVE_FIVE','Si vous avez effectué un achat, s\'il vous plaît aller à ');
  define('HEADER_LIVE_SIX','la page de Mes commandes');
  define('HEADER_LIVE_SEV',' à demander de l\'Aide en Ligne pour des détails de la commande.');
  //HEADER END
  //LEFT_CONTACT_US
  define('LEFT_SLIDE_TIT1','Infos d\'Entreprise');
  define('LEFT_SLIDE_TIT2','Service à la Clientèle ');
  define('LEFT_SLIDE_TIT3','Paiement & Livraison');
  define('LEFT_SLIDE_TIT4','Aide Rapide');
  define('LEFT_SLIDE_CON1','Contactez-Nous');
  define('LEFT_SLIDE_CON2','A propos de Fiberstore');
  define('LEFT_SLIDE_CON3','Pourquoi Nous');
  define('LEFT_SLIDE_CON4','Actualités');
  define('LEFT_SLIDE_CON5','Compte d\'Affaires');

  define('LEFT_SLIDE_CON7','OEM & PERSONNALISATION');
  define('LEFT_SLIDE_CON8','Contrôle Qualité');
  define('LEFT_SLIDE_CON9','Norme ISO');
  define('LEFT_SLIDE_CON10','Garantie');
  define('LEFT_SLIDE_CON11','Solution RMA');
  define('LEFT_SLIDE_CON12','Politique de Retour');
  define('LEFT_SLIDE_CON13','Garantie de Remboursement');
  define('LEFT_SLIDE_CON14','Moyens de Paiement');
  define('LEFT_SLIDE_CON15','Net 30 & W9');
  define('LEFT_SLIDE_CON16','Guide d\'Expédition');
  define('LEFT_SLIDE_CON17','Livraison & Expédition');
  define('LEFT_SLIDE_CON18','Aide à l\'Achat');
  define('LEFT_SLIDE_CON19','FAQ');
  //END

  //TPL INDEX
  define('FIBERSTORE_SHOPPING_HELP','Votre panier est vide.');
  define('FIBERSTORE_INDEX_HELP','<dd><b>Comment nous pouvons vous<br />aider aujourd\'hui?</b><i>Chat en Ligne</i></dd>');
  define('FIBERSTORE_INDEX_SIDER','<p class="sidebar_03_02 "><b>Programme Partenaire</b>Développer Vos Affaires</p>');
  define('FIBERSTORE_INDEX_SIDER1','<p class="sidebar_03_02 "><b>Livraison Mondiale</b>2 à 3 Jours Ouvrables de Livraison dans le Monde</p>');
  define('FIBERSTORE_INDEX_SIDER2','<p class="sidebar_03_02"><b>Norme ISO</b>Concentré sur la Qualité et la Précision</p>');
  define('FIBERSTORE_INDEX_SIDER3','<p class="sidebar_03_02"><b>Modes de Paiement</b>Paiement Sécurisé</p>');
  define('FIBERSTORE_INDEX_SIDER4','<p class="sidebar_03_02"><b>Garantie à Vie</b>Utilisation Normale</p>');
  define('FIBERSTORE_INDEX_OEM','<span class="oem_02">OEM &amp; PERSONNALISATION</span> <span class="oem_03 "><ul><li>Tout produit</li><li>Toute taille</li><li>Tout type</li><li>Toute couleur</li></ul></span> <span class="oem_03 oem_04">Qualité Excellente & Service pour satisfaire toutes vos exigences</span>');

  //INDEX END
  //2016-5-19新增购物车结账页面
define('F_EDIT','Modifier');
define('F_PROCEED_TO_PAYPAL','Procéder à Paypal');
define('F_CONFIRM_TO_PAYMENT','Confirmer le Paiement');
define('F_SUBMIT_ORDER','Soumettre la Commande');
define('F_SHIP_SAME_DAY','expédiée le jour même');
define('F_SHIP_NEXT_DAY','expédié le lendemain');
define('F_SHIP_TIME','Date Estimée : ');
define('F_WENHAO','Il peut y avoir une différence entre le temps estimé et le temps réel');
define('F_CHAT_NOW','Chat en Ligne');
define('F_PLEASE_SELECT','Veuillez Sélectionner');
define('F_PLEASE_ENTER_FIRST_NAME','Veuillez entrer votre Prénom');
define('F_PLEASE_ENTER_LAST_NAME','Veuillez entrer votre Nom');
define('F_PLEASE_ENTER_STREET_ADDRESS','Veuillez entrer votre Adresse Postale');
define('F_PLEASE_ENTER_CITY',' Veuillez entrer votre Ville');
define('F_PLEASE_ENTER_POSTAL_CODE',' Veuillez entrer votre Code Postal');
define('F_PLEASE_ENTER_COUNTRY',' Veuillez entrer votre Pays');
define('F_PLEASE_ENTER_STATE','Veuillez entrer votre Région / Département / Arrondissement');
define('F_PLEASE_ENTER_TELEPHONE_NUMBER','Veuillez entrer votre Numéro de Téléphone');
define('FIBERSTORE_SHOP_CART_BUTTON1','Achat avec Confidence</b>
      <dt>L’achat sur FS.COM est en Sûreté et en Sécurité. Garanti !<br />Vous ne payez rien si un montant non-autorisé est débité de votre carte bancaire à la suite d’achats chez FS.COM.</dt>
      <div class="ccc"></div>
       <b>Livraison Gratuite et Retour Gratuit</b>
      <dt>Pour offrir un fonctionnement sans souci et d\'éliminer les coûts associés à des réparations hors garantie, FS.COM offre une garantie à vie comme un standard pour les principales lignes de produits.');
define('FIBERSTORE_SHOP_CART_BUTTON2', 'La notation de FS.COM est BBB</b><dt><i class="login_018"></i>
La qualité et la norme sont les bases de FS.COM. Depuis le jour de la fondation, notre objectif est toujours de fournir le meilleur service et les produits de haute qualité à nos clients.
 </dt></li>
      <li><b>Achat Garanti en Toute Securité</b>
      <dd><i class="login_016" style=" height:68px; margin-bottom:5px;"></i>Toutes les informations sont cryptées et transmises sans risque en utilisant le protocole SSL.');

//支付页面
define('F_USE_CREDIT', 'Votre paiement a été refusé. S\'il vous plaît utiliser une autre carte de crédit ou modifier le mode de paiement à PayPal ou Virement Bancaire sur une commande ouverte.');
define('F_MAKE_SURE', ' S\'il vous plaît vérifier que l\'adresse de facturation que vous avez entrée ci-dessous correspond au nom et l\'adresse associée à la carte de crédit que vous utilisez pour cet achat. S\'il vous plaît noter que le pays de votre adresse de facturation et celui de votre adresse de livraison doit être le même');
define('F_COUNTRY', 'Pays/Région');
define('F_ZIP', 'ZIP');
define('F_ORDER_SUMMARY', 'Récapitulatif de la Commande');
define('F_ORDER_NUMBER', 'Numéro de Commande ');
define('F_TOTAL_AMOUNT', 'Montant Total ');
define('F_CREDIT', 'Crédit');
define('F_DEBIT', 'Paiement par Carte de Débit');
define('F_ACCEPT', 'Nous acceptons les cartes de débit et de crédit suivantes');
define('F_SELECT_CARD_TYPE', 'S\'il vous plaît sélectionnez un type de carte, complétez les informations ci-dessous et cliquez sur Continuer');
define('F_NOTE', 'Remarque : Pour des raisons de sécurité, nous ne conservons aucune de vos données de carte de crédit');
define('F_SELECT_SELECT_CREDIT', ' Sélectionnez une carte de crédit');
define('F_CREDIT_OR_DEBIT', 'Centre de paiement de Carte de Crédit/Débit');
define('F_SELECT_CREDIT', ' Sélectionnez une ');
define('F_DEBIT_CARD', 'carte de Crédit/Débit ');
define('F_CARD_NUMBER', 'Numéro de Carte');
define('F_EXPIRATION_DATE', 'Date d’Expiration');
define('F_MONTH', 'Mois');
define('F_YEAR', 'Année');
define('F_SECURITY_CODE', 'Code de Sécurité');
define('F_LOADING', 'chargement');
define('F_CONTINUE', 'Continuer');
define('F_SWITCH', "Passer à d'autres moyens de paiement");
define('FIBERSTORE_CART', 'Panier');
define('FIBERSTORE_CHECKOUT', 'Caisse');
define('FIBERSTORE_SUCCESS', 'Succès');
define('FS_TAG_COPYRIGHT', 'Copyright  ');
define('FS_ALL_RIGHTS_RESERVED', 'FS.COM Tous Droits Réservés');


//checkout_globalcollect_billing
define('FIBERSTORE_FIRST_NAME', 'Prénom :');

define('FIBERSTORE_LAST_NAME', 'Nom de Famille :');

define('FIBERSTORE_ADDRESS', 'Adresse :');

define('F_COUNTRY', 'Pays de Destination :');

define('FIBERSTORE_CITY', 'Ville :');

define('FIBERSTORE_ADDRESS_EXAMPLE', 'Exemple: appartement, bureau, unité, bâtiment, étage');

define('FIBERSTORE_ADDRESS_COUNTRY', 'Pays de Destination :');

define('FIBERSTORE_ADDRESS_PLEASE', 'Sélectionnez ---');

define('FIBERSTORE_STATE', 'Etat');
define('FIBERSTORE_PROVINCE', 'Province ');
define('FIBERSTORE_REGION', 'Région :');

define('FIBERSTORE_ADDRESS_ZIP', 'NPA');
define('FIBERSTORE_POSTAL_CODE', 'Code Postal :');

define('FIBERSTORE_TELEPHONE_NUMBER', 'Numéro de Téléphone :');

define('FIBERSTORE_BILLING_ADDRESS', 'Adresse de Facturation :');


//列表页
define('FIBERSTORE_SHOW_RESULTS', '<b>Montrer les Résultats par</b>');
define('FIBERSTORE_SHOW_BRANDS', 'Montrer Plus de Marques');
define('FIBERSOTER_SHOW_MORE_BRANDS', ' Montrer Plus de Marques');
define('FIBERSOTER_COMPATIBLE_BRANDS', 'Marques Compatibles');
define('FIBERSOTER_SHOW_LESS_BRANDS', 'Montrer Moins de Marques');
define('FIBERSTORE_QUICKFINDER', 'Recherche Rapide');
define('FIBERSTORE_PAGE', 'page');
define('FIBERSTORE_REVIEWS_ALL', 'commentaires');
define('FIBERSTORE_P_LOW_TO_HIGH', 'Prix : Faible à Élevé');
define('FIBERSTORE_P_HIGH_TO_LOW', 'Prix : Élevé à Faible');
define('FIBERSTORE_R_HIGH_TO_LOW', 'Vitesse : Élevée à Faible');
define('FIBERSTORE_NEWEST_F', 'Plus Récent en Premier');
define('FIBERSTORE_POPU', 'Popularité');
define('LET_US_HELP_YOU', 'Laissez-nous vous aider');
define('CHAT_WITH_US_NOW', 'Chattez avec nous maintenant');
define('CATR_TOTAL', 'Total du Panier');
define('THE_MQQ', 'MOQ - La MOQ (Quantité Minimum de Commande) de ce câble est 1 km. S\'il vous plaît augmentez la longueur totale puis vérifiez à nouveau. Si vous avez des questions, n\'hésitez pas à nous contacter à Sales@fs.com.');
define('FIBERSTORE_VIEW_CART', 'Voir le Panier');


//写产品评论页面
define('FIBERSTORE_REQUIRED_QUESTION', 'Question Requise');
define('FIBERSTORE_EXAMPLE', 'Titre de commentaire *');
define('FIBERSTORE_REVIEWS_ATTACH', 'Attachez une Image +');
define('FIBERSTORE_REVIEWS_SUBMIT_REVIEW', 'Soumettre le Commentaire');

//推广文章页面


//客户中心页面


define('FIBERSTORE_SALES_MESSAGES', '1. Vous ne pouvez demander le service après-vente que si votre commande est accomplie. S\'il vous plaît cliquez la « Confirmation de Réception » dans votre page de détails de la commande pour terminer la commande.<br>
 S\'il vous plaît demandez le service après-vente dans votre page de détails d\'ordre fini.');

//2016-5-23新增一级分类
define('FIBERSTORE_TRANS1', 'Rechercher par Appareil Réseau');
define('FIBERSTORE_TRANS2', 'Rechercher par Module Original');
define('FIBERSTORE_TRANS3', 'Câbles Patch à Fibre Optique</h1>
      </div>
      <div class="title_small">FS.COM offre des assemblages de câbles à fibre optique de haute qualité tels que Câbles Patch, Pigtails, MCPs, Câbles Breakout, etc. Tous nos câbles à fibre optique peuvent être commandés en fibre Monomode 9/125, Multimode 62.5/125 OM1, Multimode 50/125 OM2 et Multimode 10 Gig 50/125 OM3/OM4.</div>
      
      <div class="sidebar_find">
          <span>Câbles à Fibre Optique Populaires');
define('FIBERSTORE_TRANS4', 'Acheter par Connecteurs');
define('FIBERSTORE_TRANS5', 'Tous Assemblages de Câbles à Fibre Optique');
define('FIBERSTORE_TRANS6', 'Acheter Par Catégories');

//2016-6-16 订单确认页面,货到付款弹窗  （checkout）
define('FS_CHECKOUT_FREIGHT', 'Fret Payable ');
define('FS_CHECKOUT_SHIPPING_METHOD', 'Méthode d\'Expédition :');
define('FS_CHECKOUT_EXPRESS_ACCOUNT', 'Compte Express :');
define('FS_CHECKOUT_ORDER_REMARKS', 'Remarques de Commande');
define('FS_CHECKOUT_ORDER_ADVISE', 'Veuillez indiquer le modèle de votre équipement pour assurer la compatibilité.');
define('FS_CHECKOUT_REMARKS', 'Pour toutes les attentes supplémentaires sur l\'expédition de la commande, l\'emballage ou d\'autres informations, s\'il vous plaît les précisez dans le champ Remarques, il sera utile pour le traitement des commandes. Merci !');
//支付页面

//tpl_header.php   melo


//光模块  2016-7-30 frankie
define('SHORT_DES', 'Câbles Patch à Fibre Optique');
define('SHORT_TEXT', 'FS.COM offre les assemblages de câble à fibre optique de haute qualité tels que Câbles de Patch, MCPs, Câbles Breakout, etc. Tous nos câbles à fibre optique se divisent en Monomode 9 /125, Multimode 62,5 / 125 OM1,Multimode 50 / 125 OM2 et Multimode 50 / 125 OM3 / OM4 10G');

//tpl_index_categories.php   ery
define('FS_INDEX_CATEGORIES1', 'Chercher par Appareil Réseau');
define('FS_INDEX_CATEGORIES2', 'Chercher par Modèle Original');

//tpl_fiber_categories_default.php    ery
define('FS_FIBER_CATE1', 'Extrémités de Connecteurs');
define('FS_FIBER_CATE2', 'vers');
define('FS_FIBER_CATE3', 'Mode de Fibre Optique');
define('FS_FIBER_CATE4', 'Longueur (m)');
define('FS_FIBER_CATE5', '[Options Avancées]');
define('FS_FIBER_CATE6', 'Nombre de Fibre Optique :');
define('FS_FIBER_CATE7', 'Gaine de Câble :');
define('FS_FIBER_CATE8', 'Application :');
define('FS_FIBER_CATE9', 'Type de Polissage :');
define('FS_FIBER_CATE10', 'Diamètre de Câble :');
define('FS_FIBER_CATE11', 'Effacer les Sélections');
define('FS_FIBER_CATE12', 'Conforme aux normes IEEE 802.3z pour les applications Fast Ethernet et Gigabit Ethernet');
define('FS_FIBER_CATE13', 'Votre Prix :');
define('FS_FIBER_CATE14', 'Quantité :');
define('FS_FIBER_CATE15', 'Achetez');
define('FS_FIBER_CATE16', 'Suivant');
define('FS_FIBER_CATE17', 'Précédent');
define('FS_FIBER_CATE18', 'expédié le jour même');
define('FS_FIBER_CATE19', 'Estimated the next day');
define('FS_FIBER_CATE20', 'Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.<br/>There may be some difference between the estimated time and the actual time.');
define('FS_FIBER_CATE21', 'There may be some difference between the estimated time and the actual time.');

//ery
define('MODULE_PAYMENT_HSBC_TEXT_TITLE', 'hsbc order');

//2016-8-15 by buck
define('FS_GET_QUOTE1', 'Obtenir un Devis Rapide');
define('FS_GET_QUOTE2', 'Afin de nous aider à vous offrir un service rapide et efficace, veuillez compléter et puis soumettre les informations suivantes pour que votre question / problème s\'adresse au service approprié.');
define('FS_GET_QUOTE3', 'Veuillez remplir les champs demandés ci-dessous. Notre service de ventes professionnel vous prendra en contact dans les 12 heures.');
define('FS_GET_QUOTE4', 'Entrer Votre Nom :');
define('FS_GET_QUOTE5', 'Votre Adresse E-mail :');
define('FS_GET_QUOTE6', 'Votre Pays :');
define('FS_GET_QUOTE7', 'Concernant :');

define('FS_REGARDING1', 'Veuillez choisir');
define('FS_REGARDING2', 'Commande');
define('FS_REGARDING3', 'Prix de Gros');
define('FS_REGARDING4', 'Paiement');
define('FS_REGARDING5', 'Délai de Livraison');
define('FS_REGARDING6', 'Garantie');
define('FS_REGARDING7', 'Après-Vente');
define('FS_REGARDING8', 'Solution Technologique');
define('FS_REGARDING9', 'Information des Produits');
define('FS_REGARDING10', 'Information Générale');

define('FS_GET_QUOTE8', 'Numéro de Téléphone :');
define('FS_GET_QUOTE9', 'Objet du Message :');
define('FS_GET_QUOTE10', 'Soumettre');
define('FS_GET_QUOTE20', 'Commentaires / Questions :');

define('FS_GET_QUOTE11', 'Assurez-vous d\'avoir entré votre nom.');
define('FS_GET_QUOTE12', 'L\'adresse e-mail que vous avez soumise n\'est pas reconnue. (exemple : prénom@exemple.com).');
define('FS_GET_QUOTE13', 'Veuillez renseigner un numéro de téléphone valable.');
define('FS_GET_QUOTE14', 'Veuillez entrer une question.');
define('FS_GET_QUOTE15', 'Affichage de votre message sur Fiberstore avec succès. Merci !');
define('FS_GET_QUOTE16', 'Désolé, mais vous êtes ajouté(e) dans la liste noire !');

define('FS_GET_QUOTE17', 'Assurez-vous d\'avoir choisi votre pays.');
define('FS_GET_QUOTE18', 'Votre numéro de téléphone devrait comprendre au moins 7 chiffres.');
define('FS_GET_QUOTE19', 'En Traitement');

//Content  in  manage_order 
// 2016-9-7 add by  frankie 
define('ALL_ORDER', 'Toutes les commandes');
define('UNPAID_ORDER', 'Commandes en attente');
define('TRADING_ORDERS', 'Commandes de Transaction');
define('CLOSED_ORDERS', 'Commandes annulées');

define('FIBERSTORE_QUESTION', 'Questions soumises avec succès');
define('FIBERSTORE_ORDER_PRIVATE', 'Commandes Privées');
define('FIBERSTORE_ORDER_COMPANY', 'Toutes les commandes de l\'entreprise');
define('FIBERSTORE_ORDER_SELECT', 'Sélectionnez par Date de commande');
define('PLEASE', 'Sélectionnez');
define('WEEK', 'Semaine Dernière');
define('MONTH', 'Mois Dernier');
define('THREE_MONTH', 'Trois Derniers Mois');
define('FIBERSTORE_ORDER_ENTER', 'Saisissez votre numéro de commande');
define('FIBERSTORE_ORDER_NO', 'Numéro de commande');
define('SEARCH', 'Cherchez');
define('FIBERSTORE_ORDER_PROMT', 'AUCUNE COMMANDE TROUVÉE.');
define('FIBERSTORE_ORDER_PROMT2', 'Vous n\'avez pas encore passé de commande.');
define('FIBERSTORE_ORDER_PICTURE', 'Image des produits');
define('FIBERSTORE_ORDER_DATE', 'Date de commande');
define('CANCELED', 'Annulée');
define('FIBERSTORE_ORDER_OPERATE', 'Opérer');
define('FIBERSTORE_VIEW_DETAILS', 'Voir les détails');
define('PREVIOUS', 'Précédent');
define('NEXT', 'Suivant');
define('PAYMENT', 'Paiement');
define('FIBERSTORE_ORDER_PAGE', 'Page');
define('FIBERSTORE_ORDER_OF', '/');
define('FS_LEARN_MORE', 'En Savoir Plus');
define('CONNECTING_PAYPAL', 'Connexion à PayPal');
define('ACCOUNT_CANCEL_ORDER', 'Annuler cette commande ?');
define('ACCOUNT_BE_RECOVERED', 'Une fois annulée, la commande ne peut pas être récupérée.');
define('ACCOUNT_OFFLINE', 'Commande hors ligne');
define('ACCOUNT_CONFIRM', 'Confirmer');
define('FIBERSTORE_ORDER_CONFIRM', 'Confirmer');
define('ACCOUNT_OTHERS', 'D\'autres');
define('ACCOUNT_TIP', 'Avant d\'envoyer, veuillez remplir les raisons de l\'annulation de commande');
define('ACCOUNT_CANCEL', 'Annuler');
define('FS_CANCEL', 'Annuler');

//fallwind	2016.9.9	add
define('FIBERSTORE_LIVE_CHAT', 'Laissez un Message');
define('FIBERSTORE_EDIT_CART', 'Modifier le Panier');
define('FIBERSTORE_PROCESSING', 'En Traitement');
define('FIBERSTORE_ALL_RIGHTS_RESERVED', 'Tous Droits Réservés');
//分类 搜索公用常量 公用常量，不要随意删除
define('FIBERSTORE_IMAGES','Images');
define('FIBERSTORE_DETAILS','Détails');
define('FIBERSTORE_SHOWING','Montrer');
define('FS_CUSTOM','Personnalisation');
define('FIBERSTORE_OF','');
define("FIBERSTORE_PRODUCTS","produits");
define("FIBERSTORE_PRODUCT","produit");
define("FIBERSTORE_RESULTS_BY01","Trier par :");
define("FIBERSTORE_RESULTS_VIEW","Afficher :");
define('FIBERSTORE_RESULTS_BY',' les Résultats par');
define('FIBERSTORE_YOUR_PRICE','Votre Prix');
define('FIBERSTORE_QUANTITY','Quantité');
define('FIBERSTORE_ADD_TO_CART','Ajoutez au Panier');
define('FS_SHIP_SAME_DAY', 'Expédiée le Jour Même');
define('FS_SHIP_NEXT_DAY', 'expédié le lendemain');
define('FS_PRODUCTS_ORDERS_RECEIVED', 'Les commandes reçues après 1:00pm HNP de Lun à Ven (à part les jours fériés) seront expédiées le jour ouvrable suivant.');
define('FS_PRODUCTS_ACTUAL_TIME', 'Il peut y avoir une différence entre le temps estimé et le temps réel.');

define('FS_COMMON_CLEAR', 'Effacer les Sélections');
define('FS_COMMON_COMPLIANT', 'Conforme aux normes IEEE 802.3z pour les applications Gigabit Ethernet et Fast Ethernet');
define('FS_COMMON_ADD', 'Ajoutez');
define('FS_COMMON_ADDED', 'Ajouté');
define('FS_COMMON_PROCESSING', 'Traitement');
define('FS_COMMON_PLEASE_WAIT', 'Veuillez attendre');
define('FS_COMMON_PRODUCT', 'Vue Rapide du Produit');
define('FS_COMMON_NEXT', 'Suivant');
define('FS_COMMON_PREVIOUS', 'Précédent');
define('FS_PRICE_LOW_HIGH', 'Prix : Bas à Haut');
define('FS_PRICE_HIGH_LOW', 'Prix : Haut à Bas');
define('FS_RATE_HOGH', 'Vitesse : Haut à Bas');
define('FS_NEWEST_FIRST', 'Nouveauté');
define('FS_POPULARITY', 'Popularité');
//update 2016.10.27 frankie
define('FS_QUICK_VIEW', 'Vue Rapide du Produit');
define('FS_WAIT', 'Veuillez patienter');
//update 2016.12.5 frankie
define('FS_VERIFIED_PUR', 'Achat Vérifié');
define('FS_COMMENTS', 'Commentaires');
define('FS_SUBMIT', 'Envoyer');
define('FS_REVIEWS9', 'Par ');
define('FS_REVIEWS26', ' le ');
define('FS_REVIEWS10', 'Partagez');
define('FS_REVIEWS11', 'Commentez');
define('FS_DELETE','Supprimer');
define('FIBERSTORE_POPUP_SUCCEED', 'L\'Image du Client est modifiée.');
define('FIBERSTORE_POPUP_FAILURE', 'Le fichier est trop grand !');
/***********************end***********************/


//module shipping   运费模块 
define('FS_SHIP_ORDER', 'Expédier mes commandes à');
define('FS_CHOOSE_SHIP', 'Choisir un Mode d\'Expédition ');
define('FS_COMPANY', 'Compagnie de Transport');
define('FS_TIME', 'Délai d\'Expédition');
define('FS_COST', 'Frais d\'Expédition');
define('FS_TO', 'à');
define('FS_VIA', 'via');
define('FS_FREE_SHIP', 'Livraison gratuite');
define('FS_PREFER', 'Si vous préférez utiliser votre propre compte express, s\'il vous plaît fournir le numéro de compte, alors Fiberstore ne facture pas pour le fret.');
define('FS_METHOD', 'Méthodes de livraison');
define('FS_ACCOUNt', 'compte express');
define('FS_NO_SHIPPING', 'Pas de livraison disponible pour le pays sélectionné');
define('FS_BUSINESS_DAYS', 'Jours Ouvrables');
define('FS_BUSINESS_DAY', 'Jour Ouvrable');
define('FS_SHIP_CONFIRM', 'Validez');
define('FS_WORK_DAYS_SERVICE', 'Jours Ouvrables');

//frankie  stock_list
define('STOCK_LIST_FILTER', 'Sélectionner');
define('STOCK_LIST_MODEL', 'Modèle');
define('STOCK_LIST_DESCRIPTION', 'Description');
define('STOCK_LIST_PRICE', 'Prix');
define('STOCK_LIST_WUHAN', 'Stock');
define('STOCK_LIST_QUANTITY', 'Quantité');

//评论相关页面编辑头像 2017.4.10  ery
define('FS_ADAPTER_TYPE', 'Type d\'Adaptateur');
define('FS_TRANS_RELATED', 'Type');

define('FS_REVIEWS_REPLACE', 'Remplacez l\'image');
define('FS_REVIEWS_EDIT', 'Edit Your Profile');
define('FS_REVIEWS_RECOMMENDED', 'Images Recommandées ');
define('FS_REVIEWS_LOCAL', 'Chargement Local');
define('FS_REVIEWS_ONLY', 'N\'accepte que les formats JPG, GIF, PNG, JPEG, BMP, la taille du fichier doit être supérieure à 300KB');
define('FS_REVIEWS_SAVE', 'Sauvegarder');
//2017.6.15 add  by  frankie 


//账户中心相关页面公用向量   2017.5.12  ery  add
/*edit_my_account页面*/
define('ACCOUNT_MY_ACCOUNT', 'Mon Compte');
define('ACCOUNT_EDIT_ACCOUNT', 'Paramètres du Compte');
define('ACCOUNT_EDIT_BELOW', 'Veuillez modifier vos informations ci-dessous, puis cliquez sur le bouton Mise à Jour pour effectuer les modifications.');
define('ACCOUNT_EDIT_FOLLOW', 'Veuillez vérifier les points suivants…');
define('ACCOUNT_EDIT_ACCOUNT_INFO', 'Information sur le Compte');
define('ACCOUNT_EDIT_UPDATE', 'Mise à Jour');
define('ACCOUNT_EDIT_EMAIL', 'Adresse E-mail');
define('ACCOUNT_EDIT_NEW', 'Nouveau Mot de Passe');
define('ACCOUNT_EDIT_REENTER', 'Confirmez le Mot de Passe');
define('ACCOUNT_EDIT_ADDRESS', 'Information sur l\'Adresse');
define('ACCOUNT_EDIT_FIRST', 'Prénom');
define('ACCOUNT_EDIT_LAST', 'Nom');
define('ACCOUNT_EDIT_COMPANY', 'Nom d\'Entreprise');
define('ACCOUNT_EDIT_STREET', 'Adresse Postale');
define('ACCOUNT_EDIT_LINE', 'Adresse Ligne 2');
define('ACCOUNT_EDIT_POSTAL', 'Code Postal');
define('ACCOUNT_EDIT_CITY', 'Ville');
define('ACCOUNT_EDIT_COUNTRY', 'Pays/Région');
define('ACCOUNT_EDIT_STATE', 'État/Province/Région');
define('ACCOUNT_EDIT_PHONE', 'Numéro de Téléphone');
define('ACCOUNT_EDIT_EMIAL_MSG', 'L\'adresse e-mail que vous avez fournie n\'est pas reconnue. (example : quelqu\'un@example.com).');
define('ACCOUNT_EDIT_PASS_MSG', 'Votre mot de passe doit comporter au moins 7 caractères.');
define('ACCOUNT_EDIT_CONFIRM_MSG', "La confirmation du mot de passe ne correspond pas au nouveau mot de passe. Ils devraient être identiques.");
define('ACCOUNT_EDIT_FIRST_MSG', 'Veuillez entrer votre Prénom.');
define('ACCOUNT_EDIT_LAST_MSG', 'Veuillez entrer votre Nom.');
define('ACCOUNT_EDIT_STREET_MSG', 'Veuillez entrer votre Adresse Postale.');
define('ACCOUNT_EDIT_POSTAL_MSG', 'Veuillez entrer votre Code Postal.');
define('ACCOUNT_EDIT_CITY_MSG', 'Veuillez entrer votre Ville.');
define('ACCOUNT_EDIT_COUNTRY_MSG', 'Veuillez entrer votre Pays.');
define('ACCOUNT_EDIT_STATE_MSG', 'Veuillez entrer votre État/Province/Région.');
define('ACCOUNT_EDIT_PHONE_MSG', 'Veuillez entrer votre Numéro de Téléphone.');
define('ACCOUNT_EDIT_HEADER_OUR', 'Cette adresse e-mail existe déjà dans notre système.');
define('ACCOUNT_EDIT_HEADER_EDIT', 'Modifiez le surnom avec succès.');
define('ACCOUNT_EDIT_HEADER_FILE', 'Le fichier est trop volumineux !');
define('ACCOUNT_EDIT_HEADER_CUSTOMER', 'La Photo du Client est modifiée.');
define('ACCOUNT_EDIT_HEADER_THANKS', 'Merci');
define('ACCOUNT_EDIT_HEADER_FS', 'Service Clients de FS.COM');
define('ACCOUNT_EDIT_HEADER_INFO', 'FS.COM : Mise à Jour de l\'Information du Compte');
define('ACCOUNT_EDIT_HEADER_YOUR', 'Les informations de votre compte FS.COM ont été mises à jour. Veuillez consulter ci-dessous pour vérifier vos informations de compte mises à jour');

/*my_questions和my_questions_details页面*/
define('FS_QUSTION', 'Questions');
define('FS_QUSTI', 'Question');
define('FS_QUSTION_TELL', 'Dites-nous vos problèmes, nous ferons de notre mieux pour vous aider.');
define('FS_QUSTION_ASK', 'Poser une Question');
define('FS_QUSTION_DATE', 'Date');
define('FS_QUSTION_STATUS', 'État');
define('FS_QUSTION_VIEW', 'Voir');
define('FS_QUSTION_REMOVE', 'Supprimer');
define('FS_QUSTION_ENTRIES', 'Inscription(s)');
define('FS_QUSTION_NO', 'Aucun title n\'est rempli.');
define('FS_QUSTION_ANSWERS', 'Réponses');
define('FS_QUSTION_REPLY', 'Les questions sont en traitement, veuillez patienter.');
define('FS_QUSTION_JS', 'Voulez-vous supprimer cette Information ?');
/*manage_address页面*/
define('FS_ADDRESS_BOOK', 'Carnet d\'Adresses');
define('FS_ADDRESS_NAME', 'Prénom');
define('FS_ADDRESS_COMPANY', 'Entreprise');
define('FS_ADDRESS_ADDRESS', 'Adresse');
define('FS_ADDRESS_NO', 'Pas d\'Adresse Trouvée');
define('FS_ADDRESS_DEFAULT', 'Par défaut');
define('FS_ADDRESS_SET', 'Définir par défaut');
define('FS_ADDRESS_EDIT', 'Modifier');
define('FS_ADDRESS_CREATE', 'Créer une Adresse');
define('FS_ADDRESS_UPDATE', 'Mettre à Jour l\'Inscription d\'Adresse');
define('FS_ADDRESS_PLEASE', 'Veuillez compléter ce formulaire pour modifier cette adresse, puis cliquez sur le bouton de mise à jour.');

define('FS_ADDRESS_FIRST_REQUIRED_TIP', 'Votre prénom ne peut pas être vide.');
define('FS_ADDRESS_FIRST_MSG', 'Votre prénom doit comporter au moins 2 caractères.');

define('FS_ADDRESS_LAST_REQUIRED_TIP', 'Votre nom ne peut pas être vide.');
define('FS_ADDRESS_LAST_MSG', 'Votre nom de famille doit comporter au moins 2 caractères.');

define('FS_ADDRESS_STREET_FORMAT_TIP', 'La ligne d\'adresse 1 doit contenir 4 à 35 caractères.');
define('FS_ADDRESS_STREET_PO_BOX_TIP', 'Nous ne livrons pas aux boîtes postales.');
define('FS_ADDRESS_SORRY', 'Désolé, l\'Adresse de Livraison est nécessaire.');

define('FS_ADDRESS_POSTAL_REQUIRED_TIP', 'Votre ZIP/code postal ne peut pas être vide.');
define('FS_ADDRESS_POSTAL_MSG', 'Votre code ZIP/code postal doit comporter au moins 3 caractères.');

define('FS_ADDRESS_COUNTRY_MSG', 'Votre pays est nécessaire.');
define('FS_ADDRESS_STATE_MSG', 'Votre État est nécessaire.');

define('FS_ADDRESS_PHONE_REQUIRED_TIP', 'Votre numéro de téléphone ne peut pas être vide.');
define('FS_ADDRESS_PHONE_MSG', 'Votre numéro de téléphone doit comporter au moins 6 chiffres.');

define('FS_ADDRESS_UP_ADDRESS', 'Mettre à Jour l\'Adresse');
define('FS_ADDRESS_NEW', 'Nouvelle Adresse');
define('FS_ADDRESS_NEW_PLEASE', 'Veuillez compléter ce formulaire pour ajouter une nouvelle adresse, puis cliquez sur le bouton ci-dessous.');
define('FS_ADDRESS_ADD', 'Ajouter l\'Adresse');
define('FS_ADDRESS_DELETE', 'L\'adresse est supprimée avec succès !');
define('FS_ADDRESS_SET_SUCCESS', 'L\'adresse est définie par défaut avec succès !');
define('FS_ADDRESS_UP_SUCCESS', 'L\'adresse est mise à jour avec succès.');
define('FS_ADDRESS_ADD_SUCCESS', 'L\'adresse est ajoutée avec succès.');
/*manage_order相关页面*/
define('MANAGE_ORDER_STATUS', 'État ');
define('MANAGE_ORDER_ORDER', 'N° de Commande ');
define('MANAGE_ORDER_ORDER_NEW', 'N°Commande');
define('MANAGE_ORDER_SHIPMENT', 'Livraison');
define('MANAGE_ORDER_INFORMATION', 'Information de la Commande');
define('MANAGE_ORDER_DATE', 'Date de la Commande ');
define('MANAGE_ORDER_PAYMENT', 'Moyen de Paiement ');
define('MANAGE_ORDER_SEE', 'Voir Tout');
define('MANAGE_ORDER_PO', 'Numéro de PO ');
define('MANAGE_ORDER_RMA_NO', 'Numéro de RMA');
define('MANAGE_ORDER_TEL', 'Tél');
define('MANAGE_ORDER_NOT', 'Pas encore mis en marche');
define('MANAGE_ORDER_SHIPPING', 'Information de la Livraison');
define('MANAGE_ORDER_PRODUCT', 'Article');
define('MANAGE_ORDER_ITEM', 'Prix de l\'Article');
define('MANAGE_ORDER_QUANTITY', 'Quantité ');
define('MANAGE_ORDER_TOTAL', 'Total ');
define('MANAGE_ORDER_TOTAL_01', 'Total ');
define('MANAGE_ORDER_QTY', 'Qté');
define('MANAGE_ORDER_WRITE', 'Écrire un Commentaire');
define('MANAGE_ORDER_PRINT', 'Imprimer les Factures');
define('MANAGE_ORDER_REORDER', 'Commander à Nouveau');
define('MANAGE_ORDER_TIME', 'Temps de Traitement');
define('MANAGE_ORDER_INFO', 'Information de Traitement');
define('MANAGE_ORDER_OPERATOR', 'Opérateur de Traitement');
define('MANAGE_ORDER_COMMODITY', 'Traitement de produits');
define('MANAGE_ORDER_MSG', 'Votre commande est annulée avec succès !');
define('MANAGE_ORDER_ALL', 'Toutes les Commandes');
define('MANAGE_ORDER_PENDING', 'Commandes en Attente');
define('MANAGE_ORDER_COMPLETED', 'Commandes Terminées');
define('MANAGE_ORDER_CANCELLED', 'Commandes Annulées');
define('MANAGE_ORDER_RMA', 'RMA');
define('MANAGE_ORDER_PLACED', 'Date ');
define('MANAGE_ORDER_SHIPING', 'Adresse');
define('MANAGE_ORDER_DETAILS', 'Détails de la Commande');
define('MANAGE_ORDER_INVOICE', 'Facture');
define('MANAGE_ORDER_DOWNLOAD_INVOICE', 'Télécharger la facture');
define('MANAGE_ORDER_BUY', 'Acheter à Nouveau');
define('MANAGE_ORDER_VIEW', 'Voir Plus de Marchandises dans l\'Ordre');
define('MANAGE_ORDER_PAY', 'Payer Maintenant');
define('MANAGE_ORDER_CANCEL', 'Annuler la Commande');
define('MANAGE_ORDER_RETURN', 'Retourner/Remplacer');
define('MANAGE_ORDER_RESTORE', 'Rétablir la Commande Annulée');
define('MANAGE_ORDER_MONTH', 'dernier mois');
define('MANAGE_ORDER_THREE_MONTHS', 'trois derniers mois');
define('MANAGE_ORDER_YEAR', 'dernière année');
define('MANAGE_ORDER_YEAR_AGO', 'il y a un an');
define('MANAGE_ORDER_NO', 'N° de Commande');
define('MANAGE_ORDER_HEADER', 'La demande d\'annulation d\'ordre a été soumise avec succès, veuillez attendre le traitement');
define('MANAGE_ORDER_EA', 'pc');
/*sales_service页面*/
define('FS_SALES_CHOOSE', 'Choisissez les articles à retourner');
define('FS_SALES_ALL', 'Tout');
define('FS_SALES_RETURN', 'Retournez');
define('FS_SALES_CONTINUE', 'Continuez');
define('FS_SALES_SELECT', 'Sélectionnez vos produits');
define('FS_SALES_CONFIRM', 'Annulez cette commande ?');
/*sales_service_info页面*/
define('FS_SALES_REASONS', 'CONFIRMATION RMA');
define('FS_SALES_PLEASE', 'Sélectionnez Type de Service');
define('FS_SALES_REFUND', 'Retour et Remboursement');
define('FS_SALES_REPLACE', 'Remplacement');
define('FS_SALES_MAINTENANCE', 'Réparation');
define('FS_SALES_WHY', 'Pourquoi voulez-vous retourner cet article ?');
define('FS_SALES_NO', 'Pas Besoin');
define('FS_SALES_INCORRECT', 'Produit ou Taille Commandé(e) Incorrect(e)');
define('FS_SALES_MATCH', "Ne pas correspondre à la description");
define('FS_SALES_DAMAGED', 'Endommagé à l\'arrivée');
define('FS_SALES_RECEIVED', 'Réception d\'un article incorrect');
define('FS_SALES_NOT', 'Ne pas répondre aux attentes');
define('FS_SALES_NO_REASON', 'Pas de raison');
define('FS_SALES_OTHER', 'Autres');
define('FS_SALES_COMMENTS', 'Commentaires (obligatoires)');
define('FS_SALES_NOTE', 'REMARQUE');
define('FS_SALES_WE', "Nous ne pouvons pas offrir des exceptions stratégiques en réponse aux commentaires");
define('FS_SALES_WRITE', 'Veuillez écrire votre problème.');
define('FS_SALES_SUCCESSFUL', 'avec succès');
define('RMA_TRACK_STATUS', 'Suivre l\'État ');
define('RMA_SERVICE_TYPE', 'Type de Service');
define('RMA_REASON', 'Raisons pour Service');
/*sales_service_details*/
define('SALES_DETAILS_CONFIRM', 'Confirmer la Réception');
define('SALES_DETAILS_RECEIPT', 'Accusé de Réception');
define('SALES_DETAILS_SUBMIT', 'Soumettre la Demande de RMA');
define('SALES_DETAILS_REJECT', 'Rejeté');
define('SALES_DETAILS_APPROVED', 'Approuvée');
define('SALES_DETAILS_RETURN', 'Retour');
define('SALES_DETAILS_RMA', 'RMA Reçu');
define('SALES_DETAILS_NEW', 'Nouvel Envoi');
define('SALES_DETAILS_REFUND', 'Remboursement');
define('SALES_DETAILS_COMPLETE', 'Achevée');
define('SALES_DETAILS_SEND', 'Comment Renvoyer ?');
define('SALES_DETAILS_SEND_MSG', ' Veuillez suivre l\'organigramme ci-dessous pour retourner les articles, concernant «créer l\'étiquette d\'expédition», vous pouvez le faire sur le site web d\'une entreprise express ou l\'obtenir à partir de l\'emplacement d\'un courrier. Si vous pensez que l\'étiquette d\'expédition devrait être créée et payée par FS.COM, appelez +1 253 2773058 ou envoyez un courriel à service.us@fs.com.');
define('SALES_DETAILS_FROM', 'Renvoyer De');
define('SALES_DETAILS_EDIT', 'Modifiez');
define('SALES_DETAILS_DELIVER', 'Expédier À');
define('SALES_DETAILS_FILL', 'Remplir l\'Awb');
define('SALES_DETAILS_AWB', 'Veuillez remplir l\'AWB de sorte que notre logistique puisse suivre le(s) colis retourné(s), une fois que nous le(s) recevons, le remplacement, le remboursement ou la maintenance seront bientôt traités.');
define('SALES_DETAILS_TRACKING', 'Numéro de Suivi');
define('SALES_DETAILS_PLEASE', 'Veuillez écrire le numéro de suivi.');
define('SALES_DETAILS_PRINT', 'Imprimer RMA');
define('SALES_DETAILS_PRINT_MSG', 'RMA peut nous aider à distinguer votre (vos) colis afin de traiter plus rapidement votre demande RMA à l\'étape suivante. Veuillez l\'imprimer et l\'attacher avec le(s) colis renvoyé(s).');
define('SALES_DETAILS_STEP_CONFIRM', 'Confirmer l\'Adresse');
define('SALES_DETAILS_STEP_PRINT', 'Imprimer Formulaire de RMA');
define('SALES_DETAILS_STEP_ATTACH', 'Joindre Formulaire de RMA');
define('SALES_DETAILS_STEP_CREATE', 'Créer Étiquette d\'Expédition');
define('SALES_DETAILS_STEP_SHIP', 'Expédier l\'Article');
define('SALES_DETAILS_CANCEL','Annulée');

/*售后流程状态提示*/
define('SALES_MSG_APPROVED', 'Votre Demande de RMA a été approuvée, veuillez nous renvoyer le(s) colis.');
define('SALES_MSG_SUBMIT', 'Votre Demande de RMA a été soumise, veuillez attendre le résultat de la revue.');
define('SALES_MSG_RETURN', 'Merci de nous renvoyer le(s) colis, notre service logistique fera attention à l\'état d\'expédition.');
define('SALES_MSG_COMPLETE', 'Le RMA a été complété.');

define('FS_PANEL_REQUEST', 'Demandez un Devis ');
define('FS_PANEL_YOUR', 'Votre Nom');
define('FS_PANEL_PHONE', 'Numéro de Téléphone');
define('FS_PANEL_COUNTRY', 'Votre Pays');
define('FS_PANEL_SEARCH', 'Recherchez votre pays');
define('FS_PANEL_EMAIL', 'Votre Adresse E-mail');
define('FS_PANEL_COMMENTS', 'Commentaires/Question');
define('FS_PANEL_UPLOAD', 'Envoyez les Fichiers');
define('FS_PANEL_COMPLETE', 'Envoi Terminé !');
define('FS_PANEL_PLEASE', 'Veuillez entrer les informations correctes !');
//manage_orders & sales_service_list  2017.6.10		add 	ery
define('MANAGE_ORDER_SEARCH', 'Cherchez toutes les commandes');
define('MANAGE_ORDER_FILTER', 'Filtrez les commandes');
define('MANAGE_ORDER_BACK', 'Retour');
define('MANAGE_ORDER_APPLY', 'Appliquer');
define('MANAGE_ORDER_TYPE', 'Type de Commande');
define('MANAGE_ORDER_TIME_FILTER', 'Filtre temporel');
//2017.6.6		add		ery   manage_orders & account_history_info
define('F_RECEIPT_CONFIRMATION', 'Accusé de Réception');
define('F_REFUNDED_PROCESSING', 'Traitement de Remboursement');
define('MANAGE_ORDER_ARE', "Êtes-vous sûr(e) d'avoir reçu tous les produits ? ");
define('MANAGE_ORDER_YES', 'Oui');
define('MANAGE_ORDER_JS_NO', 'Non');
define('FIBERSTORE_REFUND', 'Confirmation de Remboursement');
define('FIBERSTORE_ONCE_RECOVERED', 'Une fois qu\'il est confirmé, il ne sera plus récupéré.');
define('FIBERSTORE_PLEASE_KINDLY', 'Veuillez compléter les raisons de l\'annulation de la commande si vous insistez pour le faire.');
define('FS_PLEASE_W_REVIEW', 'Ecrivez vos commentaires...');
define('FS_REVIEWS_COMMENT_DEACRIPTION','Vous devez être signé ou créer un compte avant de laisser des commentaires');
//add ternence 
define('MY_CASE_UPLOAD_1', 'Votre demande de solution ');
define('MY_CASE_UPLOAD_2', ' a été soumise.');
define('MY_CASE_UPLOAD_3', 'Cher/Chère');
define('MY_CASE_UPLOAD_4', 'Merci d\'avoir contacté le Support de Solution de FS.COM, nous venons de recevoir votre demande et avons créé un Cas ');
define('MY_CASE_UPLOAD_5', ' pour votre demande de solution.');
define('MY_CASE_UPLOAD_6', 'Nous serons en contact avec vous dans les 24 heures, veuillez vérifier votre e-mail après.');
define('MY_CASE_UPLOAD_7', 'Vous pourriez trouver ces ressources utiles en même temps : ');
define('MY_CASE_UPLOAD_8', 'https://www.fs.com/fr/Data-Center-Cabling.html');
define('MY_CASE_UPLOAD_9', 'https://www.fs.com/fr/Enterprise-Networks.html');
define('MY_CASE_UPLOAD_10', 'https://www.fs.com/fr/Long-haul-Transmission.html');
define('MY_CASE_UPLOAD_11', 'https://www.fs.com/fr/Optic-OEM-Solution.html');
define('MY_CASE_UPLOAD_12', 'Câblage du Centre de Données');
define('MY_CASE_UPLOAD_13', 'Réseau d\'Entreprise');
define('MY_CASE_UPLOAD_14', 'Transmission à Longue Distance');
define('MY_CASE_UPLOAD_15', 'Solution Optique OEM');
define('MY_CASE_UPLOAD_16', 'Cordialement,');
define('MY_CASE_UPLOAD_17', 'https://www.fs.com/fr/');
define('MY_CASE_UPLOAD_18', 'FS.COM');
define('MY_CASE_UPLOAD_19', ' Support de Solution');
define('MY_CASE_UPLOAD_20', 'FS.COM - Demande de Solution & Numéro de Cas : ');
//2017.7.5 add by frankie
define('ACCOUNT_EDIT_SUCCESS', 'Succès');
define('FS_REMOVED_CART', 'a été supprimé de votre panier');
define('FS_UPDATE', 'update');
//2017.7.10 add by peter
define('PATCH_PANEL_01', 'Comment obtenir plus de support ?');
define('PATCH_PANEL_02', 'FS s\'engage à fournir des solutions pour réseaux de centre de données, d\'entreprise et de transmission optique pour vous aider à construire exactement ce dont vous avez besoin.');
define('PATCH_PANEL_03', 'Veuillez contacter le Support Technique : ');
define('PATCH_PANEL_04', 'ou l\'Équipe de Vente :');

//2017.7.11  add by frankie
define('ACCOUNT_TOTAL', 'Sous-total ');
define('ACCOUNT_OF_SHIPPING', '(+) Frais d\'Expédition : ');
define('ACCOUNT_OF_TOTAL', 'Total :');
define('ACCOUNT_OF_GSP_TOTAL_AU','Total GST Incl.');
define('FS_ORDERS_DETAILS_TAX_AU','Montant total du GST');

//2017.8.3 add by frankie
define('TITLE_RELARED_DES', "Chaque module émetteur-récepteur est testé individuellement par les équipements Cisco, Arista, Juniper, Dell, Brocade et d'autres marques, a passé la surveillance du système intelligent de contrôle de qualité de Fiberstore.");
define('TITLE_RELARED_01', '40GBASE-SR4 QSFP+ 850nm 150m MTP/MPO Module Émetteur-Récepteur Optique pour MMF');
define('TITLE_RELARED_02', 'QSFP28 100GBASE-SR4 850nm 100m Module Émetteur-Récepteur Optique');
define('TITLE_RELARED_03', '40GBASE-LR4 et OTU3 QSFP+ 1310nm 10km LC Module Émetteur-Récepteur Optique pour SMF');
define('TITLE_RELARED_04', 'QSFP28 100GBASE-LR4 1310nm 10km Module Émetteur-Récepteur Optique');
define('TITLE_RELARED_05', 'Marque Compatible ');

//checkout 运输方式
define('FS_CHECK_OTHERS', 'Autres');
//2017.8.15 add  全站通用常量
define('FS_SER_COMMON_EMALl', 'Sales@fs.com');
define('FS_EMAIL','fr@fs.com');

define("MANAGE_ORDER_VIEW_PO", "Réviser mon PO");
define("MANAGE_PO_NUMBER", "No. de commande");
//2017.8.9 		add 	ery  税号
define('FS_VAT_NUMBER', 'N° TVA ');
define('FS_VAT_PLEASE', 'Veuillez entrer un numéro Fiscal/TVA valide.');
define('FS_VAT_NO', 'Sans numéro d\'identification à la TVA');
define('FS_CHECK_OUT_STATE', 'Veuillez sélectionner un État');
define('FS_CHECK_OUT_PLEASE', 'Veuillez entrer votre Pays');
define('FS_CHECK_OUT_INVALID', 'Numéro de téléphone invalide, essayez à nouveau.');
define('FS_CHECK_OUT_NEED', 'Besoin d\'aide ');
define('FS_CHECK_OUT_LIVE', 'Chat en Ligne');
define('FS_CHECK_OUT_EMAIL', 'Écrivez-Nous');
define('FS_CHECK_OUT_TAX', 'Taxe ');
define('FS_CHECK_OUT_TAX_RU', 'Taxe ');
define('FS_CHECK_OUT_ORDER', 'Récapitulatif de Commande');
define('FS_CHECK_OUT_REMARKS', 'Remarques de Commande');
define('FS_CHECK_OUT_CHANGE', 'Modifier');
define('FS_CHECK_OUT_ADD', 'Ajouter une nouvelle adresse');
define('FS_CHECK_OUT_REVIEW', 'Vérifier les Articles et l\'Expédition');
define('FS_CHECK_OUT_YOUR', 'Votre Article');
define('FS_CHECK_OUT_ADDRESS', 'Votre Adresse');
define('EMAIL_CHECKOUT_COMMON_VAT_COST', 'TVA ');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2', 'TVA ');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR','TVA ');
define('FS_CHECK_OUT_INCLUDEING', '(Taxe Incluse)');
define('FS_CHECK_OUT_EXCLUDING', '(Hors Taxe)');

define('FS_CHECK_OUT_EXCLUDING_CA','(Le total ci-dessus n\'inclut pas les <a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">taxes</a> éventuelles)');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE', '(Hors Taxe)');

define('FS_CHECK_ADDRESS_TYPE', "Type d'Adresse");
define('FS_CHECK_OUT_ADTYPE_TIT', "Le type d'adresse ne peut pas être vide");
define('FS_CHECK_OUT_COMPANY_TIT', "Le nom de l'entreprise ne peut pas être vide");
define('FIBER_CHECK_USE', 'Utiliser mon propre compte de livraison');
define('FIBER_CHECK_MORE', 'Plus');
define('FIBER_CHECK_LESS', 'Moins');
define('FIBER_CHECK_BANK_NAME', 'Nom de la Banque :');
define('FIBER_CHECK_AC_NAME', 'Nom du Compte :');
define('FIBER_CHECK_AC_NO', 'IBAN :');
define('FIBER_CHECK_SWIFT', 'BIC :');
define('FIBER_CHECK_NUMBER', 'Numéro de Compte ');
define('FIBER_CHECK_BANK_ADDRESS', 'Adresse de la Banque Bénéficiaire :');
define('FS_ADDRESS_INVOCE', "J'aimerais recevoir cette facture par email");
// add by aron 2017.7.17  
define("MANAGE_ORDER_PURCHASE_ORDER", 'Bon de Commande');
define("MANAGE_ORDER_UPLOAD_PO_FILE", 'Ajouter le PO');
define("MANAGE_ORDER_UPLOAD_PURCHASE_ORDER", 'Ajouter le PO');
define("MANAGE_ORDER_UPLOAD_MESAAGE", 'Les articles ne seront pas expédiés avant la réception du Bon de Commande qui doit être reçu dans 5 jours incluant le numéro de commande.');
define("MANAGE_ORDER_UPLOAD_FILE_TEXT", ' Choisissez un Fichier ');
define("MANAGE_ORDER_UPLOAD_ERROR", "Autoriser le fichier de type PDF, JPG, PNG. Taille de fichier maximale : 4MB");
define("MANAGE_ORDER_UPLOAD_SUBMIT", "Ajouter");
define("MANAGE_ORDER_UPLOAD_LABEL", 'Fichier Téléchargé');
define("FS_CHECK_OUT_SELECT", 'Veuillez Sélectionner');
define("FS_CHECK_OUT_BUSINESS", 'Entreprise');
define("FS_CHECK_OUT_INDIVIDUAL", 'Personnel');

//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS', 'UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS', 'UPS Express Next Day 12:00');

define('FS_DHLG', 'DHL Express Domestic');
define('FS_DHLE', 'DHL Economy');
define('FS_DHLEE', 'DHL Express Worldwide');

define('FS_WAREHOSE_CA_TIP', "Livraison gratuite à partir de $ 79,00 dans l'entrepôt U.S.");
define('FS_WAREHOSE_EU_TIP', "Livraison gratuite à partir de 79,00 € dans l'entrepôt EU");
define('FS_WAREHOSE_OTHER_TIP', "Les trois entrepôts de FS.COM assurent une livraison rapide vers ");
define('FS_USCA_SHIPPING_TIP', "Livraison gratuite à partir de C$ 105 dans l'entrepôt U.S.");
define('FS_DECA_SHIPPING_TIP', "Livraison gratuite à partir de C$ 105 dans l'entrepôt EU");

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 免运费提示信息（每个站点显示不一样。不是直接翻译的）

define('FS_FOOTER_FREE_SHIPPING_US_TIP', 'Livraison Gratuite');
define('FS_HEADER_FREE_SHIPPING_US_TIP', 'Livraison Gratuite pour les Commandes d\'Articles Éligibles à Partir de US$ 79');
define('FS_HEADER_FREE_SHIPPING_DE_TIP', 'Livraison Gratuite pour les Commandes d\'Articles Éligibles à Partir de $MONEY');
define('FS_FOOTER_FREE_SHIPPING_DE_TIP', 'Livraison Gratuite');
define('FS_HEADER_FREE_SHIPPING_AU_TIP', 'Livraison Gratuite pour les Commandes d\'Articles Éligibles à Partir de A$99');
define('FS_FOOTER_FREE_SHIPPING_AU_TIP', 'Livraison Gratuite');
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP', 'Same Day Shipping on a Broad Selection of Stock Items');
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP', 'Same Day Shipping');
define('FS_HEADER_FREE_SHIPPING_USFR_CA', 'Livraison Gratuite pour les Commandes d\'Articles Éligibles à Partir de C$ 105');

define('FS_FOOTER_FREE_SHIPPING_USFR_CA', 'Livraison Gratuite');
define('FS_M_FREE_SHIPPING_USFR_CA','Livraison Gratuite à Partir de C$ 105');
define('FS_M_FREE_SHIPPING_DE_TIP','Livraison Gratuite à Partir de $MONEY');
define('FS_M_FREE_SHIPPING_AU_TIP','Livraison Gratuite à Partir de A$99');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','Expédition vers');
define('FS_M_SHIPPING_US_TIP','Livraison Gratuite à Partir de US$ 79');

/*国家下拉框搜索*/
define('FS_SEARCH_YOUR_COUNTRY', 'Cherchez votre pays/région');

//2017-9-12  ery   add 层级属性定制提示语
define('PROINFO_CUSTOM_WAVE', 'Écrivez d\'autres longueurs d\'onde que vous voulez.');
define('PROINFO_CUSTOM_GRID', 'Écrivez d\'autres grid channels que vous voulez.');
define('PROINFO_CUSTOM_RATIO', 'Écrivez d\'autres taux de couplage que vous voulez.');
//2017.10.12. add by frankie 自提
define("CHECKOUT_ONESELF_PICH", "Retirer Moi-même");
//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_INSTALLATION', 'Installation :');
define('FS_PRODUCT_INSTALLATION_TEXT', 'S\'installe dans le châssis FMU-1UFMX-N à monter sur un rack');
define('FS_PRODUCT_INSTALLATION_TEXT2', 'S\'installe dans le châssis ');
define('FS_PRODUCT_INSTALLATION_TEXT3', 'FMT04-CH1U');
define('FS_PRODUCT_INSTALLATION_TEXT4', ' à monter sur un rack');
define('FS_PRODUCT_INSTALLATION_TEXT5','La cassette LGX s\'adapte au châssis <a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a> qui peut être monté sur un rack');
define('FS_PRODUCT_INFO_STEP','Étape');

//2019.1.10 详情页评论
define('FS_REVIEWS34',' Utiles');
define('FS_REVIEWS35',' Utile');
define('FS_REVIEW_REPORT','Rapport');
define('FS_REVIEWS31','Présenter');
define('FS_REVIEWS32','commentaire');
define('FS_REVIEWS36','commentaires');
define('FS_BY','Par');
define('FS_REVIEWS_STARS_TITLE','sur 5 étoiles');
define('FS_READ_MORE','Voir Plus');
define('FS_SEE_LESS','Voir Moins');


//2018.9.6 Yoyo  add 产品详情  shipping&returns
define('FS_ASK_EXPERT', 'Demande d\'Infos : ');
define('FS_ASK_EXPERT_1', 'Demander');
define('SOLUTION_SUB_PAGE_05', 'Demande d\'Infos');

//define('FS_PRODUCT_CUSTOMIZATION','Remarque :');
//define('FS_PRODUCT_CUSTOMIZATION_TEXT','Puissance d\'Entrée Typique=Gain de Puissance de Sortie');

define('FS_PRODUCT_CUSTOMIZATION_TEXT','FMU module Plug-in s\'adapte au châssis ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1','FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2','Module Plug-in s\'adapte à ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3','FUD module Plug-in s\'adapte au châssis ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4','FMU-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5',' qui peut être monté sur un rack');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6','FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7','Le type Plug-in s\'adapte au châssis ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8','FS-2U-RC001');
define('FS_PRODUCT_ITEM','Article ID : ');

//add  by  ery  2017-10-12    产品详情页stock list板块
define('FS_STOCK_LIST_OTHER_ID', 'ID');
define('FS_STOCK_LIST_CENTER', 'Longueur d\'Onde Centrale (nm)');
define('FS_STOCK_LIST_CHANNEL', 'Canal');
define('FS_STOCK_LIST_CWDM', 'CWDM SFP/SFP+');
define('FS_STOCK_LIST_DWDM', '10G DWDM SFP+ 80km');
define('FS_DOWNLOAD', 'Télécharger');
define('FS_DOWNLOADS', 'Téléchargements');
define('FS_STOCK_LIST', 'Liste de Stock');
define('FS_STOCK_LIST_RECOM', 'Recommandation');
define('FS_STOCK_LIST_ADD_TO_CART', 'Ajoutez');
define('FS_STOCK_LIST_PIC', 'Images');
define('FS_STOCK_LIST_ID', 'ID#');
define('FS_STOCK_LIST_DESC', 'Description');
define('FS_STOCK_LIST_PRICE', 'Prix');
define('FS_STOCK_LIST_STOCK', 'Stock');
define('FS_STOCK_OPTION','Option');

//2017-11-2   add  ery  国家下拉框搜索提示语
define('FS_COUNTRY_SEARCH', 'Cherchez votre pays/région');

//2017.11.28  dylan 详情页图标描述
define('PRO_AUTHENTICATION_ICON_PLEASE','Veuillez <a href="'.zen_href_link('contact_us').'" target="_blank">nous contacter</a> pour en savoir plus.');
define('PRO_AUTHENTICATION_ICON_01','Ce produit est conforme aux exigences applicables de la Directive (UE) 2015/863 de la RoHS. La directive RoHS limite l\'utilisation de dix matières dangereuses dans la fabrication de dix types d\'équipements électroniques et électriques : plomb, mercure, cadmium, chrome hexavalent, biphényles polybromés, éthers diphényliques polybromés et quatre phtalates différents. Veuillez nous contacter pour en savoir plus. ');
define('PRO_AUTHENTICATION_ICON_02', 'Ce produit vous fournit la garantie à vie en présentant notre grande sincérité. ');
define('PRO_AUTHENTICATION_ICON_03', 'Ce produit est conforme à la norme ISO9001. Ce système est valable pour une entreprise qui s\'engage dans le développement, la production et la fourniture de produits de fibre optique. ');
define('PRO_AUTHENTICATION_ICON_04', 'Ce produit a été produit selon les exigences de CE, ce qui indique la conformité avec la santé et la sécurité essentielles. ');
define('PRO_AUTHENTICATION_ICON_05', 'Ce produit est complètement conforme à la norme FCC qui vise à gérer les ondes radio et les champs magnétiques plus raisonnablement. ');
define('PRO_AUTHENTICATION_ICON_06', 'La norme FDA est responsable de la réglementation des produits électroniques émettant des radiations pour protéger le public contre l\'exposition dangereuse et inutile aux rayonnements provenant de produits électroniques. ');
define('PRO_AUTHENTICATION_LEARN', 'pour en savoir plus.');
//new
define('PRO_AUTHENTICATION_ICON_07','Ce produit est entièrement conforme à la ETL, qui vise à gérer plus raisonnablement les ondes radio et les champs magnétiques. ');
define('PRO_AUTHENTICATION_ICON_08','Ce produit a été fabriqué conformément aux exigences d\'UL, qui est une consultation et une certification en matière de sécurité mondiale. ');
define('PRO_AUTHENTICATION_ICON_09','CB est un système international géré par IECEE. Ce produit est basé sur les normes IEC qui sont pour tester la performance de sécurité des produits électriques. ');
//
define('PRO_AUTHENTICATION_ICON_10','REACH est un règlement de l\'Union Européenne, adopté pour améliorer la protection de la santé humaine et de l\'environnement grâce à une identification meilleure et plus précoce des propriétés intrinsèques des substances chimiques. ');
define('PRO_AUTHENTICATION_ICON_11','Ce produit est conforme à la norme RCM, ce qui indique la conformité aux exigences légales en matière de sécurité électrique, CEM, EME et de télécommunications. ');
define('PRO_AUTHENTICATION_ICON_12', 'Ce produit est pleinement conforme aux DEEE, qui est une réglementation environnementale de l\'Union Européenne et vise à améliorer la collecte, le traitement et le recyclage des produits en fin de vie. ');
define('PRO_AUTHENTICATION_ICON_13', 'Ce produit répond à la certification 3C, il appartient aux gouvernements de protéger la sécurité personnelle des consommateurs et la sécurité nationale, d\'améliorer la gestion de la qualité des produits, conformément aux lois et règlements pour la mise en place d\'un système d\'évaluation de la conformité des produits. ');
define('PRO_AUTHENTICATION_ICON_14', 'La certification VCCI (Voluntary Control Council for Interference) est une certification obligatoire pour les équipements multimédia (MME) au Japon, et elle est spécifique aux équipements informatiques, au contrôle de diffusion électromagnétique, qui constitue la certification EMC des produits. Ce produit est entièrement conforme à la certification VCCI du Japon. ');
define('PRO_AUTHENTICATION_ICON_15', 'TELEC est la certification obligatoire des produits sans fil au Japon, également appelée certification MIC au Japon. Ce produit répond à la certification TELEC requise pour les produits sans fil (appareils Bluetooth, téléphones portables, routeurs WIFI, drones, etc.) exportés au Japon. ');
define('PRO_AUTHENTICATION_ICON_16', 'Cet article est conforme à la norme ISO14001. La présente Norme est destinée à être utilisée par les organismes souhaitant gérer leurs responsabilités environnementales d\'une manière systématique qui contribue au pilier environnemental du développement durable. ');
define('PRO_AUTHENTICATION_ICON_17', 'Ce produit est pleinement conforme au certificat TR CU de Russie (Certificat EAC), ce qui signifie qu\'il est conforme aux normes des pays membres de l\'Union Douanière, ainsi qu\'aux exigences de qualité et de sécurité. ');
define('PRO_AUTHENTICATION_ICON_18', 'Ce produit est entièrement conforme aux exigences de UL (Underwriters Laboratories Inc.), ce qui indique que ce produit répond aux exigences de sécurité de UL. ');

//2017-12-5   ery
define('MY_ORDER_SUCCESSFULLY', 'Commande soumise avec succès, nous attendrons la réception de votre paiement.');
define('MY_ORDER_WAIT', 'Vous avez payé avec succès, attendez l\'expédition s\'il vous plaît.');
define('FIBERSTORE_BY_SYSTEM', 'via le système');
define('FIBERSTORE_SESTEM', 'Système de Fiberstore');

define('FS_WRITE_OTHER_DEVICES', 'ex : Cisco N9K-C9396PX');
define('HPE_LIMIT', 'Veuillez choisir la compatibilité "VAL_XXX" pour votre commande en raison de son matériau spécifique, puis noter les numéros de modèle.');
define('HPE_LIMIT2', 'La compatibilité « VAL_XXX » n’est pas disponible pour votre commande en raison de son matériau spécial.');
define('model_number_empty','Veuillez remplir le numéro de modèle de votre appareil.');
//2017-12-2  add   ery  产品无库存是的提示语
define('FS_PRODUCTS_CUSTOMIZED', 'Personnalisé');
define('FS_COMMON_LEVEL_WAS', 'Était');
//2017-12-15  ery  add  前台相关打印发票页面的公司地址
// 武汉仓
define('FS_COMMON_WAREHOUSE_CN','ATTN : FS. COM LIMITED<br> 
			Address : A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China<br>
			Tél. : +86-0755-83571351');
define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> Chine');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Allemagne<br>
			Tél. : +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			États-Unis <br>
			Tél. : +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','ATTN: FS.COM Inc.<br>
					Adresse : 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					États Unis<br>
					Tél. : +1 (888) 468 7419');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapour<br>
				Tél. : (65) 6443 7951<br>
				GST Reg No. : 201818919D');

// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australie<br>
				Tél. : +61 3 9693 3488<br>
				ABN : 71 620 545 502');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','ATTN: FS Tech Pte Ltd.<br>
				Adresse : 30A Kallang Place #11-10/11/12<br>
				Singapour 339213<br>
				Singapour<br>
				Tél. : +(65) 6443 7951');
define("QTY_SHOW_ZERO_STOCK", "pc");
define("QTY_SHOW_MORE_STOCK", "pcs");
define("QTY_SHOW_MORE", "pcs en");
define("QTY_SHOW_ZERO_STOCK_1", " En Stock");
define("QTY_SHOW_MORE_STOCK_2", " En Stock");
define("QTY_SHOW_AVAILABLE", "Disponible");
define('QTY_SHOW_IN_CN_STOCK_1','En Stock');
//add by quest 2019-03-08
define("QTY_SHOW_AVAILABLE_NEW_INFO","En Transit");
define("QTY_SHOW_AVAILABLE_TAG_NEW_INFO","En Production");

define("FS_IN_STOCK", "en stock");
define("QTY_SHOW_ZERO", "pc en");
//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK", "Merci pour votre commande chez ");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE", "Chat en Ligne");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH", "avec un spécialiste");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN", "Sincèrement,");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR", "Bonjour");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM", "Service Client ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING", "Adresse de livraison : ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT", "Si vous avez des questions sur votre commande, n'hésitez pas à ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR", "Votre PO#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP", "a été téléchargé avec succès.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE", "Merci pour les documents PO, vous pouvez voir le bon de commande et imprimer la facture via");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS", "Mes commandes");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW", "maintenant.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES", "Frais de Port ");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL", "Total Général");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL", "Sous-total");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS", "Votre commande sera traitée immédiatement, si vous avez des questions sur elle, n'hésitez pas à");


define("FS_WAREHOUSE_AREA_SG","Expédition de l'entrepôt SG");
define("FS_WAREHOUSE_AREA_PR",'Expédition de FS U.S');
//分仓分库语言包
define("FS_WAREHOUSE_AREA_1","expédition directe de l'entrepôt CN");
define("FS_WAREHOUSE_AREA_2","expédition l'entrepôt U.S.");
define("FS_WAREHOUSE_AREA_3","expédiée à partir de l'entrepôt DE");
define("FS_WAREHOUSE_AREA_4","- Disponible pour une expédition immédiate");
define("FS_WAREHOUSE_AREA_5","- Disponible pour expédition qui est prévue pour le ");
define("FS_WAREHOUSE_AREA_6","Les articles seront livrés par ");
define("FS_WAREHOUSE_AREA_7","colis séparés. ");
define("FS_WAREHOUSE_AREA_8","Article");
define("FS_WAREHOUSE_AREA_9","Prix Unitaire");
define("FS_WAREHOUSE_AREA_10","Qté");
define("FS_WAREHOUSE_AREA_11","Prix Unitaire");
define("FS_WAREHOUSE_AREA_12","Veuillez visiter la page '");
define("FS_WAREHOUSE_AREA_13","Mes Commandes");
define("FS_WAREHOUSE_AREA_14","' pour télécharger le document PO si vous ne l'avez pas déjà fait. Nous traiterons votre commande dès la confirmation de votre bon de commande.");
define("FS_WAREHOUSE_AREA_15","Merci pour votre commande chez");
define("FS_WAREHOUSE_AREA_16"," ! Voici un résumé de votre dernière commande en attente. Il ne vous reste qu'une dernière étape pour finir le paiement.");
define("FS_WAREHOUSE_AREA_17","Merci pour votre commande cehz FS.COM ! Nous avons bien reçu votre commande et nous allons la traiter au plus vite. ");
define("FS_WAREHOUSE_AREA_18","Merci pour votre commande cehz FS.COM. Votre commande #");
define("FS_WAREHOUSE_AREA_19"," passée à ");
define("FS_WAREHOUSE_AREA_20"," a été bien reçue. Pour ne pas retarder le délai de livraison, vous pouvez effectuer le paiement directement au compte paypal de notre entreprise : paypal@fs.com.");
define("FS_WAREHOUSE_AREA_21","S'il y a des problèmes ou des questions sur le paiement de paypal, n'hésitez pas à nous contacter à ");
define("FS_WAREHOUSE_AREA_22","Pas encore établi");
define("FS_WAREHOUSE_AREA_23","Commande Reçue, En Attente de Traitement");
define("FS_WAREHOUSE_AREA_24","a été reçue.");
define("FS_WAREHOUSE_AREA_25","S'il y a des problèmes ou des questions sur le paiement de Carte de crédit/débit, n'hésitez pas à nous contacter à");
define("FS_WAREHOUSE_AREA_26","Commande reçue, en attente de traitement");
define("FS_WAREHOUSE_AREA_27","S'il y a des problèmes ou des questions sur");
define("FS_WAREHOUSE_AREA_28","n'hésitez pas à nous contacter à");
define("FS_WAREHOUSE_AREA_29","N° de Commande :");
define("FS_WAREHOUSE_AREA_30","Expédiée Par :");
define("FS_WAREHOUSE_AREA_31","commande cehz FS.COM");
define("FS_WAREHOUSE_AREA_32","Merci pour votre commande chez FS.COM ! Voici les détails de votre commande. Il faut attendre la confirmation du Bon de Commande maintenant.");
define("FS_WAREHOUSE_AREA_33","Merci pour votre commande chez FS.COM ! Voici les détails de votre commande.</br>Note: emarque : L'adresse de livraison ne correspond pas aux adresses de votre formulaire de demande de crédit. Cette commande devra être revue et le résultat vous sera envoyé par e-mail dans les 12 heures.");
define("FS_WAREHOUSE_AREA_34","Merci pour votre commande chez FS.COM ! Voici les détails de votre commande.</br>Note: emarque : L'adresse de livraison ne correspond pas aux adresses de votre formulaire de demande de crédit et le montant de la commande dépasse votre limite de crédit FS.COM. Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes pour modifier la limite de crédit, ou vous pouvez cliquer sur «Mon compte» et cliquer sur «Bon de commande» pour demander l'augmentation de votre limite de crédit. Nous vous enverrons le résultat par e-mail après la vérification.");
define("FS_WAREHOUSE_AREA_35","Merci pour votre bon de commande ! Voici des détails de votre commande.</br>Remarque : Le montant de la commande dépasse votre limite de crédit chez FS.COM. Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes pour modifier la limite de crédit, ou aller dans Mon compte et cliquer sur Bon de commande pour demander une augmentation de votre limite de crédit.");

/*结算页交期气泡提示语*/
define("FS_WAREHOUSE_AREA_TIME_36","L'expédition a été retardée en raison du jour férié aux États-Unis.");
define("FS_WAREHOUSE_AREA_TIME_37","L'expédition a été retardée en raison du jour férié en Australie.");
define("FS_WAREHOUSE_AREA_TIME_38","L'expédition a été retardée en raison du jour férié en Allemagne.");
define("FS_WAREHOUSE_AREA_TIME_39","L'expédition a été retardée en raison du jour férié à Singapour.");
define("FS_WAREHOUSE_AREA_TIME_42","L'expédition a été retardée en raison du jour férié en Chine.");
define("FS_WAREHOUSE_AREA_TIME_40","L'expédition a été retardée en raison du week-end.");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">Fermer</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","Retirer moi-même à l'Entrepôt U.S. à l'heure souhaitée");
define("FS_WAREHOUSE_AREA_TIME_44","Retirer moi-même à l'Entrepôt DE (Allemagne) à l'heure souhaitée");
define("FS_WAREHOUSE_AREA_TIME_45","Retirer moi-même à l'Entrepôt AU à l'heure souhaitée");
define("FS_WAREHOUSE_AREA_TIME_46","Retirer moi-même à l'Entrepôt en Asie à l'heure souhaitée");
define("FS_WAREHOUSE_AREA_TIME_47","Retirer moi-même à l'Entrepôt SG à l'heure souhaitée");
define("FS_WAREHOUSE_AREA_SHIP_CN"," à partir de l'Entrepôt en Asie");
define("FS_WAREHOUSE_AREA_SHIP_US"," à partir de l'Entrepôt U.S.");
define("FS_WAREHOUSE_AREA_SHIP_AU"," à partir de l'Entrepôt AU ");
define("FS_WAREHOUSE_AREA_SHIP_DE"," à partir de l'Entrepôt DE (Allemagne)");
define("FS_WAREHOUSE_AREA_SHIP_SG"," à partir de l'Entrepôt SG");
define("FS_PICK_UP_WAREHOUSE", "Retirer moi-même à l'entrepôt");

//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR', 'Votre paiement de commande est confirmé.');
define('EMAIL_CHECKOUT_SUCCESS_WE', 'Nous avons bien reçu votre paiement pour la commande ');
define('EMAIL_CHECKOUT_SUCCESS_THANK', ', merci pour votre grand soutien.');


define('FIBER_CHECK_TWO', 'UPS 2nd Day Air<sup>®</sup> service');
define('FIBER_CHECK_TWO_AM','UPS 2nd Day A.M.<sup>®</sup> service');
define('FIBER_CHECK_STAND', 'UPS Ground<sup>®</sup> service');
define('FIBER_CHECK_ONE', 'UPS Next Day-Afternoon<sup>®</sup> service');

define('FIBER_FEDEX_CHECK_OVER', 'FedEX Overnight<sup>®</sup> service');
define('FIBER_FEDEX_CHECK_TWO', 'FedEX 2Day<sup>®</sup> service');
define('FIBER_FEDEX_CHECK_GROUND', 'FedEX Ground<sup>®</sup> service');
define('FIBER_CHECK_USE', "Utiliser mon propre compte d'expédition");
define('FIBER_CHECK_FREE', 'Gratuit');
define('FIBER_CHECK_FREE_SHIPPING','Gratuit');

define("FS_WAREHOUSE_AREA_32", "Merci pour votre commande ! Voici les détails. Nous attendons la confirmation de PO.");
define('EMAIL_CHECKOUT_PAYPAL_TEXT1', "Commande Reçue, En Attente de Confirmation de Paiement");
define('EMAIL_CHECKOUT_PAYPAL_TEXT2', "Merci pour votre commande chez ");
define('EMAIL_CHECKOUT_PAYPAL_TEXT3', "FS.COM");
define('EMAIL_CHECKOUT_PAYPAL_TEXT4', " ! Voici un résumé de votre dernière commande en attente. Il ne vous reste qu'une dernière étape pour finir le paiement.");
define('EMAIL_CHECKOUT_PAYPAL_TEXT4_1', "! Voici un résumé de votre dernière commande en attente. Il ne vous reste qu'une dernière étape pour finir le paiement.");
define('EMAIL_CHECKOUT_PAYPAL_TEXT5', "Livraison Prévue");
define('EMAIL_CHECKOUT_PAYPAL_TEXT6', "Si vous avez des questions sur votre commande, n'hésitez pas à ");
define('EMAIL_CHECKOUT_PAYPAL_TEXT7', '<a href="' . zen_href_link('contact_us') . '">nous contacter</a>');
define('EMAIL_CHECKOUT_PAYPAL_TEXT8', " Service Client ");
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE', 'FS.COM - Commande %s reçue, veuillez compléter le paiement');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE_PO', 'FS.COM - Commande %s reçue, en attente de confirmation du Bon de Commande');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE', 'FS.COM - Paiement Reçu pour Commande %s');
define('EMAIL_CHECKOUT_PO', 'téléchargé avec succès');
define("FS_MANAGE_ORDERS_FILE", "Veuillez ajouter votre bon de commande.");

define("FS_CANLED_CK", "Annuler");
define("FS_SAVE_CK", "Sauvegarder");
define("FS_ITEMS_CK", "Votre Article");
define("FS_QUANITY_CK", "Qté");

define('FS_SUCCESS_METHOD', "Moyen d'Expédition");
define('FS_SUCCESS_DELIVERY', "Livraison Prévue");
define('FS_SUCCESS_SHIP_FROM', "Expédié de");
define('FS_SUCCESS_ORDER_DINGDAN', 'Commande #');
define('FS_SUCCESS_ORDER_QUESTION', "Si vous avez besoin d'aide, merci de nous appeler au +33 (1) 82 884 336 ou nous envoyer un mail.");
define("FS_WAREHOUSE_EU", "Entrepôt DE");
define("FS_WAREHOUSE_US", "Entrepôt U.S.");
define("FS_WAREHOUSE_CN", "Entrepôt CN");
define('FS_SUCCESS_PURCHASE', 'Votre commande a été divisée en');
define('FS_SUCCESS_ORDER_01', '.');
//公用头部账户板块
define('FS_COMMON_HEADER_ACCOUNT', 'N° de Compte');
define('FS_COMMON_HEADER_CASES', 'Mes Cas');
//FS_COMMON_HEADER_NOT 英文站是Not You?法语翻译后太长且已经不能在精简，因此要求去掉
define('FS_COMMON_HEADER_NOT', '');
define('FS_COMMON_HEADER_OUT', 'Se Déconnecter ');
define('MANAGE_ORDER_HISTORY', 'Historique de Commandes');
define('FS_ACCOUNT_NO','N° ');

//再次付款公共
/**************************html_checkout_payment_against_paypal.php**************************/
define('FS_AGAINST_PROCEED', 'Passer à PayPal');
/************************** add by Aron html_checkout_gloabal**************************/
define("GLOBAL_FIRSTNAME", "Prénom");
define("GLOBAL_LASTNAME", "Nom");
define("GLOBAL_ADDRESS1", "Adresse Ligne 1");
define("GLOBAL_ADDRESS2", "Adresse Ligne 2 (optionnelle)");
define("GLOBAL_POSTAL", "Code Postal");
define("GLOBAL_CITY", "Ville");
define("GLOBAL_COUNTRY", "Pays/Région");
define("GLOBAL_PHONE", "Numéro de Téléphone");
define("GLOBAL_STATE", "État / Province / Région");
define("GLOABL_VAT", "N° TVA");
define("GLOABL_COMPANY", "Nom de l'Entreprise");
define("GLOABL_ADRESSTYPE", "Type d'Adresse");
define("GLOABL_CART", "Panier");
define("GLOABL_EDIT_BILLING", "Modifiez l'Adresse de Facturation");
define("GLOABL_CHECK_FOLLOWING", "Veuillez vérifier les éléments suivants ...");
define("GLOABL_CHECKETOUT", "Passer à la caisse");
define("GLOABL_SUCCESS", "Succès");
define("GLOABL_LIVECHAT", "Chat en Ligne");
define("GLOBAL_TEXT1", "Veuillez contacter votre représentante commerciale si vous avez des questions sur l'état du paiement.");
define("GLOBAL_TEXT2", "Le paiement a été refusé. Veuillez utiliser une autre carte de créditpaiement ou changer le mode de paiement dans PayPal ou le virement bancaire pour une commande en attente.");
define("GLOBAL_TEXT3", "Assurez-vous que l'adresse de facturation que vous entrez ci-dessous correspond au nom et à l'adresse associés à la carte de crédit que vous utilisez pour cette commande. Veuillez noter que le pays de l'adresse de facturation et d'expédition doivent être identiques.");

define("GLOBAL_TEXT4", "Centre de Paiement par Carte de Crédit/Débit");
define("GLOBAL_TEXT5", "Nous acceptons les cartes de crédit/débit suivantes. Veuillez sélectionner un type de carte, compléter les informations
         ci-dessous, et cliquer sur Continuer. (Remarque : Pour des raisons de sécurité, nous ne sauvegardons aucune de vos données de carte de crédit.)");

define("GLOBAL_TEXT6", "Sélectionner une Carte de Crédit/Débit :");

define("GLOBAL_TEXT7", "Récapitulatif de Commande");
define("GLOBAL_TEXT8", "Numéro de Commande :");
define("GLOBAL_TEXT9", "Besoin d'aide ? ");
define("GLOBAL_TEXT10", " Consultez le Pages d'Aide ou  ");
define("GLOBAL_TEXT11", " Adresse de Facturation  ");
define("GLOBAL_TEXT12", "Modifier");
define("GLOBAL_TEXT13", "Numéro de Carte");
define("GLOBAL_TEXT14", "Date d'Expiration");
define("GLOBAL_TEXT15", "Mois");
define("GLOBAL_TEXT16", "Année");
define("GLOBAL_TEXT17", "Code de Sécurité");
define("ADDRESS_TYPE1", "Type d'Entreprise");
define("ADDRESS_TYPE2", "Type Personnel");
define("CHECKOUT_PLEASE1", "veuillez sélectionner");
define("GLOABL_VAT_PLEASE2", "N° TVA valide, par exemple : DE123456789");
define("ADDRESS_TYPE_TIT1", "Le Type d'Adresse ne peut pas être vide");
define("ADDRESS_TYPE_TIT2", "Le nom de la société ne peut pas être vide");
define('FS_SUCCESS_ORDER_DINGDAN', 'Numéro de Commande');
define("FS_QUESTION", "Si vous avez des questions,appelez-nous");
define("FS_EMAIL_US", "ou envoyez-nous un e-mail");
define("FS_NOT_NULL", "Le numéro de la commande ne peut pas être vide");
define("FS_SYSTEM_ERROR_TIT", "Veuillez contacter votre représentante commerciale si vous avez des questions sur l'état du paiement.");

//add  by frankie 询价按钮
define('GET_A_QOUTE', 'Obtenir un Devis');

//2018 1-9.aRON 游客邮件
define("FS_GUEST_EMAIL_THANK", "en tant qu'un visiteur");
define("FS_GUEST_EMAIL_CONTACT", "Nous vous contacterons concernant le statut de la commande avec cette adresse e-mail. Si vous avez d'autres questions relatives à votre commande, n'hésitez pas à ");

define("CHECKOUT_TAXE_US_TIT", "À Propos de la Taxe de Vente & des Droits et Taxes");
define("CHECKOUT_TAXE_US_FRONT", "Si les articles sont expédiés de notre entrepôt américain à une adresse dans l'État de Washington, une TVA de 10% sera facturée conformément aux lois fiscales de l'État de Washington. Toutefois, si vous pouvez fournir un certificat d'exonération de taxe valide pour l'État ou les États où vous vous trouvez, aucune TVA ne sera perçue. Les articles expédiés au Canada et au Mexique sont exempts de la TVA, mais l'acheteur sera responsable du dédouanement et des droits de douane. Quand vous passez une commande en ligne, nous ne facturerons que les frais d'expédition sans tout autre tarif dans le montant total de la commande (FS.COM par défaut). S'il est nécessaire, FS.COM peut vous aider à organiser le prépaiement des droits de douane.");
define("CHECKOUT_TAXE_US_BACK", "Pour les expéditions à partir de l'Entrepôt du CN, FS.COM ne facturera les articles et les frais d'expédition que lors de la commande. Ces colis peuvent toutefois faire l'objet d'une évaluation des droits d'importation ou de douane, en fonction de la législation de chaque pays. Tous les droits de douane ou d'importation sont perçus une fois que le colis atteint le pays de destination. Des frais supplémentaires pour le dédouanement devraient être supportés par le destinataire ; nous n'avons aucun contrôle sur ces frais et ne pouvons pas prédire ce qu'ils pourraient être. Étant donné que les politiques douanières varient considérablement d'un pays à l'autre, vous pouvez contacter votre bureau de douane local pour plus d'informations. Si nécessaire, FS.COM peut vous aider à prépayer la TAXE DE SERVICE.");

define("CHECKOUT_TAXE_CN_TIT", "Concernant le Droit et le Taxe");
define("CHECKOUT_TAXE_CN_TIT1","À Propos des Droits et Taxes");
define("CHECKOUT_TAXE_CN_FRONT", "Pour les commandes expédiées de notre entrepôt CN, nous ne facturerons que la valeur du produit et les frais d'expédition. Aucune taxe de vente (ex. TVA ou TPS) ne sera facturée. Toutefois, les colis peuvent faire l’objet d’une taxe d’importation ou de droits de douane, selon les lois/réglementations en vigueur dans certains pays. <b>Tout droit de douane dû au dédouanement doit être déclaré et supporté par le destinataire.</b> Si vous avez besoin d'aide pour prépayer les droits de douane, veuillez nous contacter.");

define("CHECKOUT_TAXE_DE_TIT", "À propos de la TVA, du droit et de l'impôt");
define("CHECKOUT_TAXE_DE_FRONT","Tous les articles seront expédiés de l'entrepôt de l'Allemagne, et en fonction des lois applicables aux pays membres de l'Union Européenne, FS.COM GmbH est obligé de facturer la TVA sur toutes les commandes livrées vers les destinations des pays membres de l'UE.");
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>Destination de Pays</div><div>TVA &amp; Tarif</div></div><div class=\"help-center-taTr\"><div>Allemagne</div><div>Une TVA de 19% sera facturée.</div></div><div class=\"help-center-taTr\"><div>France et Monaco</div><div>Une TVA de 20% sera facturée, mais si vous avez un Numéro de TVA Européen Valide, la TVA sera exonérée.</div></div><div class=\"help-center-taTr\"><div>Pays-Bas, Espagne, Belgique</div><div>Une TVA de 21% sera facturée, mais si vous avez un Numéro de TVA Européen Valide, la TVA sera exonérée.</div></div><div class=\"help-center-taTr\"><div>Italie</div><div>Une TVA de 22% sera facturée, mais si vous avez un Numéro de TVA Européen Valide, la TVA sera exonérée.
</div></div><div class=\"help-center-taTr\"><div>Suède </div><div>Une TVA de 25% sera facturée, mais si vous avez un Numéro de TVA Européen Valide, la TVA sera exonérée.</div></div><div class=\"help-center-taTr\"><div>d'Autres Pays Membres de l’UE</div><div>Une TVA de 19% sera facturée, mais si vous avez un Numéro de TVA Européen Valide, la TVA sera exonérée.</div></div><div class=\"help-center-taTr\"><div>Pays Hors de l'UE</div><div>La TVA sera pas facturée, mais les droits de douane seront à votre charge. </div></div></div>
<br>Pour les commandes expédiées directement à partir de nos entrepôts en Asie vers des Pays Européens, la TVA ne sera pas facturée. Toutefois, ces colis peuvent être soumis à des frais d'importation ou à des droits de douane en fonction des lois de chaque pays. Pour les commandes en ligne, nous facturerons uniquement les frais d'expédition sans aucun tarif auprès de FS par défaut. Tous les frais causés par le dédouanement doivent être supportés par le destinataire. Si vous avez besoin de notre assistance à organiser le prépaiement des droits de douane, veuillez nous contacter à l'avance.");
define("CHECKOUT_TAXE_NEW_CN_CONTENT","Les produits en stock dans notre entrepôt américain seront expédiés directement du Delaware vers toutes les destinations américaines. FS.COM facturera UNIQUEMENT la valeur du produit et les frais d'expédition. Aucune TVA ne sera facturée.<br/><br/>Si les commandes contiennent des articles temporairement en rupture de stock dans l'entrepôt américain, nous vous les enverrons directement à partir de notre entrepôt d'Asie pour accélérer la livraison. S'il y a un message «Livraison Gratuite» sur la page du produit, FS.COM supportera tous les droits et taxes éventuels causés par le dédouanement à l'importation.<br/><br/>Pour les produits qui N'ONT PAS de message «Livraison Gratuite» sur la page du produit, il s'agit des articles lourds ou surdimensionnés. Ils seront expédiés directement à partir d'entrepôt d'Asie et ne peuvent pas obenir le service de livraison gratuite. Et tous les frais éventuels causés par le dédouanement doivent être supportés par vous-même.");
define("CHECKOUT_TAXE_NEW_CA_CONTENT","Les produits en stock dans notre entrepôt américain seront expédiés directement du Delaware vers toutes les destinations au Canada.<br/><br/>Si les commandes contiennent des articles temporairement en rupture de stock dans l'entrepôt américain, nous vous les enverrons directement à partir de notre entrepôt d'Asie pour accélérer la livraison.<br/><br/>Lorsque vous passez la commande en ligne, FS.COM facturera UNIQUEMENT la valeur du produit et les frais d'expédition. Tous les droits et tarifs éventuels causés par le dédouanement devraient être supportés par vous-même.");
define("CHECKOUT_TAXE_NEW_MX_CONTENT","Les produits en stock dans notre entrepôt américain seront expédiés directement du Delaware vers toutes les destinations au Mexique.<br/><br/>Si les commandes contiennent des articles temporairement en rupture de stock dans l'entrepôt américain, nous vous les enverrons directement à partir de notre entrepôt d'Asie pour accélérer la livraison.<br/><br/>Lorsque vous passez la commande en ligne, FS.COM facturera UNIQUEMENT la valeur du produit et les frais d'expédition. Tous les droits et tarifs éventuels causés par le dédouanement devraient être supportés par vous-même.");


//游客页面注册
define("REGITS_FROM_GUEST_EMAIL_ERROR1", "Votre adresse e-mail est indispensable.");
define("REGITS_FROM_GUEST_EMAIL_ERROR2", "Entrez votre adresse e-mail (eg : someone@gmail.com).");
define("REGITS_FROM_GUEST_PASSWORD_ERROR1", "6 caractères minimum comportant au moins une lettre et un chiffre.");
define("REGITS_FROM_GUEST_PASSWORD_ERROR2", "Votre mot de passe doit être conforme.");
define("REGITS_FROM_GUEST_ASK", "Aimeriez-vous créer un compte maintenant ?");
define("REGITS_FROM_GUEST_CAN", "Encore une étape pour obtenir un meilleur service. Avec un compte FS, vous aurez l'accès au :");
define("REGITS_FROM_GUEST_EASY", "Suivi facile à travers l'historique de votre commande");
define("REGITS_FROM_GUEST_FASTER", "Paiement plus rapide avec un carnet d'adresse");
define("REGITS_FROM_GUEST_NO", "Non, merci.");
define("REGITS_FROM_GUEST_YES", "Oui, j'aimerais bien créer un compte.");
define("REGITS_FROM_GUEST_USE", "Utiliser mon e-mail de paiement");
define("REGITS_FROM_GUEST_OR", "OU");
define("REGITS_FROM_GUEST_HISTORY", "Si votre e-mail de paiement et votre e-mail d'enregistrement sont différents, ils seront associés automatiquement pour offrir un meilleur service. Les e-mails concernant la confirmation de la commande seront envoyés à l'adresse e-mail d'enregistrement, vous pouvez vous enregistrer à compte FS pour la gestion et le suivi de vos commandes à tout moment.");
define("REGITS_FROM_GUEST_PASWORD", "Mot de Passe");
define("REGITS_FROM_GUEST_CPASWORD", "Confirmer Votre Mot de Passe");
define("REGITS_FROM_GUEST_NOTE", "Remarque : votre numéro de téléphone est uniquement utilisé pour vous contacter à la livraison, ainsi que votre adresse e-mail pour mettre à jour le statut de la commande.<br>Vous pouvez consulter <a href='" . HTTPS_SERVER.reset_url('policies/privacy_policy.html') . "'>Politique de Confidentialité & Cookies</a> pour plus d'informations.");
define("REGITS_FROM_GUEST_EXSIT1", "L'adresse e-mail est enregistrée dans notre système, veuillez vous connecter directement. &nbsp;&nbsp;&nbsp;&nbsp;");
define("REGITS_FROM_GUEST_EXSIT2", "Connectez-vous »");
define("REGIST_NUM_LENGTH", "au moins 6 caractères");
define("REGIST_NUM_LEAST", "6 caractères minimum comportant au moins une lettre et un chiffre.");

//2017-12-1  dylan     产品详情页Customization属性
define('FS_PRODUCT_CUSTOMIZATION_TEXT', 'FMU module Plug-in s\'adapte au châssis ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1', 'FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2', 'Le type de carte Plug-in s\'adapte au châssis ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3', 'FUD module Plug-in s\'adapte au châssis ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4', 'FMU-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5', ' qui peut être monté sur un rack');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6', 'FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7', ' qui peut être monté sur un rack');

//2018-1-24   ery   add  产品详情页属性未勾选加入购物车提示语 
define('FS_PRODUCT_INFO_ATTR_PLEASE','Veuillez sélectionner une option pour chaque attribut.');
//产品详情页长度定制框语言包
define('FS_LENGTH_CUSTOM_FEET', 'Feet Or');
define('FS_LENGTH_CUSTOM_METER', 'Meter');
define('FS_PRODUCTS_AOC_LENGTH_ERROR','La longueur du câble peut être personnalisée de 0,5m à 100m (1,64ft à 328,084ft) selon vos besoins.');

//春节设置,请勿乱修改,1->开启春节分仓 0->关闭春节分仓
define("FS_IS_SPRING", 0);


define("CN_SPRING_WAREHOUSE_MESSAGE", "Die Artikel, die nur Lagerbestand in China haben, werden in den Frühlingsferien (10.02.2018 - 20.02.2018) nicht versandt");
define("FS_EMPTY_COST", "Nous sommes désolés que toutes les entreprises de logistique n'offrent pas de services d'expédition à votre adresse pour l'instant, s'il vous plaît utilisez votre propre compte de livraison. Pour plus d'infos, veuillez <a href='https://www.fs.com/fr/contact_us.html'>nous contacter</a>.");
define("CN_SPRING_WAREHOUSE_MESSAGE1", "Remarque : La commande ");
define("CN_SPRING_WAREHOUSE_MESSAGE2", "de l'entrepôt CN ne sera pas expédiée avant la Fête du Printemps (le 6 février 2018 - le 20 février 2018).");

define("FS_QTY_CHANGED", "Veuillez effectuer le paiement le plus tôt possible afin que votre commande puisse être traitée à temps. Sinon, l'expédition de votre commande pourrait être retardée en raison du changement de stockage.");

define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | Lundi - Vendredi ');
define("FS_JS_TIT_CHECK1","</br>Temps de Ramassage : ");
define("FS_JS_TIT_CHECK2", "Heure du Pacifique : ");
define("FS_JS_TIT_CHECK3", "lundi - vendredi");
define("FS_JS_TIT_CHECK4", "10:00 - 12:00");
define("FS_JS_TIT_CHECK5", ", 14:00 - 17:00 ");
define("FS_JS_TIT_CHECK6", "Nom sur la Pièce d'Identité");
define("FS_JS_TIT_CHECK7", "Adresse E-mail");
define("FS_JS_TIT_CHECK8", "N° de Téléphone");
define("FS_JS_TIT_CHECK9", "Temps de Ramassage");
define("FS_JS_TIT_CHECK_US","9:30 - 17:30");
define("PICK_UP_ALERT1", "le Nom sur la Pièce d'Identité est nécessaire.");
define("PICK_UP_ALERT2", 'le N° de Téléphone est nécessaire.');
define("PICK_UP_ALERT4", 'Le temps de ramassage est nécessaire.');
define("FS_POPUP_TIT_ALERT2", "Nous ne livrons pas aux boîtes postales");
define("FS_POPUP_TIT_ALERT", "La signature est requise pour la livraison. Nous n'expédions pas à PO Box.");
define("FS_POPUP_TIT_ALERT_NOT_PO", "La signature est requise pour la livraison.");
define("REGITS_FROM_GUEST_EMAIL_ERROR3", "Entrez une adresse e-mail valide.");

//helun 客户提出问提成功
define('FS_MODIFY_EMAIL_MY_CASE_01', 'Votre Cas');
define('FS_MODIFY_EMAIL_MY_CASE_02', 'est confirmé ici.');
define('FS_MODIFY_EMAIL_MY_CASE_03', 'Merci d\'avoir contacté <a href="' . zen_href_link('index') . '" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>, ceci est un email de confirmation pour vous informer que votre demande d\'assistance a bien été reçue sous le numéro de cas - ');
define('FS_MODIFY_EMAIL_MY_CASE_04', 'Notre <a href="' . zen_href_link('index') . '" target="_blank" style="color:#232323; text-decoration:none;">équipe de vente</a> de FS.COM examinera votre cas et vous répondra dans les 12 heures.');
define('FS_MODIFY_EMAIL_MY_CASE_05', 'Si vous avez besoin d\'une aide immédiate, nous vous invitons à contacter <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (888) 468 7419</a> (États-Unis), ou <a href="tel:+33 (1) 82 884 336" style="color:#232323; text-decoration:none;">+33 (1) 82 884 336</a> (France). Vous pouvez également utiliser le chat en ligne pour obtenir une réponse rapide.');
define('FS_MODIFY_EMAIL_MY_CASE_06', 'Cordialement,');
define('FS_MODIFY_EMAIL_MY_CASE_07', 'Équipe du Service Client de <a href="' . zen_href_link('index') . '" target="_blank" style="color:#232323; text-decoration:none;">FS.COM </a>');
define('FS_MODIFY_EMAIL_MY_CASE_08', 'Cher/Chère');
define('FS_MODIFY_EMAIL_MY_CASE_09', 'FS.COM - Numéro de Cas: ');

//客户追问成功
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_01', 'Nouvelle Réponse de');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_02', 'sur le Cas');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_03', 'Cher,');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_04', 'Client');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_05', 'a répondu au cas comme suit :');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_06', '-Vendeurs.Rép :');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_07', '-Ingénieur :');

//request_stock
define("FS_EMAIL_REQUEST_STOCK_01", "FS.COM - Demande de Stock & Numéro de Cas : ");
define("FS_EMAIL_REQUEST_STOCK_02", "Votre demande pour plus de stock d'article #");
define('FS_EMAIL_REQUEST_STOCK_11', ' a été reçue.<br />
									N° de Cas :');
define("FS_EMAIL_REQUEST_STOCK_03", "Cher/Chère ");
define("FS_EMAIL_REQUEST_STOCK_04", "Merci d'avoir soumis la demande de stock. Vos besoins en matière d'inventaire sont très importants pour nous. Une représentante de vente prendra contact avec vous pour suivre vos demandes en détail. En même temps, ");
define("FS_EMAIL_REQUEST_STOCK_05", " l'Équipe de Gestion de l'Inventaire se référera à vos demandes de stock et optimisera notre plan de stock. ");
define('FS_EMAIL_REQUEST_STOCK_06', 'Si vous avez besoin d\'une réponse immédiate, appelez-nous au <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+33 (1) 82 884 336 </a> (France), ou <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Allemagne). Vous pouvez également chat en ligne pour obtenir une réponse rapide.');
define('FS_EMAIL_REQUEST_STOCK_07', 'Cordialement,');
define('FS_EMAIL_REQUEST_STOCK_08', '<a href="' . zen_href_link('index') . '" target="_blank" style="color:#232323; text-decoration:none;">Équipe du Service Client de</a> FS.COM ');
define('FS_EMAIL_REQUEST_STOCK_09', 'Cher/Chère');
define('FS_EMAIL_REQUEST_STOCK_10', 'FS.COM - Numéro de Cas : ');

//2017-12-29   ery  add  sales_service_details
define('SALES_DETAILS_PRINT_LABEL', 'Imprimer l\'Étiquette d\'Expédition Prépayée');
define('SALES_DETAILS_LABEL_MSG', 'FS.COM vous permet d\'imprimer les étiquettes d\'expédition prépayées par n\'importe quel ordinateur qui a accès à l\'internet. 
Veuillez inclure l\'étiquette dans le paquet original et déposer le paquet dans la boîte de dépôt de UPS la plus proche de chez vous.');
define('SALES_DETAILS_PSL', 'Imprimer l\'étiquette d\'expédition');
define('FS_SALES_DETAILS_COMMENT', 'Commentaires (nécessaires)');
define('FS_SALES_DETAILS_REVIEW', 'Informations sur Retour/Remplacement');
define('FS_SALES_DETAILS_NO', 'N° de RMA');
define('FS_SALES_DETAILS_STATUS', 'Statut de RMA');
define('FS_SALES_DETAILS_AMOUNT', 'Montant');
define('FS_SALES_DETAILS_RPI', 'Informations sur le Paiement de Retour');
define('FS_SALES_DETAILS_RA', 'Montant de Remboursement');
define('FS_SALES_DETAILS_RM', 'Méthode de Remboursement');
define('FS_SALES_DETAILS_SAME', 'Même mode de paiement');
define('FS_SALES_DETAILS_NOTE', 'Remarque :  Le montant final du remboursement sera indiqué dans votre e-mail de confirmation de retour.');
define('FS_SALES_DETAILS_PROCESS', 'Processus de RMA');
define('FS_SALES_DETAILS_AWB', 'Mettre à Jour l\'AWB');
define('FS_SALES_DETAILS_ADDRESS', 'Confirmer l\'Adresse');
//2017-12-30  ery    add
define('FS_SALES_INFO_REQUEST', 'Demande de RMA');
define('FS_SALES_INFO_A', 'Une demande de retour ne garantit pas d\'un numéro d\'autorisation, car des articles ne sont remboursables et doivent être vérifiés.');
define('FS_SALES_INFO_PLEASE', 'Veuillez consulter la Politique de Retour. Vous serez informé sous 24 heures si votre retour a été approuvé ou refusé.');
define('FS_SALES_INFO_YOU', 'Vous pouvez soumettre jusqu\'à ');
define('FS_SALES_INFO_WHAT', 'Quelle est la raison du retour ?');
define('FS_SALES_INFO_QI', 'Problèmes de Qualité');
define('FS_SALES_INFO_SI', 'Problèmes de Service');
define('FS_SALES_INFO_OI', 'D\'autres Problèmes');
define('FS_SALES_INFO_WE', "Nous ne pouvons pas offrir des exceptions de politique en réponse aux commentaires");
define('FS_SALES_INFO_ATTA', 'Attachement');
define('FS_SALES_INFO_ALLOW', 'Autoriser les fichiers de type PDF, JPG, PNG.');
define('FS_SALES_INFO_ADD', 'Ajouter des Photos');
define('FS_SALES_INFO_VERIFY', 'Vérifier l\'Adresse de RMA');
define('FS_SALES_INFO_KIND', 'Remarque');
define('FS_SALES_INFO_OUR', 'Notre centre après-vente peut vous appeler, veuillez laisser votre téléphone allumer.');
define('FS_SALES_INFO_I', 'J\'accepte ');
define('FS_SALES_INFO_RP', 'la Politique de Retour');
define('FS_SALES_INFO_PLEASE_AGREE', 'Veuillez accepter Politique de Retour pour continuer.');
define('FS_SALES_INFO_PLEASE_WRITE', 'Veuillez écrire votre problème.');
define('FS_SALES_INFO_ITEMS', 'Les articles ne fonctionnent pas correctement');
define('FS_SALES_INFO_MIS', 'Inadéquation de taille');
define('FS_SALES_INFO_DID', 'Ne correspondre pas à la description');
define('FS_SALES_INFO_RE', 'Recevoir des articles incorrects');
define('FS_SALES_INFO_UN', 'Sans stock');
define('FS_SALES_INFO_DA', 'Endommagé à l\'arrivée');
define('FS_SALES_INFO_NO', 'Ne plus besoin');
define('FS_SALES_INFO_NOT', 'N\'est pas comme prévu');
define('FS_SALES_INFO_WRONG', 'Commande de articles incorrects');
define('FS_MANAGE_ORDERS_PO', 'N° de PO');
define('FS_MANAGE_ORDERS_RE', 'Achat Évalué');
define('FS_MANAGE_ORDERS_TN', 'Numéro de Suivi');
define('FS_MANAGE_ORDERS_MORE', 'Plus');
define('FS_MANAGE_ORDERS_RECORDA', 'enregistrements par page');
define('FS_MANAGE_ORDERS_PURCHASE', "Le numéro de commande ne peut pas être vide");
define('FS_MANAGE_ORDERS_OC', "Remarque ");
define("FS_MANAGE_ORDERS_FILE", "Please upload your PO file.");
//2018-1-3   ery    add
define('FS_SALES_DETAILS_RAE', 'Les Retours Sont Faciles');
define('FS_SALES_DETAILS_NO_LABEL', 'Veuillez suivre l\'ordinogramme ci-dessous pour retourner les articles. Nous vous fournissons une adresse de retour, et vous offrez et payez votre propre étiquette de livraison en utilisant le transporteur que vous voulez. Nous vous remercions de nous donner le numéro de suivi. Pour toutes questions, contactez-nous pour une aide dans l\'immédiat.');
define('FS_SALES_DETAILS_LABEL', 'Veuillez suivre l\'ordinogramme ci-dessous pour retourner les articles. Nous vous fournissons une étiquette de livraison prépayée pour votre paquet retourné et nous l\'apportons dans un lieu de livraison UPS autorisé, cette option vous permet de suivre votre colis durant son retour.');
define('FS_SALES_DETAILS_CR', 'Annuler le RMA');
//2018-1-22    ery  add   sales_service_info页面
define('FS_SALES_INFO_NUMBER', 'Numéro de Série');
define('FS_SALES_INFO_FOR', 'Pour les modules optiques,&nbsp;veuillez nous donner le numéro de série afin que nous puissions mieux identifier et résoudre le problème.');
define('FS_SALES_INFO_BRIEFLY', 'Raconter brièvement le problème');
define('FS_REFUND_PROCESSING', 'Traitement de remboursement');
define('FS_REFUND_APPLICATION', 'Demande de Remboursement');
define('FS_REFUND_SUCCESS_MSG', 'Rembourser avec succès, veuillez vérifier la facture de votre compte de paiement.');
define('FS_REFUND_FAIL_MSG', 'Désolé, votre demande de remboursement est refusée. Si vous avez des questions, n\'hésitez pas à nous contacter.');
define('FS_REFUND_APPMSG', 'Votre demande de remboursement est en traitement, le résultat sera mis à jour ici bientôt.');
define('MANAGE_ORDER_SEARCH_NO', 'N° de commande');
define('BUY_AGAIN', 'Commander à Nouveau');
//tt账户
define('FS_COMMON_TT_BANK_DE', '<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Nom de la Banque Bénéficiaire :  </td>
							<td><b>Sparkasse Freising</b></td>
						  </tr>
						  <tr>
							<td>Nom du Compte Bénéficiaire : </td>
							<td><b> '.FS_DE_COMPANY_NAME.'</b></td>
						  </tr>
						  <tr>
							<td>IBAN : </td>
							<td><b>DE16 7005 1003 0025 6748 88</b></td>
						  </tr>
						  <tr>
							<td>BIC : </td>
							<td><b> BYLADEM1FSI</b></td>
						  </tr>
						  <tr>
							<td>Numéro de Compte : </td>
							<td><b>25674888</b></td>
						  </tr>
                          <tr>
							<td>Adresse de la Banque Bénéficiaire : </td>
							<td><b>Untere Hauptstr.29, 85354, Freising</b></td>
						  </tr>
					  </table>');
define('FIBERSTORE_INFO_WIRE_DE', 'Compte Bancaire Sparkasse');
define('FS_COMMON_TT_BANK', '<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Nom de la Banque Bénéficiaire : </td>
							<td><b>HSBC Hong Kong</b></td>
						  </tr>
						  <tr>
							<td>Nom du Compte Bénéficiaire : </td>
							<td><b>FS.COM LIMITED</b></td>
						  </tr>
						  <tr>
							<td>N° du Compte Bénéficiaire : </td>
							<td><b>817-888472-838</b></td>
						  </tr>
						  <tr>
							<td>Code SWIFT : </td>
							<td><b>HSBCHKHHHKH</b></td>
						  </tr>
						  <tr>
							<td>Adresse de la Banque Bénéficiaire : </td>
							<td><b>1 Queen\'s Road Central, Hong Kong</b></td>
						  </tr>
					  </table>');

//2018-3-19  add   ery  产品详情页Compatible Brands属性未勾选的提示语
define('FS_PRODUCT_INFO_BRAND_PLEASE', 'Veuillez choisir une marque.');
define('FS_PRODUCT_INFO_BRAND_CHOOSE', 'Choisissez une marque');
define('FS_MOBILE_CLOSE','Fermer');

//fairy 整理公共的
// 公共表单
define('FS_TAX_ERROR_EMPTY','Veuillez entrer un numéro de taxe valide. ');
define('FS_SECURITY_ERROR', 'Il y avait une erreur de sécurité.'); // token验证不正确
define('FS_SYSTME_BUSY', 'Le système est occupé. Veuillez réessayer plus tard'); // 异步提交，连接服务器出现error情况
define('FS_ACCESS_DENIED', 'Erreur : Accès refusé.'); //没有权限访问
define('FS_ACCESS_DENIED_1', 'Erreur : code 999.');
define('FS_FORM_REQUEST_ERROR', 'Le système est occupé. Veuillez réessayer plus tard');
define('FS_NON_MANDAROTY', "Facultatif");
define('FS_COMMON_SAVE', "Sauvegarder");
define('FS_COMMON_CANCEL', "Annuler");
define('FS_COMMON_YES', "Oui");
define('FS_COMMON_NO', "Non");
define('FS_COMMON_SUBMIT', "Envoyer");
define('FS_COMMON_PROCESSING', "Traitement");
define('FS_COMMON_EDIT', 'Modifier');
define('FS_COMMON_LESS',"Moins");
define('FS_CONFIRM', 'Confirmer');
define("FS_PLEASE_CHOOSE_ONE", 'Veuillez sélectionner ...');

//验证码 start
define('FS_ENTER_CHARACTER',"Entrez les caractères que vous voyez");
define('FS_IMAGE_REQUIRED_TIP',"Veuillez entrer les caractères montrés dans l'image.");
//验证码-服务器端的验证
define('FS_IMAGE_ERROR_TIP',"Les caractères sont incorrects. Veuillez réessayer.");
define('FS_IMAGE_EXPIRE_TIP',"En l'absence d'opération pendant une longue période, veuillez actualiser les caractères et les entrer à nouveau.");
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP',"Pour mieux protéger votre compte, veuillez entrer de nouveau votre mot de passe et entrer les caractères tels qu'ils sont montrés dans l'image ci-dessous.");
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP',"Pour mieux protéger votre compte, veuillez entrer de nouveau votre e-mail et entrer les caractères tels qu'ils sont montrés dans l'image ci-dessous.");
//验证码 end

// 公共的
define('FS_USERNAME', 'Identifiant');
define('FS_FIRST_NAME', "Prénom");
define('FS_LAST_NAME', "Nom");
define('FS_PASSWORD', "Mot de Passe");
define('FS_EMAIL_ADDRESS', "Adresse E-mail");
define('FS_EMAIL_ADDRESS1', "Adresse e-mail");
define('FS_COMPANY_WEBSITE', "Site d'Entreprise");
define('FS_INDUSTRY', "Industrie");
define('FS_COMPANY_NAME', "Nom d'Entreprise");
define('FS_ENTERPRISE_OWNER_NAME', "Nom du Propriétaire d'entreprise");
define('FS_YOUR_COUNTRY', "Pays/Région");
define('FS_COUNTRY', "Pays/Région");
define('FS_OTHER_COUNTRIES', "Autres pays/régions");
define('FS_SELECT_YOUR_COUNTRY_REGION', 'Sélectionnez votre Pays/Région');
define('FS_SELECT_COUNTRY_REGION', 'Sélectionnez Votre Pays/Région');
define('FS_COMMON_COUNTRY_REGION','Pays/Région');
define('CURRENT','actuel');
define('MAIN_MENU','Menu Principal');
define('FS_SELECT_CURRENCY','Sélectionner la Langue/Monnaie');
define('FS_LANGUAGE_CURRENCY','Langue/Monnaie');
define('FS_PHONE_NUMBER', "Numéro de Téléphone");
define('FS_COMMON_COMPANY', 'Entreprise');
define('FS_FOOTER_COMPANY_INFO', "Entreprise");
define('FS_QTY', 'Quantité');
define('FS_OPTIONAL_COMPANY',' (Optionnel)');
// 公共的
define('FS_OR', 'ou');
define('FS_OTHERS', 'Autres');
define('FS_LOADING', "chargement");
define('FS_SHOW', "afficher");
define('FS_HIDE', "cacher");
define('FS_HELLO', 'Bonjour');
define('FS_COMMON_MORE', 'Plus');
define('FS_COMMON_CUSTOMIZED', 'Personnalisation');
// 公共的
define('FS_COPY', "Copyright");
define('FS_RIGHTS', "Tous Droits Réservés");
define('FS_TERMS_OF_USE', "Conditions d'utilisation");
define('FS_POLICY', "Politique de confidentialité");
define('FS_AGREE_POLICY', 'En cliquant sur le bouton ci-dessous, vous acceptez notre <a href="' . HTTPS_SERVER.reset_url('policies/privacy_policy.html') . '" target="_blank">Politique de Confidentialité & Cookies</a> et <a href="' . HTTPS_SERVER.reset_url('policies/terms_of_use.html') . '" target="_blank">Conditions d’Utilisation</a>.');
define('FS_FOOTER_COOKIE_TIP', 'Nous utilisons les cookies pour vous garantir la meilleure expérience sur notre site web. En poursuivant votre navigation sur ce site, vous acceptez l\'utilisation de cookies. Pour plus d\'infos, veuillez cliquer <a href="' . HTTPS_SERVER.reset_url('policies/privacy_policy.html') . '">Confidentialité et Cookies</a>.');
define('FS_FOOTER_COOKIE_MOBILE_TIP', 'Nous utilisons les cookies pour vous fournir une meilleure expérience d\'achat. En savoir plus sur <a href="' . HTTPS_SERVER.reset_url('policies/privacy_policy.html') . '">Politique de Confidentialité & Cookies </a>.');
define('FS_I_ACCEPT', 'J\'accepte');

define("FS_WAREHOUSE_EU", "Entrepôt DE");
define("FS_WAREHOUSE_US", "Entrepôt U.S.");
define("FS_WAREHOUSE_CN", "Entrepôt CN");
// 2018.4.3 fairy 报价
define('FS_GET_A_QUOTE_BIG', 'Obtenir un devis');
define('FS_GET_A_QUOTE_FREE', 'Échantillon');
define('FS_GET_A_QUOTE', 'Obtenir un devis');
define('FS_REQUEST_DEADLINE', "La demande a été fermée comme prévu. Une version mise à jour sera disponible sous peu, veuillez rester à l'écoute.");
//运费
define("FS_SHIPPING_AREA_BY_WAREHOUSE_CN", "Disponible pour l'expédition rapide de l'entrepôt CN");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_US", "Disponible pour l'expédition rapide de l'entrepôt U.S.");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_EU", "Disponible pour l'expédition rapide de l'entrepôt EU");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_CN", "de l'entrepôt CN");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_US", "de l'entrepôt U.S.");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_EU", "de l'entrepôt EU");
define("FS_BULK_WAREHOUSE", "Expédition de l'entrepôt CN estimée le");
define("FS_TIME_ZONE_RULE_US", " (UTC/GMT+1)");
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}
define("FS_TIME_ZONE_RULE_AU", "(AEST)");
define("FS_JS_TIT_CHECK_AU", "9:30am - 5pm ");
define("FREE_SHIPPING_TEXT1", "Livraison gratuite à partir de 79,00 € (gros articles exclus).");
define("FREE_SHIPPING_TEXT2", "Livraison gratuite à partir de 79,00 $ (gros articles exclus).");
define('FS_LIMIT_MONEY', "Le montant total dépasse la limite, veuillez diviser la commande ou choisir un autre moyen de paiement!");
define('FS_LIMIT_MONEY_15000',"Le montant total dépasse la limite (€ 15 000), veuillez diviser la commande ou choisir un autre moyen de paiement !");
define('FS_LIMIT_MONEY_10000',"Le montant total dépasse la limite (€ 10 000), veuillez diviser la commande ou choisir un autre moyen de paiement !");

//2018-3-15  ery  add  订单上传logo
define('FS_ATTRIBUTE_OEM','Service OEM/ODM');
define('NEWS_FS_ATTRIBUTE_OEM','Service d\'Étiquetage');
define('FS_ATTRIBUTE_NONE','Nul');
define('FS_ATTRIBUTE_DESIGN','Conception d\'Étiquette');

define('FS_ORDER_LOGO_DESIGN',"Téléchargez le Logo de Conception d'Étiquette");
define('FS_ORDER_LOGO_YOUR',"Téléchargez votre logo de conception d'étiquette ou votre Nom de Fournisseur Spécifique & Numéro de Pièce comme référence.");
define('FS_ORDER_LOGO_WE',"Nous allons confirmer l'étiquette avec vous et traiter votre commande. Vous pouvez également nous envoyer votre logo par un courriel.");
define('FS_ORDER_LOGO_UPLOAD',"Télécharger le Logo");
define('FS_ORDER_LOGO_DELETE',"Supprimer l'image ?");
define('FS_ORDER_LOGO_UP_SUCCESS','Fichier de Logo Téléchargé avec Succès !');
define('FS_ORDER_LOGO_DEL_SUCCESS','Supprimer l\'Image avec Succès !');

define('FS_LIVE_CHAT_SERVICE_CONTENT5','Hors Ligne');
//产品详情页
define("FS_FOR_FREE_SHIPPING", "Livraison GRATUITE ");
define("FS_SG_FREE_SHIPPING","Livraison et Installation Gratuites ");
define("FS_SG_NO_FREE_SHIPPING","Installation Gratuite ");
define("FS_FOR_FREE_SHIPPING_US", 'à partir de $MONEY');
define("FS_FOR_FREE_SHIPPING_US_CA", "à partir de C$ 105");
define('FS_FOR_FREE_SHIPPING_USFR_TO_CA', 'à partir de C$ 105');
define("FS_FOR_FREES_SHIPPING_ONE", "Vous en avez besoin demain ");
define("FS_FOR_FREES_SHIPPING_TWO", "Commandez avant ");
define("FS_FOR_FREES_SHIPPING_TIME", "16h (PST)");
define("FS_FOR_FREES_SHIPPING_TIME_UP", "16h (PST)");
define("FS_FOR_FREES_SHIPPING_THREE", "et choisissez Livraison le Lendemain");
define("FS_FOR_FREES_SHIPPING_FOUR", "Expédition :");
define("FS_FOR_FREES_SHIPPING_FIVE", "Obtenez dans les 1-3 jours ouvrables lorsque vous commandez avant <span>16h (PST)</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_CA_UP", "Obtenez dans les 1-3 jours ouvrables lorsque vous commandez avant <span>17h (EST)</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_MX_UP", "Obtenez dans les 1-3 jours ouvrables lorsque vous commandez avant <span>17h (EST)</span>.");
define("FS_FOR_FREES_SHIPPING_SIX", "Vous en avez besoin le mardi ? Choisissez Livraison le Lendemain");
define("FS_FOR_FREE_SHIPPING_DE", "Livraison GRATUITE ");
if (in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF'))) {
    define("FS_FOR_FREE_SHIPPING_DE_MONEY", ' pour achats supérieurs à $MONEY');
} else {
    define("FS_FOR_FREE_SHIPPING_DE_MONEY", ' pour achats supérieurs à $MONEY (hors TVA)');
}
define("FS_FOR_FREES_SHIPPING_FIVE_DE1", " <span>16h (UTC/GMT +2)</span> et choisissez DHL Express");
define("FS_FOR_FREES_SHIPPING_FIVE_DE2", " <span>16h (UTC/GMT +1)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE3", "Livraison plus rapide ? Commandez avant <span>17h (UTC/GMT +2)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE4", " <span>15h (UTC/GMT +1)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE5", " <span>15h (UTC/GMT +1)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE6", "Livraison plus rapide ? Commandez avant <span>11h (UTC/GMT -3)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE7", "Livraison plus rapide ? Commandez avant <span>18h (UTC/GMT +4)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE8", "Livraison plus rapide ? Commandez avant <span>15h (UTC/GMT +1)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE9", "Livraison plus rapide ? Commandez avant <span>17h (UTC/GMT +3)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE10", "<span>16h (UTC/GMT +3)</span> et choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE11", "Livraison plus rapide ? Commandez avant <span>12h (UTC/GMT -2)</span> et choisissez DHL Express");
define("FS_FOR_FREES_SHIPPING_FIVE_DE12", "Expédier le mardi et l'obtenir dans les 1-3 jours ouvrables.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE13", "Vous en avez besoin le mardi ? Choisissez DHL Express");
define("FS_FOR_FREES_SHIPPING_FIVE_DE14", "Vous en avez besoin le mardi ? Choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE15", "Livraison plus rapide ? Choisissez UPS Express Saver");
define("FS_FOR_FREES_SHIPPING_FIVE_DE16", "Livraison plus rapide ? Choisissez DHL Express");
define("FS_FOR_FREE_SHIPPING_GB1", "Livraison GRATUITE");
define("FS_FOR_FREE_SHIPPING_GB3", "à partir de 79£");
define("FS_FOR_FREE_SHIPPING_GB4", "au Royaume-Uni");
define('FS_ITEM_LOCATION', 'Location d\'article:');
define('FS_SEATTLE_WASHINGTON', 'Seattle, États-Unis');
define('FS_SEATTLE_EU', 'Munich, Allemagne');
define('FS_SEATTLE_CN', 'Wuhan, Chine');

//详情页Compatible Brands提示 dylan 2019.11.18
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01','ex. : Cisco N9K-C9396PX vers Juniper MX960');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02','ex. : Cisco N9K-C9396PX QSFP+ vers Juniper MX960 SFP+');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03','ex. : Cisco N9K-C9396PX QSFP+ vers Juniper EX4200 XFP');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04','ex. : Cisco N9K-C9396PX QSFP28 vers Juniper QFX5200 SFP28');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05','ex. : Cisco Nexus 5696Q CXP vers Juniper MX960 QSFP+');

define('FS_SELECT_TYPE','Les spécifications les plus souvent sélectionnées par nos clients.');
define('FS_SELECT_DEFAULT','Par Défaut');
define('FS_SELECT_CUSTOMIZE','Personnalisation');
define('FSCHOOSE_SPECI','Sélectionnez les Spécifications : ');


//add by quest 2019-03-11  // 2019 3.18 po产品 shipping弹窗 pico
define("FS_FOR_FREE_SHIPPING_PRE_ORDER","à partir de MONEY");

if ($_SESSION['countries_iso_code'] == 'ca') {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', "Livraison gratuite pour les articles en précommande à partir de MONEY");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Pour bénéficier de la livraison gratuite, ajoutez au moins MONEY d'articles en Précommande dans votre Panier. Tout article en Précommande avec la mention « Livraison Gratuite » sur cette page est éligible et contribue au minimum de votre commande de livraison gratuite.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "Le délai de traitement des articles en Précommande sera d'environ 15 jours ouvrables. Nous les expédierons après la production et des tests approfondis. La vitesse de livraison dépendra de l'option de livraison que vous aurez choisie lors du paiement.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "Le service de précommande peut vous aider à planifier votre projet librement et de manière plus flexible. En savoir plus sur <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>le service de Pré-commande</a>.");
}
else{
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', "Livraison gratuite pour les articles en précommande à partir de MONEY");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "Pour bénéficier de la livraison gratuite, ajoutez au moins MONEY d'articles en Précommande dans votre Panier. Tout article en Précommande avec la mention « Livraison Gratuite » sur cette page est éligible et contribue au minimum de votre commande de livraison gratuite.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "Le délai de traitement des articles en Précommande sera d'environ 15 jours ouvrables. Nous les expédierons après la production et des tests approfondis. La vitesse de livraison dépendra de l'option de livraison que vous aurez choisie lors du paiement.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "Le service de précommande peut vous aider à planifier votre projet librement et de manière plus flexible. En savoir plus sur <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>le service de Pré-commande</a>.");
}

//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Garantie & Retour');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Expédition Rapide en Asie du Sud-Est');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','<p>Si les articles ne fonctionnent pas comme prévu, la garantie de FS peut permettre le retour, le remplacement ou la réparation des articles.</p><br/>
<p>Nous offrons des services de retour, de remboursement et de remplacement pour la plupart des articles en stock dans les 30 jours. S\'il y a des problèmes de qualité pendant la période de garantie, nous offrons un service de réparation gratuit.</p><br/>
<p>Pour les produits consommables, il n\'y a pas de période de garantie et service de réparation gratuit. Si vous rencontrez des problèmes de qualité après la réception des produits, n\'hésitez pas à nous contacter, FS s\'en occupera dans le plus bref délai. Consultez la page <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">Politique de Retour</a> et <a href="'.reset_url("/policies/warranty.html").'" target="_blank">Garantie</a> pour plus de détails.</p>');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Les commandes supérieures à $MONEY pour les articles éligibles peuvent bénéficier du service de livraison gratuite. Pour plus d\'informations, veuillez consulter la page <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Expédition & Livraison</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS propose multiples options d\'expédition pour respecter votre calendrier ou votre budget. Et les commandes de stock seront expédiées dans les 24 heures ouvrables après la confirmation de la commande. Pour plus d\'informations, veuillez visiter la page <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Expédition & Livraison</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Pour les articles en Précommande, les commandes supérieures à $MONEY peuvent bénéficier du service de livraison gratuite. Pour plus d\'informations, veuillez visiter la page <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Expédition & Livraison</a>.</div>');


define("FS_SHIPPING_POLICY_US","La date de livraison s'applique aux articles en stock achetés avant 17h EST pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_CA","La date de livraison s'applique aux articles en stock achetés avant 17h pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_MX","La date de livraison s'applique aux articles en stock achetés avant 16h pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_NZ","La date de livraison s'applique aux articles en stock achetés avant 15h (AEST/AEDT) pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_AU","La date de livraison s'applique aux articles en stock achetés avant 15h (AEST/AEDT) pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_GB","La date de livraison s'applique aux articles en stock achetés avant ".FS_SUMMER_OR_WINTER_TIME." pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_DE","La date de livraison s'applique aux articles en stock achetés avant ".(SUMMER_TIME ? '16h30 (UTC/GMT+2)' : '16h30 (UTC/GMT+1)')." pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_CN","La date de livraison s'applique aux articles en stock achetés avant 17h pendant les jours ouvrables. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_SG","La date de livraison s'applique aux articles en stock achetés avant 15h30 (GMT+8) pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");
define("FS_SHIPPING_POLICY_RU","La date de livraison s'applique aux articles en stock achetés avant 10h30 (UTC/GMT+3) pendant les jours ouvrables. Si la quantité demandée est supérieure aux stocks, les articles seront expédiés dans une autre livraison, sans frais supplémentaires. Pour plus de détails, veuillez consulter la page de paiement.");

define("FS_FESTIVAL1","Jour Férié en Allemagne le");
define("FS_FESTIVAL2"," FS.COM GmbH sera de retour le ");
define("FS_FESTIVAL3"," pour traiter les commandes précédentes.");
define("FS_FESTIVAL4","st");
define("FS_FESTIVAL5","nd");
define("FS_FESTIVAL6","Jour Férié aux États-Unis le");
define("FS_FESTIVAL7"," pour traiter les commandes précédentes.");
define("FS_FESTIVAL8"," FS.COM sera de retour le");
define("FS_FESTIVAL8_01"," FS.COM sera de retour le");
define("FS_FESTIVAL9","");
define("FS_FESTIVAL10","");
/******meta标签语言包*****/
define("FS_META_PRO_01", "Achetez  ");
define("FS_META_PRO_02", " chez le fournisseur de solutions de centres de données, de réseau d'entreprise et de réseau FAI au meilleur prix.");
/******end*****/
//2017-12-14  ery  add  manage_orders和account_history_info页面reorder提示语
define('FS_COMMON_REORDER_CLOSE', 'Désolé, les articles suivants ont peut-être été supprimés et ne sont plus disponibles.');
define('FS_COMMON_REORDER_CUSTOM', "Ce sont des produits personnalisés, veuillez re-choisir les caractères dans l'introduction du produit.");
define('FS_COMMON_REORDER_SKIP', 'Passer et Continuer');

define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG', '(GST Comprise)');

//新增加
define('FS_CHECK_OUT_TAX_AU', 'GST');
define('FS_CHECK_OUT_EXCLUDING_AU', '(Hors TPS)');
define('FS_CHECK_OUT_INCLUDING_AU', '(GST Comprise)');
define("FS_WAREHOUSE_AREA_AU", "Expédier de l'Entrepôt AU");
define("CHECKOUT_TAXE_AU_TIT", "À propos de la TPS et des Droits de Douane");
define("CHECKOUT_TAXE_AU_CONTENT", "Conformément à la<em class='alone_font_italic'> Loi de 1999 sur le Nouveau Système Fiscal (Taxe sur les Produits et Services)</em>, pour l'expédition à partir de l'entrepôt de Melbourne, FS.COM PTY LTD est obligé de facturer la GST sur toutes les commandes livrées à des endroits en Australie. Tous les articles de notre catégorie sont soumis au taux normal de la GST de 10% en conséquence. Une fois que vous aurez complété les informations de la commande, vous pourrez voir le montant total, y compris la GST applicable, dans le récapitulatif de la commande. </br></br>Pour les commandes dont les produits ne sont pas disponibles dans notre entrepôt de Melbourne, nous pouvons les expédier à votre arrivée à Melbourne après les avoir transférés de l'entrepôt d'Asie. </br></br>Pour les commandes contenant des articles lourds ou surdimensionnés, nous vous les expédierons directement à partir de notre entrepôt d'Asie et ne facturerons aucune GST. Toutefois, ces colis peuvent être soumis à des frais d'importation ou à des droits de douane, selon les Lois. Tous les droits et tarifs éventuels causés par le dédouanement devraient être supportés par vous-même.");
define("FREE_SHIPPING_TEXT3", "Livraison GRATUITE à partir de AU$ 99.");
define("FS_WAREHOUSE_AU", "Entrepôt AU");
define("FS_WAREHOUSE_SG","Entrepôt SG");
define("FS_WAREHOUSE_RU","Entrepôt RU");
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU', 'TPS');
define('PRODUCTS_SHIP_TODAY', "Expédier Aujourd'hui");
define('ITEM_LOCATION_AU', 'Melbourne, Australie ');
//define('FS_COMMON_WAREHOUSE_AU', 'FS.COM Pty Ltd<br>
//			ABN 71 620 545 502 <br>
//			57-59 Edison Rd,<br>
//Dandenong South,<br>
//VIC 3175,<br>
//Australia Tél: +61 3 9693 3488');


// 2018.7.23 fairy 底部反馈弹窗
define('FS_GIVE_FEEDBACK', 'FS Commentaires');
define('FS_GIVE_FEEDBACK_TIP', 'Merci de visiter FS. Vos commentaires nous aideront à offrir à nos clients une meilleure expérience.');
define('FS_RATE_THIS_PAGE', 'Veuillez évaluer votre expérience avec FS*');
define('FS_NOT_LIKELY', 'Pauvre');
define('FS_VERY_LIKELY', 'Excellent');
define('FS_TELL_US_SUGGESTIONS', 'Veuillez sélectionner un sujet pour votre commentaire.*');
define('FS_ENTER_COMMENTS', 'Dites-nous ce que vous en pensez.');
define('FS_PROVIDE_EMAIL', 'Si vous souhaitez recevoir une réponse de notre part, veuillez laisser vos coordonnées.');
define('FS_PROVIDE_EMAIL_TIP', 'Remarque : Cette information NE sera PAS utilisée à d\'autres fins. Nous respectons votre vie privée.');
define('FS_FEEDBACK_THANKYOU', 'Vous avez partagé ce produit avec succès.');
define('FS_PRO_SHARE_EMAIL', 'Votre message a été envoyé.');
define('FS_FEEDBACK_THANKYOU_TIP_01','Votre avis est important pour nous. Nous examinerons vos commentaires afin de pouvoir améliorer le site web de FS pour vos visites futures.');
define('FS_FEEDBACK_THANKYOU_TIP_02','Votre satisfaction est notre priorité et nous continuerons à vous offrir un service et une expérience d\'achat de haute qualité.');
define('FS_CHOOSE_ONE', 'Veuillez en choisir un');
define('FS_WEB_ERROR', 'Erreur du site');
define('FS_FEEDBACK_PRODUCT', 'Produit');
define('FS_ORDER_SUPPORT', 'Support de commande');
define('FS_TECH_SUPPORT', 'Support technique');
define('FS_SITE_SEARCH', 'Recherche sur le site');
define('FS_FEEDBACK_OTHER', 'Autre');
define('FS_FEEDBACK_NAME', 'Nom');
define('FS_FEEDBACK_EMAIL', 'Adresse E-mail');
//新增加
define('FS_LOGIN_REGIST_PWD_REQUIRED_TIP_COMMON', "Le mot de passe est requis.");
define('FS_LOGIN_REGIST_EMAIL_FORMAT_TIP_COMMON', "Entrez une adresse email valide (par exemple : someone@gmail.com)");
define('FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_COMMON', "L\'adresse e-mail est requis.");
define('FS_LOGIN_REGIST_PWD_ERROR_TIP_COMMON', "Votre mot de passe n'est pas correct, veuillez le vérifier à nouveau !");
define('FS_LOGIN_REGIST_EMAIL_NOT_FOUND_ERROR_COMMON', "Erreur : L'Adresse Email n'a pas été trouvée, veuillez réessayer.");
define('FS_LOGIN_REGIST_LOGIN_BANNED_COMMON', 'Erreur : Accès refusé.');
define("FS_LOGIN_POPUP1", "Session Expirée");
define("FS_LOGIN_POPUP2", "Votre session a expiré et vous avez été déconnecté.");
define("FS_LOGIN_POPUP3", "Entrez à nouveau votre mot de passe pour continuer.");
define("FS_LOGIN_POPUP4", "Adresse E-mail");
define("FS_LOGIN_POPUP5", "Pas Vous ?");
define("FS_LOGIN_POPUP6", "Mot de Passe");
define("FS_LOGIN_POPUP7", "Mot de passe oublié ?");
define("FS_LOGIN_POPUP8", "afficher");
define("FS_LOGIN_POPUP9", "cacher");
define("FS_ADDRESS_EDIT_TITLE", "Modifiez l'Adresse");
define('FS_CHECK_OUT_TAX_DE', 'TVA ');
define('FS_COMMON_WAREHOUSE_US_ES', 'FS.COM INC<br>
			380 Centerpoint Blvd<br>
			New Castle, DE 19720,<br>
			United States<br>
			Tél : +1 (888) 468 7419');
define("GLOBAL_TEXT_NAME", "Nom de Carte");
define("FS_HSBC_INFO1", "Nom de la Banque ");
define("FS_HSBC_INFO2", "Nom du Compte ");
define("FS_HSBC_INFO3", "IBAN :");
define("FS_HSBC_INFO4", "BIC :");
define("FS_HSBC_INFO5", "Numéro du Compte :");
define("FS_HSBC_INFO6", "Adresse de la Banque Bénéficiaire :");
define("FS_CHECKOUT_ERROR29", "Veuillez modifier votre adresse (entrez le code postal valide).");
define("FS_ADDRESS_MESSAGE3", "Adresse Postale");
define("FS_ADDRESS_MESSAGE4", "Appartement, chambre, bâtiment, étage, etc.");
define("CHECKOUT_TAXE_CN_FRONT1", "Toutes les commandes expédiées de notre entrepôt CN vers la Chine continentale, HK, Macao et Taiwan peuvent profiter de la Livraison GRATUITE (SF Express par défaut vers la Chine continentale, et Fedex IE vers HK, Macao et Taiwan).");
define("CHECKOUT_TAXE_CN_FRONT2", "Conformément à la loi de la République populaire de Chine sur l'Administration de la Perception Fiscale (ci-après dénommé LATC), FS.COM est obligé de facturer 13% de TVA sur toutes les commandes livrées en Chine continentale. Et pour les commandes expédiées à HK, Macao et Taiwan, aucune TVA n'est perçue, mais des frais d'importation ou de douane peuvent être facturés selon les lois/règlements des destinations particulières. Des frais supplémentaires de dédouanement seront perçus pour le destinataire.");
define("CHECK_SET_DEFAULT", "Définir par défaut");
define("CHECK_SEARCH", "Cherchez");

//add ternence 2018-7-9
define('FS_SHOP_CART_ALERT_JS_50', 'Article(s)');
define('FS_SHOP_CART_ALERT_JS_51', 'Sous-total (');
define('FS_SHOP_CART_ALERT_JS_52', ') :');
define('FS_SHOP_CART_ALERT_JS_53', 'Récapitulatif de Commande');
define('FS_SHOP_CART_ALERT_JS_54', '(Frais de Livraison et TVA exclus)');
define('FS_SHOP_CART_ALERT_JS_55','Votre Nom');
define('FS_SHOP_CART_ALERT_JS_55_1','Nom du Destinataire');
define('FS_SHOP_CART_ALERT_JS_56','Votre E-mail');
define('FS_SHOP_CART_ALERT_JS_56_1',"Séparer plusieurs destinataires avec des ';'");
define('FS_SHOP_CART_ALERT_JS_57', '500 caractères maximum.');
define('FS_SHOP_CART_ALERT_JS_58', 'Panier Enregistré');
define('FS_SHOP_CART_ALERT_JS_59', 'Votre commande répond aux critères de livraison GRATUITE');
define('FS_SHOP_CART_ALERT_JS_60', 'Expédier vers');
define('FS_SHOP_CART_ALERT_JS_61', 'Livraison GRATUITE pour toute commande à partir de 79$ dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_61_CA', 'Livraison GRATUITE pour toute commande à partir de C$ 105 dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_62', 'Pour bénéficier de la livraison gratuite, ajoutez ');
define('FS_SHOP_CART_ALERT_JS_63', ' des articles admissibles. ');
define('FS_SHOP_CART_ALERT_JS_64', 'Votre commande répond aux critères de Livraison GRATUITE ');
define('FS_SHOP_CART_ALERT_JS_65', 'Livraison GRATUITE pour toute commande à partir de 79€ dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_66', 'Livraison GRATUITE pour toute commande à partir de 79£ dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_67', 'Livraison GRATUITE pour toute commande à partir de 79€ dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_68', 'Livraison GRATUITE pour toute commande à partir de 79£ dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_69', 'Paiement Sécurisé');
define('FS_SHOP_CART_ALERT_JS_70', 'Continuer Vos Achats');
define('FS_SHOP_CART_ALERT_JS_71', 'Livraison GRATUITE pour toute commande à partir de AUD99$ dans toutes les catégories de produits.');
define('FS_SHOP_CART_ALERT_JS_72', 'Enregistrer le Panier');
define('FS_SHOP_CART_ALERT_JS_72_1', 'Enregistrer le Panier');
define('FS_SHOP_CART_ALERT_JS_73', 'Partager votre panier');
define('FS_SHOP_CART_ALERT_JS_74', 'Imprimer');
define("FS_SHOP_CART_ALERT_JS_76_1","Envoyer");
define("FS_AJAX_DELETE1", "a été supprimé avec succès de votre panier. ");
define("FS_AJAX_DELETE2", "Annuler");

define('FS_SHARE_CART_06','Responsable de Compte. ');
//add by helun
define('FS_AGAINST_BPAY_01', 'Date de Commande :');
define('FS_AGAINST_BPAY_02', 'Montant Total :');
define('FS_AGAINST_BPAY_03', 'Votre achat a été divisé en');
define('FS_AGAINST_BPAY_04', 'commandes.');
define('FS_AGAINST_BPAY_05', 'Expédition prévue');
define('FS_AGAINST_BPAY_06', 'Expédié de');
define('FS_AGAINST_BPAY_07', 'Commande');
define('FS_AGAINST_BPAY_08', 'de');
define('FS_AGAINST_BPAY_09', 'Procéder à');
define('FS_AGAINST_BPAY_10', 'Sparkasse Freising');
define('FS_AGAINST_BPAY_11', 'FS.COM GmbH');
define('FS_AGAINST_BPAY_12', 'DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13', 'BYLADEM1FSI');
define('FS_AGAINST_BPAY_14', '25674888');
define('FS_AGAINST_BPAY_15', 'Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16', '817-888472-838');
define('FS_AGAINST_BPAY_17', 'HSBCHKHHHKH');
define("FS_COMMON_CHECKOUT_HSBC", "Après avoir effectué le paiement, il sera généralement reçu par FS entre 1-3 jours ouvrables. La commande sera traitée une fois que le paiement a été confirmé.");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","Veuillez indiquer votre numéro de commande FS lors du paiement afin que votre commande puisse être traitée à temps. Généralement, le paiement sera reçu entre 1 et 3 jours ouvrables. Le stock ne sera pas réservé avant la confirmation de l'envoi.");

define('FS_TOTAL_SAVINGS', 'Total Savings');

//2018-8-29  credit付款页面
define('FS_CREDIT_CARD_NUMBER', 'Numéro de Carte');
define('FS_CREDIT_EXPIRY_DATE', "Date d’Expiration");
define('FS_CREDIT_CONTINUE', 'Continuer');
define("FS_WAREHOUSE_AREA_36", "Expédition de l'Entrepôt Seattle");
define("FS_WAREHOUSE_AREA_37", "Expédition de l'Entrepôt Delaware");
define("FS_LIVE_CHAT_CHECKOUT", "Besoin d'aide ? Contactez-nous par l'option <a  href='javascript:;' onclick='LC_API.open_chat_window();return false;'>Chat en ligne</a> ou par téléphone à ");
define("FS_WAREHOUSE_SEA", "Entrepôt Seattle");
define("FS_WAREHOUSE_DEL", "Entrepôt Daleware");
define("FS_COMMON_CHECKOUT_HSBC","Après avoir effectué le paiement, il sera généralement reçu par FS entre 1-3 jours ouvrables. La commande sera traitée une fois que le paiement a été confirmé.");

//2018-8-31   shoppint_cart 页面分享
define('FS_SHARE_AGAIN', 'Partager à Nouveau');
define('HEADER_TITLE_CLEARANCE', 'Déstockage');

define("FS_PO_ADDRESS_01", 'Soumettez-vous cette adresse comme adresse de bon de commande ?');
define("FS_PO_ADDRESS_02", 'Votre demande a été soumise avec succès, veuillez attendre la notification');
define("FS_PO_ADDRESS_03", 'Remarque');
//define("FS_PO_ADDRESS_04", 'Après avoir passé cette commande avec succès, il faudra vérifier la sécurité de votre commande, car l\'adresse de livraison n\'est pas celle avec l\'icône "PO".');
define("FS_PO_ADDRESS_04", 'Après avoir passé cet achat avec succès, la sécurité de votre commande doit être vérifiée, car l\'adresse de livraison n\'est pas celle avec l\'icône “PO”.');
define("FS_PO_ADDRESS_05", "confirmer l'adresse");
define("FS_PO_ADDRESS_06", "sélectionner de nouveau l'adresse");
define("FS_PO_ADDRESS_07", 'Modifier la limite de crédit');
define("FS_PO_ADDRESS_08", 'Augmenter le montant');
define("FS_PO_ADDRESS_09", 'Oui');
define("FS_PO_ADDRESS_10", 'Non');
define("FS_PO_ADDRESS_11", 'Votre crédit restant est insuffisant, souhaitez-vous augmenter la limite de crédit ?');
define('FS_ADDRESS_SET_PO_SUCCESS', "Votre adresse de PO a été soumise, veuillez attendre l'approbation");


/*
 * 产品详情页 客户分享产品邮件
 */
define('FS_EMAIL_PRODUCT_SHARE1', 'Votre ami vous partage cet article seulement via ');
define('FS_EMAIL_PRODUCT_SHARE2', 'FS.COM.');
define('FS_EMAIL_PRODUCT_SHARE3', 'Je pense que vous pourriez vous intéresser à cette page de ');
define('FS_EMAIL_PRODUCT_SHARE4', 'En Savoir Plus');
define('FS_EMAIL_PRODUCT_SHARE5', 'Sincèrement,');
define('FS_EMAIL_PRODUCT_SHARE6', 'FS.COM');
define('FS_EMAIL_PRODUCT_SHARE7', ' équipe de Service Clients ');
define('FS_EMAIL_PRODUCT_SHARE8', 'Cet e-mail a été envoyé par ');
define('FS_EMAIL_PRODUCT_SHARE9', 'en utilisant le service de Partager Avec Un Ami de FS.COM. à la suite de la réception de ce message, vous ne recevrez aucun message non sollicité de la part de ');
define('FS_EMAIL_PRODUCT_SHARE10', zen_href_link('index'));
define('FS_EMAIL_SHARE_TITLE_ONE', 'FS.COM - Votre ami ');
define('FS_EMAIL_SHARE_TITLE_TWO', ' veut que vous voyiez cet article.');
define('FS_EMAIL_PRODUCT_SHARE11', 'Message de ');
define('FS_EMAIL_PRODUCT_SHARE13', ',learn more about our');
define('FS_EMAIL_POLICY_AGREE', '');
define('FS_EMAIL_POLICY_2', "");
define('FS_EMAIL_PRODUCT_USING', ' using ');

//站点融合整理 邮件标点符号整理成常量
define('FS_EMAIL_COMMA', ',');   //逗号
define('FS_EMAIL_POINT', '.'); //句号
define('FS_EMAIL_PERIOD', '.');
define('FS_EMAIL_MARK', '!');//感叹号
define('FS_EMAIL_PAUSE', ',&nbsp;');  //日语中的逗号有时是顿号，其他语种是逗号
//产品详情页加入购物车后弹出框
define('FS_CONTINUE_SHOPPING', 'Continuer Vos Achats');
define('FS_CUSTOMERS_ALSO', 'Les clients ont également acheté ces produits.');

//au单独的RMA地址
define('FIBER_CHECK_ANZ','Compte Bancaire ANZ :');
define('FIBER_CHECK_ACCOUNT','Nom du Compte :');
define('FIBER_CHECK_PTY','FS.COM Pty Ltd');
define('FIBER_CHECK_BSB','BSB : ');
define('FIBER_CHECK_013','013160');
define('FIBER_CHECK_ACCOUNT_NO','Numéro du Compte :');
define('FIBER_CHECK_4167','416794959');
define('FIBER_CHECK_SWIFT_CODE','Code SWIFT :');
define('FIBER_CHECK_ANZBAU3M','ANZBAU3M');
define('FIBER_CHECK_BANK','Adresse de la Banque Bénéficiaire :');
define('FIBER_CHECK_ST_VIC','230 Swanston St, Melbourne, VIC, 3000');
define('FIBER_CHECK_TITLE_AU','To pay via direct deposit, please use the following bank account information:');

define("FS_PICK_UP_AT_WAREHOUSE","Retirer Moi-Même ");
define("FS_TIME_ZONE_RULE_US_ES","(EST)");
define("FS_TIME_ZONE_ADDRESS_US","<span>Adresse de l'Entrepôt :</span> 820 SW 34th Street Bldg W7 Suite H Renton, EWA 98057, États Unis | +1 (877) 205 5306 ");
define("FS_TIME_ZONE_ADDRESS_DE","<span>Adresse de l'Entrepôt :</span> NOVA Gewerbepark Building 7, Am Gfild 7, E85375 Neufahrn Allemagne | +49 (0) 8165 80 90 517 ");
define("FS_TIME_ZONE_ADDRESS_US_ES","<span>Adresse de l'Entrepôt :</span> 380 Centerpoint Blvd, New Castle, EDE 19720, États Unis | +1 (888) 468 7419 ");

//产品详情页产品加入购物车后的弹出框信息
define('FS_JUST_ADDED', 'Vous avez ajouté ');
define('FS_JUST_ITEM', ' article');
define('FS_JUST_ITEMS', ' articles');
define('FS_CART_QTY', 'Qté :');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'Partager le Panier');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'Imprimer le Panier');
define("FS_SHOP_CART_ALERT_JS_77","Voir le Panier");

//hsbc
define('FS_SUCCESS_YOUR_NEXT', 'Votre prochaine étape consiste à effectuer votre paiement par Virement Bancaire et soumettre vos informations de paiement.');
define('FS_SUCCESS_WIRE', 'Virement Bancaire');
define('FS_SUCCESS_ORDER', 'Imprimer la Commande');
define('FS_SUCCESS_DETAIL', 'Détails de Bénéficiaire de Virement Bancaire');
//define('FS_SUCCESS_BANK_NAME','Nom du Compte Bénéficiaire ');
//define('FS_SUCCESS_HSBC','HSBC Hong Kong');
//define('FS_SUCCESS_AC_NAME','Banque Bénéficiaire ');
//define('FS_SUCCESS_CO','Sparkasse Freising');
//define('FS_SUCCESS_AC_NO','IBAN ');
//define('FS_SUCCESS_TEL','DE16 7005 1003 0025 6748 88');
//define('FS_SUCCESS_SWIFT','BIC ');
//define('FS_SUCCESS_HK','BYLADEM1FSI');
//define('FS_SUCCESS_BANK_ADRESS','Numéro de Compte ');
//define('FS_SUCCESS_ROAD','25674888');
define('FS_SUCCESS_BANK_NAME', 'Banque Bénéficiaire :');
define('FS_SUCCESS_HSBC', 'HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME', 'Nom du Compte Bénéficiaire :');
define('FS_SUCCESS_CO', 'FS.COM LIMITED');
define('FS_SUCCESS_AC_NO', 'IBAN :');
define('FS_SUCCESS_TEL', '817-888472-838');
define('FS_SUCCESS_SWIFT', 'BIC ');
define('FS_SUCCESS_HK', 'HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS', 'Adresse de la Banque Bénéficiaire :');
define('FS_SUCCESS_ROAD', '1 Queen\'s Road Central, Hong Kong');
//UK
define('FIBER_CHECK_ANZ_UK','HSBC Bank Account');
define('FS_SUCCESS_BANK_NAME_UK','Beneficiary Bank Name');
define('FS_SUCCESS_HSBC_UK','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME_UK','Beneficiary A/C Name');
define('FS_SUCCESS_CO_UK','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO_UK','Beneficiary A/C NO');
define('FS_SUCCESS_TEL_UK','817-888472-838');
define('FS_SUCCESS_SWIFT_UK','SWIFT Address');
define('FS_SUCCESS_HK_UK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS_UK','Beneficiary Bank Address');
define('FS_SUCCESS_ROAD_UK','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR', 'Adresse de la Banque Bénéficiaire ');
define('FS_SUCCESS_NO', 'Untere Hauptstr.29, 85354, Freising');

//2018-9-15  add  ery  游客结算页面账号已存在提示语
define('FS_CHECKOUT_GUEST_LOG_MSG', 'L\'adresse e-mail existe dans notre système, connectez-vous directement. <a href="' . zen_href_link('login') . '">Se connecter   »</a>');
//推荐版块标题
define('FS_PRODUCT_RELATED', 'Produits Connexes');
//产品详情货币单位
define('FS_PRODUCT_PRICE_EA', '/pc');
//产品详情页 选择产品属性
define('PLEASE_SELECT', 'Please select ...');

//2018-9-11
define('EMAIL_OVER79_FREE_DELIVERY', '<tr><td style="font-size:12px;font-weight: 400;padding-top: 35px;">Les commandes d\'articles éligibles de plus de %s peuvent bénéficier d\'une livraison gratuite. Nous espérons vous revoir bientôt.</td></tr>');
define('FS_TRACK_ORDER', 'Vous pouvez suivre l\'état de votre commande en cliquant sur ');
define('FS_TRACK_MY_ORDERS', 'Mes Commandes');
define('FS_ORDER_COMMENTS', 'Commentaires de Commande : ');
define('FS_TRACK_PO_ORDER', 'Vous pouvez suivre l\'état de votre commande dans ');
define('FS_TRACK_ACCOUNT_CENTER', 'le centre du compte');

//print_order & print_main_order
define('FS_PRINT_ORDER_TEL', 'Tél : ');
define('FS_PRINT_ORDER_NUM', 'Numéro de TVA : ');
define('FS_PRINT_ORDER_CREDIT', 'Carte de Crédit/Débit');
define('FS_PRINT_ORDER_PURCHASE', 'Bon de Commande');
define('FS_PRINT_ORDER_BANK', 'Virement Bancaire');
define('FS_PRINT_ORDER_WESTERN', 'Western Union');
define('FS_PAY_WAY_PAYPAL','Paypal');
define('FS_PAY_WAY_PAYEEZY','payeezy');
define("FS_CHECKOUT_NEW42", "Chèque Électronique");
define('FS_PRINT_ORDER_FREE', 'Gratuit');

/**
 *评论邮件
 */
define('FS_EMAIL_TO_US_DEAR','Cher/Chère ');
define('EMAIL_MESSAGE_TITLE_REVIEWS',' Commentaire Reçu');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS-Merci pour vos commentaires.');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','Nous sommes très reconnaissants de vos commentaires et ravis d\'entendre que vous avez eu une bonne expérience.');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','Ces commentaires nous aident à comprendre ce que nous faisons et ce que nous pouvons faire pour améliorer continuellement notre expérience client.');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','Nous sommes désolés que votre expérience ne corresponde pas à vos attentes. C\'était un cas peu commun et nous ferons mieux plus tard.');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','Soyez assuré que votre responsable de compte vous contactera dans les 48 heures. Nous espérons sincèrement résoudre tous les problèmes avec vous dès que possible.');
define('FS_EMAIL_REVIEWS_THANKS','Merci');
define('FS_EMAIL_REVIEWS_TEAM','L\'équipe FS');
define('FS_EMAIL_REVIEWS_WELL_HEADER','Merci pour votre commentaire et nous continuerons à offrir les meilleurs produits.');
define('FS_EMAIL_REVIEWS_BAD_HEADER','Merci pour votre commentaire et nous vous aiderons à résoudre le problème dès que possible.');

//客户取消订单邮件
define('FS_CANCEL_ORDER', "Votre commande#");
define('FS_CANCEL_ORDER_1', "a été annulée");
define('FS_CANCEL_ORDER_2', "Comme vous l'avez demandé, nous avons annulé votre commande réservée# ");
define('FS_CANCEL_ORDER_3', ". Nous regrettons qu'elle n'ait pas marché et nous espérons que vous allez bientôt faire des achats avec nous.");
define('FS_CANCEL_ORDER_4', "Si vous avez des questions, veuillez <a href='" . zen_href_link('contact_us', '', 'SSL') . "'>nous contacter</a>. Nous espérons vous revoir bientôt !");
define('FS_CANCEL_ORDER_5', "Adresse E-mail du Client : ");
define('FS_CANCEL_ORDER_6', "N° de Commande : ");
define('FS_CANCEL_ORDER_7', "Raison : ");
define('FS_CANCEL_ORDER_8', 'Commande# ');

//live chat留言邮件
define('FS_LIVE_CHAT_MAIL', 'Merci d’avoir contacté <a href="' . zen_href_link('index', '', 'SSL') . '"> FS.COM </a>. C\'est un e-mail de confirmation pour vous informer que votre demande de soutien a été reçue. Nous reverrons votre message et vous répondrons dans les 12 heures.');
define('FS_LIVE_CHAT_MAIL_1', 'FS.COM - E-mail de Confirmation du Message ');
define('FS_LIVE_CHAT_MAIL_2', 'Votre Type de Service : ');
define('FS_LIVE_CHAT_MAIL_3', 'Votre Message : ');

define("FS_OVERNIGHT_TITLE", "La commande dont le paiement est reçu après l'heure limite (17h00 EST) sera expédiée le jour ouvrable suivant. La livraison ne se fera que les jours ouvrables.");
define("FS_OVERNIGHT_TITLE_UP", "La commande dont le paiement est reçu après l'heure limite (17h00 EST) sera expédiée le jour ouvrable suivant. La livraison ne se fera que les jours ouvrables.");

define("FS_ECHECK_NOTICE","* Nous n'acceptons que les chèques électroniques émis par les banques américaines. Le traitement du fonds peut prendre 1-2 jours ouvrables.");
define("FS_ECHECK_BANK_ACCOUNT","Nom du Compte Bancaire");
define("FS_ECHECK_BANK_ACCOUNT_NUMBER","Numéro du Compte Bancaire");
define("FS_ECHECK_BANK_ACCOUNT_TYPE","Type de Compte");
define("FS_ECHECK_BANK_ACCOUNT_CHECK","Vérifier");
define("FS_ECHECK_BANK_ACCOUNT_SAVE","Sauvegarder");
define("FS_ECHECK_BANK_ACCOUNT_CONFIRM","Confirmation du Numéro du Compte Bancaire");
define("FS_ECHECK_BANK_ACCOUNT_ROUTE","Numéro d'Acheminement ABA/ACH");
define("FS_ECHECK_ERROR_1","Le Nom du Compte Bancaire est requis.");
define("FS_ECHECK_ERROR_2","Le Numéro Compte Bancaire est requis.");
define("FS_ECHECK_ERROR_3","Le Type de Compte est requis.");
define("FS_ECHECK_ERROR_4","La Confirmation du Numéro du Compte Bancaire est requise.");
define("FS_ECHECK_ERROR_5","Le Numéro d'Acheminement ABA/ACH est requis.");


//专题页面加购弹窗语言包翻译
define('FS_SUPPORT_ADD', 'Ajouter au Panier...');
define('FS_SUPPORT_ADDED', 'Ajouté');

define("FS_SUCCESS_ECHECK", "Electronic Check");
define("CHECKOUT_TAX_NZ_CONTENT", "Pour les commandes livrées ailleurs qu'en Australie, FS.COM ne facturera les articles et les frais d'expédition qu’au moment de la passation de la commande. Toutefois, ces colis peuvent être soumis à une taxe d'importation ou à des frais de douane, en fonction de la législation de votre pays de destination. <br/> <br/> Des droits de douane ou d'importation sont perçus dès que le colis parvient au pays de destination. Des frais supplémentaires pour le dédouanement devront être supportés par vous-même.");
define("FS_TIME_ZONE_ADDRESS_AU", "<span>Entrepôt de Melbourne FS:</span> 57-59 Edison Rd, Dandenong South, VIC 3175, Australia | +61 3 9693 3488 ");
define('FS_PURCHASE_NUMBER', 'Numéro de Bon de Commande');
//购物车分享相关 移动到公共语言包部分
define('FS_SHOP_CART_ALERT_JS_43','Votre Nom est requis.');
define('FS_SHOP_CART_ALERT_JS_43_01',"Le Nom du Destinataire est requis.");
define('FS_SHOP_CART_ALERT_JS_44','Votre E-mail est requis.');
define('FS_SHOP_CART_ALERT_JS_44_01',"E-mail du Destinataire est requis.");
define('FS_SHOP_CART_ALERT_JS_45','Veuillez entrer une adresse e-mail valide.');
define('FS_SHOP_CART_ALERT_JS_46','Envoyer à Votre Responsable de Compte');
//第三方登录提示语
define("REDIRECT_DEAR", "Cher ");
define("REDIRECT_USER", " utilisateur ");
define("REDIRECT_WELCOME", " Bienvenue");
define("REDIRECT_NOTICE", "Vous avez enregistré un compte FS avec la même adresse <br>e-mail. Pour vous offrir une meilleure expérience de la gestion de compte, <br>vous vous connecterez à votre compte FS. Si vous ne connaissez pas ce compte, <br>veuillez nous contacter.");
define("REDIRECT_ACCOUNT", "Redirection dans ");


//移动到公共文件 checkout,ccheckout_guest,邮件共用
define("FS_CHECKOUT_NEW31", "PayPal");
define("FS_CHECKOUT_NEW32", "Carte de Crédit/Débit");
define("FS_CHECKOUT_NEW33", "Virement Bancaire");
define("FS_CHECKOUT_NEW34", "Bon de Commande");
define("FS_CHECKOUT_NEW35", " BPAY");
define("FS_CHECKOUT_NEW36", " eNETS");
define("FS_CHECKOUT_NEW37", "Yandex");
define("FS_CHECKOUT_NEW38", "WebMoney");
define("FS_CHECKOUT_NEW39", "iDEAL");
define("FS_CHECKOUT_NEW40", "SOFORT");
define('GET_A_QUOTE', 'Obtenir un Devis');

// 税号模板 start
//新增结账税号验证
define("FS_CHECKOUT_VAX_CH", "Veuillez entrer un Numéro de Taxe valide, par ex. : 00.000.000-0.");
define("FS_CHECKOUT_VAX_AR", "Veuillez entrer un Numéro de Taxe valide, par ex. : 00-00000000-0.");
define("FS_CHECKOUT_VAX_BR_BS", "Veuillez entrer un Numéro de Taxe valide, par ex. : 00.000.000/0000-00.");
define("FS_CHECKOUT_VAX_BR_IN", "Veuillez entrer un Numéro de Taxe valide, par ex. : 000.000.000/00.");
define("FS_TAXT_TITLE_NOTICE", "Votre commande peut être exonérée de la TVA en fournissant un numéro de TVA correct et valide.");
define("FS_TAXT_TITLE_NOTICE_OTHER","Pour accélérer le dédouanement, veuillez remplir un numéro d'identification fiscale valide.");
// 税号模块 end

//manage_orders
define('FS_MANAGE_ORDERS_PUR', 'Numéro de Bon de Commande');
define('CANCEL', 'Annuler');

define("FS_NO_FREE_SHIPPING_US_HEAVY", "Les commandes contenant des articles lourds ou surdimensionnés ne peuvent pas bénéficier de la livraison gratuite.");
define("FS_NO_FREE_SHIPPING_DEAU_HEAVY", "Les commandes contenant des articles lourds ou surdimensionnés ne peuvent pas être livrées gratuitement.");
define("FS_NO_FREE_SHIPPING_AU_REMOTE", "Cette commande est livrée à un district éloigné, vous devrez donc payer des frais d'expédition.");

//产品详情404页面
define('FS_404_HOT_PRODUCTS', 'Produits Populaires');
define('SEARCH_OFFINE_1', 'Désolé, cet article n\'est plus disponible en ligne.');
define('SEARCH_OFFINE_2', 'Vous pouvez obtenir un devis pour effectuer des enquêtes hors ligne.');
define('SEARCH_OFFINE_3', 'obtenir un devis');
define('SEARCH_OFFINE_4', 'Besoin d\'aide ? Visitez ');
define('SEARCH_OFFINE_5', ' Centre d\'Aide');
define('SEARCH_OFFINE_6', ' Pour plus d\'assistance.');
define('SEARCH_OFFINE_7','Désolé, nous ne pouvons pas trouver cette page.');
define('SEARCH_OFFINE_8','C\'est peut-être parce que :');
define('SEARCH_OFFINE_9','La page a été déplacée vers une adresse différente.');
define('SEARCH_OFFINE_10','L\'adresse Web est incorrecte.');
define('SEARCH_OFFINE_11','Veuillez vérifier l\'URL ou retourner à la page <a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">d\'accueil</a>.');
define('SEARCH_OFFINE_12', 'la page d\'accueil.');
define('FS_OUTDATED_LINK','L\'URL qui vous a conduit ici est obsolète.');

//faq问题汇总
define('FS_FAQ_HELPFUL_01', "Cette réponse était-elle utile ?");
define('FS_FAQ_HELPFUL_02', "Oui");
define('FS_FAQ_HELPFUL_03', "Non");
define('FS_FAQ_HELPFUL_04', "Merci pour votre commentaire !");
define('FS_FAQ_HELPFUL_05', "Que pouvons-nous améliorer ?");
define('FS_FAQ_HELPFUL_06', "C'était confus");
define('FS_FAQ_HELPFUL_07', "Cela n'a pas répondu à ma question");
define('FS_FAQ_HELPFUL_08', "Je n'aime pas votre politique");
define('FS_FAQ_HELPFUL_09', "Soumettre");


//产品详情页新增弹窗语言包
define("FS_PRODUCTS_REORDERING", "Reordering");
define("FS_FOR_FREE_SHIPPING_GET_AROUND", "Get it around");
define("FS_CHOOSE_LOCATION", "Choisir votre localisation");
define("FS_DELIVERY_OPTION", "Les moyens et les vitesses de livraison peuvent varier en fonction des endroits différents.");
define("FS_SHIP_OUTSIDE", "expédier en dehors de ");
define("FS_SHIP_CONTINUE_SEE", "Vous verrez les frais de livraison exacts et la date d'arrivée à la page de paiement.");
define("FS_SHIP_DONE", "Soumettre");
define("FS_REDIRECT_PART1", "Continuer vos achats sur ");
define("FS_REDIRECT_PART2", " et vérifier le contenu spécifique avec le prix et la livraison locaux ?");
define("FS_SHIP_TO", "Expédier à");
define("FS_SHIP_CHANGE", "Changer");
define("FS_SHIP_OR", "ou");
define("FS_SHIP_OR_OTHER", "ou changer d'autre pays");
define("FS_SHIP_ENTER", "ou entrer un ");
define("FS_SHIP_ZIP_CODE", " code postal");
define("FS_SHIP_APPLY", " Appliquer");
define("FS_SHIP_ADD_NEW_ADDRESS", "Ajouter une nouvelle adresse");
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'"> Connectez-vous</a> pour voir vos adresses');
define("FS_SHIP_MANAGE", "Gérer le carnet d'adresse");
define("FS_SHIP_TODAY", "Expédier le Jour Même");
define("FS_SHIP_GET_TODAY","arriver aujourd'hui");
define("FS_PRODUCTS_POST_CODE_EMPTY_INVALID", "Veuillez entrer un Code Postal valide");
define('FS_PRODUCTS_CUSTOMIZE', 'Personnaliser');

define("FS_SHIP_LIST_COUNTRY", "Pays/Région");
define("FS_SHIP_LIST_POST", "Code Postal");
define("FS_SHIP_DELIVEY_TO", "Destination de Livraison : ");

define("FS_CN_HUBEI", "Wuhan, Hubei");
define("FS_CN_APAC", "Entrepôt en Asie");
define("FS_DE_MUNICH", "Munich, Bavière");
define("FS_AU_VIC", "Melbourne, Victoria");
define("FS_US_WA", "Washington/Delaware");
define("FS_FOR_FREE_SHIPPING_GET_ARRIVE", "Arrivée pour le");
define("FS_APAC_NOTICE", "L'Entrepôt d'Asie de FS supporte principalement des expéditions mondiales à Singapour, Brésil, Chine, Japon, Malaisie, Corée du Sud, Émirats Arabes Unis et d'autres régions.<a  target='_blank' href=" . zen_href_link("shipping_delivery", "", "SSL") . ">En savoir plus</a>");
define("FS_US_NOTICE","L'Entrepôt U.S. de FS, situé à Delaware, supporte une expédition rapide le jour même. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>");
define("FS_US_UP_NOTICE", "Les Entrepôts U.S de FS, situés respectivement à Delaware, supportent les expéditions nationales rapides le jour même dans les contiguës aux États-Unis, Alaska, Hawaii, les régions militaires APO/FPO et Porto Rico, etc., ainsi que les expéditions internationales au Canada, au Mexique.  <a  target='_blank' href=" . zen_href_link("shipping_delivery", "", "SSL") . ">En savoir plus</a>");
define("FS_US_OTHER_NOTICE", "Les Entrepôts U.S de FS, situés respectivement à Seattle & à Delaware, supportent les expéditions rapides le jour même aux États-Unis, au Canada et au Mexique.  <a  target='_blank' href=" . zen_href_link("shipping_delivery", "", "SSL") . ">En savoir plus</a>");
define("FS_US_UP_OTHER_NOTICE", "L'Entrepôt U.S de FS, situé à Delaware, supporte les expéditions rapides le jour même aux États-Unis, au Canada et au Mexique.  <a  target='_blank' href=" . zen_href_link("shipping_delivery", "", "SSL") . ">En savoir plus</a>");
define("FS_DE_NOTICE","L'entrepôt DE de FS, qui est situé à Munich, vous assure une expédition rapide le jour même. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>.");
define("FS_AU_OTHER_NOTICE", "L'Entrepôt AU de FS, situé à Melbourne, Victoria, supporte les expéditions intérieures rapides le jour même en Australie, et les expéditions internationales à la Nouvelle-Zélande.");
define("FS_NZ_OTHER_NOTICE", "L'Entrepôt AU de FS, situé à Melbourne, Victoria, supporte les expéditions rapides le jour même à la Nouvelle-Zélande. <a target='_blank' href=" . zen_href_link("shipping_delivery", "", "SSL") . ">En savoir plus</a>");
define("FS_CN_NOTICE","L'Entrepôt Global de FS, situé en Asie, supporte une expédition rapide le jour même. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Les articles seront expédiés une fois préparés. Il existe un délai de fabrication. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Disponible, En Transit</p> Les articles sont en route vers notre entrepôt et seront expédiés une fois arrivés. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Disponible, En Production</p> Les articles seront expédiés une fois préparés. Il existe un délai de facturation. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>");
define('FS_AU_NOTICE',"L'Entrepôt AU de FS, situé à Melbourne, supporte une expédition rapide le jour même. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">En savoir plus</a>");
define('FS_BUCK_NOTICE',"Les articles lourds ou surdimensionnés seront expédiés à partir de notre entrepôt en Asie.");
define('FS_SG_NOTICE',"L'Entrepôt SG de FS, situé à Singapour, supporte une expédition rapide le jour même. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>En savoir plus</a>");

//add by quest 2019-03-08
define("FS_NO_QTY_NOTICE","Les articles sont expédiés de l'entrepôt global.");
define("FS_NO_QTY_TAG_NOTICE","Les articles sont en préparation pour le transit de l'entrepôt global.");
define("FS_NO_QTY_TAG_NOTICE_NEW","Les articles sont en préparation pour l'expédition de l'entrepôt en Asie.");
define("FS_NO_QTY_NOTICE_NEW","Les articles seront en transit de l'Entrepôt en Asie.");



define("FS_SURBSTREET_MAXLENGTH_ERROR", "La ligne d'adresse 2 doit contenir au maximum 35 caractères.");
define("FS_TELEPHONE_MAXLENGTH_ERROR", "Le numéro de téléphone doit contenir au maximum 15 caractères.");
define("FS_COMPANY_MAXLENGTH_ERROR", "Le Nom de l'Entreprise doit comprendre entre 1 et 100 caractères.");
define("FS_FIRSTNAME_MAXLENGTH_ERROR", "Le Prénom doit contenir au maximum 35 caractères.");
define("FS_LASTNAME_MAXLENGTH_ERROR", "Le Nom de Famille doit contenir au maximum 35 caractères.");
define("FS_CHECKOUT_ERROR12", "La ligne d'adresse 1 doit contenir 4 à 300 caractères.");
define("FS_PRODUCTS_POST_CODE_EMPTY_ERROR", "Votre Code Postal est requis");
define('FAIL_TO_OPEN_SOURCE', "Erreur d'ouverture de l'image");
define('FAIL_TO_CONNECT_FTP', 'Erreur de connexion au serveur');
//超时取消订单


define('MANAGE_ORDER_RESTORE_1','Annulée dans Oh.');
define('MANAGE_ORDER_RESTORE_2','Annulée dans ');
define('MANAGE_ORDER_RESTORE_3','Veuillez compléter le paiement dans les 30 minutes, sinon, la commande sera automatiquement annulée en raison de la variation de l\'inventaire des articles.');
define('MANAGE_ORDER_RESTORE_4','Acheter à nouveau');
define('MANAGE_ORDER_RESTORE_5','Veuillez ajouter votre bon de commande dans les 7 jours. Sinon, la commande sera automatiquement annulée en raison de la variation de l\'inventaire des articles.');
define('MANAGE_ORDER_RESTORE_6','Veuillez compléter le paiement dans les 2 jours, sinon, la commande sera automatiquement annulée en raison du changement de l\'inventaire des articles.');
define('MANAGE_ORDER_RESTORE_7','Veuillez compléter le paiement dans les 7 jours, sinon, la commande sera automatiquement annulée en raison de la variation de l\'inventaire des articles.');
define("FS_INQUIRY_SUBMITED",'Envoyé');
define("FS_INQUIRY_QUOTED",'Coté');
define("FS_INQUIRY_DEALED",'Traitée');
define("FS_INQUIRY_CANCELED",'Annulé');
define("FS_INQUIRY_REVIEWING",'Révisé');
define("FS_FORWARD_SHIPPING","Expédition par Transitaire (avec Droits et Taxes Prépayés)");
define("FS_FORWARD_SHIPPING_NOTICE","Le prix indiqué comprend les frais de transport, les droits et taxes éventuels. L'assurance nécessaire est également facturée et indiquée dans le Récapitulatif de la Commande, calculée en fonction du montant du sous-total.");
define('FS_CHECK_OUT_INSURANCE','Assurance');

// 个人中心详情页面
define("FS_INQUIRY_SUBTOTAL",'Sous-total');
define("FS_INQUIRY_CHECKOUT",'Commander');
define("FS_INQUIRY_ADD_FILE",'Ajoutez une fichier');
define("FS_INQUIRY_CANCEL_SUCCESS",'Annuler avec succès');
define("FS_NOTES",'Notes');

// 个人中心列表页面
define("FS_INQUIRY_TOTAL_QUOTE_NUMBER",'QUOTE_NUMBER Demandes Totales de Devis');
define("FS_INQUIRY_VIEW",'Voir');
define("FS_INQUIRY_CANCEL_THIS_QUOTE",'Annuler ce Devis ?');
define("FS_INQUIRY_CANCEL_QUOTE_TIP1",'Une fois annulé, il ne peut pas être récupéré.');
define("FS_INQUIRY_CANCEL_QUOTE_TIP2",'Cependant, si vous voulez vraiment faire cela, veuillez nous donner une raison d\'annuler : ');
define("FS_INQUIRY_CANCEL_REASON1",'Article déjà acheté');
define("FS_INQUIRY_CANCEL_REASON2",'Devis en double');
define("FS_INQUIRY_CANCEL_REASON3",'Pas le produit dont j\'ai besoin');
define("FS_INQUIRY_CANCEL_REASON4",'Problème de garantie');
define("FS_INQUIRY_CANCEL_REASON5",'Long délai de livraison');
define("FS_INQUIRY_CANCEL_REASON6",'Trop cher');
define("FS_INQUIRY_CANCEL_REASON7",'Pas besoin');
define("FS_INQUIRY_CANCEL_REQUIRED_TIP",'Avant de soumettre, veuillez choisir les raisons d\'annulation.');
define('FS_INQUIRY_EMPTY_PAGE_TIP','Il n\'y a pas de demande de devis. Obtenez un devis dans la page du produit.');
define('FS_INQUIRY_LIST_TIP','Vérifiez le statut de vos devis et achetez directement avec les prix préférentiels.');
define('FS_CANCEL_QUOTE','Annuler le Devis');



//产品详情页产品树收起提示语
define('FS_COMMON_CLOSE', 'Moins');
define('FS_COMMON_FS_PN', 'FS P/N: ');

//新版邮件

define("SEND_MAIL_1","Expédition GRATUITE à Partir de £79,00");
define("SEND_MAIL_2","Fiberstore Ltd, Part 7th Floor, 45 CHURCH STREET, Birmingham, B3 2RT");
define("SEND_MAIL_3","Expédition GRATUITE à Partir de $79");
define("SEND_MAIL_4","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");
define("SEND_MAIL_5","Expédition GRATUITE à Partir de 79€");
define("SEND_MAIL_6","GmbH, NOVA Gewerbepark, Building 7, Am Gfild 7, 85375 Neufahrn, Allemagne");
define("SEND_MAIL_7","Expédition GRATUITE à Partir de A$99");
define("SEND_MAIL_8","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Pty Ltd, ABN 71 620 545 502,57-59 Edison Rd, Dandenong South, VIC 3175, Australie");
define("SEND_MAIL_9","Expédition le Jour Même pour les Articles en Stock");
define("SEND_MAIL_10","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Limited Room 2702, 27 Floor Yisibo Software Building, Haitian Second Road, Yuehai Street Nanshan District, Shenzhen, 518054, China");
//Postbank账户
define('FIBER_CHECK_COMMON_ACCOUNT','N° de compte :');
define('FIBER_CHECK_COMMON_CODE','N° de code bancaire :');
define('FIBER_CHECK_COMMON_IBAN','IBAN :');
define('FIBER_CHECK_COMMON_BIC','BIC :');

define('FIBER_CHECK_DO_TITLE','Compte US-$');
define('FIBER_CHECK_DO_ACCOUNT_VALUE','0902543668');
define('FIBER_CHECK_DO_CODE_VALUE','590 100 66');
define('FIBER_CHECK_DO_IBAN_VALUE','DE98 5901 0066 0902 5436 68');
define('FIBER_CHECK_DO_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_GB_TITLE','Livre Sterling GBP');
define('FIBER_CHECK_GB_ACCOUNT_VALUE','0902544661');
define('FIBER_CHECK_GB_CODE_VALUE','590 100 66');
define('FIBER_CHECK_GB_IBAN_VALUE','DE59 5901 0066 0902 5446 61');
define('FIBER_CHECK_GB_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_CH_TITLE','Franc Suisse CHF');
define('FIBER_CHECK_CH_ACCOUNT_VALUE','0902545664');
define('FIBER_CHECK_CH_CODE_VALUE','590 100 66');
define('FIBER_CHECK_CH_IBAN_VALUE','DE41 5901 0066 0902 5456 64');
define('FIBER_CHECK_CH_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_POST_TITLE','Compte de la Banque Postale');
define('FIBER_CHECK_COMMON_ACCOUNT_NAME','Nom de Compte :');
define('FIBER_CHECK_COMMON_BANK','Nom de Banque:');
define('FIBER_CHECK_COMMON_ADDRESS','Adresse de la Banque:');

define('FIBER_CHECK_SG_TITLE','Compte Bancaire OCBC');
define('FIBER_CHECK_SG_OCBC_USD','Numéro du Compte OCBC USD :');
define('FIBER_CHECK_SG_OCBC_SGD','Numéro du Compte OCBC SGD :');
define('FIBER_CHECK_SG_INT_BANK','Banque Intermédiaire (pour TT en USD)');
define('FIBER_CHECK_SG_SWIFT','BIC :');
define('FIBER_CHECK_SG_BANK_CODE','Code Banque :');
define('FIBER_CHECK_SG_BRANCH_CODE','Code Guichet :');
define('FIBER_CHECK_SG_BRANCH_CODE_CONTENT','3 premiers chiffres de votre numéro de compte.');
define('FIBER_CHECK_SG_BRANCH_NAME','Nom de la Banque :');
define('FIBER_CHECK_SG_BRANCH_NAME_CONTENT','NORTH Branch');
define('FIBER_CHECK_SG_BANK_ADDRESS','Adresse de la Banque :');
define('FIBER_CHECK_SG_BANK_ADDRESS_CONTENT','65 Chulia Street, OCBC Centre, Singapore 049513');

define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE','FS.COM GmbH');
define('FIBER_CHECK_COMMON_BANK_VALUE','Banque Postale');
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE','Eckenheimer Landstr.242 60320 Frankfurt');

//add by helun 2018.5.15
define('FS_CHECKOUT_SUCCESS_01','commandes.');
define('FS_CHECKOUT_SUCCESS_02','Imprimer la Commande');
define('FS_CHECKOUT_SUCCESS_03','Commande');
define('FS_CHECKOUT_SUCCESS_04','de');
define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07','FS.COM GmbH');
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');
define('FS_CHECKOUT_SUCCESS_12','Bon de Commande');
define('FS_CHECKOUT_SUCCESS_13','JOURS');
define('FS_CHECKOUT_SUCCESS_14','Ajouter le Fichier Bon de Commande');
//new_cart
define('FS_NEW_SHIPPING_FREE','Cette commande se qualifie pour la Livraison Gratuite ! ');
define('FS_GO_SHOPPING','Commencer Vos Achats');
define('FS_ENTERPRISE_NETWORK','Réseau d\'Entreprise');
define('FS_OTN_SOLUTION','Solution OTN');
define('FS_DATA_CENTER_SOLUTION','Solution de Centre de Données');
define('FS_OEM_SOLUTION','Solution OEM');
define('FS_RECENTLY_VIEWED','Votre Historique de Navigation');
define('FS_CART_TIP','Vous avez un compte FS ? <a target="_blank" href="'.zen_href_link('login','','SSL').'" class="cart_no_23Link">Connectez-vous</a> pour voir ce que vous avez ajouté, ou ajoutez quelque article de nouveau.');
define('FS_ADDED_TO_CART','Ajouter au panier');
define('FS_REMOVED','Supprimer');
define('FS_SHOP_CART_MOVE','Ajouter');
define('FS_SHOP_CART_SAVE','Mettre de Côté');
define('FS_SHOP_CART_SIMILAR','Recommandation de Produit Similaire');
define('FS_SHOP_CART_SAVED','Mettre de Côté');
define('FS_CART_EMPTY','Votre panier est vide.');
define('FS_SVAE_FOR_LATER_TIP',' a été mis de côté pour plus tard.');
define('FS_MOVE_TO_CART_TIP',' a été déplacé au panier.');
define('FS_DELETE_FOR_LATER','Supprimer la Mise de Côté');
define('FS_DELETE_SURE_SAVE','Êtes-vous sûr de vouloir supprimer le produit mis de côté ?');
define('FS_DELETE_SURE','Êtes-vous sûr de vouloir supprimer ');
define('FS_DELETE_CART_TITLE','Supprimer le Panier Enregistré');
define('FS_SYMBOL',',');

//下架产品气泡，提示
define('FS_PRODUCT_OFF_TEXT','Désolé, cet article a été supprimé et n\'est plus disponible en ligne.');
define('FS_PRODUCT_OFF_TEXT_2','Désolé, les articles suivants auraient été supprimés et ne sont plus disponibles chez FS.COM.');
define('FS_PRODUCT_OFF_TEXT_3','Sélectionner les Attributs');
define('FS_PRODUCT_OFF_TEXT_4','Les attributs des articles personnalisés suivants ont été modifiés. Veuillez sélectionner les attributs sur la page de détails du produit.');
define('FS_PRODUCT_OFF_TEXT_5','*Certains articles de cette commande ne peuvent pas être ajoutés au panier.');
define('FS_PRODUCT_OFF_TEXT_6','Votre commande contient un/des article(s) indisponible(s), sautez et continuez à télécharger le fichier PO.');
define('FS_PRODUCT_OFF_TEXT_7','Les articles ci-dessous ne sont plus disponibles et ne seront pas calculés dans le prix total lors du paiement.');
define('FS_PRODUCT_OFF_TEXT_8','Un article de votre panier est indisponible. Il n\'apparaîtra pas lorsque vous passerez la commande.');
define('FS_PRODUCT_OFF_TEXT_9','Les articles de votre panier sont indisponibles. Ils n\'apparaîtront pas lorsque vous passerez la commande.');

define('FS_PRODUCT_CLEARANCE_TEXT','Les articles suivants sont peut-être en rupture de stock, veuillez contacter votre responsable de compte pour connaître les disponibilités.');
define('FS_PRODUCT_CLEARANCE_TEXT_1','La quantité dont vous avez besoin est supérieure aux stocks disponibles et a été ajustée en conséquence, veuillez contacter votre responsable de compte pour connaître une quantité supplémentaire.');

// 添加购物车成功弹窗
define('FS_ADDED_ONE_ITEM','Vous venez d\'ajouter [ADDITEM] article.');
define('FS_ADDED_MORE_ITEM','Vous venez d\'ajouter [ADDITEM] articles');

//四级分类名称
define('FS_CATEGORIES_01','Type de Produit');
define('FS_CATEGORIES_02','Classification du Produit');
define('FS_CATEGORIES_03','Type d\'Outil');
define('FS_CATEGORIES_04','Type de Convertisseurs de Média');
define('FS_CATEGORIES_05','Type de Câble');
define('FS_CATEGORIES_06','Type de Switches KVM');
define('FS_CATEGORIES_07','Type de Convertisseurs de Vidéo');
define('FS_CATEGORIES_08','Application');
define('FS_PRODUCTS_JS_MOQ','La quantité minimale de commande (MOQ) de ce produit est ');
define('FS_PRODUCTS_JS_UPPER','AUCUNE limite supérieure');


define("FS_PRODUCTS_PICK_UP","Retirement gratuit, du Lun. au Ven. ");
define("FS_PRODUCTS_VIA","avec");

//fairy 2019.1.15 add
define('FS_COLOR_RED','Rouge');
define('FS_COLOR_BLUR','Bleu');
define('FS_COLOR_GREEN','Vert');

//账户中心
define('FS_MANAGE_ORDERS_1','Les informations suivantes sont toutes destinées à l\'Utilisateur Final ou à l\'Opérateur du Commutateur. Il est essentiel de fournir des services de support technique. Veuillez vous assurer que toutes les informations sont correctes et efficaces.');
define('FS_MANAGE_ORDERS_2','Application Soumise');
define('FS_MANAGE_ORDERS_3','Clé de Licence : ');
define('FS_MANAGE_ORDERS_4','Procédure : ');
define('FS_MANAGE_ORDERS_5','Clé de Licence Reçue');
define('FS_MANAGE_ORDERS_6','Activation Terminée');
define('FS_MANAGE_ORDERS_7','L\'information a été soumise avec succès. Nous vous enverrons un e-mail contenant la clé de licence pour activer le commutateur bientôt.');
define('FS_MANAGE_ORDERS_8','Commutateurs Cumulus de Série N');
define('FS_MANAGE_ORDERS_9','Clé de Licence pour Commutateurs Cumulus de Série N');
define('FS_MANAGE_ORDERS_10','Cher/Chère ');
define('FS_MANAGE_ORDERS_11','Votre clé de licence est ');
define('FS_MANAGE_ORDERS_12','Remarque : Il faudra environ 3 jours pour vérifier la clé de licence. Une fois la vérification terminée, vous pouvez l\'importer dans le commutateur. ');
define('FS_MANAGE_ORDERS_13','1. Utilisation et Restrictions de la Licence');
define('FS_MANAGE_ORDERS_14','La clé de licence sera efficace et à long terme.');
define('FS_MANAGE_ORDERS_15','Vous pouvez bénéficier d\'un service d\'assistance technique d\'un an et de 45 jours à compter de la date d\'activation. (Le service gratuit supplémentaire serait en retard si vous ne l\'utilisez pas dans les 45 jours).');
define('FS_MANAGE_ORDERS_16','Une fois le service expiré, vous pouvez continuer à l\'acheter si vous le souhaitez.');
define('FS_MANAGE_ORDERS_17','2. Processus d\'Importation de la Clé de Licence');
define('FS_MANAGE_ORDERS_18','Veuillez vérifier les informations suivantes pour importer la licence :');
define('FS_MANAGE_ORDERS_19','Nous vous invitons à nous contacter pour toute question au cours de l\'utilisation de la licence ou pour l\'extension des services de support technique. Nos coordonnées sont les suivantes ：');
define('FS_MANAGE_ORDERS_20','E-mail : ');
define('FS_MANAGE_ORDERS_21','Tél : +1 (877) 205 5306 (PST)');
define('FS_MANAGE_ORDERS_22','+1 (888) 468 7419 (EST)');
define('FS_MANAGE_ORDERS_23','Assurez-vous que cette clé de licence est restée dans les bonnes mains et l\'importez dans le commutateur en cas de besoin.');
define('FS_MANAGE_ORDERS_24','Cordialement,');
define('FS_MANAGE_ORDERS_25','Équipe Technique de FS.COM');
define('FS_MANAGE_ORDERS_26','Vidéo :');
define('FS_MANAGE_ORDERS_26_1','Vidéo');
define('FS_MANAGE_ORDERS_27','PDF : ');
define('FS_MANAGE_ORDERS_28','Téléphone : ');
define('FS_MANAGE_ORDERS_29','Livraison GRATUITE à Partir de $79');
define('FS_MANAGE_ORDERS_30','Obtenir la Clé de Licence');
define('FS_MANAGE_ORDERS_31','Cher/Chère ');
define('FS_MANAGE_ORDERS_32','Voici votre clé de licence : ');
define('FS_MANAGE_ORDERS_33','Leaf(10G/25G): 556688 <br />Spine(40G/100G): 335521');
define('FS_MANAGE_ORDERS_34','Remarque :');
define('FS_MANAGE_ORDERS_35','1. La clé de licence sera efficace et à long terme. Assurez-vous que cette clé de licence est restée dans les bonnes mains. Il faudra environ 3 jours pour vérifier la clé de licence.');
define('FS_MANAGE_ORDERS_36','2. Après la vérification, vous pouvez l\'importer dans le commutateur. Vous pouvez bénéficier d\'un service d\'assistance technique d\'un an ainsi que de 45 jours, le service gratuit supplémentaire serait invalide si vous ne l\'utilisez pas dans les 45 jours. Une fois le service expiré, vous pouvez continuer à l\'acheter si vous le souhaitez.');
define('FS_MANAGE_ORDERS_37','Comment Importer la Clé de Licence');
define('FS_MANAGE_ORDERS_38','Veuillez vérifier les informations suivantes pour vous aider :');
define('FS_MANAGE_ORDERS_39','Nous vous invitons à nous contacter pour toute question au cours de l\'utilisation de la licence ou pour l\'extension des services de support technique. Nos coordonnées sont les suivantes ：');
define('FS_MANAGE_ORDERS_40','E-mail: <a style="text-decoration: none;color: #232323;">tech@fs.com</a> <br />Téléphone : +1 (647) 243 6342');
define('FS_MANAGE_ORDERS_41','Cordialement,');
define('FS_MANAGE_ORDERS_42','Équipe Technique de FS.COM');
define('FS_MANAGE_ORDERS_43','Le Nom de Votre Entreprise est requis');
define('FS_MANAGE_ORDERS_44','Votre Nom est requis');
define('FS_MANAGE_ORDERS_45','Votre Numéro de Téléphone est requis');
define('FS_MANAGE_ORDERS_46','Votre Adresse E-mail est requise');
define('FS_MANAGE_ORDERS_47','L\'adresse e-mail que vous avez envoyée n\'est pas reconnue.  (exemple : quelqu\'un@exemple.com).');
define('FS_MANAGE_ORDERS_48','Veuillez cliquer sur le bouton de l\'accord CLUF');
define('FS_MANAGE_ORDERS_49','Votre Adresse Web est requise');
define('FS_MANAGE_ORDERS_50','Ce message a été envoyé à ');
define('FS_MANAGE_ORDERS_51','Livraison Gratuite : Certaines exclusions s\'appliquent.');
define('FS_MANAGE_ORDERS_52','En savoir plus sur notre ');
define('FS_MANAGE_ORDERS_53','politique de livraison');
define('FS_MANAGE_ORDERS_54','FS.COM Inc.');
define("CULUMS_OFF1","Demande d'Activation");
define("CULUMS_OFF2","L'information suivante est destinée à l'utilisateur final ou à la personne chargée d'opérer le commutateur. Il est essentiel de fournir un service de support technique. Veuillez vous assurer que toute information est réelle et efficace. ");
define("CULUMS_OFF3","Nom d'Entreprise");
define("CULUMS_OFF4","Identifiant");
define("CULUMS_OFF5","Téléphone");
define("CULUMS_OFF6","Adresse E-mail");
define("CULUMS_OFF7","Adresse Internet");
define("CULUMS_OFF8","l'Accord CLUF (Contrat de Licence Utilisateur Final).");
define("CULUMS_OFF9","Cumulus Networks®");
define("CULUMS_OFF10","Demande d'Activation");
define("CULUMS_OFF11","Contrat de Licence Utilisateur Final pour Logiciels");
define("CULUMS_OFF12","Ces conditions de licence, ainsi que la Confirmation de Commande qui vous a été livrée (Titulaire de Licence) par Cumulus Networks, Inc. (Cumulus) ou un revendeur autorisé par Cumulus (Revendeur Autorisé) à vous distribuer le logiciel Cumulus, sont un accord entre Cumulus et vous. Ces conditions s'appliquent aux logiciels avec lesquels ils sont distribués, y compris le support sur lequel vous l'avez reçu, le cas échéant. Les conditions s'appliquent également à toutes les mises à jour, suppléments et services de support Cumulus pour le logiciel que Cumulus peut vous fournir, sauf si d'autres conditions accompagnent ces éléments. Si c'est le cas, ces conditions s'appliquent. En utilisant le logiciel, vous confirmez que vous disposez d'une confirmation de commande valide pour chaque copie du logiciel que vous utilisez et que vous acceptez les présentes conditions en relation avec chaque copie.");
define("CULUMS_OFF13","SI VOUS N'ACCEPTEZ PAS CES CONDITIONS, N'UTILISEZ PAS LE LOGICIEL. EN UTILISANT LE LOGICIEL, VOUS ACCEPTEZ DE VOUS ABONNER PAR LE PRÉSENT CONTRAT DE LICENCE DE LOGICIEL (Contrat ).");
define("CULUMS_OFF14"," LICENCES D'ÉVALUATION, BÊTA ET NFR. Dans le cas ou vous recevez une licence du Produit qui est identifiée par Cumulus comme une Licence d'Evaluation ou une Licence Beta, les limitations supplémentaires suivantes s'appliquent: sauf autorisation écrite de Cumulus, votre utilisation du Produit n'est (i) autorisée que pour une durée de trente jours dans un environnement interne hors production (tests et évaluation uniquement); et est (ii) limité à un maximum de cinq occurrence simultanées du produit, fonctionnant uniquement sur du matériel dont vous êtes le propriétaire ou que vous êtes le seul à contrôler, sauf autorisation contraire de Cumulus. Si vous avez reçu une licence pour le Produit qui est identifiée par Cumulus comme étant une licence non destinée à la revente (NFR), les limitations supplémentaires suivantes s'appliquent: votre utilisation du Produit (i) n'est autorisée qu'une seule fois sur du matériel dont vous êtes le propriétaire ou que vous êtes le seul à contrôler, pendant que vous êtes un partenaire en règle dans le cadre du programme de partenariat Cumulus qui vous a rendu éligible à recevoir la licence NFR,  (ii) limité uniquement aux démonstrations, essais et formation de produits (aucune production, traitement d'information ou utilisation d'infrastructure est autorisée). Cependant, toute disposition contraire, l'Évaluation, la Licence Beta, les Produits sous licence NFR et tout autre Produit (ou partie de ceux-ci) identifié par Cumulus comme Accès Anticipé sont fournis TELS QUELS sans indemnisation, support ou garantie d'aucune sorte, explicite ou tacite. Vous assumez tous les risques associés à l'utilisation des produits sous licence d'évaluation, Beta et NFR. LE PRÉSENT ACCORD NE PEUT ÊTRE REMPLACÉ QUE PAR UN ACCORD ÉCRIT DISTINCT ET SIGNÉ AVEC CUMULUS NETWORKS, INC. QUI RÉFÈRE EXPRESSÉMENT ET REMPLACE CET ACCORD (UN ACCORD DE REMPLACEMENT).");
define("CULUMS_OFF15","Les parties conviennent de ce qui suit :");
define("CULUMS_OFF16","1. Définitions");
define("CULUMS_OFF17","a. Produit désigne la/les version(s) exécutable(s) du logiciel de réseau  mise(s) à disposition par Cumulus telle(s) que définie(s) explicitement dans la(les) Confirmation(s) de Commande (définie(s) à l'Article 3(a)) du présent Contrat, y compris toutes mises a jours et nouvelles versions du produit mises à disposition du Titulaire de Licence dans ce Contrat et la documentation applicable à l'utilisateur final. ");
define("CULUMS_OFF18","b. Renseignements exclusifs  désigne l'ensemble des inventions, algorithmes, savoir-faire et idées ainsi que toutes autres informations commerciales, techniques et financières qu'une partie obtient de l'autre partie si: a) identifiés comme confidentiels ou exclusifs au moment de la divulgation ou avant,  ou b)  une personne raisonnable estimerait que ces renseignements sont confidentiels compte tenu du contenu ou des circonstances de la divulgation.");
define("CULUMS_OFF19","c. Droits de propriété signifie les droits de brevet, les droits d'auteur, les droits de secret commercial, les droits de base de données sui generis et tout autres droits de propriété intellectuelle et industrielle de toute sorte.");
define("CULUMS_OFF20","2. Octroi de Licence");
define("CULUMS_OFF21","a. Sous réserve du paiement intégral en vertu de l'Article 3 et de la conformité du titulaire de la licence des autres modalités de la présente entente, Cumulus accorde uniquement au Titulaire de Licence, tous les Droits de Propriété de Cumulus,  une licence limitée, non exclusive, uniquement pour reproduction et usage interne au profit du titulaire de la licence, la quantité de licences achetées du Produit uniquement pour la durée de la licence applicable (la Durée de la Licence), uniquement sur un commutateur en silicium adapté, et uniquement jusqu'aux vitesses de port maximales spécifiées dans chaque Confirmation de commande (telle que définie à l'Article 3 (a)).");
define("CULUMS_OFF22","b. La licence précédente n'autorise aucune sous-licence, distribution ou divulgation du Produit à un tiers et le titulaire de la licence accepte à ne pas s'engager dans une telle sous-licence, divulgation ou distribution.");
define("CULUMS_OFF23","c. Le titulaire de la licence ne doit pas (et n'autorise pas son personnel, ni aucun tiers, à): (i) modifier ou créer des œuvres dérivées du Produit;  (ii) effectuer de la rétro-ingénierie ni tenter de découvrir le code source ou les idées ou algorithmes sous-jacents du Produit (sauf dans la mesure où la loi applicable interdit les restrictions de rétro-ingénierie), (iii) supprimer ou modifier tout avis d'identification de produit, de marque de commerce, de droit d'auteur ou tout autre avis intégré ou apparaissant dans ou sur le Produit ; ou (iv) publier ou distribuer les résultats d'analyses comparatives ou d'études de performance à des tiers sans l'accord écrit préalable de Cumulus. Le titulaire de licence est seul responsable du respect et de l'observation de toutes les conditions du présent contrat par ses employés, sous-traitans, fournisseurs de services et agents, et tout autre tiers autorisé à accéder au Produit à la suite de ses actions ou omissions du titulaire de la licence. Le Titulaire de Licence devra indemniser, mettre hors de cause et défendre Cumulus et ses concédants de licence contre toute réclamation ou poursuite,  y compris les honoraires et frais d'avocats, résultant d'une utilisation ou distribution non autorisée ou illégale du Produit. ");
define("CULUMS_OFF24","d. Le Produit inclut des progiciels de code source ouvert (collectivement Open Source Software). Chaque progiciel de code source ouvert inclus dans le Produit est mis à la disposition du titulaire de licence conformément à sa licence de progiciel de code source ouvert applicable.  En cas de conflit entre une licence de progiciel de code source ouvert et le texte du présent Contrat, la licence de progiciel de code source ouvert ne s'applique qu'à ce progiciel spécifique.");
define("CULUMS_OFF25","e. Le Produit est régi par les lois, restrictions et réglementations d'exportation des États-Unis. Le Titulaire de Licence n'exportera pas ou ne réexportera pas, ou ne permettra pas l'exportation ou la réexportation du Produit en violation de telles lois, restrictions ou réglementations.");
define("CULUMS_OFF26","f. Le Produit (i) a été développé à des frais privés et comprend des secrets commerciaux et des informations confidentielles; (ii) est un article commercial constitué d'un logiciel informatique commercial et d'une documentation de logiciel informatique commercial réglementé par la section DFARS 227.7202 et FAR 12.212 et ne doit pas être considéré comme un logiciel informatique non commercial ou de la documentation en vertu des dispositions du DFARS; et (iii) N'EST PAS offert aux agences du gouvernement des États-Unis en vertu de la licence de logiciel informatique commercial énoncée à la FAR 52.227-19. Conformément à 48 CFR 12.212 et 48 CFR 227.7202 selon le cas, le Produit est concédé sous licence aux utilisateurs finaux du gouvernement uniquement en tant qu'Article Commercial et ne comprend que les droits accordés aux autres utilisateurs finaux selon les termes du présent Contrat. L'Article 2(f) remplace et annule toute clause des FAR, DFAR ou autres clauses complémentaires des FAR. Les droits non publiés réservés en vertu des lois sur les droits d'auteur des États-Unis.");
define("CULUMS_OFF27","3. Prix; Paiement; Archives.");
define("CULUMS_OFF28","a. Pendant la durée du présent Contrat, le Titulaire de Licence peut demander des Licences Achetées supplémentaires en passant des commandes à Cumulus ou à un Revendeur Autorisé. Cumulus ou le Revendeur Autorisé répondra par une commande formalisée et acceptée confirmant le nombre de Licences Achetées, la Durée de la Licence, le prix total, les taxes eventuelles, et toutes les conditions générales supplémentaires relatives aux licences achetées (chacune de ces formes, une Confirmation de commande). Chaque Confirmation de Commande est entièrement intégrée au Présent Contrat. Chaque licence achetée mentionnée sur une confirmation de commande doit permettre au titulaire de licence de créer une copie unique du produit et d'utiliser la copie conformément à la concession de licence mentionnée dans l'Article 2.");
define("CULUMS_OFF29","b. Pendant la durée du présent Contrat, le titulaire de licence aura le droit d'acquérir des Licences Achetées conformément aux Confirmations de Commande livrées par Cumulus au titulaire de licence (hors taxes, le cas échéant). Si cela est spécifié dans la Confirmation de commande correspondante, les licences achetées précédemment prendront fin immédiatement comme indiqué dans cette Confirmation et seront remplacées par de nouvelles licences achetées (ce remplacement, la Conversion). Les conditions applicables aux Conversions seront précisées dans la Confirmation de Commande correspondante et/ou dans un calendrier décrivant les détails de cette Conversion (ce calendrier étant appelé Avis de Conversion).");
define("CULUMS_OFF30","c. Le Titulaire de Licence paiera à Cumulus (ou à un Revendeur Autorisé) tous les frais applicables précisés dans chaque Confirmation de Commande (les Frais) dans les trente (30) jours suivant la réception de chaque Confirmation de Commande, ou comme convenu autrement entre le Titulaire de Licence et un Revendeur Autorisé. La devise applicable sera indiquée sur la Confirmation de commande, sinon c'est en dollars US. Les frais ne sont pas remboursables. Sauf indication explicite en tant que taxes sur la confirmation de commande, tous les montants dus sont exclus des taxes, retenues à la source, droits,  prélèvements, droits de douane et autres charges gouvernementales (y compris sans limitation la TVA), hors impôts sur le revenu net de Cumulus (collectivement, Impôts), et le titulaire de licence est responsable du paiement de toutes les taxes. Les parties coopéreront raisonnablement pour minimiser légalement les taxes.  Dans le cas où le Titulaire de Licence ne paie pas Cumulus ou un Revendeur Autorisé une partie des Frais à l'échéance, il devra également payer à Cumulus ou au Revendeur Autorisé des frais de retard de 1,5% du montant restant dû par mois pour la période pendant laquelle ces frais sont en souffrance, sauf convention contraire entre le titulaire de Licence et le Revendeur Autorisé.");
define("CULUMS_OFF31","d. Pendant la durée du présent contrat et pendant un (1) an suivant sa résiliation, le titulaire de licence établira et préservera les archives concernant l'utilisation du Produit par ce dernier, qui comprendra, sans limitation, chaque installation d'une copie du produit et un identifiant unique pour le matériel sur lequel il est installé (collectivement, «Records»). A la demande de Cumulus, le Titulaire de Licence fournira sans délai ces archives à Cumulus afin de vérifier le respect du présent Contrat. Si le titulaire de licence manque de créer, de maintenir ou de fournir les archives comme l'exige la présente section, ou en cas de contestation sur l'exactitude de archives, Cumulus peut vérifier l'utilisation du Produit par le Titulaire de Licence (par exemple, au moyen d'un examen des copies des fichiers de log applicables, etc.), à tout endroit où le Produit est ou a été installé ou autrement utilisé par le Titulaire de Licence.");
define("CULUMS_OFF32","4. Livraison et Support..");
define("CULUMS_OFF33","a. Après la livraison de la première Confirmation de Commande au titre du présent Contrat, Cumulus fournira rapidement au Titulaire de Licence un exemplaire du Produit sous forme exécutable.");
define("CULUMS_OFF34","b. Le Titulaire de Licence peut commander des services de support auprès de Cumulus comme indiqué dans la Confirmation de Commande correspondante, et sous réserve du paiement par le Titulaire de Licence des frais de support applicables. Le Titulaire de Licence reconnaît et accepte que le support Cumulus soit soumis aux termes et conditions énoncés à l'URL suivante : <a href='javascript:;'>https://cumulusnetworks.com/support/overview/</a> (the “Programme de Support Cumulus”).");
define("CULUMS_OFF35","c. Sauf une interdiction contractuelle ou légale, Cumulus fournira aux titulaires de licences les mises à jour et les nouvelles versions du produit qu’il met généralement à la disposition des clients, à condition que le titulaire de licence possède une ou plusieurs Licences Achetées en règle en vertu du Présent Contrat, et qu'il a commandé et payé le Programme de Support Cumulus comme spécifié dans la Confirmation de Commande correspondante.");
define("CULUMS_OFF36","5. Publicité; accord de divulgation; marques de commerce.");
define("CULUMS_OFF37","a. Cumulus a le droit de faire référence au Titulaire de Licence en tant que client sans divulguer les termes du présent Contrat. Sauf si requis par la loi ou autrement préciser dans le présent Contrat, toutes les annonces publiques concernant les termes du présent Contrat seront coordonnées entre Cumulus et le Titulaire de Licence par accord mutuel.");
define("CULUMS_OFF38","b. Sauf indication contraire dans le présent contrat, aucune des parties ne peut utiliser les marques de commerce et les marques de service (marques) de l'autre partie, sans autorisation écrite (y compris électroniques) de l'autre partie. Le Titulaire de Licence accorde à Cumulus une licence limitée d'utilisation des Marques de ce dernier conformément aux directives d'utilisation des ces Marques dans le seul but d'identifier le Titulaire de Licence comme un client. Les parties n'utiliseront ni n'enregistreront les marques de l'autre partie (ou n'effectueront aucun dépôt à leur égard) où que ce soit dans le monde. Aucune des parties ne contestera, où que ce soit dans le monde, l'utilisation ou l'autorisation par l'autre partie de quelconque de ses marques. Aucun autre droit ou licence à l'égard d'une marque de commerce, d'un nom commercial ou d'une autre désignation n'est accordé en vertu du présent accord.");
define("CULUMS_OFF39","6. Interdiction de cession. Ni le présent Accord, ni les droits, licences ou obligations ci-dessous ne peuvent être cédés par l'une ou l'autre des parties sans l'accord écrit préalable de la partie non cédante; toute cession présumée interdite sera nulle. Malgré ce qui précède, l'une ou l'autre partie peut céder le présent accord ou déléguer ses droits et obligations à tout acquéreur de la totalité ou de la quasi-totalité des biens, entreprises, ou les titres de participations de cette partie correspondant à l'objet du présent accord, à condition, qu'en cas d'une telle cession, sur réception de l'avis de cession, la partie non cédante dispose d'un délai de trente jours pour mettre fin au présent accord moyennant un préavis écrit.");
define("CULUMS_OFF40","7. Durée de Contrat. La durée du présent contrat restera en vigueur jusqu'à la fin du dernier délai de validité de la licence. Le présent Contrat sera automatiquement résilié, y compris les Licences accordées dans l'Article 2 si le Titulaire de Licence ne respecte pas l'une des conditions de cette section. Le présent Contrat peut être résilié si l’une des parties manque gravement d’exécuter ou de se conformer à toute disposition de ce dernier. La résiliation prendra effet trente (30) jours après la notification à la partie défaillante si les infractions n’ont pas été résolus au cours de cette période.");
define("CULUMS_OFF41","8. Survie. Droits de paiement, Articless 1, 2 (b-e), 3 (b), 6, 7, 8, 9, 10, 11, 12, 13 (b-d) et 14, sauf disposition contraire dans les présentes, tout droit d'action pour violation du présent contrat avant sa résiliation survivra à toute résiliation de ce dernier. En cas de résiliation pour violation par Cumulus, toutes les Licences Achetées survivront à la résiliation jusqu'à la fin de la Durée de la Licence applicable. En cas de résiliation pour violation du Titulaire de Licence, toutes les Licences Achetées seront immédiatement résiliées.");
define("CULUMS_OFF42","9. Avis et demandes. Tous les avis, consentements, autorisations et demandes relatifs au présent accord seront remis immédiatement après leur envoi par courrier express aérien, frais payés d'avance; et adressée à l'attention du Service juridique à l'adresse applicable indiquée dans la Confirmation de commande la plus récente régie par le présent contrat ou à toute autre adresse désignée par la partie destinataire de la notification ou de la demande, par notification écrite en vertu du présent Article 9 à l'autre partie.");
define("CULUMS_OFF43","10. Loi de Contrôle; honoraires d'avocat. Le présent contrat est régi par les lois de l'État de Californie et des États-Unis et doit être interprété conformément à ces lois, sans égard à leurs dispositions en matière de conflits de lois et sans égard à l'UCITA ou la Convention des Nations Unies sur les contrats de vente internationale de marchandises. La seule juridiction et le seul lieu pour les actions liées à l'objet des présentes seront les tribunaux de l'État de Californie et les tribunaux fédéraux américains du comté de Santa Clara, en Californie. Les deux parties consentent à la juridiction et au lieu de ces tribunaux et conviennent que le processus peut être manifesté de la manière indiquée dans les présentes pour communiquer des préavis ou autrement comme le permet la loi californienne ou fédérale.");
define("CULUMS_OFF44","11. Confidentialité");
define("CULUMS_OFF45","Les conditions de prix du présent Contrat, le Produit et les inventions, algorithmes, savoir-faire et idées sous-jacents sont la propriété de Cumulus. Sauf autorisation claire et officielle, le titulaire de licence conservera la confidentialité de ses informations personnelles et n'utilisera ni ne divulguera ces informations. Ses employés et ses contractants seront également liés par écrit. Aucune disposition des présentes ne permet à la partie destinataire de divulguer ou d'utiliser, sauf dans les cas expressément autorisés ailleurs dans le présent accord, les renseignements confidentiels de la partie divulgatrice et uniquement en fonction «au besoin» aux objectifs du présent accord. En cas de résiliation du présent Contrat, le Titulaire de Licence retournera ou détruira sans délai toute Information Propriétaire et toutes copies, extraits et dérivés de celle-ci, sauf disposition contraire du présent Contrat. De plus, le Titulaire de Licence supprimera sans délai toute copie du Produit i) dès l'expiration de la Licence Achetée applicable relative à cette copie du Produit ; et ii) avant toute distribution du matériel sur lequel le Produit est installé à tout tiers, y compris un revendeur ou fabricant de matériel. Chaque partie reconnaît que la violation de l'Article 11 causerait un préjudice irréparable à l'autre partie pour lequel des dommages pécuniaires ne constituent pas un recours approprié. En conséquence, une partie aura le droit de demander des injonctions et d'autres recours équitables dans l'éventualité d'une telle infraction par l'autre partie.");
define("CULUMS_OFF46","12. Responsabilité Limitée. SAUF INDICATION CONTRAIRE INDIQUÉE CI-DESSOUS, ET EN AUCUN CAS QUE CE SOIT DANS LE PRÉSENT CONTRAT, AUCUNE DES PARTIES NE PEUT ÊTRE TENUE RESPONSABLE OU OBLIGÉE EN VERTU D'UNE SECTION QUELCONQUE DU PRÉSENT CONTRAT OU EN VERTU D'UN CONTRAT, D'UNE NÉGLIGENCE, D'UNE RESPONSABILITÉ STRICTE OU D'UNE AUTRE THÉORIE JURIDIQUE OU ÉQUITABLE (A) POUR TOUT MONTANT EXCÉDANT LE TOTAL DES DROITS DE LICENCE QUI LUI ONT ÉTÉ PAYÉS (DANS LE CAS DE CUMULUS) OU (DANS LE CAS DU TITULAIRE DE LICENCE) PAYÉ OU DÛ EN VERTU DES PRÉSENTES, OU (B) TOUT DOMMAGE ACCESSOIRE OU CONSÉCUTIF, PERTE DE PROFITS (SAUF LES MONTANTS PAYABLES EN VERTU DE L'ARTICLE 3) OU PERTE OU ALTÉRATION DE DONNÉES OU INTERRUPTION D'UTILISATION OU C) LE COÛT DE L'ACHAT DE BIENS, TECHNOLOGIES OU SERVICES DE SUBSTITUTION. LES LIMITATIONS DE L'ARTICLE 12 NE S'APPLIQUENT PAS AUX BRIS DES ARTICLES 2(b)(e) ET 11 OU AUX ACTIONS DU DÉTENTEUR DE LICENCE AU-DESSUS DE LA PORTÉE DE L'OCTROI DE LICENCE.");
define("CULUMS_OFF47","13. Garantie.");
define("CULUMS_OFF48","a. Cumulus garantit au Titulaire de Licence que le Produit et sa fabrication seront de bonnes qualités, conformément aux normes professionnelles les plus élevées. Le seul recours du titulaire de licence en cas d'infraction de la présente garantie ou de défauts du produit est le droit que lui confère l'article 4(b). Cumulus ne donne aucune garantie concernant l'absence de bugs ou l'utilisation ininterrompue.");
define("CULUMS_OFF49","b. Le Produit n'est pas conçu, destiné ou certifié pour être utilisé dans des composants ou des systèmes destinés à l'exploitation de systèmes ou d'applications dangereux (par exemple, armes, systèmes d'armes, installations nucléaires, moyens de transport de masse, aviation, ordinateurs ou équipements de survie (y compris les équipements de réanimation et implants chirurgicaux), contrôle de la pollution, gestion des substances dangereuses, ou pour toute autre application dangereuse) dans laquelle la défaillance du Produit pourrait créer une situation où des blessures corporelles ou la mort pourraient survenir. Le Titulaire de Licence comprend que l'utilisation du Produit dans de telles applications est entièrement aux risques du Titulaire de Licence, et le Titulaire de Licence assume tous ces risques.");
define("CULUMS_OFF50","c. CUMULUS NE DONNE AUCUNE GARANTIE À TOUTE PERSONNE OU ENTITÉ EN CE QUI CONCERNE LE PRODUIT, À L'EXCEPTION DE CE QUI EST EXPRESSÉMENT STIPULÉ CI-DESSUS, ET DÉCLINE TOUTE GARANTIE IMPLICITE, Y COMPRIS, SANS LIMITATION, LES GARANTIES DE QUALITÉ MARCHANDE ET D'ADAPTATION À UN USAGE PARTICULIER ET DE NON-CONTREFAÇON.");
define("CULUMS_OFF51","d. CHAQUE PARTIE RECONNAÎT ET ACCEPTE QUE LA GARANTIE, LES LIMITATIONS DE RESPONSABILITÉ ET DE RESPONSABILITÉ DU PRÉSENT ACCORD SONT DES MOYENS NÉGOCIÉS POUR LES BASES DU PRÉSENT CONTRAT ET QU'ELLES ONT ÉTÉ PRISES EN COMPTE ET REFLÉTÉES POUR DÉTERMINER LA CONSTITUTION DE LA GARANTIE ET DANS LA DÉCISION DE CHACUNE DES PARTIES DE CONCLURE LA PRÉSENTE ENTENTE.");
define("CULUMS_OFF52","14. Général. Le présent contrat constitue l'entente intégrale entre les parties à l'égard de l'objet des présentes et regroupe toutes les communications antérieures et actuelles. Il ne peut être modifié que par un accord écrit daté postérieurement à la date du présent Contrat et signé au nom du Titulaire de Licence et de Cumulus par leurs représentants dûment autorisés. Si une disposition du présent accord est jugée illégale, invalide ou inexécutable par un tribunal compétent, cette disposition sera limitée ou éliminée dans la mesure minimale nécessaire pour que la présente entente demeure par ailleurs pleinement en vigueur et applicable. Aucune renonciation à une infraction d'une disposition du présent contrat ne constitue une renonciation à une infraction antérieure, concurrente ou subséquente de la même ou de toute autre disposition des présentes, et aucune renonciation ne prend effet à moins d'être réalisée par écrit et signée par un représentant autorisé de la partie ayant renoncé.");
define("CULUMS_OFF53","Soumettre");
define("CULUMS_OFF54","Copyright &copy; 2009-".date('Y',time())." FS.COM GmbH Tous Droits Réservés.");
define("CULUMS_OFF55","Politique de confidentialité");
define("CULUMS_OFF56","Information envoyée avec succès. Nous vous enverrons un email avec le code de licence pour activer le commutateur dans les 10 minutes.");
define("CULUMS_OFF57","Le Nom de Votre Entreprise est nécessaire");
define("CULUMS_OFF58","Votre Numéro de Téléphone est nécessaire");
define("CULUMS_OFF59","Votre Adresse E-mail est nécessaire");
define("CULUMS_OFF60","L'adresse e-mail que vous avez fournie n'est pas reconnue (exemple: personne@exemple.com).");
define("CULUMS_OFF61","Veuillez cocher le bouton de l'accord de CLUF");
define("CULUMS_OFF62","Votre Adresse Internet est nécessaire");
define("CULUMS_OFF63","Vous avez soumis des informations de vérification, veuillez ne pas les soumettre à nouveau.");
define("CULUMS_OFF64","Les informations ont été soumises avec succès et vous n'avez pas besoin de les soumettre à nouveau.");
define("CULUMS_OFF65","Informations sur l'Article");
define("CULUMS_OFF66","Partager Votre Expérience d'Utilisation ");

//加购弹窗
define('FS_ADD_CART_PROCHUSE','Sous-total du Panier ');

//地址模块 start
define("FS_ADD_NEW_ADDRESS","Ajouter une Nouvelle Adresse");
define('FS_ADD_SHIPPING_ADDRESSES','Ajouter une Nouvelle Adresse');
define('FS_ADD_BILLING_ADDRESS','Ajouter une Nouvelle Adresse de Facturation');
//地址模块 end

//2019-01-07 继续付款，再次付款，付款成功
define('FS_PAYMENT_CONFIRM','Confirmer');
define('PAYMENT_AGAINST_PAYPAL_SECURITY','Vous serez dirigé vers un compte paypal pour payer cette commande.');
define('PAYMENT_AGAINST_BANK_SENTENCE01','Habituellement, les paiements seront reçus dans les 1-3 jours ouvrables. Nous traiterons la commande une fois que le virement est confirmé.');
define('PAYMENT_AGAINST_BANK_SENTENCE02','Faites-nous savoir quand vous êtes prêt à verser le paiement afin que nous puissions vérifier votre paiement et traiter votre commande à temps.');
define('PAYMENT_AGAINST_BANK_FILL','Remplissez Vos Informations de Virement Bancaire');
define('PAYMENT_AGAINST_PAYPAL','PayPal');
define('PAYMENT_AGAINST_BANK','Virement Bancaire');
define('PAYMENT_AGAINST_EDIT','Éditer');
define('PAYMENT_AGAINST_BANK_EMAIL','Adresse E-mail du Payeur');

define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP','Le numéro de bon de commande ne peut être vide.');
define("FS_ORDER_UPLOAD_PO_MESSAGE",'Votre commande ne sera pas expédiée avant que le document de PO valide soit reçu dans les 7 jours ouvrables.');

define('FS_AGAINST_PAYER','Nom du Payeur');
define('FS_AGAINST_PAY_TIME','Date de Paiement');
define('FS_AGAINST_PAY_AMOUNT','Montant du Paiement');
define('FS_AGAINST_COUNTRY','Pays');
define('FS_AGAINST_PHONE','Numéro de Téléphone du Payeur');
define('FS_AGAINST_OR','Veuillez remplir le nom que vous utilisez pour effectuer le virement bancaire, individuel ou d\'entreprise.');
define('FS_AGAINST_YOUR','La Date de Paiement est requise (ex.: 26/01/2019)');
define('FS_AGAINST_MUST','Il faut être un numéro de téléphone valide, nous pourrons vous appeler si nécessaire');

define('FS_BT_SUCCESSFULLY','Mise à jour avec succès !');
define('FS_BT_SUCCESSFULLY_SENTENCE_01','Habituellement, les paiements seront reçus entre 1-3 jours ouvrables. Nous nous en occuperons dès que possible. Cliquez sur');
define('FS_BT_SUCCESSFULLY_SENTENCE_02',' Historique des Commandes ');
define('FS_BT_SUCCESSFULLY_SENTENCE_03','pour voir la commande.');

define("FS_CHECKOUT_NEW28","Copyright © 2009-".date('Y', time())." ".FS_LOCAL_COMPANY_NAME." Tous Droits Réservés.");

define('GLOBAL_GS_SENTENCE1','Remarque : Pour des raisons de sécurité, nous ne conserverons aucune des données de votre carte de crédit.');
define('GLOBAL_GS_SENTENCE2','Nous acceptons les cartes de crédit/débit suivantes ainsi que les P-Card émises par ces sociétés. Veuillez sélectionner un type de carte, compléter les informations ci-dessous et cliquer sur Confirmer.');
define('GLOBAL_GS_SENTENCE3','Nous acceptons les cartes de crédit/débit suivantes. Pour des raisons de sécurité, nous ne conserverons aucune des données de votre carte de crédit.');
define('FS_AGAINST_WE','Nous acceptons les cartes de crédit/débit suivantes ainsi que les P-Card émises par ces sociétés. Veuillez sélectionner un type de carte, compléter les informations ci-dessous et cliquer sur Confirmer.');
define("GLOBAL_GC_TEXT6","Sélectionnez une Carte de Crédit /Débit :");
define("GLOBAL_GC_TEXT7","Récapitulatif de la Commande");
define("GLOBAL_GC_TEXT8","Numéro de Commande");
define("GLOBAL_GC_TEXT11","Adresse de Facturation");
define("GLOBAL_GC_TEXT13","Numéro de Carte");
define("GLOBAL_GC_TEXT14","Date d'Expiration");
define("GLOBAL_GC_TEXT17","Code de Sécurité");
define("GLOABL_GC_LIVECHAT","Chat en Ligne");
define("GLOABL_CART","Panier");
define("GLOABL_CHECKETOUT","Paiement");
define("GLOABL_SUCCESS","Succès");
define("GLOBAL_EXPECTED_SHIPPING","Expédition Prévue");
define("GLOBAL_EXPECTED_DELIVERY","Arrivée prévue");
define('FS_ALLOWED_FILE_TYPES','Autoriser les fichiers de type: ');
define('CHECKOUT_BILLING_CREDIT','Centre de Paiement par Carte de Crédit/Débit');
define('FS_REGIST','Enregistrer');
define('FS_GC_TIPS_01','Désolé, votre demande est refusée. Veuillez vérifier les raisons suivantes et réessayer. Vous pouvez aussi choisir un autre moyen de paiement.');
define('FS_GC_TIPS_02','1. Le montant total excède la limite (€ 15000);');
define('FS_GC_TIPS_03','2. La carte ne supporte pas cette monnaie.;');
define('FS_GC_TIPS_04','3. Erreur réseau, veuillez réessayer plus tard.');

//询价弹窗
define("FS_INQUIRY_YOUR_ITEM",'Votre Article');

define("CHECKOUT_TAXE_CLEARANCE_CN_FRONT","Pour les commandes expédiées de notre Entrepôt CN, nous ne facturerons que la valeur du produit et les frais d'expédition. Aucune taxe de vente (ex. TVA ou TPS) ne sera facturée. Toutefois, les paquets peuvent être soumis à une taxe d'importation ou à des droits de douane, en fonction des lois/réglementations des pays concernés. Tout tariff ou droit de douane dû au dédouanement doit être déclaré et supporté par le destinataire. Pour les commandes expédiées en Malaisie, en Indonésie et aux Philippines, nous fournissons maintenant le « Expédition par Transitaire » comme méthode d'expédition pour aider les clients à prépayer les Droits et Taxes générés lors du dédouanement en ligne. Pour les clients d'autres régions, veuillez nous contacter si vous avez besoin d'aide pour prépayer les droits de douane.");
define('FS_SAMPLE_APPLICATION_SUBMIT','Soumettre ...');

// 上传 start
//2018-9-20  ery  add
define('FS_COMMON_FILE', 'Fichier');
//服务器端的提示
define("FS_UPLOAD_ERROR1",'L\'erreur de la première pièce jointe : ');
define("FS_UPLOAD_ERROR2",'L\'erreur de la seconde pièce jointe : ');
define("FS_UPLOAD_ERROR3",'L\'erreur de la troisième pièce jointe : ');
define("FS_UPLOAD_ERROR4",'L\'erreur de la quatrième pièce jointe : ');
define("FS_UPLOAD_ERROR5",'L\'erreur de la cinquième pièce jointe : ');
// 2019.2.26 fairy add
define("FS_UPLOAD_FORMAT_TIP",'Autoriser les fichiers de type $FILE_TYPE');
define("FS_UPLOAD_SIZE_DEFAULT_TIP",'Taille maximale du fichier : 5M.');
// 上传 end

//信用卡新加坡渠道弹窗
define("GLOABL_TEXT_DECLINED_1","Nous sommes désolés que votre carte ait été refusée pour l'une des raisons suivantes:");
define("GLOABL_TEXT_DECLINED_2","1.Assurez-vous qu'il n'y a pas plus de 2 Adresses de Facturation uniques par numéro de carte ou par adresse électronique dans les 30 jours.");
define("GLOABL_TEXT_DECLINED_3","2.Assurez-vous que le pays émetteur de la carte est même du pays de l'adresse d'expédition dans la commande.");
define("GLOABL_TEXT_DECLINED_8","3.Assurez-vous que l'adresse de facturation dans la commande est exactement comme il apparaît sur votre relevé de carte.");
define("GLOABL_TEXT_DECLINED_4","Vous pouvez contacter d'abord votre banque pour demander les raisons, et si votre problème de carte ne peut pas être résolu rapidement, nous vous conseillons de changer une autre carte ou de passer à Paypal, Virement Bancaire ou Chèque pour payer la commande.");
define("GLOABL_TEXT_DECLINED_5","Votre carte a été refusée par la banque émettrice");
define("GLOABL_TEXT_DECLINED_6","Votre carte a été refusée pour une variété de raisons, les raisons communes incluent:");

define("GLOABL_TEXT_DECLINED_7","Veuillez contacter votre banque ou l'émetteur de la carte pour trouver la raison spécifique qui refuse la transaction. Ou vous pouvez utiliser une autre carte de crédit ou changer le mode de paiement à paypal ou virement bancaire pour payer la commande.");
define("GLOABL_TEXT_DECLINED_9","Cliquez ici pour payer avec d'autres moyens de paiement.");
define("GLOABL_TEXT_DECLINED_10","Veillez diviser la commande si le montant total est supérieur à 15000,00 €, ou");
define("GLOABL_TEXT_DECLINED_11"," cliquez ici ");
define("GLOABL_TEXT_DECLINED_12","pour payer avec un autre mode de paiement.");

define('FS_CLEARACNE_05','Voir tout');
define('FS_CLEARACNE_06','Voir Plus');

define('FS_EMAIL_MY_PO_UP_CONTACT','Contactez-Nous');
define('EMAIL_BODY_COMMON_TAX_NUMBER','Numéro de TVA ');
//退换货提示
define('FS_ACCOUNT_HISTORY_1','Veuillez confirmer la réception du colis, le retour &amp; le remplacement seront activés.');

//详情页定制产品加购弹窗
define('FS_CUSTOMIZED_INFORMATION','Informations de Personnalisation');
define('FS_CUSTOMIZED','Personnalisation');
define('FS_PROCESSING','Traitement');
define('FS_SHIPPING','Expédition');
define('FS_DELIVERED','Livraison');
define('FS_PROCESSING_EST','En Traitement : ');
define('FS_SHIPPING_EST','Expédition : ');
define('FS_DELIVERED_EST','Livraison : ');
define('FS_BUSINESS_DAYS_ADD',' jours ouvrables');
define('FS_BUSINESS_DAYS_DELIVER_TO',' jours ouvrables, livrer à ');
define('FS_EST','Environ ');
define('FS_CUSTOMIZED_ADD_TO_CART','Confirmer');
define('FS_KEEP_SHOPPING','Continuer Vos Achats');
define('FS_CONTINUE_TO_CART','Continuer au Panier');

define('FS_PRODCUTS_INFO_VIEW','Plus de Détails : ');
define('FS_PRODUCTS_INFO_VIEW_NEW','Plus');


define('FS_PRE_ORDER','Précommander');

//订单邮件语言包
define('FS_ORDER_EMAIL_01','Nous vous remercions d\'avoir choisi FS. Nous avons reçu votre commande en attente ');
define('FS_ORDER_EMAIL_02','. Complétez le paiement pour que votre commande soit traitée dès que possible. ');
define('FS_ORDER_EMAIL_03','Les détails de votre commande ');
define('FS_ORDER_EMAIL_04',' sont ci-dessous. Nous vous enverrons un e-mail dès que le statut de votre commande est mis à jour.');
define('FS_ORDER_EMAIL_05','Les détails de votre commande ');
define('FS_ORDER_EMAIL_06','sont ci-dessous. Comme vous avez choisi "Retirer à l\'entrepôt", nous vous enverrons les instructions de ramassage par e-mail une fois que votre commande est prête.');
define('FS_ORDER_EMAIL_07','Nous vous remercions d\'avoir choisi FS. Nous avons reçu votre commande en attente. Complétez le paiement pour que votre commande soit traitée dès que possible. ');
define('FS_ORDER_EMAIL_08','Les détails de votre commande sont ci-dessous. Comme vous avez choisi "Retirer à l\'entrepôt", nous vous enverrons les instructions de ramassage par e-mail une fois que votre commande est prête.');
define('FS_ORDER_EMAIL_09','Nous vous remercions d\'avoir effectué vos achats chez nous. Les détails de votre commande sont ci-dessous. Nous vous enverrons les informations de suivi dès que vos articles seront expédiés.');
define('FS_ORDER_EMAIL_10','Commande');
define('FS_ORDER_EMAIL_11','Votre achat a été divisé en ');
define('FS_ORDER_EMAIL_12',' commandes.');
define('FS_ORDER_EMAIL_13','Gérer les Commandes');
define('FS_ORDER_EMAIL_14','Commande');
define('FS_ORDER_EMAIL_15','Commandé');
define('FS_ORDER_EMAIL_16','Expédition Estimée');
define('FS_ORDER_EMAIL_17','Livraison Prévue');
define('FS_ORDER_EMAIL_18','Ne vous inquiétez pas, nous vous informerons dès que vos articles seront expédiés. Pour connaître l\'état actuel de votre commande, vous pouvez vérifier ');
define('FS_ORDER_EMAIL_19','Mon Compte');
define('FS_ORDER_EMAIL_20',' à tout moment.');
define('FS_ORDER_EMAIL_21','Si vous avez besoin de modifier ou d\'annuler votre commande, veuillez visiter ');
define('FS_ORDER_EMAIL_22','. Veuillez noter que vous ne pourrez plus effectuer de modifications une fois que vos articles seront expédiés.');
define('FS_ORDER_EMAIL_23','Ne vous inquiétez pas, nous vous informerons dès que vos articles seront expédiés. Pour connaître l\'état actuel de votre commande, vous pouvez nous contacter à tout moment. ');
define('FS_ORDER_EMAIL_24','Si vous voulez modifier ou annuler votre commande, veuillez contacter votre responsable commercial. Veuillez noter que vous ne pourrez plus effectuer de modification une fois que vos articles seront expédiés. ');
define('FS_ORDER_EMAIL_25','Complétez le paiement pour que votre commande soit traitée dès que possible. ');
define('FS_ORDER_EMAIL_26','Commande Reçue');
define('FS_ORDER_EMAIL_27','Traitement de Commande');
define('FS_ORDER_EMAIL_28','Cher/Chère ');
define('FS_ORDER_EMAIL_29','Détails de Livraison');
define('FS_ORDER_EMAIL_30','Expédier à');
define('FS_ORDER_EMAIL_31','Coordonnées');
define('FS_ORDER_EMAIL_32','Questions Fréquentes');
define('FS_ORDER_EMAIL_33','Où est l\'article que j\'ai commandé ?');
define('FS_ORDER_EMAIL_34','Comment puis-je changer ma commande ?');
define('FS_ORDER_EMAIL_35','Détails de Paiement');
define('FS_ORDER_EMAIL_36','Sous-total :');
define('FS_ORDER_EMAIL_37','Expédition :');
define('FS_ORDER_EMAIL_38','Prix Total :');
define('FS_ORDER_EMAIL_39','Méthode de Paiement :');
define('FS_ORDER_EMAIL_40','Tous les frais seront marqués sous le nom de  <a style="color: #0070BC;text-decoration: none" href="javascript:;">FS COM</a>.');
define('FS_ORDER_EMAIL_41','Adresse de Facturation');
define('FS_ORDER_EMAIL_42','Merci pour votre achat. Veuillez voir à l\'intérieur pour les détails de votre commande.');
define('FS_ORDER_EMAIL_43','FS - Nous avons reçu votre commande en attente %s');
define('FS_ORDER_EMAIL_44','Adresse de ramassage');
define('FS_ORDER_EMAIL_45','Personne de ramassage');
define('FS_ORDER_EMAIL_46','. Téléchargez le fichier PO et votre commande sera traitée dans les plus brefs délais.');
define('FS_ORDER_EMAIL_47','FS - Merci pour votre Achat %s');
define('FS_ORDER_EMAIL_48','Bon de Commande');
define('FS_ORDER_EMAIL_49','Emballée');
define('FS_ORDER_EMAIL_50','Retirée');
//2019.4.9 新增俄罗斯对公支付 邮件语言包 [ORDERNUMBER]不需要翻译保留即可，只有一单时会替换成对应的订单号，多单时会替换为空
define('FS_ORDER_EMAIL_51', "Merci pour choisir FS. Nous avons reçu votre commande en attente[ORDERNUMBER]. Votre responsable de compte va vous envoyer la facture par e-mail dans le plus bref délai.");
define('FS_ORDER_EMAIL_52','Veuillez vérifier vos détails de paiement :');
define('FS_ORDER_EMAIL_53','Correspondant');
define('FS_ORDER_EMAIL_54','Numéro de téléphone*');
define('FS_ORDER_EMAIL_55','E-mail*');
define('FS_ORDER_EMAIL_56','Nom de l\'organisation*');
define('FS_ORDER_EMAIL_57','INN*');
define('FS_ORDER_EMAIL_58','KPP*');
define('FS_ORDER_EMAIL_59','OKPO');
define('FS_ORDER_EMAIL_60','BIC*');
define('FS_ORDER_EMAIL_61','Adresse légale*');
define('FS_ORDER_EMAIL_62','Adresse postale');
define('FS_ORDER_EMAIL_63','Compte de correspondant');
define('FS_ORDER_EMAIL_64','Nom de la banque*');
define('FS_ORDER_EMAIL_65','Compte de règlement*');
define('FS_ORDER_EMAIL_66','Nom complet du titulaire');
define('FS_ORDER_EMAIL_67','Information de Paiement');
define('FS_ORDER_EMAIL_68','Longueur');
define('FS_ORDER_EMAIL_09_1','Votre achat a été divisé en deux commandes ');
define('FS_ORDER_EMAIL_09_2','Les détails sont ci-dessous. Nous vous enverrons un e-mail dès que le statut de votre commande est mis à jour.');
define('FS_ORDER_EMAIL_69','Vous pouvez vous connecter pour suivre la progression de votre commande sur la page de ');
define('FS_ORDER_EMAIL_70','l\'Historique de Commandes');
define('FS_ORDER_EMAIL_71','.');
define('FS_ORDER_EMAIL_72','Paiement Reçu');
define('FS_ORDER_EMAIL_73','Traitement');
define('FS_ORDER_EMAIL_74','En Route');
define('FS_ORDER_EMAIL_75','Livrée');
define('FS_ORDER_EMAIL_76','PO Confirmé');
//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"Partager Votre Expérience d'Utilisation #");
define('EMAIL_COMMON_FOOTER_NEW_02',"Vous êtes abonné à cet e-mail en tant que ");
define('EMAIL_COMMON_FOOTER_NEW_03',"Cliquez ici pour modifier vos préférences ou vous désabonner.");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS.COM Inc, 380 Centerpoint Blvd, New Castle, DE 19720");
define('EMAIL_COMMON_FOOTER_NEW_05',"Contactez-Nous");
define('EMAIL_COMMON_FOOTER_NEW_06',"Mon Compte");
define('EMAIL_COMMON_FOOTER_NEW_07',"Expédition &amp; Livraison");
define('EMAIL_COMMON_FOOTER_NEW_08',"Politique de Retour");
define('EMAIL_COMMON_FOOTER_NEW_09'," GmbH Tous Droits Réservés.");
define('EMAIL_COMMON_FOOTER_NEW_10',"Copyright &copy; ");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"Vous avez changé votre mot de passe avec succès. Votre nouveau mot de passe est prêt sur tous nos sites.");
define('RESET_PASS_SUCCESS_02','Connectez-Vous à Votre Compte');
define('RESET_PASS_SUCCESS_03',"Si vous n'avez pas demandé de changer votre mot de passe, répondez à cet e-mail ou appelez-nous au +1 (888) 468 7419.");
define('RESET_PASS_SUCCESS_04','Cordialement <br>L\'Équipe FS');
define('RESET_PASS_SUCCESS_05','Cher/Chère');
define('RESET_PASS_SUCCESS_TITLE','Mettre à Jour Le Mot de Passe');
define('RESET_PASS_SUCCESS_THEME','Votre mot de passe a été mis à jour');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"Nous avons reçu une demande de réinitialisation de votre mot de passe pour votre compte FS. Si vous n'avez pas fait cette demande, veuillez ignorer cet e-mail. Si vous avez fait cette demande, cliquez simplement sur le bouton ci-dessous pour obtenir un nouveau mot de passe.");
define('RESET_PASS_SEND_02',"Définir un Nouveau Mot de Passe");
define('RESET_PASS_SEND_03',"P.S. Si vous avez des difficultés à cliquer sur le bouton de réinitialisation du mot de passe, copiez et placez le code de réinitialisation du mot de passe ci-dessous dans votre page de réinitialisation.");
define('RESET_PASS_SEND_04',"Merci <br>Équipe de FS");
define('RESET_PASS_SEND_05',"Cher/Chère");
define('RESET_PASS_SEND_06',"Pas de mot de passe ? ne vous inquiétez pas , nous vous aiderons à le réinitialiser.");
define('RESET_PASS_SEND_TITLE','Réinitialiser le Mot de Passe');
define('RESET_PASS_SEND_THEME','Instructions de Réinitialisation du Mot de Passe');
define('RESET_PASS_EXPIRE_TIME','Ce code de réinitialisation du mot de passe expirera dans 4 heures. Pour obtenir un nouveau lien de réinitialisation de mot de passe, veuillez visiter
<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>');

//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"Votre adresse e-mail a été changée en ");
define('RESET_EMAIL_SUCCESS_02','Cher/Chère');
define('RESET_EMAIL_SUCCESS_03','Utiliser cette adresse pour accéder à votre ');
define('RESET_EMAIL_SUCCESS_04',"Mon Compte");
define('RESET_EMAIL_SUCCESS_05'," détails.");
define('RESET_EMAIL_SUCCESS_06',"Si vous n'avez pas demandé de changer vos informations, veuillez visiter ");
define('RESET_EMAIL_SUCCESS_07',"Cordialement <br>Équipe de FS");
define('RESET_EMAIL_SUCCESS_TITLE','Metter à Jour L\'Adresse E-mail');
define('RESET_EMAIL_SUCCESS_THEME','FS - Votre adresse e-mail a été mise à jour');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"Votre compte a été créé avec succès. Maintenant, vous pouvez vous connecter avec votre e-mail et mot de passe.");
define('REGIST_EMAIL_SEND_02',"Cher/Chère");
define('REGIST_EMAIL_SEND_03',"Votre compte a été créé avec succès. Maintenant vous pouvez ");
define('REGIST_EMAIL_SEND_04',"vous connecter");
define('REGIST_EMAIL_SEND_05'," avec votre e-mail et mot de passe.");
define('REGIST_EMAIL_SEND_06',"Une fois connecté, vous pouvez : ");
define('REGIST_EMAIL_SEND_07',"Gérer votre ");
define('REGIST_EMAIL_SEND_08',"compte FS");
define('REGIST_EMAIL_SEND_09'," et demander un accès facile aux services FS.");
define('REGIST_EMAIL_SEND_10',"");
define('REGIST_EMAIL_SEND_11',"Demander un support technique");
define('REGIST_EMAIL_SEND_12'," et obtenir une réponse gratuite et rapide.");
define('REGIST_EMAIL_SEND_13',"Faire un achat en ligne et suivre le statut de la commande à tout moment.");
define('REGIST_EMAIL_SEND_14',"Cordialement <br>Équipe de FS");
define('REGIST_EMAIL_SEND_15',"Votre compte a été créé avec succès, le numéro de compte est ");
define('REGIST_EMAIL_SEND_16',". Maintenant, vous pouvez ");
define('REGIST_EMAIL_SEND_TITLE','Le Compte a été Créé');
define('REGIST_EMAIL_SEND_THEME','Votre nouveau compte FS est prêt à être utilisé !');

//企业用户注册(新用户注册)
define('REGIST_COM_EMAIL_SEND_01','Nous avons reçu votre demande de compte professionnel. Il est actuellement en cours de révision et ce processus peut prendre 1 - 3 jours ouvrables.');
define('REGIST_COM_EMAIL_SEND_03','Nous avons reçu votre demande de compte professionnel. Il est actuellement en cours de révision et ce processus peut prendre 1 - 3 jours ouvrables.
Lorsqu\'une décision a été prise, vous serez informé par un e-mail de FS en temps opportun.');
define('REGIST_COM_EMAIL_SEND_02','Cher/Chère');
define('REGIST_COM_EMAIL_SEND_04','Avant d\'être approuvé, vous pouvez ');
define('REGIST_COM_EMAIL_SEND_05','vous connecter');
define('REGIST_COM_EMAIL_SEND_06',' avec votre e-mail et votre mot de passe, bénéficier d\'abord des services de compte standard.');
define('REGIST_COM_EMAIL_SEND_07','Une fois connecté, vous pouvez : ');
define('REGIST_COM_EMAIL_SEND_08','Gérer votre ');
define('REGIST_COM_EMAIL_SEND_09','compte FS');
define('REGIST_COM_EMAIL_SEND_10',' et demander un accès facile aux services FS.');
define('REGIST_COM_EMAIL_SEND_11','');
define('REGIST_COM_EMAIL_SEND_12','Demander un support technique');
define('REGIST_COM_EMAIL_SEND_13',' et obtenir une réponse gratuite et rapide.');
define('REGIST_COM_EMAIL_SEND_14','Faire un achat en ligne et suivre le statut de la commande à tout moment.');
define('REGIST_COM_EMAIL_SEND_15','Merci <br>L\'Équipe FS');
define('REGIST_COM_EMAIL_SEND_TITLE','La Demande a été Reçue');
define('REGIST_COM_EMAIL_SEND_THEME','FS - Votre demande de Compte d\'Entreprise reçue');

//新注册邮件语言包
define('REGIST_EMAIL_SEND_NEW_01',"Le Compte a été Créé");
define('REGIST_EMAIL_SEND_NEW_02',"Bienvenue chez FS");
define('REGIST_EMAIL_SEND_NEW_03',"Leader Mondial dans la Fourniture d'Équipements et Solutions de Communication par Internet");
define('REGIST_EMAIL_SEND_NEW_04',"Engagement de Qualité");
define('REGIST_EMAIL_SEND_NEW_05',"Garantie de Qualité, Priorité à la Clientèle et Gestion Durable.");
define('REGIST_EMAIL_SEND_NEW_06',"Solutions Personnalisées");
define('REGIST_EMAIL_SEND_NEW_07',"Fournit des Solutions Innovantes, Rentables et Fiables.");
define('REGIST_EMAIL_SEND_NEW_08',"Livraisons Rapides");
define('REGIST_EMAIL_SEND_NEW_09',"Des Entrepôts Locaux, un Inventaire Important et une Politique d'Expédition Gratuite.");
define('REGIST_EMAIL_SEND_NEW_10',"Fournit une expertise et un support technique, et répond rapidement pour assurer le progrès de votre entreprise.");
define('REGIST_EMAIL_SEND_NEW_11',"Visitez nos blog, wiki, études de cas et nos annonces pour obtenir des solutions adaptées.");
define('REGIST_EMAIL_SEND_NEW_12',"Commencer Vos Achats");
define('REGIST_EMAIL_SEND_NEW_13',"FS Support Technique");
define('REGIST_EMAIL_SEND_NEW_14',"FS Communauté");

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','Nous avons reçu votre demande de compte professionnel. Il est actuellement en cours de révision et ce processus peut prendre 1 - 3 jours ouvrables.');
define('REGIST_COM_EMAIL_UPGRADE_02','Cher/Chère');
define('REGIST_COM_EMAIL_UPGRADE_03','Nous avons reçu votre demande de mise à jour de votre compte. Il est actuellement en cours de révision et ce processus peut prendre 1 - 3 jours ouvrables. Lorsqu\'une décision a été prise, vous serez informé par un e-mail de FS en temps opportun.');
define('REGIST_COM_EMAIL_UPGRADE_04','Merci <br>L\'Équipe FS');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','La Demande a été Reçue');
define('REGIST_COM_EMAIL_UPGRADE_THEME','FS - Votre demande de Compte d\'Entreprise reçue');

//邮件系统改版语言包
//在线询价(A)
define('FS_SEND_EMAIL','FS - Nous avons reçu votre demande de devis ');
define('FS_SEND_EMAIL_1',"Nous avons reçu votre demande de devis ");
define('FS_SEND_EMAIL_2'," et vous enverrons un e-mail avec les détails du devis dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_3',"Demande Reçue");
define('FS_SEND_EMAIL_3_1','Nous avons reçu votre demande d\'échantillon $CASENUMBER');
define('FS_SEND_EMAIL_4'," et vous enverrons un e-mail avec les détails du devis dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_5',"Votre message");
define('FS_SEND_EMAIL_6',"Liste du Devis");
define('FS_SEND_EMAIL_7',"Vos Notes Supplémentaires");
define('FS_SEND_EMAIL_8',"Qté. : ");
//在线技术咨询A
define('FS_SEND_EMAIL_8_1','FS - Nous avons reçu votre demande de support ');
define('FS_SEND_EMAIL_8_2', 'FS - Nous avons reçu votre demande d\'assistance technique ');//product_support页面，发送邮件
define('FS_SEND_EMAIL_9',"Merci de contacter FS. Votre numéro de cas est ");
define('FS_SEND_EMAIL_10',". Notre équipe de support technique vous répondra dans les 6-18 heures.");
define('FS_SEND_EMAIL_10_1',". Nous vous répondrons dans les 6-18 heures.");//product_support页面，发送邮件
//产品QA邮件
define('FS_SEND_EMAIL_11',"FS - Nous avons reçu votre question concernant l'article #");
define('FS_SEND_EMAIL_12',"Question Reçue");
define('FS_SEND_EMAIL_12_1',"Nous avons reçu votre question concernant l'article #");
define('FS_SEND_EMAIL_13'," et nous allons vous contacter dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_14',"Nous avons reçu votre question concernant l'article ");
define('FS_SEND_EMAIL_15'," et nous allons vous contacter dans un délai d'un jour ouvrable.");
//退换货all
define('FS_SEND_EMAIL_16',"On s'en occupe");
define('FS_SEND_EMAIL_17',"Nous avons reçu votre demande concernant vos problèmes de commande ");
define('FS_SEND_EMAIL_18',"Merci de nous laisser nous occuper de cela pour vous !");
define('FS_SEND_EMAIL_19',"FS - Nous avons reçu votre demande d'assistance ");
define('FS_SEND_EMAIL_20',"Nous vous remercions d'avoir contacté FS. Nous avons reçu votre demande d'assistance et nous vous contacterons dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_21',"Nous vous remercions d'avoir contacté FS. Nous avons reçu votre demande d'assistance et nous vous contacterons dans un délai d'un jour ouvrable. Votre numéro de cas est");
define('FS_SEND_EMAIL_22',"Nous avons reçu votre demande de stock concernant l'article #");
define('FS_SEND_EMAIL_23'," et nous vous contacterons dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_24',"Nous avons reçu votre demande de stock concernant l'article ");
define('FS_SEND_EMAIL_25'," et nous vous contacterons dans un délai d'un jour ouvrable. Votre numéro de cas est ");
define('FS_SEND_EMAIL_26',". Vous pouvez vous référer à ce numéro dans toutes les communications de suivi concernant cette demande.");
define('FS_SEND_EMAIL_27',"Article(s)");
define('FS_SEND_EMAIL_28',"Vos Notes Supplémentaires");
define('FS_SEND_EMAIL_29',"Quantité de Demande : ");
define('FS_SEND_EMAIL_30',"Date d'Arrivée : ");
define('FS_SEND_EMAIL_31',"FS -  Nous avons reçu votre demande de stock ");
define('FS_SEND_EMAIL_32',"FS - Nous avons reçu votre demande de retour");
define('FS_SEND_EMAIL_33',"Nous avons reçu votre demande de remboursement et vous enverrons plus d'informations par e-mail dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_34',"FS - Nous avons reçu votre demande de remplacement");
define('FS_SEND_EMAIL_35',"Nous avons reçu votre demande de remplacement et vous enverrons plus d'informations par e-mail dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_36',"FS - Nous avons reçu votre demande de maintenance");
define('FS_SEND_EMAIL_37',"Nous avons reçu votre demande de maintenance et vous enverrons plus d'informations par e-mail dans un jour ouvrable.");
define('FS_SEND_EMAIL_38'," Instructions pour le retour de votre article FS");
define('FS_SEND_EMAIL_39',"Suivez ces étapes pour compléter le retour de votre commande #");
define('FS_SEND_EMAIL_40',"Retour de Commande");
define('FS_SEND_EMAIL_41'," et vous enverrons un e-mail contenant plus d'information concernant le remboursement dans un délai d'un jour ouvrable. ");
define('FS_SEND_EMAIL_42'," et vous enverrons un e-mail contenant plus d'informations concernant vos articles de remplacement dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_43'," et vous enverrons un e-mail contenant plus d'informations concernant la maintenance des produits dans un délai d'un jour ouvrable.");
define('FS_SEND_EMAIL_44',"Produits de remboursement");
define('FS_SEND_EMAIL_45',"Articles de remplacement");
define('FS_SEND_EMAIL_46',"Articles pour entretien");
define('FS_SEND_EMAIL_47',"Remboursement");
define('FS_SEND_EMAIL_48',"Nous sommes désolés d'apprendre que le(s) article(s) de votre commande");
define('FS_SEND_EMAIL_49'," ne vous convenaient pas. Pour compléter votre déclaration, veuillez suivre ces étapes simples :");
define('FS_SEND_EMAIL_50',"Dès réception de(s) article(s) retourné(s), nous vous rembourserons ");
define('FS_SEND_EMAIL_51',"(hors taxe) selon votre mode de paiement initial dans un délai d'un jour ouvrable. L'argent sera sur votre compte dans une semaine.");
define('FS_SEND_EMAIL_52'," Résumé");
define('FS_SEND_EMAIL_53',"Crédit de frais d'article(s) :");
define('FS_SEND_EMAIL_54',"Frais de Retour :");
define('FS_SEND_EMAIL_55',"Remboursement Total :");
define('FS_SEND_EMAIL_56',"Méthode de Remboursement :");
define('FS_SEND_EMAIL_57',"Méthode de Paiement Initial ");
define('FS_SEND_EMAIL_58',"Pour plus d'informations sur notre Politique de Retour, ");
define('FS_SEND_EMAIL_59',"veuillez cliquer ici");
define('FS_SEND_EMAIL_60',"Remplacement");
define('FS_SEND_EMAIL_61',"Nous sommes désolés d'apprendre que vous avez eu des problèmes avec votre commande");
define('FS_SEND_EMAIL_62'," Pour compléter le remplacement, veuillez suivre ces étapes simples :");
define('FS_SEND_EMAIL_63',"Dès la réception de(s) article(s) retourné(s), nous organiserons l'expédition de la commande de remplacement dès que possible et vous enverrons les informations de suivi lorsqu'elles seront disponibles.");
define('FS_SEND_EMAIL_64',"Maintenance");
define('FS_SEND_EMAIL_67',"Dès la réception de(s) article(s) retourné(s), nous organiserons la maintenance dès que possible et vous enverrons les informations de suivi lorsqu'elles seront disponibles.");
define('FS_SEND_EMAIL_68',"Résumé");
define('FS_SEND_EMAIL_69',"Expédier à");
define('FS_SEND_EMAIL_70',"Coordonnées");
define('FS_SEND_EMAIL_71',"Réf : PO#");
define('FS_SEND_EMAIL_83',"Prix : ");
//样品申请邮件
define('FS_SEND_EMAIL_84',"Nous avons reçu votre demande d'échantillon et nous vous tiendrons au courant des résultats dans les 24 heures.");
define('FS_SEND_EMAIL_85',"Nous avons reçu votre demande d'échantillon. Votre responsable de compte vous contactera bientôt. Voici votre numéro de cas ");
define('FS_SEND_EMAIL_86',". Vous pouvez vous référer à ce numéro dans toutes les communications de suivi concernant cette demande.");
define('FS_SEND_EMAIL_87',"Liste des Échantillons");
define('FS_SEND_EMAIL_88',"Quantité de Demande : ");
define('FS_SEND_EMAIL_89',"Vos Notes Supplémentaires");
define('FS_SEND_EMAIL_90',"FS - Nous avons reçu votre demande d'échantillon ");
//cumlums交换机发送激活码邮件
define('FS_SEND_EMAIL_91',"Clé de Licence");
define('FS_SEND_EMAIL_92',"Vos informations d'activation ont été envoyées avec succès.");
define('FS_SEND_EMAIL_94',"Votre clé de licence et les détails de votre commande sont fournis ci-dessous. Vous devrez installer cette clé de licence sur le commutateur pour activer le logiciel. Cette clé de licence est unique pour votre compte. Cela nous prendra environ 3 jours pour vous aider à l'activer. Veuillez copier et coller le texte de la clé de licence au moment approprié pendant le processus d'installation de la licence.");
define('FS_SEND_EMAIL_95',"Veuillez noter : La clé de licence sera effective à long terme.  La période de support technique est de 1 an, mais vous pouvez bénéficier de 45 jours supplémentaires gratuits si vous réalisez l'installation dans les 45 jours.");
define('FS_SEND_EMAIL_96',"Si vous avez des questions ou avez besoin d'assistance, veuillez nous contacter à ");
define('FS_SEND_EMAIL_97',"Clé de Licence");
define('FS_SEND_EMAIL_98',"Pour Cumulus Linux 2.5.3 ou versions ultérieures:");
define('FS_SEND_EMAIL_99',"N° de Commande : ");
define('FS_SEND_EMAIL_100',"Date : ");
define('FS_SEND_EMAIL_101',"Afficher Plus d'Info");
define('FS_SEND_EMAIL_102',"FS - Clé de Licence");
//付款链接
define('FS_SEND_EMAIL_103',"<br>Remarque :");
define('FS_SEND_EMAIL_104'," nous vous avons envoyé une demande de paiement");
define('FS_SEND_EMAIL_105',"N° de Facture : ");
define('FS_SEND_EMAIL_106',"Payer Maintenant");
define('FS_SEND_EMAIL_107',"FS - Vous avez une demande de paiement de ");
//分享购物车
define('FS_SEND_EMAIL_108',"Partager la Liste du Panier");
define('FS_SEND_EMAIL_109',"Votre ami ");
define('FS_SEND_EMAIL_110'," a partagé une liste du panier avec vous.");
define('FS_SEND_EMAIL_111',"Votre ami ");
define('FS_SEND_EMAIL_112'," a partagé une liste du panier avec vous. Vous pouvez cliquer sur le bouton ci-dessous pour voir les détails complets et ajouter à votre propre liste du panier.");
define('FS_SEND_EMAIL_113',"Liste du Panier");
define('FS_SEND_EMAIL_115',"Cet e-mail a été envoyé par ");
define('FS_SEND_EMAIL_116'," en utilisant le service Partager Avec Un Ami de ");
define('FS_SEND_EMAIL_117',"Service Partager avec un ami.");
define('FS_SEND_EMAIL_118',"À la suite de la réception de ce message, vous ne recevrez aucun message non sollicité de ");
define('FS_SEND_EMAIL_119',"en savoir plus sur notre ");
define('FS_SEND_EMAIL_120',"Politique de Confidentialité");
define('FS_SEND_EMAIL_121',"FS - Votre ami ");
define('FS_SEND_EMAIL_122'," a partagé une liste du panier avec vous");
//分享产品
define('FS_SEND_EMAIL_123',"Partager l'Article");
define('FS_SEND_EMAIL_124',"Cet article pourrait vous intéresser");
define('FS_SEND_EMAIL_125',"Plus de détails");
define('FS_SEND_EMAIL_126',"le service Partager avec un ami. À la suite de la réception de ce message, vous ne recevrez aucun message non sollicité de");
define('FS_SEND_EMAIL_127'," en savoir plus sur notre ");
define('FS_SEND_EMAIL_129'," a partagé un article avec vous");
//RMA取消订单邮件
define('FS_SEND_EMAIL_130',"Mise à jour du RMA");
define('FS_SEND_EMAIL_131',"Votre demande de RMA pour la commande# ");
define('FS_SEND_EMAIL_132'," a été annulé. Nous sommes là pour vous aider pour tout autre problème.");
define('FS_SEND_EMAIL_133',"RMA Annulé");
define('FS_SEND_EMAIL_135'," a été annulée.");
define('FS_SEND_EMAIL_136',"Nous sommes là pour vous aider pour tout autre problème.");
define('FS_SEND_EMAIL_137',"Articles de RMA");
//订单评价成功邮件
define('FS_SEND_EMAIL_138'," vous a envoyé une demande de paiement.");
define('FS_SEND_EMAIL_139',"Mise à Jour de la Commande");
define('FS_SEND_EMAIL_140',"FS - Votre Commande #");
define('FS_SEND_EMAIL_141',"Commande Annulée");
define('FS_SEND_EMAIL_142',"Nous vous remercions de faire vos achats chez nous et nous espérons vous revoir bientôt.");
define('FS_SEND_EMAIL_143',"Détails de la Commande");
//留言入口客户调查问卷
define('FS_SEND_EMAIL_144',"Partager Vos Commentaires");
define('FS_SEND_EMAIL_145',"Quelle est la probabilité que vous recommandiez FS à un ami ou un collègue ?");
define('FS_SEND_EMAIL_146',"Pour vous assurer de profiter de la meilleure expérience d'achat possible,<br> veuillez répondre à la question ci-dessus. Lorsque vous répondrez, on vous demandera de donner <br> une brève explication de votre évaluation. Tous les commentaires nous sont très utiles.");
//live_chat留言
define('FS_SEND_EMAIL_147',"Sujet du Commentaire");
define('FS_SEND_EMAIL_148',"Nous vous remercions d'avoir contacté FS. Nous avons reçu votre e-mail et nous vous contacterons dans les 12 heures.");
define('FS_SEND_EMAIL_149',"FS - Nous avons reçu votre e-mail");
define('FS_SEND_EMAIL_150',"Nous vous remercions d'avoir contacté FS. Nous avons reçu votre e-mail et nous vous contacterons dans les 12 heures. Votre numéro de cas est ");
define('FS_SEND_EMAIL_151',"Partager l'Article");
define('FS_SEND_EMAIL_152',"Cet article pourrait vous intéresser");
define('FS_SEND_EMAIL_153',"Votre ami ");
define('FS_SEND_EMAIL_154'," Cet e-mail a été envoyé par ");
define('FS_SEND_EMAIL_155'," a partagé cet article avec vous via ");
define('FS_SEND_EMAIL_156',"FS - Votre RMA a été annulé");
define('FS_SEND_EMAIL_157',"FS - Nous avons reçu votre demande de devis ");
define('FS_SEND_EMAIL_158',"Message de");
define('FS_SEND_EMAIL_159',"Ajouter au Panier");
//退换货需要翻译的英文部分
define('FS_SEND_EMAIL_160',"Votre Commande #");
define('FS_SEND_EMAIL_160_01',"FS - Votre Commande #");
define('FS_SEND_EMAIL_161',"FS - Votre Commande FS ");
define('FS_SEND_EMAIL_162',"Instruction de Retour");
define('FS_SEND_EMAIL_163',"1. Imprimer la RMA");
define('FS_SEND_EMAIL_164',"La RMA peut nous aider à reconnaître votre colis. Imprimez le formulaire RMA et fixez-le sur la boîte.");
define('FS_SEND_EMAIL_165',"2. Emballez le(s) article(s)");
define('FS_SEND_EMAIL_166',"Enlevez les anciennes étiquettes si vous utilisez la/les boîte(s) originale(s) et fixée(s) la RMA");
define('FS_SEND_EMAIL_167',"3. Expédiez-le");
define('FS_SEND_EMAIL_168',"Renvoyez-nous le colis");
define('FS_SEND_EMAIL_169',"4. Recevez Vos Articles de remplacement");
define('FS_SEND_EMAIL_170',"Nous vous remercions d'avoir contacté FS. Nous avons reçu votre demande d'appel et nous vous contacterons à votre meilleur moment.");
define('FS_SEND_EMAIL_171',"FS - Nous avons reçu votre demande d'appel");
define('FS_SEND_EMAIL_3_1',"Demande de Paiement");
define('FS_DAY_PROCESSING','<span class="process_time_dylan">$DAYNUMBER</span> jours pour la Production');
define('FS_DAY_PROCESSING_SEARCH','<span class="process_time_dylan">$DAYNUMBER</span> jours pour la Production');
define("PREORDER_DESPRCTION","Précommande se spécialise dans la recherche et le développement, et la chaîne de montage orientée au client. Elle est basée sur l'économie d'échelle et l'automatisation de la production qui nous permet de fournir à la clientèle l'achat en gros et des projets dont le budget est strictement contrôlé, des produits très économiques et la garantie d'une livraison beaucoup plus rapide que celles des autres commerçants.");
define("PRERDER_PROCESSIONG","<i class='popover_i'></i>La durée de  traitement se réfère au jour ouvrable, comprend la fabrication et les tests, à l'exception de la livraison, car celle-ci est déterminée par la vitesse d'expédition que vous avez choisie.");
define("PRERER_SAVE","pour économiser le budget de votre projet ");

//quest add 2019-03-01
define('CHECKOUT_CUSTOMER_ACCOUNT1','Veuillez entrer un compte valide composé de 9 numéros');
define('CHECKOUT_CUSTOMER_ACCOUNT2','Veuillez entrer un compte valide composé de 6 caractères');

// fairy 2019.1.17 组合子产品
define("FS_ITEM_INCLUDES_PRODUCTS","Cet article inclut les produits suivants");


define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total general');
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');

define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+)Shipping Cost:');
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Total');
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');

//2019.3.9   ery  add 专题询价板块
define('FS_SPECILA_INQUIRY_QUESTION', 'Vous avez des questions ? Nous vous répondrons dans les plus brefs délais.');
define('FS_SPECILA_INQUIRY_ASK', 'Si vous avez des questions sur les prix, la livraison ou toute autre chose, nos responsables hautement qualifiés sont là pour vous aider.');

//rebirth.ma  2019.03.12  上传错误定义
define("FS_FILE_TOO_LARGE","Le fichier est trop volumineux, la mise en ligne a échoué");

define('FIBERSTORE_PRODUCT_DETAIL','Détails de Produit');

//rebirth.ma  2019.03.22  购物车样式调整
define("FS_Summary","Récapitulatif");


//liang.zhu 2019.04.02 定义tpl_modules_index_product_list_old_style.php
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'Vue tableau');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'Vue liste');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'Recherche rapide');






//2019.4.4  ery  ADD俄罗斯对公支付方式名
define("FS_CHECKOUT_NEW_CASHLESS","Paiement sans Numéraire");
define("SHIPPING_COURIER_DELIVERY","Courier delivery");
define("SHIPPING_DELIVERY","Moyen de Livraison");
define("SHIPPING_COURIER_DELIVERY_01"," pour Personne Physique");
//2019.4.11  ery add  俄罗斯对公支付收税政策文字表达优化
define('CHECKOUT_TAXE_RU_TIT', 'Conformément au Chapitre 21 du Code des Impôts de la Fédération de Russie, FS.COM Ltd est obligé de facturer la TVA sur toutes les commandes  livrées à la Russie. Tous les articles de notre catalogue sont soumis au taux normal de TVA de 20% selon la Loi Fiscale Générale de Russie. Si vous remplissez toutes les informations nécessaires concernant la commande (notamment le type d\'entreprise et l\'adresse de livraison), vous connaîtrez le montant total et le TVA , avant d\'effectuer le paiement.');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","Pour les commandes de personnes physiques et expédiées depuis notre entrepôt international, nous ne facturerons QUE la valeur du produit et les frais d'expédition. Tout droit de douane ou d'importation causé par le dédouanement doit être déclaré et supporté par le destinataire. Depuis le 1er janvier 2020, la limite pour les achats hors taxes a été abaissée à 200 € et jusqu'à 31 kg par paquet. Si vous êtes intéressé par d'autres méthodes de livraison ou souhaitez payer par paiement sans numéraire, veuillez contacter votre responsable de compte.");
define("FS_EMAIL_ERROR","Votre adresse e-mail est incorrecte");

define("FS_CREDIT_CARD_NOTICE","Veuillez entrer votre adresse de facturation pour procéder au paiement.");
//ternence.qin
define('FS_CREDIT','Mon Compte de Crédit');

//Jeremy.Wu 2019.4.17 定义本地取货
define('FS_LOCAL_PICKUP','Retirer Moi-Même');

//报价改版 ternence 2019.04.17
define("FS_INQUIRY_INFO","Liste de Devis");
define("FS_INQUIRY_INFO_1","Ajouter de Nouveaux Produits");
define("FS_INQUIRY_INFO_2","Ajouter");
define("FS_INQUIRY_INFO_3","L'ID de produit en ligne est requis.");
define("FS_INQUIRY_INFO_4","Prix Unitaire");
define("FS_INQUIRY_INFO_5"," Remarque ");
define("FS_INQUIRY_INFO_6","Éditer");
define("FS_INQUIRY_INFO_7","Avez-vous un Compte Existant ?");
define("FS_INQUIRY_INFO_8","Vous connecter</a> ou ");
define("FS_INQUIRY_INFO_9","Créez un Compte");
define("FS_INQUIRY_INFO_10","  pour suivre votre demande en ligne.");
define("FS_INQUIRY_INFO_11","Informations qui peuvent vous Intéresser à Propos du Devis");
define("FS_INQUIRY_INFO_12","Logo");
define("FS_INQUIRY_INFO_13","Garantie");
define("FS_INQUIRY_INFO_14","Délai");
define("FS_INQUIRY_INFO_15","Prix de Gros");
define("FS_INQUIRY_INFO_16","Commande PO");
define("FS_INQUIRY_INFO_17","Commentaires Supplémentaires");
define("FS_INQUIRY_INFO_18","Fichier");
define("FS_INQUIRY_INFO_19","Autoriser les fichiers de type JPG, PDF, PNG, XLS, XLSX <br> Taille maximale du fichier : 5M");
define("FS_INQUIRY_INFO_20","Envoyer la Demande");
define("FS_INQUIRY_INFO_21","La demande de devis est vide.");
define("FS_INQUIRY_INFO_22","Continuer Vos Achats");
define("FS_INQUIRY_INFO_24","Il nous faudra environ 12 heures pour réviser.");
define("FS_INQUIRY_INFO_25","Demander un Devis");
define("FS_INQUIRY_INFO_26","L'article ci-dessous est un produit personnalisé. Veuillez vous rendre sur la page du produit pour sélectionner l'attribut en premier, puis l'ajouter à la liste des devis.");
define("FS_INQUIRY_INFO_26_2","L’ID du produit");
define("FS_INQUIRY_INFO_26_3"," n’est pas trouvé dans nos records.");
define("FS_INQUIRY_INFO_27","Votre demande de devis N°");
define("FS_INQUIRY_INFO_28"," est envoyée.");
define("FS_INQUIRY_INFO_29","Nous traiterons le devis et vous répondrons dans les 12-24 heures. Vous pouvez consulter l'état de devis dans <b>Mon Dompte</b> > <b>Historique de Devis</b>. ");
define("FS_INQUIRY_INFO_30","Bonjour ! ");
define("FS_INQUIRY_INFO_30_1","Choisir l'Attribut ");
define("FS_INQUIRY_INFO_31","Avec un compte, vous pouvez voir facilement le devis dans votre compte et bénéficier d'un meilleur service FS, y compris :");
define("FS_INQUIRY_INFO_32","- Suivre facilement via votre historique de commande");
define("FS_INQUIRY_INFO_33","- Passer la commande facilement avec un carnet d'adresses");
define("FS_INQUIRY_INFO_34","Voulez-vous créer un compte maintenant ?");
define("FS_INQUIRY_INFO_35","Non, merci. (Nous répondrons à votre devis par e-mail)");
define("FS_INQUIRY_INFO_36","Oui, je veux créer un compte maintenant.");

define("FS_INQUIRY_INFO_37","Historique de Devis");
define("FS_INQUIRY_INFO_38","Vérifiez le statut de vos devis et achetez directement avec les prix préférentiels. ");
define("FS_INQUIRY_INFO_39","Contactez le Service Client");
define("FS_INQUIRY_INFO_40","Date de Devis");
define("FS_INQUIRY_INFO_41","Devis #");
define("FS_INQUIRY_INFO_42","Total");
define("FS_INQUIRY_INFO_43","Nom du Devis");
define("FS_INQUIRY_INFO_43_1","Voir Plus");
define("FS_INQUIRY_INFO_43_2","Annuler le Devis");

define("FS_INQUIRY_INFO_44","Ajouté au Devis");
define("FS_INQUIRY_INFO_45","Qté.");
define("FS_INQUIRY_INFO_46","Voir la Liste");
define("FS_INQUIRY_INFO_47","Obtenir un Devis");
define("FS_INQUIRY_INFO_48","Liste des Devis");
define("FS_INQUIRY_INFO_23"," Votre demande de devis. ");
define("FS_INQUIRY_INFO_23_1"," a été envoyée.");
define("FS_INQUIRY_INFO_49","Nom du Devis :");
define("FS_INQUIRY_INFO_50","Ce devis expirera après X jours. Veuillez passer la commande le plus tôt possible.");
define("FS_INQUIRY_INFO_51","Votre devis a expiré.");
define("FS_INQUIRY_INFO_52","Remarque");
define("FS_INQUIRY_INFO_54","N° d'Article#");
define("FS_INQUIRY_INFO_55","L'ID de produit en ligne est nécessaire.");
define("FS_INQUIRY_INFO_56","Nom*");
define("FS_INQUIRY_INFO_57","Adresse E-mail*");
define("FS_INQUIRY_INFO_58","Numéro de Téléphone*");
define("FS_INQUIRY_INFO_59","L'ID de produit ");
define("FS_INQUIRY_INFO_60"," n'a pas été trouvé dans nos dossiers.");
define("FS_INQUIRY_INFO_61","Nommez Votre Devis");
define("FS_INQUIRY_INFO_62","Numéro de Devis");
define("FS_INQUIRY_INFO_63","Veuillez choisir une option pour chaque attribut.");
define("FS_INQUIRY_BUY_TIP",'Ce devis n\'est valable que pendant 15 jours et la quantité d\'achat doit être égale ou supérieure à la quantité de demande, veuillez effectuer votre commande dès que possible.');
define("FS_INQUIRY_INFO_53","Liste de Demande de Devis");
define("FS_INQUIRY_INFO_64","Tous les Devis");
define("FS_INQUIRY_INFO_65","Cette cotation n'est valable que pendant 15 jours. Veuillez commander le plus tôt possible.");
define("FS_INQUIRY_INFO_66","Votre devis a expiré.");

define('FS_INQUIRY_EMPTY_TXT','La demande de devis est vide.');
define('FS_INQUIRY_EMPTY_TXT_01','Envoyer une demande de devis sur les détails du produit ou entrer le N° d\'article# directement.');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">Si vous avez déjà un compte FS, <a href="'.zen_href_link('login','','SSL').'">Connectez-Vous</a> pour voir votre Demande de Devis.</p>');

define('FS_ACCOUNT_NEW_01',"Besoin d'Aide ?");
define('FS_ACCOUNT_NEW_02','Lundi - Vendredi');
define('FS_ACCOUNT_NEW_03','Commandes');
define('FS_ACCOUNT_NEW_04','Mes Commandes');
define('FS_ACCOUNT_NEW_05','Retournée');
define('FS_ACCOUNT_NEW_06','Ligne de Crédit Disponible :');
define('FS_ACCOUNT_NEW_07','Commande Récente');
define('FS_ACCOUNT_NEW_08','Voir Mes Commandes');
define('FS_ACCOUNT_NEW_09',"Vous n’avez pas fait d’achat depuis un moment.");
define('FS_ACCOUNT_NEW_10','Votre Historique de Navigation');
define('FS_ACCOUNT_NEW_11','Devis Récent');
define('FS_ACCOUNT_NEW_12','Voir Mes Devis');
define('FS_ACCOUNT_NEW_13',"Vous n'avez pas demandé de devis."); 

//2019.5.3 pico 企业账号注册

define("FS_BUSINESS_ACCOUNT_01","Avantages de Compte d'Entreprise");
define("FS_BUSINESS_ACCOUNT_02","Créer un compte d'entreprise FS aujourd'hui et bénéficier de 2% de réduction sur les produits et services, ainsi que d'autres avantages.");
define("FS_BUSINESS_ACCOUNT_03","Prix Préférentiel");
define("FS_BUSINESS_ACCOUNT_04","Livraison Rapide");
define("FS_BUSINESS_ACCOUNT_05","Devis en Ligne Faciles");
define("FS_BUSINESS_ACCOUNT_06","Personnalisation Professionnelle");
define("FS_BUSINESS_ACCOUNT_07",'Vous avez déjà un compte ? <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">Mise à Niveau le Compte</a>');
define("FS_BUSINESS_ACCOUNT_08",'Besoin d\'Aide ? Nous sommes ici 24/7');
define("FS_BUSINESS_ACCOUNT_09",'Chat en Ligne');
if ($_SESSION['countries_iso_code'] == 'ca'){
    define("FS_BUSINESS_ACCOUNT_10", '+1 (647) 243 6342');
}else {
    define("FS_BUSINESS_ACCOUNT_10", '+33 (1) 82 884 336');
}
define("FS_BUSINESS_ACCOUNT_11",'fr@fs.com');
define("FS_BUSINESS_ACCOUNT_12",'La demande de compte d\'entreprise a été envoyée.');
define("FS_BUSINESS_ACCOUNT_13",'Bienvenue chez FS, nous avons reçu votre demande et votre responsable de compte examinera votre demande de mise à niveau vers un compte d\'entreprise dès que possible.');
define("FS_BUSINESS_ACCOUNT_14",'Votre demande a été reçue, veuillez attendre la vérification et la validation.');
define("FS_BUSINESS_ACCOUNT_15",'Cliquez ici pour entrer dans votre centre de compte');
define("FS_BUSINESS_ACCOUNT_16",'Votre demande de compte d\'entreprise est en cours de révision.');
define("FS_BUSINESS_ACCOUNT_17",'Pas de compte ? <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '">Créer un Compte d\'Entreprise</a>');
define("FS_BUSINESS_ACCOUNT_18","Créer un compte d'entreprise");
define("FS_BUSINESS_ACCOUNT_19","Mettre à niveau le compte");
define("FS_BUSINESS_ACCOUNT_20",'Votre Demande de Compte d\'Entreprise a été Envoyée.');
//add by rebirth  结算页超重超大标签
define('FS_HEAVY','Lourd');

define('FS_OVERSIZED','Surdimensionné');

//add by jeremy 各语种公司名称
define('FS_LOCAL_COMPANY_NAME','FS.COM GmbH');
define('FS_US_COMPANY_NAME','FS.COM Inc.');
define('FS_DE_COMPANY_NAME','FS.COM GmbH');
define('FS_UK_COMPANY_NAME','FIBERSTORE Ltd.');
define('FS_AU_COMPANY_NAME','FS.COM Pty Ltd');
define('FS_SG_COMPANY_NAME','FS Tech Pte Ltd.');
define('FS_RU_COMPANY_NAME','FS.COM Ltd.');
define('FS_CN_COMPANY_NAME','FS.COM LIMITED');

//amp语言包
//十个专题模块
define('FS_AMP_CATE_01','25G/100G');
define('FS_AMP_CATE_02','40G');
define('FS_AMP_CATE_03','10G');
define('FS_AMP_CATE_04','DAC/AOC');
define('FS_AMP_CATE_05','Switches');
define('FS_AMP_CATE_06','WDM<br>MUX');
define('FS_AMP_CATE_07','Câbles Optiques');
define('FS_AMP_CATE_08','Câbles<br>MTP/MPO');
define('FS_AMP_CATE_09','Câblage<br>Modulaire');
define('FS_AMP_CATE_10','Réseau<br>en Cuivre');
//Interconnection产品模块
define('FS_AMP_INTERCONNECT_01','Interconnexion');
//Optical Transport Network产品模块
define('FS_AMP_OPTICAL_TRANS_01','Assemblages de Réseau');
//Network Cable Assemblies产品模块
define('FS_AMP_NETWORK_CABLE_01','Réseau de Transport Optique');
//Space Management产品模块
define('FS_AMP_SPACE_MANAGE_01','Gestion de l\'Espace');
//Solution模块
define('FS_AMP_SOLUTION_01','Solutions');
//公共底部模块
define('FS_AMP_FOOTER_01','E-mail');
define('FS_AMP_FOOTER_02','Chat en Ligne');
define('FS_AMP_FOOTER_03','Live ChaSupport');
define('FS_AMP_FOOTER_04','Company');
define('FS_AMP_FOOTER_05','Quick Access');
define('FS_AMP_FOOTER_06','Copyright © 2009-2019 FS.COM Inc All Rights Reserved.');
define('FS_AMP_FOOTER_07','Privacy policy');
define('FS_AMP_FOOTER_08','Terms of use');
//第一级侧边栏
define('FS_AMP_FIRST_SIDEBAR_01','Compte / Se connecter');
define('FS_AMP_FIRST_SIDEBAR_02','Catégories');
define('FS_AMP_FIRST_SIDEBAR_03','Mise en Réseau');
define('FS_AMP_FIRST_SIDEBAR_04','Modules Optiques');
define('FS_AMP_FIRST_SIDEBAR_05','Câbles à Fibre Optique');
define('FS_AMP_FIRST_SIDEBAR_06','Racks & Tiroirs');
define('FS_AMP_FIRST_SIDEBAR_07','WDM & Accès Optique');
define('FS_AMP_FIRST_SIDEBAR_08','Cat5e/Cat6/Cat7/Cat8');
define('FS_AMP_FIRST_SIDEBAR_09','Testeurs & Outils Optiques');
define('FS_AMP_FIRST_SIDEBAR_10','Support');
define('FS_AMP_FIRST_SIDEBAR_11','Company');
define('FS_AMP_FIRST_SIDEBAR_12','Quick Access');
define('FS_AMP_FIRST_SIDEBAR_13','Aide & Paramètres');
//所有二级分类侧边栏
define('FS_AMP_SECOND_SIDEBAR_01','Menu');
define('FS_AMP_SECOND_SIDEBAR_02','Mise en Réseau');
define('FS_AMP_SECOND_SIDEBAR_03','Switches Réseau');
define('FS_AMP_SECOND_SIDEBAR_04','Système d\'Alimentation, PDU, UPS');
define('FS_AMP_SECOND_SIDEBAR_05','PDU, UPS, Power System');
define('FS_AMP_SECOND_SIDEBAR_06','Cartes Réseau');
define('FS_AMP_SECOND_SIDEBAR_07','Routeurs, Serveurs');
define('FS_AMP_SECOND_SIDEBAR_08','Convertisseurs de Média, KVM, TAP');
define('FS_AMP_SECOND_SIDEBAR_09','Modules Optiques');
define('FS_AMP_SECOND_SIDEBAR_10','40G/100G Modules Optiques');
define('FS_AMP_SECOND_SIDEBAR_11','SFP+ Modules Optiques');
define('FS_AMP_SECOND_SIDEBAR_12','SFP Modules Optiques');
define('FS_AMP_SECOND_SIDEBAR_13','Câbles à Attache Directe');
define('FS_AMP_SECOND_SIDEBAR_14','Câbles Optiques Actifs');
define('FS_AMP_SECOND_SIDEBAR_15','XFP Modules Optiques');
define('FS_AMP_SECOND_SIDEBAR_16','Modules Optiques Vidéo');
define('FS_AMP_SECOND_SIDEBAR_17','Autres Modules Optiques');
define('FS_AMP_SECOND_SIDEBAR_18','Boîte FS');
define('FS_AMP_SECOND_SIDEBAR_19','Câbles à Fibre Optique');
define('FS_AMP_SECOND_SIDEBAR_20','Câblage à Fibre Optique MTP');
define('FS_AMP_SECOND_SIDEBAR_21','Jarretières Optiques');
define('FS_AMP_SECOND_SIDEBAR_22','Câbles à Fibre Optique Renforcés');
define('FS_AMP_SECOND_SIDEBAR_23','Câblage à Fibre Optique MPO');
define('FS_AMP_SECOND_SIDEBAR_24','Câbles à Ultra-Haute Densité');
define('FS_AMP_SECOND_SIDEBAR_25','Câbles Multifibres Pré-Connectorisés');
define('FS_AMP_SECOND_SIDEBAR_26','Pigtails à Fibre Optique');
define('FS_AMP_SECOND_SIDEBAR_27','Adaptateurs & Connecteurs à Fibre Optique');
define('FS_AMP_SECOND_SIDEBAR_28','Câbles Optiques en Vrac');
define('FS_AMP_SECOND_SIDEBAR_29','Racks & Tiroirs');
define('FS_AMP_SECOND_SIDEBAR_30','Racks & Baies');
define('FS_AMP_SECOND_SIDEBAR_31','Tiroirs Optiques Modulaires');
define('FS_AMP_SECOND_SIDEBAR_32','Panneaux de Brassage');
define('FS_AMP_SECOND_SIDEBAR_33','Cassettes à Fibre Optique MTP');
define('FS_AMP_SECOND_SIDEBAR_34','Cassettes à Fibre Optique MPO');
define('FS_AMP_SECOND_SIDEBAR_35','Cassettes à Fibre Optique');

define('FS_AMP_SECOND_SIDEBAR_57','Panneaux Breakout MTP-LC');
define('FS_AMP_SECOND_SIDEBAR_58','Gestion de Câbles');
define('FS_AMP_SECOND_SIDEBAR_59','Système de Chemin de Câble');

define('FS_AMP_SECOND_SIDEBAR_36','WDM & Accès Optique');
define('FS_AMP_SECOND_SIDEBAR_37','Mux Demux & OADM');
define('FS_AMP_SECOND_SIDEBAR_38','Composants Passifs');
define('FS_AMP_SECOND_SIDEBAR_39','Terminaison Optique');
define('FS_AMP_SECOND_SIDEBAR_40','Plate-forme de Transport WDM FMT');
define('FS_AMP_SECOND_SIDEBAR_41','Modules d\'Infrastructure FMT');
define('FS_AMP_SECOND_SIDEBAR_42','Nettoyages & Testeurs');
define('FS_AMP_SECOND_SIDEBAR_43','Cat5e/Cat6/Cat7/Cat8');
define('FS_AMP_SECOND_SIDEBAR_44','Câbles Réseau');
define('FS_AMP_SECOND_SIDEBAR_45','Câbles Trunk Pré-connectorisés');
define('FS_AMP_SECOND_SIDEBAR_46','Câbles en Vrac');
define('FS_AMP_SECOND_SIDEBAR_47','Panneaux de Brassage');
define('FS_AMP_SECOND_SIDEBAR_48','Gestion de Câbles');
define('FS_AMP_SECOND_SIDEBAR_49','Outils & Testeurs Réseau');
define('FS_AMP_SECOND_SIDEBAR_50','Testeurs & Outils Optiques');
define('FS_AMP_SECOND_SIDEBAR_51','Nettoyage à Fibre Optique');
define('FS_AMP_SECOND_SIDEBAR_52','Testeurs Fondamentaux');
define('FS_AMP_SECOND_SIDEBAR_53','Testeurs Avancés');
define('FS_AMP_SECOND_SIDEBAR_54','Polissage & Soudure à Fibre Optique');
define('FS_AMP_SECOND_SIDEBAR_55','Outils à Fibre Optique');
define('FS_AMP_SECOND_SIDEBAR_56','Outils & Testeurs Réseau');
//三级分类侧边栏
define('FS_AMP_THIRD_SIDEBAR_01','Go back');
//登陆后侧边栏
define('FS_AMP_LOGIN_SIDEBAR_01','My Account');
define('FS_AMP_LOGIN_SIDEBAR_02','Account Setting');
define('FS_AMP_LOGIN_SIDEBAR_03','Order History');
define('FS_AMP_LOGIN_SIDEBAR_04','Address Book');
define('FS_AMP_LOGIN_SIDEBAR_05','My Cases');
define('FS_AMP_LOGIN_SIDEBAR_06','My Quotes');
define('FS_AMP_LOGIN_SIDEBAR_07','Sign out');
//搜索侧边栏
define('FS_AMP_SEARCH_01','Recherche Chaude');
//语言选择
define('FS_AMP_SELECT_LANG_01','Sélectionnez votre Pays/Région');
define('FS_AMP_SELECT_LANG_02','Sauvegarder');
//订阅功能语言包(单页面，账户中心)
define('FS_EMAIL_SUBSCRIPTION_01','Abonnement par E-mail');
define('FS_EMAIL_SUBSCRIPTION_02','Gérez vos préférences d\'abonnement par e-mail et obtenez les dernières nouvelles de FS.');
define('FS_EMAIL_SUBSCRIPTION_03','Abonnement par E-mail');
define('FS_EMAIL_SUBSCRIPTION_04','Confirmez l\'e-mail d\'abonnement que vous souhaitez gérer.');
define('FS_EMAIL_SUBSCRIPTION_05','Abonnez-vous aux e-mails FS pour en savoir plus sur les dernières politiques préférentielles, l’information d\'inventaire, le support technique, etc. Qu\'il s\'agisse de nouveaux produits ou de solutions de centres de données dont vous n\'êtes peut-être pas au courant, les e-mails de FS vous tiendront informés !');
define('FS_EMAIL_SUBSCRIPTION_06','Les e-mails concernant votre compte et vos commandes sont importants. Nous les envoyons même si vous avez choisi de ne plus recevoir de newsletter.');
define('FS_EMAIL_SUBSCRIPTION_07','Veuillez noter : Cela peut prendre jusqu\'à 48 heures pour que les modifications soient appliquées. Vous recevrez toujours des e-mails concernant les commandes, les politiques préférentielles, l\'information d\'inventaire et le support technique même si vous vous êtes désabonné.');
define('FS_EMAIL_SUBSCRIPTION_08','À quelle fréquence souhaitez-vous recevoir des newsletters ?');
define('FS_EMAIL_SUBSCRIPTION_09','Régulier');
define('FS_EMAIL_SUBSCRIPTION_10','Pas plus d\'une fois par semaine');
define('FS_EMAIL_SUBSCRIPTION_11','Pas plus d\'une fois par mois');
define('FS_EMAIL_SUBSCRIPTION_12','Jamais');
define('FS_EMAIL_SUBSCRIPTION_13','Envoyer');
define('FS_EMAIL_SUBSCRIPTION_14','Annuler');
define('FS_EMAIL_SUBSCRIPTION_15','Votre demande a été envoyée avec succès !');
define('FS_EMAIL_SUBSCRIPTION_16','Nous vous répondrons dans les 24 heures.');
define('FS_EMAIL_SUBSCRIPTION_17','Veuillez entrer votre propre adresse e-mail.');
define('FS_EMAIL_SUBSCRIPTION_18','Consulter, modifier ou annuler vos abonnements.');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span>Vous vous êtes désabonné avec succès.');
define('FS_EMAIL_SUBSCRIPTION_20','Vous ne recevrez plus de newsletter de FS.');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>Vous vous êtes abonné avec succès.');
define('FS_EMAIL_SUBSCRIPTION_22','Merci pour vous être abonné aux e-mails de FS.');
define('FS_EMAIL_SUBSCRIPTION_23','Envoyez-moi un e-mail mensuel sur les derniers développements de FS.');
define('FS_EMAIL_SUBSCRIPTION_24','Vous ne recevrez plus d\'e-mails de demande de commentaire FS.');
define('FS_EMAIL_SUBSCRIPTION_25','Vous ne recevrez plus d\'e-mails promotionnels et de demande de commentaire FS.');

//底部订阅语言包
define('FS_EMAIL_SUBSCRIPTION_FOOTER_01','S\'abonner');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02','Obtenir les dernières nouvelles de FS');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03','Votre Adresse E-mail');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04','Veuillez entrer votre adresse e-mail.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05','Veuillez entrer une adresse e-mail valide.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06','Merci pour votre abonnement !');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','App Mobile');
//2019.5.27 新政策弹窗 pico
define('FS_SHIPPING_RETURNS','<a class="info_returns" href="javascript:;">'.FS_DELIVERY_RETURN.'</a>');
define('FS_SHIPPING_WARRANTY','<a class="info_warranty" href="javascript:;">Garantie</a>');
define('FS_SHIPPING_SUPPORT','<a class="" href="'.reset_url('product_support.html?products_id=###').'" target="_blank">Support Technique</a>');;
define('FS_SHIPPING_RETURNS_TITLE','Retour dans les 30 Jours');
define('FS_SHIPPING_RETURNS_PART',"FS offre un service de retour et de remplacement pour un délai de 30 jours afin de vous garantir une expérience d'achat sans souci. Si le retour ou le remplacement est causé par notre faute, nous serons responsables de tous les frais d'expédition et des taxes. Veuillez visiter la page de <a href ='".zen_href_link('index')."policies/day_return_policy.html' target='_blank'>Politique de Retour</a> pour en savoir plus.");
define('FS_SHIPPING_WARRANTY_TITLE','Garantie sur Toute la Gamme de Produits');
define('FS_SHIPPING_WARRANTY_PART',"Si quelque chose ne va pas avec le produit et la période de retour est déjà passée, ne vous inquiétez pas. Tant que le produit est dans la période de garantie, vous pouvez bénéficier d'un service d'entretien gratuit. Veuillez consulter la <a href ='".zen_href_link('index')."policies/warranty.html' target='_blank'>Politique de Garantie</a> pour connaître la période de garantie particulière des produits.");
define('FS_SHIPPING_SUPPORT_TITLE','Support Technique Gratuit');
define('FS_SHIPPING_SUPPORT_PART',"FS s'engage à devenir un partenaire de confiance pour ses clients et offre une gamme complète de produits d'infrastructure et de solutions numériques.");
define('FS_SHIPPING_SUPPORT_PART_BR',"Vous pouvez <a href='".reset_url('solution_support.html')."' target='_blank'>Demander un Support Technique</a> pour obtenir une aide rapide pour toute question relative aux articles ou pour la conception d'une solution de connectivité gratuite.");

//add by ternence 询价产品弹窗
define('FS_PRODUCT_INQUIRY_3','FS a bien reçu votre devis. Nous vous donnerons les réponses plus tard.');
define('FS_PRODUCT_INQUIRY_1','Nous vous répondrons dans les 24 heures.');
define('FS_PRODUCT_INQUIRY_2','En cliquant sur le bouton ci-dessous, vous acceptez notre <a href="javascript:;" class="">Politique de Confidentialité & Cookiess</a> et <a href="javascript:;">Conditions d\'Utilisation</a>.');
define('FS_SALES_INFO_MODAL_ZIP_CODE','Code Postal*');
//退换货指引入口
define('FS_RETURN_BUTTON','Retourner un Article');

//登陆超时
define('LOING_TIMEOUT','Pour des raisons de sécurité, votre connexion a expiré. Veuillez vous connecter à nouveau.');
//产品详情AOC
define('PRODUCT_AOC','Selon vos besoins, la longueur du câble peut être personnalisée de 1m à 300m (3ft à 984.252ft) .');
define('PRODUCT_AOC_1','Selon vos besoins, la longueur du câble peut être personnalisée de 1m à 30m (3ft à 98.43ft).');
//报价列表
define('QUOTE_EMPTY_1',"Vous n'avez envoyé aucune demande de devis.");
define('QUOTE_EMPTY_2','Commencer Vos Achats');
define('QUOTE_EMPTY_3',"On n'a trouvé aucune demande de devis.");

define("ATTRIBUTE_MESSAGE",'Entièrement compatible avec les commutateurs Cisco, pour la Matrice de Compatibilité, veuillez <a target="_blank" href="https://tmgmatrix.cisco.com"> cliquer ici</a>.');

//首页cart sign in翻译
define('FILENAME_SIGN_IN','Connexion');
define('FILENAME_HOME_CART','Panier');

//购物车登陆且为空的状态 添加save cart入口
define('FS_SAVE_CART_ENTRANCE','Continuez vos achats sur FS ou consultez vos <a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">Paniers Enregistrés</a>.');
//报价添加打印
define('INQUIRY_GET_A_QUOTE','Besoin d\'aide pour votre achat ?');
define('INQUIRY_GET_A_QUOTE_1',"Nous nous engageons toujours à vous offrir des articles de la plus haute qualité, des prix favorables pour les commandes de grande quantité, et un traitement dans les plus brefs délais une fois la commande passée. Appelez-nous au ");
define('INQUIRY_GET_A_QUOTE_2',' ou nous envoyez un e-mail à ');
define('INQUIRY_GET_A_QUOTE_3','Imprimer le Devis');
define('INQUIRY_GET_A_QUOTE_4','DÉTAILS DU DEVIS ');
define('INQUIRY_GET_A_QUOTE_5','Qté (pcs)');
define('INQUIRY_GET_A_QUOTE_6','Prix Coté');

//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', 'Compte du Client');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', 'Disponible, En Production');
define('QV_SHOW_AVAILABLE_02', 'Disponible, En Transit');

//清仓产品加购限制 Dylan 2019.8.27
define('FS_CLEARANCE_TIPS_TITLE','Quantité Disponible Insuffisante');
define('FS_CLEARANCE_TIPS_CONTENT','La quantité dont vous avez besoin est supérieure aux stocks disponibles <span class="clearance_total_qty">$QTY</span>, veuillez contacter votre responsable de compte pour connaître une quantité supplémentaire.');
define('QV_CLEARANCE_TIPS','La quantité dont vous avez besoin est supérieure aux stocks disponibles <span class="clearance_total_qty">$QTY</span>.');
define('QV_CLEARANCE_EMPTY_QTY_TIPS','Ce produit est en rupture de stock, veuillez contacter votre responsable de compte pour connaître les disponibilités.');


//文章分类
define('CASE_STUDIES_01','Région');
define('CASE_STUDIES_02','Amérique du Nord');
define('CASE_STUDIES_03','Amérique Latine');
define('CASE_STUDIES_04','Europe');
define('CASE_STUDIES_05','Océanie');
define('CASE_STUDIES_06','Afrique');
define('CASE_STUDIES_07','Moyen-Orient');
define('CASE_STUDIES_08','Asie');
define('CASE_STUDIES_09','Type de Cas');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','Réseau d\'Entreprise');
define('CASE_STUDIES_12','Câblage de Centre de Données');
define('CASE_STUDIES_13','Industrie');
define('CASE_STUDIES_14','Finances');
define('CASE_STUDIES_15','Éducation');
define('CASE_STUDIES_16','Santé');
define('CASE_STUDIES_17','ISP');
define('CASE_STUDIES_18','Fabrication');
define('CASE_STUDIES_19','Transport');
define('CASE_STUDIES_20','commerce de Détail');
define('CASE_CLEAR_ALL','Tout Effacer');
define("FS_PRODUCTS","Résultats");
define("FS_PRODUCT","Résultat");
define('CASE_CATEGORY_MENU_CASE_STUDIES','Études de Cas');

define('FS_TEST_TOOL','Outil de Test');


// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','Correspondre aux <a href="fr/c/fhd-rack-mount-45" style="color: #0070BC;">tiroirs optiques de montage en rack FHD</a> et aux <a href="fr/c/fhd-wall-mount-3358" style="color: #0070BC;">tiroirs optiques de montage murals FHD</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_2','Correspondre aux tiroirs optiques <a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> pouvant être montés sur un rack 19"');
define('FS_PRODUCT_INSTALLATION_TEXT_3','Correspondre aux tiroirs optiques <a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> pouvant être montés sur un rack 19"');
define('FS_PRODUCT_INSTALLATION_TEXT_4','Correspondre aux tiroirs optiques <a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a> pouvant être montés sur un rack 19"');
define('FS_ADDRESS_PO','PO');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','Compatible avec les baies serveur & réseau - <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">Séries GR800</a> et <a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;">Séries HR800</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_6','Compatible avec les baies serveur - <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">Séries GR600</a> et <a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;">Séries HR600</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_7','Compatible avec les baies - <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">Séries GR800</a> et <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">Séries GR600</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_8','Compatible avec les baies serveur & réseau - <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">Séries GR800</a>');
define('FS_PRODUCT_INSTALLATION_TEXT_9','FMX Module 100G s\'adapte au châssis <a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color: #0070BC;">FMX-100G-CH2U</a> qui peut être monté sur un rack');

// add by pico
define('CHECKOUT_ERROR_01', 'Veuillez sélectionner le type de paiement.');
define('CHECKOUT_ERROR_02', 'Le Nom du Titulaire de la carte est nécessaire.');
define('CHECKOUT_ERROR_03', 'Le Numéro de Carte est nécessaire.');
define('CHECKOUT_ERROR_04', 'Le Code de Sécurité est requis.');

//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'Découvrir les Solutions');
define('FS_BEST_SELLERS', 'Meilleures Ventes');
define('FS_CASE_STUDIES', 'Études de Cas');

//add ternence
define('INQUIRY_TITLE','Envoyez Votre Demande de Devis par E-mail');
define('INQUIRY_TITLE_1','Votre Liste de Devis Partagé');
define('INQUIRY_TITLE_2','L\'E-mail a été Envoyé avec Succès');
define('INQUIRY_TITLE_3','Votre demande de devis a été envoyée avec Succès');
define('INQUIRY_TITLE_4','Retourner');
define('INQUIRY_TITLE_5','L\'E-mail a été Envoyé avec Succès');
define('INQUIRY_TITLE_6','Quelqu\'un a créé une liste de devis pour vous afin que vous puissiez vous connecter ! Si vous avez encore besoin d\'aide, vous pouvez toujours');
define('INQUIRY_TITLE_7','le bouton rouge ci-dessous');
define('INQUIRY_TITLE_8',' pour ajouter ce que vous voyez sur cette page à votre devis.');
define('INQUIRY_TITLE_9','Partager la Liste de Devis');
define('INQUIRY_TITLE_10','Liste de Devis');
define('INQUIRY_TITLE_11',' a partagé une liste de devis avec vous. Vous pouvez cliquer sur le bouton ci-dessous pour afficher les détails complets et ajouter à votre propre liste de devis.');
define('INQUIRY_TITLE_12',' vous a partagé une liste de devis');
define('INQUIRY_TITLE_13','Ajouter à la demande de devis');
define("FS_INQUIRY_INFO_67",'Votre demande de devis est vide. Si vous avez déjà un compte, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'"> Connectez-Vous</a> pour voir votre Devis.');
define("FS_INQUIRY_INFO_68",'E-mail');
define("FS_INQUIRY_INFO_69",'Qté.');


//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','Numéro de Taxe');
define('CHECKOUT_TAX_2','Vous pouvez être exonéré de la TVA si vous avez un Numéro de TVA valide.');

// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"Besoin d'aide?");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"Contacter le Support Client");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','L’article ci-dessous est un cadeau gratuit qui ne sera pas facturé dans le prix total.');
define('FS_GIFT_TITLE_ARE','Les articles ci-dessous sont des cadeaux graduits qui ne seront pas facturés dans le prix total.');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">Cadeau Gratuit</div></div>');
define('FS_GIFT_CHECK_TITLE','Le cadeau gratuit n’est pas disponible pour l’adresse de livraison actuelle, veuillez choisir l’outil de test sur la page du produit si nécessaire.');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">Cadeau Gratuit</div></div>');


// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY',' J\'accepte la <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">Politique de Confidentialité</a> et les<a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank"> Conditions d\'Utilisation </a> de FS.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Veuillez vous assurer que vous acceptez notre Politique de Confidentialité et nos Conditions d\'Utilisation.');

define('NEW_PRODUCTS_TAG','Nouveau');

define('HOT_PRODUCTS_TAG','Populaire');


define("INVALID_CVV_ERROR",'Le code de sécurité est incorrect. Veuillez entrer le code correct et essayer à nouveau.');

define('FS_ACCOUNT_CODING_REQUESTS','Demandes de Codage');
define('FS_ACCOUNT_MY_CODING_REQUESTS','Mes Demandes de Codage');
define('FS_ACCOUNT_CODING_REQUEST_BTN','Demander un Codage');
define('CODING_REQUESTS_LIST','Listes des Codages');
define('CODING_REQUESTS_CODING_DETAILS','Détails de Codage');

// 2019-7-19 potato 地址编辑提示修改
define ("FS_POST_CODE_TITLE_ERROR", "Votre Code Postal est requis.");
define ("FS_CITY_TITLE_ERROR", "Votre ville est requise.");
define ("FS_CHECKOUT_ERROR28_AU", "Veuillez entrer un code postal valide.");
define ("ACCOUNT_EDIT_CITY_AU", "Ville");
define ("ACCOUNT_EDIT_STATE_AU", "Pays");
define ("FS_ZIP_CODE_AU_NEW", "Code Postal");


//add by liang.zhu 2019.09.02
define('FS_COMMON_LEARN_MORE', 'En savoir plus');
define('FS_COMMON_SEE_MORE', 'Voir plus');
define('FS_COMMON_SEE_LESS', 'Voir moins');

//模块标签属性
define('FS_PLACEHOLDER_EG','ex : ');
define('FS_OPTIONAL',' (Optionnel)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','TVA');
define('FS_CHECK_OUT_INCLUDEING_RU','(TVA Incluse)');
define('FS_CHECK_OUT_EXCLUDING_RU','(TVA Exclue)');



//2019-9-7 Jeremy 购物车改版
define("FS_CART_ITEM_TOTAL","Prix Total");
define("FS_CART_ATTR_BTN","Choisir les attributs");
define("FS_CART_ATTR_CONTENT","C'est un produit personnalisé, veuillez choisir les attributs dans la page du produit.");

// 表单次数提交频繁
define('FS_SUBMIT_TOO_OFTEN','Vous avez essayé trop de fois. Veuillez réessayer plus tard.');
define('FS_ROBOT_VERIFY_PROMOPT','Veuillez suivre les instructions pour compléter cette vérification.');

//2019-09-17 liang.zhu
define("CHECKOUT_TAXE_SG_TIT", "À Propos de la GST et du Tarif");
define("CHECKOUT_TAXE_SG_FRONT", "Pour les commandes expédiées à partir de notre entrepôt de Singapour et livrées à des endroits à Singapour, FS est obligé de facturer la GST sur la valeur du produit et les frais d'expédition au taux de 7%.<br/><br/> Si les commandes contiennent des articles temporairement en rupture de stock dans l'entrepôt de Singapour, nous vous les enverrons directement à partir de notre entrepôt d'Asie (Chine) et ne facturerons aucune GST. Toutefois, ces colis peuvent être soumis à des frais d'importation ou à des droits de douane. Tous les droits et tarifs éventuels causés par le dédouanement devraient être supportés par vous-même.");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "À Propos du Droit et du Taxe");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "Pour les commandes livrées à des endroits en dehors de Singapour, nous ne facturerons que la valeur du produit et les frais d'expédition. Aucune taxe de vente (ex. TVA ou TPS) ne sera facturée. Toutefois, les colis peuvent être soumis à des frais d'importation ou à des droits de douane en fonction des lois/réglementations dans les pays concernés. Tous les droits et tarifs éventuels causés par le dédouanement devraient être supportés par vous-même.");

//mtp退货货提示语
define('FS_RETURN_ALL_MTP_PRODUCTS','Veuillez retourner tous ces accessoires ensemble.');
//2019-09-17 add by liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', 'Amérique du Nord');
//澳洲
define('FS_STATE_OCEANIA', 'Océanie');
//亚洲
define('FS_STATE_ASIA', 'Asie');
//欧洲
define('FS_STATE_EUROPE', 'Europe');
define('FS_PORTFOLIOS','applications');
define('FS_ORDER_LINK_REMARK','Remarque');
define('FS_VIEW_INVOICE_BUBBLE','Veuillez contacter votre responsable de compte pour recevoir la facture correspondante.');

define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00am - 5:00pm ");
define("FS_SHIPPING_SG_GRAB_TIPS","Ce service est disponible pour les commandes d'une cargaison unique expédiée depuis l'entrepôt du Singapour, et payées avant 15h00 les jours ouvrables.");
define("FS_TIME_ZONE_ADDRESS_SG","<span>Entrepôt du Singapour FS :</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");
define('FS_SG_VAT_NUMBER',"Numéro de GST");

//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','Envoyer votre devis');
define("FS_INQUIRY_REVIEWING_1",'Envoyé');
define("FS_INQUIRY_QUOTED_1",'Approuvé');
define('FS_QUOTE_INFO_1','Détails du Devis');
define("FS_INQUIRY_CANCELED_1",'Expiré');
define('FS_QUOTE_INFO_2','Prix Unitaire');
define('FS_QUOTE_INFO_3','Prix Cible');
define('FS_QUOTE_INFO_4','Prix Coté');
define('FS_QUOTE_INFO_5',"(Le prix n'inclut pas la taxe et les frais d'expédition)");
define('FS_QUOTE_INFO_6','Tous');
define('FS_QUOTE_INFO_8',"Veuillez choisir des articles d'abord.");
define('FS_QUOTE_INFO_9','Nous vous remercions et nous avons envoyé votre devis par e-mail à votre liste de destinataires.');
define('FS_QUOTE_INFO_10','Retourner au Devis');
define('FS_QUOTE_INFO_11','Obtenir un Nouveau Devis');
define('FS_QUOTE_INFO_12','Obtenir un Devis');
define('FS_QUOTE_INFO_13',"Récapitulatif (");
define('FS_QUOTE_INFO_14',' Articles');
define('FS_QUOTE_INFO_15','Prix Cible : ');
define('FS_QUOTE_INFO_16',"Le prix n'inclut pas la taxe et les frais d'expédition");
define('FS_QUOTE_INFO_17',"Ce devis a été offert avec un rabais basé sur l'ensemble de la liste des produits. Si vous commandez seulement une partie de produits dans la liste, ce rabais sera invalide.");
define('FS_QUOTE_INFO_18',"Ce devis a été offert avec différents rabais basés sur la quantité de chaque produit. Si vous réduisez la quantité du produit, le rabais de ce produit sera invalide.");
define('FS_SEND_EMAIL_2019_1',"Nous avons reçu votre demande de devis ");
define('FS_SEND_EMAIL_2019_2',", votre responsable de compte vous offrira un devis dans 30 minutes. Veuillez le trouver dans ");
define('FS_SEND_EMAIL_2019_3',"Mes Devis");
define('FS_SEND_EMAIL_2019_4'," plus tard.");
define('FS_SEND_EMAIL_2019_5',"Votre client ");
define('FS_SEND_EMAIL_2019_6',"Demande de Devis");
define('FS_SEND_EMAIL_2019_7',"Votre Article(s)");
define('FS_SEND_EMAIL_2019_8',"Qté : ");
define('FS_SEND_EMAIL_2019_9',"Article(s)");
define('FS_SEND_EMAIL_2019_10',"Qté");
define('FS_SEND_EMAIL_2019_11',"Prix Cible");
define('FS_SEND_EMAIL_2019_12',"Prix Unitaire");
define('FS_SEND_EMAIL_2019_13',"Total :");
define('FS_SEND_EMAIL_2019_14',"Cible :");
define('FS_SEND_EMAIL_2019_15',"Offrir un Devis");
define('FS_QUOTE_INFO_19','Date');
define("FS_INQUIRY_INFO_65_1","Ce devis n'est valable que pendant 15 jours et aura expiré le ");
define("FS_INQUIRY_INFO_65_2",", Ce devis n'est valable que pendant 15 jours et aura expiré le ");
define("FS_INQUIRY_INFO_65_3","Sous-total:");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01','Veuillez compléter les paiements dans un délai de ');
define('FS_ORDERS_OVERTIMES_02','');
define('FS_ORDERS_OVERTIMES_03','');
define('FS_ORDERS_OVERTIMES_02_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04','Dans le cas contraire, la commande sera automatiquement annulée en raison du changement de stock des articles.');
define('FS_ORDERS_OVERTIMES_05','Veuillez télécharger le fichier PO dans un délai de ');
define('FS_ORDERS_OVERTIMES_06','Remarque : Si vous notez le numéro de commande FS au moment du transfert, votre commande sera traitée dans les délais prévus. Généralement, les paiements seront reçus dans un délai de 1 à 3 jours ouvrables.');
define('FS_ORDERS_OVERTIMES_07','Votre commande doit être examinée à cause des raisons suivantes :');
define('FS_ORDERS_OVERTIMES_08','L\'adresse de livraison ne correspond pas à celle indiquée sur votre formulaire de demande de crédit');
define('FS_ORDERS_OVERTIMES_09','Votre crédit disponible a également été dépassé');
define('FS_ORDERS_OVERTIMES_10','Veuillez payer les commandes précédentes afin de récupérer le crédit, ou vous pouvez vous rendre à "Mon Crédit" dans votre compte, pour demander une augmentation de la limite de crédit.');
define('FS_ORDERS_OVERTIMES_11','Nous examinerons la commande et vous enverrons le résultat par e-mail dans un délai de 12 heures.');
define('FS_ORDERS_OVERTIMES_12','Pour que cette commande soit traitée rapidement, veuillez payer les commandes précédentes afin de récupérer le crédit, ou vous pouvez vous rendre à "Mon Crédit" dans votre compte, pour demander une augmentation de la limite de crédit.');
define('FS_ORDERS_OVERTIMES_13','Se termine en');
define('FS_ORDERS_OVERTIMES_14','j'); //天  这三个是英文的 day  hour minute 首字母缩写
define('FS_ORDERS_OVERTIMES_15','h'); //时
define('FS_ORDERS_OVERTIMES_16','m'); //分
define('FS_ORDERS_OVERTIMES_17','Désolé, votre commande a été annulée car la date limite de paiement a été dépassée.');
define('FS_ORDERS_OVERTIMES_18','Vous pouvez trouver la commande dans l\'Historique de Commandes et cliquer sur "Acheter à Nouveau" pour passer une nouvelle commande.');
define('FS_ORDERS_OVERTIMES_19','Il y a un problème avec votre commande...');
define('FS_ORDERS_OVERTIMES_20','Nous avons reçu votre paiement de la part de');
define('FS_ORDERS_OVERTIMES_21','Cependant, votre commande a été annulée parce que la date limite de paiement (indiquée sur les commandes en attente de FS) a été dépassée. Veuillez contacter votre responsable de compte pour rétablir la commande. Nous sommes désolés pour le dérangement !');
define('FS_ORDERS_OVERTIMES_22','Il y a des commandes impayées dans votre compte Net 30. Veuillez payer les commandes précédentes. Ou votre responsable de compte dédié vous contactera pour vous demander des documents supplémentaires à examiner.');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36','Rappel de Commande de FS - Paiement en Attente ');
define('FS_ORDERS_OVERTIMES_23','Rappel de Commande');
define('FS_ORDERS_OVERTIMES_24','Merci d\'avoir choisi FS ! Nous avons remarqué que vous avez laissé une commande impayée <b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25','<b style="font-weight: 600;">Remarque</b> : Si vous avez déjà terminé le paiement, veuillez ignorer cet e-mail et nous allons traiter rapidement votre commande. Si vous n\'avez pas besoin de cette commande, veuillez ignorer cet e-mail, elle sera annulée automatiquement par le système plus tard en raison de paiement inaccompli.');
define('FS_ORDERS_OVERTIMES_26','Cordialement.');
define('FS_ORDERS_OVERTIMES_27','</b>. Veuillez savoir qu\'elle sera annulée automatiquement dans ');
define('FS_ORDERS_OVERTIMES_28','. <a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29','">Cliquez Ici</a> pour compléter votre achat s\'il vous plaît. Nous allons traiter votre commande dans le plus bref délai.');


//by rebirth 2019.10.18 新版上传提示 法语
define("FS_UPLOAD_NEW_NOTICE_ONE","Veuillez utiliser un fichier de type PDF, JPG, PNG, DOC, DOCX, XLS, XLSX ou TXT.");
define("FS_UPLOAD_NEW_NOTICE_TWO","Veuillez utiliser un fichier de type JPG, GIF, PNG, JPEG ou BMP.");
define("FS_UPLOAD_NEW_NOTICE_THREE","Taille maximale : 5M.");
define("FS_UPLOAD_NEW_NOTICE_FOUR","Taille maximale : 300KB.");
define("FS_UPLOAD_NEW_ERROR_1","Le fichier téléchargé N'est Pas Admissible !"); //该文件不允许上传
define("FS_UPLOAD_NEW_ERROR_2","Le fichier existe déjà !");  //文件已存在
define("FS_UPLOAD_NEW_ERROR_3","Le téléchargement de fichiers sur le serveur cloud a échoué."); //文件上传云服务器失败
define('FS_UPLOAD_NEW_ERROR_4', 'La taille du fichier téléchargé dépasse la limite autorisée.');


define('FS_SHOP_CART_SG_INSTALL',"Installation gratuite disponible pour les articles dans l'entrepôt SG. En savoir plus sur la page du paiement.");

define('FS_CHECKOUT_SGINSTALL_CC',"Vous avez sélectionné le service d'installation. Veuillez vous assurer d'effectuer le paiement avant le temps d'installation prévu, sinon le service pourrait être retardé.");
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','FS offre un service d\'installation gratuit pour tous les produits en stock, vous pouvez choisir le service sur la page de paiement .');
define('FS_SG_DELIVERY_RETURN','Installation Gratuite');
define('FS_SG_DELIVERY_RETURN','Installation Gratuite');

define('FS_CHECKOUT_SGINSTALL_SUCCESS_1',"Vous avez sélectionné le service d'installation. Lorsque la commande est prête à être expédiée, notre spécialiste technique vous contactera avant de vous rendre chez vous.");
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2',"Vous avez sélectionné le service d'installation. Veuillez vous assurer d'effectuer le paiement avant l'heure d'installation prévue, sinon le service pourrait être retardé.");
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3',"Vous avez sélectionné le service d'installation. Veuillez vous assurer de télécharger le fichier PO avant le temps d'installation prévu, sinon le service pourrait être retardé.");

define('FS_SG_CALENDAR_1',"Sélectionnez le Temps d'Installation");
define('FS_SG_CALENDAR_2',"Obtenir l'Heure d'Installation Disponible");
define('FS_SG_CALENDAR_3',"Veuillez sélectionner la Livraison et Installation de FS.");
define('FS_SG_CALENDAR_4',"Veuillez sélectionner le temps d'installation préféré.");
define("FS_SG_CALENDAR_5","Installation sur Place");
define("FS_SG_CALENDAR_6","Changement d'Expédition");
define("FS_SG_CALENDAR_7","Vous avez annulé toutes les demandes d'installation. Nous organiserons l'expédition de vos articles le plus tôt possible.");
define("FS_SG_CALENDAR_8","Annuler");
define("FS_SG_CALENDAR_9","Confirmer");
define("FS_SG_CALENDAR_10",'Seuls les articles sélectionnés seront installés après la livraison');
define("FS_SG_CALENDAR_11",'* Le service d\'installation est disponible pour les articles expédiés de l\'entrepôt de SG actuellement. Nous sommes désolés pour l\'inconvénient.');
//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","Demande d'Installation");
define("FS_SG_CALENDAR_101","Choisissez le type de service");
define("FS_SG_CALENDAR_102","Veuillez sélectionner");
define("FS_SG_CALENDAR_103","Support de Projet");
define("FS_SG_CALENDAR_104","Dépannage et Réparation");
define("FS_SG_CALENDAR_105","Veuillez sélectionner le type de service.");
define("FS_SG_CALENDAR_106","Décrivez les détails de votre demande*");
define("FS_SG_CALENDAR_107","Veuillez décrire votre demande.");
define("FS_SG_CALENDAR_108","Le contenu doit avoir un minimum de 4 caractères.");
define("FS_SG_CALENDAR_109","Le contenu doit avoir un maximum de 500 caractères.");
define("FS_SG_CALENDAR_110","Demande d'Installation");
define("FS_SG_CALENDAR_111","Type de Service");
define("FS_SG_CALENDAR_112","Heure Prévue");
define("FS_SG_CALENDAR_113","Détails de la Demande");
define("FS_SG_CALENDAR_114","Installation Prévue");
define("FS_SG_CALENDAR_115","Votre Demande d'Installation a été Reçue.");
define("FS_SG_CALENDAR_116","Notre expert technique vous contactera avant d'arriver sur place.");

define('FS_FESTIVAL16','Jour Férié à Singapour le');
define('FS_FESTIVAL17',' dans l\'Entrepôt SG.');

//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","Merci pour choisir FS Singapour, nous avons reçu votre commande en attente ");
define("FS_SG_EMAIL_1","Veuillez compléter le paiement et nous vous enverrons un e-mail dès que l'installation gratuite pour cette commande est arrangée.");
define("FS_SG_EMAIL_2","Des produits sont disponibles pour une installation gratuite, vous pouvez <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">demander un service d'installation</a> s'il est nécessaire. Veuillez compléter le paiement et nous vous enverrons un e-mail à nouveau.");
define("FS_SG_EMAIL_3","Vous avez choisi le service d'installation pour votre commande ");
define("FS_SG_EMAIL_4"," Nous vous contacterons lorsque notre spécialiste technique se rend à votre adresse de livraison.");
define("FS_SG_EMAIL_5","Veuillez vous connecter pour suivre la progression de votre commande sur la page de ");
define("FS_SG_EMAIL_6","Les détails de votre commande ");
define("FS_SG_EMAIL_7","sont ci-dessous. Nous vous enverrons un e-mail dès que le statut de votre commande est mis à jour.");
define("FS_SG_EMAIL_8","Vous pouvez vous connecter pour suivre la progression de votre commande sur la page de ");
define("FS_SG_EMAIL_9"," Veuillez noter que l'installation gratuite est disponible pour cette commande, vous pouvez choisir une heure convenable <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">ici</a>.");
define("FS_SG_EMAIL_10","Votre commande ");
define("FS_SG_EMAIL_11"," est prête pour l'installation et notre spécialiste technique se rendra à votre adresse à temps.");
define("FS_SG_EMAIL_12","S'il y a un changement, veuillez nous contacter au <a style=\"color: #0070bc;text-decoration: none\" href=\"tel:+(65) 6443 7951\">+(65) 6443 7951</a> ou envoyer un e-mail à <a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>.");
define("FS_SG_EMAIL_13","Cordialement");
define("FS_SG_EMAIL_14","Équipe de FS");
define("FS_SG_EMAIL_15","Infos de Contact :");
define("FS_SG_EMAIL_16","N° de Téléphone :");
define("FS_SG_EMAIL_17","Adresse :");
define("FS_SG_EMAIL_18","Heure prévue :");
define("FS_SG_EMAIL_19","Commande de FS #");
define("FS_SG_EMAIL_20","- Rappel d'Installation");
define("FS_SG_EMAIL_21","Merci pour choisir FS Singapour. Nous avons remarqué que vous avez une commande impayée");
define("FS_SG_EMAIL_22"," avec le service d'installation. Veuillez noter que le service a été annulé.");
define("FS_SG_EMAIL_23","<a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">Cliquez ici</a> pour compléter votre achat et vous pouvez sélectionner une heure convenable pour le service d'installation dans Mon Compte.");
define("FS_SG_EMAIL_24","Votre Commande FS #");
define("FS_SG_EMAIL_25"," a été expédiée");
define("FS_SG_EMAIL_26","Rappel d'Installation");
define("FS_SG_EMAIL_27","Installation Annulée");
define("FS_SG_EMAIL_28","Rappel de Paiement");

define('FS_SHIPPING_SG_INSTALL_TIPS','Pour cette livraison, vous pouvez sélectionner l\'heure d\'installation préférée. Les services d\'installation ne sont disponibles qu\'avec Livraison de FS & Installation Gratuite.');

define('FS_SG_DELIVERY_INSTALLATION', 'Livraison de FS & Installation Gratuite');
define('FS_SG_NEXT_WORKING_DAY', 'Livraison le Jour Ouvrable Suivant de FS');
define('FS_SG_SAME_WORKING_DAY', 'Livraison le Jour Ouvrable Même de FS');
define('FS_ACCOUNT_DETELE','Ce compte a été supprimé');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 Working Days');

//rebirth 2019.10.17 订单超时,分钟,工作日的单复数处理
define('FS_ORDERS_OVERTIMES_30','minute');
define('FS_ORDERS_OVERTIMES_31','jour ouvrable');
define('FS_ORDERS_OVERTIMES_32','minutes');
define('FS_ORDERS_OVERTIMES_33','jours ouvrables');
define('FS_ORDERS_OVERTIMES_34','');
define('FS_ORDERS_OVERTIMES_35','');

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'Type de Service');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', 'Support d\'Utilisation du Produit');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'Support de Connectivité de Liaison');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'Support d\'Installation & de Configuration');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'Autres');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","Partager l'Expérience");
define("EMAIL_MESSAGE_01","Comment votre expérience d'achat ?");
define("EMAIL_MESSAGE_02","Laissez votre commentaire");
define('EMAIL_MESSAGE_CONTENT', 'Nous aimerions que vous nous aidiez et d\'autres clients, en passant en revue les produits que vous avez récemment achetés en commande <a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a>. ela ne prend qu\'une minute et cela aiderait vraiment les autres. Cliquez sur le bouton ci-dessous et laissez votre commentaire !');
define('EMAIL_MESSAGE_SUBTITLE', 'Vous avez des questions à votre commande ?');
define('EMAIL_MESSAGE_SUB_CONTENT', 'Qu\'il s\'agisse de support technique, de questions de garantie ou de livraison, nous sommes heureux de vous aider. Veuillez consulter le <a style="color: #0070bc;text-decoration: none;" href="javascript:;">Centre d\'Aide</a> pour une assistance rapide et utile.');
define('EMAIL_TO_LICENSE_5','Voir Plus');
define('EMAIL_TO_LICENSE_6','Vous avez un nouvel article à évaluer sur FS.COM');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'Merci de votre support');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'Nous apprécierions vos commentaires sur votre expérience sur Trustpilot. Veuillez prendre un moment pour évaluer FS.');
define('EMAIL_REVIEWS_FOUR_FIVE_03', 'Votre évaluation');
define('EMAIL_REVIEWS_FOUR_FIVE_04', 'Votre commentaire (qu\'il soit bon, mauvais ou autre) sera immédiatement publié sur Trustpilot.com afin d\'aider d\'autres personnes à prendre des décisions plus éclairées.');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'Merci pour votre temps et nous nous réjouissons de vous revoir ! <br>FS équipe.');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'évaluez-nous');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'Votre expérience est importante - Merci pour de partager');


//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Support Technique');
define('FS_REQUEST_SUPPORT','Demande de Support');

//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'Statut de Devis');
define("FS_INQUIRY_LIST_2",'Devis Valables');
define("FS_INQUIRY_LIST_3",'Contacter le Service Client');
define("FS_INQUIRY_LIST_4",'Chercher le Devis :');
define("FS_INQUIRY_LIST_5",'N° de Devis ');
define("FS_INQUIRY_LIST_6",'Search');
define("FS_INQUIRY_LIST_7",'Date de Demande ');
define("FS_INQUIRY_LIST_8",'Sous-total ');
define("FS_INQUIRY_LIST_9",'Qté :');
define("FS_INQUIRY_LIST_10",'Voir plus...');
define("FS_INQUIRY_LIST_11",'Ce devis n\'est valable qu\'avant le ');
define("FS_INQUIRY_LIST_12",'Ce devis a expiré le ');
define("FS_INQUIRY_LIST_13",'AUCUN DEVIS TROUVÉ.');
define("FS_INQUIRY_LIST_14",'Commencer votre Achat');
define("FS_INQUIRY_LIST_15",'Si vous ne pouvez pas localiser votre devis, essayez de sélectionner différentes conditions de filtrage.');
define("FS_INQUIRY_LIST_16",'Détails de Demande de Devis');
define("FS_INQUIRY_LIST_17",'Nom du Devis :');
define("FS_INQUIRY_LIST_18",'Obtenir un Nouveau Devis');
define("FS_INQUIRY_LIST_19",'Ajouter au Panier');
define("FS_INQUIRY_LIST_20",'Imprimer cette page');
define("FS_INQUIRY_LIST_21",'DEMANDE DE DEVIS');
define("FS_INQUIRY_LIST_22",'Article');
define("FS_INQUIRY_LIST_23",'Prix Unitaire');
define("FS_INQUIRY_LIST_24",'Quantité');
define("FS_INQUIRY_LIST_25",'Prix Coté');
define("FS_INQUIRY_LIST_26",'ID de Client ');
define("FS_INQUIRY_LIST_28",'N° de Téléphone ');
define("FS_INQUIRY_LIST_29",'Total Coté :');
define("FS_INQUIRY_LIST_30",'Le devis ci-dessous est déjà envoyé, votre responsable de compte vous répondra dans les 24 heures.');
define("FS_INQUIRY_LIST_30_1",'Le devis est en cours de révision par votre responsable de compte. Vous recevrez une réponse dans les 24 heures.');
define("FS_INQUIRY_LIST_31",'Le devis est en cours de révision par votre responsable de compte, vous recevrez la réponse dans les 24 heures.');
define("FS_INQUIRY_LIST_32",'Les détails de votre devis sont ci-dessous. Ce devis n\'est valable qu\'avant le ');
define("FS_INQUIRY_LIST_33",'Ce devis a expiré le ');
define("FS_INQUIRY_LIST_34",'. Vous pouvez demander un nouveau devis s\'il est nécessaire.');
define("FS_INQUIRY_LIST_35","Devis #");
define("FS_INQUIRY_LIST_36","Date de Demande :");
define("FS_INQUIRY_LIST_37","Devis # :");
define("FS_INQUIRY_LIST_38","Article : #");
define("FS_INQUIRY_LIST_38_1",'Article#: ');
define("FS_INQUIRY_LIST_39","Voici le devis que vous avez demandé.");
define("FS_INQUIRY_LIST_40","RÉFÉRENCE");
define("FS_INQUIRY_LIST_41",'Imprimer cette page');
define("FS_INQUIRY_LIST_42",'Date de Devis ');
// manage address
define("FS_CREATE_NEW_ADDRESS", 'Ajouter une Nouvelle Adresse');
define("FS_DEFAULT", 'Par Défaut');
define("FS_SAVE_ADDRESSES", 'Adresses Sauvegardées');
define("FS_EDIT_REMOVE", 'Modifier/Supprimer');
define("FS_EDIT", 'Modifier');
define("FS_REMOVE", 'Supprimer');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", 'AUCUNE ADRESSE D\'EXPEDITION.');
define("FS_NO_BILLING_ADDRESS_HISTORY", 'AUCUNE ADRESSE DE FACTURATION.');

//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', "C'est un produit personnalisé, veuillez sélectionner les attributs sur la page de détails du produit.");
define('FS_MANAGE_CLOSE_TIP', "Ce produit n'est plus disponible en ligne. Veuillez contacter votre responsable de compte pour connaître les disponibilités ou voir des produits similaires en ligne.");

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','Votre Statut ');
define('FS_NEW_ACCOUNT_MY_CREDIT_02','');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','Montant Utilisé ');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','Montant Limite du Crédit ');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','Augmenter');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','Chercher les Commandes');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','N° de PO/Commande');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','Date');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','AUCUNE COMMANDE DE CRÉDIT.');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','Commencer votre Achat');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','AUCUNE COMMANDE DE CRÉDIT TROUVÉE.');
define('FS_NEW_ACCOUNT_MY_CREDIT_12', 'Cherchez');

// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",'Administrateur de Compte :');
define("FS_ACCOUNT_NEW",'N° de Compte :');
define("FS_NAME",'Nom ');
define("FS_ACCOUNT_MANAGE_CONTACT",'Responsable de Compte :');
define("FS_ACCOUNT_PHONE",'Téléphone :');
define("FS_ACCOUNT_ORDERS_PENDING",'Commandes en Attente');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'Traitement');
define("FS_ACCOUNT_ORDERS_COMPLETED",'Complétée');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'Devis Valables');
define("FS_ACCOUNT_ORDERS_RMA",'RMA');
define("FS_ACCOUNT_ORDERS",'COMMANDES');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'Voir et Suivre les Commandes Récentes');
define("FS_ACCOUNT_HISTORY",'Historique de Commandes');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'Nouvelle Demande de Devis');
define("FS_ACCOUNT_QUOTE_STATUS",'Historique/Statut de Devis');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'Nouvelle Demande de RMA');
define("FS_ACCOUNT_RMA_STATUS",'Historique/Statut de RMA');
define("FS_ACCOUNT_REVIEW_PURCHASES",'Commenter vos Achats');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'Vérifier le statut, la localisation et l\'historique de commande.');
define("FS_ACCOUNT_VIEW_ORDERS",'Voir les Commandes');
define("FS_ACCOUNT_SEARCH_ORDERS",'Chercher les Commandes :');
define("FS_ACCOUNT_PO_ORDER_ID",'N° de PO/Commande/Article');
define("FS_ACCOUNT_SEARCH",'Chercher');
define("FS_ACCOUNT_NET_TERMS",'COMPTE DE CRÉDIT');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'Acheter Maintenant, Payer Plus Tard');
define("FS_ACCOUNT_CURRENT_BALANCE",'Montant Utilisé');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'Voir les Détails de Votre Crédit');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'PARAMETRES DE COMPTE');
define("FS_ACCOUNT_PASSWORD_MAIL",'Mot de Passe et Adresse E-mail');
define("FS_ACCOUNT_USER_PHOTO",'Photo');
define("FS_ACCOUNT_USER_NAME",'Identifiant');
define("FS_ACCOUNT_EMAIL_ADDRESS",'Adresse E-mail');
define("FS_ACCOUNT_EMAIL_PASSWORD",'Mot de Passe');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'Préférences d\'Abonnement E-mail');
define("FS_ACCOUNT_SHOPPING_TOOLS",'OUTILS UTILES');
define("FS_ACCOUNT_USEFUL_SHOPPING",'Support et Commentaire');
define("FS_ACCOUNT_REQUEST_SAMPLE",'Demander un Échantillon');
define("FS_ACCOUNT_WRITE_REVIEW",'Donnez votre Avis sur FS');
define("FS_ACCOUNT_USER_INFORMATION",'INFORMATIONS DE L\'UTILISATEUR');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'Cas et Adresses');
define("FS_ACCOUNT_ADDRESS_BOOK",'Carnet d\'Adresses');
define("FS_ACCOUNT_CASE_CENTER",'Centre de Cas');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click "<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');

define("FS_ACCOUNT_CASE_E_MAIL",'E-mail : ');
define("FS_CREATE_SHIPPING_ADDRESS",'Créer une Nouvelle Adresse de Livraison');
define("FS_CREATE_BILLING_ADDRESS",'Créer une Nouvelle Adresse de Facturation');
define("FS_EDIT_SHIPPING_ADDRESS",'Modifier votre Adresse de Livraison');
define("FS_EDIT_BILLING_ADDRESS",'Modifier votre Adresse de Facturation');
define("FS_CONFIRMATION",'Confirmation');
define("FS_DELETE_THIS_ADDRESS",'Supprimer cette adresse ?');
define("FS_SAVED_ADDRESSES",'Adresses Sauvegardées');
define("FS_SAVE_AS_DEFAULT",'Sauvegarder par Défaut');

define('FS_SALES_INFO_MODAL_TITLE','Ajouter une Nouvelle Adresse');
define('FS_SALES_INFO_MODAL_FNAME','Prénom');
define('FS_SALES_INFO_MODAL_LNAME','Nom');
define('FS_SALES_INFO_MODAL_COUNTRY','Pays/Région');
define('FS_SALES_INFO_MODAL_ADS_TYPE','Type d\'Adresse');
define('FS_SALES_INFO_MODAL_COMPANT','Nom d\'Entreprise');
define('FS_SALES_INFO_MODAL_VAT','NUMéRO de TVA/TAXE');
define('FS_SALES_INFO_MODAL_ADS1','Adresse');
define('FS_SALES_INFO_MODAL_ADS2','Adresse 2');
define('FS_SALES_INFO_MODAL_CITY','Ville');
define('FS_SALES_INFO_MODAL_SPR','état/Province/Région');
define('FS_SALES_INFO_MODAL_STATE','Veuillez choisir un état');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','Code Postal');
define('FS_SALES_INFO_MODAL_PHONE_NUM','Numéro de Téléphone');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','Annuler');
define('FS_SALES_INFO_MODAL_BTN_SAVE','Sauvegarder');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','Adresse de Rue, c/o');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','Appartement, Chambre, Étage, etc.');

define('FS_SALES_DETILS_TYPE1','Remboursement');
define('FS_SALES_DETILS_TYPE2','Remplacement');
define('FS_SALES_DETILS_TYPE3','Réparation');
define('FS_RMA_NAVI1','Confirmation de RMA');
define('FS_RMA_NAVI2','Historique de RMA');
define('FS_RMA_NAVI3','Détail de RMA');
define('FS_RMA_NAVI4','RMA');
define('FS_RMA_NAVI5','Nouvelle Demande de RMA');
define('FS_RMA_DETAILS_NAVI1','Détail du Retour & Remboursement');
define('FS_RMA_DETAILS_NAVI2','Détail du Remplacement');
define('FS_RMA_DETAILS_NAVI3','Détail de la Réparation');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', 'Veuillez payer au compte suivant.');

define('FS_RMA_SEARCH_TIPS','Tous les RMA');

define("FS_SAVE_AS_DEFAULT",'Supprimer');
define("FS_ACCOUNT_REQUEST_A_SAMPLE",'Demander un Échantillon');
define("FS_ACCOUNT_USEFUL_TOOLS",'OUTILS UTILES');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Support et Commentaire');
define("FS_ACCOUNT_CANCEL",'Supprimer');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'ADRESSES DE LIVRAISON');
define("FS_ACCOUNT_BILLING_ADDRESS",'ADRESSES DE FACTURATION');
define('ACCOUNT_MY_HOME','Accueil');
define("FS_REVIEW_PURCHASE_10",'N° de Commande/Article');

define('FS_INDEX_FPE_TITLE','Produits Vedettes');
define('FS_INDEX_ETN_TITLE','Explorez le Réseau');
define('FS_INDEX_SERVICE_TITLE','Services');
define('FS_ACCOUNT_TITLE','Statut de Commande');
define('FS_ACCOUNT_BTN','Voir les Commandes');
define('FS_ACCOUNT_CONTENT','Suivez votre commande pour obtenir le dernier statut du colis et le délai de livraison estimé.');
define('FS_ACCOUNT_TITLE_REGISTER','Créer un Compte');

define('FIBER_SPARKASSE_BANK_NAME','Nom de la Banque :');

//订单详情
define('FS_PRINT_QTY','Quantité');
define('FS_PRINT_UNIT_PRICE','Prix');
define('FS_PRINT_TOTAL','Prix Total');
define('FS_PRINT_SHIPMENT','Commande');
define('FS_PRINT_SUBTOTAL','Sous-total :');
define('FS_PRINT_SHIPPING_COST','Frais d\'Expédition:');
define('FS_PRINT_SHIPPING_TAX','TVA/Taxe :');
define('FS_PRINT_TOTAL_WIDTH_COLON','Total :');
define('FS_PRINT_ITEM','Article');

//税后价公用语言包 add dylan 2020.5.13
define('FS_BLANKET_32','Frais de Livraison');
define('FS_BLANKET_33','Montant Total du GST');
define('FS_BLANKET_34','Total');
define('FS_BLANKET_35','GST Incl.');

define('ACCOUNT_EDIT_CITY_FROMAT_TIP','Votre ville doit comporter au moins 2 caractères.');
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP','La ligne d\'adresse 2 doit comporter au moins 2 caractères.');

//报价相关
define('INQUIRY_QUOTE_LIST_1','Voir le Devis');
define('INQUIRY_QUOTE_LIST_2','Historique de Devis');

define('FS_CHECKOUT_ERROR_VAT','Veuillez entrer un NUMÉRO DE TVA valide. ex. : $VAT');
define('FS_CHECKOUT_POPUP_TIPS','Êtes-vous sûr de vouloir retourner à votre Panier ?');
define('FS_CHECKOUT_POPUP_TIPS_QUOTE',"Voulez-vous retourner à l'historique de devis ?");
define('FS_CHECKOUT_POPUP_BUTTON1','Continuer');
define('FS_CHECKOUT_POPUP_BUTTON2','Retourner');
define('FS_CHECKOUT_PAYMENT','Paiement');
define('FS_CHECKOUT_PAYMENT_PO','Ajouter le PO');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','Personnalisé');
define('FS_ORDER_MANUFACTURING','Production');
define('FS_ORDER_TEST_PASS','Test Réussi');
define('FS_ORDER_SHIPPED','Expédié');
define('FS_ORDER_TEST_REPORT','Bilan des Tests');

define('FS_PRODUCTS_INFO_NOTE_TITLE','Remarque : ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','Le module CFP cohérent ne peut pas être vendu séparément.');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','Votre compte de crédit est dans un état de "Suspension de Crédit " et l\'option de paiement "Bon de Commande" n\'est pas disponible. Veuillez <a href="'.zen_href_link('manage_orders','','SSL').'" target="_blank">régler les commandes impayées</a> ou choisir d\'autres options de paiement.');
define('FS_PO_FORZEN_NOTICE_02','Votre compte de crédit est dans un état de "Suspension de Crédit ". Pour en savoir plus, veuillez consulter la page Détails du Crédit.');

define('FS_PO_FORZEN_NOTICE_03','Votre compte de crédit est dans un état de "Suspension de Crédit ". Veuillez <a href="'.zen_href_link('manage_orders','','SSL').'">régler les commandes impayées</a> ou contacter votre responsable de compte pour plus de détails.');


define("FS_ACCOUNT_RMA_ORDERS",'Commande de RMA');
define("FS_ACCOUNT_PO_NUMBER",'PO #');
define("FS_ACCOUNT_REQUEST_RMA",'Demander un RMA');
define("FS_ACCOUNT_RMA_HISTORY",'Historique de RMA');
define("FS_ACCOUNT_PO_ORDER",'Envoyer/Voir le Bon de Commande');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'Evaluez votre Commande');
define("FS_ACCOUNT_QUOTES",'DEVIS');
define("FS_ACCOUNT_QUICK_QUOTE",'Obtenir un Devis Rapidement et Consulter le Statut');
define("FS_ACCOUNT_ACTIVE",'Devis Valable');
define("FS_ACCOUNT_QUOTE_HISTORY",'Historique de Devis');
define("FS_ACCOUNT_REQUEST_QUOTE",'Demander un Devis');
define("FS_ACCOUNT_ORDER_PENDING",'Commandes en Attente');
define("FS_ACCOUNT_ORDER_PROGRESSING",'Commandes en Traitement');
define("FS_ACCOUNT_ORDER_COMMENTS",'Remarque du Client :');

//support
define("SUPPORT_PAGE","Bienvenue au service client de FS. Comment pouvons-nous vous aider ?");
define("SUPPORT_PAGE_1","Assistance immédiate");
define("SUPPORT_PAGE_2","Chat en Ligne");
define("SUPPORT_PAGE_3","Centre de Téléchargement");
define("SUPPORT_PAGE_4","En savoir plus");
define("SUPPORT_PAGE_5","Demander un Support Technique");
define("SUPPORT_PAGE_6","Demander un Devis");
define("SUPPORT_PAGE_7","Études de Cas");
define("SUPPORT_PAGE_8","Vidéo");
define("SUPPORT_PAGE_9","Communauté");
define("SUPPORT_PAGE_10","Plus de Support");
define("SUPPORT_PAGE_11","Politique de Retour");
define("SUPPORT_PAGE_12","Suivre votre Colis");
define("SUPPORT_PAGE_13","Demander un Échantillon");
define("SUPPORT_PAGE_14","Centre d'Assistance");
define('FS_SUPPORT','Support');

define('FS_SEND_EMAIL_PAYMENT',"Demande de Paiement");

define('FS_BY_CLICKING','En cliquant \'Je Confirme et Je Paye\', vous acceptez nos');
define('FS_TERMS_AND_CONDITIONS','Termes et Conditions');
define('FS_PRIVACY_AND_COOKIES',' Confidentialité et Cookies');
define('FS_AND_RIGHT_OF_WITHDRAWL',' et Droit de Rétraction.');
define("FS_ZIP_CODE_EU","Code Postal");
define("FS_ADDRESS_EU","Adresse");
define("FS_ADDRESS2_EU","Adresse 2");
define('ACCOUNT_EDIT_CITY_EU','Ville');

//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','Merci de visiter FS. Pour une assistance immédiate, veuillez visiter');
define('FS_GIVE_FEEDBACK_TIP_2','FS Support');//链接
define('FS_GIVE_FEEDBACK_TIP_3','ou');
define('FS_GIVE_FEEDBACK_TIP_4','Chat en Ligne');//链接
define('FS_GIVE_FEEDBACK_TIP_5','.');
define('FS_FEEDBACK_SELECT_1', 'Conception du site');
define('FS_FEEDBACK_SELECT_2', 'Recherche et navigation');
define('FS_FEEDBACK_SELECT_3', 'Produit');
define('FS_FEEDBACK_SELECT_4', 'Commande et paiement');
define('FS_FEEDBACK_SELECT_5', 'Expédition et livraison');
define('FS_FEEDBACK_SELECT_6', 'Retour et remplacement');
define('FS_FEEDBACK_SELECT_7', 'Service et support');
define('FS_FEEDBACK_SELECT_8', 'Suggestion du site');

define('FS_AND',' et ');
define('FS_RIGHT_OF_WITHDRAWL','Droit de Withdrawl');
define('FS_RIGHT_OF_WITHDRAWL_01','');
define('FS_CHECKOUT_ERROR3_EU','Votre Adresse est requise');


//报价语言包
define('INQUIRY_LISTS_1','Tous les Devis');
define('INQUIRY_LISTS_2','Coté');
define('INQUIRY_LISTS_3','Commandé');
define('INQUIRY_LISTS_4','Le devis a été approuvé pour passer une commande.');
define('INQUIRY_LISTS_5','RÉFÉRENCE');
define('INQUIRY_LISTS_6','Détails du Devis');
define('FS_INQUIRY_INFO_66_1','La demande de devis a expiré le ');
define('FS_INQUIRY_INFO_66_2',' Vous pouvez demander un nouveau devis si besoin.');
define('FS_INQUIRY_INFO_66_3','Le devis a expiré le ');
define('FS_INQUIRY_INFO_66_4','La demande de devis est valable jusqu\'au ');
define("FS_INQUIRY_LIST_27","Responsable de Compte");
define('FS_INQUIRY_INFO_66_5','Vous pouvez passer la commande directement après avoir reçu le devis de votre responsable de compte.');
define('FS_QUOTE','Devis');
define('INQUIRY_LISTS_7','Tous les Temps');
define('INQUIRY_LISTS_8','Historique de Devis');
define('INQUIRY_LISTS_9','Historique de Devis');
define('INQUIRY_LISTS_10','Demande de Devis');
define('INQUIRY_LISTS_11','Demande de Devis');
define('INQUIRY_LISTS_12','Expiration : ');
define('INQUIRY_LISTS_13','Créé par : ');
define('INQUIRY_LISTS_14','Responsable de Compte : ');
define('INQUIRY_LISTS_15','Retourner');

// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate for Education & Learning');
define('FS_ERate_03','Server Room');
define('FS_ERate_04','Classroom');
define('FS_ERate_05','Lecture Hall');
define('FS_ERate_06','Laboratory');
define('FS_ERate_07','Contact an EDU specialist today');
define('FS_ERate_08','Mon - Fri, 9:00am-5:00pm EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','E-rate Discounts');
define('FS_ERate_11','Take advantage of E-rate funding to receive discounts on networking equipment. Most public, private, and charter schools & libraries qualify. We proudly serve teachers, principals, and IT support staff by sourcing the best technology solutions for classrooms—at every level of education.');
define('FS_ERate_12','FS SPIN (Form 498 ID): 143051712');
define('FS_ERate_13','Get Started for E-rate');
define('FS_ERate_14','Leave your contact or call us for assistant');
define('FS_ERate_15','Please enter your email address.');
define('FS_ERate_16','Please enter a valid email address.');
define('FS_ERate_17','Thank you. We will get in touch with you ASAP.');
define('FS_ERate_18','10G DWDM Interconnections Over 120km in Campus Network');
define('FS_ERate_19','FS FMU DWDM and FMT series enable good quality transmission over long distance in a simple way.');
define('FS_ERate_20','Read more');
define('FS_ERate_21','Sir/Madam');
define('FS_ERate_22','We\'ve received your E-Rate request and will get in touch with you soon. Here is your case number $CNxxxxxxx, you can refer to this number in all follow-up communications regarding this request.');
define('FS_ERate_23','FS - We received your E-Rate request ');
define('FS_ERate_24','Featured Case');
define('FS_ERate_25','Laboratory');
define('FS_ERate_26','Your Email Address');
define('FS_ERate_27','E-rate for Education ');
define('FS_ERate_28','E-rate Support');
define('FS_ERate_29','Receive discounts with E-rate funding');

define('CART_SHIPPING_METHOD_CHECKOUT_PRE','Livraison :');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT','Calculée au paiement');
define('FS_COMMON_GSP_1','expédié et fourni par FS Asie');
define('FS_COMMON_GSP_2','Frais d\'Importation');
define('FS_COMMON_GSP_3','inclus');
define('FS_COMMON_GSP_4','Frais d\'importation inclus au moment de l\'achat de dédouanement sont traités par FS.');
define('FS_COMMON_5','Fermer');


define("FS_SHOP_CART_LIST_SUB", "Sous-total");

//详情页定制弹窗文字 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'Personnalisation');
define('FS_DETAIL_CUSTOM_2', 'Production');
define('FS_DETAIL_CUSTOM_3', 'Expédition');
define('FS_DETAIL_CUSTOM_4', 'Arrivée');
define('FS_DETAIL_CUSTOM_5', 'Production prévue : ');
define('FS_DETAIL_CUSTOM_6', 'Expédition prévue : ');
define('FS_DETAIL_CUSTOM_7', 'Arrivée prévue : ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Customized');
define('FS_GSP_STOCK_2', 'Produit International');
define('FS_GSP_STOCK_3', 'ship from ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Import Fees Deposit');
define('FS_GSP_STOCK_6', 'included');
define('FS_GSP_STOCK_7', 'L\'article sera expédié depuis l\'entrepôt mondial d\'Asie via le <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Programme d\'Expédition Mondial (GSP)</a>. Les frais d\'importation inclus au moment de l\'achat ainsi que le dédouanement sont pris en charge par FS. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">En savoir plus</a>');
define('FS_GSP_STOCK_8', 'Close');
define('FS_GSP_STOCK_9', 'L\'article sera expédié depuis l\'entrepôt mondial en Asie via le <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Programme d\'Expédition Mondial (GSP)</a>. Les frais d\'importation inclus au moment de l\'achat ainsi que le dédouanement sont traités par FS. La taxe de vente sera incluse au moment du paiement. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">En savoir plus</a>');
define('FS_AVAILABLE', 'Disponible');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW','L\'article sera expédié depuis l\'entrepôt mondial d\'Asie.');

define('FS_OUTBREAK_NOTICE', 'Nous sommes là pour vous aider - Une lettre sur COVID-19 par FS');
define('FS_OUTBREAK_NOTICE_M', 'Une lettre sur COVID-19 par FS');
define('FS_OUTBREAK_READ_MORE', 'En savoir plus');

//subtotal(有税收的带上税收)
define('FS_SHOP_CART_SUBTOTAL','Sous-total :');
define('FS_SHOP_CART_EXCL_VAT','TVA ($VAT) ');
define('FS_SHOP_CART_EXCL_SG_VAT','GST (7%) ');
define('FS_SHOP_CART_EXCL_AU_VAT','Australie GST (10%) ');
define('FS_SHOP_CART_EXCL_DE_VAT',' Allemagne TVA ($VAT) ');;

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','La date de livraison s\'applique aux articles en stock achetés avant 17h EST pendant les jours ouvrables. Au-delà de cette heure, votre commande sera expédiée le jour ouvrable suivant. Si la quantité demandée est supérieure aux stocks, l\'article sera expédié depuis l\'entrepôt en Asie FS avec le <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Programme d\'Expédition Mondial (GSP)</a>.');
define('FS_GSP_COVID_TIPS','Il est possible que votre service de livraison soit retardé en raison du COVID-19 et de l\'augmentation du volume. Pour plus de détails sur le suivi, veuillez consulter  <a href="'.reset_url('/login.html').'" target="_blank">Mon Compte</a>. ');

define('PRODUCTS_WARRANTY','Modules Optiques');
define('PRODUCTS_WARRANTY_2','Test de Qualité ');
define('PRODUCTS_WARRANTY_1','');
define('PRODUCTS_WARRANTY_3',' Professionnel Pour ');
define('PRODUCTS_WARRANTY_4','Expédition &amp; Livraison');
define('PRODUCTS_WARRANTY_5','WARRANTY_YEARS Ans de Garantie');
define('PRODUCTS_WARRANTY_5_1','WARRANTY_YEARS An de Garantie');
define('PRODUCTS_WARRANTY_6','Garantie à Vie');
define('PRODUCTS_WARRANTY_7','Retours Gratuits');

//打印发票 VAT No 本地化
define('FS_VAT_NO_EU','N° de TVA : ');
define('FS_VAT_NO_AU','ABN : ');
define('FS_VAT_NO_SG','GST Reg No. : ');
define('FS_VAT_NO_BR','CNPJ : ');
define('FS_VAT_NO_CL','RUT : ');
define('FS_VAT_NO_AR','CUIT : ');
define('FS_VAT_NO_DEFAULT','N° de Taxe : ');

//购物车saved_items、saved_cart_details
define('FS_SAVED_CARTS','Paniers Enregistrés');
define('FS_ALL_SAVED_CARTS','Tous les Paniers Enregistrés');
define('FS_ADD_ALL_TO_CARTS','Ajouter Tout au Panier');
define('FS_GO','Confirmez');
define('FS_SHOW_CART','Afficher');
define('FS_SEARCH','Chercher');
define('FS_CART_NAME','Nom du Panier ');
define('FS_SEARCH_SAVED_CARTS','Rechercher des Paniers Enregistrés');
define('FS_DATE_SAVED','Date ');
define('FS_CUSTOMER_ID','N ° du Client ');
define('FS_ACCOUNT_MANAGER','Responsable de Compte ');
define('FS_PHONE','Téléphone# ');
define('FS_SUBTOTAL','Sous-total ');
define('FS_VIEW_SHIPPING_CART','Voir les Paniers');
define('FS_SAVE_CART_CONDITIONS','Si vous ne trouvez pas votre panier enregistré, veuillez sélectionner différentes conditions de filtrage.');
define('FS_NO_SAVED_CART_FOUND','AUCUN PANIER ENREGISTRÉ TROUVÉ.');
define('FS_CRET_REFERENCE','CONTENU DU PANIER');
define('FS_CART_DELETE','Confirmer');
define('FS_CART_NEW_ITEMS','De nouveaux articles ont été ajoutés à votre');
define('FS_CART_SUCCESSFULLY_UPDATED','Votre panier a été mis à jour avec succès');
define('FS_CART_SAVED_CART_NAME','Nom du Panier Enregistré');
define('FS_CART_NEW_CART_CREATE','Un nouveau panier a été créé.');
define('FS_CART_HAS_BEEN_ADD','a été ajouté à vos Paniers Enregistrés.');
define('FS_CART_NAME_ALREADY_EXISTED','Ce nom a déjà existé. Veuillez utiliser un autre nom.');
define('FS_ADD_TO_SAVED_CART','Ajouter');
define('FS_SAVE_CART_SELECT','Sélectionner un Panier Enregistré');
define('FS_ADD_THE_ITEMS','Ou, ajouter le(s) article(s) dans un Panier Enregistré existant.');
define('FS_NAME_YOUR_SAVED_CART','Nommer votre Panier Enregistré');
define('FS_ADD_TO_CART','Ajouter au Panier ');
define('FS_EMIAL_YOUR_CART','Envoyer votre Panier');
define('FS_PRINT_THIS_PAGE','Imprimer cette page');
define('FS_SAVED_CART_DETAILS','Détails du Panier Enregistré');
define('FS_BELOW_IS_THE_CART','Vous trouverez ci-dessous les détails de votre panier enregistré.');
define('FS_CART_CONTACT_CUSTOMER_SERVICE', 'Contacter le Service Client');
define('FS_UPDATED_SUCCESSFULLY', 'Votre panier a été mis à jour avec succès.');
define('FS_NEW_ITEM_CART', 'De nouveaux articles ont été ajoutés à votre Panier Enregistré ');
define('FS_CART_ALL_ITEMS', 'Tous les articles de ce panier ne sont plus disponibles à l\'achat, veuillez contacter votre responsable de compte pour connaître la disponibilité.');
define('FS_CART_SOME_CUSTOMIZED', 'Certains articles personnalisés dans ce panier ont été modifiés, veuillez vous rendre sur la page des détails du produit pour sélectionner les attributs.');
define('FS_CART_ALL_CUSTOMEIZED_ITEMS', 'Tous les articles dans ce panier ont été modifiés, veuillez vous rendre sur la page des détails du produit pour sélectionner les attributs.');
define('FS_CART_THE_QUANTITY', 'La quantité dont vous avez besoin dépasse l\'inventaire disponible et a été ajustée en conséquence, veuillez contacter votre responsable de compte pour une quantité supplémentaire.');
define('FS_CART_SHOPPING_CART_DIRECTLY', 'Les articles dans ce panier ne sont plus disponibles à l\'achat en ligne, veuillez contacter votre responsable de compte pour connaître la disponibilité. En attendant, les articles disponibles ont été déplacés directement dans le panier.');
define('FS_CART_QUANTITY_ADDITIONAL', 'La quantité dont vous avez besoin dépasse l\'inventaire disponible et a été ajustée en conséquence, veuillez contacter votre responsable de compte pour une quantité supplémentaire.');
define('FS_CART_CUSTOMIZED_SHOPPING_CART', 'Les articles personnalisés dans ce panier ont été modifiés, veuillez vous rendre sur la page des détails du produit pour sélectionner les attributs. En attendant, les articles disponibles ont été déplacés directement dans le panier.');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','Veuillez entrer le nom du panier, au maximum 150 mots.');

define('FS_FROM','De ');
define('FS_TO_EMAIL','À ');

define('FS_SELECT_SAVE_CART','Veuillez sélectionner un panier enregistré.');

define('FS_NOTICE_FREE_SHIPPING','Livraison gratuite pour les commandes supérieures à $MONEY');
if ($_SESSION['languages_code'] == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))) {
    define('FS_NOTICE_FREE_DELIVERY','Livraison gratuite pour achats supérieurs à $MONEY (hors TVA)');
} else {
    define('FS_NOTICE_FREE_DELIVERY','Livraison gratuite pour achats supérieurs à $MONEY');
}

define('FS_NOTICE_FAST_SHIPPING','Expédition rapide vers $COUNTRY.');
define('FS_NOTICE_HEADER_COMMON_TIPS',' En raison du COVID-19, les délais de livraison peuvent être prolongés.');

define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 Jours Ouvrables Service');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early® service');
define('FS_SERVICE_WORD', 'Service');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'Effectuer un Paiement');
define('FS_EMAIL_OPTIMIZE_02', 'Remarque : si vous avez déjà effectué le paiement, veuillez ignorer cet e-mail, merci.');
define('FS_EMAIL_OPTIMIZE_03', 'On s\'en occupe !');
define('FS_EMAIL_OPTIMIZE_04', 'Les détails de votre commande #ORDER_NUMBER sont ci-dessous. En cas de mise à jour de votre commande, nous vous enverrons immédiatement les informations de suivi.');
define('FS_EMAIL_OPTIMIZE_05', 'Voir la Commande');
define('FS_EMAIL_OPTIMIZE_06', 'Remarque : si vous avez déjà téléchargé le PO, veuillez ignorer cet e-mail, merci.');
define('FS_EMAIL_OPTIMIZE_07', 'Merci pour votre Achat');
define('FS_EMAIL_OPTIMIZE_08', 'Veuillez compléter les paiements dans un délai de 7 jours ouvrables. Dans le cas contraire, la commande sera automatiquement annulée en raison du changement de stock des articles. Après avoir effectué le paiement, vous recevrez une notification pour vous informer que FS a confirmé votre commande.');
define('FS_EMAIL_OPTIMIZE_09', 'Instructions de Paiement');
define('FS_EMAIL_OPTIMIZE_10', 'Une fois le paiement effectué avec succès, veuillez envoyer un bordereau de virement bancaire à $FS_EMAIL. ou votre responsable de compte. Cela permettra de libérer votre commande en priorité et d\'éviter son annulation. Veuillez effectuer votre paiement sur le compte suivant.');
define('FS_EMAIL_OPTIMIZE_11', 'Remarque : veuillez laisser votre numéro de commande $ORDER_NUMBER et votre adresse e-mail dans la note de transfert bancaire.');
define('FS_EMAIL_OPTIMIZE_12', 'Politique de Livraison');
define('FS_EMAIL_OPTIMIZE_13', 'Le délai de livraison estimé prend effet à partir du moment où nous avons reçu votre paiement');
define('FS_EMAIL_OPTIMIZE_14', 'Votre commande sera livrée entre 9h et 17h, du Lundi au Vendredi (hors jours fériés). Une personne devra être présente à l\'adresse indiquée pour accepter et confirmer la livraison.');

define('FS_PLEASE_CHECK_THE_URL','Veuillez vérifier l\'URL ou retourner à la page ');
define('FS_HOMEPAGE','d\'Accueil');
define('FS_GO_TO_HOMEPAGE','Page d\'Accueil');

define('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 Jours Ouvrables');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 Jours Ouvrables');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 Jours Ouvrables');

define("FS_WORD_CLOSE", 'Fermer');

//报价购物车
define('FS_NEW_OTHER_LENGTH','Autre longueur');
define('FS_INQUIRY_CART_1',"Demander un Devis");
define('FS_INQUIRY_CART_2',"Coordonnées");
define('FS_INQUIRY_CART_3',"Prénom*");
define('FS_INQUIRY_CART_4',"Prénom*");
define('FS_INQUIRY_CART_5',"E-mail*");
define('FS_INQUIRY_CART_6',"Téléphone");
define('FS_INQUIRY_CART_7',"Commentaires");
define('FS_INQUIRY_CART_8',"Télécharger le Fichier");
define('FS_INQUIRY_CART_9',"Autoriser les fichiers de type PDF, JPG, PNG.<br>Taille maximale : 5M.");
define('FS_INQUIRY_CART_10',"Ajoutez rapidement des articles à votre devis en indiquant le numéro ID du produit et la quantité.");
define('FS_INQUIRY_CART_11',"Ajouter au Devis");
define('FS_INQUIRY_CART_12',"Demande de Devis");
define('FS_INQUIRY_CART_13',"Si vous avez des exigences particulières, veuillez laisser un message.");
define('FS_INQUIRY_CART_14',"Veuillez entrer le numéro ID du produit");
define('FS_INQUIRY_CART_15',"Veuillez entrer l'ID de produit.");



define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'UPS Express Saver® Next Day Service');
define("FS_BLANK", ' ');
// 结算页美国、澳大利亚跳转
define('AUSTRALIA_HREF_1',"Les commandes sur ce site ne peuvent pas être livrées en Australie. Veuillez vous rendre sur le site de ");
define('FS_AUSTRALIA_CHECKOUT',"FS Australie");
define('AUSTRALIA_HREF_2'," si vous souhaitez livrer en Australie.");
define('UNITED_STATES_SITE_HREF_1',"Les commandes sur ce site ne peuvent pas être livrées aux États-Unis. Veuillez vous rendre sur le site de ");
define('FS_UNITED_STATES_SITE',"FS États-Unis");
define('UNITED_STATES_SITE_HREF_2'," si vous souhaitez livrer aux États-Unis.");
define('RUSSIAN_SITE_HREF_1',"Pour les Personnes Morales, les commandes doivent être payées par Paiement sans Numéraire en Roubles. Veuillez vous rendre sur le site de ");
define('FS_RUSSIAN_SITE',"FS Fédération de Russie");
define('RUSSIAN_SITE_HREF_2'," si vous souhaitez passer les commandes.");


//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'Chargement du Panier');

define('FS_VAX_TITLE_US','Taxe de Vente Estimée');
define('FS_VAX_TITLE_US_TAX','Taxe de Vente');

//消费税提示小气泡
define('FS_VAX_US_TIPS','Selon les lois fiscales de l\'État, FS est tenu de percevoir la taxe de vente auprès des parties non exonérées. <a href="https://www.fs.com/service/sales_tax.html" target="_blank">En savoir plus</a>');


//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "Voir les Commentaires");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "Écrire un Commentaire");
define('FS_VIEW_REVIEWS_SEARCH', "Rechercher");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "Rechercher des Commentaires :");
define('FS_VIEW_REVIEWS_ITEM', "Article #");
define('FS_VIEW_REVIEWS_1', "Aucun Commentaire Trouvé.");
define('FS_VIEW_REVIEWS_2', "Trouvez votre commande et partagez votre commentaire.");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "Évalué le ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "Très satisfait");
define('FS_VIEW_REVIEWS_READ_MORE', "En savoir plus");
define('FS_VIEW_REVIEWS_MORE', "Plus");
define('FS_VIEW_REVIEWS_SHOW', "Afficher");
define('FS_VIEW_REVIEWS_COMMENTS', "commentaires");


define('FS_SRVICE_WORD', "service");

define('FS_PRODUCT_MATERIAL_M','m');
define('FS_PRODUCT_MATERIAL_CABLE',' Matériaux du Câble');
define('FS_PRODUCT_MATERIAL_TIP','Le délai de livraison sera un peu plus long si la quantité demandée dépasse le stock. Pour demander une expédition fractionnée d\'articles en stock, veuillez contacter votre responsable de compte.');

define('FS_INQUIRY_PRODUCTS_NUM',"Veuillez vérifier les informations sur le produit dans les détails de votre devis.");

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'Veuillez entrer votre nom complet.');
define('FS_NET_30_02', 'Veuillez télécharger votre Formulaire de Demande.');
define('FS_NET_30_03', 'Le Compte de Crédit existe déjà.');
define('FS_NET_30_04', 'FS - Votre Demande de Bon de Commande a été Reçue');
define('FS_NET_30_05', 'Nous avons reçu votre demande de Bon de Commande.  Elle est actuellement en cours de révision et ce processus peut prendre 2 - 3 jours ouvrables. Lorsqu\'une décision a été prise, vous serez informé par un e-mail de FS en temps opportun.');
define('FS_NET_30_06', 'État de la Demande');
define('FS_NET_30_07', 'Envoyée');
define('FS_NET_30_08', 'En Cours de Révision');
define('FS_NET_30_09', 'Approuvée');
define('FS_NET_30_10', 'Rejetée');
define('FS_NET_30_11', 'Envoyer le Formulaire de Demande');
define('FS_NET_30_12', 'Nom Complet');
define('FS_NET_30_13', 'E-mail');
define('FS_NET_30_14', 'Téléphone');
define('FS_NET_30_15', 'Télécharger des Fichiers');
define('FS_NET_30_16', 'Sélectionner un Fichier');
define('FS_NET_30_17', 'Votre formulaire de demande a été envoyé avec succès.');
define('FS_NET_30_18', 'Nous vous enverrons le résultat de la révision dans les 2-3 jours ouvrables par e-mail, vous pouvez également suivre les mises à jour dans "#CASE_CENTER" avec le compte FS.');
define('FS_NET_30_19', 'Merci ! Votre Formulaire de Demande de Crédit a été Envoyé avec Succès.');
define('FS_NET_30_20', 'Votre demande de Bon de Commande est en cours de révision, veuillez prévoir environ 2-3 jours ouvrables pour le traitement.');
define('FS_NET_30_21', 'Nous sommes heureux de vous informer que votre demande de Bon de Commande a été approuvée. Maintenant, vous pouvez passer la commande sur FS avec Bon de Commande.');
define('FS_NET_30_22', 'Vous pouvez également consulter les détails de votre crédit dans “#FS_CREDIT”.');
define('FS_NET_30_23', 'Nous sommes désolés de vous informer que votre demande de Bon de Commande a été rejetée. ');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', 'Vous voulez faire une nouvelle demande pour le Bon de Commande ?');
define('FS_NET_30_25', 'Remplissez et Envoyez le Formulaire de Demande à “#NET_TERMS”.');
define('FS_NET_30_26', 'Pour toute question, n\'hésitez pas à contacter votre responsable de compte #ACCOUNT_MANAGER.');
define('FS_NET_30_27', 'Pays/Région');
define('FS_NET_30_28', 'Commentaires');
define('FS_NET_30_29', 'Envoyer');
define('FS_NET_30_30','Merci<br>FS Équipe');
define('FS_NET_30_31','Demande Reçue');
define('FS_NET_30_32','Bon de Commande');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','Explorez les dernières innovations');

//取消订阅
define('FS_UNSUBSCRIBE_MAIL_1','FS Newsletter');
define('FS_UNSUBSCRIBE_MAIL_2',"Pour en savoir plus sur les dernières politiques préférentielles, l'information d'inventaire, le support technique, etc.");
define('FS_UNSUBSCRIBE_MAIL_3','E-mails de Demande de Commentaire');
define('FS_UNSUBSCRIBE_MAIL_4','Les e-mails de demande de commentaire seront envoyés après 7 jours à compter de la livraison de la commande.');
define('FS_UNSUBSCRIBE_MAIL_5',"Gérez vos préférences d'abonnement pour recevoir des e-mails de FS.");
define('FS_UNSUBSCRIBE_MAIL_6','Les e-mails concernant votre compte et vos commandes sont importants. Nous les envoyons même si vous avez choisi de ne plus recevoir d\'e-mails suivants.');

//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', 'Entreprises');

/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','Longueur d\'Onde (nm)');

//100G产品提示语
define("FS_COHERENT_CFP","Le module CFP cohérent n'est pas vendu séparément.");

//checkout 账单地址邮编验证提示
define('FS_ZIP_VALID_1',"L'adresse sélectionnée ne correspond pas aux enregistrements du service postal. Veuillez revérifier votre adresse.");
define('FS_ZIP_VALID_2',"Veuillez entrer un Code Postal valide.");


define("FS_SOLUTION_CLICK_OPEN_VIEW","Cliquez sur l'image pour l'agrandir");
define("FS_CUSTOMIZE_YOUR_SOLUTION","Choisissez et Personnalisez la Solution");
define("FS_TECH_SPEC_CUSTOMOZATION","Spécifications Techniques");
define("FS_SOLUTION_OVERVIEW",'Aperçu');
define("FS_SOLUTION_CUSTOMIZED",'Ajouter au Panier');
define("FS_SOLUTION_EDIT",'Modifier');
define("FS_SOLUTION_CONFIGURATION",'Configuration de la Solution');
define("FS_SOLUTION_MORE",'Plus');
define("FS_SOLUTION_LESS",'Moins');
define("FS_SOLUTION_DEVICES",'Dispositifs');
define("FS_SOLUTION_TRANSCEIVER",'Module');
define("FS_SOLUTION_WAVE_COM_BAR",'Longueur d\'Onde & Marques Compatibles');
define("FS_SOLUTION_ACCESSORIES",'Accessoires');
define("FS_SOLUTION_CHOOSE_LENGTH",'Choisissez la Longueur');
define("FS_SOLUTION_INFO",'Informations sur la Solution');

define('FS_SOLUTION_PERSONALIZATION','Personnalisation');
define('FS_SOLUTION_MANUFACTURING','Production');
define('FS_SOLUTION_SHIPPED','Expédition');
define('FS_SOLUTION_ARRIVED','Arrivée');
define('FS_SOLUTION_CON_LIST','Liste de Configuration de Solution');
define('FS_SOLUTION_QUANTITY','Quantité');
define('FS_SOLUTION_TOTAL','Total');

define('FS_SOLUTION_SITEA','Site A');
define('FS_SOLUTION_SITEB','Site B');

define('FS_SOLUTION_NAV_01','Réseau de Transport Optique');
define('FS_SOLUTION_NAV_02','Réseau de Campus');
define('FS_SOLUTION_NAV_03','Centre de Données');
define('FS_SOLUTION_NAV_04','Câblage Structuré');
define('FS_SOLUTION_NAV_05','Par Application');
define('FS_SOLUTION_NAV_06','Réseau à Double Fibre 10G CWDM');
define('FS_SOLUTION_NAV_07','Réseau à Seule Fibre 10G CWDM');
define('FS_SOLUTION_NAV_08','Réseau à Double Fibre 10G DWDM');
define('FS_SOLUTION_NAV_09','Réseau à Seule Fibre 10G DWDM');
define('FS_SOLUTION_NAV_10','Réseau à Double Fibre 25G DWDM');
define('FS_SOLUTION_NAV_11','Réseau à Seule Fibre 25G DWDM');
define('FS_SOLUTION_NAV_12','Réseau Cohérent 40/100G');
define('FS_SOLUTION_NAV_13','Réseau d\'Entreprise');
define('FS_SOLUTION_NAV_14','Sans Fil et Mobilité');
define('FS_SOLUTION_NAV_15','Réseau Multi-branches ');
define('FS_SOLUTION_NAV_16','Mise en Réseau Gérée dans le Cloud');
define('FS_SOLUTION_NAV_17','Câblage Structuré du Centre de Données');
define('FS_SOLUTION_NAV_18','Câblage MTP®/MPO à Haute Densité');
define('FS_SOLUTION_NAV_19','Migration 40G/100G');
define('FS_SOLUTION_NAV_20','Câblage en Cuivre Pré-Connectorisé');
define('FS_SOLUTION_NAV_21','Solution CWDM de Multiples Services');
define('FS_SOLUTION_NAV_22','Transport 10G DWDM à Longue Distance');
define('FS_SOLUTION_NAV_23','25G WDM pour 5G Fronthaul');
define('FS_SOLUTION_NAV_24','Solution DWDM Cohérente 100G');
define('FS_SOLUTION_NAV_25','Optimisation du Réseau MLAG');
define('FS_SOLUTION_NAV_26','Commutation de Réseau Central DC');
define('FS_SOLUTION_NAV_27','Solution d\'Alimentation par Ethernet');
define('FS_SOLUTION_NAV_28','Solution sans Fil Sécurisée');
define('FS_SOLUTION_NAV_29','Câblage Structuré du Centre de Données');
define('FS_SOLUTION_NAV_30','Câblage MTP®/MPO à Haute Densité');
define('FS_SOLUTION_NAV_31','Migration 40G/100G');
define('FS_SOLUTION_NAV_32','Câblage en Cuivre Pré-Connectorisé');
define('FS_SOLUTION_NAV_33','Équipe Technique et Support de Solution Professionnels');
define('FS_SOLUTION_NAV_34','Centre de Données d\'Entreprise');
define('FS_SOLUTION_NAV_35','Centre de Données des Fournisseurs de Services');
define('FS_SOLUTION_NAV_36','Centre de Données Hyperscale et Cloud');
define('FS_SOLUTION_NAV_37','Centre de Données Multi-locataire');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','10G DWDM à Longue Distance de la Série M6200');
define('FS_SOLUTION_NAV_M6500','100G/200G à Haut Débit de la Série M6500');
define('FS_SOLUTION_NAV_M6800','Solution 1,6T de la Série M6800 pour DCI');
define('FS_SOLUTION_NAV_WiFi6','Solutions de Mise en Réseau Wi-Fi 6');

define("FS_CHECKOUT_ERROR_SG_01","Votre Adresse 2 est Requise.");
define("FS_CHECKOUT_ERROR_SG_02","Appartement, Chambre, Étage/N° d'Unité");
define("FS_CHECKOUT_ERROR_SG_03","Numéro de Billet");
define("FS_CHECKOUT_ERROR_SG_04","Pour assurer une livraison rapide, veuillez fournir le Numéro de Billet du colis envoyé à Equinix.");
define("FS_CHECKOUT_ERROR_SG_05","*Pendant la période de gestion spéciale de COVID-19, il est recommandé de remplir l'adresse de votre maison pour garantir la réception en temps opportun.");
define("FS_CHECKOUT_ERROR_SG_06","Veuillez remplir votre adresse de livraison complètement.");

define('FS_CHECKOUT_ERROR_001',"Vous avez atteint le nombre maximum pour l'achat des articles ci-dessus. Tous les produits disponibles sont ajoutés dans le panier. ");
define('FS_CHECKOUT_ERROR_002','Veuillez sélectionner <span>4</span> Canaux différents. ');

define("FS_SEE_ALL_RESULTS","Voir tous les résultats");

define("FS_SEE_ALL_RESULTS","Voir tous les résultats");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD',"Téléchargement de Logiciel");
define('FS_CHECK',"Vérifiez la dernière version logicielle des commutateurs que vous avez achetés.");
define('FS_SOFWARE','Téléchargement de Logiciel');
define('FS_SOFWARE_1','Contactez le Service Client');
define('FS_SOFWARE_2','Vérifiez la dernière version du logiciel des commutateurs que vous avez achetés. Pour plus d\'informations, veuillez consulter');
define('FS_SOFWARE_4','Centre de Téléchargement');
define('FS_SOFWARE_5','Afficher :');
define('FS_SOFWARE_6','Switch Réseau');
define('FS_SOFWARE_7','Switch 1G/10G');
define('FS_SOFWARE_8','Switch 25G');
define('FS_SOFWARE_9','Switch 40G');
define('FS_SOFWARE_10','Switch 100G');
define('FS_SOFWARE_11','Switch 400G');
define('FS_SOFWARE_12','Chercher un Article :');
define('FS_SOFWARE_13','Cherchez');
define('FS_SOFWARE_14','Dernières Informations sur les Fichiers');
define('FS_SOFWARE_15','N° d\'Article');
define('FS_SOFWARE_16','Date de Publication');
define('FS_SOFWARE_17','Taille');
define('FS_SOFWARE_18','Logiciel');
define('FS_SOFWARE_19','Notification de Logiciel');
define('FS_SOFWARE_20','Dernières Informations sur les Fichiers');
define('FS_SOFWARE_22','Note de Publication');
define('FS_SOFWARE_23','Publication');
define('FS_SOFWARE_24','Logiciel');
define('FS_SOFWARE_25','Télécharger');
define('FS_SOFWARE_26','Notification de Logiciel');
define('FS_SOFWARE_27','Se désabonner');
define('FS_SOFWARE_28','S\'abonner');
define('FS_SOFWARE_29','Se désabonner de la nouvelle version du logiciel ?');
define('FS_SOFWARE_30','S\'abonner à une nouvelle version du logiciel ?');
define('FS_SOFWARE_31','Si vous ne trouvez pas votre logiciel, essayez de sélectionner différentes conditions de filtrage.');
define('FS_SOFWARE_32','Vous n\'avez pas acheté de commutateurs FS auparavant, passez à l\'achat de commutateurs FS.');
define('FS_SOFWARE_33','Commencez Vos Achats');
define('FS_SOFWARE_34','Vous vous êtes abonné avec succès.');
define('FS_SOFWARE_35','Vous recevrez une notification par e-mail concernant le dernier logiciel.');
define('FS_SOFWARE_36','Vous vous êtes abonné avec succès.');
define('FS_SOFWARE_37','Vous vous êtes désabonné avec succès.');
define('FS_SOFWARE_38','Vous ne recevrez plus de notification par e-mail concernant le dernier logiciel.');
define('FS_SOFWARE_39','N° d\'Article');
define('FS_SOFWARE_40','AUCUN LOGICIEL TROUVÉ.');
define('FS_SOFWARE_41','Abonnement Confirmé');
define('FS_SOFWARE_42','Vous avez réussi à vous abonner aux mises à jour logicielles pour le switch ci-dessous, nous vous enverrons une notification une fois la dernière version disponible.');
define('FS_SOFWARE_43','Vous pourriez aussi être intéressé par...');
define('FS_SOFWARE_44','Découvrez ce que nous avons apporté à nos clients du monde entier.');
define('FS_SOFWARE_45','Découvrez les derniers produits innovants et les événements d\'entreprise.');
define('FS_SOFWARE_46','FS - Abonnement aux Mises à Jour Logicielles');
define('FS_SOFWARE_47','Se Désabonner avec Succès');
define('FS_SOFWARE_48','Vous ne recevrez plus les notifications de mise à jour des logiciels pour le switch ci-dessous.');
define('FS_SOFWARE_49','S\'il y a une erreur, réabonnez-vous en cliquant sur le bouton ci-dessous.');
define('FS_SOFWARE_50','Réabonnez-vous');
define('FS_SOFWARE_51','Gardons le Contact');
define('FS_SOFWARE_52','Abonnement Logiciel');
define('FS_SOFWARE_53','FS Études de Cas');
define('FS_SOFWARE_54','FS Nouvelle Annonce');

define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','Vous ne trouvez pas d\'option de livraison ?');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','En raison de la restriction du transporteur sur la dimension de l\'article, les commandes contenant #73579/#73958 ne peuvent pas être expédiées par livraison express générale. Vous pouvez utiliser votre propre transporteur ou consulter votre responsable de compte au sujet de l\'expédition par transitaire. Nous sommes désolés pour les inconvénients.');


define('FS_CHECKOUT_FOOTER_NEW_01', "J'ai des commentaires sur");
define('FS_CHECKOUT_FOOTER_NEW_02', '<a href="' . reset_url('service/fs_support.html'). '" target="_blank" >Centre d\'Assistance</a> ou <a target="_blank" href="' . reset_url('contact_us.html') . '">Contactez-Nous</a>.');
define('FS_CHECKOUT_FOOTER_NEW_03', 'Pour une assistance immédiate, veuillez visiter ');
define('FS_CHECKOUT_FOOTER_NEW_04', 'Sélectionner un sujet*');
define('FS_CHECKOUT_FOOTER_NEW_05', 'Veuillez sélectionner... ');
define('FS_CHECKOUT_FOOTER_NEW_06', 'Connexion/Création d\'un compte');
define('FS_CHECKOUT_FOOTER_NEW_07', 'Panier');
define('FS_CHECKOUT_FOOTER_NEW_08', 'Taxe');
define('FS_CHECKOUT_FOOTER_NEW_09', "Adresse d'Expédition et de Facturation");
define('FS_CHECKOUT_FOOTER_NEW_10', 'Expédition');
define('FS_CHECKOUT_FOOTER_NEW_11', 'Paiements');
define('FS_CHECKOUT_FOOTER_NEW_12', 'Autres');
define('FS_CHECKOUT_FOOTER_NEW_13', 'Veuillez sélectionner un sujet.');
define('FS_CHECKOUT_FOOTER_NEW_14', 'Que pouvons-nous faire pour améliorer votre expérience ?');
define('FS_CHECKOUT_FOOTER_NEW_15', 'Vos commentaires aident FS à fournir un service plus rapide.');
define('FS_CHECKOUT_FOOTER_NEW_16', 'Veuillez entrer plus de 10 caractères.');
define('FS_CHECKOUT_FOOTER_NEW_17', 'Envoyer');
define('FS_CHECKOUT_FOOTER_NEW_18', 'Merci pour vos commentaires.');
define('FS_CHECKOUT_FOOTER_NEW_19', 'Nous examinerons vos commentaires et les utiliserons pour améliorer le site web du FS pour vos visites futures.');
define('FS_CHECKOUT_SUCCESS_EMAIL_01', 'Vous avez reçu un nouveau commentaire');
define('FS_CHECKOUT_SUCCESS_EMAIL_02', 'Le client a envoyé les informations ci-dessous à la page de paiement réussi, veuillez suivre si nécessaire.');
define('FS_CHECKOUT_SUCCESS_EMAIL_03', 'Nom du Client :');
define('FS_CHECKOUT_SUCCESS_EMAIL_04', 'E-mail du Client :');
define('FS_CHECKOUT_SUCCESS_EMAIL_05', 'N° de Commande :');
define('FS_CHECKOUT_SUCCESS_EMAIL_06', 'Sujet du Commentaire :');
define('FS_CHECKOUT_SUCCESS_EMAIL_07', 'Contenu Supplémentaire :');
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'Sujet du Commentaire');

define('FS_PRINT',"Pour protéger la confidentialité du client, veuillez entrer l'e-mail de l'utilisateur qui a passé cette commande pour vérifier les détails de la commande :");
define('FS_PRINT_1',"Confirmer");
define('FS_PRINT_2',"L'e-mail que vous avez entré ne correspond pas aux informations de commande. Veuillez vérifier et entrer à nouveau.");
define('FS_PRINT_3',"Veuillez entrer l'adresse e-mail.");

//线下订单列表
define('FS_OFFLINE_01','Télécharger la Facture');
define('FS_OFFLINE_02','Date : ');
define('FS_OFFLINE_03','Commande #: ');
define('FS_OFFLINE_04','Sous-total : ');
define('FS_OFFLINE_05','Frais de Livraison : ');
define('FS_OFFLINE_06','GST : ');
define('FS_OFFLINE_07','Assurance : ');
define('FS_OFFLINE_08','TOTAL : ');
define('FS_OFFLINE_09','Votre commande a été expédiée selon le moyen sélectionné lors du paiement. Vous pouvez voir le statut de colis en cliquant sur le Numéro de Suivi ci-dessous ou dans l\'e-mail de notification. Cependant, certains transporteurs ne mettent pas toujours à jour les informations de suivi immédiatement, l\'état de livraison peut être différé.');
define('FS_OFFLINE_10',"Cette commande a été remplacée par une nouvelle commande");
define('FS_OFFLINE_11','Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power ');
define('FS_OFFLINE_12','Confirmer la Réception');
define('FS_OFFLINE_13','Cette expédition a été annulée, veuillez contacter votre responsable de compte si vous avez des questions.');
define('FS_OFFLINE_14','Voir');
define('FS_OFFLINE_15',' more deliveries');
define('FS_OFFLINE_16',' in this order.');
define('FS_OFFLINE_17','En Traitement');
define('FS_OFFLINE_18','Fermer');
define('FS_OFFLINE_19','Commande # ');
define('FS_OFFLINE_20','(commande actuelle)');
define('FS_OFFLINE_21','AUCUNE COMMANDE TROUVÉE.');
define('FS_OFFLINE_22','Si vous ne pouvez pas localiser votre commande, essayez de sélectionner différentes conditions de filtrage ou vérifiez le numéro de commande. <br/>Les commandes hors ligne ne peuvent être cherchées qu\'après leur expédition. Vous pouvez consulter votre responsable de compte avant cela.');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','Commandes hors Ligne');
define('FS_OFFLINE_COMBINED_SHIPMENT','Expédition Combinée');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','Pour réduire le nombre de livraisons et aider à protéger l\'environnement, FS a organisé l\'expédition de vos commandes ci-dessous ensemble. Cliquez sur le numéro de commande # pour vérifier les détails de la commande respective.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','Si le statut de la commande n\'a pas été mis à jour, veuillez consulter votre responsable de compte. Vous verrez cette commande dans "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" quand elle sera expédiée.');
define('FS_OFFINE_TRANSACTION_1','Cette expédition a été annulée, veuillez contacter votre responsable de compte si vous avez des questions.');
define('FS_OFFLINE_POPUP',"Cette commande a été remplacée par une nouvelle commande");
define('FS_OFFINE_TRANSACTION','Transaction hors Ligne');
define('FS_OFFINE_TRANSACTION_2','Voir les informations de suivi ci-dessous');
define('FS_OFFINE_TRANSACTION_4','Votre commande est en cours de traitement.');
//my credit orders 页面
define('FS_VIEW_CONTENT','Cette commande est divisée en plusieurs livraisons, vous pouvez consulter toutes les factures dans les détails de la commande car les factures sont séparées pour chaque livraison. Cliquez sur ');
define('FS_VIEW_LINK','voir toutes les factures.');
define('FS_MY_CREDIT_01','Afficher :');
define('FS_MY_CREDIT_02','Commandes en Ligne');
define('FS_MY_CREDIT_03','Commandes hors Ligne');
define('FS_MY_CREDIT_04','Confirmez');
define('FS_OFFINE_TRACK_INFO_1',"Si le statut de la commande n'a pas été mis à jour, veuillez consulter votre responsable de compte. Vous verrez cette commande dans <a class='new_alone_a' href=".zen_href_link('manage_orders').">l'Historique de Commandes</a> lorsqu'elle sera expédiée.");



define("FS_SEE_ALL_RESULTS","Voir tous les résultats");

//评论改版
define('FS_REVIEW_07','Modèle d\'équipement');
define('FS_REVIEW_08','L\'ajout du nom du modèle de votre équipement aide les autres acheteurs.');
define('FS_REVIEW_09','Autoriser les fichiers de type JPG, JPEG, PNG.  Taille maximale du fichier : 5MB');
define('FS_REVIEW_11','Optionnel');
define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Compatibilité');


//2020.08.03 liang.zhu
define('FS_CLEARANCE_TIP_01_01', 'Cette promotion est limitée à $QTY pc(s) et sera retirée une fois que l\'article est épuisé.');
define('FS_CLEARANCE_TIP_01_02', 'Pour des quantités supplémentaires, nous recommandons de vous procurer l\'article alternatif "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_02_01', 'L\'article en promotion est en rupture de stock et sera retiré.');
define('FS_CLEARANCE_TIP_02_02', 'Pour des quantités supplémentaires, nous recommandons de vous procurer l\'article alternatif "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_03_01', 'Cette promotion est limitée à $QTY pc(s) et sera retirée une fois que l\'article est épuisé.');
define('FS_CLEARANCE_TIP_03_02', 'Pour des quantités supplémentaires, veuillez contacter votre responsable de compte.');
define('FS_CLEARANCE_TIP_04_01', 'L\'article en promotion est en rupture de stock et sera retiré.');
define('FS_CLEARANCE_TIP_04_02', 'Pour des quantités supplémentaires, veuillez contacter votre responsable de compte.');


define('CHECKOUT_COMPANY_TYPE', 'Le type d\'adresse est incorrect');


## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "Instructions de Livraison (Optionnelles)");
define("FS_DELIVERY_TICKET_NUMBER", "Numéro de billet, code de sécurité, etc.");
define("FS_DELIVERY_OTHER_INFO", "Délai de livraison ou autres instructions de livraison");
define("FS_DELIVERY_PROMPT", "Vos instructions nous aideront à livrer votre colis.");
define('FS_DELIVERY_INSTRUCTIONS', 'Instructions de Livraison');

//PO
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', ' est confirmée. Veuillez télécharger le fichier PO (Bon de Commande) dans les 7 jours ouvrables. Dans le cas contraire, la commande sera automatiquement annulée en raison du changement de stock des articles.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', 'Télécharger le Fichier PO (Bon de Commande)');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', 'Qu\'est-ce qu\'un fichier PO ?');
define('FS_PO_FILE','BON DE COMMANDE');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','Bon de Commande');
define('FS_PO_FILE_4','Date : 08/08/2020<br />PO #: PO0001');
define('FS_PO_FILE_5','Fournisseur');
define('FS_PO_FILE_6','Adresse de Livraison');
define('FS_PO_FILE_7','Adresse de Facturation');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','Responsable de Compte : ');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','E-mail : ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','Tél. #: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','Destinataire : ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','Tél. #: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','Destinataire : ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','Terme de Paiement');
define('FS_PO_FILE_27','Demandé par');
define('FS_PO_FILE_28','Département');
define('FS_PO_FILE_29','Virement Bancaire');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','Département Achats');
define('FS_PO_FILE_32','FS RQC #: RQC2008010003');
define('FS_PO_FILE_33','<th>Description de l\'Article</th><th>N° de l\'Article</th><th>Qté</th><th>Prix Unitaire</th><th>Total</th>');
define('FS_PO_FILE_36','SOUS-TOTAL :');
define('FS_PO_FILE_38','Frais de Livraison :');
define('FS_PO_FILE_39','TVA :');
define('FS_PO_FILE_40','TOTAL :');
define('FS_PO_FILE_41',"Qu'est-ce qu'un fichier PO ?");
define('FS_PO_FILE_42',"Le fichier de bon de commande (PO) est utilisé comme un document pour les commandes d'achat et contient généralement le contenu suivant : ");
define('FS_PO_FILE_43',"Date et numéro du bon de commande;");
define('FS_PO_FILE_44',"Informations sur l'entreprise de l'acheteur et du fournisseur;");
define('FS_PO_FILE_45',"Adresse d'Expédition et de Facturation; Terme de Paiement;");
define('FS_PO_FILE_46',"Informations sur l'article et prix de FS.");
define('FS_PO_FILE_47',"Voir l'exemple du fichier PO");
define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');

//结算页
define('FS_CHECK_OUT_EXCLUDING1','Hors Droits et Taxes');

//搜索V2版本
define('FS_SEARCH_NEW','Résultats de la recherche pour ');
define('FS_SEARCH_NEW_1','Produit');
define('FS_SEARCH_NEW_2','Document &amp; Ressources');
define('FS_SEARCH_NEW_3','Solutions');
define('FS_SEARCH_NEW_4','Études de Cas');
define('FS_SEARCH_NEW_5','Téléchargement');
define('FS_SEARCH_NEW_6','Tout Effacer');
define('FS_SEARCH_NEW_7','Solutions');
define('FS_SEARCH_NEW_8','Études de Cas');
define('FS_SEARCH_NEW_9','Nom');
define('FS_SEARCH_NEW_10','Type');
define('FS_SEARCH_NEW_11','Date');
define('FS_SEARCH_NEW_12','Fichier');
define('FS_SEARCH_NEW_13','Nouvelles');
define('FS_SEARCH_NEW_14',"n'est plus disponible en ligne, veuillez voir le produit similaire ");
define('FS_SEARCH_NEW_15',' comme ci-dessous.');
define('FS_SEARCH_NEW_16'," n'est plus disponible en ligne, pour obtenir de l'aide, veuillez obtenir un devis.");

define('FS_ACCOUNT_SEARCH_ALL_TIMES', 'Filtre de Temps');

define('FS_MY_SHOPPING_CART','Mon Panier');
define('GET_A_QUOTE_TIP_1',"*Pour toute question concernant le délai de livraison ou les informations d'expédition, veuillez remplir les informations ci-dessous et envoyer le devis, nous vous répondrons dès que possible.");

define("FS_INQUIRY_NEW_EMAIL"," vous a envoyé une demande de modification du devis #");
define("FS_INQUIRY_NEW_EMAIL_1"," Modification du Devis");
define("FS_INQUIRY_NEW_EMAIL_2","vous a envoyé une demande de modification du devis");
define("FS_INQUIRY_NEW_EMAIL_3",", Veuillez vérifier les détails ci-dessous et rectifier le devis dans les meilleurs délais.");
define("FS_INQUIRY_NEW_EMAIL_4","Numéro de Cas :");
define("FS_INQUIRY_NEW_EMAIL_5","Article (s)");
define("FS_INQUIRY_NEW_EMAIL_6","Qté.");
define("FS_INQUIRY_NEW_EMAIL_7","Prix Unitaire");
define("FS_INQUIRY_NEW_EMAIL_8","Prix du Devis");
define("FS_INQUIRY_NEW_EMAIL_9","Total Initial :");
define("FS_INQUIRY_NEW_EMAIL_10","Total du Devis :");
define("FS_INQUIRY_NEW_EMAIL_11","Veuillez répondre à ");
define("FS_INQUIRY_NEW_EMAIL_12"," ou envoyer le devis à ce compte.");
define("FS_INQUIRY_NEW_EMAIL_13","Votre demande a été envoyée.");
define("FS_INQUIRY_NEW_EMAIL_14","Nous avons reçu votre e-mail. Votre responsable de compte vous répondra dans les 12-24 heures.");


define('FS_QUOTE_INQUIRY_01', 'Sélectionner un Fichier');
define('FS_QUOTE_INQUIRY_02', 'Télécharger la Liste de Produits');
define('FS_QUOTE_INQUIRY_03', 'Veuillez entrer l\'ID du produit ou télécharger la liste de produits dont vous avez besoin pour demander un devis.');
define('FS_QUOTE_INQUIRY_04', 'Votre demande de devis a été envoyée avec succès.');
define('FS_QUOTE_INQUIRY_05', 'Votre responsable de compte traitera le devis dans les 12-24 heures et vous enverra un e-mail lorsque le devis sera prêt.');
define("FS_QUOTE_EDIT_QUOTE", "Modifier le Devis");
define("FS_QUOTE_QUOTE_REQUEST", "DEMANDE DE DEVIS");
define("FS_QUOTE_INQUIRY_06", "Envoyer un E-mail à votre Responsable de Compte à Propos de ce Devis");
define("FS_QUOTE_INQUIRY_07", "Votre Devis ");
define("FS_QUOTE_INQUIRY_08", "est actif, ");
define("FS_QUOTE_INQUIRY_09", "vous pouvez effectuer la commande directement.");
define("FS_QUOTE_INQUIRY_10", "Si vous avez besoin de modifier ce devis ou si vous avez des questions à ce sujet, vous pouvez indiquer les informations ci-dessous. Un e-mail sera envoyé à votre responsable de compte à la suite de votre message.");
define("FS_QUOTE_INQUIRY_11", "De :");
define("FS_QUOTE_INQUIRY_12", "Le responsable de compte répondra à cet e-mail.");
define("FS_QUOTE_INQUIRY_13", "À :");
define("FS_QUOTE_INQUIRY_14", "Commentaires");
define("FS_QUOTE_INQUIRY_15", "Si vous souhaitez ajouter ou modifier des articles, il est préférable d'écrire l'ID de l'article (par exemple #11552) et la quantité souhaitée.");
define("FS_QUOTE_INQUIRY_16", "Envoyer un E-mail");
define("FS_QUOTE_INQUIRY_17", "Imprimer le Panier");
define("FS_QUOTE_INQUIRY_18", "Imprimer le Devis");
define("FS_QUOTE_INQUIRY_19", "Vous avez besoin de modifier ce devis ?");
define("FS_QUOTE_INQUIRY_20", "Article(s)");
define("FS_QUOTE_INQUIRY_21", "TELECHARGER LA LISTE DE PRODUITS");
define("FS_QUOTE_INQUIRY_22", "Liste de Produits :");
define("FS_QUOTE_INQUIRY_23", "Le statut de la demande de devis ");
define("FS_QUOTE_INQUIRY_24", " a été mis à jour. Veuillez vérifier à nouveau.");
define("FS_QUOTE_INQUIRY_25", "Veuillez télécharger les fichiers relatifs au PO.");
define("FS_QUOTE_INQUIRY_26", "COMMENTAIRES (OPTIONNELS)");
define("FS_QUOTE_INQUIRY_28", "Contenu");

//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_COMMON_DHL','DHL Economy Select');

define('FS_CHECKOUT_PAY_01','Payer');

//详情页新文件标记
define('FS_NEW_FILE_TAG','Nouveau');//详情页新文件标记

//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','Votre modification ');
define('FS_INQUIRY_EDIT_SUCCESS_2',' a été envoyée avec succès.');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','Mon Devis Officiel');

define('FS_XING_HAO', '*');


//下单邮件公司信息底部展示
// 深圳仓
define('FS_CHECKOUT_FS_NAME_CN', "FS.COM LIMITED");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_CN','
			Unit 1, Warehouse No. 7,
			South China International Logistics Center,
			Longhua District,
			Shenzhen, 518109, Chine');
// 德国仓
define('FS_CHECKOUT_FS_NAME_EU', "FS.COM GmbH");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_EU','  
			NOVA Gewerbepark, Building 7,
			Am Gfild 7,
			85375, Neufahrn bei Munich,
			Allemagne');
define('FS_CHECKOUT_EMAIL_TEL_EU', '+49 (0) 8165 80 90 517');
define('FS_CHECKOUT_EMAIL_EU', 'de@fs.com');

// 美东仓
define('FS_CHECKOUT_FS_NAME_US', "FS.COM Inc.");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			Adresse : 380 Centerpoint Blvd,
					New Castle, DE 19720,
					États Unis');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Tél : +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australie,
				ABN : 71 620 545 502
');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Tél : +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapour,
				GST Reg No. : 201818919D
');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Tél : (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');


define('FS_ORDERS_TRACKING_NINJA_STATUS1', 'Réception réussie par l\'expéditeur - FS');
define('FS_ORDERS_TRACKING_NINJA_STATUS2', 'Le colis est en cours de traitement à l\'entrepôt Ninja Van - Installation de Tri de Ninja Van');
define('FS_ORDERS_TRACKING_NINJA_STATUS3', 'Le colis est en route');
define('FS_ORDERS_TRACKING_NINJA_STATUS4', 'Livraison réussie');

//账户中心确认收货弹窗
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'Commentaires de Commandes');
define('FS_ACCOUNT_HISTORY_INFO_THANK', "Merci pour vos achats.");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "Votre commentaire est précieux pour les autres clients, nous aimerions avoir votre commentaire. <br />Cliquez sur le bouton ci-dessous et laissez votre commentaire !");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "Plus Tard");

define('FS_FOOTER_COOKIE_TIP_NEW','Nous utilisons des cookies pour vous offrir la meilleure expérience sur notre site Web. En cliquant sur "Accepter les Cookies" ou en continuant à utiliser ce site, vous acceptez <br/>notre utilisation des cookies conformément à notre <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">politique en matière de cookies</a>. Vous pouvez refuser l\'utilisation des cookies <a href="javascript:;" class="refuse_cookie_btn_google">ici</a>.');
define('FS_FOOTER_COOKIE_TIP_BTN','Accepter les Cookies');



//新增俄罗斯仓库
define("FS_WAREHOUSE_RU","Entrepôt RU");
define('FS_RU_NOTICE',"L'Entrepôt RU de FS, situé à Moscou, supporte une expédition rapide le jour même. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>En savoir plus</a>");
define('FS_COMMON_WAREHOUSE_RU','《FiberStore.COM》Ltd.<br>
            No.4062, d. 6, str. 16<br>
            Proektiruemyy proezd<br>
            Moscow 115432<br>
            Russian Federation<br>
            Tél. : +7 (499) 643 4876');
define("FS_WAREHOUSE_AREA_TIME_48","Retirer moi-même à l'Entrepôt RU à l'heure souhaitée");
define("FS_WAREHOUSE_AREA_SHIP_RU"," depuis l'Entrepôt RU");
define("FS_WAREHOUSE_AREA_RU","ship from RU Warehouse");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', '%s Vendu');
define('FS_PRODUCTS_SALES_SOLDS', '%s Vendus');
define('FS_PRODUCTS_SALES_REVIEW', '%s Commentaire');
define('FS_PRODUCTS_SALES_REVIEWS', '%s Commentaires');



define('FS_REVIEWS_TAG_01', 'Commentaires des Clients');
define('FS_REVIEW_NEW_15', 'Cliquez sur l\'image pour ajouter des étiquettes, vous pouvez également ajouter');
define('FS_REVIEW_NEW_16', 'Etiquettes');
define('FS_REVIEW_NEW_17', 'Sauvegarder');
define('FS_REVIEW_NEW_18', 'Éditer l\'Étiquette');
define('FS_REVIEW_NEW_19', 'Acheté Récemment');
define('FS_REVIEW_NEW_20', 'Aucune Commande Trouvée.');
define('FS_REVIEW_NEW_21', 'Confirmer');
define('FS_REVIEW_NEW_22', 'Entrer l\'ID ou le tire du produit');
define('FS_REVIEW_NEW_23', 'Veuillez entrer l\'ID/le titre du produit.');
define('FS_REVIEW_NEW_24', 'Ajouter une Étiquette');
define('FS_REVIEW_NEW_25', 'Voir les Albums des Clients');
define('FS_REVIEW_NEW_26', 'étiquette');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', 'Caractéristiques du Produit');
define('FS_PRODUCT_COMMUNITY_01', 'Communauté');
define('FS_PRODUCT_COMMUNITY_02', 'Opinions');
define('FS_PRODUCT_COMMUNITY_03', 'Déballage du Commutateur S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_04', 'Test Ixia RFC2544 pour Commutateur S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_05', 'S5860-20SQ : Vidéo de Produit | FS');
define('FS_PRODUCT_COMMUNITY_06', 'Comment Connecter le Commutateur FS avec le Commutateur Cisco | FS');
define('FS_PRODUCT_COMMUNITY_07', 'Unboxing the S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_08', 'Ixia RFC2544 Test for S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_09', 'S3910-24TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_10', 'Unboxing the S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_11', 'Unboxing the S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_12', 'Ixia RFC2544 Test for S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_13', 'S3910-48TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_14', 'First Look at S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_15', 'S5860-24XB-U Multi-Gig L3 Switch Ixia RFC2544 Test | FS');
define('FS_PRODUCT_COMMUNITY_16', 'Uninterruptible Power Supply Test on S5860-24XB-U | FS');
define('FS_PRODUCT_COMMUNITY_17', 'How to Connect FS Multi-Gig L3 Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_18', 'Unboxing L2+ PoE+ Switch S3410-24TS-P | FS');
define('FS_PRODUCT_COMMUNITY_19', 'Take You to Know S3410-24TS-P in Short | FS');
define('FS_PRODUCT_COMMUNITY_20', 'How to Check Power Status of PoE Port via Web | FS');
define('FS_PRODUCT_COMMUNITY_21', 'IXIA RFC2544 Test on S3410-24TS-P PoE Switch | FS');
define('FS_PRODUCT_COMMUNITY_22', 'Comment Remplacer les Alimentations et Ventilateurs | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', 'Points Forts du Produit');

//报价PDF语言包
define('FS_QUOTES_PDF_01', 'DEVIS OFFICIEL');
define('FS_QUOTES_PDF_01_TAX', 'DEVIS OFFICIEL');
define('FS_QUOTES_PDF_02', 'Numéro du Devis');
define('FS_QUOTES_PDF_03', 'Créé par');
define('FS_QUOTES_PDF_04', '1. Le devis n\'est valable que pendant 15 jours, veuillez contacter votre responsable de compte après l\'expiration.');
define('FS_QUOTES_PDF_05', '2. Veuillez laisser le numéro du devis ou le nom de votre entreprise lorsque vous passez la commande.');
define('FS_QUOTES_PDF_TOTAL_TAX', 'Total');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "Nous avons reçu votre demande de devis ");
define('EMAIL_QUOTES_SUCCESS_02', ' et vous enverrons un e-mail avec les détails du devis dans un délai d\'un jour ouvrable.');
define('EMAIL_QUOTES_SUCCESS_03', 'Votre Message');
define('EMAIL_QUOTES_SUCCESS_04', 'Request quote, please give me your best offer.');
define('EMAIL_QUOTES_SUCCESS_05', 'Voir dans Mon Compte');
define('EMAIL_QUOTES_SUCCESS_06', 'Aperçu PDF');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'Vous pouvez voir ce devis dans "Compte/Devis" et le convertir en commande.');
define('EMAIL_QUOTES_SHARE_02', 'Si vous avez des questions sur la configuration, la tarification et la vérification des contrats, ');
define('EMAIL_QUOTES_SHARE_03', 'veuillez contacter votre responsable de compte.');
define('EMAIL_QUOTES_SHARE_04', 'Mise à Jour du Devis');
define('EMAIL_QUOTES_SHARE_05', 'Vous avez reçu un nouveau devis de FS.COM.');


//报价详情页语言包
define('FS_QUOTES_DETAILS_01', 'L\'Inventaire, la Date de Livraison, les Taxes Estimées et les Frais d\'Expédition sont susceptibles d\'être modifiés et seront recalculés lors du paiement.');
define('FS_QUOTES_DETAILS_02', 'Paiement');
define('FS_QUOTES_DETAILS_03', 'Vous trouverez ci-dessous le détail de votre devis. Ce devis est valable jusqu\'au.');
define('FS_QUOTES_DETAILS_04', 'Demande de Devis #:');
define('FS_QUOTES_DETAILS_05', 'Télécharger le Devis');
define('FS_QUOTES_DETAILS_06', 'Date de Demande :');
define('FS_QUOTES_DETAILS_07', 'Date de Devis :');
define('FS_QUOTES_DETAILS_08', 'N ° du Client :');
define('FS_QUOTES_DETAILS_09', 'N° #');
define('FS_QUOTES_DETAILS_10', 'Responsable de Compte :');
define('FS_QUOTES_DETAILS_11', 'N° du Téléphone #:');
define('FS_QUOTES_DETAILS_12', 'Adresse de Livraison');
define('FS_QUOTES_DETAILS_13', 'Méthode de Livraison : ');
define('FS_QUOTES_DETAILS_14', 'Adresse de Facturation');
define('FS_QUOTES_DETAILS_15', 'Méthode de Paiement :');
define('FS_QUOTES_DETAILS_16', 'Voir Tout');
define('FS_QUOTES_DETAILS_17', 'Référence');
define('FS_QUOTES_DETAILS_18', 'Désolé, l\'article a été supprimé et n\'est plus disponible à l\'achat.');
define('FS_QUOTES_DETAILS_19', 'Longueur : ');
define('FS_QUOTES_DETAILS_20', 'Plus');
define('FS_QUOTES_DETAILS_21', 'Cet article inclut les produits suivants');
define('FS_QUOTES_DETAILS_22', 'TVA/Taxe :');
define('FS_QUOTES_DETAILS_23', 'Ce devis a expiré le $TIME. Vous pouvez demander à nouveau si nécessaire.');
define('FS_QUOTES_DETAILS_24', 'Le devis a été commandé avec succès.');


//报价列表页语言包
define('QUOTES_LIST_BRED_CRUMBS','Historique du Devis');

define('QUOTES_LIST_TIME_TYPE_1', 'Tous les Temps');
define('QUOTES_LIST_TIME_TYPE_2', 'Dernier Mois');
define('QUOTES_LIST_TIME_TYPE_3', '3 Derniers Mois');
define('QUOTES_LIST_TIME_TYPE_4', 'Dernière Année');
define('QUOTES_LIST_TIME_TYPE_5', 'Il y a un An');

define('QUOTES_LIST_STATUS_TYPE_1', 'Devis en Ligne');
define('QUOTES_LIST_STATUS_TYPE_2', 'Actif');
define('QUOTES_LIST_STATUS_TYPE_3', 'Acheté');
define('QUOTES_LIST_STATUS_TYPE_4', 'Expiré');
define('QUOTES_LIST_STATUS_TYPE_5', 'Devis hors Ligne');
define('QUOTES_LIST_STATUS_TYPE_6', 'Tous les États');

define('QUOTES_LIST_RESULT_SINGULAR', 'Résultat');
define('QUOTES_LIST_RESULT_PLURAL', 'Résultats');
define('QUOTES_LIST_UPDATE_TIME', 'Prix Mis à Jour le $TIME');
define('QUOTES_LIST_EXPIRE_TIME', 'Expire le $TIME');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', 'Expire le $TIME');
define('QUOTES_LIST_QUOTE_AGAIN', 'Demander à Nouveau');
define('QUOTES_LIST_VIEW_ORDERS', 'Voir l\'Historique des Commandes');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', 'Recherche par N° du Devis, Description du Devis …');

define('FS_SHOPPING_CART_CREATE_QUOTE', 'Créer un Devis');
define('FS_QUOTES_ORDERS_NUMBER', 'N° de Commande');
define('QUOTES_LIST_EMPTY_TIPS', 'Aucun Devis Trouvé.');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - Nous avons reçu votre demande de devis $NUM');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS - Votre ami(e) $EMAIL vous a partagé un devis');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', 'Les Frais d\'Expédition et la TVA seront calculés au paiement.');


define('FS_RECENT_SEARCH', 'Recherche Récente');
define('FS_HOT_SEARCH', 'Recherche Populaire');
define('FS_CHANGE', 'Changer');

define('FS_VIEW_WORD', 'Voir');

//一级分类页
define('FS_CATEGORIES_POPULAR', 'Catégories Populaires');
define('FS_CATEGORIES_BEST_SELLERS', 'Meilleures Ventes');
define('FS_CATEGORIES_NETWORK', 'Accessoires du Réseau');
define('FS_CATEGORIES_DISCOVERY', 'Découverte');

define('CARD_NOT_SUPPORT', "Ce mode de paiement n'est pas pris en charge actuellement. Veuillez utiliser un autre mode de paiement.");

//全站help center 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','FS Support');


define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '<span class="new_proList_proListNtit">Il n\'y a pas de résultats pour</span> "###SEARCH_WORD###" <span class="new_proList_proListNtit">et nous affichons les résultats pour</span> "###RECOMMEND_WORD###"<span class="new_proList_proListNtit">.</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', 'Avez-vous recherché pour <a target="_blank" href="###HREF_LINK###">###RECOMMEND_WORD###</a>');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', 'Le nouveau produit amélioré ci-dessous vous est recommandé.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', 'Le produit similaire ci-dessous vous est recommandé.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', 'Le produit personnalisé ci-dessous vous est recommandé.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', 'Vous ne trouvez pas ce dont vous avez besoin ? Veuillez nous contacter pour obtenir de l\'aide.');
define('SEARCH_OFFLINE_PRODUCT_TIP', '"KEYWORD" n\'est plus disponible pour achat en ligne, mais est toujours fourni par FS. Pour plus de détails, veuillez consulter la <a  style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">Politique de Fin de Vente</a>.');
//信用卡语言包
define("CREDIT_CARD_ERROR_303","Déclin générique - Aucune autre information n'est fournie par l'émetteur");
define("CREDIT_CARD_ERROR_606","L'émetteur n'autorise pas ce type de transaction");
define("CREDIT_CARD_ERROR_08","Les données CVV2/CID/CVC2 ne sont pas vérifiées");
define("CREDIT_CARD_ERROR_22","Numéro de Carte de Crédit non Valide");
define("CREDIT_CARD_ERROR_25","Date d'Expiration Non Valable");
define("CREDIT_CARD_ERROR_26","Montant Non Valable");
define("CREDIT_CARD_ERROR_27","Titulaire de la Carte Non Valide");
define("CREDIT_CARD_ERROR_28","Numéro d'Autorisation Non Valable");
define("CREDIT_CARD_ERROR_31","Champ de Vérification Non Valable");
define("CREDIT_CARD_ERROR_32","Code de Transaction Non Valable");
define("CREDIT_CARD_ERROR_57","Numéro de Référence Non Valable");
define("CREDIT_CARD_ERROR_58","Champ AVS invalide. La longueur du champ a été dépassé. 40 caractères maximum");
define('CREDIT_CARD_ERROR_260',"Le service est temporairement indisponible en raison d'une erreur de réseau. Veuillez essayer plus tard ou contacter votre responsable de compte.");
define('CREDIT_CARD_ERROR_301',"Le service est temporairement indisponible en raison d'une erreur de réseau. Veuillez essayer plus tard ou contacter votre responsable de compte.");
define('CREDIT_CARD_ERROR_304',"Le compte n'est pas reconnu. Veuillez vérifier les informations ou contacter la banque émettrice.");
define('CREDIT_CARD_ERROR_401',"L'émetteur désire contacter le titulaire de la carte. Veuillez appeler votre banque émettrice.");
define('CREDIT_CARD_ERROR_502',"La carte est signalée comme perdue/volée. Veuillez contacter votre banque émettrice. Note: Ceci ne s'applique pas à American Express.");
define('CREDIT_CARD_ERROR_505','Votre compte est sur fichier négatif. Veuillez essayer une autre carte ou autre mode de paiement.');
define('CREDIT_CARD_ERROR_509',"Dépasse la limite de retrait ou d'activité. Veuillez essayer une autre carte ou autre mode de paiement.");
define('CREDIT_CARD_ERROR_510',"Dépasse la limite de retrait ou d'activité. Veuillez essayer une autre carte ou autre mode de paiement.");
define('CREDIT_CARD_ERROR_519','Votre compte est sur fichier négatif. Veuillez essayer une autre carte ou autre mode de paiement.');
define('CREDIT_CARD_ERROR_521','Le montant total dépasse la limite de crédit. Veuillez essayer une autre carte ou autre mode de paiement.');
define('CREDIT_CARD_ERROR_522',"Votre carte est expirée. Veuillez vérifier la date d'expiration ou essayer un autre mode de paiement.");
define('CREDIT_CARD_ERROR_530',"Manque d'informations fournies par la banque émettrice. Veuillez contacter votre banque ou essayer un autre mode de paiement.");
define('CREDIT_CARD_ERROR_531',"L'émetteur a décliné la demande d'autorisation. Veuillez contacter votre banque émettrice ou essayer un autre mode de paiement.");
define('CREDIT_CARD_ERROR_591',"Erreur de l'émetteur. Veuillez contacter la banque émettrice ou essayer une autre carte.");
define('CREDIT_CARD_ERROR_592',"Erreur de l'émetteur. Veuillez contacter la banque émettrice ou essayer une autre carte.");
define('CREDIT_CARD_ERROR_594',"Erreur de l'émetteur. Veuillez contacter la banque émettrice ou essayer une autre carte.");
define('CREDIT_CARD_ERROR_776',"Transaction Dupliquée. Veuillez contacter votre responsable de compte pour confirmer l'état de la transaction.");
define('CREDIT_CARD_ERROR_787','La transaction est refusée en raison de risque élevé. Veuillez essayer un autre mode de paiement.');
define('CREDIT_CARD_ERROR_806','Votre carte a été soumise à des restrictions. Veuillez essayer une autre carte ou autre mode de paiement.');
define('CREDIT_CARD_ERROR_825',"Le compte n'est pas reconnu. Veuillez vérifier les informations et réessayer.");
define('CREDIT_CARD_ERROR_902',"Le service est temporairement indisponible en raison d'une erreur de réseau. Veuillez essayer plus tard ou contacter votre responsable de compte.");
define('CREDIT_CARD_ERROR_904',"Votre carte n'est pas activée. Veuillez contacter votre banque émettrice.");
define('CREDIT_CARD_ERROR_201','Numéro de compte non valable/format incorrect. Veuillez vérifier le numéro et réessayer.');
define('CREDIT_CARD_ERROR_204','Erreur non identifiable. Veuillez essayer plus tard ou choisissez un autre mode de paiement.');
define('CREDIT_CARD_ERROR_233','Le numéro de la carte de crédit ne correspond pas au mode de paiement ou NIB non valide. Veuillez essayer une autre carte ou autre mode de paiement.');
define('CREDIT_CARD_ERROR_239',"La carte n'est pas prise en charge. Veuillez essayer une autre carte ou choisir un autre mode de paiement.");
define('CREDIT_CARD_ERROR_261','Numéro de compte non valable/format incorrect. Veuillez vérifier le numéro et réessayer.');
define('CREDIT_CARD_ERROR_351',"Le service est temporairement indisponible en raison d'une erreur de réseau. Veuillez essayer plus tard ou contacter votre responsable de compte.");
define('CREDIT_CARD_ERROR_755',"Le compte n'est pas reconnu. Veuillez vérifier les informations ou contacter la banque émettrice.");
define('CREDIT_CARD_ERROR_758',"Le compte est bloqué. Veuillez contacter votre banque émettrice ou essayer un autre mode de paiement.");
define('CREDIT_CARD_ERROR_834',"La carte n'est pas prise en charge. Veuillez essayer une autre carte ou autre mode de paiement.");
define('HISTORY_TIPS', 'Vous pouvez sélectionner des devis hors ligne créés par votre responsable de compte ici.');
define('TIPS_BUTTON', 'Confirmer');

define('FS_CHECKOUT_EPIDEMIC_TIPS', 'La livraison est susceptible de subir des retards ou restrictions en raison de mesures administratives officielles. Veuillez vous assurer que la livraison soit réceptionnée, sinon le colis sera retourné à l\'expéditeur.');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', 'La commande peut être retardée pour des raisons de dédouanement.');

define('QUOTES_NOTE_TITLE','Remarque :');
define('QUOTES_NOTE_TIPS','L\'Inventaire, la Date de Livraison, les Taxes Estimées et les Frais d\'Expédition sont susceptibles d\'être modifiés et seront recalculés lors du paiement.');
define('QUOTES_RQN_NUMBER_TITLE','N° de RQN :');
define('QUOTES_TRADE_TERM_TITLE','Terme Commercial :');
define('QUOTES_PAYMENT_TERM_TITLE','Moyen de Paiement :');
define('QUOTES_SHIP_VIA_TITLE','Moyen de Livraison :');
define('QUOTES_DATE_ISSUED_TITLE','Date d\'Émission :');
define('QUOTES_EXPIRES_TITLE','Date d\'Expiration :');
define('QUOTES_ACCOUNT_MANAGER_TITLE','Responsable de Compte :');
define('QUOTES_ACCOUNT_EMAIL_TITLE','E-mail :');
define('QUOTES_DELIVER_TO','Adresse de Livraison');
define('QUOTES_BILLING_TO','Adresse de Facturation');
define('QUOTES_QUOTE_TITLE1','Article(s)');
define('QUOTES_QUOTE_TITLE2','Qté');
define('QUOTES_QUOTE_TITLE3','Prix Unitaire');
define('QUOTES_QUOTE_TITLE4','Prix du Devis');

define('FS_WHAT_IS_DIFFERENCE', "Quelle est la Différence ?");
define('FS_AVAILABILITY', 'Disponibilité');
define('FS_ON_SALE', 'Disponible');
define('FS_END_SALE', 'Indisponible');
define('FS_DIFFERENCES', 'Veuillez vérifier les paramètres détaillés pour bien comprendre les différences des produits avant d\'effectuer un achat.');

define('FS_CN_LIMIT_TIPS', 'Veuillez noter que cet article ne peut pas être livré en Chine.');
define('QUOTE_MESSAGE_TXT_1', 'Commentaires Supplémentaires (par '. $_SESSION['customer_first_name'].')');
define('QUOTE_MESSAGE_TXT_2', 'Commentaires Supplémentaires (par Responsable de Compte | FS)');
