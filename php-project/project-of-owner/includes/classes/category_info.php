<?php
class category_info{
	/**
	 * @var string $query_categories
	 * @var array $categories
	 */
	private $query_categories = '';
	function __construct(){
	}
	
	
	function get_narrow_description($category_id){
		global $db;
		$get_narrow = $db->Execute("select categories_narrow_by_values from " . TABLE_CATEGORIES . " where categories_id = ". (int)$category_id);
		return $get_narrow->fields['categories_narrow_by_values'];
	}
	/**
	 * get category info, eg: name,description
	 * or
	 * get sub categories that under this category
	 * @param int $current_category_id
	 */
	function get_current_category_info_or_subs($witch_type,$current_category_id){
		global $db;
		$categories = array();
		if ('info' == $witch_type){
			$this->query_categories = "select c.categories_id,cd.categories_name, cd.categories_description,cd.categories_introduction from " . TABLE_CATEGORIES . " as c 
			inner join " . TABLE_CATEGORIES_DESCRIPTION .
			" as cd using(categories_id) 
			where categories_status = 1 
			and language_id = ".(int)$_SESSION['languages_id'] . " 
			and categories_id = :categories_id  
			order by sort_order 
			";
		}else{
			$this->query_categories = "select c.categories_id,c.categories_image,cd.categories_name, cd.categories_description,cd.categories_introduction from " . TABLE_CATEGORIES . " as c 
			inner join " . TABLE_CATEGORIES_DESCRIPTION .
			" as cd using(categories_id) 
			where categories_status = 1 
			and language_id = ".(int)$_SESSION['languages_id'] . " 
			and parent_id = :categories_id  
			order by sort_order 
			";
		}
		$get_categories = $db->Execute($db->bindVars($this->query_categories, ':categories_id', $current_category_id, 'integer'));
		
		if ($get_categories->RecordCount()){
			if('info' == $witch_type){
				$categories['id'] = $get_categories->fields['categories_id'];
				$categories['name'] = $get_categories->fields['categories_name'];
				$categories['description']=$get_categories->fields['categories_description'];
				$categories['introduction']= $get_categories->fields['categories_introduction'];					
				
			}else {
				while (!$get_categories->EOF){
					$categories [] = array(
						'id' => $get_categories->fields['categories_id'],
						'name' => $get_categories->fields['categories_name'],
						'image' => $get_categories->fields['categories_image'],
						'description' => $get_categories->fields['categories_description'],
						'introduction' => $get_categories->fields['categories_introduction']					
					);
					$get_categories->MoveNext();
				}
			}
		}
		return $categories;
	}
	
	/**
	 * 
	 * get catgegory info for only module
	 * @param int $categories_id
	 */
	function get_index_only_category_info($categories_id){
		return array(
			'info' => $this->get_current_category_info_or_subs('info', $categories_id),
			'subs' => $this->get_current_category_info_or_subs('subs', $categories_id)
		);
	}
	
	/**
	 * get catgegory info for julia module
	 */
	function get_index_julia_category_info($categories_id){
		return array(
			'info' => $this->get_current_category_info_or_subs('info', $categories_id),
			'subs' => $this->get_current_category_info_or_subs('subs', $categories_id)
		);
	}
	
	/**
	 * 
	 * get catgegory info for mechelle module
	 * @param unknown_type $categories_id
	 */
	function get_index_mechelle_category_info($categories_id){
		return array(
			'info' => $this->get_current_category_info_or_subs('info', $categories_id),
			'subs' => $this->get_current_category_info_or_subs('subs', $categories_id)
		);
	}
	
	
	/**
	 * get products under this category
	 */
	
	function get_products_under_the_category($category_id){
		global $db;
		$products = array();
		
		$products_list = "select * from " . TABLE_PRODUCTS_DESCRIPTION . " as pd 
			left join " . TABLE_PRODUCTS . " as p using(products_id)
			left join " . TABLE_PRODUCTS_TO_CATEGORIES . " as ptc using(products_id)
			where pd.language_id = " .intval($_SESSION['languages_id']) ." 
			and p.products_status = 1 
			and ptc.categories_id =".intval($category_id);
		
		$products_list .= " order by p.products_sort_order, pd.products_name";
		$get_products = $db->Execute($products_list);
		
		while (!$get_products->EOF){
			$products [] = array(
				'products_id' => $get_products->fields['products_id'],
				'products_name' => $get_products->fields['products_name'],
				'products_price' => $get_products->fields['products_price'],
				'products_SKU' => $get_products->fields['products_SKU'],
				'products_image' => $get_products->fields['products_image']
			);
			$get_products->MoveNext();
		}
		
		return $products;
	}
	/**
	 * 
	 * @param int $categories_id
	 * @return boolean
	 * @todo check currenct category is arrive soon
	 */
	function category_is_arrive_soon($categories_id){
		global $db;
		$is_arrive_soon = false ;
		$sql = "SELECT is_arrive_soon FROM categories WHERE categories_id = :categories_id:";
		$sql = $db->bindVars($sql,':categories_id:',$categories_id,'integer');
		$result = $db->Execute($sql);
		if (1 == $result->fields['is_arrive_soon']) {
			$is_arrive_soon = true;
		}
		return $is_arrive_soon;
	}
	function display_categories($current_category_id){
		$html = '';
		

		$file_path = DIR_FS_SQL_CACHE.'/htmls/';
        $file_name = 'top_category_right_'.$current_category_id.'.html';
        $file_path_name = $file_path.$file_name;
		
		//if cache file exists, read it and return
		if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
			return $html;
		}
		
		$sub_categories = $this->get_current_category_info_or_subs('subs',$current_category_id);
		if (($counts = sizeof($sub_categories))){

			$html .= '<div class="main_content_one min_category">
						<div class="main_content_01">
						<div class="main_content_02">';
			
			for ($i = 0; $i < $counts; $i++) {
				$img_src = (file_exists(DIR_WS_IMAGES.$sub_categories[$i]['image'])) ? DIR_WS_IMAGES.$sub_categories[$i]['image'] : DIR_WS_IMAGES.'no_picture.gif';
				$html .= '<dl>';
				$html .= '
						
                              <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$sub_categories[$i]['id']).'">'.zen_image($img_src,zen_get_categories_name($sub_categories[$i]['id'])).'
                              	<i></i><h3>'.zen_get_categories_name($sub_categories[$i]['id'])
                              	.'</h3></a>
                              </dt><dd><ul>';
				
				$sub_categories2 = array();
				if(get_fiberstore_parent_categories_id($sub_categories[$i]['id'])!=573)$sub_categories2 = $this->get_current_category_info_or_subs('subs',$sub_categories[$i]['id']);
							  
				if (sizeof($sub_categories2)){
					foreach ($sub_categories2 as $ii => $category){
						$html .= '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id']).'">'.$category['name'].'</a></li>';
					}
				}else{
					//add arrive soon icon
					if ($this->category_is_arrive_soon((int)$sub_categories[$i]['id'])) {
						$html .='<a class="arrive_soon"></a>';
					}
				}
				$html .= '
                           
                         </ul></dd></dl>
				';
				
			   if(0 < $i && 0 == ($i+1)%4){
					$html .= ' 
					<div id="cc_'. $i .'" class="ccc"></div>
					';
				}
				
				if(0 < $i && 0 == ($i+1)%3){
					$html .= ' 
					<div id="ccc_'. $i .'" ></div>
					';
				}
				
			}
			
			$html .= '
			 		<div class="ccc"></div>
               </div></div></div>
			';
		}
		
		
		//cache categories html contents
		cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
		return $html;
		
		
	}
}