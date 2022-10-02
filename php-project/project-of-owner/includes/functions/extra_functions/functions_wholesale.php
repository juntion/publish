<?php
/**
 * 
 * @param array $current_category_wholesale_quantity
 * @param int $categories_id
 * @return boolean
 * @todo get wholesale quantity of current category from database
 */
function zen_get_current_category_wholesale_quantity(& $current_category_wholesale_quantity,$categories_id){
	global $db;
// 	$temp_array = array();
	$sql = "select categories_wholesale_quantity from " . TABLE_CATEGORIES . " as c 
			left join " .TABLE_CATEGORIES_DESCRIPTION ." as cd 
			on (c.categories_id = cd.categories_id and cd.language_id = :languages_id:) 
			where c.categories_id=:categories_id:";

	$sql = $db->bindVars($sql, ':languages_id:', (int)$_SESSION['languages_id'], 'integer');
	$sql = $db->bindVars($sql, ':categories_id:', (int)$categories_id, 'integer');
	
	
	$result = $db->Execute($sql);
	$categories_wholesale_quantity_string = $result->fields['categories_wholesale_quantity'];
	if ($categories_wholesale_quantity_string) {
		$current_category_wholesale_quantity = split('[,]', $categories_wholesale_quantity_string);
		return true;
	}else 
		return false;
} 

/*
function zen_get_wholesale_product_prices($products_id){
	global $db,$currencies;
	$prices = array();
	
	$sql = "select discount_price from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = :products_id: 
			order by discount_qty ";
	$sql = $db->bindVars($sql, ':products_id:', $products_id, 'string');
	
	$result = $db->Execute($sql);
	if ($result->RecordCount()) {
		
		while (!$result->EOF){
			$prices [] = $currencies->fs_format($result->fields['discount_price']);
			$result->MoveNext();
		}
	}
	return $prices;
	
}
*/