<?php
    use classes\custom\FsCustomRelate;

	define('ATTRIBUTE_FIBER_TYPE', 'Fiber Type');
	define('ATTRIBUTE_FIBER_COUNT', 'Fiber Count');
	define('ATTRIBUTE_TUBE_COLOR', 'Inner Tube Color');
	define('ATTRIBUTE_FIBER_COLOR', 'Fiber Color');
    define('SPECIALSERVICE', 'Special Service');
	define('PORTCONNECTORS','Channels Port Connectors');
	define('BRAND','Compatible Brands');
	define('ADDITIONALFUNCTION','Additional Function');
	define('WAVELENGTH','Wavelength');
	define('PACKAGETYPE','Package Type');
	define('CONNECTORB','Connector B');
	define('POLISHB','Polish B');
	define('CONNECTORA','Connector A');
	define('POLISHA','Polish A');
	define('CABLEDIAMETER','Cable Diameter');

    //定制属性 Others
    function get_attributes_others($products_options_name,$attr_value=""){
        global $db;
        if(in_array(trim($products_options_name),array(ATTRIBUTE_FIBER_TYPE,ATTRIBUTE_FIBER_COUNT,ATTRIBUTE_OUTER_JACKET,ATTRIBUTE_Package))) return false;
        $result1=$db->getAll("select products_options_id from products_options where products_options_name = '".trim($products_options_name)."' and products_options_type=0 limit 1");
        $result2=$db->getAll("select products_options_id from products_options where products_options_name = '".trim($products_options_name)."' and products_options_type=1 limit 1");
        if(!empty($result1) && !empty($result2)){
            if($attr_value){
                if($attr_value == 'Others' || $attr_value == 'with pulling eye'){
                    return true;
                }else{
                    return false;
                }
            }else{
                return  true;
            }
        }else{
            return  false;
        }
    }

    function pulling_eye_status($option_id){
        global $db;

        $res = $db->getAll("select products_options_name from products_options where products_options_id = '".$option_id."' and products_options_type = 1 limit 1");
        if($res){
            if($res[0]['products_options_name'] == PULLINGEYE){
                return true;
            }
        }
        return false;
    }

	//HP 根据产品价格 加上它的60%的价格
    // 2019-7-23 potato 添加第二个参数，$product_detail，此为product_info/header_php.php已经查询过的数据
	function set_hp_option_price($products_id ,$product_detail = ''){
		global $db,$cPath_array;
		// 2019-7-23 potato 后面有用到products表查询的数据，所以加一个参数$product_detail
		$products_base_price = zen_get_products_base_price((int)$_GET['products_id'], $clearance = false, $product_detail);
		$new_add_option_price = $products_base_price*0.4;
		if(in_array($cPath_array[2],array(63,114))){
			$list = $db->getAll("SELECT products_attributes_id FROM products_attributes WHERE products_id = '$products_id' AND options_values_id=1082 limit 1");
			if($list){
				$db->query("UPDATE products_attributes SET price_prefix='+',options_values_price='$new_add_option_price' WHERE products_attributes_id = '".$list[0]['products_attributes_id']."'");
			}
		}
	}
	//详情  显示(eg,Cisco Nexus 7000)
	function option_name_detail($products_options_name){
		if($products_options_name == 'Compatible Brands'){
			return true;
		}else{
			return false;
		}
	}
	//对 Custom 设置是否为BLOCK  inline
	function set_block_inline($products_options_name){
		if($products_options_name == 'Compatible Brands'){
			return true;
		}else{
			return false;
		}
	}

    /**
     * 2020.3.21  ery add 新增该函数供get_category_parent_id调用
     * @param $cate_id
     * @param $cate_arr
     * @return array
     */
    /*function get_category_parent_id_by_cid($cate_id,$cate_arr){
        global $db;
        $sqlCache = sqlCacheType();
        $act_info = $db->getAll("select {$sqlCache} categories_id,parent_id from categories where categories_id = '".$cate_id."' limit 1");
        if($act_info){
            $cate_arr[] = $act_info[0]['categories_id'];

            $cate_arr = get_category_parent_id($act_info[0]['parent_id'],$cate_arr);

        }
        return $cate_arr;

    }*/
	

	function get_category_parent_id($cate_id,$cate_arr){
        /*$parent_categories_md5 = md5('parent_categories_by_cid_'.$cate_id);
        $redis_categories = get_redis_key_value($parent_categories_md5,'parent_categories_all');
        if(!$redis_categories){
            //当前分类的所有父分类若没有存入redis中就查询数据库
            $cate_arr = get_category_parent_id_by_cid($cate_id, $cate_arr);
            set_redis_key_value($parent_categories_md5, $cate_arr,24*3600,'parent_categories_all');
        }else{
            foreach($redis_categories as $key=>$value){
                $cate_arr[sizeof($cate_arr)] = $value;
            }
        }*/
        global $db;
        $sqlCache = sqlCacheType();
        $act_info = $db->getAll("select {$sqlCache} categories_id,parent_id from categories where categories_id = '".$cate_id."' limit 1");
        if($act_info){
            $cate_arr[] = $act_info[0]['categories_id'];

            $cate_arr = get_category_parent_id($act_info[0]['parent_id'],$cate_arr);

        }
		return $cate_arr;
		
	}
	function get_category_sons_id($cate_id,$cate_arr){
		global $db;
		$act_info = $db->getAll("select categories_id,parent_id from categories where parent_id = '".$cate_id."'");
		if($act_info){	
			foreach($act_info as $key=>$v){
				$cate_arr[] = $v['categories_id'];
	
				$cate_arr = get_category_sons_id($v['categories_id'],$cate_arr);
			}
				
		}
		return $cate_arr;
	}
	function transceivers_categories($cid){
		$transceivers_arr = get_category_sons_id(9,array());
		$array = array(80,62,110,132,139,155);
		foreach($transceivers_arr as $key=>$v){
			foreach($array as $k){
				if($k == $v){
					unset($transceivers_arr[$key]);
				}
			}
		}
		if(in_array($cid,$transceivers_arr)){
			return true;
		}else{
			return false;
		}
	}

	function fiber_output_html($products_options_name){
		$html = "";
		if($products_options_name == ATTRIBUTE_FIBER_COUNT){
			$html .= "<span id='fiber_count_span'></span>";
		}
		return $html;
	}
	//判断是否存在Fiber Type，Fiber Count属性
	function attribute_type_count($attribute){
		global $db;
		$fiber_type_s = "";
		$fiber_count_s = "";
		if($attribute){
			foreach($attribute as $key=>$v){
				if(intval($key) > 0){
						$attribute_list = $db->getAll("select * from products_options where products_options_id = '$key' limit 1");
						$name = $attribute_list[0]['products_options_name'];
						if($name == ATTRIBUTE_FIBER_TYPE || $name == ATTRIBUTE_FIBER_COUNT){
							$a = $db->getAll("select * from products_options_values where products_options_values_id = '$v' and language_id = 1 limit 1");
							if($a){
								if($name == ATTRIBUTE_FIBER_TYPE){
									$fiber_type_s = $a[0]['products_options_values_name'];
								}elseif($name == ATTRIBUTE_FIBER_COUNT){
									$fiber_count_s = $a[0]['products_options_values_name'];
								}
							}
						}
					}
			}
		}
		if(!empty($fiber_type_s) && !empty($fiber_count_s)){
			//return true;
			return false;  //重新修改
		}else{
			return false;
		}
	}	
	function get_fiber_count_weight($fiber_count){
		
		if($fiber_count >= 4 && $fiber_count <=24){
			$weights = 116;
		}elseif($fiber_count == 36){
			$weights = 129;
		}elseif($fiber_count == 48){
			$weights = 141;
		}elseif($fiber_count == 64 || $fiber_count == 72){
			$weights = 159;
		}elseif($fiber_count == 96){
			$weights = 209;
		}elseif($fiber_count == 122 || $fiber_count == 144){
			$weights = 280;
		}else{
			$weights = 0;
		}
		return $weights;
							
	}

	function get_outer_jacket_length($length_id,&$length=''){
		global $db;
		$length_arr = $db->getAll("select length from products_length where id='".$length_id."' limit 1");
		$length_s = 1;
		if($length_arr){
			$length_q = $length = $length_arr[0]['length'];
			if(stripos($length_q,'km')){
				$length_s = substr(trim($length_q),0,-2);
				$length_s = $length_s*1000;
			}elseif(stripos($length_q,'m')){
				$length_s = substr(trim($length_q),0,-1);
			}
		}
		return $length_s;
	}
	//获取属性项需要按照/m展示加价的属性项
	function zen_get_all_option_price_type(){
		global $db;
		$option = array();
		$sql = "select products_options_id from products_options where language_id=".$_SESSION['languages_id']." and price_type!=0";
		$res = $db->Execute($sql);
		if($res->RecordCount()){
			while(!$res->EOF){
				$option[] = $res->fields['products_options_id'];
				$res->MoveNext();
			}
		}
		return $option;
	}
	function zen_get_all_option_by_price_type($type=1){
		global $db;
		$option = array();
		$sql = "select products_options_id from products_options where language_id=".$_SESSION['languages_id']." and price_type=".$type;
		$res = $db->Execute($sql);
		if($res->RecordCount()){
			while(!$res->EOF){
				$option[] = $res->fields['products_options_id'];
				$res->MoveNext();
			}
		}
		return $option;
	}
	function get_outer_jacket_options_values_price($option,$options_values_price,$length_s,$price_type=''){
		global $db;
		$option = (int)$option;
		if($length_s<1) $length_s = 1;
		//$price_type为1或2是 属性价格的长度有关
		if($option && $price_type==''){
			$price_type = fs_get_data_from_db_fields('price_type', 'products_options', 'language_id='.$_SESSION['languages_id'].' and products_options_id='.$option,'limit 1');
		}
		if($price_type==1){
			//属性价格的计算方式是（n-1)*$price
			$options_values_price = $options_values_price*($length_s-1);
		}else if($price_type==2){
			//属性价格的计算方式是n*$price
			$options_values_price = $options_values_price*$length_s;
		}
		return $options_values_price;
	}
	//对Remark  颜色块进行设置
	function get_remark_status($products_options_id){
		global $db;
		$a = $db->getAll("select products_options_name from products_options where products_options_id = '$products_options_id' limit 1");
		if($a){
	      $attribute_arr = array(ATTRIBUTE_TUBE_COLOR,ATTRIBUTE_FIBER_COLOR,WAVELENGTH,CONNECTORB,POLISHB,CONNECTORA,POLISHA,CABLEDIAMETER,'Cable Jacket','Fiber Type',747,750,754,759,765,772,780,822);
			if(in_array($a[0]['products_options_name'],$attribute_arr) || in_array($products_options_id,$attribute_arr)){
				foreach($attribute_arr as $key=>$n){
					if($a[0]['products_options_name'] == $n || $products_options_id == $n){
						return $key+1;
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	function fiber_optic_network($option_name){
		$option_name = trim(strip_tags(str_replace('*','',$option_name)));
		return $option_name;
	}
	//对fiber service属性进行设置
	function specical_service_status($products_options_id){
		global $db;
		$a = $db->getAll("select products_options_name from products_options where products_options_id = '$products_options_id' limit 1");
		if($a){
			if(in_array($a[0]['products_options_name'],array(SPECIALSERVICE,ADDITIONALFUNCTION,PACKAGETYPE))){
					return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

function  Channels_Port_option_value_id($products_options_id,$products_options_name){
    global $db;
    $info = array();
    if($products_options_name == PORTCONNECTORS){
        $info = $db->getAll("select * from products_options_values_to_products_options where products_options_id = '$products_options_id'");
    }
    return $info;
}
function get_spool_option_data($product_id){
	 global $db;
	 $option_data = [];
	 if($product_id){
        $option_data = $db->getAll('SELECT popt.products_options_id,popt.products_options_name,popt.products_options_type,products_options_word,patrib.options_values_id FROM '.TABLE_PRODUCTS_OPTIONS .' popt LEFT JOIN '.TABLE_PRODUCTS_ATTRIBUTES.' patrib ON popt.products_options_id=patrib.options_id
	     WHERE patrib.products_id= '.(int)$product_id.'  AND patrib.attributes_status=1 AND popt.products_options_id = 341 AND products_options_status=1 AND popt.language_id = '.$_SESSION['languages_id'].' LIMIT 1');
        if(!empty($option_data) && $option_data[0]['options_values_id'] !=0){
            $option_data = $option_data[0];
            $value_sql = "select pov.products_options_values_id, pov.products_options_values_name,pa.options_values_id,pa.price_prefix,pa.options_values_price,pa.options_id
                                        from ". TABLE_PRODUCTS_ATTRIBUTES ." pa," .TABLE_PRODUCTS_OPTIONS_VALUES. " pov 
                                        where pa.products_id = '" .$product_id . "' 
                                        and pa.options_id = ".$option_data['products_options_id']."
                                        and pa.options_values_id = pov.products_options_values_id
					                    and pov.language_id = '" . (int)$_SESSION['languages_id'] . "'
					                    and pa.attributes_status=1
					                    order by LPAD(pov.products_options_values_sort_order,11,'0') 
					                    limit 1";
            $value_data = $db->getAll($value_sql);
            $value_data = $value_data ? $value_data[0] : '';
            $option_data['products_values'] = $value_data;
        }
	 }
	 return $option_data;
}

/**
 * 获取层级属性 展示的的html字符串
 * 说明一下：层级属性是树状结构。产品id是第一层（parent_id = 0的层）。一个属性项、属性值属于一层。
 * @param int $pid：产品id
 * @param int $third_categories_id：产品所属三级分类id
 * @param string $html_select_type：属性选择类型dom
 * @return string
 */
function zen_get_fs_attribute_box($pid, $third_categories_id=0,$html_select_type=''){
    global $db,$currencies;

    // 获取产品的层级属性id
    $sql = "select column_id,column_name from attribute_custom_column where column_name = '" . (int)$pid . "' and parent_id = 0 limit 1";
    $attribute_custom_column = $db->Execute($sql);
    $allAttr = '';
    $attr = '';
    if($attribute_custom_column->fields['column_name']>0){
        $column_id = $attribute_custom_column->fields['column_id'];

        // 获取 当前产品 默认展示的所有的层级栏目id数组。
        $column_array = zen_get_all_sub_column($column_id);
        // 把第一层产品id也放到开头
        array_unshift($column_array,$column_id);

        $id ="";
        $html = "<div class='detail_proSelct_team'>".$html_select_type."<ul><div id='fs_attribute'>";
        // 循环层级栏目id数组
        foreach($column_array as $kk=>$column){
            // 获取当前层级栏目id，对应的属性项的id。一般情况情况是只有一个。
            $count = $db->getAll("select distinct cc.attr_id from attribute_custom_column cc left join products_options ca on (cc.attr_id=ca.products_options_id) where parent_id=".$column." and cc.language_id=1 and ca.language_id=".$_SESSION['languages_id']."");
            $id .= $column.'_';
            $is_old_disabled = "disabled";
            $select_class = 'fs_select_old';
            if(!$html_select_type){
                $is_old_disabled = '';
                $select_class = '';
            }
            $data_column_id = '';
            for($i=0,$total=count($count);$i<$total;$i++){
                // 获取当前层级栏目id，属性项的对应的属性值数组
                $sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=".$column." and language_id=1 and attr_id=".$count[$i]['attr_id']."  order by sort");
                if($kk==0){
                    $data_column_id = 'data-column-id="'.$column.'"';
                }
                //获取父级栏目的信息。后面有些展示需要。
                $parent_attr_id = fs_get_data_from_db_fields('attr_id','attribute_custom_column','column_id='.$column,'limit 1');
                $parent_attribute_type = fs_get_data_from_db_fields('products_options_type','products_options','products_options_id='.$parent_attr_id.' and language_id='.$_SESSION['languages_id'],'');
                if($sub_one&&$sub_one[0]['attr_value_id']){
                    //获取属性项的相关信息
                    $attribute_id = $sub_one[0]['attr_id'];
                    $allAttr .= $sub_one[0]['attr_id']; // default选中的属性值都拼接起来
                    $option_data = fs_get_data_from_db_fields_array(['products_options_name','products_options_type','products_options_word'],'products_options','products_options_id='.$attribute_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                    $attribute_name = $option_data[0][0];
                    $attribute_type = $option_data[0][1];
                    $option_remark = $option_data[0][2];
                    // 属性项的备注
                    if($option_remark){
                        $option_remark = getNewWordHtml($option_remark);
                    }
                    if($attribute_name){
                        //单选也展示为下拉框
                        if($attribute_type == 0 || $attribute_type ==2){     //select
                            $html_custom='';
                            $html .= '<li class="detail_proSelct_li" id="'.$id.'"><div class="product_03_09 product_03_12 custom_attribute">';
                            $html .= '<span class="product_03_02 product_03_15"><label class="attribsSelect" for="attrib-'.$attribute_id.'"><span>'.$attribute_name.'</span>:'.$option_remark.'</label></span>';
                            $html .= '<span class="product_03_08 detail_proSelct_checked">';
                            $html .= '<select class="login_country changez '.$select_class.'" '.$is_old_disabled.' '.$data_column_id.' onchange="change_attribute(this,$(this).find(\'option:selected\').attr(\'id\'),'.$attribute_id.',this.value,$(this).find(\'option:selected\').attr(\'class\'),'.$column_id.',1)" name="ids['.$attribute_id.']" id="attrib-'.$attribute_id.'" rel="AttrSelect">';
                            //$html .='<option value="0">'.PLEASE_SELECT.'</option>';
                            $tishi = '';
                            foreach($sub_one as $k=>$h){
                                $option_value_data = fs_get_data_from_db_fields_array(['options_values_word','products_options_values_name'],'products_options_values','products_options_values_id='.$h['attr_value_id'].' and language_id='.$_SESSION['languages_id'],'limit 1');
                                $option_value_word = $option_value_data[0][0];
                                $attribute_value_name = $option_value_data[0][1];
                                if($k==0){
                                    $allAttr .= ':'.$h['attr_value_id'].'_'.$h['column_id'].',';// default选中的属性值都拼接起来
                                    $attr .= $h['attr_value_id'].'_'.$h['column_id'].',';
                                    if ($option_value_word) {
                                        $tishi = getNewWordHtml($option_value_word);
                                    }
                                }

                                if($attribute_value_name){
                                    $default_selected = '';
                                    if($k==0){
                                        $default_selected = 'selected="selected"';
                                    }
                                    $html .= '<option '.$default_selected.' value="'.$h['attr_value_id'].'_'.$h['column_id'].'" id="'.$h['column_id'].'" class="'.$id.'">'.$attribute_value_name.'</option>';
                                }
                                //定制输入框
                                if($h['attr_value_id']==4262){
                                    $related_id = fs_get_data_from_db_fields('related_option_id','products_options','products_options_id='.$attribute_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                                    if($related_id){
                                        $custom_style = '';
                                        if($default_selected==''){
                                            $custom_style = 'style="display:none"';
                                        }
                                        $html_custom .= '<div class="custom_wavelength" '.$custom_style.'><input id="attrib-'.$related_id.'-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_'.$related_id.']" placeholder="">';
                                        $option_word = fs_get_data_from_db_fields('products_options_word','products_options','products_options_id='.$related_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                                        $word_error = '';
                                        if($option_word){
                                            $html_custom .= getNewWordHtml($option_word);
                                            $word_error .= '<div style="color: #c00000; display: none;" class="word_error">'.$option_word.'</div>';
                                        }
                                        $html_custom .= $word_error.'</div>';
                                    }
                                }

                            }
                            $html .= '</select>';

							$html .= $html_custom.'<div id="product_tishi_'.$attribute_id.'">'.$tishi.'</div></span>';
                            $html .= '<div class="ccc"></div>';
                            $html .= '</div></li>';
                        }elseif($attribute_type == 2){    //radio

                            $html .= '<div class="product_03_09 product_03_12 custom_attribute" id="'.$id.'">';
                            $html .= '<span class="product_03_02 product_03_15">'.$attribute_name.': '.$option_remark.'</span>';
                            $html .= '<span class="product_03_08 detail_proSelct_checked">';
                            foreach($sub_one as $k=>$h){
                                if($k==0){
                                    $allAttr .= ':'.$h['attr_value_id'].'_'.$h['column_id'].',';// default选中的属性值都拼接起来
                                    $attr .= $h['attr_value_id'].'_'.$h['column_id'].',';
                                }
                                if($parent_attr_id==78 && $parent_attribute_type==3){
                                    $onclick = 'onclick="change_attribute(this,'.$h['column_id'].','.$attribute_id.','.$h['attr_value_id'].',\''.$id.'\','.$column_id.',0)"';
                                }else{
                                    $onclick = 'onclick="change_attribute(this,'.$h['column_id'].','.$attribute_id.','.$h['attr_value_id'].',\''.$id.'\','.$column_id.',1)"';
                                }
                                $option_value_data = fs_get_data_from_db_fields_array(['options_values_word','products_options_values_name'],'products_options_values','products_options_values_id='.$h['attr_value_id'].' and language_id='.$_SESSION['languages_id'],'limit 1');
                                $option_value_word = $option_value_data[0][0];
                                $attribute_value_name = $option_value_data[0][1];
                                $tishi = '';

                                if($option_value_word){
                                    $tishi .= ' <div class="question_text" style="margin-top: 0;">
                                <div class="question_bg"></div>
                                <div class="question_text_01 leftjt">
                                    <div class="arrow"></div>
                                    <div class="popover-content">
                                       '.$option_value_word.'
                                    </div>
                                </div>
                            </div>';
                                }

                                if($attribute_value_name){
                                    $html .= '<label class="attribsRadioButton zero" for="attrib-'.$attribute_id.'-'.$h['attr_value_id'].'"><input name="ids['.$attribute_id.']"  value="'.$h['attr_value_id'].'_'.$h['column_id'].'"  id="attrib-'.$attribute_id.'-'.$h['attr_value_id'].'" type="radio" id="'.$h['column_id'].'" class="'.$id.'"  '.$onclick.'>'.$attribute_value_name.$tishi.'</label>';
								}
                                //定制输入框
                                if($h['attr_value_id']==4262){
                                    $related_id = fs_get_data_from_db_fields('related_option_id','products_options','products_options_id='.$attribute_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                                    if($related_id){
                                        $html .= '<div class="custom_wavelength" style="display:none;"><input id="attrib-'.$related_id.'-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_'.$related_id.']" placeholder="">';
                                        $option_word = fs_get_data_from_db_fields('products_options_word','products_options','products_options_id='.$related_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                                        if($option_word){
                                            $html .= '<div class="track_orders_wenhao">
                                    <div class="question_bg"></div>
                                    <div class="question_text_01 leftjt"><div class="arrow"></div>
                                      <div class="popover-content">'.$option_word.'</div>
                                    </div></div>';
                                        }
                                        $html .= '</div>';
                                    }
                                }
                            }

                            $html .= '</span>';
                            $html .= '<div class="ccc"></div>';
                            $html .= '</div>';

                        }elseif($attribute_type == 3){    //checkbox

                            $html .= '<li class="detail_proSelct_li" id="'.$id.'"><div class="product_03_09 product_03_12 custom_attribute">';
                            $html .= '<span class="product_03_02 product_03_15">'.$attribute_name.': '.$option_remark.'</span>';
                            $html .= '<span class="product_03_08 detail_proSelct_checked">';
                            foreach($sub_one as $k=>$h){
                                $checked = '';
                                $active = '';
                                //$checkbox_disabled = 'checkbox_disabled';
                                $checkbox_disabled = '';
                                if($k==0){
                                    $allAttr .= ':'.$h['attr_value_id'].'_'.$h['column_id'].',';// default选中的属性值都拼接起来
                                    $attr .= $h['attr_value_id'].'_'.$h['column_id'].',';
                                    $checked = 'checked=checked';
                                    //$checkbox_disabled = 'default_attribute_checkbox active';
                                    $checkbox_disabled = 'active';
                                }
                                $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name','products_options_values','products_options_values_id='.$h['attr_value_id'].' and language_id='.$_SESSION['languages_id'],'limit 1');
                                if($attribute_value_name){
                                    $html .= '<label class="attribsCheckboxButton '.$checkbox_disabled.'"><input '.$checked.' name="ids['.$attribute_id.']['.$h['attr_value_id'].']" value="'.$h['attr_value_id'].'_'.$h['column_id'].'" tag="'.$attribute_id.'-'.$h['attr_value_id'].'" id="attrib-'.$attribute_id.'-'.$h['attr_value_id'].'" type="checkbox" id="'.$h['column_id'].'" class="'.$id.'" onclick="change_attribute(this,'.$h['column_id'].','.$attribute_id.','.$h['attr_value_id'].',\''.$id.'\','.$column_id.',1)" '.$is_old_disabled.'>'.$attribute_value_name.'</label>';
                                }
                            }
                            $html .= '</span>';
                            $html .= '<div class="ccc"></div>';
                            $html .= '</div></li>';
                        }
                    }
                }
            }
        }
        //特殊属性 线轴加价处理
        $spool_data = get_spool_option_data($pid);
        if(!empty($spool_data) && !empty($spool_data['products_values'])){
            $products_values = $spool_data['products_values'];
            $html  .='
           <li class="detail_proSelct_li spool_price_proSelct_li" style="display: none">
               <div id="" class="product_03_09 product_03_12 fiber_optic_network custom_attribute">
                   <span class="product_03_02 product_03_15 ">
                       <label class="attribsSelect" for="attrib-'.$spool_data['products_options_id'].'">
                       <span>'.$spool_data['products_options_name'].'</span>:
                       </label>
                   </span>
                   <span class="product_03_08 detail_proSelct_checked "> 
                       <select class="login_country changez" name="ids['.$spool_data['products_options_id'].']" id="attrib-'.$spool_data['products_options_id'].'" rel="AttrSelect">
                           <option value="' . $products_values['products_options_values_id'] . '" selected="selected">' . $products_values['products_options_values_name'] . '
                           </option>
                       </select>
                    </span>
                    <div class="ccc"></div>
               </div>
           </li>';
        }
    }
    $html .= "</div></div></ul>";
    $data = array('html'=>$html,'all_Attr'=>$allAttr,'attr'=>$attr);
    return $data;
}


/**
 * 获取层级属性 展示的的报价购物车html字符串
 * 说明一下：层级属性是树状结构。产品id是第一层（parent_id = 0的层）。一个属性项、属性值属于一层。
 * @param int $pid：产品id
 * @return string
 */
function zen_get_fs_inquiry_attribute_box($pid,$attribute_arr=array(),$column_id){
	global $db,$currencies;

	$html = '';
	// 获取产品的层级属性id
	$sql = "select column_id,column_name from attribute_custom_column where column_name = '" . (int)$pid . "' and parent_id = 0 limit 1";
	$attribute_custom_column = $db->Execute($sql);
	$allAttr = '';
	$attr = '';
	if($attribute_custom_column->fields['column_name']>0){
		$column_id = $attribute_custom_column->fields['column_id'];
		// 获取 当前产品 默认展示的所有的层级栏目id数组。
		$column_array = zen_get_all_sub_column($column_id);
		// 把第一层产品id也放到开头
		array_unshift($column_array,$column_id);
		$id ="";
		$html = '';
		// 循环层级栏目id数组
		foreach($column_array as $kk=>$column){
			// 获取当前层级栏目id，对应的属性项的id。一般情况情况是只有一个。
			$count = $db->getAll("select distinct cc.attr_id from attribute_custom_column cc left join products_options ca on (cc.attr_id=ca.products_options_id) where parent_id=".$column." and cc.language_id=1 and ca.language_id=".$_SESSION['languages_id']."");
			$id .= $column.'_';
			$is_old_disabled = "disabled";
			$data_column_id = '';
			$first_key=0;
			for($i=0,$total=count($count);$i<$total;$i++){
				// 获取当前层级栏目id，属性项的对应的属性值数组
				$sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=".$column." and language_id=1 and attr_id=".$count[$i]['attr_id']."  order by sort");
				if($kk==0){
					$data_column_id = 'data-column-id="'.$column.'"';
				}

				//获取父级栏目的信息。后面有些展示需要。
				$parent_attr_id = fs_get_data_from_db_fields('attr_id','attribute_custom_column','column_id='.$column,'limit 1');
				$parent_attribute_type = fs_get_data_from_db_fields('products_options_type','products_options','products_options_id='.$parent_attr_id.' and language_id='.$_SESSION['languages_id'],'');
				if($sub_one&&$sub_one[0]['attr_value_id']){
					//获取属性项的相关信息
					$attribute_id = $sub_one[0]['attr_id'];
					$allAttr .= $sub_one[0]['attr_id']; // default选中的属性值都拼接起来
					$attribute_name = fs_get_data_from_db_fields('products_options_name','products_options','products_options_id='.$attribute_id.' and language_id='.$_SESSION['languages_id'],'');
					$attribute_type = fs_get_data_from_db_fields('products_options_type','products_options','products_options_id='.$attribute_id.' and language_id='.$_SESSION['languages_id'],'');

					$option_remark = fs_get_data_from_db_fields('products_options_word','products_options','products_options_id='.$attribute_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
					// 属性项的备注
					if($option_remark){
						$option_remark = getNewWordHtml($option_remark);
					}

					if($attribute_name){
						//单选也展示为下拉框
						$html_custom='';
						if($attribute_type==3){
							$html .= '<li id="' . $id . '" calss="re_ul"><span class="re_select_name">' . $attribute_name . ': '.$option_remark.'</span>
							<div class="alone_container alone_container_radio"><div class="re_radio_container">';
						}else{
							$pid_str = $pid;
							$is_attr = strstr($pid, ':');
							if($is_attr==true){
								$attr_str = explode(':',$is_attr);
								$pid_str = $attr_str[1];
							}

							$html.='<li id="'.$id.'"><span class="re_select_name">'.$attribute_name.': '.$option_remark.'</span>';
							$html .= '<div class="alone_container"><select class="re_select '.$pid_str.'" id="attrib-'.$attribute_id.'" attr_pro="'.$pid_str.'" attr_products="'.$pid.'"   onchange="change_attribute(this,$(this).find(\'option:selected\').attr(\'id\'),'.$attribute_id.',this.value,$(this).find(\'option:selected\').attr(\'class\'),'.$column_id.',1)"  name="ids['.$attribute_id.']" rel="AttrSelect"><option value="">'.FS_INQUIRY_INFO_30_1.'</option>';
						}
						foreach($sub_one as $k=>$h){
							$showFlag = true;
							if($k==0){
								$allAttr .= ':'.$h['attr_value_id'].'_'.$h['column_id'].',';// default选中的属性值都拼接起来
								$attr .= $h['attr_value_id'].'_'.$h['column_id'].',';
							}
							$attribute_value_name = fs_get_data_from_db_fields('products_options_values_name','products_options_values','products_options_values_id='.$h['attr_value_id'].' and language_id='.$_SESSION['languages_id'],'limit 1');
							$default_active='';
							$default_selected='';
							$default_active_into = '&#xf134;';
							if ($h['attr_value_id'] == 4262) {
								$related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $attribute_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
								if ($related_id) {
									$custom_style = '';
									$html_custom .= '<div class="custom_wavelength" ' . $custom_style . '><input id="attrib-' . $related_id . '-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
									$option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
									if ($option_word) {
										$html_custom .= getNewWordHtml($option_word);
									}
									$html_custom .= '</div>';
								}
							}

							if($showFlag){
								if($attribute_type==3){ //checkbox
									$attribsCheckboxButton = "attribsCheckboxButton";
									$check = '';
									$attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');

									if ($attribute_value_name) {
										$pid_str= $pid;
										$is_attr = strstr($pid, ':');
										if($is_attr==true){
											$attr_str = explode(':',$is_attr);
											$pid_str = $attr_str[1];
										}
										$input_type='';
										if($check=="active"){
											$str_box = "&#xf133;";
										}else{
											$str_box = "&#xf134;";
											$input_type='disabled="disabled"';
										}
										$html .= '<span class="re_radio" type="checkbox" rel="' . $h['attr_value_id'] . '_' . $h['column_id'] . '"  attr_pro="'.$pid_str.'" attr_products="'.$pid.'"  id="attrib-' . $attribute_id . '-' . $h['attr_value_id'] . '" onclick="change_attribute(this,' . $h['column_id'] . ',' . $attribute_id . ',' . $h['attr_value_id'] . ',\'' . $id . '\',' . $column_id . ',1)"><i class="iconfont icon">'.$str_box.'</i>' . $attribute_value_name . '<input type="hidden"  name="ids[' . $h['attr_id'] . '][' . $h['attr_value_id'] . ']"  value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" '.$input_type.'></span>';
									}
								}else{
									if($attribute_value_name){
										$html .= '<option '.$default_selected.' value="'.$h['attr_value_id'].'_'.$h['column_id'].'" id="'.$h['column_id'].'"  class="'.$id.'">'.$attribute_value_name.'</option>';
									}
								}
							}
						}
						if($attribute_type==3){
							$html .= '</span>';
							$html .= '</div></li>';
						}else{
							$html .='</select></div></li>';
						}
					}
				}
			}
		}
		//
        if(!empty($html)){
            //特殊属性 线轴加价处理
            $spool_data= get_spool_option_data($pid);
            if(!empty($spool_data) && !empty($spool_data['products_values'])){
                $products_values = $spool_data['products_values'];
                $html .= '<li class="spool_price_proSelct_li" style="display: none;">
                    <span class="re_select_name">'.$spool_data['products_options_name'].': </span>
                    <div class="alone_container">
                        <select class="re_select " id="attrib-'.$spool_data['products_options_id'].'" attr_pro="" attr_products="'.$pid.'" 
                        name="ids['.$spool_data['products_options_id'].']" rel="AttrSelect">
                            <option value="'.$products_values['products_options_values_id'].'" id="'.$spool_data['products_options_id'].'" class="">'.$products_values['products_options_values_name'].'
                            </option>
                         </select>
                    </div>
                </li>';
            }
        }
	}

	$data = array('html'=>$html,'all_Attr'=>$allAttr,'attr'=>$attr);
	return $data;
}


/**
 * @param $products_id 产品id
 * @return string   返回长度属性提示语
 */
function get_length_attribute_tips($products_id){
    $products_id = (int)$products_id;
    if(empty($products_id)){
        return '';
    }
    $brand_length_id = fs_get_data_from_db_fields('brand_length_id', 'products_count_length', 'products_id=' . (int)$products_id, 'limit 1');
    $content = fs_get_data_from_db_fields('content', 'table_column_languages', 'unique_id=' . (int)$brand_length_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
    if ($brand_length_id && $content) {
        $marked_words = $content;
    } else {
        if(in_array($products_id,array(30809))){
            if(in_array($_SESSION['languages_code'],array('de','fr','es'))){
                $word = str_replace('0,5','1',FS_PRODUCTS_AOC_LENGTH_ERROR);
                $marked_words = str_replace('1,64','3,28',$word);
            }else{
                $word = str_replace('0.5','1',FS_PRODUCTS_AOC_LENGTH_ERROR);
                $marked_words = str_replace('1.64','3.28',$word);
            }
        }elseif (in_array($products_id,array(30775,30793,30746))){
            $marked_words = FS_PRODUCTS_AOC_LENGTH_ERROR;
        }else{
            $marked_words = FS_PRODUCTS_CABLE_LENGTH2;
        }
    }
    $tips = getNewWordHtml($marked_words);
    return $tips;
}

/**
 * @param $products_id 产品id
 * @return string   返回长度属性提示语
 */
function get_quote_length_attribute_tips($products_id){
	$products_id = (int)$products_id;
	if(empty($products_id)){
		return '';
	}
	$brand_length_id = fs_get_data_from_db_fields('brand_length_id', 'products_count_length', 'products_id=' . (int)$products_id, 'limit 1');
	$content = fs_get_data_from_db_fields('content', 'table_column_languages', 'unique_id=' . (int)$brand_length_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
	if ($brand_length_id && $content) {
		$marked_words = $content;
	} else {
		if(in_array($products_id,array(30809))){
			if(in_array($_SESSION['languages_code'],array('de','fr','es'))){
				$word = str_replace('0,5','1',FS_PRODUCTS_AOC_LENGTH_ERROR);
				$marked_words = str_replace('1,64','3,28',$word);
			}else{
				$word = str_replace('0.5','1',FS_PRODUCTS_AOC_LENGTH_ERROR);
				$marked_words = str_replace('1.64','3.28',$word);
			}
		}elseif (in_array($products_id,array(30775,30793,30746))){
			$marked_words = FS_PRODUCTS_AOC_LENGTH_ERROR;
		}else{
			$marked_words = FS_PRODUCTS_CABLE_LENGTH2;
		}
	}
	$tips = getNewWordHtmlQuote($marked_words);
	return $tips;
}


function fs_attribute_column_option_value_price($products_id,$a,$option,$value,$length=1){
    global $db;
    $products_option = $a[$products_id][$option];
	$price = 0;
    if(is_array($products_option) && !empty($products_option)){
        foreach($products_option as $k=>$v){
            if($value == $k){
                $column = $v;
                $result = $db->Execute("select column_id,price_prefix,attr_price,per_price from attribute_custom_column where column_id = '".$column."' limit 1");
                if($result->fields['column_id']){
					//获取属性项加价计算方式
					$price_type = 0;
					if((int)$option){
						$price_type = fs_get_data_from_db_fields('price_type', 'products_options', 'language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$option,'limit 1');
					}
					if($length<1) $length=1;

					//如果改层级属性已经设置了每米加价则按照：底价+(n-1)/n * 每米加价  计算
					$attr_price = $result->fields['attr_price'];
					$per_price = $result->fields['per_price'];
					if($price_type==2){
						//底价+n*每米加价
						$price = $attr_price + $length*$per_price;
					}else{
						//底价+(n-1)*每米加价
						$price = $attr_price + ($length-1)*$per_price;
					}

                    return array($price,$result->fields['price_prefix']);
                }
                break;
            }
        }
    }
    return false;
}

//传递的栏目放置在属性里面。
//和购物车里面不一样，放在session最外面和总价格并排
function fs_attribute_column_option_value_price_other($column, $length=1){
    global $db;
    $return = false;
	$price = 0;
    if($column){
        $result = $db->Execute("select column_id,price_prefix,attr_price,per_price,attr_id from attribute_custom_column where column_id = '".$column."' limit 1");
        if($result->fields['column_id']){
			//获取属性项加价计算方式
			$price_type = 0;
			$option = $result->fields['attr_id'];
			if((int)$option){
				$price_type = fs_get_data_from_db_fields('price_type', 'products_options', 'language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$option,'limit 1');
			}
			if($length<1) $length=1;
			//如果改层级属性已经设置了每米加价则按照：底价+(n-1)/n * 每米加价  计算
			$attr_price = $result->fields['attr_price'];
			$per_price = $result->fields['per_price'];
			if($price_type==2){
				//底价+n*每米加价
				$price = $attr_price + $length*$per_price;
			}else{
				//底价+(n-1)*每米加价
				$price = $attr_price + ($length-1)*$per_price;
			}

            return array($price,$result->fields['price_prefix']);
        }
    }

    return $return;
}

/**
 * 获取 父级栏目为$column_id的 树状结构的最左侧。
 * @param int $column_id：栏目id
 * @return array
 */
function zen_get_all_sub_column($column_id){
    global $db;
    $columns = $db->getAll("select column_id from attribute_custom_column where parent_id=".$column_id." and language_id=1 order by sort limit 1");
    $all_column = array();
	if(sizeof($columns)){
		foreach($columns as $val){
			$all_column[]=$val['column_id'];
			$all_column = array_merge($all_column,zen_get_all_sub_column($val['column_id']));
		}
	}
    return $all_column;
}


function zen_get_all_sub_column_and_options_id($column_id,&$all_column){
    global $db;
    $columns = $db->getAll("select column_id,attr_id from attribute_custom_column where parent_id=".$column_id." and language_id=1 order by sort limit 1");
    foreach($columns as $val){
        $all_column[$val['attr_id']] = (int)$column_id;
        $all_column += zen_get_all_sub_column_and_options_id($val['column_id'],$all_column);
    }
    //var_dump($columns);die;
    return $all_column;
}

//判断当前产品是否有层级属性，返回对应的column_id
function zen_get_products_column_id($products_id){
    global $db;
    $column_id = 0;
    if((int)$products_id){
        $result = $db->getAll("select column_id from attribute_custom_column where column_name = '" . (int)$products_id . "' and parent_id = 0 limit 1");
        if($result[0]['column_id']){
            $column_id = $result[0]['column_id'];
        }
    }
    return $column_id;
}

/*
 * @param2 array $attr,保存层级属性的多维数组,$attr['option_id'] = array('option_value_id'=>column_id)
*/
function get_value_right_column($column_id,&$attr){
    global $db;
    if((int)$column_id){
        //查找第一级属性项ID
        $option_data = $db->getAll("select distinct attr_id from attribute_custom_column where parent_id=".(int)$column_id);
        if(sizeof($option_data)){
            foreach($option_data as $oval){
                //根据父级column_id和属性项option_id查找出当前层级属性项 拥有的所有属性值
                $query = $db->Execute("select column_id,attr_value_id,attr_id from attribute_custom_column where parent_id=".(int)$column_id." and attr_id=".$oval['attr_id']." order by sort");
                $data = $now_attr = array();
                $now_attr = $attr[$oval['attr_id']];
                while(!$query->EOF){
                    $data[$query->fields['attr_value_id']] = $query->fields['column_id'];
                    $query->MoveNext();
                }
                if(sizeof($now_attr)){
                    foreach($now_attr as $vid=>$cid){
                        //先获取所有的option_value_id
                        $value_key = array_keys($data);
                        if(in_array($vid,$value_key)){
                            //如果参数$attr中同一个属性项的属性值在当前的属性值数组中，就将数据库中查找的最新的column_id赋值给他
                            $attr[$oval['attr_id']][$vid] = $data[$vid];
                            //并用当前的column_id作为新的继续找他下面的层级属性
                            $new_column_id = $data[$vid];
                        }else{
                            //若是不在里面，默认用第一个column_id继续寻找子层级属性
                            $new_column_id = reset($data);
                        }
                        //用当前新的column_id递归查找下面的层级属性
                        get_value_right_column($new_column_id,$attr);
                    }
                }
            }
        }
    }
    return $attr;
}

/*
 * 获取产品的层级关系数据
 *
 * @param array $attr, eg: $attr['option_id'] = $option_value_id
 *
 * return array $columnID, eg: $columnID['option_id'] = array('option_value_id'=>'column_id');
 */
function get_products_columnID($attr){
    $columnID = array();
    if(sizeof($attr)){
        foreach($attr as $option=>$value){
            if($option!='length'){
				if(is_array($value)){
					//多选类型的属性项
					foreach($value as $kk=>$vv){
						$columnID[(int)$option][$vv] = 0;
					}
				}else{
               		$columnID[(int)$option][$value] = 0;
				}
            }
        }
    }
    return $columnID;
}

function zen_get_step_attr($column_array,$pid){
    global $db;
    $new_column_array = array();
    $no_column = '';
    if($column_array){
        $step_rst = $db->getAll("select step_sort,attr_id from products_custom_step where products_id=".(int)$pid." order by step_sort");
        foreach ($column_array as $option_id => $column){
            $option_type = fs_get_data_from_db_fields('products_options_type','products_options','products_options_id='.$option_id.' and language_id='.$_SESSION['languages_id'],'');
            if($option_type ==3){
                $new_column_array['is_checkbox'][$option_id] = $column;
                $no_column = $option_id;
            }
            foreach ($step_rst as $value){
                $is_true = strpos($value['attr_id'],',');
                if($is_true){
                    $attr_arr  = explode(',',$value['attr_id']);
                }else{
                    $attr_arr = array($value['attr_id']);
                }
                if(in_array($option_id,$attr_arr)){
                    $new_column_array[$value['step_sort']][$option_id] = $column;
                    if(!empty($no_column)){
                        unset($new_column_array[$value['step_sort']][$no_column]);
                    }
                }
            }
        }
    }
    ksort($new_column_array,SORT_LOCALE_STRING);
    return $new_column_array;
}


/**
 * 判断产品在products_attributes表中是否有展示的属性数据
 * 查找products_options表中products_options_status=1且products_attributes中attributes_status=1的属性
 * @param $products_id
 * @return int
 */
function zen_get_products_attributes_total($products_id){
	global $db;
	$total = 0;
	if((int)$products_id){
		$sql = "SELECT count(*) total FROM `products_attributes` a left join products_options o on (a.options_id=o.products_options_id) where a.products_id=".(int)$products_id." and a.attributes_status=1 and o.products_options_status=1";
		$result = $db->getAll($sql);
		if($result[0]['total']){
			$total = $result[0]['total'];
		}
	}
	return $total;
}

//判断产品在products_length是否存在长度属性
function zen_get_products_length_total($products_id){
	global $db;
	$total = 0;
	if((int)$products_id){
		$result = $db->getAll("SELECT count(*) total FROM `products_length` where product_id=".(int)$products_id." and custom=0");
		if($result[0]['total']){
			$total = $result[0]['total'];
		}
	}
	return $total;
}

/**
 * 判断是否包含定制产品
 * @param $products_arr     array|int     id或id数组
 * @return bool
 */
function zen_has_custom_product($products_arr){
    global $db;
    if (!is_array($products_arr)) {
        $products_arr = [$products_arr];
    }
    if (empty($products_arr)) {
        return false;
    }
    $products_id_str = implode(',',$products_arr);
    $result = $db->getAll("SELECT count(*) total FROM `products_length` where product_id in ({$products_id_str}) and custom=0");
    if($result[0]['total'] && $result[0]['total'] != 0){
        return true;
    }
    $sql = "SELECT count(*) total FROM `products_attributes` a left join products_options o on (a.options_id=o.products_options_id) where a.products_id in ({$products_id_str}) and a.attributes_status=1 and o.products_options_status=1";
    $result = $db->getAll($sql);
    if($result[0]['total'] && $result[0]['total'] != 0){
        return true;
    }
    return false;
}

/**
 * ery  add 2019.7.10  购物车页面已删除产品恢复加入购物车时
 * 针对购物车属性contents中定制产品属性数组 处理成add_cart()方法 接收的传参数组格式
 * @param array $products	$_SESSION['cart']->contents 元素
 * @return array $real_ids
 */
function get_real_ids_by_attribute($products){
	$real_ids = [];
	if(is_array($products['attributes']) && sizeof($products['attributes'])){
		foreach($products['attributes'] as $option=>$value){
			if($value==0){
			    //客户自定义的有文本和附件
                if($products['attributes_file'][$option]){//文件
                    $real_ids['upload_prefix_'.$option] = array(
                        'products_options_value_text' => $products['attributes_values'][$option],
                        'upload_file' =>  $products['attributes_file'][$option],
                    );
                }else{
                    //该类属性项是文本类型 客户自定义 填写的内容
                    $real_ids['text_prefix_'.$option] = $products['attributes_values'][$option];
                }
			}else if(strstr($option, '_chk')){
				//多选类型属性项
				$real_ids[(int)$option][$value] = $value;
			}else{
				$real_ids[$option] = $value;
			}
		}
	}
	return $real_ids;
}

/**
 * ery add  2019.7.10
 * 购物车页面 remove、save for later、add to cart 等相关功能 更新购物车产品后 总价格等相关信息更新处理
 * @param $products
 * @return $info
 */
function get_shopping_cart_total_info($products){
	global $currencies;
	$info = [];
	//计算删除之后的产品不是quote询价产品的 总价 及折算后的总价
	$not_quote_origin_price = $not_quote_after_discount_price =0;
	//计算优惠后产品总价格 以及 没有优惠的产品原始总价格
	$current_product_total = $current_origin_product_total = $subtotal =  $total_new = 0;
	$cart_items = 0;
	$html = '';
	//不含询价产品 的总的折扣价格
	$off = 0;
	if(!empty($products)){
		require_once DIR_WS_CLASSES.'order.php';
		$order = new order();
		foreach($products as $kk=>$product){
			if($order->fs_is_bulk_fiber(array($product['id']))) $mark=1;//有重货

            //计算优惠后产品总价格
            $current_product_total += $product['final_price'] * $product['quantity'];
            //计算没有优惠的产品原始总价格
            $current_origin_product_total += $product['products_price'] * $product['quantity'];

			//不含询价产品的总价以及折扣总格
			if($product['reoder_type'] !='quotation'){
				$not_quote_origin_price += $product['products_price'] * $product['quantity'];
				$not_quote_after_discount_price += $product['final_price'] * $product['quantity'];
			}
		}
		//获取对应站点税收
		$vat_info = get_current_vat_by_languages_code();
		$de_vat = $vat_info[2];
		$vat_price = $currencies->fs_format($current_product_total * $de_vat);	//税收的价格 fs_format处理的价格不带货币符号
		$subtotal = $currencies->fs_format($current_product_total);		//不加税收的纯产品总价格
		$total_new = $currencies->fs_format($current_product_total * (1 + $de_vat));	//加税收的产品总价格
		//购物车产品总数量  获取购物车勾选的产品数量
		$cart_items = $_SESSION['cart']->count_contents(true);

		if (($_SESSION['member_level'] > 1) && ($not_quote_origin_price > 0)) {
			$off = $currencies->fs_format($not_quote_origin_price - $not_quote_after_discount_price);
		}
		//刷新头部购物车信息
		//外部图标部分
		$qty = "";
		if ($cart_items > 1) {
			$qty = $cart_items . "  " . F_BODY_HEADER_ITEM_TWO;
		} else if($cart_items==1){
			$qty = $cart_items . "  " . F_BODY_HEADER_ITEM;
		}
		// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动顶部购物车结构
		require_once DIR_WS_CLASSES . 'shopping_cart_help.php';
		$shopping_cart_help = new shopping_cart_help();
		$html = $shopping_cart_help->show_cart_products_block($_SESSION['cart']->count_contents()); //右上角需要获取购物车所有产品数量

		unset($_SESSION['unset_id']);

		if ($current_product_total > 0) {
			if ($mark != 1) {
				$tax = $_SESSION['cart']->get_free_freight_information($current_product_total);
			} else {
				$tax = 2;
			}
		} else {
			$tax = 1;
			if ($_SESSION['languages_code'] == 'au') {
				$qty = "0 " . F_BODY_HEADER_ITEM;
			}
		}
	}else{
		$html='<a class="cart_info" href="'.zen_href_link('shopping_cart').'">
            <span class="icon iconfont cart">&#xf142;</span>
            <span class="cart_span">'.FS_CART.'</span>
        </a>';
	}
	$info = array(
		'final_price_total' => $current_product_total,	//所有产品最终美元总价格
		'origin_price_total' => $current_origin_product_total,	//所有产品优惠前的产品美元总价格
		'final_price_total_currency' => $subtotal,	//对应币种换算后的所有产品最终总价格不含税收
		'total_price_currency' => $total_new,	//对应币种换算后的所有产品最终总价格含税收
		'vat_price' => $vat_price,	//对应币种转换后的税收价格
		'header_cart_html' => $html, 	//头部购物HTML
		'cart_items' => $cart_items,	//产品总数量
		'qty' => $qty,
		'off' => $off,		//不含询价产品的优惠总价格 对应币种转换后的价格
		'tax' => $tax,
	);
	return $info;
}
function match_product_initialization_information($productsId,$allAttr='',$Attr,$length='',$qty=1){
    global $db;
    $attrArr = trim($allAttr,',');
    $Attr = trim($Attr,',');
    $productsId = (int)$productsId;
    if(empty($Attr) && empty($length) || empty($productsId)){
        return false;
    }
    $attribute = [];
    $delivery_attr_arr =  [];
    $isBrand = $brandFlag  = false;
    $fiberAttr = ''; //$fiberAttr 存放客户选择的芯数属性值,方便计算线轴加价
    //当前定制产品选中的属性项数组，属性值数组，层级属性数组
    $columnID = [];
    if($attrArr){
        $attrArr = explode(',',$attrArr);
        if(sizeof($attrArr)){
            foreach($attrArr as $v){
                $vArr = explode(':',$v);
                $option = $vArr[0];
                if(strpos($vArr[1],'_')){
                    $column = explode('_',$vArr[1]);
                    $attribute[$option]=$column[0];
                    $delivery_attr_arr[] = $column[0];
                    $columnID[$option][$column[0]] = $column[1];
                    if($option ==21)   $fiberAttr = $column[0];// 带有芯数产品(通过芯数,和客户自定义长度计算线轴加价)
                }else{
                    $columnID[$option][$vArr[1]] = 0;
                    $attribute[$option] = $vArr[1];
                    $delivery_attr_arr[] = $vArr[1];
                    if($option==2){$isBrand = true;}
                    if($option==2 && $vArr[1]==6452){
                        $brandFlag = true;
                    }
                    if($option ==21)   $fiberAttr = $vArr[1];
                }

            }
        }
    }
    if($Attr){

        if (strpos($Attr, ',')) {
            $Attr = explode(',', $Attr);
        }
        if (is_array($Attr)) {
            foreach ($Attr as $k => $v) {
                if (strpos($v, '_')) {
                    $Attr[$k] = substr($v, 0, strpos($v, '_'));
                }
            }
        } elseif (strpos($Attr, '_')) {
            $Attr = substr($Attr, 0, strpos($Attr, '_'));
        }
    }

    //定制产品匹配标准产品
    $class = new FsCustomRelate($productsId, $Attr, $length);
    $excellentMatch = $class->handle();
    //返回当前产品取整或不取整后的美元价格  //出入属性值数组  查询组合产品有属性产品的价格
    $combination_arr = $delivery_attr_arr;
    $combination_arr['is_composite'] = false;
    $combination_arr['discount_type'] = true;
    $product_price = zen_get_products_final_price((int)$productsId,'',$combination_arr);
    //判断是否为组合产品 是的话 则不用查属性值了
    //根据传过来的长度属性获取属性价格
    $priceArr = array();
    if ($length) {
		//计算长度属性价格
        $priceArr = get_length_range_price($productsId,$length,$fiberAttr);
        $length_s = str_replace("k", "", $length);
        $length_s = str_replace("m", "", $length_s);
        $attribute['length'] = $length_s;
        $delivery_attr_arr['length'] = $length_s;
    } else {
        $length_s = 1;
    }
    //获取选中属性的价格
    //$attrPrice = 0;
    $attrPrice = get_products_all_attribute_price_new($productsId, $columnID, $length_s);
    $length_price = $priceArr['length_price'] + $attrPrice;
    $custom_total_price = $total_price = $product_price + get_gsp_tax_price($_SESSION['countries_iso_code'],zen_get_products_base_price_other($length_price));
    $is_clearance = $match_status = 0;
    if($excellentMatch[0]){
        $is_clearance = get_current_pid_if_is_clearance($excellentMatch[0]);
        $is_clearance = $is_clearance ? 1 : 0;
        $match_status = get_product_status($excellentMatch[0]);
        //匹配到标准产品 且标准产品开启就展示标准产品的价格
        if($match_status){
            $total_price = zen_get_products_final_price($excellentMatch[0]);
        }
    }

    //产品属性交期
    $attr_str = "";
    if(sizeof($delivery_attr_arr) && (!$excellentMatch[0] || ($excellentMatch && !$match_status))){ //没有匹配到标准产品才会把选择的属性添加到dom(传属性值为了计算交期)
        //var_dump(1);
        $attr_str = implode(',',$delivery_attr_arr);
    }

    //获取交期 dylan 2019.12.10
    //$processing_days = 0;
    //if($delivery_attr_arr){
        //$processing_days = get_custom_processing_days($productsId,$delivery_attr_arr);
    //}
    //$processing_days = get_custom_products_attr_days($productsId,$delivery_attr_arr,$length,$qty);
    $total_price = get_one_products_currency_price($total_price, $_SESSION['currency']);
    return array(
        'match_products_id'=>$excellentMatch,
        'total_price'=>$total_price,
        'match_status'=>$match_status ? $match_status : 0,
        'delivery_attr_arr'=>$delivery_attr_arr,
        'attribute'=>$attribute,
        //'processing_days'=>$processing_days,
        'attr_str'=>$attr_str,
        'isBrand'=>$isBrand,
        'brandFlag'=>$brandFlag,
        'Attr'=>$Attr,
        'attrPrice'=>$attrPrice,
        'priceArr'=>$priceArr,
        'product_price'=>$product_price,
        'combination_arr'=>$combination_arr,
        'length_s'=>$length_s,
        'length_price' => $length_price,
        'is_clearance' => $is_clearance,
        'custom_total_price' => $custom_total_price
        );
}
function gerenal_customized_products($products_id,$options_name,$options_menu,$options_comment,$cPath_array,$html_select_type='',$options_data=[]){
    $html = '';
    if($products_id){
        $html .= '<div class="detail_proSelct_team">'.$html_select_type.'<ul><div id="fs_non_hier_attribute">';
        for ($i = 0; $i < sizeof($options_name); $i++) {
            $tit = '';
            $sele = '';
            $li_class = $li_display = '';
            if(sizeof($options_name) ==1){
                $tit = ' new_select_titz01';
                $sele = ' new_selectz01';
            }
            if($options_data[$i] == 341){ //线轴加价属性  根据客户选择的米数 和属性判断是否展示
                $li_class = 'spool_price_proSelct_li';
                $li_display = 'style="display:none"';
            }
            if ($act = fiber_optic_network($options_name[$i])) {
                $html .= '<!-- products attributes -->';
                $html .= '<li class="detail_proSelct_li '.$li_class.'" '.$li_display.'><div id="fiber_'.$act.'" class="product_03_09 product_03_12 fiber_optic_network custom_attribute">';
            } else {
                $html .= '<!-- products attributes -->';
                $html .= '<li class="detail_proSelct_li"><div class="product_03_09 product_03_12 custom_attribute">';
            }
            $html .= '<span class="product_03_02 product_03_15 '.$tit.'">'.$options_name[$i].'</span>';
            $html .= '<span class="product_03_08 detail_proSelct_checked '.$sele.'"> '.$options_menu[$i];


            if ('34107' == $products_id) {
                $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT1);
            }
            if ('28977' == $products_id && "<label class=\"attribsSelect\" for=\"attrib-185\">Package</label>" == $options_name[$i]) {
                $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT2);
            }
            if ('32623' == $products_id && "<label class=\"attribsSelect\" for=\"attrib-240\">Data Port</label>" == $options_name[$i]) {
                $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT3);
            }
            if ('32827' == $products_id && "<label class=\"attribsSelect\" for=\"attrib-240\">Data Port</label>" == $options_name[$i]) {
                $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT4);
            }
            if (in_array($products_id, array(35434, 35535, 35536, 35537, 35538, 35539, 35540, 35541, 35542, 35543)) && "MTP Polarity" == trim(strip_tags($options_name[$i]))) {
                $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT5);
            }

            if ($options_comment[$i]){
                if ($cPath_array[0] == 1){
                    $html .= '<div class="track_orders_wenhao">';
                }else{
                   if (isset($options_comment_p[$i]) && !empty($options_comment_p[$i])){
                        $html .= '<div class="question_text" style="margin-top: -4px;">';
                   } else {
                        if ($cPath_array[2] == 1155) {
                            $html .=  '<div class="track_orders_wenhao">';
                        } else {
                            $html .=  ' <div class="question_text">';
                        }
                   }
                }
                $html .= '<div class="question_bg_icon iconfont icon">&#xf228;</div>';
                $html .= '<div class="question_text_01 leftjt"><div class="arrow"></div>';
                $html .= '<div class="popover-content">'.$options_comment[$i].'</div>';
                $html .= '</div></div>';
            }
            $html .= '</span><div class="ccc"></div></div></li>';
        }

        $html .= '</div></ul></div>';
    }
    $data = array(
        'html' => $html,
    );
    return $data;
}


function get_compatibility_placeholder($productsId,$isBrand=false,$brandFlag=false){
    $brandHtml = FS_WRITE_OTHER_DEVICES;
    $brandClass = '';
    if($brandFlag && $isBrand){
        if(in_array($productsId,array(69905,69906,49575,69907,69908,49577,30746,30775,68404,50192,30752))){
            $brandHtml = FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01;
            $brandClass = 'custom_input';
        }else if(in_array($productsId,array(69909,30793))){
            $brandHtml = FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02;
            $brandClass = 'custom_input';
        }else if(in_array($productsId,array(69922))){
            $brandHtml = FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03;
            $brandClass = 'custom_input';
        }else if(in_array($productsId,array(49617,70537))){
            $brandHtml = FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04;
            $brandClass = 'custom_input';
        }else if(in_array($productsId,array(49579))){
            $brandHtml = FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05;
            $brandClass = 'custom_input';
        }
    }
    $data = array(
        'brandHtml'=>$brandHtml,
        'brandClass'=>$brandClass,
    );
    return $data;
}

//定制产品部分属性匹配毛料产品ID获取库存及交期
function get_relate_material_data($productsId, $length = 0, $qty = 1, $attribute = []){
    $materialService = new \App\Services\Materials\MaterialProductService();
    $length = str_replace("m", "", $length);
    if(strpos($length,"k")){
        $length = str_replace("k", "", $length);
        $length = (double)$length * 1000;
    }
    $all_length = $qty > 1 ? (double)$length * $qty : (double)$length;
    if(sizeof($attribute)){
        return $materialService->getCustomRelatedMaterial(
            array(
                'products_id' => $productsId,
                'length' => $all_length,
                'attribute' => $attribute
            )
        );
    }else{
        //直接查询毛料ID库存及交期
        return $materialService->getMaterialProductTotalStock($productsId, $all_length);
    }
}


/**
 * 计算定制产品选择的所有属性项价格
 * @param $products_id
 * @param array $attributes 多维数组 $attributes[options_id][values_id]=column_id 没有层级属性column_id=0
 * @param int $length_s
 * @return float|int|mixed
 */
function get_products_all_attribute_price_new($products_id, $attributes=[], $length_s=1){
    global $db;
    $attributes_price = 0;
    //对属性项和属性值数据过滤必须为整型
    $options_id = $values_id = $check_column = [];
    if(!empty($attributes)){
        reset($attributes);
        while (list($option, $value) = each($attributes)) {
            if($option!=341){
                $options_id[] = (int)$option;
                foreach($value as $vID=>$cID){
                    $values_id[] = (int)$vID;
                    if((int)$cID){
                        $check_column[] = (int)$cID;
                    }
                }
            }
        }
    }
    if((int)$products_id && !empty($options_id) && !empty($values_id)){
        //查找属性项的加价方式
        $options_price_type = [];
        $price_query = $db->Execute("SELECT products_options_id,price_type FROM products_options WHERE products_options_id IN (".join(',',$options_id).") AND language_id=".$_SESSION['languages_id']);
        while(!$price_query->EOF){
            $options_price_type[$price_query->fields['products_options_id']] = $price_query->fields['price_type'];
            $price_query->MoveNext();
        }
        //查找层级属性价格数据
        $column_price = [];
        if(!empty($check_column)){
            $column_query = $db->Execute("SELECT column_id,price_prefix,attr_price,per_price FROM attribute_custom_column WHERE column_id IN (".join(',',$check_column).")");
            while(!$column_query->EOF){
                $column_price[$column_query->fields['column_id']] = array(
                    'price_prefix' => $column_query->fields['price_prefix'],    //加价方式+或-
                    'attr_price' => $column_query->fields['attr_price'],        //底价
                    'per_price' => $column_query->fields['per_price'],          //每M加价
                );
                $column_query->MoveNext();
            }
        }
        //查找当前产品选择属性价格数据
        $attribute_price_sql = "select price_prefix,products_attributes_id,attributes_discounted,options_values_price,options_id,options_values_id,attributes_price_words_free,attributes_price_letters_free,attributes_price_words,attributes_price_letters
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                    where products_id = '" . (int)$products_id . "'
                                    and options_id IN (".join(',',$options_id).") 
                                    and options_values_id IN (".join(',',$values_id).") ";
        $attribute_price_query = $db->Execute($attribute_price_sql);
        while(!$attribute_price_query->EOF){
            $now_options = $attribute_price_query->fields['options_id'];
            $now_values = $attribute_price_query->fields['options_values_id'];
            $options_values_price = $attribute_price_query->fields['options_values_price'];
            //此处是为了排除不同属性项下有相同属性值，一条SQL会查出多与数据 只计算对应属性项下的对应属性值的价格
            $option_arr = $attributes[$now_options];
            $value_key = array_keys($option_arr);
            if(in_array($now_values, $value_key)){
                $new_attributes_price = get_outer_jacket_options_values_price($now_options,$options_values_price,$length_s,$options_price_type[$now_options]);
                //存在层级属性优先计算层级属性价格
                if($now_column_id = $attributes[$now_options][$now_values]){
                    //如果改层级属性已经设置了每米加价则按照：底价+(n-1)/n * 每米加价  计算
                    $attr_price = $column_price[$now_column_id]['attr_price'];
                    $per_price = $column_price[$now_column_id]['per_price'];
                    if($options_price_type[$now_options]==2){
                        //底价+n*每米加价
                        $new_attributes_price = $column_price[$now_column_id]['attr_price'] + $length_s*$per_price;
                    }else{
                        //底价+(n-1)*每米加价
                        $new_attributes_price = $attr_price + ($length_s-1)*$per_price;
                    }
                    if ($column_price[$now_column_id]['price_prefix'] == '+') {
                        $attributes_price += ($new_attributes_price);
                    } else {
                        $attributes_price -= ($new_attributes_price);
                    }
                }else{
                    if ($attribute_price_query->fields['price_prefix'] == '-'){
                        $attributes_price -= ($new_attributes_price);
                    }else{
                        $attributes_price += ($new_attributes_price);
                    }
                }
            }
            $attribute_price_query->MoveNext();
        }
    }
    return $attributes_price;
}

/**
 * 计算定制产品选择的所有属性加重
 * @param $products_id
 * @param array $attributes 多维数组 $attributes[options_id][values_id]=column_id 没有层级属性column_id=0
 * @return int
 */
function get_products_all_attribute_weight_new($products_id, $attributes=[]){
    global $db;
    $attribute_weight = 0;
    //对属性项和属性值数据过滤必须为整型
    $options_id = $values_id = [];
    if(!empty($attributes)){
        reset($attributes);
        while (list($option, $value) = each($attributes)) {
                $options_id[] = (int)$option;
                foreach($value as $vID=>$cID){
                    $values_id[] = (int)$vID;
                }
        }
    }
    if((int)$products_id && !empty($options_id) && !empty($values_id)){
        $attribute_weight_sql = "select options_id,options_values_id,products_attributes_weight, products_attributes_weight_prefix
										from " . TABLE_PRODUCTS_ATTRIBUTES . "
										where products_id = '" . (int)$products_id . "'
										and options_id in (".join(',',$options_id).") 
										and options_values_id in (".join(',',$values_id).") ";
        $attribute_weight_query = $db->Execute($attribute_weight_sql);
        while(!$attribute_weight_query->EOF){
            $now_options = $attribute_weight_query->fields['options_id'];
            $now_values = $attribute_weight_query->fields['options_values_id'];
            //此处是为了排除不同属性项下有相同属性值，一条SQL会查出多与数据 只计算对应属性项下的对应属性值的重量
            $option_arr = $attributes[$now_options];
            $value_key = array_keys($option_arr);
            if(in_array($now_values, $value_key)){
                if ($attribute_weight_query->fields['products_attributes_weight_prefix'] == '-') {
                    $attribute_weight -= $attribute_weight_query->fields['products_attributes_weight'];
                } else {
                    $attribute_weight += $attribute_weight_query->fields['products_attributes_weight'];
                }
            }
            $attribute_weight_query->MoveNext();
        }
    }
    return $attribute_weight;
}