<?php
define('OB_CACHE_ENABLE', 'true');
$ob_cache_pages = array('index');

//$cache_array = array('product_info','products','products_detail','tutorial','news','tutorial_list','tutorial_detail','how_to_buy','news_article');
$cache_array = array('products','products_detail','tutorial','tutorial_list','tutorial_detail','news_article');
/* $cache_array_info = array('product_info' => 'products_id',
					'products' => '',
					'tutorial' => '',
					'news' =>'',
					'tutorial_list'=>'c',
					'tutorial_detail'=>'a_id',
					'how_to_buy'=>'',
					'news_article'=>'article_id',
					'products_detail' => 's_id');
				*/
$cache_array_info = array('products' => '',
					'tutorial_list'=>'c',
					'tutorial_detail'=>'a_id',
					'news_article'=>'article_id',
					'products_detail' => 's_id');
