<?php
/*
 * 关联属性
 * 需要注意的是：循环产品时候的$product_key，是产品id。
 */
class productRelatedAttributesModel {
    public function __construct(){
    }

    /*
     * 获取 某个地方 某个产品的 关联属性
     * @para int $products_id: 产品id
     * @para string $page: 页面或者地方，list/detail/qv 产品列表页面 / 产品列表详情页面 / 产品列表列表页面的QV
     * @return array $related_attribute_id_arr: 属性id数组
     */
    public function get_attributes_by_product_id($products_id,$page,$attribute_column=''){
        if(!in_array($page,array('list','detail','qv'))){
            return array();
        }
        global $db;
        $where ='';

        //属性项条件筛选
        if($attribute_column){
            $where .=' and A.name="'.$attribute_column.'" ';
        }
        $other_related_attribute_id = "";
        if(isset($_GET['id']) && intval($_GET['id']) >0){
            $other_attribute_result = $db->Execute("select other_related_attribute_id from product_related_attributes_relation where id = '".$_GET['id']."'");
            $other_related_attribute_id = $other_attribute_result->fields['other_related_attribute_id'];
        }
        if($other_related_attribute_id){
            $sql = 'select R.id as relation_id,R.related_attribute_id,R.parent_id,R.attribute_val as eng_attribute_val,A.id,A.priority,A.name as eng_name,L.content as name 
        from product_related_attributes_relation R
        LEFT join product_related_attributes A on R.related_attribute_id = A.id
        left JOIN table_column_languages L on L.unique_id = A.name_language_id and L.language_id="' . (int)$_SESSION['languages_id'] . '"
        where R.related_attribute_id in (' . $other_related_attribute_id . ') and A.is_show_' . $page . '=1 ' . $where . '
        order by A.sort asc,A.id asc ';
        }else {
            $sql = 'select R.id as relation_id,R.related_attribute_id,R.parent_id,R.attribute_val as eng_attribute_val,A.id,A.priority,A.name as eng_name,L.content as name 
        from product_related_attributes_relation R
        LEFT join product_related_attributes A on R.related_attribute_id = A.id
        left JOIN table_column_languages L on L.unique_id = A.name_language_id and L.language_id="' . (int)$_SESSION['languages_id'] . '"
        where R.product_id ="' . $products_id . '" and A.is_show_' . $page . '=1  and R.uni_attribute_id = 0' . $where . '
        order by A.sort asc,A.id asc ';
        }
        $related_attributes_relation = $db->getAll($sql);
        if($related_attributes_relation){
            foreach ($related_attributes_relation as $key => $val){
                if($_SESSION['languages_id']==1){
                    $related_attributes_relation[$key]['name_str'] = $val['eng_name'];
                }else{
                    $related_attributes_relation[$key]['name_str'] = $val['name']?$val['name']:$val['eng_name'];
                }
            }
        }
        return $related_attributes_relation;
    }

    /*
     * 获取 某个关联属性的 子集的个数
     * @para int $related_attribute_id: 关联属性id
     * @para int $count: 子集的个数
     */
    public function get_attribute_son_attribute_counts($related_attribute_id){
        global $db;
        $sql = 'select count(id) as count
        from product_related_attributes_relation R
        where parent_id ="' .$related_attribute_id . '"';
        $count = $db->getAll($sql);
        return $count?$count[0]['count']:0;
    }

    /*
     * 获取 某个关联属性的 产品列表
     * @para int $id: 关联属性id
     * @para bool $is_parent: 是否是父级id。目的，是获取父级别的所有子集
     */
    public function get_products_by_attribute_id($id,$is_parent=false){
        global $db;

        $where = '';
        if(!$is_parent){
            $where .= ' and  R.related_attribute_id ="'.$id.'" ';
        }else{
            $where .= ' and (R.id ="'.$id.'" or R.parent_id ="'.$id.'" )';
        }

        //获取当前国家对应的发货仓库状态字段
        $warehouse_data = fs_products_warehouse_where();
        $warehouse_where = $warehouse_data['where'];

        $languages_field = '';
        $languages_table = '';
        if(!$is_parent){
            $languages_field = ',L.content as attribute_val ';
            $languages_table = ' left JOIN table_column_languages L on L.unique_id = R.attribute_val_language_id and L.language_id="' . (int)$_SESSION['languages_id'] . '" ';
        }

        $sql = 'select R.id,R.product_id,R.wavelength,R.parent_id,R.attribute_val as eng_attribute_val,R.is_graphic,R.uni_attribute_id'.$languages_field.'
            from product_related_attributes_relation R '
            .$languages_table.
            'left JOIN products P on R.product_id = P.products_id
            where 1 '.$where.' and P.products_status=1 '.$warehouse_where.'
            order by R.sort asc,R.id asc';
        $related_attributes_relation = $db->getAll($sql);
        if($related_attributes_relation){
            foreach ($related_attributes_relation as $key => $val){
                if(strtolower($val['eng_attribute_val']) == 'custom'){ //定制文字，前台控制展示什么字。因为总是变化
                    $related_attributes_relation[$key]['attribute_val_str'] = FS_COMMON_CUSTOMIZED;
                }else{
                    if(strpos( $related_attributes_relation[$key]['eng_attribute_val'],'Red')){ //复合颜色,只显示单色
                        $related_attributes_relation[$key]['attribute_val_str'] = FS_COLOR_RED;
                    }elseif(strpos( $related_attributes_relation[$key]['eng_attribute_val'],'Green')){ //复合颜色,只显示单色
                        $related_attributes_relation[$key]['attribute_val_str'] = FS_COLOR_GREEN;
                    }elseif(strpos( $related_attributes_relation[$key]['eng_attribute_val'],'Blue')) { //复合颜色,只显示单色
                        $related_attributes_relation[$key]['attribute_val_str'] = FS_COLOR_BLUR;
                    }else{
                        if($_SESSION['languages_id']==1){
                            $related_attributes_relation[$key]['attribute_val_str'] = $val['eng_attribute_val'];
                        }else{
                            $related_attributes_relation[$key]['attribute_val_str'] = $val['attribute_val']?$val['attribute_val']:$val['eng_attribute_val'];
                        }
                    }
                }
            }
        }

        return $related_attributes_relation;
    }

