<?php
/****************************公共头部***********************************/
define('EMAIL_HEAHER_RIGHT', '+33 (1) 82 884 336');
define('EMAIL_MENU_HOME','Chat en Ligne');
define('EMAIL_MENU_SUPPORT','avec un spécialiste');
define('EMAIL_HOME_URL',zen_href_link(FILENAME_DEFAULT));


/****************************公共底部****************************************/
define('EMAIL_SUPPORT_URL','FS sur Facebook');
define('EMAIL_MENU_TUTORIAL','Twitter');
define('EMAIL_TUTORIAL_URL','Nous Contacter ');
define('EMAIL_MENU_ABOUT_US','Mon Compte');
define('EMAIL_ABOUT_US_URL','Aide d\'Achat');
define('EMAIL_MENU_SERVICE','Politique de Confidentialité');
define('EMAIL_SERVICE_URL','Cette adresse n\'est utilisée que pour l\'envoi de mail, merci de ne pas y répondre.');
define('EMAIL_MENU_CONTACT_US','Nous Contacter');
define('EMAIL_CONTACT_US_URL','fs.com');
define('EMAIL_MENU_PURCHASE_HELP','  Tous Droits Réservés.');
define('EMAIL_PURCHASE_HELP_URL',zen_href_link('how_to_buy'));
define('EMAIL_FOOTER_PROMPT',zen_href_link('my_dashboard'));
define('EMAIL_FOOTER_FS_COPYRIGHT',zen_href_link('privacy_policy'));
define('EMAIL_FOOTER_FS_CONTACT',zen_href_link('contact_us'));




// fairy add
define('EMAIL_FOOTER_FACEBOOK','FS sur Facebook');
define('EMAIL_FOOTER_TWITTER','Twitter');
// fairy add 2017.11.28
define('EMAIL_FOOTER_SINCERELY','Sincèrement,');
define('EMAIL_FOOTER_FS_SERVICE','<a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Service clientèle');

/**************************************content common text**************************************/
define('EMAIL_BODY_COMMON_FSCOM','FS.COM');
define('EMAIL_BODY_COMMON_DEAR','Bonjour');
define('EMAIL_BODY_COMMON_THANKS','Merci');
define('EMAIL_BODY_COMMON_PHONE','Tél :');
define('EMAIL_BODY_COMMON_PARTNER','Partenaire');
define('EMAIL_BODY_COMMON_URL_BASE',zen_href_link(FILENAME_DEFAULT));

//装箱页面新增
define("FS_PRODUCT_INFO_SIZE","Taille :");
define("FS_PRODUCT_INFO_PIECE","Commande par Pièce");
define("FS_PRODUCT_INFO_CASE","Commande par Paquet (");
define("FS_PRODUCT_INFO_PIS","pcs/paquet)");

/*
 *客户保留购物车产品，邮件发给自己
 */
define('FS_EMAIL_CART','Votre liste d\'achat vous attend.');
define('FS_EMAIL_PAST','Auparavant, vous faisiez des achats sur ');
define('FS_EMAIL_FS','FS.COM');
define('FS_EMAIL_SAVED','et sauvegardé la liste des articles pour votre utilisation ultérieure. Utilisez les liens ci-dessous pour trouver des détails sur tous ces articles et commandez sur ');
define('FS_EMAIL_FSCOM',zen_href_link(FILENAME_DEFAULT));
define('FS_EMAIL_MESSAGE','Votre Message :');
define('FS_EMAIL_LIST',zen_href_link('save_shopping_list'));
define('FS_EMAIL_SIN','Sincèrement,');
define('FS_EMAIL_TEAM','Équipe de Service Client');
define('FS_EMAIL_SENT','Cet e-mail a été envoyé par vous-même en utilisant ');
define('FS_EMAIL_SHARE',"'le service Partager Avec Un Ami de FS.COM. À la suite de la réception de ce message, vous ne recevrez aucun message non sollicité de ");
define('FS_EMAIL_OUR',", en savoir plus sur notre ");
define('FS_EMAIL_POLICY',"Politique de Confidentialité");
define('EMAIL_CUSTOMER_SHOPPING_LIST',zen_href_link('share_shopping_list'));
define('FS_EMAIL_TO_US_DEAR','Bonjour ');
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','Une page Web de FS.COM a été partagée avec vous !');
/*
*客户分享购物车邮件（不同部分）
*/
define('FS_EMAIL_SENT_1','Cet e-mail a été envoyé par ');
define('FS_EMAIL_CART_1','Votre ami');
define('FS_EMAIL_CARTS_1','a partagé une liste  d\'achat avec vous !');
define('FS_EMAIL_PAST_1',' pensait que vous souhaitez vérifier ces articles de FS.COM. Voici la liste pour vous. Utilisez les liens ci-dessous pour trouver des détails sur tous ces articles et commandez sur  ');
define('FS_EMAIL_MESSAGE_1',"Message :");
define('FS_EMAIL_THIS_1','Cet e-mail a été envoyé par votre ami ');
define('FS_EMAIL_USING_1','en utilisant');
define('FS_EMAIL_URL_1',zen_href_link('privacy_policy'));

