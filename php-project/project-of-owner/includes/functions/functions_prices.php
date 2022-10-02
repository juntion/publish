<?php
//get specials price or sale price
  function zen_get_products_special_price($product_id, $specials_price_only=false) {
    global $db;
    $product = $db->Execute("select products_price, products_model, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");

    if ($product->RecordCount() > 0) {
//  	  $product_price = $product->fields['products_price'];
      $product_price = zen_get_products_base_price($product_id);
    } else {
      return false;
    }


      $special_price = false;


    if(substr($product->fields['products_model'], 0, 4) == 'GIFT') {    //Never apply a salededuction to Ian Wilson's Giftvouchers
      if (zen_not_null($special_price)) {
        return $special_price;
      } else {
        return false;
      }
    }

// return special price only
    if ($specials_price_only==true) {
      if (zen_not_null($special_price)) {
        return $special_price;
      } else {
        return false;
      }
    } else {
// get sale price
      return $special_price;
    }
  }


////
// computes products_price + option groups lowest attributes price of each group when on
// 2019-7-23 potato 为避免重复查询products表的产品详情特加上第三参数$product_detail，此为product_info/header_php.php已经查询过的数据
  function zen_get_products_base_price($products_id,$clearance  = false, $product_detail='') {
    global $db;
      if($clearance == true){
          $product_check = $db->Execute("select c.products_clearance_price  as products_price,p.products_priced_by_attribute from products_clearance AS c LEFT JOIN products AS p using(products_id) where products_id = '" . (int)$products_id . "'");
      }else{
          // 存在已经查询过的products表的数据就直接用，避免反复查询
          if ($product_detail) {
              $product_check = $product_detail;
          } else {
              $product_check = $db->Execute("select products_price, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
          }
      }
// is there a products_price to add to attributes
      $products_price = zen_get_products_base_price_other($product_check->fields['products_price']);

      // do not select display only attributes and attributes_price_base_included is true
      $product_att_query = $db->Execute("select options_id, price_prefix, options_values_price, attributes_display_only, attributes_price_base_included, round(concat(price_prefix, options_values_price), 5) as value from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "' and attributes_display_only != '1' and attributes_price_base_included='1'". " order by options_id, value");

      $the_options_id= 'x';
      $the_base_price= 0;
// add attributes price to price
      if ($product_check->fields['products_priced_by_attribute'] == '1' and $product_att_query->RecordCount() >= 1) {
        while (!$product_att_query->EOF) {
          if ( $the_options_id != $product_att_query->fields['options_id']) {
            $the_options_id = $product_att_query->fields['options_id'];
            $the_base_price += (($product_att_query->fields['price_prefix'] == '-') ? -1 : 1) * $product_att_query->fields['options_values_price'];
          }
          $product_att_query->MoveNext();
        }

        $the_base_price = $products_price + $the_base_price;
      } else {
        $the_base_price = $products_price;
      }
      return $the_base_price;
  }

    // fairy 2019.1.17 add，如果有sql语句，已经查询出产品价格，直接处理就好了
    /* Dylan 2020.4.30 au站澳大利亚国家展示税后价
     * Jeremy 2019/06/29 edit
     * @param float $products_price 价格
     * @return float 最终显示价格
     * 主站及UK站英镑加价5%显示
     */
    function zen_get_products_base_price_other($products_price) {
        if($_SESSION['languages_code'] == 'uk'){
            $products_price = $products_price*1.05;
        }elseif($_SESSION['languages_code'] == 'en' && $_SESSION['currency'] == 'GBP'){
            $products_price = $products_price*1.05;
        }else{
            $products_price = $products_price;
        }
        return $products_price;
    }

////
// Display Price Retail
// Specials and Tax Included
  function zen_get_products_display_price($products_id) {
    global $db, $currencies;

    $free_tag = "";
    $call_tag = "";

// 0 = normal shopping
// 1 = Login to shop
// 2 = Can browse but no prices
    // verify display of prices
      switch (true) {
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
        // customer must be logged in to browse
        return '';
        break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
        // customer may browse but no prices
        return TEXT_LOGIN_FOR_PRICE_PRICE;
        break;
        case (CUSTOMERS_APPROVAL == '3' and TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
        // customer may browse but no prices
        return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
        break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
        // customer must be logged in to browse
        return TEXT_AUTHORIZATION_PENDING_PRICE;
        break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customers_authorization'] > '0'):
        // customer must be logged in to browse
        return TEXT_AUTHORIZATION_PENDING_PRICE;
        break;
        default:
        // proceed normally
        break;
      }

// show case only
    if (STORE_STATUS != '0') {
      if (STORE_STATUS == '1') {
        return '';
      }
    }

    // $new_fields = ', product_is_free, product_is_call, product_is_showroom_only';
    $product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call, products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");

    // no prices on Document General
//    if ($product_check->fields['products_type'] == 3) {
//      return '';
//    }

    $show_display_price = '';
    $display_normal_price = zen_get_products_base_price($products_id);
/*    $display_special_price = zen_get_products_special_price($products_id, true);
    $display_sale_price = zen_get_products_special_price($products_id, false);*/

    $show_sale_discount = '';
    if (SHOW_SALE_DISCOUNT_STATUS == '1' and ($display_special_price != 0 or $display_sale_price != 0)) {
      if ($display_sale_price) {
        if (SHOW_SALE_DISCOUNT == 1) {
          if ($display_normal_price != 0) {
            $show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS);
          } else {
            $show_discount_amount = '';
          }
          $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . $show_discount_amount . PRODUCT_PRICE_DISCOUNT_PERCENTAGE . '</span>';

        } else {
          $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT . '</span>';
        }
      } else {
        if (SHOW_SALE_DISCOUNT == 1) {
          $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . number_format(100 - (($display_special_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS) . PRODUCT_PRICE_DISCOUNT_PERCENTAGE . '</span>';
        } else {
          $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT . '</span>';
        }
      }
    }

    if ($display_special_price) {
      $show_normal_price = '<span class="normalprice">' . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' </span>';
      if ($display_sale_price && $display_sale_price != $display_special_price) {
        $show_special_price = '&nbsp;' . '<span class="productSpecialPriceSale">' . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
        if ($product_check->fields['product_is_free'] == '1') {
          $show_sale_price = '<br />' . '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . '<s>' . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</s>' . '</span>';
        } else {
          $show_sale_price = '<br />' . '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
        }
      } else {
        if ($product_check->fields['product_is_free'] == '1') {
          $show_special_price = '&nbsp;' . '<span class="productSpecialPrice">' . '<s>' . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</s>' . '</span>';
        } else {
          $show_special_price = '&nbsp;' . '<span class="productSpecialPrice">' . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
        }
        $show_sale_price = '';
      }
    } else {
      if ($display_sale_price) {
        $show_normal_price = '<span class="normalprice">' . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' </span>';
        $show_special_price = '';
        $show_sale_price = '<br />' . '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
      } else {
        if ($product_check->fields['product_is_free'] == '1') {
          $show_normal_price = '<s>' . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</s>';
        } else {
          $show_normal_price = $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id']));
        }
        $show_special_price = '';
        $show_sale_price = '';
      }
    }

    if ($display_normal_price == 0) {
      // don't show the $0.00
      $final_display_price = $show_special_price . $show_sale_price . $show_sale_discount;
    } else {
      $final_display_price = $show_normal_price . $show_special_price . $show_sale_price . $show_sale_discount;
    }

    // If Free, Show it
    if ($product_check->fields['product_is_free'] == '1') {
      if (OTHER_IMAGE_PRICE_IS_FREE_ON=='0') {
        $free_tag = '<br />' . PRODUCTS_PRICE_IS_FREE_TEXT;
      } else {
        $free_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_PRICE_IS_FREE, PRODUCTS_PRICE_IS_FREE_TEXT);
      }
    }

    // If Call for Price, Show it
    if ($product_check->fields['product_is_call']) {
      if (PRODUCTS_PRICE_IS_CALL_IMAGE_ON=='0') {
        $call_tag = '<br />' . PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT;
      } else {
        $call_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_CALL_FOR_PRICE, PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT);
      }
    }

    return $final_display_price . $free_tag . $call_tag;
  }

////
// Is the product free?
  function zen_get_products_price_is_free($products_id) {
    global $db;
    $product_check = $db->Execute("select product_is_free from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if ($product_check->fields['product_is_free'] == '1') {
      $the_free_price = true;
    } else {
      $the_free_price = false;
    }
    return $the_free_price;
  }

////
// Is the product call for price?
  function zen_get_products_price_is_call($products_id) {
    global $db;
    $product_check = $db->Execute("select product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if ($product_check->fields['product_is_call'] == '1') {
      $the_call_price = true;
    } else {
      $the_call_price = false;
    }
    return $the_call_price;
  }

////
// Is the product priced by attributes?
  function zen_get_products_price_is_priced_by_attributes($products_id) {
    global $db;
    $product_check = $db->Execute("select products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if ($product_check->fields['products_priced_by_attribute'] == '1') {
      $the_products_priced_by_attribute = true;
    } else {
      $the_products_priced_by_attribute = false;
    }
    return $the_products_priced_by_attribute;
  }

////
// Return a product's minimum quantity
// TABLES: products
  function zen_get_products_quantity_order_min($product_id) {
    global $db;

    $the_products_quantity_order_min = $db->Execute("select products_id, products_quantity_order_min from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_quantity_order_min->fields['products_quantity_order_min'];
  }


////
// Return a product's minimum unit order
// TABLES: products
  function zen_get_products_quantity_order_units($product_id) {
    global $db;

    $the_products_quantity_order_units = $db->Execute("select products_id, products_quantity_order_units from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_quantity_order_units->fields['products_quantity_order_units'];
  }

////
// Return a product's maximum quantity
// TABLES: products
  function zen_get_products_quantity_order_max($product_id) {
    global $db;

    $the_products_quantity_order_max = $db->Execute("select products_id, products_quantity_order_max from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_quantity_order_max->fields['products_quantity_order_max'];
  }

////
// Find quantity discount quantity mixed and not mixed
  function zen_get_products_quantity_discount_mixed($product_id, $qty) {
    global $db;
    global $cart;

    $product_discounts = $db->Execute("select products_price, products_quantity_mixed, product_is_free from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");

    if ($product_discounts->fields['products_quantity_mixed']) {
      if ($new_qty = $_SESSION['cart']->count_contents_qty($product_id)) {
        $qty = $new_qty;
      }
    }
    return $qty;
  }


////
// Return a product's quantity box status
// TABLES: products
  function zen_get_products_qty_box_status($product_id) {
    global $db;

    $the_products_qty_box_status = $db->Execute("select products_id, products_qty_box_status  from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_qty_box_status->fields['products_qty_box_status'];
  }

////
// Return a product mixed setting
// TABLES: products
  function zen_get_products_quantity_mixed($product_id) {
    global $db;

// don't check for mixed if not attributes
    $chk_attrib = zen_has_product_attributes((int)$product_id);
    if ($chk_attrib == true) {
      $the_products_quantity_mixed = $db->Execute("select products_id, products_quantity_mixed from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
      if ($the_products_quantity_mixed->fields['products_quantity_mixed'] == '1') {
        $look_up = true;
      } else {
        $look_up = false;
      }
    } else {
      $look_up = 'none';
    }

    return $look_up;
  }


////
// Return a products quantity minimum and units display
  function zen_get_products_quantity_min_units_display($product_id, $include_break = true, $shopping_cart_msg = false) {
    $check_min = zen_get_products_quantity_order_min($product_id);
    $check_units = zen_get_products_quantity_order_units($product_id);

    $the_min_units='';

    if ($check_min != 1 or $check_units != 1) {
      if ($check_min != 1) {
        $the_min_units .= PRODUCTS_QUANTITY_MIN_TEXT_LISTING . '&nbsp;' . $check_min;
      }
      if ($check_units != 1) {
        $the_min_units .= ($the_min_units ? ' ' : '' ) . PRODUCTS_QUANTITY_UNIT_TEXT_LISTING . '&nbsp;' . $check_units;
      }

// don't check for mixed if not attributes
      $chk_mix = zen_get_products_quantity_mixed((int)$product_id);
      if ($chk_mix != 'none') {
        if (($check_min > 0 or $check_units > 0)) {
          if ($include_break == true) {
            $the_min_units .= '<br />' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_OFF : TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART);
          } else {
            $the_min_units .= '&nbsp;&nbsp;' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_OFF : TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART);
          }
        } else {
          if ($include_break == true) {
            $the_min_units .= '<br />' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_ON : TEXT_PRODUCTS_MIX_ON_SHOPPING_CART);
          } else {
            $the_min_units .= '&nbsp;&nbsp;' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_ON : TEXT_PRODUCTS_MIX_ON_SHOPPING_CART);
          }
        }
      }
    }

    // quantity max
    $check_max = zen_get_products_quantity_order_max($product_id);

    if ($check_max != 0) {
      if ($include_break == true) {
        $the_min_units .= ($the_min_units != '' ? '<br />' : '') . PRODUCTS_QUANTITY_MAX_TEXT_LISTING . '&nbsp;' . $check_max;
      } else {
        $the_min_units .= ($the_min_units != '' ? '&nbsp;&nbsp;' : '') . PRODUCTS_QUANTITY_MAX_TEXT_LISTING . '&nbsp;' . $check_max;
      }
    }

    return $the_min_units;
  }


////
// Return quantity buy now
  function zen_get_buy_now_qty($product_id) {
    global $cart;
    $check_min = zen_get_products_quantity_order_min($product_id);
    $check_units = zen_get_products_quantity_order_units($product_id);
    $buy_now_qty=1;
// works on Mixed ON
    switch (true) {
      case ($_SESSION['cart']->in_cart_mixed($product_id) == 0 ):
        if ($check_min >= $check_units) {
          $buy_now_qty = $check_min;
        } else {
          $buy_now_qty = $check_units;
        }
        break;
      case ($_SESSION['cart']->in_cart_mixed($product_id) < $check_min):
        $buy_now_qty = $check_min - $_SESSION['cart']->in_cart_mixed($product_id);
        break;
      case ($_SESSION['cart']->in_cart_mixed($product_id) > $check_min):
      // set to units or difference in units to balance cart
        $new_units = $check_units - fmod_round($_SESSION['cart']->in_cart_mixed($product_id), $check_units);
//echo 'Cart: ' . $_SESSION['cart']->in_cart_mixed($product_id) . ' Min: ' . $check_min . ' Units: ' . $check_units . ' fmod: ' . fmod($_SESSION['cart']->in_cart_mixed($product_id), $check_units) . '<br />';
        $buy_now_qty = ($new_units > 0 ? $new_units : $check_units);
        break;
      default:
        $buy_now_qty = $check_units;
        break;
    }
    if ($buy_now_qty <= 0) {
      $buy_now_qty = 1;
    }
    return $buy_now_qty;
  }


// Specials and Tax Included
  function zen_get_products_actual_price($products_id) {
    global $db, $currencies;
    $product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");

    $show_display_price = '';
    $display_normal_price = zen_get_products_base_price($products_id);
/*    $display_special_price = zen_get_products_special_price($products_id, true);
    $display_sale_price = zen_get_products_special_price($products_id, false);*/

    $products_actual_price = $display_normal_price;

    if ($display_special_price) {
      $products_actual_price = $display_special_price;
    }
    if ($display_sale_price) {
      $products_actual_price = $display_sale_price;
    }

    // If Free, Show it
    if ($product_check->fields['product_is_free'] == '1') {
      $products_actual_price = 0;
    }

    return $products_actual_price;
  }

////
// return attributes_price_factor
  function zen_get_attributes_price_factor($price, $special, $factor, $offset) {
    if (ATTRIBUTES_PRICE_FACTOR_FROM_SPECIAL =='1' and $special) {
      // calculate from specials_new_products_price
      $calculated_price = $special * ($factor - $offset);
    } else {
      // calculate from products_price
      $calculated_price = $price * ($factor - $offset);
    }
//    return '$price ' . $price . ' $special ' . $special . ' $factor ' . $factor . ' $offset ' . $offset;
    return $calculated_price;
  }


////
// return attributes_qty_prices or attributes_qty_prices_onetime based on qty
  function zen_get_attributes_qty_prices_onetime($string, $qty) {
    $attribute_qty = preg_split("/[:,]/" , $string);
    $new_price = 0;
    $size = sizeof($attribute_qty);
// if an empty string is passed then $attributes_qty will consist of a 1 element array
    if ($size > 1) {
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        $new_price = $attribute_qty[$i+1];
        if ($qty <= $attribute_qty[$i]) {
          $new_price = $attribute_qty[$i+1];
          break;
        }
      }
    }
    return $new_price;
  }


////
// Check specific attributes_qty_prices or attributes_qty_prices_onetime for a given quantity price
  function zen_get_attributes_quantity_price($check_what, $check_for) {
// $check_what='1:3.00,5:2.50,10:2.25,20:2.00';
// $check_for=50;
      $attribute_table_cost = preg_split("/[:,]/" , $check_what);
      $size = sizeof($attribute_table_cost);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($check_for >= $attribute_table_cost[$i]) {
          $attribute_quantity_check = $attribute_table_cost[$i];
          $attribute_quantity_price = $attribute_table_cost[$i+1];
        }
      }
//          echo '<br>Cost ' . $check_for . ' - '  .  $attribute_quantity_check . ' x ' . $attribute_quantity_price;
     return $attribute_quantity_price;
  }


////
// attributes final price
  function zen_get_attributes_price_final($attribute, $qty = 1, $pre_selected, $include_onetime = 'false') {
    global $db;
    global $cart;

    $attributes_price_final = 0;

    if ($pre_selected == '' or $attribute != $pre_selected->fields["products_attributes_id"]) {
      $pre_selected = $db->Execute("select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_attributes_id= '" . (int)$attribute . "'");
    } else {
      // use existing select
    }

    // normal attributes price
    if ($pre_selected->fields["price_prefix"] == '-') {
      $attributes_price_final -= $pre_selected->fields["options_values_price"];
    } else {
      $attributes_price_final += $pre_selected->fields["options_values_price"];
    }
    // qty discounts
    $attributes_price_final += zen_get_attributes_qty_prices_onetime($pre_selected->fields["attributes_qty_prices"], $qty);

    // price factor
    $display_normal_price = zen_get_products_actual_price($pre_selected->fields["products_id"]);
    $display_special_price = zen_get_products_special_price($pre_selected->fields["products_id"]);

    $attributes_price_final += zen_get_attributes_price_factor($display_normal_price, $display_special_price, $pre_selected->fields["attributes_price_factor"], $pre_selected->fields["attributes_price_factor_offset"]);

    // per word and letter charges
    if (zen_get_attributes_type($attribute) == PRODUCTS_OPTIONS_TYPE_TEXT) {
      // calc per word or per letter
    }

// onetime charges
    if ($include_onetime == 'true') {
      $pre_selected_onetime = $pre_selected;
      $attributes_price_final += zen_get_attributes_price_final_onetime($pre_selected->fields["products_attributes_id"], 1, $pre_selected_onetime);
    }

    return $attributes_price_final;
  }


////
// attributes final price onetime
  function zen_get_attributes_price_final_onetime($attribute, $qty= 1, $pre_selected_onetime) {
    global $db;
    global $cart;

    if ($pre_selected_onetime == '' or $attribute != $pre_selected_onetime->fields["products_attributes_id"]) {
      $pre_selected_onetime = $db->Execute("select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_attributes_id= '" . (int)$attribute . "'");
    } else {
      // use existing select
    }

// one time charges
    // onetime charge
      $attributes_price_final_onetime += $pre_selected_onetime->fields["attributes_price_onetime"];

    // price factor
    $display_normal_price = zen_get_products_actual_price($pre_selected_onetime->fields["products_id"]);
    $display_special_price = zen_get_products_special_price($pre_selected_onetime->fields["products_id"]);

    // price factor one time
      $attributes_price_final_onetime += zen_get_attributes_price_factor($display_normal_price, $display_special_price, $pre_selected_onetime->fields["attributes_price_factor_onetime"], $pre_selected_onetime->fields["attributes_price_factor_onetime_offset"]);

    // onetime charge qty price
      $attributes_price_final_onetime += zen_get_attributes_qty_prices_onetime($pre_selected_onetime->fields["attributes_qty_prices_onetime"], 1);

      return $attributes_price_final_onetime;
    }


////
// get attributes type
  function zen_get_attributes_type($check_attribute) {
    global $db;
    $check_options_id_query = $db->Execute("select options_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id='" . (int)$check_attribute . "'");
    $check_type_query = $db->Execute("select products_options_type from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id='" . (int)$check_options_id_query->fields['options_id'] . "'");
    return $check_type_query->fields['products_options_type'];
  }


////
// calculate words
  function zen_get_word_count($string, $free=0) {
    $string = str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $string);

    if ($string != '') {
      while (strstr($string, '  ')) $string = str_replace('  ', ' ', $string);
      $string = trim($string);
      $word_count = substr_count($string, ' ');
      return (($word_count+1) - $free);
    } else {
      // nothing to count
      return 0;
    }
  }


