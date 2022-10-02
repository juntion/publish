<?php
require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
    <?php
    $og_image = '';
    $str = META_TAG_TITLE;
    if(strpos($str,'|')){
        $title_str =explode('|',$str );
        for($i=0;$i<sizeof($title_str);$i++){
            if($title_str[$i]== ' FS.COM' || $title_str[$i]== ' FS.COM - Fiberstore' || $title_str[$i]==' Fiberstore'){
                $str =str_replace($title_str[$i],'',$str);
                $str =str_replace('|','',$str);
            }

        }
    }else{
        $spe_title_str =explode(':',$str);
        for($i=0;$i<sizeof($spe_title_str);$i++){
            if($spe_title_str[$i]== ' FS.COM' || $spe_title_str[$i]== ' FS.COM - Fiberstore' || $spe_title_str[$i]==' Fiberstore'){
                $str =str_replace($spe_title_str[$i],'',$str);
                $str =str_replace(':','',$str);
            }

        }
    }
    //FS - Fiberstore  改为 FS Fiberstore
    $str = str_replace('FS - Fiberstore','FS Fiberstore',$str);
    $site_tag =fs_get_site_tag_title();
    //所有站点取消拼接 | FS.COM - Fiberstore
    switch ($_SESSION['languages_code']){
        case 'uk':
            $site_name = 'FS United Kingdom';
            $og_locale = 'en-GB';
            break;
        case 'au':
            $site_name = 'FS Australia';
            $og_locale = 'en-AU';
            break;
        case 'mx':
            $site_name = 'FS México';
            $og_locale = 'es-MX';
            break;
        case 'sg':
            $site_name = 'FS Singapore';
            $og_locale = 'en-SG';
            break;
        case 'es':
            $site_name = 'FS España';
            $og_locale = 'es-ES';
            break;
        case 'jp':
            $site_name = 'FS 日本';
            $og_locale = 'ja-JP';
            break;
        case 'fr':
            $site_name = 'FS France';
            $og_locale = 'fr-FR';
            break;
        case 'de':
            $site_name = 'FS Deutschland';
            $og_locale = 'de-DE';
            break;
        case 'dn':
            $site_name = 'FS Germany';
            $og_locale = 'en-DE';
            break;
        case 'ru':
            $site_name = 'FS Россия';
            $og_locale = 'ru-RU';
            break;
        case 'en':
            $site_name = 'FS';
            $og_locale = 'en-US';
            break;
        case 'it':
            $site_name = 'FS Italia';
            $og_locale = 'it-IT';
            break;
    }
    if($this_is_home_page){
        //直接用数据库的数据
        $str =  str_replace(' - ','',$str);
        if(!empty($str)){// 因为后台有的是共用的 无法体现本地化，故后台上传Data Center, Enterprise, Telecom  前台拼接站点标识
            $titleOrName = $site_name . ' - ' .$str;
        }else{
            $titleOrName = $site_name;
        }

    }else{
        $titleOrMeta = $str;
        $titleOrName = $str.$site_tag;
    }

    if (in_array($_GET['main_page'], array('tutorial_detail'))) {
        if (isset($_GET['a_id']) && intval($_GET['a_id'])) {
            $doc_article_content = fs_get_data_from_db_fields('doc_article_content', TABLE_DOC_ARTICLE_DESCRIPTION, 'doc_article_id = "' . intval($_GET['a_id']) . '" and language_id =' . $_SESSION['languages_id'], '');
        }
        //$NowUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //$text=file_get_contents($NowUrl);
        //取得所有img标签，并储存至二维数组 $match 中
        preg_match_all('/<img[^>]*>/i', stripslashes($doc_article_content), $tutorial_article_match);
        $test_img_text = explode("src=\"", $tutorial_article_match[0][0]);
        $img_bak = zen_get_image_bak($test_img_text[1]);
        if ($img_bak) {
            $test_img_url = explode($img_bak, $test_img_text[1]);
            $og_image = $test_img_url[0] . $img_bak;
        }
    } else {
        if (in_array($_GET['main_page'], array('products_detail'))) {
            if (isset($_GET['s_id']) && intval($_GET['s_id'])) {
                $support_article_content = fs_get_data_from_db_fields('doc_article_content', TABLE_SOLUTION_ARTICLE_DESCRIPTION, 'doc_article_id = "' . intval($_GET['s_id']) . '" and language_id =' . $_SESSION['languages_id'], '');
            }
            preg_match_all('/<img[^>]*>/i', stripslashes($support_article_content), $support_article_match);
            $support_img_text = explode("src=\"", $support_article_match[0][0]);
            $img_bak2 = zen_get_image_bak($support_img_text[1]);
            if ($img_bak2) {
                $support_img_url = explode($img_bak2, $support_img_text[1]);
                $og_image = $support_img_url[0] . $img_bak2;
            }
        }else{
            if (in_array($_GET['main_page'], array('news_article'))) {
                if (isset($_GET['article_id']) && intval($_GET['article_id'])) {
                    $new_content_query = "select news_article_text from " . TABLE_NEWS_ARTICLES_TEXT . "
		where article_id = " . intval($_GET['article_id']) . " and language_id = " . (int)$_SESSION['languages_id'];
                    $new_article_text = $db->Execute($new_content_query);
                }
                preg_match_all('/<img[^>]*>/i', stripslashes($new_article_text->fields['news_article_text']), $new_article_match);
                $new_img_text = explode("src=\"", $new_article_match[0][0]);
                $img_bak3 = zen_get_image_bak($new_img_text[1]);
                if ($img_bak3) {
                    $new_img_url = explode($img_bak3, $new_img_text[1]);
                    $og_image = $new_img_url[0] . $img_bak3;
                }
            }elseif(in_array($_GET['main_page'], array('index')) && isset($_GET['cPath'])){
				$data_og_image =fs_get_data_from_db_fields('metatags_ogimage','meta_tags_categories_description','categories_id ='.$current_category_id.' and language_id ='.(int)$_SESSION['languages_id']);
					if($data_og_image){
						$og_image =$data_og_image;
					}else{
						if(!strstr($_GET['cPath'],'_')){
						switch ($_GET['cPath']){
							case 911:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_911.jpg';
								break;
							case 9:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_9.jpg';
								break;
							case 209:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_209.jpg';
								break;
							case 1308:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_1308.jpg';
								break;
							case 1:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_1.jpg';
								break;
							case 904:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_904.jpg';
								break;
							case 4:
								$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_image/og_4.jpg';
								break;
						}
					}else{
						if(!empty($products[0]['id'])) {
							$og_image = get_resources_img($products[0]['id'],550,550,'','','','',true);
						}
					}
				}
                
            }else{
				$page_name =$_GET['main_page'] ;
				$page_og_image=fs_get_data_from_db_fields('ogimage','page_meta_tags','page_name ="'.$page_name.'" and languages_id ='.(int)$_SESSION['languages_id']);
				if($page_og_image){
					$og_image = $page_og_image;
				}else{
					$og_image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_general.jpg';
				}
            }
        }
    }
    $og_image = !empty($og_image) ? $og_image : HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES.'og_general.jpg';
    if($this_is_home_page){
        $og_image = HTTPS_PRODUCTS_SERVER.'includes/templates/fiberstore/images/open_graph_logo.png';
    }
    ?>
    <title><?php
        $titleOrName = stripslashes($titleOrName);
        $titleOrName = str_replace('"','&#34;',$titleOrName);
        $titleOrName = str_replace("'",'&#39;',$titleOrName);
        echo $titleOrName;
	 ?></title>
   
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="x-dns-prefetch-control" content="on"/>
    <meta content="telephone=no" name="format-detection">
    <?php