    /*
     * 获取 某个关联属性的 产品列表，并去除子集
     * @para int $id: 关联属性id
     * $param int $product_id  当前产品ID
     * @para bool $is_parent: 是否是父级id
     */
    public function get_products_remove_sons_by_attribute_id($related_attribute_id,$product_id=0){
        // 获取属性下的产品列表
        $current_attribute_id = 0;//记录主属性值详情页的id
        $related_attributes_relation = $this->get_products_by_attribute_id($related_attribute_id);
        $related_attributes_product_list = array();
        if ($related_attributes_relation) {
            //去除产品列表中的子集
            foreach ($related_attributes_relation as $products_key => $products_val) {
                if ($products_val['parent_id']) {
                    if($related_attributes_product_list[$products_val['parent_id']]){
                        $related_attributes_product_list[$products_val['parent_id']]['product_id_arr'][] = $products_val['product_id'];
                    }
                } else {
                    if($products_val['product_id'] == $product_id){
                        $current_attribute_id = $products_val['id'];
                    } //单向关联和主属性值一样 按照sort大小排序(不再展示在主属性值后面)
                    $related_attributes_product_list[$products_val['id']] = $products_val;
                    $related_attributes_product_list[$products_val['id']]['product_id_arr'][] = $products_val['product_id'];
                }
            }
            //去掉不是主属性的详情页的单向关联
            foreach ($related_attributes_product_list as $key=>$value){
                if($value['uni_attribute_id']) {
                    if ($value['uni_attribute_id'] != $current_attribute_id) {
                        unset($related_attributes_product_list[$key]);
                    }
                }
            }
        }
        return $related_attributes_product_list;
    }

    /*
     * 获取 产品详情（产品详情页面或者qv） 某个产品的 关联属性
     * 这个是展示属性列表的核心方法。纯粹数据接口。修改数据，请修改这里
     * @para int $products_id: 产品id
     * @para string $show_page: 展示在哪个页面。
     * @para bool $is_not_custom_str 是不是定制
     * @para array $cPath_array 产品分类数组
     * @para array $custom_length_arr 定制产品只包含长度属性数组
     * @return array $return_related_attributes_array: 属性id数组
     */
    public function get_product_detail_related_attribute($products_id,$show_page,$is_not_custom_str='',$cPath_array='',$custom_length_arr=[])
    {
        global $db;
        $return_related_attributes_array = array();

        //定制产品只有长度属性,无其它属性则展示关联组信息
        $is_custom_length_product = sizeof($custom_length_arr) && $custom_length_arr['only_length_custom'];

        if($is_custom_length_product){
            $is_can_show = true;
        }else{
            // 定制产品
            if( !$is_not_custom_str ){
                if( in_array($cPath_array[0],array(9,209)) || in_array($products_id,array(57044,57041,57040,49651,49671,82481,82482,82483))){
                    $is_can_show = true;
                }else{
                    $is_can_show = false;
                }
            }else{
                $is_can_show = true;
            }
        }


        if($is_can_show){
            // 获取关联属性
            if($is_custom_length_product){
                $related_attributes = $this->get_attributes_by_product_id($products_id, $show_page,'length');
            }else{
                $related_attributes = $this->get_attributes_by_product_id($products_id, $show_page);
            }
            if ($related_attributes) {
                if ($show_page == 'detail' || $show_page == 'qv') {
                    // 根据优先级，获取相同属性，优先级高的属性id数组（priority越小的）
                    $new_related_attributes_id_arr = array();
                    $new_related_attributes_priority_arr = array();
                    foreach ($related_attributes as $key => $val) {
                        $current_related_attributes_id = $new_related_attributes_id_arr[$val['eng_name']];
                        $current_related_attributes_priority = $new_related_attributes_priority_arr[$val['eng_name']];
                        if (!$current_related_attributes_id || ($current_related_attributes_id && $current_related_attributes_priority > $val['priority'])) {
                            $new_related_attributes_id_arr[$val['eng_name']] = $val['id'];
                            $new_related_attributes_priority_arr[$val['eng_name']] = $val['priority'];
                        }
                    }
                }
                $attribute_id = intval($_GET['attribute']);
                if($attribute_id) {
                    $res = $db->Execute("select name from product_related_attributes where id = '" . $attribute_id . "' limit 1");
                    if($res->fields['name']){
                        $attribute_name = $res->fields['name'];
                    }
                }

                //循环关联属性
                foreach ($related_attributes as $key => $val) {
                    if(!$is_custom_length_product){
                        // 定制产品 573分类 不显示length属性关联
                        if(!$is_not_custom_str && $cPath_array[0]==209 && in_array($val['eng_name'], array('length', 'Length'))  ){
                            continue;
                        }
                        // 定制产品，9分类，不显示Compatible
                        if ( !$is_not_custom_str && $cPath_array[0] == 9 && $val['eng_name']=='Compatible'){
                            continue;
                        }
                        if($attribute_id && $val['eng_name'] == trim($attribute_name)){
                            if($attribute_id != $val['related_attribute_id']){
                                continue;
                            }
                        }else{
                            if(!in_array($val['id'], $new_related_attributes_id_arr)){ //去掉优先级低的
                                continue;
                            }
                        }
                    }
                    // 获取属性下的产品列表，并去除子集
                    $related_attributes_product_list = $this->get_products_remove_sons_by_attribute_id($val['id'],$products_id);
                    if ($related_attributes_product_list) {
                        $return_related_attributes_array[$key] = $val;
                        $return_related_attributes_array[$key]['product_list'] = $related_attributes_product_list;
                    }
                }
            }
        }
        return $return_related_attributes_array;
    }

