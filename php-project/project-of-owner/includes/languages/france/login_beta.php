<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: login.php 14280 2009-08-29 01:33:18Z drbyte $
 */

define('NAVBAR_TITLE', 'Connectez-vous');
define('HEADING_TITLE', 'Bienvenue, connectez-vous, s\'il vous plaît');

define('HEADING_NEW_CUSTOMER', 'Nouveau? Founissez vos informations de facturation, s\'il vous plaît');
define('HEADING_NEW_CUSTOMER_SPLIT', 'Nouveaux Clients');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Créer un profil de client avec <strong>' . STORE_NAME . '</strong> qui vous permet de faire des courses plus vite, de suivre l\'état de vos commandes ou de consulter vos commandes précédentes.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'Avoir un compte de PayPal? Voulez-vous payer rapidement avec une carte de crédit? Utilisez le bouton PayPal ci-dessous pour utiliser l\'option de Checkout Express');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">Or</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'Créer un profil de client avec <strong>' . STORE_NAME . '</strong> qui vous permet de faire des courses plus vite, de suivre l\'état de vos commandes ou de consulter vos commandes précédentes, et de profiter des avantages de nos autres membres.');

define('HEADING_RETURNING_CUSTOMER', 'Clients de Retour: Connectez-vous, s\'il vous plaît');
define('HEADING_RETURNING_CUSTOMER_SPLIT', 'Clients de Retour');

define('TEXT_RETURNING_CUSTOMER_SPLIT', 'Afin de continuer, connectez-vous à votre <strong>' . STORE_NAME . '</strong> compte.');

define('TEXT_PASSWORD_FORGOTTEN', 'Oubliez vos mots de passe?');

define('TEXT_LOGIN_ERROR_NO_RECORD', 'Erreur: Désolé, il n\'y a aucune correspondance pour cette adresse e-mail! Si vous avez enregistré, vérifiez à nouveau, s\'il vous plaît! Sinon, vous pourriez un nouveau compte sur la droite!');define('TEXT_LOGIN_ERROR_PASSWORD_NOT_MATCH', 'Erreur: Désolé, votre mot de passe est incorrect, vérifiez à nouveau, s\'il vous plaît!');
define('TEXT_VISITORS_CART', '<strong>Note:</strong> Si vous avez acheté des produits avec nous avant et laissé quelque produits dans votre panier, les produits seront fusionnés si vous vous connectez pour votre commodité. <a href="javascript:session_win();">[More Info]</a>');

define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">Déclaration de Confidentialité</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">Reconnaissez-vous que vous êtes d\'accord avec notre déclaration de confidentialité en cochant la boîte ci-dessous. La déclaration de confidentialité peut être lue</span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">ici</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">J\'ai lu et accepté votre déclaration de confidentialité.</span>');

define('ERROR_SECURITY_ERROR', 'Il y avait une erreur de sécurité lorsque vous essayez de vous connecter.');

define('TEXT_LOGIN_BANNED', 'Erreur: Accès refusé.');




/************BOF LOGIN LANGUAGE****************/
define('TEXT_LOGIN_SUCCESS', 'bienvenidos a Fiberstore.com');

define('TEXT_LOGIN_FIVE','Fiberstore te llevará a la página principal automáticamente en 5 segundos');

define('TEXT_SUCCESS_MSG','O usted puede ir a las siguientes páginas de forma manual');

define('TEXT_SIGN_REGIST','Connectez-vous ou Créer un Compte');

define('TEXT_SIGN_FIBERSTORE','Connectez-vous à Fiberstore:');

define('TEXT_EMIAL','Email:');

define('TEXT_PASSWORD','Mot de passe:');

//define('TEXT_LOGIN_MSG','Assurez-vous que vous avez rempli votre email, s\'il vous plaît.');
define('TEXT_LOGIN_MSG','L\'e-mail que vous avez entré est invalide. Vérifiez votre e-mail et réessayez, s\'il vous plaît.');
define('TEXT_LOGIN_ENTER','Entrez une adresse email, s\'il vous plaît.');
//define('TEXT_PASSWORD_MSG','Votre mot de passe doit contenir un minimum de 7 caractères.');
define('TEXT_PASSWORD_MSG','Votre mot de passe doit contenir un minimum de 7 caractères.');
define('TEXT_PASSWORD_ENTER','Entrez vote mot de passe, s\'il vous plaît.');

define('TEXT_FORGET_PSD','Oubliez votre mot de passe?');

define('TEXT_LOGIN_PLACE','Passer la commande en ligne');

define('TEXT_LOGIN_TRACK','Suivre vos commandes en ligne');

