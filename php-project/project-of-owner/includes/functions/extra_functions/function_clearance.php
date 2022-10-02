<?php
//清仓页面（查询清仓在service里面进行了优化，数据展示信息量大，需抽时间优化）
/*$clearanceTypeProduct右侧清仓产品信息*/
/*$getClearanceId分类id*/
/*$type展示方式 all清仓首页 list清仓列表*/
/*$sql_order_by展示产品的排序方式*/
function get_new_ajax_clearance($clearanceTypeProduct = [], $getClearanceId = '', $type='all', $sql_order_by='popularity', $params_for_categories_split='', $page=0, $products_narrow_by_option_values_ids='')
{
    global $db;
    global $fs_reviews;
    global $currencies;
    global $productRelatedAttributesModel;
    $is_mobile = isMobile();
    $common_footer_str = '<div class="clh_list_bottom">
                    <div class="clh_list_bottom_bg"></div>
                    <div class="clh_list_bottom_cont">
                        <div>
                            <p class="clh_list_bottom_tit">'.FS_CLEARACNE_07.'</p>
                            <ul class="clh_list_bottom_list">
                                <li><em></em><p>'.FS_CLEARACNE_08.'</p></li>
                                <li><em></em><p>'.FS_CLEARACNE_09.'</p></li>
                                <li><em></em><p>'.FS_CLEARACNE_10.'</p></li>
                            </ul>
                        </div>
                    </div>
                </div>';
    //获取当前国家对应的发货仓库状态字段进行筛选产品
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_where = ' where p.products_status = 1 ' .$warehouse_data['where'];
    $inquiry_field = 'is_'.$warehouse_data['code'].'_inquiry';
    $wholesaleproducts = fs_get_wholesale_products_array();
    $product_list_content = '';
    $products_list_info = '';
    $products_image_info = '';
    $ids = array();
    $product_arr_sql = 'select c.products_id,c.products_clearance_price,p.products_status,p.'.$inquiry_field.' as is_inquiry from products_clearance AS c LEFT JOIN products AS p using(products_id)';
    if($type == 'list'){
        if($getClearanceId!=''){
            //查询对应分类下清仓产品表信息
            $sql_where =' and c.clearance_id ='.$getClearanceId;
            // 获取筛选项的sql 条件
            $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
            $from_narrow_by='';
            //var_dump($products_narrow_by_option_values_ids);
            if (zen_not_null($products_narrow_by_option_values_ids)){
                if (1 == $narrow_by_count) {
                    $from_narrow_by =" left join ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS ." as povp using(products_id)";
                    $and_narrow_by = " and povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
                }else {
                    $from_narrow_by='';
                    $where_narrow_by = ' select t0.products_id from ';
                    $sql_query_array = array();
                    for($i = 0; $i< $narrow_by_count;$i++){
                        $sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
                    where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ."
                                  ) as t".$i ." ";
                    }
                    for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
                        if($i){
                            $where_narrow_by .=' CROSS JOIN';
                        }
                        $where_narrow_by .= $sql_query_array[$i];
                        if($i){
                            $where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
                        }
                    }
                    $and_narrow_by =  " AND p.products_id in(".$where_narrow_by.")";
                }
            }
            // 分组，排序
            $product_arr_sort = ' group by p.products_id ORDER BY products_sort_order ASC ';
            if(isset($sql_order_by) && $sql_order_by)
            {
                switch ($sql_order_by){
                    case 'priced':
                        $product_arr_sort = " group by c.products_id order by p.products_price desc ";
                        break;
                    case 'price':
                        $product_arr_sort = " group by c.products_id order by p.products_price ";
                        break;
                    case 'rate':
                        $product_arr_sort = " group by c.products_id order by rating desc ";
                        break;
                    case 'new':
                        $product_arr_sort = " group by c.products_id order by p.products_date_added desc ";
                        break;
                    case 'popularity':
                    default:
                        $product_arr_sort = " group by c.products_id order by c.products_sort asc  ";
                        break;
                }
            }
            $listing_sql = $product_arr_sql.$from_narrow_by.$warehouse_where.$sql_where.$and_narrow_by.$product_arr_sort;
            //var_dump($listing_sql);
            $pro_id_arr =  $db->getAll($listing_sql);
            if ($pro_id_arr) {
                foreach ($pro_id_arr as $pro_id){
                    $ids[]=$pro_id['products_id'];
                }
            }
            $start = ($page-1)*24;
            $limit = " limit ".$start.",24";
            $product_arr = $db->getAll($listing_sql.$limit);
            //分类ID关联对应清仓产品分类id查询是否存在产品
            //$row = $db->getAll($row_sql.$from_narrow_by.$warehouse_where.$sql_where.$and_narrow_by);
            // clearance_counts =$row[0]['row'];
            $listing_split = new splitPageResults($listing_sql, 24, 'p.products_id', 'page');
            $page_links = $listing_split->display_links_listing_new(1,$params_for_categories_split);
            $clearance_counts = $listing_split->number_of_rows;
            //var_dump($clearance_counts);
            if ($product_arr) {
                foreach ($product_arr as $list => $right_list) {
                    $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $right_list['products_id'], 'NONSSL');
                    $productImageSrc = fs_get_data_from_db_fields('products_image', 'products', 'products_id="' . (int)$right_list['products_id'] . '"', '');
                    $new_name = zen_get_products_name($right_list['products_id']);
                    $image = get_resources_img($right_list['products_id'], '180', '180', $productImageSrc, '', $new_name);
                    //正常价
                    $wp_price = zen_get_products_base_price($right_list['products_id']);
                    //清仓原价
                    $cle_price = zen_get_products_base_price($right_list['products_id'],true);
                    $new_product_name = mb_substr($new_name, 0, 500, 'UTF-8');
                    $productLengthInfo = fs_product_length_info($right_list['products_id']);
                    $options_name = fs_products_option_info($right_list['products_id']);
                    $is_inquiry_cle = $right_list['is_inquiry'];
                    //判断该产品产否是定制产品，若是定制产品默认不勾选属性不需展示库存
                    $isCustom = true;
                    if (sizeof($options_name) || $productLengthInfo) {
                        $isCustom = false;
                    }
                    if (in_array($right_list['products_id'], [75874, 75875, 75877])) {
                        $isCustom = true;
                    }

                    $shippingInfo = new shippingInfo(array('pid' => $right_list['products_id']));
                    $country_code = strtoupper($_SESSION['countries_iso_code']);

                    //手机站不展示qv按钮
                    $qv_btn_str = $is_mobile?'':'<div class="new_proList_QkviewBtn"><a href="javascript:;" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'. $right_list['products_id'].'"><div class="new_proList_QkviewBtnTa"><div class="new_proList_QkviewBtnTaCe icon iconfont">&#xf142;</div></div></a></div>';
                    //$reviews = fs_get_data_from_db_fields('reviews_id', 'reviews', 'products_id=' . $product['id'], 'limit 1');
                    //第一页显示的评论
                    $products_review = $fs_reviews->get_product_list_review_show($right_list['products_id']);
                    //$products_review_count = $fs_reviews->get_product_list_review_count($right_list['products_id']);
                    $product_review_content = $products_review ;
                    //价格部分
                    $products_price_info = '';
                    if ($is_inquiry_cle != '1') {
                        if (!in_array($right_list['products_id'], $wholesaleproducts)) {
                            $discount_price = $currencies->new_format_clearance($wp_price,0);
                        } else {
                            $discount_price = $currencies->new_format_clearance($wp_price,1);
                        }
                        //是否取整之后在乘以税率
                        $discount_price = get_gsp_tax_price($country_code,$discount_price);
                        $products_price_info .= $currencies->update_format($discount_price);

                        $add_to_cart = $is_mobile && $_SESSION['languages_id'] == 1?'Add':FS_ADD_TO_CART;
                    } else {
                        $discount_price = 0;
                        $products_price_info .= '-';
                        $add_to_cart = GET_A_QUOTE;
                    }
                    $products_price_info .= '<strong class="old_price_z">';
                    //清仓产品原价
                    if ($right_list['products_clearance_price'] > 0) {
                        if ($is_inquiry_cle != '1') {
                            if (!in_array($right_list['products_id'], $wholesaleproducts)) {
                                $original_price = $currencies->new_format_clearance($cle_price,0);
                            } else {
                                $original_price = $currencies->new_format_clearance($cle_price,1);
                            }
                            //是否取整之后在乘以税率
                            $original_price = get_gsp_tax_price($country_code,$original_price);
                            $products_price_info .= $currencies->update_format($original_price);

                        } else {
                            $original_price = 0;
                            $products_price_info .= '-';
                        }
                    }
                    $products_price_info .= '<span class="old_price_line"></span></strong>';
                    //产品库存部分
                    $products_price_str = $shippingInfo->pure_price;
                    $products_instock_info = $shippingInfo->showIntockDate($isCustom, 1, $products_price_str);
                    //产品数量增加部分
                    $cart_quantity_id_str = 'CART_QUANTITY_ID_STR';
                    $products_number_info = '<div class="product_list_text"><span>
                    <input type="text"  id="'.$cart_quantity_id_str.$right_list['products_id'].'" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  min="1" onblur="q_check_min_qty(this,' . $right_list['products_id'] . ');" onfocus="q_enterKey(this,' . $right_list['products_id'] . ')" value="1"  autocomplete="off" class="p_07 product_list_qty"><div class="pro_mun">';
                    if($right_list['products_id']==73321){
                        $products_number_info .= '<a href="javascript:;" class="cart_qty_add"></a>
                        <a href="javascript:;" class="cart_qty_reduce cart_reduce"></a>';
                    }else {
                        $products_number_info .= '<a href="javascript:void(list_cart_quantity_change(1,'.$right_list['products_id'].'));" class="cart_qty_add"></a>
                        <a href="javascript:void(list_cart_quantity_change(0,'.$right_list['products_id'].'));" class="cart_qty_reduce cart_reduce"></a> ';
                    }
                    $products_number_info .= '</div></span></div>';
                    //添加购物车按钮部分
                    $current_type = 'CURRENT_TYPE';
                    $products_btn_info = ' <div class="product_list_btn floatRz">';
                    if ((!sizeof($options_name) && !$productLengthInfo)) {
                        if ($is_inquiry_cle != '1') {
                            $products_btn_info .= '<button type="submit" data-product-id="'.$right_list['products_id'].'" id="prod_add2_' . $right_list['products_id'] . '" onclick="ajax_get_one_product_qv_show(this)" name="Add to Cart" value="' . $add_to_cart . '" class="new_pro_addCart_btn" placeholder="">
                                    ' . $add_to_cart . '
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
                            $products_btn_info .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                        }
                    } else {
                        $products_btn_info .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                    }
                    $products_btn_info .= '</div>';

                    /*清仓列表list展示方式 start*/
                    $products_number_info_list = str_replace('CART_QUANTITY_ID_STR','img_quantity_',$products_number_info);
                    $products_btn_info_list = str_replace('CURRENT_TYPE','new_list',$products_btn_info);
                    $products_list_info .= '<li class="new_proList_mainListTli"><div>';
                    //添加降价幅度的标识（原价-折扣价）/原价*100%
                    if($original_price != 0){
                        $discount = round(($original_price-$discount_price)/$original_price*100);
                    }
                    $discount_html = '';
                    if ($discount > 0) {
                        $discount_html = '<div class="clh_percentage_num">'.$discount.FS_DISCOUNT.'</div>';
                    }
                    // 获取产品描述
                    $products_list_info .= '
                        <div class="new_proList_ListTleft">
                            <div class="new_proList_ListImg">
                                '.$qv_btn_str.'
                                <a href="'.$href_link.'" target="_blank">'.$image.'</a>
                                '. $discount_html .'
                            </div>			
                        </div>
                        <div class="new_proList_Array_colB">
                            <div class="new_proList_Array_col">
                                <h3><a href="' . $href_link . '" target="_blank" data-is-common-title="" title="'.$new_product_name.'">' .$new_product_name . '</a></h3>			      
                                <div class="new_proList_ListBstarBox">
                                    '.$product_review_content.'
                                </div>				
                            </div>
                            <div class="new_proList__array_form">
                                <div class="new_proList_ListBPrice" id="detailSid">
                                    '.$products_price_info.'
                                </div>
                                <div class="new_proList_ListBtxt1">
                                    '.$products_instock_info.'
                                </div>
                                <div class="video_array_formRight">
                                    <div class="video_array_form">
                                            '.$products_btn_info_list.'
                                    </div>
                                </div>
                            </div>
                        </div>';
                    $products_list_info .= '</div></li>';
                    /*清仓列表list展示方式 end*/
                    /*清仓列表image展示方式 start*/
                    $products_number_info_image = str_replace('CART_QUANTITY_ID_STR','img_quantity2_',$products_number_info);
                    $products_btn_info_image = str_replace('CURRENT_TYPE','image',$products_btn_info);
                    $products_image_info .= '<li class="new_proList_mainListLi"><div>';
                    $products_image_info .= '
                    <div class="new_proList_ListTop">
                        <div class="new_proList_ListImg">
                            <a href="'.$href_link.'" target="_blank">' . $image . '</a>
                                '.$qv_btn_str.'
                                '.$discount_html.'
                        </div>
                    </div>    
                    <div class="new_proList_ListBottom">
                        <h3 class="new_proList_ListBlink"><a href="' . $href_link . '" target="_blank"  title="'.$new_product_name.'">' .$new_product_name . '</a></h3>
                        <div class="new_proList_ListBPrice" id="imgSid">'.$products_price_info.'</div>
                        <div class="new_proList_ListBstarBox">
                            '.$product_review_content.'
                        </div>
                        <div class="new_proList_ListBtxt1">
                            '.$products_instock_info.'
                        </div>
                        <div class="picture_array_from">
                        '.$products_number_info_image.'
                        '.$products_btn_info_image.'
                        </div>
                    </div>';
                    $products_image_info .= '</div></li>';
                }
            }
        }
    }elseif($type == 'all'){
        //分类名查询
        $clearance_pro_str ='';
        if ($clearanceTypeProduct) {
            foreach ($clearanceTypeProduct as $clearanceVal) {
                //uk/au转换成英式英语
                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $clearanceVal['products_type'] = swap_american_to_britain($clearanceVal['products_type']);
                }
                if($clearanceVal['product_row'][0]['row']>0){
                    $clearance_pro_str .= '<div class="clh_right_tit1 first">
                                    <span class="clh_right_tit2" style="">' . $clearanceVal['products_type'] . '<span class="numTz">(' . $clearanceVal['product_row'][0]['row'] . ')</span></span>';
                    if($clearanceVal['product_row'][0]['row']>4 || ($is_mobile && $clearanceVal['product_row'][0]['row'] >2)){
                        $clearance_pro_str .='<a class="clh_right_tit3 all_btn" onclick="spinloader()"  href="'.zen_href_link('clearance_list','type='.$clearanceVal['clearance_id']).'">'.FS_LEARN_MORE.'<span class="iconfont">&#xf089;</span></a>';
                    }
                    $clearance_pro_str .='</div>';
                    $clearance_pro_str .= '<div class="clh_right_prolist"><ul>';
                    foreach($clearanceVal['type_product'] as $list=>$right_list){
                        if ($list > 3) {
                            break;
                        }
                        $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $right_list['products_id'], 'NONSSL');
                        $productImageSrc = $right_list['products_image'];
                        $new_name = zen_get_products_name($right_list['products_id']);
                        $image =  get_resources_img($right_list['products_id'],'180','180',$productImageSrc,$new_name,$new_name);

                        //产品库存部分
                        //判断该产品产否是定制产品，若是定制产品默认不勾选属性不需展示库存
                        if(zen_get_products_length_total($right_list['products_id']) != 0 || zen_get_products_attributes_total($right_list['products_id']) != 0){
                            $isCustom = false;
                        }else{
                            $isCustom = true;
                        }
                        if(in_array($right_list['products_id'],[75874,75875,75877])){
                            $isCustom = true;
                        }
                        $shippingInfo = new shippingInfo(array('pid'=>$right_list['products_id'],'current_category'=>[0],'is_set_custome_tag'=>$isCustom));

                        //正常价
                        $wp_price = zen_get_products_base_price($right_list['products_id']);
                        //清仓原价
                        $cle_price = zen_get_products_base_price($right_list['products_id'],true);
                        $country_code = strtoupper($_SESSION['countries_iso_code']);
//                    if($country_code == 'AU' && !$shippingInfo->au_gsp_is_buck()){
//                        $wp_price = get_gsp_tax_price($country_code,$wp_price);
//                        $cle_price = get_gsp_tax_price($country_code,$cle_price);
//                    }

                        $new_product_name = mb_substr($new_name, 0, 500,'UTF-8');
                        $is_inquiry_cle = $right_list['is_inquiry'];
                        $is_customized = $right_list['is_customized'];
                        //计算折扣比
                        if ($is_inquiry_cle != '1') {
                            if (!in_array($right_list['products_id'], $wholesaleproducts)) {
                                $discount_price = $currencies->new_format_clearance($wp_price,0);
                                $original_price = $currencies->new_format_clearance($cle_price,0);
                            } else {
                                $discount_price = $currencies->new_format_clearance($wp_price,1);
                                $original_price = $currencies->new_format_clearance($cle_price,1);
                            }
                            //是否取整之后在乘以税率
                            $discount_price = get_gsp_tax_price($country_code,$discount_price);
                            $original_price = get_gsp_tax_price($country_code,$original_price);
                            $clearance_price = $currencies->update_format($discount_price);
                            $clearance_original_price = $currencies->update_format($original_price);
                        } else {
                            $discount_price = 0;
                            $original_price = 0;
                        }
                        //添加降价幅度的标识（原价-折扣价）/原价*100%
                        if($original_price != 0){
                            $discount = round(($original_price-$discount_price)/$original_price*100);
                        }
                        $discount_html = '';
                        if ($discount > 0) {
                            $discount_html = '<div class="clh_percentage_num">'.$discount.FS_DISCOUNT.'</div>';
                        }
                        if($list == 2) {
                            $class = 'choosez';
                        }elseif($list == 3){
                            $class = 'choosez last';
                        }else{
                            $class = '';
                        }
                        $clearance_pro_str .= '<li class="clh_product_li ' . $class . '">';
                        $clearance_pro_str .= '<div class="clh_product_img">';
                        $clearance_pro_str .='<a target="_blank" href="' . $href_link . '">' . $image . '</a>';
                        //手机站不展示qv按钮
                        $qv_btn_str = $is_mobile?'':'<div class="new_proList_QkviewBtn"><a href="javascript:;" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'. $right_list['products_id'].'"><div class="new_proList_QkviewBtnTa"><div class="new_proList_QkviewBtnTaCe icon iconfont">&#xf142;</div></div></a></div>';
                        $clearance_pro_str .=$qv_btn_str;
                        $clearance_pro_str .=$discount_html;
                        $clearance_pro_str .='</div>';
                        $clearance_pro_str .= '<a target="_blank" title="' . $new_product_name . '" href="' . $href_link . '"><h1 class="clh_product_txt">' . $new_product_name . '</h1></a>';
                        $clearance_pro_str .= '<div class="price_z">';
                        if ($is_inquiry_cle != '1') {
                            $clearance_pro_str .= $clearance_price;
                            $add_to_cart = $is_mobile && $_SESSION['languages_id'] == 1?'Add':FS_ADD_TO_CART;
                        } else {
                            $clearance_pro_str .= '-';
                            $add_to_cart = GET_A_QUOTE;
                        }
                        //清仓产品原价
                        $clearance_pro_str .= '<div class="old_price_zBox"><strong class="old_price_z">';
                        if($right_list['products_clearance_price'] > 0){
                            if ($is_inquiry_cle != '1') {
                                $clearance_pro_str .= $clearance_original_price;
                            } else {
                                $clearance_pro_str .= '-';
                            }
                        }
                        $clearance_pro_str .= '<span class="old_price_line"></span></strong></div></div>';

                        $clearance_pro_str .= '<div class="clh_product_info">';
                        //$reviews = fs_get_data_from_db_fields('reviews_id', 'reviews', 'products_id=' . $product['id'], 'limit 1');
                        //第一页显示的评论

                        $redis_cache = get_redis_key_value('fs_clearance_page'.$right_list['products_id'],'clearance');
                        // var_dump($redis_cache);die;
                        if($redis_cache){
                            $products_review = $redis_cache;
                        }else{
                            $products_review = $fs_reviews->get_product_list_review_show($right_list['products_id']);
                            set_redis_key_value('fs_clearance_page'.$right_list['products_id'], $products_review, 7 * 24 * 3600, 'clearance');
                        }
                        //$products_review_count = $fs_reviews->get_product_list_review_count($right_list['products_id']);
                        $clearance_pro_str .= $products_review;
                        $clearance_pro_str .= '<div class="product_grid_stock">
                <span class="products_in_stock">
                <span class="products_in_stock pro_details">';

                        $products_price_str = $shippingInfo->pure_price;
                        $clearance_pro_str .= $shippingInfo->showIntockDate($isCustom,1,$products_price_str);
                        $clearance_pro_str .= '</span></span></div>';
                        $clearance_pro_str .= '<div class="product_list_text"><span>';
                        $clearance_pro_str .= '<input type="hidden"  name="product_min_qty"><input type="text" id="img_quantity_' . $right_list['products_id'] . '" value="1" maxlength = "5"  min="1" onblur="check_min_qty(this,' . $right_list['products_id'] . ')" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^\d]/g,\'\')" onfocus="enterKey(this,' . $right_list['products_id'] . ')" class="p_07 product_list_qty" autocomplete="off">
                     <div class="pro_mun">
                          <a href="javascript:void(clearance_quantity_change(1,' . $right_list['products_id'] . '));" class="cart_qty_add"></a>
                          <a href="javascript:void(clearance_quantity_change(0,' . $right_list['products_id'] . '));" class="cart_qty_reduce cart_reduce"></a>
                          </div>
                          </span>
                          </div>
                          <div class="product_list_btn">';
                        if ($is_customized != 1) {
                            if ($is_inquiry_cle != '1') {
                                $clearance_pro_str .= '<button type="submit" id="prod_add2_' . $right_list['products_id'] . '" onclick="prodAddtoCart2(' . $right_list['products_id'] . ',$(this))" name="Add to Cart" value="' . $add_to_cart . '" class="new_pro_addCart_btn" placeholder="">
                                    <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '
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
                                $clearance_pro_str .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                            }
                        } else {
                            $clearance_pro_str .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                        }
                        $clearance_pro_str .= '</div></div></li>';
                    }
                    $clearance_pro_str .='</ul></div>';
                }
            }
        }
        $product_list_content .= '
                    <div class="clh_right_list">
                        <div class="clh_right_box">
                            <div class="clh_right_cont">
                               '.$clearance_pro_str.'
                            </div>
                        </div>
                    </div>';
    }
    //image展示方式 list展示方式 ids该分类所以产品 page分页代码 row产品总数
    if($type=='list') {
        return array(
            'image' => $products_image_info,
            'list'  => $products_list_info,
            'ids'   => $ids,
            'page'  => $page_links,
            'row'   => $clearance_counts
        );
    }elseif ($type=='all'){
        return $product_list_content;
    }
}


