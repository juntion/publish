<?php
use App\Services\Products\ProductInventoryService;

// products instock_id  or  related_instock
if(file_exists(DIR_WS_CLASSES.'FSCompositeProductsClass.php')) {
    require_once DIR_WS_CLASSES . 'FSCompositeProductsClass.php';
}
if(file_exists(DIR_WS_CLASSES.'FSCodeRelatedProducts.php')) {
    require_once DIR_WS_CLASSES . 'FSCodeRelatedProducts.php';
}
require_once DIR_WS_CLASSES . 'warehouseClass.php';

function fs_get_products_instock_id($id){
    global $db;
    $instockSQL = $db->Execute("select products_instock_id from products_instock where products_id=".(int)$id);
    if($instockSQL->fields['products_instock_id']){
        $products_instock_id = $instockSQL->fields['products_instock_id'];
    }else{
        $related = $db->Execute("select model_id from  products_instock_add_related where products_id=".$id);
        if($related->fields['model_id']){
            $instock_related = $db->Execute("select products_id from products_instock_add_model where model_id=".$related->fields['model_id']);
            if($instock_related->fields['products_id']){
                $instock_number = $db->Execute("select products_instock_id from products_instock where products_id = ".$instock_related->fields['products_id']." ");
                $products_instock_id = $instock_number->fields['products_instock_id'];
            }
        }
    }
    return $products_instock_id;
}