//标题
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT_1','FS.COM - Vous avez une liste d\'achat de  ');

//shopping_cart
define('FS_SHOP_CART_ALERT_JS_40','Votre panier enregistré a été envoyé !');
define('FS_SHOP_CART_ALERT_JS_41','Nous avons envoyé cet e-mail en votre nom avec succès. Si vous souhaitez envoyer cette liste à un autre destinataire, veuillez cliquer sur');
define('FS_SHOP_CART_ALERT_JS_42','Retourner au Panier Enregistré');

// fairy add 2017.11.28
define('EMAIL_BODY_COMMON_PLATFORM','Plate-forme');
define('EMAIL_BODY_COMMON_BROWSER','Navigateur');
define('EMAIL_BODY_COMMON_IP_ADDRESS','Adresse IP');
define('EMAIL_BODY_COMMON_UNKNOWN','Inconnu');
define('EMAIL_BODY_COMMON_EAMIL_USER','Infos de sécurité utilisées : ');
define('EMAIL_BODY_COMMON_EAMIL_COUNTRY','Pays / région');
define('EMAIL_BODY_COMMON_CUSTOMER_NAME','Nom du client: ');
define('EMAIL_BODY_COMMON_CUSTOMER_EMAIL','E-mail de Client : ');

/*********************************contact us to customer*************************************/
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1','Nous avons bien reçu votre message. Vous allez recevoir la réponse sous 12 heures. Veuillez vérifier votre boîte de réception.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT2','Besoin d\'aide rapide ? Consultez FAQ,<br /> vous pouvez trouver des réponses des questions fréquemment posées.<br>Vous pouvez aussi contacter votre représentante de vente professionnelle ou le service clientèle. Nous sommes toujours à votre disposition.');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT3','8 am.- 5 pm. HNP. Lun. à Ven. : '.FS_PHONE_FR);
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT4','');
define('EMAIL_CONTACT_US_TO_SUBJECT','Nous apprécions votre message.  -- FS.COM');

/************************************regist to customer*********************************************/
define('EMAIL_REGIST_TO_CUSTOMER_SUBJECT','Félicitations ! Vous avez un compte sur FS.COM');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT1','Nous vous remercions pour l\'inscription à FS.COM !<br />');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT2','Lorsque vous êtes connecté(e) à votre compte, vous pouvez alors :<br />
1. Passer vos commandes en toute sécurité<br />
2. Suivre vos commandes<br />
3. Consulter vos anciennes commandes<br />
4. Bénéficier du service après-vente en ligne<br />
5. Gérer vos informations personnelles<br />
<br />
Veuillez cliquer sur <a target="_blank" href="'.zen_href_link('login').'" style="color:#363636;">Se Connecter</a> pour plus de détails.');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT3','<br />
Bienvenue à FS.COM, encore une fois.
<br />
820 SW 34th Street Bldg W7 Suite H, Renton, WA 98057, États-Unis<br />
E-mail : sales@fs.com<br />
Tél : +1 877 205 5306<br />
Fax : +1-253-246-7881<br />');

//fairy
// 个人、企业激活邮件内容
define('EMAIL_REGIST_COMMON_VERIFY_EMAIL','Vérifier l\'E-mail');
define('EMAIL_REGIST_COMMON_VERIFYT_TITLE2','Si le lien ne fonctionne pas, essayez de copier cette URL dans la barre d\'adresse de votre navigateur :');
define('EMAIL_REGIST_COMMON_VERIFYT_TIME','Ce lien expirera 3 jours après l\'envoi de ce e-mail.');
define('EMAIL_REGIST_COMMON_SINCERELY','Cordialement,');
define('EMAIL_REGIST_COMMON_FS','Service Client de FS.COM');
// 个人、企业激活邮件内容
define('EMAIL_REGIST_TO_CUSTOMER_THANK','Merci pour votre inscription chez FS.COM !');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO','Votre compte est la destination de toutes les fonctionnalités que FS.COM fournit aux utilisateurs enregistrés, y compris :');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO_DES','<li>Suivi facile de l\'historique de vos commandes</li>
                  <li>Paiement rapide avec un carnet d\'adresse</li>
                  <li>E-mails actualisés sur les nouveautés et les promotions</li>
                  <li>Support technique gratuit & immédiat</li>');
