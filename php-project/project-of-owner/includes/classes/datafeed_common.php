<?php
class datafeed{
	private $categories_array = array();
	
	function __construct($categories_array){
		$this->categories_array = $categories_array;	
	}
	
	function get_categories_have_products(& $categories_have_products, $category_id){
		global $db;
		$get_categories = $db->Execute("select categories_id from " . TABLE_CATEGORIES." WHERE parent_id = ".$category_id);
		if ($get_categories->RecordCount()){
			while (!$get_categories->EOF) {
				if ($db->Execute("select products_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES." WHERE categories_id = ".$get_categories->fields['categories_id'])->RecordCount()){
					$categories_have_products[] = $get_categories->fields['categories_id'];
				}else{
					$this->get_categories_have_products($categories_have_products, $get_categories->fields['categories_id']);
				}
				$get_categories->MoveNext();
			}
		}
	}
	/*get products*/
	function get_products_array(){
		$categories_have_products = $products_array = array();
		
		foreach ($this->categories_array as $category_id){
			$this->get_categories_have_products($categories_have_products, $category_id);
		}
		if (sizeof($categories_have_products))
			$products_array = $this->fetch_products($categories_have_products);
		return $products_array;
	}
	
	/*fetch products*/
	
	function fetch_products($categories){
		$products_array = array();
		if (1 < sizeof($categories)){
			$query = "SELECT distinct(p.products_id), p.products_model, pd.products_name, pd.products_description, p.products_image, p.products_tax_class_id, p.products_price_sorter, GREATEST(p.products_date_added, IFNULL(p.products_last_modified, 0), IFNULL(p.products_date_available, 0)) AS base_date, p.products_quantity, pt.type_handler, p.products_weight,p.products_sku
										 FROM " . TABLE_PRODUCTS . " p
											 LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id)
											 LEFT JOIN " . TABLE_PRODUCT_TYPES . " pt ON (p.products_type=pt.type_id)
											 LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES . " ptc ON (p.products_id = ptc.products_id)
										 WHERE p.products_status = 1
											 AND p.product_is_call = 0
											 AND p.product_is_free = 0
											 AND pd.language_id = 1
											 AND ptc.categories_id in (".implode(',', $categories).")
                       GROUP BY p.products_id
										 ORDER BY p.products_id ASC ";
		}else if (1 == sizeof($categories)){
			$query = "SELECT distinct(p.products_id), p.products_model, pd.products_name, pd.products_description, p.products_image, p.products_tax_class_id, p.products_price_sorter, GREATEST(p.products_date_added, IFNULL(p.products_last_modified, 0), IFNULL(p.products_date_available, 0)) AS base_date, p.products_quantity, pt.type_handler, p.products_weight,p.products_sku
										 FROM " . TABLE_PRODUCTS . " p
											 LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id)
											 LEFT JOIN " . TABLE_PRODUCT_TYPES . " pt ON (p.products_type=pt.type_id)
											 LEFT JOIN ".TABLE_PRODUCTS_TO_CATEGORIES . " ptc ON (p.products_id = ptc.products_id)
										 WHERE p.products_status = 1
											 AND p.product_is_call = 0
											 AND p.product_is_free = 0
											 AND pd.language_id = 1
											 AND ptc.categories_id =".$categories."
                       GROUP BY p.products_id
										 ORDER BY p.products_id ASC ";
		}
		if (isset($query)) return $this->db_query($query);
	}
	/**
	 * 
	 * db helper
	 * @param  $query this is sql statment
	 */
	function db_query($query){
		global  $db;$products = array();
  		$get_products = $db->Execute($query);
		if ($get_products->RecordCount()){
			while (!$get_products->EOF){
					$products [] = $get_products->fields;
				$get_products->MoveNext();
			}
		}
		unset($get_products);
		return $products;
	}
}


