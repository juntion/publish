<?php 
//  优化 > 可以检索当前页面所有产品的筛选值(array),然后判断
//        当前筛选值是否在此数组中.(将array去掉重复值后再in_array)

function get_narrow_values_of_products($products){
 global $db;
  $values = array();
  if(sizeof($products) > 0){
  $narrow = $db->Execute("SELECT products_narrow_by_options_values_id as id
                          FROM products_narrow_by_option_values_to_products 
                          where products_id in (".join(',',$products).")");
  
  	if ($narrow->RecordCount()){
		while (!$narrow->EOF) {
			$values[] = $narrow->fields['id'];
			$narrow->MoveNext();
		}
	}
	$values = array_unique($values);
  }
   return $values;
}

//分类下的产品的所有筛选值


	function get_category_options_by_cID($current_categories_id){
		global $db;
		$options = array();
		$result = $db->Execute("select pnotc.products_narrow_by_options_id as id
			from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS_TO_CATEGORIES. " as pnotc left join ".TABLE_PRODUCTS_NARROW_BY_OPTIONS." as pno 
			on pnotc.products_narrow_by_options_id = pno.products_narrow_by_options_id 
			where pnotc.categories_id = ".(int)$current_categories_id ."  
			order by pno.products_narrow_by_options_name  
			");
		
		if ($result->RecordCount()){
			while (!$result->EOF) {
				$options[] = $result->fields['id'];
				$result->MoveNext();
			}
		}
		
		return $options;
	}

function zen_get_products_of_categories_narrow($current_category_id,$products_narrow_by_option_values_ids){
global $db;

if (zen_has_category_subcategories($current_category_id)) {
	$all_subcategories_ids = array();
	zen_get_subcategories_redis($all_subcategories_ids,$current_category_id);
	
	$count_of_subcategories = sizeof($all_subcategories_ids);
	if ($count_of_subcategories){
		
		if (1 < $count_of_subcategories) {
			
			$category_where_sql = " AND ptc.categories_id in(".join(',',$all_subcategories_ids).")";
		}else if (1 == $count_of_subcategories) {
			$category_where_sql = " AND ptc.categories_id = ".$all_subcategories_ids[0];
		}
	}else {
			$category_where_sql = " AND ptc.categories_id = ".(int)$current_category_id;
	}
}else {
  		$category_where_sql = " AND ptc.categories_id = ".(int)$current_category_id;
  	}
  	
$sql_order_by = ' ORDER BY p.products_sort_order';
$query_select_colums = " select products_id";

$query_from = " FROM ". TABLE_PRODUCTS . " AS p 
				LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc 
				USING(products_id) 
				";

$query_where = " WHERE p.products_status = 1 " ;

$narrow_by_count = sizeof($products_narrow_by_option_values_ids);

if (zen_not_null($products_narrow_by_option_values_ids)){
	if (1 == $narrow_by_count) {
		$where_narrow_by = " AND povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
		$listing_sql = $query_select_colums . $query_from ." INNER JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as povp 
				USING(products_id)" .$query_where.$where_narrow_by.$category_where_sql . $sql_order_by;
		
		$all_listing_sql = $query_select_colums . $query_from ." INNER JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as povp 
				USING(products_id)" .$query_where.$where_narrow_by.$category_where_sql . $sql_order_by;
	}else {
		$where_narrow_by = ' select t0.products_id from ';
		$sql_query_array = array();
		for($i = 0; $i< $narrow_by_count;$i++){
			
			$sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " 
					where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ." 
							      ) as t".$i ." ";
		}
		for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
			if($i){
				$where_narrow_by .=' CROSS JOIN';
			}
				$where_narrow_by .= $sql_query_array[$i];
			if($i){
				$where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
			}
		}
		$listing_sql = $query_select_colums . $query_from .$query_where. $category_where_sql." AND p.products_id in(".$where_narrow_by.")".$sql_order_by;
	  }
    }

  $get_products = $db->Execute($listing_sql);
  if ($get_products->RecordCount()){
    return true;
  }else{
    return false;
  }
}

