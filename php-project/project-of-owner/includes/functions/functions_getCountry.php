<?php
//获取国家信息
function get_countries(){
	global $db;
	$sql = "select * from countries";
	$countries = $db->getAll($sql);
	$array = array();
	$one_countries = array('US','CA','AU','GB','NL','SG','IT','IN','FR','BR','DE','ES');
	if($countries){
		foreach($one_countries as $l){
			foreach($countries as $key=>$v){
				if($l == $v['countries_iso_code_2']){
					$array[] = $v;
					//unset($countries[$key]);
				}
			}

		}
	}
	$countries = array_merge($array,$countries);
	return $countries;
}
function get_countries_name($id,$is_en = false){
	global $db;
	switch($_SESSION['languages_id']){
		case 2:
			$select_countries ="es_countries_name";
			break;

		case 3:
			$select_countries ="fr_countries_name";
			break;

		case 4:
			$select_countries ="ru_countries_name";
			break;
		case 5:
			$select_countries ="de_countries_name";
			break;
		case 8:
			$select_countries ="jp_countries_name";
			break;
		case 14:
			$select_countries ="it_countries_name";
			break;
		default :
			$select_countries ="countries_name";
	}
	if($is_en){
		$select_countries ="countries_name";
	}
	$res = $db->execute("select ".$select_countries." from countries where countries_id = '$id'");
	return $res->fields[$select_countries];
}

function get_en_countries_name($id){
	global $db;
	$res = $db->execute("select countries_name from countries where countries_id = '$id'");
	return $res->fields['countries_name'];
}

function get_countries_code($name){
	global $db;
	$res = $db->execute("select countries_iso_code_2 from countries where countries_name = \"$name\"");
	return $res->fields['countries_iso_code_2'];
}

function fs_get_country_id_of_code($code){
	global $db;
	$res = $db->execute("select countries_id from countries where countries_iso_code_2 = '$code'");
	return $res->fields['countries_id'];
}
function get_country_id_by_name($countries_name){
	global $db;
	$res = $db->execute("select countries_id from countries where countries_name = '$countries_name'");
	return $res->fields['countries_id'];
}

function fs_get_country_code_of_id($countries_id){
	global $db;
	$res = $db->execute("select countries_iso_code_2 from countries where countries_id = '$countries_id'");
	return $res->fields['countries_iso_code_2'];
}

