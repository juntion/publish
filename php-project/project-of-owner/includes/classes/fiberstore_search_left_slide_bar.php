<?php
class fiberstore_search_left_slide_bar{
	
	static function get_subs_of_root_category($cid)
	{
		global $db;
		$transceivers = array();
		$sql= "select c.categories_id as id,parent_id as pid, categories_name as name from " .TABLE_CATEGORIES . " as c left join " .
				TABLE_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1 
		and c.parent_id = ".(int)$cid." 
  		and cd.language_id = " .(int)$_SESSION['languages_id'] . "
  		order by c.sort_order ";
		$result = $db->Execute($sql);
		while (!$result->EOF){
			$transceivers [] = array(
					'id'=>$result->fields['id'],
					'name'=>$result->fields['name'],
					'subs'=>fiberstore_search_left_slide_bar::get_second_categories($result->fields['id']));
			$result->MoveNext();
		}
		return $transceivers;
	}

	
		static function get_second_categories($pid)
	{
		global $db;
		$arr = array();
		$sql= "select c.categories_id as id,parent_id as pid,categories_image as image, categories_name as name,categories_description as description  from " .TABLE_CATEGORIES . " as c left join " .
				TABLE_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1
  		and cd.language_id = " .(int)$_SESSION['languages_id'] . " 
  		and c.parent_id = ".(int)$pid ." 
  		order by c.sort_order ";
		$result = $db->Execute($sql);
		$i =0;
		while (!$result->EOF){
			$arr [] = array(
					'id'=>$result->fields['id'],
					'name'=>$result->fields['name'],
					'image'=>$result->fields['image'],
					'description' => $result->fields['description'],
					);
			$result->MoveNext();
		}
		return $arr;
	}
	
	//keywords
	static function get_sub_categories_of_current_category($cid){
		return fiberstore_search_left_slide_bar::get_second_categories($cid);
	}

	static function get_categories_id_by_categories_id($categories_id){
		global $db;
		$arr = '';
	
		$arr = fiberstore_search_left_slide_bar::display_search_subcategories_id(fiberstore_search_left_slide_bar::get_subs_of_root_category($categories_id));
		return $arr;
	}
	static function display_search_subcategories_id($categories){
		$ids = array();
		for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
			$id = $categories[$i]['id'];
			$name = $categories[$i]['name'];
			$subs = $categories[$i]['subs'];
				
			$ids []=$id;
			if(sizeof($subs)){
				foreach ($subs as $ii => $category){
					$ids []=$category['id'];
				}
			}
		}
		return $ids;
	}

}