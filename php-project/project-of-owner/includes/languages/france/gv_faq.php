<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: gv_faq.php 4155 2006-08-16 17:14:52Z ajeh $
//

define('NAVBAR_TITLE', TEXT_GV_NAME . ' FAQ');
define('HEADING_TITLE', TEXT_GV_NAME . ' FAQ');

define('TEXT_INFORMATION', '<a name="Top"></a>
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=1','NONSSL').'">Achat ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=2','NONSSL').'">Comment envoyer ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=3','NONSSL').'">Acheter avec ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=4','NONSSL').'">Racheter ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=5','NONSSL').'">Lorsque des problèmes surviennent</a><br />
');
switch ($_GET['faq_item']) {
  case '1':
define('SUB_HEADING_TITLE','Achats ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT', TEXT_GV_NAMES . ' sont achetés comme tout autre article dans notre magasin. Vous pouvez
  payer pour eux en utilisant les méthodes de paiement standard de magasin.
  Une fois acheté, la valeur de ' . TEXT_GV_NAME . ' sera ajouté à votre propre
   ' . TEXT_GV_NAME . ' Compte. Si vous avez des fonds dans votre ' . TEXT_GV_NAME . ' Compte, Vous
  remarquez que le montant montre dans le panier, et il fournit aussi un
  lien vers une page où vous pouvez envoyer le ' . TEXT_GV_NAME . ' à quelqu\'un par email.');
  break;
  case '2':
define('SUB_HEADING_TITLE','Comment envoyer ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT','Pour envoyer le ' . TEXT_GV_NAME . ' vous devez aller à notre ' . TEXT_GV_NAME . ' Page de Livraison. Vous pouvez
  trouver le lien vers cette page dans votre panier dans la colonne de droite de chaque page.
  Quand vous envoyez un ' . TEXT_GV_NAME . ', vous devez spécifier les éléments suivants.
  Le nom de la personne que vous envoyez le ' . TEXT_GV_NAME . ' à.
  L\'adresse email de la personne que vous envoyez le ' . TEXT_GV_NAME . ' à.
  Le montant que vous voulez envoyer. (Notez que vous ne devez pas envoyer le montant total
  dans votre ' . TEXT_GV_NAME . ' Compte.)
  Un court message qui apparaîtra dans l\'email.
  Assurez-vous que vous avez correctement saisi toutes les informations, s\'il vous plaît, bien que
  vous auriez la possibilité de changer cela comme vous voulez avant
  que l\'email est envoyé.');
  break;
  case '3':
  define('SUB_HEADING_TITLE','Acheter avec ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','Si vous avez des fonds dans votre ' . TEXT_GV_NAME . ' Compte, vous pouvez utilisez ces fonds pour
  acheter d\'autres articles dans notre magasin. À l\'étape de paiement, une boîte supplémentaire
  apparaîtra. Entrez le montant à s\'appliquer des fonds dans votre ' . TEXT_GV_NAME . ' Compte.
  Notez que vous aurez encore à choisir une autre méthode de paiement s\'il
  n\'y a pas assez dans votre ' . TEXT_GV_NAME . ' Compte pour payer le coût de votre achat.
  Si vous avez plus de fonds dans votre ' . TEXT_GV_NAME . ' Compte que le coût total de 
  votre commande, le solde sera laissé dans votre ' . TEXT_GV_NAME . ' Compte pour
  l\'avenir.');
  break;
  case '4':
  define('SUB_HEADING_TITLE','Racheter ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','Si vous recevez un ' . TEXT_GV_NAME . ' par email contient des détails sur qui vous a envoyé
  a envoyé envoyé ' . TEXT_GV_NAME . ', avec une court message de sa part. L\'email
  contiendra également le ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . '. Il est probablement une bonne idée d\'imprimer
  cet e-mail pour la référence future. Vous pouvez maintenant racheter le' . TEXT_GV_NAME . ' dans
  deux façons.<br /><br />
  1. En cliquant sur le lien contenu dans l\'e-mail pour ce but explicite.
  Cela vous mènera à la page d\'échange de  ' . TEXT_GV_NAME . ' boutique. Vous serez alors invité
  à créer un compte, avant le ' . TEXT_GV_NAME . ' est validé et placé dans votre 
   ' . TEXT_GV_NAME . ' Compte prête pour acheter ce que vous voulez.<br /><br />
  2. Pendant le processus de paiement, vous sélectionnez une méthode de paiement sur la même page
il y aura une boîte pour entrer un' . TEXT_GV_REDEEM . '. Entrez le ' . TEXT_GV_REDEEM . ' ici, et
cliquez sur le bouton d\'Échange. Le code sera
validé et ajouté à votre ' . TEXT_GV_NAME . ' Compte. Vous pouvez alors utiliser le montant pour acheter dans notre boutique');
  break;
  case '5':
  define('SUB_HEADING_TITLE','Lorsque des problèmes surviennent.');
  define('SUB_HEADING_TEXT','Pour toute demande sur le' . TEXT_GV_NAME . ' Système, contactez la boutique
  par e-mail sur '. STORE_OWNER_EMAIL_ADDRESS . '. Assurez-vous de donner
  autant d\'informations que possible dans le courriel, s\'il vous plaît. ');
  break;
  default:
  define('SUB_HEADING_TITLE','');
  define('SUB_HEADING_TEXT','Choisissez parmi des questions ci-dessus, s\'il vous plaît.');

  }

  define('TEXT_GV_REDEEM_INFO', 'Entrez votre ' . TEXT_GV_NAME . ' code de rachat: ');
  define('TEXT_GV_REDEEM_ID', 'Code de Rachat:');
?>