define('EMAIL_REGIST_TO_CUSTOMER_VERIFYT_TITLE','Pour profiter de ces fonctionnalités, veuillez vérifier votre adresse e-mail en cliquant sur le lien ci-dessous.');
// 企业激活邮件
define('EMAIL_REGIST_TO_COMPANY_THANK','Merci pour votre demande de compte d\'entreprise chez FS.COM !');
define('EMAIL_REGIST_TO_COMPANY_INTRO','Votre demande est en cours de révision. Nous vous enverrons un e-mail dans les 24 heures sur le résultat après la vérification.');
define('EMAIL_REGIST_TO_COMPANY_VERIFYT_TITLE','Pour accomplir la création de votre compte, veuillez vérifier votre adresse e-mail en cliquant sur le lien ci-dessous.');
define('EMAIL_REGIST_TO_COMPANY_THANK_AGAIN','Nous apprécions votre coopération et nous vous remercions pour votre confiance sur FS.COM.');
// 个人用户升级企业用户邮件
define('EMAIL_UPGRADE_TO_COMPANY_CONSULT','Pour toutes questions, n\'hésitez pas à <a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');
define('FS_SUBMIT_SUB1','Soumettre');

//fairy 个人注册
define('EMAIL_REGIST_TO_CUSTOMER_THANK_AGAIN','Vous pouvez accéder à votre compte, si vous avez des questions, n\'hésitez surtout pas à <a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">nous contacter.</a>');

/***************************** password forgotten to customer ***************************************/
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_SUBJECT','FS.COM - Demande de réinitialisation du mot de passe');

// fairy 2017.11.28
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TITLE','Comment réinitialiser votre mot de passe du compte chez <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ?');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT1','Cet e-mail a été envoyé en réponse à votre demande de modification de votre compte chez <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT2','Cliquez sur le lien ci-dessous pour accéder au <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">site de FS.COM</a> et réinitialiser votre mot de passe : ');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_RESET_BUTTON','Réinitialiser votre mot de passe');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT3','Veuillez noter que le lien ci-dessus a seulement une durée de 3 jours.');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT4','Si vous n\'avez pas effectué cette modification ou si vous pensez qu\'une personne non autorisée a accédé à votre compte, veuillez <a href="RESET_PWD_LINK" target="_blank" style="color:#0070BC; text-decoration:none;">réinitialiser votre mot de passe</a> immédiatement. Puis <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">connectez-vous</a> pour consulter et mettre à jour vos paramètres de sécurité.');

/***************************** 修改密码成功之后发的邮件 ***************************************/
// fairy 修改密码成功之后的邮件 add 2017.11.28
define('FS_PWD_UPDATE_SUCCESS_EAMIL_THEME','FS.COM - Mot de Passe du Compte Modifié');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_TITLE','Votre mot de passe a bien été modifié');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON1','Le mot de passe de votre <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">compte</a> chez FS.COM (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) a été modifié avec succès <b>EMAIL_TIME</b>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_USER','Informations de sécurité utilisées : ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_COUNTRY','Pays/région : ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON2','Vous pouvez maintenant utiliser vos nouvelles informations de sécurité pour vous connecter à votre compte. Si vous avez besoin d\'aide supplémentaire, veuillez <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON3','Si vous n\'avez pas effectué cette modification ou si vous croyez qu\'une personne non autorisée a accédé à votre compte, veuillez <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">réinitialiser votre mot de passe</a>  immédiatement. Puis <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">connectez-vous</a> pour consulter et mettre à jour vos paramètres de sécurité.');


/**************************************** company_regist *****************************************************/
define('EMAIL_COMPANY_REGIST_SUBJECT','Demande de Compte d’Entreprise de Fiberstore');
define('EMAIL_COMPANY_REGIST_TEXT1','Merci pour votre demande de compte d’entreprise afin de favoriser les coopérations entre entreprises.<br><br>
La demande est en cours d\'examen, et nous vous enverrons le résultat par e-mail sous 48 heures une fois la demande d\'adhésion de l\'entreprise a été vérifiée.');
define('EMAIL_COMPANY_REGIST_TEXT2','Meilleures salutations,');
define('EMAIL_COMPANY_REGIST_TEXT3','Fiberstore Co., Limited');

/********************************************* checkout common ****************************************************************/
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT','Commande de Fiberstore# %s ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_NO','No de Commande');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDERED_ON','Commandé le');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_BILL_TO','Adresse de Facturation ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PAYMENT_METHOD','Moyen de Paiement ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO','Adresse de Livraison ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_VIA','Expédier via');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_NAME','Article');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FSID','ID#');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_PRICE','Prix Unitaire');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_QTY','Qté');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PRICE','Prix');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBTOTAL','Sous-Total ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_CHARGE','Frais de Livraison');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_GRAND_TOTAL','Total Général ');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FS_SKU','FS SKU#');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_PAYPAL','Paypal');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_CARD','Carte de Crédit/Débit');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER','Détails de commande');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY','Voir ou gérer la commande');