    /*
     * 和get_product_detail_related_attribute类似
     * 获取 产品列表 某个产品的 关联属性
     * 这个是展示属性列表的核心方法。纯粹数据接口。修改数据，请修改这里
     */
    public function get_product_list_related_attribute($products_id,$is_not_custom_str)
    {
        $return_related_attributes_array = array();
        $new_key = 0;

        // 获取关联属性
        $related_attributes = $this->get_attributes_by_product_id($products_id, 'list');
        if ($related_attributes) {
            //循环关联属性
            $related_attributes_i = 0; //实际提取了几个
            foreach ($related_attributes as $key => $val) {
                if($related_attributes_i==1){ //只获取一条
                    break;
                }

                //定制产品，当前产品的属性值是more，custom则不显示
                if( !$is_not_custom_str && in_array(strtolower($val['eng_attribute_val']),array('more','more+','custom','customized'))){
                    continue;
                }

                // 获取属性下的产品列表，并去除子集
                $related_attributes_product_list = $this->get_products_remove_sons_by_attribute_id($val['id'],$products_id);

                if ($related_attributes_product_list) {
                    $related_attributes_i++;

                    if ($related_attributes_product_list) {
                        $return_related_attributes_array = $val;
                        $return_related_attributes_array['product_list'] = $related_attributes_product_list;
                        $new_key++;
                    }
                }
            }
        }
        return $return_related_attributes_array;
    }

