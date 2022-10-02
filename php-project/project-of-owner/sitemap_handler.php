<?php
require 'includes/application_top.php';


$time_start = explode (' ', microtime());

@define('SITEMAPXML_COMPRESS', 'true');
@define('SITEMAPXML_LASTMOD_FORMAT', 'date');
@define('SITEMAPXML_USE_EXISTING_FILES', 'true'); // new
@define('SITEMAPXML_USE_DEFAULT_LANGUAGE', 'true'); // new
@define('SITEMAPXML_PING_URLS', "Google => http://www.google.com/webmasters/sitemaps/ping?sitemap=%s
Yahoo! => http://search.yahooapis.com/SiteExplorerService/V1/ping?sitemap=%s
Ask.com => http://submissions.ask.com/ping?sitemap=%s
Microsoft => http://www.moreover.com/ping?u=%s"); // new

@define('SITEMAPXML_PRODUCTS_ORDERBY', 'p.products_sort_order ASC, last_date DESC'); // new
@define('SITEMAPXML_CATEGORIES_ORDERBY', 'c.sort_order ASC, last_date DESC'); // new
@define('SITEMAPXML_REVIEWS_ORDERBY', 'r.reviews_rating ASC, last_date DESC'); // new
@define('SITEMAPXML_EZPAGES_ORDERBY', 'p.sidebox_sort_order ASC'); // new
@define('SITEMAPXML_TESTIMONIALS_ORDERBY', 'last_date DESC'); // new

@define('SITEMAPXML_PRODUCTS_CHANGEFREQ', '');
@define('SITEMAPXML_CATEGORIES_CHANGEFREQ', '');
@define('SITEMAPXML_REVIEWS_CHANGEFREQ', ''); // new
@define('SITEMAPXML_EZPAGES_CHANGEFREQ', '');
@define('SITEMAPXML_TESTIMONIALS_CHANGEFREQ', ''); // new

if (!get_cfg_var('safe_mode') && function_exists('set_time_limit')) {
	set_time_limit(0);
}

// This should be first line of the script:
require(DIR_WS_CLASSES . 'sitemapxml.php');


/**
 * load languages files
 */

require DIR_WS_LANGUAGES.'english/sitemapxml.php';


$inline   = (isset($_GET['inline']) && $_GET['inline'] == 'yes') ? true : false;
$genxml   = (!isset($_GET['genxml']) || $_GET['genxml'] != 'no') ? true : false;
$ping     = (isset($_GET['ping']) && $_GET['ping'] == 'yes') ? true : false;
$checkurl = (isset($_GET['checkurl']) && $_GET['checkurl'] == 'yes') ? true : false;
$rebuild = (isset($_GET['rebuild']) && $_GET['rebuild'] == 'yes') ? true : false;

/**
 * load the site map class
 */

$zen_SiteMapXML = new zen_SiteMapXML($inline, $ping, $rebuild, $genxml);

$zen_SiteMapXML->setCheckURL($checkurl);

$tpl_dir = $template->get_template_dir('gss\.xsl', DIR_WS_TEMPLATE, $current_page_base, 'css');
$zen_SiteMapXML->setStylesheet($tpl_dir . '/gss.xsl');


$languages_id = 1;
if (isset($_GET['language_id']) && $_GET['language_id']) {
	$languages_id = (int)$_GET['language_id'];
}


$action = $_GET['action'];

if (zen_not_null($action)) {

	switch ($action){
		case 'categories':
			echo 'generate categories sitemap for google <br/>';
			$zen_SiteMapXML->build_categories_sitemap();
			break;
		case 'categories_page_link':
			echo 'generate categories page link sitemap for google <br/>';
			$zen_SiteMapXML->build_categories_sitemap();
			break;
		case 'products':
			echo 'generate fiberstor products sitemap for google <br/>';
			$zen_SiteMapXML->build_products_sitemap();
			break;
		case 'tutarial':
			$zen_SiteMapXML->build_tutorial_sitemap();
			break;
		case 'news':
			$zen_SiteMapXML->build_news_sitemap();
			break;

		case 'producttags':
			$zen_SiteMapXML->build_producttags_sitemap();
			break;
		case 'articlepage':
			$zen_SiteMapXML->build_articlepage_sitemap();
			break;
		case 'sitemap_index':
			$zen_SiteMapXML->GenerateSitemapIndex();
			break;

		case 'solution_article':
			$zen_SiteMapXML->build_solution_article_sitemap();
			break;

		case 'Narrow_by':
			//$zen_SiteMapXML->build_Narrow_by_sitemap();
			break;

		case 'one_key_generate':

			$zen_SiteMapXML->build_categories_sitemap();
			$zen_SiteMapXML->build_products_sitemap();
//			$zen_SiteMapXML->build_solution_article_sitemap();
			$zen_SiteMapXML->build_articlepage_sitemap();
			$zen_SiteMapXML->build_news_sitemap();
			$zen_SiteMapXML->build_tutorial_sitemap();
			$zen_SiteMapXML->build_pdf_sitemap();
//			$zen_SiteMapXML->build_product_catalogs_sitemap();
			$zen_SiteMapXML->build_support_sitemap();
			$zen_SiteMapXML->GenerateSitemapIndex();
			break;
	}

}