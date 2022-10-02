<?php
use classes\custom\FsCustomRelate;
use App\Services\Solution\SolutionServices;
use App\Services\Products\ProductService;
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

class shoppingCart extends base
{
    /**
     * shopping cart contents
     * @var array
     */
    var $contents;
    /**
     * shopping cart total price
     * @var decimal
     */
    var $total;
    /**
     * shopping cart level total price
     * @var decimal
     */
    var $level_total;

    /**
     * shopping cart total weight
     * @var decimal
     */
    var $weight;
    /**
     * cart identifier
     * @var integer
     */
    var $cartID;
    /**
     * overall content type of shopping cart
     * @var string
     */
    var $columnID;
    /**
     * overall content type of shopping cart
     * @var string
     */
    var $content_type;
    /**
     * number of free shipping items in cart
     * @var decimal
     */
    var $free_shipping_item;
    /**
     * total price of free shipping items in cart
     * @var decimal
     */
    var $free_shipping_weight;
    /**
     * total weight of free shipping items in cart
     * @var decimal
     */
    var $free_shipping_price;

    var $columnIDCheck; // 保存层级数属性产品对应层级关系是否已经检查过

    var $custom_attr = "";  //定制长度属性（米数）

    var $relatedStandardId=[];

    /**
     * constructor method
     *
     * Simply resets the users cart.
     * @return void
     */
    function shoppingCart()
    {
        $this->notify('NOTIFIER_CART_INSTANTIATE_START');
        $this->reset();
        $this->notify('NOTIFIER_CART_INSTANTIATE_END');
    }