function get_countries_iso_code_name($countries_code_2){
	global $db;
	if($countries_code_2){
		$select_countries_name = zen_get_countries_fields();

		$res = $db->execute("select $select_countries_name from  countries where countries_iso_code_2 = '".trim($countries_code_2)."' limit 1");
		$countries_name = $res->fields["$select_countries_name"];
		return $countries_name;
	}
}
//排序
function get_sort($shipping,$countries='US'){
	$info = array();
	$shipping = get_shippings($shipping);
	$count = count($shipping);
	foreach($shipping as $key=>$v){

		for($i=$count-1;$i>$key;$i--){

			if($shipping[$key]['methods'][0]['cost'] > $shipping[$i]['methods'][0]['cost']){

				$temp = $shipping[$i];
				$shipping[$i] = $shipping[$key];
				$shipping[$key] = $temp;
			}
		}

	}
	$shipping_array = array();
	$cus_array = array();
	foreach($shipping as $key=>$v){
		if($v['id'] != 'customzones'){
			if($v['id'] == 'fedexzones'){
				if(in_array($countries,array('US','CA','MX'))){
					$shipping_array[] = $v;
					$fedex_array = array();
				}else{
					$fedex_array = $v;
				}

			}else{
				$shipping_array[] = $v;
			}
		}else{
			$cus_array = $v;
		}
	}
	$shipping_array[] = $cus_array;
	array_unshift($shipping_array,$fedex_array);
	return $shipping_array;
}
function get_shippings($shipping){
	$act = array();
	if($shipping){
		foreach($shipping as $key=>$v){
			if(!isset($shipping[$key]['methods'][0]['cost'])){
				unset($shipping[$key]);
			}else{
				$act[] = $shipping[$key];
			}
		}

	}
	return $act;

}
//根据国家获取天数
function get_days($countries_code_2,$pament_method){
	global $db;
	if($pament_method == 'airmailzones'){
		$countries_arr1 = array('US');
		$countries_arr2 = array('RU','BR');
		$countries_arr3 = array('AU','ES');
		$countries_arr4 = array('GB');
		$countries_arr5 = array('CA','PL');
		$countries_arr6 = array('TR');
		$countries_arr7 = array('IL','IT','新西兰','DE');
		$countries_arr8 = array('FR','JP','KR');
		if(in_array($countries_code_2,$countries_arr1)){
			$days = '15-26 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr2)){
			$days = '15-50 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr3)){
			$days = '15-45 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr4)){
			$days = '15-29 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr5)){
			$days = '15-34 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr6)){
			$days = '15-27 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr7)){
			$days = '15-34 '.FS_BUSINESS_DAYS;
		}elseif(in_array($countries_code_2,$countries_arr8)){
			$days = '15-45 '.FS_BUSINESS_DAYS;
		}else{
			$days = '15-60 '.FS_BUSINESS_DAYS;
		}
		return $days;
	}elseif($pament_method == 'freezones'){
		return '15-60 '.FS_BUSINESS_DAYS;
	}elseif($pament_method == 'tntezones'){
		$day = upsStandardZonesDay($countries_code_2);
		if($day){
			return $day . FS_BUSINESS_DAYS;
		}else{
			return '1-3 ' . FS_BUSINESS_DAYS;
		}
	}elseif($pament_method == 'seazones'){
		return '15-60 '.FS_BUSINESS_DAYS;
	}elseif($pament_method == 'sfzones'){
		return '1-3 '.FS_BUSINESS_DAYS;
	}elseif($pament_method == 'airliftzones'){
		return '4-7 '.FS_BUSINESS_DAYS;
	}elseif($pament_method == 'fedexgroundzones' || $pament_method == "fedexgroundeastzones"){
		//return '5 '.FS_BUSINESS_DAYS;
		return "";
	}elseif($pament_method == 'fedex2dayzones' || $pament_method == 'fedex2dayeastzones'){
		//return '2 '.FS_BUSINESS_DAYS;
		return "";
	}elseif($pament_method == 'fedexexpresssaverzones'){
		//return '4 '.FS_BUSINESS_DAYS;
		return "";
	}elseif($pament_method == 'dhlauzones'){
		//return '4 '.FS_BUSINESS_DAYS;
		return "";
	}elseif ($pament_method == 'fedexsamedayzones'){
		return "";
	}elseif($pament_method == 'tntauroadexpresszones'){
		//return '4 '.FS_BUSINESS_DAYS;
		return "";
	}elseif($pament_method == 'tntauovernightexpresszones'){
		//return '4 '.FS_BUSINESS_DAYS;
		return "";
	}elseif($pament_method == 'tntauzones'){
		//return '4 '.FS_BUSINESS_DAYS;
		return "";
	}elseif ($pament_method == 'fastwaycourierzones' || $pament_method == 'startrackzones' || $pament_method == 'startrackfzones'){
		return "";
	}elseif($pament_method == 'upssaverzones'){
		$day = upSsaverZonesDay($countries_code_2);
		if($day){
			return $day." ". FS_BUSINESS_DAYS;
		}
	}elseif ($pament_method == 'aupoststandardzones'){
		return '3-10 '.FS_BUSINESS_DAYS;
	}elseif ($pament_method == 'aupostexpresszones'){
		return '2-4 '.FS_BUSINESS_DAYS;
	}elseif (in_array($pament_method, array('dhlauexpressworldwidezones','fedexauexpresszones'))){
		return '1-3 '.FS_BUSINESS_DAYS;
	}elseif ($pament_method == 'fedexaunormalzones'){
		return '4-6 '.FS_BUSINESS_DAYS;
	} elseif (in_array($pament_method,array("fedexpriorityovernightzones","uspsprioritymailzones","forwarderzones","courierzones"))){
		return "";
	}else{
		$zones = new $pament_method;
		$num_zones_days = $zones->num_zones_days;
		$status = false;
		$num_zones_days = $num_zones_days ? $num_zones_days :30;

		if($pament_method == 'dhlzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_DHLZONES_DAYS';
		}elseif($pament_method == 'fedexzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_FEDEXZONES_DAYS';
		}elseif($pament_method == 'fedexiezones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_FEDEXIEZONES_DAYS';
		}elseif($pament_method == 'emszones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_EMSZONES_DAYS';
		}elseif($pament_method == 'upszones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSZONES_DAYS';
		}elseif($pament_method == 'tntzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_TNTZONES_DAYS';
		}elseif($pament_method == 'ffzones'){
			return "";
			$MODULE_SHIPPING = 'MODULE_SHIPPING_FFZONES_DAYS';
		}elseif($pament_method == 'ups2dayszones' || $pament_method == "ups2dayseastzones" || $pament_method == "ups2daysamzones"){
			return "";
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPS2DAYSZONES_DAYS';
		}elseif($pament_method == 'upsovernightzones'||$pament_method == "upsovernighteastzones"){
			return "";
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS';
		}elseif($pament_method == 'fedexovernightzones' || $pament_method == "fedexovernighteastzones"){
			return "";
			$MODULE_SHIPPING = 'MODULE_SHIPPING_FEDEXOVERNIGHTZONES_DAYS';
		}elseif($pament_method == 'upsgroundzones' || $pament_method == "upsgroundeastzones"){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSGROUNDZONES_DAYS';
			return "";
		}elseif($pament_method == 'dhlexpresszones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSGROUNDZONES_DAYS';
			return "";
		}elseif($pament_method == 'dhlexpressdzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSGROUNDZONES_DAYS';
			return "";
		}elseif($pament_method == 'dhlsaturdayzones'){
			return "";
		}elseif($pament_method == 'upsexpresspluszones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSGROUNDZONES_DAYS';
			return "";
		}elseif($pament_method == 'upsexpresszones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSGROUNDZONES_DAYS';
			return "";
		}elseif($pament_method == 'dhlgzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_DHLGZONES_DAYS';
		}elseif($pament_method == 'dhleconomyzones'){
			if ($countries_code_2 == 'FR') {
				return '2-5 '.FS_WORK_DAYS_SERVICE;
			}
			return '1-3 '.FS_BUSINESS_DAYS;
		}elseif($pament_method == 'tntgzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_TNTGZONES_DAYS';
		}elseif($pament_method == 'dhlezones'){
			if($countries_code_2 == 'IM'){
				return '1-3 '.FS_BUSINESS_DAYS;
			}elseif (in_array($countries_code_2, array('GG','JE'))){
				return '2-4 '.FS_BUSINESS_DAYS;
			}
			$MODULE_SHIPPING = 'MODULE_SHIPPING_DHLEZONES_DAYS';
		}elseif($pament_method == 'dhleezones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_DHLEEZONES_DAYS';
		}elseif($pament_method == 'dhlazones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_DHLAZONES_DAYS';
		}elseif($pament_method == 'upsstandardzones'){
//			    if($countries_code_2 == 'IM'){
//			        return '3-5 '.FS_BUSINESS_DAYS;
//                }elseif (in_array($countries_code_2, array('GG','JE'))){
//                    return '4-6 '.FS_BUSINESS_DAYS;
//                }
			if (in_array($countries_code_2, ['IT', 'DK', 'ES', 'LU', 'IE', 'GR', 'EE', 'LV', 'LT', 'HR', 'MC', 'AD', 'JE', 'PT', 'FI', 'SE', 'PL', 'SK', 'HU', 'SI', 'RO', 'NO', 'SM', 'GG', 'IM'])) {
				$day = upsStandardZonesDay($countries_code_2);
				return $day . FS_BUSINESS_DAYS;
			}
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSSTANDARDZONES_DAYS';
		}elseif($pament_method == 'upsazones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSAZONES_DAYS';
		}elseif($pament_method == 'upscmpexpresszones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_UPSCMPEXPRESSZONES_DAYS';
		}elseif($pament_method == 'fedex3dayzones'){
			$MODULE_SHIPPING = 'MODULE_SHIPPING_FEDEX3DAYZONES_DAYS';
		}
		for($i=1;$i<=$num_zones_days;$i++){
			$sql = "select configuration_value from configuration where configuration_key = '".$MODULE_SHIPPING."_ZONES_".$i."' limit 1";

			$result = $db->getAll($sql);

			if($result){

				$configuration_value = $result[0]['configuration_value'];
				if($configuration_value){
					$configuration_value_arr = explode(',',$configuration_value);
					if($configuration_value_arr){
						if(in_array($countries_code_2,$configuration_value_arr)){
							$sql = "select configuration_value from configuration where configuration_key = '".$MODULE_SHIPPING."_".$i."' limit 1";
							$res = $db->getAll($sql);
							$days = $res[0]['configuration_value']." ".FS_BUSINESS_DAYS;
							$status = true;
							if ($countries_code_2 == 'RU') {
								$days = $days.SHIPPING_COURIER_DELIVERY_01;
							}
							break;
						}
					}
				}
			}
		}
		if($status == false){
			$sql = "select * from configuration where configuration_key = '".$MODULE_SHIPPING."' limit 1";
			$res = $db->getAll($sql);

			if(in_array($pament_method,array('dhlgzones','tntgzones'))){
				$days = $res[0]['configuration_value']." ".FS_BUSINESS_DAY;
			}else{
				$days = $res[0]['configuration_value']." ".FS_BUSINESS_DAYS;
			}
		}
		$days = isset($days) ? $days:'3-6 '.FS_BUSINESS_DAYS;
		return $days;
	}

}

