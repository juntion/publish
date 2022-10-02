<?php
use App\Services\Reviews\ReviewServices;

if(isset($_GET['request_type']) && !empty($_POST)){
	require 'includes/application_top.php';
	require DIR_WS_CLASSES . 'fs_reviews.php';
				$fs_reviews = new fs_reviews();
    require_once DIR_WS_LANGUAGES.$_SESSION['language'].'/views/customer_qa.php'; // 表单验证语言包

	function get_comments_of_review($rid){
		global $db;
		$comments = array();
		$comments_sql = "select r.comments_id, r.last_modified, rd.customers_id, rd.customers_name, rd.comments_content from " . TABLE_REVIEWS_COMMENTS .
		" AS r left join ".TABLE_REVIEWS_COMMENTS_DESCRIPTION." as rd using(comments_id)  WHERE  r.reviews_id = :rid 
		  AND r.status =1
		  ORDER BY r.is_fiberstore desc,r.date_added desc 
			";
		
		$comments_sql = $db->bindVars($comments_sql, ':rid', (int)$rid, 'integer');
		$get_comments = $db->Execute($comments_sql);
		if ($get_comments->RecordCount()){
			while(!$get_comments->EOF){
				$comments[] = array(
					'cid' => $get_comments->fields['comments_id'],
					'cus_id'=> $get_comments->fields['customers_id'],
					'name'=> $get_comments->fields['customers_name'],
					'content'=>$get_comments->fields['comments_content'],
					'time'=>date('F j,Y',strtotime($get_comments->fields['last_modified'])),
				);
				$get_comments->MoveNext();
			}
		}
		return $comments;
	}
	$reviewService = new ReviewServices();
	
	switch($_GET['request_type']){
	    case 'page_update':
	    //type 1,; 2,点击评论筛选; 3,点击more
        //$is_img = $_POST['is_img'];
        $pic_star_num=0;
        $star_num=0;
        $is_img = $_POST['is_img'];
        $review_star_rebirth = zen_db_prepare_input($_POST['review_star']);
        $rid = (int)zen_db_prepare_input($_POST['rid']) ? (int)zen_db_prepare_input($_POST['rid']) : 0;
        $review_star_rebirth = $review_star_rebirth ? $review_star_rebirth : 'newest'; //排序
	    if(in_array($review_star_rebirth,array(1,2,3,4,5,'one_month','six_months'))){
	        if($review_star_rebirth == 'one_month') {
                //最近一个月的评论条数
                $endTime = date('Y-m-d',time());
                $starTime = date('Y-m-d',time()-30*24*3600);
                $res_star = ' date_added>="' . $starTime . '" and date_added<="' . $endTime . '"';
            } elseif ($review_star_rebirth == 'six_months') {
                //最近一个月的评论条数
                $endTime = date('Y-m-d',time());
                $starTime = date('Y-m-d',time()-180*24*3600);
                $res_star = ' date_added>="' . $starTime . '" and date_added<="' . $endTime . '"';
            } else {
                $res_star = ' reviews_rating='.$_POST['review_star'];
            }
        }else{
            $res_star = '';
            if ($rid) {
                $res_star = ' reviews.reviews_id = '.$rid;
            }
        }

        if ($is_img) {
            $reviewsImgIds = $reviewService->getAllReviewsImg((int)$_POST['id']);
            if ($reviewsImgIds) {
                $reviewsImgIds = array_column($reviewsImgIds, 'reviews_id');
                $res_star .= (!empty($res_star) ? ' and ' : '').' reviews.reviews_id in('.join(',',$reviewsImgIds).')';
            }
        }

        $label_id = $_POST['label_id'];
        if(isset($label_id) && !empty($label_id)){
            $language_id = $_SESSION['languages_id']==9 ? 1 : $_SESSION['languages_id'];
            $res_star = ' rtl.label_id = '.$label_id." AND rld.language_id = {$language_id}";
        }
        $is_mobile = (int)$_POST["is_mobile"];
	    $page = $_POST['page'] ? (int)$_POST['page'] : 1;
	    $offset = ($page - 1) * 10;
	    $limit = 10;
	    $reviewsData = $reviewService->reviewData((int)$_POST['id'], $offset, $limit, $res_star,$review_star_rebirth);
        $page_reviews = $reviewsData['reviewsData'];
        $content_of_reviews = sizeof($page_reviews);

		$content ='';
          if ($content_of_reviews){
              $reviews_result = $reviewService->getTotalReviews($reviewService->relatedArr, $res_star);
              $pic_star_num = $reviews_result['reviewTotalImg'];
              $star_num = $reviews_result['reviewsTotalNum'];
              foreach ($page_reviews as  $ii => $review ){
                  //获取图片
                  //$images_arr = get_reviews_images($review['rid'], (int)$review['products_id']);
                  $comments = $review['reviewsComment'];
                  $customersid_end = $review['customers_end'];
                  $firstWord = $review['firstWord'];


                  $customer_pic = $review['customer_pic'];
                  if ($customer_pic) {
                      $avatar_img = HTTPS_IMAGE_SERVER.'images/'.$customer_pic;
                      if(file_exists('images/'.$customer_pic)) {
                          $img_src = $avatar_img;
                      }else{
                          $img_src = HTTPS_IMAGE_SERVER.'images/portrait_pic.jpg';
                      }
                  } else {
                      $img_src = HTTPS_IMAGE_SERVER.'images/portrait_pic.jpg';
                  }

                  // $virtual_是默认头像一起去掉
                  if (strpos($img_src, 'images/portrait_pic')){
                      $img_src = HTTPS_IMAGE_SERVER.'images/portrait_pic.jpg';
                  }

                  // 2019-7-11 potato 未设置头像的改成首字母样式
                  if (strstr($img_src, 'portrait_pic.jpg')) {
//                      if ($customersid_end <= 3) {          // 数字小于3的用这个背景
//                          $color = 'background:#6b89a5;';
//                      } elseif ($customersid_end > 6) {       // 数字大于6的用这个背景
//                          $color = 'background:#5c9ea0;';
//                      } else {
//                          $color = 'background:#92af85;';
//                      }
                      $color = 'background: linear-gradient(-120deg, #A6AAB7, #868A93);';
                      $img_src = '';
                  }

                  // 没有头像的显示首字母
                  if (in_array($firstWord, ['J', 'P', 'D', 'L'])) {
                      $color .= 'text-indent: 2px;';
                  }
                  if ($firstWord == 'J') {
                      $color .= 'line-height: 30px';
                  }
                  //M端样式
                  if ($is_mobile == 1) {
                      $content .= '<div class="reviewList"><div class="reviewList_user after"><span class="P_06_portrait">';
                      // 2019-7-13 potato 有头像的显示头像，没有的显示首字母
                      if ($img_src) {
                          $content .= '<img src="' . $img_src . '" alt="' . $review['customersid'] . '" width="48" height="48" border="0">';
                      } else {
                          $content .= '<i style="' . $color . '" >';
                          $content .= $firstWord;
                          $content .= '</i>';
                      }
                      $content .= '</span>';
                      $content .= '<div class="P_06_name"><span>';
                      if ($_SESSION['languages_code'] != 'au') {
                          $country_str = '</span><div class="P_06_country">' . $review['country_name'] . '</div>';
                      } else {
                          $country_str = '</span><div class="P_06_country review_time" >' . $review['time'] . '</div>';
                      }
                      $content .= $review['name'].$country_str;
                      $content .= '</div>';

                      if ($_SESSION['languages_code'] != 'au') {
                          $content .= '<span class="right_times">' . $review['time'] . '</span>';
                      }

                      //评论星级
                      $content .= '</div>';
                      $style_css = '';
                      $content .= '<div class="P_06_star"><div class="new-fsproStars-box new-fsproStars-16 after">';
                      for ($i=1;$i<6;$i++){
                          if($i > $review['rating']){
                              $style_css = 'style="width:0%"';
                          }
                          $content .= '<div class="new-fsproStars-main">
                            <div class="iconfont icon new-fsproStars-icBg">&#xf132;</div>
                            <div class="iconfont icon new-fsproStars-icon" '.$style_css.'>&#xf132;</div>
                            </div>';
                      }
                      $content .= '</div>';
                      $content .= '<i>' . $review["rating"] . '.0' . '</i>';
                      $content .= '</div>';
                      if ($review['reviews_headline']) {
                          $content .= '<div class="review_text">' . $review['reviews_headline'] . '</div>';
                      }

                      $content .= '<div class="review_mians more-content-boxDem"><div class="more-content-childDem">' . $review['content'] . '</div><div class="more-content-childFilter"></div></div>';
                      $content .= '<div class="more-content-showBtn-box after"><div class="more-content-showBtn-main after"><div>' . FS_READ_MORE . '</div><span class="iconfont icon">&#xf087;</span></div></div>';
                      if (count($comments) > 0) {
                          $content .= '<div class="review_tips"><div id="reply_set_'.$review['rid'].'"><div class="review_tips_text">';
                          $content .= '<p class="review_tips_title" id="p_reply_h2_'.$review['rid'].'">';
                          if ($_SESSION['languages_code'] == 'jp') {
                              $content .= count($comments) > 1 ? FS_REVIEWS31 : FS_REVIEWS31_01;
                              $content .= ' ' . count($comments);
                              $content .= ' ';
                              $content .= (count($comments) > 1 ? FS_REVIEWS36 : FS_REVIEWS32_01);
                          } else {
                              $content .= FS_REVIEWS31;
                              $content .= ' ';
                              $content .= count($comments);
                              $content .= ' ';
                              $content .= (count($comments) > 1 ? FS_REVIEWS36 : FS_REVIEWS32);
                          }

                          $content .= '</p>';
                          foreach($comments as $key=> $comment){
                              $created_by =  FS_BY . '&nbsp;' . $comment['customers_name'];
                              if($_SESSION['languages_code'] =='jp'){
                                  $created_by = $comment['customers_name'].FS_BY;
                              }
                              $content .= '<p class="review_mians">' . $comment['comments_content'] . '<em class="pro_wei01">' .$created_by . '</em></p>';
                          }
                          $content .= '</div></div></div>';
                      }

                      /*if ($is_true_customer != null) {
                          if (get_customers_verified_purchase($review['customersid'], $review['products_id'])) {
                              $content .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                          }
                      } elseif ($virtual_is_buy == 1) {
                          $content .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                      }*/
                      $content .= '<div class="review-qa-authentication-box after">';
                      $content .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                      //图片
                      if (sizeof($review['reviewsInfo'])) {
                          $content .= '<div class="m_pic" data-pswp-uid="' . $ii . '">';
                          foreach ($review['reviewsInfo'] as $kk => $img) {
                              if($img['is_v_tag_type'] == 1){
                                  $imgPath = HTTPS_IMAGE_SERVER;
                              }else{
                                  $imgPath = HTTPS_IMAGE_SERVER . 'images/reviews/';
                              }
                              if ($img['reviews_image_thumb']) {
                                  $small_img = '<img src="' . $imgPath.$img['reviews_image_thumb'][0]['reviews_image_tb'] . '">';
                                  $big_img = $img['reviews_image_thumb'][1]['reviews_image_tb'];
                                  $size_w = $img['reviews_image_thumb'][1]['size_w'];
                                  $size_h = $img['reviews_image_thumb'][1]['size_h'];
                              } else {
                                  $small_img = '<img src="' . $imgPath.$img['reviews_image'] . '"  width="100" height="100"/>';
                                  $big_img = $img['reviews_image'];
                                  $size_w = $img['size_w'];
                                  $size_h = $img['size_h'];
                              }
                              $content .= '<figure data-rid="'.$review['rid'].'" data-imgid="'.$img['reviews_image_id'].'"><span>' . $small_img . '</span></figure>';
                          }
                          $content .= '</div>';
                      }

                      $content .= '<div class="qa_comments">
                                <input type="hidden" class="pro_report_'.$review['rid'].'" value="0">
                                <a  tag="show_or_hide"  id="like_num_of_replys_'.$review['rid'].'" href="javascript:;"></a>
                                <div class="qa_comments_right">
                                    <div class="p_06_02_problem">
                                        <p class="reply_like_'.$review['rid'].'" onclick="reviews_like_or_not001('.$review['rid'].',1,\'\',1);" >
                                            <i class="iconfont icon">&#xf173;</i>
                                            <span class="r_like new_reviews_like" style="padding-left: 5px;">'.$review['r_like'].'</span>
                                        </p>
                                        <p id="new_comment_'.$review['rid'].'" onclick="replay('.$review['rid'].')">
                                            <span class="iconfont icon">&#xf151;</span>
                                            <span class="r_like" style="padding-left: 5px;">'.(count($comments) ? count($comments) : 0).'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </div>';
                      //回复隐藏层
                      $content .= '<div class="P_06_reply_inputbox reply_frame_' . $review['rid'] . '" style="display:none">';
                      $content .= '<input id="write_review' . $review['rid'] . '" class="big_input" type="text" name="customers_name" placeholder="' . ($_SESSION['customer_id'] ? FS_PLEASE_W_REVIEW : FS_REVIEWS_COMMENT_DEACRIPTION) . '" value="" />
                                <div class="solutions_16_btn" >';
                      if($_SESSION['customer_id']){
                          $content .= '<button class="button_1602" onclick="ajax_submit_comments(' . $review['rid'] . ',' . $review['products_id'] . ')">' . FS_SUBMIT . '</button>';
                      }
                      $content .= '</div></div></div>';
                  } else {
                      $content .= '<div class="p_06"><dl><dt>';
                      $content .= '<span class="P_06_portrait">';
                      if ($img_src) {
                          $content .= '<img src="' . $img_src . '" alt="' . $review['customersid'] . '" width="48" height="48" border="0">';
                      } else {
                          $content .= '<i style="'.$color.'" >';
                          $content .= $firstWord;
                          $content .= '</i>';
                      }
                      $content .= '</span>';
                      if ($_SESSION['languages_code'] != 'au') {
                          $country_str = '</span><div class="P_06_country">' . $review['country_name'] . '</div>';
                      } else {
                          $country_str = '</span><div class="P_06_country review_time" >' . $review['time'] . '</div>';
                      }
                      $content .= '<div class="P_06_name"><span>';
                      $content .= $review['name'].$country_str;

                      $content .= '</div></dt><dd>';

                      if ($review['rating']) {
                          $class = getRatingClass($review['rating']);
                          $content .= '<div class="P_06_star"><span class="'.$class.'"></span><i>' . $review["rating"] . '.0' . '</i></div>';
                      }

                      if($_SESSION['languages_code'] == 'au'){
                          $review_time = "";
                      } else {
                          $review_time = $review['time'];
                      }
                      if ($_SESSION['languages_code'] != 'au') {
                          $content .= '<span class="p_06_02_pro01">' . $review_time . '</span>';
                      }
                      if ($review['reviews_headline']) {
                          $content .= '<div class="P_06_headline">' . $review['reviews_headline'] . '</div>';
                      }

                      /*评论属性展示*/
                      $attrHtml = '';
                      if (!empty($review['modelAttr'])) {
                          foreach ($review['modelAttr'] as $attrVal) {
                              $transceiver_type_model = '';
                              if ($attrVal['transceiver_type_model']) {
                                  $transceiver_type_model = $attrVal['transceiver_type_model']['products_MFG_PART'] ? $attrVal['transceiver_type_model']['products_MFG_PART'] : $attrVal['transceiver_type_model']['products_model'];
                              }
                              $attrHtml .= $attrVal['related_attribute_content'].': '.($transceiver_type_model ? $transceiver_type_model : $attrVal['attributes_relation_content']).'  |  ';
                          }
                      }
                      if ($review['equipment_mode']) {
                          $attrHtml .= FS_REVIEW_07.': '.$review['equipment_mode'];
                      } else {
                          $attrHtml = rtrim($attrHtml, '|  ');
                      }
                      $content .= '<p class="new_review_txt">'.$attrHtml.'</p>';

                      $content .= '<div class="P_06_content more-content-boxDem"><div class="more-content-childDem">' . $review['content'] . '</div>
                            <div class="more-content-childFilter"></div></div>';
                      $content .= '<div class="more-content-showBtn-box after"><div class="more-content-showBtn-main after"><div>'.FS_READ_MORE.'</div><span class="iconfont icon">&#xf087;</span></div></div>';

                      if (sizeof($review['reviewsInfo'])) {
                          $content .= '<div class="review_pic"><ul>';
                          foreach ($review['reviewsInfo'] as $kk => $img) {
                              if($img['is_v_tag_type'] == 1){
                                  $imgPath = HTTPS_IMAGE_SERVER;
                              }else{
                                  $imgPath = HTTPS_IMAGE_SERVER . 'images/reviews/';
                              }
                              if ($img['reviews_image_thumb']) {
                                  if ((isset($img['reviews_image_thumb'][0]['reviews_image_tb'])) && (strpos($img['reviews_image_thumb'][0]['reviews_image_tb'], '.webp') !== false) && (!is_support_webp())) {
                                      $img['reviews_image_thumb'][0]['reviews_image_tb'] = substr($img['reviews_image_thumb'][0]['reviews_image_tb'], 0, strrpos($img['reviews_image_thumb'][0]['reviews_image_tb'], '.webp'));
                                  }
                                  if ((isset($img['reviews_image_thumb'][1]['reviews_image_tb'])) && (strpos($img['reviews_image_thumb'][1]['reviews_image_tb'], '.webp') !== false) && (!is_support_webp())) {
                                      $img['reviews_image_thumb'][1]['reviews_image_tb'] = substr($img['reviews_image_thumb'][1]['reviews_image_tb'], 0, strrpos($img['reviews_image_thumb'][1]['reviews_image_tb'], '.webp'));
                                  }

                                  $content.= '<li class="detail_click_pic" data-rid="'.$review['rid'].'" data-imgid="'.$img['reviews_image_id'].'"><a data-width="' . $img['reviews_image_thumb'][1]['size_w'] .'" data-height="'. $img['reviews_image_thumb'][1]['size_h']. '"  data-img="' . $imgPath.$img['reviews_image_thumb'][1]['reviews_image_tb'] . '" href="javascript:void(0)"><img src="' . $imgPath.$img['reviews_image_thumb'][0]['reviews_image_tb'] . '"></a></li>';
                              } else {
                                  if ((strpos($img['reviews_image'], '.webp') !== false) && (!is_support_webp())) {
                                      $img['reviews_image'] = substr($img['reviews_image'], 0, strrpos($img['reviews_image'], '.webp'));
                                  }
                                  $content.= '<li class="detail_click_pic" data-rid="'.$review['rid'].'" data-imgid="'.$img['reviews_image_id'].'"><a data-width="' . $img['size_w'] .'" data-height="'. $img['size_h']. '"  data-img="' . $imgPath.$img['reviews_image'] . '" href="javascript:void(0)"><img src="' . $imgPath.$img['reviews_image'] . '"  width="100" height="100"/></a></li>';
                              }
                          }
                          $content .= '</ul></div>';
                      }

                      /*if ($is_true_customer != null) {
                          if (get_customers_verified_purchase($review['customersid'], $review['products_id'])) {
                              $content .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                          }
                      } elseif ($virtual_is_buy == 1) {
                          $content .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                      }*/

                      $content .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';

                      //评论回复
                      $content .= '<div id="reply_set_' . $review['rid'] . '">';
                      if (count($comments) > 0) {
                          $content .= '<div class="pro_hf pro_hf_002">';
                          if ($_SESSION['languages_code'] == 'jp') {
                              $content .= '<h2 class="p_reply_h2">';
                              $content .= count($comments) > 1 ? FS_REVIEWS31 : FS_REVIEWS31_01;
                              $content .= ' ' . count($comments);
                              $content .= ' ';
                              $content .= (count($comments) > 1 ? FS_REVIEWS36 : FS_REVIEWS32_01);

                              $content .= '</h2>';
                          } else {
                              $content .= '<h2 class="p_reply_h2">' . FS_REVIEWS31 . ' ' . count($comments) . ' ' . (count($comments) > 1 ? FS_REVIEWS36 : FS_REVIEWS32) . '</h2>';
                          }

                          if (isset($comments) && $comments) {
                              foreach ($comments as $key => $comment) {
                                  $created_by =  FS_BY . '&nbsp;' . $comment['customers_name'];
                                  if($_SESSION['languages_code'] =='jp'){
                                      $created_by = $comment['customers_name'].FS_BY;
                                  }
                                  $content .= '<p class="p_question_tit">' . $comment['comments_content'] . '<em class="pro_wei01">' . $created_by . '</em></p>';
                              }
                          }
                          $content .= '</div>';
                      }
                      $content .= '</div>';

                      $content .= '<div class="p_06_02_problem after">';
                      $content .= '<a  tag="show_or_hide"  id="like_num_of_replys_' . $review['rid'] . '" href="javascript:;"></a>';
                      $content .= '<a class="p_06_10  pro_a_one" href="javascript:reviews_like_or_not001(' . $review['rid'] . ',1,\'\',);" id="reply_like_' . $review['rid'] . '" >';
                      $content .= '<span class="iconfont icon">&#xf173;</span>';
                      $content .= '<span class="new_reviews_like">';
                      $content .= $review['r_like'];
                      $content .= '</span>';
                      $content .= '</a>';
                      $content .= '<input type="hidden" class="pro_report_' . $review['rid'] . '" value="0">';
                      $content .= '<span class="p_06_02_pro02" id="new_comment_' . $review['rid'] . '"><a class="pro_a_only" href="javascript:click_down(' . $review['rid'] . ',\'' . $_SESSION["customer_id"] . '\');">';
                      $content .= '<span class="iconfont icon">&#xf151;</span>';
                      $content .= '<span class="new_reviews_comment">';
                      $content .= ($comments ? count($comments) : 0) . '</span></a></span>';
                      $content .= '</div>';

                      $content .= '<div class="P_06_reply_inputbox" id="reply_frame_' . $review['rid'] . '" style="display:none">';
                      $content .= '<input id="write_review' . $review['rid'] . '" class="big_input" type="text" name="customers_name" placeholder="' . ($_SESSION['customer_id'] ? FS_PLEASE_W_REVIEW : FS_REVIEWS_COMMENT_DEACRIPTION) . '" value="" />
                                <div class="solutions_16_btn" >';
                      if($_SESSION['customer_id']){
                          $content .= '<button class="button_1602" onclick="ajax_submit_comments(' . $review['rid'] . ',\'' . $_SESSION['customer_id'] . '\',' . $review['products_id'] . ')">' . FS_SUBMIT . '</button>';                        }
                      $content .= '</div>';
                      $content .= '</div>';
                      $content .= '</dd>
		    </dl>
		   </div>';
                  }
              }
          }
          $content .='</div>';
            $total = (int)$_POST['total'];
            $type = (int)$_POST['type'];

            if($is_img){ //如果筛选为图片分页
                $type = 1;
                if ($pic_star_num > 0) {
                    $total_page = ceil(($pic_star_num/10));
                }
            }else{
                $type = 2;
                $total_page = ceil(($star_num/10));
            }
            $content .= getReviewPage((int)$_POST['id'],$total_page,$page,$type,$review_star_rebirth,false,$is_img);
            exit(json_encode(array('star_num'=>$star_num,'content'=>$content,'pic_star_num'=>$pic_star_num)));
			break;

		case 'page_change':
			
				$reviews_result = $fs_reviews->get_page_reviews_of_customers($_POST['id'],$_POST['page']);
				
				$content_of_reviews = sizeof($reviews_result);
				
			
                $content ='';
				   if ($content_of_reviews){
                		$js_for_replys = '';
                		foreach ($reviews_result as  $ii => $review ){
			
						$js_for_replys .= '#num_of_replys_'.$review['rid'].',';
						$num_of_comments = sizeof($review['comments']);
						
						$reviews_count = $fs_reviews->get_review_is_like_count($review['rid']);
						$r_like = $reviews_count['r_like'] ? $reviews_count['r_like'] : 0;
						$r_bad  = $reviews_count['r_bad'] ? $reviews_count['r_bad'] : 0;
                        $review_products_name=zen_get_products_name($review['products_id']);
						$images= zen_image(DIR_WS_IMAGES.'no_picture.gif','',100,100);
						$href='<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,
						'&products_id='.$review['products_id'],'SSL').'">';
						
		 $content .='<div class="review">'.$href.$images.'
            
           </a><ul> <li class="review_01">'.$href.$review_products_name.'</a></li><li>';
         if($review['rating']==5){ 
         $content .='<div class="P_06_star"><span class="p_star01"></span><i>'.$review["rating"].'.0'.'</i></div></li>';} 
         if($review['rating']==4){
         	$content .='<div class="P_06_star"><span class="p_star02"></span><i>'.$review["rating"].'.0'.'</i></div></li>';
         }
         if($review['rating']==3){$content .='<div class="P_06_star"><span class="p_star03"></span><i>'.$review["rating"].'.0'.'</i></div></li>'
         ;}
         if($review['rating']==2){$content .='<div class="P_06_star"><span class="p_star04"></span><i>'.$review["rating"].'.0'.'</i></div></li>'
         ;}
         if($review['rating']==1){$content .='<div class="P_06_star"><span class="p_star05"></span><i>'.$review["rating"].'.0'.'</i></div></li>'
         ;}
         $content .='<li class="review_03">'.$review['content'].'</li>';
         $content .='<li class="review_02">'.$review['time'].'</li>';
		 $content .='</ul></div>';
		}
		}
		echo  $content;
		
          exit; 
			break;
			
		case 'solutionpage_update':
				$solhtml='';
				 $solution_result =get_article_three($_POST['page']);
				//var_dump($solution_result);
				 
				 foreach ($solution_result as $k => $v){
					 $description = $v['intro']?$v['intro']:$v['description'];
					 if(preg_match('/<style.*<\/style>/',$description)){
						$description = preg_replace('/<style.*<\/style>/','',$description);
					 }
					 if(preg_match('/<script.*<\/script>/',$description)){
			             $description = preg_replace('/<script.*<\/script>/','',$description);
		              } 
					 $description = strip_tags($description);
					 $description = str_replace('&nbsp;','',$description);
					 $title=(strlen($v['title'])>50)?mb_substr($v['title'],0,50,'utf-8').'...':$v['title'];
					 $seo_descriptiom =(strlen($description)>120) ? (mb_substr($description,0,120,'utf-8').'...') : $description;
					 $image = $v['image'];
					 $seo_href = zen_href_link('support_detail','&supportid='.$v['id']);
				
				 $solhtml.= '<li ><a target="_blank" href="'.$seo_href.'"><div class="product_index_con01_pic">
				 
				 <img width="285px" height="165px" src="'.HTTPS_IMAGE_SERVER.'images/'.$image.'" alt="'.$title.'"><div class="white_shadow"></div></div>';
				 $solhtml.= '<span><b style="height: 40px;display:block"> '.$title.'</b>';
				 $solhtml.= ' <p>'.$seo_descriptiom.'</p>';
				 $solhtml.= '<em  target="_blank" title="'.$title.'" href="'.$seo_href.'">'.FS_LEARN_MORE.'</em>';
				 $solhtml.=' </span></a></li>';
				 }
				
				echo  $solhtml;
				exit; 
				break;

	    case 'reviews_images':
		$id =$_POST['id'];
        $res_star ='';
        $is_img = $_POST['is_img'];
        $review_star = zen_db_prepare_input($_POST['review_star']);
        $pic_star_num =0;
        $review_star = $review_star ? $review_star : 'newest';
        if(in_array($review_star,array(1,2,3,4,5,'one_month','six_months'))){
            if($review_star == 'one_month') {
                //最近一个月的评论条数
                $endTime = date('Y-m-d',time());
                $starTime = date('Y-m-d',time()-30*24*3600);
                $res_star = ' date_added>="' . $starTime . '" and date_added<="' . $endTime . '"';
            } elseif ($review_star == 'six_months') {
                //最近一个月的评论条数
                $endTime = date('Y-m-d',time());
                $starTime = date('Y-m-d',time()-180*24*3600);
                $res_star = ' date_added>="' . $starTime . '" and date_added<="' . $endTime . '"';
            } else {
                $res_star = ' reviews_rating='.$_POST['review_star'];
            }
        }else{
            $res_star .= '';
        }

        if ($is_img) {
            $reviewsImgIds = $reviewService->getAllReviewsImg((int)$id);
            if ($reviewsImgIds) {
                $reviewsImgIds = array_column($reviewsImgIds, 'reviews_id');
                $res_star .= (!empty($res_star) ? ' and ' : '').' reviews.reviews_id in('.join(',',$reviewsImgIds).')';
            }
        }

        $is_mobile = (int)$_POST["is_mobile"];
        $page = $_POST['page'] ? $_POST['page'] : 1;
        $offset = ($page - 1) * 10;


        $reviewsData = $reviewService->reviewData((int)$_POST['id'], $offset, 10, $res_star,$review_star);
        $page_reviews = $reviewsData['reviewsData'];
        $content_of_reviews = sizeof($page_reviews);

		$html ='';
		if (sizeof($page_reviews)){
		    //图片评论总数
            $reviews_result = $reviewService->getTotalReviews($reviewService->relatedArr, $res_star);
            $pic_star_num = $reviews_result['reviewTotalImg'];
            $total_num = $reviews_result['reviewsTotalNum'];

			foreach ($page_reviews as  $ii => $review ){
			    //获取图片
                //$images_arr = get_reviews_images($review['rid'], (int)$review['products_id']);

                $customer_pic = $review['customer_pic'];

                if ($customer_pic) {
                    $avatar_img = HTTPS_IMAGE_SERVER.'images/'.$customer_pic;
                    if(file_exists('images/'.$customer_pic)) {
                        $img_src = $avatar_img;
                    }else{
                        $img_src = HTTPS_IMAGE_SERVER.'images/portrait_pic.jpg';
                    }
                } else {
                    $img_src = HTTPS_IMAGE_SERVER.'images/portrait_pic.jpg';
                }

                // $virtual_是默认头像一起去掉
                if (strpos($img_src, 'images/portrait_pic')){
                    $img_src = HTTPS_IMAGE_SERVER.'images/portrait_pic.jpg';
                }

                $customersid_end = $review['customers_end'];
                if (strstr($img_src, 'portrait_pic.jpg')) {
//                    if ($customersid_end <= 3) {          // 数字小于3的用这个背景
//                        $color = 'background:#6b89a5;';
//                    } elseif ($customersid_end > 6) {       // 数字大于6的用这个背景
//                        $color = 'background:#5c9ea0;';
//                    } else {
//                        $color = 'background:#92af85;';
//                    }
                    $color = 'background: linear-gradient(-120deg, #A6AAB7, #868A93);';
                    $img_src = '';
                }

                // 没有头像的显示首字母
                $firstWord = $review['firstWord'];
                if (in_array($firstWord, ['J', 'P', 'D', 'L'])) {
                    $color .= 'text-indent: 2px;';
                }
                if ($firstWord == 'J') {
                    $color .= 'line-height: 30px';
                }
                $comment_num = $review['reviewsComment'] ? sizeof($review['reviewsComment']) : 0;
                $r_like = $review['r_like'] ? $review['r_like'] : 0;

				if ($is_mobile == 1){
                    $html .= '<div class="reviewList"><div class="reviewList_user after"><span class="P_06_portrait">';
                    if ($img_src){
                        $html .= '<img src="' . $img_src . '" alt="' . $review['customersid'] . '" width="48" height="48" border="0">';
                    } else {
                        $html .= '<i style="' . $color . '" >';
                        $html .= $firstWord;
                        $html .= '</i>';
                    }
                    $html .= '</span>';
                    $html .= '<div class="P_06_name"><span>';
                    if ($_SESSION['languages_code'] != 'au') {
                        $country_str = '</span><div class="P_06_country">' . $review['country_name'] . '</div>';
                    } else {
                        $country_str = '</span><div class="P_06_country review_time" >' . $review['time'] . '</div>';
                    }
                    $html .= $review['name'].$country_str;
                    $html .= '</div>';

                    if ($_SESSION['languages_code'] != 'au') {
                        $html .= '<span class="right_times">' . $review['time'] . '</span>';
                    }
                    //评论星级
                    $html .= '</div>';
                    if($review['rating']){
                        $class = getRatingClass($review['rating']);
                        $html .= '<div class="P_06_star"><span class="'.$class.'"></span><i>'.$review["rating"].'.0'.'</i></div>';
                    }

                    /*评论属性展示*/
                    $attrHtml = '';
                    if (!empty($review['modelAttr'])) {
                        foreach ($review['modelAttr'] as $attrVal) {
                            $transceiver_type_model = '';
                            if ($attrVal['transceiver_type_model']) {
                                $transceiver_type_model = $attrVal['transceiver_type_model']['products_MFG_PART'] ? $attrVal['transceiver_type_model']['products_MFG_PART'] : $attrVal['transceiver_type_model']['products_model'];
                            }
                            $attrHtml .= $attrVal['related_attribute_content'].': '.($transceiver_type_model ? $transceiver_type_model : $attrVal['attributes_relation_content']).'  |  ';
                        }
                    }
                    if ($review['equipment_mode']) {
                        $attrHtml .= FS_REVIEW_07.': '.$review['equipment_mode'];
                    } else {
                        $attrHtml = rtrim($attrHtml, '|  ');
                    }
                    $html .= '<p class="new_review_txt">'.$attrHtml.'</p>';

                    $html .= '<div class="review_mians more-content-boxDem"><div class="more-content-childDem">' . $review['content'] . '</div><div class="more-content-childFilter"></div></div>';
                    $html .= '<div class="more-content-showBtn-box after"><div class="more-content-showBtn-main after"><div>' . FS_READ_MORE . '</div><span class="iconfont icon">&#xf087;</span></div></div>';

                    //回复
                    if ($comment_num) {
                        $html .= '<div class="review_tips"><div id="reply_set_'.$review['rid'].'"><div class="review_tips_text">';
                        $html .= '<p class="review_tips_title" id="p_reply_h2_'.$review['rid'].'">' . FS_REVIEWS31 . ' ' . $comment_num . ' ' . ($comment_num > 1 ? FS_REVIEWS36 : FS_REVIEWS32) . '</p>';
                        foreach($review['reviewsComment'] as $key=> $comment){
                            $created_by =  FS_BY . '&nbsp;' . $comment['customers_name'];
                            if($_SESSION['languages_code'] =='jp'){
                                $created_by = $comment['customers_name'].FS_BY;
                            }
                            $html .= '<p class="review_mians">' . $comment['comments_content'] . '<em class="pro_wei01">' . $created_by . '</em></p>';
                        }
                        $html .= '</div></div></div>';
                    }
                    /*if ($is_true_customer != null) {
                        if (get_customers_verified_purchase($review['customersid'], $review['products_id'])) {
                            $html .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                        }
                    } elseif ($virtual_is_buy == 1) {
                        $html .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                    }*/
                    $html .= '<div class="review-qa-authentication-box after">';
                    $html .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                    //图片
                    if (sizeof($review['reviewsInfo'])) {
                        $html .= '<div class="m_pic" data-pswp-uid="' . $ii . '">';
                        foreach ($review['reviewsInfo'] as $kk => $img) {
                            if($img['is_v_tag_type'] == 1){
                                $imgPath = HTTPS_IMAGE_SERVER;
                            }else{
                                $imgPath = HTTPS_IMAGE_SERVER . 'images/reviews/';
                            }
                            if ($img['reviews_image_thumb']) {
                                $small_img = '<img src="' . $imgPath.$img['reviews_image_thumb'][0]['reviews_image_tb'] . '">';
                                $big_img = $img['reviews_image_thumb'][1]['reviews_image_tb'];
                                $size_w = $img['reviews_image_thumb'][1]['size_w'];
                                $size_h = $img['reviews_image_thumb'][1]['size_h'];
                            } else {
                                $small_img = '<img src="' . $imgPath.$img['reviews_image'] . '"  width="100" height="100"/>';
                                $big_img = $img['reviews_image'];
                                $size_w = $img['size_w'];
                                $size_h = $img['size_h'];
                            }
                            $html .= '<figure data-rid="'.$review['rid'].'" data-imgid="'.$img['reviews_image_id'].'"><span>' . $small_img . '</span></figure>';
                        }
                        $html .= '</div>';
                    }
                    $html .= '<div class="qa_comments">
                                <input type="hidden" class="pro_report_'.$review['rid'].'" value="0">
                                <a  tag="show_or_hide"  id="like_num_of_replys_'.$review['rid'].'" href="javascript:;"></a>
                                <div class="qa_comments_right">
                                    <div class="p_06_02_problem">
                                        <p class="reply_like_'.$review['rid'].'" onclick="reviews_like_or_not001('.$review['rid'].',1,\'\',1);" >
                                            <i class="iconfont icon">&#xf173;</i>
                                            <span class="r_like new_reviews_like" style="padding-left: 5px;">'.$review['r_like'].'</span>
                                        </p>
                                        <p id="new_comment_'.$review['rid'].'" onclick="replay('.$review['rid'].')">
                                            <span class="iconfont icon">&#xf151;</span>
                                            <span class="r_like" style="padding-left: 5px;">'.(count($comments) ? count($comments) : 0).'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </div>';
                    //回复隐藏层
                    $html .= '<div class="P_06_reply_inputbox reply_frame_' . $review['rid'] . '" style="display:none">';
                    $html .= '<input id="write_review' . $review['rid'] . '" class="big_input" type="text" name="customers_name" placeholder="' . ($_SESSION['customer_id'] ? FS_PLEASE_W_REVIEW : FS_REVIEWS_COMMENT_DEACRIPTION) . '" value="" />
                                <div class="solutions_16_btn" >';
                    if($_SESSION['customer_id']){
                        $html .= '<button class="button_1602" onclick="ajax_submit_comments(' . $review['rid'] . ',\'' . $_SESSION['customer_id'] . '\',' . $review['products_id'] . ')">' . FS_SUBMIT . '</button>';
                    }
                    $html .= '</div></div></div>';
                }else {
                    $html .= '<div class="p_06" ><dl><dt>';
                    $html .= '<span class="P_06_portrait">';
                    if ($img_src){
                        $html .= '<img src="' . $img_src . '" alt="' . $img_src . '" width="48" height="48" border="0">';
                    } else {
                        $html .= '<i style="' . $color . '" >';
                        $html .= $firstWord;
                        $html .= '</i>';
                    }
                    $html .= '</span>';
                    if ($_SESSION['languages_code'] != 'au') {
                        $country_str = '</span><div class="P_06_country">' . $review['country_name'] . '</div>';
                    } else {
                        $country_str = '<div class="P_06_country review_time" >' . $review['time'] . '</div>';
                    }
                    $html .= '<div class="P_06_name"><span>';
                    $html .= $review['name'].$country_str;

                    $html .= '</div></dt><dd>';

                    if($review['rating']){
                        $class = getRatingClass($review['rating']);
                        $html .= '<div class="P_06_star"><span class="'.$class.'"></span><i>'.$review["rating"].'.0'.'</i></div>';
                    }

                    if($_SESSION['languages_code'] == 'au'){
                        $review_time = "";
                    } else {
                        $review_time = $review['time'];
                    }
                    if($_SESSION['languages_code'] != 'au'){
                        $html .='<span class="p_06_02_pro01">'.$review_time.'</span>';
                    }
					if($review['reviews_headline']){
						$html .='<div class="P_06_headline">'. $review['reviews_headline'].'</div>';
					}
                    /*评论属性展示*/
                    $attrHtml = '';
                    if (!empty($review['modelAttr'])) {
                        foreach ($review['modelAttr'] as $attrVal) {
                            $transceiver_type_model = '';
                            if ($attrVal['transceiver_type_model']) {
                                $transceiver_type_model = $attrVal['transceiver_type_model']['products_MFG_PART'] ? $attrVal['transceiver_type_model']['products_MFG_PART'] : $attrVal['transceiver_type_model']['products_model'];
                            }
                            $attrHtml .= $attrVal['related_attribute_content'].': '.($transceiver_type_model ? $transceiver_type_model : $attrVal['attributes_relation_content']).'  |  ';
                        }
                    }
                    if ($review['equipment_mode']) {
                        $attrHtml .= FS_REVIEW_07.': '.$review['equipment_mode'];
                    } else {
                        $attrHtml = rtrim($attrHtml, '|  ');
                    }
                    $html .= '<p class="new_review_txt">'.$attrHtml.'</p>';

					$html .='<div class="P_06_content more-content-boxDem"><div class="more-content-childDem">' . $review['content'] . '</div>
                            <div class="more-content-childFilter"></div></div>';
					$html .='<div class="more-content-showBtn-box after"><div class="more-content-showBtn-main after"><div>'.FS_READ_MORE.'</div><span class="iconfont icon">&#xf087;</span></div></div>';

					if(sizeof($review['reviewsInfo'])){
                        $html .=  '<div class="review_pic"><ul>';
                        foreach ($review['reviewsInfo'] as $kk => $img) {
                            if($img['is_v_tag_type'] == 1){
                                $imgPath = HTTPS_IMAGE_SERVER;
                            }else{
                                $imgPath = HTTPS_IMAGE_SERVER . 'images/reviews/';
                            }
                            if ($img['reviews_image_thumb']) {
                                $html.= '<li class="detail_click_pic" data-rid="'.$review['rid'].'" data-imgid="'.$img['reviews_image_id'].'"><a data-width="' . $img['reviews_image_thumb'][1]['size_w'] .'" data-height="'. $img['reviews_image_thumb'][1]['size_h']. '"  data-img="' . $imgPath.$img['reviews_image_thumb'][0]['reviews_image_tb'] . '" href="javascript:void(0)"><img src="' . $imgPath.$img['reviews_image_thumb'][0]['reviews_image_tb'] . '"></a></li>';
                            } else {
                                $html.= '<li class="detail_click_pic" data-rid="'.$review['rid'].'" data-imgid="'.$img['reviews_image_id'].'"><a data-width="' . $img['size_w'] .'" data-height="'. $img['size_h']. '"  data-img="' . $imgPath.$img['reviews_image'] . '" href="javascript:void(0)"><img src="' . $imgPath.$img['reviews_image'] . '"  width="100" height="100"/></a></li>';
                            }
                        }
                        $html .=  '</ul></div>';
                    }

                    /*if ($is_true_customer != null) {
                        if (get_customers_verified_purchase($review['customersid'], $review['products_id'])) {
                            $html .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                        }
                    } elseif ($virtual_is_buy == 1) {
                        $html .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';
                    }*/
                    $html .= '<div class="P_06_authentication"><i class="iconfont icon">&#xf186;</i>' . FS_VERIFIED_PUR . '</div>';

                    //评论回复
                    $html .= '<div id="reply_set_' . $review['rid'] . '">';
                    if ($comment_num) {
                        $html .= '<div class="pro_hf pro_hf_002">';
                        $html .= '<h2 class="p_reply_h2">' . FS_REVIEWS31 . ' ' . $comment_num . ' ' . ($comment_num > 1 ? FS_REVIEWS36 : FS_REVIEWS32) . '</h2>';
                        if($review['reviewsComment']) {
                            foreach ($review['reviewsComment'] as $key => $comment) {
                                $created_by =  FS_BY . '&nbsp;' . $comment['customers_name'];
                                if($_SESSION['languages_code'] =='jp'){
                                    $created_by = $comment['customers_name'].FS_BY;
                                }
                                $html .= '<p class="p_question_tit">' . $comment['comments_content'] . '<em class="pro_wei01">' . $created_by . '</em></p>';
                            }
                        }
                        $html .= '</div>';
                    }
                    $html .= '</div>';

                    $html .= '<div class="p_06_02_problem after">';

                    $html .= '<a  tag="show_or_hide"  id="like_num_of_replys_'. $review['rid'].'" href="javascript:;"></a>';
                    $html .='<a class="p_06_10  pro_a_one" href="javascript:reviews_like_or_not001('. $review['rid'].',1,\'\');" id="reply_like_'. $review['rid'].'" >';
                    $html .='<span class="iconfont icon">&#xf173;</span><span class="new_reviews_like">';
                    $html .=$r_like;
                    $html .='</span>';
                    $html .='</a>';
                    $html .='<span class="p_06_02_pro02" id="new_comment_'.$review['rid'].'"><a class="pro_a_only" href="javascript:click_down(' . $review['rid'] . ',\'' . $_SESSION["customer_id"] . '\');">';
                    $html .='<span class="iconfont icon">&#xf151;</span><span class="new_reviews_comment">';
                    $html .=($comment_num ? $comment_num : 0).'</span></a></span>';
                    $html .='<input type="hidden" class="pro_report_'.$review['rid'].'" value="0">';
                    $html .='</div>';

					$html .='<div class="P_06_reply_inputbox" id="reply_frame_'. $review['rid'].'" style="display:none">';
					$html .='<input id="write_review'. $review['rid'].'" class="big_input" type="text" name="customers_name" placeholder="'.($_SESSION['customer_id'] ? FS_PLEASE_W_REVIEW : FS_REVIEWS_COMMENT_DEACRIPTION).'" value="" />
    						<div class="solutions_16_btn" >';
                    if($_SESSION['customer_id']){
                        $html .= '<button class="button_1602" onclick="ajax_submit_comments(' . $review['rid'] . ',' . $review['products_id'] . ')">' . FS_SUBMIT . '</button>';
                    }
                    $html .= '</div></div>';
                    $html .= '</dd>
						</dl>
					   </div>';
                }
			}
			$html .='</div>';

            if($is_img){ //如果筛选为图片分页
                $type = 1;
                if ($pic_star_num > 0) {
                    $total_page = ceil(($pic_star_num/10));
                }
            }else{
                $type = 2;
                $total_page = ceil(($total_num/10));
            }
            $html.=getReviewPage($id,$total_page,$page,$type,$review_star,false,$is_img);
		} 
		
		exit(json_encode(array('html'=>$html,'pic_star_num'=>$pic_star_num)));
		break;
		
		case 'comments_page_update':
			$reviews_id = $_POST['id'];
			$comments = $fs_reviews->get_all_reviews_of_reply($reviews_id);
			$comments_num = sizeof($comments);
			$page_comments = $fs_reviews->get_page_reviews_of_reply($reviews_id,$_POST['page']);
			$total_num = sizeof($page_comments);
			$base_num = $_POST['page'];
			$html='';
			if($total_num<=10){				
				$html .= '<div class="">'.FS_REVIEWS31.' '. (($base_num-1)*10+1).'-'. (($base_num-1)*10+$total_num).'&nbsp;of&nbsp;'.$comments_num.' posts in this discussion.</div>';
			}else{
				$html .= '<div class="">'.FS_REVIEWS31.' '. (($base_num-1)*10+1).'-'. ($base_num*10).'&nbsp;of&nbsp;'.$comments_num.' posts in this discussion.</div>';
			}
			$html .='<div id="" class="contact_cgts_01" style="display: none; ">'. FS_DELETE_SUCESS.'</div>';
			$html .='<div class="p_06_reply_content" >';
			
			if($page_comments){
				foreach($page_comments as $key=>$val) {
					$comments_count = $fs_reviews->get_comments_is_like_count($val['id']);
					$r_like = $comments_count['r_like'] ? $comments_count['r_like'] : (0);
					$says_image = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$val['cid'].'"','');	
					$says_src =  DIR_WS_IMAGES. (($says_image) ? $says_image : 'portrait_pic.jpg');
					$comments_count = $fs_reviews->get_comments_is_like_count($val['id']);
					$c_like = $comments_count['r_like'] ? $comments_count['r_like'] : 0;
					$c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;
					$html .='<span class="p_06_reply_sub" ';
					$html .='<div id="reply_frame_'. $val['id'].'" class="p_06_reply_con" style="display:none;">';
        
		            $html .= zen_draw_form('reply_form', zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.(int)$reviews_id),'POST',' id="reply_form" enctype="multipart/form-data" ').
					zen_draw_hidden_field('from',$_GET['from']).zen_draw_hidden_field('comments_id',(int)$val['id']).
					zen_draw_hidden_field('reviews_id',(int)$reviews_id);
      
					$html .='<div class="p_06_top15">
							  <textarea id="reply_question" class="login_014" name="reply_question" cols="" rows="" >'. $val['comments'].'</textarea>
					
							  </div>
								<div class="p_06_top15">
								  <input id="Submit_Reply" value="Submit" type="submit" class="button_1602" name="fs_reply_submit" />';
					$html .='&nbsp;&nbsp;<span class="button_1601" onclick="click_cancel('. $val['id'].')">'. FS_CANCEL.'</span>
								</div>
						  </div>
						</form>
					  </div>';
				}
			}
			$html .='</div>';
			echo $html;
			exit;
		break;

		case 'del_review':		//删除评论
			if(isset($_POST['data1']) && !empty($_POST['data1']) && !empty($_POST['data2'])){
				$comments_id = (int)$_POST['data1'];
				$review_id = (int)$_POST['data2'];
				$user_id = $_SESSION['customer_id'];
				$language_id = $_SESSION['languages_id'];
				$sql = "delete from `reviews_comments` where reviews_id = ".$review_id." and comments_id = ".$comments_id;
				$sql2 ="delete from `reviews_comments_description` where comments_id = ".$comments_id ." and customers_id = ".$user_id." and language_id = ".$language_id;
				$sql3 ="select comments_id from `reviews_comments` where reviews_id=".$review_id;
				$res=$db->Execute($sql);
				$res2=$db->Execute($sql2);
				$res3=$db->Execute($sql3);

				if(!$res3->EOF){
				        $fssays = get_comments_of_review($review_id);
						if(isset($fssays) && $fssays){
						$html = '';
					    	foreach($fssays as $key=> $says){
					    	 $says_image = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$says['cus_id'].'"','');

					    	 $says_src =  DIR_WS_IMAGES. (($says_image) ? $says_image : 'portrait_pic.jpg');
					    	 $finalsrc =  (($says['cus_id']!='') ? $says_src : DIR_WS_IMAGES.'portrait_pic09.jpg');

					    	 $comments_count = $fs_reviews->get_comments_is_like_count($says['cid']);
					    	 $c_like = $comments_count['r_like'] ? $comments_count['r_like'] : 0;
							 $c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;
					     }
					}
					echo $html;
				}else{
				    echo '';
				}


			}



		break;
		
		case 'del_comments':		//删除评论
			if(isset($_POST['data1']) && !empty($_POST['data1']) && !empty($_POST['data2'])){
				$comments_id = (int)$_POST['data1'];
				$review_id = (int)$_POST['data2'];
				$user_id = $_SESSION['customer_id'];
				$language_id = $_SESSION['languages_id'];
				$sql = "delete from `reviews_comments` where reviews_id = ".$review_id." and comments_id = ".$comments_id;
				$sql2 ="delete from `reviews_comments_description` where comments_id = ".$comments_id ." and customers_id = ".$user_id." and language_id = ".$language_id;
				$res=$db->Execute($sql);
				$res2=$db->Execute($sql2);
				if($res && $res2){
				echo json_encode('Delete Success');
				}else{
				echo json_encode('Delete failed');
				}
			}
				break;
		
		case 'set_review':	
		   	$num = 0;
			if(isset($_POST['data']) && !empty($_POST['data']) && !empty($_POST['reviews_id']) && !empty($_SESSION['customer_id'])){
				$review_content = strip_tags($_POST['data']);
				$review_content = zen_db_prepare_input($review_content);
                $review_content = stripslashes($review_content);
				$reviews_id = (int)$_POST['reviews_id'];
				$products_id = (int)$_POST['products_id'];//当前评论所属产品ID
                $pid = (int)$_POST['pid'];//当前缓存所属产品ID
				$user_id = (int)$_SESSION['customer_id'];
				$stuff_email = explode('@',$_SESSION['customers_email_address']);

				$reviews_data = array(
					'reviews_id' => $reviews_id,
					'products_id' =>$products_id,
					'status' => 0,
			        'is_fiberstore' =>0,
			        'date_added' => 'now()',
					'last_modified' => 'now()',
			        'rpid'=>0,
					);
				zen_db_perform(TABLE_REVIEWS_COMMENTS, $reviews_data);
				$comments_id = $db->insert_ID();
				$reviews_data = array(
						'comments_id'=>$comments_id,
				        'customers_id' => $user_id,
						'customers_name' => trim(fs_get_data_from_db_fields('customers_firstname','customers','customers_id="'.$user_id.'"','')),
						'language_id' => (int)$_SESSION['languages_id'],
						'comments_content' => $review_content,
						
						);
			
				zen_db_perform(TABLE_REVIEWS_COMMENTS_DESCRIPTION, $reviews_data);

                $comment_count = sizeof($fs_reviews->get_all_reviews_of_reply($reviews_id));
				$fssays = get_comments_of_review($reviews_id);
                $html = '';
                $html .='<div class="pro_hf pro_hf_002">';
				if(isset($fssays) && $fssays){
                    if(sizeof($comment_count)){
                        if($comment_count == 1){
                            $html .='<h2 class="p_reply_h2">'.FS_REVIEWS31.' '.$comment_count.' '.FS_REVIEWS32.'</h2>';
                        }else{
                            $html .='<h2 class="p_reply_h2">'.FS_REVIEWS31.' '.$comment_count.' '.FS_REVIEWS36.'</h2>';
                        }
                    }
			    	foreach($fssays as $key=> $says){
			    	 $says_image = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$says['cus_id'].'"','');	
			    	 
			    	 $says_src =  DIR_WS_IMAGES. (($says_image) ? $says_image : 'portrait_pic.jpg');
			    	 $finalsrc =  (($says['cus_id']!='') ? $says_src : DIR_WS_IMAGES.'portrait_pic09.jpg');
			    	 
			    	 $comments_count = $fs_reviews->get_comments_is_like_count($says['cid']);
			    	 $c_like = $comments_count['r_like'] ? $comments_count['r_like'] : 0;
				     $c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;
                    $html .='<p class="p_question_tit">'.$says['content'].'<em class="pro_wei01">'.FS_BY.'&nbsp;'.$says['name'].'</em></p>';
			     }
			}
                $html .='</div>';
		}

        exit(json_encode(array('html'=>$html,'num'=>$comment_count)));
			
		break;  
        }
  
  
  }
