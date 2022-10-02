<?php
//********************$tutorial_query*********************/
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
///********************$tutorial_query*********************/
require($template->get_template_dir('tpl_tutorial_right_slide_bar.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/'.'tpl_tutorial_right_slide_bar.php');
//
//
//
//获取所有分类的前5条相关文章
$doc_article_idsr="";
foreach ($doc_array as $k=>$v){
    $doc_article_idsr[]= $db->getAll("select doc_article_id from doc_article_category where doc_categories_id=" . $doc_array[$k]['doc_categories_id'] . "");
}
if(!empty($doc_article_idsr)){
    $doc_news="";

    foreach ($doc_article_idsr as $k=>$v){
        $doc_news_file="";
        for ($i=0;$i<count($v);$i++){
            $doc_news_file.=$v[$i]['doc_article_id'].",";
        }
        if(!empty($doc_news_file)){
            $doc_news_file= substr($doc_news_file, 0,-1);
        }
        $doc_news[$k] = $db-> getAll("select ad.doc_article_title,a.doc_article_image from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id)
	where ad.doc_article_id in ($doc_news_file) and doc_article_status = 1 and ad.doc_article_id = a.doc_article_id and ad.language_id = '" . $_SESSION['languages_id'] . "' and a.language_id = '" . $_SESSION['languages_id'] . "' order by doc_article_last_modified DESC limit 0,5");

    }
}

$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', "define_tutorial_detail", 'false');
//
//
//
$check_products_query = "select a.doc_article_id as total
from " . TABLE_DOC_ARTICLE . " as a left join " . TABLE_DOC_ARTICLE_DESCRIPTION . " as  ad on(a.doc_article_id = ad.doc_article_id)
where a.doc_article_id = '" . $_GET['a_id'] . "' and ad.language_id = ".$_SESSION['languages_id']." and a.doc_article_status =1 ";

$check_products = $db->Execute ( $check_products_query );

//var_dump($check_products->fields ['total']);
if (!$_GET['a_id'] || $check_products->fields ['total'] < 1) {
    header('HTTP/1.1 404 Not Found');
    zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND));
}

//规范URL链接
//    $xredir="http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
//	$rightPURL = zen_href_link('tutorial_detail','&a_id='.$_GET['a_id'],'NONSSL');
//
//	if($xredir != $rightPURL && !$_GET['currency']){
//	  header("Location: ".$rightPURL);
//	}

if (isset($_GET['a_id']) && intval($_GET['a_id'])){
    $tutorial_c = $db->Execute("select doc_article_id from " . TABLE_DOC_ARTICLE ." where doc_article_id = ".intval($_GET['a_id'])."");
    if(empty($tutorial_c->fields['doc_article_id'])){
        zen_redirect(zen_href_link('page_notfound'));
    }

    $articles_query = "select a.doc_article_id,ad.doc_article_title,ad.doc_article_content,ad.doc_article_tag,a.doc_article_count,a.doc_article_date_added,a.doc_article_last_modified from " .TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_DOC_ARTICLE ." as a using(doc_article_id)
		where doc_article_id = ".intval($_GET['a_id']);
    $get_articles = $db->Execute($articles_query);

    $article_array = array();
    if ($get_articles->RecordCount()){
        $article_array['id'] = $get_articles->fields['doc_article_id'];
        $article_array['title'] = $get_articles->fields['doc_article_title'];
        $article_array['content'] = stripslashes($get_articles->fields['doc_article_content']);
        $article_array['tag'] = stripslashes($get_articles->fields['doc_article_tag']);
        $article_array['count'] = stripslashes($get_articles->fields['doc_article_count']);
        //$article_array['add_time'] = date('F j, Y',strtotime($get_articles->fields['doc_article_date_added']));

        $article_array['add_time'] = $get_articles->fields['doc_article_date_added'];
        $article_array['last_modified'] = $get_articles->fields['doc_article_last_modified'];

    }
}


$c_info  = zen_get_tutorial_detail_to_category($_GET['a_id']);




//$doc_array = array();

