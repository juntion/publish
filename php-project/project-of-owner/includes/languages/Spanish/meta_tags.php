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

//dylan 2019.8.5 Add
define('METE_TAGS_CAT_BUY','Compra ');
define('METE_TAGS_CAT_BEST_PRICE',' online, selecciona mejor ');
define('META_TAGS_CATEGORIES_DESCRIPTION',' en FS.com.');

/*narrow*/
define('METE_TAGS_NARROW_FS',', Busca FS.com');
define('METE_TAGS_NARROW_ONLINE_GLOBAL',' Tienda online global ');
define('METE_TAGS_NARROW_OEM_MANUFACTURER',' Mejor precio en FS.com');
define('METE_TAGS_NARROW_OEM',' Compra y personaliza productoc de fibra óptica en FS.com');

/*support*/
define('METE_TAGS_SUPPORT_OF_FS','Centro de asistencia');

define('METE_TAGS_POPULAR','Popular -FS.com');
define('METE_TAGS_PRODUCTS_LIST','Lista de productos ');
define('METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST',' Lista de fibra óptica ');
define('META_TAGS_FIBERSTORE',' -FS.com');
define('META_TAGS_THE_LEADING','Proveedor líder de productos de fibra óptica. Aquí, puedes encontrar fácilmente productos lo que quiera ');
define('META_TAGS_CUSTOMER_SERVICE','Servicio personalizado');
define('META_TAGS_TUTORIAL_OF_COM','Tutorial');
define('META_TAGS_NEWS_OF_COM','Noticias de FS');

define('META_TAGS_COMMON_TITLE','Centro de datos, red empresarial y teleconmunicación');
define('META_TAGS_COMMON_DESCRIPTION','FS ofrece soluciones para centro de datos, red empresarial y teleconmunicación. Servicio de TI hace posible la interconexion rápida y rentable.');

//solutions页面meta相关
define('FS_SOLUTION_META_TITLE_O1','FS solución OTN para red de fibra dual 10G DWDM');
define('FS_SOLUTION_META_DESCRIPTION_O1','FS proporciona una solución integral de 10G DWDM rentable y fácil de gestionar para la interconexión en centro de datos (DCI) y las aplicaciones empresariales.');
define('FS_SOLUTION_META_TITLE_O2','FS solución OTN para red de una sola fibra 10G DWDM');
define('FS_SOLUTION_META_DESCRIPTION_O2','FS proporciona una solución integral de 10G DWDM rentable y fácil de gestionar para la interconexión en centro de datos (DCI) y las aplicaciones empresariales.');
define('FS_SOLUTION_META_TITLE_O3','FS solución OTN para red de fibra dual 25G DWDM');
define('FS_SOLUTION_META_DESCRIPTION_O3','FS proporciona una solución de 25G DWDM con escalabilidad y gestión inteligente para 25G Ethernet, 5G fronthaul e interconexión en centro de datos.');
define('FS_SOLUTION_META_TITLE_O4','FS solución OTN para red de una sola fibra 25G DWDM');
define('FS_SOLUTION_META_DESCRIPTION_O4','FS proporciona una solución de 25G DWDM con escalabilidad y gestión inteligente para 25G Ethernet, 5G fronthaul e interconexión en centro de datos.');
define('FS_SOLUTION_META_TITLE_O5','FS solución OTN para red de fibra dual 10G CWDM');
define('FS_SOLUTION_META_DESCRIPTION_O5','FS proporciona una solución rentable y de gran capacidad de 10G CWDM para las redes de transmisión metropolitanas de corta distancia.');
define('FS_SOLUTION_META_TITLE_O6','FS solución OTN para red de una sola fibra 10G CWDM');
define('FS_SOLUTION_META_DESCRIPTION_O6','FS proporciona una solución rentable y de gran capacidad de 10G CWDM para las redes de transmisión metropolitanas de corta distancia.');