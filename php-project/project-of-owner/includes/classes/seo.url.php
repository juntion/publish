<?php
require_once(dirname(__FILE__) . '/seo.install.php');
	class SEO_URL{
		var $cache;
		var $languages_id;
		var $attributes;
		var $base_url;
		var $base_url_ssl;
		var $reg_anchors;
		var $cache_query;
		var $cache_file;
		var $data;
		var $need_redirect;
		var $is_seopage;
		var $uri;
		var $real_uri;
		var $uri_parsed;
		var $db;
		var $installer;

		function SEO_URL($languages_id=''){
			global $session_started;

			$this->installer = new SEO_URL_INSTALLER();

			$this->db = &$GLOBALS['db'];

			if ($languages_id == '') $languages_id = $_SESSION['languages_id'];

			$this->languages_id = (int)$languages_id;

			$this->data = array();

			$seo_pages = array(
				FILENAME_DEFAULT,
				FILENAME_PRODUCT_INFO,
				FILENAME_ADVANCED_SEARCH_RESULT,
				FILENAME_CLEARANCE_LIST,
				FILENAME_POPUP_IMAGE,
				FILENAME_PRODUCT_REVIEWS,
				FILENAME_PRODUCT_REVIEWS_INFO,
				FILENAME_EZPAGES,
				FILENAME_TUTORIAL,
				FILENAME_TUTORIAL_DETAIL,
				FILENAME_TUTORIAL_LIST,
				FILENAME_PRODUCTS_DETAIL,
				FILENAME_PRODUCTS_LIST,
				FILENAME_SUPPORT_DETAIL,
				FILENAME_ALL_REVIEW,
				FILENAME_NARROW,
				FILENAME_IN_THE_NEWS,
				FILENAME_POPULAR_DETAIL,
				FILENAME_PRODUCT_LIST,
				FILENAME_TAG_CATEGORIES,
				FILENAME_FIBER_TRANSCEIVERS,
				FILENAME_TUTORIAL_TAG_SEARCH,
				FILENAME_COMMENTS_REVIEW,
				'support_stock_list',
				FILENAME_PRODUCTS_TAG_SEARCH,
				'fs_single_pages',
			);

			// News & Article Manager SEO support
			if (defined('FILENAME_NEWS_INDEX')) $seo_pages[] = FILENAME_NEWS_INDEX;
			if (defined('FILENAME_NEWS_ARTICLE')) $seo_pages[] = FILENAME_NEWS_ARTICLE;
			if (defined('FILENAME_NEWS_ARCHIVE')) $seo_pages[] = FILENAME_NEWS_ARCHIVE;
			if (defined('FILENAME_NEWS_RSS')) $seo_pages[] = FILENAME_NEWS_RSS;
            if (defined('FILENAME_SUPPORT_DETAIL')) $seo_pages[] = FILENAME_SUPPORT_DETAIL;
			if (defined('FILENAME_ALL_REVIEW')) $seo_pages[] = FILENAME_ALL_REVIEW;
			//if (defined('FILENAME_SOLUTION_LIST')) $seo_pages[] = FILENAME_SOLUTION_LIST;
			if (defined('FILENAME_PRODUCTS_DETAIL')) $seo_pages[] = FILENAME_PRODUCTS_DETAIL;
			// Info Manager (Open Operations)
			if (defined('FILENAME_INFO_MANAGER')) $seo_pages[] = FILENAME_INFO_MANAGER;

			$this->attributes = array(
				'PHP_VERSION' => PHP_VERSION,
				'SESSION_STARTED' => $session_started,
				'SID' => (defined('SID') && $this->not_null(SID) ? SID : ''),
				'SEO_ENABLED' => defined('SEO_ENABLED') ? SEO_ENABLED : 'false',
				'SEO_ADD_CPATH_TO_PRODUCT_URLS' => defined('SEO_ADD_CPATH_TO_PRODUCT_URLS') ? SEO_ADD_CPATH_TO_PRODUCT_URLS : 'false',
				'SEO_ADD_CAT_PARENT' => defined('SEO_ADD_CAT_PARENT') ? SEO_ADD_CAT_PARENT : 'true',
				'SEO_URLS_USE_W3C_VALID' => defined('SEO_URLS_USE_W3C_VALID') ? SEO_URLS_USE_W3C_VALID : 'true',
				'USE_SEO_CACHE_GLOBAL' => defined('USE_SEO_CACHE_GLOBAL') ? USE_SEO_CACHE_GLOBAL : 'false',
				'USE_SEO_CACHE_PRODUCTS' => defined('USE_SEO_CACHE_PRODUCTS') ? USE_SEO_CACHE_PRODUCTS : 'false',
				'USE_SEO_CACHE_CATEGORIES' => defined('USE_SEO_CACHE_CATEGORIES') ? USE_SEO_CACHE_CATEGORIES : 'false',
				'USE_SEO_CACHE_MANUFACTURERS' => defined('USE_SEO_CACHE_MANUFACTURERS') ? USE_SEO_CACHE_MANUFACTURERS : 'false',
				'USE_SEO_CACHE_ARTICLES' => defined('USE_SEO_CACHE_ARTICLES') ? USE_SEO_CACHE_ARTICLES : 'false',
				'USE_SEO_CACHE_INFO_PAGES' => defined('USE_SEO_CACHE_INFO_PAGES') ? USE_SEO_CACHE_INFO_PAGES : 'false',
				'USE_SEO_CACHE_EZ_PAGES' => defined('USE_SEO_CACHE_EZ_PAGES') ? USE_SEO_CACHE_EZ_PAGES : 'false',
				'USE_SEO_REDIRECT' => defined('USE_SEO_REDIRECT') ? USE_SEO_REDIRECT : 'false',
				'SEO_REWRITE_TYPE' => defined('SEO_REWRITE_TYPE') ? SEO_REWRITE_TYPE : 'false',
				'SEO_URLS_FILTER_SHORT_WORDS' => defined('SEO_URLS_FILTER_SHORT_WORDS') ? SEO_URLS_FILTER_SHORT_WORDS : 'false',
				'SEO_CHAR_CONVERT_SET' => defined('SEO_CHAR_CONVERT_SET') ? $this->expand(SEO_CHAR_CONVERT_SET) : 'false',
				'SEO_REMOVE_ALL_SPEC_CHARS' => defined('SEO_REMOVE_ALL_SPEC_CHARS') ? SEO_REMOVE_ALL_SPEC_CHARS : 'false',
				'SEO_PAGES' => $seo_pages,
				'SEO_INSTALLER' => $this->installer->attributes
			);

			$this->base_url = HTTP_SERVER;
			$this->base_url_ssl = HTTPS_SERVER;
			$this->cache = array();

			$this->reg_anchors = array(
				'products_id' => 'products',
			    'Popular_id' => '-po-',
			    'tag_type' => '-tag-',
			    'pr_id' => '-r-',
				'cPath' => '-c',
			    'tag' => '-finder',
					'con' => '-fiber',
				'manufacturers_id' => '-m-',
				'pID' => '-pi-',
				'products_id_review' => '-pr-',
				'products_id_review_info' => '-pri-',

				// News & Article Manager SEO support
				'news_article_id' => '-a-',
				'news_comments_article_id' => '-a-',
				'news_dates' => '/',
				'news_archive_dates' => '/archive/',
				'news_rss_feed' => '/rss',
       
				// Info Manager (Open Operations)
				'info_manager_page_id' => '-i-',
                'keyword' > '-keyword',
				// EZ-Pages SEO support
				'id' => '-ezp-',
				//tutorial
				'a_id'=> '-aid-',
				
			    'c'=> '-cid-',
				//'c'=> '-c-',
				 				
			//in-the-news
				'news' => '/news-',
				'event' => '/event-',
				'keywords' => '/keywords-',
			
				//solution list
			    's_cid' => '-scid-',
			
			    //solution detail
			    's_id' => '-sid-',
			   //support detail
			 'supportid' => 'support/'
			);

			if ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true'){
				$this->cache_file = 'seo_urls_v2_';
				$this->cache_gc();
				if ( $this->attributes['USE_SEO_CACHE_PRODUCTS'] == 'true' ) $this->generate_products_cache();
				if ( $this->attributes['USE_SEO_CACHE_CATEGORIES'] == 'true' ) $this->generate_categories_cache();
				if ( $this->attributes['USE_SEO_CACHE_ARTICLES'] == 'true' && defined('TABLE_NEWS_ARTICLES_TEXT')) $this->generate_news_articles_cache();
				if ( $this->attributes['USE_SEO_CACHE_INFO_PAGES'] == 'true' && defined('TABLE_INFO_MANAGER')) $this->generate_info_manager_cache();
				if ( $this->attributes['USE_SEO_CACHE_EZ_PAGES'] == 'true' ) $this->generate_ezpages_cache();
			}

			if ($this->attributes['USE_SEO_REDIRECT'] == 'true'){
				$this->check_redirect();
			} # end if
			
			
		} # end constructor

		function href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $static = false, $use_dir_ws_catalog = true) {
			// don't rewrite when disabled
			// don't rewrite images, css, js, xml, real html files, etc
			if ( ($this->attributes['SEO_ENABLED'] == 'false') || (preg_match('/(.+)\.(html?|xml|css|js|png|jpe?g|gif|bmp|tiff?|ico|gz|zip|rar)$/i', $page)) ) {
				return $this->stock_href_link($page, $parameters, $connection, $add_session_id, true, $static, $use_dir_ws_catalog);
			}
			// don't rewrite the paypal IPN notify url
			if ($page == 'ipn_main_handler.php') {
				return $this->stock_href_link($page, $parameters, $connection, $add_session_id, true, $static, $use_dir_ws_catalog);
			}
			// don't rewrite the zhifubao ATN notify url
			if ($page == 'atn_main_handler.php') {
				return $this->stock_href_link($page, $parameters, $connection, $add_session_id, true, $static, $use_dir_ws_catalog);
			}

			if ((!in_array($page, $this->attributes['SEO_PAGES'])) || (($page == FILENAME_DEFAULT) && (!preg_match('/(cpath|manufacturers_id)/i', $parameters)))) {
				if ($page == FILENAME_DEFAULT) {
					$page = '';
				} elseif ($page == FILENAME_DOWNLOAD && preg_match('/(cpath)/i', $parameters)) {
                    $page = FILENAME_DOWNLOAD;
                } else {
					$page = $page . '.html';
				}
			}

			if ($connection == 'NONSSL') {
				$link = $this->base_url;
			} elseif ($connection == 'SSL') {
				if (ENABLE_SSL == 'true') {
					$link = $this->base_url_ssl ;
				} else {
					$link = $this->base_url;
				}
			}

			if ($use_dir_ws_catalog) {
				if ($connection == 'SSL' && ENABLE_SSL == 'true') {
					$link .= DIR_WS_HTTPS_CATALOG;
				} else {
					$link .= DIR_WS_CATALOG;
				}
			}
			
			//拼接各个站点标识符
			if(!empty($_GET['lang']) && in_array(trim($_GET['lang']),$GLOBALS['fs_all_site'])){
				$link .= trim($_GET['lang']).'/';
			}
			
			if (strstr($page, '?')) {
				$separator = '&';
			} else {
				$separator = '?';
			}

			if ($this->not_null($parameters)) {
				$link .= $this->parse_parameters($page, $parameters, $separator);

			} else {
				// support SEO pages with no parameters
				switch ($page) {
					case FILENAME_NEWS_RSS:
						$link .= $this->make_url($page, FILENAME_NEWS_INDEX, 'news_rss_feed', '', '.xml', $separator);
						break;
					case FILENAME_NEWS_ARCHIVE:
						$link .= $this->make_url($page, FILENAME_NEWS_INDEX, 'news_archive_dates', '', '', $separator);
						break;
					case FILENAME_NEWS_INDEX:
						$link .= $this->make_url($page, FILENAME_NEWS_INDEX, 'news_dates', '', '', $separator);
						break;
                    case FILENAME_TUTORIAL:
						$link .= $page.'.html';
						break;
					default:
						$link .= $page;
						break;
				}
			}

			$link = $this->add_sid($link, $add_session_id, $connection, $separator);
			switch($this->attributes['SEO_URLS_USE_W3C_VALID']){
				case 'true':
					if (!isset($_SESSION['customer_id']) && defined('ENABLE_PAGE_CACHE') && ENABLE_PAGE_CACHE == 'true' && class_exists('page_cache')){
						return $link;
					} else {
						return htmlspecialchars(utf8_encode($link));
					}
					break;
				case 'false':
				default:
					return $link;
					break;
			}
		} # end function

		function stock_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true) {
			global $request_type, $session_started, $http_domain, $https_domain;

			if (!$this->not_null($page)) {
				die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine the page link!</strong><br /><br />');
			}

			if ($connection == 'NONSSL') {
				$link = HTTP_SERVER;
			} elseif ($connection == 'SSL') {
				if (ENABLE_SSL == 'true') {
					$link = HTTPS_SERVER ;
				} else {
					$link = HTTP_SERVER;
				}
			} else {
				die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
			}

    if ($use_dir_ws_catalog) {
      if ($connection == 'SSL') {
        $link .= DIR_WS_HTTPS_CATALOG;
      } else {
        $link .= DIR_WS_CATALOG;
      }
    }

			if (!$static) {
				if ($this->not_null($parameters)) {
					$link .= 'index.php?main_page='. $page . "&" . $this->output_string($parameters);
				} else {
					$link .= 'index.php?main_page=' . $page;
				}
			} else {
				if ($this->not_null($parameters)) {
					$link .= $page . "?" . $this->output_string($parameters);
				} else {
					$link .= $page;
				}
			}

			$separator = '&';

			while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

			if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
				if ($this->not_null($this->attributes['SID'])) {
					$_sid = $this->attributes['SID'];
				} elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
					if ($http_domain != $https_domain) {
						$_sid = session_name() . '=' . session_id();
					}
				}
			}

			// clean up the link before processing
			while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
			while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);

			switch(true){
				case (!isset($_SESSION['customer_id']) && defined('ENABLE_PAGE_CACHE') && ENABLE_PAGE_CACHE == 'true' && class_exists('page_cache')):
					$page_cache = true;
					$return = $link . $separator . '<zensid>';
					break;
				case (isset($_sid)):
					$page_cache = false;
					$return = $link . $separator . $_sid;
					break;
				default:
					$page_cache = false;
					$return = $link;
					break;
			}

			$this->cache['STANDARD_URLS'][] = $link;

			switch(true){
				case ($this->attributes['SEO_URLS_USE_W3C_VALID'] == 'true' && !$page_cache):
					return htmlspecialchars(utf8_encode($return));
					break;
				default:
					return $return;
					break;
			}# end swtich
		} # end default tep_href function

		function add_sid($link, $add_session_id, $connection, $separator) {
			global $request_type, $http_domain, $https_domain;

			if ( ($add_session_id == true) && ($this->attributes['SESSION_STARTED']) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
				if ($this->not_null($this->attributes['SID'])) {
					$_sid = $this->attributes['SID'];
				} elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
					if ($http_domain != $https_domain) {
						$_sid = session_name() . '=' . session_id();
					}
				}
			}

			switch(true){
				case (!isset($_SESSION['customer_id']) && defined('ENABLE_PAGE_CACHE') && ENABLE_PAGE_CACHE == 'true' && class_exists('page_cache')):
					$return = $link . $separator . '<zensid>';
					break;
				case ($this->not_null($_sid)):
					$return = $link . $separator . $_sid;
					break;
				default:
					$return = $link;
					break;
			} # end switch
			return $return;
		} # end function
		

		
		//str_replace special character
		function strip_special_characters($cName){
			$special = array('#',',',' ');
			$general = array('-','-','-');
			$cName = str_replace($special, $general, $cName);
			return $cName;
		}
