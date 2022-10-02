<?php
/**
 * functions_lookups.php
 * Lookup Functions for various Zen Cart activities such as countries, prices, products, product types, etc
 *
 * @package functions
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_lookups.php 14141 2009-08-10 19:34:47Z wilt $
 */


/**
 * Returns an array with countries
 *
 * @param int If set limits to a single country
 * @param boolean If true adds the iso codes to the array
 */
function zen_get_countries($countries_id = '', $with_iso_codes = false) {
    global $db;
    $countries_array = array();
    $redisKey = __FUNCTION__.$countries_id.$with_iso_codes;
    $data = get_redis_key_value($redisKey,'countryList');
    if(!empty($data)){
        return $data;
    }
    if (zen_not_null($countries_id)) {
        if ($with_iso_codes == true) {
            $countries = "select countries_name, countries_iso_code_2, countries_iso_code_3,tel_prefix
                      from " . TABLE_COUNTRIES . "
                      where countries_id = '" . (int)$countries_id . "'
                      order by countries_name";

            $countries_values = $db->Execute($countries);

            $countries_array = array('countries_name' => $countries_values->fields['countries_name'],
                'countries_iso_code_2' => $countries_values->fields['countries_iso_code_2'],
                'countries_iso_code_3' => $countries_values->fields['countries_iso_code_3']);
        } else {
            $countries = "select countries_name
                      from " . TABLE_COUNTRIES . "
                      where countries_id = '" . (int)$countries_id . "'";

            $countries_values = $db->Execute($countries);

            $countries_array = array('countries_name' => $countries_values->fields['countries_name']);
        }
    } else {
        $countries = "select countries_id, countries_name,countries_iso_code_2, tel_prefix
                    from " . TABLE_COUNTRIES . " where countries_id NOT IN (96,125,206) and status=1
                    order by countries_name";

        $countries_values = $db->Execute($countries);

        while (!$countries_values->EOF) {
            $countries_array[] = array('countries_id' => $countries_values->fields['countries_id'],
                'countries_name' => $countries_values->fields['countries_name'],
                'english_countries_name' => $countries_values->fields['countries_name'],
                'countries_iso_code_2'=>$countries_values->fields['countries_iso_code_2'],
                'tel_prefix' => $countries_values->fields['tel_prefix']);
            //把china，hongkong，macao，taiwan 4个地名放在一起排列
            if($countries_values->fields['countries_id']==44){
                $china_data = fs_get_data_from_db_fields_array(array('countries_id','countries_name','countries_iso_code_2','tel_prefix'),TABLE_COUNTRIES,'countries_id IN (96,125,206)','order by countries_name');
                foreach($china_data as $data){
                    $countries_array[] = array('countries_id' => $data[0],
                        'countries_name' => $data[1],
                        'english_countries_name' => $data[1],
                        'countries_iso_code_2'=>$data[2],
                        'tel_prefix' => $data[3]);
                }
            }
            $countries_values->MoveNext();
        }
    }
    set_redis_key_value($redisKey,$countries_array,0,'countryList');
    return $countries_array;
}


function zen_get_country_iso_code($country_id){
    global $db;
    $get_iso_code = $db->Execute(" select countries_iso_code_2 from " . TABLE_COUNTRIES . " where countries_id = " . (int)$country_id . "  ");
    return strtolower($get_iso_code->fields['countries_iso_code_2']);
}

/*
 *  Alias function to zen_get_countries()
 */
function zen_get_country_name($country_id) {
    $country_array = zen_get_countries($country_id);

    return $country_array['countries_name'];
}
function zen_get_country_name_with_code($country_id) {
    $country_array = zen_get_countries_by_code($country_id);
    return $country_array['countries_name'];
}
//根据数据库读取的国家名转义为当前语种
function getCountryNameByCode($cname){
    if(!$cname){
        return;
    }
    $feild = zen_get_countries_fields();
    if($feild != 'countries_name'){
        global $db;
        $arr = $db->getAll("select ".$feild." from ".FILENAME_COUNTRIES." where countries_name = '".$cname."' limit 1");
        $countryname = $arr[0][$feild];
        if($countryname == ''){
            $countryname = $cname;
        }
    }else{
        $countryname = $cname;
    }
    return $countryname;
}

function zen_get_prefix($country_id){
    global $db;
    $get_tel = $db->Execute("select tel_prefix from " . TABLE_COUNTRIES . " where countries_id = " . (int)$country_id . " limit 1");
    return $get_tel->fields['tel_prefix'];
}

/**
 * Alias function to zen_get_countries, which also returns the countries iso codes
 *
 * @param int If set limits to a single country
 */
function zen_get_countries_with_iso_codes($countries_id) {
    return zen_get_countries($countries_id, true);
}

/*
 * Return the zone (State/Province) name
 * TABLES: zones
 */
function zen_get_zone_name($country_id, $zone_id, $default_zone) {
    global $db;
    $zone_query = "select zone_name
                   from " . TABLE_ZONES . "
                   where zone_country_id = '" . (int)$country_id . "'
                   and zone_id = '" . (int)$zone_id . "'";

    $zone = $db->Execute($zone_query);

    if ($zone->RecordCount()) {
        return $zone->fields['zone_name'];
    } else {
        return $default_zone;
    }
}

/*
 * Returns the zone (State/Province) code
 * TABLES: zones
 */
function zen_get_zone_code($country_id, $zone_id, $default_zone) {
    global $db;
    $zone_query = "select zone_code
                   from " . TABLE_ZONES . "
                   where zone_country_id = '" . (int)$country_id . "'
                   and zone_id = '" . (int)$zone_id . "'";

    $zone = $db->Execute($zone_query);

    if ($zone->RecordCount() > 0) {
        return $zone->fields['zone_code'];
    } else {
        return $default_zone;
    }
}


/*
 *  validate products_id
 */
function zen_products_id_valid($valid_id) {
    global $db;
    $check_valid = $db->Execute("select p.products_id
                                 from " . TABLE_PRODUCTS . " p
                                 where products_id='" . (int)$valid_id . "' limit 1");
    if ($check_valid->EOF) {
        return false;
    } else {
        return true;
    }
}

/**
 * Return a product's name.
 *
 * @param int The product id of the product who's name we want
 * @param int The language id to use. If this is not set then the current language is used
 */
function zen_get_products_name($product_id, $language = '') {
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = "select products_name
                      from " . TABLE_PRODUCTS_DESCRIPTION . "
                      where products_id = '" . (int)$product_id . "'
                      and language_id = '" . (int)$language . "'";

    $product = $db->Execute($product_query);
    //uk/au转换成英式英语
    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
        $product->fields['products_name']=swap_american_to_britain($product->fields['products_name']);
    }
    return $product->fields['products_name'];
}


function zen_get_news_name($article_id, $language = '') {
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $news_query = "select a.news_article_name
                      from " . TABLE_NEWS_ARTICLES_TEXT . " a,news_articles b 
                      where b.news_status = 1 and a.article_id = b.article_id and a.article_id = '" . (int)$article_id . "'
                      and a.language_id = '" . (int)$language . "'";

    $news = $db->Execute($news_query);

    return $news->fields['news_article_name'];
}



/**
 * Return a product's price.
 *
 * @param int The product id of the product who's name we want
 * @param int The language id to use. If this is not set then the current language is used
 */
function zen_get_products_price($product_id) {
    global $db;


    $product_query = "select products_price
                      from " . TABLE_PRODUCTS . "
                      where products_id = '" . (int)$product_id . "'";

    $product = $db->Execute($product_query);

    return $product->fields['products_price'];
}

/**
 * Return a product's weight.
 *
 * @param int The product weight
 */
function zen_get_products_weight($products_id) {
    global $db;
    $stock_query = "select products_weight
                    from " . TABLE_PRODUCTS . "
                    where products_id = '" . (int)$products_id . "'";

    $stock_values = $db->Execute($stock_query);

    return (float)$stock_values->fields['products_weight'];
}

function zen_get_products_weight_for_customer_view($products_id) {
    global $db;
    $stock_query = "select products_weight_for_view,products_weight 
                    from " . TABLE_PRODUCTS . "
                    where products_id = '" . (int)$products_id . "'";

    $stock_values = $db->Execute($stock_query);

    if ($stock_values->fields['products_weight_for_view']){
        $return = $stock_values->fields['products_weight_for_view'];
    }else {
        $return = $stock_values->fields['products_weight'];
    }
    return (float)$return;
}
/**
 * Return a product's stock count.
 *
 * @param int The product id of the product who's stock we want
 */
function zen_get_products_stock($products_id) {
    global $db;
    $products_id = zen_get_prid($products_id);
    $stock_query = "select products_quantity
                    from " . TABLE_PRODUCTS . "
                    where products_id = '" . (int)$products_id . "'";

    $stock_values = $db->Execute($stock_query);

    return $stock_values->fields['products_quantity'];
}

/**
 * Check if the required stock is available.
 *
 * If insufficent stock is available return an out of stock message
 *
 * @param int The product id of the product whos's stock is to be checked
 * @param int Is this amount of stock available
 *
 * @TODO naughty html in a function
 */
function zen_check_stock($products_id, $products_quantity) {
    $stock_left = zen_get_products_stock($products_id) - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
        $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    return $out_of_stock;
}


/*
 *  Check if product has attributes
 */
