<?php 
  $str = $_SERVER['HTTP_REFERER'];
  $sid=explode("sid-",$str);

  list($s_id, $url) = split ('[..-]', $sid[1]);
?>
<div class="con_left">
  <div class="solution_nav"> <b>Products Info</b>

<?php



 $article_categories_id  = zen_get_solution_article_id_of_category_id($s_id);
  	$tutorial_query = "select doc_categories_id,doc_categories_name from " . TABLE_SOLUTION_CATEGORIES ." as c left join " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION ." as cd
	using(doc_categories_id) where cd.language_id = '".$_SESSION['languages_id']."'  and doc_parent_id=0
	order by  doc_sort_order
	";
	$get_categories = $db->Execute($tutorial_query);
	//$c_id = $get_categories->fields['doc_categories_id'];
	$solution_array = array();

	while(!$get_categories->EOF){

		$solution_array[] = array(
				'doc_categories_id' => $get_categories->fields['doc_categories_id'],
				'doc_categories_name' => $get_categories->fields['doc_categories_name'],
		);
		$get_categories->MoveNext();
	}
    ?>
 
         <?php for ($i=0, $n = sizeof($solution_array); $i < $n; $i++){?>
                  
		                      <dl class="solution_nav_01" id="nav"> 
		                      <dt>
		                      <?php if($solution_array[$i]['doc_categories_id'] ==  zen_get_solution_article_id_of_category_id($s_id) && $s_id != '' ){?>
		                      <a href="javascript:void(0);"  class="solution_nav_js">
		                      <?php echo $solution_array[$i]['doc_categories_name'];?></a>
	                          <?php }else{ ?> 
	                          <a href="javascript:void(0);"  class="solution_nav_ForJS">
		                      <?php echo $solution_array[$i]['doc_categories_name'];?></a>
		                      <?php }?>
		                      </dt>
              
		 
         
           <?php  $cid=$solution_array[$i]['doc_categories_id'];   ?>

          <?php 

		  	$sub_query = "select doc_categories_id,doc_categories_name from " . TABLE_SOLUTION_CATEGORIES ." as c left join " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION ." as cd
			using(doc_categories_id) where cd.language_id = '".$_SESSION['languages_id']."'  and doc_parent_id='".$cid."'
			order by doc_categories_id
			";
			$get_category = $db->Execute($sub_query);
			//$c_id = $get_categories->fields['doc_categories_id'];
			$sub_array = array();
		
			while(!$get_category->EOF){
		
				$sub_array[] = array(
						'doc_categories_id' => $get_category->fields['doc_categories_id'],
						'doc_categories_name' => $get_category->fields['doc_categories_name'],
		
				);
				$get_category->MoveNext();
			}

          ?>
           <?php for ($k=0, $m = sizeof($sub_array); $k < $m; $k++){
           $pid=$sub_array[$k]['doc_categories_id'];   ?>
           
             <?php 

             $articles_query = "select ad.doc_article_id,ac.doc_categories_id,ad.doc_article_title,ad.doc_article_content,a.doc_article_image,a.doc_article_date_added from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id)
		left join " . TABLE_SOLUTION_ARTICLE_CATEGORY . " as ac  using(doc_article_id)
		where doc_categories_id = '".intval($pid)."'
		order by doc_article_sort_order
		";
		$get_articles = $db->Execute($articles_query);
         $article_two_array  = array();
		if ($get_articles->RecordCount()){
			while (!$get_articles->EOF){
				$article_two_array[] = array(
						'id' => $get_articles->fields['doc_article_id'],
				        'cid' => $get_articles->fields['doc_categories_id'],
						'title' => $get_articles->fields['doc_article_title'],
						'content' => stripslashes($get_articles->fields['doc_article_content']),
				        'image' => stripslashes($get_articles->fields['doc_article_image']),
						'add_time' => $get_articles->fields['doc_article_date_added']
				);
				$get_articles->MoveNext();
			}
		}
                 ?>
		                      
		                      
		                      
		                      
		                      
		                      
							  <?php 
					            foreach ($article_two_array as $l => $article){
					            	$article_href = zen_href_link(FILENAME_PRODUCTS_DETAIL,'&s_id='.$article['id']);    
					            	//$article_href = zen_href_link('solution_detail','&s_id='.$article['id']);
					            	$article_title = $article['title'];
					            	$article_image=  $article['image'];
					
					            ?>

		                           <?php if($solution_array[$i]['doc_categories_id'] ==  zen_get_solution_article_id_of_category_id($s_id) && $s_id != '' ){?>
		                          

		                          
		                          <?php if($article['id'] == $s_id){ ?>
		                          <dd class="sidebar_products" style="display:block;"><a href="<?php echo $article_href;?>">
		                          <span><?php echo $article_title;?></span> </a></dd>
		                          <?php }else {?>
		                          <dd  style="display:block;"><a href="<?php echo $article_href;?>">
		                          <?php echo $article_title;?>
		                          
		                          </a></dd>
		                          
		                          <?php }}else{?>
		                          <dd ><a href="<?php echo $article_href;?>"><?php echo $article_title;?>
		                          
		                          </a></dd>
		                          <?php   }}}?>  
		                       </dl>        
                  <?php }?>
  </div>
  
</div>
<script type="text/javascript">
$(function(){
	$(".solution_nav_01 > dt >   a").click(function(){
		if('solution_nav_ForJS' == this.className) { 
			$(this).removeClass('solution_nav_ForJS').addClass('solution_nav_js');
			$(this).parents('dl').siblings('dl').each(function(){
				if($(this).children('dt').children('a').attr('class') == 'solution_nav_js' ){
					$(this).children('dt').children('a').removeClass('solution_nav_js').addClass('solution_nav_ForJS');
					$(this).children('dd').css('display','none');
				}
				});	
			$(this).parents('dt').siblings('dd').css('display','block');
		}else{
			$(this).removeClass('solution_nav_js').addClass('solution_nav_ForJS');
			$(this).parents('dt').siblings('dd').css('display','none');
			 }
	});
	});

function narrow_by_pop(url){
	open(url);
}
</script>
