<?php
function get_discount_price($price,$qty,$products_id){
/*
	if($qty>0){
		if($qty>0 && $qty<=49){
			$discount_price = $price;
		}elseif($qty>49 && $qty<=199){
			$discount_price = $price*$default_discount_price[0];
		}elseif($qty>199 && $qty<=499){
			$discount_price = $price*$default_discount_price[1];
		}elseif($qty>499 && $qty<=999){
			$discount_price = $price*$default_discount_price[2];
		}else{
			$discount_price = $price*$default_discount_price[3];
		}
	}else{
		$discount_price = $price;
	}
	*/
	return $price;
}
function get_length_weight($id){
	global $db;
	$a = 0;
	$list = $db->getAll("select * from products_length where id='$id' limit 1");
	if($list){
		if($list[0]['price_prefix'] == "+"){
			$a = $list[0]['weight'];
		}
	}
	return $a;
}
function get_retail_status($product_id){
	global $db;
	$res = $db->getAll("select retail from products_count_length where products_id = '$product_id' limit 1");
	if($res){
		return $res[0]['retail'];
	}else{
		return 1;
	}
}
function get_category_length_price($product_id,$unit_price,$unit_weight,$retail){
	global $db;
	$cateArr = get_website_cateArr();
	$key_data = get_product_category_key($product_id);
	$key = $key_data['key'];
	  if($key==0){
		 $length_array = array(2,3,5,10,15,20,25,30);
			  foreach($length_array as $key=>$v){
				/*
				if($key==0 || $key==1){
					if($key==0){
						$length_price = 0.1;
					}elseif($key==1){
						$length_price = 0.3;
					}
					$weight = ($v-1)*$unit_weight;
				}else{
					$length_price = 0.3+($v-3)*$unit_price;
					$weight = ($v-1)*$unit_weight;
				}*/
				$length_price = ($v-1)*$unit_price;
				$weight = ($v-1)*$unit_weight;
				$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$v."m',product_id='".$product_id."',add_time='".date('Y-m-d H:i:s')."'");
			  }
	}elseif($key==1){
		if($retail == 1){
			$length_array = array(100,500,800,1000);
			foreach($length_array as $key=>$v){
					$length_price = ($v-1)*$unit_price;
					$weight = ($v-1)*$unit_weight;
					$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$v."m',product_id='".$_POST['productId_pl']."',add_time='".date('Y-m-d H:i:s')."'");
			}
		}else{
			$length_array = array(1,2,3);
			foreach($length_array as $key=>$v){
					$length_price = ($v*1000-1)*$unit_price;
					$weight = ($v*1000-1)*$unit_weight;
					$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$v."km',product_id='".$_POST['productId_pl']."',add_time='".date('Y-m-d H:i:s')."'");
			}
			
		}
	}elseif($key==2){
		$length_array = array(1,2,3);
		foreach($length_array as $key=>$v){
				$length_price = ($v*1000-1)*$unit_price;
				$weight = ($v*1000-1)*$unit_weight;
				$length = $v*1000;
				$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$length."m',product_id='".$_POST['productId_pl']."',add_time='".date('Y-m-d H:i:s')."'");
	    }
	}elseif($key==3){
		$length_array = array(3,5,10,15,20,25,30);
		foreach($length_array as $key=>$v){
				$length_price = ($v-1)*$unit_price;
				$weight = ($v-1)*$unit_weight;
				$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$v."m',product_id='".$_POST['productId_pl']."',add_time='".date('Y-m-d H:i:s')."'");
	    }
	}elseif($key==6){
		$length_array = array(25,50,100,500);
		foreach($length_array as $key=>$v){
				$length_price = ($v-1)*$unit_price;
				$weight = ($v-1)*$unit_weight;
				$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$v."m',product_id='".$_POST['productId_pl']."',add_time='".date('Y-m-d H:i:s')."'");
	    }
	}elseif($key==7){
		$length_array = array(5,10,15,20,25,30);
		foreach($length_array as $key=>$v){
				$length_price = ($v-3)*$unit_price;
				$weight = ($v-3)*$unit_weight;
				$db->query("insert into products_length set length_price = '".$length_price."',price_prefix='+',weight='".$weight."',length='".$v."m',product_id='".$_POST['productId_pl']."',add_time='".date('Y-m-d H:i:s')."'");
	    }
	}

}
function get_website_cateArr(){
	//$category_id_array = array(1,2,573);
	$cateArr = array();
	//foreach($category_id_array as $key=>$v){
		//$cateArr[] = array_unique(get_categories_son_id($v,1));
	//}
	$mpo = array_unique(get_categories_son_id(899,1));
	$multifibercables = array(1155);
	$patch_cable = array_unique(get_categories_son_id(209,1));
	$cate3 = array_unique(get_categories_son_id(573,1));
	foreach($patch_cable as $keys=>$v){
		$new_arr = array_merge($mpo,$cate3);
		foreach($new_arr as $k){
			if($k == $v){
				unset($patch_cable[$keys]);
			}
		}
	}
	$data_center = array_unique(get_categories_son_id(1308,1));
	array_push($patch_cable,1132,594,1343,2975,1140,1125,2974,1416,1415,593,594,3049,3074,978,3053,2875,3312,3311,3313,3314,2875);
	foreach($data_center as $y){
		array_push($patch_cable,$y);
	}
	$cateArr[0] = array_unique($patch_cable);
	$cable_array = array(1244,1245,1246,1247,1248,1249,1258,1259,1260,1261,1256,1239,1240,1241,1242,1243,1279,1280,1111);
	$cateArr[1] = $cable_array;
	array_push($cable_array,584); 
	
	foreach($cate3 as $key=>$v){
		if(in_array($v,$cable_array)){
			unset($cate3[$key]);
		}
	}
	array_push($cate3,3001,3002,3003,3004,3007,3008,3009,3010,3011,2978,2966,2977,3005,3006);
	$cateArr[2] = array_unique($cate3);
	$cateArr[3] = $mpo;
	$cateArr[4] = array(1115,1117,1217,1220,2232,2298,2254,2342);
	$cateArr[5] = array(1218);
	$cateArr[6] = array(1067);
	$cateArr[7] = array(584);
	
	return $cateArr;
}
function get_categories_son_id($cid,$c=0){
	/*global $db,$array_1;
	if($c == 1){
		$array_1 = array($cid);
	}
	$result = $db->getAll("select categories_id,parent_id from categories where parent_id = '$cid'");
	foreach($result as $key=>$v){
		$array_1[] = $v['categories_id'];
		get_categories_son_id($v['categories_id']);
	}
	return $array_1;*/
	$array_1 = [];
    if($c==1){
        $array_1[] = $cid;
    }
    zen_get_subcategories_redis($array_1, $cid);
    return $array_1;
}

