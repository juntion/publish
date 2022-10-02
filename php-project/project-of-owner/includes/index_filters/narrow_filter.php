<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

//get narrow by values id
$products_narrow_by_option_values_ids = array();

if (isset($_GET['narrow']) && is_array($_GET['narrow']))  {
	foreach ($_GET['narrow'] as $key => $value){
		$products_narrow_by_option_values_ids [] = (int)$value;
	}
}
$get_narrow = $_GET['narrow'];
//BOF sort order
//$sql_order_by = ' ORDER BY p.products_sort_order';
//$sql_order_by = ' ORDER BY p.products_sort_order asc ';
$Sale_sort = categories_products_sort_list($current_category_id);
//if($cPath_array[0] == 9 || $Sale_sort == 1){
//$sql_order_by = ' group by p.products_id order by CASE WHEN products_in_stock="1" || products_in_stock="2"  THEN 1 WHEN products_in_stock="0" THEN 2 END, p.products_sort_order asc';
//}else{
//$sql_order_by = ' ORDER BY CASE WHEN products_in_stock="1" || products_in_stock="2" THEN 1 WHEN products_in_stock="0"  THEN 2 END,p.products_sort_order asc ';
//}
$sql_order_by = ' ORDER BY p.products_sort_order asc ';
if(isset($_GET['sort_order']) && $_GET['sort_order'])
{
	switch ($_GET['sort_order']){
		case 'priced':
			$sql_order_by = " order by p.products_price desc ";
			break;
		case 'price':
			$sql_order_by = " order by p.products_price ";
			break;
		case 'sellers':
			$sql_order_by = " group by p.products_id order by sales desc ";
			break;
		case 'rate':
			$sql_order_by = " group by p.products_id order by rating desc ";
			break;
		case 'new':
			$sql_order_by = " order by p.products_date_added desc ";
			break;

		case 'productname':
			$sql_order_by = " order by pd.products_name ";
			break;
		case 'productnamed':
			$sql_order_by = " order by pd.products_name desc ";
			break;

		case 'popularity':
		default:
			$sql_order_by = " order by p.products_sort_order asc  ";
			break;
	}
}
//EOF sort order

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

//先查当前分类下的所有产品id
$query_select_colums = " select distinct products_id,products_image,p.products_price ,products_SKU,p.products_model,is_inquiry, is_min_order_qty,wavelenght,distance,data_rate";

$query_from = " FROM ". TABLE_PRODUCTS . " AS p
 LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc USING(products_id) ";

$query_where = " WHERE  p.products_status = 1 ".$category_where_sql;

/*2015.9.29 beyond*/
if($_GET['sort_order'] == 'sellers'){
	$query_select_colums .= ",sum(op.products_quantity) as sales ";
	$query_from .= " left join orders_products as op using(products_id) ";
}
if($_GET['sort_order'] == 'rate'){
	$query_select_colums .= ",count(rd.reviews_id) as rating ";
	$query_from .= " left join reviews as r using(products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =".(int)$_SESSION['languages_id'] .") ";
}
/*end*/