function zen_has_product_attributes($products_id, $not_readonly = 'true') {
    global $db;

    if (PRODUCTS_OPTIONS_TYPE_READONLY_IGNORED == '1' and $not_readonly == 'true') {
        // don't include READONLY attributes to determin if attributes must be selected to add to cart
        $attributes_query = "select pa.products_attributes_id
                           from " . TABLE_PRODUCTS_ATTRIBUTES . " pa left join " . TABLE_PRODUCTS_OPTIONS . " po on pa.options_id = po.products_options_id
                           where pa.products_id = '" . (int)$products_id . "' and po.products_options_type != '" . PRODUCTS_OPTIONS_TYPE_READONLY . "' limit 1";
    } else {
        // regardless of READONLY attributes no add to cart buttons
        $attributes_query = "select pa.products_attributes_id
                           from " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                           where pa.products_id = '" . (int)$products_id . "' limit 1";
    }

    $attributes = $db->Execute($attributes_query);

    if ($attributes->recordCount() > 0 && $attributes->fields['products_attributes_id'] > 0) {
        return true;
    } else {
        return false;
    }
}

/*
 *  Check if product has attributes values
 */
function zen_has_product_attributes_values($products_id) {
    global $db;
    $attributes_query = "select sum(options_values_price) as total
                         from " . TABLE_PRODUCTS_ATTRIBUTES . "
                         where products_id = '" . (int)$products_id . "'";

    $attributes = $db->Execute($attributes_query);

    if ($attributes->fields['total'] != 0) {
        return true;
    } else {
        return false;
    }
}

/*
 * Find category name from ID, in indicated language
 */
function zen_get_category_name($category_id, $fn_language_id) {
    global $db;
    if (!zen_not_null($fn_language_id)){
        $fn_language_id = (int) $_SESSION['languages_id'];
    }
    $category_query = "select categories_name
                       from " . TABLE_CATEGORIES_DESCRIPTION . "
                       where categories_id = '" . $category_id . "'
                       and language_id = '" . $fn_language_id . "'";

    $category = $db->Execute($category_query);

    return preg_replace('/<\/?[p]+>/i','',$category->fields['categories_name']);
}

/*
 * Gets the name of the secondary classification
 */
function get_google_products_categories_str($products_id){
    global $db;
    $categories = $db->getAll('select categories_id from products_to_categories WHERE products_id='.$products_id);
    $current_categories = $categories[0]['categories_id'];
    if($current_categories){
        $cPath_array = (array_reverse(get_category_parent_id($current_categories,array())));
        if($cPath_array[1]){
            return zen_get_category_name($cPath_array[1],1);
        }
    }
}


/*
 * Find category description, from category ID, in given language
 */
function zen_get_category_description($category_id, $fn_language_id) {
    global $db;
    if (!zen_not_null($fn_language_id)){
        $fn_language_id = (int) $_SESSION['languages_id'];
    }
    $category_query = "select categories_description
                       from " . TABLE_CATEGORIES_DESCRIPTION . "
                       where categories_id = '" . $category_id . "'
                       and language_id = '" . $fn_language_id . "'";

    $category = $db->Execute($category_query);

    return preg_replace('/<[[:space:]]*\/?[[:space:]]*[p]+(.*)>/i','',$category->fields['categories_description']);
}

/*
 * Return a product's category
 * TABLES: products_to_categories
 */
function zen_get_products_category_id($products_id) {
    global $db;

    $the_products_category_query = "select products_id, master_categories_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'";
//     $the_products_category_query = "select a.products_id, pc.categories_id from " . TABLE_PRODUCTS . " as a left join ".TABLE_PRODUCTS_TO_CATEGORIES ." as pc using(products_id)
//     	left join  ".TABLE_CATEGORIES ." as c using(categories_id)
//     where a.products_id=pc.products_id and products_id = '" . (int)$products_id . "'   and pc.categories_id = c.categories_id ";
    $the_products_category = $db->Execute($the_products_category_query);

    return $the_products_category->fields['master_categories_id'];
}
/**
 * zen_get_categories_name_by_productsid  **************************05-06 ********************
 */
function zen_get_categories_name_by_productsid($products_id) {
    global $db;

    $sql= "select categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where  products_id = '" . (int)$products_id . "'";

    $the_categories_name_by_productsid = $db->Execute($sql);

    return $the_categories_name_by_productsid->fields['categories_id'];
}

/*
 * Return category's image
 * TABLES: categories
 */
function zen_get_categories_image($what_am_i) {
    global $db;

    $the_categories_image_query= "select categories_image from " . TABLE_CATEGORIES . " where categories_id= '" . $what_am_i . "'";
    $the_products_category = $db->Execute($the_categories_image_query);

    return $the_products_category->fields['categories_image'];
}

/*
 *  Return category's name from ID, assuming current language
 *  TABLES: categories_description
 */
function zen_get_categories_name($who_am_i) {
    global $db;

    $the_categories_name_query= "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $who_am_i . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_name = $db->Execute($the_categories_name_query);
    //uk/au转换成英式英语
    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
        $the_categories_name->fields['categories_name'] = swap_american_to_britain($the_categories_name->fields['categories_name']);
    }
    return $the_categories_name->fields['categories_name'];
}

function zen_get_categories_english_name($who_am_i) {
    global $db;

    $the_categories_name_query= "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $who_am_i . "' and language_id= '1'";

    $the_categories_name = $db->Execute($the_categories_name_query);

    return $the_categories_name->fields['categories_name'];
}

function zen_get_compatible_brands_name($who_am_i){
    global $db;
    $the_categories_name_query= "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $who_am_i . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_name = $db->Execute($the_categories_name_query);

    $categories_compatible_brands_query= "select categories_compatible_brands from " . TABLE_CATEGORIES . " where categories_id= '" . $who_am_i . "' limit 1";

    $categories_compatible_brands = $db->Execute($categories_compatible_brands_query);

    $categories_compatible = $categories_compatible_brands->fields['categories_compatible_brands'] ? $categories_compatible_brands->fields['categories_compatible_brands'] : $the_categories_name->fields['categories_name'];

    $compatible_brands_images_query= "select compatible_brands_images from " . TABLE_CATEGORIES . " where categories_id= '" . $who_am_i . "' limit 1";

    $compatible_brands_images_result = $db->Execute($compatible_brands_images_query);

    $compatible_brands_images = $compatible_brands_images_result->fields['compatible_brands_images'] ? "<img src='".HTTPS_SERVER_IMAGE."images/".$compatible_brands_images_result->fields['compatible_brands_images']."'>":$categories_compatible;

    return $compatible_brands_images;
}

function zen_get_categories_description($who_am_i) {
    global $db;
    $the_categories_description_query= "select categories_description from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $who_am_i . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_description = $db->Execute($the_categories_description_query);

    return $the_categories_description->fields['categories_description'];
}



function zen_get_categories_right_div_set($who_am_i) {
    global $db;
    $the_categories_description_query= "select categories_right_div from " . TABLE_CATEGORIES_DESCRIPTION . "
                where categories_id= '" . $who_am_i . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_description = $db->Execute($the_categories_description_query);


    return  $the_categories_description->fields['categories_right_div'];
}


function zen_get_categories_left_div_set($who_am_i) {
    global $db;
    $the_categories_description_query= "select categories_left_div from " . TABLE_CATEGORIES_DESCRIPTION . "
                where categories_id= '" . $who_am_i . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_description = $db->Execute($the_categories_description_query);


    return  $the_categories_description->fields['categories_left_div'];
}

function zen_get_categories_introduction($current_category_id){
    global $db;
    $the_categories_introduction_query= "select categories_introduction from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $who_am_i . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_introduction = $db->Execute($the_categories_introduction_query);

    return $the_categories_introduction->fields['categories_introduction'];
}



/*
 * Return a product's manufacturer's image, from Prod ID
 * TABLES: products, manufacturers
 */


/*
 * Return a product's manufacturer's id, from Prod ID
 * TABLES: products
 */
function zen_get_products_manufacturers_id($product_id) {
    global $db;

    $product_query = "select p.manufacturers_id
                      from " . TABLE_PRODUCTS . " p
                      where p.products_id = '" . (int)$product_id . "'";

    $product =$db->Execute($product_query);

    return $product->fields['manufacturers_id'];
}

/*
 * Return attributes products_options_sort_order
 * TABLE: PRODUCTS_ATTRIBUTES
 */