//    if($this_is_home_page && in_array($_SESSION['languages_code'],array('au','uk','dn','sg'))){
//        if($_SESSION['languages_code'] == 'au'){
//            $description_str = 'FS (Fiberstore) is a new brand in Data Centre, Enterprise, ISP Network Solutions. We make it easy and cost-effective for IT professionals to enable their business solutions.';
//        }elseif($_SESSION['languages_code'] == 'uk'){
//            $description_str = 'FS(Fiberstore) is a new brand in Data Centre, Enterprise, ISP Network Solutions. We make it easy and cost-effective for IT professionals to enable their business solutions.';
//        }elseif($_SESSION['languages_code'] == 'dn'){
//            $description_str = 'Enjoy free delivery over €79, in-store pickup &same-day shipping for tested/certified switches, transceivers, WDM, fiber &copper cablings. FS (Fiberstore) ten-year European service experiences, professional solutions and global warehouse systems satisfy all the customers.';
//        }elseif($_SESSION['languages_code'] == 'sg'){
//            $description_str = 'FS (Fiberstore) is a new brand in Data Center, Enterprise, ISP Network Solutions.  We make it easy and cost-effective for IT professionals to enable their business solutions.';
//        }
//    }else{
//        $description_str = META_TAG_DESCRIPTION;
//    }
    $description_str = stripslashes(META_TAG_DESCRIPTION);
    $description_str = str_replace('"','&#34;',$description_str);
    $description_str = str_replace("'",'&#39;',$description_str);
    echo '<meta name="description" content="'.$description_str.'"/>';
    ?>
    <?php
    if (isset($_GET['products_id']) && $_GET['products_id']) {
        $product_img = get_resources_img($_GET['products_id'],550,550,'','','','',true);
        echo '
            <meta property="og:title" content="' . META_TAG_TITLE . '"/>
            <meta property="og:description" content="' . str_replace('Buy', '', $description_str) . '"/>
            <meta property="og:url" content="' . zen_href_link('product_info', 'products_id=' . $_GET['products_id']) . '"/>
            <meta property="og:locale" content="'.$og_locale.'">
            <meta property="og:image" content="' . $product_img . '"/> 
            <meta property="og:type" content="website"/>
            <meta property="og:site_name" content="'.$site_name.'"/>
	        <meta property="al:ios:app_name" content="FS.COM">
	        <meta property="al:ios:app_store_id" content="1441371183">
	        <meta property="al:ios:url" content="https://itunes.apple.com/us/app/fs-com/id1441371183?l=zh&ls=1&mt=8">
            ';
    }else{
        echo '
            <meta property="og:title" content="' . $titleOrMeta . '"/>
            <meta property="og:description" content="' . $description_str . '"/>
            <meta property="og:url" content="https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"/>
            <meta property="og:locale" content="'.$og_locale.'">
            <meta property="og:image" content="'.$og_image.'"/> 
            <meta property="og:type" content="website"/>
            <meta property="og:site_name" content="' .$site_name. '"/> 
            ';
    }
    ?>
    <meta http-equiv="imagetoolbar" content="no"/>
    <meta name="author" content="FS"/>
    <?php
    require($template->get_template_dir('fs_seo_google_tag_manage.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/fs_seo_google_tag_manage.php');
    ?>
    <?php
    if ($_GET['main_page'] == 'checkout_success' && $_SESSION['fromURL'] && strpos($_SESSION['fromURL'], "www.cwdm-dwdm-oadm.com")) {
        ?>
        <meta http-equiv="refresh" content="3; url=<?php echo $_SESSION['fromURL']; ?>">
        <?php
        $_SESSION['fromURL'] = '';
    } ?>
    <meta name="p:domain_verify" content="58370e85a34b607b08812b6bc4d4946d"/>
    <meta name="google-site-verification" content="5-e1avjz6qoODPVSTZoQuek8yZ8OLYh2xHAHUqo1lNU"/>
    <meta name="msvalidate.01" content="7F7D99FEC90A7776BCEC1F6416DCCA82"/>
    <meta name="yandex-verification" content="e847ca35400d7ece"/>
    <?php if($_GET['main_page'] == 'index'){ ?>
        <!-- <link rel="amphtml" href="https://www.fs.com/amp_index.php"> -->
    <?php } ?>
    <?php
    if (in_array($_GET['main_page'], array('tutorial_detail'))) {
        ?>
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@Fiberstore">
        <meta name="twitter:title" content="<?php echo META_TAG_KEYWORDS; ?>">
        <meta name="twitter:description" content="<?php echo META_TAG_DESCRIPTION; ?>">
        <meta name="twitter:image" content="<?php
        if (isset($_GET['a_id']) && intval($_GET['a_id'])) {
            $doc_article_content = fs_get_data_from_db_fields('doc_article_content', TABLE_DOC_ARTICLE_DESCRIPTION, 'doc_article_id = "' . intval($_GET['a_id']) . '" and language_id =' . $_SESSION['languages_id'], '');
        }
        //$NowUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //$text=file_get_contents($NowUrl);
        //取得所有img标签，并储存至二维数组 $match 中
        preg_match_all('/<img[^>]*>/i', stripslashes($doc_article_content), $tutorial_article_match);
        $test_img_text = explode("src=\"", $tutorial_article_match[0][0]);
        $img_bak = zen_get_image_bak($test_img_text[1]);
        if ($img_bak) {
            $test_img_url = explode($img_bak, $test_img_text[1]);
            echo $test_img_url[0] . $img_bak;
        }
        ?>">
        <meta name="twitter:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
        <meta name="twitter:creator" content="@Fiberstore">
    <?php } else {
        if (in_array($_GET['main_page'], array('products_detail'))) {
            ?>
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="@Fiberstore">
            <meta name="twitter:title" content="<?php echo META_TAG_KEYWORDS; ?>">
            <meta name="twitter:description" content="<?php echo META_TAG_DESCRIPTION; ?>">
            <meta name="twitter:image" content="<?php
            if (isset($_GET['s_id']) && intval($_GET['s_id'])) {
                $support_article_content = fs_get_data_from_db_fields('doc_article_content', TABLE_SOLUTION_ARTICLE_DESCRIPTION, 'doc_article_id = "' . intval($_GET['s_id']) . '" and language_id =' . $_SESSION['languages_id'], '');
            }
            preg_match_all('/<img[^>]*>/i', stripslashes($support_article_content), $support_article_match);
            $support_img_text = explode("src=\"", $support_article_match[0][0]);
            $img_bak2 = zen_get_image_bak($support_img_text[1]);
            if ($img_bak2) {
                $support_img_url = explode($img_bak2, $support_img_text[1]);
                echo $support_img_url[0] . $img_bak2;
            }
            ?>">
            <meta name="twitter:url"
                  content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
            <meta name="twitter:creator" content="@Fiberstore">
        <?php } else {
            if (in_array($_GET['main_page'], array('news_article'))) {
                ?>
                <meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:site" content="@Fiberstore">
                <meta name="twitter:title" content="<?php echo META_TAG_KEYWORDS; ?>">
                <meta name="twitter:description" content="<?php echo META_TAG_DESCRIPTION; ?>">
                <meta name="twitter:image" content="<?php
                if (isset($_GET['article_id']) && intval($_GET['article_id'])) {
                    $new_content_query = "select news_article_text from " . TABLE_NEWS_ARTICLES_TEXT . "
		where article_id = " . intval($_GET['article_id']) . " and language_id = " . (int)$_SESSION['languages_id'];
                    $new_article_text = $db->Execute($new_content_query);
                }
                preg_match_all('/<img[^>]*>/i', stripslashes($new_article_text->fields['news_article_text']), $new_article_match);
                $new_img_text = explode("src=\"", $new_article_match[0][0]);
                $img_bak3 = zen_get_image_bak($new_img_text[1]);
                if ($img_bak3) {
                    $new_img_url = explode($img_bak3, $new_img_text[1]);
                    echo $new_img_url[0] . $img_bak3;
                }
                ?>">
                <meta name="twitter:url"
                      content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
                <meta name="twitter:creator" content="@Fiberstore">
                <?php
            }else{?>
                <meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:site" content="@Fiberstore">
                <meta name="twitter:title" content="<?php echo isset($_GET['products_id']) ? META_TAG_TITLE : $titleOrMeta;?>">
                <meta name="twitter:description" content="<?php echo isset($_GET['products_id']) ? str_replace('Buy', '', META_TAG_DESCRIPTION) : $description_str; ?>">
                <meta name="twitter:image" content="<?php echo isset($_GET['products_id']) ? $product_img : $og_image;?>">
                <meta name="twitter:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
                <meta name="twitter:creator" content="@Fiberstore">
           <?php }
        }
    } ?>
    <?php
    $language_code = fs_get_data_from_db_fields('code', 'languages', 'languages_id=' . $_SESSION['languages_id'], '');
    if ($_SESSION['languages_code'] != 'en') {
		//只要不是英文站就把对应站点code值赋给$code,有的语种language_id一样所以用languages_code区分
		if($_SESSION['languages_code']=='dn'){
			$code = '/de-en';
		}else{
			$code = '/'.$_SESSION['languages_code'];
		}
    } else {
        $code = '';
    }
    $url_code = $language_code . '/';
    ?>
    <?php
        if($_GET['main_page'] == 'product_info'){
            $seo_products_id = (int)$_GET['products_id'];
            $warehouse_data_seo = fs_products_warehouse_where();
            if($warehouse_data_seo['code']){
                $warehouse_fields_seo = strtolower($warehouse_data_seo['code']).'_status';
                if(in_array($warehouse_fields_seo,['de_status','us_status','au_status','cn_status'])){
                    $query_warehouse_column_seo = ','.$warehouse_fields_seo.' ';
                    $sql = "select p.products_id,p.products_status,p.offline_replace_products_id,products_leadtime,related_preorder_product_id,integer_state".$query_warehouse_column_seo." 
                            from " . TABLE_PRODUCTS . " p
                            where  p.products_id = " . (int)$_GET['products_id'] . " and show_type=0 ";
                    $res = $db->Execute($sql);
                    if ($res->fields['products_status'] == 0 || !$res->fields[$warehouse_fields_seo] ) {
                        if(offline_products_is_show_new_page((int)$_GET['products_id'] )){
                            $seo_products_id = $res->fields['offline_replace_products_id'];
                        }
                    }
                }
            }
        }
    ?>
    <?php if($_GET['main_page'] == 'download'){
        $url_par = str_replace('/es','',$_SERVER['REQUEST_URI']);
        ?>
        <link rel="canonical" href="https://www.fs.com<?php echo $url_par?>" />
    <?php }?>
    <?php
    if($_GET['main_page'] == 'tutorial_detail' && isset($mult) && !empty($mult)){
        foreach ($mult as $km => $vm){?>
            <link rel="<?php echo $vm['rel'] ?>" hreflang="<?php echo $vm['hreflang'] ?>" href="<?php echo $vm['url'] ?>"/>
        <?php }
    }
    ?>
    <?php if (in_array($_GET['main_page'], array('fs_special_page', 'index', 'login', 'regist', 'my_dashboard', 'manage_orders', FILENAME_VALID_QUOTATION, FILENAME_VALID_QUOTATION_DETAIL, 'unpaid_orders', 'trading_orders', 'closed_orders', 'sales_service', 'manage_addresses', 'manage_profile','tag_categories',
        'account_newsletters', 'change_password', 'manage_reviews', 'my_questions', 'checkout', 'product_info'))) {
        $request_url = $_SERVER['REQUEST_URI'];
        //$sub_arr = array();
        //zen_get_subcategories($sub_arr,209);
        //$sub_arr[] = 209;
        //if(!in_array($_GET['cPath'],$sub_arr)){

        if (isset($_GET['cPath'])) {
            $request_url = substr($request_url, 0, strpos($request_url, '?'));
            if (empty($request_url)) {
                $request_url = $_SERVER['REQUEST_URI'];
            }
        }
        if($_GET['main_page']=="fs_special_page"){
            $request_url = substr($request_url, 0, strpos($request_url, '?'));
            if (empty($request_url)) {
                $request_url = $_SERVER['REQUEST_URI'];
            }
        }
        if ($_GET['main_page']=='tag_categories') {
            $request_url = substr($request_url, 0, strpos($request_url, '?'));
            if (empty($request_url)) {
                $request_url = $_SERVER['REQUEST_URI'];
            }

        }
        if($_GET['main_page'] == 'product_info' && $seo_products_id) {
            $right_url = zen_href_link('product_info','&products_id='.(int)$seo_products_id,'NONSSL');
            $param_array = parse_url($right_url);
            $param = $param_array['path'];
            $request_url = $param;//分类页，产品详情页不带参数
        }

        if($_GET['main_page'] == 'index') {
            if(isset($_GET['cPath'])){
                $right_url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$current_category_id);
                $param_array = parse_url($right_url);
                $param = $param_array['path'];
                $request_url = $param;
            }elseif($this_is_home_page){
                $request_url = $code.'/';//首页不带参数
            }
        }

        //}

        $request_url = str_replace('_','-',$request_url);
        $request_url = get_canonical_url($request_url);
        ?>

        <link rel="canonical" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $request_url; ?>"/>

        <?php if(($_GET['main_page'] == 'index') && isset($_GET['cPath']) && isMobile()){ ?>
            <link rel="amphtml" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . str_replace("/c/","/amp/",$param); ?>"/>
        <?php } ?>

    <?php } ?>
    <?php if (!in_array($_GET['main_page'], array(FILENAME_NEWS, 'news_and_events', 'news_article', 'tutorial', 'support', 'tutorial_list', 'tutorial_detail', 'Popular', 'Product_List', 'Popular_detail', 'products_list', 'tutorial_tag_search','advanced_search_result'))) {

        include($_SERVER["DOCUMENT_ROOT"].'/'.DIR_WS_TEMPLATE.'common'.'/fs_seo_multi_mark.php');
        $REQUEST_URI = str_replace($url_code, '', $_SERVER['REQUEST_URI']);
        if (!in_array($_GET['main_page'], array('products_list', 'support_detail', 'cwdm_dwdm_transmission_solution', 'fiber_transceivers', 'tutorial_tag_search', 'all_review', 'comments_review', 'products_detail'))) { ?>

            <?php if($_GET['main_page'] == 'product_info' && $seo_products_id) {
                $right_url = zen_href_link('product_info','&products_id='.(int)$seo_products_id,'NONSSL');
                $param_array = parse_url($right_url);
                $param = $param_array['path'];
                $param = str_replace($code,'',$param);
                $REQUEST_URI = $param;//分类页，产品详情页不带参数
            } ?>

            <?php 
			if($_GET['main_page'] == 'index') {
                if(isset($_GET['cPath'])){
                    $right_url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$current_category_id);
                    $param_array = parse_url($right_url);
                    $param = $param_array['path'];
                    $param = str_replace($code,'',$param);
                    $REQUEST_URI = $param;
                }elseif($this_is_home_page){
                    $REQUEST_URI = '/';//首页不带参数
                }
            } ?>

            <?php
            if(!strstr(strval($REQUEST_URI),'-po-') && !(($_GET['main_page'] == 'index') && strstr($REQUEST_URI,'?'))){
                $REQUEST_URI = str_replace($code,'',$REQUEST_URI);
//                if($_GET['main_page'] != 'fs_single_pages'){
//                  $REQUEST_URI = str_replace('_','-',$REQUEST_URI);
//                }
                foreach($mark_default as $key => $val){?>
                    <link rel="<?php echo $val['rel'];?>" hreflang="<?php echo $val['hreflang'];?>" href="<?php echo $val['href'].$REQUEST_URI;?>"/>
                <?php }
            }?>

            <?php
            function isset_narrows()
            {
                $get_narrow = array();
                $unarrowGET = array('_requestConfirmationToken', 'cPath', 'main_page', 'page', 'sort', 'type', 'count', 'settab', 'c_id', 'type');
                foreach ($_GET as $getname => $getvalue) {
                    if (!in_array($getname, $unarrowGET)) {
                        if ($getvalue && is_numeric($getvalue)) {
                            $get_narrow [] = $getvalue;
                        }
                    }
                }
                return $get_narrow;
            }

            $is_narrow = isset_narrows();
//            if (isset($_GET['cPath']) && $_GET['cPath'] != "" && !$this_is_home_page && empty($is_narrow)) {
//                echo '<link rel="amphtml" href="https://www.fs.com/amp' . $REQUEST_URI . '.html">';
//            }
            ?>
        <?php } elseif (in_array($_GET['main_page'], array('products_detail', 'tutorial_detail'))) {
        } else {
            ?>

            <?php foreach($mark_default as $key => $val){?>
                <link rel="<?php echo $val['rel'];?>" hreflang="<?php echo $val['hreflang'];?>" href="<?php echo $val['href'].'/';?>"/>
            <?php }?>

        <?php } ?>
    <?php } ?>

    <?php define('FAVICON', 'images/favicon.ico'); ?>
    <?php if (defined('FAVICON')) { ?>
        <link rel="icon" href="<?php echo HTTPS_IMAGE_SERVER.FAVICON; ?>" type="image/x-icon"/>
        <link rel="shortcut icon" href="<?php echo HTTPS_IMAGE_SERVER.FAVICON; ?>" type="image/x-icon"/>
    <?php } //endif FAVICON ?>
    <base href="<?php echo(($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG); ?>"/>
    <?php if (isset($canonicalLink) && $canonicalLink != '' && !in_array($_GET['main_page'], array('fs_special_page', 'index', 'advanced_search_result', 'login', 'regist', 'my_dashboard', 'manage_orders', FILENAME_VALID_QUOTATION, FILENAME_VALID_QUOTATION_DETAIL, 'unpaid_orders', 'trading_orders', 'closed_orders', 'sales_service', 'manage_addresses', 'manage_profile', 'account_newsletters', 'change_password', 'manage_reviews', 'my_questions', 'checkout'))) { ?>
        <?php if($this_is_home_page){
			   $canonical_href = HTTPS_SERVER ;
		    }else{
			   if(FS_CANONICAL_HREF){
				   $canonical_href =HTTPS_SERVER.'/'.FS_CANONICAL_HREF;
			   }else{
					$canonical_href =$canonicalLink;
			   }
		   }?>
	   <link rel="canonical" href="<?php echo $canonical_href;?>" /> 
    <?php } ?>
    <?php if (isMobile()) {
            if(!in_array( $_GET['main_page'],array('print_get_a_quote','print_service_order','print_blanket_order','print_checkout_success','print_shopping_list') )){
                if($_GET['main_page'] !='fs_single_pages' || $_GET['name'] != 'warranty'){
    ?>        
        <meta name="viewport"
              content="width=device-width,target-densitydpi=high-dpi,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <?php }?>
        <?php }?>
    <?php }?>
    <?php if (in_array($_GET['main_page'], array('fs_special_page'))) {
        $special_id = $_GET['id'];
        $css_data = fs_get_data_from_db_fields('css_link', 'fs_article_descriptions', 'article_id=' . $special_id.' and language_id='.$_SESSION['languages_id'], '');
    } ?>

    <?php
    require($template->get_template_dir('fs_special_css_js.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/fs_special_css_js.php');
    ?>

    <?php
    /**
     * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
     */
    $directory_array = $template->get_template_part($page_directory, '/^jscript_/');
    while (list ($key, $value) = each($directory_array)) {
        /**
         * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
         * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
         */
        require($page_directory . '/' . $value);
        echo "\n";
    }
    ?>
    <script type="text/javascript">
    <?php if($_SESSION['currency'] == 'EUR'){?>
        var parameters =
        {
        currency: '<?php echo $_SESSION['currency']; ?>', 			// If currency is not supplied, defaults to USD
        symbol: '',			// Overrides the currency's default symbol
        locale: 'fr',			// Overrides the currency's default locale (see supported locales)
        decimal: ',',			// Overrides the locale's decimal character
        group: '.',			// Overrides the locale's group character (thousand separator)
        pattern: '#,##0.00 !'		// Overrides the locale's default display pattern
        };
    <?php }elseif($_SESSION['currency'] == 'RUB'){?>
        var parameters =
        {
        currency: '<?php echo $_SESSION['currency']; ?>', 			// If currency is not supplied, defaults to USD
        symbol: '',			// Overrides the currency's default symbol
        locale: 'fr',			// Overrides the currency's default locale (see supported locales)
        decimal: '.',			// Overrides the locale's decimal character
        group: ' ',			// Overrides the locale's group character (thousand separator)
        pattern: '#,##0.00 !'		// Overrides the locale's default display pattern
        };
    <?php }else{?>
        var parameters =
        {
        currency: '<?php echo $_SESSION['currency']; ?>', 			// If currency is not supplied, defaults to USD
        symbol: '',			// Overrides the currency's default symbol
        locale: 'fr',			// Overrides the currency's default locale (see supported locales)
        decimal: '.',			// Overrides the locale's decimal character
        group: ',',			// Overrides the locale's group character (thousand separator)
        pattern: '#,##0.00 !'		// Overrides the locale's default display pattern
        };

    <?php }?>
    </script>
    <?php
    if(!german_warehouse('country_code', $_SESSION['countries_iso_code']) || (!isset($_COOKIE['fs_google_analytics']) || $_COOKIE['fs_google_analytics'] != 'no')){
        /** fs analytics 数据统计代码,此代码暂时只放在英文站，其他站点不要放 **/
    ?>
        <script type="text/javascript">
            <?php
            $analysisParam = '';
            if ($_SESSION['customer_id'] > 0) {
                //数据采集定义的会话时间
                if(!empty($_SESSION['analysis_session_expires_time']) && $_SESSION['analysis_session_expires_time'] > time()){
                    //会话未过期
                    $_SESSION['analysis_session_expires_time'] = time() + 1800;
                }else if(!empty($_SESSION['analysis_session_expires_time'])){
                    //会话过期
                    if(isset($_SESSION['is_regist'])){
                        unset($_SESSION['is_regist']);
                    }
                    $_SESSION['analysis_session_expires_time'] = time() + 1800;
                }else{
                    $_SESSION['analysis_session_expires_time'] = time() + 1800;
                }
                if(empty($_SESSION['is_regist'])){
                    $analysisParam .= 'l_type=1&';
                }else{
                    $analysisParam .= 'l_type=2&';
                }
            }
            //产品ID
            if (is_numeric($_GET['products_id']) && $_GET['products_id']) {
                $analysisParam .= 'p_id=' . $_GET['products_id'] . '&';
            } elseif (is_numeric($_GET['product_id']) && $_GET['product_id']) {
                $analysisParam .= 'p_id=' . $_GET['product_id'] . '&';
            }
            //最小分类ID
            if ($current_category_id) {
                $analysisParam .= 'ca_id=' . $current_category_id . '&';
            }
            //一到三级分类ID
            if (sizeof($cPath_array)) {
                if(isset($cPath_array[0]) && $cPath_array[0]){
                    $analysisParam .= 'ca_id_on=' . $cPath_array[0] . '&';
                }
                if(isset($cPath_array[1]) && $cPath_array[1]){
                    $analysisParam .= 'ca_id_tw=' . $cPath_array[1] . '&';
                }
                if(isset($cPath_array[2]) && $cPath_array[2]){
                    $analysisParam .= 'ca_id_th=' . $cPath_array[2] . '&';
                }
            }
            if($_GET['main_page']){
                $analysisParam .= 'm_p=' . $_GET['main_page'] . '&';
                //搜索关键词及搜索结果
                if($_GET['main_page'] == 'advanced_search_result' && $_GET['keyword']){
                    $analysisParam .= 's_k=' . $_GET['keyword'] . '&';
                    $analysisParam .= 's_r=' . (int)$searchResultType . '&';
                }
            }
            ?>
            var _faq = _faq || [];
            <?php if($analysisParam){ ?>
            if (typeof _faq !== 'undefined') {
                _faq.push(['appendToTrackingUrl', '<?php echo $analysisParam;?>']);
            }
            <?php }?>
            if (typeof _faq !== 'undefined') {
                _faq.push(['trackPageView', document.title]);
            }
            <?php if($_SESSION['customer_id'] > 0 && !$_SESSION['customers_number_new']){
                $_SESSION['customers_number_new'] = fs_get_data_from_db_fields('customers_number_new', 'customers', 'customers_id=' . $_SESSION['customer_id'], 'limit 1');
            }
            ?>
            <?php if($_SESSION['customers_number_new']){?>
            if (typeof _faq !== 'undefined') {
                _faq.push(['setUserId', '<?php echo \classes\FsSecret::authCode($_SESSION['customers_number_new'], 'ENCODE');?>']);
            }
            <?php }?>
            (function () {
                <?php if($_SERVER['SERVER_NAME'] === 'test.whgxwl.com'){?>
                var u = "//tech1.whgxwl.com:8001/";
                <?php }elseif($_SERVER['SERVER_NAME'] === 'tx.fs.com'){?>
                var u = "//test.whgxwl.com:20007/";
                <?php }elseif($_SERVER['SERVER_NAME'] === 'www.fs.com'){?>
                var u = "//stats.fs.com/";
                <?php }?>
                if (typeof _faq !== 'undefined') {
                    _faq.push(['setTrackerUrl', u + 'analysis']);
                    _faq.push(['setSiteId', '<?php echo !empty($_SESSION['site_code']) ? $_SESSION['site_code'] : $_SESSION['languages_code'];?>']);
                }
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.type = 'text/javascript';
                g.async = true;
                g.defer = true;
                g.src = '//img-en.fs.com/js/analysis.js?v=1';
                s.parentNode.insertBefore(g, s);
            })();
        </script>
    <?php /**  End fs analytics Code */ ?>

    <?php }?>
</head>