function get_product_category_key($product_id){
	global $db;
	$categories_data = [];
	$result = $db->getAll("select categories_id from products_to_categories where products_id = '$product_id' limit 1");
	if($result){
		$categories_id = $result[0]['categories_id'];
		$cateArr = get_website_cateArr();
		if($cateArr){
			foreach($cateArr as $key=>$v){
                 if(in_array($categories_id,$v)){
                  return [ 'categories_id' =>$categories_id,'key'=>$key]; break;
				 }
			}
			return  ['categories_id' =>$categories_id,'key'=> -1];
		}else{
            return ['categories_id' =>$categories_id, 'key'=> -1];
		}
	}else{
        return [ 'categories_id' =>0, 'key'=> -1];
	}
}
function get_product_category_id($product_id){
	global $db;
	$result = $db->getAll("select categories_id from products_to_categories where products_id = '$product_id' limit 1");
	if($result){
		$categories_id = $result[0]['categories_id'];
		$cateArr = get_website_cateArr();
		if($cateArr){			
			foreach($cateArr as $key=>$v){
                 if(in_array($categories_id,$v)){
					 return true;break;
				 }
			}
			return false;
		}else{
			return false;
		}

	}else{
		return false;
	}
}

//购物车等相关页面长度属性展示函数
function zen_show_product_length($length,$pid){
	global $db;
	$lentgh_str = '';
	$new_length = '';
	$lentgh_str = get_length_exchange_ft_str($length);
	if($lentgh_str==''){
		$key_data = get_product_category_key($pid);
		$key = $key_data['key'];
		$retail = get_retail_status($pid);
		if($key == 2 || ($key == 1 && $retail==0)){
			$lentgh_str = '';
		}else{
			$lentgh_str = round(substr($length,0,-1)/0.3048,2);
			$lentgh_str .= 'ft';
		}
	}
	$cPath = zen_get_product_path($pid);
	$cPathArr = explode('_',$cPath);
	if($lentgh_str==''){
		$new_length = $length;
	}else{
		if(in_array($cPathArr[2],array(3314,3312))){
			$new_length = $lentgh_str.' ('.$length.')';
		}else{
			$new_length = $length.' ('.$lentgh_str.')';
		}
	}
	return $new_length;
}
/*
 *有定制长度属性产品长度区间重量计算
 *
 *@param2 string $length,长度如3m/3km
 *
 *@param3 array $attr,产品属性数组，array('option_id'=>'option_value_id')
 *
 */
