<?php
/**
 * 
 * @param $rID
 * 
 * @toto check is exist one reviews valuation
 * 
 * @author kevin 
 */
function is_exist_reviews_valuation($rID){
	global $db;
	$fs_query = "select count(reviews_id) as total from reviews_like_or_not where reviews_id = ".(int)$rID;
	$result = $db->Execute($fs_query);
	
	if ($result->RecordCount() && $result->fields['total'] > 0){
		return true;
	}
	return false;
}

function get_reviews_count($rID,$type){
	global $db;
	
	$column = (1 == (int)$type) ? ' r_like ' : ' r_bad ';
	$fs_query = "select " . $column.
	 "  as total from reviews_like_or_not where reviews_id = ".(int)$rID;
	$result = $db->Execute($fs_query);
	return $result->fields['total'];
}

function is_exist_comments_valuation($cID){
	global $db;
	$fs_query = "select count(comments_id) as total from reviews_comments_like_or_not where comments_id = ".(int)$cID;
	$result = $db->Execute($fs_query);
	
	if ($result->RecordCount() && $result->fields['total'] > 0){
		return true;
	}
	return false;
}

function get_comments_count($cID,$type){
	global $db;
	
	$column = (1 == (int)$type) ? ' r_like ' : ' r_bad ';
	$fs_query = "select " . $column.
	 "  as total from reviews_comments_like_or_not where comments_id = ".(int)$cID;
	$result = $db->Execute($fs_query);
	return $result->fields['total'];
}
/**
 * customer_basket   select customers_basket_quantity by tom
 */
function get_customer_quantity($p_id,$type){
	global $db;

	//$column = (1 == (int)$type) ? ' customers_basket_quantity ' : ' customers_basket_quantity ';
	$sql = "select customers_basket_quantity as num from ".TABLE_CUSTOMERS_BASKET." where products_id = ".(int)$p_id;
	$result = $db->Execute($sql);
	return $result->fields['num'];
}