/**
 * Function to parse the parameters into an SEO URL
 * @author Bobby Easland
 * @version 1.2
 * @param string $page
 * @param string $params
 * @param string $separator NOTE: passed by reference
 * @return string
 */
	function parse_parameters($page, $params, &$separator) {
		
		$p = @explode('&', $params);
		krsort($p);
		$container = array();
		foreach ($p as $index => $valuepair){
			$p2 = @explode('=', $valuepair);  //分割成数组
			
			//BOF processing narrow by
			if ('narrow[]' == $p2[0]) {         //$p2[0] 页面
				$container['narrow'][] = $p2[1];
				continue;
			}
			//EOF processing narrow by
			switch ($p2[0]){

				case 'article_id':
					switch(true) {
						case ($page == FILENAME_NEWS_ARTICLE):
							$url = $this->make_url($page, 'news/' . $this->get_news_article_name($p2[1]), 'news_article_id', $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;
					
				case 'date':
					switch(true) {
						case ($page == FILENAME_NEWS_ARCHIVE):
							$url = $this->make_url($page, FILENAME_NEWS_INDEX, 'news_archive_dates', $p2[1], '.html', $separator);
							break;
						case ($page == FILENAME_NEWS_INDEX):
							$url = $this->make_url($page, FILENAME_NEWS_INDEX, 'news_dates', $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;

	//in_the_news ***************************/
			   case 'news':
					switch(true) {
						case ($page == FILENAME_IN_THE_NEWS):
						$url = $this->make_in_the_news_url($page, $p2[1], $p2[0],$this->get_news_date($p2[1]),  '', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;
					
				case 'keywords':				
				switch(true) {
					case ($page == FILENAME_IN_THE_NEWS):							 
						$url = $this->make_in_the_news_url($page, $p2[1], $p2[0],$p2[1],  '', $separator);
						
					break;
					default:
						$container[$p2[0]] = $p2[1];
					break;
				}
				break;
					
				case 'event':
					switch(true) {
						case ($page == FILENAME_IN_THE_NEWS):
						//$url = $this->make_in_the_news_url($page, '',$p2[0],$this->get_news_date($p2[1]), '', $separator);
							$url = $this->make_in_the_news_url($page, $p2[1], $p2[0],$this->get_events_date($p2[1]),  '', $separator);
						break;
						default:
							$container[$p2[0]] = $p2[1];
						break;
					}
				break;
				
				case 'pages_id':
					switch(true) {
						case ($page == FILENAME_INFO_MANAGER):
							$url = $this->make_url($page, $this->get_info_manager_page_name($p2[1]), 'info_manager_page_id', $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;

				case 'a_id':
					switch(true) {
						case ($page == FILENAME_TUTORIAL_DETAIL):
							
							$url = $this->make_url($page, $this->get_tutorail_detail($p2[1]), $p2[0], $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;	
			   
				case 's_id':
					switch(true) {
						case ($page == FILENAME_PRODUCTS_DETAIL):
							$url = $this->make_url($page, $this->get_solution_detail($p2[1]), $p2[0], $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;	

			     //Popular
				case 'Popular_id':
			          switch(true) {
						//case ($page == FILENAME_POPULAR_DETAIL):
						//	$url =  $this->make_url($page, $this->get_popular_name($p2[1]), $p2[0], $p2[1], '.html', $separator);
							//$this->make_url($page, $p2[0], '/'.$this->get_popular_name($p2[1]),  $p2[1], '.html', $separator);
							//$url = $this->make_url($page, '', $p2[0], '/'.$p2[1], '/'.$this->get_support_detail($p2[1]), $separator);
						//	break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
				     break;			
					
				case 'products_id':
					switch(true) {
//						case ($page == FILENAME_PRODUCT_INFO && !$this->is_attribute_string($params)):
						case ($page == FILENAME_PRODUCT_INFO):
							//$url = $this->make_url($page, $this->get_product_name($p2[1]), $p2[0], $p2[1], '.html', $separator);
							$url = $this->make_url($page,'',$p2[0],'/'.$p2[1],'.html',$separator);
							break;
						case ($page == FILENAME_PRODUCT_REVIEWS):
							//$url = $this->make_url($page, $this->get_product_name($p2[1]), 'products_id_review', $p2[1], '.html', $separator);
							$url = $this->make_url_for_reviews($page,$container,'.html' ,$separator);
							break;
						case ($page == FILENAME_PRODUCT_REVIEWS_INFO):
						    $url = $this->make_url_for_reviews($page,$container,'.html' ,$separator);
							//$url = $this->make_url($page, $this->get_product_name($p2[1]), 'products_id_review_info', $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					} # end switch
					break;
				case 'cPath':
					switch(true){
						case ($this->is_product_string($params)):
							if ($this->attributes['SEO_ADD_CPATH_TO_PRODUCT_URLS'] == 'true') {
								$container[$p2[0]] = $p2[1];
							}
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
						} # end switch
					break;
				case 'keyword':
					switch(true){
						case ($this->is_product_string($params)):
							if ($this->attributes['SEO_ADD_CPATH_TO_PRODUCT_URLS'] == 'true') {
								$container[$p2[0]] = $p2[1];
							}
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
						} # end switch
					break;	
				case 'manufacturers_id':
					switch(true){
						case ($page == FILENAME_DEFAULT && !$this->is_cPath_string($params) && !$this->is_product_string($params)):
							$url = $this->make_url($page, $this->get_manufacturer_name($p2[1]), $p2[0], $p2[1], '.html', $separator);
							break;
						case ($page == FILENAME_PRODUCT_INFO):
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
						} # end switch
					break;
				case 'pID':
					switch(true){
						case ($page == FILENAME_POPUP_IMAGE):
						$url = $this->make_url($page, $this->get_product_name($p2[1]), $p2[0], $p2[1], '.html', $separator);
						break;
					default:
						$container[$p2[0]] = $p2[1];
						break;
					} # end switch
					break;
				case 'id':	// EZ-Pages
					switch(true){
						case ($page == FILENAME_EZPAGES):
							$url = $this->make_url($page, $this->get_ezpages_name($p2[1]), $p2[0], $p2[1], '.html', $separator);
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
						} # end switch
					break;
				case 'name':
					switch(true) {
						case ($page == 'fs_single_pages'):
							$url = $this->make_single_url($p2[1], '.html');
							break;
						default:
							$container[$p2[0]] = $p2[1];
							break;
					}
					break;
				default:
					if (!strpos($p2[0],'[]')) {
						$container[$p2[0]] = $p2[1];
					}
					break;
			} # end switch
		} # end foreach $p
		$url = isset($url) ? $url : $page;
		if ( sizeof($container) > 0 ){
//			$url = HTTP_SERVER.DIR_WS_CATALOG;
			if (in_array($page,array(FILENAME_NARROW,FILENAME_NS,FILENAME_DEFAULT,FILENAME_DOWNLOAD))) {

				$url = $this->make_url_for_categories($page,$container,'.html',$separator);
			}else if (FILENAME_NEWS == $page){
				$url = $this->make_url_for_news($page,$container,'.html',$separator);
			}else if (FILENAME_IN_THE_NEWS == $page){
				  if($url != $page){
				  	$url = $this->make_url_for_nae($url,$container,'.html',$separator);
				  }else{
				  	$url = $this->make_url_for_nae($page,$container,'.html',$separator);
				  }												
			}else if(FILENAME_ADVANCED_SEARCH_RESULT == $page){
			    $url = $this->make_url_for_search($page,$container,'.html',$separator);
            }else if(FILENAME_CLEARANCE_LIST == $page){
                $url = $this->make_url_for_clearance($page,$container,'.html',$separator);
			}else if(FILENAME_POPULAR_DETAIL == $page){
			    $url = $this->make_url_for_popular_detail($page,$container,'.html',$separator);
			}
			else if(FILENAME_TUTORIAL_LIST == $page){
			    $url = $this->make_url_for_tutorial($page,$container,'.html' ,$separator);
			}else if(FILENAME_TUTORIAL == $page){
			    $url = $this->make_url_for_tutorial_page($page,$container,'.html' ,$separator);
			}
		    else if(FILENAME_ALL_REVIEW == $page){
			    $url = $this->make_url_for_reviews($page,$container,'.html' ,$separator);
			}
			else if(FILENAME_PRODUCTS_LIST == $page){
			    $url = $this->make_url_for_solution($page,$container,'.html' ,$separator);
			}
		    else if(FILENAME_PRODUCT_LIST == $page){
			    $url = $this->make_url_for_popular_list($page,$container,'.html' ,$separator);
			}else if(FILENAME_TAG_CATEGORIES == $page){
			   $url = $this->make_url_for_tag_categories($page,$container,'.html',$separator);
			}else if(FILENAME_SUPPORT_DETAIL == $page){
			   $url = $this->make_url_for_tag_support_detail($page,$container,'.html',$separator);
			}elseif('support_stock_list'==$page){
				$url = $this->make_url_for_tag_support_stock_list($page,$container,'.html',$separator);
			}else if(FILENAME_FIBER_TRANSCEIVERS == $page){
				$url = $this->make_url_for_fiber_transceivers($page,$container,'.html',$separator);
			}else if(FILENAME_TUTORIAL_TAG_SEARCH == $page){
               $url = $this->make_url_for_tutorial_tag_search($page,$container,'.html',$separator);
			}else if(FILENAME_PRODUCTS_TAG_SEARCH == $page){
				$url = $this->make_url_for_products_tag_search($page,$container,'.html',$separator);
			}else if(FILENAME_COMMENTS_REVIEW == $page){
               $url = $this->make_url_for_comments_review($page,$container,'.html',$separator);
			}
			
			else{
			
				if ( $imploded_params = $this->implode_assoc($container) ){
					$url .= $separator . $this->output_string( $imploded_params );
					$separator = '&';
	//				$url  .= $this->output_string( $imploded_params );
				}
			
			
			}
		}
		
		return $url;
	} # end function

	/**
	 * 
	 * @param int $categories_id
	 * @todo get  category name 
	 */
	function get_fiberstore_categories_name($categories_id){
		$sql = "SELECT categories_name as cName
								FROM ".TABLE_CATEGORIES_DESCRIPTION."
								WHERE categories_id='".(int)$categories_id."'
								AND language_id=1
								LIMIT 1";
		$result = $this->db->Execute($sql);
		$pName = strtolower($result->fields['cName']);
		$pName = str_replace("μ", "u", $pName);
		$pName = str_replace("μm", "um", $pName);
		$pName = str_replace("”", "-", $pName);
		$pName = str_replace("±", "-", $pName);
		$pName = str_replace("+", "-", $pName);
		$pName = str_replace(".", "-", $pName);
		$pName = str_replace("＂", "-", $pName);
		$pName = str_replace("&", "-", $pName);
		$pName = str_replace("–", "-", $pName);
		$pName = str_replace("(", "-", $pName);
		$pName = str_replace(")", "-", $pName);
		$pName = str_replace("/", "-", $pName);
		$pName = str_replace("×", "-", $pName);
		$pName = str_replace(",", "-", $pName);
		$pName = str_replace(" ", "-", $pName);
		$pName = str_replace("	", "-", $pName);
		$pName = clear_chinesechar($pName);
		$pName = str_replace("--", "-", $pName);
		$pName = str_replace("--", "-", $pName);
	    $str = $pName;
		$var = trim($str);
		$len = strlen($var)-1;
		if($var{$len} == "-"){
		$pName = substr($pName, 0, -1);
		}
		return $pName;
	}
    /**
     *
     * @param int $clearance_id
     * @todo get clearance name
     */
    function get_clearance_name($clearance_id){
        $sql = "SELECT products_type as cName
                            FROM products_clearance_type
                            WHERE clearance_id='".(int)$clearance_id."'
                            AND languages_id= 1
                            AND is_clearance =1
                            LIMIT 1";
        $result = $this->db->Execute($sql);
        $pName = strtolower($result->fields['cName']);
        $pName = str_replace("μ", "u", $pName);
        $pName = str_replace("μm", "um", $pName);
        $pName = str_replace("”", "-", $pName);
        $pName = str_replace("±", "-", $pName);
        $pName = str_replace("+", "-", $pName);
        $pName = str_replace(".", "-", $pName);
        $pName = str_replace("＂", "-", $pName);
        $pName = str_replace("&", "-", $pName);
        $pName = str_replace("–", "-", $pName);
        $pName = str_replace("(", "-", $pName);
        $pName = str_replace(")", "-", $pName);
        $pName = str_replace("/", "-", $pName);
        $pName = str_replace("×", "-", $pName);
        $pName = str_replace(",", "-", $pName);
        $pName = str_replace(" ", "-", $pName);
        $pName = str_replace("	", "-", $pName);
        $pName = clear_chinesechar($pName);
        $pName = str_replace("--", "-", $pName);
        $pName = str_replace("--", "-", $pName);
        $str = $pName;
        $var = trim($str);
        $len = strlen($var)-1;
        if($var{$len} == "-"){
            $pName = substr($pName, 0, -1);
        }
        return $pName;
    }
	/**
	 * 
	 * @param $values_id
	 * @todo get option value  via $vID
	 */
	function get_narrow_by_option_value_name($vID){
		global $db;
		$result = $db->Execute("select products_narrow_by_options_values_name  as value,options_values_url_name as url_name
			from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES. " 
			where products_narrow_by_options_values_id = ".(int)$vID);
			
		    if($result->fields['url_name']){
		    $narrow_name = $result->fields['url_name'];
		    }else{
		    $narrow_name = $result->fields['value'];
		    }
		    
			$pName = $this->strip($narrow_name);
			$pName = str_replace("μ", "u", $pName);
			$pName = str_replace("μm", "um", $pName);
			$pName = str_replace("”", "-", $pName);
			$pName = str_replace("±", "-", $pName);
			$pName = str_replace("+", "-", $pName);
			$pName = str_replace(".", "-", $pName);
			$pName = str_replace("＂", "-", $pName);
			$pName = str_replace("&", "-", $pName);
			$pName = str_replace("×", "-", $pName);
			$pName = str_replace("–", "-", $pName);
			$pName = str_replace(" ", "-", $pName);
			$pName = clear_chinesechar($pName);
			if(substr($pName, 0, 1 ) == '-'){
			   $pName =  substr($pName,1,(strlen($pName)-1));
			 }
			$pName = $this->strip_special_characters($pName);
			$pName = str_replace("--", "-", $pName);  //replace '--' to '-'	
		return $pName;
		
	}
	

	function make_url($page, $string, $anchor_type, $id, $extension = '.html', &$separator){
		// Right now there is but one rewrite method since cName was dropped
		// In the future there will be additional methods here in the switch
		switch ( $this->attributes['SEO_REWRITE_TYPE'] ){
			case 'Rewrite':
				return $string . $this->reg_anchors[$anchor_type] . $id . $extension;
				break;
			default:
				break;
		} # end switch
	} # end function

	function make_single_url($id, $extension = '.html'){

		$sql = "SELECT s.category_name FROM `fs_single_page` s LEFT JOIN  `fs_single_pages_description` d ON s.id = d.category_id WHERE d.language_id = ".$_SESSION['languages_id']." AND d.type = 1 AND d.page_link = '".$id."'";
		$result = $this->db->Execute($sql);
		$category_name = $result->fields['category_name'];
		switch ($this->attributes['SEO_REWRITE_TYPE']){
			case 'Rewrite':
				return $category_name . '/' . $id . $extension;
				break;
			default:
				break;
		}
	}

		//in_the_news_url*******************
    function make_in_the_news_url($page, $id, $anchor_type,$string, $extension = '.html', &$separator){
		switch ( $this->attributes['SEO_REWRITE_TYPE'] ){
			case 'Rewrite':
				return 'news-and-events/' . $id  .$this->reg_anchors[$anchor_type]. $string . $extension;
				break;
			default:
				break;
		} 
	}	
	
	
	   // function make_url_for_tutorial($page,$container,$extension= '.html',&$separator){
						
	  function make_url_for_tutorial($page,$container,$extension,$separator){
			            if(isset($container['page']) && intval($container['page'])>1){
			             return 'tutorial/'.$this->get_tutorail_list($container['c']).'_cid' . intval($container['c'])  .'/'.intval($container['page']).$extension;
			            }else{
			            return $this->get_tutorail_list($container['c']) . $this->reg_anchors['c'] . intval($container['c']) . $extension;
			            }
	}
	
	function make_url_for_tutorial_page($page,$container,$extension,$separator){
	                    if(isset($container['page']) && intval($container['page'])>1){
			             return 'tutorial/'.intval($container['page']).$extension;
			            }else{
			            return  'tutorial/'. $extension;
			            }
	
	}
	
     function make_url_for_popular_list($page,$container,$extension,$separator){
			            if(isset($container['page']) && intval($container['page'])>1){
			             return $this->get_popular_list($container['tag_type']).'-tag-' . intval($container['tag_type'])  .'/'.intval($container['page']).$extension;
			            }else{
			            return $this->get_popular_list($container['tag_type']) . $this->reg_anchors['tag_type'] . intval($container['tag_type']) . $extension;
			            }
	}
	
	function make_url_for_reviews($page,$container,$extension,$separator){
		if(isset($container['page']) && intval($container['page'])>1){
			return 'reviews/'. intval($container['products_id']) .$extension .'?page='.intval($container['page']);
		}else{
			//return $this->get_product_name_of_review($container['pr_id']) . $this->reg_anchors['pr_id'] . intval($container['pr_id']) . $extension;
			return 'reviews/'. intval($container['products_id']) . $extension;
		}
	}
	
	function make_url_for_solution($page,$container,$extension,$separator){
		if(isset($container['page']) && intval($container['page'])>1){
			return 'products/'.$this->get_solution_list($container['s_cid']).'_scid' . intval($container['s_cid'])  .'/'.intval($container['page']).$extension;
		}else{
			return $this->get_solution_list($container['s_cid']) . $this->reg_anchors['s_cid'] . intval($container['s_cid']) . $extension;
		}
	}
	

	function get_category_compatible_url($categories_id){
		global $db;
		$sql = "SELECT compatible_url AS url  FROM ".TABLE_CATEGORIES_DESCRIPTION." WHERE categories_id = :categories_id: AND language_id = :languages_id:";
		$sql = $db->bindVars($sql,':languages_id:',(int)$_SESSION['languages_id'],'integer');
		$sql = $db->bindVars($sql,':categories_id:',(int)$categories_id,'integer');
		$result = $db->Execute($sql);
		return $result->fields['url'];
	}
	
	function make_url_for_tutorial_tag_search($page,$container,$extension,$separator){
		if(isset($container['page']) && intval($container['page'])>1){
			return 'tag/' . intval($container['tag_id']) .'/'.intval($container['page']).$extension;
		}else{
			return 'tag/' . intval($container['tag_id']) .$extension;
		}
	}
	
	function make_url_for_products_tag_search($page,$container,$extension,$separator){
		if(isset($container['page']) && intval($container['page'])>1){
			return 'producttag/' . intval($container['tag_id']) .'/'.intval($container['page']).$extension;
		}else{
			return 'producttag/' . intval($container['tag_id']) .$extension;
		}
	}
	
	function make_url_for_comments_review($page,$container,$extension,$separator){
		return 'comments/'. intval($container['rid']) .$extension;
	}
	/**
	 * 
	 * @param $categories_id
	 * @param $extension
	 * @param $separator
	 * @todo make url for categories
	 */
	function make_url_for_search($page,$container,$extension,$separator){
				  $join_char = '&';
				  $securityToken = 'searchSubmit=Search';
				  $param = '&';
				foreach ($container as $key => $value){

						if (zen_not_null($key)){
							switch ($key){
								case 'page':
									$url_page_part = 'page='.$value.$param;
									break;
								case 'sort_order':
									$url_sort_part = 'sort_order='.$value.$param;
									break;
								case 'keyword':
								//$value = str_replace(' ', '-', $value);
									$url_categories_part = 'keyword/'.$value.$join_char;
									break;
                                case 'Popular_id':
                                    //$value = str_replace(' ', '-', $value);
                                    $url_categories_part = 'Popular_id/'.$value.$join_char;
                                    break;
								case 'narrow':
									array_unique($value);
									ksort($value);
									$narrow_index=0;
									foreach ($value as $i => $vID){
										$url_narrow_by_part .= $this->strip($this->get_narrow_by_option_value_name($vID)).'='.$vID.$param;
										$narrow_index++;
									}
									break;
								case 'style':
									$url_display_type_part = 'style='.$value.$param;
									break;
									
								case 'count':
									$url_display_count_part = 'count='.$value.$param;
									break;
									break;																								
									
							}
						}
					}

			$url .= $url_categories_part;
			if ($url_sort_part) $url .=$url_sort_part;
			if ($url_display_type_part) $url .=$url_display_type_part;
			if ($url_pagesize_part) $url .=$url_pagesize_part;
			if ($url_display_count_part) $url .=$url_display_count_part;
			if ($url_display_settab_part) $url .=$url_display_settab_part;
			
			if ($url_narrow_by_part) $url .=$url_narrow_by_part;
						
			if ($url_page_part) $url .=$url_page_part;
			if ($securityToken) $url .=$securityToken;
			else if('/'==substr($url, -1,1))
			$url = substr($url,0,strrpos($url,'/'));
			return $url;
	}

	function make_url_for_popular_detail($page,$container,$extension= '.html',&$separator){
	  $url = '';
	  foreach ($container as $key=>$value){
	    if (zen_not_null($key)){
	      switch ($key){
	        case 'Popular_id':
	          $tag_keyword = $this->get_popular_name($value);
	          if($url ==''){
	            $url .= $tag_keyword.'-po-'.$value;
	          }else{
	            $url =$tag_keyword.'-po-'.$value.$url;
	          }
	          break;
	        case 'page':
	          if($value>1){
	          $url .= '/'.$value;
	          }
	          break;
	        case 'count':
	          if(preg_match('/\/[0-9]+/i',$url)){
	            $url = '/c-'.$value.$url;
	          }else{
	            $url .='/c-'.$value;
	          }
	          break;
          case 'narrow':
            array_unique($value);
            ksort($value);
            foreach ($value as $i => $vID){
              if($i==0){
                $narrow_url .= 'screen/'.$vID;
              }else{
                $narrow_url .= '-'.$vID;
              }
            }
            break;
	      }
	    }
	  }
	  $url.=$extension;
	  if($narrow_url) $url = $narrow_url.'/'.$url;
	  return $url;
	}

	function make_url_for_clearance($page,$container,$extension= '.html',&$separator){
        $url = '';
        $url_sort_part = '';
        $url_page_part ='';
        $url_narrow_by_part = '';
        $url_display_type_part = '';
        $url_display_get_qty_part = '';
        if (!zen_not_null($extension)) $extension = '.html';
        if(sizeof($container) > 2){
            $join_char = '?';
            $securityToken = '';
        }else{
            $join_char = '';
            $securityToken = '';
        }
        $param = '&';
        foreach ($container as $key => $value){
            //var_dump($container);
            if (zen_not_null($key)){
                switch ($key){
                    case 'page':
                        $url_page_part = 'page='.$value.$param;
                        break;
                    case 'sort_order':
                        $url_sort_part = 'sort_order='.$value.$param;
                        break;
                    case 'narrow':
                        array_unique($value);
                        //asort($value);
                        $narrow_index=0;
                        foreach ($value as $i => $vID){
                            $url_narrow_by_part .= $this->strip($this->get_narrow_by_option_value_name($vID)).'='.$vID.$param;
                            $narrow_index++;
                        }
                        break;
                    case 'type':
                        $url_display_type_part = $this->get_clearance_name((int)$value).'-'.$value.$join_char;
                        break;
                    case 'settab':
                        $url_display_settab_part = 'settab='.$value.$param;
                        break;
                }
            }
        }
        $url = FILENAME_CLEARANCE_LIST.'/';
        if ($url_display_type_part) $url .=$url_display_type_part;
        if ($url_sort_part) $url .=$url_sort_part;
        if ($url_display_settab_part) $url .=$url_display_settab_part;
        if ($url_narrow_by_part) $url .=$url_narrow_by_part;
        if ($url_page_part) $url .=$url_page_part;
        else if('/'==substr($url, -1,1))
            $url = substr($url,0,strrpos($url,'/'));
        $url = trim($url,'&');
        return $url;
    }

	function make_url_for_categories($page,$container,$extension= '.html',&$separator){
		
		$url = '';
		$url_categories_part = '';
		$url_sort_part = '';
		$url_pagesize_part = '';
		$url_page_part ='';
		$url_narrow_by_part = '';
		$url_display_type_part = '';
        $url_display_get_qty_part = '';
		if (!zen_not_null($extension)) $extension = '.html';
		$sub_arr = array();
		zen_get_subcategories_redis($sub_arr,209);
		$sub_arr[] = 209;
		
		switch ($page){
            case FILENAME_DOWNLOAD:
			case FILENAME_DEFAULT:
		        if(sizeof($container) > 2){
				  $join_char = '?';
				  if(in_array($container['cPath'],$sub_arr)){
					$securityToken = '';
				  }else{
					//$securityToken = '_requestConfirmationToken='.$_SESSION['securityToken'];
                      $securityToken = '';
				  }
				}else{
				  $join_char = '';
				  $securityToken = '';
				}
				  $param = '&';
				foreach ($container as $key => $value){

						if (zen_not_null($key)){
							switch ($key){
								case 'pagesize':
									$url_pagesize_part = 'pagesize_'.$value.$param;
									break;
								case 'page':
									$url_page_part = 'page='.$value.$param;
									break;
								case 'sort_order':
									$url_sort_part = 'sort_order='.$value.$param;
									break;
								case 'cPath':
									$compatible_url = $this->get_category_compatible_url((int)$value);
									
									if (zen_not_null($compatible_url) ){
										if (!is_integer($value) && strstr($value,'_')) {
											$value = substr($value, (strrpos($value, '_')+1));
										}
										$url_categories_part = 'c/'.$compatible_url.'-'.$value.$join_char;
									}else {
										if (!is_integer($value) && strstr($value,'_')) {
											$value = substr($value, (strrpos($value, '_')+1));
										}
										$url_categories_part = 'c/'.$this->get_fiberstore_categories_name($value).'-'.$value.$join_char;
									}
									if($page == FILENAME_DOWNLOAD){
                                        $url_categories_part = FILENAME_DOWNLOAD.'/'.$url_categories_part;
                                    }
									break;
								case 'narrow':
									array_unique($value);
									asort($value);
									$narrow_index=0;
									foreach ($value as $i => $vID){
										$url_narrow_by_part .= $this->strip($this->get_narrow_by_option_value_name($vID)).'='.$vID.$param;
										$narrow_index++;
									}
									break;
								case 'type':
									$url_display_type_part = 'type='.$value.$param;
									break;
									
								case 'count':
									$url_display_count_part = 'count='.$value.$param;
									break;										
								case 'settab':
									$url_display_settab_part = 'settab='.$value.$param;
									break;
                                case 'get_qty':
                                    $url_display_get_qty_part = 'get_qty='.$value.$param;
                                    break;
                            }
						}
					}

			//target url like www.fiberstore.com/size_v12+size_v13/color_v22/transceiver-option-products_c12//2.html
			$url .= $url_categories_part;
			if ($url_sort_part) $url .=$url_sort_part;
			if ($url_display_type_part) $url .=$url_display_type_part;
			if ($url_pagesize_part) $url .=$url_pagesize_part;
			if ($url_display_count_part) $url .=$url_display_count_part;
			if ($url_display_settab_part) $url .=$url_display_settab_part;
            if ($url_display_get_qty_part) $url .=$url_display_get_qty_part;
			if ($url_narrow_by_part) $url .=$url_narrow_by_part;
						
			if ($url_page_part) $url .=$url_page_part;
			if ($securityToken) $url .=$securityToken;
			else if('/'==substr($url, -1,1))
			$url = substr($url,0,strrpos($url,'/'));
			$url = trim($url,'&');
			
			break;

			case FILENAME_NARROW:
				foreach ($container as $key => $value){
						if (zen_not_null($key)){
							switch ($key){
								case 'pagesize':
									$url_pagesize_part = 'pagesize_'.$value.'/';
									break;
								case 'page':
									$url_page_part = $value.$extension;
									break;
								case 'sort_order':
									$url_sort_part = 'sort-order_'.$value.'/';
									break;

								case 'cPath':
									$compatible_url = $this->get_category_compatible_url($value);
									if (zen_not_null($compatible_url)) {
										$url_categories_part = $compatible_url.'-'.$value.'/';
									}else
										$url_categories_part = $this->get_fiberstore_categories_name($value).'-'.$value.'/';
									break;
								case 'keyword':
									
									if($value){
										$url_keyword_part = $value.'_search/';
									}
									
									break;
								
								case 'type':
									$url_display_type_part = 'type_'.$value.'/';
									break;
								case 'narrow':
									//processing the narrow by params
									array_unique($value);
									ksort($value);
									
									$narrow_index=0;
									
									foreach ($value as $i => $vID){
										$url_narrow_by_part.= $this->strip($this->get_narrow_by_option_value_name($vID)).'_'.$vID.'/';
										$narrow_index++;
									}
									break;
								case 'count':
									$url_display_count_part = 'count-'.$value.'/';
									break;										
								case 'settab':
									$url_display_settab_part = 'settab_'.$value.'/';
									break;
                                case 'get_qty':
                                    $url_display_get_qty_part = 'get_qty-'.$value.'/';
                                    break;
									
							}
						}
					}

				//target url like www.fiberstore.com/size_v12+size_v13/color_v22/transceiver-option-products_c12//2.html
				$url .= 'narrow/';
				if($url_narrow_by_part)$url.=$url_narrow_by_part;
				if($url_keyword_part)$url.=$url_keyword_part;
				$url .= $url_categories_part;
				if ($url_sort_part) $url .=$url_sort_part;

				if ($url_display_count_part) $url .=$url_display_count_part;
				if ($url_display_settab_part) $url .=$url_display_settab_part;
                if ($url_display_get_qty_part) $url .=$url_display_get_qty_part;
				if ($url_display_type_part) $url .=$url_display_type_part;
				if ($url_pagesize_part) $url .=$url_pagesize_part;
				if ($url_page_part) $url .=$url_page_part;
				else 
				$url = substr($url,0,strrpos($url,'/'));
				break;
		}
		
		
		$separator = '&';
		return $url;
		
	}
	/**
	 * 
	 * @param string $page
	 * @param array $container
	 * @param string $extension
	 * @param string $separator
	 */
		function  make_url_for_tag_support_detail($page,$container,$extension= '.html',&$separator){
	  		$url = '';
		$url_categories_part = '';
		$url_sort_part = '';
		$url_pagesize_part = '';
		$url_page_part ='';
		$url_narrow_by_part = '';
		$url_display_type_part = '';
		if (!zen_not_null($extension)) $extension = '.html';
					foreach ($container as $key => $value){
						if (zen_not_null($key)){
							switch ($key){
								case 'supportid':
										if (!is_integer($value) && strstr($value,'_')) {
											$value = substr($value, (strrpos($value, '_')+1));
										}
										$url_categories_part = 'support/'.$this->get_support_detail($value).'-'.$value.'/';
									
									break;
	
							}
						}
					}

			$url .= $url_categories_part;
			if ($url_sort_part) $url .=$url_sort_part;
			if ($url_display_type_part) $url .=$url_display_type_part;
			if ($url_pagesize_part) $url .=$url_pagesize_part;
						
			if ($url_display_count_part) $url .=$url_display_count_part;
			if ($url_display_settab_part) $url .=$url_display_settab_part;
						
			if ($url_page_part) $url .=$url_page_part;
			else if('/'==substr($url, -1,1))
			$url = substr($url,0,strrpos($url,'/'));
			$separator = '&';
		return $url;
	}
	
	//support下stock_list模块地址优化  fallwind  2017.1.11
	function  make_url_for_tag_support_stock_list($page,$container,$extension= '.html',&$separator){
	  	$url = '';
		$url_categories_part = '';
		$url_sort_part = '';
		$url_pagesize_part = '';
		$url_page_part ='';
		$url_narrow_by_part = '';
		$url_display_type_part = '';
		if (!zen_not_null($extension)) $extension = '.html';
		
		foreach ($container as $key => $value){
			if(zen_not_null($key)){
				switch ($key){
					case 'a_id':
							if(!is_integer($value) && strstr($value,'_')) {
								$value = substr($value, (strrpos($value, '_')+1));
							}
							$url_categories_part = 'support/stock-list/'.$this->get_support_stock_list($value).'-'.$value.'/';							
					break;
				}
			}
		}

		$url .= $url_categories_part;
		if ($url_sort_part) $url .=$url_sort_part;
		if ($url_display_type_part) $url .=$url_display_type_part;
		if ($url_pagesize_part) $url .=$url_pagesize_part;
					
		if ($url_display_count_part) $url .=$url_display_count_part;
		if ($url_display_settab_part) $url .=$url_display_settab_part;
					
		if ($url_page_part) $url .=$url_page_part;
		else if('/'==substr($url, -1,1))
		$url = substr($url,0,strrpos($url,'/'));
		$separator = '&';
		return $url;
	}

	function make_url_for_fiber_transceivers($page,$container,$extension= '.html',&$separator){
		$url = '';
		$url_categories_part = '';
		$url_sort_part = '';
		$url_pagesize_part = '';
		$url_page_part ='';
		$url_narrow_by_part = '';
		$url_display_type_part = '';
		if (!zen_not_null($extension)) $extension = '.html';
					foreach ($container as $key => $value){
						if (zen_not_null($key)){
							switch ($key){
								case 'brand':
										if (!is_integer($value) && strstr($value,'_')) {
											$value = substr($value, (strrpos($value, '_')+1));
										}
										$url_categories_part = 'finder/all-'.$value.'-transceivers';
									
									break;
	
							}
						}
					}

			$url .= $url_categories_part;
			if ($url_sort_part) $url .=$url_sort_part;
			if ($url_display_type_part) $url .=$url_display_type_part;
			if ($url_pagesize_part) $url .=$url_pagesize_part;
						
			if ($url_display_count_part) $url .=$url_display_count_part;
			if ($url_display_settab_part) $url .=$url_display_settab_part;
						
			if ($url_page_part) $url .=$url_page_part;
			else if('/'==substr($url, -1,1))
			$url = substr($url,0,strrpos($url,'/'));
			$separator = '&';
		return $url;
	}
	
	function make_url_for_tag_categories($page,$container,$extension= '.html',&$separator){
		$url = '';
		$url_categories_part = '';
		$url_sort_part = '';
		$url_pagesize_part = '';
		$url_page_part ='';
		$url_narrow_by_part = '';
		$url_display_type_part = '';
		if (!zen_not_null($extension)) $extension = '.html';
				  if(sizeof($container) > 2){
				  $join_char = '?';
				  $securityToken = '_requestConfirmationToken='.$_SESSION['securityToken'];
				           $securityToken = '';
				  }else{
				  $join_char = '';
				  $securityToken = '';
				  }
				  $param = '&';
					foreach ($container as $key => $value){
						if (zen_not_null($key)){
							switch ($key){
								case 'pagesize':
									$url_pagesize_part = 'pagesize_'.$value.$param;
									break;
								case 'page':
									$url_page_part = $value.$extension;
									break;
								case 'sort_order':
									$url_sort_part = 'sort-order_'.$value.$param;
									break;
								case 'tag':
										if (!is_integer($value) && strstr($value,'_')) {
											$value = substr($value, (strrpos($value, '_')+1));
										}
										$url_categories_part = 'finder/'.$this->fs_tag_categories_name($value).'-'.$value.$join_char;
									break;
								case 'narrow':
									array_unique($value);
									ksort($value);
									$narrow_index=0;
									foreach ($value as $i => $vID){
										$url_narrow_by_part.= $this->strip($this->get_narrow_by_option_value_name($vID)).'='.$vID.$param;
										$narrow_index++;
									}
									break;	
								case 'type':
									$url_display_type_part = 'type_'.$value.$param;
									break;
									
								case 'count':
									$url_display_count_part = 'count-'.$value.$param;
									break;										
								case 'settab':
									$url_display_settab_part = 'settab_'.$value.$param;
									break;
                                case 'get_qty':
                                    $url_display_get_qty_part = 'get_qty-'.$value.$param;
                                    break;
							}
						}
					}

			//target url like www.fiberstore.com/size_v12+size_v13/color_v22/transceiver-option-products_c12//2.html
			$url .= $url_categories_part;
			if ($url_sort_part) $url .=$url_sort_part;
			if ($url_display_type_part) $url .=$url_display_type_part;
			if ($url_pagesize_part) $url .=$url_pagesize_part;

			if ($url_display_count_part) $url .=$url_display_count_part;
			if ($url_display_settab_part) $url .=$url_display_settab_part;
            if ($url_display_get_qty_part) $url .=$url_display_get_qty_part;
			if ($url_narrow_by_part) $url .=$url_narrow_by_part;			
			if ($url_page_part) $url .=$url_page_part;
			if ($securityToken) $url .=$securityToken;
			else if('/'==substr($url, -1,1))
			$url = substr($url,0,strrpos($url,'/'));
			$separator = '&';
		return $url;
	}
	function make_url_for_con_categories($page,$container,$extension= '.html',&$separator){
		$url = '';
		$url_categories_part = '';
		$url_sort_part = '';
		$url_pagesize_part = '';
		$url_page_part ='';
		$url_narrow_by_part = '';
		$url_display_type_part = '';
		if (!zen_not_null($extension)) $extension = '.html';
					foreach ($container as $key => $value){
						if (zen_not_null($key)){
							switch ($key){
								case 'pagesize':
									$url_pagesize_part = 'pagesize_'.$value.'/';
									break;
								case 'page':
									$url_page_part = $value.$extension;
									break;
								case 'sort_order':
									$url_sort_part = 'sort-order_'.$value.'/';
									break;
//								case in_array($key,range('a','z')):
//									$narrow_by_get_params[$key] = $value;
//									break;
							
								case 'con':
										if (!is_integer($value) && strstr($value,'_')) {
											$value = substr($value, (strrpos($value, '_')+1));
										}
										//$url_categories_part = 'fiber/'.$this->fs_con_categories_name($value).'-'.$value;
										$url_categories_part = 'fiber-'.$this->fs_con_categories_name($value).'-'.$value;
									
						
									
									break;
								case 'type':
									$url_display_type_part = 'type_'.$value.'/';
									break;
									
								case 'count':
									$url_display_count_part = 'count-'.$value.'/';
									break;										
								case 'settab':
									$url_display_settab_part = 'settab_'.$value.'/';
									break;
                                case 'get_qty':
                                    $url_display_get_qty_part = 'get_qty-'.$value.'/';
                                    break;
							}
						}
					}

			//target url like www.fiberstore.com/size_v12+size_v13/color_v22/transceiver-option-products_c12//2.html
			$url .= $url_categories_part;
			if ($url_sort_part) $url .=$url_sort_part;
			if ($url_display_type_part) $url .=$url_display_type_part;
			if ($url_pagesize_part) $url .=$url_pagesize_part;
						
			if ($url_display_count_part) $url .=$url_display_count_part;
			if ($url_display_settab_part) $url .=$url_display_settab_part;
            if ($url_display_get_qty_part) $url .=$url_display_get_qty_part;
			if ($url_page_part) $url .=$url_page_part;
			else if('/'==substr($url, -1,1))
			$url = substr($url,0,strrpos($url,'/'));
			$separator = '&';
		return $url;
	}
	
	function fs_tag_categories_name($id){
	    $sql = "select tag_name from meta_tags_of_search_categories where tag_categories_id ='". $id ."' and language_id =".$_SESSION['languages_id']." ";
		$result = $this->db->Execute($sql);
				$pName = 'transceiver-for-'.$this->strip($result->fields['tag_name']);
				$pName = trim($pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("=", "-", $pName);
				$pName = str_replace("®", "-", $pName);
				$pName = str_replace("™", "-", $pName);
				$pName = str_replace(" ", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = trim($pName,"-");  //去掉首尾两端的-
				$pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }

				$pName = $this->strip_special_characters($pName);
				$this->cache['TAG_CATEGORIES'][$id] = $pName;
				$pName = strtolower($pName);
		return 	$pName;	
	}

	function fs_con_categories_name($id){
	    $sql = "select connector from connectors where id ='". $id ."' ";
		$result = $this->db->Execute($sql);
				$pName = $this->strip($result->fields['connector']);
				$pName = trim($pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("=", "-", $pName);
				$pName = str_replace("®", "-", $pName);
				$pName = str_replace("™", "-", $pName);
				$pName = str_replace(" ", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = trim($pName,"-");  //去掉首尾两端的-
				$pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }

				$pName = $this->strip_special_characters($pName);
				$this->cache['TAG_CATEGORIES'][$id] = $pName;
				$pName = strtolower($pName);
		return 	$pName;	
	
}
	
	function make_url_for_news($page,$container,$extension= '.html',&$separator){
		
		$url = '';
		$page_id = (int)$container['page'];
        $tag_id =(int)$container['tag'];
        if (zen_not_null($page_id)){
            if (1< $page_id){
                if (1< $tag_id){
                    $url = 'news/'.$page_id.$extension."?tag=".$tag_id;
                }else{
                    $url = 'news/'.$page_id.$extension;
                }
            }else{
                if (1<$tag_id){
                    $url = 'news'.$extension."?tag=".$tag_id;
                }else{
                    $url = 'news'.$extension;
                }
            }
        }else{
            if (1<$tag_id){
                $url = 'news'.$extension."?tag=".$tag_id;
            }else{
                $url = 'news'.$extension;
            }
        }
		$separator = '&';
		return $url;
		
	}
	
	function make_url_for_nae($page,$container,$extension= '.html',&$separator){
	
		$url = '';
		$page_id = (int)$container['page'];
		if (zen_not_null($page_id)){
			if (1< $page_id)
				$url = $page.'/'.$page_id.$extension;
			else $url = $page.'/';
		}
		$separator = '&';
		return $url;
	
	}	
	
	function get_info_manager_page_name($pages_id) {
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('INFO_MANAGER_PAGE_NAME_' . $pages_id)):
				$return = constant('INFO_MANAGER_PAGE_NAME_' . $pages_id);
				$this->cache['INFO_MANAGER_PAGES'][$pages_id] = $return;
				break;

			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['INFO_MANAGER_PAGES'][$pages_id])):
				$return = $this->cache['INFO_MANAGER_PAGES'][$pages_id];
				break;

			default:
				$sql = "SELECT pages_title
						FROM " . TABLE_INFO_MANAGER . "
						WHERE pages_id = " . (int)$pages_id . "
						LIMIT 1";
				$result = $this->db->Execute($sql);
				$pages_title = $this->strip($result->fields['pages_title']);
				$this->cache['INFO_MANAGER_PAGES'][$pages_id] = $pages_title;
				$return = $pages_title;
				break;
		}
		return $return;
	}

	function get_news_article_name($article_id) {
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('NEWS_ARTICLE_NAME_' . $article_id)):
				$return = constant('NEWS_ARTICLE_NAME_' . $article_id);
				$this->cache['NEWS_ARTICLES'][$article_id] = $return;
				break;

			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['NEWS_ARTICLES'][$article_id])):
				$return = $this->cache['NEWS_ARTICLES'][$article_id];
				break;

			default:
			   /*新闻文章特殊处理  自定义链接
			    * 先查询news_link 字段  如果存在 则用自定义链接 否则用news_article_name
			    * */

			   $news_link_arr= $this->db->getAll("SELECT news_link
						FROM " . TABLE_NEWS_ARTICLES_TEXT . "
						WHERE article_id = " . (int)$article_id . "
						AND language_id = " . (int)$this->languages_id . "
						LIMIT 1");
			   $news_link = $news_link_arr[0]['news_link'];
			   if($news_link){
                   $news_article_name = $this->strip($news_link);
               }else{
                   $sql = "SELECT news_article_name
						FROM " . TABLE_NEWS_ARTICLES_TEXT . "
						WHERE article_id = " . (int)$article_id . "
						AND language_id = " . (int)$this->languages_id . "
						LIMIT 1";
                   $result = $this->db->Execute($sql);
                   $news_article_name = $this->strip($result->fields['news_article_name']);
               }
				$news_article_name = str_replace(array('?','&','+','.',',','%','!'), '', $news_article_name);
				$news_article_name = clear_chinesechar($news_article_name);
			    if(substr($news_article_name, 0, 1 ) == '-'){
			       $news_article_name =  substr($news_article_name,1,(strlen($news_article_name)-1));
			     }
				$this->cache['NEWS_ARTICLES'][$article_id] = $news_article_name;
				$news_article_name = strtolower($news_article_name);
				$return = $news_article_name;
				break;
		}
		return $return;
	}

/**
 * Function to get the product name. Use evaluated cache, per page cache, or database query in that order of precedent
 * @author Bobby Easland
 * @version 1.1
 * @param integer $pID
 * @return string Stripped anchor text
 */
		function get_popular_name($pid){
			switch(true){

			default:
              $sql = "select tag_keywords from products_tags where products_tag ='". $pid ."' LIMIT 1";
				$result = $this->db->Execute($sql);
				
				$pName = $this->strip($result->fields['tag_keywords']);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace("～", "-", $pName);
				$pName = str_replace(" ", "-", $pName);
				
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("--", "-", $pName);
			    $pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }
			    $pName = str_replace("--", "-", $pName);  //replace '--' to '-'
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
	function get_product_name($pID){

		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('PRODUCT_NAME_' . $pID)):
				$return = constant('PRODUCT_NAME_' . $pID);
				$this->cache['PRODUCTS'][$pID] = $return;
				break;

			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['PRODUCTS'][$pID])):
				$return = $this->cache['PRODUCTS'][$pID];
				break;

			default:
				$sql = "SELECT products_name as pName,products_name_url as uname
						FROM " . TABLE_PRODUCTS_DESCRIPTION . "
						WHERE products_id = " . (int)$pID . "
						AND language_id = " . (int)$this->languages_id . "
						LIMIT 1";
				$result = $this->db->Execute($sql);
				if($result->fields['uname']){
				$pName = $this->strip($result->fields['uname']);
				}else{
				$pName = $this->strip($result->fields['pName']);
				}
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("=", "-", $pName);
				$pName = str_replace("®", "-", $pName);
				$pName = str_replace("™", "-", $pName);
				
				$regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
				$keyword = preg_replace($regex,'-',$pName);

				$pName = str_replace(" ", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				
				$pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }
				
//				$pName = $result->fields['pName'];
				$pName = $this->strip_special_characters($pName);
				$this->cache['PRODUCTS'][$pID] = $pName;
				$pName = str_replace("--", "-", $pName);  //replace '--' to '-'
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	} # end function

	function get_product_name_of_review($pID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('PRODUCT_NAME_' . $pID)):
				$return = constant('PRODUCT_NAME_' . $pID);
				$this->cache['PRODUCTS'][$pID] = $return;
				break;

			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['PRODUCTS'][$pID])):
				$return = $this->cache['PRODUCTS'][$pID];
				break;

			default:
				$sql = "SELECT products_name as pName
						FROM " . TABLE_PRODUCTS_DESCRIPTION . "
						WHERE products_id = " . (int)$pID . "
						AND language_id = " . (int)$this->languages_id . "
						LIMIT 1";
				$result = $this->db->Execute($sql);
				$pName = $this->strip($result->fields['pName']);
				$pName = 'review/'.$pName;
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("&", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace(" ", "-", $pName);
				$pName = str_replace("--", "-", $pName);
			    $pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }
				$pName = $this->strip_special_characters($pName);
				$this->cache['PRODUCTS'][$pID] = $pName;
				$pName = str_replace("--", "-", $pName); 
				$pName = strtolower($pName); 
				$return = $pName;
				break;
		} # end switch
		return $return;
	} # end function
	
	function get_tutorail_list($cID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['TUTORIAL_LIST'][$cID])):
				$return = $this->cache['TUTORIAL_LIST'][$cID];
				break;

			default:
				$sql = "SELECT doc_categories_name as cName
						FROM " . TABLE_DOC_CATEGORIES_DESCRIPTION . "
						WHERE doc_categories_id = " . (int)$cID . " AND language_id = '" . $_SESSION['languages_id'] . "'
						LIMIT 1";
				$result = $this->db->Execute($sql);
//				$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&'), '', $result->fields['cName']);
				$pName = str_replace(" ", "-", $pName);
				$this->cache['TUTORIAL_LIST'][$cID] = $pName;
				$pName = str_replace("/", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace(",", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	function get_tutorail_detail($aID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['TUTORIAL_DETAIL'][$aID])):
				$return = $this->cache['TUTORIAL_DETAIL'][$aID];
				break;

			default:
				//由于uk au de/en 误操作 自己新增了一些文章 导致需要单独进行获取
				if(in_array((int)$aID,array(1055,1056,1057,1058,1059,1060,1061,1062,1063)) && in_array($_SESSION['languages_code'],array('au','uk','dn'))){
					$sql = "SELECT doc_article_title as tName,doc_article_url as url
					FROM " . TABLE_DOC_ARTICLE_DESCRIPTION . "
					WHERE doc_article_id = " . (int)$aID . " AND language_id = " . $_SESSION['languages_id'] . "  
					LIMIT 1";	
				}else{
					//教程详情链接统一调取英文站，小语种的title翻译后是对应小语种语言会有问题
					$sql = "SELECT doc_article_title as tName,doc_article_url as url
					FROM " . TABLE_DOC_ARTICLE_DESCRIPTION . "
					WHERE doc_article_id = " . (int)$aID . " AND language_id = 1 
					LIMIT 1";
				}
				$result = $this->db->Execute($sql);
				if($result->fields['url']){
				$pName = $this->strip($result->fields['url']);
				}else{
				$pName = $this->strip($result->fields['tName']);
				}
				//$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&','(',')'), '', $pName);
				$pName = str_replace(" ", "-", $pName);
				$this->cache['TUTORIAL_DETAIL'][$aID] = $pName;
				$pName = str_replace("/", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace(",", "-", $pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
			    $pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }
			    
			    $pName = strtolower($pName);
			    
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
   function get_popular_list($cID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['PRODUCT_LIST'][$cID])):
				$return = $this->cache['PRODUCT_LIST'][$cID];
				break;

			default:
				$sql = "SELECT tag_name as cName
						FROM products_tag_type
						WHERE tag_id = " . (int)$cID . "
						";
				$result = $this->db->Execute($sql);
				$pName = $result->fields['cName'];
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("&", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace(" ", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$this->cache['PRODUCT_LIST'][$cID] = $pName;
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
	//solution
   function get_solution_list($cID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['SOLUTION_LIST'][$cID])):
				$return = $this->cache['SOLUTION_LIST'][$cID];
				break;

			default:
				$sql = "SELECT doc_categories_name as cName
						FROM " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . "
						WHERE doc_categories_id = " . (int)$cID . " and language_id=1 
						LIMIT 1";
				$result = $this->db->Execute($sql);
//				$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&'), '', $result->fields['cName']);
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("&", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace(" ", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$this->cache['SOLUTION_LIST'][$cID] = $pName;
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
	
	
    function get_solution_detail($sID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['SOLUTION_DETAIL'][$sID])):
				$return = $this->cache['SOLUTION_DETAIL'][$sID];
				break;

			default:
				$sql = "SELECT doc_article_title as tName,doc_article_url as url
						FROM " . TABLE_SOLUTION_ARTICLE_DESCRIPTION . "
						WHERE doc_article_id = " . (int)$sID . " and language_id = ".$_SESSION['languages_id']."
						LIMIT 1";
				$result = $this->db->Execute($sql);
                if($result->fields['url']){
                    $pName = $this->strip($result->fields['url']);
                }else{
                    $pName = $this->strip($result->fields['tName']);
                }
				//$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&','-','/'), ' ', $pName);
                $pName = preg_replace('/(\s)+/', ' ', $pName);
                $pName = str_replace(".", "-", $pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("+", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = strtolower(str_replace(" ", "-", $pName));
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("---", "-", $pName);
				$pName = str_replace("--", "-", $pName);
			    $pName = clear_chinesechar($pName);
			    if(substr($pName, 0, 1 ) == '-'){
			       $pName =  substr($pName,1,(strlen($pName)-1));
			     }
				$this->cache['SOLUTION_DETAIL'][$sID] = $pName;
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
	//support
		function get_support_detail($aID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['SUPPORT_DETAIL'][$aID])):
				$return = $this->cache['SUPPORT_DETAIL'][$aID];
				break;
	
			default:
				$sql = "SELECT support_articles_title as cName
						FROM " . TABLE_SUPPORT_ARTICLES_DESCRIPTION . "
						WHERE support_articles_id = " . (int)$aID . " and language_id = 1
						LIMIT 1";
				$result = $this->db->Execute($sql);
				//				$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&',','), '', $result->fields['cName']);
				$pName = $this->strip(str_replace(" ", "-", $pName));
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$this->cache['SUPPORT_DETAIL'][$aID] = $pName;
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
	//support下stock_list模块地址优化  fallwind  2017.1.11
	function get_support_stock_list($aID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['support_stock_list'][$aID])):
				$return = $this->cache['support_stock_list'][$aID];
				break;
	
			default:
				$sql = "SELECT f_title as cName FROM doc_support_stock_list
						WHERE a_id = " . (int)$aID . " and language_id = 1
						LIMIT 1";
				$result = $this->db->Execute($sql);
				//$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&',','), '', $result->fields['cName']);
				$pName = $this->strip(str_replace(" ", "-", $pName));
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$this->cache['support_stock_list'][$aID] = $pName;
				$pName = strtolower($pName);
				$return = $pName;
				break;
		} # end switch
		return $return;
	}

		//in the news ********************************
	function get_news_date($nDate){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['IN_THE_NEWS'][$nDate])):
				$return = $this->cache['IN_THE_NEWS'][$nDate];
				break;

			default:
				$sql = "SELECT date_format(in_the_news_time,'%Y') nDate 
						FROM in_the_news
						WHERE date_format(in_the_news_time,'%Y') = " . $nDate . "
						LIMIT 1";
				$result = $this->db->Execute($sql);
				//$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&'), '', $result->fields['nDate']);
				$pName = str_replace(".", "-", $pName);
				$pName = str_replace("µ", "u", $pName);
				$pName = str_replace("μm", "um", $pName);
				$pName = str_replace("μ", "u", $pName);
				$pName = str_replace("”", "-", $pName);
				$pName = str_replace("＂", "-", $pName);
				$pName = str_replace("±", "-", $pName);
				$pName = str_replace("–", "-", $pName);
				$pName = str_replace("(", "-", $pName);
				$pName = str_replace(")", "-", $pName);
				$pName = str_replace("×", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				$pName = str_replace("--", "-", $pName);
				
				$this->cache['IN_THE_NEWS'][$nDate] = $pName;
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	//************events news releases***************
	function get_events_date($nDate){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['IN_THE_NEWS'][$nDate])):
				$return = $this->cache['IN_THE_NEWS'][$nDate];
				break;

			default:
				$sql = "SELECT date_format(news_date_published,'%Y') nDate 
						FROM news_articles
						WHERE date_format(news_date_published,'%Y') = " . $nDate . "
						LIMIT 1";
				$result = $this->db->Execute($sql);
				//$pName = $this->strip($result->fields['pName']);
				$pName = str_replace(array('?','&'), '', $result->fields['nDate']);
				$pName = str_replace(" ", "-", $pName);
				$this->cache['IN_THE_NEWS'][$nDate] = $pName;
				$return = $pName;
				break;
		} # end switch
		return $return;
	}
	
/**
 * Function to get the category name. Use evaluated cache, per page cache, or database query in that order of precedent
 * @author Bobby Easland
 * @version 1.1
 * @param integer $cID NOTE: passed by reference
 * @return string Stripped anchor text
 */
	function get_category_name(&$cID){
		$full_cPath = $single_cID =  $cID;//$this->get_full_cPath($cID, $single_cID); // full cPath needed for uniformity
		$single_cID  = (strpos($cID,'_') ? substr($cID,strrpos($cID,'_')+1) : $cID);
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('CATEGORY_NAME_' . $full_cPath)):
				$return = constant('CATEGORY_NAME_' . $full_cPath);
				$this->cache['CATEGORIES'][$full_cPath] = $return;
				break;
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['CATEGORIES'][$full_cPath])):
				$return = $this->cache['CATEGORIES'][$full_cPath];
				break;
			default:
				switch(true){
					case ($this->attributes['SEO_ADD_CAT_PARENT'] == 'true'):
						$sql = "SELECT c.categories_id, c.parent_id, cd.categories_name as cName, cd2.categories_name as pName
								FROM ".TABLE_CATEGORIES_DESCRIPTION." cd, ".TABLE_CATEGORIES." c
								LEFT JOIN ".TABLE_CATEGORIES_DESCRIPTION." cd2
								ON c.parent_id=cd2.categories_id AND cd2.language_id='".(int)$this->languages_id."'
								WHERE c.categories_id='".(int)$single_cID."'
								AND cd.categories_id='".(int)$single_cID."'
								AND cd.language_id='".(int)$this->languages_id."'
								LIMIT 1";
						$result = $this->db->Execute($sql);
						$cName = $this->not_null($result->fields['pName']) ? $result->fields['pName'] . ' ' . $result->fields['cName'] : $result->fields['cName'];
						break;
					default:
						$sql = "SELECT categories_name as cName
								FROM ".TABLE_CATEGORIES_DESCRIPTION."
								WHERE categories_id='".(int)$single_cID."'
								AND language_id='".(int)$this->languages_id."'
								LIMIT 1";
						$result = $this->db->Execute($sql);
						$cName = $result->fields['cName'];
						break;
				}
