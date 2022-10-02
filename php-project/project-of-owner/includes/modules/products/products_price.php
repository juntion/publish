<div class="detail_proPrice <?php echo $_SESSION['languages_code'] == 'ru' ? '' : 'price_ru';?>" id="productsbaseprice">
	<?php 
	/* products price show start */
	//$wholesale_products不取整的产品数组数据已经在产品详情页的header_php.php文件中生成可以直接调用
	if($_GET['cart_quantity']){
		$pure_price = get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'],(int)$_GET['cart_quantity']));
		if($integer_state == 0){
			$product_price = $currencies->new_display_price($pure_price,0);
			echo $product_price;
		}else{
			$product_price = $currencies->display_price($pure_price,0);
			echo $product_price;
		}
	}else{
	    //此处计算价格部分 移至 products_add_to_cart_by_header.php 因为头部价格需要和这里的价格一致
//		echo $priceData['totalPrice'] . $priceData['taxPrice'];

		$pure_price = $product_price;
		//生成的对应币种的带货币符号的价格
		$priceText = $currencies->total_format($product_price);
        //展示不含税注释
        if ($_SESSION['languages_code'] == 'fr') {
            if (in_array(strtolower($_SESSION['countries_iso_code']), ['fr', 'be', 'mc', 'lu'])) {
                $priceText = $priceText.' HT';
            }
        }

        $priceHtml = $taxPriceText = '';
		if(get_price_vat_uk_show()){
            $Excl_vat =' (Excl. VAT)';
			//$priceHtml .= '<em style="font-style:normal" id="productsbaseprice">'.$priceText.'</em>';
			if(german_warehouse("country_code", $_SESSION['countries_iso_code'])){
				$taxPriceText = $currencies->total_format($product_price*1.20);
                $taxPriceHtml = '<p class="detail_proPrice2">'.$taxPriceText.' (Incl. VAT)</p>';
                $priceHtml .= $priceText.$Excl_vat.$taxPriceHtml;
			}
		}elseif($_SESSION['languages_code']=='au'){
			$Excl_tax = '';
            $priceHtml .= $priceText . ($Is_NewLand ? '' : ' (Incl. GST)');
		}elseif($_SESSION['languages_code'] == 'jp'){
			$jp_price = '';
			if($_SESSION['currency']!='JPY'){
				//jp站货币是美元是需要展示出日元价格
				$jp_product_price = zen_get_products_final_price((int)$_GET['products_id'],'JPY');
				$jp_price ='<em>/'.'JPY&nbsp;'.$currencies->total_format($jp_product_price, true,"JPY",'').'</em>';
			}
			$priceHtml .= $priceText.$jp_price;
			
		}elseif($_SESSION['countries_iso_code']=='ru'){ ////俄罗斯国家20%增值税
            $inclVat = FS_INCLUDED_VAT;
            $enclVat = FS_EXCLUDED_VAT;
            $taxPriceText = $currencies->total_format($product_price * 1.20);
            $taxPriceHtml = '<p class="detail_proPrice2">'.$taxPriceText.$inclVat.'</p>';

            $priceHtml .= $priceText.$enclVat.$taxPriceHtml;
        }elseif(in_array($_SESSION['languages_code'],['de','dn','it'])){
            if (in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de') {
                $priceHtml .= $priceText.FS_PRICE_EXCL_VAT;
                //法国德英站详情页产品含税价格按照19%计算
                $taxPriceText = $currencies->total_format($product_price * 1.19);
                //德国仓展示税收
                $priceHtml .= '<div class="de_tax_detail_box">
                                <p class="detail_proPrice2">'.$taxPriceText. FS_PRICE_INCL_VAT . '</p>
                                <div class="track_orders_wenhao m_track_orders_wenhao m-track-alert" style="display: block">
                    <div class="question_bg_icon question_bg_grayIcon iconfont icon"></div>
                    <div class="new_m_bg1"></div>
                    <div class="new_m_bg_wap">
                        <div class="question_text_01 leftjt">
						<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon"></i></a>
                            <div class="arrow"></div>
                            <div class="popover-content">
                                '.FS_DE_TAX_TEXT.'
                            </div>
                        </div>
                    </div>
                </div>
                                </div>';
            } else {
                //de站和de-en站的价格展示
                $priceHtml .= $priceText;
                if(german_warehouse("country_code",$_SESSION['countries_iso_code']) && (strtoupper($_SESSION['countries_iso_code']) != "VA") && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', "MF")))){
                    //欧盟国家才展示是否含税信息    但是梵蒂岡不展示
                    $priceHtml .= FS_PRICE_EXCL_VAT;
                    $times = getVaxByCountry($_SESSION['countries_iso_code']);//法国德英站详情页产品含税价格按照20%计算
                    $taxPriceText = $currencies->total_format($product_price*$times);
                    //德国仓展示税收
                    $priceHtml .= '<p class="detail_proPrice2">'.$taxPriceText. FS_PRICE_INCL_VAT . '</p>';
                }
            }
        }elseif(strtolower($_SESSION['countries_iso_code'])=='sg'){
            $Excl_tax =' (Excl. GST)';
            $taxPriceText = $currencies->total_format($product_price * 1.07);
            $taxPriceHtml = '<p class="detail_proPrice2">'.$taxPriceText.' (Incl. GST)</p>';

			$priceHtml .= $priceText.$Excl_tax.$taxPriceHtml;
        }else{
		    if (strtolower($_SESSION['languages_code']) == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))) {
		        $current_vat = get_current_vat_by_languages_code();
                $taxPriceText = $currencies->total_format($product_price * (1 + $current_vat[2]));
                $taxPriceHtml = '<p class="detail_proPrice2">'.$taxPriceText.' TTC</p>';
                $priceHtml .= $priceText.$taxPriceHtml;
            } else {
                $priceHtml .= $priceText;
            }


		}
		echo $priceHtml;
	}
	/* products price show end 装箱专题链接 已找ternence确认功能已下线，因此屏蔽代码   add by rebirth 2019/08/26*/
