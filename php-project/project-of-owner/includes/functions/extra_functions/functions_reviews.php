<?php
/*
 * $reviews_score 评论分数
 * $classname   class名称
 * $products_id 产品ID 如果产品id存在则点击星星可以跳转到该页面定位到评论锚点
 * $reviews_count 评论数量
 */

function fs_product_reviews_level_show($reviews_score, $reviews_width, $reviews_sums, $classname = '', $products_id='', $reviews_count='',$m_reviews = false)
{
    $title = '';
    $html = '';
    if(!empty($classname) || !empty($products_id)){
        if(in_array($_SESSION['languages_code'],array('ru','jp'))){
            $title = 'title="' . FS_REVIEWS_STARS_TITLE . $reviews_score . '"';
        }else{
            $title = 'title="' . $reviews_score . ' '.FS_REVIEWS_STARS_TITLE . '"';
        }
    }
    if(!empty($products_id)){
        $html .='<a href="'.reset_url('products/'.(int)$products_id.'.html#all_reviews').'" target="_blank">';
    }
    if($m_reviews){
        $html .= '<div class="new-fsproStars-box '.$classname.' after" '.$title.'>';
        $html .= '<div class="new-fsproStars-main">
                      <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>';
        if ($reviews_score <= 1.0 && $reviews_score > 0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon" style="width:' . $reviews_width . '%">&#xf132;</div>';
        }
        if ($reviews_sums >= 1 && $reviews_score != 1.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon">&#xf132;</div>';
        }
        $html .= '</div>';
        $html .= '<div class="new-fsproStars-main">
            <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>';
        if ($reviews_score <= 2.0 && $reviews_score > 1.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon" style="width:' . $reviews_width . '%">&#xf132;</div>';
        }
        if ($reviews_sums >= 2 && $reviews_score != 2.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon">&#xf132;</div>';
        }
        $html .= '</div>';
        $html .= '<div class="new-fsproStars-main">
            <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>';
        if ($reviews_score <= 3.0 && $reviews_score > 2.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon" style="width:' . $reviews_width . '%">&#xf132;</div>';
        }
        if ($reviews_sums >= 3 && $reviews_score != 3.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon">&#xf132;</div>';
        }
        $html .= '</div>';
        $html .= '<div class="new-fsproStars-main">
            <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>';
        if ($reviews_score <= 4.0 && $reviews_score > 3.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon" style="width:' . $reviews_width . '%">&#xf132;</div>';
        }
        if ($reviews_sums >= 4 && $reviews_score != 4.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon">&#xf132;</div>';
        }
        $html .= '</div>';
        $html .= '<div class="new-fsproStars-main">
            <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>';
        if ($reviews_score > 4.0) {
            $html .= '<div class="iconfont icon new-fsproStars-icon" style="width:' . $reviews_width . '%">&#xf132;</div>';
        }else{
            $html .= '<div class="iconfont icon new-fsproStars-icon" style="width:0%">&#xf132;</div>';
        }
        $html .= '</div></div>';
    }else{

        $html .= '<div class="pro_star ' . $classname . '" '.$title.'><div class="pro_star_gray">';
        if ($reviews_score <= 1.0 && $reviews_score > 0) {
            $html .= '<div class="pro_star_hover" style="width:' . $reviews_width . '%"></div>';
        }
        if ($reviews_sums >= 1 && $reviews_score != 1.0) {
            $html .= '<div class="pro_star_hover"></div>';
        }
        $html .= ' </div><div class="pro_star_gray">';
        if ($reviews_score <= 2.0 && $reviews_score > 1.0) {
            $html .= '<div class="pro_star_hover" style="width:' . $reviews_width . '%"></div>';
        }
        if ($reviews_sums >= 2 && $reviews_score != 2.0) {
            $html .= '<div class="pro_star_hover"></div>';
        }
        $html .= '</div><div class="pro_star_gray">';
        if ($reviews_score <= 3.0 && $reviews_score > 2.0) {
            $html .= '<div class="pro_star_hover" style="width:' . $reviews_width . '%"></div>';
        }
        if ($reviews_sums >= 3 && $reviews_score != 3.0) {
            $html .= '<div class="pro_star_hover"></div>';
        }
        $html .= '</div><div class="pro_star_gray">';
        if ($reviews_score <= 4.0 && $reviews_score > 3.0) {
            $html .= '<div class="pro_star_hover" style="width:' . $reviews_width . '%"></div>';
        }
        if ($reviews_sums >= 4 && $reviews_score != 4.0) {
            $html .= '<div class="pro_star_hover"></div>';
        }
        $html .= '</div><div class="pro_star_gray">';
        if ($reviews_score > 4.0) {
            $html .= '<div class="pro_star_hover" style="width:' . $reviews_width . '%"></div>';
        }
        $html .= '</div></div>';
    }

    if(!empty($products_id)){
        $html .='<span class="new_proList_ListBtxt">'.($reviews_count ? $reviews_count : 0).'</span>';
        $html .= '</a>';
    }
    return $html;
}