//				$cName = $this->strip($cName);
				$cName = 'c/'.$cName.'_'.$single_cID;
				$this->cache['CATEGORIES'][$full_cPath] = $cName;
				$return = $cName;
				break;
		} # end switch
//		$cID = $full_cPath;
		return $return;
	} # end function

/**
 * Function to get the manufacturer name. Use evaluated cache, per page cache, or database query in that order of precedent.
 * @author Bobby Easland
 * @version 1.1
 * @param integer $mID
 * @return string
 */
	function get_manufacturer_name($mID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('MANUFACTURER_NAME_' . $mID)):
				$return = constant('MANUFACTURER_NAME_' . $mID);
				$this->cache['MANUFACTURERS'][$mID] = $return;
				break;
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['MANUFACTURERS'][$mID])):
				$return = $this->cache['MANUFACTURERS'][$mID];
				break;
			default:
		} # end switch
	} # end function

/**
 * Function to get the EZ-Pages name. Use evaluated cache, per page cache, or database query in that order of precedent.
 * @author Bobby Easland, Ronald Crawford
 * @version 1.0
 * @param integer $mID
 * @return string
 */
	function get_ezpages_name($ezpID){
		switch(true){
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && defined('EZPAGES_NAME_' . $ezpID)):
				$return = constant('EZPAGES_NAME_' . $ezpID);
				$this->cache['EZPAGES'][$ezpID] = $return;
				break;
			case ($this->attributes['USE_SEO_CACHE_GLOBAL'] == 'true' && isset($this->cache['EZPAGES'][$ezpID])):
				$return = $this->cache['EZPAGES'][$ezpID];
				break;
			default:
				$sql = "SELECT pages_title as ezpName
						FROM ".TABLE_EZPAGES."
						WHERE pages_id='".(int)$ezpID."'
						LIMIT 1";
				$result = $this->db->Execute($sql);
				$ezpName = $this->strip($result->fields['ezpName']);
				$this->cache['EZPAGES'][$ezpID] = $ezpName;
				$return = $ezpName;
				break;
		} # end switch
		return $return;
	} # end function

