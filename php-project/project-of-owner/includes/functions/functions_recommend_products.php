<?php
/**
 * functions_recommend_products
 * 推荐产品相关的函数
 */

// 辅助函数：将一个二维数组（只有一个），转换成一维数组
function twoarray_to_onearray($data,$field){
    $new_data =  array();
    foreach ($data as $value) {
        $new_data[] = $value[$field];
    }
    return $new_data;
}

// 基本方法 start----------------------------
// 根据 销售统计表，获取 推荐产品列表
function get_recommendation_products_by_sales_statistics($out_config){
    global $db;
    global $fsCurrentInquiryField;
    $inner_config = array( 'where'=>'' , 'order'=>'pss.stock_out_frequency desc,pss.total_sales desc' , 'limit'=>5 );
    $config =  array_merge( (array)$inner_config, (array)$out_config  );
    $config['order'] .= ',pss.id asc '; //默认值
    if((int)$_SESSION['languages_id'] != 1) {
        $config['where'] .= ' and dd.products_name not like "Customized%" and p.products_status=1 ';
    }else{
        $config['where'] .= ' and d.products_name not like "Customized%" and p.products_status=1 ';
    }

    $sql = 'select p.products_id,p.products_price,p.'.$fsCurrentInquiryField.' as is_inquiry,d.products_name
            from products_sales_statistics pss
            left join  ' . TABLE_PRODUCTS . ' as p on pss.products_id = p.products_id
            left join '.TABLE_PRODUCTS_DESCRIPTION.' d on d.products_id = p.products_id and d.language_id = '.(int)$_SESSION['languages_id'];
    if((int)$_SESSION['languages_id'] != 1){
        $sql .= ' left join products_description dd on dd.products_id = p.products_id and dd.language_id = 1 ';
    }
    $sql .= ' where 1 '.$config['where'].'
            order by '.$config['order'].'
            limit '.$config['limit'];
//    var_dump($sql);exit();
    $products_list = $db->getAll($sql);
    return $products_list;
}

// 根据推荐产品关联表，获取 推荐产品列表
function get_recommendation_products_by_recommendation_relation($out_config){
    global $db;
    global $fsCurrentInquiryField;
    $inner_config = array( 'where'=>'' , 'order'=>'prr.frequency desc' , 'limit'=>5 );
    $config =  array_merge( (array)$inner_config, (array)$out_config  );
    $config['order'] .= ',prr.id asc';
    if((int)$_SESSION['languages_id'] != 1) {
        $config['where'] .= ' and dd.products_name not like "Customized%" and p.products_status=1 ';
    }else{
        $config['where'] .= ' and d.products_name not like "Customized%" and p.products_status=1 ';
    }

    $sql = 'select p.products_id,p.products_price,p.'.$fsCurrentInquiryField.' as is_inquiry,d.products_name
            from products_recommendation_relation prr
            left join  ' . TABLE_PRODUCTS . ' as p on prr.matched_products_id = p.products_id
            left join '.TABLE_PRODUCTS_DESCRIPTION.' d on d.products_id = p.products_id and d.language_id = '.(int)$_SESSION['languages_id'];
    if((int)$_SESSION['languages_id'] != 1){
        $sql .= ' left join products_description dd on dd.products_id = p.products_id and dd.language_id = 1 ';
    }
    $sql .= ' where 1 '.$config['where'].' 
            order by '.$config['order'].' 
            limit '.$config['limit'];

//    var_dump($sql);exit();
    $products_list = $db->getAll($sql);
    return $products_list;
}

// 获取的数据进行整理
// $is_need_attributes 参数，是否需要 产品的属性信息，（在判断加入购车的时候需要\去除非标准产品）
// $is_remve_no_standard 参数，是否去掉 非标准产品（不能直接购买的产品）
function organize_data($products_list,$is_need_attributes=false,$is_remve_no_standard=false){
    foreach($products_list as $key => $value){
        if($is_need_attributes){
            $products_list[$key]['options_name'] = $options_name = fs_products_option_info($value['products_id'],false);
            $products_list[$key]['productLengthInfo'] = $productLengthInfo = fs_product_length_info($value['products_id']);
            // 如果去掉非标准产品，后面有一种存在就是非标准产(从fs_products_option_info.php复制过来的)
            if($is_remve_no_standard && ( sizeof($options_name) || $productLengthInfo || $value['is_inquiry'] == '1') ){
                unset($products_list[$key]);
            }
        }

        $products_list[$key]['href_link'] = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$value['products_id'],'NONSSL');
        $products_list[$key]['products_name'] = substr($value['products_name'],0,70);
        $products_list[$key]['wp_image'] = $wp_image = zen_get_products_image_of_products_id($value['products_id']);
        $products_list[$key]['image_src'] = $image_src  = file_exists(DIR_WS_IMAGES.$wp_image) ? DIR_WS_IMAGES.$wp_image: DIR_WS_IMAGES.'no_picture.gif';
        $products_list[$key]['image'] = get_resources_img($value['products_id'],120,120,$wp_image,'',$wp_image);
    }
    return $products_list;
}
// 基本方法 end----------------------------


