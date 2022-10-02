<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']) {

    $action = $_GET['ajax_request_action'];

    if (!zen_not_null($action)) {
        echo "err";
    } else {
        switch ($_GET['ajax_request_action']) {
            case 'showproductsattr':
                $column_id = $_POST['column_id'];
                $level = $_POST['level'];
                $root_column = $_POST['root_column'];
                $attr_id = $_POST['attr_id'];
                $attr_value_id = $_POST['attr_value_id'];
                //$current_category_id = $_POST['current_category_id'];
                $is_default = $_POST['is_default'];
                $allAttr = $_POST['allAttr'];
                $attrArr = explode(',', $allAttr);
                $optioVal = array();
                $installFlag = true;    //70410等产品选择16CH，18CH属性值时不展示installation属性
                if (sizeof($attrArr)) {
                    foreach ($attrArr as $v) {
                        $vArr = explode(':', $v);
                        $option = $vArr[0];
                        if (strpos($vArr[1], '_')) {
                            $columnArr = explode('_', $vArr[1]);
                            if ($option == 78) {
                                $optioVal[$option][] = $columnArr[0];
                            } else {
                                $optioVal[$option] = $columnArr[0];
                            }
                            if ($option == 38 && !in_array($columnArr[0], array(6460, 6456, 6474, 6470, 6472))) {
                                $installFlag = false;
                            }
                        }
                    }
                }
                $optionArr = array_keys($optioVal);
                //echo json_encode($optioVal);exit;
                $column_array = zen_get_all_sub_column($column_id);
                array_unshift($column_array, $column_id);
                $column_num = count($column_array);
                $now_column = $column_id;
                if ($column_id > 0) {
                    $id = $level;
                    $column_arr = $boxColumn = array();
                    for ($ii = 0; $ii < $column_num; $ii++) {
                        $column_arr[] = $now_column;
                        $count = $db->getAll("select distinct cc.attr_id from attribute_custom_column cc left join products_options ca on (cc.attr_id=ca.products_options_id) where parent_id=" . $now_column . " and cc.language_id=1 and ca.language_id=" . $_SESSION['languages_id'] . "");
                        $id .= $now_column . '_';
                        $newColumn = true;
                        for ($i = 0, $total = count($count); $i < $total; $i++) {
                            $ts = '';
                            $sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=" . $now_column . " and language_id=1 and attr_id=" . $count[$i]['attr_id'] . "  order by sort");

                            $parent_attr_id = fs_get_data_from_db_fields('attr_id', 'attribute_custom_column', 'column_id=' . $now_column, 'limit 1');
                            $parent_attribute_type = fs_get_data_from_db_fields('products_options_type', 'products_options', 'products_options_id=' . $parent_attr_id . ' and language_id=' . $_SESSION['languages_id'], '');

                            if ($sub_one && $sub_one[0]['attr_value_id']) {
                                $attribute_id = $sub_one[0]['attr_id'];
                                $option_remark = '';
                                $option_data = fs_get_data_from_db_fields_array(
                                    ['products_options_name','products_options_type','products_options_word'],
                                    'products_options',
                                    'products_options_id=' . $attribute_id . ' and language_id=' . $_SESSION['languages_id'],
                                    'limit 1');
                                $attribute_name = $option_data[0][0];
                                $attribute_type = $option_data[0][1];
                                $option_remark = $option_data[0][2];
                                if ($option_remark) {
                                    $option_remark = getNewWordHtml($option_remark);
                                }
                                if ($attribute_name) {
                                    if ($attribute_type == 0 || $attribute_type == 2) {     //select  radio也展示为下拉框
                                        if ($parent_attr_id == 78 && $parent_attribute_type == 3) {
                                            if (in_array($now_column, $boxColumn)) {
                                                $key = array_search($now_column, $boxColumn);
                                                if ($key !== false) {
                                                    unset($boxColumn[$key]);
                                                }
                                            }
                                        }
                                        if ($parent_attr_id == 78 && $parent_attribute_type == 3) {
                                            $flag = 0;
                                        } else {
                                            $flag = 1;
                                        }
                                        $html_custom = '';
                                        $html .= '<li class="detail_proSelct_li" id="' . $id . '"><div class="product_03_09 product_03_12 custom_attribute" >';
                                        $html .= '<span class="product_03_02 product_03_15"><label class="attribsSelect" for="attrib-' . $attribute_id . '"><span>' . $attribute_name . '</span>:' . $option_remark . '</label></span>';
                                        $html .= '<span class="product_03_08 detail_proSelct_checked">';

                                        $html .= '<select class="login_country" onchange="change_attribute(this,$(this).find(\'option:selected\').attr(\'id\'),' . $attribute_id . ',this.value,$(this).find(\'option:selected\').attr(\'class\'),' . $column_id . ',' . $flag . ')" name="ids[' . $attribute_id . ']" id="attrib-' . $attribute_id . '" rel="AttrSelect">';
                                        //$html .= '<option value="0">' . PLEASE_SELECT . '</option>';
                                        foreach ($sub_one as $k => $h) {
                                            $showFlag = true;
                                            //1125分类下的Cable Type属性项下面的Ribbon、LSZH Ribbon、Riser Ribbon属性值不展示
                                            //if ($current_category_id == 1125 && $attribute_id == 147 && in_array($h['attr_value_id'], [2529, 2528, 5902])) {
                                            //    $showFlag = false;
                                            //}
                                            if ($showFlag) {
                                                $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                $select = '';
                                                if($is_default==1){ //切换到默认版块,默认展示第一个属性值
                                                    if($k==0){
                                                        $select = 'selected="selected"';
                                                    }
                                                }else{
                                                    if (in_array($attribute_id, $optionArr) && $optioVal[$attribute_id] == $h['attr_value_id'] || $k==0) {
                                                        $son_data = fs_get_data_from_db_fields('column_id', 'attribute_custom_column', 'parent_id=' . $h['column_id'], 'limit 1');
                                                        if ($son_data) {
                                                            $select = 'selected="selected"';
                                                        }
                                                        $now_column = $h['column_id'];
                                                        $newColumn = false;
                                                    }
                                                }

                                                if ($attribute_value_name) {
                                                    $html .= '<option value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" ' . $select . ' id="' . $h['column_id'] . '" class="' . $id . '">' . $attribute_value_name . '</option>';
                                                }
                                                //定制输入框
                                                if ($h['attr_value_id'] == 4262) {
                                                    $related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $attribute_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                    if ($related_id) {
                                                        $custom_style = '';
                                                        if ($select == '') {
                                                            $custom_style = 'style="display:none"';
                                                        }
                                                        $html_custom .= '<div class="custom_wavelength" ' . $custom_style . '><input id="attrib-' . $related_id . '-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
                                                        $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                        $word_error = '';
                                                        if ($option_word) {
                                                            $html_custom .= getNewWordHtml($option_word);
                                                            $word_error .= '<div style="color: #c00000; display: none;" class="word_error">'.$option_word.'</div>';
                                                        }
                                                        $html_custom .= $word_error.'</div>';
                                                    }
                                                }
                                            }
                                        }
                                        $html .= '</select>';
                                        $html .= $html_custom . '<div class="product_tishi_' . $attribute_id . '"></div></span>';
                                        $html .= '<div class="ccc"></div>';
                                        $html .= '</div></li>';
                                        //如果是多选，且选择了多个属性，要把每个属性对应的下一层级的属性都展示都来
                                        //echo json_encode($boxColumn);exit;
                                        if (sizeof($boxColumn)) {
                                            foreach ($boxColumn as $box) {
                                                $text_custom = '';
                                                $box_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=" . $box . " and language_id=1 order by sort");
                                                if ($box_one && $box_one[0]['attr_value_id'] && $box_one[0]['attr_id']) {
                                                    $attr_name = fs_get_data_from_db_fields('products_options_name', 'products_options', 'products_options_id=' . $box_one[0]['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], '');
                                                    $id_arr = explode('_', $id);
                                                    $id_num = count($id_arr);
                                                    unset($id_arr[$id_num - 1]);
                                                    unset($id_arr[$id_num - 2]);
                                                    $now_id = implode('_', $id_arr) . '_' . $box . '_';
                                                    $html .= '<li class="detail_proSelct_li" id="' . $now_id . '"><div class="product_03_09 product_03_12 custom_attribute">';
                                                    $html .= '<span class="product_03_02 product_03_15">' . $attr_name . '</span>';
                                                    $html .= '<span class="product_03_08 detail_proSelct_checked">';
                                                    $html .= '<select class="login_country" onchange="change_attribute(this,$(this).find(\'option:selected\').attr(\'id\'),' . $attribute_id . ',this.value,$(this).find(\'option:selected\').attr(\'class\'),' . $column_id . ',0)" name="ids[' . $attribute_id . ']" id="attrib-' . $attribute_id . '" rel="AttrSelect">';
                                                    //$html .= '<option value="0">' . PLEASE_SELECT . '</option>';
                                                    foreach ($box_one as $kk => $one) {
                                                        $box_check = '';
                                                        if($is_default==1){ //切换到默认版块,默认展示第一个属性值
                                                            if($k==0){
                                                                $box_check = 'selected="selected"';
                                                            }
                                                        }else{
                                                            if (in_array($one['attr_id'], $optionArr) && $optioVal[$one['attr_id']] == $one['attr_value_id']) {
                                                                $box_check = 'selected="selected"';
                                                            }
                                                        }

                                                        $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $one['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                        if ($attribute_value_name) {
                                                            $html .= '<option value="' . $one['attr_value_id'] . '_' . $one['column_id'] . '" ' . $box_check . ' id="' . $one['column_id'] . '" class="' . $id . '">' . $attribute_value_name . '</option>';
                                                        }
                                                        //定制输入框
                                                        if ($one['attr_value_id'] == 4262) {
                                                            $related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $one['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                            if ($related_id) {
                                                                $text_custom .= '<div class="custom_wavelength" style="display:none;"><input id="attrib-' . $related_id . '-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
                                                                $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                                $word_error = '';
                                                                if ($option_word) {
                                                                    $text_custom .= '<div class="track_orders_wenhao">
													<div class="question_bg"></div>
													<div class="question_text_01 leftjt"><div class="arrow"></div>
													  <div class="popover-content">' . $option_word . '</div>
													</div></div>';
                                                                    $word_error .= '<div style="color: #c00000; display: none;" class="word_error">'.$option_word.'</div>';
                                                                }
                                                                $text_custom .= $word_error.'</div>';
                                                            }
                                                        }
                                                    }
                                                    $html .= '</select>' . $text_custom . '<div class="product_tishi_' . $attribute_id . '"></div>';
                                                    $html .= '</span>';
                                                    $html .= '<div class="ccc"></div>';
                                                    $html .= '</div></li>';
                                                }
                                            }//end
                                        }


                                    } elseif ($attribute_type == 2) {    //radio
                                        if ($parent_attr_id == 78 && $parent_attribute_type == 3) {
                                            if (in_array($now_column, $boxColumn)) {
                                                $key = array_search($now_column, $boxColumn);
                                                if ($key !== false) {
                                                    unset($boxColumn[$key]);
                                                }
                                            }
                                        }
                                        $html .= '<div class="product_03_09 product_03_12 custom_attribute" id="' . $id . '">';
                                        $html .= '<span class="product_03_02 product_03_15">' . $attribute_name . '</span>';
                                        $html .= '<span class="product_03_08 detail_proSelct_checked">';
                                        foreach ($sub_one as $k => $h) {
                                            $check = '';
                                            $attribsRadioButton = 'attribsRadioButton zero';
                                            if($is_default==1){ //切换到默认版块,默认展示第一个属性值
                                                if($k==0){
                                                    $check = 'checked="checked"';
                                                }
                                            }else{
                                                if (in_array($attribute_id, $optionArr) && $optioVal[$attribute_id] == $h['attr_value_id']) {
                                                    $check = 'checked="checked"';
                                                    $attribsRadioButton = 'attribsRadioButton zero active';
                                                    $now_column = $h['column_id'];
                                                    $newColumn = false;
                                                }
                                            }

                                            if ($parent_attr_id == 78 && $parent_attribute_type == 3) {
                                                $onclick = 'onclick="change_attribute(this,' . $h['column_id'] . ',' . $attribute_id . ',' . $h['attr_value_id'] . ',\'' . $id . '\',' . $column_id . ',0)"';
                                            } else {
                                                $onclick = 'onclick="change_attribute(this,' . $h['column_id'] . ',' . $attribute_id . ',' . $h['attr_value_id'] . ',\'' . $id . '\',' . $column_id . ',1)"';
                                            }

                                            $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                            $tishi = '';
                                            $option_value_word = fs_get_data_from_db_fields('options_values_word', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                            if ($option_value_word) {
                                                $tishi .= ' <div class="question_text" style="margin-top: 0;">
											<div class="question_bg"></div>
											<div class="question_text_01 leftjt">
												<div class="arrow"></div>
												<div class="popover-content">
												   ' . $option_value_word . '
												</div>
											</div>
										</div>';
                                            }

                                            if ($attribute_value_name) {
                                                $html .= '<label class="' . $attribsRadioButton . '" for="attrib-' . $attribute_id . '-' . $h['attr_value_id'] . '"><input name="ids[' . $attribute_id . ']" value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" ' . $check . ' id="attrib-' . $attribute_id . '-' . $h['attr_value_id'] . '" type="radio" id="' . $h['column_id'] . '" class="' . $id . '"  ' . $onclick . '>' . $attribute_value_name . $tishi . '</label>';
                                            }
                                            //定制输入框
                                            if ($h['attr_value_id'] == 4262) {
                                                $related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $attribute_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                if ($related_id) {
                                                    $custom_style = '';
                                                    if ($check == '') {
                                                        $custom_style = 'style="display:none"';
                                                    }
                                                    $html .= '<div class="custom_wavelength" ' . $custom_style . '><input id="attrib-' . $related_id . '-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
                                                    $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                    if ($option_word) {
                                                        $html .= '<div class="track_orders_wenhao">
												<div class="question_bg"></div>
												<div class="question_text_01 leftjt"><div class="arrow"></div>
												  <div class="popover-content">' . $option_word . '</div>
												</div></div>';
                                                    }
                                                    $html .= '</div>';
                                                }
                                            }
                                        }

                                        $html .= '</span>';
                                        $html .= '<div class="ccc"></div>';
                                        $html .= '</div>';
                                        //如果是多选，且选择了多个属性，要把每个属性对应的下一层级的属性都展示都来
                                        //echo json_encode($boxColumn);exit;
                                        if (sizeof($boxColumn)) {
                                            foreach ($boxColumn as $box) {
                                                $box_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=" . $box . " and language_id=1 order by sort");
                                                if ($box_one && $box_one[0]['attr_value_id'] && $box_one[0]['attr_id']) {
                                                    $attr_name = fs_get_data_from_db_fields('products_options_name', 'products_options', 'products_options_id=' . $box_one[0]['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], '');
                                                    $attr_remark = '';
                                                    $attr_remark = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $box_one[0]['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                    if ($attr_remark) {
                                                        $attr_remark = '<div class="track_orders_wenhao">
												<div class="question_bg"></div>
												<div class="question_text_01 leftjt"><div class="arrow"></div>
												  <div class="popover-content">' . $attr_remark . '</div>
												</div></div>';
                                                    }
                                                    $id_arr = explode('_', $id);
                                                    $id_num = count($id_arr);
                                                    unset($id_arr[$id_num - 1]);
                                                    unset($id_arr[$id_num - 2]);
                                                    $now_id = implode('_', $id_arr) . '_' . $box . '_';
                                                    $html .= '<div class="product_03_09 product_03_12 custom_attribute" id="' . $now_id . '">';
                                                    $html .= '<span class="product_03_02 product_03_15">' . $attr_name . '</span>';
                                                    $html .= '<span class="product_03_08 detail_proSelct_checked">';
                                                    foreach ($box_one as $kk => $one) {
                                                        $box_check = '';
                                                        $attribsRadioButton = 'attribsRadioButton zero';
                                                        if (in_array($one['attr_id'], $optionArr) && $optioVal[$one['attr_id']] == $one['attr_value_id']) {
                                                            $box_check = 'checked="checked"';
                                                            $attribsRadioButton = 'attribsRadioButton zero active';
                                                        }
                                                        $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $one['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                        $tishi = '';
                                                        $option_value_word = fs_get_data_from_db_fields('options_values_word', 'products_options_values', 'products_options_values_id=' . $one['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                        if ($option_value_word) {
                                                            $tishi .= ' <div class="question_text" style="margin-top: 0;">
												<div class="question_bg"></div>
												<div class="question_text_01 leftjt">
													<div class="arrow"></div>
													<div class="popover-content">
													   ' . $option_value_word . '
													</div>
												</div>
											</div>';
                                                        }
                                                        $onclick = 'onclick="change_attribute(this,' . $h['column_id'] . ',' . $attribute_id . ',' . $h['attr_value_id'] . ',\'' . $id . '\',' . $column_id . ',0)"';
                                                        if ($attribute_value_name) {
                                                            $html .= '<label class="' . $attribsRadioButton . '" for="attrib-' . $one['attr_id'] . '-' . $one['attr_value_id'] . '"><input name="ids[' . $one['attr_id'] . ']"  value="' . $one['attr_value_id'] . '_' . $one['column_id'] . '" ' . $box_check . ' id="attrib-' . $one['attr_id'] . '-' . $one['attr_value_id'] . '" type="radio" id="' . $one['column_id'] . '" class="' . $id . '"  ' . $onclick . '>' . $attribute_value_name . $tishi . '</label>';
                                                        }
                                                        //定制输入框
                                                        if ($one['attr_value_id'] == 4262) {
                                                            $related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $one['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                            if ($related_id) {
                                                                $html .= '<div class="custom_wavelength" style="display:none;"><input id="attrib-' . $related_id . '-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
                                                                $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                                if ($option_word) {
                                                                    $html .= '<div class="track_orders_wenhao">
													<div class="question_bg"></div>
													<div class="question_text_01 leftjt"><div class="arrow"></div>
													  <div class="popover-content">' . $option_word . '</div>
													</div></div>';
                                                                }
                                                                $html .= '</div>';
                                                            }
                                                        }
                                                    }
                                                    $html .= '</span>';
                                                    $html .= '<div class="ccc"></div>';
                                                    $html .= '</div>';
                                                }
                                            }//end
                                        }

                                    } elseif ($attribute_type == 3) {    //checkbox
                                        $html .= '<li class="detail_proSelct_li" id="' . $id . '"><div class="product_03_09 product_03_12 custom_attribute">';
                                        $html .= '<span class="product_03_02 product_03_15"><span style="color: rgb(51,51,51)">' . $attribute_name . ':</span></span>';
                                        $html .= '<span class="product_03_08">';
                                        foreach ($sub_one as $k => $h) {
                                            $attribsCheckboxButton = "attribsCheckboxButton";
                                            $check = '';
                                            if($is_default==1){ //切换到默认版块,默认展示第一个属性值
                                                $attribsCheckboxButton = "attribsCheckboxButton checkbox_disabled";
                                                if($k==0){
                                                    $check = 'checked=checked';
                                                    $attribsCheckboxButton = 'attribsCheckboxButton default_attribute_checkbox active';
                                                }
                                            }else{
                                                if (in_array($attribute_id, $optionArr) && in_array($h['attr_value_id'], $optioVal[$attribute_id])) {
                                                    //if($h['attr_value_id']!=5145){
                                                    $check = 'checked="checked"';
                                                    $attribsCheckboxButton = 'attribsCheckboxButton active';
                                                    //}
                                                    $now_column = $h['column_id'];
                                                    $boxColumn[] = $h['column_id'];
                                                    $newColumn = false;
                                                }
                                            }

                                            $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');

                                            if ($attribute_value_name) {
                                                $html .= '<label class="' . $attribsCheckboxButton . '"><input '.$check.' name="ids[' . $attribute_id . '][' . $h['attr_value_id'] . ']" value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" tag="' . $attribute_id . '-' . $h['attr_value_id'] . '" id="attrib-' . $attribute_id . '-' . $h['attr_value_id'] . '" type="checkbox" id="' . $h['column_id'] . '" class="' . $id . '" onclick="change_attribute(this,' . $h['column_id'] . ',' . $attribute_id . ',' . $h['attr_value_id'] . ',\'' . $id . '\',' . $column_id . ',1)">' . $attribute_value_name . '</label>';
                                            }
                                        }
                                        $html .= '</span>';
                                        $html .= '<div class="ccc"></div>';
                                        $html .= '</div></li>';
                                    }
                                }
                            }
                        }
                        if ($newColumn && $now_column) {
                            $now_column = fs_get_data_from_db_fields('column_id', 'attribute_custom_column', 'parent_id=' . $now_column, 'order by sort limit 1');
                        }
                    }
                }
                $data = array('html' => $html, 'column' => $column_arr, 'boxColumn' => $boxColumn, 'installFlag' => $installFlag);
                //echo  $html;

                echo json_encode($data);

                exit;
                break;

            case 'new_attribute_checkbox':
                global $db;
                $column_id = trim($_POST['column_id']);
                $option_id = trim($_POST['option_id']);
                $pid = $_POST['pid'];
                $html = '';
                if ($column_id && $option_id) {
                    $sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=" . $column_id . " and language_id=1 and attr_id=" . $option_id . "  order by sort");
                    if ($sub_one) {
                        $html .= '<ul class="new_se_ul">';
                        foreach ($sub_one as $k => $h) {
                            if ($h['attr_value_id'] != 5145) {
                                $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                $html .= '   <li><label class="new_sele_a attribsCheckboxButton">
                                                    <input onclick="change_attribute(this,' . $h['column_id'] . ',' . $h['attr_id'] . ',' . $h['attr_value_id'] . ',' . $column_id . ',1,' . $pid . ',\'is_checkbox\')"  name="ids[' . $h['attr_id'] . '][' . $h['attr_value_id'] . ']" value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" tag="' . $h['attr_id'] . '-' . $h['attr_value_id'] . '" id="attrib-' . $h['attr_id'] . '-' . $h['attr_value_id'] . '" type="checkbox" style="display: none">' . $attribute_value_name . '</label>
                                                    </li>';
                            }
                        }
                        $html .= '</ul>';
                    }
                }
                $data = array('html' => $html);
                exit(json_encode($data));
                break;

            case 'new_showproductsattr':
                global $db;
                $pid = $_POST['pid'];
                $column_id = $_POST['column_id'];
                $root_column = $_POST['root_column'];
                $attr_id = $_POST['attr_id'];
                $attr_value_id = $_POST['attr_value_id'];
                //$current_category_id = $_POST['current_category_id'];
                $allAttr = $_POST['allAttr'];
                $step = $_POST['step'];
                $is_true = $_POST['is_true'];
                $has_length_step = $_POST['has_length_step'];//是否有新版长度属性下拉框
                $column_array = array();
                $new_column_array = array();
                $all_column = [];
                $column_array = zen_get_all_sub_column_and_options_id($column_id,$all_column);
                $id = "";
                $new_column_array = zen_get_step_attr($column_array, $pid);
                $next_html = '';
                foreach ($new_column_array as $key => $column) {
                    if ($column) {
                        if ($key == 'is_checkbox') {
                            foreach ($column as $oid => $cid) {
                                $unique_id = fs_get_data_from_db_fields('unique_id','products_custom_step','attr_id="'.$oid.'" and products_id='.(int)$pid,'limit 1');
                                if($unique_id){
                                    $step_name = fs_get_data_from_db_fields('content','table_column_languages','unique_id='.(int)$unique_id.' and language_id='.$_SESSION['languages_id'],'');
                                }else{
                                    $step_name = fs_get_data_from_db_fields('step_name','products_custom_step','attr_id="'.$oid.'" and products_id='.(int)$pid,'limit 1');
                                }
                                $option_remark = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $oid . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                if ($option_remark) {
                                    $option_remark = '<div class="track_orders_wenhao">
                                                    <div class="question_bg"></div>
                                                    <div class="question_text_01 leftjt"><div class="arrow"></div>
                                                      <div class="popover-content">' . $option_remark . '</div>
                                                    </div></div>';
                                }
                                $html .= '<div class="new_select_w new_bottom">
                                    <div class="new_select_tit">
                                        <a class="new_sele_a" onclick="change_checkbox(this,' . $cid . ',' . $oid . ',' . $pid . ')" href="javascript:;"></a>' . $step_name . $option_remark . '
                                    </div>
                                    <div class="new_select_ul2" id="new_product_checkbox">';
                                $html .= '</div>
                                        </div>';
                            }
                        } elseif ($key == $step) {
                            $count = sizeof($column);
                            $i =0;
                            foreach ($column as $oid => $cid) {
                                $html_custom = '';
                                $i++;
                                $right = '';
                                if($_POST['is_right'] ==0){
                                    if($i==1 || $i==3){
                                        $right = ' new_right';
                                    }
                                }else{
                                    if($i==2){
                                        $right = ' new_right';
                                    }
                                }
                                //$id = $cid.'_';
                                $attribute_name = fs_get_data_from_db_fields('products_options_name', 'products_options', 'products_options_id=' . $oid . ' and language_id=' . $_SESSION['languages_id'], '');
                                $option_remark = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $oid . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                if ($option_remark) {
                                    $option_remark = '<div class="track_orders_wenhao">
                                                    <div class="question_bg"></div>
                                                    <div class="question_text_01 leftjt"><div class="arrow"></div>
                                                      <div class="popover-content">' . $option_remark . '</div>
                                                    </div></div>';
                                }
                                if ($attribute_name) {
                                    $next_html .= '  
                                                    <div class="new_select_left' . $right . '" id="new_select_' . $oid . '">
                                                    <div class="new_select_tit">' . $attribute_name . ':
                                                    ' . $option_remark . '
                                                </div>';
                                    $next_html .= '	<div class="new_select_cpntent1"><select class="new_select1 login_country" name="ids[' . $oid . ']" rel="AttrSelect" id="attrib-' . $oid . '" onchange="change_attribute(this,$(this).find(\'option:selected\').attr(\'id\'),' . $oid . ',this.value,' . $cid . ',1,' . $pid . ',' . $key . ')">';
                                    $next_html .= '<option value="0">' . PLEASE_SELECT . '</option>';
                                    $sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=" . $cid . " and language_id=1 and attr_id=" . $oid . "  order by sort");
                                    foreach ($sub_one as $k => $h) {
                                        $showFlag = true;
                                        //1125分类下的Cable Type属性项下面的Ribbon、LSZH Ribbon、Riser Ribbon属性值不展示
                                        //if ($current_category_id == 1125 && $oid == 147 && in_array($h['attr_value_id'], [2529, 2528, 5902])) {
                                        //    $showFlag = false;
                                        //}
                                        if ($showFlag) {
                                            $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                            $next_html .= '<option value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" id="' . $h['column_id'] . '" class="' . $cid . '">' . $attribute_value_name . '</option>';
                                            //定制输入框
                                            if ($h['attr_value_id'] == 4262) {
                                                $related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $h['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                if ($related_id) {
                                                    $custom_style = '';
                                                    if ($select == '') {
                                                        $custom_style = 'style="display:none"';
                                                    }
                                                    $html_custom .= '<div class="custom_wavelength" ' . $custom_style . '><input id="attrib-' . $related_id . '-0" class="new_sele_input attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
                                                    $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                    if ($option_word) {
                                                        $html_custom .= '<div class="track_orders_wenhao">
                                    <div class="question_bg"></div>
                                    <div class="question_text_01 leftjt"><div class="arrow"></div>
                                      <div class="popover-content">' . $option_word . '</div>
                                    </div></div>';
                                                    }
                                                    $html_custom .= '</div>';
                                                }
                                            }
                                        }
                                    }
                                    $next_html .= '</select></div>' . $html_custom . '</div>';
                                }
                            }
                        } else {
                            $count_column = sizeof($column);
                            $class = "";
                            $inputClass = "";
                            $is_choosing = '';
                            $no_choose = ' new_select_disabled';
                            $oem_dy='';
                            if ($count_column == 1) {
                                $one_option = array_keys($column);
                                $step_name = fs_get_data_from_db_fields('products_options_name', 'products_options', 'products_options_id=' . $one_option[0] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                $class = " mb";
                                $inputClass = ' carr_helun';
                            } else {
                                $unique_id = fs_get_data_from_db_fields('unique_id', 'products_custom_step', 'products_id=' . (int)$pid . ' and step_sort=' . (int)$key, 'limit 1');
                                if ($unique_id) {
                                    $step_name = fs_get_data_from_db_fields('content', 'table_column_languages', 'unique_id=' . (int)$unique_id . ' and language_id=' . $_SESSION['languages_id'], '');
                                } else {
                                    $step_name = fs_get_data_from_db_fields('step_name', 'products_custom_step', 'products_id=' . (int)$pid . ' and step_sort=' . (int)$key, 'limit 1');
                                }
                            }
                            $i = 1;
                            $attr_arr = array();
                            if ($is_true == 1 && empty($next_html)) {
                                if ($key == ($step + 1)) {
                                    $attr_id = fs_get_data_from_db_fields('attr_id', 'products_custom_step', 'products_id=' . (int)$pid . ' and step_sort=' . $key, 'limit 1');
                                    $attr_arr = explode(',', $attr_id);
                                    $is_choosing = ' choosing';
                                    $no_choose = '';
                                    $oem_dy = 'oem_is_choose';
                                }
                            }
                            $html .= '<div class="new_custom_dylan new_select_w '.$oem_dy.$is_choosing.'" id="attribute_step_' . $key . '">
                                        <p class="new_select_p">'.FS_PRODUCT_INFO_STEP.' ' . ($has_length_step ? $key+1 : $key) . '. <span>' . $step_name . '</span></p>
                                    <div class="new_select_wap">';
                            foreach ($column as $oid => $cid) {
                                //$id = $cid.'_';
                                $html_custom = '';
                                $i++;
                                $attribute_name = fs_get_data_from_db_fields('products_options_name', 'products_options', 'products_options_id=' . $oid . ' and language_id=' . $_SESSION['languages_id'], '');
                                $option_remark = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $oid . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                if ($option_remark) {
                                    $option_remark = '<div class="track_orders_wenhao">
                                <div class="question_bg"></div>
                                <div class="question_text_01 leftjt"><div class="arrow"></div>
                                  <div class="popover-content">' . $option_remark . '</div>
                                </div></div>';
                                }
                                if ($attribute_name) {
                                    $html .= '<div class="new_select_left ' . ($i % 2 == 1 ? 'new_right' : '') . '' . $class . $inputClass . '" id="new_select_' . $oid . '">';
                                    if (sizeof($column) > 1) {
                                        $html .= '<div class="new_select_tit">' . $attribute_name . ':' . $option_remark . '</div>';
                                    }
                                    $html .= '<div class="new_select_cpntent1"><select class="new_select1 login_country'.$no_choose.'" rel="AttrSelect" name="ids[' . $oid . ']" id="attrib-' . $oid . '" onchange="change_attribute(this,$(this).find(\'option:selected\').attr(\'id\'),' . $oid . ',this.value,' . $cid . ',1,' . $pid . ',' . $key . ')">';
                                    $html .= '<option value="0">' . PLEASE_SELECT . '</option>';
                                    if (sizeof($attr_arr)) {
                                        if (in_array($oid, $attr_arr)) {
                                            $sub_one = $db->getAll("select cc.column_id,cc.column_name,cc.attr_value_id,cc.attr_id,cc.price_prefix,cc.attr_price from attribute_custom_column cc where parent_id=" . $cid . " and language_id=1 and attr_id=" . $oid . "  order by sort");
                                            foreach ($sub_one as $k => $h) {
                                                $showFlag = true;
                                                //1125分类下的Cable Type属性项下面的Ribbon、LSZH Ribbon、Riser Ribbon属性值不展示
                                                //if ($current_category_id == 1125 && $oid == 147 && in_array($h['attr_value_id'], [2529, 2528, 5902])) {
                                                //    $showFlag = false;
                                                //}
                                                if ($showFlag) {
                                                    $attribute_value_name = fs_get_data_from_db_fields('products_options_values_name', 'products_options_values', 'products_options_values_id=' . $h['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                    $html .= '<option value="' . $h['attr_value_id'] . '_' . $h['column_id'] . '" id="' . $h['column_id'] . '" class="' . $cid . '">' . $attribute_value_name . '</option>';
                                                    //定制输入框
                                                    if ($h['attr_value_id'] == 4262) {
                                                        $related_id = fs_get_data_from_db_fields('related_option_id', 'products_options', 'products_options_id=' . $h['attr_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                        if ($related_id) {
                                                            $custom_style = '';
                                                            if ($select == '') {
                                                                $custom_style = 'style="display:none"';
                                                            }
                                                            $html_custom .= '<div class="custom_wavelength" ' . $custom_style . '><input id="attrib-' . $related_id . '-0" class="new_sele_input attr_input_2" type="text" value="" size="19" name="ids[text_prefix_' . $related_id . ']" placeholder="">';
                                                            $option_word = fs_get_data_from_db_fields('products_options_word', 'products_options', 'products_options_id=' . $related_id . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                                                            if ($option_word) {
                                                                $html_custom .= '<div class="track_orders_wenhao">
                                                        <div class="question_bg"></div>
                                                        <div class="question_text_01 leftjt"><div class="arrow"></div>
                                                          <div class="popover-content">' . $option_word . '</div>
                                                        </div></div>';
                                                            }
                                                            $html_custom .= '</div>';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $html .= '</select></div>' . $html_custom . '</div>';
                                }
                            }
                            $html .= '</div>	
                        </div>';
                        }
                    }
                }
                $data = array('next_html' => $next_html, 'html' => $html);
                echo json_encode($data);
                break;

            case 'showRelatedLabel':
                $product_id = $_POST['products_id'];
                $options_name = $options_menu = array();
                $html = '';
                $currency = $_SESSION['currency'];
                $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                if ((int)$product_id) {
                    $products_price = fs_get_data_from_db_fields('products_price', TABLE_PRODUCTS, 'products_id=' . $product_id, 'limit 1');
                    $wholesale_products = fs_get_wholesale_products_array();
                    if (!in_array((int)$product_id, $wholesale_products)) {
                        $products_price = get_products_all_currency_final_price($products_price * $currency_value);
                    } else {
                        $products_price = get_products_specail_currency_final_price($products_price * $currency_value);
                    }

                    $sql = "select distinct popt.products_options_id, popt.products_options_name, popt.products_options_sort_order,popt.related_option_id,
					popt.products_options_word  from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where           patrib.products_id='" . (int)$product_id . "' and popt.products_options_type !=1  and patrib.options_id = popt.products_options_id
					and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' " . " and patrib.attributes_status = 1 and  popt.products_options_status = 1  order by patrib.products_attributes_id desc";
                    $products_options_names = $db->Execute($sql);
                    while (!$products_options_names->EOF) {
                        $value_sql = "select pov.products_options_values_id, pov.products_options_values_name,pa.*  from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$product_id . "' and pa.options_id = '" . (int)$products_options_names->fields['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id
					and pov.language_id = '" . (int)$_SESSION['languages_id'] . "' order by LPAD(pov.products_options_values_sort_order,11,'0'), pov.products_options_values_name";

                        $products_options = $db->Execute($value_sql);
                        $tmp_radio = '';
                        while (!$products_options->EOF) {
                            $value_name = $products_options->fields['products_options_values_name'];
                            $price = $products_price / $currency_value;
                            $price_text = '';
                            if ($products_options->fields['options_values_price'] > 0) {
                                if ($products_options->fields['price_prefix'] == '+') {
                                    $price += $products_options->fields['options_values_price'];
                                } else {
                                    $price -= $products_options->fields['options_values_price'];
                                }

                            }
                            $price_text = $currencies->total_format($price, true, $currency, $currency_value);

                            $value_name .= '(' . $price_text . '/Roll)';

                            $products_options_value_id = $products_options->fields['products_options_values_id'];
//						$tmp_radio .=  '<label class="attribsLabelButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' .zen_draw_radio_field('color[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, false, ' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"'). $value_name.'</label>';
                            if($_POST['type']){
                                $tmp_radio .='<label class="new_sele_a"><input type="radio" name="color['.$products_options_names->fields['products_options_id'].']" value="'.$products_options_value_id.'" style="display:none;">' . $value_name . '</label>';
                            }else{
                                $tmp_radio .= '<option value="' . $products_options_value_id . '">' . $value_name . '</option>';
                            }
//                        $tmp_radio .= "\n";

                            $products_options->MoveNext();
                        }
                        $options_name[] = $products_options_names->fields['products_options_name'];
                        $options_menu[] = $tmp_radio;
                        $products_options_names->MoveNext();
                    }
                    if (sizeof($options_name)) {
                        foreach ($options_name as $i => $name) {
                            if ($_POST['type']) {
                                $html .= $options_menu[$i];
//                                $html .= '<select class="new_select1" name="color" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '">
//                                        <option value="0">' . PLEASE_SELECT . '</option>
//                                        ' . $options_menu[$i] . '
//                                    </select>';
                            } else {
                                $html .= '<div class="product_03_09 product_03_12 custom_attribute">
                                        <span class="product_03_02 product_03_15"><label class="attribsSelect" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '"><span>' . $name . '</span>: </label></span>
                                        <span class="product_03_08 detail_proSelct_checked"><select id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '" name="color"><option value="0">' . PLEASE_SELECT . '</option>' . $options_menu[$i] . '</select></span></div>';
                            }
                        }
                    }
                    $data = array("status" => true, "html" => $html);

                } else {
                    $data = array("status" => false, "html" => $html);
                }
                echo json_encode($data);
                exit;
                break;
            //新增展示模块标签
            case 'showMoreLables':
                $products_id = (int)$_POST['products_id'];
                $code = 0;
                if($products_id) {
                    $related_label_pid = fs_get_data_from_db_fields('related_label_pid',TABLE_PRODUCTS,'products_id='.$products_id);
                }
                $related_label_html = '';
                //根据关联的定制产品 查询其标签属性
                if($related_label_pid){
                    if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
                        $options_order_by= ' order by LPAD(popt.products_options_sort_order,11,"0")';
                    } else {
                        $options_order_by= ' order by patrib.products_attributes_id desc';
                    }
                    $sql = "select popt.products_options_id, popt.products_options_name,popt.products_options_length,
                        popt.products_options_sort_order,popt.related_option_id,popt.products_options_word,popt.	products_options_type,popt.options_placeholder,patrib.options_values_id
                        from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib 
                        where patrib.products_id='" . $related_label_pid . "' 
                        and patrib.options_id = popt.products_options_id 
                        and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' " . "
                        and patrib.attributes_status = 1 and  popt.products_options_status = 1
                        group by popt.products_options_id
                       ".$options_order_by;
                    $products_options_names = $db->getAll($sql);
                    //根据products_options_id查询出products_options_value_name
                    foreach ($products_options_names as $key=>$option){
                        if($option['options_values_id'] !=0){
                            $option_id_data[] = $option['products_options_id'];
                        }
                    }
                    $value_sql = "select pov.products_options_values_id, pov.products_options_values_name,pa.options_values_id,pa.price_prefix,pa.options_values_price,pa.options_id
                                        from ". TABLE_PRODUCTS_ATTRIBUTES ." pa," .TABLE_PRODUCTS_OPTIONS_VALUES. " pov 
                                        where pa.products_id = '" .$related_label_pid . "' 
                                        and pa.options_id in(" . join(',',$option_id_data) . ")
                                        and pa.options_values_id = pov.products_options_values_id
					                    and pov.language_id = '" . (int)$_SESSION['languages_id'] . "'
					                    order by LPAD(pov.products_options_values_sort_order,11,'0') 
					                    ";
                    $products_options = $db->getAll($value_sql);
                    //拼接返回的html 结构
                    foreach ($products_options_names as $lable=>$val) {
                        //把下拉选择框的内容追加在原有的数组后面   形成新的数组
                        if ($val['options_values_id'] != 0) {
                            foreach ($products_options as $kk => $vv) {
                                if ($val['products_options_id'] == $vv['options_id']) {
                                    $products_options_names[$lable]['product_values'][$products_options[$kk]['options_values_id']]['products_options_values_name'] = $products_options[$kk]['products_options_values_name'];
                                    $products_options_names[$lable]['product_values'][$products_options[$kk]['options_values_id']]['price_prefix'] = $products_options[$kk]['price_prefix'];
                                    $products_options_names[$lable]['product_values'][$products_options[$kk]['options_values_id']]['options_values_price'] = $products_options[$kk]['options_values_price'];
                                    $products_options_names[$lable]['product_values'][$products_options[$kk]['options_values_id']]['products_options_values_id'] = $products_options[$kk]['products_options_values_id'];

                                }
                            }
                        }
                    }
                    foreach ($products_options_names as $key =>$label_option){
                        $tip = '';
                        if($label_option['products_options_type'] ==1) {
                            $label_class = 'attribsInput';
                        }elseif ($label_option['products_options_type'] ==4){
                            $label_class = 'attribsUploads';
                        }else{
                            $label_class = 'attribsSelect';
                        }
                        if($label_option['products_options_word']){
                            $tip .= getNewWordHtml($label_option['products_options_word']);
                        }
                        if($label_option['products_options_type'] ==4){
                            $related_label_html .= '
                   <li class="detail_proSelct_li more_lable">
                    <div class="product_03_09 product_03_12 fiber_optic_network">
                        <span class="product_03_02 product_03_15"><div class="attribsUploads" for="attrib-'.$label_option['products_options_id'].'-'.$label_option['options_values_id'].'"><span>'.$label_option['products_options_name'].'</span>:'.$tip.'</div>';
                        }else{
                            $related_label_html .= '
                   <li class="detail_proSelct_li more_lable">
                    <div class="product_03_09 product_03_12 fiber_optic_network">
                        <span class="product_03_02 product_03_15"><label class="'.$label_class.'" for="attrib-'.$label_option['products_options_id'].'-'.$label_option['options_values_id'].'"><span>'.$label_option['products_options_name'].'</span>:'.$tip.'</label>';
                        }
                        $related_label_html .='
            </span><span class="product_03_08 detail_proSelct_checked">';
                        //判断属性项的类型
                        switch ($label_option['products_options_type']){
                            case 1:
                                //文本框
                                $placeholder_str = '';
                                if($label_option['options_placeholder']){
                                    $placeholder_str = FS_PLACEHOLDER_EG.$label_option['options_placeholder'];
                                }
                                $related_label_html .='<div class="custom_lable_wavelength"><input type="text" class="attr_input attr_input_text" name="color[text_prefix_'.$label_option['products_options_id'].']"  value="" id="attrib-'.$label_option['products_options_id'].'-'.$label_option['options_values_id'].'" placeholder="'.$placeholder_str.'" maxlength="'.$label_option['products_options_length'].'" onfocus="return(this.placeholder=\'\')" onblur="return(this.placeholder=\''.$placeholder_str.'\')"></div>';
                                break;
                            //文件
                            case 4:
                                $related_label_html  .= '<div class="pro-detail-fileUpload-box">
                                                      <div class="custom_lable_wavelength">
                                    <span class="iconfont pro-detail-fileUpload-ic"></span>
                                    <input type="text" class="attr_input pro-detail-fileUpload-input"  readonly placeholder="'.$label_option['options_placeholder'].'"><span class="delete-image-icon" onclick="delete_file();" style="display: none;"><em class="icon iconfont icon_on">&#xf092;</em></span>
                                    <input class="pro-detail-fileUpload-input01" type="file" title="" name="color['.$label_option['products_options_id'].']" id="attrib-'.$label_option['products_options_id'].'-'.$label_option['options_values_id'].'" onchange="previewImage($(this));"><br>
                                        </div>
                                    </div>
                                    <div id="type_msg" class="error_prompt" style="display: none;"></div>';
                                break;
                            //下拉选择框 查询下拉选择框的内容
                            default:
                                if(isset($label_option['product_values'])){
                                    $related_label_html .= '<select id="attrib-'.$label_option['products_options_id'].'" name="color['.$label_option['products_options_id'].']" class="related_color_label">';
                                    foreach ($label_option['product_values'] as $ii => $option){
                                        if($option['products_options_values_id']){
                                            $value_name =$option['products_options_values_name'];
                                        }
                                        //存在products_options_values_name  计算价格 用价格和名称拼接下拉选择框内容
                                        if($value_name){
                                            $currency = $_SESSION['currency'];
                                            $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                                            $price = getCustomPrice($related_label_pid,$option['options_values_price'],$option['price_prefix']);
                                            $price_text = $currencies->total_format($price);
                                            $value_name.= ' (' . $price_text . '/Roll)';
                                            $products_options_value_id = $option['products_options_values_id'];
                                            $related_label_html.= '<option value="' . $products_options_value_id . '">' . $value_name . '</option>';
                                        }
                                    }
                                    $related_label_html .='</select>';
                                    foreach ($label_option['product_values'] as $ii => $option) {
                                        $price = getCustomPrice($related_label_pid,$option['options_values_price'],$option['price_prefix']);
                                        $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                                        $price = $price * $currency_value;
                                        $related_label_html .='<input type="hidden" class="related_custom_price_'.$option['products_options_values_id'].'" value="'.$price.'"> ';
                                    }

                                }

                                break;
                        }
                        $related_label_html .='</span>
                    <div class="ccc"></div>
                    </div>
                    </li>';
                    }
                    if($related_label_html){
                        $related_label_html .= '<input type="hidden" name="lable_product_quality" value="1" id="lable_product_quality">';
                        $code = 1;
                    }
                }
                echo json_encode(array('html'=>$related_label_html,'code'=>$code));
                break;


            /**
             * 详情页wdm库存展示版块，为了不影响详情页速度，该版块库存数据通过异步加载
             */
            case 'getWdmRelatedStock':
                $wdmIds = json_decode($_POST['wdmIds']);
                $data = [];
                if(!is_array($wdmIds) && !count($wdmIds)){
                    exit(json_encode(array('status' => 0, 'msg' => 'data error!', 'data' => $data)));
                }
                foreach ($wdmIds as $id){
                    $products_id = (int)$id;
                    $data[$products_id] = get_instock_for_index($products_id);
                }
                exit(json_encode(array('status' => 1, 'data' => $data, 'msg' => '')));
                break;

            case 'get_related_products_images':
                $products_des_html = '';
                $products_id = $_POST['products_id'] ? (int)$_POST['products_id'] :0;
                $current_pid = $_POST['current_pid'] ? (int)$_POST['current_pid']  : 0;
                if(!$products_id){
                   exit(json_encode(['status'=>0,'data'=>'']));
                }
                $productService = new App\Services\Products\ProductService();
                $products_info = $productService->getOneProductInfo($products_id, true);
                if(!empty($products_info)){
                    require_once('includes/classes/shipping_info.php');
                    $products_des_html = get_match_products_des_html($products_id,$products_info,'',$current_pid);
                    exit(json_encode(['status'=>1,'data'=>$products_des_html]));
                }else{
                    exit(json_encode(['status'=>0,'data'=>'']));
                }
                break;

        }
    }
}