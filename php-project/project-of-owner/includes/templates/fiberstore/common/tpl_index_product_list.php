<?php
//echo '&cPath='.$current_category_id.'&'.zen_get_all_get_params(array('cPath','type')).'&type=g';exit;

//FOR narrow
if (!isset($page_handler)) {
	$page_handler = FILENAME_DEFAULT;
}
 ?>
            <div class="p_content_02">
                <h1><?php echo zen_get_categories_name($current_category_id) . zen_get_products_count_of_category($current_category_id);?></h1>
            </div>
            <p><?php echo zen_get_categories_description($current_category_id, $_SESSION['languages_id']);?></p>
<?php if (isset($current_catgegory_no_products) && $current_catgegory_no_products){
				//no products
			?>
				no product in current category. We'll get more in stock as soon as possible !
			<?php 
	}else{
			$i=0;
?>			
            
			<div class="filter_tools">
				<ul>
				<li>View:</li>
				<?php if(isset($_GET['type']) && 'l' == $_GET['type']){?>
						<li class="list red_02">List</li>
						<li class="grid"><a <?php echo 'href="'.zen_href_link($page_handler, '&cPath='.$current_category_id.'&'.zen_get_all_get_params(array('cPath','type')).'&type=g').'" ';?>>Grid</a></li>
				<?php }else{?>
						<li class="list"><a <?php echo ' href="'.zen_href_link($page_handler, '&cPath='.$current_category_id.'&'.zen_get_all_get_params(array('cPath','type')).'&type=l').'" ';?>>List</a></li>
						<li class="grid red_02">Grid</li>
				<?php }?>
				<li class="sort"><em>Sort By:</em>
				<select name="sort_order" class="sort_01" onchange="javascript: if(this.value) location=$('#'+this.value).attr('tag');">
					<option value=""> Please select ... </option>
					<?php 
					$option_array = array(
						'priced' => 'Price High to Low',
						'price' => 'Price Low to High',
						'sellers' => 'Top Sellers ',
						'rate' => 'Top Rated Products ',
						'new' => 'New Items',
					
					);
					
					 foreach ($option_array as $key => $value){
					 	echo '<option id="'.$key.'" tag="'.zen_href_link($page_handler,'&cPath='.$current_category_id.'&sort_order='.$key.'&'.zen_get_all_get_params(array('cPath','sort_order'))).'"  
					 	value="'.$key.'" '.((isset($_GET['sort_order']) && $_GET['sort_order'] == $key) ? ' selected="selected" ' : '').'> '.$value.' </option>';
					 }
					?>
					</select>
					</li>
				
				<?php 
				if (1 < $listing_split->number_of_pages){
					?>	
				<li class="page"><b>Page:</b> 
				<?php echo $page_links;?>
				</li>
				<?php }?>
				<br class="ccc" />
				</ul>
			</div>

<?php
                $count_products = sizeof($products);
            	foreach ($products as $product){ 
					$href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$product['id']);
					$name = $product['name'];
					$sku = $product['sku'];
					$image_src= file_exists(DIR_WS_IMAGES.$product['image']) ? DIR_WS_IMAGES.$product['image']: DIR_WS_IMAGES.'no_picture.gif';
					$image = zen_image($image_src,$product['name'],120,120,'title="'.$product['name'].'"');
// 					$image = '<img width="120" height="120" src="'.$image_src.'" title="'.$product['name'].'" alt="'.$product['name'].'"/>';
					$product_price = $currencies->display_price($product['price'], 0);
					$description = strip_tags(zen_get_products_description($product['id']));
					$description = (220 < strlen($description)) ? substr($description,0,220).'...' : $description;
            	
            if (!isset($_GET['type']) || 'g' == $_GET['type']){?> 	
            	
            <div class="list_08">
                <div class="list_10"><a href="<?php echo $href_link;?>"><?php echo $image;?></a></div>
                <a href="<?php echo $href_link;?>"><?php echo $name;?></a>
                <div class="list_09"><?php echo $product_price;?></div>
                <span>(<a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO,'&products_id='.$product['id']);?>#reviews"><?php echo zen_products_reviews_count($product['id']).' reviews';?></a>)</span>
            </div>
            
            
            <?php
            if (0==($i++ +1)%4) {
            	
            ?>
            <div class="ccc list_line"></div>
           <?php  }
              }else{?>
			
			<div class="page_list_01"><a href="<?php echo $href_link;?>"><?php echo $image;?></a>
				<div class="page_list_01_01"><span><a href="<?php echo $href_link;?>"><?php echo $name;?></a></span>
					<div class="page_list_01_02">Description: <?php echo $description ;?><a href="<?php echo $href_link;?>">Product Detail»</a></div>
				    <div>FiberStore SKU#: 	<?php echo $sku;?></div>
					<div class="index_label_02 index_label_03">(<a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO,'&products_id='.$product['id']);?>#reviews"><?php echo zen_products_reviews_count($product['id']);?> reviews</a>)</div>
				</div>
				<div class="page_list_02"><a href="javascript:void(0);"><?php echo $product_price;?></a> 
					<div class="page_list_02_button"><a href="<?php echo $href_link;?>"></a></div>
				</div>
				<div class="ccc"></div>
			</div>
			<?php 
            }
           
            }
           ?>
			
            <div class="ccc"></div>

		<?php 
		if (1 < $listing_split->number_of_pages){
			?>	
            <div class="filter_tools filter_tools_no">
				<ul>
				<li class="page page_01"><b>Page:</b> <?php echo $page_links;?></li>
				<br class="ccc" />
				</ul>
			</div>
        <?php }
	}?>