function zen_get_products_image_of_products_id($product_id) {
    global $db;

    $sql = "select p.products_image from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return $look_up->fields['products_image'];
}
function zen_get_order_product_attributes_by_order_products($oid,$opid){
    global $db;
    $products_attributes = array();

    $products = $db->Execute("select products_options_values_id as id,products_options,products_options_values,options_values_price,price_prefix 
                             from orders_products_attributes 
                             where orders_id =".(int)$oid." and orders_products_id =".(int)$opid." ");
    if($products->RecordCount()){
        while(!$products->EOF){
            $products_attributes [] = array(
                'id' => $products->fields['id'],
                'options' => $products->fields['products_options'],
                'values' => $products->fields['products_options_values'],
                'price' => $products->fields['options_values_price'],
                'prefix' => $products->fields['price_prefix']
            );
            $products->MoveNext();
        }
        return  $products_attributes;
    }

}
function zen_get_order_product_length_by_order_products($oid,$opid){
    global $db;
    $products_attributes = array();

    $products = $db->Execute("select price_prefix,length_price,length_name
                             from order_product_length 
                             where orders_id =".(int)$oid." and orders_products_id =".(int)$opid." ");


    if($products->RecordCount()){
        while(!$products->EOF){
            $products_attributes [] = array(
                'length_name' => $products->fields['length_name'],
                'price' => $products->fields['length_price'],
                'prefix' => $products->fields['price_prefix']
            );
            $products->MoveNext();
        }
        return  $products_attributes;
    }

}
function zen_get_order_product_of_sku($product_id){
    global $db;
    $sql = "select p.products_SKU from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return $look_up->fields['products_SKU'];

}

function zen_get_order_product_of_countries($orders_id){
    global $db;
    $sql = "select delivery_country from orders  where orders_id='" . (int)$orders_id . "'";
    $l = $db->Execute($sql);

    return $l->fields['delivery_country'];

}
function zen_get_order_product_of_shipping_method($orders_id){
    global $db;
    $sql = "select shipping_module_code from orders  where orders_id='" . (int)$orders_id . "'";
    $l = $db->Execute($sql);

    return $l->fields['shipping_module_code'];

}

function zen_get_order_product_of_order_to_admin($orders_id){
    global $db;
    $sql = "select admin_id from order_to_admin  where orders_id='" . (int)$orders_id . "' limit 1";
    $l = $db->Execute($sql);
    return zen_get_adminname($l->fields['admin_id']);
}
function zen_get_adminname($admin_id){
    global $db;
    $sql = "select admin_name from admin  where admin_id = '" . (int)$admin_id . "' limit 1";
    $l = $db->Execute($sql);

    return $l->fields['admin_name'];
}
function zen_get_order_product_of_bzone($products_instock_id){
    global $db;
    $sql = "select products_zone from products_instock_shipping_info_ProductsZone  where products_instock_id = '" . (int)$products_instock_id . "' limit 1";
    $l = $db->Execute($sql);

    return $l->fields['products_zone'];
}
function zen_get_order_product_of_fzone($products_instock_id){
    global $db;
    $sql = "select shippingzone from products_instock_shipping_zone  where products_instock_id = '" . (int)$products_instock_id . "' limit 1";
    $l = $db->Execute($sql);
    return $l->fields['shippingzone'];
}
function zen_get_order_product_of_fpiao($products_instock_id){
    global $db;
    $sql = "select is_billing from products_instock_shipping  where products_instock_id = '" . (int)$products_instock_id . "' limit 1";
    $l = $db->Execute($sql);
    if($l->fields['is_billing'] == 1){
        return "含税";
    }elseif($l->fields['is_billing'] == 2){
        return "不含税";
    }
}

function zen_get_order_product_of_model($product_id){
    global $db;
    $sql = "select p.products_model from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return $look_up->fields['products_model'];

}


function zen_get_products_attributes_instock($instock){
    global $db;
    $instockSQL = $db->Execute("select instock_qty from products_instock where products_instock_id =".(int)$instock);
    if($instockSQL->RecordCount()){
        $instockQTY = $instockSQL->fields['instock_qty'];
    }
    return $instockQTY;
}

//主产品 -- 非仓库指定品牌主产品
function zen_get_products_related_model($pid){
    global $db;
    if(is_numeric($pid) && $pid>0){
        $mainProductsId = fs_get_data_from_db_fields('main_products_id','products_instock_add_related','products_id='.$pid,'');
    }
    $products_id = $mainProductsId ? $mainProductsId : $pid;
    return $products_id;
}

//订单 调用库存临时表
function fs_order_use_products_instock($id){
    global $db;
    $sql = "SELECT SUM(qty) AS total_qty FROM products_instock_orders WHERE products_id = ".(int)$id;
    $order_IN = $db->Execute($sql);
    return $order_IN->fields['total_qty'];
}

//产品id 对应所有仓库的总库存，以后以这个为基准
function fs_products_instock_qty_all_warehouse($id){
    global $db,$countries_code_2;
    // if(zen_get_instock_products_warehouse_usa($id,1)){


    /*
       $cate_array1 = get_categories_son_id(65,1);
       $cate_array2 = get_categories_son_id(66,1);
       $cate_array3 = get_categories_son_id(87,1);
       $cate_array4 = get_categories_son_id(1789,1);
       $cate_array5 = get_categories_son_id(112,1);
       $cate_array6 = get_categories_son_id(111,1);
       $cate_array7 = get_categories_son_id(2764,1);
       $cate_array8 = get_categories_son_id(2765,1);
       $cate_array9 = get_categories_son_id(2985,1);
       $cate_array10 = get_categories_son_id(2879,1);
       $cate_array11 = array();
       $cate_array12 = get_categories_son_id(2951,1);
       $cate_array13 = get_categories_son_id(2878,1);
       $cate_array14 = get_categories_son_id(2875,1);
       $cate_array15 = get_categories_son_id(1073,1);
       $cate_array = array_merge($cate_array1,$cate_array2,$cate_array3,$cate_array4,$cate_array5,$cate_array6,$cate_array7,$cate_array8,$cate_array9,$cate_array10,$cate_array11,$cate_array12,$cate_array13,$cate_array14,$cate_array15);

     //获取定制产品主产品
     $p_id = 0;
        if($id){
           $p_id = fs_get_data_from_db_fields('products_id','products_instock_customized_related','customized_id= '.$id,' limit 1');
           }

     */
    //if(fs_zen_get_product_category_id((int)$id,$cate_array) || fs_zen_get_product_category_id((int)$p_id,$cate_array)){
    // if(fs_zen_get_product_category_id((int)$id,$cate_array)){

    //  $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = ".(int)$id." and warehouse in(1,2,3,5,6,7,10,11)";

    // }elseif(in_array($countries_code_2,array('US','CA','MX'))){

    /*
     if(in_array($countries_code_2,array('US','CA','MX'))){

          $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = ".(int)$id." and warehouse in(3)";
     }else{

          $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = ".(int)$id." and warehouse in(1,2,5,6,7,10,11)";

     }
     */
    $instockQty = 0; $isCompositeProducts = false;
    if(class_exists('classes\CompositeProducts')){
        $CompositeProducts = new classes\CompositeProducts($id);
        if($CompositeProducts->CompositeProductsRelated()){
            $instockQty = $CompositeProducts->CompositeRelatedInstock(0,true);
            $isCompositeProducts = true;
        }
    }
    if($isCompositeProducts && $instockQty){
        return $instockQty;
    }else {
        $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse in(1,2,3,5,6,7,10,11,20,18,24)";

        $instock = $db->Execute($sql);

        $instock_qty = $instock->fields['total_qty'];
        if(class_exists('classes\codeRelatedProducts')){  // 美加墨地区库存数量需加上可改码产品库存
            $codeRelatedClass = new classes\codeRelatedProducts($id);
            if($codeRelatedClass::$related_id && $codeRelatedClass->getIsCodeRelated()){
                $codeRelatedInstock = $codeRelatedClass::getProductsEnabledNum($codeRelatedClass::$related_id,3);
                $codeRelatedInstock_DE = $codeRelatedClass::getProductsEnabledNum($codeRelatedClass::$related_id,20);
                if($codeRelatedInstock_DE['instock_qty']<0){
                    $codeRelatedInstock_DE['instock_qty']=0;
                }
                if($codeRelatedInstock['instock_qty']<0) $codeRelatedInstock['instock_qty']=0;
                $instock_qty += $codeRelatedInstock['instock_qty'];
                $instock_qty += $codeRelatedInstock_DE['instock_qty'];
            }
        }
        return $instock_qty;
    }
}

/*产品库存总数 = 各仓库库存之和
 * 前台显示库存数量,排除掉退换仓  4,14,15
 * 定制产品显示半成品仓库存数量+所有关联的成品仓数量
 * 成品=该成品仓库存数量 + 对应定制产品的库存数量
 * */
function fs_products_instock_total_qty_of_products_id($products_id,$pcs=0){
    global $db;
    $all_products=array();$all_c_qty =$products_instock_qty=$temp_instock=0;
    $is_customized = fs_get_data_from_db_fields('id','products_instock_customized_related','products_id >0 and customized_id= '.$products_id,' limit 1');
    if($is_customized){  //定制产品
        $instockSQL = $db->getAll("select products_instock_id from products_instock where products_id =" .$products_id. " and warehouse in(1,2,5,6,3,20,7,10,11,18,24)");
        $instock_arr = array();
        $temp_instock = 0;
        $back_instock = 0;
        if(!empty($instockSQL)) {
            foreach ($instockSQL as $k => $v) {
                if (!empty($v['products_instock_id'])) {
                    $instock_arr[] = $v['products_instock_id'];
                }
            }
            $instock_arr = "(" . implode(",", $instock_arr) . ")";
            $temp_instock = fs_get_data_from_db_fields('sum(qty)', 'products_instock_orders', 'instock_id in ' . $instock_arr, '');
            $back_instock = fs_get_data_from_db_fields('sum(change_qty)', 'products_instock_history_temp', 'products_instock_id in ' . $instock_arr, ' and type=0 ');
            if (!$temp_instock) {
                $temp_instock = 0;
            }
            if (!$back_instock) {
                $back_instock = 0;
            }
        }
        $all_c_qty = fs_get_data_from_db_fields('instock_qty','products_instock','warehouse=6 and products_id= '.$products_id,' limit 1');
        $all_products = fs_get_data_from_db_fields_array(array('products_id'),'products_instock_customized_related','products_id >0 and customized_id= '.$products_id,'');
        foreach ($all_products as $cp){
            $all_c_qty = $all_c_qty+ fs_products_instock_qty_all_warehouse($cp[0]);
        }
        $instock_qty = $all_c_qty - $temp_instock-$back_instock;
    }else{
        $related_pid = zen_get_products_related_model($products_id);   //关联主产品
        if($related_pid){
            $products_instock_qty =fs_products_instock_qty_all_warehouse($related_pid);
            $instockSQL = $db->getAll("select products_instock_id from products_instock where products_id =" .$related_pid. " and warehouse in(1,2,5,6,7,10,11,20,3,18,24)");
            $instock_arr = array();
            $temp_instock = 0;
            $back_instock = 0;
            if(!empty($instockSQL)) {
                foreach ($instockSQL as $k => $v) {
                    if (!empty($v['products_instock_id'])) {
                        $instock_arr[] = $v['products_instock_id'];
                    }
                }
                $instock_arr = "(" . implode(",", $instock_arr) . ")";
                $temp_instock = fs_get_data_from_db_fields('sum(qty)', 'products_instock_orders', 'instock_id in ' . $instock_arr, '');
                $back_instock = fs_get_data_from_db_fields('sum(change_qty)', 'products_instock_history_temp', 'products_instock_id in ' . $instock_arr, ' and type=0 ');
                if (!$temp_instock) {
                    $temp_instock = 0;
                }
                if (!$back_instock) {
                    $back_instock = 0;
                }
            }
            $customized_id = fs_get_data_from_db_fields('customized_id','products_instock_customized_related','products_id= '.$related_pid,' limit 1');
            if($customized_id){    //主产品有关联定制产品
                $products_instock_qty = $products_instock_qty + fs_products_instock_qty_all_warehouse($customized_id);
            }
        }
        $instock_qty = $products_instock_qty - $temp_instock-$back_instock;
    }

    $instockInfo =  $instock_qty > 0 ? $instock_qty : 0;
    if($pcs == 1){
        if($instockInfo>0){
            return "<i></i>".$instockInfo.'pcs';
        }else{
            return "";
        }
    }else{
        return $instockInfo ;
    }
}


//列表页quickFinder表中库存数量显示
/*
function fs_products_instock_total_qty_of_products_id($products_id){
	global $db;	
	  $productsInstockID = fs_get_products_instock_id($products_id);  //产品对应的库存id
	  if($productsInstockID){
      $temp_instock = fs_order_use_products_instock($productsInstockID);
      $related_instock_qty = zen_get_products_attributes_instock($productsInstockID); //关联产品调用主产品库存数量

	   if($related_instock_qty > 0 ){ 
	   $ontime_qty = $related_instock_qty - $temp_instock;
	   
		   if($ontime_qty > 0){
		    $instockInfo = $ontime_qty;
		   }else{
		     $instockInfo = 0;
		   }
	   }else{
	      $sql = "SELECT SUM(`instock_qty`) AS total_qty FROM `products_instock` WHERE `products_id`='" . (int)$products_id . "'";
	      $total_qty = $db->Execute($sql);
	      $p_num_info = $total_qty->fields['total_qty'] - $temp_instock ;       

	      if ($p_num_info<1) {
	        $instockInfo = 0;
	      }else if ($p_num_info == 1){
	        $instockInfo =$p_num_info; 
	      }else{ 
	        $instockInfo =$p_num_info; 
	      }  
        } 
    }
    return $instockInfo ;    
}
*/

function fs_products_instock_qty_warehouse($id, $warehouse, $is_all_qty, $sign = true)
{
    global $db, $countries_code_2;
    $instockQty = 0;
    $isCompositeProducts = false;
    $instock_qty = 0;
    if ($warehouse == "US") {
        $type = 3;
    } elseif ($warehouse == "DE") {
        $type = 20;
    } elseif ($warehouse == "AU") {
        $type = 37;
    } elseif ($warehouse == 'US-ES') {
        $type = 40;
    } elseif ($warehouse == 'RU') {
        $type = 67;
    } elseif ($warehouse == 'SG') {
        $type = 71;
    } else {
        $type = 0;
    }

    if (class_exists('classes\CompositeProducts')) {
        $CompositeProducts = new classes\CompositeProducts($id);
        if ($CompositeProducts->CompositeProductsRelated()) {
            $instockQty = $CompositeProducts->CompositeRelatedInstock($type, true);
            $isCompositeProducts = true;
        }
    }
    if ($isCompositeProducts) {
        $instockQty = $instockQty > 0 ? $instockQty : 0;
        return $instockQty;
    } else {
        if ($warehouse == "US") {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse = 3";
        } elseif ($warehouse == "DE") {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse = 20";
        } elseif ($warehouse == "AU") {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse = 37";
        } elseif ($warehouse == "US-ES") {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse = 40";
        } elseif ($warehouse == "RU") {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse = 67";
        } elseif ($warehouse == "SG") {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse = 71";
        } else {
            $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = " . (int)$id . " and warehouse in(1,2,5,6,7,10,11)";
        }

        $instock = $db->Execute($sql);

        $instock_qty = $instock->fields['total_qty'];

        if (class_exists('classes\codeRelatedProducts') && in_array($warehouse, array('US', 'CA', 'MX', "DE","US-ES", "SG"))) {  // 美加墨地区库存数量需加上可改码产品库存
            $codeRelatedClass = new classes\codeRelatedProducts($id);
            //$sign = false;
            if ($codeRelatedClass->getIsCodeRelated() || ($codeRelatedClass->isCustom && $sign)) {
                $codeRelatedInstock = $codeRelatedClass->getCodeRelatedTotalInstockQty($type, $sign);
                if ($codeRelatedInstock < 0) $codeRelatedInstock = 0;
                $instock_qty += $codeRelatedInstock;

            }
        }
        return $instock_qty;
    }
}

/**
 * 产品库存查询
 *
 * user:aron
 * date 2019.6.19
 * @param $products_id 产品id
 * @param $warehouse  库存仓库
 * @param $is_all_qty 已经作废
 * @param int $pcs    产品数量
 * @param bool $sign 区分展示和下单 true 展示 false 下单时库存判断
 * @paran array $composite_data，存放的是组合产品选择的属性值字符串，以及匹配到子产品返回无库存的子产品数组['attr'=>'','products'=>[]]
 * @return int
 */
function fs_products_instock_qty_of_products_id($products_id, $warehouse, $is_all_qty, $pcs = 0, $sign = true, &$composite_data=[])
{
    global $db;
    //如果美西仓关闭，则库存为0
    if ($warehouse == "US" && US_WAREHOUSE_UP) {
        return 0;
    }
    if ($warehouse == "US") {
        $type = 3;
    } elseif ($warehouse == "DE") {
        $type = 20;
    } elseif ($warehouse == "AU") {
        $type = 37;
    } elseif ($warehouse == "US-ES") {
        $type = 40;
    } elseif ($warehouse == "RU") {
        $type = 67;
    } elseif ($warehouse == "SG") {
        $type = 71;
    } elseif ($warehouse == "RU") {
        $type = 67;
    } else {
        $type = 2;
    }
    $related_products_id = $products_id;
    $products_id = (int)$products_id;
    $warehouseClass = new \classes\warehouseClass();
    /*
     * 美东仓库存需要单独处理
     *
     * 定制产品匹配到改码产品全部为标准产品
     * 美东仓时，判断当前产品是否为定制产品，如果定制产品调用 半成品仓库存
     * 如果为 标准产品，判断当前产品本身是否满足发货,否则调用半成品仓库存
     */
    if ($type == 40 || $type == 20) {
        $isSemiFinished = $warehouseClass->isCustom($products_id);
        $semiFinishedStock = 0;
        if ($isSemiFinished) {
            $instockInfo = $warehouseClass->getFrontInstock($products_id, $warehouse, true);
        } else {
            $instockInfo = $warehouseClass->getFrontInstock($products_id, $warehouse);
            if ($warehouseClass->customID) {
                $semiFinishedStock = $warehouseClass->getFrontInstock($warehouseClass->customID, $warehouse, true);
            }
            if (!$sign && $instockInfo < $pcs) {
                if ($semiFinishedStock >= $pcs) {
                    $instockInfo = $semiFinishedStock;
                } else {
                    $warehouseClass->mainProducts = $products_id;
                }
            }else{
                $warehouseClass->mainProducts = $products_id;
            }
            if ($sign) {
                $instockInfo += $semiFinishedStock;
            }
        }
    }elseif ($type == 2){
        if($sign){
            $instockInfo = $warehouseClass->getFrontInstock($products_id, $warehouse);
        }else{
            $cnInstock = $warehouseClass->getCnInstock($products_id);
            if($cnInstock['current']['qty'] >= $pcs){
                $instockInfo = (int)$cnInstock['current']['qty'];
            }elseif ($cnInstock['extra']['qty'] >= $pcs){
                $instockInfo = (int)$cnInstock['extra']['qty'];
            }else{
                $instockInfo = (int)$cnInstock['current']['qty'] > 0 ? (int)$cnInstock['current']['qty'] : 0;
            }
        }
    } else {
        $instockInfo = $warehouseClass->getFrontInstock($products_id, $warehouse);
    }

    /*
     * 判断是否cumulus产品，该产品需要互相关联
     * 产品详情页展示
     */
    /*$cumulus_id = getRelatedCumulusProducts($products_id);
    if ($cumulus_id && $sign) {
        foreach ($cumulus_id as $v) {
            if ($v == $products_id) {
                continue;
            }
            $instockInfo += $warehouseClass->getFrontInstock($v, $warehouse);
        }
    }*/

    //关联主id
    $code_related_id = $warehouseClass->mainProducts;
    //判断是否组合
    if (class_exists('classes\CompositeProducts')) {
        $CompositeProducts = new classes\CompositeProducts($products_id, '', $composite_data['attr']);
        //光模块部分产品首页总库存add by ternence
        $instockInfo_new=0;
        if(in_array($_GET['main_page'],['index','product_ideas']) && !isset($_GET['cPath']) && empty($_POST)){
            if(in_array($products_id,array(44065,44550,31224,45567,44062,44555,19362,19370,31294,31237))){
                $productArr = $db->getAll('select associated_inventory_us,associated_inventory_au,associated_inventory_cn,associated_inventory_de from '.TABLE_PRODUCTS.' where products_id ='.$products_id.'');
                if($productArr){
                    if(in_array($type,array(40,3)) && $productArr[0]['associated_inventory_us']){
                        $instockInfo_new = $productArr[0]['associated_inventory_us'];
                    }elseif($type==20 && $productArr[0]['associated_inventory_de']){
                        $instockInfo_new = $productArr[0]['associated_inventory_de'];
                    }elseif($type == 37 && $productArr[0]['associated_inventory_au']){
                        $instockInfo_new = $productArr[0]['associated_inventory_au'];
                    }elseif($productArr[0]['associated_inventory_cn']){
                        $instockInfo_new = $productArr[0]['associated_inventory_cn'];
                    }
                }
            }
        }
        $instockQty = 0;
        $isCompositeProducts = false;
        if ($CompositeProducts->CompositeProductsRelated()) {
            $instockQty = $CompositeProducts->CompositeRelatedInstock($type, true);
            $composite_data['products'] = $CompositeProducts->no_stock_id;
            $isCompositeProducts = true;
        }
        if ($isCompositeProducts) {
            $instockQty = $instockInfo + $instockQty > 0 ? $instockInfo + $instockQty : 0;
            return $instockQty;
        }
    }

    //判断是否改码
    if (class_exists('classes\codeRelatedProducts') && in_array($warehouse, array('US', 'CA', 'MX', "DE", "US-ES",'SG'))) {  // 美加墨地区库存数量需加上可改码产品库存
        $codeRelatedClass = new classes\codeRelatedProducts($products_id,$pcs,$type);
        if (($codeRelatedClass->getIsCodeRelated() || $codeRelatedClass->isCustom) && $sign) {
            $codeRelatedInstock = $codeRelatedClass->getCodeRelatedTotalInstockQty($type, $sign);
            if ($codeRelatedInstock < 0) $codeRelatedInstock = 0;
            $instockInfo += $codeRelatedInstock;
            $instockInfo = $instockInfo > 0 ? $instockInfo : 0;
            //光模块部分产品首页总库存add by ternence
            if(in_array($_GET['main_page'],['index','product_ideas']) && !isset($_GET['cPath']) && empty($_POST)){
                if(in_array($products_id,array(44065,44550,31224,45567,44062,44555,19362,19370,31294,31237))){
                    $instockInfo = $instockInfo_new;
                }
            }
            return $instockInfo;
        }
        if (!$sign) {
            $bool = $codeRelatedClass::verifyProductsInstock();
            $instockInfo_code = $codeRelatedClass::$currentQty;
            //只有改码出库的时候才关联id
            if($codeRelatedClass::$isChangeCode){
                $code_related_id = $codeRelatedClass::$related_id ? $codeRelatedClass::$related_id : $code_related_id;
            }
            if ($bool && $instockInfo_code > 0) {
                if($code_related_id){
                    $GLOBALS["related_products_id_for_orders"][$related_products_id] = [
                        "related_id" => $code_related_id,
                        "qty" => $instockInfo_code,
                        "pcs" => $pcs
                    ];
                }
                $instockInfo_code = $instockInfo_code > 0 ? $instockInfo_code : 0;
                return $instockInfo_code;
            }
        }
    }
    //临时获取 已清点 但是未入库 库存,后期会关闭;
    if($sign && $type == 2){
        $instockInfo += $warehouseClass->getCnTempStock();
    }
    //记录关联产品
    if(!$sign && $code_related_id){
        $GLOBALS["related_products_id_for_orders"][$related_products_id] = [
            "related_id" => $code_related_id,
            "qty" => $instockInfo > 0 ? $instockInfo : 0,
            "pcs" => $pcs
        ];
    }
    //光模块部分产品首页总库存add by ternence
    if(in_array($_GET['main_page'],['index','product_ideas']) && !isset($_GET['cPath']) && $sign && empty($_POST)){
        if(in_array($products_id,array(44065,44550,31224,45567,44062,44555,19362,19370,31294,31237))){
            $instockInfo = $instockInfo_new;
        }
    }
    $instockInfo = $instockInfo > 0 ? $instockInfo : 0;
    return $instockInfo;
}
function zen_get_products_instock_qty_of_products_id($products_id,$is_all_qty=false,$is_custom=true){
    global $db;

    if($is_custom){
        $products_id = fs_get_custom_related_standard_products($products_id);   //  如果是定制产品  会根据默认属性值取得标准产品的ID   如果不是定制产品原ID返回
    }

    return  $p_num_info = fs_products_instock_qty_of_products_id($products_id,$is_all_qty);

}
function zen_get_products_instock_total_qty_of_products_id($products_id,$is_custom=true){
    global $db;

    if($is_custom){
        $products_id = fs_get_custom_related_standard_products($products_id);   //  如果是定制产品  会根据默认属性值取得标准产品的ID   如果不是定制产品原ID返回
    }

    $p_num_info = fs_products_instock_total_qty_of_products_id($products_id);
    /*
    if(in_array($products_id,array(22138,11774,12621,12622,22139,20358,12624,34976,39135,39138,45564,19374,11557,36433,11555,42488,42492,36434,11552,58799,36157,48722,36173,48276,36171,36170,36153,36143,36205,30884,48948,30903,30856,30862,30910,30914,30900,30907,30890))){
    $p_num_info = $p_num_info > 50 ? $p_num_info : 50;
    }else if($products_id == 48354){
    $p_num_info = $p_num_info > 20 ? $p_num_info : 20;
    }
    */

    if (in_array($products_id,array(51308,31866,31909,31922))) {
        if ($products_id == 51308) {
            $p_roll_km = FS_SHIP_ROLL_2KM;
        }else{
            $p_roll_km = FS_SHIP_ROLL_1KM;
        }

        if ($p_num_info<1) {
            $instockInfo = FS_SHIP_AVAI;
        }else if ($p_num_info == 1){
            // $instockInfo ='<i>'.$p_num_info.FS_SHIP_ROLL.'</i> '.FS_SHIP_STOCK.$p_roll_km;
            $instockInfo ='<i>'.$p_num_info.' KM</i> '.FS_SHIP_STOCK;
        }else{
            // $instockInfo = '<i>'.$p_num_info.FS_SHIP_ROLLS.'</i>'.FS_SHIP_STOCK.$p_roll_km;
            $instockInfo = '<i>'.$p_num_info.' KM</i>'.FS_SHIP_STOCK;
        }
        return $instockInfo ;
    }

    if ($p_num_info<1) {
        $instockInfo = FS_SHIP_AVAI;
    }else if ($p_num_info == 1){
        $instockInfo ='<i>'.$p_num_info.FS_SHIP_PC.'</i> '.FS_SHIP_STOCK;
    }else{
        $instockInfo = '<i>'.$p_num_info.FS_SHIP_PCS.'</i>'.FS_SHIP_STOCK;
    }
    return $instockInfo ;
}

//产品库存总量
function zen_get_current_qty($id,$warehouse,$is_global=false,$is_custom=false, &$composite_data=[]){
    if($is_custom){
        $id = fs_get_custom_related_standard_products($id);
    }
    $num = fs_products_instock_qty_of_products_id($id,$warehouse,$is_global,0,true,$composite_data);
    return $num;
}

function  get_products_instock_id($products_id){
    global $db;
    $product_sql = "select products_instock_id from products where products_id ='" . (int)$products_id . "'";
    $products_instock = $db->Execute($product_sql);
    return $products_instock->fields['products_instock_id'];
}

function zen_get_instock_products_all_qty($instock_id){
    global $db;
    $instock_sql = $db->Execute("select products_id from products_instock where products_instock_id=".$instock_id);
    $products_id = $instock_sql->fields['products_id'];
    if($products_id){
        $sql = "SELECT SUM(`instock_qty`) AS total_qty FROM `products_instock` WHERE `products_id`='" . (int)$products_id . "'";
        $total_qty = $db->Execute($sql);
        $p_num_info = (int)$total_qty->fields['total_qty'] ;
    }else{
        $p_num_info = 0 ;
    }
    return  $p_num_info;
}

function zen_get_products_channel_number_statu($p_num) {
    $p_num_info=(int)$p_num;
    if ($p_num_info<1) {
        return  '<td ><div class="pro_yellow_stock "><i></i>'.FS_SHIP_AVAI.'</div></td>';
    }elseif ($p_num_info==1){
        return  '<td><div class="pro_green_stock "><i></i>'.$p_num_info.FS_SHIP_PC.'</div></td>';
    }
    return  '<td><div class="pro_green_stock "><i></i>'.$p_num_info.FS_SHIP_PCS.'</div></td>';
}

function zen_get_products_channel_number_qty($p_num,$type = '') {
    $p_num_info=(int)$p_num;
    //add Yoyo 2019.07.05  $type =2 时  只需要返回 Available 或 In Stock
    if($type ==2){
        if($p_num_info <1){
            return QTY_SHOW_AVAILABLE;
        }else{
            return QTY_SHOW_ZERO_STOCK_1;
        }
    }else{
        if ($p_num_info<1) {
            if($type==1){
                return 0 . QTY_SHOW_ZERO_STOCK_1;
            }else{
                return  QTY_SHOW_AVAILABLE;
            }
        }elseif ($p_num_info==1){
            return  $p_num_info.QTY_SHOW_ZERO_STOCK_1;
        }
        return  $p_num_info.QTY_SHOW_ZERO_STOCK_1;
    }
}

function zen_get_products_channel_wdm_number_qty($all_qty) {

    foreach($all_qty as $key => $val){
        if($val == 1 || $val == 0){
            $all_qty[$key] = $val.FS_SHIP_PC;
        }else{
            $all_qty[$key] = $val.FS_SHIP_PCS;
        }
    }

    return $all_qty;
}

function fs_products_instock_qty($id) {
    global $db,$countries_code_2;
    /*$p_num_info = fs_products_instock_total_qty_of_products_id($id);*/
    if(german_warehouse("country_code",$countries_code_2)){
        $instockQty = zen_get_current_qty($id,"DE",false);
    }elseif(seattle_warehouse("country_code",$countries_code_2)){
        $instockQty = zen_get_current_qty($id,"US",false)+zen_get_current_qty($id,"US-ES",false);
    }elseif($countries_code_2=="AU"){
        $instockQty = zen_get_current_qty($id,"AU",false);
    }else{
        $instockQty = zen_get_current_qty($id,"CN",true);
    }

    if ($instockQty<1) {
        return  '<td style="text-align: center;"><div class="pro_yellow_stock "><i></i>'.FS_SHIP_AVAI.'</div></td>';
    }elseif ($instockQty==1){
        return  '<td style="text-align: center;"><div class="pro_green_stock "><i></i>'.$instockQty.FS_SHIP_PC.'</div></td>';
    }
    return  '<td style="text-align: center;"><div class="pro_green_stock "><i></i>'.$instockQty.FS_SHIP_PCS.'</div></td>';
}


function  zen_get_products_instock_total_qty_is_show_message($products_id,$shopping_qty,$options_array,$store_qty = false){
    global $db;
    if($store_qty !== false){
        $p_num_info = $store_qty;
    }else{
        $p_num_info =  fs_products_instock_total_qty_of_products_id((int)$products_id);
    }
    if ( $p_num_info >=1 &&  $shopping_qty > $p_num_info   ) {
        $products_deliver_time = zen_get_product_deliver_time($products_id);
        if($products_deliver_time){
            $products_ship_time = $products_deliver_time;
        }else{
            $category_deliver_time = get_deliver_time_of_product_by_category($products_id);
            if($category_deliver_time){
                $products_ship_time = $category_deliver_time;
            }else{
                $products_ship_time = 5;
            }
        }

        $week_date = array();
        for($i = 1; $i<=$products_ship_time;$i++){
            $week_date [] =  date('Y-m-d', strtotime('+'. $i .' days'));
        }

        $n = 0;
        for($k = 0; $k<sizeof($week_date);$k++){
            if(week($week_date[$k])){
                if( (sizeof($week_date) == 1) && (date('w',strtotime($week_date[$k]))==6)){
                    $n++; }
                $n++;
            }
        }

        $products_ship_time = $products_ship_time + $n;

        $ship_date = get_all_languages_date_display(strtotime('+'. $products_ship_time .' days'),"default1");
        $html='<div  class="shopping_cart_stock"><span  class="products_in_stock">';
        $html .= FS_SHIP_AVAI. ',';
        $html .= '</span>';
        $html .= FS_SHIP_INVENTORY .$ship_date;
        $html .= '</div>';
        return $html ;
    }
    return ;
}


function zen_get_products_instock_shipping_to_date_of_products_id($products_id){
    global $db;
    $p_num = fs_products_instock_total_qty_of_products_id($products_id);
    if($p_num>0){
        $products_ship_time = 1;
        $products_to_ship_time = 5;
    }elseif($products_quantity->fields['products_instock_show_statu'] == '3'){
        $products_ship_time = "";
    }elseif($products_quantity->fields['products_instock_show_statu'] == '4'){
        $products_ship_time = "";
    }else{
        /*
         $products_deliver_time = zen_get_product_deliver_time($products_id);
            $category_deliver_time = get_deliver_time_of_product_by_category($products_id);
            if($products_deliver_time){
              $products_ship_time = $products_deliver_time;
            }else{
             if($category_deliver_time){
               $products_ship_time = $category_deliver_time;
             }else{
               $products_ship_time = 5;
             }
            }

             $week_date = array();
            for($i = 1; $i<=$products_ship_time;$i++){
                $week_date [] =  date('Y-m-d', strtotime('+'. $i . ' days'));
            }

            $n = 0;
            for($k = 0; $k<sizeof($week_date);$k++){
             if(week($week_date[$k])){
               if( (sizeof($week_date) == 1) && (date('w',strtotime($week_date[$k]))==6)){

               $n++;
               }
             $n++;
             }
            }

            $products_ship_time = $products_ship_time + $n;

            if(in_array($countries_code_2,array('US','CA','MX'))){
                if(fs_products_instock_qty_domestic_inventory_warehouse($products_id)){
                    $products_ship_time = 4;
                    $products_to_ship_time = 8;
                }else{
                    $products_ship_time = $products_ship_time+4;
                    $products_to_ship_time = $products_ship_time+8;
                }

            }*/
        $products_ship_time = "";
    }
    if($products_ship_time){
        $ship_date = date('D. M. j', strtotime('+'. $products_ship_time . ' days'));
        $ship_to_date = date('D. M. j', strtotime('+'. $products_to_ship_time . ' days'));
        return "Estimated between <b>".$ship_date." and ".$ship_to_date."</b>";
        //Estimated between Tue.May.2 and Fri.May.19
    }else{
        return "";
    }
}

/**
 * @param $products_id
 * @param $products_instock_status
 * @param $warehouse
 * @param $country_code
 * @param string $languages_code
 * @param string $languages_id
 * @param int $buy_product_qty
 * @param array $attr_arr
 * @param string $is_heavy
 * @param array $en_us_data = array('is_en_us' => 英文站国家为美国,波多黎各,'transport_time' => 运输时效+2个工作日,'shipping_method' => 运输方式 ));
 * @param bool $delayHasHeavy  该订单中是否有重货  false = 没有   true = 有
 * @return array
 */
function zen_get_products_instock_delivery_time($products_id,$products_instock_status,$warehouse,$country_code,$languages_code='',$languages_id ='',$buy_product_qty=1,$attr_arr=array(),$is_heavy='',$en_us_data=[],$delayHasHeavy=false){
    global $db;
    $sql = "SELECT `products_instock_show_statu`  FROM `products` WHERE `products_id`= '" . (int)$products_id . "'";
    $products_quantity = $db->Execute($sql);
    if ($products_instock_status&&$products_instock_status !=FS_OUT_OF_STOCK && $products_instock_status !=FS_SHIP_AVAI && $products_instock_status !=FS_SHIP_DEVE&&$products_instock_status!==0) {
        return array("date"=>FS_SHIP_SAME_DAY,"time"=>0);

    }
    if ($products_quantity->fields['products_instock_show_statu'] == '3') {
        return array("date"=>'N/A',"time"=>0);
    }
    if ($products_quantity->fields['products_instock_show_statu'] == '4') {
        return array("date"=>'--',"time"=>0);
    }

    if ($products_quantity->fields['products_instock_show_statu'] == '2' || $products_quantity->fields['products_instock_show_statu'] == '1') {
        $area = $db->Execute("select time_zone from country_time_zone where code='".strtoupper($country_code)."' limit 1");
        $area = $area->fields['time_zone'];
        $area = $area ? $area : "";
        $cn_qty = zen_get_current_qty($products_id, "CN", true);//武汉仓库存
        $country_iso_code = strtolower($country_code);
        $insideTime = 0;
        //2天内部处理时间
        if(in_array($country_iso_code,['us','pr'])){
            if($cn_qty){
                $insideTime = 1; //国内有库存已经加了1天时差
            }else{
                $insideTime = 2;
            }
        }
        $add_time = 0;
        $shipping_method = '';
        if($en_us_data['transport_time']){
            $add_time = (int)$en_us_data['transport_time']; //运输时效
            $shipping_method = $en_us_data['shipping_method'];
        }
        $add_time = $add_time+$insideTime; //运输时效+内部处理时间

        $standard_product_days=0;
        //(定制产品不按照数量调取交期 调取最小数量交期)
        if($attr_arr){
            //根据属性匹配虚拟id
            $related_id = attribute_matching_fictitious_id($products_id,$attr_arr);
            $standard_product_days = get_standard_product_days($related_id,1);

            //如果匹配到的虚拟id没有交期，则调取原id的交期
            if($related_id != $products_id && !$standard_product_days) {
                $standard_product_days = get_standard_product_days($products_id,1);
            }
        }

        //标准产品根据库存数量调取对应交期
        if($buy_product_qty > $cn_qty && empty($attr_arr)){
            $standard_product_days = get_standard_product_days($products_id,$buy_product_qty);
        }

        //定制产品和预售产品备货时间
        if(!$standard_product_days){
            $products_ship_time = zen_get_product_deliver_time($products_id);
            if(!$products_ship_time){
                if(in_array($products_id,array(69219,69220))){
                    $products_ship_time = 30 ;
                }else{
                    $products_ship_time = 5 ;
                }
            }
            $products_ship_time = $products_ship_time + (int)$add_time;
        }else{
            $standard_product_days = $standard_product_days + (int)$add_time;
        }


        $spring_days = get_spring_festival_holiday();//春节假期
        //$is_spring_festival = false;
        //澳洲仓无库存新西兰从武汉直发dylan 2019.7.9
        $festival_day = 0;
        $sg_warehouse = singapore_warehouse("country_code",$country_iso_code);
        $ru_warehouse = ru_warehouse("country_code",$country_iso_code);
        if(seattle_warehouse("country_code",$country_iso_code) || all_german_warehouse("country_code",$country_iso_code) || au_warehouse($country_iso_code,"country_code") || $sg_warehouse || $ru_warehouse){
            //转运时间 (重货直发)
            if($delayHasHeavy && !all_german_warehouse("country_code",$country_iso_code) && !in_array($country_iso_code, ['au']) && !$ru_warehouse){  //欧洲仓和澳大利亚,俄罗斯仓全面转运  其它仓重货直发
                $origin_day=0;
            }else{
                $origin_day=7;
            }
            if($origin_day){
                // 加上转运时间 = 转运地区的发货时间  需要添加节假日
                $all_origin = get_specific_date_of_days($origin_day,2,$spring_days,$country_iso_code);
                $festival_day = get_festival_day($country_iso_code,$all_origin);
            }


            if(in_array($country_iso_code,array('us','ca','mx','nz','pr')) || $sg_warehouse){
                if($sg_warehouse){  //新加坡仓覆盖国家  武汉仓有库存和本地发货时间一样
                    $ship_day =  (int)$add_time;
                }else{
                    $ship_day =  1 + (int)$add_time;  //购买产品未超过本地仓库存，则比武汉仓覆盖国家发货时间+1天（美加墨新西兰）
                }
            }else{
                $ship_day = $origin_day + (int)$add_time; //转运时间-工作日
            }
            if($standard_product_days && empty($attr_arr) && $buy_product_qty > $cn_qty){ //标准产品购买数量超过武汉仓库存则调取采购交期
                if(!in_array($country_iso_code,array('us','ca','mx','nz','pr')) && !$sg_warehouse){
                    $ship_day = get_specific_date_of_days($standard_product_days+$origin_day,2,$spring_days,$country_iso_code)+$festival_day;
                }else{
                    $ship_day = get_specific_date_of_days($standard_product_days,2,$spring_days,$country_iso_code);
                }
            }else{ //定制产品武汉仓有库存，则直接发货(定制产品不按照数量调取交期) && 标准产品购买数量小于武汉仓库存直接发货
                if(!in_array($country_iso_code,array('us','ca','mx','nz','pr')) && !$sg_warehouse){
                    $ship_day = get_specific_date_of_days($ship_day,2,$spring_days,$country_iso_code)+$festival_day;
                }else{
                    $ship_day = get_specific_date_of_days($ship_day,2,$spring_days,$country_iso_code);
                }
            }
            if($cn_qty){
                $ship_day = $ship_day+$spring_days;  //加上春节假期，顺延周末(春节假包含周末)

                //周六达快递必须周六送达
                $sat = 0;
                if($shipping_method && in_array($shipping_method,['saturdaydeliveryzones','dhlsaturdayzones'])){
                    for($i=0;$i<8;$i++){
                        $d = getTime('D',strtotime('+'.($ship_day+$i).' days'),$country_code,"",true,$area);
                        if($d == 'Sat'){
                            $sat = $i;
                        }
                    }
                    $ship_day = $ship_day + $sat;
                }else{
                    //收货时间转运加上节假日  非重货
                    if(!(in_array($country_iso_code,array('us','ca','mx','nz','pr')) && $sg_warehouse) && !$delayHasHeavy){
                        $ship_day += get_festival_day($country_iso_code,$ship_day);
                        $ship_day = postponed_weekend($ship_day,$area,$country_iso_code);  //遇到节假日刚好是周五，周末顺延
                    }
                }

                if ($ship_day) {
                    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                        return array("date"=> getTime('D.', strtotime('+'. $ship_day . ' days'),$country_code,"",true,$area).' '.getTime('j', strtotime('+'. $ship_day . ' days'),$country_code).getLast(getTime('j', strtotime('+'. $ship_day . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $ship_day . ' days'),$country_code,"",true,$area),"time"=>$ship_day);
                    }else{
                        return array("date"=>get_date_product_delivery(getTime('D. M. j', strtotime('+'. $ship_day . ' days'),$country_code,"",true,$area),$_SESSION['languages_id'],2),"time"=>$ship_day);
                    }
                }
            }else{
                if ($ru_warehouse) {
                    $origin_day=7;
                }elseif($delayHasHeavy && !all_german_warehouse("country_code",$country_iso_code) && !in_array($country_iso_code, ['au'])) {  //欧洲仓和澳大利亚全面转运  其它仓重货直发
                    $origin_day = 0;
                }else{
                    $origin_day=5;
                }
                if($origin_day){
                    $all_origin = get_specific_date_of_days($origin_day,2,$spring_days,$country_iso_code);
                    $festival_day = get_festival_day($country_iso_code,$all_origin);
                }
                if(in_array($country_iso_code,array('us','ca','mx','nz','pr')) || $sg_warehouse){
                    $products_ship_time2 = $products_ship_time;
                }else{
                    $products_ship_time2 = $products_ship_time+$origin_day;
                }
                if($standard_product_days){
                    if(!in_array($country_iso_code,array('us','ca','mx','nz','pr')) && !$sg_warehouse){
                        $products_ship_time2 = get_specific_date_of_days($standard_product_days+$origin_day,2,$spring_days,$country_iso_code)+$festival_day;
                    }else{
                        $products_ship_time2 = get_specific_date_of_days($standard_product_days,2,$spring_days,$country_iso_code);
                    }
                }else{
                    if(!in_array($country_iso_code,array('us','ca','mx','nz','pr')) && !$sg_warehouse){
                        $products_ship_time2 = get_specific_date_of_days($products_ship_time2,2,$spring_days,$country_iso_code)+$festival_day;
                    }else{
                        $products_ship_time2 = get_specific_date_of_days($products_ship_time2,2,$spring_days,$country_iso_code);
                    }
                }
                $products_ship_time2 = $products_ship_time2+$spring_days;

                //周六达快递必须周六送达
                $sat = 0;
                if($shipping_method && in_array($shipping_method,['saturdaydeliveryzones','dhlsaturdayzones'])){
                    for($i=0;$i<8;$i++){
                        $d = getTime('D',strtotime('+'.($products_ship_time2+$i).' days'),$country_code,"",true,$area);
                        if($d == 'Sat'){
                            $sat = $i;
                        }
                    }
                    $products_ship_time2 = $products_ship_time2 + $sat;
                }else{
                    //收货时间转运加上节假日
                    if(!(in_array($country_iso_code,array('us','ca','mx','nz','pr')) && $sg_warehouse) && !$delayHasHeavy){
                        $products_ship_time2 += get_festival_day($country_iso_code,$products_ship_time2);
                        $products_ship_time2 = postponed_weekend($products_ship_time2,$area,$country_iso_code);  //遇到节假日刚好是周五，周末顺延
                    }
                }


                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    return array("date"=> getTime('D.', strtotime('+'. $products_ship_time2 . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $products_ship_time2 . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $products_ship_time2 . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $products_ship_time2 . ' days'),$country_code,"",true,$area),"time"=>$products_ship_time2);
                }else{
                    return array("date"=>get_date_product_delivery(getTime('D. M. j', strtotime('+'. $products_ship_time2 . ' days'),$country_code,"",true,$area),$_SESSION['languages_id'],2),"time"=>$products_ship_time2);
                }
            }

        }else{
            if($standard_product_days){
                $products_ship_time = get_specific_date_of_days($standard_product_days,2,$spring_days);
            }else{
                $products_ship_time = get_specific_date_of_days($products_ship_time,2,$spring_days);
            }
            $products_ship_time = $products_ship_time+$spring_days;

            if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                $ship_date = getTime('D.', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area);
            }elseif($_SESSION['languages_code'] == 'ru'){
                $ship_date = getTime('d/m/Y', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area);
            }else{
                $ship_date = get_date_product_delivery(getTime('D. M. j', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area),$_SESSION['languages_id'],2);
            }
            return array("date"=> $ship_date,"time"=>$products_ship_time);
        }
    }
    return array("date"=>FS_SHIP_ESTIMATED,"time"=>0);
}