function zen_get_narrow_url_has_product($url,$cid){
  global $db;
  $url = strchr($url,'_');
  //var_dump($url);
   $url_old = explode("/",$url) ; 
   
	$url_old = str_replace("t0", "",$url_old);
	$url_old = str_replace("t1", "",$url_old);
	$url_old = str_replace("t2", "",$url_old);
	$url_old = str_replace("t3", "",$url_old);
	$url_old = str_replace("t4", "",$url_old);
	$url_old = str_replace("t5", "",$url_old);
	$url_old = str_replace("t6", "",$url_old);
	//echo '<br />';
	$narrow_value = array();
    for($kk =0,$kj = 10; $kk <$kj;$kk++){
        $url_old[$kk] = strchr($url_old[$kk],'_v');
        if($url_old[$kk]){
        $narrow_value [] = str_replace("_v","",$url_old[$kk]);
        }
     }
     array_pop($narrow_value); //cancel categories 
     $has_product = zen_get_products_of_categories_narrow($cid,$narrow_value);
     
   return $has_product;      // narrow array
}


function zen_get_products_has_narrow_by_options($oid,$pid){
global $db;
$o_value = array();
$o_sql = "select products_narrow_by_options_values_id as id 
         FROM products_narrow_by_options_values_to_options as pnop
         INNER JOIN products_narrow_by_options_values as ov
         USING ( products_narrow_by_options_values_id ) 
         WHERE pnop.products_narrow_by_options_id =".(int)$oid;
$option = $db->Execute($o_sql);
while(!$option->EOF){
$o_value[] = $option->fields['id'];
$option->MoveNext();
}
if($pid){
$listing_sql = "SELECT DISTINCT products_id FROM products AS p 
LEFT JOIN products_narrow_by_option_values_to_products AS pnop USING(products_id)

WHERE p.products_status = 1 AND p.products_id IN(".join(',',$pid).") 
AND pnop.products_narrow_by_options_values_id IN (".join(',',$o_value).")";


   $get_products = $db->Execute($listing_sql);
	$products = array();
	if ($get_products->RecordCount()){
		$params_for_categories_split = zen_get_all_get_params(array('page'));
		while (!$get_products->EOF){
			$products [] = array(
				'id'  => $get_products->fields['products_id'],
			);
			$get_products->MoveNext();
		}
	$pids = array();
	foreach ($products as $ii => $pro){
					$pids []=$pro['id'];
				}
	  }
   return $pids;
}
}

function zen_get_products_of_no_narrow_for_category($current_category_id){
global $db;
$products_all = array();

	if (zen_has_category_subcategories($current_category_id)) {
		$all_subcategories_ids = array();
		zen_get_subcategories_redis($all_subcategories_ids,$current_category_id);
		$count_of_subcategories = sizeof($all_subcategories_ids);
		if ($count_of_subcategories){		
			if (1 < $count_of_subcategories) {
				$category_where_sql = " and ptc.categories_id in(".join(',',$all_subcategories_ids).")";
			}else if (1 == $count_of_subcategories) {
				$category_where_sql = " and ptc.categories_id = ".$all_subcategories_ids[0];
			}
		}else {
				$category_where_sql = " and ptc.categories_id = ".(int)$current_category_id;
		}
	}else {
	  		$category_where_sql = " and ptc.categories_id = ".(int)$current_category_id;
	  	}

$sql = "select p.products_id as id from products as p left join products_to_categories as ptc on (p.products_id = ptc.products_id)
       where p.products_status = 1 ".$category_where_sql;
$products = $db->Execute($sql);

while(!$products->EOF){
 $products_all [] = array(
  'id' => $products->fields['id']
 );
$products->MoveNext();
}
return $products_all;
}

?>