    //购物车数据同步：数据表->session，清空购物车session，将购物车表数据写入session
    function store_contents($type=0)
    {
        global $db;
        if (!$_SESSION['customer_id']) return false;

        $this->reset(false);//只清除购物车session数据
        $this->columnID = array();
        $this->getOfflineProductToCart(); //查看购物车中的关闭产品是否有开启，如有则移入购物车

        $products_query = "select products_id,customers_basket_quantity,relate_material_id,from_orders_number,is_checked
                         from " . TABLE_CUSTOMERS_BASKET . " 
                         where customers_id = '" . (int)$_SESSION['customer_id'] . "'  and save_type = {$type} order by customers_basket_id asc";

        $products = $db->Execute($products_query);
        while (!$products->EOF) {
            $material_id = $products->fields['relate_material_id'] ? (int)$products->fields['relate_material_id'] : 0;
            $this->contents[$products->fields['products_id']] = array(
                'qty' => $products->fields['customers_basket_quantity'],
                'orders_number' => $products->fields['from_orders_number'],
                'attributes' => [],
                'attributes_values' => [],
                'fiber_count' => [],     //该属性没有看到赋值的地方 为了处理warning错误初始化为空数组
                'relate_material_id' => $material_id,
                'relate_material_data' => [],
                'is_checked' => $products->fields['is_checked'],
            );

            $order_by = ' order by LPAD(products_options_sort_order,11,"0")';

            $attributes = $db->Execute("select products_options_id, products_options_value_id, products_options_value_text,column_id,upload_file
                             from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                             where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                             and products_id = '" . zen_db_input($products->fields['products_id']) . "' and save_type = {$type}" . $order_by);
            $ovflag = true;
            $options_id = $values_id = [];  //记录当前产品的所有属性项ID和属性值ID
            while (!$attributes->EOF) {
                if(!in_array((int)$attributes->fields['products_options_id'],$options_id)){
                    $options_id[] = (int)$attributes->fields['products_options_id'];
                }
                if(!in_array((int)$attributes->fields['products_options_value_id'],$values_id)){
                    $values_id[] = (int)$attributes->fields['products_options_value_id'];
                }
                /* 注释于 2020.05.29 ery 将验证属性项和属性值是否存在的多条sql查询 整合为一条查询
                 * $option_id = fs_get_data_from_db_fields('products_options_id','products_options','language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$attributes->fields['products_options_id'],'limit 1');
                $value_id = 0;
                $valueRes = $db->Execute("select count(*) as total from products_options_values where language_id=".$_SESSION['languages_id']."  and products_options_values_id=".$attributes->fields['products_options_value_id']." limit 1");
                if($valueRes->RecordCount()){
                    $value_id = $valueRes->fields['total'];
                }

                //判断该产品的该属性项以及属性值是否都存在，任何一个不存在此产品就需要删除
                if((!$option_id) || (!$value_id)){
                    $ovflag = false;
                }*/

                $this->contents[$products->fields['products_id']]['attributes'][$attributes->fields['products_options_id']] = $attributes->fields['products_options_value_id'];
                //CLR 020606 if text attribute, then set additional information
                if ($attributes->fields['products_options_value_id'] == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                    $this->contents[$products->fields['products_id']]['attributes_values'][$attributes->fields['products_options_id']] = $attributes->fields['products_options_value_text'];
                }
                $this->columnID[$products->fields['products_id']][(int)$attributes->fields['products_options_id']][$attributes->fields['products_options_value_id']] =  $attributes->fields['column_id'];
                //文件路径
                if($attributes->fields['upload_file']){
                    $this->contents[$products->fields['products_id']]['attributes_file'][$attributes->fields['products_options_id']] = $attributes->fields['upload_file'];
                }
                $attributes->MoveNext();
            }
            //验证产品属性项和属性值是否都存在 ery 2020.05.29 start
            if(!empty($options_id)){
                $optionTotal = $db->getAll("SELECT count(*) as total FROM products_options WHERE language_id=".$_SESSION['languages_id']." AND products_options_id IN (".join(',',$options_id).")");
                if($optionTotal[0]['total']!=count($options_id)){
                    $ovflag = false;
                }
            }
            if(!empty($values_id)){
                $valueTotal = $db->getAll("SELECT count(*) as total FROM products_options_values WHERE language_id=".$_SESSION['languages_id']." AND products_options_values_id IN (".join(',',$values_id).")");
                if($valueTotal[0]['total']!=count($values_id)){
                    $ovflag = false;
                }
            }//验证产品属性项和属性值是否都存在 ery 2020.05.29 end
            if($ovflag){
                $length_list = $db->getAll("select product_length_id from customers_basket_length where customers_id=".(int)$_SESSION['customer_id']." and products_id = '" . $products->fields['products_id'] . "'  and save_type={$type}  limit 1");
                if ($length_list) {
                    $this->contents[$products->fields['products_id']]['attributes']['length'] = $length_list[0]['product_length_id'];
                }
            }else{
                $this->remove($products->fields['products_id']);
            }

            //有长度属性的定制产品部分属性匹配毛料ID产品
            if($this->contents[$products->fields['products_id']]['relate_material_id'] == 0 && $this->contents[$products->fields['products_id']]['attributes']['length']){
                $length = fs_get_data_from_db_fields('length', 'products_length', 'id='.(int)$this->contents[$products->fields['products_id']]['attributes']['length']);
                $material_data = get_relate_material_data((int)$products->fields['products_id'], $length, $this->contents[$products->fields['products_id']]['qty'], $this->contents[$products->fields['products_id']]['attributes']);
                if($material_data['materialProductsId']){
                    $this->contents[$products->fields['products_id']]['relate_material_id'] = $material_data['materialProductsId'];
                    $this->contents[$products->fields['products_id']]['relate_material_data'] = $material_data;
                    $db->Execute("update " . TABLE_CUSTOMERS_BASKET . "
                    set relate_material_id = '" . (int)$material_data['materialProductsId'] . "'
                    where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                    and products_id = '" . $products->fields['products_id'] . "'");
                }
            }

            $products->MoveNext();
        }

//        $this->get_reorder();
        $this->cartID = $this->generate_cart_id();
        $this->cleanup();
    }

    //购物车数据同步：session->数据表，对比购物车session及数据表，session中新增数据写入数据表后再将最新数据写入session
    function restore_contents($type=0)
    {
        global $db;
        if (!$_SESSION['customer_id']) return false;
        $this->notify('NOTIFIER_CART_RESTORE_CONTENTS_START');
        // insert current cart contents in database
        if (is_array($this->contents)) {
            reset($this->contents);

            while (list($products_id,) = each($this->contents)) {
                $qty = $this->contents[$products_id]['qty'];
                $is_checked = $this->contents[$products_id]['is_checked'];

                $product_query = "select products_id,customers_basket_quantity from " . TABLE_CUSTOMERS_BASKET . "
                            where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                            and products_id = '" . zen_db_input($products_id) . "'  and save_type = {$type}";

                $product = $db->Execute($product_query);
                if ($product->RecordCount() <= 0) {
                    $relate_material_id = $this->contents[$products_id]['relate_material_id'];
                    $sql = "insert into " . TABLE_CUSTOMERS_BASKET . " (customers_id, products_id, customers_basket_quantity,customers_basket_date_added,save_type,relate_material_id,is_checked)
                            values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .$qty."', '".date('Ymd')."',".$type.",".$relate_material_id.",".$is_checked.")";

                    $db->Execute($sql);
                    $insert_attribute_sql = '';
                    if (isset($this->contents[$products_id]['attributes'])) {
                        reset($this->contents[$products_id]['attributes']);
                        while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                            $value = (int)$value;
                            //clr 031714 udate query to include attribute value. This is needed for text attributes.
                            $attr_value = $this->contents[$products_id]['attributes_values'][$option];
                            $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
                            if ($attr_value) {
                                $attr_value = zen_db_input($attr_value);
                            }
                            if ($option == 'length') {
                                $sql = "insert  into customers_basket_length  (customers_id,products_id,length_name,product_length_id,save_type) values ('" . (int)$_SESSION['customer_id'] . "','" . zen_db_input($products_id) . "','$option','$value',$type)";
                                $db->query($sql);
                            } else {
                                //如果有图片 把图片路径存入数据库
                                $upload_file = '';
                                if($this->contents[$products_id]['attributes_file'][$option]){
                                    $upload_file = $this->contents[$products_id]['attributes_file'][$option];
                                }
								$columnID = 0;
								if($this->columnID[$products_id][(int)$option][(int)$value]) $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                $insert_attribute_sql .= "('".(int)$_SESSION['customer_id']."', '".zen_db_input($products_id)."', '".$option."',".(int)$value.", '".(int)$columnID."', '".$attr_value."', '".$products_options_sort_order."',$type,'".$upload_file."'),";
                                /* 注释于 2020.05.29 ery 将属性数据整合为一条SQL插入
                                 * if(is_numeric($columnID)){
                                $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                                    (customers_id, products_id, products_options_id,column_id,
                                     products_options_value_id, products_options_value_text, products_options_sort_order,save_type,upload_file)
                                     values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
                                    $option . "',".$columnID.", '" . $value . "', '" . $attr_value . "', '" . $products_options_sort_order . "',$type,'".$upload_file."')";
                                    $db->Execute($sql);
                                }*/


                            }
                        }
                        $insert_attribute_sql = rtrim($insert_attribute_sql,',');
                        if($insert_attribute_sql){
                            $db->Execute("INSERT INTO " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id,column_id, products_options_value_text, products_options_sort_order,save_type,upload_file) VALUES ".$insert_attribute_sql);
                        }
                    }
                } else {
                    $qty += $product->fields['customers_basket_quantity'];
                    $sql = "update " . TABLE_CUSTOMERS_BASKET . "
                    set customers_basket_quantity = '" . $qty . "'
                    where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                    and products_id = '" . zen_db_input($products_id) . "'  and save_type={$type}";
                    $db->Execute($sql);
                }
            }
        }

        // reset per-session cart contents, but not the database contents
        $this->reset(false);
        $this->columnID = array();
        $this->getOfflineProductToCart(); //查看购物车中的关闭产品是否有开启，如有则移入购物车

        $products_query = "select products_id,customers_basket_quantity,relate_material_id
                         from " . TABLE_CUSTOMERS_BASKET . "
                         where customers_id = '" . (int)$_SESSION['customer_id'] . "'  and save_type={$type} order by customers_basket_id asc";

        $products = $db->Execute($products_query);
        while (!$products->EOF) {
            $this->contents[$products->fields['products_id']] = array(
                'qty' => $products->fields['customers_basket_quantity'],
            );
            $this->contents[$products->fields['products_id']]['relate_material_id'] = $products->fields['relate_material_id'];

            $order_by = ' order by LPAD(products_options_sort_order,11,"0")';

            $attributes = $db->Execute("select products_options_id, products_options_value_id, products_options_value_text,column_id,upload_file
                             from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                             where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                             and products_id = '" . zen_db_input($products->fields['products_id']) . "' and save_type={$type}  " . $order_by);
            $ovflag = true;
            while (!$attributes->EOF) {
                /* 注释于2020.05.29 ery 该函数主要是用在客户登录后 把未登录前加购的产品加入购物车 该验证可取消购物车页面会先调用store_contents()方法中有验证
                 * $option_id = fs_get_data_from_db_fields('products_options_id','products_options','language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$attributes->fields['products_options_id'],'limit 1');
                $value_id = 0;
                $valueRes = $db->Execute("select count(*) as total from products_options_values where language_id=".$_SESSION['languages_id']."  and products_options_values_id=".$attributes->fields['products_options_value_id']." limit 1");
                if($valueRes->RecordCount()){
                    $value_id = $valueRes->fields['total'];
                }

                //判断该产品的该属性项以及属性值是否都存在，任何一个不存在此产品就需要删除
                if((!$option_id) || (!$value_id)){
                    $ovflag = false;
                }*/

                $this->contents[$products->fields['products_id']]['attributes'][$attributes->fields['products_options_id']] = $attributes->fields['products_options_value_id'];
                //CLR 020606 if text attribute, then set additional information
                if ($attributes->fields['products_options_value_id'] == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                    $this->contents[$products->fields['products_id']]['attributes_values'][$attributes->fields['products_options_id']] = $attributes->fields['products_options_value_text'];
                }
                $this->columnID[$products->fields['products_id']][(int)$attributes->fields['products_options_id']][$attributes->fields['products_options_value_id']] =  $attributes->fields['column_id'];
                //文件路径
                if($attributes->fields['upload_file']){
                    $this->contents[$products->fields['products_id']]['attributes_file'][$attributes->fields['products_options_id']] = $attributes->fields['upload_file'];
                }
                $attributes->MoveNext();
            }
            if($ovflag){
                $length_list = $db->getAll("select product_length_id from customers_basket_length where products_id = '" . $products->fields['products_id'] . "'  and save_type={$type}  limit 1");
                if ($length_list) {
                    $this->contents[$products->fields['products_id']]['attributes']['length'] = $length_list[0]['product_length_id'];
                }
            }else{
                $this->remove($products->fields['products_id']);
            }
            $products->MoveNext();
        }

        //2017 07 24 fly 查询reorder 相关信息  历史订单 和 quotation
//        $this->get_reorder();
        $this->cartID = $this->generate_cart_id();
        $this->notify('NOTIFIER_CART_RESTORE_CONTENTS_END');
        $this->cleanup();
    }

    /**
     * @Notes: 查看购物车中的关闭产品是否有开启，如有则移入购物车
     *
     * @auther: Dylan
     * @Date: 2021/1/27
     * @Time: 17:23
     */
    function getOfflineProductToCart()
    {
        global $db;
        if (!$_SESSION['customer_id']) return false;
        $warehouse_data = fs_products_warehouse_where();
        $warehouse_where = $warehouse_data['code'] ? ' AND p.'.$warehouse_data['code'].'_status=1' : '';
        $fsCurrentInquiryField = $warehouse_data['code'] ? ' AND p.is_'.$warehouse_data['code'].'_inquiry=0' : '';

        $sql = "select cb.products_id
                from " . TABLE_CUSTOMERS_BASKET . " AS cb
                LEFT JOIN ".TABLE_PRODUCTS." AS p USING(products_id) 
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'  and save_type = 2 and p.products_status=1 ".$warehouse_where.$fsCurrentInquiryField." order by customers_basket_id asc";
        $offlineData = $db->getAll($sql);
        $productIds = [];
        if ($offlineData) {
            $productIds = array_column($offlineData, 'products_id');
        }
        if (is_array($productIds) && sizeof($productIds)>0) {
            $db->Execute("UPDATE customers_basket set save_type=0 WHERE products_id in ('".join('\',\'', $productIds)."') and customers_id = ".$_SESSION['customer_id']);
            $db->Execute("UPDATE customers_basket_attributes set save_type=0 WHERE products_id in ('".join('\',\'', $productIds)."') and customers_id = ".$_SESSION['customer_id']);
            $db->Execute("UPDATE customers_basket_length set save_type=0 WHERE products_id in ('".join('\',\'', $productIds)."') and customers_id = ".$_SESSION['customer_id']);
        }
    }


    //2017 07 24 fly 查询reorder 相关信息  历史订单 和 quotation
    function get_reorder(){
        global $db;
        if (!$_SESSION['customer_id']) return false;

        global $currencies; // $currencies依托环境，转移到其他地方要注意
        $currency_type = $_SESSION['currency'];
        $currencies_value = $currencies->currencies[$currency_type]['value'];

        //历史订单再来一单
        $order_prod = $db->getAll("SELECT `products_id`,`orders_id`, `products_quantity`, `products_price`, `reorder_type`
                                   FROM ".TABLE_CUSTOMERS_BASKET_REORDER_ORDER." WHERE `customers_id`= '".$_SESSION['customer_id']."'");
        if (sizeof($order_prod)){
            foreach ($order_prod as $qp_val){
                if (isset($this->contents[$qp_val['products_id']])){
                    $this->contents[$qp_val['products_id']]['reoder_info'] = array();
                    //单个产品购买
                    if ($qp_val['reorder_type'] == 2){
                        $this->contents[$qp_val['products_id']]['reoder_type'] = 'order';
                        if (!(isset($this->contents[$qp_val['products_id']]['reoder_price']) && $this->contents[$qp_val['products_id']]['reoder_price'] <= $qp_val['products_price'])){
                            $this->contents[$qp_val['products_id']]['reoder_price'] = $qp_val['products_price'] ;
                        }
                        $this->contents[$qp_val['products_id']]['reoder_info'][] = array(
                            'orders_id'=>$qp_val['orders_id'],
                            'products_quantity'=>$qp_val['products_quantity'],
                            'products_price'=>$qp_val['products_price'],
                            'reorder_type'=>$qp_val['reorder_type'],
                        );
                    }else{
                        $this->contents[$qp_val['products_id']]['reoder_type'] = '';
                        $this->contents[$qp_val['products_id']]['reoder_price'] = $qp_val['products_price'] ;
                        $this->contents[$qp_val['products_id']]['reoder_info'][] = array();
                    }
                }
            }
        }

        //询盘再来一单
        $quotation_prod = $db->getAll("SELECT `products_id`,`quotation_id`, `products_quantity`, `products_price`, `reorder_type`, `quotation_combination` 
                                       FROM ".TABLE_CUSTOMERS_BASKET_REORDER_QUOTATION." WHERE `customers_id`= '".$_SESSION['customer_id']."'");
        if (sizeof($quotation_prod)){
            //整单折扣的  必须要所有产品都有  才能用   1整单购买 2 可以单品购买
            $check_id = array();
            $all_ids = [];  //该产品对应的该次询价里的所有产品的id
            foreach ($quotation_prod as $qp_val){
                if ($qp_val['reorder_type'] == 1){
                    $check_id[$qp_val['quotation_id']][] = array(
                        'id'=>$qp_val['products_id'],
                        'num'=>$qp_val['products_quantity'],
                    ) ;
                    $all_ids[$qp_val['quotation_id']][] = $qp_val['products_id'];
                }else{
                    $all_ids[$qp_val['quotation_id']] =[];
                }
            }
            if (sizeof($check_id)){
                $check_id = $this->check_reorder_product($check_id);
            }
            //检查结束

            foreach ($quotation_prod as $qp_val){
                if (isset($this->contents[$qp_val['products_id']])){
                    $this->contents[$qp_val['products_id']]['reoder_info'] = array();
                    //单个产品购买   整单购买
                    if (
                        ($qp_val['reorder_type'] == 2 && isset($this->contents[$qp_val['products_id']]) && $this->contents[$qp_val['products_id']]['qty'] >= $qp_val['products_quantity']) ||
                        ($qp_val['reorder_type'] == 1 && !in_array($qp_val['quotation_id'],$check_id))
                    ){  //可以使用议价


                        $son_price_arr = $this->get_currency_combination_array($qp_val['quotation_combination']); //组合产品内各个子产品的询价价格

                        $this->contents[$qp_val['products_id']]['reoder_type'] = 'quotation';

                        $total_price = 0;
                        foreach ($son_price_arr as $pri){
                            $total_price += intval($pri['products_qty'] / $qp_val['products_quantity']) * $pri['products_price'];
                        }
                        //有价格 说明是可以议价的组合产品 为 1 其他情况为 0
                        if($total_price){
                            $this->contents[$qp_val['products_id']]['reoder_price'] = $this->get_us_formate($total_price,$currencies_value) ;
                            $this->contents[$qp_val['products_id']]['is_quote_fmt'] = 1 ;
                        }else{
                            $this->contents[$qp_val['products_id']]['reoder_price'] = $qp_val['products_price'] ;
                            $this->contents[$qp_val['products_id']]['is_quote_fmt'] = 0 ;
                        }

                        $this->contents[$qp_val['products_id']]['reoder_info'][] = array(
                            'quotation_id'=>$qp_val['quotation_id'],
                            'products_quantity'=>$qp_val['products_quantity'],
                            'products_price'=>$qp_val['products_price'],
                            'reorder_type'=>$qp_val['reorder_type'],
                            'quotation_combination'=>$qp_val['quotation_combination'],
                        );
                        $this->contents[$qp_val['products_id']]['quotation_combination'] = $son_price_arr;
                        $this->contents[$qp_val['products_id']]['all_ids'] = $all_ids[$qp_val['quotation_id']];
                    }else{
                        $this->contents[$qp_val['products_id']]['reoder_type'] = '';
                        $this->contents[$qp_val['products_id']]['reoder_price'] = $qp_val['products_price'] ;
                        $this->contents[$qp_val['products_id']]['reoder_info'][] = array();
                        $this->contents[$qp_val['products_id']]['quotation_combination'] = array();
                        $this->contents[$qp_val['products_id']]['all_ids'] = $all_ids[$qp_val['quotation_id']];
                        $this->contents[$qp_val['products_id']]['is_quote_fmt'] = 0 ;
                    }
                }
            }
        }
    }
    //检查 reorder 里面的  全单折扣的产品 必须要全部存在购物车 返回需要过来的 reorder 对应的 id  在此数组里的不可议价
    function check_reorder_product($check_id = array()){
        $return_id = array() ;
        if (sizeof($check_id)){
            foreach ($check_id as $k => $v){
                $is_flag = false ;
                if (is_array($v) && sizeof($v) > 1){ //整单产品肯定是1个以上
                    foreach ($v as $pid){
                        if (!isset($this->contents[$pid['id']]) || $this->contents[$pid['id']]['qty'] < $pid['num']){
                            $is_flag = true ;
                            break ;
                        }
                    }
                }
                if ($is_flag){
                    $return_id[] = $k ;
                }
            }
        }
        return $return_id ;
    }

    /**
     * Method to reset cart contents
     *
     * resets the contents of the session cart(e,g, empties it)
     * Depending on the setting of the $reset_database parameter will
     * also empty the contents of the database stored cart. (Only relevant
     * if the customer is logged in)
     *
     * @param boolean whether to reset customers db basket
     * @return void
     * @global object access to the db object
     */
    function reset($reset_database = false,$type=0)
    {
        global $db;
        $productsIds = [];
        $this->notify('NOTIFIER_CART_RESET_START');
        if (isset($_SESSION['customer_id']) && ($reset_database == true) && $this->contents) {
            foreach ($this->contents as $k => $products) {
                if ($products['is_checked'] == 1) {
                    $productsIds[] = $k;
                }
            }
        }
        $productsNum = $this->count_contents();



        if (isset($_SESSION['customer_id']) && ($reset_database == true)) {
            $whereProduct = '';
            if (count($productsIds) && $type == 0 && $productsNum!=count($productsIds)) {
                $whereProduct .= " and products_id in ('".join("','", $productsIds)."') ";
            }

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "' ".$whereProduct." and save_type=$type";

            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "' ".$whereProduct." and save_type=$type";

            $db->Execute($sql);

            $sql = "delete from customers_basket_length
                where customers_id = '" . (int)$_SESSION['customer_id'] . "' ".$whereProduct." and save_type=$type";
            $db->Execute($sql);

            // fairy 2019.3.15
            // 折扣 购物车和see for later 是共享的，因此没有save_type
            // 清空购物车时候一定要把报价的折扣清除掉
            $sql = "delete from customers_basket_reorder_order
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'". $whereProduct;
            $db->Execute($sql);

            // 清空购物车时候一定要把reorder的折扣清除掉
            $sql = "delete from customers_basket_reorder_quotation
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'". $whereProduct;
            $db->Execute($sql);
        }

        if ($productsNum != count($productsIds) && $productsIds && isset($_SESSION['customer_id']) && ($reset_database == true)) {
            $this->store_contents();
        } else {
            $this->contents = array();

            $this->total = 0;
            $this->weight = 0;
            $this->content_type = false;

            // shipping adjustment
            $this->free_shipping_item = 0;
            $this->free_shipping_price = 0;
            $this->free_shipping_weight = 0;

            unset($this->cartID);
            $_SESSION['cartID'] = '';
        }

        $this->notify('NOTIFIER_CART_RESET_END');
    }

    /**
     * Method to add an item to the cart
     *
     * This method is usually called as the result of a user action.
     * As the method name applies it adds an item to the uses current cart
     * and if the customer is logged in, also adds to the database sored
     * cart.
     *
     * @param integer the product ID of the item to be added
     * @param decimal the quantity of the item to be added
     * @param array any attributes that are attache to the product
     * @param boolean whether to add the product to the notify list
     * @param array $id_column: 层级属性对应的column_id数据
     * @param int $type, 购物车数据类型，默认为0代表购物车产品，1是save for later产品
     * @param array $other_info, 传递其他相关数据，需要的都可以往改参数中填充，$other_info['from_orders_number']表示产品加购的来源订单
     * @param boolean $check 针对ery新加的属性都是处理,solution产品不能有该流程
     * @return void
     * @global object access to the db object
     * @todo ICW - documentation stub
     */
    function add_cart($products_id, $qty = '1', $attributes = '', $notify = true, $id_column = array(),$type=0,$other_info=[],$check= true)
    {
        global $db;
        $this->notify('NOTIFIER_CART_ADD_CART_START');
        //为防止把属性丢失的定制产品加入购物车 在这里加一层判断 查询当前产品是否有属性
        if(!$attributes && $check){
            $length_total = zen_get_products_length_total($products_id);
            $attribute_total = zen_get_products_attributes_total($products_id);
            if($length_total || $attribute_total){
                //该产品有属性是定制产品，属性丢失不能加入购物车
                return false;
            }
        }

        $products_id = zen_get_uprid($products_id, $attributes);
		if($attributes){
			//如果当前产品有属性，判断其是否是层级属性产品
			$column_id = zen_get_products_column_id($products_id);
			if($column_id){
				//是层级属性产品，验证其对应的层级属性对应关系是否正确
				if(!sizeof($id_column)){
					//如果当前的层级ID数组$id_column为空，就$attributes属性数组重新组成
					$id_column = get_products_columnID($attributes);
					//返回正确的属性值对应的层级关系的column_id
					$id_column = get_value_right_column($column_id,$id_column);
				}
			}
		}
        $this->columnID[$products_id] = $id_column;
        $this->columnIDCheck[$products_id] = true;
        if ($notify == true) {
            $_SESSION['new_products_id_in_cart'] = $products_id;
        }
        $qty = $this->adjust_quantity($qty, $products_id, 'shopping_cart');
        $from_orders_number = $other_info['from_orders_number'] ? $other_info['from_orders_number'] : '';
        if ($this->in_cart($products_id)) {
            //加上该产品之前在购物车中的数量
            $qty += $this->contents[$products_id]['qty'];
            $this->update_quantity($products_id, $qty, $attributes);
            $this->contents[$products_id]['is_checked'] = 1; //当再次加购产品时改为勾选状态
            //客户登录的情况下 $from_orders_number若有数据表示从订单列表的buy more加购，需要查看该客户的该产品是否保存来源订单号
            if (isset($_SESSION['customer_id']) && $type==0) {
                $number_query = $db->getAll("SELECT `customers_basket_id`,`from_orders_number`,`is_checked` FROM ".TABLE_CUSTOMERS_BASKET." WHERE `customers_id`=".(int)$_SESSION['customer_id']." AND products_id='".$products_id."'");
                if($number_query[0]['customers_basket_id']){
                    $updateFields = '';
                    if (!$number_query[0]['from_orders_number'] && $from_orders_number) {
                        $updateFields .= ' , from_orders_number="'.$from_orders_number.'" ';
                        $this->contents[$products_id]['orders_number'] = $from_orders_number;
                    }
                    $db->Execute("UPDATE ".TABLE_CUSTOMERS_BASKET." SET `is_checked`=1 ".$updateFields." WHERE customers_basket_id=".$number_query[0]['customers_basket_id']);
                }
            }
            if(!$this->contents[$products_id]['orders_number'] && $from_orders_number){
                $this->contents[$products_id]['orders_number'] = $from_orders_number;
            }
        } else {
            //is_checked 默认未勾选状态
            $this->contents[$products_id] = array('qty' => (float)$qty, 'is_checked' => 1);

            $relate_material_id = $_POST['material_id'] ? (int)$_POST['material_id'] : 0;
            if($from_orders_number){
                $this->contents[$products_id]['orders_number'] = $from_orders_number;
            }
            // insert into database
            if (isset($_SESSION['customer_id'])) {
                $sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
                              (customers_id, products_id, customers_basket_quantity,
                              customers_basket_date_added,save_type,relate_material_id,from_orders_number) 
                              values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
                    $qty . "', '" . date('Ymd') . "',".$type.",".$relate_material_id.",'".$from_orders_number."')";

                $db->Execute($sql);
            }
            $this->contents[$products_id]['relate_material_id'] = $relate_material_id;
            //将定制产品的属性用一条SQL插入数据库
            $insert_attribute_sql = $insert_length_sql = '';
            if (is_array($attributes)) {
                reset($attributes);
                while (list($option, $value) = each($attributes)) {
                    //CLR 020606 check if input was from text box.  If so, store additional attribute information
                    //CLR 020708 check if text input is blank, if so do not add to attribute lists
                    //CLR 030228 add htmlspecialchars processing.  This handles quotes and other special chars in the user input.
                    $attr_value = NULL;
                    $blank_value = FALSE;
                    $is_attr_file = false;
                    $real_file = '';
                    if (strstr($option, TEXT_PREFIX)) {
                        if (trim($value) == NULL) {
                            $blank_value = TRUE;
                        } else {
                            $option = substr($option, strlen(TEXT_PREFIX));
                            $attr_value = stripslashes($value);
                            $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                            $this->contents[$products_id]['attributes_values'][$option] = $attr_value;
                        }
                    }
                    if (!$blank_value) {
                        if (is_array($value)) {
                            reset($value);
                            //file类型的属性
                            if (strpos($option, 'upload_prefix_') !== false) {
                                $option = substr($option, strlen('upload_prefix_'));
                                $attr_value = $value['products_options_value_text'];
                                $real_file = $value['upload_file'];
                                $this->contents[$products_id]['attributes_values'][$option] = $attr_value;
                                $this->contents[$products_id]['attributes_file'][$option] = $real_file;
                                $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                                $this->contents[$products_id]['attributes'][$option] = $value;
                                $is_attr_file = true;
                                $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
                                $insert_attribute_sql .= "(".(int)$_SESSION['customer_id'].", '".zen_db_input($products_id)."', '".(int)$option."', '".(int)$value."', 0, '".$attr_value."', '".$products_options_sort_order."',".$type." ,'".$real_file."'),";
                             }else{
                                //CheckBox类型的属性[option_id][value_id] = value_id
                                while (list($opt, $val) = each($value)) {
                                    $this->contents[$products_id]['attributes'][$option . '_chk' . $val] = $val;
                                    $columnID = 0;
                                    if ($this->columnID[$products_id][(int)$option][(int)$val]) {
                                        $columnID = $this->columnID[$products_id][(int)$option][(int)$val];
                                    }
                                    $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $val);
                                    $insert_attribute_sql .= "(".(int)$_SESSION['customer_id'].", '".zen_db_input($products_id)."', '".(int)$option.'_chk'.(int)$val."', '".(int)$val."', ".$columnID.", '".$attr_value."', '".$products_options_sort_order."',".$type." ,''),";
                                }
                            }
                        } else {
                            $this->contents[$products_id]['attributes'][$option] = $value;
                            if($option == 'length'){    //长度属性
                                $insert_length_sql = "insert  into customers_basket_length  (customers_id,products_id,length_name,product_length_id,save_type) values ('".(int)$_SESSION['customer_id']."','".zen_db_input($products_id)."','".$option."','".$value."',".$type.")";
                            }else{
                                $columnID = 0;
                                if ($this->columnID[$products_id][(int)$option][(int)$value]) {
                                    $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                }
                                $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
                                $insert_attribute_sql .= "(".(int)$_SESSION['customer_id'].", '".zen_db_input($products_id)."', '".(int)$option."', '".(int)$value."', ".$columnID.", '".$attr_value."', '".$products_options_sort_order."',".$type." ,''),";
                            }
                        }
                        // insert into database
                        //CLR 020606 update db insert to include attribute value_text. This is needed for text attributes.
                        //CLR 030228 add zen_db_input() processing
                        /* 注释于 2020.05.29 ery 将多条属性数据多次插入整合为一条SQL插入
                         * if (isset($_SESSION['customer_id'])) {
                            if (is_array($value) && !$is_attr_file) {
                                reset($value);
                                while (list($opt, $val) = each($value)) {
                                    $columnID = 0;
                                    if ($this->columnID[$products_id][(int)$option][(int)$val]) {
                                        $columnID = $this->columnID[$products_id][(int)$option][(int)$val];
                                    }
                                    $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $opt);
                                    $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                                  (customers_id, products_id, products_options_id, products_options_value_id,column_id, products_options_sort_order,save_type)
                                  values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" . (int)$option . '_chk' . (int)$val . "', '" . (int)$val . "'," . $columnID . ",  '" . $products_options_sort_order . "'," . $type . ")";

                                    $db->Execute($sql);
                                }
                            } elseif ($option == 'length') {
                                $sql = "insert  into customers_basket_length  (customers_id,products_id,length_name,product_length_id,save_type) values ('" . (int)$_SESSION['customer_id'] . "','" . zen_db_input($products_id) . "','$option','$value',".$type.")";
                                $db->query($sql);
                            } else {
                                if ($attr_value) {
                                    $attr_value = zen_db_input($attr_value);
                                }
                                $columnID = 0;
                                if ($this->columnID[$products_id][(int)$option][(int)$value]) {
                                    $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                }
                                $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
                                $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                                      (customers_id, products_id, products_options_id, products_options_value_id,column_id, products_options_value_text, products_options_sort_order,save_type,upload_file)
                                      values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
                                    (int)$option . "', '" . (int)$value . "'," . $columnID . ", '" . $attr_value . "', '" . $products_options_sort_order . "'," . $type . " ,'".$real_file."')";
                                $db->Execute($sql);
                            }
                        }*/
                    }
                }
                $insert_attribute_sql = rtrim($insert_attribute_sql,',');
                //客户登录的情况下属性插入数据库
                if (isset($_SESSION['customer_id'])){
                    //插入属性项数据
                    if($insert_attribute_sql){
                        $db->Execute("INSERT INTO " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id,column_id, products_options_value_text, products_options_sort_order,save_type,upload_file) VALUES ".$insert_attribute_sql);
                    }
                    //插入长度属性数据
                    if($insert_length_sql){
                        $db->Execute($insert_length_sql);
                    }
                }
            }
        }
        $this->cleanup();

        // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
        $this->cartID = $this->generate_cart_id();
        $this->notify('NOTIFIER_CART_ADD_CART_END');
    }

    /**
     * Method to update a cart items quantity
     *
     * Changes the current quantity of a certain item in the cart to
     * a new value. Also updates the database stored cart if customer is
     * logged in.
     *
     * @param mixed product ID of item to update
     * @param decimal the quantity to update the item to
     * @param array product atributes attached to the item
     * @return void
     * @global object access to the db object
     */
    function update_quantity($products_id, $quantity = '', $attributes = '',$type=0)
    {
        global $db;

        $this->notify('NOTIFIER_CART_UPDATE_QUANTITY_START');
        if (empty($quantity)) return true; // nothing needs to be updated if theres no quantity, so we return true..

        //reorder 的quotation 产品不准修改数量
        if (isset($this->contents[$products_id]['reoder_type']) && $this->contents[$products_id]['reoder_type'] == 'quotation'){return true;}

        $fiber_count = isset($this->contents[$products_id]['fiber_count']) ? $this->contents[$products_id]['fiber_count'] : "";
        //更新产品数量
        $this->contents[$products_id]['qty'] = (float)$quantity;
        $this->contents[$products_id]['fiber_count'] = $fiber_count;
        // update database
        if (isset($_SESSION['customer_id'])) {
            $sql = "update " . TABLE_CUSTOMERS_BASKET . "
                set customers_basket_quantity = '" . (float)$quantity . "'
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                and products_id = '" . zen_db_input($products_id) . "' and save_type=$type";
            $db->Execute($sql);
        }

        /*该函数用来更新 已经加入购物车产品的数量 定制产品的属性完全一致生成的加密产品ID才会一样  不需要更新属性数据
         * Ery 注释于 2019.7.8
         * if (is_array($attributes)) {
            reset($attributes);
            while (list($option, $value) = each($attributes)) {
                //CLR 020606 check if input was from text box.  If so, store additional attribute information
                //CLR 030108 check if text input is blank, if so do not update attribute lists
                //CLR 030228 add htmlspecialchars processing.  This handles quotes and other special chars in the user input.
                $attr_value = NULL;
                $blank_value = FALSE;
                if (strstr($option, TEXT_PREFIX)) {
                    if (trim($value) == NULL) {
                        $blank_value = TRUE;
                    } else {
                        $option = substr($option, strlen(TEXT_PREFIX));
                        $attr_value = stripslashes($value);
                        $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                        $this->contents[$products_id]['attributes_values'][$option] = $attr_value;
                    }
                }

                if (!$blank_value) {
                    if (is_array($value)) {
                        reset($value);
                        while (list($opt, $val) = each($value)) {
                            $this->contents[$products_id]['attributes'][$option . '_chk' . $val] = $val;
                        }
                    } else {
                        $this->contents[$products_id]['attributes'][$option] = $value;
                    }
                    // update database
                    //CLR 020606 update db insert to include attribute value_text. This is needed for text attributes.
                    //CLR 030228 add zen_db_input() processing
                    //          if (zen_session_is_registered('customer_id')) zen_db_query("update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " set products_options_value_id = '" . (int)$value . "', products_options_value_text = '" . zen_db_input($attr_value) . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . zen_db_input($products_id) . "' and products_options_id = '" . (int)$option . "'");

                    if ($attr_value) {
                        $attr_value = zen_db_input($attr_value);
                    }
                    if (is_array($value)) {
                        reset($value);
                        while (list($opt, $val) = each($value)) {
                            $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $opt);
                            $sql = "update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                        set products_options_value_id = '" . (int)$val . "'
                        where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                        and products_id = '" . zen_db_input($products_id) . "'
                        and products_options_id = '" . (int)$option . '_chk' . (int)$val . "' and save_type=$type";

                            $db->Execute($sql);
                        }
                    } elseif ($option == 'length') {
                        if (isset($_SESSION['customer_id'])) {
                            $sql = "update customers_basket_length set product_length_id = '" . (int)$value . "' where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                        and products_id = '" . zen_db_input($products_id) . "' and save_type=$type";
                        }
                    } else {
                        if (isset($_SESSION['customer_id'])) {
                            $sql = "update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                        set products_options_value_id = '" . (int)$value . "', products_options_value_text = '" . $attr_value . "'
                        where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                        and products_id = '" . zen_db_input($products_id) . "'
                        and products_options_id = '" . (int)$option . "' and save_type=$type";

                            $db->Execute($sql);
                        }
                    }
                }
            }
        }*/
        $this->cartID = $this->generate_cart_id();
        $this->notify('NOTIFIER_CART_UPDATE_QUANTITY_END');
    }

    /**
     * Method to clean up carts contents
     *
     * For various reasons, the quantity of an item in the cart can
     * fall to zero. This method removes from the cart
     * all items that have reached this state. The database-stored cart
     * is also updated where necessary
     *
     * @return void
     * @global object access to the db object
     */
    function cleanup()
    {
        global $db;
        $this->notify('NOTIFIER_CART_CLEANUP_START');
        reset($this->contents);
        while (list($key,) = each($this->contents)) {
            if (!isset($this->contents[$key]['qty']) || $this->contents[$key]['qty'] <= 0) {
                unset($this->contents[$key]);
                // remove from database
                if (isset($_SESSION['customer_id'])) {
                    $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
                    where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                    and products_id = '" . $key . "'";

                    $db->Execute($sql);

                    $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                    where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                    and products_id = '" . $key . "'";

                    $db->Execute($sql);
                    $sql = "delete from customers_basket_length
                    where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                    and products_id = '" . $key . "'";

                    $db->Execute($sql);
                }
            }
        }
        $this->notify('NOTIFIER_CART_CLEANUP_END');

    }

    /**
     * @Notes:
     *
     * @param bool $is_checked
     * @return decimal|int
     * * Method to count total number of items in cart
     *
     * Note this is not just the number of distinct items in the cart,
     * but the number of items adjusted for the quantity of each item
     * in the cart, So we have had 2 items in the cart, one with a quantity
     * of 3 and the other with a quantity of 4 our total number of items
     * would be 7
     *
     * @return total number of items in cart
     */
    function count_contents($is_checked = false)
    {
        $this->notify('NOTIFIER_CART_COUNT_CONTENTS_START');
        $total_items = 0;
        if (is_array($this->contents)) {
            reset($this->contents);
            while (list($products_id,) = each($this->contents)) {
                if ($is_checked) {
                    if ($this->contents[$products_id]['is_checked']==1) {
                        $total_items += $this->get_quantity($products_id);
                    }
                } else {
                    $total_items += $this->get_quantity($products_id);
                }
            }
        }

        $this->notify('NOTIFIER_CART_COUNT_CONTENTS_END');
        return $total_items;
    }

    /**
     * Method to get the quantity of an item in the cart
     *
     * @param mixed product ID of item to check
     * @return decimal the quantity of the item
     */
    function get_quantity($products_id)
    {
        $this->notify('NOTIFIER_CART_GET_QUANTITY_START');
        if (isset($this->contents[$products_id])) {
            $this->notify('NOTIFIER_CART_GET_QUANTITY_END_QTY');
            return $this->contents[$products_id]['qty'];
        } else {
            $this->notify('NOTIFIER_CART_GET_QUANTITY_END_FALSE');
            return 0;
        }
    }

    /**
     * Method to check whether a product exists in the cart
     *
     * @param mixed product ID of item to check
     * @return boolean
     */
    function in_cart($products_id)
    {
        //  die($products_id);
        $this->notify('NOTIFIER_CART_IN_CART_START');
        if (isset($this->contents[$products_id])) {
            $this->notify('NOTIFIER_CART_IN_CART_END_TRUE');
            return true;
        } else {
            $this->notify('NOTIFIER_CART_IN_CART_END_FALSE');
            return false;
        }
    }

    /**
     * Method to remove an item from the cart
     *
     * @param mixed product ID of item to remove
     * @return void
     * @global object access to the db object
     */
    function remove($products_id,$type=0)
    {
        global $db;

        $this->notify('NOTIFIER_CART_REMOVE_START');
        //die($products_id);
        //CLR 030228 add call zen_get_uprid to correctly format product ids containing quotes
        //      $products_id = zen_get_uprid($products_id, $attributes);

        //删除reorder  相关的信息
        $this->remove_reorder_products($products_id);

        unset($this->contents[$products_id]);
        // remove from database
        if ($_SESSION['customer_id']) {

            //        zen_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . zen_db_input($products_id) . "'");

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                and products_id = '" . zen_db_input($products_id) . "'  and save_type=$type";

            $db->Execute($sql);

            //        zen_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "' and products_id = '" . zen_db_input($products_id) . "'");

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                and products_id = '" . zen_db_input($products_id) . "'  and save_type=$type";

            $db->Execute($sql);
            $sql = "delete from customers_basket_length
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                and products_id = '" . zen_db_input($products_id) . "'  and save_type=$type";

            $db->Execute($sql);

        }
        // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
        $this->cartID = $this->generate_cart_id();
        $this->notify('NOTIFIER_CART_REMOVE_END');
    }

    function remove_reorder_products($products_id)
    {
        global $db;
        if ($_SESSION['customer_id']) {
            if (isset($this->contents[$products_id]['reoder_type']) && in_array($this->contents[$products_id]['reoder_type'],array('quotation','order'))){
                $reoder_info = $this->contents[$products_id]['reoder_info'] ;

                $products_id_arr  = array() ;//需要删除reorder的产品id
                $quotation_id_all = array() ;//需要删除的整单的 quotation id 考虑不同的询盘重合的问题
                $quotation_id_one = array() ;//需要删除的可以单品购买 quotation id
                $order_id_one     = array() ;//需要删除的可以单品购买历史订单的id  历史订单全部都是可以单品购买

                foreach ($reoder_info as $r_val){
                    if ($r_val['reorder_type'] == '1' && $r_val['quotation_id'] && !in_array($r_val['quotation_id'],$quotation_id_all)){
                        $quotation_id_all[] = $r_val['quotation_id'] ;
                    }
                    if ($r_val['reorder_type'] == '2' && isset($r_val['quotation_id']) && $r_val['quotation_id'] && !in_array($r_val['quotation_id'],$quotation_id_one)){
                        $quotation_id_one[] = $r_val['quotation_id'] ;
                    }
                    if ($r_val['reorder_type'] == '2' && isset($r_val['orders_id']) && $r_val['orders_id'] && !in_array($r_val['orders_id'],$order_id_one)){
                        $order_id_one[] = $r_val['orders_id'] ;
                    }
                }

                if (sizeof($order_id_one)){
                    $sql = "DELETE FROM ".TABLE_CUSTOMERS_BASKET_REORDER_ORDER." 
                            WHERE `customers_id` = '" . $_SESSION['customer_id'] . "' 
                            AND `orders_id` IN (".join(',',$order_id_one).") AND `products_id` = '".$products_id."'";
                    $db->Execute($sql);
                }

                if (sizeof($quotation_id_one)){
                    $sql = "DELETE FROM ".TABLE_CUSTOMERS_BASKET_REORDER_QUOTATION." 
                            WHERE `customers_id` = '" . $_SESSION['customer_id'] . "' 
                            AND `quotation_id` IN (".join(',',$quotation_id_one).") AND `products_id` = '".$products_id."'";
                    $db->Execute($sql);
                }

                //删除整单购买
                if (sizeof($quotation_id_all)){
                    $products_id_arr = $db->getAll("SELECT `products_id` FROM ".TABLE_CUSTOMERS_BASKET_REORDER_QUOTATION." 
                                                    WHERE `customers_id` = '" . $_SESSION['customer_id'] . "' 
                                                    AND `quotation_id` IN (".join(',',$quotation_id_all).")");

                    //如果删除了整单购买的产品 则给相应的提示
                    if (sizeof($products_id_arr) > 1){$_SESSION['unset_quotation'] = sizeof($products_id_arr);}

                    foreach ($products_id_arr as $p_id){
                        if (isset($this->contents[$p_id['products_id']]['reoder_type'])){
                            unset($this->contents[$p_id['products_id']]['reoder_type']);
                            unset($this->contents[$p_id['products_id']]['reoder_price']);
                            unset($this->contents[$p_id['products_id']]['reoder_info']);
                        }
                    }
                    $sql = "DELETE FROM ".TABLE_CUSTOMERS_BASKET_REORDER_QUOTATION." 
                            WHERE `customers_id` = '" . $_SESSION['customer_id'] . "' 
                            AND `quotation_id` IN (".join(',',$quotation_id_all).")";
                    $db->Execute($sql);
                }
            }
        }
    }

    /**
     * Method remove all products from the cart
     * @param array $products_ids
     * @param $type  删除的购物车数据类型 默认0 购物车产品 ，1是save for later产品
     */
    function remove_all($products_ids, $type=0)
    {
        $this->notify('NOTIFIER_CART_REMOVE_ALL_START');
        /**
         * delete database of table TABLE_CUSTOMERS_BASKET,TABLE_CUSTOMERS_BASKET_ATTRIBUTES,customers_basket_length
         */
        if (is_array($products_ids) && ($size = sizeof($products_ids))) {
            if (1 == $size) {
                $this->remove($products_ids[0], $type);
                $_SESSION['unset_id'] = $products_ids[0];
            } else {
                foreach ($products_ids as $value => $pID) {
                    $this->remove($pID, $type);
                    $_SESSION['unset_id'] = $pID;
                }
            }
        }
        $this->notify('NOTIFIER_CART_REMOVE_ALL_END');
    }

    /**
     * Method return a comma separated list of all products in the cart
     *
     * @return string
     * @todo ICW - is this actually used anywhere?
     */
    function get_product_id_list()
    {
        $product_id_list = '';
        if (is_array($this->contents)) {
            reset($this->contents);
            while (list($products_id,) = each($this->contents)) {
                $product_id_list .= ', ' . zen_db_input($products_id);
            }
        }
        return substr($product_id_list, 2);
    }

    /**
     * Method to calculate cart totals(price and weight)
     *
     * @return void
     * @global object access to the db object
     */
    function calculate()
    {
        global $db, $currencies;
        $this->total = 0;
        $this->level_total = 0;
        $this->weight = 0;

        // shipping adjustment
        $this->free_shipping_item = 0;
        $this->free_shipping_price = 0;
        $this->free_shipping_weight = 0;

        if (!is_array($this->contents)) return 0;
        //$wholesale_products = fs_get_wholesale_products_array();
        reset($this->contents);
        while (list($products_id,) = each($this->contents)) {
            $qty = $this->contents[$products_id]['qty'];

            // products price
            $product_query = "select products_id,integer_state,discount_price, products_price, products_tax_class_id, products_weight,products_priced_by_attribute, product_is_always_free_shipping, products_discount_type, products_discount_type_from,
                          products_virtual, products_model
                          from " . TABLE_PRODUCTS . "
                          where products_id = '" . (int)$products_id . "'";

            if ($product = $db->Execute($product_query)) {
                $prid = $product->fields['products_id'];
                $products_tax = zen_get_tax_rate($product->fields['products_tax_class_id']);
                $products_price = zen_get_products_base_price_other($product->fields['products_price']);

                if (($product->fields['product_is_always_free_shipping'] != 1 and $product->fields['products_virtual'] != 1)) {
                    $products_weight = $product->fields['products_weight'];
                } else {
                    $products_weight = 0;
                }

                if (($product->fields['product_is_always_free_shipping'] == 1) or ($product->fields['products_virtual'] == 1) or (preg_match('/^GIFT/', addslashes($product->fields['products_model'])))) {
                    $this->free_shipping_item += $qty;
                    $this->free_shipping_price += zen_add_tax($products_price, $products_tax) * $qty;
                    $this->free_shipping_weight += ($qty * $product->fields['products_weight']);
                }

                $fiberstore_discount = new fiberstore_discount();

                //$currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
                $currencies_value = $currencies->currencies[$_SESSION['currency']]['value'];

                //$wholesale_products = fs_get_wholesale_products_array();

				if ($product->fields['integer_state']!=1) {
                    $products_price = get_products_all_currency_final_price($products_price * $currencies_value);
                } else {
                    $products_price = get_products_specail_currency_final_price($products_price * $currencies_value);
                }

                $products_packing_info = get_product_packing_conditions($product->fields['products_id']);
                if($products_packing_info && $_SESSION['member_level']<=1){
                    $discount = $products_packing_info['discount'];
                    $packing_quantity = $products_packing_info['packing_quantity'];
                    if($qty>=$packing_quantity){
                        $products_price =zen_round($products_price*$discount,2);
                    }
                }
                if (isset($_SESSION['member_level'])) {
                    if ($product->fields['discount_price'] > 0) {
                        $products_prices = $product->fields['discount_price'];
                    } else {
                        $products_prices = get_customers_products_level_price($products_price + $this->attributes_price($products_id) * $currencies_value,$_SESSION['member_level'],(int)$products_id);
                        $products_prices = $products_prices / $currencies_value;
                    }
                } else {
                    if ($product->fields['discount_price'] > 0) {
                        $products_prices = $product->fields['discount_price'];
                    } else {
                        $products_price  = get_customers_products_level_price($products_price + $this->attributes_price($products_id) * $currencies_value,'');
                        $products_prices = $products_price / $currencies_value;
                    }
                }

				//如果产品的报价 比产品的优化价低  那么使用产品的 报价 （报价购物车不会存在报价产品 ternence.qin 2019.12.23）
//                if (isset($this->contents[$products_id]['reoder_type']) && in_array($this->contents[$products_id]['reoder_type'],array('quotation','order'))
//                    && $this->contents[$products_id]['reoder_price'] > 0 && $products_prices > $this->contents[$products_id]['reoder_price']){
//                    $reoder_info_length = count($this->contents[$products_id]['reoder_info']);
//                    if($this->contents[$products_id]['reoder_type'] == 'order'){
//                        $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
//                    }elseif($this->contents[$products_id]['reoder_type'] == 'quotation'){
//                        $reoder_info_length = count($this->contents[$products_id]['reoder_info']);
//                        if($this->contents[$products_id]['qty'] >= $this->contents[$products_id]['reoder_info'][$reoder_info_length-1]['products_quantity']){
//                            $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
//                        }
//                    }
//                }

                $level_total = $products_price * $qty;

                $total = $products_prices * $qty;


                $this->total += $total;
                $this->level_total += $level_total / $currencies_value;

                //products weight
                $this->weight += $qty * ($products_weight+$this->attributes_weight($products_id));
				$this->weight += $qty * ($this->contents[$products_id]['fiber_count']['products_attributes_weight']);
            }

            $adjust_downloads = 0;
            if (isset($this->contents[$products_id]['attributes']['length'])) {
                $length_s = get_outer_jacket_length($this->contents[$products_id]['attributes']['length']);
            } else {
                $length_s = 1;
            }
            // attributes price
            if (isset($this->contents[$products_id]['attributes'])) {
                reset($this->contents[$products_id]['attributes']);
                /* 具体到下面这个循环导致速度很慢 */
                while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {

                    if ($option != 'length') {
                        $adjust_downloads++;

                        $attribute_price_query = "select price_prefix,products_attributes_id,attributes_discounted,options_values_price,options_id,
						attributes_price_words_free,attributes_price_letters_free,attributes_price_words,attributes_price_letters,products_attributes_weight, products_attributes_weight_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . "
                        where products_id = '" . (int)$prid . "'
                            and options_id = '" . (int)$option . "'
                            and options_values_id = '" . (int)$value . "'";

                        $attribute_price = $db->Execute($attribute_price_query);

                        $new_attributes_price = 0;
                        $discount_type_id = '';
                        $sale_maker_discount = '';

                        if ($attribute_price->fields['price_prefix'] == '-') {

                            if ($attribute_price->fields['attributes_discounted'] == '1') {
                                //$new_attributes_price = zen_get_discount_calc($product->fields['products_id'], $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                                $new_attributes_price = $attribute_price->fields['options_values_price'];
                                $this->level_total -= $qty * $new_attributes_price;
                            } else {
                                $this->level_total -= $qty * $attribute_price->fields['options_values_price'];
                            }
                        } else {

                            if ($attribute_price->fields['attributes_discounted'] == '1') {
                                //$new_attributes_price = zen_get_discount_calc($product->fields['products_id'], $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                                $new_attributes_price = $attribute_price->fields['options_values_price'];
                                $new_attributes_price = get_outer_jacket_options_values_price($option, $new_attributes_price, $length_s);
                                if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, $option, (int)$value, $length_s)) {
                                    $new_attributes_price1 = $re[0];
                                    if ($re[1] == '+') {
                                        $this->level_total += $qty * $new_attributes_price1;
                                    } else {
                                        $this->level_total -= $qty * $new_attributes_price1;
                                    }
                                } else {
                                    $this->level_total += $qty * $new_attributes_price;
                                }

                            } else {

                                $attribute_price->fields['options_values_price'] = get_outer_jacket_options_values_price($option, $attribute_price->fields['options_values_price'], $length_s);
                                if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, $option, (int)$value, $length_s)) {
                                    $new_attributes_price1 = $re[0];
                                    if ($re[1] == '+') {
                                        $this->level_total += $qty * $new_attributes_price1;
                                    } else {
                                        $this->level_total -= $qty * $new_attributes_price1;
                                    }

                                } else {
                                    $this->level_total += $qty * $attribute_price->fields['options_values_price'];
                                }
                            }
                        }


                        if (isset($this->contents[$products_id]['fiber_count']['option_id'])) {
                            if ($option == $this->contents[$products_id]['fiber_count']['option_id']) {
                                $this->level_total += $qty * ($this->contents[$products_id]['fiber_count']['options_values_price']);
                                //$this->weight += $qty * ($this->contents[$products_id]['fiber_count']['products_attributes_weight']);
                            }
                        }
						/*attribute weight  start*/
						if ($product->fields['product_is_always_free_shipping'] != 1) {
                            $new_attributes_weight = $attribute_price->fields['products_attributes_weight'];
                        } else {
                            $new_attributes_weight = 0;
                        }
                        // shipping adjustments for Attributes
                        if (($product->fields['product_is_always_free_shipping'] == 1) or ($product->fields['products_virtual'] == 1) or (preg_match('/^GIFT/', addslashes($product->fields['products_model'])))) {
                            if ($attribute_price->fields['products_attributes_weight_prefix'] == '-') {
                                $this->free_shipping_weight -= ($qty * $attribute_price->fields['products_attributes_weight']);
                            } else {
                                $this->free_shipping_weight += ($qty * $attribute_price->fields['products_attributes_weight']);
                            }
                        }
                        // + or blank adds
                        if ($attribute_price->fields['products_attributes_weight_prefix'] == '-') {
                            //$this->weight -= $qty * $new_attributes_weight;
                        } else {
                            //$this->weight += $qty * $new_attributes_weight;
                        }
						/*attribute weight  end*/
                    } else {
                        //length
                        $list = $db->getAll("select price_prefix,length_price,weight from products_length where id = '$value' and product_id = '" . (int)$products_id . "'");
                        if ($list) {
                            if ($list[0]['price_prefix'] == '+') {
                                //$this->level_total += $qty * get_discount_price($list[0]['length_price'], $qty, (int)$products_id);
                                $this->level_total += $qty * $list[0]['length_price'];
                                //$this->weight += $qty * $list[0]['weight'];
                            } elseif ($list[0]['price_prefix'] == '-') {
                                $this->level_total -= $qty * $list[0]['length_price'];
                                //$this->weight -= $qty * $list[0]['weight'];
                            }
                        }
                    }

                }

            } // attributes price
        }
    }

