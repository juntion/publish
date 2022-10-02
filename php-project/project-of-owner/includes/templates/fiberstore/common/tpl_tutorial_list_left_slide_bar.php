<div class="con_left">

<div class="title_zhenghe">
  <ul>   
     <p>Tutorial</p>  

     <?php for ($i=0, $n = sizeof($doc_array); $i < $n; $i++){
     
      $c_info  = zen_get_tutorial_detail_to_category($_GET['a_id']);           
    ?>

	 <li <?php echo($doc_array[$i]['doc_categories_id'] == $c_info['cId'])  ? 'class="mrxs"' : '' ; ?>  >
	  
	 <?php echo '<a href="'.zen_href_link('tutorial_list','&c='.$doc_array[$i]['doc_categories_id'],'NONSSL').'" target="_self"> '.$doc_array[$i]['doc_categories_name'].'</a>' ;?>
	
	 </li>
	 
      <?php }?>
            
  </ul>

</div></div>
  
  

  
  
  
