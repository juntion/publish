<?php
//根据产品ID得到所属分类的父级分类
function get_discount_categories_id_of_products($products_id){
    global $db;
    $product_query="select categories_id 
                         from ". TABLE_PRODUCTS_TO_CATEGORIES ."  
                         where products_id = '" . $products_id . "' ";
    $products_discount=$db->Execute($product_query);

    $categories_query="select parent_id from ". TABLE_CATEGORIES ."
 	                   where categories_id= '". $products_discount->fields['categories_id'] ."'
 	                   ";
    $categories_discount=$db->Execute($categories_query);

    return $categories_discount->fields['parent_id'];

}

//根据产品ID得到所属分类ID
function get_discount_sub_categories_id_of_products($products_id){
    global $db;
    $product_query="select categories_id 
                         from ". TABLE_PRODUCTS_TO_CATEGORIES ."  
                         where products_id = '" . (int)$products_id . "' ";
    $products_discount=$db->Execute($product_query);

    return $products_discount->fields['categories_id'];
}


function get_products_final_price($products_price,$qty){

    $final_price=0;
    round($number,2);
    if(10<=$qty){
        if(20>$qty){
            $final_price=round(($products_price*(0.98 * 100))/100,2);
        }elseif(50>$qty){
            $final_price=round(($products_price*(0.96 * 100))/100,2);
        }elseif(100>$qty){
            $final_price=round(($products_price*(0.93 * 100))/100,2);
        }else{
            $final_price=round(($products_price*(0.90 * 100))/100,2);
        }
    }else{
        $final_price=$products_price;
    }


    return get_round_product_discount_price($final_price,$qty,0);
}


function get_products_final_price_of_discount($products_price,$products_id,$qty){

    $final_price=0;

    $default_discount_price = array(0.98,0.96,0.93,0.9);

    $current_category_discount_price= array();

    if (!zen_get_current_category_discount_price($current_category_discount_price,get_discount_sub_categories_id_of_products($products_id))) {

        if (!zen_get_current_category_discount_price($current_category_discount_price,get_discount_categories_id_of_products($products_id))) {
            $current_category_discount_price = $default_discount_price;
            $discount_price = false;
        }
    }

    $discount_qty =array();
    $discount_qty = get_products_discount_qty((int)$products_id);

    if($discount_qty[1]<=$qty){

        if($discount_qty[2]>$qty){
            $final_price=round(($products_price*($current_category_discount_price[0] * 100))/100,2);

        }elseif($discount_qty[3]>$qty){
            $final_price=round(($products_price*($current_category_discount_price[1] * 100))/100,2);

        }elseif($discount_qty[4]>$qty){
            $final_price=round(($products_price*($current_category_discount_price[2] * 100))/100,2);

        }else{
            $final_price=round(($products_price*($current_category_discount_price[3] * 100))/100,2);

        }
    }else{
        $final_price=$products_price;

    }
    return get_round_product_discount_price($final_price,$qty,$products_id);
}

function get_round_product_discount_price($final_price,$qty,$product_id){
    $product_id = intval($product_id);
    $cpa = zen_get_product_path($product_id);
    if(empty($product_id)){
        if($qty>=10){
            if($cpa[0] == 9){
                if($final_price>=40){
                    $final_price = round($final_price,0);
                }else{
                    $final_price = round($final_price,2);
                }
            }else{
                if($final_price>=10 && $final_price<100){
                    $final_price = round($final_price,1);
                }elseif($final_price>=100){
                    $final_price = round($final_price,0);
                }
            }
        }
    }else{
        $num = get_product_categories_wholesale_quantity_num($product_id);
        if($qty>=$num){
            if($cpa[0] == 9){
                if($final_price>=40){
                    $final_price = round($final_price,0);
                }else{
                    $final_price = round($final_price,2);
                }
            }else{
                if($final_price>=10 && $final_price<100){
                    $final_price = round($final_price,1);
                }elseif($final_price>=100){
                    $final_price = round($final_price,0);
                }
            }
        }

    }
    return $final_price;
}
function get_product_categories_wholesale_quantity_num($product_id){
    global $db;
    $number = 10;
    $cate_arr = $db->getAll("select categories_id from products_to_categories where products_id = '$product_id' limit 1");
    if($cate_arr){
        $categories_id = $cate_arr[0]['categories_id'];

        $result = get_categories_wholesale_quantity_value($categories_id);
        if($result){
            $re_arr = explode(',',$result);
            if($re_arr) $number = $re_arr[1];
        }
    }
    return $number;
}
function get_categories_wholesale_quantity_value($categories_id){
    global $db;
    $arr = get_categories_wholesale_quantity_tg($categories_id,array());
    if($arr){
        foreach($arr as $v){
            $re = $db->getAll("select categories_id,categories_wholesale_quantity from categories where categories_id ='".$v."' limit 1");
            if($re[0]['categories_wholesale_quantity']){
                return $re[0]['categories_wholesale_quantity'];
                break;
            }
        }
    }
    return array();

}
function get_categories_wholesale_quantity_tg($categories_id,$cate_arr){
    global $db;
    $result = $db->getAll("select categories_id,parent_id from categories where categories_id ='".$categories_id."'");
    if($result[0]['categories_id']){
        $cate_arr[] = $result[0]['categories_id'];
        $cate_arr = get_categories_wholesale_quantity_tg($result[0]['parent_id'],$cate_arr);
    }
    return $cate_arr;

}



