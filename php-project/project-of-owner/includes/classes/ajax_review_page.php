<?php

  if(isset($_GET['request_type'])){

	  require 'includes/application_top.php';
	  require DIR_WS_CLASSES . 'fs_reviews.php';
				$fs_reviews = new fs_reviews();
				
  function get_comments_of_review($rid){
				global $db;
					$comments = array();
					$comments_sql = "select r.comments_id,r.last_modified from " . TABLE_REVIEWS_COMMENTS .
					" AS r left join ".TABLE_REVIEWS_COMMENTS_DESCRIPTION." as rd using(comments_id)  WHERE  r.reviews_id = :rid
					  AND rd.language_id=".(int)$_SESSION['languages_id']."	
					  AND r.status =1
					  ORDER BY r.is_fiberstore desc,r.date_added desc limit 3
						";
					
					$comments_sql = $db->bindVars($comments_sql, ':rid', (int)$rid, 'integer');
					//$comments_sql = $db->bindVars($comments_sql, ':products_id', (int)$products_id, 'integer');
					$get_comments = $db->Execute($comments_sql);
					if ($get_comments->RecordCount()){
						while(!$get_comments->EOF){
						$comments[] = array(
								'cid' => $get_comments->fields['comments_id'],
								'cus_id'=> fs_get_data_from_db_fields('customers_id',TABLE_REVIEWS_COMMENTS_DESCRIPTION,'comments_id='.$get_comments->fields['comments_id'],' limit 1'),
								'name'=> fs_get_data_from_db_fields('customers_name',TABLE_REVIEWS_COMMENTS_DESCRIPTION,'comments_id='.$get_comments->fields['comments_id'],' limit 1'),
								'content'=>fs_get_data_from_db_fields('comments_content',TABLE_REVIEWS_COMMENTS_DESCRIPTION,'comments_id='.$get_comments->fields['comments_id'],' limit 1'),
								'time'=>date('F j,Y',strtotime($get_comments->fields['last_modified'])),
						);
						$get_comments->MoveNext();
						}
						
					}
					return $comments;
				}
		switch($_GET['request_type']){
			case 'page_update':
				
				$page_reviews = $fs_reviews->get_page_reviews_of_product($_POST['id'],$_POST['page'],'');
				
				$content_of_reviews = sizeof($page_reviews);
				
                $content ='';
				   if ($content_of_reviews){
                		$js_for_replys = '';
                		foreach ($page_reviews as  $ii => $review ){
                		
                		//获取图片
                        $reviewsSQL=$db->Execute("select reviews_image from reviews_image where reviews_id =".$review['rid']." and products_id =".(int)$_POST['id']);
     					$products_review_img = array();
					    if($reviewsSQL->RecordCount()){
					     while(!$reviewsSQL->EOF){
					      $products_review_img []= $reviewsSQL->fields['reviews_image'];
					      $reviewsSQL->MoveNext();
					     }
					    }
			
						$js_for_replys .= '#num_of_replys_'.$review['rid'].',';
						$num_of_comments = sizeof($review['comments']);
						
						$reviews_count = $fs_reviews->get_review_is_like_count($review['rid']);
						$r_like = $reviews_count['r_like'] ? $reviews_count['r_like'] : 0;
						$r_bad  = $reviews_count['r_bad'] ? $reviews_count['r_bad'] : 0;
						
						$fssays = $fs_reviews->get_comments_of_review($review['rid'],$_POST['id']);
						
						
						
						$is_true_customer = fs_get_data_from_db_fields('customers_id','reviews','reviews_id="'.$review['rid'].'"','');
						$virtual_customer = trim(fs_get_data_from_db_fields('customers_name','reviews_virtual_customer','id="'.$review['vcustomersid'].'"',''));
			          	$virtual_photo = fs_get_data_from_db_fields('portrait','reviews_virtual_customer','id="'.$review['vcustomersid'].'"','');
			          	$virtual_contury = fs_get_data_from_db_fields('cus_contury','reviews_virtual_customer','id="'.$review['vcustomersid'].'"','');
			          	$virtual_is_buy = fs_get_data_from_db_fields('is_buy','reviews_virtual_customer','id="'.$review['vcustomersid'].'"','');
			          	
                		if($is_true_customer!=null){
                		$customerImageSrc = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$review['customersid'].'"','');
							  $img_src =  DIR_WS_IMAGES. (($customerImageSrc) ? $customerImageSrc : 'portrait_pic.jpg');
							}else{
							  $img_src =  DIR_WS_IMAGES. (($virtual_photo) ? $virtual_photo : 'portrait_pic.jpg');
				          	}
			          	
			            $cus_name =fs_get_data_from_db_fields('customers_firstname','customers','customers_id="'.$review['customersid'].'"','').' '.fs_get_data_from_db_fields('customers_lastname','customers','customers_id="'.$review['customersid'].'"','');
                        $cus_contry = zen_get_country_name(fs_get_data_from_db_fields('customer_country_id','customers','customers_id="'.$review['customersid'].'"',''));
                        $nickname = fs_get_data_from_db_fields('customers_name','reviews','reviews_id="'.$review['rid'].'"','');
          $content .='<div class="p_06" id="now_review_page"><dl><dt>';
          $content .='<span class="P_06_portrait"><img src='. $img_src.' alt='. $img_src.' width="48" height="48" border="0"></span>';
          if($is_true_customer!=null){
          	if($nickname){
          	$content .='<div class="P_06_name">'.$nickname.'</div>';
          	}else{
          	$content .='<div class="P_06_name">'.$cus_name.'</div>';
          	}
         
          }else{
          $content .='<div class="P_06_name">'.$virtual_customer.'</div>';}
          if($is_true_customer!=null && $cus_contry){
          	 $content .='<div class="P_06_country">'.$cus_contry.'</div>';
          }elseif($virtual_contury){
			 $content .='<div class="P_06_country">'.$virtual_contury.'</div>';}
          if($is_true_customer!=null){
		  if(get_customers_verified_purchase($review['customersid'],$_POST['id'])){   
           $content .='<div class="P_06_authentication"><i class="authentication_icon"></i>Verified Purchase</div>';
		  }}elseif($virtual_is_buy==1){
		   $content .='<div class="P_06_authentication"><i class="authentication_icon"></i>Verified Purchase</div>';
		  }
          $content .='</dt><dd>';
         if($review['rating']==5){ 
         $content .='<div class="P_06_star"><span class="p_star01"></span><i>'.$review["rating"].'.0'.'</i></div>';} 
         if($review['rating']==4){
         	$content .='<div class="P_06_star"><span class="p_star02"></span><i>'.$review["rating"].'.0'.'</i></div>';
         }
         if($review['rating']==3){$content .='<div class="P_06_star"><span class="p_star03"></span><i>'.$review["rating"].'.0'.'</i></div>'
         ;}
         if($review['rating']==2){$content .='<div class="P_06_star"><span class="p_star04"></span><i>'.$review["rating"].'.0'.'</i></div>'
         ;}
         if($review['rating']==1){$content .='<div class="P_06_star"><span class="p_star05"></span><i>'.$review["rating"].'.0'.'</i></div>'
         ;}
         if($review['reviews_headline']){
         $content .='<div class="P_06_headline"><a href="'.zen_href_link(FILENAME_COMMENTS_REVIEW,'rid='.$review['rid']).'">'. $review['reviews_headline'].'</a></div>';
         }
         $content.='<div class="P_06_content">'.$review['content'].'</div>';

        if(sizeof($products_review_img)){
		    $content .=  '<div class="review_pic"><ul>';
		    for($rpi=0;$rpi<sizeof($products_review_img);$rpi++){
		     $img_src =  DIR_WS_IMAGES.'reviews/'. (file_exists(DIR_WS_IMAGES.'reviews/'.$products_review_img[$rpi]) ? $products_review_img[$rpi] : 'no_picture.gif');
             $image = zen_image($img_src,'',100,100,' border="0" ');
			   $content .= '<li><a href="javascript:void($(\'#fs_overlays_reviews,#basic-modal-content_reviews_'.$review['rid'].$rpi.'\').show())">'.$image.'</a></li>';
		     }
		    $content .=  '</ul></div><div style="display: none;" id="fs_overlays_reviews" class="ui-overlay"><div class="ui-widget-overlay" style="opacity:0.3;"></div></div>';
		     for($rpii=0;$rpii<sizeof($products_review_img);$rpii++){
		$img_src =  DIR_WS_IMAGES.'reviews/'. (file_exists(DIR_WS_IMAGES.'reviews/'.$products_review_img[$rpii]) ? $products_review_img[$rpii] : 'no_picture.gif');
        $image = zen_image($img_src,'',500,500,' border="0" ');
        	 $content .= '<div id="basic-modal-content_reviews_'.$review['rid'].$rpii.'" class="ui-widget ui-widget-content ui-corner-all ui-corner_pop_large" style="display:none;">
		<div class="content_reviews_pic"><span>'.$image.'</span></div>
		<button id="pic_fot_prev" class="n_prev reviews_btn disabled n_reviews_prev" onclick="pre_pic('.$review['rid'].$rpii.')" >上一张</button>
		<button id="pic_fot_next" class="n_next reviews_btn n_reviews_next" onclick="next_pic('.$review['rid'].$rpii.')" >下一张</button>
		<div class="reviews_close"><a href="javascript:;" onclick="$(\'#fs_overlays_reviews,#basic-modal-content_reviews_'.$review['rid'].$rpii.'\').hide();"></a></div></div>';
		     }
		    } 
		  
		    		
//		 $content .= '<div class="ccc"></div>';
//		 if(get_customers_buy_attributes($review['customersid'],$_POST['id'])){
//		 $content .= '<div class="P_06_dom">'. get_customers_buy_attributes($review['customersid'],$_POST['id']).'</div>';
//		 }
		 $content .='<div class="P_06_fscon" style="display: none;"><font class="red">[ Official Reply ]I am ok</font></div>';

		 $content .='<div class="p_06_02_problem">';
         $content .='<span class="p_06_02_pro02"><a href="javascript:click_down('. $review['rid'].');"><i class="solutions_icon s_icon01"></i>';
         
                		
         $content .='&nbsp;'. FS_REVIEWS11.'</a></span>';
         $content .='<span class="p_06_02_pro02"><a href="javascript:void(0);" onclick="share_to('. $review['rid'].')"><i class="solutions_icon s_icon03"></i>'. FS_REVIEWS10.'</a></span>';
	     $content .= '<a  tag="show_or_hide"  id="like_num_of_replys_'. $review['rid'].'" href="javascript:;"></a>';
		 $content .='<a class="p_06_10" href="javascript:reviews_like_or_not('. $review['rid'].',1,\'\');" id="reply_like_'. $review['rid'].'" >'.$r_like.'</a>'; 
		 $content .='<a class="p_06_11" href="javascript:reviews_like_or_not('. $review['rid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_not_'. $review['rid'].'" >'.$r_bad.'</a>';
		
         $content .='<span class="p_06_02_pro01">';
         if ($review['time']){
         $content .=$review['time'];}else{ 
         $content .='';
         }
         $content .='</span>
	</div>';
    
      	 $content .='<div class="P_06_reply_inputbox" id="reply_frame_'. $review['rid'].'" style="display:none">';
         $content .='<input id="write_review'. $review['rid'].'" class="big_input" type="text" name="customers_name" placeholder="Write down your comments..." value="" />
        <div class="solutions_16_btn" >';
		 $content .='<button class="button_1602" onclick="ajax_submit_comments('. $review['rid'].',\''. $_SESSION['customer_id'].'\','. $_POST['id'].')">'. FS_SUBMIT.'</button>';
		 $content .='<button class="button_1601" data-key="" onclick="click_cancel('. $review['rid'].')">'. FS_CANCEL.'</button>
		</div>
      </div>';
         $content .='<div id="reply_set'. $review['rid'].'">';
     if(isset($fssays) && $fssays){
    	foreach($fssays as $key=> $says){
    	 $says_image = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$says['cus_id'].'"','');	
    	 $says_src =  DIR_WS_IMAGES. (($says_image) ? $says_image : 'portrait_pic.jpg');
    	 $finalsrc =  (($says['cus_id']!='') ? $says_src : DIR_WS_IMAGES.'portrait_pic09.jpg');
    	 $comments_count = $fs_reviews->get_comments_is_like_count($says['cid']);
    	 $c_like = $comments_count['r_like'] ? $comments_count['r_like'] : (0);
		 $c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;				
    	
    	
    	$content .='<div class="P_06_reply" id="del_review_'. (int)$says['cid'].'">
        <div class="P_06_reply_icon"><img src="'. $finalsrc.'" alt="'. $finalsrc.'" width="28" height="28" border="0"></div>
	    <div class="P_06_reply_con">';
		$content .='<span class="P_06_reply_text">'. $says['content'].'</span>
        <span class="P_06_reply_name">by&nbsp;'. $says['name'].'</span>';
        $content .='<a tag="show_or_hide" id="like_num_of_replys_'. $says['cid'].'" href="javascript:;"></a>';
    	if($says['cus_id']==''){
			     $content .='<a class="p_06_10" href="javascript:comments_like_or_not('. $says['cid'].',1,\'\');" id="reply_like_'. $says['cid'].'" >'.  $c_like .'</a>'; 
			     $content .='<a class="p_06_11" href="javascript:comments_like_or_not('. $says['cid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_not_'. $says['cid'].'" >'.  $c_bad .'</a>';
			        		}
         if($says['cus_id']==$_SESSION['customer_id'] && $_SESSION['customer_id']!=''){
		$content .='<a href="javascript:void(0)" class="solutions_icon_h" onclick="del_review('. (int)$says['cid'].','. (int)$review['rid'].');"><i class="solutions_icon s_icon08"></i>'. FIBERSTORE_DELETE.'</a>';
		 }
        $content .='</div>
    </div>';
     }
    if(sizeof($fs_reviews->get_all_reviews_of_reply($review['rid'],''))>=3){
    	$content .='<div class="P_06_reply_more"><a href="'. zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$review['rid']).'">View all ';
    	 if($fs_reviews->get_all_reviews_of_reply($review['rid'],'')){
    	 $content .= sizeof($fs_reviews->get_all_reviews_of_reply($review['rid'],''));
    	 }else{
    	 $content .= '';
    	 }
    	 $content .= ' Replies<i class="arrow"></i></a></div>';
    
     }} 
    
    	 $content .='<div class="P_06_see_more "></div>';
		 $content .='</dd>
		    </dl>
		   </div>';
		   }  
		}
		$content .='</div>';
		echo $content;
          exit; 
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
					 $title=(strlen($v['title'])>50)?substr($v['title'],0,50).'...':$v['title'];
					 $seo_descriptiom =(strlen($description)>120) ? (mb_substr($description,0,120,'utf-8').'...') : $description;
					 $image = $v['image'];
					 $seo_href = zen_href_link('support_detail','&supportid='.$v['id']);
				
				 $solhtml.= '<li ><a target="_blank" href="'.$seo_href.'"><div class="product_index_con01_pic">
				 
				 <img width="285px" height="165px" src="images/'.$image.'" alt="'.$title.'"><div class="white_shadow"></div></div>';
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
				$reviews_result=$fs_reviews->get_reviews_image_of_products($id);
				$reviews_image='';
				foreach($reviews_result as $v){
					$reviews_image .=$v['id'].',';
				}
				
				$res = " and r.reviews_id in (".substr($reviews_image,0,-1).")";
				$page_reviews = $fs_reviews->get_page_reviews_of_product($_POST['id'],$_POST['page'],$res);
				$html ='';
				$content_of_reviews = sizeof($page_reviews);
				   if ($content_of_reviews){
                		$js_for_replys = '';
                		foreach ($page_reviews as  $ii => $review ){
                		//获取图片
                        $reviewsSQL=$db->Execute("select reviews_image from reviews_image where reviews_id =".$review['rid']." and products_id =".$id);
     					$products_review_img = array();
					    if($reviewsSQL->RecordCount()){
					     while(!$reviewsSQL->EOF){
					      $products_review_img []= $reviewsSQL->fields['reviews_image'];
					      $reviewsSQL->MoveNext();
					     }
					    }
			
						$js_for_replys .= '#num_of_replys_'.$review['rid'].',';
						$num_of_comments = sizeof($review['comments']);
						
						$reviews_count = $fs_reviews->get_review_is_like_count($review['rid']);
						$r_like = $reviews_count['r_like'] ? $reviews_count['r_like'] : 0;
						$r_bad  = $reviews_count['r_bad'] ? $reviews_count['r_bad'] : 0;
						
						$fssays = $fs_reviews->get_comments_of_review($review['rid'],$_POST['id']);
						 
						
						$is_true_customer = fs_get_data_from_db_fields('customers_id','reviews','reviews_id="'.$review['rid'].'"','');
			          	$virtual_customer = trim(fs_get_data_from_db_fields('customers_name','reviews_virtual_customer','id="'.$review['vcustomersid'].'"',''));
			          	$virtual_photo = fs_get_data_from_db_fields('portrait','reviews_virtual_customer','id="'.$review['vcustomersid'].'"','');
			          	$virtual_contury = fs_get_data_from_db_fields('cus_contury','reviews_virtual_customer','id="'.$review['vcustomersid'].'"','');
						$virtual_is_buy = fs_get_data_from_db_fields('is_buy','reviews_virtual_customer','id="'.$review['vcustomersid'].'"','');
                		if($is_true_customer!=null){
                			$customerImageSrc = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$review['customersid'].'"','');
							$img_src =  DIR_WS_IMAGES. (($customerImageSrc) ? $customerImageSrc : 'portrait_pic.jpg');
							}else{
							  $img_src =  DIR_WS_IMAGES. (($virtual_photo) ? $virtual_photo : 'portrait_pic.jpg');
				          	}
			            $cus_name =fs_get_data_from_db_fields('customers_firstname','customers','customers_id="'.$review['customersid'].'"','').' '.fs_get_data_from_db_fields('customers_lastname','customers','customers_id="'.$review['customersid'].'"','');
                        $cus_contry = zen_get_country_name(fs_get_data_from_db_fields('customer_country_id','customers','customers_id="'.$review['customersid'].'"',''));
                        $nickname = fs_get_data_from_db_fields('customers_name','reviews','reviews_id="'.$review['rid'].'"','');
             if(sizeof($products_review_img)){ 
          $html .='<div class="p_06" id="now_review_page"><dl><dt>';
          $html .='<span class="P_06_portrait"><img src='. $img_src.' alt='. $img_src.' width="48" height="48" border="0"></span>';
          if($is_true_customer!=null){
           if($nickname){
             $html .='<div class="P_06_name">'.$nickname.'</div>';
           }else{
             $html .='<div class="P_06_name">'.$cus_name.'</div>';}
          }else{
          $html .='<div class="P_06_name">'.$virtual_customer.'</div>';}
           if($is_true_customer!=null && $cus_contry){
          	 $html .='<div class="P_06_country">'.$cus_contry.'</div>';
          }elseif($virtual_contury){
			 $html .='<div class="P_06_country">'.$virtual_contury.'</div>';}
          if($is_true_customer!=null){
		  if(get_customers_verified_purchase($review['customersid'],$_POST['id'])){   
           $html .='<div class="P_06_authentication"><i class="authentication_icon"></i>Verified Purchase</div>';
		  }}elseif($virtual_is_buy==1){
		   $html .='<div class="P_06_authentication"><i class="authentication_icon"></i>Verified Purchase</div>';
		  }
          $html .='</dt><dd>';
         if($review['rating']==5){ 
         $html .='<div class="P_06_star"><span class="p_star01"></span><i>'.$review["rating"].'.0'.'</i></div>';} 
         if($review['rating']==4){
         	$html .='<div class="P_06_star"><span class="p_star02"></span><i>'.$review["rating"].'.0'.'</i></div>';
         }
         if($review['rating']==3){$html .='<div class="P_06_star"><span class="p_star03"></span><i>'.$review["rating"].'.0'.'</i></div>'
         ;}
         if($review['rating']==2){$html .='<div class="P_06_star"><span class="p_star04"></span><i>'.$review["rating"].'.0'.'</i></div>'
         ;}
         if($review['rating']==1){$html .='<div class="P_06_star"><span class="p_star05"></span><i>'.$review["rating"].'.0'.'</i></div>'
         ;}
         if($review['reviews_headline']){
         $html .='<div class="P_06_headline"><a href="'.zen_href_link(FILENAME_COMMENTS_REVIEW,'rid='.$review['rid']).'">'. $review['reviews_headline'].'</a></div>';
         }
         $html.='<div class="P_06_content">'.$review['content'].'</div>';

       if(sizeof($products_review_img)){
		    $html .=  '<div class="review_pic"><ul>';
		    for($rpi=0;$rpi<sizeof($products_review_img);$rpi++){
		    	$img_src =  DIR_WS_IMAGES.'reviews/'. (file_exists(DIR_WS_IMAGES.'reviews/'.$products_review_img[$rpi]) ? $products_review_img[$rpi] : 'no_picture.gif');
                $image = zen_image($img_src,'',100,100,' border="0" ');
			   $html .= '<li><a href="javascript:void($(\'#fs_overlays_reviews,#basic-modal-content_reviews_'.$review['rid'].$rpi.'\').show())">'.$image.'</a></li>';
		     }
		    $html .=  '</ul></div><div style="display: none;" id="fs_overlays_reviews" class="ui-overlay"><div class="ui-widget-overlay" style="opacity:0.3;"></div></div>';
		     for($rpii=0;$rpii<sizeof($products_review_img);$rpii++){
		$img_src =  DIR_WS_IMAGES.'reviews/'. (file_exists(DIR_WS_IMAGES.'reviews/'.$products_review_img[$rpii]) ? $products_review_img[$rpii] : 'no_picture.gif');
        $image = zen_image($img_src,'',500,500,' border="0" ');
        	 $html .= '<div id="basic-modal-content_reviews_'.$review['rid'].$rpii.'" class="ui-widget ui-widget-content ui-corner-all ui-corner_pop_large" style="display:none;">
		<div class="content_reviews_pic"><span>'.$image.'</span></div>
		<button id="pic_fot_prev" class="n_prev reviews_btn disabled n_reviews_prev" onclick="pre_pic('.$review['rid'].$rpii.')" >上一张</button>
		<button id="pic_fot_next" class="n_next reviews_btn n_reviews_next" onclick="next_pic('.$review['rid'].$rpii.')" >下一张</button>
		<div class="reviews_close"><a href="javascript:;" onclick="$(\'#fs_overlays_reviews,#basic-modal-content_reviews_'.$review['rid'].$rpii.'\').hide();"></a></div></div>';
		     }
		    } 
		    
		    		
//		 $html .= '<div class="ccc"></div>';
//         if(get_customers_buy_attributes($review['customersid'],$_POST['id'])){
//		 $html .= '<div class="P_06_dom">'. get_customers_buy_attributes($review['customersid'],$_POST['id']).'</div>';
//		 }
		 $html .='<div class="P_06_fscon" style="display: none;"><font class="red">[ Official Reply ]I am ok</font></div>';

		 $html .='<div class="p_06_02_problem">';
         $html .='<span class="p_06_02_pro02"><a href="javascript:click_down('. $review['rid'].');"><i class="solutions_icon s_icon01"></i>';
         
                		
         $html .='&nbsp;'. FS_REVIEWS11.'</a></span>';
         $html .='<span class="p_06_02_pro02"><a href="javascript:void(0);" onclick="share_to('. $review['rid'].')"><i class="solutions_icon s_icon03"></i>'. FS_REVIEWS10.'</a></span>';
	     $html .= '<a  tag="show_or_hide"  id="like_num_of_replys_'. $review['rid'].'" href="javascript:;"></a>';
		 $html .='<a class="p_06_10" href="javascript:reviews_like_or_not('. $review['rid'].',1,\'\');" id="reply_like_'. $review['rid'].'" >'.$r_like.'</a>'; 
		 $html .='<a class="p_06_11" href="javascript:reviews_like_or_not('. $review['rid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_not_'. $review['rid'].'" >'.$r_bad.'</a>';
         $html .='<span class="p_06_02_pro01">';
         if ($review['time']){
         $html .=$review['time'];}else{ 
         $html .='';
         }
         $html .='</span>
	</div>';
    
      	 $html .='<div class="P_06_reply_inputbox" id="reply_frame_'. $review['rid'].'" style="display:none">';
         $html .='<input id="write_review'. $review['rid'].'" class="big_input" type="text" name="customers_name" placeholder="Write down your comments..." value="" />
        <div class="solutions_16_btn" >';
		 $html .='<button class="button_1602" onclick="ajax_submit_comments('. $review['rid'].','. $_SESSION['customer_id'].','. $_POST['id'].')">'. FS_SUBMIT.'</button>';
		 $html .='<button class="button_1601" data-key="" onclick="click_cancel('. $review['rid'].')">'. FS_CANCEL.'</button>
		</div>
      </div>';
    	 $html .='<div id="reply_set'. $review['rid'].'">';
     if(isset($fssays) && $fssays){
    	foreach($fssays as $key=> $says){
    	 $says_image = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$says['cus_id'].'"','');	
    	 $says_src =  DIR_WS_IMAGES. (($says_image) ? $says_image : 'portrait_pic.jpg');
    	 $finalsrc =  (($says['cus_id']!='') ? $says_src : DIR_WS_IMAGES.'portrait_pic09.jpg');
    	 $comments_count = $fs_reviews->get_comments_is_like_count($says['cid']);
    	 $c_like = $comments_count['r_like'] ? $comments_count['r_like'] : 0;
		 $c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;				
    	
    	
    	$html .='<div class="P_06_reply" id="del_review_'. (int)$says['cid'].'">
        <div class="P_06_reply_icon"><img src="'. $finalsrc.'" alt="'. $finalsrc.'" width="28" height="28" border="0"></div>
	    <div class="P_06_reply_con">';
		$html .='<span class="P_06_reply_text">'. $says['content'].'</span>
        <span class="P_06_reply_name">by&nbsp;'. $says['name'].'</span>';
        $html .='<a tag="show_or_hide" id="like_num_of_replys_'. $says['cid'].'" href="javascript:;"></a>';
    	if($says['cus_id']==''){
			        		$html .='<a class="p_06_10" href="javascript:comments_like_or_not('. $says['cid'].',1,\'\');" id="reply_like_'. $says['cid'].'" >'.  $c_like .'</a>'; 
			        		$html .='<a class="p_06_11" href="javascript:comments_like_or_not('. $says['cid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_not_'. $says['cid'].'" >'.  $c_bad .'</a>';
			        		} 
         if($says['cus_id']==$_SESSION['customer_id'] && $_SESSION['customer_id']!=''){
		$html .='<a href="javascript:void(0)" class="solutions_icon_h" onclick="del_review('. (int)$says['cid'].','. (int)$review['rid'].');"><i class="solutions_icon s_icon08"></i>'. FIBERSTORE_DELETE.'</a>';
		 }
        $html .='</div>
    </div>';
     }
    if(sizeof($fs_reviews->get_all_reviews_of_reply($review['rid'],''))>=3){
    	$html .='<div class="P_06_reply_more"><a href="'. zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$review['rid']).'">View all ';
    	 if($fs_reviews->get_all_reviews_of_reply($review['rid'],'')){
    	 $html .= sizeof($fs_reviews->get_all_reviews_of_reply($review['rid'],''));
    	 }else{
    	 $html .= '';
    	 }
    	 $html .= ' Replies<i class="arrow"></i></a></div>';
    
     }} 
    
    	 $html .='<div class="P_06_see_more "></div>';
		 $html .='</dd>
		    </dl>
		   </div>';
		   
						}
          }
					
		 } 
		$html .='</div>';
		
		echo $html;
		 
		  
		exit; 
		break;	
		
		case 'share_reviews':
		$id =$_POST['rid'];
		$html='';
		$html .='<div style="filter: alpha(opacity=30);" class="ui-widget-overlay"></div>';
		$html .='<div id="review_share" class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed" >
		  <div class="popup_tit">share</div>
		  <div class="popup_con">
		  <div class="alena1">
		  <div class="alen1" style=" margin:0 auto;">
			<ul>';
		$html .='<li><a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url='.zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$id).'" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"></a></li>';
		$html .='<li><a href="https://api.addthis.com/oexchange/0.8/forward/linkedin/offer?url='.zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$id).'" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/linkedin.png" border="0" alt="LinkedIn"></a></li>';
		$html .='<li><a href="https://api.addthis.com/oexchange/0.8/forward/google_plusone_share/offer?url='.zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$id).'" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/google_plusone_share.png" border="0" alt="Google+"></a></li>';
		$html .='<li><a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url='.zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$id).'" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"></a></li>';
		$html .='<li><a href="https://www.addthis.com/bookmark.php?source=tbx32nj-1.0&amp;v=300&amp;url='.zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$id).'" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/addthis.png" border="0" alt="Addthis"></a></li>';
		$html .='</ul>
		  </div>
		</div>
		  </div>
		  <div class="box_close"><a href="javascript: ;" onclick="share_clo()"></a></div>
		</div>
	 </div>';
		echo $html;
		exit; 
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
				$html .= '<div class="">Showing '. (($base_num-1)*10+1).'-'. (($base_num-1)*10+$total_num).'&nbsp;of&nbsp;'.$comments_num.' posts in this discussion.</div>'; 
			}else{
				$html .= '<div class="">Showing '. (($base_num-1)*10+1).'-'. ($base_num*10).'&nbsp;of&nbsp;'.$comments_num.' posts in this discussion.</div>';
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
					
					$html .='<div class="P_06_reply" id="del_review_'. (int)$val['id'].'">';
					$html .='<div class="P_06_reply_icon"><img src="'. $says_src.'" alt="'. $says_src.'" width="28" height="28" border="0"></div>
						 <div class="P_06_reply_con">';
					$html .='<span class="P_06_reply_text">'. $val['comments'].'</span>';
					$html .='<span class="P_06_reply_name">by&nbsp;'. $val['name'].'</span>';
					$html .='<a tag="show_or_hide" id="like_comment_num_of_replys_'. $val['id'].'" href="javascript:;"></a>';
					if($val['cid']!=$_SESSION['customer_id'] || $val['cid']==''){
						$html .='<a class="p_06_10" href="javascript:comments_like_or_not('. $val['id'].',1,\'\');" id="reply_like_'. $val['id'].'" >'.$c_like.'</a>'; 
						$html .='<a class="p_06_11" href="javascript:comments_like_or_not('. $val['id'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_like_'. $val['id'].'" >'.$c_bad.'</a>'; 
					}
					$html .='<span class="p_06_reply_sub" ';
					if($_SESSION['customer_id']==$val['cid']){
						$html .='style="display:inline-block">';
					}else{
						$html .='style="display:none">';
					}
		
		  
					$html .='<a href="javascript:void(click_down('. $val['id'].'));" class="solutions_icon_h"><i class="solutions_icon s_icon06"></i>'. FS_EDIT_POST.'</a>';
					$html .='<a href="javascript:void(0)" class="solutions_icon_h" onclick="del_review('. (int)$val['id'].','. (int)$reviews_id.');"><i class="solutions_icon s_icon08"></i>'. FS_DELETE.'</a></span> </div>';
		    
		       
        		
                
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
						$html .='<div class="P_06_reply" id="del_review_'.(int)$says['cid'].'">';
		        		$html .='<div class="P_06_reply_icon"><img src="'.$finalsrc.'" alt="'.$finalsrc.'" width="28" height="28" border="0"></div>';
			    		$html .='<div class="P_06_reply_con">';
						$html .='<span class="P_06_reply_text">'. $says['content'].'</span>';
		        		$html .='<span class="P_06_reply_name">by&nbsp;'. $says['name'].'</span>';
		        		$html .='<a tag="show_or_hide" id="like_num_of_replys_'. $says['cid'].'" href="javascript:;"></a>';
		        		if($says['cus_id']==''){
			        		$html .='<a class="p_06_10" href="javascript:comments_like_or_not('. $says['cid'].',1,\'\');" id="reply_like_'. $says['cid'].'" >'.  $c_like .'</a>'; 
			        		$html .='<a class="p_06_11" href="javascript:comments_like_or_not('. $says['cid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_not_'. $says['cid'].'" >'.  $c_bad .'</a>';
			        		} 
		        		if($says['cus_id']==$_SESSION['customer_id'] && $_SESSION['customer_id']!=''){
						$html .='<a href="javascript:void(0)" class="solutions_icon_h" onclick="del_review('. (int)$says['cid'].','.(int)$review_id.');"><i class="solutions_icon s_icon08"></i>'. FIBERSTORE_DELETE.'</a>';
				 		}
				        $html .='</div>
				        </div>';
					     }
					     if(sizeof($fs_reviews->get_all_reviews_of_reply($review_id,''))>3){
					     	$html .='<div class="P_06_reply_more"><a href="'. zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$review_id).'">View all ';
					        $html .=sizeof($fs_reviews->get_all_reviews_of_reply($review_id,''));
					        $html .=' Replies<i class="arrow"></i></a></div>';
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
		   	
			if(isset($_POST['data']) && !empty($_POST['data']) && !empty($_POST['reviews_id']) && !empty($_SESSION['customer_id'])){
				$review_content = strip_tags($_POST['data']);
				$review_content = zen_db_prepare_input($review_content);
				$reviews_id = (int)$_POST['reviews_id'];
				$products_id = (int)$_POST['products_id'];
				$user_id = (int)$_SESSION['customer_id'];
				
				$reviews_data = array(
					'reviews_id' => $reviews_id,
					'products_id' =>$products_id,
					'status' => 1,
			        'is_fiberstore' =>0,
			        'date_added' => 'now()',
					'last_modified' => 'now()',
			        'rpid'=>0				
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
				
			
				$fssays = get_comments_of_review($reviews_id);
				if(isset($fssays) && $fssays){
				$html = '';
			    	foreach($fssays as $key=> $says){
			    	 $says_image = fs_get_data_from_db_fields('customer_photo','customers','customers_id="'.(int)$says['cus_id'].'"','');	
			    	 
			    	 $says_src =  DIR_WS_IMAGES. (($says_image) ? $says_image : 'portrait_pic.jpg');
			    	 $finalsrc =  (($says['cus_id']!='') ? $says_src : DIR_WS_IMAGES.'portrait_pic09.jpg');
			    	 
			    	 $comments_count = $fs_reviews->get_comments_is_like_count($says['cid']);
			    	 $c_like = $comments_count['r_like'] ? $comments_count['r_like'] : 0;
				     $c_bad = $comments_count['r_bad'] ? $comments_count['r_bad'] : 0;
				$html .='<div class="P_06_reply" id="del_review_'.(int)$says['cid'].'">';
        		$html .='<div class="P_06_reply_icon"><img src="'.$finalsrc.'" alt="'.$finalsrc.'" width="28" height="28" border="0"></div>';
	    		$html .='<div class="P_06_reply_con">';
				$html .='<span class="P_06_reply_text">'. $says['content'].'</span>';
        		$html .='<span class="P_06_reply_name">by&nbsp;'. $says['name'].'</span>';
        		$html .='<a tag="show_or_hide" id="like_num_of_replys_'. $says['cid'].'" href="javascript:;"></a>';
        		if($says['cus_id']==''){
        		$html .='<a class="p_06_10" href="javascript:comments_like_or_not('. $says['cid'].',1,\'\');" id="reply_like_'. $says['cid'].'" >'.  $c_like .'</a>'; 
        		$html .='<a class="p_06_11" href="javascript:comments_like_or_not('. $says['cid'].',0,\''.$_SERVER['REMOTE_ADDR'].'\');" id="reply_not_'. $says['cid'].'" >'.  $c_bad .'</a>';
        		} 
        		if($says['cus_id']==$_SESSION['customer_id'] && $_SESSION['customer_id']!=''){
				$html .='<a href="javascript:void(0)" class="solutions_icon_h" onclick="del_review('. (int)$says['cid'].','.(int)$reviews_id.');"><i class="solutions_icon s_icon08"></i>'. FIBERSTORE_DELETE.'</a>';
		 		}
		        $html .='</div>
		        </div>';
			     }
			     if(sizeof($fs_reviews->get_all_reviews_of_reply($reviews_id,''))>3){
			     	$html .='<div class="P_06_reply_more"><a href="'. zen_href_link(FILENAME_COMMENTS_REVIEW,'&rid='.$reviews_id).'">View all ';
			     
			     	$html .=sizeof($fs_reviews->get_all_reviews_of_reply($reviews_id,''));
			     
			     	$html .=' Replies<i class="arrow"></i></a></div>';
			     }
			     
			}
		}
			echo $html;
			
		break;
			    
	
	
        }
  
  
  }