/***************************************checkout_westernunion_or_wiretransfer*************************************************/
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT1','Questions Fréquemment Posées');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT2','Quand puis-je recevoir mes articles ?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT3','Dès la confirmation de votre paiement, nous allons traiter votre commande au plus vite.
			Vous pouvez vérifier l’état de votre commande par le numéro de commande à tout moment dans Mes Commandes. Pour plus de détails, veuillez nous contacter.
			Pour d’autres questions, consultez notre FAQ.');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT4','Comment puis-je vous contacter ?');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_TEXT5','Pour toute aide, veuillez nous envoyer un e-mail à <a target="_blank" href="mailto:sales@fs.com" style="color:#3E6EC1;">sales@fs.com</a>
      ou appelez-nous à <a style="color:#363636;" target="_blank" value="+1 877 205 5306">+1 877 205 5306</a> ou cliquez sur le Chat en Ligne. Vous pouvez aussi nous laisser un message, nous le traiterons sous 12 heures. ');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WESTERN_UNION','Merci de votre commande chez FiberStore ! Nous avons reçu votre commande et attendons votre confirmation de paiement.<br>

							Veuillez visiter <a target="_blank" href="'.zen_href_link('manage_orders').'" style="color:#363636;">Mes Commandes</a> pour consulter l’information de notre compte de Western Union si vous ne l’avez pas notée dans le processus de paiement.<br><br>

							Soumettez votre Confirmation de Paiement par Western Union

							Après avoir complété votre transaction de Western Union, envoyez-nous svp le numéro MTCN à <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> ou cliquez sur le lien ci-dessous pour soumettre vos détails de la transaction : <a target="_blank" href="$URL" style="color:#363636;">Cliquez ici pour soumettre vos détails de la transaction.</a>

							Nous ne pouvons procéder à votre commande qu’après la confirmation de paiement. Une fois votre paiement confirmé, nous vous enverrons un e-mail de “Confirmation de Paiement”, et nous traiterons votre commande dès que possible.<br>

							Avez-vous besoin d\'aide pour payer votre commande ? Il suffit de nous contacter à <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a>. Nous vous répondrons sous 12 heures.<br>');
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_WIRE_TRANSFER','<p>Merci de votre commande chez FiberStore ! Nous avons reçu votre commande et attendons votre confirmation de paiement.<br>

      Veuillez visiter <a target="_blank" href="'.zen_href_link('manage_orders').'" style="color:#363636;">Mes Commandes</a> pour consulter l’information de notre compte de virement bancaire si vous ne l’avez pas notée dans le processus de paiement.</p>

      <p>Soumettez votre Confirmation de Paiement par Virement Bancaire<br>

        Après avoir complété votre transaction de virement bancaire, envoyez-nous svp les détails de la transaction à <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a> ou cliquez sur le lien ci-dessous pour soumettre vos détails de la transaction : <a target="_blank" href="$URL" style="color:#363636;">Cliquez ici pour soumettre vos détails de la transaction.</a><br>

        Nous ne pouvons procéder à votre commande qu’après la confirmation de paiement. Une fois votre paiement confirmé, nous vous enverrons un e-mail de “Confirmation de Paiement”, et nous traiterons votre commande dès que possible.</p>

      <p>Avez-vous besoin d\'aide pour payer votre commande ? Il suffit de nous contacter à <a target="_blank" href="mailto:sales@fs.com" style="color:#363636;">sales@fs.com</a>. Nous vous répondrons sous 12 heures.</p>');
	  
define('EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER','<p>Merci pour votre commande, voici les détails : </p>');

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT1","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Veuillez télécharger le bon de commande dans la page <a  href='".zen_href_link('manage_orders')."'>'Mes Commandes'</a> si vous n'avez pas encore le fait. Nous allons traiter votre commande après la confirmation. </p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT2","<p style='color:rgb(51,51,51);margin:0;padding:0;'>Si vous avez d'autres questions sur votre commande, contactez-nous à <a target='_blank' href='http://sales@fs.com'>sales@fs.com</a>. Nous vous répondrons sous 12 heures.</p>");

/************************************* checkout paypal or credit card ****************************************/
define('EMAIL_CHECKOUT_PAYPAL_TEXT1','Commande Reçue, En Attente de Confirmation de Paiement');
/*************************************** checkout payment success ******************************/
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TEXT1','Merci pour commander chez Fiberstore. Nous avons reçu le paiement et traiterons votre commande le plus tôt possible. Si vous avez des questions, s\'il vous plaît <a href="'.zen_href_link('customer_service').'" target="_blank">Contactez-Nous</a>.');

/*********************************** orders status *************************************/
define('EMAIL_ORDERS_STATUS_SUBJECT','Commande Mise à Jour #');
define('EMAIL_ORDERS_STATUS_FOR_ORDER','Pour la Commande No :');
define('EMAIL_ORDERS_STATUS_TEXT1','le statut est modifié. S\'il vous plaît allez à <a href="http://www.fs.com/fr/index.php?main_page=account_history_info&orders_id=$ORDER_ID">Mes Commandes</a> sur www.fs.com pour vérifier les détails.');
define('EMAIL_ORDERS_STATUS_TEXT2','Pour toute aide, veuillez nous envoyer un e-mail à sales@fs.com ou appelez-nous au +1 877 205 5306, nous traiterons sous 12 heures.');
define('EMAIL_ORDERS_STATUS_TEXT3','Merci pour tout le soutien.');
define('EMAIL_ORDERS_STATUS_TEXT4','Meilleures salutations,');
define('EMAIL_ORDERS_STATUS_TEXT5','Équipe de Service de FiberStore');