function get_shipping_method_html($countries,$shipping,$countries_code_2,$products_id,$port=0){
	global $currencies,$db;
	if($countries_code_2){
		$res = $db->getAll("select countries_name from  countries where countries_iso_code_2 = '".trim($countries_code_2)."' limit 1");
		$countries_name = $res[0]['countries_name'];
	}

	$html = '<table class="p_shipping_01" width="100%" border="0" cellspacing="0" cellpadding="0">';

	$html .= '<tr class="p_shipping_02">';
	$html .= '<td width = "35%">'. FS_COMPANY .'</td>';
	$html .= '<td width = "35%">'. FS_TIME .'</td>';
	$html .= '<td>'.FS_COST.'</td>';
	$html .= '</tr>';
	$i = 0;
	if($shipping){
		foreach($shipping as $key=>$v){
			if(isset($v['methods'][0]['cost'])){$i++;
				$v['methods'][0]['cost'] = sprintf('%.2f',$v['methods'][0]['cost']);
				$html .= '<tr class="p_shipping_03">';
				$html .= '<td>';

				if($v['methods'][0]['id'] == 'fedexzones'){
					$num = '01';
					$title = "fedex";
				}elseif($v['methods'][0]['id'] == 'dhlzones'){
					$num = '02';
					$title = "dhl";
				}elseif($v['methods'][0]['id'] == 'emszones'){
					$num = '04';
					$title = "ems";
				}elseif($v['methods'][0]['id'] == 'tntzones'){
					$num = '06';
					$title = "tnt";
				}elseif($v['methods'][0]['id'] == 'upszones'){
					$num = '05';
					$title = "ups";
				}elseif($v['methods'][0]['id'] == 'airmailzones'){
					$num = '03';
					$title = "airmail";
				}elseif($v['methods'][0]['id'] == 'airliftzones'){
					$num = '08';
					$title = "airlift";
				}elseif($v['methods'][0]['id'] == 'seazones'){
					$num = '07';
					$title = "sea";
				}elseif($v['methods'][0]['id'] == 'customzones'){
					$num = '09';
					$title = "custom";
				}elseif($v['methods'][0]['id'] == 'fedexiezones'){
					$num = '10';
					$title = "fedexie";
				}elseif($v['methods'][0]['id'] == 'fedexovernightzones'){
					$num = '11';
					$title = "FedEx Overnight";
				}elseif($v['methods'][0]['id'] == 'fedexexpresssaverzones'){
					$num = '12';
					$title = "FedEx Express Saver";
				}elseif($v['methods'][0]['id'] == 'fedex2dayzones'){
					$num = '13';
					$title = "FedEx 2DAY";
				}elseif($v['methods'][0]['id'] == 'fedexgroundzones'){
					$num = '14';
					$title = "FedEx Ground";
				}
				elseif($v['methods'][0]['id'] == 'ffzones'){
					$num = '15';
					$title = "ODFL";
				}
				elseif($v['methods'][0]['id'] == 'ups2dayszones'){
					$num = '16';
					$title = "UPS 2DAYS";
				}
				elseif($v['methods'][0]['id'] == 'upsovernightzones'){
					$num = '17';
					$title = "UPS Overnight";
				}
				elseif($v['methods'][0]['id'] == 'upsgroundzones'){
					$num = '18';
					$title = "UPS Ground";
				}
				$html .= '<label class="shipping_logo_'.$num.'" for="'.$v['methods'][0]['id'].'">';
				if(($v['methods'][0]['cost']) == 0){
					if($v['methods'][0]['id'] == 'customzones'){
						$html .= '<input type="radio" name="choice" onclick = "select_acount(\''.$title.'\')" value="<b><font>'.$currencies->new_format($v['methods'][0]['cost']).'</font></b> ' .FS_TO .' <a href=\'javascript:void(apps())\' onclick=\'app()\' >'.$countries_name.'&nbsp;'.FS_VIA.' '.$v['ids'].'</a>"';
					}else{
						if($countries_code_2 == 'US'){
							$html .= '<input type="radio" name="choice" onclick = "select_acount(\''.$title.'\')" value="<font color=\'green\'>Free Shipping</font>&nbsp;&nbsp;'.$v['ids'].'&nbsp; Service <i class=\'shipping_service\'>|</i> <a href=\'javascript:void(apps())\' onclick=\'app()\' class=\'see_detail\'>See details</a>"';
						}else{
							$html .= '<input type="radio" name="choice" onclick = "select_acount(\''.$title.'\')" value="<font color=\'green\'>Free Shipping</font> ' .FS_TO .' <a href=\'javascript:void(apps())\' onclick=\'app()\' >'.$countries_name.'&nbsp;'.FS_VIA.' '.$v['ids'].'</a>"';
						}

					}
				}else{
					if($countries_code_2 == 'US'){
						$html .= '<input type="radio" name="choice" onclick = "select_acount(\''.$title.'\')" value="<font>'.$currencies->new_format($v['methods'][0]['cost']).'</font>&nbsp;&nbsp;'.$v['ids'].'&nbsp; Service <i class=\'shipping_service\'>|</i> <a href=\'javascript:void(apps())\' onclick=\'app()\' class=\'see_detail\'>See details</a>"';
					}else{
						$html .= '<input type="radio" name="choice" onclick = "select_acount(\''.$title.'\')" value="<b><font>'.$currencies->new_format($v['methods'][0]['cost']).'</font></b> ' .FS_TO .' <a href=\'javascript:void(apps())\' onclick=\'app()\' >'.$countries_name.'&nbsp;'. FS_VIA .' '.$v['ids'].'</a>"';
					}

				}
				if(isset($_SESSION['_choice']) && $_SESSION['_choice'] == $v['ids']){
					$html .= ' checked';
				}else{
					if($i == 1){
						$html .= ' checked';
					}
				}
				$html .= '>';
				$html .= '<a title="'.$title.'"><span onclick="_choice('.$i.',\''.$title.'\')"></span></a>';
				//$html .= '<span onclick="_choice('.$i.')">';
				//if(isset($v['icon'])){
				//$html .= $v['icon'];
				//}else{
				//$html .= $v['module'];
				//}
				//$html .= '</span>';
				$html .= '</label>';
				$html .= '</td>';
				$html .= '<td>'.$v['days'].'</td>';
				$html .= '<td>';
				if($v['methods'][0]['cost'] == 0){
					if($v['methods'][0]['id'] == 'customzones'){
						$html .= $currencies->new_format($v['methods'][0]['cost']);
					}else{
						$html .= '<span class="text_color_05">'.FS_FREE_SHIP.'</span>';
					}
				}else{
					$html .= $currencies->new_format($v['methods'][0]['cost']);
				}
				if($v['methods'][0]['id'] == 'customzones'){
					$html .= '<div class="track_orders_wenhao"><div class="question_bg"></div><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">'.FS_PREFER.'</div></div></div>';
				}
				$html .= '</td>';
				$html .= '</tr>';
			}
		}
	}
	if($_SESSION['_choice'] == 'Freight Collect'){
		$html .= '<tr id="shipping_method">';
	}else{
		$html .= '<tr id="shipping_method" style="display:none">';
	}
	$session_method = isset($_SESSION['method_shppings']) ? $_SESSION['method_shppings']:"";
	$session_acount = isset($_SESSION['method_acounts']) ? $_SESSION['method_acounts']:"";
	$shippingmethod = array('FEDEX','DHL','EMS','UPS','TNT','OTHERS');
	$html .= '<td colspan = "3"><p>'.FS_METHOD.':</p><select id="method" name="method" class="login_country">';
	foreach($shippingmethod as $jk){
		if($jk == $session_method){
			$html .='<option value="'.$jk.'" selected>'.$jk.'</option>';
		}else{
			$html .='<option value="'.$jk.'">'.$jk.'</option>';
		}
	}

	$html .='</select>';
	$html .= '<p>'. FS_ACCOUNt .':</p><input type="text" id="acount" class="big_input" name="acount" value="'.$session_acount.'"><i class="help_info"></i></td>';
	$html .= '</tr>';
	/*
    if($i>0){
        $html .= '<tr>';
        $html .= '<td width = "35%"></td>';
        $html .= '<td></td><td><input  type="button" onclick="return my_submit();" value="'.FS_SHIP_CONFIRM.'" class="button_02"></td>';
        $html .= '</tr>';
    }else{
        $html .= '<tr>';
        $html .= '<td width = "35%"></td>';
        $html .= '<td colspan = "2">'.FS_NO_SHIPPING.'</td>';
        $html .= '</tr>';
    }
    */
	$html .= '</table>';
	return $html;

}