    function calculate_for_separate($pro)
    {
        global $db, $currencies;
        $this->total = 0;
        $this->level_total = 0;
        $this->weight = 0;
        $contents =  array();
        // shipping adjustment
        $this->free_shipping_item = 0;
        $this->free_shipping_price = 0;
        $this->free_shipping_weight = 0;

        if (!is_array($this->contents)) return 0;
        $wholesale_products = fs_get_wholesale_products_array();
        reset($this->contents);
        foreach($pro as $k=>$v){
            $contents[$k]=$this->contents[$k];
            $contents[$k]['qty'] = $v;
        }
        if (!is_array($contents)) return 0;
        reset($contents);
        while (list($products_id,) = each($contents)) {
            $qty = $contents[$products_id]['qty'];

            // products price
            $product_query = "select products_id,discount_price, products_price, products_tax_class_id, products_weight,
                          products_priced_by_attribute, product_is_always_free_shipping, products_discount_type, products_discount_type_from,
                          products_virtual, products_model
                          from " . TABLE_PRODUCTS . "
                          where products_id = '" . (int)$products_id . "'";

            if ($product = $db->Execute($product_query)) {
                $prid = $product->fields['products_id'];
                $products_tax = zen_get_tax_rate($product->fields['products_tax_class_id']);
                $products_price = $product->fields['products_price'];

                if (($product->fields['product_is_always_free_shipping'] != 1 and $product->fields['products_virtual'] != 1)) {
                    $products_weight = $product->fields['products_weight'];
                } else {
                    $products_weight = 0;
                }

                if (($product->fields['product_is_always_free_shipping'] == 1) or ($product->fields['products_virtual'] == 1) or (preg_match('/^GIFT/', addslashes($product->fields['products_model'])))) {
                    $this->free_shipping_item += $qty;
                    $this->free_shipping_price += zen_add_tax($products_price, $products_tax) * $qty;
                    $this->free_shipping_weight += ($qty * $product->fields['products_weight']);
                }

                $fiberstore_discount = new fiberstore_discount();

                $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);

                $wholesale_products = fs_get_wholesale_products_array();

                if (!in_array($products_id, $wholesale_products)) {
                    $products_price = get_products_all_currency_final_price($products_price * $currencies_value);
                } else {
                    $products_price = get_products_specail_currency_final_price($products_price * $currencies_value);
                }


                if (isset($_SESSION['member_level'])) {
                    if ($product->fields['discount_price'] > 0) {
                        $products_prices = $product->fields['discount_price'];
                    } else {
                        $products_prices = get_customers_products_level_price($products_price + $this->attributes_price($products_id) * $currencies_value,$_SESSION['member_level'],(int)$products_id);
                        $products_prices = $products_prices / $currencies_value;
                    }
                } else {
                    if ($product->fields['discount_price'] > 0) {
                        $products_prices = $product->fields['discount_price'];
                    } else {
                        $products_prices = $products_price / $currencies_value + $this->attributes_price($products_id);

                    }
                }



                $level_total = $products_price * $qty;
                $total = $products_prices * $qty;

                $this->total += $total;
                $this->level_total += $level_total / $currencies_value;

                // $this->total += zen_add_tax($products_price, $products_tax) * $qty;
                $this->weight += ($qty * $products_weight);
            }

            $adjust_downloads = 0;
            if (isset($contents[$products_id]['attributes']['length'])) {
                $length_s = get_outer_jacket_length($contents[$products_id]['attributes']['length']);
            } else {
                $length_s = 1;
            }
            // attributes price
            if (isset($contents[$products_id]['attributes'])) {
                reset($contents[$products_id]['attributes']);
                /* 具体到下面这个循环导致速度很慢 */
                while (list($option, $value) = each($contents[$products_id]['attributes'])) {

                    if ($option != 'length') {
                        $adjust_downloads++;

                        $attribute_price_query = "select price_prefix,products_attributes_id,attributes_discounted,options_values_price,options_id,
          attributes_price_words_free,attributes_price_letters_free,attributes_price_words,attributes_price_letters
                                      from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                      where products_id = '" . (int)$prid . "'
                                      and options_id = '" . (int)$option . "'
                                      and options_values_id = '" . (int)$value . "'";

                        $attribute_price = $db->Execute($attribute_price_query);

                        $new_attributes_price = 0;
                        $discount_type_id = '';
                        $sale_maker_discount = '';

                        if ($attribute_price->fields['price_prefix'] == '-') {

                            if ($attribute_price->fields['attributes_discounted'] == '1') {
                                //$new_attributes_price = zen_get_discount_calc($product->fields['products_id'], $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                                $new_attributes_price = $attribute_price->fields['options_values_price'];
                                $this->level_total -= $qty * $new_attributes_price;
                            } else {
                                $this->level_total -= $qty * $attribute_price->fields['options_values_price'];
                            }
                        } else {

                            if ($attribute_price->fields['attributes_discounted'] == '1') {
                                //$new_attributes_price = zen_get_discount_calc($product->fields['products_id'], $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                                $new_attributes_price = $attribute_price->fields['options_values_price'];
                                $new_attributes_price = get_outer_jacket_options_values_price($option, $new_attributes_price, $length_s);
                                if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, $option, (int)$value, $length_s)) {
                                    $new_attributes_price1 = $re[0];
                                    if ($re[1] == '+') {
                                        $this->level_total += $qty * $new_attributes_price1;
                                    } else {
                                        $this->level_total -= $qty * $new_attributes_price1;
                                    }
                                } else {
                                    $this->level_total += $qty * $new_attributes_price;
                                }

                            } else {

                                $attribute_price->fields['options_values_price'] = get_outer_jacket_options_values_price($option, $attribute_price->fields['options_values_price'], $length_s);
                                if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, $option, (int)$value, $length_s)) {
                                    $new_attributes_price1 = $re[0];
                                    if ($re[1] == '+') {
                                        $this->level_total += $qty * $new_attributes_price1;
                                    } else {
                                        $this->level_total -= $qty * $new_attributes_price1;
                                    }

                                } else {
                                    $this->level_total += $qty * $attribute_price->fields['options_values_price'];
                                }
                            }
                        }


