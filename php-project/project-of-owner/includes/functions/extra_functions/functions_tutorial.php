<?php
function zen_get_image_bak($a){
if(strstr($a,".jpg")){
    $str =  ".jpg";
}elseif(strstr($a,".png")){
    $str = ".png";
}elseif(strstr($a,".gif")){
    $str = ".gif";
}
else{
    $str = "";
}
  return $str ;
}

function zen_get_tutorail_category_name($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_name from " . TABLE_DOC_CATEGORIES_DESCRIPTION . ' where doc_categories_id = '.(int)$c_id);
	
	return $get_info->fields['doc_categories_name'];
}




function zen_get_tutorial_list_categories($c_id){
	global $db;
	$tutorial_categories = array();
	$categories_query = " select c.doc_categories_id,cd.doc_categories_name from " . TABLE_DOC_CATEGORIES ." as c left join " . TABLE_DOC_CATEGORIES_DESCRIPTION ." as cd
	using(doc_categories_id) where cd.language_id = '".$_SESSION['languages_id']."'
	order by doc_sort_order";
	
	
	$get_categories = $db->Execute($categories_query);
	if ($get_categories->RecordCount()){
		while(!$get_categories->EOF){
			$tutorial_categories [] = array(
					'id' => $get_categories->fields['doc_categories_id'],
					'name' => $get_categories->fields['doc_categories_name']
			);
			$get_categories->MoveNext();
		}
	}
	return $tutorial_categories;
}


function zen_get_tutorial_list_article($s_id){
	global $db;
	$tutorial_articles = array();
	
	$articles_query = "select a.doc_article_id,ac.doc_categories_id,ad.doc_article_title,a.doc_article_last_modified,ad.doc_article_content,a.doc_article_image,ad.doc_article_tag from " .TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_DOC_ARTICLE ." as a using(doc_article_id)
		left join " . TABLE_DOC_ARTICLE_CATEGORY . " as ac  using(doc_article_id)
		where doc_categories_id = ".intval($s_id)." and ad.language_id = '".$_SESSION['languages_id']."' order by doc_article_last_modified DESC";
		
	$get_articles = $db->Execute($articles_query);
	
		if ($get_articles->RecordCount()){
		while(!$get_articles->EOF){
			$tutorial_articles [] = array(
						'id' => $get_articles->fields['doc_article_id'],
				        'cid' => $get_articles->fields['doc_categories_id'],
						'title' => $get_articles->fields['doc_article_title'],
						'content' => stripslashes($get_articles->fields['doc_article_content']),
				        'image' => stripslashes($get_articles->fields['doc_article_image']),
			            'add_time' =>stripslashes($get_articles->fields['doc_article_last_modified']),
				        'tag' => stripslashes($get_articles->fields['doc_article_tag']),
			);
			$get_articles->MoveNext();
		}
	}
	return $tutorial_articles;

}

function zen_get_article($p_id){
    global $db;
    $popular_query = "select ad.doc_article_id,ad.doc_article_title,ad.doc_article_des,ad.doc_article_content,a.doc_article_count,a.doc_article_image,a.doc_article_last_modified from " .TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
    left join " . TABLE_DOC_ARTICLE ." as a using(doc_article_id)
    where ad.doc_article_id = a.doc_article_id and ad.language_id = ".$_SESSION['languages_id']." and ad.doc_article_id = ".$p_id." limit 1";

    $popular_articles = $db->Execute($popular_query);
    $popular_article_array = array();
    if ($popular_articles->RecordCount()){
        while (!$popular_articles->EOF){
            $popular_article_array[] = array(
                'id' => $popular_articles->fields['doc_article_id'],
                'title' => $popular_articles->fields['doc_article_title'],
                'des' => $popular_articles->fields['doc_article_des'],
                'content' => $popular_articles->fields['doc_article_content'],
                'image'  => zen_get_img_change_src('images/'.$popular_articles->fields['doc_article_image']),
                'time'   => $popular_articles->fields['doc_article_last_modified']
            );
            $popular_articles->MoveNext();
        }
    }
    return $popular_article_array;
}

function tutorial_new_products(){
	global $db;
	$new_products = array();
	$sql = "select p.products_id,pd.products_name from ".TABLE_PRODUCTS." as p
					left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd
					on p.products_id = pd.products_id
					where p.products_status = 1
					AND pd.language_id = ".(int)$_SESSION['languages_id'] ." order by rand() limit 4";
	$get_products = $db->Execute($sql);
	if ($get_products->RecordCount()){
		while(!$get_products->EOF){
			$new_products [] = array(
					'id' => $get_products->fields['products_id'],
					'name' => $get_products->fields['products_name']	
			);
			$get_products->MoveNext();
		}
	}
	return $new_products;
}