/**
 * @param $products_id
 * @param $products_instock_status
 * @param string $countries_code_2
 * @param int $buy_product_qty
 * @param array $attr_arr
 * @param string $is_heavy
 * @param array $en_us_data  $en_us_data = array('is_en_us' => 英文站国家为美国,波多黎各,'transport_time' => 运输时效+2个工作日,'shipping_method' => 运输方式 )
 * @return string
 */
function zen_get_products_instock_shipping_date_of_products_id($products_id,$products_instock_status,$countries_code_2="",$buy_product_qty=1,$attr_arr=array(),$is_heavy='',$en_us_data=[],$over_stock_line=false){
    global $db;
    $sql = "SELECT `products_instock_show_statu`  FROM `products` WHERE `products_id`= '" . (int)$products_id . "'";
    $products_quantity = $db->Execute($sql);
    if ($products_instock_status&&$products_instock_status !=FS_OUT_OF_STOCK && $products_instock_status !=FS_SHIP_AVAI && $products_instock_status !=FS_SHIP_DEVE&&$products_instock_status!==0&&!$over_stock_line) {
        return '<b>'. FS_SHIP_SAME_DAY .'</b>';

    }
    if ($products_quantity->fields['products_instock_show_statu'] == '3') {
        return 'N/A';
    }
    if ($products_quantity->fields['products_instock_show_statu'] == '4') {
        return '--';
    }

    if ($products_quantity->fields['products_instock_show_statu'] == '2' || $products_quantity->fields['products_instock_show_statu'] == '1') {
        $area = $db->Execute("select time_zone from country_time_zone where code='".strtoupper($countries_code_2)."' limit 1");
        $area = $area->fields['time_zone'];
        $area = $area ? $area : "";

        $cn_qty = zen_get_current_qty($products_id, "CN", true);//武汉仓库存
        //本地仓无库存标准产品动态交期获取 Dylan 2019.8.13 Add 优先调取
        $standard_product_days=0;

        //(定制产品不按照数量调取交期 调取最小数量交期)
        if($attr_arr){
            //根据属性匹配虚拟id
            $related_id = attribute_matching_fictitious_id($products_id,$attr_arr);
            $standard_product_days = get_standard_product_days($related_id,1);

            //如果匹配到的虚拟id没有交期，则调取原id的交期
            if($related_id != $products_id && !$standard_product_days) {
                $standard_product_days = get_standard_product_days($products_id,1);
            }
        }


        //标准产品根据库存数量调取对应交期
        if($buy_product_qty > $cn_qty && empty($attr_arr)){
            $standard_product_days = get_standard_product_days($products_id,$buy_product_qty);
        }

        if(!$standard_product_days){
            $products_ship_time = zen_get_product_deliver_time($products_id);
            if(!$products_ship_time){
                if(in_array($products_id,array(69219,69220))){
                    $products_ship_time = 30;
                }else{
                    $products_ship_time = 5;
                }
            }
        }

        //$is_spring_festival = false;
        $spring_days = get_spring_festival_holiday();//春节假期
        $country_iso_code = strtolower($countries_code_2);
        //澳洲仓无库存新西兰从武汉直发 dylan 2019.7.9
        $sg_warehouse = singapore_warehouse("country_code",$countries_code_2);

        $ru_warehouse = ru_warehouse("country_code",$countries_code_2);
        $transport_show = FS_SHIP_ESTIMATED;
        $shipping_method = '';

        $insideTime = 0;
        //2天内部处理时间
        if(in_array($country_iso_code,['us','pr'])){
            if($cn_qty){
                $insideTime = 1; //国内有库存已经加了1天时差
            }else{
                $insideTime = 2;
            }
        }

        $add_time = 0;
        if($en_us_data['transport_time']){
            $add_time = (int)$en_us_data['transport_time']; //运输时效
            $shipping_method = $en_us_data['shipping_method'];
            $transport_show = FS_FOR_FREE_SHIPPING_GET_ARRIVE.' ';
            //自提或者没有运输方式 展示ship on时间
            if ($shipping_method == 'selfreferencezones' || empty($shipping_method)) {
                $transport_show = FS_SHIP_ESTIMATED;
            }
        }
        $add_time = $add_time + $insideTime; //运输时效+内部处理时间
        $festival_day = 0;
        if((in_array($countries_code_2,array('US','CA','MX',"AU","NZ","PR"))||FS_IS_SPRING==1) || all_german_warehouse('country_code',$countries_code_2) || $sg_warehouse || $ru_warehouse){
            if($cn_qty){
                if ($is_heavy && !all_german_warehouse('country_code',$countries_code_2) && !in_array($country_iso_code, ['au']) && !$ru_warehouse) {
                    $origin_day = 0; //欧洲仓和澳大利亚,俄罗斯全面转运  其它仓重货直发
                } else {
                    $origin_day = 7; //转运时间
                }
                if($origin_day){
                    $all_origin = get_specific_date_of_days($origin_day,2,$spring_days)+$spring_days;
                    $festival_day = get_festival_day($countries_code_2,$all_origin);
                }

                //购买标准产品数量超过武汉仓库存则调取采购交期
                if($standard_product_days && empty($attr_arr) && $buy_product_qty > $cn_qty){
                    if(in_array(strtolower($country_iso_code),array('us','ca','mx','nz','pr')) || $sg_warehouse){
                        $ship_day = $standard_product_days+(int)$add_time;
                    }else{
                        $ship_day = $standard_product_days+$origin_day+(int)$add_time;
                    }
                }else{ //定制产品武汉仓有库存，则直接发货(定制产品不按照数量调取交期) && 标准产品购买数量小于武汉仓库存直接发货
                    if(in_array(strtolower($country_iso_code),array('us','ca','mx','nz','pr')) || $sg_warehouse){
                        if($sg_warehouse){
                            $ship_day = (int)$add_time; //新加坡仓覆盖国家，武汉仓有库存和本地发货时间一样
                        }else{
                            $ship_day = 1 + (int)$add_time;
                        }
                    }else{
                        $ship_day = $origin_day+(int)$add_time;
                    }
                }
                //添加周末
                if(!in_array(strtolower($country_iso_code),array('us','ca','mx','nz','pr')) && !$sg_warehouse){
                    $ship_day = get_specific_date_of_days(($ship_day),2,$spring_days)+$festival_day;
                }else{
                    $ship_day = get_specific_date_of_days($ship_day,2,$spring_days);
                }
                $ship_day = $ship_day + $spring_days;

                //周六达快递必须周六送达
                $sat = 0;
                if($shipping_method && in_array($shipping_method,['saturdaydeliveryzones','dhlsaturdayzones'])){
                    for($i=0;$i<8;$i++){
                        $d = getTime('D',strtotime('+'.($ship_day+$i).' days'),$countries_code_2,"",true,$area);
                        if($d == 'Sat'){
                            $sat = $i;
                        }
                    }
                    $ship_day = $ship_day + $sat;
                }else{
                    //转运需要加上节假日
                    if(!(in_array($country_iso_code,array('us','ca','mx','nz','pr')) || $sg_warehouse) && !$is_heavy){
                        $ship_day += get_festival_day($countries_code_2,$ship_day);
                        $ship_day = postponed_weekend($ship_day,$area,$countries_code_2);  //遇到节假日刚好是周五，周末顺延
                    }
                }

                if ($ship_day) {
                    if(in_array($_SESSION['languages_code'],array('uk','au','dn'))){
                        $ship_date = getTime('D. ', strtotime('+' . $ship_day . ' days'), $countries_code_2,"",true,$area).' '.getTime('j', strtotime('+' . $ship_day . ' days'), $countries_code_2,"",true,$area).getLast(getTime('j', strtotime('+' . $ship_day . ' days'), $countries_code_2,"",true,$area)).' '.getTime('M.', strtotime('+' . $ship_day . ' days'), $countries_code_2,"",true,$area);
                    }else{
                        $ship_date = getTime('D. M. j', strtotime('+' . $ship_day . ' days'), $countries_code_2,"",true,$area);
                    }
                } else {
                    $ship_date = 'ship today';
                }
            }else{
                if ($ru_warehouse) {
                    $origin_day = 7;
                } elseif ($is_heavy && !all_german_warehouse('country_code',$countries_code_2) && !in_array($country_iso_code, ['au'])) {
                    $origin_day=0;  //欧洲仓全面转运  其它仓重货直发
                } else {
                    $origin_day = 5; //转运时间
                }
                if($origin_day){
                    $all_origin = get_specific_date_of_days($origin_day,2,$spring_days)+$spring_days;
                    $festival_day = get_festival_day($countries_code_2,$all_origin);
                }
                //添加周末
                if($standard_product_days){
                    if(in_array($country_iso_code,array('us','ca','mx','nz','pr')) || $sg_warehouse){
                        $products_ship_time2 = get_specific_date_of_days(($standard_product_days+(int)$add_time),2,$spring_days);
                    }else{//采购后台存在预售产品备货时间
                        $products_ship_time2 = get_specific_date_of_days(($standard_product_days+$origin_day+(int)$add_time),2,$spring_days)+$festival_day;
                    }
                }else{
                    if(in_array($country_iso_code,array('us','ca','mx','nz','pr')) || $sg_warehouse){
                        $products_ship_time2 = get_specific_date_of_days(($products_ship_time+(int)$add_time),2,$spring_days);
                    }else{
                        $products_ship_time2 = get_specific_date_of_days(($products_ship_time+$origin_day+(int)$add_time),2,$spring_days)+$festival_day;
                    }
                }
                $products_ship_time2 = $products_ship_time2 + $spring_days;  //加上春节假期

                //周六达快递必须周六送达
                $sat = 0;
                if($shipping_method && in_array($shipping_method,['saturdaydeliveryzones','dhlsaturdayzones'])){
                    for($i=0;$i<8;$i++){
                        $d = getTime('D',strtotime('+'.($products_ship_time2+$i).' days'),$countries_code_2,"",true,$area);
                        if($d == 'Sat'){
                            $sat = $i;
                        }
                    }
                    $products_ship_time2 = $products_ship_time2 + $sat;
                    $transport_show = FS_FOR_FREE_SHIPPING_GET_ARRIVE.' '; //周六达 展示收货时间
                }else{
                    //转运需要加上节假日
                    if(!(in_array($country_iso_code,array('us','ca','mx','nz','pr')) || $sg_warehouse) && !$is_heavy){
                        $products_ship_time2 += get_festival_day($countries_code_2,$products_ship_time2);
                        $products_ship_time2 = postponed_weekend($products_ship_time2,$area,$countries_code_2);  //遇到节假日刚好是周五，周末顺延
                    }
                }

                if ($products_ship_time2) {
                    if(in_array($_SESSION['languages_code'],array('uk','au','dn'))){
                        $ship_date = getTime('D. ', strtotime('+'. $products_ship_time2 . ' days'),$countries_code_2,"",true,$area).' '.getTime('j', strtotime('+' . $products_ship_time2 . ' days'), $countries_code_2,"",true,$area).getLast(getTime('j', strtotime('+' . $products_ship_time2 . ' days'), $countries_code_2,"",true,$area)).' '.getTime('M.', strtotime('+' . $products_ship_time2 . ' days'), $countries_code_2,"",true,$area);
                    }else{
                        $ship_date = getTime('D. M. j', strtotime('+'. $products_ship_time2 . ' days'),$countries_code_2,"",true,$area);
                    }
                } else {
                    $ship_date = 'ship today';
                }
            }
        }else{
            if($standard_product_days){
                $products_ship_time = get_specific_date_of_days($standard_product_days+(int)$add_time,2,$spring_days);
            }else{
                $products_ship_time = get_specific_date_of_days($products_ship_time+(int)$add_time,2,$spring_days);
            }
            $products_ship_time = $products_ship_time + $spring_days; //加上春节假期

            if ($products_ship_time) {
                if(in_array($_SESSION['languages_code'],array('uk','au','dn'))){
                    $ship_date = getTime('D. ', strtotime('+'. $products_ship_time . ' days'),$countries_code_2,"",true,$area).' '.getTime('j', strtotime('+' . $products_ship_time . ' days'), $countries_code_2,"",true,$area).getLast(getTime('j', strtotime('+' . $products_ship_time . ' days'), $countries_code_2,"",true,$area)).' '.getTime('M.', strtotime('+' . $products_ship_time . ' days'), $countries_code_2,"",true,$area);
                }else{
                    $ship_date = getTime('D. M. j', strtotime('+'. $products_ship_time . ' days'),$countries_code_2,"",true,$area);
                }
            } else {
                $ship_date = 'ship today';
            }
        }
        if($ship_date){
            if ($ship_date == 'ship today') {
                return  ' <span class="pid_ship_date">'.ucfirst(strtolower(FS_SHIP_TODAY)).'</span>';
            } else {
                return  $transport_show.' <span class="pid_ship_date">'.get_date_product_delivery($ship_date,$_SESSION['languages_id'],2).'</span>';
            }
        }else{
            return '';
        }
    }
    return '';
}


