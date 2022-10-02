<?php
/*
 * fairy 2018.11.6 搜索整个文件夹，这个方法已经没用
 */
function fs_product_list_style($products){
    $wholesale_products = fs_get_wholesale_products_array();
    $list_html ='';
    if(is_array($products)){
        foreach ($products as $product){
            $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$product['id'],'SSL');
            $name = $product['name'];
            $sku = $product['sku'];
            $model = $product['model'];
            $Wavelength = $product['wavelenght'];
            $Distance = $product['distance'];
            $Date_Rate = $product['data_rate'];

            $image_src = file_exists(DIR_WS_IMAGES . $product['image']) ? $product['image'] : 'no_picture.gif';
            $image = get_resources_img($product['id'],180,180,$image_src,$product['name'],$product['name']);
            $new_product_price = $product['price'];
            $description = strip_tags(zen_get_products_description($product['id']));
            $description = (220 < strlen($description)) ? substr($description,0,220).'...' : $description;
            $product_stock = zen_get_product_has_stock($product['id']);

            $options_name = fs_products_option_info($product['id']);
            $productLengthInfo = fs_product_length_info($product['id']);

            $list_html .='<div class="product_list_item"><hr />
        <div class="product_list_row">
          <div class="product_list_img">
            <a target="_blank" href="'.$href_link.'" class="thumbnail">
            "'.$image.'"</a>
            <span class="product_sku">#<span>"'.$product['id'].'"</span></span>
          </div>
          <div class="product_list_col">
            <h3><a target="_blank" href="'.$href_link.'">"'.$name.'"</a></h3>
            <div class="product_list_info">
              <div class="">';

            $reviews = $fs_reviews->get_all_reviews_of_product_products_info($product['id']);
            $content_of_reviews = sizeof($reviews);
            $reviews_score=$fs_reviews->get_reviews_score($product['id']);
            $stars_level = $fs_reviews->get_reviews_star_level($product['id']);
            $stars_rand_level = $fs_reviews->get_reviews_star_level_of_review_num($product['id']);
            $stars_num= $fs_reviews->get_all_rating_of_level($product['id']);
            $ratings = $fs_reviews->get_all_reviews_of_rating($product['id']);

            $content_of_ratings = sizeof($ratings);
            $stars_matcher = array( 1 => 'p_star05', 2 => 'p_star04',3 => 'p_star03', 4 => 'p_star02', 5 => 'p_star01', );
            if ($content_of_reviews){
                $reviews_nums=substr($reviews_score,-1);
                $reviews_sums=substr($reviews_score,0,1);
                if($reviews_nums==0){
                    $reviews_width=100;
                }else{
                    $reviews_width=$reviews_nums*10;
                }

                $list_html .='<div class="pro_star">
		  <div class="pro_star_gray">';
                if($reviews_score<1.0 && $reviews_score>0) {
                    $list_html .= '<div class="pro_star_hover" style="width:'.$reviews_width.'%"></div>';}
                if($reviews_sums>0){
                    $list_html .= '<div class="pro_star_hover"></div>';
                }
                $list_html .= '</div>
		  <div class="pro_star_gray">';
                if($reviews_score<2.0 && $reviews_score>=1.0) {
                    $list_html .= '<div class="pro_star_hover" style="width:'.$reviews_width.'%"></div>';}
                if($reviews_sums>1){
                    $list_html .=  '<div class="pro_star_hover"></div>';
                }
                $list_html .= ' </div>  
		  <div class="pro_star_gray">';
                if($reviews_score<3.0 && $reviews_score>=2.0) {
                    $list_html .= '<div class="pro_star_hover" style="width:'.$reviews_width.'%"></div>';}
                if($reviews_sums>2){
                    $list_html .=  '<div class="pro_star_hover"></div>';
                }
                $list_html .= '</div>
		  <div class="pro_star_gray">';
                if($reviews_score<4.0 && $reviews_score>=3.0) {
                    echo '<div class="pro_star_hover" style="width:'.$reviews_width.'%"></div>';}
                if($reviews_sums>3){
                    echo  '<div class="pro_star_hover"></div>';
                }
                $list_html .='</div>
		  <div class="pro_star_gray">';
                if($reviews_score>4.0) {
                    $list_html .= '<div class="pro_star_hover" style="width:'.$reviews_width.'%"></div>';}
                $list_html .= '</div>
		 </div>';
            }else {
                $list_html .= '<span class="p_star11" ></span>';
            }
            $list_html .='<span class="products_in_stock"> ';

            $NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($product['id']);
            $list_html .=$NowInstockQTY.',                          
                            </span> ';

            $deliver_time = zen_get_products_instock_shipping_date_of_products_id($product['id'],$NowInstockQTY);
            $list_html .= $deliver_time;
            if($deliver_time != '<b>Ship same day</b>'){

                $list_html .= '<div class="track_orders_wenhao">
                            <div class="question_bg question_bg_icon iconfont icon">&#xf228;</div>
                             <div class="question_text_01 leftjt"><div class="arrow"></div>
                                <div class="popover-content">';

                if($deliver_time == '<b>Estimated the next day</b>'){
                    $list_html .='Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.<br/>
					                                 There may be some difference between the estimated time and the actual time.';
                }else{
                    $list_html .='There may be some difference between the estimated time and the actual time.';
                }

                $list_html .='</div>
                             </div>
                          </div>';
            }
            $list_html .= '</div>
              <h4>
			    '. _zen_get_products_name_infomation($product['id']).'
			  </h4>
            </div>
          </div>
          <div class="product_list_form">
            <div class="product_list_price">
              <label>Your Price:</label>
              <span class="price">';

            if('1' != $product['is_inquiry'] ){
                if(!in_array($product['id'],$wholesale_products)){
                    $list_html .= $currencies->new_format(get_customers_products_level_final_price($new_product_price));
                }else{
                    $list_html .= $currencies->format(get_customers_products_level_final_price($new_product_price));
                }
            }else{  $list_html .= '-'; }
            $add_to_cart ="Add to Cart";

            $list_html .=' </span>
            </div>
            <div class="product_list_text">
              <label>Quantity:</label>
              <span>';
            $min_qty = $product['is_min_order_qty']>=1 ? $product['is_min_order_qty'] : '1' ;
            $list_html .='
                  <input type="number" id="detail_quantity_'.$product['id'].'" 
                         name="cart_quantity"    min="1" max="999" 
                         value="'.$min_qty.'"  autocomplete="off" class="p_07 product_list_qty">     
              </span>
            </div>
            <div class="product_list_btn">   ';

            if (!sizeof($options_name) && !$productLengthInfo) {
                $list_html .= ' <a href="'.zen_href_link('shopping_cart').'" class="detail_add_cart"  id="detail_go_to_cart_'.(int)$product['id'].'">View Cart<i class=""></i> </a>
				   <a id="detail_add_'.(int)$product['id'].'" onclick="detailAddToCart('.(int)$product['id'].')" class="button_02" >Add to Cart</a>';
            }else{

                $list_html .= '<a class="button_02"  target="_blank"  href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=' . $product['id']).'" >
		    '.$add_to_cart.'
		    </a>';
            }
            $list_html .= '</div>
          </div>
        </div>
      </div>';
        }
    }
    return $list_html;
}


//分享功能
function getShareTheBox(){
    if($_GET['main_page']=="products_detail"){
        $data =  $data = zen_href_link($_GET['main_page'],'s_id='.$_GET['s_id'].''); ;
    }
    if($_GET['main_page']=="support_detail"){
        $data = zen_href_link($_GET['main_page'],'supportid='.$_GET['supportid'].'');
    }
    if($_GET['main_page']=="fs_special_page"){
        $id = $_GET['id'];
        $colums = array('sp_link','sp_name','id','sp_html','meta_keywords','meta_description','remarks','upload_time','upload_admin','status','is_quote');
        $data_url = fs_get_data_from_db_fields_array($colums,'fs_special_page','id='.$id.' and status=1 and language_id='.$_SESSION['languages_id'],'');
        $data='https://www.fs.com/specials/'.str_replace(' ','-',$data_url[0][1]).'-'.$id.'.html';
    }


    if(!isset($data)){
        $data = HTTPS_SERVER.$_SERVER['REQUEST_URI'];
    }

    $html='<div class="popup_share" id="news_project">
                        <div class="alen1" style="">
                            <ul>
								<li><a href="https://www.facebook.com/sharer.php?u='.$data.'" target="_blank"><i class="iconfont icon cacheicon">&#xf191;</i></a></li>
								<li><a href="http://www.linkedin.com/shareArticle?mini=true&url='.$data.'" target="_blank"><i class="iconfont icon cacheicon">&#xf190;</i></a></li>
								<li style="display:none;"><a href="https://plus.google.com/share?url='.$data.'" target="_blank"><i class="iconfont icon cacheicon">&#xf192;</i></a></li>
								<li><a href="https://twitter.com/share?url='.$data.'" target="_blank"><i class="iconfont icon cacheicon">&#xf187;</i></a></li>
							</ul>
                        </div>
                </div>';
    return $html;
}

function getTutorialNewsImg($aid){
    global $db;
    //获取文章详情
    $get_article_content = "select ad.doc_article_content from " .TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_DOC_ARTICLE ." as a using(doc_article_id)
		where doc_article_id = ".$aid;
    //抽取文章详情的第一张图片
    $get_articles = $db->getAll($get_article_content);
    return $get_articles[0]['doc_article_content'];
}

/**
 * @param $word dylan 2019.6.26
 * @return string 提示语
 */
function getNewWordHtml($word){
    $html = '<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                <div class="question_bg_icon question_bg_grayIcon iconfont icon">&#xf071;</div>
                <div class="new_m_bg1"></div>
                <div class="new_m_bg_wap">
                    <div class="question_text_01 leftjt">
						<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                        <div class="arrow"></div>
                        <div class="popover-content">
                            '.$word.'
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}

/**
 * @param $word dylan 2019.6.26
 * @return string 提示语
 */
function getNewWordHtmlQuote($word){
    $html = '<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                <div class="question_bg_icon question_bg_grayIcon iconfont icon">&#xf071;</div>
                <div class="new_m_bg1"></div>
                <div class="new_m_bg_wap">
                    <div class="question_text_01 leftjt">
                        <div class="arrow"></div>
                        <div class="popover-content">
                            '.$word.'
                        </div>
                     
                    </div>
                </div>
            </div>';
    return $html;
}


/**
 * Get the sub-products under the thematic preferential products
 *
 * @id Main product id
 */
function getAccessoriesIds($id){
    global $db;
    if(isset($id)){
        $accessoriesIds = $db->getAll("select products_id from ". TABLE_PRODUCTS . " where binding_product_id like '%".(int)$id."%'");
    }
    return !empty($accessoriesIds)?$accessoriesIds:"";
}

function get_product_binding_product_id($id)
{
    global $db;
    $discount_price = $db->Execute("select binding_product_id from products where products_id = " . (int)$id . "");
    return !empty($discount_price->fields['binding_product_id']) ? 1: '';
}

function get_doc_categories_id($a_id){
    global $db;
    if(!empty($a_id)){
        $categories_id = $db->getAll("select doc_categories_id from doc_article_category where doc_article_id=".$a_id." limit 1");
    }
    return $categories_id[0]['doc_categories_id']?$categories_id[0]['doc_categories_id']:"";
}

function array_count($arr){
    $c=0;
    foreach($arr as $v){
        if(is_array($v)){
            $c++;
        }
    }
    return $c;
}
function getProductsCategoriesName($id){
    global $db;
    if(isset($id)){
        $productCategoriesId = $db->Execute("select categories_id from ". TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = ".(int)$id."");
        if(!empty($productCategoriesId)){
            $name =  zen_get_categories_name($productCategoriesId->fields['categories_id']);
        }
    }

    return !empty($name)?$name:"";
}

function getScreeningName($id){
    global $db;
    if(isset($id)){
        $get_option_ids= $db->getAll("select products_narrow_by_options_values_id from ". TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS. " where products_id=".(int)$id." and products_narrow_by_options_id ='146'");
    }
    if(!empty($get_option_ids)){
        foreach ($get_option_ids as $k=>$v){
            $get_option_names =  $db->getAll("select products_narrow_by_options_values_name from ". TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES. " where products_narrow_by_options_values_id='".(int)$v['products_narrow_by_options_values_id']."' and language_id =".$_SESSION['languages_id']);
        }
    }
    return  !empty($get_option_names)?$get_option_names[0]['products_narrow_by_options_values_name']:"";
}

function getProductsNumber($id){
    global $db;
    if(isset($id)){
        $numberOfSon = $db->Execute("select number_of_son from ". TABLE_PRODUCTS . " where products_id = ".(int)$id."");
    }
    return !empty($numberOfSon)?$numberOfSon->fields['number_of_son']:0;
}

function compare_get_products_quantitys($productArray,$id,$quantity){
    $accessoriesIds = getAccessoriesIds($id);
    if(!empty($accessoriesIds)){
        $getProductsNumber=0;
        $getNeedNumber =0;
        $getNeedNumber += (int)getProductsNumber($id) * $quantity;
        $accessoriesIds = i_array_column($accessoriesIds,products_id);
        for($n=0;$n<array_count($productArray);$n++){
            if($getNeedNumber>0 && in_array($productArray[$n]['id'],$accessoriesIds)==ture){
                $getProductsNumber += (int)$productArray[$n]['quantity'];
            }
        }
        if($getNeedNumber>0){
            $getProductsNumber += $quantity;
        }
        if($getProductsNumber<$getNeedNumber){
            $needquantity = $getNeedNumber;
            $tureOrFalse = 1;
        }else{
            unset($tureOrFalse);
        }
        unset($accessoriesIds);
    }
    return !empty($tureOrFalse)?$tureOrFalse:0;
}

function get_oders($id){
    global $db;
    $special_order = $db->Execute("select special_order from products where products_id = " . (int)$id . "");
    return !empty($special_order->fields['special_order'])? $special_order->fields['special_order'] : '';
}

function get_products_ids($productArray){
    if(isset($productArray) && !empty($productArray)){
        $productIds="";
        for($z=0;$z<array_count($productArray);$z++){
            //获取所有子配件ID
            $accessoriesIds = getAccessoriesIds($productArray[$z]['id']);
            $getNeedNumber = (int)getProductsNumber($productArray[$z]['id']);
            if(!empty($accessoriesIds) && $getNeedNumber>0 && strpos($productArray[$z]['id'],':')){
                $productIds = !empty($productIds)?$productIds:array(0=>'0');
                //拼接二维数组
                $productIds = array_merge($accessoriesIds,$productIds);
            }
        }
        if(!empty($productIds) && is_array($productIds)){
            //转化为一维数组
            $productIds = i_array_column($productIds,products_id);
            return $productIds;
        }
    }
}


function i_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
        $indexKeyIsNull            = (is_null($indexKey))?true :false;
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
        $result                         = array();
        foreach((array)$input as $key=>$row){
            if($columnKeyIsNumber){
                $tmp= array_slice($row, $columnKey, 1);
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
            }else{
                $tmp= isset($row[$columnKey])?$row[$columnKey]:null;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key))?current($key):null;
                    $key = is_null($key)?0:$key;
                }else{
                    $key = isset($row[$indexKey])?$row[$indexKey]:0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}


function get_discount_product_qty($id)
{
    global $db;
    $discount_price = $db->Execute("select discount_price from products where products_id = " . (int)$id . " limit 1");
    return $discount_price->fields['discount_price'] > 0 ? $discount_price->fields['discount_price'] : '';
}

function fs_attribute_related_name($id){
    global $db;
    $products = $db->Execute("select related_id from fiber_optic_length_related_products where products_id =".$id." order by id desc limit 1");
    if($products->fields['related_id']){
        $related = $db->Execute("select type from fiber_optic_length_related  where related_id = ".(int)$products->fields['related_id']);
        if($related->fields['type']){
            return $related->fields['type'];
        }else{
            return "Length";
        }
    }
}

// fairy 获取 产品属性关联 名称（增加小语种代码之后的）
function fs_attribute_related_name_new($products_id){
    global $db;

    $sql = 'select P.related_id,R.type,L.content as type_id_name
    from fiber_optic_length_related_products P
    left join fiber_optic_length_related R on P.related_id = R.related_id
    left join table_column_languages L on R.type_id = L.unique_id and L.language_id="'.(int)$_SESSION['languages_id'].'"  
    where P.products_id = "'.$products_id.'"
    order by P.id desc limit 1';
    $related = $db->Execute($sql);
    if($related->fields['type']){
        return $related->fields['type_id_name']?$related->fields['type_id_name']:$related->fields['type'];
    }else{
        return FS_LENGTH;
    }
}

// fairy 获取 quickfinder属性关联 名称（增加小语种代码之后的）
function fs_quickfinder_related_info($id){
    global $db;

    $sql = 'select id,relate_name,crorelated,relate_name_id from categories_fiber_cables_table where id = "'.$id.'" limit 1';
    $fiber = $db->getAll($sql);
    $fiber_one = $fiber[0];
    if($fiber_one['relate_name_id']){
        $sql = 'select content as relate_id_name from table_column_languages  
        where unique_id = "'.$fiber_one['relate_name_id'].'" and language_id="'.(int)$_SESSION['languages_id'].'" limit 1';

        $languages = $db->getAll($sql);
        $languages_one = $languages[0];
        $fiber_one['relate_name'] = $languages_one['relate_id_name']?$languages_one['relate_id_name']:$languages_one['relate_name'];
    }else{
        $fiber_one['relate_name'] = FS_TRANS_RELATED;
    }
    return $fiber_one;
}

//关联品牌后面的定制分类
function fs_transceivers_related_brand_category($cid){
    global $db;
    $custom = '';
    if(in_array($cid,array(56,57,58,889,1113,2688))){
        $category = $db->Execute("select categories_id from categories where parent_id = ".(int)$cid." order by sort_order desc limit 1");
        $custom = $category->fields['categories_id'];
    }else if(in_array($cid,array(2997))){
        $custom = 2878;
    }
    return $custom;
}

function fs_transceivers_related_brand($id){
    global $db;
    $brandArray = array();
    $products = $db->Execute("select id from categories_fiber_quickfinder_products where products_id =".(int)$id." order by id limit 1");
    $table = $db->Execute("select table_type,categories_id,sort from categories_fiber_cables_table where id =".(int)$products->fields['id']);
    //如果表名为空,则加上前一个表格;如果表名有值,则加上下一个表格
    if(trim($table->fields['table_type'])){
        $otherID = $db->Execute("select id from categories_fiber_cables_table 
                            where categories_id =".(int)$table->fields['categories_id']." 
                            and sort > ".(int)$table->fields['sort']." 
                            order by sort limit 1");
        if($otherID->fields['id']){
            $idArray =  array($products->fields['id'],$otherID->fields['id']);
        }else{
            $otherID2 = $db->Execute("select id from categories_fiber_cables_table 
                            where categories_id =".(int)$table->fields['categories_id']." and sort < ".(int)$table->fields['sort']." order by sort limit 1");

            if($otherID2->fields['id']){
                $idArray =  array($products->fields['id'],$otherID2->fields['id']);
            }else{
                $idArray =  array($products->fields['id']);
            }
        }
    }else{
        $otherID = $db->Execute("select id from categories_fiber_cables_table 
                            where categories_id =".(int)$table->fields['categories_id']." and sort < ".(int)$table->fields['sort']." order by sort limit 1");
        if($otherID->fields['id']){
            $idArray =  array($products->fields['id'],$otherID->fields['id']);
        }else{
            $otherID2 = $db->Execute("select id from categories_fiber_cables_table 
                            where categories_id =".(int)$table->fields['categories_id']." and sort > ".(int)$table->fields['sort']." order by sort limit 1");
            if($otherID2->fields['id']){
                $idArray =  array($products->fields['id'],$otherID2->fields['id']);
            }else{
                $idArray =  array($products->fields['id']);
            }
        }
    }
    for($i=0;$i<sizeof($idArray);$i++){
        $brand = $db->Execute("select brand_id,brand_name from categories_fiber_quickfinder_brand where id=".(int)$idArray[$i]." and language_id = ".$_SESSION['languages_id']." order by brand_id limit 1,5 ");
        while(!$brand->EOF){
            $brandArray [] = array(
                'id' => $idArray[$i],
                'brand_id' => $brand->fields['brand_id'],
                'brand_name' => $brand->fields['brand_name']
            );
            $brand->MoveNext();
        }

    }
    return $brandArray;
}

// 增加小语种翻译之后
// 这里使用status=0，而不是status=1。是没有激活的。主要是为了单独控制品牌关联。和QF区分开来
function fs_transceivers_related_brand_new($id){
    global $db;
    $brandArray = $idArray = array();
    $table = $db->Execute("select ct.id,ct.categories_id,ct.table_type,ct.sort from categories_fiber_quickfinder_products qp 
    left join categories_fiber_cables_table ct on (qp.id=ct.id) 
    LEFT join categories_fiber_quickfinder_brand b on b.brand_id=qp.brand_id and b.language_id=1
    where ct.status=0 and qp.products_id =".(int)$id." and b.brand_name!='More' order by pid desc,b.brand_id limit 1");
	if($table->fields['id']) {
        $idArray[] = $table->fields['id'];
        //如果表名为空,则加上前一个表格;如果表名有值,则加上下一个表格
        if(trim($table->fields['table_type'])){
            $otherID = $db->Execute("select id from categories_fiber_cables_table where categories_id =".(int)$table->fields['categories_id']." and status=0
            and sort > ".(int)$table->fields['sort']." order by sort limit 0,2");
            if($otherID->RecordCount()){
                while(!$otherID->EOF){
                    $idArray[] = $otherID->fields['id'];
                    $otherID->MoveNext();
                }
            }else{
                $otherID2 = $db->Execute("select id from categories_fiber_cables_table where categories_id =".(int)$table->fields['categories_id']." and status=0 
				and sort < ".(int)$table->fields['sort']." order by sort limit 0,2");
                if($otherID2->RecordCount()){
                    while(!$otherID2->EOF){
                        $idArray[] = $otherID2->fields['id'];
                        $otherID2->MoveNext();
                    }
                }
            }
        }else{
            $otherID = $db->Execute("select id from categories_fiber_cables_table where categories_id =".(int)$table->fields['categories_id']." and status=0 
			and sort < ".(int)$table->fields['sort']." order by sort limit 0,2");
            if($otherID->RecordCount()){
                while(!$otherID->EOF){
                    $idArray[] = $otherID->fields['id'];
                    $otherID->MoveNext();
                }
            }else{
                $otherID2 = $db->Execute("select id from categories_fiber_cables_table where categories_id =".(int)$table->fields['categories_id']." and status=0
				and sort > ".(int)$table->fields['sort']." order by sort limit 0,2");
                if($otherID2->RecordCount()){
                    while(!$otherID2->EOF){
                        $idArray[] = $otherID2->fields['id'];
                        $otherID2->MoveNext();
                    }
                }
            }
        }
        for($i=0;$i<sizeof($idArray);$i++) {
            // 2017.11.21 fairy 不管是什么语种，数据都来自英语，翻译工作在table_column_languages表里面进行。B.language_id="'.(int)$_SESSION['languages_id'].'" 修改为B.language_id="1"
            $sql =  'select B.brand_id,B.brand_name,L.content as brand_id_name
            from categories_fiber_quickfinder_brand B
            left join table_column_languages  L on B.brand_name_id = L.unique_id and L.language_id="'.(int)$_SESSION['languages_id'].'"
            where B.id="'.(int)$idArray[$i].'" and B.language_id="1"
            order by B.brand_id';
            $brand = $db->getAll($sql);
            if(trim($brand[0]['brand_name']) == 'Transceiver Type'){ //不是产品品牌,不显示
                foreach($brand  as $key => $val){
                    $brand_name =  $val['brand_id_name']?$val['brand_id_name']:$val['brand_name'];
                    $brandArray [] = array(
                        'id' => $idArray[$i],
                        'brand_id' => $val['brand_id'],
                        'brand_name' => $brand_name
                    );
                }
            }
        }
    }
    return $brandArray;
}


function fs_transceivers_related_brand_type($pid){
    global $db;
    $products = $db->Execute("select id,type from categories_fiber_quickfinder_products where products_id =".$pid." ");
    $type = $db->Execute("select type_name from categories_fiber_quickfinder_type where type_id=".(int)$products->fields['type']);
    return $type->fields['type_name'];
}

function fs_transceivers_related_brand_type_products($id,$bid,$type){
    global $db;
    $sql ="select products_id from categories_fiber_quickfinder_products as qp left join categories_fiber_quickfinder_type as qt
  on(qp.type = qt.type_id) where qt.type_name = '".$type."' and qp.id=".(int)$id." and brand_id =".(int)$bid." and products_id > 0
  order by pid desc limit 1";

    $related = $db->Execute($sql);
    return $related->fields['products_id'];
}

//fairy 获取数组。对于某些特殊的产品。2个产品是同一个产品。例如65219和65210
function fs_transceivers_related_brand_type_products_arr($id,$bid,$type){
    global $db;
    $sql ="select products_id from categories_fiber_quickfinder_products as qp left join categories_fiber_quickfinder_type as qt
  on(qp.type = qt.type_id) where qt.type_name = '".$type."' and qp.id=".(int)$id." and brand_id =".(int)$bid." and products_id > 0
  order by pid desc";
    $related = $db->getAll($sql);
    $related_products = array();
    foreach ( $related as $key => $val){
        $related_products[] = $val['products_id'];
    }
    $related_products = array_unique($related_products);
    return $related_products;
}

function fs_products_of_related($related_id){
    global $db;
    $products = array();
    if($related_id){
        $related_products = $db->Execute("select length,products_id from fiber_optic_length_related_products 
                                      where related_id=".(int)$related_id." and products_id > 0 order by sort ");
        while(!$related_products->EOF){
            $products[] = array(
                'length' => $related_products->fields['length'],
                'products_id' => $related_products->fields['products_id'],
            );
            $related_products->MoveNext();
        }
    }
    return $products;
}

function fs_fiber_optic_products_is_custom($id){
    global $db;
    $is_custom = false;
    $custom = $db->Execute("select id from fiber_optic_length_related_products where products_id =".$id." and length ='Custom'  ");
    if($custom->fields['id']){
        $is_custom = true;
    }
    return $is_custom ;
}

function fs_fiber_optic_products_length_related($id){
    global $db;
    $products = array();$Bproducts = array();
    $related_id ='';
	$group_by = '';
	$cPath = zen_get_product_path($id);
	$cPath_array = explode('_',$cPath);
	$custom_model = false;
	if(in_array($cPath_array[2],array(593,594))){
		$custom_model = true;
	}else{
		$custom_model = false;
		$group_by = ' GROUP BY P.length ';
	}
    $related = $db->Execute("select related_id,length from fiber_optic_length_related_products where products_id=".(int)$id." order by id desc limit 1 ");

    if($related->fields['related_id']){

        $sql =" select L.content as length,P.products_id from  fiber_optic_length_related_products P
        left JOIN table_column_languages L on L.unique_id = P.length_language_id and L.language_id='".$_SESSION['languages_id']."'
        where P.related_id =  ".(int)$related->fields['related_id']." and P.products_id > 0 ".$group_by." ORDER BY P.sort asc";

        $related_products = $db->Execute($sql);
        while(!$related_products->EOF){
            $Bproducts[] = array(
                'length' => $related_products->fields['length'],
                'products_id' => $related_products->fields['products_id'],
            );
            $related_products->MoveNext();
        }
    }
	if(!$custom_model){
		for($i=0;$i<sizeof($Bproducts);$i++){
			if($Bproducts[$i]['length'] == $related->fields['length']){
				$products[] = array(
					'length' => $related->fields['length'],
					'products_id' => $id,
				);
			}else{
				$products[] = array(
					'length' => $Bproducts[$i]['length'],
					'products_id' => $Bproducts[$i]['products_id'],
				);
			}
		}
	}else{
		$products = $Bproducts;
	}
    return $products;
}

//quickfinder  表格

function fs_categories_fiber_cables_table($cid){
    global $db;
    $sql="select id,table_type,table_info from categories_fiber_cables_table where categories_id=".(int)$cid." and status = 1 order by sort";
    $table = $db->Execute($sql);
    $Ctable = array();
    if($table->RecordCount()){
        while(!$table->EOF){
            $Ctable[] = array(
                'id' => $table->fields['id'],
                'filter' => $table->fields['table_type'],
                'table_info' => $table->fields['table_info']
            );
            $table->MoveNext();
        }
    }

    return $Ctable;
}

//不同的产品类型
function fs_quickfinder_table_type($id){
    global $db;
    $type = array();
//    $brandsql = $db->Execute("select * from (select * from categories_fiber_quickfinder_type ORDER BY type_id ) tt where id =".(int)$id ." GROUP BY type_name ORDER BY type_id asc");
    // 上面的语句是有问题的。获取的type_id，不是最小的那个
    // fairy 2019.3.26 modify
    $brandsql = $db->Execute("select type_name,min(type_id) as type_id from categories_fiber_quickfinder_type where id =".(int)$id ." GROUP BY type_name ORDER BY type_id asc");
    while(!$brandsql->EOF){
        $type []= array(
            'type_id' => $brandsql->fields['type_id'],
            'type_name' => $brandsql->fields['type_name']
        );
        $brandsql->MoveNext();
    }
    return $type;
}
//选择相同类型
function  fs_quickfinder_table_type_same($id,$name){
    global $db;
    $type = array();
    $sql="select type_id,type_name from categories_fiber_quickfinder_type 
 where id=".(int)$id ." and type_name = '".$name."' ORDER BY type_id ";

    $brandsql = $db->Execute($sql);
    while(!$brandsql->EOF){
        $type []= array(
            'type_id' => $brandsql->fields['type_id'],
            'type_name' => $brandsql->fields['type_name']
        );
        $brandsql->MoveNext();
    }
    return $type;
}

//quickFinder 同品牌同类型下产品
function fs_quickfinder_table_brand_type_products($id,$brand,$typename){
    global $db;
    $type = array();$products = array();
    $typeSQL = $db->Execute("select type_id from categories_fiber_quickfinder_type 
 where id =".(int)$id." and type_name ='".$typename."' ");
    while(!$typeSQL->EOF){
        $type []= $typeSQL->fields['type_id'];
        $typeSQL->MoveNext();
    }

    if(sizeof($type) > 1){
        $sql="select products_id from categories_fiber_quickfinder_products 
     where brand_id =".(int)$brand ." and type in (".join(',',$type).")  and products_id > 0 and quickfinder_status=1";
        $productssql = $db->Execute($sql);
        if($productssql->fields['products_id']){
            while(!$productssql->EOF){
                $products []= $productssql->fields['products_id'];
                $productssql->MoveNext();
            }
        }
    }
    return $products;
}

//quickfinder  表格的品牌部分
function fs_quickfinder_table_brand($id){
    global $db;
    $brandsql = $db->Execute("select brand_id,brand_name from categories_fiber_quickfinder_brand where id=".(int)$id ." and language_id = 1 order by brand_id ");
    $brand = array();

    while(!$brandsql->EOF){
        $brand []= array(
            'brand_id' => $brandsql->fields['brand_id'],
            'brand_name' => $brandsql->fields['brand_name']
        );
        $brandsql->MoveNext();
    }
    return $brand;
}

//quickfinder  表格的产品部分
function fs_quickfinder_table_brand_products($id,$brand_id,$type){
    global $db;
    $sql ="select products_id from categories_fiber_quickfinder_products 
   where id=".(int)$id." and brand_id = ".(int)$brand_id ." 
   and type= ".(int)$type ." and quickfinder_status=1
   ";
    $brandsql = $db->Execute($sql);
    return $brandsql->fields['products_id'];
}

function products_categories_reid($pid,$cid){
    global $db;
    $products = $db->Execute("select products from  products_to_categories  where products_id = ".$pid." and categories_id = ".$cid."");
    if($products->RecordCount()){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function zen_get_products_test_node($pid){
    global $db;
    $ProductsNode = array();
    $Pnode = $db->Execute("select node_id from products_test_product where products_id = ".(int)$pid." order by sort ");
    if($Pnode->RecordCount()){
        while(!$Pnode->EOF){
            $ProductsNode[] = $Pnode->fields['node_id'];
            $Pnode->MoveNext();
        }
    }
    return $ProductsNode;
}

function zen_get_products_test_equipment_images($pid,$nid){
    global $db;
    $TestImage = array();
    $TestProduct = $db->Execute("select test_id from products_test_product where products_id = ".(int)$pid." and node_id = ".(int)$nid."  ");
    if($TestProduct->fields['test_id']){
        $Images = $db->Execute("select image from products_test_productimage where test_id =".$TestProduct->fields['test_id']." order by sort ASC ");
        if($Images->RecordCount()){
            while(!$Images->EOF){
                $TestImage[] = $Images->fields['image'];
                $Images->MoveNext();
            }
        }
    }
    return $TestImage;
}

function zen_get_products_test_equipment_info($id){
    global $db;
    $info = array();
    $equipment = $db->Execute("select name,description 
                            from products_test_equipment 
                            where node_id = ".$id." and language_id = ".$_SESSION['languages_id']."");
    if($equipment->RecordCount()){
        $info = array(
            'name' => $equipment->fields['name'],
            'description' => $equipment->fields['description']
        );
    }
    return $info;
}

function zen_get_products_has_testImage($pid){
    global $db;
    $products = $db->Execute("select image from products_test_productimage where products_id = ".(int)$pid);
    if($products->RecordCount()){
        return true;
    }else{
        return false;
    }
}

//
function FS_products_name_description($id){
    global $db;
    $products_name_info ='';
    $products = $db->Execute("select products_name_info from ".TABLE_PRODUCTS_DESCRIPTION." where products_id =".(int)$id." and language_id = ".$_SESSION['languages_id']." ");
    if($products->fields['products_name_info']){
        $products_name_info = $products->fields['products_name_info'];
    }else{
        $ptc = $db->Execute("select categories_id from products_to_categories where products_id =".(int)$id." order by sort_order limit 1");
        $categories = $db->Execute("select categories_name_info from categories_description where categories_id =".(int)$ptc->fields['categories_id']." and language_id = ".$_SESSION['languages_id']."");
        $products_name_info = $categories->fields['categories_name_info'];
    }
    return $products_name_info;
}

//2014-9-5-by-melo
function zen_get_products_has_no_cid($pid){
    global $db;
    $sql = "select categories_id as cid from products_to_categories where products_id =".(int)$pid ;
    $products = $db->Execute($sql);
    if($products->fields['cid']){
        return true;
    }else{
        return false;
    }
}

//update by melo
function zen_get_products_sku_of_google($id){
    global $db;
    $products = $db->Execute("select products_SKU as sku from products where products_id=".(int)$id);
    return $products->fields['sku'];
}

function zen_get_products_leadtime_of_categories($pid){
    global $db;
    $sql="select products_processing_time as time from categories as c 
        left join products_to_categories as ptc on(c.categories_id = ptc.categories_id)
        where ptc.products_id =".(int)$pid;
    $categories = $db->Execute($sql);
    if($categories->fields['time']){
        return $categories->fields['time'];
    }
}

function zen_get_new_products($limit = false,$order_by = false){
    global $db;
    $new_products = array();
    $sql = "select p.products_id,p.products_image,pd.products_name,p.products_SKU,p.products_price from ".TABLE_PRODUCTS." as p
					left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd
					on p.products_id = pd.products_id
					where p.products_status = 1
					AND pd.language_id = ".(int)$_SESSION['languages_id'] ." 
					";
    if ($order_by) $sql .= " ORDER BY " . $order_by . " ";
    if ($limit) $sql .= " LIMIT " . $limit . " ";
    $get_products = $db->Execute($sql);
    if ($get_products->RecordCount()){
        while(!$get_products->EOF){
            $new_products [] = array(
                'id' => $get_products->fields['products_id'],
                'image' => $get_products->fields['products_image'],
                'name' => $get_products->fields['products_name'],
                'sku' => $get_products->fields['products_SKU'],
                'price' => $get_products->fields['products_price']
            );
            $get_products->MoveNext();
        }
    }
    return $new_products;
}


function zen_get_products_description_ads_html($products_id){
    global $db;
    $sql="select products_ads from ".TABLE_PRODUCTS_DESCRIPTION." where products_id = ".(int)$products_id." and language_id = ".(int)$_SESSION['languages_id'];
    $get_ads=$db->Execute($sql);
    if($get_ads->fields['products_ads']){
        $ads=$get_ads->fields['products_ads'];
        if(strpos($ads,'|')){
            $split = explode('|',$ads);
            $products_banner .= '<div class="pro_two_solution"><ul>';
            foreach ($split as $v){
                $area = explode(';',$v);
                $products_banner .= '<li><a href="'.$area[0].'" target="_blank" >
                                 <p><img src="'.$area[1].'" alt="Connectivity Solutions"></p>
                                 <div class="pro_two_solution_text">
                                 <b>'.$area[2].'</b>
                                 <span>'.$area[3].'<i class="arrow"></i></span>
                                 </div>
                                 </a>
                                 </li>';
            }
            $products_banner .= '</ul></div>';
        }else{
            $ads=explode(';',$ads);
            $language_code = fs_get_data_from_db_fields('code','languages','languages_id='.$_SESSION['languages_id'],'');
            if($_SESSION['languages_id'] !=1){
                $code = '/'.$language_code;
            }else{
                $code ='';
            }
            $products_banner='<div class="news_p_con_40Gpic"> <a href="'.$code.$ads[0].'" target="_blank"> <img src="'.$ads[1].'" alt="Connectivity Solutions" />
      <p><b>'.$ads[2].'</b>'.$ads[3].'</p><span>'.$ads[4].'<em></em></span></a></div>';
        }
        return $products_banner;
    }
}

function fs_get_product_whoelsae_info($cid,$id){
    global $db;
    $wholesale=array();$products_id=$id;$wholesale_price='';
    $wholesale_pname = fs_get_data_from_db_fields('wholesale_pname','wholesale_products','products_id='.(int)$id,'');
    $wholesale [] = array(
        'products_id' => $id,
        'wholesale_name' => $wholesale_pname,
        'products_qty' => 1,
        'wholesale_price' => zen_get_products_price($id),
        'wholesale_pid' => 0
    );

    if($cid){
        $get_products = $db->Execute("select wholesale_name,products_qty,wholesale_price,wholesale_pid from products_wholesale_price where wid = ".$cid." and products_id = ".(int)$id." order by products_qty");
    }else{
        $get_products = $db->Execute("select wholesale_name,products_qty,wholesale_price,wholesale_pid from products_wholesale_price where products_id = ".(int)$id." order by products_qty");
    }

    if ($get_products->RecordCount()){
        while(!$get_products->EOF){
            if($get_products->fields['products_qty'] > 0){

                if($get_products->fields['wholesale_pid'] >0){
                    $products_id = $get_products->fields['wholesale_pid'];
                    $wholesale_price = zen_get_products_price($get_products->fields['wholesale_pid']);
                }else{
                    $products_id = $id;
                    $wholesale_price = $get_products->fields['wholesale_price'];
                }

                $wholesale [] = array(
                    'products_id' => $products_id,
                    'wholesale_name' => $get_products->fields['wholesale_name'],
                    'products_qty' => $get_products->fields['products_qty'],
                    'wholesale_price' => $wholesale_price,
                    'wholesale_pid' => $get_products->fields['wholesale_pid'],
                );
            }
            $get_products->MoveNext();

        }
    }
    return $wholesale;
}



function fs_get_product_wholesale_price_of_qty($id,$qty){
    global $db;
    //$wholesale=array();
    //$wholesale = fs_get_product_whoelsae_info('',$id);
    $price = zen_get_products_price($id);
    return $price;
    /*
    if (sizeof($wholesale)){
       $wholesale_price ='';
       $max = sizeof($wholesale);
       for($p=0;$p<$max;$p++){
         if($wholesale[$p]['products_qty'] <= $qty && $qty < $wholesale[$p+1]['products_qty']){
         $wholesale_price = $wholesale[$p]['wholesale_price'];
         }else if($qty >= $wholesale[$max-1]['products_qty']){
         $wholesale_price = $wholesale[$max-1]['wholesale_price'];
         }
       }
       return $wholesale_price;
     }else{
     return false;
     }
     */
}

function fs_get_wholesale_products_array(){
    global $db;
    $products = array();
    //取消产品价格取整
    $whoelsale = $db->Execute("select products_id from products where products_status=1 and integer_state=1");
    while(!$whoelsale->EOF){
        $products [] = $whoelsale->fields['products_id'];
        $whoelsale->MoveNext();
    }
    return $products;
}


function fs_manage_html_structure_of_products_new($id,$current_category_id=''){
    global $db,$currencies;
    $content ='';
    if($current_category_id){
        $categories_name = zen_get_categories_name($current_category_id);
    }
    $fields_array = array('module1','module2','module3','module4','module5','module6','module7','module8','module9','module10','module11','module12','module13','module14','module15','module16','module17','module18','module19','module20','merge_modules');
    $products_info = fs_get_data_from_db_fields_array($fields_array,TABLE_PRODUCTS_DESCRIPTION,'products_id ='.$id.' and language_id = '.(int)$_SESSION['languages_id'],' limit 1');

    $tag=$description=$ui_li=$alt=$section='';
    $title_num=$second=$third=0;
    $no_li =$pic_first= false;

    $merge_modules_str = $products_info[0][20]; // 数据库中只展示合并的第一modules。
    $merge_modules_arr =  array();
    if(!empty($merge_modules_str)){ // merge_modules字段
        $merge_modules_arr =  explode(',',$merge_modules_str);
        $two_merge_modules_str =  array(); // 第二个的modules
        foreach ($merge_modules_arr as $key => $val){
            $two_merge_modules_str[] = $val+1;
        }
        $merge_modules_arr = array_merge($merge_modules_arr,$two_merge_modules_str);
    }

    for($i=0;$i<(sizeof($fields_array)-1);$i++){
        $temp = explode('{{{', $products_info[0][$i]);
        foreach ($temp as $temp_value) {
            if (empty($temp_value)) {
               continue;
            }
            $tag = explode('##', $temp_value);
            if ($merge_modules_arr && in_array(($i + 1), $merge_modules_arr)) {  // 如果在合并的modules存在，则增加浮动样式
                $content .= '<div class="p_con_module">';
            } else {
                $content .= '<div>';
            }
            if (sizeof($tag) > 1) {
                $tag[0] = trim($tag[0]);
                //去除$tag[1]结尾多余的;防止影响结构拼接展示
                $tag[1] = trim($tag[1]);
                $tag[1] = rtrim($tag[1],';');
                switch ($tag[0]) {
                    case 'FS12':
                        if ($i != 0) {
                            $content .= '<hr>';
                        }
                        $content .= '<div class="pre_order_optimized">';
                        $description = explode(";", $tag[1]);
                        foreach ($description as $k => $v) {
                            if ($k == 0) {
                                $content .= '<div class="pre_order_assure_title"><h2>' . $description[$k] . '</h2>';
                            } elseif ($k == 1) {
                                $content .= '<p class="order_assure_title_state">' . $description[$k] . '</p></div><div class="pre_order_assure_main"><ul class="order_optimized_ul">';
                            } else {
                                $ui_li = explode("**", $description[$k]);
                                if (count($ui_li) == 2) {
                                    $li_li = explode("@@", $ui_li[1]);
                                    $content .= '<li class="order_optimized_li">';
                                    if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                        $content .= '<div class="order_optimized_img">';
                                        $ui_li[0] = trim($ui_li[0]);

                                        if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                        }

                                        $content .= '<a href="' . trim($li_li[0]) . '"><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '"></a>';
                                        $content .= '</div>';
                                    }
                                    $content .= '<div class="order_optimized_title">
                                                <a class="order_optimized_a" href="' . trim($li_li[0]) . '">' . $li_li[1] . '</a>
                                            </div>';
                                    $content .= ' </li>';
                                }
                            }

                        }
                        $content .= '</ul></div><div class="p_con_02"></div></div>';
                        break;
                    case 'FS01':
                    case 'FS01_1':
                        $css_name = $tag[0] == 'FS01_1' ? 'mux_demux_highlights' : 'mux_demux_craftsmanship';
                        //if($i != 0){
                        //    $content .= '<hr>';
                        //}
                        $content .= '<hr>';
                        $content .= '<div class="' . $css_name . '">';
                        $description = explode(";", $tag[1]);

                        $pic_qty = 0;
                        foreach ($description as $tc) {
                            if (strpos($tc, ".jpeg") || strpos($tc, ".jpg") || strpos($tc, ".png") || strpos($tc, ".gif")) {
                                $pic_qty++;
                            }
                        }
                        $section = sizeof($description) - $pic_qty;                               /* 模块节点数, 四个时有:标题,加粗,说明,图片;三个时:标题,说明,图片   */
                        $ui_li = '';
                        if (strpos($description[0], ".jpeg") || strpos($description[0], ".jpg") || strpos($description[0], ".png") || strpos($description[0], ".gif")) {    /* 模块第一行是不是图片 */
                            $pic_first = true;
                        } else {
                            $pic_first = false;
                        }
                        for ($fs = 0; $fs < sizeof($description); $fs++) {
                            $ui_li = explode(":", $description[$fs]);                    /* 用 逗号 ; 分割之后的每一行 */
                            if (sizeof($ui_li) == 1) {
                                if (strpos($description[$fs], ".jpeg") || strpos($description[$fs], ".jpg") || strpos($description[$fs], ".png") || strpos($description[$fs], ".gif")) {
                                    $alt = ($fs == 0) ? $description[1] : $description[0];   /* alt标签 -> 引用标题 */

                                    if ((strpos($description[$fs], '.webp') !== false) && (!is_support_webp())) {
                                        $description[$fs] = substr($description[$fs], 0, strrpos($description[$fs], '.webp'));
                                    }

                                    $content .= '<div class="mux_demux_p_pic"><img src="' . HTTPS_IMAGE_SERVER . trim($description[$fs]) . '" alt="' . $categories_name . ' ' . $alt . '"></div>';   /*最终图片*/
                                } else {

                                    if ($section && $fs == 0) {
                                        $content .= '<div class="mux_demux_craftsmanship_tit">' . $description[$fs] . '</div>';    /* 标题 */
                                    } else {
                                        if ($section > 1 && $fs == 1) {
                                            $content .= '<div class="mux_demux_craftsmanship_text">';    /* 如果有说明文字 */
                                        }
                                        if ($fs == 1) {  //$section ==3 &&
                                            $content .= '<p>' . $description[$fs] . '</p>';  //  <b>
                                    //}else{
                                    //    $content .= '<p>'.$description[$fs].'</p>';
                                    //}
                                        }
                                        //表明此结构为链接
                                        if ($fs == 2 && (strpos($description[$fs], ".html") || strpos($description[$fs], ".pdf"))) {
                                            $des = explode('&', $description[$fs]);

                                            $des=str_replace_http($des);

                                            $a_href = $des[0];
                                            if(strpos($a_href, ".html")){
                                                $a_href = reset_url($a_href);
                                            }
                                            $content .= '<div class="new-mtp-a-con"><a href="' . $a_href . '" target="_blank">' . $des[1] . '</a><i class="iconfont icon">&#xf441;</i></div><br>';

                                        }
                                        //表明此结构为认证图标
                                        if ($fs == 2 && strpos($description[$fs], ".ICON")) {
                                            $the_icon = array(
                                                'icon01' => PRO_AUTHENTICATION_ICON_01 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon02' => PRO_AUTHENTICATION_ICON_02 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon03' => PRO_AUTHENTICATION_ICON_03 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon04' => PRO_AUTHENTICATION_ICON_04 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon05' => PRO_AUTHENTICATION_ICON_05 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon06' => PRO_AUTHENTICATION_ICON_06 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon07' => PRO_AUTHENTICATION_ICON_07 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon08' => PRO_AUTHENTICATION_ICON_08 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                                'icon09' => PRO_AUTHENTICATION_ICON_09 . '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '" target="_blank">' . FS_QUALITY_CONTACT_US . '</a>' . PRO_AUTHENTICATION_LEARN,
                                            );
                                            $content .= '<div class="pro_authentication_icon"><ul class="new-mtp-ul03">';
                                            $all_icon = explode('-', trim($description[$fs]));
                                            array_pop($all_icon); //去掉.ICON的标识
                                            foreach ($all_icon as $k => $icon) {
                                                foreach ($the_icon as $key => $icons) {
                                                    if ($icon == $key) {
                                                        $content .= '<li class="pro_authentication_' . $icon . '"><div class="track_orders_wenhao"><div class="question_text_01 leftjt">';
                                                        $content .= '<div class="arrow"></div><div class="popover-content">' . $icons . '</div></div></div></li>';
                                                    }
                                                }

                                            }
                                            $content .= '</ul></div>';

                                        }
                                        if ($section && $fs == ($section - 1)) {
                                            $content .= '</div>';
                                        }
                                    }
                                }
                            } else {                                                     /* 如果一行有多节文字  */
                                $content .= '<div class="mux_demux_p_text"><ul>';
                                for ($li = 0; $li < sizeof($ui_li); $li++) {
                                    $content .= '<li>' . $ui_li[$li] . '<div class="mux_demux_decorate"></div></li>';              /* 标题下文字说明 */
                                }
                                $content .= '</ul></div>';
                            }
                        }
                        $content .= '</div>';
                        break;
                    case 'FS01_2':
                        if ($i != 0) {
                            $content .= '<hr>';
                        }
                        $description = explode('|', $tag[1]);
                        if (sizeof($description)) {
                            if (strpos($description[0], '@@TITLE') !== false) {
                                $title = str_replace('@@TITLE', '', $description[0]);
                                unset($description[0]);
                                reset($description);
                            }
                            $content .= '<div class="mux_demux_craftsmanship">
                                            <div class="mux_demux_craftsmanship_tit">' . $title . '</div>
                                            <div class="mux_demux_p_pic">
                                                <div class="optical-main">
                                                    <ul class="optical-main-ul">';
                            foreach ($description as $value){
                                if(!empty($value)) {
                                    $li_each = explode(';', $value);
                                    $content .= '<li class="optical-main-li">';
                                    if (strpos($li_each[0], ".jpeg") || strpos($li_each[0], ".jpg") || strpos($li_each[0], ".png") || strpos($li_each[0], ".gif")) {
                                        $pic_data = explode('@@', $li_each[0]);

                                        if ((strpos($pic_data[0], '.webp') !== false) && (!is_support_webp())) {
                                            $pic_data[0] = substr($pic_data[0], 0, strrpos($pic_data[0], '.webp'));
                                        }

                                        $content .= '<div class="optical-main-li-img"><img src="' . HTTPS_IMAGE_SERVER .trim($pic_data[0]) . '" alt="' . $pic_data[1] . '"></div>';
                                    }
                                    $content .= '<div class="optical-main-item">
                                                    <div class="optical-main-tit">
                                                        '.trim($li_each[1]).'
                                                    </div>';
                                    $content .='<p> ' .$li_each[2] .'</p>';
                                    $products_des_data = explode(':',$li_each[3]);
                                    if(!empty($products_des_data)){
                                        $content .= '<div class="optical-main-item-explain">';
                                        foreach ($products_des_data as $des){
                                            $content .= '<div><span class="circle-icon"></span>
                                                 <span class="optical-main-item-explain-txt">'.$des.'</span>
                                           </div>';
                                        }
                                        $content .= '</div>';
                                    }
                                    $content .= '</div></li>';
                                }
                            }
                            $content .= '</ul>
                                    </div>
                                </div>
                            </div>';
                        }
                        break;
                    case 'FS011':
                    case 'FS01_11':
                        $css_name = $tag[0] == 'FS11' ? 'mux_demux_highlights' : 'mux_demux_craftsmanship';
                        if ($i != 0) {
                            $content .= '<hr>';
                        }
                        $content .= '<div class="' . $css_name . '">';
                        $description = explode(";", $tag[1]);
                        for ($fs = 0; $fs < sizeof($description); $fs++) {
                            if ($fs == 0) {
                                $ui_li = explode(":", $description[0]);                    /* 用 逗号 ; 分割之后的每一行 */
                                $content .= '<div class="mux_demux_craftsmanship_tit">' . $ui_li[0] . '</div>';
                                if (isset($ui_li[4]) && (!empty($ui_li[4]))) {
                                    $content .= '<div class="mux_demux_craftsmanship_text"><p>' . $ui_li[4] . '</p></div>';
                                }
                                $content .= '<div class="mun_a01"><a href="' . $ui_li[2] . ':' . $ui_li[3] . '">' . $ui_li[1] . '</a><i class="iconfont icon">&#xf089;</i></div>';
                                /* 标题 */
                            } else {
                                if (strpos($description[$fs], ".jpeg") || strpos($description[$fs], ".jpg") || strpos($description[$fs], ".png") || strpos($description[$fs], ".gif")) {
                                    $alt = ($fs == 0) ? $description[1] : $description[0];   /* alt标签 -> 引用标题 */
                                    if ((strpos($description[$fs], '.webp') !== false) && (!is_support_webp())) {
                                        $description[$fs] = substr($description[$fs], 0, strrpos($description[$fs], '.webp'));
                                    }

                                    $content .= '<div class="mux_demux_p_pic"><img src="' . HTTPS_IMAGE_SERVER . trim($description[$fs]) . '"></div>';   /*最终图片*/
                                }
                            }
                        }
                        $content .= '</div>';
                        break;
                    case 'FS07':
                    case 'FS01_7':
                        $content .= '<div class="img_font01_wap">';
                        $content .= '<hr>';
                        $description = explode(";", $tag[1]);
                        $number = 0;
                        foreach ($description as $k => $v) {
                            if ($k <= 6) {
                                if ($k == 0) {
                                    $ui_li = explode(":", $description[$k]);
                                    $ui_li=str_replace_http($ui_li);

                                    if ($ui_li[0]) {
                                        $content .= '<h2 class="Optimization_h2">' . $ui_li[0] . '</h2>
                                    <p class="describe_p01">' . $ui_li[1] . '</p>
                                    <div class="op_dl_wap">';
                                    }
                                } else {
                                    $ui_li = explode(":", $description[$k]);
                                    if (count($ui_li) == 3) {
                                        $number += 1;

                                        $content .= '<dl class="op_dl"><dt>';
                                        if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                            if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                                $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                            }
                                            $content .= '<img class="carr" src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '">';
                                        }
                                        $content .= '</dt><dd>
				                     <h2 class="op_dd_h2">' . $ui_li[1] . '</h2>
				                     <p class="op_dd_p">' . $ui_li[2] . '</p>
                                     </dd>
                                     </dl>';
                                        if ($number % 3 == 0) {
                                            $content .= '<div style="clear:both;"></div>';
                                        }
                                    }
                                }
                            }
                        }
                        $content .= '</div></div>';
                        break;
                    case 'FS08':
                    case 'FS01_8':
                        $content .= '<div><hr>';
                        $description = explode(";", $tag[1]);


                        foreach ($description as $k => $v) {
                            if ($k == 0) {
                                $ui_li = explode(":", $description[$k]);

                                $ui_li=str_replace_http($ui_li);

                                $content .= '<div class="mux_demux_craftsmanship op_conta">
                                <div class="mux_demux_craftsmanship_tit">' . $ui_li[0] . '</div>
                                <p class="describe_p01">' . $ui_li[1] . '</p>
                                <div class="op_dl_wap1">';
                            } else {
                                $ui_li = explode(":", $description[$k]);

                                if (count($ui_li) == 2 && $ui_li[0] != "") {
                                    $content .= '<dl class="op_dl01">';
                                    if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {

                                        if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                        }
                                        $content .= '<dt><img class="car" src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '"></dt>	';
                                    }
                                    $content .= '	
                                        <dd>			
                                        <div class="op_middle">' . $ui_li[1] . '</div>		
                                        </dd>
                                        </dl>';
                                }
                            }
                        }
                        $content .= '</div></div></div>';
                        break;
                    case 'FS09':
                    case 'FS01_9':
                        $content .= '<div><hr>';
                        $description = explode(";", $tag[1]);
                        foreach ($description as $k => $v) {
                            if ($k == 0) {
                                $ui_li = explode(":", $description[$k]);

                                $ui_li=str_replace_http($ui_li);

                                $content .= '<div class="mux_demux_craftsmanship">
                                             <div class="mux_demux_craftsmanship_tit">' . $ui_li[0] . '</div>
                                             <p class="describe_p01">' . $ui_li[1] . '</p>
                                             <div class="op_conta">
                                             <div class="op_table">';
                            } elseif ($k == 1) {
                                $ui_li = explode(":", $description[$k]);
                                if (count($ui_li) == 3) {
                                    $content .= '<div class="op_tr">
                                                 <div class="op_td op_th op_one">' . $ui_li[0] . '</div>
                                                 <div class="op_td op_th op_two">' . $ui_li[1] . '</div>
                                                 <div class="op_td op_th op_three">' . $ui_li[2] . '</div>
                                                 </div>';
                                }
                            } else {
                                $ui_li = explode(":", $description[$k]);
                                if (count($ui_li) == 3) {
                                    $content .= '<div class="op_tr">
                                                 <div class="op_td op_one">';
                                    if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                        if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                        }
                                        $content .= '<img class="car" src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '">';
                                    }
                                    $content .= '</div><div class="op_td op_two">' . $ui_li[1] . '</div>
                                                 <div class="op_td op_three">' . $ui_li[2] . '</div>
                                                 </div>';
                                }
                            }
                        }
                        $content .= '</div></div></div></div>';
                        break;
                    case 'FS10':
                        $content .= '<div><hr>';
                        $description = explode(";", $tag[1]);
                        foreach ($description as $k => $v) {
                            if ($k == 0) {
                                $ui_li = explode(":", $description[$k]);

                                $ui_li=str_replace_http($ui_li);

                                $content .= '<div class="mux_demux_craftsmanship">
                                             <div class="mux_demux_craftsmanship_tit">' . $ui_li[0] . '</div>
                                             <p class="describe_p01">' . $ui_li[1] . '</p>
                                             <div class="op_conta">
                                             <div class="op_table table_four">';
                            } elseif ($k == 1) {
                                $ui_li = explode(":", $description[$k]);
                                if (count($ui_li) == 4) {
                                    $content .= '<div class="op_tr">
                                                 <div class="op_td op_th op_one">' . $ui_li[0] . '</div>
                                                 <div class="op_td op_th op_two">' . $ui_li[1] . '</div>
                                                 <div class="op_td op_th op_three">' . $ui_li[2] . '</div>
                                                 <div class="op_td op_th op_four">' . $ui_li[3] . '</div>
                                                 </div>';
                                }
                            } else {
                                $ui_li = explode(":", $description[$k]);
                                if (count($ui_li) == 4) {
                                    $content .= '<div class="op_tr">
                                                     <div class="op_td op_one">' . $ui_li[0] . '</div>
                                                     <div class="op_td op_two">' . $ui_li[1] . '</div>
                                                     <div class="op_td op_three">' . $ui_li[2] . '</div>
                                                     <div class="op_td op_four">' . $ui_li[3] . '</div>
                                                     </div>';
                                }
                            }
                        }
                        $content .= '</div></div></div></div>';
                        break;
                    case 'FS11':
                        $description = explode(";", $tag[1]);
                        $ui_li = explode(":", $description[0]);
                        if ($ui_li[0] != " " && $ui_li[0] != "") {
                            $content .= '<div><hr><div class="mux_demux_craftsmanship op_conta">';
                        } else {
                            //$content .= '<div><div class="mux_demux_craftsmanship op_conta">';
                            $content .= '<div><hr><div class="mux_demux_craftsmanship op_conta">';
                        }
                        foreach ($description as $k => $v) {
                            if ($k == 0 && !empty($ui_li[0])) {

                                $ui_li=str_replace_http($ui_li);

                                $content .= '<div class="mux_demux_craftsmanship_tit">' . $ui_li[0] . '</div>
                                          <p class="describe_p01">' . $ui_li[1] . '</p>';
                                if (strpos($ui_li[2], ".jpeg") ||strpos($ui_li[2], ".jpg") || strpos($ui_li[2], ".png") || strpos($ui_li[2], ".gif")) {
                                    if ((strpos($ui_li[2], '.webp') !== false) && (!is_support_webp())) {
                                        $ui_li[2] = substr($ui_li[2], 0, strrpos($ui_li[2], '.webp'));
                                    }

                                    $content .= '<div class="mux_demux_p_pic op_img_wap01">
                                             <img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[2]) . '">
                                         </div>';
                                }
                            } elseif ($k != 0) {
                                $ui_li = explode(":", $description[$k]);
                                if (count($ui_li) == 3) {
                                    $content .= '<dl class="op_dl01">
                                    <dt>';
                                    if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {

                                        if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                        }
                                        $content .= '<img class="car" src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '">';
                                    }
                                    $content .= '</dt><dd>			
                                    <h2>' . $ui_li[1] . '</h2>
                                    <p>' . $ui_li[2] . '</p>	
                                    </dd>
                                    </dl>';
                                }
                            }
                        }
                        $content .= '</div></div>';
                        break;
                    case 'FS012':
                    case 'FS01_12':
                        $content .= '<div class="img_font01_wap">';
                        $description = explode(";", $tag[1]);
                        foreach ($description as $k => $v) {
                            if ($k <= 6) {
                                if ($k == 0) {
                                    $ui_li = explode(":", $description[$k]);
                                    $ui_li=str_replace_http($ui_li);

                                    if ($ui_li[0]) {
                                        $content .= '<hr><h2 class="Optimization_h2">' . $ui_li[0] . '</h2>
                                    <p class="describe_p01">' . $ui_li[1] . '</p>
                                    <div class="op_dl_wap">';
                                    }
                                } else {
                                    $ui_li = explode(":", $description[$k]);
                                    if (count($ui_li) == 3) {
                                        $content .= '<dl class="op_dl"><dt>';
                                        if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                            $content .= '<img class="carr" src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '">';
                                        }
                                        $content .= '</dt><dd>
				                     <h2 class="op_dd_h2">' . $ui_li[1] . '</h2>
				                     <p class="op_dd_p">' . $ui_li[2] . '</p>
                                     </dd>
                                     </dl>';
                                    }
                                }
                            }
                        }
                        $content .= '</div></div>';
                        break;
                    case 'FS02':                                 /* 两张图的模块 , 图片可放上或下*/
                    case 'FS02_1':
                        if ($tag[0] == 'FS02') {
                            $css_name = 'mux_demux_duplex';
                        } elseif ($tag[0] == 'FS02_1') {
                            $css_name = 'mux_demux_duplex product_con_bg';
                        } else {
                            $css_name = 'mux_demux_duplex';
                        }
                        $description = explode(";", $tag[1]);
                        $content .= '<hr>';
                        $content .= '<div class="' . $css_name . '"><ul>';
                        $title = false;
                        for ($fs = 0; $fs < sizeof($description); $fs++) {
                            $ui_li = explode(":", $description[$fs]);
                            $content .= '<li>';
                            if (is_numeric(trim($ui_li[0])) && trim($ui_li[0]) > 0) {          /* 是否链接 */
                                $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . trim($ui_li[0]));
                                $content .= '<a target="_blank" href="' . $href . '">';             //标题
                            }
                            $title_num = $href ? 1 : 0;                     /* 标题 */
                            if (sizeof($ui_li) == 1) {
                                if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                    $content .= '<span><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '" alt="' . $categories_name . '"></span>';   //最终图片
                                } else {
                                    $content .= '<p>' . $ui_li[0] . '</p>';             //标题
                                }
                            } else {
                                if (sizeof($ui_li) == 3) {
                                    $title = true;
                                }
                                for ($li = $title_num; $li < sizeof($ui_li); $li++) {
                                    if (strpos($ui_li[$li], ".jpeg") || strpos($ui_li[$li], ".jpg") || strpos($ui_li[$li], ".png") || strpos($ui_li[$li], ".gif")) {
                                        $alt = ($li == 0) ? $ui_li[1] : $ui_li[0];   /* alt标签 -> 引用标题 */

                                        if ((strpos($ui_li[$li], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[$li] = substr($ui_li[$li], 0, strrpos($ui_li[$li], '.webp'));
                                        }

                                        $content .= '<span><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[$li]) . '" alt="' . $categories_name . ' ' . $alt . '"></span>';   //最终图片
                                    } else {
                                        if ($title && $li == 0) {
                                            $content .= '<b>' . $ui_li[$li] . '</b>';             //标题
                                        } else {
                                            $content .= '<p>' . $ui_li[$li] . '</p>';             //标题
                                        }

                                    }
                                }
                            }
                            if ($href) {          /* 是否链接 */
                                $content .= '</a>';             //标题
                            }
                            $content .= '</li>';
                        }
                        $content .= '</ul></div>';
                        break;

                    case 'FS06':
                        $title_html = '';
                        if ($tag[0] == 'FS06') {
                            $css_name = 'product_six_circle';
                            if ($i != 0) {
                                $content .= '<hr>';
                            }
                            $title_description = explode('#', $tag[1]);
                            if (sizeof($title_description) > 1) {
                                $title_html .= '<div class="product_six_circle_tit">' . $title_description[0] . '</div>';
                            }
                        } else {
                            $css_name = 'mux_demux_duplex';
                        }
                        if ($title_description[1]) {
                            $tag[1] = $title_description[1];
                        }
                        $description = explode(";", $tag[1]);
                        $content .= '<div class="' . $css_name . '">' . $title_html . '<ul>';
                        $title = false;
                        for ($fs = 0; $fs < sizeof($description); $fs++) {
                            $ui_li = explode(":", $description[$fs]);
                            $content .= '<li>';
                            if (is_numeric(trim($ui_li[0])) && trim($ui_li[0]) > 0) {          /* 是否链接 */
                                $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . trim($ui_li[0]));
                                $content .= '<a target="_blank" href="' . $href . '">';             //标题
                            }
                            $content .= '<dl>';
                            $title_num = $href ? 1 : 0;                     /* 标题 */
                            if (sizeof($ui_li) == 1) {
                                if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                    if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                        $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                    }
                                    $content .= '<dt><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '" alt="' . $categories_name . '"></dt>';   //最终图片
                                } else {
                                    $content .= '<dd><span>' . $ui_li[0] . '</dd></span>';             //标题
                                }
                            } else {
                                if (sizeof($ui_li) == 3) {
                                    $title = true;
                                }
                                for ($li = $title_num; $li < sizeof($ui_li); $li++) {
                                    if (strpos($ui_li[$li], ".jpeg") || strpos($ui_li[$li], ".jpg") || strpos($ui_li[$li], ".png") || strpos($ui_li[$li], ".gif")) {
                                        $alt = ($li == 0) ? $ui_li[1] : $ui_li[0];   /* alt标签 -> 引用标题 */

                                        if ((strpos($ui_li[$li], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[$li] = substr($ui_li[$li], 0, strrpos($ui_li[$li], '.webp'));
                                        }

                                        $content .= '<dt><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[$li]) . '" alt="' . $categories_name . ' ' . $alt . '"></dt>';   //最终图片
                                    } else {
                                        if ($title && $li == 1) {
                                            $content .= '<dd><span>' . $ui_li[$li] . '</span>';             //标题
                                        } else {
                                            $content .= '<p>' . $ui_li[$li] . '</p>';             //标题
                                        }
                                    }
                                }
                                $content .= '</dd>';
                            }
                            $content .= '</dl>';
                            if ($href) {          /* 是否链接 */
                                $content .= '</a>';             //标题
                            }
                            $content .= '</li>';
                        }
                        $content .= '</ul></div>';
                        break;

                    case 'FS03':                                     /* 三张图的模块 , 图片可放上或下*/
                    case 'FS03_1':                                     /* 三张图的模块 , 图片可放上或下 圆角 */
                    case 'FS03_2':
                        $is_number = explode(':', $tag[1]);






                        if (!is_numeric($is_number[0])) {
                            if ($tag[0] == 'FS03') {
                                $css_name = 'mux_demux_duplex_pro';
                            } elseif ($tag[0] == 'FS03_1') {
                                $css_name = 'product_three_column';
                            } else {
                                $css_name = 'product_three_circle';
                            }
                            $description = explode(";", $tag[1]);


                            $content .= '<div class="' . $css_name . '">';
                            $fs = 0;
                            if (!strpos($description[0], ".jpeg") && !strpos($description[0], ".jpg") && !strpos($description[0], ".png") && !strpos($description[0], ".gif")) {
                                /* 第一段没有图片,则为标题 */
                                $fs++;
                                $content .= '<div class="p_con_new_tit03">' . $description[0] . '</div>';
                                if (!strpos($description[1], ".jpeg") && !strpos($description[1], ".jpg") && !strpos($description[1], ".png") && !strpos($description[1], ".gif")) {
                                    /* 第二段没有图片,则为标题+说明 */
                                    $fs++;
                                    $content .= '<div class="p_con_02">' . $description[1] . '</div>';
                                    if (!strpos($description[2], ".jpeg") && !strpos($description[2], ".jpg") && !strpos($description[2], ".png") && !strpos($description[2], ".gif")) {
                                        /* 第三段没有图片,则为标题+说明+说明 */
                                        $fs++;
                                        $content .= '<div class="p_con_02">' . $description[2] . '</div>';
                                    }
                                }
                            }

                            $title = false;
                            $li_num = 0;
                            $is_mobile = isMobile();
                            $content .= '<ul>';
                            for ($fs; $fs < sizeof($description); $fs++) {
                                $ui_li = explode(":", $description[$fs]);
                                $li_num = sizeof($ui_li);

                                if ($is_mobile) {
                                    //将图片放到最后
                                    $temp_ui_li = [];
                                    foreach ($ui_li as $ui_li_k => $ui_li_v) {
                                        if (strpos($ui_li_v, ".jpeg") || strpos($ui_li_v, ".jpg") || strpos($ui_li_v, ".png") || strpos($ui_li_v, ".gif")) {
                                            $temp_ui_li[$li_num] = $ui_li_v;
                                        } else {
                                            $temp_ui_li[$ui_li_k] = $ui_li_v;
                                        }
                                    }
                                    ksort($temp_ui_li);
                                    $temp_ui_li = array_filter($temp_ui_li);
                                    $ui_li = array_values($temp_ui_li);
                                    $li_num = sizeof($ui_li);
                                }



                                $href = '';
                                $content .= '<li>';
                                if (is_numeric(trim($ui_li[0])) && trim($ui_li[0]) > 0) {          /* 是否链接 */
                                    $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . trim($ui_li[0]));
                                    $content .= '<a target="_blank" href="' . $href . '">';             //标题
                                }
                                $title_num = $href ? 1 : 0;                     /* 标题 */
                                $content .= '<dl>';
                                if (sizeof($ui_li) == 1) {                         /* 一行只有图片或文字的情况 */
                                    if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {

                                        if ((strpos($ui_li[0], '.webp') !== false) && (!is_support_webp())) {
                                            $ui_li[0] = substr($ui_li[0], 0, strrpos($ui_li[0], '.webp'));
                                        }

                                        $content .= '<dt style="margin-top:10px;"><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[0]) . '" alt="' . $categories_name . '"></dt>';   //最终图片
                                    } else {
                                        $content .= '<dd><span>' . $ui_li[0] . '</span></dd>';             //标题
                                    }
                                } else {
                                    if ((!$href && sizeof($ui_li) == 3) || (sizeof($ui_li) == 4)) {
                                        $title = true;
                                    }
                                    for ($li = $title_num; $li < $li_num; $li++) {
                                        if (strpos($ui_li[$li], ".jpeg") || strpos($ui_li[$li], ".jpg") || strpos($ui_li[$li], ".png") || strpos($ui_li[$li], ".gif")) {
                                            $alt = ($li == 0) ? $ui_li[1] : $ui_li[0];   /* alt标签 -> 引用标题 */

                                            if ((strpos($ui_li[$li], '.webp') !== false) && (!is_support_webp())) {
                                                $ui_li[$li] = substr($ui_li[$li], 0, strrpos($ui_li[$li], '.webp'));
                                            }

                                            $content .= '<dt style="margin-top:10px;"><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[$li]) . '" alt="' . $categories_name . ' ' . $alt . '"></dt>';   //最终图片
                                        } else {

                                            if ($title && $li == ($li_num - 1)) {
                                                $content .= '<p>' . $ui_li[$li] . '</p>';                      //标题下文字说明
                                            } else {
                                                $content .= '<dd><span>' . $ui_li[$li] . '</span>';             //标题
                                            }
                                        }
                                    }
                                    $content .= '</dd>';
                                }
                                $content .= '</dl>';
                                if ($href) {          /* 是否链接 */
                                    $content .= '</a>';             //标题
                                }
                                $content .= '</li>';
                            }
                            $content .= '</ul></div>';
                        }

                        break;

                    case 'FS05':
                        //if($i != 0){
                        //    $content .= '<hr>';
                        //}
                        $content .= '<hr>';
                        $description = explode(";", $tag[1]);
                        $title = $pic_first = false;
                        $li_num = $title_num = 0;
                        $css_name = $ui_li = '';
                        $info = 2;

                        $is_mobile = isMobile();

                        for ($fs = 0; $fs < sizeof($description); $fs++) {
                            if($description[$fs]){
                                $ui_li = explode(":", $description[$fs]);
                                $li_num = sizeof($ui_li);

                                //2020.07.27 liang.zhu
                                if (($li_num > 0) && $is_mobile) {
                                    //将图片放在最后，
                                    $temp_ul_li = [];
                                    foreach ($ui_li as $ui_li_k => $ui_li_v) {
                                        if (empty($ui_li_v)) {
                                            continue;
                                        }
                                        if (strpos($ui_li_v, ".jpeg") || strpos($ui_li_v, ".jpg") || strpos($ui_li_v, ".png") || strpos($ui_li_v, ".gif")) {
                                            $temp_ul_li[$li_num]  = $ui_li_v;
                                        } else {
                                            $temp_ul_li[$ui_li_k] = $ui_li_v;
                                        }
                                    }
                                    //过滤掉为空的
                                    ksort($temp_ul_li);//排序之后再获取值
                                    $temp_ul_li = array_filter($temp_ul_li);
                                    $ui_li = array_values($temp_ul_li);
                                    $li_num = sizeof($ui_li);
                                }


                                $href = '';
                                if (is_numeric(trim($ui_li[0])) && trim($ui_li[0]) > 0) {          /* 是否链接 */
                                    $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . trim($ui_li[0]));
                                    $content .= '<a target="_blank" href="' . $href . '">';
                                }


                                if (strpos($ui_li[0], ".jpeg") || strpos($ui_li[0], ".jpg") || strpos($ui_li[0], ".png") || strpos($ui_li[0], ".gif")) {
                                    /* 模块第一行是不是图片 */
                                    $pic_first = true;
                                    $css_name = '';
                                    $info = 1;
                                } else {
                                    $pic_first = false;
                                    $css_name = ' adapter_position';
                                    $info = 0;
                                }
                                /* 标题 */
                                $title_num = $href ? 1 : 0;
                                if (sizeof($ui_li) == 1) {
                                    /* 一行只有图片或文字的情况 */
                                    $content .= '<div class="adapter_tit">' . $ui_li[0] . '</div>';
                                } else {
                                    $content .= '<div class="adapter_highlights ' . $css_name . '">';

                                    if ((!$href && sizeof($ui_li) == 3) || (sizeof($ui_li) == 4)) {
                                        $title = true;
                                    }
                                    for ($li = $title_num; $li <= $li_num; $li++) {
                                        if (empty($ui_li[$li])) {
                                            continue;
                                        }
                                        //if (strpos($ui_li[$li], ".jpg") || strpos($ui_li[$li], ".png") || strpos($ui_li[$li], ".gif")) {
                                        //    $alt = ($li == 0) ? $ui_li[1] : $ui_li[0];
                                        //    /* alt标签 -> 引用标题 */
                                        //    $content .= '<div class="adapter_highlights_pic "><img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[$li]) . '" alt="' . $categories_name . ' ' . $alt . '"></div>';   //最终图片
                                        //} else {
                                        //    if ($li == $info) {
                                        //        $content .= '<div class="adapter_highlights_tit">';
                                        //    }
                                        //    if ($li == $info + 1) {
                                        //        $content .= '<p>' . $ui_li[$li] . '</p>';                      //标题下文字说明
                                        //    } else {
                                        //        $content .= '<b>' . $ui_li[$li] . '</b>';             //标题
                                        //    }
                                        //    if (($li == $info + 1) || ($li_num == 2 && $li == $info)) {
                                        //        $content .= '</div>';
                                        //    }
                                        //}


                                        if (strpos($ui_li[$li], ".jpeg") || strpos($ui_li[$li], ".jpg") || strpos($ui_li[$li], ".png") || strpos($ui_li[$li], ".gif")) {
                                            $alt = ($li == 0) ? $ui_li[1] : $ui_li[0];
                                            /* alt标签 -> 引用标题 */
                                            $content .= '<div class="adapter_highlights_pic ">';

                                            if ((strpos($ui_li[$li], '.webp') !== false) && (!is_support_webp())) {
                                                $ui_li[$li] = substr($ui_li[$li], 0, strrpos($ui_li[$li], '.webp'));
                                            }

                                            $content .= '<img src="' . HTTPS_IMAGE_SERVER . trim($ui_li[$li]) . '" alt="' . $categories_name . ' ' . $alt . '">';
                                            $content .= '</div>';   //最终图片
                                        } else {
                                            if ($li == $info) {
                                                $content .= '<div class="adapter_highlights_tit">';
                                            }
                                            if ($li == $info + 1) {
                                                $content .= '<p>' . $ui_li[$li] . '</p>';                      //标题下文字说明
                                            } else {
                                                $content .= '<b>' . $ui_li[$li] . '</b>';             //标题
                                            }
                                            if (($li == $info + 1) || ($li_num == 2 && $li == $info)) {
                                                $content .= '</div>';
                                            }
                                        }


                                    }
                                    $content .= '</div>';
                                }

                                if ($href) {
                                    //是否链接
                                    $content .= '</a>';
                                }
                            }
                        }
                        break;
                    case 'SPECIAL':
                        $content .= '<hr>';
                        $content .= '<div class="mux_demux_craftsmanship">';
                        $description = explode(';', $tag[1]);
                        for ($fs = 0; $fs < count($description); $fs++) {
                            if ($fs == 0) {
                                $content .= '<div class="mux_demux_craftsmanship_tit">' . $description[$fs] . '</div>';
                            } elseif ($fs == 1) {
                                $content .= '<div class="mux_demux_craftsmanship_text">';
                                $content .= '<p>' . $description[$fs] . '</p></div>';
                            } elseif ($fs == 2) {
                                $des = explode('@@', $description[$fs]);
                                $content .= '<div class="mux_demux_wrap">';
                                foreach ($des as $key => $value) {
                                    $v = explode('**', $value);
                                    $content .= '<div class="mux_demux_wrap_item">';
                                    if ($key != 3) {
                                        $content .= '<a class="mux_demux_wrap_item_0' . ($key + 1) . '" href="' . HTTPS_SERVER . DIR_WS_CATALOG . trim($v[3]) . '">';
                                    } else {
                                        $content .= '<a href="javascript:;" class="mux_demux_wrap_item_0' . ($key + 1) . '" onclick="javascript:window.open(\'' . reset_url(trim($v[3])) . '\', \'c_TW\', \'location=no, toolbar=no, resizable=yes, scrollbars=yes, directories=no, status=no, width=803, height=715, left=500, top=100\'); return false;">';
                                    }
                                    $content .= '<div class="mux_demux_wrap_icon">
                                            <img src="' . 'https://www.fs.com/' . trim($v[2]) . '"/>
                                        </div>
                                        <h3>' . $v[0] . '</h3>
                                        <p>' . $v[1] . '</p>
                                    </a>
                                </div>';

                                }
                                $content .= '</div>';
                            }
                        }
                        $content .= '</div>';
                        break;
                    case 'NEWSPECIAL':
                        $description = explode(';', $tag[1]);
                        $content .= "<hr><div class=\"mux_demux_craftsmanship\"><style type=\"text/css\">
                                    .mux_left01,.mux_right01{width: 650px;border: 1px solid #e5e5e5;height: 168px;box-sizing: border-box;padding-top: 50px;box-sizing: border-box;}
                                    .mux_left01{float: left;}
                                    .mux_right01{float: right;}
                                    .mux_left_container{height: 100%;display: inline-block;text-align: left;padding-left: 22px;box-sizing: border-box;}
                                    .mux_alone_img{vertical-align: top;}
                                    .mux_left_container a{font-size: 18px;color: #0070BC;}
                                    .mux_left_container p{font-size: 14px;color: #999;padding-top: 6px;}
                                    .mux_demux_craftsmanship{padding-top: 22px;}
                                    .mux_demux_craftsmanship_tit{padding-bottom: 26px;font-weight:400;}
                                    .mux_demux_craftsmanship_text p{padding-bottom: 22px;font-weight:400;}
                                    .mux_demux_wrap{margin-left: 0px;margin-right: 0px;}
                                    @media (max-width: 1420px){
                                        .mux_left01,.mux_right01{width: 48%;}
                                    }
                                    @media (max-width: 960px){
                                        .mux_demux_wrap{padding-left:10px;padding-right:10px;box-sizing: border-box;}
                                        .mux_left01,.mux_right01{width: 49%;}
                                    }
                                    @media (max-width: 750px){
                                        .mux_left01,.mux_right01{width: 100%;text-align: left;}
                                        .mux_alone_img{padding-left: 60px;}
                                        .mux_left01{margin-bottom: 20px;}
                                    }
                                    @media (max-width: 750px){
                                        .mux_alone_img{padding-left: 30px;}
                                    }	
                                </style>";
                        for ($fs = 0; $fs < count($description); $fs++) {
                            if ($fs == 0) {
                                $content .= "<div class=\"mux_demux_craftsmanship_tit\">$description[$fs]</div>";
                            } elseif ($fs == 1) {
                                $content .= "<div class=\"mux_demux_craftsmanship_text\">
                                <p>
                                $description[$fs]</p>
                                </div>";
                            } elseif ($fs == 2) {
                                $des = explode('@@', $description[$fs]);
                                $val0 = explode('**', $des[0]);
                                $val1 = explode('**', $des[1]);
                                $content .= '<div class="mux_demux_wrap">
                            <div class="mux_left01">
                                <img class="mux_alone_img" src="' . $val0[2] . '" alt="' . $val0[2] . '">
                                <div class="mux_left_container">
                                    <a href="' . $val0[3] . '" target="_blank">' . $val0[0] . '</a>
                                    <p>' . $val0[1] . '</p>
                                </div>
                            </div>
                            <div class="mux_right01">
                                <img class="mux_alone_img" src="' . $val1[2] . '" alt="' . $val1[2] . '">
                                <div class="mux_left_container">
                                    <a href="javascript:;" onclick="javascript:window.open(\'https://www.fs.com/solution_support.html?type=1&&entrance=1\', \'c_TW\', \'location=no, toolbar=no, resizable=yes, scrollbars=yes, directories=no, status=no, width=803, height=715, left=500, top=100\'); return false;" target="_blank">' . $val1[0] . '</a>
                                    <p>' . $val1[1] . '</p>
                                </div>
                            </div>
                        </div>';
                            }
                        }
                        $content .= '</div>';
                        break;
                    case  'FS12_01':
                        //if($i != 0){
                            $content .= '<hr>';
                        //}
                        $description = explode(';', $tag[1]);
                        $content .= '<div class="new-mtp-img-con2">';
                        $content .= '<h2 class="new-mtp-h2">'.$description[0].'</h2>';
                        $content .= '<ul class="new-mtp-ul">';

                        $scene_ids = [0];
                        for($fs = 1; $fs < sizeof($description); $fs++) {
                            $scene_ids[] = intval($description[$fs]);
                        }

                       $data = get_products_tag_by_ids($scene_ids);
                       $data_keys = array_keys($data);
                       for ($fs = 1; $fs < sizeof($description); $fs++) {
                           if (!in_array(intval($description[$fs]), $data_keys)) {
                               continue;
                           }
                           $value = $data[intval($description[$fs])];
                            $content .= '<li class="new-mtp-img-container">';

                           if ((strpos($value['thumb_two_url'], '.webp') !== false) && (!is_support_webp())) {
                               $value['thumb_two_url'] = substr($value['thumb_two_url'], 0, strrpos($value['thumb_two_url'], '.webp'));
                           }

                            $content .= '<img src="'.HTTPS_IMAGE_SERVER.$value['thumb_two_url'].'" alt="'.HTTPS_IMAGE_SERVER.$value['thumb_two_url'].'" />';
                            $content .= get_all_points_html($value['points_data'], $id);
                            $content .= '</li>';
                        }
                        $content .= '</ul>';
                        $content .= '</div>';
                        //$content .= '<hr>';
                        break;
                    case 'FS12_02':
                        //if($i != 0){
                            $content .= '<hr>';
                        //}

                        //标题#描述文字1;带有tag标签的大图1;描述文字2;常规图片（或tag标签的大图2）
                        $description = explode(';', $tag[1]);
                        $content .= '<div class="mux_demux_craftsmanship">';
                        $first_title = explode('#', $description[0]);
                        $first_title = $first_title[0];
                        $content .= '<div class="mux_demux_craftsmanship_tit">'.$first_title.'</div>';

                        //每两组为一个循环
                        $description = array_filter($description);
                        $description_chunks = array_chunk($description, 2);

                        $FS_12_02_items = array();
                        foreach ($description_chunks  as $description_key => $description_value) {
                            if (empty($description_value)) {
                                continue;
                            }
                            if ($description_key == 0) {
                                $description_value[0] = explode('#', $description_value[0]);
                                $description_value[0] = end($description_value[0]);
                            }
                            $temp['title'] = $description_value[0];
                            if (is_numeric($description_value[1])){
                                //说明是tag图
                                $temp['scene_id'] = intval($description_value[1]);
                                $temp['content'] = '';
                            } else {
                                //说明是普通的大图，
                                $temp['scene_id'] = 0;
                                $temp['content'] = $description_value[1];
                            }

                            $FS_12_02_items[] = $temp;
                        }
                        $scene_ids = i_array_column($FS_12_02_items, 'scene_id');
                        //最后塞一个0进入，避免没有scene_id报错,不从前面插入，避免内容顺序错乱
                        $scene_ids[] = 0;
                        $data = get_products_tag_by_ids($scene_ids);

                        foreach ($FS_12_02_items as $FS_12_02_items_key => $FS_12_02_items_value) {
                            if (empty($FS_12_02_items_value)) {
                                continue;
                            }
                            $content .= '<div class="mux_demux_craftsmanship_text">';
                            $content .= '<p>'.$FS_12_02_items_value['title'].'</p>';
                            $content .= '</div>';
                            if ($FS_12_02_items_value['scene_id'] > 0) {
                                //拼接上tag图的数据
                                $content .= '<div class="new-mtp-img-container">';

                                $fs_12_02_items_value_img = $data[$FS_12_02_items_value['scene_id']]['images_url'];
                                if ((strpos($fs_12_02_items_value_img, '.webp') !== false) && (!is_support_webp())) {
                                    $fs_12_02_items_value_img = substr($fs_12_02_items_value_img, 0, strrpos($fs_12_02_items_value_img, '.webp'));
                                }

                                $content .= '<img src="'.HTTPS_IMAGE_SERVER.$fs_12_02_items_value_img.'" alt="'.HTTPS_IMAGE_SERVER.$fs_12_02_items_value_img.'" />';
                                $content .= get_all_points_html($data[$FS_12_02_items_value['scene_id']]['points_data'], $id);
                                $content .= '</div>';
                            } else {
                                //说明是普通的图
                                $content .= '<div class="mux_demux_p_pic">';

                                if ((strpos($FS_12_02_items_value['content'], '.webp') !== false) && (!is_support_webp())) {
                                    $FS_12_02_items_value['content'] = substr($FS_12_02_items_value['content'], 0, strrpos($FS_12_02_items_value['content'], '.webp'));
                                }

                                $content .= '<img src="'.HTTPS_IMAGE_SERVER.trim($FS_12_02_items_value['content']).'" alt="" />';
                                $content .= '</div>';
                            }
                        }

                        $content .= '</div>';

                        break;

                    case 'FS13':
                        //FS13能兼容有标题和没有标题的。
                        $content .= '<hr>';
                        if (isMobile()) {
                            $content .= '<div class="custom-box-m">';
                        } else {
                            $content .= '<div class="custom-box">';
                        }
                        //代表每一行
                        $module_values = explode(';', $tag[1]);
                        if (isset($module_values[0]) && (!empty($module_values[0]))) {
                            $content .= '<h3>' . $module_values[0] . '</h3>';
                        }
                        //去除第一行的
                        $module_values = array_slice($module_values, 1);

                        $template_value = array(
                            'SORT_NUMBER' => '',
                            'NUMBER_DESCRIPTION' => '',
                            'TITLE_01' => '',
                            'DESCRIPTION_01' => '',
                            'TITLE_02' => '',
                            'DESCRIPTION_02' => '',
                            'IMG_01' => '',
                            'IMG_02' => '',
                            'IMG_03' => '',
                        );

                        foreach ($module_values as $module_key => $module_value) {
                            $module_value = explode(':', $module_value);
                            if ($module_key == 0) {
                                $template_value['SORT_NUMBER'] = $module_value[0];
                                $template_value['NUMBER_DESCRIPTION'] = $module_value[1];
                            } elseif ($module_key == 1) {
                                $template_value['TITLE_01'] = $module_value[0];
                                $template_value['DESCRIPTION_01'] = $module_value[1];
                            } elseif ($module_key == 2) {
                                $template_value['TITLE_02'] = $module_value[0];
                                $template_value['DESCRIPTION_02'] = $module_value[1];
                            } else {
                                foreach ($module_value as $module_k => $module_v) {

                                    $module_v = trim($module_v);
                                    if ((strpos($module_v, '.webp') !== false) && (!is_support_webp())) {
                                        $module_v = substr($module_v, 0, strrpos($module_v, '.webp'));
                                    }

                                    $template_value['IMG_0' . ($module_k + 1)] = HTTPS_IMAGE_SERVER . $module_v;
                                }
                            }
                        }

                        if (isMobile()) {
                            $FS13_template = '<div class="custom-box-info-m">
                                                <div class="custom-box-title-m">
                                                    <span class="custom-title-span1">SORT_NUMBER</span>
                                                    <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                                </div>
                                                <div class="custom-box-text-m">
                                                    <div class="table-m">
                                                        <div class="table-tr-m">
                                                            <div class="table-td-m">
                                                                <p class="custom-box-li-title">TITLE_01</p>
                                                                <p class="custom-box-li-text" style="padding: 0 15px;">
                                                                   DESCRIPTION_01
                                                                </p>
                                                                <div class="m-shop-imgs">
                                                                    <img src="IMG_01" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="table-td-m">
                                                                <p class="custom-box-li-title">TITLE_02</p>
                                                                <p class="custom-box-li-text" style="padding: 0 15px;">
                                                                   DESCRIPTION_02
                                                                </p>
                                                                <div class="m-shop-imgs m-bottom-30">
                                                                    <img src="IMG_03" alt="">
                                                                </div>
                                                            </div>
                        
                                                        </div>
                        
                        
                                                    </div>
                                                </div>
                                              </div>';
                        } else {
                            $FS13_template = '<div class="custom-box-info">
                                                <div class="custom-box-title">
                                                    <span class="custom-title-span1">SORT_NUMBER</span>
                                                    <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                                </div>
                                                <div class="custom-box-text">
                                                    <div class="table">
                                                        <div class="table-tr">
                                                            <div class="table-td">
                                                                <p class="custom-box-li-title">TITLE_01</p>
                                                                <p class="custom-box-li-text">
                                                                   DESCRIPTION_01
                                                                </p>
                                                            </div>
                                                            <div class="table-td"></div>
                                                            <div class="table-td">
                                                                 <p class="custom-box-li-title">TITLE_02</p>
                                                                 <p class="custom-box-li-text">
                                                                     DESCRIPTION_02
                                                                 </p>
                                                            </div>
                        
                                                        </div>
                                                        <div class="table-tr custom-box-img-01">
                                                            <div class="table-td" align="center">
                                                                <img src="IMG_01" alt="">
                                                            </div>
                                                            <div class="table-td custom-box-img-ico" align="center">
                                                                <!--<span class="iconfont icon"></span>-->
                                                                 <img src="IMG_02" alt="">
                                                            </div>
                                                            <div class="table-td" align="center">
                                                                <img src="IMG_03" alt="">
                                                            </div>
                                                        </div>
                        
                                                    </div>
                                                </div>
                                              </div>';
                        }

                        $content .= str_replace(array_keys($template_value), array_values($template_value), $FS13_template);
                        $content .= '</div>';

                        break;

                    case 'FS14':
                        $content .= '<hr>';
                        if (isMobile()) {
                            $content .= '<div class="custom-box-m">';
                        } else {
                            $content .= '<div class="custom-box">';
                        }
                        //代表每一行
                        $module_values = explode(';', $tag[1]);

                        $template_value = array(
                            'SORT_NUMBER' => '',
                            'NUMBER_DESCRIPTION' => '',
                            'TITLE_01' => '',
                            'DESCRIPTION_01' => '',
                            'TITLE_02' => '',
                            'DESCRIPTION_02' => '',
                            'IMG' => '',

                            'M_01' => '',
                            'M_02' => ''
                        );
                        if (isset($module_values[0]) && (!empty($module_values[0]))) {
                            $content .= '<h3>' . $module_values[0] . '</h3>';
                        }
                        //去除第一行的
                        $module_values = array_slice($module_values, 1);

                        foreach ($module_values as $module_key => $module_value) {
                            $module_value = explode(':', $module_value);
                            if ($module_key == 0) {
                                $template_value['SORT_NUMBER'] = $module_value[0];
                                $template_value['NUMBER_DESCRIPTION'] = $module_value[1];
                            } elseif ($module_key == 1) {
                                $template_value['TITLE_01'] = $module_value[0];
                                $template_value['DESCRIPTION_01'] = $module_value[1];
                            } elseif ($module_key == 2) {
                                $template_value['TITLE_02'] = $module_value[0];
                                $template_value['DESCRIPTION_02'] = $module_value[1];
                            } else {
                                if ((strpos($module_value[0], '.webp') !== false) && (!is_support_webp())) {
                                    $module_value[0] = substr($module_value[0], 0, strrpos($module_value[0], '.webp'));
                                }

                                $template_value['IMG'] = HTTPS_IMAGE_SERVER . trim($module_value[0]);
                                if (trim($module_value[1]) && trim($module_value[2])) {

                                    if ((strpos($module_value[1], '.webp') !== false) && (!is_support_webp())) {
                                        $module_value[1] = substr($module_value[1], 0, strrpos($module_value[1], '.webp'));
                                    }
                                    if ((strpos($module_value[2], '.webp') !== false) && (!is_support_webp())) {
                                        $module_value[2] = substr($module_value[2], 0, strrpos($module_value[2], '.webp'));
                                    }

                                    $template_value['M_01'] = HTTPS_IMAGE_SERVER . trim($module_value[1]);
                                    $template_value['M_02'] = HTTPS_IMAGE_SERVER . trim($module_value[2]);
                                }

                            }
                        }

                        if (isMobile()) {
                            if ($template_value['M_01'] && $template_value['M_02']) {
                                $FS14_template = '<div class="custom-box-info-m">
                                                <div class="custom-box-title-m">
                                                    <span class="custom-title-span1">SORT_NUMBER</span>
                                                    <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                                </div>
                                                <div class="custom-box-text-m">
                                                    <div class="table-m">
                                                        <div class="table-tr-m">
                                                            <div class="table-td-m table-td-m-eidt">
                                                                <p class="custom-box-li-title custom-box-li-title-eidt">TITLE_01</p>
                                                                <p class="custom-box-li-text" style="padding: 0 15px;">
                                                                   DESCRIPTION_01
                                                                </p>
                                                                <div class="m-shop-imgs m-shop-imgs-eidt m-bottom-30">
                                                                    <img src="M_01" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="table-td-m">
                                                                <p class="custom-box-li-title custom-box-li-title-eidt">TITLE_02</p>
                                                                <p class="custom-box-li-text" style="padding: 0 15px;">
                                                                    DESCRIPTION_02
                                                                </p>
                                                                <div class="m-shop-imgs m-shop-imgs-eidt m-bottom-30">
                                                                    <img src="M_02" alt="">
                                                                </div>
                                                            </div>
                        
                                                        </div>
                        
                        
                                                    </div>
                                                </div>
                                            </div>';
                            } else {
                                $FS14_template = '<div class="custom-box-info-m">
                                                <div class="custom-box-title-m">
                                                    <span class="custom-title-span1">SORT_NUMBER</span>
                                                    <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                                </div>
                                                <div class="custom-box-text-m">
                                                    <div class="table-m">
                                                        <div class="table-tr-m">
                                                            <div class="table-td-m table-td-m-eidt">
                                                                <p class="custom-box-li-title custom-box-li-title-eidt">TITLE_01</p>
                                                                <p class="custom-box-li-text" style="padding: 0 15px;">
                                                                   DESCRIPTION_01
                                                                </p>
                                                             
                                                            </div>
                                                            <div class="table-td-m">
                                                                <p class="custom-box-li-title custom-box-li-title-eidt">TITLE_02</p>
                                                                <p class="custom-box-li-text" style="padding: 0 15px;">
                                                                    DESCRIPTION_02
                                                                </p>
                                                                <div class="m-shop-imgs m-shop-imgs-eidt m-bottom-30">
                                                                    <img src="IMG" alt="">
                                                                </div>
                                                            </div>
                        
                                                        </div>
                        
                        
                                                    </div>
                                                </div>
                                            </div>';
                            }

                        }else{
                            $FS14_template = '<div class="custom-box-info">
                                                <div class="custom-box-title">
                                                    <span class="custom-title-span1">SORT_NUMBER</span>
                                                    <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                                </div>
                                                <div class="custom-box-text">
                                                    <div>
                                                        <div class="table-tr">
                                                            <div class="table-td">
                                                                <p class="custom-box-li-title">TITLE_01</p>
                                                                <p class="custom-box-li-text">
                                                                   DESCRIPTION_01
                                                                </p>
                                                            </div>
                                                            <div class="table-td custom-box-img-ico-eidt"></div>
                                                            <div class="table-td">
                                                                <p class="custom-box-li-title">TITLE_02</p>
                                                                <p class="custom-box-li-text">
                                                                    DESCRIPTION_02
                                                                </p>
                                                            </div>
                        
                                                        </div>
                                                      
                                                        <div class="custom-box-img-01">
                                                            <div class="custom-box-img-eidt"  align="center">
                                                                <img src="IMG" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>';
                        }

                        $content .= str_replace(array_keys($template_value), array_values($template_value), $FS14_template);
                        $content .= '</div>';

                        break;

                    case 'FS15':
                        $content .= '<hr>';
                        if (isMobile()) {
                            $content .= '<div class="custom-box-m">';
                        } else {
                            $content .= '<div class="custom-box">';
                        }
                        //代表每一行
                        $module_values = explode(';', $tag[1]);

                        $template_value = array(
                            'SORT_NUMBER'        => '',
                            'NUMBER_DESCRIPTION' => '',
                            'DESCRIPTION_01'     => '',
                            'IMG'                => ''
                        );

                        if (isset($module_values[0]) && (!empty($module_values[0]))) {
                            $content .= '<h3>' . $module_values[0] . '</h3>';
                        }
                        //去除第一行的
                        $module_values = array_slice($module_values, 1);

                        foreach ($module_values as $module_key => $module_value) {
                            $module_value = explode(':', $module_value);
                            if ($module_key == 0) {
                                $template_value['SORT_NUMBER'] = $module_value[0];
                                $template_value['NUMBER_DESCRIPTION'] = $module_value[1];
                            } else {
                                if (stripos($module_value[0], '.png') !== false || stripos($module_value[0], '.jpg') !== false || stripos($module_value[0], '.jpeg')) {

                                    if ((strpos($module_value[0], '.webp') !== false) && (!is_support_webp())) {
                                        $module_value[0] = substr($module_value[0], 0, strrpos($module_value[0], '.webp'));
                                    }

                                    if (isMobile()) {
                                        $template_value['IMG'] = '<div class="m-shop-imgs m-shop-imgs-eidt">
                                                                    <img src="' . HTTPS_IMAGE_SERVER . trim($module_value[0]) . '" alt="">
                                                                </div>';
                                    }
                                    $template_value['IMG'] = '<div class="custom-imgs">
                                                                    <img src="' . HTTPS_IMAGE_SERVER . trim($module_value[0]) . '">
                                                              </div>';
                                } else {
                                    if (isMobile()) {
                                        $template_value['DESCRIPTION_01'] = '<p class="custom-box-li-text">' . $module_value[0] . '</p>';
                                    } else {
                                        $template_value['DESCRIPTION_01'] = '<p class="custom-box-text-five">' . $module_value[0] . '</p>';
                                    }
                                }

                            }
                        }

                        if (isMobile()) {
                            $FS15_template = '<div class="custom-box-info-m custom-box-text-m-bg">
                                                <div class="custom-box-title-m">
                                                    <span class="custom-title-span1">SORT_NUMBER</span>
                                                    <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                                </div>
                                                <div class="custom-box-text-m">
                                                    <div class="table-m">
                                                        <div class="table-tr-m">
                                                            <div class="table-td-m">
                                                            DESCRIPTION_01
                                                            IMG
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>';
                        } else {
                            $FS15_template = '<div class="custom-box-info">
                                            <div class="custom-box-title">
                                                <span class="custom-title-span1">SORT_NUMBER</span>
                                                <span class="custom-title-span2">NUMBER_DESCRIPTION</span>
                                            </div>
                                            DESCRIPTION_01
                                            IMG
                                          </div>';
                        }
                        $content .= str_replace(array_keys($template_value), array_values($template_value), $FS15_template);
                        $content .= '</div>';
                        break;
                    case 'FS16':
                        $content .= '<hr>';
                        //代表每一行
                        $module_values = explode(';', $tag[1]);

                        $template_value = array(
                            'TITLE' => '',
                            'LI_CONTENT' => '',
                        );

                        foreach ($module_values as $module_key => $module_value) {
                            $module_value = explode(':', $module_value);
                            if ($module_key == 0) {
                                $template_value['TITLE'] = $module_value[0];
                            } else {

                                if ((strpos($module_value[0], '.webp') !== false) && (!is_support_webp())) {
                                    $module_value[0] = substr($module_value[0], 0, strrpos($module_value[0], '.webp'));
                                }

                                $template_value['LI_CONTENT'] .= '<li class="new_help_list">
                                                                   <span class="new_help_list_icon" style="background-image:url(' . HTTPS_IMAGE_SERVER . trim($module_value[0]) . ')"></span>
                                                                   <h2 class="new_help_list_tit">' . $module_value[1] . '</h2>
                                                                   <p class="new_help_list_txt">' . $module_value[2] . '</p>
                                                               </li>';
                            }
                        }

                        $FS16_template = '<div class="alone_wap alone_padding" style="border-top:none;">
                                               <div class="alone_div_wap">
                                                   <h2 class="alone_tit">TITLE</h2>
                                                   <ul class="after alone-proCustom-list">LI_CONTENT</ul>
                                               </div>
                                           </div>';

                        $content .= str_replace(array_keys($template_value), array_values($template_value), $FS16_template);
                        break;

                    case 'FS17':
                        $module_values = explode(';', $tag[1]);
                        $content .= '<hr>';
                        $content .= '<p class="switch_details_tit">'.FS_DOWNLOAD.'</p>';
                        $content .= '<div class="switch_container">';
                        $content .= '<ul class="switch_details_ul after">';

                        foreach ($module_values as $module_key => $module_value) {
                            $module_value = explode('[[[', $module_value);
                            if ($module_value[0] && $module_value[1] && $module_value[2]) {

                                if ((strpos($module_value[0], '.webp') !== false) && (!is_support_webp())) {
                                    $module_value[0] = substr($module_value[0], 0, strrpos($module_value[0], '.webp'));
                                }

                                $content .= '<li>
                                            <span>
                                                <img src="'.HTTPS_IMAGE_SERVER.trim($module_value[0]).'" alt="Fs '.basename(HTTPS_IMAGE_SERVER.trim($module_value[0])).'">
                                                <a href="'.trim($module_value[2]).'">'.trim($module_value[1]).'</a>
                                            </span>
									     </li>';
                            }
                        }

						$content .= '</ul>';
                        $content .= '</div>';
                        break;
                    case 'FS18':
                        $content .= '<hr>';
                        $platform_support = '';
                        $support = str_replace('；', ';', $tag[1]);
                        $wordurl = explode(";", $support);

                        $content .= '<div class="p_con_new_tit03">' . $wordurl[0] . '</div>';

                        $wordurl = array_slice($wordurl, 1);//第一个是标题

                        $support_title = '<div class="p_con_02">' . $wordurl[0] . '</div>';
                        //获取的页面内容也要做成表格
                        $support_table  = '';
                        $support_table .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                        $support_table .= '<tbody>';
                        $support_table .= '<tr>';
                        //移除空格
                        $wordurl[1] = trim($wordurl[1]);

                        //如果是手动填写的内容
                        $show_hide = false;
                        if (sizeof($wordurl) > 20) {
                            //是否超过20行，超过20行就需要隐藏，并展示more和less了。
                            $show_hide = true;
                        }
                        $tdnum = 2;
                        $td_arr = explode(':', $wordurl[1]);
                        if (sizeof($td_arr) > 2) {
                            $tdnum = sizeof($td_arr);
                        }
                        //可以是多列的表格，平分100
                        $width = round(100 / $tdnum, 2) . "%";
                        $td_width = 'width="' . $width . '"';
                        $idnum = 0;
                        for ($tdline = 0; $tdline < $tdnum; $tdline++) {
                            $idnum++;
                            $support_table .= '<td valign="top" ' . $td_width . '>';
                            $support_table .= '<div class="p_con_02">';
                            for ($st = 1; $st < sizeof($wordurl); $st++) {
                                $Gspan = explode(":", $wordurl[$st]);
                                if ($st == 21) {
                                   $support_table .= '<div id="platform_support' . $idnum . '_' . $id . '" style="display:none;">';
                                }
                                if($Gspan[$tdline]){
                                   $support_table .= '<span>' . $Gspan[$tdline] . '</span>';
                                }
                            }
                            if ($show_hide) {
                                 $support_table .= '</div>';
                            }
                            $support_table .= '</div>';
                            $support_table .= '</td>';
                        }
                        $support_table .= '</tr>';


                        if ($show_hide) {
                            $support_table .= '<tr>';
                            $support_table .= '<td colspan="2">';
                            $support_table .= '<div class="sidebar_more p_con_platform_more">';
                            $support_table .= '<a onClick="show_hide_compatible(' . $id . ')" id="platform_support_sh_' . $id . '">'.FS_OURFACTORY_MORE.'</a>';
                            $support_table .= '</div>';
                            $support_table .= '</td>';
                            $support_table .= '</tr>';
                        }

                        $support_table .= '</tbody>';
                        $support_table .= '</table>';
                        $platform_support = $support_title . '<br/>' . $support_table;
                        $is_show_more = '<script type="text/javascript">
                                 var pid = "'.$_GET['products_id'].'";
                                   $(function(){
                                        if($("#platform_support1_"+pid).length>0 || $("#platform_support2_"+pid).length>0){
                                            $("#platform_support_sh_"+pid).show();
                                        }else{
                                            $("#platform_support_sh_"+pid).hide();
                                        }
                                    });
                                </script>';
                        $content .= $platform_support.$is_show_more;

                        break;

                    case 'FS19':
                        $content .= '<hr>';
                        $temp_module_value = str_replace(['；', '：'], [';',':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        $content .= '<div class="mtp_module_container">';

                        //处理说明
                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);
                        $content .= '<p class="mtp_module_tit">'.(isset($first_line_value[1]) ? $first_line_value[1] : '') .'</p>';

                        $temp_tag_id = intval($first_line_value[0]);

                        $temp_scene_ids = [];
                        $temp_scene_ids[] = $temp_tag_id;

                        $scene_arr = get_products_tag_by_ids($temp_scene_ids);

                        //第一个元素
                        $scene_arr = current($scene_arr);


                        $points_data = get_all_points_html($scene_arr['points_data']);


                        $content .= '<div class="mtp_module_imgage">';

                        if ((strpos($scene_arr['images_url'], '.webp') !== false) && (!is_support_webp())) {
                            $scene_arr['images_url'] = substr($scene_arr['images_url'], 0, strrpos($scene_arr['images_url'], '.webp'));
                        }

						$content .= '<div class="new-mtp-center">
                                        <div class="new-mtp-img-container">
                                            <img src="'.HTTPS_IMAGE_SERVER.trim($scene_arr['images_url']).'">
                                            '.$points_data.'
                                        </div>
						             </div>';

                        $temp_module_values = array_slice($temp_module_values, 1);
                        if (count($temp_module_values) > 0) {
                            $content .= '<div class="mtp_left_position">';
                            $content .= '<ul class="mtp_left_position_ul">';
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (empty($temp_module_value_v)) {
                                    continue;
                                }
                                $temp_module_value_v = str_replace(['：'], [':'], $temp_module_value_v);
                                $temp_module_value_v = explode(':', $temp_module_value_v);

                                $temp_module_value_v[0] = trim($temp_module_value_v[0]);
                                if ((strpos($temp_module_value_v[0], '.webp') !== false) && (!is_support_webp())) {
                                    $temp_module_value_v[0] = substr($temp_module_value_v[0], 0, strrpos($temp_module_value_v[0], '.webp'));
                                }

                                $content .= '<li>
									<div class="mtp_left_position_bg01">
										<i><img src="'.HTTPS_IMAGE_SERVER.trim($temp_module_value_v[0]).'"></i>
										'.$temp_module_value_v[1].'
									</div>
									<div class="mtp_left_position_bg02"></div>
								</li>';
                            }
                            $content .= '</ul>';
                            $content .= '</div>';
                        }
					    $content .= '</div>';
                        $content .= '</div>';
                        break;


                    case 'FS20':

                        $content .= '<hr>';

                        $temp_module_value = str_replace(['；', '：'], [';',':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);

                        $content .= '<div class="mtp_module_container">';
                        $content .= '<p class="mtp_module_tit">'.(isset($first_line_value[0]) ? $first_line_value[0]:'').'</p>';

                        if (isset($first_line_value[1]) && $first_line_value[1]) {
                            $content .= '<p class="mtp_module_txt">'.$first_line_value[1].'</p>';
                        }

                        $content .= '<div class="mtp_module_flex">';
                        $temp_module_values = array_slice($temp_module_values, 1);
                        if (count($temp_module_values) > 0) {
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (empty($temp_module_value_v)) {
                                    continue;
                                }
                                $temp_module_value_v = explode(':', $temp_module_value_v);


                                $temp_module_value_v[0] = trim($temp_module_value_v[0]);
                                if ((strpos($temp_module_value_v[0], '.webp') !== false) && (!is_support_webp())) {
                                    $temp_module_value_v[0] = substr($temp_module_value_v[0], 0, strrpos($temp_module_value_v[0], '.webp'));
                                }


                                $content .= '<dl class="mtp_module_flex_dl">
							                     <dt>
							                        <img src="'.HTTPS_IMAGE_SERVER.$temp_module_value_v[0].'">
							                     </dt>
							                     <dd>'.$temp_module_value_v[1].'</dd>
						                        </dl>';
                            }
                        }

					    $content .= '</div>';
                        $content .= '</div>';


                        break;

                    case 'FS21_01':
                        $content .= '<hr>';

                        $content .= '<div class="mtp_module_container">';

                        $temp_module_value = str_replace(['；', '：'], [';', ':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        $content .= '<p class="mtp_module_tit">'.$temp_module_values[0].'</p>';

                        $temp_module_values = array_slice($temp_module_values, 1);
                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);
                        if ((stripos($first_line_value[0], 'svg') !== false) || (stripos($first_line_value[0], 'png') !== false) || (stripos($first_line_value[0], 'jpg') !== false) || (stripos($first_line_value[0], 'jpeg') !== false) || (stripos($first_line_value[0], 'gif') !== false)) {
                            $class = ''; //说明图片在左边;
                            $FS21_img = $first_line_value[0];
                            $FS21_title = $first_line_value[1];
                        } else {
                            $class = 'mtp_module_right';//说明图片在右边
                            $FS21_img = $first_line_value[1];
                            $FS21_title = $first_line_value[0];
                        }

                        //$content .= '<p class="mtp_img_tit">'.$FS21_title.'</p>';

                        $temp_module_values = array_slice($temp_module_values, 1);

                        $content .= '<div class="mtp_img_container '.$class.'">';

                        $FS21_img = trim($FS21_img);
                        if ((strpos($FS21_img, '.webp') !== false) && (!is_support_webp())) {
                            $FS21_img = substr($FS21_img, 0, strrpos($FS21_img, '.webp'));
                        }

                        $content .= '<div class="mtp_img_alone">
                                        <img src="'.HTTPS_IMAGE_SERVER.$FS21_img.'">
                                     </div>';
                        $content .= '<div class="mtp_img_alone mtp_img_alone_txt">';
                        $content .= '<div>';
                        $content .= '<p class="mtp_img_tit">'.$FS21_title.'</p>';
						if ($temp_module_values) {
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (stripos($temp_module_value_v, '[TAGS]') !== false) {
                                    $temp_module_value_v =  str_replace('[TAGS]', '', $temp_module_value_v);
                                    //说明有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    $content .= '<ul class="mtp_module_img_ul">';
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        $content .= '<li>' . $temp_module_value_vv . '</li>';
                                    }
                                    $content .= '</ul>';
                                } else {
                                    //说明没有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        if (empty($temp_module_value_vv)) {
                                            continue;
                                        }
                                        $content .= '<p class="mtp_img_txt"><em class="mtp_module_point"></em>' . $temp_module_value_vv . '</p>';
                                    }

                                }
                            }
                        }

						$content .= '</div>';
						$content .= '</div>';
					    $content .= '</div>';
					    $content .= '</div>';
                        break;

                    case 'FS21_02':
                        //$content .= '<hr>';

                        $content .= '<div class="mtp_module_container">';

                        $temp_module_value = str_replace(['；', '：'], [';', ':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        //$content .= '<p class="mtp_module_tit">'.$temp_module_values[0].'</p>';

                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);
                        if ((stripos($first_line_value[0], 'svg') !== false) || (stripos($first_line_value[0], 'png') !== false) || (stripos($first_line_value[0], 'jpg') !== false) || (stripos($first_line_value[0], 'jpeg') !== false) || (stripos($first_line_value[0], 'gif') !== false)) {
                            $class = ''; //说明图片在左边;
                            $FS21_img = trim($first_line_value[0]);
                            $FS21_title = $first_line_value[1];
                        } else {
                            $class = 'mtp_module_right';//说明图片在右边
                            $FS21_img = trim($first_line_value[1]);
                            $FS21_title = $first_line_value[0];
                        }



                        $temp_module_values = array_slice($temp_module_values, 1);

                        $content .= '<div class="mtp_img_container '.$class.'">';


                        if ((strpos($FS21_img, '.webp') !== false) && (!is_support_webp())) {
                            $FS21_img = substr($FS21_img, 0, strrpos($FS21_img, '.webp'));
                        }

                        $content .= '<div class="mtp_img_alone">
                                        <img src="'.HTTPS_IMAGE_SERVER.$FS21_img.'">
                                     </div>';
                        $content .= '<div class="mtp_img_alone mtp_img_alone_txt">';
                        $content .= '<div>';
                        $content .= '<p class="mtp_img_tit">'.$FS21_title.'</p>';
                        if ($temp_module_values) {
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (stripos($temp_module_value_v, '[TAGS]') !== false) {
                                    $temp_module_value_v =  str_replace('[TAGS]', '', $temp_module_value_v);
                                    //说明有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    $content .= '<ul class="mtp_module_img_ul">';
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        $content .= '<li>' . $temp_module_value_vv . '</li>';
                                    }
                                    $content .= '</ul>';
                                } else {
                                    //说明没有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        if (empty($temp_module_value_vv)) {
                                            continue;
                                        }
                                        $content .= '<p class="mtp_img_txt"><em class="mtp_module_point"></em>' . $temp_module_value_vv . '</p>';
                                    }
                                }
                            }
                        }

                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        break;

                    case 'FS22':

                        $content .= '<hr>';

                        $temp_module_value = str_replace(['；', '：'], [';',':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);

                        $content .= '<div class="mtp_module_container">';
                        $content .= '<p class="mtp_module_tit">'.(isset($first_line_value[0]) ? $first_line_value[0]:'').'</p>';

                        if (isset($first_line_value[1]) && $first_line_value[1]) {
                            $content .= '<p class="mtp_module_txt">'.$first_line_value[1].'</p>';
                        }

                        $content .= '<div class="mtp_module_flex">';
                        $temp_module_values = array_slice($temp_module_values, 1);

                        $temp_scene_ids = [];
                        if (count($temp_module_values) > 0) {
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (empty($temp_module_value_v)) {
                                    continue;
                                }
                                $temp_module_value_v = explode(':', $temp_module_value_v);
                                $temp_scene_ids[intval($temp_module_value_v[0])] = trim($temp_module_value_v[1]);
                            }
                        }

                        $scene_arr = get_products_tag_by_ids(array_keys($temp_scene_ids));




                        foreach ($scene_arr as $scene_arr_k => $scene_arr_v) {
                            $points_data = get_all_points_html($scene_arr_v['points_data']);

                            $content .= '<dl class="mtp_module_flex_dl">';
                            $content .= '<dt>';

                            if ((strpos($scene_arr_v['images_url'], '.webp') !== false) && (!is_support_webp())) {
                                $scene_arr_v['images_url'] = substr($scene_arr_v['images_url'], 0, strrpos($scene_arr_v['images_url'], '.webp'));
                            }

                            $content .= '<div class="new-mtp-center">
                                        <div class="new-mtp-img-container" style="margin-bottom:0;">
                                            <img src="'.HTTPS_IMAGE_SERVER.trim($scene_arr_v['images_url']).'">
                                            '.$points_data.'
                                        </div>
						             </div>';

                            if (in_array($scene_arr_k, array_keys($temp_scene_ids))) {
                                $temp_fs22_html = $temp_scene_ids[$scene_arr_k];
                            } else {
                                $temp_fs22_html = '';
                            }

                            $content .= '</dt>';
                            $content .= '<dd>'.$temp_fs22_html.'</dd>';
                            $content .= '</dl>';
                        }




                        $content .= '</div>';
                        $content .= '</div>';


                        break;


                    case 'FS23_01':
                        $content .= '<hr>';

                        $content .= '<div class="mtp_module_container product_switch_module">';

                        $temp_module_value = str_replace(['；', '：'], [';', ':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        $content .= '<p class="mtp_module_tit">'.$temp_module_values[0].'</p>';

                        $temp_module_values = array_slice($temp_module_values, 1);
                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);
                        if ((stripos($first_line_value[0], 'svg') !== false) || (stripos($first_line_value[0], 'png') !== false) || (stripos($first_line_value[0], 'jpg') !== false) || (stripos($first_line_value[0], 'jpeg') !== false) || (stripos($first_line_value[0], 'gif') !== false)) {
                            $class = ''; //说明图片在左边;
                            $FS21_img = $first_line_value[0];
                            $FS21_title = $first_line_value[1];
                        } else {
                            $class = 'mtp_module_right';//说明图片在右边
                            $FS21_img = $first_line_value[1];
                            $FS21_title = $first_line_value[0];
                        }

                        //$content .= '<p class="mtp_img_tit">'.$FS21_title.'</p>';

                        $temp_module_values = array_slice($temp_module_values, 1);

                        $content .= '<div class="mtp_img_container '.$class.'">';

                        $FS21_img = trim($FS21_img);
                        if ((strpos($FS21_img, '.webp') !== false) && (!is_support_webp())) {
                            $FS21_img = substr($FS21_img, 0, strrpos($FS21_img, '.webp'));
                        }

                        $content .= '<div class="mtp_img_alone">
                                        <img src="'.HTTPS_IMAGE_SERVER. $FS21_img .'">
                                     </div>';
                        $content .= '<div class="mtp_img_alone mtp_img_alone_txt">';
                        $content .= '<div>';
                        $content .= '<p class="mtp_img_tit">'.$FS21_title.'</p>';
                        if ($temp_module_values) {
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (stripos($temp_module_value_v, '[TAGS]') !== false) {
                                    $temp_module_value_v =  str_replace('[TAGS]', '', $temp_module_value_v);
                                    //说明有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    $content .= '<ul class="mtp_module_img_ul">';
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        $content .= '<li>' . $temp_module_value_vv . '</li>';
                                    }
                                    $content .= '</ul>';
                                } else {
                                    //说明没有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        if (empty($temp_module_value_vv)) {
                                            continue;
                                        }
                                        $content .= '<p class="mtp_img_txt"><em class="mtp_module_point"></em>' . $temp_module_value_vv . '</p>';
                                    }

                                }
                            }
                        }

                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        break;

                    case 'FS23_02':
                        $content .= '<hr>';

                        $content .= '<div class="mtp_module_container product_switch_module">';

                        $temp_module_value = str_replace(['；', '：'], [';', ':'], $tag[1]);
                        $temp_module_values = explode(';', $temp_module_value);

                        //$content .= '<p class="mtp_module_tit">'.$temp_module_values[0].'</p>';

                        $first_line_value = current($temp_module_values);
                        $first_line_value = explode(':', $first_line_value);
                        if ((stripos($first_line_value[0], 'svg') !== false) || (stripos($first_line_value[0], 'png') !== false) || (stripos($first_line_value[0], 'jpg') !== false) || (stripos($first_line_value[0], 'jpeg') !== false) || (stripos($first_line_value[0], 'gif') !== false)) {
                            $class = ''; //说明图片在左边;
                            $FS21_img = trim($first_line_value[0]);
                            $FS21_title = $first_line_value[1];
                        } else {
                            $class = 'mtp_module_right';//说明图片在右边
                            $FS21_img = trim($first_line_value[1]);
                            $FS21_title = $first_line_value[0];
                        }



                        $temp_module_values = array_slice($temp_module_values, 1);

                        $content .= '<div class="mtp_img_container '.$class.'">';

                        if ((strpos($FS21_img, '.webp') !== false) && (!is_support_webp())) {
                            $FS21_img = substr($FS21_img, 0, strrpos($FS21_img, '.webp'));
                        }

                        $content .= '<div class="mtp_img_alone">
                                        <img src="'.HTTPS_IMAGE_SERVER.$FS21_img.'">
                                     </div>';
                        $content .= '<div class="mtp_img_alone mtp_img_alone_txt">';
                        $content .= '<div>';
                        $content .= '<p class="mtp_img_tit">'.$FS21_title.'</p>';
                        if ($temp_module_values) {
                            foreach ($temp_module_values as $temp_module_value_k => $temp_module_value_v) {
                                if (stripos($temp_module_value_v, '[TAGS]') !== false) {
                                    $temp_module_value_v =  str_replace('[TAGS]', '', $temp_module_value_v);
                                    //说明有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    $content .= '<ul class="mtp_module_img_ul">';
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        $content .= '<li>' . $temp_module_value_vv . '</li>';
                                    }
                                    $content .= '</ul>';
                                } else {
                                    //说明没有tag标签说明
                                    $temp_module_value_v = explode(':', $temp_module_value_v);
                                    foreach ($temp_module_value_v as $temp_module_value_vv) {
                                        if (empty($temp_module_value_vv)) {
                                            continue;
                                        }
                                        $content .= '<p class="mtp_img_txt"><em class="mtp_module_point"></em>' . $temp_module_value_vv . '</p>';
                                    }
                                }
                            }
                        }

                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        break;

                    case 'FS24':
                        $content .= '<hr>';
                        $fs_24_data = explode(';', $tag[1]);
                        $fs_24_data = array_filter($fs_24_data);

                        $width = 48;
                        if (isMobile()) {
                            //$width = 27;
                        }

                        $content .= '<div class="mux_demux_craftsmanship">';

                        $title = current($fs_24_data);
                        $content .= '<div class="mux_demux_craftsmanship_tit">'.$title.'</div>';
                        $end_img = end($fs_24_data);
                        $fs_24_data = array_slice($fs_24_data, 1, -1);

                        $content .= '<div class="mux_lights_describe_catList">';
						$content .= '<div class="mux_lights_describe_catListMian">';
                        foreach ($fs_24_data as $key => $value) {
                            $value = explode(':', $value);

                            $value[0] = trim($value[0]);
                            if ((strpos($value[0], '.webp') !== false) && (!is_support_webp())) {
                                $value[0] = substr($value[0], 0, strrpos($value[0], '.webp'));
                            }

                            $content .= '<div class="mux_lights_describe_catLi">
                                               <div class="mux_lights_describe_catLi_imgbox">
                                                   <img src="'.HTTPS_IMAGE_SERVER.$value[0].'" width="'.$width.'">
                                               </div>
                                               <div class="mux_lights_describe_catLi_txt">'.trim($value[1]).'</div>
                                         </div>';
                        }

                        $content .= '</div>';
                        $content .= '</div>';

                        if ((strpos($end_img, '.webp') !== false) && (!is_support_webp())) {
                            $end_img = substr($end_img, 0, strrpos($end_img, '.webp'));
                        }

                        $content .= '<div class="mux_demux_p_pic">
						                <img src="'.HTTPS_IMAGE_SERVER.$end_img.'" alt="">
					                 </div>';
                        $content .= '</div>';

                        break;

                    case 'FS24_01':
                        $content .= '<hr>';
                        $fs_24_data = explode(';', $tag[1]);
                        $fs_24_data = array_filter($fs_24_data);

                        $width = 48;
                        if (isMobile()) {
                            //$width = 27;
                        }

                        $content .= '<div class="mux_demux_craftsmanship">';

                        $title = current($fs_24_data);
                        $content .= '<div class="mux_demux_craftsmanship_tit">'.$title.'</div>';
                        $end_img = end($fs_24_data);
                        $fs_24_data = array_slice($fs_24_data, 1, -1);

                        $content .= '<div class="mux_lights_describe_catList">';
                        $content .= '<div class="mux_lights_describe_catListMian">';
                        foreach ($fs_24_data as $key => $value) {
                            $value = explode('@@', $value);

                            $value[0] = trim($value[0]);
                            if ((strpos($value[0], '.webp') !== false) && (!is_support_webp())) {
                                $value[0] = substr($value[0], 0, strrpos($value[0], '.webp'));
                            }

                            $content .= '<div class="mux_lights_describe_catLi">
                                               <div class="mux_lights_describe_catLi_imgbox">
                                                   <img src="'.HTTPS_IMAGE_SERVER.$value[0].'" width="'.$width.'">
                                               </div>
                                               <div class="mux_lights_describe_catLi_txt">'.trim($value[1]).'</div>
                                         </div>';
                        }

                        $content .= '</div>';
                        $content .= '</div>';

                        if ((strpos($end_img, '.webp') !== false) && (!is_support_webp())) {
                            $end_img = substr($end_img, 0, strrpos($end_img, '.webp'));
                        }
                        
                        $content .= '<div class="mux_demux_p_pic">
						                <img src="'.HTTPS_IMAGE_SERVER.$end_img.'" alt="">
					                 </div>';
                        $content .= '</div>';

                        break;

                    case 'FS_SWITCH_TABLE': //交换机参数对比表格
                        $content .= '<hr>';
                        $content .= '<div class="prodetails_lights_tabwrap">';
                        $table_data = explode('{{',$tag[1]);
                        foreach($table_data as $table){
                            $table = trim($table);  //去除前后空字符
                            $table = rtrim($table,';');
                            $table_title = substr($table,0,8);
                            $table_content = substr($table,9);
                            if($table_title=='TABLE_01'){   //表格样式1
                                $table_arr = explode(';',$table_content);
                                $first_row = explode('|',$table_arr[0]);
                                $table_column_num = count($first_row);
                                if($table_column_num>6){
                                    $table_column_num = 6;
                                }
                                $table_class = 'lights_tab_type_'.$table_column_num;
                                $content .= '<div class="prodetails_lights_tabBox">';
                                $content .= '<table class="prodetails_lights_tab '.$table_class.'" cellpadding="0" cellspacing="0">';
                                $choose_column = 0;		//高亮展示的列
                                foreach($table_arr as $key=>$value){
                                    $value_column = explode('|',$value);
                                    if($key==0){	//表头
                                        $content .= '<thead><tr>';
                                        foreach($value_column as $kk=>$vv){
                                            $vv = trim($vv);
                                            $thead_class = '';
                                            if(substr($vv,0,3)=='***'){
                                                $vv = substr($vv,3);
                                                $choose_column = $kk;
                                                $thead_class = ' class="choose_light"';
                                            }
                                            if($vv){
                                                $vv_arr = explode('$$',$vv);
                                                $content .= '<td '.$thead_class.'>';
                                                foreach($vv_arr as $item=>$itemVal){
                                                    $itemValArr = explode('#',$itemVal);
                                                    if(count($itemValArr)==3){
                                                        $content .= '<a href="'.reset_url($itemValArr[0]).'">
                                                                        <div class="prodetails_lights_tabimgBox">
                                                                            <img src="'.zen_get_img_change_src($itemValArr[1]).'">
                                                                        </div>
                                                                        <div class="prodetails_lights_tabtit">'.$itemValArr[2].'</div>
                                                                    </a>';
                                                    }else{
                                                        $content .= '<a href="'.reset_url($itemValArr[0]).'"><div class="prodetails_lights_tabtit">'.$itemValArr[1].'</div></a>';
                                                    }
                                                }
                                                $content .= '</div></td>';
                                            }else{
                                                $content .= '<td></td>';
                                            }
                                        }
                                        $content .= '</thead></tr>';
                                    }else{
                                        $content .= '<tr>';
                                        foreach($value_column as $kk=>$vv){
                                            $td_class = '';
                                            if($choose_column && $choose_column==$kk){
                                                $td_class = ' class="choose_light"';
                                            }
                                            if(strpos($vv,'#')){
                                                $vv_arr = explode('#',$vv);
                                                $content .= '<td '.$td_class.'>
                                                        <div>
                                                            <a href="'.reset_url($vv_arr[0]).'"><div>'.$vv_arr[1].'</div></a>
                                                        </div>
                                                    </td>';
                                            }else{
                                                $content .= '<td '.$td_class.'>
                                                        <div>
                                                            <div>'.$vv.'</div>
                                                        </div>
                                                    </td>';
                                            }
                                        }
                                        $content .= '</tr>';
                                    }
                                }
                                $content .= '</table>';
                                $content .= '</div>';
                            }elseif($table_title=='TABLE_02'){  //表格样式2
                                $table_arr = explode(';',$table_content);
                                $first_row = explode('|',$table_arr[0]);
                                $table_column_num = count($first_row);
                                if($table_column_num>7){
                                    $table_column_num = 7;
                                }
                                $table_class = 'lights_tab_type01_'.$table_column_num;
                                $content .= '<div class="prodetails_lights_tabBox">';
                                $content .= '<table class="prodetails_lights_tab01 '.$table_class.'" cellpadding="0" cellspacing="0">';
                                $choose_column = 0;		//高亮展示的列
                                $ii = 0;
                                foreach($table_arr as $key=>$value){
                                    $value_column = explode('|',$value);
                                    if($key==0){	//表头
                                        $content .= '<thead><tr>';
                                        foreach($value_column as $kk=>$vv){
                                            $vv = trim($vv);
                                            $thead_class = '';
                                            if(substr($vv,0,3)=='***'){
                                                $vv = substr($vv,3);
                                                $choose_column = $kk;
                                                $thead_class = ' class="choose_light"';
                                            }

                                            $content .= '<td '.$thead_class.'><div>
							<div class="prodetails_lights_tabtit01">
								'.$vv.'
							</div>
						</div></td>';
                                        }
                                        $content .= '</thead></tr>';
                                    }else{
                                        $tr_class = '';
                                        if(strpos($value,'#')){
                                            $tr_class = ' class="prodetails_lights_protr"';
                                        }else{
                                            $ii++;
                                        }
                                        $content .= '<tr '.$tr_class.'>';
                                        foreach($value_column as $kk=>$vv){
                                            $now_row_column_name = $key.'_'.$kk;
                                            $td_class = '';
                                            if($choose_column && $choose_column==$kk){
                                                $td_class = ' choose_light';
                                            }
                                            if($kk>0 && $vv){
                                                if($ii==1){
                                                    //有内容的td背景色是深蓝浅蓝间隔
                                                    $$now_row_column_name = 1;
                                                    $td_class .= ' td_bg1';
                                                }else{
                                                    //当前有内容的td背景色需要和上一行同一列的作比较
                                                    $after_row_column_name = ($key-1).'_'.$kk;
                                                    if($$after_row_column_name==1){
                                                        $$now_row_column_name = 2;
                                                        $td_class .= ' td_bg2';
                                                    }else{
                                                        $$now_row_column_name = 1;
                                                        $td_class .= ' td_bg1';
                                                    }
                                                }
                                            }
                                            if($td_class){
                                                $td_class = ' class="'.$td_class.'"';
                                            }
                                            if(!$vv){
                                                $content .= '<td '.$td_class.'></td>';
                                            }else{
                                                $vv_arr = explode('#',$vv);
                                                if(count($vv_arr)>1){
                                                    //图片文字组合
                                                    $content .= '<td '.$td_class.'>
                                                    <div>
                                                        <div class="prodetails_lights_tabimgBox01">
                                                            <img src="'.zen_get_img_change_src($vv_arr[0]).'">
                                                        </div>
                                                        <div class="prodetails_lights_tabimgBox02">
                                                            <img src="https://img-en.fs.com/includes/templates/fiberstore/images/prodetails_lights_bg.png">
                                                            <div class="prodetails_lights_tabimgtxt">
                                                                <div><div><p>'.$vv_arr[1].'</p></div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>';
                                                }else{
                                                    $content .= '<td '.$td_class.'>
                                                <div>
                                                    <div>'.$vv.'</div>
                                                </div>
                                            </td>';
                                                }
                                            }
                                        }
                                        $content .= '</tr>';
                                    }
                                }
                                $content .= '</table>';
                                $content .= '</div>';
                            }
                        }
                        $content .= '</div>';
                        break;

                    default:
                        $content .= '';
                        break;
                }
            } else {
                if (trim($tag[0])) {
                    $description = explode(";", $tag[0]);

                    $fs = 0;
                    $related_title = array("Recommended Products", "Related Products", "Produits Connexes", "Produits Recommandés", "Productos Recomendados", "Productos Recomendados", "Productos relativos", "関連製品","Prodotti correlati");
                    if (!strpos($description[0], ".jpeg") && !strpos($description[0], ".jpg") && !strpos($description[0], ".png") && !strpos($description[0], ".gif")) {   /* 第一段没有图片,则为标题 */
                        if (!in_array($description[0], $related_title)) {
                            $content .= '<div class="p_con_new_tit03">';
                            $content .=  $description[0];
                            $content .= '</div>';
                        }
                    }
                    for ($dt = 1; $dt < sizeof($description); $dt++) {
                        if (!strpos($description[$dt], ".jpeg") && !strpos($description[$dt], ".jpg") && !strpos($description[$dt], ".png") && !strpos($description[$dt], ".gif")) {   /* 第三段没有图片,则为标题+说明+说明 */
                            $content .= '<div class="p_con_02">' . $description[$dt] . '</div>';
                        }
                    }
                }
            }
            if ($merge_modules_arr && in_array(($i + 1), $two_merge_modules_str)) { // 如果存在合并modules，则在第二个modules清除浮动
                $content .= '</div><div style="clear:both;"></div>';
            } else {
                $content .= '</div>';
            }
        }
    }
    if($content) {
        $content .= '<hr>';
    }

    $content=str_replace_http($content);

    //$content .= '<div style="clear:both;"></div>';
    return $content;
}


// 获取 通过长度转换成的ft
// $length_str 1m,包含m
function get_length_exchange_ft_str($length_str){
    switch ($length_str){
		case '0.15m': $ft_str = '6in'; break;
        case '0.3m': $ft_str = '1ft'; break;
        case '0.6m': $ft_str = '2ft'; break;
		case '0.5m': $ft_str = '1.6ft'; break;
		case '0.9m': $ft_str = '3ft'; break;
        case '1m': $ft_str = '3ft'; break;
        case '1.2m': $ft_str = '4ft'; break;
        case '1.5m': $ft_str = '5ft'; break;
        case '1.8m': $ft_str = '6ft'; break;
        case '2m': $ft_str = '7ft'; break;
        case '3m': $ft_str = '10ft'; break;
        case '4m': $ft_str = '13ft'; break;
        case '5m': $ft_str = '16ft'; break;
        case '7m': $ft_str = '23ft'; break;
        case '8m': $ft_str = '26ft'; break;
        case '10m': $ft_str = '33ft'; break;
        case '15m': $ft_str = '49ft'; break;
        case '20m': $ft_str = '66ft'; break;
        case '25m': $ft_str = '82ft'; break;
        case '30m': $ft_str = '98ft'; break;
        case '50m': $ft_str = '164ft'; break;
        default:  $ft_str = '';
    }
    return $ft_str;
}

/**
 * @notes :为防止产品详情页里面foreach循环获取长度出现多重反复循环
 * @author:potato
 * @date  :2019/7/23
 * @param $length_str
 */
function get_length_exchange_ft_str_new($length_str)
{
    $length_arr = [
        '0.15m' => '6in',
        '0.3m' => '1ft',
        '0.6m' => '2ft',
        '0.5m' => '1.6ft',
        '0.9m' => '3ft',
        '1m' => '3ft',
        '1.2m' => '4ft',
        '1.5m' => '5ft',
        '1.8m' => '6ft',
        '2m' => '7ft',
        '3m' => '10ft',
        '4m' => '13ft',
        '5m' => '16ft',
        '7m' => '23ft',
        '8m' => '26ft',
        '10m' => '33ft',
        '15m' => '49ft',
        '20m' => '66ft',
        '25m' => '82ft',
        '30m' => '98ft',
        '50m' => '164ft',
    ];
    return isset($length_arr[$length_str]) ? $length_arr[$length_str] : '';
//    if (array_key_exists($length_str, $length_arr)) return $length_arr[$length_str];
//    return '';
}

function zen_create_stock_list_html($stock_list){
    global $db,$currencies;
	$stock_list_str = '';
    $stock_list = str_replace("；", ";",$stock_list);
    $stock_list = str_replace("：", ":",$stock_list);
    $country_code_iso = strtolower($_SESSION['countries_iso_code']);

    $stock_table_arr = explode("||",$stock_list) ;
    foreach ($stock_table_arr as $sl_val) {
        if ($sl_val) {
            $stock_list = $sl_val ;
            $stock_list_titile = '';
            $stock_list_tr = '';
            $str_pos = strpos($stock_list, '#');
            if ($str_pos === false) {
            }else{
                $stock_list_titile = substr($stock_list, 0, $str_pos);
                $stock_list = substr($stock_list, $str_pos+1);
                $stock_list_titile = '<div class="p_con_new_tit03">'.$stock_list_titile.'</div>';
            }
            $stock_list_arr = explode(";",$stock_list) ;
            if (sizeof($stock_list_arr)) {
                foreach ($stock_list_arr as $stock_list_val) {
                    $stock_prod_arr = array();
                    $stock_prod_arr = explode(":",$stock_list_val) ;
                    $stock_prod_id  = (int)trim($stock_prod_arr[0]);
//                    $stock_prod_str = fs_get_data_from_db_fields('products_name',TABLE_PRODUCTS_DESCRIPTION,'products_id='.(int)$stock_prod_id,'');
                    $stock_prod_str = zen_get_products_name((int)$stock_prod_id);
                    if ($stock_prod_id) {
                        //判断是否为属性产品 ternence 2020/3/6
                        $quicktocart = false;
                        $productsAttributesInfo = zen_get_products_attributes_total($stock_prod_id);
                        $productLengthInfo = fs_product_length_info($stock_prod_id);
                        if(!$productLengthInfo && !$productsAttributesInfo){
                            $quicktocart = true;
                        }
                        $product_category_status = get_product_category_status($stock_prod_id);
                        $custom_status = false;
                        $sql = "select column_id,column_name from attribute_custom_column where column_name = '" . (int)$stock_prod_id . "' and parent_id = 0";
                        $attribute_custom_column = $db->Execute($sql);
                        if($attribute_custom_column->fields['column_name']>0){
                            $custom_status = true;
                        }
                        $product_stock = get_instock_for_index($stock_prod_id,true);
                        $product_stock = str_replace(QTY_SHOW_ZERO_STOCK_1,FS_SHIP_PCS,$product_stock);

                        //产品价格  澳大利亚展示税后价
                        $products_price = zen_get_products_final_price((int)$stock_prod_id);  //经过是否取整，不带符号美元价格
                        $products_price = $currencies->total_format($products_price);

                        $image = get_resources_img($stock_prod_id,60,60);
                        $stock_list_tr .= '<tr style="background-color: rgb(255, 255, 255);">
                            <td style="text-align: center;">'.$image.'</td>
                            <td style="text-align: center;"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$stock_prod_id,'SSL').'">
                            '.$stock_prod_id.'</a></td>
                            <td style="text-align: left;">'.$stock_prod_str.'</td>
                            <td style="text-align: center;">'.$products_price.'</td>
                            <td style="text-align: center;"><div class="pro_yellow_stock "><i></i>'.$product_stock.'</div></td>
                            <td style="text-align: center;">
                            <div>';

                        if($quicktocart && $custom_status == false && !$product_category_status){
                            //普通产品
                            $stock_list_tr .='<a class="button_02" onclick="prodAddToCartMatching('.$stock_prod_id.',$(this))" data-product-id="'.$stock_prod_id.'">
                            <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>'.FS_COMMON_ADD.'</a>';
                        }else {
                            $stock_list_tr .= '<a class="button_02" href="'.zen_href_link('product_info', 'products_id=' .$stock_prod_id).'" target="_blank">
                            <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . FS_COMMON_ADD . '</a>';
                        }
                        $stock_list_tr .='</div>
		        </td>
		      </tr>';
                    }
                }
            }
            if ($stock_list_tr) {
                $stock_list_str .= $stock_list_titile.'<div class="pro_stock_list">
		  <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody>
		      <tr class="p_con_04">
		        <td class="first_td" style="text-align: center;">'.FS_STOCK_LIST_PIC.'</td>
		        <td style="text-align: center;">'.FS_STOCK_LIST_ID.'</td>
		        <td style="text-align: center;">'.FS_STOCK_LIST_DESC.'</td>       
		        <td style="text-align: center; width:135px;">'.FS_STOCK_LIST_PRICE.'</td>
		        <td style="text-align: center; width:85px;">'.FS_STOCK_LIST_STOCK.'</td>
		        <td style="text-align: center; width:150px;">'.FS_STOCK_LIST_ADD_TO_CART.'</td> 
		      </tr>
		      '.$stock_list_tr.'
		    </tbody>
		  </table>
		</div>';
            }
        }
    }
	return $stock_list_str;
}
function zen_create_other_stock_list_html($stock_list){
	$stock_list_str = '';
    $stock_list = str_replace("；", ";",$stock_list);
    $stock_list = str_replace("：", ":",$stock_list);
	$stock_list = trim($stock_list);
	$stock_list = trim($stock_list,';');

    $stock_table_arr = explode("||",$stock_list) ;
    foreach ($stock_table_arr as $sl_val) {
        if ($sl_val) {
            $stock_list = $sl_val ;
            $stock_list_titile = '';
            $stock_list_tr = '';
            $str_pos = strpos($stock_list, '#');
            if ($str_pos === false) {
            }else{
                $stock_list_titile = substr($stock_list, 0, $str_pos);
                $stock_list = substr($stock_list, $str_pos+1);
                $stock_list_titile = '<div class="p_con_01"><h2>'.$stock_list_titile.'</h2></div>';
            }
            $stock_list_arr = explode(";",$stock_list) ;
			$stock_num = sizeof($stock_list_arr);
			$channel_flag = false;
            if ($stock_num) {
				$arr = explode(":",$stock_list_arr[0]) ;
				$td_width = 'width="16.66%"';
				if(count($arr)==3){
					$channel_flag = true;
					$td_width = 'width="12.55%"';
				}
                foreach ($stock_list_arr as $k=>$stock_list_val) {
                    $stock_prod_arr = array();
                    $stock_prod_arr = explode(":",$stock_list_val) ;
                    $stock_prod_id  = (int)trim($stock_prod_arr[0]);
                    $stock_prod_str = trim($stock_prod_arr[1]);
					$stock_channel = trim($stock_prod_arr[2]);
                    if ($stock_prod_id) {
						if($k%2==0) $stock_list_tr .= '<tr style="background-color: rgb(255, 255, 255);">';
                        $stock_list_tr .= '
		        <td style="text-align: center;"><a style="color: #2971ba;" href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$stock_prod_id,'SSL').'">
		        '.$stock_prod_id.'</a></td>
		        <td style="text-align: center;">'.$stock_prod_str.'</td>';
				if($channel_flag){
					$stock_list_tr .= '<td style="text-align: center;">'.$stock_channel.'</td>';
				}
						$stock_list_tr .= fs_products_instock_qty($stock_prod_id);
						if($k%2==1) $stock_list_tr .= '</tr>';
                    }
                }
				if($stock_num%2==1){
					$stock_list_tr .='<td></td><td></td><td></td>';
					if($channel_flag) $stock_list_tr .= '<td></td>';
					$stock_list_tr .= '</tr>';
				}
            }
            if ($stock_list_tr) {
                $stock_list_str .= $stock_list_titile.'<div class="pro_stock_list">
		  <table border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody>
		      <tr class="p_con_04">
		        <td class="first_td" style="text-align: center;">'.FS_STOCK_LIST_OTHER_ID.'</td>
		        <td style="text-align: center;width:200px;">'.FS_STOCK_LIST_CENTER.'</td>';
				if($channel_flag){
					$stock_list_str .= '<td style="text-align: center;">'.FS_STOCK_LIST_CHANNEL.'</td>';
				}
		        $stock_list_str .= '<td style="text-align: center;">'.FS_STOCK_LIST_STOCK.'</td>
		        <td class="first_td" style="text-align: center;">'.FS_STOCK_LIST_OTHER_ID.'</td>
		        <td style="text-align: center;width:200px;">'.FS_STOCK_LIST_CENTER.'</td>';
				if($channel_flag){
					$stock_list_str .= '<td style="text-align: center;">'.FS_STOCK_LIST_CHANNEL.'</td>';
				}
		        $stock_list_str .= '<td style="text-align: center;">'.FS_STOCK_LIST_STOCK.'</td>
		      </tr>
		      '.$stock_list_tr.'
		    </tbody>
		  </table>
		</div>';
            }
        }
    }
	return $stock_list_str;
}
function getIp(){
    if ($_SERVER['REMOTE_ADDR']) {//判断SERVER里面有没有ip，因为用户访问的时候会自动给你网这里面存入一个ip
        $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv("REMOTE_ADDR")) {//如果没有去系统变量里面取一次 getenv()取系统变量的方法名字
        $cip = getenv("REMOTE_ADDR");
    } elseif (getenv("HTTP_CLIENT_IP")) {//如果还没有在去系统变量里取下客户端的ip
        $cip = getenv("HTTP_CLIENT_IP");
    } else {
        $cip = "unknown";
    }
    return $cip;
}



function newGetIp() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $res;
}

function getCity($ip)
{
    if($ip == ''){
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";//新浪接口获取访问者地区
        $ip=json_decode(file_get_contents($url),true);
        $data = $ip;
    }else{
        $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;//淘宝接口需要填写ip
        $ip=json_decode(file_get_contents($url));
        if((string)$ip->code=='1'){
            return false;
        }
        $data = (array)$ip->data;
    }
    return $data;
}

//quickfinder  表格的品牌部分去除customized
function fs_quickfinder_table_brand_remove_custom($id){
    global $db;
    $brandsql = $db->Execute("select brand_id,brand_name from categories_fiber_quickfinder_brand where id=".(int)$id ." and language_id = 1 and brand_name_id!=4971 order by brand_id ");
    $brand = array();

    while(!$brandsql->EOF){
        $brand []= array(
            'brand_id' => $brandsql->fields['brand_id'],
            'brand_name' => $brandsql->fields['brand_name']
        );
        $brandsql->MoveNext();
    }
    return $brand;
}

// 判断产品是否定制
function check_is_custom($pid)
{
    $options_name = fs_products_option_info($pid);
    $productLengthInfo = fs_product_length_info($pid);
    $isCustom = true;
    if (sizeof($options_name) || $productLengthInfo) {
        $isCustom = false;
    }
    return $isCustom;
}

//get product price
function zen_get_product_price($pid){
    global $currencies;
    $wholesale_products = fs_get_wholesale_products_array();
    if(!in_array($pid,$wholesale_products)){
        $match_product_price =  $currencies->new_display_price(get_customers_products_level_final_price(zen_get_products_base_price((int)$pid)),0);
    }else{
        $match_product_price = $currencies->display_price(get_customers_products_level_final_price(zen_get_products_base_price((int)$pid)),0);
    }
    return $match_product_price;
}

/*
 * 获取产品列表的加入购物按钮
 * @para array $pid: 产品id
 * @para string $type: 展示类型：list/image 列表/图片
 */
function products_add_cart_popup($pid='')
{
    $video_img_id = 'video_img';
    $video_array_title_id = 'video_array_title';
    $video_price_id = 'popup_cart_price';
//    $popup_catr_nunm_id = 'popup_catr_nunm';
    $addCart_qty_num_id = 'addCart_qty_num';
    //加购的弹窗 暂时不需要数量 所以删除这个id js暂时先保留

    $html = '';
    if(!empty($pid)){
        $productImageSrc = fs_get_data_from_db_fields('products_image', 'products', 'products_id="' . (int)$pid . '"', '');
        $img_src = file_exists(DIR_WS_IMAGES . $productImageSrc) ? $productImageSrc : 'no_picture.gif';
        $image = get_resources_img($pid,120,120,$img_src,'','',' border="0" ');

        $two_fields = array('stock_list', 'products_name');
        $match_products = fs_get_data_from_db_fields_array($two_fields, TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . $pid . ' and language_id=' . $_SESSION['languages_id'], '');
        $html = '<div class="new_popup addCart show new_product_popup_addCart" style="display: none;">
	<div class="new_popup_bg"></div>
	<div class="new_popup_main popup_width680 pupop_video">
		<h2 class="new_popup_addCart_tit">
			<span class="icon iconfont" onclick="$(\'.addCart\').hide();">&#xf092;</span>
		</h2>
		<div class="new_popup_content addCart_cont"> 
			<div class="addCrat_item_number"><span class="icon iconfont">&#xf186</span>'.FS_ADDED_TO_CART.'</div>
			<div class="addCrat_item_list">
				<div class="addCrat_item_list_top">
					<div class="addCrat_left">
						<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$pid,'SSL').'">' . $image . '</a>
					</div>
					<div class="addCrat_right">
						<h1 class="addCrat_item_list_tit">
							<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$pid,'SSL').'">' . $match_products[0][1] . '</a>
							<span>#' . $pid . '</span>
						</h1>
						<div id="qty_attribute_div"><p class="Qty_num"><span>'.FS_CART_QTY.' <span id="'.$addCart_qty_num_id.'"></span></span></p></div>
						<p class="addCart_pro_price after"><span id="popup_cart_price">' . zen_get_product_price($pid) . '</span><span id="product_ea">'. FS_PRODUCT_PRICE_EA .'</span></p>
					</div>
				</div>
				<div class="addCrat_item_list_bottom">
					<div class="fs_customer_btn">
						<a href="javascript:;" onclick="$(\'.addCart\').hide();" class="fs_customer_btnG01">'.FS_CONTINUE_SHOPPING.'</a><a href="'.zen_href_link('shopping_cart','','SSL').'"   class="fs_customer_btn01 mg_left10">'.FS_VIEW_CART.'</a>
					</div>
				</div>
            </div>';
        if ($match_products[0][0]) {
            $stock_list = $match_products[0][0];
            $stock_list = str_replace("；", ";", $stock_list);
            $stock_list = str_replace("：", ":", $stock_list);
            $is_stock = strpos($stock_list, '##');
            if (!$is_stock) {
                $stock_list = trim($stock_list,';');
                $stock_arr = explode(';', $stock_list);
                if (sizeof($stock_arr) > 8) {
                    $stock_arr = array_slice($stock_arr, 0, 8);
                }
                $html .='<div class="addCart_also_bought">
				<p class="also_bought">'.FS_CUSTOMERS_ALSO.'</p>
				<div class="addCart_bought_carousel">
					<div class="iconfont addCart_alert_pre">&#xf090;</div>
                    <div class="iconfont addCart_alert_next">&#xf089;</div>
					<div class="addCart_bought_carousel_box">
						<ul class="addCart_bought_carousel_list bought_carousel">';
                foreach ($stock_arr as $k => $v) {
                    $sub_stock_arr = explode(':', $v);
                    if (strpos($sub_stock_arr[0], "#") !== false) {
                        $sub_stock_v = explode('#', $sub_stock_arr[0]);
                        $sub_stock_vv = trim($sub_stock_v[1]);
                    } else {
                        $sub_stock_vv = trim($sub_stock_arr[0]);
                    }
//            $new_mat_img = fs_get_data_from_db_fields('thumb_images', 'products_additional_thumb_images', 'products_id=' . $sub_stock_vv . ' and is_main=1 and size_w=130', '');
//            if ($new_mat_img) {
//                $img = '<img src=' . HTTPS_IMAGE_SERVER . DIR_WS_IMAGES . 'products/' . $new_mat_img . '>';
//            } else {
                    if(is_numeric($sub_stock_vv)){
                        //产品库存状态(搜索页弹窗)
                        $stock = get_instock_for_index($sub_stock_vv,true);
                        $mat_img = fs_get_data_from_db_fields('products_image', 'products', 'products_id=' . (int)$sub_stock_vv, '');
                        $mat_src = file_exists(DIR_WS_IMAGES . $mat_img) ? $mat_img : 'no_picture.gif';
                        $img = get_resources_img((int)$sub_stock_vv,80,80,$mat_src);
                        $html .= '<li>
								<div>
									<a href="'.zen_href_link('product_info','products_id='.(int)$sub_stock_vv,'SSL').'">' . $img . '</a>
								</div>
								<a class="addCart_pro_link" title="' . fs_get_data_from_db_fields('products_name', TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . (int)$sub_stock_vv . ' and language_id=' . $_SESSION['languages_id'], '') . '" href="'.zen_href_link('product_info','products_id='.(int)$sub_stock_vv,'SSL').'">' . fs_get_data_from_db_fields('products_name', TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . (int)$sub_stock_vv . ' and language_id=' . $_SESSION['languages_id'], '') . '</a>
								<p>' . zen_get_product_price((int)$sub_stock_vv) . '</p>
								<div class="qv_stock">' . $stock . '</div>
							</li>';
                    }
//            }
                }
                $html .='</ul></div></div></div>';
            }
        }
        $html .= '
		</div>
	</div>
</div>
';
    }else{
        //列表页的需要单独区分，产品详情页两种情况的弹窗都有
        $video_img_id = 'video_img_list';
        $video_array_title_id = 'video_array_title_list';
        $video_price_id = 'popup_cart_price_list';
        $addCart_qty_num_id = 'addCart_qty_num_list';

        $html .='<div class="new_popup addCart show new_product_popup_addCart_list" style="display: none;">
            <div class="new_popup_bg"></div>
            <div class="new_popup_main popup_width680 pupop_video">
                <h2 class="new_popup_addCart_tit">
                    <span class="icon iconfont" onclick="$(\'.addCart\').hide();">&#xf092;</span>
                </h2>
                <div class="new_popup_content addCart_cont"> 
                    <div class="addCrat_item_number"><span class="icon iconfont">&#xf186</span>'.FS_ADDED_TO_CART.'</div>
                    <div class="addCrat_item_list">
                        <div class="addCrat_item_list_top">
                            <div class="addCrat_left" id="'.$video_img_id.'">
                                <a href=""></a>
                            </div>
                            <div class="addCrat_right">
                                <h1 class="addCrat_item_list_tit" id="'.$video_array_title_id.'">
                                    <a href=""></a>
                                    <span>#</span>
                                </h1>
                                <p class="Qty_num"><span>'.FS_CART_QTY.' <span id="'.$addCart_qty_num_id.'"></span></span></p>
                                <p class="addCart_pro_price after"><span id="'.$video_price_id.'"></span><span id="product_ea">'. FS_PRODUCT_PRICE_EA .'</span></p>
                            </div>
                        </div>
                        <div class="addCrat_item_list_bottom">
                            <div class="fs_customer_btn">
                                <a href="javascript:;" onclick="$(\'.addCart\').hide();" class="fs_customer_btnG01">'.FS_CONTINUE_SHOPPING.'</a><a href="'.zen_href_link('shopping_cart','','SSL').'" class="fs_customer_btn01 mg_left10">'.FS_VIEW_CART.'</a>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>';
    }
    return $html;
}

//判断产品分仓条件
function fs_products_warehouse_where($countries_code_2=''){
	$data = array();
	$code = $where = '';
	if(!$countries_code_2){
        $countries_code_2 = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : "US";
    }
    $countries_code_2 = strtoupper($countries_code_2);
	if(all_german_warehouse('country_code',$countries_code_2)){
		//德国仓
		$code = 'de';
		$where = ' and de_status=1 ';
	}else if(seattle_warehouse("country_code",$countries_code_2)){
		//西雅图仓
		$code = 'us';
		$where = ' and us_status=1 ';
	}else if(au_warehouse($countries_code_2,'country_code')){
		//澳大利亚仓
		$code = 'au';
		$where = ' and au_status=1 ';
	}elseif(singapore_warehouse("country_code", $countries_code_2)){
	    //新加坡仓
        $code = 'sg';
        $where = ' and sg_status=1 ';
    }elseif(ru_warehouse("country_code", $countries_code_2)){
        //俄罗斯仓
        $code = 'ru';
        $where = ' and ru_status=1 ';
    }else{
		$code = 'cn';
		$where = ' and cn_status=1 ';
	}
	$data['code'] = $code;
	$data['where'] = $where;
	return $data;
}

//获取产品分仓开启状态
function get_product_status($products_id){
    global $db;
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_fields = strtolower($warehouse_data['code']).'_status';
    $sqlCache = sqlCacheType();
    $match_status_arr = $db->getAll("SELECT {$sqlCache} products_status,{$warehouse_fields} FROM ".TABLE_PRODUCTS." WHERE products_id={$products_id} LIMIT 1");
    if($match_status_arr[0]['products_status']==1 && $match_status_arr[0][$warehouse_fields]==1){
        return 1;
    }else{
        return 0;
    }
}

//获取产品开启状态
function get_product_status_new($products_id){
    global $db;
    if($products_id){
        $product_status = $db->getAll("select products_status from products where products_id=".$products_id."");
        return $product_status[0]['products_status'];
    }
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 获取产品价格
function get_products_price($products_id,$wholesaleproducts=[]){
    global $currencies;
    if(empty($wholesaleproducts)){
        $wholesaleproducts = fs_get_wholesale_products_array();
    }
    if(!in_array($products_id,$wholesaleproducts)){
        return $currencies->new_display_price(get_customers_products_level_final_price(zen_get_products_base_price($products_id)),0);
    }else{
        return $currencies->display_price(get_customers_products_level_final_price(zen_get_products_base_price($products_id)),0);
    }
}

// 2018.8.28 装箱产品判断
function get_product_packing_conditions($products_id){
    global $db;
    if(!empty($products_id)){
        $conditions_info = $db->getAll("select p.discount,p.packing_quantity,p.products_price from
           " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd 
           where p.products_id = '" .(int)$products_id ."' 
           and  pd.products_id = p.products_id 
           and  pd.language_id = '" .(int)$_SESSION['languages_id']."' 
           and  discount_type=1 and discount>0");
        if(count($conditions_info)==1){
            return $conditions_info[0];
        }
    }else{
        return false;
    }
}

//2018.10.15   ery  add 产品详情页线材类产品获取关联的定制产品ID
function fs_get_all_attribute_related_custom_id($products_id){
    global $db;
    $related_custom_id = $html = '';
    if($products_id){
        $info = $db->getAll("SELECT	`related_custom_id`,`products_status` FROM `products` WHERE `products_id`=".(int)$products_id." LIMIT 1");
        if($info[0]['related_custom_id'] && $info[0]['products_status']==1){
            $related_custom_id = $info[0]['related_custom_id'];
        } else {
            $customizedInfo = $db->getAll("SELECT `customized_id` FROM `products_instock_other_customized_related` WHERE `products_id`=".(int)$products_id);
            $customizedData = array_column($customizedInfo, 'customized_id');
            if ($customizedData) {
                $isRelatedCustom = $db->getAll("SELECT `related_custom_id`,`products_status` FROM `products` WHERE `products_id` in (".join(',', $customizedData).")");
                foreach ($isRelatedCustom as $v) {
                    if ($v['related_custom_id'] && $v['products_status']==1){
                        $related_custom_id = $v['related_custom_id'];
                        break;
                    }
                }
            }
        }
    }
    if ($related_custom_id) {
        $html .= '<dd class=" pro_item"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$related_custom_id,'NONSSL').'" class="Difference_more">'.FS_ATTRIBUTE_CUSTOMIZED .'</a></dd>';
    }
    return $html;
}

/*
 * 获取产品颜色对应的色块
 * 传递的颜色
 * fairy 2018.11.15 add
 */
function get_product_color_str($color){
    $array = array(
        'Blue' => '#4e83ff',
        'Dark Blue' => '#4e83ff',
        'Light Blue' => '#3dafff',
        'Green' => '#31a2a0',
        'Dark Green' => '#31a2a0',
        'Light Green' => '#52b13d',
        'Red' => '#d23242',
        'Dark Red' => '#d23242',
        'Light Red' => '#fa4937',
        'Aqua' => '#6ed5ec',
        'Black' => '#232323',
        'Gray' => '#7e7e7e',
        'Pink' => '#ff97cd',
        'Yellow' => '#f8d93e',
        'Orange' => '#f39b2a',
        'Purple' => '#ab7cd8',
        'White' => '#ffffff',
    );
    return $array[$color];
}

/*
 * 获取产品列表的整理数据
 * 有缓存数据；目的：为了搜索和列表页面,处理单个产品共同使用。
 * @para array $product: 一个产品的产品的数组
 * @para string $from_page: 来自哪里，list、qv、search
 * @para array $category_arr: 产品分类数组
 * @para bool $m
 * @return string $product: 整理之后的数据
 * fairy 2018.11.9 add
 */
function get_product_list_other_data($product,$from_page='list',$category_arr=''){
    global $fs_reviews;
    global $db,$currencies;
    $is_mobile = isMobile();
    $products_id = $product['products_id'];

    $product['id'] = $products_id;
    $product['is_min_order_qty'] =$product['is_min_order_qty']?$product['is_min_order_qty']:1;
    if(!$product['products_name']){
        $sql = 'SELECT PD.products_name,PD.products_common_name,PCN.products_common_name as pcn_products_common_name,PCN.categories_id
                FROM  '.TABLE_PRODUCTS_DESCRIPTION.' PD
                LEFT JOIN products_categories_common_name as PCN 
                ON PD.products_id = PCN.products_id and PD.language_id = PCN.languages_id
                where PD.products_id  = '.$products_id.' and PD.language_id ="'.(int)$_SESSION['languages_id'].'" limit 1';
        $products_description = $db->getAll($sql);
        $products_description = $products_description[0];
        $product['products_name'] = $products_description['products_name'];
        if($products_description['pcn_products_common_name'] && ($product['categories_id'] == $products_description['categories_id'])){
            $product['products_common_name'] =   $products_description['pcn_products_common_name'];  //复制产品关联组在列表页面不同的公共标题 XQ20200708011
            }else{
            $product['products_common_name'] =   $products_description['products_common_name'];
        }
    }
    //$product['products_common_name'] = ''; //公共标题赋值为空。相当于公共标题功能暂时去掉。如果后台后期需要公共标题。这把这行代码去掉

    // 产品价格
    $new_product_price = zen_get_products_base_price_other($product['products_price']);

    //澳大利亚展示税后价
    $currency = $_SESSION['currency'] ? $_SESSION['currency'] : 'USD';
    $currency_value = $currencies->currencies[$currency]['value'];
    if ($product['integer_state'] ==0) {
        $new_product_price = get_products_all_currency_final_price($new_product_price*$currency_value);
    }else{
        $new_product_price = get_products_specail_currency_final_price($new_product_price*$currency_value);
    }
    //返回的仍然是美元为单位的价格
    $new_product_price = $new_product_price/$currency_value;
    // 澳大利亚税后价在是否取整之后*1.1
    $new_product_price = get_gsp_tax_price($_SESSION['countries_iso_code'],$new_product_price);
    $product['products_price_str'] = $new_product_price;

    //评论
    //$product['review_count'] = $fs_reviews->review_total_count;
    if($from_page == 'search'){
        $fs_reviews->get_product_review_rating_show($products_id);
    }else{
        $fs_reviews->get_product_review_rating_show($products_id,$is_mobile);
    }
    $product['products_review_str'] = $fs_reviews->products_list_info;
    $product['products_review_total'] = $fs_reviews->review_total_count;


    // 是否定制
    //$is_custome_tag = fs_get_data_from_db_fields("is_customized","products","products_id={$products_id}");
    if(zen_get_products_length_total($products_id) != 0 || zen_get_products_attributes_total($products_id) != 0){
        $isNotCustom = false;
    }else{
        $isNotCustom = true;
    }
//    if ($is_custome_tag){
//        $isNotCustom = false;
//    }else{
//        $isNotCustom = true;
//    }
    if(in_array($products_id,[75874,75875,75877])){
        $isNotCustom = true;
    }

    $product['is_not_custom_str'] =  $isNotCustom;

    //产品分类
    if(!$category_arr){
        $category_arr = get_product_all_cpath($product['id']);
    }
    $product['category_arr'] =  $category_arr;

    // 产品视频
    $product_video_data = $db->getAll('select list_video,video,video_title,list_video_title from products_description where products_id='.$product['id'].' limit 1');
    $product_video_data = $product_video_data[0];
    //不正确的视频格式不展示
    if(strpos($product_video_data['list_video'],'https://www.youtube.com')===false && strpos($product_video_data['list_video'],'https://img-en.fs.com')===false){
        $product_video_data['list_video'] = '';
    }
    if(strpos($product_video_data['video'],'https://www.youtube.com')===false){
        $product_video_data['video'] = '';
    }
    $product = array_merge($product,$product_video_data);

    if($from_page == 'qv'){
        $product['products_info_array'] = array();
        //产品轮播图
        $wartermark_images_all = get_one_product_all_images($product['id'],$product['products_image']);
        $product['wartermark_images_all'] = $wartermark_images_all;
    }
    // 产品图片
    $image = get_resources_img($products_id,'180','180',$product['products_image'],$product['products_name']);
    $product['image_str'] =  $image;

    if($product['new_products_tag'] == 1 && (strtotime($product['new_products_time']) + 90 * 24 * 3600) >= time()){
        $product['is_new_tag'] = 1;
    }else{
        $product['is_new_tag'] = 0;
    }

    //ru站点组合产品展示为询价
    if ($_SESSION['countries_iso_code'] == 'ru' && !empty($product['composite_products']) && !in_array($products_id,['108704','108706'])){
        $product['is_inquiry'] = 1;
    }
    return  $product;
}

/**
 * $Notes: 获取瀑布流数据
 *
 * $author: Quest
 * $Date: 2020/10/21
 * $Time: 15:38
 * @param $categories_id
 * @return array
 */
function getListWaterfallData($categories_id)
{
    global $db;
    $languages_id = $_SESSION['languages_id'];

    $cacheKey = md5('waterfall_data_cache_' . $languages_id . '_' . $categories_id, true);
    if (!$result = get_redis_key_value($cacheKey, 'waterfall_data_redis_cache')) {
        $sql = "SELECT cw.id,w_line,w_column,url,title_color,img,img_color,categories_id,desc_color,app_img,title,title_img,description FROM categories_waterfall cw LEFT JOIN categories_waterfall_description cd ON cw.id = cd.waterfall_id WHERE cw.categories_id = {$categories_id} AND cd.languages_id = {$languages_id}";

        $waterfall_res = $db->getAll($sql);

        $waterfall_data = [];
        $lmit_data = [];
        foreach ($waterfall_res as $w_val){
            $line = $w_val['w_line'];
            $column = $w_val['w_column'] <= 4 ? $w_val['w_column'] : 4;
            $real_key =($line - 1) * 4 + $column;

            $waterfall_data[$real_key] = $w_val;
            $lmit_data[] = $real_key;
        }

        $result = array('waterfall_data' => $waterfall_data, 'limit_data' => $lmit_data);
        set_redis_key_value($cacheKey, $result, 24 * 60 * 60, 'waterfall_data_redis_cache');
    }

    return $result;
}

function getListWaterfallGridDom($waterfall_data)
{
    $main_img = HTTPS_IMAGE_SERVER . DIR_WS_IMAGES . $waterfall_data['img'];
    $title_img = !empty($waterfall_data['title_img']) ? HTTPS_IMAGE_SERVER . DIR_WS_IMAGES . $waterfall_data['title_img'] : '';

    $html_dom = '';
    $html_dom .= '<li class="new_proList_mainListLi adv">';
    if(!empty($waterfall_data['url'])){
        $html_dom .= '    <a href="' . reset_url($waterfall_data['url']) . '"  target="_blank">';
    }else{
        $html_dom .= '    <a href="javascript:;">';
    }

    $html_dom .= '        <div class="new_proList_mainListLi_adv" style="background-color: ' . $waterfall_data['img_color'] . ';">';
    $html_dom .= '            <div class="new_proList_mainListLi_adv_font">';
    if (!empty($title_img)) {
        $html_dom .= '                <img src="' . $title_img . '" alt="' . $title_img . '">';
    }
    if (!empty($waterfall_data['title'])) {
        $html_dom .= '                <h2 style="color: '.$waterfall_data['title_color'].'">' . $waterfall_data['title'] . '</h2>';
    }
    $html_dom .= '                <p style="color: '.$waterfall_data['desc_color'].'">' . $waterfall_data['description'] . '</p>';
    $html_dom .= '            </div>';
    $html_dom .= '            <img class="new_proList_mainListLi_adv_productImg" src="' . $main_img . '" alt="' . $main_img . '">';
    $html_dom .= '        </div>';
    $html_dom .= '    </a>';
    $html_dom .= '</li>';

    return $html_dom;
}

/**
 * $Notes: 获取列表页SQL LIMIT字符
 *
 * $author: Quest
 * $Date: 2020/10/21
 * $Time: 16:30
 * @param $w_limit 瀑布流数据组
 * @param $page 当前页数
 * @param $count
 * @return string
 */
function getListSqlLimitStr($w_limit, $page, $count)
{
    $offset_count = ($page - 1) * $count;
    $limit_count = $page * $count;
    $offset_reduce = 0;
    $limit_reduce = 0;
    foreach ($w_limit as $k_val) {
        if ($k_val < $offset_count) {
            $offset_reduce += 1;
        }
        $limit_diff = $limit_count - $k_val;
        if($limit_diff > 0 && $limit_diff <= $count){
            $limit_reduce += 1;
        }
    }
    $offset = $offset_count - $offset_reduce;
    $limit = $count - $limit_reduce;

    $limit_sql_str = ' LIMIT '.$offset.', '.$limit;

    return $limit_sql_str;
}

/**
 * @param $pid  //获取产品所有分类id
 * @return array
 */
function get_product_all_cpath($pid){
    global $db;
    $category_arr = array();
    if($pid){
        $categories = $db->getAll('select categories_id from products_to_categories WHERE products_id='.(int)$pid);
        $current_categories = $categories[0]['categories_id'];
        $category_arr = (array_reverse(get_category_parent_id($current_categories,array())));
    }
    return $category_arr;
}

/**
 * 获取一个产品的New/Hot及自定义标签HTML
 * @param $is_new_tag //是否为新品(有时效的判断)
 * @param int $new_products_tag  //新品及Hot标签 1 New 2 Hot
 * @param string $product_custom_tag //自定义标签
 * @return string
 */
function get_new_or_custom_tag_html($is_new_tag, $new_products_tag = 0, $product_custom_tag=''){
    if($new_products_tag ==0 && $product_custom_tag == ''){
        return '';
    }
    //优先判断自定义标签
    if(!empty($product_custom_tag)){
        $tag_html = '<div class="product_custom_tag">'.zen_db_prepare_input($product_custom_tag).'</div>';
        return $tag_html;
    }
    if($is_new_tag ==1){
        $tag_html = '<div class="new_product_tag">'.NEW_PRODUCTS_TAG.'</div>';
        return $tag_html;
    }
    if($new_products_tag == 2){
        $tag_html = '<div class="hot_product_tag">'.HOT_PRODUCTS_TAG.'</div>';
        return $tag_html;
    }
    return '';
}

/*
 * 获取产品列表的一个产品的展示
 * 没有缓存数据
 * @para array $product: 一个产品的产品数组
 * @para string $type: 展示类型：list/image 列表/图片
 * @para bool $is_ajax: 是否是异步提交
 * @para bool $is_show_attributes 是否显示产品属性
 * @para string $is_common_title 是否是公共标题
 * @param string $from_page  页面来源
 * @return string $products_list_info: 展示的html字符串
 * @para bool  $is_m_list 是否为列表页
 * @para array  $productQty 该产品所有仓库的库存信息 Bona.Guo 2021/2/26 15:42
 * fairy 2018.11.5 add
 */
function get_product_list_show_str($product,$type='list',$is_ajax=false,$is_show_attributes=true,$is_common_title=false,$is_m_list=false,$from_page='',$productQty=[]){
    global $db;
    global $currencies;
    global $productRelatedAttributesModel;
    //global $is_mobile;
    global $common_sample_product_arr;
    $is_mobile = isMobile();
    $product['href_link'] = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product['id'], 'NONSSL');
    //获取产品的关联属性
    $related_attributes_str =  $tag_html =  '';
    if($is_show_attributes){
        if(!$is_ajax){
            $cPath_array = $product['category_arr'];
            $cPath_array_str = implode('_',$cPath_array);
            define('PRODUCT_LIST_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_product_related_attribute_'.$cPath_array_str.'_'.$product['id'].'_for_list:');
            $related_attribute_redis_key = md5($product['id'].$_SESSION['countries_iso_code'],true);
            $related_attributes_array = get_redis_key_value($related_attribute_redis_key,PRODUCT_LIST_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
            if (!$related_attributes_array) {
                if (!$productRelatedAttributesModel) {
                    require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
                    $productRelatedAttributesModel = new productRelatedAttributesModel();
                }
                $related_attributes_array = $productRelatedAttributesModel->get_product_list_related_attribute($product['id'],$product['is_not_custom_str']);
                set_redis_key_value($related_attribute_redis_key,$related_attributes_array,24*3600,PRODUCT_LIST_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
            }

            if ($related_attributes_array) {
                $related_attributes_str = 'RELATED_ATTRIBUTES_STR'; //后面进行整理
                if(!$productRelatedAttributesModel){
                    require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
                    $productRelatedAttributesModel = new productRelatedAttributesModel();
                }
            }else{
                if($is_m_list && $is_mobile){
                    $related_attributes_str = '<div class="m-product-list-label"></div>';
                }else{
                    $related_attributes_str = '<div class="new_proList_ListSizes"><ul class="new_proList_ListSizes_list"></ul></div>';
                }
            }
        }else{
                if($is_m_list && $is_mobile){
                    $related_attributes_str = '<div class="m-product-list-label">SERVICE_ATTRIBUTES_DATA</div>';
                }else{
                    $related_attributes_str = '<div class="new_proList_ListSizes">SERVICE_ATTRIBUTES_DATA</div>';
                }
            }
    }

    // 如果不是异步，产品标题，如果存在公共标题，则显示公共标题
    if(!$is_ajax){
        $is_common_title = false;
        if($related_attributes_array){  //如果存在属性，且公共标题
            if(!$product['products_common_name']){
                $related_product_id = array_column($related_attributes_array['product_list'], 'product_id');
                if(sizeof($related_product_id)){
                    $product['products_common_name'] = fs_get_data_from_db_fields(
                        'products_common_name',
                        TABLE_PRODUCTS_DESCRIPTION,
                        ' products_id in ('.implode(',',$related_product_id).') and products_common_name <> ""',
                        ' LIMIT 1'
                    );
                }
            }
            if($product['products_common_name']){
                reset($related_attributes_array['product_list']); //  将数组的内部指针指向第一个单元
                $first_product = current($related_attributes_array['product_list']); // 得到第一个元素
                $attribute_val_str = $first_product['attribute_val_str'];
                foreach ($related_attributes_array['product_list'] as $related_value){
                    if($product['products_id'] == $related_value['product_id']){
                        $attribute_val_str = $related_value['attribute_val_str'];
                        break;
                    }
                }
                if($product['category_arr'][0] == 9){ //属性后面有compatible
                    if(in_array(61, $product['category_arr'])){
                        //光模块下的分类【61】只展示公共标题 需求见立项任务SQ20200428013
                        $product['products_name'] = $product['products_common_name'];
                    }else {
                        if ($_SESSION['languages_code'] == 'jp') {
                            $product['products_name'] = $product['products_common_name'] . '、' . $attribute_val_str . '' . FS_TITLE_COMPATIBLE_01;
                        } else {
                            $product['products_name'] = $product['products_common_name'] . ', ' . $attribute_val_str . ' ' . FS_TITLE_COMPATIBLE;
                        }
                    }
                }else{
                    // 属性在后
                    if ($_SESSION['languages_code'] == 'jp') {
                        $product['products_name'] = $product['products_common_name'].'、'.$attribute_val_str;
                    } else {
                        $product['products_name'] = $product['products_common_name'].', '.$attribute_val_str;
                    }
                }
                $is_common_title = true;
            }
        }
    }else{
        if($is_common_title){
            $product['products_name'] = 'SERVICE_TITLE_DATA';
        }
    }
    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
        $product['products_name'] = swap_american_to_britain($product['products_name']);
    }

    //库存信息
    //判断该产品产否是定制产品，若是定制产品默认不勾选属性不需展示库存
    //产品库存部分
    $shippingInfo = new shippingInfo(array('pid' => $product['id'], "current_category" => $product['category_arr'], "is_set_custome_tag" => $product['is_not_custom_str'],"productQty"=>$productQty));
    $shippingInfo->pure_price = $product['products_price_str'];

    //$products_instock_info = $shippingInfo->showIntockDate($product['is_not_custom_str'],1,$product['products_price_str']);
    //$products_instock_info = get_instock_info($product['id'],$product['is_not_custom_str'],false);

    //价格部分
    $products_price_info = '';
    $products_instock_info = "";
    if($product['is_inquiry'] != '1'){
        $products_instock_info = $shippingInfo->showIntockDate($product['is_not_custom_str'],1,$product['products_price_str']);
        // fairy 2019.2.21 add 组合产品主产品价格
        $is_composite_products = false;
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts(intval($product['id']));
            $composite_product_price = $CompositeProducts->get_composite_product_price();
            if(!empty($composite_product_price['composite_product_price'])){
                $is_composite_products = true;
            }
        }

        if ($is_composite_products) {
            $products_price_info = $composite_product_price['composite_product_price_str'];
            if($_SESSION['languages_code'] == 'jp' && $_SESSION['currency']!='JPY'){
                $jp_composite_product_price = $CompositeProducts->get_composite_product_price(false,'JPY');
                $products_price_info .= '/<i>'.'JPY&nbsp;'.$jp_composite_product_price['composite_product_price_str'].'</i>';
            } elseif (in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de') {
                $products_price_info = '<span class="de_price_text">'.$composite_product_price['composite_product_price_str'].FS_PRICE_EXCL_VAT.'</span><span class="de_tax_price_text">'.$currencies->total_format($composite_product_price['composite_product_price'] * 1.19).FS_PRICE_INCL_VAT.'</span>';
            }
        }else{
            //jp站货币是美元是需要展示出日元价格
            $jp_whole_price ='';
            //de de-en站 德国国家展示税费价格
            $de_tax_price ='';
            $products_price_info = $currencies->total_format($product['products_price_str']);
            if($_SESSION['languages_code'] == 'jp' && $_SESSION['currency']!='JPY'){
                if ($product['integer_state'] ==0) {
                    $jp_whole_price = '/<i>'.'JPY&nbsp;'.$currencies->new_format($product['products_price_str'],true,'JPY').'</i>';
                } else {
                    $jp_whole_price = '/<i>'.'JPY&nbsp;'.$currencies->format($product['products_price_str'],true,'JPY').'</i>';
                }
                $products_price_info .= $jp_whole_price;
            } elseif (in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de') {
                $products_price_info = '<span class="de_price_text">'.$products_price_info.FS_PRICE_EXCL_VAT.'</span><span class="de_tax_price_text">'.$currencies->total_format($product['products_price_str'] * 1.19).FS_PRICE_INCL_VAT.'</span>';
            }
        }
        if($product['is_not_custom_str']){
            $add_to_cart = FS_ADD_TO_CART;
        }else{
            //定制产品暂时也展示成add to cart
//            if(in_array($product['id'],['75874','75875','75877'])){
//                $add_to_cart = FS_ADD_TO_CART;
//            }else{
//                $add_to_cart = FS_CUSTOMIZED;
//            }
            $add_to_cart = FS_ADD_TO_CART;
        }
    }else{
        $products_price_info .= '';
        $add_to_cart = GET_A_QUOTE;
        if(in_array($product['id'],$common_sample_product_arr)){
            $add_to_cart = FS_GET_A_QUOTE_FREE;
        }
    }

    //产品数量增加部分
    if(in_array($product['id'],$common_sample_product_arr)){
        $min_qty = 1;
        $readonly_str = ' readonly="readonly" ';
    }else{
        $min_qty = $product['is_min_order_qty'] >= 1 ? $product['is_min_order_qty'] : '1';
        $readonly_str = '';
    }
    $cart_quantity_id_str = 'CART_QUANTITY_ID_STR';
    $products_number_info = '<div class="product_list_text"><span>
        <input type="text" '.$readonly_str.' id="'.$cart_quantity_id_str.$product['id'].'" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  min="1" onblur="q_check_min_qty(this,' . $product['id'] . ');" onfocus="q_enterKey(this,' . $product['id'] . ')" value="' . $min_qty . '"  autocomplete="off" class="p_07 product_list_qty"><div class="pro_mun">';
    if($product['id']==73321){
        $products_number_info .= '<a href="javascript:;" class="cart_qty_add"></a>
			<a href="javascript:;" class="cart_qty_reduce cart_reduce"></a>';
    }else {
        $products_number_info .= '<a href="javascript:void(list_cart_quantity_change(1,'.$product['id'].'));" class="cart_qty_add"></a>
			<a href="javascript:void(list_cart_quantity_change(0,'.$product['id'].'));" class="cart_qty_reduce cart_reduce"></a> ';
    }
    $products_number_info .= '</div></span></div>';

    //添加购物车按钮部分
    $current_type = 'CURRENT_TYPE';
    $products_btn_info = ' <div class="product_list_btn floatRz">';
    $add_to_cart = FS_ADD_TO_CART;
    $is_clearance = $product['products_clearance_price'] && $product['products_clearance_price'] > 0 ? 1 : 0;
    $cn_and_local_qty = $is_clearance == 1 ? $shippingInfo->getLocalAndWuhanqty() : 0;

    //按钮点击js
    $addFun = "ajax_get_one_product_qv_show(this)";
    if ($_SESSION['countries_iso_code'] == 'ru' && $is_composite_products && !in_array($product['id'],['108704','108706'])) {
        $product['is_inquiry'] = 1;
    }
    
   /* if($related_attributes_str != 'RELATED_ATTRIBUTES_STR' && !$is_ajax && $product['is_not_custom_str'] == true && $product['is_inquiry'] != '1'){
        $addFun = "commonProdAddtoCart(this,'new_list',0,".$is_clearance.",".$cn_and_local_qty.")";
    }*/

    if($shippingInfo->is_pre_product){
        $add_to_cart = FS_PRE_ORDER;
    }
    //购物车图标 <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>
    if ($product['is_not_custom_str']) {
        if ($product['is_inquiry'] != '1') {
            $products_btn_info .= '<button type="submit" data-product-id="'.$product['id'].'" onclick="'.$addFun.'" name="Add to Cart" value="'.$add_to_cart.'" class="new_pro_addCart_btn" placeholder="">
                                    <div class="new_pro_addCart_mainDev after">';
            $products_btn_info .= $is_mobile && $_SESSION['languages_id'] == 1?'Add':$add_to_cart;
            $products_btn_info .= '</div>';
            $products_btn_info .= '<div class="new_addCart_loading choosez">
                    <div class="new_chec_bg"></div>
                    <div class="loader_order">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                        </svg>
                    </div>
                </div>
            </button>';
        } else {
            $products_btn_info .= '<a class="button_02" target="_blank" href=' .$product['href_link'] . '>';
            $products_btn_info .= $is_mobile && $_SESSION['languages_id'] == 1?'Add':GET_A_QUOTE;
            $products_btn_info .='</a>';
        }
    } else {
        if ($product['is_inquiry'] != '1') {
            $products_btn_info .= '<a class="new_pro_custom_btn" target="_blank" href=' . $product['href_link'] . '>';
        }else{
            $products_btn_info .= '<a class="button_02" target="_blank" href=' . $product['href_link'] . '>';
        }
        $products_btn_info .= $is_mobile && $_SESSION['languages_id'] == 1?'Add':($product['is_inquiry'] == '1'?GET_A_QUOTE:$add_to_cart);
        $products_btn_info .='</a>';
    }
    $products_btn_info .= '</div>';


    $list_add_btn = !$product['is_not_custom_str'] && $product['is_inquiry'] == 1 ? GET_A_QUOTE : FS_ADD_TO_CART;
    //手机站不展示qv按钮
    $qv_btn_str = $is_mobile?'':'<div class="new_proList_QkviewBtn"><a href="javascript:;" name="Add to Cart"  onclick="'.$addFun.'" data-product-id="'. $product['id'].'"><div class="new_proList_QkviewBtnTa"><div class="new_proList_QkviewBtnTaCe icon iconfont">&#xf142;</div></div></a></div>';
    //列表页 产品应用标签
    $products_tag_html = $products_vice_tag_html = $vice_tag_html ='';
    //展示不含税注释
    $taxFr = '';
    if ($_SESSION['languages_code'] == 'fr') {
        if (in_array(strtolower($_SESSION['countries_iso_code']), ['fr', 'be', 'mc'])) {
            $taxFr = ' HT';
        }
    }
    if (in_array($_SESSION['languages_code'], array('uk', 'dn' , 'au', 'en'))){
        $session = 1;
    } else {
        $session = $_SESSION['languages_id'];
    }
    $tagInfo = $db->Execute("select tags, vice_tags from products_list_tags where products_id = ".$product['id']." and languages_id =" .$session);

    $pro_tags = $tagInfo->fields['tags']; //主标签
    $pro_vice_tags = $tagInfo->fields['vice_tags']; //副标签
    if ($pro_tags){ //主标签
        $p_tags = explode('#',$pro_tags);
        $p_tags = array_filter($p_tags); //去掉数组中的空元素
        if (sizeof($p_tags)) {
            foreach ($p_tags as $key => $p_tag){
                if ($p_tag != ''){
                    $p_tag = content_preg_mtp($p_tag,$product['category_arr'][0]);
                    $products_tag_html .= '<div class="new_proList_applyLable" maxlength="5" title="'.$p_tag.'">'.$p_tag.($key<(sizeof($p_tags) - 1) ? ' /' : '').'</div>';
                }
            }
        }
    }

    if($pro_vice_tags){ //副标签
        $p_vice_tags = explode('#',$pro_vice_tags);
        $p_vice_tags = array_filter($p_vice_tags); //去掉数组中的空元素
        if (sizeof($p_vice_tags)) {
            foreach ($p_vice_tags as $p_tag){
                if ($p_tag != ''){
                    $vice_tag_html .= '<div class="new_proList_applyLable bg" maxlength="5" title="'.$p_tag.'">'.$p_tag.'</div>';
                }
            }
            if ($vice_tag_html) {
                $products_vice_tag_html .= '<div class="new_proList_applyBox after">'.$vice_tag_html.'</div>';
            }
        }
    }

    //替换标签
    if (in_array(strtolower($_SESSION['countries_iso_code']), ['us', 'jp'])) {
        $product['products_name'] = str_replace('NEOCLEAN', 'NEOCLEAN®', $product['products_name']);
        $products_vice_tag_html = str_replace('NEOCLEAN™', 'NEOCLEAN®', $products_vice_tag_html);
    }

    //产品销量和评论板块HTML
    $sales_reviews_html = $reviews_html = $m_reviews_html = '';
    if(true){
        //产品总销量
        $product['total_sale'] = '';
        //$total_sale = get_products_sale_total_num($product['id'],$product['category_arr'][1]);
        //$product['total_sale'] = products_total_sales_show($total_sale+$product['offline_sales_num']);
        $product['product_sales_total_num'] = isset($product['product_sales_total_num']) ? intval($product['product_sales_total_num']) : 0;
        $product['offline_sales_num'] = isset($product['offline_sales_num']) ? intval($product['offline_sales_num']) : 0;
        $product['total_sale'] = products_total_sales_show($product['product_sales_total_num'] + $product['offline_sales_num']);

        $reviews_title = ($product['products_review_total']>1) ? FS_PRODUCTS_SALES_REVIEWS : FS_PRODUCTS_SALES_REVIEW;
        if(in_array($_SESSION['languages_code'],['fr','it']) && $product['total_sale']>1){
            $sales_sold = FS_PRODUCTS_SALES_SOLDS;
        }else{
            $sales_sold = FS_PRODUCTS_SALES_SOLD;
        }
        $sales_reviews_html = '<div class="new_sales_container">
                            <a href="'.$product['href_link'].'" target="_blank">
                                <span class="new_sales">'.(sprintf($sales_sold,'<em>'.$product['total_sale'].'</em>')).'</span>
                            </a>
                            <i class="new_sales_border"></i>
                            <a href="'.reset_url('products/'.(int)$product['id'].'.html#all_reviews').'" target="_blank">
                                <span class="new_reviews">'.(sprintf($reviews_title,'<em>'.$product['products_review_total'].'</em>')).'</span>
                            </a>
                        </div>';
    }else{
        $reviews_html = '<div class="new_proList_ListBstarBox">'.$product['products_review_str'].'</div>';
        $m_reviews_html = '<div class="m-product-star">'.$product['products_review_str'].'</div>';
    }

    //列表页 产品应用标签end
    $products_list_info = '';
    if($type=='list' || $type=='all'){
        if($related_attributes_str == 'RELATED_ATTRIBUTES_STR'){
            $related_attributes_str_list = $productRelatedAttributesModel->handle_product_list_related_attribute($related_attributes_array,$product['id'],'list',$product['category_arr']);
        }else{
            $related_attributes_str_list = $related_attributes_str;
        }

        $products_number_info_list = str_replace('CART_QUANTITY_ID_STR','img_quantity_',$products_number_info);
        $products_btn_info_list = str_replace('CURRENT_TYPE','new_list',$products_btn_info);

        // 视频部分
        $products_video_info = '';
        if($product['list_video']){
            $product_video = $product['list_video'];
            $product_video_title = $product['list_video_title'];
        }elseif($product['video']){
            $product_video = $product['video'];
            $product_video_title = $product['video_title'];
        }else{
            $product_video='';
            $product_video_title='';
        }
        if($product_video != ''){
            $video_explode = end(explode(".",$product_video));
            if($video_explode == "mp4"){
                $products_video_info = '<div class="video_play_btn">
                            <span class="video_play_ic"  onclick="my_video_play_01(this)" data-link="'.$product_video.'" data-title="'.$product_video_title.'"><div class="video_content_open_play"><span></span></div></span>
                        </div>';
            }else{
                $product_video = explode('"',$product_video);
                $products_video_info = '<div class="video_play_btn">
                            <span class="video_play_ic"  onclick="my_video_play(this)" data-title="'.$product_video_title.'" data-link="'.$product_video[0].'"><div class="video_content_open_play"><span></span></div></span>
                        </div>';
            }
        }

        if(!$is_ajax){
            $tag_html = get_new_or_custom_tag_html($product['is_new_tag'] ,$product['new_products_tag'],$product['product_custom_tag']); //标签
            $products_list_info .= '<li class="new_proList_mainListTli">'.$tag_html.'<div>';
        }
        $products_desc_str = get_products_short_desc($product['id'],$product['category_arr'],$product['first_product_id']);
        $products_list_info .= '
            <div class="new_proList_ListTleft">
				<div class="new_proList_ListImg">
					<a href="'.$product['href_link'].'" target="_blank">'.$product['image_str'].'</a>
						'.$products_video_info.'
				</div>
				'.$related_attributes_str_list.'				
			</div>
			
			<div class="new_proList_Array_colB">
			    <div class="new_proList_Array_col">
			        <h3><a href="' . $product['href_link'] . '" target="_blank" data-is-common-title="'.$is_common_title.'" title="'.$product['products_name'].'">' .$product['products_name'] . '</a><span>#'.$product['id'].'</span></h3>
			        ' . $products_vice_tag_html .$reviews_html. $products_desc_str.'
			    </div>
			    <div class="new_proList__array_form">
                    <div class="new_proList_ListBPrice" id="detailSid">
                        '.$products_price_info.$taxFr.'
                    </div>
                    <div class="new_proList_ListBtxt1">
                        '.$products_instock_info.'
                    </div>
                    '.$sales_reviews_html.'
                    <div class="video_array_formRight">
                        <div class="video_array_form">
                                '.$products_btn_info_list.'
                        </div>
                    </div>
                    '.$qv_btn_str.'
                </div>
			</div>';
        if(!$is_ajax){
            $products_list_info .= '</div></li>';
        }
    }

    $products_image_info = '';
    if($type=='image' || $type=='all'){
        if(!$is_ajax){
            if($is_m_list && $is_mobile){ //列表页且为m端
                $products_image_info .= '<li><div class="m-product-list-center-container">';
            }else{
                $products_image_info .= '<li class="new_proList_mainListLi"><div>';
            }
        }
        $tag_html = get_new_or_custom_tag_html($product['is_new_tag'] ,$product['new_products_tag'],$product['product_custom_tag']);
        $products_image_info .= $tag_html;

        $products_number_info_image = str_replace('CART_QUANTITY_ID_STR','img_quantity2_',$products_number_info);
        $products_btn_info_image = str_replace('CURRENT_TYPE','image',$products_btn_info);

        if($related_attributes_str == 'RELATED_ATTRIBUTES_STR'){
            $related_attributes_str_image = $productRelatedAttributesModel->handle_product_list_related_attribute($related_attributes_array,$product['id'],'image',$product['category_arr'],$is_m_list);
        }else{
            $related_attributes_str_image = $related_attributes_str;
        }

        // 视频部分
        $products_video_info = '';
        if($product['list_video']){
            $product_video = $product['list_video'];
            $product_video_title = $product['list_video_title'];
        }elseif($product['video']){
            $product_video = $product['video'];
            $product_video_title = $product['video_title'];
        }else{
            $product_video='';
            $product_video_title='';
        }
        if($product_video != ''){
            $video_explode = end(explode(".",$product_video));
            if($video_explode == "mp4"){
                $products_video_info = '<div class="video_play_btn">
                            <span class="video_play_ic"  onclick="my_video_play_01(this)" data-link="'.$product_video.'" data-title="'.$product_video_title.'"><div class="video_content_open_play"><span></span></div></span>
                        </div>';
            }else{
                $product_video = explode('"',$product_video);
                $products_video_info = '<div class="video_play_btn">
                            <span class="video_play_ic"  onclick="my_video_play(this)" data-title="'.$product_video_title.'" data-link="'.$product_video[0].'"><div class="video_content_open_play"><span></span></div></span>
                        </div>';
            }
        }

        if($is_m_list && $is_mobile){
            $products_btn_info_m_image = str_replace('CURRENT_TYPE','m_image',$products_btn_info);
            $products_image_info .= '
                            <div class="m-product-list-center-left">
                                  <div class="video">
                                    <a href="' . $product['href_link'] . '" target="_blank">
                                    ' . $product['image_str'] . '
                                    </a>
                                    ' .$products_video_info. '
                                 </div>
                                 '.$related_attributes_str_image.'
                            </div>
                            <div class="m-product-list-center-right">
                                <h2 class="m-product-list-tit">
                                     <a href="' . $product['href_link'] . '" target="_blank" data-is-common-title="'.$is_common_title.'" title="'.$product['products_name'].'">
                                     ' .$product['products_name'] . '
                                     </a>
                                </h2>';
                                $products_image_info .= '<div class="new_proList_applyBox_wrap">';
                                $products_image_info .= '<div class="new_proList_applyBox after first-col">' . $products_tag_html . '</div>';
                                $products_image_info .= $products_vice_tag_html;
                                $products_image_info .= '</div>';
                                $products_image_info .= '<p class="m-product-list-pic" id="imgSid">
                                    '.$products_price_info.$taxFr.'
                                </p>';
                                $products_image_info .= $m_reviews_html;
                                $products_image_info .= '<div class="m-product-list-stock">
                                    '.$products_instock_info.'
                                </div>
                                '.$sales_reviews_html.'
                                <div class="picture_array_from">
                                '.$products_number_info_image.$products_btn_info_m_image.'
                                </div>
                            </div>';
        }else{
                $products_image_info .= '
                <div class="new_proList_ListTop">
                    <div class="new_proList_ListImg">
                        <a href="'.$product['href_link'].'" target="_blank">' . $product['image_str'] . '</a>
                        '.$products_video_info.$qv_btn_str.'
                    </div>
                    '.$related_attributes_str_image.'
                </div>    
                <div class="new_proList_ListBottom">
                    <h3 class="new_proList_ListBlink"><a href="' . $product['href_link'] . '" target="_blank" data-is-common-title="'.$is_common_title.'" title="'.htmlspecialchars($product['products_name']).'">' .$product['products_name']. '</a></h3>';
                    $products_image_info .= '<div class="new_proList_applyBox_wrap">';
                    $products_image_info .= '<div class="new_proList_applyBox after first-col">' . $products_tag_html . '</div>';
                    $products_image_info .= $products_vice_tag_html;
                    $products_image_info .= '</div>';
                    $products_image_info .='<div class="new_proList_ListBPrice" id="imgSid">'.$products_price_info.$taxFr.'</div>                      
                            '.$reviews_html.'
                            <div class="new_proList_ListBtxt1">
                            '.$products_instock_info.'
                            </div>
                            '.$sales_reviews_html.'
                            <div class="picture_array_from">'
                        .$products_number_info_image.$products_btn_info_image.
                        '</div>
                        </div>';
        }
        if(!$is_ajax){
            $products_image_info .= '</div></li>';
        }
    }
    if($type=='image'){
        return $products_image_info;
    }elseif ($type=='list'){
        return $products_list_info;
    }elseif ($type=='all'){
        return array(
            'image' => $products_image_info,
            'list' => $products_list_info,
        );
    }
}

function dealItemSpotlights($item_spotlights) {
    if (empty($item_spotlights)) {
        return '';
    }
    $item_spotlights = str_replace('；', ';', $item_spotlights);
    $item_spotlights = stripslashes($item_spotlights);
    if (strpos($item_spotlights, ';') === false) {
        return false;
    }
    return $item_spotlights;
}

/**
 * @param $products_id //调取产品新短描述信息
 * @param array $categories_id //数组
 * @param int $type 2详情页
 * @return string
 */
function get_products_short_desc($products_id,$categories_id,$first_product='', $type =1){
    global $db;
    $product['id'] = $products_id;
    $product['category_arr'][1] = $categories_id[1];
    // 获取产品描述
    $product['products_info_array'] = array();
    //列表展示产品描述
    if($product['id']){
        $list_description = $db->getAll('SELECT warranty_and_returns,product_details,module1
        FROM  '.TABLE_PRODUCTS_DESCRIPTION.'
        where products_id  = '.$product['id'].' limit 1');
        $list_description = $list_description[0];
        $product['warranty_and_returns'] = swap_american_to_britain($list_description['warranty_and_returns']);
        $product['product_details'] = swap_american_to_britain($list_description['product_details']);
        $product['module1'] = swap_american_to_britain($list_description['module1']);
    }else{
        return $products_desc_str='';
    }
    $products_info_array = array();
    /*关联组的卖点信息展示规则微调 2019.07.30 added by Yoyo
     *关联组的当前产品有卖点信息 则展示当前卖点信息  若是没有 则看第一个产品是否有卖点信息 有则展示第一个产品的卖点信息
     * */
    $item_spotlights = dealItemSpotlights($product['warranty_and_returns']);
    if ($type == 2 && !$item_spotlights) {
        return '';
    }
    if(!$item_spotlights && $first_product){
        if($product['id'] != $first_product){
            //如果是ajax 查询第一个产品的卖点信息
            $qv_info_obj = $db->Execute('SELECT warranty_and_returns FROM  '.TABLE_PRODUCTS_DESCRIPTION.'
        WHERE products_id  = '.$first_product.' limit 1');
            if($qv_info_obj->RecordCount()){
                $item_spotlights = swap_american_to_britain($qv_info_obj->fields['warranty_and_returns']);
            }
        }
    }
    if($item_spotlights){
        $new_products_info_array = get_products_qv_info_arr($item_spotlights);
    }else{
        if($product['category_arr'][1]==573){ // 这个分类，优先调取产品详情页面的 Features and Applications
            $products_info_array = get_products_info_features_arr($product['module1']);
        }
        if(!$products_info_array){ // 调取产品详情页面的 Product Details
            $product['module_status'] = (strpos($product['product_details'],'<table')===false)?1:0;
            $products_info_array = get_products_info_details_arr($product['product_details'],$product['module_status']);
        }
        $i = 0;
        $new_products_info_array = array();
        if(!empty($products_info_array['list'])){
            foreach($products_info_array['list'] as $key => $val ) {
                $i++;
                if (in_array($product['category_arr'][1], array(889, 56, 57, 58))) { //第3-6排
                    if ($i < 5 || $i > 12) {

                        continue;
                    }
                } elseif (in_array($product['category_arr'][1], array(1113, 2688, 2757, 61))) { //第2-4排
                    if ($i < 3 || $i > 8) {
                        continue;
                    }
                } else { //第1-3排
                    if ($i > 6) {
                        continue;
                    }
                }
                $new_products_info_array[$key] = $val;
            }
        }
    }
    $product['products_info_array'] = $new_products_info_array;
    $products_desc_str = '';
    $products_info_array = $product['products_info_array'];
    if ($products_info_array) {
        $cc = 0;
        if ($type == 2) {
            $li_html = '';
            $hideLibox_html = '';
            $hideLibox_html .= '<div class="newDetail_spotlights_hideLiBox" style="display: none;">';
            foreach ($products_info_array as $key => $val) {
                $cc++;
                $val = trim($val);
                if ($val) {
                    $val = content_preg_mtp($val,$categories_id[0]);
                    if($cc < 6){
                        $li_html .= ' <div class="newDetail_spotlights_li">       
                            ' . $val . '
                        </div>';
                    } else {
                        $hideLibox_html .= ' <div class="newDetail_spotlights_li">       
                            ' . $val . '
                        </div>';
                    }
                }
            }
            $hideLibox_html .= '</div>';
            $products_desc_str .= $li_html.$hideLibox_html;
            if ($cc > 5) {
                $products_desc_str .= '<div class="newDetail_spotlights_more">
                        <div class="newDetail_spotlights_moreMain" id="item_spotlights_more" data-type="1" data-more="'. FS_COMMON_SEE_MORE .'" data-less="'. FS_COMMON_SEE_LESS .'">
                            <span>'.FS_COMMON_SEE_MORE.'</span><i class="iconfont icon">&#xf087;</i>
                        </div>
                    </div>';
            }
        } else {
            $products_desc_str .= '<div class="new_proList_Array_list">';
            foreach ($products_info_array as $key => $val) {
                $cc++;
                $val = trim($val);
                if ($val) {
                    if($cc < 5){
                        $val = content_preg_mtp($val,$categories_id[0]);
                        $products_desc_str .= '<div class="new_proList_Array_listLi">
                        <span class="new_proList_Array_circle"></span>
                        <div class="new_proList_Array_txt">' . $val . '</div>
                    </div>';
                    }
                }
            }
            $products_desc_str .= '</div>';
        }
    }
    return $products_desc_str;
}

/*
 * 获取产品列表的一个产品的展示
 * @para array $product: 一个产品的产品数组
 * @return string $show_str: 展示的html字符串
 * fairy 2018..11.7 add
 */
function get_product_qv_show_str($product)
{
    global $db;
    global $productRelatedAttributesModel;
    global $currencies;
    if (!$productRelatedAttributesModel) {
        require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
        $productRelatedAttributesModel = new productRelatedAttributesModel();
    }
    global $common_sample_product_arr;

    //处理数据
    $product['href_link'] = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product['id'], 'NONSSL');
    //处理产品名
    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
        $product['products_name'] = swap_american_to_britain( $product['products_name'] );
    }
    $show_str = '';
    $qv_img = get_resources_img($product['id'],120,120,'','','','',true);

    // 产品关联属性
    $related_attributes_str = '';
    //属性关联子集start
    // qv，如果有子集，先列出子集。
    // 获取当前产品的 显示在列表页面的关联属性 的父级别id
    $attributes_parent_id = $productRelatedAttributesModel->get_attributes_by_product_id($product['id'],'list');
    if($attributes_parent_id[0]['parent_id']){
        $relation_id = $attributes_parent_id[0]['parent_id'];
    }else{
        $relation_id = $attributes_parent_id[0]['relation_id'];
        //判断是否有子集
        $son_attribute_counts = $productRelatedAttributesModel->get_attribute_son_attribute_counts($relation_id);
        $relation_id = $son_attribute_counts?$relation_id:0;
    }

    //应产品需求不显示子集
    $relation_id = 0;

    if($relation_id){
        $son_products_list = $productRelatedAttributesModel->get_products_by_attribute_id($relation_id, true);
        if($son_products_list){
            $related_attributes_str .= '<div class="detail_transceiver_type"><dl><dt>P/N:</dt>';
            // 子集的显示is_show_list
            foreach ($son_products_list as $product_key => $product_val){
                $product_val['product_id'] = (int)$product_val['product_id'];
                $choosez_str = '';
                if ($product['id'] == $product_val['product_id']) {
                    $choosez_str = ' choosez ';
                }else{
                    $onclick_str = ' data-product-id="'.$product_val['product_id'].'" onclick="ajax_get_one_product_qv_show(this)" ';
                }
                //获取产品的模型
                $current_products = $db->getAll('select products_MFG_PART,products_model from products where products_id='.$product_val['product_id']);
                $related_attributes_str .= '<dd class="'.$choosez_str.'"><a href="javascript:;" '.$onclick_str.'>'.($current_products[0]['products_MFG_PART']?$current_products[0]['products_MFG_PART']:$current_products[0]['products_model']).'</a></dd>';
            }
            $related_attributes_str .= '</dl><div class="ccc"></div></div>';
        }
    }
    //属性关联子集end

    $cPath_array = $product['category_arr'];
    $cPath_array_str = implode('_',$cPath_array);
    define('PRODUCT_QV_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_product_related_attribute_'.$cPath_array_str.'_'.$product['id'].'_for_qv:');
    $related_attribute_redis_key = md5($product['id'].$_SESSION['countries_iso_code'],true);
    $related_attributes_array = get_redis_key_value($related_attribute_redis_key,PRODUCT_QV_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
    if (!$related_attributes_array) {
        $related_attributes_array = $productRelatedAttributesModel->get_product_detail_related_attribute($product['id'],'qv',$product['is_not_custom_str'],$product['category_arr']);
        $related_attributes_str .= '<!-- qv attribute not cache -->';
        set_redis_key_value($related_attribute_redis_key,$related_attributes_array,24*3600,PRODUCT_QV_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
    }

    if($related_attributes_array){
        if (!$productRelatedAttributesModel) {
            require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
            $productRelatedAttributesModel = new productRelatedAttributesModel();
        }
        $related_attributes_str .= $productRelatedAttributesModel->handle_product_detail_related_attribute($related_attributes_array,$product['id'],'qv',$cPath_array);
    }

    //装箱产品
    $packing_str = '';
    //装箱产品
    $packing_conditions = array(
        'discount' => $product['discount'],
        'packing_quantity' => $product['packing_quantity'],
        'products_price' => $product['products_price'],
        'packing_unit' => $product['packing_unit'],
        'is_pack' => ($product['discount_type'] == 1 && $product['discount'] > 0) ? 1 : 0,
    );
    if ($packing_conditions['is_pack']) {
        if ($_SESSION['member_level'] <= 1) {
            $onclick_way_str = 'pack_switch';
        } else {
            $onclick_way_str = 'pack_switch_enterprise';
        }
        $onclick_str = ' onclick="' . $onclick_way_str . '(this,' . $product['id'] . ',' . $product['packing_quantity'] . ')" ';
        $packing_str .= '
        <div class="detail_transceiver_type">
            <dl>
                <dt>' . FS_PRODUCT_INFO_SIZE . '</dt>
                <dd class="pro_item packing choosez" id="button_1" ' . $onclick_str . '>
                    <a href="javascript:;">' . FS_PRODUCT_INFO_PIECE . '</a>
                </dd>
                <dd class="pro_item packing" id="button_2" ' . $onclick_str . '>
                    <a href="javascript:;">' . $product['packing_quantity'] . (!empty($product['packing_unit']) ? FS_PRODUCT_INFO_PIS_1 . $product['packing_unit'] : FS_PRODUCT_INFO_PIS) . '</a>
                </dd>
            </dl>
        </div>';
    }

    //产品库存部分
    $instock_info_str = '';
    $shippingInfo = new shippingInfo(array('pid' => $product['id']));
    if($shippingInfo->is_pre_product){
        $instock_info_str =  "<div>".$shippingInfo->getPreOrderTemplate()."</div>";
    }else{
        if($product['is_inquiry'] != 1){
            $instock_info_str = $shippingInfo->get_warehouse_instock_qty('','','details');
        }
    }

    // 清仓原价展示
    $clearance_price_sql = $db->Execute('select replace_products,replace_products_tip, products_clearance_price from products_clearance where products_id ='.$product['id']);
    $clearance_price = $clearance_price_sql->fields['products_clearance_price'];
    $is_clearance = $clearance_price && $clearance_price > 0;
    $is_clearance = $is_clearance ? 1 : 0;
    $cn_and_local_qty = 0;
    $define_clearance = '';
    $choosez = '';
    $disabled = '';

    //清仓产品限制加购
    if($is_clearance==1){
        $cn_and_local_qty = $shippingInfo->getLocalAndWuhanqty();
        //$define_clearance .= $cn_and_local_qty ? QV_CLEARANCE_TIPS : QV_CLEARANCE_EMPTY_QTY_TIPS;

        //liang.zhu 2020.08.03
        //获取清仓产品的提示
        $products_clearance = $clearance_price_sql->fields;

        if ($products_clearance) {
            $products_clearance['replace_products'] = explode(';', $products_clearance['replace_products']);
            $products_clearance['replace_products'] = array_filter($products_clearance['replace_products']);
            if (count($products_clearance['replace_products'])) {
                $products_clearance_replace = current($products_clearance['replace_products']);
                //$products_clearance_replace = '<a style="color:#0070BC;" href="'.reset_url('/products/'.$products_clearance_replace.'.html').'" target="_blank">'.$products_clearance_replace.'</a>';
                //有替代产品
                if ($cn_and_local_qty > 0 ) {
                    $products_clearance_tip = FS_CLEARANCE_TIP_01_01.' '.FS_CLEARANCE_TIP_01_02;
                    $products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($cn_and_local_qty, $products_clearance_replace), $products_clearance_tip);
                } else {
                    $products_clearance_tip = FS_CLEARANCE_TIP_02_01.' '.FS_CLEARANCE_TIP_02_02;
                    $products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($cn_and_local_qty, $products_clearance_replace), $products_clearance_tip);
                }

            } else {
                //对于无替代或者不可定制产品
                if ($cn_and_local_qty > 0 ) {
                    $products_clearance_tip = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                    $products_clearance_tip = str_replace(array('$QTY'), array($cn_and_local_qty), $products_clearance_tip);
                } else {
                    $products_clearance_tip = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
                }
            }

        } else {
            //对于无替代或者不可定制产品
            if ($cn_and_local_qty > 0 ) {
                $products_clearance_tip = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                $products_clearance_tip = str_replace(array('$QTY'), array($cn_and_local_qty), $products_clearance_tip);
            } else {
                $products_clearance_tip = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
            }
        }
        $define_clearance = $products_clearance_tip;


        if($cn_and_local_qty<2){
            $choosez = ' choosez';
        }
        if($cn_and_local_qty==0){
            $disabled = ' disabled';// 清仓产品库存为0,数量输入框禁用
        }
    }

    if(!in_array($_SESSION['languages_code'],array('uk','au','jp','de','dn')) && strtolower($_SESSION['countries_iso_code']) !='ru'){
        //原价获取
        $product_list_content = '';
//        $is_inquiry_cle_sql = $db->Execute("select is_inquiry,products_status FROM products where products_id = ".$product['id']);
//        $is_inquiry_cle = $is_inquiry_cle_sql->fields['is_inquiry'];  在product数组中已经查询is_inquiry 不用再次查询
        $is_inquiry_cle = $product['is_inquiry'];
//        $wholesaleproducts = fs_get_wholesale_products_array();
        if($is_clearance==1){
            if ($is_inquiry_cle != '1') {
                $product_list_content .= '<strong class="old_price_z">';
                if ($product['integer_state'] !=1) {
                    $product_list_content .= $currencies->new_format($clearance_price);
                } else {
                    $product_list_content .= $currencies->format($clearance_price);
                }
                $product_list_content .= '<span class="old_price_line"></span></strong>';
            }
        }
    }

    //产品数量增加部分
    $products_number_info = '';
    if ($product['is_not_custom_str']) {
        if (in_array($product['id'],$common_sample_product_arr)) {
            $min_qty = 1;
            $readonly_str = ' readonly="readonly" ';
        } else {
            $min_qty = $product['is_min_order_qty'] >= 1 ? $product['is_min_order_qty'] : '1';
            $readonly_str = '';
        }
        $box_number = $packing_conditions['packing_quantity'] > 0 ? (int)$packing_conditions['packing_quantity'] : 0;
        $is_pack = ($packing_conditions['is_pack'] && $_SESSION['member_level'] <= 1) ? 1 : 0;
        $products_number_info_id = 'qv_quantity_' . $product['id'];

//        <span class="qtyTxt" '.(in_array($_SESSION['languages_code'],array('de','es','mx')) ? 'style="display:none"' : "").'>' . FS_COMMON_QTY_SMALL . ':</span>
        $products_number_info .= '
            <div class="newPro_common_num_cont product_03_08 product_03_24">';
        $products_number_info .= '<input type="text" ' . $readonly_str . ' id="' . $products_number_info_id . '" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  min="1" onfocus="q_enterKey(this,' . $product['id'] . ')" value="' . $min_qty . '"  autocomplete="off" class="p_07 product_03_10"  onblur="fslocking(' . $product['id'] . ',' . $product['is_min_order_qty'] . ',' . $box_number . ',' . $is_pack . ',' . $is_clearance . ',' . $cn_and_local_qty . ');" '.$disabled.'><div class="pro_mun">';
        if ($product['id'] == 73321) {
            $products_number_info .= '<a href="javascript:;" class="cart_qty_add"></a>
                <a href="javascript:;" class="cart_qty_reduce cart_reduce"></a>';
        } else {
            $products_number_info .= '<a href="javascript:;" onclick="common_cart_quantity_change(1,this,\'qv\',' . $product['id'] . ',' . $is_pack . ',' . $box_number . ',' . $is_clearance . ',' . $cn_and_local_qty . ')" class="cart_qty_add '.$choosez.'"></a>
                <a href="javascript:;" onclick="common_cart_quantity_change(0,this,\'qv\',' . $product['id'] . ',' . $is_pack . ',' . $box_number . ',' . $is_clearance . ',' . $cn_and_local_qty . ')" class="cart_qty_reduce cart_reduce '.($disabled ? $choosez : "").'"></a> ';
        }
        $products_number_info .= '</div></div>';
    }

    //价格部分
    $add_to_cart = FS_ADD_TO_CART;
    //添加到购物车按钮部分
    if ($product['is_inquiry'] != '1') {
        $products_price_info = get_product_detail_price_show_str($product['id'], $packing_conditions, $product['category_arr'],$product['products_price_str']);
        if ($product['is_not_custom_str']) {
            $add_to_cart = FS_ADD_TO_CART;
        } else {
            $add_to_cart = FS_ADD_TO_CART;

        }
        if($shippingInfo->is_pre_product){
            $add_to_cart = FS_PRE_ORDER;
        }
    }else{
        $products_price_info = '';
        $add_to_cart = GET_A_QUOTE;
        if (in_array($product['id'],$common_sample_product_arr)) {
            $add_to_cart = FS_GET_A_QUOTE_FREE;
        }
    }

    $products_btn_info = ' <div>';
    if ($product['is_not_custom_str']) {
        if ($product['is_inquiry'] != '1') {
            $products_btn_info .='<button type="submit" data-products-id="'.$product['id'].'" onclick="commonProdAddtoCart(this,\'qv\','.$box_number.','.$is_clearance.','.$cn_and_local_qty.')" name="Add to Cart" value="'.$add_to_cart.'" class="new_pro_addCart_btn" placeholder="">
                            <div class="new_pro_addCart_mainDev after">
                            <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>'.$add_to_cart.'
                            </div>
                            <div class="new_addCart_loading choosez">
                                <div class="new_chec_bg"></div>
                                <div class="loader_order">
                                    <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                    </svg>
                                </div>
                            </div>
                        </button>';
        } else {
            $products_btn_info .= '<a class="new_pro_custom_btn" href='.$product['href_link'].'>'.GET_A_QUOTE.'</a>';
        }
    } else {
        $products_btn_info .= '<a class="new_pro_custom_btn" href='.$product['href_link'] . '>'.$add_to_cart.'</a>';
    }
    $products_btn_info .= '</div>';

    //邮编，交期
    //$product_postcodes_str = '<div class="shipping_text">'.$shippingInfo->get_warehouse_shiping_policy($product['products_price_str']).'</div>';
    $product_postcodes_str='';
    if($product['is_inquiry'] != 1){
        $product_postcodes_str = '
        <div class="pro_postcode_system_box" id="pro_postcode_system"><div>'.$shippingInfo->showProductsListPost().'</div></div>
        <div class="shipping_text">'.$shippingInfo->get_warehouse_shiping_policy($product['products_price_str'],false,2).'</div>';
    }

    $show_str .= '
    <div class="qv_detail_clearBox">
        <div class="detail_proLeft">
            <div class="qv_detail_leftImg_box">
                <img src="'.$qv_img.'" width="100">
            </div>
        </div> 
        <div class="detail_proRight">
            <span class="new_pro_QVclose iconfont icon" onclick="hide_product_qv_show();">&#xf092;</span>
            <div class="detail_proDecribe_tit">
                <h1>'.$product['products_name'].'</h1><span>#'.$product['id'].'</span>
            </div>
            <div class="detail_proAssess_starNum">
                <div class="new_proList_ListBstarBox">
                    '.$product['products_review_str'].'
                </div>
                '.$products_price_info.$product_list_content.'
            </div>'
        .$related_attributes_str.$packing_str.
        '<div class="location_text">
            <div class="new_qvFull_txt">
                <a href="'.$product['href_link'].'" target="_blank">'.FS_SEE_FULL_DETAILS.'</a><span class="iconfont icon">&#xf089;</span>
            </div>
            <div class="product_03_01 product_03_13  detail_seattle_z">
                '.$instock_info_str.$product_postcodes_str.'
                
            </div>
        </div>
        <!--QV tips-->
        <div class="custom_product_tips_fa" style="display: none;">
                <p class="custom_product_tips" id="option_remark" style="display: inline-block;"><i class="iconfont icon">&#xf228;</i><span>'.$define_clearance.'</span></p>
                
        </div>
        </div>
    </div>
    <div class="qv_edition_eightAugust_btm">
        <div class="newDetail_addCart_box">'
        .$products_number_info.$products_btn_info.
        '</div>
    </div>';

    return $show_str;
}

/*
 * 获取 产品的描述 可视化数组
 * @para string $detail: 产品的详情
 * @para int $module_status: 是新版还是旧版，1新版，2旧版
 * @return array $show_str: 转换成可以使用的
 * fairy 2018.11.7 add
 */
function get_products_info_details_arr($detail,$module_status){
    $return_array = array();
    if($module_status ==1){
        $detail = str_replace("{", "{", $detail);
        $detail_sh = explode("{", $detail);
        $detail = $detail_sh[0];

        $detail = str_replace("；", ";", $detail);
        $detail = str_replace("：", ":", $detail);
        $detail_info = explode(";", $detail);

        //标题
        $details_p = explode(":", $detail_info[0]);
        if($details_p){
            $return_array['title'] = $detail_info[0];
        }
    }else{
        $product_details = compress_html($detail);
        $product_details =str_replace('</div>', '', $product_details);
        $product_details =str_replace('<div class="p_con_02">', '{', $product_details);
        $product_details_arr = explode('{',$product_details);
        $product_details = $product_details_arr[0];

        $product_details =str_replace('<table border="0" cellpadding="0" cellspacing="0" class="solu_table01" width="100%">', '', $product_details);
        $product_details =str_replace('</tr></tbody></table>', '', $product_details);
        $product_details =str_replace('<table border="0" cellpadding="0" cellspacing="0" class="solu_table01" width="100%">', '', $product_details);
        $product_details =str_replace('<table border="0"cellpadding="0"cellspacing="0"class="solu_table01"width="100%">', '', $product_details);
        $product_details =str_replace('<tbody>', '', $product_details);
        $product_details =str_replace('<tr>', '', $product_details);
        $product_details =str_replace('<td>', '', $product_details);
        $product_details =str_replace('<td >', '', $product_details);
        $product_details =str_replace('<td bgcolor="#f4f4f4">', '', $product_details);
        $product_details =str_replace('<b>', '', $product_details);
        $product_details =str_replace('</b>', '', $product_details);
        $product_details =str_replace('</td>', ' :', $product_details);
        $product_details =str_replace('</tr>', ' ; '."\n", $product_details);
        $product_details =str_replace('</tbody>', '', $product_details);
        $product_details =str_replace('</table>', '', $product_details);
        $product_details =str_replace(': :', '', $product_details);
        $product_details =str_replace(': ;', ' ; ', $product_details);
        $product_details = substr($product_details,0,strlen($product_details)-2);
        $detail_info = explode(' ;',$product_details);
    }
    if($detail_info){
        //属性 和 属性值
        for ($i = 0; $i < sizeof($detail_info); $i++) {
            if($module_status ==1 && $i==0){
                continue;
            }
            $item_arr = explode(":", $detail_info[$i]);
            $return_array['list'][] = $item_arr[0].': '.$item_arr[1];
            $return_array['list'][] = $item_arr[2].': '.$item_arr[3];
        }
    }

    return $return_array;
}

/*
 * 获取 产品qv描述 可视化数组
 * @para string $detail: 产品的qv描述 格式为2种。1、属性1:属性值1;属性2:属性值2;  2、短语1;短语2
 * @para int $module_status: 是新版还是旧版，1新版，2旧版
 * @return array $show_str: 转换成可以使用的
 * fairy 2018.11.7 add
 */
function get_products_qv_info_arr($detail){
    $return_array = array();
    $detail = str_replace("；", ";", $detail);
    $detail = str_replace("：", ":", $detail);
    $detail_info = explode(";", $detail);
    if($detail_info){
        //属性 和 属性值
        for ($i = 0; $i < sizeof($detail_info); $i++) {
            if($detail_info[$i]){
                if(strpos($detail_info[$i],':')===false){ //属性形式
                    $return_array[$i] = $detail_info[$i];
                }else{ //短语形式
                    $item_arr = explode(":", $detail_info[$i]);
                    $return_array[$i] = $item_arr[0].': '.$item_arr[1];
                }
            }
        }
    }
    return $return_array;
}

/*
 * 获取 产品的特征详情 可视化数组
 * @para string $detail: 产品的详情
 * @para int $module_status: 是新版还是旧版，1新版，2旧版
 * @return array $show_str: 转换成可以使用的
 * fairy 2018.11.7 add
 */
function get_products_info_features_arr($detail){
    $return_array = array();

    $description = explode(";",$detail) ;

    if(!strpos($description[0],".jpeg") && !strpos($description[0],".jpg") && !strpos($description[0],".png") && !strpos($description[0],".gif")){   /* 第一段没有图片,则为标题 */
        $return_array['title'] = $description[0];
    }
    for($dt=1;$dt<sizeof($description);$dt++){
        if(!strpos($description[$dt],".jpeg") &&  !strpos($description[$dt],".jpg") && !strpos($description[$dt],".png") && !strpos($description[$dt],".gif")){   /* 第三段没有图片,则为标题+说明+说明 */
            $return_array['list'][] = str_replace('• ','',$description[$dt]);
        }
    }
    return $return_array;
}

/*
 * 获取产品的推荐产品展示
 * @para int $products_id: 产品id
 * @return string $show_str: 展示的html字符串
 * fairy 2018.11.7 add
 */
function get_one_product_recommend_products_data($products_id){
    global $currencies;
    $html = '';
    $two_fields = array('stock_list', 'products_name');
    $country_code_iso = strtolower($_SESSION['countries_iso_code']);
    $match_products = fs_get_data_from_db_fields_array($two_fields, TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . $products_id . ' and language_id=' . $_SESSION['languages_id'], '');
    if ($match_products[0][0]) {
        $stock_list = $match_products[0][0];
        $stock_list = str_replace("；", ";", $stock_list);
        $stock_list = str_replace("：", ":", $stock_list);
        $is_stock = strpos($stock_list, '##');
        if (!$is_stock) {
            $stock_list = trim($stock_list, ';');
            $stock_arr = explode(';', $stock_list);
            if (sizeof($stock_arr) > 12) {
                $stock_arr = array_slice($stock_arr, 0, 12);
            }
            $html .= '<div class="addCart_also_bought">
				<p class="also_bought">' . FS_CUSTOMER_ALSO_VIEWED . '</p>
				<div class="addCart_bought_carousel">';

            //var_dump($stock_arr);
            if(count($stock_arr)>4){
                $html .= '<div class="iconfont addCart_alert_pre">&#xf090;</div>
                    <div class="iconfont addCart_alert_next">&#xf089;</div>';
            }

            $html .='<div class="addCart_bought_carousel_box">
					<ul class="addCart_bought_carousel_list bought_carousel">';
            foreach ($stock_arr as $k => $v) {
                $sub_stock_arr = explode(':', $v);
                if (strpos($sub_stock_arr[0], "#") !== false) {
                    $sub_stock_v = explode('#', $sub_stock_arr[0]);
                    $sub_stock_vv = trim($sub_stock_v[1]);
                } else {
                    $sub_stock_vv = trim($sub_stock_arr[0]);
                }

                if (is_numeric($sub_stock_vv)) {
                    //产品库存状态(分类页弹窗)
                    $stock = get_instock_for_index($sub_stock_vv,true);
                    $mat_info = fs_get_data_from_db_fields_array(array('products_image','products_price','integer_state'), 'products', 'products_id=' . (int)$sub_stock_vv, '');
                    $mat_img = $mat_info[0][0];
                    $products_price = $mat_info[0][1];
                    $integer_state = $mat_info[0][2];

                    $mat_src = file_exists(DIR_WS_IMAGES . $mat_img) ? $mat_img : 'no_picture.gif';
                    $img = get_resources_img((int)$sub_stock_vv, 150, 150, $mat_src);
                    $products_price = zen_get_new_products_final_price((int)$sub_stock_vv,$products_price,$integer_state,$country_code_iso);
                    $products_price = $currencies->total_format($products_price);
                    $html .= '<li>
								<div>
									<a href="' . zen_href_link('product_info', 'products_id=' . (int)$sub_stock_vv, 'SSL') . '">' . $img . '</a>
								</div>
								<a class="addCart_pro_link" title="' . fs_get_data_from_db_fields('products_name', TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . (int)$sub_stock_vv . ' and language_id=' . $_SESSION['languages_id'], '') . '" href="'.zen_href_link('product_info','products_id='.(int)$sub_stock_vv,'SSL').'">' . fs_get_data_from_db_fields('products_name', TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . (int)$sub_stock_vv . ' and language_id=' . $_SESSION['languages_id'], '') . '</a>
								<p>' . $products_price . '</p>
								<div class="qv_stock">' . $stock . '</div>
							</li>';
                }
            }
            $html .= '</ul></div></div></div>';
        }
    }
    return $html;
}

/*
 * 获取产品详情页面的价格展示
 * @para int $products_id: 产品id
 * @para array $cPath_array: 产品的分类数组
 * @return string $show_str: 展示的html字符串
 * fairy 2018.11.7 add
 */
function get_product_detail_price_show_str($products_id,$packing_conditions,$cPath_array='',$price=0){
    global $currencies;
    global $Is_NewLand;
    $products_id = (int)$products_id;
    $get_cart_quantity = 0;
    $price_show_str = '';

    /* products price show start */
    $price_show_str .= '<div class="detail_proPrice" id="productsbaseprice">';
    //$wholesale_products查找的是products表中integer_state=1的所有产品 该查询可优化为直接查找当前产品的integer_state 2020.05.26 ery
    //$wholesale_products = fs_get_wholesale_products_array();
    if ($get_cart_quantity) { //这里的代码没有用了
        if (!in_array($products_id, $wholesale_products)) {
            $product_price = $currencies->new_display_price(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty($products_id, (int)$get_cart_quantity)), 0);
            $price_show_str .= $product_price;
        } else {
            $product_price = $currencies->display_price(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty($products_id, (int)$get_cart_quantity)), 0);
            $price_show_str .= $product_price;
        }
    } else {
        //代码优化，避免多次查询products表
        //获取产品的原始价格products表中的products_price的值
        //$pure_price = zen_get_products_base_price($products_id);
        //返回当前产品取整或不取整后的美元价格
        $product_price = zen_get_products_final_price($products_id);
        //生成的对应币种的带货币符号的价格
        $priceText = $currencies->total_format($product_price);
        $priceHtml = $taxPriceText = '';

//        $priceData = getAfterVatPrice($product_price,$priceText,$products_id);
//        $priceHtml .= $priceData['totalPrice'] . $priceData['taxPrice'];

        if(get_price_vat_uk_show()){
            $Excl_vat =' (Excl. VAT)';
            if(german_warehouse("country_code",$_SESSION['countries_iso_code'])){
                $taxPriceText = $currencies->total_format($product_price*1.20);
                //德国仓展示税收
                $taxPriceHtml = '<br/><i class="price_bef_tax">'.$taxPriceText.' (Incl. VAT)</i>';
                $priceHtml .= $priceText.$Excl_vat.$taxPriceHtml;
            }
        }elseif($_SESSION['languages_code']=='au'){
            //澳大利亚税后价展示
            $priceHtml .= $priceText . ($Is_NewLand ? '' : ' (Incl. GST)');
        }elseif($_SESSION['languages_code'] == 'jp'){
            $jp_price = '';
            if($_SESSION['currency']!='JPY'){
                //jp站货币是美元是需要展示出日元价格
                $jp_product_price = zen_get_products_final_price((int)$products_id,'JPY');
                $jp_price ='<em>/'.'JPY&nbsp;'.$currencies->total_format($jp_product_price, true,"JPY",'').'</em>';
            }
            $priceHtml .= $priceText.$jp_price;
        }elseif(in_array($_SESSION['languages_code'],['de','dn','it'])){
            //de站和de-en站的价格展示
            $priceHtml .= $priceText;
            if(german_warehouse("country_code",$_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))
            ){
                //欧盟国家才展示是否含税信息
                $priceHtml .= FS_PRICE_EXCL_VAT;
                // 2019-7-11 14:42:29   potato 摩纳哥的税率为20%
                $taxRate = getVaxByCountry($_SESSION['countries_iso_code']);
                $taxPriceText = $currencies->total_format($product_price * $taxRate);
                //德国仓展示税收
                $priceHtml .= '<br/><i class="price_bef_tax">'.$taxPriceText. FS_PRICE_INCL_VAT . '</i>';
            }
        }elseif ($_SESSION['languages_code'] == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))) {
            if (in_array(strtolower($_SESSION['countries_iso_code']), ['fr', 'be', 'mc', 'lu'])) {
                $priceText = $priceText.' HT';
            }
            $current_vat = get_current_vat_by_languages_code();
            $taxPriceText = $currencies->total_format($product_price * (1 + $current_vat[2]));
            $taxPriceHtml = '<br/><i class="price_bef_tax">'.$taxPriceText.' TTC</i>';
            $priceHtml .= $priceText.$taxPriceHtml;

        }elseif(strtolower($_SESSION['countries_iso_code'])=='sg'){
            //国家是新加坡展示税收价格
            $Excl_tax =' (Excl. GST)';
            $taxPriceText = $currencies->total_format($product_price * 1.07);
            $taxPriceHtml = '<br/><i class="price_bef_tax">'.$taxPriceText.' (Incl. GST)</i>';

            $priceHtml .= $priceText.$Excl_tax.$taxPriceHtml;
        }else{
            $priceHtml .= $priceText;
        }
        $price_show_str .= $priceHtml;
    }
    /* products price show end  装箱专题链接 已找ternence确认功能已下线，因此屏蔽代码   add by rebirth 2019/08/26*/

//    $discountPrice = get_discount_product_qty($products_id);
//    if ((int)$discountPrice > 0) {
//        $price_show_str .= '<div class="p_product_details"> <a href="' . zen_href_link('gx_news_fhd', '&type=' . get_oders($products_id) . '') . '" target="_blank"><em>' . $currencies->display_price($discountPrice, 0) . '</em>' . FS_PRODUCTS_TRAN . '</a></div>';
//    }
    if (3001 == $cPath_array[3]) {
        $price_show_str .= '<span class="product_info_per_meter" id="products_base_price_per_meter"> ( ' . FS_PRODUCTS_PER_METER . ' ) </span>';
    }
    if ('34747' == $products_id || '34760' == $products_id || '34778' == $products_id) {
        $price_show_str .= fs_product_custom_html_forID(FS_PRODUCTS_PRICE_JUST);
    } elseif ('17346' == $products_id) {
        $price_show_str .= fs_product_custom_html_forID(FS_PRODUCTS_UNIT_PRICE);
    } elseif (in_array($products_id, array(34946, 34849, 34947))) {
        $p_des = FS_PRODUCTS_PRICE_OF . zen_get_products_model($products_id) . ', ' . FS_PRODUCTS_NO_INCLUDEING;
        $price_show_str .= fs_product_custom_html_forID($p_des);
    }

    $price_show_str .= '<div class="ccc"></div></div>';

    // 装箱节省多少钱
    $price_show_str .= '<div class="fs_pro_Prodiscount_box" style="display:none">';
    //俄罗斯国家需要展示税后价格
    if($_SESSION['languages_code']=='en' && $packing_conditions['discount'] && strtolower($_SESSION['countries_iso_code']) !='ru') {
        $price_currency = str_replace($currencies->currencies[$_SESSION['currency']]['symbol_left'], '', $product_price);
        $price_currency = str_replace($currencies->currencies[$_SESSION['currency']]['symbol_right'], '', $price_currency);
        $price_currency = $currencies->currencies[$_SESSION['currency']]['symbol_left'] . sprintf('%.2f', $price_currency * (1 - $packing_conditions['discount'])) . $currencies->currencies[$_SESSION['currency']]['symbol_right'];
        $price_show_str .= '<div class="fs_clh_Prodiscount_new">Save '.$price_currency.'</div>';
    }
    $price_show_str .= '</div>';

    return $price_show_str;
}

//订单超时时间戳
function changeOrderRestoreTime($order){
    return false;
    global $db;
    $status = $order['orders_status_id'];
    if($status!=1){
        return false;
    }
    $payment_method = strtolower($order['payment_module_code']);
    $main_order_id = fs_get_data_from_db_fields('main_order_id','orders','orders_id='.$order['orders_id'],'limit 1');
    //主单或者整单执行
    if(in_array($main_order_id,array(0,1))){
    $payment_module_code = $db->getAll("select date_added from orders_payment_history where orders_id = ".$order['orders_id']." order by date_added desc limit 1");
    $is_instock = $db->getAll("select is_instock from orders where orders_id = ".$order['orders_id']." limit 1");
    $date_purchased  = strtotime($order['date_purchased']);
    if($is_instock[0]['is_instock']!=1) {
        if ($payment_module_code) {
            //线上8小时误差，测试站16小时
            $date_purchased = strtotime($payment_module_code[0]['date_added']) - 8 * 3600;
        }
        $filling_money = array();
        $origin_order_number = fs_get_data_from_db_fields('orders_number', 'orders', 'orders_id = ' . $order['orders_id'], '');
        if (!empty($origin_order_number)) {
            if (strpos($origin_order_number, "-") !== false) {
                $origin_order_number = explode("-", $origin_order_number);
                $origin_order_number = $origin_order_number[0];
            }
            $filling_money = $db->getAll("select add_time,payment from payment_link where order_id = " . $order['orders_id'] . " or order_num = '" . $origin_order_number . "' order by add_time desc limit 1");
        } else {
            $filling_money = $db->getAll("select add_time,payment from payment_link where order_id = " . $order['orders_id'] . " order by add_time desc limit 1");
        }

        if ($filling_money[0]['payment']) {
            if ($_GET['main_page'] != "account_history_info") {
                $payment_method = strtolower($filling_money[0]['payment']);
            } else {
                return false;
            }
        }
        $create_time = $db->getAll("select create_time from create_order_to_customer where orders_id = " . $order['orders_id']);
        $time_remaining = 0;
        if ($status == 1) {
            if (in_array($payment_method, array("paypal", "payeezy", "globalcollect", 'ideal', 'sofort', 'enets', 'yandex', 'globalcoll'))) {

                if (!strtotime($filling_money[0]['add_time'])) {
                    //信用卡
                    if (!$create_time && $payment_method != "ideal" && $payment_method != "sofort") {
                        $time = time() - 30 * 60;
                    } else {
                        //帮客户下单或者指定付款方式
                        $time = strtotime('-2 day');
                    }
                } else {
                    //补款方式
                    $date_purchased = strtotime($filling_money[0]['add_time']) - 8 * 3600;
                    $time = strtotime('-2 day');
                }
                if ($date_purchased > $time) {
                    $time_remaining = $date_purchased - $time;
                }
            } elseif (in_array($payment_method, array("hsbc", "echeck", 'hsbc order'))) {
                //账期
                $time = strtotime('-7 day');
                if ($payment_method == 'echeck') {
                    $echeck_result = fs_get_data_from_db_fields('id', 'fs_electrical_check_apply', 'orders_id =' . $order['orders_id'] . '', 'limit 1');
                    if ($echeck_result) {
                        return false;
                    }
                }
                if ($filling_money[0]['add_time']) {
                    $date_purchased = strtotime($filling_money[0]['add_time']) - 8 * 3600;
                }
                if ($date_purchased > $time) {
                    $time_remaining = $date_purchased - $time;
                }
            } elseif ($payment_method == "purchase") {
                //PO
                $time = strtotime('-7 day');
                if ($filling_money[0]['add_time']) {
                    $date_purchased = strtotime($filling_money[0]['add_time']) - 8 * 3600;
                }
                if ($date_purchased > $time) {
                    $time_remaining = $date_purchased - $time;
                }
            } else {
                //其它付款方式
                $time = strtotime('-7 day');
                if ($filling_money[0]['add_time']) {
                    $date_purchased = strtotime($filling_money[0]['add_time']) - 8 * 3600;
                }
                if ($date_purchased > $time) {
                    $time_remaining = $date_purchased - $time;
                }
            }
            return $time_remaining;
        }
    }
    }
    return false;
}
//订单状态修改为取消状态
function changeOrderRestore($order){
    return false;
    global $db;
    $status = strtolower($order['orders_status_id']);
    if($status!=1){
        return false;
    }
    $payment_method = $order['payment_module_code'];
    $is_instock = $db->getAll("select is_instock from orders where orders_id = ".$order['orders_id']." limit 1");
    $payment_module_code = $db->getAll("select date_added from orders_payment_history where orders_id = ".$order['orders_id']." order by date_added desc limit 1");
    if($is_instock[0]['is_instock']!=1){
        $date_purchased  = strtotime($order['date_purchased']);
        $main_order_id = fs_get_data_from_db_fields('main_order_id','orders','orders_id='.$order['orders_id'],'limit 1');
        //主单或者整单执行
        if(in_array($main_order_id,array(0,1))){
        if(count($payment_module_code)==1){
            //线上8小时误差，测试站16小时
            $date_purchased =strtotime($payment_module_code[0]['date_added'])-8*3600;
        }
        $filling_money=array();
        $origin_order_number = fs_get_data_from_db_fields('orders_number', 'orders', 'orders_id = ' . $order['orders_id'], '');
        if (!empty($origin_order_number)) {
            if (strpos($origin_order_number, "-") !== false) {
                $origin_order_number = explode("-", $origin_order_number);
                $origin_order_number = $origin_order_number[0];
            }
            $filling_money = $db->getAll("select add_time,payment from payment_link where order_id = " . $order['orders_id'] . " or order_num = '" . $origin_order_number . "' order by add_time desc limit 1");
        }else{
            $filling_money = $db->getAll("select add_time,payment from payment_link where order_id = " . $order['orders_id'] . " order by add_time desc limit 1");
        }

        if($filling_money[0]['payment']){
            if($_GET['main_page']!="account_history_info"){
                $payment_method = strtolower($filling_money[0]['payment']);
            }else{
                return false;
            }
        }
        $create_time=array();

            $create_time = $db->getAll("select create_time from create_order_to_customer where orders_id = ".$order['orders_id']);

        if($status == 1){
            if(in_array($payment_method,array("paypal","payeezy","globalcollect",'ideal','sofort','enets','yandex','globalcoll'))){
                //信用卡

                if(!$filling_money[0]['add_time']){
                    if(!$create_time && $payment_method!="iDEAL" && $payment_method!="SOFORT"){

                        $time=time()-30*60;
                    }else{
                        //帮客户下单或者指定付款方式
                        $time=strtotime('-2 day');
                    }
                }else{
                    //补款方式
                    $date_purchased = strtotime($filling_money[0]['add_time'])-8*3600;
                    $time=strtotime('-2 day');
                }
                if($date_purchased<$time){
                    if(in_array($main_order_id,array(0,1))){
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$order['orders_id']." or main_order_id =".$order['orders_id']);
                    }else{
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$main_order_id." or main_order_id =".$main_order_id);
                    }
                    $db->Execute("DELETE FROM products_instock_orders WHERE orders_id = ".$order['orders_id']."");
                    $sql_data_array = array('orders_id' => $order['orders_id'],
                        'orders_status_id' => 5,
                        'date_added' => 'now()',
                        'customer_notified' =>"",
                        'comments' => "订单超时");
                    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                    return 1;

                }
            }elseif (in_array($payment_method,array("hsbc","echeck",'hsbc order'))){
                //账期
                $time=strtotime('-7 day');
                if($payment_method=='echeck'){
                    $echeck_result = fs_get_data_from_db_fields('id', 'fs_electrical_check_apply', 'orders_id =' . $order['orders_id'] . '', 'limit 1');
                    if($echeck_result){
                        return false;
                    }
                }
                if($filling_money[0]['add_time']){
                    $date_purchased = strtotime($filling_money[0]['add_time'])-8*3600;
                }
                if($date_purchased<$time){
                    if(in_array($main_order_id,array(0,1))){
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$order['orders_id']." or main_order_id =".$order['orders_id']);
                    }else{
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$main_order_id." or main_order_id =".$main_order_id);
                    }
                    $db->Execute("DELETE FROM products_instock_orders WHERE orders_id = ".$order['orders_id']."");
                    $sql_data_array = array('orders_id' => $order['orders_id'],
                        'orders_status_id' => 5,
                        'date_added' => 'now()',
                        'customer_notified' =>"",
                        'comments' => "订单超时");
                    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                    return 1;
                }

            }elseif ($payment_method == "purchase"){
                //PO
                $time=strtotime('-7 day');
                if($filling_money[0]['add_time']){
                    $date_purchased = strtotime($filling_money[0]['add_time'])-8*3600;
                }
                if($date_purchased<$time){
                    if(in_array($main_order_id,array(0,1))){
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$order['orders_id']." or main_order_id =".$order['orders_id']);
                    }else{
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$main_order_id." or main_order_id =".$main_order_id);
                    }
                    $db->Execute("DELETE FROM products_instock_orders WHERE orders_id = ".$order['orders_id']."");
                    $sql_data_array = array('orders_id' => $order['orders_id'],
                        'orders_status_id' => 5,
                        'date_added' => 'now()',
                        'customer_notified' =>"",
                        'comments' => "订单超时");
                    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                    return 1;
                }
            }else{
                $time=strtotime('-7 day');
                if($filling_money[0]['add_time']){
                    $date_purchased = strtotime($filling_money[0]['add_time'])-8*3600;
                }
                if($date_purchased<$time){
                    if(in_array($main_order_id,array(0,1))){
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$order['orders_id']." or main_order_id =".$order['orders_id']);
                    }else{
                        $db->getAll("update ".TABLE_ORDERS." set orders_status = 5 where orders_id =".$main_order_id." or main_order_id =".$main_order_id);
                    }
                    $db->Execute("DELETE FROM products_instock_orders WHERE orders_id = ".$order['orders_id']."");
                    $sql_data_array = array('orders_id' => $order['orders_id'],
                        'orders_status_id' => 5,
                        'date_added' => 'now()',
                        'customer_notified' =>"",
                        'comments' => "订单超时");
                    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                    return 1;
                }
            }
        }
    }
    }
    return false;
}
//订单支付方式提示语
function changeOrderRestoreType($order_id,$payment_method){
    global $db;
    $create_time = $db->getAll("select create_time from create_order_to_customer where orders_id = " . $order_id ."");
    $filling_money=array();
    $origin_order_number = fs_get_data_from_db_fields('orders_number', 'orders', 'orders_id = ' . $order_id, '');
    if (!empty($origin_order_number)) {
        if (strpos($origin_order_number, "-") !== false) {
            $origin_order_number = explode("-", $origin_order_number);
            $origin_order_number = $origin_order_number[0];
        }
        $filling_money = $db->getAll("select add_time,payment from payment_link where order_id = " . $order_id . " or order_num = '" . $origin_order_number . "' order by add_time desc limit 1");
    }else{
        $filling_money = $db->getAll("select add_time,payment from payment_link where order_id = " . $order_id . " order by add_time desc limit 1");
    }

    if($filling_money[0]['payment']){
        if($_GET['main_page']!="account_history_info"){
            $payment_method = strtolower($filling_money[0]['payment']);
        }else{
            return false;
        }
    }
    if(in_array($payment_method,array("paypal","payeezy","globalcollect",'ideal','sofort','enets','yandex','globalcoll'))){
        //信用卡
        if(!$filling_money[0]['add_time']){
            if(!$create_time && $payment_method!="iDEAL" && $payment_method!="SOFORT"){
                //帮客户下单或者指定付款方式
                return MANAGE_ORDER_RESTORE_3;
            }else{
                return MANAGE_ORDER_RESTORE_6;
            }
        }else{
            return MANAGE_ORDER_RESTORE_6;
        }

    }elseif (in_array($payment_method,array("hsbc","echeck",'hsbc order'))){
        //账期
        if($payment_method=='echeck'){
            $echeck_result = fs_get_data_from_db_fields('id', 'fs_electrical_check_apply', 'orders_id =' . $order_id . '', 'limit 1');
            if($echeck_result){
                return false;
            }
        }
        return MANAGE_ORDER_RESTORE_7;

    } elseif ($payment_method == "purchase") {
        //PO
        return MANAGE_ORDER_RESTORE_5;
    }else{
        return MANAGE_ORDER_RESTORE_7;
    }
}

    //查询产品ID所在分类是否已关闭
    function get_product_category_status($products_id){
        global $db;
        if(is_numeric($products_id)){
            $sqlCache = sqlCacheType();
            $products_categories = $db->getAll("select {$sqlCache} show_type from " . TABLE_PRODUCTS . " where products_id=".$products_id." limit 1");
            if($products_categories[0]['show_type']==1){
                return 1;
            }else{
                return false;
            }
        }
    }



/*
 * 产品反运单号后台获取总订单表id
 * */
function get_order_products_instock_id($orders_id,$product_id=0){
    global $db;
    if($orders_id && in_array($product_id,array(75874,75876,75875,75877))) {
        //上线必备条件
        $products_instock_id = $db->getAll("SELECT products_instock_id  FROM products_instock_shipping WHERE orders_id=" . $orders_id . " and shipping_number != ''");
        if ($products_instock_id[0]['products_instock_id']) {
            $activation_code_key = $db->getAll("select license_key,updated_at from cumulus_license_key where related_id =" . $products_instock_id[0]['products_instock_id'] . " and products_id =".$product_id." order by updated_at desc");
            if (!$activation_code_key) {
                return $products_instock_id[0]['products_instock_id'];
            }else{
                return $activation_code_key;
            }
        }
    }
    //线下
    if($product_id==1 && $orders_id){
        $activation_code_key = $db->getAll("select license_key from cumulus_license_key where related_id =" . $orders_id . "");
        if ($activation_code_key) {
            return 1;
        }
    }
}

function zen_get_order_product_type($orders_id){
    global $db;
    if($orders_id){
        $products_id  = $db->getAll("select products_id from orders_products where products_id in(75874,75876,75875,75877) and orders_id=" . $orders_id . "");
        if($products_id[0]['products_id']){
            return 1;
        }
    }
}

function get_customer_subscribe_type($customers_id){
    global $db;
    $customer = $db->getAll("select customers_newsletter from customers where customers_id = ".$customers_id." limit 1");
    if($customer[0]['customers_newsletter']==0){
        return 1;
    }
}


/** dylan 2019.7.26 Add 详情页installation属性
 *
 * @param $products_match_tips 产品搭配产品提示语
 * @return string
 */
function get_product_info_installation_html($products_match_tips = ''){
//处理products_description表中的products_match_tips字段
    $other_html = '';
    if (!empty($products_match_tips)) {
        $other_html .= '<style>.title_message{color:#0070BC;}</style>';
        $products_match_tips = explode('{', $products_match_tips);
        $other_html .= '<div class="product_install_tip_container">';
        foreach ($products_match_tips as $key => $products_match_tip) {
            $products_match_tip = trim($products_match_tip);
            if (empty($products_match_tip)) {
                continue;
            }
            $products_match_tip = explode('|', $products_match_tip);

            $other_html .= '<div class="product_03_01" >';
            $other_html .= '<span class="product_03_02">';
            $other_html .= '<strong>'.$products_match_tip[0].'</strong>';
            $other_html .= '</span>';
            $other_html .= '<span class="product_03_08">'.$products_match_tip[1].'</span>';
            $other_html .= '<div class="ccc"></div>';
            $other_html .= '</div>';
        }
        $other_html .= '</div>';
    }
//如果数据库不为空，就展示数据库中的。
    return $other_html;
}

/**
 * add by Quest 2020.01.08
 * @param $products_id
 * @return string
 */
function get_product_info_note_html($products_id){
    $html = '';
    if(in_array($products_id,[96375,96376])) {
        $html = '<p style="margin-top:10px">'.FS_PRODUCTS_INFO_NOTE_TITLE.FS_PRODUCTS_INFO_NOTE_TIPS.'</p>';
    }
    return $html;
}


/*
 * 模块产品中的标签产品
 * */
function get_related_label_product_html($products_id,$price){
    global $db;
    $related_label_html = '';
    if($products_id){
        $sqlCache = sqlCacheType();
        $related_label = $db->getAll("SELECT {$sqlCache} related_label_pid FROM ".TABLE_PRODUCTS." WHERE products_id=".$products_id." LIMIT 1");
        $related_label_pid = $related_label[0]['related_label_pid'];
        if($related_label_pid) {
            $products_name = zen_get_products_name($related_label_pid);
            $image = get_resources_img(intval($related_label_pid), '100', '100', '', '', '', ' border="0" ');
            $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . intval($related_label_pid), 'NONSSL');
            //产品价格
            $currencies = new currencies();
            $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
            $color_price = $price / $currency_value;
            $priceText = $currencies->total_format($color_price);
            $related_label_html .= '<div class="addCrat_item_list">
                                    <div class="addCrat_item_listTa" data-cartid="">
                                        <div class="addCrat_item_list_top">
                                            <div class="addCrat_left" id="video_img"><a href="' . $link . '">' . $image . '</a></div>
                                            <div class="addCrat_right">
                                                <h1 class="addCrat_item_list_tit" id="video_array_title"><a href="' . $link . '" target="_blank" data-is-common-title="">' . $products_name . '</a>
                                                </h1>
                                                <div id="lable_options_div"></div>
                                                <p class="Qty_num02 ">#' . (int)$related_label_pid . '</p>
                                            </div>
                                        </div>
                                        <div class="addCrat_item_list_Quantity">
                                            <div class="product_list_text">
                                                <span>
                                                    <input type="text" id="custom_lable_pop_qty" name="customeized_cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" min="1" onblur="q_check_min_qty(this,' . $related_label_pid . ');" onfocus="q_enterKey(this,' . $related_label_pid . ')" value="1" autocomplete="off" class="p_07 product_list_qty">
                                                    <div class="pro_mun">
                                                        <a href="javascript:;" class="cart_qty_add" onclick="change_customized_product_num(1,' . $related_label_pid . ',$(this))"></a>
                                                        <a href="javascript:;" class="cart_qty_reduce cart_reduce" onclick="change_customized_product_num(0,' . $related_label_pid . ',$(this))"></a> 
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="addCrat_item_list_total">
                                            <p class="addCart_pro_price">
                                                <span id="popup_cart_price_' . $related_label_pid . '">' . $priceText . '</span>
                                                <input type="hidden" class="popup_cart_price_'.$related_label_pid.'" value="'.$price.'">
                                            </p>
                                        </div>
                                    </div>
                                </div>';
        }
    }
    return $related_label_html;
}

//获取子产品的结构
function get_son_products_html_by_arr($composite_son_product_arr){
    $html = '';
    if($composite_son_product_arr){
        $html .= '<div class="addCrat_item_childMainBoxz">
                     <div class="addCrat_item_childBox">
                         <p class="addCrat_item_childTxt" onclick="_theSlide($(this))">
                         '.FS_ITEM_INCLUDES_PRODUCTS.'<span class="iconfont icon"></span>
                         </p>
                        <div class="addCrat_item_childMain choosez">';
        foreach ($composite_son_product_arr as $composite_son_product_key => $composite_son_product_val ){
            $html .= '<div class="addCrat_item_childCont">
                          <div class="addCrat_item_childLeft">'.$composite_son_product_val['products_image_str'].' </div>
                             <div class="addCrat_item_childRight">
                                <p class="checkPro_newOrder_txt">'.$composite_son_product_val['products_name'].'</p>
                                <p class="checkPro_newOrder_txt01 composite_son_product composite_product_'.$composite_son_product_val['products_id'].'">
                                  <em style="display:none;">'.$composite_son_product_val['one_product_corr_number'].'</em>
                                   <span>'.$composite_son_product_val['buy_number'].'</span>';
            //XQ20201114001 AP组合产品子ID价格隐藏 ery 2020.11.14
            if(!in_array($composite_son_product_val['parent_products_id'],[108704,108706])){
                $html .= ' x <span>'.$composite_son_product_val['products_price_str'].'</span>'.FS_PRODUCT_PRICE_EA;
            }
            $html .= '</p>
                             </div>
                          </div>';
        }
        $html .= '</div></div></div>';
    }
    return $html;
}

/*
 * 加购产品弹窗
 * @author Frankie
 * @para string $html
 */
function products_add_cart_new_popup($is_customize=false,$products_id='',$type ='',$custom_label =0,$color_price=0,$attr_str='',$qty=0){
	global $currencies,$db;
	$html = ''; //弹窗
    $totalPrice='';
    $product_status = zen_get_products_status((int)$products_id);
    if($is_customize){
        $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($products_id),'NONSSL');
//        $products_name = fs_get_data_from_db_fields('products_name',TABLE_PRODUCTS_DESCRIPTION,'products_id='.$products_id,'limit 1');
        $products_name = zen_get_products_name($products_id);
        $image = get_resources_img(intval($products_id),'100','100','','','',' border="0" ');
        if($product_status==1){
            $image = str_replace('images/no_picture.gif','includes/templates/fiberstore/images/logo_trad.jpg',$image);
        }
        $html .='<div class="new_popup addCart show new_product_popup_addCart customAddCart" style="display: none;">
                    <div class="new_popup_bg"></div>
                    <div class="new_popup_main popup_width680 change_poput_width750 pupop_video">
                        <h2 class="new_popup_addCart_tit new_popup_changeTit01">
                            <div class="addCrat_item_number"><span class="addCrat_item_numberTit">'.FS_CUSTOMIZED_INFORMATION.'</span></div>
                            <span class="icon iconfont" onclick=$("html").css({"overflow":"auto"}).find("body").css({"overflow":"auto","padding-right":"0"}).find(".addCart").hide();$(".new_popup_addCart_customBtn").show();$(".new_popup_addCart_customBtn01").hide();>&#xf092;</span>
                            <div class="new_addCart_custshipStep_listBox">
                                <ul class="new_addCart_custshipStep_list after">
                                    <li class="new_addCart_custshipStep_li">
                                        <p><span class="new_addCart_custshipStep_Num">1. </span>'.FS_DETAIL_CUSTOM_1.'</p>
                                        <span class="iconfont icon">&#xf089;</span>
                                    </li>
                                    <li class="new_addCart_custshipStep_li">
                                        <p><span class="new_addCart_custshipStep_Num">2. </span>'.FS_DETAIL_CUSTOM_2.'</p>
                                        <span class="iconfont icon">&#xf089;</span>
                                    </li>
                                    <li class="new_addCart_custshipStep_li">
                                        <p><span class="new_addCart_custshipStep_Num">3. </span>'.FS_DETAIL_CUSTOM_3.'</p>
                                        <span class="iconfont icon">&#xf089;</span>
                                    </li>
                                    <li class="new_addCart_custshipStep_li">
                                        <p><span class="new_addCart_custshipStep_Num">4. </span>'.FS_DETAIL_CUSTOM_4.'</p>
                                    </li>
                                </ul>
                            </div>
                        </h2>
                        <div class="addCrat_item_listMain01 customDev02">
                            <div class="new_popup_content addCart_cont"> 
                                <div class="addCrat_item_taLlist">
                                    <div class="addCrat_item_taLlistLiF" '.(isMobile() ? 'style="display:none"' : '').'>'.F_BODY_HEADER_ITEM.'</div>
                                    <div class="addCrat_item_taLlistLiS">'.MANAGE_ORDER_QUANTITY.'</div>
                                    <div class="addCrat_item_taLlistLiT">'.TABLE_HEADING_TOTAL.'</div>
                                </div>
                                <div class="addCrat_item_list">
                                    <div class="addCrat_item_listTa" data-cartId="'.$product['id'].'">
                                        <div class="addCrat_item_list_top">
                                            <div class="addCrat_left" id="video_img"><a href="products/'.$products_id.'.html">'.$image.'</a></div>
                                            <div class="addCrat_right">
                                                <h1 class="addCrat_item_list_tit" id="video_array_title"><a href="'.$link.'" target="_blank" data-is-common-title="">'.$products_name.'</a>
                                                </h1>
                                                <div id="qty_attribute_div"></div>
                                                <p class="Qty_num02 ">#'.$products_id.'</p>
                                            </div>
                                        </div>
                                        <div class="addCrat_item_list_Quantity">
                                            <div class="product_list_text">
                                                <span>
                                                    <input type="text" id="customized_img_quantity" name="customeized_cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" min="1" onblur="q_check_min_qty(this,'.$products_id.');" onfocus="q_enterKey(this,'.$products_id.')" value="" autocomplete="off" class="p_07 product_list_qty">
                                                    <div class="pro_mun">
                                                        <a href="javascript:;" class="cart_qty_add" onclick="change_customized_product_num(1,'.$products_id.',$(this))"></a>
                                                        <a href="javascript:;" class="cart_qty_reduce cart_reduce" onclick="change_customized_product_num(0,'.$products_id.',$(this))"></a> 
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="addCrat_item_list_total">
                                            <p class="addCart_pro_price">
                                                <span id="popup_cart_price_'.$products_id.'" class="popup_cart_price"></span>
                                                    <input type="hidden" class="popup_cart_price_'.$products_id.' popup_cart_price_custom" value="">
                                            </p>
                                        </div>
                                    </div>
                                </div>';
                            //如果客户勾选了 custom_lable 则展示关联的标签产品
                            if($custom_label ==1 && $color_price){
                                $html .= get_related_label_product_html($products_id,$color_price);
                            }
        //子产品代码
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts($products_id,'',$attr_str);
            $composite_son_product_arr = $CompositeProducts->show_products_composite($qty);
            if($composite_son_product_arr){
                $html .= get_son_products_html_by_arr($composite_son_product_arr);
            }
        }
        //子产品代码结束
        $html .='</div>
                        </div>
                         <div class="new_popup_addCart_bottom customDev01">';
                           $country_iso_code = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : "US";
                           $is_pre_order = check_product_is_pre_product($products_id);
                           //如果是有属性的组合产品 弹窗里的交期不展示
                           if(!($is_pre_order && (all_german_warehouse("country_code",$country_iso_code) || au_warehouse($country_iso_code,"country_code"))) && !$composite_son_product_arr){
       $html .='           <div class="new_popup_addCart_bottomMain01">
                                <div id="customized_processing">
                                    <span class="new_popup_addCart_bottomTxt01">'.FS_DETAIL_CUSTOM_5.'</span><span id="attr_days_processing"></span>'.FS_BUSINESS_DAYS_ADD.'
                                </div>
                                <div>
                                    <span class="new_popup_addCart_bottomTxt01">'.FS_DETAIL_CUSTOM_6.'</span><span id="customized_shipping_time"></span>
                                </div>
                                <div>
                                    <span class="new_popup_addCart_bottomTxt01">'.FS_DETAIL_CUSTOM_7.'</span><span id="customized_arrvied_time"></span>
                                </div>
                            </div>';
                           }
        $html .='          <div class="new_popup_addCart_bottomMain">
                                <div class="fs_customer_btn new_popup_addCart_customBtn" id="new_customBtn_dylan">
                                    <a href="javascript:;" onclick=$("html").css({"overflow":"auto"}).find("body").css({"padding-right":"0"}).find(".addCart").hide(); class="fs_customer_btnG01">'.FS_ADDRESS_EDIT.'</a>
                                    <button type="submit" data-products-id="'.$products_id.'" onclick="customProdAddtoCart(this)" name="Add to Cart" value="'.($is_pre_order ? FS_PRE_ORDER : FS_CUSTOMILIZED_ADD_TO_CART).'" class="new_pro_addCart_btn" placeholder="">
                                        <div class="new_pro_addCart_mainDev after"><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>'.($is_pre_order ? FS_PRE_ORDER : FS_CUSTOMILIZED_ADD_TO_CART).'</div><div class="new_addCart_loading choosez">
                                        <div class="new_chec_bg"></div>
                                        <div class="loader_order">
                                            <svg class="circular" viewBox="25 25 50 50">
                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                            </svg>
                                        </div>
                                    </div></button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>';
    }else{
        $cart = $_SESSION['cart'];
        $cart_product =$cart->get_products();
        $citems = $_SESSION['cart']->count_contents(); //总数量
        //判断购物车数量
        if($_SESSION['languages_code'] == 'ru'){
            $item_str =get_russian_item_str($citems);
            $qty = $citems."  ".$item_str;
        }else{
            if($citems>1){
                $qty = $citems.' '.F_BODY_HEADER_ITEM_TWO;
            }else{
                $qty = $citems.' '.F_BODY_HEADER_ITEM;
            }
        }
        if($citems ==0){
            return '';
            $empty_class ='empty_cartIcon_gray';
        }
        $currency = $_SESSION['currency'];
        $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
        $decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
        if($_SESSION['languages_code'] == 'au'){
            $currency_symbol_left =  $currencies->currencies[$_SESSION['currency']]['symbol_left'];
        }else{
            $currency_symbol_left =  $currencies->currencies[$_SESSION['currency']]['symbol_left'];
        }
        $currency_symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];

        $html .='<div class="new_popup addCart show new_product_popup_addCart" style="display: none;">';
        $html .='<div class="new_popup_bg"></div><div class="new_popup_main popup_width680 change_poput_width750 pupop_video"> <h2 class="new_popup_addCart_tit new_popup_changeTit01">';
        $html .='<div class="addCrat_item_number"><span class="icon iconfont '.$empty_class.'">&#xf186;</span><span class="addCrat_item_numberTit">'.FS_ADDED_TO_CART.'</span></div>';
        $html .='<span class="icon iconfont" onclick=$("html").css({"overflow":"auto"}).find("body").css({"overflow":"auto","padding-right":"0"}).find(".addCart").hide();>&#xf092;</span></h2>';
        $html .='<div class="addCrat_item_listMain01"><div class="new_popup_content addCart_cont">';
        $html .='<div class="addCrat_item_list">';
        require_once(DIR_WS_CLASSES.'shoppingCartModel.php');
        require_once(DIR_WS_CLASSES.'shipping_info.php');
        $cartModel = new shoppingCartModel();
        foreach($cart_product as $i=>$product){
            $option_values = array();
            $Product_id = (int)$product['id'];

            $attr_str ='';
            //获取属性数据
            $attrArray = $cartModel->get_attributes_info($product);
            if (!empty($attrArray)) {
                $attr_str = '<div class="qty_attribute_div">';
                foreach ($attrArray as $option => $value) {
                    if(!$value['products_options_name']){

                    }
                    if ($option == 'length') {
                        $Length = $value['length'];
                        $attr_str .="<p class='Qty_num'><span>".FS_LENGTH_NAME. " - " .$value['length']."</span></p>";
                    }else{
                        $Attr[] = $value['options_values_id'];
                        $attr_str .="<p class='Qty_num'><span>".$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name'])."</span></p>";
                    }
                }
                $attr_str .="</div>";
            }
            $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($Product_id),'NONSSL');
            $image = get_resources_img(intval($Product_id),'100','100',$product['image'],'','',' border="0" ');
            if($product_status==1){
                $image = str_replace('images/no_picture.gif','includes/templates/fiberstore/images/logo_trad.jpg',$image);
            }
            $image_html = $title_html = '';
            if($product['show_type']==1){
                //特殊定制分类下的产品不展示在详情页和搜索页 因此不给跳转链接
                $image_html = '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="120" height="120">';
                $title_html = $product['name'];
            }else{
                $image_html = '<a href="'.$link.'">'.$image.'</a>';
                $title_html = '<a href="'.$link.'" target="_blank" data-is-common-title="">'.$product['name'].'</a>';
            }
            //所有产品总价格
            $totalPrice += $cart_product[$i]['final_price']*$product['quantity'];
            //单种产品总价
            $productsPriceTotal = $currencies->display_price_rate(zen_round(($product['final_price'] * $currency_value), $decimal), zen_get_tax_rate($product['tax_class_id']), $product['quantity']) . ($product['onetime_charges'] != 0 ? '<br />' . $currencies->display_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');
            $cart_price = $product['products_price'];
            $quantity = $product['quantity'];
            //清仓产品加购限制
            $config['pid'] = $Product_id;$shippingInfo = new ShippingInfo($config);
            $is_clearance = get_current_pid_if_is_clearance($Product_id);
            $is_clearance = $is_clearance ? 1 : 0;
            $choosez = $clearance_html = '';
            $clearance_qty = 0;
            if($is_clearance==1){
                $clearance_qty = $shippingInfo->getLocalAndWuhanqty();
                if($quantity>=$clearance_qty){
                    $choosez = ' choosez';
                }

                //liang.zhu 2020.08.04
                $products_clearance_tip = str_replace('$QTY',$clearance_qty,FS_CLEARANCE_TIPS_CONTENT);
                //获取清仓产品的提示
                $sql = "select replace_products,replace_products_tip from products_clearance where products_id=".intval($product['id']);
                $query = $db->Execute($sql);
                $products_clearance = $query->fields;
                if ($products_clearance) {
                    $products_clearance['replace_products'] = explode(';', $products_clearance['replace_products']);
                    $products_clearance['replace_products'] = array_filter($products_clearance['replace_products']);
                    if (count($products_clearance['replace_products'])) {
                        $products_clearance_replace = current($products_clearance['replace_products']);
                        //有替代产品
                        if ($clearance_qty > 0 ) {
                            $products_clearance_tip = FS_CLEARANCE_TIP_01_01.' '.FS_CLEARANCE_TIP_01_02;
                            $products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($clearance_qty, $products_clearance_replace), $products_clearance_tip);
                        } else {
                            $products_clearance_tip = FS_CLEARANCE_TIP_02_01.' '.FS_CLEARANCE_TIP_02_02;
                            $products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($clearance_qty, $products_clearance_replace), $products_clearance_tip);
                        }

                    } else {
                        //对于无替代或者不可定制产品
                        if ($clearance_qty > 0 ) {
                            $products_clearance_tip = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                            $products_clearance_tip = str_replace(array('$QTY'), array($clearance_qty), $products_clearance_tip);
                        } else {
                            $products_clearance_tip = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
                        }
                    }

                } else {
                    //对于无替代或者不可定制产品
                    if ($clearance_qty > 0 ) {
                        //$products_clearance_tip = FS_CLEARANCE_TIP_03;
                        $products_clearance_tip = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                        $products_clearance_tip = str_replace(array('$QTY'), array($clearance_qty), $products_clearance_tip);
                    } else {
                        $products_clearance_tip = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
                    }
                }


                $clearance_html .= '<div class="public_Prompt" style="display: none">
                                        <i class="iconfont icon"></i>
                                        '.$products_clearance_tip.'
                                    </div>';
            }

            $html .='<div class="addCrat_item_listTa" data-cartId="'.$product['id'].'">
                <div>
                <div class="addCrat_item_list_top">
                    <div class="addCrat_left" id="video_img">';

            $html .= $image_html.'</div>';
            $html .='<div class="addCrat_right">';
            $html .='<h1 class="addCrat_item_list_tit" id="video_array_title">'.$title_html.'</h1>';
            $html .= $attr_str.'<p class="Qty_num02 ">#'.$Product_id .'</p></div></div>';
            $html .='<div class="addCrat_item_list_Quantity"><div class="product_list_text"><p class="addCart_pro_price after"><span class="popup_cart_price">'.$productsPriceTotal.'</span></p></div>';
            //数量框板块
            $html .='<span><input type="text" id="img_quantity3_'.$Product_id .'" name="cart_quantity" onkeyup=this.value=this.value.replace(/[^0-9]/g,"") maxlength="5" onafterpaste=this.value=this.value.replace(/[^0-9]/g,"") min="1" onblur=add_check_min_qty(this,"'.$product['id'] .'","'.$is_clearance.'","'.$clearance_qty.'"); onfocus="q_enterKey(this,'.$Product_id .')" value="'.$product['quantity'].'" autocomplete="off" class="p_07 product_list_qty">';
            $html .='<div class="pro_mun"><a href="javascript:void(0);" onclick=change_product_num(1,"'.$product['id'] .'",this,"'.$is_clearance.'","'.$clearance_qty.'") class="cart_qty_add '.$choosez.'"></a>';
            $html .='<a href="javascript:void(0);" onclick=change_product_num(0,"'.$product['id'] .'",this,"'.$is_clearance.'","'.$clearance_qty.'") class="cart_qty_reduce cart_reduce"></a></div></span></div>';
            $html .= '<div class="addCrat_item_list_delete"><i class="icon iconfont" onclick=delete_this_cart("' . $product['id'] . '",' . $quantity . ',' . $cart_price . ',this)>&#xf027;</i></div>';
            $html .='</div>';

            $tip = zen_get_products_tip($Product_id);
            if($tip != ''){
                $html .= '<div class="new_product_prompt_container"><p class="new_product_prompt"><em>*</em>'.$tip.'</p></div>';
            }

            //子产品代码
            if (class_exists('classes\CompositeProducts')) {
                //账户中心的再次购买 把options_values_id值拼接成options_values_id1,options_values_id2, 方便有属性的组合产品查询子产品
                $option_values_str = '';
                if($type =='buy_again' && $product['attributes']){
                    foreach ($product['attributes'] as $option=>$value){
                        $option_values[] = $value;
                    }
                    if($option_values){
                        $option_values_str = reorder_options_values($option_values);
                    }
                }
                $CompositeProducts = new classes\CompositeProducts(intval($product['id']),'',$option_values_str);
                $composite_son_product_arr = $CompositeProducts->show_products_composite($product['quantity']);
                if($composite_son_product_arr){
                    $html .= get_son_products_html_by_arr($composite_son_product_arr);
                }
            }
            //子产品代码结束
            $html .= $clearance_html;
            $html .='</div>';
        }
        $total_new =$currencies->fs_format($totalPrice, true, $currency, $currency_value);//总价

        $html .='</div></div></div>';
        $html .='<div class="new_popup_addCart_bottom"><div class=""><span class="new_popup_addCart_bottomTit01">'.FS_ADD_CART_PROCHUSE.' (<span class="item_qty">'.$qty.'</span>)</span>';
        $html .='<span class="new_popup_addCart_bottomTit02">'.$currency_symbol_left.'<span class="cart_total">'.$total_new.'</span>'.$currency_symbol_right.'</span>';
//        $html .='<span class="new_popup_addCart_bottomLine"></span><a href="'.zen_href_link(FILENAME_SHOPPING_CART,'','NONSSL').'" class="new_popup_addCart_bottomLink">'.FS_VIEW_CART.'</a>';
        $html .='</div><br><div class="new_popup_addCart_bottomMain"><div class="fs_customer_btn">';
        if($type == 'buy_again'){
            $html .= '<a href="'.zen_href_link(FILENAME_DEFAULT, '', 'NONSSL').'" class="fs_customer_btnG01">' . FS_CONTINUE_SHOPPING . '</a><a href="' . zen_href_link(FILENAME_CHECKOUT, '', 'NONSSL') . '" class="fs_customer_btn01 mg_left10"><span class="security_icon iconfont icon">&#xf231;</span>' . FS_SHOP_CART_ALERT_JS_69 . '</a></div>';
        }else {
            $html .= '<a href="javascript:;" onclick=$("html").css({"overflow":"auto"}).find("body").css({"overflow":"auto","padding-right":"0"}).find(".addCart").hide(); class="fs_customer_btnG01">' . FS_CONTINUE_SHOPPING . '</a><a href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL') . '" class="fs_customer_btn01 mg_left10">' . FS_SHOP_CART_ALERT_JS_77 . '</a></div>';
        }
        $html .='</div></div></div></div>';
    }
    return $html;
}

//检测订单中是否有特殊产品存在
function get_order_products_type($orders_id){
    global $db;
    if(is_numeric($orders_id)){
        $mark = 0;
        $products_id = $db->getAll("select products_id from ".TABLE_ORDERS_PRODUCTS." where orders_id=".$orders_id."");
        foreach ($products_id as $rel){
         $show_type = $db->getAll("select show_type from ".TABLE_PRODUCTS." where products_id=".$rel['products_id']." and show_type=1");
            if($show_type[0]['show_type']==1){
                $mark=1;
            }
        }
        if($mark==0){
            $main_order_id = $db->getAll("select orders_id from ".TABLE_ORDERS." where main_order_id=".$orders_id."");
            if(count($main_order_id)>0){
                foreach ($main_order_id as $v){
                    $products_id = $db->getAll("select products_id from ".TABLE_ORDERS_PRODUCTS." where orders_id=".$v['orders_id']."");
                    foreach ($products_id as $value){
                        $show_type = $db->getAll("select show_type from ".TABLE_PRODUCTS." where products_id=".$value['products_id']." and show_type=1");
                        if($show_type[0]['show_type']==1){
                            $mark=1;
                        }
                    }
                }
            }
        }
        if($mark==1){
            return 1;
        }
    }
}

/*
 * 判断产品id，是否是预售产品
 * fairy 2019.2.27 add
 * @para int $first_category_id：产品的一级分类。 因为产品详情页面有这个参数。后期可以根据需求加$product_id
 * @return bool 是否是预售产品
 */
function check_product_is_pre_product($pid = "")
{
    global $db;
    //预售产品已取消不需要查询数据库 2020.3.27 ery
    return false;
    /*$pid = (int)$pid;
    if (!$pid) {
        return false;
    }
    $tag_info = $db->Execute("SELECT is_important FROM " . TABLE_PRODUCTS . " WHERE products_id=" . $pid . " LIMIT 1");
    if ($tag_info && !$tag_info->EOF) {
        $is_important = (int)($tag_info->fields['is_important']);
        if ($is_important === 10) {
            return true;
        }
    }
    return false;*/
}

/** 判断产品id，是否是定制预售产品
 * @param string $pid
 * @return bool
 */
function check_product_is_customized_pre_product($pid=""){
    //预售产品已取消不需要查询数据库 2020.3.27 ery
    return false;
    /*$pid = (int)$pid;
    if(!$pid){
        return false;
    }
    if(zen_get_products_length_total($pid) != 0 || zen_get_products_attributes_total($pid) != 0){
        $is_important = check_product_is_pre_product($pid);
        if($is_important){
            return true;
        }
    }
    return false;*/
}

function check_product_is_attr_and_qty_delivery_time($pid=""){
    $pid = (int)$pid;
    if(!$pid){
        return false;
    }
    $id = fs_get_data_from_db_fields('id','customized_attribute_delivery_time','products_id='.$pid,'limit 1');
    if($id){
        return true;
    }else{
        return false;
    }
}

//获取退换货人工审核邮件结构
function get_service_artificial_email_html($email_text2,$po_html,$name,$orders_id,$order_number,$email_text3,$type=''){
    $html="";
    $href="";
    if($type==""){
        $href= zen_href_link('account_history_info','orders_id='.$orders_id);
    }else{
        $href="javascript:;";
    }
    $html = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="center">
                            '.FS_SEND_EMAIL_16.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                            '.EMAIL_CHECKOUT_WAREHOUSE_DEAR.' '.$name.FS_EMAIL_COMMA.' 
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>';
    if($_SESSION['languages_code'] == 'jp'){
        $html.= '<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                        注文<a style="color: #0070BC;text-decoration: none" href="'.$href.'" >'.$order_number.'</a>の問題に関するご依頼は既に受領されました。'.$po_html.$email_text2.'
                        </td>';
    }else{
        $html.= '<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                        '.FS_SEND_EMAIL_17.'<a style="color: #0070BC;text-decoration: none" href="'.$href.'" >'.$order_number.'</a> '.$po_html.$email_text2.'
                        </td>';
    }
    $html.= '</tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_18.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="center">
                            '.$email_text3.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20" >
                        </td>
                    </tr>
                    </tbody>
                </table>';

    return $html;
}

//获取退换货自动审核邮件结构
function get_service_automatic_email_html($email_tx,$email_text1,$email_text2,$name,$orders_id,$email_shipping,$order_number,$po_html,$text4,$type=''){

    $href="";
    if($type==""){
        $href= zen_href_link('account_history_info','orders_id='.$orders_id);
    }else{
        $href="javascript:;";
    }
    $html_de=" ";
    if($_SESSION['languages_code']=="fr" || $_SESSION['languages_code']=="jp" || $_SESSION['languages_code']=="ru"){
        $email_tx="";
    }elseif($_SESSION['languages_code']=="de"){
        if($email_text2==FS_SEND_EMAIL_49){
            $html_de="  haben. ";
        }else{
            $html_de="";
        }
    }
    $point = '.';
    if ($_SESSION['languages_code'] == "de") {
        $point = '';
    }
    $tx=" ";
    if($_SESSION['languages_code']=="jp"){
        $tx='';
    }
    $four = FS_SEND_EMAIL_169." ".$email_tx;
    if ($type == 3 && $_SESSION['languages_code']=="ru") {
        $four = '4. Получить ваш товар';
    } elseif ($type == 1 && $_SESSION['languages_code'] == "ru") {
        $four = '4. Получить ваш возврат';
    }elseif ($type == 1 && $_SESSION['languages_code'] == "de") {
        $four = '4. Erstattung erhalten';
    }elseif ($type == 2 && $_SESSION['languages_code'] == "de") {
        $four = '4. Ersatzprodukt erhalten';
    }elseif ($type == 3 && $_SESSION['languages_code'] == "de") {
        $four = '4. Reparierte Produkte erhalten';
    }

        $html = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="center">
            '.FS_SEND_EMAIL_162.'
        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                           '.EMAIL_CHECKOUT_WAREHOUSE_DEAR.$tx.$name.FS_EMAIL_COMMA.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">'.
                            ($_SESSION['languages_code'] == 'jp' ? $email_text1.' <a style="color: #0070BC;text-decoration: none" href="'.$href.'" >'.$order_number.'</a>'.$html_de.$po_html.$email_text2 : $email_text1.' <a style="color: #0070BC;text-decoration: none" href="'.$href.'" >'.$order_number.'</a>'. $point .$html_de.$po_html.$email_text2)
                        .'</td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="border-collapse: collapse;padding: 0 40px;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" align="left" style="border-collapse: collapse;padding: 0 20px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="80" align="left" valign="top" style="border-collapse: collapse">
                                                    <img style="display: block" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/print-icon.png" alt="">
                                                </td>
                                                <td align="left" style="border-collapse: collapse;padding-left: 20px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                    <span style="font-weight: 600;margin-bottom: 5px;display: inline-block">'.FS_SEND_EMAIL_163.'</span>
                                                    <br>
                                                    <span style="color: #818181;display: inline-block">'.FS_SEND_EMAIL_164.'</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" align="left" style="border-collapse: collapse;padding: 0 20px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="80" align="left" valign="top" style="border-collapse: collapse">
                                                    <img style="display: block" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/package-icon.png" alt="">
                                                </td>
                                                <td align="left" style="border-collapse: collapse;padding-left: 20px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                    <span style="font-weight: 600;margin-bottom: 5px;display: inline-block">'.FS_SEND_EMAIL_165.'</span>
                                                    <br>
                                                    <span style="color: #818181;display: inline-block">'.FS_SEND_EMAIL_166.'</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" align="left" style="border-collapse: collapse;padding: 0 20px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="80" align="left" valign="top" style="border-collapse: collapse">
                                                    <img style="display: block" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/ship-icon.png" alt="">
                                                </td>
                                                <td align="left" style="border-collapse: collapse;padding-left: 20px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                    <span style="font-weight: 600;margin-bottom: 5px;display: inline-block">'.FS_SEND_EMAIL_167.'</span>
                                                    <br>
                                                    <span style="color: #818181;display: inline-block">'.FS_SEND_EMAIL_168.'</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" align="left" style="border-collapse: collapse;padding: 0 20px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="80" align="left" valign="top" style="border-collapse: collapse">
                                                    <img style="display: block" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/return-icon.png" alt="">
                                                </td>
                                                <td align="left" style="border-collapse: collapse;padding-left: 20px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                                    <span style="font-weight: 600;margin-bottom: 5px;display: inline-block">'. $four .'</span>
                                                    <br>
                                                    <span style="color: #818181;display: inline-block">'.$text4.'</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                                </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-top: 1px solid #f7f7f7" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                '.$email_shipping.'
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>';
    return $html;
}


function pre_order_product_get_related_product($pid=""){
    $pid = (int)$pid;
    if (!$pid) {
        return false;
    }
    $related_pid = fs_get_data_from_db_fields('products_id',TABLE_PRODUCTS,'related_preorder_product_id='.$pid,'limit 1');
    if($related_pid){
        return $related_pid;
    }else{
        return false;
    }
}


//获取M端的 match products


function zen_create_mobile_stock_list_html($stock_list){
    global $db,$currencies;
    $stock_list_str = '';
    $country_code_iso = strtolower($_SESSION['countries_iso_code']);
    $stock_list = str_replace("；", ";",$stock_list);
    $stock_list = str_replace("：", ":",$stock_list);

    $stock_table_arr = explode("||",$stock_list) ;
    foreach ($stock_table_arr as $sl_val) {
        if ($sl_val) {
            $stock_list = $sl_val ;
            $stock_list_titile = '';
            $stock_list_dl = '';
            $str_pos = strpos($stock_list, '#');
            if ($str_pos === false) {
            }else{
                $stock_list_titile = substr($stock_list, 0, $str_pos);
                $stock_list = substr($stock_list, $str_pos+1);
                $stock_list_titile = '<div class="p_con_01"><h2>'.$stock_list_titile.'</h2></div>';
            }
            $stock_list_arr = explode(";",$stock_list) ;
            if (sizeof($stock_list_arr)) {
                $stock_list_dl = '<div class="pro_stock_list">';
                foreach ($stock_list_arr as $stock_list_val) {
                    $stock_prod_arr = array();
                    $stock_prod_arr = explode(":",$stock_list_val) ;
                    $stock_prod_id  = (int)trim($stock_prod_arr[0]);
//                    $stock_prod_str = fs_get_data_from_db_fields('products_name',TABLE_PRODUCTS_DESCRIPTION,'products_id='.(int)$stock_prod_id,'');
                    $stock_prod_str = zen_get_products_name((int)$stock_prod_id);

                    if ($stock_prod_id) {
                        //获取库存
                        $product_stock = get_instock_for_index($stock_prod_id,true);
                        $product_stock = str_replace(QTY_SHOW_ZERO_STOCK_1,FS_SHIP_PCS,$product_stock);
                        $image = get_resources_img($stock_prod_id,180,180);

                        //价格展示 澳大利亚展示税后（重货本地仓无库存除外）
                        $Info = fs_get_data_from_db_fields_array(array('products_price','integer_state'),'products','products_id='.(int)$stock_prod_id,'limit 1');
                        $products_price = $Info[0][0];
                        $integer_state = $Info[0][1];
                        $products_price = zen_get_new_products_final_price((int)$stock_prod_id,$products_price,$integer_state,$country_code_iso);
                        $products_price = $currencies->total_format($products_price);

                        $stock_list_dl .= '<dl class="new_m_960_dl"><dt>'.$image.'
                        <span><a href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$stock_prod_id,'SSL').'">#'.$stock_prod_id.'</a></span></dt><dd>
                        <h2>'.$stock_prod_str.'</h2>
						<p class="new_m_p_pic">'.$products_price.'</p>
						<span class="new_m_span_ms"><td style="text-align: center;"><div class="pro_yellow_stock "><i></i>'.$product_stock.'</div></td></span>
						<div class="new_m_button_wap">';
                        $quicktocart = false;
                        $productsAttributesInfo = zen_get_products_attributes_total($stock_prod_id);
                        $productLengthInfo = fs_product_length_info($stock_prod_id);
                        if(!$productLengthInfo && !$productsAttributesInfo){
                            $quicktocart = true;
                        }
                        $product_category_status = get_product_category_status($stock_prod_id);
                        $custom_status = false;
                        $sql = "select column_id,column_name from attribute_custom_column where column_name = '" . (int)$stock_prod_id . "' and parent_id = 0";
                        $attribute_custom_column = $db->Execute($sql);
                        if($attribute_custom_column->fields['column_name']>0){
                            $custom_status = true;
                        }

                        if($quicktocart && $custom_status == false && !$product_category_status){
                            //普通产品
                            $stock_list_dl .='<button type="button"  class="new_pro_addCart_btn" onclick="prodAddToCartMatching('.$stock_prod_id.',$(this))" data-product-id="'.$stock_prod_id.'">
                            <span class="icon iconfont add_to_cart_iconfont"></span>
	                        	'.FS_ADD_TO_CART.'
	                        </button>
						</div>
					</dd></dl>';
                        }else{
                            $stock_list_dl .= '<a href="'.zen_href_link('product_info', 'products_id=' .$stock_prod_id).'"  target="_blank"><button type="button"  class="new_pro_addCart_btn" >
                            <span class="icon iconfont add_to_cart_iconfont"></span>
	                        	'.FS_ADD_TO_CART.'
	                        </button></a>
						</div>
					</dd></dl>';
                        }



                    }
                }
            }

        }
    }
    if($stock_list_dl){
        $stock_list_str .= $stock_list_titile.$stock_list_dl .'</div>';
    }
    return $stock_list_str;
}



/***
 * 获取重货类产品及其对应的is_heavy_标记
 * update by rebirth
 *
 * @param array $products   产品id数组
 * @param int $warehouse    仓库
 * @return array
 */
function get_heavy_products($products = [], $warehouse = 0)
{
    global $db;
    $heavy_products = [];
    $heavy_products_tag = [];
    $is_heavy_free = [];
    if (!empty($products)) {
        $ids = '';
        if (is_array($products)) {
            foreach ($products as $v) {
                $vv = (int)$v;
                if ($vv) {
                    $ids .= $vv . ',';
                }
            }
        }
        $ids = substr($ids , 0 , -1);
        $sqlCache = sqlCacheType();
        $sql = "SELECT {$sqlCache} is_heavy,products_id,is_cn_free,is_us_free,is_de_free,is_au_free FROM " . TABLE_PRODUCTS . " WHERE products_id in ( " . $ids . " )";
        $data = $db->Execute($sql);
        while (!$data->EOF){
            $is_heavy = $data->fields['is_heavy'];
            $is_cn_free = $data->fields['is_cn_free'];
            $is_us_free = $data->fields['is_us_free'];
            $is_au_free = $data->fields['is_au_free'];
            $is_de_free = $data->fields['is_de_free'];
            switch ($warehouse) {
                case 40:
                    $is_free = $is_us_free;
                    break;
                case 20:
                    $is_free = $is_de_free;
                    break;
                case 37:
                    $is_free = $is_au_free;
                    break;
                case 2:
                    $is_free = $is_cn_free;
                    break;
                default:
                    $is_free = 0;
            }
            if ($is_heavy && (int)$is_free !== 1) {
                $heavy_products[] = $data->fields['products_id'];
                $heavy_products_tag[$data->fields['products_id']] = $data->fields['is_heavy']; //0，正常  1.超重heavy  2.超出尺寸 oversize
            }else{
                if($is_heavy && (int)$is_free == 1) {
                    $is_heavy_free[] = $data->fields['products_id'];
                }
                $heavy_products_tag[$data->fields['products_id']] = 0; //0，正常  1.超重heavy  2.超出尺寸 oversize
            }

            $data->MoveNext();
        }
    }

    return [
        'heavy_products'=>$heavy_products,
        'heavy_products_tag'=>$heavy_products_tag,
        'is_heavy_free' => $is_heavy_free
    ];
}

//获取操作的产品数据返回google
function get_google_products_info($qty,$products_id){
    //google追踪数据统计 ternence.qin
    $proArr = $_SESSION['cart']->get_products();
    global $currencies;
    $products_info =array();
    $wholesale_products = fs_get_wholesale_products_array();
    if($proArr){
        foreach ($proArr as $k=>$v){
            if($v['id']==$products_id){
                $qty =$qty?(float)$qty:$v['quantity'];
            //    if (is_array($wholesale_products) && sizeof($wholesale_products)) {
            //         if (!in_array($_GET['products_id'], $wholesale_products)) {
            //             $products_price = $currencies->new_value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$v['id'], (int)$qty)));
            //         } else {
            //             $products_price = $currencies->value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$v['id'], (int)$qty)));
            //         }
            //     } else {
            //         $products_price = $currencies->new_value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$v['id'], (int)$qty)));
            //     }
                $products_price = zen_get_products_final_price($products_id);
                if(get_price_vat_uk_show()){
                    $products_price_tax = $products_price*1.20;
                }elseif($_SESSION['languages_code']=='au'){
                    $products_price_tax = $products_price*1.10;
                }elseif(in_array($_SESSION['languages_code'],['de','dn'])){
                    $products_price_tax = $products_price*1.19;
                }else{
                    $products_price_tax = $products_price;
                }
                $products_info = array(
                    'id'=>(string)((int)$v['id']),
                    "name"=> $v['name'],
                    "price"=> sprintf("%.2f",$products_price_tax),
                    "brand"=> "FS.COM",
                    "category"=> get_google_products_categories_str((int)$v['id']),
                    "position"=> 0,
                    "quantity"=> $qty
                );
            }
        }
    }
    return $products_info;
}


/*
 * 获取报价单第一个产品内容附带属性 ternence 2019/4/9
 * return array
 * */
function get_quote_product_info($inquiry_id,$where="",$processing_time=""){
    global $db,$currencies;
    if(is_numeric($inquiry_id)){
        $products_id = $db->getAll("select products_id,id,admin_price,products_tax_class_id,attribute_product_id,price_code,all_product_price,save_at,product_num,target_price,product_price,final_product_price from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "  where inquiry_id =".$inquiry_id." ".$where." order by id asc limit 4");
        //查询报价是否已经下单
        $customers_id= $db->Execute("select customers_id from ".TABLE_CUSTOMERS_INQUIRY." where id = ".(int)$inquiry_id." and order_id is null limit 1")->fields['customers_id'];

        //7天超时计算
        $data_type=-1;

        //根据报价单号去查询报价单号前/后台
//        $number_type = substr($inquiry_number,0,3);
//        $deskTime = 604800;//后台超时15天
//        if($number_type=='RQC'){
        $deskTime = 1296000;//前台超时15天
//        }

        if($products_id[0]['save_at']=="0000-00-00 00:00:00" && is_numeric($customers_id)){
            //直接关闭历史报价单
            $data_type=0;
            zen_db_perform(TABLE_CUSTOMER_INQUIRY,array('status'=>4), 'update', 'id=' . $inquiry_id);
        }else{
            if($processing_time){
                $admin_save_time=strtotime($processing_time);
            }else{
                $admin_save_time=strtotime($products_id[0]['save_at']);
            }

            if($admin_save_time>0 && is_numeric($customers_id)){
                $time = time()-8*3600; //线上误差8小时，测试站16小时
                $date = $time - $admin_save_time;
                if($date>$deskTime){
                    //关闭该报价单
                    zen_db_perform(TABLE_CUSTOMER_INQUIRY,array('status'=>4), 'update', 'id=' . $inquiry_id);
                    $data_type=0;
                }
            }
        }
        $productArr=[];
        foreach($products_id as $k=>$v){
            $productArr[$k] =array(
                'products_id' =>(int)$products_id[$k]['products_id'],
                'inquiry_product_id'=>$products_id[$k]['id'],
                'tax_class_id'=>$products_id[$k]['products_tax_class_id'],
                'qty'=>$products_id[$k]['product_num'],
                'final_product_price'=>$products_id[$k]['final_product_price'],
                'target_price'=>$products_id[$k]['target_price'],
                'product_price'=>$products_id[$k]['product_price'],
                'admin_price'=>$products_id[$k]['admin_price'],
                'price_code'=>$products_id[$k]['price_code'],
                'all_product_price'=>$products_id[$k]['all_product_price'],
                'data_type'=>$data_type,
                'save_at'=>$products_id[$k]['save_at'],
            );
//            if(count($products_id)==1){
//                if(count($products_id)==1){
//                if(strpos($products_id[$k]['attribute_product_id'],":")!==false){
                    //                require(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies,$_SESSION['inquiry_cart']);
                    $attributes_all_arr  = $inquiry->get_one_inquiry_products_attributes($products_id[$k]['id']);
                    $attributes = $inquiry->get_one_products_attributes_str($attributes_all_arr,(int)$products_id[$k]['products_id'],$products_id[$k]['product_num']);
                    if($attributes!=false){
                        $productArr[$k]['attributes'] =$attributes;
                    }
//                }
//                }
//            }
        }
        return $productArr;
    }
}
/***
 * 获取产品的is_heavy标签
 * add by rebirth
 *
 * @param array $products  产品id的数组
 * @return array        ['id'=>'is_heavy']
 */
function get_products_heavy_tab($products = [])
{
    global $db;
    $heavy_products = [];
    if (empty($products) && !is_array($products)) {
        return $heavy_products;
    }
    $ids = '';
    foreach ($products as $v) {
        $vv = (int)$v;
        if ($vv && ($vv == $v)) {
            $ids .= $vv . ',';
        }
    }
    $ids = substr($ids , 0 , -1);
    $sql = 'SELECT is_heavy,products_id FROM ' . TABLE_PRODUCTS . ' WHERE products_id in ( ' . $ids . ' )';
    $data = $db->Execute($sql);
    while (!$data->EOF){
        $heavy_products[$data->fields['products_id']] = $data->fields['is_heavy']; //0，正常  1.超重heavy  2.超出尺寸 oversize
        $data->MoveNext();
    }
    return $heavy_products;
}

/***
 * 获取产品的tag图板块
 * add by frankie
 * @param int $scene_id  tag图id
 * @return array        tag图数组
 */
function get_products_tag_array($scene_id){
    global $db;
    $tag_arr =array();
        $scene_img = $db->getAll("select fsi.images_url,fsi.thumb_one_url,fsi.thumb_two_url from fs_scene as fs inner join fs_scene_images as fsi using(images_id) where fs.scene_id =".$scene_id);
    if($scene_img && is_array($scene_img)){
        foreach ($scene_img as $value){
            if (!is_support_webp()) {
                if (strpos($value['images_url'], '.webp') !== false) {
                    $value['images_url'] = substr($value['images_url'], 0, strrpos($value['images_url'], '.webp'));
                }
                if (strpos($value['thumb_one_url'], '.webp') !== false) {
                    $value['thumb_one_url'] = substr($value['thumb_one_url'], 0, strrpos($value['thumb_one_url'], '.webp'));
                }
                if (strpos($value['thumb_two_url'], '.webp') !== false) {
                    $value['thumb_two_url'] = substr($value['thumb_two_url'], 0, strrpos($value['thumb_two_url'], '.webp'));
                }
            }
            $tag_arr['images_url'] = $value['images_url'];
            $tag_arr['thumb_one_url'] = $value['thumb_one_url'];
            $tag_arr['thumb_two_url'] = $value['thumb_two_url'];

        }
        $point_data =$db->Execute('select points_left,points_top,direction,main_products_id,other_products_id from fs_scene_points where scene_id ='.$scene_id);
        if($point_data->RecordCount()){
            while (!$point_data->EOF){
                $temp = array(
                    'points_left'=>$point_data->fields['points_left'],
                    'points_top'=>$point_data->fields['points_top'],
                    'direction'=>$point_data->fields['direction'],
                    'main_products_id_array'=>$point_data->fields['main_products_id'],
                    'other_products_id'=>$point_data->fields['other_products_id'],

                );
                $main_products_id = explode(';', $point_data->fields['main_products_id']);
                $temp['main_products_id'] = $main_products_id[0];

                $tag_arr['points_data'][] = $temp;
                $point_data->MoveNext();
            }
        }
    }
    return $tag_arr;
}

/***
 * 获取产品的tag图板块 传数组id
 */
function get_products_tag_by_ids($scene_id = []){
    global $db;
    $tag_arr =array();
    if ((!is_array($scene_id)) || empty($scene_id)) {
        return $tag_arr;
    }
    $scene_id = implode(',',$scene_id);
    $scene_img = $db->getAll("select fs.scene_id,fsi.images_id,fsi.images_url,fsi.thumb_one_url,fsi.thumb_two_url from fs_scene as fs inner join fs_scene_images as fsi using(images_id) where fs.scene_id  in ({$scene_id}) order by field(scene_id, ".$scene_id.")");
    if($scene_img && is_array($scene_img)){
        foreach ($scene_img as $value){

            if (!is_support_webp()) {
                if (strpos($value['images_url'], '.webp') !== false) {
                    $value['images_url'] = substr($value['images_url'], 0, strrpos($value['images_url'], '.webp'));
                }
                if (strpos($value['thumb_one_url'], '.webp') !== false) {
                    $value['thumb_one_url'] = substr($value['thumb_one_url'], 0, strrpos($value['thumb_one_url'], '.webp'));
                }
                if (strpos($value['thumb_two_url'], '.webp') !== false) {
                    $value['thumb_two_url'] = substr($value['thumb_two_url'], 0, strrpos($value['thumb_two_url'], '.webp'));
                }
            }

            $tag_arr[$value['scene_id']]['images_id'] = $value['images_id'];
            $tag_arr[$value['scene_id']]['images_url'] = $value['images_url'];
            $tag_arr[$value['scene_id']]['thumb_one_url'] = $value['thumb_one_url'];
            $tag_arr[$value['scene_id']]['thumb_two_url'] = $value['thumb_two_url'];

        }
        $point_data =$db->Execute('select scene_id,points_left,points_top,direction,main_products_id,other_products_id from fs_scene_points where scene_id in ('.$scene_id.') order by field(scene_id, '.$scene_id.')');

        if($point_data->RecordCount()){
            while (!$point_data->EOF){
                $temp = array(
                    'points_left'=>$point_data->fields['points_left'],
                    'points_top'=>$point_data->fields['points_top'],
                    'direction'=>$point_data->fields['direction'],
                    'main_products_id_array'=>$point_data->fields['main_products_id'],
                    'other_products_id'=>$point_data->fields['other_products_id'],

                );
                $main_products_id = explode(';', $point_data->fields['main_products_id']);
                $temp['main_products_id'] = $main_products_id[0];

                $tag_arr[$point_data->fields['scene_id']]['points_data'][] = $temp;
                $point_data->MoveNext();
            }
        }
    }
    return $tag_arr;
}

/***
 * 获取产品的tag图板块
 * add by frankie
 * @param  array   $data          tag图数组
 * @param  int     $products_id   产品ID
 * @return string  $tag_html      tag结构板块
 */
function get_products_tag_html($data,$products_id, $params = ''){
    $points_data = $data['points_data'];
    $tag_html ='';
    $tag_html .='<div class="new-mtp-center" ' . $params . '>';

    $tag_html .='<div class="new-mtp-img-container"><img src="'.HTTPS_IMAGE_SERVER.$data['images_url'].'" />';

    $tag_html .= get_all_points_html($points_data, $products_id);

    $tag_html .= '</div>';
    $tag_html .= '</div>';
    return $tag_html;
}

/***
 * 获取产品的锚点结构板块
 * add by frankie
 * @param  array   $data          所有的锚点数据
 * @param  int     $products_id   产品ID
 * @return string  $tag_html      锚点结构板块
 */
function get_all_points_html($points_data,$products_id = ''){
    global $currencies;
    global $db;
    $tag_html = '';
    $country_code = $_SESSION['countries_iso_code'];
    if(sizeof($points_data)){
        $direction = array(
            '向上'  => 'middle-bottom',
            '向下'  => 'middle-top',
            '向右'  => 'left-middle',
            '向左'  => 'right-middle'
        );

        foreach ($points_data as $key => $points){
            $temp_main_products_id = array();
            $auGspArr = [];

            //处理主产品ID（可能是一个，可能是2个或者是3个）
            $main_products_ids = explode(';', $points['main_products_id_array']);
            $main_products_ids_count = count($main_products_ids);
            $main_products_ids = get_products_status($main_products_ids);

            //次产品ID
            $other_products_ids = explode(';', $points['other_products_id']);
            $other_products_ids_count = count($other_products_ids);
            if($other_products_ids_count){
                //如果产品id在次产品id中，则首先展示产品id
                if((!empty($products_id)) and in_array($products_id, $other_products_ids)){
                    $temp_main_products_id[] = $products_id;
                }
            }

            //临时存放主产品id
            if (count($main_products_ids)) {
               $temp_main_products_id = array_merge($temp_main_products_id, $main_products_ids);
               $temp_main_products_id = array_unique($temp_main_products_id);//去重
            }

            $number = $main_products_ids_count - count($temp_main_products_id);
            if ($number < 0) {
                //说明$temp_main_products_id比$main_products_ids中的id要多
                $temp_main_products_id = array_slice($temp_main_products_id, 0, $number);
            }


            if ($number > 0) {  //需要从次产品id中补充
                $temp_other_products_ids = array();
                if (is_array($other_products_ids) and count($other_products_ids)) {
                    foreach ($other_products_ids as $other_products_id) {
                        if (!empty($other_products_id)) {
                            $temp_other_products_ids[] = intval($other_products_id);
                        }
                    }
                }
                if (count($temp_other_products_ids)) {
                    //需要从次产品id中补充

                    $sql = "select products_id, products_status, is_heavy, is_au_free, integer_state, products_price from products where products_id in (" . implode(',', $temp_other_products_ids) . ") and (products_status = '1') order by field(products_id, ".implode(',', $temp_other_products_ids).") limit " . $number;

                    $query = $db->Execute($sql);
                    while (!$query->EOF) {
                        if ($query->fields['products_status'] == 1) {
                            if (!in_array($query->fields['products_id'], $temp_main_products_id)) {
                                $temp_main_products_id[] = $query->fields['products_id'];
                                $auGspArr = array(
                                    'integer_state' => $query->fields['integer_state'],
                                    'products_price' => $query->fields['products_price'],
                                );
                            }
                        }
                        $query->MoveNext();
                    }
                }

            }

            //tag方向
            if(in_array($points['direction'], array_keys($direction))){
                $the_direction =$direction[$points['direction']];
            }

            $temp_main_products_id_count = count($temp_main_products_id);
            //如果主产品都没有的话，直接隐藏该tag
            if ($temp_main_products_id_count > 0) {
                $products = array();
                if ($temp_main_products_id_count) {
                    foreach ($temp_main_products_id as $key => $temp_products_id) {
                        $products_price = zen_get_new_products_final_price($temp_products_id,$auGspArr[$key]['products_price'],$auGspArr[$key]['integer_state'],$country_code);
                        $products[] = array(
                            'products_id'     => $temp_products_id,
                            'products_images' => get_resources_img($temp_products_id,120,120,'', '', '', ' style="" class="fs_scene_image" '),
                            'products_price'  => $currencies->total_format($products_price),
                            'products_name'   => zen_get_products_name($temp_products_id)
                        );
                        ;
                    }
                }

                //class  只是前端写的样式类，仅仅做调试用。
                if (count($products) == 1) {
                    $class = '';
                } else {
                    $class = 'new_Multiple_tga';
                }
                if (count($products) == 2) {
                    $class .= ' ' . 'new_Multiple_Double';
                }

                $spirit_bs_class = '';
                if (isMobile()){
                    $class  = '';
                    $class .= 'mobile_tag_html';
                    $spirit_bs_class .= 'spirit_bs_mobile';
                }

                //
                if (isMobile()) {
                    $tag_html .= '<button class="spirit_bs '.$spirit_bs_class.'" style="left: '.$points['points_left'].'%;top:'.$points['points_top'].'%">';
                    $tag_html .= '<div class="spirit_bg"></div>';
                    $tag_html .= '<div class="new_m_bg1"></div>';
                    $tag_html .= '<i class="iconfont icon show">&#xf237;</i>';
                    $tag_html .= '<i class="iconfont icon none"></i>';
                    $tag_html .= '<div class="new_m_bg_wap '.$class.'">';

                    //$tag_html .= '<div class="bubble_popup_conatainer bubble_popup_only">';
					//$tag_html .= '<div class="bubble_popup_bg"></div>';
                    $tag_html .= '<div class="bubble_popup_content">';
                    $tag_html .= '<div class="bubble_popup_dl_container">';
                    foreach ($products as $product) {
                        $tag_html .= '<dl class="bubble_popup_dl" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'.$product['products_id'].'">';
                        $tag_html .= '<dt>'.$product['products_images'].'</dt>';
                        $tag_html .= '<dd style="display:block;">
									    <p class="bubble_popup_txt">'.$product['products_name'].'</p>
									    <p class="bubble_popup_price">'.$product['products_price'].'</p>
								      </dd>';
                        $tag_html .= '</dl>';
                    }
					$tag_html .= '</div>';
					$tag_html .= '<a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close bubble_popup_close_a_mobile_tag" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>';
					$tag_html .= '</div>';
					//$tag_html .= '</div>';
                    $tag_html .= '</div>';
                    $tag_html .= '</button>';
                } else {
                    $tag_html .= '<div class="spirit_bs '.$spirit_bs_class.'" style="left: '.$points['points_left'].'%;top:'.$points['points_top'].'%">';
                    $tag_html .= '<div class="spirit_bg"></div>';
                    $tag_html .= '<div class="new_m_bg1"></div>';
                    $tag_html .= '<i class="iconfont icon show">&#xf237;</i>';
                    $tag_html .= '<i class="iconfont icon none"></i>';
                    $tag_html .= '<div class="new_m_bg_wap '.$class.'">';

                    $countP = count($products);
                    $class_car = '';
                    if ($_GET['main_page'] == 'product_info') {
                        $class_car = '<span class="listing_shopping_container"><a class="listing_shopping" href="javascript:;"><i class="iconfont icon">&#xf142;</i></a></span>';
                    }
                    if ($countP == 1) {
                        $tag_html .= '<div class="bubble-frame ' . $the_direction . '">';
						$tag_html .= '<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>';
                        $tag_html .= '<div class="bubble-arrow"></div>';
                        $tag_html .= '<div class="bubble-content">';
                        // $tag_html .= '<div class="new__mdiv_block">';
                        // $tag_html .= '<span class="iconfont icon new_m_icon_Close">&#xf092;</span>';
                        // $tag_html .= '</div>';
                        $tag_html .= '<div class="bubble_table">';
                        $tag_html .= '<div class="bubble_tr">';
                        $tag_html .= '<span onclick="ajax_get_one_product_qv_show(this)" data-product-id="' . $products[0]['products_id'] . '">';
                        $tag_html .= '<div class="bubble_td bubble_td_1">' . $products[0]['products_images'] . '</div>';

                        $tag_html .= '<div class="bubble_td bubble_td_2">';
                        $tag_html .= '<h2 class="bubble_h21" title="' . $products[0]['products_name'] . '">' . $products[0]['products_name'] . '</h2>';
                        $tag_html .= '<p class="bubble_p1">' . $products[0]['products_price'] . $class_car .'</p>';
                        $tag_html .= '<div class="tag_intock_pid tag_intock_pid_txt" id="instockShow' . $products[0]['products_id'] . '"></div>';
                        $tag_html .= '</div>';
                        $tag_html .= '</span>';
                        $tag_html .= '</div>';
                        $tag_html .= '</div>';
                        $tag_html .= '</div>';
                        $tag_html .= '</div>';
                    } else {
                        $trClass = ($countP == 2) ? "bubble_twoDem_tr" : "bubble_threeDem_tr";

                        $tag_html .= '<div class="bubble-frame ' . $the_direction . '">';
						$tag_html .= '<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>';
                        $tag_html .= '<div class="bubble-arrow"></div>';
                        $tag_html .= '<div class="bubble-content">';
                        // $tag_html .= '<div class="new__mdiv_block">';
                        // $tag_html .= '<span class="iconfont icon new_m_icon_Close"></span>';
                        // $tag_html .= '</div>';
                        $tag_html .= '<div class="bubble_table">';
                        $tag_html .= '<div class="bubble_tr ' . $trClass . '">';
                        foreach ($products as $product) {
                            $tag_html .= '<div class="bubble_td bubble_td_1">
											<span onclick="ajax_get_one_product_qv_show(this)" data-product-id="' . $product['products_id'] . '">
												' . $product['products_images'] . '
											<h2 class="bubble_h21" title="' . $product['products_name'] . '">#' . $product['products_id'] . '</h2>
											<p class="bubble_p1">' . $product['products_price'] . $class_car . '</p>
											<div class="tag_intock_pid_txt01" id="instockShow' . $product['products_id'] . '"></div>
											</span>
										</div>';
                        }

                        $tag_html .= '</div>';
                        $tag_html .= '</div>';
                        $tag_html .= '</div>';
                        $tag_html .= '</div>';
                    }
                    $tag_html .= '</div>';
                    $tag_html .= '</div>';
                }


            }

        }
    }

    return $tag_html;
}

/**
 * @function:获取在售产品
 * @param $products_ids
 * @return array
 * @author:liang.zhu
 * 2019-07-11 18:50:42
 */
function get_products_status($products_ids)
{
    global  $db;
    $temp = array();
    $temp_products_ids = array();
    if (is_array($products_ids) and count($products_ids)) {
        foreach ($products_ids as $products_id) {
            if (!empty($products_id)) {
                $temp_products_ids[] = intval($products_id);
            }
        }
    }
    if (count($temp_products_ids)) {
        $sql = "select products_id, products_status from products where products_id in (" . implode(',', $temp_products_ids) . ") order by instr('".implode(',', $temp_products_ids)."', products_id)";
        $query = $db->Execute($sql);
        while (!$query->EOF) {
            if ($query->fields['products_status'] == 1) {
                $temp[] = $query->fields['products_id'];
            }
            $query->MoveNext();
        }
    }

    return $temp;
}

/***
 * 获取用户保存购物车版本名称
 * add by Ternence
 * @param int       $id 表主键id
 * @return string   $save_cart_id 保存的名称
 */
function get_save_cart_time($id){
    global $db;
    $save_cart_id = $db->Execute("select user_save_time from customers_saved where customers_saved_id = ".(int)$id."")->fields['user_save_time'];
    return $save_cart_id;
}

/** 获取搭配产品信息
 * @param $products_id
 * @param string $type
 * @return array|string
 */
function get_match_products_info($products_id,$type='')
{
    $products = $test_tool_arr = array();
    if($type !=1){  //$type =1 是加购操作
        $test_tool_arr = get_redis_key_value($_SESSION['languages_code'] .'_'.'match_products_'. $products_id,$_SESSION['languages_code'] .'_'.'match_products_'. $products_id);
    }
    if(empty($test_tool_arr)) {
        global $db;
        $test_tool_text = $test_tool_tip = '';
        $match_title = FS_TEST_TOOL . ':';
        $sql = 'select related_test_tool,is_graphic,test_tool_text_unique_id,test_tool_tip_unique_id,match_products_type from products_related_test_tool where products_id =' . (int)$products_id . ' limit 1';
        $test_tool_obj = $db->Execute($sql);
        while (!$test_tool_obj->EOF) {
            $is_graphic = $test_tool_obj->fields['is_graphic'];
            $test_tool_arr = array(
                'related_test_tool' => $test_tool_obj->fields['related_test_tool'],
                'test_tool_text_unique_id' => $test_tool_obj->fields['test_tool_text_unique_id'],
                'test_tool_tip_unique_id' => $test_tool_obj->fields['test_tool_tip_unique_id'],
                'is_graphic' => $is_graphic,
                'match_products_type' => $test_tool_obj->fields['match_products_type']
            );
            $test_tool_obj->MoveNext();
        }
        if ($test_tool_arr) {
            //获取关联的test tool 产品信息
            $test_tool_products_str = $test_tool_arr['related_test_tool'];
            $test_tool_products = explode(';', $test_tool_products_str);
            $products_ids = '';
            foreach ($test_tool_products as $key => $test_tool) {
                $products_is = explode(':', $test_tool)[0];
                $products_ids .= $products_is . ',';
                $products[$products_is] = array(
                    'products_id' => explode(':', $test_tool)[0],
                    'quality' => explode(':', $test_tool)[1],
                );
            }
            //根据产品ID 查询主表的产品状态  products_status 状态为0 返回空
            $products_status_data = [];
            $products_ids = rtrim($products_ids, ',');
            if(!empty($products_ids)){
                $sql = 'select products_id from products where products_id in(' . $products_ids . ') and products_status =1';
                $products_status_result = $db->Execute($sql);
                while (!$products_status_result->EOF) {
                    $products_status_data[$products_status_result->fields['products_id']] = array(
                        'products_id' => $products_status_result->fields['products_id'],
                    );
                    $products_status_result->MoveNext();
                }
                foreach ($products as $kk => $product) {
                    if (!$products_status_data[$kk]) {
                        unset($products[$kk]);
                    }
                }
            }
            if ($products) {
                if ($type != 1) {
                    if (!empty($test_tool_arr['test_tool_text_unique_id'])) {
                        //获取对应语种的text_tool的文本 和提示语
                        $test_tool_text = fs_get_data_from_db_fields('content', 'table_column_languages', 'unique_id=' . (int)$test_tool_arr['test_tool_text_unique_id'] . ' and language_id=' . $_SESSION['languages_id'], '');
                        $test_tool_text = stripslashes($test_tool_text);
                    }
                    if (!empty($test_tool_arr['test_tool_tip_unique_id'])) {
                        $test_tool_tip = fs_get_data_from_db_fields('content', 'table_column_languages', 'unique_id=' . (int)$test_tool_arr['test_tool_tip_unique_id'] . ' and language_id=' . $_SESSION['languages_id'], '');
                    }
                    // 展示格式
                    if ($test_tool_arr['match_products_type'] == 2 || $test_tool_arr['is_graphic'] == 1) {//图文格式 或者是其他搭配产品的文本格式
                        $text_str = $test_tool_text;
                        //判断是否有标题
                        if (strpos($text_str, '}') !== false) {
                            $match_title_data = explode('}', $text_str);
                            $match_title = $match_title_data[0];
                            $text_str = end($match_title_data);
                        }
                        $match_products_des = explode(';', $text_str);
                        $match_products = [];
                        if (!empty($match_products_des)) {
                            $productService = new App\Services\Products\ProductService();
                            foreach ($match_products_des as $match_value) {
                                $products_info = [];
                                if ($match_value) {
                                    $match_data = explode(':', $match_value);
                                    $match_products_id = $match_data[0];
                                    $match_des = $match_data[1];
                                    $products_info = $productService->getOneProductInfo((int)$match_products_id, true);
                                    $match_products[$match_products_id] = array(
                                        'products_id' => $match_products_id,
                                        'match_products_des' => $match_des,
                                        'match_products_info' => $products_info,
                                    );
                                }
                            }
                            if (!empty($match_products)) {
                                foreach ($products as $match_key => $match) {
                                    if ($match['products_id'] == $match_products[$match_key]['products_id']) {
                                        $products[$match_key]['match_products_des'] = trim(stripcslashes($match_products[$match_key]['match_products_des']));
                                        $products[$match_key]['match_products_info'] = $match_products[$match_key]['match_products_info'];
                                    }
                                }
                            }
                        }
                    }
                    $test_tool_arr['test_tool_tip'] = $test_tool_tip;
                    $test_tool_arr['test_tool_text'] = $test_tool_text;
                    $test_tool_arr['match_title'] = $match_title;
                }
                $test_tool_arr['products_data'] = $products;
                if($type !=1){
                    set_redis_key_value($_SESSION['languages_code'] .'_'.'match_products_'.$products_id ,$test_tool_arr,7*24*3600,$_SESSION['languages_code'] .'_'.'match_products_'.$products_id . $type);
                }
            }
        }
    }
    return $test_tool_arr;
}

/*
 * 获取产品关联的test tool
 * @param int $products_id
 * @param  string $match_products_id  搭配产品ID
 * @return string $test_tool_content
 * */
function get_products_related_test_tool($products_id,$type='',$match_products_id =''){
    $test_tool_content = $match_products_des_content = '';
    $products = $final_products = $return_arr = $test_tool_arr = array();
    $test_tool_arr = get_match_products_info($products_id,$type);

    $products = $test_tool_arr['products_data'];
    if($products){
        if(!empty($match_products_id)){
            $match_products_data = explode(',',$match_products_id);
            foreach ($match_products_data as $match_value){
                $final_products[]= $products[$match_value];
            }
        }else{
            $final_products = $products;
        }
        if($type !=1) {
            if ($test_tool_arr['is_graphic'] == 1) {
                foreach ($products as $kk => $item) {
                    if ($item['match_products_des']) {
                        if ($test_tool_arr['is_graphic'] == 1) {
                            $match_products_des_content .= get_match_products_des_html($item['products_id'], $item['match_products_info'],$item['match_products_des']);
                        } else {
                            $match_products_des_content .= '<dd class="pro_item" data-match-product="' . $item['products_id'] . '">
										<a href="javascript:;"> ' . $item['match_products_des'] . '</a>
										</dd>';
                        }
                    }
                }
                if (!empty($match_products_des_content)) {
                    //HTML 结构
                    $test_tool_content = '<div class="detail_transceiver_type">
                                    <dl class="prime_attribute">
                                        <dt>' . $test_tool_arr['match_title'];
                    if ($test_tool_arr['test_tool_tip']) {
                        $test_tool_content .= getNewWordHtml(stripslashes($test_tool_arr['test_tool_tip']));
                    }
                    $test_tool_content .= '</dt>';
                    $test_tool_content .= $match_products_des_content . '</dl>
                        <div class="ccc"></div>
                        </div>';
                }
            } else {
                //拼接HTML结构 test tool 结构
                $test_tool_content .= '<div class="test_tool"><span>' . $test_tool_arr['match_title'] . '</span>';
                if ($test_tool_arr['test_tool_tip']) {
                    $test_tool_content .= getNewWordHtml(stripslashes($test_tool_arr['test_tool_tip']));
                }
                $test_tool_content .= '<dl class="Ship_To_dl"><dt><div class="ship_to_a"><label class="test_tool_lable">
                            <span class="iconfont icon test_tool_lable_icon"></span>' . $test_tool_arr['test_tool_text'] . '</label></div></dt></dl></div>';
            }
        }
    }
    $return_arr = array('test_tool_content'=>$test_tool_content, 'products_arr'=>$final_products);
    return $return_arr;
}

/** dylan 2019.8.8 Add
 * 根据国家货币展示对应免运费金额
 */
function get_currency_price(){
    $current_currency = $_SESSION['currency'] ? $_SESSION['currency'] : 'USD';
    $free_arr = array();
    //摩尔多瓦,立陶宛货币选择美元，普通产品，p产品免运金额分别为$90,$339   (属于德国仓)
    if(in_array($_SESSION['countries_iso_code'],array('LT','MD')) && $current_currency == 'USD'){
        return $free_arr = array(
                    'free_price_common' => 'US$&nbsp;90',
                    'free_price_pre' => 'US$&nbsp;399',
                );
    }
    //除上面2个特殊国家外，其余国家按照货币判断.(美东仓货币为美金,普通产品，p产品免运金额分别为$79,$299)
    switch ($current_currency){
        case 'CAD':
            $free_arr = array(
                'free_price_common' => 'C$&nbsp;105',
                'free_price_pre' => 'C$&nbsp;399',
            );
            break;
        case 'AUD':
            $free_arr = array(
                'free_price_common' => 'A$99',
                'free_price_pre' => 'A$399',
            );
            break;
        case 'MXN':
            $free_arr = array(
                'free_price_common' => 'MXN $1,600',
                'free_price_pre' => 'MXN $6,000',
            );
            break;
        case 'RUB':
            $free_arr = array(
                'free_price_common' => '20 000',
                'free_price_pre' => '20 000',
            );
            break;
        case 'DKK':
            $free_arr = array(
                'free_price_common' => '599&nbsp;DKK',
                'free_price_pre' => '2300&nbsp;DKK',
            );
            break;
        case 'EUR':
            $free_arr = array(
                'free_price_common' => '79&nbsp;€',
                'free_price_pre' => '299&nbsp;€',
            );
            break;
        case 'GBP':
            $free_arr = array(
                'free_price_common' => '£79',
                'free_price_pre' => '£299',
            );
            break;
        case 'NOK':
            $free_arr = array(
                'free_price_common' => '799&nbsp;NOK',
                'free_price_pre' => '2900&nbsp;NOK',
            );
            break;
        case 'SEK':
            $free_arr = array(
                'free_price_common' => '850&nbsp;SEK',
                'free_price_pre' => '3150&nbsp;SEK',
            );
            break;
        case 'CHF':
            $free_arr = array(
                'free_price_common' => 'CHF&nbsp;&nbsp;89',
                'free_price_pre' => 'CHF&nbsp;&nbsp;350',
            );
            break;
        default:
            $free_arr = array(
                'free_price_common' => 'US$&nbsp;79',
                'free_price_pre' => 'US$&nbsp;299',
            );
            break;
    }
    return $free_arr;
}

/** dylan 2019.8.8 Add
 *  详情页delivery & return政策弹窗信息展示
 * @param $shipping_info => shipping info类
 */
function get_shipping_info_detail($shipping_info){
    if(empty($shipping_info)){
        return '';
    }
    //预售产品
    $current_warehouse = get_warehouse_by_code(strtoupper($shipping_info->country_code),'country_code');
    $shippingInfo = '';
    $is_buck = $shipping_info->is_buck_cate();
    $country_code = $shipping_info->country_code;
    $free_arr = get_currency_price();// 根据货币得到对应金额;
    if($current_warehouse){
        switch ($current_warehouse){
            case 'us'://美东仓
                if($shipping_info->is_pre_product){//预售产品
                    $shippingInfo = str_replace('$MONEY',$free_arr['free_price_pre'],FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE);
                }else if($is_buck){//重货产品
                    $shippingInfo = FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK;
                }else{//常规产品
                    $shippingInfo = str_replace('$MONEY',$free_arr['free_price_common'],FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD);
                }
                break;
            case 'au'://澳洲仓
                if($country_code == 'AU'){
                    if($shipping_info->is_pre_product){//预售产品
                        $shippingInfo = str_replace('$MONEY',$free_arr['free_price_pre'],FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE);
                    }else if($is_buck){//重货产品
                        $shippingInfo = FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK;
                    }else{//常规产品
                        $shippingInfo = str_replace('$MONEY',$free_arr['free_price_common'],FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD);
                    }
                }else{
                    $shippingInfo = FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK;
                }
                break;
            case 'de'://德国仓
                if($shipping_info->is_pre_product){//预售产品
                    $shippingInfo = str_replace('$MONEY',$free_arr['free_price_pre'],FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE);
                }else if($is_buck){//重货产品
                    $shippingInfo = FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK;
                }else{//常规产品
                    $shippingInfo = str_replace('$MONEY',$free_arr['free_price_common'],FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD);
                }
                break;
            case 'cn'://武汉仓
                if($country_code == 'RU'){
                    $shippingInfo = str_replace('$MONEY',$free_arr['free_price_common'],FS_SHIPPING_INFO_DETAIL_RU);
                }else if(in_array($country_code,array('SG','KH','LA','MY','TL','ID','BN','MM','PH','TH','VN'))){
                    $shippingInfo = FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK;
                }else if(in_array($country_code,array('HK','TW','MO'))){
                    $shippingInfo = FS_SHIPPING_INFO_DETAIL_HK_MO_TL;
                }else{
                    $shippingInfo = FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK;
                }
                break;
        }
    }
    return $shippingInfo;
}

/**是否是清仓产品
 * @param $pid
 */
function get_current_pid_if_is_clearance($pid)
{
    global $db;
    $pid = (int)$pid;
    if (empty($pid)) {
        return false;
    }
    $rst = $db->Execute("SELECT products_id FROM  products_clearance WHERE products_id=" . $pid . ' limit 1');
    if ($rst->fields['products_id']) {
        return true;
    } else {
        return false;
    }
}

//给定 opitions_value数组 按照从小到大的顺序排序
 function reorder_options_values($options_value){
    $attr_str = '';
    if($options_value && is_array($options_value)){
        sort($options_value);
        $attr_str = join(',',$options_value);
    }
    return $attr_str;
}

/**
 * 获取未查看的报价单
 * add by ternence
 * 2019/11/26
 */
function get_quote_click_type(){
    global $db;
    if($_SESSION['customer_id']){
     $count=  $db->Execute("select count(id) from customer_inquiry where customers_id=".$_SESSION['customer_id']." and status=2 and click_type=0")->fields['count(id)'];
        return $count;
    }
}

function get_quote_checked_type_number()
{
    global $db;
    $count = 0;
    if($_SESSION['customer_id']){
        $count_res =  $db->getall("SELECT COUNT(*) as all_num FROM `fs_quotes_customers` fqc LEFT JOIN `fs_quotes` fqa ON fqc.`quotes_id`=fqa.`id` WHERE fqc.`customers_id` = ".$_SESSION['customer_id']." AND fqa.status = 1");
        $count = $count_res[0]['all_num'];
    }
    return $count;
}

/**
 * 长度属性查询
 * add by ternence
 * 2019/11/29
 */
function get_inquiry_product_length($inquiry_products_id){
    global $db;
    if($inquiry_products_id){
        $product_length_id = $db->Execute('select product_length_id from customer_inquiry_products_length where inquiry_products_id='.(int)$inquiry_products_id.'')->fields['product_length_id'];
        if($product_length_id){
            $Length = $db->Execute('select length from products_length where id='.$product_length_id.'')->fields['length'];
            if($Length){
                return $Length;
            }
        }
    }
}

/**
 * 详情页GSP项目 美国站美国本地仓无库存时 展示板块
 * @return string
 */
function get_gsp_detail_html(){
    $html = '<div class="fs-gspType-tipsWrap">
                            <p class="fs-gspType-tipsTxt01">'.FS_COMMON_GSP_2.'&nbsp;</p>
                            <div class="fs-gspType-tipsTxt02">'.FS_GSP_STOCK_6.'<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                                    <div class="question_bg_icon question_bg_grayIcon iconfont icon"></div>
                                    <div class="new_m_bg1"></div>
                                    <div class="new_m_bg_wap">
                                        <div class="question_text_01 leftjt">
											<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                                            <div class="arrow"></div>
                                            <div class="popover-content">'.(strtoupper($_SESSION['countries_iso_code']) == 'US' ? FS_GSP_STOCK_9 : FS_GSP_STOCK_7).'</div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
    return $html;
}

/**
 * canonical 产品id替换
 * @return string
 */
function get_canonical_url($url){
    $products_arr = array(
        48355=>102531,
        48853=>104847,
        48863=>104865,
        65224=>104849,
        48855=>104849,
        48857=>104853,
        48859=>104856,
        50238=>104852,
        71010=>104866
    );
    foreach($products_arr as $key=>$v){
        $url = str_replace($key,$v,$url);
    }
    return $url;
}


/**
 * 账户中心订单相关页面buy more成功后QV弹窗中需要的产品数据获取
 * @param $products：产品数组数据是OrderProductService->getOrderProductsInfo()获取的单个产品数据
 * @return array|mixed
 */
function get_orders_product_other_data($products){
    global $fs_reviews;
    global $db;
    global $fsCurrentInquiryField;
    $is_mobile = isMobile();
    $products_id = $products['products_id'];
    $sql = 'SELECT P.products_id,P.integer_state,P.products_image,P.products_price,P.products_model,P.'.$fsCurrentInquiryField.' is_inquiry,P.is_min_order_qty,P.discount,P.packing_quantity,P.products_price,P.discount_type,P.discount,PD.packing_unit,PD.products_name,PD.module1,PD.product_details,PD.module_status,PD.list_video,PD.video,PD.video_title,PD.list_video_title
     FROM '.TABLE_PRODUCTS.' P  left join '.TABLE_PRODUCTS_DESCRIPTION.' PD on PD.products_id = P.products_id and PD.language_id ="'.(int)$_SESSION['languages_id'].'" where P.products_id  = '.$products_id.' limit 1';
    $product = $db->getAll($sql);
    $product = $product[0];

    $product['id'] = $products_id;
    $product['is_min_order_qty'] =$product['is_min_order_qty']?$product['is_min_order_qty']:1;
//    if($products['products_quantity']){
//        //订单中客户购买该产品的个数
//        $product['is_min_order_qty'] = $products['products_quantity'];
//    }

    // 产品价格
    $new_product_price = zen_get_products_base_price_other($product['products_price']);
    $product['products_price_str'] = $new_product_price;

    $fs_reviews->get_product_review_rating_show($products_id,$is_mobile);
    $product['products_review_str'] = $fs_reviews->products_list_info;
    //记录订单产品的属性数据
    $product['orders_products_attributes'] = $products['orders_products_attributes'];
    $product['orders_products_length'] = $products['orders_products_length'];
    $product['is_custom'] = $products['is_custom'];
    if($products['is_custom']){
        $isNotCustom = false;
    }else{
        $isNotCustom = true;
    }
    $product['is_not_custom_str'] =  $isNotCustom;

    // 产品视频 不正确的视频格式不展示
    if(strpos($product['list_video'],'https://www.youtube.com')===false && strpos($product['list_video'],'https://img-en.fs.com')===false){
        $product['list_video'] = '';
    }
    if(strpos($product['video'],'https://www.youtube.com')===false){
        $product['video'] = '';
    }

    //产品轮播图
    $wartermark_images_all = get_one_product_all_images($product['id'],$product['products_image']);
    $product['wartermark_images_all'] = $wartermark_images_all;

    // 产品图片
    $image = get_resources_img($products_id,'180','180',$product['products_image'],$product['products_name']);
    $product_status = zen_get_products_status((int)$products_id);
    if($product_status==1 && $is_mobile){
        $image = str_replace('https://www.fs.com//images/no_picture.gif','https://img-en.fs.com/includes/templates/fiberstore/images/logo_trad.jpg',$image);
    }
    $product['image_str'] =  $image;
    return  $product;
}

function get_orders_product_qv_show_str($product, $isMobile=false)
{
    global $db;
    global $currencies;

    //处理数据
    $product['href_link'] = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product['id'], 'NONSSL');
    //处理产品名
    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
        $product['products_name'] = swap_american_to_britain( $product['products_name'] );
    }
    $show_str = '';

    //获取产品图片 start
    $wartermark_images = $product['wartermark_images_all']['wartermark_images'];
    $products_final_image_to_display = $product['wartermark_images_all']['products_final_image_to_display'];
    $product_video = $product['list_video'] ? $product['list_video'] : $product['video'];
    // 产品图片，小图列表的左右箭头
    $product_small_img_left_right_str = '';
    $wartermark_images_count = sizeof($wartermark_images['small']);
    if (($wartermark_images_count > 4 && $product_video) || ($wartermark_images_count > 5 && !$product_video)) {
        $product_small_img_left_right_str .=
            ' <div class="iconfont detail_proImg_pre" onclick="detail_proImg_pre($(this))" style="pointer-events: none; opacity: 0.35;">&#xf090;</div>
            <div class="iconfont detail_proImg_next" onclick="detail_proImg_next($(this))" style="pointer-events: auto; opacity: 1;">&#xf089;</div>';
    }
    // 产品图片的小图、大图列表
    $product_small_imgs_str = '';
    $product_big_imgs_str = '';
    // 产品图片的视频
    if ($product_video) {
        $product_small_imgs_str .= '<li class="checked_proImg_li detail_provideo" value="0">
            <a href="javascript:;"  >
                <div class="peoovideo_bg"></div>
                <span></span>
                <img src="' . $products_final_image_to_display . '"  alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '" value="0">
            </a>
        </li>';
        $sub_video = strpos($product_video, 'https://img-en.fs.com');
        if ($sub_video !== false) {
            $video_str = '<video controls="controls" id="vd_z" width="100%" src="' . $product_video . '"></video>';
        } else {
            $video_str = '<iframe class="pro_details_iframe" src="' . $product_video . '" allow="autoplay; encrypted-media" allowfullscreen="" frameborder="0" width="100%" height="auto"></iframe>';
        }
        $product_big_imgs_str .= '<li class="detail_proImg_new_listLi" value="0">
            <div class="play_proDetail_video">
                <div class="play_proDetail_video">'
            . $video_str .
            '</div>
           </div>
        </li>';
    }
    $init_products_image_i = $product_video ? 1 : 0;
    if (!count($wartermark_images)) {
        if(strstr($products_final_image_to_display,'images/no_picture.gif')){
            $products_final_image_to_display = HTTPS_IMAGE_SERVER.'/includes/templates/fiberstore/images/logo_trad.jpg';
        }
        $product_small_imgs_str .=
            '<li class="checked_proImg_li" value="' . $init_products_image_i . '">
            <a href="' . $products_final_image_to_display . '">
                <img alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '" src="' . $products_final_image_to_display . '" value="' . $init_products_image_i . '">
            </a>
        </li>';
        $product_big_imgs_str .= '<li class="detail_proImg_new_listLi" value="' . $init_products_image_i . '">
                <a href="' . $products_final_image_to_display . '">
                    <img src="' . $products_final_image_to_display . '" width="340" height="340" alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '" >
                </a>
            </li>';
    } else {
        $product_status = zen_get_products_status($product['id']);
        if(strstr($wartermark_images['big'][0],'images/no_picture.gif') && $product_status!=0){
            $wartermark_images['big'][0] = HTTPS_IMAGE_SERVER.'/includes/templates/fiberstore/images/logo_trad.jpg';
        }
        $n = sizeof($wartermark_images['small']);
        $products_image_i = $init_products_image_i;
        if($product_video){
            $product_small_imgs_str .=
                '<li class="checked_proImg_li choosez" value="1">
                <a href="javascript:;">
                    <img value="' . $products_image_i . '" alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '" src="' . $products_final_image_to_display . '" >
                </a></li>';
            $product_big_imgs_str .= '<li class="detail_proImg_new_listLi"  value="1">
               <a class="proImg_alink" href="javascript:;">
                    <img src="' . $wartermark_images['big'][0] . '" width="340" height="340" alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '">
                </a>
            </li>';
        }
        while ($products_image_i < $n) {
            if($product_video){
                $choosez_str = '';
                $product_value = $products_image_i+1;
                $first = -352;
            }else{
                $choosez_str = ($products_image_i==0)?'choosez':'';
                $product_value = $products_image_i;
                $first = 0;
            }
            $product_small_imgs_str .=
                '<li class="checked_proImg_li ' . $choosez_str . '" value="' . $product_value . '">
                <a href="javascript:;">
                    <img value="' . $products_image_i . '" alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '" src="' . $wartermark_images['small'][$products_image_i] . '">
                </a></li>';
            $product_big_imgs_str .= '<li class="detail_proImg_new_listLi" value="' . $product_value . '">
               <a class="proImg_alink" href="javascript:;">
                    <img src="' . $wartermark_images['big'][$products_image_i] . '" width="340" height="340" alt="' . $product['products_name'] . '" title="' . $product['products_name'] . '">
                </a>
            </li>';
            $products_image_i++;
        }
    }
    //获取产品图片 end

    //定制产品属性展示板块
    $attr_show_str = '';
    $attr_price = 0;    //属性价格
    if($product['is_custom']){
        $lengthPrice = [];
        $length_s = 1;
        $attr_show_str .= '<ul class="buy_more_attribute">';
        if(!empty($product['orders_products_attributes'])){
            $options_id = $values_id = $attributes = $options_name = $values_name = [];
            foreach($product['orders_products_attributes'] as $key=>$value){
                $options_id[] = $value['options_id'];
                $values_id[] = $value['values_id'];
                $attributes[$value['options_id']][$value['values_id']] = 0;
            }
            //查找属性项和属性值名称
            if(sizeof($options_id)){
                $option_query = $db->Execute("SELECT `products_options_id`,`products_options_name` FROM `products_options` WHERE `products_options_id` IN(".join(',', $options_id).") AND language_id=".$_SESSION['languages_id']);
                while(!$option_query->EOF){
                    $options_name[$option_query->fields['products_options_id']] = $option_query->fields['products_options_name'];
                    $option_query->MoveNext();
                }
            }
            if(sizeof($values_id)){
                $value_query = $db->Execute("SELECT `products_options_values_id`,`products_options_values_name` FROM `products_options_values` WHERE `products_options_values_id` IN(".join(',', $values_id).") AND language_id=".$_SESSION['languages_id']);
                while(!$value_query->EOF){
                    $values_name[$value_query->fields['products_options_values_id']] = $value_query->fields['products_options_values_name'];
                    $value_query->MoveNext();
                }
            }
            foreach($product['orders_products_attributes'] as $kk=>$vv){
                $attr_show_str .= '<li>'.$options_name[$vv['options_id']].' - '.$values_name[$vv['values_id']].'</li>';
            }
        }

        if(!empty($product['orders_products_length'])){
            $attr_show_str .= '<li>'.FS_LENGTH_NAME.' - '.$product['orders_products_length']['length_name'].'</li>';
            $lengthPrice = get_length_range_price($product['id'],$product['orders_products_length']['length_name']);
            $length_s = str_replace("k", "", $product['orders_products_length']['length_name']);
            $length_s = str_replace("m", "", $length_s);
        }
        $attr_show_str .= '</ul>';
        //获取选中属性的价格
        $attrPrice = get_products_all_attribute_price_new($product['id'], $attributes, $length_s);
        $attr_price = $attrPrice + $lengthPrice['length_price'];
    }
    //产品库存部分
    $instock_info_str = '';
    //邮编，交期
    $product_postcodes_str='';
    $shippingInfo = new shippingInfo(array('pid' => $product['id']));

    if($isMobile){
        $shippingInfo->main_page = 'index';
        $instock_info_str = $shippingInfo->showIntockDate($product['is_not_custom_str'],1,$product['products_price_str']);
    }else{
        if($product['is_inquiry'] != 1){
            $instock_info_str = $shippingInfo->get_warehouse_instock_qty('','','details');
            $product_postcodes_str = '
            <div class="pro_postcode_system_box" id="pro_postcode_system"><div>'.$shippingInfo->showProductsListPost().'</div></div>
            <div class="shipping_text">'.$shippingInfo->get_warehouse_shiping_policy($product['products_price_str'],false,2).'</div>';
        }
    }


    // 清仓原价展示
    $clearance_price_sql = $db->Execute('select replace_products,replace_products_tip,products_clearance_price from products_clearance where products_id ='.$product['id']);
    $clearance_price = $clearance_price_sql->fields['products_clearance_price'];
    //清仓产品提示语
    $products_clearance['replace_products'] = $clearance_price_sql->fields['replace_products'];
    $products_clearance['replace_products_tip'] = $clearance_price_sql->fields['replace_products_tip'];

    $is_clearance = $clearance_price && $clearance_price > 0;
    $is_clearance = $is_clearance ? 1 : 0;
    $cn_and_local_qty = 0;
    $define_clearance = '';
    $choosez = '';
    $disabled = '';

    //清仓产品限制加购
    if($is_clearance==1){
        $cn_and_local_qty = $shippingInfo->getLocalAndWuhanqty();
        //$define_clearance .= $cn_and_local_qty ? QV_CLEARANCE_TIPS : QV_CLEARANCE_EMPTY_QTY_TIPS;

        if ($products_clearance) {
            $products_clearance['replace_products'] = explode(';', $products_clearance['replace_products']);
            $products_clearance['replace_products'] = array_filter($products_clearance['replace_products']);
            if (count($products_clearance['replace_products'])) {
                $products_clearance_replace = current($products_clearance['replace_products']);
                //有替代产品
                if ($cn_and_local_qty > 0 ) {
                    $define_clearance = FS_CLEARANCE_TIP_01_01.' '.FS_CLEARANCE_TIP_01_02;
                    $define_clearance = str_replace(array('$QTY', '$PRODUCTS_ID'), array($cn_and_local_qty, $products_clearance_replace), $define_clearance);
                } else {
                    $define_clearance = FS_CLEARANCE_TIP_02_01.' '.FS_CLEARANCE_TIP_02_02;
                    $define_clearance = str_replace(array('$QTY', '$PRODUCTS_ID'), array($cn_and_local_qty, $products_clearance_replace), $define_clearance);
                }

            } else {
                //对于无替代或者不可定制产品
                if ($cn_and_local_qty > 0 ) {
                    $define_clearance = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                    $define_clearance = str_replace(array('$QTY'), array($cn_and_local_qty), $define_clearance);
                } else {
                    $define_clearance = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
                }
            }

        } else {
            //对于无替代或者不可定制产品
            if ($cn_and_local_qty > 0 ) {
                $define_clearance = FS_CLEARANCE_TIP_03_01.' '.FS_CLEARANCE_TIP_03_02;
                $define_clearance = str_replace(array('$QTY'), array($cn_and_local_qty), $define_clearance);
            } else {
                $define_clearance = FS_CLEARANCE_TIP_04_01.' '.FS_CLEARANCE_TIP_04_02;
            }
        }



        if($cn_and_local_qty<2){
            $choosez = ' choosez';
        }
        if($cn_and_local_qty==0){
            $disabled = ' disabled';// 清仓产品库存为0,数量输入框禁用
        }
    }
    //产品数量增加部分
    $products_number_info = $numberCommonStr = '';
    $min_qty = $product['is_min_order_qty'] >= 1 ? $product['is_min_order_qty'] : '1';
    $box_number = $is_pack = 0; //订单产品buy more的qv弹窗不展示装箱
    $products_number_info_id = 'qv_quantity_' . $product['id'];
    $products_number_info .= '
        <span class="qtyTxt" '.(in_array($_SESSION['languages_code'],array('de','es','mx','fr')) ? 'style="display:none"' : "").'>' . FS_COMMON_QTY_SMALL . ':</span>
        <div class="newPro_common_num_cont product_03_08 product_03_24">';

    $numberCommonStr = '<input type="text" id="' . $products_number_info_id . '" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  min="1" onfocus="q_enterKey(this,' . $product['id'] . ')" value="' . $min_qty . '"  autocomplete="off" class="p_07 product_03_10"  onblur="fslocking(' . $product['id'] . ',' . $product['is_min_order_qty'] . ',' . $box_number . ',' . $is_pack . ',' . $is_clearance . ',' . $cn_and_local_qty . ');" '.$disabled.'>
    <div class="pro_mun">
        <a href="javascript:;" onclick="common_cart_quantity_change(1,this,\'qv\',' . $product['id'] . ',' . $is_pack . ',' . $box_number . ',' . $is_clearance . ',' . $cn_and_local_qty . ')" class="cart_qty_add '.$choosez.'"><span class="iconfont icon">&#xf088;</span></a>
        <a href="javascript:;" onclick="common_cart_quantity_change(0,this,\'qv\',' . $product['id'] . ',' . $is_pack . ',' . $box_number . ',' . $is_clearance . ',' . $cn_and_local_qty . ')" class="cart_qty_reduce cart_reduce '.($disabled ? $choosez : "").'"><span class="iconfont icon">&#xf087;</span></a></div> ';
    $products_number_info .= $numberCommonStr;
    $products_number_info .= '</div>';

    //价格部分
    $add_to_cart = FS_ADD_TO_CART;
    $options_value = [];
    $product_price = zen_get_products_final_price($product['id'], '', $options_value, false)+$attr_price;
    $jpTotalPrice = 0;  //jp站点当前币种不是日元时，也需要展示日元价格
    if($_SESSION['languages_code'] == 'jp' && $_SESSION['currency']!='JPY'){
        $jpTotalPrice = zen_get_products_final_price((int)$product['id'],'JPY') + $attr_price;
    }
    $priceText = $currencies->total_format($product_price);
    $priceData = getAfterVatPrice($product_price, $priceText, $product['id'], $jpTotalPrice);
    if($_SESSION['countries_iso_code'] == 'au'){
        $priceTextHtml = $priceData['taxPrice'];
    }else{
        $priceTextHtml = $priceData['totalPrice'] . $priceData['taxPrice'];
    }
    $products_price_info = '<div class="detail_proPrice" id="productsbaseprice">'.$priceTextHtml.'<div class="ccc"></div></div>';
    //添加到购物车按钮部分
    $products_btn_info = '';
    //$products_btn_common 点击加入购物车按钮部分M端和PC端共用结构
    $btn_class = ' class="new_pro_addCart_btn" ';
    if($isMobile){
        $btn_class = ' class="account_alone_a a_red" ';
    }
    $products_btn_common ='<button type="submit" data-products-id="'.$product['id'].'" onclick="buy_more(\''.$product['from_orders_id'].'\', \''.$product['from_orders_products_id'].'\',\''.$product['from_orders_number'].'\', 2, this)" name="Add to Cart" value="'.$add_to_cart.'" '.$btn_class.' placeholder="">
					<div class="new_pro_addCart_mainDev after">
					<span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>'.$add_to_cart.'
					</div>
					<div class="new_addCart_loading choosez">
						<div class="new_chec_bg"></div>
						<div class="loader_order">
							<svg class="circular" viewBox="25 25 50 50">
								<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
							</svg>
						</div>
					</div>
				</button>';
    $products_btn_info .= '<div>'.$products_btn_common.'</div>';
    $orderHref = sprintf(FS_BUY_MORE_02, '<a href="'.reset_url('/index.php?main_page=account_history_info&orders_id='.$product['from_orders_id']).'" target="_blank">#'.$product['from_orders_number'].'</a>');
    if(!$isMobile){ //pc端QV弹窗结构
        $show_str .= '
            <div class="qv_detail_clearBox">
                <div class="detail_proLeft">
                    <div class="detail_proImg_top">
                        <div class="featurePics_proImg">
                            <ul class="detail_proImg_new_list" style="position: absolute;left: '.$first.'px;">'
                .$product_big_imgs_str.
                '</ul>
                        </div>
                    </div>
                    <div class="qv_hidden_img_div" style="display: none;">'.$product['image_str'].'</div>
                    <div class="detail_proImg_bottom">
                        <div class="proImg_check_carousel">'
                .$product_small_img_left_right_str.
                '<div class="proImg_check_carousel_cont swiper-container-horizontal">
                                <ul class="detail_proImg_new_btList" style="width: 770px;">
                                    '.$product_small_imgs_str.'
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="detail_proRight">
                    <span class="new_pro_QVclose iconfont icon" onclick="hide_product_qv_show();">&#xf092;</span>
                    <div class="detail_proDecribe_tit">
                        <h1><a href="'.$product['href_link'].'" target="_blank">'.$product['products_name'].'</a></h1><span>#'.$product['id'].'</span>
                    </div>
                    '.$attr_show_str.'
                    <div class="detail_proAssess_starNum">
                        <div class="new_proList_ListBstarBox">
                            '.$product['products_review_str'].'
                        </div>
                        '.$products_price_info.'
                    </div>
                    <div class="location_text">
                        <div class="product_03_01 product_03_13  detail_seattle_z">
                            '.$instock_info_str.$product_postcodes_str.'                           
                        </div>
                    </div>
                    <!--QV tips-->
                    <div class="custom_product_tips_fa" style="display: none;">
                            <p class="custom_product_tips" id="option_remark" style="display: inline-block;"><i class="iconfont icon">&#xf228;</i><span>'.$define_clearance.'</span></p>
                            
                    </div>
                    <div class="newDetail_addCart_box">'
                .$products_number_info.$products_btn_info.
                '</div>
                    <div class="public_Prompt"><i class="iconfont icon">&#xf071;</i>'.$orderHref.'</div>
                </div>
            </div>';
    }else{  //M端QV弹窗结构
        $show_str .= '<div class="alert_alone_bg"></div>
				<div class="alert_content alert_alone_680">
					<p class="alert_alone_tit">'.FS_BUY_MORE_01.'<em class="iconfont icon alert_alaose" onclick="$(\'#add_qv_m\').hide();">&#xf092;</em></p>
					<div class="alert_popup_content">
						<dl class="buy_more_dl after">
							<dt><a href="'.$product['href_link'].'" target="_blank">'.$product['image_str'].'</a></dt>
							<dd>
								<p class="buy_more_tit"><a href="'.$product['href_link'].'" target="_blank">'.$product['products_name'].'</a></p>
								'.$attr_show_str.'
								<div class="pro_star_container">
									'.$product['products_review_str'].'
								</div>
								<p class="buy_pice">'.$priceText.'</p>
								<div class="new_proList_ListBtxt1">'.$instock_info_str.'</div>
								<div class="add_subtract_button">
									'.$numberCommonStr.'
								</div>
							</dd>
						</dl>
						<div class="but_more_bottom">
							<div class="public_Prompt"> <i class="iconfont icon"></i>'.$orderHref.'</div>
							'.$products_btn_common.'
						</div>

					</div>
				</div>';
    }
    return $show_str;
}

/**
 * Dylan 2020.6.9
 * @param array $related_attributes_array wdm模块分类属性关联数据展示
 * @param string $title wdm库存展示标题
 * @return string
 */
function get_wdm_wavelength_attribute_html($related_attributes_array = [], $title = ''){
    $wdm_html = '';
    $total = 0;
    $productIds = [];
    if(empty($related_attributes_array)){
        return $wdm_html;
    }
    $table_header = '<table>
                    <thead>
                        <tr>
                            <th width="20%">' . FS_STOCK_LIST_OTHER_ID . '</th>
                            <th width="47%">' . FS_WDM_WAVELENGTH_NM . '</th>
                            <th width="33%">' . FS_STOCK_LIST_STOCK . '</th>
                        </tr>
                    </thead>
                    <tbody>';
    $table_footer = '</tbody></table>';
    foreach ($related_attributes_array as $value){
        if($value['eng_name'] == 'Wavelength' && !empty($value['product_list'])){
            //转换成索引数组
            $product_list = array_values($value['product_list']);
            $total = count($product_list);
            $j = ceil($total/2);
            for ( $i=0; $i<$j*2; $i++ ) {
                $products_id = (int)$product_list[$i]['product_id'];
                $wavelength = '';
                //if(!empty($products_id)){
                $instockHtml = $style = '';
                    if(!empty($products_id)){
                        $url = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $products_id);
                        $productIds[] = $products_id;
                        $instockHtml = '<span></span><em id="wdm_stock_'.$products_id.'"></em>';
                    }
                    $productHref = $products_id ? '<a href="' . $url . '" target="_blank">' . $products_id . '</a>' : '&nbsp;';

                    $wavelength = $product_list[$i]['attribute_val'];
                    if(!empty($product_list[$i]['wavelength'])){
                        $wavelength .= ' (' . $product_list[$i]['wavelength'] . ')';
                    }

                    if($i < $j){
                        if($i == 0){
                            $wdm_html .= $table_header;
                        }
                        $wdm_html .= '<tr>
                                    <td>'.$productHref.'</td>
                                    <td>' . $wavelength .'</td>
                                    <td>'.$instockHtml.'</td>
                                </tr>';
                        if($i == $j-1){
                            $wdm_html .= $table_footer;
                        }
                    }else{
                        $width1 = '';
                        $width2 = '';
                        $width3 = '';

                        if(isMobile()){
                            $width1 = 'width="20%"';
                            $width2 = 'width="47%"';
                            $width3 = 'width="33%"';
                        }

                        if($i == $j){
                            $wdm_html .= $table_header;
                        }

                        if (isMobile() && $products_id || !isMobile()) {
                            $wdm_html .= '<tr>
                                    <td '.$width1.'>'.$productHref.'</td>
                                    <td '.$width2.'>'.$wavelength.'</td>
                                    <td '.$width3.'>'.$instockHtml.'</td>
                                </tr>';
                        }
                        if($i == $j*2-1){
                            $wdm_html .= $table_footer;
                        }
                    }
               // }
            }
        }
    }
    if(!empty($wdm_html)) {
        $more = '';
        if($total > 18 && !isMobile()){ //pc端
            $more .= '<div class="new-proDetail-tree-moreBtn product-description-table-more-less after" data-less="'.FS_COMMON_SEE_LESS.'" data-more="'.FS_COMMON_SEE_MORE.'">
                        <span>'.FS_COMMON_SEE_MORE.'</span>
                        <span class="iconfont icon">&#xf087;</span>
                    </div>';
        }
        if(isMobile() && $total > 9){ //m端
            $more .= '<div class="new-proDetail-tree-moreBtn product-description-table-more-less after" data-less="'.FS_COMMON_SEE_LESS.'" data-more="'.FS_COMMON_SEE_MORE.'">
                        <span>'.FS_COMMON_SEE_MORE.'</span>
                        <span class="iconfont icon">&#xf087;</span>
                    </div>';
        }
        $wdm_html = '<div class="p_con_new_tit03">'.$title.'</div>
                        <div class="product-description-table">
                            <div class="product-description-table-main after">
                            '.$wdm_html.'
                            </div>
                            '.$more.'
                        </div>';
    }
    return array('html' => $wdm_html, 'productIds' => $productIds);
}

function get_customers_is_old($email_address)
{
    global $db;
    if (!$admin_id) {
        $email_sql = 'SELECT c.customers_id,atc.admin_id  FROM customers c inner join admin_to_customers atc on(c.customers_id=atc.customers_id) where atc.admin_id is not null and c.customers_email_address ="' . $email_address . '"';
        $email_res = $db->Execute($email_sql);
        $admin_id = $email_res->fields['admin_id'];
        $admin_id_from_table = 'admin_to_customers';
    }

    if (!$admin_id) {
        $email_sql = 'SELECT admin_id  FROM customers_offline where admin_id != 0 and customers_email_address = "' . $email_address . '"';
        $email_res = $db->Execute($email_sql);
        $admin_id = $email_res->fields['admin_id'];
        $admin_id_from_table = 'customers_offline';
    }

    /*邮箱完全匹配结束*/

    /*邮箱后缀匹配开始,排除公共邮箱后缀*/
    if (!$admin_id) {
        //如果是销售帮客户下单注册,那么分给自己的后台账号,其他分给测试账号
        $company_mail = array('@fiberstore.com', '@fs.com', '@szyuxuan.com', '@feisu.com');
        $company_email_tail = strrchr($email_address, '@');
        $company_email_tail = strtolower($company_email_tail);
        if (in_array($company_email_tail, $company_mail)) {
            $res = $db->Execute("select admin_id,admin_level from admin where admin_email = '" . $email_address . "' and admin_level in (2,5,13) ");
            if ($res->fields['admin_id']) {
                $admin_id = $res->fields['admin_id'];
            } else {
                $email_prefix = substr($email_address, 0, (stripos($email_address, '@') + 1));
                $res2 = $db->Execute("select admin_id,admin_level from admin where admin_email like '" . $email_prefix . "%' and admin_level in (2,5,13) ");
                if ($res2->fields['admin_id']) {
                    $admin_id = $res2->fields['admin_id'];
                } else {
                    $admin_id = 117; //测试账号
                }
            }
            $admin_id_from_table = 'admin_fs';
        }

        $pub_mail = zen_get_public_mail_suffix(); //获取公共邮箱后缀
        $email_tail = strrchr($email_address, '@');
        $email_tail = strtolower($email_tail);
        if ($email_tail && !in_array($email_tail, $pub_mail)) {

            if (!$admin_id) {//验证customers是否有类似邮箱
                $email_sql = 'SELECT c.customers_id ,atc.admin_id FROM customers c inner join admin_to_customers atc on(c.customers_id=atc.customers_id) where atc.admin_id >0 and c.is_disabled = 0 and c.customers_email_address like "%' . $email_tail . '" and c.is_disabled=0 order by customers_id desc limit 1 ';
                $email_res = $db->Execute($email_sql);
                $admin_id = $email_res->fields['admin_id'];
                $admin_id_from_table = 'customers_like';
            }

            if (!$admin_id) {//验证线下客户是否有类似邮箱
                $email_sql = 'SELECT admin_id  FROM customers_offline where admin_id !=0 and customers_email_address like "%' . $email_tail . '" and is_disabled = 0 order by customers_id desc limit 1 ';
                $email_res = $db->Execute($email_sql);
                $admin_id = $email_res->fields['admin_id'];

                $admin_id_from_table = 'customers_offline_like';
            }
        }
    };
    /*邮箱后缀匹配结束*/

    if ($admin_id) {//判断管理员是否存在
        $admin_sql = "SELECT admin_name FROM admin WHERE admin_id=" . $admin_id . "";
        $res = $db->Execute($admin_sql);
        if (!$res->fields['admin_name']) {
            $admin_id = null;
            $admin_id_from_table = '';
        }
    }
//邮箱匹配到了 标记老客户 用于统计
    if ($admin_id) {
        $is_old = 1;
    } else {
        $is_old = 0;
    }
    return $is_old;
}

/**
 * Ternence 2020.7.7
 * @param int $product_id  产品ID
 * @return string
 */
function zen_get_product_download($product_id){
    global $db;
    if($product_id){
        $new_files_id = $db->Execute("SELECT files_id FROM resources_download_products WHERE products_id = ".$product_id." and is_newest=1 limit 1")->fields['files_id'];
        $product_info='';
        if((int)$new_files_id>0){
            $product_info = $db->Execute("select file_name,file_title,file_description,file_url,file_size,file_type,file_add_time from resources_download_files where language_id = ".$_SESSION['languages_id']." and status = 1 and file_type_group=1 and file_type='Software' and id =".$new_files_id." order by sort=0,sort asc limit 1");
        }else{
            $product_info = $db->Execute("select file_name,file_title,file_description,file_url,file_size,file_type,file_add_time from resources_download_files where language_id = ".$_SESSION['languages_id']." and status = 1 and file_type_group=1 and file_type='Software' and id IN (SELECT files_id FROM resources_download_products WHERE products_id = ".$product_id." ) order by sort=0,sort asc limit 1");
        }
        $file_url = $db->Execute("select file_url from resources_download_files where language_id = ".$_SESSION['languages_id']." and status = 1 and file_type_group=1 and file_type='Release Note' and id IN (SELECT files_id FROM resources_download_products WHERE products_id = ".$product_id.") order by sort=0,sort asc limit 1")->fields['file_url'];
        $product_info->fields['file_url_pdf'] = $file_url;
        return $product_info;
    }
}

/**
 * Ternence 2020.7.7
 * @param int $product_id  产品ID
 * @return string
 */
function subscription_mail_type($product_id){
    global $db;
    if($product_id && $_SESSION['customer_id']){
        $type = $db->Execute("select type from switch_mail_subscription where customers_id=".$_SESSION['customer_id']." and product_id=".$product_id."")->fields['type'];
        if(!empty($type)){
            return $type;
        }else{
            return 2;
        }
    }
}

/**
 * $Notes: 获取列表页分类信息
 *
 * $author: Quest
 * $Date: 2020/8/28
 * $Time: 10:33
 * @param $c_id
 * @return array
 */
function get_list_categories_info($c_id)
{
    global $db;
    $the_categories_name_query = "SELECT categories_name,categories_list_image,categories_list_image_mobile,categories_list_image_app,categories_list_description FROM " . TABLE_CATEGORIES . " c LEFT JOIN ". TABLE_CATEGORIES_DESCRIPTION ." cd ON c.categories_id = cd.categories_id WHERE c.categories_id= '" . $c_id . "' and cd.language_id= '" . (int)$_SESSION['languages_id'] . "'";

    $the_categories_name = $db->Execute($the_categories_name_query);
    //uk/au转换成英式英语
    if (in_array($_SESSION['languages_code'], array('au', 'uk', 'dn'))) {
        $the_categories_name->fields['categories_name'] = swap_american_to_britain($the_categories_name->fields['categories_name']);
    }
    $cate_arr = array(
        'categories_name' => $the_categories_name->fields['categories_name'],
        'pc_desc_img' => $the_categories_name->fields['categories_list_image'],
        'mobile_desc_img' => $the_categories_name->fields['categories_list_image_mobile'],
        'app_desc_img' => $the_categories_name->fields['categories_list_image_app'],
        'desc_text' => $the_categories_name->fields['categories_list_description']
    );
    return $cate_arr;
}

/** 获取搭配产品描述HTML
 * @param $products_id
 * @param $product_info
 * @param $match_products_des
 * @param $current_pid //详情页当前产品ID
 * @return string
 */
function get_match_products_des_html($products_id,$product_info,$match_products_des='',$current_pid=0){
    $thumb_html = '';
    if($products_id){
        global $currencies;
        //产品信息
        if ($product_info) {
            $products_price = $product_info['products_price'];
            // 产品价格
            $new_product_price = zen_get_products_base_price_other($products_price);
            $currency = $_SESSION['currency'] ? $_SESSION['currency'] : 'USD';
            $currency_value = $currencies->currencies[$currency]['value'];
            if ($product_info['integer_state'] == 0) {
                $new_product_price = get_products_all_currency_final_price($new_product_price * $currency_value);
            } else {
                $new_product_price = get_products_specail_currency_final_price($new_product_price * $currency_value);
            }
            //返回的仍然是美元为单位的价格
            $new_product_price = $new_product_price / $currency_value;
            // 澳大利亚税后价在是否取整之后*1.1
            $new_product_price = get_gsp_tax_price($_SESSION['countries_iso_code'], $new_product_price);
            $total_price_text = $currencies->total_format($new_product_price);
            $priceData = getAfterVatPrice($new_product_price,$total_price_text,$products_id,'');
            //产品库存
            $shippingInfo = new shippingInfo(array('pid' => $products_id, 'current_category' => [0]));
            $stockHtml = $shippingInfo->showIntockDate(false,1);
            if(!empty($match_products_des)){
                $thumb_html .= '<dd class="pro_item match_products" data-match-product="' . $products_id . '">
								<a href="javascript:;">' . $product_info['source_image']['small_thumb_image'] . $match_products_des . '</a>';
            }
            if($products_id == $current_pid){
                $href =  'javascript:;';
                $target = '';
            }else{
                $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$products_id,'NONSSL');
                $target = 'target="_blank"';
            }

            $thumb_html .= ' <div class="slight_thumbnail">
                                    <div class="bubble-arrow"></div>
                                    <div class="slight_thumbnail_dl"><a href="'. $href.'"  '.$target.'>' . $product_info['source_image']['big_thumb_image'] . '</a>
                                        <div class="slight_thumbnail_txt_container">
                                            <p class="slight_thumbnail_tit"><a href="'. $href.'"  '.$target.'>' . $product_info['product_description']['products_name'] . '</a></p>
                                            <p class="slight_thumbnail_price">' . $priceData['totalPrice'] . $priceData['taxPrice']. '</p>
                                            <div class="slight_thumbnail_stock">' . $stockHtml . '</div>
                                        </div>
                                    </div>
                                </div>
				           ';
            if(!empty($match_products_des)) {
                $thumb_html .= '</dd>';
            }
            }
        }
    return $thumb_html;
}

/**
 * * 获取一个产品的线上总销量
 * @param $products_id
 * @param int $categories_id 产品所属的二级分类
 * @return int|string
 */
function get_products_sale_total_num($products_id, $categories_id=0){
    $num = 0;
    if($products_id){
        if(!$categories_id){
            $path_arr = zen_get_product_path($products_id);
            $categories_id = $path_arr[1];
        }
        $salesData = [];
        $salesDataResult = get_redis_key_value($categories_id, 'products_total_sale_cPath_');
        $flag = false;
        if($salesDataResult===false){
            $flag = true;
        }else{
            $salesData = $salesDataResult;
            $products_key = array_keys($salesData);
            if(!in_array($products_id,$products_key)){
                $flag = true;
            }
        }
        if($flag){
            $saleService = new App\Services\Products\ProductsSalesStatisticsService();
            $saleService->products_id = $products_id;
            $saleService->getStatisticTotalSales($salesData);
            set_redis_key_value($categories_id,$salesData,2*3600,'products_total_sale_cPath_');
        }
        $num = $salesData[$products_id];
    }
    return $num;
}

/**
 * 产品的最终展示的总销量展示规则
 * ery 2020.11.27 add
 * @param int $number
 * @return string
 */
function products_total_sales_show($number){
    //展示逻辑
    $number_len = strlen($number);
    if($number_len <=3){
        $number_str = $number;
    }else{
        $substr_len =  0;
        $unit = '';
        if($number_len > 3 && $number_len <7){
            $substr_len = $number_len -2;
            $unit = 'K';
        }else{
            $substr_len = $number_len -5;
            $unit = 'M';
        }
        $number_start = substr($number,0,$substr_len);
        $number_start_len = strlen($number_start)-1;
        $point_start = substr($number_start,0,$number_start_len);
        $point_end =  substr($number_start,$number_start_len,1);
        if($point_end !=0){ //如果末尾是0  则无需拼接
            $number_str = $point_start . '.'.$point_end .$unit;
        }else{
            $number_str = $point_start .$unit;
        }
    }
    return $number_str;
}

/**
 * $Notes: 获取组合产品
 *
 * $author: Quest
 * $Date: 2020/12/31
 * $Time: 19:02
 * @param $products_id
 * @param $qty
 * @return array|string
 */
function zen_get_products_composite($products_id, $qty)
{
    $products_composite_str = '';
    if(class_exists('classes\CompositeProducts')) {
        $CompositeProducts = new classes\CompositeProducts(zen_get_prid($products_id));
        $products_composite_str = $CompositeProducts->get_products_composite($qty, '', '', true, '', false);
    }
    return $products_composite_str;
}

// 分类的where条件
function get_sub_categories_sql($current_category_id){
    $category_where_sql = '';
    if (zen_has_category_subcategories($current_category_id)) {
        $all_subcategories_ids = array();
        $where_clearing = ' and is_clearing = 0 ';
        //查找当前分类下的所有子分类调用redis缓存函数
        zen_get_subcategories_redis($all_subcategories_ids, $current_category_id, $where_clearing);
        $all_subcategories_ids[] = $current_category_id;
        $all_subcategories_ids = array_unique($all_subcategories_ids);
        $count_of_subcategories = sizeof($all_subcategories_ids);
        if ($count_of_subcategories){
            if (1 < $count_of_subcategories) {
                $category_where_sql = " and ptc.categories_id in(".join(',',$all_subcategories_ids).")";
            }else if (1 == $count_of_subcategories) {
                $category_where_sql = " and ptc.categories_id = ".$all_subcategories_ids[0];
            }
        }else {
            $category_where_sql = " and ptc.categories_id = ".(int)$current_category_id;
        }
    }else {
        $category_where_sql = " and ptc.categories_id = ".(int)$current_category_id;
    }
    return $category_where_sql;
}

/**
 * $Notes: 获取分类下指定条件产品  暂时查新品
 *
 * $author: Jeremy
 * $Date: 2021/01/11
 * @param $cid
 * @param $where
 * @param $length
 * @param $page
 * @return array
 */
function get_products_by_cid($cid, $where = 'p.status = 1', $length = 3, $page = 1){
    $category_where_sql = get_sub_categories_sql($cid);
    // 获取所有产品id
    $query_where = " WHERE ".$where.$category_where_sql;
    $query_from = " from ".TABLE_PRODUCTS." AS p 
                    LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc ON ptc.products_id = p.products_id 
                    LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON p.products_id = pd.products_id";
    $all_listing_sql = "select p.products_id,p.products_image,pd.products_name " . $query_from . $query_where . " 
                        GROUP BY p.products_id ORDER BY p.products_sort_order asc,new_products_time desc,p.products_id asc";
    $products_key = md5($all_listing_sql,true);
    $prefix = 'HEADER_NEW_PRODUCTS';
    $products_data = get_redis_key_value($products_key,$prefix);
    if(!$products_data){
        global $db;
        $all_products_data = $db->Execute($all_listing_sql);
        if ($all_products_data->RecordCount()){
            while (!$all_products_data->EOF){
                $images = $all_products_data->fields['products_image'] ? HTTPS_PRODUCTS_SERVER."/images/".$all_products_data->fields['products_image'] : '';
                $products_data[] = array(
                    'id' => $all_products_data->fields['products_id'],
                    'image' => $images,
                    'name' => $all_products_data->fields['products_name'],
                    );
                $all_products_data->MoveNext();
            }
        }
        set_redis_key_value($products_key,$products_data,24*3600,$prefix);
    }
    $start = (int)$page == 1 ? 0 : (int)$length * ((int)$page - 1);
    $result = [];
    if(sizeof($products_data) >= ($start + $length)){
        $result = array_slice($products_data,$start,$length);
    }
    return $result;
}

//首页header分类下新品结构
function get_header_new_products_html($products,$is_active = 0){
    $html = '';
    if(sizeof($products)){
        $active = $is_active ? 'active' : '';
        $html .='<div class="fs_home_new_product_public '.$active.'">';
        foreach ($products as $product){
            $href = zen_href_link('product_info', 'products_id=' . (int)$product['id']);
            $html .='<dl class="header_list_more_ul_main_all_con">
                        <dt>
                            <a href="'.$href.'"><img src="'.$product['image'].'"/></a>
                        </dt>
                        <dd>
                            <span class="fs_home_new_product_label">'.NEW_PRODUCTS_TAG.'</span>
                            <a href="'.$href.'"><p class="fs_home_new_product_txt">'.$product['name'].'</p></a>
                        </dd>
                    </dl>';
        }
        $html .='</div>';
    }
    return $html;
}


/**
 * 后台在录入数据时，https:// 中的 : 会用&&或%%替换，此处要还原回来
 * @param $arr
 * @return mixed
 */
function str_replace_http($arr)
{
    if (is_string($arr)) {
        $arr && $arr = str_replace('&&', ':', $arr);
        $arr && $arr = str_replace('%%', ':', $arr);
    } else {
        foreach ($arr as $k => $v) {
            if (is_string($v)) {
                $v && $v = str_replace('&&', ':', $v);
                $v && $v = str_replace('%%', ':', $v);
                $arr[$k] = $v;
            } else if (is_array($v)) { //若为数组
                $arr[$k] = $this->str_replace_http($v);
            }
        }
    }
    return $arr;
}

/**
 * @param $products_id
 * @param $category_warranty
 * @param $product_warranty
 * @param $cPath_array
 * @return string
 */
function get_products_warranty_return_html($products_id,$category_warranty,$product_warranty,$cPath_array){
    $warranty_return_html = '';
    if(!$products_id){
        return $warranty_return_html;
    }
    $warranty_period = $return_period = 0;
    $asynchronous_product_ids = $category_warranty['asynchronous_product_ids'] ?  $category_warranty['asynchronous_product_ids'] : '';
    $asynchronous_product_ids = str_replace('；',';',$asynchronous_product_ids);
    $asynchronous_products = explode(';',$asynchronous_product_ids);
    $warranty_sort = $product_warranty['warranty_sort'] ? str_replace('；',';',$product_warranty['warranty_sort']) : '0;1;2';
    $warranty_sort = explode(';',$warranty_sort);
    if(!in_array($products_id,$asynchronous_products)){ //不同步的产品ID
        $warranty_period = $category_warranty['warranty_period'];
        $return_period = $category_warranty['return_period'];
    }
    $warranty_period = $warranty_period ? $warranty_period : $product_warranty['warranty_period'];
    if(!$warranty_period && $cPath_array[0]==9){
        $warranty_period = 5;
    }
    if(!$return_period){
        if($product_warranty['return_period']){
            $return_period = $product_warranty['return_period'];
        }elseif ($cPath_array[0]==9){
            $return_period = 30;
        }
    }
   $shipping_warranty_data = $warranty_data = $return_data = [];

    $shipping_data = array(
        'url' =>  zen_href_link('shipping_delivery'),
        'text' => PRODUCTS_WARRANTY_4,
    );
    if($warranty_period >0){
        if($warranty_period !=100){
            if($warranty_period ==1){
                $text = str_replace('WARRANTY_YEARS',$warranty_period,PRODUCTS_WARRANTY_5_1);
            }else{
                $text = str_replace('WARRANTY_YEARS',$warranty_period,PRODUCTS_WARRANTY_5);
            }
        }else{
            $text = PRODUCTS_WARRANTY_6;
        }
        $warranty_data = array(
            'url' =>  reset_url('policies/warranty.html'),
            'text' => $text,
        );
    }
    if($return_period >0){
        $return_data = array(
            'url' => reset_url('policies/day_return_policy.html'),
            'text' => str_replace('RETURN_DAYS',$return_period,FS_FAST_DELIVERY)
        );
    }
    //shipping&delivery 和质保信息展示顺序
    $shipping_warranty_data = array(
        0=>$shipping_data,
        1=>$warranty_data,
        2=>$return_data,
    );
    foreach ($warranty_sort as $i){
        if($shipping_warranty_data[$i]){
            $warranty_return_html .=  '<li>
                    <em class="spot"></em>
                    <a class="warranty_optimization_a" href="'.$shipping_warranty_data[$i]['url'].'" target="_blank">' .$shipping_warranty_data[$i]['text']. '</a>
                </li>';
        }
    }
return $warranty_return_html;
}

/**
 * Note: 判断推荐产品是否下架
 * @Author: Bona
 * @Date: 2021/3/19
 * @Time: 11:22
 * @param array $products_id
 * @return bool
 */
function get_product_staus($products_id)
{
    if (empty($products_id)) {
        return false;
    }
    $warehouse_data = fs_products_warehouse_where();
    $warehouseWhere = $warehouse_data['code'] . '_status';

    global $db;
    $sql = "select products_status," . $warehouseWhere . " from products where products_id =" . $products_id;
    $result = $db->getAll($sql);
    $data = $result[0];

    if ($data['products_status'] == 1 && $data[$warehouseWhere] == 1) {
        return true;
    }else{
        return false;
    }
}
?>