////
// calculate words price
  function zen_get_word_count_price($string, $free=0, $price) {

    $word_count = zen_get_word_count($string, $free);
    if ($word_count >= 1) {
      return ($word_count * $price);
    } else {
      return 0;
    }
  }


////
// calculate letters
  function zen_get_letters_count($string, $free=0) {
    $string = str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $string);

    while (strstr($string, '  ')) $string = str_replace('  ', ' ', $string);
    $string = trim($string);
    if (TEXT_SPACES_FREE == '1') {
      $letters_count = strlen(str_replace(' ', '', $string));
    } else {
      $letters_count = strlen($string);
    }
    if ($letters_count - $free >= 1) {
      return ($letters_count - $free);
    } else {
      return 0;
    }
  }


////
// calculate letters price
  function zen_get_letters_count_price($string, $free=0, $price) {

    $letters_price = zen_get_letters_count($string, $free) * $price;
    if ($letters_price <= 0) {
      return 0;
    } else {
      return $letters_price;
    }
  }

  function zen_get_products_discount_price_of_qty($product_id, $check_qty){
    global $db, $cart;
  $products_query = $db->Execute("select products_price from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");

  $products_price=$products_query->fields['products_price'];
  $discount_price=get_products_final_price($products_price,$check_qty);
  return $discount_price;

}

