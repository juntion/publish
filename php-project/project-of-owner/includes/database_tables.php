<?php
/**
 * database_tables.php
 * Defines the database table names used in the project
 *
 * @package initSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: database_tables.php 15508 2010-02-18 05:24:31Z drbyte $
 * @private
 */

if (!defined('DB_PREFIX')) define('DB_PREFIX', '');
define('TABLE_ADDRESS_BOOK', DB_PREFIX . 'address_book');
define('TABLE_ADMIN', DB_PREFIX . 'admin');
define('TABLE_ADMIN_ACTIVITY_LOG', DB_PREFIX . 'admin_activity_log');
define('TABLE_ADMIN_PROFILES', DB_PREFIX . 'admin_profiles');

define('TABLE_ADDRESS_FORMAT', DB_PREFIX . 'address_format');
define('TABLE_AUTHORIZENET', DB_PREFIX . 'authorizenet');
define('TABLE_BANNERS', DB_PREFIX . 'banners');
define('TABLE_BANNERS_HISTORY', DB_PREFIX . 'banners_history');
define('TABLE_CATEGORIES', DB_PREFIX . 'categories');
define('TABLE_CATEGORIES_DESCRIPTION', DB_PREFIX . 'categories_description');
define('TABLE_CONFIGURATION', DB_PREFIX . 'configuration');
define('TABLE_CONFIGURATION_GROUP', DB_PREFIX . 'configuration_group');
define('TABLE_COUNTER', DB_PREFIX . 'counter');
define('TABLE_COUNTER_HISTORY', DB_PREFIX . 'counter_history');
define('TABLE_COUNTRIES', DB_PREFIX . 'countries');
define('TABLE_COUPON_GV_QUEUE', DB_PREFIX . 'coupon_gv_queue');
define('TABLE_COUPON_GV_CUSTOMER', DB_PREFIX . 'coupon_gv_customer');
define('TABLE_COUPON_EMAIL_TRACK', DB_PREFIX . 'coupon_email_track');
define('TABLE_COUPON_REDEEM_TRACK', DB_PREFIX . 'coupon_redeem_track');
define('TABLE_COUPON_RESTRICT', DB_PREFIX . 'coupon_restrict');
define('TABLE_COUPONS', DB_PREFIX . 'coupons');
define('TABLE_COUPONS_DESCRIPTION', DB_PREFIX . 'coupons_description');
define('TABLE_CURRENCIES', DB_PREFIX . 'currencies');
define('TABLE_CUSTOMERS_INQUIRY', DB_PREFIX . 'customer_inquiry');
define('TABLE_CUSTOMERS', DB_PREFIX . 'customers');
define('TABLE_CUSTOMERS_BASKET', DB_PREFIX . 'customers_basket');
define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', DB_PREFIX . 'customers_basket_attributes');
define('TABLE_CUSTOMERS_INFO', DB_PREFIX . 'customers_info');
define('TABLE_DB_CACHE', DB_PREFIX . 'db_cache');
define('TABLE_EMAIL_ARCHIVE', DB_PREFIX . 'email_archive');
define('TABLE_EZPAGES', DB_PREFIX . 'ezpages');
define('TABLE_FEATURED', DB_PREFIX . 'featured');
define('TABLE_FILES_UPLOADED', DB_PREFIX . 'files_uploaded');
define('TABLE_GROUP_PRICING', DB_PREFIX . 'group_pricing');
define('TABLE_CUSTOMER_INQUIRY', DB_PREFIX . 'customer_inquiry');
define('TABLE_CUSTOMER_INQUIRY_PRODUCTS', DB_PREFIX . 'customer_inquiry_products');
define('TABLE_FRAUDULENT_ADDRESS_MANAGEMENT', DB_PREFIX . 'fraudulent_address_management');

