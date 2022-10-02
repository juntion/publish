<?php
  require_once 'includes/application_top.php';
  $categories_id = $_GET['cPath'];
  $customerInfo = fs_get_data_from_db_fields_array(['customers_id', 'customers_number_new', 'is_disabled'],'customers','customers_email_address = "'.$email.'"','limit 1');
  $customer_number_new = $customerInfo[0][1];
  $cart_count = $_SESSION['cart']->count_contents();
  $common_current_username = $_SESSION['customer_first_name'].' '.$_SESSION['customer_last_name'];

  // meta标签
  $_GET['main_page'] = 'index';
  $_GET['s_cid'] = $categories_id;
  require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
?>
<!DOCTYPE html>
<html ⚡="" lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <script async="" src="https://cdn.ampproject.org/v0.js"></script> 
  <title><?php echo META_TAG_TITLE;?></title> 
  <link rel="canonical" href="<?php echo zen_href_link(FILENAME_DEFAULT,'&cPath='.$categories_id,'SSL');?>" /> 
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" /> 
  <script async="" custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script> 
  <script async="" custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script> 
  <script async="" custom-element="amp-list" src="https://cdn.ampproject.org/v0/amp-list-0.1.js"></script> 
  <script async="" custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script> 
  <script async="" custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script> 
  <script async="" custom-element="amp-lightbox" src="https://cdn.ampproject.org/v0/amp-lightbox-0.1.js"></script> 
  <script async="" custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script> 
  <script async="" custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script> 
  <script async="" custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script> 
  <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "headline": "Article headline",
        "image": ["thumbnail1.jpg"],
        "datePublished": "2015-02-05T08:00:00+08:00"
      }
    </script> 
  <style amp-boilerplate="">
      body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
  </style> 
  <!-- AMP Analytics -->
  <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
  <noscript> 
   <style amp-boilerplate="">
        body {
          -webkit-animation: none;
          -moz-animation: none;
          -ms-animation: none;
          animation: none;
        }
      </style> 
  </noscript> 
  <style amp-custom="">
      @font-face{font-weight:400;font-style:normal;font-family:"Open Sans";src:url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans.woff2);src:local("Open Sans"),local("OpenSans"),url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans.woff2) format("woff2")}@font-face{font-weight:300;font-style:normal;font-family:"Open Sans";src:local("Open Sans Light"),local("OpenSans-Light"),url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans-light-webfont.woff2) format("woff2")}@font-face{font-weight:600;font-style:normal;font-family:"Open Sans";src:local("opensans semibold webfont"),local("opensans-semibold-webfont"),url(https://img-en.fs.com/includes/templates/fiberstore/images/opensans-semibold-webfont.woff2) format("woff2");font-display:swap}a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,button,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,input,ins,kbd,label,legend,li,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,select,small,span,strike,strong,sub,summary,sup,table,tbody,td,textarea,tfoot,th,thead,time,tr,tt,u,ul,var,video{-webkit-box-sizing:border-box;box-sizing:border-box;margin:0;padding:0;outline:0;border:0;border:none;font-style:normal;font-size:100%;font-family:"Open Sans",Arial,Helvetica,sans-serif;-webkit-appearance:none;-webkit-tap-highlight-color:transparent;-webkit-text-size-adjust:none;-webkit-font-smoothing:antialiased}body,html{width:100%;background:#fff;-webkit-overflow-scrolling:touch}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:after,blockquote:before,q:after,q:before{content:"";content:none}table{border-collapse:collapse;border-spacing:0}textarea{overflow:auto;vertical-align:top;resize:vertical}[hidden]{display:none}a:active,a:hover{outline:0}img{border:0}button,input,select,textarea{outline:0;border:none;background:0 0;-webkit-appearance:none;-moz-appearance:none;appearance:none}button,input{line-height:normal}button::-moz-focus-inner,input::-moz-focus-inner{padding:0;border:0}table{border-collapse:collapse;border-spacing:0}a{text-decoration:none}.fixScroll{position:fixed;width:100%}image{image-rendering:-moz-crisp-edges;image-rendering:-o-crisp-edges;image-rendering:-webkit-optimize-contrast;image-rendering:crisp-edges;-ms-interpolation-mode:nearest-neighbor}input:-webkit-autofill,input:-webkit-autofill:active,input:-webkit-autofill:focus,input:-webkit-autofill:hover{-webkit-box-shadow:0 0 0 1000px #fff inset}.clear-after:after{clear:both;display:block;visibility:hidden;height:0;content:" "}.fs_header{position:relative;width:100%;height:48px}.fs_header .header{position:relative;position:fixed;top:0;left:0;z-index:1000;display:-webkit-box;display:-ms-flexbox;display:flex;padding:0 15px;width:100%;height:48px;background:#fff;-webkit-box-shadow:0 1px 4px 0 rgba(0,0,0,.1);box-shadow:0 1px 4px 0 rgba(0,0,0,.1);-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.fs_header .header .menu{position:relative;width:24px}.fs_header .header .menu .line{display:block;margin:6px auto;width:24px;height:2px;border-radius:2px;background:#3b3e40;-webkit-transition:all .3s ease-in-out;-o-transition:all .3s ease-in-out;transition:all .3s ease-in-out}.fs_header .header .menu.menu_active .line.line1{-webkit-transform:translateY(8px) rotate(45deg);transform:translateY(8px) rotate(45deg);-ms-transform:translateY(8px) rotate(45deg)}.fs_header .header .menu.menu_active .line.line2{opacity:0}.fs_header .header .menu.menu_active .line.line3{-webkit-transform:translateY(-8px) rotate(-45deg);transform:translateY(-8px) rotate(-45deg);-ms-transform:translateY(-8px) rotate(-45deg)}.fs_header .header .logo{position:absolute;left:50%;display:inline-block;width:56px;height:27px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/logo.png);background-position:center;background-size:contain;background-repeat:no-repeat;-webkit-transform:translateX(-50%);transform:translateX(-50%);-ms-transform:translateX(-50%)}.fs_header .header .right_box{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-transition:all .5s;-o-transition:all .5s;transition:all .5s;-ms-flex-negative:0;flex-shrink:0;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_header .header .right_box.visible{opacity:1}.fs_header .header .right_box.invisible{opacity:0}.fs_header .header .right_box .search{display:inline-block;margin-right:10px;width:20px;height:20px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/header_search.svg);background-position:center;background-size:contain;background-repeat:no-repeat}.fs_header .header .right_box .to_cart{position:relative;display:inline-block;margin-right:0;width:22px;height:22px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/cart.svg);background-position:center;background-size:contain;background-repeat:no-repeat}.fs_header .header .right_box .to_cart .cart_num{position:absolute;top:-6px;right:-10px;display:inline-block;margin-left:1px;padding:0 5px;height:16px;min-width:16px;border-radius:16px;background:#c00000;color:#fff;text-align:center;font-size:12px;line-height:16px;-webkit-transform-origin:50% 50%;transform-origin:50% 50%;word-break:normal;-ms-transform-origin:50% 50%}.fs_header .header .right_box.invisible .to_cart .cart_num{display: none;} .sidebar_category{top:48px;z-index:50;width:100%;max-width:100%;background-color:#fff}.arrow_right{display:inline-block;width:8px;height:14px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/right.svg);background-position:center;background-size:contain;background-repeat:no-repeat}.arrow_left{display:inline-block;width:8px;height:14px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/left.svg);background-position:center;background-size:contain;background-repeat:no-repeat}.account_box .back_btn{display:-webkit-box;display:-ms-flexbox;display:flex;padding:0 30px;height:68px;border-bottom:1px solid #f7f7f7;color:#232323;font-size:16px;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.sidebar_category .help_second_box .back_btn{font-weight:600}.account_box .back_btn .arrow_left{margin-right:8px}.account_box .back_btn:hover{background-color:#f7f7f7}.sidebar_category .sidebar_category_info{-webkit-box-flex:1;-ms-flex:1;flex:1}.sidebar_category .user_box{border-bottom:10px solid #f7f7f7}.sidebar_category .user_box .login_box{display:-webkit-box;display:-ms-flexbox;display:flex;display:flex;padding:0 30px;height:60px;background:#fff;color:#232323;font-size:14px;line-height:60px;cursor:pointer;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.sidebar_category .user_box .login_box .account_icon{display:inline-block;margin-right:12px;width:16px;height:18px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/account.svg);background-position:center;background-size:contain;background-repeat:no-repeat}.sidebar_category .help_box{padding:10px 0;border-bottom:10px solid #f7f7f7}.sidebar_category .help_box_title{padding:0 30px;color:#232323;font-weight:600;font-size:16px;line-height:52px}.sidebar_category .help_box_list .help_item{position:relative;display:block;padding:0 30px;color:#232323;font-size:14px;cursor:pointer}.sidebar_category .help_box_list .help_item>div{display:-webkit-box;display:-ms-flexbox;display:flex;height:51px;border-bottom:1px solid #f7f7f7;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.sidebar_category .contact_box{display:-webkit-box;display:-ms-flexbox;display:flex;padding:15px 30px 50px 30px;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.sidebar_category .contact_box .contact_item{display:-webkit-box;display:-ms-flexbox;display:flex;outline:0;color:#232323;text-decoration:none;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.sidebar_category .contact_box .contact_item .contact_item_icon{display:-webkit-box;display:-ms-flexbox;display:flex;width:54px;height:54px;border-radius:50%;background:#f7f7f7;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.sidebar_category .contact_box .contact_item .contact_item_info{margin-top:10px;color:#616265;font-size:14px;line-height:22px}.account_box{position:fixed;top:48px;right:0;bottom:0;left:0;z-index:60;display:block;overflow-y:auto;background:#fff;-webkit-transition:all .3s;-o-transition:all .3s;transition:all .3s;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}.account_box .account_item{display:-webkit-box;display:-ms-flexbox;display:flex;padding:0 15px 0 30px;height:51px;color:#232323;font-size:14px;cursor:pointer;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.account_box .account_item:last-child{border-top:1px solid #e5e5e5}.account_box.help_second_box .account_item>div{display:-webkit-box;display:-ms-flexbox;display:flex;width:100%;height:51px;border-bottom:1px solid #f7f7f7;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.account_box.help_second_box .account_item:last-child{border-top:none;border-bottom:1px solid #f7f7f7}.account_box.help_second_box .account_item:last-child>div{border-bottom:none}.account_box .account_item .account_item_info{-webkit-box-flex:1;-ms-flex:1;flex:1}.account_box .account_item .account_item_info_sub{color:#999;font-size:14px}.account_box .account_item .icon{display:inline-block;margin-right:15px;width:16px;height:40px;background-position:center;background-size:contain;background-repeat:no-repeat}.account_box .account_item .icon.login_account{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/login_account.svg)}.account_box .account_item .icon.setting{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/setting.svg)}.account_box .account_item .icon.order{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/order.svg)}.account_box .account_item .icon.quote{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/quote.svg)}.account_box .account_item .icon.saved{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/save.svg)}.account_box .account_item .icon.history{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/history.svg)}.account_box .account_item .icon.log_out{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/sign_out.svg)}.fs_content{background:#f7f7f7}.fs_content .list_top{margin-bottom:15px;padding:18px 15px 10px 15px;background:#fff}.fs_content .list_top .list_title{padding-bottom:10px;color:#232323;font-weight:600;font-size:20px;line-height:30px}.fs_content .list_top .list_filter_box{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.fs_content .list_top .list_filter_box .left{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_content .list_top .list_filter_box .left .filter_icon{display:inline-block;margin-right:6px;width:20px;height:21px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/filter.svg);background-position:center;background-size:contain;background-repeat:no-repeat}.fs_content .list_top .list_filter_box .left .filter_info{color:#232323;font-size:14px}.fs_content .list_top .list_filter_box .right>span{display:inline-block;margin-left:10px;width:20px;height:21px;background-position:center;background-size:contain;background-repeat:no-repeat}.fs_content .list_top .list_filter_box .right>span.row{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/row.svg)}.fs_content .list_top .list_filter_box .right>span.column{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/column_select.svg)}.fs_content .list_top .list_filter_box.list_filter_box_row .right>span.row{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/row_select.svg)}.fs_content .list_top .list_filter_box.list_filter_box_row .right>span.column{background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/column.svg)}.fs_content .list_content [role=list]{display:-webkit-box;display:-ms-flexbox;display:flex;min-height:200px;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.fs_content .list_content amp-list{position:relative;height:auto}.fs_content .list_content .product_item{display:-webkit-box;display:-ms-flexbox;display:flex;margin-bottom:1px;padding:15px;width:100%;width:100%;border-radius:2px;background:#fff;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start}.fs_content .list_content .product_item .product_img_wrap{padding-right:15px;-webkit-box-flex:0;-ms-flex:0 0 135px;flex:0 0 135px}.fs_content .list_content .product_item .product_img_wrap .product_img_box{position:relative;width:120px;height:120px}.fs_content .list_content .product_item .product_img_wrap .product_img_box .product_img{position:relative;z-index:1;display:block}.fs_content .list_content .product_item .product_img_wrap .product_img_box .video_btn_box{position:absolute;right:-15px;bottom:0;z-index:2;display:inline-block;height:16px}.fs_content .list_content .product_item .product_img_wrap .product_img_box .video_btn{position:relative;display:inline-block;width:25px;height:16px;border:1px solid #9f9f9f;border-radius:12px;-webkit-transition:all .3s;-o-transition:all .3s;transition:all .3s}.fs_content .list_content .product_item .product_img_wrap .product_img_box .video_btn>span{position:absolute;top:50%;left:50%;display:block;margin-top:-5px;margin-left:-2px;width:0;height:0;border-top:5px solid transparent;border-right:5px solid transparent;border-bottom:5px solid transparent;border-left:7px solid #9f9f9f;-webkit-transition:all .3s;-o-transition:all .3s;transition:all .3s}.fs_content .list_content .product_item .product_img_wrap .brand_box{display:-webkit-box;display:-ms-flexbox;display:flex;margin-top:5px;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.fs_content .list_content .product_item .product_img_wrap .brand_box .brand_item{display:inline-block;margin-right:5px;padding:0 10px;height:30px;border:1px solid #ccc;border-radius:2px;color:#4a4a4a;font-size:13px;line-height:28px;cursor:pointer}.fs_content .list_content .product_item .product_img_wrap .brand_box .brand_item.brand_item_bg_2{background:#f7f7f7}.fs_content .list_content .product_item .product_img_wrap .brand_box .brand_item:last-child{margin-right:0}.fs_content .list_content .product_item .product_img_wrap .brand_box .brand_item:first-child{border:2px solid #616265;line-height:26px}.fs_content .list_content .product_item .product_content{overflow:hidden;padding-left:15px;-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto}.fs_content .list_content .product_item .product_content .product_title{display:-webkit-box;overflow:hidden;margin-bottom:10px;height:60px;min-height:40px;outline:0;color:#232323;color:#232323;text-decoration:none;font-weight:400;font-size:14px;line-height:20px;-webkit-box-orient:vertical;-webkit-line-clamp:3}.fs_content .list_content .product_item .product_content .product_apply{overflow:hidden;margin-bottom:7px;max-height:30px;color:#8d8d8f;white-space:pre-wrap;font-size:13px;cursor:default}.fs_content .list_content .product_item .product_content .product_feature{overflow:hidden;margin-bottom:16px;width:100%;max-height:20px}.fs_content .list_content .product_item .product_content .product_feature_item{display:inline-block;overflow:hidden;margin-right:6px;padding:0 6px;max-width:100%;background-color:#efefef;color:#8d8d8f;text-overflow:ellipsis;white-space:nowrap;font-size:13px;line-height:20px;-o-text-overflow:ellipsis}.fs_content .list_content .product_item .product_content .product_price{color:#232323;font-size:14px;line-height:20px}.fs_content .list_content .product_item .product_content .score_box{display:-webkit-box;display:-ms-flexbox;display:flex;margin-bottom:6px;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_content .list_content .product_item .product_content .score_box .score_icon_box{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_content .list_content .product_item .product_content .score_box .score_icon{display:inline-block;margin-right:3px;width:11px;height:11px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/gray_star.svg);background-position:center;background-size:100% 100%;background-repeat:no-repeat}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_1 .score_icon:nth-child(1){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_2 .score_icon:nth-child(1){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_2 .score_icon:nth-child(2){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_3 .score_icon:nth-child(1){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_3 .score_icon:nth-child(2){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_3 .score_icon:nth-child(3){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_4 .score_icon:nth-child(1){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_4 .score_icon:nth-child(2){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_4 .score_icon:nth-child(3){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_4 .score_icon:nth-child(4){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_5 .score_icon:nth-child(1){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_5 .score_icon:nth-child(2){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_5 .score_icon:nth-child(3){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_5 .score_icon:nth-child(4){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_icon_box_5 .score_icon:nth-child(5){background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yellow_star.svg)}.fs_content .list_content .product_item .product_content .score_box .score_num{display:inline-block;margin-top:2px;margin-left:3px;color:#999;font-size:12px}.fs_content .list_content .product_item .product_content .stock_box{color:#666;font-size:12px;line-height:16px}.fs_content .list_content .product_item .product_content .stock_box .instock{color:#8d8d8f}.fs_content .list_content.list_content_row [role=list]{display:-webkit-box;display:-ms-flexbox;display:flex;width:100%;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.fs_content .list_content.list_content_row .product_item{display:-webkit-box;display:-ms-flexbox;display:flex;margin-bottom:0;padding:15px;width:50%;border-right:1px solid #f7f7f7;border-bottom:1px solid #f7f7f7;border-radius:2px;background:#fff;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.fs_content .list_content.list_content_row .product_item:nth-child(2n){border-right:none}.fs_content .list_content.list_content_row .product_item .product_img_wrap{margin-bottom:10px;padding-right:0;width:100%}.fs_content .list_content.list_content_row .product_item .product_img_wrap .product_img_box{position:relative;margin:0 auto;width:120px;height:120px}.fs_content .list_content.list_content_row .product_item .product_img_wrap .product_img_box .video_btn_box{position:absolute;right:-15px;bottom:0;display:inline-block;height:16px}.fs_content .list_content.list_content_row .product_item .product_img_wrap .product_img_box .video_btn{position:relative;display:inline-block;width:25px;height:16px;border:1px solid #9f9f9f;border-radius:12px;-webkit-transition:all .3s;-o-transition:all .3s;transition:all .3s}.fs_content .list_content.list_content_row .product_item .product_img_wrap .product_img_box .video_btn>span{position:absolute;top:50%;left:50%;display:block;margin-top:-5px;margin-left:-2px;width:0;height:0;border-top:5px solid transparent;border-right:5px solid transparent;border-bottom:5px solid transparent;border-left:7px solid #9f9f9f;-webkit-transition:all .3s;-o-transition:all .3s;transition:all .3s}.fs_content .list_content.list_content_row .product_item .product_img_wrap .brand_box{display:-webkit-box;display:-ms-flexbox;display:flex;margin-top:5px;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.fs_content .list_content.list_content_row .product_item .product_img_wrap .brand_box .brand_item:last-child{margin-right:0}.fs_content .list_content.list_content_row .product_item .product_img_wrap .brand_box .brand_item_active{border:2px solid #616265;width:100%}.fs_content .list_content.list_content_row .product_item .product_content .product_title{overflow:hidden;height:40px;-webkit-line-clamp:2}.fs_content .list_content.list_content_row .product_item .product_content .product_apply{display:block;overflow:auto;width:100%;max-height:40px;white-space:pre-wrap;line-height:20px}.fs_content .list_content.list_content_row .product_item .product_content .product_feature{overflow:hidden;margin-bottom:16px;width:100%;max-height:20px}.fs_content .list_content.list_content_row .product_item .product_content .product_feature_item{overflow:hidden;margin-right:6px;padding:0 6px;max-width:100%;background-color:#efefef;color:#8d8d8f;text-overflow:ellipsis;white-space:nowrap;font-size:13px;line-height:20px;-o-text-overflow:ellipsis}.fs_content .list_content.list_content_row .product_item .product_content .product_price{color:#232323;font-size:14px;line-height:20px}.fs_content .list_content.list_content_row .product_item .product_content .score_box{margin-bottom:6px}.fs_content .list_content.list_content_row .product_item .product_content .score_box .score_icon{display:inline-block;margin-right:6px}.fs_content .list_content.list_content_row .product_item .product_content .score_box .score_num{display:inline-block;margin-left:-2px;padding-left:0;color:#999;vertical-align:middle;font-size:12px;line-height:20px}.fs_content .list_content.list_content_row .product_item .product_content .stock_box{color:#666;font-size:12px;line-height:16px}.fs_footer{padding:0 15px;background:#f7f7f7}.fs_footer .contact_box{display:-webkit-box;display:-ms-flexbox;display:flex;padding:20px 15px 17px 15px;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_footer .contact_box .contact_item{display:-webkit-box;display:-ms-flexbox;display:flex;outline:0;color:#232323;text-decoration:none;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.fs_footer .contact_box .contact_item .contact_item_icon{display:-webkit-box;display:-ms-flexbox;display:flex;width:54px;height:54px;border-radius:50%;background:#fff;line-height:54px;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_footer .contact_box .contact_item .contact_item_info{margin-top:10px;color:#232323;font-size:14px;line-height:22px}.fs_footer .customer_service{padding:0 5px;border-top:1px solid #e5e5e5}.fs_footer amp-accordion section{position:relative;display:block}.fs_footer amp-accordion section:after{position:absolute;bottom:0;left:0;width:100%;border-bottom:1px solid #e5e5e5;content:""}.fs_footer .customer_service .customer_service_title{position:relative;padding:0 5px;height:44px;border:none;background-color:#f7f7f7}.fs_footer .customer_service .customer_service_content{padding-bottom:10px}.fs_footer .customer_service .customer_service_content>a{display:block;padding:0 15px;color:#616265;font-size:13px;line-height:30px}.fs_footer .customer_service .customer_service_title .info{display:inline-block;color:#232323;font-weight:400;font-size:13px;line-height:44px}.fs_footer .customer_service .customer_service_title .icon{position:relative;float:right;margin-top:12px;width:20px;height:20px}.fs_footer .customer_service .customer_service_title .icon .line1{position:absolute;top:9px;right:0;display:block;width:13px;height:1px;background-color:#232323}.fs_footer .customer_service .customer_service_title .icon .line2{position:absolute;top:9px;right:0;display:block;width:13px;height:1px;background-color:#232323;-webkit-transition:all .2s;-o-transition:all .2s;transition:all .2s;-webkit-transform:rotate(90deg);transform:rotate(90deg);-ms-transform:rotate(90deg)}.fs_footer amp-accordion section[expanded] .customer_service_title .icon .line2{-webkit-transition:all .2s;-o-transition:all .2s;transition:all .2s;-webkit-transform:rotate(180deg);transform:rotate(180deg);-ms-transform:rotate(180deg)}.fs_footer .share_box{display:-webkit-box;display:-ms-flexbox;display:flex;margin:15px 0;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.fs_footer .share_box .share_item{display:inline-block;margin:0 5px;width:24px;height:24px;color:#8d8d8f;font-size:28px}.fs_footer .copyright_box{padding:5px 15px 15px;color:#8d8d8f;text-align:center;font-size:12px;line-height:20px}.fs_footer .items_box{display:-webkit-box;display:-ms-flexbox;display:flex;padding:5px 0 20px 0;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.fs_footer .items_box>a{display:inline-block;height:12px;color:#8d8d8f;font-size:12px;line-height:12px}.fs_footer .items_box>span{padding:0 4px;color:#8d8d8f;font-size:12px}.slide_right{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}.lightbox_search{position:relative;width:100%;max-width:100%;background-color:#fff}.lightbox_search .search_box{position:relative;z-index:2;display:-webkit-box;display:-ms-flexbox;display:flex;margin-bottom:20px;padding:0 15px;height:50px;background:#fff;-webkit-box-shadow:0 2px 6px 0 #ededed;box-shadow:0 2px 6px 0 #ededed;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.lightbox_search form{display:-webkit-box;display:-ms-flexbox;display:flex;padding:0 15px;width:100%;height:34px;outline:0;border:none;border-radius:3px;background-color:#f7f7f7;color:#616265;font-size:14px;-webkit-box-flex:1;-ms-flex:1;flex:1;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.lightbox_search form .search_icon{display:inline-block;height:20px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/search.svg);background-position:center;background-size:contain;background-repeat:no-repeat;-webkit-box-flex:0;-ms-flex:0 0 17px;flex:0 0 17px}.lightbox_search form .keywords{padding:0 10px;height:20px;color:#616265;font-size:14px;line-height:20px;-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto}.lightbox_search form .clear{display:inline-block;display:none;height:16px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/clear.svg);background-position:center;background-size:contain;background-repeat:no-repeat;-webkit-box-flex:0;-ms-flex:0 0 16px;flex:0 0 16px}.lightbox_search form .clear.show{display:inline-block}.lightbox_search .close{margin-left:20px;color:#232323;font-style:normal;font-size:14px;line-height:34px;cursor:pointer}.search-result{position:absolute;top:52px;left:0;z-index:1;display:block;-webkit-box-sizing:border-box;box-sizing:border-box;padding:0 15px;width:100%;background-color:#fff}.search-result-con{-webkit-box-sizing:border-box;box-sizing:border-box;padding:0 15px;border-bottom:1px solid #e5e5e5;line-height:48px}.search-result-con a{display:block;color:#333;font-size:14px}.noSearch{display:none}.hot-search{padding:0 10px 10px;border-bottom:10px solid #f6f6f6}.hot-search-tit{margin-bottom:12px;color:#232323;font-weight:600;font-size:16px}.hot-search-all-con{float:left;margin-right:10px;margin-bottom:10px;padding:0 15px;border-radius:3px;background:#f7f7f7;color:#616265;text-decoration:none;font-size:13px;line-height:36px}.hot-search .hot-search-all{min-height:1px}.hot-search .hot-search-all [role=list]{width:auto;height:auto}.list_content{min-height:200px}.list_content [role=list]{position:static;width:auto;height:auto;height:auto;min-height:1px}.lightbox_video{background:#000}.lightbox_video .close{position:absolute;top:23px;right:24px;display:inline-block;width:18px;height:18px;background-image:url(https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/close.svg);background-position:center;background-size:contain;background-repeat:no-repeat;cursor:pointer}.lightbox_video .ctn{position:absolute;top:50%;left:50%;width:100%;height:210px;background:#ddd;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%)}.lightbox_video .ctn .video_box{display:none}.lightbox_video .ctn_ytb .video_iframe_box{display:block}.lightbox_video .ctn_video .video_local_box{display:block}[class*=amphtml-sidebar-mask]{display:none}.list_content amp-list [role=list] .amp-active>div{display:none}.list_content amp-list[load-more] button{padding:0 10px;height:32px;font-size:14px;line-height:32px}.list_content amp-list[load-more] button label{font-size:14px;line-height:32px}.list_content amp-list .amp-active>div{display:none}.global_loading{position:fixed;top:0;right:0;left:0;left:0;z-index:999999;width:100%;height:100%;background:rgba(255,255,255,.5)}.global_loading .loading_img{position:absolute;top:32%;left:50%;margin-left:-40px;width:80px;height:80px}.global_loading .loading_img:before{display:block;padding-top:100%;content:''}.global_loading .loading_img .circular{position:absolute;top:0;right:0;bottom:0;left:0;margin:auto;width:100%;height:100%;-webkit-transform-origin:center center;transform-origin:center center;-webkit-animation:rotate 2s linear infinite;animation:rotate 2s linear infinite;-ms-transform-origin:center center}@-webkit-keyframes rotate{100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes rotate{100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}.global_loading .loading_img .circular .path{stroke-dasharray:1,200;stroke-dashoffset:0;-webkit-animation:dash 1.5s ease-in-out infinite,color 6s ease-in-out infinite;animation:dash 1.5s ease-in-out infinite,color 6s ease-in-out infinite;stroke-linecap:round;-webkit-animation:dash 1.5s ease-in-out infinite,add_cart_color 6s ease-in-out infinite;animation:dash 1.5s ease-in-out infinite,add_cart_color 6s ease-in-out infinite}@-webkit-keyframes dash{0%{stroke-dasharray:1,200;stroke-dashoffset:0}50%{stroke-dasharray:89,200;stroke-dashoffset:-35px}100%{stroke-dasharray:89,200;stroke-dashoffset:-124px}}@keyframes dash{0%{stroke-dasharray:1,200;stroke-dashoffset:0}50%{stroke-dasharray:89,200;stroke-dashoffset:-35px}100%{stroke-dasharray:89,200;stroke-dashoffset:-124px}}@-webkit-keyframes add_cart_color{0%,100%{stroke:#bbb}40%{stroke:#bbb}66%{stroke:#bbb}80%,90%{stroke:#bbb}}@keyframes add_cart_color{0%,100%{stroke:#bbb}40%{stroke:#bbb}66%{stroke:#bbb}80%,90%{stroke:#bbb}}

   
      
    </style> 
 </head> 
 <body> 
   <!-- Google Tag Manager -->
  <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-5RQHXZM&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
  <amp-state id="header_data"> 
   <script type="application/json">
        {
          "show_category": false,
          "show_search": false,
          "show_account_box": false,
          "show_category_second":false,
          "show_category_three":false,
          "show_help_second":false
        }
      </script> 
  </amp-state> 
  <amp-state id="sidebar_category_data" src="<?php echo HTTPS_SERVER ?>/amp_categories.php?action=all_categories"> 
   <script type="application/json">
        {
          
          "index_one":0,
          "index_two":0
        }
      </script> 
  </amp-state> 
  <amp-state id="help_second_data" src="<?php echo HTTPS_SERVER ?>/amp_categories.php?action=left_bar"> 
   <script type="application/json">
    {
        "index":0
    }
        </script> 
  </amp-state> 
  <amp-state id="searchAPI"> 
   <script type="application/json">
      {
        "autoSearchAPI": "<?php echo HTTPS_SERVER ?>/amp_categories.php?action=search&search_key=",
        "emptyAndInitialTemplateJson": [
          {
            "query": "",
            "results": []
          }
        ]
      }
    </script> 
  </amp-state> 
  <amp-state id="searchState"> 
   <script type="application/json">
      {
        "inputValue": ""
      }
    </script> 
  </amp-state> 
  <amp-state id="product_layout"> 
   <script type="application/json">
      {
        "row": false
      }
    </script> 
  </amp-state> 
  <amp-state id="product_video"> 
   <script type="application/json">
      {
        "list_video": "",
        "is_youtube_video":false,
        "list_video_title":""
      }
    </script> 
  </amp-state> 
  <!-- header --> 
  <div class="fs_header"> 
   <div class="header"> 
    <div class="menu" [class]="header_data.show_category ? 'menu menu_active' : 'menu'" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_category:!header_data.show_category,show_account_box:false,show_category_second:false,show_category_three:false,show_help_second:false}}),sidebar_category.toggle"> 
     <div class="line line1"></div> 
     <div class="line line2"></div> 
     <div class="line line3"></div> 
    </div> 
    <span class="logo"></span> 
    <div class="right_box" [class]="header_data.show_category ? 'right_box invisible' : 'right_box visible'"> 
     <div class="search" tabindex="0" role="button" on="tap:lightbox_search.open"></div> 
     <a class="to_cart" href="<?php echo zen_href_link('shopping_cart');;?>"> 
      <?php if($cart_count){ ?>
      <span class="cart_num"><?php echo $cart_count;?></span> 
      <?php } ?>
    </a> 
    </div> 
   </div> 
  </div> 
  <div class="fs_content"> 
   <div class="list_top"> 
    <div class="list_title">
     <?php echo zen_get_categories_name($current_category_id);?>
    </div> 
    <div class="list_filter_box" [class]="product_layout.row?'list_filter_box list_filter_box_row':'list_filter_box'"> 
     <div class="left"> 
      <!-- <span class="filter_icon"></span>
            <span class="filter_info">Compatible Brands</span> --> 
     </div> 
     <div class="right"> 
      <span class="row" tabindex="0" role="button" on="tap:AMP.setState({product_layout: {row:true}}),product_list_ctn.changeToLayoutContainer()"></span> 
      <span class="column" tabindex="0" role="button" on="tap:AMP.setState({product_layout: {row:false}}),product_list_ctn.changeToLayoutContainer()"></span> 
     </div> 
    </div> 
   </div> 
   <div class="list_content" [class]="product_layout.row?'list_content list_content_row':'list_content'"> 
    <amp-list  id="product_list_ctn"  layout="flex-item" reset-on-refresh="always" noloading="" src="<?php echo HTTPS_SERVER ?>/amp_categories.php?action=products_list&amp;cPath=<?php echo $current_category_id;?>"> 
     <div placeholder=""> 
      <div class="global_loading"> 
       <div class="loading_img"> 
        <svg class="circular" viewbox="25 25 50 50">
         <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle> 
        </svg> 
       </div> 
      </div> 
     </div> 
     <template type="amp-mustache"> 
      <div class="product_item"> 
       <div class="product_img_wrap"> 
        <div class="product_img_box"> 
         <a class="product_img" href="/products/{{products_id}}.html" target="_blank"> 
          <amp-img src="{{image_str}}" width="120" height="120" layout="responsive"> 
          </amp-img> </a> {{#list_video}} 
         <span class="video_btn_box" tabindex="1" role="button" on="tap:lightbox_video.open,AMP.setState({product_video: {is_youtube_video:'{{is_youtube_video}}',list_video:'{{list_video}}',list_video_title:'{{list_video_title}}'}})"> <span class="video_btn"> <span></span> </span> </span> {{/list_video}} 
        </div> {{#related_mode.length}} 
        <div class="brand_box">
          {{#related_mode}} 
         <a href="/products/{{products_id}}.html" class="brand_item" [class]="'brand_item brand_item_bg_{{bg}}'">{{title}}</a> {{/related_mode}} 
        </div> {{/related_mode.length}} 
       </div> 
       <div class="product_content"> 
        <a class="product_title" href="/products/{{products_id}}.html" target="_blank">{{products_name}}</a> {{#primary_label}} 
        <div class="product_apply" [text]="'{{primary_label}}'"></div> {{/primary_label}} 
        {{#secondary_label.length}} 
        <div class="product_feature">
          {{#secondary_label}} 
         <span class="product_feature_item">{{.}}</span> {{/secondary_label}} 
        </div> {{/secondary_label.length}} 
        <div class="product_price">
          US$ {{products_price_str}} 
        </div> 
        <a class="score_box" href="/products/{{products_id}}.html#all_reviews" target="_blank"> 
         
         <div class="score_icon_box" [class]="'score_icon_box score_icon_box_'+(ceil({{products_review_score}}))"> 
          <span class="score_icon"></span> 
          <span class="score_icon"></span> 
          <span class="score_icon"></span> 
          <span class="score_icon"></span> 
          <span class="score_icon"></span> 
         </div> 
         <span class="score_num">{{products_review_number}}</span> 
        
        </a> 
        <div class="stock_box"> 
         <div class="stock_info">
           {{#instock}} 
          <span class="instock">{{instock}}</span> {{/instock}} {{#warehouse}} 
          <span class="warehouse">{{warehouse}}</span> {{/warehouse}} 
         </div> {{#expected_time}} 
         <div class="stock_info">
          {{expected_time}} 
         </div> {{/expected_time}} 
        </div> 
       </div> 
      </div> 
     </template> 
    </amp-list> 
   </div> 
  </div> 
  <!-- footer --> 
  <div class="fs_footer"> 
   <div class="contact_box"> 
    <a class="contact_item" href="<?php echo HTTPS_SERVER;?>/solution_support.html"> 
     <div class="contact_item_icon"> 
      <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/email.svg" width="22" height="22" layout="fixed" alt="Fs email.svg"> 
      </amp-img> 
     </div> <p class="contact_item_info">Email Us</p> </a> 
    <a class="contact_item" href="tel:+1 (888) 468 7419"> 
     <div class="contact_item_icon"> 
      <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/phone.svg" width="22" height="22" layout="fixed" alt="Fs tel.svg"> 
      </amp-img> 
     </div> <p class="contact_item_info">+1 (888) 468 7419</p> </a> 
    <a class="contact_item" href="<?php echo HTTPS_SERVER;?>/service/help_center.html"> 
     <div class="contact_item_icon"> 
      <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/live-chat.svg" width="22" height="22" layout="fixed" alt="Fs live-chat.svg"> 
      </amp-img> 
     </div> <p class="contact_item_info">Live Chat</p> </a> 
   </div> 
   <amp-accordion class="customer_service" expand-single-section="" animate=""> 
    <section> 
     <h4 class="customer_service_title"> <span class="info">Company</span> <span class="icon"> <span class="line1"></span> <span class="line2"></span> </span> </h4> 
     <div class="customer_service_content"> 
      <a href="https://fs.com/company/about_us.html">About Us</a> 
      <a href="https://fs.com/contact_us.html">Contact Us</a> 
      <a href="https://fs.com/company/quality_control.html">Quality</a> 
      <a href="https://fs.com/news/">Latest News</a> 
     </div> 
    </section> 
    <section> 
     <h4 class="customer_service_title"> <span class="info">Customer Service</span> <span class="icon"> <span class="line1"></span> <span class="line2"></span> </span></h4> 
     <div class="customer_service_content"> 
      <a href="https://fs.com/service/help_center.html"> Help Center</a> 
      <a href="https://fs.com/payment_methods.html"> Payment Methods</a> 
      <a href="https://fs.com/shipping_delivery.html"> Shipping &amp; Delivery</a> 
      <a href="https://fs.com/service/sales_tax.html">Sales Tax</a> 
      <a href="https://fs.com/policies/day_return_policy.html">Return Policy</a> 
      <a href="https://fs.com/policies/warranty.html">Warranty</a> 
     </div> 
    </section> 
    <section> 
     <h4 class="customer_service_title"> <span class="info">My Account</span> <span class="icon"> <span class="line1"></span> <span class="line2"></span> </span></h4> 
     <div class="customer_service_content"> 
      <a href="https://fs.com/login.html">Sign in/Create an Accunt</a> 
      <a href="https://fs.com/index.php?main_page=manage_orders">View Order History</a> 
      <a href="https://fs.com/index.php?main_page=service_view_order_online">Track Your Items</a> 
      <a href="https://fs.com/index.php?main_page=inquiry_list">Quote History</a> 
      <a href="https://fs.com/index.php?main_page=sales_service_request_list">Return an Item</a> 
     </div> 
    </section> 
    <section> 
     <h4 class="customer_service_title"> <span class="info">Support</span> <span class="icon"> <span class="line1"></span> <span class="line2"></span> </span></h4> 
     <div class="customer_service_content"> 
      <a href="https://fs.com/index.php?main_page=inquiry">Request Quote</a> 
      <a href="https://fs.com/sample_application.html">Request Sample</a> 
      <a href="https://fs.com/policies/net_30.html">Net Terms</a> 
      <a href="https://fs.com/index.php?main_page=e_rate">E-rate</a> 
     </div> 
    </section> 
   </amp-accordion> 
   <div class="share_box"> 
    <a class="share_item" title="fiberstore linkedin" target="_blank" href="<?php sourceHtml('linkedin'); ?>" rel="nofollow">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/lki.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
    <a class="share_item" title="fiberstore instagram" target="_blank" href="<?php sourceHtml('instagram'); ?>" rel="publisher">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/ins.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
    <a class="share_item" title="fiberstore facebook" target="_blank" href="<?php sourceHtml('facebook'); ?>">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/fb.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
    <a class="share_item" title="fiberstore twitter" target="_blank" href="<?php sourceHtml('twitter'); ?>">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/tw.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
    <a class="share_item" title="fiberstore pinterest" target="_blank" href="<?php sourceHtml('pinterest'); ?>">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/pin.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
    <a class="share_item" title="fiberstore youtube" target="_blank" href="<?php sourceHtml('youtube'); ?>">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/yt.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
    <a class="share_item" title="fiberstore community" target="_blank" href="https://community.fs.com">
     <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/com.svg" height="24" layout="responsive" width="24"></amp-img> </a> 
   </div> 
   <div class="copyright_box">
     Copyright &copy; 2009-2020&nbsp;FS.COM Inc.&nbsp;All Rights Reserved. 
   </div> 
   <div class="items_box"> 
    <a href="<?php echo HTTPS_SERVER;?>/policies/privacy_policy.html">Privacy Policy</a> 
    <span>|</span> 
    <a href="<?php echo HTTPS_SERVER;?>/policies/terms_of_use.html">Terms of Use</a> 
   </div> 
  </div>   
  <!--sidebar category  --> 
  <amp-sidebar id="sidebar_category" class="sidebar_category" layout="nodisplay" side="left"> 
   <div class="user_box"> 
     <?php if(!$_SESSION['customer_id']){?>
    <a href="<?php echo HTTPS_SERVER;?>/index.php?main_page=login" class="login_box"> <span class="account_icon"></span> <span class="sidebar_category_info">Account/Sign in</span> <span class="arrow_right"></span> </a> 
     <?php }else{ ?>
    <div class="login_box" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_account_box:true}})"> 
     <span class="account_icon"></span> 
     <span class="sidebar_category_info"><?php echo $common_current_username;?></span> 
     <span class="arrow_right"></span> 
    </div> 
     <?php } ?>
   </div> 
   <!-- all categories --> 
   <div class="help_box"> 
    <h2 class="help_box_title">All Categories</h2> 
    <div class="help_box_list"> 
     <amp-list layout="responsive" [src]="sidebar_category_data.items" height="0" width="414" [height]="51 * sidebar_category_data.items.length"> 
      <template type="amp-mustache"> 
       <div class="help_item" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_category_second:true},sidebar_category_data:{index_one:'{{index}}'}})"> 
        <div> 
         <span class="help_info">{{categories_name}}</span> 
         <span class="arrow_right"></span> 
        </div> 
       </div> 
      </template> 
     </amp-list> 
    </div> 
   </div> 
   <!-- help & setting --> 
   <div class="help_box"> 
    <h2 class="help_box_title">Help &amp; Setting</h2> 
    <div class="help_box_list"> 
     <amp-list layout="responsive" [src]="help_second_data.items" height="0" width="414" [height]="51 * help_second_data.items.length"> 
      <template type="amp-mustache">
        {{#url}} 
       <a href="{{url}}" class="help_item"> 
        <div> 
         <span class="help_info">{{title}}</span> 
         <span class="arrow_right"></span> 
        </div> </a> {{/url}} {{^url}} 
       <div class="help_item" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_help_second:true},help_second_data:{index:'{{index}}'}})"> 
        <div> 
         <span class="help_info">{{title}}</span> 
         <span class="arrow_right"></span> 
        </div> 
       </div> {{/url}} 
      </template> 
     </amp-list> 
    </div> 
   </div> 
   <!-- sidebar contact_box --> 
   <div class="contact_box"> 
    <a class="contact_item" href="<?php echo HTTPS_SERVER;?>/solution_support.html"> 
     <div class="contact_item_icon"> 
      <!-- <amp-img height="22" layout="responsive" src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/email.svg" width="22" alt="Fs email.svg"></amp-img> --> 
      <!-- <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/email.svg" height="22" layout="responsive"  width="22" ></amp-img> --> 
      <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/email.svg" width="22" height="22" layout="fixed"> 
      </amp-img> 
     </div> <p class="contact_item_info">Email Us</p> </a> 
    <a class="contact_item" href="tel:+1 (888) 468 7419"> 
     <div class="contact_item_icon"> 
      <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/phone.svg" height="22" layout="fixed" width="22"></amp-img> 
     </div> <p class="contact_item_info">+1 (888) 468 7419</p> </a> 
    <a class="contact_item" href="<?php echo HTTPS_SERVER;?>/service/help_center.html"> 
     <div class="contact_item_icon"> 
      <!-- <amp-img height="22" layout="responsive" src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/live-chat.svg" width="22" alt="Fs live-chat.svg"></amp-img> --> 
      <amp-img src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/live-chat.svg" height="22" layout="fixed" width="22"></amp-img> 
     </div> <p class="contact_item_info">Live Chat</p> </a> 
   </div> 
  </amp-sidebar> 
  <!-- account second --> 
  <div class="account_box" [class]="header_data.show_account_box ? 'account_box slide_right' : 'account_box'"> 
   <div class="back_btn" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_account_box:false}})"> 
    <span class="arrow_left"></span> 
    <span class="back_btn_info">Main Menu</span> 
   </div> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=my_dashboard"><span class="icon login_account"></span> <span class="account_item_info">My Account</span> <span class="account_item_info_sub"> (No. #<?php echo $customer_number_new;?>) </span> </a> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=edit_my_account"><span class="icon setting"></span><span class="account_item_info">Account Setting</span></a> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=manage_orders"><span class="icon order"></span><span class="account_item_info">Order History</span></a> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=inquiry_list&amp;quote_status=2"> <span class="icon quote"></span> <span class="account_item_info">Active Quote</span> </a> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=saved_items&amp;type=saved_carts"> <span class="icon saved"></span> <span class="account_item_info">Saved Carts</span> </a> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=browsing_history"> <span class="icon history"></span> <span class="account_item_info">Browsing History</span> </a> 
   <a class="account_item" href="<?php echo HTTPS_SERVER;?>/index.php?main_page=logoff"> <span class="icon log_out"></span> <span class="account_item_info">Sign Out</span> </a> 
  </div> 
  <!--  help second --> 
  <div class="account_box help_second_box" [class]="header_data.show_help_second ? 'account_box help_second_box slide_right' : 'account_box help_second_box'"> 
   <div class="back_btn" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_help_second:false}})"> 
    <span class="arrow_left"></span> 
    <span class="back_btn_info" [text]="help_second_data['items'][help_second_data.index].title"></span> 
   </div> 
   <amp-list layout="responsive" height="0" [src]="help_second_data['items'][help_second_data.index].sub" [height]="51*help_second_data['items'][help_second_data.index].sub.length" width="414"> 
    <template type="amp-mustache">
      {{#url}} 
     <a class="account_item" href="{{url}}"> 
      <div>
       <span class="account_item_info">{{title}}</span> 
       <span class="arrow_right"></span> 
      </div></a> {{/url}} 
    </template> 
   </amp-list> 
  </div> 
  <!-- category second --> 
  <div class="account_box help_second_box" [class]="header_data.show_category_second ? 'account_box help_second_box slide_right' : 'account_box help_second_box'"> 
   <div class="back_btn" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_category_second:false}})"> 
    <span class="arrow_left"></span> 
    <span class="back_btn_info" [text]="sidebar_category_data['items'][sidebar_category_data.index_one].categories_name"></span> 
   </div> 
   <amp-list layout="responsive" height="0" [src]="sidebar_category_data['items'][sidebar_category_data.index_one].second_categories" [height]="51*sidebar_category_data['items'][sidebar_category_data.index_one].second_categories.length" width="414"> 
    <template type="amp-mustache"> 
     <div class="account_item" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_category_three:true},sidebar_category_data:{index_two:'{{index}}'}})"> 
      <div>
       <span class="account_item_info">{{categories_name}}</span> 
       <span class="arrow_right"></span> 
      </div>
     </div> 
    </template> 
   </amp-list> 
  </div> 
  <!-- category three --> 
  <div class="account_box help_second_box" [class]="header_data.show_category_three ? 'account_box help_second_box slide_right' : 'account_box help_second_box'"> 
   <div class="back_btn" tabindex="0" role="button" on="tap:AMP.setState({header_data: {show_category_three:false}})"> 
    <span class="arrow_left"></span> 
    <span class="back_btn_info" [text]="sidebar_category_data['items'][sidebar_category_data.index_one]['second_categories'][sidebar_category_data.index_two].categories_name"></span> 
   </div> 
   <amp-list layout="responsive" height="0" [src]="sidebar_category_data['items'][sidebar_category_data.index_one]['second_categories'][sidebar_category_data.index_two]['subs']" [height]="51*sidebar_category_data['items'][sidebar_category_data.index_one]['second_categories'][sidebar_category_data.index_two]['subs'].length" width="414"> 
    <template type="amp-mustache"> 
     <a class="account_item" href="{{categories_url}}"> 
      <div>
       <span class="account_item_info">{{categories_name}}</span> 
       <span class="arrow_right"></span> 
      </div></a> 
    </template> 
   </amp-list> 
  </div> 
  <amp-lightbox id="lightbox_search" class="lightbox_search" layout="nodisplay" on="lightboxOpen:input-focus.focus" scrollable=""> 
   <div class="search_box"> 
    <form action="<?php echo HTTPS_SERVER;?>" method="GET" target="_top"> 
     <span class="search_icon"></span> 
     <input type="hidden" name="main_page" value="advanced_search_result" /> 
     <input type="text" name="keyword" placeholder="Search..." [value]="searchState.inputValue" id="input-focus" class="keywords" on="input-throttled:AMP.setState({searchState:{inputValue:event.value}})" autocomplete="off" /> 
     <span tabindex="0" role="button" class="clear" [class]="searchState.inputValue ? 'clear show' : 'clear'" on="tap:AMP.setState({searchState:{inputValue:''}})"></span> 
    </form> 
    <span class="close" tabindex="0" role="button" on="tap:lightbox_search.close">Cancel</span> 
   </div> 
   <div class="noSearch" [class]="searchState.inputValue ? 'search-result' : 'noSearch'"> 
    <amp-list class="search-result-list" layout="responsive" width="300" height="300" [src]="searchState.inputValue ? searchAPI.autoSearchAPI + encodeURIComponent(searchState.inputValue) : searchAPI.emptyAndInitialTemplateJson"> 
     <template type="amp-mustache"> 
      <div class="search-result-con"> 
       <a href="{{link}}"> {{fs_search_words}} </a> 
      </div> 
     </template> 
    </amp-list> 
   </div> 
   <div class="hot-search"> 
    <h2 class="hot-search-tit">Hot Search</h2> 
    <div class="hot-search-all"> 
     <amp-list width="414" height="200" layout="responsive" src="<?php echo HTTPS_SERVER ?>/amp_categories.php?action=hot_search"> 
      <template type="amp-mustache"> 
       <a class="hot-search-all-con" href="{{link}}"> {{name}} </a> 
      </template> 
     </amp-list> 
    </div> 
   </div> 
  </amp-lightbox> 
  <amp-lightbox id="lightbox_video" class="lightbox_video" layout="nodisplay"> 
   <span class="close" tabindex="1" role="button" on="tap:lightbox_video.close,AMP.setState({product_video: {is_youtube_video:false,list_video:'',list_video_title:''}})"></span> 
   <div class="ctn" [class]="product_video.is_youtube_video?'ctn ctn_ytb':'ctn_video'"> 
    <div class="video_box video_iframe_box"> 
     <amp-iframe width="414" height="220" layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups" allowfullscreen="" frameborder="0" src="<?php echo HTTPS_SERVER;?>" [src]="product_video.is_youtube_video ? product_video.list_video : '' "> 
      <amp-img layout="fill" src="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/transparent.png" placeholder=""></amp-img> 
     </amp-iframe> 
    </div> 
    <div class="video_box video_local_box"> 
     <amp-video width="414" height="220" [src]="!product_video.is_youtube_video?product_video.list_video:''" poster="https://img-en.fs.com/includes/templates/fiberstore/images/amp/category/transparent.png" layout="responsive" controls="" autoplay=""> 
      <div fallback=""> 
       <p>Your browser doesn't support HTML5 video.</p> 
      </div> 
     </amp-video> 
    </div> 
   </div> 
  </amp-lightbox>  
 </body>
</html>