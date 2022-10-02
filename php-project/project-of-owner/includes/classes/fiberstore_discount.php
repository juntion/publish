<?php
class fiberstore_discount{

	var $discount= array(0.98,0.96,0.93,0.9);
	function fiberstore_products_discount($products_price,$products_id,$qty){
	   
    $total=0;
   
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
   $total=zen_add_tax(get_round_product_discount_price(round($products_price*($current_category_discount_price[0]*100)/100,2),$qty,$products_id), 0) * $qty;
   }elseif($discount_qty[3]>$qty){
   $total=zen_add_tax(get_round_product_discount_price(round($products_price*($current_category_discount_price[1]*100)/100,2),$qty,$products_id), 0) * $qty;
   }elseif($discount_qty[4]>$qty){
   $total=zen_add_tax(get_round_product_discount_price(round($products_price*($current_category_discount_price[2]*100)/100,2),$qty,$products_id), 0) * $qty;
   }else{
   $total=zen_add_tax(get_round_product_discount_price(round($products_price*($current_category_discount_price[3]*100)/100,2),$qty,$products_id), 0) * $qty;
   }
   }else{
   $total=zen_add_tax(get_round_product_discount_price($products_price,$qty,$products_id), 0) * $qty;
   }

   return $total;
}

}