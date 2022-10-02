<?php
class fiberstore_product_info{
	
	/**
	 * 
	 * @param int $products_id
	 * @return customer viewed current product times
	 */
	function times_of_customer_viewed_current_product($products_id){
		global $db;
		$sql = " SELECT COUNT(customer_recent_viewed_id) as total FROM customers_recent_viewed_products 
				WHERE products_id = :products_id:
		";
		$sql = $db->bindVars($sql, ':products_id:', (int)$products_id, 'integer');
		$result = $db->Execute($sql);
		$total = $result->fields['total'];
		if ($total){
			return (int)$total;
		}else return 0;
		
	}
	/**
	 * 
	 * @param int $products_id
	 * @todo add customer viewed products to db
	 */
	function add_customers_viewed_products($products_id){
		$viewed_times = $this->times_of_customer_viewed_current_product($products_id);
		
		if (!$viewed_times){
			$viewed_times = 1 ;
			$viewd_products_data = array(
					'products_id' => (int)$products_id,
					'customers_id' => (int)$_SESSION['customer_id'],
					'last_viewed_time' => 'now()',
					'viewed_times' => (int)$viewed_times,
					);
			
			zen_db_perform('customers_recent_viewed_products', $viewd_products_data);
		}else {
			$viewed_times += 1 ;
			$viewd_products_data = array(
					'last_viewed_time' => 'now()',
					'viewed_times' => (int)$viewed_times,
			);
			zen_db_perform('customers_recent_viewed_products', $viewd_products_data,'update',' products_id='.(int)$products_id.' and customers_id='.(int)$_SESSION['customer_id']);
		}
	}
	/**
	 * 
	 * 
	 * @db table
	 * CREATE TABLE customers_recent_viewed_products
		(
		customer_recent_viewed_id INT(9) PRIMARY KEY AUTO_INCREMENT,
		products_id INT(9),
		customers_id INT(9),
		last_viewed_time DATETIME,
		viewed_times INT(9)
		);
	 */
	function display_customers_recent_viewed_products($products_id){
		
		global $db;
		$sql = "SELECT vp.products_id as id, p.products_price as price, p.products_image as image
				FROM customers_recent_viewed_products AS vp 
				JOIN products AS p USING(products_id) 
				WHERE customers_id = :customers_id: 
				AND p.products_status = 1 
				AND vp.products_id != :products_id: 
				ORDER BY last_viewed_time DESC,viewed_times DESC 
				LIMIT 8;
				";
		//$sql = $db->bindVars($sql, ':languages_id:', (int)$_SESSION['languages_id'], 'integer');
		$sql = $db->bindVars($sql, ':customers_id:', (int)$_SESSION['customer_id'], 'integer');
		$sql = $db->bindVars($sql, ':products_id:', (int)$products_id, 'integer');
		$result = $db->Execute($sql);
		if ($result->RecordCount()) {
			$html .=' <div class="sidebar_histor"> <i>'.FIBERSTORE_RECENT_HISTOR.'</i>
					<div>';
				
			while(!$result->EOF){
				list($products_id,$href,$products_name,$price,$image) = $this->get_one_product_info_plus($result->fields['id'], zen_get_products_name($result->fields['id']),30, $result->fields['price'], $result->fields['image'], 100, 100);
				$html .= ' 
						<div class="sidebar_histor_01">
							<a href="'.$href.'">
							'.$image.'</a>
							<a href="'.$href.'">'.$products_name.'</a>
							
							<div class="sedebar_hot_03">'.$price.'
							</div>
						</div>
				';
						
						
				$result->MoveNext();
			}
				
			$html .='
					 </div>
               </div>
					';
				
			echo $html
			;
		}
		
	}
	function display_related_categories($products_id){
		global $db;
		$html = '';
		$current_category_id = zen_get_products_category_id($products_id);
		$sql = "SELECT c.categories_id AS id,cd.categories_name AS name FROM categories  AS c 
				LEFT JOIN categories_description AS cd 
				USING (categories_id) 
				WHERE c.categories_status =1 
				AND cd.language_id = :languages_id: 
				AND c.parent_id IN 
				(
				SELECT c.parent_id FROM categories  AS c 
				LEFT JOIN categories_description AS cd 
				USING (categories_id) 
				WHERE c.categories_status =1 
				AND cd.language_id = :languages_id:
				AND c.categories_id = :categories_id: 
				) 
				LIMIT 8;";
		$sql = $db->bindVars($sql, ':languages_id:', (int)$_SESSION['languages_id'], 'integer');
		$sql = $db->bindVars($sql, ':categories_id:', (int)$current_category_id, 'integer');
		
		$result = $db->Execute($sql);
		
		if ($result->RecordCount()) {
			$html .='
		       <div class="sidebar_04 p_sidebar"> <i>'.FIBERSTORE_RELATED_CATEGORIES.'</i>
					<dl>';
			
			while(!$result->EOF){
				list($href,$name) = $this->get_one_category_info_plus($result->fields['id'], $result->fields['name'],26);
				$html .= ' <a href="'.$href.'">'.$name.'</a>';
				$result->MoveNext();
			}
			
			$html .='
					 </dl>
               </div>
					';
			
			echo $html;
		}
		
	}
	function get_one_category_info_plus($categories_id,$categories_name,$categories_name_limit = 0){
		$href = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$categories_id);
		if ($categories_name_limit){
			$categories_name = isset($categories_name{$categories_name_limit}) ? substr($categories_name, 0,$categories_name_limit-2) .'...' : $categories_name;
		}
		
