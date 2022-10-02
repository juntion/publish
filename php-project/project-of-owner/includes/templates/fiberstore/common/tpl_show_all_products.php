<?php
/**
 */
 //require DIR_WS_MODULES.zen_get_module_directory('get_categories_list');
$rewrite_type='category';
 ?>
<div class="sidebar" style="display: none;" id="all_categories">
            <div class="sidebar_menu">
                <div class="menu_02">
                	<ul>
                		<?php 
                		$query_category = "select categories_id, categories_name FROM " .TABLE_CATEGORIES . " AS c LEFT JOIN " .
                						  TABLE_CATEGORIES_DESCRIPTION ." AS cd 
                						  USING(categories_id) 
                						  WHERE parent_id = 0 
                						  AND categories_status = 1 
                						  ORDER BY sort_order ";
                		$get_category = $db->Execute($query_category);
                		//echo $query_category;
                		//echo 'aa' . $get_category->RecordCount();//var_dump($get_category->fields);
                		//exit;
                		while (!$get_category->EOF){
                			/*level 1*/
                		?>
                					<li class="wu"><?php echo $get_category->fields['categories_name'];?>
		                        	</li>
			                		
			                		<?php 
			                			$query_sub_category = "select categories_id, categories_name FROM " .TABLE_CATEGORIES . " AS c LEFT JOIN " .
			                						  TABLE_CATEGORIES_DESCRIPTION ." AS cd 
			                						  USING(categories_id)
			                						  WHERE parent_id = " . (int)$get_category->fields['categories_id'] ." 
			                						  AND categories_status = 1 ORDER BY c.sort_order";
			                						
			                			$get_sub_category  = $db->Execute($query_sub_category);
			                			
			                			
			                			//if (zen_category_has_sub_category($get_category->fields['categories_id'])){
			                			while (!$get_sub_category->EOF){
			                				$has_subs = zen_category_has_sub_category($get_sub_category->fields['categories_id']);
			                				/*level 2*/
			                				//$href = HTTP_SERVER.'/'.preg_replace('/(\/| )/i', '-', zen_get_categories_name($get_sub_category->fields['categories_id'])).fs_get_categories_path($get_sub_category->fields['categories_id']);
			                			?>
			                					<li><a <?php echo $has_subs ? '' : 'style="background-image:url();"';?> href="<?php echo fs_get_rewrite_url($rewrite_type, $get_sub_category->fields['categories_id']);//zen_href_link(FILENAME_DEFAULT,'&'.fs_get_categories_path($get_sub_category->fields['categories_id']));?>" class="hide"><?php echo $get_sub_category->fields['categories_name'];?></a>
								                	<?php 
								                		/*if this category has sub category*/
								                		if ($has_subs){
								                	?>
								                		<ul>	
								                			<?php 
								                			$query_sub2_category = "select categories_id, categories_name FROM " .TABLE_CATEGORIES . " AS c LEFT JOIN " .
					                						  TABLE_CATEGORIES_DESCRIPTION ." AS cd 
					                						  USING(categories_id)
					                						  WHERE parent_id = " . (int)$get_sub_category->fields['categories_id']." AND categories_status = 1 ORDER BY c.sort_order";
					                						
								                			$get_sub2_category  = $db->Execute($query_sub2_category);			

								                			while (!$get_sub2_category->EOF){
								                				/*level 3*/
								                				/*if this category has sub category*/
								                				if (zen_category_has_sub_category($get_sub2_category->fields['categories_id'])){
								                				?>
								                						<li class="first"><a title="<?php echo $get_sub2_category->fields['categories_name'];?>" href="<?php echo fs_get_rewrite_url($rewrite_type, $get_sub2_category->fields['categories_id']);?>" class="hide"><?php echo $get_sub2_category->fields['categories_name'];?></a>
								                						<ul>
								                							<?php 
												                				$query_sub3_category = "select categories_id, categories_name FROM " .TABLE_CATEGORIES . " AS c LEFT JOIN " .
										                						  TABLE_CATEGORIES_DESCRIPTION ." AS cd 
										                						  USING(categories_id)
										                						  WHERE parent_id = " . (int)$get_sub2_category->fields['categories_id']." AND categories_status = 1 ORDER BY c.sort_order";
										                						  $get_sub3_category  = $db->Execute($query_sub3_category);
												                				while (!$get_sub3_category->EOF){
												                					/*level 4*/
												                					
												                					if (zen_category_has_sub_category($get_sub3_category->fields['categories_id'])){
												                					?>
												                					
												                					<li class="first"><a  title="<?php echo $get_sub2_category->fields['categories_name'];?>" href="<?php echo fs_get_rewrite_url($rewrite_type, $get_sub3_category->fields['categories_id']);?>" class="hide"><?php echo $get_sub3_category->fields['categories_name'];?></a>
								                										<ul>
								                											<?php 
								                											$query_sub4_category = "select categories_id, categories_name FROM " .TABLE_CATEGORIES . " AS c LEFT JOIN " .
													                						  TABLE_CATEGORIES_DESCRIPTION ." AS cd 
													                						  USING(categories_id)
													                						  WHERE parent_id = " . (int)$get_sub3_category->fields['categories_id']." AND categories_status = 1 ORDER BY c.sort_order";
													                						  $get_sub4_category  = $db->Execute($query_sub4_category);
															                				while (!$get_sub4_category->EOF){
															                					/*level 5*/
															                					
															                					/*$class = '';
															                					if (in_array((int)$get_sub3_category->fields['categories_id'], array(220,221))){

															                						$class = ' ';
															                					}*/

															                					?>
															                					
															                					<li><a style="width: 230px;" title="<?php echo $get_sub4_category->fields['categories_name'];?>" href="<?php echo fs_get_rewrite_url($rewrite_type, $get_sub4_category->fields['categories_id']);?>"><?php echo $get_sub4_category->fields['categories_name'];?></a></li>
															                					
															                			<?php $get_sub4_category->MoveNext();
															                				}
												                					/*level 4*/
								                											?>
								                										</ul>	
												                					<?php 
												                					}else{
												                				?>	
												                					<li><a title="<?php echo $get_sub3_category->fields['categories_name'];?>" href="<?php echo fs_get_rewrite_url($rewrite_type, $get_sub3_category->fields['categories_id']);?>"><?php echo $get_sub3_category->fields['categories_name'];?></a></li>
												                				<?php 	
												                					}
												                					$get_sub3_category->MoveNext();
												                				}
								                							?>
								                						</ul>
								                				<?php }else {
								                				?>
								                						<li><a title="<?php echo $get_sub2_category->fields['categories_name'];?>" href="<?php echo fs_get_rewrite_url($rewrite_type, $get_sub2_category->fields['categories_id']);?>" class="hide"><?php echo $get_sub2_category->fields['categories_name'];?></a>
								                				<?php 
								                				}
								                				$get_sub2_category->MoveNext();
								                			}
								                			?>
								                		</ul>	
								                	<?php 	}
								                	?>
								                </li>     
			                			<?php 	
			                				$get_sub_category->MoveNext();
			                			}
			                			?>
			                			
                			<?php 
                			$get_category->MoveNext();
                		}
                		?>
                	</ul>
                
                
                </div>
            </div>
</div>