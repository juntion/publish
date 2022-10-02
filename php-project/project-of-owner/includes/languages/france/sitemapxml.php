<?php
/**
 * Sitemap XML Feed
 *
 * @package Sitemap XML Feed
 * @copyright Copyright 2005-2009, Andrew Berezin eCommerce-Service.com
 * @copyright Portions Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @link http://www.sitemaps.org/
 * @version $Id: site_map_xml.php, v 2.1.0 30.04.2009 10:35 AndrewBerezin $
 */

define('NAVBAR_TITLE', 'SiteMapXML');
define('HEADING_TITLE', 'SiteMapXML (' . SITEMAPXML_VERSION . ')');

define('TEXT_EXECUTION_TIME', 'Durée d\'exécution totale');
define('TEXT_TOTAL_SITEMAP', 'Total: fichiers %s, articles %s (%s bytes).');
define('TEXT_FILE_SITEMAP_INFO', 'Fichier <a href="%s" target="_blank">%s</a>. Ecrit %s articles (%s bytes), Filesize: %s bytes');
define('TEXT_WRITTEN', ' Ecrit %s articles (%s bytes), Filesize: %s bytes');

define('TEXT_URL_FILE', 'URL - ');
define('TEXT_INCLUDE_FILE', 'Inclure ');
define('TEXT_FILE_NOT_CHANGED', 'pas changé - en utilisant le fichier existant');
define('TEXT_FAILED_TO_OPEN', '<span style="font-weight: bold); color: red;"> Impossible d\'ouvrir le fichier</span>');

define('TEXT_HEAD_SITEMAP_INDEX', 'Plan du site Index');
define('TEXT_HEAD_PING', 'Ping');

define('TEXT_ERROR_CURL_NOT_FOUND', 'CURL functions not found - required for ping/checkURL functions');
define('TEXT_ERROR_CURL_INIT', 'cURL Erreur: init cURL');
define('TEXT_ERROR_CURL_EXEC', 'cURL Erreur: "<b>%s</b>" lecture "%s"');
define('TEXT_ERROR_CURL_NO_HTTPCODE', 'cURL Erreur: No http_code reading "%s"');
define('TEXT_ERROR_CURL_ERR_HTTPCODE', 'cURL Erreur: Error http_code "<b>%s</b>" reading "%s"');
define('TEXT_ERROR_CURL_0_DOWNLOAD', 'cURL Erreur: Zero download size reading "%s"');
define('TEXT_ERROR_CURL_ERR_DOWNLOAD', 'cURL Erreur: Reading less than page size "%s". Download = %s, Content length = %s.');

define('TEXT_HEAD_PRODUCTS', 'Plan du site des produits');
define('TEXT_HEAD_CATEGORIES', 'Plan du site des catégories');
define('TEXT_HEAD_EZPAGES', 'Plan du site des Ezpages');
define('TEXT_HEAD_REVIEWS', 'Plan du site des commentaires');
define('TEXT_HEAD_TESTIMONIALS', 'Testimonials Sitemap des témoignages');

define('TEXT_ERRROR_EZPAGES_OUTOFBASE', 'EZ-Page ignored (out of base url): "<b>%s</b>" (%s)');
define('TEXT_ERRROR_EZPAGES_ROBOTS', 'EZ-Page ignored (found in ROBOTS_PAGES_TO_SKIP): "<b>%s</b>" (%s)');

// EOF