////
// compute discount based on qty
/*
  function zen_get_products_discount_price_qty($product_id, $check_qty, $check_amount=0) {
    global $db, $cart;
      $new_qty = $_SESSION['cart']->in_cart_mixed_discount_quantity($product_id);
      // check for discount qty mix
      if ($new_qty > $check_qty) {
        $check_qty = $new_qty;
      }
      $product_id = (int)$product_id;
      $products_query = $db->Execute("select products_discount_type, products_discount_type_from, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");
      $products_discounts_query = $db->Execute("select * from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . (int)$product_id . "' and discount_qty <='" . (float)$check_qty . "' order by discount_qty desc");

      $display_price = zen_get_products_base_price($product_id);
      $display_specials_price = zen_get_products_special_price($product_id, true);

      switch ($products_query->fields['products_discount_type']) {
        // none
        case ($products_discounts_query->EOF):
          //no discount applies
          $discounted_price = zen_get_products_actual_price($product_id);
          break;
        case '0':
          $discounted_price = zen_get_products_actual_price($product_id);
          break;
        // percentage discount
        case '1':
          if ($products_query->fields['products_discount_type_from'] == '0') {
            // priced by attributes
            if ($check_amount != 0) {
              $discounted_price = $check_amount - ($check_amount * ($products_discounts_query->fields['discount_price']/100));
//echo 'ID#' . $product_id . ' Amount is: ' . $check_amount . ' discount: ' . $discounted_price . '<br />';
//echo 'I SEE 2 for ' . $products_query->fields['products_discount_type'] . ' - ' . $products_query->fields['products_discount_type_from'] . ' - '. $check_amount . ' new: ' . $discounted_price . ' qty: ' . $check_qty;
            } else {
              $discounted_price = $display_price - ($display_price * ($products_discounts_query->fields['discount_price']/100));
            }
          } else {
            if (!$display_specials_price) {
              // priced by attributes
              if ($check_amount != 0) {
                $discounted_price = $check_amount - ($check_amount * ($products_discounts_query->fields['discount_price']/100));
              } else {
                $discounted_price = $display_price - ($display_price * ($products_discounts_query->fields['discount_price']/100));
              }
            } else {
              $discounted_price = $display_specials_price - ($display_specials_price * ($products_discounts_query->fields['discount_price']/100));
            }
          }

          break;
        // actual price
        case '2':
          if ($products_query->fields['products_discount_type_from'] == '0') {
            $discounted_price = $products_discounts_query->fields['discount_price'];
          } else {
            $discounted_price = $products_discounts_query->fields['discount_price'];
          }
          break;
        // amount offprice
        case '3':
          if ($products_query->fields['products_discount_type_from'] == '0') {
            $discounted_price = $display_price - $products_discounts_query->fields['discount_price'];
          } else {
            if (!$display_specials_price) {
              $discounted_price = $display_price - $products_discounts_query->fields['discount_price'];
            } else {
              $discounted_price = $display_specials_price - $products_discounts_query->fields['discount_price'];
            }
          }
          break;
      }

      return get_round_product_discount_price($discounted_price,$check_qty,$product_id);
  }
  */


