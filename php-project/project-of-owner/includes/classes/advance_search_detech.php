<?php

class advance_search_detech{
	function __construct(){
		
	}
	
	/**
	 *  level 1 use product SKU to search
	 *  level 2 use whole keyword to search
	 */
	function search_level($keyword,$level){
		global $db,$current_category_id;
		 $sql ='';
		switch($level){
			case 1:
				$sql = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p 
						where p.products_status = 1 and p.show_type = 0 
						and p.products_SKU = '".$keyword."'";
				break;
				/*
				 * 优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
				 * */
			case 2: //search by tom products_model,products_MFG_PART
                $origin_word = $keyword;
                $pattern =array('/-/','/\./','/\*/','/\//','/\s/');
                $keyword = preg_replace($pattern,'',$keyword);

                //$sql ="select count(p.products_id) as total from products as p
					//where p.products_status = 1 and p.show_type = 0
					//and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = '".$keyword."' or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = '".$keyword."' or  find_in_set('".$keyword."', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) )";

                $sql ="select count(p.products_id) as total from products as p	
					where p.products_status = 1 and p.show_type = 0 and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = '".$keyword."' or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = '".$keyword."' or  find_in_set('".$keyword."', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ',''))  or p.products_model='".$origin_word."' or p.old_products_model='".$origin_word."') ";


				break;
			case 4: //if keyword = products_name
				$sql = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p	
				left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd 
					on p.products_id = pd.products_id
					where p.products_status = 1 and p.show_type = 0 
					and language_id = :language_id:  
					and ((REPLACE(REPLACE(REPLACE(pd.products_name,'\(',' '),'\)',' '),'/',' ')) = '".$keyword."')";
				$sql = $db->bindVars($sql, ':language_id:', (int)$_SESSION['languages_id'], 'integer');
				break;
			case 5:

			  $categories_arr = zen_get_keywords_is_categories_tag($keyword);
			  $categories_arr = zen_get_subcategories_of_arr($categories_arr);
			 
		       if ($categories_arr){
			  		if (1 < sizeof($categories_arr)) {
			  			$category_where_sql = " AND ptc.categories_id in(".join(',',$categories_arr).") ";
			  			
			  		}else if (1 == sizeof($categories_arr)) {
			  			$category_where_sql = " AND  ptc.categories_id = ".$categories_arr[0]." ";
			  		}
			  	}
             $sql = "select  count(p.products_id) as total from ".TABLE_PRODUCTS." as p
					left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc on p.products_id = ptc.products_id
					where p.products_status = 1 and p.show_type = 0 
					". $category_where_sql ." order by p.products_quantity = 0 , p.products_sort_order";
				
				break;		
			 case 3: 
			 	//split keywords by ' ' to search each single word
				if (strpos($keyword, ' ')){
					$keywords = explode(' ', $keyword);
					$where_str = " and ( ";
					if (($size = sizeof($keywords))) {
						for ($i = 0; $i < $size; $i++) {
							if ($keywords[$i]) {
								$where_str .= "( pd.products_name REGEXP '".$keywords[$i]."' or p.products_model REGEXP '".$keywords[$i]."' or p.products_MFG_PART REGEXP '".$keywords[$i]."')";
								//if ($i < $size -1) {
								if ($i < ($size - 1) && $keywords[1] != '0') {
									$where_str .= " and ";
								}
							}
						}
					}
					$where_str .= " ) ";
					$sql = "select count(p.products_id) as total from ".TABLE_PRODUCTS." as p 
							left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd
							on p.products_id = pd.products_id 
							where p.products_status = 1 and p.show_type = 0 
							and  language_id = :language_id: 
							" . $where_str;
				}
				break;
			/*case 4: 
				$sql = "select count(products_id) as total from ".TABLE_PRODUCTS." as p
					left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd
					on p.products_id = pd.products_id
					where p.products_name REGEXP '".$keyword."'";
				break; */			
		}
		$sql = $db->bindVars($sql, ':language_id:', (int)$_SESSION['languages_id'], 'integer');
		$result = $db->Execute($sql);

		if ($result->fields['total']){
			return 1;
		}else {
			return 0;
		}
	}

	/**
	 * 
	 * @param array $keywords
	 * @tutorial 
	 * use splite keywords to search
	 */
	function regexp_search($keywords,$except_products,$limit = false){
		global $db;
		$products = array();
		$sql = "select p.products_id,p.products_image,pd.products_name,p.products_SKU,p.products_price from ".TABLE_PRODUCTS." as p
					left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd
					on p.products_id = pd.products_id
					where p.products_status = 1 and p.show_type = 0 
					AND pd.language_id = ".(int)$_SESSION['languages_id'] ." 
					AND ";
		
		if (is_array($except_products) && sizeof($except_products)){
			if (1 == sizeof($except_products)){
				$sql .= " p.products_id != ".(int)$except_products[0] ." AND ";
			}else {
				$sql .= " p.products_id not in(".implode(',',$except_products).") AND ";
			}
		}
		$where_str = '';
		if (sizeof($keywords)){
			foreach ($keywords as $word){
				if ($word)
					$where_str .= " pd.products_name REGEXP '".$word."' OR ";
			}
			$where_str = substr($where_str, 0,strrpos($where_str, 'OR'));
			
		}
		
		$order_by_str = " ORDER BY p.products_id desc " ;
		
		
		$sql = $sql . " ( " . $where_str ." ) " . $order_by_str;
		if ($limit){
			$sql .= " LIMIT  ". (int)$limit;
		}
		
		return $sql;

	}
	/**
	 * @todo get related search keywords demilited by blank 
	 */
	function get_related_searches(){
		$related = array();
		if (isset($_GET['keyword']) && $_GET['keyword'] && strpos($_GET['keyword'],' ')){
			$keyword = preg_replace('/select|insert|update|delete|\'|\(|\)|$|^|%|\+|"|\/|\*|\.|\/|union|into|load_file|outfile/i','',$_GET['keyword']);
			$related = explode(' ', $keyword);
			$related = array_unique($related);
		}
		return $related;
	}
	
	function get_polular_searches(){
		
		$populars = array('Cisco SFP-10G-SR','Fiber Media Converter','Handheld Optical Power Meter','Fusion Splicer');
		
		return $populars;
	}
	
	function get_products_already_in_search_result($sql){
		global $db;
		$products = array();
		$get_products = $db->Execute($sql);
		if ($get_products->RecordCount()){
			
			while(!$get_products->EOF){
				$products [] = $get_products->fields['products_id'];
				$get_products->MoveNext();
			}
		}
		return $products;
	}

	function display_advanced_search_result_left_bar($search_products,$keyword,$key_array){
		global $db;
		$categories = array();
		$products = array();
		if (is_array($search_products) && sizeof($search_products)) {
			foreach ($search_products as $i => $product){
				if ($product['id']) 
					//$categories [] = zen_get_products_category_id((int)$product['id']);   //cancel by melo 2015-3-10
					$categories [] = zen_get_categories_name_by_productsid((int)$product['id']);
					$products [] =(int)$product['id'];
			}
		}
		
		$categories = array_unique($categories);
		$html = '';
		$sub_array = array();
		foreach ($categories as $i => $id){
		    $sub_array [] = zen_get_categories_is_not_subcategories($id);
			//$categories_name_search = zen_get_categories_name($id);
		}
		$sub_array = array_unique($sub_array);
		foreach ($sub_array as $l => $sid){
			if($sid){
				$html .= '<dt>
				<a href="'.zen_href_link('products_search','&categories='.$sid.'&keyword='. $keyword .'').'">
				'.zen_get_categories_name($sid).'</a></dt>' 
				."\n";
			}
		}
		
		return $html;
	}
	


	function setProductsData($products){
		$this->products = $products;
	}

}