/**
 * @param string $country_code 国家
 * @param array $en_us_data = array('is_en_us' => 英文站国家为美国,波多黎各,'transport_time' => 运输时效+2个工作日,'shipping_method' => 运输方式 )
 * @return array
 */
function zen_get_products_delivery_time($country_code="",$en_us_data=[]){
    $country_code = $country_code ? strtoupper($country_code) : strtoupper($_SESSION['countries_iso_code']);
    $transport_time = (int)$en_us_data['transport_time']; //运输时效
    $day = 0;
    $area = fs_get_data_from_db_fields('time_zone','country_time_zone','code="'.$country_code.'"','limit 1');
    $area = $area ? $area : "";
    $shipping_methods = $en_us_data['shipping_method'] ? $en_us_data['shipping_method'] : "";
    if($en_us_data['is_en_us']){
        $transport_time = (int)$en_us_data['transport_time'];
    }
    $extensionTime=0;
    //除国内仓以外 如果当地时间超过本地发货时间+1day (针对本地仓有库存)
    if ($en_us_data['warehouse'] && getWarehouseDeliveryDeadline($en_us_data['warehouse'], $country_code)) {
        $extensionTime=1;
    }

    $spring_days = 0;
    if($en_us_data['warehouse'] == 2){
        $spring_days = get_spring_festival_holiday();//春节假期
    }

    $festival_day = get_festival_day($country_code);
    if($festival_day){
        $festival_or_weekend = (int)$festival_day; //节假日
    }elseif($spring_days) {
        $festival_or_weekend = 0;
    } else {
        $festival_or_weekend = postponed_weekend(0,$area,$country_code); // 遇到周末顺延
    }
    if($transport_time){
        $day = $transport_time+$extensionTime; //工作日
        $delivery_status = FS_FOR_FREE_SHIPPING_GET_ARRIVE;
    }else{
        $day = $extensionTime;
        $delivery_status = FS_SHIP_ESTIMATED;
    }

    $day = get_specific_date_of_days($day,2,$festival_or_weekend+$spring_days)+$festival_or_weekend+$spring_days;

    if($day){
        $day += get_festival_day($country_code,$day);
        $day = postponed_weekend($day,$area,$country_code); // 遇到周末顺延
        $date = get_date_time_format($day,$country_code,$area);
    }else{
        $date = get_date_time_format($festival_or_weekend,$country_code,$area);   //没有获取到具体时效
        if(!$festival_or_weekend){
            $day = $extensionTime;
            $date = $extensionTime ? get_date_time_format($day,$country_code,$area) : '';
            $delivery_status = $extensionTime ? FS_SHIP_ESTIMATED : FS_SHIP_TODAY;
        }

        //周六达快递只在周六送货
        if(in_array($shipping_methods,array('saturdaydeliveryzones','dhlsaturdayzones'))){
            for($i=0;$i<8;$i++){
                $d = getTime('D',strtotime('+'.$i.' days'),$country_code,"",true,$area);
                if($d == 'Sat'){
                    $date = get_date_time_format($i,$country_code,$area);
                    $delivery_status = FS_FOR_FREE_SHIPPING_GET_ARRIVE;
                }
            }
        }
        if($shipping_methods == 'grabexpresszones'){
            $date = get_date_time_format($festival_or_weekend,$country_code,$area);   //没有获取到具体时效
        }
    }
    //$date：具体日期 ，$delivery_status：交期表达方式 ，$day：天数
    return array('date' => $date, 'expression' => $delivery_status, 'day' => $day);
}