// 页面调用的方法 start-------------------------
// 产品详情页，获取推荐产品
function get_recommendation_products_at_product_info($products_id,$three_categories_id,$limit=30){
    // 1、从 推荐产品关联表 中提取$limit个产品，按匹配度降序
    if($three_categories_id){
        $where = ' and prr.products_id="'.$products_id.'" and prr.matched_three_categories_id!="'.$three_categories_id.'" ';
    }else{
        $where = ' and prr.products_id="'.$products_id.'" ';
    }
    $products_list = get_recommendation_products_by_recommendation_relation( array( 'where'=>$where , 'limit'=>$limit ) );
//    var_dump($products_list);
    $count = count($products_list);

    if($count < $limit){
        // 2、如果不够的话，再从 产品销售统计表 中提取，按出库频率降序
        $limit1 =  $limit - $count;

        $products_ids_arr = twoarray_to_onearray( $products_list,'products_id');
        $products_ids_arr[] = $products_id; //加上当前的产品ID
        $products_ids_str = implode(',',$products_ids_arr);
        // 去除重复的数据
        $where = !empty($products_ids_str)?' and pss.products_id not in('.$products_ids_str.') ':'';
        if($three_categories_id){
            $where .= ' and pss.three_categories_id!="'.$three_categories_id.'" ';
        }
        $products_list1 = get_recommendation_products_by_sales_statistics( array( 'where'=>$where, 'limit'=>$limit1 ) );
//      var_dump($products_list1);
        $products_list =  array_merge( (array)$products_list, (array)$products_list1  );
    }
    //var_dump($products_list);
    return organize_data($products_list,true,true);
}

// 产品分类页，获取推荐产品
function get_recommendation_products_at_product_list($one_categories_id,$limit=30){
    // 从 产品销售统计表 中挑选用除此二级分类外的其他类别外的ID，按出库频率降序
    $where = ' and pss.one_categories_id != "'.$one_categories_id.'" ';
    $products_list = get_recommendation_products_by_sales_statistics( array( 'where'=>$where, 'limit'=>$limit )  );

    return organize_data( $products_list,true);
}

// 购物车，获取推荐产品
function get_recommendation_products_at_shopping($products_id,$one_categories_id,$all_limit=10){
    // 对于购物车过度页面，有时候会出现不存在$products_id的情况。当右上角异步清空购物车的时候
    if($products_id){
        // 1、选取 推荐产品关联表 中同一级分类内的5个产品，匹配度降序，
        $where = ' and prr.products_id="'.$products_id.'" and prr.matched_one_categories_id="'.$one_categories_id.'" and prr.matched_products_id!="'.$products_id.'" ';
        $limit = 5;
        $products_list = get_recommendation_products_by_recommendation_relation( array( 'where'=>$where, 'limit'=>$limit ) );
//        var_dump($products_list);
        $count = count($products_list);

        // 2、其他分类中的产品，匹配度降序，补够$all_limit个
        $limit1  = $all_limit - $count;
        $where = ' and prr.products_id="'.$products_id.'" and prr.matched_one_categories_id!="'.$one_categories_id.'" and prr.matched_products_id!="'.$products_id.'" ';
        $products_list1 = get_recommendation_products_by_recommendation_relation( array( 'where'=>$where, 'limit'=>$limit1 ) );
//        var_dump($products_list1);
        $count1 = count($products_list1);

        $products_list = array_merge( (array)$products_list, (array)$products_list1  );
        $count2 = $count + $count1;
    }else{
        $products_list =  array();
        $count2 = 0;
    }

    if($count2 != $all_limit){
        // 3、如果不够$all_limit个，从 产品销售统计表（products_sales_statistics），按销量降序
        $limit2 =  $all_limit - $count2;
        $products_ids_arr = twoarray_to_onearray( $products_list,'products_id');
        $products_ids_arr[] = $products_id;
        $products_ids_str = implode(',',$products_ids_arr);
        $where = !empty($products_ids_str)?' and pss.products_id not in('.$products_ids_str.') ':'';// 去除重复的数据
        $products_list2 = get_recommendation_products_by_sales_statistics( array( 'where'=>$where, 'limit'=>$limit2 ) );
//        var_dump($products_list2);
        $products_list =  array_merge( (array)$products_list, (array)$products_list2  );
    }
//    var_dump($products_list);
    return organize_data( $products_list,true);
}

// 首页，获取推荐产品
function get_recommendation_products_at_index($limit='30'){
    // 按照 产品销售统计表，按出库频率降序
    $products_list = get_recommendation_products_by_sales_statistics(array( 'limit'=>$limit ) ) ;

    return organize_data( $products_list);
}
// 页面调用的方法 end-------------------------