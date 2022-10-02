<?php
 function fs_products_list_quickfinder_table($current_category_id,$pid,$cPath0,$cPath1){

   $fiber_optic_list = fs_categories_fiber_cables_table($current_category_id) ? fs_categories_fiber_cables_table($current_category_id) : fs_categories_fiber_cables_table($pid) ;
 
  $quickfinder_html ='';
  $quickfinder_html .='<div class="product_table_responsive">';
  //$quickfinder_html .='<div class="product_table_filter"><b>'.FS_FILTER.':</b><label><input type="checkbox" onclick="view_all()" id="view_all" name="view_all" value="all" checked="checked">'.FS_VIEW_ALL.'</label>';	

   foreach($fiber_optic_list as $keys=>$v){ 
	if($v['filter']){
	 //$quickfinder_html .='<label><input type="checkbox" name="filter" value="'.$v['id'].'" id="'.$v['id'].'"  onclick="my_filter('.$v['id'].')">'.$v['filter'].'</label>';
	 }
   } 
	
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
		            $PinstockQTY = fs_products_instock_total_qty_of_products_id($brand_products);
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
						            $SPinstockQTY = fs_products_instock_total_qty_of_products_id($S_products);
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

function fs_related_id_products($rid){
  global $db;
  $products_array [] = array();
  $related = $db->Execute("select products_id from fiber_optic_length_related_products where related_id =".(int)$rid);
   while (!$related->EOF) {
		    $products_array [] = $related->fields['products_id'];
	  $related->MoveNext();
   }
   return $products_array;
}

function fs_related_brand_products($pid,$km){
 global $db;
 $related = $db->Execute("select related_id from fiber_optic_length_related_products where products_id in(".join(',',$pid).") order by sort desc limit 1");
 $related_array = array();$brand = array();$products = array();
 if($km){
 $and = "and name REGEXP '".$km."'";
 }else{
 $and ="";
 }
 //其他品牌
 if($related->fields['related_id']){
	 $relatedC = $db->Execute("select categories_id from fiber_optic_length_related where related_id =".(int)$related->fields['related_id']);
	 if($relatedC->fields['categories_id']){
	 $CTR = $db->Execute("select related_id from fiber_optic_length_related where categories_id =".(int)$relatedC->fields['categories_id']." $and ");
	 
	 if($CTR->RecordCount()){
	   while (!$CTR->EOF) {
			    $related_array [] = $CTR->fields['related_id'];
		  $CTR->MoveNext();
	   }
	 }
	 if(sizeof($related_array)){
	   $brand = array_unique($related_array);
	   if(sizeof($brand)){
	     for($r=0;$r<sizeof($brand);$r++){
	       $Rproducts = array();
	       $Rproducts = fs_related_id_products($brand[$r]);
	       $products = array_merge($products,$Rproducts);  
	     }
	    }
	  }
    } 
  }
 return $products;
}

//产品当前总关联
function zen_get_products_related_id($pid){
 global $db;
 $related = $db->Execute("select related_id from products_relate_all_products where products_id = '" . (int)$pid . "'");
 if ($related->RecordCount()) {
  $related_id = $related->fields['related_id'];
 }
 return $related_id;
}

// 产品关联的品牌
function zen_get_related_brand_of_products($pid){
   global  $db;
   $brand_array = array();
	$related_id = zen_get_products_related_id($pid);
	if ($related_id) {
	 $brand = $db->Execute("select brand_id,brand_name from products_relate_all_brand where related_id = ".(int)$related_id." order by sort");
	 if($brand->RecordCount()){
		 while (!$brand->EOF) {
		    $brand_array [] = array(
			    'brand_id' => $brand->fields['brand_id'],
			    'brand_name' => $brand->fields['brand_name']
			    );
		    $brand->MoveNext();
		 }
	   }
	}
	return $brand_array; 
}

//通道产品    不展示关联
function zen_get_products_is_Wavelength($pid,$oid){
  global $db;
  $products = $db->Execute("select products_attributes_id FROM products_attributes where products_id=".$pid." and options_id = ".$oid);
  $isWavelength = false;
  if($products->fields['products_attributes_id']){
   $isWavelength = true;
  }
  return $isWavelength;
}

  function zen_get_products_status($product_id) {
    global $db;
    $sql = "select products_status from " . TABLE_PRODUCTS . (zen_not_null($product_id) ? " where products_id=" . $product_id : "");
    $check_status = $db->Execute($sql);
    return $check_status->fields['products_status'];
  }

function zen_get_related_brand_products($rid,$bid){
 global $db;
 $products_array = array();
 $sql="select products_id,products_tag from products_relate_all_products where related_id =".(int)$rid." and brand_id=".(int)$bid." order by sort";
  $products = $db->Execute($sql);
  if($products->RecordCount()){
	 while (!$products->EOF) {
	    $products_array [] = array(
	    'id' => $products->fields['products_id'],
	    'tag' => $products->fields['products_tag']
	    );
	  $products->MoveNext();
	 }
  }
  return $products_array;
}

function zen_get_default_related_brand($pid){
global $db;
 $brand = $db->Execute("select brand_id from products_relate_all_products where products_id =".(int)$pid);
 if($brand->fields['brand_id']){
  $brand_info_id = $brand->fields['brand_id'];
 }
 return $brand_info_id;
}

function zen_get_brand_default_products($rid,$bid){
 global $db;
 $sql ="select products_id from products_relate_all_products where related_id =".(int)$rid." and brand_id=".(int)$bid." 
        order by sort,related_products_id limit 1";
 $products = $db->Execute($sql);
 if($products->fields['products_id']){
 $products_id = $products->fields['products_id'];
 }
 return $products_id;
}

function zen_get_brand_name($bid){
 global $db;
 $brand =$db->Execute("select brand_name from products_relate_all_brand where brand_id=".(int)$bid);
 if($brand->RecordCount()){
 $name = $brand->fields['brand_name'];
 }
 return $name;
}

function zen_get_products_model_PART($pid){
 global $db;
 $products = $db->Execute("select products_model,products_MFG_PART from products where products_id =".(int)$pid);
 if($products->fields['products_MFG_PART']){
  $model = $products->fields['products_MFG_PART'];
 }else{
  $model = $products->fields['products_model'];
 }
 return $model;
}

function zen_get_products_related_brand_info($id){
   global  $db;
   $brand_array = array();
	$brand = $db->Execute("select brand_id as id,brand_name
                                from products_relate_all_brand
                                where brand_id = ".(int)$id."
                                and language_id = '" . (int)$_SESSION['languages_id'] . "'
                                order by sort");
	if ($brand->RecordCount()) {
		while (!$brand->EOF) {
			$brand_array [] = array('id'=>$brand->fields['id'],'text'=>$brand->fields['brand_name']);
			$brand->MoveNext();
		}
	}
	return $brand_array; 
}

//获取分类quickfinder表中产品关联的颜色属性
function zen_get_products_related_color($products_id){
	global $db;
	$sql = 'select id,type from categories_fiber_quickfinder_products where products_id = "'.(int)$products_id.'" order by pid desc limit 1';
	$current_fiber = $db->getAll($sql);
	$id = $current_fiber[0]['id'];
	$type = $current_fiber[0]['type'];
	$all_products = array();
	if($id){
		$crorelated = fs_get_data_from_db_fields('crorelated','categories_fiber_cables_table','id='.$id,'limit 1');
		if($crorelated == 1){
			$sql = 'select Q.products_id,B.brand_name
			from categories_fiber_quickfinder_products Q
			left join categories_fiber_quickfinder_brand B on B.brand_id=Q.brand_id and B.id = Q.id
			where Q.id = "'.$id.'" and Q.type= "'.$type.'" and Q.crorelate = 1 ';
			$result = $db->Execute($sql);
			while(!$result->EOF){
				$products_status = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$result->fields['products_id'],'limit 1');
				if($products_status==1){
					$all_products[] = array(
						'products_id' => $result->fields['products_id'],
						'brand_name' => $result->fields['brand_name'],
					);
				}
				$result->MoveNext();
			}
			
		}
	}
	return $all_products;
}

//获取产品主图src
function zen_get_product_image_src($products_id){
	$image_src = '';
	$color_img = fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.$products_id,'limit 1');
	if($color_img){
		$color_img = 'images/'.$color_img;
		$path_info = pathinfo($color_img);
		$large_image =  $path_info['dirname'] . '/' . str_replace('.' . $path_info['extension'], '', $path_info['basename']) . '_LRG.' . $path_info['extension'];
		$ih_image = new ih_image($large_image, 600, 600);
		$image_src = HTTPS_IMAGE_SERVER.$ih_image->get_local();
	}
	return $image_src;
}

function zen_get_products_tip($product_id) {
 	$tip = '';
 	if($product_id){
		global $db;
		$sql = "select add_cart_tip from products_tips_info 
				where products_id = ".$product_id." and language_id = ".$_SESSION['languages_id']." and tip_is_show = 1 limit 1";
		$data = $db->Execute($sql);
		$tip = $data->fields['add_cart_tip'];
	}
	return $tip;
}
?>