/**
 * Function to retrieve full cPath from category ID
 * @author Bobby Easland
 * @version 1.1
 * @param mixed $cID Could contain cPath or single category_id
 * @param integer $original Single category_id passed back by reference
 * @return string Full cPath string
 */
	function get_full_cPath($cID, &$original){
//		if ( is_numeric(strpos($cID, '_')) ){
//			$temp = @explode('_', $cID);
//			$original = $temp[sizeof($temp)-1];
//			return $cID;
//		} else {
//			$c = array();
//			$this->GetParentCategories($c, $cID);
//			$c = array_reverse($c);
//			$c[] = $cID;
//			$original = $cID;
//			$cID = sizeof($c) > 1 ? implode('_', $c) : $cID;
//			return $cID;
//		}
return $cID;
	} # end function

/**
 * Recursion function to retrieve parent categories from category ID
 * @author Bobby Easland
 * @version 1.0
 * @param mixed $categories Passed by reference
 * @param integer $categories_id
 */
	function GetParentCategories(&$categories, $categories_id) {
		$sql = "SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE categories_id = " . (int)$categories_id;

		$parent_categories = $this->db->Execute($sql);

		while (!$parent_categories->EOF) {
			if ($parent_categories->fields['parent_id'] == 0) return true;

			$categories[sizeof($categories)] = $parent_categories->fields['parent_id'];

			if ($parent_categories->fields['parent_id'] != $categories_id) {
				$this->GetParentCategories($categories, $parent_categories->fields['parent_id']);
			}

			$parent_categories->MoveNext();
		}
	}

	function not_null($value) {
		return zen_not_null($value);
	}

	function is_attribute_string($params){
		if (preg_match('/products_id=([0-9]+):([a-zA-z0-9]{32})/', $params)) {
			return true;
		}

		return false;
	}

	function is_product_string($params) {
		if (preg_match('/products_id=/i', $params)) {
			return true;
		}

		return false;
	}

	function is_cPath_string($params) {
		if (preg_match('/cPath=/i', $params)) {
			return true;
		}

		return false;
	}