function zen_get_products_length_weight($product_id,$length,$attr=array()){
	global $db;
	$weigth_data = array();
	$weight = 0;
	if(strpos($length,'km')!==false){
		$length = str_replace('km','',$length);
		$length = $length*1000;
	}else{
		$length = str_replace('m','',$length);
	}
	if($length<1) $length = 1;
	//获取所有的重量区间的数据
	if((int)$product_id){
		$result = $db->Execute("SELECT min_length,max_length,base_weight,per_weight,option_value_id,area_sort FROM products_length_weight WHERE product_id=".(int)$product_id." ORDER BY area_sort");
		while(!$result->EOF){
			$weigth_data[$result->fields['area_sort']][] = array(
				'min_length' => $result->fields['min_length'],
				'max_length' => $result->fields['max_length'],
				'base_weight' => $result->fields['base_weight'],
				'per_weight' => $result->fields['per_weight'],
				'option_value_id' => $result->fields['option_value_id'],
				'area_sort' =>$result->fields['area_sort']
			);
			$result->MoveNext();
		}
		$min_length = $max_length = $per_weight = $base_weight = 0;
		if(sizeof($weigth_data)){
			foreach($weigth_data as $key=>$wval){
				foreach($wval as $kk=>$val){
					//该长度区间存在多种情况受属性值影响
					if($val['option_value_id']){
						$value_arr = explode(',',$val['option_value_id']);
						foreach($attr as $oid=>$vid){
							if(in_array($vid,$value_arr)){
								$min_length = $val['min_length'];
								$max_length = $val['max_length'];
								$per_weight = $val['per_weight'];
								$base_weight = $val['base_weight'];
								continue 2;	//已找到该区间属性值所对应的区间重量记录则结束循环
							}
						}
					}else{
						$min_length = $val['min_length'];
						$max_length = $val['max_length'];
						$per_weight = $val['per_weight'];
						$base_weight = $val['base_weight'];
					}
				}
				//若长度大于当前区间的最大长度,就先计算当前区间的重量
				if($length>$max_length){
					if($min_length>$max_length){
						//如果最小长度大于最大长度则表示该区间没有最大长度限制，所有长度都按照该区间价格计算
						$weight += $base_weight + ($length-$min_length)*$per_weight;
						break;
					}else{
						//重量计算方法，base_weight+(max_length-min_length)*per_weight
						$weight += $base_weight + ($max_length-$min_length)*$per_weight;
					}
				}else{
					//若长度小于当前区间的最大长度,就直接用该长度length计算当前区间的重量
					if($length>$min_length){
						$weight += $base_weight + ($length-$min_length)*$per_weight;
					}
					break;
				}
			}
		}
	}
	return $weight;
}
//查找长度区间重量表中是否有该产品的重量记录
function get_products_length_weight_count($products_id){
	global $db;
	$count = 0;
	if((int)$products_id){
		$data = $db->getAll("select count(id) total from products_length_weight where product_id=".(int)$products_id);
		if($data[0]['total']) $count = $data[0]['total'];
	}
	return $count;
}

?>