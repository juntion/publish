<?php

class fiberstore_categories_banner{

	function get_categories_banner_by_categories_id($categories_id){
		global $db;

		$picture [] = array();
		$sql ="	 select banner_image as image ,banner_link as link from ".TABLE_CATEGORIES_BANNER." where categories_id = ".$categories_id." and languages_id = ".(int)$_SESSION['languages_id']." order by banner_id	";
		$categories_banner = $db->Execute($sql);
	
		if(zen_get_categories_name($categories_id) != null)
			$categories_names = zen_get_categories_name($categories_id);
		else $categories_names = zen_get_products_name_banner($categories_id);
		
		if($categories_banner->RecordCount() > 0){
	
			$path = "images/categories_banner/".$categories_names;
			$categories_name = str_replace(' ','-',$categories_names);
	
			while (!$categories_banner->EOF) {
				$picture [] = array(
						'image' => $categories_banner->fields['image'],
						'link' => $categories_banner->fields['link']
				);
				$categories_banner->MoveNext();
				}
			}
	
	
			echo '<div class="sidebar_ad"><dl>';
			for ($m = 1,$n =sizeof($picture); $m < $n;$m++){
				$image = $picture[$m]['image'];
				$pic = "/".$image;
				$link = $picture[$m]['link'];
				if(isset($image) && $image != null)
						//echo '<dd><a href="'.$link.'">'.zen_image(DIR_WS_IMAGES."categories_banner/$categories_name$pic ",'','','',' border="0" ')."<i></i></a></dd>";
						echo '<dd><a href="'.$link.'"><img src='.DIR_WS_IMAGES."categories_banner/$categories_name$pic".'><i></i></a></dd>';
				}
				echo '	</dl> </div>';
		
			
	}
	
	function get_bannner_by_products_id($products_id){
		
		global $db;
		$sql = "select categories_id as id from ".TABLE_CATEGORIES_BANNER." where categories_id = :products_id: AND languages_id = ".(int)$_SESSION['languages_id']."";
		
		$sql = $db->bindVars($sql,':products_id:',(int)$products_id,'integer');
		$result = $db->Execute($sql);
		
		return $result->fields['id'];

	}
	
	
	
	
	
}
