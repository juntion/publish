<?php

use App\Services\Inquiry\InquiryRequestService;
use classes\custom\FsCustomRelate;
// 用户报价
class inquiry extends base
{
    public $wholesaleproducts;
    public $currencies;
    public $optionArr;
    public $contents;
    public $total;
    public $target_price;
    public $cartID;
    public $level_total;
    public $columnID;
    public $free_shipping_item;
    public $products_data;
    public $total_qty = 0;


    public function __construct($currencies,$inquiry_cart_session=array()){
        if(sizeof($inquiry_cart_session)){
            $this->total = $inquiry_cart_session['total']?$inquiry_cart_session['total']:0;
            $this->contents = $inquiry_cart_session['contents']?$inquiry_cart_session['contents']:[];
            $this->cartID = $inquiry_cart_session['cartID']?$inquiry_cart_session['cartID']:0;
        }
        $this->currencies = $currencies?$currencies:'';
    }

    //报价购物车数据同步：session->数据表，对比购物车session及数据表，session中新增数据写入数据表后再将最新数据写入session
    function restore_contents($type=0)
    {
        global $db;

        if (!$_SESSION['customer_id']) return false;
        // insert current cart contents in database
        $inquiry_id = $db->Execute("select id from customer_inquiry where status=5 and customers_id=".$_SESSION['customer_id']." limit 1")->fields['id'];
        if(!$inquiry_id){
            // 添加主表customer_inquiry
            $time = date('Y-m-d H:i:s');
            $inquiry_arr = array(
                'customers_id' => $_SESSION['customer_id'],
                'status' => 5,
                'created_at' => $time,
                'updated_at' => $time,
                'language_id' => $_SESSION['languages_id'],
                'language_code' => $_SESSION['languages_code'],
            );
            zen_db_perform('customer_inquiry', $inquiry_arr);
            $inquiry_id = $db->insert_ID();
        }

        $products_arr = $this->get_products();

        if (is_array($this->contents)) {
            foreach ($this->contents as $products_id => $value) {
                $qty = $this->contents[$products_id]['qty'];
                //查询用户是否第一次加入新报价
                $product_query = "select products_id,product_num from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                            where attribute_product_id = '" . zen_db_input($products_id) . "'  and inquiry_id=" . $inquiry_id . "";

                $product = $db->getAll($product_query);

                if (count($product) <= 0) {
                    $is_customized = 0;
                    if (strpos($products_id, ":") !== false) {
                        $is_customized = 1;
                    }
                    $product_price = 0;
                    $product_final_price =0;
                    foreach ($products_arr as $k => $v) {
                        if ($v['id'] == $products_id) {
                            $product_price = $v['price'];
                            if($v['attributes']) {
                                $attributes_all = array(
                                    'attributes' => $v['attributes'],
                                    'attributes_column' => $v['columnId'],
                                );
                            }
                            $product_price_arr = $this->get_product_price_str((int)$products_id,$v['price'],$attributes_all,$v['tax_class_id']);
                        }
                    }

                    $sql = "insert into " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . " (inquiry_id,all_product_price_dollar,final_product_price_dollar,all_product_price,final_product_price,updated_person,product_price,price_code,products_id,attribute_product_id, product_num,updated_at,is_customized)
                            values (" . $inquiry_id . "," . $product_price_arr['products_price_original'] . "," . $product_price_arr['products_price_finial'] . "," . $product_price_arr['products_price_original_current'] . "," . $product_price_arr['products_price_finial_current'] . "," . $_SESSION['customer_id'] . "," . $product_price . ",'" . $_SESSION['currency'] . "'," . zen_db_input((int)$products_id) . ", '" . zen_db_input($products_id) . "'," . $qty . ", '" . date('Y-m-d H:i:s') . "','" . $is_customized . "')";
                    $db->Execute($sql);
                    $inquiry_products_id = $db->insert_ID();

                    if (isset($this->contents[$products_id]['attributes'])) {
                        reset($this->contents[$products_id]['attributes']);
                        while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                            $value = (int)$value;
                            //clr 031714 udate query to include attribute value. This is needed for text attributes.
                            $attr_value = $this->contents[$products_id]['attributes_values'][$option];
                            if ($attr_value) {
                                $attr_value = zen_db_input($attr_value);
                            }
                            if ($option == 'length') {
                                $sql = "insert  into customer_inquiry_products_length  (products_id,length_name,product_length_id,inquiry_products_id) values ('" . zen_db_input($products_id) . "','$option','$value','$inquiry_products_id')";
                                $db->query($sql);
                            } else {
                                $columnID = 0;
                                if ($this->columnID[$products_id][(int)$option][(int)$value]) {
                                    $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                }
//                                if(is_numeric($columnID)){
                                $sql = "insert into " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                                    (products_id, options_id,column_id,
                                     options_value_id, options_value_text,inquiry_products_id)
                                     values ('" . zen_db_input((int)$products_id) . "', '" .
                                    $option . "'," . $columnID . ", '" . $value . "', '" . $attr_value . "'," . $inquiry_products_id . ")";
                                $db->Execute($sql);
//                                }
                            }
                        }
                    }
                } else {
                    $product_num = $product[0]['product_num'];
                    if ($product_num) {
                        $qty = $qty + (int)$product_num;
                    }
                    $data = array("product_num" => (float)$qty);
                    zen_db_perform(TABLE_CUSTOMER_INQUIRY_PRODUCTS, $data, 'update', "attribute_product_id='".zen_db_input($products_id)."' and inquiry_id=" . $inquiry_id);
                }
            }
        }

//      reset per-session cart contents, but not the database contents
        $this->reset(false);

        $this->columnID = array();
        $products_query = "select id,attribute_product_id,product_num,target_price
                         from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                         where inquiry_id = '" . (int)$inquiry_id . "'";

        $products = $db->Execute($products_query);

        //验证属性产品的属性项是否存在
        while (!$products->EOF) {
            $this->contents[$products->fields['attribute_product_id']] = array('qty' => $products->fields['product_num'],'target_price'=>$products->fields['target_price']);
            $attributes = $db->Execute("select options_id, options_value_id, options_value_text,column_id
                             from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                             where inquiry_products_id = '" . $products->fields['id'] . "'
                             and products_id = '" . zen_db_input($products->fields['attribute_product_id']) . "'");

            $ovflag = true;
            while (!$attributes->EOF) {
                $option_id = fs_get_data_from_db_fields('products_options_id','products_options','language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$attributes->fields['options_id'],'limit 1');

                $value_id = 0;
                $valueRes = $db->Execute("select count(*) as total from products_options_values where language_id=".$_SESSION['languages_id']."  and products_options_values_id=".$attributes->fields['options_value_id']." limit 1");
                if($valueRes->RecordCount()){
                    $value_id = $valueRes->fields['total'];
                }

                //判断该产品的该属性项以及属性值是否都存在，任何一个不存在此产品就需要删除
                if((!$option_id) || (!$value_id)){
                    $ovflag = false;
                }

                $this->contents[$products->fields['attribute_product_id']]['attributes'][$attributes->fields['options_id']] = $attributes->fields['options_value_id'];
                //CLR 020606 if text attribute, then set additional information
                if ($attributes->fields['options_value_id'] == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                    $this->contents[$products->fields['attribute_product_id']]['attributes_values'][$attributes->fields['options_id']] = $attributes->fields['options_value_text'];
                }
                $this->columnID[$products->fields['attribute_product_id']][(int)$attributes->fields['options_id']][$attributes->fields['options_value_id']] =  $attributes->fields['column_id'];
                $attributes->MoveNext();
            }
            if($ovflag){
                //
                $length_list = $db->getAll("select product_length_id from customer_inquiry_products_length where products_id = '" . $products->fields['products_id'] . "' limit 1");
                if ($length_list) {
                    $this->contents[$products->fields['attribute_product_id']]['attributes']['length'] = $length_list[0]['product_length_id'];
                }
                //$this->contents[$products->fields['products_id']]['fiber_count'] = set_fibers_count_attribute($products->fields['products_id'], $this->contents[$products->fields['products_id']]['attributes']);
            }else{
                $this->remove($products->fields['attribute_product_id']);
            }
            $products->MoveNext();
        }
    }

    //报价购物车数据同步：session->数据表，对比购物车session及数据表，session中新增数据写入数据表后再将最新数据写入session
    function restore_contents_submit($type=0, $status = 5)
    {
        global $db;

        if (!$_SESSION['customer_id']) return false;
        // insert current cart contents in database
        $inquiry_id = $db->Execute(sprintf("select `id` from customer_inquiry where `status` = %d and `customers_id` = %d limit 1", $status, $_SESSION['customer_id']))->fields['id'];

        if(!$inquiry_id){
            // 添加主表customer_inquiry
            $time = date('Y-m-d H:i:s');
            $inquiry_arr = array(
                'customers_id' => $_SESSION['customer_id'],
                'status' => $status,
                'created_at' => $time,
                'updated_at' => $time,
                'language_id' => $_SESSION['languages_id'],
                'language_code' => $_SESSION['languages_code'],
            );

            zen_db_perform('customer_inquiry', $inquiry_arr);
            $inquiry_id = $db->insert_ID();
        }

        //定制产品匹配标准产品
        $attr_product_id="";
        $a='';
        foreach ($this->contents as $key=>$val){
            if($val['qty']>0){
                if($val['attributes']){
                    $attr_option="";
                    $len='';
                    $attr=[];
                    $pro_attributes =[];
                    if(!empty($val['attributes'])){
                        while (list($option, $value) = each($val['attributes'])) {
                            if($option!="length"){
                                if (!strstr($option, TEXT_PREFIX)) {
                                    if (strstr($option,"_chk")) {
//                             reset($value);
                                        $attr_option = "_chk".$value;
                                        $option = str_replace($attr_option,'',$option);
                                        $attr[] = $value;
                                        if(!empty($pro_attributes[$option])){
                                            $pro_attributes[$option] = array($value=>$value)+$pro_attributes[$option];
                                        }else{
                                            $pro_attributes[$option] = array($value=>$value);
                                        }
                                    }else{
                                        $pro_attributes[$option] = $value;
                                        $attr[] = $value;
                                    }
                                } else {
                                    $pro_attributes[$option] = $value;
                                    $attr[] = $value;
                                }
                            }else{
                                $pro_attributes['length'] = $value;
                                $len = fs_get_data_from_db_fields('length','products_length','id='.$value,'limit 1');
                            }
                        }

                        $class = new FsCustomRelate((int)$key, $attr, $len);
                        $excellentMatch = $class->handle();
                        $match_status = 0;
                        if($excellentMatch[0]){
                            $match_status = get_product_status($excellentMatch[0]);
                        }

                        if ($excellentMatch[0] && $match_status) {

                            if(!empty($this->contents[$excellentMatch[0]])){
                                $this->contents[$excellentMatch[0]]['qty']=$this->contents[$excellentMatch[0]]['qty']+$this->contents[$key]['qty'];
                                unset($this->contents[$key]);
                            }else{
                                $this->contents[$excellentMatch[0]]['qty'] = $this->contents[$key]['qty'];
                                unset($this->contents[$key]);
                            }
                        }else{
                            $attr_product_id = zen_get_uprid((int)$key, $pro_attributes);
                            if($attr_product_id && empty($this->contents[$attr_product_id])){
                                $this->contents[$attr_product_id]=$this->contents[$key];
                                unset($this->contents[$key]);
                            }else{
                                $this->contents[$attr_product_id]['qty']=$this->contents[$key]['qty']+$this->contents[$attr_product_id]['qty'];
                                unset($this->contents[$key]);
                            }
                        }
                    }
                }
            }
        }



        $products_arr = $this->get_products();

        if (is_array($this->contents)) {
            foreach ($this->contents as $products_id => $value) {
                if($value['color']){
                    $related_label_pid = fs_get_data_from_db_fields('related_label_pid','products','products_id='.(int)$products_id,'limit 1');
                    if((int)$related_label_pid){
                        $this->add_inquiry_cart($related_label_pid,1, $value['color'], true);
                    }
                }
                if((int)$this->contents[$products_id]['qty']>0){
                $qty = $this->contents[$products_id]['qty'];
                //查询用户是否第一次加入新报价
                $product_query = "select products_id,product_num from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                            where attribute_product_id = '" . zen_db_input($products_id) . "'  and inquiry_id=" . $inquiry_id . "";

                $product = $db->getAll($product_query);

                if (count($product) <= 0) {
                    $is_customized = 0;
                    if (strpos($products_id, ":") !== false) {
                        $is_customized = 1;
                    }
                    $product_price = 0;
                    $product_final_price =0;
                    foreach ($products_arr as $k => $v) {
                        if ($v['id'] == $products_id) {
                            $product_price = $v['price'];
                            if($v['attributes']) {
                                $attributes_all = array(
                                    'attributes' => $v['attributes'],
                                    'attributes_column' => $v['columnId'],
                                );
                            }
                            $product_price_arr = $this->get_product_price_str((int)$products_id,$v['price'],$attributes_all,$v['tax_class_id']);
                        }
                    }


                    if (isset($this->contents[$products_id]['attributes'])) {
                        $sql = "insert into " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . " (inquiry_id,all_product_price_dollar,final_product_price_dollar,all_product_price,final_product_price,updated_person,product_price,price_code,products_id,attribute_product_id, product_num,updated_at,is_customized)
                            values (" . $inquiry_id . "," . $product_price_arr['products_price_original'] . "," . $product_price_arr['products_price_finial'] . "," . $product_price_arr['products_price_original_current'] . "," . $product_price_arr['products_price_finial_current'] . "," . $_SESSION['customer_id'] . "," . $product_price . ",'" . $_SESSION['currency'] . "'," . zen_db_input((int)$products_id) . ", '" . zen_db_input($products_id) . "'," . $qty . ", '" . date('Y-m-d H:i:s') . "','" . $is_customized . "')";
                        $db->Execute($sql);
                        $inquiry_products_id = $db->insert_ID();

                        reset($this->contents[$products_id]['attributes']);
                        while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                            $value = (int)$value;
                            //clr 031714 udate query to include attribute value. This is needed for text attributes.
                            $attr_value = $this->contents[$products_id]['attributes_values'][$option];
                            if ($attr_value) {
                                $attr_value = zen_db_input($attr_value);
                            }
                            if ($option == 'length') {
                                $sql = "insert  into customer_inquiry_products_length  (products_id,length_name,product_length_id,inquiry_products_id) values ('" . zen_db_input($products_id) . "','$option','$value','$inquiry_products_id')";
                                $db->query($sql);
                            } else {
                                $columnID = 0;
                                if ($this->columnID[$products_id][(int)$option][(int)$value]) {
                                    $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                }
//                                if(is_numeric($columnID)){
                                $sql = "insert into " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                                    (products_id, options_id,column_id,
                                     options_value_id, options_value_text,inquiry_products_id)
                                     values ('" . zen_db_input((int)$products_id) . "', '" .
                                    $option . "'," . $columnID . ", '" . $value . "', '" . $attr_value . "'," . $inquiry_products_id . ")";
                                $db->Execute($sql);
//                                }
                            }
                        }
                    }else{
                        $this->add_inquiry_product($products_id,$qty,1, falae, '', $status);
                    }
                } else {
                    $product_num = $product[0]['product_num'];
                    if ($product_num) {
                        $qty = $qty + (int)$product_num;
                    }
                    $data = array("product_num" => (float)$qty, "target_price" => "");
                    zen_db_perform(TABLE_CUSTOMER_INQUIRY_PRODUCTS, $data, 'update', "attribute_product_id='".zen_db_input($products_id)."' and inquiry_id=" . $inquiry_id);
                }
            }

            }
        }

//      reset per-session cart contents, but not the database contents
        $this->reset(false);

        $this->columnID = array();
        $products_query = "select id,attribute_product_id,product_num,target_price
                         from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                         where inquiry_id = '" . (int)$inquiry_id . "'";

        $products = $db->Execute($products_query);

        //验证属性产品的属性项是否存在
        while (!$products->EOF) {
            $this->contents[$products->fields['attribute_product_id']] = array('qty' => $products->fields['product_num'],'target_price'=>$products->fields['target_price']);
            $attributes = $db->Execute("select options_id, options_value_id, options_value_text,column_id
                             from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                             where inquiry_products_id = '" . $products->fields['id'] . "'
                             and products_id = '" . zen_db_input($products->fields['attribute_product_id']) . "'");

            $ovflag = true;
            while (!$attributes->EOF) {
                $option_id = fs_get_data_from_db_fields('products_options_id','products_options','language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$attributes->fields['options_id'],'limit 1');

                $value_id = 0;
                $valueRes = $db->Execute("select count(*) as total from products_options_values where language_id=".$_SESSION['languages_id']."  and products_options_values_id=".$attributes->fields['options_value_id']." limit 1");
                if($valueRes->RecordCount()){
                    $value_id = $valueRes->fields['total'];
                }

                //判断该产品的该属性项以及属性值是否都存在，任何一个不存在此产品就需要删除
                if((!$option_id) || (!$value_id)){
                    $ovflag = false;
                }

                $this->contents[$products->fields['attribute_product_id']]['attributes'][$attributes->fields['options_id']] = $attributes->fields['options_value_id'];
                //CLR 020606 if text attribute, then set additional information
                if ($attributes->fields['options_value_id'] == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                    $this->contents[$products->fields['attribute_product_id']]['attributes_values'][$attributes->fields['options_id']] = $attributes->fields['options_value_text'];
                }
                $this->columnID[$products->fields['attribute_product_id']][(int)$attributes->fields['options_id']][$attributes->fields['options_value_id']] =  $attributes->fields['column_id'];
                $attributes->MoveNext();
            }
            if($ovflag){
                //
                $length_list = $db->getAll("select product_length_id from customer_inquiry_products_length where products_id = '" . $products->fields['products_id'] . "' limit 1");
                if ($length_list) {
                    $this->contents[$products->fields['attribute_product_id']]['attributes']['length'] = $length_list[0]['product_length_id'];
                }
                //$this->contents[$products->fields['products_id']]['fiber_count'] = set_fibers_count_attribute($products->fields['products_id'], $this->contents[$products->fields['products_id']]['attributes']);
            }else{
                $this->remove($products->fields['attribute_product_id']);
            }
            $products->MoveNext();
        }
    }

    //报价购物车数据同步：数据表->session，清空购物车session，将购物车表数据写入session
    function store_contents($type=0)
    {
        global $db;
        if (!$_SESSION['customer_id']) return false;

        $this->reset(false);//只清除购物车session数据
        $this->columnID = array();
        $inquiry_id = $db->Execute("select id from customer_inquiry where status=5 and customers_id=".$_SESSION['customer_id']." limit 1")->fields['id'];
        if(!$inquiry_id){
            // 添加主表customer_inquiry
            $time = date('Y-m-d H:i:s');
            $inquiry_arr = array(
                'customers_id' => $_SESSION['customer_id'],
                'status' => 5,
                'created_at' => $time,
                'updated_at' => $time,
                'language_id' => $_SESSION['languages_id'],
                'language_code' => $_SESSION['languages_code'],
            );
            zen_db_perform('customer_inquiry', $inquiry_arr);
            $inquiry_id = $db->insert_ID();
        }
        $products_query = "select id,products_id,attribute_product_id,product_num,target_price 
                         from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                         where inquiry_id =".$inquiry_id."";

        $products = $db->Execute($products_query);

        while (!$products->EOF) {
            if(!$products->fields['attribute_product_id']){
                $products->fields['attribute_product_id'] = $products->fields['products_id'];
            }
            $this->contents[$products->fields['attribute_product_id']] = array('qty' => $products->fields['product_num'],'target_price'=>$products->fields['target_price']);
            $attributes = $db->Execute("select options_id, options_value_id, options_value_text,column_id
                             from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                             where  products_id = '" . zen_db_input($products->fields['products_id']) . "' and inquiry_products_id=".$products->fields['id']."");
            $ovflag = true;

            while (!$attributes->EOF) {
                $option_id = fs_get_data_from_db_fields('products_options_id','products_options','language_id='.$_SESSION['languages_id'].' and products_options_id='.(int)$attributes->fields['options_id'],'limit 1');
                $value_id = 0;
                $valueRes = $db->Execute("select count(*) as total from products_options_values where language_id=".$_SESSION['languages_id']."  and products_options_values_id=".$attributes->fields['options_value_id']." limit 1");
                if($valueRes->RecordCount()){
                    $value_id = $valueRes->fields['total'];
                }

                //判断该产品的该属性项以及属性值是否都存在，任何一个不存在此产品就需要删除
                if((!$option_id) || (!$value_id)){
                    $ovflag = false;
                }
                if(!empty($this->contents[$products->fields['attribute_product_id']]['attributes'][$attributes->fields['options_id']])){
                    $this->contents[$products->fields['attribute_product_id']]['attributes'][$attributes->fields['options_id']."_chk".$attributes->fields['options_value_id']] = $attributes->fields['options_value_id'];
                }else{
                    $this->contents[$products->fields['attribute_product_id']]['attributes'][$attributes->fields['options_id']] = $attributes->fields['options_value_id'];
                }
                //CLR 020606 if text attribute, then set additional information
                if ($attributes->fields['options_value_id'] == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                    $this->contents[$products->fields['attribute_product_id']]['attributes_values'][$attributes->fields['options_id']] = $attributes->fields['options_value_text'];
                }
                $this->columnID[$products->fields['attribute_product_id']][(int)$attributes->fields['products_options_id']][$attributes->fields['options_value_id']] =  $attributes->fields['column_id'];


                $attributes->MoveNext();
            }
            if($ovflag){
                $length_list = $db->getAll("select product_length_id from customer_inquiry_products_length where products_id = '" . $products->fields['products_id'] . "'  and inquiry_products_id=".$products->fields['id']."  limit 1");
                if ($length_list) {

                    $this->contents[$products->fields['attribute_product_id']]['attributes']['length'] = $length_list[0]['product_length_id'];
                }
                // $this->contents[$products->fields['products_id']]['fiber_count'] = set_fibers_count_attribute($products->fields['products_id'], $this->contents[$products->fields['products_id']]['attributes']);
            }else{
                $this->remove($products->fields['attribute_product_id']);
            }
            $products->MoveNext();
        }
        $data=[];
        //合并报价购物车相同数据
//        foreach ($this->contents as $k=>$v){
//            //储存第一次产品出现的数据
//            if(strstr($k,":")!=false){
//                if(!$data[(int)$k]){
//                    $data[(int)$k] = array(
//                        "attr_id"=>$k
//                    );
//                }else{
//                    //定制产品，第二次出现
//                    $this->contents[$data[(int)$k]['attr_id']]['qty'] =  $this->contents[$data[(int)$k]['attr_id']]['qty'] + $v['qty'];
//                    unset($this->contents[$k]);
//                }
//            }
//        }
        $this->cartID = $this->generate_cart_id();
//        $this->cleanup();

        return $this->contents;
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
        $this->contents = array();
        $this->total = 0;
        $this->weight = 0;
        $this->content_type = false;

        // shipping adjustment
        $this->free_shipping_item = 0;
        $this->free_shipping_price = 0;
        $this->free_shipping_weight = 0;

        if (isset($_SESSION['customer_id']) && ($reset_database == true)) {
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'  and save_type=$type";

            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'  and save_type=$type";

            $db->Execute($sql);

            $sql = "delete from customers_basket_length
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'  and save_type=$type";
            $db->Execute($sql);

            // fairy 2019.3.15
            // 折扣 购物车和see for later 是共享的，因此没有save_type
            // 清空购物车时候一定要把报价的折扣清除掉
            $sql = "delete from customers_basket_reorder_order
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'";
            $db->Execute($sql);

            // 清空购物车时候一定要把reorder的折扣清除掉
            $sql = "delete from customers_basket_reorder_quotation
                where customers_id = '" . (int)$_SESSION['customer_id'] . "'";
            $db->Execute($sql);
        }

        unset($this->cartID);
        $_SESSION['cartID'] = '';
    }

    /*
     * 获取产品打印连接参数
     * */
    function get_all_products_str(){
        $contents = $this->contents;
        $columnID = $contents['attributes_values'];
        $list = '';
        if($contents){
            foreach($contents as $key=>$value){
                $list .= $key.':'.$value['qty'];
                if($value['attributes']){
                    foreach($value['attributes'] as $k=>$v){
                        $k = str_replace("_","/",$k);
                        if($v==0){
                            $list .= '_' . $k . ':{' .$value['attributes_values'][$k].'}';
                        }else{
                            $list .= '_'.$k.':'.$v;
                        }
                        if($columnID[$key][(int)$k][$v]){
                            $list .= '-'.$columnID[$key][(int)$k][$v];
                        }
                    }
                }
                $list .= '|';
            }
        }
        $list_str = substr($list,0,count($list)-2);
        return $list_str;
    }
    /**
     * 定制产品查询是否已存在
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
     * 获取产品数量
     * Method to get the quantity of an item in the cart
     *
     * @param mixed product ID of item to check
     * @return decimal the quantity of the item
     */
    function get_quantity($products_id)
    {
        if (isset($this->contents[$products_id])) {
            return $this->contents[$products_id]['qty'];
        } else {
            return 0;
        }
    }

    /**
     * calculate quantity adjustments based on restrictions
     * USAGE:  $qty = $this->adjust_quantity($qty, (int)$products_id, 'shopping_cart');
     *
     * @param float $check_qty
     * @param int $products
     * @param string $message
     */
    function adjust_quantity($check_qty, $products, $stack = 'inquiry_cart')
    {
        global $messageStack;
        if ($stack == '' || $stack == FALSE) $stack = 'inquiry_cart';
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

    /**
     * 定制产品加入报价购物车 ternence 2019/3/28
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
     * @return void
     * @global object access to the db object
     *
     */
    function add_inquiry_cart($products_id, $qty = '1', $attributes = '', $notify = true, $id_column = array(),$type=0)
    {
        global $db;
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
        if ($notify == true) {
            $_SESSION['new_products_id_in_cart'] = $products_id;
        }
        $qty = $this->adjust_quantity($qty, $products_id, 'inquiry_cart');

        if ($this->in_cart($products_id)) {
            //如果存在报价购物车则修改数量
            $this->update_quantity($products_id, $qty, $attributes);
        } else {
            $this->contents[$products_id] = array('qty' => (float)$qty);
            if (is_array($attributes)) {
                reset($attributes);
                //插入数据库
                if(isset($_SESSION['customer_id'])){
                    $inquiry_products_id = $this->add_inquiry_product($products_id,$qty,1,true,$attributes);

                }

                while (list($option, $value) = each($attributes)) {
                    //CLR 020606 check if input was from text box.  If so, store additional attribute information
                    //CLR 020708 check if text input is blank, if so do not add to attribute lists
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
                        // insert into database
                        //CLR 020606 update db insert to include attribute value_text. This is needed for text attributes.
                        //CLR 030228 add zen_db_input() processing
                        if (isset($_SESSION['customer_id'])) {

                            //if (zen_session_is_registered('customer_id')) zen_db_query("insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text) values ('" . (int)$customer_id . "', '" . zen_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "', '" . zen_db_input($attr_value) . "')");
                            if (is_array($value)) {
                                reset($value);

                                while (list($opt, $val) = each($value)) {
                                    $columnID = 0;
                                    if($this->columnID[$products_id][(int)$option][(int)$val]){
                                        $columnID = $this->columnID[$products_id][(int)$option][(int)$val];
                                    }
                                    $this->contents[$products_id]['columnID']=$columnID;
                                    $sql = "insert into customer_inquiry_products_attributes
                                        ( products_id, options_id, options_value_id,column_id,inquiry_products_id)
                                        values ('" . zen_db_input((int)$products_id) . "', '" .
                                        (int)$option . '_chk' . (int)$val . "', '" . (int)$val . "',".$columnID.",".$inquiry_products_id.")";
                                    $db->Execute($sql);
                                }
                            } elseif ($option == 'length') {
                                $length = $db->Execute("select length from products_length where id=".$value."")->fields['length'];
                                $sql = "insert  into customer_inquiry_products_length  (inquiry_products_id,products_id,length_name,product_length_id,length) values ('" . $inquiry_products_id . "','" . zen_db_input((int)$products_id) . "','$option','$value','$length')";
                                $db->query($sql);
                            } else {
                                if ($attr_value) {
                                    $attr_value = zen_db_input($attr_value);
                                }else{
                                    $attr_value = 0;
                                }
                                $columnID = 0;
                                if($this->columnID[$products_id][(int)$option][(int)$value]){
                                    $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                }
                                $this->contents[$products_id]['columnID']=$columnID;
                                $sql = "insert into customer_inquiry_products_attributes
                                      ( products_id, options_id, options_value_id,column_id,inquiry_products_id,options_value_text)
                                      values ('" . zen_db_input((int)$products_id) . "', '" .
                                    (int)$option . "', '" . (int)$value . "',".$columnID.",".$inquiry_products_id.",'".$attr_value."')";
                                $db->Execute($sql);
                            }
                        }
                    }
                }
                if($inquiry_products_id){
                    $products_ar = $this->get_products();
                    foreach ($products_ar as $key=>$val){
                        if($val['id']==$products_id){
                            if($val['attributes']){
                                $attributes_all = array(
                                    'attributes' => $val['attributes'],
                                    'attributes_column' => $val['columnId'],
                                );
                            }
                            $product_price_arr = $this->get_product_price_str((int)$products_id,$val['price'],$attributes_all,$val['tax_class_id'],"",true);
                            $customer_guest = array(
                                'product_price' => $val['original_price'],
                                'all_product_price_dollar' => $product_price_arr['products_price_original'],
                                'final_product_price_dollar' => $product_price_arr['products_price_finial'],
                                'all_product_price' => $product_price_arr['products_price_original_current'],
                                'final_product_price' => $product_price_arr['products_price_finial_current'],
                            );
                            zen_db_perform(TABLE_CUSTOMER_INQUIRY_PRODUCTS, $customer_guest,'update','id = '.$inquiry_products_id);
                        }
                    }
                }
            }
        }
//        $this->cleanup();
        // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
        $this->cartID = $this->generate_cart_id();
    }


    /*
     * 报价产品购物车计算价格
     * */
    function calculate_for_separate()
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
        $qty =0;
        $target=0;
        if (!is_array($this->contents)) return 0;
        while (list($products_id,) = each($this->contents)) {
            $target = $this->contents[$products_id]['target_price']?$this->contents[$products_id]['target_price']:0;
            $qty = $this->contents[$products_id]['qty'];
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
                $products_price = zen_get_products_base_price_other($products_price);
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
                        $products_prices = get_customers_products_level_price($products_price + $this->attributes_price($products_id,$this->contents[$products_id],true) * $currencies_value,$_SESSION['member_level'],(int)$products_id);
                        $products_prices = $products_prices / $currencies_value;
                    }
                } else {
                    if ($product->fields['discount_price'] > 0) {
                        $products_prices = $product->fields['discount_price'];
                    } else {
                        $products_prices = $products_price / $currencies_value + $this->attributes_price($products_id,$this->contents[$products_id]);
                    }
                }

                $level_total = $products_price * $qty;
                $target_ic = $target * $qty;
                $total = $products_prices * $qty;
                $this->products_data[$products_id] = $total;
                $this->target_price += $target_ic;
                $this->total += $total;

                $this->level_total += $level_total / $currencies_value;
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
                                $new_attributes_price = $attribute_price->fields['options_values_price'];
                                $this->level_total -= $qty * $new_attributes_price;
                            } else {
                                $this->level_total -= $qty * $attribute_price->fields['options_values_price'];
                            }
                        } else {

                            if ($attribute_price->fields['attributes_discounted'] == '1') {
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

    /**判断报价产品是否存在报价购物车
     * Method to check whether a product exists in the cart
     *
     * @param mixed product ID of item to check
     * @return boolean
     */
    function in_cart($products_id)
    {
        if (isset($this->contents[$products_id])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 将产品插入报价购物车表 ternence 2019/3/28
     * @Insert the product into the quote cart
     * @table : customer_inquiry and customer_inquiry_products
     * @param array attributes
     * */
    function add_inquiry_product($products_id,$qty,$type=1,$attr=false,$attributes ='',$status = 5){
        global $db;
        if (isset($_SESSION['customer_id'])) {
            // 添加报价产品
            $time = date('Y-m-d H:i:s');
            //查询用户是否第一次加入报价
            $inquiry_id = $db->Execute("select id from customer_inquiry where status=".$status." and customers_id=".$_SESSION['customer_id']." limit 1")->fields['id'];

            if(!$inquiry_id){
                // 添加主表customer_inquiry
                $time = date('Y-m-d H:i:s');
                $inquiry_arr = array(
                    'customers_id' => $_SESSION['customer_id'],
                    'status' => $status,
                    'created_at' => $time,
                    'updated_at' => $time,
                    'language_id' => $_SESSION['languages_id'],
                    'language_code' => $_SESSION['languages_code'],
                );
                zen_db_perform('customer_inquiry', $inquiry_arr);
                $inquiry_id = $db->insert_ID();
            }
            if($type==1 && $attr==false){
                $this->contents[$products_id]=array('qty' => $qty);
            }
            //报价产品存表
            if($inquiry_id){
                $time = date('Y-m-d H:i:s');
                $products_arr = $this->get_products();
                // 将用户填写的价格转换成美元

                foreach ($products_arr as $key => $val) {
                    //将此产品加入报价购物车数据库
                    if($val['id']==$products_id){
                        if($val['attributes']){
                            $attributes_all = array(
                                'attributes' => $val['attributes'],
                                'attributes_column' => $val['columnId'],
                            );
                        }
                        $composite_str = $this->get_fmt_products_son_str($products_id , $qty,'',$attributes);

                        if($type==1){
                            $product_price_arr = $this->get_product_price_str((int)$products_id,$val['price'],$attributes_all,$val['tax_class_id'],"",true);
                            $is_customized=0;
                            if(strpos($products_id,":")!==false){
                                $is_customized=1;
                            }
                            $inquiry_arr = array(
                                'inquiry_id' => $inquiry_id,
                                'products_id' => (int)$products_id,
                                'attribute_product_id'=>$products_id,
                                'product_num' => $qty,
                                'product_price' => $val['original_price'],
                                'products_tax_class_id' => $val['tax_class_id'],
                                'created_person' => 0,
                                'updated_person' => 0,
                                'is_customized'=>$is_customized,
                                'created_at' => $time,
                                'updated_at' => $time,
                                'price_code' => $_SESSION['currency'],
                                'all_product_price_dollar' => $product_price_arr['products_price_original'],
                                'final_product_price_dollar' => $product_price_arr['products_price_finial'],
                                'all_product_price' => $product_price_arr['products_price_original_current'],
                                'final_product_price' => $product_price_arr['products_price_finial_current'],
                                'combination_info' => $composite_str,
                                'combination_origin_info' => $composite_str
                            );

                            zen_db_perform(TABLE_CUSTOMER_INQUIRY_PRODUCTS, $inquiry_arr);
                            $this->contents[$products_id]['qty'] = (float)$qty;
                            return $db->insert_ID();
                        }else{
                            $product_inquiry_id = $db->Execute("select id from customer_inquiry_products where products_id=".(int)$products_id." and inquiry_id=".$inquiry_id." limit 1")->fields['id'];
                            $inquiry_arr=array(
                                'product_num'=>$qty,
                                'combination_info' => $composite_str,
                                'combination_origin_info' => $composite_str
                            );
                            zen_db_perform(TABLE_CUSTOMER_INQUIRY_PRODUCTS, $inquiry_arr,"update",'id='.$product_inquiry_id);
                            $this->contents[$products_id]['qty'] = (float)$qty;
                            return $product_inquiry_id;
                        }
                    }
                }

            }
        }
        $this->cartID = $this->generate_cart_id();
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
        if (empty($quantity)) return true; // nothing needs to be updated if theres no quantity, so we return true..

        //reorder 的quotation 产品不准修改数量
//        if (isset($this->contents[$products_id]['reoder_type']) && $this->contents[$products_id]['reoder_type'] == 'quotation'){return true;}
//
//        $fiber_count = isset($this->contents[$products_id]['fiber_count']) ? $this->contents[$products_id]['fiber_count'] : "";
        $this->contents[$products_id]['qty'] = (float)$quantity;
//        $this->contents[$products_id]['fiber_count'] = $fiber_count;
        // update database

        if (isset($_SESSION['customer_id'])) {
            $inquiry_id = $db->Execute("select id from customer_inquiry where status=5 and customers_id=".$_SESSION['customer_id']." limit 1")->fields['id'];
            $composite_str = $this->get_fmt_products_son_str($products_id , $quantity);
            $sql = "update " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                set 
                product_num = " .$quantity . "
                , combination_info = '" .$composite_str . "'
                , combination_origin_info = '" .$composite_str . "'
                where inquiry_id = " . $inquiry_id . "
                and  attribute_product_id = '" . zen_db_input($products_id) . "'";
            $db->Execute($sql);
            if (is_array($attributes)) {
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
                        $products_inquiry_id = $db->Execute("select id from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . " where inquiry_id=".$inquiry_id." and attribute_product_id = '".zen_db_input($products_id)."'")->fields['id'];
                        if (is_array($value)) {
                            reset($value);
                            while (list($opt, $val) = each($value)) {
                                $sql = "update " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                            set options_value_id = '" . (int)$val . "'
                            where inquiry_products_id = ".$products_inquiry_id." 
                            and products_id = '" . zen_db_input($products_id) . "'
                            and options_id = '" . (int)$option . '_chk' . (int)$val . "'";
                                $db->Execute($sql);
                            }
                        } elseif ($option == 'length') {
                            if (isset($_SESSION['customer_id'])) {
                                $sql = "update customer_inquiry_products_length set product_length_id = '" . (int)$value . "' where inquiry_products_id = " . $products_inquiry_id . "
                        and products_id = '" . zen_db_input((int)$products_id) . "'";
                                $db->Execute($sql);
                            }
                        } else {
                            if (isset($_SESSION['customer_id'])) {
                                $sql = "update " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                        set options_value_id = '" . (int)$value . "', options_value_text = '" . $attr_value . "'
                        where inquiry_products_id = ".$products_inquiry_id."
                        and products_id = '" . zen_db_input((int)$products_id) . "'
                        and options_id = '" . (int)$option . "'";
                                $db->Execute($sql);
                            }
                        }
                    }
                }
            }
        }

        $this->contents[$products_id]['qty'] = (float)$quantity;
        $this->cartID = $this->generate_cart_id();
    }


    /** add ternence.qin 2019/4/29
     * Validation of the currency
     * If there is a currency inconsistent with the current site restore currency price
     */
    function  verify_product_price($inquiry_id){
        global $db;
        $products =$this->get_products();
        if(is_numeric($inquiry_id)){
            $productArr= $db->getAll("select id,attribute_product_id from ".TABLE_CUSTOMER_INQUIRY_PRODUCTS." where inquiry_id =".$inquiry_id." and price_code!='".$_SESSION['currency']."'");
            if($productArr){
                foreach ($productArr as $k=>$v){
                    foreach ($products as $key=>$val){
                        if($val['id']==$v['attribute_product_id']){
                            if($val['attributes']){
                                $attributes_all = array(
                                    'attributes' => $val['attributes'],
                                    'attributes_column' => $val['columnId'],
                                );
                            }

                            $product_price_arr = $this->get_product_price_str((int)$val['id'],$val['price'],$attributes_all,$val['tax_class_id'],"",true);
                            $customer_guest = array(
                                'price_code'=> $_SESSION['currency'],
                                'product_price' => $val['price'],
                                'all_product_price_dollar' => $product_price_arr['products_price_original'],
                                'final_product_price_dollar' => $product_price_arr['products_price_finial'],
                                'all_product_price' => $product_price_arr['products_price_original_current'],
                                'final_product_price' => $product_price_arr['products_price_finial_current'],
                            );
                            zen_db_perform(TABLE_CUSTOMER_INQUIRY_PRODUCTS, $customer_guest,'update','id = '.$v['id']);
                        }
                    }
                }
            }
        }

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
        //删除方法 改
        global $db;
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
    }

    /**
     * Method to return details of all products in the cart
     *
     * @param boolean whether to check if cart contents are valid
     * @return array
     */
    function get_products($check_for_valid_cart = false)
    {
        global $db;
        $products_array = array();
        $wholesale_products = fs_get_wholesale_products_array();
        if (!is_array($this->contents)) return false;

        //如果需要排序 则重新给购物车产品排序
//        if($this->is_need_order_by()){
//            $this->products_order_by();
//        }

        reset($this->contents);  //此步不能少  将指针指到数组头

        while (list($products_id,) = each($this->contents)) {

            $products_query = "select p.products_id,p.discount_price,p.master_categories_id, p.products_status,p.products_model, p.products_image,
                                  p.products_price, p.products_weight, p.products_tax_class_id,
                                  p.products_quantity_order_min, p.products_quantity_order_units,
                                  p.product_is_free, p.products_priced_by_attribute,
                                  p.products_discount_type, p.products_discount_type_from,p.discount_price
                           from " . TABLE_PRODUCTS . " p
                           where p.products_id = '" . (int)$products_id . "'";

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
                $check_unit_decimals = zen_get_products_quantity_order_units((int)$products->fields['products_id']);
                if (strstr($check_unit_decimals, '.')) {
                    $new_qty = round($new_qty, QUANTITY_DECIMALS);
                } else {
                    $new_qty = round($new_qty, 0);
                }

                if ($new_qty == (int)$new_qty) {
                    $new_qty = (int)$new_qty;
                }

                $prid = $products->fields['products_id'];
                $wholesale_price = zen_get_products_base_price_other($products->fields['products_price']);
                $products_price = $wholesale_price;

                if ($check_for_valid_cart == true) {
                    $fix_once = 0;
                    $check_status = $products->fields['products_status'];
                    //2019.4.11 进入购物车时判断商品是否下架 pico
                    if ($check_status == 0) {
                        $fix_once++;
                        $_SESSION['valid_to_checkout'] = false;
                        $_SESSION['cart_errors'] .= ERROR_PRODUCT . $products->fields['products_name'] . ERROR_PRODUCT_STATUS_SHOPPING_CART . '<br />';

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
                $check_unit_decimals = zen_get_products_quantity_order_units((int)$products->fields['products_id']);
                if (strstr($check_unit_decimals, '.')) {
                    $new_qty = round($new_qty, QUANTITY_DECIMALS);
                } else {
                    $new_qty = round($new_qty, 0);
                }

                if ($new_qty == (int)$new_qty) {
                    $new_qty = (int)$new_qty;
                }
                $discount_product = get_discount_product_qty($products_id);

                $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);

                // fairy 2019.2.21 add 组合产品主产品价格
                //属性值数组  方便有属性的组合产品计算价格使用  2019.10.29
                $combination_arr = array();
                $attr_str = '';
                if($this->contents[$products_id]['attributes']){
                    foreach ($this->contents[$products_id]['attributes'] as $value){
                        $combination_arr[] = (int)$value;
                    }
                }
                if($combination_arr){
                    $attr_str = reorder_options_values($combination_arr);
                }
                $is_composite_products = false;
                if (class_exists('classes\CompositeProducts')) {
                    $CompositeProducts = new classes\CompositeProducts(intval($products_id),'',$attr_str);
                    $composite_product_price = $CompositeProducts->get_composite_product_price(true);
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
                        if($this->contents[$products_id]['reoder_type'] == 'quotation')
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

                    if (!in_array((int)$products_id, $wholesale_products)) {
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
                    $attributes_price = $this->attributes_price($products_id,$this->contents[$products_id],true);
                    if (isset($_SESSION['member_level'])) {
                        $products_prices = get_customers_products_level_price($products_price + $attributes_price * $currencies_value, $_SESSION['member_level'],(int)$products_id);
                        $products_prices = $products_prices / $currencies_value;

                    } else {
                        $products_prices = $products_price / $currencies_value + $attributes_price;
                    }

                    //如果产品的报价 比产品的优化价低  那么使用产品的 报价
                    if (isset($this->contents[$products_id]['reoder_type']) && in_array($this->contents[$products_id]['reoder_type'],array('quotation','order'))
                        && $this->contents[$products_id]['reoder_price'] > 0 && $products_prices > $this->contents[$products_id]['reoder_price']){
                        $reoder_info_length = count($this->contents[$products_id]['reoder_info']);
                        if($this->contents[$products_id]['reoder_type'] == 'order'){
                            $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
                        }elseif($this->contents[$products_id]['reoder_type'] == 'quotation'){
                            $reoder_info_length = count($this->contents[$products_id]['reoder_info']);
                            if($this->contents[$products_id]['qty'] >= $this->contents[$products_id]['reoder_info'][$reoder_info_length-1]['products_quantity']){
                                $products_prices = zen_get_products_base_price_other($this->contents[$products_id]['reoder_price']);
                            }
                        }
                    }
                    //au站点gsp加税
                    if (AU_use_gsp_tax($products_id) && $_GET['main_page']!="inquiry"){
                        $products_prices_tax = get_gsp_tax_price('AU', $products_prices);
                    }else{
                        $products_prices_tax = $products_prices;
                    }

                    $products_price_original = $products_price / $currencies_value + $attributes_price;
                    $products_price_original = zen_round($products_price_original * $currencies_value, 2) / $currencies_value;

                }

                //前台展示给客户的重量
                $view_weight = zen_get_products_weight_for_customer_view((int)$products_id) + $this->attributes_weight($products_id);
                if(isset($this->contents[$products_id]['fiber_count']['products_attributes_weight'])){
                    $view_weight += $this->contents[$products_id]['fiber_count']['products_attributes_weight'];
                }

                $products_array[] = array('id' => $products_id,
                    'category' => $products->fields['master_categories_id'],
                    'name' => zen_get_products_name($products_id),
                    'model' => $products->fields['products_model'],
                    'image' => $products->fields['products_image'],
                    'price' => ($products->fields['product_is_free'] == '1' ? 0 : $wholesale_price),
                    'original_price'=>$products->fields['products_price'],
                    'quantity' => $new_qty,
                    'weight' => $products->fields['products_weight'] + $this->attributes_weight($products_id),
                    'view_weight' => $view_weight,
                    'products_price' => $products_price_original, //没有打折之前的价格，方便计算节省了多少钱
                    'final_price' => $products_prices,
                    'final_price_tax' => $products_prices_tax,
                    'tax_class_id' => $products->fields['products_tax_class_id'],
                    'attributes' => (isset($this->contents[$products_id]['attributes']) ? $this->contents[$products_id]['attributes'] : []),
                    'fiber_count' => (isset($this->contents[$products_id]['fiber_count']) ? $this->contents[$products_id]['fiber_count'] : ''),
                    'attributes_values' => (isset($this->contents[$products_id]['attributes_values']) ? $this->contents[$products_id]['attributes_values'] : ''),
                    'products_priced_by_attribute' => $products->fields['products_priced_by_attribute'],
                    'product_is_free' => $products->fields['product_is_free'],
                    'products_discount_type' => $products->fields['products_discount_type'],
                    'products_discount_type_from' => $products->fields['products_discount_type_from'],
                    'columnID' => $this->contents[$products_id]['columnID'],
                    'reoder_type'  => (isset($this->contents[$products_id]['reoder_type'])  ? $this->contents[$products_id]['reoder_type'] : ''),
                    'reoder_price' => (isset($this->contents[$products_id]['reoder_price']) ? $this->contents[$products_id]['reoder_price'] : 0.00),
                    'reoder_info'  => (isset($this->contents[$products_id]['reoder_info'])  ? $this->contents[$products_id]['reoder_info'] : array()),

                );
            }
        }
        return array_reverse($products_array);
    }

    function remove($products_id)
    {
        global $db;

        //CLR 030228 add call zen_get_uprid to correctly format product ids containing quotes
        //      $products_id = zen_get_uprid($products_id, $attributes);
        unset($this->contents[$products_id]);
        // remove from database
        if ($_SESSION['customer_id']) {
            $inquiry_id = $db->Execute("select id from customer_inquiry where status=5 and customers_id=".$_SESSION['customer_id']." limit 1")->fields['id'];
            if($inquiry_id){
                $inquiry_priducts_id = $db->Execute("select id from ".TABLE_CUSTOMER_INQUIRY_PRODUCTS." where inquiry_id=" . $inquiry_id ." and products_id = '" . zen_db_input($products_id) . "' limit 1")->fields['id'];
                $sql = "delete from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS . "
                where inquiry_id = " . $inquiry_id . "
                and attribute_product_id = '" . zen_db_input($products_id) . "'";
                $db->Execute($sql);
                $sql = "delete from " . TABLE_CUSTOMER_INQUIRY_PRODUCTS_ATTRIBUTES . "
                where products_id = '" . zen_db_input((int)$products_id) . "'
                and inquiry_products_id ='".$inquiry_priducts_id."'";
                $db->Execute($sql);
                $sql = "delete from customer_inquiry_products_length
                where  products_id = '" . zen_db_input((int)$products_id) . "'  and inquiry_products_id ='".$inquiry_priducts_id."'";
                $db->Execute($sql);
            }
        }
        // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
        $this->cartID = $this->generate_cart_id();
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

        if (isset($this->contents[$products_id]['attributes'])) {
            reset($this->contents[$products_id]['attributes']);
            while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                //长度属性的重量
                if($option=='length'){
                    //如果长度区间重量[products_length_weight]数据存在就获取不同长度区间的加重数据
                    $length = fs_get_data_from_db_fields('length','products_length','id='.(int)$value,'limit 1');
                    if(get_products_length_weight_count((int)$products_id)){
                        $attribute_weight += zen_get_products_length_weight((int)$products_id, $length, $this->contents[$products_id]['attributes']);
                    }else{
                        //仍然查找之前的products_length重量记录
                        $attribute_weight += get_length_weight($value);
                    }
                }else{
                    $attribute_weight_query = "select products_attributes_weight, products_attributes_weight_prefix
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
                    */
                    if ($attribute_weight_info->fields['products_attributes_weight_prefix'] == '-') {
                        $attribute_weight -= $attribute_weight_info->fields['products_attributes_weight'];
                    } else {
                        $attribute_weight += $attribute_weight_info->fields['products_attributes_weight'];
                    }
                }
            }
        }

        return $attribute_weight;
    }

    public function set_optionArr(){
        //获取属性项价格/m加价的所有属性项
        $this->optionArr = zen_get_all_option_by_price_type(1);
    }

    public function set_wholesaleproducts(){
        $this->wholesaleproducts =  fs_get_wholesale_products_array();
    }

    /*
    * 查-one - 获取一个报价的信息
    * @param $inquiry_id 报价id
    * @param $page 第几个页，all是全部
    * @param $number 获取几个
    * @return 报价的信息
    */
    public function get_one_inquiry($inquiry_id){
        global $db;

        $sql = "SELECT I.`id`,I.`customers_id`,I.`firstname`,I.`lastname`,I.`email`,I.`telephone`,I.`country_id`,I.`company_name`,I.`comment`,I.`point_ids`,I.sales_remark,I.`quote_name`,
                        I.`admin_id`,I.`order_id`,I.`inquiry_number`,I.`status`,I.`order_number`,I.`created_at`,I.`updated_at`,I.`all_price`,I.`price_code`,I.`interest`,I.`user_type`,I.`from_place`,I.`reorder_type`
                FROM customer_inquiry I
                WHERE I.id=".$inquiry_id."
                ORDER BY I.id desc limit 1";
        $result = $db->getAll($sql);
        if($result){
            $result = $result[0];
            if($result['customers_id']!=0){ // 如果是登录用户，提取用户信息
                $sql = "SELECT `customers_firstname`,`customers_lastname`,`customers_email_address`,`customer_country_id`,`customers_telephone`
                FROM customers
                WHERE customers_id=".$result['customers_id']."
                ORDER BY customers_id desc limit 1";
                $customer_result = $db->getAll($sql);
                $customer_result = $customer_result[0];
                $result['firstname'] = $customer_result['customers_firstname'];
                $result['lastname'] = $customer_result['customers_lastname'];
                $result['email'] = $customer_result['customers_email_address'];
                $result['telephone'] = $customer_result['customers_telephone'];
//                $result['country_id'] = $customer_result['customer_country_id'];
                $result['company_name'] = $customer_result['customers_company_name'];
            }
            $result['country_id_str'] = zen_get_country_name($result['country_id']);
            $result['telephone_str'] = zen_get_prefix($result['country_id']).' '.$result['telephone'];
            $result['point_ids_str'] = $this->get_inquiry_point_ids_str($result['point_ids']);
            $result['newStatus'] = $result['status'];
            $result['status'] = $this->check_add_inquiry_status($result['status'],$result['created_at']);
            $result['status_str'] = $this->get_inquiry_status_str($result['status']);
            $result['newStatusStr'] = $this->get_inquiry_status_str($result['newStatus']);
            $result['interest_str'] = $this->get_inquiry_interest_str($result['interest']);
            $result['user_type_str'] = $this->get_inquiry_user_type_str($result['user_type']);
            if($result['price_code']=='GBP' && $result['status']!=1){ //需要重新计算
                $result['all_price'] =  $this->get_one_inquiry_all_price($result['id'],true);
            }
            $result['all_price_str'] = $this->get_price_str($result['all_price'],$result['price_code']);
        }
        return $result;
    }

    /*
     * 查-列表 - 获取一个用户的 指定的 报价
     * @param $customers_id 用户id
     * @return 报价
     */
    public function get_one_customer_inquiries($customers_id,$page='all',$number='',$where=""){
        global $db;

        $limit = '';
        if(!$page && $number){
            $limit = 'limit '.$number;
        }elseif ($page && $number){
            $begin_page = ($page-1)*$number ;
            $limit = 'limit '.$begin_page.','.$number;
        }

        $sql = "SELECT  `id`,`customers_id`,`quote_name`,`firstname`,`lastname`,`email`,`telephone`,`country_id`,`company_name`,`comment`,`point_ids`,`admin_id`,`inquiry_number`,`status`,`order_number`,`updated_at`,`all_price`,`price_code`,`from_place`,`created_at`
            FROM customer_inquiry
            WHERE customers_id=".$customers_id.$where." and status !=5
            ORDER BY id desc ".$limit;
        $result = $db->getAll($sql);
        if($result){
            $is_online_website = strpos($_SERVER['HTTP_HOST'],'www.fs.com')!==false?true:false;
            foreach ($result as $key =>$val){
                $result[$key]['status'] = $val['status'] = $this->check_add_inquiry_status($val['status'],$val['created_at']);
                $result[$key]['status_str'] = $this->get_inquiry_status_str($val['status']);
                if($val['status']==4 || ($val['status']==1 && $val['from_place']!=4)){  //来自于前台
                    $result[$key]['updated_at_str'] = getTime('default',strtotime($val['updated_at']),$_SESSION['countries_iso_code']);
                }else{  //来自与后台
                    $result[$key]['updated_at_str'] = getTime('default',strtotime($val['updated_at']),$_SESSION['countries_iso_code'],'',false);
                }

                if($val['price_code']=='GBP' && $val['status']!=1){ //需要重新计算
                    $result[$key]['all_price'] = $val['all_price'] =  $this->get_one_inquiry_all_price($val['id'],true);
                }

                $result[$key]['all_price_str'] = $this->get_price_str($val['all_price'],$val['price_code']);
            }
        }

        return $result;
    }

    /*
     * 查 - 获取一个报价的附加信息
     * @param $inquiry_id 报价id
     * @return 评论
     */
    public function get_one_inquiry_attachments($inquiry_id){
        global $db;
        $sql = "SELECT attachment_path,origin_file_name
                FROM customer_inquiry_info
                WHERE inquiry_id=".$inquiry_id."
                ORDER BY id asc ";
        $result = $db->getAll($sql);
        return $result;
    }

    /*
     * 查 - 获取一个报价的产品
     * @param $inquiry_id 报价id
     * @return 二维数组
     */
    public function get_one_inquiry_products_withinfo($inquiry_id){
        global $db;

        // fairy 2019.3.4 add 组合产品
        $all_is_composite_products = false;

        $sql = 'SELECT IP.id,IP.inquiry_id,IP.products_id,IP.save_at,IP.product_name,IP.comment,IP.product_num,IP.target_price,IP.price_code,IP.admin_price,IP.product_price,IP.all_product_price,IP.final_product_price,IP.is_customized,IP.products_tax_class_id,
                  P.products_image,PD.products_name,IP.attribute_product_id,P.products_status 
            FROM customer_inquiry_products IP
            LEFT JOIN '.TABLE_PRODUCTS.' P on IP.products_id = P.products_id
            LEFT JOIN '.TABLE_PRODUCTS_DESCRIPTION.' PD on IP.products_id = PD.products_id and language_id='.$_SESSION['languages_id'].'
            WHERE IP.inquiry_id='.$inquiry_id.' and IP.is_display=1
            ORDER BY IP.id asc';
        $result = $db->getAll($sql);
        foreach ($result as $key => $val){
            if($val['products_id']){
                $products_image = DIR_WS_IMAGES.$val['products_image'];
                $result[$key]['products_image_str'] = file_exists($products_image) ? $products_image: DIR_WS_IMAGES.'no_picture.gif';
                $result[$key]['product_name_str'] = $val['products_name'];
                $result[$key]['attribute_product_id'] = $val['attribute_product_id'];
                $result[$key]['save_at'] = $val['save_at'];
                $result[$key]['products_status'] = $val['products_status'];
                $attributes_all_arr = [];
                if($val['is_customized']){
                    // 属性信息
                    // Push all attributes information in an array
                    $attributes_all_arr  = $this->get_one_inquiry_products_attributes($val['id']);
                    //把属性值放到一个数组  方便有属性的组合产品展示价格
                    $combination_arr = array();
                    $attr_str = '';
                    if(is_array($attributes_all_arr)  && !empty($attributes_all_arr['attributes'])){
                        foreach ($attributes_all_arr['attributes'] as $value){
                            $combination_arr[] = (int)$value;
                        }
                    }
                    if($combination_arr){
                        $attr_str = reorder_options_values($combination_arr);
                    }
                    // fairy 2019.3.4 add 组合产品  换一个位置 传入属性值
                    $is_composite_products = false;
                    if (class_exists('classes\CompositeProducts')) {
                        $CompositeProducts = new classes\CompositeProducts(intval($val['products_id']),'',$attr_str);
                        $is_composite_products = $CompositeProducts->check_product_is_composite();
                        if(!$all_is_composite_products && $is_composite_products){
                            $all_is_composite_products = $is_composite_products;
                        }
                    }
                    $result[$key]['attributes'] = $this->get_one_products_attributes_str($attributes_all_arr,$val['products_id'],$val['product_num']);
                }
                /**
                 * au站gsp税收
                 */
//                if ($use_au_tax){
//                    $auAttr = [];
//                    if (isset($result[$key]['attributes']) && is_array($result[$key]['attributes'])){
//                        foreach ($result[$key]['attributes'] as $attributes){
//                            if (isset($attributes['options_values_id'])){
//                                $auAttr[] = $attributes['options_values_id'];
//                            }
//                        }
//                    }
//                    if (AU_use_gsp_tax($val['products_id'],reorder_options_values($auAttr),'AU')){
//                        $val['final_product_price'] = get_gsp_tax_price('AU',$val['final_product_price']);
//                        $val['admin_price'] = get_gsp_tax_price('AU',$val['admin_price']);
//                        $result[$key]['admin_price'] = $val['admin_price'];
//                        $result[$key]['final_product_price'] = $val['final_product_price'];
//                    }
//                }
                $language_code = $db->Execute("select language_code from customer_inquiry where id=".$inquiry_id."")->fields['language_code'];

                // 单价
                $currency_value = $this->currencies->currencies[$val['price_code']]['value'];
                if(in_array($_SESSION['languages_code'],array('uk','en')) && $val['price_code']=="GBP"){
                    //uk站&主站英镑价格展示提升5%
                    $product_price_arr = $this->get_product_price_str($val['products_id'],$val['product_price']*1.05,$attributes_all_arr,$val['products_tax_class_id'],$val['price_code'],true);
                    $val['all_product_price'] = $product_price_arr['products_price_original_current'];
                    $val['final_product_price'] = $product_price_arr['products_price_finial_current'];
                    if($is_composite_products){
                        $result[$key]['products_price_original_str'] =  $product_price_arr['products_price_original_str'];
                        $result[$key]['products_price_finial_str'] = $product_price_arr['products_price_finial_str'];
                    }else{
                        $result[$key]['products_price_original_str'] =  $this->get_price_str($val['all_product_price'],$val['price_code']);
                        $result[$key]['products_price_finial_str'] = $this->get_price_str($val['final_product_price'],$val['price_code']);
                    }
                }else{
                    if(in_array($language_code,array('au')) && $val['admin_price']=='0.00' && $val['price_code']=="AUD") {
                        $result[$key]['products_price_original_str'] =  $this->get_price_str($val['all_product_price']*1.1,$val['price_code']);
                        $result[$key]['products_price_finial_str'] = $this->get_price_str($val['final_product_price']*1.1,$val['price_code']);
                    }else{
                        $result[$key]['products_price_original_str'] =  $this->get_price_str($val['all_product_price'],$val['price_code']);
                        $result[$key]['products_price_finial_str'] = $this->get_price_str($val['final_product_price'],$val['price_code']);
                    }

                }

            }else{
                $result[$key]['products_image_str'] = DIR_WS_IMAGES.'no_picture.gif';
                $result[$key]['product_name_str'] = $val['product_name'];
            }

            $result[$key]['target_price_str'] = $this->get_price_str($val['target_price'],  $val['price_code']);

            // 数据库存储的是原价，因为uk站&主站前台英镑统一加价0.05
            if(in_array($language_code,array('uk','en')) && $val['admin_price']!='0.00' && $val['price_code']=="GBP") {
                $result[$key]['admin_price'] = $val['admin_price'] = zen_round($val['admin_price'] * 1.05,2);
            }
            if($val['price_code']=="AUD" && $val['admin_price']!='0.00'){
                $result[$key]['admin_price_str'] = $this->get_price_str($val['admin_price']*1.1, $val['price_code']);
            }else{
                $result[$key]['admin_price_str'] = $this->get_price_str($val['admin_price'], $val['price_code']);

            }
        }
        $result[0]['is_composite_products'] = $all_is_composite_products;

        return $result;
    }

    /*
     * 查 - 获取一个报价的产品
     * @param $inquiry_id 报价id
     * @return 二维数组
     */
    public function get_one_inquiry_products_withinfo_checkout($inquiry_id){
        global $db,$currencies;

        $inquiry_info = $db->getAll("select created_at,status,all_price from ".TABLE_CUSTOMERS_INQUIRY." where id = ".(int)$inquiry_id." and order_id is null and status =2 and all_price!='0.00' limit 1");
        $created_at='';
        if(is_array($inquiry_info) && $inquiry_info[0]['status']==2 && $inquiry_info[0]['all_price']!='0.00'){
            $products_arr = get_quote_product_info((int)$inquiry_id, '', '');
            $created_at = $products_arr[0]['save_at'];
        }

        //验证数据有效性
        if(empty($created_at)){
            return false;
        }else{
            $deskTime = 1296000;//前台超时15天
            $admin_save_time=strtotime($created_at);
            if($admin_save_time>0){
                $time = time()-8*3600; //线上误差8小时，测试站16小时
                $date = $time - $admin_save_time;
                if($date>$deskTime){
                    //关闭该报价单
                    zen_db_perform(TABLE_CUSTOMER_INQUIRY,array('status'=>4), 'update', 'id=' . $inquiry_id);
                    $data_type=0;
                    return false;
                }
            }

        }

        $all_is_composite_products = false;
        $sql = 'SELECT IP.id,IP.inquiry_id,IP.products_id,IP.save_at,IP.product_name,IP.comment,IP.product_num,IP.target_price,IP.price_code,IP.admin_price,IP.product_price,IP.all_product_price,IP.final_product_price,IP.is_customized,IP.products_tax_class_id,
                  P.products_image,P.products_discount_type,P.products_discount_type_from,P.products_model,P.products_weight,P.show_type,P.master_categories_id,P.products_tax_class_id,P.products_status,PD.products_name,IP.attribute_product_id
            FROM customer_inquiry_products IP
            LEFT JOIN '.TABLE_PRODUCTS.' P on IP.products_id = P.products_id
            LEFT JOIN '.TABLE_PRODUCTS_DESCRIPTION.' PD on IP.products_id = PD.products_id and language_id='.$_SESSION['languages_id'].'
            WHERE IP.inquiry_id='.$inquiry_id.' and IP.is_display=1
            ORDER BY IP.id asc';
        $result = $db->getAll($sql);

        foreach ($result as $key => $val){
            if($val['products_id']){
                $view_weight=0;
                $weight=0;
                //前台展示给客户的重量
//                $result[$key]['clearance_qty']= $clearance_qty;
//                $result[$key]['is_clearance']=  $is_clearance ? 1 : 0;    //是否是清仓产品
                $attributes_all_arr = [];
                if($val['is_customized']){
                    // 属性信息
                    // Push all attributes information in an array
                    $attributes_all_arr  = $this->get_checkout_inquiry_products_attributes($val['id']);
                    //把属性值放到一个数组  方便有属性的组合产品展示价格
                    $combination_arr = array();
                    $attr_str = '';
                    if(is_array($attributes_all_arr)  && !empty($attributes_all_arr['attributes'])){
                        foreach ($attributes_all_arr['attributes'] as $value){
                            $combination_arr[] = (int)$value;
                        }
                    }
                    if($combination_arr){
                        $attr_str = reorder_options_values($combination_arr);
                    }
                    // fairy 2019.3.4 add 组合产品  换一个位置 传入属性值
                    $is_composite_products = false;
                    if (class_exists('classes\CompositeProducts')) {
                        $CompositeProducts = new classes\CompositeProducts(intval($val['products_id']),'',$attr_str);
                        $is_composite_products = $CompositeProducts->check_product_is_composite();
                        if(!$all_is_composite_products && $is_composite_products){
                            $all_is_composite_products = $is_composite_products;
                        }
                    }
//                    $attributes = $this->get_one_products_attributes_str($attributes_all_arr,$val['products_id'],$val['product_num']);
                }

                // 单价
                if(in_array($_SESSION['languages_code'],array('uk','en')) && $val['price_code']=="GBP"){
                    //uk站&主站英镑价格展示提升5%
                    $product_price_arr = $this->get_product_price_str($val['products_id'],$val['product_price']*1.05,$attributes_all_arr,$val['products_tax_class_id'],$val['price_code'],true);
                    $val['all_product_price'] = $product_price_arr['products_price_original_current'];
                    $val['final_product_price'] = $product_price_arr['products_price_finial_current'];
                }
            }else{
                $result[$key]['products_image_str'] = DIR_WS_IMAGES.'no_picture.gif';
                $result[$key]['product_name_str'] = $val['product_name'];
            }

            $language_code = $db->Execute("select language_code from customer_inquiry where id=".$inquiry_id."")->fields['language_code'];
            $result[$key]['products_price'] = $result[$key]['final_price'] = $val['admin_price'];
            // 数据库存储的是原价，因为uk站&主站前台英镑统一加价0.05
            if(in_array($language_code,array('uk','en')) && $val['admin_price']!='0.00' && $val['price_code']=="GBP") {
                $result[$key]['products_price'] = $result[$key]['final_price'] = $val['admin_price'] = zen_round($val['admin_price'] * 1.05,2);
            }
            $attr_product_id = zen_get_uprid($val['products_id'], $attributes_all_arr['attributes']);
            if(is_array($attributes_all_arr)  && !empty($attributes_all_arr['attributes'])){
                $result[$key]['id'] = $attr_product_id;
                $this->contents[$attr_product_id]['attributes']=$attributes_all_arr['attributes'];
                $result[$key]['attributes']=$attributes_all_arr['attributes'];
                if(!empty($attributes_all_arr['attributes_text'])){
                    $result[$key]['attributes_values'] = $attributes_all_arr['attributes_text'];
                }
            }else{
                $result[$key]['id'] = $val['products_id'];
                $result[$key]['attributes']=[];
            }

//            require_once(DIR_WS_CLASSES.'shipping_info.php');
            $config['pid'] = $result[$key]['id'];
            //shipping_info类在购物车等相关页面实例化是，必须将已经选择的属性数据赋值过去，attr_option_arr和label_option
//            $shipping_info = new ShippingInfo($config);
//            $shipping_info->pure_price = $val['admin_price'];
//            $shipping_info->main_page = "shopping_cart";
//            $shipping_info->set_products_info($val['product_num']);
//            $instockHtml = $shipping_info->showIntockDate(false,1);
//            $result[$key]['instockHtml']= $instockHtml;
            $currency_type = $_SESSION['currency'];
            $currencies_value = $currencies->currencies[$currency_type]['value'];
            $product_price=0;
            if($val['admin_price']!='0.00'){
                $product_price = $this->get_us_formate_quote($val['admin_price'],$currencies_value);
            }
            //将报价最终价格转化为美元再进行计算
            $view_weight = zen_get_products_weight_for_customer_view((int)$val['products_id']) + $this->attributes_weight($attr_product_id);
            $weight = $val['products_weight'] + $this->attributes_weight($attr_product_id);
            $result[$key]['weight']=$weight;
            $result[$key]['view_weight']=$view_weight;
            $products_image = DIR_WS_IMAGES.$val['products_image'];
            $result[$key]['products_image_str'] = file_exists($products_image) ? $products_image: DIR_WS_IMAGES.'no_picture.gif';
            $result[$key]['product_name_str'] = $val['products_name'];
            $result[$key]['attribute_product_id'] = $val['attribute_product_id'];
            $result[$key]['save_at'] = $val['save_at'];
            $result[$key]['name'] = $val['products_name'];
            $result[$key]['image'] = $val['products_image'];
            $result[$key]['model'] = $val['products_model'];
            $result[$key]['price'] = $val['product_price'];
            $result[$key]['products_price'] = $val['product_price'];
            $price_us = $val['admin_price']/zen_get_currencies_value_of_code($val['price_code']);//美元
            $result[$key]['final_price'] = $price_us;
            $result[$key]['quantity'] = $val['product_num'];
            $result[$key]['reoder_type']='quotation';
            $result[$key]['category']=$val['master_categories_id'];
            $result[$key]['show_type']=$val['show_type'];
            $result[$key]['products_status']=$val['products_status'];
            $result[$key]['tax_class_id']= $val['products_tax_class_id'];
            $result[$key]['products_discount_type']=$val['products_discount_type'];
            $result[$key]['products_discount_type_from']=$val['products_discount_type_from'];
            $result[$key]['reoder_price']=$price_us;
            $result[$key]['reoder_info'] = array(
                'quotation_id'=>$val['inquiry_id'],
                'products_quantity'=>0,
                'products_price'=>$product_price?$product_price:$val['admin_price'],
                'reorder_type'=>1,
                'quotation_combination'=>0,
            );
            $result[$key]['is_clearance'] =0;
            $result[$key]['clearance_qty'] =0;
            $result[$key]['is_gift'] =0;
            $result[$key]['attributes_file'] =0;
            $result[$key]['onetime_charges']= 0;
            $result[$key]['products_priced_by_attribute']=[];
            $result[$key]['product_is_free']=[];
            $result[0]['is_composite_products'] = $all_is_composite_products;
            $this->total_qty+=$val['product_num'];
        }
//        $result = array_filter($result, function ($item){
//            return $item['products_status'];
//        });
        $result = array_values($result);
        return $result;
    }

    function get_us_formate_quote($price,$currencies_value){
        $currencies_value = zen_get_products_base_price_other($currencies_value);
        $us_price = $price / $currencies_value;
        return $us_price;
    }

    /*
    * 查 - 获取一个报价产品 的长度和属性 信息
    * @param $inquiry_products_id 报价产品 id
    * @return 属性
    */
    public function get_one_inquiry_products_attributes($inquiry_products_id){
        global $db;

        //不写成一个数组，是因为，要调用公共的方法，保证和其他的结构一直。后期优化可以合并成一个数组
        $attributes = $attributes_column = $attributes_text_arr = $attributes_customized = array();

        $inquiry_products_attributes_sql = "SELECT `id`,`inquiry_products_id`,`products_id`,`options_id`,`options_value_id`,`column_id`,`options_value_text`
            FROM customer_inquiry_products_attributes WHERE `inquiry_products_id` = '".$inquiry_products_id."'" ;

        $inquiry_products_attributes = $db->getAll($inquiry_products_attributes_sql);
        if($inquiry_products_attributes){
            foreach ($inquiry_products_attributes as $attributes_val){
                if($attributes_val['options_value_id'] != 0){
                    $products_options_type = $db->Execute("SELECT products_options_type FROM `products_options` WHERE products_options_id=".$attributes_val['options_id']."")->fields['products_options_type'];
                    if($products_options_type == PRODUCTS_OPTIONS_TYPE_CHECKBOX){
                        $attributes[$attributes_val['options_id']."_chk".$attributes_val['options_value_id']] = $attributes_val['options_value_id'];
                    }else{
                        $attributes[$attributes_val['options_id']] = $attributes_val['options_value_id'];
                    }
                }else{
                    $attributes[TEXT_PREFIX.$attributes_val['options_id']] = 0;
                    $attributes_text_arr[$attributes_val['options_id']] = $attributes_val['options_value_text'];
                }
                if(!empty($attributes_val['options_value_text'])){
                    $attributes_customized[$attributes_val['options_value_id']] = $attributes_val['options_value_text'];
                }
                $attributes_column[$attributes_val['options_id']][$attributes_val['options_value_id']] = $attributes_val['column_id'];
            }
        }

        $inquiry_products_length_sql = "SELECT `id`,`inquiry_products_id`,`products_id`,`length_name`,`product_length_id`,`length`
            FROM customer_inquiry_products_length WHERE `inquiry_products_id` = '".$inquiry_products_id."'" ;

        $inquiry_products_length = $db->getAll($inquiry_products_length_sql);
        //length后台与前台存储方式不一致
        if(isset($inquiry_products_length[0]['product_length_id']) && (int)$inquiry_products_length[0]['product_length_id']>0){
            $inquiry_length = $db->getAll('SELECT length FROM products_length WHERE id = '.(int)$inquiry_products_length[0]['product_length_id'].'');
            if(!empty($inquiry_length[0]['length'])){
                $inquiry_products_length[0]['length'] = $inquiry_length[0]['length'];
            }
        }
        if($inquiry_products_length){
            $inquiry_products_length = $inquiry_products_length[0];
            if($inquiry_products_length['length']){
                $p_id = $inquiry_products_length['products_id'];
                $len = $inquiry_products_length['length'];
                $priceArr = get_length_range_price($p_id, $len);
                $is_exists = fs_get_data_from_db_fields('id', 'products_length', 'product_id = "' . $p_id . '" AND length = "' . $priceArr['length'] . '"');
                if ($is_exists) {
                    $attributes['length'] = $is_exists;
                }else{
                    $data = array(
                        'length_price' => $priceArr['length_price'],
                        'price_prefix' => '+',
                        'weight' => $priceArr['weight'],
                        'length' => $priceArr['length'],
                        'product_id' => $p_id,
                        'add_time' => 'now()',
                        'update_time' => '',
                        'custom' => '1'
                    );
                    zen_db_perform('products_length', $data);
                    $attributes['length'] = $db->insert_ID();
                }
            }else{
                $attributes['length'] = $inquiry_products_length['product_length_id'];
            }
        }

        $attributes_all = array(
            'attributes' => $attributes,
            'attributes_column' => $attributes_column,
            'attributes_text' => $attributes_text_arr,
            'attributes_customized' => $attributes_customized
        );
        return $attributes_all;
    }

    /*
* 查 - 获取一个报价产品 的长度和属性 信息
* @param $inquiry_products_id 报价产品 id
* @return 属性
*/
    public function get_checkout_inquiry_products_attributes($inquiry_products_id){
        global $db;

        //不写成一个数组，是因为，要调用公共的方法，保证和其他的结构一直。后期优化可以合并成一个数组
        $attributes = $attributes_column = $attributes_text_arr = array();

        $inquiry_products_attributes_sql = "SELECT `id`,`inquiry_products_id`,`products_id`,`options_id`,`options_value_id`,`column_id`,`options_value_text`
            FROM customer_inquiry_products_attributes WHERE `inquiry_products_id` = '".$inquiry_products_id."'" ;

        $inquiry_products_attributes = $db->getAll($inquiry_products_attributes_sql);
        if($inquiry_products_attributes){
            foreach ($inquiry_products_attributes as $attributes_val){
                if($attributes_val['options_value_id'] != 0){
                    $products_options_type = $db->Execute("SELECT products_options_type FROM `products_options` WHERE products_options_id=".$attributes_val['options_id']."")->fields['products_options_type'];
                    if($products_options_type == PRODUCTS_OPTIONS_TYPE_CHECKBOX){
                        $attributes[$attributes_val['options_id']."_chk".$attributes_val['options_value_id']] = $attributes_val['options_value_id'];
                    }else{
                        $attributes[$attributes_val['options_id']] = $attributes_val['options_value_id'];
                    }
                }else{
                    $attributes[$attributes_val['options_id']] = 0;
                    $attributes_text_arr[$attributes_val['options_id']] = $attributes_val['options_value_text'];
                }
                $attributes_column[$attributes_val['options_id']][$attributes_val['options_value_id']] = $attributes_val['column_id'];
            }
        }

        $inquiry_products_length_sql = "SELECT `id`,`inquiry_products_id`,`products_id`,`length_name`,`product_length_id`,`length`
            FROM customer_inquiry_products_length WHERE `inquiry_products_id` = '".$inquiry_products_id."'" ;

        $inquiry_products_length = $db->getAll($inquiry_products_length_sql);
        //length后台与前台存储方式不一致
        if(isset($inquiry_products_length[0]['product_length_id']) && (int)$inquiry_products_length[0]['product_length_id']>0){
            $inquiry_length = $db->getAll('SELECT length FROM products_length WHERE id = '.(int)$inquiry_products_length[0]['product_length_id'].'');
            if(!empty($inquiry_length[0]['length'])){
                $inquiry_products_length[0]['length'] = $inquiry_length[0]['length'];
            }
        }
        if($inquiry_products_length){
            $inquiry_products_length = $inquiry_products_length[0];
            if($inquiry_products_length['length']){
                $p_id = $inquiry_products_length['products_id'];
                $len = $inquiry_products_length['length'];
                $priceArr = get_length_range_price($p_id, $len);
                $is_exists = fs_get_data_from_db_fields('id', 'products_length', 'product_id = "' . $p_id . '" AND length = "' . $priceArr['length'] . '"');
                if ($is_exists) {
                    $attributes['length'] = $is_exists;
                }else{
                    $data = array(
                        'length_price' => $priceArr['length_price'],
                        'price_prefix' => '+',
                        'weight' => $priceArr['weight'],
                        'length' => $priceArr['length'],
                        'product_id' => $p_id,
                        'add_time' => 'now()',
                        'update_time' => '',
                        'custom' => '1'
                    );
                    zen_db_perform('products_length', $data);
                    $attributes['length'] = $db->insert_ID();
                }
            }else{
                $attributes['length'] = $inquiry_products_length['product_length_id'];
            }
        }

        $attributes_all = array(
            'attributes' => $attributes,
            'attributes_column' => $attributes_column,
            'attributes_text' => $attributes_text_arr,
        );
        return $attributes_all;
    }

    /*
     * 查 - 获取报价的所有信息
     * @return 报价的所有信息
     */
    function get_one_inquiry_all_info($inquiry_id,$has_attachments=true){
        $customer_inquiry = $this->get_one_inquiry($inquiry_id);
        $customer_inquiry['products'] = $this->get_one_inquiry_products_withinfo($inquiry_id);

        // fairy 2019.3.4 add 组合产品
        if($customer_inquiry['products']){
            $customer_inquiry['is_composite_products'] = $customer_inquiry['products'][0]['is_composite_products'];
        }
        if($has_attachments){
            $customer_inquiry['attachments'] = $this->get_one_inquiry_attachments($inquiry_id);
        }
        return $customer_inquiry;
    }

    /*
    * 查 - 获取申请报价的产品信息
    * @param $products_id 产品id
    * @param $customers_id 用户id
    * @return 报价
    */
    public function get_apply_inquiry_product_info($products_id){
        global $db;
        require_once DIR_WS_CLASSES . 'shipping_info.php';
        $where =  '';
        if(is_array($products_id)){
            $products_arr = $products_id;
            $products_count = count($products_arr);
            if($products_count){
                $products_id_arr = array();
                foreach ($products_arr as $key => $val){
                    $products_id_arr[] =  (int)$key;
                }
                if($products_count==1){
                    $where .= ' and P.products_id ='.$products_id_arr[0].' ';
                }else{
                    $where .= ' and P.products_id in ('.implode(',',$products_id_arr).') ';
                }
            }
        }else{
            $where .= ' and P.products_id ='.$products_id.' limit 1 ';
            $products_arr = array($products_id=>1);
        }

        $sql = 'select P.products_id,P.products_image,P.products_price,P.products_tax_class_id,P.products_status,PD.products_name,P.is_min_order_qty as min_qty
          from '.TABLE_PRODUCTS .' P
          left join '.TABLE_PRODUCTS_DESCRIPTION .' PD on PD.products_id = P.products_id and PD.language_id ='.(int)$_SESSION['languages_id'].'
              where 1 '.$where;
        $result = $db->getAll($sql);
        if($result){
            //整理数据
            foreach ($result as $key => $val){
                $result[$key]['productImageSrc'] = $val['products_image'];
                $result[$key]['id'] = $val['products_id'];
                $result[$key]['productsName'] = $val['products_name'];
                $price = $val['products_price'];
                //uk站&主站产品英镑价格提升5%
                $price = zen_get_products_base_price_other($price);
                // 单价
                $product_price_arr = $this->get_product_price_str($val['products_id'],$price,'',$val['products_tax_class_id']);
                $result[$key]['products_price_original_str'] = $product_price_arr['products_price_original_str'];
                $result[$key]['final_price'] = $product_price_arr['products_price_finial_current'];
                $result[$key]['productsPriceEach'] = $product_price_arr['products_price_finial_str'];
                // 库存
                $isCustom = check_is_custom($val['products_id']);
                $shippingInfo = new shippingInfo(array('pid'=>$val['products_id']));
                $result[$key]['instock_info_str'] = $shippingInfo->get_warehouse_instock_qty();
                $result[$key]['quantity'] = $products_arr[$val['products_id']];
                $result[$key]['is_custom'] = $isCustom?0:1;
            }
        }
        return $result;
    }

    /*
     * 查-判断 - 是否是某个用户的报价
     * @param $customers_id 用户id
     * @param $inquiry_id 报价id
     * @return 是不是
     */
    public function check_is_customer_inquiry($customers_id,$inquiry_id){
        global $db;
        $sql = 'SELECT count(id) as count
                FROM customer_inquiry
                WHERE customers_id='.$customers_id.' and id='.$inquiry_id.'
                ORDER BY id desc';
        $result = $db->getAll($sql);
        return (!$result || $result[0]['count']==0)? false:true;
    }

    /*
     * 查-统计 - 获取用户的报价单个数
     * @param $customers_id 用户id
     * @return 报价单个数
     */
    public function get_one_customer_inquiries_num($customers_id,$orders_query_and=""){
        global $db;
        $sql = 'SELECT count(distinct IP.id) as count
                FROM customer_inquiry IP LEFT JOIN customer_inquiry_products P on IP.id = P.inquiry_id
                WHERE IP.customers_id='.$customers_id.$orders_query_and.' and IP.status!=5 and P.id!=""';
        $result = $db->getAll($sql);
        return $result?$result[0]['count']:0;
    }

    /*
 * 查-统计 - 获取用户的报价单个数
 * @param $customers_id 用户id
 * @return 报价单个数
 */
    public function get_one_customer_inquiries_num_one($customers_id,$orders_query_and=""){
        global $db;
        $sql = 'SELECT count(id) as count
                FROM customer_inquiry
                WHERE customers_id='.$customers_id.$orders_query_and.' and status=2';
        $result = $db->getAll($sql);
        return $result?$result[0]['count']:0;
    }


    /*
 * 查-统计 - 获取用户的报价单个数
 * @param $customers_id 用户id
 * @return 报价单个数
 */
    public function get_one_customer_inquiries_num_two($customers_id,$orders_query_and=""){
        global $db;
        $sql = 'SELECT count(id) as count
                FROM customer_inquiry
                WHERE customers_id='.$customers_id.$orders_query_and.' and status!=2 and status!=5';
        $result = $db->getAll($sql);
        return $result?$result[0]['count']:0;
    }

    /*
     * 查-统计 - 获取一个报价的所有产品的总价格
     * @param $inquiry_id 报价id
     * @param bool $for_uk_show: 是否为了uk展示。用于添加到数据的话，这个一定是false，不然会出错
     * @param bool $for_au_show: 是否为了au展示。用于添加到数据的话，这个一定是false，不然会出错
     * @param bool $decimal_places: 四舍五入
     * @return 评论
     */
    public function get_one_inquiry_all_price($inquiry_id,$for_uk_show=false,$for_au_show = false,$decimal_places = 2){
        global $db;

        $sql = 'SELECT IP.target_price,IP.admin_price,IP.product_num,IP.price_code,IP.products_id,IP.product_price,P.products_tax_class_id,IP.price_code
            FROM customer_inquiry_products IP
            LEFT JOIN '.TABLE_PRODUCTS.' P on IP.products_id = P.products_id
            WHERE IP.inquiry_id='.$inquiry_id.'
            ORDER BY IP.id asc';
        $result = $db->getAll($sql);
        $all_price = 0;
        if($result){
            foreach ($result as $key => $val){
                $current_price = 0;
                if($val['admin_price']!='0.00'){
                    if($for_uk_show){
                        $current_price = zen_round($val['admin_price']*1.05,2);
                    }elseif($for_au_show && AU_use_gsp_tax($val['products_id'],'','AU')){
                        $current_price = zen_round(get_gsp_tax_price('AU',$val['admin_price']),$decimal_places);
                    }else{
                        $current_price = zen_round($val['admin_price'], $decimal_places);
                    }
                }
                $all_price += $current_price*$val['product_num'];
            }
        }
        return $all_price;
    }

    /*
     * 删除 - 删除某个询价产品
     * @param $product_inquiry_id 产品报价id
     * @param $inquiry_id 报价id
     * @return 删除是否成功
     */
    public function del_one_inquiry_product($product_inquiry_id){
        global $db;
        $sql = 'delete FROM customer_inquiry_products WHERE id='.$product_inquiry_id;
        $result = $db->query($sql);
        return $result;
    }

    /*
     * 初始化 - 初始化某个报价的总价格
     * @param $inquiry_id 报价id
     * @param $price_code 单位。更新的时候不需要传递
     * @return 操作是否成功
     */
    public function init_one_inquiry_all_price($inquiry_id,$price_code='',$updated_person=''){
        $all_price = $this->get_one_inquiry_all_price($inquiry_id);
        $inquiry_arr = array('all_price' => $all_price);
        if($price_code){
            $inquiry_arr['price_code'] = $price_code;
        }
        $inquiry_arr['updated_at'] = date('Y-m-d H:i:s');
        $inquiry_arr['updated_person'] = $updated_person;
        $result = zen_db_perform('customer_inquiry', $inquiry_arr, 'update', ' id=' . $inquiry_id);
        $current_root_dir = str_replace('cache','',DIR_FS_SQL_CACHE);
        $inquiry_log_dir = $current_root_dir.'debug/inquiry.log';
        error_log(date('Y-m-d H:i:s')."\n 【inquiry_id：".$inquiry_id."】【all_price：".$all_price."】\n\n", 3,$inquiry_log_dir);

        return $result;
    }


    /*
     * 公共的方法 - 获取 报价状态的 字符串
     * @param $inquiry_status 报价状态
     * @return 字符串
     */
    public function get_inquiry_status_str($inquiry_status){
        $result = '';
        switch ($inquiry_status){
            case '1':
                $result = FS_COMMON_PROCESSING;
                break;
            case '2':
                $result = INQUIRY_LISTS_2;
                break;
            case '3':
                $result = FS_INQUIRY_DEALED;
                break;
            case '4':
                $result = FS_INQUIRY_CANCELED_1;
                break;
            case '5':
                $result = FS_COMMON_PROCESSING;
                break;
        }

        return $result;
    }

    /*
     * 公共的方法 - 获取 一个报价用户关注点 字符串
     * @param $inquiry_status 报价用户关注点
     * @return 字符串
     */
    public function get_inquiry_point_id_str($point_id){
        $result = '';
        switch ($point_id){
            case '1':
                $result = FS_INQUIRY_LOGO;
                break;
            case '2':
                $result = FS_INQUIRY_WARRANTY;
                break;
            case '3':
                $result = FS_INQUIRY_LEAD_TIME;
                break;
            case '4':
                $result = FS_INQUIRY_BULK_PRICE;
                break;
            case '5':
                $result = FS_INQUIRY_PO_ORDER;
                break;
            case '6':
                $result = FS_INQUIRY_ATTACH;
                break;
        }
        return $result;
    }

    /*
     * 公共的方法 - 获取 报价用户关注点 字符串
     * @param $inquiry_status 报价用户关注点
     * @return 字符串
     */
    public function get_inquiry_point_ids_str($point_ids){
        $result = array();
        if($point_ids){
            $point_ids = explode(',',$point_ids);
            foreach ($point_ids as $val){
                $result[]= $this->get_inquiry_point_id_str($val);
            }
        }
        return $result;
    }

    /*
     * 公共的方法 - 处理 user_type 字符串
     * @param $str user_type字符串
     * @return 处理之后的user_type
     */
    public function get_inquiry_user_type_str($str){
        $result = '';
        switch ($str){
            case '1':
                $result = FS_INQUIRY_DESCRIBE_OPTION1;
                break;
            case '2':
                $result = FS_INQUIRY_DESCRIBE_OPTION2;
                break;
            case '3':
                $result = FS_INQUIRY_DESCRIBE_OPTION3;
                break;
            case '4':
                $result = FS_INQUIRY_DESCRIBE_OPTION4;
                break;
            case '5':
                $result = FS_INQUIRY_DESCRIBE_OPTION5;
                break;
            case '6':
                $result = FS_FORM_OTHERS;
                break;
        }
        return $result;
    }

    /*
     * 公共的方法 - 处理 interest 字符串
     * @param $str interest字符串
     * @return 处理之后的interest
     */
    public function get_inquiry_interest_str($str){
        $result = '';
        switch ($str){
            case '1':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION1;
                break;
            case '2':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION2;
                break;
            case '3':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION3;
                break;
            case '4':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION4;
                break;
            case '5':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION5;
                break;
            case '6':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION6;
                break;
            case '7':
                $result = FS_INQUIRY_SOLUTION_INTEREST_OPTION7;
                break;
            case '8':
                $result = FS_FORM_OTHERS;
                break;
        }
        return $result;
    }

    /*
    * 公共的方法 - 新增的虚拟状态，审查中
    * 2018.12.5 fairy
    * 等后期可以优化成销售查看状态，在设置成reviewing，可以去掉这个方法
    * @param $prefix 前缀
    * @return 报价单号字符串
    */
    public function check_add_inquiry_status($inquiry_status,$created_at){
        if($inquiry_status==1) {
            $time_cha = time() - strtotime($created_at);
            if ($time_cha>12*60*60) { //大于12小时，设置为审查中
                $inquiry_status = 5;
            } else {
                $inquiry_status = 1;
            }
        }
        return $inquiry_status;
    }

    /*
     * 公共的方法 - 生成报价单号
     * @param $prefix 前缀
     * @return 报价单号字符串
     */
    public function create_inquiry_number($prefix = 'RQC')
    {
        global $db;
        //询盘编号
        $new_number = $db->Execute('select inquiry_number from customer_inquiry where inquiry_number like "' . $prefix . date('ymd') . '%' . '" ORDER BY inquiry_number DESC limit 1');//获取今天最新一条编号
        $redis = getRedis();
        $is_not_same_inquiry = true;
        $n = 0;
        $rq_num = (string)$new_number->fields['inquiry_number'];
        while ($is_not_same_inquiry && $n <= 5) {
            $rq_num = $this->_createInquiryNumber($prefix, $rq_num);
            $is_not_same_inquiry = $redis::$is_connect && !($redis::sAdd('inquiriesNumber', $rq_num));
            $n++;
        }
        //设置sAdd 过期时间
        $redis::expire('inquiriesNumber', 50);
        return $rq_num;
    }


    private function _createInquiryNumber($prefix, $lastRq)
    {
        $start = 6 +  strlen($prefix);
        $lastNum = (int)substr($lastRq, $start);
        $order_num = $lastNum + 1;//获取随机数，并加+1递增
        if ($order_num < 10) {//添加0，满足单号位数
            $rq_num = $prefix . date('ymd') . '000' . $order_num;
        } else if ($order_num < 100) {
            $rq_num = $prefix . date('ymd') . '00' . $order_num;
        } else if ($order_num < 1000) {
            $rq_num = $prefix . date('ymd') . '0' . $order_num;
        } else {
            $rq_num = $prefix . date('ymd') . $order_num;
        }
        return $rq_num;
    }

    /*
        * 公共的方法 - 发送申请报价单成功的邮件
        * @return 报价单号字符串
        */
    function send_apply_inquiry_email($inquiry_id, $adminData=[]){
        $customer_inquiry = $this->get_one_inquiry_all_info($inquiry_id,false);
        $customer_info = zen_get_customers_info($_SESSION['customer_id']);
        $customers_firstname=$customer_info[0]['customers_firstname']?$customer_info[0]['customers_firstname']:'';
        $customers_lastname=$customer_info[0]['customers_lastname']?$customer_info[0]['customers_lastname']:'';
        $email_address=$customer_info[0]['customers_email_address']?$customer_info[0]['customers_email_address']:'';

//        $email_address = $customer_inquiry['email'];
        $admin_id = $customer_inquiry['admin_id'];
        $email_username = ucwords($customers_firstname).' '.ucwords($customers_lastname);
        if (!$customers_firstname && !$customers_lastname) $email_username = '';

        get_email_langpac();
        $theme = FS_SEND_EMAIL.$customer_inquiry['inquiry_number'];
        $title_info = FS_SEND_EMAIL_3;
        $tx_info=FS_SEND_EMAIL_1.$customer_inquiry['inquiry_number'].FS_SEND_EMAIL_2;
        if($_SESSION['languages_code']=="jp"){
            $title_info ="お見積もり依頼書";
            $theme="お見積もり依頼".$customer_inquiry['inquiry_number']."は既に受領されました。";
        }
        $html=common_email_header_and_footer($title_info,$tx_info);
        $html_msg = '';
        $email_title = str_replace('INQUIRY_NUMBER',$customer_inquiry['inquiry_number'],FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE);
        if($_SESSION['customer_id']){
            $herf = zen_href_link('inquiry_detail','inquiry_id='.$inquiry_id,'SSL');
        }else{
            $herf ='javascript:;';
        }
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                           '.EMAIL_BODY_COMMON_DEAR.(empty($email_username)? '': ' ').ucwords($email_username).FS_EMAIL_COMMA.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_1.' <a style="color: #0070BC;text-decoration: none" href="'.$herf.'" >'.$customer_inquiry['inquiry_number'].'</a>'.FS_SEND_EMAIL_4.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;font-weight: 600;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_6.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20" >
                        </td>
                    </tr>
                    </tbody>
                </table>';
        if($customer_inquiry['products']){
            $num=count($customer_inquiry['products'])-1;
            foreach ($customer_inquiry['products'] as $k=>$v){
                $attrHtml = '';
                if (isset($v['attributes']) && sizeof($v['attributes'])) {
                    foreach ($v['attributes'] as $xx => $attr) {
                        if ($xx=='length') {
                            $attrHtml .= '<div style="font-size:12px;">'.FS_LENGTH.' : ' . ucwords($attr['length']) . '&nbsp;&nbsp;</div>';
                        } else {
                            $attrHtml .= '<div style="font-size:12px;">' . ucwords($attr['products_options_name']) . ':' . ucwords($attr['products_options_values_name']) . ' </div>';
                        }
                    }
                }

                $product_category_status = get_product_category_status((int)$v['products_id']);
                if($product_category_status==1){
                    $image_stock= '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="60" height="60">';
                }else{
                    $image_stock = get_resources_img($v['products_id'],60,60,'','','',' style="" ');
                }
                $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;padding-left:20px;" width="60">
                                    <a style="text-decoration: none;" href="'.zen_href_link('product_info','products_id='.$v['products_id']).'">
                                        '.$image_stock.'
                                    </a>
                                </td>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" height="20">
                                    <a style="text-decoration: none;color: #232323;" href="'.zen_href_link('product_info','products_id='.$v['products_id']).'">
                                        <span>'.$v['product_name_str'].'<span style="text-decoration: none;color: #999;"> #'.$v['products_id'].'</span></span>
                                    </a>
                                    <div style="padding:5px 0 0 0;color: #616265;">' . $attrHtml . '</div>
                                    <span>'.FS_SEND_EMAIL_8.'<span>'.$v['product_num'].'</span></span>
                                    
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                if($k<$num || $customer_inquiry['comment']){
                    $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="20">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20">
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                }else{
                    $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30">

                                </td>
                            </tr>
                            </tbody>
                        </table>';
                }
            }
        }
        if($customer_inquiry['comment']){
            $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;font-weight: 600;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_5.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;border-radius: 2px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                       '.$customer_inquiry['comment'].'
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table><table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>';
        }

        sendwebmail($email_username, $email_address,'询价入口客户提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME, $theme, $html_msg,'default');

        if ($adminData['service_email']) {
            sendwebmail($adminData['service_name'], $adminData['service_email'],'询价入口客服提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME, $theme, $html_msg,'default');
        }

        if ($adminData['admin_email']) {
            sendwebmail($adminData['admin_name'], $adminData['admin_email'],'询价入口销售提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME, $theme, $html_msg,'default');
        }


        // 并给相应的销售发邮件
//        if($admin_id>0){
//            $admin_name = fs_get_data_from_db_fields('admin_name','admin','admin_id ='.(int)$admin_id ,'limit 1');
//            $admin_email = fs_get_data_from_db_fields('admin_email','admin','admin_id ='.(int)$admin_id ,'limit 1');
//            $email_title = str_replace('INQUIRY_NUMBER',$customer_inquiry['inquiry_number'],FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE_SALE);
//            $text = 'Your customer '.$email_username.' <a style="color: #0070BC;text-decoration: none" href="javascript:;" >'.$email_address.'</a> submitted a quote request <a href="javascript:;" style="color:#0070BC;text-decoration:none">'.$customer_inquiry['inquiry_number'].'</a>, please email the quotation details to the customer within one business day.';
//            $html_msg['EMAIL_BODY'] = str_replace(EMAIL_BODY_COMMON_DEAR.' '.ucwords($email_username).FS_EMAIL_COMMA,EMAIL_BODY_COMMON_DEAR.' '.ucwords($admin_name).FS_EMAIL_COMMA,$html_msg['EMAIL_BODY']);
//            $html_msg['EMAIL_BODY'] = str_replace(FS_SEND_EMAIL_1.' <a style="color: #0070BC;text-decoration: none" href="'.$herf.'" >'.$customer_inquiry['inquiry_number'].'</a>'.FS_SEND_EMAIL_4,$text,$html_msg['EMAIL_BODY']);
//            $html_msg['EMAIL_BODY'] = str_replace(FS_SEND_EMAIL_5,'Customer message',$html_msg['EMAIL_BODY']);
//            $html_admin = common_email_header_and_footer('New Request',$tx_info);
//            $html_msg['EMAIL_HEADER'] = $html_admin['header'];
//            $theme = 'Customer Request: Get a quote '.$customer_inquiry['inquiry_number'];
//            sendwebmail($admin_name, $admin_email, '询价入口销售提醒邮件:'.date('Y-m-d h:i:s',time()), STORE_NAME,$theme, $html_msg,'default');
//        }
    }

    /*
     * 公共的方法 - 发送申请报价单成功的邮件 - 外围页面
     * @return 报价单号字符串
     */
    function send_apply_out_inquiry_email($inquiry_id,$admin_email=''){
        $customer_inquiry = $this->get_one_inquiry($inquiry_id);
        $email_address = $customer_inquiry['email'];
        $description = $customer_inquiry['comment'];
        get_email_langpac();
        $title_info =FS_SEND_EMAIL_3;
        $tx_info=FS_SEND_EMAIL_1.$customer_inquiry['inquiry_number'].FS_SEND_EMAIL_2;
        if($_SESSION['languages_code']=="jp"){
            $title_info ="お見積もり依頼書";
            $theme="お見積もり依頼".$customer_inquiry['inquiry_number']."は既に受領されました。";
        }else{
            $theme = FS_SEND_EMAIL.$customer_inquiry['inquiry_number'];
        }
        $html = common_email_header_and_footer($title_info,$tx_info);
        $html_msg = '';
        if($_SESSION['customer_id']){
            $herf = zen_href_link('inquiry_detail','inquiry_id='.$inquiry_id,'SSL');
        }else{
            $herf ='javascript:;';
        }
        $email_username = $customer_inquiry['firstname'].' '.$customer_inquiry['lastname'];
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                           '.EMAIL_BODY_COMMON_DEAR.' '.ucwords($email_username).FS_EMAIL_COMMA.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_1.'<a style="color: #0070BC;text-decoration: none" href="'.$herf.'" >'.$customer_inquiry['inquiry_number'].'</a>'.FS_SEND_EMAIL_4.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>';
        if($description){
            $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;font-weight: 600;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_5.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;border-radius: 2px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                       '.$description.'
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>';
        }
        $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>';
        sendwebmail($email_username, $email_address,'外围询价入口客户提醒邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME, $theme, $html_msg,'default');
        // 并给相应的销售发邮件
        if($admin_email){
            $admin_name = fs_get_data_from_db_fields('admin_name','admin','admin_email ="'.$admin_email.'"','limit 1');
            $html_msg['EMAIL_BODY'] = str_replace('EMAIL_BODY_COMMON_DEAR '.ucwords($email_username).FS_EMAIL_COMMA,'EMAIL_BODY_COMMON_DEAR '.ucwords($admin_name).FS_EMAIL_COMMA,$html_msg['EMAIL_BODY']);
            $html_msg['EMAIL_BODY'] = str_replace(FS_SEND_EMAIL_1.'<a style="color: #0070BC;text-decoration: none" href="'.$herf.'" >'.$customer_inquiry['inquiry_number'].'</a>'.FS_SEND_EMAIL_4,'Your customer '.$email_username.' <a style="color: #0070BC;text-decoration: none" href="javascript:;" >'.$email_address.'</a> submitted a quote request <a href="javascript:;" style="color:#0070BC;text-decoration:none">'.$customer_inquiry['inquiry_number'].'</a>, please email the quotation details to the customer within one business day.',$html_msg['EMAIL_BODY']);
            $html_msg['EMAIL_BODY'] = str_replace(FS_SEND_EMAIL_5,'Customer message',$html_msg['EMAIL_BODY']);
            $html_admin = common_email_header_and_footer('New Request',$tx_info);
            $html_msg['EMAIL_HEADER'] = $html_admin['header'];
            $theme = 'Customer Request: Get a quote '.$customer_inquiry['inquiry_number'];
            sendwebmail($admin_email, $admin_email, '外围询价入口销售提醒邮件:'.date('Y-m-d h:i:s',time()), STORE_NAME,$theme, $html_msg,'default');
        }
        // 并给相应的销售发邮件
    }

    /*
     * 公共的方法 - 转换价格字符串
     * @return 价格字符串
     */
    function get_price_str($price,$currency){
        $currency_value = zen_get_currencies_value_of_code($currency);
        return $this->currencies->update_format($price, false, $currency, $currency_value);
    }

    /*
     * 公共的方法 - 获取产品的单价 没有属性价格
     * @param $inquiry_status 报价用户关注点
     * @param bool $for_uk_show: 是否为了uk展示。用于添加到数据的话，这个一定是false，不然会出错
     * @return 价格字符串
     */
    function get_product_price_str($products_id,$products_price,$attributes,$tax_class_id,$current_currency='',$for_uk_show=false){

        $result = array();
        !$this->wholesaleproducts?$this->set_wholesaleproducts():'';
        $current_currency = $current_currency?$current_currency:$_SESSION['currency'];
        $currency_value = $this->currencies->currencies[$current_currency]['value'];
        // fairy 2019.2.21 add 组合产品主产品价格
        //把属性值存到一个数组  计算有属性的组合产品价格
        $combination_arr = array();
        $attr_str = '';
        if($attributes['attributes']){
            foreach ($attributes['attributes']  as $value){
                $combination_arr[] = (int)$value;
            }
        }
        if($combination_arr){
            $attr_str = reorder_options_values($combination_arr);
        }
        $is_composite_products = false;
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts(intval($products_id),'',$attr_str);
            $composite_product_price = $CompositeProducts->get_composite_product_price(true,$current_currency);
            if(!empty($composite_product_price['composite_product_price'])){
                $is_composite_products = true;
            }
        }
        if ($is_composite_products) {
            $result['products_price_original'] = $composite_product_price['composite_product_price_original']; //产品的原价，不带有单位
            $result['products_price_original_current'] = $composite_product_price['composite_product_origin_current']; //产品的原价，不带有单位,单位是当时币种
            $result['products_price_original_str'] = $composite_product_price['composite_product_price_original_str'];
            $result['products_price_finial'] = $composite_product_price['composite_product_price']; //企业价格的处理之后的，最终单价，不带单位
            $result['products_price_finial_current'] = $composite_product_price['composite_product_price_current']; //企业价格的处理之后的，最终单价，不带单位,单位是当时币种
            $result['products_price_finial_str'] =  $composite_product_price['composite_product_price_str'];
            return $result;
        }
        if(AU_use_gsp_tax($products_id) && $_GET['main_page']!="inquiry"){
            $products_price = get_gsp_tax_price('AU',$products_price);
        }
        if (!in_array((int)$products_id, $this->wholesaleproducts)) {
            $products_price = get_products_all_currency_final_price($products_price * $currency_value);
        } else {
            $products_price = get_products_specail_currency_final_price($products_price * $currency_value);
        }
        $attributes_price = $attributes?$this->attributes_price($products_id,$attributes,$for_uk_show):0;

        if (isset($_SESSION['member_level'])) { //企业价格的处理
            $products_prices_finial = get_customers_products_level_price($products_price + $attributes_price * $currency_value, $_SESSION['member_level'],(int)$products_id);
            $products_prices_finial = $products_prices_finial / $currency_value;
        } else {
            $products_prices_finial = $products_price / $currency_value;
        }
        $products_price_original = $products_price / $currency_value + $attributes_price;
        $products_price_original = zen_round($products_price_original * $currency_value, 2) / $currency_value;
        $result['products_price_original'] = $products_price_original; //产品的原价，不带有单位
        $result['products_price_original_current'] = $this->currencies->fs_format_new($products_price_original,true,$current_currency,$currency_value); //产品的原价，不带有单位,单位是当时币种
        $result['products_price_original_str'] = $this->currencies->display_price_rate(zen_round(($products_price_original*$currency_value),2),0,1);
        // 和购物车的$productsPriceEach对比。
        // 购物车类中onetime_charges 不在使用
        $result['products_price_finial'] = $products_prices_finial; //企业价格的处理之后的，最终单价，不带单位
        $result['products_price_finial_current'] = $this->currencies->fs_format_new($products_prices_finial,true,$current_currency,$currency_value); //企业价格的处理之后的，最终单价，不带单位,单位是当时币种
        $result['products_price_finial_str'] =  $this->currencies->display_price_rate(zen_round(($products_prices_finial*$currency_value),2), zen_get_tax_rate($tax_class_id), 1);
        return $result;

    }

    /*
    * 公共的方法 - 整理产品属性
    * @param  array $attributes_all_arr：get_one_inquiry_products_attributes方法的返回值
    * @param int $products_id：产品id
    * @param int $product_qty：产品购买数量
    * @return array：返回整理后的产品属性
    */
    public function get_one_products_attributes_str($attributes_all_arr,$products_id,$product_qty){
        global $db;
        // $attributeHiddenField = "";
        !$this->optionArr?$this->set_optionArr():'';
        $optionArr = $this->optionArr;

        $attributes_arr = $attributes_all_arr['attributes'];
        $attributes_column_arr = $attributes_all_arr['attributes_column'];
        $attributes_text_arr = $attributes_all_arr['attributes_text'];
        $attributes_customized = $attributes_all_arr['attributes_customized'];
        //$fiber_count = set_fibers_count_attribute($products_id, $attributes_arr);

        $attrArray = false;
        if (isset($attributes_arr) && is_array($attributes_arr)) {
            if (PRODUCTS_OPTIONS_SORT_ORDER == '0') {
                $options_order_by = ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
            } else {
                $options_order_by = ' ORDER BY popt.products_options_name';
            }
            if (isset($attributes_arr['length'])) {
                $length_s = get_outer_jacket_length($attributes_arr['length']);
            } else {
                $length_s = 1;
            }
//var_dump($attributes_arr);die;
            foreach ($attributes_arr as $option => $value) {
                if ($option != 'length') { // 属性
                    $attributes = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                         FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                         WHERE pa.products_id = :productsID
                         AND pa.options_id = :optionsID
                         AND pa.options_id = popt.products_options_id
                         AND pa.options_values_id = :optionsValuesID
                         AND pa.options_values_id = poval.products_options_values_id
                         AND popt.language_id = :languageID
                         AND poval.language_id = :languageID " . $options_order_by;

                    $attributes = $db->bindVars($attributes, ':productsID', $products_id, 'integer');
                    $attributes = $db->bindVars($attributes, ':optionsID', str_replace(TEXT_PREFIX,"",$option), 'integer');
                    $attributes = $db->bindVars($attributes, ':optionsValuesID', $value, 'integer');
                    $attributes = $db->bindVars($attributes, ':languageID', $_SESSION['languages_id'], 'integer');
                    $attributes_values = $db->Execute($attributes);

                    $option_name = $attributes_values->fields['products_options_name'];
                    $value_name = $attributes_values->fields['products_options_values_name'];
                    //clr 030714 determine if attribute is a text attribute and assign to $attr_value temporarily
                    if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) { // 用户输入文字类型
                        // $attributeHiddenField .= zen_draw_hidden_field('attribute['.$i.'][' . TEXT_PREFIX . $option . ']', $products[$i]['attributes_values'][$option]);

                        if(strpos($option,TEXT_PREFIX)!==false){
                            $attr_value=  $attributes_text_arr[str_replace(TEXT_PREFIX,"",$option)];
                        }else{
                            $attr_value = htmlspecialchars($attributes_text_arr[$option], ENT_COMPAT, CHARSET, TRUE);
                        }
                    }else {
                        // $attributeHiddenField .= zen_draw_hidden_field('attribute['.$i.'][' . $option . ']', $value);
                        $attr_value = $value_name;
                    }

                    $attrArray[$option]['products_options_name'] = $option_name;
                    $attrArray[$option]['options_values_id'] = $value;
                    $attrArray[$option]['products_options_values_name'] = $attr_value;
                    if(isset($attributes_customized[$value]) && !empty($attributes_customized[$value])){
                        $attrArray[$option]['products_options_values_name'] = $attributes_customized[$value];
                    }

                    $outer_jacket_options_values_price = get_outer_jacket_options_values_price((int)$option, $attributes_values->fields['options_values_price'], $length_s);
                    $attributes_values->fields['options_values_price'] = $outer_jacket_options_values_price;
                    if ($re = fs_attribute_column_option_value_price_other($attributes_column_arr[$option][$value], $length_s)) { //层叠属性
                        $attributes_values->fields['options_values_price'] = $re[0];
                        $attributes_values->fields['price_prefix'] = $re[1];
                        if ($re[1] == '-') {
                            $attrArray[$option]['price_prefix'] = '-';
                        }
                    }
                    $attrArray[$option]['options_values_price'] = $attributes_values->fields['options_values_price'];
                    $attrArray[$option]['price_prefix'] = $attributes_values->fields['price_prefix'];

                } else { //长度
                    $attributes = $db->getAll("select id,price_prefix,length_price,length,product_id,sign,custom from products_length where product_id = '" . $products_id . "' and id = '$value'");
                    if ($attributes) {
                        $attrArray[$option]['length'] = $attributes[0]['length'];
                        $attrArray[$option]['id'] = $value;
                        if ($attributes[0]['price_prefix'] == "+") {
                            $attrArray[$option]['length_price'] = get_discount_price($attributes[0]['length_price'],$product_qty, $products_id);
                        } else {
                            $attrArray[$option]['length_price'] = $attributes[0]['length_price'];
                        }
                        $attrArray[$option]['price_prefix'] = $attributes[0]['price_prefix'];
                        //$attributeHiddenField .= zen_draw_hidden_field('attribute['.$i.'][length]', $value);
                    }
                }
            }
        }
//        if(!$attributeHiddenField){ // 每个产品都有属性input，产品属性为空的时候，属性input为空
//            $attributeHiddenField .= zen_draw_hidden_field('attribute['.$i.']', '');
//        }
        return $attrArray;
    }

    /*
     * 公共的方法 - 根据属性，获取属性价格
     * @param int $products_id：产品id
     * @param array $attributes_all_arr：get_one_inquiry_products_attributes方法的返回值
     * @param bool $for_uk_show: 是否为了uk展示。用于添加到数据的话，这个一定是false，不然会出错
     * @global 属性价格
     */
    function attributes_price($products_id,$attributes_all_arr,$for_uk_show=false){
        global $db;
        !$this->optionArr?$this->set_optionArr():'';
        $optionArr = $this->optionArr;
        $attributes_price = 0;
        if(is_array($attributes_all_arr)  && !empty($attributes_all_arr['attributes'])){
            $attributes = $attributes_all_arr['attributes'];
            $attributes_column_arr = $attributes_all_arr['attributes_column'];
            //$fiber_count = set_fibers_count_attribute($products_id, $attributes);

            if (isset($attributes['length'])) {
                $length_s = get_outer_jacket_length($attributes['length']);
            } else {
                $length_s = 1;
            }
            if (isset($attributes)) {
                //先重新验证一下层级属性产品的column_id数据是否正确start
                $column_id = zen_get_products_column_id($products_id);
                //如果当前产品有属性，判断其是否是层级属性产品
                if($column_id){
                    //是层级属性产品，验证其对应的层级属性对应关系是否正确
                    $id_column = array();
                    $id_column = get_products_columnID($attributes);
                    //返回正确的属性值对应的层级关系的column_id
                    $id_column = get_value_right_column($column_id,$id_column);
                    $attributes_column_arr = $id_column;
                }

                reset($attributes);
                $fiberValue = 0;
                while (list($option, $value) = each($attributes)) {
                    if($option ==21) $fiberValue = $value; //根据客户选择的fiber count属性和长度 额外计算线轴加价
                    if ($option != 'length') {
                        if($option !=341) {//线轴加价的属性价格额外计算
                            $attribute_price_query = "select price_prefix,products_attributes_id,attributes_discounted,options_values_price,options_id,
                        attributes_price_words_free,attributes_price_letters_free,attributes_price_words,attributes_price_letters
                        from " . TABLE_PRODUCTS_ATTRIBUTES . "
                        where products_id = '" . (int)$products_id . "'
                        and options_id = '" . (int)$option . "'
                        and options_values_id = '" . (int)$value . "'";

                            $attribute_price = $db->Execute($attribute_price_query);

                            $new_attributes_price = 0;
                            if ($attribute_price->fields['price_prefix'] == '-') {
                                // calculate proper discount for attributes
                                if ($attribute_price->fields['attributes_discounted'] == '1') {
                                    $new_attributes_price = $attribute_price->fields['options_values_price'];
                                    $attributes_price -= ($new_attributes_price);
                                } else {
                                    $attributes_price -= $attribute_price->fields['options_values_price'];
                                }
                            } else {
                                if ($attribute_price->fields['attributes_discounted'] == '1') {
                                    $new_attributes_price = $attribute_price->fields['options_values_price'];
                                    $outer_jacket_options_values_price = get_outer_jacket_options_values_price($option, $new_attributes_price, $length_s);
                                    $new_attributes_price = $outer_jacket_options_values_price;

                                    if ($re = fs_attribute_column_option_value_price_other($attributes_column_arr[$option][$value], $length_s)) { //层叠属性
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
                                    $outer_jacket_options_values_price = get_outer_jacket_options_values_price($option, $attribute_price->fields['options_values_price'], $length_s);
                                    $new_attributes_price = $outer_jacket_options_values_price;

                                    if ($re = fs_attribute_column_option_value_price_other($attributes_column_arr[$option][$value], $length_s)) { //层叠属性
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
                            }
                        }


                    } else {
                        //length   实时获取length_price
                        $priceArr = get_length_range_price($products_id, $length_s,$fiberValue);
                        $attributes_price += $priceArr['length_price'];


//                        $list = $db->getAll("select price_prefix,length_price,weight from products_length where id = '$value' and product_id = '" . (int)$products_id . "'");
//                        if ($list) {
//                            if ($list[0]['price_prefix'] == '+') {
//                         $attributes_price += get_discount_price($list[0]['length_price'], $qty, (int)$products_id);
//                                $attributes_price += $list[0]['length_price'];
//                            } elseif ($list[0]['price_prefix'] == '-') {
//                                $attributes_price -= $list[0]['length_price'];
//                            }
//                        }
                    }
                }
            }
        }
        //如果是主站或者UK的英镑币种
        if($for_uk_show && in_array($_SESSION['languages_code'],array('uk','en')) && $_SESSION['currency']=="GBP"){
            $attributes_price = $attributes_price*1.05;
        }

        return $attributes_price;
    }

    /*
     * 检查产品是否在报价的cookie里面
     * @para int $products_id：产品id
     * @return bool 返回是否存在
     */
    public function inquiry_cache_products_number($products_id){
        if($_COOKIE['fs_inquiry_products']){
            $inquiry_products = unserialize($_COOKIE['fs_inquiry_products']);
            foreach ($inquiry_products as $key => $val){
                if($products_id == $key){
                    return $val;
                }
            }
            return 0;
        }else{
            return 0;
        }
    }

    /*
     * 获取一个报价流程图一个按钮的html字符串
     * fairy 2018.12.05 add
     * @para string $content：显示的内容
     * @para string $position：start\end\center，li的位置
     * @para string $color：green\grey\default，li的颜色
     * @return string：html字符串
     */
    public function get_inquiry_flow_one($content='',$position='center',$color="default",$time=""){
        $li_class = '';
        if ($_GET['main_page'] == 'inquiry_detail' && $_SESSION['languages_code'] == 'jp') {
            $time = str_replace('午後', '', $time);
            $time = str_replace('午前', '', $time);
        }
        switch ($position){
            case 'start':  $li_class .= ' schedule_start';break;
            case 'end':  $li_class .= ' schedule_end';break;
        }
        switch ($color){
            case 'grey':  $li_class .= ' schedule_start_gagy active';break;
            case 'green':  $li_class .= ' active';break;
        }
        $class="";
        if($position!="start"){
            $class= " css_tow";
        }else{
            $class= " css_one";
        }

        if(isMobile()){
            return '<li class="'.$li_class.'">
        <span class="details_Point"><em></em></span>
            <div class="details_schedule_left'.$class.'">'.$time.'</div>
            <p class="details_schedule_right new_alone_padding_left" >'.$content.'</p>
        </li>';
        }else {
            return '<li class="' . $li_class . '">
        <div class="schedule_proint">
            <i class="hollow"></i>
            <div class="current_progress' . $class . '" style="display: block">' . $time . '</div>
            <div class="new_details_schedule" style="display: block;">' . $content . '</div>
        </div></li>';
        }
    }

    /**
     * add by rebirth  04/24/2019
     * 专用于get quote 的选择产品阶段时的fmt产品获取其子产品的原始价格字符串
     *
     * @param $id        //产品id
     * @param $qty       //产品数量
     * @param $currency  //币种code
     * @param array $attributes //有属性的组合产品 根据选择的属性 查询对应的子产品
     * @return string    //子产品的价格字符
     */
    public function get_fmt_products_son_str($id , $qty , $currency = '',$attributes= ''){
        $composite_str = '';
        $composite_arr = array();
        if (class_exists('classes\CompositeProducts')) {
            if($attributes && is_array($attributes)){
                foreach ($attributes as $option=>$value){
                    $composite_arr[] = (int)$value;
                }
                if($composite_arr){
                    $composite_str = reorder_options_values($composite_arr);
                }
            }
            $Composite = new classes\CompositeProducts((int)$id,'',$composite_str);
            $composite_str = $Composite->get_products_composite($qty,'',$currency,true,'',false);
        }
        return $composite_str;
    }

    public function get_inquiry_cart_number(){
        $number = 0;
        if($this->contents){
            foreach ($this->contents as $key=>$value){
                if($value['qty']>0){
                    $number+=$value['qty'];
                }
            }
        }
        return $number;
    }

    /**
     * 获取产品底价
     * @param $productsId  产品id
     * @param $num  产品数量
     * @return $discount  产品折扣率
     */
    function  get_product_min_price($productId,$num)
    {
        global $db;
        $data = $db->getAll('select should_price ,num ,discount from products_should_price where products_id=' . $productId);
        $discount = 1;
        if (count($data)) { //有值
            foreach ($data as $v) {
                $arr = explode('-', $v['num']);
                if (count($arr) > 1) {  //两个数量之间 如50-100
                    if ($num >= $arr[0] && $num <= $arr[1]) {   //在区间内
                        $discount = $v['discount'];
                    }
                } else {
                    $arr2 = explode('+', $v['num']);
                    if (count($arr2) > 1) { //某数量之上  如 100+
                        if ($num >= $arr2[0]) {
                            $discount = $v['discount'];
                        }
                    }
                }

            }

        }

        return $discount;

    }

    /*
     *报价产品单独结算 add by ternence
     */
    function add_quote($products_id, $qty = '1', $attributes = '', $notify = true, $id_column = array(),$type=3)
    {
        global $db;
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

        $qty = $this->adjust_quantity($qty, $products_id, 'shopping_cart');
        $this->contents[$products_id] = array('qty' => (float)$qty,'is_gift'=>0);
        // insert into database
        if (isset($_SESSION['customer_id'])) {
            $sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
                              (customers_id, products_id, customers_basket_quantity,
                              customers_basket_date_added,save_type) 
                              values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
                $qty . "', '" . date('Ymd') . "',".$type.")";

            $db->Execute($sql);
        }
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
                    }
                }
                if (!$blank_value) {
                    if (is_array($value)) {
                        reset($value);
                        if (strpos($option, 'upload_prefix_') !== false) {
                            $option = substr($option, strlen('upload_prefix_'));
                            $attr_value = $value['products_options_value_text'];
                            $real_file = $value['upload_file'];
                            $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                            $is_attr_file = true;
                        }
                    }
                    // insert into database
                    //CLR 020606 update db insert to include attribute value_text. This is needed for text attributes.
                    //CLR 030228 add zen_db_input() processing
                    if (isset($_SESSION['customer_id'])) {
                        $columnID = 0;
                        //              if (zen_session_is_registered('customer_id')) zen_db_query("insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text) values ('" . (int)$customer_id . "', '" . zen_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "', '" . zen_db_input($attr_value) . "')");
                        if (is_array($value) && !$is_attr_file) {
                            reset($value);
                            while (list($opt, $val) = each($value)) {

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
                            $products_options_sort_order = zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
                            $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                                      (customers_id, products_id, products_options_id, products_options_value_id,column_id, products_options_value_text, products_options_sort_order,save_type,upload_file)
                                      values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
                                (int)$option . "', '" . (int)$value . "'," . $columnID . ", '" . $attr_value . "', '" . $products_options_sort_order . "'," . $type . " ,'".$real_file."')";
                            $db->Execute($sql);
                        }
                    }
                }
            }
        }

        $this->cartID = $this->generate_cart_id();
    }

    function inquiry_gerenal_products($attr_product_id){
     global $db,$currencies;
        $product_id = (int)$attr_product_id;
        $show_onetime_charges_description = 'false';
        $show_attributes_qty_prices_description = 'false';
        $flag_show_weight_attrib_for_this_prod_type = SHOW_PRODUCT_INFO_WEIGHT_ATTRIBUTES;
        // limit to 1 for performance when processing larger tables
        $sql = "select count(*) as total
          from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
          where    patrib.products_id='" . (int)$product_id . "'
            and      patrib.options_id = popt.products_options_id  
            and      popt.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
            " and    patrib.attributes_status = 1 and popt.products_options_status = 1 limit 1";

        $pr_attr = $db->Execute($sql);
        $option_remark = array();
        $new_option_id = array();

        if ($pr_attr->fields['total'] > 0) {
            if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
                $options_order_by= ' order by LPAD(popt.products_options_sort_order,11,"0")';
            } else {
                //$options_order_by= ' order by popt.products_options_name';
                $options_order_by= ' order by patrib.products_attributes_id desc';
            }

            $sql = "select distinct popt.products_options_id, popt.products_options_name, popt.products_options_sort_order,
                              popt.products_options_type, popt.products_options_length, popt.products_options_comment,
                              popt.products_options_size,popt.related_option_id,popt.products_options_word,
                              popt.products_options_images_per_row,
                              popt.products_options_images_style,
                              popt.products_options_rows,popt.products_options_count,patrib.is_custom,
                              popt.options_placeholder
              from        " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
              where           patrib.products_id='" . (int)$product_id . "'
              and             patrib.options_id = popt.products_options_id
              and             popt.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
                " and     patrib.attributes_status = 1 and  popt.products_options_status = 1 ".$options_order_by;
            $products_options_names = $db->Execute($sql);

            // iii 030813 added: initialize $number_of_uploads
            $number_of_uploads = 0;

            if ( PRODUCTS_OPTIONS_SORT_BY_PRICE =='1' ) {
                //$order_by= ' order by LPAD(pa.products_options_sort_order,11,"0"), pov.products_options_values_name';
                $order_by= ' order by LPAD(pov.products_options_values_sort_order,11,"0"), pov.products_options_values_name';
            } else {
                // $order_by= ' order by LPAD(pa.products_options_sort_order,11,"0"), pa.options_values_price';
                $order_by= ' order by LPAD(pov.products_options_values_sort_order,11,"0"), pa.options_values_price';

            }

            //$discount_type = zen_get_products_sale_discount_type((int)$product_id);
            //$discount_amount = zen_get_discount_calc((int)$product_id);

            $zv_display_select_option = 0;

            //记录初始化属性:$custom_attribute_data['all_Attr']=>带属性项+属性值  $custom_attribute_data['attr']=>属性值
            $custom_attribute_data['all_Attr'] = '';
            $custom_attribute_data['attr'] = '';
            $options_data = [];
            while (!$products_options_names->EOF) {
                $products_options_array = array();
                $option_value_array = array();
                $options_data[] = (int)$products_options_names->fields['products_options_id'];//属性ID
                /*
                pa.options_values_price, pa.price_prefix,
                pa.products_options_sort_order, pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,
                pa.attributes_default, pa.attributes_discounted, pa.attributes_image
                */

                $sql = "select    pov.products_options_values_id,
                        pov.products_options_values_name,pa.del_color,
                        pa.*
              from      " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
              where     pa.products_id = '" . (int)$product_id . "'
              and       pa.options_id = '" . (int)$products_options_names->fields['products_options_id'] . "'
              and       pa.options_values_id = pov.products_options_values_id
              and       pov.language_id = '" . (int)$_SESSION['languages_id'] . "' " .$order_by;
                $products_options = $db->Execute($sql);

                $products_options_value_id = '';
                $products_options_details = '';
                $products_options_details_noname = '';
                $tmp_radio = '';
                $tmp_checkbox = '';
                $tmp_html = '';
                $selected_attribute = false;

                $tmp_attributes_image = '';
                $tmp_attributes_image_row = 0;
                $show_attributes_qty_prices_icon = 'false';
                $i=0;
                while (!$products_options->EOF) {
                    $i++;
                    // reset
                    $products_options_display_price='';
                    $new_attributes_price= '';
                    $price_onetime = '';
                    $option_value_array[] = $products_options->fields['products_options_values_id'];
//				if((int)$products_options_names->fields['products_options_id']==2 && $i==1){
//					$products_options_array[] = array('id' => 'all',
//													'text' => FS_PRODUCT_INFO_BRAND_CHOOSE);
//				}
                    $products_options_array[] = array('id' => $products_options->fields['products_options_values_id'],
                        'text' => $products_options->fields['products_options_values_name']);

                    if (((CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == '') or (STORE_STATUS == '1')) or ((CUSTOMERS_APPROVAL_AUTHORIZATION == '1' or CUSTOMERS_APPROVAL_AUTHORIZATION == '2') and $_SESSION['customers_authorization'] == '') or (CUSTOMERS_APPROVAL == '2' and $_SESSION['customers_authorization'] == '2') or (CUSTOMERS_APPROVAL_AUTHORIZATION == '2' and $_SESSION['customers_authorization'] != 0) ) {

                        $new_attributes_price = '';
                        $new_options_values_price = 0;
                        $products_options_display_price = '';
                        $price_onetime = '';
                    } else {
                        // collect price information if it exists
                        if ($products_options->fields['attributes_discounted'] == 1) {
                            // apply product discount to attributes if discount is on
                            $new_attributes_price = $products_options->fields['options_values_price'];
//                       $new_attributes_price = zen_get_attributes_price_final($products_options->fields["products_attributes_id"], 1, '', 'false');
//                       $new_attributes_price = zen_get_discount_calc((int)$product_id, true, $new_attributes_price);
                        } else {
                            // discount is off do not apply
                            $new_attributes_price = $products_options->fields['options_values_price'];
                        }

                        // reverse negative values for display
                        if ($new_attributes_price < 0) {
                            $new_attributes_price = -$new_attributes_price;
                        }

                        if ($products_options->fields['attributes_price_onetime'] != 0 or $products_options->fields['attributes_price_factor_onetime'] != 0) {
                            $show_onetime_charges_description = 'true';
                            $new_onetime_charges = zen_get_attributes_price_final_onetime($products_options->fields["products_attributes_id"], 1, '');
                            $price_onetime = TEXT_ONETIME_CHARGE_SYMBOL . $currencies->display_price($new_onetime_charges, zen_get_tax_rate($product_info->fields['products_tax_class_id']));
                        } else {
                            $price_onetime = '';
                        }

                        if ($products_options->fields['attributes_qty_prices'] != '' or $products_options->fields['attributes_qty_prices_onetime'] != '') {
                            $show_attributes_qty_prices_description = 'true';
                            $show_attributes_qty_prices_icon = 'true';
                        }

                        if ($products_options->fields['options_values_price'] != '0' and ($products_options->fields['product_attribute_is_free'] != '1' and $product_info->fields['product_is_free'] != '1')) {
                            // show sale maker discount if a percentage
                            if($products_options_names->fields['products_options_id']==60){
                                $products_options_display_price = '';
                            }else if ($products_options_names->fields['products_options_id']==15){
//						$products_options_display_price= ATTRIBUTES_PRICE_DELIMITER_PREFIX . $products_options->fields['price_prefix'] .
//						$currencies->display_price($new_attributes_price, zen_get_tax_rate($product_info->fields['products_tax_class_id'])) .'/m'. ATTRIBUTES_PRICE_DELIMITER_SUFFIX;
                            }else{
//						$products_options_display_price= ATTRIBUTES_PRICE_DELIMITER_PREFIX . $products_options->fields['price_prefix'] .
//						$currencies->display_price($new_attributes_price, zen_get_tax_rate($product_info->fields['products_tax_class_id'])) . ATTRIBUTES_PRICE_DELIMITER_SUFFIX;
                            }
                        } else {
                            // if product_is_free and product_attribute_is_free
                            if ($products_options->fields['product_attribute_is_free'] == '1' and $product_info->fields['product_is_free'] == '1') {
//							$products_options_display_price= TEXT_ATTRIBUTES_PRICE_WAS . $products_options->fields['price_prefix'] .
//							$currencies->display_price($new_attributes_price, zen_get_tax_rate($product_info->fields['products_tax_class_id'])) . TEXT_ATTRIBUTE_IS_FREE;
                            } else {
                                // normal price
                                if ($new_attributes_price == 0) {
                                    $products_options_display_price= '';
                                } else {
//								$products_options_display_price= ATTRIBUTES_PRICE_DELIMITER_PREFIX . $products_options->fields['price_prefix'] .
//								$currencies->display_price($new_attributes_price, zen_get_tax_rate($product_info->fields['products_tax_class_id'])) . ATTRIBUTES_PRICE_DELIMITER_SUFFIX;
                                }
                            }
                        }

                        $products_options_display_price .= $price_onetime;

                    } // approve
                    $products_options_array[sizeof($products_options_array)-1]['text'] .= $products_options_display_price;

                    $products_options->fields['products_attributes_weight'] = 0;
                    if (($flag_show_weight_attrib_for_this_prod_type=='1' and $products_options->fields['products_attributes_weight'] != '0')) {
                        $products_options_display_weight = ATTRIBUTES_WEIGHT_DELIMITER_PREFIX . $products_options->fields['products_attributes_weight_prefix'] . round($products_options->fields['products_attributes_weight'],2) . TEXT_PRODUCT_WEIGHT_UNIT . ATTRIBUTES_WEIGHT_DELIMITER_SUFFIX;
                        //$products_options_array[sizeof($products_options_array)-1]['text'] .= $products_options_display_weight;
                        $products_options_array[sizeof($products_options_array)-1]['text'] .= '';
                    } else {
                        // reset
                        $products_options_display_weight='';
                    }

                    // prepare product options details
                    $prod_id = $product_id;
                    //die($prod_id);
                    if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE or $products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT or $products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_CHECKBOX or $products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_RADIO or $products_options->RecordCount() == 1 or $products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_READONLY) {
                        $products_options_value_id = $products_options->fields['products_options_values_id'];
                        if ($products_options_names->fields['products_options_type'] != PRODUCTS_OPTIONS_TYPE_TEXT and $products_options_names->fields['products_options_type'] != PRODUCTS_OPTIONS_TYPE_FILE) {
                            $products_options_details = $products_options->fields['products_options_values_name'];
                        } else {
                            // don't show option value name on TEXT or filename
                            $products_options_details = '';
                        }
                        if ($products_options_names->fields['products_options_images_style'] >= 3) {
                            $products_options_details .= $products_options_display_price . ($products_options->fields['products_attributes_weight'] != 0 ? '<br />' . $products_options_display_weight : '');
                            $products_options_details_noname = $products_options_display_price . ($products_options->fields['products_attributes_weight'] != 0 ? '<br />' . $products_options_display_weight : '');
                        } else {
                            $products_options_details .= ($products_options->fields['products_attributes_weight'] != 0 ? '  ' . $products_options_display_weight : '');
                            $products_options_details_noname = $products_options_display_price . ($products_options->fields['products_attributes_weight'] != 0 ? '  ' . $products_options_display_weight : '');
                        }
                    }
                    // radio buttons
                    if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_RADIO) {
                        $checked_status = "";
                        $selected_attribute = false;
                        switch ($products_options_names->fields['products_options_images_style']) {
                            case '0':
                                //属性值提示语
                                $option_value_word = '';
                                $option_value_word = fs_get_data_from_db_fields('options_values_word','products_options_values','products_options_values_id='.$products_options_value_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                                if($option_value_word){
                                    $products_options_details .= ' <div class="question_text" style="margin-top: 0;">
								<div class="question_bg"></div>
								<div class="question_text_01 leftjt">
									<div class="arrow"></div>
									<div class="popover-content">
									   '.$option_value_word.'
									</div>
								</div>
							</div>';
                                }
                                if(in_array($products_options_names->fields['products_options_id'],array(921,922,916,905))){
                                    $tmp_radio .=  '<label class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' .zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' .  str_replace(' ','-',strtolower($products_options_names->fields['products_options_name'])) .'-'.  str_replace(' ','-',strtolower($products_options->fields['products_options_values_name'])) . '"'). $products_options_details . '</label>' . "\n";
//						    $tmp_radio .='<option class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">'.$products_options_details.'</option>';

                                }else{
                                    $active = '';
                                    $class = '';
                                    if(in_array($product_id,['75875','75874','75877'])){
                                        $class = ' attribsRadioLabel';
                                        if($products_options_value_id == 7243){
                                            $active = ' active';
                                            $selected_attribute = 'id[297]';
                                        }
                                    }
                                    $tmp_radio .=  '<label class="attribsRadioButton'.$class.$active.' zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' .zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"'). $products_options_details . '</label>';
//                            $tmp_radio .='<option class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">'.$products_options_details.'</option>';
                                    if($products_options_value_id==4262){
                                        if($products_options_names->fields['related_option_id']){
                                            $related_id = $products_options_names->fields['related_option_id'];
                                            $tmp_radio .= '<div class="alone_container" style="display:none"><input id="attrib-'.$related_id.'-0" class="re_input" onblur="change_attribute(this,3)" type="text" value="" size="19" name="ids[text_prefix_'.$related_id.']" placeholder="">';
                                            $option_word = fs_get_data_from_db_fields('products_options_word','products_options','products_options_id='.$related_id.' and language_id='.$_SESSION['languages_id'],'limit 1');
                                            if($option_word){
                                                $tmp_radio .= '<div class="track_orders_wenhao">
										<div class="question_bg"></div>
										<div class="question_text_01 leftjt"><div class="arrow"></div>
										  <div class="popover-content">'.$option_word.'</div>
										</div></div>';
                                            }
                                            $tmp_radio .= '</div>';
                                        }
                                    }
                                    $tmp_radio .= "\n";
                                }

                                break;

                            case '1':
                                $tmp_radio .= '<div class="product_03_08_01">'.zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton one" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ($products_options->fields['attributes_image'] != '' ? zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) . '  ' : '') . '  '.$products_options_details . '</label></div>' . "\n";
                                break;
                            case '2':
                                $tmp_radio .= zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton two" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . ($products_options->fields['attributes_image'] != '' ? '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) : '') . '</label>' . "\n";
                                break;
                            case '3':
                                $tmp_attributes_image_row++;
                                //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                                if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                    $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                    $tmp_attributes_image_row = 1;
                                }

                                if ($products_options->fields['attributes_image'] != '') {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton three" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . $products_options_details_noname . '</label></div>' . "\n";
                                } else {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']',  $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton threeA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . $products_options_details_noname . '</label></div>' . "\n";
                                }
                                break;

                            case '4':
                                $tmp_attributes_image_row++;

                                //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                                if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                    $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                    $tmp_attributes_image_row = 1;
                                }

                                if ($products_options->fields['attributes_image'] != '') {
                                    $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsRadioButton four" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_sta.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
                                } else {
                                    $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsRadioButton fourA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_sta.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
                                }
                                break;

                            case '5':
                                $tmp_attributes_image_row++;

                                //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                                if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                    $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                    $tmp_attributes_image_row = 1;
                                }

                                if ($products_options->fields['attributes_image'] != '') {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton five" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>';
                                } else {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton fiveA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>';
                                }
                                break;
                        }
                    }

                    // checkboxes
                    if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_CHECKBOX) {
                        $string = $products_options_names->fields['products_options_id'].'_chk'.$products_options->fields['products_options_values_id'];
                        if ($_SESSION['cart']->in_cart($prod_id)) {
                            if ($_SESSION['cart']->contents[$prod_id]['attributes'][$string] == $products_options->fields['products_options_values_id']) {
                                $selected_attribute = true;
                            } else {
                                $selected_attribute = false;
                            }
                        } else {
                            //              $selected_attribute = ($products_options->fields['attributes_default']=='1' ? true : false);
                            // if an error, set to customer setting
                            if ($_POST['id'] !='') {
                                $selected_attribute= false;
                                reset($_POST['id']);
                                foreach ($_POST['id'] as $key => $value) {
                                    if (is_array($value)) {
                                        foreach ($value as $kkey => $vvalue) {
                                            if (($key == $products_options_names->fields['products_options_id'] and $vvalue == $products_options->fields['products_options_values_id'])) {
                                                $selected_attribute = true;
                                                break;
                                            }
                                        }
                                    } else {
                                        if (($key == $products_options_names->fields['products_options_id'] and $value == $products_options->fields['products_options_values_id'])) {
                                            // zen_get_products_name($_POST['products_id']) .
                                            $selected_attribute = true;
                                            break;
                                        }
                                    }
                                }
                            } else {
                                $selected_attribute = ($products_options->fields['attributes_default']=='1' ? true : false);
                            }
                        }

                        /*
                        $tmp_checkbox .= zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details .'</label><br />';
                        */
                        switch ($products_options_names->fields['products_options_images_style']) {
                            case '0':
                                //$tmp_checkbox .= zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label><br />' . "\n";
//                        $tmp_checkbox .= '<label>'.zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'" onClick="checkOptions(this.id,\'id\\['.$products_options_names->fields['products_options_id'].'\\]\','.$products_attributes_count.')" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"')  . $products_options_details.'</label>';
                                //针对颜色块
                                if($xt=get_remark_status($products_options_names->fields['products_options_id'])){
                                    if($i == 1){
                                        $tmp_checkbox .= '<div id="show'.$xt.'" class="toggle">';
                                    }
                                    if($products_options->fields['del_color'] != 1){
                                        $tmp_checkbox .= zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"');
                                        $tmp_checkbox .='<label class="lable_color_'.$i.'" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" title="'.$products_options->fields['products_options_values_name'].'"><span></span></label>';
                                    }
                                    if($i == 12){
                                        $tmp_checkbox .= '</div>';
                                    }
                                }elseif($re = $xt=specical_service_status($products_options_names->fields['products_options_id'])){
                                    $option_value_id = str_replace(' ','',strtolower($products_options->fields['products_options_values_name']));
                                    $option_value_id = str_replace(',','',$option_value_id);
                                    $option_value_id = str_replace('/','',$option_value_id);
                                    $option_value_id = str_replace('"','',$option_value_id);
                                    $option_value_id = substr($option_value_id,0,25);
                                    $class=' customLable checkbox_disabled';
                                    $tmp_checkbox .= '<div class="alone_container alone_container_radio">'.zen_draw_checkbox_inquiry_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' .$option_value_id. '"')  . $products_options_details.'</div>';
                                }else{
                                    //custom lable
                                    $onclick_str = '';
                                    $class=' customLable checkbox_disabled';
                                    if($products_options_names->fields['products_options_id']==318){
                                        $onclick_str = 'onclick="show_lables_or_not(\''.$attr_product_id.'\',$(this),false);"';
                                    }else{
                                        if($attr_product_id){
                                            $attr_product = explode(':',$attr_product_id)[1];
                                        }
                                        $onclick_str = 'onclick="show_lables_or_not(\''.$attr_product_id.'\',$(this),true);" attr_pro="'.$attr_product.'"';
                                    }
                                    $tmp_checkbox .= '<div class="alone_container alone_container_radio"><div class="re_radio_container">'.zen_draw_checkbox_inquiry_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"'.$onclick_str.'',true,$products_options_details,$products_options_names->fields['products_options_id']).'</div></div>';
                                }
                                break;
                            case '1':
                                $tmp_checkbox .= zen_draw_checkbox_inquiry_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ($products_options->fields['attributes_image'] != '' ? zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) . '  ' : '') . $products_options_details . '</label><br />' . "\n";
                                break;
                            case '2':
                                $tmp_checkbox .= zen_draw_checkbox_inquiry_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . ($products_options->fields['attributes_image'] != '' ? '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) : '') . '</label><br />' . "\n";
                                break;

                            case '3':
                                $tmp_attributes_image_row++;

                                //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                                if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                    $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                    $tmp_attributes_image_row = 1;
                                }

                                if ($products_options->fields['attributes_image'] != '') {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_inquiry_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . $products_options_details_noname . '</label></div>' . "\n";
                                } else {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_inquiry_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . $products_options_details_noname . '</label></div>' . "\n";
                                }
                                break;

                            case '4':
                                $tmp_attributes_image_row++;

                                //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                                if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                    $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                    $tmp_attributes_image_row = 1;
                                }

                                if ($products_options->fields['attributes_image'] != '') {
                                    $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
                                } else {
                                    $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']',$products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
                                }
                                break;

                            case '5':
                                $tmp_attributes_image_row++;

                                //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                                if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                    $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                    $tmp_attributes_image_row = 1;
                                }

                                if ($products_options->fields['attributes_image'] != '') {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>' . "\n";
                                } else {
                                    $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_field('ids[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>' . "\n";
                                }
                                break;
                        }
                    }


                    // text
                    if (($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT)) {
                        //CLR 030714 Add logic for text option
                        //            $products_attribs_query = zen_db_query("select distinct patrib.options_values_price, patrib.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$product_id . "' and patrib.options_id = '" . $products_options_name['products_options_id'] . "'");
                        //            $products_attribs_array = zen_db_fetch_array($products_attribs_query);
                        if ($_POST['id']) {
                            reset($_POST['id']);
                            foreach ($_POST['id'] as $key => $value) {
                                //echo preg_replace('/txt_/', '', $key) . '#';
                                //print_r($_POST['id']);
                                //echo $products_options_names->fields['products_options_id'].'|';
                                //echo $value.'|';
                                //echo $products_options->fields['products_options_values_id'].'#';
                                if ((preg_replace('/txt_/', '', $key) == $products_options_names->fields['products_options_id'])) {
                                    // use text area or input box based on setting of products_options_rows in the products_options table
                                    if ( $products_options_names->fields['products_options_rows'] > 1) {
                                        $tmp_html = '  <input disabled="disabled" type="text" name="remaining' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . '" size="3" maxlength="3" value="' . $products_options_names->fields['products_options_length'] . '" /> ' . TEXT_MAXIMUM_CHARACTERS_ALLOWED . '<br />';
                                        $tmp_html .= '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="' . $products_options_names->fields['products_options_rows'] . '" cols="' . $products_options_names->fields['products_options_size'] . '" onKeyDown="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" onKeyUp="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . stripslashes($value) .'</textarea>' . "\n";
                                    } else {
                                        $tmp_html = '<div class="alone_container">    
                            <input class="re_input" type="text" onblur="change_attribute(this,3);" name="ids[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" size="' . $products_options_names->fields['products_options_size'] .'" maxlength="' . $products_options_names->fields['products_options_length'] . '" value="' . stripslashes($value) .'" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" placeholder="'.FS_PLACEHOLDER_EG.stripslashes($products_options_names->fields['options_placeholder']).'" />  </div>';
                                    }
                                    $tmp_html .= $products_options_details;
                                    break;
                                }
                            }
                        } else {
                            $tmp_value = $_SESSION['cart']->contents[$product_id]['attributes_values'][$products_options_names->fields['products_options_id']];
                            // use text area or input box based on setting of products_options_rows in the products_options table
                            if ( $products_options_names->fields['products_options_rows'] > 1 ) {
                                $tmp_html = '  <input disabled="disabled" type="text" name="remaining' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . '" size="3" maxlength="3" value="' . $products_options_names->fields['products_options_length'] . '" /> ' . TEXT_MAXIMUM_CHARACTERS_ALLOWED . '<br />';
                                $tmp_html .= '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="' . $products_options_names->fields['products_options_rows'] . '" cols="' . $products_options_names->fields['products_options_size'] . '" onkeydown="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" onkeyup="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . stripslashes($tmp_value) .'</textarea>' . "\n";
                                //                $tmp_html .= '  <input type="reset">';
                            }else{
                                if(get_remark_status($products_options_names->fields['products_options_id'])){
                                    $tmp_html = '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="5" cols="30" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . $tmp_value_html .'</textarea>' . "\n";
                                }else{
                                    $tmp_html = '<div class="alone_container"><input type="text" onblur="change_attribute(this,3);" class="re_input" name="ids[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" size="' . $products_options_names->fields['products_options_size'] .'" maxlength="' . $products_options_names->fields['products_options_length'] . '" value="' . htmlspecialchars($tmp_value) .'" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" placeholder="'.FS_PLACEHOLDER_EG.stripslashes($products_options_names->fields['options_placeholder']).'" /> </div> ';
                                }
                            }
                            $tmp_html .= $products_options_details;
                            $tmp_word_cnt_string = '';
                            // calculate word charges
                            $tmp_word_cnt =0;
                            $tmp_word_cnt_string = $_SESSION['cart']->contents[$product_id]['attributes_values'][$products_options_names->fields['products_options_id']];
                            $tmp_word_cnt = zen_get_word_count($tmp_word_cnt_string, $products_options->fields['attributes_price_words_free']);
                            $tmp_word_price = zen_get_word_count_price($tmp_word_cnt_string, $products_options->fields['attributes_price_words_free'], $products_options->fields['attributes_price_words']);

                            if ($products_options->fields['attributes_price_words'] != 0) {
                                $tmp_html .= TEXT_PER_WORD . $currencies->display_price($products_options->fields['attributes_price_words'], zen_get_tax_rate($product_info->fields['products_tax_class_id'])) . ($products_options->fields['attributes_price_words_free'] !=0 ? TEXT_WORDS_FREE . $products_options->fields['attributes_price_words_free'] : '');
                            }
                            if ($tmp_word_cnt != 0 and $tmp_word_price != 0) {
                                $tmp_word_price = $currencies->display_price($tmp_word_price, zen_get_tax_rate($product_info->fields['products_tax_class_id']));
                                $tmp_html = $tmp_html . '<br />' . TEXT_CHARGES_WORD . ' ' . $tmp_word_cnt . ' = ' . $tmp_word_price;
                            }
                            // calculate letter charges
                            $tmp_letters_cnt =0;
                            $tmp_letters_cnt_string = $_SESSION['cart']->contents[$product_id]['attributes_values'][$products_options_names->fields['products_options_id']];
                            $tmp_letters_cnt = zen_get_letters_count($tmp_letters_cnt_string, $products_options->fields['attributes_price_letters_free']);
                            $tmp_letters_price = zen_get_letters_count_price($tmp_letters_cnt_string, $products_options->fields['attributes_price_letters_free'], $products_options->fields['attributes_price_letters']);

                            if ($products_options->fields['attributes_price_letters'] != 0) {
                                $tmp_html .= TEXT_PER_LETTER . $currencies->display_price($products_options->fields['attributes_price_letters'], zen_get_tax_rate($product_info->fields['products_tax_class_id'])) . ($products_options->fields['attributes_price_letters_free'] !=0 ? TEXT_LETTERS_FREE . $products_options->fields['attributes_price_letters_free'] : '');
                            }
                            if ($tmp_letters_cnt != 0 and $tmp_letters_price != 0) {
                                $tmp_letters_price = $currencies->display_price($tmp_letters_price, zen_get_tax_rate($product_info->fields['products_tax_class_id']));
                                $tmp_html = $tmp_html . '<br />' . TEXT_CHARGES_LETTERS . ' ' . $tmp_letters_cnt . ' = ' . $tmp_letters_price;
                            }
                            $tmp_html .= "\n";
                        }
                    }

                    // file uploads

                    // iii 030813 added: support for file fields
                    if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE) {
                        $number_of_uploads++;
                        if (zen_run_normal() == true and zen_check_show_prices() == true) {
                            // $cart->contents[$product_id]['attributes_values'][$products_options_name['products_options_id']]
                            $tmp_html = '<div class="alone_container"><p class="customized_logo re_input">
							<i class="iconfont icon"></i>
							<em>Upload Your Logo Image</em>
							
							<strong></strong>
							<input type="file" class="input_file file_arr" onchange="change_attribute(this,4)" name="ids['. $products_options_names->fields['products_options_id'] . ']"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"  id="file1"  placeholder="'.stripslashes($products_options_names->fields['options_placeholder']).'">
					      	<input class="product_input_val">
						    </p></div>';
                            //上传文件的提示语
                            $tmp_html .= '<div id="type_msg" class="error_prompt" style="display: none;"></div>';
                        } else {
                            $tmp_html = '';
                        }
                        $tmp_html .= $products_options_details;
                    }


                    // collect attribute image if it exists and to be drawn in table below
                    if ($products_options_names->fields['products_options_images_style'] == '0' or ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE or $products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT or $products_options_names->fields['products_options_type'] == '0') ) {
                        if ($products_options->fields['attributes_image'] != '') {
                            $tmp_attributes_image_row++;

                            //              if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                            if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                $tmp_attributes_image_row = 1;
                            }

                            $tmp_attributes_image .= '<div class="attribImg">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . '</div>' . "\n";
                        }
                    }

                    // Read Only - just for display purposes
                    if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_READONLY) {
                        //            $tmp_html .= '<input type="hidden" name ="ids[' . $products_options_names->fields['products_options_id'] . ']"' . '" value="' . stripslashes($products_options->fields['products_options_values_name']) . ' SELECTED' . '" />  ' . $products_options->fields['products_options_values_name'];
                        $tmp_html .= $products_options_details . '<br />';
                    } else {
                        $zv_display_select_option ++;
                    }


                    // default
                    // find default attribute if set to for default dropdown
                    if ($products_options->fields['attributes_default']=='1') {
                        $selected_attribute = $products_options->fields['products_options_values_id'];
                    }

                    $products_options->MoveNext();

                }

