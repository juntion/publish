<?php
/**
 */
if (in_array($_GET['main_page'],array(FILENAME_CHECKOUT_SUCCESS,'data_center', FILENAME_CHECKOUT_SUCCESS_PURCHASE))) {

    require $body_code;
}else {

    ?>
    <div class="box">
    <div class="remove_bg"></div>
    <?php
    if (in_array($_GET['main_page'], array('e_rate','inquiry','file_demonstration_po','software_download','product_support','appdownload','optical_transport_technical','poe_series_switches','sfp_optical_module','delivery_method','fiber_splitter','st_fiber_cables','sc_fiber_cables','qc_development','copper','patch_cable','fum_fmt','40g_solution','patch_panel','base','dwdm_long_haul_network_solution','customer_service_others','fs_special_page','support_stock_list','bulk_fiber_cable_usa','new_domain','oem','wholesale','fiber_patching_solution','mpo_mtp_cables_solutions','copper_cable_assemblies','test_assured_program','solutions_bak_bak_bak','cwdm_dwdm_transmission_solution','bend_insensitive_fiber_cables','reversible_polarity_lc_uniboot_patch_cable','about_us','show_all_categories','service','100G_Transceivers','lc_special','fiber_lc_fc_3','aoc','transport_network_specials','products_detail','qc_development_detail','terms_of_use','ethernet_patch_cables','wdm_optical_transport_platform','gr_series_cabinet','fs_n_series_cumulus_linux_switches','withdrawal','solution_support','new_product',
        'custom_fiber_cable_assemblies','inquiry_out','support_page','clearance','clearance_list','verify','product_ideas','customer_payment_link','products_payment','shopping_products','sample_application','cwdm_dwdm_model_solution','light_armored_fiber_cable_solution','price_distribution','service_view_order_online','fmu_cwdm_dwdm_mux_demux_solution','fhd','custom_lc_uniboot_hd_plus_fiber_cables','cable_management_solutions','payment_methods','estimated_lead_time','net_30','fiber_patch_cables','faq','partner','how_to_buy','density_fiber_distribution','optical_transport_network','quality_control','day_return_policy','help_center','global_shipping','warranty','why_us','news_article','news','news_and_events','fiberstore_with_partners','banner_fhd','shopping_cart','cleaning_tools','privacy_policy','shipping_delivery','eu_shipping_delivery','course_page','product_catalogs','knowledge_base_all','cabling_solution','tutorial_detail','choose_country',FILENAME_LIVE_CHAT_SERVICE,FILENAME_LIVE_CHAT_SERVICE_MAIL,FILENAME_LIVE_CHAT_SERVICE_PHONE,'warranty_brochure','imprint','product_video','customer_service','contact_us','my_team','fs_single_pages','save_shopping_list',FILENAME_PRODUCT_SUB_PAGE,FILENAME_PRODUCT_SUB_PAGE_ENT,FILENAME_PRODUCT_SUB_PAGE_ISP,FILENAME_SOLUTION_SUB_PAGE,FILENAME_SOLUTION_SUB_PAGE_ENT,FILENAME_SOLUTION_SUB_PAGE_OPT,FILENAME_SOLUTION_TWO_PAGE,'customer_service','legal_notice','walking_trough','fs_series_introduction','visit_us','confirm_unsubscribe','email_subscription','page_notfound',FILENAME_ADVANCED_SEARCH_RESULT)) || (isMobile() && $_GET['main_page']=='product_info') || ($_GET['main_page']=='index' && sizeof($cPath_array)>1) || ($_GET['main_page']=='product_info' && $products_page_state == 3) || ($_GET['main_page']!='products_support' &&sizeof($cPath_array)==1)){
    }elseif (in_array($_GET['main_page'],$member_center_page)) {

    }else{
        require 'tpl_breadcrumb.php';
    }

    ?>
    <?php
        if($this_is_home_page){
            $class_content = "content_index";
        }else{
            $class_content = " ";
        }
    ?>
    <div class="content <?PHP echo $class_content;?>">

        <?php
        $left_side_bar = 'tpl_left_slide_bar.php';

        if (in_array($_GET['main_page'], array('money_back_guarantee','faq_detail','get_a_quick_quote','both_ways','partner_submit','rma_solution','contact_us_success','distributors')))//terms_of_use  privacy_policy
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
//         else if (in_array($_GET['main_page'], array('tutorial')))
//        {
//        $left_side_bar = 'tpl_tutorial_left_slide_bar.php';
//        }
//        else if (in_array($_GET['main_page'], array('tutorial_list')))
//        {
//        $left_side_bar = 'tpl_tutorial_category_left_slide_bar.php';
//        }
//         else if (in_array($_GET['main_page'], array('tutorial_detail')))
//        {
//        $left_side_bar = 'tpl_tutorial_list_left_slide_bar.php';
//        }
        else if (in_array($_GET['main_page'], array('custom_OEM','solution_list','low_cost_cwdm_solution')))
        {
            $left_side_bar = 'tpl_solution_category_left_slide.php';
        }
        else if(in_array($_GET['main_page'], array('solution_detail','solution','products_detail')))
        {
            if(!empty($article_is_new)){
                $left_side_bar = '';
            }else{
                //$left_side_bar = 'tpl_solution_list_left_slide_bar.php';
                $left_side_bar = '';
            }


        }
        else if (in_array($_GET['main_page'], array('wavelength_guide_for_c_band_50ghz_dwdm_series','wavelength_guide_for_c_band_100ghz_dwdm_series')))
        {
            $left_side_bar = 'tpl_10g_sfp_left_slide_bar.php';
        }
        else if (in_array($_GET['main_page'], array('news_archive'))){
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
                    $left_side_bar = '';
            }else $left_side_bar = 'tpl_left_side_bar_for_categories_narrow_by.php';
        }else if (FILENAME_DEFAULT == $_GET['main_page'] && $this_is_home_page ){
            $left_side_bar = '';
        }else if (in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT,'search')) ){
            //load search left bar
            $left_side_bar = '';
            if ($search_products_total_num)
                //$left_side_bar = 'tpl_left_side_bar_for_advanced_search_result.php';
                $left_side_bar = '';
        }else if (in_array($_GET['main_page'],array('Popular_detail')) ){
            //load search left bar
            $left_side_bar = '';
            if ($fs_result->number_of_rows)
                $left_side_bar = 'tpl_left_side_bar_for_popular_detail.php';
        }else {
            $left_side_bar = '';
        }
        if (zen_not_null($left_side_bar)&& (int)$current_category_id != 4)
            require($template->get_template_dir($left_side_bar,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$left_side_bar);
        //}

        ?>




        <?php if($this_is_home_page){?>

            <?php require $body_code;?>

        <?php }elseif (in_array($_GET['main_page'],$member_center_page)) { ?>
            <?php require $body_code;?>

        <?php }
        else if(in_array($_GET['main_page'],array(FILENAME_PRODUCT_INFO,FILENAME_SUBMIT_REVIEW,FILENAME_ALL_REVIEW,FILENAME_HOW_TO_BUY,FILENAME_SHOPPING_CART,FILENAME_CONTACT_US,FILENAME_PAYMENT_METHODS,FILENAME_GET_A_QUICK_QUOTE,FILENAME_SHIPPING_GUIDE,FILENAME_FAQ,FILENAME_ABOUT_US,FILENAME_WHY_US,FILENAME_PURCHASING_HELP,FILENAME_RMA_SOLUTION,FILENAME_PRIVACY_POLICY,FILENAME_SAVE_SHOPPING_LIST,FILENAME_PRINT_SHOPPING_LIST,
            FILENAME_CUSTOM_OEM,FILENAME_ESTIMATED_TIME,FILENAME_SITE_MAP,FILENAME_LOW_COST_CWDM_SOLUTION,FILENAME_TUTORIAL_LIST,FILENAME_TUTORIAL_DETAIL,FILENAME_NEWS_ARTICLE,FILENAME_NEWS,FILENAME_LIVE_CHAT_SERVICE,FILENAME_LIVE_CHAT_SERVICE_MAIL,FILENAME_LIVE_CHAT_SERVICE_PHONE,
            FILENAME_GLOBAL_SHIPPING,FILENAME_ISO_STANDARD,FILENAME_OEM,FILENAME_DAY_RETURN_POLICY,FILENAME_DAY_RETURN_POLICY,FILENAME_BOTH_WAYS,FILENAME_FREE_SHIPPING,FILENAME_FAQ_DETAIL,FILENAME_TIME_OUT,FILENAME_SUBMIT_EDIT_REVIEW,'ethernet_patch_cables',
            FILENAME_PRODUCT_REVIEWS,FILENAME_PRODUCT_REVIEWS_WRITE,FILENAME_PARTNER,FILENAME_PARTNER_SUBMIT,FILENAME_PRODUCT_REVIEWS_INFO,FILENAME_SHOW_ALL_CATEGORIES,FILENAME_PRODUCTS_NEW,'my_cases','my_cases_details',FILENAME_SUPPORT_LIST,FILENAME_SUPPORT_DETAIL,FILENAME_PRODUCT_INFO_INQUIRY_SUCCESS,FILENAME_TRANSMISSION_SOLUTIONS,FILENAME_SUBMIT_ORDERS_REVIEW,FILENAME_TAKE_PRODUCT_OFF_SHELVES,FILENAME_DEFAULT,'checkout_success','checkout_success_western_union','checkout_success_wire_transfer','cookie_usage','new_domain','wholesale','fiber_patching_solution','copper_cable_assemblies','test_assured_program','solutions_bak_bak_bak','oem','distributors','tutorial_tag_search','selection_region','mtp_mpo_fiber_cabling',
            'Popular','Product_List','fiberstore_with_partners','products_list','customer_payment_link','products_payment','shopping_products','all_feedback','bend_insensitive_fiber_cables','reversible_polarity_lc_uniboot_patch_cable','custom_fiber_cable_assemblies','mpo_mtp_cables_solutions','cwdm_dwdm_model_solution','light_armored_fiber_cable_solution','service_view_order_online','fmu_cwdm_dwdm_mux_demux_solution','fhd','comments_review','custom_lc_uniboot_hd_plus_fiber_cables','customer_qa','products_tag_search','100G_Transceivers','lc_special','fiber_lc_fc_3','aoc','transport_network_specials','wdm_optical_transport_platform','gr_series_cabinet','fs_n_series_cumulus_linux_switches',
            'cable_management_solutions','clearance','clearance_list','verify','saved_items','saved_cart_details','data_center_switches','delivery_method','bulk_fiber_cable_usa','high_density_fiber_patching_solutions','support_stock_list','price_distribution','fs_special_page','dwdm_long_haul_network_solution','base','patch_panel','40g_solution','dac_cables','fum_fmt','1g_sfp_transceivers','patch_cable','copper','qc_development','banner_fhd',"enterprise_network_solution","fiber_optical_transceivers_solution",'cleaning_tools','shipping_delivery','gx_news_fhd','withdrawal',
            'course_page','product_catalogs','knowledge_base_all','cabling_solution','catalog_fiber','choose_country','print_get_a_quote','solution_support','cumlums_table','qc_development_detail','fs_special_pages','st_fiber_cables','sc_fiber_cables','new_comment_success_order','new_comment_success_details','eu_shipping_delivery','warranty_brochure','copper_cabling_systems','imprint','help_center','product_video','my_team',FILENAME_PRODUCT_SUB_PAGE,FILENAME_PRODUCT_SUB_PAGE_ENT,FILENAME_PRODUCT_SUB_PAGE_ISP,FILENAME_SOLUTION_SUB_PAGE,FILENAME_SOLUTION_SUB_PAGE_ENT,FILENAME_SOLUTION_SUB_PAGE_OPT,FILENAME_SOLUTION_TWO_PAGE,
            'inquiry','software_download','inquiry_out','appdownload','terms_of_use','cumlums_off','inquiry_list','sample_application','inquiry_detail','sfp_optical_module','density_fiber_distribution','optical_transport_network','resources','videos','case_studies','buying_guide','spotlight','know_how','download','optical_transport_technical','customer_service','legal_notice','request_stock','walking_trough','fs_series_introduction','confirm_unsubscribe','email_subscription','support_page'))){?>
            <?php
            require $body_code;?>
        <?php }

        else if (in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT,'search'))){
            ?>
            <div class="<?php echo  in_array($current_category_id,array(1,9,209,904,1308,4,911)) ? '' : '';?>">
                <?php require $body_code;?>
            </div>
        <?php }

        else if (in_array($_GET['main_page'],array('fiber_transceivers','appdownload','customer_service_others','customer_payment_link','superior_10g_sfp_transceivers','terms_of_use','privacy_policy'))){
            ?>
            <div class="">
                <?php require $body_code;?>
             </div>
        <?php }

        else if (in_array($_GET['main_page'],array(FILENAME_MY_DASHBOARD,'manage_orders_old',FILENAME_VALID_QUOTATION,FILENAME_VALID_QUOTATION_DETAIL,FILENAME_MANAGE_WISHLISTS,FILENAME_MANAGE_REVIEWS,FILENAME_ACCOUNT_NEWSLETTERS,FILENAME_MANAGE_PROFILE,FILENAME_MANAGE_ADDRESSES,FILENAME_ACCOUNT_HISTORY_INFO,FILENAME_MY_QUESTIONS,FILENAME_MY_QUESTIONS_DETAILS,'edit_my_account','sales_service_list','sales_service_details','sales_service','sales_service_info'))){

            ?>
            <div class="new17my_account_main">
                <?php require $body_code;?>
            </div>
        <?php }
        else if(in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT)) && 0 == $search_products_total_num){

            require $body_code;
        }

        else if(in_array($_GET['main_page'],array(FILENAME_WARRANTY,FILENAME_Net_30,'fiber_patch_cables','poe_series_switches',FILENAME_QUALITY_CONTROL,'fiber_splitter'))){

            require $body_code;
        }


         
        else if(in_array($_GET['main_page'],array(FILENAME_ADVANCED_SEARCH_RESULT,'Popular_detail')) ){
			
            ?> <?php
            require $body_code;?>
            <?php
        }
        else if(in_array($_GET['main_page'],array(FILENAME_PRODUCTTAGS,'page_notfound',FILENAME_NEWSLETTER_SUCCESS))){
            ?>
            <div>
                <?php require $body_code;?>
            </div>
        <?php }
        else if(in_array($_GET['main_page'],array('products_detail'))&&empty($article_is_new)){
            ?>
            <div class="product_article_left">
                <?php require $body_code;?>
            </div>
        <?php }

        else {?>
                <?php require $body_code;?>
        <?php }?>

        <?php if (in_array($_GET['main_page'],$member_center_page)) {
            if(!in_array($_GET['main_page'],$member_center_page_navi)){
                echo '</div></div>';
            }
        }?>

        <div class="ccc"></div>
    </div>
    <div class="ccc"></div>
<?php }?>