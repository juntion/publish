<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 10:23
 */
class ShippingInfo
{
    public $country_code;
    private $page_name;
    //1->德国;2->欧盟;3->美国;4->加拿大墨西哥;5 欧洲其他国家; 6 ->中国辐射地区
    private $warehouse;
    public $isCustom = false;
    //当前仓库库存
    public $qty = 0;
    private $all_qty = 0;
    //另外2个仓库库存
    private $us_qty = 0;
    private $eu_qty = 0;
    private $au_qty = 0;
    private $cn_qty = 0;
    private $sg_qty = 0;
    private $ru_qty = 0;
    //库存警戒线
    public $qty_line = 0;
    private $us_qty_line = 0;
    private $eu_qty_line = 0;
    private $au_qty_line = 0;
    private $sg_qty_line = 0;
    private $ru_qty_line = 0;
    private $over_stock_line = false;
    //当前仓库名称
    private $warehouse_name = "";
    //另外2个仓库名称
    private $us_name = "";
    private $de_name = "";
    private $au_name = "";
    private $cn_name = "";
    private $sg_name = "";
    private $ru_name = "";
    private $template_data = "";
    private $template_data_wdm = "";
    private $template_data_line = "";
    //是否展示三仓库存
    private $is_show_separate = true;
    private $overSizeProduct; // 超重产品清单
    public $isOverSize = false;
    public  $attributes = array();
    public  $length_array = array();
    private $city = "";
    public $state = "";
    private $customers_id;
    public $purchase_qty =1;
    public $attr_option_arr = array();//定制属性
    public $is_instock_route = "";//是否库存在途
    public $weight = 0;
    public $post_code = "";
    public $pure_price = 0;
    public $country_id = "";
    public $country_name = "";
    private $language_code;
    public $shipping_postCode = "";
    private $is_tag = false;
    public  $main_page;
    private $is_buck = false;
    private  $products_leadtime = 15;
    private  $related_preorder_product_id = NULL;
    private $isShowNotice = true;
    public  $is_pre_product  = false;
    public $is_shipping_free = false;
    public $is_cabinet = false;
    public $isInstock = 0;
    public $is_default_methods = "";
    private $current_category = 0;
    private $is_set_custome_tag;
    private $local_warehouse = "";
    private $spec_heavy_arr = [18543, 18544, 58708, 58727, 69075, 71024];
    private $is_heavy_free = false;
    //add by ternence 部分光模块总库存
    private $associated_inventory = 0;
    //模块标签产品  是否勾选了标签
    private $is_label = false;
    //针对GSP项目本地，国内都无库存
    private $InCnStock = 0;
    //锂电池标识
    private $is_lithium_battery = false;
    //组合产品无库存产品ID和属性
    public $composite_data = ['attr'=>'','products'=>[]];
    //定制产品部分属性匹配毛料ID库存和交期数组
    public $material_data = array();
    public $settingDay=0;//运输时效

    public $productQty=[];//该产品所有仓库的库存信息

    public function __construct($config=array())
    {
        $this->page_name = isset($config['page_name']) ? $config['page_name'] : "product_info";
        $this->pid = isset($config['pid']) ? (int)$config['pid'] : "";
        $this->state = isset($config['state']) ? $config['state'] : "";
        $this->productQty = isset($config['productQty']) ? $config['productQty'] : "";
        $this->post_code = isset($config['post_code']) ? $config['post_code'] : "";
        $this->current_category =  isset($config['current_category']) && is_array($config['current_category']) ? $config['current_category'] : [];
        $is_set_custome_tag = $config['is_set_custome_tag'];
        $this->country_code = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : "US";
        $this->customers_id  = $_SESSION['customer_id'] ? $_SESSION['customer_id'] : "" ;
        $this->language_code = $_SESSION['languages_code'];
        $this->attr_option_arr = isset($config['attr_option_arr']) ? $config['attr_option_arr'] : array();
        $this->purchase_qty = isset($config['purchase_qty']) ? $config['purchase_qty'] : 1;
        $this->material_data = sizeof($config['material_data']) ? $config['material_data'] : ['materialProductsId'=>0, 'materialStockLength'=>0, 'materialLeadTime'=>0, 'materialDelay'=>0];
        if(sizeof($this->attr_option_arr)){
            $this->composite_data['attr'] = reorder_options_values($this->attr_option_arr);
        }
        //判断模块选择标签产品
        $this->attributes = isset($config['attributes']) ?  $config['attributes'] : array();
        if($this->attr_option_arr){
            if(isset($config['attributes']) && $config['attributes'][318] || isset($config['label_option']) && in_array(318,$config['label_option'])){
                $this->is_label = true;
            }
        }
        if($_SESSION['site_code']=="dn"){
            $this->language_code = "de-en";
        }
        $this->shipping_postCode = $_SESSION['shipping_postCode_'.$this->language_code] ? $_SESSION['shipping_postCode_'.$this->language_code] : "";
        $this->main_page = $_GET['main_page'];
        if ($this->country_code == "DE") {
            //DE
            $this->warehouse = 1;
            $this->local_warehouse = 20;
        } elseif ($this->country_code == "US") {
            //US
            $this->warehouse = 3;
            $this->local_warehouse = 40;
        } elseif (german_warehouse("country_code", $this->country_code)) {
            //欧盟
            $this->warehouse = 2;
            $this->local_warehouse = 20;
        } elseif (other_eu_warehouse($this->country_code, "country_code")) {
            //other eu country
            $this->warehouse = 5;
            $this->local_warehouse = 20;
        } elseif (seattle_warehouse("country_code", $this->country_code)) {
            //ca || mx
            $this->warehouse = 4;
            $this->local_warehouse = 40;
        } elseif (au_warehouse($this->country_code,"country_code")) {
            $this->warehouse = 37;
            $this->local_warehouse = 37;
        } elseif (singapore_warehouse("country_code",$this->country_code)) {
            //新加坡仓
            $this->warehouse = 71;
            $this->local_warehouse = 71;
        } elseif (ru_warehouse('country_code', $this->country_code)) {
            //俄罗斯仓
            $this->warehouse = 67;
            $this->local_warehouse = 67;
        } else {
            //cn
            $this->warehouse = 6;
            $this->local_warehouse = 2;
        }
        $this->initWarehouse(0,$is_set_custome_tag);
        if ($this->all_qty==0) {
            $this->is_show_separate = false;
        }
        $this->overSizeProduct = [76880, 97949, 73579, 73958, 73984, 75869, 74126, 76887, 70855, 70856, 96682];
        if(in_array($this->pid,$this->overSizeProduct)){
            $this->isOverSize = true;
        }
    }

    //初始化3仓库存
    public function initWarehouse($pid = 0,$is_set_custome_tag = null){
        if(!$pid){
            $pid = $this->pid;
        }
        if(!$pid){
            return false;
        }
        //产品是否被 标记为待观察以及精简待关闭的判断放在set_products_info中一起查找 减轻SQL查询压力 2020.3.27 ery
        //$this->is_tag = $this->is_tag();

        $isGetAllStock = $this->isGetAllStock();
        if ($this->country_code == "DE") {
            //DE
            $this->warehouse = 1;
        } elseif ($this->country_code == "US") {
            //US
            $this->warehouse = 3;
        } elseif (german_warehouse("country_code", $this->country_code)) {
            //欧盟
            $this->warehouse = 2;
        } elseif (other_eu_warehouse($this->country_code, "country_code")) {
            //other eu country
            $this->warehouse = 5;
        } elseif (seattle_warehouse("country_code", $this->country_code)) {
            //ca || mx
            $this->warehouse = 4;
        } elseif (au_warehouse($this->country_code,"country_code")) {
            $this->warehouse = 37;
        } elseif (singapore_warehouse("country_code",$this->country_code)) {
            $this->warehouse = 71;
        } elseif (ru_warehouse('country_code', $this->country_code)) {
            $this->warehouse = 67;
        } else {
            //cn
            $this->warehouse = 6;
        }

        //是否是定制产品
        if(isset($is_set_custome_tag)){
            $this->isCustom = $is_set_custome_tag ? false : true;
        }else{
            $this->isCustom = $this->is_custom();
        }

        //前台取消警戒值设定 2020.11.21 dylan
        /*$mainId = $this->getMainId();
        $qty_line_data = fs_get_data_from_db_fields_array(['caution_us','caution_de','caution_au','caution_sg','caution_ru'],'products_instock_cautions','products_id ='.(int)$mainId);
        if(!empty($qty_line_data)) {
            $this->us_qty_line = (int)$qty_line_data[0][0];
            $this->eu_qty_line = (int)$qty_line_data[0][1];
            $this->au_qty_line = (int)$qty_line_data[0][2];
            $this->sg_qty_line = (int)$qty_line_data[0][3];
            $this->ru_qty_line = (int)$qty_line_data[0][4];
        }*/

        switch ($this->warehouse) {
            case 1:
            case 2:
            case 5:
                //如果模块产品选择标签  则当前库存为0
                if($this->is_label){
                    $qty = 0;
                }else{
                    $qty = $this->checkProductQty($pid, "DE", false, false, $this->composite_data);
                }
                $this->qty_line = $this->eu_qty_line;
                $this->is_instock_route = "in_de";
                if(!$isGetAllStock){
                    $us_qty = 0;
                    $cn_qty = 0;
                    $au_qty = 0;
                    $sg_qty = 0;
                    $ru_qty = 0;
                    if(($this->main_page == "index" && $qty==0 && !$this->isCustom) || (($this->qty_line > $qty) || !$this->qty)){
                        $cn_qty = $this->checkProductQty($pid, "CN", true);
                    }
                }else{
                    $us_qty = $this->checkProductQty($pid, "US", false)+$this->checkProductQty($this->pid,"US-ES",false);
                    $cn_qty = $this->checkProductQty($pid, "CN", true);
                    $sg_qty = $this->checkProductQty($pid, "SG", true);
                    $au_qty = $this->checkProductQty($pid, "AU", false);
                    $ru_qty = $this->checkProductQty($pid, "RU", true);
                }
                $all_qty = $qty + $us_qty + $cn_qty + $au_qty + $sg_qty + $ru_qty;
                $this->warehouse_name = FS_WAREHOUSE_EU;
//                if($this->country_code == "DE"){
//                    $this->warehouse_name = FS_DE_MUNICH;
//                }
                $this->us_name = FS_WAREHOUSE_US;
                $this->cn_name = FS_CN_APAC;
                $this->au_name = FS_WAREHOUSE_AU;
                $this->sg_name = FS_WAREHOUSE_SG;
                $this->ru_name = FS_WAREHOUSE_RU;
                $this->us_qty = $us_qty;
                $this->cn_qty = $cn_qty;
                $this->au_qty = $au_qty;
                $this->sg_qty = $sg_qty;
                $this->ru_qty = $ru_qty;
                $this->template_data = array(
                    $this->au_name => $au_qty,
                    $this->us_name => $us_qty,
                    $this->cn_name => $cn_qty,
                    $this->sg_name => $sg_qty,
                    $this->ru_name => $ru_qty,
                );
                $this->template_data_wdm = array(
                    '3' => $us_qty,
                    '2' => $qty,
                    '37' => $au_qty,
                    '6' => $cn_qty,
                    '71' => $sg_qty,
                    '67' => $ru_qty,
                );
                break;
            case 3:
            case 4:
                //美东+美西库存汇总
                //如果模块产品选择标签  则当前库存为0
                if($this->is_label){
                    $qty = 0;
                }else{
                    $qty = $this->checkProductQty($pid, "US", false, false, $this->composite_data)+$this->checkProductQty($this->pid,"US-ES",false,false,$this->composite_data);
                }
                $this->qty_line = $this->us_qty_line;
                $this->is_instock_route = "in_us";
                if(!$isGetAllStock){
                    $de_qty = 0;
                    $cn_qty = 0;
                    //列表页当前国家是美国或波多黎各时,本地仓无库存需要查中国仓库存
                    $countries_code = strtolower($_SESSION['countries_iso_code']);
                    if((in_array($countries_code, ['us', 'pr']) && $this->main_page == "index" && $qty==0) || (($this->qty_line > $qty) || !$this->qty)){
                        $cn_qty = $this->checkProductQty($pid, "CN", true);
                    }
                    $au_qty = 0;
                    $sg_qty = 0;
                    $ru_qty = 0;
                }else{
                    $de_qty = $this->checkProductQty($pid, "DE", false);
                    $cn_qty = $this->checkProductQty($pid, "CN", true);
                    $au_qty = $this->checkProductQty($pid, "AU", false);
                    $sg_qty = $this->checkProductQty($pid, "SG", false);
                    $ru_qty = $this->checkProductQty($pid, "RU", false);
                }
                $all_qty = $qty + $de_qty + $cn_qty + $au_qty + $sg_qty + $ru_qty;
                $this->warehouse_name = FS_WAREHOUSE_US;
                if($this->warehouse == 3){
                    $this->warehouse_name = FS_WAREHOUSE_US;
                }
                $this->eu_name = FS_WAREHOUSE_EU;
                $this->cn_name = FS_CN_APAC;
                $this->au_name = FS_WAREHOUSE_AU;
                $this->sg_name = FS_WAREHOUSE_SG;
                $this->ru_name = FS_WAREHOUSE_RU;
                $this->de_qty = $de_qty;
                $this->cn_qty = $cn_qty;
                $this->au_qty = $au_qty;
                $this->sg_qty = $sg_qty;
                $this->ru_qty = $ru_qty;
                $this->template_data = array(
                    $this->au_name => $au_qty,
                    $this->eu_name => $de_qty,
                    $this->cn_name => $cn_qty,
                    $this->sg_name => $sg_qty,
                    $this->ru_name => $ru_qty,
                );
                $this->template_data_wdm = array(
                    '3' => $qty,
                    '2' => $de_qty,
                    '37' => $au_qty,
                    '6' => $cn_qty,
                    '71' => $sg_qty,
                    '67' => $ru_qty,
                );
                break;
            case 37:
                //如果模块产品选择标签  则当前库存为0
                if($this->is_label){
                    $qty = 0;
                }else{
                    $qty = $this->checkProductQty($pid, "AU", false, false, $this->composite_data);
                }
                $this->qty_line = $this->au_qty_line;
                $this->is_instock_route = "in_au";
                if(!$isGetAllStock){
                    $de_qty = 0;
                    $cn_qty = 0;
                    $us_qty = 0;
                    $sg_qty = 0;
                    $ru_qty = 0;
                    if($this->main_page == "index" && $qty==0 && !$this->isCustom || (($this->qty_line > $qty) || !$this->qty)){
                        $cn_qty = $this->checkProductQty($pid, "CN", true);
                    }
                }else{
                    $de_qty = $this->checkProductQty($pid, "DE", false);
                    $cn_qty = $this->checkProductQty($pid, "CN", true);
                    $sg_qty = $this->checkProductQty($pid, "SG", true);
                    $ru_qty = $this->checkProductQty($pid, "RU", false);
                    $us_qty = $this->checkProductQty($pid, "US", false)+$this->checkProductQty($this->pid,"US-ES",false);
                }
                $all_qty = $qty + $de_qty + $cn_qty + $us_qty + $sg_qty + $ru_qty;
                $this->warehouse_name = FS_AU_VIC;
                if($this->country_code == "NZ"){
                    $this->warehouse_name = FS_WAREHOUSE_AU;
                }
                $this->eu_name = FS_WAREHOUSE_EU;
                $this->cn_name = FS_CN_APAC;
                $this->us_name =  FS_WAREHOUSE_US;
                $this->sg_name =  FS_WAREHOUSE_SG;
                $this->ru_name =  FS_WAREHOUSE_RU;
                $this->de_qty = $de_qty;
                $this->cn_qty = $cn_qty;
                $this->us_qty = $us_qty;
                $this->sg_qty = $sg_qty;
                $this->ru_qty = $ru_qty;
                $this->template_data = array(
                    $this->us_name => $us_qty,
                    $this->eu_name => $de_qty,
                    $this->cn_name => $cn_qty,
                    $this->sg_name => $sg_qty,
                    $this->ru_name => $ru_qty,
                );
                $this->template_data_wdm = array(
                    '3' => $us_qty,
                    '2' => $de_qty,
                    '37' => $qty,
                    '6' => $cn_qty,
                    '71' => $sg_qty,
                    '67' => $ru_qty,
                );
                break;
            case 71:
                //如果模块产品选择标签  则当前库存为0
                if($this->is_label){
                    $qty = 0;
                }else {
                    $qty = $this->checkProductQty($pid, "SG", false, false, $this->composite_data);
                }
                $this->qty_line = $this->sg_qty_line;
                $this->is_instock_route = "in_cn";
                if(!$isGetAllStock){
                    $de_qty = 0;
                    $cn_qty = 0;
                    $us_qty = 0;
                    $au_qty = 0;
                    $ru_qty = 0;
                    if($this->main_page == "index" && $qty==0 && !$this->isCustom || (($this->qty_line > $qty) || !$this->qty)){
                        $cn_qty = $this->checkProductQty($pid, "CN", true);
                    }
                }else{
                    $de_qty = $this->checkProductQty($pid, "DE", false);
                    $cn_qty = $this->checkProductQty($pid, "CN", true);
                    $au_qty = $this->checkProductQty($pid, "AU", false);
                    $ru_qty = $this->checkProductQty($pid, "RU", false);
                    $us_qty = $this->checkProductQty($pid, "US", false)+$this->checkProductQty($this->pid,"US-ES",false);
                }
                $all_qty = $qty + $de_qty + $cn_qty + $us_qty + $au_qty + $ru_qty;
                $this->warehouse_name = FS_WAREHOUSE_SG;
                if($this->country_code == "SG"){
                    $this->warehouse_name = FS_WAREHOUSE_SG;
                }
                $this->eu_name = FS_WAREHOUSE_EU;
                $this->cn_name = FS_CN_APAC;
                $this->us_name =  FS_WAREHOUSE_US;
                $this->au_name = FS_WAREHOUSE_AU;
                $this->ru_name = FS_WAREHOUSE_RU;
                $this->de_qty = $de_qty;
                $this->cn_qty = $cn_qty;
                $this->us_qty = $us_qty;
                $this->au_qty = $au_qty;
                $this->ru_qty = $ru_qty;
                $this->template_data = array(
                    $this->us_name => $us_qty,
                    $this->eu_name => $de_qty,
                    $this->cn_name => $cn_qty,
                    $this->au_name => $au_qty,
                    $this->ru_name => $ru_qty,
                );
                $this->template_data_wdm = array(
                    '3' => $us_qty,
                    '2' => $de_qty,
                    '37' => $au_qty,
                    '6' => $cn_qty,
                    '71' => $qty,
                    '67' => $ru_qty,
                );
                break;
            case 67:
                //如果模块产品选择标签  则当前库存为0
                if($this->is_label){
                    $qty = 0;
                }else {
                    $qty = $this->checkProductQty($pid, "RU", false, false, $this->composite_data);
                }
                $this->qty_line = $this->ru_qty_line;
                $this->is_instock_route = "in_ru";
                if(!$isGetAllStock){
                    $de_qty = 0;
                    $cn_qty = 0;
                    $us_qty = 0;
                    $au_qty = 0;
                    $sg_qty = 0;
                    if($this->main_page == "index" && $qty==0 && !$this->isCustom || (($this->qty_line > $qty) || !$this->qty)){
                        $cn_qty = $this->checkProductQty($pid, "CN", true);
                    }
                }else{
                    $de_qty = $this->checkProductQty($pid, "DE", false);
                    $cn_qty = $this->checkProductQty($pid, "CN", true);
                    $au_qty = $this->checkProductQty($pid, "AU", false);
                    $sg_qty = $this->checkProductQty($pid, "SG", false);
                    $us_qty = $this->checkProductQty($pid, "US", false)+$this->checkProductQty($this->pid,"US-ES",false);
                }
                $all_qty = $qty + $de_qty + $cn_qty + $us_qty + $au_qty + $sg_qty;
                $this->warehouse_name = FS_WAREHOUSE_RU;
                if($this->country_code == "RU"){
                    $this->warehouse_name = FS_WAREHOUSE_RU;
                }
                $this->eu_name = FS_WAREHOUSE_EU;
                $this->cn_name = FS_CN_APAC;
                $this->us_name =  FS_WAREHOUSE_US;
                $this->au_name = FS_WAREHOUSE_AU;
                $this->sg_name = FS_WAREHOUSE_SG;
                $this->de_qty = $de_qty;
                $this->cn_qty = $cn_qty;
                $this->us_qty = $us_qty;
                $this->au_qty = $au_qty;
                $this->sg_qty = $sg_qty;
                $this->template_data = array(
                    $this->us_name => $us_qty,
                    $this->eu_name => $de_qty,
                    $this->cn_name => $cn_qty,
                    $this->au_name => $au_qty,
                    $this->sg_name =>  $sg_qty,
                );
                $this->template_data_wdm = array(
                    '3' => $us_qty,
                    '2' => $de_qty,
                    '37' => $au_qty,
                    '6' => $cn_qty,
                    '71' => $sg_qty,
                    '67' => $qty,
                );
                break;
            default:
                //如果模块产品选择标签  则当前库存为0
                if($this->is_label){
                    $qty = 0;
                }else {
                    $qty = $this->checkProductQty($pid, "CN", true, false, $this->composite_data);
                }
                $this->is_instock_route = "in_cn";
                if(!$isGetAllStock){
                    $de_qty = 0;
                    $us_qty = 0;
                    $au_qty = 0;
                    $sg_qty = 0;
                    $ru_qty = 0;
                }else{
                    $de_qty = $this->checkProductQty($pid, "DE", false);
                    $sg_qty = $this->checkProductQty($pid, "SG", false);
                    $ru_qty = $this->checkProductQty($pid, "RU", false);
                    $us_qty = $this->checkProductQty($pid, "US", false)+$this->checkProductQty($this->pid,"US-ES",false);
                    $au_qty = $this->checkProductQty($pid, "AU", false);
                }
                $all_qty = $de_qty + $us_qty + $qty + $au_qty + $sg_qty + $ru_qty;
                $this->warehouse_name = FS_CN_APAC;
                if($this->country_code == "CN"){
                    $this->warehouse_name = FS_CN_HUBEI;
                }
                $this->us_name = FS_WAREHOUSE_US;
                $this->eu_name = FS_WAREHOUSE_EU;
                $this->au_name = FS_WAREHOUSE_AU;
                $this->sg_name = FS_WAREHOUSE_SG;
                $this->ru_name = FS_WAREHOUSE_RU;
                $this->us_qty = $us_qty;
                $this->de_qty = $de_qty;
                $this->au_qty = $au_qty;
                $this->sg_qty = $sg_qty;
                $this->ru_qty = $ru_qty;
                $this->template_data = array(
                    $this->us_name => $us_qty,
                    $this->eu_name => $de_qty,
                    $this->au_name => $au_qty,
                    $this->sg_name => $sg_qty,
                    $this->ru_name => $ru_qty,
                );
                $this->template_data_wdm = array(
                    '3' => $us_qty,
                    '2' => $de_qty,
                    '37' => $au_qty,
                    '71' => $sg_qty,
                    '6' => $qty,
                    '67' => $ru_qty,
                );
        }

        $this->template_data_line = array(
            FS_WAREHOUSE_US => in_array($this->warehouse, [3,4]) ? $qty : (int)$us_qty,
            FS_WAREHOUSE_EU => in_array($this->warehouse, [1,2,5]) ? $qty : (int)$de_qty,
            FS_WAREHOUSE_AU => in_array($this->warehouse, [37]) ? $qty : (int)$au_qty,
            FS_WAREHOUSE_SG => in_array($this->warehouse, [71]) ? $qty : (int)$sg_qty,
            FS_WAREHOUSE_RU => in_array($this->warehouse, [67]) ? $qty : (int)$ru_qty
        );
        $this->qty = $qty;
        $this->all_qty = $all_qty;


        if($this->qty_line > $this->qty && $this->cn_qty > $this->qty){
            $this->over_stock_line = ture;
        }

        $warehouse_code = $this->local_warehouse;
        if($this->local_warehouse == '40' && $this->purchase_qty > $this->qty){
            $warehouse_code = '2';
        }

        if(in_array($this->pid,$this->spec_heavy_arr) && $this->purchase_qty > $this->qty){
            $this->is_buck = [$this->pid];
        }else {
            $heavy_products = get_heavy_products([$pid], $warehouse_code);
            $this->is_buck = $heavy_products['heavy_products'];
        }

        /**
         * 设置当前产品基本交期 以及 当前产品关联预售 产品id
         */
        $this->set_products_info();
    }