////
// set the products_price_sorter
  function zen_update_products_price_sorter($product_id) {
    global $db;

    $products_price_sorter = zen_get_products_actual_price($product_id);

    $db->Execute("update " . TABLE_PRODUCTS . " set
                  products_price_sorter='" . zen_db_prepare_input($products_price_sorter) . "'
                  where products_id='" . (int)$product_id . "'");
  }

////
// salemaker categories array
  function zen_parse_salemaker_categories($clist) {
    $clist_array = explode(',', $clist);

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($clist_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($clist_array[$i], $tmp_array)) {
        $tmp_array[] = $clist_array[$i];
      }
    }
    return $tmp_array;
  }

//根据产品ID和定制长度获取价格和中重量
function zen_get_products_custom_length_price($pid, $length)
{
    global $db;
    $priceArr = array();
    $length_price = $weight = $categories_id =0;
    $meter = 'm';
    $length_range_price = '';
    $length = str_replace("k", "", $length);
    $length = str_replace("m", "", $length);
    if ($length > 0) {
        $list = $db->getAll("select * from  products_count_length where products_id = '" . $pid . "' limit 1");
        $categories_data = get_product_category_key($pid);
        $key = $categories_data['key'];
        $categories_id = $categories_data['categories_id'] ? $categories_data['categories_id'] : 0;
        if ($list) {
            $retail = $list[0]['retail'];
        } else {
            $retail = 1;
        }
        if ($list) {
            $length_range_price = $list[0]['length_range_price'];
            if ($length > 1) {
                switch ($key) {
                    case 0:
                    case 2:
//                    $length_price = ($length - 1) * $list[0]['unit_price'];
//                    $weight = ($length - 1) * $list[0]['unit_weight'];
                        $length_price = ($length - 1) * $list[0]['unit_price'];
                        $weight = ($length - 1) * $list[0]['unit_weight'];
                        break;
                    case 1:
                        if ($retail == 1) {
                            $length_price = ($length - 1) * $list[0]['unit_price'];
                            $weight = ($length - 1) * $list[0]['unit_weight'];
                        } else {
                            $meter = 'km';
                            $length_price = ($length * 1000 - 1) * $list[0]['unit_price'];
                            $weight = ($length * 1000 - 1) * $list[0]['unit_weight'];
                        }
                        break;
                    case 4:
                        $custom_length = $length - 10 > 0 ? $length - 10 : 0;
                        $length_price = ($custom_length) * $list[0]['unit_price'];
                        $weight = ($custom_length) * $list[0]['unit_weight'];
                        break;
                    case 5:
                        $custom_length = $length - 100 > 0 ? $length - 100 : 0;
                        $length_price = ($custom_length) * $list[0]['unit_price'];
                        $weight = ($custom_length) * $list[0]['unit_weight'];
                        break;
                    case 7:
                        $custom_length = $length - 3 > 0 ? $length - 3 : 0;
                        $length_price = ($custom_length) * $list[0]['unit_price'];
                        if ($custom_length < 100) {
                            $weight = ($custom_length) * $list[0]['unit_weight'];
                        } else {
                            $weight = ($custom_length) * $list[0]['unit_weight'];
                        }
                        break;
                    default:
                        $length_price = ($length - 1) * $list[0]['unit_price'];
                        $weight = ($length - 1) * $list[0]['unit_weight'];
                        break;
                }
            } else {
                if ($key == 1 && $retail == 0) {
                    $meter = 'km';
                    $length_price = ($length * 1000 - 1) * $list[0]['unit_price'];
                    $weight = ($length * 1000 - 1) * $list[0]['unit_weight'];
                } else {
                    $length_price = 0;
                    $weight = 0;
                }
            }
            //通过产品ID过去他的所有分类ID
            if ($key == 1 && $retail == 0) {
                $other_length = $length * 1000;
                if ($other_length >= 100) {
                    $weight += 22.68;
                }
            } elseif (in_array($key, [1, 2])) {
                if ($length >= 100) {
                    $weight += 22.68;
                }
            }
        }
        $length_price = round($length_price, 2);
        $weight = round($weight, 3);
        if ($key == 1 && $retail == 0) {
            $length = round($length, 3);
        } else {
            $length = round($length, 2);
        }
	}
    $priceArr['length_price'] = $length_price;
    $priceArr['weight'] = $weight;
    $priceArr['length'] = $length . $meter;
    $priceArr['categories_id'] = $categories_id;
    $priceArr['length_range_price'] = $length_range_price;

    return $priceArr;
}