function zen_get_attributes_sort_order($products_id, $options_id, $options_values_id) {
    global $db;
    $check = $db->Execute("select products_options_sort_order
                             from " . TABLE_PRODUCTS_ATTRIBUTES . "
                             where products_id = '" . (int)$products_id . "'
                             and options_id = '" . (int)$options_id . "'
                             and options_values_id = '" . (int)$options_values_id . "' limit 1");

    return $check->fields['products_options_sort_order'];
}

/*
 *  return attributes products_options_sort_order
 *  TABLES: PRODUCTS_OPTIONS, PRODUCTS_ATTRIBUTES
 */
function zen_get_attributes_options_sort_order($products_id, $options_id, $options_values_id=0, $lang_num = '') {
    global $db;
    if ($lang_num == '') $lang_num = (int)$_SESSION['languages_id'];
    $check = $db->Execute("select products_options_sort_order
                             from " . TABLE_PRODUCTS_OPTIONS . "
                             where products_options_id = '" . (int)$options_id . "' and language_id = '" . $lang_num . "' limit 1");
    /**
     * 下面的查询注释于 2020.05.28  ery
     * products_attributes表中的products_options_sort_order字段全部为0 为减轻数据库查询压力取消此段代码
     */
    /*$check_options_id = $db->Execute("select products_id, options_id, options_values_id, products_options_sort_order
                           from " . TABLE_PRODUCTS_ATTRIBUTES . "
                           where products_id='" . (int)$products_id . "'
                           and options_id='" . (int)$options_id . "'
                           and options_values_id = '" . (int)$options_values_id . "' limit 1");
    return $check->fields['products_options_sort_order'] . '.' . str_pad($check_options_id->fields['products_options_sort_order'],5,'0',STR_PAD_LEFT);*/
    return $check->fields['products_options_sort_order'] . '.' . str_pad(0,5,'0',STR_PAD_LEFT);
}

/*
 *  check if attribute is display only
 */
function zen_get_attributes_valid($product_id, $option, $value) {
    global $db;

// regular attribute validation
    $check_attributes = $db->Execute("select attributes_display_only, attributes_required from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . (int)$product_id . "' and options_id='" . (int)$option . "' and options_values_id='" . (int)$value . "'");

    $check_valid = true;

// display only cannot be selected
    if ($check_attributes->fields['attributes_display_only'] == '1') {
        $check_valid = false;
    }

// text required validation
    if (preg_match('/^txt_/', $option)) {
        $check_attributes = $db->Execute("select attributes_display_only, attributes_required from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . (int)$product_id . "' and options_id='" . (int)preg_replace('/txt_/', '', $option) . "' and options_values_id='0'");
// text cannot be blank
        if ($check_attributes->fields['attributes_required'] == '1' and empty($value)) {
            $check_valid = false;
        }
    }

    return $check_valid;
}

/*
 * Return Options_Name from ID
 */

function zen_options_name($options_id) {
    global $db;

    $options_id = str_replace('txt_','',$options_id);

    $options_values = $db->Execute("select products_options_name
                                    from " . TABLE_PRODUCTS_OPTIONS . "
                                    where products_options_id = '" . (int)$options_id . "'
                                    and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    return $options_values->fields['products_options_name'];
}

/*
 * Return Options_values_name from value-ID
 */
function zen_values_name($values_id) {
    global $db;

    $values_values = $db->Execute("select products_options_values_name
                                   from " . TABLE_PRODUCTS_OPTIONS_VALUES . "
                                   where products_options_values_id = '" . (int)$values_id . "'
                                   and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    return $values_values->fields['products_options_values_name'];
}

/*
 *  configuration key value lookup
 *  TABLE: configuration
 */
function zen_get_configuration_key_value($lookup) {
    global $db;
    $configuration_query= $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $lookup . "'");
    $lookup_value= $configuration_query->fields['configuration_value'];
    if ( !($lookup_value) ) {
        $lookup_value='<span class="lookupAttention">' . $lookup . '</span>';
    }
    return $lookup_value;
}

/*
 *  Return products description, based on specified language (or current lang if not specified)
 */
function zen_get_products_description($product_id, $language = '') {
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = "select products_description
                      from " . TABLE_PRODUCTS_DESCRIPTION . "
                      where products_id = '" . (int)$product_id . "'
                      and language_id = '" . (int)$language . "'";

    $product = $db->Execute($product_query);

    return $product->fields['products_description'];
}
function zen_get_products_specifications($product_id, $language_id) {
    global $db;
    if (empty($language_id)) $language_id = $_SESSION['languages_id'];
    $product = $db->Execute("select products_specifications
                             from " . TABLE_PRODUCTS_DESCRIPTION . "
                             where products_id = '" . (int)$product_id . "'
                             and language_id = '" . (int)$language_id . "'");

    return $product->fields['products_specifications'];
}

/*
 * look up the product type from product_id and return an info page name (for template/page handling)
 */
function zen_get_info_page($zf_product_id) {
    global $db;
    $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$zf_product_id . "'";
    $zp_type = $db->Execute($sql);
    if ($zp_type->RecordCount() == 0) {
        return 'product_info';
    } else {
        $zp_product_type = $zp_type->fields['products_type'];
        //$sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . (int)$zp_product_type . "'";
        $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = 1";
        $zp_handler = $db->Execute($sql);
        return $zp_handler->fields['type_handler'] . '_info';
    }
}

/*
 * Get accepted credit cards
 * There needs to be a define on the accepted credit card in the language file credit_cards.php example: TEXT_CC_ENABLED_VISA
 */
function zen_get_cc_enabled($text_image = 'TEXT_', $cc_seperate = ' ', $cc_make_columns = 0) {
    global $db;
    $cc_check_accepted_query = $db->Execute(SQL_CC_ENABLED);
    $cc_check_accepted = '';
    $cc_counter = 0;
    if ($cc_make_columns == 0) {
        while (!$cc_check_accepted_query->EOF) {
            $check_it = $text_image . $cc_check_accepted_query->fields['configuration_key'];
            if (defined($check_it)) {
                $cc_check_accepted .= constant($check_it) . $cc_seperate;
            }
            $cc_check_accepted_query->MoveNext();
        }
    } else {
        // build a table
        $cc_check_accepted = '<table class="ccenabled">' . "\n";
        $cc_check_accepted .= '<tr class="ccenabled">' . "\n";
        while (!$cc_check_accepted_query->EOF) {
            $check_it = $text_image . $cc_check_accepted_query->fields['configuration_key'];
            if (defined($check_it)) {
                $cc_check_accepted .= '<td class="ccenabled">' . constant($check_it) . '</td>' . "\n";
            }
            $cc_check_accepted_query->MoveNext();
            $cc_counter++;
            if ($cc_counter >= $cc_make_columns) {
                $cc_check_accepted .= '</tr>' . "\n" . '<tr class="ccenabled">' . "\n";
                $cc_counter = 0;
            }
        }
        $cc_check_accepted .= '</tr>' . "\n" . '</table>' . "\n";
    }
    return $cc_check_accepted;
}

////
// TABLES: categories_name from products_id
function zen_get_categories_name_from_product($product_id) {
    global $db;

//    $check_products_category= $db->Execute("select products_id, categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id='" . $product_id . "' limit 1");
    $check_products_category = $db->Execute("select products_id, master_categories_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $the_categories_name= $db->Execute("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $check_products_category->fields['master_categories_id'] . "' and language_id= '" . $_SESSION['languages_id'] . "'");

    return $the_categories_name->fields['categories_name'];
}


/*
 * configuration key value lookup in TABLE_PRODUCT_TYPE_LAYOUT
 * Used to determine keys/flags used on a per-product-type basis for template-use, etc
 */
function zen_get_configuration_key_value_layout($lookup, $type=1) {
    global $db;
    $configuration_query= $db->Execute("select configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $lookup . "' and product_type_id='". (int)$type . "'");
    $lookup_value= $configuration_query->fields['configuration_value'];
    if ( !($lookup_value) ) {
        $lookup_value='<span class="lookupAttention">' . $lookup . '</span>';
    }
    return $lookup_value;
}

/*
 * look up a products image and send back the image's HTML \<IMG...\> tag
 */
function zen_get_products_image($product_id, $width = SMALL_IMAGE_WIDTH, $height = SMALL_IMAGE_HEIGHT) {
    global $db;

    $sql = "select p.products_image from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return zen_image(DIR_WS_IMAGES . $look_up->fields['products_image'], zen_get_products_name($product_id), $width, $height);
}

/**
 * get products image by products_id  ***********************tom
 */
function zen_get_fs_products_image($product_id, $width = SMALL_IMAGE_WIDTH, $height = SMALL_IMAGE_HEIGHT) {
    global $db;

    $sql = "select p.products_image from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return  DIR_WS_IMAGES. (file_exists(DIR_WS_IMAGES.$look_up->fields['products_image'] ) ? $look_up->fields['products_image'] : 'no_picture.gif');
}

/*
 * look up whether a product is virtual
 */
function zen_get_products_virtual($lookup) {
    global $db;

    $sql = "select p.products_virtual from " . TABLE_PRODUCTS . " p  where p.products_id='" . (int)$lookup . "'";
    $look_up = $db->Execute($sql);

    if ($look_up->fields['products_virtual'] == '1') {
        return true;
    } else {
        return false;
    }
}

/*
 * Look up whether the given product ID is allowed to be added to cart, according to product-type switches set in Admin
 */
function zen_get_products_allow_add_to_cart($lookup) {
    global $db;

    $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . (int)$lookup . "'";
    $type_lookup = $db->Execute($sql);

    $sql = "select allow_add_to_cart from " . TABLE_PRODUCT_TYPES . " where type_id = '" . (int)$type_lookup->fields['products_type'] . "'";
    $allow_add_to_cart = $db->Execute($sql);

    return $allow_add_to_cart->fields['allow_add_to_cart'];
}

/*
 * Look up SHOW_XXX_INFO switch for product ID and product type
 */
function zen_get_show_product_switch_name($lookup, $field, $suffix= 'SHOW_', $prefix= '_INFO', $field_prefix= '_', $field_suffix='') {
    global $db;

    $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . (int)$lookup . "'";
    $type_lookup = $db->Execute($sql);

    $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . (int)$type_lookup->fields['products_type'] . "'";
    $show_key = $db->Execute($sql);

// BOM by zen-cart.cn
    $zv_key = GBcase($suffix . $show_key->fields['type_handler'] . $prefix . $field_prefix . $field . $field_suffix,"upper");
// EOM by zen-cart.cn

    return $zv_key;
}

/*
 * Look up SHOW_XXX_INFO switch for product ID and product type
 */
function zen_get_show_product_switch($lookup, $field, $suffix= 'SHOW_', $prefix= '_INFO', $field_prefix= '_', $field_suffix='') {
    global $db;

    $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . $lookup . "'";
    $type_lookup = $db->Execute($sql);

    $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $type_lookup->fields['products_type'] . "'";
    $show_key = $db->Execute($sql);

// BOM by zen-cart.cn
    $zv_key = GBcase($suffix . $show_key->fields['type_handler'] . $prefix . $field_prefix . $field . $field_suffix,"upper");
// EOM by zen-cart.cn

    $sql = "select configuration_key, configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $zv_key . "'";
    $zv_key_value = $db->Execute($sql);
    if ($zv_key_value->RecordCount() > 0) {
        return $zv_key_value->fields['configuration_value'];
    } else {
        $sql = "select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $zv_key . "'";
        $zv_key_value = $db->Execute($sql);
        if ($zv_key_value->RecordCount() > 0) {
            return $zv_key_value->fields['configuration_value'];
        } else {
            return false;
        }
    }
}

/*
 *  Look up whether a product is always free shipping
 */
function zen_get_product_is_always_free_shipping($lookup) {
    global $db;

    $sql = "select p.product_is_always_free_shipping from " . TABLE_PRODUCTS . " p  where p.products_id='" . (int)$lookup . "'";
    $look_up = $db->Execute($sql);

    if ($look_up->fields['product_is_always_free_shipping'] == '1') {
        return true;
    } else {
        return false;
    }
}

/*
 *  stop regular behavior based on customer/store settings
 *  Used to disable various activities if store is in an operating mode that should prevent those activities
 */
function zen_run_normal() {
    $zc_run = false;
    switch (true) {
        case (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])):
            // down for maintenance not for ADMIN
            $zc_run = true;
            break;
        case (DOWN_FOR_MAINTENANCE == 'true'):
            // down for maintenance
            $zc_run = false;
            break;
        case (STORE_STATUS >= 1):
            // showcase no prices
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
            // show room only
            // customer may browse but no prices
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL == '3'):
            // show room only
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customers_authorization'] > '0'):
            // customer must be logged in to browse
            $zc_run = false;
            break;
        default:
            // proceed normally
            $zc_run = true;
            break;
    }
    return $zc_run;
}

/*
 *  Look up whether to show prices, based on customer-authorization levels
 */
function zen_check_show_prices() {
    if (!(CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == '') and !((CUSTOMERS_APPROVAL_AUTHORIZATION > 0 and CUSTOMERS_APPROVAL_AUTHORIZATION < 3) and ($_SESSION['customers_authorization'] > '0' or $_SESSION['customer_id'] == '')) and STORE_STATUS != 1) {
        return true;
    } else {
        return false;
    }
}

/*
 * Return any field from products or products_description table
 * Example: zen_products_lookup('3', 'products_date_added');
 */
function zen_products_lookup($product_id, $what_field = 'products_name', $language = '') {
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_lookup = $db->Execute("select " . $what_field . " as lookup_field
                              from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                              where p.products_id ='" . (int)$product_id . "'
                              and pd.products_id = p.products_id
                              and pd.language_id = '" . (int)$language . "'");

    $return_field = $product_lookup->fields['lookup_field'];

    return $return_field;
}

/*
 * Return any field from categories or categories_description table
 * Example: zen_categories_lookup('10', 'parent_id');
 */
function zen_categories_lookup($categories_id, $what_field = 'categories_name', $language = '') {
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $category_lookup = $db->Execute("select " . $what_field . " as lookup_field
                              from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                              where c.categories_id ='" . (int)$categories_id . "'
                              and c.categories_id = cd.categories_id
                              and cd.language_id = '" . (int)$language . "'");

    $return_field = $category_lookup->fields['lookup_field'];

    return $return_field;
}

/*
 * Find index_filters directory
 * suitable for including template-specific immediate /modules files, such as:
 * new_products, products_new_listing, featured_products, featured_products_listing, product_listing, specials_index, upcoming,
 * products_all_listing, products_discount_prices, also_purchased_products
 */
function zen_get_index_filters_directory($check_file, $dir_only = 'false') {
    global $template_dir;

    $zv_filename = $check_file;
    if (!strstr($zv_filename, '.php')) $zv_filename .= '.php';

    if (file_exists(DIR_WS_INCLUDES . 'index_filters/' . $template_dir . '/' . $zv_filename)) {
        $template_dir_select = $template_dir . '/';
    } else {
        $template_dir_select = '';
    }

    if (!file_exists(DIR_WS_INCLUDES . 'index_filters/' . $template_dir_select . '/' . $zv_filename)) {
        $zv_filename = 'default';
    }

    if ($dir_only == 'true') {
        return 'index_filters/' . $template_dir_select;
    } else {
        return 'index_filters/' . $template_dir_select . $zv_filename;
    }
}

////
// get define of New Products
function zen_get_products_new_timelimit($time_limit = false) {
    if ($time_limit == false) {
        $time_limit = SHOW_NEW_PRODUCTS_LIMIT;
    }
    switch (true) {
        case ($time_limit == '0'):
            $display_limit = '';
            break;
        case ($time_limit == '1'):
            $display_limit = " and date_format(p.products_date_added, '%Y%m') >= date_format(now(), '%Y%m')";
            break;
        case ($time_limit == '7'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 7';
            break;
        case ($time_limit == '14'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 14';
            break;
        case ($time_limit == '30'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 30';
            break;
        case ($time_limit == '60'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 60';
            break;
        case ($time_limit == '90'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 90';
            break;
        case ($time_limit == '120'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 120';
            break;
    }
    return $display_limit;
}

// build date range for new products
function zen_get_new_date_range($time_limit = false) {
    if ($time_limit == false) {
        $time_limit = SHOW_NEW_PRODUCTS_LIMIT;
    }
    // 120 days; 24 hours; 60 mins; 60secs
    $date_range = time() - ($time_limit * 24 * 60 * 60);
    $upcoming_mask_range = time();
    $upcoming_mask = date('Ymd', $upcoming_mask_range);

// echo 'Now:      '. date('Y-m-d') ."<br />";
// echo $time_limit . ' Days: '. date('Ymd', $date_range) ."<br />";
    $zc_new_date = date('Ymd', $date_range);
    switch (true) {
        case (SHOW_NEW_PRODUCTS_LIMIT == 0):
            $new_range = '';
            break;
        case (SHOW_NEW_PRODUCTS_LIMIT == 1):
            $zc_new_date = date('Ym', time()) . '01';
            $new_range = ' and p.products_date_added >=' . $zc_new_date;
            break;
        default:
            $new_range = ' and p.products_date_added >=' . $zc_new_date;
    }

    if (SHOW_NEW_PRODUCTS_UPCOMING_MASKED == 0) {
        // do nothing upcoming shows in new
    } else {
        // do not include upcoming in new
        $new_range .= " and (p.products_date_available <=" . $upcoming_mask . " or p.products_date_available IS NULL)";
    }
    return $new_range;
}


// build date range for upcoming products
function zen_get_upcoming_date_range() {
    // 120 days; 24 hours; 60 mins; 60secs
    $date_range = time();
    $zc_new_date = date('Ymd', $date_range);
// need to check speed on this for larger sites
//    $new_range = ' and date_format(p.products_date_available, \'%Y%m%d\') >' . $zc_new_date;
    $new_range = ' and p.products_date_available >' . $zc_new_date . '235959';

    return $new_range;
}
function ns_get_products_weight($products_id){
    global $db;
    $products_weight = 0;
    $get_products_weight = $db->Execute("select products_weight from " . TABLE_PRODUCTS . " where products_id = " . $products_id);
    if ($get_products_weight->RecordCount()){
        $products_weight = $get_products_weight->fields['products_weight'];
    }
    return $products_weight;
}
function ns_get_root_category(& $root_category_id, $category_id){
    global $db;
    $get_category_top = $db->Execute("select categories_id, parent_id from " . TABLE_CATEGORIES . " where categories_id = " . $category_id);
    if ($get_category_top->RecordCount()){
        if (0 != $get_category_top->fields['parent_id']){
            ns_get_root_category($root_category_id,$get_category_top->fields['parent_id']);
        }else {
            $root_category_id = $get_category_top->fields['categories_id'];
        }
    }
}
function ns_get_products_root_category($products_id){
    global $db;
    $root_category_id = 0;
    $get_category = $db->Execute("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = " . $products_id);
    if ($get_category->RecordCount()){
        ns_get_root_category($root_category_id, $get_category->fields['categories_id']);
    }
    return $root_category_id ;
}

/*fs rewrite url */
function fs_get_rewrite_url($type,$id){
    switch ($type){
        case 'category':
            return HTTP_SERVER.DIR_WS_CATALOG.strtolower(preg_replace('/(\/|[[:space:]]{1,}|\"|\\\')/i', '-', ltrim(zen_get_categories_name($id)))).fs_get_categories_path($id);
            break;
        case 'product':
            return HTTP_SERVER.DIR_WS_CATALOG.strtolower(preg_replace('/(\/|[[:space:]]{1,}|\"|\\\')/i', '-', ltrim(zen_get_products_name($id)))).'-p'.$id . '.html';
            break;

    }

}
/*get shipping weight (except tranceivers and meida converter)  to caculate the shipping cost*/
/*  function ns_get_shipping_weight(){
  	$total_weight = $_SESSION['cart']->show_weight();
//  	echo $total_weight;exit;
  	foreach (($_SESSION['cart']->contents) as $products_id => $products_info){
  		echo $products_id .', '. ns_get_products_root_category($products_id);exit;
  		if (in_array(ns_get_products_root_category($products_id),array(1,9))){
  			$total_weight -= ns_get_products_weight($products_id) * $products_info['qty'];
  		}
  	}
  	return $total_weight;
  }*/

// customer lookup of address book
function zen_get_customers_address_book($customer_id) {
    global $db;

    $customer_address_book_count_query = "SELECT c.*, ab.* from " .
        TABLE_CUSTOMERS . " c
                                          left join " . TABLE_ADDRESS_BOOK . " ab on c.customers_id = ab.customers_id
                                          WHERE c.customers_id = '" . (int)$customer_id . "'";

    $customer_address_book_count = $db->Execute($customer_address_book_count_query);
    return $customer_address_book_count;
}
////
// get products type
function zen_get_products_type($product_id) {
    global $db;
    $check_products_type = $db->Execute("select products_type from " . TABLE_PRODUCTS . " where products_id='" . $product_id . "'");
    return $check_products_type->fields['products_type'];
}
/************zen_get_products_min_order_by_productsid   tom-------------***********/
function zen_get_products_min_order_by_productsid($products_id) {
    global $db;

    $sql= "select is_min_order_qty as qty from ".TABLE_PRODUCTS." where  products_id = '" . (int)$products_id . "'";

    $the_min_order_by_productsid = $db->Execute($sql);

    return $the_min_order_by_productsid->fields['qty'];
}

//get specail product price url

function zen_special_product_price_url_description($products_id,$c_id){
    global $db;
    $language = $_SESSION['languages_id'];
    //if($c_id!='1308'){
    // return '';
    // }
    $url_des = $db->Execute("select products_special_url_description from ".TABLE_PRODUCTS_DESCRIPTION." where products_id = '".$products_id."' and language_id = '" . (int)$language . "'");
    if($url_des->fields['products_special_url_description']){
        return '<div class="product_2016pdf">'.$url_des->fields['products_special_url_description'].'</div>';
    }else{
        return '';
    }


}

// 用户登录、用户注册、企业注册、个人中心编辑资料
function get_username_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'firstname' => array(
                'required' => true,
                'minlength' => $_SESSION['languages_code'] == 'jp' ? 1:2,
                'maxlength' => 32,
            ),
            'lastname' => array(
                'required' => true,
                'minlength'=> $_SESSION['languages_code'] == 'jp' ? 1:2,
                'maxlength'=> 32,
            ),
            'email_login' => array( //登录使用
                'required' => true,
                'FSEmailLogin'=> true
            ),
            'email' => array(
                'required' => true,
                'FSemailRegist'=> true
            ),
            'new_email' => array(
                'required' => true,
                'FSemail'=> true
            ),
            'new_email_c' => array(
                'required' => true,
                'equalTo' =>  '#new_email'
            ),
            'old_password' => array( //登录、修改密码时候使用
                'required' => true
            ),
            'password' => array(
                'required' => true,
                'FSpsw' => true,
            ),
            'password_c' => array(
                'required' => true,
                'equalTo' => '#password'
            ),
            'new_password' => array(
                'required' => true,
                'FSpsw' => true,
            ),
            'new_password_c' => array(
                'required' => true,
                'equalTo' => '#new_password'
            ),
            'company_name'=> array(
                'required' => true,
                'minlength' => 2
            ),
            'phone_number'=> array(
                'required' => true,
                'FSphone' => true
            ),
            'tax_number_new' => array(
                'FStax' => array('country')
            ),
            'tax_number_partner' => array(
                'FStax_new' => array('country')
            ),
            'industry' => array(
                'required'=> true
            ),
            'country' => array(
                'required'=> true
            ),
            'validate' => array(
                'fs_visible_required'=> true,
            ),
            'customers_company' => array(
                'maxlength' => 100
            ),
            'privacy_policy' => array(
                'required'=> true
            ),
            'reset_code' => array(
                'required'=> true
            ),
            'reset_password' => array(
                'required' => true,
                'FSpsw' => true,
            ),
        ),
        'messages' => array(
            'firstname' => array(
                'required' => FS_FIRST_REQUIRED_TIP,
                'minlength' => FS_FIRST_MIN_TIP,
                'maxlength' => FS_FIRST_MAX_TIP,
            ),
            'lastname' => array(
                'required'=> FS_LAST_REQUIRED_TIP,
                'minlength' => FS_LAST_MIN_TIP,
                'maxlength' => FS_LAST_MAX_TIP,
            ),
            'email_login' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSEmailLogin'=> FS_EMAIL_FORMAT_TIP
            ),
            'email' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP,
                'FSemailRegist' => FS_EMAIL_FORMAT_TIP,
            ),
            'new_email' => array(
                'required' => FS_NEW_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'new_email_c' => array(
                'required' => FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP,
                'equalTo' =>  FS_NEW_EMAIL_MATCH_TIP
            ),
            'old_password' => array(
                'required' => FS_PASSWORD_REQUIRED_TIP
            ),
            'password' => array(
                'required' => FS_PASSWORD_REQUIRED_TIP,
                'FSpsw' => FS_PASSWORD_FORMAT_TIP
            ),
            'password_c' => array(
                'required' => FS_CONFIRM_PASSWORD_REQUIRED_TIP,
                'equalTo' => FS_PASSWORD_MATCH_TIP
            ),
            'new_password' => array(
                'required' => FS_NEW_PASSWORD_REQUIRED_TIP,
                'FSpsw' => FS_PASSWORD_FORMAT_TIP
            ),
            'new_password_c' => array(
                'required' => FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP,
                'equalTo' => FS_NEW_PASSWORD_MATCH_TIP
            ),
            'company_name' => array(
                'required' => FS_COMPANY_NAME_REQUIRED_TIP,
                'minlength' => FS_COMPANY_NAME_MIN_TIP
            ),
            'phone_number' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'FSphone' => FS_ADDRESS_PHONE_MSG
            ),
            'tax_number_new' => array(
                'FStax' => FS_CHECKOUT_ERROR_VAT
            ),
            'tax_number_partner' => array(
            ),
            'industry' => array(
                'required' => FS_INDUSTRY_REQUIRED_TIP
            ),
            'country' => array(
                'required' => FS_INDUSTRY_REQUIRED_TIP
            ),
            'validate' => array(
                'fs_visible_required'=> FS_IMAGE_REQUIRED_TIP,
            ),
            'customers_company' => array(
                'maxlength' => FS_COMPANY_MAXLENGTH_ERROR
            ),
            'privacy_policy'=> array(
                'required'=> FS_COMMON_PRIVACY_POLICY_ERROR
            ),
            'reset_code' => array(
                'required'=> FS_RESET_CODE_REQUIRED
            ),
            'reset_password' => array(
                'required'=> FS_REEOR_PROMPT,
                'FSpsw' => FS_REEOR_PROMPT
            ),

        )
    );

    return $valide_cofig;
}

function get_address_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'company_type' => array(
                'required' => true
            ),
            'entry_company'=> array(
                'fs_depend_required'=> array('company_type','BusinessType','upadd_company_type'),
                'maxlength' => 100
            ),
            'entry_firstname'=> array(
                'required' => true,
                'minlength' => $_SESSION['languages_code'] == 'jp' ? 1:2,
                'maxlength' => 35
            ),
            'entry_lastname'=> array(
                'required' => true,
                'minlength'=> $_SESSION['languages_code'] == 'jp' ? 1:2,
                'maxlength' => 35
            ),
            'entry_street_address'=> array(
                'required' => true,
                'minlength' => 4,
                'maxlength' => 300,
            ),
            'entry_street_address_new'=> array(
                'required' => true,
                'minlength' => 4,
                'maxlength' => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? 35 : 300,
                'disallow_pobox' => true,
            ),
            'entry_suburb'=> array(
                'minlength' => 4,
                'maxlength' => 35,
            ),
            'entry_suburb_new'=> array(
                'minlength' => 4,
                'maxlength' => 35,
                'disallow_pobox' => true,
            ),
            'entry_postcode'=> array(
                'required' => true,
                'minlength' => 3,
            ),
            'entry_city'=> array(
                'required' => true,
                'maxlength' => 50,
            ),
            'entry_telephone'=> array(
                'required' => true,
                'maxlength' => 15,
            ),
            'entry_state'=> array(
                'fs_visible_required'=> true,
            ),
            'state'=> array(
                'fs_visible_required'=> true
            ),
            'entry_tax_number' => array(
                'FStax_new' => array('tagcountry')
            ),
        ),
        'messages' => array(
            'company_type' => array(
                'required' => FS_CHECKOUT_ERROR17
            ),
            'entry_company' => array(
                'fs_depend_required' => FS_CHECKOUT_ERROR10,
                'maxlength' => FS_COMPANY_MAXLENGTH_ERROR
            ),
            'entry_firstname' => array(
                'required' => FS_CHECKOUT_ERROR1,
                'minlength' =>FS_CHECKOUT_ERROR13,
                'maxlength' => FS_FIRSTNAME_MAXLENGTH_ERROR
            ),
            'entry_lastname' => array(
                'required' => FS_CHECKOUT_ERROR2,
                'minlength' => FS_CHECKOUT_ERROR14,
                'maxlength' => FS_LASTNAME_MAXLENGTH_ERROR
            ),
            'entry_street_address' => array(
                'required' => FS_CHECKOUT_ERROR3,
                'minlength' => FS_CHECKOUT_ERROR12,
                'maxlength' => FS_CHECKOUT_ERROR12,
            ),
            'entry_street_address_new' => array(
                'required' => FS_CHECKOUT_ERROR3,
                'minlength' => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? str_replace(300, 35, FS_CHECKOUT_ERROR12) : FS_CHECKOUT_ERROR12,
                'maxlength' => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? str_replace(300, 35, FS_CHECKOUT_ERROR12) : FS_CHECKOUT_ERROR12,
                'disallow_pobox' => FS_ADDRESS_STREET_PO_BOX_TIP,
            ),
            'entry_suburb' => array(
                'minlength' => FS_ADDRESS_LINE_TWO_MIN_MAX_TIP,
                'maxlength' => FS_ADDRESS_LINE_TWO_MIN_MAX_TIP,
            ),
            'entry_suburb_new' => array(
                'minlength' => FS_ADDRESS_LINE_TWO_MIN_MAX_TIP,
                'maxlength' => FS_ADDRESS_LINE_TWO_MIN_MAX_TIP,
                'disallow_pobox' =>FS_ADDRESS_STREET_PO_BOX_TIP,
            ),
            'entry_postcode' => array(
                'required' => FS_CHECKOUT_ERROR4,
                'minlength' => FS_CHECKOUT_ERROR15,
            ),
            'entry_city' => array(
                'required' => FS_CHECKOUT_ERROR5,
                'maxlength' => FS_CITY_MIN_MAX_TIP
            ),
            'entry_telephone' => array(
                'required' => FS_CHECKOUT_ERROR7,
                'maxlength' => FS_TELEPHONE_MAXLENGTH_ERROR,
            ),
            'entry_state' => array(
                'fs_visible_required' =>FS_CHECKOUT_ERROR6
            ),
            'state' => array(
                'fs_visible_required' =>FS_CHECKOUT_ERROR6
            ),
            'entry_tax_number' => array(),
        )
    );

    return $valide_cofig;
}

function get_visit_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'customer_name' => array(
                'required' => true
            ),
            'customer_email'=> array(
                'required' => true,
                'FSemail'=> true
            ),
            'customer_company_name'=> array(
                'required' => true
            ),
            'customer_phone' => array(
                'digits' => true
            ),
            'appointment_fourth_type'=> array(
                'required' => true
            ),
            'customer_number'=> array(
                'required' => true,
                'digits' => true
            ),
            'agreement'=> array(
                'required' => true
            ),
            'pick_time'=> array(
                'required' => true
            )
        ),
        'messages' => array(
            'customer_name' => array(
                'required' => FS_SGVISIT_FROM_ERROR1,
            ),
            'customer_email' => array(
                'required' => FS_SGVISIT_FROM_ERROR2,
                'FSemail' => FS_SGVISIT_FROM_ERROR8
            ),
            'customer_company_name' => array(
                'required' => FS_SGVISIT_FROM_ERROR3,
            ),
            'customer_phone' => array(
                'digits' => FS_SGVISIT_FROM_ERROR4,
            ),
            'customer_number' => array(
                'required' => FS_SGVISIT_FROM_ERROR5,
                'digits' => FS_SGVISIT_FROM_ERROR6
            ),
            'agreement'=> array(
                'required' => FS_COMMON_PRIVACY_POLICY_ERROR
            ),
            'pick_time' => array(
                'required' => FS_SGVISIT_FROM_ERROR7
            )
        )
    );

    return $valide_cofig;
}

function get_QA_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'type' => array(
                'required' => true
            ),
            'question_content' => array(
                'required' => true
            ),
            'answer_content' => array(
                'required' => true,
                'maxlength' => 500,
                'minlength' =>3
            ),
            'comment_content' => array(
                'required' => true,
                'maxlength' => 500,
                'minlength' =>3
            ),
            'email' => array(
                'required' => true,
                'FSemail'=> true
            ),
            'nickname' => array(
                'required' => true,
            ),
            'qa_agree' => array(
                'required' => true,
            ),
            'first_name' => array(
                'required' => true,
                'minlength' =>2,
                'maxlength' =>32,
            ),
            'last_name' => array(
                'required' => true,
                'minlength' =>2,
                'maxlength' =>32,
            ),
            'qa_tag' => array(
                'required' => true,
            ),
        ),
        'messages' => array(
            'type' => array(
                'required' => POPUP_ANSWER_10
            ),
            'question_content' => array(
                'required'=> POPUP_ANSWER_12
            ),
            'answer_content' => array(
                'required'=> POPUP_ANSWER_23,
                'minlength' => FS_AT_LEAST_ANSWER,
                'maxlength' => FS_AT_MOST_ANSWER,
            ),
            'comment_content' => array(
                'required'=> FS_PRODUCTS_QA_COMMENT_REQUIRED_TIP,
                'minlength' => FS_AT_LEAST_ANSWER,
                'maxlength' => FS_AT_MOST_ANSWER,
            ),
            'email' => array(
                'required' => POPUP_ANSWER_15,
                'FSemail'=> POPUP_ANSWER_24
            ),
            'nickname' => array(
                'required' => POPUP_ANSWER_14
            ),
            'qa_agree' => array(
                'required' => FS_COMMON_PRIVACY_POLICY_ERROR
            ),
            'first_name' =>array(
                'required' => ACCOUNT_EDIT_FIRST_MSG,
                'minlength' => FS_FIRST_MIN_TIP,
                'maxlength' => FS_FIRST_MAX_TIP,
            ),
            'last_name' =>array(
                'required' => ACCOUNT_EDIT_LAST_MSG,
                'minlength' => FS_LAST_MIN_TIP,
                'maxlength' => FS_LAST_MAX_TIP,
            ),
            'qa_tag' => array(
                'required' => FS_QA_QUESTIONS_TAG_TIP
            ),
        )
    );

    return $valide_cofig;
}

