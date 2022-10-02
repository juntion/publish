<?php
require('includes/application_top.php');
if($_GET['request_type']=='setPage') {
    $str = "";
    require DIR_WS_CLASSES . 'fs_reviews.php';
    $fs_reviews = new fs_reviews();

    $reviews = $fs_reviews->get_all_reviews_of_product_products_info($_GET['products_id']);

    $content_of_reviews = sizeof($reviews);

    if ($content_of_reviews) {
        $js_for_replys = '';
        $page_reviews = $fs_reviews->get_page_reviews_of_product_interval($_GET['products_id'], $_GET['page'], '');

        foreach ($page_reviews as $ii => $review) {

            $js_for_replys .= '#num_of_replys_' . $review['rid'] . ',';
            //$num_of_comments = sizeof($review['comments']);

            $reviews_count = $fs_reviews->get_review_is_like_count($review['rid']);
            $r_like = $reviews_count['r_like'] ? $reviews_count['r_like'] : 0;
            $r_bad = $reviews_count['r_bad'] ? $reviews_count['r_bad'] : 0;
            $fssays = $fs_reviews->get_comments_of_review($review['rid'], $_GET['products_id']);
            $str .= '<div class="p_06" style="" ><dl><dt>';

            $related_param = get_all_related_products($review['products_id']);
            $is_true_customer = fs_get_data_from_db_fields('customers_id', 'reviews', 'reviews_id="' . $review['rid'] . '"', '');
            $virtual_customer = trim(fs_get_data_from_db_fields('customers_name', 'reviews_virtual_customer', 'id="' . $review['vcustomersid'] . '"', ''));
            $virtual_photo = fs_get_data_from_db_fields('portrait', 'reviews_virtual_customer', 'id="' . $review['vcustomersid'] . '"', '');
            $virtual_contury = fs_get_data_from_db_fields('cus_contury', 'reviews_virtual_customer', 'id="' . $review['vcustomersid'] . '"', '');
            $virtual_is_buy = fs_get_data_from_db_fields('is_buy', 'reviews_virtual_customer', 'id="' . $review['vcustomersid'] . '"', '');
            $customerImageSrc = fs_get_data_from_db_fields('customer_photo', 'customers', 'customers_id="' . (int)$review['customersid'] . '"', '');
            $cus_name = fs_get_data_from_db_fields('customers_firstname', 'customers', 'customers_id="' . $review['customersid'] . '"', '') . ' ' . fs_get_data_from_db_fields('customers_lastname', 'customers', 'customers_id="' . $review['customersid'] . '"', '');
            $cus_contry = zen_get_country_name(fs_get_data_from_db_fields('customer_country_id', 'customers', 'customers_id="' . $review['customersid'] . '"', ''));
            $nickname = fs_get_data_from_db_fields('customers_name', 'reviews', 'reviews_id="' . $review['rid'] . '"', '');
            if (!$nickname) {
                $final_name = substr($cus_name, 0, 1) . '***' . substr($cus_name, -1);
            } else {
                $final_name = $nickname;
            }
            if ($is_true_customer != null) {
                $img_class = ($customerImageSrc) ? 'portrait_pic_two' : '';
                $img_src = DIR_WS_IMAGES . (($customerImageSrc) ? $customerImageSrc : 'portrait_pic.jpg');
            } else {
                $img_src = DIR_WS_IMAGES . (($virtual_photo) ? $virtual_photo : 'portrait_pic.jpg');
            }

            $str .= '<span class="P_06_portrait">';
            if ($is_true_customer != null && $is_true_customer == $_SESSION['customer_id']) {

                $str .= '<img src="' .HTTPS_IMAGE_SERVER . $img_src . '" alt="Replace Head" width="48" height="48" border="0">
                <div class="portrait_pic_p '.$img_class.'"><img src="'.HTTPS_IMAGE_SERVER.'images/portrait_pic_p.png" alt="Replace Head" width="32" height="32" border="0">
                <div class="portrait_link"><em><i></i></em><a href="javascript:void(0)"  onclick="replace_to()">' . FS_REVIEWS_REPLACE . '</a>
                <a href="' . zen_href_link(FILENAME_MANAGE_PROFILE, '', 'SSL') . '">' . FS_REVIEWS_EDIT . '</a></div></div>';

            } else {
                $str .= '<img src="' .HTTPS_IMAGE_SERVER . $img_src . '" width="48" height="48" border="0">';
            }
            if ($is_true_customer != null) {
                $name = $final_name;
            } else {
                $name = $virtual_customer;
            }
            $str .= '</span><div class="P_06_name">' . $name . '</div>';
            if ($is_true_customer != null && $cus_contry) {
                $str .= '<div class="P_06_country" >' . $cus_contry . '</div>';
            } else {
                if ($virtual_contury) {
                    $str .= '<div class="P_06_country" >' . $virtual_contury . '</div>';
                }
            }


            if ($is_true_customer != null) {
                if (get_customers_verified_purchase($is_true_customer, $review['products_id'])) {
                    $str .= '<div class="P_06_authentication"><i class="authentication_icon"></i>"' . FS_VERIFIED_PUR . '"</div>';
                }
            } elseif ($virtual_is_buy == 1) {
                $str .= '<div class="P_06_authentication"><i class="authentication_icon"></i>' . FS_VERIFIED_PUR . '</div>';
            }

            $str .= '</dt><dd>';
            if ($review['rating'] == 5) {
                $str .= '<div class="P_06_star"><span class="p_star01"></span><i>' . $review["rating"] . '.0' . '</i></div>';
            }
            if ($review['rating'] == 4) {
                $str .= '<div class="P_06_star"><span class="p_star02"></span><i>' . $review["rating"] . '.0' . '</i></div>';
            }
            if ($review['rating'] == 3) {
                $str .= '<div class="P_06_star"><span class="p_star03"></span><i>' . $review["rating"] . '.0' . '</i></div>';
            }
            if ($review['rating'] == 2) {
                $str .= '<div class="P_06_star"><span class="p_star04"></span><i>' . $review["rating"] . '.0' . '</i></div>';
            }
            if ($review['rating'] == 1) {
                $str .= '<div class="P_06_star"><span class="p_star05"></span><i>' . $review["rating"] . '.0' . '</i></div>';
            }


            if ($review['reviews_headline']) {
                $str .= '<div class="P_06_headline"><a href="' . zen_href_link(FILENAME_COMMENTS_REVIEW, 'rid=' . $review['rid']) . '">' . $review['reviews_headline'] . '</a></div>';
            }
            $str .= '<div class="P_06_content">' . $review['content'] . '</div>';

            /*
            *bof 评论图片
            */

            $reviewsSQL = $db->Execute("select reviews_image from reviews_image where reviews_id =" . $review['rid'] . " and products_id =" . (int)$review['products_id']);
            //var_dump($reviewsSQL);
            $products_review_img = array();
            if ($reviewsSQL->RecordCount()) {
                while (!$reviewsSQL->EOF) {
                    $products_review_img [] = $reviewsSQL->fields['reviews_image'];
                    $reviewsSQL->MoveNext();
                }
            }
            if (sizeof($products_review_img)) {
                $str.='<div class="review_pic"><ul>';
                for ($rpi = 0; $rpi < sizeof($products_review_img); $rpi++) {
                    $img_src = DIR_WS_IMAGES . 'reviews/' . (file_exists(DIR_WS_IMAGES . 'reviews/' . $products_review_img[$rpi]) ? $products_review_img[$rpi] : 'no_picture.gif');
                    $image = zen_image($img_src, '', 100, 100, ' border="0" ');
                    $str .= '<li><a href="javascript:void($(\'.ui-widget-overlay,#basic-modal-content_reviews_' . $review['rid'] . $rpi . '\').show())">' . $image . '</a></li>';
                }
                $str.= '</ul></div>';
            }

            /*
             *产品参数start
             */
            if ($related_param['related']) {
                $str .= '<div class="P_06_attribute"><ul>';
                foreach ($related_param['related'] as $related) {
                    $str .= '<li><span>' . str_replace(':', '', $related['related_name']) . '</span>' . $related['related_value'] . '</li>';
                }
                $str .= '</ul></div>';
            }
            /*
            *产品参数end
            */

            $str .= '<div style="display: none;" id="fs_overlays_reviews" class="ui-overlay"><div class="ui-widget-overlay" style="opacity:0.1;"></div></div>';

//        if (sizeof($products_review_img)) {
//
//            for ($rpii = 0; $rpii < sizeof($products_review_img); $rpii++) {
//                $img_src = DIR_WS_IMAGES . 'reviews/' . (file_exists(DIR_WS_IMAGES . 'reviews/' . $products_review_img[$rpii]) ? $products_review_img[$rpii] : 'no_picture.gif');
//                $image = zen_image($img_src, '', 500, 500, ' border="0" ');
//                $str .= '<div id="basic-modal-content_reviews_' . $review['rid'] . $rpii . '" class="ui-widget ui-widget-content ui-corner-all ui-corner_pop_large" style="">
//		<div class="content_reviews_pic"><span>' . $image . '</span></div>
//		<button id="pic_fot_prev" class="n_prev reviews_btn disabled n_reviews_prev" onclick="pre_pic(' . $review['rid'] . $rpii . ')" >上一张</button>
//		<button id="pic_fot_next" class="n_next reviews_btn n_reviews_next" onclick="next_pic(' . $review['rid'] . $rpii . ')" >下一张</button>
//		<div class="reviews_close"><a href="javascript:;" onclick="$(\'.ui-widget-overlay,#basic-modal-content_reviews_' . $review['rid'] . $rpii . '\').hide();"></a></div></div>';
//            }
//        }

            $re_time = $review['time'] ? $review['time'] : "";

            $str .= '<div class="p_06_02_problem">
                        <span class="p_06_02_pro02"><a href="javascript:click_down('.$review['rid'].')"><i class="solutions_icon s_icon01"></i>&nbsp' . FS_REVIEWS11 . '</a></span>
                        <a  tag="show_or_hide"  id="like_num_of_replys_'.$review['rid'].'" href="javascript:"></a>
                        <a class="p_06_10" href="javascript:void(0);" id="reply_like_'.$review['rid'].'" onclick="reviews_like_or_not('.$review['rid'].',1,\'\');">' . $r_like . '</a>
                        <a class="p_06_11" href="javascript:void(0);" id="reply_not_'.$review['rid'].'" onclick="reviews_like_or_not('.$review['rid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');">'.$r_bad.'</a>
                        <span class="p_06_02_pro02 m_pro_share"><a href="javascript:void(0);" onclick="share_to(' . $review['rid'] . ')"><i class="solutions_icon s_icon03"></i>' . FS_REVIEWS10 . '</a></span>
                        <span class="p_06_02_pro01">  
                        ' . $re_time . '</span>
                    </div><div class="P_06_reply_inputbox" id="reply_frame_'.$review['rid'].'" style="display:none">
                        <input id="write_review' . $review['rid'] . '" class="big_input" type="text" name="customers_name" placeholder="' . FS_PLEASE_W_REVIEW . '" value="" />
                        <div class="solutions_16_btn" >
                            <button class="button_1602" onclick="ajax_submit_comments(\'' . $review['rid'] . '\',\'' . $_SESSION['customer_id'] . '\',\'' . $_GET['products_id'] . '\')">' . FS_SUBMIT . '</button>
                            <button class="button_1601" data-key="" onclick="click_cancel(' . $review['rid'] . ')">' . FS_CANCEL . '</button>
                        </div></div><div id="reply_set' . $review['rid'] . '">';
            if (isset($fssays) && $fssays) {
                foreach ($fssays as $key => $says) {
                    $says_image = fs_get_data_from_db_fields('customer_photo', 'customers', 'customers_id="' . (int)$says['cus_id'] . '"', '');

                    $says_src = DIR_WS_IMAGES . (($says_image) ? $says_image : 'portrait_pic.jpg');
                    $finalsrc = (($says['cus_id'] != '') ? $says_src : DIR_WS_IMAGES . 'portrait_pic09.jpg');

                    $comments_count = $fs_reviews->get_comments_is_like_count($says['cid']);
                    $c_like = $comments_count['r_like'] ? $comments_count['r_like'] : 0;
                    $c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;
                    $del_review = 'del_review' . (int)$says['cid'];
                    $str .= '<div class="' . P_06_reply . $del_review . '">';
                    $str .= '<div class="P_06_reply_icon"><img src="' .HTTPS_IMAGE_SERVER. $finalsrc . '" alt="' . $finalsrc . '" width="28" height="28" border="0"></div>
                                    <div class="P_06_reply_con">
                                        <span class="P_06_reply_text">' . $says['content'] . '</span>
                                        <span class="P_06_reply_name">by&nbsp' . $says['name'] . '</span>
                                        <a tag="show_or_hide" id="like_comment_num_of_replys_ ' . $says['cid'] . '" href="javascript:;"></a>';
                    if ($says['cus_id'] == '' || $says['cus_id'] != $_SESSION['customer_id']) {
                        $str .= '<a class="p_06_10" href="javascript:void(0);" id="reply_like_ ' . $says['cid'] . '" onclick="comments_like_or_not(' . $says['cid'] . ',1,"")">' . $c_like . '</a><a class="p_06_11" href="javascript:void(0);" id="reply_not_ ' . $says['cid'] . '" onclick="comments_like_or_not(' . $says['cid'] . ',0,","' . $_SERVER['REMOTE_ADDR'] . '")"> ' . $c_bad . '</a>';
                    }
                    if ($says['cus_id'] == $_SESSION['customer_id'] && $_SESSION['customer_id'] != '') {
                        $str .= '<a href="javascript:void(0)" class="solutions_icon_h" onclick="del_review(' . (int)$says['cid'] . ',' . (int)$review['rid'] . ')"><i class="solutions_icon s_icon08"></i>' . FIBERSTORE_DELETE . '</a>';
                    }
                    $str .= '</div></div>';

                    if (sizeof($fs_reviews->get_all_reviews_of_reply($review['rid'], '')) > 3) {
                        $str .= '<div class="P_06_reply_more"><a href="' . zen_href_link(FILENAME_COMMENTS_REVIEW, "&rid=" . $review['rid']) . '">View all ' . $fs_reviews->get_all_reviews_of_reply($review['rid'], '') ? sizeof($fs_reviews->get_all_reviews_of_reply($review['rid'], '')) : "";
                        'Replies<i class="arrow"></i></a></div>';

                    }
                }
            }
            $str .= '</div><div class="P_06_see_more "></div></dd></dl></div>';
        }
        $page_next = $fs_reviews->get_page_reviews_of_product_count($_GET['products_id'], $_GET['page'] + '1', '');

        if ($page_next == 0) {
            $str .= '
        <script type="text/javascript">
            $(".P_06_morebtn").hide();
        </script>';
        }
        echo $str;
        die;
    }
}