//获取美国州的
function zen_get_countries_us_states(){
	global $db;

	return $db->getAll("select * from countries_us_states where status = 1 and type =1 order by states_code asc");
}
//获取加拿大的省份
function zen_get_countries_ca_states(){
	global $db;

	return $db->getAll("select * from countries_us_states where status = 1 and type =2 order by states asc");
}
//获取加拿大省份全称
function zen_get_countries_ca_states_code($states){
	global $db;

	$result = $db->Execute("select states from countries_us_states where states_code = '".$states."' and status = 1 and type =2 order by states asc");
	return $result->fields['states'];
}

/**
 *add by quest 2019-04-11
 * 获取墨西哥的省份
 */
function zen_get_countries_mx_states(){
	global $db;

	return $db->getAll("select * from countries_us_states where status = 1 and type = 3 order by states asc");
}

//获取美国州简称
function zen_get_countries_us_states_code($states){
	global $db;

	$result = $db->Execute("select * from countries_us_states where states = '".$states."' and status = 1 and type =1 order by states_code asc");
	return $result->fields['states_code'];
}


/**
 * @function:获取国家所在周
 * @param $countries_iso_code
 * @return string
 * @author:liang.zhu
 * 2019-09-17 15:38:02
 */
function get_country_to_state($countries_iso_code)
{
	$temp = '';

	$countries_iso_code = strtoupper($countries_iso_code);
	//北美洲
	$fs_state_north_america_array = array('CA', 'MX', 'PR');
	if (in_array($countries_iso_code, $fs_state_north_america_array)) {
		$temp = FS_STATE_NORTH_AMERICA;
	}
	//亚洲
	$fs_state_asia_array = array('BN', 'KH', 'ID', 'LA', 'MY', 'MM', 'PH', 'TH', 'TL', 'VN');
	if (in_array($countries_iso_code, $fs_state_asia_array)) {
		$temp = FS_STATE_ASIA;
	}
	//澳洲
	$fs_state_oceania_array = array('NZ');
	if (in_array($countries_iso_code, $fs_state_oceania_array)) {
		$temp = FS_STATE_OCEANIA;
	}
	//欧洲
	$fs_state_europe_array = array(
		'AL', 'AD', 'AW', 'AT', 'BE', 'BA', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE',
		'FO', 'FI', 'FR', 'GF', 'DR', 'GL', 'GP', 'GG', 'HU', 'IS', 'IE', 'IM',
		'IT', 'JE', 'LV', 'LI', 'LT', 'LU', 'MK', 'MT', 'MQ', 'YT', 'MD', 'MC',
		'ME', 'NL', 'NO', 'PL', 'PT', 'RO', 'SM', 'RS', 'SK', 'SI', 'ES', 'IC',
		'SE', 'CH',
	);
	if (in_array($countries_iso_code, $fs_state_europe_array)) {
		$temp = FS_STATE_EUROPE;
	}
	return $temp;
}

