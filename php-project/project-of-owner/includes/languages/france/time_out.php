<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

// define('NAVBAR_TITLE', 'Login Time Out');
// define('HEADING_TITLE', 'Whoops! Your session has expired.');
// define('HEADING_TITLE_LOGGED_IN', 'Whoops! Sorry, but you are not allowed to perform the action requested. ');
// define('TEXT_INFORMATION', '<p>If you were placing an order, please login and your shopping cart will be restored. You may then go back to the checkout and complete your final purchases.</p><p>If you had completed an order and wish to review it' . (DOWNLOAD_ENABLED == 'true' ? ', or had a download and wish to retrieve it' : '') . ', please go to your <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">My Account</a> page to view your order.</p>');

// define('TEXT_INFORMATION_LOGGED_IN', 'You are still logged in to your account and may continue shopping. Please choose a destination from a menu.');

// define('HEADING_RETURNING_CUSTOMER', 'Login');
// define('TEXT_PASSWORD_FORGOTTEN', 'Forgot Your Password?')
define('NAVBAR_TITLE', 'Enter Time Out');
define('HEADING_TITLE', 'Allez! Votre session a expiré.');
define('HEADING_TITLE_LOGGED_IN', 'Allez! Désolé, nous ne sommes pas autorisés à effectuer l\'action demandée. ');
define('TEXT_INFORMATION', '<p>Si vous essayez de passer une commande, connectez-vous, s\'il vous plaît, et vore panier sera restauré. Vous pouvez ensuite revenir à la boîte et terminer vos derniers achats.</p><p>Si vous avez termivé une commande et vous voulez commenter' . (DOWNLOAD_ENABLED == 'true' ? ', ou a une décharge et vous voulez retourner' : '') . ',référez-vous à votre <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mon Compte</a> la page pour voir votre commande.</p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Vous êtes toujours connecté à votre compte et vous pouvez continuer votre shopping. Choisissez une destination à partir de menu.');

define('HEADING_RETURNING_CUSTOMER', 'Login');
define('TEXT_PASSWORD_FORGOTTEN', 'Oubliez le mot de passe?')
?>