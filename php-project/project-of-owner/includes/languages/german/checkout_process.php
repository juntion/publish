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
// $Id: checkout_process.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('EMAIL_TEXT_SUBJECT', 'Fiberstore Bestellung# %s ');
define('EMAIL_TEXT_HEADER', 'Bestellung bestätigen');
define('EMAIL_TEXT_FROM',' von');  //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING','Vielen Dank für den Einkauf bei uns heute!');
define('EMAIL_DETAILS_FOLLOW','Im folgenden sind die Details Ihrer Bestellung.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestellungsnummer:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailierte Rechnung:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Klicken Sie hier für eine detaillierte Rechnung');
define('EMAIL_TEXT_DATE_ORDERED', 'Bestellungsdatum:');
define('EMAIL_TEXT_PRODUCTS', 'Produkte');
define('EMAIL_TEXT_SUBTOTAL', 'Zwischensumme:');
define('EMAIL_TEXT_TAX', 'Steuer:        ');
define('EMAIL_TEXT_SHIPPING', 'Lieferung: ');
define('EMAIL_TEXT_TOTAL', 'Gesamtsumme:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Lieferadresse');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Rechnungsadresse');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Zahlungsmethode');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'durch');

// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' Nr: ');
define('HEADING_ADDRESS_INFORMATION','Adressinformation');
define('HEADING_SHIPPING_METHOD','Versandmethode');


define('COPY_RIGHT', 'Copyright &copy; 2009-'.date('Y',time()).' FiberStore Co., Ltd. Alle Rechte vorbehalten.');
define('FOOTER', '<tr>
        <td bgcolor="#E2E2E2"></td>
        <td bgcolor="#E2E2E2" height="160" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Firmeninfo</strong><br />
                <a href="http://www.fiberstore.com/contact_us.html" target="_blank" style=" color:#616265; text-decoration:none;">Kontakt</a><br />
                <a href="http://www.fiberstore.com/about_us.html" target="_blank" style=" color:#616265; text-decoration:none">Über uns</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=why_us" target="_blank" style=" color:#616265; text-decoration:none">Warum uns</a><br />
                <a href="http://www.fiberstore.com/privacy_policy.html" target="_blank" style=" color:#616265; text-decoration:none">Die Datenschutzrichtlinie</a><br />
                <a href="http://www.fiberstore.com/site_map.html" target="_blank" style=" color:#616265; text-decoration:none">Sitemap</a><br />
                <a href="http://www.fiberstore.com/blog/" target="_blank" style=" color:#616265; text-decoration:none">FiberStore Blog</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Kundenservice</strong><br />
                <a href="http://www.fiberstore.com/index.php?main_page=get_a_quick_quote" target="_blank" style=" color:#616265; text-decoration:none">Preise der Angebote schnell erfahren</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=custom_OEM" target="_blank" style=" color:#616265; text-decoration:none">Custom/OEM</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=payment_methods" target="_blank" style=" color:#616265; text-decoration:none">Zahlungsmethode</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=shipping_guide" target="_blank" style=" color:#616265; text-decoration:none">Versandhilfe</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=rma_solution" target="_blank" style=" color:#616265; text-decoration:none">RMA Lösung</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=estimated_lead_time" target="_blank" style=" color:#616265; text-decoration:none">Geschäzte Durchlaufzeit</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Mein Konto</strong><br />
                <a href="http://www.fiberstore.com/login.html" target="_blank" style=" color:#616265; text-decoration:none">Anmelden/Registrieren</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=manage_orders" target="_blank" style=" color:#616265; text-decoration:none">Meine Bestellungen</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=manage_wishlists" target="_blank" style=" color:#616265; text-decoration:none">Mein Wunschzettel</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; padding:0 5px;"><strong>Schnelle Hilfe</strong><br />
                <a href="http://www.fiberstore.com/how_to_buy.html" target="_blank" style=" color:#616265; text-decoration:none">Wie kann man etwas kaufen?</a><br />
                <a href="http://www.fiberstore.com/password_forgotten.html" target="_blank" style=" color:#616265; text-decoration:none">Ihr Passwort vergessen?</a><br />
                <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl(\'http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=\', \'chatbox152062\', globalWindowAttribute);" style=" color:#616265; text-decoration:none">Live Chat</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=faq" target="_blank" style=" color:#616265; text-decoration:none">FAQ</a></div></td>
        <td bgcolor="#E2E2E2"></td>
    </tr>');