//	$discountPrice = get_discount_product_qty((int)$_GET['products_id']);
//	if((int)$discountPrice>0){
//		echo '<div class="p_product_details"> <a href="'.zen_href_link('gx_news_fhd','&type='.get_oders((int)$_GET['products_id']).'').'" target="_blank"><em>'.$currencies->display_price($discountPrice,0).'</em>'.FS_PRODUCTS_TRAN.'</a></div>';
//	}
	if(3001==$cPath_array[3]){ 
		echo '<span class="product_info_per_meter" id="products_base_price_per_meter"> ( '.FS_PRODUCTS_PER_METER.' ) </span>';
	}
	/*
	 * 经查看代码fs_product_custom_html_forID()函数不会输出任何内容，此段代码可以先注释 ery 2020.11.28
	 * if('34747' == $_GET['products_id'] || '34760' == $_GET['products_id'] || '34778' == $_GET['products_id']){
		echo fs_product_custom_html_forID(FS_PRODUCTS_PRICE_JUST);
	}elseif ('17346' == $_GET['products_id']) {
		echo fs_product_custom_html_forID(FS_PRODUCTS_UNIT_PRICE);
	}elseif(in_array($_GET['products_id'],array(34946,34849,34947))) {
		$p_des =FS_PRODUCTS_PRICE_OF.zen_get_products_model((int)$_GET['products_id']).', '.FS_PRODUCTS_NO_INCLUDEING;
		echo fs_product_custom_html_forID($p_des);
	}
	if($products_price_description){
		if($cPath_array[2] != 1187){
			echo fs_product_custom_html_forID($products_price_description);
		}
	}else{
		if(strpos($products_name,'Plenum')){
			echo fs_product_custom_html_forID(FS_PRODUCTS_INVENTORY_CHANGE);
		}
	}*/
	?>
</div>
<?php // 清仓原价展示
if(!in_array($_SESSION['languages_code'],array('uk','au','jp','de','dn')) && strtolower($_SESSION['countries_iso_code']) !='ru'){
	//原价获取
//	$is_inquiry_cle_sql = $db->Execute("select is_inquiry,products_status FROM products where products_id = ".$_GET['products_id']);
//	$is_inquiry_cle = $is_inquiry_cle_sql->fields['is_inquiry'];  //这里 main_template_vars中已经查询出来了 不必再次查询
	if($is_clearance_pri){
		if ($products_is_inquiry !=1) {
			$product_list_content .= '<strong class="old_price_z">';
			if ($integer_state!=1) {
				//取整
				$product_list_content .= $currencies->new_format($clearance_price);
			} else {
				//不取整
				$product_list_content .= $currencies->format($clearance_price);
			}
			$product_list_content .= '<span class="old_price_line"></span></strong>';
			echo $product_list_content;
		}
	}
}
?>
<?php /***   装箱产品展示节省价格板块 展示在产品价格下面  start   ***/?>
<div class="fs_pro_Prodiscount_box" style="display:none">
    <?php
    $packing_conditions = get_product_packing_conditions($_GET['products_id']);
    if($_SESSION['languages_code']=='en' && $packing_conditions['discount'] && strtolower($_SESSION['countries_iso_code']) !='ru'){
        $price_currency =str_replace($currencies->currencies[$_SESSION['currency']]['symbol_left'],'',$product_price);
        $price_currency =str_replace($currencies->currencies[$_SESSION['currency']]['symbol_right'],'',$price_currency);
        $price_currency = $currencies->currencies[$_SESSION['currency']]['symbol_left'].sprintf('%.2f', $price_currency * (1-$packing_conditions['discount'])).$currencies->currencies[$_SESSION['currency']]['symbol_right'];
        echo '<div class="fs_clh_Prodiscount_new">'.FS_COMMON_SAVE.' '.$price_currency.'</div>';
    } ?>
</div>
<?php /***   装箱产品展示节省价格板块 end   ***/?>

<?php
/**美国站且国家为美国以及波多黎各非重货才展示Import Fees板块 2020.3.18 ery**/
$import_fees_html = '';
if($shipping_info->check_en_us_site()){
    $import_fees_html = get_gsp_detail_html();
    $import_fees_html = '<div class="fs-gspType-tipsBox" id="import_fees">'.$import_fees_html.'</div>';
}
echo $import_fees_html;
?>