/************************************** sales manager to customer *********************************************/
define('EMAIL_SALES_MANAGER_SUBJECT','L’administrateur attribue un consultant d’achat pour vous - FS.COM');
define('EMAIL_SALES_MANAGER_TEXT1','Bonne journée !<br><br>Merci pour rejoindre Fiberstore. ');
define('EMAIL_SALES_MANAGER_TEXT2','Je suis');
define('EMAIL_SALES_MANAGER_TEXT3','votre représentant des ventes. ');
define('EMAIL_SALES_MANAGER_TEXT4','Si vous avez des besoins ou des questions sur nos produits ou d\'autres informations concernant Fiberstore, n\'hésitez pas à me contacter. C\'est un plaisir pour moi de vous servir.<br><br><br>
			<span style="font-family:Calibri;font-size:13px;">Voici mes coordonnées :</span>');
define('EMAIL_SALES_MANAGER_TEL','Tél :');
define('EMAIL_SALES_MANAGER_MOBILE','Tél portable :');
define('EMAIL_SALES_MANAGER_EMAIL','E-mail :');
define('EMAIL_SALES_MANAGER_TEXT5','(12 / 7 Ventes &amp; Support)');
define('EMAIL_SALES_MANAGER_TEXT6','<span style="font-family:Calibri;font-size:13px;">Room 301, Third Floor, Weiyong Building, No. 10, Kefa Road, Nanshan District, Shenzhen, 518057, CHINA</span>');
define('EMAIL_SALES_MANAGER_TEXT7','Avec l’expression de mes salutations distinguées');

/************************************ backend common *********************************************/
//update orders status 
define('EMAIL_BACKEND_COMMON_PAYMENT_RECEIVED','Paiement Reçu');
define('EMAIL_BACKEND_COMMON_YOUR_ORDER','Votre Commande :');
define('EMAIL_BACKEND_COMMON_TEXT1','le statut a été mis à jour :');
define('EMAIL_BACKEND_COMMON_TRACK_INFORMATION','Informations de Suivi :');
define('EMAIL_BACKEND_COMMON_PROCESSING','En traitement');
define('EMAIL_BACKEND_COMMON_TRACKING_INFO','Informations de Suivi :');
define('EMAIL_BACKEND_COMMON_TEXT2','Tous les produits de votre commande ont été expédiés, il prendra 3-4 jours pour arriver à votre adresse, et vous pourriez obtenir les informations de suivi dans votre compte sur FiberStore.');
define('EMAIL_BACKEND_COMMON_SHIPPING_METHOD','Méthode d’Expédition :');
define('EMAIL_BACKEND_COMMON_TACKINF_NUMBER','Numéro de Suivi :');
define('EMAIL_BACKEND_COMMON_TEXT3','a été expédiée.');
define('EMAIL_BACKEND_COMMON_REFUNDED','Remboursée');
define('EMAIL_BACKEND_COMMON_IS_CANCELED','est annulée');
define('EMAIL_BACKEND_COMMON_CANCELED','Annulée');
define('EMAIL_BACKEND_COMMON_COMPLETED','Terminée');
define('EMAIL_BACKEND_COMMON_NO_INFO','pas d\'information');
define('EMAIL_BACKEND_COMMON_TEXT4','Conseils : Pour plus de détails, s\'il vous plaît vous connecter à votre compte sur fiberstore.');
//reviews to customer
define('EMAIL_BACKEND_COMMON_REVIEWS_REPLY_SUBJECT','Nouvelle Réponse de commentaire de Fiberstore.');
define('EMAIL_BACKEND_COMMON_YOUR_REVIEW','Votre commentaire :');
define('EMAIL_BACKEND_COMMON_PRODUCTS_NAME_URL','Nom de Produits | Url de Commentaire :');
define('EMAIL_BACKEND_COMMON_REPLY_BY','Réponse par :');
define('EMAIL_BACKEND_COMMON_REPLY_CONTENT','Contenu de Réponse :');

/*********************************** business account success to customer *************************************************/
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_SUBJECT','Votre Demande de Compte d’Entreprise a été acceptée.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT1','Félicitations, votre demande de compte d\'entreprise a été acceptée.');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT2','Avec le compte d’entreprise, vous pouvez profiter des services suivants maintenant :');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT3','1. Réduction de $PER<br>
        2. Meilleure méthode d\'expédition<br>
        3. Représentant de vente professionnel<br>
		4. Support technique<br>
        <br><br>Meilleures salutations<br><br>
        Fiberstore Co., Limited');

/************************    customer question to customer     *********************/
define('EMAIL_CUSTOMER_QUESTION_TC_SUBJECT','Vos Questions ont été répondues par FiberStore');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT1','Merci pour vos questions.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT2','Nous allons faire de notre mieux pour vous proposer des solutions complètes.');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT3','Cordialement');

