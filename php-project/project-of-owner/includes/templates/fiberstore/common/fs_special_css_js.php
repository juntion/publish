<?php
// 是否是手机
$is_mobile = isMobile();
$common_is_mobile = (!$is_mobile || isset($_COOKIE['c_site']))?0:1;
// 插件样式，应该放到最前面，自己写的样式覆盖插件样式

//对应语种样式文件目录
$cssCode = '';
if($_SESSION['languages_id']!=1) $cssCode = $_SESSION['language'];

//新版个人中心

$member_center_page = array('inquiry_request_edit','view_reviews','orders_review','orders_review_list','my_cases','my_cases_details','inquiry_list','inquiry_detail','manage_orders','manage_orders_offline','account_history_info','account_offline_history_info','manage_addresses','edit_my_account','new_account_index','my_credit','sales_service_list','sales_service_request_list','sales_service_info','sales_service_details','sales_service_success','my_dashboard','regist_success','return_guidelines','coding_requests','track_package','saved_items','saved_cart_details','purchase_order_list','purchase_order_details','tax_exemption','my_companies','quotes_list','quotes_details','billing');


//个人中心包含左侧导航的页面
$member_center_page_navi = array('inquiry_request_edit','orders_review','inquiry_list','inquiry_detail','manage_orders','manage_orders_offline','account_history_info','manage_addresses','edit_my_account','my_credit','my_dashboard','return_guidelines','orders_review','sales_service_list','regist_success');

// 弹窗插件的样式
// 尾部反馈弹窗需要调用
?>

<?php
//如果是 jp 需要单独加载字体
if($_SESSION['languages_id'] ==8){?>
    <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/font_jp.css',$code);?>" />
<?php }else{?>
    <style>@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;src:url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans.woff2);src:local('Open Sans'),local('OpenSans'),url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans.woff2) format('woff2')}@font-face{font-family:'Open Sans';font-style:normal;font-weight:300;src:local('Open Sans Light'),local('OpenSans-Light'),url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans-light-webfont.woff2) format('woff2');}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;src:local('opensans semibold webfont'),local('opensans-semibold-webfont'),url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans-semibold-webfont.woff2) format('woff2');font-display: swap}<?php if($_SESSION['languages_code'] == 'ru'){//俄语站点文字改为免费字体arial SQ20200310002?>
        body{font-family:'system-ui' !important;}
        <?php }?>
    </style>
<?php }?>
<link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/iconfont.css',$code);?>" />
<?php if(!in_array($_GET['main_page'],array('nationality'))){?>
    <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/public.css',$code);?>" />
    <link rel="stylesheet" href="<?php echo auto_version('/includes/templates/fiberstore/css/swiper-sweetalert2.css',$code);?>">
<?php }?>
<?php if($common_is_mobile==0){ ?>

<?php }elseif($this_is_home_page || $_GET['main_page']=='product_ideas'){ ?>
<link rel="stylesheet" href="<?php echo auto_version('/includes/templates/fiberstore/css/indexCss.css',$code);?>">
<?php  }?>
<script type="text/javascript" src="<?php echo auto_version('includes/templates/fiberstore/jscript/cdn_js/jquery-3.5.1.min.js',$code);?>"></script>

<?php if(!in_array($_GET['main_page'],array('nationality'))){?>
    <script type="text/javascript" src="<?php echo auto_version('includes/templates/fiberstore/jscript/cdn_js/js_cdn.js',$code);?>"></script>
<?php }?>


