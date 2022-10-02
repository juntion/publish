<?php
function zen_get_quick_payment_products($cid){
global $db;
$wishlist_attr = array();
$sql = " select products_id as pid , customers_id as cid,customers_wishlist_id as wid,products_quantity as qty from customers_wishlist where customers_id=".$cid;
$products_attr = $db->Execute($sql);

		while (!$products_attr->EOF){
			$wishlist_attr [] = array(
					'pid'=>$products_attr->fields['pid'],
			        'cid'=>$products_attr->fields['cid'],
			        'wid'=>$products_attr->fields['wid'],
			        'qty'=>$products_attr->fields['qty'],
					);
			$products_attr->MoveNext();
		}
		return $wishlist_attr;
}
  
function zen_get_products_image_of_id($product_id) {
    global $db;

    $sql = "select p.products_image from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return $look_up->fields['products_image'];
}

function zen_get_products_price_of_id($pid){
  global $db;
  $sql ="select products_price as price from products where products_id =".$pid;
  $products = $db->Execute($sql);
  return $products->fields['price'];
}

function zen_get_products_length_price_prefix($id){
global $db;
$sql ="select price_prefix from products_length where id=".(int)$id;
$price = $db->execute($sql);
return $price->fields['price_prefix'];
}

function zen_get_products_length_price($id){
global $db;
$sql ="select length_price,price_prefix from products_length where id=".(int)$id;
$price = $db->execute($sql);
return $price->fields['length_price'];
}

function zen_get_products_length_name($id){
global $db;
$sql ="select length from products_length where id=".(int)$id;
$price = $db->execute($sql);
return $price->fields['length'];
}

function zen_display_products_wishlist_length($wid){
  global $db;
  $sql = "select length_name,products_length_id as id from customers_wishlist_length where customers_wishlist_id=".(int)$wid;
  $length = $db->Execute($sql);
  return $length->fields['length_name'];
}

function zen_display_products_length_id($wid){
  global $db;
  $sql = "select products_length_id as id from customers_wishlist_length where customers_wishlist_id=".(int)$wid;
  $length = $db->Execute($sql);
  return $length->fields['id'];
}

function zen_get_option_name_of_id($oid){
 global $db;
 $sql =" select products_options_name as name from products_options where products_options_id=".(int)$oid;
 $option = $db->execute($sql);
return $option->fields['name'];
}