//新产品报价购物车
function get_new_inquiry_common_valide(){
    $valide_cofig = array(
        'rules' => array(
            'entry_firstname' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 32,
            ),
            'entry_lastname' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 32,
            ),
            'email' => array(
                'required' => true,
                'FSemail'=> true
            ),
//            'phone'=> array(
//                'required' => true,
//                'FSphone' => true
//            ),
        ),
        'messages' => array(
            'entry_firstname' => array(
                'required' => FS_FIRST_REQUIRED_TIP,
                'minlength' => FS_FIRST_MIN_TIP,
                'maxlength' => FS_FIRST_MAX_TIP,
            ),
            'entry_lastname' => array(
                'required' => $_SESSION['languages_code'] == 'jp' ? FS_LAST_REQUIRED_TIP :  FS_LAST_NAME_PLEASE,
                'minlength' => FS_LAST_MIN_TIP,
                'maxlength' => FS_FIRST_MAX_TIP,
            ),
            'email' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'phone' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'FSphone' => FS_PHONE_FORMAT_TIP
            ),
        )
    );

    return $valide_cofig;
}

function get_inquiry_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'firstname' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 32,
            ),
            'lastname' => array(
                'required' => true,
                'minlength'=> 2,
                'maxlength'=> 32,
            ),
            'email' => array(
                'required' => true,
                'FSemail'=> true
            ),
            'telephone'=> array(
                //'required' => true,
                //'FSphone' => true
            ),
            'company_name'=> array(
                'minlength'=> 2,
                'maxlength'=> 300,
            ),
            'agree'=> array(
                'required'=> true
            ),
            'password'=> array(
                'required'=> true
            ),
            'comment'=> array(
                'maxlength'=> 5000
            ),
            'comment1'=> array(
                'required'=> true,
                'maxlength'=> 5000
            ),
            'interest'=> array(
                'required'=> true
            ),
            'user_type'=> array(
                'required'=> true
            ),
            'privacy_policy'=> array(
                'required'=> true
            )
        ),
        'messages' => array(
            'firstname' => array(
                'required' => FS_FIRST_REQUIRED_TIP,
                'minlength' => FS_FIRST_MIN_TIP,
                'maxlength' => FS_FIRST_MAX_TIP,
            ),
            'lastname' => array(
                'required'=> FS_LAST_REQUIRED_TIP,
                'minlength' => FS_LAST_MIN_TIP,
                'maxlength' => FS_LAST_MAX_TIP,
            ),
            'email' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'telephone' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'FSphone' => FS_PHONE_FORMAT_TIP
            ),
            'company_name' => array(
                'minlength' => FS_COMPANY_NAME_MIN_TIP,
                'maxlength' => FS_COMPANY_NAME_MAX_TIP,
            ),
            'agree'=> array(
                'required'=> FS_AGREE_REQUIRED_TIP
            ),
            'password'=> array(
                'required'=> FS_PASSWORD_REQUIRED_TIP
            ),
            'comment'=> array(
                'maxlength'=> FS_COMMENT_MAX_TIP
            ),
            'comment1'=> array(
                'required'=> FS_PRO_DES_REQUIRED_TIP,
                'maxlength'=> FS_PRO_DES_MAX_TIP
            ),
            'interest'=> array(
                'required'=> FS_SOLUTION_INTEREST_REQUIRED_TIP
            ),
            'user_type'=> array(
                'required'=> FS_DESCRIBE_REQUIRED_TIP
            ),
            'privacy_policy'=> array(
                'required'=> FS_COMMON_PRIVACY_POLICY_ERROR
            )
        )
    );

    return $valide_cofig;
}