<?php
//客户中心后台样式引用
if(in_array($_GET['main_page'],$member_center_page)){ //my_account.css

}
else
if (in_array($_GET['main_page'],array(FILENAME_ACCOUNT_PASSWORD,FILENAME_ACCOUNT_NEWSLETTERS,'account','my_dashboard','my_questions',FILENAME_MY_QUESTIONS_DETAILS,'manage_orders','manage_orders_offline',FILENAME_VALID_QUOTATION,FILENAME_VALID_QUOTATION_DETAIL,'manage_wishlists','edit_my_account','my_cases','my_cases_details',
    'manage_addresses','manage_profile','manage_reviews','manage_coupons',FILENAME_ACCOUNT_HISTORY_INFO,FILENAME_REGIST_SUCCESS,'unpaid_orders','closed_orders','trading_orders','unpaid_orders','change_password','sales_service',FILENAME_SALES_SERVICE_INFO,'sales_service_success','sales_service_list','service_view_order_online',FILENAME_SALES_SERVICE_DETAILS,
    'inquiry_list','inquiry_detail', 'inquiry_request_edit'))){ ?>
    <link href="<?php echo auto_version('includes/templates/fiberstore/css/my_account.css',$code);?>" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if(in_array($_GET['main_page'],array('sales_service_list','sales_service_info','sales_service_details','sales_service_success'))){ ?>
    <script type="text/javascript" src="<?php echo auto_version('/includes/templates/fiberstore/jscript/check_number.js',$code);?>"></script>
    <script type="text/javascript" src="<?php echo auto_version('includes/templates/fiberstore/jscript/country_select.js',$code);?>"></script>
<?php } ?>
<?php if(!empty($current_category_id) && isset($current_category_id) && $_GET['main_page']=='index'  && in_array($current_category_id,array(1,9,209,1308,573,4,904,911) ) ){
//        $version = fs_get_total_from_db('categories_index_menu','categories_id = '.$current_category_id.' and languages_id = '.$_SESSION['languages_id'].' and type = 0');
//        if($common_is_mobile==0){
//            $css_name = $version > 0 ? 'index_menu.css' : 'fot.css';
//        }else{
//            $css_name = 'index_menu_m.css';
//        }?>
    <link href="<?php echo auto_code_version('/includes/templates/fiberstore/css/index_menu.css');?>" rel="stylesheet" type="text/css" />
<?php } ?>
<?php if(!$this_is_home_page){
    $userbrowser = $_SERVER["HTTP_USER_AGENT"];
    ?>
<?php } ?>


<?php
$userbrowser = $_SERVER["HTTP_USER_AGENT"];
if($this_is_home_page){
    ?>
<?php }else{
    if ( preg_match( '/MSIE/i', $userbrowser ) || strpos($_SERVER["HTTP_USER_AGENT"],"rv:11.0")) {
        ?>
    <?php }else{?>
    <?php }?>
    <?php if(in_array($_GET['main_page'],$member_center_page) || $_GET['main_page']=='checkout' ||
        $_GET['main_page']=='quotes_create'||$_GET['main_page']=='pdf_show_html'){ //新版个人中心不加载fs_allCss.css

    }else
        if(in_array($_GET['main_page'], array('login','regist','partner_submit','checkout_paypal_confirm','checkout_wiretransfer_complete','checkout_success','password_forgotten','password_submit_success','password_update','address_book_edit','address_book_guest','checkout_globalcollect_billing','checkout_payment_against',FILENAME_LOGIN_GUEST,'partner_update','regist_email_check','modern_slavery_statement','checkout_echeck_complete'))){?>
        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/backstage.css',$code);?>" />
        <?php
        if($_GET['main_page'] == "checkout_echeck_complete"){
            ?>
            <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/fs_allCss.css',$code);?>" />
        <?php }?>
    <?php }else{ ?>
        <?php
        if($countryCode !="AU"){
            if(!in_array($_GET['main_page'],array(FILENAME_ACCOUNT_PASSWORD,FILENAME_ACCOUNT_NEWSLETTERS,'account',
                'my_dashboard','my_questions',
                FILENAME_MY_QUESTIONS_DETAILS,'manage_orders','manage_orders_offline',
                FILENAME_VALID_QUOTATION,FILENAME_VALID_QUOTATION_DETAIL,
                'manage_wishlists','edit_my_account','manage_addresses','manage_profile','manage_reviews','manage_coupons',
                FILENAME_ACCOUNT_HISTORY_INFO,FILENAME_REGIST_SUCCESS,'unpaid_orders',
                'closed_orders','trading_orders','unpaid_orders','change_password',
                'sales_service','customer_service_others',
                'sales_service_list','sales_service_success',
                FILENAME_SALES_SERVICE_INFO,FILENAME_SALES_SERVICE_DETAILS,
                'fum_fmt','concerning_polarity','40g_solution','patch_panel','base',
                'dwdm_long_haul_network_solution','cabling_solution','catalog_cable',
                'catalog_enterprise_network','catalog_fiber','catalog_test',
                'catalog_transceiver','catalog_wdm','resources','videos',
                'buying_guide','spotlight','ideas','know_how','products_support','support','customer_service',
                'fs_single_pages','inquiry','inquiry_out','print_blanket_order','print_get_a_quote',
                'product_info','index','nationality', 'print_checkout_success', 'network_solution'))){?>
                <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/fs_allCss.css',$code);?>" />
            <?php }}else{
            if(!in_array($_GET['main_page'],array(FILENAME_ACCOUNT_PASSWORD,FILENAME_ACCOUNT_NEWSLETTERS,'account','my_dashboard','my_questions',
                FILENAME_MY_QUESTIONS_DETAILS,'manage_orders','manage_orders_offline',FILENAME_VALID_QUOTATION,FILENAME_VALID_QUOTATION_DETAIL,'manage_wishlists','edit_my_account','manage_addresses','manage_profile','manage_reviews','manage_coupons',
                FILENAME_ACCOUNT_HISTORY_INFO,FILENAME_REGIST_SUCCESS,'unpaid_orders','closed_orders','trading_orders','unpaid_orders','change_password','sales_service','customer_service_others',
                'sales_service_list','sales_service_success',FILENAME_SALES_SERVICE_INFO,FILENAME_SALES_SERVICE_DETAILS,'fum_fmt','shipping_delivery','concerning_polarity','40g_solution','patch_panel','base','dwdm_long_haul_network_solution','cabling_solution','catalog_cable','catalog_enterprise_network','catalog_fiber','catalog_test','catalog_transceiver','catalog_wdm','resources','videos','buying_guide','spotlight','ideas','know_how','products_support','support','fs_single_pages','inquiry','inquiry_out','print_blanket_order','print_get_a_quote','product_info','index','nationality', 'print_checkout_success'))){?>
                <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/fs_allCss.css',$code);?>" />
            <?php }} ?>
    <?php } ?>
<?php } ?>

<?php
switch($_GET['main_page'])
{
    case 'my_dashboard':
    case 'orders_review':
    case 'submit_review':
    echo '<link href="'.auto_version('/includes/templates/fiberstore/css/want_go_buy.css',$code).'" rel="stylesheet" type="text/css" />';
        break;
    case 'on_site_service':
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/upload_check.js',$code).'"></script>';
//        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/sample_application.js',$code).'"></script>';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/service-apply-form.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/service_data_time.css',$code).'" />';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/service_data_time.js',$code).'"></script>';
        break;

    //Resource板块样式引用
    case 'index':
        if(!empty($_GET['cPath']) && !$this_is_home_page){   //定位列表页
            if(!in_array($current_category_id,array(1,9,209,1308,4,904,911))){
                echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_product_list.css',$code).'" />';
            }
            if($common_is_mobile){//m端
                echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new-list-m.css',$code).'" />';
            }
        }else{
            if(!$this_is_home_page){
                echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/fs_allCss.css',$code).'" />';
            }
        }
        break;
    case 'ideas':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/collection_resources.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/ideas.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_index.css',$code).'" />';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/ideas.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/product_list.js',$code).'"></script>';
        break;
    case 'product_ideas':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/collection_resources.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/ideas.css',$code).'" />';
        break;
    case 'download':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_download.css',$code).'" />';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/download.js',$code).'"></script>';
        break;
    case 'products_support':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/collection_resources.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_support.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/technical_documents.css',$code).'" />';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/download.js',$code).'"></script>';
        break;
    case 'request_demo':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/request_demo.css', $code).'" />';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/request_demo.js',$code).'"></script>';
        break;
    case 'question_list':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/support_index.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/faqs.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/single/help_center.css',$code).'" />';
        break;
    case 'software_download':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/public_account.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/account_center_new.css',$code).'">';
        break;
    case 'resources':
    case 'videos':
    case 'case_studies':
    case 'buying_guide':
    case 'spotlight':
    case 'know_how':
    case 'tutorial_detail':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/collection_resources.css',$code).'" />';
        break;
    case 'customer_service':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/contact_us.css',$code).'"/>';
        break;

    case 'density_fiber_distribution':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/FHX_special.css',$code).'">';
        break;

    case 'optical_transport_technical':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/case_studies.css',$code).'" />';
        break;

    case 'optical_transport_network':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/optical_network.css',$code).'">';
        break;


    //专题页面样式引用
    case 'light_armored_fiber_cable_solution':
    case 'copper_cable_assemblies':
    case  'fmu_cwdm_dwdm_mux_demux_solution':
    case  'custom_lc_uniboot_hd_plus_fiber_cables':
        echo '<link href="'.auto_version('/includes/templates/fiberstore/css/special_style.css',$code).'" rel="stylesheet" type="text/css" />';
        break;
    case 'support_page':
        echo '<link href="'.auto_version('/includes/templates/fiberstore/css/support_new.css',$code).'" rel="stylesheet" type="text/css" />';
        echo '<link href="'.auto_version('/includes/templates/fiberstore/css/public.css',$code).'" rel="stylesheet" type="text/css" />';
		echo '<link href="'.auto_version('/includes/templates/fiberstore/css/media.css',$code).'" rel="stylesheet" type="text/css" />';
        break;
    case 'news':
        echo '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version('/includes/templates/fiberstore/css/specials/sp_default.css',$code).'" />';
        echo '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version('/includes/templates/fiberstore/css/news.css',$code).'" />';
        break;
    //单页面样式引用
    case 'returns':
    case 'estimated_lead_time':
    case 'news_and_events':
    case 'news_article':
    case 'eu_shipping_delivery':
        if(!all_german_warehouse('country_code',strtoupper($_SESSION['languages_code']))) {
            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/Return_Policy.css',$code).'"/>';
        }
       echo '<link href="'.auto_code_version('/includes/templates/fiberstore/css/all_style.css').'" rel="stylesheet" type="text/css" />';
        $country_code = strtolower($_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us');
        if (seattle_warehouse('country_code',strtoupper($_SESSION['languages_code']))) {
            echo '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version('/includes/templates/fiberstore/css/shipping_delivery_local.css',$code).'" />';
        }elseif(all_german_warehouse('country_code',strtoupper($_SESSION['languages_code']))) {
            echo '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version('/includes/templates/fiberstore/css/shipping_delivery_local.css',$code).'" />';
        }else{
            echo '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version('/includes/templates/fiberstore/css/shipping_delivery.css',$code).'" />';
        }
        break;
    case 'quotes_create':
    case 'checkout':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/fs-public.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/checkout_new.css',$code).'" />';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/choose_time.css',$code).'">';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/jquery.datetimepicker.css',$code).'">';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/checkout/checkVat.js',$code).'"></script>';
        if($_GET['main_page'] == 'quotes_create'){
            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/createQuote.css',$code).'" />';
        }
        if(in_array($_SERVER["HTTP_HOST"], ['www.fs.com'])){
            echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/cdn_js/vue.pro.js', $code).'">';
        }else{
            echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/cdn_js/vue.dev.js', $code).'">';
        }
       break;
    case 'checkout_globalcollect_billing':
    case 'checkout_payment_against':
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/checkout.css',$code).'" />';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/checkout_new.css',$code).'" />';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/checkout.js', $code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/check_number.js',$code).'"></script>';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/choose_time.css',$code).'">';
        break;
    case 'delivery_method':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/Delivery_Method.css', $code).'" />';
        break;
    case 'partner_submit':
    case 'partner_update':
    case 'edit_my_account':
    case 'manage_addresses':
    case 'regist':
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/check_number.js',$code).'"></script>';
        break;
    case 'poe_series_switches';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/Poe_promotion.css',$code).'"/>  ';
        break;
    case 'support_detail':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('includes/templates/fiberstore/css/solutions_style.css',$code).'">';
        break;

    case 'new_product':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('includes/templates/fiberstore/css/new_product.css',$code).'" />';
        break;
    case 'customer_payment_link':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('includes/templates/fiberstore/css/customer_payment.css',$code).'">';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/clipboard_copy/clipboard.min.js',$code).'"></script>';
        break;
    case 'products_payment':
    case 'shopping_products':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('includes/templates/fiberstore/css/products_payment.css',$code).'">';
        break;
    case 'catalog_fiber':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/Resource_catalog.css',$code).'">';
        break;
    case 'tutorial_detail':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/list_product.css',$code).'">';
        break;
    case 'qc_development_detail':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.$code.auto_version('includes/templates/fiberstore/css/qc_development_style.css',$code).'">';
        break;
    case 'fs_special_page':
        if ($is_inquiry ==1) {
            echo '<link rel="stylesheet" type="text/css" href="'.auto_version('/includes/templates/fiberstore/css/inquiry.css').'">';
		    echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/pre_order_new.css').'">';
        }
        if($qa_product_id){
            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/product_detail.css',$code).'">';
        }
        echo '<link rel="stylesheet" href="'.auto_version($css_data).'">';
        break;
	case 'fs_single_pages':
//        if(in_array($_GET['name'],array('shipping_delivery'))){
//            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/alone_common.css',$code).'" />';
//        }
        foreach ($single_css_data as $key=>$value){
            $value = zen_change_url($value);
            echo '<link rel="stylesheet" href="'.auto_version($value,$code).'">';
        }
        break;
    case 'superior_10g_sfp_transceivers':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/10g_40g.css',$code).'">';
        break;
    case 'lc_special':
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/swiper-sweetalert2.css', $code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'" />';
        break;
    case 'wdm_optical_transport_platform':
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/sp_default.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/otn_platform.css',$code).'">';
        // echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/new_listPage.css',$code).'">';
        break;
    case 'fiber_lc_fc_3':
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/media.css',$code).'" />';
        break;
    case 'banner_fhd':
        echo '<link href="'.auto_version('includes/templates/fiberstore/css/fhs.css',$code).'" rel="stylesheet" type="text/css">';
        break;
    case 'dac_cables':
        echo '<link href="'.auto_version('includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'" rel="stylesheet" type="text/css">';
        break;
    case 'mtp_mpo_fiber_cabling':
    case '10g_sfp_transceivers':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'">';
        break;
    case 'data_center_switches':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/Secondary_classification.css',$code).'"/>';
        break;
    case 'copper_cabling_systems':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'">';
        break;
    case 'fiber_patch_cables':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'">';
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/fiber-patch-cables.css', $code).'">';
        break;
    case 'aoc':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/Secondary_classification.css',$code).'" />';
        break;
    case 'transport_network_specials':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/transport_network.css',$code).'">';
        break;
    case 'cleaning_tools':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/fiber_cleaner.css',$code).'" />';
        break;
    case 'enterprise_network_solution':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/Enterprise_Network.css',$code).'">';
        break;
    case 'fiber_optical_transceivers_solution':
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/sfp.css',$code).'">';
        break;
    case 'contact_us':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/new_alone_public.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/fs_contact_us.css',$code).'">';
        echo  '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/new_alone_public.css',$code).'"/>';
        echo '<script type="text/javascript" src="'.auto_version('/includes/templates/fiberstore/jscript/single/fs-policy.js',$code).'"></script>';
        break;
    case 'partner':
        //echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/partner.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/alone_common.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_single_page.css',$code).'">';
        break;
    case 'patch_panel':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/patch_panel.css',$code).'" />';
        break;
    case 'live_chat_service':
    case 'live_chat_service_phone':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/customer_service.css',$code).'" />';
        break;
    case 'warranty_brochure':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/return_policy.css',$code).'" />';
        break;
    case 'imprint':
    case 'product_video':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/list_product.css',$code).'">';
        break;
    case 'checkout_success':
    case 'checkout_success_purchase':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/choose_time.css',$code).'">';
        echo '<script src="'.auto_code_version('includes/templates/fiberstore/jscript/upload_check.js',$code).'"></script>';
        echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/upload_logo.js',$code).'"></script>';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/checkout.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/checkout_new.css',$code).'" />';
        break;
    case 'product_info':
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/choose_time.css',$code).'">';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/serch_result.css',$code).'">';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/product_detail.css',$code).'">';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/customer_qa.js',$code).'"></script>';
        if (isMobile()){
            echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/detilInfo.css',$code).'">';
            echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/reviews_tag.css',$code).'">';
        }
        break;
    case 'high_density_fiber_patching_solutions':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/hdscr.css',$code).'"/>';
        echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/optic_transceiver.css',$code).'">';
        break;
    case 'clearance':
    case 'clearance_list':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/clearance.css',$code).'"/>';
        break;
    case 'verify':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/verify.css', $code).'"/>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/specials/verify.js',$code).'"></script>';
        break;
    case 'shipping_delivery':
        echo  '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/shipping.css',$code).'"/>';
        echo  '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/new_alone_public.css',$code).'"/>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/single/fs-policy.js',$code).'"></script>';

