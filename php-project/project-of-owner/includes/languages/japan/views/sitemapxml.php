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

define('TEXT_EXECUTION_TIME', '総実行時間');
define('TEXT_TOTAL_SITEMAP', '全部：ファイル %s, アイテム %s (%s バイト).');
define('TEXT_FILE_SITEMAP_INFO', 'ファイル <a href="%s" target="_blank">%s</a>. %s アイテム (%s バイト)記入された, ファイル サイズ: %s バイト');
define('TEXT_WRITTEN', '%s アイテム (%s バイト)記入された, ファイル サイズ: %s バイト');

define('TEXT_URL_FILE', 'URL - ');
define('TEXT_INCLUDE_FILE', '含む ');
define('TEXT_FILE_NOT_CHANGED', '変更はありません - 既存のファイルを使用する');
define('TEXT_FAILED_TO_OPEN', '<span style="font-weight: bold); color: red;"> ファイルのオープンに失敗した</span>');

define('TEXT_HEAD_SITEMAP_INDEX', 'サイトマップインデックス');
define('TEXT_HEAD_PING', 'Ping');

define('TEXT_ERROR_CURL_NOT_FOUND', 'cURL関数が見つからない - ping/checkUrl関数が必要になる');
define('TEXT_ERROR_CURL_INIT', 'cURLエラー：init cURL');
define('TEXT_ERROR_CURL_EXEC', 'cURLエラー： "<b>%s</b>" 読み込み中"%s');
define('TEXT_ERROR_CURL_NO_HTTPCODE', 'cURLエラー：http_codeが読まれていない "%s"');
define('TEXT_ERROR_CURL_ERR_HTTPCODE', 'cURLエラー：エラーhttp_codeの読み取り "%s"');
define('TEXT_ERROR_CURL_0_DOWNLOAD', 'cURLエラー：ダウンロード読み込みサイズがゼロです "%s"');
define('TEXT_ERROR_CURL_ERR_DOWNLOAD', 'cURLエラー：読み込みファイルのサイズがページサイズより大きいです "%s".ダウンロード = %s,Content-Length = %s.');

define('TEXT_HEAD_PRODUCTS', '商品 - サイトマップ');
define('TEXT_HEAD_CATEGORIES', 'カテゴリ - サイトマップ');
define('TEXT_HEAD_EZPAGES', 'EZページ - サイトマップ');
define('TEXT_HEAD_REVIEWS', 'レビュー - サイトマップ');
define('TEXT_HEAD_TESTIMONIALS', 'クライアントの声 - サイトマップ');

define('TEXT_ERRROR_EZPAGES_OUTOFBASE', 'EZ-ページが無視されます（URL以外）: "<b>%s</b>" (%s);
define('TEXT_ERRROR_EZPAGES_ROBOTS', 'EZ-ページが無視されます（ROBOTS_PAGES_TO_SKIPに見つかりました）: "<b>%s</b>" (%s)');

// EOF