//define('TABLE_GET_TERMS_TO_FILTER', DB_PREFIX . 'get_terms_to_filter');
define('TABLE_LANGUAGES', DB_PREFIX . 'languages');
define('TABLE_LAYOUT_BOXES', DB_PREFIX . 'layout_boxes');
define('TABLE_META_TAGS_PRODUCTS_DESCRIPTION', DB_PREFIX . 'meta_tags_products_description');
define('TABLE_METATAGS_CATEGORIES_DESCRIPTION', DB_PREFIX . 'meta_tags_categories_description');
define('TABLE_NEWSLETTERS', DB_PREFIX . 'newsletters');
define('TABLE_ORDERS_TRACKING_INFO', DB_PREFIX . 'order_tracking_info');
define('TABLE_ORDERS', DB_PREFIX . 'orders');
define('TABLE_ORDERS_SPLIT', DB_PREFIX . 'orders_split');
define('TABLE_ORDERS_PRODUCTS', DB_PREFIX . 'orders_products');
define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', DB_PREFIX . 'orders_products_attributes');
define('TABLE_ORDERS_STATUS', DB_PREFIX . 'orders_status');
define('TABLE_ORDERS_STATUS_HISTORY', DB_PREFIX . 'orders_status_history');
define('TABLE_ORDERS_TYPE', DB_PREFIX . 'orders_type');
define('TABLE_ORDERS_TOTAL', DB_PREFIX . 'orders_total');
define('TABLE_ORDERS_TOTAL_TAX', DB_PREFIX . 'orders_total_tax');
define('TABLE_PAYPAL', DB_PREFIX . 'paypal');
define('TABLE_PAYPAL_SESSION', DB_PREFIX . 'paypal_session');
define('TABLE_PAYPAL_PAYMENT_STATUS', DB_PREFIX . 'paypal_payment_status');
define('TABLE_PAYPAL_PAYMENT_STATUS_HISTORY', DB_PREFIX . 'paypal_payment_status_history');
define('TABLE_PRODUCTS', DB_PREFIX . 'products');
define('TABLE_PRODUCT_TYPES', DB_PREFIX . 'product_types');
define('TABLE_PRODUCT_TYPE_LAYOUT', DB_PREFIX . 'product_type_layout');
define('TABLE_PRODUCT_TYPES_TO_CATEGORY', DB_PREFIX . 'product_types_to_category');
define('TABLE_PRODUCTS_ATTRIBUTES', DB_PREFIX . 'products_attributes');
define('TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES', DB_PREFIX . 'customer_inquiry_products_attributes');

define('TABLE_PRODUCTS_OPTIONS', DB_PREFIX . 'products_options');
define('TABLE_PRODUCTS_OPTIONS_VALUES', DB_PREFIX . 'products_options_values');
define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', DB_PREFIX . 'products_options_values_to_products_options');
define('TABLE_PRODUCTS_OPTIONS_TYPES', DB_PREFIX . 'products_options_types');
define('TABLE_PRODUCTS_TO_CATEGORIES', DB_PREFIX . 'products_to_categories');
define('TABLE_PROJECT_VERSION', DB_PREFIX . 'project_version');
define('TABLE_PROJECT_VERSION_HISTORY', DB_PREFIX . 'project_version_history');
define('TABLE_REVIEWS', DB_PREFIX . 'reviews');
define('TABLE_REVIEWS_DESCRIPTION', DB_PREFIX . 'reviews_description');
define('TABLE_REVIEWS_COMMENTS', DB_PREFIX . 'reviews_comments');
define('TABLE_REVIEWS_COMMENTS_DESCRIPTION', DB_PREFIX . 'reviews_comments_description');


define('TABLE_SESSIONS', DB_PREFIX . 'sessions');
define('TABLE_TEMPLATE_SELECT', DB_PREFIX . 'template_select');
define('TABLE_GEO_ZONES', DB_PREFIX . 'geo_zones');
define('TABLE_ZONES_TO_GEO_ZONES', DB_PREFIX . 'zones_to_geo_zones');
define('TABLE_UPGRADE_EXCEPTIONS', DB_PREFIX . 'upgrade_exceptions');
define('TABLE_WISHLIST', DB_PREFIX . 'customers_wishlist');
define('TABLE_WHOS_ONLINE', DB_PREFIX . 'whos_online');
define('TABLE_ZONES', DB_PREFIX . 'zones');

