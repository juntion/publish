<?php
/**
 * attributes module
 *
 * Prepares attributes content for rendering in the template system
 * Prepares HTML for input fields with required uniqueness so template can display them as needed and keep collected data in proper fields
 *
 * @package modules
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: attributes.php 14141 2009-08-10 19:34:47Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

//属性开始
$custom_status = false;
$sql = "select column_id,column_name from attribute_custom_column where column_name = '" . (int)$_GET['products_id'] . "' and parent_id = 0";
$attribute_custom_column = $db->Execute($sql);

// fairy 2017.10.11 获取当前产品的分类ID，后面需要使用
$sql = "select categories_id from products_to_categories where products_id = '" . (int)$_GET['products_id'] . "' limit 1 ";
$products_to_categories = $db->getAll($sql);
$current_product_categoty_id = $products_to_categories[0]['categories_id'];
$custom_attribute_data = [];
//$html_select_type = get_select_type_html(); //属性选择类型
$html_select_type = '';
if($attribute_custom_column->fields['column_name']>0){ //层级属性
    $custom_status = true;
    $custom_attribute_data = zen_get_fs_attribute_box((int)$_GET['products_id'], $cPath_array[2],$html_select_type);
    $match_product = match_product_initialization_information((int)$_GET['products_id'],$custom_attribute_data['all_Attr'],$all_length);
}else{  //非层级属性
    $show_onetime_charges_description = 'false';
    $show_attributes_qty_prices_description = 'false';

    // limit to 1 for performance when processing larger tables
    $sql = "select count(*) as total
          from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
          where    patrib.products_id='" . (int)$_GET['products_id'] . "'
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
              where           patrib.products_id='" . (int)$_GET['products_id'] . "'
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

        //$discount_type = zen_get_products_sale_discount_type((int)$_GET['products_id']);
        //$discount_amount = zen_get_discount_calc((int)$_GET['products_id']);

        $zv_display_select_option = 0;

        //记录初始化属性:$custom_attribute_data['all_Attr']=>带属性项+属性值  $custom_attribute_data['attr']=>属性值
        $custom_attribute_data['all_Attr'] = '';
        $custom_attribute_data['attr'] = '';
        $options_data = [];  //products_options_id
        while (!$products_options_names->EOF) {
            $products_options_array = array();
            $option_value_array = array();
            $options_data[] = $products_options_names->fields['products_options_id'];
            /*
            pa.options_values_price, pa.price_prefix,
            pa.products_options_sort_order, pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,
            pa.attributes_default, pa.attributes_discounted, pa.attributes_image
            */

            $sql = "select    pov.products_options_values_id,
                        pov.products_options_values_name,pa.del_color,
                        pa.*
              from      " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
              where     pa.products_id = '" . (int)$_GET['products_id'] . "'
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
//                       $new_attributes_price = zen_get_discount_calc((int)$_GET['products_id'], true, $new_attributes_price);
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
                $prod_id = $_GET['products_id'];
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
                                $tmp_radio .=  '<label class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' .zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' .  str_replace(' ','-',strtolower($products_options_names->fields['products_options_name'])) .'-'.  str_replace(' ','-',strtolower($products_options->fields['products_options_values_name'])) . '"'). $products_options_details . '</label>' . "\n";
