<link href="includes/templates/fiberstore/css/style_solution.css" rel="stylesheet" type="text/css" />
<div class="con_left">
  <div class="solution_nav"> <b>Product Solution</b>
  
  
<?php 

  
  	$tutorial_query = "select * from " . TABLE_SOLUTION_CATEGORIES ." as c left join " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION ." as cd
	using(doc_categories_id) where cd.language_id = '".$_SESSION['languages_id']."' and doc_parent_category = 1
	order by doc_sort_order";
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
                  
                  
                                   <?php  $cid=$solution_array[$i]['doc_categories_id'];   ?>
                 <?php 
                 
                 
               $articles_query = "select * from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id)
		left join " . TABLE_SOLUTION_ARTICLE_CATEGORY . " as ac  using(doc_article_id)
		where doc_categories_id = ".intval($cid);
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
                  
		                      <dl class="solution_nav_01">

		                      
		                      <dt><a href="javascript:void(0);"><?php echo $solution_array[$i]['doc_categories_name'];?></a></dt>
	
		                      
							  <?php 
					           
					            foreach ($article_two_array as $i => $article){
					            	
					            	$article_href = zen_href_link('solution_detail','&s_id='.$article['id']);
					            	$article_title = $article['title'];
					            	$article_image=  $article['image'];
					
					            ?>

		                          <dd><a href="<?php echo $article_href;?>"><?php echo $article_title;?></a></dd>
		                          
		                          <?php   }?>            
		                       </dl>        
		                      	
                <?php }?>
  

  
  

  <p style="border-top:1px solid #dedede; margin-top:5px;"><b style="border-radius:0;">Project Solution</b></p>
  
  
  <?php 

  
  	$solution_query = "select * from " . TABLE_SOLUTION_CATEGORIES ." as c left join " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION ." as cd
	using(doc_categories_id) where cd.language_id = '".$_SESSION['languages_id']."' and doc_parent_category = 2
	order by doc_sort_order";
	$get_category = $db->Execute($solution_query);
	//$c_id = $get_categories->fields['doc_categories_id'];
	$doc_array = array();

	while(!$get_category->EOF){


		$doc_array[] = array(
				'doc_categories_id' => $get_category->fields['doc_categories_id'],
				'doc_categories_name' => $get_category->fields['doc_categories_name'],

		);
		$get_category->MoveNext();
	}
  
    ?>
  
                  <?php for ($f=0, $m = sizeof($doc_array); $f < $m; $f++){?>
                  
                  
                                   <?php  $did=$doc_array[$f]['doc_categories_id'];   ?>
                 <?php 
                 
                 
               $doc_query = "select * from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
				left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id)
				left join " . TABLE_SOLUTION_ARTICLE_CATEGORY . " as ac  using(doc_article_id)
				where doc_categories_id = ".intval($did);
				$get_doc_articles = $db->Execute($doc_query);
		         $article_one_array  = array();
				if ($get_doc_articles->RecordCount()){
					while (!$get_doc_articles->EOF){
						$article_one_array[] = array(
								'id' => $get_doc_articles->fields['doc_article_id'],
						        'cid' => $get_doc_articles->fields['doc_categories_id'],
								'title' => $get_doc_articles->fields['doc_article_title'],
								'content' => stripslashes($get_doc_articles->fields['doc_article_content']),
						        'image' => stripslashes($get_doc_articles->fields['doc_article_image']),
								'add_time' => $get_doc_articles->fields['doc_article_date_added']
						);
						$get_doc_articles->MoveNext();
					}
				}
				
                 ?>
                  
		                      <dl class="solution_nav_01">

		                      
		                      <dt><a href="javascript:void(0);"><?php echo $doc_array[$f]['doc_categories_name'];?></a></dt>
	
		                      
							  <?php 
					           
					            foreach ($article_one_array as $i => $article){
					            	
					            	$article_href = zen_href_link('solution_detail','&s_id='.$article['id']);
					            	$article_title = $article['title'];
					            	$article_image=  $article['image'];
					
					            ?>

		                          <dd><a href="<?php echo $article_href;?>"><?php echo $article_title;?></a></dd>
		                          
		                          <?php   }?>            
		                       </dl>        
		                      	
                <?php }?>
  
  </div>
  
  
</div>
<script type="text/javascript">
$(function(){
$(".solution_nav_01 > dt > a").click(function(){
	
	if('solution_nav_js' == this.className) { 
	$(this).removeClass('solution_nav_js').addClass('solution_nav_ForJS');
	}
	else{
	 	$(this).removeClass('solution_nav_ForJS').addClass('solution_nav_js');
	 }
	$(this).parent().siblings().slideToggle('fast');
	
});
});

function narrow_by_pop(url){
	open(url);
}
</script>