                //echo 'TEST I AM ' . $products_options_names->fields['products_options_name'] . ' Type - ' . $products_options_names->fields['products_options_type'] . '<br />';
                // Option Name Type Display
                if($products_options_names->fields['products_options_id'] !=159){
                    $option_remark_str = '';
                    $custom_option_remark = '';
                    if($products_options_names->fields['products_options_word']){
                        $option_remark_str = getNewWordHtml($products_options_names->fields['products_options_word']);
                    }
                    $html_custom = '';
                    if ($products_options_names->fields['related_option_id']) {
                        $related_id = $products_options_names->fields['related_option_id'];
                        $html_custom .= '<div class="alone_container" style="display:none;"><input id="attrib-' . $related_id . '-0" class="re_input" type="text" value="" size="19" name="id[text_prefix_' . $related_id . ']" placeholder="">';
                        $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                        if ($option_word) {
                            $html_custom .= getNewWordHtml($option_word);
                        }
                        $html_custom .= '</div>';
                    }
                    switch (true) {
                        // text
                        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT):
                            if ($show_attributes_qty_prices_icon == 'true') {
                                $options_name[] = '<label class="attribsInput" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"><span>' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</span>: '.$option_remark_str.'</label>';
                                $option_remark[] = $option_remark_str;
                            } else {
//                    $options_name[] = '<label class="attribsInput" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"></label><span>' . $products_options_names->fields['products_options_name'] . ': '.$option_remark_str.'</span>';

                                $options_name[] = '<label class="attribsInput" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"><span>' . $products_options_names->fields['products_options_name'] . '</span>:'.$option_remark_str.'</label>';
                                $option_remark[] = $option_remark_str;
                            }
                            $options_menu[] = $tmp_html . "\n";
                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 0;
                            break;
                        // checkbox
                        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_CHECKBOX):
                            $option_name_str = $products_options_names->fields['products_options_name'].':';
                            //特殊的 label service（模块产品 展示标签产品的属性）
                            if($products_options_names->fields['products_options_id']==318){
                                $option_name_str = $products_options_names->fields['products_options_name'].FS_OPTIONAL.':';
                            }
                            if ($show_attributes_qty_prices_icon == 'true') {
                                $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $option_name_str;
                                $option_remark[] = $option_remark_str;
                            } else {
                                $options_name[] = $option_name_str;
                                $option_remark[] = $option_remark_str;
                            }
                            $options_menu[] = $tmp_checkbox . "\n";
                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 0;
                            break;
                        // radio buttons
                        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_RADIO):
                            if ($show_attributes_qty_prices_icon == 'true') {
                                $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'].':';
                                $option_remark[] = $option_remark_str;
                            } else {
                                $options_name[] = $products_options_names->fields['products_options_name'].':';
                                $option_remark[] = $option_remark_str;
                            }
                            $options_menu[] = $tmp_radio . "\n";
                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 0;
                            break;
                        // file upload
                        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE):
                            if ($show_attributes_qty_prices_icon == 'true') {
                                $options_name[] = '<div class="attribsUploads" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"><span>' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</span>:'.$option_remark_str.'</div>';
                                $option_remark[] = $option_remark_str;
                            } else {
                                $options_name[] = '<div class="attribsUploads" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"><span>' . $products_options_names->fields['products_options_name'] . '</span>:'.$option_remark_str.'</div>';
                                $option_remark[] = $option_remark_str;
                            }
                            $options_menu[] = $tmp_html . "\n";
                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 0;
                            break;
                        // READONLY
                        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_READONLY):
                            $options_name[] = $products_options_names->fields['products_options_name'];
                            $option_remark[] = $option_remark_str;
                            $options_menu[] = $tmp_html . "\n";
                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 0;
                            break;
                        // dropdown menu auto switch to selected radio button display


                        /*
                        case ($products_options->RecordCount() == 1 && $products_options_names->fields['products_options_name'] != 'Fiber Count'):
                        if ($show_attributes_qty_prices_icon == 'true') {
                          $options_name[] = '<label class="switchedLabel ONE" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</label>';
                        } else {
                          $options_name[] = $products_options_names->fields['products_options_name'];
                        }
                        $options_menu[] = zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 'selected', 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" class="product_03_08_radio"') . '<label class="attribsRadioButton" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label>' . "\n";
                        $options_comment[] = $products_options_names->fields['products_options_comment'];
                        $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                        break;*/
                        case ($products_options->RecordCount() == 1 && ($products_options_names->fields['products_options_name'] == '18ch Wavelengths' || $products_options_names->fields['products_options_name'] == 'Fiber Diameter' || $products_options_names->fields['products_options_name'] == 'MTP Polarity')):
                            if ($show_attributes_qty_prices_icon == 'true') {
                                $options_name[] = '<label class="switchedLabel ONE" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</label>';
                                $option_remark[] = $option_remark_str;
                            } else {
                                $options_name[] = $products_options_names->fields['products_options_name'];
                                $option_remark[] = $option_remark_str;
                            }
                            $options_menu[] = zen_draw_radio_field('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 'selected', 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" class="product_03_08_radio"') . '<label class="attribsRadioButton" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label>' . "\n";
                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 1;
                            break;


                        default:
                            // normal dropdown menu display
