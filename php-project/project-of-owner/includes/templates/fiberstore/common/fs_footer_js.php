<?php
// 公共的底部js
// 改公共js的版本号比较方便

//公共的数据
// 是否是手机
$is_mobile = isMobile();
$common_is_mobile = (!$is_mobile || isset($_COOKIE['c_site']))?0:1;
// 弹窗js
// 现在尾部增加反馈弹窗，有公共尾部的都有需要这个js。所以用的不包含
echo '<script type = "text/javascript" src = "'.auto_version('includes/templates/fiberstore/jscript/sweetalert2.min.js', $code).'" ></script>';

// validate验证表单js
// 现在尾部增加反馈弹窗，有公共尾部的都有需要这个js。所以用的不包含
echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/jquery.validate.js',$code).'"></script>';
echo '<script>
    var FStax_error = "'.FS_CHECKOUT_ERROR_VAT.'";
    var FStax_error_argentina = "'.FS_TAX_FORMAT_ARGENTINA_TIP.'";
    var FStax_error_brazil = "'.FS_TAX_FORMAT_BRAZIL_TIP.'";
    var FStax_error_chile = "'.FS_CHECKOUT_VAX_CH.'";
</script>';
echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/jquery.validate.myadd.js',$code).'"></script>';

// 国家选择的js
if(in_array($_GET['main_page'],array('login','login_guest','regist','partner_submit','partner_update','sample_application','inquiry','inquiry_out','customer_qa','manage_addresses','product_info','edit_my_account','advanced_search_result','products_payment','shopping_products','customer_service_others','request_stock','index','advanced_search_result','customer_payment_link')) && !$this_is_home_page ) {
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/country_select.js',$code).'"></script>';
}

