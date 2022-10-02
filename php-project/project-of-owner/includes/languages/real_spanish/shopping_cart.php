<?php //Spanish Language Pack for Zen Cart 1.5: http://zencartspanish.svn.sourceforge.net/viewvc/zencartspanish/
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: shopping_cart.php 3183 2006-03-14 07:58:59Z birdbrain $
 */

define('NAVBAR_TITLE', 'Carro de Compra');
define('HEADING_TITLE', 'Su carro de compra contiene:');
define('HEADING_TITLE_EMPTY', 'Su carro de compra');
define('TEXT_INFORMATION', '');
define('TABLE_HEADING_REMOVE', 'Quitar');
define('TABLE_HEADING_QUANTITY', 'Cant.');
define('TABLE_HEADING_MODEL', 'Modelo');
define('TABLE_HEADING_PRICE', 'Precio');
define('TEXT_CART_EMPTY', 'Su carro de compra está vacía.');
define('SUB_TITLE_SUB_TOTAL', 'Subtotal:');
define('SUB_TITLE_TOTAL', 'Total:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Los productos marcados con ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' están agotados o no hay en suficiente cantidad para atender su pedido.<br />Por favor, modifique la cantidad de productos marcados con (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '). Gracias');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Los productos marcados con ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' están agotados.<br />Dichos artículos serán puestos en un pedido de espera.');

define('TEXT_TOTAL_ITEMS', 'Total de Artículos: ');
define('TEXT_TOTAL_WEIGHT', '&nbsp;&nbsp;Peso: ');
define('TEXT_TOTAL_AMOUNT', '&nbsp;&nbsp;Cantidad: ');

define('TEXT_VISITORS_CART', '<a href="javascript:session_win();">[Ayuda (?)]</a>');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
?>