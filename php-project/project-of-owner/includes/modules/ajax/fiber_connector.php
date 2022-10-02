<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':
			   
			   $where = " where 1=1";
			   $page = $_POST['page'];
			   $connector_ends_a = trim($_POST['connector_ends_a']);
			   $connector_ends_b = trim($_POST['connector_ends_b']);
			   $connector_fiber_mode = trim($_POST['connector_fiber_mode']);
			   $connector_length_meter = trim($_POST['connector_length_meter']);
			   $polish_type = trim($_POST['polish_type']);
			   $cable_jack = trim($_POST['cable_jack']);
			   $fiber_count = trim($_POST['fiber_count']);
			   $cable_diameter = trim($_POST['cable_diameter']);
			   $application = trim($_POST['application']);

			   if($connector_ends_a){
				   $a = " and connector_end_a = '".$connector_ends_a."'";
				   $where .=  $a;
			   }
			   if($connector_ends_b){
				   $b = " and connector_end_b = '".$connector_ends_b."'";
				   $where .=  $b;
			   }
			   if($connector_fiber_mode){
				   $c = " and fiber_mode = '".$connector_fiber_mode."'";
				   $where .=  $c;
			   }
			   if($connector_length_meter){
				   $d = " and length_meter = '".$connector_length_meter."'";
				   $where .=  $d;
			   }
			   if($polish_type){
				   $e = " and polish_type = '".$polish_type."'";
				   $where .=  $e;
			   }
			   if($cable_jack){
				   $f = " and cable_jack = '".$cable_jack."'";
				   $where .=  $f;
			   }
			   if($fiber_count){
				   $g = " and pf.fiber_count = '".$fiber_count."'";
				   $where .=  $g;
			   }
			   if($cable_diameter){
				   $h = " and cable_diameter = '".$cable_diameter."'";
				   $where .=  $h;
			   }
			   if($application){
					$q = " and pf.application = '".$application."'";
				   $where .=  $q;
			   }
			   $Rpage = $page ? $page : 1;  
			   $start = ($Rpage-1)*AJAX_NUM; 
			   $sql = "select pf.products_id from products_fiber as pf,products as p  $where and pf.products_id = p.products_id and p.products_status = 1 limit $start,".AJAX_NUM."";
			  
			   $list = $db->getAll($sql);
			   $wholesale_products = fs_get_wholesale_products_array();
               foreach($list as $key=>$v){
				   $id = $v['products_id'];
				  
				   $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$id);
				   $name = zen_get_products_name($id);
				   if(!in_array($id,$wholesale_products)){
				   $price = $currencies->new_display_price(zen_get_products_price($id),0);
				   }else{
				   $price = $currencies->display_price(zen_get_products_price($id),0);
				   }
				   $img_src = file_exists(DIR_WS_IMAGES. zen_get_products_image_of_products_id($id)) ? DIR_WS_IMAGES. zen_get_products_image_of_products_id($id) : DIR_WS_IMAGES.'no_picture.gif';
				   $image = zen_image($img_src,$name,200,200,' border="0"');
				   $list[$key]['href'] = $href;
				   $list[$key]['name'] = $name;
				   $list[$key]['price'] = $price;
				   $list[$key]['image'] = $image;
				   $list[$key]['instock'] = __zen_get_products_instock($id);
				  
			   }
			   $sql = "select count(pf.products_id) as count from products_fiber as pf,products as p  $where and pf.products_id = p.products_id and p.products_status = 1";
			   $re = $db->Execute($sql);
			   $count = $re->fields['count'];
			   $page_num = ceil($count/AJAX_NUM);//评论页数
			   $page_html="";
				 if($page_num > 1){
					$next_num = 2;
					$next_href ='<a onclick="ajax_page_of_reviews('.$next_num.',2,'.$page_num.')" class="splitPageLink">'.FS_COMMON_NEXT.'<i></i></a>';
					$page_total ='<div class="new_page_center" id="new_page_center">'.FIBERSTORE_ORDER_PAGE. ' 1 / '.FIBERSTORE_ORDER_OF.' '.$page_num.'</div>';	
				
				  $page_html .='<div class="new_page_prev" id="new_page_prev"><span><i></i>'.FS_COMMON_PREVIOUS.'</span></div>';
				  $page_html .='<div class="new_page_next" id="new_page_next">'.$next_href.'</div>';
				  $page_html .= $page_total;
				 }
			   $connector_ends_a_sql = "select connector_end_a from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$b.$c.$d.$e.$f.$g.$h.$q." GROUP BY connector_end_a";

			   $connector_ends_ar = $db->getAll($connector_ends_a_sql);
			   $connector_ends_ar_array = array();
			   foreach($connector_ends_ar as $k=>$l){
					$connector_ends_ar_array[] = trim($l['connector_end_a']);
			   }
			   $connector_ends_b_sql = "select connector_end_b from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$c.$d.$e.$f.$g.$h.$q." GROUP BY connector_end_b";
			   $connector_ends_br = $db->getAll($connector_ends_b_sql);
			   $connector_ends_br_array = array();
			   foreach($connector_ends_br as $k=>$l){
					$connector_ends_br_array[] = trim($l['connector_end_b']);
			   }
			   $fiber_mode_sql = "select fiber_mode from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$d.$e.$f.$g.$h.$q." GROUP BY fiber_mode";
			   $fiber_moder = $db->getAll($fiber_mode_sql);
			   $fiber_moder_arr = array();
			   foreach($fiber_moder as $k=>$l){
					$fiber_moder_arr[] = trim($l['fiber_mode']);
			   }

			    $length_meter_sql = "select length_meter from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$c.$e.$f.$g.$h.$q." GROUP BY length_meter";
			   $length_meter = $db->getAll($length_meter_sql);
			   $length_meter_arr = array();
			   foreach($length_meter as $k=>$l){
					$length_meter_arr[] = trim($l['length_meter']);
			   }

			   $polish_type_sql = "select polish_type from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$c.$d.$f.$g.$h.$q." GROUP BY polish_type";
			   $polish_type = $db->getAll($polish_type_sql);
			   $polish_type_arr = array();
			   foreach($polish_type as $k=>$l){
					$polish_type_arr[] = trim($l['polish_type']);
			   }

			   $cable_jack_sql = "select cable_jack from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$c.$d.$e.$g.$h.$q." GROUP BY cable_jack";
	
			   $cable_jack = $db->getAll($cable_jack_sql);
			   $cable_jack_arr = array();
			   foreach($cable_jack as $k=>$l){
					$cable_jack_arr[] = trim($l['cable_jack']);
			   }

			   $fiber_count_sql = "select pf.fiber_count from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$c.$e.$f.$d.$h.$q." GROUP BY fiber_count";
			   $fiber_count = $db->getAll($fiber_count_sql);
			   $fiber_count_arr = array();
			   foreach($fiber_count as $k=>$l){
					$fiber_count_arr[] = trim($l['fiber_count']);
			   }

			   $cable_diameter_sql = "select cable_diameter from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$c.$e.$f.$g.$d.$q." GROUP BY cable_diameter";
			   $cable_diameter = $db->getAll($cable_diameter_sql);
			   $cable_diameter_arr = array();
			   foreach($cable_diameter as $k=>$l){
					$cable_diameter_arr[] = trim($l['cable_diameter']);
			   }

			   $cable_diameter_sql = "select pf.application from products_fiber as pf,products as p where pf.products_id = p.products_id and p.products_status = 1 ".$a.$b.$c.$e.$f.$g.$d.$h." GROUP BY application";
			   $application = $db->getAll($cable_diameter_sql);
			   $application_arr = array();
			   foreach($application as $k=>$l){
					$application_arr[] = trim($l['application']);
			   }
               

				
				//$connector_end_a = zen_get_connector_end_a();
				$connector_end_a = zen_get_products_fiber(1);
				//$connector_end_b = zen_get_connector_end_b();
				$connector_end_b = zen_get_products_fiber(2);
				//$connector_fiber_mode = zen_get_fiber_mode();
				$connector_fiber_mode = zen_get_products_fiber(3);
				//$connector_length_meter = zen_get_length_meter();
				$connector_length_meter = zen_get_products_fiber(4);

				//$polish_type = zen_get_polish_type();
				$polish_type = zen_get_products_fiber(6);
				//$cable_jack = zen_get_cable_jack();
				$cable_jack = zen_get_products_fiber(7);
				//$fiber_count = zen_get_fiber_count();
				$fiber_count = zen_get_products_fiber(5);
				//$cable_diameter = zen_get_cable_diameter();
				$cable_diameter = zen_get_products_fiber(8);

				
				//$application = array('Bend Insensitive','HD TAB','Common','HD Uniboot','Secure Keyed');
				$application = zen_get_products_fiber(9);

				$ends_a_array = array();
				foreach($connector_end_a as $v){
					$ends_a_array[] = trim($v['options_value_name']);
				}
				$ends_b_array = array();
				foreach($connector_end_b as $v){
					$ends_b_array[] = trim($v['options_value_name']);
				}
                $fiber_moder_array = array();
				foreach($connector_fiber_mode as $v){
					$fiber_moder_array[] = trim($v['options_value_name']);
				}
				$length_meter_array = array();
				foreach($connector_length_meter as $v){
					$length_meter_array[] = trim($v['options_value_name']);
				}
				$polish_type_array = array();
				foreach($polish_type as $v){
					$polish_type_array[] = trim($v['options_value_name']);
				}
				$cable_jack_array = array();
				foreach($cable_jack as $v){
					$cable_jack_array[] = trim($v['options_value_name']);
				}
				$fiber_count_array = array();
				foreach($fiber_count as $v){
					$fiber_count_array[] = trim($v['options_value_name']);
				}
				$cable_diameter_array = array();
				foreach($cable_diameter as $v){
					$cable_diameter_array[] = trim($v['options_value_name']);
				}

				$application_array = array();
				foreach($application as $v){
					$application_array[] = trim($v['options_value_name']);
				}
			  

			 //  $html = '<li class=" text_center">(B)</li>';
      
         
		       $ends_b = array();
			   foreach($ends_b_array as $key=>$v){
				  
						   if(!in_array($v,$connector_ends_br_array)){
							   $ends_b[] = $key+1;
								//$html .= '<li><a href="javascript:void(0)">'.$v.'</a></li>';
						   }
			   }
			   $ends_a = array();
			   foreach($ends_a_array as $key=>$v){
				    if(!in_array($v,$connector_ends_ar_array)){
						$ends_a[] = $key+1;
					}
			   }
			   $fiber_mode_a = array();
			   foreach($fiber_moder_array as $key=>$v){
				    if(!in_array($v,$fiber_moder_arr)){
						$fiber_mode_a[] = $key;
					}
			   }
			   $length_meter_a = array();
			   foreach($length_meter_array as $key=>$v){
				    if(!in_array($v,$length_meter_arr)){
						$length_meter_a[] = $key;
					}
			   }



			    $polish_type_a = array();
			   foreach($polish_type_array as $key=>$v){
				    if(!in_array($v,$polish_type_arr)){
						$polish_type_a[] = $key;
					}
			   }
			    $cable_jack_a = array();
			   foreach($cable_jack_array as $key=>$v){
				    if(!in_array($v,$cable_jack_arr)){
						$cable_jack_a[] = $key;
					}
			   }
			    $fiber_count_a = array();
			   foreach($fiber_count_array as $key=>$v){
				    if(!in_array($v,$fiber_count_arr)){
						$fiber_count_a[] = $key;
					}
			   }
			    $cable_diameter_a = array();
			   foreach($cable_diameter_array as $key=>$v){
				    if(!in_array($v,$cable_diameter_arr)){
						$cable_diameter_a[] = $key;
					}
			   }

			   $application_a = array();
			   foreach($application_array as $key=>$v){
				    if(!in_array($v,$application_arr)){
						$application_a[] = $key;
					}
			   }
			   $list_array = array('list'=>$list,'page_html'=>$page_html,'connector_ends_b'=>$ends_b,'connector_ends_a'=>$ends_a,'fiber_mode_a'=>$fiber_mode_a,'length_meter_a'=>$length_meter_a,'polish_type_a'=>$polish_type_a,'cable_jack_a'=>$cable_jack_a,'fiber_count_a'=>$fiber_count_a,'cable_diameter_a'=>$cable_diameter_a,'application_a'=>$application_a);
			   echo json_encode($list_array);exit;
			break;

			case 'fiber_bulk':
			   

			   $where = " where 1=1";
			   $page = $_POST['page'];
			   $category = trim($_POST['category']);			  
			   $color = trim($_POST['color']);
			   $connector_length_meter = trim($_POST['connector_length_meter']);
			   $advanced1 = trim($_POST['advanced1']);
			   $advanced2 = trim($_POST['advanced2']);
			   $advanced3 = trim($_POST['advanced3']);
			   $advanced4 = trim($_POST['advanced4']);

			   if($category){
				   $a = " and category = '".$category."'";
				   $where .=  $a;
			   }
			   
			   if($color){
				   $c = " and color = '".$color."'";
				   $where .=  $c;
			   }
			   if($connector_length_meter){
				   $d = " and length = '".$connector_length_meter."'";
				   $where .=  $d;
			   }
			   if($advanced1){
				   $e = " and advanced1 = '".$advanced1."'";
				   $where .=  $e;
			   }
			   if($advanced2){
				   $f = " and advanced2 = '".$advanced2."'";
				   $where .=  $f;
			   }
			   if($advanced3){
				   $g = " and advanced3 = '".$advanced3."'";
				   $where .=  $g;
			   }
			   if($advanced4){
				   $h = " and advanced4 = '".$advanced4."'";
				   $where .=  $h;
			   }
			   $Rpage = $page ? $page : 1;  
			   $start = ($Rpage-1)*AJAX_NUM; 
			   $sql = "select products_id from products_bulk_fiber_cables $where limit $start,".AJAX_NUM."";
			   $list = $db->getAll($sql);
               foreach($list as $key=>$v){
				   $id = $v['products_id'];
				   $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$id);
				   $name = zen_get_products_name($id);
				   $price = $currencies->new_display_price(zen_get_products_price($id),0);
				   $image = get_resources_img($id, 180, 180, '', '', '', ' border="0"');
				   $list[$key]['href'] = $href;
				   $list[$key]['name'] = $name;
				   $list[$key]['price'] = $price;
				   $list[$key]['image'] = $image;
				   $list[$key]['instock'] = __zen_get_products_instock($id);
			   }
			   $sql = "select count(products_id) as count from products_bulk_fiber_cables $where";
			   $re = $db->Execute($sql);
			   $count = $re->fields['count'];
			   $page_num = ceil($count/AJAX_NUM);//评论页数
			   $page_html="";
				  if($page_num > 1){
					$next_num = 2;
					$next_href ='<a onclick="ajax_page_of_reviews('.$next_num.',2,'.$page_num.')" class="splitPageLink">'.FS_COMMON_NEXT.'<i></i></a>';
					$page_total ='<div class="new_page_center" id="new_page_center">'.FIBERSTORE_ORDER_PAGE. ' 1 / '.FIBERSTORE_ORDER_OF.' '.$page_num.'</div>';	
				
				  $page_html .='<div class="new_page_prev" id="new_page_prev"><span><i></i>'.FS_COMMON_PREVIOUS.'</span></div>';
				  $page_html .='<div class="new_page_next" id="new_page_next">'.$next_href.'</div>';
				  $page_html .= $page_total;
				 }
			   $category_sql = "select category from products_bulk_fiber_cables where 1=1 ".$c.$d.$e.$f.$g.$h." GROUP BY category";
			   $categoryr = $db->getAll($category_sql);
			   $categoryr_array = array();
			   foreach($categoryr as $k=>$l){
					$categoryr_array[] = trim($l['category']);
			   }
			   $fiber_mode_sql = "select color from products_bulk_fiber_cables where 1=1 ".$a.$d.$e.$f.$g.$h." GROUP BY color";
			   $fiber_moder = $db->getAll($fiber_mode_sql);
			   $fiber_moder_arr = array();
			   foreach($fiber_moder as $k=>$l){
					$fiber_moder_arr[] = trim($l['color']);
			   }

			    $length_meter_sql = "select length from products_bulk_fiber_cables where 1=1 ".$a.$c.$e.$f.$g.$h." GROUP BY length";
			   $length_meter = $db->getAll($length_meter_sql);
			   $length_meter_arr = array();
			   foreach($length_meter as $k=>$l){
					$length_meter_arr[] = trim($l['length']);
			   }
			   $advanced1_sql = "select advanced1 from products_bulk_fiber_cables where 1=1 ".$a.$c.$d.$f.$g.$h." GROUP BY advanced1";
			   $advanced1 = $db->getAll($advanced1_sql);
			   $advanced1_arr = array();
			   foreach($advanced1 as $k=>$l){
					$advanced1_arr[] = trim($l['advanced1']);
			   }
			   $advanced2_sql = "select advanced2 from products_bulk_fiber_cables where 1=1 ".$a.$c.$d.$e.$g.$h." GROUP BY advanced2";
			   $advanced2 = $db->getAll($advanced2_sql);
			   $advanced2_arr = array();
			   foreach($advanced2 as $k=>$l){
					$advanced2_arr[] = trim($l['advanced2']);
			   }

			   $advanced3_sql = "select advanced3 from products_bulk_fiber_cables where 1=1 ".$a.$c.$e.$f.$d.$h." GROUP BY advanced3";
			   $advanced3 = $db->getAll($advanced3_sql);
			   $advanced3_arr = array();
			   foreach($advanced3 as $k=>$l){
					$advanced3_arr[] = trim($l['advanced3']);
			   }

			   $advanced4_sql = "select advanced4 from products_bulk_fiber_cables where 1=1 ".$a.$c.$e.$f.$g.$d." GROUP BY advanced4";
			   $advanced4 = $db->getAll($advanced4_sql);
			   $advanced4_arr = array();
			   foreach($advanced4 as $k=>$l){
					$advanced4_arr[] = trim($l['advanced4']);
			   }
               

				
				//$connector_end_a = zen_get_connector_end_a();
				$connector_end_a = array('Cat5E','Cat6','Cat6A','Cat7');;
				
				$color = array('Aqua','Blue','Black','Gray','Green','Orange','Pink','Purple','Red','White','Yellow');
				//$connector_length_meter = zen_get_length_meter();
				$connector_fiber_mode = array('Aqua','Blue','Black','Gray','Green','Orange','Pink','Purple','Red','White','Yellow','Off White');
				$connector_length_meter = array('0.3m',
'0.5m',
'1.5m',
'1m',
'2m',
'2.5m',
'3m',
'4m',
'5m',
'7m',
'10m',
'15m',
'20m',
'25m',
'30m',
'40m',
'50m',
'60m'
);

				//$advanced1 = zen_get_advanced1();
				$advanced1 = array('Unshielded(UTP)','Shielded');
				//$advanced2 = zen_get_advanced2();
				$advanced2 =  array('Booted','Non-booted');
				//$advanced3 = zen_get_advanced3();
				$advanced3 =  array('PVC/OFNR(CM)','LSZH(CM)');
				//$advanced4 = zen_get_advanced4();'Snagless Cable'
				$advanced4 =  array('Round Cable','Slim Cable','Retractable Cable','Angled Cable');


 
				$ends_a_array = array();
				foreach($connector_end_a as $v){
					$ends_a_array[] = trim($v);
				}
				
                $fiber_moder_array = array();
				foreach($connector_fiber_mode as $v){
					$fiber_moder_array[] = trim($v);
				}
				$length_meter_array = array();
				foreach($connector_length_meter as $v){
					$length_meter_array[] = trim($v);
				}
				$advanced1_array = array();
				foreach($advanced1 as $v){
					$advanced1_array[] = trim($v);
				}
				$advanced2_array = array();
				foreach($advanced2 as $v){
					$advanced2_array[] = trim($v);
				}
				$advanced3_array = array();
				foreach($advanced3 as $v){
					$advanced3_array[] = trim($v);
				}
				$advanced4_array = array();
				foreach($advanced4 as $v){
					$advanced4_array[] = trim($v);
				}
			  

			   $ends_a = array();
			   foreach($ends_a_array as $key=>$v){
				    if(!in_array($v,$categoryr_array)){
						$ends_a[] = $key;
					}
			   }
			   $fiber_mode_a = array();
			   foreach($fiber_moder_array as $key=>$v){
				    if(!in_array($v,$fiber_moder_arr)){
						$fiber_mode_a[] = $key;
					}
			   }
			   $length_meter_a = array();
			   foreach($length_meter_array as $key=>$v){
				    if(!in_array($v,$length_meter_arr)){
						$length_meter_a[] = $key;
					}
			   }


			    $advanced1_a = array();
			   foreach($advanced1_array as $key=>$v){
				    if(!in_array($v,$advanced1_arr)){
						$advanced1_a[] = $key;
					}
			   }
			    $advanced2_a = array();
			   foreach($advanced2_array as $key=>$v){
				    if(!in_array($v,$advanced2_arr)){
						$advanced2_a[] = $key;
					}
			   }
			    $advanced3_a = array();
			   foreach($advanced3_array as $key=>$v){
				    if(!in_array($v,$advanced3_arr)){
						$advanced3_a[] = $key;
					}
			   }
			    $advanced4_a = array();
			   foreach($advanced4_array as $key=>$v){
				    if(!in_array($v,$advanced4_arr)){
						$advanced4_a[] = $key;
					}
			   }
			   $list_array = array('list'=>$list,'page_html'=>$page_html,'category'=>$ends_a,'color'=>$fiber_mode_a,'length_meter_a'=>$length_meter_a,'advanced1'=>$advanced1_a,'advanced2'=>$advanced2_a,'advanced3'=>$advanced3_a,'advanced4'=>$advanced4_a);
			   echo json_encode($list_array);exit;
			break;
		
		}
	}
}