function get_products_discount_price($products_price,$categories_discount_price,$cid){
    global $db;
    $final_price=0;

    if($categories_discount_price){

        $final_price=round(($products_price*($categories_discount_price * 100))/100,2);

    }
    if($cid == 9){

        if($final_price<40){
            $final_price = round($final_price,2);
        }else{
            $final_price = round($final_price,0);
        }
        return $final_price;
    }else{
        return get_round_product_discount_price($final_price,10,0);
    }
}



function get_products_discount_qty($products_id){
    global $db,$discount_qty,$discount_qtys;
    $discount_qty = array();
    $discount_qtys = array();
    $product_discount_query="select ptc.products_id,c.categories_id,c.parent_id,c.categories_wholesale_quantity as qty 
                         from ". TABLE_PRODUCTS_TO_CATEGORIES ." as ptc left join ". TABLE_CATEGORIES ." as c  on(ptc.categories_id=c.categories_id)
                         where products_id = '" . (int)$products_id. "' ";
 	$products_discount=$db->Execute($product_discount_query); 

 	
 	$categories_discount_query="select categories_wholesale_quantity as qty  from ". TABLE_CATEGORIES ." where categories_id='". (int)$products_discount->fields['parent_id'] ."'";
 	$categories_discount=$db->Execute($categories_discount_query); 
 	//var_dump($categories_discount->fields['qty']);exit;
 	 	
 	if($products_discount->fields['qty']){
 	$discount_qty=split('[,]', $products_discount->fields['qty']);
 	  return  $discount_qty;
 	 }	else if( $categories_discount->fields['qty']){
 	 $discount_qtys=split('[,]', $categories_discount->fields['qty']);
 	  return  $discount_qtys;
 	  
 	  } 
 	 
 }

 
   function get_products_discount_of_categories($prodocts_id){
 	 global $db;
 	$product_discount_query="select ptc.products_id,c.categories_id,c.categories_wholesale_quantity 
                         from ". TABLE_PRODUCTS_TO_CATEGORIES ." as ptc left join ". TABLE_CATEGORIES ." as c on(ptc.categories_id = c.categories_id)  
                         where products_id = '" . (int)$prodocts_id. "' ";
 	$products_discount=$db->Execute($product_discount_query); 
 	
 	return $products_discount->fields['categories_wholesale_quantity'];
 }
 
 

 
    function get_categories_wholesale_of_categories_id($categories_id){
 	 global $db;
 	$sub_categories_query ="select categories_wholesale_quantity from ". TABLE_CATEGORIES ." where categories_id='". (int)$categories_id ."'";
 	
 	$products_discount=$db->Execute($sub_categories_query); 
 	
 	return $products_discount->fields['categories_wholesale_quantity'];
 }
 
 
 
 
  function get_products_discount_of_sub_categories($prodocts_id){
 	 global $db;
 	$product_discount_query="select ptc.products_id,c.categories_id,c.categories_wholesale_quantity 
                         from ". TABLE_PRODUCTS_TO_CATEGORIES ." as ptc left join ". TABLE_CATEGORIES ." as c on(ptc.categories_id = c.categories_id)  
                         where products_id = '" . (int)$prodocts_id. "' ";
    $products_discount=$db->Execute($product_discount_query);

    return $products_discount->fields['categories_wholesale_quantity'];
}




?>