                        if (isset($contents[$products_id]['fiber_count']['option_id'])) {
                            if ($option == $contents[$products_id]['fiber_count']['option_id']) {
                                $this->level_total += $qty * ($contents[$products_id]['fiber_count']['options_values_price']);
                                $this->weight += $qty * ($contents[$products_id]['fiber_count']['products_attributes_weight']);
                            }
                        }
                    } else {
                        //length
                        $list = $db->getAll("select price_prefix,length_price,weight from products_length where id = '$value' and product_id = '" . (int)$products_id . "'");
                        if ($list) {
                            if ($list[0]['price_prefix'] == '+') {
                                //$this->level_total += $qty * get_discount_price($list[0]['length_price'], $qty, (int)$products_id);
                                $this->level_total += $qty * $list[0]['length_price'];
                                $this->weight += $qty * $list[0]['weight'];
                            } elseif ($list[0]['price_prefix'] == '-') {
                                $this->level_total -= $qty * $list[0]['length_price'];
                                $this->weight -= $qty * $list[0]['weight'];
                            }
                        }
                    }

                }

            } // attributes price

            // attributes weight
            if (isset($contents[$products_id]['attributes'])) {
                reset($contents[$products_id]['attributes']);
                while (list($option, $value) = each($contents[$products_id]['attributes'])) {
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

                        // shipping adjustments for Attributes
                        if (($product->fields['product_is_always_free_shipping'] == 1) or ($product->fields['products_virtual'] == 1) or (preg_match('/^GIFT/', addslashes($product->fields['products_model'])))) {
                            if ($attribute_weight->fields['products_attributes_weight_prefix'] == '-') {
                                $this->free_shipping_weight -= ($qty * $attribute_weight->fields['products_attributes_weight']);
                            } else {
                                $this->free_shipping_weight += ($qty * $attribute_weight->fields['products_attributes_weight']);
                            }
                        }

                        // + or blank adds
                        if ($attribute_weight->fields['products_attributes_weight_prefix'] == '-') {
                            $this->weight -= $qty * $new_attributes_weight;
                        } else {
                            $this->weight += $qty * $new_attributes_weight;
                        }
                    }
                }
            } // attributes weight

        }
    }

    /**
     * 根据产品获取重量
     * @param $products
     * @return float|int
     */
    function get_order_weight($products)
    {
        global $db;
        if (!$products || !is_array($products)) {
            return 0;
        }
        $weight = 0;
        foreach ($products as $v) {
            $product_query = "select products_weight,product_is_always_free_shipping
                          from " . TABLE_PRODUCTS . "
                          where products_id = '" . (int)$v['id'] . "'";
            $qty = $v['quantity'];
            $product = $db->Execute($product_query);
            if (!$product->EOF) {
                if (($product->fields['product_is_always_free_shipping'] != 1 and $product->fields['products_virtual'] != 1)) {
                    $products_weight = $product->fields['products_weight'];
                } else {
                    $products_weight = 0;
                }
                $weight += $qty * ($products_weight + $this->attributes_weight((int)$v['id']));
                $weight += $qty * ($this->contents[(int)$v['id']]['fiber_count']['products_attributes_weight']);
            }
        }
        return $weight;
    }
    /**
     * Method to calculate price of attributes for a given item
     *
     * @param mixed the product ID of the item to check
     * @return decimal the pice of the items attributes
     * @global object access to the db object
     */
    function attributes_price($products_id)
    {
        global $db;
        $attributes_price = 0;
        $qty = $this->contents[$products_id]['qty'];
        $length = '';
        if (isset($this->contents[$products_id]['attributes']['length'])) {
            $length_s = get_outer_jacket_length($this->contents[$products_id]['attributes']['length'],$length);
            $this->custom_attr = $length_s;
        } else {
            $length_s = 1;
        }
        if (isset($this->contents[$products_id]['attributes'])) {
			//先重新验证一下层级属性产品的column_id数据是否正确start
			$column_id = zen_get_products_column_id($products_id);
			//如果当前产品有属性，判断其是否是层级属性产品
			if($column_id && !$this->columnIDCheck[$products_id]){
				//是层级属性产品，验证其对应的层级属性对应关系是否正确
                $id_column = $this->columnID[$products_id];
                if(!$id_column){
                    $attributes = get_real_ids_by_attribute($this->contents[$products_id]);
                    $id_column = get_products_columnID($attributes);
                }
                //返回正确的属性值对应的层级关系的column_id
				$id_column = get_value_right_column($column_id,$id_column);
				//如果客户已经登录则更新购物车属性表中的column_id数据
				if($_SESSION['customer_id'] && !empty($id_column)){
					foreach($id_column as $okey=>$vval){
						foreach($vval as $vid=>$cid){
							$db->Execute("update `customers_basket_attributes` set `column_id`=".(int)$cid." where `customers_id`={$_SESSION['customer_id']} and `products_id`='".$products_id."' and `products_options_id`='".(int)$okey."' and `products_options_value_id`=".(int)$vid);
						}
					}
				}
				$this->columnID[$products_id] = $id_column;
                $this->columnIDCheck[$products_id] = true;  //层级属性已经验证过，不用多次验证
			}
			//先重新验证一下层级属性产品的column_id数据是否正确end
            reset($this->contents[$products_id]['attributes']);
			$attributes_arr = $values_id = [];
			$fiberValue = 0; //存放芯数属性值id,方便计算线轴价格
            while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                if($option ==21) $fiberValue = $value; //根据客户选择的fiber count属性和长度 额外计算线轴加价
                if ($option != 'length') {
                    if($option !=341) { //线轴加价的属性价格额外计算
                        $column_id = 0;
                        if($this->columnID[$products_id][(int)$option][(int)$value]){
                            $column_id = $this->columnID[$products_id][(int)$option][(int)$value];
                        }
                        $attributes_arr[(int)$option][(int)$value] = $column_id;
                    }
                    //保存定制产品匹配标准产品的所有属性值id
                    $values_id[] = (int)$value;
                    /* 注释于2020.06.09 Ery  定制产品所有属性项价格计算统一放在循环外处理 整合为一条SQL查询检查数据库查询压力
                     * $attribute_price_query = "select price_prefix,products_attributes_id,attributes_discounted,options_values_price,options_id,attributes_price_words_free,attributes_price_letters_free,attributes_price_words,attributes_price_letters
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                    where products_id = '" . (int)$products_id . "'
                                    and options_id = '" . (int)$option . "'
                                    and options_values_id = '" . (int)$value . "'";

                    $attribute_price = $db->Execute($attribute_price_query);

                    $new_attributes_price = 0;
                    $discount_type_id = '';
                    $sale_maker_discount = '';

                    $new_attributes_price = $attribute_price->fields['options_values_price'];
                    //根据该属性项价格计算类型是(n-1)/n 米加价得到新的属性价格
                    $new_attributes_price = get_outer_jacket_options_values_price($option, $new_attributes_price, $length_s);
                    //计算层级属性价格
                    if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, (int)$option, (int)$value, $length_s)) {
                        $new_attributes_price1 = $re[0];
                        if ($re[1] == '+') {
                            $attributes_price += ($new_attributes_price1);
                        } else {
                            $attributes_price -= ($new_attributes_price1);
                        }
                    } else {
                        if ($attribute_price->fields['price_prefix'] == '-'){
                            $attributes_price -= ($new_attributes_price);
                        }else{
                            $attributes_price += ($new_attributes_price);
                        }
                    }*/

                    /* 以前的计算方法很多判断多没用 直接用上面的方法计算属性价格
                    if ($attribute_price->fields['price_prefix'] == '-') {
                        // calculate proper discount for attributes
                        if ($attribute_price->fields['attributes_discounted'] == '1') {
                            $discount_type_id = '';
                            $sale_maker_discount = '';
                            //$new_attributes_price = zen_get_discount_calc($products_id, $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                            $new_attributes_price = $attribute_price->fields['options_values_price'];
                            $attributes_price -= ($new_attributes_price);
                        } else {
                            $attributes_price -= $attribute_price->fields['options_values_price'];
                        }
                    } else {
                        if ($attribute_price->fields['attributes_discounted'] == '1') {
                            $discount_type_id = '';
                            $sale_maker_discount = '';
                            $new_attributes_price = $attribute_price->fields['options_values_price'];
                            //根据该属性项价格计算类型是(n-1)/n 米加价得到新的属性价格
                            $new_attributes_price = get_outer_jacket_options_values_price($option, $new_attributes_price, $length_s);
                            //计算层级属性价格
                            if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, (int)$option, (int)$value, $length_s)) {
                                $new_attributes_price1 = $re[0];
                                if ($re[1] == '+') {
                                    $attributes_price += ($new_attributes_price1);
                                } else {
                                    $attributes_price -= ($new_attributes_price1);
                                }
                            } else {
                                $attributes_price += ($new_attributes_price);
                            }
                        } else {

                             $new_attributes_price = get_outer_jacket_options_values_price($option, $attribute_price->fields['options_values_price'], $length_s);

                            if ($re = fs_attribute_column_option_value_price($products_id, $this->columnID, $option, (int)$value, $length_s)) {
                                $new_attributes_price1 = $re[0];
                                if ($re[1] == '+') {
                                    $attributes_price += ($new_attributes_price1);
                                } else {
                                    $attributes_price -= ($new_attributes_price1);
                                }
                            } else {
                                $attributes_price += ($new_attributes_price);
                            }
                        }
                    }*/

                    if (isset($this->contents[$products_id]['fiber_count']['option_id'])) {
                        if ($option == $this->contents[$products_id]['fiber_count']['option_id']) {
                            $attributes_price += $this->contents[$products_id]['fiber_count']['options_values_price'];
                        }
                    }
                } else {
                    //length
                    $priceArr = get_length_range_price($products_id,$length,$fiberValue);
                    $attributes_price += $priceArr['length_price'];

//                    $list = $db->getAll("select price_prefix,length_price,weight from products_length where id = '$value' and product_id = '" . (int)$products_id . "'");
//                    if ($list) {
//                        if ($list[0]['price_prefix'] == '+') {
//                            //$attributes_price += get_discount_price($list[0]['length_price'], $qty, (int)$products_id);
//                            $attributes_price += $list[0]['length_price'];
//                        } elseif ($list[0]['price_prefix'] == '-') {
//                            $attributes_price -= $list[0]['length_price'];
//                        }
//                    }
                }
            }
            /**
             * 计算当前产品的所有属性项价格 一条SQL查当前产品所有的属性项加价数据
             */
            $option_value_price = get_products_all_attribute_price_new((int)$products_id, $attributes_arr, $length_s);
            $attributes_price += $option_value_price;
            //更新定制产品关联的关闭的标准产品的数据 2021.4.6  ery
            if(!isset($this->relatedStandardId[$products_id])){
                $class = new classes\custom\FsCustomRelate($products_id, $values_id, $length);
                $excellentMatch = $class->handle();
                if($excellentMatch[0]){
                    $this->relatedStandardId[$products_id] = $excellentMatch[0];
                }else{
                    $this->relatedStandardId[$products_id] = 0;
                }
            }
        }
        $attributes_price = zen_get_products_base_price_other($attributes_price);
        return $attributes_price;
    }

    /**
     * Method to calculate one time price of attributes for a given item
     *
     * @param mixed the product ID of the item to check
     * @param decimal item quantity
     * @return decimal the pice of the items attributes
     * @global object access to the db object
     */
    function attributes_price_onetime_charges($products_id, $qty)
    {
        global $db;
        $attributes_price_onetime = 0;
        /*  melo 注释，该函数不需要
        if (isset($this->contents[$products_id]['attributes'])) {

          reset($this->contents[$products_id]['attributes']);
          while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {

            $attribute_price_query = "select *
                                        from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                        where products_id = '" . (int)$products_id . "'
                                        and options_id = '" . (int)$option . "'
                                        and options_values_id = '" . (int)$value . "'";

            $attribute_price = $db->Execute($attribute_price_query);

            $new_attributes_price = 0;
            $discount_type_id = '';
            $sale_maker_discount = '';

            if ($attribute_price->fields['product_attribute_is_free'] == '1' and zen_get_products_price_is_free((int)$products_id)) {
            } else {
              $discount_type_id = '';
              $sale_maker_discount = '';
              $new_attributes_price = $attribute_price->fields['options_values_price'];

            }
          }
        }
        */
        return $attributes_price_onetime;
    }

    /**
     * Method to calculate weight of attributes for a given item
     *
     * @param mixed the product ID of the item to check
     * @return decimal the weight of the items attributes
     */
    function attributes_weight($products_id)
    {
        global $db;

        $attribute_weight = 0;
        $options_id = $values_id = $attributes = [];
        if (isset($this->contents[$products_id]['attributes'])) {
            reset($this->contents[$products_id]['attributes']);
            while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
				//长度属性的重量
				if($option=='length'){
					//如果长度区间重量[products_length_weight]数据存在就获取不同长度区间的加重数据
					$length = fs_get_data_from_db_fields('length','products_length','id='.(int)$value,'limit 1');
					if(get_products_length_weight_count((int)$products_id)){
                        $lengthWeight = zen_get_products_length_weight((int)$products_id, $length, $this->contents[$products_id]['attributes']);
					}else{
						//仍然查找之前的products_length重量记录
                        $lengthWeight = get_length_weight($value);
					}
                    $attribute_weight += $lengthWeight;
				}else{
                    $options_id[] = (int)$option;
                    $values_id[] = (int)$value;
                    $attributes[(int)$option][(int)$value] = 0;
					/* 注释于2020.06.09 Ery 定制产品多个属性循环查询加重调整为放在循环外一条SQL查询所有 减轻数据库查询压力
					 *$attribute_weight_query = "select products_attributes_weight, products_attributes_weight_prefix
										from " . TABLE_PRODUCTS_ATTRIBUTES . "
										where products_id = '" . (int)$products_id . "'
										and options_id = '" . (int)$option . "'
										and options_values_id = '" . (int)$value . "'";

					$attribute_weight_info = $db->Execute($attribute_weight_query);

					/*
					$product = $db->Execute("select products_id, product_is_always_free_shipping
									  from " . TABLE_PRODUCTS . "
									  where products_id = '" . (int)$products_id . "'");

					if ($product->fields['product_is_always_free_shipping'] != 1) {
					  $new_attributes_weight = $attribute_weight_info->fields['products_attributes_weight'];
					} else {
					  $new_attributes_weight = 0;
					}

					if ($attribute_weight_info->fields['products_attributes_weight_prefix'] == '-') {
						$attribute_weight -= $attribute_weight_info->fields['products_attributes_weight'];
					} else {
						$attribute_weight += $attribute_weight_info->fields['products_attributes_weight'];
					}*/
				}
            }
            // 一条SQL查所有属性项的重量
            $attribute_weight_new = get_products_all_attribute_weight_new((int)$products_id, $attributes);
            $attribute_weight += $attribute_weight_new;
        }

        return $attribute_weight;
    }

    /**
     * Remove the method of shopping cart individual products
     *
     * @The product is deleted whether or not it is logged in
     * @return 1
     */
    function remove_cart_product($customer_id, $product_id)
    {
        global $db;
        $this->remove($product_id);
        return '1';
//        if (!empty($product_id)) {
//            if (!empty($_SESSION['customer_id'])) {
//                $db->Execute("delete  from customers_basket where customers_id =" . $customer_id . " and products_id='{$product_id}'");
//            }
//            unset($_SESSION['cart']->contents[$product_id]);
//            return '1';
//        }
    }

    /**
     * Method to return details of all products in the cart
     *
     * @param boolean whether to check if cart contents are valid
     * @param boolean  //Saved for later（save_cart  初始化）  里边不需要检测quote
     * @param boolean  $is_tax_before 是否传税前价
     * @return array
     */
    function get_products($check_for_valid_cart = false,$need_check_quote = true,$is_tax_before = false)
    {
        global $db;
        global $currencies;
		$products_array = array();
        require_once(DIR_WS_CLASSES.'shipping_info.php');
        $this->notify('NOTIFIER_CART_GET_PRODUCTS_START');
        $country_code = strtoupper($_SESSION['countries_iso_code']);

        if (!is_array($this->contents)) return false;

        //如果需要排序 则重新给购物车产品排序
        if($this->is_need_order_by()){
            $this->products_order_by();
        }
        reset($this->contents);  //此步不能少  将指针指到数组头

        if ($need_check_quote){
            $this->get_reorder();
        }

        $warehouse_data = fs_products_warehouse_where();
        $warehouseStatus = $warehouse_data['code'].'_status';
        $fsCurrentInquiryField = 'is_'.$warehouse_data['code'].'_inquiry';

        while (list($products_id,) = each($this->contents)) {

            $products_query = "select p.products_id,p.discount_price,p.master_categories_id, p.products_status,p.products_model, p.products_image,
                                  p.products_price, p.products_weight, p.products_tax_class_id,p.show_type,".$warehouseStatus.",".$fsCurrentInquiryField.",
                                  p.products_quantity_order_min, p.products_quantity_order_units,
                                  p.product_is_free, p.products_priced_by_attribute,p.integer_state,
                                  p.products_discount_type, p.products_discount_type_from,p.products_weight_for_view,p.products_weight
                           from " . TABLE_PRODUCTS . " p
                           where p.products_id = '" . (int)$products_id . "'";
$usual_qty = $this->contents[$products_id]['qty'];

            if ($products = $db->Execute($products_query)) {

                if (QUANTITY_DECIMALS != 0) {
                    $fix_qty = $this->contents[$products_id]['qty'];
                    switch (true) {
                        case (!strstr($fix_qty, '.')):
                            $new_qty = $fix_qty;
                            break;
                        default:
                            $new_qty = preg_replace('/[0]+$/', '', $this->contents[$products_id]['qty']);
                            break;
                    }
                } else {
                    $new_qty = $this->contents[$products_id]['qty'];
                }
                /* 注释于2020.06.02 ery 此段代码和下面的代码重复
                 * $check_unit_decimals = zen_get_products_quantity_order_units((int)$products->fields['products_id']);
                if (strstr($check_unit_decimals, '.')) {
                    $new_qty = round($new_qty, QUANTITY_DECIMALS);
                } else {
                    $new_qty = round($new_qty, 0);
                }

                if ($new_qty == (int)$new_qty) {
                    $new_qty = (int)$new_qty;
                }*/
                $attr = $label_option_arr = [];
                if($this->contents[$products_id]['attributes']){
                    foreach ($this->contents[$products_id]['attributes']  as $key  =>  $val){
                        if($key!='length'){
                            $attr[] = $val;
                            $label_option_arr[] = (int)$key;
                        }else{
                            if((int)$val){
                                $attr['length'] = fs_get_data_from_db_fields('length', 'products_length', 'id='.(int)$val);
                            }
                        }
                    }
                }
                //清仓产品处理
                $clearance_qty = 0;
                $is_clearance = get_current_pid_if_is_clearance($products_id); //是否是清仓产品;
                $instockHtml = '';
                if($is_clearance){
                    $config['pid'] = $products_id;
                    $config['attr_option_arr'] = $attr;
                    $config['label_option'] = $label_option_arr;    //用于判断定制模块是否勾选label service属性
                    $shipping_info = new ShippingInfo($config);
                    $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存
                    if($new_qty>$clearance_qty && $clearance_qty){
                        //如果购物车中清仓产品的数量大于总库存数量，则改为最大数量
                        $this->update_quantity($products_id,(int)$clearance_qty);
                    }
                }
                //shipping_info类在购物车等相关页面实例化是，必须将已经选择的属性数据赋值过去，attr_option_arr和label_option
                $prid = $products->fields['products_id'];
                $wholesale_price = zen_get_products_base_price_other($products->fields['products_price']);
                $products_price = $wholesale_price;
                if ($check_for_valid_cart == true) {
                    $fix_once = 0;
                    $check_status = $products->fields['products_status'];
                    $warehouse_status = $products->fields[$warehouseStatus];
                    $inquiry_status = $products->fields[$fsCurrentInquiryField];
                    //2019.4.11 进入购物车时判断商品是否下架 pico
                    //2019.7.8  ery  关闭的赠品购物车页面要求正常展示
                    //Dylan 2019.10.2  无库存的清仓产品和下架产品展示一致
                    if ($check_status == 0 || $warehouse_status == 0 || $inquiry_status==1 || ($is_clearance && $clearance_qty==0 && $_GET['main_page']=='shopping_cart')) {
                        $fix_once++;
                        $_SESSION['valid_to_checkout'] = false;
                        $_SESSION['cart_errors'] .= ERROR_PRODUCT . $products->fields['products_name'] . ERROR_PRODUCT_STATUS_SHOPPING_CART . '<br />';
                        if ($_SESSION['customer_id']) {
                            //判断此商品是否已经存在于save for later
                            $products_off = $db->Execute("select customers_basket_quantity from customers_basket where customers_id={$_SESSION['customer_id']} and products_id='$products_id' and save_type =2");
                            if ($products_off->fields['customers_basket_quantity']){
                                $num = $products_off->fields['customers_basket_quantity']+$new_qty;
                                $db->Execute("update customers_basket set customers_basket_quantity='$num' where customers_id={$_SESSION['customer_id']} and products_id='$products_id' and save_type =2");
                            }else{
                                $db->Execute("update customers_basket set save_type= 2 where customers_id={$_SESSION['customer_id']} and products_id='$products_id'");
                                //判断是否为属性商品
                                $attr_products = explode(':',$products_id);
                                if ($attr_products[1]){
                                    $db->Execute("update customers_basket_attributes set save_type= 2 where customers_id={$_SESSION['customer_id']} and products_id='$products_id'");
                                    $products_length = $db->Execute("select id from customers_basket_length where customers_id={$_SESSION['customer_id']} and products_id='$products_id'");
                                    //判断商品是否有length这个属性
                                    if ($products_length->fields['id']){
                                        $db->Execute("update customers_basket_length set save_type= 2 where customers_id={$_SESSION['customer_id']} and products_id='$products_id'");
                                    }
                                }
                            }
                        }
                        $this->remove($products_id);  
                    }

                    // check only if valid products_status
                    if ($fix_once == 0) {
                        $check_quantity = $this->contents[$products_id]['qty'];
                        $check_quantity_min = $products->fields['products_quantity_order_min'];
                        // Check quantity min
                        if ($new_check_quantity = $this->in_cart_mixed($prid)) {
                            $check_quantity = $new_check_quantity;
                        }
                    }

                    if ($fix_once == 0) {
                        if ($check_quantity < $check_quantity_min) {
                            $fix_once++;
                            $_SESSION['valid_to_checkout'] = false;
                            $_SESSION['cart_errors'] .= ERROR_PRODUCT . $products->fields['products_name'] . ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART . ERROR_PRODUCT_QUANTITY_ORDERED . $check_quantity . ' <span class="alertBlack">' . zen_get_products_quantity_min_units_display((int)$prid, false, true) . '</span> ' . '<br />';
                        }
                    }

                    // Check Quantity Units if not already an error on Quantity Minimum
                    if ($fix_once == 0) {
                        $check_units = $products->fields['products_quantity_order_units'];
                        if (fmod_round($check_quantity, $check_units) != 0) {
                            $_SESSION['valid_to_checkout'] = false;
                            $_SESSION['cart_errors'] .= ERROR_PRODUCT . $products->fields['products_name'] . ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART . ERROR_PRODUCT_QUANTITY_ORDERED . $check_quantity . ' <span class="alertBlack">' . zen_get_products_quantity_min_units_display((int)$prid, false, true) . '</span> ' . '<br />';
                        }
                    }
                }

                if (QUANTITY_DECIMALS != 0) {
                    //          $new_qty = round($new_qty, QUANTITY_DECIMALS);

                    $fix_qty = $this->contents[$products_id]['qty'];
                    switch (true) {
                        case (!strstr($fix_qty, '.')):
                            $new_qty = $fix_qty;
                            break;
                        default:
                            $new_qty = preg_replace('/[0]+$/', '', $this->contents[$products_id]['qty']);
                            break;
                    }
                } else {
                    $new_qty = $this->contents[$products_id]['qty'];
                }
                //$check_unit_decimals = zen_get_products_quantity_order_units((int)$products->fields['products_id']);
                $check_unit_decimals = $products->fields['products_quantity_order_units'];
                if (strstr($check_unit_decimals, '.')) {
                    $new_qty = round($new_qty, QUANTITY_DECIMALS);
                } else {
                    $new_qty = round($new_qty, 0);
                }

                if ($new_qty == (int)$new_qty) {
                    $new_qty = (int)$new_qty;
                }
                //$discount_product = get_discount_product_qty($products_id);
                $discount_product = $products->fields['discount_price'];

                $currencies_value = $currencies->currencies[$_SESSION['currency']]['value'];

                // fairy 2019.2.21 add 组合产品主产品价格
                $is_composite_products = false;
                if (class_exists('classes\CompositeProducts')) {
                    //把属性值传进去  有属性的组合产品拿组合产品的价格
                    $attr_str = '';
                    if($this->contents[$products_id]['attributes']){
                        $attr_str = reorder_options_values($this->contents[$products_id]['attributes']);
                    }
                    $CompositeProducts = new classes\CompositeProducts(intval($products_id),'',$attr_str);

                    $composite_product_price = $CompositeProducts->get_composite_product_price(true,'',$is_tax_before);
                    if(!empty($composite_product_price['composite_product_price'])){
                        $is_composite_products = true;
                        $products_price_original = $composite_product_price['composite_product_price_original'];
                        $products_prices = $composite_product_price['composite_product_price'];
                        $products_price_start = $composite_product_price['composite_product_price'];
                    }

                    //如果产品的报价 比产品的优化价低  那么使用产品的 报价
                    if (isset($this->contents[$products_id]['reoder_type'])
                        && in_array($this->contents[$products_id]['reoder_type'],array('quotation','order'))
                        && $this->contents[$products_id]['reoder_price'] > 0)
                    {
                        if($this->contents[$products_id]['reoder_type'] == 'quotation' && $need_check_quote)
                        {
                            $reoder_info_length = count($this->contents[$products_id]['reoder_info']);
                            if($this->contents[$products_id]['qty'] >= $this->contents[$products_id]['reoder_info'][$reoder_info_length-1]['products_quantity']){
                                $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
                                $products_price_start = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
                            }
                        }
                    }



                }

                if(!$is_composite_products){ //如果不是组合产品

                    if ($products->fields['integer_state']!=1) {
                        //产品价格不取整
                        $products_price_start = get_products_all_currency_final_price($products_price);
                        $products_price = get_products_all_currency_final_price($products_price * $currencies_value);
                    } else {
                        $products_price_start = get_products_specail_currency_final_price($products_price);
                        $products_price = get_products_specail_currency_final_price($products_price * $currencies_value);
                    }
                    $products_packing_info = get_product_packing_conditions($products->fields['products_id']);
                    if($products_packing_info  && $_SESSION['member_level']<=1){
                        $discount = $products_packing_info['discount'];
                        $packing_quantity = $products_packing_info['packing_quantity'];
                        if($new_qty>=$packing_quantity){
                            $products_price = sprintf('%.2f',$products_price*$discount);
                            $products_price_start = sprintf('%.2f',$products_price_start*$discount);
                        }
                    }
                    $attributes_price = $this->attributes_price($products_id);
                    if (isset($_SESSION['member_level'])) {
                        $products_prices = get_customers_products_level_price($products_price + $attributes_price * $currencies_value, $_SESSION['member_level'],(int)$products_id);
                        $products_prices = $products_prices / $currencies_value;

                    } else {
                        $products_prices = $products_price / $currencies_value + $attributes_price;
                    }
                    //如果产品的报价 比产品的优化价低  那么使用产品的 报价
                    if (isset($this->contents[$products_id]['reoder_type'])
                        && in_array($this->contents[$products_id]['reoder_type'],array('quotation','order'))
                        && $this->contents[$products_id]['reoder_price'] > 0)
                    {
                        if($this->contents[$products_id]['reoder_type'] == 'order'){
                            $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
                        }elseif($this->contents[$products_id]['reoder_type'] == 'quotation' && $need_check_quote){
                            $reoder_info_length = count($this->contents[$products_id]['reoder_info']);
                            if($this->contents[$products_id]['qty'] >= $this->contents[$products_id]['reoder_info'][$reoder_info_length-1]['products_quantity']){
                                if($products_prices>=zen_get_products_base_price_other($this->contents[$products_id]['reoder_price'])){
                                    //当产品报价低于产品价格时才生效 add by ternence
                                    $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
                                }
                            }
                        }
                    }

                $products_price_original = $products_price / $currencies_value + $attributes_price;

                }
                //澳大利亚展示税后价
                $tax_after_price = $products_prices*1.1;
                if($country_code == 'AU' && !$is_tax_before && !$is_composite_products){
                    $products_prices = get_gsp_tax_price($country_code,$products_prices);
                    $products_price_original = get_gsp_tax_price($country_code,$products_price_original);
                }

                //对产品的最终单价 和 没有折扣前的原价 进行美元转对应币种 并保留小数位操作 这样可以避免出现转币种后的0.01误差
                $products_prices = get_one_products_currency_price($products_prices, $_SESSION['currency']);
                $products_price_original = get_one_products_currency_price($products_price_original, $_SESSION['currency']);
                $tax_after_price = get_one_products_currency_price($tax_after_price, $_SESSION['currency']);


				//前台展示给客户的重量
                if ($products->fields['products_weight_for_view']){
                    $view_weight = $products->fields['products_weight_for_view'];
                }else {
                    $view_weight = $products->fieldsfields['products_weight'];
                }
                $attribute_weight = $this->attributes_weight($products_id);
				$view_weight += $attribute_weight;
				if(isset($this->contents[$products_id]['fiber_count']['products_attributes_weight'])){
					$view_weight += $this->contents[$products_id]['fiber_count']['products_attributes_weight'];
				}
                $weight = $products->fields['products_weight'] + $attribute_weight;

                if($is_clearance){
                    if($products_price_original || $this->contents[$products_id]['attributes']){
                        $shipping_info->pure_price = $products_price_original;
                        $shipping_info->main_page = "shopping_cart";
                        $shipping_info->set_products_info($new_qty);
                        $instockHtml = $shipping_info->showIntockDate(false,1);
                    }
                }

                $products_array[] = array('id' => $products_id,
                    'category' => $products->fields['master_categories_id'],
                    'name' => zen_get_products_name($products_id),
                    'model' => $products->fields['products_model'],
                    'image' => $products->fields['products_image'],
                    'price' => ($products->fields['product_is_free'] == '1' ? 0 : $products_price_start),
                    'quantity' => $new_qty,
                    'usual_qty' => $usual_qty,
                    'weight' => $weight,
                    'view_weight' => $view_weight,
                    'products_price' => $products_price_original, //没有打折之前的价格，方便计算节省了多少钱
                    'final_price' => $products_prices,
                    'onetime_charges' => ($this->attributes_price_onetime_charges($products_id, $new_qty)),
                    'tax_class_id' => $products->fields['products_tax_class_id'],
                    'attributes' => (isset($this->contents[$products_id]['attributes']) ? $this->contents[$products_id]['attributes'] : []),
                    'fiber_count' => (isset($this->contents[$products_id]['fiber_count']) ? $this->contents[$products_id]['fiber_count'] : ''),
                    'attributes_values' => (isset($this->contents[$products_id]['attributes_values']) ? $this->contents[$products_id]['attributes_values'] : ''),
                    'products_priced_by_attribute' => $products->fields['products_priced_by_attribute'],
                    'product_is_free' => $products->fields['product_is_free'],
                    'products_discount_type' => $products->fields['products_discount_type'],
                    'products_discount_type_from' => $products->fields['products_discount_type_from'],
                    //（报价购物车不会存在报价产品 ternence.qin 2019.12.23）
//                    'reoder_type'  => (isset($this->contents[$products_id]['reoder_type'])  ? $this->contents[$products_id]['reoder_type'] : ''),
//                    'reoder_price' => (isset($this->contents[$products_id]['reoder_price']) ? $this->contents[$products_id]['reoder_price'] : 0.00),
//                    'reoder_info'  => (isset($this->contents[$products_id]['reoder_info'])  ? $this->contents[$products_id]['reoder_info'] : array()),
                    //文件
                    'attributes_file'  => (isset($this->contents[$products_id]['attributes_file'])  ? $this->contents[$products_id]['attributes_file'] : array()),
                    'show_type' => $products->fields['show_type'],
                    'products_status' => $products->fields['products_status'],   //保存产品状态 不需要多次查询数据库
                    'clearance_qty' => $clearance_qty, //清仓产品总库存
                    'is_clearance' => $is_clearance ? 1 : 0,    //是否是清仓产品
                    'instockHtml' => $instockHtml ? $instockHtml : "",
                    'relate_material_id' => $this->contents[$products_id]['relate_material_id'],
                    'relate_material_data' => (isset($this->contents[$products_id]['relate_material_data']) ? $this->contents[$products_id]['relate_material_data'] : []),
                    'orders_number' => $this->contents[$products_id]['orders_number'],  //保存的是产品在订单列表页加购的来源订单号
                    'tax_after_price' => $tax_after_price,
                    'is_checked' => (isset($this->contents[$products_id]['is_checked']) ? $this->contents[$products_id]['is_checked'] : 1), //默认为购买，购物车勾选为1，不勾选为0
                    'warehouseStatus' => $products->fields[$warehouseStatus], //对应仓库产品状态
                    'inquiryStatus' => $products->fields[$fsCurrentInquiryField], //对应仓库产品询价状态
                    'standardProductsId' => $this->relatedStandardId[$products_id] ? $this->relatedStandardId[$products_id] : 0  //定制产品关联的关闭的标准产品ID 用来获取库存数据
                );
            }
        }
        $this->notify('NOTIFIER_CART_GET_PRODUCTS_END');
        return array_reverse($products_array);
    }

    /**
     * @Notes: 购物车产品分类
     *
     * @param bool $check_for_valid_cart
     * @param bool $need_check_quote
     * @param bool $is_tax_before
     * @return array
     * @auther: Dylan
     * @Date: 2020/12/19
     * @Time: 11:19
     */
    function get_checked_products($check_for_valid_cart = false,$need_check_quote = true,$is_tax_before = false)
    {
        $checkedProducts = $unCheckedProducts = [];
        $products = $this->get_products($check_for_valid_cart, $need_check_quote, $is_tax_before);
        foreach ($products as $k => $products) {
            if ($products['is_checked'] == 1 && $products['products_status'] == 1) {
                $checkedProducts[] = $products;
            } else {
                $unCheckedProducts[] = $products;
            }
        }
        return [
            'checkedProducts' => $checkedProducts, //加购结算产品
            'unCheckedProducts' => $unCheckedProducts,  //加购未结算产品
            'allProducts' => $products //购物车内所有产品
        ];
    }

    //判断是否需要对购物车产品排序
    function is_need_order_by()
    {

        //对产品进行排序 询盘报价的产品和历史订单的产品  要放在前面
        $is_order_by = false ; //排序是否正确  如果正确 就不用排序  默认不用排序
        $is_order_qu = false ; //是否有 quotation  产品
        $is_order_or = false ; //是否有 order history  产品
        $is_order_pr = false ; //是否有正常加入购物车产品

        reset($this->contents);
        while (list($products_id,) = each($this->contents)) {
            if (!(isset($this->contents[$products_id]['reoder_type']) && in_array($this->contents[$products_id]['reoder_type'],array('quotation','order')))) {
                if ($is_order_or || $is_order_qu){
                    $is_order_by = true ;
                    break ;
                }else{
                    $is_order_pr = true ;
                }
            }else if (isset($this->contents[$products_id]['reoder_type']) && $this->contents[$products_id]['reoder_type'] == 'order') {
                if ($is_order_qu){
                    $is_order_by = true ;
                    break ;
                }else{
                    $is_order_or = true ;
                }
            }else if (isset($this->contents[$products_id]['reoder_type']) && $this->contents[$products_id]['reoder_type'] == 'quotation') {
                $is_order_qu = true ;
            }
        }
        return $is_order_by ;
    }

    //对购物车产品进行排序
    function products_order_by()
    {
        $this_contents = $this->contents;
        $this->contents = array();

        //order 购物车产品排在后
        foreach ($this_contents as $k=>$val){
            if (!(isset($val['reoder_type']) && in_array($val['reoder_type'],array('quotation','order')))) {
                $this->contents[$k] = $val;
            }
        }

        //order 产品排在中
        foreach ($this_contents as $k=>$val){
            if (isset($val['reoder_type']) && $val['reoder_type'] == 'order') {
                $this->contents[$k] = $val;
            }
        }

        //quotation 产品排在前
        foreach ($this_contents as $k=>$val){
            if (isset($val['reoder_type']) && $val['reoder_type'] == 'quotation') {
                $this->contents[$k] = $val;
            }
        }

    }

    /**
     * Method to calculate total price of items in cart
     *
     * @return decimal Total Price
     */
    function show_total()
    {
        $this->notify('NOTIFIER_CART_SHOW_TOTAL_START');
        $this->calculate();
        $this->notify('NOTIFIER_CART_SHOW_TOTAL_END');
        return $this->total;
    }

    /**
     * Method to calculate total weight of items in cart
     *
     * @return decimal Total Weight
     */
    function show_weight()
    {
        $this->calculate();
        return $this->weight;
    }

    /**
     * Method to generate a cart ID
     *
     * @param length of ID to generate
     * @return string cart ID
     */
    function generate_cart_id($length = 5)
    {
        return zen_create_random_value($length, 'digits');
    }

    /**
     * Method to calculate the content type of a cart
     *
     * @param boolean whether to test for Gift Vouchers only
     * @return string
     */
    function get_content_type($gv_only = 'false')
    {
        global $db;

        $this->content_type = false;
        $gift_voucher = 0;

        //      if ( (DOWNLOAD_ENABLED == 'true') && ($this->count_contents() > 0) ) {
        if ($this->count_contents() > 0) {
            reset($this->contents);
            while (list($products_id,) = each($this->contents)) {
                $free_ship_check = $db->Execute("select products_virtual, products_model, products_price, product_is_always_free_shipping from " . TABLE_PRODUCTS . " where products_id = '" . zen_get_prid($products_id) . "'");
                $virtual_check = false;
                if (preg_match('/^GIFT/', addslashes($free_ship_check->fields['products_model']))) {
                    $gift_voucher += ($free_ship_check->fields['products_price'] + $this->attributes_price($products_id)) * $this->contents[$products_id]['qty'];
                }
                // product_is_always_free_shipping = 2 is special requires shipping
                // Example: Product with download
                if (isset($this->contents[$products_id]['attributes']) and $free_ship_check->fields['product_is_always_free_shipping'] != 2) {
                    reset($this->contents[$products_id]['attributes']);
                } else {
                    switch ($this->content_type) {
                        case 'virtual':
                            if ($free_ship_check->fields['products_virtual'] == '1') {
                                $this->content_type = 'virtual';
                            } else {
                                $this->content_type = 'mixed';
                                if ($gv_only == 'true') {
                                    return $gift_voucher;
                                } else {
                                    return $this->content_type;
                                }
                            }
                            break;
                        case 'physical':
                            if ($free_ship_check->fields['products_virtual'] == '1') {
                                $this->content_type = 'mixed';
                                if ($gv_only == 'true') {
                                    return $gift_voucher;
                                } else {
                                    return $this->content_type;
                                }
                            } else {
                                $this->content_type = 'physical';
                            }
                            break;
                        default:
                            if ($free_ship_check->fields['products_virtual'] == '1') {
                                $this->content_type = 'virtual';
                            } else {
                                $this->content_type = 'physical';
                            }
                    }
                }
            }
        } else {
            $this->content_type = 'physical';
        }

        if ($gv_only == 'true') {
            return $gift_voucher;
        } else {
            return $this->content_type;
        }
    }

    /**
     * Method to unserialize a cart object
     *
     * @deprecated
     * @private
     */
    function unserialize($broken)
    {
        for (reset($broken); $kv = each($broken);) {
            $key = $kv['key'];
            if (gettype($this->$key) != "user function")
                $this->$key = $kv['value'];
        }
    }

    /**
     * Method to calculate item quantity, bounded the mixed/min units settings
     *
     * @param boolean product id of item to check
     * @return deciaml
     */
    function in_cart_mixed($products_id)
    {
        global $db;
        // if nothing is in cart return 0
        if (!is_array($this->contents)) return 0;

        // check if mixed is on
        //      $product = $db->Execute("select products_id, products_quantity_mixed from " . TABLE_PRODUCTS . " where products_id='" . (int)$products_id . "' limit 1");
        $product = $db->Execute("select products_id, products_quantity_mixed from " . TABLE_PRODUCTS . " where products_id='" . zen_get_prid($products_id) . "' limit 1");

        // if mixed attributes is off return qty for current attribute selection
        if ($product->fields['products_quantity_mixed'] == '0') {
            return $this->get_quantity($products_id);
        }

        // compute total quantity regardless of attributes
        $in_cart_mixed_qty = 0;
        $chk_products_id = zen_get_prid($products_id);

        // reset($this->contents); // breaks cart
        $check_contents = $this->contents;
        reset($check_contents);
        while (list($products_id,) = each($check_contents)) {
            $test_id = zen_get_prid($products_id);
            if ($test_id == $chk_products_id) {
                $in_cart_mixed_qty += $check_contents[$products_id]['qty'];
            }
        }
        return $in_cart_mixed_qty;
    }

    /**
     * Method to calculate item quantity, bounded the mixed/min units settings
     *
     * @param boolean product id of item to check
     * @return deciaml
     */
    function in_cart_mixed_discount_quantity($products_id)
    {
        global $db;
        // if nothing is in cart return 0
        if (!is_array($this->contents)) return 0;

        // check if mixed is on
        //      $product = $db->Execute("select products_id, products_mixed_discount_quantity from " . TABLE_PRODUCTS . " where products_id='" . (int)$products_id . "' limit 1");
        $product = $db->Execute("select products_id, products_mixed_discount_quantity from " . TABLE_PRODUCTS . " where products_id='" . zen_get_prid($products_id) . "' limit 1");

        // if mixed attributes is off return qty for current attribute selection
        if ($product->fields['products_mixed_discount_quantity'] == '0') {
            return $this->get_quantity($products_id);
        }

        // compute total quantity regardless of attributes
        $in_cart_mixed_qty_discount_quantity = 0;
        $chk_products_id = zen_get_prid($products_id);

        // reset($this->contents); // breaks cart
        $check_contents = $this->contents;
        reset($check_contents);
        while (list($products_id,) = each($check_contents)) {
            $test_id = zen_get_prid($products_id);
            if ($test_id == $chk_products_id) {
                $in_cart_mixed_qty_discount_quantity += $check_contents[$products_id]['qty'];
            }
        }
        return $in_cart_mixed_qty_discount_quantity;
    }

    /**
     * Method to calculate the number of items in a cart based on an abitrary property
     *
     * $check_what is the fieldname example: 'products_is_free'
     * $check_value is the value being tested for - default is 1
     * Syntax: $_SESSION['cart']->in_cart_check('product_is_free','1');
     *
     * @param string product field to check
     * @param mixed value to check for
     * @return integer number of items matching restraint
     */
    function in_cart_check($check_what, $check_value = '1')
    {
        global $db;
        // if nothing is in cart return 0
        if (!is_array($this->contents)) return 0;

        // compute total quantity for field
        $in_cart_check_qty = 0;

        reset($this->contents);
        while (list($products_id,) = each($this->contents)) {
            $testing_id = zen_get_prid($products_id);
            // check if field it true
            $product_check = $db->Execute("select " . $check_what . " as check_it from " . TABLE_PRODUCTS . " where products_id='" . $testing_id . "' limit 1");
            if ($product_check->fields['check_it'] == $check_value) {
                $in_cart_check_qty += $this->contents[$products_id]['qty'];
            }
        }
        return $in_cart_check_qty;
    }

    /**
     * Method to check whether cart contains only Gift Vouchers
     *
     * @return mixed value of Gift Vouchers in cart
     */
    function gv_only()
    {
        $gift_voucher = $this->get_content_type(true);
        return $gift_voucher;
    }

    /**
     * Method to return the number of free shipping items in the cart
     *
     * @return decimal
     */
    function free_shipping_items()
    {
        $this->calculate();
        return $this->free_shipping_item;
    }

    /**
     * Method to return the total price of free shipping items in the cart
     *
     * @return decimal
     */
    function free_shipping_prices()
    {
        $this->calculate();

        return $this->free_shipping_price;
    }

    /**
     * Method to return the total weight of free shipping items in the cart
     *
     * @return decimal
     */
    function free_shipping_weight()
    {
        $this->calculate();

        return $this->free_shipping_weight;
    }

    /**
     * Method to handle cart Action - update product
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionUpdateProduct($goto, $parameters)
    {
        global $messageStack, $db;

        for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++) {
            $adjust_max = 'false';
            if ($_POST['cart_quantity'][$i] == '') {
                $_POST['cart_quantity'][$i] = 0;
            }
            if (!is_numeric($_POST['cart_quantity'][$i]) || $_POST['cart_quantity'][$i] < 0) {
                $messageStack->add_session('header', ERROR_CORRECTIONS_HEADING . ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART . zen_get_products_name($_POST['products_id'][$i]) . ' ' . PRODUCTS_ORDER_QTY_TEXT . zen_output_string_protected($_POST['cart_quantity'][$i]), 'error');
                continue;
            }
            if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())) or $_POST['cart_quantity'][$i] == 0) {
                $this->remove($_POST['products_id'][$i]);
            } else {
                $add_max = zen_get_products_quantity_order_max($_POST['products_id'][$i]);
                $cart_qty = $this->in_cart_mixed($_POST['products_id'][$i]);
                $new_qty = $_POST['cart_quantity'][$i];
                $sql = 'select is_min_order_qty as min_qty from products where products_id = ' . (int)$_POST['products_id'][$i];
                $result = $db->Execute($sql);
                $min_qty = $result->fields['min_qty'];
                if ((int)$new_qty < (int)$min_qty) {
                    $new_qty = $min_qty;
                }


//echo 'I SEE actionUpdateProduct: ' . $_POST['products_id'] . ' ' . $_POST['products_id'][$i] . '<br>';
                $new_qty = $this->adjust_quantity($new_qty, $_POST['products_id'][$i], 'shopping_cart');

//die('I see Update Cart: ' . $_POST['products_id'][$i] . ' add qty: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
                if (($add_max == 1 and $cart_qty == 1)) {
                    // do not add
                    $adjust_max = 'true';
                } else {
                    // adjust quantity if needed
                    if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                        $adjust_max = 'true';
                        $new_qty = $add_max - $cart_qty;
                    }

                    $attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';

                    if (isset($_POST['length'][$_POST['products_id'][$i]]) && $_POST['length'][$_POST['products_id'][$i]]) {
                        $attributes['length'] = $_POST['length'][$_POST['products_id'][$i]];
                    }
                    $this->add_cart($_POST['products_id'][$i], $new_qty, $attributes, false);
                }
                if ($adjust_max == 'true') {
//          $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' A: - ' . zen_get_products_name($_POST['products_id'][$i]), 'caution');
                    $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . zen_get_products_name($_POST['products_id'][$i]), 'caution');
                } else {
// display message if all is good and not on shopping_cart page
                    if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
                        $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
                    }
                }
            }
        }
        //zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }

    /*
     * 详情页定制标签产品上传附件的方法
     * @param string $file_name
     * */

    function upload_file($products_id,$files,$product_option){
        $file_data = array();
        require_once(DIR_WS_CLASSES.'uploads.php');
        $savepath = 'attributes/'.(int)$products_id;
        $fileFormat = array('application/postscript','application/octet-stream','png','jpg','jpeg','xlsx');
        $maxsize = 5*1024*1024; //上传文件大小限制
        $overwrite = 1; //0. no 1. yes
        $f = new Uploads($savepath, $fileFormat, $maxsize, $overwrite);
        if (!$f->run($files,1,1)){
            $file_error = $f->errmsg();
            $file_data['error'] = $file_error;
        }else{
            $info = $f->returnArray;
            if($info){
                foreach($info as $key=>$v){
                    $pic_name = strtolower(str_replace(' ', '-', $v['saveName']));
                    $saveName = $savepath.'/'.$pic_name;
                }
            }
            $upload_file = $saveName ? $saveName : '';
            if($upload_file){
                $origin_name = $_FILES[$files]['name'][$product_option];
                $file_data['products_options_value_text'] = $origin_name;
                $file_data['upload_file'] = $upload_file;
                $file_data['products_options_id'] = $product_option;
            }
        }
        return $file_data;
    }


    /*获取当前产品的标签产品   并加入购物车
     *
     * */
     function  add_custom_to_cart($products_id,$color_data= array(),$lable_product_quality=1){
         $related_label_pid = fs_get_data_from_db_fields('related_label_pid','products','products_id='.(int)$products_id,'limit 1');
         if((int)$related_label_pid){
             /*文件上传开始*/
             $name_arr = $_FILES['color']['name'];
             foreach ($name_arr as $key=>$value) {
                 $upload_prefix = $key;
             }
             if($_FILES['color']['name'][$upload_prefix]){
                 $file_data = $this->upload_file($related_label_pid,'color',$upload_prefix);
                 //错误信息
                 if($file_data['error'] || !$file_data){
                     $status = 0;
                     $error_info = $file_data['error'];
                     unset($file_data);
                 }else{
                     //文件信息储存至color属
                     $color_data['upload_prefix_'.$file_data['products_options_id']] = array(
                         'products_options_value_text' =>  $file_data['products_options_value_text'],
                         'upload_file' => $file_data['upload_file'],
                     );
                 }
             }
             /*上传文件结束*/
             $this->add_cart($related_label_pid,  $lable_product_quality, $color_data, true,'',0);
         }
     }
    /**
     * Method to handle cart Action - add product
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionAddProduct($goto, $parameters, $cn_local_qty='')
    {
        global $messageStack, $db;
        if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {
            // verify attributes and quantity first
            $the_list = '';
            $adjust_max = 'false';
            $id_option = array();
            $id_column = array();
            $file_data = array();
            $status = 1;
            $error_info = '';
            if (isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0) {
                foreach ($_POST['ids'] as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $v) {
                            $value_arr = explode('_', $v);
                            $id_option[$key][$value_arr[0]] = $value_arr[0];
                            $id_column[$key][$value_arr[0]] = $value_arr[1];
                        }
                    } else {
                        $value_arr = explode('_', $value);
                        $id_option[$key] = $value_arr[0];
                        if(!strstr($key, TEXT_PREFIX)){
                            //custom客户自定义填写内容不存在层级属性
                            $id_column[$key][$value_arr[0]] = $value_arr[1];
                        }
                    }
                }
                $_POST['id'] = $id_option;
            }

            if (isset($_POST['id'])) {
                foreach ($_POST['id'] as $key => $value) {
                    $check = zen_get_attributes_valid($_POST['products_id'], $key, $value);
                    if ($check == false) {
                        $the_list .= TEXT_ERROR_OPTION_FOR . '<span class="alertBlack">' . zen_options_name($key) . '</span>' . TEXT_INVALID_SELECTION . '<span class="alertBlack">' . (zen_values_name($value) == 'TEXT' ? TEXT_INVALID_USER_INPUT : zen_values_name($value)) . '</span>' . '<br />';
                    }
                }
            }

            // verify qty to add
//          $real_ids = $_POST['id'];
//die('I see Add to Cart: ' . $_POST['products_id'] . 'real id ' . zen_get_uprid($_POST['products_id'], $real_ids) . ' add qty: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
            $add_max = zen_get_products_quantity_order_max($_POST['products_id']);
            $cart_qty = $this->in_cart_mixed($_POST['products_id']);
            $new_qty = $_POST['cart_quantity'];
//            $sql = 'select is_min_order_qty as min_qty from products where products_id = ' . (int)$_POST['products_id'];
//            $result = $db->Execute($sql);
//            $min_qty = $result->fields['min_qty'];
//            if ((int)$new_qty < (int)$min_qty) {
//                $new_qty = $min_qty;
//            }

//echo 'I SEE actionAddProduct: ' . $_POST['products_id'] . '<br>';
            $new_qty = $this->adjust_quantity($new_qty, $_POST['products_id'], 'shopping_cart');

            if (($add_max == 1 and $cart_qty == 1)) {
                // do not add
                $new_qty = 0;
                $adjust_max = 'true';
            } else {
                // adjust quantity if needed
                if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                    $adjust_max = 'true';
                    $new_qty = $add_max - $cart_qty;
                }
            }
            if ((zen_get_products_quantity_order_max($_POST['products_id']) == 1 and $this->in_cart_mixed($_POST['products_id']) == 1)) {
                // do not add
            } else {
                // process normally
                // bof: set error message
                if ($the_list != '') {
                    $messageStack->add('product_info', ERROR_CORRECTIONS_HEADING . $the_list, 'caution');
//          $messageStack->add('header', 'REMOVE ME IN SHOPPING CART CLASS BEFORE RELEASE<br/><BR />' . ERROR_CORRECTIONS_HEADING . $the_list, 'error');
                } else {
                    // process normally
                    // iii 030813 added: File uploading: save uploaded files with unique file names
                    $real_ids = isset($_POST['id']) ? $_POST['id'] : [];
                    $length = isset($_POST['length']) ? $_POST['length'] : "";
                    $products_id = $_POST['products_id'];
                    /*文件上传开始*/
                    $name_arr = $_FILES['id']['name'];
                    if(sizeof($name_arr)){
                        foreach ($name_arr as $key=>$value) {
                            $upload_prefix = $key;
                        }
                    }
                    if($_FILES['id']['name'][$upload_prefix]){
                        $file_data = $this->upload_file($_POST['products_id'],'id',$upload_prefix);
                        //错误信息
                        if($file_data['error'] || !$file_data){
                            $status = 0;
                            $error_info = $file_data['error'];
                            unset($file_data);
                        }else{
                            //文件数据存放到real_ids中 给一个特殊的标记
                            $real_ids['upload_prefix_'.$file_data['products_options_id']] = array(
                                'products_options_value_text' =>  $file_data['products_options_value_text'],
                                'upload_file' => $file_data['upload_file'],
                            );

                        }
                    }
                    /*上传文件结束*/
                    //根据选中的属性去匹配标准产品
                    $attr = array();
                    $fiberCount = 0; //存放客户选择的芯数属性,方便计算线轴加价
                    if($real_ids){
                        reset($real_ids);
                        while (list($option, $value) = each($real_ids)) {
                            if (!strstr($option, TEXT_PREFIX)) {
                                if (is_array($value)) {
                                    reset($value);
                                    while (list($opt, $val) = each($value)) {
                                        if($opt== 21){
                                            $fiberCount = $val;
                                        }
                                        $attr[] = $val;
                                    }
                                } else {
                                    $attr[] = $value;
                                    if($option == 21){
                                        $fiberCount = $value;
                                    }
                                }
                            }
                        }
                    }

                    $attrArr = array();
                    $len = isset($_POST['attribute_length']) ? $_POST['attribute_length'] : "";
                    $real_len = $len;
                    if($real_len){  //选择的长度属性也计算长度价格，方便获取线轴属性
                        $attrArr = get_length_range_price($_POST['products_id'],$real_len,$fiberCount);
                        $len = $attrArr['length'];
                    }
                    if($len=='' && $length){
                        $len = fs_get_data_from_db_fields('length','products_length','id='.$length,'limit 1');
                    }
                    if($attrArr['is_show_spool'] !=1){
                        if(sizeof($real_ids)){
                            foreach ($real_ids as $key=>$value){
                                if(!is_array($value) && $key == 341){
                                    unset($real_ids[$key]);//不满足条件的spool属性不加购
                                }
                            }
                        }
                    }

                    $class = new FsCustomRelate($_POST['products_id'], $attr, $len);
                    $excellentMatch = $class->handle();
                    //判断是否是清仓产品 Jeremy 2019.12.06
                    $is_clearance = get_current_pid_if_is_clearance($excellentMatch[0]);
                    $excellentMatch = $is_clearance ? false : $excellentMatch;//定制产品匹配标准产品 不匹配清仓产品
                    $match_status = 0;
                    if($excellentMatch[0]){
                        $match_status = get_product_status($excellentMatch[0]);
                    }
                    if ($excellentMatch[0] && $match_status) {
                        //匹配到标准产品，直接将标准产品加入购物车
                        $_POST['products_id'] = $excellentMatch[0];
                        if(sizeof($real_ids)){
                            foreach($real_ids as $op=>$va){
                                if (strstr($op, TEXT_PREFIX)) {
                                    if(trim($va) == NULL){
                                        unset($real_ids[$op]);
                                    }
                                }else{
                                    unset($real_ids[$op]);
                                }
                            }
                        }
                        //$real_ids = '';
                        $id_column = array();
                    }else{
                        if (isset($_POST['custom_length']) && $_POST['custom_length']) {
                            if (isset($_POST['custom_length']) && is_numeric($_POST['custom_length']) && ($_POST['custom_length']) > 0) {
                                //$_POST['custom_length'] = round($_POST['custom_length'], 2);
                                $result = $db->getAll("select id from products_length where product_id = '" . $_POST['products_id'] . "' and length = '".$attrArr['length']."' limit 1");
                                if ($result) {
                                    $length = $result[0]['id'];
                                } else {
                                    if (attribute_type_count($real_ids)) {
                                        $_POST['custom_length'] = round($_POST['custom_length'], 2);
                                        $db->query("insert into products_length (length_price,price_prefix,weight,length,product_id,add_time,sign,custom) values ('0','+','0','" . trim($_POST['custom_length']) . "km','" . $_POST['products_id'] . "','" . date('Y-m-d H:i:s') . "','0','1')");
                                    } else {
                                        $db->query("insert into products_length (length_price,price_prefix,weight,length,product_id,add_time,sign,custom) values ('" . $attrArr['length_price'] . "','+','" . $attrArr['weight'] . "','" .$attrArr['length']. "','" . $_POST['products_id'] . "','" . date('Y-m-d H:i:s') . "','0','1')");
                                    }
                                    $length = $db->insert_ID();
                                }
                            }

                        }

                        if ($length) {
                            $real_ids['length'] = $length;
                        }

                    }