//set pre and next id
$currentArticleId = $article_array['id'];
$cate_id = $db->Execute("select * from doc_article_category where doc_article_id = " . intval($currentArticleId) ."");
$doc_categories_id  = $cate_id->fields['doc_categories_id'];
$prev_article_id = $next_article_id= 0;
$get_prev_one = $db->Execute("select n.doc_article_id, nt.doc_article_title from " . TABLE_DOC_ARTICLE . " n left join " . TABLE_DOC_ARTICLE_DESCRIPTION . " nt on n.doc_article_id = nt.doc_article_id left join doc_article_category dac on n.doc_article_id = dac.doc_article_id
  where dac.doc_categories_id = '$doc_categories_id' and n.doc_article_status = 1 and n.doc_article_id < " . intval($currentArticleId) ." order by n.doc_article_id desc limit 1");
$get_next_one = $db->Execute("select n.doc_article_id, nt.doc_article_title from " . TABLE_DOC_ARTICLE . " n left join " . TABLE_DOC_ARTICLE_DESCRIPTION . " nt on n.doc_article_id = nt.doc_article_id left join doc_article_category dac on n.doc_article_id = dac.doc_article_id
  where dac.doc_categories_id = '$doc_categories_id' and n.doc_article_status = 1 and n.doc_article_id > " . intval($currentArticleId) ." order by n.doc_article_id limit 1");
if ($get_prev_one->RecordCount()){
    $prev_article_id = $get_prev_one->fields['doc_article_id'];
    $prev_article_name = $get_prev_one->fields['doc_article_title'];
}
if ($get_next_one->RecordCount()){
    $next_article_id = $get_next_one->fields['doc_article_id'];
    $next_article_name = $get_next_one->fields['doc_article_title'];
}
unset($get_prev_one,$get_next_one);
//end
//所有tag标签
$tags_array = array();
$results = $db->Execute("select tag_id,tag_name from doc_tag_article left join doc_tag_description using(tag_id) where language_id=".$_SESSION['languages_id']." and type=1  group by tag_name having count(tag_name) > 1");
if($results->RecordCount()){
    while(!$results->EOF){
        $tags_array[] = array('id'=>$results->fields['tag_id'],'text'=>$results->fields['tag_name']);
        $results->MoveNext();
    }
}


if(!empty($_GET['a_id'])){
	$related_result = $db->Execute("select related_article_ids from doc_article_description where doc_article_id=".$_GET['a_id']."");
    $related = $related_result->fields['related_article_ids'];
	if($related) {
        $related = str_replace('，', ',', $related);
        $related = trim($related);
        $related = trim($related, ',');
        $related_id = explode(',', $related);
    }
}
if(!empty($c_info['cId'])){
    $cid=$c_info['cId'];
 $categorie_name = $db->getAll("select doc_categories_name from doc_categories_description where doc_categories_id=".$cid."");
 $blogs = $db->getAll("select blog_title,blog_url from doc_categories_related_blog where doc_categories_id=".$cid." ORDER BY  RAND() LIMIT 3");
}

$categories_id = get_article_one_id();
$count_query = $db->Execute("select count(a.doc_article_id) as total from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id) where a.article_type=2 and a.doc_article_status = 1
		and ad.language_id = ".(int)$_SESSION['languages_id']." order by doc_article_sort_order");
$article_total = $count_query->fields['total'];
$articles_query = "select a.doc_article_id,a.doc_article_image,ad.doc_article_title,ad.doc_article_intro from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id) where a.article_type=2 and a.doc_article_status = 1
		and ad.language_id = ".(int)$_SESSION['languages_id']." order by doc_article_sort_order limit 0,3";
$get_articles_info = $db->Execute($articles_query);
$article_array_info = array();
if ($get_articles_info->RecordCount()){
    while (!$get_articles_info->EOF){
        $article_array_info[] = array(
            'id' => $get_articles_info->fields['doc_article_id'],
            'title' => $get_articles_info->fields['doc_article_title'],
            'intro' => $get_articles_info->fields['doc_article_intro'],
            'image' => stripslashes($get_articles_info->fields['doc_article_image']),
        );
        $get_articles_info->MoveNext();
    }
}
//print_r($article_array_info);die;


