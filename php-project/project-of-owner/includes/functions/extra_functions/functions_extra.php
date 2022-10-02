<?php
function zen_get_air_mail_shipping_cost()
{
 	$shipping_modules = new shipping('airmailzones_airmailzones'); 	
 	$quote = $shipping_modules->quote('airmailzones','airmailzones');
 	
	if (isset($quote['error'])) {
                $shipping_cost = 0;
    } else {
                if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
                  $shipping_cost = $quote[0]['methods'][0]['cost'];
                }
   }
   if ($shipping_cost > 0) return $shipping_cost;
   else return null; 	
}

function zen_get_fedex_shipping_cost()
{
	$shipping_modules = new shipping('fedexzones_fedexzones'); 	
 	$quote = $shipping_modules->quote('fedexzones','fedexzones');
 	
	if (isset($quote['error'])) {
                $shipping_cost = 0;
    } else {
                if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
                  $shipping_cost = $quote[0]['methods'][0]['cost'];
                }
   }
   if ($shipping_cost > 0) return $shipping_cost;
   else return null; 	
}
/**
 * 
 * @param int $current_category_id
 * @return boolean
 * @todo check category exist or not 
 */
function zen_exist_category($current_category_id){
	global $db;
	$categories_products_query = "SELECT count(c.categories_id) AS total
                                FROM   " . TABLE_CATEGORIES . " as c left join ".TABLE_CATEGORIES_DESCRIPTION ." AS cd 
                               	ON(c.categories_id = cd.categories_id and cd.language_id = :languages_id:) 
                                WHERE   c.categories_id = :categoriesID";
	$categories_products_query = $db->bindVars($categories_products_query, ':languages_id:', (int)$_SESSION['languages_id'], 'integer');
	$categories_products_query = $db->bindVars($categories_products_query, ':categoriesID', $current_category_id, 'integer');
	$categories_products = $db->Execute($categories_products_query);
	if($categories_products->fields['total']) return true;
	else return false;
}

function zen_get_customers_info($customers_id){
	global $db;
	$get_info = $db->getAll("select customers_firstname,customers_lastname,customers_email_address from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$customers_id);
	return $get_info;
}


function zen_get_customers_name_by_customrers_id($customers_id){
	global $db;
	$get_info = $db->Execute("select customers_firstname,customers_lastname from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$customers_id); 
	
	return $get_info->fields['customers_firstname'].''.$get_info->fields['customers_lastname'];
}

function zen_get_customers_name($customers_id){
    global $db;
    $get_info = $db->Execute("select customers_firstname,customers_lastname from " . TABLE_CUSTOMERS. " where customers_id = ".(int)$customers_id);

    return $get_info->fields['customers_firstname'].'.'.$get_info->fields['customers_lastname'];
}

function zen_get_admin_name(){

}

function zen_get_products_sku_by_productid($productid){
	global $db;
	$get_info = $db->Execute("select products_SKU from " . TABLE_PRODUCTS. " where products_id = ".(int)$productid); 
	
	return $get_info->fields['products_SKU'];
}

function zen_get_products_price_by_productid($productid){
	global $db;
	$get_info = $db->Execute("select products_price from " . TABLE_PRODUCTS. " where products_id = ".(int)$productid); 
	
	return $get_info->fields['products_price'];
}



function zen_get_orders_by_customers_service_id($ser_id){
	global $db;
	$get_info = $db->Execute("select orders_id from " . TABLE_CUSTOMERS_SERVICE. " where customers_service_id = ".(int)$ser_id); 
	
	return $get_info->fields['orders_id'];
}

// 把用户输入的价格(小数点，千分位处理)转换成可以储存到数据库中的价格
// 例如：德语站的 99.999,00；其他站的99,999.00
function transform_price_for_db($price,$languages_id){
    if($languages_id==5){ //德语
        $price = str_replace('.','',$price); //千分位
        $price = str_replace(',','.',$price);
    }else{
        $price = str_replace(',','',$price);
    }

    return $price;
}

//add by ternence
//客户报价单数量
function zenGetQuoteCount(){
	if($_SESSION['customer_id']){
		global $db;
		$number= $db->Execute("select COUNT(id) from customer_inquiry where customers_id=".$_SESSION['customer_id']." and status=2 and order_id is null and all_price !=0.00")->fields['COUNT(id)'];
		if((int)$number>0){
			return $number;
		}
	}
}

function zenGetQuotesNewCount()
{
    if($_SESSION['customer_id']){
        global $db;
        $number= $db->Execute("SELECT COUNT(fqc.id) as all_num FROM `fs_quotes_customers` fqc LEFT JOIN `fs_quotes_orders` fqo ON fqc.`quotes_id` = fqo.`quotes_id` WHERE fqc.`customers_id` = ".$_SESSION['customer_id']." AND fqo.`orders_id` IS NOT NULL;")->fields['all_num'];
        if((int)$number>0){
            return $number;
        }
    }
}