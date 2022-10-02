<?php 

function zen_get_categories_parents_ids($categories_id){
	$categories_ids = array();
	zen_get_parent_category_id($categories_ids,$categories_id);
	return $categories_ids;
	 
}
function zen_get_parent_category_id(& $categories_ids,$categories_id){
	global $db;
	$sql = "select parent_id from " .TABLE_CATEGORIES . " where categories_id = :categories_id";
	$sql = $db->bindVars($sql,':categories_id',(int)$categories_id,'integer');
	
	$result = $db->Execute($sql);
	if ($result->RecordCount()) {
		if ($result->fields['parent_id']) {
			$categories_ids [] = $result->fields['parent_id'];
			zen_get_parent_category_id($categories_ids,(int)$result->fields['parent_id']);
		}
		
		else
			return $categories_ids;
	}
	 
}
