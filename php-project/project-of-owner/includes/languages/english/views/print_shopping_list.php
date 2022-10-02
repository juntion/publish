<?php
define('NAVBAR_TITLE','SHOPPING CART');
define('FS_CART_YOUR_ITEM','Your item');
define('FS_CART_PRICE','Unit Price');
define('FS_CART_QTY','Qty');
define('FS_CART_WEIGHT','Weight');
define('FS_CART_TOTAL','Total');
define('FS_CART_MOQ','The MOQ(Minimum order Quantity) of this cable is 1 km. Please increase the total length then check out again. Any question, contact us at Sales@fs.com.');
define('FS_CART_SHIPPING_HTML1','Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the same day.<br/>
                                 There may be some difference between the estimated time and the actual time.');
define('FS_CART_SHIPPING_HTML2','Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.<br/>
                                 There may be some difference between the estimated time and the actual time.');
define('FS_CART_SHIPPING_HTML','There may be some difference between the estimated time and the actual time.');
if(US_WAREHOUSE_UP){
    define('FS_PRINT_AVE','380 Centerpoint Blvd, New Castle, DE 19720');
    define('FS_PRINT_AVE_QUOTE','380 Centerpoint Blvd, New Castle <br > DE 19720');
}else{
    define('FS_PRINT_AVE','820 SW 34th Street Bldg W7 Suite H, Renton, WA 98057');
    define('FS_PRINT_AVE_QUOTE','820 SW 34th Street Bldg W7 Suite H, Renton <br > WA 98057');
}

define('FS_PRINT_US','United States');
define('FS_PRINT_SALE','sales@fs.com');
define('FS_PRINT_CART','Cart Total');
define('FS_PRINT_DOCUMENT','Print Document');
define('FS_PRINT_NEED','Need help with your purchase?');
define('FS_PRINT_WE','We\'re always available to help with questions, including product selection, sizing, installation and product customization.');
define('FS_CART_ESTIMATED','Estimated Shipping Cost');
define('FS_CART_AMOUNT','Total:');
define('FS_CART_CART_TOTAL','Subtotal');

define('FS_PRINT_EU','Building 7, NOVA Neufahrn Gewerbepark, Am');
define('FS_PRINT_EUS','Gfild 7, 85375, Neufahrn bei Freising, Munich');
define('FS_PRINT_EU_1','Tel: +49 (0) 89 414176412');
define('FS_PRINT_EU_2','sales@fs.com');

define('FS_PRINT_SG','30A Kallang Pl, #11-10/11/12');
define('FS_PRINT_SGS','Singapore 339213');
define('FS_PRINT_CALL_US','<p>We\'re always available to help with questions, including product selection, sizing, installation and product customization.<br> Call us at <a href="tel:PHONE">PHONE</a> or email us<a href="mailto:EMAIL"> EMAIL</a>.</p>');
define('FS_PRINT_GST','GST Reg No.: 201818919D');

//新定义语言包
define('FS_PRINT_INSTRUCTIONS','Instructions:');
define('FS_PRINT_INSTRUCTIONS_01','1. Shipping cost is not included in the above subtotal.');
define('FS_PRINT_INSTRUCTIONS_02','2. The inventory and lead time are subject to change. You can always check the latest update online.');
define('FS_PRINT_INSTRUCTIONS_03','3. If you have any inquiries about customized request, technical support, or placing order, please contact your account manager or FS customer service team.');
define('FS_PRINT_INSTRUCTIONS_FROM_QUOTE','3. Please note this is not an official quote. ');

define("FS_CART_INQUIRY_PRINT_00", "OFFICIAL QUOTE");
define("FS_CART_INQUIRY_PRINT_01", "Date Issued: ");
define("FS_CART_INQUIRY_PRINT_02", "Created by: ");
define("FS_CART_INQUIRY_PRINT_03", "1. Shipping cost & tax are not included in the above subtotal.");
define("FS_CART_INQUIRY_PRINT_04", "2. The inventory and lead time are subject to change. You can always check the latest update online.");
?>