// 对于is_inquiry等于1的产品，没有价格的产品，进行询价
function get_quote_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'firstname' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 32,
            ),
            'lastname' => array(
                'required' => true,
                'minlength'=> 2,
                'maxlength'=> 32,
            ),
            'phone_number'=> array(
                'required' => true,
                'FSphone' => true
            ),
            'email' => array(
                'required' => true,
                'FSemail'=> true
            ),
            'product_qty' => array(
                'required' => true,
                'positiveinteger' => true,
            ),
            'enquiry' => array(
                'required' => true
            ),
            'validate' => array(
                'required' => true
            )
        ),
        'messages' => array(
            'firstname' => array(
                'required' => FS_FIRST_REQUIRED_TIP,
                'minlength' => FS_FIRST_MIN_TIP,
                'maxlength' => FS_FIRST_MAX_TIP,
            ),
            'lastname' => array(
                'required'=> FS_LAST_REQUIRED_TIP,
                'minlength' => FS_LAST_MIN_TIP,
                'maxlength' => FS_LAST_MAX_TIP,
            ),
            'phone_number' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'FSphone' => FS_PHONE_FORMAT_TIP
            ),
            'email' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'product_qty' => array(
                'required' => FS_PRODUCT_QTY_REQUIRED_TIP,
                'positiveinteger' => FS_PRODUCT_QTY_FORMAT_TIP,
            ),
            'enquiry' => array(
                'required' => COMMENTS_OR_QUESTIONS_REQUIRED_TIP
            ),
            'validate' => array(
                'required' => FS_IMAGE_FORM_TIP
            )
        )
    );

    return $valide_cofig;
}