//						    $tmp_radio .='<option class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">'.$products_options_details.'</option>';

                            }else{
                                $active = '';
                                $class = '';
                                if(in_array($_GET['products_id'],['75875','75874','75877'])){
                                    $class = ' attribsRadioLabel';
                                    if($products_options_value_id == 7243){
                                        $active = ' active';
                                        $selected_attribute = 'id[297]';
                                    }
                                }
                                $tmp_radio .=  '<label class="attribsRadioButton'.$class.$active.' zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' .zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"'). $products_options_details . '</label>';
//                            $tmp_radio .='<option class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">'.$products_options_details.'</option>';
                                if($products_options_value_id==4262){
                                    if($products_options_names->fields['related_option_id']){
                                        $related_id = $products_options_names->fields['related_option_id'];
                                        $tmp_radio .= '<div class="custom_wavelength" style="display:none;"><input id="attrib-'.$related_id.'-0" class="attr_input_2" type="text" value="" size="19" name="ids[text_prefix_'.$related_id.']" placeholder="">';
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
                            $tmp_radio .= '<div class="product_03_08_01">'.zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton one" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ($products_options->fields['attributes_image'] != '' ? zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) . '  ' : '') . '  '.$products_options_details . '</label></div>' . "\n";
                            break;
                        case '2':
                            $tmp_radio .= zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton two" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . ($products_options->fields['attributes_image'] != '' ? '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) : '') . '</label>' . "\n";
                            break;
                        case '3':
                            $tmp_attributes_image_row++;
                            //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                            if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                $tmp_attributes_image_row = 1;
                            }

                            if ($products_options->fields['attributes_image'] != '') {
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton three" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . $products_options_details_noname . '</label></div>' . "\n";
                            } else {
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']',  $products_options_value_id, $selected_attribute, ''.$checked_status.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton threeA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . $products_options_details_noname . '</label></div>' . "\n";
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
                                $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsRadioButton four" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_sta.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
                            } else {
                                $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsRadioButton fourA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, ''.$checked_sta.' id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
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
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton five" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>';
                            } else {
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton fiveA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>';
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
                    $tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details .'</label><br />';
                    */
                    switch ($products_options_names->fields['products_options_images_style']) {
                        case '0':
                            //$tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label><br />' . "\n";
//                        $tmp_checkbox .= '<label>'.zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'" onClick="checkOptions(this.id,\'id\\['.$products_options_names->fields['products_options_id'].'\\]\','.$products_attributes_count.')" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"')  . $products_options_details.'</label>';
                            //针对颜色块
                            if($xt=get_remark_status($products_options_names->fields['products_options_id'])){
                                if($i == 1){
                                    $tmp_checkbox .= '<div id="show'.$xt.'" class="toggle">';
                                }
                                if($products_options->fields['del_color'] != 1){
                                    $tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"');
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
                                $class=' customLable';
                                $tmp_checkbox .= '<label class="attribsCheckboxButton '.$class.'">'.zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' .$option_value_id. '"')  . $products_options_details.'</label>';
                            }else{
                                //custom lable
                                $onclick_str = '';
                                $class=' customLable';
                                if($products_options_names->fields['products_options_id']==318){
                                    $onclick_str = 'onclick="show_lables_or_not('.$_GET['products_id'].',$(this));"';
                                }else{
                                    //初始化默认选中第一个
                                    if($i==1) {
                                        $class = ' customLable ';
                                        $custom_attribute_data['all_Attr'] .= $products_options_names->fields['products_options_id'].':'.$products_options_value_id.',';
                                        $custom_attribute_data['attr'] .= $products_options_value_id.',';
                                        $selected_attribute = true;
                                    }
                                }
                                $tmp_checkbox .= '<label class="attribsCheckboxButton'.$class.'">'.zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"'.$onclick_str.'')  . $products_options_details.'</label>';
                            }
                            break;
                        case '1':
                            $tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ($products_options->fields['attributes_image'] != '' ? zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) . '  ' : '') . $products_options_details . '</label><br />' . "\n";
                            break;
                        case '2':
                            $tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . ($products_options->fields['attributes_image'] != '' ? '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) : '') . '</label><br />' . "\n";
                            break;

                        case '3':
                            $tmp_attributes_image_row++;

                            //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
                            if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                                $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                                $tmp_attributes_image_row = 1;
                            }

                            if ($products_options->fields['attributes_image'] != '') {
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . $products_options_details_noname . '</label></div>' . "\n";
                            } else {
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . $products_options_details_noname . '</label></div>' . "\n";
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
                                $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
                            } else {
                                $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']',$products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
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
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>' . "\n";
                            } else {
                                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label></div>' . "\n";
                            }
                            break;
                    }
                }


                // text
                if (($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT)) {
                    //CLR 030714 Add logic for text option
                    //            $products_attribs_query = zen_db_query("select distinct patrib.options_values_price, patrib.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = '" . $products_options_name['products_options_id'] . "'");
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
                                    $tmp_html = '<div class="custom_lable_wavelength">    
                            <input class="attr_input attr_input_text" type="text" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" size="' . $products_options_names->fields['products_options_size'] .'" maxlength="' . $products_options_names->fields['products_options_length'] . '" value="' . stripslashes($value) .'" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" placeholder="'.FS_PLACEHOLDER_EG.stripslashes($products_options_names->fields['options_placeholder']).'" />  </div>';
                                }
                                $tmp_html .= $products_options_details;
                                break;
                            }
                        }
                    } else {
                        $tmp_value = $_SESSION['cart']->contents[$_GET['products_id']]['attributes_values'][$products_options_names->fields['products_options_id']];
                        // use text area or input box based on setting of products_options_rows in the products_options table
                        if ( $products_options_names->fields['products_options_rows'] > 1 ) {
                            $tmp_html = '  <input disabled="disabled" type="text" name="remaining' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . '" size="3" maxlength="3" value="' . $products_options_names->fields['products_options_length'] . '" /> ' . TEXT_MAXIMUM_CHARACTERS_ALLOWED . '<br />';
                            $tmp_html .= '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="' . $products_options_names->fields['products_options_rows'] . '" cols="' . $products_options_names->fields['products_options_size'] . '" onkeydown="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" onkeyup="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . stripslashes($tmp_value) .'</textarea>' . "\n";
                            //                $tmp_html .= '  <input type="reset">';
                        }else{
                            if(get_remark_status($products_options_names->fields['products_options_id'])){
                                $tmp_html = '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="5" cols="30" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . $tmp_value_html .'</textarea>' . "\n";
                            }else{
                                $tmp_html = '<div class="custom_lable_wavelength"><input type="text" class="attr_input attr_input_text" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" size="' . $products_options_names->fields['products_options_size'] .'" maxlength="' . $products_options_names->fields['products_options_length'] . '" value="' . htmlspecialchars($tmp_value) .'" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" placeholder="'.FS_PLACEHOLDER_EG.stripslashes($products_options_names->fields['options_placeholder']).'"/> </div> ';
                            }
                        }
                        $tmp_html .= $products_options_details;
                        $tmp_word_cnt_string = '';
                        // calculate word charges
                        $tmp_word_cnt =0;
                        $tmp_word_cnt_string = $_SESSION['cart']->contents[$_GET['products_id']]['attributes_values'][$products_options_names->fields['products_options_id']];
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
                        $tmp_letters_cnt_string = $_SESSION['cart']->contents[$_GET['products_id']]['attributes_values'][$products_options_names->fields['products_options_id']];
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
                        // $cart->contents[$_GET['products_id']]['attributes_values'][$products_options_name['products_options_id']]
                        $tmp_html = '<div class="pro-detail-fileUpload-box">
                                    <div class="custom_lable_wavelength">
                                    <span class="iconfont pro-detail-fileUpload-ic">&#xf324;</span>
                                    <input type="text" class="attr_input pro-detail-fileUpload-input" placeholder="'.stripslashes($products_options_names->fields['options_placeholder']).'" readonly value=""><span class="delete-image-icon" onclick="delete_file();" style="display: none;"><em class="icon iconfont icon_on">&#xf092;</em></span>
                                    <input class="pro-detail-fileUpload-input01" type="file" title="" onchange="previewImage($(this))" name="id['. $products_options_names->fields['products_options_id'] . ']"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" /><br />' . $_SESSION['cart']->contents[$prod_id]['attributes_values'][$products_options_names->fields['products_options_id']] . "\n".
                            '</div></div>';
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
                    //            $tmp_html .= '<input type="hidden" name ="id[' . $products_options_names->fields['products_options_id'] . ']"' . '" value="' . stripslashes($products_options->fields['products_options_values_name']) . ' SELECTED' . '" />  ' . $products_options->fields['products_options_values_name'];
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
                    $html_custom .= '<div class="custom_wavelength" style="display:none;"><input id="attrib-' . $related_id . '-0" class="attr_input_2" type="text" value="" size="19" name="id[text_prefix_' . $related_id . ']" placeholder="">';
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
                    $options_menu[] = zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 'selected', 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" class="product_03_08_radio"') . '<label class="attribsRadioButton" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label>' . "\n";
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
                        $options_menu[] = zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 'selected', 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" class="product_03_08_radio"') . '<label class="attribsRadioButton" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label>' . "\n";
                        $options_comment[] = $products_options_names->fields['products_options_comment'];
                        $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                        $options_comment_p[] = 1;
                        break;


                    default:
                        // normal dropdown menu display
                        if (isset($_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']])) {
                            $selected_attribute = $_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']];
                        } else {
                            // use customer-selected values
                            if ($_POST['id'] !='') {
                                reset($_POST['id']);
                                foreach($_POST['id'] as $key => $value){
                                    if ($key == $products_options_names->fields['products_options_id']){
                                        $selected_attribute = $value;
                                        break;
                                    }
                                }
                            }else{
                                // use default selected set above
                            }
                        }



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
                                $productsId = (int)$_GET['products_id'];
                                if($selected_attribute==6452){$brandFlag=true;}else{$brandFlag=false;}
                                $compatibility_placeholder = get_compatibility_placeholder($productsId,true,$brandFlag);
                                $brandClass = $compatibility_placeholder['brandClass'];
                                $brandHtml = $compatibility_placeholder['brandHtml'];

                                // fariy 2018.8.15 对一些提示进行了优化
                                $options_menu[] = zen_draw_pull_down_menu('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_array, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '" rel="AttrSelect"',false,false) . "\n".'';
                                $options_menu[] = '<div  class="custom_wavelength"><input id="attrib-159-0" class="big_input '.$brandClass.'" type="text" value="" size="19" name="id[text_prefix_159]" placeholder="'.$brandHtml.'"></div><div class="hpe_error"></div>';
                            }else{
                                $options_menu[] = zen_draw_pull_down_menu('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_array, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '" rel="AttrSelect"',false,false) . "\n".$html_custom;
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
    }
}


//定制产品只有长度属性且且关联组里面包含长度属性 --start(属性关联)
$custom_length_arr = [];
$only_length_custom = false;//定制产品只有长度属性
$customLenStatus = 0;
if($status){
    if($productLengthInfo) {
        if ($keys_number == 1 && $retail == 0) {
            $customLenStatus = 1;
        }
        if((!$custom_status && !$pr_attr->fields['total'] > 0)){
            $only_length_custom = true;
        }
    }
}
$custom_length_arr = array(
    'only_length_custom'=>$only_length_custom,
    'keys_number'=>$keys_number,
    'unit_price'=>$status[0]['unit_price'],
    'retail'=>$retail,
    'customLenStatus'=>$customLenStatus,
    'pid'=>$_GET['products_id'],
    'productLengthInfo'=>$productLengthInfo,
    'cPath'=>$cPath_array,
);
$current_products_id = (int)trim($_GET['products_id']);
$attribute_id = (int)trim($_GET['attribute']);
$ralation_id = (int)trim($_GET['id']);
if($attribute_id){
    $redis_current_products_id = $current_products_id."_".$attribute_id;
}else{
    $redis_current_products_id = $current_products_id;
}
if($ralation_id){
    $redis_current_products_id = $current_products_id."_".$attribute_id."_".$ralation_id;
}
//新产品关联属性开始
$cPath_array_str = implode('_',$cPath_array);
define('PRODUCT_DETAIL_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_product_related_attribute_'.$cPath_array_str.'_'.$redis_current_products_id.'_for_detail:');
$related_attribute_redis_key = md5($redis_current_products_id.$_SESSION['countries_iso_code'],true);
$related_attributes_array = get_redis_key_value($related_attribute_redis_key,PRODUCT_DETAIL_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
//$related_attributes_array = array();
if (!$related_attributes_array) {
    if (!$productRelatedAttributesModel) {
        require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
        $productRelatedAttributesModel = new productRelatedAttributesModel();
    }
    echo '<!-- attribute detail not cache -->';
    $related_attributes_array = $productRelatedAttributesModel->get_product_detail_related_attribute($current_products_id,'detail',$is_custome_new,$cPath_array,$custom_length_arr);
    set_redis_key_value($related_attribute_redis_key,$related_attributes_array,24*3600,PRODUCT_DETAIL_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
}
if($related_attributes_array){
    if (!$productRelatedAttributesModel) {
        require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
        $productRelatedAttributesModel = new productRelatedAttributesModel();
    }
    $related_attributes_str = $productRelatedAttributesModel->handle_product_detail_related_attribute($related_attributes_array,$current_products_id,'detail',$cPath_array,$custom_length_arr);
}
/*--end (属性关联) --*/
$all_length = ''; //default长度属性
$customLenStatus = 0;
$related_attribute_length = false;
if($related_attributes_array){
    foreach ($related_attributes_array as $kk => $vv){
        if(in_array($vv['eng_name'], array('length', 'Length'))){
            $related_attribute_length = true; //属性关联中展示长度属性
            $all_length = '1m';
        }
    }
}

$is_length = ($status && !$related_attribute_length && $productLengthInfo);
if($is_length){
    foreach($productLengthInfo as $key=>$v){
        if($v['sign'] == 1){
            $all_length = $v['length'] ? $v['length'] : '1m';
        }
    }
}

?>