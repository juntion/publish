
<div class="con_left">
<div class="title_zhenghe">
 <ul>
 <p>Product Information</p>
  
  
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
                  <?php for ($i=0, $n = sizeof($solution_array); $i < $n; $i++){
                  $href = zen_href_link(FILENAME_SOLUTION_LIST,'&s='.$solution_array[$i]['doc_categories_id']);     
                  ?>

		                      
		                      
		        <li <?php echo ($solution_array[$i]['doc_categories_id'] ==  $_GET['s']) ? 'class="mrxs"' : ''; ?>>
		        
		        <?php echo ($solution_array[$i]['doc_categories_id'] ==  $_GET['s']) ? $solution_array[$i]['doc_categories_name']: '<a href="'.$href.'">'.$solution_array[$i]['doc_categories_name'].'</a>' ;?>
          
		                      
		                      </li>         	
                <?php }?>
                
                <!-- 
<div class="title_zhenghe_bor">
  <p >Project Solution</p>
  </div>
  <?php  
  /*
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
    */
	?>
  
                  <?php
                   /*
                    for ($f=0, $m = sizeof($doc_array); $f < $m; $f++){
                    $did=$doc_array[$f]['doc_categories_id'];  
                    $href = zen_href_link(FILENAME_SOLUTION_LIST,'&s='.$doc_array[$f]['doc_categories_id']);
                */
                     ?>
		        <li <?php // echo ($doc_array[$f]['doc_categories_id'] ==  $_GET['s']) ? 'class="mrxs"' : ''; ?>>
		        
		        <?php // echo ($doc_array[$f]['doc_categories_id'] ==  $_GET['s']) ? $doc_array[$f]['doc_categories_name']: '<a href="'.$href.'">'.$doc_array[$f]['doc_categories_name'].'</a>' ;?>
          
		                      
		                      </li>           	
                <?php //}?>
                
                
                -->

  </ul>
</div>
</div>
<script type="text/javascript">


function narrow_by_pop(url){
	open(url);
}
</script>