define('TEXT_LOGIN_VIEW','Voir votre histoire de commande');

define('TEXT_LOGIN_CREATE','Créer des favoris, des listes d\'envie, et plus!');

define('TEXT_LOGIN_MAKE','Faire le budget du projet en utilisant des listes d\'envie');

define('TEXT_LOGIN_TECHNICAL','Support d\'Équipe Technique');

define('TEXT_LOGIN_HELP','Besoin d\'aide?');

define('TEXT_LOGIN_HELP_WITH','Besoin d\'aide avec');

define('TEXT_LOGIN_RETURNING','Retourner un article');

define('TEXT_LOGIN_VIEW_THE','Voir le');

define('TEXT_LOGIN_RMA','RMA Solution');

define('TEXT_LOGIN_PAGE','page ou Écrivez-nous à');

define('TEXT_LOGIN_EMAIL','service@fiberstore.com');

define('TEXT_LOGIN_CONTACT','Contactez nous');

define('TEXT_VIEW_FAQ','Voir la page de FAQs');

define('TEXT_LOGIN_QUESTIONS','Vous avez des questions concernant l\'expédition et la livraison?');

define('TEXT_LOGIN_SHOP','ACHETER EN TOUTE CONFIANCE');

define('TEXT_SHOPPING_ON','SHOPPING SUR FIBERSTORE.COM');

define('TEXT_IS_SAFE','EST SÛR ET SÉCURISÉ.');

define('TEXT_LOGIN_GUARANTEED','GARANTIE!');

define('TEXT_LOGIN_FIBERSTORE','Vous payerez rien si des frais non autorisés sont effectués avec votre carte de crédit à la suite de courses sur fiberstore.com.');

define('TEXT_LOGIN_SAFE','Garantie des achats sécurisés');

define('TEXT_LOGIN_INFORMATION','Toutes les informations sont cryptées et transmises sans risque en utilisant un protocole Secure Sockets Layer (SSL).');

define('TEXT_LOGIN_PROTECT','Comment nous protégeons vos données personnelles?');

define('TEXT_LOGIN_FREE','LIVRAISON GRATUITE ET RETOURS GRATUITS');

define('TEXT_LOGIN_UNSA','Si vous n\'êtes pas satisfait de votre achat sur FiberStore Co., Ltd, vous pouvez le retourner dans son état original dans les 7 jours pour un remboursement. Nous allons même payer pour l\'expédition de retour!');

define('TEXT_LOGIN_DELIVER','Pour offrir un fonctionnement sans souci et d’éliminer les coûts associés à des réparations hors garantie, FiberStore offre une garantie à vie comme une caractéristique standard sur tous les principales lignes de produits.');

define('TEXT_LOGIN_MORE','Apprendre Plus');

define('TEXT_LOGIN_OR','Ou');

define('TEXT_LOGIN_CASE','les mots de passe sont sensibles aux majuscules');







define('ACCOUNT_FOOTER_TITLE','ACHETER EN TOUTE CONFIANCE');

define('ACCOUNT_FOOTER_SHOPPING','SHOPPING SUR FIBERSTORE.COM ');

define('ACCOUNT_FOOTER_SECURE','EST SÛR ET SÉCURISÉ.');

define('ACCOUNT_FOOTER_PAY','Vous payerez rien si des frais non autorisés sont effectués avec votre carte de crédit à la suite de courses sur fiberstore.com.');

define('ACCOUNT_FOOTER_SAFE','Garantie des achats sécurisés');

define('ACCOUNT_FOOTER_INFORMATION','Toutes les informations sont cryptées et transmises sans risque en utilisant un protocole Secure Sockets Layer (SSL).');

define('ACCOUNT_FOOTER_HOW','Comment nous protégeons vos données personnelles?');

define('ACCOUNT_FOOTER_FREE','LIVRAISON GRATUITE ET RETOURS GRATUITS');

define('ACCOUNT_FOOTER_SHOP','Si vous n\'êtes pas satisfait de votre achat sur FiberStore Co., Ltd, vous pouvez le retourner dans son état original dans les 7 jours pour un remboursement. Nous allons même payer pour l\'expédition de retour!');

define('ACCOUNT_FOOTER_DELIVER','Pour offrir un fonctionnement sans souci et d’éliminer les coûts associés à des réparations hors garantie, FiberStore offre une garantie à vie comme une caractéristique standard sur tous les principales lignes de produits.');

define('ACCOUNT_FOOTER_LEARN','Apprendre Plus ?');

/***********EOF LOGIN LANGUAGUE***************/























































