<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

define('NAVBAR_TITLE', 'Ingresa Time Out');
define('HEADING_TITLE', '¡Vaya! Su sesión ha caducado.');
define('HEADING_TITLE_LOGGED_IN', '¡Vaya! Lo sentimos, pero no están autorizados a realizar la acción solicitada. ');
define('TEXT_INFORMATION', '<p>Si intenta hacer un pedido, por favor ingrese y su carrito de compras será restaurado. A continuación, puede volver a la caja y completar sus compras finales.</p><p>Si usted ha completado un pedido y desea revisarlo' . (DOWNLOAD_ENABLED == 'true' ? ', o tiene una descarga y desea recuperarla' : '') . ',por favor vaya a su <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mi cuenta</a> página para ver su pedido.</p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Usted todavía está conectado a su cuenta y podrá seguir comprando. Elija un destino desde un menú.');

define('HEADING_RETURNING_CUSTOMER', 'Login');
define('TEXT_PASSWORD_FORGOTTEN', 'Olvidó su contraseña?')
?>