define('TABLE_COMPLAINTS', DB_PREFIX . 'complaints');
define('TABLE_SHIPPING_AIRMAIL', DB_PREFIX . 'shipping_airmail');

define('TABLE_CUSTOMERS_TYPE', 'customers_type');


define('TABLE_DOC_CATEGORIES','doc_categories');
define('TABLE_DOC_CATEGORIES_DESCRIPTION','doc_categories_description');
define('TABLE_DOC_ARTICLE','doc_article');
define('TABLE_DOC_ARTICLE_DESCRIPTION','doc_article_description');
define('TABLE_DOC_ARTICLE_CATEGORY','doc_article_category');

define('TABLE_GIVE_A_LIKE','give_a_like');
define('TABLE_PRODUCTS_DESCRIPTION_EN', 'products_description');

define('TABLE_SOLUTION_CATEGORIES','solution_categories');
define('TABLE_SOLUTION_CATEGORIES_DESCRIPTION','solution_categories_description');
define('TABLE_SOLUTION_ARTICLE','solution_article');
define('TABLE_SOLUTION_ARTICLE_DESCRIPTION','solution_article_description');
define('TABLE_SOLUTION_ARTICLE_CATEGORY','solution_article_category');

define('TABLE_ADMIN_TO_CUSTOMERS','admin_to_customers');

define('TABLE_WIRETRANSFER_ORDERS', 'wiretransfer_orders');

define('TABLE_SEARCH_WORDS','search_words');

define('TABLE_SEO_CACHE', DB_PREFIX . 'seo_cache');
define('TABLE_PRODUCTS_CUSTOMERS_ULTIMATELY_BUY', DB_PREFIX . 'products_customers_ultimately_buy');

define('TABLE_ORDERS_CANCEL_REQUEST',DB_PREFIX .'orders_cancel_request');
define('TABLE_SPECIAL_OFFERS_DESCRIPTION',DB_PREFIX .'special_offers_description');
define('TABLE_CATEGORIES_BANNER',DB_PREFIX .'categories_banner');

define('TABLE_SUBSCRIBE',DB_PREFIX .'subscribe');
define('TABLE_CUSTOMERS_VISITED_PAGES',DB_PREFIX .'customers_visited_pages');

define('TABLE_ORDER_INQUIRY',DB_PREFIX .'order_inquiry');
define('TABLE_CUSTOMER_OF_PARTNER','customer_of_partner');
define('TABLE_PARTNER_BUSINESS_SCOPE','partner_business_scope');

define('TABLE_PRICE_INQUIRY','products_price_inquiry');
define('TABLE_PRICE_INQUIRY_ATTRIBUTE','product_inquiry_attribute');
define('TABLE_PRICE_INQUIRY_PRODUCTS_LENGTH','product_inquiry_products_length');

define('TABLE_SUPPORT_ARTICLES_DESCRIPTION',DB_PREFIX .'support_articles_description');
define('TABLE_SUPPORT_ARTICLES',DB_PREFIX .'support_articles');
define('TABLE_SUPPORT_ARTICLES_EXTENSION',DB_PREFIX .'support_articles_extension');
define('TABLE_SUPPORT_ARTICLES_EXTENSION_DESCRIPTION',DB_PREFIX .'support_articles_extension_description');
define('TABLE_SUPPORT_ARTICLES_TO_CATEGORIES',DB_PREFIX .'support_articles_to_categories');
define('TABLE_SUPPORT_CATEGORIES',DB_PREFIX .'support_categories');
define('TABLE_SUPPORT_CATEGORIES_DESCRIPTION',DB_PREFIX .'support_categories_description');
define('TABLE_SUPPORT_MODULES',DB_PREFIX .'support_modules');
define('TABLE_SUPPORT_MODULES_DESCRIPTION',DB_PREFIX .'support_modules_description');
define('TABLE_SUPPORT_ARTICLE_IS_USEFUL',DB_PREFIX .'support_article_is_useful');
define('TABLE_CUSTOMER_QUICKLY',DB_PREFIX.'customers_quickly');