function fs_product_custom_html_forID($param)
{
    $html = '';
    $html .= '<div class="question_text"><div class="question_bg"></div><div class="question_text_01 leftjt">
        <div class="arrow"></div><div class="popover-content">' . $param . '</div></div></div>';
}

function zen_products_reviews_total_rating($products_id)
{
    global $db;
    $rating_total_sql = "select sum(r.reviews_rating) as total from " . TABLE_REVIEWS_DESCRIPTION . " AS rd LEFT JOIN " . TABLE_REVIEWS .
        " AS r ON(rd.reviews_id = r.reviews_id) LEFT JOIN " . TABLE_PRODUCTS . " AS p  ON(r.products_id = p.products_id)
			WHERE rd.languages_id = " . (int)$_SESSION['languages_id'] . "
			AND p.products_id = :products_id
			AND r.status = 1
			";
    $rating_total_sql = $db->bindVars($rating_total_sql, ':products_id', (int)$products_id, 'integer');
    $ratings_total = $db->Execute($rating_total_sql)->fields['total'];
    return $ratings_total;
}

function zen_products_reviews_count($products_id)
{
    global $db;

    $sql = "SELECT COUNT(reviews_id) AS total  FROM " . TABLE_REVIEWS . " as r 
			 WHERE r.languages_id = :languages_id: AND r.products_id = :products_id";
    $sql = $db->bindVars($sql, ':languages_id:', (int)$_SESSION['languages_id'], 'integer');
    $result = $db->Execute($db->bindVars($sql, ':products_id', $products_id, 'integer'));
    return $result->fields['total'];
}

function zen_get_reviews_products_related($products_id)
{
    $products_related_id = '';
    $products_related_id = fs_get_data_from_db_fields('customized_id', 'products_instock_other_customized_related', 'products_id=' . (int)$products_id, '');
    if (!$products_related_id) {
        $products_related_id = $products_id;
    }
    return $products_related_id;
}

function zen_get_model_related_id($related_id)
{
    global $db;
    //模块关联表
    if (sizeof($related_id)) {
        $model_sql = 'select model_id from products_instock_add_related where products_id in (' . implode(',', $related_id) . ')';
        $model_rst = $db->Execute($model_sql);
        $mid = array();
        if ($model_rst->RecordCount()) {
            while (!$model_rst->EOF) {
                $mid[] = $model_rst->fields['model_id'];
                $model_rst->MoveNext();
            }
        }
        if (sizeof($mid)) {
            $mode_next_sql = 'select products_id from products_instock_add_related where model_id in (' . implode(',', $mid) . ') and warehouse <>0';
            $mode_next_rst = $db->Execute($mode_next_sql);
            $mode_next_arr = array();
            if ($mode_next_rst->RecordCount()) {
                while (!$mode_next_rst->EOF) {
                    $mode_next_arr[] = $mode_next_rst->fields['products_id'];
                    $mode_next_rst->MoveNext();
                }
                if (sizeof($mode_next_arr)) {
                    $related_id = array_merge($related_id, $mode_next_arr);
                    $related_id = array_flip($related_id);
                    $related_id = array_flip($related_id);//翻转两次，去重
                    $related_id = array_merge($related_id);
                }
            }
        }
    }
    return $related_id;
}

function zen_get_model_related($products_id, $related_arr)
{
    global $db;
    if ($products_id) {
        $md_czed = fs_get_data_from_db_fields('customized_id', 'products_instock_customized_related', 'customized_id=' . (int)$products_id . ' or products_id=' . (int)$products_id, 'limit 1');
        $md_id = array();
        if ($md_czed) {
            $sql = 'select products_id from products_instock_customized_related where customized_id=' . (int)$md_czed;
            $rst = $db->Execute($sql);
            if ($rst->RecordCount()) {
                while (!$rst->EOF) {
                    $md_id[] = $rst->fields['products_id'];
                    $rst->MoveNext();
                }
            }
            //添加定制产品本身
            $md_id[] = $md_czed;
        }
        if (sizeof($md_id)) {
            $related_id = array_merge($related_arr, $md_id);
            $related_id = array_unique($related_id);
        } else {
            $related_id = $related_arr;
        }
    } else {
        $related_id = $related_arr;
    }

    return $related_id;
}

function get_custom_reviews_related($products_id){
    global $db;
    $products_id = (int)$products_id;
    $related_id = [];
    $main_id = [];
    if(empty($products_id)){
        return false;
    }
    $pid = fs_get_data_from_db_fields('pid','reviews_to_pid_related_pid','pid='.$products_id.' or related_pid='.$products_id,'limit 1');
    if($pid){
        $sql = "SELECT pid,related_pid FROM reviews_to_pid_related_pid WHERE pid=".(int)$pid;
        $rst = $db->Execute($sql);
        while (!$rst->EOF){
            $main_id = $rst->fields['pid'];
            $related_id[] = $rst->fields['related_pid'];
            $rst->MoveNext();
        }
        $related_id[] = $main_id; //如果自定义关联有数据
    }
    return $related_id;
}

