<?php 
  function zen_get_fiberstore_popular_tag_type(){
   global $db;
    $key_arr = array();
    $sql = "select tag_id,tag_name from products_tag_type";
	$key_tag = $db->Execute($sql);
  		if ($key_tag->RecordCount()){
			while (!$key_tag->EOF){
				$key_arr[] = array(
						'id' => $key_tag->fields['tag_id'],
                        'type' => $key_tag->fields['tag_name'],
                        'list_href' => zen_href_link('Product_List','&tag_type='.$key_tag->fields['tag_id']),
				);
				$key_tag->MoveNext();
			}
		}
	 return $key_arr;	
  }

  function zen_get_popular_tag_type($id){
   global $db;
   $sql = "select tag_name from products_tag_type where tag_id =".(int)$id;
   $tag = $db->Execute($sql);
   return $tag->fields['tag_name'];
  }
  
  function zen_get_fiberstore_popular_tag($key){
   global $db;
    $key_arr = array();
    $sql = "select products_tag,tag_keywords,tag_url from products_tags 
            where tag_type = '". $key ."' 
            order by products_tag desc limit 3 
           ";
	$key_tag = $db->Execute($sql);
  		if ($key_tag->RecordCount()){
			while (!$key_tag->EOF){
				$key_arr[] = array(
						'id' => $key_tag->fields['products_tag'],
				        'key' => $key_tag->fields['tag_keywords'],
						'url' => $key_tag->fields['tag_url'],

				);
				$key_tag->MoveNext();
			}
		}
	 return $key_arr;	
  }
?>