<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_payment.php 4087 2006-08-07 04:46:08Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Payer - Étape 1');
define('NAVBAR_TITLE_2', 'Méthode de paiement - Étape 2');

define('HEADING_TITLE', 'Étape 2 de 3 - Information de paiement');

define('TABLE_HEADING_BILLING_ADDRESS', 'Adresse de Facturation');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Votre adresse de facturation est indiquée à gauche. L\'adresse de facturation doit correspondre à l\'adresse de votre carte de crédit. Vous pouvez changer l\'adresse de facturation en cliquant sur le <em>Changer l\'adresse</em> bouton.');
define('TITLE_BILLING_ADDRESS', 'Adresse de Facturation:');

define('TABLE_HEADING_PAYMENT_METHOD', 'Méthode de paiement');
define('TEXT_SELECT_PAYMENT_METHOD', 'Sélectionnez une méthode de paiement pour cette commande, s\'il vous plaît.');
define('TITLE_PLEASE_SELECT', 'Sélectionnez');
define('TEXT_ENTER_PAYMENT_INFORMATION', '');
define('TABLE_HEADING_COMMENTS', 'Instructions ou Commentaires spéciales de commande');

define('TITLE_NO_PAYMENT_OPTIONS_AVAILABLE', 'Pas disponible en ce moment');
define('TEXT_NO_PAYMENT_OPTIONS_AVAILABLE','<span class="alert">Désolé, nous ne pouvons pas accepter les paiements de votre région à cette époque.</span><br />Contactez-nous pour d\'autres arrangements, s\'il vous plaît.');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Passez à l\'étape 3</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- à confirmer votre commande.');

define('TABLE_HEADING_CONDITIONS', '<span class="termsconditions">Terms et Conditions</span>');
define('TEXT_CONDITIONS_DESCRIPTION', '<span class="termsdescription">Reconnaissez les termes et conditions liés à cette commande en cochant la case ci-dessous, s\'il vous plaît. Les termes et conditions peuvent être lues <a href="' . zen_href_link(FILENAME_CONDITIONS, '', 'SSL') . '"><span class="pseudolink">ici</span></a>.');
define('TEXT_CONDITIONS_CONFIRM', '<span class="termsiagree">J\'ai lu et accepté les termes et conditions liés à cette commande.</span>');

define('TEXT_CHECKOUT_AMOUNT_DUE', 'Montant Total: ');
define('TEXT_YOUR_TOTAL','Votre Total');
?>