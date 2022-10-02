<?php
/*
	@return  
	0 =>  not set 
	1 =>  all set
	2 =>  not all set
 */
function zen_is_set_page_meta_tags($page_name,$languages_id)
{
	
	global $db;
	$sql = "SELECT * FROM ".TABLE_PAGE_META_TAGS." WHERE page_name = '".$page_name."' and languages_id = ".(int)$languages_id.";";
	$result = $db->Execute($sql);
	
	if ($result->RecordCount() < 1)
	return 0;
	else {
		if(zen_not_null($result->fields['title']) && zen_not_null($result->fields['keywords']) && zen_not_null($result->fields['description'])){
			return 1;
		}else 
			return 2;
	}
}


function zen_get_page_meta_tags($page_name, $languages_id= '')
{
	global $db;
	$meta_info  = array();
	
	if ($languages_id) {
		$sql_and = " and languages_id = ".(int)$languages_id;
	}
	
	$sql = "SELECT languages_id,title,keywords,description FROM ".TABLE_PAGE_META_TAGS." WHERE page_name = '".$page_name."' ";
	
	if (isset($sql_and) && $sql_and) {
		$sql .= $sql_and;
	}
	$result = $db->Execute($sql);
	if($result->RecordCount()){
		while (!$result->EOF) {
			$meta_info[$result->fields['languages_id']] = array (
					'title' => $result->fields['title'],
					'keywords' => $result->fields['keywords'],
					'description' => $result->fields['description'],
			);
			$result->MoveNext();
		}	
	}
	return $meta_info;
}