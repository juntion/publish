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

define('NAVBAR_TITLE', 'SitemapXML');
define('HEADING_TITLE', 'SitemapXML (' . SITEMAPXML_VERSION . ')');

define('TEXT_EXECUTION_TIME', 'Gesamte Durchführungszeit');
define('TEXT_TOTAL_SITEMAP', 'Total: Datei %s, Artikel%s (%s Bytes).');
define('TEXT_FILE_SITEMAP_INFO', 'Datei <a href="%s"Ziel="_blank">%s</a>. Geschriebene %s Artikel (%s Bytes), Dateigröße : %s Bytes');
define('TEXT_WRITTEN', 'Geschriebene %s Artikel (%s Bytes), Dateigröße : %s Bytes');

define('TEXT_URL_FILE', 'URL - ');
define('TEXT_INCLUDE_FILE', 'Enthalten ');
define('TEXT_FILE_NOT_CHANGED', 'haben nicht geändert - existierte Daten zu benutzen');
define('TEXT_FAILED_TO_OPEN', '<span style="Font-Gewicht: fettgedruckt); Farbe: Rot;"> Datei nicht aufgemacht werden kann</span>');

define('TEXT_HEAD_SITEMAP_INDEX', 'Sitemap Index');
define('TEXT_HEAD_PING', 'Ping');

define('TEXT_ERROR_CURL_NOT_FOUND', 'CURL Funktionen nicht gefunden -  ping erforderlich /Prüfen URL Funktionen');
define('TEXT_ERROR_CURL_INIT', 'cURL Fehler: Initialisieren cURL');
define('TEXT_ERROR_CURL_EXEC', 'cURL Fehler: "<b>%s</b>" Ablesung  "%s"');
define('TEXT_ERROR_CURL_NO_HTTPCODE', 'cURL Fehler: Keine http_Kode Lesen "%s"');
define('TEXT_ERROR_CURL_ERR_HTTPCODE', 'cURL Fehler: Fehler http_code "<b>%s</b>" Lesen "%s"');
define('TEXT_ERROR_CURL_0_DOWNLOAD', 'cURL Fehler: Kein Herunterladen Größe Lesen "%s"');
define('TEXT_ERROR_CURL_ERR_DOWNLOAD', 'cURL Fehler: Lesen weniger als Seitengröße "%s". Herunterladen = %s, Inhalt Länge = %s.');

define('TEXT_HEAD_PRODUCTS', 'Produkte Sitemap');
define('TEXT_HEAD_CATEGORIES', 'Kategorien Sitemap');
define('TEXT_HEAD_EZPAGES', 'Ezpages Sitemap');
define('TEXT_HEAD_REVIEWS', 'Kommentare Sitemap');
define('TEXT_HEAD_TESTIMONIALS', 'Empfehlungsschreiben Sitemap');

define('TEXT_ERRROR_EZPAGES_OUTOFBASE', 'EZ-Seite ignoriert (Aus der Basis url): "<b>%s</b>" (%s)');
define('TEXT_ERRROR_EZPAGES_ROBOTS', 'EZ-Seite ignoriert (gefunden auf ROBOTS_PAGES_TO_SKIP): "<b>%s</b>" (%s)');

// EOF