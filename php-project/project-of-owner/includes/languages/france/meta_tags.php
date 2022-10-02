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
define('CUSTOM_KEYWORDS', 'Émetteurs-récepteurs, câbles de raccordement, adaptateurs, atténuateurs, FiberStore, les achats en ligne');

// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'FiberStore pour émetteur-récepteur optique, Multiplexeur / Démultiplxeur, Fibre Convertisseur de Média, Multiplexeur de vidéo, cordon patch à fibre optique, panneau patch à fibre, connecteur de câble à fibre optique et d\'autres accessoires réseaux à fibre optique');
  define('HOME_PAGE_META_KEYWORDS', 'la communication à fibre optique, le réseau à fibre optique, les produits à fibre optique');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', 'FiberStore - Fiber Network Solution, Tout dans FiberStore! '); // usually best left blank


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
  define('META_TAGS_REVIEW', 'Commentaires: ');

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
define('METE_TAGS_CAT_BUY','Achetez ');
define('METE_TAGS_CAT_BEST_PRICE',' en Ligne, Sélectionnez les Meilleurs ');
define('META_TAGS_CATEGORIES_DESCRIPTION',' chez FS.com.');

/*narrow*/
define('METE_TAGS_NARROW_FS',', Recherche FS.com');
define('METE_TAGS_NARROW_ONLINE_GLOBAL',' Mondial en Ligne ');
define('METE_TAGS_NARROW_OEM_MANUFACTURER',' Fournisseur OEM International pour Marques Renommées');
define('METE_TAGS_NARROW_OEM',' FS.com. Commandez et personnalisez vos produits de fibre optique chez FS.com !');

/*support*/
define('METE_TAGS_SUPPORT_OF_FS','Assistance FS.com');

define('METE_TAGS_POPULAR','Populaire -FS.com');
define('METE_TAGS_PRODUCTS_LIST','Liste de produits');
define('METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST',' Liste de produits de fibre optique ');
define('META_TAGS_FIBERSTORE',' -FS.com');
define('META_TAGS_THE_LEADING','Fournisseur OEM international de produits de fibre optique pour marques renommées. Vous pouvez facilement trouver tous les produits de FS.com sur cette page.');
define('META_TAGS_CUSTOMER_SERVICE','Service Clients');
define('META_TAGS_TUTORIAL_OF_COM','Tutoriel de FS.com');
define('META_TAGS_NEWS_OF_COM','Nouvelles de FS.com');

define('META_TAGS_COMMON_TITLE','Centre de données, Entreprise, Télécom');
define('META_TAGS_COMMON_DESCRIPTION','FS est une nouvelle marque de solutions d\'accès aux datacenters, aux entreprises et Télécom. Nous permettons aux professionnels de l\'informatique d\'activer leurs solutions d\'affaires de manière simple et économique.');

//solutions页面meta相关
define('FS_SOLUTION_META_TITLE_O1','FS Solution OTN pour Réseau DWDM 10G à Double Fibre');
define('FS_SOLUTION_META_DESCRIPTION_O1','FS fournit une solution DWDM 10G intégrée, rentable et facile à gérer pour l\'Interconnexion des Centres de Données (DCI) et des Applications de l\'Enterprise.');
define('FS_SOLUTION_META_TITLE_O2','FS Solution OTN pour Réseau  DWDM 10G à Seule Fibre');
define('FS_SOLUTION_META_DESCRIPTION_O2','FS fournit une solution DWDM 10G intégrée, rentable et facile à gérer et pour l\'Interconnexion des Centres de Données (DCI) et des Applications de l\'Enterprise.');
define('FS_SOLUTION_META_TITLE_O3','FS Solution OTN pour Réseau DWDM 25G à Double Fibre');
define('FS_SOLUTION_META_DESCRIPTION_O3','FS fournit une solution DWDM 25G d\'évolutivité facile et de gestion intelligente pour 25G Ethernet, 5G fronthaul et interconnexion des centres de données.');
define('FS_SOLUTION_META_TITLE_O4','FS Solution OTN pour Réseau DWDM 25G à Seule Fible');
define('FS_SOLUTION_META_DESCRIPTION_O4','FS fournit une solution DWDM 25G d\'évolutivité facile et de gestion intelligente pour 25G Ethernet, 5G fronthaul et interconnexion des centres de données.');
define('FS_SOLUTION_META_TITLE_O5','FS Solution OTN pour Réseau CWDM 10G à Double Fibre');
define('FS_SOLUTION_META_DESCRIPTION_O5','FS fournit une solution CDWM 10G rentable et de grande capacité pour les réseaux de tranfert métropolitains à courte distance.');
define('FS_SOLUTION_META_TITLE_O6','FS Solution OTN pour Réseau CWDM 10G à Seule Fibre');
define('FS_SOLUTION_META_DESCRIPTION_O6','FS fournit une solution CWDM 10G rentable et de grande capacité pour les réseaux de tranfert métropolitains à courte distance.');