		return array($href,$categories_name);
	}
	/**
	 * 
	 * @param int $products_id
	 * @todo display ultimately products
	 */
	function display_ultimately_buy_products($products_id){
		global $db;
		$html = '';
		$category_id = zen_get_products_category_id((int)$products_id);
		$sql= "select p.products_id as id, pd.products_name as name,p.products_image as image,p.products_price as price 
				 from " .TABLE_PRODUCTS . " p, " .
						 TABLE_PRODUCTS_DESCRIPTION  ." pd
		
  		where p.products_status = 1
        AND p.master_categories_id = " . (int)$category_id . "
		
  		and pd.language_id = " .(int)$_SESSION['languages_id'] . "    and p.`products_id`!=".$products_id." and p.`products_id`=pd.`products_id`
  	    ORDER by p.products_id DESC limit 8 ";
		
		$sql_master_categories = "select p.products_id as id, pd.products_name as name,p.products_image as image,p.products_price as price
				 from " .TABLE_PRODUCTS . " p, " .
						 TABLE_PRODUCTS_DESCRIPTION  ." pd
		
  		where p.products_status = 1
  		and pd.language_id = " .(int)$_SESSION['languages_id'] . "    and p.`products_id`!=".$products_id." and p.`products_id`=pd.`products_id`
  	    ORDER by p.products_id DESC limit 8 ";
		//echo "<div style=\"display:none\">'.$sql.'</div>";
		$result = $db->Execute($sql);
		$result_master_categories = $db->Execute($sql_master_categories);
		
		if ($result->RecordCount()) {
			$html .='
					<div class="sidebar_histor"> <i>'.FIBERSTORE_PRODUCT_BUY.'</i>
					<div class="centerBoxWrapper" id="similar_product">';
			while(!$result->EOF){
				list($products_id,$href,$products_name,$price,$image) = $this->get_one_product_info_plus($result->fields['id'], $result->fields['name'],62, $result->fields['price'], $result->fields['image'], 180, 180);
				
				$html .=' 
						<div class="sedebar_hot_01">
     						<a href="'.$href.'"> '.$image.'</a><br />'.
     						'<a href="'.$href.'"> '.$products_name.'</a>
     						<div class="sedebar_hot_03">'.$price.'</div>
     					</div>		
						';
				$result->MoveNext();
			}
			
			$html .='</div>
					</div>
					';
			
			echo $html;
		}else {
			
			$html .='
					<div class="sidebar_histor"> <i>'.FIBERSTORE_PRODUCT_BUY.'</i>
					<div class="centerBoxWrapper" id="similar_product">';
			while(!$result_master_categories->EOF){
				list($products_id,$href,$products_name,$price,$image) = $this->get_one_product_info_plus($result_master_categories->fields['id'], $result_master_categories->fields['name'],62, $result_master_categories->fields['price'], $result_master_categories->fields['image'], 180, 180);
			
				$html .='
						<div class="sedebar_hot_01">
     						<a href="'.$href.'"> '.$image.'</a><br />'.
			     						'<a href="'.$href.'"> '.$products_name.'</a>
     						<div class="sedebar_hot_03">'.$price.'</div>
     					</div>
						';
				$result_master_categories->MoveNext();
			}
				
			$html .='</div>
					</div>
					';
				
			echo $html;
			
		}
	}
	
	/**
	 * get products hot products
	 */
	
	function get_one_product_info_plus($products_id,$products_name,$products_name_length = 0,$products_price,$products_image,$image_width,$image_height){
		global $currencies;
		$img_src=  DIR_WS_IMAGES. (file_exists(DIR_WS_IMAGES.$products_image ) ? $products_image : 'no_picture.gif');
		$img_title = ' title="'.$products_name.'"';
		$image = zen_image($img_src,$products_name,$image_width,$image_height,$img_title);
		
		if ($products_name_length){
			$products_name = (isset($products_name{$products_name_length}) ? mb_substr($products_name, 0,$products_name_length-2,'utf-8').'...' : $products_name);
		}
		
		$href = zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id);
		
		$price = $currencies->display_price($products_price,0);
		return array($products_id,$href,$products_name,$price,$image);
	}
	function get_outdoor_product_list($cid){
		global $db;
		$categories_info = $db->getAll("select a.*,b.* from categories a,categories_description b where a.parent_id = '".$cid."' and a.categories_id = b.categories_id and b.language_id = 1  order by a.sort_order ASC");
		if(empty($categories_info)){
			$categories_info = $db->getAll("select a.*,b.* from categories a,categories_description b where a.categories_id = '".$cid."' and a.categories_id = b.categories_id and b.language_id = 1");
		}
		if($categories_info){
			foreach($categories_info as $key=>$k){
				$product_info = $db->getAll("select a.*,b.categories_id from products a,products_to_categories b where a.products_id = b.products_id and b.categories_id = '".$k['categories_id']."' and a.products_status = 1 order by products_sort_order ASC");
				
				$categories_info[$key]['products'] = $product_info;
			}
		}
		return $categories_info;
	}
}