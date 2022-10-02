<?php

class Datafeed extends base
{
    //feed人工添加字段
    function get_google_label($pid){
        global $db;
        $labels = $db->Execute("select id,custom_label,products_description,shipping_feed from products_google_label where products_id = '$pid' 
        and languages_id = {$_SESSION['languages_id']} and country_code = '{$_SESSION['countries_iso_code']}' and currency = '{$_SESSION['currency']}'");
        $each_label = explode('&&',$labels->fields['custom_label']);
        $products_description = $labels->fields['products_description'];
        $id = $labels->fields['id'];
        $shipping_feed = $labels->fields['shipping_feed'];
        $array = array(
            'shipping_feed' => $shipping_feed,
            'label' =>  $each_label,
            'description' => $products_description,
            'id' => $id,
        );
        return $array;
    }

    //判断商品上下架，是否为新品,清仓产品,定制产品(默认这三种产品不投广告)的情况
    function get_products_stasus_pre($pid){
        global $db;
        $total_view = 0;
        $total_length = 0;
        $pre = $db->Execute("select is_important from ". TABLE_PRODUCTS ." where products_id = '" . $pid . "'")->fields['is_important'];
        $p_status = $db->Execute("select products_status from ". TABLE_PRODUCTS ." where products_id = '" . $pid . "'")->fields['products_status'];
        $clear = $db->Execute("select id from `products_clearance` where products_id = '" . $pid . "'")->fields['id'];
        if((int)$pid){
            $result_view = $db->getAll("SELECT count(*) total FROM `products_attributes` where products_id=".$pid." and attributes_status=1 and options_id not in(4,5,6)");
            if($result_view[0]['total']){
                $total_view = $result_view[0]['total'];
            }
            $result_length = $db->getAll("SELECT count(*) total FROM `products_length` where product_id=".$pid." and custom=0");
            if($result_length[0]['total']){
                $total_length = $result_length[0]['total'];
            }
        }
        if ($p_status == 1 && $pre != 10 && $total_view == 0 && $total_length == 0 && $clear == null){
            $availability = 'in stock';
        }else{
            $availability = 'out of stock';
        }
        return $availability;
    }


    //获取产品详细信息
    function zen_get_order_shipping_products($cid){
        global $db;
        if ($_SESSION['languages_id'] == 1){
            $products_description = 'products_description';
        }elseif($_SESSION['languages_id'] == 2){
            $products_description = 'products_description_es';
        }elseif($_SESSION['languages_id'] == 3){
            $products_description = 'products_description_fr';
        }elseif($_SESSION['languages_id'] == 4){
            $products_description = 'products_description_ru';
        }elseif($_SESSION['languages_id'] == 5){
            $products_description = 'products_description_de';
        }elseif($_SESSION['languages_id'] == 8){
            $products_description = 'products_description_jp';
        }elseif($_SESSION['languages_id'] == 9){
            $products_description = 'products_description_uk';
        }
        if (zen_has_category_subcategories($cid)) {
            $all_subcategories_ids = array();
            zen_get_subcategories($all_subcategories_ids,$cid);
            $count_of_subcategories = sizeof($all_subcategories_ids);
            if ($count_of_subcategories){
                if (1 < $count_of_subcategories) {
                    $category_where_sql = " ptc.categories_id in(".join(',',$all_subcategories_ids).")";
                }else if (1 == $count_of_subcategories) {
                    $category_where_sql = " ptc.categories_id = ".$all_subcategories_ids[0];
                }
            }else {
                $category_where_sql = " ptc.categories_id = ".(int)$cid;
            }
        }else {
            $category_where_sql = " ptc.categories_id = ".(int)$cid;
        }

        $get_products = $db->Execute("select p.products_id from products as p  left join products_to_categories as ptc on(p.products_id = ptc.products_id)
	                           where ". $category_where_sql ." and p.products_status = 1 order by products_sort_order asc
	                          ");
        if ($get_products->RecordCount()){
            while (!$get_products->EOF){
                $products [] = $get_products->fields['products_id'];
                $get_products->MoveNext();
            }
        }

        $order_shipping = array();
        if(sizeof($products)){
            $sql = "select p.products_id as id,p.products_image,p.products_price,p.products_sort_order,
        p.products_weight_for_view,p.products_weight,pd.products_name,pd.products_title,
        pd.product_details from products as p left join ".$products_description." as pd on (p.products_id = pd. products_id)
        where p.products_id in(".join(',',$products).") and p.products_status = 1 and pd.language_id =".$_SESSION['languages_id']."
        order by p.products_sort_order asc";
            $order_products = $db->Execute($sql);
            if ($order_products->RecordCount()) {
                while(!$order_products->EOF){
                    $id = $order_products->fields['id'];
                    //库存计算暂时不要
//                    $au_qty = zen_get_current_qty($id, "AU", false);
//                    $de_qty = zen_get_current_qty($id, "DE", false);
//                    $cn_qty = zen_get_current_qty($id, "CN", true);
//                    $us_qty = zen_get_current_qty($id, "US", false)+zen_get_current_qty($id,"US-ES",false);
//                    $num = $au_qty + $de_qty + $cn_qty + $us_qty;
//                    if($num > 0){
                    $order_shipping [] = array(
                        'id' => $id,
                        'products_name' => $order_products->fields['products_name'],
                        'products_title' => $order_products->fields['products_title'],
                        'product_details' => $order_products->fields['product_details'],
                        'products_image'=> $order_products->fields['products_image'],
                        'products_price' => $order_products->fields['products_price'],
                        'products_sort_order' => $order_products->fields['products_sort_order'],
                        'products_weight_for_view' => $order_products->fields['products_weight_for_view'],
                        'products_weight' => $order_products->fields['products_weight'],
                    );
//                    }
                    $order_products->MoveNext();
                }
            }
        }
        return $order_shipping;
    }


    function get_products_of_categories($pid){
        global $db;
        $list = $db->Execute("select categories_id from products_to_categories where products_id = '".$pid."'")->fields['categories_id'];
        return $list;
    }


    function get_categories_name($cid,$c=0) {
        global $db,$array;
        if($c == 1){
            $array = array();
        }
        $result = $db->getAll("select categories_id,parent_id from categories where categories_id = '$cid' limit 1");
        if($result){
            $array[] = $result[0]['categories_id'];
            $this->get_categories_name($result[0]['parent_id']);
        }
        return $array;
    }

    //获取分类
    function zen_get_product_cate($cid){
        global $db;
        $cate_arr = array_reverse($this->get_categories_name($cid,1));
        if($cate_arr){
            $str = HEADER_TITLE_CATALOG;
            foreach($cate_arr as $key=>$v){
                $res = $db->getAll("select categories_name from categories_description where categories_id = '$v' and language_id ={$_SESSION['languages_id']}  limit 1");
                if($res){
                    $str .= ' &gt; '.$res[0]['categories_name'];
                }
            }
            return $str;
        }else{
            return "";
        }
    }

    //根据所给出商品分类找到对应的google商品分类
    function zen_get_google_cate($cid){
        $cate_arr = $this->get_categories_name($cid,1);
        if($cate_arr){
            foreach($cate_arr as $key=>$v){
                if ($v ==  1023){
                    $g_id = 342;break;
                }elseif ($v == 1017){
                    $g_id = 1544;break;
                }elseif ($v == 6 || $v == 894){
                    $g_id = 2479;break;
                }elseif ($v == 1334 || $v == 1308){
                    $g_id = 5273;break;
                }elseif ($v == 9 || $v == 1037){
                    $g_id = 2121;break;
                }elseif ($v == 899 || $v == 261 || $v == 960 || $v == 2974 || $v == 629){
                    $g_id = 1480;break;
                }elseif ($v == 1000){
                    $g_id = 4463;break;
                }elseif ($v == 4){
                    $g_id = 5557;break;
                }elseif ($v == 2962){
                    $g_id = 275;break;
                }elseif ($v == 3376 || $v == 3266){
                    $g_id = 1562;break;
                }elseif ($v == 3265){
                    $g_id = 2358;break;
                }elseif ($v == 3150){
                    $g_id = 8156;break;
                }elseif ($v == 1097){
                    $g_id = 2377;break;
                }elseif ($v == 3079 || $v == 1071){
                    $g_id = 2455;break;
                }else{
                    $g_id = '';
                }
            }
//        var_dump($g_id);exit;
            return $g_id;
        }else{
            return "";
        }
    }

    /*
     * 返回转成对应币种价格取整后又转成美元的价格
     * Ery add
     */
    function zen_get_products_final_price($products_id, $currency=''){
        // fairy 2019.2.21 add 组合产品主产品价格
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts(intval($products_id));
            $composite_product_price = $CompositeProducts->get_composite_product_price();
            if(!empty($composite_product_price['composite_product_price'])){
                return $composite_product_price['composite_product_price'];
            }
        }

        global $db,$currencies;
        $products_id = (int)$products_id;
        if($products_id){
            $currency = $currency ? $currency : $_SESSION['currency'];
            $currency_value = $currencies->currencies[$currency]['value'];
            $integer_state = fs_get_data_from_db_fields('integer_state', 'products', 'products_id='.$products_id, 'limit 1');
            $products_price = zen_get_products_base_price((int)$products_id);
            if ($integer_state == 0) {
                //产品价格取整操作，products表中的products_price值是以美元为单位，当前货币要不是美元取整前先要转成对应币种的价格后在进行取整操作
                $products_price = get_products_all_currency_final_price($products_price*$currency_value);
            } else {
                //产品价格不取整
                $products_price = get_products_specail_currency_final_price($products_price*$currency_value);
            }
            //返回的仍然是美元为单位的价格
            $products_price = $products_price/$currency_value;
        }
        return $products_price;
    }

}