<?php


function is_exist_support_userful($rID){
	global $db;
	$fs_query = "select count(support_article_is_useful_id) as total from ".TABLE_SUPPORT_ARTICLE_IS_USEFUL." where support_article_id = ".(int)$rID;
	$result = $db->Execute($fs_query);
	if ($result->RecordCount() && $result->fields['total'] > 0){
		return true;
	}
	return false;
}

function get_support_userful_count($rID,$type){
	global $db;
	
    //$helpful_sql="select count(support_article_is_useful_id) as total from ". TABLE_SUPPORT_ARTICLE_IS_USEFUL ."  where  support_article_id='".$_GET['s_id'] ."'  ";
    
	$fs_query = "select support_userful_count as total from ".TABLE_SUPPORT_ARTICLE_IS_USEFUL." where support_article_id = ".(int)$rID;
	$helpful = $db->Execute($fs_query);
	return $helpful->fields['total'];
}