//西雅图发货延迟通知邮件 2017.8.2  ery
define('EMAIL_BODY_COMMON_TAX_NUMBER','Numéro de TVA ');
define('ORDER_DELAY_TITLE','Nous Faisons l\'Inventaire des Stocks des Produits pour Votre Commande Urgente# || FS.COM');
define('ORDER_DELAY_EMAIL_WE',"Nous sommes très heureux d'avoir reçu % de votre commande à FS.COM.");
define('ORDER_DELAY_EMAIL_THIS',"Ce mail consiste à vous tenir au courant l'arrivée de %s de votre commande dans notre entrepôt. Notre département de contrôle de qualité a besoin de temps pour sélectionner et tester les articles, d'où vient possiblement un retard pour l'expédition urgente.");
define('ORDER_DELAY_EMAIL_PLEASE',"Nous vous remercions de votre patience. Nous allons arranger l'expédition au plus vite et vous tenir au courant les dernières  informations. Nous nous excusons sincèrement des inconvénients.");
define('ORDER_DELAY_EMAIL_THANKS','Merci pour votre compréhension.');

// add by Aron
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT1','confirmé % pour la commande# de Fiberstore ');
define('EMAIL_CHECKOUT_COMMON_TO_PURCHASE_CUSTOMER_SUBJECT','% de Commande# de Fiberstore ');
/************************************* checkout purchase ****************************************/
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT3","<p style='color:rgb(51,51,51);margin:0;padding:0;'> Merci encore une fois pour votre commande ! </p>");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT4","<p style='color:rgb(51,51,51);margin:0;padding:0;'> Service Clientèle chez FS.COM </p>");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START1","Merci pour votre document de commande, vous pouvez le réviser dans la partie  <a href='".zen_href_link('manage_orders')."'  target='_blank'>'Mes Commandes'</a>.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START2","Votre commande sera bientôt traitée, nous vous informerons le numéro de suivi dès l'expédition des produits.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START3","Pour toute question, n'hésitez pas à <a href='".zen_href_link('contact_us')."'  target='_blank'>nous contacter</a>.");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START4","Merci beaucoup !");
define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START_NO","N° de Commande  ");

// fairy 异地登录邮件 add 2017.11.28
define('FS_OFFSITE_LOGIN_EAMIL_THEME','FS.COM - Notification de Nouvelle Activité de Compte');
define('FS_OFFSITE_LOGIN_EAMIL_TITLE','Nouvelle connexion sur EMAIL_USER_DEVICE');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT1','Votre compte de FS <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a> est connecté sur un nouvel appareil.');
define('FS_OFFSITE_LOGIN_EAMIL_LOCATION','Emplacement approximatif');
define('FS_OFFSITE_LOGIN_EAMIL_TIME','Moment');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT2','si vous ne reconnaissez pas cette activité ou si vous croyez qu\'une personne non autorisée a accédé à votre compte, veuillez réinitialiser votre mot de passe immédiatement.');
define('FS_OFFSITE_LOGIN_EAMIL_CONTENT3','Si vous avez d\'autres questions, n\'hésitez pas à <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');

// fairy 修改密码成功
define('FS_MODIFY_PWD_EAMIL_SUCCESS_THEME','FS.COM - Mot de passe du Compte modifié');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_TITLE','Votre mot de passe a été modifié.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT1','Le mot de passe de votre <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) a été modifié avec succès à <b>EMAIL_TIME</b>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT2','Vous pouvez maintenant utiliser vos nouvelles informations de sécurité pour vous connecter à votre compte. Si vous avez besoin d\'aide supplémentaire, veuillez <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT3','i vous n\'avez pas effectué cette modification ou si vous pensez qu\'une personne non autorisée a accédé à votre compte, veuillez <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">réinitialiser votre mot de passe</a> immédiatement.  Puis <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">connectez-vous</a> et mettez à jour vos paramètres de sécurité.');

// fairy 修改邮件成功
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_THEME','FS.COM - Adresse E-mail Modifiée');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_TITLE','Votre adresse e-mail a été modifiée.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT1','L\'adresse e-mail a été changée à <b>EMAIL_TIME</b>. Votre nouvelle adresse e-mail est <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT2','Vous pouvez maintenant utiliser votre nouvelle adresse pour vous connecter. Si vous avez besoin d\'aide, veuillez <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT3','Si vous n\'avez pas effectué cette modification ou si vous pensez qu\'une personne non autorisée a accédé à votre compte, veuillez <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">réinitialiser votre mot de passe</a> immédiatement.  Puis <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">connectez-vous</a> et mettez à jour vos paramètres de sécurité.');