// 尾部右侧浮动的反馈
function get_feedback_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'rating' => array(
                'required' => true,
            ),
            'topic' => array(
                'required'=> true
            ),
            'content' => array(
                'required'=> true,
                'minlength'=> 10
            ),
        ),
        'messages' => array(
            'rating' => array(
                'required' => FEEDBACK_RATE_REQUIRED_TIP,
            ),
            'topic' => array(
                'required'=> FEEDBACK_TOPIC_REQUIRED_TIP,
            ),
            'content' => array(
                'required'=> FEEDBACK_CONTENT_REQUIRED_TIP,
                'minlength'=> FEEDBACK_CONTENT_REQUIRED_TIP
            ),

        ),
    );
    return $valide_cofig;
}

// 订单提交评价
function get_review_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'rating' => array(
                'required' => true,
                'min' => 1,
                'max' => 5,
            ),
//            'headline' => array(
//                'required'=> true,
//                'minlength'=> 3,
//            ),
            'review_content' => array(
                'required'=> true,
                'minlength'=> 10,
                'maxlength'=> 5000,
            ),
            'privacy_policy' => array(
                'required'=> true,
            ),
            'equipment_mode' => array(
                'maxlength' => 50,
                'required'=> false,
            )
        ),
        'messages' => array(
            'rating' => array(
                'required' => FEEDBACK_RATE_REQUIRED_TIP,
                'min' => FEEDBACK_RATE_REQUIRED_TIP,
                'max' => FEEDBACK_RATE_REQUIRED_TIP,
            ),
//            'headline' => array(
//                'required'=> FS_REVIEW_TITLE_MIN_TIP,
//                'minlength'=> FS_REVIEW_TITLE_MIN_TIP,
//            ),
            'review_content' => array(
                'required'=> FS_REVIEW_CONTENT_REQUIRED_TIP_NEW,
                'minlength'=> FS_REVIEW_CONTENT_MIN_TIP,
                'maxlength'=> FS_REVIEW_CONTENT_MAX_TIP,
            ),
            'privacy_policy' => array(
                'required'=> FS_COMMON_PRIVACY_POLICY_ERROR,
            ),
            'equipment_mode' => array(
                'maxlength' => 50,
            )
        )
    );

    return $valide_cofig;
}