/*
 * 返回转成对应币种价格取整后又转成美元的价格
 * Ery add
 * 加一个属性值数组 用于查询组合产品有属性的产品价格
 * $is_au_tax 澳洲是否含税
 */
function zen_get_products_final_price($products_id, $currency='',&$options_value = array(), $is_au_tax = true){
    // fairy 2019.2.21 add 组合产品主产品价格
    //是否计算企业折扣价  默认为false;
    $discount_type = false;
    if (class_exists('classes\CompositeProducts')) {
        //处理属性
        $attr_str = '';
        if($options_value){
            unset($options_value['is_composite']);
            if($options_value['discount_type']){
                $discount_type = true;
            }
            unset($options_value['discount_type']);
            $attr_str = reorder_options_values($options_value);
        }
        $CompositeProducts = new classes\CompositeProducts(intval($products_id),'',$attr_str);
        $composite_product_price = $CompositeProducts->get_composite_product_price('',$currency);
        if(!empty($composite_product_price['composite_product_price'])){
            $options_value['is_composite'] = true;
            return $composite_product_price['composite_product_price'];
        }
    }
	global $db,$currencies;
	$products_id = (int)$products_id;
	if($products_id){
		$currency = $currency ? $currency : $_SESSION['currency'];
		$currency_value = $currencies->currencies[$currency]['value'];
        $integer_state = fs_get_data_from_db_fields('integer_state', 'products', 'products_id='.$products_id, 'limit 1');
        $products_price = zen_get_products_base_price((int)$products_id);

		if ($integer_state == 0) {
			//产品价格取整操作，products表中的products_price值是以美元为单位，当前货币要不是美元取整前先要转成对应币种的价格后在进行取整操作
			$products_price = get_products_all_currency_final_price($products_price*$currency_value);
		} else {
			//产品价格不取整
			$products_price = get_products_specail_currency_final_price($products_price*$currency_value);
		}
		//返回的仍然是美元为单位的价格
		$products_price = $products_price/$currency_value;
	}
    // 澳大利亚税后价在是否取整之后*1.1
    if (AU_use_gsp_tax($products_id) && $is_au_tax){
        $products_price = get_gsp_tax_price('AU',$products_price);
    }
	return $products_price;
}