/**
 * Function to strip the string of punctuation and white space
 * @author Bobby Easland
 * @version 1.1
 * @param string $string
 * @return string Stripped text. Removes all non-alphanumeric characters.
 */
	function strip($string){
		if ( is_array($this->attributes['SEO_CHAR_CONVERT_SET']) ) $string = strtr($string, $this->attributes['SEO_CHAR_CONVERT_SET']);
		$pattern = $this->attributes['SEO_REMOVE_ALL_SPEC_CHARS'] == 'true'
						?	"([^[:alnum:]])+"
						:	"([[:punct:]])+";
		
		$pattern = '/(\/|\&|\-|\*|\(|\)|\"|\'|\~|\:|([[:space:]]|[[:blank:]])+)/i';
		$anchor = trim(preg_replace($pattern, ' ', strtolower($string)));
		$pattern = "([[:space:]]|[[:blank:]])+";
		$anchor = ereg_replace($pattern, '-', $anchor);
		return $anchor;//$this->short_name($anchor); // return the short filtered name
	} # end function

/**
 * Function to expand the SEO_CONVERT_SET group
 * @author Bobby Easland
 * @version 1.0
 * @param string $set
 * @return mixed
 */
	function expand($set){
		if ( $this->not_null($set) ){
			if ( $data = @explode(',', $set) ){
				foreach ( $data as $index => $valuepair){
					$p = @explode('=>', $valuepair);
					$container[trim($p[0])] = trim($p[1]);
				}
				return $container;
			} else {
				return 'false';
			}
		} else {
			return 'false';
		}
	} # end function
