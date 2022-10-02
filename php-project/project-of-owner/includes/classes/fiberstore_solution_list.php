<?php
class fiberstore_solution_list{

//查找二级分类下的三级分类
	static function get_subs_of_root_category($cid)
	{
		global $db;
		$transceivers = array();
		$sql= "select c.doc_categories_id as id,doc_parent_id as pid, doc_categories_name as name from " .TABLE_SOLUTION_CATEGORIES . " as c left join " .
				TABLE_SOLUTION_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.doc_categories_id = cd.doc_categories_id)
  		where  c.doc_parent_id = ".(int)$cid." 
  		and  cd.language_id = ".(int)$_SESSION['languages_id']."
  		 ";
		$result = $db->Execute($sql);
		while (!$result->EOF){
			$transceivers [] = array(
					'id'=>$result->fields['id'],
					'name'=>$result->fields['name'],
					'subs'=>fiberstore_solution_list::get_second_categories($result->fields['id']));
			$result->MoveNext();
		}
		return $transceivers;
	}

	
		static function get_second_categories($pid)
	{
		global $db;
		$arr = array();
		$sql= "select c.doc_categories_id as id,doc_parent_id as pid, doc_categories_name as name,doc_categories_description as description  from " .TABLE_SOLUTION_CATEGORIES . " as c left join " .
				TABLE_SOLUTION_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.doc_categories_id = cd.doc_categories_id)
  		where  c.doc_parent_id = ".(int)$pid ." 
  		and  cd.language_id = ".(int)$_SESSION['languages_id']."
        ";
		$result = $db->Execute($sql);
		$i =0;
		while (!$result->EOF){
			$arr [] = array(
					'id'=>$result->fields['id'],
					'name'=>$result->fields['name'],
					'description' => $result->fields['description'],
					);
			$result->MoveNext();
		}
		return $arr;
	}
	
	//keywords
	static function get_sub_categories_of_current_category($cid){
		return fiberstore_solution_list::get_second_categories($cid);
	}

	
	static function get_categories_id_by_categories_id($categories_id){
		global $db;
		$arr = '';
	
		$arr = fiberstore_solution_list::display_search_subcategories_id(fiberstore_solution_list::get_subs_of_root_category($categories_id));
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
//	三级分类下的文章
  function zen_get_article_of_solution_category($categories_id) {
    global $db;
    $subcategories_array = array();
    $subcategories_query = "select doc_categories_id,a.doc_article_id,ad.doc_article_title,ad.doc_article_content
                            from " . TABLE_SOLUTION_ARTICLE . " as a 
                            left join ".TABLE_SOLUTION_ARTICLE_DESCRIPTION ." as ad using(doc_article_id) 
                            left join ".TABLE_SOLUTION_ARTICLE_CATEGORY ." as ac using(doc_article_id)
                            where 
                            a.doc_article_id=ad.doc_article_id
                            and a.doc_article_id=ac.doc_article_id
                            and doc_article_status = 1
                            and a.language_id = ".(int)$_SESSION['languages_id']."		
                            and doc_categories_id = '" . (int)$categories_id . "' 
                             order by doc_article_last_modified limit 6
                            ";

    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {
      $subcategories_array[] = $subcategories->fields['doc_article_id'];
      $subcategories->MoveNext();
    }
   //  var_dump($subcategories_array);
    return $subcategories_array;
  }
	
//三级分类
  function zen_get_subcategories_of_solution_category($categories_id) {
    global $db;
    $subcategories_array = array();
    $subcategories_query = "select doc_categories_id
                            from " . TABLE_SOLUTION_CATEGORIES . " as c 
                            left join ".TABLE_SOLUTION_CATEGORIES_DESCRIPTION ." as cd 
                            using(doc_categories_id) 
                            where 
                            language_id = ".(int)$_SESSION['languages_id']."		
                            and doc_parent_id = '" . (int)$categories_id . "' 

                            ";

    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {
      $subcategories_array[] = $subcategories->fields['doc_categories_id'];
      $subcategories->MoveNext();
    }
   //  var_dump($subcategories_array);
    return $subcategories_array;
  }

   //查找二级分类
   function get_third_categories_of_top_solution_category($top_category_id){
   		$all_third_categories = array();
   		$second_categories = $this->zen_get_subcategories_of_solution_category($top_category_id);  //所有二级分类
   		$size = sizeof($second_categories);
   		
   		$ss_id=$this->zen_get_subcategories_of_solution_category(33); 
   		//var_dump($this->zen_get_subcategories_of_solution_category(33));
   		
   		if ($size) {
   			foreach ($second_categories as $k => $category){   //$category这时候是三级分类的ID了  40 41 42 43 ……
   			  // $category['doc_categories_id'];
   				$temp_array = $this->zen_get_article_of_solution_category($category); //所有三级分类
   				$all_third_categories = array_merge($all_third_categories,$temp_array);
   			}
   		}
   	
   		return $all_third_categories;
   	//	var_dump($all_third_categories);
   }
   
   //查找所有一级分类                  40 41 42
   function get_all_solution_categories(){
   		global $db;
   		$categories = array();
   		$sql = "SELECT c.doc_categories_id AS id , cd.doc_categories_name AS name,c.doc_categories_image as image,c.doc_categories_image_attribute as image_alt
   		        FROM ".TABLE_SOLUTION_CATEGORIES." AS c
				LEFT JOIN ".TABLE_SOLUTION_CATEGORIES_DESCRIPTION." AS cd 
				ON (c.doc_categories_id = cd.doc_categories_id AND cd.language_id = :languages_id:) 
				WHERE c.doc_parent_id = 0 and doc_categories_status = 1
                 and  language_id = ".(int)$_SESSION['languages_id']."
                 order by  c.doc_sort_order
                
				;";
   		$sql = $db->bindVars($sql,':languages_id:',(int)$_SESSION['languages_id'],'integer');
   		$result = $db->Execute($sql);
   		while (!$result->EOF) {
   			$thirdCategories = $this->get_third_categories_of_top_solution_category($result->fields['id']);   //查找二级分类  33 50
   			$categories [] = array(
   			'id' => $result->fields['id'],'image' => $result->fields['image'],'image_alt' => $result->fields['image_alt'],'name' => $result->fields['name'],'third'=>$thirdCategories
   			);
   			$result->MoveNext();
   		}
   		
   		return $categories;
   }
   
  function zen_get_sub_of_solution_category($categories_id) {
    global $db;
    $subcategories_array = array();
    $subcategories_query = "select doc_categories_id,doc_categories_name
                            from " . TABLE_SOLUTION_CATEGORIES . " as c 
                            left join ".TABLE_SOLUTION_CATEGORIES_DESCRIPTION ." as cd 
                            using(doc_categories_id) 
                            where 
                            language_id = ".(int)$_SESSION['languages_id']."		
                            and doc_parent_id = '" . (int)$categories_id . "'
                            order by  doc_categories_id

                            ";

    $subcategories = $db->Execute($subcategories_query);

      while (!$subcategories->EOF) {
      $subcategories_array[] =  array('id' => $subcategories->fields['doc_categories_id'],'name' => $subcategories->fields['doc_categories_name']);
      $subcategories->MoveNext();
    }
   //  var_dump($subcategories_array);
    return $subcategories_array;
  }
   
   
   /**
    * get all categories list 
    */
   function buildsolutionTree(){
   		global $db;
   		$html = '';
   		$all_categories = $this->get_all_solution_categories();

   		$size = sizeof($all_categories);
   		if ($size) {
   		$html .= '<div class="product_index_con"> ';
   			foreach ($all_categories as $i => $top){
               $image_src = 'http://www.fiberstore.com/images/'.$top['image'];
   				$html .='
   				<dl>
   				<dt><a href="'. zen_href_link('products_list','&s_cid='.$top['id']) .'">
   				<img border="0"  alt="'. $top['image_alt'].'" title="'. $top['image_alt'].'" src="'. $image_src .'" width="225" height="130"></a>
                <h3><a href="'. zen_href_link('products_list','&s_cid='.$top['id']) .'">'.$top['name'].'</a></h3>
                </dt>
   				';
   				$all_subcategory = $this->zen_get_sub_of_solution_category($top['id']);
   				
   		for ($h=0, $n = sizeof($all_subcategory); $h < $n; $h++){
   			$cid = $all_subcategory[$h]['id'];  
   			
   			$html .= '	
   				 <dd>
          <ul> ';

   			  $article_list="select ad.doc_article_id,ad.doc_article_title,a.doc_article_image from " . TABLE_SOLUTION_ARTICLE_DESCRIPTION ." as ad left join 
					            
                     " . TABLE_SOLUTION_ARTICLE_CATEGORY ." as ac  using(doc_article_id) 
                     left join ".TABLE_SOLUTION_ARTICLE." as a using(doc_article_id)
                     
                     where ad.language_id = '".$_SESSION['languages_id']."'
                        and ac.doc_categories_id=".intval($cid)."   
						
						and doc_article_status = 1
						order by doc_article_sort_order limit 3 ";
					    $get_article = $db->Execute($article_list);
					    $article_array = array();
			                while(!$get_article->EOF){
					
							$article_array[] = array(
									'doc_article_id' => $get_article->fields['doc_article_id'],
									'doc_article_title' => $get_article->fields['doc_article_title'],
							        'doc_article_image' => $get_article->fields['doc_article_image']
							);
							$get_article->MoveNext();
				}

   					$flag = 0;
   					for ($k=0, $m = sizeof($article_array); $k < $m; $k++){
			                  $a_href = zen_href_link(FILENAME_PRODUCTS_DETAIL,'&s_id='.$article_array[$k]['doc_article_id']);     
			                  $aid = $article_array[$k]['doc_article_id'];
			                  $artilce_title = $article_array[$k]['doc_article_title'];
   						
   						$html .='<li><a href="'.zen_href_link('products_detail','s_id='.$article_array[$k]['doc_article_id']).'">'.zen_get_solution_article_name($aid).'</a>
   						       </li>  
   						';
                      if($k >1){
                       $html .='<li class="more"><a href="'. zen_href_link('products_list','&s_cid='.$top['id']) .'">More  +</a></li>';
                       break;
                      }
   					}
                 
              	 $html .='</dd>
                         </ul>';
              	 
   			   }
   				 $html .='<div class="ccc"></div>
   				 </dl>
   				 ';
   			 }
   			 $html .='</div>';
   		}
   		echo $html;
   }
 
 //查找所有三级下的文章
 

   function solutionTree(){
   		global $db;
   		$html = '';
   		$all_categories = $this->get_all_solution_categories();
   		$size = sizeof($all_categories);
   		if ($size) {
   			foreach ($all_categories as $i => $top){
   				$html .= '
   				 <dl class="solution_nav_01" id="nav"> 
   				 <dt>';
   				
   				if($top['id'] == zen_get_solution_article_id_of_category_id($_GET['s_id']) && $_GET['s_id'] != '' ){
		          $html .= '   <a href="javascript:void(0);"  class="solution_nav_js">  '.$top['name'].'</a>';
   				}else{
   				 $html .= '   <a href="javascript:void(0);"  class="solution_nav_ForJS">  '.$top['name'].'</a>';
   				}
   			
   				if (sizeof($top['third'])) {
   					$flag = 0;
   					foreach ($top['third'] as $ii => $category){
   						
   						if($category == $_GET['s_id']){
   						$html .='<dd class="sidebar_products" style="display:block;"><a href="'.zen_href_link('solution_detail','s_id='.$category).'"><span>'.zen_get_solution_article_name($category).'</span> </a></dd>';
   						}else{
   						$html .='<dd style="display:block;"><a href="'.zen_href_link('solution_detail','s_id='.$category).'">'.zen_get_solution_article_name($category).'</a>';
   						
   						}
   						
   			//
   					}
   				}
   				
              	 $html .='</ul>	</div></div>';
              
              	 
   			}
   		}
   		echo $html;
   }
   
   
   
   
   
   
   function solutionarticle(){
   		global $db;
   		$html = '';
   		$all_categories = $this->get_all_solution_categories(2);
   		$size = sizeof($all_categories);
   		if ($size) {
   			foreach ($all_categories as $i => $top){

   			
   				if (sizeof($top['third'])) {
   					$flag = 0;
   					foreach ($top['third'] as $ii => $category){
   						$time=date('F j, Y',strtotime(zen_get_solution_article_time($category)));
   						$html .='<dd><a href="'.zen_href_link('solution_detail','s_id='.$category).'">'.zen_get_solution_article_name($category).'</a></dd>';
   					if($n >5)break;
   					}
   				}

              	 
   			}
   		}
   		echo $html;
   }
 
 //查找所有三级下的文章
 
}





