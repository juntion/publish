<?php
namespace  classes\custom;

class FsCustomRelate
{
    public static $products_id;
    public static $optionAttr;
    protected static $customRelateProducts;  //  定制产品关联了哪些主产品   Array
    protected static $allRelated;            //  对应主产品包含的所有子产品以及属性信息
    protected static $db;
    protected static $excellentMatch;        //  属性匹配信息   其中的key  matchNum  标识了选择属性在该产品中的匹配次数
    protected static $PCRelated;             //   主产品和子产品关联数组(仅仅是产品的关联  没有属性信息)
    public static $optionAttrQty;            //   选择了几个属性
    protected static $productsType = 1;      //   1产品有主产品关联      0没有关联
    public static $length;                  //   长度值
    protected static $matchRes;
    protected static $lengthOptionValue;
    protected static $isfeet = false;
    public static $match_custom_products = array();
    public $result_is_custom = false;
    public $onlyMatchCustom = false;


    function __construct($products_id = 0, $option_arr = 0, $length = '')
    {
       if(is_array($option_arr)){
           foreach ($option_arr as $key=>$value){
               if($value == 8389){ //线轴加价 特殊处理(线轴属性只加价,不影响匹配标准产品)
                   unset($option_arr[$key]);
               }
           }
       }elseif (is_numeric($option_arr)){
           if($option_arr == 8389){
               $option_arr =0;
           }
       }
        global $db;
        self::$products_id = $products_id;
        self::$db = $db;
        self::$optionAttr = $option_arr;
        self::$length = $length;
        self::$match_custom_products = array();
    }

    /**
     * 检查是否是定制产品，是的话就查出对应的关联主产品ID集合
     * return array or false;
     */
    function checkCustomProducts()
    {
        if (self::$products_id) {
            if (is_numeric(self::$optionAttr) && self::$optionAttr) {
                $optionAttrQty = 1;
            } elseif (is_array(self::$optionAttr)) {
                $optionAttrQty = sizeof(self::$optionAttr);
            }
            if (self::$length) {
                $optionAttrQty += 1;
                if (strpos(self::$length, 'ft')) {
                    self::$isfeet = true;
                    $Nres = self::$db->Execute('select products_options_values_id from products_options_values where (products_options_values_name regexp "^[0-9.]+m[ \f\n\r\t\v]*\\\\(' . self::$length . '\\\\)$" 
                     or products_options_values_name regexp "^' . self::$length . '[ \f\n\r\t\v]*\\\\([0-9.]+m\\\\)$") and language_id=1');
                } else {
                    if (strpos(self::$length, 'km')) {
                        $Nres = self::$db->Execute('select products_options_values_id from products_options_values where products_options_values_name regexp "' . self::$length . '"');
                    } else {
                        $remove_unit = str_replace('m', '', self::$length);
                        if ($remove_unit == floatval($remove_unit)) {
                            self::$length = floatval($remove_unit) . 'm';
                        }
                        $Nres = self::$db->Execute('select products_options_values_id from products_options_values where (products_options_values_name regexp "^' . self::$length . '[ \f\n\r\t\v]*\\\\([0-9.]+ft\\\\)$"
                      or products_options_values_name regexp "^[0-9.]+ft[ \f\n\r\t\v]*\\\\(' . self::$length . '\\\\)$") and language_id=1');
                    }
                }
                if (!is_array(self::$optionAttr) && self::$optionAttr) {
                    self::$optionAttr = explode(',', self::$optionAttr);
                }
                while (!$Nres->EOF) {
                    if ($Nres->fields['products_options_values_id']) {
                        //由于用长度例如1m去products_options_values表中会查到多个记录，所以不往$optionAttr中追加，单独放在$lengthOptionValue中
                        //self::$optionAttr[] = $Nres->fields['products_options_values_id'];
                        self::$lengthOptionValue[] = $Nres->fields['products_options_values_id'];
                    }
                    $Nres->MoveNext();
                }
            }
            self::$optionAttrQty = $optionAttrQty;
            //  定制关联用新的关联表
            /*$res = self::$db->Execute('select products_id from products_instock_customized_related where customized_id='.(int)self::$products_id);
             while(!$res->EOF){
            if($res->fields['products_id']){
            $standardProduct[] = $res->fields['products_id'];
            }
            $res->MoveNext();
            }*/
            if (!isset($standardProduct)) {
                $res = self::$db->Execute('select products_id from products_instock_other_customized_related where customized_id=' . (int)self::$products_id);
                while (!$res->EOF) {
                    if ($res->fields['products_id']) {
                        $standardProduct[] = $res->fields['products_id'];
                    }
                    $res->MoveNext();
                }
                self::$productsType = 0;
            }
        }
        if (sizeof($standardProduct) > 0) {
            self::$customRelateProducts = $standardProduct;
            return $standardProduct;
        } else {
            return false;
        }
    }

