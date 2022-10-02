<?php
/**
 */
 if (in_array($_GET['main_page'],array(FILENAME_CHECKOUT_SUCCESS))) {

 	 require $body_code;
 }else {

 ?>
<div class="content <?PHP echo ($this_is_home_page) ? 'content_index': '';?>">

        <?php
        $left_side_bar = 'tpl_left_slide_bar.php';

        /*load left bar for account special pages */
        if (in_array($_GET['main_page'], array(FILENAME_ACCOUNT_PASSWORD,FILENAME_ACCOUNT_NEWSLETTERS,'account','my_dashboard','my_questions','my_cases',FILENAME_MY_QUESTIONS_DETAILS,'manage_orders_old','manage_wishlists',
        		'manage_addresses','manage_profile','manage_reviews','manage_coupons','account_history_info_old',FILENAME_REGIST_SUCCESS,'unpaid_orders','closed_orders','trading_orders','unpaid_orders','change_password','sales_service','copper_cabling_systems',FILENAME_SALES_SERVICE_INFO,FILENAME_SALES_SERVICE_DETAILS)))
        {
        	if (isset($_SESSION['customer_id']))
        		$left_side_bar = 'tpl_account_left_slide_bar.php';

        }else if (in_array($_GET['main_page'], array('net_30','money_back_guarantee','quality_control','terms_of_use','contact_us','faq_detail','faq','get_a_quick_quote','both_ways','estimated_lead_time','global_shipping','how_to_buy','oem','payment_methods','partner','partner_submit','rma_solution','day_return_policy','shipping_guide','warranty','why_us','privacy_policy','contact_us_success')))
        {
        $left_side_bar = 'tpl_service_left_slide_bar.php';
        }
        else if (in_array($_GET['main_page'], array('iso_standard')))
        {
        $left_side_bar = 'tpl_news_left_slide_bar.php';
        }
//          else if (in_array($_GET['main_page'], array('partner_submit')))
//         {
//         $left_side_bar = 'tpl_partner_left_slide_bar.php';
//         }
         else if (in_array($_GET['main_page'], array('tutorial')))
        {
        $left_side_bar = 'tpl_tutorial_left_slide_bar.php';
        }
        else if (in_array($_GET['main_page'], array('tutorial_list')))
        {
        $left_side_bar = 'tpl_tutorial_category_left_slide_bar.php';
        }
         else if (in_array($_GET['main_page'], array('tutorial_detail')))
        {
        $left_side_bar = 'tpl_tutorial_list_left_slide_bar.php';
        }
        else if (in_array($_GET['main_page'], array('custom_OEM','solution_list','low_cost_cwdm_solution')))
        {
        $left_side_bar = 'tpl_solution_category_left_slide.php';
        }
        else if(in_array($_GET['main_page'], array('solution_detail','solution','products_detail')))
        {
            if(!empty($article_is_new)){
                $left_side_bar = '';
            }else{
                $left_side_bar = 'tpl_solution_list_left_slide_bar.php';
            }

        }
         else if (in_array($_GET['main_page'], array('wavelength_guide_for_c_band_50ghz_dwdm_series','wavelength_guide_for_c_band_100ghz_dwdm_series')))
        {
        $left_side_bar = 'tpl_10g_sfp_left_slide_bar.php';
        }
  		else if (in_array($_GET['main_page'], array(FILENAME_IN_THE_NEWS,'news','news_article','news_archive'))){
        	$left_side_bar = 'tpl_left_slide_bar_for_in_the_news.php';
        }
 		else if(in_array($_GET['main_page'], array(FILENAME_PRODUCTS_SEARCH))){
        	$left_side_bar = 'tpl_left_side_bar_for_categories_narrow_by.php';

        }else if(in_array($_GET['main_page'], array('tag_categories'))){
        	$left_side_bar = 'tpl_left_side_bar_for_tag.php';

        }

        else if ((FILENAME_DEFAULT == $_GET['main_page'] && !$this_is_home_page ) || FILENAME_NARROW == $_GET['main_page'] || FILENAME_NS == $_GET['main_page']){

        	//load left bar for categories
        	if (FILENAME_DEFAULT == $_GET['main_page']){
	        	$count_of_category = sizeof($cPath_array);
	        	if (1 == $count_of_category){
	        		$left_side_bar = 'tpl_left_side_bar_for_categories.php';
	        	}else
	        	$left_side_bar = 'tpl_left_side_bar_for_categories_narrow_by.php';
        	}else $left_side_bar = 'tpl_left_side_bar_for_categories_narrow_by.php';
        }else if (FILENAME_DEFAULT == $_GET['main_page'] && $this_is_home_page ){
                $left_side_bar = '';
        }else if (in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT,'search')) ){
        	//load search left bar
        		$left_side_bar = '';
        		if ($search_products_total_num)
        			$left_side_bar = 'tpl_left_side_bar_for_advanced_search_result.php';
        }else {
        	$left_side_bar = '';
        }
        if (zen_not_null($left_side_bar))
			require($template->get_template_dir($left_side_bar,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$left_side_bar);
//}

?>




<?php if($this_is_home_page){?>

        	<?php require $body_code;?>

        <?php }
        else if(in_array($_GET['main_page'],array(FILENAME_PRODUCT_INFO,FILENAME_SUBMIT_REVIEW,FILENAME_ALL_REVIEW,FILENAME_HOW_TO_BUY,FILENAME_SHOPPING_CART,FILENAME_CONTACT_US
,FILENAME_PAYMENT_METHODS,FILENAME_GET_A_QUICK_QUOTE,FILENAME_SHIPPING_GUIDE,FILENAME_FAQ,FILENAME_ABOUT_US,FILENAME_WHY_US,FILENAME_TUTORIAL,FILENAME_PURCHASING_HELP,FILENAME_RMA_SOLUTION,FILENAME_PRIVACY_POLICY,
FILENAME_CUSTOM_OEM,FILENAME_ESTIMATED_TIME,FILENAME_SITE_MAP,FILENAME_LOW_COST_CWDM_SOLUTION,FILENAME_TUTORIAL_LIST,FILENAME_TUTORIAL_DETAIL,FILENAME_NEWS_ARTICLE,FILENAME_NEWS,
FILENAME_GLOBAL_SHIPPING,FILENAME_ISO_STANDARD,FILENAME_OEM,FILENAME_DAY_RETURN_POLICY,FILENAME_DAY_RETURN_POLICY,FILENAME_BOTH_WAYS,FILENAME_FREE_SHIPPING,FILENAME_FAQ_DETAIL,FILENAME_TIME_OUT,FILENAME_SUBMIT_EDIT_REVIEW,
FILENAME_PRODUCT_REVIEWS,FILENAME_PRODUCT_REVIEWS_WRITE,FILENAME_PARTNER,FILENAME_PARTNER_SUBMIT,FILENAME_PRODUCT_REVIEWS_INFO,FILENAME_SHOW_ALL_CATEGORIES,FILENAME_PRODUCTS_NEW,
FILENAME_SUPPORT,FILENAME_SUPPORT_LIST,FILENAME_SUPPORT_DETAIL,FILENAME_PRODUCT_INFO_INQUIRY_SUCCESS,'checkout_success','checkout_success_western_union','checkout_success_wire_transfer','cookie_usage','new_domain','wholesale','distributors',
'Popular','Popular_detail','Product_List','fiberstore_with_partners','support','products_list','all_feedback','selection_region','copper_cabling_systems'))){?>
         <?php
         require $body_code;?>
        <?php }

		else if (FILENAME_DEFAULT == $_GET['main_page']){
			?>
			<div class="main_content main_content_page ">
       	<?php require $body_code;?>
        </div>
		<?php }

		else if (in_array($_GET['main_page'],array(FILENAME_MY_DASHBOARD,'manage_orders_old',FILENAME_MANAGE_WISHLISTS,FILENAME_MANAGE_REVIEWS,FILENAME_ACCOUNT_NEWSLETTERS,FILENAME_MANAGE_PROFILE,FILENAME_MANAGE_ADDRESSES,'account_history_info_old'))){

		?>
					<div class="main_content main_content_admin ">
		        	<?php require $body_code;?>
		        </div>
				<?php }
        else if(in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT)) && 0 == $fs_result->number_of_rows){

			require $body_code;
		}

         else if(in_array($_GET['main_page'],array(FILENAME_WARRANTY))){

			require $body_code;
		}



         else if(in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT)) ){
			 ?> <div class="main_content main_content_page"><?php
			require $body_code;?>
			</div><?php
		}
		else if(in_array($_GET['main_page'],array(FILENAME_PRODUCTTAGS,'page_notfound','customer_qa',FILENAME_NEWSLETTER_SUCCESS))){
		?>
			     <div>
		        	<?php require $body_code;?>
		        </div>
		<?php }


        else {?>


        <div class="<?php echo empty($article_is_new)?'main_content main_content_page':''?>">
            <?php require $body_code;?>

        </div>

        <?php }?>

        <div class="ccc"></div>
    </div>
    <div class="ccc"></div>
<?php }?>