function get_sub_clearance_types($clearance_id)
{
    global $db;
    $result = $db->getAll("select clearance_id from product_clearance_type where parent_id=".intval($clearance_id));

    if (empty($result)) {
        return [];
    }

    return array_column($result, 'clearance_id');
}

function get_new_ajax_clearance_new($clearanceTypeProduct = [], $getClearanceId = '', $type='all', $sql_order_by='popularity', $params_for_categories_split='', $page=0, $products_narrow_by_option_values_ids='')
{
    global $db;
    global $fs_reviews;
    global $currencies;
    global $productRelatedAttributesModel;
    $is_mobile = isMobile();


    $common_footer_str = '<div class="clh_list_bottom">
                    <div class="clh_list_bottom_bg"></div>
                    <div class="clh_list_bottom_cont">
                        <div>
                            <p class="clh_list_bottom_tit">'.FS_CLEARACNE_07.'</p>
                            <ul class="clh_list_bottom_list">
                                <li><em></em><p>'.FS_CLEARACNE_08.'</p></li>
                                <li><em></em><p>'.FS_CLEARACNE_09.'</p></li>
                                <li><em></em><p>'.FS_CLEARACNE_10.'</p></li>
                            </ul>
                        </div>
                    </div>
                </div>';


    //获取当前国家对应的发货仓库状态字段进行筛选产品
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_where = ' where p.products_status = 1 ' .$warehouse_data['where'];
    $wholesaleproducts = fs_get_wholesale_products_array();
    $product_list_content = '';
    $products_list_info = '';
    $products_image_info = '';
    $ids = array();
    $product_arr_sql = 'select c.products_id,c.products_clearance_price,p.products_status,p.product_sales_total_num,p.offline_sales_num from products_clearance AS c LEFT JOIN products AS p using(products_id)';
    if($type == 'list'){
        if($getClearanceId != ''){

            //获取清仓的所有子分类
            $subClearanceIds = get_sub_clearance_types($getClearanceId);
            $subClearanceIds[] = intval($getClearanceId);

            //查询对应分类下清仓产品表信息
            $sql_where =' and c.clearance_id in ('.implode(',', $subClearanceIds).')';

            // 获取筛选项的sql 条件
            $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
            $from_narrow_by='';

            if (zen_not_null($products_narrow_by_option_values_ids)){
                if (1 == $narrow_by_count) {
                    $from_narrow_by =" left join ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS ." as povp using(products_id)";
                    $and_narrow_by = " and povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
                }else {
                    $from_narrow_by='';
                    $where_narrow_by = ' select t0.products_id from ';
                    $sql_query_array = array();
                    for($i = 0; $i< $narrow_by_count;$i++){
                        $sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
                    where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ."
                                  ) as t".$i ." ";
                    }
                    for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
                        if($i){
                            $where_narrow_by .=' CROSS JOIN';
                        }
                        $where_narrow_by .= $sql_query_array[$i];
                        if($i){
                            $where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
                        }
                    }
                    $and_narrow_by =  " AND p.products_id in(".$where_narrow_by.")";
                }
            }
            // 分组，排序
            //$product_arr_sort = ' group by p.products_id ORDER BY products_sort_order ASC ';
            $product_arr_sort = ' group by p.products_id ORDER BY c.products_sort ASC ';
            if(isset($sql_order_by) && $sql_order_by)
            {
                switch ($sql_order_by){
                    case 'priced':
                        $product_arr_sort = " group by c.products_id order by p.products_price desc ";
                        break;
                    case 'price':
                        $product_arr_sort = " group by c.products_id order by p.products_price ";
                        break;
                    case 'rate':
                        $product_arr_sort = " group by c.products_id order by rating desc ";
                        break;
                    case 'new':
                        $product_arr_sort = " group by c.products_id order by p.products_date_added desc ";
                        break;
                    case 'popularity':
                    default:
                        $product_arr_sort = " group by c.products_id order by c.products_sort asc  ";
                        break;
                }
            }
            $listing_sql = $product_arr_sql.$from_narrow_by.$warehouse_where.$sql_where.$and_narrow_by.$product_arr_sort;
            //var_dump($listing_sql);
            $pro_id_arr =  $db->getAll($listing_sql);
            if ($pro_id_arr) {
                foreach ($pro_id_arr as $pro_id){
                    $ids[]=$pro_id['products_id'];
                }
            }
            $start = ($page-1)*24;
            $limit = " limit ".$start.",24";
            $product_arr = $db->getAll($listing_sql.$limit);
            //分类ID关联对应清仓产品分类id查询是否存在产品
            //$row = $db->getAll($row_sql.$from_narrow_by.$warehouse_where.$sql_where.$and_narrow_by);
            // clearance_counts =$row[0]['row'];
            $listing_split = new splitPageResults($listing_sql, 24, 'p.products_id', 'page');
            $page_links = $listing_split->display_links_listing_new(1,$params_for_categories_split);
            $clearance_counts = $listing_split->number_of_rows;
            //var_dump($clearance_counts);
            if ($product_arr) {
                foreach ($product_arr as $list => $right_list) {
                    $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $right_list['products_id'], 'NONSSL');
                    $productImageSrc = fs_get_data_from_db_fields('products_image', 'products', 'products_id="' . (int)$right_list['products_id'] . '"', '');
                    $new_name = zen_get_products_name($right_list['products_id']);
                    $image = get_resources_img($right_list['products_id'], '180', '180', $productImageSrc, '', $new_name);
                    //正常价
                    $wp_price = zen_get_products_base_price($right_list['products_id']);
                    //清仓原价
                    $cle_price = zen_get_products_base_price($right_list['products_id'],true);
                    $new_product_name = mb_substr($new_name, 0, 500, 'UTF-8');
                    $productLengthInfo = fs_product_length_info($right_list['products_id']);
                    $options_name = fs_products_option_info($right_list['products_id']);
                    $is_inquiry_cle_sql = $db->Execute("select is_inquiry FROM products where products_id = " . $right_list['products_id']);
                    $is_inquiry_cle = $is_inquiry_cle_sql->fields['is_inquiry'];
                    //判断该产品产否是定制产品，若是定制产品默认不勾选属性不需展示库存
                    $isCustom = true;
                    if (sizeof($options_name) || $productLengthInfo) {
                        $isCustom = false;
                    }
                    if (in_array($right_list['products_id'], [75874, 75875, 75877])) {
                        $isCustom = true;
                    }

                    $shippingInfo = new shippingInfo(array('pid' => $right_list['products_id']));
                    $country_code = strtoupper($_SESSION['countries_iso_code']);

                    //手机站不展示qv按钮
                    $qv_btn_str = $is_mobile?'':'<div class="new_proList_QkviewBtn"><a href="javascript:;" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'. $right_list['products_id'].'"><div class="new_proList_QkviewBtnTa"><div class="new_proList_QkviewBtnTaCe icon iconfont">&#xf142;</div></div></a></div>';
                    //$reviews = fs_get_data_from_db_fields('reviews_id', 'reviews', 'products_id=' . $product['id'], 'limit 1');
                    //第一页显示的评论
                    $fs_reviews->get_product_review_rating_show($right_list['products_id'], $is_mobile);
                    $products_review = $fs_reviews->review_total_count;
                    $product_review_content = $products_review;
                    //产品总销量
                    $product_total_sale = '';
                    //$total_sale = get_products_sale_total_num($product['id'],$product['category_arr'][1]);
                    //$product_total_sale = products_total_sales_show($total_sale+$product['offline_sales_num']);
                    $right_list['product_sales_total_num'] = isset($right_list['product_sales_total_num']) ? intval($right_list['product_sales_total_num']) : 0;
                    $right_list['offline_sales_num'] = isset($right_list['offline_sales_num']) ? intval($right_list['offline_sales_num']) : 0;
                    $product_total_sale = products_total_sales_show($right_list['product_sales_total_num'] + $right_list['offline_sales_num']);

                    $reviews_title = ($products_review>1) ? FS_PRODUCTS_SALES_REVIEWS : FS_PRODUCTS_SALES_REVIEW;
                    if(in_array($_SESSION['languages_code'],['fr','it']) && $product_total_sale>1){
                        $sales_sold = FS_PRODUCTS_SALES_SOLDS;
                    }else{
                        $sales_sold = FS_PRODUCTS_SALES_SOLD;
                    }
                    $reviews_or_sold = '<div class="new_sales_container">
                            <a href="'.$href_link.'" target="_blank">
                                <span class="new_sales">'.(sprintf($sales_sold,'<em>'.$product_total_sale.'</em>')).'</span>
                            </a>
                            <i class="new_sales_border"></i>
                            <a href="'.reset_url('products/'.(int)$right_list['products_id'].'.html#all_reviews').'" target="_blank">
                                <span class="new_reviews">'.(sprintf($reviews_title,'<em>'.$products_review.'</em>')).'</span>
                            </a>
                        </div>';

                    //价格部分
                    $products_price_info = '';
                    $clearance_tax_price = $clearance_tax_class = '';
                    if ($is_inquiry_cle != '1') {
                        if (!in_array($right_list['products_id'], $wholesaleproducts)) {
                            $discount_price = $currencies->new_format_clearance($wp_price,0);
                        } else {
                            $discount_price = $currencies->new_format_clearance($wp_price,1);
                        }
                        //是否取整之后在乘以税率
                        $discount_price = get_gsp_tax_price($country_code,$discount_price);
                        if (in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de') {
                            $clearance_tax_price = $currencies->update_format($discount_price * 1.19);
                            $clearance_tax_class = 'de_tax_old_price';
                        }
                        if ($clearance_tax_price) {
                            $products_price_info .= '<span class="de_price_text">'.$currencies->update_format($discount_price).FS_PRICE_EXCL_VAT.'</span>';
                        } else {
                            $products_price_info .= $currencies->update_format($discount_price);
                        }

                        $add_to_cart = $is_mobile && $_SESSION['languages_id'] == 1?'Add':FS_ADD_TO_CART;
                    } else {
                        $discount_price = 0;
                        $products_price_info .= '-';
                        $add_to_cart = GET_A_QUOTE;
                    }
                    $products_price_info .= '<div class="old_price_zBox '.$clearance_tax_class.'"><strong class="old_price_z">';
                    //清仓产品原价
                    if ($right_list['products_clearance_price'] > 0) {
                        if ($is_inquiry_cle != '1') {
                            if (!in_array($right_list['products_id'], $wholesaleproducts)) {
                                $original_price = $currencies->new_format_clearance($cle_price,0);
                            } else {
                                $original_price = $currencies->new_format_clearance($cle_price,1);
                            }
                            //是否取整之后在乘以税率
                            $original_price = get_gsp_tax_price($country_code,$original_price);
                            if ($clearance_tax_price) {
                                $products_price_info .= $currencies->update_format($original_price).FS_PRICE_EXCL_VAT;
                            } else {
                                $products_price_info .= $currencies->update_format($original_price);
                            }

                        } else {
                            $original_price = 0;
                            $products_price_info .= '-';
                        }
                    }
                    $products_price_info .= '<span class="old_price_line"></span></strong></div>';
                    if ($clearance_tax_price) {
                        $products_price_info .= '<span class="de_tax_price_text">'.$clearance_tax_price.FS_PRICE_INCL_VAT.'</span>';
                    }
                    //列表页 产品应用标签
                    $products_tag_html = $products_vice_tag_html = $vice_tag_html ='';
                    if (in_array($_SESSION['languages_code'], array('uk', 'dn' , 'au', 'en'))){
                        $session = 1;
                    } else {
                        $session = $_SESSION['languages_id'];
                    }
                    $tagInfo = $db->Execute("select tags, vice_tags from products_list_tags where products_id = ".$right_list['products_id']." and languages_id =" .$session);

                    $pro_tags = $tagInfo->fields['tags']; //主标签
                    $pro_vice_tags = $tagInfo->fields['vice_tags']; //副标签
                    if ($pro_tags){ //主标签
                        $p_tags = explode('#',$pro_tags);
                        $p_tags = array_filter($p_tags); //去掉数组中的空元素
                        if (sizeof($p_tags)) {
                            foreach ($p_tags as $key => $p_tag){
                                if ($p_tag != ''){
                                    $p_tag = content_preg_mtp($p_tag);
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
                        $right_list['products_name'] = str_replace('NEOCLEAN', 'NEOCLEAN®', $right_list['products_name']);
                        $products_vice_tag_html = str_replace('NEOCLEAN™', 'NEOCLEAN®', $products_vice_tag_html);
                    }

                    //产品库存部分
                    $products_price_str = $shippingInfo->pure_price;
                    $products_instock_info = $shippingInfo->showIntockDate($isCustom, 1, $products_price_str);
                    //产品数量增加部分
                    $cart_quantity_id_str = 'CART_QUANTITY_ID_STR';
                    $products_number_info = '<div class="product_list_text"><span>
                    <input type="text"  id="'.$cart_quantity_id_str.$right_list['products_id'].'" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  min="1" onblur="q_check_min_qty(this,' . $right_list['products_id'] . ');" onfocus="q_enterKey(this,' . $right_list['products_id'] . ')" value="1"  autocomplete="off" class="p_07 product_list_qty"><div class="pro_mun">';
                    if($right_list['products_id']==73321){
                        $products_number_info .= '<a href="javascript:;" class="cart_qty_add"></a>
                        <a href="javascript:;" class="cart_qty_reduce cart_reduce"></a>';
                    }else {
                        $products_number_info .= '<a href="javascript:void(list_cart_quantity_change(1,'.$right_list['products_id'].'));" class="cart_qty_add"></a>
                        <a href="javascript:void(list_cart_quantity_change(0,'.$right_list['products_id'].'));" class="cart_qty_reduce cart_reduce"></a> ';
                    }
                    $products_number_info .= '</div></span></div>';
                    //添加购物车按钮部分
                    $current_type = 'CURRENT_TYPE';
                    $products_btn_info = ' <div class="product_list_btn floatRz">';
                    if ((!sizeof($options_name) && !$productLengthInfo)) {
                        if ($is_inquiry_cle != '1') {
                            $products_btn_info .= '<button type="submit" data-product-id="'.$right_list['products_id'].'" id="prod_add2_' . $right_list['products_id'] . '" onclick="ajax_get_one_product_qv_show(this)" name="Add to Cart" value="' . $add_to_cart . '" class="new_pro_addCart_btn" placeholder="">
                                    ' . $add_to_cart . '
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
                            $products_btn_info .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                        }
                    } else {
                        $products_btn_info .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                    }
                    $products_btn_info .= '</div>';

                    /*清仓列表list展示方式 start*/
                    $products_number_info_list = str_replace('CART_QUANTITY_ID_STR','img_quantity_',$products_number_info);
                    $products_btn_info_list = str_replace('CURRENT_TYPE','new_list',$products_btn_info);
                    $products_list_info .= '<li class="new_proList_mainListTli"><div>';
                    //添加降价幅度的标识（原价-折扣价）/原价*100%
                    if($original_price != 0){
                        $discount = round(($original_price-$discount_price)/$original_price*100);
                    }
                    $discount_html = '';
                    if ($discount > 0) {
                        $discount_html = '<div class="clh_percentage_num">'.str_replace('##NUM##', $discount, FS_DISCOUNT).'</div>';
                    }
                    // 获取产品描述
//                    $products_list_info .= '
//                        <div class="new_proList_ListTleft">
//                            <div class="new_proList_ListImg">
//                                '.$qv_btn_str.'
//                                <a href="'.$href_link.'" target="_blank">'.$image.'</a>
//                                '. $discount_html .'
//                            </div>
//                        </div>
//                        <div class="new_proList_Array_colB">
//                            <div class="new_proList_Array_col">
//                                <h3><a href="' . $href_link . '" target="_blank" data-is-common-title="" title="'.$new_product_name.'">' .$new_product_name . '</a></h3>
//                                <div class="new_proList_ListBstarBox">
//                                    '.$product_review_content.'
//                                </div>
//                            </div>
//                            <div class="new_proList__array_form">
//                                <div class="new_proList_ListBPrice" id="detailSid">
//                                    '.$products_price_info.'
//                                </div>
//                                <div class="new_proList_ListBtxt1">
//                                    '.$products_instock_info.'
//                                </div>
//                                <div class="video_array_formRight">
//                                    <div class="video_array_form">
//                                            '.$products_btn_info_list.'
//                                    </div>
//                                </div>
//                            </div>
//                        </div>';
//                    $products_list_info .= '</div></li>';
                    /*清仓列表list展示方式 end*/
                    /*清仓列表image展示方式 start*/
                    $products_number_info_image = str_replace('CART_QUANTITY_ID_STR','img_quantity2_',$products_number_info);
                    $products_btn_info_image = str_replace('CURRENT_TYPE','image',$products_btn_info);
                    $products_image_info .= '<li class="new_proList_mainListLi"><div>';
                    $products_image_info .= '
                    <div class="new_proList_ListTop">
                        <div class="new_proList_ListImg">
                            <a href="'.$href_link.'" target="_blank">' . $image . '</a>
                                '.$qv_btn_str.'
                                '.$discount_html.'
                        </div>
                    </div>    
                    <div class="new_proList_ListBottom">
                        <h3 class="new_proList_ListBlink"><a href="' . $href_link . '" target="_blank"  title="'.$new_product_name.'">' .$new_product_name . '</a></h3>
                        <div class="new_proList_applyBox_wrap">
                        <div class="new_proList_applyBox after first-col">' . $products_tag_html . '</div>
                        ' .$products_vice_tag_html. '
                        </div>
                        <div class="new_proList_ListBPrice" id="imgSid">'.$products_price_info.'</div>
                        <div class="new_proList_ListBtxt1">
                            '.$products_instock_info.'
                        </div>
                        '.$reviews_or_sold.'
                        <div class="picture_array_from">
                        '.$products_number_info_image.'
                        '.$products_btn_info_image.'
                        </div>
                    </div>';
                    $products_image_info .= '</div></li>';
                }
            }
        }
    }elseif($type == 'all'){
        //分类名查询
        $clearance_pro_str ='';
        if ($clearanceTypeProduct) {
            foreach ($clearanceTypeProduct as $clearanceVal) {
                //uk/au转换成英式英语
                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $clearanceVal['products_type'] = swap_american_to_britain($clearanceVal['products_type']);
                }
                if($clearanceVal['product_row'][0]['row']>0){
                    $clearance_pro_str .= '<div class="clh_right_tit1 first">
                                    <span class="clh_right_tit2" style="">' . $clearanceVal['products_type'] . '<span class="numTz">(' . $clearanceVal['product_row'][0]['row'] . ')</span></span>';
                    if($clearanceVal['product_row'][0]['row']>4 || ($is_mobile && $clearanceVal['product_row'][0]['row'] >2)){
                        $clearance_pro_str .='<a class="clh_right_tit3 all_btn" onclick="spinloader()"  href="'.zen_href_link('clearance_list','type='.$clearanceVal['clearance_id']).'">'.FS_LEARN_MORE.'<span class="iconfont">&#xf089;</span></a>';
                    }
                    $clearance_pro_str .='</div>';
                    $clearance_pro_str .= '<div class="clh_right_prolist"><ul>';
                    foreach($clearanceVal['type_product'] as $list=>$right_list){
                        if ($list > 3) {
                            break;
                        }
                        $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $right_list['products_id'], 'NONSSL');
                        $productImageSrc = $right_list['products_image'];
                        $new_name = zen_get_products_name($right_list['products_id']);
                        $image =  get_resources_img($right_list['products_id'],'180','180',$productImageSrc,$new_name,$new_name);

                        //产品库存部分
                        //判断该产品产否是定制产品，若是定制产品默认不勾选属性不需展示库存
                        if(zen_get_products_length_total($right_list['products_id']) != 0 || zen_get_products_attributes_total($right_list['products_id']) != 0){
                            $isCustom = false;
                        }else{
                            $isCustom = true;
                        }
                        if(in_array($right_list['products_id'],[75874,75875,75877])){
                            $isCustom = true;
                        }
                        $shippingInfo = new shippingInfo(array('pid'=>$right_list['products_id'],'current_category'=>[0],'is_set_custome_tag'=>$isCustom));

                        //正常价
                        $wp_price = zen_get_products_base_price($right_list['products_id']);
                        //清仓原价
                        $cle_price = zen_get_products_base_price($right_list['products_id'],true);
                        $country_code = strtoupper($_SESSION['countries_iso_code']);
//                    if($country_code == 'AU' && !$shippingInfo->au_gsp_is_buck()){
//                        $wp_price = get_gsp_tax_price($country_code,$wp_price);
//                        $cle_price = get_gsp_tax_price($country_code,$cle_price);
//                    }

                        $new_product_name = mb_substr($new_name, 0, 500,'UTF-8');
                        $is_inquiry_cle = $right_list['is_inquiry'];
                        $is_customized = $right_list['is_customized'];
                        //法国德英站详情页产品含税价格按照19%计算
                        $clearance_tax_price = '';
                        $clearance_tax_class = '';
                        //计算折扣比
                        if ($is_inquiry_cle != '1') {
                            if (!in_array($right_list['products_id'], $wholesaleproducts)) {
                                $discount_price = $currencies->new_format_clearance($wp_price,0);
                                $original_price = $currencies->new_format_clearance($cle_price,0);
                            } else {
                                $discount_price = $currencies->new_format_clearance($wp_price,1);
                                $original_price = $currencies->new_format_clearance($cle_price,1);
                            }
                            //是否取整之后在乘以税率
                            $discount_price = get_gsp_tax_price($country_code,$discount_price);
                            $original_price = get_gsp_tax_price($country_code,$original_price);
                            $clearance_price = $currencies->update_format($discount_price);
                            $clearance_original_price = $currencies->update_format($original_price);
                            if (in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de') {
                                $clearance_tax_price = $currencies->update_format($discount_price * 1.19);
                                $clearance_tax_class = 'de_tax_old_price';
                            }
                        } else {
                            $discount_price = 0;
                            $original_price = 0;
                        }
                        //添加降价幅度的标识（原价-折扣价）/原价*100%
                        if($original_price != 0){
                            $discount = round(($original_price-$discount_price)/$original_price*100);
                        }
                        $discount_html = '';
                        if ($discount > 0) {
                            $discount_html = '<div class="clh_percentage_num">'.str_replace('##NUM##', $discount, FS_DISCOUNT).'</div>';
                        }
                        if($list == 2) {
                            $class = 'choosez';
                        }elseif($list == 3){
                            $class = 'choosez last';
                        }else{
                            $class = '';
                        }
                        //列表页 产品应用标签
                        $products_tag_html = $products_vice_tag_html = $vice_tag_html ='';
                        if (in_array($_SESSION['languages_code'], array('uk', 'dn' , 'au', 'en'))){
                            $session = 1;
                        } else {
                            $session = $_SESSION['languages_id'];
                        }
                        $tagInfo = $db->Execute("select tags, vice_tags from products_list_tags where products_id = ".$right_list['products_id']." and languages_id =" .$session);

                        $pro_tags = $tagInfo->fields['tags']; //主标签
                        $pro_vice_tags = $tagInfo->fields['vice_tags']; //副标签
                        if ($pro_tags){ //主标签
                            $p_tags = explode('#',$pro_tags);
                            $p_tags = array_filter($p_tags); //去掉数组中的空元素
                            if (sizeof($p_tags)) {
                                foreach ($p_tags as $key => $p_tag){
                                    if ($p_tag != ''){
                                        $p_tag = content_preg_mtp($p_tag);
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
                            $right_list['products_name'] = str_replace('NEOCLEAN', 'NEOCLEAN®', $right_list['products_name']);
                            $products_vice_tag_html = str_replace('NEOCLEAN™', 'NEOCLEAN®', $products_vice_tag_html);
                        }

                        $clearance_pro_str .= '<li class="clh_product_li ' . $class . '">';
                        $clearance_pro_str .= '<div class="clh_product_img">';
                        $clearance_pro_str .='<a target="_blank" href="' . $href_link . '">' . $image . '</a>';
                        //手机站不展示qv按钮
                        $qv_btn_str = $is_mobile?'':'<div class="new_proList_QkviewBtn"><a href="javascript:;" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'. $right_list['products_id'].'"><div class="new_proList_QkviewBtnTa"><div class="new_proList_QkviewBtnTaCe icon iconfont">&#xf142;</div></div></a></div>';
                        $clearance_pro_str .=$qv_btn_str;
                        $clearance_pro_str .=$discount_html;
                        $clearance_pro_str .='</div>';
                        $clearance_pro_str .= '<a target="_blank" title="' . $new_product_name . '" href="' . $href_link . '"><h1 class="clh_product_txt">' . $new_product_name . '</h1></a>';
                        $clearance_pro_str .= '<div class="new_proList_applyBox_wrap">';
                        $clearance_pro_str .= '<div class="new_proList_applyBox after first-col">' . $products_tag_html . '</div>';
                        $clearance_pro_str .= $products_vice_tag_html;
                        $clearance_pro_str .= '</div>';
                        $clearance_pro_str .= '<div class="price_z">';
                        if ($is_inquiry_cle != '1') {
                            if ($clearance_tax_price) {
                                $clearance_pro_str .= '<span class="de_price_text">'.$clearance_price.FS_PRICE_EXCL_VAT.'</span>';
                            } else {
                                $clearance_pro_str .= $clearance_price;
                            }
                            $add_to_cart = $is_mobile && $_SESSION['languages_id'] == 1?'Add':FS_ADD_TO_CART;
                        } else {
                            $clearance_pro_str .= '-';
                            $add_to_cart = GET_A_QUOTE;
                        }
                        //清仓产品原价
                        $clearance_pro_str .= '<div class="old_price_zBox '.$clearance_tax_class.'"><strong class="old_price_z">';
                        if($right_list['products_clearance_price'] > 0){
                            if ($is_inquiry_cle != '1') {
                                if ($clearance_tax_price) {
                                    $clearance_pro_str .= $clearance_original_price.FS_PRICE_EXCL_VAT;
                                } else {
                                    $clearance_pro_str .= $clearance_original_price;
                                }
                            } else {
                                $clearance_pro_str .= '-';
                            }
                        }
                        $clearance_pro_str .= '<span class="old_price_line"></span></strong></div>';
                        if ($clearance_tax_price) {
                            $clearance_pro_str .= '<span class="de_tax_price_text">'.$clearance_tax_price.FS_PRICE_INCL_VAT.'</span>';
                        }
                        $clearance_pro_str .= '</div>';
                        $clearance_pro_str .= '<div class="clh_product_info">';
                        $clearance_pro_str .= '<div class="new_proList_ListBtxt1">';

                        $products_price_str = $shippingInfo->pure_price;
                        $clearance_pro_str .= $shippingInfo->showIntockDate($isCustom,1,$products_price_str);
                        $clearance_pro_str .= '</div>';

                        //$reviews = fs_get_data_from_db_fields('reviews_id', 'reviews', 'products_id=' . $product['id'], 'limit 1');
                        //第一页显示的评论
                        $redis_cache = get_redis_key_value('fs_clearance_count'.$right_list['products_id'],'clearance');
                        if($redis_cache){
                            $products_review = $redis_cache;
                        }else{
                            $fs_reviews->get_product_review_rating_show($right_list['products_id'], $is_mobile);
                            $products_review = $fs_reviews->review_total_count;
                            set_redis_key_value('fs_clearance_count'.$right_list['products_id'], $products_review, 7 * 24 * 3600, 'clearance');
                        }
                        //产品总销量
                        $product_total_sale = '';
                        //$total_sale = get_products_sale_total_num($product['id'],$product['category_arr'][1]);
                        //$product_total_sale = products_total_sales_show($total_sale+$product['offline_sales_num']);
                        $right_list['product_sales_total_num'] = isset($right_list['product_sales_total_num']) ? intval($right_list['product_sales_total_num']) : 0;
                        $right_list['offline_sales_num'] = isset($right_list['offline_sales_num']) ? intval($right_list['offline_sales_num']) : 0;
                        $product_total_sale = products_total_sales_show($right_list['product_sales_total_num'] + $right_list['offline_sales_num']);

                        $reviews_title = ($products_review>1) ? FS_PRODUCTS_SALES_REVIEWS : FS_PRODUCTS_SALES_REVIEW;
                        if(in_array($_SESSION['languages_code'],['fr','it']) && $product_total_sale>1){
                            $sales_sold = FS_PRODUCTS_SALES_SOLDS;
                        }else{
                            $sales_sold = FS_PRODUCTS_SALES_SOLD;
                        }
                        $clearance_pro_str .= '<div class="new_sales_container">
                            <a href="'.$href_link.'" target="_blank">
                                <span class="new_sales">'.(sprintf($sales_sold,'<em>'.$product_total_sale.'</em>')).'</span>
                            </a>
                            <i class="new_sales_border"></i>
                            <a href="'.reset_url('products/'.(int)$right_list['products_id'].'.html#all_reviews').'" target="_blank">
                                <span class="new_reviews">'.(sprintf($reviews_title,'<em>'.$products_review.'</em>')).'</span>
                            </a>
                        </div>';
                        $clearance_pro_str .= '<div class="product_list_text"><span>';
                        $clearance_pro_str .= '<input type="hidden"  name="product_min_qty"><input type="text" id="img_quantity_' . $right_list['products_id'] . '" value="1" maxlength = "5"  min="1" onblur="check_min_qty(this,' . $right_list['products_id'] . ')" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^\d]/g,\'\')" onfocus="enterKey(this,' . $right_list['products_id'] . ')" class="p_07 product_list_qty" autocomplete="off">
                     <div class="pro_mun">
                          <a href="javascript:void(clearance_quantity_change(1,' . $right_list['products_id'] . '));" class="cart_qty_add"></a>
                          <a href="javascript:void(clearance_quantity_change(0,' . $right_list['products_id'] . '));" class="cart_qty_reduce cart_reduce"></a>
                          </div>
                          </span>
                          </div>
                          <div class="product_list_btn">';
                        if ($is_customized != 1) {
                            if ($is_inquiry_cle != '1') {
                                $clearance_pro_str .= '<button type="submit" id="prod_add2_' . $right_list['products_id'] . '" onclick="prodAddtoCart2(' . $right_list['products_id'] . ',$(this))" name="Add to Cart" value="' . $add_to_cart . '" class="new_pro_addCart_btn" placeholder="">
                                    <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '
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
                                $clearance_pro_str .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                            }
                        } else {
                            $clearance_pro_str .= '<a class="button_02"  id="" href=' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $right_list['products_id']) . ' ><span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>' . $add_to_cart . '</a>';
                        }
                        $clearance_pro_str .= '</div></div></li>';
                    }
                    $clearance_pro_str .='</ul></div>';
                }
            }
        }
        $product_list_content .= '
                    <div class="clh_right_list">
                        <div class="clh_right_box">
                            <div class="clh_right_cont">
                               '.$clearance_pro_str.'
                            </div>
                        </div>
                    </div>';
    }
    //image展示方式 list展示方式 ids该分类所以产品 page分页代码 row产品总数
    if($type=='list') {
        return array(
            'image' => $products_image_info,
            'list'  => $products_list_info,
            'ids'   => $ids,
            'page'  => $page_links,
            'row'   => $clearance_counts
        );
    }elseif ($type=='all'){
        return $product_list_content;
    }
}