//use cross join to get products  from narrow by
$narrow_by_count = sizeof($products_narrow_by_option_values_ids);
if (zen_not_null($products_narrow_by_option_values_ids)){
	if (1 == $narrow_by_count) {
		$where_narrow_by = " AND povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
		$listing_sql = $query_select_colums . $query_from ." INNER JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as povp
				USING(products_id)" .$query_where.$where_narrow_by . $sql_order_by;

		$all_listing_sql = $query_select_colums . $query_from ." INNER JOIN ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as povp
				USING(products_id)" .$query_where.$where_narrow_by . $sql_order_by;
	}else {
		$where_narrow_by = ' select t0.products_id from ';
		$sql_query_array = array();
		for($i = 0; $i< $narrow_by_count;$i++){
//查询符合筛选项的产品ID
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
		$listing_sql = $query_select_colums . $query_from .$query_where. " AND p.products_id in(".$where_narrow_by.")".$sql_order_by;
		$all_listing_sql = $query_select_colums . $query_from .$query_where. " AND p.products_id in(".$where_narrow_by.")".$sql_order_by;

	}
}

$all_products = $db->Execute($all_listing_sql);

//reset the number of products in one page
//$count = 36;
$count = 24;

if (isset($_GET['count']) && intval($_GET['count'])) $count = intval($_GET['count']);
if (isset($_GET['settab']) && $_GET['settab']){ $settab = $_GET['settab']; }else{ $settab = 'two'; }


$listing_split = new splitPageResults($listing_sql, $count, 'products_id', 'page');

$get_products = $db->Execute($listing_split->sql_query);

if ($listing_split->number_of_rows < 1){
	$all_product ='';
	//筛选页面没有产品时,跳转到当前分类下面
	if(sizeof($products) < 1){
		zen_redirect(zen_href_link('index','cPath='.$current_category_id));
	}

}
else{
	$products = array();
	if ($get_products->RecordCount()){
		$params_for_categories_split = zen_get_all_get_params(array('page','count','settab'));
		if (isset($current_category_id)) $params_for_categories_split = zen_get_all_get_params(array('page','cPath','count','settab')).'&cPath='.$current_category_id;

		//$page_links = $listing_split->display_links(5,$params_for_categories_split);
		//$page_top_links = $listing_split->display_top_links_extra(1,$params_for_categories_split);

		if(!(isset($_GET['sort_order']) && $_GET['sort_order'])){ $params_for_categories_split .= '&sort_order=popularity'; }
		$params_for_categories_split .= '&count='.$count.'&settab='.$settab;
		//$page_top_links = $listing_split->display_top_links_listing(1,$params_for_categories_split);
//	 	$page_links = $listing_split->display_links_listing(1,$params_for_categories_split);
//	 	$page_top_links = $page_links ;
//	    $page_jump_links = zen_href_link($_GET['main_page'],$params_for_categories_split)  ;

		$params_for_categories_split = zen_get_all_get_params(array('page'));
		if (isset($current_category_id)) $params_for_categories_split = zen_get_all_get_params(array('page','cPath')).'&cPath='.$current_category_id;
		$page_links = $listing_split->display_links_listing(1,$params_for_categories_split);
		$page_top_links = $page_links ;
		$page_jump_links = zen_href_link($_GET['main_page'],$params_for_categories_split)  ;

		while (!$get_products->EOF){
			$products [] = array(
					'id'  => $get_products->fields['products_id'],
					'name'  => zen_get_products_name($get_products->fields['products_id']),
					'image'  => $get_products->fields['products_image'],
					'price'  => $get_products->fields['products_price'],
					'description'  => zen_get_products_name($get_products->fields['products_id']),
					'sku' => $get_products->fields['products_SKU'],
					'model'	=> $get_products->fields['products_model'],
					'is_inquiry'	=> $get_products->fields['is_inquiry'],
					'is_min_order_qty'	=> $get_products->fields['is_min_order_qty'],
					'wavelenght' => $get_products->fields['wavelenght'],
					'distance' => $get_products->fields['distance'],
					'data_rate' => $get_products->fields['data_rate']
			);
			$get_products->MoveNext();
		}
	}
	/* update by melo */
	$all_product = array();
	if ($all_products->RecordCount()){
		while (!$all_products->EOF){
			$all_product [] = array(
					'id'  => $all_products->fields['products_id'],
					'name'  => zen_get_products_name($all_products->fields['products_id']),
					'image'  => $all_products->fields['products_image'],
					'price'  => $all_products->fields['products_price'],
					'description'  => zen_get_products_name($all_products->fields['products_id']),
					'sku' => $all_products->fields['products_SKU'],
					'model'	=> $all_products->fields['products_model'],
					'is_inquiry'	=> $all_products->fields['is_inquiry'],
					'is_min_order_qty'	=> $all_products->fields['is_min_order_qty'],
					'wavelenght' => $all_products->fields['wavelenght'],
					'distance' => $all_products->fields['distance'],
					'data_rate' => $all_products->fields['data_rate']
			);
			$all_products->MoveNext();
		}
	}
	/* eof */
	$page_total = (int)$listing_split->current_page_number;

// if((int)$_GET['page'] == 1 && $page_total ==1){
// zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND));
// }



	if($_GET['type']){
		if($_GET['narrow']){
			zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND));
		}else{
			zen_redirect(zen_href_link('index','cPath='.$current_category_id));
		}
	}
}