    /*
     * 处理 关联属性数组，转换成字符串，产品详情页面-直接展示
     * @para array $related_attributes_array: 关联属性数组
     * @return string $related_attributes_str: 关联属性字符串
     * @para array $cPath_array 产品分类数组
     * @para array $custom_length_arr 定制产品长度属性数组
     * @return sting $related_attributes_str:html字符串
     */
    public function handle_product_detail_related_attribute($related_attributes_array,$products_id,$show_page,$cPath_array='',$custom_length_arr=[]){
        global $db;
        $related_attributes_str = '';

        // 思科品牌的产品的条件
        $pin_name = '';
        if($cPath_array[0] == 9 && !empty($cPath_array[3])){ //一级分类只有为9的时候才会有思科品牌
            $sql = $db->Execute("select categories_name from categories_description where categories_id = ".$cPath_array[3]);
            $pin_name = $sql -> fields['categories_name'];
        }
        $condition = strtolower($pin_name) == 'cisco' || in_array($products_id,array(17938,66620,66621,72582,73840,39985,65222,61895,73656,73689,73695,39293,15534,39132,39317,39316,15534));

        //是否包含transceiver type属性
        $status_t = false;
        if($condition){
            foreach ($related_attributes_array as $k => $v){
                $status_t = in_array(strtolower($v['eng_name']),array('transceiver type')) ? true : false;
            }
        }

        //线材类只有长度属性的定制产品，关联的有其他所有属性的定制产品展示(详情页展示)
        $relatedCustomHtml = '';
        if ($show_page == 'detail' && $cPath_array && in_array($cPath_array[0], [209])) {
            $relatedCustomHtml = fs_get_all_attribute_related_custom_id($products_id);
        }

        //循环关联属性
        $attribute = array();
        $lengthError = '';
        foreach ($related_attributes_array as $key => $val) {
            if(in_array($val['related_attribute_id'],$attribute)){
                continue;
            }
            $attribute[] = $val['related_attribute_id'];

            //是否是颜色
            $is_color_attribute = (strtolower($val['eng_name']) == 'color')?1:0;
            //属性头
            $fs_colon = ':';  //冒号
            if($_SESSION['languages_code'] == 'fr'){
                $fs_colon = ' :';
            }
            if($condition && in_array(strtolower($val['eng_name']),array('transceiver type'))){
                // 如果是cisco产品，且是'transceiver type'属性的话，有提示信息。11552
                $name = $val['name_str'].$fs_colon.getNewWordHtml(ATTRIBUTE_MESSAGE);
            }elseif($condition && in_array(strtolower($val['eng_name']),array('compatible'))){
                // 如果是cisco产品，没有transceiver type属性，其他属性有提示信息
                $name = $status_t == true ? $val['name_str'].$fs_colon : $val['name_str'].$fs_colon.getNewWordHtml(ATTRIBUTE_MESSAGE);
            }else{
                $name = $val['name_str'].$fs_colon;
            }
            $name = swap_american_to_britain($name);

            if($custom_length_arr['only_length_custom'] && sizeof($custom_length_arr) && in_array($val['eng_name'],array('length','Length'))){
                $length_tips = get_length_attribute_tips($products_id);
                $related_attributes_str .= '<div class="detail_transceiver_type only_customized_length"><dl><dt>'. $name . $length_tips . '</dt>';
                $related_attributes_str .='<input type="hidden" id="length_attribute" name="length" value="">';
                $related_attributes_str .='<input type="hidden" id="length_attribute_length" name="attribute_length" value="">';
            }else{
                $bubbles_str="";
                if(in_array($products_id,array(96372,96373,96375,96376))){
                    $bubbles_str = '<div class="track_orders_wenhao m_track_orders_wenhao m-track-alert">
                                <div class="question_bg_icon question_bg_grayIcon iconfont icon"></div>
                                <div class="new_m_bg1"></div>
                                <div class="new_m_bg_wap">
                                    <div class="question_text_01 leftjt">
                                        <a class="bubble_popup_close_a m_960_close new_m_icon_Close" href="javascript:;"><i class="iconfont icon"></i></a>
                                        <div class="arrow"></div>
                                        <div class="popover-content">
                                            '.FS_COHERENT_CFP.'
                                        </div>
                                    </div>
                                </div>
                             </div>';
                }
                $related_attributes_str .= '<div class="detail_transceiver_type"><dl><dt>'. $name . $bubbles_str .'</dt>';
            }
            // 产品详情页面。一级分类：9（模块），compatible属性，关联属性超过十个，则多余的默认隐藏到More+。custom如果有，则默认显示。通过前台js来控制
            if( in_array($show_page,['detail','qv']) && $cPath_array[0]==9 && strtolower($val['eng_name']) =='compatible'){
                $is_compatible_condition = 1;
            }else{
                $is_compatible_condition = 0;
            }
            // 详情页面Transceiver Type属性 关联属性超过3个，则多余的隐藏到More+
            if( in_array($show_page,['detail']) && $cPath_array[0]==9 && strtolower($val['eng_name']) =='transceiver type'){
                $is_transceiver_condition = 1;
            }else{
                $is_transceiver_condition = 0;
            }

            //循环产品
            $i = 0;
            $min_show_num = 10;
            $min_transceiver_num = 2;
            $product_list_num = count($val['product_list']);
            $hide_str = '';
            $choose_one_str='';
            $is_graphic =0;
            //当前属性如果展示图文 则当前产品的属性都展示图文
            $attribute_pro = array();
            $attribute_product = array();
            $related_attribute_id = $val['related_attribute_id'];
            foreach ($val['product_list'] as $product_list){
                if (in_array($products_id, $product_list['product_id_arr'])) {
                    $is_graphic = $product_list['is_graphic'];
                }
                if(in_array($product_list['product_id'],$attribute_pro)){
                    $attribute_product[] = $product_list['product_id'];
                    $relation_products_id = $product_list['product_id'];
                }
                $attribute_pro[] = $product_list['product_id'];
            }
            if(isset($relation_products_id) && !empty($relation_products_id)){
                $other_related_where = '';
                if($_GET['attribute'] && $_GET['attribute'] != $related_attribute_id){
                    $other_related_where = ' AND (other_related_attribute_id ="' .$related_attribute_id . ','.(int)$_GET['attribute']. '" OR  other_related_attribute_id ="' .(int)$_GET['attribute'] . ','.(int)$related_attribute_id. '")'; //同一个关联组中有同一个产品ID的情况
                }
                $result = $db->Execute("SELECT id FROM product_related_attributes_relation WHERE related_attribute_id = '".$related_attribute_id."' AND product_id = '".$relation_products_id."' ".$other_related_where." ORDER BY sort ASC LIMIT 1");
                if($result->fields['id']){
                    $product_related_attributes_relation_id = $result->fields['id'];
                }
            }
            foreach ($val['product_list'] as $product_key => $product_val) {
                $i++;
                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $product_val['attribute_val_str'] = swap_american_to_britain($product_val['attribute_val_str']);
                }
                $images= '';
                if($is_graphic ==1){ //前台去掉限制 后台自行上传 hover不展示放大图
                    if (!in_array(strtolower($product_val['eng_attribute_val']), array('more', 'more+', 'custom')) && !$is_compatible_condition) { //模块类产品Compatible关联组默认不展示图片
                        $images = get_resources_img($product_val['product_id'],'60','60');
                    }//获取关联组中产品的信息
                }
                $height_class = $hover= '';
                if($is_graphic ==1 && !$is_compatible_condition){ //more 、custom 不展示图片 但是边框需加高
                    $height_class = ' match_products';
//                    $hover = 'onmouseenter=showRelatedProInfo($(this),'.$product_val['product_id'].','.$products_id.')';
                }
                //是否选中
                if (in_array($products_id, $product_val['product_id_arr']) && !in_array($products_id,$attribute_product)) {
                    $choosez_str = ' choosez ';
                    $href = 'javascript:;';
                    $onclick_str = '';
                    $current_choose_i = $i;
                    $current_choose_attribute_val_str = $product_val['attribute_val_str'];
                    $current_images =  $images;
                    $current_height_class = $height_class;
                    $current_hover = $hover;
                }else{
                    if(isset($product_related_attributes_relation_id) && $product_related_attributes_relation_id>0 && in_array($products_id, $product_val['product_id_arr'])){
                        //if(!isset($_GET['id'])){
                        if($val['related_attribute_id'] != (int)$_GET['attribute']) {
                            $_GET['id'] = $product_related_attributes_relation_id;
                        }
                        //}
                    }
                    if(isset($_GET['id']) && $product_val['id'] == (int)$_GET['id'] && in_array($products_id, $product_val['product_id_arr'])) {
                        $choosez_str = ' choosez ';
                        $href = 'javascript:;';
                        $onclick_str = '';
                        $current_choose_i = $i;
                        $current_choose_attribute_val_str = $product_val['attribute_val_str'];
                        $current_images =  $images;
                        $current_height_class = $height_class;
                        $current_hover = $hover;
                    }else{
                        $choosez_str = '';
                        $onclick_str = ' data-product-id="' . $product_val['product_id'] . '" onclick="ajax_get_one_product_qv_show(this,\'qv\')" ';
                        $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product_val['product_id']) . "?attribute=" . $val['related_attribute_id'] ."&id=" . $product_val['id'];

                    }

                }
                // 颜色
                if ($is_color_attribute) {
                    $attribute_val_str = '';
                    $color_bg_str = ' style="background:'.get_product_color_str($product_val['eng_attribute_val']).';" ';
                    if(strtolower($product_val['eng_attribute_val']) == 'white'){ //如果是白颜色
                        $dd_class=" pro_item_color pro_item_color_white ";
                    }else{
                        $dd_class=" pro_item_color ";
                    }
                }else{
                    $attribute_val_str = $product_val['attribute_val_str'];
                    $dd_class = " pro_item";
                    $color_bg_str = '';
                }
                //是否是定制
                $onclick='';
                $custom_input='';
                if(in_array(strtolower($product_val['eng_attribute_val']), array('custom'))){
                    $a_class_str = 'class="Difference_more"';
                    if ($cPath_array && in_array($cPath_array[2], [1135, 1140, 897, 2867, 1324, 901, 1082, 3254, 3856, 974])) {
                        $attribute_val_str =FS_NEW_OTHER_LENGTH; //所有的定制长度属性展示为other length
                    }
                    //定制产品只有长度属性且且关联组里面包含长度属性
                    if($custom_length_arr['only_length_custom'] && sizeof($custom_length_arr) && strtolower($val['eng_name'])=='length'){
                        $attribute_val_str =FS_NEW_OTHER_LENGTH;
                        $onclick .= 'onclick="change_length(\'custom\',\'\','.$products_id.',\'\')"';
                        $custom_on = 1;
                        if($custom_length_arr['unit_price'] == '0.00'){$custom_on = 0;}
                        $custom_input .='<div class="new_product_attribute">
                                                <input type="hidden" name="length_unit" value="1">
												<input class="new_product_attribute_input" placeholder="" autofocus name="custom_length" id="custom_length" type="text" maxlength="8" onblur="my_onblur('.$products_id.','.$custom_on.','.$cPath_array[2].','.$custom_length_arr["customLenStatus"].')"/>
												<div class="new_product_attribute_meter_container">
													<em class="new_product_attribute_border"></em>
													<div class="new_product_attribute_meter"><span>m</span> <i class="iconfont icon">&#xf087;</i></div>
													<div class="new_product_attribute_ul_container">
														<ul class="new_product_attribute_ul">
															<li data-unit="1">m</li>
															<li data-unit="2">ft</li>
														</ul>
													</div>
												</div>
											</div>';
                        $lengthError = '<div><span id="error_text" style="display:none;color: #c00000;"></span></div>';
//                        $custom_input .='<div class="ccc"></div><p class="product_04_22"> <span id="custom_text" >';
//                        if($cPath_array[2]==3314){
//                            $center_tip = FS_LENGTH_CUSTOM_FEET;
//                            $footer_tip = FS_LENGTH_CUSTOM_METER;
//                            $custom_input .='<input type="text" id="custom_length_feet" name="custom_length_feet" placeholder="3" maxlength ="8" class= "p_07  product_05_21" size=5 onblur="my_onblur_feet('.$products_id.','.$custom_on.','.$cPath_array[2].')">';
//                        }else{
//                            $center_tip = FS_PRODUCTS_METER_OR;
//                            $footer_tip = FS_PRODUCTS_FEET;
//                            $custom_input .='<input type="text" id="custom_length" name="custom_length" placeholder="1" maxlength ="7" class = "p_07  product_05_21" size=5  onblur="my_onblur('.$products_id.','.$custom_on.','.$cPath_array[2].','.$custom_length_arr["customLenStatus"].')">';
//                        }
//                        $custom_input .='&nbsp;&nbsp;'.$center_tip.'&nbsp;&nbsp;';
//                        if($cPath_array[2]==3314){
//                            $custom_input .='<input type="text" id="custom_length" name="custom_length" placeholder="1" maxlength ="7" class = "p_07  product_05_21" size=5  onblur="my_onblur('.$products_id.','.$custom_on.','.$cPath_array[2].','.$custom_length_arr["customLenStatus"].')">';
//                        }else{
//                            $custom_input .='<input type="text" id="custom_length_feet" name="custom_length_feet" placeholder="3.28" maxlength ="8" class= "p_07  product_05_21" size=5 onblur="my_onblur_feet('.$products_id.','.$custom_on.','.$cPath_array[2].')">';
//                        }
//                        $custom_input .='&nbsp;&nbsp;'.$footer_tip;
//                        if($custom_length_arr['keys_number'] == 4){
//                            $custom_input .='&nbsp;&nbsp;('.FS_PRODUCTS_LENGTH_10M.')';
//                        }elseif($custom_length_arr['keys_number'] == 5){
//                            $custom_input .='&nbsp;&nbsp;('.FS_PRODUCTS_LENGTH_100M.')';
//                        }
//                        //}
//                        $custom_input .='&nbsp;&nbsp;</span><span id="custom_price" style="display:none"></span><span id="error_text" style="display:none;color: #c00000;"></span></p>';
                    }
                }else{
                    $a_class_str = '';
                }
                $dd_display_str = '';
                $special_class = '';
                //是否一级分类：9（模块），compatible属性
                if( $is_compatible_condition ){
                    if($i!=$product_list_num){ //除了最后一个custom
                        $special_class = ' pro_item_special ';
                        if($i>$min_show_num){
                            $dd_display_str = 'style="display:none;" ';
                        }
                    }else{ //如果是最后一个custom的
                        if($product_list_num>$min_show_num+1){ //如果总个数大于11个。加more
                            if($current_choose_i>10){ //如果当前选中的产品id，被隐藏了
                                $related_attributes_str .= '<dd class="pro_item pro_item_special_current choosez '.$current_height_class.'"><a href="javascript:;" '.$current_hover.'>'.$current_images.$current_choose_attribute_val_str.'</a></dd>';
                            }
                            $related_attributes_str .= '<dd class="pro_item pro_item_more"><a href="javascript:;" class="Difference_more" data-more="'.FS_COMMON_MORE.'">'.FS_COMMON_MORE.' +</a></dd>';
                        }
                    }
                }
                $product_list_num_trans = count($product_val['product_id_arr']);
                $j = 0;
                if($is_transceiver_condition){
                    foreach ($product_val['product_id_arr'] as $k => $v) {
                        //获取产品的模型
                        $current_products = $db->getAll('select products_MFG_PART,products_model from products where products_id=' . $v);
                        $j++;
                        if ($products_id == $v && !in_array($products_id,$attribute_product)) {
                            $choosez_str2 = ' choosez';
                            $href = 'javascript:;';
                            $current_choose_m = $j;
//                            $current_choose_array_j[] = $j;
                            //把选中的模型存起来
                            $current_choose_trans_str_1 = $current_products;
                            $current_images_1 = $images; //当前属性图片信息
                            $current_height_class_1 = $height_class;
                            $current_hover_1 = $hover;
                        } else {
                            if(isset($product_related_attributes_relation_id) && $product_related_attributes_relation_id>0 && $products_id == $v){
                                //if(!isset($_GET['id'])){
                                    $_GET['id']  = $product_related_attributes_relation_id;
                                //}
                            }
                            if(isset($_GET['id']) && $product_val['id'] == (int)$_GET['id'] && $products_id == $v) {
                                $choosez_str2 = ' choosez';
                                $href = 'javascript:;';
                                $current_choose_m = $j;
//                            $current_choose_array_j[] = $j;
                                //把选中的模型存起来
                                $current_choose_trans_str_1 = $current_products;
                                $current_images_1 = $images; //当前属性图片信息
                                $current_height_class_1 = $height_class;
                                $current_hover_1 = $hover;
                            }else {
                                $choosez_str2 = '';
                                $onclick_str = ' data-product-id="' . $product_val['product_id'] . '" onclick="ajax_get_one_product_qv_show(this,\'qv\')" ';
                                $href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $v ). "?attribute=" . $val['related_attribute_id'] . "&id=" . $product_val['id'];
                            }
                        }
                        $special_class = ' special_' . $i;
                        $special_class_2 = ' switch_more';
                        //如果产品模型个数大于2，不显示且存入变量$hide_str
                        if ($j > $min_transceiver_num) {
                            $dd_display_str = ' style="display:none;" ';
                            $hide_str .= '<dd class="' . $dd_class . $choosez_str2 . $special_class . $special_class_2 .$height_class. '" ' . $dd_display_str . '><a href="' . $href . '" ' . $color_bg_str . ' ' . $a_class_str . ' '.$hover.'>'.$images. ($current_products[0]['products_MFG_PART'] ? $current_products[0]['products_MFG_PART'] : $current_products[0]['products_model']) . '</a></dd>';
                        }else{
                            //显示至多二个产品模型
                            if ($show_page == 'qv' && !in_array(strtolower($product_val['eng_attribute_val']), array('more', 'more+', 'custom'))) {

                                //切换qv窗口
                                $related_attributes_str .= '<dd class="' . $dd_class . $choosez_str2 . $special_class . $special_class_2 . '" ' . $dd_display_str . '><a href="javascript:;" ' . $onclick_str . ' ' . $color_bg_str . ' ' . $a_class_str . '>' . ($current_products[0]['products_MFG_PART'] ? $current_products[0]['products_MFG_PART'] : $current_products[0]['products_model']) . '</a></dd>';
                            } else {  //跳转链接
                                $related_attributes_str .= '<dd class="' . $dd_class . $choosez_str2 . $special_class .$height_class. $special_class_2 . '" ' . $dd_display_str . '><a href="' . $href . '" ' . $color_bg_str . ' ' . $a_class_str . ' '.$hover.'>' .$images. ($current_products[0]['products_MFG_PART'] ? $current_products[0]['products_MFG_PART'] : $current_products[0]['products_model']) . '</a></dd>';
                            }
                        }
                        //如果选中的产品模型在显示出来的二个产品模型以外，则始终显示在more+前面一个并选中
                        if($product_list_num_trans>$min_transceiver_num && $current_choose_m > $min_transceiver_num){
                            $choose_one_str = '<dd class="pro_item pro_item_special_current choosez '.$current_height_class_1.'"><a href="javascript:;" '.$current_hover_1.'>'.$current_images_1.($current_choose_trans_str_1[0]['products_MFG_PART']?$current_choose_trans_str_1[0]['products_MFG_PART']:$current_choose_trans_str_1[0]['products_model']).'</a></dd>';
                        }
                    }
                    //循环到结尾，输出所有的html
                    if($product_list_num == $i){
                        //输出前 如果是二个产品模型以外，加上选中的html选中
                        $related_attributes_str.=$choose_one_str;
                        //输出前 加上隐藏的二个产品模型以外的产品模型
                        $related_attributes_str.=$hide_str;
                        $related_attributes_str .= $hide_str ?  '<dd class="pro_item pro_item_trans_more '.$height_class.'"><a href="javascript:;" class="Difference_more"  data-more="'.FS_COMMON_MORE.'">'.FS_COMMON_MORE.' +</a></dd>' : '' ;
                    }
                }else{
                    if ($show_page == 'qv' && !in_array(strtolower($product_val['eng_attribute_val']), array('more', 'more+','custom'))) {
                        //切换qv窗口
                        $related_attributes_str .= '<dd class="'.$dd_class.$choosez_str.$special_class.'" '.$dd_display_str.'><a href="javascript:;" '.$onclick_str.' '.$color_bg_str.' '.$a_class_str.'>'. $attribute_val_str . '</a></dd>';
                    } else{  //跳转链接
                        if (!$custom_input) {
                            $oHtml = '<a href="'.$href.'" '.$onclick.' '.$color_bg_str.' '.$a_class_str.' '.$hover.'>'.$images. $attribute_val_str . '</a>';
                        } else {
                            $oHtml = $custom_input;
                        }
                        $related_attributes_str .= '<dd class="'.$dd_class.$choosez_str.$special_class.$height_class.'" '.$dd_display_str.'>'.$oHtml.'</dd>';
                    }
                }
            }
            $related_attributes_str .= $relatedCustomHtml.'</dl>'.$lengthError.'<div class="ccc"></div></div>';
        }
        //dd($related_attributes_str);
        return $related_attributes_str;
    }

    /*
     * 和handle_product_detail_related_attribute类似
     * 处理 关联属性数组，转换成字符串，产品列表-直接展示
     * $list_type 展示的image还是list形式
     * $is_m_list 列表页
     */
    public function handle_product_list_related_attribute($related_attributes_array,$products_id,$list_type,$cPath_array='',$is_m_list=false)
    {
        $related_attributes_str = '';
        $related_attributes_product_list = $related_attributes_array['product_list'];

        //是否是模块的属性关联。+n是哪种操作，
        // $is_modules_product +n是跳转；其他是打开qv
        $is_mobile = isMobile();
        $common_is_mobile = (!$is_mobile || isset($_COOKIE['c_site']))?0:1;
        if(!$common_is_mobile){
            $is_modules_product = $cPath_array[0]==9?1:0;
        }else{ //手机端，所有的都是跳转
            $is_modules_product = 1;
        }

        //是否是颜色
        $is_color_attribute = in_array($related_attributes_array['eng_name'], array('color', 'Color'))?1:0;

        $i = 0; //这里不用$product_key，是因为$product_key，是产品id
        if ($is_m_list && $common_is_mobile) {
            $color_max_show_num = 3; //颜色，最多展示几个
        } else {
            $color_max_show_num = 5; //颜色，最多展示几个
        }
        $new_related_attributes_relation_count = count($related_attributes_product_list); //产品总个数
        if ($is_color_attribute) {
            $ul_class_str = '';
            if ($is_m_list && $common_is_mobile) {
                $ul_class_str = 'new_proList_ListSizes_list_text';
            }
        }else{
            $ul_class_str = 'new_proList_ListSizes_list_text'; //主要是为了前端，通过js控制显示一行
        }
        if($is_m_list && $common_is_mobile){
            $related_attributes_str .= '<div class="m-product-list-label"><div class="'.$ul_class_str.'">';
        }else{
            $related_attributes_str .= '<div class="new_proList_ListSizes"><ul class="new_proList_ListSizes_list '.$ul_class_str.'">';
        }
        foreach ($related_attributes_product_list as $product_key => $product_val) {
            $i++;
            if (in_array($products_id, $product_val['product_id_arr'])) {
                $choosez_str = ' choosez ';
                $active_str = 'active';
            }else{
                $choosez_str = '';
                $active_str = '';
            }
            if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                $product_val['attribute_val_str'] = swap_american_to_britain($product_val['attribute_val_str']);
            }
            if($is_m_list && $common_is_mobile){
                $click_str = 'onclick="m_ajax_get_one_product_show(this)"  data-product-id="'.$product_val['product_id'].'" data-show-type="'. $list_type.'"';
            }else{
                $click_str = 'onclick="ajax_get_one_product_show(this)"  data-product-id="'.$product_val['product_id'].'" data-show-type="'. $list_type.'"';
            }
            if ($is_color_attribute) { //颜色
                if ($i > $color_max_show_num) { //大于最大展示个数,展示+n
                    if($is_modules_product){ //模块产品，跳转到隐藏产品id
                        $click_str = '';
                        $a_href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$product_val['product_id'], 'NONSSL');
                    }else{  //其他，打开第一个隐藏产品id的qv
                        $a_href = 'javascript:;';
                        $click_str = 'data-product-id="'.$product_val['product_id'].'" onclick="ajax_get_one_product_qv_show(this)"';
                    }
                    if($is_m_list && $common_is_mobile){
                        $related_attributes_str .= '<span class="color_more" '.$click_str.'><a href="'.$a_href.'">+' . ($new_related_attributes_relation_count - $color_max_show_num). '</a></span>';
                    }else{
                        $related_attributes_str .= '<li class="new_proList_ListSizes_listLi new_proList_ListSizes_listLi_more" '.$click_str.'><a href="'.$a_href.'">+' . ($new_related_attributes_relation_count - $color_max_show_num). '</a></li>';
                    }
                    break;
                }

                if(strtolower($product_val['eng_attribute_val']) == 'white') { //如果是白颜色
                    $white_class_str = ' new_proBgColor_white ';
                }else{
                    $white_class_str = '';
                }

                if($is_m_list && $common_is_mobile){
                    $related_attributes_str .= '<span class="m-product-list-span  '.$active_str.'" ' . $click_str . '><a class="new_proBgColor '.$white_class_str.'" href="javascript:;" style="background:'.get_product_color_str($product_val['eng_attribute_val']).';" title="'.$product_val['attribute_val_str'].'"></a></span>';
                }else{
                    $related_attributes_str .= '<li class="new_proList_ListSizes_listLi1 '.$choosez_str.'" ' . $click_str . '><a class="new_proBgColor '.$white_class_str.'" href="javascript:;" style="background:'.get_product_color_str($product_val['eng_attribute_val']).';" title="'.$product_val['attribute_val_str'].'"></a></li>';
                }
            } else { //除了颜色，其他的，默认隐藏，通过js控制显示一行
                if (in_array(strtolower($product_val['eng_attribute_val']), array('more', 'more+'))) { //如果是more是跳转
                    if($is_m_list && $common_is_mobile){
                        $related_attributes_str .= '<span class="'.$active_str.'" style="display:none;"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product_val['product_id'], 'NONSSL') . '" data-is-modules="1">' . $product_val['attribute_val_str'] . '</a></span>';
                    }else{
                        $related_attributes_str .= '<li class="new_proList_ListSizes_listLi ' . $choosez_str . '" style="display:none;" ><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $product_val['product_id'], 'NONSSL') . '" data-is-modules="1">' . $product_val['attribute_val_str'] . '</a></li>';
                    }
                } else {
                    if($is_m_list && $common_is_mobile){
                        $related_attributes_str .= '<span class="'.$active_str.'" '.$click_str .' style="display:none;"><a href="javascript:;" data-href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$product_val['product_id'], 'NONSSL').'" data-is-modules="'.$is_modules_product.'" title="'.$product_val['attribute_val_str'].'">' . $product_val['attribute_val_str'] . '</a></span>';
                    }else{
                        $related_attributes_str .= '<li class="new_proList_ListSizes_listLi '.$choosez_str.'" '.$click_str .' style="display:none;"><a href="javascript:;" data-href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$product_val['product_id'], 'NONSSL').'" data-is-modules="'.$is_modules_product.'" title="'.$product_val['attribute_val_str'].'">' . $product_val['attribute_val_str'] . '</a></li>';
                    }
                }
            }
        }

        if($is_m_list && $common_is_mobile){
            $related_attributes_str .= '</div></div>';
        }else{
            $related_attributes_str .= '</ul></div>';
        }


        return $related_attributes_str;
    }

}