function zen_get_reviews_related($products_id)
{
    global $db;
    $products_id = (int)$products_id;
    if(empty($products_id)){
        return false;
    }
    $related_id = get_custom_reviews_related($products_id);
    //自定义关联有数据则优先调取
    if($related_id){
        return $related_id;
    }

    $products_related_id = fs_get_data_from_db_fields('customized_id', 'products_instock_other_customized_related', 'customized_id=' . (int)$products_id, 'order by customized_related_id asc limit 1');
    //旧表定制产品ID
    if ($products_related_id) {
        $sql = 'select products_id from products_instock_other_customized_related where customized_id=' . (int)$products_related_id;
        $rst = $db->Execute($sql);
        if ($rst->RecordCount()) {
            while (!$rst->EOF) {
                $related_id[] = $rst->fields['products_id'];
                $rst->MoveNext();
            }
        }
        $related_id = zen_get_model_related($products_related_id, $related_id);
        $related_id[] = $products_id;
        $related_id = zen_get_model_related_id($related_id);
    } else {
        $customized_id = fs_get_data_from_db_fields('customized_id', 'products_instock_other_customized_related', 'products_id=' . (int)$products_id, 'order by customized_related_id asc limit 1');
        if ($customized_id) {
            $sql = 'select products_id from products_instock_other_customized_related where customized_id=' . (int)$customized_id;
            $rst = $db->Execute($sql);
            if ($rst->RecordCount()) {
                while (!$rst->EOF) {
                    $related_id[] = $rst->fields['products_id'];
                    $rst->MoveNext();
                }
            }
            $related_id = zen_get_model_related($customized_id, $related_id);
            $related_id[] = $customized_id;
            $related_id = zen_get_model_related_id($related_id);
        } else {
            //不属于标准ID和定制ID
            $pid = $products_id;
            $model_id = fs_get_data_from_db_fields('model_id', 'products_instock_add_related', 'products_id=' . (int)$pid, 'limit 1');
            if ($model_id) {
                $pro_id = fs_get_data_from_db_fields('products_id', 'products_instock_add_model', 'model_id=' . (int)$model_id, 'limit 1');
                if ($pro_id) {
                    $model_customized_id = fs_get_data_from_db_fields('customized_id', 'products_instock_other_customized_related', 'products_id=' . (int)$pro_id, 'limit 1');
                    if ($model_customized_id) {
                        $sql = 'select products_id from products_instock_other_customized_related where customized_id=' . (int)$model_customized_id;
                        $rst = $db->Execute($sql);
                        if ($rst->RecordCount()) {
                            while (!$rst->EOF) {
                                $related_id[] = $rst->fields['products_id'];
                                $rst->MoveNext();
                            }
                        }
                        $related_id = zen_get_model_related($model_customized_id, $related_id);
                        $related_id[] = $model_customized_id;
                        $related_id = zen_get_model_related_id($related_id);
                    } else {
                        $related_id = zen_get_model_related($pro_id, array());
                        $related_id = zen_get_model_related_id($related_id);
                    }
                }
            } else {
                //只有products_instock_customized_related存在定制ID 其它表不存在
                $related_id = zen_get_model_related($pid, array());
                $related_id = zen_get_model_related_id($related_id);
            }
        }
    }
    if (!$related_id) {
        $related_id = array($products_id);
    }
    return $related_id;
}

/*
 * 获取图片评论的方法
 * @param int $reviews_id 评论id
 * @param int $product_id 产品id
 * @return array 返回图片数组
 * */

