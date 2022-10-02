<?php
//获取西雅图的库存，fallwind	2017.4.25
function zen_get_sale_stock_num($products_id){
	$sale_stock_num = fs_get_data_from_db_fields('instock_qty','products_instock','products_id='.(int)$products_id.' and warehouse=3','');												
	if($sale_stock_num==''){
		$products_id = zen_get_products_related_model($products_id);
		$sale_stock_num = fs_get_data_from_db_fields('instock_qty','products_instock','products_id='.(int)$products_id.' and warehouse=3','');
	}

	$reduce_num = fs_get_data_from_db_fields('qty','products_instock_orders','products_id='.(int)$products_id,'');
	$sale_stock_num = $sale_stock_num-$reduce_num;
																				
	/* if($sale_stock_num<=0){
		$sale_stock_num='';
	} */
	return $sale_stock_num;
}

//西雅图库存页面的QF列表	fallwind	2017.4.25
function fs_products_list_quickfinder_table_new($current_category_id,$pid,$cPath0,$cPath1){

   $fiber_optic_list = fs_categories_fiber_cables_table($current_category_id) ? fs_categories_fiber_cables_table($current_category_id) : fs_categories_fiber_cables_table($pid) ;
 
  $quickfinder_html ='';
  $quickfinder_html .='<div class="product_table_responsive">';
  //$quickfinder_html .='<div class="product_table_filter"><b>'.FS_FILTER.':</b><label><input type="checkbox" onclick="view_all()" id="view_all" name="view_all" value="all" checked="checked">'.FS_VIEW_ALL.'</label>';	

  // foreach($fiber_optic_list as $keys=>$v){ 
	//if($v['filter']){
	 //$quickfinder_html .='<label><input type="checkbox" name="filter" value="'.$v['id'].'" id="'.$v['id'].'"  onclick="my_filter('.$v['id'].')">'.$v['filter'].'</label>';
	// }
  // } 
	
	//$quickfinder_html .='</div><br />';

	  $table ='';
	  
	  if($cPath0 == 9 || $cPath1 == 2997){
	  $quickfinderHide = true;
	  $quickfinderCSS ='style="display:none;"';
	  }else{
	  $quickfinderShow = false;
	  $quickfinderCSS ='';
	  }
	  
	  for($t=0;$t<sizeof($fiber_optic_list);$t++){ 
	  
       $quickfinder_html .='<div class="product_table_title categories_name_s" id="table_name_'.$fiber_optic_list[$t]['id'].'" style="display: block;">'.$fiber_optic_list[$t]['filter'].'</div>';
       $quickfinder_html .= '<div class="categories_name_list"><div class="categories_name_list_left"></div><div class="categories_name_list_right"></div><table width="100%" border="0" cellspacing="0" cellpadding="0" class="product_table_striped filter_connector" id="table_'.$fiber_optic_list[$t]['id'].'" style="display: table;"><tbody>';
       $table_brand = fs_quickfinder_table_brand($fiber_optic_list[$t]['id']);
        
       if(sizeof($table_brand)){
          //过滤了相同类型的产品
          $table_type = fs_quickfinder_table_type($fiber_optic_list[$t]['id']);
          $typeName = '';$Custom=false;
        
          $quickfinder_html .= '<tr>';
          $first_products=$image_src=$image='';
           for($tb=0;$tb<sizeof($table_brand);$tb++){             //展示品牌
             /* 第一个产品图片 */
             $quickfinder_html .= '<th>'.$table_brand[$tb]['brand_name'];
             if($tb >0){
             $first_products = fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$tb]['brand_id'],$table_type[0]['type_id']);
	           if(is_numeric($first_products)){
	             $image_src= file_exists(DIR_WS_IMAGES.zen_get_products_image_of_products_id($first_products)) ? DIR_WS_IMAGES.zen_get_products_image_of_products_id($first_products): DIR_WS_IMAGES.'no_picture.gif';
				 $image = zen_image($image_src,zen_get_products_name($first_products),40,40,'title="'.zen_get_products_name($first_products).'" ');
	             $quickfinder_html .= '<br/>'.$image;
	           }else{
				   //如果该品牌不存在第一个产品 调用下面的产品的图 
				   for($i=1;$i<sizeof($table_type);$i++){
					   $next_products =fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$tb]['brand_id'],$table_type[$i]['type_id']);
				      //直到有产品为止
					  if(is_numeric($next_products)){
					      $last_products =$next_products;
						  break;
				       }
				  }  
				  $image_src= file_exists(DIR_WS_IMAGES.zen_get_products_image_of_products_id($last_products)) ? DIR_WS_IMAGES.zen_get_products_image_of_products_id($last_products): DIR_WS_IMAGES.'no_picture.gif';
				  $image = zen_image($image_src,zen_get_products_name($last_products),40,40,'title="'.zen_get_products_name($last_products).'" ');
				  $quickfinder_html .= '<br/>'. $image;
			   }
             }
             $quickfinder_html .= '</th>';
           }
          $quickfinder_html .= '</tr>'; 

          for($num=0;$num<sizeof($table_type);$num++){
            $quickfinder_html .= '<tr>';
             $typeName = $table_type[$num]['type_name'];
             if($table_type[$num]['type_name'] == 'Custom'){
             $Custom = true;
             }else{
             $Custom = false;
             }
            //search到相同类型的产品
	        $sameType='';
	        $sameType = fs_quickfinder_table_type_same($fiber_optic_list[$t]['id'],$typeName);
	        $brand_products='';$PinstockID='';$PinstockQTY=0;$InstockPCS='';
	        
          	for($bs=0;$bs<sizeof($table_brand);$bs++){            //展示品牌下产品
	             if($bs ==0){
	              $quickfinder_html .= '<td>'.$typeName.'</td>';
	             }else{

	             //下面这个循环速度很慢  要找出对应产品以及产品的库存数量
	             $brand_products = fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$bs]['brand_id'],$table_type[$num]['type_id']);
	             
	             //有产品id的则显示
	             if(is_numeric($brand_products) && $brand_products > 0){
	               if($Custom){
	                $productsID = '<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=' . $brand_products).'" target="_blank">'.$brand_products.'</a>';
	               }else{
	               if($fiber_optic_list[$t]['table_info'] == 1){
		             $productsID = '<a onclick="LAddToCart('.(int)$brand_products.')">'.zen_get_products_model_PART((int)$brand_products).'</a>';  
		            }else{
		             $productsID = '<a onclick="LAddToCart('.(int)$brand_products.')">'.$brand_products.'</a>';
		            } 
	               }
		            //$PinstockQTY = fs_products_instock_total_qty_of_products_id($brand_products);
					
					$PinstockQTY = zen_get_sale_stock_num($brand_products);
		            $InstockPCS = $PinstockQTY > 0 ? '<span class="pro_green_stock "><i></i>'.$PinstockQTY.'pcs</span>' : '';
		             
	             }else{
	               if($brand_products ==0 && $cPath_array[0] == 9){
	               $productsID ='--';
	               }else{
	               $productsID = $brand_products;
	               }
		             
		            $InstockPCS =''; 
	             }
	             
	             //对应品牌,同类型下有多个产品,显示或隐藏
	             $brand_type_P = fs_quickfinder_table_brand_type_products($fiber_optic_list[$t]['id'],$table_brand[$bs]['brand_id'],$typeName);
	             
	             $moreProducts ='';
	             if(sizeof($brand_type_P) > 1 && $quickfinderHide){
	             $moreProducts =   '&nbsp;<a id="pulldownC_'.$table_type[$num]['type_id'].'_'.$bs.'"  class="sidebar_more" onclick="GetMoreType('.$table_type[$num]['type_id'].','.sizeof($sameType).','.$bs.')"><i></i></a>';
	             }
	             $quickfinder_html .= '<td>'.$productsID.$moreProducts.'&nbsp;'.$InstockPCS.'</td>';
	             }
	          }
	          
	        $quickfinder_html .= '</tr>'; 

             if(sizeof($sameType) > 1){
              $autoID=0;$sameCustom = false;
              for($st=1;$st<sizeof($sameType);$st++){          // 相同类型的第一个在前面已经显示
              $SPinstockID='';$SPinstockQTY=0;$SInstockPCS='';
                 $autoID++;
                 
            if($sameType[$st]['type_name'] == 'Custom'){
             $sameCustom = true;
             }else{
             $sameCustom = false;
             }
                          $quickfinder_html .= '<tr id="type_'.$table_type[$num]['type_id'].'_'.$autoID.'" '.$quickfinderCSS.'>';
				            $S_products='';
					          for($bbs=0;$bbs<sizeof($table_brand);$bbs++){            //展示品牌下产品
					             if($bbs ==0){
					              $quickfinder_html .= '<td>'.$sameType[$st]['type_name'].'</td>';
					             }else{
					             $S_products = fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$bbs]['brand_id'],$sameType[$st]['type_id']);
					             
					             if(is_numeric($S_products) && $S_products > 0){
					             if($sameCustom){
					                $SproductsID = '<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=' . $S_products).'" target="_blank">'.$S_products.'</a>';
					             }else{
					               if($fiber_optic_list[$t]['table_info'] == 1){
						             $SproductsID = '<a onclick="LAddToCart('.(int)$S_products.')">'.zen_get_products_model_PART((int)$S_products).'</a>';  
						            }else{
						             $SproductsID = '<a onclick="LAddToCart('.(int)$S_products.')">'.$S_products.'</a>';
						            } 
	                              }
						            //$SPinstockQTY = fs_products_instock_total_qty_of_products_id($S_products);
									$SPinstockQTY = zen_get_sale_stock_num($S_products);
						            $SInstockPCS = $SPinstockQTY > 0 ? '<span class="pro_green_stock "><i></i>'.$SPinstockQTY.'pcs</span>' : '';
						             
					             }else{
					              if(is_numeric($S_products) && $S_products ==0){
					               $SproductsID ='--';
					               }else{
					               $SproductsID = $S_products ;
					               }
						             
						            $SInstockPCS =''; 
					             }
					             
					             $quickfinder_html .= '<td>'.$SproductsID.'&nbsp;'.$SInstockPCS.'</td>';
					             }
					          }
					      $quickfinder_html .= '</tr>';
                }
             }
          }   
          
        }
       $quickfinder_html .= '</tbody></table></div>';
	 }
	 $quickfinder_html .= '</div>';
     return $quickfinder_html;
}