/**
 * Function to return the short word filtered string
 * @author Bobby Easland
 * @version 1.0
 * @param string $str
 * @param integer $limit
 * @return string Short word filtered
 */
	function short_name($str, $limit=3){
		if ( $this->attributes['SEO_URLS_FILTER_SHORT_WORDS'] != 'false' ) $limit = (int)$this->attributes['SEO_URLS_FILTER_SHORT_WORDS'];
		$foo = @explode('-', $str);
		foreach($foo as $index => $value){
			switch (true){
				case ( strlen($value) <= $limit ):
					continue;
				default:
					$container[] = $value;
					break;
			}
		} # end foreach
		$container = ( sizeof($container) > 1 ? implode('-', $container) : $str );
		return $container;
	}

/**
 * Function to implode an associative array
 * @author Bobby Easland
 * @version 1.0
 * @param array $array Associative data array
 * @param string $inner_glue
 * @param string $outer_glue
 * @return string
 */
	function implode_assoc($array, $inner_glue='=', $outer_glue='&') {
		//$output = array();
		$output = '';
		ksort($array);
		foreach( $array as $key => $item ){
			if ( $this->not_null($key) && $this->not_null($item) ){
				$output[] = $key . $inner_glue . $item;
//				$output .= $key.'/'.$item;
			}
		} # end foreach
		return $ouput;
//		return @implode($outer_glue, $output);
	}