function get_reviews_images($reviews_id, $product_id = '')
{
    global $db;
    $source_arr = array();

    //原图,原图id
    $reviewsSQL = $db->Execute("select reviews_image,reviews_image_id from reviews_image where reviews_id =" . $reviews_id . " and products_id =" . (int)$product_id);
//原图id
    if ($reviewsSQL->RecordCount()) {
        $reviews_image_id = array();
        $products_review_img = array();
        while (!$reviewsSQL->EOF) {
            $reviews_image_id[] = $reviewsSQL->fields['reviews_image_id'];
            $products_review_img[] =  $reviewsSQL->fields['reviews_image'];

            $reviewsSQL->MoveNext();
        }
        //根据原图id 查看切割图是否存在
        if (sizeof($reviews_image_id)) {
            $sql = "select reviews_image_tb,id,reviews_image_id,size_w,size_h from reviews_image_thumb where reviews_image_id in (" . implode(',', $reviews_image_id) . ") order by id";
            $resourceSQL = $db->Execute($sql);
            if ($resourceSQL->RecordCount()) {
            //if (0) {
                $products_review_img = array();
                while (!$resourceSQL->EOF) {
                    $products_review_img [$resourceSQL->fields['reviews_image_id']][] = $resourceSQL->fields['reviews_image_tb'];
                    $products_review_img [$resourceSQL->fields['reviews_image_id']][] = $resourceSQL->fields['size_w'];
                    $products_review_img [$resourceSQL->fields['reviews_image_id']][] = $resourceSQL->fields['size_h'];

                    $resourceSQL->MoveNext();
                }
                //切割图
                foreach ($products_review_img as $key => $value) {
                    //判断资源服务器中是否存在大小图   如果存在 那切割图  如果不存在 就拿前台的图片用zen_image 生产缩略图
                    $pat = '/[a-z]+[-]*[a-z]+[.]{1}[a-z\d\-]+[.]{1}[a-z\d]*[\/]{1}/';
                    if(1){
                        $small_img = HTTPS_IMAGE_SERVER . 'images/reviews/' . $value[0];
                        $big_img = HTTPS_IMAGE_SERVER . 'images/reviews/' . $value[3];
                        $small_str = '<img src="' . $small_img . '">';
                        $source_arr[$key] = array(
                            'big_img' => $big_img,
                            'small_img' => $small_str,
                            'big_w' => $value[4],
                            'big_h' => $value[5]
                        );
                    } else {
                        //服务器中的切割图没有上传成功
                        $small_src = file_exists(DIR_WS_IMAGES . 'revires/' . $value[0]) ? DIR_WS_IMAGES . 'revires/' . $value[0] : DIR_WS_IMAGES . 'no_picture.gif';
                        $image_geo = zen_products_geo_images($small_src, 100, 100);
                        $image = zen_image($small_src, '', $image_geo['width'], $image_geo['height'], ' border="0" ');
                        $info = zen_image_get_info($small_src, '', 500, 500, ' border="0" ');
                        $image_real = preg_replace($pat, 'www.fs.com/', $image);
                        if (!empty($image_real)) {
                            $image = $image_real;
                        }
                        $big_img = preg_replace($pat, 'www.fs.com/', $info['image']);
                        if (empty($big_img)) {
                            $big_img = $info['image'];
                        }
                        $width = $info['width'];
                        $height = $info['height'];
                        $small_str = $image;
                        $source_arr[$key] = array(
                            'big_img' => $big_img,
                            'small_img' => $small_str,
                            'big_w' => $width,
                            'big_h' => $height
                        );
                    }
                }
            } else {
                //切割图不存在,拿原图
                if(sizeof($products_review_img)) {
                    $source_arr = array();
                    for ($rpi = 0; $rpi < sizeof($products_review_img); $rpi++) {
                        //资源服务器没有图片的 直接调用  no_picture.gif
                        $small_img = '<img src="'.HTTPS_IMAGE_SERVER.'images/reviews/'.$products_review_img[$rpi].'"  width="100" height="100"/>';
                        $source_arr[$rpi] = array(
                            'big_img' => HTTPS_IMAGE_SERVER . 'images/reviews/'.$products_review_img[$rpi],
                            'small_img' => $small_img,
                            'big_w' => 500,
                            'big_h' => 500
                        );
                    }
                  }
               }
        }
    }
    return $source_arr;
}

/**
 * @Notes:
 *
 * @param $pid
 * @param $total
 * @param $page
 * @param $type
 * @param string $review_star
 * @param bool $is_hide
 * @param int $is_img
 * @return string
 * @auther: Dylan
 * @Date: 2020/11/19
 * @Time: 16:20
 */