define('TABLE_LIVE_CHAT_PHONE_SERVICE',DB_PREFIX .'live_chat_phone_service');

define('TABLE_CUSTOMERS_SIGNIN_WITH_SOCIAL_MEIDA',DB_PREFIX.'customers_signin_with_social_media');
define('TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO','customers_social_media_google_info');
define('TABLE_CUSTOMERS_SOCIAL_MEDIA_PAYPAL_INFO','customers_social_media_paypal_info');
define('TABLE_CUSTOMERS_SOCIAL_MEDIA_MSN_INFO','customers_social_media_msn_info');

define('TABLE_ORDER_TO_ADMIN',DB_PREFIX.'order_to_admin');

define('TABLE_UPDATE_CATEGORIES_HISTORY',DB_PREFIX.'update_categories_history');
define('TABLE_UPDATE_PRODUCTS_HISTORY',DB_PREFIX.'update_products_history');

define('TABLE_PAGE_META_TAGS',DB_PREFIX.'page_meta_tags');

define('TABLE_CUSTOEMR_FEEDBACK',DB_PREFIX.'customer_feedback');
define('TABLE_CUSTOEMR_FEEDBACK_SOLUTION',DB_PREFIX.'customer_feedback_solution');
define('TABLE_INDEX_FBNEWS_INFO','index_fbnews_info');
define('TABLE_FS_SEARCH_WORDS','fs_search_words');

define('TABLE_CUSTOMERS_SERVICE','customers_service');
define('TABLE_CUSTOMERS_SERVICE_REFUND','customers_service_refund');
define('TABLE_CUSTOMERS_SERVICE_HISTORY','customers_service_history');
define('TABLE_SERVICE_STATUS_NAME','service_status_name');
define('TABLE_PURCHASE_TO_LOGISTICS','purchase_to_logistics');
define('TABLE_CATEGORIES_NARROW_BY_SET','categories_narrow_by_set');
define('TABLE_ONLY_WT_CHECKOUT_PRODUCTS','only_wt_checkout_products');

define('TABLE_CUSTOMER_OF_GUEST','customer_of_guest');

define('TABLE_QUOTATION','quotation');
define('TABLE_QUOTATION_PRODUCTS','quotation_products');
define('TABLE_CUSTOMERS_BASKET_REORDER_QUOTATION','customers_basket_reorder_quotation');
define('TABLE_CUSTOMERS_BASKET_REORDER_ORDER','customers_basket_reorder_order');
define('TABLE_ORDERS_OVERTIME','orders_overtime');
define('TABLE_ORDERS_OVERTIME_CHANGE_LOGO','orders_overtime_change_logo');

define('TABLE_CUSTOMER_APPOINTMENT_INFO', 'customer_appointment_info');
define('TABLE_CUSTOMER_APPOINTMENT_QUEUE', 'customer_appointment_queue');
define('TABLE_CAQ_SUCCESS_LOG', 'caq_success_log');
define('TABLE_CAQ_FAILED_LOG', 'caq_failed_log');

//po重构表
define('TABLE_PRODUCTS_INSTOCK_SHIPPING_PAYMENT_INVOICE', 'products_instock_shipping_payment_invoice');
define('TABLE_PRODUCTS_INSTOCK_SHIPPING_PAYMENT_INVOICE_SERVICE', 'products_instock_shipping_payment_invoice_service');


define('TABLE_PRODUCTS_NARROW_BY_OPTIONS','products_narrow_by_options');
define('TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES','products_narrow_by_options_values');
define('TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES_TO_OPTIONS','products_narrow_by_options_values_to_options');

define('TABLE_PRODUCTS_NARROW_BY_OPTIONS_TO_CATEGORIES','products_narrow_by_options_to_categories');
define('TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS','products_narrow_by_option_values_to_products');