// case 添加
function get_case_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'service_type' => array(
                'required' => true,
            ),
            'question_content' => array(
                'required' => true,
            ),
        ),
        'messages' => array(
            'service_type' => array(
                'required' => FS_CASE_TYPE_REQUIRED_TIP,
            ),
            'question_content' => array(
                'required' => FS_CASE_CONTENT_REQUIRED_TIP,
            ),
        )
    );

    return $valide_cofig;
}

function get_current_valide($type,$valide_input){
    /*
     *格式类似这样
    $email_valide = get_current_valide(array(
        'new_email' => array('common_name'=>'email','required_message'=>FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_NEW),
        'new_email_c' => array(),
        'email_password' => array('common_name'=>'old_password')
    ));
    */
    $valide_fun = 'get_'.$type.'_common_valide_cofig';
    $valide_cofig = $valide_fun();
    $new_valide_cofig = array(
        'rules' => array(),
        'messages' => array(),
    );
    foreach ($valide_input as $key => $val){
        if($key=="focusInvalid" && $val==false){
            $new_valide_cofig['focusInvalid']=false;
        }
        if($key=="focusInvalid" && $val==true){
            $new_valide_cofig['focusInvalid']=true;
        }
        if($val['common_name']){
            $sort_valide_key = $val['common_name'];
        }else{
            $sort_valide_key = $key;
        }
        if($val['rules']){
            $sort_valide_role = $valide_cofig['rules'][$sort_valide_key];
            foreach ($val['rules'] as $rule_key => $rule_val){
                $sort_valide_role[$rule_key] = $rule_val;
            }
        }else{
            $sort_valide_role = $valide_cofig['rules'][$sort_valide_key];
        }
        if($val['messages']){
            $sort_valide_message = $valide_cofig['messages'][$sort_valide_key];
            foreach ($val['messages'] as $message_key => $message_val){
                $sort_valide_message[$message_key] = $message_val;
            }
        }else{
            $sort_valide_message = $valide_cofig['messages'][$sort_valide_key];
        }

        $new_valide_cofig['rules'][$key] = $sort_valide_role;
        $new_valide_cofig['messages'][$key] =  $sort_valide_message;
    }

    return $new_valide_cofig;
}

// 账期客户的额度
function get_credit_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'apply_money' => array(
                'required' => true,
                'FSIsMoney' => true,
            ),
            'apply_money_europe' => array(
                'required' => true,
                'FSIsEuropeMoney' => true,
            ),
            'apply_reason' => array(
                'required' => true,
            ),
        ),
        'messages' => array(
            'apply_money' => array(
                'required' => FS_APPLY_MONEY_REQUIRED_TIP,
                'FSIsMoney' => FS_APPLY_MONEY_FORMAT_TIP,
            ),
            'apply_money_europe' => array(
                'required' => FS_APPLY_MONEY_REQUIRED_TIP,
                'FSIsEuropeMoney' => FS_APPLY_MONEY_FORMAT_TIP,
            ),
            'apply_reason' => array(
                'required' => FS_APPLY_MONEY_REASON_TIP,
            ),
        )
    );
    return $valide_cofig;
}

//fairy 2018.4.10 展示搜索分页
function display_search_page_str($parameters = '',$current_page_number,$number_of_pages,$page_name) {
    global $request_type;
    $display_links_string = '';

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    $display_links_string .= '<div class="new_page_prev">';

    if ($current_page_number > 1)
        $display_links_string .= '<a  href="' . zen_href_link($_GET['main_page'], $parameters .
                $page_name . '=' . ($current_page_number - 1), $request_type) . '" 
                                         title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i></i>' . PREVNEXT_BUTTON_PREV . '</a>';
    else $display_links_string .= '<span><i></i>'.PREVNEXT_BUTTON_PREV .'</span>';

    $display_links_string .= '</div>';

    $display_links_string .= '<div class="new_page_next">';

    if (($current_page_number < $number_of_pages) && ($number_of_pages != 1))
        $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '<i></i></a>';
    else $display_links_string .= '<span>'.PREVNEXT_BUTTON_NEXT.'<i></i></span>' ;

    $display_links_string .= '</div>';

    $display_links_string .= '<div class="new_page_center">Page '.$current_page_number;
    $display_links_string .= ' of '.$number_of_pages.'</div>';

    return $display_links_string;
}

//补款验证
function get_payment_link_common_valide_cofig()
{
    $valide_cofig = array(
        'rules' => array(
            'customer_number' => array(
                'required' => true,
            ),
            'customer_email' => array(
                'required' => true,
                'FSemail'=> true
            ),
            'order_num' => array(
                'required' => true,
                'FSOrdersNumber' => true,
            ),
            'order_total'=> array(
                'required' => true
            ),
            'quest_option'=> array(
                'required' => true,
            ),
        ),
        'messages' => array(
            'customer_number' => array(
                'required' => CUSTOMER_PAYMENT_ERROR_2,
            ),
            'customer_email' => array(
                'required' => CUSTOMER_PAYMENT_ERROR_5,
                'FSemail'=> CUSTOMER_PAYMENT_ERROR_5
            ),
            'order_num' => array(
                'required' => CUSTOMER_PAYMENT_ERROR_3,
                'FSOrdersNumber' => CUSTOMER_PAYMENT_ERROR_6
            ),
            'order_total' => array(
                'required' => CUSTOMER_PAYMENT_ERROR_4
            ),
            'quest_option' => array(
                'required' => CUSTOMER_PAYMENT_ERROR_7,
            ),
        )
    );

    return $valide_cofig;
}