function getReviewPage($pid,$total,$page,$type,$review_star='',$is_hide=false,$is_img=0){
    $content ='';
    if($total>1){
        //当前页
        //$pid = $_POST['id'];
        //$page = $_POST['page'];
        //总页数
        $page_num = $total;
        //初始化数据
        $start = 1;
        $end = $page_num;
        //第一页显示数量
        $showPage = 5;
        //中间显示数量以及偏移量
        $cenPage = 3;
        $pageoffset = ($cenPage -1)/2;
        //结尾显示数量
        $endPage = 4;
        if($page_num >= $showPage){
            //中间循坏输出
            if($page >= $showPage && $page <= $page_num -$cenPage) {
                $start = $page - $pageoffset;
                $start = (int)$start;
                $end = $page_num >$page + $pageoffset ? $page + $pageoffset :$page_num;
                $end = (int)$end;
            }else{
                //起始循坏
                $start = 1;
                $end = $page_num > $showPage ? $showPage : $page_num;
                $end = (int)$end;
            }
            //结尾循坏
            if ($page > $page_num -$cenPage && $page >= $showPage) {
                $start = $page_num -$cenPage;
                $end = $page_num;
            }
        }
        if($page){
            $next_page = $page+1;
            $prev_page = $page-1;
        }else{
            $next_page = 2;
        }
        if($is_img != 1){
            $onclick = 'onclick="star_screening_reviews('.($page-1).','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"';
        }else{
            $onclick = 'onclick="ajax_review_images('.($page-1).','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
        }

        /*2019.06.27  YOYO
       * PC端分页效果微调
       * */
        $display='';
        if($is_hide){
            $display = 'style="display: none"';
        }
        if(isMobile()){//M 端
            $content .= '<div class="FS_Newpation_en" id="page_one_2"><div class="FS_Newpation_box">';
            if ($page && $page!=1)
                $content .= '<a  href="javascript:;" class="list_Newpro_page not_first_page" '.$onclick.' data = "'.$prev_page.'"><em class="iconfont icon">&#xf090;</em></a>';
            else $content .= '<a href="javascript:;" class="list_Newpro_page choosez"><em class="iconfont icon">&#xf090;</em></a>';
            $content .= '<ul class="FS_Newpation_cont">';
            if($start >1){
                $onclick = ($is_img != 1)?'onclick="star_screening_reviews(1,'.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images(1,'.$pid.',1,'.$page_num.',this,'.$is_img.')"';
                $content .= '<li class="FS_Newpation_item"><a href="javascript:;" '.$onclick.' class="the_page" data="1">1</a></li>';
            }
            if($page >=$showPage && $page_num>$showPage){
                $content .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
            }
            if($page){
                for($i=$start;$i<=$end;$i++){
                    $onclick = ($is_img != 1)?'onclick="star_screening_reviews('.$i.','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images('.$i.','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
                    if($i==$page){
                        $content .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;" '.$onclick.' class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                    }else{
                        $content .= '<li class="FS_Newpation_item">
                    <a href="javascript:;" '.$onclick.'
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                    }
                }
            }
            if($page_num -$cenPage >= $page && $page_num>6&& $end!=$page_num){
                $content .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
            }
            if($end <= $page_num-1){
                $onclick = ($is_img != 1)?'onclick="star_screening_reviews('.$page_num.','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images('.$page_num.','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
                $content .= '<li class="FS_Newpation_item">
                    <a href="javascript:;" class="the_page" '.$onclick.' data = "'.$page_num.'">'.$page_num.'</a></li>';
            }
            $content .= '</ul>';
            $onclick = ($is_img != 1)?'onclick="star_screening_reviews('.($page+1).','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images('.($page+1).','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
            if (($page < $page_num) && ($page_num != 1))
                $content .= '<a href="javascript:;" class="list_Newnext_page not_first_page" '.$onclick.'> <i class="iconfont icon">&#xf089;</i></a>';
            else $content .= '<a href="javascript:;" class="list_Newnext_page choosez is_last_page" data="' . $next_page . '"><i class="iconfont icon">&#xf089;</i></a>';
            $content .= '</div></div>';
        }else{//PC 端
            $content .= '<div class="FS_Newpation_en" id="page_one_2" '.$display.'><div class="FS_Newpation_box">';
            if ($page && $page!=1)
                $content .= '<a  href="javascript:;" class="list_Newpro_page not_first_page" '.$onclick.' data = "'.$prev_page.'"><em class="iconfont icon">&#xf090;</em></a>';
            else $content .= '<a href="javascript:;" class="list_Newpro_page choosez"><em class="iconfont icon">&#xf090;</em></a>';
            $content .= '<ul class="FS_Newpation_cont">';
            if($start >1){
                $onclick = ($is_img != 1)?'onclick="star_screening_reviews(1,'.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images(1,'.$pid.',1,'.$page_num.',this,'.$is_img.')"';
                $content .= '<li class="FS_Newpation_item"><a href="javascript:;" '.$onclick.' class="the_page" data="1">1</a></li>';
            }
            if($page >=$showPage && $page_num>$showPage){
                $content .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
            }
            if($page){
                for($i=$start;$i<=$end;$i++){
                    $onclick = ($is_img != 1)?'onclick="star_screening_reviews('.$i.','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images('.$i.','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
                    if($i==$page){
                        $content .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;" '.$onclick.' class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                    }else{
                        $content .= '<li class="FS_Newpation_item">
                    <a href="javascript:;" '.$onclick.'
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                    }
                }
            }
            if($page_num -$cenPage >= $page && $page_num>6&& $end!=$page_num){
                $content .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
            }
            if($end <= $page_num-1){
                $onclick = ($is_img != 1)?'onclick="star_screening_reviews('.$page_num.','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images('.$page_num.','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
                $content .= '<li class="FS_Newpation_item">
                    <a href="javascript:;" class="the_page" '.$onclick.' data = "'.$page_num.'">'.$page_num.'</a></li>';
            }
            $content .= '</ul>';
            $onclick = ($is_img != 1)?'onclick="star_screening_reviews('.($page+1).','.$pid.',2,'.$page_num.',\''.$review_star.'\',this,false)"':'onclick="ajax_review_images('.($page+1).','.$pid.',1,'.$page_num.',this,'.$is_img.')"';
            if (($page < $page_num) && ($page_num != 1))
                $content .= '<a href="javascript:;" class="list_Newnext_page not_first_page" '.$onclick.'> <i class="iconfont icon">&#xf089;</i></a>';
            else $content .= '<a href="javascript:;" class="list_Newnext_page choosez is_last_page" data="' . $next_page . '"><i class="iconfont icon">&#xf089;</i></a>';
            $content .= '</div></div>';
        }
    }
    return $content;
}

/*
 * 获取评论分页的方法
 * $page 当前页
 * $page_num 总页数
 * $type 区分星星和more的onclick 事件
 * $pid 产品ID
 * $from_where 区分有无图片的onclick事件
 * */
function get_reviews_page($page,$page_num,$pid,$type,$from_where=0){
    //初始化数据
    $start = 1;
    $end = $page_num;
    //第一页显示数量
    $showPage = 5;
    //中间显示数量以及偏移量
    $cenPage = 3;
    $pageoffset = ($cenPage -1)/2;
    //结尾显示数量
    $endPage = 4;
    if($page_num >= $showPage){
        //中间循坏输出
        if($page >= $showPage && $page <= $page_num -$cenPage) {
            $start = $page - $pageoffset;
            $start = (int)$start;
            $end = $page_num >$page + $pageoffset ? $page + $pageoffset :$page_num;
            $end = (int)$end;
        }else{
            //起始循坏
            $start = 1;
            $end = $page_num > $showPage ? $showPage : $page_num;
            $end = (int)$end;
        }
        //结尾循坏
        if ($page > $page_num -$cenPage && $page >= $showPage) {
            $start = $page_num -$cenPage;
            $end = $page_num;
        }
    }
    if($page){
        $next_page = $page+1;
        $prev_page = $page-1;
    }else{
        $next_page = 2;
    }

    if($from_where ==1){
        $onclick = 'onclick="ajax_review_images('.($page-1).','.$pid.',3,'.$page_num.',this)"';
    }else{
        $onclick = ($type ==2)? 'onclick="star_screening_reviews('.($page-1).','.$pid.',2,'.$page_num.','.$_POST['review_star'].',this,false)"' : 'onclick="ajax_all_reviews('.($page-1).','.$pid.',1,'.$page_num.',this)"';
    }
    $content = '';
    $content .= '<div class="FS_Newpation_en" id="page_one_2"><div class="FS_Newpation_box">';
    if ($page && $page!=1)
        $content .= '<a  href="javascript:;" class="list_Newpro_page not_first_page" '.$onclick.' data = "'.$prev_page.'"><em class="iconfont icon">&#xf089;</em></a>';
    else $content .= '<a href="javascript:;" class="list_Newpro_page choosez"><em class="iconfont icon">&#xf090;</em></a>';
    $content .= '<ul class="FS_Newpation_cont">';
    if($start >1){
        if($from_where ==1){
            $onclick = 'onclick="ajax_review_images(1,'.$pid.',3,'.$page_num.',this)"';
        }else{
            $onclick = ($type ==2)?'onclick="star_screening_reviews(1,'.$pid.',2,'.$page_num.','.$_POST['review_star'].',this,false)"':'onclick="ajax_all_reviews(1,'.$pid.',1,'.$page_num.',this)"';
        }

        $content .= '<li class="FS_Newpation_item"><a href="javascript:;" '.$onclick.' class="the_page" data="1">1</a></li>';
    }
    if($page >=$showPage && $page_num>$showPage){
        $content .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
    }
    if($page){
        for($i=$start;$i<=$end;$i++){
            if($from_where ==1){
                $onclick = 'onclick="ajax_review_images('.$i.','.$pid.',3,'.$page_num.',this)"';
            }else{
                $onclick = ($type ==2)?'onclick="star_screening_reviews('.$i.','.$pid.',2,'.$page_num.','.$_POST['review_star'].',this,false)"':'onclick="ajax_all_reviews('.$i.','.$pid.',1,'.$page_num.',this)"';
            }

            if($i==$page){
                $content .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;" '.$onclick.' class="the_page" data = "'.$i.'">'.$i.'</a></li>';
            }else{
                $content .= '<li class="FS_Newpation_item">
                    <a href="javascript:;" '.$onclick.'
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
            }
        }
    }
    if($page_num -$cenPage >= $page && $page_num>6&& $end!=$page_num){
        $content .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
    }
    if($end <= $page_num-1){
        if($from_where ==1){
            $onclick = 'onclick="ajax_review_images('.$page_num.','.$pid.',3,'.$page_num.',this)" ';
        }else{
            $onclick = ($type ==2)?'onclick="star_screening_reviews('.$page_num.','.$pid.',2,'.$page_num.','.$_POST['review_star'].',this,false)"':'onclick="ajax_all_reviews('.$page_num.','.$pid.',1,'.$page_num.',this)"';
        }
        $content .= '<li class="FS_Newpation_item">
                    <a href="javascript:;" class="the_page" '.$onclick.' data = "'.$page_num.'">'.$page_num.'</a></li>';
    }
    $content .= '</ul>';
    if($from_where ==1){
        $onclick = 'onclick="ajax_review_images('.($page+1).','.$pid.',3,'.$page_num.',this)"';
    }else{
        $onclick = ($type ==2)?'onclick="star_screening_reviews('.($page+1).','.$pid.',2,'.$page_num.','.$_POST['review_star'].',this,false)"':'onclick="ajax_all_reviews('.($page+1).','.$pid.',1,'.$page_num.',this)"';
    }
    if (($page < $page_num) && ($page_num != 1))
        $content .= '<a href="javascript:;" class="list_Newnext_page not_first_page" '.$onclick.'> <i class="iconfont icon">&#xf089;</i></a>';
    else $content .= '<a href="javascript:;" class="list_Newnext_page choosez is_last_page" data="' . $next_page . '"><i class="iconfont icon">&#xf089;</i></a>';
    $content .= '</div></div>';
return $content;
}


function send_customer_and_admin_reviews_email($data){
    global $db;
    $oID = $data['orders_id'] ? $data['orders_id'] : "";
    $language_code = $data['language_code'] ? $data['language_code'] : "";
    //$customers_id = $data['customers_id'] ? $data['customers_id'] : "";
    $customers_name = $data['customers_name'] ? $data['customers_name'] : "";
    $order_number = $data['order_number'] ? $data['order_number'] : "";
    $customers_email_address = $data['customers_email_address'] ? $data['customers_email_address'] : "";

    if(empty($oID)){
        return;
    }else{
        $oID = (int)$oID;
    }


    //根据send comment emails 如果选择了completed 就发送评论邮件
    switch ($language_code){
        case 'es':
            $codes = '/es';
            break;
        case 'fr':
            $codes = '/fr';
            break;
        case 'ru':
            $codes = '/ru';
            break;
        case 'de':
            $codes = '/de';
            break;
        case 'jp':
            $codes = '/jp';
            break;
        case 'au':
            $codes = '/au';
            break;
        case 'mx':
            $codes = '/mx';
            break;
        case 'sg':
            $codes = '/sg';
            break;
        case 'uk':
            $codes = '/uk';
            break;
        case 'dn':
            $codes = '/de-en';
            break;
        case 'it':
            $codes = '/it';
            break;
        default:
            $codes = '';
    }
    if ($_SERVER['SERVER_NAME'] == "https://tx.fs.com") {
        $baseCode = "https://tx.fs.com";
    } else {
        $baseCode = "https://www.fs.com";
    }
    $order = new order((int)$oID);
    $subjectTittle = EMAIL_MESSAGE_TITTLE;
    $html_new = common_email_header_and_footer($subjectTittle,EMAIL_MESSAGE_01);
    $html_msg['EMAIL_NEW_HEADER'] = $html_new['header'];
    $html_msg['EMAIL_NEW_FOOTER'] = $html_new['footer'];
    $html_msg['EMAIL_MESSAGE_01'] = EMAIL_MESSAGE_01;
    $html_msg['EMAIL_MESSAGE_02'] = EMAIL_MESSAGE_02;
    $html_msg['EMAIL_MESSAGE_SUBTITLE'] = EMAIL_MESSAGE_SUBTITLE;
    /*$countryId = fs_get_data_from_db_fields('customer_country_id', 'customers', 'customers_id = ' . $_SESSION['customer_id']);
    if ($countryId == 223) {
        $html_msg['WANT_TO_BUY'] = '<table border="0" cellpadding="0" cellspacing="0" width="640">
							<tbody>
								<tr>
									<td bgcolor="#fff" height="320" style="border-collapse:collapse;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody>
												<tr>
													<td height="320" style="border-collapse:collapse;background:url(https://img-en.fs.com/includes/templates/fiberstore/images/email/mail-banner.jpg) no-repeat;position: relative;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td height="100%" style="border-collapse:collapse" valign="top" width="1%"></td>
																	<td align="center" style="border-collapse:collapse;font-family:Open Sans,arial,sans-serif;" valign="top" width="98%">
                                                                        <div style="margin-top: -132px;">
                                                                            <p style="font-family:Open Sans,arial,sans-serif;font-size: 16px; color: #fff;margin: 0;">
                                                                                Share Your Project with Photos and Stories
																			</p>
																			<p style="font-family:Open Sans,arial,sans-serif; color: #fff; font-size:22px; font-weight:600;margin: 10px 0;">
																				Get $20 Gift Card &amp; Win iPhone 12 Pro Max
                                                                            </p>
                                                                            <p style="font-family:Open Sans,arial,sans-serif;font-size: 14px; color: #fff;margin: 0;margin-bottom: 15px;">Coming Soon: 2020.11.20 - 2021.2.20</p>
                                                                            <a style="cursor: pointer;font-family:Open Sans,arial,sans-serif;font-size: 14px; color: #fff;margin: 0;text-decoration: none;" href="https://www.fs.com/specials/share-your-project-on-fs-120.html">Learn more<img src="https://img-en.fs.com/includes/templates/fiberstore/images/email/mail-right-icon.png" style="margin-left:5px; vertical-align:middle"></a>
																		</div>

																	</td>
																	<td height="100%" style="border-collapse:collapse" valign="top" width="1%"></td>
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
                        </table>';
    } else {
        $html_msg['WANT_TO_BUY'] = '';
    }*/
    $html_msg['WANT_TO_BUY'] = '';

    $reviewsUrl = $baseCode .$codes .'/index.php?main_page=orders_review_list&utm_source=newsletter&utm_medium=email&utm_campaign=review';
    $helpUrl = $baseCode .$codes .'/index.php?main_page=fs_single_pages&category_name=service&name=help_center&utm_source=newsletter&utm_medium=email&utm_campaign=review';
    $content = str_replace('ORDER_NUMBER',$order_number,EMAIL_MESSAGE_CONTENT);
    $content = str_replace('javascript:;', $reviewsUrl, $content);
    $html_msg['EMAIL_MESSAGE_CONTENT'] = $content;
    $html_msg['EMAIL_MESSAGE_SUB_CONTENT'] = str_replace('javascript:;',$helpUrl, EMAIL_MESSAGE_SUB_CONTENT);
    $html_msg['EMAIL_MESSAGE_REVIEW_URL'] = $reviewsUrl;
    $html_msg['EMAIL_MESSAGE_06'] = EMAIL_TO_LICENSE_5;
    $products_html = '';
    for ($k=0, $kn=sizeof($order->products); $k<$kn; $k++) {
        $products_images = $order->products[$k]['products_image'];
        $products_name = $order->products[$k]['name'];
        $products_url = HTTPS_SERVER.$codes.'/index.php?main_page=product_info&products_id='.$order->products[$k]['id'].'&utm_source=newsletter&utm_medium=email&utm_campaign=review';
        $products_html .= '<tr>
                                <td bgcolor="#fff" style="border-collapse: collapse;padding: 10px 0 10px 20px;" width="100">
                                    <a href="'.$products_url.'" style="text-decoration: none;">
                                        <img width="80" src="'.HTTPS_IMAGE_SERVER.'/images/'.$products_images .'">
                                    </a>
                                </td>
                                <td bgcolor="#fff"
										style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding: 0px 30px 0px 10px;">
                                    <a href="'.$products_url.'" style="text-decoration: none;color: #232323;">
                                        '.$products_name .'
                                        <span>#'.$order->products[$k]['id'] .'</span>
                                    </a>
                                </td>
                            </tr>';
    }
    $html_msg['EMAIL_MESSAGE_PRODUCTS'] = $products_html;
    sendwebmail($customers_name,$customers_email_address,'邀请评论客户邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,EMAIL_TO_LICENSE_6,$html_msg,'order_commend');
}

function getRatingClass($reviewRating = ''){
    $class = '';
    if (empty($reviewRating)) {
        return $class;
    }

    switch ($reviewRating) {
        case 1:
            $class = 'p_star05';
            break;
        case 2:
            $class = 'p_star04';
            break;
        case 3:
            $class = 'p_star03';
            break;
        case 4:
            $class = 'p_star02';
            break;
        default:
            $class = 'p_star01';
            break;
    }
    return $class;
}

function getRuReview($num){
    if (isMobile() && $_SESSION['languages_code'] == 'de') {
        return '';
    }
    if ($_SESSION['languages_code'] != 'ru') {
        if (in_array($_SESSION['languages_code'], array('es', 'mx'))) {
            return $num > 1 ? FS_REVIEWS_SMALL : FS_REVIEW;
        } else {
            return $num > 1 ? FS_REVIEWS : FS_REVIEW;
        }

    }
    if (in_array($num, [12, 14])) {
        return 'Отзывов';
    }
    if (in_array($num, [13,15,17,37,47,97,18,28,58,78])) {
        return  'Отзыв';
    }
    $_num = $num % 10;
    if ($_num == 0) {
        return 'Отзывов';
    } elseif ($_num == 1) {
        return 'Отзыв';
    } elseif (in_array($_num, [2,3,4])) {
        return 'Отзыва';
    } elseif (in_array($_num, [5,6,7,8,9])) {
        return 'Отзывов';
    }
}