/**
 * @param $products_id 产品id
 * @param int $products_price 产品原价
 * @param int $integer_state 是否取整
 * @param string $country_code 国家code
 * @param string $currency 当前货币
 * @param array $options_value 组合产品属性
 * @return float|int
 */
function zen_get_new_products_final_price($products_id,$products_price=0,$integer_state=0,$country_code='',$currency='',&$options_value = array()){
    if(!$products_id){
        return 0;
    }
    $products_id = (int)$products_id;
    $currency = $currency ? $currency : $_SESSION['currency'];
    $country_code = $country_code ? $country_code : $_SESSION['countries_iso_code'];
    if($products_price){
        global $currencies;
        // fairy 2019.2.21 add 组合产品主产品价格
        //是否计算企业折扣价  默认为false;
        $discount_type = false;
        if (class_exists('classes\CompositeProducts')) {
            //处理属性
            $attr_str = '';
            if($options_value){
                unset($options_value['is_composite']);
                if($options_value['discount_type']){
                    $discount_type = true;
                }
                unset($options_value['discount_type']);
                $attr_str = reorder_options_values($options_value);
            }
            $CompositeProducts = new classes\CompositeProducts(intval($products_id),'',$attr_str);
            $composite_product_price = $CompositeProducts->get_composite_product_price($discount_type);
            if(!empty($composite_product_price['composite_product_price'])){
                $options_value['is_composite'] = true;
                return $composite_product_price['composite_product_price'];
            }
        }
        $currency_value = $currencies->currencies[$currency]['value'];
        if ($integer_state == 0) {
            //产品价格取整操作，products表中的products_price值是以美元为单位，当前货币要不是美元取整前先要转成对应币种的价格后在进行取整操作
            $products_price = get_products_all_currency_final_price($products_price*$currency_value);
        } else {
            //产品价格不取整
            $products_price = get_products_specail_currency_final_price($products_price*$currency_value);
        }
        $products_price = $products_price/$currency_value;
        // 澳大利亚税后价在是否取整之后*1.1
        $products_price = get_gsp_tax_price($country_code,$products_price);
    }else{
        $products_price = zen_get_products_final_price($products_id,$currency,$options_value);
    }
    return $products_price;
}

function getCustomPrice($related_label_pid,$attributes_value,$price_prefix ){
    $price = '';
    $price = zen_get_products_final_price((int)$related_label_pid);
    if($attributes_value >0){
        if ($price_prefix== '+') {
            $price += $attributes_value;
        } else {
            $price -= $attributes_value;
        }
    }
    return $price;
}

/**
 * 根据客户选择的长度和属性 获取线轴加价
 * @param $product_id
 * @param $length
 * @param $categories_id
 * @param int $fiberValue //客户选择的芯数
 * @return array
 */
