<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$action = $_GET['ajax_request_action'];
if (isset($action)) {
    $page = (($_POST['page']-1)*24).",".$_POST['page']*24;
    if(isset($_POST['order']) && !empty($_POST['order'])){
        if($_POST['order']=='asc'){
            $getNewProducts = $db->getAll("select p.number_of_son,p.products_model,p.products_price,p.products_price_old,p.products_id,p.discount_price,pd.products_name from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd using(products_id) where p.new_stata ='1'
     and p.products_status = 1 and pd.language_id =".$_SESSION['languages_id']." order by p.products_price asc limit $page");
        }elseif($_POST['order']=='desc'){
            $getNewProducts = $db->getAll("select p.number_of_son,p.products_model,p.products_price,p.products_price_old,p.products_id,p.discount_price,pd.products_name from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd using(products_id) where p.new_stata ='1'
     and p.products_status = 1 and pd.language_id =".$_SESSION['languages_id']." order by p.products_price desc limit $page");
        }else{
            $getNewProducts = $db->getAll("select p.number_of_son,p.products_model,p.products_price,p.products_price_old,p.products_id,p.discount_price,pd.products_name from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd using(products_id) where p.new_stata ='1'
     and p.products_status = 1 and pd.language_id =".$_SESSION['languages_id']." order by p.products_date_added desc limit $page");
        }
    }else{
        if(isset($_POST['news']) && !empty($_POST['news'])){
            $getNewProducts = $db->getAll("select p.number_of_son,p.products_model,p.products_price,p.products_price_old,p.products_id,p.discount_price,pd.products_name from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd using(products_id) where p.new_stata ='1'
    and p.products_status = 1 and pd.language_id =".$_SESSION['languages_id']." order by p.products_date_added desc limit $page");
        }else{
            $getNewProducts = $db->getAll("select p.number_of_son,p.products_model,p.products_price,p.products_price_old,p.products_id,p.discount_price,pd.products_name from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd using(products_id) where p.new_stata ='1'
    and p.products_status = 1 and pd.language_id =".$_SESSION['languages_id']." order by p.new_product_ordering desc limit $page");

        }
    }
    if(!empty($getNewProducts)){
     $html="";
        foreach ($getNewProducts as $k=>$v){
            $wp_image = zen_get_products_image_of_products_id($v['products_id']);
			$image = get_resources_img($v['products_id'], '150', '150', $wp_image, '', '', ' style="position: absolute;top: 0;" ');
            $html.=' <dl class="New_centent_right_ul_dl">
                            <dt>
                                <a href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $v['products_id'], 'NONSSL').'">'.$image.'</a>
                            </dt>
                            <dd>
                                <p class="New_centent_right_ul_p"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $v['products_id'], 'NONSSL').'">'.$v['products_name'].'</a>
                                </p>
                                <h2 class="New_centent_right_ul_h2">'.$currencies->display_price($v['products_price'], 0).'</h2>';
            $NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($v['products_id']);
            $html.= $NowInstockQTY;
            $html.='</dd></dl>';
        }
    }
    if(count($getNewProducts)<24){
        $html.='<script type="text/javascript">$(".load_more").hide();</script>';
    }
        echo $html;
}