if(!$common_is_mobile&&in_array($_GET['main_page'],array('login','login_guest'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/login.js', $code).'"></script>';
}else if ($common_is_mobile&&in_array($_GET['main_page'],array('login','login_guest'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/login_m.js', $code).'"></script>';
}


if(!$common_is_mobile&&in_array($_GET['main_page'],array('regist'))){
//    echo "<script src=\"https://www.recaptcha.net/recaptcha/api.js\" async defer></script>";
    if (FS_RECAPTCHA_SWITCH > 0) {
        if ($language_code_verify !== 'cn') {
            echo '<script src="https://www.google.com/recaptcha/api.js?hl=' . $language_google_code . ' async defer"></script>';
        } else {
            echo '<script src="https://www.recaptcha.net/recaptcha/api.js?hl=' . $language_google_code . ' async defer"></script>';
        }
    }
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/register.js',$code).'"></script>';
}else if ($common_is_mobile&&in_array($_GET['main_page'],array('regist'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/register_m.js', $code).'"></script>';
}
if(in_array($_GET['main_page'],array('products_payment','shopping_products'))){
    if (FS_RECAPTCHA_SWITCH > 0) {
        if ($language_code_verify !== 'cn') {
            echo '<script src="https://www.google.com/recaptcha/api.js?hl=' . $language_google_code . ' async defer"></script>';
        } else {
            echo '<script src="https://www.recaptcha.net/recaptcha/api.js?hl=' . $language_google_code . ' async defer"></script>';
        }
    }
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/login_register.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('partner_submit','partner_update'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/partner_submit.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('advanced_search_result')) || ($_GET['main_page']=='product_info' && $products_page_state==3) ){ //搜索和产品详情页面共用
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/search/search_offline_products.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('customer_qa'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/customer_qa.js',$code).'"></script>';
}
if($this_is_home_page){
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/index.js',$code).'"></script>';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/product_list.js',$code).'"></script>';
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('edit_my_account'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/account/editAccount.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('inquiry'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/inquiry/inquiry.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('inquiry_detail','inquiry_list','my_dashboard'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/inquiry/inquiry_detail.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('inquiry_out'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/inquiry/inquiry_out.js',$code).'"></script>';
}
if (in_array($_GET['main_page'], ['submit_review'])){
    echo '<script type="text/javascript" src="'.auto_version('includes\templates\fiberstore\jscript\account\account_common_bubble.js',$code).'"></script>';
}

if(in_array($_GET['main_page'],array('product_info'))  && $products_page_state==1 ){ //正常产品的js
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/product_details.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/product_reviews.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('shopping_cart'))){
	echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/country_select.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>
		  <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/layer/layer_renamed.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('wdm_optical_transport_platform','gr_series_cabinet','fs_n_series_cumulus_linux_switches','clearance','clearance_list'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>';
}
if (in_array($_GET['main_page'], array('fs_special_page'))) {
    $special_id = $_GET['id'];
    if($special_id==60){
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/specials/second_level_special.js',$code).'"></script>';
    }
    if($quote_product_details_js){
        //tag 产品树的js
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/special_tag.js',$code).'"></script>';
    }
}
if(in_array($_GET['main_page'],array('customer_service_others'))){
    echo '<script type="text/javascript" src="'.auto_code_version('includes/templates/fiberstore/jscript/customer_service_others.js').'"></script>';
}

//产品列表、搜索页面js
if(in_array($_GET['main_page'],array('index','advanced_search_result')) && !$this_is_home_page){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/categories_list_page.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('advanced_search_result','advanced_search_offline_products','index','wdm_optical_transport_platform','product_info','data_center','gr_series_cabinet','clearance','clearance_list','fs_n_series_cumulus_linux_switches','tutorial_detail','account_history_info','new_product','manage_orders','manage_orders_offline')) && !$this_is_home_page){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/product_list.js',$code).'"></script>';
}

// 2019.11.22 aron 个人中心改版
if ($_GET['main_page'] == 'orders_review') {
    echo  '<script type="text/javascript" src="'.auto_version("includes/templates/fiberstore/jscript/reviews_tag.js",$code).'"></script>';
}
if(in_array($_GET['main_page'],array('orders_review','orders_review_list','view_reviews'))){
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/specials/m_pic/photoswipe-ui-default.min.js', $code).'"></script>
    <script src="'.auto_version('includes/templates/fiberstore/jscript/specials/m_pic/photoswipe.min.js', $code).'"></script>
    <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/account/orderReview.js',$code).'"></script>
    <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/layer/layer_renamed.js',$code).'"></script>';
}
if($_GET['main_page'] == 'submit_review'){
    echo  '<script type="text/javascript" src="'.auto_version("includes/templates/fiberstore/jscript/submit_reviews.js",$code).'"></script>';
    echo  '<script type="text/javascript" src="'.auto_version("includes/templates/fiberstore/jscript/reviews_tag.js",$code).'"></script>';
}
if(in_array($_GET['main_page'],array('manage_addresses','sales_service_info','sales_service_details','sales_service_success'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/address_common.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('manage_addresses'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/member/manage_address.js',$code).'"></script>';
//    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/rma.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('my_cases','my_cases_details','purchase_order_list','my_dashboard'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/account/caseCenter.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('tax_exemption'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/account/taxExemption.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('account_offline_history_info','account_history_info','manage_orders','manage_orders_offline'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/account/accountHistoryCommon.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('account_history_info','manage_orders','manage_orders_offline','account_offline_history_info','my_dashboard','shopping_products','purchase_order_list','purchase_order_details'))){   //共用操作
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/member/account_history_common.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/currencyFormatter.min.js',$code).'"></script>';
}
if(in_array($_GET['main_page'],array('account_history_info'))){ // 其他操作，例如：上传定制logo需要
    echo '<script src="'.auto_version('includes/templates/fiberstore/jscript/specials/m_pic/photoswipe-ui-default.min.js', $code).'"></script>
    <script src="'.auto_version('includes/templates/fiberstore/jscript/specials/m_pic/photoswipe.min.js', $code).'"></script>
	<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/upload_logo.js',$code).'"></script>
	<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/member/account_history_info.js',$code).'"></script>';
}

if(in_array($_GET['main_page'],array('manage_orders', 'manage_orders_offline'))) { // 其他操作，例如搜索操作
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/member/manage_orders.js',$code).'"></script>';
}
// 2018.12.18 Quest 退换货
if (in_array($_GET['main_page'],array('sales_service_list','sales_service_info','sales_service_details','sales_service_request_list','sales_service_success'))){
    if(in_array($_GET['main_page'],['sales_service_list','sales_service_request_list'])){
        echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/new_file.js',$code).'"></script>';
    }
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/return_oreders.js',$code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/rma.js',$code).'"></script>';
}



if(in_array($_GET['main_page'],array('visit_us'))){
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/choose_time.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/jquery.validate.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/jquery.validate.myadd.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/choose_time.js',$code).'"></script>
          <script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/country_select.js',$code).'"></script>';
}
//账户中心所有页面统一加载M端气泡点击js
if(in_array($_GET['main_page'], $member_center_page)  && $_GET['main_page'] !='edit_my_account') {
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/account/account_common_bubble.js', $code).'"></script>';
}
if($_GET['main_page'] == 'sample_application'){
    echo '<script type="text/javascript" src="'.auto_version('/includes/templates/fiberstore/jscript/sample_application.js',$code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('/includes/templates/fiberstore/jscript/inquiry/inquiry_new.js',$code).'"></script>';
    echo '<script type="text/javascript" src="'.auto_version('includes/templates/fiberstore/jscript/login_register/login_register.js',$code).'"></script>';
}

if ($_GET['main_page'] == 'solution_info'){
    echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/solution/case-solution-detail.js',$code).'"></script>';
    echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/product_details.js',$code).'"></script>';
    echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/customer_qa.js',$code).'"></script>';
}

if (in_array($_GET['main_page'], ['quotes_list', 'quotes_details', 'inquiry_list', 'inquiry_detail'])){
    echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/quotes_click_log.js',$code).'"></script>';
    echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/account_new.js',$code).'"></script>';
    echo '<script src="'.auto_version('/includes/templates/fiberstore/jscript/quotes.js',$code).'"></script>';
}

?>