/**
 * Note: 对应仓库当天截止发货时间
 * @author: Dylan
 * @Date: 2020/8/5
 *
 * @param string $warehouse
 * @return bool
 */
function getWarehouseDeliveryDeadline($warehouse='', $country_code=''){
    $isCurrentDeliver = false;
    $country_code = $country_code ? strtoupper($country_code) : strtoupper($_SESSION['countries_iso_code']);
    if ($warehouse != 2) {
        $date = getTime("Y-m-d H:i:s", "", $country_code);
        if ($date) {
            $current_time = strtotime($date);
            $date_arr = explode(" ", $date);
            $ymd = $date_arr[0];
        } else {
            $current_time = time();
            $ymd = date('Y-m-d', time());
        }
        switch ($warehouse) {
            case 20:
                $de_time = $ymd .' 16:30:00';
                $end_time = strtotime($de_time);
                break;
            case 40:
                $us_time = $ymd. ' 17:00:00';
                $end_time = strtotime($us_time);
                break;
                break;
            case 67:
                $ru_time = $ymd. ' 16:30:00';
                $end_time = strtotime($ru_time);
                break;
            case 71:
                $sg_time = $ymd. ' 15:30:00';
                $end_time = strtotime($sg_time);
                break;
            case 37:
                $au_time = $ymd. ' 15:00:00';
                $end_time = strtotime($au_time);
                break;
        }

        if ($current_time >= $end_time) {
            $isCurrentDeliver = true;
        } else {
            $isCurrentDeliver = false;
        }
    }
    return $isCurrentDeliver;
}

/**
 * @param string $local_warehouse  仓库id
 * @param string $shipping_method   运输方式
 * @param string $country_code  国家code
 * @param bool $has_local_instock  本地仓是否有库存
 * @param array $local_data  本地有库存的条件数据
 * @return int
 */
function zen_get_transport_limitation($local_warehouse="",$shipping_method="",$country_code="",$has_local_instock=false,$local_data=[]){
    $settingDay = 0;

    /*$add_time = 0;
    if(!$has_local_instock && $local_warehouse==40 && in_array($country_code,['US','PR'])){ //gsp覆盖国家本地无库存新增2天内部处理时间
        $add_time = 2;
    }*/

    $default_shipping_methods = strtolower($shipping_method);
    $country_code = $country_code ? strtoupper($country_code) : strtoupper($_SESSION['countries_iso_code']);

    if($default_shipping_methods){ //本地仓无库存的运输时效
        if(!in_array($default_shipping_methods,['upsltlzones','upsgroundeastzones'])){
            if(in_array($country_code,['PR'])){
                $settingDay = fs_get_data_from_db_fields('shipping_time', 'shipping_effectiveness', 'shipping_methods = "' . $default_shipping_methods . '" AND code = "US" limit 1');
            }else{
                $settingDay = fs_get_data_from_db_fields('shipping_time', 'shipping_effectiveness', 'shipping_methods = "' . $default_shipping_methods . '" AND code = "'.$country_code.'" limit 1');
            }
        }

        $settingDay = $settingDay ? $settingDay : 0;
        if(!$settingDay){
            if(preg_match("/ups2day|fedex2day/i",$default_shipping_methods)){
                $settingDay = 2;
            }elseif (preg_match("/upsovernight|fedexovernight|fedexpriorityovernight|fedexsameday/i",$default_shipping_methods)){
                $settingDay = 1;
            }elseif (preg_match("/dhlazones|fedex3dayzones|upsazones/i",$default_shipping_methods)){
                $settingDay = 3;
            }elseif (in_array($default_shipping_methods,array('upsexpresspluszones','ups2daysamzones'))){
                $settingDay = 1;
            }
            if($country_code == 'PR'){
                if(in_array($default_shipping_methods,['ups2dayseastzones'])){
                    $settingDay = 2;
                }elseif (in_array($default_shipping_methods,['upsgroundeastzones'])){
                    $settingDay = 3;
                }elseif (in_array($default_shipping_methods,['upsovernighteastzones'])){
                    $settingDay = 1;
                }
            }
        }
    }
    if(!$settingDay){
        $day = 0;
        $post_code = $local_data['post_code'] ? $local_data['post_code'] : '';
        $is_cabinet = false;
        $is_cabinet_pid = '';
        $country_id = $local_data['country_id'] ? $local_data['country_id'] : '';
        if($local_data['local_products']){
            foreach ($local_data['local_products'] as $value){
                if(in_array($value,[73579, 73958])){
                    $is_cabinet_pid = (int)$value;
                }
            }
        }
        if(!empty($is_cabinet_pid) && seattle_warehouse("country_code",$country_code)){
            if($country_code == 'US'){
                if(!empty($post_code)){
                    $state = fs_get_data_from_db_fields('states', 'countries_to_zip', 'zip = "' . $post_code . '"');
                }
                if(!empty($state)) {
                    $cabinet = fs_get_data_from_db_fields('id', 'shipping_ups_ltl', 'products_id = ' . $is_cabinet_pid . ' AND country_id = 223 AND (state = "' . $state . '" OR state_abb = "' . $state . '")');
                    $is_cabinet = $cabinet ? true : false;
                }
            }else{
                $is_cabinet = $country_code == 'PR' ? false : true;
            }
        }
        switch ($country_code){
            case "US":
                if(!empty($post_code)) {
                    if ($is_cabinet && $is_cabinet_pid && $country_id && $state) {
                        $day = fs_get_data_from_db_fields('delivery_date', 'shipping_ups_ltl', 'products_id =' . $is_cabinet_pid . ' AND country_id = "'.$country_id.'" AND state = "' . $state . '"');
                    } else {
                        $day = fs_get_data_from_db_fields('timeliness_md', 'countries_to_zip', 'zip ="' . $post_code . '"','limit 1');
                    }
                }else{
                    $day = 3;
                }
                break;
            case in_array($country_code,array("MX","CA")):
                if ($is_cabinet && $is_cabinet_pid && $country_id && $state) {
                    if(!empty($this->state)) {
                        $day = fs_get_data_from_db_fields('delivery_date', 'shipping_ups_ltl', 'products_id =' . $is_cabinet_pid . ' AND country_id = "' . $country_id . '" AND (state = "' . $state . '" OR state_abb = "' . $state . '")');
                    }
                    $delivery_default = array(
                        '38' => ['73579' => 4, '73958' => 4],
                        '138' => ['73579' => 7, '73958' => 7]
                    );
                    $day = !empty($day) ? $day : $delivery_default[$country_id][$is_cabinet_pid];
                }else{
                    $day = 3;
                }
                break;
        }
        $settingDay = $day;
    }
    if(in_array($default_shipping_methods,array('saturdaydeliveryzones','dhlsaturdayzones','customzones'))){
        $settingDay = 0; //周六达快递运输时效给0，其它地方做了处理
    }
    return $settingDay;
}


/**
 * @Notes:
 *
 * @author: Dylan
 * @Date: 2020/9/29
 * @Time: 16:49
 * @param array $data
 * @return array
 */
function zen_get_checkout_delivery($data = []){
    $local_warehouse_title = $local_time = '';
    if (is_array($data) && $data){
        $shipping_local = $data['shipping_local'];
        $local_products = $data['local_products'];
        $order = $data['order'];
        $warehouse = $data['warehouse'];
        $country_code = $data['country_code'];

        if($shipping_local){
            $shipping_method_arr = explode('_',$shipping_local['id']);
            $shipping_method = $shipping_method_arr[0];
        }
        $new_local_products = $local_data = [];

        foreach ($local_products as $v){
            $new_local_products[] = $v['id'];
        }

        if ($shipping_method != 'selfreferencezones') {
            $local_data = array(
                'post_code' => $order->delivery['postcode'],
                'state' => $order->delivery['state'],
                'country_id' => $order->delivery['country_id'],
                'local_products' => $new_local_products
            );
            //运输时间
            $transport_time = zen_get_transport_limitation($warehouse,$shipping_method,$country_code,true,$local_data);
            $en_us_data = array(
                'warehouse' => $warehouse,
                'is_en_us' => true,
                'transport_time' => $transport_time, //运输时间+2个工作日
                'shipping_method' => $shipping_method,
            );
            $time_info = zen_get_products_delivery_time($country_code,$en_us_data);
            $sat = 0;
            if(in_array($shipping_method,array('saturdaydeliveryzones','dhlsaturdayzones'))){
                for($i=0;$i<8;$i++){
                    $d = getTime('D',strtotime('+'.($time_info['day']+$i).' days'),$country_code,"",true);
                    if($d == 'Sat'){
                        $sat = $i;
                    }
                }
            }
            $pause = in_array($_SESSION['languages_code'],['es','mx']) ? '' : FS_EMAIL_PAUSE;
            if (!$transport_time) {
                $pause = '';
                if ($warehouse == 40) {
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SHIP_US;
                } elseif ($warehouse == 20) {
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SHIP_DE;
                } elseif ($warehouse == 37) {
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SHIP_AU;
                } elseif ($warehouse == 2) {
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SHIP_CN;
                } elseif ($warehouse == 67) {
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SHIP_RU;
                } elseif ($warehouse == 71) {
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SHIP_SG;
                }
            }
            $local_time = $time_info['expression'].($time_info['day'] ? " <span class='fs-new-Fontweight600'>".get_date_time_format($time_info['day']+$sat,$country_code)."</span>".$pause : "");
        } else {
            if ($warehouse == 40) {
                $local_time = FS_WAREHOUSE_AREA_TIME_43;
            } elseif ($warehouse == 20) {
                $local_time = FS_WAREHOUSE_AREA_TIME_44;
            } elseif ($warehouse == 37) {
                $local_time = FS_WAREHOUSE_AREA_TIME_45;
            } elseif ($warehouse == 2) {
                $local_time = FS_WAREHOUSE_AREA_TIME_46;
            } elseif ($warehouse == 67) {
                $local_time = FS_WAREHOUSE_AREA_TIME_48;
            } elseif ($warehouse == 71) {
                $local_time = FS_WAREHOUSE_AREA_TIME_47;
            }
        }
    }
    return [
        'local_time' => $local_time,
        'local_warehouse_title' => $local_warehouse_title,
        'shipping_method' => $shipping_method,
    ];
}


function zen_get_is_cabinet(){
    $post_code = $this->post_code ? : $this->shipping_postCode;
    if(in_array($this->pid, array(73579, 73958)) && $this->qty){
        if($this->country_code == 'US'){
            $post_code = empty($post_code) ? 10010 : $post_code;
            $state = fs_get_data_from_db_fields('states', 'countries_to_zip', 'zip = "' . $post_code . '"');
            if(!empty($state)) {
                $cabinet = fs_get_data_from_db_fields('id', 'shipping_ups_ltl', 'products_id = ' . $this->pid . ' AND country_id = 223 AND (state = "' . $state . '" OR state_abb = "' . $state . '")');
                $this->is_cabinet = $cabinet ? true : false;
                $this->state = $state;
            }
        }else{
            $this->is_cabinet = $this->country_code == 'PR' ? false : true;
        }
    }
}




