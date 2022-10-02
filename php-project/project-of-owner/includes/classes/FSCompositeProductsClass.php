<?php
namespace classes;

class CompositeProducts
{
    public static $products_id;   //  需要拆分的ID
    public static $db;
    public static $type;  //1,A=B+C;2,A=B+2C;3,A=B+C+D,4是根据字段composite_products来进行定义的
    public static $relatedArray;   //  拆分后的产品数组
    public static $orders_id;
    public static $combination_attr = ''; //组合产品的属性 如果有值  则根据传的属性值获取对应的子产品
    public $no_stock_id = [];    //保存type=4中组合产品中所有无库存的子产品
    public $cacheType = "";
    function __construct($products_id = 0, $orders_id = 0,$combination_attr ='')
    {
        global $db;
        self::$products_id = (int)$products_id;
        self::$db = $db;
        self::$orders_id = $orders_id;
        self::$combination_attr = $combination_attr;
        $this->no_stock_id = [];
        $this-> cacheType = sqlCacheType();
    }

    /**
     * 检查产品是否是组合产品  如果是记录到属性relatedArray
     *
     * @return bool
     */
    public function CompositeProductsRelated()
    {
        self::$type = 0;
        self::$relatedArray = array();
        if (self::$products_id) {
            //优先判断是否是组合属性产品
            $where = ' and products_options_value= ""';
            if(self::$combination_attr){
                $where = ' and products_options_value= "' . self::$combination_attr . '"';
            }
            $res = self::$db->Execute("select {$this->cacheType} products_id,composite_B,composite_C,composite_D,composite_E,`type`,`composite_products` from products_composite where products_id=" . self::$products_id . $where.' limit 1');
            if ($res->fields['products_id']) {
                self::$type = $res->fields['type'];
                $relatedStr = '';
                switch (self::$type) {
                    case 1 :
                        $composite = array(array('id' => $res->fields['composite_B'], 'num' => 1), array('id' => $res->fields['composite_C'], 'num' => 1));
                        break;
                    case 2 :
                        $composite = array(array('id' => $res->fields['composite_B'], 'num' => 1), array('id' => $res->fields['composite_C'], 'num' => 2));
                        break;
                    case 3 :
                        $composite = array(array('id' => $res->fields['composite_B'], 'num' => 1), array('id' => $res->fields['composite_C'], 'num' => 1), array('id' => $res->fields['composite_D'], 'num' => 1));
                        break;
                    case 4 : //2019.1.10
                        $composite_products = $res->fields['composite_products'];
                        $composite_products_array = explode(',',$composite_products);
                        $composite =  array();
                        foreach ($composite_products_array as $key => $val){
                            $composite_products_one = explode(':',$val);
                            $composite[] = array(
                                'id' => (int)$composite_products_one[0],
                                'num' => $composite_products_one[1],
                            );
                        }
                        break;
                    default :
                        $composite = array();
                        break;
                }
                if (sizeof($composite) && $composite) {
                    self::$relatedArray = $composite;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 获取组合产品的库存数量
     *
     * @param int  $warehouse 0表示调用全部库存   参考前台显示库存的仓库  默认是成品仓
     * @param bool $isStore   标记前台调用
     * @param bool $isAuto    是否指定仓库库存
     * @param array $relatedArray 下单成功后的相关页面已经知道其对应的子产品组合直接复制即可 ery 2019.10.28
     * @return int
     */
    public function CompositeRelatedInstock($warehouse = 2, $isStore = false, $isAuto = true, $relatedArray=[])
    {
        if(sizeof($relatedArray)){
            self::$type = 4;
            self::$relatedArray = $relatedArray;
        }else{
            $this->CompositeProductsRelated(self::$products_id);
        }
        $compositeInstock = $CInstockQty = $specialInstock = 0;
        if (self::$relatedArray && sizeof(self::$relatedArray)) {
            if (self::$type == 1 || self::$type == 3) {
                foreach (self::$relatedArray as $v) {
                    $instock_id = 0;
                    if ($warehouse) {
                        $selectWarehouse = $isAuto ? $this->getWarehouseId($warehouse, $v['id']) : $warehouse;
                        $instock_id = fs_get_data_from_db_fields('products_instock_id', 'products_instock', 'products_id=' . (int)$v['id'] . ' and warehouse=' . (int)$selectWarehouse, '');
                        $storeOrderLock = $isStore ? fs_order_use_products_instock($v['id']) : 0;
                        $instock_qty[] = fs_get_data_from_db_fields('instock_qty', 'products_instock', 'products_instock_id=' . (int)$instock_id, '') - fs_products_instock_id_lock_total((int)$instock_id) - $storeOrderLock;
                    } else {
                        $lockTotal = 0;
                        if ($isStore) {
                            $lockTotal = fs_order_use_products_instock($v['id']);    //  前台order临时锁定库存
                        } else {
                            $res = self::$db->Execute('select products_instock_id from products_instock where warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)$v['id']);
                            while (!$res->EOF) {
                                if ($res->fields['products_instock_id']) {
                                    $lockTotal += fs_products_instock_id_lock_total($res->fields['products_instock_id']);
                                }
                                $res->MoveNext();
                            }
                        }
                        $instock_qty[] = fs_get_data_from_db_fields('sum(instock_qty)', 'products_instock', 'warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)$v['id'], '') - $lockTotal;
                    }
                }
                $compositeInstock = min($instock_qty);
            }
            elseif (self::$type == 2) {
                if ($warehouse) {
                    $selectWarehouseC = $isAuto ? $this->getWarehouseId($warehouse, self::$relatedArray[1]['id']) : $warehouse;
                    $CInstockID = fs_get_data_from_db_fields('products_instock_id', 'products_instock', 'products_id=' . (int)self::$relatedArray[1]['id'] . ' and warehouse=' . (int)$selectWarehouseC, '');
                    $CstoreOrderLock = $isStore ? fs_order_use_products_instock((int)self::$relatedArray[1]['id']) : 0;
                    $CInstockQty = fs_get_data_from_db_fields('instock_qty', 'products_instock', 'products_instock_id=' . (int)$CInstockID, '') - fs_products_instock_id_lock_total((int)$CInstockID) - $CstoreOrderLock;
                    $selectWarehouseB = $isAuto ? $this->getWarehouseId($warehouse, self::$relatedArray[0]['id']) : $warehouse;
                    $BInstockID = fs_get_data_from_db_fields('products_instock_id', 'products_instock', 'products_id=' . (int)self::$relatedArray[0]['id'] . ' and warehouse=' . (int)$selectWarehouseB, '');
                    $BstoreOrderLock = $isStore ? fs_order_use_products_instock((int)self::$relatedArray[0]['id']) : 0;
                    $BInstockQty = fs_get_data_from_db_fields('instock_qty', 'products_instock', 'products_instock_id=' . (int)$BInstockID, '') - fs_products_instock_id_lock_total((int)$BInstockID) - $BstoreOrderLock;
                } else {
                    $ClockTotal = $BlockTotal = 0;
                    if ($isStore) {
                        $ClockTotal = fs_order_use_products_instock(self::$relatedArray[1]['id']);
                    } else {
                        $Cres = self::$db->Execute('select products_instock_id from products_instock where warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)self::$relatedArray[1]['id']);
                        while (!$Cres->EOF) {
                            if ($Cres->fields['products_instock_id']) {
                                $ClockTotal += fs_products_instock_id_lock_total($Cres->fields['products_instock_id']);
                            }
                            $Cres->MoveNext();
                        }
                    }
                    $CInstockQty = fs_get_data_from_db_fields('sum(instock_qty)', 'products_instock', 'warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)self::$relatedArray[1]['id'], '') - $ClockTotal;

                    if ($isStore) {
                        $BlockTotal = fs_order_use_products_instock(self::$relatedArray[0]['id']);
                    } else {
                        $Bres = self::$db->Execute('select products_instock_id from products_instock where warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)self::$relatedArray[0]['id']);
                        while (!$Bres->EOF) {
                            if ($Bres->fields['products_instock_id']) {
                                $BlockTotal += fs_products_instock_id_lock_total($Bres->fields['products_instock_id']);
                            }
                            $Bres->MoveNext();
                        }
                    }
                    $BInstockQty = fs_get_data_from_db_fields('sum(instock_qty)', 'products_instock', 'warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)self::$relatedArray[0]['id'], '') - $BlockTotal;
                }
                if ($CInstockQty <= 1) {
                    $compositeInstock = 0;
                } elseif ($CInstockQty > 1 && $BInstockQty < floor($CInstockQty / 2)) {
                    $compositeInstock = $BInstockQty;
                } elseif ($CInstockQty > 1 && $BInstockQty >= floor($CInstockQty / 2)) {
                    $compositeInstock = floor($CInstockQty / 2);
                }
            }elseif (self::$type == 4) { // fairy 2019.1.11 add
                if ($warehouse) {
                    foreach (self::$relatedArray as $key => $val) {
                        /*$selectWarehouseC = $isAuto ? $this->getWarehouseId($warehouse, $val['id']) : $warehouse;
                        $CInstockID = fs_get_data_from_db_fields('products_instock_id', 'products_instock', 'products_id=' . (int)$val['id'] . ' and warehouse=' . (int)$selectWarehouseC, '');
                        $CstoreOrderLock = $isStore ? fs_order_use_products_instock((int)$val['id']) : 0;
                        $CInstockQty = fs_get_data_from_db_fields('instock_qty', 'products_instock', 'products_instock_id=' . (int)$CInstockID, '') - fs_products_instock_id_lock_total((int)$CInstockID) - $CstoreOrderLock;*/
                        switch($warehouse){
                            case 3:
                            case 40:
                                $CInstockQty = zen_get_current_qty($val['id'], "US", false)+zen_get_current_qty($val['id'],"US-ES",false);
                                break;
                            case 20:
                                $CInstockQty = zen_get_current_qty($val['id'], "DE", false);
                                break;
                            case 37:
                                $CInstockQty = zen_get_current_qty($val['id'], "AU", false);
                                break;
                            case 71:
                                $CInstockQty = zen_get_current_qty($val['id'], "SG", false);
                                break;
                            case 67:
                                $CInstockQty = zen_get_current_qty($val['id'], "RU", false);
                                break;
                            default:
                                $CInstockQty = zen_get_current_qty($val['id'], "CN", true);
                                break;
                        }

                        $current_product_num =  floor($CInstockQty/$val['num']);
                        if (in_array(self::$products_id, [108705, 108701, 108707])) {   //组合产品子产品为非软件产品时
                            if($key == 0){
                                $compositeInstock = $current_product_num;
                            }elseif ($current_product_num < $compositeInstock) { // 获取最小的，就是组合产品的数量。短板原理
                                $compositeInstock = $current_product_num;
                            }
                        } else {  //组合产品子产品为软件产品时
                            $isSoftware = fs_get_data_from_db_fields('is_software', TABLE_PRODUCTS, 'products_id='.(int)$val['id'], 'limit 1');
                            if (!$isSoftware) {
                                $compositeInstock = $current_product_num;
                            }
                        }


                        //90593,90594,97356防火墙组合产品需要展示所有子产品的库存和
                        if (in_array(self::$products_id, [106548, 108166, 106549, 108167, 106550, 108168, 117734, 117735, 117736, 117737, 107738, 117739])) {
                            $specialInstock += $CInstockQty;
                            $compositeInstock = $specialInstock;
                        }

                        if($current_product_num == 0){ //如果为0，将不再执行
                            $this->no_stock_id[$val['id']] = array('id'=>$val['id'], 'qty'=>$val['num']);
                        }
                    }
                } else {
                    foreach (self::$relatedArray as $key => $val) {
                        $ClockTotal = 0;
                        if ($isStore) {
                            $ClockTotal = fs_order_use_products_instock($val['id']);
                        } else {
                            $Cres = self::$db->Execute('select products_instock_id from products_instock where warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)$val['id']);
                            while (!$Cres->EOF) {
                                if ($Cres->fields['products_instock_id']) {
                                    $ClockTotal += fs_products_instock_id_lock_total($Cres->fields['products_instock_id']);
                                }
                                $Cres->MoveNext();
                            }
                        }
                        $instockQty = fs_get_data_from_db_fields('sum(instock_qty)', 'products_instock', 'warehouse in(1,2,3,5,6,7,10,11,21,20,37) and products_id=' . (int)$val['id'], '') - $ClockTotal;
                        $current_product_num = floor($instockQty/$val['num']);
                        if($key == 0){
                            $compositeInstock = $current_product_num;
                        }elseif ($current_product_num < $compositeInstock) { // 获取最小的，就是组合产品的数量。短板原理
                            $compositeInstock = $current_product_num;
                        }
                        if($current_product_num == 0){ //如果为0，将不再执行
                            $this->no_stock_id[$val['id']] = array('id'=>$val['id'], 'qty'=>$val['num']);
                        }
                    }
                }
            }
        }
        return $compositeInstock;
    }

    /**
     * 获取拆分后产品价格
     *
     * @return mixed
     */
    public function CompositeRelatedProductsPrice()
    {
        $this->CompositeProductsRelated(self::$products_id);
        $discount = 1;
        if (self::$orders_id) {
            $customers_id = fs_get_data_from_db_fields('customers_id', 'orders', 'orders_id=' . (int)self::$orders_id, '');
            $discount = fs_get_data_from_db_fields('discount_rate', 'customers', 'customers_id=' . (int)$customers_id, '');
        }
        if (self::$relatedArray && sizeof(self::$relatedArray)) {
            foreach (self::$relatedArray as $products) {
                $res = '';
                $res = self::$db->Execute('select discount_price,products_price from products where products_id = ' . (int)$products['id']);
                if ($res->fields['discount_price'] > 0) {
                    $fine_price = $res->fields['discount_price'];
                } else {
                    if($discount){
                        $fine_price = $res->fields['products_price'] * $discount;
                    }else{
                        $fine_price = $res->fields['products_price'];
                    }
                }
                $products_price[$products['id']] = $fine_price;
            }
        }
        return $products_price;
    }

    /**
     * 用于改变包材类产品的调用仓库
     * @param $warehouse
     * @param $products_id
     * @return int
     */
    private function getWarehouseId($warehouse, $products_id)
    {
        $products_type = fs_get_data_from_db_fields('products_type', 'products', 'products_id = ' . (int)$products_id, '');
        if(in_array($products_type, array(3, 4, 5))){
            switch ($warehouse){
                /*case 3 :
                    $selectWarehouse = 18;
                    break;*/
                case 2 :
                    $selectWarehouse = 5;
                    break;
                default :
                    $selectWarehouse = $warehouse;
                    break;
            }
        }
        $selectWarehouse = $selectWarehouse ? $selectWarehouse : $warehouse;
        return $selectWarehouse;
    }

    /**
     * 检查产品是否是 type=4 的组合产品
     * fairy 2019.2.21 add
     * pico 2020.9.15 add 后台添加组合产品修改和新增，现在数据库查询是否有type=4的组合产品
     * @return bool
     */
    public function check_product_is_composite(){
        //is_show_son为1才展示子产品数据 add dylan 2021.1.14
        $is_type4 = self::$db->Execute('select count(composite_id) as num from products_composite where products_id ='.(int)self::$products_id .' and type = 4 and is_show_son=1');
        if($is_type4->fields['num']){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取type=4的组合产品的数据。订单生成之前调用
     * fairy 2019.2.21 add
     * @param int $buy_num: 主产品的购买数量
     * @param string $currency_type: currencies表的code，币种code
     * @param int $size: 图片的宽度和高度
     * @param bool $is_for_order_product: 是否为了订单产品表插入数据使用
     * @param bool $is_tax_before: 是否展示税前价
     * @return array/string
     */
    public function get_products_composite($buy_num='',$size=60,$currency_type='',$is_for_order_product=false,$c_pid = '',$is_need_level_deal = true,$is_tax=false){
        if(!$is_for_order_product){
            $products = array();
        }else{
            $products = '';
        }

        if($this->check_product_is_composite()){
            $this->CompositeProductsRelated(self::$products_id); //获取组合产品数据

            global $currencies; // $currencies依托环境，转移到其他地方要注意
            $currency_type = $currency_type?$currency_type:$_SESSION['currency'];
            $currencies_value = $currencies->currencies[$currency_type]['value'];
            //整理数据
            $product_id_arr = array();
            $product_num_arr = array();
            foreach (self::$relatedArray as $key => $val){
                $product_id_arr[] = $val['id'];
                $product_num_arr[$val['id']] = $val['num'];
            }
            //获取数据库数据
            $relatedStr = implode(',',$product_id_arr);
            if(!empty($c_pid)){//获取组合产品单个子产品的数据
                $relatedStr = $c_pid;
            }
            if(!$is_for_order_product){
                $res = self::$db->Execute('SELECT p.products_id,p.products_image,p.products_price,p.integer_state,pd.products_name,p.is_heavy,p.integer_state 
                FROM '.TABLE_PRODUCTS.' p
                LEFT JOIN   '.TABLE_PRODUCTS_DESCRIPTION.' pd ON pd.products_id = p.products_id
                WHERE p.products_id in ('.$relatedStr.')
                ORDER BY FIELD(p.products_id,'.$relatedStr.')');
            }else{
                $res = self::$db->Execute('SELECT p.products_id,p.products_price,p.is_heavy,p.integer_state 
                FROM '.TABLE_PRODUCTS.' p
                WHERE p.products_id in ('.$relatedStr.')
                ORDER BY FIELD(p.products_id,'.$relatedStr.')');
            }

//            $wholesale_products = fs_get_wholesale_products_array();
            while(!$res->EOF){
                $product_price = zen_get_products_base_price_other($res->fields['products_price']);

                // 和购物车，产品详情页的计算方式保持一致。先把美元转换成对应币种，进行取整，之后在转换成美元，之后在在转化成对应币种。为了对应币种的产品价格是整数
                if ($res->fields['integer_state'] !=1) {
                    $product_price = get_products_all_currency_final_price($product_price * $currencies_value);
                } else {
                    $product_price = get_products_specail_currency_final_price($product_price * $currencies_value);
                }
                $original_product_price = number_format(zen_round($product_price, 2), 2, '.', '');//保留2位小数 原产品价格
                if ($is_need_level_deal && isset($_SESSION['member_level']) && $_SESSION['member_level'] > 1) { //企业价格的处理
                    $product_price = get_customers_products_level_price($product_price, $_SESSION['member_level']);
                    $product_price = $product_price / $currencies_value;
                } else {
                    $product_price = $product_price / $currencies_value;
                }

                //组合产品子产品 澳大利亚展示税后价 （重货本地仓无库存除外）
                $country_code = strtoupper($_SESSION['countries_iso_code']);
                $product_price = $is_tax ? get_gsp_tax_price($country_code,$product_price) : $product_price;

                $product_price_currency = $product_price * $currencies_value;
                $product_price_currency = $currencies->fs_format_new($product_price_currency,false);

                $current_buy_num = $buy_num?$buy_num*$product_num_arr[$res->fields['products_id']]:0; //如果购买几个主产品，对应几个分产品

                if(!$is_for_order_product){
                    // 已经计算好汇率了，所以update_format下面传递false
                    $products_price_str = $currencies->update_format($product_price_currency, false, $currency_type);
                    $original_product_price = $currencies->update_format($original_product_price, false, $currency_type);
                    $products[$res->fields['products_id']] = array(
                        'products_id' => $res->fields['products_id'],
                        'product_price_currency' => $product_price_currency, //当前币种价格
                        'products_price_str' => $products_price_str, //带有单位的，当前币种价格
                        'products_name' => $res->fields['products_name'],
                        'buy_number' => $current_buy_num,
                        'original_product_price' => $original_product_price,       // 原产品的价格
                        'one_product_corr_number' => $product_num_arr[$res->fields['products_id']],  //一个主产品，对应几个分产品。购物车修改数量需要
                        'products_image_str' => get_resources_img(intval($res->fields['products_id']),$size,$size,$res->fields['products_image'],'','',' border="0" ')
                    );
                }else{
                    $products .= $res->fields['products_id'].':'.$current_buy_num.'-'.$product_price_currency.',';
                }

                $res->MoveNext();
            }
        }

        return $products;
    }

    /**
     * 获取type=4的组合产品的数据。订单生成之前调用,专用于需要展示组合产品的页面，并且是经过quote之后的价格，是对上面fairy写的get_products_composite的补充
     * rebirth 2019.04.11 add
     * @param int $buy_num  // 主产品的购买数量
     * @param int $id       // 主产品的id
     * @param int $size     // 展示图片的尺寸
     * @return array
     */
    public function show_products_composite($buy_num = 0, $id = 0 ,$size = 60, $original_price = '', $is_tax = ''){
        $products = array();

        if(!empty($id)){
            self::$products_id  = $id;
        }

        if($this->check_product_is_composite()){

            global $currencies; // $currencies依托环境，转移到其他地方要注意
            $currency_type = $_SESSION['currency'];
            $currencies_value = $currencies->currencies[$currency_type]['value'];


            if(!empty($_SESSION['cart']->contents[self::$products_id]['quotation_combination']) && $_SESSION['cart']->contents[self::$products_id]['reoder_type'] == 'quotation'){
                $flag = true;
                $quotation_combination = $_SESSION['cart']->contents[self::$products_id]['quotation_combination'];
            }else{
                $flag = false;
                $quotation_combination = [];
            }
            $this->CompositeProductsRelated(self::$products_id); //获取组合产品数据
            if(self::$relatedArray) {
                $pid = self::$relatedArray[0]['id'];
                //ternence 2019/7.5 add 组合产品企业会员打折判断
                $corporate_discount = fs_get_data_from_db_fields("corporate_discount", TABLE_PRODUCTS, "products_id = {$pid} LIMIT 1");
                $discount_type = true;
                if ($corporate_discount == 0) {
                    $discount_type = false;
                }

                //整理数据
                $product_id_arr = array();
                $product_num_arr = array();
                foreach (self::$relatedArray as $key => $val) {
                    $product_id_arr[] = $val['id'];
                    $product_num_arr[$val['id']] = $val['num'];
                }
                //获取数据库数据
                $relatedStr = implode(',', $product_id_arr);
                if (!empty($c_pid)) {//获取组合产品单个子产品的数据
                    $relatedStr = $c_pid;
                }

                $res = self::$db->Execute('SELECT p.products_id,p.products_image,p.products_price,pd.products_name,p.is_heavy,p.integer_state
            FROM ' . TABLE_PRODUCTS . ' p
            LEFT JOIN   ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON pd.products_id = p.products_id
            WHERE p.products_id in (' . $relatedStr . ')
            ORDER BY FIELD(p.products_id,' . $relatedStr . ')');

//                $wholesale_products = fs_get_wholesale_products_array();
                while (!$res->EOF) {
                    if ($flag) {
                        $product_price_currency = $quotation_combination[$res->fields['products_id']]['products_price'];
                        $products_price_str = $quotation_combination[$res->fields['products_id']]['products_price_str'];
                    } else {
                        $product_price = zen_get_products_base_price_other($res->fields['products_price']);

                        // 和购物车，产品详情页的计算方式保持一致。先把美元转换成对应币种，进行取整，之后在转换成美元，之后在在转化成对应币种。为了对应币种的产品价格是整数
                        if ($res->fields['integer_state'] !=1) {
                            $product_price = get_products_all_currency_final_price($product_price * $currencies_value);
                        } else {
                            $product_price = get_products_specail_currency_final_price($product_price * $currencies_value);
                        }
                        if (isset($_SESSION['member_level']) && $_SESSION['member_level'] > 1 && $discount_type == true) { //企业价格的处理
//                            $product_price = get_customers_products_level_price($product_price, $_SESSION['member_level']);
                            // 2019-10-31 potato $original_price = 1 的时候获取的是原价，其它的时候获取的是折扣价
                            if (empty($original_price)) $product_price = get_customers_products_level_price($product_price, $_SESSION['member_level']);
                            $product_price = $product_price / $currencies_value;
                        } else {
                            $product_price = $product_price / $currencies_value;
                        }

                        //组合产品子产品 澳大利亚展示税后价 （重货本地仓无库存除外）
                        $country_code = strtoupper($_SESSION['countries_iso_code']);
                        $is_tax = $is_tax !== '' ? $is_tax : ($country_code == 'AU' ? true : false);
                        $product_price = $is_tax ? get_gsp_tax_price($country_code,$product_price) :
                            $product_price;

                        $product_price_currency = $product_price * $currencies_value;
                        $product_price_currency = $currencies->fs_format_new($product_price_currency,false);
                        //$product_price_currency = number_format(zen_round($product_price_currency, 2), 1, '.', '');//保留1位小数
                        $products_price_str = $currencies->update_format($product_price_currency, false, $currency_type);
                    }
                    $current_buy_num = $buy_num ? $buy_num * $product_num_arr[$res->fields['products_id']] : 0; //如果购买几个主产品，对应几个分产品
                    $products[$res->fields['products_id']] = array(
                        'products_id' => $res->fields['products_id'],
                        'product_price_currency' => $product_price_currency, //当前币种价格
                        'products_price_str' => $products_price_str, //带有单位的，当前币种价格
                        'products_name' => $res->fields['products_name'],
                        'buy_number' => $current_buy_num,
                        'one_product_corr_number' => $product_num_arr[$res->fields['products_id']],  //一个主产品，对应几个分产品。购物车修改数量需要
                        'products_image_str' => get_resources_img(intval($res->fields['products_id']), $size, $size, $res->fields['products_image'], '', '', ' border="0" '),
                        'parent_products_id' => self::$products_id
                    );

                    $res->MoveNext();
                }
            }
        }

        return $products;
    }


    /**
     * 获取type=4的组合产品的主价格。等于子产品价格之和
     * fairy 2019.2.21 add
     * @param int $is_shopping_cart_checkout_page。是否是购物车或者结算页面
     * @param string $currency_type: currencies表的code，币种code
     * @return float: 单位是美元。因为收税计算等好多地方，是根据美元进行计算的
     */
    public function get_composite_product_price($is_shopping_cart_checkout_page=false,$currency_type='', $is_tax_before = false){
        global $currencies; // $currencies依托环境，转移到其他地方要注意
        $composite_product_price = 0;
        $composite_product_price_original = 0; //没有打折的价格。方便购物车计算节省了多少钱
        $currency_type = $currency_type?$currency_type:$_SESSION['currency'];
        $currencies_value = $currencies->currencies[$currency_type]['value'];
        if($this->check_product_is_composite()){
            $this->CompositeProductsRelated(self::$products_id); //获取组合产品数据
            $use_au_gsp = false;
            $country_code = strtoupper($_SESSION['countries_iso_code']);
            if (!$is_tax_before && AU_use_gsp_tax(self::$products_id,self::$combination_attr,$country_code)){
                $use_au_gsp = true;
            }
            //ternence 2019/7.5 add 组合产品企业会员打折判断
            if(self::$relatedArray) {
                $pid = self::$relatedArray[0]['id'];
                $corporate_discount = fs_get_data_from_db_fields("corporate_discount", TABLE_PRODUCTS, "products_id = {$pid} LIMIT 1");
                $discount_type = true;
                if ($corporate_discount == 0) {
                    $discount_type = false;
                }
                //整理数据
                $product_id_arr = array();
                $product_num_arr = array();
                foreach (self::$relatedArray as $key => $val) {
                    $product_id_arr[] = $val['id'];
                    $product_num_arr[$val['id']] = $val['num'];
                }
                //获取数据库数据
                $relatedStr = implode(',', $product_id_arr);
                $res = self::$db->Execute('SELECT p.products_id,p.products_price,p.integer_state,p.is_heavy 
            FROM ' . TABLE_PRODUCTS . ' p
            WHERE p.products_id in (' . $relatedStr . ')');
//                $wholesale_products = fs_get_wholesale_products_array();  这个数组返回的就是 integer_state 为1的数组
                while (!$res->EOF) {
                    $product_price = zen_get_products_base_price_other($res->fields['products_price']);

                    // 和购物车，产品详情页的计算方式保持一致。先把美元转换成对应币种，进行取整，之后在转换成美元，之后在在转化成对应币种。为了对应币种的产品价格是整数
                    if ($res->fields['integer_state'] !=1) {
                        $product_price = get_products_all_currency_final_price($product_price * $currencies_value);
                    } else {
                        $product_price = get_products_specail_currency_final_price($product_price * $currencies_value);
                    }

                    if ($is_shopping_cart_checkout_page) {
                        if (isset($_SESSION['member_level']) && $_SESSION['member_level'] > 1 && $discount_type == true) {//企业价格的处理
                            $product_price_original = $product_price / $currencies_value;
                            $product_price = get_customers_products_level_price($product_price, $_SESSION['member_level']);
                            $product_price = $product_price / $currencies_value;
                        } else {
                            $product_price = $product_price / $currencies_value;
                        }
                    } else {
                        $product_price = $product_price / $currencies_value;
                    }

                    //组合产品子产品 澳大利亚展示税后价 （重货本地仓无库存除外）
                    $product_price = ($use_au_gsp) ? get_gsp_tax_price($country_code,$product_price) :
                        $product_price;

                    $product_price_currency = $product_price * $currencies_value;
                    $product_price_currency = $currencies->fs_format_new($product_price_currency,false);
                    $composite_product_price += $product_price_currency * $product_num_arr[$res->fields['products_id']];

                    if ($is_shopping_cart_checkout_page && isset($_SESSION['member_level']) && $_SESSION['member_level'] > 1 && $discount_type == true) {
                        $product_price_currency_original = $product_price_original * $currencies_value;
                        $composite_product_price_original += $product_price_currency_original * $product_num_arr[$res->fields['products_id']];
                    }
                    $res->MoveNext();
                }
            }
        }
        $composite_product_price = $composite_product_price / $currencies_value; //转换成美元。
        if ($is_shopping_cart_checkout_page && isset($_SESSION['member_level']) && $_SESSION['member_level']>1 && $discount_type==true) {
            $composite_product_price_original = $composite_product_price_original / $currencies_value; //转换成美元。
        }
        if($is_shopping_cart_checkout_page){
            if (!(isset($_SESSION['member_level']) && $_SESSION['member_level']>1)  && $discount_type==true) {
                $composite_product_price_original = $composite_product_price;
            }

            return array(
                'composite_product_price' => $composite_product_price, //美元
                'composite_product_price_current' => number_format(zen_round($composite_product_price*$currencies_value, 2), 2, '.',''), //对应币种
                'composite_product_price_str' => $composite_product_price==0?0:$currencies->total_format($composite_product_price,true,$currency_type,$currencies_value), //对应币种
                'composite_product_price_original' => $composite_product_price_original, //美元
                'composite_product_origin_current' => number_format(zen_round($composite_product_price_original*$currencies_value, 2), 2, '.', ''), //对应币种
                'composite_product_price_original_str' => $composite_product_price_original==0?0:$currencies->total_format($composite_product_price_original,true,$currency_type,$currencies_value), //对应币种
            );
        }else{
            return array(
                'composite_product_price' => $composite_product_price, //美元
                'composite_product_price_str' => $composite_product_price==0?0:$currencies->total_format($composite_product_price,true,$currency_type,$currencies_value), //对应币种
            );
        }
    }

}

?>