/**
 * Function to translate a string
 * @author Bobby Easland
 * @version 1.0
 * @param string $data String to be translated
 * @param array $parse Array of tarnslation variables
 * @return string
 */
	function parse_input_field_data($data, $parse) {
		return strtr(trim($data), $parse);
	}

/**
 * Function to output a translated or sanitized string
 * @author Bobby Easland
 * @version 1.0
 * @param string $sting String to be output
 * @param mixed $translate Array of translation characters
 * @param boolean $protected Switch for htemlspecialchars processing
 * @return string
 */
	function output_string($string, $translate = false, $protected = false) {
		if ($protected == true) {
		  return htmlspecialchars($string);
		} else {
		  if ($translate == false) {
			return $this->parse_input_field_data($string, array('"' => '&quot;'));
		  } else {
			return $this->parse_input_field_data($string, $translate);
		  }
		}
	}

/**
 * Function to generate EZ-Pages cache entries
 * @author Bobby Easland, Ronald Crawford
 * @version 1.0
 */
	function generate_ezpages_cache(){
		$this->is_cached($this->cache_file . 'ezpages', $is_cached, $is_expired);
		if ( !$is_cached || $is_expired ) {
		$sql = "SELECT pages_id as id, pages_title as name
				FROM ".TABLE_EZPAGES."
				WHERE language_id = '".(int)$this->languages_id."'";
		$ezpages = $this->db->Execute($sql);
		$ezpages_cache = '';
		while (!$ezpages->EOF) {
			$define = 'define(\'EZPAGES_NAME_' . $ezpages->fields['id'] . '\', \'' . $this->strip($ezpages->fields['name']) . '\');';
			$ezpages_cache .= $define . "\n";
			eval("$define");
			$product->MoveNext();
		}
		$this->save_cache($this->cache_file . 'ezpages', $ezpages_cache, 'EVAL', 1 , 1);
		unset($ezpages_cache);
		} else {
			$this->get_cache($this->cache_file . 'ezpages');
		}
	} # end function

/**
 * Function to generate products cache entries
 * @author Bobby Easland
 * @version 1.0
 */
	function generate_products_cache(){
		$this->is_cached($this->cache_file . 'products', $is_cached, $is_expired);
		if ( !$is_cached || $is_expired ) {
		$sql = "SELECT p.products_id as id, pd.products_name as name
		        FROM ".TABLE_PRODUCTS." p
				LEFT JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd
				ON p.products_id=pd.products_id
				AND pd.language_id='".(int)$this->languages_id."'
				WHERE p.products_status='1'";
		$product = $this->db->Execute($sql);
		$prod_cache = '';
		while (!$product->EOF) {
			$define = 'define(\'PRODUCT_NAME_' . $product->fields['id'] . '\', \'' . $this->strip($product->fields['name']) . '\');';
			$prod_cache .= $define . "\n";
			eval("$define");
			$product->MoveNext();
		}
		$this->save_cache($this->cache_file . 'products', $prod_cache, 'EVAL', 1 , 1);
		unset($prod_cache);
		} else {
			$this->get_cache($this->cache_file . 'products');
		}
	} # end function


/**
 * Function to generate categories cache entries
 * @author Bobby Easland
 * @version 1.1
 */
	function generate_categories_cache(){
		$this->is_cached($this->cache_file . 'categories', $is_cached, $is_expired);
		if ( !$is_cached || $is_expired ) { // it's not cached so create it
			switch(true){
				case ($this->attributes['SEO_ADD_CAT_PARENT'] == 'true'):
					$sql = "SELECT c.categories_id as id, c.parent_id, cd.categories_name as cName, cd2.categories_name as pName
							FROM ".TABLE_CATEGORIES." c
							LEFT JOIN ".TABLE_CATEGORIES_DESCRIPTION." cd2
							ON c.parent_id=cd2.categories_id AND cd2.language_id='".(int)$this->languages_id."',
							".TABLE_CATEGORIES_DESCRIPTION." cd
							WHERE c.categories_id=cd.categories_id
							AND cd.language_id='".(int)$this->languages_id."'";
					//IMAGINADW.COM;
					break;
				default:
					$sql = "SELECT categories_id as id, categories_name as cName
							FROM ".TABLE_CATEGORIES_DESCRIPTION."
							WHERE language_id='".(int)$this->languages_id."'";
					break;
			} # end switch
		$category = $this->db->Execute($sql);
		$cat_cache = '';
		while (!$category->EOF) {
			$id = $this->get_full_cPath($category->fields['id'], $single_cID);
			$name = $this->not_null($category->fields['pName']) ? $category->fields['pName'] . ' ' . $category->fields['cName'] : $category->fields['cName'];
			$define = 'define(\'CATEGORY_NAME_' . $id . '\', \'' . $this->strip($name) . '\');';
			$cat_cache .= $define . "\n";
			eval("$define");
			$category->MoveNext();
		}
		$this->save_cache($this->cache_file . 'categories', $cat_cache, 'EVAL', 1 , 1);
		unset($cat_cache);
		} else {
			$this->get_cache($this->cache_file . 'categories');
		}
	} # end function

