<?php 
header("Access-Control-Allow-Origin:*");
$debug = false;
require 'includes/application_top.php';
if (!class_exists('fiberstore_category')){
require DIR_WS_CLASSES . 'fiberstore_category.php';
}
$wholesaleproducts = fs_get_wholesale_products_array();
 if($_GET['type']=='hot'){
 		$products = array();
    	$wp = $db->Execute("select products_id,hot_pname from hot_products  
                        where  is_hot = 1 and language_id = ".$_SESSION['languages_id']." 
                        order by sort limit 2");
	if($wp->RecordCount()){
	 while(!$wp->EOF){
	 	$wp_image = zen_get_products_image_of_products_id($wp->fields['products_id']);
	 	$image_src= file_exists(DIR_WS_IMAGES.$wp_image) ? DIR_WS_IMAGES.$wp_image: DIR_WS_IMAGES.'no_picture.gif';
		$image = get_resources_img($wp->fields['products_id'],'150','150',$wp_image,'','',' border="0" ');
	 	$wp_price = zen_get_products_price($wp->fields['products_id']);
	 	$new_product_name = substr($wp->fields['hot_pname'],0,70);
	    $products[] = array(
	    'products_id' => $wp->fields['products_id'],
	    'products_name' => $wp->fields['hot_pname'],
	    'href'	 => zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$wp->fields['products_id'],'NONSSL'),
	    'image' => $image_src,
	    "wp_price"=> in_array($wp->fields['products_id'],$wholesaleproducts)?$currencies->format(get_customers_products_level_final_price($wp_price)):$currencies->new_format(get_customers_products_level_final_price($wp_price)),
	    "store" => zen_get_products_instock_total_qty_of_products_id($wp->fields['products_id'])
	    );
	 $wp->MoveNext();
	 }
	}
	echo json_encode(array('items'=>$products));
 }
 if($_GET['type']=='cat'){
 	$one_cate = fs_get_subcategories(0);
 	$one_cate[0]['url'] = "./c/wdm-optical-access-1.html";
 	$one_cate[1]['url'] = "./c/fiber-optic-transceivers-9.html";
 	$one_cate[2]['url'] = "./c/fiber-optic-cables-209.html";
 	$one_cate[3]['url'] = "./c/racks-enclosures-1308.html";
 	$one_cate[4]['url'] = "./c/fiber-testers-tools-4.html";
 	$one_cate[5]['url'] = "./c/cat5e-cat6-cat7-904.html";
 	$one_cate[6]['url'] = "./c/enterprise-network-911.html";
 	echo json_encode(array('items'=>$one_cate));
 }
 if($_GET['type']=="cart"){

	$cart_items = $_SESSION['cart']->count_contents();
	$arr=array(array("num"=>$cart_items));
	echo json_encode(array("items"=>$arr));
}
 ?>