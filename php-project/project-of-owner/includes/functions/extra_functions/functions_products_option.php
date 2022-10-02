<?php
function fs_products_to_categories_id($id){
  global $db;
  $cid=0;
  $category = $db->Execute("select categories_id from products_to_categories where products_id = ".(int)$id." order by sort_order limit 1 ");
  if($category->fields['categories_id']){
    $cid = $category->fields['categories_id'];
  }
  return $cid;
}

function fs_product_length_info($id){
  global $db;
  $keys_data = get_product_category_key($id);
  $keys_number = $keys_data['key'];
  if($keys_number == 2 || ($keys_number == 1 && $retail==0) ){
    $productLengthInfo  = $db->getAll("select * from products_length where product_id = '".$id."' and custom=0 order by sign DESC,length ASC");
  }else{
    $productLengthInfo  = $db->getAll("select * from products_length where product_id = '".$id."' and custom=0 order by length_price ASC");
  }
  return $productLengthInfo;
}

function fs_products_option_info($id){
  global $db;
  //$_GET['products_id'] = $id;
  $show_onetime_charges_description = 'false';
  $show_attributes_qty_prices_description = 'false';

// limit to 1 for performance when processing larger tables
  $sql = "select count(*) as total
          from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
          where    patrib.products_id='" . (int)$id . "'
            and      patrib.options_id = popt.products_options_id
            and      popt.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
      " limit 1";


  $pr_attr = $db->Execute($sql);

  if ($pr_attr->fields['total'] > 0) {
    if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
      $options_order_by= ' order by LPAD(popt.products_options_sort_order,11,"0")';
    } else {
      //$options_order_by= ' order by popt.products_options_name';
      $options_order_by= ' order by patrib.products_attributes_id desc';
    }

    $sql = "select distinct popt.products_options_id, popt.products_options_name, popt.products_options_sort_order,
                              popt.products_options_type, popt.products_options_length, popt.products_options_comment,
                              popt.products_options_size,
                              popt.products_options_images_per_row,
                              popt.products_options_images_style,
                              popt.products_options_rows,popt.products_options_count
              from        " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
              where           patrib.products_id='" . (int)$id . "'
              and             patrib.options_id = popt.products_options_id
              and             patrib.attributes_status =1
              and             popt.products_options_status = 1
              and             popt.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
        $options_order_by;

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

    //$discount_type = zen_get_products_sale_discount_type((int)$id);
    //$discount_amount = zen_get_discount_calc((int)$id);

    $zv_display_select_option = 0;

    while (!$products_options_names->EOF) {
      $products_options_array = array();

      $sql = "select    pov.products_options_values_id,
                        pov.products_options_values_name,
                        pa.*
              from      " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
              where     pa.products_id = '" . (int)$id . "'
              and       pa.options_id = '" . (int)$products_options_names->fields['products_options_id'] . "'
              and       pa.options_values_id = pov.products_options_values_id
              and       pov.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
          $order_by;
      //echo '<div style="display:none">'.$sql.'</div>';
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
//                       $new_attributes_price = zen_get_discount_calc((int)$id, true, $new_attributes_price);
          } else {
            // discount is off do not apply
            $new_attributes_price = $products_options->fields['options_values_price'];
          }

          // reverse negative values for display
          if ($new_attributes_price < 0) {
            $new_attributes_price = -$new_attributes_price;
          }


          $price_onetime = '';


          if ($products_options->fields['attributes_qty_prices'] != '' or $products_options->fields['attributes_qty_prices_onetime'] != '') {
            $show_attributes_qty_prices_description = 'true';
            $show_attributes_qty_prices_icon = 'true';
          }


        } // approve
        $products_options_array[sizeof($products_options_array)-1]['text'] .= $products_options_display_price;
        //echo '<div style="display:none">'.$products_options_array[sizeof($products_options_array)-1]['text'].'</div>';
        // collect weight information if it exists
        if (($flag_show_weight_attrib_for_this_prod_type=='1' and $products_options->fields['products_attributes_weight'] != '0')) {
          $products_options_display_weight = ATTRIBUTES_WEIGHT_DELIMITER_PREFIX . $products_options->fields['products_attributes_weight_prefix'] . round($products_options->fields['products_attributes_weight'],2) . TEXT_PRODUCT_WEIGHT_UNIT . ATTRIBUTES_WEIGHT_DELIMITER_SUFFIX;
          $products_options_array[sizeof($products_options_array)-1]['text'] .= $products_options_display_weight;
        } else {
          // reset
          $products_options_display_weight='';
        }

        // prepare product options details
        $prod_id = $id;
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
            $products_options_details .= $products_options_display_price . ($products_options->fields['products_attributes_weight'] != 0 ? '  ' . $products_options_display_weight : '');
            $products_options_details_noname = $products_options_display_price . ($products_options->fields['products_attributes_weight'] != 0 ? '  ' . $products_options_display_weight : '');
          }
        }

        // radio buttons
        if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_RADIO) {
          if ($_SESSION['cart']->in_cart($prod_id)) {
            if ($_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']] == $products_options->fields['products_options_values_id']) {
              $selected_attribute = $_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']];
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
                if (($key == $products_options_names->fields['products_options_id'] and $value == $products_options->fields['products_options_values_id'])) {
                  // zen_get_products_name($_POST['products_id']) .
                  $selected_attribute = true;
                  break;
                }
              }
            } else {
              $selected_attribute = ($products_options->fields['attributes_default']=='1' ? true : ($products_options->RecordCount() == 1 ? true : false));
            }
          }

          switch ($products_options_names->fields['products_options_images_style']) {

            case '0':
              if($xt=get_remark_status($products_options_names->fields['products_options_id'])){
                if($i == 1){
                  $tmp_radio .= '<div id="show'.$xt.'" class="c_wavelength">';
                }
                //if($cPath_array[2] == 990){
                $products_options_values_name = $products_options->fields['products_options_values_name'];
                if(strpos($products_options_values_name,'(')){
                  $products_options_values_name = explode('(',$products_options_values_name);
                  $products_options_values_name = $products_options_values_name[0];
                }
                //}else{
                //$products_options_values_name = $products_options->fields['products_options_values_name'];
                //}
                $tmp_radio .= zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"');
                $tmp_radio .='<label class="lable_color" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" title="'.$products_options_values_name.'"><span>'.$products_options_values_name.'</span><i></i></label>';
                if($i == $products_options->RecordCount()){
                  $tmp_radio .= '</div>';
                }
              }else{
                $tmp_radio .=  '<label class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' .zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"'). $products_options_details . '</label><br />' . "\n";
              }
              break;

            case '1':
              $tmp_radio .= '<div class="product_03_08_01">'.zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton one" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ($products_options->fields['attributes_image'] != '' ? zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) . '  ' : '') . '  '.$products_options_details . '</label></div>' . "\n";
              break;
            case '2':
              $tmp_radio .= zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton two" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . ($products_options->fields['attributes_image'] != '' ? '<br />' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image'], '', '', '' ) : '') . '</label><br />' . "\n";
              break;
            case '3':
              $tmp_attributes_image_row++;
              //                  if ($tmp_attributes_image_row > PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW) {
              if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
                $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
                $tmp_attributes_image_row = 1;
              }

              if ($products_options->fields['attributes_image'] != '') {
                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton three" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . $products_options_details_noname . '</label></div>' . "\n";
              } else {
                $tmp_attributes_image .= '<div class="attribImg">' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']',  $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<br />' . '<label class="attribsRadioButton threeA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . $products_options_details_noname . '</label></div>' . "\n";
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
                $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsRadioButton four" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
              } else {
                $tmp_attributes_image .= '<div class="attribImg">' . '<label class="attribsRadioButton fourA" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options->fields['products_options_values_name'] . ($products_options_details_noname != '' ? '<br />' . $products_options_details_noname : '') . '</label><br />' . zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '</div>' . "\n";
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
                $tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"');
                $tmp_checkbox .='<label class="lable_color_'.$i.'" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" title="'.$products_options->fields['products_options_values_name'].'"><span></span></label>';
                if($i == 12){
                  $tmp_checkbox .= '</div>';
                }
              }elseif($re = $xt=specical_service_status($products_options_names->fields['products_options_id'])){
                $option_value_id = str_replace(' ','',strtolower($products_options->fields['products_options_values_name']));
                $option_value_id = str_replace(',','',$option_value_id);
                $option_value_id = str_replace('/','',$option_value_id);
                $option_value_id = substr($option_value_id,0,25);
                $tmp_checkbox .= '<label>'.zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' .$option_value_id. '"')  . $products_options_details.'</label>';
              }else{
                $tmp_checkbox .= '<label>'.zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'tag="'.$products_options_names->fields['products_options_id'] . '-' . $products_options_value_id.'"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"')  . $products_options_details.'</label>';
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

          if ($_POST['id']) {
            reset($_POST['id']);
            foreach ($_POST['id'] as $key => $value) {

              if ((preg_replace('/txt_/', '', $key) == $products_options_names->fields['products_options_id'])) {
                // use text area or input box based on setting of products_options_rows in the products_options table
                if ( $products_options_names->fields['products_options_rows'] > 1) {
                  $tmp_html = '  <input disabled="disabled" type="text" name="remaining' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . '" size="3" maxlength="3" value="' . $products_options_names->fields['products_options_length'] . '" /> ' . TEXT_MAXIMUM_CHARACTERS_ALLOWED . '<br />';
                  $tmp_html .= '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="' . $products_options_names->fields['products_options_rows'] . '" cols="' . $products_options_names->fields['products_options_size'] . '" onKeyDown="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" onKeyUp="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . stripslashes($value) .'</textarea>' . "\n";
                } else {
                  $tmp_html = '<input class="attr_input" type="text" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" size="' . $products_options_names->fields['products_options_size'] .'" maxlength="' . $products_options_names->fields['products_options_length'] . '" value="' . stripslashes($value) .'" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" />  ';
                }
                $tmp_html .= $products_options_details;
                break;
              }
            }
          } else {
            $tmp_value = $_SESSION['cart']->contents[$id]['attributes_values'][$products_options_names->fields['products_options_id']];
            // use text area or input box based on setting of products_options_rows in the products_options table
            if ( $products_options_names->fields['products_options_rows'] > 1 ) {
              $tmp_html = '  <input disabled="disabled" type="text" name="remaining' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . '" size="3" maxlength="3" value="' . $products_options_names->fields['products_options_length'] . '" /> ' . TEXT_MAXIMUM_CHARACTERS_ALLOWED . '<br />';
              $tmp_html .= '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="' . $products_options_names->fields['products_options_rows'] . '" cols="' . $products_options_names->fields['products_options_size'] . '" onkeydown="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" onkeyup="characterCount(this.form[\'' . 'id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']\'],this.form.' . TEXT_REMAINING . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ',' . $products_options_names->fields['products_options_length'] . ');" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . stripslashes($tmp_value) .'</textarea>' . "\n";
              //                $tmp_html .= '  <input type="reset">';
            }else{
              if(get_remark_status($products_options_names->fields['products_options_id'])){
                $tmp_html = '<textarea class="attribsTextarea" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" rows="5" cols="30" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" >' . $tmp_value_html .'</textarea>' . "\n";
              }else{
                $tmp_html = '<input type="text" class="attr_input" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']" size="' . $products_options_names->fields['products_options_size'] .'" maxlength="' . $products_options_names->fields['products_options_length'] . '" value="' . htmlspecialchars($tmp_value) .'" id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" />  ';
              }
            }
            $tmp_html .= $products_options_details;
            $tmp_word_cnt_string = '';
            // calculate word charges
            $tmp_word_cnt =0;
            $tmp_word_cnt_string = $_SESSION['cart']->contents[$id]['attributes_values'][$products_options_names->fields['products_options_id']];
            $tmp_word_cnt = zen_get_word_count($tmp_word_cnt_string, $products_options->fields['attributes_price_words_free']);
            $tmp_word_price = zen_get_word_count_price($tmp_word_cnt_string, $products_options->fields['attributes_price_words_free'], $products_options->fields['attributes_price_words']);

            // calculate letter charges
            $tmp_letters_cnt =0;
            $tmp_letters_cnt_string = $_SESSION['cart']->contents[$id]['attributes_values'][$products_options_names->fields['products_options_id']];
            $tmp_letters_cnt = zen_get_letters_count($tmp_letters_cnt_string, $products_options->fields['attributes_price_letters_free']);
            $tmp_letters_price = zen_get_letters_count_price($tmp_letters_cnt_string, $products_options->fields['attributes_price_letters_free'], $products_options->fields['attributes_price_letters']);


            $tmp_html .= "\n";
          }
        }

        if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE) {
          $number_of_uploads++;
          if (zen_run_normal() == true and zen_check_show_prices() == true) {
            $tmp_html = '<input type="file" name="id[' . TEXT_PREFIX . $products_options_names->fields['products_options_id'] . ']"  id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" /><br />' . $_SESSION['cart']->contents[$prod_id]['attributes_values'][$products_options_names->fields['products_options_id']] . "\n" .
                zen_draw_hidden_field(UPLOAD_PREFIX . $number_of_uploads, $products_options_names->fields['products_options_id']) . "\n" .
                zen_draw_hidden_field(TEXT_PREFIX . UPLOAD_PREFIX . $number_of_uploads, $_SESSION['cart']->contents[$prod_id]['attributes_values'][$products_options_names->fields['products_options_id']]);
          } else {
            $tmp_html = '';
          }
          $tmp_html .= $products_options_details;
        }

        if ($products_options_names->fields['products_options_images_style'] == '0' or ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE or $products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT or $products_options_names->fields['products_options_type'] == '0') ) {
          if ($products_options->fields['attributes_image'] != '') {
            $tmp_attributes_image_row++;

            if ($tmp_attributes_image_row > $products_options_names->fields['products_options_images_per_row']) {
              $tmp_attributes_image .= '<br class="clearBoth" />' . "\n";
              $tmp_attributes_image_row = 1;
            }

            $tmp_attributes_image .= '<div class="attribImg">' . zen_image(DIR_WS_IMAGES . $products_options->fields['attributes_image']) . (PRODUCT_IMAGES_ATTRIBUTES_NAMES == '1' ? '<br />' . $products_options->fields['products_options_values_name'] : '') . '</div>' . "\n";
          }
        }

        if ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_READONLY) {
          $tmp_html .= $products_options_details . '<br />';
        } else {
          $zv_display_select_option ++;
        }

        if ($products_options->fields['attributes_default']=='1') {
          $selected_attribute = $products_options->fields['products_options_values_id'];
        }

        $products_options->MoveNext();

      }

      switch (true) {
        // text
        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_TEXT):
          if ($show_attributes_qty_prices_icon == 'true') {
            $options_name[] = '<label class="attribsInput" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</label>';
          } else {
            $options_name[] = '<label class="attribsInput" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_names->fields['products_options_name'] . '</label>';
          }
          $options_menu[] = $tmp_html . "\n";
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 0;
          break;
        // checkbox
        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_CHECKBOX):
          if ($show_attributes_qty_prices_icon == 'true') {
            $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];
          } else {
            $options_name[] = $products_options_names->fields['products_options_name'];
          }
          $options_menu[] = $tmp_checkbox . "\n";
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 0;
          break;
        // radio buttons
        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_RADIO):
          if ($show_attributes_qty_prices_icon == 'true') {
            $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];
          } else {
            $options_name[] = $products_options_names->fields['products_options_name'];
          }
          $options_menu[] = $tmp_radio . "\n";
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 0;
          break;
        // file upload
        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_FILE):
          if ($show_attributes_qty_prices_icon == 'true') {
            $options_name[] = '<label class="attribsUploads" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</label>';
          } else {
            $options_name[] = '<label class="attribsUploads" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_names->fields['products_options_name'] . '</label>';
          }
          $options_menu[] = $tmp_html . "\n";
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 0;
          break;
        // READONLY
        case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_READONLY):
          $options_name[] = $products_options_names->fields['products_options_name'];
          $options_menu[] = $tmp_html . "\n";
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 0;
          break;

        case ($products_options->RecordCount() == 1 && ($products_options_names->fields['products_options_name'] == '18ch Wavelengths' || $products_options_names->fields['products_options_name'] == 'Fiber Diameter' || $products_options_names->fields['products_options_name'] == 'MTP Polarity' || $products_options_names->fields['products_options_name'] == 'Cable Diameter')):
          if ($show_attributes_qty_prices_icon == 'true') {
            $options_name[] = '<label class="switchedLabel ONE" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</label>';
          } else {
            $options_name[] = $products_options_names->fields['products_options_name'];
          }
          $options_menu[] = zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 'selected', 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '" class="product_03_08_radio"') . '<label class="attribsRadioButton" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label>' . "\n";
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 1;
          break;

        default:
          if (isset($_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']])) {
            $selected_attribute = $_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']];
          } else {
            if ($_POST['id'] !='') {
              reset($_POST['id']);
              foreach($_POST['id'] as $key => $value){
                if ($key == $products_options_names->fields['products_options_id']){
                  $selected_attribute = $value;
                  break;
                }
              }
            }else{
            }
          }

          if ($show_attributes_qty_prices_icon == 'true') {
            $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];
          } else {
            $options_name[] = '<label class="attribsSelect" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '">' . $products_options_names->fields['products_options_name'] . '</label>';
          }


            $options_menu[] = zen_draw_pull_down_menu('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_array, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '"') . "\n";
   
          $options_comment[] = $products_options_names->fields['products_options_comment'];
          $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
          $options_comment_p[] = 0;
          break;
      }
      $options_attributes_image[] = trim($tmp_attributes_image) . "\n";
      $products_options_names->MoveNext();
    }
    $_GET['number_of_uploads'] = $number_of_uploads;
    zen_draw_hidden_field('number_of_uploads', $number_of_uploads);
  }

  return $options_name;
}
?>