//                    $this->add_cart($_POST['products_id'], $this->get_quantity(zen_get_uprid($_POST['products_id'], $real_ids)) + ($new_qty), $real_ids, true, $id_column);
                   // add_cart 中对数量已经作了处理
                    $this->add_cart($_POST['products_id'], $new_qty, $real_ids, true, $id_column);
                    //若是定制光模块，选择了定制标签就把对应的标签产品也加入购物车
                    $color_data = $_POST['color'];
                    $lable_product_quality = $_POST['lable_product_quality'] ? (int)$_POST['lable_product_quality'] : 1;
                    if(sizeof($color_data) && !empty($color_data) && $color_data!="none"){
                        $this->add_custom_to_cart($products_id,$color_data,$lable_product_quality);
                    }
                    // iii 030813 end of changes.
                } // eof: set error message
            } // eof: quantity maximum = 1

            if ($adjust_max == 'true') {
//        $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' B: - ' . zen_get_products_name($_POST['products_id']), 'caution');
                $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . zen_get_products_name($_POST['products_id']), 'caution');
            }
        }
        if ($the_list == '') {
            // no errors
// display message if all is good and not on shopping_cart page
            if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
                $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
            }
            //zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
        } else {
            // errors - display popup message
        }
        if(isset($parameters) && $parameters==1){
            $no_customized_html="";
            if (($excellentMatch[0] && $match_status) || $cn_local_qty==1) {
                $no_customized_html = products_add_cart_new_popup(false);
            }
            require DIR_WS_CLASSES.'shopping_cart_help.php';
            $shopping_cart_help = new shopping_cart_help();
            $cart_items = $_SESSION['cart']->count_contents();

            $html=$shopping_cart_help->show_cart_products_block($cart_items);
            $products_id = zen_get_uprid($_POST['products_id'], $real_ids);
            $products_info = get_google_products_info($_POST['cart_quantity'],$products_id);
            exit(json_encode(array('html'=>$html,'no_customized_html'=>$no_customized_html,'products_info'=>$products_info,'currencyCode'=>$_SESSION['currency'],'status'=>$status,'error_info' =>$error_info)));
        }
    }

    function solutionAddProducts()
    {
        try {
//            $products = $this->solutionAddProductsDataCheck();solutionAddProductsDataCheck
            $site_body = $_POST['sitebody'];
            $sku_str = zen_db_prepare_input($_POST['sku']);
            $products = (new SolutionServices())->solutionAddProductsDataCheck($site_body, $sku_str);
            $pids = array_keys($products);
            $productService = new ProductService();
            $pbi = $productService->setField([
                'products_quantity_order_max',
                'products_quantity_mixed',
                'is_min_order_qty',
            ])->getProductsInfo($pids);
            $mixQtys = [];
            $isArray = is_array($this->contents);
            if ($isArray) {
                $check_contents = $this->contents;
                reset($check_contents);
                foreach ($check_contents as $pid => $content) {
                    $pid = (int)$pid;
                    if (isset($mixQtys[$pid])) {
                        $mixQtys[$pid] += $content['qty'];
                    } else {
                        $mixQtys[$pid] = $content['qty'];
                    }
                }
            }

            foreach ($pbi as $pb) {
                $pid = $pb->products_id;
                $cart = $pb->products_quantity_mixed;
                if (!$isArray) {
                    $cart = 0;
                } elseif ($cart == 0) {
                    $cart = $this->get_quantity($pid);
                } else {
                    $cart = isset($mixQtys[$pid]) ? $mixQtys[$pid] : 0;
                }
                $min = (int)$pb->is_min_order_qty;
                $max = $pb->products_quantity_order_max;
                if ($min == 1 && $max == 1) {
                    continue;
                }
                $new_qty = $this->adjust_quantity($products[$pid], $pid, 'shopping_cart');
                if (($new_qty + $cart > $max) and $max != 0) {
                    $new_qty = $max - $cart;
                }
                $this->add_cart($pid, $new_qty, '', true, [], 0, [], false);
            }
            require DIR_WS_CLASSES.'shopping_cart_help.php';
            $shopping_cart_help = new shopping_cart_help();
            $cart_items = $this->count_contents();
            $html=$shopping_cart_help->show_cart_products_block($cart_items);
            echo json_encode([
                'code'=>1,
                'count'=>$cart_items,
                'html'=>$html,
                'url'=>zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL')
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'code'=>0,
                'msg'=>$e->getMessage()
            ]);
        }
        exit();
    }

    /**
     * 方案批量加购检测前端传过来的数据是否有效,以及数据整理
     *
     * @return array
     * @throws Exception
     */