function upsStandardZonesDay($country_code)
{
	$day = [
		'IT' => '2-4 ',
		'DK' => '2-4 ',
		'ES' => '2-5 ',
		'LU' => '2-4 ',
		'IE' => '3-5 ',
		'GR' => '5-7 ',
		'EE' => '4-6 ',
		'LV' => '3-5 ',
		'LT' => '3-5 ',
		'HR' => '2-5 ',
		'MC' => '2-5 ',
		'AD' => '6-8 ',
		'JE' => '4-6 ',
		'PT' => '3-5 ',
		'FI' => '4-6 ',
		'SE' => '2-4 ',
		'PL' => '2-4 ',
		'SK' => '4-6 ',
		'HU' => '3-5 ',
		'SI' => '2-5 ',
		'RO' => '4-6 ',
		'NO' => '3-6 ',
		'SM' => '4-6 ',
		'GG' => '4-6 ',
		'IM' => '3-5 ',
		'JE' => '4-6 ',
	];
	return $day[$country_code] ? $day[$country_code] : '';
}

function upSsaverZonesDay($country_code)
{
	$day = [
		'DE' => '1-2',
		'AT' => '1-2',
		'BE' => '1-2',
		'LU' => '1-2',
		'NL' => '1-2',
		'FR' => '1-2',
		'GB' => '1-2',
		'IT' => '1-2',
		'VA' => '1-2',
		'SE' => '1-2',
		'CZ' => '1-2',
		'PL' => '1-2',
		'LI' => '1-2',
		'CH' => '1-2',
		'MK' => '1-2',
		'DK' => '1-3 ',
		'ES' => '1-3 ',
		'IE' => '1-3 ',
		'GR' => '1-4 ',
		'EE' => '1-3 ',
		'LV' => '1-3 ',
		'LT' => '1-3 ',
		'HR' => '1-3 ',
		'MC' => '1-3 ',
		'AD' => '4-7 ',
		'JE' => '1-3 ',
		'IC' => '2-5 ',
		'PT' => '1-3 ',
		'FI' => '2-4 ',
		'SK' => '1-3 ',
		'HU' => '1-3 ',
		'SI' => '1-3 ',
		'RO' => '1-3 ',
		'BG' => '1-3 ',
		'CY' => '1-3 ',
		'BA' => '3-5 ',
		'RS' => '2-5 ',
		'ME' => '2-4 ',
		'AL' => '3-5 ',
		'MD' => '4-6 ',
		'MT' => '1-3 ',
		'IS' => '2-4 ',
		'NO' => '1-4 ',
		'FO' => '3-7 ',
		'GL' => '10-15 ',
		'GP' => '4-6 ',
		'MQ' => '4-6 ',
		'YT' => '4-7 ',
		'AW' => '5-7 ',
		'SM' => '1-3 ',
		'GF' => '4-6 ',
		'GG' => '2-4 ',
		'IM' => '2-4 ',
        'BL' => '4-6 ',
        'MF' => '4-6 ',
	];
	return $day[$country_code] ? $day[$country_code] : '';
}

/**
 * $countries_id 国家id
 * 获取对应语种国家名称
 * return 国家名称
 */
function getLanguageCountriesName($countries_id){
	if(empty($countries_id)){
		return '';
	}
	$languages_code = $_SESSION['languages_code'] ? $_SESSION['languages_code'] : 'en';
	if(in_array($languages_code,['fr','it','es','mx','dn','ru','jp'])){
		if(in_array($_SESSION['languages_code'],['mx'])){
			$filed = 'es_countries_name';
		}else{
			$filed = $_SESSION['languages_code'].'_countries_name';
		}
	}else{
		$filed = 'countries_name';
	}
	$countries_name = fs_get_data_from_db_fields($filed,'countries','countries_id='.(int)$countries_id,'limit 1');
	if($countries_name){
		return $countries_name;
	}else{
		return '';
	}
}

?>