//            echo  '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/shipping_delivery_local.css',$code).'"/>';
            echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/shipping_delivery_nation.js',$code).'"></script>';
//        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/Return_Policy.css').'"/>';
//        echo '<script type="text/javascript" src="'.auto_code_version('includes/templates/fiberstore/jscript/alone_page.js').'"></script>';
        if(in_array($_SESSION['languages_code'],array('sg')) || all_german_warehouse('country_code',$countryCode)){
            echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/country_select.js',$code).'"></script>';
        }
        break;

        break;
    case 'legal_notice':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/alone_common.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_code_version("includes/templates/fiberstore/css/alone_page/legal_notice.css").'">';
        break;
    case 'customer_service_others':
        echo '<link rel="stylesheet" href="'.auto_code_version("includes/templates/fiberstore/css/alone_page/apply_for.css").'" />';
        echo '<link rel="stylesheet" href="'.auto_code_version("includes/templates/fiberstore/css/login_register.css").'" />';
        break;
    case 'request_stock':
        echo  '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version("/includes/templates/fiberstore/css/choose_time.css",$code).'" />';
        break;
    case 'sfp_optical_module':
    case 'fs_n_series_cumulus_linux_switches':
        if ($_GET['main_page'] == 'sfp_optical_module'){
            echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/second_level_special.css',$code).'">';
            echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/sfp_optical_module.css',$code).'">';
            echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/product_detail.css',$code).'">';
            echo '<script type="text/javascript" src="'.auto_version('/includes/templates/fiberstore/jscript/product_list.js',$code).'"></script>';
            echo '<script type="text/javascript" src="'.auto_version('/includes/templates/fiberstore/jscript/product_details.js',$code).'"></script>';
        }elseif ($_GET['main_page'] == 'fs_n_series_cumulus_linux_switches'){
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/cooperationTopic.css',$code).'">';
        }
        if ($_GET['main_page'] != 'sfp_optical_module'){
            echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/solution-insidePage.css',$code).'">';
        }
        break;
    case 'fs_series_introduction':
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/specials/fs_series_introduction.css',$code).'">';
        break;
    case  'payment_methods':
        echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/policy/payment_methods.css', $code) . '">';
        echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/policy/new_alone_public.css', $code) . '">';
        echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/payment_methods.css', $code) . '">';


        //$warehouse = get_warehouse_by_code($_SESSION['countries_iso_code']);
        //if(1==0 && seattle_warehouse('country_code',strtoupper($_SESSION['countries_iso_code']))){
        //    echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/new_payment.css', $code) . '">';
        //}elseif($warehouse == 'de'  || in_array($_SESSION['languages_code'], array('uk', 'au', 'sg'))){
        //    echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/alone_common.css').'">';
        //    echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/Return_Policy.css').'">';
        //    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/alone_page.js',$code).'"></script>';
        //    if(in_array($_SESSION['languages_code'], array('uk','ru','fr'))){
        //        echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/all_style.css', $code) . '"/>';
        //    }
        //}elseif(($warehouse == 'cn' and $_SESSION['countries_iso_code'] != 'ru') || $warehouse == 'us' ){
        //    echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/alone_page/alone_common.css', $code) . '">';
        //    echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/alone_page/Return_Policy.css', $code) . '">';
        //    echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/payment.css', $code) . '">';
        //    echo '<script type="text/javascript" src="' . auto_version('includes/templates/fiberstore/jscript/alone_page.js', $code) . '"></script>';
        //}else{
        //    echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/alone_page/alone_common.css', $code) . '"/>';
        //    echo '<link rel="stylesheet" href="' . auto_code_version('includes/templates/fiberstore/css/alone_page/Return_Policy.css', $code) . '"/>';
        //    echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/payment.css', $code) . '"/>';
        //    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/alone_page.js',$code).'"></script>';
        //}
        break;

	case 'withdrawal':	//de和de-en站独有页面
        if($_SESSION['languages_code'] =='dn'){
            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/ab_public.css',$code).'" />';
            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/Withdrawal-de.css',$code).'" />';
        }elseif($_SESSION['languages_code'] =='de'){
            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/specials/Return_Policy.css',$code).'">';
            echo '<link href="'.auto_version('includes/templates/fiberstore/css/all_style.css',$code).'" rel="stylesheet" type="text/css" />';
        }
        break;
    case 'saved_cart_details':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new-shopcart.css',$code).'">';
        break;

    case 'email_subscription':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/media.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/sp_default.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/new-dwdm.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/my_dashboard.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/customer_service.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/account_settings_optimize.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/email_subscription.css',$code).'">';
        break;
    case 'confirm_unsubscribe':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/media.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/sp_default.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/new-dwdm.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/my_dashboard.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/customer_service.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/email_subscription.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/account_settings_optimize.css',$code).'">';
        break;
    case 'service_view_order_online':
        echo '<link href="'.auto_version('includes/templates/fiberstore/css/my_dashboard.css',$code).'" rel="stylesheet" type="text/css" />';
        echo '<link rel="stylesheet" href="'.auto_version('/includes/templates/fiberstore/css/media.css',$code).'" />';
        break;
    case 'visit_us':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/visit_us.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/choose_time.css',$code).'">';
        break;
    case 'on_site':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/service-apply-form.css',$code).'">';

    case 'product_support':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/product_support.css',$code).'">';
        echo '<script type="text/javascript" src="'.auto_version('/includes/templates/fiberstore/jscript/country_select.js', $code).'"></script>';
        break;

    case 'browsing_history':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/browsing_history.css',$code).'">';
        if($common_is_mobile){//m端
            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new-list-m.css',$code).'" />';
        }
        break;

    case 'purchase_order':
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/login_register.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/upload_check.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/service_data_time.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/country_select.js',$code).'"></script>';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/purchase_order.css',$code).'" />';
        break;

    case 'purchase_order_list':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/purchase_order.css',$code).'" />';
        echo '<script type="text/javascript" src="'.auto_code_version('includes/templates/fiberstore/jscript/upload_check.js').'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/service_data_time.js',$code).'"></script>';
        break;

    case 'customer_qa':
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/upload_check.js',$code).'"></script>';
    case 'qa_list':
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/customer_qa.js',$code).'"></script>';
        echo '<link rel="stylesheet" type="text/css" media="all" href="'.auto_version('/includes/templates/fiberstore/css/product_detail.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/qa_detail.css',$code).'" />';
        break;
    case 'solution_info':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/qa_detail.css',$code).'" />';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/product_detail.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/media.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/solution/case-solution-detail.css',$code).'">';
        break;
    case 'file_demonstration_po':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_file.css',$code).'">';
        break;
    case 'site_map':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/site_map.css',$code).'">';
        break;
    case 'network_solution':
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/upload_check.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/network_solution.js',$code).'"></script>';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/recommend_page.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/swiper-sweetalert2.css',$code).'" />';
        break;
    case 'offline_products_eos':
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/eos.css',$code).'">';
        break;
}

