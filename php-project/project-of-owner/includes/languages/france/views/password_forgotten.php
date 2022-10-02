<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Connecter');
define('NAVBAR_TITLE_2', 'Mot de passe oublié');

define('HEADING_TITLE', 'Mot de passe oublié');

define('TEXT_MAIN', 'Entrez votre adresse e-mail ci-dessous et nous vous enverrons un email contenant votre nouveau mot de passe.');

define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Erreur : L\'adresse e-mail n\'a pas été trouvée dans notre base de données ; Veuillez réessayer.');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Nouveau Mot de Passe');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Le mot de passe est demandé' . $_SERVER['REMOTE_ADDR']  . '.' . "\n\n" . ' Votre nouveau mot de passe dans \'' . STORE_NAME . '\' est:' . "\n\n" . '   %s' . "\n\nAprès vous être connecté en utilisant le nouveau mot de passe, vous pouvez le modifier en accédant à la zone 'Mon Compte' .");

define('SUCCESS_PASSWORD_SENT', 'Un nouveau mot de passe a été envoyé à votre adresse e-mail.');

define('FS_PASSWORD_SUBMIT','Soumettez');



/**********BOF PASSWORD_FORGOTTEN LANGUAGE************/
define('FIBERSTORE_NEW_PWD','Nouveau mot de passe de FiberStore');

define('FIBERSTORE_FORGOTTEN_RESET', 'Réinitialiser Votre Mot de Passe');

define('FIBERSTORE_FORGOTTEN_EMAIL', '*Adresse e-mail:');

define('FIBERSTORE_FORGOTTEN_SEND', 'Entrez votre adresse email ci-dessous et nous vous enverrons un email contenant votre nouveau mot de passe.');

define('FIBERSTORE_FORGOTTEN_RETURN', 'Retourner à la page de Connexion');

define('FIBERSTORE_FORGOTTEN_OR', 'OU');

define('FIBERSTORE_FORGOTTEN_PLACE', 'Passer une commande en ligne');

define('FIBERSTORE_FORGOTTEN_TRACK', 'Suivre vos commandes en ligne');

define('FIBERSTORE_FORGOTTEN_VIEW', 'Consulter votre historique de commandes');

define('FIBERSTORE_FORGOTTEN_CREATE', 'Créer vos listes de favoris, listes de souhaits, et plus !');

define('FIBERSTORE_FORGOTTEN_MAKE', 'Faire votre budget du projet en utilisant vos listes de souhaits');

define('FIBERSTORE_FORGOTTEN_SUPPORT', 'Bénéficier de notre Équipe de support technique');

define('FIBERSTORE_FORGOTTEN_HELP', 'Avoir besoin d\'aide ?');

define('TEXT_LOGIN_GUARANTEED','GARANTI !');

define('TEXT_LOGIN_HELP','Avoir besoin d\'aide ?');

define('TEXT_LOGIN_OR','Ou');

define('FIBERSTORE_PWD_OF','Votre Nouveau Mot de passe de FiberStore');

define('FIBERSTORE_A_NEWPWD','Le nouveau mot de passe de votre compte de FiberStore.com.');
define('FIBERSTORE_PWD_IS','Votre nouveau mot de passe est : ');
define('FIBERSTORE_LOGGED_RECOMMEND','Après vous être connecté en utilisant le nouveau mot de passe, nous vous recommandons d\'aller à Mon Compte et de consulter vos paramètres de compte pour le changer.');
define('FIBERSTORE_FORGET_SINCERELY','Sincèrement,');
define('FIBERSTORE_THANKS_AGAIN','Merci encore une fois de nous avoir choisis.');
define('FIBERSTORE_FORGET_NOTE','Veuillez noter :');
define('FIBERSTORE_SEND_EMAIL','Ce message de courriel a été envoyé à partir d\'une adresse de notification qui ne peut pas recevoir le courrier.');
define('FIBERSTORE_NOT_REPLY','NE REPONDEZ PAS SVP');
define('FIBERSTORE_CONTACT_US','à ce message. Si vous avez des questions, veuillez nous contacter.');
/**********EOF****************************************/






/*********************************/


define('TEXT_LOGIN_HELP_WITH','Besoin d\'Aide avec');

define('TEXT_LOGIN_RETURNING','Retourner un article');

define('TEXT_LOGIN_VIEW_THE','Voir');

define('TEXT_LOGIN_RMA','Solution RMA ');

define('TEXT_LOGIN_PAGE','Envoyez-nous un e-mail à l\'adresse suivante');

define('TEXT_LOGIN_EMAIL','service@fiberstore.com');

define('TEXT_LOGIN_CONTACT','Contactez-nous');

define('TEXT_VIEW_FAQ','Consulter la page FAQ');

define('TEXT_LOGIN_QUESTIONS','Avez-vous des questions sur les achats et la livraison des produits ?');