function get_spool_price_by_length($product_id,$length,$categories_id,$fiberValue=0){
    $final_spool_price =  $spool_price = 0;
    $product_id = (int)$product_id;
    $is_show_spool =  0;
    $categories_data = ['1125','2866','3253','3081','2958','1148','3856','1155'];
    $spool_price_data = [];
    if($length && in_array($categories_id,$categories_data)) {
        global $db;
        $spool_price_data = $db->getAll('select popt.price_type,patrib.price_prefix,patrib.options_values_price,popt.products_options_id,patrib.attributes_status from '.TABLE_PRODUCTS_OPTIONS.' popt
                                  left join '.TABLE_PRODUCTS_ATTRIBUTES.' patrib 
                                  on popt.products_options_id = patrib.options_id 
                                  where patrib.products_id = '. (int)$product_id.'
                                  and popt.products_options_id = 341
                                  and popt.products_options_status =1 
                                  and popt.language_id = '.$_SESSION['languages_id'].'
                                  limit 1
                                  ');
        if (!empty($spool_price_data)) {
            $spool_price_data = $spool_price_data[0];
            $attributes_status = $spool_price_data['attributes_status'] ? (int)$spool_price_data['attributes_status'] : 0;
            $option_value_price = $spool_price_data['options_values_price'];
            if ($spool_price_data['price_prefix'] == '+') { //线轴属性 目前只有加价
                $spool_price = $option_value_price;
            }
            if ($categories_id == 1125) {
                //1125特殊分类 根据客户选择的芯数判断
                if ($fiberValue) {
                    if (in_array($product_id, [80734, 80735, 80736, 30962, 30977, 30976, 31097, 31098, 31099, 30850, 30843, 30842, 31102, 31136, 31135, 61724, 62979, 61710, 61713, 64212, 61712])) {
                        if (in_array($fiberValue, [3381, 7564]) && $length >= 100) {  //8/12芯
                            $final_spool_price = $spool_price ? $spool_price : 10;
                            if($final_spool_price && $attributes_status ==1){
                                $is_show_spool = 1;
                            }
                            return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                        }
                        if (in_array($fiberValue, [7544, 7545]) && $length >= 60) {//24/36芯
                            $final_spool_price = $spool_price ? $spool_price : 10;
                            if($final_spool_price && $attributes_status ==1){
                                $is_show_spool = 1;
                            }
                            return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                        }
                        if (in_array($fiberValue, [7546, 7547, 7548, 7549]) && $length >= 30) { //48芯及以上
                            $final_spool_price = $spool_price ? $spool_price : 10;
                            if($final_spool_price && $attributes_status ==1){
                                $is_show_spool = 1;
                            }
                            return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                        }

                    } elseif (in_array($product_id, [31014, 31015, 31012, 25884, 31065, 31066, 30931, 30930, 30929, 31191, 31184, 31167, 61719, 61721, 61717])) {
                        if (in_array($fiberValue, [7567]) && $length >= 100) {  //24芯
                            $final_spool_price = $spool_price ? $spool_price : 10;
                            if($final_spool_price && $attributes_status ==1){
                                $is_show_spool = 1;
                            }
                            return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                        }
                        if (in_array($fiberValue, [7558, 7559]) && $length >= 60) { //48/72芯
                            $final_spool_price = $spool_price ? $spool_price : 10;
                            if($final_spool_price && $attributes_status ==1){
                                $is_show_spool = 1;
                            }
                            return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                        }
                        if (in_array($fiberValue, [7560, 7561]) && $length >= 30) { //96芯及以上
                            $final_spool_price = $spool_price ? $spool_price : 10;
                            if($final_spool_price && $attributes_status ==1){
                                $is_show_spool = 1;
                            }
                            return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                        }
                    }
                }else{
                    if($length >=100 &&  $attributes_status !=1){ //定制长度属性产品 不展示线轴属性  只加价
                        $final_spool_price = $spool_price ? $spool_price : 0;
                        return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>0];
                    }
                }
            } else {  //其他分类 根据长度判断
                if (in_array($categories_id, [2866, 3253, 3081, 2958]) && $length >= 100) {
                    $final_spool_price = $spool_price ? $spool_price : 10;
                    if($final_spool_price && $attributes_status ==1){
                        $is_show_spool = 1;
                    }
                    return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                }
                if (in_array($categories_id, [1148, 3856]) && $length >= 100) {
                    $final_spool_price = $spool_price ? $spool_price : 15;
                    if($final_spool_price && $attributes_status ==1){
                        $is_show_spool = 1;
                    }
                    return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                }
                if ($categories_id == 1155) {
                    $products_narrow_by_options_values =[];
                    //1155 分类根据产品所属筛选项再次判断
                    $products_narrow_by_options_values_id_data = $db->getAll("select nvtp.products_narrow_by_options_values_id 
                    from ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as nvtp  
                    where nvtp.products_id =  ".$product_id);
                    if(!empty($products_narrow_by_options_values_id_data)){
                        foreach ($products_narrow_by_options_values_id_data as $value) {
                            $products_narrow_by_options_values[] = $value['products_narrow_by_options_values_id'];
                        }
                        if(in_array(21952,$products_narrow_by_options_values)){
                            if($length >= 100){
                                $final_spool_price = $spool_price ? $spool_price : 15;
                                if($final_spool_price && $attributes_status ==1){
                                    $is_show_spool = 1;
                                }
                                return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                            }
                        }
                        if(in_array(21954,$products_narrow_by_options_values)){
                            if ($length >= 100 && $length <= 400) {
                                $final_spool_price = $spool_price ? $spool_price : 30;
                                if($final_spool_price && $attributes_status ==1){
                                    $is_show_spool = 1;
                                }
                                return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                            } elseif ($length > 400) {
                                $final_spool_price = $spool_price ? $spool_price : 65;
                                if($final_spool_price && $attributes_status ==1){
                                    $is_show_spool = 1;
                                }
                                return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
                            }
                        }
                    }
                }
            }
        }
    }
    return ['final_spool_price'=>$final_spool_price,'is_show_spool'=>$is_show_spool];
}

/**
 * 获取长度区间价格
 * @param $product_id
 * @param $length
 * @param int $fiberValue //客户选择的芯数 通过芯数和米数计算线轴加价
 * @return array
 */
function get_length_range_price($product_id,$length,$fiberValue = 0){
    $price = $spool_price = 0;
    $is_show_spool = 0;
    $priceArr = zen_get_products_custom_length_price($product_id, $length);
    $categories_id = $priceArr['categories_id'];

    if(stripos($length,'m')){
        $length_s = substr(trim($length),0,-1);
    }elseif (stripos($length,'km')){
        $length_s = substr(trim($length),0,-2);
        $length_s = $length_s  * 1000;
    }else{
        $length_s = $length;
    }
    if($length_s){ //线轴加价都是超过一定米数之后才有价格
        $spool_price_data = get_spool_price_by_length($product_id,$length_s,$categories_id,$fiberValue);
        $spool_price = $spool_price_data['final_spool_price'];//获取线轴加价
        $is_show_spool = $spool_price_data['is_show_spool'];//是否在页面展示packing 属性
    }
    $length_range_price = $priceArr['length_range_price'] ? $priceArr['length_range_price'] : '';
    if ($length_range_price && $length_s) {
        $length_price_data = explode(',', $length_range_price);
        $price_data = $length_data = array();
        foreach ($length_price_data as $d => $data) {
            $length_data[] = explode(':', $data)[0];
            $price_data[] = explode(':', $data)[1];
        }
        foreach ($length_data as $l => $len) {
            $new_length_data[] = explode('-', $len);
        }
        $final_length_data = array();
        foreach ($new_length_data as $n => $new) {
            $final_length_data[] = array(
                'min_length' => $new[0],
                'max_length' => isset($new[1]) ? $new[1] : 0,
                'unit_price' => $price_data[$n],
            );
        }
        foreach ($final_length_data as $key => $val) {
            if ($length_s > $val['max_length']) {
                //如果当前区间的最小值大于最大值 那就说明当前区间没有最大值
                if ($val['min_length'] > $val['max_length']) {
                    $price += ($length_s - $val['min_length']) * $val['unit_price'];
                    break;
                } else {
                    $price += ($val['max_length'] - $val['min_length']) * $val['unit_price'];
                }
            } else {
                if ($length_s > $val['min_length']) {
                    $price += ($length_s - $val['min_length']) * $val['unit_price'];
                }
                break;
            }
        }
        $priceArr['length_price'] = $price + $spool_price;
    }else{
        $priceArr['length_price'] += $spool_price;
    }
    $priceArr['is_show_spool'] = $is_show_spool;
    return $priceArr;
}

/*
 * 获取对应站点的税后价
 * @param float $totalPrice 当前币种产品总价
 * @param string $totalPriceText  当前币种产品带货币符总价
 * @param int $productId 用于计算日语站币种为USD时 JPY的产品价格(计算标准产品)
 * @param float $jpTotalPrice(加上属性的JPY价格)
 * @param string $type  区分是否是询价
 * */
function getAfterVatPrice($totalPrice,$totalPriceText,$productId =0,$jpTotalPrice='',$type=''){
    global $currencies;
    $vat = 1;
    $inclVat = $enclVat = $taxPrice = '';
    $priceData = [];
    if(get_price_vat_uk_show()){ //uk站展示 20% 增值税
        if(all_german_warehouse('country_code',$_SESSION['countries_iso_code'])){
            $vat = 1.20;
        }
        $inclVat = ' (Incl. VAT)';
        $enclVat = ' (Excl. VAT)';
    }
    if($_SESSION['languages_code']=='au' && strtolower($_SESSION['countries_iso_code']) !='nz'){//au站当前国家不是新西兰时展示10%税收价格
        $vat = 1.1;
        $enclVat = ' (Incl. GST)'; //澳大利亚直接展示税后价
    }
    if(in_array($_SESSION['languages_code'],['de','dn', 'it'])){////de站欧盟国家展示19%税收价格
        if(german_warehouse("country_code",$_SESSION['countries_iso_code']) && (strtoupper($_SESSION['countries_iso_code']) != "VA") && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))
        ) {//欧盟国家才展示是否含税信息
            $vat = getVaxByCountry($_SESSION['countries_iso_code']);
            $inclVat = FS_PRICE_INCL_VAT;
            $enclVat = FS_PRICE_EXCL_VAT;
        }
    }
    if(strtolower($_SESSION['countries_iso_code'])=='sg'){ //sg站覆盖国家展示7%税收价格
        $vat = 1.07;
        $inclVat = ' (Incl. GST)';
        $enclVat = ' (Excl. GST)';
    }
    if(strtolower($_SESSION['countries_iso_code'])=='ru'){ ////俄罗斯国家20%增值税
        $vat = 1.2;
        $inclVat = FS_INCLUDED_VAT;
        $enclVat = FS_EXCLUDED_VAT;
    }
    if($_SESSION['languages_code'] == 'jp'){
        $jpyPrice = '';
        if($_SESSION['currency']!='JPY'){
            //jp站货币是美元是需要展示出日元价格
            if(!$jpTotalPrice && $productId){
                $jpTotalPrice = zen_get_products_final_price((int)$productId,'JPY');
            }
            $jpyPrice ='<em>/'.'JPY&nbsp;'.$currencies->total_format($jpTotalPrice, true,"JPY",'').'</em>';
            $totalPriceText .= $jpyPrice;
        }
    }

    //liang.zhu 2020.11.03同步 法语站德国仓国家展示含税价和不含税价
    if ($_SESSION['languages_code'] == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))) {
        if (in_array(strtolower($_SESSION['countries_iso_code']), ['fr', 'be', 'mc', 'lu'])) {
            $totalPriceText = $totalPriceText.' HT';
        }
        $current_vat = get_current_vat_by_languages_code();
        $taxPriceText = $currencies->total_format($totalPrice * (1 + $current_vat[2]));
        $taxPrice = '<p class="detail_proPrice2">'.$taxPriceText.' TTC</p>';
    }


    if($vat !=1 && $totalPrice){
        if (strtolower($_SESSION['countries_iso_code']) != 'au') { //AU站的税后价 在zen_get_products_final_price中已获取 直接展示税后价
            $taxPriceText = $currencies->total_format($totalPrice *$vat);
            $taxPrice = '<p class="detail_proPrice2">'.$taxPriceText.$inclVat.' </p>';
        }
        if($type !='quote'){
            $totalPriceText .= $enclVat;
        }
    }
    $priceData = array(
        'totalPrice' => $totalPriceText,
        'taxPrice' => $taxPrice
    );
    return $priceData;
    }

/**
 * 是否展示税后价
 * @param $products_id 产品id
 * @param int $products_price 产品原价
 * @param string $country_code 国家code
 * @param string $is_heavy 是否为重货
 * @param string $heavyQty 重货本地仓是否有库存
 * @return int
 */
function getIsTaxAfterPrice($products_id, $products_price=0, $country_code='', $is_heavy='', $au_qty=0){
    if(!$products_price || !$products_id){
        return 0;
    }
    $country_code = $country_code ? $country_code : $_SESSION['countries_iso_code'];

    if(strtolower($country_code) == 'au'){
        if(empty($is_heavy)){
            $is_heavy = fs_get_data_from_db_fields('is_heavy',TABLE_PRODUCTS,'products_id='.(int)$products_id,'limit 1');
        }
        if($is_heavy && in_array($is_heavy,[1,2])){
            if(empty($au_qty)){
                $au_qty = zen_get_current_qty((int)$products_id,"AU",false);
            }
            if($au_qty>1){
                $products_price = get_gsp_tax_price($country_code,$products_price);
            }
        }else{
            $products_price = get_gsp_tax_price($country_code,$products_price);
        }
    }
    return $products_price;
}