if($_SESSION['languages_code']!='en'){
    //外围页公共样式
    if(in_array($_GET['main_page'],array("faq","purchase_order","modern_slavery_statement")) ){
        echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/alone_common.css').'"/>';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/Return_Policy.css').'"/>';
        if(all_german_warehouse('country_code',$_SESSION['countries_iso_code']) || $_SESSION['languages_code'] =='au'){
            echo '<script type="text/javascript" src="'.auto_code_version('includes/templates/fiberstore/jscript/alone_page.js').'"></script>';
        }

    }

    if(in_array($_GET['main_page'],array("my_team"))){
        if($_SESSION['languages_code']=='mx'){
            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/about.css',$code).'"/>';
            echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/alone_page/ab_public.css',$code).'"/>';
        }else{
            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/about.css').'"/>';
            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/ab_public.css').'"/>';
        }

    }
//    if(in_array($_GET['main_page'],array('contact_us'))) {
//        if (in_array($_SESSION['languages_code'], array('uk', 'au', 'de', 'dn', 'it'))) {
//            echo '<link rel="stylesheet" href="' . auto_code_version('includes/templates/fiberstore/css/alone_page/contact_us.css') . '"/>';
//        } elseif (in_array($_SESSION['languages_code'], array('mx', 'jp'))) {
//            echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/alone_page/contact_us.css') . '"/>';
//            //array('es', 'fr','ru')的ru判断移到下面 勿删 @dori@2019/5/20
//        } elseif (in_array($_SESSION['languages_code'], array('es', 'fr'))) {
//            if (all_german_warehouse('country_code', $_SESSION['countries_iso_code'])) {
//                echo '<link rel="stylesheet" href="' . auto_code_version('includes/templates/fiberstore/css/alone_page/contact_us.css') . '"/>';
//            } else {
//                echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/alone_page/contact_us.css', $code) . '"/>';
//            }
//        }elseif (in_array($_SESSION['languages_code'], array('ru'))) {
//            echo '<link rel="stylesheet" href="' . auto_version('includes/templates/fiberstore/css/alone_page/contact_us.css', $code) . '"/>';
//        }
//    }
    if(in_array($_GET['main_page'],array('partner'))){
        if(all_german_warehouse('country_code',strtoupper($_SESSION['countries_iso_code'] )) || in_array($_SESSION['languages_code'],array('uk','au','ru'))){
//            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/alone_common.css').'">';
            echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/alone_page/business.css').'">';
        }

    }
}