/**
 * Function to generate articles cache entries
 * @author Bobby Easland
 * @version 1.0
 */
	function generate_news_articles_cache(){
		$this->is_cached($this->cache_file . 'news_articles', $is_cached, $is_expired);
		if ( !$is_cached || $is_expired ) { // it's not cached so create it
			$sql = "SELECT article_id as id, news_article_name as name
					FROM ".TABLE_NEWS_ARTICLES_TEXT."
					WHERE language_id = '".(int)$this->languages_id."'";
			$article = $this->db->Execute($sql);
			$article_cache = '';
			while (!$article->EOF) {
				$define = 'define(\'NEWS_ARTICLE_NAME_' . $article->fields['id'] . '\', \'' . $this->strip($article->fields['name']) . '\');';
				$article_cache .= $define . "\n";
				eval("$define");
				$article->MoveNext();
			}
			$this->save_cache($this->cache_file . 'news_articles', $article_cache, 'EVAL', 1 , 1);
			unset($article_cache);
		} else {
			$this->get_cache($this->cache_file . 'news_articles');
		}
	} # end function

/**
 * Function to generate information cache entries
 * @author Bobby Easland
 * @version 1.0
 */
	function generate_info_manager_cache(){
		$this->is_cached($this->cache_file . 'info_manager', $is_cached, $is_expired);
		if ( !$is_cached || $is_expired ) { // it's not cached so create it
			$sql = "SELECT pages_id as id, pages_title as name
					FROM ".TABLE_INFO_MANAGER;
			$information = $this->db->Execute($sql);
			$information_cache = '';
			while (!$information->EOF) {
				$define = 'define(\'INFO_MANAGER_PAGE_NAME_' . $information->fields['id'] . '\', \'' . $this->strip($information->fields['name']) . '\');';
				$information_cache .= $define . "\n";
				eval("$define");
				$information->MoveNext();
			}
			$this->save_cache($this->cache_file . 'info_manager', $information_cache, 'EVAL', 1 , 1);
			unset($information_cache);
		} else {
			$this->get_cache($this->cache_file . 'info_manager');
		}
	} # end function

/**
 * Function to save the cache to database
 * @author Bobby Easland
 * @version 1.0
 * @param string $name Cache name
 * @param mixed $value Can be array, string, PHP code, or just about anything
 * @param string $method RETURN, ARRAY, EVAL
 * @param integer $gzip Enables compression
 * @param integer $global Sets whether cache record is global is scope
 * @param string $expires Sets the expiration
 */
	function save_cache($name, $value, $method='RETURN', $gzip=1, $global=0, $expires = '30 days'){
		$expires = date('Y-m-d H:i:s', strtotime('+' . $expires));

		if ($method == 'ARRAY') $value = serialize($value);
		$value = ( $gzip === 1 ? base64_encode(gzdeflate($value, 1)) : addslashes($value) );
		$sql_data_array = array(
			'cache_id' => md5($name),
			'cache_language_id' => (int)$this->languages_id,
			'cache_name' => $name,
			'cache_data' => $value,
			'cache_global' => (int)$global,
			'cache_gzip' => (int)$gzip,
			'cache_method' => $method,
			'cache_date' => date("Y-m-d H:i:s"),
			'cache_expires' => $expires
		);
		$this->is_cached($name, $is_cached, $is_expired);
		$cache_check = ( $is_cached ? 'true' : 'false' );
		switch ( $cache_check ) {
			case 'true':
				zen_db_perform(TABLE_SEO_CACHE, $sql_data_array, 'update', "cache_id='".md5($name)."'");
				break;
			case 'false':
				zen_db_perform(TABLE_SEO_CACHE, $sql_data_array, 'insert');
				break;
			default:
				break;
		} # end switch ($cache check)
		# unset the variables...clean as we go
		unset($value, $expires, $sql_data_array);
	}# end function save_cache()

/**
 * Function to get cache entry
 * @author Bobby Easland
 * @version 1.0
 * @param string $name
 * @param boolean $local_memory
 * @return mixed
 */
	function get_cache($name = 'GLOBAL', $local_memory = false){
		$select_list = 'cache_id, cache_language_id, cache_name, cache_data, cache_global, cache_gzip, cache_method, cache_date, cache_expires';
		$global = ( $name == 'GLOBAL' ? true : false ); // was GLOBAL passed or is using the default?
		switch($name){
			case 'GLOBAL':
				$cache = $this->db->Execute("SELECT ".$select_list." FROM " . TABLE_SEO_CACHE . " WHERE cache_language_id='".(int)$this->languages_id."' AND cache_global='1'");
				break;
			default:
				$cache = $this->db->Execute("SELECT ".$select_list." FROM " . TABLE_SEO_CACHE . " WHERE cache_id='".md5($name)."' AND cache_language_id='".(int)$this->languages_id."'");
				break;
		}
		$num_rows = $cache->RecordCount();
		if ($num_rows){
			$container = array();
			while(!$cache->EOF){
				$cache_name = $cache->fields['cache_name'];
				if ( $cache->fields['cache_expires'] > date("Y-m-d H:i:s") ) {
					$cache_data = ( $cache->fields['cache_gzip'] == 1 ? gzinflate(base64_decode($cache->fields['cache_data'])) : stripslashes($cache->fields['cache_data']) );
					switch($cache->fields['cache_method']){
						case 'EVAL': // must be PHP code
							eval($cache_data);
							break;
						case 'ARRAY':
							$cache_data = unserialize($cache_data);
						case 'RETURN':
						default:
							break;
					} # end switch ($cache['cache_method'])
					if ($global) $container['GLOBAL'][$cache_name] = $cache_data;
					else $container[$cache_name] = $cache_data; // not global
				} else { // cache is expired
					if ($global) $container['GLOBAL'][$cache_name] = false;
					else $container[$cache_name] = false;
				}# end if ( $cache['cache_expires'] > date("Y-m-d H:i:s") )
				if ( $this->keep_in_memory || $local_memory ) {
					if ($global) $this->data['GLOBAL'][$cache_name] = $container['GLOBAL'][$cache_name];
					else $this->data[$cache_name] = $container[$cache_name];
				}
				$cache->MoveNext();
			} # end while ($cache = $this->DB->FetchArray($this->cache_query))
			unset($cache_data);
			switch (true) {
				case ($num_rows == 1):
					if ($global){
						if ($container['GLOBAL'][$cache_name] == false || !isset($container['GLOBAL'][$cache_name])) return false;
						else return $container['GLOBAL'][$cache_name];
					} else { // not global
						if ($container[$cache_name] == false || !isset($container[$cache_name])) return false;
						else return $container[$cache_name];
					} # end if ($global)
				case ($num_rows > 1):
				default:
					return $container;
					break;
			}# end switch (true)
		} else {
			return false;
		}# end if ( $num_rows )
	} # end function get_cache()

/**
 * Function to get cache from memory
 * @author Bobby Easland
 * @version 1.0
 * @param string $name
 * @param string $method
 * @return mixed
 */
	function get_cache_memory($name, $method = 'RETURN'){
		$data = ( isset($this->data['GLOBAL'][$name]) ? $this->data['GLOBAL'][$name] : $this->data[$name] );
		if ( isset($data) && !empty($data) && $data != false ){
			switch($method){
				case 'EVAL': // data must be PHP
					eval("$data");
					return true;
					break;
				case 'ARRAY':
				case 'RETURN':
				default:
					return $data;
					break;
			} # end switch ($method)
		} else {
			return false;
		} # end if (isset($data) && !empty($data) && $data != false)
	} # end function get_cache_memory()

/**
 * Function to perform basic garbage collection for database cache system
 * @author Bobby Easland
 * @version 1.0
 */
	function cache_gc(){
		$this->db->Execute("DELETE FROM " . TABLE_SEO_CACHE . " WHERE cache_expires <= '" . date("Y-m-d H:i:s") . "'");
	}

/**
 * Function to check if the cache is in the database and expired
 * @author Bobby Easland
 * @version 1.0
 * @param string $name
 * @param boolean $is_cached NOTE: passed by reference
 * @param boolean $is_expired NOTE: passed by reference
 */
	function is_cached($name, &$is_cached, &$is_expired){ // NOTE: $is_cached and $is_expired is passed by reference !!
		$this->cache_query = $this->db->Execute("SELECT cache_expires FROM " . TABLE_SEO_CACHE . " WHERE cache_id='".md5($name)."' AND cache_language_id='".(int)$this->languages_id."' LIMIT 1");
		$is_cached = ( $this->cache_query->RecordCount() > 0 ? true : false );
		if ($is_cached){
			$is_expired = ( $this->cache_query->fields['cache_expires'] <= date("Y-m-d H:i:s") ? true : false );
			unset($check);
		}
	}# end function is_cached()

/**
 * Function to initialize the redirect logic
 * @author Bobby Easland
 * @version 1.1
 */
	function check_redirect(){
		$this->need_redirect = false;
		$this->uri = ltrim( basename($_SERVER['REQUEST_URI']), '/' );
		$this->real_uri = ltrim( basename($_SERVER['SCRIPT_NAME']) . '?' . $_SERVER['QUERY_STRING'], '/' );

		// damn zen cart attributes use illegal url characters
		if ($this->is_attribute_string($this->uri)) {
			$parsed_url = parse_url($this->uri);
			$this->uri_parsed = parse_url($parsed_url['scheme']);
			$this->uri_parsed['query'] = preg_replace('/products_id=([0-9]+)/', 'products_id=$1:' . $parsed_url['path'], $this->uri_parsed['query']);
		} else {
			$this->uri_parsed = parse_url($this->uri);
		}

		$this->attributes['SEO_REDIRECT']['URI'] = $this->uri;
		$this->attributes['SEO_REDIRECT']['REAL_URI'] = $this->real_uri;
		$this->attributes['SEO_REDIRECT']['URI_PARSED'] = $this->uri_parsed;
		$this->need_redirect();
		$this->check_seo_page();

		if ($this->need_redirect && $this->is_seopage && $this->attributes['USE_SEO_REDIRECT'] == 'true') {
			$this->do_redirect();
		}
	} # end function

/**
 * Function to check if the URL needs to be redirected
 * @author Bobby Easland
 * @version 1.2
 */
	function need_redirect() {
		$this->need_redirect = ((preg_match('/main_page=/i', $this->uri)) ? true : false);
		// QUICK AND DIRTY WAY TO DISABLE REDIRECTS ON PAGES WHEN SEO_URLS_ONLY_IN is enabled IMAGINADW.COM
		$sefu = explode(",", ereg_replace( ' +', '', SEO_URLS_ONLY_IN ));
		if ((SEO_URLS_ONLY_IN!="") && !in_array($_GET['main_page'],$sefu) ) $this->need_redirect = false;
		// IMAGINADW.COM

		$this->attributes['SEO_REDIRECT']['NEED_REDIRECT'] = $this->need_redirect ? 'true' : 'false';
	}

/**
 * Function to check if it's a valid redirect page
 * @author Bobby Easland
 * @version 1.1
 */
	function check_seo_page() {
		if (!isset($_GET['main_page']) || (!$this->not_null($_GET['main_page']))) {
			$_GET['main_page'] = 'index';
		}

		$this->is_seopage = (($this->attributes['SEO_ENABLED'] == 'true') ? true : false);

		$this->attributes['SEO_REDIRECT']['IS_SEOPAGE'] = $this->is_seopage ? 'true' : 'false';
	}

/**
 * Function to perform redirect
 * @author Bobby Easland
 * @version 1.0
 */
	function do_redirect() {
		$p = @explode('&', $this->uri_parsed['query']);
		foreach( $p as $index => $value ) {
			$tmp = @explode('=', $value);

			if ($tmp[0] == 'main_page') continue;

			switch($tmp[0]){
				case 'products_id':
					if ($this->is_attribute_string('products_id=' . $tmp[1])) {
						$pieces = explode(':', $tmp[1]);
						$params[] = $tmp[0] . '=' . $pieces[0];
					} else {
						$params[] = $tmp[0] . '=' . $tmp[1];
					}
					break;
				default:
					$params[] = $tmp[0].'='.$tmp[1];
					break;
			}
		} # end foreach( $params as $var => $value )
		$params = ( sizeof($params) > 1 ? implode('&', $params) : $params[0] );

		$url = $this->href_link($_GET['main_page'], $params, 'NONSSL', false);
		// cleanup url for redirection
		$url = str_replace('&amp;', '&', $url);

		switch($this->attributes['USE_SEO_REDIRECT']){
			case 'true':
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: $url");
				break;
			default:
				$this->attributes['SEO_REDIRECT']['REDIRECT_URL'] = $url;
				break;
		} # end switch
	} # end function do_redirect

} # end class
