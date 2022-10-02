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
// $Id: FEDEXIEzones.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE', 'FedEx Ground Rates');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_DESCRIPTION', 'FedEx Ground Rates');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY', 'Shipping to');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_UNITS', 'g');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_INVALID_ZONE', 'No shipping available to the selected Zone');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_UNDEFINED_RATE', 'The shipping rate cannot be determined at this time');

define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_1_1', 'Enable FedEx Ground Method');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_1_2', 'Do you want to offer FedEx Ground shipping?');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_2_1', 'Calculation Method');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_2_2', 'Calculate cost based on Weight, Price or Item?');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_3_1', 'Tax Class');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_3_2', 'Use the following tax class on the shipping fee.');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_4_1', 'Tax Basis');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_4_2', 'On what basis is Shipping Tax calculated. Options are<br />Shipping - Based on customers Shipping Address<br />Billing Based on customers Billing address<br />Store - Based on Store address if Billing/Shipping Zone equals Store Zone');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_5_1', 'Sort Order');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_5_2', 'Sort order of display.');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_6_1', 'Skip Zones, use a comma separated list of the two character ISO zone codes');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_6_2', 'Disable for the following Zones:');

define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_1', 'Zone');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_2', ' Zones');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_3', 'Comma separated list of two character ISO zone codes that are part of Zone ');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_4', '.<br />Set as 00 to indicate all two character ISO zone codes that are not specifically defined.');

define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_1', 'Zone');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_2', ' Shipping Table');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_3', 'Shipping rates to Zone');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_4', ' destinations based on a group of maximum order weights/prices. Example: 3:8.50,7:10.50,... Weight/Price less than or equal to 3 would cost 8.50 for Zone ');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_5', ' destinations.');

define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_9_1', 'Zone ');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_9_2', ' Handling Fee');
define('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_9_3', 'Handling Fee for this shipping zone');
?>
