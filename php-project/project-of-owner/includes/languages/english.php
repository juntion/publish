<?php

define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="http://www.zen-cart.cn" target="_blank">Zen Cart</a>');
define('FIBERSTORE_ALL_RIGHTS_RESERVED','All Rights Reserved');
/*bof language for my_account*/
define('FIBERSTORE_ORDER_HELLO','Hello, ');
//define('FIBERSTORE_CDN_IMAGES','https://d2gwt4r5cjfqmi.cloudfront.net/');
define('FIBERSTORE_CDN_IMAGES','images/');
define('FIBERSTORE_ORDER_LOGIN_AS',' Logged in as ');
define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> News )');
define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> Tutorial )');
/*eof*/

//夏令时--冬令时
define('SUMMER_TIME',true);
if(SUMMER_TIME){
    define('FS_SUMMER_OR_WINTER_TIME','3:30pm (UTC/GMT+1)');
    define('FS_CHECKOUT_TIME','4:30pm UTC/GMT+2');
}else{
    define('FS_SUMMER_OR_WINTER_TIME','3:00pm (UTC/GMT)');
    define('FS_CHECKOUT_TIME','4pm UTC/GMT+1');
}

@setlocale(LC_TIME, 'en_US.UTF-8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
// define('FIBERSTORE_REGIST_ERROR','Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');
define('FIBERSTORE_REGIST_ERROR','Nuestro sistema ya tiene un registro de dicha dirección de correo electrónico - por favor intenta acceder a dicha dirección de correo electrónico. Si usted no usa esa dirección por más tiempo se puede corregir en el area Mi Cuenta');
define('FIBERSTORE_LOGIN_ERROR','La dirección de email o la contrase?a es incorrecta.');
define('FIBERSTORE_WELCOME_MEAASGE','Este mensaje fue enviado desde una dirección exclusivamente de notificación que no puede recibir mensajes entrantes. Por favor no responda a este mensaje. Si usted tiene alguna pregunta, por favor póngase en contacto con nosotros.');
define('FIBERSTORE_REVIEW_NO','Ninguna revisión actualmente .');
define('FIBERSTORE_WELCOME_TO','Estimado cliente,');
define('FIBERSTORE_WELCOME_CART','Carrito Permanente');
define('FIBERSTORE_CONTACT_ABOUT','sobre nosotros contenido de ecoptical.com');
define('FIBERSTORE_CUSTOMER_NAME','Nombre del cliente:');
define('FIBERSTORE_CUSTOMER_EMAIL','Cliente E-mail:');
define('FIBERSTORE_CONTACT_SUBJECT','sujeto');
define('FIBERSTORE_CONTACT_CONTENTS','Contenido:');
define('FIBERSTORE_CONTACT_FROM','De http://www.fs.com');
define('FIBERSTORE_SELECT','Por favor seleccione...');
define('FS_FSCOM','https://www.fs.com');
define('COPY_RIGHT', 'derechos de autor @ 2009-'.date('Y',time()).' FS.COM Co., Ltd. Todos los Derechos Reservados.');
define('FOOTER', '<tr>
        <td bgcolor="#E2E2E2"></td>
        <td bgcolor="#E2E2E2" height="160" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Información</strong><br />
                <a href="'.zen_href_link('contact_us').'" target="_blank" style=" color:#616265; text-decoration:none;">Contacte con nosotros</a><br />
                <a href="'.zen_href_link('about_us').'" target="_blank" style=" color:#616265; text-decoration:none">Acerca de nosotros</a><br />
                <a href="'.zen_href_link('why_us').'" target="_blank" style=" color:#616265; text-decoration:none">Por qué nosotros</a><br />
                <a href="'.zen_href_link('privacy_policy').'" target="_blank" style=" color:#616265; text-decoration:none">Política de Privacidad</a><br />
                <a href="'.zen_href_link('site_map').'" target="_blank" style=" color:#616265; text-decoration:none">Mapa del Sitio</a><br />
                <a href="http://www.fs.com/blog/" target="_blank" style=" color:#616265; text-decoration:none">FS.COM Blog</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Servicio al Cliente</strong><br />
                <a href="'.zen_href_link('get_a_quick_quote').'" target="_blank" style=" color:#616265; text-decoration:none">Obtener una cotización rápida</a><br />
                <a href="'.zen_href_link('oem').'" target="_blank" style=" color:#616265; text-decoration:none">OEM</a><br />
                <a href="'.zen_href_link('payment_methods').'" target="_blank" style=" color:#616265; text-decoration:none">Formas de Pago</a><br />
                <a href="'.zen_href_link('shipping_guide').'" target="_blank" style=" color:#616265; text-decoration:none">Guía de envío</a><br />
                <a href="'.zen_href_link('custom_OEM').'" target="_blank" style=" color:#616265; text-decoration:none">Solución</a><br />
                <a href="'.zen_href_link('estimated_lead_time').'" target="_blank" style=" color:#616265; text-decoration:none">Tiempo estimado</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; border-right:1px solid #C6C6C6; padding:0 5px;"><strong>Mi cuenta</strong><br />
                <a href="'.zen_href_link('login').'" target="_blank" style=" color:#616265; text-decoration:none">Inicie sesión o Regístrese</a><br />
                <a href="'.zen_href_link('manage_orders').'" target="_blank" style=" color:#616265; text-decoration:none">Mis pedidos</a><br />
                <a href="'.zen_href_link('manage_wishlists').'" target="_blank" style=" color:#616265; text-decoration:none">Mis Favoritos</a></div></td>
        <td bgcolor="#E2E2E2" style="border-bottom:1px solid #C6C6C6; "><div style=" height:140px; padding:0 5px;"><strong>Ayuda rápida</strong><br />
                <a href="'.zen_href_link('how_to_buy').'" target="_blank" style=" color:#616265; text-decoration:none">Cómo comprar</a><br />
                <a href="'.zen_href_link('password_forgotten').'" target="_blank" style=" color:#616265; text-decoration:none">Olvidaste tu contraseña?</a><br />
                <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl(\'http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=\', \'chatbox152062\', globalWindowAttribute);" style=" color:#616265; text-decoration:none">Chat en Vivo</a><br />
                <a href="'.zen_href_link('faq').'" target="_blank" style=" color:#616265; text-decoration:none">Preguntas más frecuentes</a></div></td>
        <td bgcolor="#E2E2E2"></td>
    </tr>');

define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="'.zen_href_link('index').'">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
				</a>		
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Data-Center-Products.html').'">Data Center</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Enterprise-Small-Business.html').'">Enterprise Network</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/ISP-Networks.html').'">Optical Transport Network</a>
			</div>');
define('EMAIL_FOOTER_INFO','
			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">Share Your Using Experience <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="'.zen_href_link('index').'">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('contact_us').'">Contact Us</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('account_newsletters').'">My Account</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('shipping_delivery').'">Shipping & Delivery</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.HTTPS_SERVER.reset_url('policies/day_return_policy.html').'">Return Policy</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">You are subscribed to this email as $user_email.</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="'.zen_href_link('account_newsletters').'">Click here to modify your preferences or unsubscribe.</a>
			</div>');

/* 产品、分类公用 */
define('FS_CUSTOMILIZED_ADD_TO_CART','Add to Cart');
define('FS_ADD_TO_CART', 'Add to Cart');
define('CATEGORIES_HEADING_DETAILS','View Details');
define('FS_VIEW_CART', 'View Cart');
define('FS_REVIEWS', 'Reviews');
define('FS_REVIEWS_SMALL', 'Reviews');
define('FS_REVIEW','Review');
define('FS_SHARE', 'share');
define('FS_NEED_HELP', 'need help');
define('FS_PRODUCT_NEED_HELP', 'Need Help?');
define('FS_COMPATIBLE', 'Compatible');
define('FS_LENGTH', 'Length');
define('FS_TOTAL_LENGTH', 'Total Length');
define('FS_CUSTOM_LENGTH', 'Custom Length');
define('FS_CUSTOM', 'Custom');
define('FS_SHIPPING_COST', 'Shipping Cost');
//define('FS_SHIP_SAME_DAY', 'Ready to ship');
define('FS_SHIP_SAME_DAY', 'Ship Today');
define('FS_SHIP_NEXT_DAY', 'Estimated the next day');
define('FS_OUT_OF_STOCK', 'Out of stock');
define('FS_DELETE_PRODUCT', 'Delete the product');
define('FS_AVAILABILTY', 'Availability');
define('PRODUCT_INFO_ADD','Add');
define('PRODUCT_INFO_ADDED','Added');
//2017.11.24  ery  add  产品详情页属性名称
define('FS_CHOOSE_LENGTH','Choose Length');
define('FS_LENGTH_NAME','Length');
define('FS_OPTION_NAME','Device Number');
//products移动公共文件
define('FS_PRODUCTS_ORDERS_RECEIVED','Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.');
//define('FS_PRODUCTS_ACTUAL_TIME','There may be some difference between the estimated time and the actual time.');
define('FS_PRODUCTS_ACTUAL_TIME','The actual shipping time may vary with the estimated time, it depends on handling time, destination zip code, shipping service selected and receipt of cleared payment.');
define('F_BODY_HEADER_GS','Global<br>Shipping');
define('F_BODY_HEADER_ITEM','Item');
define('F_BODY_HEADER_ITEM_TWO','Items');
define('F_BODY_HEADER_ITEMS','Items');
define('BOX_HEADING_SEARCH','Search');
define('FS_TRANSCEIVER_TYPE', 'Transceiver Type:');

define('FS_QUICK_VIEW', 'Product Quick View');
define('FS_WAIT', 'Please wait');
/* 放到公用文件 */

//2018.9.6 Yoyo  add 产品详情  shipping&returns
define('FS_ASK_EXPERT','Ask Our Expert:');
define('FS_ASK_EXPERT_1','Inquiry');
define('SOLUTION_SUB_PAGE_05','Project Inquiry');

/* 搜索相关 */
define('FIBERSTORE_IMAGES','Images');
define('FIBERSTORE_DETAILS','Details');
define('FIBERSTORE_SHOWING','Showing');
define('FIBERSTORE_OF','of');
define('FIBERSTORE_RESULTS_BY',' results by');
define("FIBERSTORE_PRODUCTS","products");
define("FIBERSTORE_PRODUCT","product");
define("FIBERSTORE_RESULTS_BY01","Sort by :");
define("FIBERSTORE_RESULTS_VIEW","View :");
define('FIBERSTORE_YOUR_PRICE','Your Price');
define('FIBERSTORE_QUANTITY','Qty');
define('FIBERSTORE_ADD_TO_CART','Add to Cart');
//define('FS_SHIP_SAME_DAY', 'Ready to ship');
define('FS_SHIP_SAME_DAY', 'Ship Today');
define('FS_SHIP_NEXT_DAY', 'Estimated the next day');
define('FS_PRODUCTS_ORDERS_RECEIVED','Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.');
//define('FS_PRODUCTS_ACTUAL_TIME','There may be some difference between the estimated time and the actual time.');
define('FS_PRODUCTS_ACTUAL_TIME','The actual shipping time may vary with the estimated time, it depends on handling time, destination zip code, shipping service selected and receipt of cleared payment.');
/* end 搜索 */

/* 购物车层 */
define('FIBERSTORE_REMOVE','Remove');
define('FIBERSTORE_CART_TOTAL','Cart Total:');
define('FIBERSTORE_EDITE_ORDER','View Cart');
define('FIBERSTORE_CHECK_YOU_ORDER','Checkout');
define('FIBERSTORE_SHOPPING_HELP','Your Shopping Cart is Empty.');
define('FS_PROCEED_TO_CHECKOUT','PROCEED TO CHECKOUT');
define('FS_ITEMS','items');
define('FS_CART','Cart');
define('FS_VIEW_ALL','View All');
define('FS_FILTER', 'Filter');
define('FS_SAVED_ITEMS', 'All Saved Items');
define('FS_SAVED_CART', 'Saved Cart');
/* end 购物车 */

//module shipping   运费模块
define('FS_SHIP_ORDER','Ship my order(s) to');
define('FS_CHOOSE_SHIP','Choose Delivery Method');

define('ACCOUNT_EDIT_FOOTER_TITLE','SHOP WITH CONFIDENCE');

define('ACCOUNT_EDIT_FOOTER_SHOPPING','SHOPPING ON FS.COM ');

define('ACCOUNT_EDIT_FOOTER_SECURE','IS SAFE AND SECURE.');

define('TEXT_LOGIN_GUARANTEED','GUARANTEED!');

define('ACCOUNT_EDIT_FOOTER_PAY','You Will pay nothing if unauthorized charges are made to your credit card as a result of shopping at fs.com.');

define('ACCOUNT_EDIT_FOOTER_SAFE','SAFE SHOPPING GUARANTEE');

define('ACCOUNT_EDIT_FOOTER_INFORMATION','All information is encrypted and transmitted without risk using a Secure Sockets Layer (SSL) protocol.');

define('ACCOUNT_EDIT_FOOTER_HOW','How We Protect Your Personal Data ?');

define('ACCOUNT_EDIT_FOOTER_FREE','FREE SHIPPING AND FREE RETURNS');

define('ACCOUNT_EDIT_FOOTER_SHOP','If, you are unsatisfied with your purchase from FS.COM Co.,Ltd you may return it in its original condition as soon as possible for a refund. We Will even pay for return shipping!');

define('ACCOUNT_EDIT_FOOTER_DELIVER','To deliver worry free operation and eliminate the cost associated with out of warranty repairs, FS.COM offers a Warranty as a standard feature across all major product lines.');

define('ACCOUNT_EDIT_FOOTER_LEARN','Learn More...');

define('TEXT_FIBERSTORE_REGIST_RESPECTS','fs.com respects your privacy. We don t rent or sell your personal information to anyone.');

define('TEXT_FIBERSTORE_REGIST_PRIVACY','privacy a policy.');

define('FS_LOCAL_PICKUP','Local Pickup');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false) {
        if ($reverse) {
            return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
        } else {
            return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
        }
    }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="en"');

// charset for web pages and emails
define('CHARSET', 'UTF-8');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'requests since');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME','Gift Certificate');
define('TEXT_GV_NAMES','Gift Certificates');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM','Redemption Code');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
define('BOX_GV_REDEEM_INFO', 'Redemption code: ');

// text for gender
define('MALE', 'Mr.');
define('FEMALE', 'Ms.');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Ms.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

//text for sidebox heading links
define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[more]');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Categories');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Manufacturers');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'New Products');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'New Products ...');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Featured');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Featured Products ...');
define('TEXT_NO_FEATURED_PRODUCTS', 'More featured products will be added soon. Please check back later.');

define('TEXT_NO_ALL_PRODUCTS', 'More products will be added soon. Please check back later.');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'All Products ...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Search');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Advanced Search');
define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'Enter your search words here ...');
// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Specials');
define('CATEGORIES_BOX_HEADING_SPECIALS','Specials ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Reviews');
define('BOX_REVIEWS_WRITE_REVIEW', 'Write a review on this product.');
define('BOX_REVIEWS_NO_REVIEWS', 'There are currently no product reviews.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 Stars!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Cart');
define('BOX_SHOPPING_CART_EMPTY', 'Your cart is empty.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Quick Re-Order');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bestsellers');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestsellers in<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Notifications');
define('BOX_NOTIFICATIONS_NOTIFY', 'Notify me of updates to <strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Do not notify me of updates to <strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Manufacturer Info');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Other products');

// languages box text in sideboxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Languages');

// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Currencies');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_PRIVACY', 'Privacy Notice');
define('BOX_INFORMATION_CONDITIONS', 'Conditions of Use');
define('BOX_INFORMATION_SHIPPING', 'Shipping &amp; Returns');
define('BOX_INFORMATION_CONTACT', 'Contact Us');
define('BOX_BBINDEX', 'Forum');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Newsletter Unsubscribe');

define('BOX_INFORMATION_SITE_MAP', 'Site Map');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'More Information');
define('BOX_INFORMATION_PAGE_2', 'Page 2');
define('BOX_INFORMATION_PAGE_3', 'Page 3');
define('BOX_INFORMATION_PAGE_4', 'Page 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Tell A Friend');
define('BOX_TELL_A_FRIEND_TEXT', 'Tell someone you know about this product.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'My Wishlist');
define('BOX_WISHLIST_EMPTY', 'You have no items on your Wishlist');
define('IMAGE_BUTTON_ADD_WISHLIST', 'Add to Wishlist');
define('TEXT_WISHLIST_COUNT', 'Currently %s items are on your Wishlist.');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> items on your wishlist)');

//New billing address text
define('SET_AS_PRIMARY' , 'Set as Primary Address');
define('NEW_ADDRESS_TITLE', 'Billing Address');

// javascript messages
define('JS_ERROR', 'Errors have occurred during the processing of your form.\n\nPlease make the following corrections:\n\n');

define('JS_REVIEW_TEXT', '* Please add a few more words to your comments. The review needs to have at least ' . REVIEW_TEXT_MIN_LENGTH . ' characters.');
define('JS_REVIEW_RATING', '* Please choose a rating for this item.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please select a payment method for your order.');

define('JS_ERROR_SUBMITTED', 'This form has already been submitted. Please press OK and wait for this process to be completed.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method for your order.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Please confirm the terms and conditions bound to this order by ticking the box below.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Please confirm the privacy statement by ticking the box below.');

define('CATEGORY_COMPANY', 'Company Details');
define('CATEGORY_PERSONAL', 'Your Personal Details');
define('CATEGORY_ADDRESS', 'Your Address');
define('CATEGORY_CONTACT', 'Your Contact Information');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Your Password');
define('CATEGORY_LOGIN', 'Login');
define('PULL_DOWN_DEFAULT', 'Please Choose Your Country');
define('PLEASE_SELECT', 'Please select ...');
define('TYPE_BELOW', 'Type a choice below ...');

define('ENTRY_COMPANY', 'Company Name:');
define('ENTRY_COMPANY_ERROR', 'Please enter a company name.');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Salutation:');
define('ENTRY_GENDER_ERROR', 'Please choose a salutation.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', 'Is your first name correct? Our system requires a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters. Please try again.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', 'Is your last name correct? Our system requires a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters. Please try again.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Is your birth date correct? Our system requires the date in this format: MM/DD/YYYY (eg 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (eg. 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'Email Address:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Is your email address correct? It should contain at least ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters. Please try again.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Sorry, my system does not understand your email address. Please try again.');
// define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este e-mail ya existe en nuestra base de datos - por favor, entre con otro e-mail o cree otra cuenta con una dirección de e-mail diferen.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');

define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', 'Forum Nick Name:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
define('ENTRY_NICK_DUPLICATE_ERROR', 'That Nick Name is already being used. Please try another.');
define('ENTRY_NICK_LENGTH_ERROR', 'Please try again. Your Nick Name must contain at least ' . ENTRY_NICK_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Address Line 2:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Post/Zip Code:');
define('ENTRY_POST_CODE_ERROR', 'Your Post/ZIP Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'City:');
define('ENTRY_CUSTOMERS_REFERRAL', 'Referral Code:');

define('ENTRY_CITY_ERROR', 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'State/Province: ');
define('ENTRY_STATE_ERROR', 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR_SELECT', 'Please select a state from the States pull down menu.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- Please Choose --');
define('ENTRY_COUNTRY', 'Country: ');
define('ENTRY_COUNTRY_ERROR', 'You must select a country from the Countries pull down menu.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone Number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Subscribe to Our Newsletter.');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Password:');
define('ENTRY_PASSWORD_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'The Password Confirmation must match your Password.');
define('ENTRY_PASSWORD_TEXT', '* (at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Confirm Password:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current Password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW', 'New Password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'The Password Confirmation must match your new Password.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

define('FORM_REQUIRED_INFORMATION', '* Required information');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Total: <strong>%d</strong> Items &nbsp;&nbsp; <strong>%d</strong> / %d');

define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> specials)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> featured products)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
define('TEXT_TOTAL_NUMBER_OF_REVIEWS','(<strong>%d</strong>)');


define('PREVNEXT_TITLE_FIRST_PAGE', 'First Page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Previous Page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Next Page');
define('PREVNEXT_TITLE_LAST_PAGE', 'Last Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
define('PREVNEXT_BUTTON_FIRST', 'FIRST');
define('PREVNEXT_BUTTON_PREV', 'Prev');
define('PREVNEXT_BUTTON_NEXT', 'Next');
define('PREVNEXT_BUTTON_LAST', 'LAST');

define('TEXT_BASE_PRICE','Starting at: ');

define('TEXT_CLICK_TO_ENLARGE', 'larger image');

define('TEXT_SORT_PRODUCTS', 'Sort products ');
define('TEXT_DESCENDINGLY', 'descendingly');
define('TEXT_ASCENDINGLY', 'ascendingly');
define('TEXT_BY', ' by ');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');
define('TEXT_NO_REVIEWS', 'There are currently no product reviews.');

define('TEXT_NO_NEW_PRODUCTS', 'More new products will be added soon. Please check back later.');

define('TEXT_UNKNOWN_TAX_RATE', 'Sales Tax');

define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: %s. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: %s. This is a potential security risk - please set the right user permissions on this file (read-only, CHMOD 644 or 444 are typical). You may need to use your webhost control panel/file-manager to change the permissions effectively. Contact your webhost for assistance. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">See this FAQ</a>');
define('ERROR_FILE_NOT_REMOVEABLE', 'Error: Could not remove the file specified. You may have to use FTP to remove the file, due to a server-permissions configuration limitation.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . zen_session_save_path() . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . zen_session_save_path() . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this PHP feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Warning: The SQL cache directory does not exist: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until this directory is created.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the SQL cache directory: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until the right user permissions are set.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Your database appears to need patching to a higher level. See Admin->Tools->Server Information to review patch levels.');
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'WARNING: Could not locate language file: ');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiration date entered for the credit card is invalid. Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid. Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The credit card number starting with %s was not entered correctly, or we do not accept that kind of card. Please try again or use another credit card.');

define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Discount Coupons');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Balance ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Account');
define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
define('ERROR_REDEEMED_AMOUNT', 'Congratulations, you have redeemed ');
define('ERROR_NO_REDEEM_CODE', 'You did not enter a ' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
define('TABLE_HEADING_CREDIT', 'Credits Available');
define('GV_HAS_VOUCHERA', 'You have funds in your ' . TEXT_GV_NAME . ' Account. If you want <br />
                           you can send those funds by <a class="pageResults" href="');

define('GV_HAS_VOUCHERB', '"><strong>email</strong></a> to someone');
define('ENTRY_AMOUNT_CHECK_ERROR', 'You do not have enough funds to send this amount.');
define('BOX_SEND_TO_FRIEND', 'Send ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED',  TEXT_GV_NAME . ' Redeemed');
define('CART_COUPON', 'Coupon :');
define('CART_COUPON_INFO', 'more info');
define('TEXT_SEND_OR_SPEND','You have a balance available in your ' . TEXT_GV_NAME . ' account. You may spend it or send it to someone else. To send click the button below.');
define('TEXT_BALANCE_IS', 'Your ' . TEXT_GV_NAME . ' balance is: ');
define('TEXT_AVAILABLE_BALANCE', 'Your ' . TEXT_GV_NAME . ' Account');

// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Gift Certificate/Coupon');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Credits Available');

define('TEXT_INVALID_REDEEM_COUPON', 'Invalid Coupon Code');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'You must spend at least %s to redeem this coupon');
define('TEXT_INVALID_STARTDATE_COUPON', 'This coupon is not available yet');
define('TEXT_INVALID_FINISHDATE_COUPON', 'This coupon has expired');
define('TEXT_INVALID_USES_COUPON', 'This coupon could only be used ');
define('TIMES', ' times.');
define('TIME', ' time.');
define('TEXT_INVALID_USES_USER_COUPON', 'You have used coupon code: %s the maximum number of times allowed per customer. ');
define('REDEEMED_COUPON', 'a coupon worth ');
define('REDEEMED_MIN_ORDER', 'on orders over ');
define('REDEEMED_RESTRICTIONS', ' [Product-Category restrictions apply]');
define('TEXT_ERROR', 'An error has occurred');
define('TEXT_INVALID_COUPON_PRODUCT', 'This coupon code is not valid for any product currently in your cart.');
define('TEXT_VALID_COUPON', 'Congratulations you have redeemed the Discount Coupon');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'The coupon code you entered is not valid for the address you have selected.');

// more info in place of buy now
define('MORE_INFO_TEXT','... more info');

// IP Address
define('TEXT_YOUR_IP_ADDRESS','Your IP Address is: ');

//Generic Address Heading
define('HEADING_ADDRESS_INFORMATION','Address Information');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART','Quantity in Cart: ');
define('PRODUCTS_ORDER_QTY_TEXT','Add to Cart: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Successfully added Product to the cart ...');
// only for where multiple add to cart is used:
define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Successfully added selected Product(s) to the cart ...');

define('TEXT_PRODUCT_WEIGHT_UNIT','kg');

// Shipping
define('TEXT_SHIPPING_WEIGHT','kg');
define('TEXT_SHIPPING_BOXES', 'Boxes');

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX_1','Save &nbsp;');
define('PRODUCT_PRICE_DISCOUNT_PREFIX','Save:&nbsp;');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE','% off');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT','&nbsp;off');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE','Sale:&nbsp;');

//universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX','Sponsors');
define('TEXT_BANNER_BOX','Please Visit Our Sponsors ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2','Have you seen ...');
define('TEXT_BANNER_BOX2','Check this out today!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL','Sponsors');
define('TEXT_BANNER_BOX_ALL','Please Visit Our Sponsors ...');

// boxes defines
define('PULL_DOWN_ALL','Please Select');
define('PULL_DOWN_MANUFACTURERS','- Reset -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Please Select');

// general Sort By
define('TEXT_INFO_SORT_BY','Sort by: ');

// close window image popups
define('TEXT_CLOSE_WINDOW',' - Click Image to Close');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW','[ Close Window ]');

// iii 031104 added:  File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Error:  File type not allowed.');
define('WARNING_NO_FILE_UPLOADED', 'Warning:  no file uploaded.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Success:  file saved successfully.');
define('ERROR_FILE_NOT_SAVED', 'Error:  File not saved.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Error:  destination not writeable.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Error: destination does not exist.');
define('ERROR_FILE_TOO_BIG', 'Warning: File was too large to upload!<br />Order can be placed but please contact the site for help with upload');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'NOTICE: This website is scheduled to be down for maintenance on: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'NOTICE: The website is currently Down For Maintenance to the public');

define('PRODUCTS_PRICE_IS_FREE_TEXT','It\'s Free!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT','Call for Price');
define('TEXT_CALL_FOR_PRICE','Call for price');

define('TEXT_INVALID_SELECTION',' You picked an Invalid Selection: ');
define('TEXT_ERROR_OPTION_FOR',' On the Option for: ');
define('TEXT_INVALID_USER_INPUT', 'User Input Required<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING','Min: ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING','Units: ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING','In cart:');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING','Add Additional:');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING','Max:');

define('TEXT_PRODUCTS_MIX_OFF','*Mixed OFF');
define('TEXT_PRODUCTS_MIX_ON','*Mixed ON');

define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART','<br />*You can not mix the options on this item to meet the minimum quantity requirement.*<br />');
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART','*Mixed Option Values is ON<br />');

define('ERROR_MAXIMUM_QTY','The quantity added to your cart has been adjusted because of a restriction on maximum you are allowed. See this item: ');
define('ERROR_CORRECTIONS_HEADING','Please correct the following: <br />');
define('ERROR_QUANTITY_ADJUSTED', 'The quantity added to your cart has been adjusted. The item you wanted is not available in fractional quantities. The quantity of item: ');
define('ERROR_QUANTITY_CHANGED_FROM', ', has been changed from: ');
define('ERROR_QUANTITY_CHANGED_TO', ' to ');

// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG','NOTE: Downloads are not available until payment has been confirmed');
define('TEXT_FILESIZE_BYTES', ' bytes');
define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
define('ERROR_PRODUCT','The item: ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART','<br />We are sorry but this product has been removed from our inventory at this time.<br />This item has been removed from your shopping cart.');
define('ERROR_PRODUCT_QUANTITY_MIN',',  ... Minimum Quantity errors - ');
define('ERROR_PRODUCT_QUANTITY_UNITS',' ... Quantity Units errors - ');
define('ERROR_PRODUCT_OPTION_SELECTION','<br /> ... Invalid Option Values Selected ');
define('ERROR_PRODUCT_QUANTITY_ORDERED','<br /> You ordered a total of: ');
define('ERROR_PRODUCT_QUANTITY_MAX',' ... Maximum Quantity errors - ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART',', has a minimum quantity restriction. ');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART',' ... Quantity Units errors - ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART',' ... Maximum Quantity errors - ');

define('WARNING_SHOPPING_CART_COMBINED', 'NOTICE: For your convenience, your current shopping cart has been combined with your shopping cart from your last visit. Please review your shopping cart before checking out.');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
define('ERROR_CUSTOMERS_ID_INVALID', 'Customer information cannot be validated!<br />Please login or recreate your account ...');

define('TABLE_HEADING_FEATURED_PRODUCTS','Featured Products');

define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');
define('TABLE_HEADING_SPECIALS_INDEX', 'Monthly Specials For %s');

define('CAPTION_UPCOMING_PRODUCTS','These items will be in stock soon');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS','table contains a list of products that are due to be in stock soon and the dates the items are expected');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT','It\'s Free!');

// customer login
define('TEXT_SHOWCASE_ONLY','Contact Us');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE','Price Unavailable');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE','Login for price');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM','Show Room Only');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Price Unavailable');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'APPROVAL PENDING');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE','Login to Shop');

// text pricing
define('TEXT_CHARGES_WORD','Calculated Charge:');
define('TEXT_PER_WORD','<br />Price per word: ');
define('TEXT_WORDS_FREE',' Word(s) free ');
define('TEXT_CHARGES_LETTERS','Calculated Charge:');
define('TEXT_PER_LETTER','<br />Price per letter: ');
define('TEXT_LETTERS_FREE',' Letter(s) free ');
define('TEXT_ONETIME_CHARGES','*onetime charges = ');
define('TEXT_ONETIME_CHARGES_EMAIL',"\t" . '*onetime charges = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Option Quantity Discounts');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY','QTY');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE','PRICE');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Option Quantity Discounts Onetime Charges');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED',' maximum characters allowed');
define('TEXT_REMAINING','remaining');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Estimate Shipping Costs');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Please <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>, to display your personal shipping costs.');
define('CART_SHIPPING_METHOD_TEXT', 'Available Shipping Methods');
define('CART_SHIPPING_METHOD_RATES', 'Rates');
define('CART_SHIPPING_METHOD_TO','Deliver to');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Ship to: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT','Free Shipping');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS','- Downloads');
define('CART_SHIPPING_METHOD_RECALCULATE','Recalculate');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED','true');
define('CART_SHIPPING_METHOD_ADDRESS','Address:');
define('CART_OT','Total Cost Estimate:');
define('CART_OT_SHOW','true'); // set to false if you don't want order totals
define('CART_ITEMS','Items in Cart: ');
define('CART_SELECT','Select');
define('ERROR_CART_UPDATE', '<strong>Please update your order.</strong> ');
define('IMAGE_BUTTON_UPDATE_CART', 'Update');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Whoops! Your session has expired ... Please update your shopping cart for Shipping Quote ...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Shipping quotes are based on the address information you selected:');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
//moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Qty Discounts Off Price');
define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Qty Discounts New Price');
define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Qty Discounts Off Price');
define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Discounts may vary based on options above');
define('TEXT_HEADER_DISCOUNTS_OFF', 'Qty Discounts Unavailable ...');

// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET','- RESET - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Product Name');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Product Name - desc');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Price - low to high');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Price - high to low');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Model');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Date Added - New to Old');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Date Added - Old to New');
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Default Display');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Link Expires');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Remaining');
define('HEADING_DOWNLOAD', 'To download your files click the download button and choose "Save to Disk" from the popup menu.');
define('TABLE_HEADING_DOWNLOAD_FILENAME','Filename');
define('TABLE_HEADING_PRODUCT_NAME','Item Name');
define('TABLE_HEADING_BYTE_SIZE','File Size');
define('TEXT_DOWNLOADS_UNLIMITED', 'Unlimited');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Qty.');
define('TABLE_HEADING_PRODUCTS', 'Item Name');
define('TABLE_HEADING_TOTAL', 'Total');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Privacy Statement');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Please acknowledge you agree with our privacy statement by ticking the following box. The privacy statement can be read <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'I have read and agreed to your privacy statement.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Address Details');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Additional Contact Details');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Verify Your Age');
define('TABLE_HEADING_LOGIN_DETAILS', 'Login Details');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Were You Referred to Us?');

define('ENTRY_EMAIL_PREFERENCE','Newsletter and Email Details');
define('ENTRY_EMAIL_HTML_DISPLAY','HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY','TEXT-Only');
define('EMAIL_SEND_FAILED','ERROR: Failed sending email to: "%s" <%s> with subject: "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Error - Could not connect to Database');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - On for Admin IP Only');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Items starting with ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Reset --');

///////////////////////////////////////////////////////////
// include email extras
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select. FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

// END OF EXTERNAL LANGUAGE LINKS

define('FIBERSTORE_VIEW_MORE', 'More items ...');
define('FIBERSTORE_WISHLIST_ADD_TO_CART','Add To Cart');
define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS','Add To WishList Success');
define('FIBERSTORE_DELETE','Delete');
define('FIBERSTORE_PRICE','PRICE');
define('FIBERSTORE_VIEW_MORE_ORDERS','View All Orders »');
define('FIBERSTORE_ORDER_IMAGE','Products picture');
define('FIBERSTORE_POST','Post');
define('FIBERSTORE_CANCEL_ORDER','Cancel Order');
define('FIBERSTORE_PRODTCTS_DETAILS','Products Details');

define('FIBERSTORE_OEM_CUSTOM','OEM & CUSTOMER');
define('FIBERSTORE_ANY_TYPE','Any Type');
define('FIBERSTORE_ANY_LENGTH','Any Length');
define('FIBERSTORE_ANY_COLOR','Any Color');
define('FIBERSTORE_WORK_PROJECT','Let‘s Work With You on Your Custom Project');

define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
define('TEXT_PREFIX','text_prefix_');
//2016-5-25. by peter
define('LIVE_CHAT_TIT','Get All the Support about Purchase');
define('LIVE_CHAT_TIT1','Professional Service & Support is available in three different ways');
define('LIVE_CHAT_TIT2','Post your message to FS.COM successfully, Thank you!');
define('LIVE_CHAT_CON1','Chat live with FS.COM');
define('LIVE_CHAT_CON2','Talking with us and getting the related information immediately.');
define('LIVE_CHAT_CON3','8 am. to Midnight PST Mon. to Fri.');
define('LIVE_CHAT_CON4','Please leave us a message, we\'ll respond to you as soon.');
define('LIVE_CHAT_CON5','Leave Message');
define('LIVE_CHAT_CON6','Email to FS.COM');
define('LIVE_CHAT_CON7','Reply Within 12 Hours');
define('LIVE_CHAT_CON8','Post a inquiry request and get a quick response from FS.COM.');
define('LIVE_CHAT_CON9','E-mail Now');
define('LIVE_CHAT_CON10','Available');
define('LIVE_CHAT_CON11','Unavailable');
define('LIVE_CHAT_CON12','Get a Call');

//订单页面公共部分  常量
//2016-9-7 add by  Frankie
define('ALL_ORDER','All Orders');
define('UNPAID_ORDER','Pending Orders');
define('TRADING_ORDERS','Transaction Orders');
define('CLOSED_ORDERS','Canceled Orders');
define('FIBERSTORE_QUESTION','Question submit successfully');
define('FIBERSTORE_ORDER_PRIVATE','Private orders');
define('FIBERSTORE_ORDER_COMPANY','All orders for the company');
define('FIBERSTORE_ORDER_SELECT','Select by Order Date');
define('PLEASE','Please select');
define('WEEK','Latest Week');
define('MONTH','Latest Month');
define('THREE_MONTH','Latest Three Month');
define('FIBERSTORE_ORDER_ENTER','Enter your Order No');
define('FIBERSTORE_ORDER_NO','Order NO');
define('SEARCH','Search');
define('FIBERSTORE_ORDER_PROMT','NO ORDERS FOUND.');
define('FIBERSTORE_ORDER_PROMT_RMA','No RMA request.');
// add by Aron
define('FIBERSTORE_ORDER_PROMT1','No RMA request.');
define('FIBERSTORE_ORDER_PROMT2','No orders found.');
define('FIBERSTORE_ORDER_PROMT3','Canceled');
define('FIBERSTORE_ORDER_PROMT4','Shipping Address');
define('FIBERSTORE_ORDER_PICTURE','Products Picture');
define('FIBERSTORE_ORDER_DATE','Order Date');
define('PAYMENT','Payment');
define('CANCELED','Canceled');
define('FIBERSTORE_ORDER_OPERATE','Operate');
define('PREVIOUS','Previous');
define('NEXT','Next');
define('FIBERSTORE_ORDER_PAGE','Page');
define('FIBERSTORE_ORDER_OF','of');
define('FS_LEARN_MORE','Learn more');
define('CONNECTING_PAYPAL','Connecting to Paypal');
define('ARE_YOU_SURE','Are you sure to cancel the order?');
define('ONCE_YOU_DO','Once you do that, it can not be recovered.');
define('HOWEVER','However, if you really mean that, pls kindly provide us a reason(s) for canceling');
define('EXPENSIVE','Expensive shipping fee');
define('DUPLICATE','Duplicate order');
define('FAILING','Failing payment');
define('WRONG','Wrong writing of information');
define('OUT','Out of Stock');
define('NO_NEED','No need');
define('OFFLINE','Offline deal');
define('FIBERSTORE_ORDER_CONFIRM','Confirm');
define('OTHERS','Others');
define('BEFORE_SUBMITTING','Before submitting,please fill out the reasons for cancelling the order');
define('CANCEL','Cancel');
define('HOT_PRODUCTS','Hot Products');
/*module shipping   运费模块 */
define('FS_COMPANY','Delivery Method');
define('FS_TIME','Estimated Delivery');
define('FS_COST','Shipping Cost');
define('FS_TO','to');
define('FS_VIA','Via');
define('FS_FREE_SHIP','Free Shipping');
define('FS_PREFER','If you prefer to use your own express account, please kindly provide the account number, then FS.COM does not charge for the freight.');
define('FS_METHOD','Shipping Method');
define('FS_ACCOUNt','Express Account');
define('FS_NO_SHIPPING','No shipping available to the selected country');
define('FS_SHIP_CONFIRM','Confirm');
define('FS_BUSINESS_DAYS','Business Days');
define('FS_BUSINESS_DAY','Business Day');
define('FS_WORK_DAYS_SERVICE', 'Working Days');


define('FS_COMMON_CLEAR','Clear Selections');
define('FS_COMMON_COMPLIANT','Compliant with IEEE 802.3z standards for Fast Ethernet and Gigabit Ethernet applications');
define('FS_COMMON_ADD','Add');
define('FS_COMMON_ADDED','Added');
define('FS_ADDED','Added');
define('FS_COMMON_PROCESSING','Processing');
define('FS_COMMON_PLEASE_WAIT','Please wait');
define('FS_COMMON_PRODUCT','Product Quick View');
define('FS_COMMON_NEXT','Next');
define('FS_COMMON_PREVIOUS','Previous');

//2016.12.6 added
define('FS_VERIFIED_PUR','Verified Purchase');
define('FS_COMMENTS','Comments');
//2016.12.13评论ajax
define('FS_REVIEWS10','Share');
define('FS_REVIEWS11','Comments');
define('FS_CANCEL','Cancel');
define('FS_SUBMIT', 'Submit');
define('FS_DELETE_SUCESS','Delete successfully.');
define('FS_DELETE','Delete');
define('FS_EDIT_POST','Edit this post');
define('FS_REVIEW_REPORT','Report');
define('FS_REVIEWS34',' Helpful votes');
define('FS_REVIEWS35',' Helpful vote');
define('FS_REVIEWS31','Showing');
define('FS_REVIEWS32','comment');
define('FS_REVIEWS36','comments');
define('FS_BY','By');
define('FS_READ_MORE','Read more');
define('FS_SEE_LESS','Read less');


//评论相关页面编辑头像 2017.4.10  ery
define('FS_ADAPTER_TYPE', 'Adapter Type');
define('FS_TRANS_RELATED', 'Type');

define('FS_REVIEWS_REPLACE','Replace Head');
define('FS_REVIEWS_EDIT','Edit Your Profile');
define('FS_REVIEWS_RECOMMENDED','Recommended head');
define('FS_REVIEWS_LOCAL','Local Upload');
define('FS_REVIEWS_ONLY','Only supports JPG, GIF, PNG, JPEG, BMP format, the file is less than 300KB');
define('FS_REVIEWS_SAVE','Save');
define('ACCOUNT_FOOTER_LEARN','View More...');

//账户中心相关页面公用向量   2017.5.12  ery  add
/*edit_my_account页面*/
define('ACCOUNT_MY_HOME','Home');
define('ACCOUNT_MY_ACCOUNT','My Account');
define('ACCOUNT_MY_REVIEWS','My Reviews');
define('ACCOUNT_EDIT_ACCOUNT','Account Settings');
define('ACCOUNT_EDIT_BELOW','Please edit your information below, then  click the update button to make the changes.');
define('ACCOUNT_EDIT_FOLLOW','Please check the following…');
define('ACCOUNT_EDIT_SUCCESS','Success');
define('ACCOUNT_EDIT_ACCOUNT_INFO','Account Information');
define('ACCOUNT_EDIT_UPDATE','Update');
define('ACCOUNT_EDIT_EMAIL','Email Address');
define('ACCOUNT_EDIT_NEW','New Password');
define('ACCOUNT_EDIT_REENTER','Re-Enter Password');
define('ACCOUNT_EDIT_ADDRESS','Address Information');
define('ACCOUNT_EDIT_FIRST','First Name');
define('ACCOUNT_EDIT_LAST','Last Name');
define('ACCOUNT_EDIT_COMPANY','Company Name');
define('ACCOUNT_EDIT_STREET','Address Line 1');
define('ACCOUNT_EDIT_LINE','Address Line 2');
define('ACCOUNT_EDIT_POSTAL','Postal Code');
define('ACCOUNT_EDIT_CITY','City');
define('ACCOUNT_EDIT_COUNTRY','Destination Country/Region');
define('ACCOUNT_EDIT_STATE','State / Province / Region');
define('ACCOUNT_EDIT_PHONE','Phone Number');
define('ACCOUNT_EDIT_EMIAL_MSG','The email address you submitted is not recognized.(example:someone@example.com).');
define('ACCOUNT_EDIT_PASS_MSG','6 characters minimun; at least one letter and one number.');
define('ACCOUNT_EDIT_CONFIRM_MSG',"The confirmation password doesn\'t match the new password. They should be identical.");
define('ACCOUNT_EDIT_FIRST_MSG','Please enter your First Name.');
define('ACCOUNT_EDIT_LAST_MSG','Please enter your  Last Name.');
define('ACCOUNT_EDIT_STREET_MSG','Please enter your  Street Address.');
define('ACCOUNT_EDIT_POSTAL_MSG','Please enter your  Postal Code.');
define('ACCOUNT_EDIT_CITY_MSG','Please enter your  city.');
define('ACCOUNT_EDIT_CITY_FROMAT_TIP','Your city should be at least 2 characters long.');
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP','Your address line 2 should be at least 2 characters long.');

define('ACCOUNT_EDIT_COUNTRY_MSG','Please enter your Country/Region.');
define('ACCOUNT_EDIT_STATE_MSG','Please enter your  State / Province / Region.');
define('ACCOUNT_EDIT_PHONE_MSG','Please enter your  Telephone Number.');
define('ACCOUNT_EDIT_HEADER_OUR','Our system already has a record of that email address .');
define('ACCOUNT_EDIT_HEADER_EDIT','Edit nickname successfully .');
define('ACCOUNT_EDIT_HEADER_FILE','File is too big!');
define('ACCOUNT_EDIT_HEADER_CUSTOMER','Customer Photo is modified.');
define('ACCOUNT_EDIT_HEADER_THANKS','Thank you');
define('ACCOUNT_EDIT_HEADER_FS','FS.COM Customer Service');
define('ACCOUNT_EDIT_HEADER_INFO','FS.COM - Account Information Update');
define('ACCOUNT_EDIT_HEADER_YOUR','Your FS.COM account information has been updated. Please refer below to verify your update account information');

/*my_questions和my_questions_details页面*/
define('FS_QUSTION','Questions');
define('FS_QUSTI','Question');
define('FS_QUSTION_TELL','Share any of your questions regarding account, orders, RMAs, or technical support, we will ensure a quickest response.');
define('FS_QUSTION_ASK','Ask a Question');
define('FS_QUSTION_DATE','Date');
define('FS_QUSTION_STATUS','Status');
define('FS_QUSTION_VIEW','View');
define('FS_QUSTION_REMOVE','Remove');
define('FS_QUSTION_ENTRIES','Entries');
define('FS_QUSTION_NO','No title filled in.');
define('FS_QUSTION_ANSWERS','Answers');
define('FS_QUSTION_REPLY','Questions was in processing,please be patient.');
define('FS_QUSTION_JS','Delete this Information ?');
define('FS_QUSTION_STATUS_JS','Are you confirm ?');
/*manage_address页面*/
define('FS_ADDRESS_BOOK','Address Book');
define('FS_ADDRESS_NAME','Name');
define('FS_ADDRESS_COMPANY','Company');
define('FS_ADDRESS_ADDRESS','Address');
define('FS_ADDRESS_NO','No Address Found');
define('FS_ADDRESS_DEFAULT','Default');
define('FS_ADDRESS_PO','PO');
define('FS_ADDRESS_SET','Set as default');
define('FS_ADDRESS_EDIT','Edit');
define('FS_ADDRESS_CREATE','Create Address');
define('FS_ADDRESS_UPDATE','Update Address Entry');
define('FS_ADDRESS_PLEASE','Please complete this form to edit this address, then  the update button.');

define('FS_ADDRESS_FIRST_REQUIRED_TIP','Your first name can\'t be empty.');
define('FS_ADDRESS_FIRST_MSG','Your first name must contain a minimum of 2 characters.');
define('FS_ADDRESS_LAST_REQUIRED_TIP','Your last name can\'t be empty.');
define('FS_ADDRESS_LAST_MSG','Your last name must contain a minimum of 2 characters.');

define('FS_ADDRESS_SORRY','Sorry, shipping address is required.');
define('FS_ADDRESS_STREET_FORMAT_TIP','Address must be between 4 and 35 characters long.');
define('FS_ADDRESS_STREET_PO_BOX_TIP','We do not ship to PO Boxes.');

define('FS_ADDRESS_POSTAL_REQUIRED_TIP','Your ZIP/postal can\'t be empty.');
define('FS_ADDRESS_POSTAL_MSG','Your ZIP/postal code should be at least 3 characters long.');

define('FS_ADDRESS_COUNTRY_MSG','Your Country is required.');
define('FS_ADDRESS_STATE_MSG','Your state is required.');

define('FS_ADDRESS_PHONE_REQUIRED_TIP','Your phone number can\'t be empty.');
define('FS_ADDRESS_PHONE_MSG','Your phone number must be at least 6 digits.');
define('FS_ADDRESS_PHONE_NEW_MSG','Must be digit; at least 6 digits; at most 15 digits.');

define('FS_ADDRESS_UP_ADDRESS','Update Address');
define('FS_ADDRESS_NEW','New Address');
define('FS_ADDRESS_NEW_PLEASE','Please complete this form to add a new address, then click the add button.');
define('FS_ADDRESS_ADD','Add Address');
define('FS_ADDRESS_DELETE','Delete address successfully !');
define('FS_ADDRESS_SET_SUCCESS','Set default address successfully !');
define('FS_ADDRESS_UP_SUCCESS','Update address successfully .');
define('FS_ADDRESS_ADD_SUCCESS','Add address successfully .');
//po相关语言包
define("FS_PO_ADDRESS_01",'Will you submit this address as your PO address?');
define("FS_PO_ADDRESS_02",'Your application has been submitted successfully, please wait for the notice');
define("FS_PO_ADDRESS_03",'Note');
define("FS_PO_ADDRESS_04",'After you successfully place this order, it will need review for your order security as the shipping address is not the one marked with "PO" icon.');
define("FS_PO_ADDRESS_05",'confirm the address');
define("FS_PO_ADDRESS_06",'re-select the address');
define("FS_PO_ADDRESS_07",'Edit credit limit');
define("FS_PO_ADDRESS_08",'Increase the amount');
define("FS_PO_ADDRESS_09",'Yes');
define("FS_PO_ADDRESS_10",'No');
define("FS_PO_ADDRESS_11",'Your remaining credit is insufficient, would you like to increase the credit limit?');
define('FS_ADDRESS_SET_PO_SUCCESS','Your PO address has been submitted, please wait for approval');
/*manage_order相关页面*/
define('MANAGE_ORDER_STATUS','Order Status');
define('MANAGE_ORDER_HISTORY','Order History');
define('MANAGE_ORDER_ORDER','Order #:');
define('MANAGE_ORDER_SHIPMENT','Delivery');
define('MANAGE_ORDER_INFORMATION','Order Information');
define('MANAGE_ORDER_DATE','Order Date');
define('MANAGE_ORDER_PAYMENT','Payment Method');
define('MANAGE_ORDER_SEE','See All');
define('MANAGE_ORDER_PO','PO NO.');
define('MANAGE_ORDER_RMA_NO','RMA NO./ID');
define('MANAGE_ORDER_TEL','tel');
define('MANAGE_ORDER_NOT','Not set yet');
define('MANAGE_ORDER_SHIPPING','Shipping Address');
define('MANAGE_ORDER_PRODUCT','Product');
define('MANAGE_ORDER_ITEM','Item Price');
define('MANAGE_ORDER_QUANTITY','Quantity');
define('MANAGE_ORDER_TOTAL','Total');
define('MANAGE_ORDER_QTY','Qty');
define('MANAGE_ORDER_WRITE','Write a Review');
define('MANAGE_ORDER_PRINT','Print Invoices');
define('MANAGE_ORDER_REORDER','Reorder');
define('MANAGE_ORDER_TIME','Processing Time');
define('MANAGE_ORDER_INFO','Process Information');
define('MANAGE_ORDER_OPERATOR','Process Operator');
define('MANAGE_ORDER_COMMODITY','Commodity Processing');
define('MANAGE_ORDER_MSG','Cancel your order successfully !');
define('MANAGE_ORDER_ALL','All Orders');
define('MANAGE_ORDER_PENDING','Pending Orders');
define('MANAGE_ORDER_COMPLETED','Completed Orders');
define('MANAGE_ORDER_CANCELLED','Canceled Orders');
define('MANAGE_ORDER_RMA','RMA');
define('MANAGE_ORDER_PLACED','Order Placed');
define('MANAGE_ORDER_SHIPING','Ship to');
define('MANAGE_ORDER_DETAILS','Order Details');
define('MANAGE_ORDER_INVOICE','Print Invoice');
define('MANAGE_ORDER_BUY','Buy Again');
define('MANAGE_ORDER_VIEW','View More Goods in Order');
define('MANAGE_ORDER_PAY','Pay Now');
define('MANAGE_ORDER_CANCEL','Cancel Order');
define('MANAGE_ORDER_DOWNLOAD_INVOICE','Download Invoice');
define('MANAGE_ORDER_RETURN','Return/Replace');
define('MANAGE_ORDER_RESTORE','Restore Order');
define('MANAGE_ORDER_MONTH','Latest Month');
define('MANAGE_ORDER_THREE_MONTHS','Latest 3 Months');
define('MANAGE_ORDER_YEAR','Latest Year');
define('MANAGE_ORDER_YEAR_AGO','One Year Ago');
define('MANAGE_ORDER_SEARCH_NO','PO/Order NO./ID');
define('MANAGE_ORDER_HEADER','Order canceling request has been submitted successfully, please wait for processing.');
define('MANAGE_ORDER_EA','ea.');
// add by aron 2017.7.17
define("MANAGE_ORDER_PURCHASE_ORDER",'Purchase Order');
define("MANAGE_ORDER_UPLOAD_PO_FILE",'Upload PO File');
define("MANAGE_ORDER_UPLOAD_PURCHASE_ORDER",'Upload Purchase Order');
define("MANAGE_ORDER_UPLOAD_MESAAGE",'Your order will not ship until valid PO document is received within 5 days.');
define("MANAGE_ORDER_UPLOAD_FILE_TEXT",' Choose File ');
define("MANAGE_ORDER_UPLOAD_ERROR","Allowed file types: PDF, JPG, PNG. Max filesize is 4MB.");
define("MANAGE_ORDER_UPLOAD_SUBMIT","Upload");
define("MANAGE_ORDER_UPLOAD_LABEL",'File Upload');




/*sales_service页面*/
define('FS_SALES_CHOOSE','Choose Items to Return');
define('FS_SALES_ALL','All');
define('FS_SALES_RETURN','Return');
define('FS_SALES_CONTINUE','Continue');
define('FS_SALES_SELECT','Please select your products');
define('FS_SALES_CONFIRM','Cancel this RMA?');
/*sales_service_info页面*/
define('FS_SALES_REASONS','RMA CONFIRMATION');
define('FS_SALES_PLEASE','Please select Service Type');
define('FS_SALES_REFUND','Return&Refund');
define('FS_SALES_REPLACE','Replacement');
define('FS_SALES_MAINTENANCE','Maintenance');
define('FS_SALES_WHY','Why are you returning this?');
define('FS_SALES_NO','No Longer Needed');
define('FS_SALES_INCORRECT','Incorrect Product or Size Ordered');
define('FS_SALES_MATCH',"Didn't match description");
define('FS_SALES_DAMAGED','Damaged upon arrival');
define('FS_SALES_RECEIVED','Received wrong item');
define('FS_SALES_NOT','Not as expected');
define('FS_SALES_NO_REASON','No reason');
define('FS_SALES_OTHER','Other');
define('FS_SALES_COMMENTS','Comments (required)');
define('FS_SALES_NOTE','NOTE');
define('FS_SALES_WE',"We aren't able to offer policy exceptions in response to comments");
define('FS_SALES_WRITE','Please write down your problem.');
define('FS_SALES_SUCCESSFUL','successfull');
define('RMA_TRACK_STATUS','Track Status');
define('RMA_SERVICE_TYPE','Service Type');
define('RMA_REASON','Reasons for Service');
/*sales_service_details*/
define('SALES_DETAILS_CONFIRM','Confirm Receipt');
define('SALES_DETAILS_RECEIPT','Receipt Confirmation');
define('SALES_DETAILS_SUBMIT','Submit RMA Application');
define('SALES_DETAILS_REJECT','Rejected');
define('SALES_DETAILS_APPROVED','Approved');
define('SALES_DETAILS_RETURN','Return');
define('SALES_DETAILS_RMA','RMA Received');
define('SALES_DETAILS_NEW','New Shipment');
define('SALES_DETAILS_REFUND','Refund');
define('SALES_DETAILS_COMPLETE','Complete');
define('SALES_DETAILS_SEND','How To Send Back ');
define('SALES_DETAILS_SEND_MSG',' Please do follow below flowchart to return items, about “create shipping label”,  you may do it on an express company\'s website or getting it from a courier\'s location, If you think the shipping label should be created and paid by FS.COM, please call +1 253 2773058 or email service.us@fs.com.');
define('SALES_DETAILS_FROM','Return from');
define('SALES_DETAILS_EDIT','Edit');
define('SALES_DETAILS_DELIVER','Deliver to');
define('SALES_DETAILS_FILL','Fill In The Awb');
define('SALES_DETAILS_AWB','Please fill in the AWB so that our logistics track returned parcel(s), once we receive it (them), replacement, refund or maintenance will be processed soon.');
define('SALES_DETAILS_TRACKING','Tracking Number');
define('SALES_DETAILS_PLEASE','Please write down the tracking number.');
define('SALES_DETAILS_PRINT','Print RMA');
define('SALES_DETAILS_PRINT_MSG','RMA can help us distinguish your parcel(s) so as to process your RMA request to next step more quickly. Please print it and attach it with the returned parcel(s).');
define('SALES_DETAILS_STEP_CONFIRM','Confirm Address');
define('SALES_DETAILS_STEP_PRINT','Print RMA Form');
define('SALES_DETAILS_STEP_ATTACH','Attach RMA Form');
define('SALES_DETAILS_STEP_CREATE','Create Shipping Label');
define('SALES_DETAILS_STEP_SHIP','Ship It');
define('SALES_DETAILS_CANCEL','Cancel');

/*售后流程状态提示*/
define('SALES_MSG_APPROVED','Your RMA Application has been approved, please return parcel(s) to us.');
define('SALES_MSG_SUBMIT','Your RMA Application has been submitted, please wait for result of review.');
define('SALES_MSG_RETURN','Thanks for returning parcel(s) to us, our logitstics deparment will pay attentions to shipping status.');
define('SALES_MSG_COMPLETE','The RMA has been completed.');

//2017.6.6		add		ery   manage_orders & account_history_info
define('F_RECEIPT_CONFIRMATION','Receipt Confirmation');
define('F_REFUNDED_PROCESSING','Refunded Processing');
define('MANAGE_ORDER_ARE','Are you sure you have received all items? ');
define('MANAGE_ORDER_YES','Yes');
define('MANAGE_ORDER_NO','No');

//2017.6.7
//define('FS_THEA_CTUAL_SHIPPING_TIME','The actual shipping time may vary with the estimated time, it depends on handling time, destination zip code, shipping service selected and receipt of cleared payment.');
define('FS_THEA_CTUAL_SHIPPING_TIME','We are always devoted to offering the fastest delivery with multi-warehouse system. Learn more about our <a href="'.zen_href_link('shipping_delivery').'">shipping policy</a>.');
//manage_orders & sales_service_list  2017.6.10		add 	ery
define('MANAGE_ORDER_SEARCH','Search all orders');
define('MANAGE_ORDER_FILTER','Filter orders');
define('MANAGE_ORDER_BACK','Back');
define('MANAGE_ORDER_APPLY','Apply');
define('MANAGE_ORDER_TYPE','Order Type');
define('MANAGE_ORDER_TIME_FILTER','Time filter');
define('FS_PLEASE_W_REVIEW','Write down your comments...');
define('ACCOUNT_TOTAL','Subtotal');
define('ACCOUNT_OF_SHIPPING','Shipping Cost:');
define('ACCOUNT_OF_TOTAL','Total:');
define('ACCOUNT_OF_GSP_TOTAL_AU','Total Inc. GST');
define("MANAGE_ORDER_VIEW_PO","View my PO");
define("MANAGE_PO_NUMBER","PO/ID#");
define('FS_REVIEWS_COMMENT_DEACRIPTION','You need to be signed or create an account before leaving comments.');

//2017.8.3 add by frankie
define('TITLE_RELARED_DES',"Every transceiver is individually tested on corresponding equipment such as Cisco, Arista, Juniper, Dell, Brocade and other brands, passed the monitoring of FS.COM intelligent quality control system.");
define('TITLE_RELARED_01','40GBASE-SR4 QSFP+ 850nm 150m MTP/MPO Transceiver for MMF');
define('TITLE_RELARED_02','QSFP28 100GBASE-SR4 850nm 100m Transceiver');
define('TITLE_RELARED_03','40GBASE-LR4 and OTU3 QSFP+ 1310nm 10km LC Transceiver for SMF');
define('TITLE_RELARED_04','QSFP28 100GBASE-LR4 1310nm 10km Transceiver');
define('TITLE_RELARED_05','Compatible Brand');

//税后价公用语言包 add dylan 2020.5.13
define('FS_BLANKET_32','Delivery Cost');
define('FS_BLANKET_33','Total GST Amount');
define('FS_BLANKET_34','Total');
define('FS_BLANKET_35','Inc. GST');

//2017.8.9 		add 	ery  税号
define('FS_VAT_PLEASE_REQUIRED','TAX/VAT is required.');
define('FS_VAT_PLEASE','Valid TAX/VAT eg:DE123456789');
define('FS_VAT_NO','No VAT Number');
define('FS_CHECK_OUT_STATE','please select states');
define('FS_CHECK_OUT_PLEASE','Please enter your Country');
define('FS_CHECK_OUT_INVALID','Invalid phone number, try again.');
define('FS_CHECK_OUT_NEED','Need help');
define('FS_CHECK_OUT_LIVE','Live Chat');
define('FS_CHECK_OUT_EMAIL','Email Now');
define('FS_CHECK_OUT_TAX','Tax');
define('FS_CHECK_OUT_TAX_RU','Tax');
define('FS_CHECK_OUT_ORDER','Order Summary');
define('FS_CHECK_OUT_REMARKS','Add Order Comments');
define('FS_CHECK_OUT_CHANGE','Edit');
define('FS_CHECK_OUT_ADD','Add a new address');
define('FS_CHECK_OUT_REVIEW','Review Items and Shipping');
define('FS_CHECK_OUT_YOUR','Your item');
define('FS_CHECK_OUT_ADDRESS','Your addresses');
define('EMAIL_CHECKOUT_COMMON_VAT_COST','Vat/Tax');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2','VAT');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR','Vat/Tax');
define('FS_CHECK_OUT_INCLUDEING','(Including Taxes)');
define('FS_CHECK_OUT_EXCLUDING','(Excluding Taxes)');

define('FS_CHECK_OUT_EXCLUDING_CA','(Above total does not include any possible <a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">taxes</a>)');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE','(Excluding Taxes)');

define('FS_CHECK_ADDRESS_TYPE',"Address Type");
define('FS_CHECK_OUT_ADTYPE_TIT',"The Address Type can't be empty");
define('FS_CHECK_OUT_COMPANY_TIT',"The company name can't be empty");

//checkout 运输方式
define('FS_CHECK_OTHERS','Others');
//2017.8.15 add  全站通用常量
define('FS_SER_COMMON_EMALl','Sales@fs.com');
define('FS_EMAIL','Sales@fs.com');
//2017.8.24  add  ery checkout页面地址公司类型
define('FS_CHECK_OUT_SELECT','Please Select');
define('FS_CHECK_OUT_BUSINESS','Business');
define('FS_CHECK_OUT_INDIVIDUAL','Residential');
//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS','UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS','UPS Express Next Day 12:00');

//add by aron
define('FS_CHECK_ADDRESS_TYPE',"Address Type");
define('FS_CHECK_OUT_ADTYPE_TIT',"The Address Type can't be empty");
define('FS_CHECK_OUT_COMPANY_TIT',"The company name can't be empty");
define('FS_CHECK_OUT_UPDATE_NEW_TITLE',"Update Your Shipping Address");
define('FS_CHECK_OUT_UPDATE_NEW_TITLE2',"Billing Address Information");

//add by frankie 2017.9.1
define('FS_DHLG','DHL Express Domestic');
define('FS_DHLE','DHL Economy');
define('FS_DHLEE','DHL Express Worldwide');
//add by frankie 2017.9.7
define('FS_WAREHOSE_CA_TIP','Free shipping on orders over US$ 79 dispatched from U.S. Warehouse');
define('FS_WAREHOSE_EU_TIP','Free delivery on orders over €79 dispatched from EU (Germany) Warehouse');
define('FS_WAREHOSE_OTHER_TIP','FS.COM Multiple-warehouse system makes sure the fastest delivery to ');
define('FS_WAREHOSE_AU_TIP','Free delivery on orders over AU$ 99 dispatched from AU Warehouse');
define('FS_USCA_SHIPPING_TIP','Free shipping on orders over C$ 105 dispatched from U.S. Warehouse');
define('FS_USMX_SHIPPING_TIP','Free Shipping on Orders over MXN$ 1,600 dispatched from U.S. Warehouse');
define('FS_DECA_SHIPPING_TIP','Free delivery on orders over C$ 105 dispatched from EU (Germany) Warehouse');
define('FS_DEMX_SHIPPING_TIP','Free delivery on orders over MXN$ 1,600 dispatched from EU (Germany) Warehouse');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 免运费提示信息（每个站点显示不一样。不是直接翻译的）
define('FS_HEADER_FREE_SHIPPING_US_TIP','Free shipping on orders over $MONEY');
define('FS_FOOTER_FREE_SHIPPING_US_TIP','Free Shipping');
define('FS_HEADER_FREE_SHIPPING_DE_TIP','Free shipping on orders over $MONEY');
define('FS_FOOTER_FREE_SHIPPING_DE_TIP','Free Shipping');
define('FS_HEADER_FREE_SHIPPING_AU_TIP','Free Delivery on Orders of Eligible Items over A$189 dispatched from AU warehouse');
define('FS_FOOTER_FREE_SHIPPING_AU_TIP','Free Delivery');
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP','Same Day Shipping on a Broad Selection of Stock Items');
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP','Same Day Shipping');
define('FS_HEADER_FREE_SHIPPING_USFR_CA','Free Shipping on Orders of Eligible Items over C$ 105');
define('FS_FOOTER_FREE_SHIPPING_USFR_CA','Free Shipping');
define('FS_HEADER_FREE_SHIPPING_USMX_MX','Free Shipping on Orders of Eligible Items over MXN$ 1,600');
define('FS_FOOTER_FREE_SHIPPING_USMX_MX','Free Shipping');
// 2020-2-17 m端开头文字显示
define('FS_M_FREE_SHIPPING_USMX_MX','Free Shipping on Orders over MXN$ 1,600');
define('FS_M_FREE_SHIPPING_USFR_CA','Free Shipping on Orders over C$ 105');
define('FS_M_SHIPPING_US_TIP','Free Shipping on Orders over US$ 79');
define('FS_M_FREE_SHIPPING_DE_TIP','Free Delivery on Orders over EUR $MONEY');
define('FS_M_FREE_SHIPPING_AU_TIP','Free Delivery on Orders over A$99');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','Fast Shipping to');
define('FS_M_SHIPPING_DELIVERY_RU','Free Shipping over 20 000 ₽');

//2017-9-12  ery   add 层级属性定制提示语
define('PROINFO_CUSTOM_WAVE','Write down other wavelength according to your needs.');
define('PROINFO_CUSTOM_GRID','Write down other grid channel according to your needs.');
define('PROINFO_CUSTOM_RATIO','Write down other coupling ratio according to your needs.');
//2017-9-16   ery
define('GET_A_QUOTE','Get a Quote');
//add  by  ery  2017-10-12    产品详情页stock list板块
define('FS_STOCK_LIST_OTHER_ID','ID');
define('FS_STOCK_LIST_CENTER','Center Wavelength (nm)');
define('FS_STOCK_LIST_CHANNEL','Channel');
define('FS_STOCK_LIST_CWDM','CWDM SFP/SFP+');
define('FS_STOCK_LIST_DWDM','10G DWDM SFP+ 80km');
define('FS_DOWNLOAD','Download');
define('FS_DOWNLOADS', 'Downloads');
define('FS_STOCK_LIST','Stock List');
define('FS_STOCK_LIST_RECOM','Matching Products');
define('FS_STOCK_LIST_ADD_TO_CART','Add to Cart');
define('FS_STOCK_LIST_PIC','Pictures');
define('FS_STOCK_LIST_ID','ID#');
define('FS_STOCK_LIST_DESC','Description');
define('FS_STOCK_LIST_PRICE','Price');
define('FS_STOCK_LIST_STOCK','Stock');
define('FS_STOCK_OPTION','Option');

//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_INSTALLATION','Installation:');
define('FS_PRODUCT_INSTALLATION_TEXT','<a href="'.zen_href_link('product_info','products_id=30408','SSL').'" style="color: #0070BC;">FMU-1UFMX-N</a> chassis that can be mounted on a rack');
define('FS_PRODUCT_INSTALLATION_TEXT2','Pluggable Module fit in ');
define('FS_PRODUCT_INSTALLATION_TEXT3','FMT04-CH1U');
define('FS_PRODUCT_INSTALLATION_TEXT4',' chassis that can be mounted on a rack');
define('FS_PRODUCT_INSTALLATION_TEXT5','LGX cassette fits in <a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a> chassis that can be mounted on a rack');
define('FS_PRODUCT_INFO_STEP','Step');

//2019.1.10 详情页评论
define('FS_REVIEWS34',' Helpful votes');
define('FS_REVIEWS35',' Helpful vote');
define('FS_REVIEWS_STARS_TITLE','out of 5 stars');

//2017-12-1  dylan     产品详情页Customization属性
//define('FS_PRODUCT_CUSTOMIZATION','Note:');
define('FS_PRODUCT_CUSTOMIZATION_TEXT','FMU Plug-in Module fits in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1','FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2','Pluggable Module fits in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3','FUD Plug-in module fits in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4','FMU-1UFMX');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5',' chassis that can be mounted on a rack');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6','FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7','Plug-in type fits in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8','FS-2U-RC001');
define('FS_PRODUCT_ITEM','Item ID: ');
//2017-11-2   add  ery  国家下拉框搜索提示语
define('FS_COUNTRY_SEARCH','Search your country/region');

//2017-11-9 ternence add all email languages
/*
 *客户保留购物车产品，邮件发给自己
 */
define('FS_EMAIL_CART','Your cart list is waiting for you.');
define('FS_EMAIL_PAST','Past you was shopping on ');
define('FS_EMAIL_FS','FS.COM');
define('FS_EMAIL_SAVED','and saved the item list for your later using.  Use the links below to find details about all these items and shop on');
define('FS_EMAIL_FSCOM',zen_href_link('index'));
define('FS_EMAIL_MESSAGE','Your Message:');
define('FS_EMAIL_LIST',zen_href_link('save_shopping_list'));
define('FS_EMAIL_SIN','Sincerely,');
define('FS_EMAIL_TEAM','Customer Service Team');
define('FS_EMAIL_SENT','This email was sent by your own using ');
define('FS_EMAIL_SHARE',"'s Share With A Friend service. As a result of receiving this message, you will not receive any unsolicited message from ");
define('FS_EMAIL_OUR',", learn more about our ");
define('FS_EMAIL_POLICY',"Privacy Policy");
define('EMAIL_CUSTOMER_SHOPPING_LIST',zen_href_link('share_shopping_list'));
/*
 *客户分享购物车邮件（不同部分）
 */
define('FS_EMAIL_SENT_1','This email was sent by ');
define('FS_EMAIL_CART_1','Your Friend');
define('FS_EMAIL_CARTS_1','has shared a cart list with you!');
define('FS_EMAIL_PAST_1',' thought that you’d like to check out these items from FS.COM. Here’s the list for you. Use the links below to find details about all these items and shop on ');
define('FS_EMAIL_MESSAGE_1',"Message:");
define('FS_EMAIL_THIS_1','This email was sent by your friend');
define('FS_EMAIL_USING_1','using');
define('FS_EMAIL_URL_1',HTTPS_SERVER.reset_url('policies/privacy_policy.html'));
/*
 * 客户分享产品邮件
 */
define('FS_EMAIL_PRODUCT_SHARE1','Your friend only share this item for you via ');
define('FS_EMAIL_PRODUCT_SHARE2','FS.COM.');
define('FS_EMAIL_PRODUCT_SHARE3','I thought you might be interested in this page from ');
define('FS_EMAIL_PRODUCT_SHARE4','Learn More');
define('FS_EMAIL_PRODUCT_SHARE5','Sincerely,');
define('FS_EMAIL_PRODUCT_SHARE6','FS.COM');
define('FS_EMAIL_PRODUCT_SHARE7',' Customer Service Team ');
define('FS_EMAIL_PRODUCT_SHARE8','This email was sent by ');
define('FS_EMAIL_PRODUCT_SHARE9','\'s Share With A Friend service. As a result of receiving this message, you will not receive any unsolicited message from ');
define('FS_EMAIL_PRODUCT_SHARE10',zen_href_link('index'));
define('FS_EMAIL_SHARE_TITLE_ONE','FS.COM - Your friend ');
define('FS_EMAIL_SHARE_TITLE_TWO',' wants you to see this item.');
define('FS_EMAIL_PRODUCT_SHARE11','Message from ');
define('FS_EMAIL_PRODUCT_SHARE13',',learn more about our');
define('FS_EMAIL_POLICY_2',"");
define('FS_EMAIL_PRODUCT_USING',' using ');
/*
 *客户联系客服email to us
 */
define('FS_EMAIL_TO_US_TITLE','FS.COM - Customer Service Auto Response Email');
define('FS_EMAIL_TO_US_CONTACT','Thanks for taking your time to contact ');
define('FS_EMAIL_TO_US_DEAR','Dear ');
define('FS_EMAIL_TO_US_SYSTEM','This is a system email to let you know we have received your request. ');
define('FS_EMAIL_TO_US_TEAM','Sales Team will start resolving your issues and get back to you within 12 hours.');
define('FS_EMAIL_TO_US_REQUIRE','If you require immediate attentions, please call us directly at ');
define('FS_EMAIL_TO_US_FHONE','+1 877 205 5306');
define('FS_EMAIL_TO_US_OR','(US) or');
define('FS_EMAIL_TO_US_TEL','tel:+49 (0) 89 414176412');
define('FS_EMAIL_TO_US_PHONES','+49 (0) 89 414176412');
define('FS_EMAIL_TO_US_YOU','(Germany). You may also');
define('FS_EMAIL_TO_US_LIVE',' live chat');
define('FS_EMAIL_TO_US_GET',' to get quick response.');
define('FS_EMAIL_TO_US_SALES',' Sales Team');
define('FS_EMAIL_TO_US_URL',reset_url('service/fs_support.html'));

/**
 *评论邮件
 */
define('EMAIL_MESSAGE_TITLE_REVIEWS',' Feedback Received');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS-Thanks for your feedback.');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','We are so grateful for your kind words and delighted to hear that you had such a great experience interacting with our team.');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','Feedback like this helps us constantly improve our customer experiences by knowing what we are doing right and what we can work on.');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','We\'re sorry your experience did not match your expectations. It was an uncommon instance and we\'ll do better.');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','Please be assured that your account manager will reach out to you within 48 hours. Sincerely hope to work with you to resolve any issues as quickly as possible.');
define('FS_EMAIL_REVIEWS_THANKS','Thanks');
define('FS_EMAIL_REVIEWS_TEAM','The FS Team');
define('FS_EMAIL_REVIEWS_WELL_HEADER','Thanks for your review and we will continue to offer the best products as usual.');
define('FS_EMAIL_REVIEWS_BAD_HEADER','Thanks for your review and we will help you solve the issue asap.');
/*
 * 客户在My account里问销售问题-发给销售和客户
 */
define('FS_EMAIL_MY_ACCOUNT_TITLE','FS.COM - Question Feedback Update');
define('FS_EMAIL_MY_ACCOUNT_YOUR','Your question is under processing.');
define('FS_EMAIL_MY_ACCOUNT_FOR','Thanks for submitting your question. Your sales representative will start resolving your questions and get back to you within 12 hours.');
define('FS_EMAIL_MY_ACCOUNT_TIT','Title');
define('FS_EMAIL_MY_ACCOUNT_CON','Content');
define('FS_EMAIL_MY_ACCOUNT_IF','If you require immediate attentions, please call us directly at ');
define('FS_EMAIL_MY_ACCOUNT_PHONE','+1 (877) 205 5306');
define('FS_EMAIL_MY_ACCOUNT_OR',' (US) or ');
define('FS_EMAIL_MY_ACCOUNT_TEL','tel:+49 (0) 89 414176412');
define('FS_EMAIL_MY_ACCOUNT_PHONES','+49 (0) 89 414176412');
define('FS_EMAIL_MY_ACCOUNT_MAY','. You may also ');
define('FS_EMAIL_MY_ACCOUNT_URL',reset_url('service/fs_support.html'));
define('FS_EMAIL_MY_ACCOUNT_LIVE','live chat');
define('FS_EMAIL_MY_ACCOUNT_GET',' to get quick response.');
/*
 * 线上PO订单上传邮件
 */
define('FS_EMAIL_MY_PO_UP_TITLE','FS.COM - PO# Confirmed for Purchase Order# ');
define('FS_EMAIL_MY_PO_UP_TITLES','Confirmed for Purchase Order# ');
define('FS_EMAIL_MY_PO_UP_PO','Your PO# ');
define('FS_EMAIL_MY_PO_UP_HAS','has been uploaded successfully.');
define('FS_EMAIL_MY_PO_UP_THANK','Thank you for the PO documents, you could now view the PO and print the invoice via \'');
define('FS_EMAIL_MY_PO_UP_ORDER','Order No.: ');
define('FS_EMAIL_MY_PO_UP_NO',' PO NO.: ');
define('FS_EMAIL_MY_PO_UP_WILL','Your order will be processed soon, if you have any further questions regarding your order, please feel free to ');
define('FS_EMAIL_MY_PO_UP_CONTACT','contact us');
define('FS_EMAIL_MY_PO_UP_SIN','Sincerely,');
define('FS_EMAIL_MY_PO_UP_CUS',' Customer Service Team ');
define('FS_EMAIL_MY_PO_UP_MY','My orders');
define('FS_EMAIL_MY_PO_UP_NOW','\' now. ');
define('FS_EMAIL_MY_PO_UP_URL',zen_href_link('manage_orders'));
define('FS_EMAIL_MY_PO_UP_URLS',zen_href_link('contact_us'));
/*
 * 线上PO订单确认邮件
 */
define('FS_EMAIL_MY_PO_UP_RUR','FS.COM - Purchase Order Confirmation for Order# ');
define('FS_EMAIL_MY_PO_UP_FOR','Thank you for shopping with ');
define('FS_EMAIL_MY_PO_UP_YUOR','Thank you for your purchase order! Here is your order details. It is awaiting for PO confirmation now.');
define('FS_EMAIL_MY_PO_UP_NOR','Order No: ');
define('FS_EMAIL_MY_PO_UP_GO','Please go to \'');
define('FS_EMAIL_MY_PO_UP_PAGE','\' page to upload the PO file if you have not already done so. We\'re not able to process your order until your PO has been confirmed. ');
define('FS_EMAIL_MY_PO_UP_IF','If you have any further questions regarding your order, please feel free to ');
define('FS_WRITE_OTHER_DEVICES','eg: Cisco N9K-C9396PX');
define('HPE_LIMIT','Please choose "VAL_XXX" compatibility for your order due to its special material and then note down model numbers.');
define('HPE_LIMIT2','"VAL_XXX" compatibility is not available for your order due to its special material.');
define('model_number_empty','Please fill in the model number of your device.');

//运费公共
define('FIBER_CHECK_TWO', 'UPS 2nd Day Air® service');
define('FIBER_CHECK_TWO_AM','UPS 2nd Day A.M.® service');
define('FIBER_CHECK_STAND','UPS Ground® ');
define('FIBER_CHECK_ONE', 'UPS Next Day-Afternoon® service');
define('FIBER_SHIPPING_MONDAY_DELIVERY',' (Monday Delivery)');
define('FIBER_FEDEX_CHECK_OVER','FedEx Overnight® service');
define('FIBER_FEDEX_CHECK_TWO','FedEx 2Day® service');
define('FIBER_FEDEX_CHECK_GROUND','FedEx Ground® ');
define('FIBER_CHECK_USE','Use my own shipping account');
define('FIBER_CHECK_FREE','Free');
define('FIBER_CHECK_FREE_SHIPPING','Free');

//2017-11-22   ery add  层级属性breakout length 提示语
define('PROINFO_CUSTOM_LENGTH','Please note that when the total cable length is not more than 1m, the euqal breakout lenghth is 0.3m instead of 0.5m.');
define('FS_WRITE_OTHER_DEVICES','write your devices');

//2017-12-2  add   ery  产品无库存是的提示语
define('FS_PRODUCTS_CUSTOMIZED','Customized');
define('FS_COMMON_LEVEL_WAS','Was');
define('FS_COMMON_LEVEL_WAS_1','was');
//2017-12-13  add  ery 公用的tt账号语言包
define('FS_COMMON_TT_BANK','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Beneficiary Bank Name: </td>
							<td><b>HSBC Hong Kong</b></td>
						  </tr>
						  <tr>
							<td>Beneficiary A/C Name: </td>
							<td><b>FS.COM LIMITED</b></td>
						  </tr>
						  <tr>
							<td>Beneficiary A/C NO: </td>
							<td><b>817-888472-838</b></td>
						  </tr>
						  <tr>
							<td>SWIFT Address: </td>
							<td><b>HSBCHKHHHKH</b></td>
						  </tr>
						  <tr>
							<td>Beneficiary Bank Address: </td>
							<td><b>1 Queen\'s Road Central, Hong Kong</b></td>
						  </tr>
					  </table>');
//2017-12-14  ery  add  manage_orders和account_history_info页面reorder提示语
define('FS_COMMON_REORDER_CLOSE','Sorry, the following item(s) might have been removed and is no longer available for purcahse.');
define('FS_COMMON_REORDER_CUSTOM','Below is customized product(s) , please re-choose the characters in product introduction.');
define('FS_COMMON_REORDER_SKIP','Skip and Continue');

define("FS_POPUP_TIT_ALERT","A signature is required for delivery. We do not ship to PO Boxes.");
define("FS_POPUP_TIT_ALERT_NOT_PO","A signature is required for delivery.");
define("FS_POPUP_TIT_ALERT2","We do not ship to PO Boxes");
//2017-12-15  ery  add  前台相关打印发票页面的公司地址
// 武汉仓
define('FS_COMMON_WAREHOUSE_CN','ATTN: FS. COM LIMITED<br> 
			Address: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China<br>
			Tel: +86-0755-83571351');
// 深圳仓
define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> China');
// 德国仓
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany<br>
			Tel: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States <br>
			Tel: +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','ATTN: FS.COM Inc.<br>
					Address: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States<br>
					Tel: +1 (888) 468 7419');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Tel: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: (65) 6443 7951<br>
				GST Reg No.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','ATTN: FS Tech Pte Ltd.<br>
				Address: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: +(65) 6443 7951');
// 俄罗斯仓
define('FS_COMMON_WAREHOUSE_RU','《FiberStore.COM》Ltd.<br>
				No.4062, d. 6, str. 16<br>
				Proektiruemyy proezd<br>
				Moscow 115432<br>
				Russian Federation<br>
				Tel: +7 (499) 643 4876');
define("QTY_SHOW_ZERO","pc in");
define("QTY_SHOW_MORE","pcs in");
define("QTY_SHOW_ZERO_STOCK","pc");
define("QTY_SHOW_MORE_STOCK","pcs");
define("QTY_SHOW_ZERO_STOCK_1"," In Stock");
define("QTY_SHOW_MORE_STOCK_2"," In Stock");
define("QTY_SHOW_AVAILABLE","Available");
define("QTY_SHOW_AVAILABLE_NEW_INFO","In Transit");
define("QTY_SHOW_AVAILABLE_TAG_NEW_INFO","Need Transit");
define('QTY_SHOW_IN_CN_STOCK_1','In Stock');


define("FS_WAREHOUSE_AREA_SG","ship from SG Warehouse");
define("FS_WAREHOUSE_AREA_PR",'ship from FS United States');
//分仓分库语言包
define("FS_WAREHOUSE_AREA_1","ship from Asia Warehouse");
define("FS_WAREHOUSE_AREA_2","ship from U.S. Warehouse");
define("FS_WAREHOUSE_AREA_3","ship from DE(Germany) Warehouse");
define("FS_WAREHOUSE_AREA_4","- Available for immediate shipment");
define("FS_WAREHOUSE_AREA_5","- Available for shipment estimated on ");
define("FS_WAREHOUSE_AREA_6","Items will be delivered in ");
define("FS_WAREHOUSE_AREA_7","separate shipment. ");
define("FS_WAREHOUSE_AREA_8","Item");
define("FS_WAREHOUSE_AREA_9","Item Price");
define("FS_WAREHOUSE_AREA_10","Qty");
define("FS_WAREHOUSE_AREA_11","Price");
define("FS_WAREHOUSE_AREA_12","Please go to '");
define("FS_WAREHOUSE_AREA_13","My Orders");
define("FS_WAREHOUSE_AREA_14","' page to upload the PO file if you have not already done so. We're not able to process your order until your PO has been confirmed.");
define("FS_WAREHOUSE_AREA_15","Thanks for shopping in");
define("FS_WAREHOUSE_AREA_16",". Below is the summary of your order, please confirm and <a href='https://www.fs.com/index.php?main_page=manage_orders' target='_blank' style='color:#0070BC; text-decoration:none;'>complete the payment</a> if there is no problem.");
define("FS_WAREHOUSE_AREA_16_1",". Below is the summary of your order, please confirm and complete the payment if there is no problem.");
define("FS_WAREHOUSE_AREA_17","Thank you for ordering from FS.COM! We have received your order and are awaiting processing. ");
define("FS_WAREHOUSE_AREA_18","Thank you for shopping at FS.COM . Your order #");
define("FS_WAREHOUSE_AREA_19"," placed on ");
define("FS_WAREHOUSE_AREA_20"," has been received. Yet it is still unpaid. If you still need the items, you can send the payment to our company's paypal account directly: paypal@fs.com.");
define("FS_WAREHOUSE_AREA_21","If there is any problems or questions with the paypal payment, please feel free to contact us at ");
define("FS_WAREHOUSE_AREA_22","Not set yet");
define("FS_WAREHOUSE_AREA_23","Order Received, Awaiting Processing");
define("FS_WAREHOUSE_AREA_24","has been received. Yet it is still unpaid.");
define("FS_WAREHOUSE_AREA_25","If there is any problems or questions with the Credit/Debit card payment, please feel free to contact us at");
define("FS_WAREHOUSE_AREA_26","Order received, pending");
define("FS_WAREHOUSE_AREA_27","If there is any problems or questions with the");
define("FS_WAREHOUSE_AREA_28","please feel free to contact us at");
define("FS_WAREHOUSE_AREA_29","Order NO.:");
define("FS_WAREHOUSE_AREA_30","Ship Via:");
define("FS_WAREHOUSE_AREA_31","order on FS.COM...");
define("FS_WAREHOUSE_AREA_32","Thank you for your purchase order! Here is your order details. It is awaiting for PO confirmation now.");
define("FS_WAREHOUSE_AREA_33","Thank you for your purchase order! Here is your order details.</br>Note: The shipping address does not match addresses on your credit application form, this order will need review and result will be emailed to you within 12 hours.");
define("FS_WAREHOUSE_AREA_34","Thank you for your purchase order! Here is your order details.</br>Note: The shipping address does not match addresses on your credit application form and the order amount exceeds your credit limit in FS.COM. To get this order processed
 quickly, please pay off the previous orders to revolve credit limit, or you can go to “My account” and click “Purchase Order” to apply for increasing your credit limit, we will email you the result after a review.");
define("FS_WAREHOUSE_AREA_35","Thank you for your purchase order! Here is your order details.</br>Note: The order amount exceeds your credit limit in FS.COM. To get this order processed quickly, please pay off the previous orders to revolve credit limit, or you can go
 to “My account” and click “Purchase Order” to apply for increasing your credit limit, we will email you the result after a review.");

/*结算页交期气泡提示语*/
define("FS_WAREHOUSE_AREA_TIME_36",'The shipment was delayed due to the public holiday in U.S.');
define("FS_WAREHOUSE_AREA_TIME_37","The shipment was delayed due to the public holiday in Australia.");
define("FS_WAREHOUSE_AREA_TIME_38","The shipment was delayed due to the public holiday in Germany.");
define("FS_WAREHOUSE_AREA_TIME_39","The shipment was delayed due to the public holiday in Singapore.");
define("FS_WAREHOUSE_AREA_TIME_42","The shipment was delayed due to the public holiday in China.");
define("FS_WAREHOUSE_AREA_TIME_40","The shipment was delayed due to the weekend.");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">Close</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","Pick up at U.S. Warehouse on desirable time");
define("FS_WAREHOUSE_AREA_TIME_44","Pick up at DE(Germany) Warehouse on desirable time");
define("FS_WAREHOUSE_AREA_TIME_45","Pick up at AU Warehouse Warehouse on desirable time");
define("FS_WAREHOUSE_AREA_TIME_46","Pick up at Asia Warehouse on desirable time");
define("FS_WAREHOUSE_AREA_TIME_47","Pick up at SG Warehouse on desirable time");
define("FS_WAREHOUSE_AREA_TIME_48","Pick up at RU Warehouse on desirable time");
define("FS_WAREHOUSE_AREA_SHIP_CN"," from Asia Warehouse");
define("FS_WAREHOUSE_AREA_SHIP_US"," from U.S. Warehouse");
define("FS_WAREHOUSE_AREA_SHIP_AU"," from AU Warehouse");
define("FS_WAREHOUSE_AREA_SHIP_DE"," from DE(Germany) Warehouse");
define("FS_WAREHOUSE_AREA_SHIP_SG"," from SG Warehouse");
define("FS_WAREHOUSE_AREA_SHIP_RU"," from RU Warehouse");
define("FS_PICK_UP_WAREHOUSE", "Pick up at warehouse");
//产品详情页长度定制框语言包
define('FS_LENGTH_CUSTOM_FEET','Feet Or');
define('FS_LENGTH_CUSTOM_METER','Meter');
define('FS_PRODUCTS_AOC_LENGTH_ERROR','Cable length could be customized from 0.5m to 100m(1.64ft to 328.084ft) as you required.');

define("CHECKOUT_EIDT_TIT_FS","* Please edit and update your address");
define("CHECKOUT_EIDT_TIT_FS1","Edit Your Shipping Address");
define("CHECKOUT_EIDT_TIT_FS2","Edit your Billing Address");
define("CHECKOUT_EIDT_TIT_FS3","* Please edit and update your billing address");

//游客页面注册
define("REGITS_FROM_GUEST_EMAIL_ERROR1","Email address is required.");
define("REGITS_FROM_GUEST_EMAIL_ERROR2","Enter valid email address. (eg:someone@gmail.com)");
define("REGITS_FROM_GUEST_EMAIL_ERROR3","Enter valid email address.");
define("REGITS_FROM_GUEST_PASSWORD_ERROR1","6 characters minimun; at least one letter and one number");
define("REGITS_FROM_GUEST_PASSWORD_ERROR2","Password must match.");
define("REGITS_FROM_GUEST_ASK","Would you like to create an account now?");
define("REGITS_FROM_GUEST_CAN","Just one more step to gain a better service. With a FS account, you can:");
define("REGITS_FROM_GUEST_EASY","Easy tracking via your order history");
define("REGITS_FROM_GUEST_FASTER","Faster checkout with an address book");
define("REGITS_FROM_GUEST_NO","No, thanks.");
define("REGITS_FROM_GUEST_YES","Yes, I'd like to create an account.");
define("REGITS_FROM_GUEST_USE","Use my checkout email");
define("REGITS_FROM_GUEST_OR","OR");
define("REGITS_FROM_GUEST_HISTORY","If your checkout and registered email addresses are different, they will be associated, and order information will be sent to the registered email address with which you can sign in your FS.COM account, manage and track your orders any time.");
define("REGITS_FROM_GUEST_PASWORD","Password");
define("REGITS_FROM_GUEST_CPASWORD","Confirm Password");
define("REGITS_FROM_GUEST_NOTE",'Note: Your phone number is only used to contact you on delivery, as well as your email address to update the order status.<br>You can visvit <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Privacy and Cookies policy</a> for more information.');
define("REGITS_FROM_GUEST_EXSIT1","The email address exists in our system, please log in directly. &nbsp;&nbsp;&nbsp;&nbsp;");
define("REGITS_FROM_GUEST_EXSIT2","Login in »");
define("REGIST_NUM_LENGTH","6-character minimum");
define("REGIST_NUM_LEAST","6 characters minimun; at least one letter and one number.");

//2017-12-29   ery  add  sales_service_details
define('SALES_DETAILS_PRINT_LABEL','Print Prepaid Shipping Label');
define('SALES_DETAILS_LABEL_MSG','FS.COM allows you to print prepaid shipping labels for shipments from the convenience of any computer with Internet access. 
Please include the label in the original package and drop off it at a UPS drop box nearest you.');
define('SALES_DETAILS_PSL','Print shipping label');
define('FS_SALES_DETAILS_COMMENT','Comments (required)');
define('FS_SALES_DETAILS_REVIEW','Return/Replace Review');
define('FS_SALES_DETAILS_NO','RMA NO.');
define('FS_SALES_DETAILS_STATUS','RMA Status');
define('FS_SALES_DETAILS_AMOUNT','Amount');
define('FS_SALES_DETAILS_RPI','Return Payment Information');
define('FS_SALES_DETAILS_RA','Refund Amount');
define('FS_SALES_DETAILS_RM','Refund Method');
define('FS_SALES_DETAILS_SAME','Same payment method');
define('FS_SALES_DETAILS_NOTE','Please note: Final refund amount will be in your return confirmation email.');
define('FS_SALES_DETAILS_PROCESS','RMA Process');
define('FS_SALES_DETAILS_AWB','Update AWB');
define('FS_SALES_DETAILS_ADDRESS','Address Confirming');
//2017-12-30  ery    add
define('FS_SALES_INFO_REQUEST','RMA Request');
define('FS_SALES_INFO_A','A request for a return does not gurantee an authorization number, as some items are not returnable and need to be verified.');
define('FS_SALES_INFO_PLEASE','Please review the Term & Conditions of Sale for our Return Policy. You will be noticed within 24 hours if your return has been approved or denied.');
define('FS_SALES_INFO_YOU','You can submit up to ');
define('FS_SALES_INFO_WHAT','What is the reason for return?');
define('FS_SALES_INFO_QI','Quality Issues');
define('FS_SALES_INFO_SI','Service Issues');
define('FS_SALES_INFO_OI','Other Issues');
define('FS_SALES_INFO_WE',"We aren't able to offer policy exceptions in response to comments");
define('FS_SALES_INFO_ATTA','Attachment');
define('FS_SALES_INFO_ALLOW','Allow files of type PDF, JPG, PNG.');
define('FS_SALES_INFO_ADD','Add photo');
define('FS_SALES_INFO_VERIFY','Verify RMA Address');
define('FS_SALES_INFO_KIND','Kind remind');
define('FS_SALES_INFO_OUR','Our After-Sale center may give a call to you, please keep your phone unblocked.');
define('FS_SALES_INFO_I','I agree to the ');
define('FS_SALES_INFO_RP','Return Policy');
define('FS_SALES_INFO_PLEASE_AGREE','Please agree to the Return Policy to continue.');
define('FS_SALES_INFO_PLEASE_WRITE','Please write down your problem.');
define('FS_SALES_INFO_ITEMS','Items did not work properly');
define('FS_SALES_INFO_MIS','Mismatch in size');
define('FS_SALES_INFO_DID','Did not match description');
define('FS_SALES_INFO_RE','Received wrong items');
define('FS_SALES_INFO_UN','Unable to ship when i need them');
define('FS_SALES_INFO_DA','Damaged upon arrival');
define('FS_SALES_INFO_NO','No longer needed');
define('FS_SALES_INFO_NOT','Not as expected');
define('FS_SALES_INFO_WRONG','Order wrong items');
define('FS_MANAGE_ORDERS_PO','PO NO.');
define('FS_MANAGE_ORDERS_RE','Reviewed');
define('FS_MANAGE_ORDERS_TN','Track Number');
define('FS_MANAGE_ORDERS_MORE','More');
define('FS_MANAGE_ORDERS_RECORDA','records per page');
define('FS_MANAGE_ORDERS_PURCHASE',"Purchase order number can't be empty");
define('FS_MANAGE_ORDERS_OC',"Order Comments");
define("FS_MANAGE_ORDERS_FILE","Please upload your PO file.");
//2018-1-3   ery    add
define('FS_SALES_DETAILS_RAE','Returns Are Easy');
define('FS_SALES_DETAILS_NO_LABEL','Please follow the flowchart below to return items. We provide you with a return shipping address, and you provide and pay for your own mailing label using the carrier of your choice. Please update your tracking number to us. If you have any questions, please contact us for immediate help.');
define('FS_SALES_DETAILS_LABEL','Please follow the flowchart below to return items. We provide you with a pre-paid shipping label for your return package and take it to an authorized UPS shipping location, this option allows you to track your package on its way back to us.');
define('FS_SALES_DETAILS_CR','Cancel RMA');
//2018-1-8   ery  add   产品详情页未勾选属性的提示语
define('FS_PRODUCT_INFO_ATTR_PLEASE','Please select an option for each attribute.');

//2018 1-9.aRON 游客邮件
define("FS_GUEST_EMAIL_THANK","as a guest");
define("FS_GUEST_EMAIL_CONTACT","We will update you on the order status with this email address. If you have any further questions regarding your order, please feel free to ");

define("CHECKOUT_TAXE_US_TIT","About Sales Tax & About Duty and Tax");
define("CHECKOUT_TAXE_US_FRONT","If items are shipped from our U.S. Warehouse to an address within Washington State, a 10% sales tax will be charged in accordance with Washington State tax laws. However, if you are able to provide a valid tax exemption certificate for the state(s) where you are located, no sales tax will be collected. Items shipped to Canada and Mexico are free of sales tax but buyer will be responsible for custom clearance and duty tax. When placing your order online, we will only charge the shipping fee and exclude any tariff from the order total (FS.COM default). If needed, FS.COM can help arrange to pre-pay the DUTY TAX.");
define("CHECKOUT_TAXE_US_BACK","For dispatch from CN Warehouse, FS.COM will only charge the items and shipping fee when placing an order. These packages may, however, be assessed import or customs fees, depending on the laws of the particular countries. Any customs or import duties are levied once the package reaches the destination country. Additional charges for customs clearance would have to be borne by the recipient; we have no control over these charges and cannot predict what they might be. Since customs policies vary widely from country to country, you may want to contact your local customs office for further information. If needed, FS.COM can help arrange to pre-pay the DUTY TAX.");

define("CHECKOUT_TAXE_CN_TIT","About Duty and Tax");
define("CHECKOUT_TAXE_CN_TIT1","About Duties and Taxes");
define("CHECKOUT_TAXE_CN_FRONT","For orders shipped from our Asia Warehouse, we will ONLY charge product value and shipping fees. No sales tax(ex. VAT or GST) will be charged. However, the packages may be assessed import or customs duties, depending on the laws/regulations of the particular countries. <b>Any tariff or import duties caused by customs clearance should be declared and borne by the recipient.</b> If you need help to pre-pay the customs duty, please contact us.");

define("CHECKOUT_TAXE_SG_TIT", "About GST and Tariff");
define("CHECKOUT_TAXE_SG_FRONT", "For orders dispatched from Singapore warehouse and delivered to locations within Singapore, FS is obliged to charge GST on product value and shipping fees at the rate of 7%.<br/><br/> If the product(s) you order is not currently in stock, we will ship them directly from Asia warehouse (China) and charge NO GST. However, these packages may be assessed import or customs duties. Any tariff or import duties caused by customs clearance should be declared and borne by the recipient.");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "About Duty and Tax");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "For orders delivered to the destinations outside Singapore, we will only charge product value and shipping fees. No sales tax (ex. VAT or GST) will be charged. However, the packages may be assessed import or customs duties, depending on the laws/regulations of the particular countries. Any tariff or import duties caused by customs clearance should be declared and borne by the recipient.");

define("CHECKOUT_TAXE_DE_TIT","About VAT & About Duty and Tax");
define("CHECKOUT_TAXE_DE_FRONT","All items will be shipped out from Germany warehouse, and in accordance with the laws governing members of the European Union, FS.COM GmbH is obliged to charge VAT on all orders delivered from Germany to destinations in member countries of the EU.");
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>Destination Country</div><div>VAT &amp; Tariff</div></div><div class=\"help-center-taTr\"><div>Germany</div><div>A 19% VAT will be charged.</div></div><div class=\"help-center-taTr\"><div>France and Monaco</div><div>A 20% VAT will be charged, but if a valid EU VAT Identification Number is offered, VAT will be exempted.</div></div><div class=\"help-center-taTr\"><div>Netherlands, Spain, Belgium</div><div>A 21% VAT will be charged, but if a valid EU VAT Identification Number is offered, VAT will be exempted.</div></div><div class=\"help-center-taTr\"><div>Italy</div><div>A 22% VAT will be charged, but if a valid EU VAT Identification Number is offered, VAT will be exempted.
</div></div><div class=\"help-center-taTr\"><div>Sweden</div><div>A 25% VAT will be charged, but if a valid EU VAT Identification Number is offered, VAT will be exempted.</div></div><div class=\"help-center-taTr\"><div>Other EU Members</div><div>A 19% VAT will be charged, but if a valid EU VAT Identification Number is offered, VAT will be exempted.</div></div><div class=\"help-center-taTr\"><div>Non-EU countries</div><div>VAT will not be charged, but customs clearance will be borne by your own. </div></div></div>");
define('FS_PRICE_LOW_HIGH', 'Price: Low to High');
define('FS_PRICE_HIGH_LOW', 'Price: High to Low');
define('FS_RATE_HOGH', 'Rate: High to Low');
define('FS_NEWEST_FIRST', 'Newest First');
define('FS_POPULARITY', 'Popularity');

define("CHECKOUT_TAXE_NEW_CN_CONTENT","Products in stock in our U.S. Warehouse will be shipped directly from Delaware to any destinations in the U.S.. FS.COM will ONLY charge the product value and shipping fees. No any Sales Tax will be charged.<br/><br/>If the orders contain items that are temporarily out of stock in U.S. Warehouse, we will ship them to you directly from our Asia Warehouse to expedite the delivery speed. If the product has “Free Shipping” message on the product page, FS.COM will bear all the possible duties and tariffs caused by import clearance.<br/><br/>For the products that DO NOT have “Free Shipping” message on the product page, they are heavy or oversize items. They will be shipped directly from Asia Warehouse and can not receive the free shipping service. And any possible charges caused by customs clearance should be borne by yourself.");
define("CHECKOUT_TAXE_NEW_CA_CONTENT","Products in stock in our U.S. Warehouse will be shipped directly from Delaware to any destinations in Canada.<br/><br/>If the orders contain items that are temporarily out of stock in U.S. Warehouse, we will ship them to you directly from our Asia Warehouse to expedite the delivery speed. <br/><br/>When you place the order online, FS.COM will ONLY charge the product value and shipping fees. Any possible duties and tariffs caused by customs clearance should be borne by yourself.");
define("CHECKOUT_TAXE_NEW_MX_CONTENT","Products in stock in our U.S. Warehouse will be shipped directly from Delaware to any destinations in Mexico.<br/><br/>If the orders contain items that are temporarily out of stock in U.S. Warehouse, we will ship them to you directly from our Asia Warehouse to expedite the delivery speed. <br/><br/>When you place the order online, FS.COM will ONLY charge the product value and shipping fees. Any possible duties and tariffs caused by customs clearance should be borne by yourself.");



//春节设置,请勿乱修改,1->开启春节分仓 0->关闭春节分仓
define("FS_IS_SPRING",0);
define("CN_SPRING_WAREHOUSE_MESSAGE","Note: The items from CN warehouse will not be shipped until Spring Holiday (Feb.6, 2018 - Feb.20, 2018) is over.");

//2018-1-22    ery  add   sales_service_info页面
define('FS_SALES_INFO_NUMBER','Series Number');
define('FS_SALES_INFO_FOR','For transceivers,&nbsp;please kindly provide the serial number, so that we can  better identify and solve the problem.');
define('FS_SALES_INFO_BRIEFLY','Briefly recount the problem');
define('FS_REFUND_PROCESSING','Refund processing');
define('FS_REFUND_APPLICATION','Refund Application');
define('FS_REFUND_SUCCESS_MSG','Refund successfully, please check the bill statement of your payment account.');
define('FS_REFUND_FAIL_MSG','Sorry, your refund application is declined. If you have any questions, please contact us.');
define('FS_REFUND_APPMSG','Your refund application is in progress, result will be updated here soon.');


define("FS_EMPTY_COST","We are sorry that all logistics companies do not offer shipping services to your district at present, please use your own shipping account to pay the shipping cost. However, we can help you enquire real-time shipping cost from other third forwarders, if you are interested, please <a href='".zen_href_link('contact_us')."'>contact us</a>.");
define("FS_RU_SPRING","During Chinese Spring Festival (6.02.2018-20.02.2018), all orders delivered to courntires outside European Union will be shipped out from our warehouse in USA. But due to the Russia customs restrictions,  only EMS from China is the safest way to Russia while our warehouse in USA only supports DHL and UPS. Therefore, your order(s) will be shipped from our warehouse in China after the holiday.  We apologize for any inconvenience we may cause you and thanks for your cooperation in advance.");

define("FS_QTY_CHANGED","please complete your payment ASAP so that your order can be handled at the first time. Otherwise your order might be delayed on delivery due to the storage change.");

//helun 客户提出问提成功
define('FS_MODIFY_EMAIL_MY_CASE_01','Your Case');
define('FS_MODIFY_EMAIL_MY_CASE_02','confirmed here.');
define('FS_MODIFY_EMAIL_MY_CASE_03','Thank you for contacting <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>, this is a confirmation email to let you know that your request for support has been received under case');
define('FS_MODIFY_EMAIL_MY_CASE_04','Our <a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> sales team will review your case and get back to you within 12 hours.');
define('FS_MODIFY_EMAIL_MY_CASE_05','If you require immediate attentions, please call us at <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (888) 468 7419</a> (US), or <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Germany). You may also live chat to get a quick response.');
define('FS_MODIFY_EMAIL_MY_CASE_06','Sincerely,');
define('FS_MODIFY_EMAIL_MY_CASE_07','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Customer Service Team ');
define('FS_MODIFY_EMAIL_MY_CASE_08','Dear');
define('FS_MODIFY_EMAIL_MY_CASE_09','FS.COM - Case Number: ');

//客户追问成功
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_01','New Reply from');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_02','on Case');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_03','Dear All,');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_04','Customer');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_05','had replied the case as following:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_06','-Sales.Rep:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_07','-Engineer:');

//request_stock
define("FS_EMAIL_REQUEST_STOCK_01","FS.COM - Request Stock & Case Number: ");
define("FS_EMAIL_REQUEST_STOCK_02","Your request for more stock of item #");
define('FS_EMAIL_REQUEST_STOCK_11',' has been received.<br />
									Case No. :');
define("FS_EMAIL_REQUEST_STOCK_03","Dear ");
define("FS_EMAIL_REQUEST_STOCK_04","Thanks for submitting the stock request. Your inventory needs data is very important to us. A dedicated sales will get in touch with you to follow up your detail demands. Meanwhile, ");
define("FS_EMAIL_REQUEST_STOCK_05"," Inventory Management team will refer to your stock needs and optimize our inventory plan. ");
define('FS_EMAIL_REQUEST_STOCK_06','If you require immediate attentions, please call us at <a href="tel:+1 (888) 468 7419" style="color:#232323; text-decoration:none;">+1 (888) 468 7419</a> (US), or <a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a> (Germany). You may also live chat to get a quick response.');
define('FS_EMAIL_REQUEST_STOCK_07','Sincerely,');
define('FS_EMAIL_REQUEST_STOCK_08','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> Customer Service Team ');
define('FS_EMAIL_REQUEST_STOCK_09','Dear');
define('FS_EMAIL_REQUEST_STOCK_10','FS.COM - Case Number: ');

define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | Mon. - Fri.');
define("FS_JS_TIT_CHECK1","</br>Pickup Time: ");
define("FS_JS_TIT_CHECK2","Pacific Time：");
define("FS_JS_TIT_CHECK3","Monday - Friday");
define("FS_JS_TIT_CHECK4","10:00am - 12:00am ");
define("FS_JS_TIT_CHECK5",", 2:00pm - 5:30pm ");
define("FS_JS_TIT_CHECK_US","9:30am - 5:30pm");
define("FS_TIME_ZONE_RULE_US","(UTC/GMT+1)");
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}
define("FS_TIME_ZONE_RULE_AU","(AEST)");
define("FS_JS_TIT_CHECK_AU","9:30am - 5pm ");
define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00am - 5:00pm ");
//新增pickup自提语言包 Aron 2018.9.6
define("FS_PICK_UP_AT_WAREHOUSE","Pickup at warehouse ");
define("FS_TIME_ZONE_RULE_US_ES"," (EST)");
define("FS_TIME_ZONE_ADDRESS_US","<span>Warehouse Location:</span> 820 SW 34th Street Bldg W7 Suite H Renton, WA 98057, United States | +1 (877) 205 5306 ");
define("FS_TIME_ZONE_ADDRESS_DE","<span>Warehouse Location:</span> NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany | +49 (0) 8165 80 90 517 ");
define("FS_TIME_ZONE_ADDRESS_US_ES","<span>Warehouse Location:</span> 380 Centerpoint Blvd, New Castle, DE 19720, United States | +1 (888) 468 7419 ");
define("CN_SPRING_WAREHOUSE_MESSAGE1","Note: The order ");
define("CN_SPRING_WAREHOUSE_MESSAGE2","dispatched from CN warehouse will not be shipped until the Chinese Spring Festival (Feb.6, 2018 - Feb.20, 2018) is over.");

define("FS_ADDRESS_MESSAGE3","Street address, c/o");
define("FS_ADDRESS_MESSAGE4","Apartment, suite, unit, buliding, floor, ect.");
define('FS_COMMON_TT_BANK_DE','<table cellspacing="0" cellpadding="5" border="0" class="m_yh_information">
						  <tr>
							<td>Beneficiary Bank Name:  </td>
							<td><b>Sparkasse Freising</b></td>
						  </tr>
						  <tr>
							<td>Beneficiary A/C Name: </td>
							<td><b> '.FS_DE_COMPANY_NAME.'</b></td>
						  </tr>
						  <tr>
							<td>IBAN: </td>
							<td><b>DE16 7005 1003 0025 6748 88</b></td>
						  </tr>
						  <tr>
							<td>BIC: </td>
							<td><b> BYLADEM1FSI</b></td>
						  </tr>
						  <tr>
							<td>Account Number: </td>
							<td><b>25674888</b></td>
						  </tr>
                          <tr>
							<td>Beneficiary Bank Address: </td>
							<td><b>Untere Hauptstr.29, 85354, Freising</b></td>
						  </tr>
					  </table>');
define('FIBERSTORE_INFO_WIRE_DE','Sparkasse Bank Account');
define("FS_HSBC_INFO1","Beneficiary Bank Name");
define("FS_HSBC_INFO2","Beneficiary A/C Name");
define("FS_HSBC_INFO3","IBAN:");
define("FS_HSBC_INFO4","BIC:");
define("FS_HSBC_INFO5","Account Number:");
define("FS_HSBC_INFO6","Beneficiary Bank Address:");

//fairy 整理公共的
// 公共表单
define('FS_TAX_ERROR_EMPTY','Please enter a valid tax number.');
define('FS_SECURITY_ERROR', 'There was a security error.'); // token验证不正确
define('FS_SYSTME_BUSY', 'The system is busy. Please try again later'); // 异步提交，连接服务器出现error情况
define('FS_ACCESS_DENIED', 'Error: Access denied.'); //没有权限访问
define('FS_ACCESS_DENIED_1', 'Error: code 999.');
define('FS_FORM_REQUEST_ERROR','Sorry, we’ve encountered an error while processing your request. Please refresh the page and try again.');
define('FS_NON_MANDAROTY',"Non mandatory");
define('FS_COMMON_SAVE',"Save");
define('FS_COMMON_CANCEL',"Cancel");
define('FS_COMMON_YES',"Yes");
define('FS_COMMON_NO',"No");
define('FS_COMMON_SUBMIT',"Submit");
define('FS_COMMON_PROCESSING',"Processing");
define('FS_COMMON_EDIT','Edit');
define('FS_COMMON_LESS',"Less");
define('FS_CONFIRM','Confirm');
define("FS_PLEASE_CHOOSE_ONE",'Please choose one...');
define("FS_WRONG_TIP",'Oops, wrong!');

//验证码 start
define('FS_ENTER_CHARACTER',"Enter the character you see");
define('FS_IMAGE_REQUIRED_TIP',"Please enter the characters in the image.");
//验证码-服务器端的验证
define('FS_IMAGE_ERROR_TIP',"The characters are incorrect. Please try again.");
define('FS_IMAGE_EXPIRE_TIP',"Due to long time there is no operation, please refresh the characters and re-enter again.");
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP',"To better protect your account, please re-enter your password and then enter the character as they are shown in the image below.");
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP',"To better protect your account, please re-enter your email and then enter the character as they are shown in the image below.");
//验证码 end

// 公共的
define('FS_USERNAME','Username');
define('FS_FIRST_NAME',"First Name");
define('FS_LAST_NAME',"Last Name");
define('FS_PASSWORD',"Password");
define('FS_EMAIL_ADDRESS',"Email Address");
define('FS_EMAIL_ADDRESS1',"E-mail address");
define('FS_COMPANY_WEBSITE',"Company website");
define('FS_INDUSTRY',"Industry");
define('FS_COMPANY_NAME',"Company Name");
define('FS_ENTERPRISE_OWNER_NAME',"Enterprise owner name");
define('FS_YOUR_COUNTRY',"Your Country/Region");
define('FS_COUNTRY','Country/Region:');
define('FS_OTHER_COUNTRIES','Other Countries');
define('FS_SELECT_YOUR_COUNTRY_REGION','Select your Country/Region');
define('FS_SELECT_COUNTRY_REGION','Select Country/Region');
define('FS_COMMON_COUNTRY_REGION','Common Country/Region');
define('CURRENT','current');
define('MAIN_MENU','Main Menu');
define('FS_SELECT_CURRENCY','Select Language/Currency');
define('FS_LANGUAGE_CURRENCY','Language/Currency');
define('FS_VAT_NUMBER',"VAT/TAX Number");
define('FS_PHONE_NUMBER',"Phone Number");
define('FS_COMMON_COMPANY','Company');
define('FS_FOOTER_COMPANY_INFO',"Company");
define('FS_QTY','QTY');
define('FS_OPTIONAL_COMPANY',' (optional)');
// 公共的
define('FS_OR', 'or');
define('FS_OTHERS','Others');
define('FS_LOADING',"Loading");
define('FS_SHOW',"show");
define('FS_HIDE',"hide");
define('FS_HELLO','Hello');
define('FS_SORT','Sort');
define('FS_COMMON_MORE','More');
define('FS_COMMON_CUSTOMIZED','Customized');
// 公共的
define('FS_COPY',"Copyright");
define('FS_RIGHTS',"All Rights Reserved");
define('FS_TERMS_OF_USE',"Terms of Use");
define('FS_POLICY',"Privacy Policy");
define('FS_AGREE_POLICY','By clicking the button below, you agree to our <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'" target="_blank">Privacy Policy</a> and <a href="'.HTTPS_SERVER.reset_url('policies/terms_of_use.html').'" target="_blank">Terms of Use.</a>');
define('FS_FOOTER_COOKIE_TIP','We use cookies to ensure that we give you the best experience on our website. By continuing to use this site you agree to our use of cookies in accordance with our <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie Policy</a>.');

define('FS_FOOTER_COOKIE_TIP_NEW','We use cookies to ensure that we give you the best experience on our website. By clicking on "Accept Cookies" or continuing to use this site, you agree to our use of cookies <br />in accordance with our <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie Policy</a>. You can refuse the use of cookies <a href="javascript:;" class="refuse_cookie_btn_google">here</a>.');
define('FS_FOOTER_COOKIE_TIP_BTN','Accept Cookies');

define('FS_FOOTER_COOKIE_MOBILE_TIP','We use cookies to offer you a better shopping experience. View <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie Policy</a>.');
define('FS_I_ACCEPT','I accept');
//运费
define("FS_SHIPPING_AREA_BY_WAREHOUSE_CN","Available for immediate shipment from China warehouse");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_US","Available for immediate shipment from U.S. warehouse");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_EU","Available for immediate shipment from EU warehouse");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_CN","from China warehouse");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_US","from U.S. warehouse");
define("FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_EU","from EU warehouse");
define("FS_BULK_WAREHOUSE","Ship from CN Warehouse estimated on");
define("FREE_SHIPPING_TEXT1","Free shipping on orders over €79 (large dimension items excluded).");
define("FREE_SHIPPING_TEXT2","Free shipping on orders over $79 (large dimension items excluded).");
//2018-3-7   add   ery  产品详情页Compatible Brands属性未勾选的提示语
define('FS_PRODUCT_INFO_BRAND_PLEASE','Please choose a brand.');
define('FS_MOBILE_CLOSE','Close');


define("FS_WAREHOUSE_EU","DE Warehouse");
define("FS_WAREHOUSE_US","U.S. Warehouse");
define("FS_WAREHOUSE_CN","Asia Warehouse");
define("FS_WAREHOUSE_SG","SG Warehouse");
define("FS_WAREHOUSE_RU","RU Warehouse");
define("FS_WAREHOUSE_SEA","Seattle warehouse");
define("FS_WAREHOUSE_DEL","Delaware Warehouse");
define('FS_PRODUCT_INFO_BRAND_CHOOSE','Choose a brand');

//2018-3-15  ery  add  订单上传logo
define('FS_ATTRIBUTE_OEM','OEM/ODM Service');
define('NEWS_FS_ATTRIBUTE_OEM','Labeling Service');
define('FS_ATTRIBUTE_NONE','None');
define('FS_ATTRIBUTE_DESIGN','Design Label');

define('FS_ORDER_LOGO_DESIGN',"Upload Design Label Logo");
define('FS_ORDER_LOGO_YOUR',"Upload your design label Logo or your specific Vendor Name & Part Number for reference.");
define('FS_ORDER_LOGO_WE',"We'll confirm the label with you and process your order accordingly. You can also email us your logo.");
define('FS_ORDER_LOGO_UPLOAD',"Upload Logo");
define('FS_ORDER_LOGO_DELETE',"Delete the picture?");
define('FS_ORDER_LOGO_UP_SUCCESS','Logo File Uploaded Success!');
define('FS_ORDER_LOGO_DEL_SUCCESS','Delete Picture Successfully!');

define('FS_LIMIT_MONEY',"Total amount exceeds limitation, please split order or choose other payment method!");
define('FS_LIMIT_MONEY_15000',"Total amount exceeds limitation (€ 15000), please split order or choose other payment method!");
define('FS_LIMIT_MONEY_10000',"Total amount exceeds limitation (€ 10000), please split order or choose other payment method!");
define("FS_JS_TIT_CHECK6","Name on Photo ID");
define("FS_JS_TIT_CHECK7","Email Address");
define("FS_JS_TIT_CHECK8","Phone Number");
define("FS_JS_TIT_CHECK9","Pick up time");

define('MY_CASE_UPLOAD_1','Your solution request ');
define('MY_CASE_UPLOAD_2',' has been submitted.');
define('MY_CASE_UPLOAD_3','Dear ');
define('MY_CASE_UPLOAD_4','Thanks for contacting FS.COM Solution Support, we just received your request and created the Case ');
define('MY_CASE_UPLOAD_5',' for your solution request.');
define('MY_CASE_UPLOAD_6','We\'ll be in touch within 24 hours, please check your email then.');
define('MY_CASE_UPLOAD_7','In the meantime, you might find these resources helpful: ');
define('MY_CASE_UPLOAD_8','https://www.fs.com/Data-Center-Cabling.html');
define('MY_CASE_UPLOAD_9','https://www.fs.com/Enterprise-Networks.html');
define('MY_CASE_UPLOAD_10','https://www.fs.com/Long-haul-Transmission.html');
define('MY_CASE_UPLOAD_11','https://www.fs.com/Optic-OEM-Solution.html');
define('MY_CASE_UPLOAD_12','Data Center Cabling');
define('MY_CASE_UPLOAD_13','Enterprise Network');
define('MY_CASE_UPLOAD_14','Optical Transport Network');
define('MY_CASE_UPLOAD_15','Optic OEM Solution');
define('MY_CASE_UPLOAD_16','Sincerely,');
define('MY_CASE_UPLOAD_17',zen_href_link('index'));
define('MY_CASE_UPLOAD_18','FS.COM');
define('MY_CASE_UPLOAD_19',' Solution Support');
define('MY_CASE_UPLOAD_20','FS.COM - Solution Request & Case Number: ');

//产品详情页

//change 2018.4.28
define("FS_FOR_FREE_SHIPPING","Free Shipping ");
define("FS_SG_FREE_SHIPPING","Free Shipping and Installation ");
define("FS_SG_NO_FREE_SHIPPING","Free Installation ");
//*****
define("FS_FOR_FREE_SHIPPING_US",'on orders over $MONEY');
define("FS_FOR_FREE_SHIPPING_US_CA","on orders over C$ 105");
define("FS_FOR_FREE_SHIPPING_US_MX","on orders over MXN$ 1,600");
define('FS_FOR_FREE_SHIPPING_USFR_TO_CA','on orders over C$ 105');
define("FS_FOR_FREES_SHIPPING_ONE","Want it tomorrow");
define("FS_FOR_FREES_SHIPPING_TWO","Order by ");
define("FS_FOR_FREES_SHIPPING_TIME","4pm (PST)");
define("FS_FOR_FREES_SHIPPING_TIME_UP","5pm (EST)");
define("FS_FOR_FREES_SHIPPING_THREE","and choose  Overnight Shipping at checkout.");
define("FS_FOR_FREES_SHIPPING_FOUR","Shipping:");
define("FS_FOR_FREES_SHIPPING_FIVE","Get it within 1-3 business days  when you order by <span>4pm(PST)</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_CA_UP","Get it within 1-3 business days  when you order by <span>5pm</span>.");
define("FS_FOR_FREES_SHIPPING_FIVE_MX_UP","Get it within 1-3 business days  when you order by <span>4pm</span>.");

define("FS_FOR_FREES_SHIPPING_SIX","Want it Tuesday? Choose  Overnight Shipping at checkout.");
//change 2018.4.28

//add by quest 2019-03-11 // 2019 3.18 po产品 shipping弹窗 pico
define("FS_FOR_FREE_SHIPPING_PRE_ORDER","on orders over MONEY");
if (get_warehouse_by_code($_SESSION['countries_iso_code']) == 'cn'){
    if (in_array($_SESSION['countries_iso_code'],array('cn','hk','tw','mo'))){
        define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE',"Pre-Order Service, Mass Supply & Saving Budget");
        define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "To better serve our SMB and big enterprises, FS invests in a 10,000 square meters manufacturer and adds pre-order service oriented production lines, which can help customers cut down budget by mass production and meet the project delivery.");
        define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "The processing time of Pre-Order items is around 15 business days. Therefore, customers can arrange their purchase plans in advance for the scheduled projects.");
        define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "All items will be shipped from our Asia Factory to China Mainland, HK, Macao and Taiwan can enjoy FREE Shipping. Learn more details about <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>Pre-Order service</a>.");
    }else {
        define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE',"Pre-Order Service, Mass Supply & Saving Budget");
        define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "To better serve our SMB and big enterprises, FS invests in a 10,000 square meters manufacturer and adds pre-order service oriented production lines, which can help customers cut down budget by mass production and meet the project delivery. ");
        define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "The processing time of Pre-Order items is around 15 business days. Therefore, customers can arrange their purchase plans in advance for the scheduled projects.");
        define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "We will ship them out after manufacture and thorough test. The shipping speed will depend on the shipping method you choose during checkout. <br><br> Learn more details about <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>Pre-Order service</a>.");
    }
}else {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE',"Free Shipping on Pre-Order Items Over MONEY");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', "To qualify for free shipping, add at least MONEY of Pre-Order items to your Shopping cart. Any Pre-Order item with 'Free Shipping' on this page is eligible and contributes to your free shipping order minimum.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "The processing time for Pre-Order items will be around 15 business days. We will ship them out after manufacture and thorough test. The shipping speed will depend on the shipping method you choose during checkout.");
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "The Pre-Order service can help you schedule your project more flexible and freely. Learn more details about <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>Pre-Order service</a>.");
}
define("FS_FOR_FREE_SHIPPING_DE","Free Delivery ");

//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Warranty & Returns');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Fast Shipping to South-East Asia');
//define('FS_DELIVERY_FREE_RETURNS_CONTENT','After delivery, if there is any quality issue or you just change your mind, you can return eligible items within 30 days. Learn more about <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">Returns Policy</a> of all products sold by FS.');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','<p>If items don\'t work as expected, FS warranty may allow the items to be returned, exchanged, or repaired.</p><br/>
<p>We offer a 30-day return & refund and exchange service for most in-stock items. And within the warranty period, we still offer free repair services.</p><br/>
<p>For consumables, there is no warranty period and free repair services. If there are any quality issues after delivery, please feel free to contact us. We will handle it promptly. View <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">Return Policy</a> and <a href="'.reset_url("/policies/warranty.html").'" target="_blank">Warranty</a> page for more details.</p>');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Orders up to $MONEY or more qualify for free shipping on eligible items. For more information on how to qualify, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS provides multiple shipping options to meet your time schedule or budget. And the stock orders will be shipped within 24 business hours after order placed. For more information, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">For Pre-Order items, orders up to $MONEY or more qualify for free shipping. For more information on how to qualify, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_HK_MO_TL','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">All items delivered to HK, Macao and Taiwan can enjoy Free shipping. And the stock orders will be shipped within 24 business hours after order placed. For more information, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_RU','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Orders up to $MONEY rubles or more qualify for free shipping. For more information, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');


//***
define("FS_FOR_FREE_SHIPPING_DE_MONEY",' on orders over $MONEY');
define("FS_FOR_FREE_SHIPPING_AU",'on orders over $MONEY');
//修改2018.5.8
define("FS_FOR_FREES_SHIPPING_FIVE_DE1"," <span>4pm (UTC/GMT +2)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE2"," <span>4pm (UTC/GMT +2)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE3","Want it delivery faster? Order by <span>4pm (UTC/GMT +2)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE4"," <span>3pm (UTC/GMT +1)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE5"," <span>3:00 pm (UTC/GMT +1)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE6","Want it delivery faster? Order by <span>11:00am (UTC/GMT -3)</span> and choose DHL Express 9:00am  at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE7","Want it delivery faster? Order by <span>6:00 pm (UTC/GMT +4)</span> and choose DHL Express 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE8","Want it delivery faster? Order by <span>3:00 pm (UTC/GMT +1)</span> and choose DHL Express 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE9","Want it delivery faster? Order by <span>5:00 pm (UTC/GMT +3)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE10","<span>4pm (UTC/GMT +3)</span> and choose DHL Express 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE11","Want it delivery faster? Order by <span>12:00am (UTC/GMT -2)</span> and choose DHL Express at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE12","Ship it Tuesday and get it within 1-3 business days.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE13","Want it Tuesday? Choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE14","Want it Tuesday? Choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE15","Want it delivery faster? Choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_FOR_FREES_SHIPPING_FIVE_DE16","Want it delivery faster? Choose DHL Express at checkout.");
//......
define("FS_FOR_FREE_SHIPPING_GB1","FREE UK Delivery ");
define("FS_FOR_FREE_SHIPPING_GB3","on orders over £79");
define("FS_FOR_FREE_SHIPPING_GB4","");
define('FS_ITEM_LOCATION','Item location:');
define('FS_SEATTLE_WASHINGTON','Seattle, United States');
define('FS_SEATTLE_EU','Munich, Germany');
define('FS_SEATTLE_CN','Wuhan, China');

//详情页Compatible Brands提示 dylan 2019.11.18
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01','eg: Cisco N9K-C9396PX to Juniper MX960');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02','eg: Cisco N9K-C9396PX QSFP+ to Juniper MX960 SFP+');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03','eg: Cisco N9K-C9396PX QSFP+ to Juniper EX4200 XFP');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04','eg: Cisco N9K-C9396PX QSFP28 to Juniper QFX5200 SFP28');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05','eg: Cisco Nexus 5696Q CXP to Juniper MX960 QSFP+');

//定制产品属性类型选择
define('FS_SELECT_TYPE','The most common specifications our customers selected.');
define('FSCHOOSE_SPECI','Choose Specifications:');
define('FS_SELECT_DEFAULT','Default');
define('FS_SELECT_CUSTOMIZE','Customize');

//2018.5.5 aron
define("FS_FOR_FREES_SHIPPING_SATURDAY","and Choose Saturday Delivery at checkout.");
// 2018.4.3 fairy 报价
define('FS_GET_A_QUOTE_BIG', 'Get a Quote');
define('FS_GET_A_QUOTE_FREE', 'Request a Box');
define('FS_GET_A_QUOTE', 'Get a Quote');
define('FS_REQUEST_DEADLINE','Request was closed as scheduled. An updated version will be available soon, please stay tuned.');
//英国专用提示
define('FS_WAREHOSE_GB_TIP','Free delivery on orders over £79 dispatched from EU (Germany) Warehouse');
define("FREE_SHIPPING_TEXT_GB","Free delivery on orders over £79 (large dimension items excluded).");
//公用头部账户板块
define('FS_COMMON_HEADER_ACCOUNT','Account');
define('FS_COMMON_HEADER_CASES','Cases');
define('FS_COMMON_HEADER_NOT','Not You? ');
define('FS_COMMON_HEADER_OUT','Sign Out');
define('FS_ACCOUNT_NO','No. ');


//产品详情页新增aron
define("FS_FOR_FREE_SHIPPING_TO_FREE","Free");
define("FS_FOR_FREE_SHIPPING_TO"," Deliver to");
define("FS_FOR_FREE_SHIPPING_TO_CN","Ship on ");
define("FS_FOR_FREE_SHIPPING_TO2","Shipping to ");
define("FS_FOR_FREE_SHIPPING_ON","on");
define("FS_FOR_FREE_SHIPPING_TO3","to");
define("FS_FOR_FREE_SHIPPING_GET","get it by");
//修改2018 5.8
define("FS_DE_SHIPPING_RESET1"," <span>4pm (UTC/GMT +2)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET2"," Want it next Tuesday? Choose UPS Express Plus Next Day 9:00am at checkout.");

define("FS_DE_SHIPPING_RESET3"," <span>5:00 pm (UTC/GMT +3)</span> and choose UPS Express Plus Next Day 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET4","Want it delivery faster? Order by <span>3pm (UTC/GMT +1)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET5","Want it delivery faster? Choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET6","Want it delivery faster? Order by <span>4:00 pm (UTC/GMT +2)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET7","Want it delivery faster? Order by <span>3:00 pm (UTC/GMT +1)</span> and choose DHL Express 9:00am at checkout.");
define("FS_DE_SHIPPING_RESET8","morning");

define("FS_SHIPPING_POLICY_US","The delivery date applies to the inventory items purchased by 5pm EST on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_CA","The delivery date applies to the inventory items purchased by 5pm on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_MX","The delivery date applies to the inventory items purchased by 4pm on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_NZ","The delivery date applies to the inventory items purchased by 3:00pm (AEST/AEDT) on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_AU","The delivery date applies to the inventory items purchased by 3:00pm (AEST/AEDT) on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_GB","The delivery date applies to the inventory items purchased by ".FS_SUMMER_OR_WINTER_TIME." on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_DE","The delivery date applies to the inventory items purchased by ".(SUMMER_TIME ? '4:30pm (UTC/GMT+2)' : '4pm (UTC/GMT+1)')." on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_CN","The delivery date applies to the inventory items purchased by 3:30pm (GMT+8) on business days. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_SG","The delivery date applies to the inventory items purchased by 3:30pm (GMT+8) on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_RU","The delivery date applies to the inventory items purchased by 10:30am (UTC/GMT+3) on business days. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");

define("FS_FESTIVAL1","Public Holiday in Germany starts on");
define("FS_FESTIVAL2","FS.COM GmbH will be back on");
define("FS_FESTIVAL3"," in Germany Warehouse.");
define("FS_FESTIVAL4","st");
define("FS_FESTIVAL5","nd");
define("FS_FESTIVAL6","Public Holiday in U.S. starts on");
define("FS_FESTIVAL7"," in U.S. Warehouse.");
define("FS_FESTIVAL8","Orders placed during the holiday will be line-up processed on");
define("FS_FESTIVAL8_01","Orders placed during the holiday will be line-up processed on");

define("FS_FESTIVAL13","Public Holiday in Melbourne starts on");
define("FS_FESTIVAL14"," in Melbourne Warehouse.");
define("FS_FESTIVAL15","Orders placed during the holiday will be line-up processed on");


define("FS_PRODUCTS_SHIPPING_CHANGE1","Choose your delivery location");
define("FS_PRODUCTS_SHIPPING_CHANGE2","Delivery Options and delivery speeds may vary for different lications");
define("FS_PRODUCTS_SHIPPING_CHANGE3","Sign in to see your addresses");
define("FS_PRODUCTS_SHIPPING_CHANGE4","or enter a US zip code");
define("FS_PRODUCTS_SHIPPING_CHANGE5","Deliver to");
define("FS_PRODUCTS_SHIPPING_CHANGE6","Change");
define("FS_PRODUCTS_SHIPPING_CHANGE7","The goods do not deliver to <font class='choice_country'>Germany</font>.shall we switch to the corresponding region?");
define("FS_PRODUCTS_SHIPPING_CHANGE8","Apply");
define("FS_PRODUCTS_SHIPPING_CHANGE9","See more");
define("FS_PRODUCTS_SHIPPING_CHANGE10","Manager address book");
define("FS_PRODUCTS_SHIPPING_CHANGE11","Order by 4pm(PST) will be shipped out today");
define("FS_PRODUCTS_SHIPPING_CHANGE12","or");
define("FS_PRODUCTS_SHIPPING_CHANGE13","Add a new address");
define("FS_PRODUCTS_SHIPPING_CHANGE14","Please enter a valid US zip code");
define("FS_PRODUCTS_SHIPPING_CHANGE15","Ship outside the US");
define("FS_PRODUCTS_SHIPPING_CHANGE16","Please enter the zip code or choose the country which you will ship to.");
define("FS_PRODUCTS_SHIPPING_CHANGE17","Submit");

define("FS_FESTIVAL9","th");
define("FS_FESTIVAL10","rd");
define("CHECKOUT_TAXE_CN_FRONT1","All orders shipped from our Asia Warehouse to China Mainland, HK, Macao and Taiwan can enjoy FREE Shipping (to Mainland, default SF Express and Fedex IE by default to HK, Macao and Taiwan).");
define("CHECKOUT_TAXE_CN_FRONT2","While, in accordance with the Law of the People's Republic of China on the Administration of Tax Collection (hereinafter referred to as LATC), FS.COM is obliged to charge 13% VAT on all orders delivered to China Mainland. And for orders dispatched to HK, Macao and Taiwan, no VAT is charged but these packages may be assessed import or customs fees, depending on the laws/regulations of the particular destinations. Additional charges for customs clearance must be born by the recipient.");
define('FS_ADDRESS_SHIPPING_ERROR','Sorry, Shipping Address should be at least 3 characters long.');

//add by quest
define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG','(Including GST)');

//新增加
define('FS_CHECK_OUT_TAX_AU','GST');
define('FS_ORDERS_DETAILS_TAX_AU','Total GST Amount');
define('FS_CHECK_OUT_EXCLUDING_AU','(Excluding GST)');
define('FS_CHECK_OUT_INCLUDING_AU','(Including GST)');
define("FS_WAREHOUSE_AREA_AU","ship from AU Warehouse");
define("CHECKOUT_TAXE_AU_TIT","About GST and Tariff");
define("CHECKOUT_TAXE_AU_CONTENT", "In accordance with the <em class='alone_font_italic'>A New Tax System (Goods and Services Tax) Act 1999</em>, for dispatch from Melbourne Warehouse, FS.COM PTY LTD is obliged to charge GST on all orders delivered to locations within Australia. All items in our category are subject to the regular GST rate of 10% accordingly. After you have completed the order information, you will be able to see the total amount inclusive of applicable GST in order summary.</br></br>For orders with products unavailable in our Melbourne Warehouse, we may ship them upon arrival at Melbourne after transferred from Asia Warehouse.</br></br>For orders containing heavy or oversized items, we will ship them to you from Asia Warehouse directly. In this case, no GST is charged when placing the order. But the packages may be assessed import or customs fees, depending on the laws. Any tariff or import duties caused by customs clearance should be declared and borne by yourself.");
define("FS_WAREHOUSE_AU","AU Warehouse");
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU','GST');
define('PRODUCTS_SHIP_TODAY','Ship Today');
define('ITEM_LOCATION_AU','Melbourne, Australia ');
define('FS_COMMON_WAREHOUSE_AU','FS.COM Pty Ltd<br>
			ABN 71 620 545 502 <br>
			Room 2314, HWT Tower,<br>
			40 City Road, Southbank,<br>
			Melbourne VIC 3006, Australia<br>
			Tel: +61 (2) 8317 1119');
define('FS_LOGIN_REGIST_PWD_REQUIRED_TIP_COMMON',"Password is required.");
define('FS_LOGIN_REGIST_EMAIL_FORMAT_TIP_COMMON',"Enter valid email address.(eg:someone@gmail.com)");
define('FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_COMMON',"Email address is required.");
define('FS_LOGIN_REGIST_PWD_ERROR_TIP_COMMON',"Your password is not correct, check it again please !");
define('FS_LOGIN_REGIST_EMAIL_NOT_FOUND_ERROR_COMMON',"Error: The Email Address was not found in our records; please try again.");
define('FS_LOGIN_REGIST_LOGIN_BANNED_COMMON', 'Error: Access denied.');
define("FS_LOGIN_POPUP1","Session Timed Out");
define("FS_LOGIN_POPUP2","Your session has timed out and you have been logged off.");
define("FS_LOGIN_POPUP3","Re-enter your password to continue.");
define("FS_LOGIN_POPUP4","Email address");
define("FS_LOGIN_POPUP5","Not you?");
define("FS_LOGIN_POPUP6","Password");
define("FS_LOGIN_POPUP7","Forgot your password?");
define("FS_LOGIN_POPUP8","show");
define("FS_LOGIN_POPUP9","hide");
define("FS_ADDRESS_EDIT_TITLE","Edit Address");
define('FS_CHECK_OUT_TAX_DE','VAT/Tax');
define('FS_COMMON_WAREHOUSE_US_ES','FS.COM INC.<br>
			380 Centerpoint Blvd,<br>
			New Castle, DE 19720,<br>
			United States<br>
			Tel: +1 (888) 468 7419');
define("CHECK_SEARCH","Search");
define("GLOBAL_TEXT_NAME","Cardholder Name");
define("FS_CHECKOUT_ERROR29","Please edit your address(enter the valid postal code).");

define('FS_SHARE_CART_06','Account Manager. ');

//add ternence 2018-7-9
define('FS_SHOP_CART_ALERT_JS_50','Item(s)');
define('FS_SHOP_CART_ALERT_JS_51','Subtotal (');
define('FS_SHOP_CART_ALERT_JS_52','):');
define('FS_SHOP_CART_ALERT_JS_53','Summary');
define('FS_SHOP_CART_ALERT_JS_54','(Shipping and taxes not included)');
define('FS_SHOP_CART_ALERT_JS_55','Your Name');
define('FS_SHOP_CART_ALERT_JS_55_1','Recipient\'s Name');
define('FS_SHOP_CART_ALERT_JS_56','Your Email');
define('FS_SHOP_CART_ALERT_JS_56_1','Separate multiple recipients with semicolons \';\'');
define('FS_SHOP_CART_ALERT_JS_57','500 characters maximum allowed.');
define('FS_SHOP_CART_ALERT_JS_58','Saved Cart');
define('FS_SHOP_CART_ALERT_JS_59','Your order qualifies for FREE Shipping ');
define('FS_SHOP_CART_ALERT_JS_60','Deliver to');
define('FS_SHOP_CART_ALERT_JS_61','All orders of US$ 79 or more of eligible items across any product category qualify for FREE Shipping.');
define('FS_SHOP_CART_ALERT_JS_61_CA','All orders of C$ 105 or more of eligible items across any product category qualify for FREE Shipping.');
define('FS_SHOP_CART_ALERT_JS_61_MX','All orders of MXN $1600 or more of eligible items across any product category qualify for FREE Shipping.');
define('FS_SHOP_CART_ALERT_JS_62','To qualify for FREE Shipping, add ');
define('FS_SHOP_CART_ALERT_JS_63',' of eligible items. ');
define('FS_SHOP_CART_ALERT_JS_64','Your order qualifies for FREE Delivery ');
define('FS_SHOP_CART_ALERT_JS_65','All orders of €79 or more of eligible items across any product category qualify for FREE Delivery.');
define('FS_SHOP_CART_ALERT_JS_66','All orders of £79 or more of eligible items across any product category qualify for FREE Delivery.');
define('FS_SHOP_CART_ALERT_JS_67','All orders of €79 or more of eligible items across any product category qualify for FREE Shipping.');
define('FS_SHOP_CART_ALERT_JS_68','All orders of £79 or more of eligible items across any product category qualify for FREE Shipping.');
define('FS_SHOP_CART_ALERT_JS_69','Secure Checkout');
define('FS_SHOP_CART_ALERT_JS_70','Continue Shopping');
define('FS_SHOP_CART_ALERT_JS_71','All orders of AUD$99 or more of eligible items across any product category qualify for FREE delivery.');
define('FS_SHOP_CART_ALERT_JS_72','Save Cart');
define('FS_SHOP_CART_ALERT_JS_72_1','Save Cart');
define('FS_SHOP_CART_ALERT_JS_73','Email your cart');
define('FS_SHOP_CART_ALERT_JS_74','Print');
define("FS_SHOP_CART_ALERT_JS_76_1","Send Email");
define("FS_SHOP_CART_ALERT_JS_77","View Cart");
// 2018.7.23 fairy 底部反馈弹窗
define('FS_HELP','Help');
define('FS_GIVE_FEEDBACK','FS Feedback');
define('FS_GIVE_FEEDBACK_UK','Make a Complaint');
define('FS_GIVE_FEEDBACK_TIP','Thanks for visiting FS. Your feedback will help us provide customers a better experience.');
define('FS_RATE_THIS_PAGE','Rate your overall experience with FS*');
define('FS_NOT_LIKELY','Poor');
define('FS_VERY_LIKELY','Excellent');
define('FS_TELL_US_SUGGESTIONS','Please select a topic for your feedback.*');
define('FS_ENTER_COMMENTS','Tell us what you think.');
define('FS_PROVIDE_EMAIL','If you would like to hear back from us, please leave your contact information.');
define('FS_PROVIDE_EMAIL_TIP','Note: This information will NOT be used for any other purpose. We value your privacy.');
define('FS_FEEDBACK_THANKYOU','You have shared it successfully.');
define('FS_PRO_SHARE_EMAIL','Your message has been sent.');
define('FS_FEEDBACK_THANKYOU_TIP_01','Your opinion matters to us, we\'ll review your feedback and use it to improve the FS website for future visits.');
define('FS_FEEDBACK_THANKYOU_TIP_02','Your satisfaction is our unremitting pursuit, and we\'ll continue to bring you better service and shopping experience.');
define("FS_SEARCH_YOUR_COUNTRY",'Search your country/region');
define('FS_CHOOSE_ONE','Please choose one');
define('FS_WEB_ERROR','Website error');
define('FS_FEEDBACK_PRODUCT','Product');
define('FS_ORDER_SUPPORT','Order support');
define('FS_TECH_SUPPORT','Tech support');
define('FS_SITE_SEARCH','Site search');
define('FS_FEEDBACK_OTHER','Other');
define('FS_FEEDBACK_NAME','Name');
define('FS_FEEDBACK_EMAIL','E-mail Address');

// 2018.10.16 quest 底部反馈弹窗
define('FS_SG_NOT_LIKELY_AT_ALL','Not likely at all ');
define('FS_SG_GIVE_FEEDBACK_TIP','Thanks for visiting FS.COM. Your feedback will help us provide customers a better experience.');
define('FS_SG_RATE_THIS_PAGE','How likely are you to recommend FS.COM to your friends?');
define('FS_SG_PROVIDE_INFO','If you would like a follow-up, please kindly leave your information:');
define('FS_SG_VISTI_HELP',"* For any other shopping assistance, please visit <a target='_blank' href='".reset_url('/information/help_center.html')."'>FS Support</a>.");
define('FS_SG_PAYMENT_METHODS',"Payment Methods:");

//信用卡语言包
//define("CREDIT_CARD_ERROR_530","Do not honor declines are the most common decline from a card issuing bank.  It is a generic decline and the issuer is not advising First Data of the decline reason.  It may be due to omitting AVS information for a card not present transaction or an incorrect expiration date being entered, a daily spending limit, a single purchase transaction limit, a restriction on that card for specific business types etc. but only the card issuing bank can advise why they actually declined the transaction.");
//define("CREDIT_CARD_ERROR_201","Bad check digit, length, or other credit card problem");
define("CREDIT_CARD_ERROR_303","Generic decline – No other information is being provided by the Issuer");
define("CREDIT_CARD_ERROR_606","Issuer does not allow this type of transaction");
//define("CREDIT_CARD_ERROR_591","Bad check digit, length or other credit card problem. Issuer generated");
define("CREDIT_CARD_ERROR_08","CVV2/CID/CVC2 Data not verified");
define("CREDIT_CARD_ERROR_22","Invalid Credit Card Number");
define("CREDIT_CARD_ERROR_25","Invalid Expiry Date");
define("CREDIT_CARD_ERROR_26","Invalid Amount");
define("CREDIT_CARD_ERROR_27","Invalid Card Holder");
define("CREDIT_CARD_ERROR_28","Invalid Authorization No");
define("CREDIT_CARD_ERROR_31","Invalid Verification String");
define("CREDIT_CARD_ERROR_32","Invalid Transaction Code");
define("CREDIT_CARD_ERROR_57","Invalid Reference No");
define("CREDIT_CARD_ERROR_58","Invalid AVS String, The length of the AVS String has exceeded the max. 40 characters");
define('FS_CART_ITEM','Item)');
define('FS_CART_ITEMS','Items)');
define('CREDIT_CARD_ERROR_260','Service is temporarily unavailable due to network error. Please try later or contact your account manager.');
define('CREDIT_CARD_ERROR_301','Service is temporarily unavailable due to network error. Please try later or contact your account manager.');
define('CREDIT_CARD_ERROR_304','Account is not found. Please check the information or contact the issuing bank.');
define('CREDIT_CARD_ERROR_401','Issuer wants voice contact with cardholder. Please call your issuing bank.');
define('CREDIT_CARD_ERROR_502','Card is reported as lost/stolen. Please contact your issuing bank. Note: Does not apply to American Express.');
define('CREDIT_CARD_ERROR_505','Your account is on negative file. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_509','Exceeds withdrawal or activity amount limit. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_510','Exceeds withdrawal or activity count limit. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_519','Your account is on negative file. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_521','Total amount exceeds credit limit. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_522','Your card has expired. Please check the expiry date or try another payment method.');
define('CREDIT_CARD_ERROR_530','Lack of information provided by issuing bank. Please contact the bank or try another payment method.');
define('CREDIT_CARD_ERROR_531','Issuer has declined auth request. Please contact your issuing bank or try another payment method.');
define('CREDIT_CARD_ERROR_591','Issuer error. Please contact the issuing bank or try another card.');
define('CREDIT_CARD_ERROR_592','Issuer error. Please contact the issuing bank or try another card.');
define('CREDIT_CARD_ERROR_594','Issuer error. Please contact the issuing bank or try another card.');
define('CREDIT_CARD_ERROR_776','Duplicate Transaction. Please contact your account manager to confirm the transaction status.');
define('CREDIT_CARD_ERROR_787','Transaction is declined due to high risk. Please try another payment method.');
define('CREDIT_CARD_ERROR_806','Your card has been restricted. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_825','Account is not found. Please check the information and try again.');
define('CREDIT_CARD_ERROR_902','Service is temporarily unavailable due to network error. Please try later or contact your account manager.');
define('CREDIT_CARD_ERROR_904','Your card is not active. Please contact your issuer bank.');
define('CREDIT_CARD_ERROR_201','Invalid account number/incorrect format. Please check the number and try again.');
define('CREDIT_CARD_ERROR_204','Unidentifiable error. please try later or change to another payment method.');
define('CREDIT_CARD_ERROR_233','Credit card number does not match method of payment type or invalid BIN. Please try another card or payment method.');
define('CREDIT_CARD_ERROR_239','Card is not supported. Please try another card or choose another payment method.');
define('CREDIT_CARD_ERROR_261','Invalid account number/incorrect format. Please check the number and try again.');
define('CREDIT_CARD_ERROR_351','Service is temporarily unavailable due to network error. Please try later or contact your account manager.');
define('CREDIT_CARD_ERROR_755','Account is not found. Please check the information or contact the issuing bank.');
define('CREDIT_CARD_ERROR_758','Account is frozen. Please contact your issuing bank or try another payment method.');
define('CREDIT_CARD_ERROR_834','Card is not supported. Please try another card or payment method.');
//共用 支付成功语言包
define('FS_AGAINST_BPAY_01','Order Date:');
define('FS_AGAINST_BPAY_02','Total Amount:');
define('FS_AGAINST_BPAY_03','Your purchase has been divided into');
define('FS_AGAINST_BPAY_04','orders.');
define('FS_AGAINST_BPAY_05','Expected Delivery');
define('FS_AGAINST_BPAY_06','Ship From');
define('FS_AGAINST_BPAY_07','Order');
define('FS_AGAINST_BPAY_08','of');
define('FS_AGAINST_BPAY_09','Proceed to');
define('FS_AGAINST_BPAY_10','Sparkasse Freising');
define('FS_AGAINST_BPAY_11','FS.COM GmbH');
define('FS_AGAINST_BPAY_12','DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13','BYLADEM1FSI');
define('FS_AGAINST_BPAY_14','25674888');
define('FS_AGAINST_BPAY_15','Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16','817-888472-838');
define('FS_AGAINST_BPAY_17','HSBCHKHHHKH');
define("FS_COMMON_CHECKOUT_HSBC","After you remit the payment, usually it will be received by FS in 1-3 working days. We will deal with the order once remittance confirmed.");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","Please remark your FS order number when paying so that your order can be processed timely. Usually funds will be received between 1-3 working days. The stock is not reserved until the remittance is confirmed.");

define("FS_WAREHOUSE_AREA_36","Ship from Seattle Warehouse");
define("FS_WAREHOUSE_AREA_37","Ship from Delaware Warehouse");



//装箱产品新增
define("FS_PRODUCT_INFO_SIZE","Package:");
define("FS_PRODUCT_INFO_PIECE","1 piece");
define("FS_PRODUCT_INFO_CASE","Order By Case(");
define("FS_PRODUCT_INFO_PIS","pcs/case");
define("FS_PRODUCT_INFO_PIS_1","pcs/");

//结账页面新增
define("FS_LIVE_CHAT_CHECKOUT","<a  href='javascript:;' onclick='LC_API.open_chat_window();return false;'>Live Chat</a> or call");

//au单独的RMA地址
define('FIBER_CHECK_ANZ','ANZ Bank Account:');
define('FIBER_CHECK_ACCOUNT','Account Name:');
define('FIBER_CHECK_PTY','FS.COM Pty Ltd');
define('FIBER_CHECK_BSB','BSB:');
define('FIBER_CHECK_013','013160');
define('FIBER_CHECK_ACCOUNT_NO','Account No.:');
define('FIBER_CHECK_4167','416794959');
define('FIBER_CHECK_SWIFT_CODE','SWIFT Code:');
define('FIBER_CHECK_ANZBAU3M','ANZBAU3M');
define('FIBER_CHECK_BANK','Bank Address:');
define('FIBER_CHECK_ST_VIC','230 Swanston St, Melbourne, VIC, 3000');
define('FIBER_CHECK_TITLE_AU','To pay via direct deposit, please use the following bank account information:');

define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07','FS.COM GmbH');
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');



define('FS_SUCCESS_YOUR_NEXT','Your next step is to complete your Bank Transfer payment and submit your payment details.');
define('FS_SUCCESS_WIRE','Bank Transfer');
define('FS_SUCCESS_ORDER','Print Order');
define('FS_SUCCESS_DETAIL','Bank Transfer beneficiary details');
define('FS_SUCCESS_BANK_NAME','Beneficiary Bank Name:');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','Beneficiary A/C Name:');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','Beneficiary A/C NO:');
define('FS_SUCCESS_TEL','817-888472-838');
define('FS_SUCCESS_SWIFT','SWIFT Address:');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','Beneficiary Bank Address:');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
//UK
define('FIBER_CHECK_ANZ_UK','HSBC Bank Account');
define('FS_SUCCESS_BANK_NAME_UK','Beneficiary Bank Name');
define('FS_SUCCESS_HSBC_UK','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME_UK','Beneficiary A/C Name');
define('FS_SUCCESS_CO_UK','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO_UK','Beneficiary A/C NO');
define('FS_SUCCESS_TEL_UK','817-888472-838');
define('FS_SUCCESS_SWIFT_UK','SWIFT Address');
define('FS_SUCCESS_HK_UK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS_UK','Beneficiary Bank Address');
define('FS_SUCCESS_ROAD_UK','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','Our Company Address');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');

define("FS_LIVE_CHAT_CHECKOUT","<a target='_blank' href='".reset_url('service/fs_support.html')."'>Live Chat</a> or call");


define('FS_TOTAL_SAVINGS','Total Savings');

//2018-8-29  credit付款页面
define('FS_CREDIT_CARD_NUMBER','Card number');
define('FS_CREDIT_EXPIRY_DATE','Expiry date');
define('FS_CREDIT_CONTINUE','Continue');
//2018-8-31   shoppint_cart 页面分享
define('FS_SHARE_AGAIN','Share Again');

//站点融合整理 邮件标点符号整理成常量
define('FS_EMAIL_COMMA',',');   //逗号
define('FS_EMAIL_POINT','.'); //句号
define('FS_EMAIL_PERIOD','.');
define('FS_EMAIL_MARK','.');//感叹号英语中是句点
define('FS_EMAIL_PAUSE',',&nbsp;');  //日语中的逗号有时是顿号
//产品详情页加入购物车后弹出框
define('FS_CONTINUE_SHOPPING','Continue Shopping');
define('FS_CUSTOMERS_ALSO','Customers also bought these products.');
//产品加入购物车后的弹出框信息
define('FS_JUST_ADDED','You just added ');
define('FS_JUST_ITEM',' item');
define('FS_JUST_ITEMS',' items');
define('FS_CART_QTY','Qty:');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'Share Cart');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'Print Cart');
//2018-9-11
define('EMAIL_OVER79_FREE_DELIVERY','<tr><td style="font-size:12px;font-weight: 400;padding-top: 35px;">Orders of eligible items over %s can enjoy free delivery. Hope to see you again.</td></tr>');
define('FS_TRACK_ORDER','You can track your order status by clicking ');
define('FS_TRACK_MY_ORDERS','My Orders');
define('FS_ORDER_COMMENTS','Order Comments: ');
define('FS_TRACK_PO_ORDER','You can track your status in ');
define('FS_TRACK_ACCOUNT_CENTER','account center');


define("FREE_SHIPPING_TEXT3","Free delivery on orders over AU$ 99.");
//2018-9-15  add  ery  游客结算页面账号已存在提示语
define('FS_CHECKOUT_GUEST_LOG_MSG','The email address exists in our system,Please log in directly. &nbsp;&nbsp;&nbsp;&nbsp;<a href="'.zen_href_link('login').'">log in »</a>');
//推荐版块标题
define('FS_PRODUCT_RELATED','Matching Products');
//产品详情货币单位
define('FS_PRODUCT_PRICE_EA','/ea');

//print_order & print_main_order
define('FS_PRINT_ORDER_TEL','Tel: ');
define('FS_PRINT_ORDER_NUM','VAT Number: ');
define('FS_PRINT_ORDER_CREDIT','Credit/Debit Card');
define('FS_PRINT_ORDER_PURCHASE','Purchase Order');
define('FS_PRINT_ORDER_BANK','Bank Transfer');
define('FS_PRINT_ORDER_WESTERN','Western Union');
define('FS_PAY_WAY_PAYPAL','Paypal');
define('FS_PAY_WAY_PAYEEZY','payeezy');
define("FS_CHECKOUT_NEW42","Electronic Check");
define('FS_PRINT_ORDER_FREE','Free');

//客户取消订单邮件
define('FS_CANCEL_ORDER',"Your order#");
define('FS_CANCEL_ORDER_1',"has been canceled");
define('FS_CANCEL_ORDER_2',"As you requested, we've canceled your reserved order# ");
define('FS_CANCEL_ORDER_3',". We're sorry it didn't work out and hope you'll shop with us again soon.");
define('FS_CANCEL_ORDER_4',"If you have any questions, please <a href='contact_us.html'>contact us</a>. Hope to see you again soon!");
define('FS_CANCEL_ORDER_5',"Customer Email Address:");
define('FS_CANCEL_ORDER_6',"Order Number: ");
define('FS_CANCEL_ORDER_7',"Reason:");
define('FS_CANCEL_ORDER_8','Order# ');

//live chat留言邮件
define('FS_LIVE_CHAT_MAIL','Thank you for contacting <a href="'.zen_href_link('index','','SSL').'">FS.COM</a>, this is a confirmation email to let you know that your request for support has been received.We will review your message and get back to you within 12 hours.');
define('FS_LIVE_CHAT_MAIL_1','FS.COM-Email Message Confirmation ');
define('FS_LIVE_CHAT_MAIL_2','Your Service Type:');
define('FS_LIVE_CHAT_MAIL_3','Your Message:');




//产品详情页
define("FS_PRODDUCTS_DELIVERY_TO","Deliver to");
define("FS_PRODUCTS_POST_CODE_EMPTY_ERROR","Your Zip Code is required");
define("FS_AU_SHIPPING_FREE_POLICY","Free Delivery on orders of eligible items over A$99+");
define("FS_CN_SHIPPING_FREE_POLICY","Fast same day shipping for most stock items+.");
define("FS_SHIPPING_POLICY_FOOTER","You’ll see exact shipping costs and arrival dates when you checkout.");
define("FS_PRODUCTS_SHIPPING_OPTIONS","Shipping options");

define("CHECKOUT_TAX_NZ_CONTENT","For orders delivered to the destinations outside Australia, FS.COM will only charge the items and shipping fee when placing an order. These packages may, however, be assessed import or customs fees, depending on the laws of the  destination countries.<br/><br/> Any customs or import duties are levied once the package reaches the destination country. Additional charges for customs clearance would have to be borne by yourself.");
define("FS_TIME_ZONE_ADDRESS_AU","<span>FS Melbourne Warehouse:</span> 57-59 Edison Rd, Dandenong South, VIC 3175, Australia | +61 3 9693 3488 ");
define("FS_TIME_ZONE_ADDRESS_SG","<span>FS Singapore Warehouse:</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");

//专题页面加购弹窗语言包翻译
define('FS_SUPPORT_ADD','Add...');
define('FS_SUPPORT_ADDED','Added');
define("FS_OVERNIGHT_TITLE","Order payment received after cut-off time (5:00pm EST) will be shipped out next business day. Delivery will only occur on business days.");
define("FS_OVERNIGHT_TITLE_UP","Order payment received after cut-off time (5:00pm EST) will be shipped out next business day. Delivery will only occur on business days.");
define("FS_ECHECK_NOTICE","* We only accept Electronic checks issued by US banks. It may take 1-2 business days for us to process the fund.");
define("FS_ECHECK_BANK_ACCOUNT","Bank Account Name");
define("FS_ECHECK_BANK_ACCOUNT_NUMBER","Bank Account Number");
define("FS_ECHECK_BANK_ACCOUNT_TYPE","Account Type");
define("FS_ECHECK_BANK_ACCOUNT_CHECK","Checking");
define("FS_ECHECK_BANK_ACCOUNT_SAVE","Saving");
define("FS_ECHECK_BANK_ACCOUNT_CONFIRM","Confirm Bank Account Number");
define("FS_ECHECK_BANK_ACCOUNT_ROUTE","ABA /ACH routing number");
define("FS_ECHECK_ERROR_1","Bank Account Name is required.");
define("FS_ECHECK_ERROR_2","Bank Account Number is required.");
define("FS_ECHECK_ERROR_3","Account Type is required.");
define("FS_ECHECK_ERROR_4","Confirm Bank Account Number is required.");
define("FS_ECHECK_ERROR_5","Bank ABA /ACH routing Number is required.");

define("FS_SUCCESS_ECHECK","Electronic Check");
//checkout_success
define('FS_PURCHASE_NUMBER','Purchase Order Number');

//购物车分享相关 移动到公共语言包部分
define('FS_SHOP_CART_ALERT_JS_43','Your Name should not be empty.');
define('FS_SHOP_CART_ALERT_JS_43_01',"Recipient's Name should not be empty.");
define('FS_SHOP_CART_ALERT_JS_44','Your Email should not be empty.');
define('FS_SHOP_CART_ALERT_JS_44_01',"Recipient's Email should not be empty.");
define('FS_SHOP_CART_ALERT_JS_45','Please enter a valid email address.');
define('FS_SHOP_CART_ALERT_JS_46','Send to Account Manager');

//第三方登录提示语
define("REDIRECT_DEAR","Dear ");
define("REDIRECT_USER"," user ");
define("REDIRECT_WELCOME"," welcome");
define("REDIRECT_NOTICE","You have registered an FS account with the same email <br>address. To provide you better experience on account management, you'll sign <br>in to your FS account. If you don't know about this account, <br>please contact us.");
define("REDIRECT_ACCOUNT","Redirect in ");

//移动到公共文件 checkout,ccheckout_guest,邮件共用
define("FS_CHECKOUT_NEW31","PayPal");
define("FS_CHECKOUT_NEW32","Credit/Debit Card");
define("FS_CHECKOUT_NEW33","Bank Transfer");
define("FS_CHECKOUT_NEW34","Net Terms");
define("FS_CHECKOUT_NEW35"," BPAY");
define("FS_CHECKOUT_NEW36"," eNETS");
define("FS_CHECKOUT_NEW37","YANDEX");
define("FS_CHECKOUT_NEW38","WEBMONEY");
define("FS_CHECKOUT_NEW39","iDEAL");
define("FS_CHECKOUT_NEW40","SOFORT");
define("FS_CHECKOUT_NEW_CASHLESS","Cashless Payment");

// 税号模块 start
define("FS_CHECKOUT_VAX_CH","Please enter valid Tax Number eg: 00.000.000-0.");
define("FS_CHECKOUT_VAX_AR","Please enter valid Tax Number eg: 00-00000000-0.");
define("FS_CHECKOUT_VAX_BR_BS","Please enter valid Tax Number eg: 00.000.000/0000-00.");
define("FS_CHECKOUT_VAX_BR_IN","Please enter valid Tax Number eg: 000.000.000/00.");
define("FS_TAXT_TITLE_NOTICE","Your order can be exempted from the VAT Tax by providing a correct and valid VAT ID.");
define("FS_TAXT_TITLE_NOTICE_OTHER","To speed up customs clearance, please fill in a valid Tax Identification Number.");
// 税号模块 end

//manage_orders
define('FS_MANAGE_ORDERS_PUR','Purchase Order Number');

define("FS_NO_FREE_SHIPPING_US_HEAVY","Orders containing heavy or oversize items cannot enjoy free shipping.");
define("FS_NO_FREE_SHIPPING_DEAU_HEAVY","Orders containing heavy or oversize items cannot enjoy free delivery.");
define("FS_NO_FREE_SHIPPING_AU_REMOTE","This order is delivered to remote district so a shipping fee is incurred.");

//产品详情404页面
define('FS_404_HOT_PRODUCTS','Hot Products');
define('SEARCH_OFFINE_1','Sorry, this item is no longer available online.');
define('SEARCH_OFFINE_2','You can get a quote to make offline inquiries.');
define('SEARCH_OFFINE_3','get a quote');
define('SEARCH_OFFINE_4','Need more help? Visit ');
define('SEARCH_OFFINE_5','FS Support');
define('SEARCH_OFFINE_6',' for further assistance.');


//产品详情页新增弹窗语言包
define("FS_PRODUCTS_REORDERING","Reordering");
define("FS_FOR_FREE_SHIPPING_GET_AROUND","Get it around");
define("FS_CHOOSE_LOCATION","Choose your location");
define("FS_DELIVERY_OPTION","Delivery Options and delivery speeds may vary for different locations.");
define("FS_SHIP_OUTSIDE","Ship outside the ");
define("FS_SHIP_CONTINUE_SEE","You’ll see exact shipping costs and arrival dates when you checkout.");
define("FS_SHIP_DONE","Done");
define("FS_REDIRECT_PART1","Continue shopping on ");
define("FS_REDIRECT_PART2"," and check the specific content with local price and delivery?");
define("FS_SHIP_TO","Ship to");
define("FS_SHIP_CHANGE","Change");
define("FS_SHIP_OR","or");
define("FS_SHIP_OR_OTHER","or change other country");
define("FS_SHIP_ENTER","or enter a ");
define("FS_SHIP_ZIP_CODE"," zip code");
define("FS_SHIP_APPLY"," Apply");
define("FS_SHIP_ADD_NEW_ADDRESS","Add a new address");
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'"> Sign in</a> to see your addresses');
define("FS_SHIP_MANAGE","Manage address book");
define("FS_SHIP_TODAY","Ship Today");
define("FS_SHIP_GET_TODAY","get it by the end of today");
define("FS_PRODUCTS_POST_CODE_EMPTY_INVALID","Please enter a valid Zip Code");
define('FS_PRODUCTS_CUSTOMIZE','Customize');
define('SEARCH_OFFINE_7','Sorry, this webpage cannot be found.');
define('SEARCH_OFFINE_8','It may be because:');
define('SEARCH_OFFINE_9','The page has moved to a different address.');
define('SEARCH_OFFINE_10','The web address is typed incorrectly.');
define('SEARCH_OFFINE_11','Please check the URL, or go to the <a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">homepage</a>.');
define('SEARCH_OFFINE_12','homepage.');
define('FS_OUTDATED_LINK','The link that took you here is outdated.');

define("FS_SHIP_LIST_COUNTRY","Country/Region");
define("FS_SHIP_LIST_POST","zip code");
define("FS_SHIP_DELIVEY_TO","Deliver to");

define("FS_CN_HUBEI","Wuhan, Hubei");
define("FS_CN_APAC","Asia Warehouse");
define("FS_DE_MUNICH","Munich,Bavaria");
define("FS_AU_VIC","Melbourne, Victoria");
define("FS_US_WA","Washington/Delaware");
define("FS_FOR_FREE_SHIPPING_GET_ARRIVE","Get it by");
define("FS_APAC_NOTICE","FS Asia Warehouse supports fast same day global shipments to South-America, Africa, Asia Pacific, and other areas. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_US_NOTICE","FS U.S. Warehouse located in Delaware, supports fast same day shipping. <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Learn more</a>");
define("FS_US_UP_NOTICE","FS U.S. Warehouse located in Delaware, supports fast same day domestic shipments within Contiguous U.S., Alaska, Hawaii, APO/FPO military addresses and Puerto Rico, etc, and international shipments to Canada, Mexico.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_US_OTHER_NOTICE","FS U.S. Warehouses located in Seattle & Delaware respectively, support fast same day shipments to United States, Canada, and Mexico.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_US_UP_OTHER_NOTICE","FS U.S. Warehouse located in Delaware, supports fast same day shipments to United States, Canada, and Mexico.  <a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_DE_NOTICE","FS DE Warehouse located in Munich supports fast shipping. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_DE_OTHER_NOTICE","FS DE Warehouse, located in Munich, Bavaria, supports global shipments to United Kingdom, EU and other European countries. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_AU_OTHER_NOTICE","FS AU Warehouse, located in Melbourne, Victoria, supports fast same day domestic shipments within Australia, and international shipments to New Zealand. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_NZ_OTHER_NOTICE","FS AU Warehouse, located in Melbourne, Victoria, supports fast same day shipments to New Zealand. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define("FS_CN_NOTICE","FS Global Warehouse in Asia supports fast same day shipping. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Items will be shipped out once prepared. There may be manufacturing lead times. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Available, In Transit</p> Items are on the way to our warehouse and will be shipped out once arrive. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Available, Need Transit</p> Items will be shipped out once prepared. There may be manufacturing lead times. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define('FS_AU_NOTICE',"FS AU Warehouse located in Melbourne supports fast same day shipping. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Read more</a>");
define('FS_BUCK_NOTICE',"Heavy or oversize items will be shipped out from Asia warehouse.");
define('FS_SG_NOTICE',"FS SG Warehouse located in Singapore supports fast same day shipping. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Read more</a>");
define('FS_RU_NOTICE',"FS RU Warehouse located in Moscow supports fast same day shipping. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Read more</a>");

//add by quest 2019-03-08
define("FS_NO_QTY_NOTICE","The items are expedited to transit from global warehouse.");
define("FS_NO_QTY_TAG_NOTICE","The items are preparing to transit from global warehouse.");
define("FS_NO_QTY_TAG_NOTICE_NEW","The items are being prepared to be transitted from Asia Warehouse.");
define("FS_NO_QTY_NOTICE_NEW","The items are being transitted from Asia Warehouse.");
//faq问题汇总
define('FS_FAQ_HELPFUL_01',"Was this answer helpful?");
define('FS_FAQ_HELPFUL_02',"Yes");
define('FS_FAQ_HELPFUL_03',"No");
define('FS_FAQ_HELPFUL_04',"Thanks for your feedback!");
define('FS_FAQ_HELPFUL_05',"What can we improve?");
define('FS_FAQ_HELPFUL_06',"This was confusing");
define('FS_FAQ_HELPFUL_07',"This didn't answer my question");
define('FS_FAQ_HELPFUL_08',"I don't like your policy");
define('FS_FAQ_HELPFUL_09',"Submit");



define("FS_SURBSTREET_MAXLENGTH_ERROR","Address line 2 should contain a maximum of 35 characters.");
define("FS_TELEPHONE_MAXLENGTH_ERROR","Phone number should contain a maximum of 15 characters.");
define("FS_COMPANY_MAXLENGTH_ERROR","Company Name must be between 1 and 100 characters long.");
define("FS_FIRSTNAME_MAXLENGTH_ERROR","First Name should contain a maximum of 35 characters.");
define("FS_LASTNAME_MAXLENGTH_ERROR","Last Name should contain a maximum of 35 characters.");

define('FAIL_TO_OPEN_SOURCE','Error opening the image');
define('FAIL_TO_CONNECT_FTP','Server connection failed');

//超时取消订单
define('MANAGE_ORDER_RESTORE_1','Ends in 0h');
define('MANAGE_ORDER_RESTORE_2','Ends in ');
define('MANAGE_ORDER_RESTORE_3','Please complete payment in 30 minutes, otherwise, the order will be cancelled automatically due to the inventory change of items.');
define('MANAGE_ORDER_RESTORE_4','Buy again');
define('MANAGE_ORDER_RESTORE_5','Please upload your purchase order file in 7 days, otherwise, the order will be cancelled automatically due to the inventory change of items.');
define('MANAGE_ORDER_RESTORE_6','Please complete payment in 2 days, otherwise, the order will be cancelled automatically due to the inventory change of items.');
define('MANAGE_ORDER_RESTORE_7','Please complete payment in 7 days, otherwise, the order will be cancelled automatically due to the inventory change of items.');
define("FS_INQUIRY_CANCELED",'Canceled');
define("FS_INQUIRY_SUBMITED",'Submitted');
define("FS_INQUIRY_QUOTED",'Quoted');
define("FS_INQUIRY_DEALED",'Dealed');
define("FS_INQUIRY_REVIEWING",'Reviewing');
// 个人中心详情页面
define("FS_INQUIRY_SUBTOTAL",'Subtotal');
define("FS_INQUIRY_CHECKOUT",'Checkout');
define("FS_INQUIRY_ADD_FILE",'Add a File');
define("FS_INQUIRY_CANCEL_SUCCESS",'Cancel successfully');
define("FS_NOTES",'Notes');

// 个人中心列表页面
define("FS_INQUIRY_TOTAL_QUOTE_NUMBER",'QUOTE_NUMBER Total Requests for Quote');
define("FS_INQUIRY_VIEW",'View');
define("FS_INQUIRY_CANCEL_THIS_QUOTE",'Cancel This Quote?');
define("FS_INQUIRY_CANCEL_QUOTE_TIP1",'Once you do that, it can not be recovered.');
define("FS_INQUIRY_CANCEL_QUOTE_TIP2",'However, if you really mean that, please kindly provide us a reason(s) for canceling: ');
define("FS_INQUIRY_CANCEL_REASON1",'Already bought from others');
define("FS_INQUIRY_CANCEL_REASON2",'Duplicate quotation');
define("FS_INQUIRY_CANCEL_REASON3",'Not the product I need');
define("FS_INQUIRY_CANCEL_REASON4",'Warranty issue');
define("FS_INQUIRY_CANCEL_REASON5",'Long lead time');
define("FS_INQUIRY_CANCEL_REASON6",'Too expensive');
define("FS_INQUIRY_CANCEL_REASON7",'No need');
define("FS_INQUIRY_CANCEL_REQUIRED_TIP",'Before submitting, please fill out the reasons for canceling the quote.');
define('FS_INQUIRY_EMPTY_PAGE_TIP','There is no quote request yet. Get a quote in the product page. ');
define('FS_INQUIRY_LIST_TIP','Check the status of your quotes and purchase directly with the preferential prices.');
define('FS_CANCEL_QUOTE','Cancel Quote');

//forward 运费
define("FS_FORWARD_SHIPPING","Forwarder Shipping (with Pre-paid Duties & Taxes)");
define("FS_FORWARD_SHIPPING_NOTICE","The price shown includes shipping cost and possible duties & taxes. Neccessary insurance will also be charged and shown at Order Summary,  calculated by the amount of subtotal.");
define('FS_CHECK_OUT_INSURANCE','Insurance');
//产品详情页产品树收起提示语
define('FS_COMMON_CLOSE','Close');

define('FS_COMMON_FS_PN', 'FS P/N: ');

//新版邮件
define("SEND_MAIL_1","FREE Delivery Over £79");
define("SEND_MAIL_2","Fiberstore Ltd, Part 7th Floor, 45 CHURCH STREET, Birmingham, B3 2RT");
define("SEND_MAIL_3","FREE Shipping Over $79");
define("SEND_MAIL_4","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");
define("SEND_MAIL_5","FREE Delivery Over €79");
define("SEND_MAIL_6","GmbH, NOVA Gewerbepark, Building 7, Am Gfild 7, 85375 Neufahrn, Germany");
define("SEND_MAIL_7","FREE Delivery Over A$99");
define("SEND_MAIL_8","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Pty Ltd, ABN 71 620 545 502,57-59 Edison Rd, Dandenong South, VIC 3175, Australia");
define("SEND_MAIL_9","Same Day Shipping on Stock Items");
define("SEND_MAIL_10","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Limited Room 2702, 27 Floor Yisibo Software Building, Haitian Second Road, Yuehai Street Nanshan District, Shenzhen, 518054, China");
//Postbank账户
define('FIBER_CHECK_COMMON_ACCOUNT','Account Number:');
define('FIBER_CHECK_COMMON_CODE','Bank Code Number:');
define('FIBER_CHECK_COMMON_IBAN','IBAN:');
define('FIBER_CHECK_COMMON_BIC','BIC:');


define('FIBER_CHECK_DO_TITLE','US-$ account');
define('FIBER_CHECK_DO_ACCOUNT_VALUE','0902543668');
define('FIBER_CHECK_DO_CODE_VALUE','590 100 66');
define('FIBER_CHECK_DO_IBAN_VALUE','DE98 5901 0066 0902 5436 68');
define('FIBER_CHECK_DO_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_GB_TITLE','Britisch Pound GBP');
define('FIBER_CHECK_GB_ACCOUNT_VALUE','0902544661');
define('FIBER_CHECK_GB_CODE_VALUE','590 100 66');
define('FIBER_CHECK_GB_IBAN_VALUE','DE59 5901 0066 0902 5446 61');
define('FIBER_CHECK_GB_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_CH_TITLE','Swiss Franc CHF');
define('FIBER_CHECK_CH_ACCOUNT_VALUE','0902545664');
define('FIBER_CHECK_CH_CODE_VALUE','590 100 66');
define('FIBER_CHECK_CH_IBAN_VALUE','DE41 5901 0066 0902 5456 64');
define('FIBER_CHECK_CH_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_POST_TITLE','Postbank Account');
define('FIBER_CHECK_COMMON_ACCOUNT_NAME','Account Name:');
define('FIBER_CHECK_COMMON_BANK','Bank Name:');
define('FIBER_CHECK_COMMON_ADDRESS','Bank Address:');

define('FIBER_CHECK_SG_TITLE','OCBC Bank Account');
define('FIBER_CHECK_SG_OCBC_USD','OCBC USD Account Number:');
define('FIBER_CHECK_SG_OCBC_SGD','OCBC SGD Account Number:');
define('FIBER_CHECK_SG_INT_BANK','Intermediary Bank (for TT in USD)');
define('FIBER_CHECK_SG_SWIFT','SWIFT Code:');
define('FIBER_CHECK_SG_BANK_CODE','Bank Code:');
define('FIBER_CHECK_SG_BRANCH_CODE','Branch Code:');
define('FIBER_CHECK_SG_BRANCH_CODE_CONTENT','First 3 digits of your account no.');
define('FIBER_CHECK_SG_BRANCH_NAME','Branch Name:');
define('FIBER_CHECK_SG_BRANCH_NAME_CONTENT','NORTH Branch');
define('FIBER_CHECK_SG_BANK_ADDRESS','Bank Address:');
define('FIBER_CHECK_SG_BANK_ADDRESS_CONTENT','65 Chulia Street, OCBC Centre, Singapore 049513');

define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE','FS.COM GmbH');
define('FIBER_CHECK_COMMON_BANK_VALUE','Postbank');
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE','Eckenheimer Landstr.242 60320 Frankfurt');
//new_cart
define('FS_NEW_SHIPPING_FREE','This order qualifies for Free Shipping!');
define('FS_GO_SHOPPING','Continue Shopping');
define('FS_ENTERPRISE_NETWORK','Enterprise Network');
define('FS_OTN_SOLUTION',' OTN Solution ');
define('FS_DATA_CENTER_SOLUTION','Data Center Solution');
define('FS_OEM_SOLUTION',' OEM Solution');
define('FS_RECENTLY_VIEWED','Recently Viewed');
define('FS_CART_TIP','Have a FS account? <a target="_blank" href="'.zen_href_link('login','','SSL',true).'" class="cart_no_23Link">Sign in</a> to see items you may have added, or add something new.');
define('FS_ADDED_TO_CART','Added to Cart');
define('FS_REMOVED','Remove');
define('FS_SHOP_CART_MOVE','Move to cart');
define('FS_SHOP_CART_SAVE','Save for later');
define('FS_SHOP_CART_SIMILAR','View similar');
define('FS_SHOP_CART_SAVED','Saved for later');
define('FS_CART_EMPTY','Your Shopping Cart is Empty.');
define('FS_SVAE_FOR_LATER_TIP',' has been saved for later.');
define('FS_MOVE_TO_CART_TIP',' has been moved to cart.');
define('FS_DELETE_FOR_LATER','Delete Save for Later');
define('FS_DELETE_SURE_SAVE','Are you sure you want to delete Save for Later product?');
define('FS_DELETE_SURE','Are you sure you want to delete ');
define('FS_DELETE_CART_TITLE','Delete Saved Cart');
define('FS_SYMBOL',',');

//四级分类标题
define('FS_CATEGORIES_01','Product Type');
define('FS_CATEGORIES_02','Product Classification');
define('FS_CATEGORIES_03','Tool Type');
define('FS_CATEGORIES_04','Media Converters Type');
define('FS_CATEGORIES_05','Cable Type');
define('FS_CATEGORIES_06','KVM Switches Type');
define('FS_CATEGORIES_07','Video Converters Type');
define('FS_CATEGORIES_08','Application');

//下架产品气泡,提示
define('FS_PRODUCT_OFF_TEXT','Sorry, the item has been removed and is no longer available for purchase.');
define('FS_PRODUCT_OFF_TEXT_2','Sorry, the following item(s) might have been removed and is no longer available for purchase from FS.COM.');
define('FS_PRODUCT_OFF_TEXT_3','Select attributes');
define('FS_PRODUCT_OFF_TEXT_4','The attributes of the following customized items have changed, please go to the product details page to select attributes.');
define('FS_PRODUCT_OFF_TEXT_5','*Some of the items in this order cannot be added to the shopping cart.');
define('FS_PRODUCT_OFF_TEXT_6','Your order contains the unavaliable item(s),skip and continue to upload PO file.');
define('FS_PRODUCT_OFF_TEXT_7','Below item(s) are not available any more and will not be calculated in total price when checkout.');
define('FS_PRODUCT_OFF_TEXT_8','An item in your Cart is unavailable. It will not show when you proceed to checkout.');
define('FS_PRODUCT_OFF_TEXT_9','These items in your Cart are unavailable. It will not show when you proceed to checkout.');

//清仓产品气泡,提示
define('FS_PRODUCT_CLEARANCE_TEXT','The following item(s) might have been out of stock, please contact your account manager for availability.');
define('FS_PRODUCT_CLEARANCE_TEXT_1','The quantity you’ve specified exceeds available inventory and has been adjusted accordingly, please contact your account manager for additional quantity.');


// 添加购物车成功弹窗
define('FS_ADDED_ONE_ITEM','You just added [ADDITEM] item.');
define('FS_ADDED_MORE_ITEM','You just added [ADDITEM] items.');
define('FS_PRODUCTS_JS_MOQ','This products the MOQ is');
define('FS_PRODUCTS_JS_UPPER','NO upper limit');

//2019-01-07 继续付款，再次付款，付款成功
define('PAYMENT_AGAINST_PAYPAL','PayPal');
define('CHECKOUT_BILLING_CREDIT','Credit/Debit Card Payment Center');

define('PAYMENT_AGAINST_PAYPAL_SECURITY','You will be directed to PayPal to complete the payment.');
define('PAYMENT_AGAINST_ECHECK','Electronic Check');
define('PAYMENT_AGAINST_BANK','Bank Transfer');
define('PAYMENT_AGAINST_BANK_SENTENCE01','Usually funds will be received within 1-3 working days. We will process the order once remittance is confirmed.');
define('PAYMENT_AGAINST_BANK_SPARKASSE','Sparkasse Bank Account');
define('PAYMENT_AGAINST_BANK_FILL','Fill in your Bank Transfer Information');
define('PAYMENT_AGAINST_BANK_SENTENCE02','Let us know when you are ready to remit payment so as we can check your payment and process your order timely.');
define('PAYMENT_AGAINST_BANK_EMAIL','Payer\'s Email Address');
define('PAYMENT_AGAINST_ITEMS','items');
define('PAYMENT_AGAINST_EDIT','Edit');
define("GLOABL_GC_LIVECHAT","Live Chat");
define("GLOBAL_GC_TEXT6","Select Credit/Debit Card:");
define("GLOBAL_GC_TEXT7","Order Summary");
define("GLOBAL_GC_TEXT8","Order Number");
define("GLOBAL_GC_TEXT9","Need help? ");
define("GLOBAL_GC_TEXT10"," Check our Help pages or  ");
define("GLOBAL_GC_TEXT11"," Billing Address");
define("GLOBAL_GC_TEXT12","Edit");
define("GLOBAL_GC_TEXT13","Card Number");
define("GLOBAL_GC_TEXT14","Expiration Date");
define("GLOBAL_GC_TEXT17","Security Code");
define('GLOBAL_GS_ITEMS','items');
define('GLOBAL_GS_SENTENCE1','Note: For security purposes, we will not save any of your credit card data.');
define('GLOBAL_GS_SENTENCE2','We accept the following credit/debit cards as well as P-Card issued by these companies. Please select a card type, complete the information below, and click Confirm.');
define('GLOBAL_GS_SENTENCE3','We accept the following credit/debit cards. For security purposes, we will not save any of your credit card data.');
define('FS_AGAINST_WE','We accept the following credit/debit cards as well as P-Card issued by these companies. Please select a card type, complete the information below, and click Confirm.');
define("GLOABL_CART","Cart");
define("GLOABL_CHECKETOUT","Checkout");
define("GLOABL_SUCCESS","Success");
define("GLOBAL_EXPECTED_SHIPPING","Expected Shipping");
define("GLOBAL_EXPECTED_DELIVERY","Expected Delivery");
define("GLOABL_EDIT_BILLING","Edit Your Billing Address");
define("FS_CHECKOUT_NEW28","Copyright &copy; 2009-".date('Y',time())." FS.COM INC All Rights Reserved.");
define('FS_PAYMENT_CONFIRM','Confirm');
define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP','Purchase order number can\'t be empty.');

define('FS_AGAINST_ITEM','Item(s)');
define('FS_AGAINST_SHIPPING','Shipping Method');
define('FS_AGAINST_ORDER_DATE','Order Date');
define('FS_AGAINST_PAYMENT','Payment Method');
define('FS_AGAINST_DETAIL','Bank Account Information');
define('FS_AGAINST_BENE','Beneficiary Bank Name');
define('FS_AGAINST_HSBC','HSBC Hong Kong');
define('FS_AGAINST_AC','Beneficiary A/C Name');
define('FS_AGAINST_CO','FS.COM LIMITED');
define('FS_AGAINST_NO','Beneficiary A/C NO');
define('FS_AGAINST_SWIFT','SWIFT Address');
define('FS_AGAINST_ADDRESS','Beneficiary Bank Address');
define('FS_AGAINST_ROAD','1 Queen\'s Road Central, Hong Kong');
define('FS_AGAINST_OUR','Our Company Address');
define('FS_AGAINST_EAST','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
define('FS_AGAINST_FILL','Fill in your payment information ');
define('FS_AGAINST_PAYER','Payer\'s Name');
define('FS_AGAINST_OR','Please fill in the full name that you use to make the bank transfer, either individual or company');
define('FS_AGAINST_COUNTRY','Country');
define('FS_AGAINST_CHOOSE','Please choose');
define('FS_AGAINST_PLE_CHOOSE','Please choose your country.');
define('FS_AGAINST_PAY_AMOUNT','Payment Amount');
define('FS_AGAINST_EX','Your Payment Amount field is required.ex: $29.22 or € 29.22 or 29.22(The default is $)');
define('FS_AGAINST_PAY_TIME','Payment Time');
define('FS_AGAINST_YOUR','Your Payment Time field is required(ex: 01/26/2019)');
define('FS_AGAINST_PHONE','Payer\'s Phone Number');
define('FS_AGAINST_MUST','Must be a valid telephone number, at which we can reach you if necessary');
define('FS_AGAINST_SEND','Send');
define('FS_AGAINST_ANZ','ANZ Bank Account');
define('FS_BT_SUCCESSFULLY','Update successfully!');
define('FS_BT_SUCCESSFULLY_SENTENCE_01','Usually funds will be received between 1-3 working days. We will deal with it as soon as possible. Click');
define('FS_BT_SUCCESSFULLY_SENTENCE_02',' Order History ');
define('FS_BT_SUCCESSFULLY_SENTENCE_03','to see the order.');
define("FS_ORDER_UPLOAD_PO_MESSAGE",'Your order will not be shipped until valid PO document is received within 7 business days.');
define('FS_ALLOWED_FILE_TYPES','Allowed file types: ');

define("FS_PRODUCTS_PICK_UP","Free pickup, get it by Mon. - Fri.");
define("FS_PRODUCTS_VIA","via");
define('FS_GC_TIPS_01','Sorry, your request is declined. Please check the following reasons and try again, or choose another payment method.');
define('FS_GC_TIPS_02','1. Total amount exceeds limit (€ 15000) ;');
define('FS_GC_TIPS_03','2. Card does not support the currency;');
define('FS_GC_TIPS_04','3. Network error, please try later.');

//fairy 2019.1.15 add
define('FS_COLOR_RED','Red');
define('FS_COLOR_BLUR','Blue');
define('FS_COLOR_GREEN','Green');

//账户中心
define('FS_MANAGE_ORDERS_1','The following informations are all for End User or Switch Operator. It is essential to provide technical support services. Please ensure that all informations are true and effective.');
define('FS_MANAGE_ORDERS_2','Application Submitted');
define('FS_MANAGE_ORDERS_3','License Key : ');
define('FS_MANAGE_ORDERS_4','Procedure : ');
define('FS_MANAGE_ORDERS_5','License Key Received');
define('FS_MANAGE_ORDERS_6','Activation Completed');
define('FS_MANAGE_ORDERS_7','Information submitted successfully. We will send you an email including the license key to activate switch soon.');
define('FS_MANAGE_ORDERS_8','N Series Cumulus Switches');
define('FS_MANAGE_ORDERS_9','N Series Cumulus Switches License Key');
define('FS_MANAGE_ORDERS_10','Dear ');
define('FS_MANAGE_ORDERS_11','Your license key is ');
define('FS_MANAGE_ORDERS_12','Note: It will take about 3 days to verify the license key. After the verification is completed, you can import it into the switch. ');
define('FS_MANAGE_ORDERS_13','1. License Usage and Restrictions');
define('FS_MANAGE_ORDERS_14','The license key will be long-term and effective.');
define('FS_MANAGE_ORDERS_15','You can enjoy 1 year as well as 45 days technical support service from the date of activation. (The extra free service would be overdue if you do not use within 45 days).');
define('FS_MANAGE_ORDERS_16','After the service expires, you are allowed to continue to purchase the service if you\'d like to.');
define('FS_MANAGE_ORDERS_17','2. License Key Import Process');
define('FS_MANAGE_ORDERS_18','Please kindly check the following resources to import the license:');
define('FS_MANAGE_ORDERS_19','We welcome you come to us for any questions during the license operation or the desire of extending the technical support services. Our contact information is as follows:');
define('FS_MANAGE_ORDERS_20','Email: ');
define('FS_MANAGE_ORDERS_22','+1 (888) 468 7419 (EST)');
define('FS_MANAGE_ORDERS_23','Please make sure this license key remained in safe hands and import it to the switch when you need it.');
define('FS_MANAGE_ORDERS_24','Sincerely,');
define('FS_MANAGE_ORDERS_25','FS.COM Technical Team');
define('FS_MANAGE_ORDERS_26','Video: ');
define('FS_MANAGE_ORDERS_26_1','Video');
define('FS_MANAGE_ORDERS_27','PDF: ');
define('FS_MANAGE_ORDERS_28','Phone: ');
define('FS_MANAGE_ORDERS_29','FREE Shipping Over $79');
define('FS_MANAGE_ORDERS_30','Get License Key');
define('FS_MANAGE_ORDERS_31','Dear ');
define('FS_MANAGE_ORDERS_32','Here\'s your license key: ');
define('FS_MANAGE_ORDERS_33','Leaf(10G/25G): 556688 <br />Spine(40G/100G): 335521');
define('FS_MANAGE_ORDERS_34','Note: ');
define('FS_MANAGE_ORDERS_35','1. The license key will be long-term and effective. Please make sure this license key remained in safe hands. It will take about 3 days to verify the license key.');
define('FS_MANAGE_ORDERS_36','2. After completed, you can import it into the switch. You can enjoy 1 year as well as 45 days technical support service, the extra free service would be invalid if you do not use within 45 days. Once the service expires, you are allowed to continue to purchase the service if you\'d like to.');
define('FS_MANAGE_ORDERS_37','How to Import License Key');
define('FS_MANAGE_ORDERS_38','Please kindly check the following resources to help:');
define('FS_MANAGE_ORDERS_39','We welcome you come to us for any questions during the license operation or the desire of extending the technical support services. Our contact information is as follows:');
define('FS_MANAGE_ORDERS_40','Email: <a style="text-decoration: none;color: #232323;">tech@fs.com</a> <br />Phone: +1 (888) 468 7419');
define('FS_MANAGE_ORDERS_41','Sincerely,');
define('FS_MANAGE_ORDERS_42','FS.COM Technical Team');
define('FS_MANAGE_ORDERS_43','Your Company Name is required');
define('FS_MANAGE_ORDERS_44','Your Name is required');
define('FS_MANAGE_ORDERS_45','Your Telephone Number is required');
define('FS_MANAGE_ORDERS_46','Your Email Address is required');
define('FS_MANAGE_ORDERS_47','The email address you submitted is not recognized.(example: someone@example.com).');
define('FS_MANAGE_ORDERS_48','Please click the EULA agreement button');
define('FS_MANAGE_ORDERS_49','Your Web Address is required');
define('FS_MANAGE_ORDERS_50','This message was sent to ');
define('FS_MANAGE_ORDERS_51','Free Shipping: Some exclusions apply.');
define('FS_MANAGE_ORDERS_52','Read more about our ');
define('FS_MANAGE_ORDERS_53','shipping policy');
define('FS_MANAGE_ORDERS_54','<a style="text-decoration: none;color: #232323;">FS.COM</a> Inc.');
//culums off
define("CULUMS_OFF1","Apply for Activation");
define("CULUMS_OFF2","The following informations are all for End User or Switch Operator. It is essential to provide technical support services. Please ensure that all informations are true and effective. ");
define("CULUMS_OFF3","Company Name");
define("CULUMS_OFF4","User Name");
define("CULUMS_OFF5","Telephone");
define("CULUMS_OFF6","Email Address");
define("CULUMS_OFF7","Web Address");
define("CULUMS_OFF8","EULA agreement.");
define("CULUMS_OFF9","Cumulus Networks®");
define("CULUMS_OFF11","End User Software License Agreement");
define("CULUMS_OFF12","These license terms, along with the Order Confirmation delivered to you (“Licensee”) by either Cumulus Networks, Inc. (“Cumulus”) or a reseller who is authorized by Cumulus to distribute Cumulus software to you (“Authorized Reseller”) are an agreement between Cumulus and you. These terms apply to the software with which they are distributed, including the media on which you received it, if any. The terms also apply to any Cumulus updates, supplements, and support services for the software that Cumulus may supply to you, unless other terms accompany those items. If so, those terms apply.  By using the software, you confirm that you have a valid Order Confirmation with respect to every copy of the software that you use and that you accept these terms in connection with each copy.");
define("CULUMS_OFF13","IF YOU DO NOT ACCEPT THESE TERMS, DO NOT USE THE SOFTWARE. BY USING THE SOFTWARE, YOU ACCEPT AND AGREE TO ABIDE BY THIS SOFTWARE LICENSE AGREEMENT (“Agreement”).");
define("CULUMS_OFF14","EVALUATION, BETA, AND NFR LICENSES. If you receive a license to the Product that is identified by Cumulus as an Evaluation License or Beta License, then the following additional limitations apply to your license: unless otherwise authorized by Cumulus in writing, your use of the Product is (i) only permitted for a term of thirty days in an internal non-production environment (testing and evaluation only); and is (ii) limited to no more than five concurrent instances of the Product, solely running on hardware owned or solely controlled by you, unless otherwise authorized by Cumulus. If you a receive a license to the Product that is identified by Cumulus as a Not-For-Resale (NFR) license, then the following additional limitations apply to your license: your use of the Product is (i) only permitted for one instance on hardware owned or solely controlled by you, while you are a partner in good standing under the applicable Cumulus partner program that made you eligible to receive the NFR license, (ii) limited to product demonstrations, tests, and training only (no production, information processing or infrastructure use allowed). Notwithstanding anything to the contrary, Evaluation, Beta License, NFR licensed Products, and any Product (or portion thereof) identified by Cumulus as Early Access are provided “AS-IS” without indemnification, support, or warranties of any kind, expressed or implied. You assume all risk associated with any use of Evaluation, Beta License, and NFR licensed Products. THIS AGREEMENT MAY ONLY BE SUPERSEDED BY A SEPARATE, SIGNED WRITTEN AGREEMENT WITH CUMULUS NETWORKS, INC. THAT EXPRESSLY REFERENCES AND SUPERSEDES THIS AGREEMENT (A “SUPERSEDING AGREEMENT”).");
define("CULUMS_OFF15","The parties agree as follows:");
define("CULUMS_OFF16","1.Definitions");
define("CULUMS_OFF17","a. “Product” shall mean the executable version(s) of the networking software made available by Cumulus as explicitly defined in the Order Confirmation(s) (as defined in Section 3(a)) governed by this Agreement and as made available to Licensee, including all updates and new releases of the Product made available to Licensee under this Agreement and the applicable end-user documentation.");
define("CULUMS_OFF18","b. “Proprietary Information” means all inventions, algorithms, know-how and ideas and all other business, technical and financial information a party obtains from the other party if: a) identified as confidential or proprietary at or before disclosure, or b) a reasonable person would presume such information to be confidential given the content or circumstances of the disclosure.");
define("CULUMS_OFF19","c. “Proprietary Rights” shall mean patent rights, copyrights, trade secret rights, sui generis database rights and all other intellectual and industrial property rights of any sort.");
define("CULUMS_OFF20","2.License Grant");
define("CULUMS_OFF21","a. Subject to full payment under Section 3 and to Licensee’s compliance with the other terms and conditions of this Agreement, Cumulus grants to Licensee, and only Licensee, under all Proprietary Rights of Cumulus, a limited, non-exclusive, fully paid-up license only to reproduce and internally use for Licensee’s benefit the Quantity of Purchased Licenses of the Product only for the applicable license term length (the “License Term”), solely on the applicable switch silicon, and solely up to the maximum port speeds as specified in each Order Confirmation (as defined in Section 3(a)).");
define("CULUMS_OFF22","b. The foregoing license does not allow any sublicense, distribution or disclosure of the Product to any third party and Licensee agrees that it will not engage in any such sublicensing, disclosure or distribution.");
define("CULUMS_OFF23","c. Licensee shall not (and shall not allow its personnel or any third party to): (i) modify or create derivative works of the Product; (ii) reverse engineer or attempt to discover any source code or underlying ideas or algorithms of the Product (except to the extent that applicable law prohibits reverse engineering restrictions), (iii) remove or alter any product identification, trademark, copyright or other notices embedded within or appearing within or on the Product; or (iv) publish or otherwise distribute the results of benchmarking or performance studies to third parties without prior written consent from Cumulus. Licensee shall be solely responsible for the observance and compliance with all terms and conditions hereunder by its employees, contractors, service providers and agents and any other third party who has been permitted access to the Product as a result of Licensee’s action or inaction. Licensee shall indemnify, hold harmless and defend Cumulus and its licensors from and against any claims or suits, including attorneys' fees and expenses, which arise or result from any unauthorized or illegal use or distribution of the Product.");
define("CULUMS_OFF24","d. The Product includes open source software packages (collectively, the “Open Source Software”). Each open source software package included in the Product is made available to Licensee in accordance with its applicable open source software package license. In the event of any conflict between an open source software package license and the text of this Agreement, the open source software package license shall control with respect to that specific open source package only.");
define("CULUMS_OFF25","e. The Product is governed by export laws, restrictions, and regulations of the United States. Licensee will not export or re-export, or allow the export or re-export of the Product in violation of any such laws, restrictions or regulations.");
define("CULUMS_OFF26","f. The Product (i) was developed at private expense and includes trade secrets and confidential information; (ii) is a Commercial Item consisting of Commercial Computer Software and Commercial Computer Software Documentation regulated under DFARS Section 227.7202 and FAR Section 12.212 and shall not be deemed to be Noncommercial Computer Software or Noncommercial Computer Software Documentation under any provision of DFARS; and (iii) is NOT offered to US Government agencies under the Commercial Computer Software License set forth at FAR 52.227-19. Consistent with 48 CFR 12.212 and 48 CFR 227.7202 as applicable, the Product is licensed to government end users solely as a Commercial Item and with only those rights as are granted to other end users under the terms of this Agreement. This section 2(f) is in lieu of and supersedes any clause in the FAR, DFAR, or other FAR supplement clauses. Unpublished rights reserved under the copyright laws of the United States.");
define("CULUMS_OFF27","3.Price; Payment; Records.");
define("CULUMS_OFF28","a. During the term of this Agreement, Licensee may place requests for additional Purchased Licenses by submitting orders to either Cumulus or an Authorized Reseller. Cumulus or the Authorized Reseller will respond with a formalized and accepted order confirming the number of Purchased Licenses, the License Term, the total price, any taxes due, and any additional terms and conditions with respect to Purchased Licenses  (each such form, an “Order Confirmation”). Each Order Confirmation is hereby incorporated into this Agreement in its entirety. Each Purchased License set forth on an Order Confirmation shall enable Licensee to create a single copy of the Product and use the copy of the Product in accordance with the License Grant set forth in Section 2.");
define("CULUMS_OFF29","b. During the term of this Agreement, Licensee shall be entitled to buy Purchased Licenses in accordance with the Order Confirmations delivered by Cumulus to Licensee (exclusive of taxes, if any).  If so specified in the corresponding Order Confirmation, previously Purchased Licenses will terminate immediately as set forth in such Order Confirmation and be replaced by new Purchased Licenses (such replacement, the “Conversion”).  The terms applicable to Conversions will be specified in the corresponding Order Confirmation and/or a schedule describing the specifics of such Conversion (such schedule, the “Conversion Notice”).");
define("CULUMS_OFF30","c. Licensee will pay to Cumulus (or an Authorized Reseller) all applicable fees set forth in each Order Confirmation (the “Fees”) within thirty (30) days of receipt of each Order Confirmation, or as otherwise agreed between Licensee and an Authorized Reseller. The applicable currency will be stated on the Order Confirmation; otherwise it is US dollars. Fees are not refundable. Unless explicitly identified as Taxes on the Order Confirmation, all amounts due are exclusive of taxes, withholding, duties, levies, tariffs, and other governmental charges (including without limitation VAT), excluding taxes on net income of Cumulus (collectively, “Taxes”), and Licensee is responsible for payment of all Taxes. The parties will reasonably cooperate to lawfully minimize Taxes. In the event Licensee does not pay Cumulus or an Authorized Reseller any portion of the Fees when due, Licensee shall also pay Cumulus or the Authorized Reseller a late payment fee in the amount of 1.5% of the total amount outstanding per month for the period any such Fees are delinquent, unless otherwise agreed between Licensee and the Authorized Reseller.");
define("CULUMS_OFF31","d. During the Term of this Agreement and for one (1) year following its termination, Licensee will create and maintain records regarding Licensee’s use of the Product, which records shall include, without limitation, each installation of a copy of the Product and a unique identifier for the hardware where it is installed (collectively, 'Records'). At the request of Cumulus, Licensee will promptly provide such Records to Cumulus for the purpose of verifying compliance with this Agreement. In the event that Licensee fails to create, maintain or deliver Records as required under this Section or in the event of any dispute as to the accuracy of such Records, Cumulus may audit Licensee’s use of the Product (e.g., via review of copies of applicable log files, etc.), at any location in which the Product is or has been installed or otherwise utilized by Licensee.");
define("CULUMS_OFF32","4.Delivery and Support.");
define("CULUMS_OFF33","a. After delivery of the first Order Confirmation under this Agreement, Cumulus will promptly deliver to Licensee one copy of the Product in executable form.");
define("CULUMS_OFF34","b. Licensee may order support services from Cumulus as set forth in the corresponding Order Confirmation, and subject to the payment by Licensee of the applicable support fees.  Licensee acknowledges and agrees that Cumulus support is subject to the terms and conditions set forth at the following URL: <a href='javascript:;'>https://cumulusnetworks.com/support/overview/</a> (the “Cumulus Support Program”).");
define("CULUMS_OFF35","c. Unless contractually or legally prohibited from doing so, Cumulus will provide Licensee updates and new releases of the Product that it makes generally commercially available to Cumulus customers, provided Licensee has one or more Purchased Licenses that are in good standing under this Agreement, and Licensee has ordered and paid for the Cumulus Support Program as specified in the corresponding Order Confirmation.");
define("CULUMS_OFF36","5.Publicity; Agreement Disclosure; Trademarks.");
define("CULUMS_OFF37","a. Cumulus shall have the right to reference Licensee as a customer without disclosing the terms of this Agreement. Except as required by law or otherwise set forth in this Agreement, all public announcements regarding the terms of this Agreement shall be coordinated between Cumulus and Licensee by mutual agreement.");
define("CULUMS_OFF38","b. Except as otherwise specified herein, neither party may use any of the other party’s trademarks and service marks (“Marks”) except in accordance with written (including electronic communications) approval of the other party. Licensee grants Cumulus a limited license to use Licensee’s Marks in accordance with Licensee’s Marks usage guidelines for the sole purpose of identifying Licensee as a customer. The parties will not otherwise use or register (or make any filing with respect to) the other party’s Marks anywhere in the world. Neither party will contest anywhere in the world the use by or authorization by the other party of any of such party’s Marks. No other right or license with respect to any trademark, tradename, or other designation is granted under this Agreement.");
define("CULUMS_OFF39","6.Prohibition Against Assignment. Neither this Agreement nor any rights, licenses or obligations hereunder, may be assigned by either party without the prior written approval of the non-assigning party; any prohibited purported assignment shall be void. Notwithstanding the foregoing, either party may assign this Agreement or delegate its rights and obligations to any acquirer of all or of substantially all of such party's assets or business or equity securities pertaining to the subject matter of this Agreement, provided however, that in the event of any such assignment, upon receipt of notice of assignment, the non-assigning party shall have a period of thirty days to terminate this Agreement upon written notice.");
define("CULUMS_OFF40","7.Term of Agreement. The term of this Agreement shall run until the end of the last to expire License Term.  This Agreement will automatically terminate, including the License grants in Section 2 if Licensee fails to comply with any of the conditions in Section 2. This Agreement may be terminated if either party materially fails to perform or comply with this Agreement or any material provision hereof. Termination shall be effective thirty (30) days after notice of termination to the defaulting party if the defaults have not been cured within such thirty (30) day period.");
define("CULUMS_OFF41","8.Survival. Rights to payment, Sections 1, 2(b-e), 3(b), 6, 7, 8, 9, 10, 11, 12, 13 (b-d), and 14 and, except as otherwise expressly provided herein, any right of action for breach of this Agreement prior to termination shall survive any termination of this Agreement. In the event of termination for breach by Cumulus, all Purchased Licenses shall survive termination until the end of the applicable License Term. In the event of termination for Licensee’s breach, all Purchased Licenses shall immediately terminate.");
define("CULUMS_OFF42","9.Notices and Requests. All notices, consents, authorizations, and requests in connection with this Agreement shall be deemed given immediately after they are sent by air express courier, charges prepaid; and addressed with Attention to the Legal Department to the applicable address set forth in the most recent Order Confirmation governed by this Agreement or to such other address as the party to receive the notice or request so designates by written notice under this Section 9 to the other.");
define("CULUMS_OFF43","10.Controlling Law; Attorney’s Fees. This Agreement shall be governed by and construed under the laws of the State of California and the United States without regard to its conflicts of laws provisions and without regard to UCITA or the United Nations Convention on Contracts for the International Sale of Goods. The sole jurisdiction and venue for actions related to the subject matter hereof shall be the California state and U.S. federal courts in Santa Clara County, California. Both parties consent to the jurisdiction and venue of such courts and agree that process may be served in the manner provided herein for giving of notices or otherwise as allowed by California or federal law. The prevailing party in any dispute shall be entitled to recover its reasonable costs attorneys’ fees, and other expenses.");
define("CULUMS_OFF44","11.Confidentiality");
define("CULUMS_OFF45","The pricing terms of this Agreement, the Product and underlying inventions, algorithms, know-how and ideas are Cumulus Proprietary Information . Except as expressly and unambiguously allowed herein, Licensee will hold in confidence and not use or disclose any Proprietary Information and its employees and contractors will be similarly bound in writing. Nothing herein shall permit the receiving party to disclose or use, except as explicitly permitted elsewhere in this Agreement, confidential information of the disclosing party and then only on an “as-needed” basis for purposes of this Agreement. Upon any termination of this Agreement, Licensee will promptly return or destroy any Proprietary Information and any copies, extracts and derivatives thereof, except as otherwise set forth in this Agreement. Additionally, Licensee will promptly delete any and all copies of the Product i) as soon as the applicable Purchased License expires with respect to that copy of the Product; and ii) prior to any distribution of hardware where the Product is installed to any third party, including a hardware reseller or manufacturer. Each party acknowledges that its breach of this Section 11 would cause irreparable injury to the other for which monetary damages are not an adequate remedy. Accordingly, a party will be entitled to seek injunctions and other equitable remedies in the event of such a breach by the other.");
define("CULUMS_OFF46","12.Limited Liability. EXCEPT AS OTHERWISE PROVIDED BELOW, AND NOTWITHSTANDING ANYTHING ELSE IN THIS AGREEMENT OR OTHERWISE, NEITHER PARTY SHALL BE LIABLE OR OBLIGATED UNDER ANY SECTION OF THIS AGREEMENT OR UNDER CONTRACT, NEGLIGENCE, STRICT LIABILITY OR OTHER LEGAL OR EQUITABLE THEORY (A) FOR ANY AMOUNTS IN EXCESS OF THE AGGREGATE OF THE LICENSE FEES PAID TO IT (IN THE CASE OF CUMULUS) OR (IN THE CASE OF LICENSEE) PAID OR OWED BY IT HEREUNDER, OR (B) ANY INCIDENTAL OR CONSEQUENTIAL DAMAGES, LOST PROFITS (EXCEPT AMOUNTS PAYABLE UNDER SECTION 3) OR LOST OR CORRUPTED DATA OR INTERRUPTED USE OR (C) COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR SERVICES. THE LIMITATIONS IN THIS SECTION 12 SHALL NOT APPLY TO BREACHES OF SECTIONS 2(b-e) AND 11 OR TO ACTIONS OF LICENSEE BEYOND THE SCOPE OF THE LICENSE GRANT HEREUNDER.");
define("CULUMS_OFF47","13.Warranty.");
define("CULUMS_OFF48","a. Cumulus warrants to Licensee that the Product will be of good quality and developed using good workmanship in accordance with the highest professional standards. Licensee’s sole remedy for breach of this warranty or for product defects is its rights under Section 4(b). Cumulus makes no warranty regarding freedom from bugs or uninterrupted use.");
define("CULUMS_OFF49",". The Product is not designed, intended, or certified for use in components or systems intended for the operation hazardous systems or applications (e.g. weapons, weapons systems, nuclear installations, means of mass transportation, aviation, life-support computers or equipment (including resuscitation equipment and surgical implants), pollution control, hazardous substances management, or for any other dangerous application) in which the failure of the Product could create a situation where personal injury or death may occur. Licensee understands that use of the Product in such applications is fully at the risk of Licensee, and Licensee hereby assumes all such risk.");
define("CULUMS_OFF50","c. EXCEPT AS EXPRESSLY SET FORTH ABOVE, CUMULUS MAKES NO WARRANTIES TO ANY PERSON OR ENTITY WITH RESPECT TO THE PRODUCT AND DISCLAIMS ALL IMPLIED WARRANTIES, INCLUDING WITHOUT LIMITATION WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT.");
define("CULUMS_OFF51","d. EACH PARTY RECOGNIZES AND AGREES THAT THE WARRANTY DISCLAIMERS AND LIABILITY AND REMEDY LIMITATIONS IN THIS AGREEMENT ARE MATERIAL BARGAINED FOR BASES OF THIS AGREEMENT AND THAT THEY HAVE BEEN TAKEN INTO ACCOUNT AND REFLECTED IN DETERMINING THE CONSIDERATION TO BE GIVEN BY EACH PARTY UNDER THIS AGREEMENT AND IN THE DECISION BY EACH PARTY TO ENTER INTO THIS AGREEMENT.");
define("CULUMS_OFF52","14.General. This Agreement constitutes the entire agreement between the parties with respect to the subject matter hereof and merges all prior and contemporaneous communications. It shall not be modified except by a written agreement dated subsequent to the date of this Agreement and signed on behalf of Licensee and Cumulus by their duly authorized representatives. If any provision of this Agreement shall be held by a court of competent jurisdiction to be illegal, invalid or unenforceable, that provision shall be limited or eliminated to the minimum extent necessary so that this Agreement shall otherwise remain in full force and effect and enforceable. No waiver of any breach of any provision of this Agreement shall constitute a waiver of any prior, concurrent or subsequent breach of the same or any other provisions hereof, and no waiver shall be effective unless made in writing and signed by an authorized represen­tative of the waiving party.");
define("CULUMS_OFF53","Submit");
define("CULUMS_OFF54","Copyright &copy; 2009-".date('Y',time())." FS.COM INC All Rights Reserved.");
define("CULUMS_OFF55","Privacy policy");
define("CULUMS_OFF56","Information submitted successfully. We will send you an email including the license code to activate switch Within 10 mintes.");
define("CULUMS_OFF57","Your Company Name is required");
define("CULUMS_OFF58","Your Telephone Number is required");
define("CULUMS_OFF59","Your Email Address is required");
define("CULUMS_OFF60","The email address you submitted is not recognized.(example: someone@example.com).");
define("CULUMS_OFF61","Please tick the EULA agreement button");
define("CULUMS_OFF62","Your web address is required");
define("CULUMS_OFF63","You have submitted verification information, please do not submit again.");
define("CULUMS_OFF64","Information submitted successfully already, you don't need to submit again.");
define("CULUMS_OFF65","Item Information");
define("CULUMS_OFF66","Share Your Using Experience ");

//加购弹窗
define('FS_ADD_CART_PROCHUSE','Cart Subtotal ');

//地址模块 start
define("FS_ADD_NEW_ADDRESS","Add a New Address");
define('FS_ADD_SHIPPING_ADDRESSES','Add a New Shipping Address');
define("FS_ADD_BILLING_ADDRESS","Add a New Billing Address");
//地址模块 end
define('FS_REGIST','Regist');

//询价弹窗
define("FS_INQUIRY_YOUR_ITEM",'Your Item');

define('FS_SAMPLE_APPLICATION_SUBMIT','Submit...');
define("FS_CLEARANCE_TIP",'Want it faster? Prepay customs and taxes to avoid delays.');
define("FS_CLEARANCE_TIP_ARROW",'For orders shipped to <b class="fs-new-Fontweight600">Malaysia</b>, <b class="fs-new-Fontweight600">Indonesia</b> and <b class="fs-new-Fontweight600">Philippines</b>, you can save the time and troubles required on customs clearance by choosing Forwarder Shipping (with Pre-paid Duties & Taxes) at checkout. <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Read more</a>');
define("CHECKOUT_TAXE_CLEARANCE_CN_FRONT","For orders shipped from our CN Warehouse, we will ONLY charge product value and shipping fees. No sales tax(ex. VAT or GST) will be charged. However, the packages may be assessed import or customs duties, depending on the laws/regulations of the particular countries. Any tariff or import duties caused by customs clearance should be declared and borne by the recipient. For orders shipped to Malaysia, Indonesia and Philippines, we now provide “Forwarder Shipping” as a shipping method to help customers pre-pay the Duties & Taxes generated in customs clearance online. For customers from other areas, please contact us if you need help to pre-pay the customs duty.");

// 上传 start
//2018-9-20 ery add
define('FS_COMMON_FILE','upload file');
//服务器端的提示
define("FS_UPLOAD_ERROR1",'The first attachment\'s error: ');
define("FS_UPLOAD_ERROR2",'The second attachment\'s error: ');
define("FS_UPLOAD_ERROR3",'The third attachment\'s error: ');
define("FS_UPLOAD_ERROR4",'The fourth attachment\'s error: ');
define("FS_UPLOAD_ERROR5",'The fifth attachment\'s error: ');
// 2019.2.26 fairy add
define("FS_UPLOAD_FORMAT_TIP",'Allow files type of $FILE_TYPE');
define("FS_UPLOAD_SIZE_DEFAULT_TIP",'Maximum file size 5M.');
// 上传 end

//信用卡新加坡渠道弹窗
define("GLOABL_TEXT_DECLINED_1","We are sorry that your card was declined for one of below reasons:");
define("GLOABL_TEXT_DECLINED_2","1.Please be sure that no more than 2 unique Billing Address per card number or per email address appears in 30 days.");
define("GLOABL_TEXT_DECLINED_3","2.Please be sure that the card issuing country is same from country of shipping address in the order.");
define("GLOABL_TEXT_DECLINED_8","3.Please be sure that the billing address in the order is exactly as it appears on your credit card statement.");
define("GLOABL_TEXT_DECLINED_4","You may contact your card bank for reasons at first, and if your card issue can not be resolved shortly, we suggest to change another card or switch into Paypal, Bank Transfer or Check to pay the order.");
define("GLOABL_TEXT_DECLINED_5","Your card was declined by the issuing bank");
define("GLOABL_TEXT_DECLINED_6","Your card may have been declined for a variety of reasons, common reasons include:");

define("GLOABL_TEXT_DECLINED_7","Please contact your bank or card issuer to find out the specific reason, since they are the one declining the transaction. Or you may use another credit card or switch the payment method into paypal or Bank Transfer to pay the order.");
define("GLOABL_TEXT_DECLINED_9","Click here to pay with other payment method.");
define("GLOABL_TEXT_DECLINED_10","Please split order if the total amount is over €15000.00, or");
define("GLOABL_TEXT_DECLINED_11"," click here ");
define("GLOABL_TEXT_DECLINED_12","to pay with other payment method.");

define('FS_CLEARACNE_05','View all');
define('FS_CLEARACNE_06','load more');

//退换货提示
define('FS_ACCOUNT_HISTORY_1','Please confirm receipt of the package, return&amp;replace will be activited.');

//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"Share Your Using Experience #");
define('EMAIL_COMMON_FOOTER_NEW_02',"You are subscribed to this email as ");
define('EMAIL_COMMON_FOOTER_NEW_03',"Click here to modify your preferences or unsubscribe.");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS.COM Inc, 380 Centerpoint Blvd, New Castle, DE 19720");
define('EMAIL_COMMON_FOOTER_NEW_05',"Contact Us");
define('EMAIL_COMMON_FOOTER_NEW_06',"My Account");
define('EMAIL_COMMON_FOOTER_NEW_07',"Shipping &amp; Delivery");
define('EMAIL_COMMON_FOOTER_NEW_08',"Return Policy");
define('EMAIL_COMMON_FOOTER_NEW_09'," All Rights Reserved.");
define('EMAIL_COMMON_FOOTER_NEW_10',"Copyright &copy; ");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"You've successfully changed your password. Your new password is ready to use immediately across all of our sites.");
define('RESET_PASS_SUCCESS_02','Sign in to Your Account');
define('RESET_PASS_SUCCESS_03',"If you didn't ask to change your password, please reply to this email or call us at +1 (888) 468 7419.");
define('RESET_PASS_SUCCESS_04','Thanks<br>The FS Team');
define('RESET_PASS_SUCCESS_05','Dear');
define('RESET_PASS_SUCCESS_TITLE','Password Update');
define('RESET_PASS_SUCCESS_THEME','Your password has been updated');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"We have received a request to reset your password for your FS account. If you did not make this request simply ignore this email and everything will be fine. If you did make this request just click the button below to get yourself a brand new password.");
define('RESET_PASS_SEND_02',"Set New Password");
define('RESET_PASS_SEND_03',"P.S. If you're having trouble clicking the password reset button, copy and paste the password reset code below into your reset page.");
define('RESET_PASS_SEND_04',"Thanks<br>The FS Team");
define('RESET_PASS_SEND_05',"Dear");
define('RESET_PASS_SEND_06',"No password? no problem. we will help you reset it.");
define('RESET_PASS_SEND_TITLE','Reset Password');
define('RESET_PASS_SEND_THEME','Password Reset Instructions');
define('RESET_PASS_EXPIRE_TIME','This password reset code will expire in 4 hours. To get a new password reset link, visit
<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>');

//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"Your email address has been changed to ");
define('RESET_EMAIL_SUCCESS_02','Dear');
define('RESET_EMAIL_SUCCESS_03','Use this address to access your ');
define('RESET_EMAIL_SUCCESS_04',"My Account");
define('RESET_EMAIL_SUCCESS_05'," details.");
define('RESET_EMAIL_SUCCESS_06',"If you didn't ask to change your details, please visit ");
define('RESET_EMAIL_SUCCESS_07',"Thanks<br>The FS Team");
define('RESET_EMAIL_SUCCESS_TITLE','Email Address Updated');
define('RESET_EMAIL_SUCCESS_THEME','FS - Your email address has been updated');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"Your account has been successfully created. Now you can sign in with your email and password.");
define('REGIST_EMAIL_SEND_02',"Dear");
define('REGIST_EMAIL_SEND_03',"Your account has been successfully created. Now you can ");
define('REGIST_EMAIL_SEND_04',"sign in");
define('REGIST_EMAIL_SEND_05'," with your email and password.");
define('REGIST_EMAIL_SEND_06',"After logging in, you can:");
define('REGIST_EMAIL_SEND_07',"Manage your ");
define('REGIST_EMAIL_SEND_08',"FS account profile");
define('REGIST_EMAIL_SEND_09'," and request access to FS services easily.");
define('REGIST_EMAIL_SEND_10',"Submit ");
define('REGIST_EMAIL_SEND_11',"technical support request");
define('REGIST_EMAIL_SEND_12'," and get free & immediate response.");
define('REGIST_EMAIL_SEND_13',"Make a purchase online and track order status anytime.");
define('REGIST_EMAIL_SEND_14',"Thanks<br>The FS Team");
define('REGIST_EMAIL_SEND_15',"Your account has been successfully created, the account number is ");
define('REGIST_EMAIL_SEND_16',". Now you can ");
define('REGIST_EMAIL_SEND_TITLE','Account Created');
define('REGIST_EMAIL_SEND_THEME','Your new FS account is ready to use!');

//企业用户注册(新用户注册)
define('REGIST_COM_EMAIL_SEND_01','We\'ve received your request for a business account. It is currently under review and this process can take up 1-3 business days.');
define('REGIST_COM_EMAIL_SEND_03','We\'ve received your request for a business account. It is currently under review and this process can take up 1-3 business days.
When a decision has been reached, you will be notified by FS mail timely.');
define('REGIST_COM_EMAIL_SEND_02','Dear');
define('REGIST_COM_EMAIL_SEND_04','Before approved,  you can ');
define('REGIST_COM_EMAIL_SEND_05','sign in');
define('REGIST_COM_EMAIL_SEND_06',' with your email and password and enjoy standard account services first.');
define('REGIST_COM_EMAIL_SEND_07','After logging in, you can:');
define('REGIST_COM_EMAIL_SEND_08','Manage your ');
define('REGIST_COM_EMAIL_SEND_09','FS account profile');
define('REGIST_COM_EMAIL_SEND_10',' and request access to FS services easily.');
define('REGIST_COM_EMAIL_SEND_11','Submit ');
define('REGIST_COM_EMAIL_SEND_12','technical support request');
define('REGIST_COM_EMAIL_SEND_13',' and get free & immediate response.');
define('REGIST_COM_EMAIL_SEND_14','Make a purchase online and track order status anytime.');
define('REGIST_COM_EMAIL_SEND_15','Thanks<br>The FS Team');
define('REGIST_COM_EMAIL_SEND_TITLE','Request Received');
define('REGIST_COM_EMAIL_SEND_THEME','FS - Your Business Account request received');

//新注册邮件语言包
define('REGIST_EMAIL_SEND_NEW_01',"Account Created");
define('REGIST_EMAIL_SEND_NEW_02',"Welcome to FS");
define('REGIST_EMAIL_SEND_NEW_03',"Global Leading Internet Communications Devices & Solution Provider");
define('REGIST_EMAIL_SEND_NEW_04',"Quality Commitment");
define('REGIST_EMAIL_SEND_NEW_05',"Quality Assurance, Customer Focus, and Sustainable Management");
define('REGIST_EMAIL_SEND_NEW_06',"Personalized Solutions");
define('REGIST_EMAIL_SEND_NEW_07',"Providing Innovative, Cost-effective, and Reliable One-stop Solution.");
define('REGIST_EMAIL_SEND_NEW_08',"Accelerated Delivery");
define('REGIST_EMAIL_SEND_NEW_09',"Local Warehouses, Adequate Inventory, and Free Shipping Policy.");
define('REGIST_EMAIL_SEND_NEW_10',"Deliver expertise and technical support, <br> respond quickly to move your business <br> forward.");
define('REGIST_EMAIL_SEND_NEW_11',"Visit our blog, wiki, cases, and <br> announcements to find solutions to <br> outstanding recommendations.");
define('REGIST_EMAIL_SEND_NEW_12',"Get Started");
define('REGIST_EMAIL_SEND_NEW_13',"FS Tech Support");
define('REGIST_EMAIL_SEND_NEW_14',"FS Community");

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','We\'ve received your request to upgrade your account. It is currently under review and this process can take up 1-3 business days.
');
define('REGIST_COM_EMAIL_UPGRADE_02','Dear');
define('REGIST_COM_EMAIL_UPGRADE_03','We\'ve received your request to upgrade your account. It is currently under review and this process can take up 1-3 business days. When a decision has been reached, you will be notified by FS mail timely.');
define('REGIST_COM_EMAIL_UPGRADE_04','Thanks<br>The FS Team');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','Request Received');
define('REGIST_COM_EMAIL_UPGRADE_THEME','FS - Your Business Account request received');

//订单邮件语言包
define('FS_ORDER_EMAIL_01','Thanks for choosing FS. We\'ve received your pending order ');
define('FS_ORDER_EMAIL_02','. Complete the payment and your order can be in the process asap.');
define('FS_ORDER_EMAIL_03','Details for your order ');
define('FS_ORDER_EMAIL_04',' are below. We\'ll send you tracking information as soon as an item from your order ships.');
define('FS_ORDER_EMAIL_05','Details for your order ');
define('FS_ORDER_EMAIL_06',' are below. As you\'ve chosen "Pickup at the warehouse", we will email you pickup instruction once your order is ready.');
define('FS_ORDER_EMAIL_07','Thanks for choosing FS. We\'ve received your pending order. Complete the payment and your order can be in the process asap.');
define('FS_ORDER_EMAIL_08','Detail for your orders are below. As you\'ve chosen "Pickup at the warehouse", we will email your pickup instrution once your order is ready.');
define('FS_ORDER_EMAIL_09','Thank you for shopping with us. Details for your orders are below. We\'ll send you tracking information as soon as an item from your order ships.');
define('FS_ORDER_EMAIL_10','Order');
define('FS_ORDER_EMAIL_11','Your purchase has been divided into ');
define('FS_ORDER_EMAIL_12',' orders.');
define('FS_ORDER_EMAIL_13','Manage Orders');
define('FS_ORDER_EMAIL_14','Order');
define('FS_ORDER_EMAIL_15','Ordered');
define('FS_ORDER_EMAIL_16','Estimated Shipped');
define('FS_ORDER_EMAIL_17','Expected Delivery');
define('FS_ORDER_EMAIL_18','Not to worry, we\'ll let you know as soon as your items ship. For an up-to-date status of your order, you can check ');
define('FS_ORDER_EMAIL_19','My Account');
define('FS_ORDER_EMAIL_20',' at any time.');
define('FS_ORDER_EMAIL_21','If you need to change or cancel your order, visit ');
define('FS_ORDER_EMAIL_22','. Please note that you will no longer be able to make any changes once your items ship.');
define('FS_ORDER_EMAIL_23','Not to worry, we\'ll let you know as soon as your items ship. For an up-to-date status of your order, you can contact us at any time.');
define('FS_ORDER_EMAIL_24','If you need to change or cancel your order, please contact your account manager. Please note that you will no longer be able to make any changes once your items ship.');
define('FS_ORDER_EMAIL_25','Complete the payment and your order can be in the process asap.');
define('FS_ORDER_EMAIL_26','Order Received');
define('FS_ORDER_EMAIL_27','Order Processing');
define('FS_ORDER_EMAIL_28','Dear ');
define('FS_ORDER_EMAIL_29','Delivery Details');
define('FS_ORDER_EMAIL_30','Shipping to');
define('FS_ORDER_EMAIL_31','Contact information');
define('FS_ORDER_EMAIL_32','Frequently Asked Questions');
define('FS_ORDER_EMAIL_33','Where\'s the item I ordered?');
define('FS_ORDER_EMAIL_34','How do I change my order?');
define('FS_ORDER_EMAIL_35','Payment Details');
define('FS_ORDER_EMAIL_36','Subtotal:');
define('FS_ORDER_EMAIL_37','Shipping:');
define('FS_ORDER_EMAIL_38','Total Cost:');
define('FS_ORDER_EMAIL_39','Payment Method:');
define('FS_ORDER_EMAIL_40','All charges will appear as <a style="color: #0070BC;text-decoration: none" href="javascript:;">FS COM</a>.');
define('FS_ORDER_EMAIL_41','Billing to');
define('FS_ORDER_EMAIL_42','Thanks for your order. See inside for details from your order.');
define('FS_ORDER_EMAIL_43','FS - We received your Pending Order %s');
define('FS_ORDER_EMAIL_44','Pickup address');
define('FS_ORDER_EMAIL_45','Pickup person');
define('FS_ORDER_EMAIL_46','. Upload the PO file and your order can be in the process asap');
define('FS_ORDER_EMAIL_47','FS - Thanks for your Order %s');
define('FS_ORDER_EMAIL_48','Purchase Order');
define('FS_ORDER_EMAIL_49','Ready');
define('FS_ORDER_EMAIL_50','Pick Up');
//2019.4.9 新增俄罗斯对公支付 邮件语言包 [ORDERNUMBER]不需要翻译保留即可，只有一单时会替换成对应的订单号，多单时会替换为空
define('FS_ORDER_EMAIL_51', "Thanks for choosing FS. We've received your pending order[ORDERNUMBER]. Our account manager will send the invoice to your email as soon as possible.");
define('FS_ORDER_EMAIL_52','Please check your payment details:');
define('FS_ORDER_EMAIL_53','Contact person');
define('FS_ORDER_EMAIL_54','Phone number*');
define('FS_ORDER_EMAIL_55','E-mail*');
define('FS_ORDER_EMAIL_56','Name of the organization*');
define('FS_ORDER_EMAIL_57','INN*');
define('FS_ORDER_EMAIL_58','KPP*');
define('FS_ORDER_EMAIL_59','OKPO');
define('FS_ORDER_EMAIL_60','BIC*');
define('FS_ORDER_EMAIL_61','Legal address*');
define('FS_ORDER_EMAIL_62','Postal address');
define('FS_ORDER_EMAIL_63','Correspondent account');
define('FS_ORDER_EMAIL_64','Bank name*');
define('FS_ORDER_EMAIL_65','Settlement account*');
define('FS_ORDER_EMAIL_66','Full name of the holder');
define('FS_ORDER_EMAIL_67','Payment Information');
define('FS_ORDER_EMAIL_68','Length');
define('FS_ORDER_EMAIL_09_1','Your purchase has been divided into 2 orders ');
define('FS_ORDER_EMAIL_09_2','Details are below. We\'ll send you an email as soon as an update comes from your orders.');
define('FS_ORDER_EMAIL_69','You can track the progress of your order by logging into your account and going to the ');
define('FS_ORDER_EMAIL_70','Order History');
define('FS_ORDER_EMAIL_71',' page.');
define('FS_ORDER_EMAIL_72','Payment Received');
define('FS_ORDER_EMAIL_73','In Progress');
define('FS_ORDER_EMAIL_74','In Transit');
define('FS_ORDER_EMAIL_75','Delivered');
define('FS_ORDER_EMAIL_76','PO Confirmed');
define('FS_ORDER_EMAIL_ALFA_01','We will send you an invoice based on the uploaded payment information within 24 hours. You can view your uploaded files in <a style="color: #0070BC;text-decoration:none" href="'.zen_href_link('my_companies').'" target="_blank">Account-Companies</a>.');
//详情页定制产品加购弹窗
define('FS_CUSTOMIZED_INFORMATION','Customized Information');
define('FS_CUSTOMIZED','Customized');
define('FS_PROCESSING','Processing');
define('FS_SHIPPING','Shipping');
define('FS_DELIVERED','Delivered');
define('FS_PROCESSING_EST','Processing: ');
define('FS_SHIPPING_EST','Shipping: ');
define('FS_DELIVERED_EST','Delivered: ');
define('FS_BUSINESS_DAYS_ADD',' business days');
define('FS_BUSINESS_DAYS_DELIVER_TO',' business days, deliver to ');
define('FS_EST','Est. ');
define('FS_CUSTOMIZED_ADD_TO_CART','Confirm');
define('FS_KEEP_SHOPPING','Keep Shopping');
define('FS_CONTINUE_TO_CART','Continue to Cart');


define('FS_PRODCUTS_INFO_VIEW','View Full Spec:');
define('FS_PRODUCTS_INFO_VIEW_NEW','See more');

// 2019.2.27 fairy add 预售产品相关功能
define('FS_PRE_ORDER','Pre-Order');
define('FS_DAY_PROCESSING','<span class="process_time_dylan">$DAYNUMBER</span>-Day Processing Time');
define('FS_DAY_PROCESSING_SEARCH','<span class="process_time_dylan">$DAYNUMBER</span>-Day Processing Time');
define("PREORDER_DESPRCTION","Pre-Order is specialized in R&D and customer-oriented assembly line based on achieving economies of scale and automated manufacturing, enable us to provide bulk-purchase and project customers, whose budget is controlled strictly, with highly cost-effective items as well as guarantee a much faster delivery than fellow traders.");

//邮件系统改版语言包
//在线询价(A)
define('FS_SEND_EMAIL','FS - We received your quote request ');
define('FS_SEND_EMAIL_1',"We've received your quote request ");
define('FS_SEND_EMAIL_2'," and will email you with quotation details within one business day.");
define('FS_SEND_EMAIL_3',"Request Received");
define('FS_SEND_EMAIL_3_1','We received your sample request $CASENUMBER');
define('FS_SEND_EMAIL_4'," and will email you with quotation details within one business day.");
define('FS_SEND_EMAIL_5',"Your message");
define('FS_SEND_EMAIL_6',"Quote List");
define('FS_SEND_EMAIL_7',"Your additional notes");
define('FS_SEND_EMAIL_8',"Qty: ");
//在线技术咨询A
define('FS_SEND_EMAIL_8_1','FS - We received your support request ');
define('FS_SEND_EMAIL_8_2', 'FS - We received your product technical request ');//product_support页面，发送邮件
define('FS_SEND_EMAIL_9',"Thank you for contacting FS and your case number is ");
define('FS_SEND_EMAIL_10',". Our technical support team will get back to you within 6-18 hours.");
define('FS_SEND_EMAIL_10_1',". We will get back to you within 6-18 hours.");//product_support页面，发送邮件
//产品QA邮件
define('FS_SEND_EMAIL_11',"FS -  We received your question regarding item #");
define('FS_SEND_EMAIL_12',"Question Received");
define('FS_SEND_EMAIL_12_1',"We've received your question regarding item #");
define('FS_SEND_EMAIL_13'," and will get back to you within one business day.");
define('FS_SEND_EMAIL_14',"We've received your question regarding item ");
define('FS_SEND_EMAIL_15'," and will get back to you within one business day.");
//退换货all
define('FS_SEND_EMAIL_16',"We're on it");
define('FS_SEND_EMAIL_17',"We've received your request regarding your problems with order ");
define('FS_SEND_EMAIL_18',"Thanks for letting us take care of this for you!");
define('FS_SEND_EMAIL_19',"FS - We received your support request ");
define('FS_SEND_EMAIL_20',"Thank you for contacting FS. We've received your support request and will get back to you within one business day.");
define('FS_SEND_EMAIL_21',"Thank you for contacting FS. We've received your support request and will get back to you within one business day. And your case number is");
define('FS_SEND_EMAIL_22',"We've received your stock request regarding item #");
define('FS_SEND_EMAIL_23'," and will get in touch with you within one business day.");
define('FS_SEND_EMAIL_24',"We've received your stock request regarding item ");
define('FS_SEND_EMAIL_25'," and will get in touch with you within one business day. And here is your case number ");
define('FS_SEND_EMAIL_26',". You can refer to this number in all follow-up communications regarding this request.");
define('FS_SEND_EMAIL_27',"Your Item");
define('FS_SEND_EMAIL_28',"Your additional notes");
define('FS_SEND_EMAIL_29',"Request Qty: ");
define('FS_SEND_EMAIL_30'," Request Arrival Date: ");
define('FS_SEND_EMAIL_31',"FS -  We received your stock request ");
define('FS_SEND_EMAIL_32',"FS - We received your refund request");
define('FS_SEND_EMAIL_33',"We've received your refund request and will email you with more information within one business day.");
define('FS_SEND_EMAIL_34',"FS - We received your replacement request");
define('FS_SEND_EMAIL_35',"We've received your replacement request and will email you with more information within one business day.");
define('FS_SEND_EMAIL_36',"FS - We received your maintenance request");
define('FS_SEND_EMAIL_37',"We've received your Maintenance request and will email you with more information within one business day.");
define('FS_SEND_EMAIL_38'," Instructions for your FS return");
define('FS_SEND_EMAIL_39',"Follow these steps to complete your return for your order #");
define('FS_SEND_EMAIL_40',"Returning Order");
define('FS_SEND_EMAIL_41'," and will email you with more information about your Refund parts within one business day.");
define('FS_SEND_EMAIL_42'," and will email you with more information about your Replacement parts within one business day.");
define('FS_SEND_EMAIL_43'," and will email you with more information about your Maintenance parts within one business day.");
define('FS_SEND_EMAIL_44',"Refund parts");
define('FS_SEND_EMAIL_45',"Replacement parts");
define('FS_SEND_EMAIL_46',"Maintenance parts");
define('FS_SEND_EMAIL_47',"Refund");
define('FS_SEND_EMAIL_48',"We're sorry to hear that the item(s) from your order");
define('FS_SEND_EMAIL_49'," weren't right for you. To complete your return, follow these simple steps:");
define('FS_SEND_EMAIL_50',"Upon receipt of the returned item(s), we will issue a refund of ");
define('FS_SEND_EMAIL_51'," to your original payment method within 1 business day. The money will be in your account within a week");
define('FS_SEND_EMAIL_52'," Overview");
define('FS_SEND_EMAIL_53',"Item(s) Cost Credit:");
define('FS_SEND_EMAIL_54',"Return Shipping Cost:");
define('FS_SEND_EMAIL_55',"Total Return Refund:");
define('FS_SEND_EMAIL_56',"Refund Method:");
define('FS_SEND_EMAIL_57',"Original Payment Method ");
define('FS_SEND_EMAIL_58',"For information on our Return Policy, ");
define('FS_SEND_EMAIL_59',"click here");
define('FS_SEND_EMAIL_60',"Replacement");
define('FS_SEND_EMAIL_61',"We're sorry to hear that you've had problems with your order");
define('FS_SEND_EMAIL_62'," To complete your replacement, follow these simple steps:");
define('FS_SEND_EMAIL_63',"Upon receipt of the returned item(s), we'll arrange the shipment of replacement order as soon as possible and send you tracking information when available.");
define('FS_SEND_EMAIL_64',"Maintenance");
define('FS_SEND_EMAIL_67',"Upon receipt of the returned item(s), we'll arrange the shipment of Maintenance order as soon as possible and send you tracking information when available.");
define('FS_SEND_EMAIL_68',"Overview");
define('FS_SEND_EMAIL_69',"Shipping to");
define('FS_SEND_EMAIL_70',"Contact information");
define('FS_SEND_EMAIL_71',"Ref: PO#");
define('FS_SEND_EMAIL_83',"Price: ");
//样品申请邮件
define('FS_SEND_EMAIL_84',"We've received your sample request and will update you the results within 24 hours.");
define('FS_SEND_EMAIL_85',"We've received your sample request and a dedicated manager from our team will be in touch soon. And here is your case number ");
define('FS_SEND_EMAIL_86',". You can refer to this number in all follow-up communications regarding this request.");
define('FS_SEND_EMAIL_87',"Sample List");
define('FS_SEND_EMAIL_88',"Request Qty: ");
define('FS_SEND_EMAIL_89',"Your additional notes");
define('FS_SEND_EMAIL_90',"FS - We received your sample request ");
//cumlums交换机发送激活码邮件
define('FS_SEND_EMAIL_91',"License Key");
define('FS_SEND_EMAIL_92',"Your activation information has been submitted successfully.");
define('FS_SEND_EMAIL_94',"Your license key as well as your order details are provided below. You will have to install this license key on the switch to activate the software. This license key is unique to your account. We will take about 3 days to help you activate it. Please copy and paste the license key text at the appropriate time during the license installation process.");
define('FS_SEND_EMAIL_95',"Please note: The license key will be long-term and effective. The technical support service period is 1 year but you can enjoy an extra 45 days free if you install within 45 days.");
define('FS_SEND_EMAIL_96',"If you have any questions or need assistance, please contact us at ");
define('FS_SEND_EMAIL_97',"License Key");
define('FS_SEND_EMAIL_98',"For Cumulus Linux 2.5.3 or later versions:");
define('FS_SEND_EMAIL_99',"Order No.: ");
define('FS_SEND_EMAIL_100',"Date: ");
define('FS_SEND_EMAIL_101',"View More");
define('FS_SEND_EMAIL_102',"FS - License Key");
//付款链接
define('FS_SEND_EMAIL_103',"<br>Remark:");
define('FS_SEND_EMAIL_104'," sent you a payment request");
define('FS_SEND_EMAIL_105',"Invoice No. : ");
define('FS_SEND_EMAIL_106',"Pay Now");
define('FS_SEND_EMAIL_107',"FS - You have a payment request from ");
//分享购物车
define('FS_SEND_EMAIL_108',"Share Cart List");
define('FS_SEND_EMAIL_109',"Your friend ");
define('FS_SEND_EMAIL_110'," shared a cart list with you.");
define('FS_SEND_EMAIL_111',"Your friend ");
define('FS_SEND_EMAIL_112'," shared a cart list with you. You can click button below to view complete details and add to your own cart list.");
define('FS_SEND_EMAIL_113',"Cart List");
define('FS_SEND_EMAIL_115',"This email was sent by ");
define('FS_SEND_EMAIL_116'," using ");
define('FS_SEND_EMAIL_117',"'s Share With A Friend service.");
define('FS_SEND_EMAIL_118',"As a result of receiving this message, you will not receive any unsolicited message from ");
define('FS_SEND_EMAIL_119',"learn more about our ");
define('FS_SEND_EMAIL_120',"Privacy Policy");
define('FS_SEND_EMAIL_121',"FS - Your friend ");
define('FS_SEND_EMAIL_122'," shared you a cart list");
//分享产品
define('FS_SEND_EMAIL_123',"Share Item");
define('FS_SEND_EMAIL_124',"You might be interested in this item");
define('FS_SEND_EMAIL_125',"More details");
define('FS_SEND_EMAIL_126',"'s Share With A Friend service. As a result of receiving this message, you will not receive any unsolicited message from ");
define('FS_SEND_EMAIL_127'," learn more about our ");
define('FS_SEND_EMAIL_129'," shared you an item");
//RMA取消订单邮件
define('FS_SEND_EMAIL_130',"RMA Update");
define('FS_SEND_EMAIL_131',"Your RMA application for order# ");
define('FS_SEND_EMAIL_132'," has been canceled. We're here to support for your any further problem.");
define('FS_SEND_EMAIL_133',"Canceled RMA");
define('FS_SEND_EMAIL_135'," has been canceled.");
define('FS_SEND_EMAIL_136',"We're here to support for your any further problem.");
define('FS_SEND_EMAIL_137',"RMA Parts");
//订单评价成功邮件
define('FS_SEND_EMAIL_138'," sent you a payment request.");
define('FS_SEND_EMAIL_139',"Order Update");
define('FS_SEND_EMAIL_140',"Your Order #");
define('FS_SEND_EMAIL_141',"Canceled Order");
define('FS_SEND_EMAIL_142',"Thank you for shopping with us and we hope to see you again soon.");
define('FS_SEND_EMAIL_143',"Order Details");
//留言入口客户调查问卷
define('FS_SEND_EMAIL_144',"Share Feedback");
define('FS_SEND_EMAIL_145',"How likely are you to recommend FS to a friend or colleague?");
define('FS_SEND_EMAIL_146',"To ensure you enjoy the best shopping experience possible,<br>please answer the question above. When you respond, you'll be asked to give a<br>short explanation for your rating. All feedback is extremely helpful.");
//live_chat留言
define('FS_SEND_EMAIL_147',"Topic of the Feedback");
define('FS_SEND_EMAIL_148',"Thank you for contacting FS. We've received your email and will get back to you within 12 hours.\"");
define('FS_SEND_EMAIL_149',"FS - We received your email message");
define('FS_SEND_EMAIL_150',"Thank you for contacting FS. We've received your email and will get back to you within 12 hours. And your case number is ");
define('FS_SEND_EMAIL_151',"Share Item");
define('FS_SEND_EMAIL_152',"You might be interested in this item");
define('FS_SEND_EMAIL_153',"Your friend ");
define('FS_SEND_EMAIL_154'," This email was sent by ");
define('FS_SEND_EMAIL_155'," shared this item with you via ");
define('FS_SEND_EMAIL_156',"FS - Your RMA has been canceled");
define('FS_SEND_EMAIL_157',"FS - We received your quote request ");
define('FS_SEND_EMAIL_158',"Message from");
define('FS_SEND_EMAIL_159',"Add to List");
//退换货
define('FS_SEND_EMAIL_160',"Your Order #");
define('FS_SEND_EMAIL_160_01',"FS - Your Order #");
define('FS_SEND_EMAIL_161',"FS - Your FS Orde ");
define('FS_SEND_EMAIL_162',"Returning Instruction");
define('FS_SEND_EMAIL_163',"1. Print RMA");
define('FS_SEND_EMAIL_164',"RMA can help us distinguish your package. Print the RMA form and attach it on box.");
define('FS_SEND_EMAIL_165',"2. Package the item(s)");
define('FS_SEND_EMAIL_166',"Remove old labels if you‘ re using the original box(es) and attached the RMA");
define('FS_SEND_EMAIL_167',"3. Ship it");
define('FS_SEND_EMAIL_168',"Send the package back to us");
define('FS_SEND_EMAIL_169',"4. Receive Your");
//live_chat_phone留言发客戶售邮件
define('FS_SEND_EMAIL_170',"Thank you for contacting FS. We've received your call request and will get back to you at your best time to get in touch.");
define('FS_SEND_EMAIL_171',"FS - We received your call request");
define('FS_SEND_EMAIL_3_1',"Payment Request");





//define("PRERDER_PROCESSIONG","The processing time calculated using business days includes material procurement and product assembly. It is separate from the shipping time.");
define("PRERDER_PROCESSIONG","<i class='popover_i'></i>The processing time refers to business day, includes manufacturing and testing, except shipping as it is determined by shipping speed you've chosen.");
define("PRERER_SAVE"," to save your project budget");

//quest add 2019-03-01
define('CHECKOUT_CUSTOMER_ACCOUNT1','Please enter a valid account consisted of 9 numbers');
define('CHECKOUT_CUSTOMER_ACCOUNT2','Please enter a valid account consisted of 6 characters');

// fairy 2019.1.17 组合子产品
define("FS_ITEM_INCLUDES_PRODUCTS","This item includes the following products");





define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total general');
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');

define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+)Shipping Cost:');
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Total');
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');

define('MODULE_ORDER_TOTAL_INSURANCE_TITLE', 'Insurance');

//2019.3.9   ery  add 专题询价板块
define('FS_SPECILA_INQUIRY_QUESTION', 'Questions? We’ll put you on the right path.');
define('FS_SPECILA_INQUIRY_ASK', 'Ask about pricing, delivery or anything else. Our highly trained reps are standing by, ready to help.');

//rebirth.ma  2019.03.12  上传错误定义
define("FS_FILE_TOO_LARGE","File too large, upload failed");

define('FIBERSTORE_PRODUCT_DETAIL','Product Details');

//rebirth.ma  2019.03.22  购物车样式调整
define("FS_Summary","Summary");

//liang.zhu 2019.04.02 定义tpl_modules_index_product_list_old_style.php
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'View in a grid');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'View in a list');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'Quickfinder');

//fs shipping
define("SHIPPING_COURIER_DELIVERY","Courier delivery for Legal Person");
define("SHIPPING_COURIER_DELIVERY_01"," for Nature Person");
define("SHIPPING_DELIVERY","Delivery");
//2019.4.11  ery add  俄罗斯对公支付收税政策文字表达优化
define('CHECKOUT_TAXE_RU_TIT', 'In accordance with Chapter 21 of the Tax Code of the Russian Federation, FS.COM Ltd is obliged to charge VAT on all orders delivered to Russia. All products from our catalog are subject to standard VAT of 20% of the cost in accordance with the General Tax Law of Russia. You will know the total amount, including VAT, before making the payment, if you fill in all the necessary information about the order (including the type of enterprise and delivery address).');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","For orders from natural person and shipped from our international warehouse, we will ONLY charge product value and shipping fees. Any tariff or import duties caused by customs clearance should be declared and borne by the recipient. From January 1, 2020, the threshold for duty free purchases has been lowered to 200 € and up to 31 kg per package. If you are interested in other delivery methods or want to pay by cashless payment, please contact your account manager.");
define("FS_EMAIL_ERROR","Your email address is not correct");
define("FS_CREDIT_CARD_NOTICE","Please enter your billing address to proceed the payment");

//报价改版 ternence 2019.04.17
define("FS_INQUIRY_INFO","Quote Sheet");
define("FS_INQUIRY_INFO_1","Add New Products");
define("FS_INQUIRY_INFO_2","Add");
define("FS_INQUIRY_INFO_3","The online product ID can't be empty.");
define("FS_INQUIRY_INFO_4","Unit Price");
define("FS_INQUIRY_INFO_5"," Take a Note ");
define("FS_INQUIRY_INFO_6","Edit");
define("FS_INQUIRY_INFO_7","Have an Existing Account?");
define("FS_INQUIRY_INFO_8","Sign in</a> or ");
define("FS_INQUIRY_INFO_9","Create an Account");
define("FS_INQUIRY_INFO_10","  to track your request online.");
define("FS_INQUIRY_INFO_11","Information You May Care About The Quote");
define("FS_INQUIRY_INFO_12","Logo");
define("FS_INQUIRY_INFO_13","Warranty");
define("FS_INQUIRY_INFO_14","Lead Time");
define("FS_INQUIRY_INFO_15","Bulk Price");
define("FS_INQUIRY_INFO_16","PO Order");
define("FS_INQUIRY_INFO_17","Additional Comments");
define("FS_INQUIRY_INFO_18","File");
define("FS_INQUIRY_INFO_19","Allow files type of JPG, PDF, PNG, XLS, XLSX <br> Maximum file size 5M");
define("FS_INQUIRY_INFO_20","Submit Request");
define("FS_INQUIRY_INFO_21","The quote request is empty.");
define("FS_INQUIRY_INFO_22","Continue Shopping");
define("FS_INQUIRY_INFO_24","It will take us about 12 hours for reviewing.");
define("FS_INQUIRY_INFO_25","Request Quote");
define("FS_INQUIRY_INFO_26","Below item is a customize product, please go to product page to select attribute first and then add to quote list");
define("FS_INQUIRY_INFO_26_2","The product ID");
define("FS_INQUIRY_INFO_26_3","was not found in our records.");
define("FS_INQUIRY_INFO_27","Your request for quote No.");
define("FS_INQUIRY_INFO_28"," was submitted.");
define("FS_INQUIRY_INFO_29","We will process the quote and reply you within 12-24 hours. You can view quote status in <b>My Account</b> > <b>Quote History</b>. ");
define("FS_INQUIRY_INFO_30","Hello Guest! ");
define("FS_INQUIRY_INFO_30_1","Select Attribute ");
define("FS_INQUIRY_INFO_31","With an account, you can easily view the quote in your account and also gain a better FS service including:");
define("FS_INQUIRY_INFO_32","- Easily track via your order history");
define("FS_INQUIRY_INFO_33","- Faster checkout with an address book");
define("FS_INQUIRY_INFO_34","Would you like to create an account now?");
define("FS_INQUIRY_INFO_35","No, thanks. (We'll reply to your quote through email )");
define("FS_INQUIRY_INFO_36","Yes, I'd like to create an account now.");
define("FS_INQUIRY_INFO_37","Quote History");
define("FS_INQUIRY_INFO_38","Check the status of your quotes and purchase directly with the preferential prices. ");
define("FS_INQUIRY_INFO_39","Contact Customer Service");
define("FS_INQUIRY_INFO_40","Quote Request Date");
define("FS_INQUIRY_INFO_41","Quotation #");
define("FS_INQUIRY_INFO_42","Total");
define("FS_INQUIRY_INFO_43","Quote Name");
define("FS_INQUIRY_INFO_43_1","See More");
define("FS_INQUIRY_INFO_43_2","Cancel Quote");

define("FS_INQUIRY_INFO_44","Added to Quote");
define("FS_INQUIRY_INFO_45","Quantity");
define("FS_INQUIRY_INFO_46","Go to List");
define("FS_INQUIRY_INFO_47","Request Quote");
define("FS_INQUIRY_INFO_48","Quote Request List");
define("FS_INQUIRY_INFO_23","Your request for quote request.");
define("FS_INQUIRY_INFO_23_1"," was submitted.");
define("FS_INQUIRY_INFO_49","Quotation Name:");
define("FS_INQUIRY_INFO_50","This quotation will expire after XX days. Please checkout as soon as possible.");
define("FS_INQUIRY_INFO_51","Your quote has expired.");
define("FS_INQUIRY_INFO_52","Note");
define("FS_INQUIRY_INFO_54","Enter online item#");
define("FS_INQUIRY_INFO_55","The online product ID can't be empty");
define("FS_INQUIRY_INFO_56","Full Name*");
define("FS_INQUIRY_INFO_57","Email address*");
define("FS_INQUIRY_INFO_58","Phone Number*");
define("FS_INQUIRY_INFO_59","The product ID ");
define("FS_INQUIRY_INFO_60"," was not found in our records.");
define("FS_INQUIRY_INFO_61","Name Your Quote");
define("FS_INQUIRY_INFO_62","Quotation No.");
define("FS_INQUIRY_INFO_63","Please select an option for each attribute in black.");

define("FS_INQUIRY_BUY_TIP",'This quotation is only valid for 15 days, and the purchase quantity must be equal or greater than the inquiry, please checkout as soon as possible.');
define("FS_INQUIRY_INFO_53","QUOTE REQUEST LIST");
define("FS_INQUIRY_INFO_64","All Quotes");
define("FS_INQUIRY_INFO_65","This quotation is only valid for 15 days, please checkout as soon as possible.");
define("FS_INQUIRY_INFO_66","The quote has expired.");

define('FS_INQUIRY_EMPTY_TXT','The quote request is empty.');
define('FS_INQUIRY_EMPTY_TXT_01','Submit a quote request at product details or enter an online item# directly.');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">If you already have a FS account, <a href="'.zen_href_link('login','','SSL').'">Sign in</a> to see your Request Quote.</p>');

//ternence.qin
define('FS_CREDIT','My Credit Account');


//2019.7.29 helun add 新版账户中心首页语言包
define('FS_ACCOUNT_NEW_01','Need Help?');
define('FS_ACCOUNT_NEW_02','Mon. - Fri.');
define('FS_ACCOUNT_NEW_03','Orders');
define('FS_ACCOUNT_NEW_04','My Orders');
define('FS_ACCOUNT_NEW_05','Returned');
define('FS_ACCOUNT_NEW_06','Available Credit Line:');
define('FS_ACCOUNT_NEW_07','Most Recent Orders');
define('FS_ACCOUNT_NEW_08','View My Orders');
define('FS_ACCOUNT_NEW_09','You haven’t made a purchase in a while.');
define('FS_ACCOUNT_NEW_10','Recently Viewed Products');
define('FS_ACCOUNT_NEW_11','Most Recent Quotes');
define('FS_ACCOUNT_NEW_12','View My Quotes');
define('FS_ACCOUNT_NEW_13','You haven’t created a quote in a while.');

//2019.5.3 pico 企业账号注册

define("FS_BUSINESS_ACCOUNT_01","Advantages of Business Account");
define("FS_BUSINESS_ACCOUNT_02","Create a FS business account today and get a 2% discount on products and services, plus other great benefits.");
define("FS_BUSINESS_ACCOUNT_03","Preferential Price");
define("FS_BUSINESS_ACCOUNT_04","Quick Delivery");
define("FS_BUSINESS_ACCOUNT_05","Easy Online Quotes");
define("FS_BUSINESS_ACCOUNT_06","Professional Customization");
define("FS_BUSINESS_ACCOUNT_07",'Already have an account? <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">Upgrade account</a>');
define("FS_BUSINESS_ACCOUNT_08",'Need Help? We are here 24/7');
define("FS_BUSINESS_ACCOUNT_09",'Live Chat');
if ($_SESSION['countries_iso_code'] == 'mx'){
    define("FS_BUSINESS_ACCOUNT_10",'+52 (55) 3098 7566');
    define("FS_BUSINESS_ACCOUNT_11",'mx@fs.com');
}elseif ($_SESSION['countries_iso_code'] == 'sg'){
    define("FS_BUSINESS_ACCOUNT_10",'+(65) 6443 7951');
    define("FS_BUSINESS_ACCOUNT_11",'sg@fs.com');
}else{
    define("FS_BUSINESS_ACCOUNT_10",'+1 (888) 468 7419');
    define("FS_BUSINESS_ACCOUNT_11",'us@fs.com');
}
define("FS_BUSINESS_ACCOUNT_12",'Business account is applying.');
define("FS_BUSINESS_ACCOUNT_13",'Welcome to join FS , your application has beeen received , the account manager will review your account as a business account as soon possible.');
define("FS_BUSINESS_ACCOUNT_14",'Your application has been received, please wait for verification and validation.');
define("FS_BUSINESS_ACCOUNT_15",'Click here to enter your account center');
define("FS_BUSINESS_ACCOUNT_16",'Your business account application is under review.');
define("FS_BUSINESS_ACCOUNT_17",'Don\'t have an account? <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '">  Register Business Account</a>');
define("FS_BUSINESS_ACCOUNT_18",'Create a business account');
define("FS_BUSINESS_ACCOUNT_19",'Upgrade account');
define("FS_BUSINESS_ACCOUNT_20",'Your Business Account is Applying.');

//add by rebirth  结算页超重超大标签
define('FS_HEAVY','Heavy');
define('FS_OVERSIZED','Oversized');
//2019 5 3 定义武汉仓发货的文案优化
define('FS_HEADER_FREE_SHIPPING_CN_TIP','Fast Shipping to');
define('FS_HEADER_FREE_SHIPPING_CNRU_TIP','Fast Shipping');
define('FS_FOOTER_FREE_SHIPPING_CN_TIP','Same Day Shipping');
define('FS_BANNER_FREE_SHIPPING_CN_TIP','Same Day Shipping');
define('FS_BANNER_FREE_SHIPPING_CNSG_TIP','Free Shipping on Orders with Eligible Items over S$ 99');
define('FS_FOOTER_FREE_SHIPPING_CN','Free Shipping');
define('FS_M_BANNER_FREE_SHIPPING_CNSG_TIP','Free Shipping on Orders over S$ 99');
//add by jeremy 各语种公司名称
define('FS_LOCAL_COMPANY_NAME','FS.COM Inc.');
define('FS_US_COMPANY_NAME','FS.COM Inc.');
define('FS_DE_COMPANY_NAME','FS.COM GmbH');
define('FS_UK_COMPANY_NAME','FIBERSTORE Ltd.');
define('FS_AU_COMPANY_NAME','FS.COM Pty Ltd');
define('FS_SG_COMPANY_NAME','FS Tech Pte Ltd.');
define('FS_RU_COMPANY_NAME','FS.COM Ltd.');
define('FS_CN_COMPANY_NAME','FS.COM LIMITED');
//amp语言包
//十个专题模块
define('FS_AMP_CATE_01','25G/100G');
define('FS_AMP_CATE_02','40G');
define('FS_AMP_CATE_03','10G');
define('FS_AMP_CATE_04','DAC/AOC');
define('FS_AMP_CATE_05','Switches');
define('FS_AMP_CATE_06','WDM<br>MUX');
define('FS_AMP_CATE_07','Fiber<br>Cables');
define('FS_AMP_CATE_08','MTP/MPO<br>Cables');
define('FS_AMP_CATE_09','Modular<br>Cabling');
define('FS_AMP_CATE_10','Copper<br>Network');
//Interconnection产品模块
define('FS_AMP_INTERCONNECT_01','Interconnection');
//Optical Transport Network产品模块
define('FS_AMP_OPTICAL_TRANS_01','Optical Transport Network');
//Network Cable Assemblies产品模块
define('FS_AMP_NETWORK_CABLE_01','Network Cable Assemblies');
//Space Management产品模块
define('FS_AMP_SPACE_MANAGE_01','Space Management');
//Solution模块
define('FS_AMP_SOLUTION_01','Solutions');
//公共底部模块
define('FS_AMP_FOOTER_01','Email Us');
define('FS_AMP_FOOTER_02','Live Chat');
define('FS_AMP_FOOTER_03','Live ChaSupport');
define('FS_AMP_FOOTER_04','Company');
define('FS_AMP_FOOTER_05','Quick Access');
define('FS_AMP_FOOTER_06','Copyright © 2009-2019 FS.COM Inc All Rights Reserved.');
define('FS_AMP_FOOTER_07','Privacy policy');
define('FS_AMP_FOOTER_08','Terms of use');
//第一级侧边栏
define('FS_AMP_FIRST_SIDEBAR_01','Account / Sign in');
define('FS_AMP_FIRST_SIDEBAR_02','All Categories');
define('FS_AMP_FIRST_SIDEBAR_03','Networking');
define('FS_AMP_FIRST_SIDEBAR_04','Fiber Optic Transceivers');
define('FS_AMP_FIRST_SIDEBAR_05','Fiber Optic Cables');
define('FS_AMP_FIRST_SIDEBAR_06','Racks & Enclosures');
define('FS_AMP_FIRST_SIDEBAR_07','WDM & Optical Access');
define('FS_AMP_FIRST_SIDEBAR_08','Cat5e/Cat6/Cat7/Cat8');
define('FS_AMP_FIRST_SIDEBAR_09','Testers & Tools');
define('FS_AMP_FIRST_SIDEBAR_10','Support');
define('FS_AMP_FIRST_SIDEBAR_11','Company');
define('FS_AMP_FIRST_SIDEBAR_12','Quick Access');
define('FS_AMP_FIRST_SIDEBAR_13','Help & Setting');
//所有二级分类侧边栏
define('FS_AMP_SECOND_SIDEBAR_01','Main Menu');
define('FS_AMP_SECOND_SIDEBAR_02','Networking');
define('FS_AMP_SECOND_SIDEBAR_03','Network Switches');
define('FS_AMP_SECOND_SIDEBAR_04','Data Center Switches');
define('FS_AMP_SECOND_SIDEBAR_05','PDU, UPS, Power System');
define('FS_AMP_SECOND_SIDEBAR_06','Network Adapters');
define('FS_AMP_SECOND_SIDEBAR_07','Routers, Servers');
define('FS_AMP_SECOND_SIDEBAR_08','Media Converters, KVM, TAP');
define('FS_AMP_SECOND_SIDEBAR_09','Fiber Optic Transceivers');
define('FS_AMP_SECOND_SIDEBAR_10','40G/100G Transceivers');
define('FS_AMP_SECOND_SIDEBAR_11','SFP+ Transceivers');
define('FS_AMP_SECOND_SIDEBAR_12','SFP Transceivers');
define('FS_AMP_SECOND_SIDEBAR_13','Direct Attach Cables');
define('FS_AMP_SECOND_SIDEBAR_14','Active Optical Cables');
define('FS_AMP_SECOND_SIDEBAR_15','XFP Transceivers');
define('FS_AMP_SECOND_SIDEBAR_16','Digital Video Transceivers');
define('FS_AMP_SECOND_SIDEBAR_17','Other Transceivers');
define('FS_AMP_SECOND_SIDEBAR_18','FS Box');
define('FS_AMP_SECOND_SIDEBAR_19','Fiber Optic Cables');
define('FS_AMP_SECOND_SIDEBAR_20','MTP Fiber Cabling');
define('FS_AMP_SECOND_SIDEBAR_21','Fiber Patch Cables');
define('FS_AMP_SECOND_SIDEBAR_22','Ruggedized Fiber Cables');
define('FS_AMP_SECOND_SIDEBAR_23','MPO Fiber Cabling');
define('FS_AMP_SECOND_SIDEBAR_24','Ultra HD Fiber Cables');
define('FS_AMP_SECOND_SIDEBAR_25','Pre-terminated Multifiber Cables');
define('FS_AMP_SECOND_SIDEBAR_26','Fiber Cable Pigtails');
define('FS_AMP_SECOND_SIDEBAR_27','Fiber Adapters & Connectors');
define('FS_AMP_SECOND_SIDEBAR_28','Bulk Fiber Cables');
define('FS_AMP_SECOND_SIDEBAR_29','Racks & Enclosures');
define('FS_AMP_SECOND_SIDEBAR_30','Racks & Cabinets');
define('FS_AMP_SECOND_SIDEBAR_31','Fiber Optic Enclosures');
define('FS_AMP_SECOND_SIDEBAR_32','Fiber Patch Panels');
define('FS_AMP_SECOND_SIDEBAR_33','MTP Fiber Cassettes');
define('FS_AMP_SECOND_SIDEBAR_34','MPO Fiber Cassettes');
define('FS_AMP_SECOND_SIDEBAR_35','Fiber Optic Cassettes');

define('FS_AMP_SECOND_SIDEBAR_57','MTP-LC Breakout Panels');
define('FS_AMP_SECOND_SIDEBAR_58','Cable Management');
define('FS_AMP_SECOND_SIDEBAR_59','Raceway System');

define('FS_AMP_SECOND_SIDEBAR_36','WDM & Optical Access');
define('FS_AMP_SECOND_SIDEBAR_37','Mux Demux & OADM');
define('FS_AMP_SECOND_SIDEBAR_38','Passive Components');
define('FS_AMP_SECOND_SIDEBAR_39','Fiber Termination');
define('FS_AMP_SECOND_SIDEBAR_40','FMT WDM Transport Platform');
define('FS_AMP_SECOND_SIDEBAR_41','FMT Infrastructure Modules');
define('FS_AMP_SECOND_SIDEBAR_42','Cleaner & Testers');
define('FS_AMP_SECOND_SIDEBAR_43','Cat5e/Cat6/Cat7/Cat8');
define('FS_AMP_SECOND_SIDEBAR_44','Patch Cables');
define('FS_AMP_SECOND_SIDEBAR_45','Pre-terminated Trunk Cables');
define('FS_AMP_SECOND_SIDEBAR_46','Bulk Cables');
define('FS_AMP_SECOND_SIDEBAR_47','Patch Panels');
define('FS_AMP_SECOND_SIDEBAR_48','Cable Management');
define('FS_AMP_SECOND_SIDEBAR_49','Copper Tools & Testers');
define('FS_AMP_SECOND_SIDEBAR_50','Testers & Tools');
define('FS_AMP_SECOND_SIDEBAR_51','Fiber Optic Cleaner');
define('FS_AMP_SECOND_SIDEBAR_52','Basic Fiber Tester');
define('FS_AMP_SECOND_SIDEBAR_53','Advanced Fiber Tester');
define('FS_AMP_SECOND_SIDEBAR_54','Fiber Polish & Splice');
define('FS_AMP_SECOND_SIDEBAR_55','Fiber Optic Tools');
define('FS_AMP_SECOND_SIDEBAR_56','Copper Tools & Testers');
//三级分类侧边栏
define('FS_AMP_THIRD_SIDEBAR_01','Go back');
//登陆后侧边栏
define('FS_AMP_LOGIN_SIDEBAR_01','My Account');
define('FS_AMP_LOGIN_SIDEBAR_02','Account Setting');
define('FS_AMP_LOGIN_SIDEBAR_03','Order History');
define('FS_AMP_LOGIN_SIDEBAR_04','Address Book');
define('FS_AMP_LOGIN_SIDEBAR_05','My Cases');
define('FS_AMP_LOGIN_SIDEBAR_06','My Quotes');
define('FS_AMP_LOGIN_SIDEBAR_07','Sign out');
//搜索侧边栏
define('FS_AMP_SEARCH_01','Hot Search');
//语言选择
define('FS_AMP_SELECT_LANG_01','Select Country/Region');
define('FS_AMP_SELECT_LANG_02','Save');
define('FS_FOOTER_FREE_SHIPPING_RU_TIP','Free Shipping to');

//订阅功能语言包(单页面，账户中心)
define('FS_EMAIL_SUBSCRIPTION_01','Email Subscriptions');
define('FS_EMAIL_SUBSCRIPTION_02','Manage your email subscription preferences, get the latest news from FS.');
define('FS_EMAIL_SUBSCRIPTION_03','Email Subscriptions');
define('FS_EMAIL_SUBSCRIPTION_04','Comfirm the email you want to manage subscription:');
define('FS_EMAIL_SUBSCRIPTION_05','Subscribe FS emails to learn more about the latest preferential policies, inventory news, technical support and so on. From new products to data center solutions you may not be aware of, FS emails will keep you informed!');
define('FS_EMAIL_SUBSCRIPTION_06','Emails about your account and orders are important. We send those even if you have opted out of marketing emails.');
define('FS_EMAIL_SUBSCRIPTION_07','Please note: It may take up to 48 hours for any changes to be applied. You will still receive emails about orders, preferential policies, inventory news and technical support regardless of your email subscription.');
define('FS_EMAIL_SUBSCRIPTION_08','How often do you want to receive promotions?');
define('FS_EMAIL_SUBSCRIPTION_09','Regular');
define('FS_EMAIL_SUBSCRIPTION_10','No more than once a week');
define('FS_EMAIL_SUBSCRIPTION_11','No more than once a month');
define('FS_EMAIL_SUBSCRIPTION_12','Unsubscribed');
define('FS_EMAIL_SUBSCRIPTION_13','Save');
define('FS_EMAIL_SUBSCRIPTION_14','Cancel');
define('FS_EMAIL_SUBSCRIPTION_15','Your request has been submitted successfully!');
define('FS_EMAIL_SUBSCRIPTION_16','We will reply you within 24 hours.');
define('FS_EMAIL_SUBSCRIPTION_17','Please enter your own email address.');
define('FS_EMAIL_SUBSCRIPTION_18','View, change, or cancel your subscriptions.');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span>You have successfully unsubscribed.');
define('FS_EMAIL_SUBSCRIPTION_20','You\'ll no longer receive FS promotional emails.');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>You have successfully subscribed.');
define('FS_EMAIL_SUBSCRIPTION_22','Thank you for subscribing to FS emails.');
define('FS_EMAIL_SUBSCRIPTION_23','Email me about FS latest development once per month.');
define('FS_EMAIL_SUBSCRIPTION_24','You\'ll no longer receive FS review request emails.');
define('FS_EMAIL_SUBSCRIPTION_25','You\'ll no longer receive FS promotional emails and review request emails.');

//底部订阅语言包
define('FS_EMAIL_SUBSCRIPTION_FOOTER_01','Subscribe');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02','Get the latest news from FS');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03','Your Email Address');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04','Please enter your email address.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05','Please enter a valid email address.');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06','Thank you for subscription!');
define('FS_FOOTER_FREE_SHIPPING_RU_TIP','Free Shipping to');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','Mobile Apps');


//2019.5.27 新政策弹窗 pico
define('FS_SHIPPING_RETURNS','<a class="info_returns" href="javascript:;">'.FS_DELIVERY_RETURN.'</a>');
define('FS_SHIPPING_WARRANTY','<a class="info_warranty" href="javascript:;">Warranty</a>');
define('FS_SHIPPING_SUPPORT','<a class="" href="'. reset_url('product_support.html?products_id=###') . '" target="_blank">Product Support</a>');
define('FS_SHIPPING_RETURNS_TITLE','30-Day Return');
define('FS_SHIPPING_RETURNS_PART',"FS provides 30-day return & replace service to guarantee you a truly worry-free shopping experience. If the reason for return is a result of a FS error, we will be responsible for all incurring shipping cost and taxes. Visit <a href ='".zen_href_link('index')."policies/day_return_policy.html' target='_blank'>Return Policy</a> to learn details on different products.");
define('FS_SHIPPING_WARRANTY_TITLE','Warranty on Full Ranges of Products');
define('FS_SHIPPING_WARRANTY_PART',"If anything goes wrong with the product but it exceeds the return window period, don't worry. As long as the product is in warranty period, you can enjoy free maintenance service. Look up for particular warranty period of products in <a href ='".zen_href_link('index')."policies/warranty.html' target='_blank'>Warranty Policy</a>.");
define('FS_SHIPPING_SUPPORT_TITLE','Free Technical Support');
define('FS_SHIPPING_SUPPORT_PART',"FS is committed to becoming the trusted partners of our clients, and offering a full portfolio of digital infrastructure products and a comprehensive one-stop digital solution.");
define('FS_SHIPPING_SUPPORT_PART_BR',"You can <a href='".reset_url('solution_support.html')."' target='_blank'>Request Technical Support</a> to get timely help for any questions about the items or a free connectivity solution design.");

//add by ternence 询价产品弹窗
define('FS_PRODUCT_INQUIRY_3','Your quote has been received by FS. We will give you feedback later.');
define('FS_PRODUCT_INQUIRY_1','We will reply you within 24 hours.');
define('FS_PRODUCT_INQUIRY_2','By clicking the button below, you agree to FS.COM\'s <a href="javascript:;" class="">Privacy and Cookies policy</a> and <a href="javascript:;">Terms of Use</a>.');

//add by ternence 结算页面地址提示
define('FS_SALES_INFO_MODAL_ZIP_CODE','Zip Code*');
define('FS_RETURN_BUTTON','Return an Item');


//分类文章
define('CASE_STUDIES_01','Region');
define('CASE_STUDIES_02','North America');
define('CASE_STUDIES_03','Latin America');
define('CASE_STUDIES_04','Europe');
define('CASE_STUDIES_05','Oceania');
define('CASE_STUDIES_06','Africa');
define('CASE_STUDIES_07','Middle East');
define('CASE_STUDIES_08','Asia');
define('CASE_STUDIES_09','Case Type');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','Enterprise Network');
define('CASE_STUDIES_12','Data Center Cabling');
define('CASE_STUDIES_13','Industry');
define('CASE_STUDIES_14','Aerospace & Defense');
define('CASE_STUDIES_15','Consumer Services');
define('CASE_STUDIES_16','Education');
define('CASE_STUDIES_17','Electric Utilities');
define('CASE_STUDIES_18','Media');
define('CASE_STUDIES_19','ISP');
define('CASE_STUDIES_20','IT Services');
define('CASE_STUDIES_21','Other');
define('CASE_CLEAR_ALL','Clear All');
define("FS_PRODUCTS","Results");
define("FS_PRODUCT","Result");
define('CASE_CATEGORY_MENU_CASE_STUDIES','Case Studies');

//登陆超时
define('LOING_TIMEOUT','For security reasons, your session has expired. Please sign in again.');


//产品详情AOC
define('PRODUCT_AOC','Cable length could be customized from 1m to 300m（3ft to 984.252ft）as you required.');
define('PRODUCT_AOC_1','Cable length could be customized from 1m to 30m（3ft to 98.43ft）as you required.');
//报价列表
define('QUOTE_EMPTY_1','You haven\'t made any quote requests yet.');
define('QUOTE_EMPTY_2','Start Shopping');
define('QUOTE_EMPTY_3','No quote requests found.');

define("ATTRIBUTE_MESSAGE",'Fully compatible with Cisco switches, for Compatible Matrix, please <a target="_blank" href="https://tmgmatrix.cisco.com"> click here</a>.');
//首页cart sign in翻译
define('FILENAME_SIGN_IN','Sign in');
define('FILENAME_HOME_CART','Cart');

//购物车登陆且为空的状态 添加save cart入口
define('FS_SAVE_CART_ENTRANCE','Continue shopping on FS or view your <a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">Saved Carts</a>.');

//报价添加打印
define('INQUIRY_GET_A_QUOTE','Need help with your purchase?');
define('INQUIRY_GET_A_QUOTE_1',"We're always committed to offering you the best quality items, favorable price with bulk order, fast processing procedures once order placed. Call us at ");
define('INQUIRY_GET_A_QUOTE_2',' or email ');
define('INQUIRY_GET_A_QUOTE_3','Print Quote');
define('INQUIRY_GET_A_QUOTE_4','QUOTE DETAILS');
define('INQUIRY_GET_A_QUOTE_5','Qty(pcs)');
define('INQUIRY_GET_A_QUOTE_6','Quote Price');


//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', 'Customer Account');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', 'Available, Need Transit');
define('QV_SHOW_AVAILABLE_02', 'Available, In Transit');

//清仓产品加购限制 Dylan 2019.8.27
define('FS_CLEARANCE_TIPS_TITLE','Insufficient Quantity Available');
define('FS_CLEARANCE_TIPS_CONTENT','The quantity you’ve specified exceeds available inventory <span class="clearance_total_qty">$QTY</span> pc(s), please contact your account manager for additional quantity.');
define('QV_CLEARANCE_TIPS','The quantity you’ve specified exceeds available inventory <span class="clearance_total_qty">$QTY</span> pc(s).');
define('QV_CLEARANCE_EMPTY_QTY_TIPS','The product is out of stock, please contact your account manager for availability.');

//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'Explore Solutions');
define('FS_BEST_SELLERS', 'Best Sellers');
define('FS_CASE_STUDIES', 'Case Studies');

define('FS_TEST_TOOL','Test Tool');


// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','Fit in <a href="c/fhd-rack-mount-45" style="color: #0070BC;">FHD rack mount</a> and <a href="c/fhd-wall-mount-3358" style="color: #0070BC;">FHD wall mount</a> fiber enclosures');
define('FS_PRODUCT_INSTALLATION_TEXT_2','Fit in <a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> fiber enclosure that can be mounted on a 19\'\' rack');
define('FS_PRODUCT_INSTALLATION_TEXT_3','Fit in <a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> fiber enclosure that can be mounted on a 19\'\' rack');
define('FS_PRODUCT_INSTALLATION_TEXT_4','Fit in <a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a> fiber enclosure that can be mounted on a 19\'\' rack');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','Fit in <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Series</a> and <a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;">HR800-Series</a> network & server cabinets');
define('FS_PRODUCT_INSTALLATION_TEXT_6','Fit in <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600-Series</a> and <a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;">HR600-Series</a> server cabinets');
define('FS_PRODUCT_INSTALLATION_TEXT_7','Fit in <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Series</a> and <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600-Series</a> cabinets');
define('FS_PRODUCT_INSTALLATION_TEXT_8','Fit in <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Series</a> network & server cabinet');
//liang.zhu 2020.1.7
define('FS_PRODUCT_INSTALLATION_TEXT_9','FMX 100G module fits in <a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color: #0070BC;">FMX-100G-CH2U</a> chassis that can be mounted on a rack');



// add by pico
define('CHECKOUT_ERROR_01', 'Please select the payment type.');
define('CHECKOUT_ERROR_02', 'The Cardholder Name is required.');
define('CHECKOUT_ERROR_03', 'The Card Number is required.');
define('CHECKOUT_ERROR_04', 'The Security Code is required.');


//add ternence
define('INQUIRY_TITLE','Email Your Quote Request List');
define('INQUIRY_TITLE_1','Your Share Quote List');
define('INQUIRY_TITLE_2','Email Sent Successfully');
define('INQUIRY_TITLE_3','Success! Your quote request has been sent to your list of recipient.');
define('INQUIRY_TITLE_4','Return quotation list');
define('INQUIRY_TITLE_5','Email Sent Successfully');
define('INQUIRY_TITLE_6','Someone created a quote list just for you so that you can get connected! If you still need help, you can always');
define('INQUIRY_TITLE_7','Add to request quote');
define('INQUIRY_TITLE_8',' below to add what you see on this page to your quote.');
define('INQUIRY_TITLE_9','Share Quote List');
define('INQUIRY_TITLE_10','Quote List');
define('INQUIRY_TITLE_11',' shared a quote request list with you. You can click button below to view complete details and add to your own quote list.');
define('INQUIRY_TITLE_12',' shared you a quote list');
define('INQUIRY_TITLE_13','Add to request quote');
define("FS_INQUIRY_INFO_67",'Your quote request is empty. If you already have an account, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">Sign in</a> to see your Quote.');
define("FS_INQUIRY_INFO_68",'Email');
define("FS_INQUIRY_INFO_69",'Qty.');
//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','Tax Number');
define('CHECKOUT_TAX_2','You can exempt from VAT tax if you have a valid Tax Identification Number.');

// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"Need help?");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"Contact Customer Support.");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','Below item is free gift and will not be calculated in total price when checkout.');
define('FS_GIFT_TITLE_ARE','Below items are free gift and will not be calculated in total price when checkout.');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">Free Gift</div></div>');
define('FS_GIFT_CHECK_TITLE','Free gift is not available for the current shipping address, please choose test tool in product page if needed.');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">Free Gift</div></div>');


// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY',' I agree to FS\'s <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">Privacy Policy</a> and <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">Terms of Use</a>.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Please make sure you agree to our Privacy Policy and Terms of Use.');

//新品标记
define('NEW_PRODUCTS_TAG','New');

//热卖标记
define('HOT_PRODUCTS_TAG','Hot');


define("INVALID_CVV_ERROR",'Security code is incorrect. Please enter the correct code and try again.');


//2019.8.20 jeremy 产品改码相关
define('FS_ACCOUNT_CODING_REQUESTS','Coding Requests');
define('FS_ACCOUNT_MY_CODING_REQUESTS','My Coding Requests');
define('FS_ACCOUNT_CODING_REQUEST_BTN','Request Coding');
define('CODING_REQUESTS_LIST','Coding Request Lists');
define('CODING_REQUESTS_CODING_DETAILS','Coding Request Details');

// 2019-7-19 potato 地址编辑提示修改
define('ACCOUNT_EDIT_CITY_AU','Suburb');
define('ACCOUNT_EDIT_STATE_AU','State');
define('FS_CITY_TITLE_ERROR','Your suburb is required.');
define('FS_POST_CODE_TITLE_ERROR','Your postcode is required.');
define("FS_ZIP_CODE_AU_NEW","Postcode");


//add by liang.zhu 2019.09.02
define('FS_COMMON_LEARN_MORE', 'Learn more');
define('FS_COMMON_SEE_MORE', 'See more');
define('FS_COMMON_SEE_LESS', 'See less');

//模块标签属性
define('FS_PLACEHOLDER_EG','eg: ');
define('FS_OPTIONAL',' (Optional)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','VAT');
define('FS_CHECK_OUT_INCLUDEING_RU','(Including VAT)');
define('FS_CHECK_OUT_EXCLUDING_RU','(Excluding VAT)');

define("FS_CART_ITEM_TOTAL","Item Total");
define("FS_CART_ATTR_BTN","Select attribute(s)");
define("FS_CART_ATTR_CONTENT","This is a customized product. Please select attribute(s) first.");

// 表单次数提交频繁
define('FS_SUBMIT_TOO_OFTEN','Your are trying too often. Please try again later.');
define('FS_ROBOT_VERIFY_PROMOPT','Please follow the prompts to complete the verify.');
//mtp退货货提示语
define('FS_RETURN_ALL_MTP_PRODUCTS','Please return all these accessories together.');
//2019-09-17 liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', 'North America');
//澳洲
define('FS_STATE_OCEANIA', 'Oceania');
//亚洲
define('FS_STATE_ASIA', ' Southeast Asia');
//欧洲
define('FS_STATE_EUROPE', 'Europe');
define('FS_PORTFOLIOS','portfolios');
define('FS_ORDER_LINK_REMARK','Remark');
define('FS_VIEW_INVOICE_BUBBLE','Please contact your account manager to get the updated invoice for this order.');

//新加坡税号标题 add by quest
define('FS_SG_VAT_NUMBER',"GST Registration No.");

//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','Email your quote');
define("FS_INQUIRY_REVIEWING_1",'Submitted');
define("FS_INQUIRY_QUOTED_1",'Approved');
define('FS_QUOTE_INFO_1','Quote Details');
define("FS_INQUIRY_CANCELED_1",'Expired');
define('FS_QUOTE_INFO_2','Unit Price');
define('FS_QUOTE_INFO_3','Target price');
define('FS_QUOTE_INFO_4','Quoted Price');
define('FS_QUOTE_INFO_5','(Price not including tax and shipping cost)');
define('FS_QUOTE_INFO_6','All');
define('FS_QUOTE_INFO_8','Please select item first.');
define('FS_QUOTE_INFO_9','Thank you. We\'ve emailed your quote to your list of recipient.');
define('FS_QUOTE_INFO_10','Return to Quote Details');
define('FS_QUOTE_INFO_11','Quote Again');
define('FS_QUOTE_INFO_12','Quick Quote');
define('FS_QUOTE_INFO_13','Summary (');
define('FS_QUOTE_INFO_14',' Items');
define('FS_QUOTE_INFO_15','Target:');
define('FS_QUOTE_INFO_16','Price not including tax and shipping costs');
define('FS_QUOTE_INFO_17','This quote was given the discount based on the whole product lists. If you check out with partial products, discount will become invalid.');
define('FS_QUOTE_INFO_18','This quote was given the various discounts based on the quantity of each products. If you reduce the quantity of the products that you will check out, the discount of selected products will become invalid.');
define('FS_QUOTE_INFO_19','Created');
define('FS_SEND_EMAIL_2019_1',"We have got your quote request ");
define('FS_SEND_EMAIL_2019_2',", your account manager will quote you in 30 minutes. Please find it in ");
define('FS_SEND_EMAIL_2019_3',"My Quotes");
define('FS_SEND_EMAIL_2019_4'," later.");
define('FS_SEND_EMAIL_2019_5',"Your customer ");
define('FS_SEND_EMAIL_2019_6',"Quote Request");
define('FS_SEND_EMAIL_2019_7',"Your Item");
define('FS_SEND_EMAIL_2019_8',"Qty: ");
define('FS_SEND_EMAIL_2019_9',"Your Item");
define('FS_SEND_EMAIL_2019_10',"Qty");
define('FS_SEND_EMAIL_2019_11',"Target Price");
define('FS_SEND_EMAIL_2019_12',"Unit Price");
define('FS_SEND_EMAIL_2019_13',"Subtotal:");
define('FS_SEND_EMAIL_2019_14',"Target:");
define('FS_SEND_EMAIL_2019_15',"Go to Quote");
define("FS_INQUIRY_INFO_65_1","This quotation is only valid for 15 days and expires ");
define("FS_INQUIRY_INFO_65_2",", will expire on ");
define("FS_INQUIRY_INFO_65_3","Grand Total:");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01','Please complete payment within ');
define('FS_ORDERS_OVERTIMES_02','');
define('FS_ORDERS_OVERTIMES_03','');
define('FS_ORDERS_OVERTIMES_02_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04','Otherwise, the order will be cancelled automatically due to the inventory change of items.');
define('FS_ORDERS_OVERTIMES_05','Please upload PO file within ');
define('FS_ORDERS_OVERTIMES_06_01','Note: Remarking FS order NO.');
define('FS_ORDERS_OVERTIMES_06_02',' when you transfer will get your order processed timely. Usually funds will be received in 1-3 business days.');
define('FS_ORDERS_OVERTIMES_07','Your order needs to be reviewed due to the following reason:');
define('FS_ORDERS_OVERTIMES_08','The shipping address does not match addresses on your credit application form');
define('FS_ORDERS_OVERTIMES_09','Your available credit has also been overrun');
define('FS_ORDERS_OVERTIMES_10','Please pay off the previous orders to recover the credit or go to "My Credit" to apply for increasing the credit limit. We will review the order and email you the result.');
define('FS_ORDERS_OVERTIMES_11','We will review the order and email you the result within 12 hours.');
define('FS_ORDERS_OVERTIMES_12','To get this order processed quickly, please pay off the previous orders to recover the credit, or you can go to "My Credit" to apply for increasing the credit limit.');
define('FS_ORDERS_OVERTIMES_13','Ends in');
define('FS_ORDERS_OVERTIMES_14','d'); //天  这三个是英文的 day  hour minute 首字母缩写
define('FS_ORDERS_OVERTIMES_15','h'); //时
define('FS_ORDERS_OVERTIMES_16','m'); //分
define('FS_ORDERS_OVERTIMES_17','Sorry, your order has been closed because of passing the deadline for payment.');
define('FS_ORDERS_OVERTIMES_18','You can find it in Order History and click “Buy Again” to place another order.');
define('FS_ORDERS_OVERTIMES_19','Something went wrong with your order......');
define('FS_ORDERS_OVERTIMES_20','We\'ve received your remittance from');
define('FS_ORDERS_OVERTIMES_21','However, the order has been closed because of passing the deadline (shown on FS pending orders) for payment. Please contact your account manager to restore the order. We\'re sorry for the inconvenience!');
define('FS_ORDERS_OVERTIMES_22','There are overdue bills under your Net Term account. Please pay off the previous orders. Or your dedicated account manager will contact you and ask for additional documents for review.');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36','FS Order Reminder - Pending Payment ');
define('FS_ORDERS_OVERTIMES_23','Order Reminder');
define('FS_ORDERS_OVERTIMES_24','Thanks for choosing FS. We noticed that you left an unpaid order <b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25','<b style="font-weight: 600;">Note</b>: If you have paid the order, please ignore this email. We will process your order soon. If you don\'t want this order, please ignore this email. The order will be canceled by the system automatically later if it is left unpaid.');
define('FS_ORDERS_OVERTIMES_26','Have a great day!');
define('FS_ORDERS_OVERTIMES_27','</b>.  Kindly remind it will be canceled automatically after ');
define('FS_ORDERS_OVERTIMES_28','. Just <a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29','">Click Here</a> to complete your purchase and your order can be in the process asap.');



//quest 新加坡安装
define('FS_SHOP_CART_SG_INSTALL','Free installation available for items in SG warehouse. Checkout to see more.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','You\'ve selected installation service. When the order is ready to ship, our technical specialist will contact your before heading to your place.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','You\'ve selected installation service. Please make sure to complete the payment before scheduled installation time, or the service may be delayed.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','You\'ve selected installation service. Please make sure to upload PO file before scheduled installation time, or the service may be delayed.');
//by rebirth 2019.10.18 新版上传提示 英语
define("FS_UPLOAD_NEW_NOTICE_ONE","Please use a PDF, JPG, PNG, DOC, DOCX, XLS, XLSX or TXT file.");
define("FS_UPLOAD_NEW_NOTICE_TWO","Please use a  JPG, GIF, PNG, JPEG, or BMP file.");
define("FS_UPLOAD_NEW_NOTICE_THREE","Maximum size 5M.");
define("FS_UPLOAD_NEW_NOTICE_FOUR","Maximum size 300KB.");
define("FS_UPLOAD_NEW_ERROR_1","The uploaded file is Unallowable!"); //该文件不允许上传
define("FS_UPLOAD_NEW_ERROR_2","File exist already!");  //文件已存在
define("FS_UPLOAD_NEW_ERROR_3","Failed to upload files to cloud server."); //文件上传云服务器失败
define('FS_UPLOAD_NEW_ERROR_4', 'The uploaded file exceeds the upload_max_filesize directive in php.ini.');//文件大小超过php.ini的限制

//Quest 2019.10.24 新加坡上门安装提示语
define('FS_CHECKOUT_SGINSTALL_CC','You\'ve selected installation service. Please make sure to complete the payment before scheduled installation time, or the service may be delayed.');
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','Free installation service is supported to all products in stock. You can choose the service at checkout page.');
define('FS_SG_DELIVERY_RETURN','Free Installation');
define('FS_SHIPPING_SG_INSTALL_TIPS','For this delivery, you may select preferred installation time. Installation services are only available with FS Delivery & Free Installation.');

//aron 2019.10.24 新加坡安装时间
define('FS_SG_CALENDAR_1',"Select Installation Timeslot");
define('FS_SG_CALENDAR_2',"Get Available Installation Time");
define('FS_SG_CALENDAR_3',"Please select FS Delivery & Installation");
define('FS_SG_CALENDAR_4',"Please select preferred installation time.");
define("FS_SG_CALENDAR_5","On-site Installation");
define("FS_SG_CALENDAR_6",'Delivery Change');
define("FS_SG_CALENDAR_7","You've canceled all installation requests. We'll arrange parcel delivery for you.");
define("FS_SG_CALENDAR_8","Cancel");
define("FS_SG_CALENDAR_9","Yes, please");
define("FS_SG_CALENDAR_10",'Only checked items will be installed after delivery.');
define("FS_SG_CALENDAR_11",'* Installation service is available for item(s) shipped from SG warehouse currently. We\'re sorry for the incovenience.');
//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","Request Installation");
define("FS_SG_CALENDAR_101","Choose service type");
define("FS_SG_CALENDAR_102","Please select");
define("FS_SG_CALENDAR_103","Project Support");
define("FS_SG_CALENDAR_104","Troubleshooting and Repair");
define("FS_SG_CALENDAR_105","Please select service type.");
define("FS_SG_CALENDAR_106","Describe the details about your request*");
define("FS_SG_CALENDAR_107","Please describe your request.");
define("FS_SG_CALENDAR_108","The content should be 4 characters at least.");
define("FS_SG_CALENDAR_109","The content should be 500 characters at most.");
define("FS_SG_CALENDAR_110","Installation Request");
define("FS_SG_CALENDAR_111","Service Type");
define("FS_SG_CALENDAR_112","Scheduled Time");
define("FS_SG_CALENDAR_113","Request Details");
define("FS_SG_CALENDAR_114","Scheduled Installation");
define("FS_SG_CALENDAR_115","Your installation request has been received.");
define("FS_SG_CALENDAR_116","Our technical specialist will contact you before heading to your place.");


// add by quest 20190.10.26 新加坡表单验证提示语
define('FS_SGVISIT_FROM_ERROR1','Please enter your name.');
define('FS_SGVISIT_FROM_ERROR2','Please enter your email address.');
define('FS_SGVISIT_FROM_ERROR3','Please enter your company name.');
define('FS_SGVISIT_FROM_ERROR4','The Phone must be digits.');
define('FS_SGVISIT_FROM_ERROR5','The Numbers of Visitors is required.');
define('FS_SGVISIT_FROM_ERROR6','The Numbers of Visitors must be digits.');
define('FS_SGVISIT_FROM_ERROR7','Please schedule a visiting time.');
define('FS_SGVISIT_FROM_ERROR8','Please enter a valid email address.');
//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","Thanks for choosing FS Singapore, we've received your pending order ");
define("FS_SG_EMAIL_1","Complete the payment and you will hear from us again once the order is scheduled for free installation.");
define("FS_SG_EMAIL_2","Some product(s) is available for free installation, you may <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">request installation</a> service if need. Complete the payment and you will hear from us again.");
define("FS_SG_EMAIL_3","You've selected the installation service for your order ");
define("FS_SG_EMAIL_4"," We will contact you when our technical specialist is heading to your delivery address.");
define("FS_SG_EMAIL_5","Please track the progress of your order by logging into your account and going to the ");
define("FS_SG_EMAIL_6","Details for your order ");
define("FS_SG_EMAIL_7"," are below. We'll send you an email as soon as an update comes from your order.");
define("FS_SG_EMAIL_8","You can track the progress of your order by logging into your account and going to the ");
define("FS_SG_EMAIL_9"," Please kindly note that free installation is available for the order, you may grab some time <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">here</a>.");
define("FS_SG_EMAIL_10","Your order ");
define("FS_SG_EMAIL_11"," is ready for installation and our technical specialist will be heading to your address timely.");
define("FS_SG_EMAIL_12","Any changes, please contact us at <a style=\"color: #0070bc;text-decoration: none\" href=\"tel:+(65) 6443 7951\">+(65) 6443 7951</a> or email <a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>.");
define("FS_SG_EMAIL_13","Thanks");
define("FS_SG_EMAIL_14","The FS Team");
define("FS_SG_EMAIL_15","Contact Info:");
define("FS_SG_EMAIL_16","Phone No:");
define("FS_SG_EMAIL_17","Address:");
define("FS_SG_EMAIL_18","Scheduled time:");
define("FS_SG_EMAIL_19","FS Order #");
define("FS_SG_EMAIL_20"," - Installation Reminder");
define("FS_SG_EMAIL_21","Thanks for choosing FS Singapore. We noticed that you left an unpaid order");
define("FS_SG_EMAIL_22"," with on-site installation service. Kindly remind the service has been canceled.");
define("FS_SG_EMAIL_23","Just <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">Click Here</a> to complete your purchase and you can select a new convenient time for installation service in My Account.");
define("FS_SG_EMAIL_24","Your FS Order #");
define("FS_SG_EMAIL_25"," has shipped");
define("FS_SG_EMAIL_26","Installation Reminder");
define("FS_SG_EMAIL_27","Installation Canceled");
define("FS_SG_EMAIL_28","Payment Reminder");

define('FS_FESTIVAL16','Public Holiday in Singapore starts on');
define('FS_FESTIVAL17',' in SG Warehouse.');
define('FS_FESTIVAL18','Public Holiday in Russian starts on');
define('FS_FESTIVAL19',' in  Russian Warehouse.');

//新加坡拜访邮件
define('FS_SG_VISIT_EAMIL_TITLE','Request Received');
define('FS_SG_VISIT_EAMIL_END_TITLE','Visit us Email');

define('FS_SG_DELIVERY_INSTALLATION', 'FS Delivery & Free Installation');
define('FS_SG_NEXT_WORKING_DAY', 'FS Next Working Day Delivery');
define('FS_SG_SAME_WORKING_DAY', 'FS Same Working Day Delivery');
define('FS_ACCOUNT_DETELE','The current account has been deleted');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 Working Days');

//rebirth 2019.10.17 订单超时,分钟,工作日的单复数处理
define('FS_ORDERS_OVERTIMES_30','minute');
define('FS_ORDERS_OVERTIMES_31','minutes');
define('FS_ORDERS_OVERTIMES_32','business day');
define('FS_ORDERS_OVERTIMES_33','business days');
define('FS_ORDERS_OVERTIMES_34','');
define('FS_ORDERS_OVERTIMES_35','');

//Aron 面包屑
define("BREAD_HOME",'Home');

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'Service Type');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', 'Product Usage Support');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'Link Connectivity Support');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'Installation & Configuration Support');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'Others');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","Share Experience");
define("EMAIL_MESSAGE_01","How did we do?");
define("EMAIL_MESSAGE_02","Leave your review");
define('EMAIL_MESSAGE_CONTENT', 'We would like it if you help us and other customers by reviewing products that you recently purchased in order <a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a>. It only takes one minute and it would really help others. Click the button below and leave your review!');
define('EMAIL_MESSAGE_SUBTITLE', 'Have questions to your order?');
define('EMAIL_MESSAGE_SUB_CONTENT', 'Whether technical support, warranty questions, or delivery questions, we\'re glad to help. Please go to the <a style="color: #0070bc;text-decoration: none;" href="javascript:;">FS Support</a> for quick and helpful assistance.');
define('EMAIL_TO_LICENSE_5','View More');
define('EMAIL_TO_LICENSE_6','You have a new item to review on FS.COM');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'Thanks for your support');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'We would appreciate your feedback about your experience on the Trustpilot. Please take a moment to rate FS.');
define('EMAIL_REVIEWS_FOUR_FIVE_03', 'Your rating');
define('EMAIL_REVIEWS_FOUR_FIVE_04', 'Your review (whether good, bad or otherwise) will be posted on Trustpilot.comimmediately to help other people make more informed decisions.');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'Thanks for your time, and we look forward to seeing you again! <br>The FS Team.');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'Rate Us');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'Your experience matters - Thanks for sharing');


//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Technical Support');
define('FS_REQUEST_SUPPORT','Request Support');

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','Your Status');
define('FS_NEW_ACCOUNT_MY_CREDIT_02',' Terms');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','Current Balance');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','Total Credit Limit');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','Increase');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','Search Order');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','PO #, Order #');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','Date');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','NO PURCHASE ORDER HISTORY.');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','Start Shopping');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','NO PURCHASE ORDER FOUND.');
define('FS_NEW_ACCOUNT_MY_CREDIT_12', 'Search');

// manage address
define("FS_CREATE_NEW_ADDRESS", 'Create a New Address');
define("FS_DEFAULT", 'Default');
define("FS_SAVE_ADDRESSES", 'Saved Addresses');
define("FS_EDIT_REMOVE", 'Edit / Remove');
define("FS_EDIT", 'Edit');
define("FS_REMOVE", 'Remove');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", 'NO SHIPPING ADDRESS HISTORY.');
define("FS_NO_BILLING_ADDRESS_HISTORY", 'NO BILLING ADDRESS HISTORY.');
//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'Quote Status');
define("FS_INQUIRY_LIST_2",'Active Quote');
define("FS_INQUIRY_LIST_3",'Contact Customer Service');
define("FS_INQUIRY_LIST_4",'Search Quote:');
define("FS_INQUIRY_LIST_5",'Quotation #');
define("FS_INQUIRY_LIST_6",'Search');
define("FS_INQUIRY_LIST_7",'Quote Request Date:');
define("FS_INQUIRY_LIST_8",'Subtotal');
define("FS_INQUIRY_LIST_9",'Qty:');
define("FS_INQUIRY_LIST_10",'See more...');
define("FS_INQUIRY_LIST_11",'The quote is valid until ');
define("FS_INQUIRY_LIST_12",'The quote has expired on ');
define("FS_INQUIRY_LIST_13",'NO QUOTE FOUND.');
define("FS_INQUIRY_LIST_14",'Start Shopping');
define("FS_INQUIRY_LIST_15",'If you can\'t locate your quote, try selecting different filter conditions.');
define("FS_INQUIRY_LIST_16",'Quote Request Details');
define("FS_INQUIRY_LIST_17",'Quote Name:');
define("FS_INQUIRY_LIST_18",'Quote Again');
define("FS_INQUIRY_LIST_19",'Add to Cart');
define("FS_INQUIRY_LIST_20",'Print this page');
define("FS_INQUIRY_LIST_21",'QUOTE REQUEST');
define("FS_INQUIRY_LIST_22",'Product');
define("FS_INQUIRY_LIST_23",'Item Price');
define("FS_INQUIRY_LIST_24",'Quantity');
define("FS_INQUIRY_LIST_25",'Quoted Price');
define("FS_INQUIRY_LIST_26",'Customer ID:');
define("FS_INQUIRY_LIST_28",'Phone #:');
define("FS_INQUIRY_LIST_29",'Quoted Subtotal:');
define("FS_INQUIRY_LIST_30",'Below is the quote you have submitted, your account manager will reply you within 24 hours.');
define("FS_INQUIRY_LIST_30_1",'The quote is under reviewing by your account manager, you will get the reply within 24 hours.');
define("FS_INQUIRY_LIST_31",'The quote is under reviewing by your account manager, you will get the reply within 24 hours.');
define("FS_INQUIRY_LIST_32",'Below is your quote detail. This quote is valid until ');
define("FS_INQUIRY_LIST_33",'This quote has expired on ');
define("FS_INQUIRY_LIST_34",'.You can quote it again if need.');

define("FS_INQUIRY_LIST_35",'Quotation #');
define("FS_INQUIRY_LIST_36",'Quote Request Date:');
define("FS_INQUIRY_LIST_37",'Quote #:');
define("FS_INQUIRY_LIST_38",'Item: #');
define("FS_INQUIRY_LIST_38_1",'Item #: ');
define("FS_INQUIRY_LIST_39",'Below is the sales quote you have requested.');
define("FS_INQUIRY_LIST_40",'REFRENCE');
define("FS_INQUIRY_LIST_41",'Print this page');
define("FS_INQUIRY_LIST_42",'Quote Date:');


//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', 'This product is customized, please go to the product details page to select attributes.');
define('FS_MANAGE_CLOSE_TIP', 'This product is no longer available online. Please contact your account manager for checking, or you can check the similar product online.');

// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",'Account Administrator:');
define("FS_ACCOUNT_NEW",'Account #:');
define("FS_NAME",'Name');
define("FS_ACCOUNT_MANAGE_CONTACT",'Account Manager Contact:');
define("FS_ACCOUNT_PHONE",'Phone:');
define("FS_ACCOUNT_ORDERS_PENDING",'Orders Pending');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'Progressing');
define("FS_ACCOUNT_ORDERS_COMPLETED",'Completed');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'Active Quote');
define("FS_ACCOUNT_ORDERS_RMA",'RMA Order');
define("FS_ACCOUNT_ORDERS",'ORDERS');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'View and Track Recent Orders');
define("FS_ACCOUNT_HISTORY",'Order History');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'New Quote Request');
define("FS_ACCOUNT_QUOTE_STATUS",'Quote Status/History');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'New RMA Request');
define("FS_ACCOUNT_RMA_STATUS",'RMA Status/History');
define("FS_ACCOUNT_REVIEW_PURCHASES",'Review Your Purchases');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'Check order status, tracking, and history.');
define("FS_ACCOUNT_VIEW_ORDERS",'View Orders');
define("FS_ACCOUNT_SEARCH_ORDERS",'Search Orders:');
define("FS_ACCOUNT_PO_ORDER_ID",'PO #, Order #, Item ID');
define("FS_ACCOUNT_SEARCH",'Search');
define("FS_ACCOUNT_NET_TERMS",'CREDIT ACCOUNT');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'Buy Now, Pay Later');
define("FS_ACCOUNT_CURRENT_BALANCE",'Current Balance');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'View Your Credit Details');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'ACCOUNT SETTINGS');
define("FS_ACCOUNT_PASSWORD_MAIL",'Password and E-mail');
define("FS_ACCOUNT_USER_PHOTO",'User Photo');
define("FS_ACCOUNT_USER_NAME",'User Name');
define("FS_ACCOUNT_EMAIL_ADDRESS",'Email Address');
define("FS_ACCOUNT_EMAIL_PASSWORD",'Password');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'Email Subscription Preferences');
define("FS_ACCOUNT_SHOPPING_TOOLS",'SHOPPING TOOLS');
define("FS_ACCOUNT_USEFUL_SHOPPING",'Useful Shopping Tools');
define("FS_ACCOUNT_REQUEST_SAMPLE",'Request Sample');
define("FS_ACCOUNT_WRITE_REVIEW",'Leave Feedback about FS');
define("FS_ACCOUNT_USER_INFORMATION",'USER INFORMATION');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'Cases and Addresses');
define("FS_ACCOUNT_ADDRESS_BOOK",'Address Book');
define("FS_ACCOUNT_CASE_CENTER",'Support Tickets');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click <br>"<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');

define("FS_ACCOUNT_CASE_E_MAIL",'E-mail:');
define("FS_CREATE_SHIPPING_ADDRESS",'Create a New Shipping Address');
define("FS_CREATE_BILLING_ADDRESS",'Create a New Billing Address');
define("FS_EDIT_SHIPPING_ADDRESS",'Edit Your Shipping Address');
define("FS_EDIT_BILLING_ADDRESS",'Edit Your Billing Address');
define("FS_CONFIRMATION",'Confirmation');
define("FS_DELETE_THIS_ADDRESS",'Delete this address?');
define("FS_SAVED_ADDRESSES",'Saved Addresses');
define("FS_SAVE_AS_DEFAULT",'Save as Default');

//2019.11.26 quest 售后地址表单
define('FS_SALES_INFO_MODAL_TITLE','Add A New Address');
define('FS_SALES_INFO_MODAL_FNAME','First Name');
define('FS_SALES_INFO_MODAL_LNAME','Last Name');
define('FS_SALES_INFO_MODAL_COUNTRY','Country/Region');
define('FS_SALES_INFO_MODAL_ADS_TYPE','Address Type');
define('FS_SALES_INFO_MODAL_COMPANT','Company Name');
define('FS_SALES_INFO_MODAL_VAT','VAT/TAX NUMBER');
define('FS_SALES_INFO_MODAL_ADS1','Address');
define('FS_SALES_INFO_MODAL_ADS2','Address 2');
define('FS_SALES_INFO_MODAL_CITY','City/Town');
define('FS_SALES_INFO_MODAL_SPR','State/Province/Region');
define('FS_SALES_INFO_MODAL_STATE','Please select state');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','Zip Code');
define('FS_SALES_INFO_MODAL_PHONE_NUM','Phone Number');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','Cancel');
define('FS_SALES_INFO_MODAL_BTN_SAVE','Save');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','Street address,c/o');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','Apt,Suite,floor,etc.');


define('FS_RMA_SEARCH_TIPS','All RMAs');
define('FS_SALES_DETILS_TYPE1','Refund');
define('FS_SALES_DETILS_TYPE2','Exchange');
define('FS_SALES_DETILS_TYPE3','Repair');
define('FS_RMA_NAVI1','RMA Confirmation');
define('FS_RMA_NAVI2','RMA History');
define('FS_RMA_NAVI3','RMA Detail');
define('FS_RMA_NAVI4','RMA');
define('FS_RMA_NAVI5','New RMA Request');
define('FS_RMA_DETAILS_NAVI1','Return & Refund Detail');
define('FS_RMA_DETAILS_NAVI2','Exchange Detail');
define('FS_RMA_DETAILS_NAVI3','Repair Detail');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', 'Please transfer to the below account.');

define('FS_SALES_REQUEST_SEARCH_TIPS','All Valid Orders');

define("FS_ACCOUNT_REQUEST_A_SAMPLE",'Request a Sample');
define("FS_ACCOUNT_USEFUL_TOOLS",'USEFUL TOOLS');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Support and Feedback');
define("FS_ACCOUNT_CANCEL",'Delete');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'Shipping Addresses');
define("FS_ACCOUNT_BILLING_ADDRESS",'Billing Addresses');
define('ACCOUNT_MY_HOME','Home');
define("FS_REVIEW_PURCHASE_10",'Order #, Item #');

//首页版块
define('FS_INDEX_FPE_TITLE','Featured Products');
define('FS_INDEX_ETN_TITLE','Explore the Network');
define('FS_INDEX_SERVICE_TITLE','Services');
define('FS_ACCOUNT_TITLE','Order Status');
define('FS_ACCOUNT_BTN','View Orders');
define('FS_ACCOUNT_CONTENT','Track your order to get the latest package status and estimated delivery time.');
define('FS_ACCOUNT_TITLE_REGISTER','Create Account');

//打印相关
define('FS_PRINT_QTY','Quantity');
define('FS_PRINT_UNIT_PRICE','Price');
define('FS_PRINT_TOTAL','Item Total');
define('FS_PRINT_SHIPMENT','Shipment');
define('FS_PRINT_SUBTOTAL','Subtotal:');
define('FS_PRINT_SHIPPING_COST','Shipping Cost:');
define('FS_PRINT_SHIPPING_TAX','Vat/Tax/GST:');
define('FS_PRINT_TOTAL_WIDTH_COLON','Total:');
define('FS_PRINT_ITEM','Item');

define('FIBER_SPARKASSE_BANK_NAME','Bank Name:');

//报价相关
define('INQUIRY_QUOTE_LIST_1','View Quote');
define('INQUIRY_QUOTE_LIST_2','Quote History');

define('FS_CHECKOUT_ERROR_VAT','Please enter a valid VAT NUMBER. eg: $VAT');
define('FS_CHECKOUT_POPUP_TIPS','Are you sure you want to return to your Shopping Cart?');
define('FS_CHECKOUT_POPUP_TIPS_QUOTE','Are you sure you want to return to your Quote?');
define('FS_CHECKOUT_POPUP_BUTTON1','Stay in Checkout');
define('FS_CHECKOUT_POPUP_BUTTON2','Return to Cart');
define('FS_CHECKOUT_PAYMENT','Payment');
define('FS_CHECKOUT_PAYMENT_PO','Upload PO');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','Customized');
define('FS_ORDER_MANUFACTURING','Manufacturing');
define('FS_ORDER_TEST_PASS','Test Passed');
define('FS_ORDER_SHIPPED','Shipped');
define('FS_ORDER_TEST_REPORT','Test Report');

define('FS_PRODUCTS_INFO_NOTE_TITLE','Note: ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','The coherent CFP transceiver can\'t be sold separately.');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','Your credit account is in a state of "Credit Suspension" and Net Terms payment option is unavailable. Please <a href="'.zen_href_link('manage_orders','','SSL').'" target="_blank">pay off the unpaid invoices</a> or choose other payment options.');
define('FS_PO_FORZEN_NOTICE_02','Your credit account is in a state of "Credit Suspension". See more on Credit Details page.');

define('FS_PO_FORZEN_NOTICE_03','Your credit account is in a state of "Credit Suspension". Please <a href="'.zen_href_link('manage_orders','','SSL').'">pay off the unpaid invoices</a> or contact your account manager for further details.');

define("FS_ACCOUNT_RMA_ORDERS",'RMA Order');
define("FS_ACCOUNT_PO_NUMBER",'PO #');
define("FS_ACCOUNT_REQUEST_RMA",'Request RMA');
define("FS_ACCOUNT_RMA_HISTORY",'RMA History');
define("FS_ACCOUNT_PO_ORDER",'Submit/View Purchase Order');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'Review Your Order');
define("FS_ACCOUNT_QUOTES",'QUOTES');
define("FS_ACCOUNT_QUICK_QUOTE",'Quick Quote and View Status');
define("FS_ACCOUNT_ACTIVE",'Active Quote');
define("FS_ACCOUNT_QUOTE_HISTORY",'Quote History');
define("FS_ACCOUNT_REQUEST_QUOTE",'Request Quote');
define("FS_ACCOUNT_ORDER_PENDING",'Order Pending');
define("FS_ACCOUNT_ORDER_PROGRESSING",'Order Progressing');
define("FS_ACCOUNT_ORDER_COMMENTS",'Order Comments:');
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'Order Review');


//support
define("SUPPORT_PAGE","Welcome to FS Customer Support. How can we help?");
define("SUPPORT_PAGE_1","Instant Help");
define("SUPPORT_PAGE_2","Live Chat");
define("SUPPORT_PAGE_3","Download Center");
define("SUPPORT_PAGE_4","Learn more");
define("SUPPORT_PAGE_5","Request Technical Support");
define("SUPPORT_PAGE_6","Request Quote");
define("SUPPORT_PAGE_7","Case Study");
define("SUPPORT_PAGE_8","Support Videos");
define("SUPPORT_PAGE_9","Community");
define("SUPPORT_PAGE_10","More Support Resources");
define("SUPPORT_PAGE_11","Return Policy");
define("SUPPORT_PAGE_12","Track Your Package");
define("SUPPORT_PAGE_13","Request a Sample");
define("SUPPORT_PAGE_14","FS Support");
define('FS_SUPPORT','Support');

define('FS_SEND_EMAIL_PAYMENT',"Payment Request");

define('FS_BY_CLICKING','By clicking Submit Order, you agree to our');
define('FS_TERMS_AND_CONDITIONS','Terms and Conditions');
define('FS_PRIVACY_AND_COOKIES',' Privacy and Cookies');
define('FS_AND_RIGHT_OF_WITHDRAWL',' and Right of Withdrawl.');
define("FS_ZIP_CODE_EU","Postcode");
define("FS_ADDRESS_EU","Street and House Number");
define("FS_ADDRESS2_EU","Additional Address");
define('ACCOUNT_EDIT_CITY_EU','City');

//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','Thanks for visiting FS. For immediate assistance, please visit');
define('FS_GIVE_FEEDBACK_TIP_2','FS Support');//链接
define('FS_GIVE_FEEDBACK_TIP_3','or');
define('FS_GIVE_FEEDBACK_TIP_4','Live Chat ');//链接
define('FS_GIVE_FEEDBACK_TIP_5','with us.');
define('FS_FEEDBACK_SELECT_1', 'Website design');
define('FS_FEEDBACK_SELECT_2', 'Search and navigation');
define('FS_FEEDBACK_SELECT_3', 'Product');
define('FS_FEEDBACK_SELECT_4', 'Checkout and payment');
define('FS_FEEDBACK_SELECT_5', 'Shipping and delivery');
define('FS_FEEDBACK_SELECT_6', 'Return and exchange');
define('FS_FEEDBACK_SELECT_7', 'Service and support');
define('FS_FEEDBACK_SELECT_8', 'Website suggestion');


define('FS_AND',' and ');
define('FS_RIGHT_OF_WITHDRAWL','Right of Withdrawl');
define('FS_RIGHT_OF_WITHDRAWL_01','');
define('FS_CHECKOUT_ERROR3_EU','Your Street and House Number is required');


//报价语言包
define('INQUIRY_LISTS_1','All Quotes');
define('INQUIRY_LISTS_2','Active');
define('INQUIRY_LISTS_3','Purchased');
define('INQUIRY_LISTS_4','The quote has been generated to order successfully.');
define('INQUIRY_LISTS_5','REFERENCE');
define('INQUIRY_LISTS_6','Quote Details');
define('FS_INQUIRY_INFO_66_1','This quote request has expired on ');
define('FS_INQUIRY_INFO_66_6','The quote request has expired on ');
define('FS_INQUIRY_INFO_66_2',' You can quote it again if need.');
define('FS_INQUIRY_INFO_66_3','This quote has expired on ');
define('FS_INQUIRY_INFO_66_7','The quote has expired on ');
define('FS_INQUIRY_INFO_66_4','The quote request is valid until ');
define("FS_INQUIRY_LIST_27",'Customer Manager:');
define('FS_INQUIRY_INFO_66_5','You can checkout directly after getting the quotation from your account manager.');

define('FS_QUOTE','Quote');
define('INQUIRY_LISTS_7','All Time Frame');
define('INQUIRY_LISTS_8','Quote History');
define('INQUIRY_LISTS_9','quote history');
define('INQUIRY_LISTS_10','Quote Request');
define('INQUIRY_LISTS_11','Quotation Request');
define('INQUIRY_LISTS_12','Expires on: ');
define('INQUIRY_LISTS_13','Created by: ');
define('INQUIRY_LISTS_14','Account Manager: ');
define('INQUIRY_LISTS_15','Return to Quote');

// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate for Education & Learning');
define('FS_ERate_03','Server Room');
define('FS_ERate_04','Classroom');
define('FS_ERate_05','Lecture Hall');
define('FS_ERate_06','Laboratory');
define('FS_ERate_07','Contact an EDU specialist today');
define('FS_ERate_08','Mon - Fri, 9:00am-5:00pm EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','E-rate Discounts');
define('FS_ERate_11','Take advantage of E-rate funding to receive discounts on networking equipment. Most public, private, and charter schools & libraries qualify. We proudly serve teachers, principals, and IT support staff by sourcing the best technology solutions for classrooms—at every level of education.');
define('FS_ERate_12','FS SPIN (Form 498 ID): 143051712');
define('FS_ERate_13','Get Started for E-rate');
define('FS_ERate_14','Leave your contact or call us for assistant');
define('FS_ERate_15','Please enter your email address.');
define('FS_ERate_16','Please enter a valid email address.');
define('FS_ERate_17','Thank you. We will get in touch with you ASAP.');
define('FS_ERate_18','10G DWDM Interconnections Over 120km in Campus Network');
define('FS_ERate_19','FS FMU DWDM and FMT series enable good quality transmission over long distance in a simple way.');
define('FS_ERate_20','Read more');
define('FS_ERate_21','Sir/Madam');
define('FS_ERate_22','We\'ve received your E-Rate request and will get in touch with you soon. Here is your case number $CNxxxxxxx, you can refer to this number in all follow-up communications regarding this request.');
define('FS_ERate_23','FS - We received your E-Rate request ');
define('FS_ERate_24','Featured Case');
define('FS_ERate_25','Laboratory');
define('FS_ERate_26','Your Email Address');
define('FS_ERate_27','E-rate for Education ');
define('FS_ERate_28','E-rate Support');
define('FS_ERate_29','Receive discounts with E-rate funding');


define('CART_SHIPPING_METHOD_CHECKOUT_PRE','Shipping:');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT','Calculated at checkout');
define('FS_COMMON_GSP_1','ship from FS Asia');
define('FS_COMMON_GSP_2','Import Fees');
define('FS_COMMON_GSP_3','included');
define('FS_COMMON_GSP_4','Import fees included at time of purchase plus customs clearance handled by FS.');
define('FS_COMMON_GSP_5','Close');

//subtotal(有税收的带上税收)
define('FS_SHOP_CART_SUBTOTAL','Subtotal:');
define('FS_SHOP_CART_EXCL_VAT','VAT ($VAT)');
define('FS_SHOP_CART_EXCL_SG_VAT','GST (7%)');
define('FS_SHOP_CART_EXCL_AU_VAT','Australia GST (10%)');
define('FS_SHOP_CART_EXCL_DE_VAT','Germany VAT ($VAT)');


define("FS_SHOP_CART_LIST_SUB",'Subtotal');

//详情页定制弹窗文字 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'Customized');
define('FS_DETAIL_CUSTOM_2', 'Manufacturing');
define('FS_DETAIL_CUSTOM_3', 'Shipped');
define('FS_DETAIL_CUSTOM_4', 'Arrived');
define('FS_DETAIL_CUSTOM_5', 'Estimated manufacturing time: ');
define('FS_DETAIL_CUSTOM_6', 'Estimated to ship: ');
define('FS_DETAIL_CUSTOM_7', 'Estimated to get it by: ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Customized');
define('FS_GSP_STOCK_2', 'International Product');
define('FS_GSP_STOCK_3', 'ship from ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Import Fees');
define('FS_GSP_STOCK_6', 'included');
define('FS_GSP_STOCK_7', 'The item will be shipped from Asia global warehouse via <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global Shipping Program (GSP)</a>. Import fees included at the time of purchase plus customs clearance are handled by FS. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Learn more</a>');
define('FS_GSP_STOCK_9', 'The item will be shipped from Asia global warehouse via <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global Shipping Program (GSP)</a>. Import fees included at the time of purchase plus customs clearance are handled by FS. Sales tax will be included at checkout. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Learn more</a>');
define('FS_GSP_STOCK_8', 'Close');
define('FS_AVAILABLE', 'Available');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW','The item will be shipped from Asia global warehouse.');

define('FS_OUTBREAK_NOTICE', 'We\'re here to help - A letter about COVID-19 from FS');
define('FS_OUTBREAK_NOTICE_M', 'A letter about COVID-19 from FS');
define('FS_OUTBREAK_READ_MORE', 'Read more');

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','The delivery date applies to the inventory items purchased by 5pm EST on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched from FS Asia warehouse with <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global Shipping Program (GSP)</a>.');
define('FS_GSP_COVID_TIPS','There may be a delay to your delivery service due to COVID-19 and increased volume. For more tracking details, please refer to  <a href="'.reset_url('/login.html').'" target="_blank">My Account</a>. ');

define('PRODUCTS_WARRANTY','Transceivers');
define('PRODUCTS_WARRANTY_1','Professional Quality ');
define('PRODUCTS_WARRANTY_2','Testing Program');
define('PRODUCTS_WARRANTY_3',' for ');
define('PRODUCTS_WARRANTY_4','Shipping &amp; Delivery');
define('PRODUCTS_WARRANTY_5','WARRANTY_YEARS Years Warranty');
define('PRODUCTS_WARRANTY_5_1','WARRANTY_YEARS Year Warranty');
define('PRODUCTS_WARRANTY_6','Lifetime Warranty');
define('PRODUCTS_WARRANTY_7','Free Returns');

//打印发票 VAT No 本地化
define('FS_VAT_NO_EU','VAT No.: ');
define('FS_VAT_NO_AU','ABN: ');
define('FS_VAT_NO_SG','GST Reg No.: ');
define('FS_VAT_NO_BR','CNPJ: ');
define('FS_VAT_NO_CL','RUT: ');
define('FS_VAT_NO_AR','CUIT: ');
define('FS_VAT_NO_DEFAULT','Tax No.: ');

//购物车saved_items、saved_cart_details
define('FS_SAVED_CARTS','Saved Carts');
define('FS_ALL_SAVED_CARTS','All Saved Carts');
define('FS_ADD_ALL_TO_CARTS','Add All to Cart');
define('FS_GO','GO');
define('FS_SHOW_CART','Show');
define('FS_SEARCH','search');
define('FS_CART_NAME','Cart Name');
define('FS_SEARCH_SAVED_CARTS','Search Saved Carts');
define('FS_DATE_SAVED','Date Saved');
define('FS_CUSTOMER_ID','Customer ID');
define('FS_ACCOUNT_MANAGER','Account Manager');
define('FS_PHONE','Phone#');
define('FS_SUBTOTAL','Subtotal');
define('FS_VIEW_SHIPPING_CART','View Shopping Cart');
define('FS_SAVE_CART_CONDITIONS','If you can\'t locate your Saved Cart, try selecting different filter conditions.');
define('FS_NO_SAVED_CART_FOUND','No Saved Cart Found.');
define('FS_CRET_REFERENCE','Cart Reference');
define('FS_CART_DELETE','Delete');
define('FS_CART_NEW_ITEMS','New item(s) have been added to your');
define('FS_CART_SUCCESSFULLY_UPDATED','Your cart has been successfully updated');
define('FS_CART_SAVED_CART_NAME','Saved Cart Name');
define('FS_CART_NEW_CART_CREATE','New cart has been created.');
define('FS_CART_HAS_BEEN_ADD','has been added to your Saved Carts.');
define('FS_CART_NAME_ALREADY_EXISTED','This name has already existed. Please use a different name.');
define('FS_ADD_TO_SAVED_CART','Add to Saved Cart');
define('FS_SAVE_CART_SELECT','Select Saved Cart');
define('FS_ADD_THE_ITEMS','Or, add the item(s) into an existing Saved Cart.');
define('FS_NAME_YOUR_SAVED_CART','Name Your Saved Cart');
define('FS_ADD_TO_CART','Add to Cart ');
define('FS_EMIAL_YOUR_CART','Email Your Cart');
define('FS_PRINT_THIS_PAGE','Print this page');
define('FS_SAVED_CART_DETAILS','Saved Cart Details');
define('FS_BELOW_IS_THE_CART','Below is the cart details you have saved.');
define('FS_CART_CONTACT_CUSTOMER_SERVICE','Contact Customer Service');
define('FS_UPDATED_SUCCESSFULLY','Your cart has been updated successfully.');
define('FS_NEW_ITEM_CART','New item(s) has been added to your Saved Cart ');
define('FS_CART_ALL_ITEMS','All item(s) in this cart is no longer available for purchase, please contact your account manager for availability.');
define('FS_CART_SOME_CUSTOMIZED','Some customized item(s) in this cart  have been changed, please go to the product details page to select attributes.');
define('FS_CART_ALL_CUSTOMEIZED_ITEMS','All items in this cart have been changed,  please go to the product details page to select attributes.');
define('FS_CART_THE_QUANTITY','The quantity you’ve specified exceeds available inventory and has been adjusted accordingly, please contact your account manager for additional quantity.');
define('FS_CART_SHOPPING_CART_DIRECTLY','The item(s) in this cart is no longer available for purchase online, please contact your account manager for availability. At the meantime, the availale items have been moved into shopping cart directly.');
define('FS_CART_QUANTITY_ADDITIONAL','The quantity you’ve specified exceeds available inventory and has been adjusted accordingly, please contact your account manager for additional quantity.');
define('FS_CART_CUSTOMIZED_SHOPPING_CART','The customized item(s)  in this cart have been changed, please go to the product details page to select attributes. At the meantime, the availale items have been moved into shopping cart directly.');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','Please enter the cart name maximum 150 words.');
define('FS_FROM','From');
define('FS_TO_EMAIL','To');
define('FS_SELECT_SAVE_CART','Please select save cart.');

define('FS_NOTICE_FREE_SHIPPING','Free shipping on orders over $MONEY');
define('FS_NOTICE_FREE_DELIVERY','Free delivery on orders over $MONEY');
define('FS_NOTICE_FAST_SHIPPING','Fast shipping to $COUNTRY');
define('FS_NOTICE_HEADER_COMMON_TIPS',' Delivery times may be longer than usual due to COVID-19 effect.');

define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 Business Day Service');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early® service');
define('FS_SERVICE_WORD', 'service');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'Make Payment');
define('FS_EMAIL_OPTIMIZE_02', 'Note: if you\'ve already done the payment, please ignore this email, thanks.');
define('FS_EMAIL_OPTIMIZE_03', 'We\'re on it!');
define('FS_EMAIL_OPTIMIZE_04', 'Details for your order #ORDER_NUMBER are below. We’ll send you tracking information as soon as any update comes from your order.');
define('FS_EMAIL_OPTIMIZE_05', 'View Order');
define('FS_EMAIL_OPTIMIZE_06', 'Note: if you\'ve already uploaded the PO, please ignore this email, thanks.');
define('FS_EMAIL_OPTIMIZE_07', 'Thanks for your Order');
define('FS_EMAIL_OPTIMIZE_08', 'Please complete payment within 7 business days. Otherwise, the order will be cancelled due to inventory change of items. After completing payment you will receive a payment clearance notification to inform that FS has confirmed your order.');
define('FS_EMAIL_OPTIMIZE_09', 'Payment Instructions');
define('FS_EMAIL_OPTIMIZE_10', 'After the payment is remitted successfully, please send bank slip to $FS_EMAIL. or your account manager. This will help release your order on priority and avoid cancellation of your order. Please send your payment to the following account.');
define('FS_EMAIL_OPTIMIZE_11', 'Note: Please leave your order number $ORDER_NUMBER and email address in the bank transfer memo.');
define('FS_EMAIL_OPTIMIZE_12', 'Delivery Policy');
define('FS_EMAIL_OPTIMIZE_13', 'Estimated delivery time does not commence until your payment has been received by us');
define('FS_EMAIL_OPTIMIZE_14', 'Your order will be delivered between 9am and 5pm, Monday to Friday (excluding public holidays). Someone will need to be at the nominated address to accept and sign for delivery.');

define('FS_PLEASE_CHECK_THE_URL','Please check the URL, or go to the ');
define('FS_HOMEPAGE','Homepage');
define('FS_GO_TO_HOMEPAGE','Go to Homepage');

define('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 Business Days');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 Business Days');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 Business Days');

define("FS_WORD_CLOSE", 'Close');



//报价购物车
define('FS_NEW_OTHER_LENGTH','Other Length');
define('FS_INQUIRY_CART_1',"Request a Quote");
define('FS_INQUIRY_CART_2',"Quote Contact Information");
define('FS_INQUIRY_CART_3',"First Name*");
define('FS_INQUIRY_CART_4',"Last Name*");
define('FS_INQUIRY_CART_5',"Email*");
define('FS_INQUIRY_CART_6',"Phone");
define('FS_INQUIRY_CART_7',"Comments");
define('FS_INQUIRY_CART_8',"Upload File");
define('FS_INQUIRY_CART_9',"Allow files of type PDF, JPG, PNG.<br>Maximum file size 5M.");
define('FS_INQUIRY_CART_10',"Quickly add items to your quote details by entering product IDs and quantities.");
define('FS_INQUIRY_CART_11',"Add to Quote");
define('FS_INQUIRY_CART_12',"Quote Request");
define('FS_INQUIRY_CART_13',"Please leave a message if you have any special requirements.");
define('FS_INQUIRY_CART_14',"Enter product ID");
define('FS_INQUIRY_CART_15',"Please enter a product ID.");



define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'UPS Express Saver® Next Day Service');
define("FS_BLANK", ' ');
// 结算页美国、澳大利亚跳转 、 俄罗斯对公支付
define('AUSTRALIA_HREF_1',"Orders on this site cannot be delivered to Australia. Please kindly go to ");
define('FS_AUSTRALIA_CHECKOUT',"FS Australia");
define('AUSTRALIA_HREF_2'," if you wish to deliver to Australia.");
define('UNITED_STATES_SITE_HREF_1',"Orders on this site cannot be delivered to United States. Please kindly go to ");
define('FS_UNITED_STATES_SITE',"FS United States");
define('UNITED_STATES_SITE_HREF_2'," if you wish to deliver to United States.");
define('RUSSIAN_SITE_HREF_1',"For Legal Person, orders need to be paid via Cashless Payment with rubles. Please kindly go to ");
define('FS_RUSSIAN_SITE',"FS Russian Federation");
define('RUSSIAN_SITE_HREF_2'," if you wish to place the order.");




//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'Cart Loading');

//美国消费税
define('FS_VAX_TITLE_US','Est. Sales Tax');
define('FS_VAX_TITLE_US_TAX','Sales Tax');

//消费税提示小气泡
define('FS_VAX_US_TIPS','According to state tax laws, FS is required to collect sales tax from non-exempt parties. <a href="https://www.fs.com/service/sales_tax.html" target="_blank">Read more</a>');

//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "View Reviews");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "Write a review");
define('FS_VIEW_REVIEWS_SEARCH', "Search");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "Search Reviews:");
define('FS_VIEW_REVIEWS_ITEM', "Item #");
define('FS_VIEW_REVIEWS_1', "No Reviews Found.");
define('FS_VIEW_REVIEWS_2', "Find your order and share your review.");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "Reviewed on ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "Very satisfied");
define('FS_VIEW_REVIEWS_READ_MORE', "Read more");
define('FS_VIEW_REVIEWS_MORE', "More");
define('FS_VIEW_REVIEWS_SHOW', "Show");
define('FS_VIEW_REVIEWS_COMMENTS', "comments");


define('FS_SRVICE_WORD', "service");

//俄罗斯国家 详情页展示税后价
define('FS_EXCLUDED_VAT',' (Excl. VAT) ');
define('FS_INCLUDED_VAT',' (Incl. VAT) ');


//毛料ID库存与交期
define('FS_PRODUCT_MATERIAL_M','m');
define('FS_PRODUCT_MATERIAL_CABLE',' Cable Materials');
define('FS_PRODUCT_MATERIAL_TIP','The delivery time will be a little longer as the requested quantity exceeds  inventory. To request a split shipment of items in stock, please contact your account manager.');

//地址栏中文字符提示
define('FS_ADDRESSES_REGULAR',"Please enter an indentifible address.");
define('FS_ADDRESSES_REGULAR_1',"Please enter an indentifible address in accordance with the web language.");
define('FS_ADDRESSES_REGULAR_2',"Please enter an indentifible address in</br> accordance with the web language.");
define('FS_INQUIRY_PRODUCTS_NUM',"Please check the product information of your quote details.");

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'Please enter your full name.');
define('FS_NET_30_02', 'Please upload your Application Form.');
define('FS_NET_30_03', 'Credit Account already exists.');
define('FS_NET_30_04', 'FS - Your Net Terms Application Received');
define('FS_NET_30_05', 'We\'ve received your request for Net Terms.  It is currently under review and this process can approximately take up 2-3 business days . When a decision has been reached, you will be notified by FS email timely.');
define('FS_NET_30_06', 'Application Status');
define('FS_NET_30_07', 'Submitted');
define('FS_NET_30_08', 'Under Review');
define('FS_NET_30_09', 'Approved');
define('FS_NET_30_10', 'Rejected');
define('FS_NET_30_11', 'Submit Application Form');
define('FS_NET_30_12', 'Full Name');
define('FS_NET_30_13', 'Email');
define('FS_NET_30_14', 'Phone');
define('FS_NET_30_15', 'Upload Files');
define('FS_NET_30_16', 'Select File');
define('FS_NET_30_17', 'Your application form has been submitted successfully.');
define('FS_NET_30_18', 'We will send the review result within 2-3 business days by email, you can also trace updates in “#CASE_CENTER” with FS account.');
define('FS_NET_30_19', 'Thank you! Your Credit Application Form has been submitted successfully.');
define('FS_NET_30_20', 'Your Net Terms application is under review, please allow approximately 2-3 business days for processing.');
define('FS_NET_30_21', 'Glad to share with you that your request for Net Terms has been approved. From now on, you can place order on FS with Net Terms.');
define('FS_NET_30_22', 'You can also view your credit details in “#FS_CREDIT”.');
define('FS_NET_30_23', 'Sorry to tell you that your request for Net Terms was rejected. ');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', 'Do you want to re-apply for Net Terms?');
define('FS_NET_30_25', 'Complete and Submit the completed Application Form in “#NET_TERMS”.');
define('FS_NET_30_26', 'Any questions, please feel free to contact your account manager #ACCOUNT_MANAGER.');
define('FS_NET_30_27', 'Country/Region');
define('FS_NET_30_28', 'Comments');
define('FS_NET_30_29', 'Upload');
define('FS_NET_30_30','Thanks<br>The FS Team');
define('FS_NET_30_31','Request Received');
define('FS_NET_30_32','Net Terms');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','Explore the latest innovations');

//取消订阅
define('FS_UNSUBSCRIBE_MAIL_1','FS Newsletter');
define('FS_UNSUBSCRIBE_MAIL_2','Learn more about the latest preferential policies, inventory news, technical support and so on.');
define('FS_UNSUBSCRIBE_MAIL_3','Review Request Emails');
define('FS_UNSUBSCRIBE_MAIL_4','Review request emails will be sent after 7 days upon delivery of the order.');
define('FS_UNSUBSCRIBE_MAIL_5','Choose the emails you would like to receive from FS.');
define('FS_UNSUBSCRIBE_MAIL_6','Emails about your account and orders are important. We send those even if you have opted out of all the following emails.');


//checkout 账单地址邮编验证提示
define('FS_ZIP_VALID_1','The address you selected does not match postal service records. Please double-check your address.');
define('FS_ZIP_VALID_2','Please enter a valid Postal Code.');



//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', 'Companies');

/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','Wavelength (nm)');


define("FS_CHECKOUT_RU_FILE_TIPS_2", "Allow files of type JPG, JPGE, PDF, PNG, DOC, DOCX, XLS, XLSX. Maximum file size 5M.");


//100G产品提示语
define("FS_COHERENT_CFP","The coherent CFP transceiver isn't sold separately.");



//solution专题的常量定义
define("FS_SOLUTION_CLICK_OPEN_VIEW","Click to open expanded view");
define("FS_CUSTOMIZE_YOUR_SOLUTION","Choose & Customize Solution");
define("FS_TECH_SPEC_CUSTOMOZATION","Tech Specs");
define("FS_SOLUTION_OVERVIEW",'Overview');
define("FS_SOLUTION_CUSTOMIZED",'Add to Cart');
define("FS_SOLUTION_EDIT",'Edit');
define("FS_SOLUTION_CONFIGURATION",'Solution Configuration');
define("FS_SOLUTION_MORE",'More');
define("FS_SOLUTION_LESS",'Less');
define("FS_SOLUTION_DEVICES",'Devices');
define("FS_SOLUTION_TRANSCEIVER",'Transceiver');
define("FS_SOLUTION_WAVE_COM_BAR",'Wavelength & Compatible Brands');
define("FS_SOLUTION_ACCESSORIES",'Accessories');
define("FS_SOLUTION_CHOOSE_LENGTH",'Choose Length');
define("FS_SOLUTION_INFO",'Solution Information');

define('FS_SOLUTION_PERSONALIZATION','Customized');
define('FS_SOLUTION_MANUFACTURING','Manufacturing');
define('FS_SOLUTION_SHIPPED','Shipped');
define('FS_SOLUTION_ARRIVED','Arrived');
define('FS_SOLUTION_CON_LIST','Solution Configuration List');
define('FS_SOLUTION_QUANTITY','Quantity');
define('FS_SOLUTION_TOTAL','Total');

define('FS_SOLUTION_SITEA','siteA');
define('FS_SOLUTION_SITEB','siteB');

define('FS_SOLUTION_NAV_01','Optical Transport Network');
define('FS_SOLUTION_NAV_02','Campus Network');
define('FS_SOLUTION_NAV_03','Data Center');
define('FS_SOLUTION_NAV_04','Structured Cabling');
define('FS_SOLUTION_NAV_05','By Application');
define('FS_SOLUTION_NAV_06','10G CWDM Dual Fiber Network');
define('FS_SOLUTION_NAV_07','10G CWDM Single Fiber Network');
define('FS_SOLUTION_NAV_08','10G DWDM Dual Fiber Network');
define('FS_SOLUTION_NAV_09','10G DWDM Single Fiber Network');
define('FS_SOLUTION_NAV_10','25G DWDM Dual Fiber Network');
define('FS_SOLUTION_NAV_11','25G DWDM Single Fiber Network');
define('FS_SOLUTION_NAV_12','40/100G Coherent Network');
define('FS_SOLUTION_NAV_13','Enterprise Network');
define('FS_SOLUTION_NAV_14','Wireless and Mobility');
define('FS_SOLUTION_NAV_15','Multi-branch Network');
define('FS_SOLUTION_NAV_16','Cloud-managed Networking');
define('FS_SOLUTION_NAV_17','Data Center Structured Cabling');
define('FS_SOLUTION_NAV_18','High-density MTP®/MPO Cabling');
define('FS_SOLUTION_NAV_19','40G/100G Migration');
define('FS_SOLUTION_NAV_20','Pre-terminated Copper Cabling');
define('FS_SOLUTION_NAV_21','Multi-service CWDM Solution');
define('FS_SOLUTION_NAV_22','10G DWDM Long Haul Transport');
define('FS_SOLUTION_NAV_23','25G WDM for 5G Fronthaul');
define('FS_SOLUTION_NAV_24','100G Coherent DWDM Solution');
define('FS_SOLUTION_NAV_25','MLAG Network Optimization');
define('FS_SOLUTION_NAV_26','Data Center Core Network Switching');
define('FS_SOLUTION_NAV_27','Power over Ethernet Solution');
define('FS_SOLUTION_NAV_28','Secure Wireless Solution');
define('FS_SOLUTION_NAV_29','Data Center Structured Cabling');
define('FS_SOLUTION_NAV_30','High-density MTP®/MPO Cabling');
define('FS_SOLUTION_NAV_31','40G/100G Migration');
define('FS_SOLUTION_NAV_32','Pre-terminated Copper Cabling');
define('FS_SOLUTION_NAV_33','Professional Solution Tech Team & Support');
define('FS_SOLUTION_NAV_33','Enterprise Data Center');
define('FS_SOLUTION_NAV_34','Service Provider Data Center');
define('FS_SOLUTION_NAV_35','Hyperscale and Cloud Data Center');
define('FS_SOLUTION_NAV_36','Multi Tenant Data Center');
define('FS_SOLUTION_NAV_34','Enterprise Data Center');
define('FS_SOLUTION_NAV_35','Service Provider Data Center');
define('FS_SOLUTION_NAV_36','Hyperscale and Cloud Data Center');
define('FS_SOLUTION_NAV_37','Multi Tenant Data Center');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','M6200 Series 10G DWDM Long-haul');
define('FS_SOLUTION_NAV_M6500','M6500 series 100G/200G High Bandwidth');
define('FS_SOLUTION_NAV_M6800','M6800 Series 1.6T Solution for DCI');
define('FS_SOLUTION_NAV_WiFi6','Wi-Fi 6 Networking Solutions');
//新加坡
define("FS_CHECKOUT_ERROR_SG_01","Your Address 2 is required.");
define("FS_CHECKOUT_ERROR_SG_02","Apt, Suite, Floor/Unit No.");
define("FS_CHECKOUT_ERROR_SG_03","Ticket Number");
define("FS_CHECKOUT_ERROR_SG_04","To ensure a smooth delivery, please provide a Ticket Number for parcels sent to Equinix.");
define("FS_CHECKOUT_ERROR_SG_05","*During COVID-19 special management period, it is recommended to fill in your house address to ensure the timeliness of receipt.");
define("FS_CHECKOUT_ERROR_SG_06","Please fill in your shipping address completely.");

define('FS_CHECKOUT_ERROR_001',"You've reached the maximum units allowed for the purchase of above items. All available products are added into the cart.");
define('FS_CHECKOUT_ERROR_002','Please select <span>4</span> different Channels.');
define("FS_SEE_ALL_RESULTS","See all results");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD',"Software Download");
define('FS_CHECK',"Check the latest software release of switches that you have purchased.");
define('FS_SOFWARE','Software Download');
define('FS_SOFWARE_1','Contact Customer Service');
define('FS_SOFWARE_2','Check the latest software release of switches that you have purchased. For more software release, please go to');
define('FS_SOFWARE_4','Download Center');
define('FS_SOFWARE_5','Show:');
define('FS_SOFWARE_6','Network Switches');
define('FS_SOFWARE_7','1G/10G Switches');
define('FS_SOFWARE_8','25G Switches');
define('FS_SOFWARE_9','40G Switches');
define('FS_SOFWARE_10','100G Switches');
define('FS_SOFWARE_11','400G Switches');
define('FS_SOFWARE_12','Search Item:');
define('FS_SOFWARE_13','Search');
define('FS_SOFWARE_14','Latest File Information');
define('FS_SOFWARE_15','Product ID');
define('FS_SOFWARE_16','Release Date');
define('FS_SOFWARE_17','Size');
define('FS_SOFWARE_18','Software');
define('FS_SOFWARE_19','Software Notification');
define('FS_SOFWARE_20','Latest File Information');
define('FS_SOFWARE_22','Release Note');
define('FS_SOFWARE_23','Release');
define('FS_SOFWARE_24','Software');
define('FS_SOFWARE_25','Download');
define('FS_SOFWARE_26','Software Notification');
define('FS_SOFWARE_27','Unsubscribe');
define('FS_SOFWARE_28','Subscribe');
define('FS_SOFWARE_29','Unsubscribe new release of software?');
define('FS_SOFWARE_30','Subscribe new release of software?');
define('FS_SOFWARE_31','If you can\'t locate your software, try selecting different filter conditions.');
define('FS_SOFWARE_32','You haven\'t purchased FS Switches before, go shopping for FS Switches.');
define('FS_SOFWARE_33','Start Shopping');
define('FS_SOFWARE_34','You have subscribed successfully.');
define('FS_SOFWARE_35','You will receive the email notification about the latest software.');
define('FS_SOFWARE_36','You have subscribed successfully.');
define('FS_SOFWARE_37','You have unsubscribed successfully.');
define('FS_SOFWARE_38','You will no longer receive the email notification about the latest software.');
define('FS_SOFWARE_39','Item ID');
define('FS_SOFWARE_40','NO SOFTWARE FOUND.');

define('FS_SOFWARE_41','Subscription Confirmed');
define('FS_SOFWARE_42','You have successfully subscribed to the software updates for the below switch, we\'ll send you notification once the latest version is available.');
define('FS_SOFWARE_43','You might also be interested in...');
define('FS_SOFWARE_44','Learn what we\'ve brought to our customers <br> around the world.');
define('FS_SOFWARE_45','View the latest innovative products & company <br> events.');
define('FS_SOFWARE_46','FS - Software Updates Subscription');
define('FS_SOFWARE_47','Unsubscribe Successful');
define('FS_SOFWARE_48','You will no longer receive software updates notifications for the below switch.');
define('FS_SOFWARE_49','If there\'s a mistake, re-subscribe by clicking the button below.');
define('FS_SOFWARE_50','Re-subscribe');
define('FS_SOFWARE_51','Let\'s Keep In Touch');
define('FS_SOFWARE_52','Software Subscription');
define('FS_SOFWARE_53','FS Customer Success');
define('FS_SOFWARE_54','FS New Announcement');


define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','Can\'t find a shipping option?');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','Due to carrier\'s restriction on item dimension, orders containing #73579/#73958 cannot be shipped by general express delivery. You may use your own carrier or consult your account manager about forwarder shipping. We\'re sorry for the inconvenience.');

//checkout_footer_new
define('FS_CHECKOUT_FOOTER_NEW_01', 'I have feedback on');
define('FS_CHECKOUT_FOOTER_NEW_02', '<a href="' . reset_url('service/fs_support.html'). '" target="_blank" >FS Support</a> or <a target="_blank" href="' . reset_url('contact_us.html') . '">Contact Us</a>.');
define('FS_CHECKOUT_FOOTER_NEW_03', 'For immediate assistance, please visit our ');
define('FS_CHECKOUT_FOOTER_NEW_04', 'Select a topic*');
define('FS_CHECKOUT_FOOTER_NEW_05', 'Please select... ');
define('FS_CHECKOUT_FOOTER_NEW_06', 'Signing in/Creating an account');
define('FS_CHECKOUT_FOOTER_NEW_07', 'Shopping Cart');
define('FS_CHECKOUT_FOOTER_NEW_08', 'Tax');
define('FS_CHECKOUT_FOOTER_NEW_09', 'Shipping & Billing Address');
define('FS_CHECKOUT_FOOTER_NEW_10', 'Shipping');
define('FS_CHECKOUT_FOOTER_NEW_11', 'Payments');
define('FS_CHECKOUT_FOOTER_NEW_12', 'Others');
define('FS_CHECKOUT_FOOTER_NEW_13', 'Please select a topic.');
define('FS_CHECKOUT_FOOTER_NEW_14', 'What can we do to improve your experience?');
define('FS_CHECKOUT_FOOTER_NEW_15', 'Your comments will help FS respond more quickly.');
define('FS_CHECKOUT_FOOTER_NEW_16', 'Please enter more than 10 characters.');
define('FS_CHECKOUT_FOOTER_NEW_17', 'Submit');
define('FS_CHECKOUT_FOOTER_NEW_18', 'Thanks for your feedback.');
define('FS_CHECKOUT_FOOTER_NEW_19', 'We will review your input and use it to improve FS website for your future visits.');
define('FS_CHECKOUT_SUCCESS_EMAIL_01', 'You have received a new feedback');
define('FS_CHECKOUT_SUCCESS_EMAIL_02', 'The customer submitted the below information at the page of successful payment, please kindly follow up if necessary.');
define('FS_CHECKOUT_SUCCESS_EMAIL_03', 'Customer Name:');
define('FS_CHECKOUT_SUCCESS_EMAIL_04', 'Customer E-mail:');
define('FS_CHECKOUT_SUCCESS_EMAIL_05', 'Order Number:');
define('FS_CHECKOUT_SUCCESS_EMAIL_06', 'Topic of Feedback:');
define('FS_CHECKOUT_SUCCESS_EMAIL_07', 'Additional Contents:');
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'Topic of the Feedback');

define('FS_PRINT',"To protect customer's privacy, please enter the FS account of user who placed this order to check the order details:");
define('FS_PRINT_1',"Confirm");
define('FS_PRINT_2',"The email you entered does not match the order information. Please verify and enter again.");
define('FS_PRINT_3',"Please enter the email address.");

define('FS_OFFLINE_ORDERS','Offline Orders');
define('FS_OFFLINE_COMBINED_SHIPMENT','Combined Shipment');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','To reduce the amount of deliveries and help protect environment, FS has arranged to ship your orders below together. Click order # to check details of respective order.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','If the delivery status hasn\'t been updated, please consult your account manager. You\'ll see this order in "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" when it\'s shipped out.');



define('FS_OFFINE_TRANSACTION','Offline Transaction');
define('FS_OFFINE_TRANSACTION_2','See Tracking info below under the delivery');
define('FS_OFFINE_TRANSACTION_4','Your order is being processing.');
define('FS_OFFINE_TRACK_INFO_1','If the order status hasn\'t been updated, please consult your account manager. You\'ll see this order in "<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">Order History</a>" when it\'s shipped out.');

//评论改版
define('FS_REVIEW_07','Equipment Mode');
define('FS_REVIEW_08','Adding model name of your equipment helps other shoppers.');
define('FS_REVIEW_09','Allow files of type of JPG, PNG.  Maximum file size: 5MB');
//define('FS_REVIEW_10','Allowd file types: PDF, JPG, PNG');
define('FS_REVIEW_11','Optional');

define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Compatibility');

//线下订单列表
define('FS_OFFLINE_01','Download Invioce');
define('FS_OFFLINE_02','Order Placed on: ');
define('FS_OFFLINE_03','Order #: ');
define('FS_OFFLINE_04','Items Subtotal: ');
define('FS_OFFLINE_05','Shipping Cost: ');
define('FS_OFFLINE_06','GST: ');
define('FS_OFFLINE_07','Insurance: ');
define('FS_OFFLINE_08','TOTAL: ');
define('FS_OFFLINE_09','Your order has been shipped according to the selected method during checkout. You may view the tracking status by clicking the Tracking Number below or in the notification e-mail. However, some shipping carriers do not always update tracking information immediately, the status of your shipment may be deferred.');
define('FS_OFFLINE_10','The delivery has been replaced by a new order');
define('FS_OFFLINE_11','Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power ');
define('FS_OFFLINE_12','Confirm Receipt');
define('FS_OFFLINE_13','This delivery has been canceled, please contact your account manager if you have any questions.');
define('FS_OFFLINE_14','View ');
define('FS_OFFLINE_15',' more deliveries');
define('FS_OFFLINE_16',' in this order.');
define('FS_OFFLINE_17','Processing');
define('FS_OFFLINE_18','ok');
define('FS_OFFLINE_19','Order # ');
define('FS_OFFLINE_20','(current order)');
define('FS_OFFLINE_21','NO ORDERS FOUND.');
define('FS_OFFLINE_22','If you can\'t locate your order, try selecting different filter conditions or check the order #.<br/>Offline orders can only be searched after shipment. You may consult your account manager before that.');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','Offline Orders');
define('FS_OFFLINE_COMBINED_SHIPMENT','Combined Shipment');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','To reduce the amount of deliveries and help protect environment, FS has arranged to ship your orders below together. Click order # to check details of respective order.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','If the order status hasn\'t been updated, please consult your account manager. You\'ll see this order in "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" when it\'s shipped out.');
define('FS_OFFINE_TRANSACTION_1','This delivery has been canceled, please contact your account manager if you have any questions.');
define('FS_OFFLINE_POPUP','There are other orders combined into this shipment.');
define('FS_OFFINE_TRANSACTION','Offline Transaction');
define('FS_OFFINE_TRANSACTION_2','See Tracking info below under the delivery');
define('FS_OFFINE_TRANSACTION_4','Your order is being processed.');
//my credit orders 页面
define('FS_VIEW_CONTENT','This order is divided into several deliveries, you may view all invoices in order details as the invoices are seperated for each delievery. Click to ');
define('FS_VIEW_LINK','view all invoices.');
define('FS_MY_CREDIT_01','Show:');
define('FS_MY_CREDIT_02','Online Orders');
define('FS_MY_CREDIT_03','Offline Orders');
define('FS_MY_CREDIT_04','Go');
define('FS_OFFINE_TRACK_INFO_1','If the order status hasn\'t been updated, please consult your account manager. You\'ll see this order in "<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">Order History</a>" when it\'s shipped out.');


//liang.zhu 2020.08.03
define('FS_CLEARANCE_TIP_01_01', 'This promotional product is limited to $QTY pc(s) and will be removed once sold out.');
define('FS_CLEARANCE_TIP_01_02', 'For more quantities, we recommend getting the alternative product "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_02_01', 'This promotional product is out of stock and will be removed soon.');
define('FS_CLEARANCE_TIP_02_02', 'For more quantities, we recommend getting the alternative product "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_03_01', 'This promotional product is limited to $QTY pc(s) and will be removed once sold out.');
define('FS_CLEARANCE_TIP_03_02', 'For more quantities, please contact your account manager.');
define('FS_CLEARANCE_TIP_04_01', 'This promotional product is out of stock and will be removed soon.');
define('FS_CLEARANCE_TIP_04_02', 'For more quantities, please contact your account manager.');
define('CHECKOUT_COMPANY_TYPE', 'The address type is error');

## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "Delivery Instructions (Optional)");
define("FS_DELIVERY_TICKET_NUMBER", "Ticket number, security code, etc.");
define("FS_DELIVERY_OTHER_INFO", "Delivery time, or other delivery instructions");
define("FS_DELIVERY_PROMPT", "Your instructions will help us deliver your package.");
define('FS_DELIVERY_INSTRUCTIONS', 'Delivery Instructions');

//PO
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', ' is confirmed. Please upload purchase order (PO) file within 7 business days. Otherwise, the order will be cancelled automatically due to the inventory change of items.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', 'Upload Purchase Order (PO) File');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', 'What is a PO file?');
define('FS_PO_FILE','PURCHASE ORDER');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','Purchase Order');
define('FS_PO_FILE_4','Date: 08/08/2020<br />PO #: PO0001');
define('FS_PO_FILE_5','Supplier');
define('FS_PO_FILE_6','Ship To');
define('FS_PO_FILE_7','Bill To');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','Accanount Mager: ');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','Email: ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','PHONE #: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','Attn: ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','PHONE #: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','Attn: ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','Payment Term');
define('FS_PO_FILE_27','Requested By');
define('FS_PO_FILE_28','Department');
define('FS_PO_FILE_29','Wire Transfer');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','Purchasing Dept');
define('FS_PO_FILE_32','FS RQC #: RQC2008010003');
define('FS_PO_FILE_33','<th>Item Description</th><th>Item ID</th><th>Qty</th><th>Unit Price</th><th>Total</th>');
define('FS_PO_FILE_36','SUBTOTAL:');
define('FS_PO_FILE_38','SHIPPING FEE:');
define('FS_PO_FILE_39','TAX/VAT:');
define('FS_PO_FILE_40','TOTAL:');
define('FS_PO_FILE_41',"What is a PO file?");
define('FS_PO_FILE_42',"The Purchase Order (PO) File is used as a voucher for purchase orders and generally includes the following content: ");
define('FS_PO_FILE_43',"Purchase order date and purchase order number;");
define('FS_PO_FILE_44',"Company information of the buyer and the supplier;");
define('FS_PO_FILE_45',"Shipping&Billing Address; Payment Term;");
define('FS_PO_FILE_46',"FS Item info and price.");
define('FS_PO_FILE_47',"See example of PO file");

define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');
//结算页
define('FS_CHECK_OUT_EXCLUDING1','Excluding Duties and Taxes');

//搜索V2版本
define('FS_SEARCH_NEW','Search result for ');
define('FS_SEARCH_NEW_1','Product');
define('FS_SEARCH_NEW_2','Document &amp; Resources');
define('FS_SEARCH_NEW_3','Solutions');
define('FS_SEARCH_NEW_4','Case Studies');
define('FS_SEARCH_NEW_5','Download');
define('FS_SEARCH_NEW_6','Clear All');
define('FS_SEARCH_NEW_7','Solutions');
define('FS_SEARCH_NEW_8','Case Studies');
define('FS_SEARCH_NEW_9','Name');
define('FS_SEARCH_NEW_10','Type');
define('FS_SEARCH_NEW_11','Date');
define('FS_SEARCH_NEW_12','File');
define('FS_SEARCH_NEW_13','News');
define('FS_SEARCH_NEW_14','is no longer available online, please view the similar product ');
define('FS_SEARCH_NEW_15',' as below.');
define('FS_SEARCH_NEW_16',' is no longer available online, please get a quote for help.');

define('FS_ACCOUNT_SEARCH_ALL_TIMES','All Time Frame');

define('FS_MY_SHOPPING_CART','My Shopping Cart');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','My Official Quote');
define('GET_A_QUOTE_TIP_1',"*For inquiry on lead time or shipping information, please help to fill out the below information and submit the quote, we will reply to you as soon as possible.");

define('FS_MY_SHOPPING_CART','My Shopping Cart');

define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Compatibility');

/**
 * quote 2020 07 改版
 */
define('FS_QUOTE_INQUIRY_01', 'Select file');
define('FS_QUOTE_INQUIRY_02', 'Upload Product List');
define('FS_QUOTE_INQUIRY_03', 'Please enter the product ID or upload the product list you need to request quote.');
define('FS_QUOTE_INQUIRY_04', 'Your quote request has been submitted successfully.');
define('FS_QUOTE_INQUIRY_05', 'Your account manager will process the quote within 12-24 hours and email you when the quote is ready.');
define("FS_QUOTE_EDIT_QUOTE", "Edit Quote");
define("FS_QUOTE_QUOTE_REQUEST", "QUOTE REQUEST");
define("FS_QUOTE_INQUIRY_06", "Email to Your Account Manager about This Quote");
define("FS_QUOTE_INQUIRY_07", "Your Quote ");
define("FS_QUOTE_INQUIRY_08", "is active, ");
define("FS_QUOTE_INQUIRY_09", "you can checkout directly.");
define("FS_QUOTE_INQUIRY_10", "If you need to modify this quote or have any questions about it, you can fill in the information below. An email will be sent to your account manager based on your message.");
define("FS_QUOTE_INQUIRY_11", "From:");
define("FS_QUOTE_INQUIRY_12", "Account manager will reply to this email.");
define("FS_QUOTE_INQUIRY_13", "To:");
define("FS_QUOTE_INQUIRY_14", "Content you want to talk about");
define("FS_QUOTE_INQUIRY_15", "If you would like to add or change items, it's better to write down the item ID (eg. #11552) and quantity desired.");
define("FS_QUOTE_INQUIRY_16", "Send an Email");
define("FS_QUOTE_INQUIRY_17", "Print Shopping Cart");
define("FS_QUOTE_INQUIRY_18", "Print as Quote");
define("FS_QUOTE_INQUIRY_19", "Need to modify this quote?");
define("FS_QUOTE_INQUIRY_20", "Your Item");
define("FS_QUOTE_INQUIRY_21", "UPLOAD PRODUCT LIST");
define("FS_QUOTE_INQUIRY_22", "Product List:");
define("FS_QUOTE_INQUIRY_23", "Status of quote request ");
define("FS_QUOTE_INQUIRY_24", " has been updated. Place check again.");
define("FS_QUOTE_INQUIRY_25", "Please upload the related files of PO.");
define("FS_QUOTE_INQUIRY_26", "COMMENTS (OPTIONAL)");
define("FS_QUOTE_INQUIRY_27", "Please enter the product ID or upload the product list you need to request quote.");
define("FS_QUOTE_INQUIRY_28", "Content");


//报价邮件
define("FS_INQUIRY_NEW_EMAIL"," sent you a modification request of #");
define("FS_INQUIRY_NEW_EMAIL_1"," Quote Modification");
define("FS_INQUIRY_NEW_EMAIL_2"," sent you a request to modify quotation");
define("FS_INQUIRY_NEW_EMAIL_3",", please check below details and re-quote asap.");
define("FS_INQUIRY_NEW_EMAIL_4","Case Number:");
define("FS_INQUIRY_NEW_EMAIL_5","Item(s)");
define("FS_INQUIRY_NEW_EMAIL_6","Qty");
define("FS_INQUIRY_NEW_EMAIL_7","Unit Price");
define("FS_INQUIRY_NEW_EMAIL_8","Quote Price");
define("FS_INQUIRY_NEW_EMAIL_9","Original Total:");
define("FS_INQUIRY_NEW_EMAIL_10","Quote Total:");
define("FS_INQUIRY_NEW_EMAIL_11","Please reply to ");
define("FS_INQUIRY_NEW_EMAIL_12"," or send the quote to this account.");
define("FS_INQUIRY_NEW_EMAIL_13","Your comment was submitted.");
define("FS_INQUIRY_NEW_EMAIL_14","Please allow 1-2 business days for the comment to become visible.");

//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_CHECKOUT_PAY_01','Pay');
define('FS_COMMON_DHL','DHL Economy Select®');

//详情页新文件标记
define('FS_NEW_FILE_TAG','New');


//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','Your modification to ');
define('FS_INQUIRY_EDIT_SUCCESS_2',' has been submitted successfully.');

define('FS_XING_HAO', '*');

define('FS_ALERT_01', "Thanks for your review");
define('FS_ALERT_02', "Stay Tuned to Share&amp;Earn Activity");
define('FS_ALERT_03', "Share Your Project with Photos and Stories");
define('FS_ALERT_04', "Get $20 Gift Card &amp; Win iPhone 12 Pro Max");
define('FS_ALERT_05', "Coming Soon: 2020.11-2021.2");
define('FS_ALERT_06', "Got it! ");
define('FS_ALERT_07', "No, thanks");
define('FS_ALERT_08', "Do not show me this again");

//下单邮件公司信息底部展示
// 深圳仓
define('FS_CHECKOUT_FS_NAME_CN', "FS.COM LIMITED");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_CN','
			Unit 1, Warehouse No. 7,  
			South China International Logistics Center, 
			Longhua District, 
			Shenzhen, 518109, China');
// 德国仓
define('FS_CHECKOUT_FS_NAME_EU', "FS.COM GmbH");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_EU','  
			NOVA Gewerbepark, Building 7, 
			Am Gfild 7, 
			85375, Neufahrn bei Munich, 
			Germany');
define('FS_CHECKOUT_EMAIL_TEL_EU', '+49 (0) 8165 80 90 517');
define('FS_CHECKOUT_EMAIL_EU', 'de@fs.com');

// 美东仓
define('FS_CHECKOUT_FS_NAME_US', "FS.COM INC");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			380 CENTERPOINT BLVD, 
			NEW CASTLE, DE 19720, 
			United States');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Tel: +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australia,
				ABN: 71 620 545 502');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Tel: +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapore,
				GST Reg No.: 201818919D');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Tel: (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');


define('FS_ORDERS_TRACKING_NINJA_STATUS1', 'Successfully picked up from sender - FS');
define('FS_ORDERS_TRACKING_NINJA_STATUS2', 'Parcel is being processed at Ninja Van warehouse - Ninja Van Sorting Facility');
define('FS_ORDERS_TRACKING_NINJA_STATUS3', 'Parcel is on its way');
define('FS_ORDERS_TRACKING_NINJA_STATUS4', 'Successfully delivered');

//账户中心确认收货弹窗
define('FS_ACCOUNT_HISTORY_INFO_THANK', "Thank you for shopping with us.");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "Your review is valuable to other customers, we'd love to hear from you. <br />Click the button below and leave your review!");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "Not Now");




//新增俄罗斯仓库
define("FS_WAREHOUSE_AREA_RU","ship from RU Warehouse");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', '%s Sold');
define('FS_PRODUCTS_SALES_REVIEW', '%s Review');
define('FS_PRODUCTS_SALES_REVIEWS', '%s Reviews');



//评论场景图上传优化  (订单评论上传，详情入口评论上传)
define('FS_REVIEW_NEW_15', 'Click the picture to add tags, you can also add');
define('FS_REVIEW_NEW_16', 'tags');
define('FS_REVIEW_NEW_17', 'save');
define('FS_REVIEW_NEW_18', 'Edit Tag');
define('FS_REVIEW_NEW_19', 'Recently Purchased');
define('FS_REVIEW_NEW_20', 'No Order Found.');
define('FS_REVIEW_NEW_21', 'Confirm');
define('FS_REVIEW_NEW_22', 'Click to enter Product ID/Product Title');
define('FS_REVIEW_NEW_23', 'Please enter Product ID/Product Title.');
define('FS_REVIEW_NEW_24', 'Tag Products');
define('FS_REVIEW_NEW_25', 'View All Customer Gallery');
define('FS_REVIEW_NEW_26', 'tag');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', 'Item Spotlights');
define('FS_PRODUCT_COMMUNITY_01', 'Community');
define('FS_PRODUCT_COMMUNITY_02', 'Ideas');
define('FS_PRODUCT_COMMUNITY_03', 'Unboxing the S5860-20SQ Switch | FS');
define('FS_PRODUCT_COMMUNITY_04', 'Ixia RFC2544 Test for S5860-20SQ Switch | FS');
define('FS_PRODUCT_COMMUNITY_05', 'S5860-20SQ: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_06', 'How to Connect FS Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_07', 'Unboxing the S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_08', 'Ixia RFC2544 Test for S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_09', 'S3910-24TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_10', 'Unboxing the S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_11', 'Unboxing the S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_12', 'Ixia RFC2544 Test for S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_13', 'S3910-48TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_14', 'First Look at S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_15', 'S5860-24XB-U Multi-Gig L3 Switch Ixia RFC2544 Test | FS');
define('FS_PRODUCT_COMMUNITY_16', 'Uninterruptible Power Supply Test on S5860-24XB-U | FS');
define('FS_PRODUCT_COMMUNITY_17', 'How to Connect FS Multi-Gig L3 Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_18', 'Unboxing L2+ PoE+ Switch S3410-24TS-P | FS');
define('FS_PRODUCT_COMMUNITY_19', 'Take You to Know S3410-24TS-P in Short | FS');
define('FS_PRODUCT_COMMUNITY_20', 'How to Check Power Status of PoE Port via Web | FS');
define('FS_PRODUCT_COMMUNITY_21', 'IXIA RFC2544 Test on S3410-24TS-P PoE Switch | FS');
define('FS_PRODUCT_COMMUNITY_22', 'How to Replace Power Supplies and Fans | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', 'Product Highlights');


//报价PDF语言包
define('FS_QUOTES_PDF_01', 'OFFICIAL QUOTE');
define('FS_QUOTES_PDF_01_TAX', 'OFFICIAL QUOTE');
define('FS_QUOTES_PDF_02', 'RQ number');
define('FS_QUOTES_PDF_03', 'Created By');
define('FS_QUOTES_PDF_04', '1. The quotation is only valid for 15days, please contact your account manager to re-inquire after expiration.');
define('FS_QUOTES_PDF_05', '2. Please kindly leave a message of this order RQ No. or your company name when you pay this quote.');
define('FS_QUOTES_PDF_TOTAL_TAX', 'Total');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "We’ve received your quote request ");
define('EMAIL_QUOTES_SUCCESS_02', ' and will email you with quotation details within one business day.');
define('EMAIL_QUOTES_SUCCESS_03', 'Your Message');
define('EMAIL_QUOTES_SUCCESS_04', 'Request quote, please give me your best offer.');
define('EMAIL_QUOTES_SUCCESS_05', 'View in My Account');
define('EMAIL_QUOTES_SUCCESS_06', 'Download PDF');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'You can view and convert this quote to an order in “Account / Quote” .');
define('EMAIL_QUOTES_SHARE_02', 'If you have questions with configuration, pricing and contract verification, ');
define('EMAIL_QUOTES_SHARE_03', 'please contact your account manager.');
define('EMAIL_QUOTES_SHARE_04', 'Quote Update');
define('EMAIL_QUOTES_SHARE_05', 'You have received a new quote from FS.COM.');
//报价列表
define('QUOTES_LIST_BRED_CRUMBS','Quote History');
define('QUOTES_LIST_TIME_TYPE_1', 'All Time Frames');
define('QUOTES_LIST_TIME_TYPE_2', 'Latest Month');
define('QUOTES_LIST_TIME_TYPE_3', 'Latest 3 Months');
define('QUOTES_LIST_TIME_TYPE_4', 'Latest Year');
define('QUOTES_LIST_TIME_TYPE_5', 'One Year Ago');
define('QUOTES_LIST_STATUS_TYPE_1', 'Online Quotes');
define('QUOTES_LIST_STATUS_TYPE_2', 'Active');
define('QUOTES_LIST_STATUS_TYPE_3', 'Purchased');
define('QUOTES_LIST_STATUS_TYPE_4', 'Expired');
define('QUOTES_LIST_STATUS_TYPE_5', 'Offline Quotes');
define('QUOTES_LIST_STATUS_TYPE_6', 'All Status');
define('QUOTES_LIST_RESULT_SINGULAR', 'Result');
define('QUOTES_LIST_RESULT_PLURAL', 'Results');
define('QUOTES_LIST_UPDATE_TIME', 'Price Updated on $TIME');
define('QUOTES_LIST_EXPIRE_TIME', 'Expired on $TIME');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', 'Expire on $TIME');
define('QUOTES_LIST_QUOTE_AGAIN', 'Quote Again');
define('QUOTES_LIST_VIEW_ORDERS', 'View Order History');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', 'Quote #, item #');
//报价详情
define('FS_QUOTES_DETAILS_01', 'Inventory, Delivery Date, Estimated Tax and Shipping Cost are subject to change and will be recalculated at checkout.');
define('FS_QUOTES_DETAILS_02', 'Checkout');
define('FS_QUOTES_DETAILS_03', 'Below is your quote detail. This quote is valid until $TIME.');
define('FS_QUOTES_DETAILS_04', 'Quotation Request #:');
define('FS_QUOTES_DETAILS_05', 'Download Quote');
define('FS_QUOTES_DETAILS_06', 'Quote Created Date:');
define('FS_QUOTES_DETAILS_07', 'Quote Date:');
define('FS_QUOTES_DETAILS_08', 'Customer ID:');
define('FS_QUOTES_DETAILS_09', 'No.  #');
define('FS_QUOTES_DETAILS_10', 'Customer Manager:');
define('FS_QUOTES_DETAILS_11', 'Phone #:');
define('FS_QUOTES_DETAILS_12', 'Ship To');
define('FS_QUOTES_DETAILS_13', 'Shipping Method: ');
define('FS_QUOTES_DETAILS_14', 'Bill To');
define('FS_QUOTES_DETAILS_15', 'Payment Method:');
define('FS_QUOTES_DETAILS_16', 'See All');
define('FS_QUOTES_DETAILS_17', 'Reference');
define('FS_QUOTES_DETAILS_18', 'Sorry, the item has been removed and is no longer available for purchase.');
define('FS_QUOTES_DETAILS_19', 'Length: ');
define('FS_QUOTES_DETAILS_20', 'More');
define('FS_QUOTES_DETAILS_21', 'This item includes the following products');
define('FS_QUOTES_DETAILS_22', 'Vat/Tax:');
define('FS_QUOTES_DETAILS_23', 'This quote has expired on $TIME. You can quote it again if need.');
define('FS_QUOTES_DETAILS_24', 'The quote has been generated to order successfully.');

define('FS_SHOPPING_CART_CREATE_QUOTE', 'Create Quote');
define('FS_QUOTES_ORDERS_NUMBER', 'Order');
define('QUOTES_LIST_EMPTY_TIPS', 'No Quotes Found.');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - We received your quote request $NUM');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS - Your friend $EMAIL shared you a quote');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', 'Shipping Cost and Tax will be calculated at checkout.');


//
define('FS_RECENT_SEARCH', 'Recent Search');
define('FS_HOT_SEARCH', 'Hot Search');
define('FS_CHANGE', 'Change');

define('FS_VIEW_WORD', 'View');

//一级分类页
define('FS_CATEGORIES_POPULAR', 'Popular Categories');
define('FS_CATEGORIES_BEST_SELLERS', 'Best Sellers');
define('FS_CATEGORIES_NETWORK', 'Network Assemblies');
define('FS_CATEGORIES_DISCOVERY', 'Discovery');


define('CARD_NOT_SUPPORT', 'This payment method is not currently supported. Please enter a different method.');
//全站FS Support 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','FS Support');

define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '<span class="new_proList_proListNtit">Showing search result for</span> "###RECOMMEND_WORD###" <span class="new_proList_proListNtit">as no result for</span> "###SEARCH_WORD###"<span class="new_proList_proListNtit">.</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', 'Did you search for <a href="###HREF_LINK###" target="_blank">###RECOMMEND_WORD###</a>');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', 'The upgraded new product is recommended as below for your reference.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', 'The similar product is recommended as below for your reference.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', 'The customized product is recommended as below for your reference.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', ' Can\'t find what you need? Please contact us for help.');
define('SEARCH_OFFLINE_PRODUCT_TIP', '"KEYWORD" is no longer available online, but still supported by FS. For more details, please refer to the <a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">End of Sale Policy</a>.');
define('HISTORY_TIPS', 'You can select offline quotes created by your account manager here.');
define('TIPS_BUTTON', 'I got it!');

define('FS_CHECKOUT_EPIDEMIC_TIPS', 'Delivery may be subject to delays or restrictions due to official administrative measures.
Please ensure there is someone accepting the delivery, otherwise parcel would be returned to shipper.');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', 'Order may be delayed due to customs clearance reasons.');

//quote成功发送邮件新增
define('QUOTES_NOTE_TITLE','Note:');
define('QUOTES_NOTE_TIPS','Inventory, Delivery Date, Estimated Tax and Shipping Cost are subject to change and will be recalculated at checkout.');
define('QUOTES_RQN_NUMBER_TITLE','RQN Number:');
define('QUOTES_TRADE_TERM_TITLE','Trade Term:');
define('QUOTES_PAYMENT_TERM_TITLE','Payment Term:');
define('QUOTES_SHIP_VIA_TITLE','Ship Via:');
define('QUOTES_DATE_ISSUED_TITLE','Date Issued:');
define('QUOTES_EXPIRES_TITLE','Expires:');
define('QUOTES_ACCOUNT_MANAGER_TITLE','Account Manager:');
define('QUOTES_ACCOUNT_EMAIL_TITLE','Email:');
define('QUOTES_DELIVER_TO','Deliver To');
define('QUOTES_BILLING_TO','Billing To');
define('QUOTES_QUOTE_TITLE1','Item(s)');
define('QUOTES_QUOTE_TITLE2','Qty');
define('QUOTES_QUOTE_TITLE3','Unit Price');
define('QUOTES_QUOTE_TITLE4','Quote Price');


define('FS_WHAT_IS_DIFFERENCE', "What's the Difference");
define('FS_AVAILABILITY', 'Availability');
define('FS_ON_SALE', 'On Sale');
define('FS_END_SALE', 'End of Sale');
define('FS_DIFFERENCES', 'Please check the detailed parameters carefully to fully understand the differences of the products before making a purchase.');

define('FS_CN_LIMIT_TIPS', 'The item cannot be delivered to China, please note it.');
define('QUOTE_MESSAGE_TXT_1', 'Additional Comments (from "'. $_SESSION['customer_first_name'].'")');
define('QUOTE_MESSAGE_TXT_2', 'Additional Comments (from Account Manager | FS)');