//调用国内库存数量
function fs_products_instock_qty_domestic_inventory_warehouse($id){
    global $db;

    $related_pid = zen_get_products_related_model($id);   //关联主产品

    $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = ".(int)$related_pid." and warehouse in(1,2,5,6,7,10,11)";
    $instock = $db->Execute($sql);
    $total_qty = 0;
    if($instock->fields['total_qty']<1){
        if($related_pid){
            $customized_id = fs_get_data_from_db_fields('customized_id','products_instock_customized_related','products_id= '.$related_pid,' limit 1');
            if($customized_id){
                $sql = "SELECT SUM(instock_qty) AS total_qty FROM products_instock WHERE products_id = ".(int)$customized_id." and warehouse in(1,2,5,6,7,10,11)";
                $products_instock_qty = $db->Execute($sql);
                $total_qty = $products_instock_qty->fields['total_qty'];
            }
        }
    }else{
        $total_qty = $instock->fields['total_qty'];
    }
    return $total_qty;
}
//调用本地库存
function fs_products_instock_local_qty_warehouse($id,$warehouse){
    global $db;
    $id = fs_get_custom_related_standard_products($id);
    $related_pid = zen_get_products_related_model($id);   //关联主产品
    $instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =" . $related_pid . " and warehouse = " . $warehouse);
    $total_qty = 0;
    if($instockSQL->fields['products_instock_id']){
        $seattle_lock_front = fs_get_data_from_db_fields('sum(qty)','products_instock_orders','instock_id='.$instockSQL->fields['products_instock_id'],'');
        $seattle_lock_back = fs_get_data_from_db_fields('sum(change_qty)','products_instock_history_temp','products_instock_id='.$instockSQL->fields['products_instock_id'].' and type=0 and warehouse='.$warehouse.'','');
        $total_qty = $instockSQL->fields['instock_qty'] - $seattle_lock_back-$seattle_lock_front;
    }
    return $total_qty;
}
//定制产品总库存

function fs_get_quickfinder_products_instock($products_id,$i=0){
    global $db,$countries_code_2;
    //if($instockQty==0){
    $dot = "";
    if(german_warehouse("country_code",$countries_code_2)){
        $instockQty = zen_get_current_qty($products_id,"DE",false);
    }elseif(seattle_warehouse("country_code",$countries_code_2)){
        $instockQty = zen_get_current_qty($products_id,"US",false)+zen_get_current_qty($products_id,"US-ES",false);
    }elseif($countries_code_2=="AU"){
        $instockQty = zen_get_current_qty($products_id,"AU",false);
    }else{
        $instockQty = zen_get_current_qty($products_id,"CN",true);
    }

    //}
    if($instockQty==1){
        return "<i></i>".$instockQty.FS_SHIP_PC;
    }elseif ($instockQty>1){
        return "<i></i>".$instockQty.FS_SHIP_PCS;
    }else{
        return "";
    }
}

//quickfinder    速度很慢
function fs_get_quickfinder_products_instock_new($products_id,$i=0){
    require_once DIR_WS_CLASSES . 'shipping_info.php';
    global $db,$countries_code_2;
    if($products_id){
        $shippingInfo = new ShippingInfo(array('pid'=>$products_id));
        $SInstockPCS  = $shippingInfo->get_all_qf_qty();
    }
    return $SInstockPCS;
}

/**
 * 查询产品的的库存; Bona.Guo 2021/3/10 17:52
 * @param string $proIds 查询的多个产品id
 * @return array
 *
 */
function fs_get_quickfinder_products_instock_arr($proIds){

    $products=explode(',',$proIds);

    $ProductsModel = new ProductInventoryService();
    $now_warehouse_code = strtoupper(get_warehouse_by_code($_SESSION['countries_iso_code']));

    //当查询库存的时候，若当前仓库无库存则显示CN仓库存，直接查当前仓和CN仓两个仓的数据；
    $now_warehouse = [
        $now_warehouse_code => $ProductsModel->WarehouseEnum[$now_warehouse_code],
        'CN' => 1
    ];
    $currentQty_date=$ProductsModel->setProducts($products, $now_warehouse)->calculateInventory(0);

    return $currentQty_date;
}

/**
 * @Notes: 返回库存显示信息 Bona.Guo 2021/3/10 17:52
 * @param Array $instockArr 库存数组信息
 * @return string
 */
function fs_get_Index_Instock_Qty_Html($instockArr)
{
    $now_warehouse_code = strtoupper(get_warehouse_by_code($_SESSION['countries_iso_code']));

    //当前仓库库存
    $instockQty = $instockArr[$now_warehouse_code]['currentQty'];

    //若无库存则显示CN仓库存
    if ($instockQty < 1) {
        $instockQty = $instockArr['CN']['currentQty'];
    }

    return $instockQty;
}

