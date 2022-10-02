<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers'://注意加号
			   
			   $where = " where 1=1";
			   $page = $_POST['page'];
	
			   $network_platform = trim($_POST['network_platform']);
			   $form_factor = trim($_POST['form_factor']);
			   $form_factor = str_replace('888','+',$form_factor);
			   $type = trim($_POST['type']);
			   $speed = trim($_POST['speed']);
			   $distance = trim($_POST['distance']);
			   $wavelength_filter = trim($_POST['wavelength_filter']);

			   if($network_platform){
				   $a = " and network_platform = '".$network_platform."'";
				   $where .=  $a;
			   }
			   if($form_factor){
				   $b = " and form_factor = '".$form_factor."'";
				   $where .=  $b;
			   }
			   if($type){
				   $c = " and type = '".$type."'";
				   $where .=  $c;
			   }
			   if($speed){
				   $d = " and speed = '".$speed."'";
				   $where .=  $d;
			   }
			   if($distance){
				   $e = " and distance = '".$distance."'";
				   $where .=  $e;
			   }
			   if($wavelength_filter){
				   $f = " and wavelength_filter = '".$wavelength_filter."'";
				   $where .=  $f;
			   }
			  
			   $Rpage = $page ? $page : 1;  
			   $start = ($Rpage-1)*AJAX_NUM; 
			   $sql = "select products_id from products_transceivers $where limit $start,".AJAX_NUM."";
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
				   $image = get_resources_img($id, 180, 180, '', '', '', ' border="0"');
				   $list[$key]['href'] = $href;
				   $list[$key]['name'] = $name;
				   $list[$key]['price'] = $price;
				   $list[$key]['image'] = $image;
				   $list[$key]['instock'] = __zen_get_products_instock($id);
			   }
			   $sql1 = "select count(products_id) as count from products_transceivers $where and wavelength_filter like '%nm%'";
			   $result = $db->Execute($sql1);
			   $nm = $result->fields['count'];
			   $sql2 = "select count(products_id) as count from products_transceivers $where and wavelength_filter like '%C%'";
			   $result = $db->Execute($sql2);
			   $nm1 = $result->fields['count'];
			   $sql3 = "select count(products_id) as count from products_transceivers $where and wavelength_filter like '%H%'";
			   $result = $db->Execute($sql3);
			   $nm2 = $result->fields['count'];


			   $sql = "select count(products_id) as count from products_transceivers $where";
			
			   $re = $db->Execute($sql);
			   $count = $re->fields['count'];
			   $page_num = ceil($count/AJAX_NUM);
			   $page_html="";
				 if($page_num > 1){
					$next_num = 2;
					$next_href ='<a onclick="ajax_page_of_reviews('.$next_num.',2,'.$page_num.')" class="splitPageLink">Next<i></i></a>';
					$page_total ='<div class="new_page_center" id="new_page_center">Page 1 of '.$page_num.'</div>';	
				
				  $page_html .='<div class="new_page_prev" id="new_page_prev"><span><i></i>Previous</span></div>';
				  $page_html .='<div class="new_page_next" id="new_page_next">'.$next_href.'</div>';
				  $page_html .= $page_total;
				 }
			   $network_platform_sql = "select network_platform from products_transceivers where 1=1 ".$b.$c.$d.$e.$f." GROUP BY network_platform";
			   $network_platformr = $db->getAll($network_platform_sql);
			   $network_platformr_arr = array();
			   foreach($network_platformr as $k=>$l){
					$network_platformr_arr[] = trim($l['network_platform']);
			   }
			   $form_factor_sql = "select form_factor from products_transceivers where 1=1 ".$a.$c.$d.$e.$f." GROUP BY form_factor";
			   $form_factorr = $db->getAll($form_factor_sql);
			   $form_factorr_arr = array();
			   foreach($form_factorr as $k=>$l){
					$form_factorr_arr[] = trim($l['form_factor']);
			   }
			   $type_sql = "select type from products_transceivers where 1=1 ".$a.$b.$d.$e.$f." GROUP BY type";
			   $typer = $db->getAll($type_sql);
			   $typer_arr = array();
			   foreach($typer as $k=>$l){
					$typer_arr[] = trim($l['type']);
			   }

			    $speed_sql = "select speed from products_transceivers where 1=1 ".$a.$b.$c.$e.$f." GROUP BY speed";
			   $speed = $db->getAll($speed_sql);
			   $speed_arr = array();
			   foreach($speed as $k=>$l){
					$speed_arr[] = trim($l['speed']);
			   }

			   $distance_sql = "select distance from products_transceivers where 1=1 ".$a.$b.$c.$d.$f." GROUP BY distance";
			   $distance = $db->getAll($distance_sql);
			   $distance_arr = array();
			   foreach($distance as $k=>$l){
					$distance_arr[] = trim($l['distance']);
			   }
			   $wavelength_filter_sql = "select wavelength_filter from products_transceivers where 1=1 ".$a.$b.$c.$d.$e." GROUP BY wavelength_filter";
	
			   $wavelength_filter = $db->getAll($wavelength_filter_sql);
			   $wavelength_filter_arr = array();
			   foreach($wavelength_filter as $k=>$l){
					$wavelength_filter_arr[] = trim($l['wavelength_filter']);
			   }           
				

				$network_platformr_array = array('Generic','Cisco','Arista Networks','Juniper Networks','Brocade','HPE','H3C','Dell','Extreme Networks','Huawei');
				//$form_factorr_array = array('SFP','10G SFP+','QSFP+','QSFP+28','XFP','X2','XENPARK','GBIC','QSFP+ Breakout','QSFP28 Breakout','CFP/CFP2','SFP28');
				//$form_factorr_array = array('SFP','10G SFP+','CFP/CFP2','GBIC','QSFP+','QSFP+ Breakout','QSFP28','QSFP28 Breakout','SFP28','X2','XENPAK','XFP');
				$form_factorr_array = array('SFP','10G SFP+','QSFP+','QSFP28','XFP','X2','XENPAK','GBIC','QSFP+ Breakout','QSFP28 Breakout','CFP/CFP2','SFP28');
				$typer_array = array('Regular','BIDI','CWDM','DWDM','Passive DAC','Active DAC','AOC');
				$speed_array = array('10/100/1000Mbit','100Mbit','1G','10G','25G','40G','100G','Fibre Channel','SONET/SDH');
				$distance_array = array('0.5-50m','80-100m','150-550m','1-5km','10-20km','25-40km','45-60km','70-80km','100-120km','150-160km');

				$wavelength_filter_array = array();
         
			   $network_platformr_a = array();
			   foreach($network_platformr_array as $key=>$v){
				    if(!in_array($v,$network_platformr_arr)){
						$network_platformr_a[] = $key;
					}
			   }
			   $form_factorr_arr_a = array();
			   foreach($form_factorr_array as $key=>$v){
					if(!in_array($v,$form_factorr_arr)){
						$form_factorr_arr_a[] = $key;
					}
			   }
			   $type_a = array();
			   foreach($typer_array as $key=>$v){
				    if(!in_array($v,$typer_arr)){
						$type_a[] = $key;
					}
			   }
			   $speed_a = array();
			   foreach($speed_array as $key=>$v){
				    if(!in_array($v,$speed_arr)){
						$speed_a[] = $key;
					}
			   }



			    $distance_a = array();
			   foreach($distance_array as $key=>$v){
				    if(!in_array($v,$distance_arr)){
						$distance_a[] = $key;
					}
			   }
			    $wavelength_filter_a = array();
			   foreach($wavelength_filter_array as $key=>$v){
				    if(!in_array($v,$wavelength_filter_arr)){
						$wavelength_filter_a[] = $key;
					}
			   }
			  
			   $list_array = array('list'=>$list,'num'=>array($nm,$nm1,$nm2),'page_html'=>$page_html,'network_platformr_a'=>$network_platformr_a,'form_factorr_arr_a'=>$form_factorr_arr_a,'type_a'=>$type_a,'speed_a'=>$speed_a,'distance_a'=>$distance_a,'wavelength_filter_a'=>$wavelength_filter_a);
			   echo json_encode($list_array);exit;
			break;		
		}

	}
}