// fairy 修改邮件给销售的
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_THEME','FS.COM - L\'Adresse E-mail de Votre Client a été Modifiée');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_TITLE','Votre client(CUSTOMER_NAME）a changé l\'adressee-mail.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT1','L\'adresse e-mail de votre client(CUSTOMER_NAME）a ​​été modifiée avec succès à <b>EMAIL_TIME</b>.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT2','L\'ancienne adresse e-mail est OLD_EMAIL.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT3','La nouvelle adresse e-mail est NEW_EMAIL.');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","Merci pour votre commande chez");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","Chat en Ligne");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH","avec un expert");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","Sincèrement,");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","Bonjour");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","Équipe de Service Clientèle ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","Adresse de Livraison : ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","Si vous avez des questions sur votre commande, n'hésitez pas à ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","Votre PO#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","a été téléchargé avec succès.");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","Merci de votre documents de PO, vous pouvez voir le PO et imprimer la facture via");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","Mes commandes");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","maintenant.");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","Frais de Port");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","Total");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","Sous-total");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","Votre commande sera traitée au plus vite, si vous avez des questions sur votre commande, n'hésitez pas à");
//checkout_payment_success
define('EMAIL_CHECKOUT_SUCCESS_YOUR','Votre paiement de commande est confirmé ici.');
define('EMAIL_CHECKOUT_SUCCESS_WE','Nous avons bien reçu votre paiement de la commande ');
define('EMAIL_CHECKOUT_SUCCESS_THANK',', merci pour votre grand soutien.');
//rma_success   售后单申请成功邮件
define('EMAIL_RMA_SUCCESS_APPROVED_YRR','Votre demande de RMA # %s a été approuvée.');
define('EMAIL_RMA_SUCCESS_APPROVED_YOUR','Votre demande de RMA # %s a été approuvée, veuillez suivre l\'organigramme en ligne et retourner le colis à l\'adresse indiquée.');
define('EMAIL_RMA_SUCCESS_APPROVED_WE','Nous allons traiter %s dès que nous recevons le colis. Pour une aide immédiate, n\'hésitez pas à  <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');
define('EMAIL_RMA_SUCCESS_SUBMIT_YOUR','Votre demande de RMA # %s est en cours de révision.');
define('EMAIL_RMA_SUCCESS_SUBMIT_WE','Nous avons reçu votre demande de RMA et nous allons la traiter au plus vite. Pour plus d\'informations sur le processus, votre représentante de vente va vous mettre à jour en temps opportun.');
define('EMAIL_RMA_SUCCESS_SUBMIT_FOR','Pour une aide immédiate, n\'hésitez pas à <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">nous contacter</a>.');
define('EMAIL_RMA_SUCCESS_TITLE','FS.COM - Demande de RMA # %s');

// fairy 申请报价之后的邮件
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_THEME','FS.COM - Demande de Devis INQUIRY_NUMBER');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE','Nous avons reçu votre demande de devis INQUIRY_NUMBER.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE_SALE','Vous avez une nouvelle demande de devis INQUIRY_NUMBER.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT1','Veuillez trouver ci-dessous les détails de votre demande de devis. Une de nos représentantes de vente vous contactera dès que possible avec les informations que vous avez demandées.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT2','Détails de Demande');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT3','Si vous êtes un membre enregistré, vous pouvez suivre et consulter les détails de devis via <a href="'.zen_href_link('inquiry_list').'" style="color: #0070BC;">centre de compte</a>.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT4','Merci de soumettre une demande de devis. Une de nos représentante de vente vous contactera dès que possible avec les informations que vous avez demandées.');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_RQ_NUMBER','Numéro RQ');

//fairy 个人中心用户添加评论，给对应销售发的邮件
define('FS_PRODUCT_REVIEW_SUCCESS_SALE_EMAIL_THEME','Nouveau commentaire du client sur le produit de FS.');
define('FS_CUSTOMER_REVIEWS', 'Commentaires du Client');
define('FS_REVIEWS_URL', 'Nom du Produit|Lien de Commentaire');
define('FS_REVIEW_RATING', 'Évaluation de Commentaire');
define('FS_REVIEW_CONTENT', 'Contenu de Commentaire');

