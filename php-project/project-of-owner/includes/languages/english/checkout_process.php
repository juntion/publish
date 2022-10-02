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

define('EMAIL_TEXT_SUBJECT', 'FS.COM Order# %s ');
define('EMAIL_TEXT_HEADER', 'Order Confirmation');
define('EMAIL_TEXT_FROM',' from ');  //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING','Thanks for shopping with us today!');
define('EMAIL_DETAILS_FOLLOW','The following are the details of your order.');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Click here for a Detailed Invoice');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_PRODUCTS', 'Products');
define('EMAIL_TEXT_SUBTOTAL', 'Sub-Total:');
define('EMAIL_TEXT_TAX', 'Tax:        ');
define('EMAIL_TEXT_SHIPPING', 'Shipping: ');
define('EMAIL_TEXT_TOTAL', 'Total:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');

// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' No: ');
define('HEADING_ADDRESS_INFORMATION','Address Information');
define('HEADING_SHIPPING_METHOD','Shipping Method');


define('COPY_RIGHT', 'Copyright &copy; 2009-'.date('Y',time()).' FiberStore Co., Ltd. All Rights Reserved.');
define('FOOTER', '<tr>
        <td bgcolor="#E2E2E2"></td>
        <td bgcolor="#E2E2E2" height="160" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Company Info</strong><br />
                <a href="http://www.fiberstore.com/contact_us.html" target="_blank" style=" color:#616265; text-decoration:none;">Contact Us</a><br />
                <a href="http://www.fiberstore.com/about_us.html" target="_blank" style=" color:#616265; text-decoration:none">About Us</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=why_us" target="_blank" style=" color:#616265; text-decoration:none">Why Us</a><br />
                <a href="http://www.fiberstore.com/privacy_policy.html" target="_blank" style=" color:#616265; text-decoration:none">Privacy Policy</a><br />
                <a href="http://www.fiberstore.com/site_map.html" target="_blank" style=" color:#616265; text-decoration:none">Site Map</a><br />
                <a href="http://www.fiberstore.com/blog/" target="_blank" style=" color:#616265; text-decoration:none">FiberStore Blog</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Customer Service</strong><br />
                <a href="http://www.fiberstore.com/index.php?main_page=get_a_quick_quote" target="_blank" style=" color:#616265; text-decoration:none">Get a Quick Quote</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=custom_OEM" target="_blank" style=" color:#616265; text-decoration:none">Custom/OEM</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=payment_methods" target="_blank" style=" color:#616265; text-decoration:none">Payment Methods</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=shipping_guide" target="_blank" style=" color:#616265; text-decoration:none">Shipping Guide</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=rma_solution" target="_blank" style=" color:#616265; text-decoration:none">RMA Solution</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=estimated_lead_time" target="_blank" style=" color:#616265; text-decoration:none">Estimated Lead Time</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>My Account</strong><br />
                <a href="http://www.fiberstore.com/login.html" target="_blank" style=" color:#616265; text-decoration:none">Log in/Register</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=manage_orders" target="_blank" style=" color:#616265; text-decoration:none">My Orders</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=manage_wishlists" target="_blank" style=" color:#616265; text-decoration:none">My Wishlist</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; padding:0 5px;"><strong>Quick Help</strong><br />
                <a href="http://www.fiberstore.com/how_to_buy.html" target="_blank" style=" color:#616265; text-decoration:none">How to buy</a><br />
                <a href="http://www.fiberstore.com/password_forgotten.html" target="_blank" style=" color:#616265; text-decoration:none">Forgot your password?</a><br />
                <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl(\'http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=\', \'chatbox152062\', globalWindowAttribute);" style=" color:#616265; text-decoration:none">Live Chat</a><br />
                <a href="http://www.fiberstore.com/index.php?main_page=faq" target="_blank" style=" color:#616265; text-decoration:none">FAQ</a></div></td>
        <td bgcolor="#E2E2E2"></td>
    </tr>');