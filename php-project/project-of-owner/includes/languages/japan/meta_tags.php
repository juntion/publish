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
define('METE_TAGS_CAT_BUY','');
define('METE_TAGS_CAT_BEST_PRICE','をオンラインで購入し、FS.comで最適な');
define('META_TAGS_CATEGORIES_DESCRIPTION',' を選択してください。');

/*narrow*/
define('METE_TAGS_NARROW_FS',', FS.comを検索');
define('METE_TAGS_NARROW_ONLINE_GLOBAL',' グローバルからオンライン ');
define('METE_TAGS_NARROW_OEM_MANUFACTURER',' FS.comで卸売価格のOEMメーカー');
define('METE_TAGS_NARROW_OEM',' OEMメーカー。FS.comから光ファイバ製品を購入してカスタマイズしてください！');

/*support*/
define('METE_TAGS_SUPPORT_OF_FS','FS.comのサポート');

define('METE_TAGS_POPULAR','人気-FS.com');
define('METE_TAGS_PRODUCTS_LIST','製品リスト ');
define('METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST',' 光ファイバ製品一覧 ');
define('META_TAGS_FIBERSTORE',' -FS.com');
define('META_TAGS_THE_LEADING','主要な光ファイバ製品のOEMメーカー。このページでは、文字で始まる単語を含むすべてのFS.com製品を簡単に見つけることができます。 ');
define('META_TAGS_CUSTOMER_SERVICE','顧客サービス');
define('META_TAGS_TUTORIAL_OF_COM','FS.COMのチュートリアル');
define('META_TAGS_NEWS_OF_COM','FS.COMのニュース');

define('META_TAGS_COMMON_TITLE','データセンター、エンタープライズ、テレコム');
define('META_TAGS_COMMON_DESCRIPTION','FSは、データセンター、エンタープライズ、インターネットアクセスソリューションの新しいブランドです。ITプロフェッショナルがビジネスソリューションを実現するのを簡単かつ費用対効果の高いものにします。');

//solutions页面meta相关
define('FS_SOLUTION_META_TITLE_O1','10G DWDMデュアルファイバネットワーク向けFS OTNソリューション');
define('FS_SOLUTION_META_DESCRIPTION_O1','FSは、データセンター相互接続（DCI）およびエンタープライズアプリケーション向けに、費用対効果の高く、管理しやすい統合10G DWDMソリューションを提供しております。');
define('FS_SOLUTION_META_TITLE_O2','10G DWDMシングルファイバネットワーク向けFS OTNソリューション');
define('FS_SOLUTION_META_DESCRIPTION_O2','FSは、データセンター相互接続（DCI）およびエンタープライズアプリケーション向けに、費用対効果の高く、管理しやすい統合10G DWDMソリューションを提供しております。');
define('FS_SOLUTION_META_TITLE_O3','25G DWDMデュアルファイバネットワーク向けFS OTNソリューション');
define('FS_SOLUTION_META_DESCRIPTION_O3','FSは、25Gイーサネット、5Gフロントホール、およびデータセンター相互接続のための容易なスケーラビリティとインテリジェントな管理の25G DWDMソリューションを提供しております。');
define('FS_SOLUTION_META_TITLE_O4','25G DWDMシングルファイバネットワーク向けFS OTNソリューション');
define('FS_SOLUTION_META_DESCRIPTION_O4','FSは、25Gイーサネット、5Gフロントホール、およびデータセンター相互接続のための容易なスケーラビリティとインテリジェントな管理の25G DWDMソリューションを提供しております。');
define('FS_SOLUTION_META_TITLE_O5','10G CWDMデュアルファイバネットワーク向けFS OTNソリューション');
define('FS_SOLUTION_META_DESCRIPTION_O5','FSは、短距離メトロポリタン伝送ネットワークに費用対効果の高い大容量10G CDWMソリューションを提供しております。');
define('FS_SOLUTION_META_TITLE_O6','10G CWDMシングルファイバネットワーク向けFS OTNソリューション');
define('FS_SOLUTION_META_DESCRIPTION_O6','FSは、短距離メトロポリタン伝送ネットワークに費用対効果の高く、柔軟性の高い10G CDWMソリューションを提供しております。');
