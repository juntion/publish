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
// $Id: download_time_out.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('NAVBAR_TITLE', 'Ihr Herunterladen ...');
define('HEADING_TITLE', 'Ihr Herunterladen ...');

define('TEXT_INFORMATION', 'Es tut uns leid, aber Ihr Herunterladen ist abgelaufen.<br /><br />
  Wenn Sie etwas Anderes heruntergeladen haben, und sie zurückholen möchten, 
  bitte gehen Sie zur Seite von <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mein Konto</a> um Ihren Auftrag anzuschauen.<br /><br />
  Oder wenn es ein Problem Ihrer Meinung nach mit Ihrer Bestellung gibt, bitte klicken Sie auf<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">Kontakt</a> <br /><br />
  Vielen Dank!
  ');
?>