//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"Partager Votre Expérience d'Utilisation #");
define('EMAIL_COMMON_FOOTER_NEW_02',"Vous êtes abonné à cet e-mail en tant que ");
define('EMAIL_COMMON_FOOTER_NEW_03',"Cliquez ici pour modifier vos préférences ou vous désabonner.");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS.COM Inc, 380 Centerpoint Blvd, New Castle, DE 19720");
define('EMAIL_COMMON_FOOTER_NEW_05',"Contactez-Nous");
define('EMAIL_COMMON_FOOTER_NEW_06',"Mon Compte");
define('EMAIL_COMMON_FOOTER_NEW_07',"Expédition &amp; Livraison");
define('EMAIL_COMMON_FOOTER_NEW_08',"Politique de Retour");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"Vous avez changé votre mot de passe avec succès. Votre nouveau mot de passe est prêt sur tous nos sites.");
define('RESET_PASS_SUCCESS_02','Connectez-Vous à Votre Compte');
define('RESET_PASS_SUCCESS_03',"Si vous n'avez pas demandé de changer votre mot de passe, répondez à cet e-mail ou appelez-nous au +1 (888) 468 7419.");
define('RESET_PASS_SUCCESS_04','Merci <br>à L\'Équipe FS');
define('RESET_PASS_SUCCESS_05','Cher/Chère');
define('RESET_PASS_SUCCESS_TITLE','Mettre à Jour Le Mot de Passe');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"Nous avons récemment reçu une demande de réinitialisation du mot de passe de votre compte. Cliquez simplement ci-dessous et nous vous aiderons rapidement et facilement à revenir à la normale.");
define('RESET_PASS_SEND_02',"Réinitialiser Votre Mot de Passe");
define('RESET_PASS_SEND_03',"Veuillez remarquer : Ce lien ne peut être utilisé qu'une seule fois et deviendra inactif en 24 heures. Si vous n'avez pas besoin de réinitialiser votre mot de passe, veuillez ignorer cet e-mail.");
define('RESET_PASS_SEND_04',"Cordialement <br>Équipe de FS");
define('RESET_PASS_SEND_05',"Cher/Chère");
define('RESET_PASS_SEND_06',"Pas de mot de passe ? ne vous inquiétez pas , nous vous aiderons à le réinitialiser.");
define('RESET_PASS_SEND_TITLE','Réinitialiser le Mot de Passe');

//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"Votre adresse e-mail a été changée en ");
define('RESET_EMAIL_SUCCESS_02','Cher/Chère');
define('RESET_EMAIL_SUCCESS_03','Utiliser cette adresse pour accéder à votre ');
define('RESET_EMAIL_SUCCESS_04',"Mon Compte");
define('RESET_EMAIL_SUCCESS_05'," détails.");
define('RESET_EMAIL_SUCCESS_06',"Si vous n'avez pas demandé de changer vos informations, veuillez visiter ");
define('RESET_EMAIL_SUCCESS_07',"Cordialement <br>Équipe de FS");
define('RESET_EMAIL_SUCCESS_TITLE','Metter à Jour L\'Adresse E-mail');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"Votre compte a été créé avec succès. Maintenant, vous pouvez vous connecter avec votre e-mail et mot de passe.");
define('REGIST_EMAIL_SEND_02',"Cher/Chère");
define('REGIST_EMAIL_SEND_03',"Votre compte a été créé avec succès. Maintenant vous pouvez ");
define('REGIST_EMAIL_SEND_04',"se connecter");
define('REGIST_EMAIL_SEND_05'," avec votre e-mail et mot de passe.");
define('REGIST_EMAIL_SEND_06',"Une fois connecté, vous pouvez : ");
define('REGIST_EMAIL_SEND_07',"Gérer votre ");
define('REGIST_EMAIL_SEND_08',"compte FS");
define('REGIST_EMAIL_SEND_09'," et demander un accès facile aux services FS.");
define('REGIST_EMAIL_SEND_10',"Envoyer ");
define('REGIST_EMAIL_SEND_11',"demander un support technique");
define('REGIST_EMAIL_SEND_12'," et obtenir une réponse gratuite et rapide.");
define('REGIST_EMAIL_SEND_13',"Faire un achat en ligne et suivre le statut de la commande à tout moment.");
define('REGIST_EMAIL_SEND_14',"Cordialement <br>Équipe de FS");
define('REGIST_EMAIL_SEND_15',"Votre compte a été créé avec succès, le numéro de compte est ");
define('REGIST_EMAIL_SEND_16',". Maintenant, vous pouvez ");
define('REGIST_EMAIL_SEND_TITLE','Le Compte a été Créé');

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
define('REGIST_COM_EMAIL_SEND_11','Envoyer ');
define('REGIST_COM_EMAIL_SEND_12','demander un support technique');
define('REGIST_COM_EMAIL_SEND_13',' et obtenir une réponse gratuite et rapide.');
define('REGIST_COM_EMAIL_SEND_14','Faire un achat en ligne et suivre le statut de la commande à tout moment.');
define('REGIST_COM_EMAIL_SEND_15','Merci <br>à L\'Équipe FS');
define('REGIST_COM_EMAIL_SEND_TITLE','La Demande a été Reçue');

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','Nous avons reçu votre demande de compte professionnel. Il est actuellement en cours de révision et ce processus peut prendre 1 - 3 jours ouvrables.');
define('REGIST_COM_EMAIL_UPGRADE_02','Cher/Chère');
define('REGIST_COM_EMAIL_UPGRADE_03','Nous avons reçu votre demande de mise à jour de votre compte. Il est actuellement en cours de révision et ce processus peut prendre 1 - 3 jours ouvrables. Lorsqu\'une décision a été prise, vous serez informé par un e-mail de FS en temps opportun.');
define('REGIST_COM_EMAIL_UPGRADE_04','Merci <br>à L\'Équipe FS');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','La Demande a été Reçue');