//ery  2018-9-19  customer_service_others.html线下申请售后验证
function get_service_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'order_number' => array(
                'required' => true,
                'orderNumber' => true
            ),
            'review_content' => array(
                'required' => true,
            ),
            'entry_firstname'=> array(
                'required' => true,
//					'minlength' => 2
            ),
            'entry_lastname'=> array(
                'required' => true,
//					'minlength'=> 2
            ),
            'entry_street_address'=> array(
                'minlength' => 4,
                'maxlength' =>300,
                'required' => true,
            ),
            'entry_suburb'=> array(
                'minlength' => 2,
                //'required' => false,
            ),
            'entry_postcode'=> array(
                'required' => true,
                'minlength' => 3
            ),
            'entry_city'=> array(
                'required' => true,
//					'minlength' => 2
            ),
            //电话规则  6位及以上的数字
            'entry_telephone'=> array(
                'required' => true,
                'digits' => true,
                'minlength' =>6,
            ),
            'state'=> array(
                'fs_visible_required'=> true
            ),
            'email_address'=> array(
                'required' => true,
                'FSemail'=> true
            ),
            'comments_content' => array(
                'required' => true,
//                    'minlength' =>3,
                'maxlength'=>5000,
            ),
            'PrivacyPolicy'=>array(
                'required' => true,
            ),
        ),
        'messages' => array(
            'order_number' => array(
                'required' => FS_CUSTOMER_SERVICE_01,
                'orderNumber' => FS_CUSTOMER_SERVICE_02
            ),
            'review_content' => array(
                'required' => FS_CUSTOMER_SERVICE_03,
            ),
            'entry_firstname' => array(
                'required' => FS_FIRST_NAME_PLEASE,
                'minlength' =>FS_FIRST_MIN_TIP
            ),
            'entry_lastname' => array(
                'required' => FS_LAST_NAME_PLEASE,
                'minlength' => FS_LAST_MIN_TIP
            ),
            'entry_street_address' => array(
                'required' => FS_CHECKOUT_ERROR3,
                'minlength' => FS_CHECKOUT_ERROR12,
                'maxlength' => FS_CHECKOUT_ERROR12,
            ),
            'entry_suburb' => array(
                'minlength' =>ACCOUNT_EDIT_SUBCITY_FROMAT_TIP,
                'required' =>FS_CHECKOUT_ERROR_SG_01,
            ),
            'entry_postcode' => array(
                'required' => FS_CHECKOUT_ERROR4,
                'minlength' => FS_CHECKOUT_ERROR15
            ),
            'entry_city' => array(
                'required' => FS_CHECKOUT_ERROR5,
                'minlength' =>ACCOUNT_EDIT_CITY_FROMAT_TIP
            ),
            'entry_telephone' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'digits' => FS_ADDRESS_PHONE_MSG,
                'minlength' => FS_ADDRESS_PHONE_MSG,
            ),
            'state' => array(
                'fs_visible_required' =>FS_CHECKOUT_ERROR6
            ),
            'email_address' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'comments_content' => array(
                'required'=> FS_PLEASE_ENTER_COMMENTS,
//                    'minlength' => FS_COMMON_AT_LEAST,
                'maxlength' => FS_COMMON_AT_MOST,
            ),
            'PrivacyPolicy' => array(
                'required' => FS_COMMON_PRIVACY_POLICY_ERROR,
            ),
        )
    );

    return $valide_cofig;
}

//rebirth  2020-5-18  polices_net_30 前台po申请外围页
function get_polices_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'fullName'=> array(
                'required' => true
            ),
            'email'=> array(
                'required' => true,
                'FSemail'=> true
            ),
            'phone'=> array(
                'required' => true,
                'digits' => true,
                'minlength' =>6,
            ),
            'comments' => array(
                'maxlength'=>5000,
            )
        ),
        'messages' => array(
            'fullName' => array(
                'required' => FS_NET_30_01
            ),
            'email' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'phone' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'digits' => FS_ADDRESS_PHONE_MSG,
                'minlength' => FS_ADDRESS_PHONE_MSG,
            ),
            'comments' => array(
                'maxlength' => FS_COMMON_AT_MOST,
            )
        )
    );

    return $valide_cofig;
}
//防伪码页面验证
function get_verify_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'security_code'=> array(
                'required' => true,
                 'fsVerify'=> true
            ),
            'verify_code'=> array(
                'required' => true,
            )
        ),
        'messages' => array(
            'security_code' => array(
                'required' => FS_VERIFY_16,
                'fsVerify' => FS_VERIFY_17
            ),
            'verify_code' => array(
                'required' => FS_VERIFY_06
            )
        )
    );

    return $valide_cofig;
}

//request_demo 验证
function get_request_demo_common_valide_cofig(){
    $valide_cofig = array(
        'rules' => array(
            'entry_firstname'=> array(
                'required' => true,
//					'minlength' => 2
            ),
            'entry_lastname'=> array(
                'required' => true,
//					'minlength'=> 2
            ),
            //电话规则  6位及以上的数字
            'entry_telephone'=> array(
                'required' => true,
                'digits' => true,
                'minlength' =>6,
            ),
            'email_address'=> array(
                'required' => true,
                'FSemail'=> true
            ),
            'comments_content' => array(
                'required' => true,
//                    'minlength' =>3,
                'maxlength'=>5000,
            ),
            'industry' => array(
                'required' => true
            ),
            'company_name' => array(
                'required' => true
            ),
            'company_size' => array(
                'required' => true
            ),
            'product_id' => array(
                'required' => true
            ),
            'functions' => array(
                'required' => true
            ),
            'PrivacyPolicy'=>array(
                'required' => true,
            ),
        ),
        'messages' => array(
            'entry_firstname' => array(
                'required' => FS_FIRST_NAME_PLEASE,
                'minlength' =>FS_FIRST_MIN_TIP
            ),
            'entry_lastname' => array(
                'required' => FS_LAST_NAME_PLEASE,
                'minlength' => FS_LAST_MIN_TIP
            ),
            'entry_telephone' => array(
                'required' => FS_PHONE_REQUIRED_TIP,
                'digits' => FS_ADDRESS_PHONE_MSG,
                'minlength' => FS_ADDRESS_PHONE_MSG,
            ),
            'email_address' => array(
                'required' => FS_EMAIL_REQUIRED_TIP,
                'FSemail'=> FS_EMAIL_FORMAT_TIP
            ),
            'comments_content' => array(
                'required'=> FS_PLEASE_ENTER_COMMENTS,
//                    'minlength' => FS_COMMON_AT_LEAST,
                'maxlength' => FS_COMMON_AT_MOST,
            ),
            'industry' => array(
                'required' => REQUEST_DEMO_FORM_TIP_01,
            ),
            'company_name' => array(
                'required' => REQUEST_DEMO_FORM_TIP_02,
            ),
            'company_size' => array(
                'required' => REQUEST_DEMO_FORM_TIP_03,
            ),
            'product_id' => array(
                'required' => REQUEST_DEMO_FORM_TIP_04,
            ),
            'functions' => array(
                'required' => REQUEST_DEMO_FORM_TIP_05,
            ),
            'PrivacyPolicy' => array(
                'required' => FS_COMMON_PRIVACY_POLICY_ERROR,
            ),
        )
    );

    return $valide_cofig;
}

/*
 * 地址 验证邮编 是否验证通过
 * @para int $country_id: 国家id
 * @return bool: 是否验证通过
 */
function validate_zip_code($country_id,$entry_postcode){
    global $db;
    $entry_postcode = $entry_postcode ? $entry_postcode : 0;
    switch ($country_id) {
        case 223:
            $sql = "SELECT zip FROM `countries_to_zip`  WHERE zip = '$entry_postcode'";
            $ret = $db->Execute($sql);
            if (empty($ret->fields['zip'])) {
                return false;
            }
            break;
        case 129:
            $my_sql = "SELECT post_zip FROM `fs_shipping_sameday_post`  WHERE post_zip = '$entry_postcode' AND shipping_type=4";
            $my_ret = $db->Execute($my_sql);
            if (empty($my_ret->fields['post_zip'])) {
                return false;
            }
            break;
    }
    return true;
}

/**
 * @notes :获得国家的缩写
 * @author:potato
 * @date  :2019/7/26
 * @param $countries
 * @return mixed
 */
function zen_get_country_iso_code_new($countries)
{
    global $db;
    $countries = array_keys($countries);
    $country_id = implode(',', $countries);
    $sql = " select countries_iso_code_2,countries_id from " . TABLE_COUNTRIES . " where countries_id in (" . $country_id . ")";
    $get_iso_code = $db->getAll($sql);
    foreach ($get_iso_code as $v) {
        $get_iso_codes[$v['countries_id']] = strtolower($v['countries_iso_code_2']);
    }
    return $get_iso_codes;
}