function zen_get_product_length_instock($pid,$length){
    global $db;
    $instock = $db->Execute("select pil.products_instock_id 
                          from  products_instock_length as pil left join products_instock as pi on(pil.products_instock_id = pi.products_instock_id)
 where pil.products_id = ".(int)$pid." and length = '".$length."' and pil.products_instock_id = pi.products_instock_id");
    if($instock->fields['products_instock_id']){
        return '<i>.</i>';
    }
}

function zen_get_product_attribute_instock($pid,$vid){
    global $db;
    $instock = $db->Execute("select pia.products_instock_id from 
                          products_instock_attributes as pia left join products_instock as pi on(pia.products_instock_id = pi.products_instock_id)
 where pia.products_id = ".(int)$pid." and options_values_id = '".$vid."' and pia.products_instock_id = pi.products_instock_id");
    if($instock->fields['products_instock_id']){
        return '<i></i>';
    }
}

function zen_get_product_compatible_attribute_instock($pid,$vid){
    global $db;
    $instock = $db->Execute("select pic.products_instock_id 
                          from products_instock_attributes_compatible  as pic left join products_instock as pi on(pic.products_instock_id = pi.products_instock_id)
 where pic.products_id = ".(int)$pid." and options_values_id = '".$vid."' and pic.products_instock_id = pi.products_instock_id");
    if($instock->fields['products_instock_id']){
        return '<i></i>';
    }
}

//特定产品库存
function fs_products_instock_of_custom($id){
    global $db;
    $instockQTY = 0;
    if($id == 45564){
        $parr = array(44560,44077,44055,44078,44056,44079,44057,44080,44058,44081,44059,44082,44060,44083,44061,44084,44062,44085,44063,44086,
            44064,44087,44065,44088,44066,44089,44067,44090,44068,44091,44069,44092,44070,44093,44071,44094,44072,44095,44073,44096,44074,44097,
            44075,44098,44076);
        for($i=0;$i<sizeof($parr);$i++){
            $instockQTY = $instockQTY + fs_products_instock_total_qty_of_products_id($parr[$i]);
        }
    }else{
        if($id == 19374){
            $parr = array(44111,44112,44113,44114,44115,44116,44117,44135);
            for($i=0;$i<sizeof($parr);$i++){
                $instockQTY = $instockQTY + fs_products_instock_total_qty_of_products_id($parr[$i]);
            }
        }
    }
    if($instockQTY > 0){
        $instockInfo = '<i>'.$instockQTY.FS_SHIP_PCS.'</i>'. FS_SHIP_STOCK;
    }else{
        $instockInfo = FS_SHIP_AVAI;
    }
    return $instockInfo;
}

/* 库存调用锁定 */
function  fs_order_product_instock_lock($instockID,$opid,$pid,$qty,$warehouse=''){
    global $db;
    $warehouse = $warehouse ? $warehouse : 2;
    $shipping_zone = array(
        'products_instock_id' => $instockID,
        'orders_products_id' =>$opid,
        'products_id' => $pid,
        'change_qty' => $qty,
        'message' => '库存调用锁定',
        'date' => 'now()',
        'warehouse' => $warehouse
    );
    // zen_db_perform('products_instock_history_temp',$shipping_zone);
}


/* 某个库存订单锁定总数 */
function  fs_products_instock_id_lock_total($id){
    global $db;
    $instock = $db->Execute("SELECT sum(change_qty)as total FROM products_instock_history_temp WHERE products_instock_id =".(int)$id." and products_shipping_info_id>0 and type=0 ");
    return $instock->fields['total'];
}

/* 定制需求客户 */
function fs_warehouse_instock_of_custom($id,$is_special,$opid,$qty){
    global $db;
    $products_instock_id= array();
    $instock_str = '';
    $categoriesID = fs_get_data_from_db_fields('categories_id','products_to_categories','products_id='.$id,'order by sort_order limit 1');
    if(in_array($categoriesID,array(1202,1125,2866,1328))){
        $instock_str = '';
    }else{
        $warehouse = array(2,8,6);
        $products_id = zen_get_products_related_model($id);  /* 主产品 */
        $to_qty = $qty;
        $custom_id = fs_get_data_from_db_fields('customized_id','products_instock_customized_related','products_id>0 and customized_id ='.$products_id.' or products_id= '.$products_id,' limit 1');
        if($is_special ==1){
            // 客户有定制化需求,只能用半成品   -- 改成 非标准的不进到仓管
            $products_instock_id='';
            /*
             $custom_instock_info = fs_get_data_from_db_fields_array(array('products_instock_id','instock_qty'),'products_instock','products_id='.$id.' and warehouse =6 ','limit 1');
             if($custom_instock_info[0][0]){
              if($custom_instock_info[0][1] >0){
                $lock_qty = fs_products_instock_id_lock_total($custom_instock_info[0][0]);
                if(($custom_instock_info[0][1] - $lock_qty) > 0){
                  $products_instock_id = $custom_instock_info[0][0];
                  fs_order_product_instock_lock($products_instock_id,$opid,$id,$qty,6);  // 锁定库存
                }
               }
             }
             */
        }else{
            /* 成品仓是否有库存和库存量 */
            $c_instock = fs_get_data_from_db_fields_array(array('products_instock_id','instock_qty'),'products_instock','products_id='.$products_id.' and warehouse =2','limit 1');
            //$Z_instock = fs_get_data_from_db_fields_array(array('products_instock_id','instock_qty'),'products_instock','products_id='.$products_id.' and warehouse =8','limit 1');
            if($custom_id){
                $B_instock = fs_get_data_from_db_fields_array(array('products_instock_id','instock_qty'),'products_instock','products_id='.$custom_id.' and warehouse =6','limit 1');
            }

            /* 成品仓 */
            if($c_instock[0][0]){
                if($c_instock[0][1] >0){
                    $c_lock_qty = fs_products_instock_id_lock_total($c_instock[0][0]); /* 锁定数量 */
                    /* 库存数量减去锁定数量=可用数量 */
                    $c_available_qty = $c_instock[0][1] - $c_lock_qty;
                }
            }

            /* 武汉转运仓*/
            /*
            if($Z_instock[0][0]){
              if($Z_instock[0][1] >0){
               $Z_lock_qty = fs_products_instock_id_lock_total($Z_instock[0][0]);
               // 库存数量减去锁定数量=可用数量
               $Z_available_qty = $Z_instock[0][1] - $Z_lock_qty;
              }
            }
            */

            /* 武汉半成品仓*/
            if($B_instock[0][0]){
                if($B_instock[0][1] >0){
                    /* 成品仓订单锁定的库存数量 */
                    $B_lock_qty = fs_products_instock_id_lock_total($B_instock[0][0]);
                    /* 库存数量减去锁定数量=可用数量 */
                    $B_available_qty = $B_instock[0][1] - $B_lock_qty;
                    if($B_available_qty > 0){
                        $B_instock_id = $B_instock[0][0];
                    }
                }
            }

            /* 订单锁定成品仓库存数量 */
            if($c_available_qty > 0){
                $c_instock_id = $c_instock[0][0];
                if($c_available_qty >= $qty){                 /* 可用数量满足订单产品数量 */
                    $to_qty =0;
                    fs_order_product_instock_lock($c_instock_id,$opid,$id,$qty,2);  /* 锁定库存 */
                }else{
                    if($Z_available_qty > 0 || $B_available_qty > 0){  /* 成品仓可用数量不能满足订单产品数量,有转运仓或半成品仓支持调用 */
                        $to_qty = $qty - $c_available_qty;
                        fs_order_product_instock_lock($c_instock_id,$opid,$id,$c_available_qty,2);
                    }else{                                             /* 转运仓和半成品仓都不支持调用,成品仓为终点库存 */
                        $to_qty = 0;
                        fs_order_product_instock_lock($c_instock_id,$opid,$id,$qty,2);
                    }
                }
                $products_instock_id [] = $c_instock_id ;
            }
            /* 订单锁定转运仓库存数量 */
            if($Z_available_qty > 0 && $to_qty > 0){
                $Z_instock_id = $Z_instock[0][0];
                if($Z_available_qty >= $to_qty){                /* 可用数量满足订单产品数量 */
                    fs_order_product_instock_lock($Z_instock_id,$opid,$id,$to_qty,8);
                    $to_qty = 0;
                }else{
                    if($B_available_qty > 0){
                        $to_qty = $to_qty - $Z_available_qty;      /* 武汉转运仓可用数量不能满足订单产品数量,同时半成品仓可接着调用 */
                        fs_order_product_instock_lock($Z_instock_id,$opid,$id,$Z_available_qty,8);
                    }else{
                        /* 没有半成品可调时,转运仓就是终点 */
                        fs_order_product_instock_lock($Z_instock_id,$opid,$id,$to_qty,8);
                        $to_qty = 0;
                    }
                }
                $products_instock_id [] = $Z_instock_id ;
            }
            /* 订单锁定半成品仓库存数量 */
            if($B_available_qty > 0 && $to_qty > 0){
                $B_instock_id = $B_instock[0][0];
                /* 半成品是最终库存,不管数量是否达到调用数量,都是终点 */
                fs_order_product_instock_lock($B_instock_id,$opid,$id,$to_qty,6);
                $products_instock_id [] = $B_instock_id ;
            }
        }
        if(sizeof($products_instock_id)){
            $instock_str =  implode(",",$products_instock_id);
        }
    }
    //$instock_str =  $products_instock_id[0].$products_instock_id[1].$products_instock_id[2];
    return $instock_str;
}

require DIR_WS_CLASSES."customClass.php";
use classes\custom\FsCustomRelate;
/**
 * 获取定制产品  默认属性的标准产品ID
 */
function fs_get_custom_related_standard_products($products_id){
    global $db;
    $optionsID = fs_get_products_default_show_attr($products_id,true);
    $defaultLength = fs_get_data_from_db_fields('length','products_length','sign=1 and product_id='.(int)$products_id,'');
    if($optionsID&&is_array($optionsID)){
        $customClass = new FsCustomRelate((int)$products_id,$optionsID,$defaultLength);
        $excellentMatch = $customClass->handle();
        if($excellentMatch){
            $products_id = $excellentMatch[0];
        }
    }
    return $products_id;
}
/**
 * 获取前台默认显示的属性值
 */
function fs_get_products_default_show_attr($products_id,$returnValueID=false){
    global $db;
    $res = $db->Execute("select column_id,column_name from attribute_custom_column where column_name = '" . (int)$products_id . "' and parent_id = 0");
    if($res->fields['column_id']){

        $products_options_array=array();
        $column_array = zen_get_all_sub_column($res->fields['column_id']);

//    array_unshift($column_array,$res->fields['column_id']);
//    foreach($column_array as $column){
//      $count = $db->getAll("select distinct cc.attr_id from attribute_custom_column cc left join products_options ca on (cc.attr_id=ca.products_options_id) where parent_id=".$column." and cc.language_id=".$_SESSION['languages_id']." and ca.language_id=".$_SESSION['languages_id']."");
//      for($i=0,$total=count($count);$i<$total;$i++){
//        $sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.attr_price from attribute_custom_column cc where parent_id=".$column." and language_id=".$_SESSION['languages_id']." and attr_id=".$count[$i]['attr_id']."  order by sort");
//        foreach($sub_one as $k=>$h){
//          if(!array_key_exists($h['attr_id'],$products_options_array)){
//            $products_options_array[$h['attr_id']] = array('id' => $h['attr_value_id'],'text' => $h['column_name']);
//          }
//        }
//      }
//    }

        $column_id_str = implode(',',$column_array);
        if($column_id_str){
            $column_list = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id from attribute_custom_column cc,products_options ca where cc.attr_id=ca.products_options_id and column_id in ($column_id_str)");
        }
        if($column_list){
            foreach ($column_list as $column) {
                if (!array_key_exists($column['attr_id'], $products_options_array)) {
                    $products_options_array[$column['attr_id']] = array('id' => $column['attr_value_id'], 'text' => $column['column_name']);
                }
            }
        }

    }else{
        $sql = "select count(*) as total
          from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
          where    patrib.products_id='" . (int)$products_id . "'
            and      patrib.options_id = popt.products_options_id
            and      popt.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
            " and    patrib.attributes_status = 1 and popt.products_options_status = 1 limit 1";
        $pr_attr = $db->Execute($sql);

        if ($pr_attr->fields['total'] > 0) {
            if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
                $options_order_by= ' order by LPAD(popt.products_options_sort_order,11,"0")';
            } else {
                //$options_order_by= ' order by popt.products_options_name';
                $options_order_by= ' order by patrib.products_attributes_id desc';
            }

            $sql = "select distinct popt.products_options_id, popt.products_options_name, popt.products_options_sort_order,
                                popt.products_options_type, popt.products_options_length, popt.products_options_comment,
                                popt.products_options_size,
                                popt.products_options_images_per_row,
                                popt.products_options_images_style,
                                popt.products_options_rows,popt.products_options_count,patrib.is_custom
                from        " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
                where           patrib.products_id='" . (int)$products_id . "'
                and             patrib.options_id = popt.products_options_id
                and             popt.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
                " and     patrib.attributes_status = 1 and  popt.products_options_status = 1 ".
                $options_order_by;

            $products_options_names = $db->Execute($sql);

            // iii 030813 added: initialize $number_of_uploads
            $number_of_uploads = 0;

            if ( PRODUCTS_OPTIONS_SORT_BY_PRICE =='1' ) {
                //$order_by= ' order by LPAD(pa.products_options_sort_order,11,"0"), pov.products_options_values_name';
                $order_by= ' order by LPAD(pov.products_options_values_sort_order,11,"0"), pov.products_options_values_name';
            } else {
                // $order_by= ' order by LPAD(pa.products_options_sort_order,11,"0"), pa.options_values_price';
                $order_by= ' order by LPAD(pov.products_options_values_sort_order,11,"0"), pa.options_values_price';

            }
            $zv_display_select_option = 0;
            $products_options_array=array();
            while (!$products_options_names->EOF) {
                $sql = "select    pov.products_options_values_id,
                          pov.products_options_values_name,pa.del_color,
                          pa.*
                from      " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
                where     pa.products_id = '" . (int)$products_id . "'
                and       pa.options_id = '" . (int)$products_options_names->fields['products_options_id'] . "'
                and       pa.options_values_id = pov.products_options_values_id
                and       pov.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
                    $order_by;
                //echo '<div style="display:none">'.$sql.'</div>';
                $products_options = $db->Execute($sql);
                while (!$products_options->EOF) {
                    if(!array_key_exists($products_options_names->fields['products_options_id'],$products_options_array)){
                        $products_options_array[$products_options_names->fields['products_options_id']] = array('id' => $products_options->fields['products_options_values_id'],
                            'text' => $products_options->fields['products_options_values_name']);
                    }
                    $products_options->MoveNext();
                }
                $products_options_names->MoveNext();
            }
        }
    }
    if($returnValueID&&$products_options_array){
        if($products_options_array){
            foreach ($products_options_array as $v){
                $optionsID[] = $v['id'];
            }
        }
    }
    if($products_options_array){
        return $returnValueID ? $optionsID : $products_options_array;
    }else{
        return false;
    }
}

//查看该产品是否标记为“高频高价、高频低价、低频高价、低频低价”
function zen_get_products_important($pid){
    global $db;
    $falg = false;
    $sql = "select is_important from ".TABLE_PRODUCTS." where products_id=".$pid." limit 1";
    $res = $db->Execute($sql);
    if($res->RecordCount()){
        $is_important = $res->fields['is_important'];
        if(in_array($is_important,array(1,2,3,4))){
            $falg = true;
        }
    }
    return $falg;
}
function zen_get_products_instock_qty($NowInstockQTY,$pid){
    if ($NowInstockQTY == FS_SHIP_AVAI) {
        if(zen_get_products_important((int)$pid)){
            //没有库存，但是有标记为高频高价、高频低价、低频高价、低频低价，直接显示交期，不显示customized
            $NowInstockQTY = '';
        }else{
            //查找该产品库存关联的主ID，如有主ID，则查看该主ID是否标记
            $related_id = zen_get_products_related_model((int)$pid);
            if(zen_get_products_important($related_id)){
                $NowInstockQTY = '';
            }else{
                $NowInstockQTY = FS_PRODUCTS_CUSTOMIZED;
            }
        }
    }
    return $NowInstockQTY;
}
//shopping cart和checkout相关页面库存信息展示
function zen_get_products_instock_date($pid,$Attr,$Length){
    $countries_code_2 = strtoupper($_SESSION['countries_iso_code']);
    $instockHtml = '';
    $is_custom = true;
    $ProductsID = $pid;
    $local_qty = 0;
    $show_qty = "";

    $FsCustomRelate = new classes\custom\FsCustomRelate();
    $FsCustomRelate::$products_id = $pid;
    $FsCustomRelate::$optionAttr = $Attr;
    $FsCustomRelate::$length = $Length;
    $matchProducts = $FsCustomRelate->handle();
    if(sizeof($Attr)||$Length){
        $is_custom = false;
    }
    if ($matchProducts) {
        $ProductsID = $matchProducts[0];
    }
    return get_instock_info($ProductsID,$is_custom,$is_show_separate=false);
}
function get_instock_info($pid,$custom=false,$is_show_separate=true){
    $countries_code_2 = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : "US";
    $pid = (int)$pid;
    $local_qty = 0;
    $html="";
    $is_show = true;
    $show_qty = "";
    if(german_warehouse("country_code",$countries_code_2)||other_eu_warehouse($countries_code_2,"country_code")){
        $warehouse_name =  FS_WAREHOUSE_EU;
        $other_name =  FS_WAREHOUSE_US;
        $global_name = FS_WAREHOUSE_CN;
        $warehouse = "US";
        if($_GET['main_page']=="product_info"||$_GET['main_page']=="shopping_cart"){
            $tag = " ".FS_WAREHOUSE_EU.", ";
        }else{
            if($_SESSION['languages_code'] == 'es' || $_SESSION['languages_code'] == 'mx'){
                $tag = " la UE, ";
            }else{
                $tag = " EU, ";
            }
        }
        $NowInstockQTY = zen_get_current_qty($pid,"DE",false);
        $show_qty = $NowInstockQTY;
        $local_qty = zen_get_current_qty($pid,$warehouse,false);
        $global_qty =  zen_get_current_qty($pid,"CN",true);
    }elseif(seattle_warehouse("country_code",$countries_code_2)||FS_IS_SPRING==1){
        $warehouse_name =  FS_WAREHOUSE_US;
        $other_name =  FS_WAREHOUSE_EU;
        $global_name = FS_WAREHOUSE_CN;
        $warehouse = "DE";
        $tag = " U.S., ";
        if($_GET['main_page']=="product_info"||$_GET['main_page']=="shopping_cart"){
            $tag = " ".FS_WAREHOUSE_US.", ";
        }else{
            $tag = " U.S., ";
        }
        $NowInstockQTY = zen_get_current_qty($pid,"US",false)+zen_get_current_qty($pid,"US-ES",false);
        $show_qty =  $NowInstockQTY;
        $local_qty = zen_get_current_qty($pid,$warehouse,false);
        $global_qty =  zen_get_current_qty($pid,"CN",true);
    }elseif (au_warehouse($countries_code_2,"country_code")){
        $warehouse_name = FS_WAREHOUSE_AU;
        $other_name = FS_WAREHOUSE_US;
        $global_name = FS_WAREHOUSE_EU;
        $warehouse = "US";
        $NowInstockQTY = zen_get_current_qty($pid,"AU",false);
        if($_GET['main_page']=="product_info"||$_GET['main_page']=="shopping_cart"){
            $tag = " ".FS_WAREHOUSE_AU.", ";
        }else{
            $tag = " AU, ";
        }
        $show_qty =  $NowInstockQTY;
        $local_qty = zen_get_current_qty($pid,$warehouse,false);
        $global_qty =  zen_get_current_qty($pid,"CN",true);
    }elseif (ru_warehouse("country_code",$countries_code_2)){
        $warehouse_name = FS_WAREHOUSE_RU;
        $other_name = FS_WAREHOUSE_US;
        $global_name = FS_WAREHOUSE_CN;
        $warehouse = "RU";
        $NowInstockQTY = zen_get_current_qty($pid,"RU",false);
        if($_GET['main_page']=="product_info"||$_GET['main_page']=="shopping_cart"){
            $tag = " ".FS_WAREHOUSE_RU.", ";
        }else{
            $tag = " RU, ";
        }
        $show_qty =  $NowInstockQTY;
        $local_qty = zen_get_current_qty($pid,$warehouse,false);
        $global_qty =  zen_get_current_qty($pid,"CN",true);
    }else{
        $warehouse_name = FS_WAREHOUSE_CN;
        $other_name = FS_WAREHOUSE_US;
        $global_name = FS_WAREHOUSE_EU;
        $NowInstockQTY = zen_get_current_qty($pid,"CN",true);
        $show_qty =  $NowInstockQTY;
        $tag = " CN ".FS_EMAIL_PAUSE;
        if($_GET['main_page']=="product_info"||$_GET['main_page']=="shopping_cart" || $_GET['main_page']=="saved_items"){
            $tag = " ".FS_WAREHOUSE_CN.FS_EMAIL_PAUSE;
        }else{
            $tag = "CN".FS_EMAIL_PAUSE;
        }
        $local_qty = zen_get_current_qty($pid,"US",false);
        $global_qty =  zen_get_current_qty($pid,"DE",false);
    }
    if ($is_show_separate) {
        $where = $local_qty == 0 && $global_qty == 0 && ($NowInstockQTY === 0 || $NowInstockQTY === FS_SHIP_AVAI) ? true : false;
        if($NowInstockQTY==0){
            $dot = "";
            $show_qty="";
            $last_dot = FS_EMAIL_PAUSE;
            $warehouse_name = FS_SHIP_AVAI;
        }else{
            $last_dot = FS_EMAIL_PAUSE;
            $dot = QTY_SHOW_MORE;
        }
    } else {
        if( $NowInstockQTY==0){
            $dot = "";
            $last_dot = "";
        }else{
            $dot = " ".QTY_SHOW_MORE." ".$tag;
            $last_dot = "";
        }
        $where = $NowInstockQTY === 0 || $NowInstockQTY === FS_SHIP_AVAI ? true : false;
    }
    $deliver_time = zen_get_products_instock_shipping_date_of_products_id($pid,$NowInstockQTY,$countries_code_2);
//  $NowInstockQTY = zen_get_products_instock_qty($NowInstockQTY,$_GET['products_id']);
    $is_show = true;
    $custome_products = [31966,31922,31909,51308];
    if($where){
        if($is_show_separate){
            if(zen_get_products_important((int)$pid)){
                //没有库存，但是有标记为高频高价、高频低价、低频高价、低频低价，直接显示交期，不显示customized
                $NowInstockQTY = "";
                $show_qty="";
                $dot = "";
            }else{
                //查找该产品库存关联的主ID，如有主ID，则查看该主ID是否标记
                $related_id = zen_get_products_related_model((int)$pid);
                if(zen_get_products_important($related_id)){
                    $NowInstockQTY = '';
                    $dot = "";
                    $show_qty= "";
                }else{
                    $NowInstockQTY = FS_SHIP_AVAI;
                    $show_qty = FS_SHIP_AVAI;
                    $dot = FS_EMAIL_PAUSE;
                }
            }
        }else{
            if(zen_get_products_important((int)$pid)){
                //没有库存，但是有标记为高频高价、高频低价、低频高价、低频低价，直接显示交期，不显示customized
                $NowInstockQTY = "";
                $show_qty = "";
                $dot = "";
            }else{
                //查找该产品库存关联的主ID，如有主ID，则查看该主ID是否标记
                $related_id = zen_get_products_related_model((int)$pid);
                if(zen_get_products_important($related_id)){
                    $NowInstockQTY = "";
                    $show_qty = "";
                    $dot = "";
                }else{
                    $NowInstockQTY = FS_SHIP_AVAI.FS_EMAIL_PAUSE;
                    $show_qty = FS_SHIP_AVAI.FS_EMAIL_PAUSE;
                    $dot = "";
                    //如果为定制产品
                    if(!$custom){
                        $NowInstockQTY = FS_PRODUCTS_CUSTOMIZED.FS_EMAIL_PAUSE;
                        $show_qty = FS_PRODUCTS_CUSTOMIZED.FS_EMAIL_PAUSE;
                        $dot = "";
                    }
                }
            }
            if(in_array($pid,$custome_products)){
                $NowInstockQTY = FS_PRODUCTS_CUSTOMIZED.FS_EMAIL_PAUSE;
                $show_qty = FS_PRODUCTS_CUSTOMIZED.FS_EMAIL_PAUSE;
                $dot = "";
            }
        }
        $is_show = false;
    }
    $html.= '<span class="products_in_stock pro_details">'.$show_qty.'<em>'.$dot.'</em>';
    // }
    if($is_show&&$is_show_separate){
        if($local_qty==0){
            $pc_num_local = QTY_SHOW_ZERO;
        }else{
            $pc_num_local = QTY_SHOW_MORE;
        }
        if($global_qty==0){
            $pc_num_global = QTY_SHOW_ZERO;
        }else{
            $pc_num_global = QTY_SHOW_MORE;
        }
        $html.=  '<span class="track_orders_wenhao track_orders_wenhao_only">'. $warehouse_name .'<div class="new_m_bg1"></div>
		<div class="new_m_bg_wap">
		<div class="question_text_01 leftjt">
		<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
			<div class="arrow"></div>
			<div class="popover-content">
				<div class="arr_top">
					<i>·</i><strong>'. $local_qty .'</strong><p>'. $pc_num_local.' '.$other_name.'</p>
				</div>
				<div class="arr_bottom">
					<i>·</i><strong>'. $global_qty .'</strong><p>'. $pc_num_global.' '. $global_name.'</p>
				</div>
			</div>
		</div></div></span>'.$last_dot;
    }
    $html.= $deliver_time.'</span>';
//    if($deliver_time == '<b>'.FS_SHIP_SAME_DAY.'</b>'){
//        $html.= '<link itemprop="availability" href="http://schema.org/InStock"/>';
//    }
    //if($deliver_time != '<b>'.FS_SHIP_SAME_DAY.'</b>'){
    $html.= '<div class="track_orders_wenhao">
		<div class="question_bg"></div>
		 <div class="question_text_01 leftjt"><div class="arrow"></div>
			<div class="popover-content">';
    if($countries_code_2 == 'US'){
        $shipping_html = FS_THEA_CTUAL_SHIPPING_TIME;
    }elseif($deliver_time == '<b>'.FS_SHIP_NEXT_DAY.'</b>'){
        $shipping_html=FS_PRODUCTS_ORDERS_RECEIVED.'<br/>'.FS_PRODUCTS_ACTUAL_TIME;
    }else{
        //$shipping_html=FS_PRODUCTS_ACTUAL_TIME;
        $shipping_html = FS_THEA_CTUAL_SHIPPING_TIME;
    }
    $html.=  $shipping_html;
    $html.=	'</div></div></div>';
    return $html;
}
//首页默认库存展示
//首页默认库存展示
function get_instock_for_index($pid,$zero_show_available = false,$page = ''){
    global $db;

    // 前台取消警戒值设定 2020.11.21 dylan
    $caution = '';
    $countries_code_2 = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : 'US';
    if(german_warehouse("country_code",$countries_code_2)||other_eu_warehouse($countries_code_2,"country_code")){
        $NowInstockQTY = zen_get_current_qty($pid,"DE",false);
        //$caution = 'caution_de';
        $warehouse = 20;
    }elseif(seattle_warehouse("country_code",$countries_code_2)||FS_IS_SPRING==1){
        $NowInstockQTY = zen_get_current_qty($pid,"US",false)+zen_get_current_qty($pid,"US-ES",false);
        //$caution = 'caution_us';
        $warehouse = 40;
    }elseif (au_warehouse($countries_code_2,"country_code")){
        $NowInstockQTY = zen_get_current_qty($pid,"AU",false);
        //$caution = 'caution_au';
        $warehouse = 37;
    }elseif (ru_warehouse("country_code",$countries_code_2)){
        $NowInstockQTY = zen_get_current_qty($pid,"RU",false);
        $caution = 'caution_ru';
        $warehouse = 67;
    }elseif (singapore_warehouse("country_code",$countries_code_2)){
        $NowInstockQTY = zen_get_current_qty($pid,"SG",false);
        //$caution = 'caution_sg';
        $warehouse = 71;
    }else{
        $NowInstockQTY = zen_get_current_qty($pid,"CN",true);
        $warehouse = 2;
    }

    //由于首页展示无定制产品，故剔除掉
    $isNotCustom = false;
    if(!in_array($page,['index'])){
        if(zen_get_products_length_total($pid) != 0 || zen_get_products_attributes_total($pid) != 0){
            $isNotCustom = true;
        }
    }

    if(!$NowInstockQTY){ //本地仓无库存
        //$InCnStock = fs_get_data_from_db_fields('in_cn','products','products_id='.(int)$pid,'limit 1');
        if($warehouse == 2){
            if($isNotCustom){ //定制产品国内无库存不展示
                return FS_COMMON_CUSTOMIZED;
            }else{
                return QTY_SHOW_AVAILABLE;
            }
        }else{
            $CnInstockQTY = zen_get_current_qty($pid,"CN",true);
            if($CnInstockQTY>0){
                $pic = QTY_SHOW_ZERO_STOCK_1;
                $NowInstockQTY = $CnInstockQTY;
            }else{
                if($isNotCustom){ //定制产品国内无库存不展示
                    return FS_COMMON_CUSTOMIZED;
                }else{
                    return QTY_SHOW_AVAILABLE;
                }
            }
        }
    }else{  //本地仓有库存
        if($warehouse == 2){
            $pic = QTY_SHOW_ZERO_STOCK_1;
        }else{
            $pic = QTY_SHOW_MORE_STOCK_2;
            if(!empty($caution)){
                $CnInstockQTY = zen_get_current_qty($pid,"CN",true);
                $WarningValue = fs_get_data_from_db_fields($caution,'products_instock_cautions','products_id='.(int)$pid,'limit 1');
                if($WarningValue){
                    if($WarningValue > $NowInstockQTY && $CnInstockQTY > $NowInstockQTY){ //本地仓库存低于警戒值且国内仓大于本地仓库存，展示国内仓库存
                        $NowInstockQTY = $CnInstockQTY;
                    }
                }
            }
        }
    }

    /*if($zero_show_available && !$NowInstockQTY){  //本地仓无库存
        $countries_code = strtolower($_SESSION['countries_iso_code']);

        if(in_array($countries_code, ['us', 'pr'])){
            //GSP项目 美国和波多黎各无库存是展示 In Stock 2020.3.21  ery
            return QTY_SHOW_ZERO_STOCK_1;
        }else{
            return QTY_SHOW_AVAILABLE;
        }
    }
    if($NowInstockQTY<1){
        $pic = QTY_SHOW_ZERO_STOCK_1;
    }else{
        $pic = QTY_SHOW_MORE_STOCK_2;
    }*/

    if (in_array($pid,array(51308,31866,31909,31922))) {
        if ($pid == 51308) {
            $p_roll_km = FS_SHIP_ROLL_2KM;
        }else{
            $p_roll_km = FS_SHIP_ROLL_1KM;
        }
        if ($NowInstockQTY<1) {
            $NowInstockQTY = FS_SHIP_AVAI;
        }else if ($NowInstockQTY == 1){
            // $instockInfo ='<i>'.$p_num_info.FS_SHIP_ROLL.'</i> '.FS_SHIP_STOCK.$p_roll_km;
            $NowInstockQTY ='<i>'.$NowInstockQTY.' KM</i> '.FS_SHIP_STOCK;
        }else{
            // $instockInfo = '<i>'.$p_num_info.FS_SHIP_ROLLS.'</i>'.FS_SHIP_STOCK.$p_roll_km;
            $NowInstockQTY = '<i>'.$NowInstockQTY.' KM</i>'.FS_SHIP_STOCK;
        }
    }else{
        $NowInstockQTY =  $NowInstockQTY." ".$pic;
    }
    return $NowInstockQTY;
}


function getRelatedCumulusProducts($pid = "")
{
    $pid = $pid ? (int)$pid : "";
    $related_products = [];
    if (empty($pid)) {
        return $related_products;
    }
    $part = [
        [75876, 69375, 93488, 93489],
        [69226, 75874, 93486, 93487],
        [69227, 69342, 75875, 93490, 93491],
        [69229, 69340, 75877, 93492, 93493]
    ];
    foreach ($part as $v) {
        if (in_array($pid, $v)) {
            $related_products = $v;
            break;
        }
    }
    return $related_products;
}

/*
* add by ternence 2019/8/19 获取多个产品的总库存
* return (int)所有产品的总库存数量
* */
function getAlllProductInstock($arr,$pid){
    if(is_array($arr) && !empty($arr)){
        $au_num=$de_num=$cn_num=$us_num=0;
        foreach ($arr as $k=>$v){
            //库存查询
            $id = (int)$v;
            if($id>0){
                //澳洲仓库存汇总
                $au_qty = zen_get_current_qty($id, "AU", false);
                //德国仓库存汇总
                $de_qty = zen_get_current_qty($id, "DE", false);
                //武汉仓库存汇总
                $cn_qty = zen_get_current_qty($id, "CN", true);
                //美东+美西库存汇总
                $us_qty = zen_get_current_qty($id, "US", false)+zen_get_current_qty($id,"US-ES",false);
                $de_num +=$de_qty;
                $cn_num +=$cn_qty;
                $us_num +=$us_qty;
                $au_num +=$au_qty;
            }
        }
        //更新各大仓库总库存
        zen_db_perform(TABLE_PRODUCTS,array('associated_inventory_au'=>$au_num,'associated_inventory_de'=>$de_num,'associated_inventory_cn'=>$cn_num,'associated_inventory_us'=>$us_num,),'update','products_id='.$pid);
    }
    return 1;
}

function get_country_relate_warehouse($country_code = ''){
    if(!$country_code) $country_code = $_SESSION['countries_iso_code'];
    if (german_warehouse("country_code", $country_code) || other_eu_warehouse($country_code, "country_code")) {
        $warehouse = 20;
    }elseif (seattle_warehouse("country_code", $country_code)) {
        $warehouse = 40;
    }elseif (au_warehouse($country_code, "country_code")) {
        $warehouse = 37;
    }elseif (ru_warehouse("country_code", $country_code)) {
        $warehouse = 67;
    }elseif (singapore_warehouse("country_code",$country_code)) {
        $warehouse = 71;
    }else{
        $warehouse = 2;
    }
    return $warehouse;
}

/**
 * 2020.8.14 本地仓无库存，无库存统一展示Available
 * @param array $instock_data | $instock_data['qty']=>本地仓库存,$instock_data['cn_qty']=>国内仓库存,$instock_data['warehouse']=>仓库id,$instock_data['warehouseName']=>本地仓库名,$instock_data['asia_warehouseName']=>国内仓库名,$instock_data['mark']=>针对特殊模块分类列表页展示该分类总库存
 * @param array $products_data | $products_data['in_cn']=>在途库存,$products_data['is_custom']=>是否是定制产品
 * @param bool $overStockLine | 低于库存警戒值true
 * @param string $page | 页面page
 * @return string
 */
function get_products_instock_template($instock_data=[],$products_data=[],$overStockLine=false,$page=''){
    $html = '';
    if(empty($instock_data) || empty($products_data)){
        return $html;
    }
    $instockShow = $warehouseName = '';


    $showQtyOne = QTY_SHOW_IN_CN_STOCK_1;
    $showQtyTwo = QTY_SHOW_MORE_STOCK_2;
    if($instock_data['qty']){ //本地仓有库存
        if($overStockLine){ //本地仓库存低于警戒值，展示国内仓库存
            $instockShow = $instock_data['cn_qty'].$showQtyTwo.FS_EMAIL_PAUSE;
            $warehouseName = $instock_data['asia_warehouseName'];
        }else{
            $instockShow = $instock_data['qty'].$showQtyTwo.FS_EMAIL_PAUSE;
            $warehouseName = $instock_data['warehouseName']; //仓库名
        }
    }else{
        if($overStockLine){
            if($instock_data['cn_qty']){
                if($instock_data['material_stock']){
                    //有毛料ID库存
                    $instockShow = $instock_data['material_stock'].FS_PRODUCT_MATERIAL_M.FS_PRODUCT_MATERIAL_CABLE." ".$showQtyOne.FS_EMAIL_PAUSE;
                }else{
                    $instockShow = $instock_data['cn_qty'].$showQtyTwo.FS_EMAIL_PAUSE;
                }
            }else{
                if($products_data['is_custom']){ //定制产品国内无库存不展示
                    if($instock_data['material_stock']){
                        //有毛料ID库存
                        $instockShow = $instock_data['material_stock'].FS_PRODUCT_MATERIAL_M.FS_PRODUCT_MATERIAL_CABLE." ".$showQtyOne.FS_EMAIL_PAUSE;
                    }else{
                        $instockShow = FS_COMMON_CUSTOMIZED.FS_EMAIL_PAUSE;
                    }
                }else{
                    $instockShow = QTY_SHOW_AVAILABLE.FS_EMAIL_PAUSE;
                }
            }
        }else{
            if($instock_data['warehouse'] == 2 || !$instock_data['cn_qty']){
                if($products_data['is_custom']){ //定制产品国内无库存不展示
                    if($instock_data['material_stock']){
                        //有毛料ID库存
                        $instockShow = $instock_data['material_stock'].FS_PRODUCT_MATERIAL_M.FS_PRODUCT_MATERIAL_CABLE." ".$showQtyOne.FS_EMAIL_PAUSE;
                    }else{
                        $instockShow = FS_COMMON_CUSTOMIZED.FS_EMAIL_PAUSE;
                    }
                }else{
                    $instockShow = QTY_SHOW_AVAILABLE.FS_EMAIL_PAUSE;
                }
            }else{
                if($instock_data['cn_qty']){
                    if($instock_data['material_stock']){
                        //有毛料ID库存
                        $instockShow = $instock_data['material_stock'].FS_PRODUCT_MATERIAL_M.FS_PRODUCT_MATERIAL_CABLE." ".$showQtyOne.FS_EMAIL_PAUSE;
                    }else{
                        $instockShow = $instock_data['cn_qty'].$showQtyTwo.FS_EMAIL_PAUSE;
                    }
                }
            }
        }
        $warehouseName = $instock_data['asia_warehouseName'];
    }

    if($page == 'details'){
        if ($_SESSION['languages_code'] == 'de') {
            $html = '<span class="track_orders_wenhao track_orders_wenhao_only m_track_orders_wenhao m-track-alert">' . $instockShow . '<div class="new_m_bg1"></div><div class="new_m_bg_wap">$OTHER_WAREHOUSE</div></span><em class="instock_warehouse sfpDetail-instock-warehouse"> '.$warehouseName.'</em>';
        } else {
            $html = '<span class="track_orders_wenhao track_orders_wenhao_only m_track_orders_wenhao m-track-alert">' . $instockShow . '<div class="new_m_bg1"></div><div class="new_m_bg_wap">$OTHER_WAREHOUSE</div></span><em class="instock_warehouse sfpDetail-instock-warehouse">'.$warehouseName.'</em>';
        }
    }elseif($page == 'shopping_cart'){
        $html = '<span><i class="iconfont stock-package-icon">&#xf429;</i>' . $instockShow . '</span>'.$warehouseName;
    }else{ //列表页，搜索页
        if((!$instock_data['qty'] || $overStockLine) && $instock_data['warehouse'] != 2){//国内仓覆盖的国家，列表页展示亚洲仓库
            $warehouseName = FS_GSP_STOCK_2;
        }
        if(isset($instock_data['mark']) && $instock_data['mark']){  //只针对特殊模块分类
            $instockShow = $instock_data['mark'].QTY_SHOW_MORE_STOCK_2.FS_EMAIL_PAUSE;
        }
        $html = '<span>' . $instockShow . '</span>'.$warehouseName;
    }
    return $html;
}
?>



