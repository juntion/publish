<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: meta_tags.php 10330 2008-10-10 20:14:32Z drbyte $
 */

// page title
define('TITLE', 'FS.COM');

// Site Tagline
define('SITE_TAGLINE', '');

// Custom Keywords
define('CUSTOM_KEYWORDS', 'Transceivers,Patch Cables, Adapters,Attenuators,FiberStore, online shopping');

// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'FiberStore-shop for optical transceiver ,Mux / Demux , Fiber Media Converter, Video multiplexer, fiber optic patch cord ,fiber patch panel , fiber optic cable connectors and other fiber optic network accessories');
  define('HOME_PAGE_META_KEYWORDS', 'fiber optic communication, fiber optic network, fiber optic products');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', 'FiberStore - Fiber Network Solution, All in FiberStore! '); // usually best left blank


// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it.
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_EZPAGE_#','');
  define('META_TAG_KEYWORDS_EZPAGE_#','');
  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_page_name','');
  define('META_TAG_KEYWORDS_page_name','');
  define('META_TAG_TITLE_page_name', '');

// Review Page can have a lead in:
  define('META_TAGS_REVIEW', 'Reviews: ');

// separators for meta tag definitions
// Define Primary Section Output
  define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ', ');

// Define divider ... usually just a space or a comma plus a space
  define('METATAGS_DIVIDER', ' ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
  define('ROBOTS_PAGES_TO_SKIP','login,logoff,create_account,account,account_edit,account_history,account_history_info,account_newsletters,account_notifications,account_password,address_book,advanced_search,advanced_search_result,checkout_success,checkout_process,checkout_shipping,checkout_payment,checkout_confirmation,cookie_usage,create_account_success,contact_us,download,download_timeout,customers_authorization,down_for_maintenance,password_forgotten,time_out,unsubscribe,info_shopping_cart,popup_image,popup_image_additional,product_reviews_write,ssl_check');


// favicon setting
// There is usually NO need to enable this unless you need to specify a path and/or a different filename
//  define('FAVICON','favicon.ico');
define('META_WDM01','WDM Intergrated Optical Transport Platform');
define('META_WDM02','FS WDM Transport Platform enable enterprises, ISP and service providers to cost-effectively build out or upgrade the speed and capacity of optical networks.');
define('META_WDM03','Long-haul Transmission, Network Management System, Optical Transport Network');

//dylan 2019.8.5 Add
define('METE_TAGS_CAT_BUY','Buy ');
define('METE_TAGS_CAT_BEST_PRICE',' w/ best price online, select ');
define('META_TAGS_CATEGORIES_DESCRIPTION',' at FS.com.');

/*narrow*/
define('METE_TAGS_NARROW_FS',', Search FS.COM');
define('METE_TAGS_NARROW_ONLINE_GLOBAL',' Online From Global ');
define('METE_TAGS_NARROW_OEM_MANUFACTURER',' OEM Manufacturer with Wholesale Price at FS.COM');
define('METE_TAGS_NARROW_OEM',' Buy and customize fiber optical products from FS.COM!');

/*support*/
define('METE_TAGS_SUPPORT_OF_FS','Support Of FS.COM');

define('METE_TAGS_POPULAR','Popular - FS.COM');
define('METE_TAGS_PRODUCTS_LIST','Products list ');
define('METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST',' Fiber optic products list ');
define('META_TAGS_FIBERSTORE',' - FS.COM');
define('META_TAGS_THE_LEADING','The leading fiber optical  products OEM manufactuer.In this page you could easily find out all Fiberstore products that includes the word initiated by the letter ');
define('META_TAGS_CUSTOMER_SERVICE','Customer service');
define('META_TAGS_TUTORIAL_OF_COM','Tutorial Of FS.COM');
define('META_TAGS_NEWS_OF_COM','News Of FS.COM');

define('META_TAGS_COMMON_TITLE','Data Center, Enterprise, Telecom');
define('META_TAGS_COMMON_DESCRIPTION','FS is a new brand in Data Center, Enterprise, Telecom network solutions. We make it easy and cost-effective for IT professionals to enable their business solutions.');

//solutions页面meta相关
define('FS_SOLUTION_META_TITLE_O1','FS OTN Solution for 10G DWDM Dual Fiber Network');
define('FS_SOLUTION_META_DESCRIPTION_O1','FS provides cost effective easy-to-manage integrated 10G DWDM solution for Data Center Interconnection (DCI) and enterprise applications.');
define('FS_SOLUTION_META_TITLE_O2','FS OTN Solution for 10G DWDM Single Fiber Network');
define('FS_SOLUTION_META_DESCRIPTION_O2','FS provides cost effective easy-to-manage integrated 10G DWDM solution for Data Center Interconnection (DCI) and enterprise applications.');
define('FS_SOLUTION_META_TITLE_O3','FS OTN Solution for 25G DWDM Dual Fiber Network');
define('FS_SOLUTION_META_DESCRIPTION_O3','FS provides 25G DWDM solution of easy scalability and intelligent management for 25G Ethernet, 5G fronthaul and data center interconnection.');
define('FS_SOLUTION_META_TITLE_O4','FS OTN Solution for 25G DWDM Single Fiber Network');
define('FS_SOLUTION_META_DESCRIPTION_O4','FS provides 25G DWDM solution of easy scalability and intelligent management for 25G Ethernet, 5G fronthaul and data center interconnection.');
define('FS_SOLUTION_META_TITLE_O5','FS OTN Solution for 10G CWDM Dual Fiber Network');
define('FS_SOLUTION_META_DESCRIPTION_O5','FS provides cost effective, large capacity 10G CDWM solution for short-distance metropolitan transmission networks.');
define('FS_SOLUTION_META_TITLE_O6','FS OTN Solution for 10G CWDM Single Fiber Network');
define('FS_SOLUTION_META_DESCRIPTION_O6','FS provides cost effective, high flexibility 10G CDWM solution for short-distance metropolitan transmission networks.');