//                            if (isset($_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']])) {
//                                $selected_attribute = $_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']];
//                            } else {
//                                // use customer-selected values
//                                if ($_POST['id'] !='') {
//                                    reset($_POST['id']);
//                                    foreach($_POST['id'] as $key => $value){
//                                        if ($key == $products_options_names->fields['products_options_id']){
//                                            $selected_attribute = $value;
//                                            break;
//                                        }
//                                    }
//                                }else{
//                                    // use default selected set above
//                                }
//                            }



                            if ($show_attributes_qty_prices_icon == 'true') {
                                $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];

                                $option_remark[] = $option_remark_str;
                                $new_option_id = $products_options_names->fields['products_options_id'];
                            } else {
                                $option_remark[] = $option_remark_str;
                                $options_name[] = '<label class="attribsSelect" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '"><span>' . 	$products_options_names->fields['products_options_name'] . '</span>:'.$option_remark_str.'</label>';
                                //DAC产品属性特殊处理 end
                                if($products_options_names->fields['products_options_id']==2){
                                    $options_name[] = '<label class="attribsSelect" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '">'.FS_OPTION_NAME.':'.$option_remark_str.'</label>';
                                }
                                $new_option_id = $products_options_names->fields['products_options_id'];
                            }


                            if(in_array($products_options_names->fields['products_options_id'],array(60,131))){
                                if($products_options_array){
                                    $radio_div = '';
                                    foreach($products_options_array as $k=>$option){
                                        $class = '';
                                        if($k==0){
                                            $radio_div .= '<input type="hidden" id="power_type"  name="id['.$products_options_names->fields['products_options_id'].']" value="'.$option['id'].'">';
                                            $class = 'item_selected';
                                        }

                                        $radio_div .= '<div id="item_0" class="pro_item '.$class.'" onclick="change_type('.$option['id'].','.$prod_id.','.$products_options_names->fields['products_options_id'].',this)"><a href="javascript:void(0)" ><b>'.$option['text'].'</b><i></i></a></div>';

                                    }
                                }
                                $options_menu[] = $radio_div;
                            }else{
                                $selected_attribute = $products_options_array[0]['id'];
                                $custom_attribute_data['all_Attr'] .= $products_options_names->fields['products_options_id'].':'.$selected_attribute.',';
                                $custom_attribute_data['attr'] .= $selected_attribute.',';

                                if($products_options_names->fields['products_options_id']==2){
                                    //Compatible Brands属性项下的Dual Compatibility Solutions属性值需根据不同产品展示不同提示语 Dylan
                                    $productsId = (int)$product_id;
                                    if($selected_attribute==6452){$brandFlag=true;}else{$brandFlag=false;}
                                    $compatibility_placeholder = get_compatibility_placeholder($productsId,true,$brandFlag);
                                    $brandClass = $compatibility_placeholder['brandClass'];
                                    $brandHtml = $compatibility_placeholder['brandHtml'];

                                    // fariy 2018.8.15 对一些提示进行了优化
                                    $options_menu[] = zen_draw_pull_down_inquiry_menu('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_array, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '" rel="AttrSelect"',false,false,$attr_product_id,$products_options_names->fields['products_options_id'],false) . "\n".'';
                                    $options_menu[] = '<div class="alone_container"><input id="attrib-159-0" class="re_input" onblur="change_attribute(this,3)" type="text" value="" size="19" name="ids[text_prefix_159]" placeholder="'.$brandHtml.'" ></div><div class="hpe_error"></div>';
                                }else{

                                    $options_menu[] = zen_draw_pull_down_inquiry_menu('ids[' . $products_options_names->fields['products_options_id'] . ']', $products_options_array, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '" rel="AttrSelect"',false,false,$attr_product_id,$products_options_names->fields['products_options_id'],true) . "\n".$html_custom;
                                }
                            }

                            $options_comment[] = $products_options_names->fields['products_options_comment'];
                            $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                            $options_comment_p[] = 0;
                            $oId = $products_options_names->fields['products_options_id'];
                            break;
                    }
                }
                // attributes images table
                $options_attributes_image[] = trim($tmp_attributes_image) . "\n";
                $products_options_names->MoveNext();
            }
            // manage filename uploads
            $_GET['number_of_uploads'] = $number_of_uploads;
            //zen_draw_hidden_field('number_of_uploads', $_GET['number_of_uploads']);
            zen_draw_hidden_field('number_of_uploads', $number_of_uploads);
            return  array('options_name'=>$options_name,'options_menu'=>$options_menu,'options_comment'=>$options_comment,'options_data'=>$options_data);
        }
        return false;
    }

    function inquiry_gerenal_customized_products($products_id,$options_name,$options_menu,$options_comment,$cPath_array,$html_select_type='',$options_data =[]){
        $html = '';
        if($products_id){
            $html .= '';
            for ($i = 0; $i < sizeof($options_name); $i++) {
                $tit = '';
                $sele = '';
                $spool_class = $spool_display = '';
                if(sizeof($options_name) ==1){
                    $tit = ' new_select_titz01';
                    $sele = ' new_selectz01';
                }

                if($options_data[$i] == 341){
                    $spool_class = 'class="spool_price_proSelct_li"';
                    $spool_display = 'style="display:none;"';
                }
//                if ($act = fiber_optic_network($options_name[$i])) {
//                    $html .= '<li><div id="fiber_'.$act.'" class="product_03_09 product_03_12 fiber_optic_network custom_attribute">';
//                } else {
//                    $html .= '<!-- products attributes -->';
//                    $html .= '<li><div class="product_03_09 product_03_12 custom_attribute">';
//                }
                $html .= '<li '.$spool_class.' '.$spool_display.'><span class="re_select_name'.$tit.'">'.$options_name[$i].'</span>';
                $html .= $options_menu[$i];


                if ('34107' == $products_id) {
                    $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT1);
                }
                if ('28977' == $products_id && "<label class=\"attribsSelect\" for=\"attrib-185\">Package</label>" == $options_name[$i]) {
                    $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT2);
                }
                if ('32623' == $products_id && "<label class=\"attribsSelect\" for=\"attrib-240\">Data Port</label>" == $options_name[$i]) {
                    $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT3);
                }
                if ('32827' == $products_id && "<label class=\"attribsSelect\" for=\"attrib-240\">Data Port</label>" == $options_name[$i]) {
                    $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT4);
                }
                if (in_array($products_id, array(35434, 35535, 35536, 35537, 35538, 35539, 35540, 35541, 35542, 35543)) && "MTP Polarity" == trim(strip_tags($options_name[$i]))) {
                    $html .= fs_product_custom_html_forID(FS_PRODUCTS_POPOVER_CONTENT5);
                }

                if ($options_comment[$i]){
                    if ($cPath_array[0] == 1){
                        $html .= '<div class="track_orders_wenhao">';
                    }else{
                        if (isset($options_comment_p[$i]) && !empty($options_comment_p[$i])){
                            $html .= '<div class="question_text" style="margin-top: -4px;">';
                        } else {
                            if ($cPath_array[2] == 1155) {
                                $html .=  '<div class="track_orders_wenhao">';
                            } else {
                                $html .=  ' <div class="question_text">';
                            }
                        }
                    }
                    $html .= '<div class="question_bg_icon iconfont icon">&#xf228;</div>';
                    $html .= '<div class="question_text_01 leftjt"><div class="arrow"></div>';
                    $html .= '<div class="popover-content">'.$options_comment[$i].'</div>';
                    $html .= '</div></div>';
                }
                $html .= '<div class="ccc"></div></li>';
            }
            $html .= '';
        }
        $data = array(
            'html' => $html,
        );
        return $data;
    }


    /**
     * Notes:
     * User: LiYi
     * Date: 2020/9/8 0008
     * Time: 17:14
     * @param $inquiry_id
     * @param $service1
     * @return int
     */
    function restore_contents_submit_new($inquiry_id, $service1)
    {
        //定制产品匹配标准产品
        $attr_product_id = $attr_option = $len = '';
        $attr = $pro_attributes = [];

        foreach ($this->contents as $key => $val) {
            if ($val['qty'] <= 0 || empty($val['attributes'])) {
                continue;
            }

            foreach ($val['attributes'] as $option => $value) {
                if ($option != "length") {
                    if (!strstr($option, TEXT_PREFIX)) {
                        if (strstr($option, "_chk")) {
                            $attr_option = "_chk" . $value;
                            $option = str_replace($attr_option, '', $option);
                            $attr[] = $value;
                            if (!empty($pro_attributes[$option])) {
                                $pro_attributes[$option] = array($value => $value) + $pro_attributes[$option];
                            } else {
                                $pro_attributes[$option] = array($value => $value);
                            }
                        } else {
                            $pro_attributes[$option] = $value;
                            $attr[] = $value;
                        }
                    } else {
                        $pro_attributes[$option] = $value;
                        $attr[] = $value;
                    }
                } else {
                    $pro_attributes['length'] = $value;
                    $len = fs_get_data_from_db_fields(
                        'length',
                        'products_length',
                        'id=' . $value,
                        'limit 1'
                    );
                }
            }

            $class = new FsCustomRelate((int)$key, $attr, $len);
            $excellentMatch = $class->handle();
            $match_status = 0;
            if ($excellentMatch[0]) {
                $match_status = get_product_status($excellentMatch[0]);
            }

            if ($excellentMatch[0] && $match_status) {
                if (!empty($this->contents[$excellentMatch[0]])) {
                    $this->contents[$excellentMatch[0]]['qty'] = $this->contents[$excellentMatch[0]]['qty'] +
                        $this->contents[$key]['qty'];
                    unset($this->contents[$key]);
                } else {
                    $this->contents[$excellentMatch[0]]['qty'] = $this->contents[$key]['qty'];
                    unset($this->contents[$key]);
                }
            } else {
                $attr_product_id = zen_get_uprid((int)$key, $pro_attributes);
                if ($attr_product_id && empty($this->contents[$attr_product_id])) {
                    $this->contents[$attr_product_id] = $this->contents[$key];
                    unset($this->contents[$key]);
                } else {
                    $this->contents[$attr_product_id]['qty'] = $this->contents[$key]['qty'] +
                        $this->contents[$attr_product_id]['qty'];
                    unset($this->contents[$key]);
                }
            }
        }

        $products_arr = $this->get_products();

        if (is_array($this->contents)) {
            foreach ($this->contents as $products_id => $value) {
                if ($value['color']) {
                    $related_label_pid = fs_get_data_from_db_fields(
                        'related_label_pid',
                        'products',
                        'products_id=' . (int)$products_id,
                        'limit 1'
                    );
                    if ((int)$related_label_pid) {
                        $this->add_inquiry_cart($related_label_pid, 1, $value['color'], true);
                    }
                }

                $qty = $this->contents[$products_id]['qty'];

                if ((int)$qty <= 0) {
                    continue;
                }

                $product = $service1->findInquiryProduct(
                    ['attribute_product_id' => zen_db_input($products_id), 'inquiry_id' => $inquiry_id],
                    ['products_id', 'product_num'],
                    false
                );

                if (empty($product)) {
                    $is_customized = 0;
                    if (strpos($products_id, ":") !== false) {
                        $is_customized = 1;
                    }
                    $product_price = 0;
                    foreach ($products_arr as $k => $v) {
                        if ($v['id'] == $products_id) {
                            $product_price = $v['price'];
                            $attributes_all = [];
                            if ($v['attributes']) {
                                $attributes_all = array(
                                    'attributes' => $v['attributes'],
                                    'attributes_column' => $v['columnId'],
                                );
                            }
                            $product_price_arr = $this->get_product_price_str(
                                (int)$products_id,
                                $v['price'],
                                $attributes_all,
                                $v['tax_class_id']
                            );
                        }
                    }

                    if (isset($this->contents[$products_id]['attributes'])) {
                        $insertData1 = [
                            'inquiry_id' => $inquiry_id,
                            'all_product_price_dollar' => $product_price_arr['products_price_original'],
                            'final_product_price_dollar' => $product_price_arr['products_price_finial'],
                            'all_product_price' => $product_price_arr['products_price_original_current'],
                            'final_product_price' => $product_price_arr['products_price_finial_current'],
                            'updated_person' => $_SESSION['customer_id'],
                            'product_price' => $product_price,
                            'price_code' => $_SESSION['currency'],
                            'products_id' => zen_db_input((int)$products_id),
                            'attribute_product_id' => zen_db_input($products_id),
                            'product_num' => $qty,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'is_customized' => $is_customized
                        ];

                        $inquiry_products_id = $service1->insertInquiryProduct($insertData1);

                        reset($this->contents[$products_id]['attributes']);
                        while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                            $value = (int)$value;
                            $attr_value = $this->contents[$products_id]['attributes_values'][$option];
                            if ($attr_value) {
                                $attr_value = zen_db_input($attr_value);
                            }
                            if ($option == 'length') {
                                $insertData2 = [
                                    'products_id' => zen_db_input($products_id),
                                    'length_name' => $option,
                                    'product_length_id' => $value,
                                    'inquiry_products_id' => $inquiry_products_id,
                                ];
                                $service1->insertInquiryProductLength($insertData2);
                            } else {
                                $columnID = 0;
                                if ($this->columnID[$products_id][(int)$option][(int)$value]) {
                                    $columnID = $this->columnID[$products_id][(int)$option][(int)$value];
                                }

                                $insertData3 = [
                                    'products_id' => zen_db_input((int)$products_id),
                                    'options_id' => $option,
                                    'column_id' => $columnID,
                                    'options_value_id' => $value,
                                    'options_value_text' => $attr_value,
                                    'inquiry_products_id' => $inquiry_products_id,
                                ];
                                $service1->insertInquiryProductAttributes($insertData3);
                            }
                        }
                    } else {
                        $this->add_inquiry_product_new($inquiry_id, $products_id, $qty);
                    }
                } else {
                    $product_num = $product[0]['product_num'];
                    if ($product_num) {
                        $qty = $qty + (int)$product_num;
                    }
                    $data = array("product_num" => (float)$qty, "target_price" => "");
                    $service1->updateInquiryProduct(
                        ['attribute_product_id' => zen_db_input($products_id), 'inquiry_id' => $inquiry_id],
                        $data
                    );
                }
            }
        }

        return 0;

        /*
         * 验证产品属性是否存在，know of
        $this->reset(false);
        $this->columnID = [];

        $products = $service1->findInquiryProduct(
            ['inquiry_id' => (int)$inquiry_id],
            ['id', 'attribute_product_id', 'product_num', 'target_price'],
            false
        );

        if (empty($products)) {
            return null;
        }

        foreach ($products as $key => $value) {
            $tempArr1 = ['qty' => $value['product_num'], 'target_price' => $value['target_price']];
            $this->contents[$value['attribute_product_id']] = $tempArr1;
            $attributes = $service1->findInquiryProductAttributes(
                ['inquiry_products_id' => $value['id'], 'products_id' => zen_db_input($value['attribute_product_id'])],
                ['options_id', 'options_value_id', 'options_value_text', 'column_id']
            );

            $flag = true;
            if (!empty($attributes)) {
                foreach ($attributes as $kk => $item) {
                    $optionData = $service1->productAttrService->findProductsOptions(
                        ['language_id' => $_SESSION['languages_id'], 'products_options_id' => (int)$item['options_id']],
                        ['products_options_id'],
                        false
                    );
                    if (empty($optionData)) {
                        $option_id = 0;
                    } else {
                        $option_id = $optionData['products_options_id'];
                    }

                    $value_id = $service1->productAttrService->findProductsOptionsValuesCount([
                        'language_id' => $_SESSION['languages_id'],
                        'products_options_values_id' => $item['options_value_id']
                    ]);

                    //判断该产品的该属性项以及属性值是否都存在，任何一个不存在此产品就需要删除
                    if ((!$option_id) || (!$value_id)) {
                        $flag = false;
                    }

                    $this->contents[$value['attribute_product_id']]['attributes'][$value['options_id']] =
                        $item['options_value_id'];

                    if ($item['options_value_id'] == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                        $this->contents[$value['attribute_product_id']]['attributes_values'][$value['options_id']] =
                            $item['options_value_text'];
                    }

                    $this->columnID[$value['attribute_product_id']][(int)$item['options_id']][$item['options_value_id']]
                        = $item['column_id'];
                }
            }

            if ($flag) {
                $length_list = $service1->findInquiryProductLength(
                    ['inquiry_products_id' => $value['id']],
                    ['product_length_id'],
                    false
                );
                if ($length_list) {
                    $this->contents[$value['attribute_product_id']]['attributes']['length'] =
                        $length_list['product_length_id'];
                }
            } else {
                $this->remove($value['attribute_product_id']);
            }
        }*/
    }

    /**
     * Notes:没有属性的产品
     * User: LiYi
     * Date: 2020/9/7 0007
     * Time: 15:22
     * @param $inquiry_id
     * @param $products_id
     * @param $qty
     * @param int $type
     * @param bool $attr
     * @return int
     */
    function add_inquiry_product_new($inquiry_id, $products_id, $qty, $type = 1, $attr = false)
    {
        if ($type == 1 && $attr == false) {
            $this->contents[$products_id] = ['qty' => $qty];
        }
        $time = date('Y-m-d H:i:s');
        $products_arr = $this->get_products();
        // 将用户填写的价格转换成美元
        $service1 = new InquiryRequestService();
        foreach ($products_arr as $key => $val) {
            //将此产品加入报价购物车数据库
            if ($val['id'] != $products_id) {
                continue;
            }
            $attributes_all = [];
            if ($val['attributes']) {
                $attributes_all = array(
                    'attributes' => $val['attributes'],
                    'attributes_column' => $val['columnId'],
                );
            }
            $composite_str = $this->get_fmt_products_son_str($products_id, $qty);

            if ($type == 1) {
                $product_price_arr = $this->get_product_price_str(
                    (int)$products_id,
                    $val['price'],
                    $attributes_all,
                    $val['tax_class_id'],
                    "",
                    true
                );
                $is_customized = 0;
                if (strpos($products_id, ":") !== false) {
                    $is_customized = 1;
                }
                $inquiry_arr = array(
                    'inquiry_id' => $inquiry_id,
                    'products_id' => (int)$products_id,
                    'attribute_product_id' => $products_id,
                    'product_num' => $qty,
                    'product_price' => $val['original_price'],
                    'products_tax_class_id' => $val['tax_class_id'],
                    'created_person' => 0,
                    'updated_person' => 0,
                    'is_customized' => $is_customized,
                    'created_at' => $time,
                    'updated_at' => $time,
                    'price_code' => $_SESSION['currency'],
                    'all_product_price_dollar' => $product_price_arr['products_price_original'],
                    'final_product_price_dollar' => $product_price_arr['products_price_finial'],
                    'all_product_price' => $product_price_arr['products_price_original_current'],
                    'final_product_price' => $product_price_arr['products_price_finial_current'],
                    'combination_info' => $composite_str,
                    'combination_origin_info' => $composite_str
                );

                $this->contents[$products_id]['qty'] = (float)$qty;

                return $service1->insertInquiryProduct($inquiry_arr);
            } else {
                $inquiry_arr = array(
                    'product_num' => $qty,
                    'combination_info' => $composite_str,
                    'combination_origin_info' => $composite_str
                );
                $inquiryProductId = $service1->findInquiryProduct(
                    ['products_id' => (int)$products_id, 'inquiry_id' => $inquiry_id],
                    ['id']
                );
                $this->contents[$products_id]['qty'] = (float)$qty;
                if (!empty($inquiryProductId)) {
                    $service1->updateInquiryProduct(
                        ['id' => $inquiryProductId['id']],
                        $inquiry_arr
                    );
                    return $inquiryProductId['id'];
                }
            }
        }

        return 0;
    }
}