define('ACCOUNT_FOOTER_TITLE','VOS ACHATS EN TOUTE CONFIANCE');

define('ACCOUNT_FOOTER_SHOPPING','ACHATS SUR FIBERSTORE.COM ');

define('ACCOUNT_FOOTER_SECURE','EN SECURITÉ.');

define('ACCOUNT_FOOTER_PAY','Vous ne payez rien si un montant non-autorisé est débité de votre carte bancaire dans le cadre d\'un achat sur WWW.FIBERSTORE.COM.');

define('ACCOUNT_FOOTER_SAFE','ACHATS GARANTIS EN TOUTE SECURITÉ');

define('ACCOUNT_FOOTER_INFORMATION','Toutes les informations sont cryptées et transmises sans risque en utilisant le protocole SSL.');

define('ACCOUNT_FOOTER_HOW','Comment Nous Protégeons Vos Renseignements Personnels ?');

define('ACCOUNT_FOOTER_FREE','LIVRAISON GRATUITE ET RETOUR GRATUIT');

define('ACCOUNT_FOOTER_SHOP','Si vous n\'êtes pas satisfait de votre achat de FiberStore Co., Ltd, vous pouvez le retourner dans son état original dans les 7 jours pour un remboursement. Nous prenons en charge les frais de retour !');

define('ACCOUNT_FOOTER_DELIVER','Pour offrir un fonctionnement sans souci et d\'éliminer les coûts associés à des réparations hors garantie, FiberStore offre une garantie à vie comme une caractéristique standard pour les principales lignes de produits.');

define('ACCOUNT_FOOTER_LEARN','En Savoir Plus ?');
/**********************************/



// reason block
define('FS_PS_FORGOTTEN_WHY','Pourquoi ne pouvez-vous pas vous connecter ?');
define('FS_PS_FORGOTTEN_REASON1','J\'ai oublié mon mot de passe');
define('FS_PS_FORGOTTEN_REASON2','Je connais mon mot de passe, mais je ne peux pas me connecter');
define('FS_PS_FORGOTTEN_REASON2_TIP','Conseil : Veuillez revérifier le compte auquel vous essayez de vous connecter. On fait parfois des erreurs lors de la saisie de l\'adresse e-mail. Assurez-vous également d\'utiliser le bon domaine pour votre compte, tel que hotmail.com, live.com ou outlook.com.');
define('FS_PS_FORGOTTEN_REASON3','Je pense que quelqu\'un non autorisé utilise mon compte de FS');
define('FS_PS_FORGOTTEN_REASON3_TIP','Facultatif : pourquoi pensez-vous que quelqu\'un non autorisé a accès à votre compte ?');
define('FS_PS_FORGOTTEN_REASON3_OPTION1','Sélectionner la raison');
define('FS_PS_FORGOTTEN_REASON3_OPTION2','Quelqu\'un non autorisé envoie un e-mail de mon compte');
define('FS_PS_FORGOTTEN_REASON3_OPTION3','Je vois des connexions inhabituelles sur ma page d\'activité récente');
define('FS_PS_FORGOTTEN_REASON3_OPTION4','Quelqu\'un m\'a dit que mon compte a été piraté');
define('FS_PS_FORGOTTEN_REASON3_OPTION5','Les commandes que je n\'ai pas autorisées apparaissent sur mon compte');
define('FS_PS_FORGOTTEN_REASON3_OPTION6','D\'autres (veuillez expliquer)');
define('FS_PS_FORGOTTEN_REASON3_TEXTAREA','Veuillez écrire les raisons');
define('FS_PS_FORGOTTEN_NEXT','Ensuite');

// tpl_password_forgotten_default.php
define('FS_PS_PROCESSING','En traitement...');
define('FS_PS_RESET_MY_PASSWORD','Réinitialiser Mon Mot de Passe');
define('FS_PS_BACK','Revenir');
define('FS_PS_ENTER_YOUR_EMAIL','Veuillez entrer l\'adresse e-mail de votre compte FS et nous vous enverrons un e-mail contenant un lien sécurisé pour réinitialiser votre mot de passe.');
define('FS_PS_EMAIL_ADDRESS','Adresse E-mail :');
define('FS_PS_PLEASE_ENTER_ACCOUNT_MAIL','Veuillez entrer votre adresse e-mail');
define('FS_PS_SUBMIT','Envoyer');
define('FS_PS_FORGOTTEN_ALSO','Vous pouvez également :');
define('FS_PS_FORGOTTEN_REGISTER','Créer un nouveau compte');
define('FS_PS_FORGOTTEN_CONTACT','Contactez-nous');

// error tip
define('FS_PS_FORGOTTEN_TIP_CHOOSE_REASON','Veuillez sélectionner les raisons.');
define('FS_PS_FORGOTTEN_TIP_NOT_FIND_EMAIL','Cet e-mail n\'est associé à aucun compte. Veuillez essayer un autre e-mail.');



?>