//    function solutionAddProductsDataCheck()
//    {
//        $solutionID = (int)$_POST['solution_id'];
//        $sites = $_POST['site'];
//        if (!is_array($sites) || empty($sites) || $solutionID <= 0) {
//            $this->solutionAddProductsDataCheckThrow();
//        }
//        $realSites = [];
//        foreach ($sites as $site) {
//            if (!isset($site['site_id'], $site['products']) || !is_array($site['products']) || empty($site['products'])) {
//                $this->solutionAddProductsDataCheckThrow();
//            }
//            $realSites['siteId'] = (int)$site['site_id'];
//            foreach ($site['products'] as $sp) {
//                if (!isset($sp['id'], $sp['nums'])) {
//                    $this->solutionAddProductsDataCheckThrow();
//                }
//                $id = (int)$sp['id'];
//                $nums = (int)$sp['nums'];
//                $len = strlen($id);
//                if ($id <= 0 || $nums <= 0 || $len < 5) {
//                    $this->solutionAddProductsDataCheckThrow();
//                }
//                $realSites['products'][] = [
//                    'id'   => $id,
//                    'nums' => $nums
//                ];
//            }
//        }
//
//        $allProducts = (new SolutionServices())->getSolutionAllSiteAndProducts($solutionID);
//        if (empty($allProducts)) {
//            $this->solutionAddProductsDataCheckThrow('The Solution_' . $solutionID . ' has been removed from the shelves.');
//        }
//        $siteIds = array_keys($allProducts);
//        $savedPids = [];
//        foreach ($realSites as $realSite) {
//            if (!in_array($realSite['siteId'], $siteIds)) {
//                $this->solutionAddProductsDataCheckThrow('The site_' . $realSite['siteId'] . ' has been removed from the shelves');
//            }
//            foreach ($realSite['products'] as $sp) {
//                if (!in_array($sp['id'], $allProducts[$realSite['siteId']])) {
//                    $this->solutionAddProductsDataCheckThrow('The product_' . $sp['id'] . ' has been removed from the shelves');
//                }
//                if (isset($savedPids[$sp['id']])) {
//                    $savedPids[$sp['id']] += $sp['nums'];
//                } else {
//                    $savedPids[$sp['id']] = $sp['nums'];
//                }
//            }
//        }
//        return $savedPids;
//    }


    /**
     * Method to handle cart Action - buy now
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionBuyNow($goto, $parameters)
    {
        global $messageStack;
        if (isset($_GET['products_id'])) {
            if (zen_has_product_attributes($_GET['products_id'])) {
                zen_redirect(zen_href_link(zen_get_info_page($_GET['products_id']), 'products_id=' . $_GET['products_id']));
            } else {
                $add_max = zen_get_products_quantity_order_max($_GET['products_id']);
                $cart_qty = $this->in_cart_mixed($_GET['products_id']);
                $new_qty = zen_get_buy_now_qty($_GET['products_id']);
//die('I see Buy Now Cart: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
                if (($add_max == 1 and $cart_qty == 1)) {
                    // do not add
                    $new_qty = 0;
                } else {
                    // adjust quantity if needed
                    if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                        $new_qty = $add_max - $cart_qty;
                    }
                }
                if ((zen_get_products_quantity_order_max($_GET['products_id']) == 1 and $this->in_cart_mixed($_GET['products_id']) == 1)) {
                    // do not add
                } else {
                    // check for min/max and add that value or 1
                    // $add_qty = zen_get_buy_now_qty($_GET['products_id']);
                    //                                    $_SESSION['cart']->add_cart($_GET['products_id'], $_SESSION['cart']->get_quantity($_GET['products_id'])+$add_qty);
                    $this->add_cart($_GET['products_id'], $this->get_quantity($_GET['products_id']) + $new_qty);
                }
            }
        }
// display message if all is good and not on shopping_cart page
        if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
            $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
        }
        if (is_array($parameters) && !in_array('products_id', $parameters) && !strpos($goto, 'reviews') > 5) $parameters[] = 'products_id';
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }

    /**
     * Method to handle cart Action - multiple add products
     *
     * @param string forward destination
     * @param url parameters
     * @todo change while loop to a foreach
     */
    function actionMultipleAddProduct($goto, $parameters)
    {
        global $messageStack;
        $addCount = 0;
        if (is_array($_POST['products_id']) && sizeof($_POST['products_id']) > 0) {
            while (list($key, $val) = each($_POST['products_id'])) {
                if ($val > 0) {
                    $adjust_max = false;
                    $prodId = preg_replace('/[^0-9a-f:.]/', '', $key);
                    $qty = $val;
                    $add_max = zen_get_products_quantity_order_max($prodId);
                    $cart_qty = $this->in_cart_mixed($prodId);
//        $new_qty = $qty;
//echo 'I SEE actionMultipleAddProduct: ' . $prodId . '<br>';
                    $new_qty = $this->adjust_quantity($qty, $prodId, 'shopping_cart');

                    if (($add_max == 1 and $cart_qty == 1)) {
                        // do not add
                        $adjust_max = 'true';
                    } else {
                        // adjust quantity if needed
                        if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                            $adjust_max = 'true';
                            $new_qty = $add_max - $cart_qty;
                        }
                        $this->add_cart($prodId, $this->get_quantity($prodId) + ($new_qty));
                        $addCount++;
                    }
                    if ($adjust_max == 'true') {
//            $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' C: - ' . zen_get_products_name($prodId), 'caution');
                        $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . zen_get_products_name($prodId), 'caution');
                    }
                }
            }
