<?php

/**
 *
 * @author kevin
 * @toto manage reviews
 */
class fs_reviews
{
    public $review_total_count;
    public $review_total_score;
    public $review_total_rating;
    public $products_list_info;

    /*
     * 设置产品的产品的评论总信息
     * @para int $pid: 产品id
     * fairy 2019.3.23 add
     */
    public function get_review_total_info($pid)
    {
        global $db;
        $where = '';

        // 获取产品的关联产品
        $data = $this->product_relate_common_id($pid);
        $products_related_id = $data['products_related_id'];

        //语种条件
        if( in_array($_SESSION['languages_id'],array(1,9))){
            $where .= ' and languages_id in (1,9) ';
        }else{
            if ($_SESSION['languages_id'] == 8) {
                $where .= ' and languages_id in ('.$_SESSION['languages_id'].') ';
            } else {
                $where .= ' and languages_id in (1,9,'.$_SESSION['languages_id'].') ';
            }

        }
        $reviews = $db->Execute("select sum(reviews_rating)as total,count(reviews_id)as count from reviews 
        where status = 1 AND check_status=1 AND  products_id in (" . implode(',', $products_related_id) . ") " .$where);

        //var_dump($reviews);die;
        $this->review_total_score = $reviews->fields['total'];
        $this->review_total_count = $reviews->fields['count'];
        if ($this->review_total_count == 0) {
            $this->review_total_rating = 0;
        } else {
            $this->review_total_rating = number_format($this->review_total_score/$this->review_total_count, 1);
        }

        return $products_related_id; //关联产品
    }

    /*
     * 获取星级展示
     * fairy 2019.3.23 add
     */
    function get_review_rating_html($reviews_score, $reviews_width, $reviews_sums, $classname = '', $products_id='', $reviews_count='',$is_mobile = false)
    {
        $html = '';
        $title = '';
        if(!empty($products_id)){
            $html .='<a href="'.reset_url('products/'.(int)$products_id.'.html#all_reviews').'" target="_blank">';
            if(in_array($_SESSION['languages_code'],array('ru','jp'))){
                $title = 'title="' . FS_REVIEWS_STARS_TITLE . $reviews_score . '"';
            }else{
                $title = 'title="' . $reviews_score . ' '.FS_REVIEWS_STARS_TITLE . '"';
            }
        }
        if ($is_mobile){
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
        if(!empty($reviews_count)){
            $html .='<span class="new_proList_ListBtxt">'.$reviews_count.'</span>';
        }
        if(!empty($products_id)){
            $html .= '</a>';
        }
        return $html;
    }

    /*
     * 获取产品列表的产品的评论展示
     * @para int $products_id: 产品id
     * @para bool $products_id: pc与m端区分
     * fairy 2019.3.23 add
     */
    public function get_product_review_rating_show($products_id,$is_mobile = false)
    {
        $this->get_review_total_info($products_id);
        $products_list_info = '';
        if ($this->review_total_count) {
            $reviews_nums = substr($this->review_total_rating, -1);
            $reviews_sums = substr($this->review_total_rating, 0, 1);
            if ($reviews_nums == 0) {
                $reviews_width = 100;
            } else {
                $reviews_width = $reviews_nums * 10;
            }
            if($is_mobile){
                $products_list_info .= $this->get_review_rating_html($this->review_total_rating, $reviews_width, $reviews_sums, 'new-fsproStars-13', $products_id, $this->review_total_count,$is_mobile);
            }else{
                $products_list_info .= $this->get_review_rating_html($this->review_total_rating, $reviews_width, $reviews_sums, 'change_head_proStar', $products_id, $this->review_total_count);
            }

        } else { //没有评论的情况
            if(in_array($_SESSION['languages_code'],array('ru','jp'))){
                $title = 'title="' . FS_REVIEWS_STARS_TITLE . '0.0"';
            }else{
                $title = 'title="0.0 '.FS_REVIEWS_STARS_TITLE . '"';
            }
            if($is_mobile){
                $products_list_info .= '<a href="'.reset_url('products/'.(int)$products_id.'.html#all_reviews').'"><div class="new-fsproStars-box new-fsproStars-13 after" '.$title.'>';
                for ($i = 0; $i < 5; $i++) {
                    $products_list_info .= '<div class="new-fsproStars-main">
                            <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>
                            <div class="iconfont icon new-fsproStars-icon" style="width: 0%">&#xf132;</div>
                            </div>';
                }
            }else{
                $products_list_info .= '<a href="'.reset_url('products/'.(int)$products_id.'.html#all_reviews').'"><div class="pro_star change_head_proStar" '.$title.'>';
                for ($i = 0; $i < 5; $i++) {
                    $products_list_info .= '<div class="pro_star_gray"><div class="pro_star_black"></div></div>';
                }
            }
            $products_list_info .= '</div><span class="new_proList_ListBtxt">0</span></a>';
        }
        $this->products_list_info = $products_list_info;
    }






    /**
     * get the all reviews score   by frankie
     * 2019-7-24 potato 产品详情页有重复查询，添加第二个参数避免重复查询
     */
    function get_reviews_score($pid, $relate_prdudcts=[])
    {
        global $db;
//        2019-7-24 potato 产品详情页已查询过，直接调用即可
        $result = get_redis_key_value($_SESSION['languages_code'] . "_reviews_rating_" . $pid, $_SESSION['languages_code'] . "_reviews_rating_" . $pid);
        if($result){
            return $result;
        }else{
            if (!empty($relate_prdudcts)) {
                $products_related_id = $relate_prdudcts['products_related_id'];
            }else {
                $data = $this->product_relate_common_id($pid);
                $products_related_id = $data['products_related_id'];
            }

            $where = $this->set_languages_where($products_related_id);
            $reviews = $db->Execute("select sum(reviews_rating)as total from reviews where check_status=1 AND products_id in (" . implode(',', $products_related_id) . ") " . $where);
            $rating_total = $reviews->fields['total'];
            $count = $db->Execute("select count(reviews_id)as count from reviews where check_status=1 AND products_id in (" . implode(',', $products_related_id) . ") " . $where);
            $rating_count = $count->fields['count'];
            if ($rating_count == 0) {
                $rating = 0;
            } else {
                $rating = $rating_total / $rating_count;
                $rating = number_format($rating, 1);
            }
            set_redis_key_value($_SESSION['languages_code'] . "_reviews_rating_" . $pid, $rating, 7 * 24 * 3600, $_SESSION['languages_code'] . "_reviews_rating_" . $pid);
        }
        return $rating;
    }

    function fs_get_product_reviews_score($pid)
    {
        global $db;
        $reviews = $db->Execute("select sum(reviews_rating)as total from reviews where check_status=1 AND  products_id =" . $pid);
        $rating_total = $reviews->fields['total'];
        $count = $db->Execute("select count(reviews_id)as count from reviews where check_status=1 AND  products_id =" . $pid);
        $rating_count = $count->fields['count'];
        if ($rating_count == 0) {
            $rating = 0;
        } else {
            $rating = $rating_total / $rating_count;
            $rating = number_format($rating, 1);
        }

        return $rating;
    }

    function get_nums_reviews($pid, $res)
    {
        global $db;
        $data = $this->product_relate_common_id($pid);
        $products_related_id = $data['products_related_id'];

        $where = $this->set_languages_where($products_related_id, 'r');
        $reviews_sql = "select count(reviews_id)as count from reviews as r where r.check_status=1 and r.status = 1 " . $where . " AND r.products_id in(" . implode(',', $products_related_id) . ") " . $res;
        $reviews = $db->Execute($reviews_sql);
        //var_dump($reviews_sql);die;
        $nums = $reviews->fields['count'];
        return $nums;
    }

    function get_page_reviews_of_product_count($products_id, $page, $res)
    {
        global $db;
        $reviews = array();
        $data = $this->product_relate_common_id($products_id);
        $products_related_id = $data['products_related_id'];

        $Rpage = $page ? $page : 1;
        $start = ($Rpage - 1) * 10;
        $reviews_sql = "select reviews_id from  " . TABLE_REVIEWS . " 
			WHERE status = 1  AND check_status=1 
			AND products_id in(" . implode(',', $products_related_id) . ")   
			AND languages_id=" . (int)$_SESSION['languages_id'] . "
			" . $res . "
			ORDER BY date_added desc, is_featured desc limit $start,10";
        $reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$products_id, 'integer');
        $get_reviews = $db->Execute($reviews_sql);
        return $get_reviews->RecordCount();
    }


    function get_page_reviews_of_product_interval($products_id, $page, $res)
    {
        global $db;
        $reviews = array();
        $data = $this->product_relate_common_id($products_id);
        $products_related_id = $data['products_related_id'];

        $Rpage = $page ? $page : 1;
        $start = ($Rpage - 1) * 10;
        $reviews_sql = "select reviews_id,products_id,reviews_rating,is_featured,date_added,customers_id,v_customers_id,customers_name,cus_contury from  " . TABLE_REVIEWS . " 
			WHERE status = 1 AND check_status=1 
			AND  products_id in(" . implode(',', $products_related_id) . ") 
			AND languages_id=" . (int)$_SESSION['languages_id'] . "
			" . $res . "
			ORDER BY date_added desc, is_featured desc limit $start,10";

        $reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$products_id, 'integer');
        $get_reviews = $db->Execute($reviews_sql);

        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {

                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'contry' => $get_reviews->fields['cus_contury'],
                    'customersid' => $get_reviews->fields['customers_id'],
                    'vcustomersid' => $get_reviews->fields['v_customers_id'],
                    'content' => fs_get_data_from_db_fields('reviews_text', TABLE_REVIEWS_DESCRIPTION, 'reviews_id=' . $get_reviews->fields['reviews_id'] . ' and languages_id=' . (int)$_SESSION['languages_id'], ' limit 1'),
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'comments' => '',   //产品页无用
                    'reviews_headline' => fs_get_data_from_db_fields('reviews_headline', TABLE_REVIEWS_DESCRIPTION, 'reviews_id=' . $get_reviews->fields['reviews_id'] . ' and languages_id=' . (int)$_SESSION['languages_id'], ' limit 1')
                );
                $get_reviews->MoveNext();
            }
        }

        return $reviews;
    }

    function get_reviews_products_related_count($pid)
    {
        global $db;
        $data = $this->product_relate_common_id($pid);
        $products_related_id = $data['products_related_id'];

        $reviews_sql = "select count(reviews_id) as total from reviews where languages_id=" . $_SESSION['languages_id'] . " and  products_id in(" . implode(',', $products_related_id) . ") ";
        $rev_rst = $db->getAll($reviews_sql);
        return $rev_rst[0]['total'];
    }





    function get_page_reviews_of_product($products_id, $page, $res, $pageSize = 10, $relate_prdudcts=[])
    {
        global $db;
        $reviews = array();
        if (!empty($relate_prdudcts)) {
            $products_related_id = $relate_prdudcts['products_related_id'];
        }else {
            $data = $this->product_relate_common_id($products_id);
            $products_related_id = $data['products_related_id'];
        }

        $Rpage = $page ? $page : 1;
        //第一页显示3条
        //$start = $page==2?($page*3):($Rpage-1)*10+3;
        $limit = '';
        if($pageSize == 10){
            $start = ($Rpage - 1) * 10;
            $end = 10;
            $limit = " limit " . $start . ", " . $end;
        }
        $where = $this->set_languages_where($products_related_id, 'rd');
        $reviews_sql = "
            select r.reviews_id, r.top, r.products_id, r.reviews_rating, r.is_featured, r.date_added, 
            r.customers_id, r.v_customers_id, r.customers_name as r_customers_name, 
            r.cus_contury, r.anonymity, r.customers_name, 
            rd.reviews_text, rd.reviews_headline, 
			c.customers_firstname, c.customers_lastname, c.customer_country_id, c.customer_photo, 
			rvc.customers_name as v_customers_name, rvc.portrait, rvc.cus_contury as v_cus_contury, rvc.is_buy 
			from  " . TABLE_REVIEWS . " AS r  
			left join " . TABLE_REVIEWS_DESCRIPTION . " as rd on(r.reviews_id=rd.reviews_id) 
			left join " . TABLE_CUSTOMERS . " as c on(r.customers_id=c.customers_id) 
			left join reviews_virtual_customer as rvc on(r.v_customers_id=rvc.id) 
			WHERE r.status = 1 AND r.check_status=1 AND r. products_id in(" . implode(',', $products_related_id) . ")
			" . $where . " " . $res . " 
			ORDER BY r.rev_top desc, r.top desc, r.date_added desc " . $limit;
//		dd($reviews_sql);
        $result = get_redis_key_value($reviews_sql, $_SESSION['languages_code'] . '_reviews_' . $products_id);
        if ($result) {
            return $result;
        } else {
            $get_reviews = $db->Execute($reviews_sql);
            if ($get_reviews->RecordCount()) {
                while (!$get_reviews->EOF) {
                    $temp_reviews_time = in_array($_SESSION['languages_code'], array('au', 'uk', 'dn')) ? date('d/m/Y', strtotime($get_reviews->fields['date_added'])) : date('m/d/Y', strtotime($get_reviews->fields['date_added']));
                    if ($_SESSION['languages_code'] == 'de') {
                        $temp_reviews_time = date('d.m.Y', strtotime($get_reviews->fields['date_added']));
                    }
                    if(strpos($get_reviews->fields['reviews_text'],'\n')){
                        $str = str_replace(['\r\n','\n'],'<br>',$get_reviews->fields['reviews_text']);
                    }else{
                        $str = json_decode(str_replace(['\r\n','\n'],'<br>',json_encode($get_reviews->fields['reviews_text'])));
                    }
                    $str = content_preg_mtp($str);
                    $reviews[] = array(
                        'rid' => $get_reviews->fields['reviews_id'],
                        'products_id' => $get_reviews->fields['products_id'],
                        'name' => $get_reviews->fields['r_customers_name'],
                        'contry' => $get_reviews->fields['cus_contury'],
                        'customersid' => $get_reviews->fields['customers_id'],
                        'vcustomersid' => $get_reviews->fields['v_customers_id'],
                        'content' => $str,
                        'time' => $temp_reviews_time,
                        'rating' => $get_reviews->fields['reviews_rating'],
                        'is_featured' => $get_reviews->fields['is_featured'],
                        'comments' => '',   //产品页无用
                        'reviews_headline' => $get_reviews->fields['reviews_headline'],
                        'anonymity' => $get_reviews->fields['anonymity'],
                        'r_customers_name' => $get_reviews->fields['customers_name'], //别名
                        'customers_firstname' => $get_reviews->fields['customers_firstname'],
                        'customers_lastname' => $get_reviews->fields['customers_lastname'],
                        'customer_country_id' => $get_reviews->fields['customer_country_id'],
                        'customer_photo' => $get_reviews->fields['customer_photo'],
                        'v_customers_name' => $get_reviews->fields['v_customers_name'],
                        'v_portrait' => $get_reviews->fields['portrait'],
                        'v_cus_contury'  => $get_reviews->fields['v_cus_contury'],
                        'v_is_buy' => $get_reviews->fields['is_buy'],
                    );
                    $get_reviews->MoveNext();
                }
                set_redis_key_value($reviews_sql, $reviews, 7 * 24 * 3600, $_SESSION['languages_code'] . '_reviews_' . $products_id);
                return $reviews;
            }
        }
    }

    //APP端获取优选评论 dori 2020.7.23
    function getMostHelpData($products_id,$res,$relate_prdudcts=[])
    {
        global $db;
        $reviews = array();
        $mostHelpData = array();
        if (!empty($relate_prdudcts)) {
            $products_related_id = $relate_prdudcts['products_related_id'];
        } else {
            $data = $this->product_relate_common_id($products_id);
            $products_related_id = $data['products_related_id'];
        }
        $where = $this->set_languages_where($products_related_id, 'rd');
        $reviews_sql = "
            select r.reviews_id, r.top,r.rev_top, r.products_id, r.reviews_rating, r.is_featured, r.date_added, 
            r.customers_id, r.v_customers_id, r.customers_name as r_customers_name, 
            r.cus_contury, r.anonymity, r.customers_name, 
            rd.reviews_text, rd.reviews_headline, 
			c.customers_firstname, c.customers_lastname, c.customer_country_id, c.customer_photo, 
			rvc.customers_name as v_customers_name, rvc.portrait, rvc.cus_contury as v_cus_contury, rvc.is_buy,ron.r_like 
			from  " . TABLE_REVIEWS . " AS r  
			left join " . TABLE_REVIEWS_DESCRIPTION . " as rd on(r.reviews_id=rd.reviews_id) 
			left join " . TABLE_CUSTOMERS . " as c on(r.customers_id=c.customers_id) 
			left join reviews_virtual_customer as rvc on(r.v_customers_id=rvc.id) 
			left join reviews_like_or_not as ron on(r.reviews_id=ron.reviews_id) 
			WHERE r.status = 1 AND r.check_status=1 AND r. products_id in(" . implode(',', $products_related_id) . ")
			" . $where . " " . $res . " 
			ORDER BY r.rev_top desc, r.top desc, r.date_added desc ";
//		dd($reviews_sql);
        $result = get_redis_key_value($reviews_sql, $_SESSION['languages_code'] . '_mostHelpData_' . $products_id);
        if ($result) {
            return $result;
        } else {
            $get_reviews = $db->Execute($reviews_sql);
            if ($get_reviews->RecordCount()) {
                while (!$get_reviews->EOF) {
                    $temp_reviews_time = in_array($_SESSION['languages_code'], array('au', 'uk', 'dn')) ? date('d/m/Y', strtotime($get_reviews->fields['date_added'])) : date('m/d/Y', strtotime($get_reviews->fields['date_added']));
                    if ($_SESSION['languages_code'] == 'de') {
                        $temp_reviews_time = date('d.m.Y', strtotime($get_reviews->fields['date_added']));
                    }
                    if (strpos($get_reviews->fields['reviews_text'], '\n')) {
                        $str = str_replace(['\r\n', '\n'], '<br>', $get_reviews->fields['reviews_text']);
                    } else {
                        $str = json_decode(str_replace(['\r\n', '\n'], '<br>', json_encode($get_reviews->fields['reviews_text'])));
                    }
                    if (
                        $get_reviews->fields['r_like'] >= 50 && count($mostHelpData) <= 2 &&
                        ($_SESSION['languages_id'] == 1 && $get_reviews->fields['top'] == 1) ||
                        ($_SESSION['languages_id'] != 1 && $get_reviews->fields['rev_top'] == 1)
                    ) {
                        $str = content_preg_mtp($str);
                        $mostHelpData[] =  array(
                            'rid' => $get_reviews->fields['reviews_id'],
                            'products_id' => $get_reviews->fields['products_id'],
                            'name' => $get_reviews->fields['r_customers_name'],
                            'contry' => $get_reviews->fields['cus_contury'],
                            'customersid' => $get_reviews->fields['customers_id'],
                            'vcustomersid' => $get_reviews->fields['v_customers_id'],
                            'content' => $str,
                            'time' => $temp_reviews_time,
                            'rating' => $get_reviews->fields['reviews_rating'],
                            'is_featured' => $get_reviews->fields['is_featured'],
                            'comments' => '',   //产品页无用
                            'reviews_headline' => $get_reviews->fields['reviews_headline'],
                            'anonymity' => $get_reviews->fields['anonymity'],
                            'r_customers_name' => $get_reviews->fields['customers_name'], //别名
                            'customers_firstname' => $get_reviews->fields['customers_firstname'],
                            'customers_lastname' => $get_reviews->fields['customers_lastname'],
                            'customer_country_id' => $get_reviews->fields['customer_country_id'],
                            'customer_photo' => $get_reviews->fields['customer_photo'],
                            'v_customers_name' => $get_reviews->fields['v_customers_name'],
                            'v_portrait' => $get_reviews->fields['portrait'],
                            'v_cus_contury' => $get_reviews->fields['v_cus_contury'],
                            'v_is_buy' => $get_reviews->fields['is_buy'],
                        );
                    }
                    $get_reviews->MoveNext();
                }
                set_redis_key_value($reviews_sql, $mostHelpData, 7 * 24 * 3600, $_SESSION['languages_code'] . '_mostHelpData_' . $products_id);
                return $mostHelpData;
            }
        }
    }


    function get_sum_reviews($products_id, $res, $relate_prdudcts=[]){
        $result = get_redis_key_value($_SESSION['languages_code'].'_reviews_total_'.$res.$products_id,$_SESSION['languages_code'].'_reviews_total_'.$res.$products_id);
        if($result){
            return $result;
        }else{
            global $db;
            if (!empty($relate_prdudcts)) {
                $products_related_id = $relate_prdudcts['products_related_id'];
            }else {
                $data = $this->product_relate_common_id($products_id);
                $products_related_id = $data['products_related_id'];
            }
            $where = $this->set_languages_where($products_related_id, '');
            $sql = "SELECT count(reviews_id) as total FROM reviews
                WHERE status = 1 AND check_status=1 AND products_id in(" . implode(',', $products_related_id) . ")" . $where . $res;
            $reviews = $db->getAll($sql);
            $totalReview = $reviews[0]['total'];
            set_redis_key_value($_SESSION['languages_code'].'_reviews_total_'.$res.$products_id, $totalReview, 7 * 24 * 3600, $_SESSION['languages_code'].'_reviews_total_'.$res.$products_id);
            return $totalReview;
        }


    }

    /**
     *
     * Enter description here ...
     * @param $products_id
     */
    function get_all_reviews_of_product_products_info($products_id)
    {
        global $db;
        $reviews = array();
        $data = $this->product_relate_common_id($products_id);
        $products_related_id = $data['products_related_id'];
        $reviews_sql = "select r.reviews_id,r.products_id,reviews_rating, is_featured, reviews_text,date_added,last_modified,customers_name,
			rd.reviews_headline from " . TABLE_REVIEWS_DESCRIPTION . " AS rd LEFT JOIN " . TABLE_REVIEWS .
            " AS r ON(rd.reviews_id = r.reviews_id) WHERE rd.languages_id = " . (int)$_SESSION['languages_id'] . " 
			AND r. products_id in(" . implode(',', $products_related_id) . ")  AND r.status = 1 AND r.check_status=1 
			ORDER BY r.date_added desc, is_featured desc limit 8";

        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'customersid' => $get_reviews->fields['customers_id'],
                    'content' => $get_reviews->fields['reviews_text'],
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'comments' => $this->get_comments_of_review($get_reviews->fields['reviews_id'], $products_id),
                    'reviews_headline' => $get_reviews->fields['reviews_headline']
                );
                $get_reviews->MoveNext();

            }
        }
        return $reviews;

    }


    function get_all_reviews_of_product($products_id)
    {
        global $db;
        $reviews = array();
        $reviews_sql = "select r.reviews_id,r.products_id,reviews_rating, is_featured, reviews_text,date_added,last_modified,customers_name,rd.reviews_headline from " . TABLE_REVIEWS_DESCRIPTION . " AS rd LEFT JOIN " . TABLE_REVIEWS .
            " AS r ON(rd.reviews_id = r.reviews_id) LEFT JOIN " . TABLE_PRODUCTS . " AS p  ON(r.products_id = p.products_id) 
			WHERE rd.languages_id = " . (int)$_SESSION['languages_id'] . " 
			AND p.products_id = :products_id 
		    
			AND r.status = 1 AND r.check_status=1 
			ORDER BY r.date_added desc, is_featured desc";

        $reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$products_id, 'integer');
        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'customersid' => $get_reviews->fields['customers_id'],
                    'content' => $get_reviews->fields['reviews_text'],
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'comments' => $this->get_comments_of_review($get_reviews->fields['reviews_id'], $products_id),
                    'reviews_headline' => $get_reviews->fields['reviews_headline']
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }

    /**
     * @todo get customer's all reviews
     */
    function get_all_reviews_of_current_customer()
    {
        global $db;
        $reviews = array();
        $reviews_sql = "select r.reviews_id,r.products_id,reviews_rating, is_featured, reviews_text,date_added,p.products_image,customers_name from " . TABLE_REVIEWS . " AS r LEFT JOIN " . TABLE_PRODUCTS . " AS p  ON(r.products_id = p.products_id) 
			WHERE r.languages_id = " . (int)$_SESSION['languages_id'] . " 
			AND r.status = 1 
			AND r.customers_id = :customers_id 
			
			ORDER BY r.reviews_id desc";

        $reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$products_id, 'integer');
        $reviews_sql = $db->bindVars($reviews_sql, ':customers_id', (int)$_SESSION['customer_id'], 'integer');
        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'products_name' => $get_reviews->fields['products_name'],
                    'products_image' => $get_reviews->fields['products_image'],
                    'content' => $get_reviews->fields['reviews_text'],
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'comments' => $this->get_comments_of_review($get_reviews->fields['reviews_id'], $get_reviews->fields['products_id']),
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }

    // LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd on(p.products_id=pd.products_id)

    function get_all_reviews_of_order($customers_id)
    {
        global $db;
        $reviews_order = array();
        $reviews_sql = "select r.reviews_id,reviews_rating, is_featured, reviews_text,last_modified,customers_name,customers_id,p.products_id,p.products_image,pd.products_name from " . TABLE_REVIEWS_DESCRIPTION . " AS rd LEFT JOIN " . TABLE_REVIEWS .
            " AS r ON(rd.reviews_id = r.reviews_id) LEFT JOIN " . TABLE_PRODUCTS . " AS p  ON(r.products_id = p.products_id)  LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd on(p.products_id=pd.products_id)
			WHERE rd.languages_id = " . (int)$_SESSION['languages_id'] . "
			AND customers_id = :customers_id
	       
			AND r.status = 1
			ORDER BY is_featured desc,last_modified desc";

        $reviews_sql = $db->bindVars($reviews_sql, ':customers_id', /*(int)$customers_id*/
            (int)$_SESSION['customer_id'], 'integer');

        //exit ($reviews_sql);
        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews_order[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'customersid' => $get_reviews->fields['customers_id'],
                    'content' => $get_reviews->fields['reviews_text'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'products_name' => $get_reviews->fields['products_name'],
                    'products_image' => $get_reviews->fields['products_image'],
                    'time' => date('F j,Y', strtotime($get_reviews->fields['last_modified'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'comments' => $this->get_comments_of_review($get_reviews->fields['reviews_id'], $customers_id),
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews_order;
    }


    function get_all_reviews_of_rating($products_id)
    {
        global $db;
        $ratings = array();

        $rating_total_sql = "select sum(reviews_rating) as total from " . TABLE_REVIEWS . " 
		    WHERE languages_id = " . (int)$_SESSION['languages_id'] . "
			AND status = 1 AND check_status=1 AND products_id=" . $products_id;
        $ratings_total = $db->Execute($rating_total_sql)->fields['total'];

        $ratings_sql = "select count(reviews_id) as total from " . TABLE_REVIEWS . " 
            WHERE languages_id = " . (int)$_SESSION['languages_id'] . "
			AND status = 1 AND products_id=" . $products_id;

        $total = $db->Execute($ratings_sql)->fields['total'];

        if ($total) {
            $ratings['average'] = round($ratings_total / $total, 0);
        } else {
            $ratings['average'] = 5;
        }
        return $ratings;
    }

    /**
     *
     * @param int $reviews_id
     *
     * @return customers comments of review
     */
    function get_all_reviews_of_reply($reviews_id)
    {
        global $db;
        $reviews_reply = array();
        $reviews_reply_sql = "select r.comments_id,r.date_added from " . TABLE_REVIEWS_COMMENTS .
            " AS r  WHERE  r.reviews_id= :reviews_id
				AND r.status =1
				and r.rpid=0
			ORDER BY r.is_fiberstore desc,r.date_added desc ";

        $reviews_reply_sql = $db->bindVars($reviews_reply_sql, ':reviews_id', (int)$reviews_id, 'integer');
        $get_reviews = $db->Execute($reviews_reply_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                // 2019-7-25 potato 原来下面的是执行了多条fs_get_data_from_db_fields
                $data = fs_get_data_from_db_fields_array(['customers_id', 'customers_name', 'comments_content'], TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'] . ' and language_id=' . (int)$_SESSION['languages_id']);

                $reviews[] = array(
                    'id' => $get_reviews->fields['comments_id'],
                    'cid' => $data[0][0],
                    //'content'=>
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'name' => $data[0][1],
                    'comments' => $data[0][2],
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }

    /*获取comments分页数据
     *
     */
    function get_page_reviews_of_reply($reviews_id, $page)
    {
        global $db;
        $reviews_reply = array();
        $Rpage = $page ? $page : 1;
        $start = ($Rpage - 1) * 10;

        $reviews_reply_sql = "select r.comments_id,r.date_added from " . TABLE_REVIEWS_COMMENTS .
            " AS r WHERE  r.reviews_id= :reviews_id
				AND r.status =1
				and r.rpid=0
			ORDER BY r.is_fiberstore desc,r.date_added desc limit $start,10";

        $reviews_reply_sql = $db->bindVars($reviews_reply_sql, ':reviews_id', (int)$reviews_id, 'integer');
        $get_reviews = $db->Execute($reviews_reply_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'id' => $get_reviews->fields['comments_id'],
                    'cid' => fs_get_data_from_db_fields('customers_id', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'] . ' and language_id=' . (int)$_SESSION['languages_id'], ' limit 1'),
                    //'content'=>
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'name' => fs_get_data_from_db_fields('customers_name', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'] . ' and language_id=' . (int)$_SESSION['languages_id'], ' limit 1'),
                    'comments' => fs_get_data_from_db_fields('comments_content', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'] . ' and language_id=' . (int)$_SESSION['languages_id'], ' limit 1'),
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }


    /**
     *
     * @param int $reviews_id
     *
     * @return fs.com comments of review
     */
    function get_fs_reviews_of_reply($reviews_id, $rpid)
    {
        global $db;
        $reviews_reply = array();
        $reviews_reply_sql = "select r.comments_id,r.date_added from " . TABLE_REVIEWS_COMMENTS .
            " AS r  WHERE   r.reviews_id= :reviews_id
				AND r.status =1
				and r.is_fiberstore=1
				and rpid= :rpid
			ORDER BY r.date_added desc";

        $reviews_reply_sql = $db->bindVars($reviews_reply_sql, ':reviews_id', (int)$reviews_id, 'integer');
        $reviews_reply_sql = $db->bindVars($reviews_reply_sql, ':rpid', (int)$rpid, 'integer');
        $get_reviews = $db->Execute($reviews_reply_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'id' => $get_reviews->fields['comments_id'],
                    'cid' => fs_get_data_from_db_fields('customers_id', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'], ' limit 1'),
                    //'content'=>
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'name' => fs_get_data_from_db_fields('customers_name', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'], ' limit 1'),
                    'comments' => fs_get_data_from_db_fields('comments_content', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_reviews->fields['comments_id'], ' limit 1'),
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }


    /**
     *
     * @param int $rid
     * @param int $products_id
     * @return comments of review
     */
    function get_comments_of_review($rid, $products_id)
    {
        global $db;
        $comments = array();
        $comments_sql = "select r.comments_id,r.last_modified from " . TABLE_REVIEWS_COMMENTS .
            " AS r left join " . TABLE_REVIEWS_COMMENTS_DESCRIPTION . " as rd using(comments_id)  WHERE  r.reviews_id = :rid
		   	AND r.products_id = :products_id
		    AND r.status =1 
			ORDER BY r.is_fiberstore desc,r.date_added desc
			";

        $comments_sql = $db->bindVars($comments_sql, ':rid', (int)$rid, 'integer');
        $comments_sql = $db->bindVars($comments_sql, ':products_id', (int)$products_id, 'integer');
        $get_comments = $db->Execute($comments_sql);
        if ($get_comments->RecordCount()) {
            while (!$get_comments->EOF) {
                $data = fs_get_data_from_db_fields_array(['customers_id', 'customers_name', 'comments_content'], TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_comments->fields['comments_id'], '');
                $comments[] = array(
                    'cid' => $get_comments->fields['comments_id'],
//                    'cus_id' => fs_get_data_from_db_fields('customers_id', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_comments->fields['comments_id'], ' limit 1'),
//                    'name' => fs_get_data_from_db_fields('customers_name', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_comments->fields['comments_id'], ' limit 1'),
//                    'content' => fs_get_data_from_db_fields('comments_content', TABLE_REVIEWS_COMMENTS_DESCRIPTION, 'comments_id=' . $get_comments->fields['comments_id'], ' limit 1'),
                    'cus_id' => $data[0][0],
                    'name' => $data[0][1],
                    'content' => $data[0][2],
                    'time' => date('F j,Y', strtotime($get_comments->fields['last_modified'])),
                );
                $get_comments->MoveNext();
            }

        }
        return $comments;
    }

    //得到一条官方评论
    function get_fs_one_comment_review($rid)
    {//$_SESSION['languages_id']
        global $db;
        $comment = array();
        $codestr = '1,9';
        if(!in_array($_SESSION['languages_id'],array(1,9))){
            $codestr .= ','.$_SESSION['languages_id'];
        }

        $comment_sql = "select rc.comments_id,rcd.customers_name,rcd.customers_id,rcd.comments_content,rc.last_modified from " . TABLE_REVIEWS_COMMENTS . " AS rc left join " . TABLE_REVIEWS_COMMENTS_DESCRIPTION . " AS rcd using(comments_id) 
	                    WHERE rc.reviews_id=" . $rid . " AND rcd.customers_name='FS.COM' AND rc.status=1 AND rcd.language_id in ( " .$codestr. " )order by
	                     rc.is_fiberstore desc,rc.date_added desc limit 1";
        $get_comment = $db->Execute($comment_sql);
        if ($get_comment->RecordCount()) {
            while (!$get_comment->EOF) {
                $comment = array(
                    'cid' => $get_comment->fields['comments_id'],
                    'time' => date('F j,Y', strtotime($get_comment->fields['last_modified'])),
                    'content' => $get_comment->fields['comments_content'],
                    'name' => $get_comment->fields['customers_name'],
                    'cus_id' => $get_comment->fields['customers_id']
                );
                $get_comment->MoveNext();
            }
        }
        return $comment;
    }


    /*  get rand reviews level for product     */
    //rand display level begin 90 to 100     it's unstable ,every product maybe change on refresh  ,so,i use the second method

    function get_rand_reviews_level_of_product($pid)
    {
        global $db, $review_count;
        //$review_arr=array("90","91","92","93","94","95","96","97","98","99","100");
        $review_arr = array("90" => "90%", "91" => "91%", "92" => "92%", "93" => "93%", "94" => "94%", "95" => "95%", "96" => "96%", "97" => "97%", "98" => "98%", "99" => "99%", "100" => "100%");
        $rand_keys = array_rand($review_arr, 1);

        $review_sql = "select reviews_id as rid from " . TABLE_REVIEWS . "  where products_id = '" . $pid . "'  ";
        $is_have_review = $db->Execute($review_sql);
        if ($is_have_review->fields['rid']) {
            $review_count = $rand_keys;
        } else {
            $review_count = 100;
        }
        return $review_count;
    }

//	 new count  method of reviews level .  count reviews num for product,vaerage - total(reviews)  == final level
    function get_reviews_star_level_of_review_num($products_id, $related_products=[])
    {
        $result = get_redis_key_value($_SESSION['languages_code'] . '_reviews_star_count_' . $products_id, $_SESSION['languages_code'] . '_reviews_count_' . $products_id);
        //var_dump($result);
        if ($result) {
            return $result;
        } else {
            global $db;
            $stars_level = array();
            if (!empty($related_products)) {
                $products_related_id = $related_products['products_related_id'];
            }else {
                $data = $this->product_relate_common_id($products_id);
                $products_related_id = $data['products_related_id'];
            }

            $where = $this->set_languages_where($products_related_id);
            $stars_level_sql = "select count(reviews_id) as total from reviews where products_id in(" . implode(',', $products_related_id) . ")  and status=1 and check_status=1 " . $where;
            $total = $db->Execute($stars_level_sql)->fields['total'];
            if ($total) {
                foreach (array(1, 2, 3, 4, 5) as $num) {
                    $stars_sql = "select count(reviews_id) as total from reviews where   products_id in(" . implode(',', $products_related_id) . ") " . $where . " and status=1 and check_status=1 and reviews_rating=" . $num;
                    $get_star_level = $db->Execute($stars_sql);
                    if ($num == 5) {
                        $stars_level['level' . $num] = 100 - $stars_level['level1'] - $stars_level['level2'] - $stars_level['level3'] - $stars_level['level4'];
                    } else {
                        $stars_level['level' . $num] = round(($get_star_level->fields['total'] / $total) * 100, 0);
                    }
                    $stars_level['show' . $num] = $get_star_level->fields['total'];
                }
            }
            $stars_level_sqls = "select reviews_id from reviews where  products_id in(" . implode(',', $products_related_id) . ")  and status=1 and check_status=1 and reviews_rating > 2 and languages_id=" . $_SESSION['languages_id'];
            $best_reviews_total = $db->Execute($stars_level_sqls)->fields['total'];
            if ($total && $best_reviews_total) {
                $stars_level['average'] = number_format((int)($best_reviews_total / $total) * 100, 0) - (int)$total;
                if ($stars_level['average'] < 92) {
                    $stars_level['average'] = 92;
                }
            } else {
                $stars_level['average'] = 100;
            }
            set_redis_key_value($_SESSION['languages_code'] . '_reviews_star_count_' . $products_id, $stars_level, 7 * 24 * 3600, $_SESSION['languages_code'] . '_reviews_count_' . $products_id);
            return $stars_level;
        }
    }

    /** eof rand review **/
    /**
     *
     * @param int $products_id
     * @return array of stars rating info
     * array(leve1 => xx,level2=>bbb,leve ..., average=>xx)
     */
    function get_reviews_star_level($products_id)
    {
        global $db;
        $stars_level = array();
        //update from melo .2012-11-01
        foreach (array(1, 2, 3, 4, 5) as $num) {
            $stars_sql = "select count(reviews_id) as total from " . TABLE_REVIEWS . " 
			            WHERE languages_id = " . (int)$_SESSION['languages_id'] . " 
						AND products_id=" . $products_id . " 
						AND status = 1 AND check_status=1 and languages_id=" . $_SESSION['languages_id'] . " 
						and reviews_rating = $num
						";
            $get_star_level = $db->Execute($stars_sql);
            $stars_level['level' . $num] = $get_star_level->fields['total'];
        }

        //total reviews people
        $stars_level_sql = "select count(reviews_id) as total from " . TABLE_REVIEWS . " 
		    WHERE languages_id = " . (int)$_SESSION['languages_id'] . "
			AND products_id=" . $products_id . " 
			AND status = 1 AND check_status=1 
			";
        $total = $db->Execute($stars_level_sql)->fields['total'];
        //get 3,4,5 rating 's people
        $stars_level_sqls = "select count(reviews_id) as total from " . TABLE_REVIEWS . " 
		    WHERE languages_id = " . (int)$_SESSION['languages_id'] . "
			AND products_id=" . $products_id . " 
			AND status = 1 AND check_status=1 
			AND reviews_rating > 2
			";
        $best_reviews_total = $db->Execute($stars_level_sqls)->fields['total'];

        if ($total && $best_reviews_total) {
            $stars_level['average'] = number_format((float)($best_reviews_total / $total) * 100, 0);
        } else {
            $stars_level['average'] = 100;
        }
        return $stars_level;
    }

    //统计评论点赞
    function get_review_is_like_count($rID)
    {
        global $db;
        $reviews_count = array();
        $fs_query = "select r_like, r_bad from reviews_like_or_not where reviews_id = " . (int)$rID;
        $result = $db->Execute($fs_query);
        if ($result->RecordCount()) {
            $reviews_count = array(
                'r_like' => $result->fields['r_like'],
                'r_bad' => $result->fields['r_bad'],

            );
        }
        return $reviews_count;
    }

    //统计评论讨论点赞
    function get_comments_is_like_count($cID)
    {
        global $db;
        $comments_count = array();
        $fs_query = "select r_like, r_bad from reviews_comments_like_or_not where comments_id = " . (int)$cID;
        $result = $db->Execute($fs_query);
        if ($result->RecordCount()) {
            $comments_count = array(
                'r_like' => $result->fields['r_like'],
                'r_bad' => $result->fields['r_bad'],

            );
        }
        return $comments_count;
    }

    /*
     * get customers_basket_quantity by customres_basket
     */
    function get_customers_basket_quantity_count($rID)
    {
        global $db;
        $reviews_count = array();
        $fs_query = "select customers_basket_quantity as count from " . TABLE_CUSTOMERS_BASKET . " where products_id = " . (int)$rID;
        //echo $fs_query;
        $result = $db->Execute($fs_query);
        if ($result->RecordCount()) {
            $cart_num = $result->fields['count'];
        }
        return $cart_num;
    }


    function get_all_rating_of_level($products_id)
    {
        global $db;
        $stars_num = array();

        $stars_sql = "select count(r.reviews_id) as total from " . TABLE_REVIEWS . " r
		    LEFT JOIN " . TABLE_PRODUCTS . " AS p  ON(r.products_id = p.products_id)
			WHERE r.languages_id = " . (int)$_SESSION['languages_id'] . "
			AND p.products_id = :products_id
			AND r.status = 1 AND r.check_status=1 
			AND r.reviews_rating = :number
			";
        $stars_sql = $db->bindVars($stars_sql, ':products_id', (int)$products_id, 'integer');


        return $stars_num;
    }

    /**
     * get the customer reviews count   by  frankie
     */
    function get_customers_reviews_count($customers_id)
    {
        global $db;
        $review_count = $db->Execute("select count(reviews_id) as total from " . TABLE_REVIEWS . " where customers_id=" . (int)$_SESSION['customer_id']);
        $customer_reviews_count = $review_count->fields['total'];
        return $customer_reviews_count;
    }

    /**
     * get pege of customers_reviews by frankie
     */
    function get_page_reviews_of_customers($customers_id, $page)
    {
        global $db;
        $reviews = array();
        $Rpage = $page ? $page : 1;
        $start = ($Rpage - 1) * 10;
        $reviews_sql = "select r.reviews_id,r.products_id,reviews_rating, is_featured, 
		reviews_text,date_added,last_modified,customers_name,rd.reviews_headline 
		               from " . TABLE_REVIEWS_DESCRIPTION . " AS rd LEFT JOIN " . TABLE_REVIEWS .
            " AS r ON(rd.reviews_id = r.reviews_id)  
			          WHERE  r.customers_id=" . (int)$_SESSION['customer_id'] . "
			         AND r.status = 1 
			         ORDER BY r.date_added desc, is_featured desc limit $start,10";

        //$reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$products_id, 'integer');

        $get_reviews = $db->Execute($reviews_sql);

        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'customers_id' => $get_reviews->fields['customers_id'],
                    'content' => $get_reviews->fields['reviews_text'],
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'comments' => $this->get_comments_of_review($get_reviews->fields['reviews_id'], $products_id),
                    'reviews_headline' => $get_reviews->fields['reviews_headline']
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }

    function get_reviews_image_of_products($products_id, $res = '')
    {
        global $db;
        //        2019-7-24 potato 产品详情页头部已查询过，直接调用即可
        $data = $this->product_relate_common_id($products_id);
        $products_related_id = $data['products_related_id'];
        $where = $this->set_languages_where($products_related_id, 'r');
        $rst = "select DISTINCT r.reviews_id  from reviews_image left join reviews r using(reviews_id) where r.check_status=1 AND r.products_id in(" . implode(',', $products_related_id) . ")  " . $where . $res;
        $result = get_redis_key_value($rst, $_SESSION['languages_code'] . "_reviews_image_" . $products_id);
        if ($result) {
            return $result;
        } else {
            $reviews_num = $db->Execute($rst);
            if ($reviews_num->RecordCount()) {
                while (!$reviews_num->EOF) {
                    $reviews_id[] = array(
                        'id' => $reviews_num->fields['reviews_id']);
                    $reviews_num->MoveNext();
                }
            }
            set_redis_key_value($rst, $reviews_id, 7 * 24 * 3600, $_SESSION['languages_code'] . '_reviews_image_' . $products_id);
            return $reviews_id;
        }
    }

    function get_products_reviews_count($products_id)
    {
        global $db;
        $review_count = $db->Execute("select count(reviews_id) as total from " . TABLE_REVIEWS . " where check_status=1 and products_id=" . (int)$products_id);
        $products_reviews_count = $review_count->fields['total'];
        return $products_reviews_count;
    }

    function get_reviews_info($reviews_id)
    {
        global $db;
        $reviews = array();
        $reviews_sql = "select r.reviews_id,r.products_id,r.reviews_rating,r.is_featured,r.date_added,r.last_modified,r.customers_name from  " . TABLE_REVIEWS .
            " AS r  WHERE  r.status = 1 
			AND r.reviews_id=:reviews_id
			ORDER BY r.date_added desc, is_featured desc ";

        $reviews_sql = $db->bindVars($reviews_sql, ':reviews_id', (int)$reviews_id, 'integer');
        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'products_id' => $get_reviews->fields['products_id'],
                    'name' => $get_reviews->fields['customers_name'],
                    'content' => fs_get_data_from_db_fields('reviews_text', TABLE_REVIEWS_DESCRIPTION, 'reviews_id=' . $get_reviews->fields['reviews_id'] . ' and languages_id=' . $_SESSION['languages_id'], ' limit 1'),
                    'time' => date('F j,Y', strtotime($get_reviews->fields['date_added'])),
                    'rating' => $get_reviews->fields['reviews_rating'],
                    //  'comment'=>$this->get_comments_of_review($reviews_id,$get_reviews->fields['products_id']),
                    'is_featured' => $get_reviews->fields['is_featured'],
                    'reviews_headline' => fs_get_data_from_db_fields('reviews_headline', TABLE_REVIEWS_DESCRIPTION, 'reviews_id=' . $get_reviews->fields['reviews_id'] . ' and languages_id=' . $_SESSION['languages_id'], ' limit 1')
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }

    /*
    * 获取真实客户评价其他产品数据
    */
    function get_other_products_reviews($cid, $pid)
    {
        global $db;
        $reviews = array();
        $reviews_sql = "select r.reviews_id,r.products_id from reviews r left join products p using(products_id) where p.products_status=1 and  r.customers_id=:customers_id and r.products_id!=:products_id and r.status=1 order by date_added desc";
        $reviews_sql = $db->bindVars($reviews_sql, ':customers_id', (int)$cid, 'integer');
        $reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$pid, 'integer');
        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'pid' => $get_reviews->fields['products_id'],
                    'cid' => $cid
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }

    /*
    * 获取虚拟客户评价其他产品数据
    */
    function get_other_virtual_products_reviews($cid, $pid)
    {
        global $db;
        $reviews = array();
        $reviews_sql = "select r.reviews_id,r.products_id from reviews r left join products p using(products_id) where p.products_status=1 and  v_customers_id=:v_customers_id and products_id!=:products_id and r.status=1 AND r.check_status=1 order by date_added desc";
        $reviews_sql = $db->bindVars($reviews_sql, ':v_customers_id', (int)$cid, 'integer');
        $reviews_sql = $db->bindVars($reviews_sql, ':products_id', (int)$pid, 'integer');
        $get_reviews = $db->Execute($reviews_sql);
        if ($get_reviews->RecordCount()) {
            while (!$get_reviews->EOF) {
                $reviews[] = array(
                    'rid' => $get_reviews->fields['reviews_id'],
                    'pid' => $get_reviews->fields['products_id'],
                    'cid' => $cid
                );
                $get_reviews->MoveNext();
            }
        }
        return $reviews;
    }


    /*
     * 获取产品列表的产品的评论展示
     * @para int $products_id: 产品id
     * @return string $products_list_info: 评论展示的字符串
     */
    public function get_product_list_review_show($products_id)
    {
        $products_list_info = '';
        $products_related_id['products_related_id'] = $this->get_review_total_info($products_id);
        //第一页显示的评论
        $reviews_score = $this->get_reviews_score($products_id,$products_related_id);

        $stars_matcher = array(1 => 'p_star05', 2 => 'p_star04', 3 => 'p_star03', 4 => 'p_star02', 5 => 'p_star01',);
        if ($this->review_total_count) {
            $reviews_nums = substr($reviews_score, -1);
            $reviews_sums = substr($reviews_score, 0, 1);
            if ($reviews_nums == 0) {
                $reviews_width = 100;
            } else {
                $reviews_width = $reviews_nums * 10;
            }
            $products_list_info .= fs_product_reviews_level_show($reviews_score, $reviews_width, $reviews_sums, 'change_head_proStar',$products_id,$this->review_total_count);
        } else {
            if(in_array($_SESSION['languages_code'],array('ru','jp'))){
                $title = 'title="' . FS_REVIEWS_STARS_TITLE . '0.0"';
            }else{
                $title = 'title="0.0 '.FS_REVIEWS_STARS_TITLE . '"';
            }
            $products_list_info .= '<a href="'.reset_url('products/'.(int)$products_id.'.html#all_reviews').'"><div class="pro_star change_head_proStar" '.$title.'>';
            for ($i = 0; $i < 5; $i++) {
                $products_list_info .= '<div class="pro_star_gray"><div class="pro_star_black"></div></div>';
            }
            $products_list_info .= '</div><span class="new_proList_ListBtxt">0</span></a>';
        }

        return $products_list_info;
    }

    /*
     * 获取产品列表的评论数目
     * @para int $products_id: 产品id
     * @return string $products_list_info: 评论展示的字符串
     */
    public function get_product_list_review_count($products_id)
    {
        global $db;
        //该产品的总评论数
        $result = get_redis_key_value($_SESSION['languages_code'] . '_reviews_total_' . $products_id, $_SESSION['languages_code'] . '_reviews_total_' . $products_id);
        if ($result !== false) {
            $reviews_total = $result;
        } else {
            $data = $this->product_relate_common_id($products_id);
            $products_related_id = $data['products_related_id'];

            $where = $this->set_languages_where($products_related_id);
            $stars_sql = "select count(reviews_id) as total from " . TABLE_REVIEWS . " WHERE 
            products_id in(" . implode(',', $products_related_id) . ") " . $where . "  AND status = 1 AND check_status=1";

            $get_star_level = $db->Execute($stars_sql);
            $reviews_total = $get_star_level->fields['total'];
            set_redis_key_value($_SESSION['languages_code'] . '_reviews_total_' . $products_id, $reviews_total, 7 * 24 * 3600, $_SESSION['languages_code'] . '_reviews_total_' . $products_id);
        }
        return $reviews_total;
    }

    public function set_languages_where($products_related_id, $prefix = '')
    {
        global $db;
        if ($_SESSION['languages_id'] != 1) {
            $en_reviews = "select count(reviews_id)as count from reviews where products_id in(" . implode(',', $products_related_id) . ") and status = 1 AND check_status=1 and languages_id=1";
            $en_result = $db->Execute($en_reviews);
            $str = ($_SESSION['languages_id'] == '9') ? '' : ',9';
            if ($en_result->fields['count']) {
                $where = "languages_id in (1," . $_SESSION['languages_id'] . $str . ")";
            } else {
                $where = "languages_id in (" . $_SESSION['languages_id'] . $str . ")";
            }
        } else {
            $where = "languages_id in (1,9)";
        }
        $and = $prefix ? " and " . $prefix . "." : " and ";
        return $and . $where;
    }

    /**
     * @notes : 获取改产品的所有关联产品(这个判断有多个地方在使用，所以摘出来)
     * @author:potato
     * @date  :2019/7/24
     * @param string $products_id
     * @return array
     */
    public function product_relate_common_id($products_id ='')
    {
        $result = get_redis_key_value($_SESSION['languages_code'] . '_reviews_products_related_' . $products_id, $_SESSION['languages_code'] . '_reviews_products_related_' . $products_id);
        if($result){
            return $result;
        }else{
            if (check_product_is_pre_product($products_id)) {
                $is_pre_order = true;
                $products_related_id = array($products_id);
                $related_id = pre_order_product_get_related_product($products_id);
                if ($related_id) {
                    $products_related_id = zen_get_reviews_related($related_id);
                }
            } else {
                $is_pre_order = false;
                $products_related_id = zen_get_reviews_related($products_id);
            }
            $data = [
                'products_related_id' => $products_related_id ? $products_related_id : [],
                'related_id' => $related_id ? $related_id : '',
                'is_pre_order' => $is_pre_order,
            ];
            set_redis_key_value($_SESSION['languages_code'] . '_reviews_products_related_' . $products_id, $data, 7 * 24 * 3600, $_SESSION['languages_code'] . '_reviews_products_related_' . $products_id);
            return $data;
        }
    }
}