// 公共的可以用上面的写法
// 下面是：单独样式
// 以样式文件为对象，一个条件是一个样式
// 账户中心
// 国家选择的样式
if(in_array($_GET['main_page'],array('manage_addresses','sales_service_info','sales_service_details','product_info','inquiry_out','inquiry','advanced_search_result','custom_fiber_cable_assemblies','custom_fiber_optic_transceivers','my_cases','customer_qa','sample_application')) && !$this_is_home_page){
    //echo '<link href="'.auto_version('includes/templates/fiberstore/css/manage_addresses.css',$code).'" media="all" type="text/css" rel="stylesheet">';
}
if(in_array($_GET['main_page'],array('edit_my_account'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/email_subscription.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/account_settings_optimize.css',$code).'">';
}


// 注册登录相关样式
if(in_array($_GET['main_page'],array('login','login_guest','regist','partner_submit','partner_update','shopping_products','products_payment','purchase_order'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/login_register.css',$code).'">';
}

// 用户报价样式
if(in_array($_GET['main_page'],array('inquiry','inquiry_out'))){

    if($_GET['main_page']=='inquiry_out'){
        echo '<link rel="stylesheet" href="'.auto_code_version('includes/templates/fiberstore/css/my_dashboard.css').'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/inquiry.css',$code).'">';
    }else{
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/upload_check.js',$code).'"></script>';
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/inquiry/inquiry_new.js',$code).'"></script>';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_request_quote.css',$code).'">';
    }
}
if(in_array($_GET['main_page'],array('inquiry_detail'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/inquiry_detail.css',$code).'">';
}
if(in_array($_GET['main_page'],array('sample_application','live_chat_service_mail','solution_support'))) {
    //echo '<link href="'.auto_code_version('/includes/templates/fiberstore/css/all_style.css').'" rel="stylesheet" type="text/css" />';
    //echo '<link rel="stylesheet" type="text/css" media="all" name="go_phone" href="'.auto_version('/includes/templates/fiberstore/css/media.css',$code) .'">
    //        <link rel="stylesheet" href="includes/templates/fiberstore/css/Sample_application.css">';
    echo '<link href="'.auto_code_version('/includes/templates/fiberstore/css/request-support.css').'" rel="stylesheet" type="text/css" />';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/Sample_application.css',$code).'">';
}
echo '<script  type="text/javascript"> var country_search_str = "'.FS_SEARCH_YOUR_COUNTRY.'"; </script>';

//登录相关页面RSA前端加密
if(in_array($_GET['main_page'],array('regist', 'login', 'login_guest', 'inquiry', 'partner_submit', 'checkout_guest',"checkout",'checkout_new','quotes_create',"new_checkout", 'shopping_products', 'products_payment','purchase_order','sample_application'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/rsa/jsbn.js', $code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/rsa/prng4.js', $code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/rsa/rng.js', $code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/rsa/rsa.js', $code).'"></script>';
}

//首页
if($this_is_home_page){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/fs_home.css',$code).'" />';
    if(!$common_is_mobile) { // pc
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new_index.css',$code).'">';
        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/media.css',$code).'">';
    }else{
//        echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/index-wap.css',$code).'">';
    }
}

//上传文件相关页面对文件类型验证

if(in_array($_GET['main_page'],array('manage_orders', 'manage_orders_offline', 'account_history_info', 'account_offline_history_info','edit_my_account','inquiry','submit_review','submit_orders_review','sales_service_info','my_cases','my_cases_details','solution_support','customer_service_others','inquiry_out','orders_review','manage_orders','my_dashboard','product_info','live_chat_service_mail','sales_service_list'))){
    echo '<script type="text/javascript" src="'.auto_code_version('includes/templates/fiberstore/jscript/upload_check.js').'"></script>';
}

if(in_array($_GET['main_page'],array('submit_review'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/reviews.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/reviews_tag.css',$code).'">';
}

if(in_array($_GET['main_page'],array('orders_review'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/reviews_tag.css',$code).'">';
}

// 专题
if(in_array($_GET['main_page'],array('1g_sfp_transceivers','price_distribution'))) {
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/second_level_special.css',$code).'">';
}



// 2018.11.29 fairy 个人中心改版
if (in_array($_GET['main_page'], $member_center_page)) {
    echo '<link href="' . auto_version('includes/templates/fiberstore/css/public_account.css', $code) . '" rel="stylesheet" type="text/css" />';
    echo '<link href="' . auto_version('includes/templates/fiberstore/css/account_center_new.css', $code) . '" rel="stylesheet" type="text/css" />';
}
//订单列表页和详情页buy more成功后的QV弹窗样式表
if(in_array($_GET['main_page'],array('account_history_info','manage_orders','manage_orders_offline'))){
    echo '<link href="' . auto_version('includes/templates/fiberstore/css/account_orders_qv.css', $code) . '" rel="stylesheet" type="text/css" />';
}

if(in_array($_GET['main_page'],array('account_history_info','orders_review'))){ //上传图片预览需要
    echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/m_pic/photoswipe.css', $code).'"/>
	<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/specials/m_pic/default-skin.css', $code).'"/>';
}
if (in_array($_GET['main_page'],array('print_shipping_label'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/footer.js',$code).'"></script>';
}

// 2019.1.23 data center专题
if(in_array($_GET['main_page'],array('data_center'))) {
    echo  '<link rel="stylesheet" type="text/css" media="all"  href="'.auto_version("/includes/templates/fiberstore/css/specials/data-center.css",$code).'" />';
}

// 2019.1.17 购物车改版样式调用转移过来
if(in_array($_GET['main_page'],array('shopping_cart','save_shopping_list'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/jscript/layer/theme/default/layer.css', $code).'" id="layuicss-layer">
    <link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new-shopcart.css',$code).'">';
}

//2019.0309 e_rate单页面
if(in_array($_GET['main_page'],array('e_rate'))){
    //
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/new_alone_public.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/policy/fs_tare.css',$code).'">';
}

//打印相关页面
if(in_array($_GET['main_page'],array('print_shipping_label','print_main_order','print_shopping_list','shopping_products','print_get_a_quote','print_service_order', 'print_checkout_success'))){
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/fs_print.css',$code).'">';
}

// 专题
if(in_array($_GET['main_page'],array('checkout_success'))) {
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/checkoutFooter.css',$code).'" />';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/checkoutFooter.js',$code).'"></script>';
}

if (in_array($_GET['main_page'], array('view_reviews'))) {
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/m_pic/photoswipe.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/specials/m_pic/default-skin.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/view_reviews.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/swiper-sweetalert2.css',$code).'">';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/cdn_js/js_cdn.js', $code).'"></script>';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/specials/m_pic/photoswipe.min.js', $code).'"></script>';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/specials/m_pic/photoswipe-ui-default.min.js', $code).'"></script>';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/view_reviews.js', $code).'"></script>';
}
if (in_array($_GET['main_page'], array('orders_review_list'))) {
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/view_reviews.css',$code).'">';
}
//
if(in_array($_GET['main_page'],array('my_companies'))){ //上传图片预览需要
    echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/my_companies.css',$code).'"/>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/my_companies.js',$code).'"/></script>';
}

// 产品列表页、搜索
if($_GET['main_page']=='advanced_search_result') {
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/new-list-m.css',$code).'">';
    echo '<link rel="stylesheet" href="'.auto_version('includes/templates/fiberstore/css/serch_result.css',$code).'">';
}

?>

<?php
//手机端样式  可以放到所有样式的底下 最后调用
if(isMobile() && !$_COOKIE['c_site']) { ?>

    <?php if(in_array($_GET['main_page'],array('nationality'))){ ?>
        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/select-country.css',$code);?>" />
    <?php }else{?>
        <link rel="stylesheet" type="text/css" media="all" name="go_phone" href="<?php echo auto_version('/includes/templates/fiberstore/css/media.css',$code);?>" />

<?php }}?>

<?php
if (in_array($_GET['main_page'], ['inquiry_request_edit'])) {
    echo '<link rel="stylesheet" type="text/css" href="'.auto_version('includes/templates/fiberstore/css/edit_quote.css',$code).'"/>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/inquiry/inquiry_new.js',$code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/edit_quote.js',$code).'"></script>';
}
?>