// display message if all is good and not on shopping_cart page
            if ($addCount && DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
                $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCTS, 'success');
            }
            zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
        }
    }


    /**
     * Method to handle cart Action - Customer Order
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionCustomerOrder($goto, $parameters)
    {
        global $zco_page;
        global $messageStack;
        if ($_SESSION['customer_id'] && isset($_GET['pid'])) {
            if (zen_has_product_attributes($_GET['pid'])) {
                zen_redirect(zen_href_link(zen_get_info_page($_GET['pid']), 'products_id=' . $_GET['pid']));
            } else {
                $this->add_cart($_GET['pid'], $this->get_quantity($_GET['pid']) + 1);
            }
        }
// display message if all is good and not on shopping_cart page
        if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
            $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
        }
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }

    /**
     * Method to handle cart Action - remove product
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionRemoveProduct($goto, $parameters)
    {
        if (isset($_GET['product_id']) && zen_not_null($_GET['product_id'])) $this->remove($_GET['product_id']);
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }

    /**
     * Method to handle cart Action - user action
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionCartUserAction($goto, $parameters)
    {
        $this->notify('NOTIFY_CART_USER_ACTION');
    }

    //delete all products ******************************************main_cart_actions.php
    function actionRemoveAllProduct($goto, $parameters)
    {
        if (isset($_POST['products']) && zen_not_null($_POST['products'])) {
            $this->remove_all($_POST['products']);
        }

        //2017 07 26 fly 此处有 bug  remove_all() 必须接受一个参数
        //else  $this->remove_all();

        //zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }


    /**
     * calculate quantity adjustments based on restrictions
     * USAGE:  $qty = $this->adjust_quantity($qty, (int)$products_id, 'shopping_cart');
     *
     * @param float $check_qty
     * @param int $products
     * @param string $message
     */
    function adjust_quantity($check_qty, $products, $stack = 'shopping_cart')
    {
        global $messageStack;
        if ($stack == '' || $stack == FALSE) $stack = 'shopping_cart';
        $old_quantity = $check_qty;
        if (QUANTITY_DECIMALS != 0) {
            //          $new_qty = round($new_qty, QUANTITY_DECIMALS);
            $fix_qty = $check_qty;
            switch (true) {
                case (!strstr($fix_qty, '.')):
                    $new_qty = $fix_qty;
//            $messageStack->add_session('shopping_cart', ERROR_QUANTITY_ADJUSTED . zen_get_products_name($products) . ' - ' . $old_quantity . ' => ' . $new_qty, 'caution');
                    break;
                default:
                    $new_qty = preg_replace('/[0]+$/', '', $check_qty);
//            $messageStack->add_session('shopping_cart', 'A: ' . ERROR_QUANTITY_ADJUSTED . zen_get_products_name($products) . ' - ' . $old_quantity . ' => ' . $new_qty, 'caution');
                    break;
            }
        } else {
            if ($check_qty != round($check_qty, QUANTITY_DECIMALS)) {
                $new_qty = round($check_qty, QUANTITY_DECIMALS);
                $messageStack->add_session($stack, ERROR_QUANTITY_ADJUSTED . zen_get_products_name($products) . ERROR_QUANTITY_CHANGED_FROM . $old_quantity . ERROR_QUANTITY_CHANGED_TO . $new_qty, 'caution');
            } else {
                $new_qty = $check_qty;
            }
        }
        return $new_qty;
    }
    //add by aron
    function AjaxUpdateProduct($goto, $parameters)
    {
        global $messageStack, $db;
        $isCheck = ($_GET['main_page']=='shopping_cart' || $_POST['is_check']) ? true : false;
        for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++) {
            $adjust_max = 'false';
            if ($_POST['cart_quantity'][$i] == '') {
                $_POST['cart_quantity'][$i] = 0;
            }
            if (!is_numeric($_POST['cart_quantity'][$i]) || $_POST['cart_quantity'][$i] < 0) {
                $messageStack->add_session('header', ERROR_CORRECTIONS_HEADING . ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART . zen_get_products_name($_POST['products_id'][$i]) . ' ' . PRODUCTS_ORDER_QTY_TEXT . zen_output_string_protected($_POST['cart_quantity'][$i]), 'error');
                continue;
            }
            if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())) or $_POST['cart_quantity'][$i] == 0) {
                $this->remove($_POST['products_id'][$i]);
            } else {
                //购物车勾选产品数据处理
                if (isset($_POST['is_check']) && is_array($_POST['is_check'])) {
                    $is_checked_ids = $is_unchecked_ids = [];
                    foreach ($_POST['products_id'] as $p_k => $p_v) {
                        if($_SESSION['customer_id']) {
                            if ($_POST['is_check'][$p_k]) { //勾选产品
                                $is_checked_ids[] = $_POST['products_id'][$p_k];
                            } else { //未勾选产品
                                $is_unchecked_ids[] = $_POST['products_id'][$p_k];
                            }
                        }
                        $this->contents[$_POST['products_id'][$p_k]]['is_checked'] = $_POST['is_check'][$p_k];
                    }
                    if ($_SESSION['customer_id']) {
                        if ($is_checked_ids) {
                            $db->Execute("update customers_basket set is_checked=1 where customers_id=".(int)$_SESSION['customer_id']." and save_type=0 and products_id in ('".join("','",$is_checked_ids)."')");
                        }
                        if ($is_unchecked_ids) {
                            $db->Execute("update customers_basket set is_checked=0 where customers_id=".(int)$_SESSION['customer_id']." and save_type=0 and products_id in ('".join("','",$is_unchecked_ids)."')");
                        }
                    }
                }
                $new_qty = $_POST['cart_quantity'][$i];
                $new_qty = $this->adjust_quantity($new_qty, $_POST['products_id'][$i], 'shopping_cart');
                $pid_len = strlen($_POST['products_id'][$i]);
                if($pid_len>5){
                    //有属性的定制产品，要判断session里的该产品是否过期，已过期则不能直接更新该产品的数量，否则属性会丢失
                    $all_products_id = array_keys($this->contents);
                    if(in_array($_POST['products_id'][$i],$all_products_id)){
                        $this->contents[$_POST['products_id'][$i]]['qty'] = $new_qty;
                    }else{
                        //session中的该产品已经过期，取cookie中该产品的数据
                        $cookie_cart = json_decode($_COOKIE['cart_products'],true);
                        $cookie_key = array_keys($cookie_cart);
                        if(in_array($_POST['products_id'][$i],$cookie_key)){
                            $attr = $cookie_cart[$_POST['products_id'][$i]];
                            $id_attr = $column_arr = array();
                            foreach($attr as $akey=>$aval){
                                $aval_arr = explode('_',$aval);
                                if(strstr($akey, '_chk')){
                                    //多选属性
                                    $id_attr[(int)$akey][$aval_arr[0]] = $aval_arr[0];
                                }else{
                                    $id_attr[$akey] = $aval_arr[0];
                                }
                                //是层级属性
                                if($aval_arr[1]){
                                    $column_arr[(int)$akey][$aval_arr[0]] = $aval_arr[1];
                                }
                            }
                            $_SESSION['cart']->add_cart($_POST['products_id'][$i], $new_qty, $id_attr, true, $column_arr);
                        }
                    }
                }else{
                    $this->contents[$_POST['products_id'][$i]]['qty'] = $new_qty;
                }
                if($_SESSION['customer_id']){
                    $db->Execute("update customers_basket set customers_basket_quantity=".$new_qty." where products_id='".$_POST['products_id'][$i]."' and customers_id=".$_SESSION['customer_id']." and save_type=0");
                }
                //判断购物车数量
                if($_SESSION['languages_code'] == 'ru'){
                    $item_str =get_russian_item_str($_SESSION['cart']->count_contents($isCheck));
                    $qty = $_SESSION['cart']->count_contents($isCheck)."  ".$item_str;
                }else{
                    if($_SESSION['cart']->count_contents($isCheck)>1){
                        $qty = $_SESSION['cart']->count_contents($isCheck)."  ".F_BODY_HEADER_ITEM_TWO;
                    }else{
                        $qty = $_SESSION['cart']->count_contents($isCheck)."  ".F_BODY_HEADER_ITEM;
                    }
                }

                //$total = $_SESSION['cart']->show_total();
                $off="";

                $shopping_total=$not_quote_origin_price= $not_quote_after_discount= 0;
                $currencies = new currencies();
                $currency = $_SESSION['currency'];
                $currency_value = $currencies->currencies[$currency]['value'];
                require_once DIR_WS_CLASSES.'order.php';
				require_once DIR_WS_CLASSES . 'order_total.php';
                $products = $_SESSION['cart']->get_products();
                $order = new order();
                $GLOBALS['order'] = $order;
				$order_total = new order_total();
				$total = $order_total->process();
                $prince_total = 0;
                $mark=0;
                $products_proce=0;
                $quantity = 1;
                $quotation=0;
                $quote_products_price = array();
                $other_quote_products_price = array();
                $ss = 0;  //用作数组的key
                $totalProductsPrice = 0;//产品总价
                //组合产品报价
                $CompositeProducts = new classes\CompositeProducts(intval($_POST['products_id'][$i]));
                $composite_discount_product_array = $CompositeProducts->show_products_composite($_POST['cart_quantity'][$i]);
                foreach ($products as $k=>$v){
                    if($_POST['products_id'][$i]==$v['id']){
                        //该产品的价格
                        $products_proce = $currencies->total_format_new($products[$k]['final_price'],true,$currency, $currency_value);
                        //获取产品原始价格
                        $before_discount_each = $currencies->total_format_new($products[$k]['products_price'],true,$currency, $currency_value);
                        $quantity = $products[$k]['quantity'];
                        if(isset($v['reoder_type']) && $v['reoder_type']=="quotation"){  //可以询价
                            $quotation=1;
                            $quote_products_price['quote_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, $currency, $currency_value);
                            $quote_products_price['quote_us_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, 'USD');
                        }else{  //不可以询价
                            $quotation=0;
                            $quote_products_price['quote_price'] = $currencies->total_format_new($v['products_price'], true, $currency, $currency_value);
                            $quote_products_price['quote_us_price'] = $v['products_price'];
                        }
                        $quote_products_price['initial_price'] = $currencies->display_price_rate(zen_round(($v['final_price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places'],2),0,1);
                        $quote_products_price['per_price'] = $quote_products_price['initial_price'].FS_PRODUCT_PRICE_EA;
                        $quote_products_price['quote_type']=0;
                        if(zen_round($v['final_price'])==zen_round($v['reoder_info'][0]['products_price'])){
                            $quote_products_price['quote_type']=1;
                        }
                    }else if (zen_not_null($_SESSION['cart']->contents[$_POST['products_id'][$i]]['all_ids']) && in_array($v['id'],$_SESSION['cart']->contents[$_POST['products_id'][$i]]['all_ids'])){
                        //该产品询价时其他产品的价格,整单时要跟着变
                        $other_quote_products_price[$ss]['id'] = $v['id'];
                        $other_quote_products_price[$ss]['products_proce'] = $currencies->total_format_new($products[$k]['final_price'],true,$currency, $currency_value) * $products[$k]['quantity'];
                        if(isset($v['reoder_type']) && $v['reoder_type']=="quotation"){  //可以询价
                            $other_quote_products_price[$ss]['quotation'] = 1;
                            $other_quote_products_price[$ss]['quote_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, $currency, $currency_value);
                            $other_quote_products_price[$ss]['quote_us_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, 'USD');
                        }else{  //不可以询价
                            $other_quote_products_price[$ss]['quotation'] = 0;
                            $other_quote_products_price[$ss]['quote_price'] = $currencies->total_format_new($v['products_price'], true, $currency, $currency_value);
                            $other_quote_products_price[$ss]['quote_us_price'] = $v['products_price'];
                        }
                        $other_quote_products_price[$ss]['initial_price']= $currencies->display_price_rate(zen_round(($v['final_price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places'],2),0,1);
                        $other_quote_products_price[$ss]['per_price'] = $other_quote_products_price[$ss]['initial_price'].' '.FS_PRODUCT_PRICE_EA;
                        $other_quote_products_price[$ss]['composite_product_price'] = $CompositeProducts->show_products_composite(0,$v['id']);  //这里传0不影响  因为对应的产品数量没变 不做计算
                        $quote_products_price[$ss]['quote_type']=0;
                        if(zen_round($v['final_price'])==zen_round($v['reoder_info'][0]['products_price'])){
                            $quote_products_price[$ss]['quote_type']=1;
                        }
                        $ss++;
                    }

                    //计算勾选的总价
                    if ($v['is_checked'] == 1) {
                        $shopping_total += $products[$k]['products_price']*$products[$k]['quantity'];
                        $is_bulk = $order->fs_is_bulk_fiber(array($v['id']));
                        if(!$is_bulk){
                            $prince_total += $products[$k]['products_price']*$products[$k]['quantity'];
                        }else{
                            $mark=1;
                        }


                        /* Yoyo 2019.06.14
                            企业用户的quote依然展示total saving
                            但是只是展示除去quote且有优惠的
                         */
                        if($products[$k]['reoder_type'] !='quotation'){
                            $not_quote_origin_price += $products[$k]['products_price']*$products[$k]['quantity'];
                            $not_quote_after_discount += $products[$k]['final_price'] * $products[$k]['quantity'];
                        }

                        $totalProductsPrice += $products[$k]['final_price'] * $products[$k]['quantity'];
                    }
                }

				$de_vat = 0;
				$vat_price = 0;	//税收的价格
				//$subtotal = 0;	//不加税收的纯产品总价格
				//de和de-en站展示税收后的总价格
                /*Yoyo 2019.06.12
                 *添加税后展示 uk(20%)，和au(10%)
                 * */
                $vat_info  = get_current_vat_by_languages_code();
                $has_vat = $vat_info[1];
                $de_vat = $vat_info[2];
                $vat_price = $currencies->total_format_new($totalProductsPrice*$de_vat, true, $currency, $currency_value);

                $subtotal = $currencies->total_format_new($totalProductsPrice, true, $currency, $currency_value);

                $total_new = $currencies->total_format_new($totalProductsPrice*(1+$de_vat), true, $currency, $currency_value);
                $shopping_total = $currencies->total_format_new($shopping_total, true, $currency, $currency_value);
                $not_quote_origin_price = $currencies->total_format_new($not_quote_origin_price, true, $currency, $currency_value);
                $not_quote_after_discount =  $currencies->total_format_new($not_quote_after_discount, true, $currency, $currency_value);
                $products_proce=$quantity*$products_proce;
                $before_discount_total = $quantity*$before_discount_each;
                if(($_SESSION['member_level']>1)){
                    $off =$currencies->fs_format($not_quote_origin_price-$not_quote_after_discount,false,$currency);
                }

                if($totalProductsPrice>0){
                    if($mark!=1){
                        $tax=$this->get_free_freight_information($totalProductsPrice);
                    }else{
                        $tax=2;
                    }
                }else{
                    $tax=1;
                }
                if ($adjust_max == 'true') {
                    echo json_encode(array("type"=>"error","msg"=> ERROR_MAXIMUM_QTY . zen_get_products_name($_POST['products_id'][$i])));
                } else {
                    //刷新头部购物车信息
                    //外部图标部分
                    // 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动顶部购物车结构
                    $cart_items = $_SESSION['cart']->count_contents();
                    require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                    $shopping_cart_help = new shopping_cart_help();
                    $html = $shopping_cart_help->show_cart_products_block($cart_items);
                    exit(json_encode(array(
                        "type"=>"success",
                        "quotation"=>$quotation,
                        "qty"=>$qty,
                        "off"=>$off,
                        "tax_prompt"=>$tax,
                        "html"=>$html,
                        "mark"=>$mark,
                        'total'=>$total_new,
                        'products_proce'=>$products_proce,
                        'vat_price'=>$vat_price,
                        'subtotal'=>$subtotal,
                        'shopping_total'=>$shopping_total,
                        "qty_only"=>$_SESSION['cart']->count_contents(),
                        'composite_product_price' => $composite_discount_product_array,
                        'quote_products_price' => $quote_products_price,
                        'other_quote_products_price' => $other_quote_products_price,
                        'before_discount_total'=>$before_discount_total
                    )));
                }
            }
        }
    }

    function AjaxUpdateSaveProduct($goto, $parameters)
    {
        global $messageStack, $db;

        for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++) {
            $adjust_max = 'false';
            if ($_POST['cart_quantity'][$i] == '') {
                $_POST['cart_quantity'][$i] = 0;
            }
            if (!is_numeric($_POST['cart_quantity'][$i]) || $_POST['cart_quantity'][$i] < 0) {
                $messageStack->add_session('header', ERROR_CORRECTIONS_HEADING . ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART . zen_get_products_name($_POST['products_id'][$i]) . ' ' . PRODUCTS_ORDER_QTY_TEXT . zen_output_string_protected($_POST['cart_quantity'][$i]), 'error');
                continue;
            }
            if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())) or $_POST['cart_quantity'][$i] == 0) {
                $this->remove($_POST['products_id'][$i],1);
            } else {
                $new_qty = $_POST['cart_quantity'][$i];
                $new_qty = $this->adjust_quantity($new_qty, $_POST['products_id'][$i], 'shopping_cart');
                $pid_len = strlen($_POST['products_id'][$i]);
                if($pid_len>5){
                    //有属性的定制产品，要判断session里的该产品是否过期，已过期则不能直接更新该产品的数量，否则属性会丢失
                    $all_products_id = array_keys($this->contents);
                    if(in_array($_POST['products_id'][$i],$all_products_id)){
                        $this->contents[$_POST['products_id'][$i]]['qty'] = $new_qty;
                    }else{
                        //session中的该产品已经过期，取cookie中该产品的数据
                        $cookie_cart = json_decode($_COOKIE['cart_products'],true);
                        $cookie_key = array_keys($cookie_cart);
                        if(in_array($_POST['products_id'][$i],$cookie_key)){
                            $attr = $cookie_cart[$_POST['products_id'][$i]];
                            $id_attr = $column_arr = array();
                            foreach($attr as $akey=>$aval){
                                $aval_arr = explode('_',$aval);
                                if(strstr($akey, '_chk')){
                                    //多选属性
                                    $id_attr[(int)$akey][$aval_arr[0]] = $aval_arr[0];
                                }else{
                                    $id_attr[$akey] = $aval_arr[0];
                                }
                                //是层级属性
                                if($aval_arr[1]){
                                    $column_arr[(int)$akey][$aval_arr[0]] = $aval_arr[1];
                                }
                            }
                            $_SESSION['save_cart']->add_cart($_POST['products_id'][$i], $new_qty, $id_attr, true, $column_arr,1);
                        }
                    }
                }else{
                    $this->contents[$_POST['products_id'][$i]]['qty'] = $new_qty;
                }
                if($_SESSION['customer_id']){
                    $db->Execute("update customers_basket set customers_basket_quantity=".$new_qty." where products_id='".$_POST['products_id'][$i]."' and customers_id=".$_SESSION['customer_id']." and save_type=1");
                }
                //判断购物车数量
                if($_SESSION['languages_code'] == 'ru'){
                    $item_str =get_russian_item_str($_SESSION['save_cart']->count_contents());
                    $qty = $_SESSION['save_cart']->count_contents();

                }else{
                    if($_SESSION['save_cart']->count_contents()>1){
                        $qty = $_SESSION['save_cart']->count_contents();
                        $item_str =F_BODY_HEADER_ITEM_TWO;
                    }else{
                        $qty = $_SESSION['save_cart']->count_contents();
                        $item_str =F_BODY_HEADER_ITEM;
                    }
                }

                //$total = $_SESSION['cart']->show_total();
                $products = $_SESSION['save_cart']->get_products();
                $shopping_total=0;
                $currencies = new currencies();
                $currency = $_SESSION['currency'];
                $currency_value = $currencies->currencies[$currency]['value'];
                require_once DIR_WS_CLASSES.'order.php';
                require_once DIR_WS_CLASSES . 'order_total.php';
                $order = new order();
                $GLOBALS['order'] = $order;
                $order_total = new order_total();
                $products_proce=0;
                $quantity = 1;


                //组合产品报价
                $CompositeProducts = new classes\CompositeProducts(intval($_POST['products_id'][$i]));
                $composite_discount_product_array = $CompositeProducts->show_products_composite($_POST['cart_quantity'][$i], '', '', 1);

                foreach ($products as $k=>$v){
                    if($_POST['products_id'][$i]==$v['id']){
                        //获取产品原始价格
                        $before_discount_each = $currencies->total_format_new($products[$k]['products_price'],true,$currency, $currency_value);
                        $products_proce = $currencies->total_format_new($products[$k]['final_price'],true,$currency, $currency_value);
                        $quantity = $products[$k]['quantity'];
                    }
                }
                $before_discount_total = $quantity*$before_discount_each;
                $products_proce=$quantity*$products_proce;

                if ($adjust_max == 'true') {
                    echo json_encode(array("type"=>"error","msg"=> ERROR_MAXIMUM_QTY . zen_get_products_name($_POST['products_id'][$i])));
                } else {

//                    echo json_encode(array("type"=>"success","qty"=>$qty,'products_proce'=>$products_proce,'iterm'=>$item_str,'before_discount_total'=>$before_discount_total));
                    echo json_encode(array(
                        "type" => "success",
                        "qty" => $qty,
                        'products_proce' => $products_proce,
                        'iterm' => $item_str,
                        'before_discount_total' => $before_discount_total,
                        'composite_product_price' => $composite_discount_product_array,
                    ));
                }
            }
        }
    }


    function get_free_freight_information($total){
        global $currencies;
        $tax="";
        $mark=0;
        if($total>0){
            $new_prompt =FS_NEW_SHIPPING_FREE;
            if(seattle_warehouse('country_code',$_SESSION['countries_code_21'])==false && german_warehouse('country_code',$_SESSION['countries_code_21'])==false  && other_eu_warehouse($_SESSION['countries_code_21'],'country_code')==false){
            }else{
                $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                //美加墨
                if(seattle_warehouse('country_code',$_SESSION['countries_code_21'])==true){
                    if($_SESSION['countries_iso_code'] == 'ca' && in_array($_SESSION['languages_code'],['en','fr']) && $_SESSION['currency'] == 'CAD'){
                        $total = $total*$currency_value;
                        if($total >= 105){
                            $mark=1;
                        }
                    }elseif($_SESSION['countries_iso_code'] == 'mx' && in_array($_SESSION['languages_code'],['en','mx']) && $_SESSION['currency'] == 'MXN'){
                        $total = $total*$currency_value;
                        if($total >= 1600){
                            $mark=1;
                        }
                    }else{
                        if($total>=79){
                            $mark=1;
                        }
                    }
                }
                if(german_warehouse('country_code',$_SESSION['countries_code_21'])==true){
                    //德国仓非英国
                    $currencies_value_de = zen_get_currencies_value_of_code("EUR");
                    if($_SESSION['countries_code_21']!="GB"){
                        if($total*$currencies_value_de>=79){
                            $mark=1;
                        }
                    }else{
                        //德国仓英国
                        $currencies_value_uk = zen_get_currencies_value_of_code("GBP");
                        if($total*$currencies_value_uk>=79){
                            $mark=1;
                        }
                    }
                }
                //var_dump($mark);
                if($mark==1){
                    $tax ='<span class="icon iconfont">&#xf214;</span>'.$new_prompt;
                }else{
                    $tax ='<span class="icon iconfont"></span>';
                }

            }
            if(!empty($new_prompt)){
                return $tax;
            }
        }
    }


    /**
     * add by quest 2019-03-30
     * 获取购物车组合产品信息
     *
     * @param $products_id //产品id
     * @param $is_tax //是否含税
     * @return string
     */
	function get_cart_quotation_combination($products_id, $main_qty = 0, $is_tax = false){

        $new_reorder_key = sizeof($this->contents[$products_id]['reoder_info']) - 1;
        $quotation_id = $this->contents[$products_id]['reoder_info'][$new_reorder_key]['quotation_id'];
        if(empty($quotation_id)){
            return '';
        }
        $composite_products = fs_get_data_from_db_fields_array(['quotation_combination','products_quantity'],'customers_basket_reorder_quotation','quotation_id = '.$quotation_id);
        $inquiry_qty = $composite_products[0][1];

        $composite_products_str = $_SESSION['cart']->contents[$products_id]['quotation_combination'];

        if(empty($composite_products_str)){   //因为订单会拆分  所以直接从原先的cart里边检测是否是可报价的组合产品  原先的数量检查去掉了
            return '';
        }
        $composite_products_str = $this->get_currency_combination_string($composite_products_str,$main_qty,$inquiry_qty, $is_tax);
        return $composite_products_str;
    }

    /**
     * add by quest 2019-04-01
     * 将组合产品价格转换成对应币种
     * @param $composite_products_ori_str 组合产品字段
     * @param $currency 货币类型
     * @param $is_array 返回结果是否为数组
     * @param $is_positive 正向转换(美元转其他货币)/反向转换(其他货币转美元)
     * @return string/array
     */
    function get_currency_combination_products($composite_products_ori_str,$currency,$is_array = false,$is_positive = false, $has_symbol = true,$main_qty = 0,$inquiry_qty = 0){
        global $currencies;

        $composite_products_str = '';
        $composite_products_array = array();

        $composite_array_one = explode(',',$composite_products_ori_str);
        foreach ($composite_array_one as $v){
            if(!empty($v)) {
                $composite_array_t = explode(':', $v);
                $composite_array_s = explode('-', $composite_array_t[1]);

                $products_son_id = $composite_array_t[0];
                $products_son_qty = $composite_array_s[0];

                if($main_qty != 0 && $inquiry_qty != 0){
                    $products_son_qty = $products_son_qty*$main_qty/$inquiry_qty;
                }

                if ($is_positive) {
                    if($has_symbol){
                        $products_son_price = $currencies->total_format($composite_array_s[1], true, $currency);
                    }else{
                        $products_son_price = $currencies->fs_format($composite_array_s[1], true, $currency);
                    }
                } else {
                    $products_son_price = $currencies->fs_format_for_usd($composite_array_s[1], true, $currency);
                }
                $products_son_price = str_replace(",","",$products_son_price);
                if ($is_array) {
                    $composite_products_array[$products_son_id] = array(
                        'products_price_str' => $products_son_price
                    );
                } else {
                    $composite_products_str .= $products_son_id . ':' . $products_son_qty . '-' . $products_son_price . ',';
                }
            }
        }

        if($is_array){
            return $composite_products_array;
        }else{
            return $composite_products_str;
        }

    }

    /**
     * add by rebirth 2019-04-18
     * 将议价子产品字符串转为要展示的币种数组  专用于议价
     *
     * @param $composite_products_ori_str
     * @return array
     */
    function get_currency_combination_array($composite_products_ori_str){
        global $currencies; // $currencies依托环境，转移到其他地方要注意
        $currency_type = $_SESSION['currency'];
        $currencies_value = $currencies->currencies[$currency_type]['value'];


        $composite_products_array = array();
        $composite_array_one = explode(',',$composite_products_ori_str);
        foreach ($composite_array_one as $v){
            if(!empty($v)) {
                $composite_array_t = explode(':', $v);
                $composite_array_s = explode('-', $composite_array_t[1]);

                $products_son_id = $composite_array_t[0];
                $products_son_qty = $composite_array_s[0];
                $products_son_price = str_replace(",","",$composite_array_s[1]);

                $product_price_currency = zen_get_products_base_price_other($products_son_price*$currencies_value);
                $product_price_currency = number_format(zen_round($product_price_currency, 2), 2, '.', '');//保留2位小数
                $products_price_str = $currencies->update_format($product_price_currency, false, $currency_type);

                $composite_products_array[$products_son_id] = array(
                    'products_id' => $composite_array_t[0],
                    'products_qty' => $products_son_qty,
                    'products_price' => $product_price_currency,
                    'products_price_str' => $products_price_str
                );
            }
        }

        return $composite_products_array;
    }

    /**
     * add by rebirth 2019-04-23
     * 专职将get_currency_combination_array的结果转成string格式   请勿用于其他地方
     *
     * @param $array  //get_currency_combination_array 的结果
     * @param $main_qty  //分单后实际购买的数量
     * @param $inquiry_qty  //quote时的数量
     * @param $is_tax  //是否含稅
     * @return string  // string格式
     */
    private function get_currency_combination_string($array,$main_qty,$inquiry_qty, $is_tax = false){
        $string = '';
        foreach ($array as $son_product){
            $products_son_qty = $son_product['products_qty'];
            if($main_qty != 0 && $inquiry_qty != 0){
                $products_son_qty = $products_son_qty*$main_qty/$inquiry_qty;
            }
            //子产品显示税后价
            $products_price = $is_tax ? get_gsp_tax_price(13,$son_product['products_price']) :
                $son_product['products_price'];
            $string .= $son_product['products_id'].':'.$products_son_qty.'-'.$products_price.',';
        }
        return $string;
    }

    /**
     * add by rebirth 2019-04-19
     * 对get_currency_combination_array的products_price 求和后的$price 反向转换为美元
     *
     * @param $price  //对get_currency_combination_array的products_price 后的结果
     * @param $currencies_value  //当前的汇率
     * @return float
     */
    function get_us_formate($price,$currencies_value){
        $currencies_value = zen_get_products_base_price_other($currencies_value);
        $us_price = $price / $currencies_value;
        return $us_price;
    }

}