    /**
     * 获取主产品的关联子产品
     *
     * @param        products_id     int OR Array  可传一个一位数组的产品集合或者单个产品ID  可选参数
     * @param  Array $relatedProduct [key=主产品id]=array(1,2,3)子产品
     */
    function getChildrenProduct($products_id = 0)
    {
        if ($products_id && is_numeric($products_id)) {
            $res = self::$db->Execute('select pa.products_id as main_id,pb.products_id from products_instock_add_related as pb left join products_instock_add_model as pa using(model_id)
          where pa.products_id =' . (int)$products_id);
        } elseif (is_array($products_id)) {
            $res = self::$db->Execute('select pa.products_id as main_id,pb.products_id from products_instock_add_related as pb left join products_instock_add_model as pa using(model_id)
          where pa.products_id in (' . implode(',', $products_id) . ')');
        } else if (sizeof(self::$customRelateProducts)) {
            $res = self::$db->Execute('select pa.products_id as main_id,pb.products_id from products_instock_add_related as pb left join products_instock_add_model as pa using(model_id)
          where pa.products_id in (' . implode(',', self::$customRelateProducts) . ')');
        }
        if ($res) {
            while (!$res->EOF) {
                if ($res->fields['main_id']) {
                    $relatedProduct[$res->fields['main_id']][] = $res->fields['products_id'];
                }
                $res->MoveNext();
            }
        }
        return $relatedProduct;
    }

    /**
     * 获取指定产品的属性
     */
    public static function getProductsAttr($products_id)
    {
        if ($products_id) {
            $res = self::$db->Execute('select options_id,options_values_id from products_attributes where products_id=' . (int)$products_id);
            $verify_is_custom = array();
            while (!$res->EOF) {
                $options_status = 0;
                $optionsRes = self::$db->Execute('select products_options_status,products_options_type from products_options where products_options_id = '.(int)$res->fields['options_id'])->fields;
                if (sizeof($optionsRes)) {
                    $options_status = $optionsRes['products_options_status'];
                    $optionsTypes = $optionsRes['products_options_type'];
                }
                if ($res->fields['options_id'] && $res->fields['options_values_id'] && ($options_status || $res->fields['options_id'] == 34) && !in_array($optionsTypes, array(1, 4))) {
                    if (!in_array($res->fields['options_id'], $verify_is_custom)) {  //存在同一属性   对应多个属性值的  则是定制拆分id
                        $verify_is_custom[] = $res->fields['options_id'];
                    } else {
                        if (!in_array($products_id, self::$match_custom_products)) {
                            self::$match_custom_products[] = $products_id;
                        }
                    }
                    $attr[] = $res->fields['options_values_id'];
                }
                $res->MoveNext();
            }
        }
        return $attr;
    }

    /**
     * 主函数处理
     */
    function handle()
    {
        self::$customRelateProducts = array();
        self::$allRelated = array();
        self::$excellentMatch = array();
        self::$PCRelated = array();
        self::$match_custom_products = array();
        self::$matchRes = array();
        self::$lengthOptionValue = array();
        self::$isfeet = false;
        self::$productsType = 1;
        //当只有长度属性时，获取属性表中的不展示在前台的属性数据(主要针对线材类只有长度属性定制产品匹配标准产品)
        if (self::$length && !self::$optionAttr) {
            //该产品前台展示的是否有其他属性
            $data = self::$db->getAll("SELECT `products_attributes_id` FROM `products_attributes` WHERE `attributes_status`=1 AND `products_id`=" . self::$products_id . " LIMIT 1");
            if (!$data[0]['products_attributes_id']) {
                //前台没有展示属性表格上传的属性，在查找该产品是否有不展示的属性
                $res = self::$db->Execute('select options_id,options_values_id from products_attributes where products_id=' . (int)self::$products_id);
                $attr = array();
                while (!$res->EOF) {
                    $options_status = 0;
                    $optionsRes = self::$db->Execute('select products_options_status,products_options_type from products_options where products_options_id = '.(int)$res->fields['options_id'])->fields;
                    if (sizeof($optionsRes)) {
                        $options_status = $optionsRes['products_options_status'];
                        $optionsTypes = $optionsRes['products_options_type'];
                    }
                    if ($res->fields['options_id'] && $res->fields['options_values_id'] && ($options_status || $res->fields['options_id'] == 34) && !in_array($optionsTypes, array(1, 4))) {
                        if ($res->fields['options_id'] != 341) {
                            $attr[] = $res->fields['options_values_id'];
                        }
                    }
                    $res->MoveNext();
                }
                self::$optionAttr = $attr;
            }
        }
        $standardProduct = $this->checkCustomProducts();  //  检查是否是定制产品   如果是返回定制关联的主产品
        if ($standardProduct) {
            if (self::$productsType) {                        //  光模块才有主产品关联
                $relatedProduct = $this->getChildrenProduct();    //  获取关联主产品的子产品
            } else {
                $relatedProduct = $standardProduct;
            }

            if (sizeof($relatedProduct)) {
                self::$PCRelated = $relatedProduct;
                $allRelatedProducts = [];
                if(self::$productsType){
                    foreach($relatedProduct as $pK=>$pV){
                        foreach($pV as $id){
                            $allRelatedProducts[] = $id;
                        }
                    }
                }else{
                    $allRelatedProducts = $relatedProduct;
                }
                //把获取到的关联产品 开启的放在前面优先匹配
                $allRelatedProducts = $this->getProductByStatus($allRelatedProducts);
                //获取所有关联产品的属性
                $relatedProductsAttr = self::getAllRelatedProductsAttr($allRelatedProducts);

                $matchProducts = self::optionAttrMatch($relatedProductsAttr);  //  定制选择的属性与关联产品属性匹配     返回定制选择属性关联的产品ID
                self::$allRelated = $relatedProductsAttr;        //  所有关联产品属性以及和   定制选择属性匹配标准产品的次数  数组
                $excellentMatch = self::screenProducts();        //   筛选匹配数组中匹配次数最大的产品返回
                $excellentMatch = $this->trimRelatedProducts($excellentMatch);     // 去除最优匹配产品中前台隐藏取消的
                self::$excellentMatch = $excellentMatch;
            }
        }
        if ($excellentMatch['matchNum'] == 0 || !isset($excellentMatch['matchNum']) || $excellentMatch['matchNum'] != self::$optionAttrQty || empty($excellentMatch[0])) {  //匹配的标准产品属性的个数要和定制产品选中数量一致
            if (self::$isfeet) {
                return false;
            } else {
                // return $this->tryagain();
                return false;
            }
        } else {
            if (in_array($excellentMatch[0], self::$match_custom_products)) {
                $this->result_is_custom = true;
            }
            return $excellentMatch;
        }
    }

    /**
     * 用定制产品选中的属性  对其关联的所有标准产品进行属性匹配
     * return  array    返回关联产品中包含选中属性的所有产品
     */
    protected static function optionAttrMatch(&$findData)
    {
        if (sizeof(self::$optionAttr) && sizeof($findData)) {
            if (!is_array(self::$optionAttr) && is_numeric(self::$optionAttr)) {   //  属性值可传int类 型和  数组
                $optionAttrNum =0;
                if(self::$length) $optionAttrNum +=1;
                foreach ($findData as $k => $v) {
                    $v_num = sizeof($v);
                    if($v_num && !self::$optionAttr){
                        if($v_num!=$optionAttrNum){
                            //标准产品的属性个数和定制产品勾选的属性个数完全一致时才去匹配
                            unset($findData[$k]);
                            continue;
                        }
                        //由于程序根据长度例如1m去数据库中搜索对应的属性值，会存在1m (3ft)，1m(3ft)，1m (3.3ft)等多种情况
                        if(sizeof(self::$lengthOptionValue)){
                            //只要关联的标准产品的长度属性在上面查到的所有长度属性中就认为长度一致
                            if(in_array($v[0], self::$lengthOptionValue)){
                                $matchProducts[$v[0]][] = $k;
                                $findData[$k]['matchNum'] += 1;
                                self::$matchRes[$k][] = $v[0];
                            }
                        }
                    }elseif ($v_num && in_array((int)self::$optionAttr, $v)) {
                        $matchProducts[self::$optionAttr][] = $k;
                        $findData[$k]['matchNum'] += 1;
                        self::$matchRes[$k][] = self::$optionAttr;
                    }
                }
            } elseif (is_array(self::$optionAttr)) {
                $optionAttrNum = sizeof(self::$optionAttr);
                //属性个数加上长度属性
                if(self::$length) $optionAttrNum +=1;
                foreach ($findData as $k => $v) {
                    $selectOptionAttr = self::$optionAttr;
                    if(sizeof($v)!=$optionAttrNum){
                        //标准产品的属性个数和定制产品勾选的属性个数完全一致时才去匹配
                        unset($findData[$k]);
                        continue;
                    }
                    if (sizeof($v) && is_array($v)) {
                        foreach ($v as $attr) {
                            //由于程序根据长度例如1m去数据库中搜索对应的属性值，会存在1m (3ft)，1m(3ft)，1m (3.3ft)等多种情况
                            if(sizeof(self::$lengthOptionValue)){
                                //只要关联的标准产品的长度属性在上面查到的所有长度属性中就认为长度一致
                                if(in_array($attr, self::$lengthOptionValue)){
                                    $matchProducts[$attr][] = $k;
                                    $findData[$k]['matchNum'] += 1;
                                    self::$matchRes[$k][] = $attr;
                                }
                            }
                            if (in_array($attr, $selectOptionAttr)) {
                                //删除已经匹配过的values_id
                                $selectKey = array_search($attr, $selectOptionAttr);
                                unset($selectOptionAttr[$selectKey]);
                                $matchProducts[$attr][] = $k;
                                $findData[$k]['matchNum'] += 1;
                                self::$matchRes[$k][] = $attr;
                            }
                        }
                    }
                }
            }
        }
        return $matchProducts;
    }

    /**
     * 筛选匹配结果    选出与定制产品选中属性匹配最多的标准产品
     */
    protected static function screenProducts()
    {
        if (sizeof(self::$allRelated)) {
            $initMatchNum = 0;
            foreach (self::$allRelated as $k => $v) {
                if (isset($v['matchNum']) && $v['matchNum'] > $initMatchNum && $v['matchNum']<=self::$optionAttrQty) {
                    $excellentMatch = array();
                    $excellentMatch[] = $k;
                    $initMatchNum = $v['matchNum'];
                } elseif ($v['matchNum'] == $initMatchNum) {
                    $excellentMatch[] = $k;
                }
            }
            $excellentMatch['matchNum'] = $initMatchNum;
            $excellentMatch['option'] = array('length'   => self::$length, 'attr' => (is_array(self::$optionAttr) ? implode(',', self::$optionAttr) : self::$optionAttr),
                                              'matchRes' => self::$matchRes);
        }
        return $excellentMatch;
    }

    /**
     * handle函数返回FALSE时   可用该函数查看 匹配结果
     */
    public static function getExcellentMatch()
    {
        return self::$excellentMatch;
    }

    public static function getAllRelatedProducts()
    {
        return self::$allRelated;
    }

    /**
     * 获取线上订单的属性   根据orders_products_id
     */
    public static function getOrdersProductsAttr($id, $type = 0)
    {
        if ($type == 0 && $id) {
            $res = self::$db->Execute('select products_options_id,products_options_values_id,products_options,products_options_values from orders_products_attributes where orders_products_id=' . $id);
            while (!$res->EOF) {
                if ($res->fields['products_options_id'] && $res->fields['products_options_values_id']) {
                    $productsAttr[$res->fields['products_options_id']] = $res->fields['products_options_values_id'];
                }
                $res->MoveNext();
            }
            $length_name = fs_get_data_from_db_fields('length_name', 'order_product_length', 'orders_products_id=' . $id, '');
            if ($length_name) {
                $length = str_replace(' ', '', $length_name);
            }
        }
        return array('attr' => $productsAttr, 'length' => $length);
    }

    /**
     * 去除匹配关联中前台取消的产品   以及属性匹配相同属性ID匹配问题
     * 同一个产品属性值ID可能存在重复    上面的匹配存在遗漏     把属性数组转字符串再进行比较   是否是相同属性
     */
    protected function trimRelatedProducts($matchProducts)
    {
        $select = array();
        $match_products_num = 0;
        if (sizeof($matchProducts)) {
            foreach ($matchProducts as $k => $pid) {
                if (is_numeric($k)) {
                    $res = self::$db->Execute('select products_status from products where products_id=' . (int)$pid);
                    $productsAttr = self::$matchRes[$pid];  //  对应产品的匹配到的属性
                    @sort($productsAttr);
                    if (is_array(self::$optionAttr) && sizeof(self::$optionAttr)) {
                        if (is_array(self::$lengthOptionValue) && sizeof(self::$lengthOptionValue)) {
                            foreach (self::$optionAttr as $attr) {
                                if (!in_array($attr, self::$lengthOptionValue)) {   //  取到非长度属性值
                                    $unLengthOption[] = $attr;
                                }
                            }
                            foreach (self::$lengthOptionValue as $length) {
                                $checkArr = array();
                                foreach ($unLengthOption as $attr) {
                                    $checkArr[] = $attr;
                                }
                                $checkArr[] = $length;
                                @sort($checkArr);
                                $select[] = @implode('', $checkArr);
                            }
                        } else {
                            @sort(self::$optionAttr);
                            $select[] = @implode('', self::$optionAttr);
                        }
                    } else {
                        if (is_array(self::$lengthOptionValue) && sizeof(self::$lengthOptionValue)) {
                            foreach (self::$lengthOptionValue as $length) {
                                $checkArr = array();
                                if(self::$optionAttr){
                                    $checkArr[] = self::$optionAttr;
                                }
                                $checkArr[] = $length;
                                @sort($checkArr);
                                $select[] = @implode('', $checkArr);
                            }
                        }else{
                            $select[] = self::$optionAttr;
                        }
                    }
                    //  17-6-6  推广去掉过滤关闭产品
                    /*if($res->fields['products_status'] && (@implode('',$productsAttr))==$select){
                     $data[] = $pid;
                    }*/
                    $thisProductsAttrQty = 0;
                    if (sizeof(self::$allRelated[$pid]) && self::$allRelated[$pid]) {
                        foreach (self::$allRelated[$pid] as $k => $v) {
                            if (is_numeric($k)) {
                                $thisProductsAttrQty++;
                            }
                        }
                    }
                    if (in_array((@implode('', $productsAttr)), $select) && (in_array($pid, self::$match_custom_products) || self::$optionAttrQty == $thisProductsAttrQty)) {
                        $data[] = $pid;
                        $match_products_num += 1;
                    }
                } elseif ($k == 'matchNum') {
                    $data['matchNum'] = $pid;
                } elseif ($k == 'option') {
                    $data['option'] = $pid;
                }
            }
        }
        if (sizeof($data) && $data) {
            foreach ($data as $k => $v) {
                if (is_numeric($k)) {
                    if (in_array($v, self::$match_custom_products)) {  // 有多个产品满足匹配的时候   去除掉定制产品
                        if($match_products_num > 1) {
                            unset($data[$k]);
                        }
                        $deleteCustom[] = $v;
                    } elseif (empty($data[0])) {  // 匹配结果是取键值为0的   要保证键值0的值是有的
                        $data[0] = $v;
                    }
                }
            }
            //优先调取主产品ID的匹配
            $mainID = $standardID = [];
            foreach ($data as $k => $v) {
                if (is_numeric($k) && $match_products_num > 0) {
                    $res = self::$db->Execute('select model_id from products_instock_add_model where products_id = ' . (int)$v);
                    if ($res->fields['model_id']) {
                        $mainID[] = $v;
                    } else {
                        $standardID[] = $v;
                    }
                }
            }
            $newData = array_merge($mainID, $standardID);;
            /*if(!$this->onlyMatchCustom) {
                $newData = array_merge($mainID, $standardID);
            }*/
            //只匹配定制拆分id
            if ($this->onlyMatchCustom) {
                if (sizeof($deleteCustom)) {
                    $newData = array_merge($deleteCustom, $newData);
                    $newData = array_unique($newData);
                } else {
                    $newData = [];
                }
            }
            $newData['matchNum'] = $data['matchNum'];
            $newData['option'] = $data['option'];
        }
        return $newData;
    }

    /**
     * 米数转换成feet  四舍五入
     */
    public static function metersConvertFeet($m)
    {
        $length = str_replace('m', '', $m);
        $length = round((float)$length * 3.2808399) . 'ft';
        return $length;
    }

    /**
     * 米数长度没匹配到再转成feet进行匹配
     */
    public function tryagain()
    {
        if (self::$isfeet === false && self::$length) {
            if (is_array(self::$lengthOptionValue) && sizeof(self::$lengthOptionValue)) {
                foreach (self::$optionAttr as $attr) {
                    if (!in_array($attr, self::$lengthOptionValue)) {   //  取到非长度属性值
                        $unLengthOption[] = $attr;
                    }
                }
            } else {
                $unLengthOption = self::$optionAttr;
            }
            self::$lengthOptionValue = array();
            self::$customRelateProducts = array();
            self::$PCRelated = array();
            self::$matchRes = array();
            self::$optionAttr = $unLengthOption;
            self::$length = self::metersConvertFeet(self::$length);
            $res = $this->handle();
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 获取到的关联产品数组 重新排序 开启产品在前优先匹配
     * 参数$product 一维索引数组
     */
    public function getProductByStatus($products=array())
    {
        $data = $open_data = $close_data = array();
        if(sizeof($products)){
            $result = self::$db->Execute("SELECT `products_id`,`products_status` FROM `products` WHERE `products_id` IN (".join(',', $products).")");
            while(!$result->EOF){
                if($result->fields['products_status']==1){
                    $open_data[] = $result->fields['products_id'];
                }else{
                    $close_data[] = $result->fields['products_id'];
                }
                $result->MoveNext();
            }
            $data = array_merge($open_data, $close_data);
        }
        return $data;
    }

    public static function getAllRelatedProductsAttr($products=[])
    {
        $productsAttr = [];
        if(sizeof($products)){
            $result = self::$db->Execute("SELECT  pa.products_id,pa.options_id,pa.options_values_id,po.products_options_status,po.products_options_type FROM `products_attributes` pa LEFT JOIN `products_options` po ON (pa.options_id=po.products_options_id) WHERE pa.products_id IN (".join(',',$products).") AND po.language_id=".$_SESSION['languages_id']." ORDER BY FIELD(pa.products_id,".join(',',$products).")");
            $data = [];
            while(!$result->EOF){
                $data[$result->fields['products_id']][] = array(
                    'options_id' => $result->fields['options_id'],
                    'options_values_id' => $result->fields['options_values_id'],
                    'products_options_status' => $result->fields['products_options_status'],
                    'products_options_type' => $result->fields['products_options_type'],
                );
                $result->MoveNext();
            }
            if(count($data)){
                foreach($data as $pid=>$pValue){
                    $verify_is_custom = $attr = array();
                    foreach($pValue as $key=>$value){
                        if ($value['options_id'] && $value['options_values_id'] && ($value['products_options_status'] || $value['options_id'] == 34) && !in_array($value['products_options_type'], array(1, 4))) {
                            if (!in_array($value['options_id'], $verify_is_custom)) {  //存在同一属性   对应多个属性值的  则是定制拆分id
                                $verify_is_custom[] = $value['options_id'];
                            } else {
                                if (!in_array($pid, self::$match_custom_products)) {
                                    self::$match_custom_products[] = $pid;
                                }
                            }
                            $attr[] = $value['options_values_id'];
                        }
                    }
                    $productsAttr[$pid] = $attr;
                }
            }
        }
        return $productsAttr;
    }
}

?>