    /**
     * 检查是否已经传了库存数量 Bona.Guo 2021/2/26 16:31
     * @param $pid
     * @param $warehouseCode
     * @param bool $is_global
     * @param bool $is_custom
     * @param array $composite_data
     * @return int
     */
    public function checkProductQty($pid, $warehouseCode, $is_global = false, $is_custom = false, &$composite_data = [])
    {
        //旧版库存查询里面US仓已废弃
        if ($warehouseCode == 'US') {
            return 0;
        }

        $productQty = $this->productQty;

        //保留仓库code，用于旧版查询
        $warehouseCodeOld = $warehouseCode;

        //新版查询库存里面美东仓是"US"
        if ($warehouseCode == 'US-ES') {
            $warehouseCode = 'US';
        }
        if (isset($productQty[$warehouseCode])) {
            return $productQty[$warehouseCode]['currentQty'];
        } else {
            return zen_get_current_qty($pid, $warehouseCodeOld, $is_global, $is_custom, $composite_data);
        }
    }


    public function getMainId(){
        global $db;
        $related = $db->Execute("select {$this->cacheType} r.products_id,m.products_id as main_id from products_instock_add_related as r
                    left join products_instock_add_model as m using(model_id) where r.products_id = " . (int)$this->pid . '
                    order by r.warehouse asc limit 1');
        $productsID = $related->fields['main_id'] ? $related->fields['main_id'] : $this->pid;
        return $productsID;
    }

    public function  get_current_product_qty(){
           if($this->qty || $this->template_data_wdm[6]){
               return true;
           }else{
               return false;
           }
    }

    //展示微数据
    public function show_microdata()
    {
        //改用新版的微数据了
        //$html = "<link itemprop=\"itemCondition\" href=\"https://schema.org/NewCondition\">";
        $html = "";
        if ($this->all_qty == 0) {
            $html .= 'https://schema.org/OnlineOnly';
        } else {
            $html .= 'https://schema.org/InStock';
        }
        return $html;
    }

    /**
     * 是否获取除当前仓库外的其他仓库库存
     * add by Aron
     * created on 2019.5.29
     * @return bool
     */
    public function isGetAllStock()
    {//$this->is_label  如果模块产品 选择了标签则返回false
        if (($this->main_page == "index" && !isAjax()) || in_array($_GET['handler'],['pages_route']) || $this->is_label) {
            return false;
        }
        return true;
    }
    //展示item location
    public function get_warehouse_location()
    {
        if(seattle_warehouse("country_code",$_SESSION['countries_iso_code']) && in_array($_SESSION['languages_code'],array('en','fr','mx'))) {
            return "";
        }
        switch ($this->warehouse) {
            case 1:
            case 2:
            case 5:
                return $this->get_location_template(FS_SEATTLE_EU);
                break;
            case 3:
            case 4:
                return $this->get_location_template(FS_SEATTLE_WASHINGTON);
                break;
            case 37:
                return $this->get_location_template(ITEM_LOCATION_AU);
            default:
                return $this->get_location_template(FS_SEATTLE_CN);
        }
    }

    //item location template
    public function get_location_template($warehouse)
    {
        $is_show_location = false;
        if ($is_show_location) {
            return '<div class="product_03_01 product_03_12" id="item_loca">
                            <span class="pro_itme_location">'.FS_ITEM_LOCATION.'</span>
                            <span class="product_03_01 product_03_13">
                            <div class="item_location">
                                ' . $warehouse . '
                            </div>
                            </span>
                            </div>
                       <div class="ccc"></div>';
        }
        return "";
    }

    public function get_processing_days(){
        if($this->qty){ //本地仓有库存
            $processing_days = 0;
        }elseif ($this->material_data['materialProductsId'] && $this->material_data['materialStockLength'] > 0 && $this->material_data['materialLeadTime']){
            $processing_days = $this->material_data['materialLeadTime'];
        }else{
            $is_en_us = $this->check_en_us_site();
            $processing_days = get_custom_processing_days($this->pid,$this->attr_option_arr,$this->template_data_wdm[6],$this->is_buck,$is_en_us);
        }
        return $processing_days;
    }


    public function spring_festival_holiday($contain_weekday = true) {
        $spring_day = 0;
        if($this->local_warehouse==2 || $this->local_warehouse!=2 && !$this->qty) {
            $spring_day = get_spring_festival_holiday($contain_weekday);//春节假期
        }
        return $spring_day;
    }

    /**
     * 详情页加购弹窗使用
     * 本地仓定制产品有库存，加购弹窗添加节假日(除武汉仓)
     */
    public function get_festival_day($day = 0) {
        $festival_day = 0;
        if($this->qty && $this->local_warehouse!=2){
            $country_code = $this->country_code;
            $festival_day = get_festival_day($country_code, $day);
        }
        return $festival_day;
    }

    /**Dylan 2019.8.16
     * 详情页,分类页,购物车标准产品修改数量动态交期获取
     * @return int|mixed
     */
    public function get_standard_product_details_days(){
        $days = 0;
        if(!$this->is_custom() && !$this->qty){ //是标准产品且本地仓无库存改变数量才获取动态交期
            if($this->purchase_qty>$this->cn_qty){
                if(!$this->cn_qty){
                    $origin_day = 5;
                }else{
                    $origin_day = 7;
                }
                if($this->is_buck){
                    $origin_day = 0; //重货武汉直发
                }
                $days = get_standard_product_days($this->pid,$this->purchase_qty);
                if(all_german_warehouse("country_code",$this->country_code) || in_array($this->country_code,array('AU'))){
                    $days = $days + $origin_day;
                }
            }else{//标准产品国内仓有库存，且客户购买数量小于库存数量
                if(FS_IS_SPRING==1){
                    $days = 22;//非工作日
                }else{
                    if ($this->is_buck) {
                        $origin_day = 0; //重货武汉直发
                    } else {
                        $origin_day = 7;
                    }

                    if(in_array(strtolower($this->country_code),array('us','ca','mx','nz'))){
                        $ship_day = 1;
                    }elseif(all_german_warehouse("country_code",$this->country_code) || in_array($this->country_code,array('AU'))){
                        $ship_day = $origin_day;//转运需要加节假日
                    }else{
                        $ship_day = 0;
                    }
                    if(all_german_warehouse("country_code",$this->country_code) || in_array($this->country_code,array('AU'))){
                        $festival_day = get_festival_day($this->country_code,$ship_day);
                        $ship_day = $ship_day + $festival_day;
                    }
                    $days = $ship_day;
                }
            }
        }
        return $days;
    }

    //是否定制
    public function is_custom()
    {
        if(zen_get_products_length_total($this->pid) != 0 || zen_get_products_attributes_total($this->pid) != 0){
            $isNotCustom = true;
        }else{
            $isNotCustom = false;
        }
        return $isNotCustom;
    }


    //根据当前产品数量 展示单位
    private function get_unit_by_qty($qty)
    {
        if ($qty < 1) {
            $unit = QTY_SHOW_ZERO_STOCK_1;
        } else {
            $unit = QTY_SHOW_MORE_STOCK_2;
        }
        return $unit;
    }
    public function getNoticeInfo(){
        switch ($this->warehouse){
            case 1://de
            case 2:
            case 5:
                if($this->qty){
                    $html = FS_DE_NOTICE;
                }
                break;
            case 3://us,mx,ca
            case 4:
                if($this->qty){
                    $html = FS_US_NOTICE;
                }
                break;
            case 37://au
                if($this->qty){
                    $html = FS_AU_NOTICE;
                }
                break;
            case 71:
                if($this->qty){
                    $html = FS_SG_NOTICE;
                }
                break;
            case 67://ru
                if($this->qty){
                    $html = FS_RU_NOTICE;
                }
                break;
            default://cn
                if($this->qty){
                    $html = FS_CN_NOTICE;
                }
                break;
        }
        $this->isInstock = $this->isInstock ? $this->isInstock : 0;
        if(!$this->qty){//是否是在途库存
            if($this->isInstock){
                $html = FS_INSTOCK_NOTICE;
            }else{
                $html = FS_TRANSIT_NOTICE;
            }
        }
        if($this->isCustom && !$this->qty){//定制产品
            $html = FS_CUSTOM_NOTICE;
        }
        return $html;
    }

    public function match_product_change_pid($pid){
        //匹配到标准产品
        if($pid){
            $this->pid = (int)$pid;
            $this->initWarehouse();
        }
    }

    public function set_products_info($buy_product_qty = 0)
    {
        global $db;
        $warehouse_data = fs_products_warehouse_where();
        $warehouse_where = $warehouse_data['where'];
        $sqlCache = sqlCacheType();
        $sql = "select {$sqlCache} related_preorder_product_id,is_important,coming_close,products_leadtime,is_customized,associated_inventory_us,associated_inventory_au,associated_inventory_cn,associated_inventory_de,in_cn,is_lithium_battery 
          from " . TABLE_PRODUCTS . " p
          where  p.products_id = '" . $this->pid . "' and show_type=0 " . $warehouse_where;
        $res = $db->Execute($sql);
        //判断改产品是否被 标记为待观察以及精简待关闭 20.3.27 ery
        if (!$res->EOF) {
            $is_important = (int)($res->fields['is_important']);
            $coming_close = $res->fields['coming_close'];
            $this->InCnStock = $res->fields['in_cn'];
            if (in_array($is_important,array(0, 9)) || in_array($coming_close, array(1, 2))) {
                $this->is_tag = true;
            }
            $this->is_lithium_battery = $res->fields['is_lithium_battery'] ? true : false;
        }
        if($buy_product_qty){
            $this->purchase_qty = $buy_product_qty;
        }
        $this->is_pre_product = check_product_is_pre_product($this->pid);

        //add by ternence 光模块总库存字段添加
        if($warehouse_data['code']){
            switch ($warehouse_data['code']){
                case "us":
                    $this->associated_inventory = $res->fields['associated_inventory_us']?(int)$res->fields['associated_inventory_us']:0;
                    break;
                case "au":
                    $this->associated_inventory = $res->fields['associated_inventory_au']?(int)$res->fields['associated_inventory_au']:0;
                    break;
                case "de":
                    $this->associated_inventory = $res->fields['associated_inventory_de']?(int)$res->fields['associated_inventory_de']:0;
                    break;
                case "cn":
                    $this->associated_inventory = $res->fields['associated_inventory_cn']?(int)$res->fields['associated_inventory_cn']:0;
                    break;
                default;
            }
        }

        $qty_days=0;
        if($this->is_pre_product){ //预售产品备货交期
            $prep_attr = $this->attr_option_arr ? $this->attr_option_arr : array();
            $length="";
            if($this->purchase_qty > $this->cn_qty && empty($prep_attr)){
                $standard_product_days = get_standard_product_days($this->pid,$this->purchase_qty);
                $qty_days = $standard_product_days;
                if(all_german_warehouse("country_code",$this->country_code) || in_array(strtoupper($this->country_code),array('AU')) && $standard_product_days){
                    $qty_days +=5;
                }
            }
            if(!$qty_days){
                if($prep_attr && $prep_attr['length']){
                    $length = fs_get_data_from_db_fields('length','products_length','product_id='.(int)$this->pid.' and id='.(int)$prep_attr['length'],'limit 1');
                    unset($prep_attr['length']);
                }
                $qty_days = get_custom_products_attr_days($this->pid,$prep_attr,$length,$this->purchase_qty,true);
            }

        }
        if($qty_days){
            $process_days = $qty_days;
        }elseif($res->fields['products_leadtime']){
            $process_days = $res->fields['products_leadtime'];
        }else{
            $process_days = 15;
        }

        $post_code = $this->post_code ? : $this->shipping_postCode;
        if(in_array($this->pid, array(75869, 70973, 73579, 73958, 73984)) && $this->qty && $warehouse_data['code'] == 'us'){
            if($this->country_code == 'US'){
                $post_code = empty($post_code) ? 10010 : $post_code;
                $state = fs_get_data_from_db_fields('states', 'countries_to_zip', 'zip = "' . $post_code . '"');
                if(!empty($state)) {
                    $cabinet = fs_get_data_from_db_fields('id', 'shipping_ups_ltl', 'products_id = ' . $this->pid . ' AND country_id = 223 AND (state = "' . $state . '" OR state_abb = "' . $state . '")');
                    $this->is_cabinet = $cabinet ? true : false;
                    $this->state = $state;
                }
            }else{
                $this->is_cabinet = $this->country_code == 'PR' ? false : true;
            }
        }

        $this->products_leadtime = $process_days;
        $this->related_preorder_product_id = $res->fields['related_preorder_product_id'];
        $this->isCustom = $res->fields['is_customized'];
//        $this->is_pre_product = false;
//        $this->related_preorder_product_id = false;
    }

    /**
     * @param string $warehouse_name
     * @param $type
     * @return string
     * 分仓展示模板
     */
    public function get_template_for_products($warehouse_name = "",$type="",$page="",$mark=false)
    {
        $other_information = $this->show_detail_all_warehouse_stock_html();
        $instock_data = array(
            'qty' => $this->qty,
            'cn_qty' => $this->cn_qty,
            'warehouse' => $this->local_warehouse,
            'warehouseName' => $this->warehouse_name,
            'asia_warehouseName' => $this->get_local_warehouse_name(2),
        );
        if($mark){
            $instock_data['mark'] = $this->associated_inventory;
        }
        $overStockLine = $this->over_stock_line;
        $products_data = array(
            'in_cn' => $this->InCnStock ? true : false,
            'is_custom' => $this->is_custom(),
        );


        //小气泡提示语
        if($this->check_en_us_site()){
            if(strtoupper($this->country_code) == 'US'){
                $notice = FS_GSP_STOCK_9;
            }else{
                $notice = FS_GSP_STOCK_7;
            }
        }elseif(!$this->qty || $this->over_stock_line){
            $notice = FS_LOACAL_EMPTY_INSTOCK_SHOW;
        }else{
            $notice = $this->getNoticeInfo();
        }
        if(!$this->isShowNotice){
            $notice = "";
        }
        if(!empty($notice)){
            $notice = $this->getPopupNoticeTemplate($notice);
        }

        if($this->material_data['materialProductsId'] && $this->material_data['materialStockLength'] > 0){
            $instock_data['material_stock'] = $this->material_data['materialStockLength'];
        }
        $html = get_products_instock_template($instock_data,$products_data,$overStockLine,$page);
        if($page == 'details'){
            $html = str_replace('$OTHER_WAREHOUSE',$other_information,$html).$notice;
        }
        return $html;
    }
    /**
     * 展示库存数量
     * @param bool $custom
     * @return string
     * $type :1
     */
    public function get_warehouse_instock_qty($custom = false,$type="",$page="")
    {
        global $db;
        //add by ternence 光模块库存汇总 仅展示列表页和搜索
        if(!$page) {
            $page = in_array($this->main_page, array('advanced_search_result', 'index')) ? 'list' : '';
        }
        $mark = false;
        if($page=="list"){
            if((int)$this->associated_inventory>0){
                $mark = true;
                $current_qty = $this->associated_inventory;
            }else{
                $current_qty = $this->qty;
            }
        }else{
            $current_qty = $this->qty;
        }
        $template = $this->get_template_for_products('', $type, $page, $mark);
        $qty_html = $template;
        /*if($this->over_stock_line){//超过库存临界值
            $qty_html = $this->show_qty_line_html($page);
        }elseif(($this->check_en_us_site() || $this->check_eu_and_au_warehouse()) && $mark==false){
            //当前站点是美国站国家选择为美国或者波多黎各，且美东仓无库存
            $qty_html = $this->show_en_us_stock_html($page);
        }else{
            $unit = $this->get_unit_by_qty($current_qty);
            $qty = $current_qty.$unit;

            $custom = $this->isCustom;
            if($current_qty){
                $template = $this->get_template_for_products($qty . FS_EMAIL_PAUSE,$type,$page);
                $qty_html = $template;
            }else{
                if($custom){
                    $qty_html = '';
                }else {
                    $warehouse_name = QTY_SHOW_AVAILABLE;
                    //只要不是重货或者定制产品后面就可以拼接FS_EMAIL_PAUSE逗号常量
                    $warehouse_name = $warehouse_name . FS_EMAIL_PAUSE;

                    $qty_html = $template;

                }
            }
        }*/
        return $qty_html;
    }


    /**
     * @param int $settingDay
     * @return int
     */
    public function getProductShippingDays($settingDay=0){
        $country_code = $this->country_code;
        $postcode = $this->post_code;
        $day = 0;
        switch ($country_code){
            case "US":
                if(!empty($postcode)){
                    $us_qty = zen_get_current_qty($this->pid, "US", false);
                    $es_qty = zen_get_current_qty($this->pid,"US-ES",false);
                    $info = fs_get_data_from_db_fields_array(array('timeliness_md','timeliness_mx','zone'), 'countries_to_zip', 'zip ="'.$postcode.'" ');
                    $zone = $info[0][2];
                    $mx_day = $info[0][1];
                    $md_day = $info[0][0];
                    if($zone == 2){
                        if(($es_qty && $es_qty>=$this->purchase_qty)){
                            $day = $md_day;
                        }elseif ($us_qty && $us_qty>=$this->purchase_qty){
                            $day = $mx_day;
                        }else{
                            if(($es_qty&&!$us_qty)){
                                $day = $md_day;
                            }
                            if(!$es_qty && $us_qty){
                                $day = $mx_day;
                            }
                            if(!$es_qty && !$us_qty){
                                $day = $md_day;
                            }
                            if($es_qty && $us_qty){
                                $day = $mx_day;
                            }
                        }

                    }else{
                        if(($us_qty && $us_qty>=$this->purchase_qty)){
                            $day = $mx_day;
                        }elseif ($es_qty && $es_qty>=$this->purchase_qty){
                            $day = $md_day;
                        }else{
                            if(($us_qty && !$es_qty)){
                                $day = $mx_day;
                            }
                            if($es_qty && !$us_qty){
                                $day = $md_day;
                            }
                            if($es_qty && $us_qty){
                                $day = $mx_day;
                            }
                            if(!$es_qty && !$us_qty){
                                $day = $md_day;
                            }
                        }
                    }
                }
                if(empty($day)){
                    $day = 2;
                }
                if ((getTime("D", time(), $country_code) == "Sun" || getTime("D", time(), $country_code) == "Sat") || (getTime("D", time(), $country_code) == "Fri" && $hour >= 16)) {
                    if (getTime("D", time(), $country_code) == "Sun") {
                        $day += 1;
                    } elseif (getTime("D", time(), $country_code) == "Fri") {
                        $festival_day = get_festival_day($country_code);
                        $add_day = (3-$festival_day) < 0 ? 0 : (3-$festival_day);
                        $day += $add_day;
                    }else{
                        $day += 2;
                    }
                }
                break;
            case in_array($country_code,array("MX","CA")):
                $day = 3;
                break;
            case in_array($country_code,array("DE", "BE", "LU" ,"CZ")):
                $day = 1;
                break;
            case "GB":
                $day = 2;
                break;
            case in_array($country_code,  array("NL", "FR", "MC", "IT", "IE", "DK", "AT", "SE", "PL", "CY", "SK", "HU", "SI", "CH", "ES", "MT","VA")):
                $day = 2;
                break;
            case in_array($country_code,array("PT", "FI", "LV", "LT", "RO", "HR", "NO")):
                $day = 3;
                break;
            case in_array($country_code,array("BG", "GR", "EE")):
                $day = 4;
                break;
        }
        return $day;
    }


    /**Dylan 2019.8.23 Add
     * 针对清仓产品加购限制
     * 得到武汉仓和本地仓的库存总数
     */
    public function getLocalAndWuhanqty(){
        switch ($this->warehouse){
            case '6':
                return $this->qty;
                break;
            default:
                return $this->cn_qty+$this->qty;
                break;
        }
    }

    /**
     * 展示运输时间
     * @return string
     */
    public function getShippingDate($settingDay=0,$shipping_methods=''){
        $country_code = $this->country_code;
        $is_en_us = $this->check_en_us_site($country_code);
        $day = 0;
        $str = "";
        $qty = $this->qty;
        $area = fs_get_data_from_db_fields('time_zone','country_time_zone','code="'.strtoupper($country_code).'"','limit 1');
        $area = $area ? $area : "";
        if(!$settingDay && $shipping_methods){
            $settingDay = $this->getSettingDay($shipping_methods);
        }
        $express = FS_SHIP_ESTIMATED;
        if($settingDay){
            $express = FS_FOR_FREE_SHIPPING_GET_ARRIVE;
        }
        $spring_days = $this->spring_festival_holiday();//春节假期
        $spring_days = (int)$spring_days;

        if($this->material_data['materialProductsId'] && $this->material_data['materialStockLength'] > 0 && $this->material_data['materialLeadTime']){
            $day = $this->material_data['materialLeadTime'] + $settingDay;
            if($spring_days){
                $day = get_specific_date_of_days((int)($day),2,$spring_days) + $spring_days;
            }else{
                $day = get_specific_date_of_days($day,2);
            }
            if(in_array($_SESSION['languages_code'],array('uk','au','dn'))){
                $ship_date = getTime('D. ', strtotime('+'. $day . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $day . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $day . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $day . ' days'),$country_code,"",true,$area);
            }else{
                $ship_date = getTime('D. M. j', strtotime('+'. $day . ' days'),$country_code,"",true,$area);
            }
            $ship_day = "<span class='pid_ship_date'>".get_date_product_delivery($ship_date,$_SESSION['languages_id'],2)."</span>";
            return $express." ".$ship_day;
        }

        if($qty && !$this->over_stock_line){
            $spring_days = $this->spring_festival_holiday();//春节假期
            $spring_days = (int)$spring_days;
            $festival_day = get_festival_day($country_code); //当天是否是节假日

            $extensionTime=0;
            //除国内仓以外 如果当地时间超过本地发货时间+1day (针对本地仓有库存)
            if ($this->local_warehouse != 2 && $this->getWarehouseDeliveryDeadline()) {
                $extensionTime=1;
            }

            //展示ship today 排除周末或者节假日
            if($festival_day) {
                $spring_days_weekend = $festival_day;
            } else {
                $spring_days_weekend = postponed_weekend($spring_days,$area,$country_code); // 遇到周末顺延
            }
            if($settingDay){
                $day = $settingDay+$extensionTime;
            }
            if($day){
                if($spring_days){
                    $day = get_specific_date_of_days((int)($day),2,$spring_days) + $spring_days;
                }else{
                    $day = get_specific_date_of_days($day,2,$spring_days_weekend)+$spring_days_weekend;
                }
                $day += get_festival_day($country_code,$day);   // 收货时间遇到节假日顺延
                $day = postponed_weekend($day,$area,$country_code);

                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $date = getTime('D. ', strtotime('+'. $day . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $day . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $day . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $day . ' days'),$country_code,"",true,$area);
                }else{
                    $date = getTime('D. M. j', strtotime('+'. $day . ' days'),$country_code,"",true,$area);
                }
                $str = $express." ".get_date_product_delivery($date,$_SESSION['languages_id'],2);
            }else{
                if($spring_days_weekend){
                    $spring_days_weekend += get_festival_day($country_code,$spring_days_weekend);   // 收货时间加上节假日
                    $spring_days_weekend = postponed_weekend($spring_days_weekend,$area,$country_code);  //遇到节假日刚好是周五，周末顺延
                    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                        $date = getTime('D. ', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area);
                    }else{
                        $date = getTime('D. M. j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area);
                    }
                } else {
                    if ($extensionTime) {
                        $extensionTime += get_festival_day($country_code,$extensionTime);   // 收货时间加上节假日
                        $extensionTime = postponed_weekend($extensionTime,$area,$country_code);  //遇到节假日刚好是周五，周末顺延
                        if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                            $date = getTime('D. ', strtotime('+'. $extensionTime . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $extensionTime . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $extensionTime . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $extensionTime . ' days'),$country_code,"",true,$area);
                        }else{
                            $date = getTime('D. M. j', strtotime('+'. $extensionTime . ' days'),$country_code,"",true,$area);
                        }
                    }
                }
                //当前仓库有库存能立即发货未统计到具体的get it by到货时效的展示Ship today
                $str = $spring_days_weekend ? $express." ".get_date_product_delivery($date,$_SESSION['languages_id'],2) : ($extensionTime ? $express." ".get_date_product_delivery($date,$_SESSION['languages_id'],2) : ucfirst(strtolower(FS_SHIP_TODAY)));
            }
            /*if(($this->main_page == "shopping_cart" && !in_array($this->country_code,['US','PR'])) || $this->main_page == "print_shopping_list" || $this->main_page == "saved_cart_details"){
                if($spring_days_weekend){
                    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                        $date = getTime('D. ', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area);
                    }else{
                        $date = getTime('D. M. j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area);
                    }
                }

                $str = $spring_days_weekend ? $express." ".get_date_product_delivery($date,$_SESSION['languages_id']) : FS_SHIP_SAME_DAY;
            }*/
            if(in_array($shipping_methods,array('saturdaydeliveryzones','dhlsaturdayzones'))&& !empty($shipping_methods)){//周六达快递只在周六送货
                for($i=0;$i<8;$i++){
                    $d = getTime('D',strtotime('+'.$i.' days'),$country_code,"",true,$area);
                    if($d == 'Sat'){
                        if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                            $date = getTime('D. ', strtotime('+'. $i . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $i . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $i . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $i . ' days'),$country_code,"",true,$area);
                        }else{
                            $date = getTime('D. M. j', strtotime('+'. $i . ' days'),$country_code,"",true,$area);
                        }
                        $str = FS_FOR_FREE_SHIPPING_GET_ARRIVE . " ".get_date_product_delivery($date,$_SESSION['languages_id'],2);
                    }
                }
            }
            if($shipping_methods == 'grabexpresszones'){
                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $date = getTime('D. ', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area);
                }else{
                    $date = getTime('D. M. j', strtotime('+'. $spring_days_weekend . ' days'),$country_code,"",true,$area);
                }
                $str = $spring_days_weekend ? $express." ".get_date_product_delivery($date,$_SESSION['languages_id'],2) : FS_SHIP_GET_TODAY;
            }
        }else{
            $en_us_data = array(
                'is_en_us' => $is_en_us,
                'transport_time' => $settingDay, //2天内部处理时间和运输时效
                'shipping_method' => $this->is_default_methods,
            );
            if(sizeof($this->composite_data['products'])){
                //当前产品是组合产品 且子产品无库存 获取子产品中交期最长的
                $warehouse = get_country_relate_warehouse($country_code);
                $max_data = get_max_date($this->composite_data['products'], $warehouse, $country_code,$en_us_data);
                $products_ship_time = $max_data['max_time']['time'];
                if(in_array($_SESSION['languages_code'],array('uk','au','dn'))){
                    $ship_date = getTime('D. ', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area).' '.getTime('j', strtotime('+' . $products_ship_time . ' days'), $country_code,"",true,$area).getLast(getTime('j', strtotime('+' . $products_ship_time . ' days'), $country_code,"",true,$area)).' '.getTime('M.', strtotime('+' . $products_ship_time . ' days'), $country_code,"",true,$area);
                }else{
                    $ship_date = getTime('D. M. j', strtotime('+'. $products_ship_time . ' days'),$country_code,"",true,$area);
                }
                $str = $express.' <span class="pid_ship_date">'.get_date_product_delivery($ship_date,$_SESSION['languages_id'],2).'</span>';
            }else{
                $str = zen_get_products_instock_shipping_date_of_products_id($this->pid, $qty, $country_code,$this->purchase_qty,$this->attr_option_arr,$this->is_buck,$en_us_data,$this->over_stock_line);
            }
        }

        return $str;
    }
    //展示专题页面产品库存信息
    public function  get_10g_sfp_optical_qty($type=1, $is_cn=true){
        $html = '<div class="question_text_01 leftjt">
		<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
        <div class="arrow"></div>
        <div class="popover-content">';
        if($type==1){
            $warehouse_name = [$this->warehouse_name => $this->qty];
            $this->template_data = array_merge($warehouse_name,$this->template_data);
        }
        arsort($this->template_data);
        foreach ($this->template_data as $k => $v) {
            if ($is_cn == false && $k == $this->cn_name) {
                continue;
            }
            $html .= '<div class="arr_top">
            <i>·</i><strong>' . $v .'</strong><p>'. $this->get_unit_by_qty($v) . FS_EMAIL_PAUSE . $k .'</p>
            </div>';
        }
        $html .= '</div>
        </div>';
        return $html;
    }

    public function getWarehouseDeliveryDeadline(){
        $isCurrentDeliver = false;
        if ($this->local_warehouse != 2) {
            $date = getTime("Y-m-d H:i:s", "", $this->country_code);
            if ($date) {
                $current_time = strtotime($date);
                $date_arr = explode(" ", $date);
                $ymd = $date_arr[0];
            } else {
                $current_time = time();
                $ymd = date('Y-m-d', time());
            }
            switch ($this->local_warehouse) {
                case 20:
                    $de_time = $ymd .' 16:30:00';
                    $end_time = strtotime($de_time);
                    break;
                case 40:
                    $us_time = $ymd. ' 17:00:00';
                    $end_time = strtotime($us_time);
                    break;
                case 67:
                    $ru_time = $ymd. ' 16:30:00';
                    $end_time = strtotime($ru_time);
                    break;
                case 71:
                    $sg_time = $ymd. ' 15:30:00';
                    $end_time = strtotime($sg_time);
                    break;
                case 37:
                    $au_time = $ymd. ' 15:00:00';
                    $end_time = strtotime($au_time);
                    break;
            }
            if ($current_time >= $end_time) {
                $isCurrentDeliver = true;
            } else {
                $isCurrentDeliver = false;
            }
        }
        return $isCurrentDeliver;
    }

    /**
     * 展示运费政策
     * 不再展示运费说明了 em 箭头为空
     * @param $price
     * @param $type 表示调用的地方，$type=2代表QV弹窗
     * @return string
     */
    public function get_warehouse_shiping_policy($price, $special = false, $type=1)
    {
        global $currencies;
        $shipping = "";
        $is_buck = $this->is_buck;
        $settingDay = $this->getSettingDay();
        $is_trans = $this->country_id == 13 ? true : false;//澳大利亚全面转运

        $shipping_date = $this->getShippingDate($settingDay);
        $country_code = $this->country_code;
        $br = "<br/>";
        $arrow = '';
        $show_narrow_country = array("US","CA","MX","BE", "FR", "IT", "NL", "LU", "DK", "ES", "AT", "SE", "PL", "HU", "CZ", "SK", "SI", "HR", "MC","NO", "CH", "AD", "LI", "SM", "JE", "RS", "ME", "MK", "AL","GB","DE","IE", "PT","GL", "GP", "MQ", "AW","YT","IS", "FO","BA", "MD","GR", "FI", "MT", "CY", "EE", "LV", "LT", "RO", "BG","GF");
        $policy = $this->getPolicy();
        $notice = '';
        if(empty($policy)){
            $buckTip = FS_BUCK_NOTICE.'<br>';
            if($this->local_warehouse == 20 || $is_trans){
                $buckTip = '';
            }
            if(!$this->qty && $this->is_buck){
                $notice = $buckTip.$notice;
            }
            $policy = $this->getPopupNoticeTemplate($notice);
        }
        if (($this->warehouse == 6 && !in_array($this->country_code,array("CN","HK","MO","TW"))) || $this->country_code == "NZ" || $this->country_code=="AU") {
            $shipping = $shipping_date.$policy;
            return $shipping;
        }
        if(!in_array($this->country_code,array("CN","HK","MO","TW"))){
            if($is_buck){
                $shipping = $shipping_date.$policy;
                return $shipping;
            }
        }
        if($this->warehouse == '71' && $this->country_code != 'SG' && $type == 2){
            $shipping = $shipping_date.$policy;
            return $shipping;
        }
        $free_money_notice = "";
        $date = date('M. j', strtotime('+' . 1 . ' days'));
        $hour = getTime('G', time(),$country_code);
        if ($this->warehouse == 3 || $this->warehouse == 4) {
            $free_warehouse = 'us';
            $free_money_notice = FS_FOR_FREE_SHIPPING_US;
        }elseif($this->warehouse == 37){
            if($country_code != "NZ"){
                $free_warehouse = 'au';
                $free_money_notice = FS_FOR_FREE_SHIPPING_AU;
            }
        }else{
            if (!in_array($country_code, array("CN", "HK", "MO", "TW")) && in_array($this->warehouse, array(1, 2, 5))) {//欧洲仓
                $free_warehouse = 'de';
                $free_money_notice = FS_FOR_FREE_SHIPPING_DE_MONEY;
            }
        }

        if(!empty($free_warehouse)) {
            $free_info = get_ori_free_shipping_money($free_warehouse);
            $free_money = $this->is_pre_product ? $free_info['pre_free_price'] : $free_info['free_price'];
            $free_text_money = $this->is_pre_product ? $free_info['TextPrePri'] : $free_info['TextPri'];
            $free_money_notice = str_replace('$MONEY', $free_text_money, $free_money_notice);

            $price = zen_round($currencies->currencies[$free_info['currencies_type']]['value'] * $price, 2);
        }

        if (in_array($this->country_code, array("CN", "HK", "MO", "TW")) || $price >= $free_money) {
            $free_money_notice = "";
            if ($type != 2) {
                //QV弹窗中免运提示跟时间交期显示分2行展示
                $br = ", ";
            }
        }

        if($free_money_notice){
            $free_money_notice = "<span class='pro_font_w'>".$free_money_notice."</span>";
        }
        if(!$shipping_date){
            $br = " ";
        }
        if($br == ", "){
            $shipping_date = lcfirst($shipping_date);
        }
        $em = $br.$shipping_date.$arrow;
        if(!$this->qty){
            $em = $br.$shipping_date;
        }
        switch ($this->warehouse) {
            case 3:
                $shipping .= '<div class="product_03_01">';
                $shipping .= '<div class="product_aron"><span class="products_in_stock pro_details"><span class="pro_font_w">'.FS_FOR_FREE_SHIPPING.'</span>'.$free_money_notice.'</span>'.$em.$policy.'</div>';
                $shipping .= '</div>';
                break;
            case 4:
                $shipping .= '<div class="product_03_01">';
                $shipping .= '<div class="product_aron"><span class="products_in_stock pro_details"><span class="pro_font_w">'.FS_FOR_FREE_SHIPPING.'</span>'.$free_money_notice.'</span>'.$em.$policy.'</div>';
                $shipping .= '</div>';
                break;
            case 1:
            case 2:
            case 5:
                $shipping .= '<div class="product_03_01">';
                if ($this->country_code == "GB") {
                    $shipping .= '<div class="product_aron"><span class="products_in_stock pro_details"><span class="pro_font_w">'.FS_FOR_FREE_SHIPPING_GB1 . '</span>' . $free_money_notice . '</span>'.$em.$policy.'</div>';
                } else {
                    if(in_array($this->country_code, ['MQ', 'GF', 'YT', 'GP', 'BL', 'MF'])){
                        $free_pre = '';
                        $free_money_notice = '';
                        $em = strip_tags($em);
                    }else{
                        $free_pre = FS_FOR_FREE_SHIPPING_DE;
                    }
                    $shipping .= '<div class="product_aron"><span class="products_in_stock pro_details"><span class="pro_font_w">'.$free_pre.'</span>' . $free_money_notice . '</span>'.$em.$policy.'</div>';
                }
                $shipping .= '</div>';
                break;
            case 37:
                $shipping .= '<div class="product_03_01">';
                $shipping .= '<div class="product_aron"><span class="products_in_stock pro_details"><span class="pro_font_w">'.FS_FOR_FREE_SHIPPING.'</span>'.$free_money_notice . '</span>'.$em.$policy.'</div>';
                $shipping .= '</div>';
                break;
            default:
                $shipping .= '<div class="product_03_01">';
                $shipping .= '<div class="product_aron"><span class="products_in_stock pro_details"><span class="pro_font_w">' . FS_FOR_FREE_SHIPPING . '</span>' . $free_money_notice . '</span>'.$em.$policy.'</div>';
                $shipping .= '</div>';
        }
        return $shipping;
    }

    /**
     * @param int $price
     * @return string
     */
    public function getShippingDayInfo($price = 0, $default_methods = "",$feed = false)
    {
        $this->getDefaultAddressInfo();
        $price = $this->pure_price ? $this->pure_price : $price;
        $is_trans = $this->country_id == 13 ? true : false;//澳大利亚全面转运
        $free_info = $this->getFreeText($price);
        $free_text = $free_info['free_text'];
        $free_money_notice = $free_info['free_money_notice'];
        $this->weight = $this->weight ? $this->weight : $this->get_weight_for_prdoucts_id();

        $total_weight = $this->purchase_qty * $this->weight;
        $limit = $this->getDELimit($total_weight);
        $shipping_list = $this->getShippingList($price, $this->is_shipping_free, $limit);

        $shipping_feed = $shipping_list[1]['price'];
        //生成模拟免运费
        $sim_is_free = true;
        if(get_warehouse_by_code($_SESSION['countries_iso_code']) == 'cn' || $_SESSION['countries_iso_code'] == 'nz'){
            $sim_is_free = false;
        }

        $total_weight = $this->purchase_qty * $this->weight;
        $limit = $this->getDELimit($total_weight);
        $free_shipping_list = $this->getShippingList(200, $sim_is_free, $limit);
        $free_shipping_info = $free_shipping_list[0];
        $default_shipping_info = $shipping_list[0];
        if($this->country_code=="JP" && $_SESSION['languages_code'] == 'jp'){
            $split = "、";
        }else{
            $split = ", ";
        }
        if ($default_methods) {
            foreach ($shipping_list as $v) {
                if ($v['methods'] == $default_methods) {
                    $default_shipping_info = $v;
                    break;
                }
            }
        }

        $default_shipping_methods = $default_shipping_info['methods'];
        $default_shipping_title = trim($default_shipping_info['origin_title']);

        $shippig_price = $this->country_id == 13 ? $default_shipping_info['price_tax'] : $default_shipping_info['price'];
        $default_shipping_title = str_replace("service", "", $default_shipping_title);
        $default_shipping_price = trim(str_replace("&nbsp;", " ", $shippig_price));
        $default_shipping_origin_price = $default_shipping_info['origin_price'];
        $default_shipping_title = trim($default_shipping_title);

        //获取免余份运输方式
        $free_shipping_methods = $free_shipping_info['methods'];
        $free_shipping_title = trim($free_shipping_info['origin_title']);

        $free_shipping_title = str_replace("service", "", $free_shipping_title);
        $free_shipping_title = str_replace("Service", "", $free_shipping_title);
        $free_shipping_price = trim(str_replace("&nbsp;", " ", $free_shipping_info['price']));
        $free_shipping_origin_price = $free_shipping_info['origin_price'];
        $free_shipping_title = trim($free_shipping_title);

        //墨西哥物流比较特殊
        $free_shipping_title = strtolower($_SESSION['countries_iso_code']) == 'mx' ? $default_shipping_title : $free_shipping_title;

        $policy = $this->getPolicy();
//        if(empty($policy)){  //没有提示气泡展示疫情影响的说明
//            $policy = $this->getPopupNoticeTemplate(FS_GSP_COVID_TIPS);
//        }
        if ($default_methods) {
            $this->is_default_methods = $default_shipping_methods;
            $settingDay = $this->getSettingDay($default_shipping_methods);
            $shipping_day = $this->getShippingDate($settingDay,$default_shipping_methods);
            $html = $default_shipping_price . " " . FS_PRODUCTS_VIA . " " . $default_shipping_title . $split . lcfirst($shipping_day);
            if ($this->country_code == 'RU' && $default_methods == 'upszones') {
                $html = $default_shipping_price . " " . FS_PRODUCTS_VIA . " " . $default_shipping_title .SHIPPING_COURIER_DELIVERY_01 . $split . lcfirst($shipping_day);
            }
            if ($default_shipping_origin_price == 0) {
                $html = "<span class=\"pro_font_w\">" . $free_text . "</span> " . FS_PRODUCTS_VIA . " " . $default_shipping_title . $split . lcfirst($shipping_day);
            }
            $html .= '<input type="hidden" value="' . $default_shipping_methods . '" id="default_shipping_methods">';
        } else {
            if ($free_shipping_origin_price == 0) {
                $this->is_default_methods = $free_shipping_methods;
                $settingDay = $this->getSettingDay($free_shipping_methods);
                $shipping_day = $this->getShippingDate($settingDay,$free_shipping_methods);
                $html = "<span class=\"pro_font_w\">" . $free_text . "</span> " . FS_PRODUCTS_VIA . " " . $free_shipping_title . $split . lcfirst($shipping_day);
                if ($default_shipping_origin_price != 0) {
                    $html = "<span class=\"pro_font_w\">" . $free_text . "</span> " . FS_PRODUCTS_VIA . " " . $free_shipping_title . " " . $free_money_notice . "<br/>" . ucfirst($shipping_day);
                }

                $html .= '<input type="hidden" value="' . $free_shipping_methods . '" id="default_shipping_methods">';
            } else {
                $this->is_default_methods = $default_shipping_methods;
                $settingDay = $this->getSettingDay($default_shipping_methods);
                $shipping_day = $this->getShippingDate($settingDay,$default_shipping_methods);
                if ($_SESSION['languages_code'] == 'ru') {
                    if ($default_shipping_price == FS_FOR_FREE_SHIPPING_TO_FREE) {
                        $html = "<span class='pro_font_w'>" . FS_FOR_FREE_SHIPPING . "</span> " . "  " . $default_shipping_title . $split . lcfirst($shipping_day);
                    } else {
                        $html = $default_shipping_price . "  " . $default_shipping_title . $split . lcfirst($shipping_day);
                    }
                } else {
                    if ($default_shipping_price == FS_FOR_FREE_SHIPPING_TO_FREE) {
                        $html = "<span class='pro_font_w'>" .FS_FOR_FREE_SHIPPING . "</span> " ."  " . FS_PRODUCTS_VIA . " " . $default_shipping_title . $split . lcfirst($shipping_day);
                    } else {
                        $html = $default_shipping_price . "  " . FS_PRODUCTS_VIA . " " . $default_shipping_title . $split . lcfirst($shipping_day);
                    }
                }
                $html .= '<input type="hidden" value="' . $default_shipping_methods . '" id="default_shipping_methods">';
            }
        }
        if (!$default_shipping_title || !$free_shipping_title) {
            $html = $shipping_day;
        }
        if ($default_shipping_methods == "selfreferencezones") {
            $html = FS_PRODUCTS_PICK_UP;
            $html .= '<input type="hidden" value="selfreferencezones" id="default_shipping_methods">';
        }
        $buckTip = FS_BUCK_NOTICE.'<br>';
        if($this->local_warehouse == 20){
            $buckTip = '';
        }
        if($this->is_buck && !$this->qty){
//            $buck_notice = $is_trans ? FS_GSP_COVID_TIPS : $buckTip.FS_GSP_COVID_TIPS;
            $buck_notice = $this->getPopupNoticeTemplate($buckTip);
            $html .= $buck_notice;
            $policy = '';
        }

        if ($feed == true){
            return $shipping_feed;
        }else{
            if($default_shipping_methods == 'grabexpresszones'){
                return $html;
            }
            return $html . $policy;
        }
    }

    /** Dylan 2020.3.23
     * 列表页,购物车,搜索页 获取默认运输方式
     * @return string
     */
    public function getDefaultMethod(){
        $country_code = strtoupper($this->country_code);
        $default_shipping_methods = '';
        $has_instock = $this->qty && !$this->over_stock_line; //本地仓有库存
        switch ($this->local_warehouse){
            case '20': //de
                if($has_instock){
                    if(in_array($country_code,['DE'])){
                        $default_shipping_methods = 'tntgzones';
                    }elseif (in_array($country_code,['IS','NO'])){
                        $default_shipping_methods = 'tntezones';
                    }elseif (in_array($country_code,['AL','AW','BA','FR','FO','GF','GL','GP','ME','MT','MK','MQ','YT','MD','RS','CY', 'BL'])){
                        $default_shipping_methods = 'dhlezones';
                    }else{
                        $default_shipping_methods = 'upsstandardzones';
                    }
                }else{
                    if($this->is_buck){
                        $this->weight = $this->weight ? $this->weight : $this->get_weight_for_prdoucts_id();
                        $cabinet = false;
                        //超尺寸产品
                        if(in_array($this->pid,[76880,76880,97949,73579,73958,73984,75869,74126,76887,70855,70856,96682])){
                            $cabinet = true;
                        }

                        if (($this->weight < 30 && $cabinet) || ($this->weight >=30 && $this->weight <= 70)) {
                            if (in_array($country_code,
                                ['MT','CY','IM','IS','BA','RS','ME','MK','AL','MD','FO','GL','GP','GF','MQ','IC','YT','AW','ES', 'BL'])
                            ) {
                                $default_shipping_methods = 'upssaverzones';
                            } else {
                                $default_shipping_methods = 'upsstandardzones';
                            }
                        }

                        if ($this->weight < 30 && !$cabinet) {
                            if(in_array($country_code,['DE'])){
                                $default_shipping_methods = 'tntgzones';
                            }elseif (in_array($country_code,['IS','NO'])){
                                $default_shipping_methods = 'tntezones';
                            }elseif (in_array($country_code,['AL','AW','BA','FR','FO','GF','GL','GP','ME','MT','MK','MQ','YT','MD','RS','CY', 'BL'])){
                                $default_shipping_methods = 'dhlezones';
                            }else{
                                $default_shipping_methods = 'upsstandardzones';
                            }
                        }

                        if ($this->weight > 70) {
                            $default_shipping_methods = 'upssaverzones';
                        }
                    }else{
                        if(in_array($country_code,['DE'])){
                            $default_shipping_methods = 'tntgzones';
                        }elseif (in_array($country_code,['IS','NO'])){
                            $default_shipping_methods = 'tntezones';
                        }elseif (in_array($country_code,['AL','AW','BA','FR','FO','GF','GL','GP','ME','MT','MK','MQ','YT','MD','RS','CY', 'BL'])){
                            $default_shipping_methods = 'dhlezones';
                        }else{
                            $default_shipping_methods = 'upsstandardzones';
                        }
                    }
                }

                if (in_array($country_code, ['IE','GB', 'FR'])) {
                    $default_shipping_methods = 'dhleconomyzones';
                }

                if (in_array($country_code, ['MF'])) {
                    $default_shipping_methods = 'upssaverzones';
                }

                break;
            case '40': //us-es
                if($has_instock){
                    if(in_array($country_code,['US','PR'])){
                        if($this->is_cabinet){ //机柜类
                            $default_shipping_methods = 'upsltlzones';
                        }else{
                            $default_shipping_methods = 'upsgroundeastzones';
                        }
                    }else{
                        if($this->is_cabinet){ //机柜类
                            $default_shipping_methods = 'upsltlzones';
                        }else{
                            $default_shipping_methods = 'upsazones';
                        }
                    }
                }else{
                    if($this->is_buck){
                        $default_shipping_methods = 'dhlzones';
                    }else{
                        $default_shipping_methods = 'fedexzones';
                    }
                }
                break;
            case '37': //au
                if($has_instock){
                    if($country_code == 'AU'){
                        $this->weight = $this->weight ? $this->weight : $this->get_weight_for_prdoucts_id();
                        if($this->pure_price > 99 ){
                            $default_shipping_methods = 'startrackfzones';
                        }else{
                            if($this->weight > 20){
                                $default_shipping_methods = 'tntauroadexpresszones';
                            }else{
                                $default_shipping_methods = 'startrackfzones';
                            }
                        }
                    }else{
                        $default_shipping_methods = 'aupostexpresszones';
                    }
                }else{
                    if($country_code == 'NZ'){
                        $default_shipping_methods = 'dhlzones';
                    }else{
                        if($this->is_buck){
                            $default_shipping_methods = 'tntauroadexpresszones';
                        }else{
                            if($this->pure_price > 99){
                                $default_shipping_methods = 'startrackfzones';
                            }else{
                                $this->weight = $this->weight ? $this->weight : $this->get_weight_for_prdoucts_id();
                                if($this->weight > 20){
                                    $default_shipping_methods = 'tntauroadexpresszones';
                                }else{
                                    $default_shipping_methods = 'startrackfzones';
                                }
                            }
                        }
                    }
                }
                break;
            case '71': //sg
                if($has_instock){
                    if($country_code == 'SG'){
                        $default_shipping_methods = 'simplyzones';
                    }elseif ($country_code == 'MM'){
                        $default_shipping_methods = 'upsexpressworldwidezones';
                    }else{
                        $default_shipping_methods = 'fedexsgzones';
                    }
                }else{
                    if(!$this->is_buck && $country_code == 'SG'){
                        $this->weight = $this->weight ? $this->weight : $this->get_weight_for_prdoucts_id();
                        if($this->weight > 20){
                            $default_shipping_methods = 'dhlzones';
                        }else{
                            $default_shipping_methods = 'fedexzones';
                        }
                    }
                }
                break;
        }
        return $default_shipping_methods;
    }

    public function insertIntoDefaultShippingMethods($shipping_method="",$country_code=""){
        global $db;
        $country_code = $country_code ? strtoupper($country_code) : strtoupper($this->country_code);
        if(!empty($shipping_method)){
            $insertSql = "INSERT INTO fs_default_shipping_methods 
                            (
                                products_id,
                                country_code,
                                default_shipping_code
                            )
                            VALUES
                            (
                                ".(int)$this->pid.",
                                '".$country_code."',
                                '".$shipping_method."'
                            )
                            ";
            $db->Execute($insertSql);
        }
    }

    public function getProductToDefaultShippingMethod(){
        $where = ' products_id ='.(int)$this->pid.' and country_code="'.strtoupper($this->country_code.'"');
        $default_shipping_methods = fs_get_data_from_db_fields('default_shipping_code','fs_default_shipping_methods',$where,'limit 1');
        return $default_shipping_methods;
    }

    public function getSettingDay($default_shipping_methods='', $norway_time =''){
        //如果默认运费为0，则调用免运费交期
        $settingDay = 0;
        $country_code = $this->country_code;
        if(empty($default_shipping_methods)){
            if($this->local_warehouse != 2){
                $default_shipping_methods = $this->getDefaultMethod();
            }
            if(empty($default_shipping_methods) && in_array($this->main_page,['index','advanced_search_result','shopping_cart'])){
                $default_shipping_methods = $this->getProductToDefaultShippingMethod();
                if(empty($default_shipping_methods)){
                    //列表页,购物车  国内仓覆盖的国家获取默认运输方式
                    $this->weight = $this->weight ? $this->weight : $this->get_weight_for_prdoucts_id();
                    $price = $this->pure_price;
                    $free_info = $this->getFreeText($price);
                    $total_weight = $this->purchase_qty * $this->weight;
                    $limit = $this->getDELimit($total_weight);
                    $shipping_list = $this->getShippingList($price,$this->is_shipping_free,$limit);
                    $default_shipping_info = $shipping_list[0];
                    $default_shipping_methods = $default_shipping_info['methods'];
                    if($default_shipping_methods){
                        $this->insertIntoDefaultShippingMethods($default_shipping_methods,$country_code);
                    }
                }
            }
        }

        if($default_shipping_methods){
            if(!in_array($default_shipping_methods,['upsltlzones','upsgroundeastzones'])){
                if(in_array($this->country_code,['PR'])){
                        $settingDay = fs_get_data_from_db_fields('shipping_time', 'shipping_effectiveness', 'shipping_methods = "' . $default_shipping_methods . '" AND code = "US" limit 1');
                }else{
                    $where = 'shipping_methods = "' . $default_shipping_methods . '" AND code = "'.$this->country_code.'" limit 1';
                    if($default_shipping_methods == 'dhleconomyzones' && $_SESSION['languages_code' != 'uk']){
                        $where = 'shipping_methods = "' . $default_shipping_methods . '" limit 1';
                    }
                    $settingDay = fs_get_data_from_db_fields('shipping_time', 'shipping_effectiveness', $where);
                }
            }
            $settingDay = $settingDay ? $settingDay : 0;
            if(!$settingDay){
                if(preg_match("/ups2day|fedex2day/i",$default_shipping_methods)){
                    $settingDay = 2;
                }elseif (preg_match("/upsovernight|fedexovernight|fedexpriorityovernight|fedexsameday/i",$default_shipping_methods)){
                    $settingDay = 1;
                }elseif (preg_match("/dhlazones|fedex3dayzones|upsazones/i",$default_shipping_methods)){
                    $settingDay = 3;
                }elseif (in_array($default_shipping_methods,array('upsexpresspluszones','ups2daysamzones'))){
                    $settingDay = 1;
                }
                if($this->country_code == 'PR'){
                    if(in_array($default_shipping_methods,['ups2dayseastzones'])){
                        $settingDay = 2;
                    }elseif (in_array($default_shipping_methods,['upsgroundeastzones'])){
                        $settingDay = 3;
                    }elseif (in_array($default_shipping_methods,['upsovernighteastzones'])){
                        $settingDay = 1;
                    }
                }
            }
        }
        if(!$settingDay){
            $postcode = $this->post_code;
            $day = 0;
            switch ($country_code){
                case "US":
                    if(!empty($postcode)) {
                        if ($this->is_cabinet) {
                            $day = fs_get_data_from_db_fields('delivery_date', 'shipping_ups_ltl', 'products_id =' . $this->pid . ' AND country_id = "'.$this->country_id.'" AND state = "' . $this->state . '"');
                        } else {
                            $day = fs_get_data_from_db_fields('timeliness_md','countries_to_zip','zip ="' . $postcode . '"','limit 1');
                        }
                    }else{
                        $day = 3;
                    }
                    break;
                case in_array($country_code,array("MX","CA")):
                    if ($this->is_cabinet) {
                        if(!empty($this->state)) {
                            $day = fs_get_data_from_db_fields('delivery_date', 'shipping_ups_ltl', 'products_id =' . $this->pid . ' AND country_id = "' . $this->country_id . '" AND (state = "' . $this->state . '" OR state_abb = "' . $this->state . '")');
                        }
                        $delivery_default = array(
                            '38' => ['73579' => 4, '73958' => 4],
                            '138' => ['73579' => 7, '73958' => 7]
                        );
                        $day = !empty($day) ? $day : $delivery_default[$this->country_id][$this->pid];
                    }else{
                        $day = 3;
                    }
                    break;
            }
            $settingDay = $day;
        }

        if(in_array($default_shipping_methods,array('saturdaydeliveryzones','dhlsaturdayzones'))){
            $settingDay = 0; //周六达快递运输时效给0，其它地方做了处理
        }
        $this->is_default_methods = $default_shipping_methods;
        $this->settingDay = $settingDay;
        return $settingDay;
    }
    /**
     * 获取运费提示
     */
    public function getPolicy(){
        $arrow ='<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                    <div class="question_bg_icon question_bg_grayIcon iconfont icon">&#xf071;</div>
                    <div class="new_m_bg1"></div>
                    <div class="new_m_bg_wap">
                        <div class="question_text_01 leftjt">
						<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                            <div class="arrow"></div>';
        $show_narrow_country = array("US","CA","MX","BE","PR","JP","RU", "SG","FR", "IT", "NL", "LU", "DK", "ES", "AT", "SE", "PL", "HU", "CZ", "SK", "SI", "HR", "MC","NO", "CH", "AD", "LI", "SM", "JE", "RS", "ME", "MK", "AL","GB","DE","IE", "PT","GL", "GP", "MQ", "AW","YT","IS", "FO","BA", "MD","GR", "FI", "MT", "CY", "EE", "LV", "LT", "RO", "BG","GF");
        $country_code = $this->country_code;
        $html = "";
        $hour = getTime('G', time(),$country_code);
        $detail_info = "";
        if(in_array($country_code,['US','PR'])){
            if($this->qty > 0 && !$this->over_stock_line){
                $detail_info = FS_GSP_LOCAL_STOCK_DELIVERY_TIPS;
            }
        }
        //匹配到毛料ID且交期延迟
        if($this->material_data['materialProductsId'] && $this->material_data['materialStockLength'] > 0 && $this->material_data['materialLeadTime'] && $this->material_data['materialDelay']){
            $detail_info = FS_PRODUCT_MATERIAL_TIP;
        }
        if($detail_info){
            $html = $arrow.$this->shipping_detail($detail_info);
            return $html;
        }

        $current_warehouse_qty = $this->qty;
        if($this->country_code == 'RU'){ //俄罗斯仓库存 += 武汉仓库存 XQ20210121022
            $current_warehouse_qty = $this->qty + $this->cn_qty;
        }
        if($this->isCustom || !$current_warehouse_qty ){
            $arrow = "";
        }

        switch ($this->country_code){
            case "US":
                $detail_info = FS_SHIPPING_POLICY_US;
            break;
            case "PR";
                $detail_info = FS_SHIPPING_POLICY_US;
                break;
            case "CA":
                $detail_info = FS_SHIPPING_POLICY_CA;
            break;
            case "JP":
                $detail_info = FS_SHIPPING_POLICY_CN;
                break;
            case "SG":
                $detail_info = FS_SHIPPING_POLICY_SG;
                break;
            case "RU":
                $detail_info = FS_SHIPPING_POLICY_RU;
                break;
            case "MX":
                $detail_info = FS_SHIPPING_POLICY_MX;
            break;
            case "NZ":
                $detail_info = FS_SHIPPING_POLICY_NZ;
            break;
            case "AU":
                $detail_info = FS_SHIPPING_POLICY_AU;
            break;
            case "GB":
            case "IM":
            case "JE":
            case "GG":
                $detail_info = FS_SHIPPING_POLICY_GB;
            break;
            case all_german_warehouse("country_code",$this->country_code):
                $detail_info = FS_SHIPPING_POLICY_DE;
            break;
            default:
                $detail_info = FS_SHIPPING_POLICY_CN;
        }

        if($detail_info&&$arrow){
            $html = $arrow.$this->shipping_detail($detail_info);
        }
        return $html;
    }

    //列表页,购物车页面交期库存展示
    public function showIntockDate($custome=false,$type="",$price=0){
        global $currencies;
        $page = in_array($this->main_page,array('advanced_search_result','index')) ? 'list' : ($this->main_page == 'shopping_cart' ? $this->main_page : '');
        $instock = $this->get_warehouse_instock_qty($custome,$type,$page);
        $price = $price ?: $this->pure_price;
        $this->getDefaultAddressInfo();


        $settingDay = $this->getSettingDay();
        $date = $this->getShippingDate($settingDay);
        $free = "";
        $is_free_word = true;
        $is_inline = "";
        if ($this->main_page == 'shopping_cart') {
            $instock_str = $instock ? trim($instock) : "";
            $html = '<span class="products_in_stock pro_details">'.$instock_str.'<br><span><i class="iconfont stock-freeship-icon">&#xf430;</i>'.trim($date).'</span></span>';
        } elseif (in_array($this->main_page,array('print_shopping_list','saved_cart_details','inquiry','inquiry_list'))){
            $instock_str = $instock ? trim($instock) : "";
            $html = '<span class="products_in_stock pro_details">'.$instock_str.'<br>'.trim($date).'</span>';
        }else{
            if ($this->warehouse == 3 || $this->warehouse == 4) {
                if($price>79){
                    $free = trim(FS_FOR_FREE_SHIPPING);
                }

                if($this->is_pre_product) {
                    if (in_array($_SESSION['languages_code'], ['en', 'fr']) && $_SESSION['countries_iso_code'] == 'ca' && $_SESSION['currency'] == 'CAD' && $currencies->fs_format_new($price, true, 'CAD') < 399) {
                        $is_free_word = false;
                    } elseif (in_array($_SESSION['languages_code'], ['en', 'mx']) && $_SESSION['countries_iso_code'] == 'mx' && $_SESSION['currency'] == 'MXN' && $currencies->fs_format_new($price, true, 'MXN') < 6000) {
                        $is_free_word = false;
                    } else {
                        if($price < 299){
                            $is_free_word = false;
                        }
                    }
                }

            }elseif($this->warehouse == 37){
                $price = zen_round($currencies->currencies['AUD']['value']*$price,2);
                if($price>99){
                    $free = trim(FS_FOR_FREE_SHIPPING);
                }
                if($price < 399 && $this->is_pre_product){
                    $is_free_word = false;
                }
            }elseif($this->warehouse == 71){
                $price = zen_round($currencies->currencies['SGD']['value']*$price,2);
                if($this->qty){
//                    if($price>=99){
//                        $free = trim(FS_SG_FREE_SHIPPING);
//                    }else{
//                        $free = trim(FS_SG_NO_FREE_SHIPPING);
//                    }
                    if($price>=99){
                        $free = trim(FS_FOR_FREE_SHIPPING);
                    }
                }
            }elseif($this->warehouse == 67){
                $price = zen_round($currencies->currencies['RUB']['value']*$price,2);
                if($price>=20000){
                    $free = trim(FS_FOR_FREE_SHIPPING);
                }
            }else{
                $price = zen_round($currencies->currencies['EUR']['value']*$price,2);
                if(in_array($this->country_code,array("CN","HK","MO","TW")) || ($price>79&&$this->warehouse!=6)){
                    $free = trim(FS_FOR_FREE_SHIPPING);
                    if($this->country_code == "GB"){
                        $free = FS_FOR_FREE_SHIPPING_GB1;
                    }
                    if(all_german_warehouse("country_code",$this->country_code)){
                        $free = trim(FS_FOR_FREE_SHIPPING_DE);
                    }
                    if($price < 299 && $this->is_pre_product){
                        $is_free_word = false;
                    }
                }
            }
            if($this->is_buck || in_array($this->country_code, ['NZ','MQ','GF','YT','GP', 'BL', "MF"])){
                $free = "";
            }
            if($free){
                if($this->is_pre_product && !$is_free_word){
                    $date = $date ? trim(ucfirst($date)) : "";
                }else{
                    if ($_SESSION['languages_code'] == 'de') {
                        $date = $date ? ", ".trim(ucfirst($date)) : "";
                    } else {
                        $date = $date ? ", ".trim(lcfirst($date)) : "";
                    }
                }
            }
            $instock_icon = $date_icon = '';
            if(in_array($this->main_page,['index',FILENAME_ADVANCED_SEARCH_RESULT,'clearance','clearance_list','new_product'])){
                $instock_icon = '<i class="iconfont warehouse_details_baoguoIc">&#xf429;</i>';
                $date_icon = '<i class="iconfont warehouse_details_baoguoIc">&#xf430;</i>';
            }
            $html = "<div>".$instock_icon."<div>".trim($instock)."</div></div><div>".$date_icon."<div>".$free.trim($date)."</div></div>";
        }
        if($this->is_pre_product){
            $html = "<div ".$is_inline.">".$this->getPreOrderTemplate()."</div><div>".($is_free_word ? $free : '').trim($date)."</div>";
        }
        return $html;
    }

    /**
     * tag 获取产品库存
     *
     * @author rebirth
     * @date
     * @return string
     */
    public function showIntockTagDate(){

        if ($this->qty < 1){
            $inInstockField = $this->is_instock_route ? $this->is_instock_route : "in_cn";
            $InStock = fs_get_data_from_db_fields($inInstockField,'products','products_id='.(int)$this->pid,'limit 1');
            $this->isInstock = $InStock ? $InStock : $this->isInstock;
            $str =  $this->isInstock ? QTY_SHOW_AVAILABLE_NEW_INFO : QTY_SHOW_AVAILABLE_TAG_NEW_INFO;
            return QTY_SHOW_AVAILABLE . FS_EMAIL_PAUSE . $str;
        }else{
            return  $this->get_qty_with_unit();
        }
    }
    //获取当前库存
    public function get_qty_with_unit()
    {
        return $this->qty . " " . $this->get_unit_by_qty($this->qty);
    }
    //获取当前库存,没有in stock字样
    public function get_qty()
    {
        return $this->qty;
    }
    //获取当前库存,没有in stock字样
    public function get_all_qf_qty(){
        if($this->qty_line && $this->qty_line > $this->qty || (!$this->qty && $this->cn_qty)){
            return $this->cn_qty;
        }
        return $this->qty;
    }
    //获取当前所有库存,没有in stock字样
    public function get_all_qty($warehouse_data = '')
    {
        switch($warehouse_data){
            case 'US':
                return $this->qty;
                break;
            case 'DE':
                return $this->qty;
                break;
            case 'AU':
                return $this->all_qty;
                break;
            case 'CN':
                return $this->all_qty;
                break;
            default:
                return $this->all_qty;
                break;
        }
    }

    //获取当前所有库存,没有in stock字样
    public function get_all_country_qty()
    {
        $all_qty = $this->template_data_wdm;
        $all_qty[0] = $this->all_qty;
        return $all_qty;
    }


    /**
     * 判断是否是收关税产品
     * @return bool
     */
    public function is_gsp_vat_product()
    {
        $return = false;
        if(($this->qty == 0 || $this->over_stock_line) && in_array($this->country_code,['US','PR'])){
            $return = true;
        }
        return $return;
    }

    /**
     * 是否12大重类
     * @return bool
     */
    public function is_buck_cate(){

        $status = false;
        $product_combine = array($this->pid);
        $product_combine = array_map("intval",$product_combine);
        $no_free_products = array(18015,18016,18013,18000,29669,35858,29032,14101,72480,72752,71024,74124,72448,28952,72753);
        $other_no_free_products = array();
        if(in_array($this->warehouse,array(1,2,3,4,5))){
            $no_free_products = array_merge($no_free_products,$this->spec_heavy_arr);
        }
        $products = array_diff($product_combine,$no_free_products);
        if(!empty($products)){
            foreach($products as $key=>$v){
                if(in_array($v,array(72012,72023,72500,72012,72022,31922))){
                    $status = true;
                    break;
                }
                if(!empty($other_no_free_products) && in_array($v,$other_no_free_products)){
                    $status = true;
                    break;
                }
                if($this->current_category){
                    $arr = array(13,17,16,1155,1148,2907,900,3093,2969,3059,3260,3319,996,3313,1134,1133,3073,633,3319,573,3253);
                    foreach ($this->current_category as $cc){
                        if(in_array($cc,$arr)){
                            $status = true;
                            break 2;
                        }
                    }
                }else{
                    if(fs_zen_get_product_category_id($v,array(13,17,16,1155,1148,2907,900,3093,2969,3059,3260,3319,996,3313,1134,1133,3073,633,3253)) || zen_product_in_category($v,3319)  || zen_product_in_category($v,573)){
                        $status = true;
                        break;
                    }
                }
            }
        }
        return  $status;
    }

    /**
     * 下拉免运费说明
     * @param $info
     * @return string
     */
    public function shipping_detail($info,$special = false){
        $html = "";
        if (empty($info)) {
            return $html;
        }
        $html .='<div class="popover-content">
                           '.$info.'
                        </div>
                    </div>
                </div>
            </div>';
        return $html;
    }
    /**
     * 获取单个产品重量
     * @return int
     */
    public function get_weight_for_prdoucts_id()
    {
        global $db;
        // products price
        $sqlCache = sqlCacheType();
        $product_query = "select {$sqlCache} products_id,products_weight, product_is_always_free_shipping, products_virtual
                          from " . TABLE_PRODUCTS . "
                          where products_id = '" . (int)$this->pid . "' limit 1";

        if ($product = $db->Execute($product_query)) {
            $prid = $product->fields['products_id'];
            if (($product->fields['product_is_always_free_shipping'] != 1 and $product->fields['products_virtual'] != 1)) {
                $products_weight = $product->fields['products_weight'];
            } else {
                $products_weight = 0;
            }
            $this->weight = ($products_weight);
        }

        $attributes_weight = 0;
        $adjust_downloads = 0;
        // attributes price
        if (isset($this->attributes)) {
            reset($this->attributes);
            /* 具体到下面这个循环导致速度很慢 */
            while (list($option, $value) = each($this->attributes)) {

                if ($option != 'length') {
                    $adjust_downloads++;
                } else {
                    //length
                    $length_weight = 0;
                    //如果长度区间重量[products_length_weight]数据存在就获取不同长度区间的加重数据
                    if(get_products_length_weight_count((int)$this->pid)){
                        $length_weight += zen_get_products_length_weight($this->pid, $value, $this->attributes);
                    }else{
                        //仍然查找之前的products_length重量记录
                        $length_s = str_replace("k","",$value);
                        $length_s = str_replace("m","",$length_s);
                        $priceArr = zen_get_products_custom_length_price($this->pid,$length_s);
                        $length_weight += $priceArr['weight'];
                    }
                    $attributes_weight +=  $length_weight;
                }

            }

        }
        // attributes price
        // attributes weight
        if (isset($this->attributes)) {
            reset($this->attributes);
            while (list($option, $value) = each($this->attributes)) {
                if ($option != 'length') {
                    $attribute_weight_query = "select products_attributes_weight, products_attributes_weight_prefix
                                       from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                       where products_id = '" . (int)$prid . "'
                                       and options_id = '" . (int)$option . "'
                                       and options_values_id = '" . (int)$value . "'";

                    $attribute_weight = $db->Execute($attribute_weight_query);

                    // adjusted count for free shipping
                    if ($product->fields['product_is_always_free_shipping'] != 1) {
                        $new_attributes_weight = $attribute_weight->fields['products_attributes_weight'];
                    } else {
                        $new_attributes_weight = 0;
                    }
                    // + or blank adds
                    if ($attribute_weight->fields['products_attributes_weight_prefix'] == '-') {
                        $attributes_weight -= $new_attributes_weight;
                    } else {
                        $attributes_weight += $new_attributes_weight;
                    }
                }
            }
        } // attributes weight
        $this->weight += $attributes_weight;

        return $this->weight;
    }

    /**
     * 根据当前产品，获取德国仓重货 发货方式
     *
     * @param $weight 产品重量
     * @return array
     */
    public function getDELimit($weight)
    {
        $limit = [];
        if($this->country_id == 13 && $this->qty == 0 && $this->is_buck){
            $limit = ['tntauroadexpresszones'];
        }else{
            $isLimit = $weight < 30 && !$this->isOverSize;
            $is_buck = $this->is_buck;
            if ($is_buck) {
                if(!$isLimit){
                    $limit = ['upsstandardzones', 'upssaverzones'];
                }
                if (in_array($this->pid, [73579, 73958]) && !$this->qty){
                    $limit = ['upssaverzones'];
                }
                if( $weight>70){
                    $limit = ['upssaverzones'];
                }
            }
            if($this->isOverSize){
                if($weight >70){
                    $limit = ['upssaverzones'];
                }
            }
        }
        return $limit;
    }


    /**
     * 获取物流运输方式
     *
     * @param int $price 产品价格
     * @param bool $is_shipping_free 是否免运
     * @param array $limit 获取指定运输方式
     * @return array
     */
    public function getShippingList($price=0,$is_shipping_free=false,$limit = [])
    {
        global $currencies;
        if($price){
            $this->pure_price = $price;
        }
        $total_weight = $this->purchase_qty*$this->weight;
        $price = $this->pure_price*$this->purchase_qty;
        $rate = (zen_not_null($currencies->currencies[$_SESSION['currency']]['value'])) ? $currencies->currencies[$_SESSION['currency']]['value'] : $currencies->currencies[$_SESSION['currency']]['value'];
        $is_buck = $this->is_buck;
        $is_pre_product = $this->is_pre_product;
        $country_code = $this->country_code;
        $country_id = $this->country_id;
        $post_code = $this->post_code;
        $local_hour = getTime("G",time(),$country_code);
        $local_day = getTime('D',time(),$country_code);
        $qty = $this->qty;
        $state = $this->state;
        $is_show_overnight = true;
        $zone_type = 1;
        $is_show_pick_up = true;
        if(all_german_warehouse("country_code",$country_code)){
            $warehouse = "DE";
        }elseif (au_warehouse($country_code,"country_code")){
            $warehouse = "AU";
//            if (($qty<$this->purchase_qty && $is_buck) || $is_pre_product) {
//                $warehouse = "CN";
//            }

            if($country_code == "NZ"){
                $warehouse = "AU-NZ";
                if (($qty<$this->purchase_qty) || $is_pre_product) {
                    $warehouse = "CN";
                }
            }

        }elseif (seattle_warehouse("country_code",$country_code)){
            $warehouse = "US-ES";
            $us_qty = 0;
            $es_qty = fs_products_instock_qty_of_products_id($this->pid, "US-ES", false, $pcs = 0, false);
            $all_qty = $us_qty+$es_qty;
            if(!empty($post_code)){
                $zone = fs_get_data_from_db_fields('zone', 'countries_to_zip', 'zip = "' . $post_code . '" limit 1');
                if($all_qty < $this->purchase_qty){
                    $is_show_overnight = false;
                }

                if($zone == 2){
                    $zone_type = 2;
                    if(($es_qty && $es_qty>=$this->purchase_qty)){
                        $warehouse = "US-ES";
                    }elseif ($us_qty && $us_qty>=$this->purchase_qty){
                        $warehouse = "US";
                        $zone_type = 1;
                    }else{
                        if(($es_qty&&!$us_qty)){
                            $warehouse = "US-ES";
                        }
                        if(!$es_qty && $us_qty){
                            $warehouse = "US";
                            $zone_type = 1;
                        }
                        if(!$es_qty && !$us_qty){
                            $warehouse = "US-ES";
                        }
                        if($es_qty && $us_qty){
                            $warehouse = "US";
                            $zone_type = 1;
                        }
                        if($qty<$this->purchase_qty || $is_pre_product){
                            $warehouse = "CN";
                        }
                    }
                    $type = ($zone_type == 2) ? 1:2;
                    $is_show_sameday = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$post_code.'" and type = '.$type.' and shipping_type = 1 limit 1');
                }else{
                    $zone_type = 1;
                    $is_show_sameday = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$post_code.'" and type = 2 and shipping_type = 1 limit 1');
                    if(($us_qty && $us_qty>=$this->purchase_qty)){
                        $warehouse = "US";
                    }elseif ($es_qty && $es_qty>=$this->purchase_qty){
                        $warehouse = "US-ES";
                        $zone_type = 2;
                    }else{
                        if(($us_qty && !$es_qty)){
                            $warehouse = "US";
                        }
                        if($es_qty && !$us_qty){
                            $warehouse = "US-ES";
                            $zone_type = 2;
                        }
                        if($es_qty && $us_qty){
                            $warehouse = "US-ES";
                            $zone_type = 2;
                        }
                        if(!$es_qty && !$us_qty){
                            $warehouse = "US-ES";
                        }
                        if($qty<$this->purchase_qty || $is_pre_product){
                            $warehouse = "CN";
                        }
                    }
                    $type = ($zone_type == 2) ? 1:2;
                    $is_show_sameday = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$post_code.'" and type = '.$type.' and shipping_type = 1 limit 1');
                }
            }
            if ($qty<$this->purchase_qty || $is_pre_product) {
                $warehouse = "CN";
            }
        }elseif (singapore_warehouse("country_code",$country_code)) {
            $warehouse = "SG";
            if ($qty < $this->purchase_qty) {
                $warehouse = "CN";
            }
        }elseif (ru_warehouse("country_code",$country_code)) {
            $warehouse = "RU";
            if ($qty < $this->purchase_qty) {
                $warehouse = "CN";
            }
        }else{
            $warehouse = "CN";
        }

        if($this->over_stock_line && !in_array($warehouse,['AU','DE'])){
            $warehouse = "CN";
        }

        switch ($warehouse){
            case "US":
                //是否为美西邮编
                if(!$us_qty || $us_qty<$this->purchase_qty){
                    $is_show_pick_up = false;
                }
                $current_hour = getTime("G",time(),$country_code);
                $is_settle_zone = $zone;
                //整单才展示自提
                $is_self_lifting = true;
                if (in_array($country_id, array(138, 38))) {
                    $shipping_arr = array(

                        array(
                            'method' => 'dhlazones',
                            'title' => 'DHL'
                        ),
                        array(
                            'method' => 'fedex3dayzones',
                            'title' => 'FedEx'
                        ),
                        array(
                            'method' => 'upsazones',
                            'title' => 'UPS Expedited'
                        )

                    );
                } else {
                    $shipping_arr1 = array(
                        array(
                            'method' => 'ffzones',
                            'title' => 'ODFL'
                        ),
                        array(
                            'method' => 'fedexgroundzones',
                            'title' => FIBER_FEDEX_CHECK_GROUND
                        ),
                        array(
                            'method' => 'upsgroundzones',
                            'title' => FIBER_CHECK_STAND
                        ),
                        array(
                            'method' => 'fedex2dayzones',
                            'title' => FIBER_FEDEX_CHECK_TWO
                        ),
                        array(
                            'method' => 'ups2dayszones',
                            'title' => FIBER_CHECK_TWO
                        ),
                        array(
                            'method' => 'fedexpriorityovernightzones',
                            'title' => 'FedEx Priority Overnight'
                        )
                    );
                    $shipping_arr2 = array(
                        array(
                            'method' => 'upsovernightzones',
                            'title' => FIBER_CHECK_ONE
                        ),
                        array(
                            'method' => 'fedexovernightzones',
                            'title' => FIBER_FEDEX_CHECK_OVER
                        )
                    );
                    $shipping_arr3 = array(
                        array(
                            'method' => 'upsovernightzones',
                            'title' => FIBER_CHECK_ONE . FIBER_SHIPPING_MONDAY_DELIVERY
                        ),
                        array(
                            'method' => 'fedexovernightzones',
                            'title' => FIBER_FEDEX_CHECK_OVER . FIBER_SHIPPING_MONDAY_DELIVERY
                        )
                    );
                    $shipping_arr4 = array(
                        array(
                            'method' => 'fedexsamedayzones',
                            'title' => 'FedEx SameDay Standard'
                        )
                    );
                    if (date('D') == 'Fri') {
                        $shipping_arr = array_merge($shipping_arr1, $shipping_arr3);
                    } else {
                        $shipping_arr = array_merge($shipping_arr1, $shipping_arr2);
                    }
                    if ($current_hour<13 && $is_self_lifting && $is_settle_zone){
                        $shipping_arr = array_merge($shipping_arr, $shipping_arr4);
                    }
                }
                if($country_id == 223 && $this->state && in_array($this->state,array("Armed Forces Americas","Armed Forces Pacific","Armed Forces other"))){
                    $shipping_arr = array(
                        array(
                            'method' => 'uspsprioritymailzones',
                            'title' => 'USPS Priority Mail® service'
                        ),
                    );
                }

                if($this->is_cabinet){
                    $shipping_arr = array(
                        array(
                            'method' => 'fedexltlzones',
                            'title' => 'FedEx LTL'
                        )
                    );
                }

                break;
            case "US-ES":
                if(!$es_qty || $es_qty<$this->purchase_qty){
                    $is_show_pick_up = false;
                }
                $current_hour = getTime("G",time(),$country_code,"America/New_York");
                $is_east_zone = $zone;
                //整单才展示自提
                $is_self_lifting = true;
                if (in_array($country_id, array(138, 38))) {
                    $shipping_arr = array(
                        array(
                            'method' => 'dhlazones',
                            'title' => 'DHL'
                        ),
                        array(
                            'method' => 'upscmpexpresszones',
                            'title' => 'UPS Express'
                        )

                    );

                    if($price > 1000 && $country_id == 138){
                        $shipping_arr_sort_o = ['method' => 'fedex3dayzones', 'title' => 'FedEx'];
                        $shipping_arr_sort_t = ['method' => 'upsazones', 'title' => 'UPS Expedited'];
                    }else{
                        $shipping_arr_sort_o = ['method' => 'upsazones', 'title' => 'UPS Expedited'];
                        $shipping_arr_sort_t = ['method' => 'fedex3dayzones', 'title' => 'FedEx'];
                    }
                    array_unshift($shipping_arr, $shipping_arr_sort_o, $shipping_arr_sort_t);

                } else {
                    $shipping_arr = array(
                        array(
                            'method' => 'upsgroundeastzones',
                            'title' => $country_id == 223 ? 'UPS Ground®' :FIBER_CHECK_STAND,
                        ),
//                        array(
//                            'method' => 'fedexgroundeastzones',
//                            'title' => FIBER_FEDEX_CHECK_GROUND
//                        ),
                        array(
                            'method' => 'fedex2dayeastzones',
                            'title' => FIBER_FEDEX_CHECK_TWO
                        ),
                        array(
                            'method' => 'ups2dayseastzones',
                            'title' => FIBER_CHECK_TWO
                        ),
                        array(
                            'method' => 'upsovernighteastzones',
                            'title' => FIBER_CHECK_ONE
                        ),
                        array(
                            'method' => 'fedexovernighteastzones',
                            'title' => FIBER_FEDEX_CHECK_OVER
                        ),
                        array(
                            'method' => 'ups2daysamzones',
                            'title' => UPS_NEXT_DAY_AIR_EARLY
                        )
                    );
                }

                if($country_id == 223 && $this->state && in_array($this->state,array("Armed Forces Americas","Armed Forces Pacific","Armed Forces other"))){
                    $shipping_arr = array(
                        array(
                            'method' => 'uspsprioritymailzones',
                            'title' => 'USPS Priority Mail® service'
                        ),
                    );
                }

                if( $country_id == 172){
                    $shipping_arr = array(
                        array(
                            'method' => 'upsgroundeastzones',
                            'title' => FIBER_CHECK_STAND
                        ),
                        array(
                            'method' => 'ups2dayseastzones',
                            'title' => FIBER_CHECK_TWO
                        ),
                        array(
                            'method' => 'upsovernighteastzones',
                            'title' => FIBER_CHECK_ONE
                        ),
                    );
                }
                if($this->is_cabinet){
                    $shipping_arr = array(
                        array(
                            'method' => 'upsltlzones',
                            'title' => 'UPS LTL'
                        )
                    );
                }
                break;
            case "DE":
                $is_show = true;
                $de_qty = fs_products_instock_qty_of_products_id($this->pid, "DE", false, $pcs = $this->purchase_qty, true);//获取库存
                if(!$de_qty || $de_qty<$this->purchase_qty){
                    $is_show_pick_up = false; //是否展示自提
                }
                //如果整单没有从德国发货就不展示运输方式等信息
                if (!$de_qty) {
                    $is_show = false;
                }
                if ($_SESSION['languages_id']) {
                    if ($country_id == 81) {
                        $shipping_arr = array(

							array(
								'method' => 'tntgzones',
                                'title' => 'TNT Express®'
                            ),
                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard®'
                            ),
                            array(
                                'method' => 'dhlgzones',
                                'title' => 'DHL Express Domestic®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00® Service'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => FS_COMMON_DHL
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            ),
                            array(
                                'method' => 'upsexpresszones',
                                'title' => 'UPS Express Next Day 12:00®'
                            )
                        );
                    } elseif ($country_id == 98) {
                        $shipping_arr = array(


                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard®'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express®'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00®'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => FS_COMMON_DHL
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                    } elseif ($country_id == 160) {
                        $shipping_arr = array(
                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard®'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express®'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00®'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => FS_COMMON_DHL
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                    } elseif ($country_id == 222){
                        $shipping_arr = array(

                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard® 4-7 days Working Days Service'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express® 2-4 Working Days Service'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide® 1-3 Working Days'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver® 1-4 Working Days Service'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00® Service'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00® Service'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => 'DHL Economy Select® 2-5 Working Days Service'
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                    } elseif ($country_id == 228){
                        //add by rebirth   新增梵蒂冈的地址运输判断
                        $shipping_arr = array(
                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                    } elseif ($country_id == 73){
                        $shipping_arr = array(
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express®'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide®'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => FS_COMMON_DHL
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            )
                        );
                    } else {
                        $shipping_arr = array(

                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard®'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express®'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => FS_COMMON_DHL
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00®'
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                    }
                    if (!$is_show) {
                        foreach ($shipping_arr as $d => $l) {
                            if (in_array($l["method"], array("dhlexpresszones", "dhlexpressdzones","upsexpresspluszones", "upsexpresszones"))) {
                                unset($shipping_arr[$d]);
                            }
                        }
                    }
                } else {
                    $shipping_arr = array(
                        array(
                            'method' => 'dhlzones',
                            'title' => 'DHL'
                        ),

                        array(
                            'method' => 'fedexzones',
                            'title' => 'FedEx IP'
                        ),
                        array(
                            'method' => 'airmailzones',
                            'title' => 'Airmail'
                        ),
                        array(
                            'method' => 'emszones',
                            'title' => 'EMS'
                        ),
//                        array(
//                            'method' => 'fedexiezones',
//                            'title' => 'FedEx IE'
//                        ),
                        array(
                            'method' => 'tntzones',
                            'title' => 'TNT'
                        ),
                        array(
                            'method' => 'upszones',
                            'title' => 'UPS'
                        ),
                        array(
                            'method' => 'airliftzones',
                            'title' => 'Airlift shipping'
                        ),
                        array(
                            'method' => 'seazones',
                            'title' => 'Sea shipping'
                        )
                    );
                }
                if (!empty($limit)) {
                    foreach ($shipping_arr as $k => $v) {
                        if (!in_array($v['method'], $limit)) {
                            unset($shipping_arr[$k]);
                        }
                    }
                }
                break;
            case "AU":
                $shipping_arr = array(
                    /*    array(
                            'method' => 'fastwaycourierzones',
                            'title' => 'Fastway Courier'
                        ),*/
                    array(
                        'method' => 'startrackfzones',
                        'title' => 'StarTrack 1-5 Business Days',
                        "origin_title" => 'StarTrack'
                    ),
                    array(
                        'method' => 'startrackzones',
                        'title' => STARTRACK_PREMIUM_EXPRESS,
                        "origin_title" => 'StarTrack Premium'
                    ),
                    array(
                        'method' => 'tntauroadexpresszones',
                        'title' => TNT_ROAD_EXPRESS_1_4,
                        "origin_title" => 'TNT Road Express'
                    ),
                    array(
                        'method' => 'dhlauzones',
                        'title' => DHL_EXPRESS_1_3,
                        "origin_title" => 'DHL Express'
                    ),
                    array(
                        'method' => 'tntauovernightexpresszones',
                        'title' => 'TNT Overnight Express Service',
                        "origin_title" => 'TNT Overnight Express'
                    ),
                    array(
                        'method' => 'tntauzones',
                        'title' => ' TNT 9:00 Express Service',
                        "origin_title" => 'TNT 9:00 Express'
                    )
                );

                if (!empty($limit)) {
                    foreach ($shipping_arr as $k => $v) {
                        if (!in_array($v['method'], $limit)) {
                            unset($shipping_arr[$k]);
                        }
                    }
                }

//                if($is_trans){
//                    $shipping_arr = array(
//                        array(
//                            'method' => 'tntauroadexpresszones',
//                            'title' => TNT_ROAD_EXPRESS_1_4,
//                            "origin_title" => 'TNT Road Express'
//                        )
//                    );
//                }
                break;
            case "AU-NZ":
                $shipping_arr = array(
//                    array(
//                        'method' => 'aupoststandardzones',
//                        'title' => 'Australia Post Standard'
//                    ),
//                    array(
//                        'method' => 'aupostexpresszones',
//                        'title' => 'Australia Post Express'
//                    ),
                    array(
                        'method' => 'dhlauexpressworldwidezones',
                        'title' => 'DHL Express Worldwide'
                    ),
                    array(
                        'method' => 'fedexaunormalzones',
                        'title' => 'FedEx Normal'
                    ),
                    array(
                        'method' => 'fedexauexpresszones',
                        'title' => 'FedEx Express'
                    )
                );
                break;
            case "SG":
                if ($_SESSION['languages_id']) {
                    if ($country_id == 188) {
                        $shipping_arr = array(
//                            array(
//                                'method' => 'simplyzones',
//                                'title' => FS_SG_SIMPLYPOST_SHIPPING
//                            ),
                            array(
                                'method' => 'ninjavanstandardzones',
                                'title' => 'Ninja Van 1-3 Working Days'
                            ),
                            array(
                                'method' => 'ninjavanovernightzones',
                                'title' => 'Ninja Van Next Working Day'
                            ),
                            array(
                                'method' => 'speedpoststandardzones',
                                'title' => 'Speedpost Standard 1 Working Day'
                            ),
//                            array(
//                                'method' => 'simplyovernightzones',
//                                'title' => 'SimplyPost Next Working Day'
//                            )
                        );

                        if (!in_array($local_day, ['Sat', 'Sun']) && $local_hour < 15) {
                            $shipping_arr[] = array(
                                'method' => 'grabexpresszones',
                                'title' => 'GrabExpress Same Day'
                            );
                        }

                    } elseif ($country_id == 146 || $country_id == 116) {
                        $shipping_arr = array(
//                            array(
//                                'method' => 'upsexpressworldwidezones',
//                                'title' => 'UPS Worldwide Express 1-3working Days'
//                            ),
                            array(
                                'method' => 'dhlsexpresszones',
                                'title' => 'DHL World Express 1-3 Working Days'
                            )
                        );
                    } else {
                        $shipping_arr = array(
//                            array(
//                                'method' => 'fedexsgiezones',
//                                'title' => 'FedEx IE 4-6 Working Days'
//                            ),
                            array(
                                'method' => 'fedexsgzones',
                                'title' => 'FedEx IP 1-3 Working Days'
                            ),
                            array(
                                'method' => 'dhlsexpresszones',
                                'title' => 'DHL World Express 1-3 Working Days'
                            )
                        );
                    }
                }
                break;
            case "RU":
                $shipping_arr = array(
                    array(
                        'method' => 'courierzones',
                        'title' => SHIPPING_COURIER_DELIVERY
                    )
                );
                break;
            case "CN":
                $is_hidden = false;
                if ($country_id == 176) {
                    $is_hidden = true;
                }
                $is_br_hidden = false;
                if($country_id == 30 && in_array($post_code ,array('89618000'))){
                    $is_br_hidden = true;
                }
                if ($_SESSION['languages_id'] == 1) {
                    $shipping_arr = array(
                        array(
                            'method' => 'fedexzones',
                            'title' => 'FedEx IP'
                        ),

                        array(
                            'method' => 'dhlzones',
                            'title' => 'DHL'
                        ),

                        array(
                            'method' => 'airmailzones',
                            'title' => 'Airmail'
                        ),
                        array(
                            'method' => 'emszones',
                            'title' => 'EMS'
                        ),
//                        array(
//                            'method' => 'fedexiezones',
//                            'title' => 'FedEx IE'
//                        ),
//                        array(
//                            'method' => 'tntzones',
//                            'title' => 'TNT'
//                        ),
                        array(
                            'method' => 'upszones',
                            'title' => 'UPS'
                        ),
                        array(
                            'method' => 'airliftzones',
                            'title' => 'Airlift shipping'
                        ),
                        array(
                            'method' => 'seazones',
                            'title' => 'Sea shipping'
                        )
                    );
                    if (in_array($country_id, array(96, 125, 206))) {
                        $shipping_arr = array(
//                            array(
//                                'method' => 'fedexiezones',
//                                'title' => 'FedEx IE'
//                            ),
                            array(
                                'method' => 'fedexzones',
                                'title' => 'FedEx IP'
                            ),

                            array(
                                'method' => 'dhlzones',
                                'title' => 'DHL'
                            ),

                            array(
                                'method' => 'airmailzones',
                                'title' => 'Airmail'
                            ),
                            array(
                                'method' => 'emszones',
                                'title' => 'EMS'
                            ),
//                            array(
//                                'method' => 'tntzones',
//                                'title' => 'TNT'
//                            ),
                            array(
                                'method' => 'upszones',
                                'title' => 'UPS'
                            ),
                            array(
                                'method' => 'airliftzones',
                                'title' => 'Airlift shipping'
                            ),
                            array(
                                'method' => 'seazones',
                                'title' => 'Sea shipping'
                            )
                        );
                    }


                } else {
                    $shipping_arr = array(
                        array(
                            'method' => 'dhlzones',
                            'title' => 'DHL'
                        ),

                        array(
                            'method' => 'fedexzones',
                            'title' => 'FedEx IP'
                        ),
                        array(
                            'method' => 'airmailzones',
                            'title' => 'Airmail'
                        ),
                        array(
                            'method' => 'emszones',
                            'title' => 'EMS'
                        ),
//                        array(
//                            'method' => 'fedexiezones',
//                            'title' => 'FedEx IE'
//                        ),
//                        array(
//                            'method' => 'tntzones',
//                            'title' => 'TNT'
//                        ),
                        array(
                            'method' => 'upszones',
                            'title' => 'UPS'
                        ),
                        array(
                            'method' => 'airliftzones',
                            'title' => 'Airlift shipping'
                        ),
                        array(
                            'method' => 'seazones',
                            'title' => 'Sea shipping'
                        )
                    );
                }
                // 屏蔽 by rebirth   2019.12.16   reason ：对于ru 产品详情页只展示对私的运输方式，不再展示DHL(courierzones)
                //且 ems 针对ru 增加免运费20000 免运费 以及 重货 判断
//                if($country_id == 176 && $price*$currencies->currencies["RUB"]["value"]>20000){
//                    $shipping_arr = [
//                        array(
//                            'method' => 'courierzones',
//                            'title' => SHIPPING_COURIER_DELIVERY
//                        ),
//                        array(
//                            'method' => 'emszones',
//                            'title' => 'EMS'
//                        ),
//                        array(
//                            'method' => 'upszones',
//                            'title' => 'UPS'
//                        )
//                    ];
//                }
                if ($is_hidden) {
                    $shipping_arr = array(
                        array(
                            'method' => 'courierzones',
                            'title' => SHIPPING_COURIER_DELIVERY
                        )
                    );
                }
                if($is_br_hidden){
                    foreach ($shipping_arr as $d => $l) {
                        if (in_array($l["method"], array("fedexzones", "fedexiezones", "upszones"))) {
                            unset($shipping_arr[$d]);
                        }
                    }
                }
                break;
            default:
                $shipping_arr = array(
                    array(
                        'method' => 'dhlzones',
                        'title' => 'DHL'
                    ),

                    array(
                        'method' => 'fedexzones',
                        'title' => 'FedEx IP'
                    ),
                    array(
                        'method' => 'airmailzones',
                        'title' => 'Airmail'
                    ),
                    array(
                        'method' => 'emszones',
                        'title' => 'EMS'
                    ),
//                    array(
//                        'method' => 'fedexiezones',
//                        'title' => 'FedEx IE'
//                    ),
//                    array(
//                        'method' => 'tntzones',
//                        'title' => 'TNT'
//                    ),
                    array(
                        'method' => 'upszones',
                        'title' => 'UPS'
                    ),
                    array(
                        'method' => 'airliftzones',
                        'title' => 'Airlift shipping'
                    ),
                    array(
                        'method' => 'seazones',
                        'title' => 'Sea shipping'
                    )
                );

        }

        if ($country_id == 44) {
            $shipping_arr = array(
                array(
                    'method' => 'sfzones',
                    'title' => 'SF Express'
                ),
                array(
                    'method' => 'emszones',
                    'title' => 'EMS'
                )
            );
        }
        if(($warehouse == "CN") && in_array($country_id,array(100,168,129))){
            $shipping_arr[] = array(
                'method' => 'forwarderzones',
                'title' => "Forwarder Shipping"
            );
        }

        if (($warehouse == "DE") && in_array($country_id, array(81, 73, 222, 21, 72, 195, 57, 105, 171, 56, 150, 14, 204, 243, 244, 245))) {
            if ((($local_day == 'Fri'&& $local_hour < 16) || ($local_day == 'Thu' && $local_hour>16)) && $is_show_pick_up) {

                $f_day = $local_day == 'Thu' ? 1 : 0;
                $check_festival = get_festival_day($country_code,$f_day);//周五为节假日不出现周六达

                if($check_festival == 0) {
                    $shipping_arr[] = array(
                        'method' => 'dhlsaturdayzones',
                        'title' => 'DHL Saturday Delivery '
                    );
                }
            }
        }
        if (($warehouse == "US" || $warehouse == "US-ES") && !in_array($country_id, array(138, 38))) {
            $states_code = !empty($state) ? fs_get_data_from_db_fields('states_code','countries_us_states','states = "'.$this->state.'"'.' AND status = 1 AND type = 1') : '';
            $state_no_sat = array('HI', 'RI', 'AP', 'VI', 'PR', 'AE', 'AP', 'AA', 'AK');//无法周六达的州
            if ((($local_day == 'Fri'&& $local_hour < 16) || ($local_day == 'Thu' && $local_hour>17)) && !in_array($states_code,$state_no_sat)) {

                $f_day = $local_day == 'Thu' ? 1 : 0;
                $check_festival = get_festival_day($country_code,$f_day);//周五为节假日不出现周六达

                if($check_festival == 0) {
                    $shipping_arr[] = array(
                        'method' => 'saturdaydeliveryzones',
                        'title' => 'Saturday Delivery '
                    );
                }
            }
        }

        //自提
        if(!in_array($this->warehouse,array(6, 37, 67)) && !in_array($this->country_code,array("CA","MX")) && $this->purchase_qty < $this->qty){
            //非欧盟国家没有自提方式
            if (!other_eu_warehouse($this->country_id,"country_number") && !(singapore_warehouse('country_number',$this->country_id) && $this->country_id != 188) || checkNorthIrelandPostcode($post_code, $country_id)){
                $shipping_arr[] = array(
                    'method' => 'selfreferencezones',
                    'title' => FS_PICK_UP_AT_WAREHOUSE
                );
            }
        }
        $shipping_data = array();
        if(!empty($shipping_arr)){
            foreach ($shipping_arr as $k=>$v){
                $shipping_data[] = $v['method'];
            }
        }

        require_once(DIR_FS_CATALOG.'includes/classes/shipping.php');
        $shipping = new shipping();
        //西班牙默认邮编 28001
        $this->post_code = empty($this->post_code) && $country_code == 'ES' ? '28001' : $this->post_code;
        if ($this->is_cabinet) {
            $quotes_res = $GLOBALS['upsltlzones']->quotes("", $total_weight, $this->country_id, $this->post_code, $price, $this->pid, $this->purchase_qty, $this->state);
            $quotes['upsltlzones'] = $quotes_res;
        } else {
            if(in_array($this->pid,$this->spec_heavy_arr) && $this->is_shipping_free){
                $this->is_heavy_free = true;
            }
            $products_info = array('products_id' => $this->pid, 'purchase_qty' => $this->purchase_qty, 'qty' => $this->qty, 'weight' => $this->weight,
                'is_heavy_free' => $this->is_heavy_free, 'attributes' => $this->attr_option_arr,
                'over_size' => $this->isOverSize
                );
            $quotes = $shipping->quotes("", $total_weight, $shipping_data, $country_code, $this->post_code, $price,
                $this->state, $is_buck, $this->length_array, $zone_type, $is_shipping_free, $products_info);
        }
        $j = 0;
        $data = array();
        foreach ($shipping_arr as $key => $v) {
            if (isset($quotes[$v['method']]) && is_array($quotes[$v['method']]) && $quotes[$v['method']]['methods'][0]['cost'] >= 0) {
                if ($warehouse != "US" && $warehouse != "SG" && !in_array($quotes[$v['method']]['methods'][0]['id'],array("customzones","selfreferencezones","saturdaydeliveryzones"))) {
                    $day = get_days($country_code, $v['method']);
                    if(in_array($this->country_id, array(138, 38)) && $quotes[$v['method']]['methods'][0]['id'] == "upsltlzones"){
                        $day = ' '.FS_SERVICE_WORD;
                    }
                } else {
                    if (in_array($this->country_id, array(138, 38)) || $this->state=="Puerto Rico" && $quotes[$v['method']]['methods'][0]['id'] != "customzones") {
                        $day = get_days($country_code, $v['method']);
                    } else {
                        $day = "";
                    }

                }
                $data[$j]['origin_title'] = $v['title'];
                if($warehouse == "AU"){
                    $data[$j]['origin_title'] = $v['origin_title'];
                }
                if($this->post_code){
                    switch ($quotes[$v['method']]['methods'][0]['id']){
                        case "fedexgroundeastzones" :
                            $day = fs_get_data_from_db_fields('timeliness_md', 'countries_to_zip', 'zip ="'.$this->post_code.'"  limit 1');
                            $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                            break;
                        case "fedexgroundzones":
                            $day = fs_get_data_from_db_fields('timeliness_mx', 'countries_to_zip', 'zip ="'.$this->post_code.'"  limit 1');
                            $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                            break;
                        case "upsgroundzones":
                            $day = fs_get_data_from_db_fields('timeliness_mx', 'countries_to_zip', 'zip ="'.$this->post_code.'"  limit 1');
                            $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                            break;
                        case "upsgroundeastzones":
//                            $day = fs_get_data_from_db_fields('timeliness_md', 'countries_to_zip', 'zip ="'.$this->post_code.'"  limit 1');
//                            $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                            $day = " ".FS_SERVICE_WORD;
                            break;
                        case "fedexltlzones":
                            $day = " ".FS_SERVICE_WORD;
                            break;
                        case "upsltlzones":
//                            $shipping_day = $day = fs_get_data_from_db_fields('delivery_date', 'shipping_ups_ltl', 'state ="'.$state.'"  limit 1');
//                            if($day){
//                                $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
//                            }else{
                                $day = " ".FS_SERVICE_WORD;
//                            }
                            break;
                        case "dhleconomyzones":
                            $day = $country_id == 195 ? '3-5 '.FS_BUSINESS_DAYS : $day;
                    }
                }

                $data[$j]['methods'] = $v['method'];

                if ($country_id == 222) {
                    $data[$j]['title'] = $v['title'];
                }else{
                    if ($warehouse == "DE" && !in_array($quotes[$v['method']]['methods'][0]['id'],array("customzones","selfreferencezones",'dhlsaturdayzones'))) {
                        $data[$j]['title'] = $v['title'] . " " . $day . " ".FS_SERVICE_WORD;
                    } else {
                        $data[$j]['title'] = $v['title'] . " " . $day;
                    }
                }

                if ($quotes[$v['method']]['methods'][0]['cost'] == 0  && !in_array($quotes[$v['method']]['methods'][0]['id'],array("customzones","selfreferencezones"))) {
                    $data[$j]['price'] = FIBER_CHECK_FREE;
                    $data[$j]['origin_price'] = 0;
                } else {
                    $data[$j]['price'] = $currencies->new_format($quotes[$v['method']]['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
                    $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes[$v['method']]['methods'][0]['cost'] * $rate), $currencies->currencies[$_SESSION['currency']]['decimal_places']);
                }

                //澳大利亚税后价
                if($country_id == 13){
                    //cost_tax为已转货币的价格
                    $cost_tax = get_gsp_tax_price($country_id,$data[$j]['origin_price']);
                    $is_tax_shipping  = true;
                    $data[$j]['price_tax'] = $data[$j]['origin_price'] == 0 ? FIBER_CHECK_FREE_SHIPPING :
                        $currencies->new_format($cost_tax, true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value'], $is_tax_shipping);
                }

                $data[$j]['s_price'] = $quotes[$v['method']]['methods'][0]['cost'];
                $j++;
            }
        }

        if (!(in_array($country_id, array(138, 38)) && $warehouse == 'US-ES') && !(in_array($country_id, array(188)) && $warehouse == "SG")) {
            //按照运费对运输方式进行排序
            $data = my_sort($data, "origin_price", SORT_ASC);
        }
        $customez = array();
        $self = array();
        $unset_saver = false;
        foreach ($data as $v=>$k){
            if($k['methods'] == "customzones"){
                $customez = $data[$v];
                unset($data[$v]);
            }
            if($k['methods'] == "selfreferencezones"){
                $self = $data[$v];
                unset($data[$v]);
            }
            if(!$is_show_overnight){
                if(preg_match("/upsovernight|fedexpriorityovernight|fedexovernight/i",$k['methods'])){
                    unset($data[$v]);
                }
            }
            if(!$is_show_pick_up ||!$is_show_sameday || $current_hour>13){
                if(preg_match("/fedexsamedayzones/i",$k['methods'])){
                    unset($data[$v]);
                }
            }
            if(!empty($limit) && $this->local_warehouse == 20){
                if($k['methods'] == 'upsstandardzones'){
                    $unset_saver = true;
                }
             }
        }
        if($unset_saver){
            foreach ($data as $v=>$k){
                if($k['methods'] == 'upssaverzones'){
                    unset($data[$v]);
                    break;
                }
            }
        }
        if(!$this->qty){
            $is_show_pick_up = false;
        }
        if(!empty($self) && $is_show_pick_up){
            $data[] = $self;
        }
        if(!empty($customez)){
            $data[] = $customez;
        }
        //重置数组索引
        $data = array_values($data);
        return $data;
    }
    /**
     * 获取客户地址
     * @param bool $has_default
     * @return array
     */
    public function get_customers_shipping_address($has_default = true)
    {
        global $db;
        $shipping_address = array();
        $query_addresses = "SELECT address_book_id,entry_gender,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,company_type,
			entry_postcode,entry_city,entry_state,entry_country_id,entry_zone_id,entry_telephone,entry_tax_number FROM " . TABLE_ADDRESS_BOOK . "  as ab 
			INNER JOIN " . TABLE_CUSTOMERS . " as c USING(customers_id) 
			WHERE (entry_firstname != '' and  c.customers_id = :customers_id and ab.address_type!=2)";

        $query_addresses .= " Group by address_book_id order by address_book_id; ";
        $get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
        if ($get_customer_info->RecordCount()) {
            while (!$get_customer_info->EOF) {
                /*set default shipping address flag*/
                $is_default_shipping_address = false;
                if (intval($this->get_default_shipping_address_id()) == (int)$get_customer_info->fields['address_book_id']) {
                    $is_default_shipping_address = true;
                }
                if ($has_default || (!$has_default && !$is_default_shipping_address)) { // 没有默认值时候，当时是默认值不展示
                    $entry_country_name = zen_get_country_name($get_customer_info->fields['entry_country_id']);
                    $tel_prefix = zen_get_prefix($get_customer_info->fields['entry_country_id']);
                    $country_code = zen_get_country_iso_code($get_customer_info->fields['entry_country_id']);
                    $shipping_address [] = array(
                        'is_default' => $is_default_shipping_address,
                        'address_book_id' => $get_customer_info->fields['address_book_id'],
                        'entry_company' => $get_customer_info->fields['entry_company'],
                        'entry_firstname' => $get_customer_info->fields['entry_firstname'],
                        'entry_lastname' => $get_customer_info->fields['entry_lastname'],
                        'entry_street_address' => $get_customer_info->fields['entry_street_address'],
                        'entry_suburb' => $get_customer_info->fields['entry_suburb'],
                        'entry_postcode' => $get_customer_info->fields['entry_postcode'],
                        'entry_city' => $get_customer_info->fields['entry_city'],
                        'entry_state' => $get_customer_info->fields['entry_state'],
                        'entry_tax_number' => $get_customer_info->fields['entry_tax_number'],
                        'entry_country' => array(
                            'entry_country_id' => $get_customer_info->fields['entry_country_id'],
                            'entry_country_name' => $entry_country_name,
                            'tel_prefix' => $tel_prefix,
                            'country_code' => $country_code
                        ),
                        'entry_country_id' => $get_customer_info->fields['entry_country_id'],
                        'entry_country_name' => $entry_country_name,
                        'tel_prefix' => $tel_prefix,
                        'country_code' => $country_code,
                        'entry_zone_id' => $get_customer_info->fields['entry_zone_id'],
                        'entry_telephone' => $get_customer_info->fields['entry_telephone'],
                        "company_type" => $get_customer_info->fields['company_type']
                    );
                }

                $get_customer_info->MoveNext();
            }
        }

        return $shipping_address;
    }

    /**
     * 获取客户默认地址
     * @return mixed
     */
    function get_default_shipping_address_id(){
        global $db;
        $shipping_address = array();
        $query_addresses = "SELECT address_book_id FROM " . TABLE_ADDRESS_BOOK ." as ab  
				INNER JOIN " .TABLE_CUSTOMERS . " as c USING(customers_id) 
				WHERE address_book_id = customers_default_address_id 
				AND c.customers_id = :customers_id";
        $get_customer_info = $db->Execute($db->bindVars($query_addresses, ':customers_id', (int)$_SESSION['customer_id'], 'integer'));
        return $get_customer_info->fields['address_book_id'];
    }
    /**
     * 获取客户运输地址
     * @return string
     */
    private function getCustomerAddress(){
        global $db;
        $customer_id = $this->customers_id;
        $html = "";
        if(!$customer_id){
//            $html = '<p class="pro_deliverTo_mt10">
//        		<a href="'.zen_href_link("login","","SSL").'" class="fs_customer_btn01 bt_widthAll">'.FS_SHIP_SIGN_IN.'</a>
//        	      </p>';
        }else{
            $shipping_addresses = $this->get_customers_shipping_address();
            if(empty($shipping_addresses)){
                $html = '<p class="pro_deliverTo_mt20">
        		<div class="pro_deliverTo_sddressBox">
        			<p class="pro_deliverTo_sddressCont"><a href="'.zen_href_link("manage_addresses","","SSL").'"><em class="iconfont icon">&#xf057;</em>'.FS_SHIP_ADD_NEW_ADDRESS.'</a></p>
        		</div>
        	       </p>';
            }else{
                $address_str = "";
                //对运输地址进行排序
                if (!empty($shipping_addresses)) {
                    foreach ($shipping_addresses as $k => $v) {
                        if ($v['is_default']) {
                            $default_addresses = $v;
                            unset($shipping_addresses[$k]);
                            break;
                        }
                    }
                    if(!empty($default_addresses)){
                        array_unshift($shipping_addresses, $default_addresses);
                        $shipping_addresses = array_values($shipping_addresses);
                    }
                }
                foreach ($shipping_addresses as $v){
                    $address_info = Address_format($v);
                    if($v['address_book_id'] == (int)$_SESSION['checkout_default_ads']){
                        $choosez = "choosez";
                    }else{
                        $choosez = "";
                    }
                    $web_site_tag = "";
                    if($v["entry_country"]['country_code']){

                        $web_site_data = getWebsiteData(['website'], "country_code= '" . $v["entry_country"]['country_code'] . "'", " LIMIT 1");
                        $web_site_tag = $web_site_data[0][0];

                    }
                    $address_str .= '<div class="pro_deliverTo_sddressBox1 '.$choosez.'" data-address_book_id="'.$v['address_book_id'].'" data-website="'.$web_site_tag.'" data-country = "'.$v["entry_country"]['entry_country_id'].'" data-postcode="'.$v['entry_postcode'].'" data-countrycode="'.$v["entry_country"]['country_code'].'" data-countryname="'.$v["entry_country"]['entry_country_name'].'" data-state="'.$v['entry_state'].'">
        			<p class="pro_deliverTo_sddressCont1">
        				<span class="pro_deliverTo_changeTxt3 pro_deliverTo_mr10">'.$v["entry_firstname"]." ".$v["entry_lastname"].'</span>'.$address_info['address_info'].'
        			</p>
        		</div>';
                }
                $html = '<div class="pro_deliverTo_mt20 pro_deliverTo_overAutoBox deliveryTo_maxH132" id="address_list">
        	              '.$address_str.'
	                 </div>
	                 <p class="pro_deliverTo_mt5 pro_deliverTo_changeTxt4"><a href="'.zen_href_link("manage_addresses","","SSL").'">'.FS_SHIP_MANAGE.'</a></p>';
            }
        }
        return $html;
    }

    /**
     * 初始化客户城市 zip 国家
     * 获取默认 邮编城市
     * @return string
     */
    public function getDefaultAddressInfo(){
        global $db;
        switch ($this->country_code) {
            case "US":
                if($this->shipping_postCode){
                    $info = fs_get_data_from_db_fields_array(array('states','city'), 'countries_to_zip', 'zip ="' . $this->shipping_postCode . '" limit 1');
                    $this->city = $city = $info[0][1];
                    $this->post_code = $this->shipping_postCode;
                    $this->state = $info[0][0];
                    $city = $city ? $city.", " : "";
                    $ip_info = $city.$this->post_code;
                    $this->country_id = fs_get_country_id_of_code($this->country_code);
                }else{
                    $this->post_code = 10010;
                    $this->city = "New York";
                    $this->country_id = 223;
                    $this->state = "New York";
                    $ip_info = $this->city.", ".$this->post_code;
                }
                break;
            case "AU":
                if($this->shipping_postCode){
                    $city = $db->getAll("SELECT city,state FROM countries_au_zip where postcode ='".$this->shipping_postCode."'");
                    if(sizeof($city)>1 || !sizeof($city)){
                        $ip_info = $this->shipping_postCode;
                        $this->city = "";
                        $this->post_code = $this->shipping_postCode;
                    }else{
                        $this->city = $city['0']['city'];
                        $this->post_code = $this->shipping_postCode;
                        $ip_info =$city[0]['city'].", ". $this->shipping_postCode;
                    }
                    $this->country_id = fs_get_country_id_of_code($this->country_code);
                    $this->state = $city[0]['state'];
                    break;
                }else{
                    $this->post_code = 1001;
                    $this->city = "Sydney";
                    $this->country_id = 13;
                    $ip_info = $this->city.", ".$this->post_code;
                    $this->state = "NSW";
                }
                break;
            case "DE":
                if($this->shipping_postCode){
                    $city = $db->getAll("SELECT city,state FROM countries_de_zip WHERE postcode ='".$this->shipping_postCode."' AND  country = 'Germany'");
                    if(sizeof($city)>1 || !sizeof($city)){
                        $this->city = "";
                        $this->post_code = $this->shipping_postCode;
                        $state = $this->state = $city[0]['state'];
                        $state =  $state ?  $state.", " : "";
                        $ip_info = $state . $this->shipping_postCode;
                    }else{
                        $this->city = $city['0']['city'];
                        $this->post_code = $this->shipping_postCode;
                        $ip_info = $city[0]['city'].", ".$this->shipping_postCode;
                    }
                    $this->country_id = fs_get_country_id_of_code($this->country_code);
                    $this->state = $city[0]['state'];
                }else{
                    $this->post_code = 10082;
                    $this->city = "Berlin";
                    $this->country_id = 81;
                    $ip_info = $this->city.", ".$this->post_code;
                    $this->state = "Berlin";
                }
                break;
            case "GB":
                if($this->shipping_postCode){
                    $city = $db->getAll("SELECT city,state FROM countries_de_zip WHERE replace(`postcode`,' ','') ='".str_replace(" ","",$this->shipping_postCode)."' AND  country = 'United Kingdom'");
                    if(sizeof($city)>1 || !sizeof($city)){
                        $this->city = "";
                        $this->post_code = $this->shipping_postCode;
                        $state = $this->state = $city[0]['state'];
                        $state =  $state ?  $state.", " : "";
                        $ip_info = $state . $this->shipping_postCode;
                    }else{
                        $this->city = $city['0']['city'];
                        $this->post_code = $this->shipping_postCode;
                        $ip_info = ($city[0]['city'] ? ucwords(strtolower($city[0]['city'])) : "").", ".$this->shipping_postCode;
                    }
                    $this->country_id = fs_get_country_id_of_code($this->country_code);
                    $this->state = $city[0]['state'];
                }else{
                    $this->post_code = "E15 2PP";
                    $this->city = "London";
                    $this->country_id = 222;
                    $ip_info = $this->city.", ".$this->post_code;
                }
                break;
            case "SG":
                $sg_name = get_countries_name(188).', ';
                if($this->shipping_postCode){
                    $city = $db->getAll("SELECT shipping_method FROM countries_sg_zip_special WHERE replace(`postcode`,' ','') ='".str_replace(" ","",$this->shipping_postCode));
                    if(sizeof($city)){
                        $this->post_code = $this->shipping_postCode;
                        $ip_info = $sg_name.$this->shipping_postCode;
                    }else{
                        $this->post_code = $this->shipping_postCode;
                        $ip_info = $sg_name.$this->shipping_postCode;
                    }
                    $this->country_id = fs_get_country_id_of_code($this->country_code);
                }else{
                    $this->post_code = 178958;
                    $this->country_id = 188;
                    $ip_info = $sg_name.$this->post_code;
                }
                break;
            default:
                $this->post_code = "";
                $this->city = "";
                $this->country_id = fs_get_country_id_of_code($this->country_code);
                $ip_info = get_countries_name($this->country_id);
        }
        $this->country_name = get_countries_name($this->country_id);
        return $ip_info;
    }

    /**
     * 展示运输邮编
     * $isInline true 时，为内联块元素
     * @return string
     */
    public function showShippingAddress($pure_price)
    {
        $ip_info = $this->getDefaultAddressInfo();
        //$notice_info = $this->getFreeText($pure_price);
        //$free_text_notice = $notice_info['free_text_notice'];
        /*$block = '';
        if($this->related_preorder_product_id){
            //$block = "style='display:inline-block'";
        }elseif (!$this->qty && !$this->is_pre_product){
            if(!$this->check_en_us_site()){
                if($this->isCustom){
                    $block = "style='display:inline-block'";
                }
            }
        }*/
        $delivery_text =  FS_SHIP_DELIVEY_TO;
        $html = '<dl class="Ship_To_dl" id="dl_country_post">
		<dt><i class="iconfont warehouse_details_baoguoIc">&#xf430;</i>'.$delivery_text.' <div class="ship_to_a"><a href="javascript:;" onclick=\'showShippingList()\'>' . $ip_info . '</a></div></dt>
		<dd></dd>
	</dl>';
        return $html;
    }


    public function getFreeShippingText(){
        $free_text = FS_FOR_FREE_SHIPPING;
        if (all_german_warehouse("country_code", $this->country_code)) {
            $free_text = FS_FOR_FREE_SHIPPING_DE;
            if($this->country_code=="GB"){
                $free_text = FS_FOR_FREE_SHIPPING_GB1;
            }
        }
        return $free_text;
    }

    /**
     * @param int $price
     * 获取免运费气泡
     * @return array
     */
    public function getFreeText($price=0)
    {
        global $currencies;
        $notice_info = array();
        $free_str = "";
        $free_text_notice = "";
        $is_hide_free_tips = false;
        $is_buck = $this->is_buck;
        $is_pre_product = $this->is_pre_product;
        $free_text = $this->getFreeShippingText();
        if(!$is_buck) {//重货类不免运费
            if ($this->warehouse == 3 || $this->warehouse == 4) {//美国仓 加美墨国家
                $free_warehouse = 'us';
                $free_money_notice = FS_FOR_FREE_SHIPPING_US;
            } else if ($this->warehouse == 37) {//澳洲
                if($this->country_code != "NZ"){
                    $free_warehouse = 'au';
                    $free_money_notice = FS_FOR_FREE_SHIPPING_AU;
                }
            } else if ($this->warehouse == 71 && $this->country_code == 'SG') {//新加坡仓
                $free_warehouse = 'sg';
                $free_money_notice = FS_FOR_FREE_SHIPPING_US;
            } else if ($this->warehouse == 67) {//俄罗斯仓
                $free_warehouse = 'ru';
                $free_money_notice = FS_FOR_FREE_SHIPPING_RU;
            } else {
                if (!in_array($this->country_code, array("CN", "HK", "MO", "TW")) && in_array($this->warehouse, array(1, 2, 5))) {//欧洲仓
                    $free_warehouse = 'de';
                    $free_money_notice = FS_FOR_FREE_SHIPPING_DE_MONEY;
                }
            }

            if(!empty($free_warehouse)) {
                $free_info = get_ori_free_shipping_money($free_warehouse);
                $free_money = $is_pre_product ? $free_info['pre_free_price'] : $free_info['free_price'];
                $free_text_money = $is_pre_product ? $free_info['TextPrePri'] : $free_info['TextPri'];
                $free_money_notice = str_replace('$MONEY', $free_text_money, $free_money_notice);

                //澳大利亚用税后价判断
                //$price = $this->country_code == 'AU' ? $price * 1.1 : $price;
                $products_price = zen_round($currencies->currencies[$free_info['currencies_type']]['value'] * $price, 2);
                $total_price = $this->purchase_qty * $products_price;
                $is_hide_free_tips = $products_price >= $free_money ? true : false;
                $this->is_shipping_free = $total_price >= $free_money ? true : false;
            }

            if (!$is_hide_free_tips) {//不免运费，展示免运政策
                $free_str = $free_text . " " . $free_money_notice;
            }
        }
        if ($free_str && !$is_buck) {
            $free_text_notice = '<div class="track_orders_wenhao">
                    <div class="question_bg question_bg_icon iconfont icon">&#xf228;</div>
                    <div class="question_text_01 leftjt">
						<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                        <div class="arrow"></div>
                        <div class="popover-content">' . $free_str . '</div>
                    </div>
	           </div>';
        }
        $notice_info['free_text_notice'] = $free_text_notice;
        $notice_info['free_text'] = trim($free_text);
        $notice_info['free_money_notice'] = $free_money_notice;
        return $notice_info;
    }

    /**
     * 获取国家下拉选框
     * @return string
     */
    private function getCountryList($hide_country=array())
    {
        if (!$this->country_id) {
            $this->getDefaultAddressInfo();
        }
        $country = zen_draw_countries_pull_down_add_tag_new('shipping_country', 'shipping_country', 'session', $this->country_id,$hide_country);
        return $country;
    }

    /**
     * 是否需要邮编的国家
     * @return array|bool
     */
    private function is_country_with_zip(){
        $country = array("GB","US","AU","DE","SG");
        if(in_array($this->country_code,$country)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 跳出站点模版
     * @return string
     */
    private function ship_outside_for_zip_template(){
        $show_post_zip = $this->is_country_with_zip();
        if(!$show_post_zip){
            return "";
        }
        $hide_country = array(strtolower($this->country_code));
        $text = FS_SHIP_OUTSIDE." ".strtoupper($this->country_code);
        $web_code = $this->country_code == "GB" ? "UK" : strtoupper($this->country_code);
        $web_code = $this->country_code == "JP" ? "日本" : strtoupper($this->country_code);
        $web_code = "<span class='code_str_aron'>".$web_code."</span>";
        if($this->language_code == "jp"){
            $text =  $web_code." ".FS_SHIP_OUTSIDE;
        }
        $html = '
            <div class="orenter_fa1 pro_deliverTo_mt20 pro_deliverTo_mb20">
                 <div class="cutoff_line1"></div>
                    <span class="or_txt1">'.FS_SHIP_OR.'</span>
            </div>
            <div>
                <span class="country_outside" style="display: none;">'.$text.'</span>
                <div class="choose_address">
                             ' . $this->getCountryList($hide_country) . '
                </div>
            </div>';
        return $html;
    }
    /**
     * 切换邮编模版
     */
    private function changePostCodeTemplate(){
        $show_post_zip = $this->is_country_with_zip();
        $web_code = $this->country_code;
        if($this->country_code == "GB"){
            $web_code = "UK";
        }elseif ($this->country_code == "JP"){
            $web_code = "日本";
        }
        $city_name = $this->getCityInfoByPostCode($this->post_code);
        if($show_post_zip){
            $html = '
            <div class="orenter_fa1 pro_deliverTo_mt20 pro_deliverTo_mb20">
                <div class="cutoff_line1"></div>
                <span class="or_txt1">'.FS_SHIP_ENTER.$web_code. FS_SHIP_ZIP_CODE.'</span>
            </div>
            <div>
               <div class="pro_deliverTo_changeBox" id="pro_deliverTo_changeDefalt">
                 <span class="pro_deliverTo_changeTxt">
                        '.FS_SHIP_DELIVEY_TO.'
						<em class="pro_deliverTo_changeTxt1 shippingCity">'.($city_name ? $city_name.'<i class="symbol">,</i>' : '').'</em>
                        <em class="pro_deliverTo_changeTxt1 shippingPostCode">'.$this->post_code.'</em>, 
                        <em class="pro_deliverTo_changeTxt1 shippingCountry">'.$this->country_name.'</em>
                        <a href="javascript:;" class="pro_deliverTo_changeTxt2 pro_deliverTo_ml10" onclick="pro_change_tab($(this).parents(\'.pro_deliverTo_changeBox\'))">'.FS_SHIP_CHANGE.'</a>
                 </span>
               </div>
               <div class="pro_deliverTo_changeBox1  pro_deliverTo_changeDT choosez">
                     <div class="pro_deliverTo_changeTxt pro_deliverTo_changeDTL">
                            <span class="pro_deliverTo_changeFL">'.FS_SHIP_DELIVEY_TO.'</span>
                            <div class="pro_deliverTo_country">
                                   <span class="pro_deliverTo_countryICbox '.strtolower($this->country_code).' shipping_country_code"></span><span class="shippingCountry">'.$this->country_name.'</span>
                            </div>
                     </div>
                     <div class="pro_deliverTo_changeDTR">
                            <input type="text" name="" class="header_main_search_txt post_code_shipping" value="'.$this->post_code.'"><a href="javascript:;" class="top_country_more_main_save" id="pro_deliverTo_changeApply" onclick="get_shipping_list(this,1,'.$this->country_id.')">'.FS_SHIP_APPLY.'</a>
               
                     </div>
               </div>
               <div class="error_prompt post_code_error">'.FS_PRODUCTS_POST_CODE_EMPTY_ERROR.'</div> 
           </div>';
        }else{
            $html = '
                <div class="orenter_fa1 pro_deliverTo_mt20 pro_deliverTo_mb20">
                     <div class="cutoff_line1"></div>
                        <span class="or_txt1">'.FS_SHIP_OR_OTHER.'</span>
                </div> 
               <div class="pro_deliverTo_changeBox1  pro_deliverTo_changeDT" id="pro_deliverTo_changeDefalt">
                  
                        <div class="pro_deliverTo_changeTxt pro_deliverTo_changeDTL pro_deliverTo_widthBai11">
	            		<span class="pro_deliverTo_changeFL">'.FS_SHIP_DELIVEY_TO.'</span>
	            	   </div>
	            	   <div class="pro_deliverTo_changeDTR ro_deliverTo_widthBai89">'.$this->getCountryList().'</div>
               </div>
            ';
        }
        return $html;
    }
    /**
     * 展示产品详情页运费弹出层
     * @return string
     */
    public function showShippingPopup()
    {
        if(!$this->country_id){
            $this->getDefaultAddressInfo();
        }
        $default_methods = $this->is_default_methods ? $this->is_default_methods : "";
        $settingDay = $this->getSettingDay($default_methods);
        $address_template = $this->getCustomerAddress();
        $zip_template = $this->changePostCodeTemplate();
        $web_code = $this->country_code;
        $address_template_a = '';
        if (!$this->customers_id) {
            $address_template_a .= FS_SHIP_SIGN_IN;
        }
        if($this->country_code == "GB"){
            $web_code = "UK";
        }elseif ($this->country_code == "JP"){
            $web_code = "日本";
        }
        $web_code = "<span class='code_str_aron'>".$web_code."</span>";
        $is_show_zip = $this->is_country_with_zip();
        if($is_show_zip){
            $text = FS_SHIP_OUTSIDE." ".$web_code;
            if($this->language_code == "jp"){
                $text = $web_code." ".FS_SHIP_OUTSIDE;
            }
        }else{
            $text = $this->country_name;
        }
        if($this->language_code == "jp"){
            $url_des = '<a href="javascript:void(0)" class="rediretc_to_index"></a>'.FS_REDIRECT_PART1;
        }else{
            $url_des = FS_REDIRECT_PART1.'<a href="javascript:void(0)" class="rediretc_to_index"></a>';
        }
        $is_spuer_spec = in_array($this->pid, [73579, 73958]) && !in_array($this->country_id, [13, 100, 129, 168]) &&
        !in_array($this->local_warehouse, [37, 20, 67]) &&
        ($this->local_warehouse == 2 || $this->qty == 0) ? true : false;
        $html = '
        <div style="display: none" id="pro_postcode_system_alert" class="new_popup video show pro_email_share pro_deliverTo_alert location_ui_overlay">
            <div class="new_popup_main popup_width480 pupop_video">
                <h2 class="new_popup_tit">
                    <strong>'.FS_CHOOSE_LOCATION.'</strong>
                    <span class="icon iconfont"></span>
                </h2>
                 <div class="new_popup_content addCart_cont product_email_share">
        	<p>'.FS_DELIVERY_OPTION.$address_template_a.'</p>
               ' . $address_template . ' 
               '. $zip_template .'
	        <div class="pro_deliverTo_overAutoBox pro_deliverTo_mt15">
                <div class="shipping_list">
                
                </div>
            	<div class="spinWrap list_fsLoading pro_deliverTo_list_fsLoading" style="display: none;">
            		<div class="bg_color"></div>
            		<div id="loader_order_alone" class="loader_order">
            			<svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg>
            	</div>
            	</div>	
            </div>
            ';
        if($is_spuer_spec){
            $html .= '<div class="shipping_option_prompt">'.FS_CHECKOUT_SPEC_PRODUCTS_DOUBT.'<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                <div class="question_bg_icon question_bg_grayIcon iconfont icon"></div>
                <div class="new_m_bg1"></div>
                <div class="new_m_bg_wap">
                    <div class="question_text_01 leftjt">
                        <a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon"></i></a>
                        <div class="arrow"></div>
                        <div class="popover-content">
                            '.FS_CHECKOUT_SPEC_PRODUCTS_TIPS.'
                        </div>
                    </div>
                </div>
            </div></div>';
        }
        $html .= $this->ship_outside_for_zip_template().'
                <div class="pro_deliverTo_mt5">
                         <p class="pro_deliverTo_tips defalut_tit">'.FS_SHIP_CONTINUE_SEE.'</p>
                         <p class="pro_deliverTo_tips redirect_tit" style="display: none;">'.$url_des.FS_REDIRECT_PART2.'</p>
                </div>
                <p class="pro_deliverTo_mt20">
                     <input type="hidden" value="' . $this->get_weight_for_prdoucts_id() . '" name="weight_num" id="weight_num">
                     <input type="hidden" value="' . $this->pure_price . '" name="procuts_price" id="products_price">
                     <input type="hidden" id="confirm_postCode" value="'.$this->post_code.'">
                     <input type="hidden" id="default_country_name" value="'.$this->country_name.'" > 
                     <input type="hidden" id="default_country_id" value="'.$this->country_id.'">
                     <input type="hidden" id="default_language_code" value="'.$this->language_code.'">
                     <span  style="display: none"  id="default_outside_text">'.$text.'</span>
                     <input type="hidden" id="redirect_country_code" value="'.$this->country_code.'">
                     <input type="hidden" id="products_id" value="'.$this->pid.'">
                     <input type="hidden" id="default_country_code" value="'.strtolower($this->country_code).'">
                     <input type="hidden" id="city_and_post" value="'.$this->getDefaultAddressInfo().'">
                     <input type="hidden" id="ship_day" value="'.$settingDay.'">
                     <input type="hidden" id="confirm_state" value="'.$this->state.'">
                     <button href="javascript:;" id="shipping_btn_done" class="fs_customer_btn01 bt_floatRight" onclick="redirect_website(\''.$this->language_code.'\',this,'.$this->pid.',1)"><span>'.FS_SHIP_DONE.'</span>
                         <div class="loading_box" style="display: none">
                        <div class="new_chec_bg"></div>
                        <div class="loader_order">
                        <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                        </svg>
                        </div>                     
                        </div>
                    </button>
                </p>
            </div>
        </div></div>';
        return $html;
    }

    /**
     * 判断产品当前仓库是否开启
     * @param $country_id
     * @return bool
     */
    public function products_status($country_code)
    {
        if (!$country_code) {
            return false;
        }
        global $db;
        $warehouse_data = fs_products_warehouse_where($country_code);
        $warehouse = $warehouse_data['code'].'_status';
        $sqlCache = sqlCacheType();
        $status = $db->getAll("SELECT {$sqlCache} products_status,{$warehouse} FROM ".TABLE_PRODUCTS." WHERE products_id={$this->pid} LIMIT 1");
        if (!empty($status)) {
            $all_status = $status[0]['products_status'];
            $local_status = $status[0][$warehouse];
            if (!$all_status) {
                return false;
            }
            if (!$local_status) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断改产品是否被 标记为待观察以及精简待关闭
     * @return bool
     */
    public function is_tag()
    {
        global $db;
        $sqlCache = sqlCacheType();
        $tag_info = $db->Execute("SELECT {$sqlCache} coming_close,is_important FROM " . TABLE_PRODUCTS . " WHERE products_id=" . $this->pid . " LIMIT 1");
        if ($tag_info && !$tag_info->EOF) {
            $is_important = (int)($tag_info->fields['is_important']);
            $coming_close = $tag_info->fields['coming_close'];
            if (in_array($is_important,array(0, 9)) || in_array($coming_close, array(1, 2))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $type 1:列表 other:qv
     * @return string
     */
    public function showProductsListPost($type=''){
        $ip_info = $this->getDefaultAddressInfo();
        $country_list = $this->getCountryList();
        $show_post_zip = $this->is_country_with_zip() ? "" : "style='display:none'";
        if($type == 1){
            $ship_to = "";
        }else{
            $ship_to = FS_SHIP_DELIVEY_TO." ";
        }
        $html = '<div class="pro_postcode_system_box post_code_common" id="pro_postcode_system_alert">
                        <div>'.$ship_to.' <!-- <span>94066, San Mateo</span> -->
                             <div class="new_proList_shipTime_link new_proList_show"><span class="aron_barry">'. $ip_info.'</span>
                                <div class="productList_top_country_more new_proList_Moreshow showO">
                                    <div class="header_sign_more_arrow"></div>
                                    <div class="new_proList_closeBox">
                                       <span class="iconfont icon new_proList_closeCon">&#xf092;</span>
                                   </div>
                                    <div class="top_country_more_main">
                                        <h2 class="top_country_more_main_smalltit">'.FS_SHIP_LIST_COUNTRY.'</h2>
                                        '.$country_list.'
                                        <div class="postBox" '.$show_post_zip.'>
                                                 <h2 class="top_country_more_main_smalltit">'.FS_SHIP_LIST_POST.'</h2>
                                            <div>
                                                <input type="text" id="confirm_postCode" value="'.$this->post_code.'" class="pro_proList_Input01">
                                                <input type="hidden" id="redirect_country_code" value="'.$this->country_code.'">
                                                <div class="error_prompt post_error">'.FS_PRODUCTS_POST_CODE_EMPTY_ERROR.'</div>    
                                            </div>
                                        </div>                            
                                        <div class="top_country_more_main_save_fa">
                                            <div class="top_country_more_main_save_fa_son"></div>
                                            <a class="top_country_more_main_save" href="javascript:;" onclick="redirect_website(\''.$this->language_code.'\',this,\'\',2)">Save</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="iconfont icon aron_barry">&#xf087;</span>
                            </div>
                        </div>
                    </div>';
        return $html;
    }

    /**
     * 初始化客户城市 zip 国家
     * 获取默认 邮编城市
     * @return string
     */
    public function getCityInfoByPostCode($postCode=''){
        global $db;
        $city_name = '';
        switch ($this->country_code) {
            case "US":
                if($postCode){
                    $info = fs_get_data_from_db_fields_array(array('states','city'), 'countries_to_zip', 'zip ="' . $postCode . '" limit 1');
                    $city_name = $info[0][1];
                }
                break;
            case "AU":
                if($postCode){
                    $city = $db->getAll("SELECT city,state FROM countries_au_zip where postcode ='".$postCode."'");
                    if(sizeof($city)>1 || !sizeof($city)){
                        $city_name = "";
                    }else{
                        $city_name = $city[0]['city'];
                    }
                    break;
                }
                break;
            case "DE":
                if($postCode){
                    $city = $db->getAll("SELECT city,state FROM countries_de_zip WHERE postcode ='".$postCode."' AND  country = 'Germany'");
                    if(sizeof($city)>1 || !sizeof($city)){
                        $city_name = $city[0]['state'] ? $city[0]['state'] : "";
                    }else{
                        $city_name = $city[0]['city'];
                    }
                }
                break;
            case "GB":
                if($postCode){
                    $city = $db->getAll("SELECT city,state FROM countries_de_zip WHERE replace(`postcode`,' ','') ='".str_replace(" ","",$postCode)."' AND  country = 'United Kingdom'");
                    if(sizeof($city)>1 || !sizeof($city)){
                        $city_name = $city[0]['state'] ? $city[0]['state'] : '';
                    }else{
                        $city_name = $city[0]['city'] ? ucwords(strtolower($city[0]['city'])) : "";
                    }
                }
                break;
        }
        return $city_name;
    }

    /***
     * 获取气泡模版
     * @param $notice
     * @param bool $is_block
     * @return string
     */
    public function getPopupNoticeTemplate($notice,$is_block = false){
        if(empty($notice)){
            return "";
        }
        $block = $is_block ? "style:'display:block'" :"";
        $notice = '<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert" '.$block.'>
                    <div class="question_bg_icon question_bg_grayIcon iconfont icon">&#xf071;</div>
                    <div class="new_m_bg1"></div>
                    <div class="new_m_bg_wap">
                        <div class="question_text_01 leftjt">
						<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                            <div class="arrow"></div>
                            <div class="popover-content">
                                '.$notice.'
                            </div>
                        </div>
                    </div>
                </div>';
        return $notice;
    }
    /**
     * 产品详情页使用
     * 设置库存和运输方式
     * $is_show是否展示showShippingAddress()版块
     */
     public function  getStockShipping($pure_price,$first_category_id="",$is_show = true){
        //存在关联预售产品id时
         $check_product_is_pre_product = $this->is_pre_product;
         if($is_show){
             $shippingAddress = $this->showShippingAddress($pure_price);
         }else{
             $shippingAddress = '';
         }

         $stock = $this->get_warehouse_instock_qty($this->isCustom,'','details');
         $html = $stock . $shippingAddress;

         //$notice = $this->getNoticeInfo();
         //$notice =  $this->getPopupNoticeTemplate($notice);
         //$html .= ($this->isCustom && !$this->qty) ? $notice : '';
         if($this->related_preorder_product_id){
             //$this->isShowNotice = false;
             $stock = $this->get_warehouse_instock_qty($this->isCustom,false,'details');
             $html = $stock.$shippingAddress;
             $is_customized_pre = check_product_is_customized_pre_product($this->related_preorder_product_id); //是否是定制预售产品
             if(!($this->isCustom && $is_customized_pre)){
                 $html .= $this->getPreOrderTemplate($first_category_id);
             }
         }elseif ($check_product_is_pre_product){
             $html = $this->getPreOrderTemplate($first_category_id);
             $html .= $shippingAddress;
         }
        return $html;
     }

    /***
     * 获取pre-order 表达说明
     * @param $first_category_id
     * @return string
     */
    public function getPreOrderTemplate($is_show_popup_message = true){
        $html = "";
        $check_product_is_pre_product = $this->is_pre_product;
        if($this->related_preorder_product_id && $this->main_page != 'request_stock'){
            $notice_text = PREORDER_DESPRCTION;
            $notice = $this->getPopupNoticeTemplate($notice_text);
            $html.= '<div><a class="track_orders_wenhao_only aron_carr_barry_tag" target="_blank" href="'.reset_url('products/'.$this->related_preorder_product_id.'.html').'">'.FS_PRE_ORDER.'</a> '.PRERER_SAVE.'';
            $html.= $notice."</div>";
        }elseif ($check_product_is_pre_product){
            $dot = ",";
            if($this->country_code == "JP" && $_SESSION['languages_code'] == 'jp'){
                $dot = "、";
            }
            if($this->main_page == 'advanced_search_result'){
                $search_show = 'search_show';
                $ship_from = FS_DAY_PROCESSING_SEARCH;
            }else{
                $search_show = '';
                $ship_from = FS_DAY_PROCESSING;
            }

            $notice_text = "<span class=\" track_orders_wenhao track_orders_wenhao_only ".$search_show."\">
                ".FS_PRE_ORDER.$dot."
                	<div class=\"new_m_bg1\"></div>
							<div class=\"new_m_bg_wap\">
                                <div class=\"question_text_01 leftjt\">
                                <a class=\"bubble_popup_close_a m_960_close\" href=\"javascript:;\"><i class=\"iconfont icon\">&#xf092;</i></a>
                <div class=\"arrow\"></div>
                <div class=\"popover-content\">
                    ".PREORDER_DESPRCTION."
                </div>
            </div>
            </div>
             </span>";
            $notice_text_last = PRERDER_PROCESSIONG;
            $lead_time=  str_replace('$DAYNUMBER',$this->products_leadtime,$ship_from);
            $notice_last =  $this->getPopupNoticeTemplate($notice_text_last);
            if(!$is_show_popup_message && $this->main_page == 'advanced_search_result'){
                $notice_last = "";
            }
            $html = $notice_text." ".$lead_time.$notice_last;
        }
        return $html;
    }

    /**
     * 获取pre-order免运费金额
     * @param $constant 预售产品常量
     * @param $old_constant 标准产品常量
     * @return mixed
     */
    public function get_free_pro_order_shipping_money($constant,$old_constant,$type = 0){
        $free_pre_order_money = ['us'=>'US$ 299','ca'=>'C$ 399','mx'=>'MXN$ 6,000','de'=>'299 €','uk'=>'£299','au'=>'A$399'];

        if ($this->warehouse == 3 || $this->warehouse == 4) {
            if (in_array($_SESSION['languages_code'], ['en', 'fr']) && $_SESSION['countries_iso_code'] == 'ca' && $_SESSION['currency'] == 'CAD') {
                $free_tips = $this->is_pre_product ? str_replace('MONEY', $free_pre_order_money['ca'], $constant) : $old_constant;
            } elseif (in_array($_SESSION['languages_code'], ['en', 'mx']) && $_SESSION['countries_iso_code'] == 'mx' && $_SESSION['currency'] == 'MXN') {
                $free_tips = $this->is_pre_product ? str_replace('MONEY', $free_pre_order_money['mx'], $constant) : $old_constant;
            } else {
                $free_tips = $this->is_pre_product ? str_replace('MONEY',$free_pre_order_money['us'],$constant) : $old_constant;
            }
            if($type == 1){
                $free_tips = $old_constant;
            }
        } elseif ($this->warehouse == 37) {
            if($type == 0) {
                $free_tips = $this->is_pre_product && $this->country_code != 'NZ' ? str_replace('MONEY', $free_pre_order_money['au'], $constant) : $old_constant;
            }else{
                $free_tips = $old_constant;
            }
        } else {
            if (get_warehouse_by_code($this->country_code) == 'cn') {
                $free_tips = $old_constant;
            }else{
                $free_tips = $this->is_pre_product ? str_replace('MONEY',$free_pre_order_money['de'],$constant) : $old_constant;
                if ($_SESSION['currency'] == "GBP") {
                    $free_tips = $this->is_pre_product ? str_replace('MONEY',$free_pre_order_money['uk'],$constant) : $old_constant;
                }elseif ($_SESSION['currency'] == "USD"){
                    $free_tips = $this->is_pre_product ? str_replace('MONEY',$free_pre_order_money['us'],$constant) : $old_constant;
                }

                if($type == 1) {
                    $free_tips = $old_constant;
                }
            }
        }
        return $free_tips;
    }
    /*
    * 展示库存数量
    * @return string
    * $type :1
    */
    public function get_header_instock_info($type=false){
        $instockShow = '';
        if($this->over_stock_line || !$this->qty){
            $current_qty =$this->cn_qty;
            if(!$current_qty){
                if($this->is_custom()){ //定制产品国内无库存不展示
                    $instockShow = ($this->InCnStock ? QTY_SHOW_IN_CN_STOCK_1 : FS_COMMON_CUSTOMIZED);
                }else{
                    $instockShow = ($this->InCnStock ? QTY_SHOW_IN_CN_STOCK_1 : QTY_SHOW_AVAILABLE);
                }
            }
        }else{
            $current_qty =$this->qty;
        }
        $unit = $this->get_unit_by_qty($current_qty);
        $qty = $current_qty.$unit;
        if($current_qty){
            $qty_html = $qty;
        }else{
            $qty_html = $instockShow;
        }


        return $qty_html;
    }


    /**
     * GSP项目 美国站点且国家为美国时 详情页库存展示调整 只针对美东仓无库存的产品设置
     * 1.标准产品，美东本地仓无库存，国内仓有库存 价格：展示price details
     * 库存：展示库存数量，xx In stock, shipped from and sold by FS Asia
     * 2.标准产品，美东本地仓无库存，国内仓无库存  价格：展示price details
     * 库存：In stock, shipped from and sold by FS Asia
     * 3.定制产品 价格：展示price details
     * 库存：Customized, shipped from and sold by FS Asia
     * @param $page, 标识调用页面details：详情页，list：列表
     * @return $html
     */
    /*public function show_en_us_stock_html($page='details'){
        $html = '';
        $eu_au_true = $this->check_eu_and_au_warehouse();
        $asia_warehouse = $this->get_local_warehouse_name(2);
        if($page=='details'){
            $common_html = '';
            if($this->check_en_us_site()){
                if(!$this->get_product_is_buck()){
                    $common_html = '<span class="detail-new-shipedForm-txt">'.$this->getPopupNoticeTemplate(FS_GSP_STOCK_7);
                }
            }elseif ($eu_au_true){
                if($this->cn_qty > 0){
                    $common_html = '<em class="instock_warehouse sfpDetail-instock-warehouse">'.$this->get_local_warehouse_name(2).'</em>';
                }else{
                    $common_html = '<em class="instock_warehouse sfpDetail-instock-warehouse">'.QTY_SHOW_AVAILABLE_TAG_NEW_INFO.'</em>';
                }
            }
            //美东仓无库存
            if($this->isCustom){
                //定制产品
                $html = '<span class="track_orders_wenhao track_orders_wenhao_only">'.FS_GSP_STOCK_1.FS_EMAIL_PAUSE.'</span><span style="padding-left: 3px;">'.$asia_warehouse.'</span>'.$common_html;
            }else {
                //标准产品
                $unit = $this->get_unit_by_qty($this->cn_qty);
                if($this->cn_qty < 1 && !$this->InCnStock){
                    $unit = FS_AVAILABLE;
                }
                $asia_warehouse_html = '<span style="padding-left: 3px;">'.$asia_warehouse.'</span>';
                if($eu_au_true){
                    $asia_warehouse_html = '';
                    if($this->cn_qty <1) {
                        $unit = QTY_SHOW_AVAILABLE;
                    }
                }
                $other_information = $this->show_detail_all_warehouse_stock_html();
                $html = '<span class="track_orders_wenhao track_orders_wenhao_only">' . ($this->cn_qty!=0 ? $this->cn_qty.' ' : '') . $unit .FS_EMAIL_PAUSE .$other_information . '</span>'.$asia_warehouse_html.$common_html;
            }
        }else if($page=='shopping_cart'){
            $warehouse_html = $asia_warehouse;
            if($this->isCustom){
                $html = '<span>'.FS_COMMON_CUSTOMIZED.FS_EMAIL_PAUSE.'</span><span> '.$warehouse_html.'</span>';
            }else{
                $unit = QTY_SHOW_ZERO_STOCK_1;
                if($this->cn_qty < 1 && !$this->InCnStock){
                    $unit = FS_AVAILABLE;
                }
                if($eu_au_true){
                    if($this->cn_qty > 0){
                        $warehouse_html = $asia_warehouse;
                    }else{
                        $warehouse_html = QTY_SHOW_AVAILABLE_TAG_NEW_INFO;
                        $unit = QTY_SHOW_AVAILABLE;
                    }
                }
                $html = '<span>'.(($this->cn_qty != 0) ? $this->cn_qty.' ' : '').$unit.FS_EMAIL_PAUSE.'</span><span> '.$warehouse_html.'</span>';
            }
        }else{
            if($this->isCustom){
                $html = '<div><span>'.FS_GSP_STOCK_1.FS_EMAIL_PAUSE.'</span>'.FS_GSP_STOCK_2.'</div>';
            }else{
                $unit = $this->get_unit_by_qty($this->cn_qty);
                if($this->cn_qty < 1 && !$this->InCnStock){
                    $unit = FS_AVAILABLE;
                }
                $warehouse_html = FS_GSP_STOCK_2;
                if($eu_au_true){
                    if($this->cn_qty > 0){
                        $warehouse_html = $asia_warehouse;
                    }else{
                        $warehouse_html = QTY_SHOW_AVAILABLE_TAG_NEW_INFO;
                        $unit = QTY_SHOW_AVAILABLE;
                    }
                }

                $html = '<div><span>'.(($this->cn_qty != 0) ? $this->cn_qty.' ' : '').$unit.FS_EMAIL_PAUSE.'</span>'.$warehouse_html.'</div>';
            }
        }
        return $html;
    }*/


    /*public function show_qty_line_html($page='details')
    {
        $eu_au_true = $this->check_eu_and_au_warehouse();
        $asia_warehouse = $this->get_local_warehouse_name(2);
        if($page == 'details'){
            $common_html = '';
            if($this->check_en_us_site()){
                if(!$this->get_product_is_buck()){
                    $common_html = '<span class="detail-new-shipedForm-txt">'.$this->getPopupNoticeTemplate(FS_GSP_STOCK_7);
                }
            }elseif ($eu_au_true){
                if($this->cn_qty > 0){
                    $common_html = '<em class="instock_warehouse sfpDetail-instock-warehouse">'.$this->get_local_warehouse_name(2).'</em>';
                }else{
                    $common_html = '<em class="instock_warehouse sfpDetail-instock-warehouse">'.QTY_SHOW_AVAILABLE_TAG_NEW_INFO.'</em>';
                }
            }

            //美东仓无库存
            if($this->isCustom){
                //定制产品
                $html = '<span class="track_orders_wenhao track_orders_wenhao_only">'.FS_GSP_STOCK_1.FS_EMAIL_PAUSE.'</span><span style="padding-left: 3px;">'.$asia_warehouse.'</span>'.$common_html;
            }else {
                //标准产品
                $unit = $this->get_unit_by_qty($this->cn_qty);
                if($this->cn_qty < 1 && !$this->InCnStock){
                    $unit = FS_GSP_STOCK_1;
                }
                $asia_warehouse_html = '<span style="padding-left: 3px;">'.$asia_warehouse.'</span>';
                if($eu_au_true){
                    $asia_warehouse_html = '';
                    if($this->cn_qty <1) {
                        $unit = QTY_SHOW_AVAILABLE;
                    }
                }
                $other_information = $this->show_detail_all_warehouse_stock_html();
                $html = '<span class="track_orders_wenhao track_orders_wenhao_only">' . ($this->cn_qty!=0 ? $this->cn_qty.' ' : '') . $unit .FS_EMAIL_PAUSE .$other_information . '</span>'.$asia_warehouse_html.$common_html;
            }

        }else if($page=='shopping_cart'){
            $warehouse_html = $asia_warehouse;
            if($this->isCustom){
                $html = '<span>'.FS_COMMON_CUSTOMIZED.FS_EMAIL_PAUSE.'</span><span> '.$warehouse_html.'</span>';
            }else{
                $unit = QTY_SHOW_ZERO_STOCK_1;
                if($this->cn_qty < 1 && !$this->InCnStock){
                    $unit = FS_COMMON_CUSTOMIZED;
                }
                if($eu_au_true){
                    if($this->cn_qty > 0){
                        $warehouse_html = $asia_warehouse;
                    }else{
                        $warehouse_html = QTY_SHOW_AVAILABLE_TAG_NEW_INFO;
                        $unit = QTY_SHOW_AVAILABLE;
                    }
                }
                $html = '<span>'.(($this->cn_qty != 0) ? $this->cn_qty.' ' : '').$unit.FS_EMAIL_PAUSE.'</span><span> '.$warehouse_html.'</span>';
            }
        }else{
            if($this->isCustom){
                $html = '<div><span>'.FS_GSP_STOCK_1.FS_EMAIL_PAUSE.'</span>'.FS_GSP_STOCK_2.'</div>';
            }else{
                $unit = $this->get_unit_by_qty($this->cn_qty);
                $warehouse_html = FS_GSP_STOCK_2;
                if($this->cn_qty < 1 && !$this->InCnStock){
                    $unit = FS_GSP_STOCK_1;
                };
                if($eu_au_true || ($this->local_warehouse == 40 && !in_array($this->country_code,['US','PR']))){
                    if($this->cn_qty > 0){
                        $warehouse_html = $asia_warehouse;
                    }else{
                        $warehouse_html = QTY_SHOW_AVAILABLE_TAG_NEW_INFO;
                        $unit = QTY_SHOW_AVAILABLE;
                    }
                }

                $html = '<div><span>'.(($this->cn_qty != 0) ? $this->cn_qty.' ' : '').$unit.FS_EMAIL_PAUSE.'</span>'.$warehouse_html.'</div>';
            }
        }

        return $html;
    }*/

    /**
     * 详情页库存板块鼠标浮动展示各仓库存数量
     * @return string
     */
    public function show_detail_all_warehouse_stock_html(){
        $part = $other_information_html = '';
        $is_us_pr = $this->check_en_us_site();

        $template_data_arr = $this->template_data;
        if($this->over_stock_line){
            $template_data_arr = $this->template_data_line;
        }
        foreach ($template_data_arr as $k=>$v){
            if($k == FS_CN_APAC && ($this->over_stock_line || $this->qty<1)){
                $template_data_arr[$k] = $this->qty;
            }
        }
        arsort($template_data_arr);
        foreach ($template_data_arr as $k=>$v){
            if($k == FS_CN_APAC && ($this->over_stock_line || $this->qty<1)){
                $part.='<div class="arr_top">
					<i>·</i><strong>' . $this->qty . '</strong><p>' . $this->get_unit_by_qty($v) . FS_EMAIL_PAUSE . $this->get_local_warehouse_name() . '</p>
				</div>';
            }else{
                $part.='<div class="arr_top">
					<i>·</i><strong>' . $v . '</strong><p>' . $this->get_unit_by_qty($v) . FS_EMAIL_PAUSE . $k . '</p>
				</div>';
            }
        }
        $other_information_html = '<div class="question_text_01 leftjt">
		<a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
			<div class="arrow"></div>
			<div class="popover-content">
				'.$part.'
			</div>
		</div>';
        return $other_information_html;
    }

    /**
     * 判断当前国家选择为美国,波多黎各 本地仓无库存
     * @param string $countries_code 国家code
     * @return bool $result
     */
    public function check_en_us_site($countries_code=''){
        $result = false;
        if(!$countries_code){
            $countries_code = $_SESSION['countries_iso_code'];
        }
        $countries_code = strtolower($countries_code);
        if(in_array($countries_code, ['us', 'pr']) && (!$this->qty || $this->over_stock_line)){
            $result = true;
        }
        return $result;
    }

    /**
     * 欧洲仓和澳洲仓无库存且标准产品
     * @return bool
     */
    public function check_eu_and_au_warehouse(){
        if(in_array($this->local_warehouse,[20,37,71]) && !$this->isCustom && (!$this->qty || $this->over_stock_line)){
            return true;
        }
        return false;
    }

    /**
     * 获取对应仓库名称
     * @param string $local_warehouse 本地仓库id
     * @return string
     */
    public function get_local_warehouse_name($local_warehouse=''){
        $local_warehouse = $local_warehouse ? $local_warehouse : $this->local_warehouse;
        $warehouse_name = '';
        switch ($local_warehouse){
            case 2:
                $warehouse_name = FS_CN_APAC;
                break;
            case 20:
                $warehouse_name = FS_WAREHOUSE_EU;
                break;
            case 37:
                $warehouse_name = FS_WAREHOUSE_AU;
                break;
            case 40:
                $warehouse_name = FS_WAREHOUSE_US;
                break;
            case 71:
                $warehouse_name = FS_WAREHOUSE_SG;
                break;
            case 67:
                $warehouse_name = FS_WAREHOUSE_RU;
                break;
        }
        return $warehouse_name;
    }

    /**
     * @return bool  判断是否是重货或者锂电池
     */
    public function get_product_is_buck(){
        if(sizeof($this->is_buck) || $this->is_lithium_battery){
            return true;
        }
        return false;
    }

    /**
     * 判断澳大利亚重货本地仓无库存
     */
    public function au_gsp_is_buck($country_code=''){
        $country_code = $country_code ? $country_code : $this->country_code;
        if(in_array($this->warehouse,['37']) && strtoupper($country_code)=='AU' && $this->is_buck && !$this->qty){
            return true;
        }else{
            return false;
        }
    }
}
