<?php


if (!defined('IS_ADMIN_FLAG')) {

    die('Illegal Access');

}
if (file_exists(DIR_FS_CATALOG . 'includes/classes/FSCodeRelatedProducts.php')) {
    require_once(DIR_FS_CATALOG . 'includes/classes/FSCodeRelatedProducts.php');
}
require_once(DIR_FS_CATALOG . 'includes/classes/SGInstallerServiceClass.php');
require_once(DIR_FS_CATALOG .'includes/classes/warehouseClass.php');
class order extends base
{

    var $info, $totals, $products, $customer, $delivery, $content_type, $email_low_stock, $products_ordered_attributes, $sendTo, $billTo,

        $products_ordered, $products_ordered_email, $attachArray, $is_reissue, $local_warehouse, $global_warehouse, $warehouse, $currencies_value,
        $delay_cart_products, $local_cart_products, $global_cart_products, $shipping_warehouse, $is_buck,
        $is_buck_in_products, $heavy_products, $local_shipping_cost, $delay_shipping_cost, $global_shipping_cost,
        $heavy_products_tag, $is_local_buck, $cart_products, $is_remote_post_code, $local_cabinet, $special_heavy,
        $spec_heavy_arr, $local_heavy_products, $is_heavy_free, $vax, $insertData, $insurance, $is_de_remote,
        $is_lithium_battery_order, $shoppingCartProducts, $orderVat, $is_send_trustpilot, $is_local_oversize,
        $is_delay_oversize, $is_local_overweight, $is_delay_overweight, $is_ireland_zones, $is_ireland_billings_zones,
        $cn_limit_products;


    /**
     * order constructor.
     * @param string $order_id 订单id
     * @param array $cart_products 购物车产品
     * @param int $sendTo //发货地址
     * @param int $billTo //账单地址
     */
    function order($order_id = '', $cart_products = [], $sendTo = 0, $billTo = 0)
    {

        $this->delivery_id = "";
        $this->info = array();

        $this->totals = array();

        $this->products = array();
        $this->shoppingCartProducts = [];
        $this->customer = array();

        $this->delivery = array();

        $this->global_products = array();

        $this->local_products = array();
        $this->gift_products = [];
        $this->delay_products = array();
        $this->delay_cart_products = array();
        $this->local_cart_products = array();
        $this->global_cart_products = array();
        $this->gift_cart_products = [];
        $this->delay_info = array();

        $this->global_info = array();

        $this->local_info = array();
        $this->vax = 0;
        $this->gift_info = [];
        $this->is_reissue = 0;
        $this->local_warehouse = 0;
        $this->global_warehouse = 0;
        $this->warehouse = 0;
        $this->is_vax = false;
        $this->is_vax_de = false;
        $this->is_vax_us = false;
        $this->is_vax_cn = false;
        $this->is_vax_au = false;
        $this->is_vax_sg = false;
        $this->insurance = 0;
        $this->vat = 0;
        $this->all_delay_no_vat = false;
        $this->one_delay_no_vat = false;
        $this->vat_by_post_code = 0;
        $this->vax_de = FS_DE_VAX;
        $this->vax_cn = FS_CN_VAX;
        $this->is_buck = false;
        $this->is_local_buck = false;
        $this->heavy_products = array();
        $this->heavy_products_tag = [];
        $this->special_heavy = false;
        $this->spec_heavy_arr = [18543, 18544, 58708, 58727, 69075, 71024];
        $this->is_heavy_free = [];
        $this->is_remote_post_code = false;
        $this->is_de_remote = false;
        $this->cart_products = $cart_products;
        $this->local_cabinet = array();
        $this->local_heavy_products = array();
        $this->is_lithium_battery_order = array();
        $this->is_send_trustpilot = false;
        $this->is_local_oversize = false;
        $this->is_delay_oversize = false;
        $this->is_delay_overweight = false;
        $this->is_local_overweight = false;
        $this->is_ireland_zones = false;
        $this->is_ireland_billings_zones = false;
        $this->cn_limit_products = [];
        if (!empty($sendTo)) {
            $this->sendTo = $sendTo;
        }
        if (!empty($billTo)) {
            $this->billTo = $billTo;
        }
        if (zen_not_null($order_id)) {

            $this->query($order_id);

        } else {

            $this->cart();

        }

    }


    function query($order_id)
    {

        global $db;


        $order_id = zen_db_prepare_input($order_id);

        $wholesale_products = fs_get_wholesale_products_array();

        $order_query = "select customers_id, customers_name,customers_lastname, customers_company,

                         customers_street_address, customers_suburb, customers_city,

                         customers_postcode, customers_state, customers_country,

                         customers_telephone, customers_email_address, customers_address_format_id,

                         delivery_name, delivery_lastname,delivery_company, delivery_street_address, delivery_suburb,

                         delivery_city, delivery_postcode, delivery_state, delivery_country,delivery_country_id,delivery_telephone,delivery_tax_number,delivery_company_type,

                         delivery_address_format_id, billing_name,billing_lastname, billing_company,

                         billing_street_address, billing_suburb, billing_city, billing_postcode,billing_tax_number,billing_company_type,

                         billing_state, billing_country,billing_telephone, billing_address_format_id,

                         payment_method, payment_module_code, shipping_method, shipping_module_code,

                         coupon_code, cc_type, cc_owner, cc_number, cc_expires, currency, currency_value,

                         date_purchased, orders_status, last_modified, order_total, order_tax, ip_address,orders_number,c_tel_prefix,d_tel_prefix,b_tel_prefix

                        from " . TABLE_ORDERS . "

                        where orders_id = '" . (int)$order_id . "'";


        $order = $db->Execute($order_query);


        $totals_query = "select title, text, class, value

                         from " . TABLE_ORDERS_TOTAL . "

                         where orders_id = '" . (int)$order_id . "'

                         order by sort_order";


        $totals = $db->Execute($totals_query);


        while (!$totals->EOF) {


            if ($totals->fields['class'] == 'ot_coupon') {

                $coupon_link_query = "SELECT coupon_id

                from " . TABLE_COUPONS . "

                where coupon_code ='" . $order->fields['coupon_code'] . "'";

                $coupon_link = $db->Execute($coupon_link_query);

                $zc_coupon_link = '<a href="javascript:couponpopupWindow(\'' . zen_href_link(FILENAME_POPUP_COUPON_HELP, 'cID=' . $coupon_link->fields['coupon_id']) . '\')">';

            }

            $this->totals[$totals->fields['class']] = array('title' => ($totals->fields['class'] == 'ot_coupon' ? $zc_coupon_link . $totals->fields['title'] . '</a>' : $totals->fields['title']),

                'text' => $totals->fields['text'],

                'value' => $totals->fields['value'],

                'class' => $totals->fields['class']);

            $totals->MoveNext();

        }


        $order_total_query = "select text, value

                             from " . TABLE_ORDERS_TOTAL . "

                             where orders_id = '" . (int)$order_id . "'

                             and class = 'ot_total'";


        $order_total = $db->Execute($order_total_query);


        $order_subtotal_query = "select text, value

                             from " . TABLE_ORDERS_TOTAL . "

                             where orders_id = '" . (int)$order_id . "'

                             and class = 'ot_subtotal'";


        $order_subtotal = $db->Execute($order_subtotal_query);


        $shipping_method_query = "select title, text, value

                                from " . TABLE_ORDERS_TOTAL . "

                                where orders_id = '" . (int)$order_id . "'

                                and class = 'ot_shipping'";


        $shipping_method = $db->Execute($shipping_method_query);

        $order_vat_query = "select text, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_tax'";
        $vat_total = $db->Execute($order_vat_query);

        $order_status_query = "select orders_status_name

                             from " . TABLE_ORDERS_STATUS . "

                             where orders_status_id = '" . $order->fields['orders_status'] . "'

                             and language_id = '" . (int)$_SESSION['languages_id'] . "'";


        $order_status = $db->Execute($order_status_query);


        $this->info = array('currency' => $order->fields['currency'],

            'currency_value' => $order->fields['currency_value'],

            'payment_method' => $order->fields['payment_method'],

            'payment_module_code' => $order->fields['payment_module_code'],

            'shipping_method' => $order->fields['shipping_method'],

            'shipping_module_code' => $order->fields['shipping_module_code'],

            'shipping_us_method' => $order->fields['shipping_us_method'],


            'shipping_us_module_code' => $order->fields['shipping_us_module_code'],

            'coupon_code' => $order->fields['coupon_code'],

            'cc_type' => $order->fields['cc_type'],

            'cc_owner' => $order->fields['cc_owner'],

            'cc_number' => $order->fields['cc_number'],

            'cc_expires' => $order->fields['cc_expires'],

            'date_purchased' => $order->fields['date_purchased'],

            'orders_status' => $order_status->fields['orders_status_name'],

            'orders_status_id' => $order->fields['orders_status'],

            'last_modified' => $order->fields['last_modified'],

            'total' => $order->fields['order_total'],

            'vat_value' => $vat_total->fields['value'],

            'tax' => $order->fields['order_tax'],

            'ip_address' => $order->fields['ip_address'],

            'orders_number' => $order->fields['orders_number'],

            'shipping_cost' => $shipping_method->fields['value'],

            'tel_prefix' => $order->fields['c_tel_prefix'],

            'subtotal_text' => $order_subtotal->fields['text'],

            'shipping_text' => $shipping_method->fields['text'],

            'total_text' => $order_total->fields['text'],

            'vat_text' => $vat_total->fields['text'],

            'items' => 0,

            'orders_id' => $order_id,

            'delivery_country_id' => $order->fields['delivery_country_id'],

            'tax_groups' => array(),

        );


        $this->customer = array('id' => $order->fields['customers_id'],

            'name' => $order->fields['customers_name'],

            'lastname' => $order->fields['customers_lastname'],

            'company' => $order->fields['customers_company'],

            'street_address' => $order->fields['customers_street_address'],

            'suburb' => $order->fields['customers_suburb'],

            'city' => $order->fields['customers_city'],

            'postcode' => $order->fields['customers_postcode'],

            'state' => $order->fields['customers_state'],

            'country' => $order->fields['customers_country'],

            'countries_iso_code_2' => get_countries_code($order->fields['customers_country']),

            'format_id' => $order->fields['customers_address_format_id'],

            'telephone' => $order->fields['customers_telephone'],

            'tel_prefix' => $order->fields['c_tel_prefix'],

            'email_address' => $order->fields['customers_email_address']);


        $this->delivery = array('name' => $order->fields['delivery_name'],

            'lastname' => $order->fields['delivery_lastname'],

            'company' => $order->fields['delivery_company'],

            'street_address' => $order->fields['delivery_street_address'],

            'suburb' => $order->fields['delivery_suburb'],

            'city' => $order->fields['delivery_city'],

            'postcode' => $order->fields['delivery_postcode'],

            'state' => $order->fields['delivery_state'],

            'country' => $order->fields['delivery_country'],

            'countries_iso_code_2' => get_countries_code($order->fields['delivery_country']),

            'tax_number' => $order->fields['delivery_tax_number'],

            'telephone' => $order->fields['delivery_telephone'],

            'tel_prefix' => $order->fields['d_tel_prefix'],

            'company_type' => $order->fields['delivery_company_type'],

            'format_id' => $order->fields['delivery_address_format_id']);


        if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {

            $this->delivery = false;

        }

        $this->billing = array('name' => $order->fields['billing_name'],

            'lastname' => $order->fields['billing_lastname'],

            'company' => $order->fields['billing_company'],

            'street_address' => $order->fields['billing_street_address'],

            'suburb' => $order->fields['billing_suburb'],

            'city' => $order->fields['billing_city'],

            'postcode' => $order->fields['billing_postcode'],

            'state' => $order->fields['billing_state'],

            'country' => $order->fields['billing_country'],

            'countries_iso_code_2' => get_countries_code($order->fields['billing_country']),

            'tax_number' => $order->fields['billing_tax_number'],

            'telephone' => $order->fields['billing_telephone'],

            'tel_prefix' => $order->fields['b_tel_prefix'],

            'company_type' => $order->fields['billing_company_type'],

            'format_id' => $order->fields['billing_address_format_id']);


        $index = 0;


        if (fs_orders_products_is_main($order_id)) {
            $order_list = $db->getAll("select orders_id from orders where main_order_id = '" . $order_id . "'");
            if ($order_list) {
                $order_str = "";
                foreach ($order_list as $v) {
                    $order_str .= $v['orders_id'] . ",";
                }
                $order_str = substr($order_str, 0, -1);
            }
        }

        if ($order_str) {

            $where = " where orders_id  in (" . $order_str . ")";

        } else {
            $where = " where orders_id = '" . (int)$order_id . "'";
        }

        $orders_products_query = "select orders_products_id, products_id, products_name,

                                 products_model, products_price, products_tax,

                                 products_quantity, final_price,

                                 onetime_charges,

                                 products_priced_by_attribute, product_is_free, products_discount_type,

                                 products_discount_type_from,reorder_type

                                  from " . TABLE_ORDERS_PRODUCTS . $where . "

                                  order by orders_products_id";


        $orders_products = $db->Execute($orders_products_query);


        while (!$orders_products->EOF) {

            // convert quantity to proper decimals - account history

            if (QUANTITY_DECIMALS != 0) {

                $fix_qty = $orders_products->fields['products_quantity'];

                switch (true) {

                    case (!strstr($fix_qty, '.')):

                        $new_qty = $fix_qty;

                        break;

                    default:

                        $new_qty = preg_replace('/[0]+$/', '', $orders_products->fields['products_quantity']);

                        break;

                }

            } else {

                $new_qty = $orders_products->fields['products_quantity'];

            }


            $new_qty = round($new_qty, QUANTITY_DECIMALS);


            if ($new_qty == (int)$new_qty) {

                $new_qty = (int)$new_qty;

            }


            /*bof get the products_SKU for every products*/

            $products_info = $db->Execute("select products_SKU,products_image from " . TABLE_PRODUCTS . ' where products_id = ' . $orders_products->fields['products_id']);

            $products_SKU = $products_info->fields['products_SKU'];

            $products_image = $products_info->fields['products_image'];


            /*eof get the products_SKU for every products*/

            $this->info['items'] += $new_qty;


            if ($currency_value > 0) {
                if (!in_array($orders_products->fields['products_id'], $wholesale_products)) {
                    $paypal_final_price = get_products_all_currency_final_price($orders_products->fields['products_price'] * $currency_value) / $currency_value;
                } else {
                    $paypal_final_price = get_products_specail_currency_final_price($orders_products->fields['products_price'] * $currency_value) / $currency_value;
                }
            }

            $this->products[$index] = array('qty' => $new_qty,

                'id' => $orders_products->fields['products_id'],

                'name' => $orders_products->fields['products_name'],

                'model' => $orders_products->fields['products_model'],

                'products_SKU' => $products_SKU,

                'products_image' => $products_image,//add for melo  11-23

                //'products_image' => $orders_products->fields['products_image'],

                'tax' => $orders_products->fields['products_tax'],

                'price' => $orders_products->fields['products_price'],

                'paypal_price' => $paypal_final_price,

                'final_price' => $orders_products->fields['final_price'],

                'onetime_charges' => $orders_products->fields['onetime_charges'],

                'products_priced_by_attribute' => $orders_products->fields['products_priced_by_attribute'],

                'product_is_free' => $orders_products->fields['product_is_free'],

                'products_discount_type' => $orders_products->fields['products_discount_type'],

                'products_discount_type_from' => $orders_products->fields['products_discount_type_from'],
                'reorder_type' => $orders_products->fields['reorder_type']
            );


            $subindex = 0;

            $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,

                              options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "

                               where orders_id = '" . (int)$order_id . "'

                               and orders_products_id = '" . (int)$orders_products->fields['orders_products_id'] . "'";


            $attributes = $db->Execute($attributes_query);

            if ($attributes->RecordCount()) {

                while (!$attributes->EOF) {

                    $this->products[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options'],

                        'value' => $attributes->fields['products_options_values'],

                        'option_id' => $attributes->fields['products_options_id'],

                        'value_id' => $attributes->fields['products_options_values_id'],

                        'prefix' => $attributes->fields['price_prefix'],

                        'price' => $attributes->fields['options_values_price']);


                    $subindex++;

                    $attributes->MoveNext();

                }

            }

            $attributes_length = "select * from order_product_length where orders_id = '" . (int)$order_id . "'

                               and orders_products_id = '" . (int)$orders_products->fields['orders_products_id'] . "'";

            $attributes_length = $db->Execute($attributes_length);

            if ($attributes_length->RecordCount()) {

                while (!$attributes_length->EOF) {

                    if ($attributes_length->fields['price_prefix'] == "+") {

                        $length_price = get_discount_price($attributes_length->fields['length_price'], $products[$index]['qty'], (int)$orders_products->fields['orders_products_id']);

                    } else {

                        $length_price = $attributes_length->fields['length_price'];

                    }

                    $this->products[$index]['attributes'][$subindex] = array('option' => $attributes_length->fields['length_name'],

                        'value' => 'length',

                        'value_id' => '',

                        'prefix' => $attributes_length->fields['price_prefix'],

                        'price' => $attributes_length->fields['length_price']);

                    $subindex++;

                    $attributes_length->MoveNext();

                }

            }


            $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';


            $index++;

            $orders_products->MoveNext();

        }

    }


    function cart()
    {

        global $db, $currencies;

        $this->content_type = $_SESSION['cart']->get_content_type();

        $this->currencies_value = $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);

        if ($_SESSION['customers_guest_id']) {

            $customers_guest = $db->Execute("select customers_default_address_id,customers_default_billing_address_id from customer_of_guest where guest_id = '" . $_SESSION['customers_guest_id'] . "'");
            if (empty($customers_guest->fields['customers_default_address_id'])) {
                $db->Execute("update customer_of_guest set customers_default_address_id = '" . $customers_guest->fields['customers_default_billing_address_id'] . "' where guest_id = '" . $_SESSION['customers_guest_id'] . "'");
            }
        }
        $customer_address_query = "select c.customers_firstname, c.customers_lastname, c.customers_telephone,

                                    c.customers_email_address, ab.entry_company, ab.entry_street_address,ab.is_avaTax_check,

                                    ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id,

                                    z.zone_name, co.countries_id, co.countries_name,

                                    co.countries_iso_code_2, co.countries_iso_code_3,

                                    co.address_format_id, ab.entry_state,customers_number_new

                                   from (" . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab )

                                   left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)

                                   left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)

                                   where c.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                   and ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                   and c.customers_default_address_id = ab.address_book_id";

        if ($_SESSION['customer_id']) {
            $customer_address_query = "select c.customers_firstname, c.customers_lastname, c.customers_telephone,

                                    c.customers_email_address, ab.entry_company, ab.entry_street_address,

                                    ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id,ab.is_avaTax_check,

                                    co.countries_id, co.countries_name,

                                    co.countries_iso_code_2, co.countries_iso_code_3,

                                    co.address_format_id, ab.entry_state,tel_prefix,c.customers_number_new

                                   from (" . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab )

                                   left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)

                                   where c.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                   and ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                   and c.customers_default_address_id = ab.address_book_id";
        } elseif ($_SESSION['customers_guest_id']) {

            $customer_address_query = "select c.first_name as customers_firstname, c.last_name as customers_lastname, c.telephone as customers_telephone,

                                    c.email_address as customers_email_address, ab.entry_company, ab.entry_street_address,

                                    ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id,

                                    co.countries_id, co.countries_name,

                                    co.countries_iso_code_2, co.countries_iso_code_3,

                                    co.address_format_id, ab.entry_state,tel_prefix

                                   from (" . TABLE_CUSTOMER_OF_GUEST . " c, " . TABLE_ADDRESS_BOOK . " ab )

                                   left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)

                                   where c.guest_id = '" . (int)$_SESSION['customers_guest_id'] . "'

                                   and ab.customers_guest_id = '" . (int)$_SESSION['customers_guest_id'] . "'

                                   and c.customers_default_address_id = ab.address_book_id";


        }

        $customer_address = $db->Execute($customer_address_query);


        /*$shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,

                                        ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,

                                        ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id,

                                        c.countries_id, c.countries_name, c.countries_iso_code_2,

                                        c.countries_iso_code_3, c.address_format_id, ab.entry_state

                                       from " . TABLE_ADDRESS_BOOK . " ab

                                       left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)

                                       left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)

                                       where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                       and ab.address_book_id = '" . (int)$_SESSION['sendto'] . "'";*/
        if (!empty($_SESSION['sendto'])) {
            $shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.is_avaTax_check,

                                    ab.entry_city, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,ab.entry_tax_number,ab.company_type,

                                    c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id, ab.entry_state,tel_prefix from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$_SESSION['sendto'];
            $this->delivery_id = (int)$_SESSION['sendto'];

        } elseif (!empty($_SESSION['sendtoG'])) {
            $shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,ab.is_avaTax_check,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_tax_number,ab.company_type,

                                    ab.entry_city, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,

                                    c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id, ab.entry_state,tel_prefix from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$_SESSION['sendtoG'];
            $this->delivery_id = (int)$_SESSION['sendtoG'];
        } elseif (!empty($this->sendTo)) {
            $shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,ab.is_avaTax_check,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,

                                    ab.entry_city, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,ab.entry_tax_number,ab.company_type,

                                    c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id, ab.entry_state,tel_prefix from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$this->sendTo;
        } else {

            $shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,ab.is_avaTax_check,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_tax_number,ab.company_type,

                                    ab.entry_city, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,

                                    c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id, ab.entry_state,tel_prefix from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$_SESSION['customer_default_address_id'];

            $this->delivery_id = (int)$_SESSION['customer_default_address_id'];
        }

        $shipping_address = $db->Execute($shipping_address_query);

        $billing_address = $this->resetBill();
        //STORE_PRODUCT_TAX_BASIS


        switch (STORE_PRODUCT_TAX_BASIS) {
            case 'Shipping':
                $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id

                              from " . TABLE_ADDRESS_BOOK . " ab

                              left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)

                              where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                              and ab.address_book_id = '" . (int)($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'";

                $tax_address = $db->Execute($tax_address_query);

                break;

            case 'Billing':
                $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id

                              from " . TABLE_ADDRESS_BOOK . " ab

                              left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)

                              where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                              and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";

                $tax_address = $db->Execute($tax_address_query);

                break;

            case 'Store':

                if ($billing_address->fields['entry_zone_id'] == STORE_ZONE) {
                    $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id

                                from " . TABLE_ADDRESS_BOOK . " ab

                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)

                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";

                } else {

                    $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id

                                from " . TABLE_ADDRESS_BOOK . " ab

                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)

                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'

                                and ab.address_book_id = '" . (int)($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'";

                }

                $tax_address = $db->Execute($tax_address_query);
                break;

        }


        $class =& $_SESSION['payment'];

        if (isset($_SESSION['cc_id'])) {

            $coupon_code_query = "select coupon_code

                              from " . TABLE_COUPONS . "

                              where coupon_id = '" . (int)$_SESSION['cc_id'] . "'";


            $coupon_code = $db->Execute($coupon_code_query);


        }


        //先发单信息
        $this->local_info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,

            'currency' => $_SESSION['currency'],

            'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],

            'payment_method' => $GLOBALS[$class]->title,

            'payment_module_code' => $GLOBALS[$class]->code,

            'coupon_code' => $coupon_code->fields['coupon_code'],

            'shipping_method' => (is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_module_code' => (isset($_SESSION['shipping']['id']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_us_method' => (is_array($_SESSION['nyshipping']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_us_module_code' => (isset($_SESSION['nyshipping']['id']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_cost' => $_SESSION['shipping']['cost'],

            'nyshipping_cost' => $_SESSION['nyshipping']['cost'],

            'shipping_insurance' => 0,

            'subtotal' => 0,

            'aftertax_subtotal' => 0,

            'shipping_tax' => 0,

            'tax' => 0,

            'total' => 0,

            'tax_groups' => array(),

            'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''),

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            "vat" => 0,

            "products_arr" => array(),

            "total_weight" => 0,

            "is_shipping_free" => false,

            "weight_info" => array(),

            "buck_weight" => 0
        );
        //延迟发货单信息
        $this->delay_info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,

            'currency' => $_SESSION['currency'],

            'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],

            'payment_method' => $GLOBALS[$class]->title,

            'payment_module_code' => $GLOBALS[$class]->code,

            'coupon_code' => $coupon_code->fields['coupon_code'],
            'shipping_method' => (is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_module_code' => (isset($_SESSION['shipping']['id']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_us_method' => (is_array($_SESSION['nyshipping']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_us_module_code' => (isset($_SESSION['nyshipping']['id']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_cost' => $_SESSION['shipping']['cost'],

            'nyshipping_cost' => $_SESSION['nyshipping']['cost'],

            'shipping_insurance' => 0,

            'subtotal' => 0,

            'aftertax_subtotal' => 0,

            'shipping_tax' => 0,

            'tax' => 0,

            'total' => 0,

            'tax_groups' => array(),

            'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''),

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            "products_arr" => array(),

            "total_weight" => 0,

            "vat" => 0,

            "is_shipping_free" => false,
            "buck_weight" => 0

        );
        //预售单信息
        $this->global_info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,

            'currency' => $_SESSION['currency'],

            'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],

            'payment_method' => $GLOBALS[$class]->title,

            'payment_module_code' => $GLOBALS[$class]->code,

            'coupon_code' => $coupon_code->fields['coupon_code'],

            'shipping_method' => (is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_module_code' => (isset($_SESSION['shipping']['id']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_us_method' => (is_array($_SESSION['nyshipping']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_us_module_code' => (isset($_SESSION['nyshipping']['id']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_cost' => $_SESSION['shipping']['cost'],

            'nyshipping_cost' => $_SESSION['nyshipping']['cost'],

            'shipping_insurance' => 0,

            'subtotal' => 0,

            'aftertax_subtotal' => 0,

            'shipping_tax' => 0,

            'tax' => 0,

            'total' => 0,

            'tax_groups' => array(),

            'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''),

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            "products_arr" => array(),

            "total_weight" => 0,

            "vat" => 0,

            "is_shipping_free" => false,
            "buck_weight" => 0

        );

        $this->gift_info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,

            'currency' => $_SESSION['currency'],

            'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],

            'payment_method' => $GLOBALS[$class]->title,

            'payment_module_code' => $GLOBALS[$class]->code,

            'coupon_code' => $coupon_code->fields['coupon_code'],

            'shipping_method' => (is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_module_code' => (isset($_SESSION['shipping']['id']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_us_method' => (is_array($_SESSION['nyshipping']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_us_module_code' => (isset($_SESSION['nyshipping']['id']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_cost' => 0,

            'nyshipping_cost' => 0,

            'shipping_insurance' => 0,

            'subtotal' => 0,

            'shipping_tax' => 0,

            'tax' => 0,

            'total' => 0,

            'tax_groups' => array(),

            'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''),

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            "products_arr" => array(),

            "total_weight" => 0,

            "vat" => 0,

            "is_shipping_free" => false,
            "buck_weight" => 0

        );
        $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,

            'currency' => $_SESSION['currency'],

            'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],

            'payment_method' => $GLOBALS[$class]->title,

            'payment_module_code' => $GLOBALS[$class]->code,

            'coupon_code' => $coupon_code->fields['coupon_code'],

            'shipping_method' => (is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_module_code' => (isset($_SESSION['shipping']['id']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']),

            'shipping_us_method' => (is_array($_SESSION['nyshipping']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_us_module_code' => (isset($_SESSION['nyshipping']['id']) ? $_SESSION['nyshipping']['id'] : $_SESSION['nyshipping']),

            'shipping_cost' => $_SESSION['shipping']['cost'],

            'nyshipping_cost' => $_SESSION['nyshipping']['cost'],

            'shipping_insurance' => 0,

            'subtotal' => 0,

            'shipping_tax' => 0,

            'tax' => 0,

            'total' => 0,

            'tax_groups' => array(),

            'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''),

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            "vat" => 0,
            "total_weight" => 0

        );


        if ($customer_address->fields['customers_firstname'] || $customer_address->fields['customers_lastname']) {

            $this->customer = array('firstname' => $customer_address->fields['customers_firstname'],

                'lastname' => $customer_address->fields['customers_lastname'],

                'company' => $customer_address->fields['entry_company'],

                'street_address' => $customer_address->fields['entry_street_address'],

                'suburb' => $customer_address->fields['entry_suburb'],

                'city' => $customer_address->fields['entry_city'],

                'postcode' => $customer_address->fields['entry_postcode'],

                'state' => ((zen_not_null($customer_address->fields['entry_state'])) ? $customer_address->fields['entry_state'] : $customer_address->fields['zone_name']),

                'zone_id' => $customer_address->fields['entry_zone_id'],

                'country' => array('id' => $customer_address->fields['countries_id'], 'title' => $customer_address->fields['countries_name'], 'iso_code_2' => $customer_address->fields['countries_iso_code_2'], 'iso_code_3' => $customer_address->fields['countries_iso_code_3'], 'tel_prefix' => $customer_address->fields['tel_prefix']),

                'format_id' => (int)$customer_address->fields['address_format_id'],

                'telephone' => $customer_address->fields['customers_telephone'],

                'customers_number_new' => $customer_address->fields['customers_number_new'],

                'email_address' => $customer_address->fields['customers_email_address']);

        } else {


            $email_address = $db->Execute("select customers_email_address,customers_number_new from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "'");

            $this->customer = array('firstname' => $shipping_address->fields['entry_firstname'],

                'lastname' => $shipping_address->fields['entry_lastname'],

                'company' => $shipping_address->fields['entry_company'],

                'street_address' => $shipping_address->fields['entry_street_address'],

                'suburb' => $shipping_address->fields['entry_suburb'],

                'city' => $shipping_address->fields['entry_city'],

                'postcode' => $shipping_address->fields['entry_postcode'],

                'state' => ((zen_not_null($shipping_address->fields['entry_state'])) ? $shipping_address->fields['entry_state'] : $shipping_address->fields['zone_name']),

                'zone_id' => $shipping_address->fields['entry_zone_id'],

                'country' => array('id' => $shipping_address->fields['countries_id'], 'title' => $shipping_address->fields['countries_name'], 'iso_code_2' => $shipping_address->fields['countries_iso_code_2'], 'iso_code_3' => $shipping_address->fields['countries_iso_code_3'], 'tel_prefix' => $shipping_address->fields['tel_prefix']),

                'telephone' => $shipping_address->fields['entry_telephone'],

                'format_id' => (int)$shipping_address->fields['address_format_id'],
                'customers_number_new' => $email_address->fields['customers_number_new'],

                'email_address' => $email_address->fields['customers_email_address']);


        }


        $this->delivery = array('firstname' => $shipping_address->fields['entry_firstname'],

            'lastname' => $shipping_address->fields['entry_lastname'],

            'company' => $shipping_address->fields['entry_company'],

            'street_address' => $shipping_address->fields['entry_street_address'],

            'suburb' => $shipping_address->fields['entry_suburb'],

            'city' => $shipping_address->fields['entry_city'],

            'postcode' => $shipping_address->fields['entry_postcode'],

            'state' => ((zen_not_null($shipping_address->fields['entry_state'])) ? $shipping_address->fields['entry_state'] : $shipping_address->fields['zone_name']),

            'zone_id' => $shipping_address->fields['entry_zone_id'],

            'country' => array('id' => $shipping_address->fields['countries_id'], 'title' => $shipping_address->fields['countries_name'], 'iso_code_2' => $shipping_address->fields['countries_iso_code_2'], 'iso_code_3' => $shipping_address->fields['countries_iso_code_3'], 'tel_prefix' => $shipping_address->fields['tel_prefix']),

            'country_id' => $shipping_address->fields['entry_country_id'],

            'telephone' => $shipping_address->fields['entry_telephone'],

            'format_id' => (int)$shipping_address->fields['address_format_id'],
            'company_type' => $shipping_address->fields['company_type'],
            'is_avaTax_check' => $shipping_address->fields['is_avaTax_check'],
            'tax_number' => $shipping_address->fields['entry_tax_number']);


        if ($shipping_address->fields['countries_iso_code_2']) {

            $_SESSION['countries_code_2'] = $shipping_address->fields['countries_iso_code_2'];

        } else {

            $_SESSION['countries_code_2'] = "";

        }


        $index = 0;

        $products = $this->cart_products ? $this->cart_products : $_SESSION['cart']->get_checked_products(false, true, true)['checkedProducts'];

        /**
         * 产品分仓初始化
         * 对购物车产品进行拆分
         */
        //$this->create_separate($tax_address,$products );
        $this->create_separate_order_info($tax_address, $products);


        //订单总价

//    $this->info['shipping_cost'] = zen_round(get_products_all_currency_final_price($this->info['shipping_cost'] * $currencies_value),2)/$currencies_value;


        // Update the final total to include tax if not already tax-inc


        /*

        // moved to function create

            if ($this->info['total'] == 0) {

              if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {

                $this->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;

              } else {

                $this->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;

              }

            }

        */

        if (isset($GLOBALS[$class]) && is_object($GLOBALS[$class])) {

            if (isset($GLOBALS[$class]->order_status) && is_numeric($GLOBALS[$class]->order_status) && ($GLOBALS[$class]->order_status > 0)) {

                $this->info['order_status'] = $GLOBALS[$class]->order_status;

            }

        }

        $this->notify('NOTIFY_ORDER_CART_FINISHED');

    }

    //将游客未注册订单改为线下自动录单
    function guest_order_to_offline_order($admin_id)
    {
        global $db;
        $sql_data_array = array(
            'customers_firstname' => $this->customer['name'],
            'customers_lastname' => $this->customer['lastname'],
            'customers_email_address' => $this->customer['email_address'],
            'customers_company' => $this->customer['company'],
            'customer_country_id' => fs_get_data_from_db_fields('countries_id', 'countries', "countries_name='" . $this->customer['country'] . "'", ''),
            'customers_level' => 'D',
            //'customers_number' => $customers_number,
            'customers_telephone' => $this->customer['telephone'],
            //'customers_address'=> $entry_street_address,
            //'customer_address_country_id' =>$entry_country_id,
            //'customers_code' => $entry_postcode,
            //'customers_city' => $entry_city,
            'addtime' => 'now()',
            'admin_id' => $admin_id,
            //		'admin_to_customers' => $admin_to_customers
        );
        zen_db_perform('customers_offline', $sql_data_array);
        $customers_id = $db->insert_ID();
        $address_delivery_info = array(
            'address_type' => 1,
            'customers_id' => $customers_id,
            'entry_firstname' => $this->delivery['name'],
            'entry_lastname' => $this->delivery['lastname'],
            'entry_street_address' => $this->delivery['street_address'],
            'entry_suburb' => $this->delivery['suburb'],
            'entry_city' => $this->delivery['city'],
            'entry_country_id' => fs_get_data_from_db_fields('countries_id', 'countries', "countries_name='" . $this->delivery['country'] . "'", ''),
            'entry_state' => $this->delivery['state'],
            'entry_postcode' => $this->delivery['postcode'],
            'entry_telephone' => $this->delivery['telephone'],
        );
        zen_db_perform('address_offline_book', $address_delivery_info);
        $a_id = $db->insert_ID();
        $db->Execute("update customers_offline set customers_default_address_id = '$a_id'
					            where customers_id = '$customers_id'");
        $address_billing_info = array(
            'address_type' => 2,
            'customers_id' => $customers_id,
            'entry_firstname' => $this->billing['name'],
            'entry_lastname' => $this->billing['lastname'],
            'entry_street_address' => $this->billing['street_address'],
            'entry_suburb' => $this->billing['suburb'],
            'entry_city' => $this->billing['city'],
            'entry_country_id' => fs_get_data_from_db_fields('countries_id', 'countries', "countries_name='" . $this->billing['country'] . "'", ''),
            'entry_state' => $this->billing['state'],
            'entry_postcode' => $this->billing['postcode'],
            'entry_telephone' => $this->billing['telephone'],
        );
        zen_db_perform('address_offline_book', $address_billing_info);
        $b_id = $db->insert_ID();
        $db->Execute("update customers_offline set customers_default_billing_address_id = '$b_id'
					            where customers_id = '$customers_id'");
    }

    function resetBill()
    {
        global $db;
        if (!empty($_SESSION['billto'])) {

            $billing_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_tax_number,ab.company_type,

                                    ab.entry_city, ab.entry_state, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,

									c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id,tel_prefix

                                    from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$_SESSION['billto'];

        } elseif (!empty($_SESSION['billtoG'])) {
            $billing_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_tax_number,ab.company_type,

                                    ab.entry_city, ab.entry_state, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,

									c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id,tel_prefix

                                    from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$_SESSION['billtoG'];
        } elseif (!empty($this->billTo)) {
            $billing_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_tax_number,ab.company_type,

                                    ab.entry_city, ab.entry_state, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,

									c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id,tel_prefix

                                    from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . $this->billTo;
        } else {


            $billing_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,

                                    ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_tax_number,ab.company_type,

                                    ab.entry_city, ab.entry_state, ab.entry_zone_id,ab.entry_country_id,ab.entry_telephone,

									c.countries_id, c.countries_name, c.countries_iso_code_2,

                                    c.countries_iso_code_3, c.address_format_id,tel_prefix

                                    from " . TABLE_ADDRESS_BOOK . " as ab , " .

                TABLE_COUNTRIES . " as c where ab.entry_country_id = c.countries_id and ab.address_book_id = " . (int)$_SESSION['customer_default_address_id'];

        }


        $billing_address = $db->Execute($billing_address_query);
        $this->billing = array('firstname' => $billing_address->fields['entry_firstname'],

            'lastname' => $billing_address->fields['entry_lastname'],

            'company' => $billing_address->fields['entry_company'],

            'street_address' => $billing_address->fields['entry_street_address'],

            'suburb' => $billing_address->fields['entry_suburb'],

            'city' => $billing_address->fields['entry_city'],

            'postcode' => $billing_address->fields['entry_postcode'],

            'state' => ((zen_not_null($billing_address->fields['entry_state'])) ? $billing_address->fields['entry_state'] : $billing_address->fields['zone_name']),

            'zone_id' => $billing_address->fields['entry_zone_id'],

            'country' => array('id' => $billing_address->fields['countries_id'], 'title' => $billing_address->fields['countries_name'], 'iso_code_2' => $billing_address->fields['countries_iso_code_2'], 'iso_code_3' => $billing_address->fields['countries_iso_code_3'], 'tel_prefix' => $billing_address->fields['tel_prefix']),

            'country_id' => $billing_address->fields['entry_country_id'],

            'telephone' => $billing_address->fields['entry_telephone'],

            'format_id' => (int)$billing_address->fields['address_format_id'],
            'company_type' => $billing_address->fields['company_type'],
            'tax_number' => $billing_address->fields['entry_tax_number']
        );
        return $billing_address;
    }

    /***
     * add by aron
     * 检查邮箱后缀 判断客户是否是欺诈客户
     * @param $email
     * @param $main_order_id
     * @return int|string
     */
    function check_eamil_ext($email, $main_order_id)
    {
        global $db;
        $str = $email;
        $ext = substr($str, strpos($str, "@"));
        $ext_arr = array("@szyuxuan.com", "@feisu.com", "@fs.com");
        if (in_array($ext, $ext_arr)) {
            return 1;
        }

        if (in_array($this->local_warehouse, array(3, 40))) {
            //整单/主单触发
            if (in_array($main_order_id, array(0, 1))) {
                $mark = 0;
                //查询是否游客下单
                $customers = $db->getAll("SELECT customers_id,customers_level FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address ='" . $email . "' limit 1");
                $customer_id = $db->getAll("SELECT is_test_type,is_test FROM " . TABLE_ORDERS . " WHERE customers_email_address ='" . $email . "' and is_test_type = 1  order by date_purchased asc limit 1");
                if ($this->billing['country_id'] == 223 || $this->delivery['country_id'] == 223) {
                    if ($this->billing['state'] == "Florida" || $this->delivery['state'] == "Florida") {
                        $mark .= 8;
                    }
                }
                $blacklist_address = $db->getAll("select street_address,city,postcode from " . TABLE_FRAUDULENT_ADDRESS_MANAGEMENT . " where id>0");

                $mark_order = 0;
                $billing_arr = $this->billing;
                $delivery_arr = $this->delivery;
                $billing_arr['street_address'] = $this->billing['street_address'] . $this->billing['suburb'];
                $delivery_arr['street_address'] = $this->delivery['street_address'] . $this->delivery['suburb'];
                foreach ($blacklist_address as $key => $arr) {
                    $billing_mark = 0;
                    $delivery_mark = 0;
                    $address_str = "";
                    $billing_str = "";
                    $delivery_str = "";
                    foreach ($arr as $k => $v) {
                        if ($blacklist_address[$key][$k]) {
                            $address_str = str_replace(" ", "", $blacklist_address[$key][$k]);
                        }
                        $billing_str = str_replace(" ", "", $billing_arr[$k]);
                        $delivery_str = str_replace(" ", "", $delivery_arr[$k]);
                        if ($address_str) {
                            if ($billing_str && $billing_str != $address_str) {
                                $billing_mark = 1;
                            }
                            if ($delivery_str && $delivery_str != $address_str) {
                                $delivery_mark = 1;
                            }
                        }
                    }
                    if ($billing_mark == 0 || $delivery_mark == 0) {
                        $mark_order = 2;
                    }
                }

                $telephone = array("+1-9086423030", "+1-3057489688", "0000000000");
                if (in_array($this->billing['telephone'], $telephone) || in_array($this->billing['telephone'], $telephone)) {
                    $mark_order = 2;
                }
                if ($mark_order == 2) {
                    $mark .= 2;
                }
                //查询是否为ABC级客户 并且首次下单超过6个月
                if ($customers[0]['customers_level'] && $mark == 0) {
                    if (in_array($customers[0]['customers_level'], ['A', 'B', 'C'])) {
                        $order_time = $db->getAll("SELECT date_purchased FROM orders WHERE customers_email_address ='" . $email . "' order by date_purchased asc limit 1");
                        if ($order_time[0]['date_purchased']) {
                            $time = strtotime($order_time[0]['date_purchased']);
                            if ($time < strtotime("-6 month")) {
                                return 0;
                            }
                        }
                    }
                }
                //未注册客户
                if (!$customer_id[0]['is_test_type'] && !$customers[0]['customers_id']) {
                    $mark .= 7;
                }
                $customer_orders = $this->new_customer_orders();
                //判断是否为新客户
                if ($customer_orders != false) {
                    $mark .= $customer_orders;
                }
                $many_times_order_user = $this->many_times_order_user();
                //判断地址是否下单次数过多
                if ($many_times_order_user != false) {
                    $mark .= $many_times_order_user;
                }

                $number_of_ip_orders = $this->number_of_ip_orders();
                //判断IP是否下单次数过多
                if ($number_of_ip_orders != false) {
                    $mark .= $number_of_ip_orders;
                }
                $many_times_order = $this->many_times_order($this->delivery['street_address']);
                //判断用户是否下单次数过多
                if ($many_times_order != false) {
                    $mark .= $many_times_order;
                }

                $billing_address_str = $this->billing['firstname'] . $this->billing['lastname'] . $this->billing['company'] .
                    $this->billing['street_address'] . $this->billing['suburb'] . $this->billing['city'] . $this->billing['postcode'] . $this->billing['state'] .
                    $this->billing['zone_id'] . $this->billing['country'] . $this->billing['country_id'] . $this->billing['telephone'] . $this->billing['format_id'] .
                    $this->billing['company_type'] . $this->billing['tax_number'];
                $delivery_address_str = $this->delivery['firstname'] . $this->delivery['lastname'] . $this->delivery['company'] .
                    $this->delivery['street_address'] . $this->delivery['suburb'] . $this->delivery['city'] . $this->delivery['postcode'] . $this->delivery['state'] .
                    $this->delivery['zone_id'] . $this->delivery['country'] . $this->delivery['country_id'] . $this->delivery['telephone'] . $this->delivery['format_id'] .
                    $this->delivery['company_type'] . $this->delivery['tax_number'];
                //判断账单地址和收获地址是否相等
                if ($billing_address_str != $delivery_address_str) {
                    $mark .= 6;
                }
                return $mark;
            } elseif ($main_order_id > 1) {
                //分单
                $order_info = $db->getAll("SELECT is_test from " . TABLE_ORDERS . " where orders_id =" . $main_order_id . "");
                if ($order_info) {
                    return $order_info[0]['is_test'];
                } else {
                    return 0;
                }
            }
        } else {
            return 0;
        }
    }

    function create($zf_ot_modules, $zf_mode = 2, $zf_ot_modules_tax = [])
    {

        global $db;
        date_default_timezone_set('America/Los_Angeles');
        if ($this->info['total'] == 0) {

            if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {

                $this->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;

            } else {

                if ($_SESSION['payment'] != 'freecharger') {

                    $this->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;

                }

            }

        }

        if ($_SESSION['shipping'] == 'free_free') {

            $this->info['shipping_module_code'] = $_SESSION['shipping'];

        }

        /*check if there is any orders exist*/

        $orders_number = $this->createOrdersNumber();


        $sql_data_array = array('customers_id' => $_SESSION['customer_id'],

            'guest_id' => (int)$_SESSION['customers_guest_id'],
            'customers_name' => $this->customer['firstname'],

            'customers_lastname' => $this->customer['lastname'],

            'customers_company' => $this->customer['company'],

            'customers_street_address' => $this->customer['street_address'],

            'customers_suburb' => $this->customer['suburb'],

            'customers_city' => $this->customer['city'],

            'customers_postcode' => $this->customer['postcode'],

            'customers_state' => $this->customer['state'],

            'customers_country' => $this->customer['country']['title'],

            'customers_telephone' => $this->customer['telephone'],

            'customers_email_address' => $this->customer['email_address'],

            'customers_address_format_id' => $this->customer['format_id'],

            'delivery_name' => $this->delivery['firstname'],

            'delivery_lastname' => $this->delivery['lastname'],

            'delivery_company' => $this->delivery['company'],

            'delivery_street_address' => $this->delivery['street_address'],

            'delivery_suburb' => $this->delivery['suburb'],

            'delivery_city' => $this->delivery['city'],

            'delivery_postcode' => $this->delivery['postcode'],

            'delivery_state' => $this->delivery['state'],

            'delivery_country' => $this->delivery['country']['title'],

            'delivery_address_format_id' => $this->delivery['format_id'],

            'delivery_tax_number' => $this->delivery['tax_number'],
            'delivery_company_type' => $this->delivery['company_type'],

            'billing_name' => $this->billing['firstname'],

            'billing_lastname' => $this->billing['lastname'],

            'billing_company' => $this->billing['company'],

            'billing_street_address' => $this->billing['street_address'],

            'billing_suburb' => $this->billing['suburb'],

            'billing_city' => $this->billing['city'],

            'billing_postcode' => $this->billing['postcode'],

            'billing_state' => $this->billing['state'],

            'billing_country' => $this->billing['country']['title'],

            'billing_tax_number' => $this->billing['tax_number'],
            "billing_company_type" => $this->billing['company_type'],

            'billing_address_format_id' => $this->billing['format_id'],

            'payment_method' => (($this->info['payment_module_code'] == '' and $this->info['payment_method'] == '') ? PAYMENT_METHOD_GV : $this->info['payment_method']),

            'payment_module_code' => (($this->info['payment_module_code'] == '' and $this->info['payment_method'] == '') ? PAYMENT_MODULE_GV : $this->info['payment_module_code']),

            'shipping_method' => $this->info['shipping_method'],

            'shipping_us_method' => $this->info['shipping_us_method'],


            'shipping_module_code' => (strpos($this->info['shipping_module_code'], '_') > 0 ? substr($this->info['shipping_module_code'], 0, strpos($this->info['shipping_module_code'], '_')) : $this->info['shipping_module_code']),

            'shipping_us_module_code' => (strpos($this->info['shipping_us_module_code'], '_') > 0 ? substr($this->info['shipping_us_module_code'], 0, strpos($this->info['shipping_us_module_code'], '_')) : $this->info['shipping_us_module_code']),

            'coupon_code' => $this->info['coupon_code'],

            'cc_type' => $this->info['cc_type'],

            'cc_owner' => $this->info['cc_owner'],

            'cc_number' => $this->info['cc_number'],

            'cc_expires' => $this->info['cc_expires'],

            'date_purchased' => date('Y-m-d H:i:s'),

            'orders_status' => $this->info['order_status'],

            'order_total' => $this->info['total'],

            'order_tax' => $this->info['tax'],

            'currency' => $this->info['currency'],

            'currency_value' => $this->info['currency_value'],

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            'orders_number' => $orders_number,

            'd_tel_prefix' => zen_db_prepare_input($this->delivery['country']['tel_prefix']),

            'b_tel_prefix' => zen_db_prepare_input($this->billing['country']['tel_prefix']),

            'c_tel_prefix' => zen_db_prepare_input($this->customer['country']['tel_prefix']),

            'delivery_telephone' => $this->delivery['telephone'],

            'billing_telephone' => $this->billing['telephone'],

            'main_order_id' => 1,

            'language_id' => (int)$_SESSION['languages_id'],

            'language_code' => $_SESSION['languages_code'],
            //是否为补发订单 local 为本地 delay 为本地补发 global 全国仓发货
            'is_reissue' => $this->is_reissue,
            //订单所属仓库
            'warehouse' => $this->warehouse,

            'is_test' => $this->check_eamil_ext($this->customer['email_address'], 1),

            'customers_remarks' => !empty($_SESSION['customer_remarks']) ? $_SESSION['customer_remarks'] : "",

            'customers_po' => !empty($_SESSION['customers_po']) ? $_SESSION['customers_po'] : "",

            'relate_address_id' => $this->delivery_id,

            'client_type' => $_SESSION['client_type'] ? $_SESSION['client_type'] : "",

            'delivery_country_id' => $this->delivery['country']['id'],

            'vax' => $this->vax/100,

            'is_au_gsp' => $this->delivery['country']['id'] == 13 ? 1 : 0
        );

        zen_db_perform(TABLE_ORDERS, $sql_data_array);

        $insert_id = $db->Insert_ID();

        if ($_SESSION['customer_id']) {

            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);

        }

        if ($admin_id) {

            $sql_data_array = array(

                'admin_id' => $admin_id,

                'orders_id' => $insert_id

            );
            $_SESSION['orders_to_admin_id'] = $admin_id;
            zen_db_perform('order_to_admin', $sql_data_array);

        }


        $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_HEADER', array_merge(array('orders_id' => $insert_id, 'shipping_weight' => $_SESSION['cart']->weight), $sql_data_array));


//        $sql_data_log_array = array(
//
//            'orders_id' => $insert_id,
//
//            'customers_id' => $_SESSION['customer_id'],
//
//            'browser_info' => $_SERVER['HTTP_USER_AGENT'],
//
//            'session_content_info' => var_export($_SESSION,true),
//
//        );
//
//        zen_db_perform('order_logs',$sql_data_log_array);


        if (is_array($zf_ot_modules) && $zf_ot_modules) {
            foreach ($zf_ot_modules as $total) {
                $sql_data_array = array('orders_id' => $insert_id,

                    'title' => $total['title'],

                    'text' => $total['text'],

                    'value' => (is_numeric($total['value'])) ? $total['value'] : '0',

                    'class' => $total['code'],

                    'sort_order' => $total['sort_order']);


                zen_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

                $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDERTOTAL_LINE_ITEM', $sql_data_array);

            }
        }

        if(is_array($zf_ot_modules_tax) && !empty($zf_ot_modules_tax)){
            foreach($zf_ot_modules_tax as $total_tax) {
                $sql_data_array = array('orders_id' => $insert_id,

                    'title' => $total_tax['title'],

                    'text' => $total_tax['text'],

                    'value' => (is_numeric($total_tax['value'])) ? $total_tax['value'] : '0',

                    'class' => $total_tax['code'],

                    'sort_order' => $total_tax['sort_order']);



                zen_db_perform(TABLE_ORDERS_TOTAL_TAX, $sql_data_array);

                $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDERTOTAL_LINE_ITEM', $sql_data_array);

            }
        }

        $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';

        $sql_data_array = array('orders_id' => $insert_id,

            'orders_status_id' => $this->info['order_status'],

            'date_added' => 'now()',

            'customer_notified' => $customer_notification,

            'comments' => $this->info['comments']);


        zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);


        $this->update_related_email($insert_id);
        $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_COMMENT', $sql_data_array);


        if ($_SESSION['shipping']['title'] == 'customzones') {

            if (!empty($_SESSION['method_shppings']) && !empty($_SESSION['method_acounts'])) {

                $sql_data_array = array('orders_id' => $insert_id,

                    'customers_id' => $_SESSION['customer_id'],

                    'addtime' => date('Y-m-d H:i;s'),

                    'method' => $_SESSION['method_shppings'],

                    'account' => $_SESSION['method_acounts']);

                zen_db_perform('orders_shipping', $sql_data_array);

            }

        }


        return ($insert_id);


    }

    /**
     * add by aron
     * 对购物车拆分后产品 进行处理,生成分单信息
     * 2019.8.15税收规则进行调整
     *
     * @param $tax_address
     * @param $products
     */
    function create_separate_order_info($tax_address, $products)
    {
        //如果全部从本地发货或者是全部从国内发货
        global $currencies;
        $country_code = $this->delivery['country']["iso_code_2"];
        $billing_country_code = strtoupper($this->billing['country']['iso_code_2']);
        if (german_warehouse("country_code", $country_code) || other_eu_warehouse($country_code, "country_code")) {
            $warehouse = 20;
            $this->local_warehouse = 20;
            $this->global_warehouse = 2;
            $separate_product = $this->create_separate_products_info($warehouse, $products);
            $this->is_vax = true;
            $this->is_vax_de = true;
            if (time() > 1609455599) { //柏林2020-12-31 23：59：59时间戳
                $vax_num = 19;
            } else {
                $vax_num = 16;
            }
            $this->vax = $this->vax_de = $vax_num;
            $this->is_ireland_zones = checkNorthIrelandPostcode($this->delivery['postcode'], $this->delivery['country_id']);
            $this->is_ireland_billings_zones = checkNorthIrelandPostcode($this->billing['postcode'], $this->billing['country_id']);
            //收货地址为德国，无论账单地址为哪个国家，一律收取19%的VAT。
            //2020-6-25 pico 更新规则 收货地址为德国，无论账单地址为哪个国家，一律收取16%的VAT。 2020.7.1-12.31
            if ($country_code == "DE") {
                $this->vax = $this->vax_de = 16;
            } elseif (german_warehouse("country_code", $country_code) || $this->is_ireland_zones) {
                //收货地址为欧盟国家（非德国），以账单地址的国家为准，判断是否收税：
                //2019-12-26 pico 更新规则 账单地址为企业类型，根据账单地址国家继续判断

                if ($billing_country_code){
                    if ($this->billing['company_type'] == 'BusinessType') {
                        if ($billing_country_code == 'DE') {
                            $this->vax = $this->vax_de = $vax_num;
                        } elseif (german_warehouse("country_code", $billing_country_code) || $this->is_ireland_billings_zones) {
                            $this->is_vax = false;
                            $this->is_vax_de = false;
                            $this->vax = 0;
                        } else {
                            $this->vax = $this->vax_de = $vax_num;
                        }
                    } elseif ($this->billing['company_type'] == 'IndividualType') {
                        if (in_array($country_code, ['FR', 'MC', 'IM'])) {
                            $this->vax = $this->vax_de = 20;
                        } elseif ($country_code == "SE") {
                            $this->vax = $this->vax_de = 25;
                        } elseif ($country_code == "NL" || $country_code == "ES") {
                            $this->vax = $this->vax_de = 21;
                        } elseif ($country_code == "IT") {
                            $this->vax = $this->vax_de = 22;
                        } elseif ($country_code == "BL" || $country_code == "MF") {
                            $this->vax = $this->vax_de = 0;
                        } else {
                            $this->vax = $this->vax_de = $vax_num;
                        }
                    }
                }
            } else {
                $this->vax = 0;
                $this->is_vax = false;
                $this->is_vax_de = false;
            }

        } elseif (seattle_warehouse("country_code", $country_code)) {
            $warehouse = 40;
            $this->local_warehouse = 40;
            $this->global_warehouse = 2;
            $separate_product = $this->create_separate_products_info($warehouse, $products);
        } elseif (au_warehouse($country_code, "country_code")) {
            $warehouse = 37;
            $this->local_warehouse = 37;
            $this->global_warehouse = 2;
            $separate_product = $this->create_separate_products_info($warehouse, $products);
        } elseif (singapore_warehouse("country_code", $country_code)) {
            $warehouse = 71;
            $this->local_warehouse = 71;
            $this->global_warehouse = 2;
            $separate_product = $this->create_separate_products_info($warehouse, $products);
        } elseif (ru_warehouse("country_code", $country_code) && $this->delivery['company_type'] == 'BusinessType') {
            $warehouse = 67;
            $this->local_warehouse = 67;
            $this->global_warehouse = 2;
            $separate_product = $this->create_separate_products_info($warehouse, $products);
        } else {
            $this->global_warehouse = 2;
            $this->local_warehouse = 2;
            $warehouse = 2;
            $separate_product = $this->create_separate_products_info($warehouse, $products);
        }
        if (get_apply_customer_duty_free($this->delivery['country']['title'])) {
            $this->is_vax = false;
            $this->is_vax_de = false;
        }
        //有库存产品
        //从购物车获取拆分后的产品
        $this->local_cart_products = $domestic_delivery_pro = $separate_product['local'];
        $this->delay_cart_products = $domestic_delivery_delay_pro = $separate_product['delay'];
        $this->global_cart_products = $global_delivery_global_pro = $separate_product['global'];
        $this->gift_cart_products = $gift_delivery_pro = $separate_product['gift'];

        $this->is_buck_in_products = $this->is_buck_in_all_products();
        $this->getChinaLimitProducts($country_code, $products);//查看是否存在中国大陆限制的产品id

        //生成分单以及产品信息
        if (isset($domestic_delivery_pro)) {
            $this->creat_products($domestic_delivery_pro, $tax_address, $this->local_products, $this->local_info);
        }
        if (isset($domestic_delivery_delay_pro)) {
            $this->creat_products($domestic_delivery_delay_pro, $tax_address, $this->delay_products, $this->delay_info,'delay');
        }
        if (isset($global_delivery_global_pro)) {
            $this->creat_products($global_delivery_global_pro, $tax_address, $this->global_products, $this->global_info);
        }
        if (isset($gift_delivery_pro)) {
            $this->creat_products($gift_delivery_pro, $tax_address, $this->gift_products, $this->gift_info);
        }

        if (!empty($this->delay_products)  && $this->heavy_products) {
            foreach ($this->delay_info['products_arr'] as $d_buck) {
                if (in_array((int)$d_buck, $this->heavy_products)) {
                    $this->is_buck = true;
                    break;
                }
            }
            foreach ($this->delay_products as $o_weight) {
                if (in_array((int)$o_weight['id'], $this->heavy_products) && $o_weight['weight'] > 30) {
                    $this->is_delay_overweight = true;
                    break;
                }
            }
        }

        if (!empty($this->local_info['products_arr']) && $this->heavy_products) {
            foreach ($this->local_info['products_arr'] as $v_buck) {
                if (in_array((int)$v_buck, $this->heavy_products) && !(in_array((int)$v_buck, $this->is_heavy_free))) {
                    $this->is_local_buck = true;
                    break;
                }
            }

            foreach ($this->local_products as $d_weight) {
                if (in_array((int)$d_weight['id'], $this->heavy_products) && $d_weight['weight'] > 30) {
                    $this->is_local_overweight = true;
                    break;
                }
            }
        }
        //判断是否有超重
        if (!empty($this->local_products)) {
            $this->is_local_oversize = $this->isOverSize($this->local_products);
        }

        if (!empty($this->delay_products)) {
            $this->is_delay_oversize = $this->isOverSize($this->delay_products);
        }

        $this->add_heavy_tag($this->local_cart_products, 'local');
        $this->add_heavy_tag($this->delay_cart_products);
        $this->add_heavy_tag($this->global_cart_products);
        $this->add_heavy_tag($this->local_products, 'local');
        $this->add_heavy_tag($this->delay_products);
        $this->add_heavy_tag($this->global_products);

        $this->resetOrderTotalInfo();
        $this->createShippingInfo();
        //判断是否包含特殊机柜
        $this->is_cabinet_in_order();
    }

    /**
     * 此方法用于重置order 订单 税收信息 因为会多次调用 请勿添加sql
     *
     * 生成订单税收运费信息
     */
    public function resetOrderTotalInfo()
    {
        global $currencies;
        $country_code = $this->delivery['country']["iso_code_2"];
        $billing_country_code = strtoupper($this->billing['country']['iso_code_2']);
        $this->orderVat = $_SESSION['orderVat'];
        $order_info = $this->get_order_num();
        $order_num = $this->transOrderInfo($order_info)['order_num'];
        $order_data = $this->transOrderInfo($order_info)['order_data'];
        $this->local_shipping_cost = $local_shipping_cost = $this->handleShippingCost($_SESSION['shipping_local']['cost']);
        $this->delay_shipping_cost = $delay_shipping_cost = $this->handleShippingCost($_SESSION['shipping_delay']['cost']);
        $this->global_shipping_cost = $global_shipping_cost = $this->handleShippingCost($_SESSION['shipping_global']['cost']);
        //保险费
        if ($_SESSION['shipping_delay']['id'] == 'forwarderzones_forwarderzones') {
            $this->insurance = $this->delay_info['subtotal'] * 0.005;
        }
        //生成税率
        if (german_warehouse("country_code", $country_code) || other_eu_warehouse($country_code, "country_code")) {
            $this->is_vax = true;
            $this->is_vax_de = true;
            //2020-6-25 pico 更新规则 收货地址为德国，无论账单地址为哪个国家，一律收取16%的VAT。 2020.7.1-12.31
            if (time() > 1609455599) { //柏林2020-12-31 23：59：59时间戳
                $vax_num = 19;
            } else {
                $vax_num = 16;
            }
            $this->vax = $this->vax_de = $vax_num;
            //收货地址为德国，无论账单地址为哪个国家，一律收取19%的VAT。
            if ($country_code == "DE") {
                $this->vax = $this->vax_de = $vax_num;
            } elseif (german_warehouse("country_code", $country_code) || $this->is_ireland_zones) {
                //收货地址为欧盟国家（非德国），以账单地址的国家为准，判断是否收税：
                //2019-12-26 pico 更新规则 账单地址为企业类型，根据账单地址国家继续判断
                //2019-12-26 pico 更新规则 账单地址为个人类型，根据收件地址国家继续判断：
                if ($billing_country_code) {
                    if ($this->billing['company_type'] == 'BusinessType') {
                        if ($billing_country_code == 'DE') {
                            $this->vax = $this->vax_de = $vax_num;
                        } elseif (german_warehouse("country_code", $billing_country_code) || $this->is_ireland_billings_zones) {
                            $this->is_vax = false;
                            $this->is_vax_de = false;
                            $this->vax = 0;
                        } else {
                            $this->vax = $this->vax_de = $vax_num;
                        }
                    } elseif ($this->billing['company_type'] == 'IndividualType') {
                        if (in_array($country_code, ['FR', 'MC', 'IM'])) {
                            $this->vax = $this->vax_de = 20;
                        } elseif ($country_code == "SE" || $country_code == "DK") {
                            $this->vax = $this->vax_de = 25;
                        } elseif ($country_code == "NL" || $country_code == "ES" || $country_code == "BE") {
                            $this->vax = $this->vax_de = 21;
                        } elseif ($country_code == "BL" || $country_code == "MF") {
                            $this->is_vax = false;
                            $this->vax = $this->vax_de = 0;
                        } elseif ($country_code == "IT") {
                            $this->vax = $this->vax_de = 22;
                        } else {
                            $this->vax = $this->vax_de = $vax_num;
                        }
                    }
                }
            } else {
                $this->vax = 0;
                $this->is_vax = false;
                $this->is_vax_de = false;
            }

        } elseif (seattle_warehouse("country_code", $country_code)) {
            $this->is_vax = false;
            if ($country_code == 'US' && AUTOAVATAX) {
                $this->is_vax = true;
                $this->vax = 10;
                $this->is_vax_us = true;
            } else {
                $this->vax = 0;
            }
        } elseif (au_warehouse($country_code, "country_code")) {
            $this->is_vax = true;
            $this->is_vax_au = true;
            $this->vax = 10;
            if ($country_code == "NZ") {
                $this->is_vax = false;
                $this->is_vax_au = false;
                $this->vax = 0;
            }
        } elseif (singapore_warehouse("country_code", $country_code)) {
            //收获国家为新加坡时才收税
            if (strtolower($country_code) == "sg") {
                $this->is_vax = true;
                $this->is_vax_sg = true;
                $this->vax = 7;
            }
        } elseif (ru_warehouse("country_code", $country_code) && $this->delivery['company_type'] == "BusinessType") {
            //俄罗斯地区对公账户收税20%
            $this->is_vax = true;
            $this->is_vax_ru = true;
            $this->vax = 20;
        } else {
            //中国地区需要收税
            if (strtolower($country_code) == "cn") {
                $this->is_vax = true;
                $this->is_vax_cn = true;
                $this->vax = $this->vax_cn;
            } elseif ($this->delivery['company_type'] == "BusinessType" && $country_code == "RU") {
                //俄罗斯地区对公账户收税20%
                $this->is_vax = true;
                $this->is_vax_cn = true;
                $this->vax = $this->vax_cn = 20;
            }

        }

        if (get_apply_customer_duty_free($this->delivery['country']['title'])) {
            $this->is_vax = false;
            $this->is_vax_de = false;
        }

        if ($order_num == 1 && $order_data == "delay" && $this->is_buck && !in_array($this->local_warehouse,[2, 20, 37, 40, 67])) {
            $this->is_vax = false;
            $this->is_vax_de = false;
            $this->is_vax_au = false;
        }
        if ($country_code == "US" && isset($this->orderVat['total'])) {
            $this->is_vax = true;
            $this->is_vax_us = true;
        }
        if ($this->is_vax) {
            //中国税收 产品总价*税率
            if ($this->is_vax_cn) {
                if ($country_code == "RU") {
                    $this->vat = (($this->global_info['subtotal'] + $this->local_info['subtotal'] + $this->delay_info['subtotal'] + $local_shipping_cost + $delay_shipping_cost + $global_shipping_cost) * $this->vax_cn) / 100;
                } else {
                    $this->vat = (($this->global_info['subtotal'] + $this->local_info['subtotal'] + $this->delay_info['subtotal']) * $this->vax_cn) / 100;
                }
            }
            if ($this->is_vax_de) {
                //德国税收规则 （产品总价+运费)*税率
                if ($order_num == 1) {
                    switch ($order_data) {
                        case "local":
                            $this->vat = ($this->local_info['subtotal'] + $local_shipping_cost) * $this->vax_de;
                            break;
                        case "delay":
                            $this->vat = ($this->delay_info['subtotal'] + $delay_shipping_cost) * $this->vax_de;
                            break;
                        case "global":
                            $this->vat = ($this->global_info['subtotal'] + $global_shipping_cost) * $this->vax_de;
                            break;
                    }
                } elseif ($order_num == 2) {
                    switch ($order_data) {
                        case "local-delay":
                            if ($this->is_buck) {
                                $this->vat = ($this->local_info['subtotal'] + $this->delay_info['subtotal'] + $local_shipping_cost
                                        + $delay_shipping_cost) * $this->vax_de;
                            } else {
                                $this->vat = ($this->local_info['subtotal'] + $this->delay_info['subtotal'] + $local_shipping_cost) * $this->vax_de;
                            }
                            break;
                        case "local-global":
                            $this->vat = ($this->local_info['subtotal'] + $this->global_info['subtotal'] + $global_shipping_cost + $local_shipping_cost) * $this->vax_de;
                            break;
                        case "delay-global":
                            if (!$this->is_buck) {
                                $this->vat = ($this->delay_info['subtotal'] + $this->global_info['subtotal'] + $global_shipping_cost + $delay_shipping_cost) * $this->vax_de;
                            } else {
                                //当直发单与预售产品共用一个运费时，需要按照重量比例拆分运费获取税收
                                $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                                $weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                                $delay_cost = $delay_shipping_cost * $weight_percent;
                                $global_cost = $delay_shipping_cost - $delay_cost;
                                $this->vat = ($this->global_info['subtotal'] + $global_cost) * $this->vax_de;
                            }
                            break;
                    }
                } else {
                    if ($this->is_buck) {
                        //当直发单与预售产品共用一个运费时，需要按照重量比例拆分运费获取税收
                        $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                        $weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                        $delay_cost = $delay_shipping_cost * $weight_percent;
                        $global_cost = $delay_shipping_cost - $delay_cost;
                        $this->vat = ($this->local_info['subtotal'] + $this->global_info['subtotal'] + $global_cost + $local_shipping_cost) * $this->vax_de;
                    } else {
                        $this->vat = ($this->local_info['subtotal'] + $this->global_info['subtotal'] + $this->delay_info['subtotal'] + $global_shipping_cost + $local_shipping_cost) * $this->vax_de;
                    }
                }
                $this->vat = $this->vat / 100;
            }
            if ($this->is_vax_au) {
                //澳大利亚税收规则 （产品总价+运费)*税率
                $au_vax = 10;
                if ($order_num == 1) {
                    switch ($order_data) {
                        case "local":
                            $vat_shipping_cost = $local_shipping_cost * $au_vax;
                            $this->vat = $this->local_info['tax'] * 100 + $vat_shipping_cost;
                            break;
                        case "delay":
                            $vat_shipping_cost = $delay_shipping_cost * $au_vax;
                            $this->vat = $this->delay_info['tax'] * 100 + $vat_shipping_cost;
                            break;
                        case "global":
                            $vat_shipping_cost = $global_shipping_cost * $au_vax;
                            $this->vat = $this->global_info['tax'] * 100 + $vat_shipping_cost;
                            break;
                    }
                } elseif ($order_num == 2) {
                    switch ($order_data) {
                        case "local-delay":
                            $vat_shipping_cost = ($local_shipping_cost + $delay_shipping_cost) * $au_vax;
                            $this->vat = ($this->local_info['tax'] + $this->delay_info['tax']) * 100 + $vat_shipping_cost;
                            break;
                        case "local-global":
                            $vat_shipping_cost = ($local_shipping_cost + $global_shipping_cost) * $au_vax;
                            $this->vat = ($this->local_info['tax'] + $this->global_info['tax']) * 100 + $vat_shipping_cost;
                            break;
                        case "delay-global":
                            if (!$this->is_buck) {
                                $this->vat = ($this->delay_info['subtotal'] + $this->global_info['subtotal'] + $global_shipping_cost + $delay_shipping_cost) * $au_vax;
                            } else {
                                //当直发单与预售产品共用一个运费时，需要按照重量比例拆分运费获取税收
                                $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                                $weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                                $delay_cost = $delay_shipping_cost * $weight_percent;
                                $global_cost = $delay_shipping_cost - $delay_cost;
                                $this->vat = ($this->global_info['subtotal'] + $global_cost) * $au_vax;
                            }
                            break;
                    }
                } else {
                    if ($this->is_buck) {
                        //当直发单与预售产品共用一个运费时，需要按照重量比例拆分运费获取税收
                        $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                        $weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                        $delay_cost = $delay_shipping_cost * $weight_percent;
                        $global_cost = $delay_shipping_cost - $delay_cost;
                        $this->vat = ($this->local_info['subtotal'] + $this->global_info['subtotal'] + $global_cost + $local_shipping_cost) * $au_vax;
                    } else {
                        $this->vat = ($this->local_info['subtotal'] + $this->global_info['subtotal'] + $this->delay_info['subtotal'] + $local_shipping_cost + $global_shipping_cost) * $au_vax;
                    }
                }
                $this->vat = $this->vat / 100;
            }
            if ($this->is_vax_sg) {
                //新加坡税收规则 （产品总价+运费)*税率
                $sg_vax = 7;
                if ($order_num == 1) {
                    switch ($order_data) {
                        case "local":
                            $this->vat = ($this->local_info['subtotal'] + $local_shipping_cost) * $sg_vax;
                            break;
                    }
                } elseif ($order_num == 2) {
                    switch ($order_data) {
                        case "local-delay":
                            $this->vat = ($this->local_info['subtotal'] + $local_shipping_cost) * $sg_vax;
                            break;
                    }
                }
                $this->vat = $this->vat / 100;
            }
            if ($this->is_vax_ru) {
                $this->vat = (($this->global_info['subtotal'] + $this->local_info['subtotal'] + $this->delay_info['subtotal'] + $local_shipping_cost + $delay_shipping_cost + $global_shipping_cost) * $this->vax) / 100;
            }
            if ($this->is_vax_us && $country_code == "US") {
                $this->vat = $this->orderVat['total'];
            }
        } else {
            $this->vat = 0;
            $this->is_vax = false;
            $this->is_vax_au = false;
            $this->is_vax_de = false;
            $this->is_vax_us = false;
            $this->is_vax_sg = false;
            $this->is_vax_cn = false;
            $this->is_vax_ru = false;
        }

        //生成订单总单价格信息
        $this->info['shipping_cost'] = $local_shipping_cost + $delay_shipping_cost + $global_shipping_cost;
        $this->info['subtotal'] = $this->global_info['subtotal'] + $this->local_info['subtotal'] + $this->delay_info['subtotal'];
        $this->info['total'] = $this->info['subtotal'] + $this->info['shipping_cost'] + $this->vat;
        if ($this->is_vax) {
            $this->info['tax_groups']['Vat'] = $this->vat;
        }

        //税后价格
        $local_shipping_cost_tax = get_gsp_tax_price($this->delivery['country_id'], $local_shipping_cost);
        $global_shipping_cost_tax = get_gsp_tax_price($this->delivery['country_id'], $global_shipping_cost);
        $delay_shipping_cost_tax = get_gsp_tax_price($this->delivery['country_id'], $delay_shipping_cost);

        $this->info['aftertax_shipping_cost'] = $local_shipping_cost_tax + $delay_shipping_cost_tax +
            $global_shipping_cost_tax;
        $this->info['aftertax_subtotal'] = $this->global_info['aftertax_subtotal'] +
            $this->local_info['aftertax_subtotal'] + $this->delay_info['aftertax_subtotal'];
    }


    /**
     * add by aron
     * 为每一单 生成是否免运费信息
     */
    function createShippingInfo()
    {
        global $currencies;
        $order_info = $this->get_order_num();
        $order_data = $this->transOrderInfo($order_info)['order_data'];
        $heavy_products = $this->heavy_products;
        $free_shipping_info = $this->get_free_shipping_money();
        $translate_currency = $free_shipping_info['currencies_val'];
        $translate_currency_type = $free_shipping_info['currencies_type'];
        $pre_free_price = $free_shipping_info['pre_free_price'];
        $free_price = $free_shipping_info['free_price'];
        $country_code = $this->delivery['country']["iso_code_2"];
        if ($country_code == "AU") {
            $this->is_remote_post_code = check_au_remote_areas($this->delivery['postcode']);
        }

        if ($this->local_warehouse == 20) {
            $this->is_de_remote = check_de_remote_areas($this->delivery['postcode'], $this->delivery['country']['iso_code_2']);
        }

        switch ($order_data) {
            case "local":
                $buck_price = 0;
                if (!empty($heavy_products)) {
                    foreach ($this->local_cart_products as $v) {
                        if (in_array((int)$v['id'], $this->local_heavy_products)) {
                            $this->local_info['buck_weight'] += $v["quantity"] * $v['weight'];
                            $buck_price += $v["quantity"] * $v['final_price'];
                        }
                    }
                }

                //澳大利亚税后价判断是否免运
                $free_subtotal = $this->delivery['country_id'] == 13 ? $this->local_info['aftertax_subtotal'] :
                    $this->local_info['subtotal'];

                $normal_price = $currencies->total_format_new($free_subtotal - $buck_price, true, $translate_currency_type, $translate_currency);
                if ($normal_price >= $free_price && !$this->is_remote_post_code && $this->local_warehouse!=2) {
                    $this->local_info['is_shipping_free'] = true;
                } elseif ($normal_price >= $free_price && $country_code == "RU" && $this->local_warehouse == 2) {
                    $this->local_info['is_shipping_free'] = true;
                }
                break;
            case "delay":
                $buck_price = 0;
                if (!empty($heavy_products)) {
                    foreach ($this->delay_cart_products as $v) {
                        if (in_array((int)$v['id'], $this->heavy_products)) {
                            $this->delay_info['buck_weight'] += $v["quantity"] * $v['weight'];
                            $buck_price += $v["quantity"] * $v['final_price'];
                        }
                    }
                }

                //澳大利亚税后价判断是否免运
                $free_subtotal = $this->delivery['country_id'] == 13 ? $this->delay_info['aftertax_subtotal'] :
                    $this->delay_info['subtotal'];

                $normal_price = $currencies->total_format_new($free_subtotal - $buck_price, true, $translate_currency_type, $translate_currency);
                if ($normal_price >= $free_price && !$this->is_remote_post_code && $this->local_warehouse!=2) {
                    $this->delay_info['is_shipping_free'] = true;
                } elseif ($normal_price >= $free_price && $country_code == "RU" && $this->local_warehouse == 2) {
                    $this->delay_info['is_shipping_free'] = true;
                }
                break;
            case "global":
                $normal_price = $currencies->total_format_new($this->global_info['subtotal'], true, $translate_currency_type, $translate_currency);
                if ($normal_price >= $pre_free_price && !$this->is_remote_post_code && $country_code != "NZ" && $this->local_warehouse != 2) {
                    $this->global_info['is_shipping_free'] = true;
                }
                break;
            case "local-delay":
            case "local-delay-global":
            case "delay-global":
            case "local-global":
                $local_buck_price = 0;
                $delay_buck_price = 0;

                if (!empty($heavy_products)) {
                    foreach ($this->delay_cart_products as $v) {
                        if (in_array((int)$v['id'], $this->heavy_products)) {
                            $this->delay_info['buck_weight'] += $v["quantity"] * $v['weight'];
                            if($this->delivery['country_id'] == 13){
                                //澳洲无库存重货算税后价
                                $delay_buck_price += $v["quantity"] * $v['tax_after_price'];
                            }else{
                                $delay_buck_price += $v["quantity"] * $v['final_price'];
                            }
                        }
                    }
                }


                if (!empty($heavy_products) && !empty($this->local_cart_products)) {
                    foreach ($this->local_cart_products as $v) {
                        if (in_array((int)$v['id'], $this->local_heavy_products)) {
                            $this->local_info['buck_weight'] += $v["quantity"] * $v['weight'];
                            $local_buck_price += $v["quantity"] * $v['final_price'];
                        }
                    }
                }


                //澳大利亚税后价判断是否免运
                $free_subtotal = $this->delivery['country_id'] == 13 ?
                    ($this->local_info['aftertax_subtotal'] + $this->delay_info['aftertax_subtotal']) :
                    ($this->local_info['subtotal'] + $this->delay_info['subtotal']);

                $buck_price = $local_buck_price + $delay_buck_price;
                $normal_price = $free_subtotal - $buck_price;
                $normal_price = $currencies->total_format_new($normal_price, true, $translate_currency_type, $translate_currency);
                if ($normal_price >= $free_price && !$this->is_remote_post_code) {
                    if ($country_code != "NZ" && $this->local_warehouse != 2) {
                        $this->local_info['is_shipping_free'] = true;
                        $this->delay_info['is_shipping_free'] = true;
                    } elseif ($country_code == "RU" && $this->local_warehouse == 2) {
                        $this->local_info['is_shipping_free'] = true;
                        $this->delay_info['is_shipping_free'] = true;
                    }
                }
                if (!empty($this->global_cart_products)) {
                    $normal_price_global = $currencies->total_format_new($this->global_info['subtotal'], true, $translate_currency_type, $translate_currency);
                    if ($normal_price_global >= $pre_free_price && !$this->is_remote_post_code && $country_code != "NZ" && $this->local_warehouse != 2) {
                        $this->global_info['is_shipping_free'] = true;
                    }
                }

                break;
        }
        //新加坡仓除了新加坡其他国家均不免运
        if ($this->local_warehouse == 71 && $country_code != 'SG') {
            $this->local_info['is_shipping_free'] = false;
            $this->delay_info['is_shipping_free'] = false;
        }
    }

    public function transOrderInfo($order_info)
    {
        $order_tag_arr = ['local-gift' => 'local', 'delay-gift' => 'delay', 'global-gift' => 'global', 'local-delay-gift' => 'local-delay',
            'local-global-gift' => 'local-global', 'delay-global-gift' => 'delay-global', 'local-delay-global-gift' => 'local-delay-global'];
        $order_data = $order_info['data'];
        $order_num = $order_info['num'];
        if (isset($order_tag_arr[$order_data])) {
            $order_data = $order_tag_arr[$order_data];
            $order_num = count(explode("-", $order_data));
        }
        return [
            'order_data' => $order_data,
            'order_num' => $order_num
        ];
    }

    /***
     * 达到by aron
     * @return array
     * 获取各仓库免运金额
     */
    function get_free_shipping_money()
    {
        global $currencies;
        $warehouse = $this->local_warehouse;
        $country_code = $this->delivery['country']["iso_code_2"];
        switch ($warehouse) {
            case 37:
                $free_price = 99;
                $pre_free_price = 399;
                $currencies_val = $currencies->currencies["AUD"]['value'];
                $currencies_type = "AUD";
                break;
            case 71:
                $free_price = 99;
                $pre_free_price = 399;
                $currencies_val = $currencies->currencies["SGD"]['value'];
                $currencies_type = "SGD";
                break;
            case 67:
                $free_price = 20000;
                $pre_free_price = 70000;
                $currencies_val = $currencies->currencies["RUB"]['value'];
                $currencies_type = "RUB";
                break;
            case 20:
                $free_price = 79;
                $pre_free_price = 299;
                $currencies_val = $currencies->currencies["EUR"]['value'];
                $currencies_type = "EUR";
                if (in_array($country_code, array("GB", "GG", "IM", "JE"))) {
                    $currencies_val = $currencies->currencies["GBP"]['value'];
                    $currencies_type = "GBP";
                }
                //欧洲仓非欧元的免运费价格 Quest
                if ($_SESSION['currency'] != 'EUR' && $country_code == strtoupper($_SESSION['countries_iso_code'])) {//当前站点国家与收获地址币种一致
                    switch ($country_code) {
                        case 'DK':
                        case 'FO':
                            $free_price = 599;
                            $pre_free_price = 2300;
                            $currencies_val = $currencies->currencies["DKK"]['value'];
                            $currencies_type = "DKK";
                            break;
                        case 'LT':
                        case 'MD':
                            $free_price = 90;
                            $pre_free_price = 339;
                            $currencies_val = $currencies->currencies["USD"]['value'];
                            $currencies_type = "USD";
                            break;
                        case 'NO':
                            $free_price = 799;
                            $pre_free_price = 2900;
                            $currencies_val = $currencies->currencies["NOK"]['value'];
                            $currencies_type = "NOK";
                            break;
                        case 'SE':
                            $free_price = 850;
                            $pre_free_price = 3150;
                            $currencies_val = $currencies->currencies["SEK"]['value'];
                            $currencies_type = "SEK";
                            break;
                        case 'CH':
                            $free_price = 89;
                            $pre_free_price = 350;
                            $currencies_val = $currencies->currencies["CHF"]['value'];
                            $currencies_type = "CHF";
                            break;
                    }
                }
                break;
            case 40:
                $free_price = 79;
                $pre_free_price = 299;
                $currencies_val = $currencies->currencies["USD"]['value'];
                $currencies_type = "USD";
                if ($_SESSION['currency'] != 'USD' && $country_code == strtoupper($_SESSION['countries_iso_code'])) {//当前站点国家与收获地址币种一致
                    if ($country_code == "CA") {
                        $free_price = 105;
                        $pre_free_price = 399;
                        $currencies_val = $currencies->currencies["CAD"]['value'];
                        $currencies_type = "CAD";
                    }
                    if ($country_code == "MX") {
                        $free_price = 1600;
                        $pre_free_price = 6000;
                        $currencies_val = $currencies->currencies["MXN"]['value'];
                        $currencies_type = "MXN";
                    }
                }
                break;
            case 2:
                $free_price = 79;
                $pre_free_price = 299;
                $currencies_val = $currencies->currencies["USD"]['value'];
                $currencies_type = "USD";
                if ($country_code == "RU") {
                    $free_price = 20000;
                    $pre_free_price = 99999999; //by rebirth  2019-12-17   设置免运时未知预售产品免运价格 直接剔除
                    $currencies_val = $currencies->currencies["RUB"]['value'];
                    $currencies_type = "RUB";
                }
                break;
            default:
                $free_price = 79;
                $pre_free_price = 299;
                $currencies_val = $currencies->currencies["USD"]['value'];
                $currencies_type = "USD";
        }
        return [
            "free_price" => $free_price,
            "pre_free_price" => $pre_free_price,
            "currencies_val" => $currencies_val,
            "currencies_type" => $currencies_type,
            'outPutTextPre' => $currencies->currencies[$currencies_type]['symbol_left'] . $pre_free_price . $currencies->currencies[$currencies_type]['symbol_right']
        ];
    }

    /**
     * add by aron
     * 对运费进行处理
     * @param $shippingCost
     * @return float|int
     */
    public function handleShippingCost($shippingCost)
    {
        global $currencies;
        if (!$shippingCost) {
            return 0;
        }
        $currencies_value = $this->info['currency_value'];
        $decimal = $currencies->currencies[$this->info['currency']]['decimal_places'];
        $shippingCost = zen_round(get_products_all_currency_final_price($shippingCost * $currencies_value), $decimal) / $currencies_value;
        return $shippingCost;
    }

    /**
     * add by aron
     * 根据仓库将购物车产品进行拆分
     * @param $warehouse  当前订单仓库
     * @param $products   购物车获取的产品
     * @return array      local: 本地库存 delay: 本地无库存 global: 预售产品
     */
    function create_separate_products_info($warehouse, $products)
    {
        $local_num = 0;
        $global_num = 0;
        $delay_num = 0;
        $is_confirm = 0;
        $gift_num = 0;
        $products_arr = array();
        $isCaution = 0;
        if ($_SESSION['customer_id']) {
            $customer_type = fs_customer_order_product_is_instock($_SESSION['customer_id'], true);
            if ($customer_type) {
                if ($customer_type == 1) {
                    $is_confirm = 1;  //全部需要销售确认
                } else {
                    $instock_category = $customer_type;  //对应分类下产品需要销售确认
                }
            }
        }
        for ($i = 0; $i < sizeof($products); $i++) {
            //  定制产品录单   获取关联标准产品ID
            $standard_products = (int)$products[$i]['standardProductsId'] ? (int)$products[$i]['standardProductsId']:(int)$products[$i]['id'];
            //判断当前产品是否有设置禁戒值
            $isCaution = (int)$this->getInstockCaution($standard_products);
            //判断是否为预售产品
            if (check_product_is_pre_product($standard_products)) {
                $products_arr["global"][$global_num] = $products[$i];
                $global_num++;
                continue;
            }
            //判断是否为赠品
            if ($products[$i]['is_gift'] == 1) {
                if (in_array($warehouse, [20, 40])) {
                    $products_arr["gift"][$gift_num] = $products[$i];
                    $gift_num++;
                }
                continue;
            }
            //判断模块产品是否勾选标签  如果选择了标签 也存放到delay里面
            $label_flag = false;
            if (isset($products[$i]['attributes'])) {
                foreach ($products[$i]['attributes'] as $kk => $vv) {
                    if ((int)$kk == 318 || $vv == 7621) {
                        $label_flag = true;
                        break;
                    }
                }
            }
            if ($label_flag && $warehouse != 40) {
                $products_arr["delay"][$delay_num] = $products[$i];
                $delay_num++;
                continue;
            }
            if (($is_confirm == 0)) {
                if (isset($instock_category) && is_array($instock_category)) {                                           //客户某些分类订单 需销售确认
                    $update_status = fs_customer_order_product_auto_instock($standard_products, $instock_category);
                } else {
                    $update_status = 1;
                }
                if ($update_status) {
                    if (in_array($warehouse, array(3, 20, 2, 37, 40, 67, 71))) {
                        $combination_attr = ''; //组合产品选中的属性值ID
                        if (sizeof($products[$i]['attributes'])) {
                            $combination_attr = reorder_options_values($products[$i]['attributes']);
                        }
                        $composite_data = ['attr' => $combination_attr];
                        if ($warehouse == 3) {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "US", false, $pcs = $products[$i]['quantity'], false, $composite_data);
                        } elseif ($warehouse == 20) {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "DE", false, $pcs = $products[$i]['quantity'], false, $composite_data);
                        } elseif ($warehouse == 37) {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "AU", false, $pcs = $products[$i]['quantity'], false, $composite_data);
                        } elseif ($warehouse == 40) {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "US-ES", false, $pcs = $products[$i]['quantity'], false, $composite_data);
                        } elseif ($warehouse == 67) {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "RU", false, $pcs = $products[$i]['quantity'], false, $composite_data);
                        } elseif ($warehouse == 71) {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "SG", false, $pcs = $products[$i]['quantity'], false, $composite_data);
                        } else {
                            $remain_num = fs_products_instock_qty_of_products_id($standard_products, "CN", true, $pcs = $products[$i]['quantity'], false, $composite_data);
                        }
                        $products[$i]['instock'] = $remain_num;

                        //如果当前产品 超过禁戒值 并且 亚洲仓库存大于本地仓库存 直接从亚洲仓发
                        if (!empty($isCaution) && $isCaution > $remain_num && in_array($warehouse, [20, 37, 40, 71])) {
                            $cnNum = fs_products_instock_qty_of_products_id($products[$i]['id'], "CN",
                                true, $pcs = $products[$i]['quantity'], true, $composite_data);
                            if ($cnNum > $remain_num) {
                                $products_arr["delay"][$delay_num] = $products[$i];
                                $delay_num++;
                                continue;
                            }
                        }
                        
                        if ($GLOBALS["related_products_id_for_orders"]) {
                            $related_id = $GLOBALS["related_products_id_for_orders"][$products[$i]['id']]['related_id'];
                            foreach ($GLOBALS["related_products_id_for_orders"] as $rek => $re) {
                                if ($rek == $products[$i]['id']) {
                                    continue;
                                }
                                if ($related_id == $re['related_id']) {
                                    $remain_num -= $re['pcs'];
                                }
                            }
                        }
                        $remain_num = $remain_num > 0 ? $remain_num : 0;
                        if ($remain_num < $products[$i]['quantity']) {
                            if ($remain_num <= 0) {
                                $products_arr["delay"][$delay_num] = $products[$i];
                                $delay_num++;
                            } else {
                                $products_arr["delay"][$delay_num] = $products[$i];
                                $products_arr["delay"][$delay_num]['quantity'] = $products_arr["delay"][$delay_num]['quantity'] - $remain_num;
                                $products_arr["local"][$local_num] = $products[$i];
                                $products_arr["local"][$local_num]['quantity'] = $remain_num;
                                $local_num++;
                                $delay_num++;
                            }
                        } else {
                            $products_arr["local"][$local_num] = $products[$i];
                            $local_num++;
                        }
                    }
                } else {
                    $products_arr["delay"][$delay_num] = $products[$i];
                    $delay_num++;
                }
            } else {
                $products_arr["delay"][$delay_num] = $products[$i];
                $delay_num++;
            }

        }
        unset($GLOBALS["related_products_id_for_orders"]);
        return $products_arr;
    }

    /**
     * 获取产品当前仓库警戒值
     *
     * @param $pid  产品主id
     * @return int
     * @author aron
     */
    public function getInstockCaution($pid = 0)
    {
        global $db;
        return 0;
        $warehouse = $this->local_warehouse;
        $caution = "";
        $result = 0;
        switch ($warehouse) {
            case 40:
                $caution = 'caution_us';
                break;
            case 20:
                $caution = 'caution_de';
                break;
            case 71:
                $caution = "caution_sg";
                break;
            case 37:
                $caution = 'caution_au';
                break;
            case 67:
                $caution = "caution_ru";
                break;
        }
        $related = $db->Execute("select {$this->cacheType} r.products_id,m.products_id as main_id from products_instock_add_related as r 
            left join products_instock_add_model as m using(model_id) where r.products_id = " . (int)$pid . ' order by r.warehouse asc limit 1');
        $productsID = $related->fields['main_id'] ? $related->fields['main_id'] : $pid;
        if (!empty($productsID) && !empty($caution)) {
            $data = $db->Execute("SELECT products_id,{$caution} as caution FROM
            products_instock_cautions WHERE products_id = {$productsID} limit 1");
            $result = $data->fields['caution'] ? $data->fields['caution'] : 0;
        }
        return $result;
    }

    /**
     * add by aron
     * @param $products
     * @param $tax_address
     * @param $set_pro
     * @param $set_info
     * @param $type 分单类型,默认为空
     * 对购物车获取的产品进行处理
     * 根据不同订单生成不同 info信息
     */
    function creat_products($products, $tax_address, &$set_pro, &$set_info, $type = '')
    {
        global $db, $currencies;
        $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
        $decimal = $currencies->currencies[$this->info['currency']]['decimal_places'];
        $index = 0;

        if(isset($products)){

            //判断delay 是否包含重货
            $is_delay_aftertax = true;
            if($type == 'delay'){
                foreach ($products as $p_val){
                    if(in_array($p_val['id'], $this->heavy_products)){
                        $is_delay_aftertax = false;
                        break;
                    }
                }
            }

            for ($i = 0, $n = sizeof($products); $i < $n; $i++) {

                if (($i / 2) == floor($i / 2)) {

                    $rowClass = "rowEven";

                } else {

                    $rowClass = "rowOdd";

                }
                $set_info['products_arr'][] = $products[$i]['id'];
                $taxRates = zen_get_multiple_tax_rates($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']);

                $paypal_price = $products[$i]['final_price'];

                $aftertax_price = get_gsp_tax_price($this->delivery['country_id'],$paypal_price);

//                if($is_delay_aftertax){
//                    $aftertax_price = get_gsp_tax_price($this->delivery['country_id'],$paypal_price);
//                }else{
//                    $aftertax_price = $paypal_price;
//                }

                //$_SESSION['cart']->get_produucts()在获取产品的时候就对产品重量进行了计算，直接调用即可
                $pure_weight = ((int)$products[$i]['quantity'] * round($products[$i]['view_weight'], 3));

                $set_info['total_weight'] += $products[$i]['weight'] * $products[$i]['quantity'];
                if (isset($set_info['weight_info'])) {
                    $set_info['weight_info'][$products[$i]['id']] = $products[$i]['weight'] * $products[$i]['quantity'];
                }
                $set_pro[$index] = array(
                    'qty' => $products[$i]['quantity'],

                    'name' => $products[$i]['name'],

                    'model' => $products[$i]['model'],

                    'tax' => zen_get_tax_rate($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']),

                    'tax_groups' => $taxRates,

                    'tax_description' => zen_get_tax_description($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']),

                    'price' => $products[$i]['price'],

                    'attributes_price' => $_SESSION['cart']->attributes_price($products[$i]['id']),

                    'products_price' => $products[$i]['products_price'],

                    'final_price' => $products[$i]['price'] + $_SESSION['cart']->attributes_price($products[$i]['id']),

                    'paypal_price' => $paypal_price,

                    'aftertax_price' => $aftertax_price,

                    'onetime_charges' => $_SESSION['cart']->attributes_price_onetime_charges($products[$i]['id'], $products[$i]['quantity']),

                    'weight' => $products[$i]['weight'],

                    'products_priced_by_attribute' => $products[$i]['products_priced_by_attribute'],

                    'product_is_free' => $products[$i]['product_is_free'],

                    'products_discount_type' => $products[$i]['products_discount_type'],

                    'products_discount_type_from' => $products[$i]['products_discount_type_from'],

                    'id' => $products[$i]['id'],

                    'productImageSrc' => $products[$i]['image'],

                    'instock' => $products[$i]["instock"],

                    'relate_material_id' => $products[$i]["relate_material_id"],

                    'rowClass' => $rowClass,

                    'orders_number' => $products[$i]['orders_number']
                );

                $this->notify('NOTIFY_ORDER_CART_ADD_PRODUCT_LIST', array('index' => $index, 'products' => $products[$i]));


                if ($products[$i]['attributes']) {

                    $subindex = 0;

                    reset($products[$i]['attributes']);

                    while (list($option, $value) = each($products[$i]['attributes'])) {

                        if ($option != 'length') {

                            $attributes_query = "select popt.products_options_name, poval.products_options_values_name,

                                          pa.options_values_price, pa.price_prefix

                                   from " . TABLE_PRODUCTS_OPTIONS . " popt,

                                        " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval,

                                        " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                                   where pa.products_id = '" . (int)$products[$i]['id'] . "'

                                   and pa.options_id = '" . (int)$option . "'

                                   and pa.options_id = popt.products_options_id

                                   and pa.options_values_id = '" . (int)$value . "'

                                   and pa.options_values_id = poval.products_options_values_id

                                   and popt.language_id = '" . (int)$_SESSION['languages_id'] . "'

                                   and poval.language_id = '" . (int)$_SESSION['languages_id'] . "'";

                            $attributes = $db->Execute($attributes_query);

                            if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {

                                $attr_value = $products[$i]['attributes_values'][$option];

                            } else {

                                $attr_value = $attributes->fields['products_options_values_name'];

                            }

                            //attributes_file
                            $attributes_file = '';
                            if ($products[$i]['attributes_file'][$option]) {
                                $attributes_file = $products[$i]['attributes_file'][$option];
                            }

                            $set_pro[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options_name'],

                                'value' => $attr_value,

                                'option_id' => $option,

                                'value_id' => $value,

                                'prefix' => $attributes->fields['price_prefix'],

                                'price' => $attributes->fields['options_values_price'],

                                'attributes_file' => $attributes_file
                            );

                            $this->notify('NOTIFY_ORDER_CART_ADD_ATTRIBUTE_LIST', array('index' => $index, 'subindex' => $subindex, 'products' => $products[$i], 'attributes' => $attributes));

                        } else {

                            $list = $db->getAll("select price_prefix,length from products_length where product_id = '" . (int)$products[$i]['id'] . "' and id ='" . (int)$value . "'");

                            if ($list) {
                                //通过长度 实时获取价格
                                $priceArr = get_length_range_price((int)$products[$i]['id'], $list[0]['length']);
                                $length_price = $priceArr['length_price'];

                                $set_pro[$index]['attributes'][$subindex] = array(

                                    'option' => $list[0]['length'],

                                    'value' => 'length',

                                    'value_id' => $value,

                                    'prefix' => $list[0]['price_prefix'],

                                    'price' => $length_price);

                            }

                        }
                        $subindex++;
                    }

                }

                $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
                $products_total_data = zen_add_tax($set_pro[$index]['paypal_price'], $set_pro[$index]['tax']) ;
                $products_total = zen_round($products_total_data * $currencies_value,$decimal) * $set_pro[$index]['qty'] ;
                $products_total = zen_round($products_total,$decimal);
                $shown_price = $products_total/$currencies_value;

                //计算了税后价
//                if($is_delay_aftertax){
                    $au_tax = 0.1;
                    $tax_total = $products_total_data * $au_tax;
                    $tax_total = zen_round($tax_total * $currencies_value, $decimal) * $set_pro[$index]['qty'] ;
                    $tax_total = zen_round($tax_total, $decimal);
                    $tax_total = $tax_total / $currencies_value;
                    $set_info['tax'] += $tax_total;
//                }

                //税后价
                $products_total_tax = zen_add_tax($aftertax_price, $set_pro[$index]['tax']);
                $products_total_tax = zen_round($products_total_tax * $currencies_value,$decimal) * $set_pro[$index]['qty'];
                $products_total_tax = zen_round($products_total_tax,$decimal);
                $shown_price_tax = $products_total_tax / $currencies_value;

                $set_info['subtotal'] += $shown_price;
                $set_info['aftertax_subtotal'] += $shown_price_tax;

                $this->notify('NOTIFIY_ORDER_CART_SUBTOTAL_CALCULATE', array('shown_price' => $shown_price));
                $products_tax = $set_pro[$index]['tax'];
                $products_tax_description = $set_pro[$index]['tax_description'];

                if (DISPLAY_PRICE_WITH_TAX == 'true') {

                    // calculate the amount of tax "inc"luded in price (used if tax-in pricing is enabled)

                    $tax_add = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));

                } else {

                    $tax_add = ($products_tax / 100) * $shown_price;

                }

                $set_info['tax'] += $tax_add;

                foreach ($taxRates as $taxDescription => $taxRate) {

                    $taxAdd = zen_calculate_tax($set_pro[$index]['final_price'] * $set_pro[$index]['qty'], $taxRate)

                        + zen_calculate_tax($set_pro[$index]['onetime_charges'], $taxRate);

                    if (isset($set_info['tax_groups'][$taxDescription])) {

                        $set_info['tax_groups'][$taxDescription] += $taxAdd;

                    } else {

                        $set_info['tax_groups'][$taxDescription] = $taxAdd;

                    }

                }

                /*********************************************
                 * END: Calculate taxes for this product
                 *********************************************/

                $index++;

            }
        }

        //注意改订单目前临时总价个是 当前订单+统一运费；后期运费功能上线后，这里要改变。临时使用 subtotal.
        $set_info['shipping_cost'] = zen_round(get_products_all_currency_final_price($set_info['shipping_cost'] * $currencies_value), $decimal) / $currencies_value;
        //税后运费
        $tax_shpping_cost = get_gsp_tax_price($this->delivery['country_id'], $set_info['shipping_cost']);
        $set_info['aftertax_shipping_cost'] = zen_round(get_products_all_currency_final_price($tax_shpping_cost * $currencies_value), $decimal) / $currencies_value;
        $this->info['shipping_cost'] = zen_round(get_products_all_currency_final_price($this->info['shipping_cost'] * $currencies_value), $decimal) / $currencies_value;

        if (DISPLAY_PRICE_WITH_TAX == 'true') {
            $set_info['total'] = $set_info['subtotal'] + $set_info['tax'] + $set_info['shipping_insurance'];
        } else {
            $set_info['total'] = $set_info['subtotal'] + $set_info['tax'] + $set_info['shipping_cost'] + $set_info['shipping_insurance'];
        }
    }

    /**
     * @Notes:
     * @param $products
     * @return array
     * @author: aron
     * @Date: 2020-12-18
     * @Time: 00:11
     */
    function creat_products_for_shopping_cart($products)
    {
        global $db;
        $index = 0;
        $data = [];
        if(isset($products)){

            for ($i = 0, $n = sizeof($products); $i < $n; $i++) {

                if (($i / 2) == floor($i / 2)) {

                    $rowClass = "rowEven";

                } else {

                    $rowClass = "rowOdd";

                }
                $paypal_price = $products[$i]['final_price'];
                $aftertax_price = get_gsp_tax_price($this->delivery['country_id'],$paypal_price);
                $data[$index] = array(
                    'qty' => $products[$i]['quantity'],

                    'name' => $products[$i]['name'],

                    'model' => $products[$i]['model'],

                    'price' => $products[$i]['price'],

                    'attributes_price' => $_SESSION['cart']->attributes_price($products[$i]['id']),

                    'products_price' => $products[$i]['products_price'],

                    'final_price' => $products[$i]['price'] + $_SESSION['cart']->attributes_price($products[$i]['id']),

                    'paypal_price' => $paypal_price,

                    'aftertax_price' => $aftertax_price,

                    'weight' => $products[$i]['weight'],

                    'products_priced_by_attribute' => $products[$i]['products_priced_by_attribute'],

                    'product_is_free' => $products[$i]['product_is_free'],

                    'products_discount_type' => $products[$i]['products_discount_type'],

                    'products_discount_type_from' => $products[$i]['products_discount_type_from'],

                    'id' => $products[$i]['id'],

                    'productImageSrc' => $products[$i]['image'],

                    'instock' => $products[$i]["instock"],

                    'relate_material_id' => $products[$i]["relate_material_id"],

                    'rowClass' => $rowClass,

                    'orders_number' => $products[$i]['orders_number']
                );

                if ($products[$i]['attributes']) {

                    $subindex = 0;

                    reset($products[$i]['attributes']);

                    while (list($option, $value) = each($products[$i]['attributes'])) {

                        if ($option != 'length') {

                            $attributes_query = "select popt.products_options_name, poval.products_options_values_name,

                                          pa.options_values_price, pa.price_prefix

                                   from " . TABLE_PRODUCTS_OPTIONS . " popt,

                                        " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval,

                                        " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                                   where pa.products_id = '" . (int)$products[$i]['id'] . "'

                                   and pa.options_id = '" . (int)$option . "'

                                   and pa.options_id = popt.products_options_id

                                   and pa.options_values_id = '" . (int)$value . "'

                                   and pa.options_values_id = poval.products_options_values_id

                                   and popt.language_id = '" . (int)$_SESSION['languages_id'] . "'

                                   and poval.language_id = '" . (int)$_SESSION['languages_id'] . "'";

                            $attributes = $db->Execute($attributes_query);

                            if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {

                                $attr_value = $products[$i]['attributes_values'][$option];

                            } else {

                                $attr_value = $attributes->fields['products_options_values_name'];

                            }

                            //attributes_file
                            $attributes_file = '';
                            if ($products[$i]['attributes_file'][$option]) {
                                $attributes_file = $products[$i]['attributes_file'][$option];
                            }

                            $data[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options_name'],

                                'value' => $attr_value,

                                'option_id' => $option,

                                'value_id' => $value,

                                'prefix' => $attributes->fields['price_prefix'],

                                'price' => $attributes->fields['options_values_price'],

                                'attributes_file' => $attributes_file
                            );

                        } else {
                            $list = $db->getAll("select price_prefix,length from products_length where
                            product_id = '" . (int)$products[$i]['id'] . "' and id ='" . (int)$value . "'");
                            if ($list) {
                                //通过长度 实时获取价格
                                $priceArr = get_length_range_price((int)$products[$i]['id'], $list[0]['length']);
                                $length_price = $priceArr['length_price'];

                                $data[$index]['attributes'][$subindex] = array(

                                    'option' => $list[0]['length'],

                                    'value' => 'length',

                                    'value_id' => $value,

                                    'prefix' => $list[0]['price_prefix'],

                                    'price' => $length_price);

                            }

                        }
                        $subindex++;
                    }

                }

                $index++;

            }
        }
        return $data;
    }

    /**
     * add by aron
     * filter 开启后会判断整单是否有库存
     * 判断产品是否有重货类
     * @param $products
     * @param bool $filter
     * @return bool
     */
    function fs_is_bulk_fiber($products, $filter = false)
    {
        $status = false;
        $products = array_map("intval", $products);
        $no_free_products = array(18015, 18016, 18013, 18000, 29669, 35858, 29032, 14101, 72480, 72752, 71024, 74124, 72448, 28952, 72753);
        $other_no_free_products = array();
        if (in_array($this->local_warehouse, array(3, 40, 20))) {
            $no_free_products = array_merge($no_free_products, array(18544, 58708, 18543, 69075, 58727));
            if (in_array($this->local_warehouse, array(3, 40))) {
                $no_free_products = array_merge([72020], $no_free_products);
            }
        }
        $products = array_diff($products, $no_free_products);
        if (!empty($products)) {
            foreach ($products as $key => $v) {
                if (in_array($v, array(72012, 72023, 72500, 72012, 72022, 31922))) {
                    if ($filter) {
                        $this->heavy_products[] = $v;
                    }
                    $status = true;
                    if (!$filter) {
                        break;
                    }
                }
                if (!empty($other_no_free_products) && in_array($v, $other_no_free_products)) {
                    if ($filter) {
                        $this->heavy_products[] = $v;
                    }
                    $status = true;
                    if (!$filter) {
                        break;
                    }
                }
                if (fs_zen_get_product_category_id($v, array(13, 17, 16, 1155, 1148, 2907, 900, 3093, 2969, 3059, 3260, 3319, 996, 3313, 1134, 1133, 3073, 633, 3253)) || zen_product_in_category($v, 3319) || zen_product_in_category($v, 573)) {
                    if ($filter) {
                        $this->heavy_products[] = $v;
                    }
                    $status = true;
                    if (!$filter) {
                        break;
                    }
                }
            }
        }
        return $status;
    }

    /**
     * add by aron
     * 更新运费自提信息
     * @param $order_id
     * @param $shipping
     */
    function update_pick_info($order_id, $shipping)
    {
        if (!empty($shipping) && $shipping['id'] == 'selfreferencezones_selfreferencezones') {
            $photo_name = $shipping['pick_info']['photo_name'];
            $pick_email = $shipping['pick_info']["pick_email"];
            $pick_phone = $shipping['pick_info']['pick_phone'];
            $pick_time = $shipping['pick_info']['pick_time'];
            $sql_data_array = array(
                "photo_name" => $photo_name,
                "order_id" => $order_id,
                "email_address" => $pick_email,
                "phone" => $pick_phone,
                'pick_time' => $pick_time
            );
            if (!empty($photo_name) && !empty($pick_email) && !empty($pick_phone) && !empty($pick_time)) {
                zen_db_perform('order_pickbyself_info', $sql_data_array);
            }
        }
    }

    /**
     * add by rebirth
     * 2019-08-13
     * @param $zf_ot_modules 订单总价
     * @param $order_total
     * @return int 返回主单 id
     */
    function create_order_new($zf_ot_modules, $order_total, $insertData = "")
    {
        //订单生成流程
        $this->insertData = $insertData;
        $main_id = $this->create_order_new_main_PLEASE_NOT_CHANGE($zf_ot_modules, $order_total);
        //订单超时未支付流程
        orders_overtime($main_id, $this->info['payment_module_code']);
        //$this->update_order_company_number($main_id);
        $this->insert_ns_orders($main_id);

        $this->insert_billing_address_init_date($main_id);
//        orders_overtime($main_id, 1);

        if ($this->customer['customers_number_new']) {
            $this->update_tax_sale($this->customer['customers_number_new']);
        }
        $this->createSgTicketNumber($main_id);
        send_app_message($main_id, $_SESSION['customer_id'], 1);
        return $main_id;
    }

    /**
     * add by aron
     * 美国和德国 仓会存在赠品单
     *
     * @param $zf_ot_modules 订单总价
     * @param $order_total
     * @return int  返回主单 id
     */
    function create_order_new_main_PLEASE_NOT_CHANGE($zf_ot_modules, $order_total, $data = "")
    {
        $order_info = $this->get_order_num();
        $order_num = $order_info['num'];
        $order_data = $order_info['data'];
        $global_warehouse = 2;
        $local_warehouse = $this->local_warehouse;
        $country_code = $this->delivery['country']["iso_code_2"];
        //生成1单
        $zf_ot_modules = $this->createTotal('all');
        $zf_ot_modules_tax = [];
        if($country_code == 'AU') {
            $zf_ot_modules_tax = $this->createTotalTax('all');
        }

        if ($order_num == 1) {
            switch ($this->local_warehouse) {
                case 40:
                case 71:
                    switch ($order_data) {
                        case "local":
                            $local_total = $this->createTotal("local");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $is_reissue = $this->local_warehouse == 40 ? 12 : 24;

                            $local_id = $this->_create_order_new($local_total, 0, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse, $is_reissue);
                            if ($is_reissue == 24 && isset($this->insertData['install'])) {
                                $install = new SGInstallerServiceClass();
                                $productsId = explode(",", $this->insertData['install']['localInstall']);
                                $installTime = $this->insertData['install']['installTime'];
                                $data['start_time'] = $installTime;
                                //$install->insertByOrder($local_id,$data,$productsId,$_SESSION['customer_id']);
                            }
                            return $local_id;
                            break;
                        case "delay":
                            $delay_total = $this->createTotal("delay");
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $is_reissue = 14;
                            $is_reissue = $this->local_warehouse == 40 ? 14 : 25;

                            $delay_id = $this->_create_order_new($delay_total, 0, $this->delay_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $global_warehouse, $is_reissue);
                            return $delay_id;
                            break;
                        case "global":
                            $global_total = $this->createTotal("global");
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $is_reissue = 15;
                            $global_id = $this->_create_order_new($global_total, 0, $this->global_info, $is_reissue, $global_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $global_warehouse, $is_reissue);
                            return $global_id;
                            break;
                    }
                    break;
                case 37:
                    switch ($order_data) {
                        case "local":
                            $local_total = $this->createTotal("local");
                            $local_total_tax = $this->createTotalTax("local");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $is_reissue = 9;
                            $local_id = $this->_create_order_new($local_total, 0, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info'], $local_total_tax);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse, $is_reissue);
                            return $local_id;
                            break;
                        case "delay":
                            $delay_total = $this->createTotal("delay");
                            $delay_total_tax = $this->createTotalTax("delay");
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $is_reissue = 10;
                            $current_warehouse = $local_warehouse;
                            if ($country_code == "NZ") {
                                $is_reissue = 11;
                                $current_warehouse = $global_warehouse;
                            }
                            $delay_id = $this->_create_order_new($delay_total, 0, $this->delay_info, $is_reissue, $current_warehouse, $session_shipping_delay, $_SESSION['customzones_info'], $delay_total_tax);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse, $is_reissue);
                            return $delay_id;
                            break;
                        case "global":
                            $global_total = $this->createTotal("global");
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $is_reissue = 18;
                            $global_id = $this->_create_order_new($global_total, 0, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse, $is_reissue);
                            return $global_id;
                            break;
                    }
                    break;
                case 20:
                    switch ($order_data) {
                        case "local":
                            $local_total = $this->createTotal("local");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $is_reissue = 6;
                            $local_id = $this->_create_order_new($local_total, 0, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse, $is_reissue);
                            return $local_id;
                            break;
                        case "delay":
                            $delay_total = $this->createTotal("delay");
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $is_reissue = 8;
                            $current_warehouse = $local_warehouse;
//                            if ($this->is_buck) {
//                                $is_reissue = 7;
//                                $current_warehouse = $global_warehouse;
//                            }
                            $delay_id = $this->_create_order_new($delay_total, 0, $this->delay_info, $is_reissue, $current_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse, $is_reissue);
                            return $delay_id;
                            break;
                        case "global":
                            $global_total = $this->createTotal("global");
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $is_reissue = 20;
                            $global_id = $this->_create_order_new($global_total, 0, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse, $is_reissue);
                            return $global_id;
                            break;
                    }
                    break;
                case 2:
                    switch ($order_data) {
                        case "local":
                            $local_total = $this->createTotal("local");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $is_reissue = $country_code == 'RU' ? 27 : 4;
                            $local_id = $this->_create_order_new($local_total, 0, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                            return $local_id;
                            break;
                        case "delay":
                            $delay_total = $this->createTotal("delay");
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $is_reissue = $country_code == 'RU' ? 27 : 5;
                            $delay_id = $this->_create_order_new($delay_total, 0, $this->delay_info, $is_reissue, $local_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $local_warehouse,$is_reissue);
                            return $delay_id;
                            break;
                        case "global":
                            $global_total = $this->createTotal("global");
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $is_reissue = $country_code == 'RU' ? 27 : 21;
                            $global_id = $this->_create_order_new($global_total, 0, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            return $global_id;
                            break;
                    }
                    break;
                case 67:
                    switch ($order_data) {
                        case "local":
                            $local_total = $this->createTotal("local");
                            $local_total_tax = $this->createTotalTax("local");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $is_reissue = 26;
                            $local_id = $this->_create_order_new($local_total, 0, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info'], $local_total_tax);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse, $is_reissue);
                            return $local_id;
                            break;
                        case "delay":
                            $delay_total = $this->createTotal("delay");
                            $delay_total_tax = $this->createTotalTax("delay");
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $is_reissue = 28;
                            $current_warehouse = $local_warehouse;
                            $delay_id = $this->_create_order_new($delay_total, 0, $this->delay_info, $is_reissue, $current_warehouse, $session_shipping_delay, $_SESSION['customzones_info'], $delay_total_tax);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse, $is_reissue);
                            return $delay_id;
                            break;
                        case "global":
                            $global_total = $this->createTotal("global");
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $is_reissue = 28;
                            $global_id = $this->_create_order_new($global_total, 0, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse, $is_reissue);
                            return $global_id;
                            break;
                    }
                    break;
            }
        } elseif ($order_num == 2) {
            //生成主单
            $main_id = $this->create($zf_ot_modules,2,$zf_ot_modules_tax);
            switch ($this->local_warehouse) {
                case 40:
                case 71:
                    switch ($order_data) {
                        case "local-delay":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $local_total = $this->createTotal("local");
                            $delay_total = $this->createTotal("delay");

                            //12 美东 海外直发单
                            $is_reissue = $this->local_warehouse == 40 ? 12 : 24;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                            if ($is_reissue == 24 && isset($this->insertData['install'])) {
                                $install = new SGInstallerServiceClass();
                                $productsId = explode(",", $this->insertData['install']['localInstall']);
                                $installTime = $this->insertData['install']['installTime'];
                                $data['start_time'] = $installTime;
                                //$install->insertByOrder($local_id,$data,$productsId,$_SESSION['customer_id']);
                            }

                            //14 国内直发
                            $is_reissue = $this->local_warehouse == 40 ? 14 : 25;
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $global_warehouse,$is_reissue);
                            break;
                        case "local-global":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $local_total = $this->createTotal("local");
                            $global_total = $this->createTotal("global");

                            //12 美东 海外直发单
                            $is_reissue = 12;
                            $is_reissue = $this->local_warehouse == 40 ? 12 : 24;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                            //美东预售产品15
                            $is_reissue = 15;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $global_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $global_warehouse,$is_reissue);
                            break;
                        case "delay-global":
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $delay_total = $this->createTotal("delay");
                            $global_total = $this->createTotal("global");

                            //14 国内直发
                            $is_reissue = $this->local_warehouse == 40 ? 14 : 25;
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $global_warehouse,$is_reissue);
                            //预售产品15
                            $is_reissue = 15;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $global_warehouse,$is_reissue);
                            break;
                        case "local-gift":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_gift = $_SESSION['shipping_gift'];
                            $local_total = $this->createTotal("local");
                            $gift_total = $this->createTotal("gift");

                            //12 美东 海外直发单
                            $is_reissue = $this->local_warehouse == 40 ? 12 : 24;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            //赠品单
                            $is_reissue = 22;
                            $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                            $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                            break;
                        case "delay-gift":
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $session_shipping_gift = $_SESSION['shipping_gift'];
                            $delay_total = $this->createTotal("delay");
                            $gift_total = $this->createTotal("gift");

                            //14 国内直发
                            $is_reissue = $this->local_warehouse == 40 ? 14 : 25;
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $global_warehouse,$is_reissue);

                            //赠品单 22
                            $is_reissue = 22;
                            $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                            $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                            break;

                        case "global-gift":
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $global_total = $this->createTotal("global");
                            $gift_total = $this->createTotal("gift");
                            $session_shipping_gift = $_SESSION['shipping_gift'];

                            //美东预售产品15
                            $is_reissue = 15;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $global_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $global_warehouse,$is_reissue);

                            //赠品单 22
                            $is_reissue = 22;
                            $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                            $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                            break;

                    }
                    break;
                case 37:
                    switch ($order_data) {
                        case "local-delay":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $local_total = $this->createTotal("local");
                            $delay_total = $this->createTotal("delay");
                            $local_total_tax = $this->createTotalTax("local");
                            $delay_total_tax = $this->createTotalTax("delay");

                            $is_reissue = 9;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info'], $local_total_tax);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            $is_reissue = 10;
                            //判断是否重货类
                            $shipping = $session_shipping_local;
                            $current_warehouse = $local_warehouse;
                            if ($country_code == "NZ") {
                                $is_reissue = 11;
                                $shipping = $session_shipping_delay;
                                $current_warehouse = $global_warehouse;
                            }

                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $shipping, $_SESSION['customzones_info'], $delay_total_tax);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);
                            break;
                        case "local-global":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $local_total = $this->createTotal("local");
                            $global_total = $this->createTotal("global");

                            $is_reissue = 9;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            $is_reissue = 18;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            break;
                        case "delay-global":
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $session_shipping_global = $_SESSION['shipping_global'];

                            $delay_total = $this->createTotal("delay");
                            $global_total = $this->createTotal("global");
                            $is_reissue = 10;
                            $shipping_global = $session_shipping_global;
                            $current_warehouse = $local_warehouse;
                            if ($this->is_buck || $country_code == "NZ") {
                                $is_reissue = 11;
                                $shipping_global = $session_shipping_delay;
                                $current_warehouse = $global_warehouse;
                            }
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);

                            $is_reissue = 18;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            break;
                    }
                    break;
                case 20:
                    switch ($order_data) {
                        case "local-delay":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $local_total = $this->createTotal("local");
                            $delay_total = $this->createTotal("delay");
                            $is_reissue = 6;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            $is_reissue = 8;
                            $current_warehouse = $this->local_warehouse;
                            //判断是否重货类
                            $shipping = $session_shipping_local;
                            if ($this->is_buck) {
//                                $is_reissue = 7;
//                                $current_warehouse = $this->global_warehouse;
                                $shipping = $session_shipping_delay;
                            }
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $shipping, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);
                            break;
                        case "local-global":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $local_total = $this->createTotal("local");
                            $global_total = $this->createTotal("global");

                            $is_reissue = 6;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            $is_reissue = 20;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            break;
                        case "delay-global":
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $session_shipping_global = $_SESSION['shipping_global'];

                            $delay_total = $this->createTotal("delay");
                            $global_total = $this->createTotal("global");

                            $is_reissue = 8;
                            $shipping_global = $session_shipping_global;
                            $current_warehouse = $local_warehouse;
                            if ($this->is_buck) {
                                $is_reissue = 7;
                                $shipping_global = $session_shipping_delay;
                                $current_warehouse = $global_warehouse;
                            }
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);

                            $is_reissue = 20;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            break;
                        case "local-gift":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_gift = $_SESSION['shipping_gift'];
                            $local_total = $this->createTotal("local");
                            $gift_total = $this->createTotal("gift");
                            $is_reissue = 6;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            //生成 赠品单
                            $is_reissue = 23;
                            $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                            $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                            break;
                        case "delay-gift":
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $delay_total = $this->createTotal("delay");
                            $is_reissue = 8;
                            $current_warehouse = $local_warehouse;
                            if ($this->is_buck) {
                                $is_reissue = 7;
                                $current_warehouse = $global_warehouse;
                            }
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);

                            //生成赠品单
                            $gift_total = $this->createTotal("gift");
                            $session_shipping_gift = $_SESSION['shipping_gift'];
                            $is_reissue = 23;
                            $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                            $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                            break;
                        case "global-gift":
                            $session_shipping_global = $_SESSION['shipping_global'];
                            $global_total = $this->createTotal("global");
                            $is_reissue = 20;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_global, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);

                            //生成赠品单
                            $gift_total = $this->createTotal("gift");
                            $session_shipping_gift = $_SESSION['shipping_gift'];
                            $is_reissue = 23;
                            $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                            $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                            break;
                    }
                    break;
                case 2:
                    switch ($order_data) {
                        case "local-delay":
                            $local_total = $this->createTotal("local");
                            $delay_total = $this->createTotal("delay");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            //国内先发
                            $is_reissue = $country_code == 'RU' ? 27 : 4;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                            //国内补发
                            $is_reissue = $country_code == 'RU' ? 27 : 5;
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $local_warehouse,$is_reissue);
                            break;
                        case "local-global":
                            $local_total = $this->createTotal("local");
                            $global_total = $this->createTotal("global");
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $is_reissue = $country_code == 'RU' ? 27 : 4;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                            //国内预售产品
                            $is_reissue = $country_code == 'RU' ? 27 : 21;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            break;
                        case "delay-global":
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            //国内补发
                            $delay_total = $this->createTotal("delay");
                            $global_total = $this->createTotal("global");
                            $is_reissue = $country_code == 'RU' ? 27 : 5;
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $local_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $local_warehouse,$is_reissue);
                            //国内预售产品
                            $is_reissue = $country_code == 'RU' ? 27 : 21;
                            $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);
                            $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                            break;
                    }
                    break;
                case 67:
                    switch ($order_data) {
                        case "local-delay":
                            $session_shipping_local = $_SESSION['shipping_local'];
                            $session_shipping_delay = $_SESSION['shipping_delay'];
                            $local_total = $this->createTotal("local");
                            $delay_total = $this->createTotal("delay");
                            $local_total_tax = $this->createTotalTax("local");
                            $delay_total_tax = $this->createTotalTax("delay");

                            $is_reissue = 26;
                            $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info'], $local_total_tax);
                            $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);

                            $is_reissue = 28;
                            //判断是否重货类
                            $shipping = $session_shipping_local;
                            $current_warehouse = $local_warehouse;
                            $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $shipping, $_SESSION['customzones_info'], $delay_total_tax);
                            $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);
                            break;
                    }
                    break;
            }
            return $main_id;
        } else {
            //生成4单 or 3单
            switch ($this->local_warehouse) {
                //美东仓
                case 40:
                case 71:
                    $session_shipping_local = $_SESSION['shipping_local'];
                    $session_shipping_delay = $_SESSION['shipping_delay'];
                    //生成主单
                    $main_id = $this->create($zf_ot_modules);
                    //12 美东国内直发,海外直发单
                    if (!empty($this->local_products)) {
                        $local_total = $this->createTotal("local");
                        $is_reissue = $this->local_warehouse == 40 ? 12 : 24;
                        $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);

                        $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                    }

                    //14 国内直发
                    if (!empty($this->delay_products)) {
                        $is_reissue = 14;
                        $is_reissue = $this->local_warehouse == 40 ? 14 : 25;
                        $delay_total = $this->createTotal("delay");
                        $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);

                        $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $global_warehouse,$is_reissue);
                    }

                    //预售产品,国内直发
                    if (!empty($this->global_products)) {
                        $is_reissue = 15;
                        $global_total = $this->createTotal("global");
                        $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $global_warehouse, $session_shipping_delay, $_SESSION['customzones_info']);

                        $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $global_warehouse,$is_reissue);
                    }

                    //赠品
                    if (!empty($this->gift_products)) {
                        $is_reissue = 22;
                        $gift_total = $this->createTotal('gift');
                        $session_shipping_gift = $_SESSION['shipping_gift'];
                        $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                        $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                    }
                    break;
                //澳大利亚仓
                case 37:
                    $session_shipping_local = $_SESSION['shipping_local'];
                    $session_shipping_delay = $_SESSION['shipping_delay'];
                    $session_shipping_global = $_SESSION['shipping_global'];

                    //生成主单
                    $main_id = $this->create($zf_ot_modules);
                    $local_total = $this->createTotal("local");
                    $delay_total = $this->createTotal("delay");
                    $global_total = $this->createTotal("global");
                    //9 澳大利亚海外直发
                    $is_reissue = 9;
                    $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);

                    $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                    //10 澳大利亚转运
                    $is_reissue = 10;
                    $shipping = $session_shipping_local;
                    $current_warehouse = $local_warehouse;
                    $shipping_global = $session_shipping_global;
                    //判断是否有重货类
                    if ($this->is_buck || $country_code == "NZ") {
                        //国内直发
                        $is_reissue = 11;
                        $shipping = $session_shipping_delay;
                        $current_warehouse = $global_warehouse;
                        $shipping_global = $session_shipping_delay;
                    }
                    $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $shipping, $_SESSION['customzones_info']);

                    $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);
                    //预售产品 澳大利亚转运
                    $is_reissue = 18;
                    $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $shipping_global, $_SESSION['customzones_info']);
                    $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                    break;
                case 20:
                    //德国仓
                    $session_shipping_local = $_SESSION['shipping_local'];
                    $session_shipping_delay = $_SESSION['shipping_delay'];
                    $session_shipping_global = $_SESSION['shipping_global'];
                    $shipping_global = $session_shipping_global;
                    //生成主单
                    $main_id = $this->create($zf_ot_modules);

                    $current_warehouse = $local_warehouse;
                    //6 德国仓海外先发
                    if (!empty($this->local_products)) {
                        $local_total = $this->createTotal("local");
                        $is_reissue = 6;
                        $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                        $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                    }
                    //德国转运
                    if (!empty($this->delay_products)) {
                        $delay_total = $this->createTotal("delay");
                        $is_reissue = 8;
                        $shipping = $session_shipping_local;
                        //判断是否有重货类
                        if ($this->is_buck) {
                            //国内直发
                            $is_reissue = 7;
                            $shipping = $session_shipping_delay;
                            $current_warehouse = $global_warehouse;
                            $shipping_global = $session_shipping_delay;
                        }
                        $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $current_warehouse, $shipping, $_SESSION['customzones_info']);
                        $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $current_warehouse,$is_reissue);
                    }
                    //预售产品 德国转运
                    if (!empty($this->global_products)) {
                        $global_total = $this->createTotal("global");
                        $is_reissue = 20;

                        $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $shipping_global, $_SESSION['customzones_info']);
                        $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                    }
                    //赠品
                    if (!empty($this->gift_products)) {
                        $is_reissue = 23;
                        $gift_total = $this->createTotal('gift');
                        $session_shipping_gift = $_SESSION['shipping_gift'];
                        $gift_id = $this->_create_order_new($gift_total, $main_id, $this->gift_info, $is_reissue, $local_warehouse, $session_shipping_gift, $_SESSION['customzones_info']);
                        $this->create_add_products_new($gift_id, $zf_mode = false, $this->gift_products, $local_warehouse,$is_reissue);
                    }
                    break;
                case 2:
                    //中国仓
                    $session_shipping_local = $_SESSION['shipping_local'];
                    //生成主单
                    $main_id = $this->create($zf_ot_modules);
                    $local_total = $this->createTotal("local");
                    $delay_total = $this->createTotal("delay");
                    $global_total = $this->createTotal("global");

                    //国内单先发
                    $is_reissue = $country_code == 'RU' ? 27 : 4;

                    $local_id = $this->_create_order_new($local_total, $main_id, $this->local_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                    $this->create_add_products_new($local_id, $zf_mode = false, $this->local_products, $local_warehouse,$is_reissue);
                    //国内补发
                    $is_reissue = $country_code == 'RU' ? 27 : 5;
                    $delay_id = $this->_create_order_new($delay_total, $main_id, $this->delay_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);

                    $this->create_add_products_new($delay_id, $zf_mode = false, $this->delay_products, $local_warehouse,$is_reissue);
                    //国内预售产品
                    $is_reissue = $country_code == 'RU' ? 27 : 21;
                    $global_id = $this->_create_order_new($global_total, $main_id, $this->global_info, $is_reissue, $local_warehouse, $session_shipping_local, $_SESSION['customzones_info']);
                    $this->create_add_products_new($global_id, $zf_mode = false, $this->global_products, $local_warehouse,$is_reissue);
                    break;

            }

            return $main_id;
        }
    }

    /**
     * add by aron
     * 为每一单生成 运费 总价 税收等信息
     * @param $order_tag 获取指定订单 运费总价税收等信息 标识
     * @return array
     */
    function createTotal($order_tag)
    {
        global $currencies;
        $info = array();
        $country_code = $this->delivery['country']["iso_code_2"];
        $point = $currencies->currencies[$this->info['currency']]['decimal_places'];
        $symbol_left = $currencies->currencies[$this->info['currency']]['symbol_left'];
        $symbol_right = $currencies->currencies[$this->info['currency']]['symbol_right'];
        $order_info = $this->get_order_num();
        $num = $order_info['num'];
        $order_origin_data = $order_data = $order_info['data'];
        //汇率转化后价格
        $total_shipping = $currencies->total_format_new($this->info['shipping_cost'], true, $this->info['currency'], $this->info['currency_value']);
        if ($this->local_warehouse == 40) {
            $total_vat = $this->vat;
        } else {
            $total_vat = $currencies->total_format_new($this->vat, true, $this->info['currency'], $this->info['currency_value']);
        }

        $total_insurance = $currencies->total_format_new($this->insurance, true, $this->info['currency'], $this->info['currency_value']);
        $total = $currencies->total_format_new($this->info['subtotal'], true, $this->info['currency'], $this->info['currency_value']) + $total_shipping + $total_vat + $total_insurance;
        $subtotal = $currencies->total_format_new($this->info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
        //带货币符号价格
        $total_shipping_text = $symbol_left . $currencies->fs_format_number($total_shipping) . " " . $symbol_right;
        $total_vat_text = $symbol_left . $currencies->fs_format_number($total_vat) . " " . $symbol_right;
        $total_insurance_text = $symbol_left . $currencies->fs_format_number($total_insurance) . " " . $symbol_right;
        $subtotal_text = $symbol_left . $currencies->fs_format_number($subtotal) . " " . $symbol_right;
        $total_text = $symbol_left . $currencies->fs_format_number($total) . " " . $symbol_right;
        //美元价格
        $total_value = $total / $this->info['currency_value'];
        $total_shipping_value = $total_shipping / $this->info['currency_value'];
        $total_vat_value = $total_vat / $this->info['currency_value'];
        $total_insurance_value = $total_insurance / $this->info['currency_value'];

        $local_vat = 0;
        $delay_vat = 0;
        $global_vat = 0;

        $order_tag_arr = ['local-gift' => 'local', 'delay-gift' => 'delay', 'global-gift' => 'global', 'local-delay-gift' => 'local-delay',
            'local-global-gift' => 'local-global', 'delay-global-gift' => 'delay-global', 'local-delay-global-gift' => 'local-delay-global'];
        if (isset($order_tag_arr[$order_data])) {
            $order_data = $order_tag_arr[$order_data];
            $num = count(explode("-", $order_data));
        }

        //汇率转换后的运费
        switch ($num) {
            case 1 :
                $info[$order_tag] = [
                    [
                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                        'text' => $total_text,

                        'value' => (is_numeric($total_value)) ? $total_value : '0',

                        'code' => 'ot_total',

                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                        'text' => $total_shipping_text,

                        'value' => (is_numeric($total_shipping_value)) ? $total_shipping_value : '0',

                        'code' => 'ot_shipping',

                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                        'text' => $subtotal_text,

                        'value' => (is_numeric($this->info['subtotal'])) ? $this->info['subtotal'] : '0',

                        'code' => 'ot_subtotal',

                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                    ],
                ];
                if ($this->is_vax) {
                    $info[$order_tag][] = [
                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                        'text' => $total_vat_text,

                        'value' => (is_numeric($total_vat_value)) ? $total_vat_value : '0',

                        'code' => 'ot_tax',

                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                    ];
                }

                if ($this->insurance) {
                    $info[$order_tag][] = [
                        'title' => MODULE_ORDER_TOTAL_INSURANCE_TITLE,

                        'text' => $total_insurance_text,

                        'value' => (is_numeric($total_insurance_value)) ? $total_insurance_value : '0',

                        'code' => 'ot_insurance',

                        'sort_order' => MODULE_ORDER_TOTAL_INSURANCE_SORT_ORDER
                    ];
                }

                break;
            case 2 :
                switch ($order_data) {
                    case "local-delay":
                        //汇率转化后价格
                        $local_subtotal = $currencies->total_format_new($this->local_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        $delay_subtotal = $currencies->total_format_new($this->delay_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        switch ($this->local_warehouse) {
                            case 40:
                            case 71:
                                //汇率转化后价格
                                $local_shipping_cost = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                $delay_shipping_cost = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);

                                $local_total = $local_subtotal + $local_shipping_cost;
                                $delay_total = $delay_subtotal + $delay_shipping_cost;

                                if ($this->local_warehouse == 71) {
                                    $delay_total += $total_insurance;
                                }

                                $local_total_value = $local_total / $this->info['currency_value'];
                                $delay_total_value = $delay_total / $this->info['currency_value'];
                                if ($this->is_vax && $this->local_warehouse == 71) {
                                    $vax = 7;
                                    $local_vat = 0;
                                    if (!empty($this->local_products)) {
                                        $local_vat = zen_round((($local_shipping_cost + $local_subtotal) * $vax) / 100, $point);
                                    }
                                    $local_total = $local_total + $local_vat;

                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                                    $local_total_value += $local_vat_value;
                                }
                                if ($this->is_vax && $this->local_warehouse == 40) {
                                    //美国税率是汇率转换后价格
                                    $local_vat = $this->orderVat['local'] ? $this->orderVat['local'] : 0;
                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                                    $local_total_value += $local_vat_value;
                                    $local_total = $local_total + $local_vat;

                                    $delay_vat = $this->orderVat['delay'] ? $this->orderVat['delay'] : 0;
                                    $delay_total = $delay_total + $delay_vat;
                                    $delay_vat_value = $delay_vat / $this->info['currency_value'];
                                    $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                                    $delay_total_value += $delay_vat_value;
                                }

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                if ($this->is_vax) {

                                    $info["local"][] = [
                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $local_vat_text,

                                        'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                    if ($this->local_warehouse == 40) {
                                        $info["delay"][] = [
                                            'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                            'text' => $delay_vat_text,

                                            'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                            'code' => 'ot_tax',

                                            'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                        ];
                                    }
                                }

                                if ($this->insurance && $this->local_warehouse == 71) {
                                    $info['delay'][] = [
                                        'title' => MODULE_ORDER_TOTAL_INSURANCE_TITLE,

                                        'text' => $total_insurance_text,

                                        'value' => (is_numeric($total_insurance_value)) ? $total_insurance_value : '0',

                                        'code' => 'ot_insurance',

                                        'sort_order' => MODULE_ORDER_TOTAL_INSURANCE_SORT_ORDER
                                    ];
                                }

                                break;
                            case 20:
                            case 37:
                                //汇率转化后价格
                                $local_shipping_cost = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                if ($this->is_buck || $country_code == "NZ") {
                                    $delay_shipping_cost = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                } else {
                                    $total_weight = $this->local_info['total_weight'] + $this->delay_info['total_weight'];
                                    $weight_percent = zen_round($this->local_info['total_weight'] / $total_weight);
                                    $local_shipping_cost = zen_round($total_shipping * $weight_percent, $point);
                                    $delay_shipping_cost = $total_shipping - $local_shipping_cost;
                                    if ($local_shipping_cost < 10) {
                                        $local_shipping_cost = 0;
                                        $delay_shipping_cost = $total_shipping;
                                    }
                                }
                                if ($this->is_vax_de) {
                                    $vax = $this->vax_de;
                                } else {
                                    $vax = 10;
                                }

                                if($this->is_vax){
                                    $local_vat = zen_round((($local_shipping_cost + $local_subtotal) * $vax)/100,$point);
                                    if($country_code != 'NZ'){
                                        $delay_vat = $total_vat - $local_vat;
                                        $delay_vat_value = $delay_vat / $this->info['currency_value'];
                                        $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                                    }
                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                                }

                                $local_total = $local_subtotal + $local_shipping_cost + $local_vat;
                                $delay_total = $delay_subtotal + $delay_shipping_cost + $delay_vat;

                                $local_total_value = $local_total / $this->info['currency_value'];
                                $delay_total_value = $delay_total / $this->info['currency_value'];

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                if ($this->is_vax) {
                                    $info["local"][] = [
                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $local_vat_text,

                                        'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                    if(!$this->is_buck || $country_code != 'NZ'){
                                        $info["delay"][] = [
                                            'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                            'text' => $delay_vat_text,

                                            'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                            'code' => 'ot_tax',

                                            'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                        ];
                                    }
                                }
                                break;
                            case 2:
                                $total_weight = $this->local_info['total_weight'] + $this->delay_info['total_weight'];
                                $weight_percent = zen_round($this->local_info['total_weight'] / $total_weight, 2);
                                //汇率转化后价格
                                $local_shipping_cost = zen_round($total_shipping * $weight_percent, $point);
                                $delay_shipping_cost = $total_shipping - $local_shipping_cost;
                                if ($local_shipping_cost < 10) {
                                    $local_shipping_cost = 0;
                                    $delay_shipping_cost = $total_shipping;
                                }

                                if ($this->is_vax_cn) {
                                    $local_vat = zen_round(($local_subtotal * $this->vax_cn) / 100, $point);
                                    if ($country_code == "RU") {
                                        $local_vat = zen_round((($local_subtotal + $local_shipping_cost) * $this->vax_cn) / 100, $point);
                                    }
                                    $delay_vat = $total_vat - $local_vat;

                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $delay_vat_value = $delay_vat / $this->info['currency_value'];

                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                                    $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                                }

                                $local_total = $local_subtotal + $local_shipping_cost + $local_vat;
                                $delay_total = $delay_subtotal + $delay_shipping_cost + $delay_vat;

                                $local_total_value = $local_total / $this->info['currency_value'];
                                $delay_total_value = $delay_total / $this->info['currency_value'];

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;

                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                if ($this->is_vax_cn) {

                                    $info['local'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $local_vat_text,

                                        'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                    $info['delay'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $delay_vat_text,

                                        'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];
                                }

                                break;
                            case 67:
                                //汇率转化后价格
                                $local_shipping_cost = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                $delay_shipping_cost = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);

                                $vax = 20;
                                if ($this->is_vax) {
                                    $local_vat = zen_round((($local_shipping_cost + $local_subtotal) * $vax)/100,$point);

                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;

                                    $delay_vat = $total_vat - $local_vat;
                                    $delay_vat_value = $delay_vat / $this->info['currency_value'];
                                    $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                                }

                                $local_total = $local_subtotal + $local_shipping_cost + $local_vat;
                                $delay_total = $delay_subtotal + $delay_shipping_cost + $delay_vat;

                                $local_total_value = $local_total / $this->info['currency_value'];
                                $delay_total_value = $delay_total / $this->info['currency_value'];

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                if ($this->is_vax) {

                                    $info["local"][] = [
                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $local_vat_text,

                                        'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];
                                    $info["delay"][] = [
                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $delay_vat_text,

                                        'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                }
                                break;
                        }
                        break;
                    case  "local-global":
                        $local_subtotal = $currencies->total_format_new($this->local_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        $global_subtotal = $currencies->total_format_new($this->global_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        switch ($this->local_warehouse) {
                            case 40:
                                //汇率转化后价格
                                $local_shipping_cost = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                $global_shipping_cost = $currencies->total_format_new($this->global_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);

                                $local_total = $local_subtotal + $local_shipping_cost;
                                $global_total = $global_subtotal + $global_shipping_cost;

                                $local_total_value = $local_total / $this->info['currency_value'];
                                $global_total_value = $global_total / $this->info['currency_value'];

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;
                                $info['global'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $global_total_text,

                                        'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $global_shipping_cost_text,

                                        'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $global_subtotal_text,

                                        'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];
                                break;
                            case 20:
                            case 37:
                                //汇率转化后价格
                                $local_shipping_cost = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                $global_shipping_cost = $currencies->total_format_new($this->global_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);

                                if ($this->is_vax_de) {
                                    $vax = $this->vax_de;
                                } else {
                                    $vax = 10;
                                }

                                if ($this->is_vax) {
                                    $local_vat = zen_round((($local_shipping_cost + $local_subtotal) * $vax) / 100, $point);
                                    $global_vat = zen_round((($global_shipping_cost + $global_subtotal) * $vax) / 100, $point);;
                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $global_vat_value = $global_vat / $this->info['currency_value'];

                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                                    $global_vat_text = $symbol_left . $currencies->fs_format_number($global_vat) . " " . $symbol_right;

                                }

                                $local_total = $local_subtotal + $local_shipping_cost + $local_vat;
                                $global_total = $global_subtotal + $global_shipping_cost + $global_vat;


                                $local_total_value = $local_total / $this->info['currency_value'];
                                $global_total_value = $global_total / $this->info['currency_value'];

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;
                                $info['global'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $global_total_text,

                                        'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $global_shipping_cost_text,

                                        'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $global_subtotal_text,

                                        'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];


                                if ($this->is_vax) {
                                    $info["local"][] = [
                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $local_vat_text,

                                        'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                    if (!$this->is_buck) {
                                        $info["global"][] = [
                                            'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                            'text' => $global_vat_text,

                                            'value' => (is_numeric($global_vat_value)) ? $global_vat_value : '0',

                                            'code' => 'ot_tax',

                                            'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                        ];
                                    }
                                }
                                break;
                            case 2:
                                $local_subtotal = $currencies->total_format_new($this->local_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                                $global_subtotal = $currencies->total_format_new($this->global_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);

                                $total_weight = $this->local_info['total_weight'] + $this->global_info['total_weight'];
                                $weight_percent = zen_round($this->local_info['total_weight'] / $total_weight, 2);
                                //汇率转化后价格
                                $local_shipping_cost = zen_round($total_shipping * $weight_percent, $point);
                                $global_shipping_cost = $total_shipping - $local_shipping_cost;

                                if ($this->is_vax_cn) {
                                    $local_vat = zen_round(($local_subtotal * $this->vax_cn) / 100, $point);
                                    if ($country_code == "RU") {
                                        $local_vat = zen_round((($local_subtotal + $local_shipping_cost) * $this->vax_cn) / 100, $point);
                                    }
                                    $global_vat = $total_vat - $local_vat;

                                    $local_vat_value = $local_vat / $this->info['currency_value'];
                                    $global_vat_value = $global_vat / $this->info['currency_value'];

                                    $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                                    $global_vat_text = $symbol_left . $currencies->fs_format_number($global_vat) . " " . $symbol_right;
                                }

                                $local_total = $local_subtotal + $local_shipping_cost + $local_vat;
                                $global_total = $global_subtotal + $global_shipping_cost + $global_vat;

                                $local_total_value = $local_total / $this->info['currency_value'];
                                $global_total_value = $global_total / $this->info['currency_value'];

                                $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                                $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];

                                $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                                $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;

                                $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                                $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;

                                $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                                $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;

                                $info['global'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $global_total_text,

                                        'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $global_shipping_cost_text,

                                        'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $global_subtotal_text,

                                        'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['local'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $local_total_text,

                                        'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $local_shipping_cost_text,

                                        'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $local_subtotal_text,

                                        'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                if ($this->is_vax_cn) {

                                    $info['local'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $local_vat_text,

                                        'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                    $info['global'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $global_vat_text,

                                        'value' => (is_numeric($global_vat_value)) ? $global_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];
                                }
                                break;
                        }
                        break;
                    case "delay-global":
                        $delay_subtotal = $currencies->total_format_new($this->delay_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        $global_subtotal = $currencies->total_format_new($this->global_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        switch ($this->local_warehouse) {
                            case 40:
                                //汇率转化后价格
                                $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                                $percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                                $delay_shipping_cost = zen_round($total_shipping * $percent, $point);
                                $global_shipping_cost = $total_shipping - $delay_shipping_cost;
                                if ($_SESSION['shipping_delay']['id'] == "fedexiezones_fedexiezones") {
                                    $delay_shipping_cost_trans = 0;
                                    $global_shipping_cost_trans = 0;
                                    if ($this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                        $global_shipping_cost_trans = 0;
                                        $delay_shipping_cost_trans = 0;
                                    } elseif ($this->global_info['is_shipping_free'] && !$this->delay_info['is_shipping_free']) {
                                        $global_shipping_cost_trans = 0;
                                        $delay_shipping_cost_trans = $total_shipping;
                                    } elseif (!$this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                        $global_shipping_cost_trans = $total_shipping;
                                        $delay_shipping_cost_trans = 0;
                                    }
                                    $total_trans = $global_shipping_cost_trans + $delay_shipping_cost_trans;
                                    if ($total_trans == $total_shipping) {
                                        $delay_shipping_cost = $delay_shipping_cost_trans;
                                        $global_shipping_cost = $global_shipping_cost_trans;
                                    }
                                }

                                $global_total = $global_subtotal + $global_shipping_cost;
                                $delay_total = $delay_subtotal + $delay_shipping_cost;

                                $global_total_value = $global_total / $this->info['currency_value'];
                                $delay_total_value = $delay_total / $this->info['currency_value'];

                                $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];
                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                                $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;
                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                                $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;
                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                                $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;
                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['global'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $global_total_text,

                                        'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $global_shipping_cost_text,

                                        'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $global_subtotal_text,

                                        'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];
                                break;
                            case 20:
                            case 37:
                                //汇率转化后价格
                                $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                                $percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                                if ($this->is_buck || $country_code == "NZ") {
                                    $shipping_delay_global = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                    $delay_shipping_cost = zen_round($shipping_delay_global * $percent, $point);
                                    $global_shipping_cost = $shipping_delay_global - $delay_shipping_cost;
                                    if ($_SESSION['shipping_delay']['id'] == "fedexiezones_fedexiezones") {
                                        $delay_shipping_cost_trans = 0;
                                        $global_shipping_cost_trans = 0;
                                        if ($this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                            $global_shipping_cost_trans = 0;
                                            $delay_shipping_cost_trans = 0;
                                        } elseif ($this->global_info['is_shipping_free'] && !$this->delay_info['is_shipping_free']) {
                                            $global_shipping_cost_trans = 0;
                                            $delay_shipping_cost_trans = $shipping_delay_global;
                                        } elseif (!$this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                            $global_shipping_cost_trans = $shipping_delay_global;
                                            $delay_shipping_cost_trans = 0;
                                        }
                                        $total_trans = $global_shipping_cost_trans + $delay_shipping_cost_trans;
                                        if ($total_trans == $shipping_delay_global) {
                                            $delay_shipping_cost = $delay_shipping_cost_trans;
                                            $global_shipping_cost = $global_shipping_cost_trans;
                                        }
                                    }
                                } else {
                                    $delay_shipping_cost = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                    $global_shipping_cost = $currencies->total_format_new($this->global_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                                }


                                if ($this->is_vax_de) {
                                    $vax = $this->vax_de;
                                } else {
                                    $vax = 10;
                                }
                                if ($this->is_vax) {
                                    $global_vat = zen_round(($global_subtotal + $global_shipping_cost) * $vax / 100, $point);
                                    if (!$this->is_buck) {
                                        $delay_vat = zen_round(($delay_subtotal + $delay_shipping_cost) * $vax / 100, $point);
                                    }
                                    $delay_vat_value = $delay_vat / $this->info['currency_value'];
                                    $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                                    $global_vat_value = $global_vat / $this->info['currency_value'];
                                    $global_vat_text = $symbol_left . $currencies->fs_format_number($global_vat) . " " . $symbol_right;
                                }
                                $global_total = $global_subtotal + $global_shipping_cost + $global_vat;
                                $delay_total = $delay_subtotal + $delay_shipping_cost + $delay_vat;

                                $global_total_value = $global_total / $this->info['currency_value'];
                                $delay_total_value = $delay_total / $this->info['currency_value'];

                                $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];
                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                                $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;
                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                                $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;
                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                                $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;
                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['global'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $global_total_text,

                                        'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $global_shipping_cost_text,

                                        'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $global_subtotal_text,

                                        'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];
                                if ($this->is_vax) {
                                    if (!$this->is_buck) {
                                        $info['delay'][] = [

                                            'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                            'text' => $delay_vat_text,

                                            'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                            'code' => 'ot_tax',

                                            'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                        ];
                                    }

                                    $info['global'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $global_vat_text,

                                        'value' => (is_numeric($global_vat_value)) ? $global_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];
                                }
                                break;
                            case 2:
                                $total_weight = $this->delay_info['total_weight'] + $this->global_info['total_weight'];
                                $weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                                //汇率转化后价格
                                $delay_shipping_cost = zen_round($total_shipping * $weight_percent, $point);
                                $global_shipping_cost = $total_shipping - $delay_shipping_cost;

                                if ($this->is_vax_cn) {
                                    $delay_vat = zen_round(($delay_subtotal * $this->vax_cn) / 100, $point);
                                    if ($country_code == "RU") {
                                        $delay_vat = zen_round((($delay_subtotal + $delay_shipping_cost) * $this->vax_cn) / 100, $point);
                                    }
                                    $global_vat = $total_vat - $delay_vat;

                                    $delay_vat_value = $delay_vat / $this->info['currency_value'];
                                    $global_vat_value = $global_vat / $this->info['currency_value'];

                                    $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                                    $global_vat_text = $symbol_left . $currencies->fs_format_number($global_vat) . " " . $symbol_right;
                                }

                                $delay_total = $delay_subtotal + $delay_shipping_cost + $delay_vat;
                                $global_total = $global_subtotal + $global_shipping_cost + $global_vat;

                                $delay_total_value = $delay_total / $this->info['currency_value'];
                                $global_total_value = $global_total / $this->info['currency_value'];

                                $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];
                                $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];

                                $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;
                                $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;

                                $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;
                                $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;

                                $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                                $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;

                                $info['global'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $global_total_text,

                                        'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $global_shipping_cost_text,

                                        'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $global_subtotal_text,

                                        'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                $info['delay'] = [
                                    [
                                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                        'text' => $delay_total_text,

                                        'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                        'code' => 'ot_total',

                                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                        'text' => $delay_shipping_cost_text,

                                        'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                        'code' => 'ot_shipping',

                                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                                    ],
                                    [
                                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                        'text' => $delay_subtotal_text,

                                        'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                        'code' => 'ot_subtotal',

                                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                                    ],
                                ];

                                if ($this->is_vax_cn) {

                                    $info['delay'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $delay_vat_text,

                                        'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];

                                    $info['global'][] = [

                                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                        'text' => $global_vat_text,

                                        'value' => (is_numeric($global_vat_value)) ? $global_vat_value : '0',

                                        'code' => 'ot_tax',

                                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                    ];
                                }

                                break;
                        }
                        break;
                }
                break;
            case 3:
                $local_subtotal = $currencies->total_format_new($this->local_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                $delay_subtotal = $currencies->total_format_new($this->delay_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                $global_subtotal = $currencies->total_format_new($this->global_info['subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                switch ($this->local_warehouse) {
                    case 40:
                    case 71:
                        $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                        $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                        $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;

                        $total_weight = $this->delay_info['total_weight'] + $this->global_info['total_weight'];
                        $weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);

                        $local_shipping_cost = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                        $delay_global_shipping = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);

                        $delay_shipping_cost = zen_round($delay_global_shipping * $weight_percent, $point);
                        $global_shipping_cost = $delay_global_shipping - $delay_shipping_cost;

                        if ($_SESSION['shipping_delay']['id'] == "fedexiezones_fedexiezones") {
                            $delay_shipping_cost_trans = 0;
                            $global_shipping_cost_trans = 0;
                            if ($this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                $global_shipping_cost_trans = 0;
                                $delay_shipping_cost_trans = 0;
                            } elseif ($this->global_info['is_shipping_free'] && !$this->delay_info['is_shipping_free']) {
                                $global_shipping_cost_trans = 0;
                                $delay_shipping_cost_trans = $delay_global_shipping;
                            } elseif (!$this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                $global_shipping_cost_trans = $delay_global_shipping;
                                $delay_shipping_cost_trans = 0;
                            }
                            $total_trans = $global_shipping_cost_trans + $delay_shipping_cost_trans;
                            if ($total_trans == $delay_global_shipping) {
                                $delay_shipping_cost = $delay_shipping_cost_trans;
                                $global_shipping_cost = $global_shipping_cost_trans;
                            }
                        }

                        $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                        $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];
                        $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];

                        $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                        $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;
                        $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;


                        $local_total = $local_subtotal + $local_shipping_cost;
                        $delay_total = $delay_subtotal + $delay_shipping_cost;
                        if ($this->local_warehouse == 71) {
                            $delay_total += $total_insurance;
                        }
                        $global_total = $global_subtotal + $global_shipping_cost;


                        $local_total_value = $local_total / $this->info['currency_value'];
                        $delay_total_value = $delay_total / $this->info['currency_value'];
                        $global_total_value = $global_total / $this->info['currency_value'];

                        $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                        $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;
                        $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;

                        $info['delay'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $delay_total_text,

                                'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $delay_shipping_cost_text,

                                'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $delay_subtotal_text,

                                'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];

                        $info['local'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $local_total_text,

                                'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $local_shipping_cost_text,

                                'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $local_subtotal_text,

                                'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];


                        $info['global'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $global_total_text,

                                'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $global_shipping_cost_text,

                                'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $global_subtotal_text,

                                'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];

                        if ($this->insurance && $this->local_warehouse == 71) {
                            $info['delay'][] = [
                                'title' => MODULE_ORDER_TOTAL_INSURANCE_TITLE,

                                'text' => $total_insurance_text,

                                'value' => (is_numeric($total_insurance_value)) ? $total_insurance_value : '0',

                                'code' => 'ot_insurance',

                                'sort_order' => MODULE_ORDER_TOTAL_INSURANCE_SORT_ORDER
                            ];
                        }

                        break;
                    case 37:
                    case 20:
                        //汇率转化后价格
                        $total_weight = $this->global_info['total_weight'] + $this->delay_info['total_weight'];
                        $percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);
                        $local_shipping_delay = $currencies->total_format_new($this->local_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                        if ($this->is_buck || $country_code == "NZ") {
                            $shipping_delay_global = $currencies->total_format_new($this->delay_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                            $delay_shipping_cost = zen_round($shipping_delay_global * $percent, $point);
                            $global_shipping_cost = $shipping_delay_global - $delay_shipping_cost;
                            $local_shipping_cost = $local_shipping_delay;
                            if ($_SESSION['shipping_delay']['id'] == "fedexiezones_fedexiezones") {
                                $delay_shipping_cost_trans = 0;
                                $global_shipping_cost_trans = 0;
                                if ($this->global_info['is_shipping_free'] && $this->delay_info['is_shipping_free']) {
                                    $global_shipping_cost_trans = 0;
                                    $delay_shipping_cost_trans = 0;
                                } elseif ($this->global_info['is_shipping_free'] && !$this->delay_info['is_shipping_free']) {
                                    $global_shipping_cost_trans = 0;
                                    $delay_shipping_cost_trans = $shipping_delay_global;
                                }
                                $total_trans = $global_shipping_cost_trans + $delay_shipping_cost_trans;
                                if ($total_trans == $shipping_delay_global) {
                                    $delay_shipping_cost = $delay_shipping_cost_trans;
                                    $global_shipping_cost = $global_shipping_cost_trans;
                                }
                            }
                        } else {
                            $total_weight = $this->local_info['total_weight'] + $this->delay_info['total_weight'];
                            $percent = zen_round($this->local_info['total_weight'] / $total_weight);
                            $local_shipping_cost = zen_round($local_shipping_delay * $percent, $point);
                            $delay_shipping_cost = $local_shipping_delay - $local_shipping_cost;
                            $global_shipping_cost = $currencies->total_format_new($this->global_shipping_cost, true, $this->info['currency'], $this->info['currency_value']);
                        }


                        if ($this->is_vax_de) {
                            $vax = $this->vax_de;
                        } else {
                            $vax = 10;
                        }
                        if ($this->is_vax) {
                            $local_vat = zen_round(($local_subtotal + $local_shipping_cost) * $vax / 100, $point);
                            $global_vat = zen_round(($global_subtotal + $global_shipping_cost) * $vax / 100, $point);
                            if (!$this->is_buck) {
                                $delay_vat = zen_round(($delay_subtotal + $delay_shipping_cost) * $vax / 100, $point);
                            }
                            $local_vat_value = $local_vat / $this->info['currency_value'];
                            $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                            $delay_vat_value = $delay_vat / $this->info['currency_value'];
                            $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                            $global_vat_value = $global_vat / $this->info['currency_value'];
                            $global_vat_text = $symbol_left . $currencies->fs_format_number($global_vat) . " " . $symbol_right;
                        }
                        $local_total = $local_subtotal + $local_shipping_cost + $local_vat;
                        $global_total = $global_subtotal + $global_shipping_cost + $global_vat;
                        $delay_total = $delay_subtotal + $delay_shipping_cost + $delay_vat;

                        $local_total_value = $local_total / $this->info['currency_value'];
                        $global_total_value = $global_total / $this->info['currency_value'];
                        $delay_total_value = $delay_total / $this->info['currency_value'];

                        $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                        $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];
                        $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                        $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                        $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;
                        $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                        $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                        $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;
                        $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                        $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                        $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;
                        $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;

                        $info['local'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $local_total_text,

                                'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $local_shipping_cost_text,

                                'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $local_subtotal_text,

                                'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];
                        $info['delay'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $delay_total_text,

                                'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $delay_shipping_cost_text,

                                'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $delay_subtotal_text,

                                'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];

                        $info['global'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $global_total_text,

                                'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $global_shipping_cost_text,

                                'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $global_subtotal_text,

                                'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];
                        if ($this->is_vax) {
                            if (!$this->is_buck) {
                                $info['delay'][] = [

                                    'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                    'text' => $delay_vat_text,

                                    'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                    'code' => 'ot_tax',

                                    'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                                ];
                            }
                            $info['local'][] = [

                                'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                'text' => $local_vat_text,

                                'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                'code' => 'ot_tax',

                                'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                            ];
                            $info['global'][] = [

                                'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                'text' => $global_vat_text,

                                'value' => (is_numeric($global_vat_value)) ? $global_vat_value : '0',

                                'code' => 'ot_tax',

                                'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                            ];
                        }
                        break;
                    case 2:
                        $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                        $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                        $global_subtotal_text = $symbol_left . $currencies->fs_format_number($global_subtotal) . " " . $symbol_right;

                        $total_weight = $this->local_info['total_weight'] + $this->delay_info['total_weight'] + $this->global_info['total_weight'];
                        $local_weight_percent = zen_round($this->local_info['total_weight'] / $total_weight, 2);
                        $delay_weight_percent = zen_round($this->delay_info['total_weight'] / $total_weight, 2);

                        $local_shipping_cost = zen_round($total_shipping * $local_weight_percent, $point);
                        $delay_shipping_cost = zen_round($total_shipping * $delay_weight_percent, $point);
                        $global_shipping_cost = $total_shipping - $local_shipping_cost - $delay_shipping_cost;

                        $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                        $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];
                        $global_shipping_cost_value = $global_shipping_cost / $this->info['currency_value'];

                        $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                        $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;
                        $global_shipping_cost_text = $symbol_left . $currencies->fs_format_number($global_shipping_cost) . " " . $symbol_right;

                        $local_vat = zen_round(($local_subtotal * $this->vax_cn) / 100, $point);
                        $delay_vat = zen_round(($delay_subtotal * $this->vax_cn) / 100, $point);
                        $global_vat = zen_round(($global_subtotal * $this->vax_cn) / 100, $point);
                        if ($country_code == "RU") {
                            $local_vat = zen_round((($local_subtotal + $local_shipping_cost) * $this->vax_cn) / 100, $point);
                            $delay_vat = zen_round((($delay_subtotal + $delay_shipping_cost) * $this->vax_cn) / 100, $point);
                            $global_vat = zen_round((($global_subtotal + $global_shipping_cost) * $this->vax_cn) / 100, $point);
                        }

                        $local_vat_value = $local_vat / $this->info['currency_value'];
                        $delay_vat_value = $delay_vat / $this->info['currency_value'];
                        $global_vat_value = $global_vat / $this->info['currency_value'];

                        $local_vat_text = $symbol_left . $currencies->fs_format_number($local_vat) . " " . $symbol_right;
                        $delay_vat_text = $symbol_left . $currencies->fs_format_number($delay_vat) . " " . $symbol_right;
                        $global_vat_text = $symbol_left . $currencies->fs_format_number($global_vat) . " " . $symbol_right;

                        $local_total = $local_subtotal + $local_shipping_cost;
                        $delay_total = $delay_subtotal + $delay_shipping_cost;
                        $global_total = $global_subtotal + $global_shipping_cost;

                        if ($this->is_vax_cn) {
                            $local_total += $local_vat;
                            $delay_total += $delay_vat;
                            $global_total += $global_vat;
                        }

                        $local_total_value = $local_total / $this->info['currency_value'];
                        $delay_total_value = $delay_total / $this->info['currency_value'];
                        $global_total_value = $global_total / $this->info['currency_value'];

                        $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                        $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;
                        $global_total_text = $symbol_left . $currencies->fs_format_number($global_total) . " " . $symbol_right;

                        $info['delay'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $delay_total_text,

                                'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $delay_shipping_cost_text,

                                'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $delay_subtotal_text,

                                'value' => (is_numeric($this->delay_info['subtotal'])) ? $this->delay_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];

                        $info['local'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $local_total_text,

                                'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $local_shipping_cost_text,

                                'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $local_subtotal_text,

                                'value' => (is_numeric($this->local_info['subtotal'])) ? $this->local_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];


                        $info['global'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $global_total_text,

                                'value' => (is_numeric($global_total_value)) ? $global_total_value : '0',

                                'code' => 'ot_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $global_shipping_cost_text,

                                'value' => (is_numeric($global_shipping_cost_value)) ? $global_shipping_cost_value : '0',

                                'code' => 'ot_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $global_subtotal_text,

                                'value' => (is_numeric($this->global_info['subtotal'])) ? $this->global_info['subtotal'] : '0',

                                'code' => 'ot_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];

                        if ($this->is_vax_cn) {

                            $info['local'][] = [

                                'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                'text' => $local_vat_text,

                                'value' => (is_numeric($local_vat_value)) ? $local_vat_value : '0',

                                'code' => 'ot_tax',

                                'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                            ];

                            $info['delay'][] = [

                                'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                'text' => $delay_vat_text,

                                'value' => (is_numeric($delay_vat_value)) ? $delay_vat_value : '0',

                                'code' => 'ot_tax',

                                'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                            ];

                            $info['global'][] = [

                                'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                                'text' => $global_vat_text,

                                'value' => (is_numeric($global_vat_value)) ? $global_vat_value : '0',

                                'code' => 'ot_tax',

                                'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                            ];
                        }

                        break;
                }
                break;
        }
        if ($num == 1) {
            switch ($order_tag) {
                case "local":
                    $this->local_info['total'] = $total_value;
                    break;
                case "delay":
                    $this->delay_info['total'] = $total_value;
                    break;
                case "global":
                    $this->global_info['total'] = $total_value;
                    break;
            }
        } else {
            switch ($order_tag) {
                case "local":
                    $this->local_info['total'] = $local_total_value;
                    break;
                case "delay":
                    $this->delay_info['total'] = $delay_total_value;
                    break;
                case "global":
                    $this->global_info['total'] = $global_total_value;
                    break;
            }
        }
        if ($order_tag == "all") {
            if ($num == 1) {
                $info[$order_tag] = [
                    [
                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                        'text' => $total_text,

                        'value' => (is_numeric($total_value)) ? $total_value : '0',

                        'code' => 'ot_total',

                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                        'text' => $total_shipping_text,

                        'value' => (is_numeric($total_shipping_value)) ? $total_shipping_value : '0',

                        'code' => 'ot_shipping',

                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                        'text' => $subtotal_text,

                        'value' => (is_numeric($this->info['subtotal'])) ? $this->info['subtotal'] : '0',

                        'code' => 'ot_subtotal',

                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                    ],
                ];
                if ($this->is_vax) {
                    $info[$order_tag][] = [
                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                        'text' => $total_vat_text,

                        'value' => (is_numeric($total_vat_value)) ? $total_vat_value : '0',

                        'code' => 'ot_tax',

                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                    ];
                }

                if ($this->insurance) {
                    $info[$order_tag][] = [
                        'title' => MODULE_ORDER_TOTAL_INSURANCE_TITLE,

                        'text' => $total_insurance_text,

                        'value' => (is_numeric($total_insurance_value)) ? $total_insurance_value : '0',

                        'code' => 'ot_insurance',

                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                    ];
                }

            } else {
                $total = $local_total + $delay_total + $global_total;
                $total_text = $symbol_left . $currencies->fs_format_number($total) . " " . $symbol_right;
                $total_value = $total / $this->info['currency_value'];
                $total_shipping = $local_shipping_cost + $delay_shipping_cost + $global_shipping_cost;
                $total_shipping_text = $symbol_left . $currencies->fs_format_number($total_shipping) . " " . $symbol_right;
                $total_shipping_value = $total_shipping / $this->info['currency_value'];
                $this->info['total'] = $total_value;
                $info[$order_tag] = [
                    [
                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                        'text' => $total_text,

                        'value' => (is_numeric($total_value)) ? $total_value : '0',

                        'code' => 'ot_total',

                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                        'text' => $total_shipping_text,

                        'value' => (is_numeric($total_shipping_value)) ? $total_shipping_value : '0',

                        'code' => 'ot_shipping',

                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                        'text' => $subtotal_text,

                        'value' => (is_numeric($this->info['subtotal'])) ? $this->info['subtotal'] : '0',

                        'code' => 'ot_subtotal',

                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                    ],
                ];
                if ($this->is_vax) {
                    $total_vat = $local_vat + $delay_vat + $global_vat;
                    $total_vat_value = $total_vat / $this->info['currency_value'];
                    $total_vat_text = $symbol_left . $currencies->fs_format_number($total_vat) . " " . $symbol_right;
                    $info[$order_tag][] = [
                        'title' => MODULE_ORDER_TOTAL_TAX_TITLE,

                        'text' => $total_vat_text,

                        'value' => (is_numeric($total_vat_value)) ? $total_vat_value : '0',

                        'code' => 'ot_tax',

                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                    ];
                }

                if ($this->insurance) {
                    $info[$order_tag][] = [
                        'title' => 'Insurance',

                        'text' => $total_insurance_text,

                        'value' => (is_numeric($total_insurance_value)) ? $total_insurance_value : '0',

                        'code' => 'ot_insurance',

                        'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
                    ];
                }

            }
        }
        //赠品单单独设置
        if ($order_tag == 'gift') {
            $this->gift_info['total'] = 0;
            $info['gift'] = [
                [
                    'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                    'text' => $symbol_left . $currencies->fs_format_number(0) . " " . $symbol_right,

                    'value' => 0,

                    'code' => 'ot_total',

                    'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                ],
                [
                    'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                    'text' => $symbol_left . $currencies->fs_format_number(0) . " " . $symbol_right,

                    'value' => 0,

                    'code' => 'ot_shipping',

                    'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                ],
                [
                    'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                    'text' => $symbol_left . $currencies->fs_format_number(0) . " " . $symbol_right,

                    'value' => 0,

                    'code' => 'ot_subtotal',

                    'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                ],
            ];
        }
        return $info[$order_tag];
    }

    /**
     * add by quest
     * 为每一单生成税后 运费 总价
     * @param $order_tag 获取指定订单 运费总价税收等信息 标识
     * @return array
     */
    function createTotalTax($order_tag)
    {
        global $currencies;
        $info = array();
        $country_code = $this->delivery['country']["iso_code_2"];
        $point = $currencies->currencies[$this->info['currency']]['decimal_places'];
        $symbol_left = $currencies->currencies[$this->info['currency']]['symbol_left'];
        $symbol_right = $currencies->currencies[$this->info['currency']]['symbol_right'];
        $order_info = $this->get_order_num();
        $num = $order_info['num'];
        $order_origin_data = $order_data = $order_info['data'];

        //汇率转化后税后价格
        $total_shipping = $currencies->total_format_new($this->info['aftertax_shipping_cost'], true, $this->info['currency'], $this->info['currency_value']);
        $total = $currencies->total_format_new($this->info['aftertax_subtotal'], true, $this->info['currency'], $this->info['currency_value']) + $total_shipping;
        $subtotal = $currencies->total_format_new($this->info['aftertax_subtotal'], true, $this->info['currency'], $this->info['currency_value']);


        //带货币符号价格
        $total_shipping_text = $symbol_left . $currencies->fs_format_number($total_shipping) . " " . $symbol_right;
        $subtotal_text = $symbol_left . $currencies->fs_format_number($subtotal) . " " . $symbol_right;
        $total_text = $symbol_left . $currencies->fs_format_number($total) . " " . $symbol_right;

        //美元税后价格
        $total_value = $total / $this->info['currency_value'];
        $total_shipping_value = $total_shipping / $this->info['currency_value'];

        $order_tag_arr =  ['local-gift'=>'local','delay-gift'=>'delay','global-gift'=>'global','local-delay-gift'=>'local-delay',
            'local-global-gift'=>'local-global','delay-global-gift'=>'delay-global','local-delay-global-gift' => 'local-delay-global'];
        if(isset($order_tag_arr[$order_data])){
            $order_data = $order_tag_arr[$order_data];
            $num = count(explode("-",$order_data));
        }

        //汇率转换后的运费
        switch ($num) {
            case 1 :
                $info[$order_tag] = [
                    [
                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                        'text' => $total_text,

                        'value' => (is_numeric($total_value)) ? $total_value : '0',

                        'code' => 'tax_total',

                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                        'text' => $total_shipping_text,

                        'value' => (is_numeric($total_shipping_value)) ? $total_shipping_value : '0',

                        'code' => 'tax_shipping',

                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                        'text' => $subtotal_text,

                        'value' => (is_numeric($this->info['aftertax_subtotal'])) ? $this->info['aftertax_subtotal'] : '0',

                        'code' => 'tax_subtotal',

                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                    ],
                ];
                break;
            case 2 :
                switch ($order_data) {
                    case "local-delay":

                        //汇率转化后价格
                        $local_subtotal = $currencies->total_format_new($this->local_info['aftertax_subtotal'], true, $this->info['currency'], $this->info['currency_value']);
                        $delay_subtotal = $currencies->total_format_new($this->delay_info['aftertax_subtotal'], true, $this->info['currency'], $this->info['currency_value']);

                        //汇率转化后价格
                        $local_shipping_cost_tax = get_gsp_tax_price($this->delivery['country_id'],$this->local_shipping_cost);
                        $delay_shipping_cost_tax = get_gsp_tax_price($this->delivery['country_id'],$this->delay_shipping_cost);
                        $local_shipping_cost = $currencies->total_format_new($local_shipping_cost_tax, true, $this->info['currency'], $this->info['currency_value']);
                        if ($this->is_buck || $country_code == "NZ") {
                            $delay_shipping_cost = $currencies->total_format_new($delay_shipping_cost_tax, true, $this->info['currency'], $this->info['currency_value']);
                        } else {
                            $total_weight = $this->local_info['total_weight'] + $this->delay_info['total_weight'];
                            $weight_percent = zen_round($this->local_info['total_weight'] / $total_weight);
                            $local_shipping_cost = zen_round($total_shipping * $weight_percent, $point);
                            $delay_shipping_cost = $total_shipping - $local_shipping_cost;
                            if($local_shipping_cost < 10){
                                $local_shipping_cost = 0;
                                $delay_shipping_cost = $total_shipping;
                            }
                        }

                        $local_total = $local_subtotal + $local_shipping_cost;
                        $delay_total = $delay_subtotal + $delay_shipping_cost;

                        $local_total_value = $local_total / $this->info['currency_value'];
                        $delay_total_value = $delay_total / $this->info['currency_value'];

                        $local_shipping_cost_value = $local_shipping_cost / $this->info['currency_value'];
                        $delay_shipping_cost_value = $delay_shipping_cost / $this->info['currency_value'];

                        $local_total_text = $symbol_left . $currencies->fs_format_number($local_total) . " " . $symbol_right;
                        $delay_total_text = $symbol_left . $currencies->fs_format_number($delay_total) . " " . $symbol_right;

                        $local_shipping_cost_text = $symbol_left . $currencies->fs_format_number($local_shipping_cost) . " " . $symbol_right;
                        $delay_shipping_cost_text = $symbol_left . $currencies->fs_format_number($delay_shipping_cost) . " " . $symbol_right;

                        $local_subtotal_text = $symbol_left . $currencies->fs_format_number($local_subtotal) . " " . $symbol_right;
                        $delay_subtotal_text = $symbol_left . $currencies->fs_format_number($delay_subtotal) . " " . $symbol_right;
                        $info['delay'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $delay_total_text,

                                'value' => (is_numeric($delay_total_value)) ? $delay_total_value : '0',

                                'code' => 'tax_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $delay_shipping_cost_text,

                                'value' => (is_numeric($delay_shipping_cost_value)) ? $delay_shipping_cost_value : '0',

                                'code' => 'tax_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $delay_subtotal_text,

                                'value' => (is_numeric($this->delay_info['aftertax_subtotal'])) ? $this->delay_info['aftertax_subtotal'] : '0',

                                'code' => 'tax_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];

                        $info['local'] = [
                            [
                                'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                                'text' => $local_total_text,

                                'value' => (is_numeric($local_total_value)) ? $local_total_value : '0',

                                'code' => 'tax_total',

                                'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                                'text' => $local_shipping_cost_text,

                                'value' => (is_numeric($local_shipping_cost_value)) ? $local_shipping_cost_value : '0',

                                'code' => 'tax_shipping',

                                'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                            ],
                            [
                                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                                'text' => $local_subtotal_text,

                                'value' => (is_numeric($this->local_info['aftertax_subtotal'])) ? $this->local_info['aftertax_subtotal'] : '0',

                                'code' => 'tax_subtotal',

                                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                            ],
                        ];
                }
                break;
        }

        if($order_tag == "all"){
            if($num == 1){
                $info[$order_tag] = [
                    [
                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                        'text' => $total_text,

                        'value' => (is_numeric($total_value)) ? $total_value : '0',

                        'code' => 'tax_total',

                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                        'text' => $total_shipping_text,

                        'value' => (is_numeric($total_shipping_value)) ? $total_shipping_value : '0',

                        'code' => 'tax_shipping',

                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                        'text' => $subtotal_text,

                        'value' => (is_numeric($this->info['aftertax_subtotal'])) ? $this->info['aftertax_subtotal'] : '0',

                        'code' => 'tax_subtotal',

                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                    ],
                ];

            }else{
                $total =  $local_total + $delay_total;
                $total_text = $symbol_left . $currencies->fs_format_number($total) . " " . $symbol_right;
                $total_value = $total/$this->info['currency_value'];
                $total_shipping = $local_shipping_cost + $delay_shipping_cost;
                $total_shipping_text = $symbol_left . $currencies->fs_format_number($total_shipping) . " " . $symbol_right;
                $total_shipping_value = $total_shipping/$this->info['currency_value'];
                $info[$order_tag] = [
                    [
                        'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE,

                        'text' =>  $total_text,

                        'value' => (is_numeric($total_value)) ? $total_value : '0',

                        'code' => 'tax_total',

                        'sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE,

                        'text' => $total_shipping_text,

                        'value' => (is_numeric($total_shipping_value)) ? $total_shipping_value : '0',

                        'code' => 'tax_shipping',

                        'sort_order' => MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER
                    ],
                    [
                        'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE,

                        'text' => $subtotal_text,

                        'value' => (is_numeric($this->info['aftertax_subtotal'])) ? $this->info['aftertax_subtotal'] : '0',

                        'code' => 'tax_subtotal',

                        'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER
                    ],
                ];
            }
        }

        return $info[$order_tag];
    }

    /**
     * add by aron
     * @param string $shippingMethod
     * @return array|string
     */
    function handleShippingMethod($shippingMethod = "")
    {
        if (!$shippingMethod) {
            return "";
        }
        if (strpos($shippingMethod, "_") !== false) {
            $shippingMethod = explode("_", $shippingMethod);
            return $shippingMethod[0];
        }
        return $shippingMethod;
    }

    /**
     * 将生成的 订单号插入redis 集合，如果插入成功则订单号不重复,插入失败需要重新生成订单号
     * 如果重复生成5次失败,则跳出while循环,防止死循环
     *
     * @return string
     * @author aron
     * @date 2019.8.9
     */
    public function createOrdersNumber()
    {
        global $db;
        $orders = $db->Execute("select orders_number from " . TABLE_ORDERS . ' where payment_link = 0 AND is_offline=0 order by orders_id desc limit 1');
        $redis = getRedis();
        $is_not_same_order = true;
        $n = 0;
        $orders_number = "";
        while ($is_not_same_order && $n <= 5) {
            $orders_number = $this->_createOrderNumber($orders);
            $is_not_same_order = $redis::$is_connect && !($redis::sAdd('ordersNumber', $orders_number));
            $n++;
        }
        //设置sAdd 过期时间
        $redis::expire('ordersNumber', 50);
        return $orders_number;
    }

    /**
     * 生成订单号
     *
     * @date 2019 8.9
     * @return string
     * @author aron
     */
    private function _createOrderNumber($orders = "")
    {
        if ($orders->RecordCount() > 0) {

            $number = (int)substr($orders->fields['orders_number'], 8) + 1;
            $number2 = $number;
            if ($number < 10000) {

                $number = "00" . $number;

            } elseif ($number >= 10000 && $number < 100000) {

                $number = "0" . $number;

            } else {
                $number = rand(10, 80) . substr($number, 2);
                $orderNumber = 'FS' . date('ymd', time()) . $number;
                if (check_exist_order_num($orderNumber)) {
                    $number = rand(81, 92) . substr($number2, 2);
                    //$number = 13 . substr($number2, 2);
                }
            }

            $orders_number = 'FS' . date('ymd', time()) . $number;

        } else {

            $orders_number = 'FS' . date('ymd', time()) . '001000';

        }
        return $orders_number;
    }

    /**
     * add by aron
     * @param $zf_ot_modules 订单总价信息
     * @param $main_id 主单id  0: 主订单
     * @param $set_info 订单信息
     * @param $is_reissue 订单分仓信息
     * @param string $warehouse 订单所属仓库
     * @param $shippings 订单运费信息
     * @param $zf_ot_modules_tax 税后总价信息
     * @param array $account_info 订单account 信息 该字段已废除 后期可以考虑取消
     * @return int  生成订单id
     */
    function _create_order_new($zf_ot_modules, $main_id, $set_info, $is_reissue, $warehouse = "", $shippings, $account_info = array(), $zf_ot_modules_tax = [])
    {
        global $db;
        date_default_timezone_set('America/Los_Angeles');
        if ($set_info['total'] == 0) {

            if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {

                $set_info['order_status'] = DEFAULT_ORDERS_STATUS_ID;

            } else {

                if ($_SESSION['payment'] != 'freecharger' && !in_array($is_reissue, [22, 23])) {

                    $set_info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;

                }

            }

        }

        if ($_SESSION['shipping'] == 'free_free') {

            $set_info['shipping_module_code'] = $_SESSION['shipping'];

        }

        /*check if there is any orders exist*/
        $orders_number = $this->createOrdersNumber();
        if (in_array($is_reissue, [1, 4, 6, 9, 12, 24, 26])) {
            $remarks = $this->insertData['remarks']['local'];
        } else {
            $remarks = $this->insertData['remarks']['delay'];
        }

        $sql_data_array = array('customers_id' => $_SESSION['customer_id'],

            'guest_id' => (int)$_SESSION['customers_guest_id'],
            'customers_name' => $this->customer['firstname'],

            'customers_lastname' => $this->customer['lastname'],

            'customers_company' => $this->customer['company'],

            'customers_street_address' => $this->customer['street_address'],

            'customers_suburb' => $this->customer['suburb'],

            'customers_city' => $this->customer['city'],

            'customers_postcode' => $this->customer['postcode'],

            'customers_state' => $this->customer['state'],

            'customers_country' => $this->customer['country']['title'],

            'customers_telephone' => $this->customer['telephone'],

            'customers_email_address' => $this->customer['email_address'],

            'customers_address_format_id' => $this->customer['format_id'],

            'delivery_name' => $this->delivery['firstname'],

            'delivery_lastname' => $this->delivery['lastname'],

            'delivery_company' => $this->delivery['company'],

            'delivery_street_address' => $this->delivery['street_address'],

            'delivery_suburb' => $this->delivery['suburb'],

            'delivery_city' => $this->delivery['city'],

            'delivery_postcode' => $this->delivery['postcode'],

            'delivery_state' => $this->delivery['state'],

            'delivery_country' => $this->delivery['country']['title'],

            'delivery_address_format_id' => $this->delivery['format_id'],

            'delivery_tax_number' => $this->delivery['tax_number'],
            'delivery_company_type' => $this->delivery['company_type'],

            'billing_name' => $this->billing['firstname'],

            'billing_lastname' => $this->billing['lastname'],

            'billing_company' => $this->billing['company'],

            'billing_street_address' => $this->billing['street_address'],

            'billing_suburb' => $this->billing['suburb'],

            'billing_city' => $this->billing['city'],

            'billing_postcode' => $this->billing['postcode'],

            'billing_state' => $this->billing['state'],

            'billing_country' => $this->billing['country']['title'],

            'billing_tax_number' => $this->billing['tax_number'],
            "billing_company_type" => $this->billing['company_type'],

            'billing_address_format_id' => $this->billing['format_id'],

            'payment_method' => (($set_info['payment_module_code'] == '' and $set_info['payment_method'] == '') ? PAYMENT_METHOD_GV : $set_info['payment_method']),

            'payment_module_code' => (($set_info['payment_module_code'] == '' and $set_info['payment_method'] == '') ? PAYMENT_MODULE_GV : $set_info['payment_module_code']),

            'shipping_method' => $shippings['id'],

            'shipping_us_method' => $set_info['shipping_us_method'],


            'shipping_module_code' => $this->handleShippingMethod($shippings['id']),

            'shipping_us_module_code' => (strpos($set_info['shipping_us_module_code'], '_') > 0 ? substr($set_info['shipping_us_module_code'], 0, strpos($set_info['shipping_us_module_code'], '_')) : $set_info['shipping_us_module_code']),

            'coupon_code' => $set_info['coupon_code'],

            'cc_type' => $set_info['cc_type'],

            'cc_owner' => $set_info['cc_owner'],

            'cc_number' => $set_info['cc_number'],

            'cc_expires' => $set_info['cc_expires'],

            'date_purchased' => date('Y-m-d H:i:s'),

            'orders_status' => $set_info['order_status'],

            'order_total' => $set_info['total'],//目前分订单暂时不加上运费

            'order_tax' => $set_info['tax'],

            'currency' => $set_info['currency'],

            'currency_value' => $set_info['currency_value'],

            'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP(),

            'orders_number' => $orders_number,

            'd_tel_prefix' => zen_db_prepare_input($this->delivery['country']['tel_prefix']),

            'b_tel_prefix' => zen_db_prepare_input($this->billing['country']['tel_prefix']),

            'c_tel_prefix' => zen_db_prepare_input($this->customer['country']['tel_prefix']),

            'delivery_telephone' => $this->delivery['telephone'],

            'billing_telephone' => $this->billing['telephone'],

            'language_id' => (int)$_SESSION['languages_id'],
            'language_code' => $_SESSION['languages_code'],
            //关联主订单
            'main_order_id' => $main_id,
            //是否为补发订单 local 为本地 delay 为本地补发 global 全国仓发货
            'is_reissue' => $is_reissue,
            "warehouse" => $warehouse,
            'is_test' => $this->check_eamil_ext($this->customer['email_address'], $main_id),

            'customers_remarks' => !empty($remarks) ? $remarks : "",

            'customers_po' => !empty($_SESSION['customers_po']) ? zen_db_prepare_input($_SESSION['customers_po']) : "",

            'relate_address_id' => $this->delivery_id,
            'client_type' => $_SESSION['client_type'] ? zen_db_prepare_input($_SESSION['client_type']) : "",
            'delivery_country_id' => $this->delivery['country']['id'],
            'vax' => $this->vat == 0 || $this->delivery['country']['id'] == 223 ? 0 : $this->vax / 100,
            'is_au_gsp' => ($this->delivery['country']['id'] == 13 && $is_reissue != 11) ? 1 : 0
        );

        zen_db_perform(TABLE_ORDERS, $sql_data_array);

        $insert_id = $db->Insert_ID();
        //拆分订单不用分配销售
        if ($_SESSION['customer_id']) {

            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);

        }

        if ($admin_id) {

            $sql_data_array = array(

                'admin_id' => $admin_id,

                'orders_id' => $insert_id

            );
            $_SESSION['orders_to_admin_id'] = $admin_id;
            zen_db_perform('order_to_admin', $sql_data_array);

        }


        $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_HEADER', array_merge(array('orders_id' => $insert_id, 'shipping_weight' => $_SESSION['cart']->weight), $sql_data_array));


//        $sql_data_log_array = array(
//
//            'orders_id' => $insert_id,
//
//            'customers_id' => $_SESSION['customer_id'],
//
//            'browser_info' => $_SERVER['HTTP_USER_AGENT'],
//
//            'session_content_info' => var_export($_SESSION,true),
//
//        );
//
//        zen_db_perform('order_logs',$sql_data_log_array);


        if (is_array($zf_ot_modules) && $zf_ot_modules) {
            foreach ($zf_ot_modules as $total) {
                $sql_data_array = array('orders_id' => $insert_id,

                    'title' => $total['title'],

                    'text' => $total['text'],

                    'value' => (is_numeric($total['value'])) ? $total['value'] : '0',

                    'class' => $total['code'],

                    'sort_order' => $total['sort_order']);


                zen_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

                $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDERTOTAL_LINE_ITEM', $sql_data_array);

            }
        }


        if(is_array($zf_ot_modules_tax) && !empty($zf_ot_modules_tax)){
            foreach($zf_ot_modules_tax as $total_tax) {
                $sql_data_array = array('orders_id' => $insert_id,

                    'title' => $total_tax['title'],

                    'text' => $total_tax['text'],

                    'value' => (is_numeric($total_tax['value'])) ? $total_tax['value'] : '0',

                    'class' => $total_tax['code'],

                    'sort_order' => $total_tax['sort_order']);



                zen_db_perform(TABLE_ORDERS_TOTAL_TAX, $sql_data_array);

                $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDERTOTAL_LINE_ITEM', $sql_data_array);

            }
        }


        $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';

        $sql_data_array = array('orders_id' => $insert_id,

            'orders_status_id' => $this->info['order_status'],

            'date_added' => 'now()',

            'customer_notified' => $customer_notification,

            'comments' => $this->info['comments']);


        zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
        if ($this->delivery['country']['id'] == 223) {
            if ($is_reissue == 12) {
                foreach ($this->local_products as $k => $v) {
                    $products['local'][$k]['name'] = @mb_convert_encoding(substr($v['name'], 0, 50),"UTF-8", "UTF-8");
                    $products['local'][$k]['id'] = $v['id'];
                    $products['local'][$k]['paypal_price'] = $v['paypal_price'];
                    $products['local'][$k]['qty'] = $v['qty'];
                }
                $products['local'][] = [
                    'qty' => 1,
                    'type' => 'shipping',
                    'name' => $_SESSION['shipping_local']['title'],
                    'id' => $_SESSION['shipping_local']['id'],
                    'paypal_price' => $this->local_shipping_cost,
                ];
            } else {
                foreach ($this->delay_products as $k => $v) {
                    $products['delay'][$k]['name'] = @mb_convert_encoding(substr($v['name'], 0, 50),"UTF-8","UTF-8");
                    $products['delay'][$k]['id'] = $v['id'];
                    $products['delay'][$k]['paypal_price'] = $v['paypal_price'];
                    $products['delay'][$k]['qty'] = $v['qty'];
                }
                $products['delay'][] = [
                    'qty' => 1,
                    'type' => 'shipping',
                    'name' => $_SESSION['shipping_delay']['title'],
                    'id' => $_SESSION['shipping_delay']['id'],
                    'paypal_price' => $this->delay_shipping_cost
                ];
            }
            if (AUTOAVATAX) {
                $avaAddress = $this->delivery;
                if ($avaAddress['state']) {
                    $avaAddress['state'] = zen_get_countries_us_states_code($avaAddress['state']);
                }

                $isUseDefaultAddress = (int)$_SESSION['useUpsDefaultAddress'];
                $avaAddress['useUpsDefaultAddress'] = $isUseDefaultAddress ? $isUseDefaultAddress : 0;
                if (!empty($_SESSION['avaTaxRecord'])) {
                    zen_db_perform('avatax_calate_record', [
                        'created_at' => time(),
                        'updated_at' => time(),
                        'response_data' => $_SESSION['avaTaxRecord'],
                        'orders_id' => $insert_id
                    ]);
                }
                try{
                    (new \App\Models\AvaTaxQueues())->create([
                        'orders_id' => $insert_id,
                        'created_at' => time(),
                        'updated_at' => time(),
                        'data' => json_encode(
                            [
                                'admin_id' => $admin_id,
                                'customerCode' => (new \App\Services\HelpCustomerPlaceOrder\HelpCustomerPlaceOrderService())
                                    ->getRelatedCustomerCode($this->customer['customers_number_new']),
                                'orders_number' => $orders_number,
                                'products' => $products,
                                'address' => $avaAddress,
                                'currency' => $this->info['currency'],
                                'currency_value' => $this->info['currency_value']
                            ]
                        )
                    ]);
                }catch (\Exception $e){
                }

                zen_db_perform('orders_related_avatax', [
                    'orders_id' => $insert_id,
                    'is_ups_address' => $_SESSION['useUpsDefaultAddress'] ? $_SESSION['useUpsDefaultAddress'] : 0
                ]);
            }
        }

        $this->update_related_email($insert_id);
        $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_COMMENT', $sql_data_array);
        $this->update_shipping_account($insert_id, $shippings);
        $this->update_pick_info($insert_id, $shippings);
        return ($insert_id);

    }

    /**
     * add by aron
     * 更新echeck信息
     * @param $orders_id
     */
    function update_echeck_info($orders_id)
    {
        global $db;
        if (!empty($_SESSION['echeck_info']) && $this->info['payment_module_code'] == "echeck" && $orders_id) {
            $admin_id = fs_get_data_from_db_fields('admin_id', 'order_to_admin', 'orders_id=' . $orders_id . '', 'limit 1');
            $orders_info = $db->Execute("SELECT orders_number,order_total,currency,customers_email_address,customers_name,customers_id FROM " . TABLE_ORDERS . " WHERE orders_id = " . $orders_id . " limit 1");
            $applyMoney = zen_round($orders_info->fields['order_total'], 2);
            $customersEmail = $orders_info->fields['customers_email_address'];
            $ordersNumber = $orders_info->fields['orders_number'];
            $currency = $orders_info->fields['currency'];
            $currenciesId = 1;
            $customers_id = $orders_info->fields['customers_id'] ? $orders_info->fields['customers_id'] : "";
            $customersName = $orders_info->fields['customers_name'] ? $orders_info->fields['customers_name'] : "";
            $customersLevel = "";
            $customersNO = "";
            if ($currency) {
                $currenciesId = fs_get_data_from_db_fields('currencies_id', 'currencies', 'code="' . $currency . '"', ' ORDER BY currencies_id ASC limit 1');
            }
            if ($customers_id) {
                $customer_info = $db->Execute("SELECT customers_level,customers_number_new FROM " . TABLE_CUSTOMERS . " WHERE customers_id = " . $customers_id . " limit 1");
                $customersNO = $customer_info->fields['customers_number_new'];
                $customersLevel = $customer_info->fields['customers_level'];
            }
            $check_info = array(
                "orders_id" => $orders_id,
                "account_name" => $_SESSION['echeck_info']["account_name"] ? $_SESSION['echeck_info']["account_name"] : "",
                "account_number" => $_SESSION['echeck_info']["account_number"] ? $_SESSION['echeck_info']["account_number"] : "",
                "account_type" => $_SESSION['echeck_info']["account_type"] ? $_SESSION['echeck_info']["account_type"] : "",
                "routing_number" => $_SESSION['echeck_info']["account_route"] ? $_SESSION['echeck_info']["account_route"] : "",
                'customers_email' => $customersEmail,// 客户邮箱
                'customers_NO' => $customersNO,// 客户编号
                'customers_level' => $customersLevel,// 客户等级
                'customers_name' => $customersName,// 客户名称
                'currencies_id' => $currenciesId,// 币种ID
                'apply_money' => $applyMoney,// 订单金额
                'orders_number' => $ordersNumber,// FS单号
                'apply_admin' => $admin_id ? $admin_id : "",// 销售，申请人
                'created_at' => 'now()',
                'updated_at' => 'now()',
            );
            zen_db_perform('fs_electrical_check_apply', $check_info);
        }
    }

    /**
     * add by aron
     * @param $insert_id 订单id
     * @param $shipping 运费session
     * 更新运费 account账户信息
     */
    function update_shipping_account($insert_id, $shipping)
    {
        $account_info = $shipping['customzones_info'];
        $title = $shipping['id'];
        $shippings = $account_info["customzones_select"];
        $acounts = $account_info["customzones_account"];
        if ($title == 'customzones_customzones') {
            if (!empty($shippings) && !empty($acounts)) {

                $sql_data_array = array('orders_id' => $insert_id,

                    'customers_id' => $_SESSION['customer_id'],

                    'addtime' => date('Y-m-d H:i;s'),

                    'method' => $shippings,

                    'account' => $acounts);

                zen_db_perform('orders_shipping', $sql_data_array);

            }

        }

    }

    /**
     * @param $order_id
     * 更新关联运单邮件表
     */
    function update_related_email($order_id)
    {
        if (!empty($_SESSION['related_email'])) {
            $email_arr = $_SESSION['related_email'];
            foreach ($email_arr as $value) {
                if ($value['email'] && $value['name']) {
                    $data = array(
                        "orders_id" => $order_id,
                        "customers_relate_email" => zen_db_input($value['email']),
                        "customers_relate_name" => $value['name'] ? zen_db_input($value['name']) : ''
                    );
                    zen_db_perform('email_to_customers', $data);
                }
            }
        }
    }


    /**
     * add by aron
     * @param $zf_insert_id 订单id
     * @param bool $zf_mode
     * @param $set_pro 当前分单 产品信息
     * @param $warehouse  仓库
     */
    function create_add_products_new($zf_insert_id, $zf_mode = false, $set_pro, $warehouse, $is_reissue)
    {

        global $db, $currencies, $order_total_modules, $order_totals;

        // initialized for the email confirmation

        $this->products_ordered = '';

        $this->products_ordered_html = '';

        $this->subtotal = 0;

        $this->total_tax = 0;


        // lowstock email report

        $this->email_low_stock = '';

        $delivery_country = zen_get_order_product_of_countries($zf_insert_id);
        //$products_custom = fs_get_data_from_db_fields('products_custom','orders','orders_id ='.$zf_insert_id,'');
        $products_custom = 0; //之前客户可以标记定制那么不进入西雅图,现功能已隐藏
        $is_special = 0;
        if ($_SESSION['customer_id']) {
            $customer_type = fs_customer_order_product_is_instock($_SESSION['customer_id']);
            if ($customer_type) {
                if ($customer_type == 1) {
                    $is_special = 1;  //全部需要销售确认
                } else {
                    $instock_category = $customer_type;  //对应分类下产品需要销售确认
                }
            }
        }

        $country_flag = '';
        if ($delivery_country) {
            $flag = fs_get_data_from_db_fields('flag', 'countries', 'countries_name="' . $delivery_country . '"', 'limit 1');
            switch ($this->local_warehouse) {
                case 20:
                    $country_flag = 'DE';
                    break;
                case 3:
                    $country_flag = 'US';
                    break;
                case 2:
                    $country_flag = 'CN';
                    break;
                case 40:
                    $country_flag = 'US';
                    break;
                case 37:
                    $country_flag = 'AU';
                    break;
                case 71:
                    $country_flag = 'SG';
                    break;
            }
        }
//        $warehouse = $this->local_warehouse ? $this->local_warehouse : 2;
        if ($warehouse == 2) {
            $warehouse = 1; //武汉仓库存锁定深圳仓库存
        }
        $FsCustomRelate = new classes\custom\FsCustomRelate();
        for ($i = 0, $n = sizeof($set_pro); $i < $n; $i++) {

            $custom_insertable_text = '';

            // Stock Update - Joao Correia

            if (STOCK_LIMITED == 'true') {

                if (DOWNLOAD_ENABLED == 'true') {

                    $stock_query_raw = "select p.products_quantity,p.product_is_always_free_shipping

                              from " . TABLE_PRODUCTS . " p

                              left join " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                               on p.products_id=pa.products_id

                               on pa.products_attributes_id=pad.products_attributes_id

                              WHERE p.products_id = '" . zen_get_prid($set_pro[$i]['id']) . "'";


                    // Will work with only one option for downloadable products

                    // otherwise, we have to build the query dynamically with a loop

                    $products_attributes = $set_pro[$i]['attributes'];

                    if (is_array($products_attributes)) {

                        $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";

                    }

                    $stock_values = $db->Execute($stock_query_raw);

                } else {

                    $stock_values = $db->Execute("select * from " . TABLE_PRODUCTS . " where products_id = '" . zen_get_prid($set_pro[$i]['id']) . "'");

                }


                $this->notify('NOTIFY_ORDER_PROCESSING_STOCK_DECREMENT_BEGIN');


                if ($stock_values->RecordCount() > 0) {

                    // do not decrement quantities if products_attributes_filename exists

                    if ((DOWNLOAD_ENABLED != 'true') || $stock_values->fields['product_is_always_free_shipping'] == 2) {

                        $stock_left = $stock_values->fields['products_quantity'] - $set_pro[$i]['qty'];

                        $set_pro[$i]['stock_reduce'] = $set_pro[$i]['qty'];

                    } else {

                        $stock_left = $stock_values->fields['products_quantity'];

                    }


                    // $db->Execute("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");


                    //当产品数量低于1时  关闭该产品
                    /*
                    if ($stock_left <= 0) {
                      if (SHOW_PRODUCTS_SOLD_OUT == '0') {
                        $db->Execute("update " . TABLE_PRODUCTS . " set products_status = 0 where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");
                      }
                    }
                   */


                    // for low stock email

                    if ($stock_left <= STOCK_REORDER_LEVEL) {

                        // WebMakers.com Added: add to low stock email

                        $this->email_low_stock .= 'ID# ' . zen_get_prid($set_pro[$i]['id']) . "\t\t" . $set_pro[$i]['model'] . "\t\t" . $set_pro[$i]['name'] . "\t\t" . ' Qty Left: ' . $stock_left . "\n";

                    }

                }

            }

            //下单后更新产品的数量
            $db->Execute("update products set products_quantity = products_quantity - " . $set_pro[$i]['qty'] . " where products_id = " . zen_get_prid($set_pro[$i]['id']) . "");

            // Update products_ordered (for bestsellers list)

            //    $db->Execute("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . zen_get_prid($order->products[$i]['id']) . "'");

            $db->Execute("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%f', $set_pro[$i]['qty']) . " where products_id = '" . zen_get_prid($set_pro[$i]['id']) . "'");


            $this->notify('NOTIFY_ORDER_PROCESSING_STOCK_DECREMENT_END');


            // fairy 2019.2.21 add 组合产品的子产品信息
            $composite_son_products = $_SESSION['cart']->get_cart_quotation_combination($set_pro[$i]['id'], $set_pro[$i]['qty']);//报价价格

            $composite_son_products_tax = $this->delivery['country_id'] == 13 ?
                $_SESSION['cart']->get_cart_quotation_combination($set_pro[$i]['id'], $set_pro[$i]['qty'], true) :
                $composite_son_products;

            //有属性的组合产品  根据选择的属性 查找对应的子产品  SQ20190910029
            $combination_arr = array();
            $attr_str = '';
            if ($set_pro[$i]['attributes']) {
                foreach ($set_pro[$i]['attributes'] as $option => $val) {
                    $combination_arr[] = (int)$val['value_id'];
                }
                if ($combination_arr) {
                    $attr_str = reorder_options_values($combination_arr);
                }
            }
            $products_composite_str = '';
            if (class_exists('classes\CompositeProducts')) {
                $CompositeProducts = new classes\CompositeProducts(zen_get_prid($set_pro[$i]['id']), '', $attr_str);
                $products_composite_str = $CompositeProducts->get_products_composite($set_pro[$i]['qty'], '', '', true, '', false);  // 取消企业用户打折处理
//                if ($products_composite_str != '') {
//                    $composite_origin_son_products = $products_composite_str;//原价格
//                }

                $products_composite_str_tax = $this->delivery['country_id'] == 13 ? $CompositeProducts->get_products_composite($set_pro[$i]['qty'], '', '', true,'',false, true) : $products_composite_str;
            }


            $sql_data_array = array('orders_id' => $zf_insert_id,

                'products_id' => zen_get_prid($set_pro[$i]['id']),

                'products_model' => $set_pro[$i]['model'],

                'products_name' => $set_pro[$i]['name'],

                'products_price' => $set_pro[$i]['products_price'],

                'final_price' => $set_pro[$i]['paypal_price'],

                'tax_after_price' => $set_pro[$i]['aftertax_price'],

                'onetime_charges' => $set_pro[$i]['onetime_charges'],

                'products_tax' => $set_pro[$i]['tax'],

                'products_quantity' => $set_pro[$i]['qty'],

                'products_priced_by_attribute' => $set_pro[$i]['products_priced_by_attribute'],

                'product_is_free' => $set_pro[$i]['product_is_free'],

                'products_discount_type' => $set_pro[$i]['products_discount_type'],

                'products_discount_type_from' => $set_pro[$i]['products_discount_type_from'],

                //'is_seattle_warehouse' => $is_seattle_warehouse,

                'is_instock' => 0,

                'is_heavy' => in_array(zen_get_prid((int)$set_pro[$i]['id']), $this->heavy_products) ? 1 : 0,

                'composite_son_products' => !empty($composite_son_products) ? $composite_son_products : $products_composite_str,  // fairy 2019.2.21 add 组合产品的子产品信息

                'composite_origin_son_products' => $products_composite_str,  // fairy 2019.2.21 add 组合产品的子产品信息

                'composite_son_products_tax' => !empty($composite_son_products_tax) ?
                    $composite_son_products_tax : $products_composite_str_tax,  // 税后组合产品子产品价格

                'products_prid' => $set_pro[$i]['id'],

                'relate_material_id' => $set_pro[$i]['relate_material_id'], // Jeremy 20.20.5.25 add 关联毛料产品ID

                'from_orders_number' => $set_pro[$i]['orders_number'],  //ery 2020.05.25 记录客户在账户中心订单相关页面加购产品的来源订单号

            );

            zen_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

            $order_products_id = $db->Insert_ID();

            /* 系统判断是否库存直发,先排除西雅图直发的 */
            // if($is_seattle_warehouse !=1){
            //$is_instock =fs_warehouse_instock_of_custom((int)$this->products[$i]['id'],$is_special,$order_products_id,$this->products[$i]['qty']);
            //if($is_instock){
            //$db->Execute("update " . TABLE_ORDERS_PRODUCTS . " set is_instock = '".$is_instock."' where orders_products_id= ".$order_products_id);
            //}
            // }

            $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_PRODUCT_LINE_ITEM', array_merge(array('orders_products_id' => $order_products_id), $sql_data_array));

            $this->notify('NOTIFY_ORDER_PROCESSING_CREDIT_ACCOUNT_UPDATE_BEGIN');

            $order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM

            $this->notify('NOTIFY_ORDER_PROCESSING_ATTRIBUTES_BEGIN');

            //------ bof: insert customer-chosen options to order--------

            $attributes_exist = '0';

            $this->products_ordered_attributes = '';

            if (isset($set_pro['attributes'])) {

                for ($j = 0, $n2 = sizeof($set_pro[$i]['attributes']); $j < $n2; $j++) {

                    if ($set_pro[$i]['attributes'][$j]['value'] == 'length') {

                        if (isset($set_pro[$i]['attributes'][$j]['value_id'])) {

                            $length_s = get_outer_jacket_length($set_pro[$i]['attributes'][$j]['value_id']);

                        } else {

                            $length_s = 1;

                        }

                    }

                }

            }

            if (isset($set_pro[$i]['attributes'])) {

                $attributes_exist = '1';

                for ($j = 0, $n2 = sizeof($set_pro[$i]['attributes']); $j < $n2; $j++) {

                    if ($set_pro[$i]['attributes'][$j]['value'] != 'length') {

                        if (DOWNLOAD_ENABLED == 'true') {

                            $attributes_query = "select popt.products_options_name, poval.products_options_values_name,

                                 pa.options_values_price, pa.price_prefix,

                                 pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,

                                 pa.attributes_discounted, pa.attributes_price_base_included, pa.attributes_price_onetime,

                                 pa.attributes_price_factor, pa.attributes_price_factor_offset,

                                 pa.attributes_price_factor_onetime, pa.attributes_price_factor_onetime_offset,

                                 pa.attributes_qty_prices, pa.attributes_qty_prices_onetime,

                                 pa.attributes_price_words, pa.attributes_price_words_free,

                                 pa.attributes_price_letters, pa.attributes_price_letters_free,


                                 from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " .

                                TABLE_PRODUCTS_ATTRIBUTES . " pa

                           

                                  on pa.products_attributes_id=pad.products_attributes_id

                                 where pa.products_id = '" . zen_db_input($set_pro[$i]['id']) . "'

                                  and pa.options_id = '" . $set_pro[$i]['attributes'][$j]['option_id'] . "'

                                  and pa.options_id = popt.products_options_id

                                  and pa.options_values_id = '" . $set_pro[$i]['attributes'][$j]['value_id'] . "'

                                  and pa.options_values_id = poval.products_options_values_id

                                  and popt.language_id = '" . $_SESSION['languages_id'] . "'

                                  and poval.language_id = '" . $_SESSION['languages_id'] . "'";


                            $attributes_values = $db->Execute($attributes_query);

                        } else {

                            $attributes_values = $db->Execute("select popt.products_options_name, poval.products_options_values_name,

                                 pa.options_values_price, pa.price_prefix,

                                 pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,

                                 pa.attributes_discounted, pa.attributes_price_base_included, pa.attributes_price_onetime,

                                 pa.attributes_price_factor, pa.attributes_price_factor_offset,

                                 pa.attributes_price_factor_onetime, pa.attributes_price_factor_onetime_offset,

                                 pa.attributes_qty_prices, pa.attributes_qty_prices_onetime,

                                 pa.attributes_price_words, pa.attributes_price_words_free,

                                 pa.attributes_price_letters, pa.attributes_price_letters_free

                                 from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                                 where pa.products_id = '" . $set_pro[$i]['id'] . "' and pa.options_id = '" . (int)$set_pro[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$set_pro[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $_SESSION['languages_id'] . "' and poval.language_id = '" . $_SESSION['languages_id'] . "'");

                        }


                        $options_values_price = $attributes_values->fields['options_values_price'];

                        if (isset($_SESSION['cart']->contents[$set_pro[$i]['id']]['fiber_count']['option_id'])) {

                            if ($_SESSION['cart']->contents[$set_pro[$i]['id']]['fiber_count']['option_id'] == (int)$set_pro[$i]['attributes'][$j]['option_id']) {

                                $options_values_price += $_SESSION['cart']->contents[$set_pro[$i]['id']]['fiber_count']['options_values_price'];

                            }

                        }

                        $options_values_price = get_outer_jacket_options_values_price($set_pro[$i]['attributes'][$j]['option_id'], $options_values_price, $length_s);

                        if ($re = fs_attribute_column_option_value_price($set_pro[$i]['id'], $_SESSION['cart']->columnID, (int)$set_pro[$i]['attributes'][$j]['option_id'], (int)$set_pro[$i]['attributes'][$j]['value_id'], $length_s)) {
                            $options_values_price = $re[0];
                            if ($re[1] == '-') {
                                $attributes_values->fields['price_prefix'] = '-';
                            }
                        }

                        //clr 030714 update insert query.  changing to use values form $order->products for products_options_values.
                        $option_name = $attributes_values->fields['products_options_name'];
                        if (!$option_name) {
                            $option_name = fs_get_data_from_db_fields('products_options_name', TABLE_PRODUCTS_OPTIONS, 'products_options_id=' . (int)$set_pro[$i]['attributes'][$j]['option_id'] . ' and language_id = ' . $_SESSION['languages_id'], 'limit 1');
                        }
                        $value_name = $set_pro[$i]['attributes'][$j]['value'];
                        if (!$value_name) {
                            $value_name = fs_get_data_from_db_fields('products_options_values_name', TABLE_PRODUCTS_OPTIONS_VALUES, 'products_options_values_id=' . (int)$set_pro[$i]['attributes'][$j]['value_id'] . ' and language_id = ' . $_SESSION['languages_id'], 'limit 1');
                        }
                        $sql_data_array = array('orders_id' => $zf_insert_id,

                            'orders_products_id' => $order_products_id,

                            'products_options' => $option_name,

                            'products_options_values' => $value_name,

                            'options_values_price' => $options_values_price,

                            'price_prefix' => $attributes_values->fields['price_prefix'],

                            'product_attribute_is_free' => $attributes_values->fields['product_attribute_is_free'],

                            'products_attributes_weight' => $attributes_values->fields['products_attributes_weight'],

                            'products_attributes_weight_prefix' => $attributes_values->fields['products_attributes_weight_prefix'],

                            'attributes_discounted' => $attributes_values->fields['attributes_discounted'],

                            'attributes_price_base_included' => $attributes_values->fields['attributes_price_base_included'],

                            'attributes_price_onetime' => $attributes_values->fields['attributes_price_onetime'],

                            'attributes_price_factor' => $attributes_values->fields['attributes_price_factor'],

                            'attributes_price_factor_offset' => $attributes_values->fields['attributes_price_factor_offset'],

                            'attributes_price_factor_onetime' => $attributes_values->fields['attributes_price_factor_onetime'],

                            'attributes_price_factor_onetime_offset' => $attributes_values->fields['attributes_price_factor_onetime_offset'],

                            'attributes_qty_prices' => $attributes_values->fields['attributes_qty_prices'],

                            'attributes_qty_prices_onetime' => $attributes_values->fields['attributes_qty_prices_onetime'],

                            'attributes_price_words' => $attributes_values->fields['attributes_price_words'],

                            'attributes_price_words_free' => $attributes_values->fields['attributes_price_words_free'],

                            'attributes_price_letters' => $attributes_values->fields['attributes_price_letters'],

                            'attributes_price_letters_free' => $attributes_values->fields['attributes_price_letters_free'],

                            'products_options_id' => (int)$set_pro[$i]['attributes'][$j]['option_id'],

                            'products_options_values_id' => (int)$set_pro[$i]['attributes'][$j]['value_id'],

                            'products_prid' => $set_pro[$i]['id'],

                            'upload_file' => $set_pro[$i]['attributes'][$j]['attributes_file'],

                        );


                        zen_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);


                        $this->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ATTRIBUTE_LINE_ITEM', $sql_data_array);


                        $this->products_ordered_attributes .= "\n\t" . $attributes_values->fields['products_options_name'] . ' ' . zen_decode_specialchars($set_pro[$i]['attributes'][$j]['value']);

                    } else {

                        $attributes_values = $db->query("insert into order_product_length set orders_id = '$zf_insert_id',orders_products_id='$order_products_id',price_prefix='" . $set_pro[$i]['attributes'][$j]['prefix'] . "',length_price='" . $set_pro[$i]['attributes'][$j]['price'] . "',length_name='" . $set_pro[$i]['attributes'][$j]['option'] . "',products_prid='" . $set_pro[$i]['id'] . "'");

                    }

                }

            }

            //  定制产品录单   获取关联标准产品ID
            $thisAttr = array();
            $standard_products = (int)$set_pro[$i]['id'];
            $thisAttr = $FsCustomRelate::getOrdersProductsAttr($order_products_id);
            if (is_array($thisAttr['attr']) && sizeof($thisAttr['attr'])) {
                $FsCustomRelate::$products_id = $set_pro[$i]['id'];
                $FsCustomRelate::$optionAttr = $thisAttr['attr'];
                $FsCustomRelate::$length = $thisAttr['length'];
                $matchProducts = $FsCustomRelate->handle();
                if ($matchProducts) {
                    $standard_products = $matchProducts[0];
                }
            }

            $instockQty = 0;
            $isCompositeProducts = false;
            $relatedProducts = array();
            if (class_exists('classes\CompositeProducts')) {
                $CompositeProducts = new classes\CompositeProducts($standard_products);
                if ($CompositeProducts->CompositeProductsRelated()) {
                    $instockQty = $CompositeProducts->CompositeRelatedInstock(($warehouse ? $warehouse : 2), true);
                    $relatedProducts = $CompositeProducts::$relatedArray;
                    $isCompositeProducts = true;
                }
            }
            if ($relatedProducts && sizeof($relatedProducts) && $isCompositeProducts) {
                $is_seattle_warehouse = 0;
                $PinstockArray = array();
                foreach ($relatedProducts as $composite) {
                    $PinstockID = fs_get_data_from_db_fields('products_instock_id', 'products_instock', 'products_id=' . (int)$composite['id'], 'order by warehouse limit 1');
                    if ($country_flag) {
                        //如果客户没有勾选定制标签
                        if ($products_custom == 0) {
                            //如果销售在后台没有指定定制客户
                            if ($is_special == 0) {
                                $instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =" . (int)$composite['id'] . " and warehouse = " . $warehouse);
                                if ($instockQty >= $set_pro[$i]['qty']) {
                                    $update_status = 1;
                                    if (isset($instock_category) && is_array($instock_category)) {                                           //客户某些分类订单 需销售确认
                                        $update_status = fs_customer_order_product_auto_instock((int)$composite['id'], $instock_category);
                                    }
                                    if ($update_status) {
                                        $is_seattle_warehouse = $country_flag == 'US' ? 1 : 3;
                                        $PinstockID = $instockSQL->fields['products_instock_id'];
                                        $db->Execute("update orders_products set is_seattle_warehouse = " . $is_seattle_warehouse . " where orders_products_id = " . $order_products_id);
                                    }
                                }
                            }
                        }
                    }
                    $seattle_warehouse[] = $is_seattle_warehouse;
                    if ($PinstockID) {
                        $PinstockArray = array(
                            'orders_id' => $zf_insert_id,
                            'products_id' => (int)$composite['id'],
                            'qty' => $set_pro[$i]['qty'] * $composite['num'],
                            'instock_id' => $PinstockID,
                            'date' => 'now()',
                            'seattle_lock' => $is_seattle_warehouse
                        );
                        zen_db_perform('products_instock_orders', $PinstockArray);
                    }
                }
            } else {
                //如果该产品是有库存的,那么及时调用至订单库存表
                $lockService =  new \App\Services\ProductsInstocks\LockProductInstockService();
                $relatedID = zen_get_products_related_model((int)$standard_products);
                if (!empty($relatedID)) {
                    $is_seattle_warehouse = 0;
                    $codeRelatedClass = new classes\codeRelatedProducts($standard_products, $set_pro[$i]['qty'], $warehouse);
                    if ($codeRelatedClass::verifyProductsInstock() && in_array($warehouse, array(3, 20, 40)) && in_array($country_flag, array("DE", "US", 'SG'))) {
                        $PinstockID = $codeRelatedClass::getThisIstockID();
                        $lockService->lockQty($relatedID, $is_reissue, $zf_insert_id, $set_pro[$i]['qty'], $PinstockID);
                    } else {
                        if ($is_reissue == 12 || $is_reissue == 6) {
                            $stock_warehouse = $is_reissue == 12 ? 98 : 104;
                            //匹配到半成品使用当前id发货
                            $customID = $db->Execute('select customized_id from products_instock_customized_related where products_id = ' . $relatedID . ' or customized_id = ' . $relatedID . ' limit 1')->fields['customized_id'];
                            if (isset($customID) && $customID == $relatedID) {
                                $instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =" . $relatedID . " and warehouse = $stock_warehouse");
                            } else {
                                $currentQty = $codeRelatedClass::getProductsEnabledNum($relatedID, $warehouse);
                                $currentQty = $currentQty['instock_qty'] ? $currentQty['instock_qty'] : 0;
                                if ($currentQty < $set_pro[$i]['qty'] && isset($customID)) {
                                    $instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =" . $customID . " and warehouse = $stock_warehouse");
                                } else {
                                    $instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =" . $relatedID . " and warehouse = " . $warehouse);
                                }
                            }
                            $instock_id = $instockSQL->fields['products_instock_id'] ? $instockSQL->fields['products_instock_id'] : 0;
                            $lockService->lockQty($relatedID,$is_reissue,$zf_insert_id,$set_pro[$i]['qty'],$instock_id);
                        } else {
                            $cn_qty_info = [];
                            if (in_array($is_reissue, [7, 8, 10, 25, 4, 14])) {
                                $warehouseClass = new \classes\warehouseClass();
                                $cn_qty_info = $warehouseClass->getCnInstock((int)$standard_products);
                            }
                            $lockService->lockQty($relatedID, $is_reissue, $zf_insert_id, $set_pro[$i]['qty'],0, $cn_qty_info);
                        }
                    }
                }
            }

            //------eof: insert customer-chosen options ----

            $this->notify('NOTIFY_ORDER_PROCESSING_ATTRIBUTES_EXIST', $attributes_exist);


            $this->notify('NOTIFY_ORDER_DURING_CREATE_ADD_PRODUCTS', $custom_insertable_text);


            /* START: ADD MY CUSTOM DETAILS

             * 1. calculate/prepare custom information to be added to this product entry in order-confirmation, perhaps as a function call to custom code to build a serial number etc:

             *   Possible parameters to pass to custom functions at this point:

             *     Product ID ordered (for this line item): $this->products[$i]['id']

             *     Quantity ordered (of this line-item): $this->products[$i]['qty']

             *     Order number: $zf_insert_id

             *     Attribute Option Name ID: (int)$this->products[$i]['attributes'][$j]['option_id']

             *     Attribute Option Value ID: (int)$this->products[$i]['attributes'][$j]['value_id']

             *     Attribute Filename: $attributes_values->fields['products_attributes_filename']

             *

             * 2. Add that data to the $this->products_ordered_attributes variable, using this sort of format:

             *      $this->products_ordered_attributes .=  {INSERT CUSTOM INFORMATION HERE};

             */


            $this->products_ordered_attributes .= $custom_insertable_text;


            /* END: ADD MY CUSTOM DETAILS */


            // update totals counters

            $this->total_weight += ($set_pro[$i]['qty'] * $set_pro[$i]['weight']);

            $this->total_tax += zen_calculate_tax($total_products_price, $products_tax) * $set_pro[$i]['qty'];

            $this->total_cost += $total_products_price;


            $this->notify('NOTIFY_ORDER_PROCESSING_ONE_TIME_CHARGES_BEGIN');


            // build output for email notification

            $this->products_ordered .= $set_pro[$i]['qty'] . ' x ' . $set_pro[$i]['name'] . ($set_pro[$i]['model'] != '' ? ' (' . $set_pro[$i]['model'] . ') ' : '') . ' = ' .

                $currencies->display_price($set_pro[$i]['final_price'], $set_pro[$i]['tax'], $set_pro[$i]['qty']) .

                ($set_pro[$i]['onetime_charges'] != 0 ? "\n" . TEXT_ONETIME_CHARGES_EMAIL . $currencies->display_price($set_pro[$i]['onetime_charges'], $set_pro[$i]['tax'], 1) : '') .

                $this->products_ordered_attributes . "\n";

            $this->products_ordered_html .=

                '<tr>' . "\n" .

                '<td class="product-details" align="right" valign="top" width="30">' . $set_pro[$i]['qty'] . '&nbsp;x</td>' . "\n" .

                '<td class="product-details" valign="top">' . nl2br($set_pro[$i]['name']) . ($set_pro[$i]['model'] != '' ? ' (' . nl2br($set_pro[$i]['model']) . ') ' : '') . "\n" .

                '<nobr>' .

                '<small><em> ' . nl2br($this->products_ordered_attributes) . '</em></small>' .

                '</nobr>' .

                '</td>' . "\n" .

                '<td class="product-details-num" valign="top" align="right">' .

                $currencies->display_price($set_pro[$i]['final_price'], $set_pro[$i]['tax'], $set_pro[$i]['qty']) .

                ($set_pro[$i]['onetime_charges'] != 0 ?

                    '</td></tr>' . "\n" . '<tr><td class="product-details">' . nl2br(TEXT_ONETIME_CHARGES_EMAIL) . '</td>' . "\n" .

                    '<td>' . $currencies->display_price($set_pro[$i]['onetime_charges'], $set_pro[$i]['tax'], 1) : '') .

                '</td></tr>' . "\n";

        }

        $order_total_modules->apply_credit();//ICW ADDED FOR CREDIT CLASS SYSTEM

        $this->notify('NOTIFY_ORDER_AFTER_ORDER_CREATE_ADD_PRODUCTS');

    }

    function email_text_spacing($height = '', $border_style = '')
    {
        $html =
            '<table width="640" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                    <td bgcolor="#ffffff" style="' . $border_style . 'border-collapse: collapse" height="' . $height . '">

                    </td>
            </tr>
            </tbody>
        </table>';
        return $html;
    }

    function get_email_series_time($date_purchased, $id, $delivery_postcode)
    {
        global $db;
        $order_time = $ship_time = $expected_delivery = '';

        // 1.下单时间
        $date = getTime("D. M. j", strtotime($date_purchased), $_SESSION['countries_code_21']);
        $order_time = get_date_product_delivery($date, $_SESSION['languages_id'],2);
        //德英站、英国、澳洲时间格式不同
        if (in_array($_SESSION['languages_code'], array('au', 'uk', 'dn'))) {
            $order_time = getTime('D.', strtotime($date_purchased), $_SESSION['countries_code_21']) . getTime('j', strtotime($date_purchased), $_SESSION['countries_code_21']) . getLast(getTime('j', strtotime($date_purchased), $_SESSION['countries_code_21'])) . ' ' . getTime('M.', strtotime($date_purchased), $_SESSION['countries_code_21']);
        }

        // 2.运输时间
        $item_order_info = array();
        $info_sql = "select orders_id,orders_number,shipping_method,warehouse,is_reissue,delivery_country,currency from orders where orders_id=" . $id;
        $items_sql = "select sum(products_quantity) as num from orders_products where orders_id=" . $id;
        $items = $db->getAll($items_sql);
        $items = $items["0"]['num'];
        $info_res = $db->Execute($info_sql);
        $product_ord = zen_get_products_by_order_id($id, $info_res->fields['currency']);
        while (!$info_res->EOF) {
            $item_order_info[] = array(
                'orders_id' => $info_res->fields['orders_id'],
                'orders_number' => $info_res->fields['orders_number'],
                'shipping_method' => $info_res->fields['shipping_method'],
                'warehouse' => $info_res->fields['warehouse'],
                'items' => $items,
                'is_reissue' => $info_res->fields['is_reissue'],
                'products' => $product_ord,
                'delivery_country' => $info_res->fields['delivery_country']

            );
            $info_res->MoveNext();
        }
        $ship_time = getOrderDate($item_order_info[0]);
        $ship_time = strip_tags($ship_time);
        if ($ship_time == FS_SHIP_SAME_DAY) {
            $ship_time = $order_time;
        }
        // 3.获取交期

        $country_code = fs_get_data_from_db_fields('countries_iso_code_2', 'countries', 'countries_name LIKE "' . $item_order_info[0]['delivery_country'] . '"', 'limit 1');
        $hour = getTime('G', time(), $country_code);
        $day = '';

        if (in_array($item_order_info[0]['is_reissue'], array(1, 4, 6, 9, 12))) {
            $day = 0;
            if ($hour >= 16 && in_array($item_order_info[0]['warehouse'], array(3, 20, 40))) {
                $day = 1;
            }
        } else {
            $time_data = get_max_date($item_order_info[0]['products'], $item_order_info[0]["warehouse"], $country_code);
            $day = $time_data['max_time']['time'];
        }

        $postcode = $delivery_postcode;
        $shipping_module_code = fs_get_data_from_db_fields('shipping_module_code', 'orders', 'orders_id =' . (int)$id, 'limit 1');
        if ($country_code == 'US' && in_array($shipping_module_code, ['fedexgroundeastzones', 'upsgroundeastzones'])) {
            if (!empty($postcode)) {
                $info = fs_get_data_from_db_fields_array(array('timeliness_md', 'timeliness_mx', 'zone'), 'countries_to_zip', 'zip ="' . $postcode . '" ');
                if ($info) {
                    $zone = $info[0][2];
                    $mx_day = $info[0][1];
                    $md_day = $info[0][0];
                    if ($zone == 1) {
                        $day += $md_day;
                    } else {
                        $day += $mx_day;
                    }
                    if (empty($day)) {
                        $day += 2;
                    }
                    $sun_day = 0;
                    if ((getTime("D", '+' . $day . ' days', $country_code) == "Sun" || getTime("D", '+' . $day . ' days', $country_code) == "Sat")) {
                        if (getTime("D", '+' . $day . ' days', $country_code) == "Sun") {
                            $sun_day += 1;
                        } else {
                            $sun_day += 2;
                        }
                    }
                    $festival_day = get_festival_day($country_code);
                    $festival_day = ($festival_day - $sun_day) < 0 ? 0 : ($festival_day - $sun_day);
                    $day = $day + $sun_day;
                    $day = $day + $festival_day;

                    $arrive_day = getTime('D', strtotime('+' . $day . ' days'), $country_code);

                    if (($arrive_day == "Sun" || $arrive_day == "Sat")) {
                        if ($arrive_day == "Sat") {
                            $day += 2;
                        } else {
                            $day += 1;
                        }
                    }

                    $expected_delivery = getTime('D. M. j', strtotime('+' . $day . ' days'), $country_code);
                    $expected_delivery = get_date_product_delivery($expected_delivery, $_SESSION['languages_id'],2);
                    //德英站、英国、澳洲时间格式不同
                    if (in_array($_SESSION['languages_code'], array('au', 'uk', 'dn'))) {
                        $expected_delivery = getTime('D.', strtotime('+' . $day . ' days'), $country_code) . getTime('j', strtotime('+' . $day . ' days'), $country_code) . getLast(getTime('j', strtotime('+' . $day . ' days'), $country_code)) . ' ' . getTime('M.', strtotime('+' . $day . ' days'), $country_code);
                    }
                } else {
                    $expected_delivery = '';
                }
            } else {
                $expected_delivery = '';
            }
        } else {
            $day += fs_get_data_from_db_fields('shipping_time', 'shipping_effectiveness', 'code = "' . $country_code . '" and shipping_methods = "' . $shipping_module_code . '"', 'limit 1');
            if (!$day) {
                $expected_delivery = '';
            } else {
                $festival_day = get_festival_day($country_code);
                $sun_date = getTime("D", '+' . $day . ' days', $country_code);
                $sun_day = 0;
                if (($sun_date == "Sun" || $sun_date == "Sat")) {
                    if ($sun_date == "Sat") {
                        $sun_day = 2;
                    } else {
                        $sun_day = 1;
                    }
                    $festival_day = ($festival_day - $sun_day) < 0 ? 0 : ($festival_day - $sun_day);
                }
                $day = $day + $sun_day;
                $day = $day + $festival_day;

                $arrive_day = getTime('D', strtotime('+' . $day . ' days'), $country_code);

                if (($arrive_day == "Sun" || $arrive_day == "Sat")) {
                    if ($arrive_day == "Sat") {
                        $day += 2;
                    } else {
                        $day += 1;
                    }
                }
                $expected_delivery = getTime('D. M. j', strtotime('+' . $day . ' days'), $country_code);
                $expected_delivery = get_date_product_delivery($expected_delivery, $_SESSION['languages_id'],2);
                //德英站、英国、澳洲时间格式不同
                if (in_array($_SESSION['languages_code'], array('au', 'uk', 'dn'))) {
                    $expected_delivery = getTime('D.', strtotime('+' . $day . ' days'), $country_code) . getTime('j', strtotime('+' . $day . ' days'), $country_code) . getLast(getTime('j', strtotime('+' . $day . ' days'), $country_code)) . ' ' . getTime('M.', strtotime('+' . $day . ' days'), $country_code);
                }
            }
        }
        //如果选择星期6运送方式
        if (in_array($shipping_module_code, ['saturdaydeliveryzones', 'dhlsaturdayzones'])) {
            $expected_delivery = getTime('D. M. j', strtotime('+1 days'), $country_code);
            $expected_delivery = get_date_product_delivery($expected_delivery, $_SESSION['languages_id'],2);
            if (in_array($_SESSION['languages_code'], array('au', 'uk', 'dn'))) {
                $expected_delivery = getTime('D.', strtotime('+1 days'), $country_code) . getTime('j', strtotime('+1 days'), $country_code) . getLast(getTime('j', strtotime('+1 days'), $country_code)) . ' ' . getTime('M.', strtotime('+1 days'), $country_code);
            }
        }

        $time = array('order_time' => $order_time, 'ship_time' => $ship_time, 'expected_delivery' => $expected_delivery);
        return $time;
    }

    function send_order_email($zf_insert_id, $zf_mode)
    {
        global $currencies, $order_totals, $db;
        //低库存邮件
        if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL == '1') {
            // send an email
            $email_html = zen_get_corresponding_languages_email_common();
            $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
            $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];

            $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;
            $html_msg['EMAIL_MESSAGE_HTML'] = nl2br($email_low_stock);

            zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, $html_msg, 'low_stock_to_us');
        }

        $email_warehouse_info = get_email_langpac();

        //自提标识 $is_local_pickup
        $shipping_method = zen_get_order_shipping_method_by_code($this->info['shipping_method'], $zf_insert_id);
        $is_local_pickup = false;
        if ($shipping_method == 'Local Pickup') {
            $is_local_pickup = true;
        }

        //PO订单标识 $purchase_order_num
        $orderResult = $db->getAll("select purchase_order_num,customers_po,payment_module_code,customers_id,orders_number from orders where orders_id = " . $zf_insert_id . " limit 1");
        $this->info['orders_number'] = $orderResult[0]['orders_number'];
        $purchase_order_num = $orderResult[0]['purchase_order_num'];

        //Add Order Comments标识
        $customers_po_num = $orderResult[0]['customers_po'];
        $purchase = trim($orderResult[0]['payment_module_code']);

        //游客标识 $is_customer
        $is_customer = $orderResult[0]['customers_id'];
        /* 第一部分 */
        $son_order = array();
        if ($zf_insert_id) $son_order = zen_get_all_son_order_id($zf_insert_id);
        if (!count($son_order)) {
            $son_order[] = $zf_insert_id;
        }

        $purchase_order_num_html = '';
        if ($customers_po_num) {
            $purchase_order_num_html = ' (' . FS_SEND_EMAIL_71 . '<a href="javascript:;" style="color: #232323;text-decoration: none">' . $customers_po_num . '</a>)';
        }

        $order_num = count($son_order);
        $order_number = '';
        $divided_order = '';
        if ($order_num === 1) {
            $order_number = $orderResult[0]['orders_number'];
            $orderNumText = '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $zf_insert_id, 'SSL') . '">#' . $order_number . '</a>';
            if (!$is_customer) {
                $orderNumText = '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>';
            }
            $first_sentence = FS_ORDER_EMAIL_01 . $orderNumText . $purchase_order_num_html . FS_ORDER_EMAIL_02;
            if ($this->info['payment_module_code'] == 'purchase') {
                $first_sentence = FS_ORDER_EMAIL_01 . $orderNumText . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_46;
            }
            if ($purchase == 'alfa') {
                $first_sentence = str_replace('[ORDERNUMBER]', ' ' . $orderNumText, FS_ORDER_EMAIL_51);
            }
        } else {
            $first_sentence = FS_ORDER_EMAIL_07;
            if ($this->info['payment_module_code'] == 'purchase') {
                $first_sentence = FS_ORDER_EMAIL_01 . FS_ORDER_EMAIL_46;
            }
            if ($purchase == 'alfa') {
                $first_sentence = str_replace('[ORDERNUMBER]', '', FS_ORDER_EMAIL_51);
            }
            $divided_order =
                '<table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                    ' . FS_ORDER_EMAIL_11 . $order_num . FS_ORDER_EMAIL_12 . '
                    </td>
                </tr>
                </tbody>
            </table>' . $this->email_text_spacing(10);
        }
        $manage_orders =
            '<table width="640" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="center">
                    <a style="font-size: 14px;display: inline-block;text-decoration: none;color: #0070BC;padding: 10px 12px;border: 1px solid #0070BC;border-radius:2px;" href="' . zen_href_link(FILENAME_MANAGE_ORDERS, '', 'SSL') . '">' . FS_ORDER_EMAIL_13 . '</a>
                </td>
            </tr>
            </tbody>
        </table>';
        if ($is_customer) {
            $html_msg['MANAGE_ORDERS'] = $manage_orders . $this->email_text_spacing(30);
        } else {
            $html_msg['MANAGE_ORDERS'] = '';
        }
        /* 第一部分结束 */

        /* 第二部分 */
        //$html_msg['DIVIDED_ORDER'] = $divided_order;
        //$date_time = date('m-d-Y H:i:s A',strtotime(trim($this->info['date_purchased'])));
        //$date = date('F j, Y H:i:s',strtotime($this->info['date_purchased']));
        if ($order_num > 1) {
            $html = $this->email_text_spacing(30, 'border-top: 1px solid #f7f7f7;');
        } else {
            $html = '';
        }

        $html .= $divided_order;
        $order_fraction = '';
        $order_number_html = '';
        $orderNumerHtml = '';
        $orderKey = 0;
        //是否为德国仓发货
        $isReissueDe = false;
        if ($zf_insert_id) {
            foreach ($son_order as $key => $id) {
                $orderKey++;
                $fields = array('orders_number', 'currency', 'currency_value', 'shipping_method', 'is_reissue');
                $order_data = fs_get_data_from_db_fields_array($fields, 'orders', 'orders_id=' . $id, 'limit 1');

                //判断发货仓是否德国
                if (in_array($order_data[0][4], [6 ,8 ,20])) {
                    $isReissueDe = true;
                }

                $series_time = self::get_email_series_time($this->info['date_purchased'], $id, $this->delivery['postcode']);

                $order_fraction = $orderKey . '/' . $order_num;
                $order_num_href = zen_href_link('account_history_info', 'orders_id=' . $id, 'SSL');
                if (!$is_customer) $order_num_href = 'javascript:;';
                $order_number_html = '#' . $order_data[0][0];
                $orderNumerHtml .= '#' . $order_data[0][0] . ' & ';
                if ($order_num > 1) {
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                ' . FS_ORDER_EMAIL_14 . ' ' . $order_fraction . ' <a style="color: #0070BC;text-decoration: none" href="' . $order_num_href . '">' . FS_ORDER_EMAIL_10 . $order_number_html . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
                    if ($customers_po_num) {
                        $html .= $this->email_text_spacing(10);
                        $html .=
                            '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                    ' . FS_SEND_EMAIL_71 . '<a style="text-decoration: none;color: #232323" href="javascript:;">' . $customers_po_num . '</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                    }
                    $html .= $this->email_text_spacing(30);
                }

                $products = zen_get_products_by_order_id($id, $order_data[0][1]);
                $products_count = count($products);
                foreach ($products as $kk => $product) {
                    $product_border = '';
                    if ($kk == $products_count - 1) $product_border = 'border-bottom: 1px solid #f7f7f7;';
                    //获取订单产品图片和标题HTML
                    $productHtml = $this->create_product_html($product, $order_data[0][4]);
                    $image_html = $productHtml['image_html'];
                    $title_html = $productHtml['title_html'];
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;border-top: 1px solid #f7f7f7;' . $product_border . '">';

                    $html .=
                        '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>
                        
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td width="60" valign="middle" style="border-collapse: collapse;">
                            ' . $image_html . '
                        </td>
                        <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #232323;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                            ' . $title_html . '
                            <br>
                            ' . FS_SEND_EMAIL_8 . $product['qty'] . '
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>';

                    $html .= '</td></tr></tbody></table>';
                }
                if ($orderKey == $order_num) {
                    $html .= $this->email_text_spacing(20);
                } else {
                    $html .= $this->email_text_spacing(30);
                }
            }
        }
        $html_msg['PRODUCTS_INFO'] = $html;
        /* 第二部分结束 */

        /* 第三部分 */
        if ($purchase == 'alfa') {
            $alfa_info_array = ['alfa_contact_person', 'alfa_phone', 'alfa_email', 'alfa_organization', 'alfa_inn', 'alfa_kpp', 'alfa_okpo', 'alfa_bic', 'alfa_legal_address', 'alfa_postal_address', 'alfa_correspondent_accout', 'alfa_bank_name', 'alfa_settlement_account', 'alfa_holder_name', 'card_path'];
            $alfa_info = fs_get_data_from_db_fields_array($alfa_info_array, 'orders_alfa_account', 'orders_id =' . (int)$zf_insert_id, '');
            $alfa_info = $alfa_info[0];
            if($alfa_info[14]){
                $html_msg['PAYMENT_INFO'] =
                '<table width="640" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;font-weight: 600;font-family: Open Sans,arial,sans-serif;line-height: 24px" align="center">
                          ' . FS_ORDER_EMAIL_67 . '
                      </td>
                  </tr>
                  </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td  bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td width="100%" colspan="2" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;">
                                        <span style="color: #818181;display: inline-block;margin-bottom: 3px">
                                        ' . FS_ORDER_EMAIL_ALFA_01 . '
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
        
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7" height="30">
        
                                </td>
                            </tr>
                            </tbody>
                        </table>
        
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">
        
                                </td>
                            </tr>
                            </tbody>
                        </table>';
            }else{
                $html_msg['PAYMENT_INFO'] =
                '<table width="640" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;font-weight: 600;font-family: Open Sans,arial,sans-serif;line-height: 24px" align="center">
                          ' . FS_ORDER_EMAIL_67 . '
                      </td>
                  </tr>
                  </tbody>
              </table>

              <table width="640" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">

                      </td>
                  </tr>
                  </tbody>
              </table>

              <table width="640" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td  bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                                <td width="100%" colspan="2" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;">
                                    <span style="color: #818181;display: inline-block;margin-bottom: 3px">
                                    ' . FS_ORDER_EMAIL_52 . '
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_56 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[3] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_57 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[4] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_58 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[5] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_60 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[7] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_61 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[8] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_64 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[11] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_55 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                    ' . $alfa_info[2] . '
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . FS_ORDER_EMAIL_54 . '
                                </td>
                                <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;color: #232323;">
                                ' . $alfa_info[1] . '
                                </td>
                            </tr>
                        </tbody>
                      </table>
                      </td>
                  </tr>
                  </tbody>
              </table>

              <table width="640" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7" height="30">

                      </td>
                  </tr>
                  </tbody>
              </table>

              <table width="640" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">

                      </td>
                  </tr>
                  </tbody>
              </table>';
            }
        } else {
            $html_msg['PAYMENT_INFO'] = '';
        }
        if ($this->billing['street_address']) {
            $billing_info = ucwords($this->billing['name'] . ' ' . $this->billing['lastname'])
                . '<br>' .
                $this->billing['street_address'] . ' ' . $this->billing['suburb']
                . '<br>' .
                $this->billing['city'] . ', ' . $this->billing['postcode']
                . '<br>' .
                $this->billing['country']
                . '<br>' .
                $this->customer['email_address']
                . '<br>' .
                $this->billing['tel_prefix'] . '-' . $this->billing['telephone'];
        } else {
            $billing_info = 'Not set yet';
        }

        $shipping_info = ucwords($this->delivery['name'] . ' ' . $this->delivery['lastname'])
            . '<br>' .
            (($this->delivery['company']) ? $this->delivery['company'] . '<br />' : '')
            . $this->delivery['street_address'] . ' ' . $this->delivery['suburb']
            . '<br>' .
            $this->delivery['city'] . ', ' . $this->delivery['postcode']
            . '<br>' .
            $this->delivery['country'];

        $customer_info = ucwords($this->customer['name'] . ' ' . $this->customer['lastname'])
            . '<br>' .
            $this->customer['email_address']
            . '<br>' .
            ($this->customer['telephone'] ? $this->customer['telephone'] : $this->billing['tel_prefix'] . '-' . $this->billing['telephone']);

        $html_msg['SHIPPING_INFO'] = $shipping_info;
        $html_msg['BILLING_INFO'] = $billing_info;
        $html_msg['CUSTOMER_INFO'] = $customer_info;

        //自提显示仓库信息
        if ($is_local_pickup) {
            $warehouse = fs_get_data_from_db_fields('warehouse', 'orders', 'orders_id=' . $zf_insert_id, 'limit 1');
            $html_msg['SHIPPING_INFO'] = zen_get_orders_warehouse_address($warehouse);
            $customer_pickself_info = fs_get_data_from_db_fields_array(['photo_name', 'email_address', 'phone'], 'order_pickbyself_info', 'order_id=' . $zf_insert_id, 'limit 1');
            $html_msg['CUSTOMER_INFO'] = ucfirst($customer_pickself_info[0][0])
                . '<br>' .
                $customer_pickself_info[0][1]
                . '<br>' .
                $customer_pickself_info[0][2];
        }

        //支付方式
        $html_msg['MAKE_PAYMENT'] = '';
        if (strtolower($this->info['payment_module_code']) == 'purchase') {
            //PO订单邮件中支付方式展示具体账期类型
            $purchaseInfo = getPurchaseInfo();
            if ($purchaseInfo["customer_pay_day"]) {
                $paymentHtml = $purchaseInfo["customer_pay_day"];
            } else {
                $paymentHtml = FS_CHECKOUT_NEW34;
            }
            $html_msg['MAKE_PAYMENT'] = $this->ccAndPpEmailPaymentButton(count($son_order));
        } else {
            $paymentHtml = FS_CHECKOUT_NEW33;
            if ($purchase == 'echeck') {
                $paymentHtml = FS_SUCCESS_ECHECK;
            } elseif ($purchase == 'alfa') {
                $paymentHtml = FS_CHECKOUT_NEW_CASHLESS;
            }
        }
        $html_msg['PAYMENT_METHOD'] = $paymentHtml;

        $cost_data = zen_get_order_cost_by_order($zf_insert_id, true);
        //小计
        $html_msg['SUBTOTAL'] = $cost_data['ot_subtotal']['text'];
        //总计
        $html_msg['TOTAL'] = $cost_data['ot_total']['text'];
        //运费
        $shipping_charge = $this->info['shipping_text'];

        $is_au_gsp = $this->info['delivery_country_id'] == 13 ? true : false;
        //如果收货地址为澳大利亚  展示税后价
        if($is_au_gsp){
            $tax_data = zen_get_order_au_tax_order($order_id);
            if($tax_data){
                $html_msg['SUBTOTAL'] = $tax_data['tax_subtotal']['text'];
                $html_msg['TOTAL'] = $tax_data['tax_total']['text'];
                $shipping_charge = $tax_data['tax_shipping']['text'];
            }
        }

        $html_msg['SHIPPING_CHARGE'] = $shipping_charge;
        //税（判断是否显示）
        $vat_html = '';
        if ($cost_data['ot_tax']) {
            if (strtolower($this->delivery["country"]) == "australia") {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    '.FS_BLANKET_33.':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } elseif (strtolower($this->delivery["country"]) == 'monaco') {     // 2019-7-11 potato 添加摩纳哥的税率
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST_FR . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } else {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            }
        }
        $html_msg['VAT_TEXT'] = $vat_html;
        /* 第三部分结束 */

        if ($is_customer) {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_18 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_20;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_21 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_22;
            if ($_SESSION['languages_code'] == 'de') {
                $html_msg['EMAIL_TEXT_03'] = 'Sie können in ' . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . ' to die Artikel ändern oder die Bestellung stornieren.';
            }
        } else {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_23;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_24;
        }

        //邮件隐藏标题
        $display_none_title = FS_ORDER_EMAIL_25;
        if ($this->info['payment_module_code'] == 'purchase') {
            if ($_SESSION['languages_code'] == 'jp') {
                $Order_title_ne = 'POを添付';
            } else {
                $Order_title_ne = FS_CHECKOUT_PAYMENT_PO;
            }
        } else {
            $Order_title_ne = FS_ORDER_EMAIL_26;
        }

        $html = common_email_header_and_footer($Order_title_ne, $display_none_title, $email_warehouse_info, $isReissueDe);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];

        $customer_name = ucwords($this->customer['name'] . ($this->customer['lastname'] ? ' ' . $this->customer['lastname'] : ''));
        $html_msg['CUSTOMER_NAME'] = $customer_name;
        $html_msg['COMMON_DEAR'] = FS_ORDER_EMAIL_28;
        $html_msg['EMAIL_TEXT_01'] = $first_sentence;
        $html_msg['FS_ORDER_EMAIL_29'] = FS_ORDER_EMAIL_29;
        if ($is_local_pickup) {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_44;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_45;
        } else {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_30;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_31;
        }
        $html_msg['FS_ORDER_EMAIL_32'] = FS_ORDER_EMAIL_32;
        $html_msg['FS_ORDER_EMAIL_33'] = FS_ORDER_EMAIL_33;
        $html_msg['FS_ORDER_EMAIL_34'] = FS_ORDER_EMAIL_34;
        $html_msg['FS_ORDER_EMAIL_35'] = FS_ORDER_EMAIL_35;
        $html_msg['FS_ORDER_EMAIL_36'] = FS_ORDER_EMAIL_36;
        $html_msg['FS_ORDER_EMAIL_37'] = FS_ORDER_EMAIL_37;
        $html_msg['FS_ORDER_EMAIL_38'] = FS_ORDER_EMAIL_38;
        $html_msg['FS_ORDER_EMAIL_39'] = FS_ORDER_EMAIL_39;
        $html_msg['FS_ORDER_EMAIL_40'] = FS_ORDER_EMAIL_40;
        $html_msg['FS_ORDER_EMAIL_41'] = FS_ORDER_EMAIL_41;
        $html_msg['FS_EMAIL_COMMA'] = FS_EMAIL_COMMA;

        if($is_au_gsp){
            $html_msg['FS_ORDER_EMAIL_38'] = FS_BLANKET_34;
        }
        $orderNumerHtml = trim($orderNumerHtml);
        $orderNumerHtml = trim($orderNumerHtml, '&');
        $orderNumerHtml = trim($orderNumerHtml);
        if ($purchase_order_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$purchase_order_num.')';
        } elseif ($customers_po_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$customers_po_num.')';
        }
        $email_title = sprintf(FS_ORDER_EMAIL_43, $orderNumerHtml);
        if ($_SESSION['languages_code'] == 'de') {
            $email_title = sprintf(FS_ORDER_EMAIL_43, $orderNumerHtml) . ' erhalten';
        }

        sendwebmail($customer_name, $this->customer['email_address'], '订单邮件发送给客户' . $this->customer['email_address'] . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $zf_insert_id);

        if ($_SESSION['customer_id']) {
            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
        }
        if (!$admin_id) {
            //根据订单分配对应销售获取admin_id
            $admin_id = zen_get_customer_order_has_admin_id($zf_insert_id);
        }

        if ($admin_id) {
            $admin_data = fs_get_data_from_db_fields_array(['admin_name', 'admin_email'], 'admin', 'admin_id=' . $admin_id, 'limit 1');
            $admin_name = $admin_data[0][0];
            $admin_email = $admin_data[0][1];
            sendwebmail($admin_name, $admin_email, '订单邮件发送给销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $zf_insert_id);
        }
        if ($purchase == 'alfa' && $_SERVER['HTTP_HOST'] == "www.fs.com") {
            //线上俄罗斯对公支付需要给俄语客服发送邮件
            $service_email = 'ru@fs.com';
            sendwebmail($service_email, $service_email, '订单邮件发送给俄语客服' . $service_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $zf_insert_id);
        }
        //如果是de-en 发送密送邮件到trustpilot
        if ($_SESSION['languages_code'] == 'dn' && $this->is_send_trustpilot) {
            $bcc_email = 'fs.com+468638a060@invite.trustpilot.com';
            if ($cost_data['ot_total']['value'] > 540) {
                sendwebmail('Angelina.Li', $bcc_email, '客户下单Trustpilot邮件' . $bcc_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $zf_insert_id);
                sendwebmail('Angelina.Li', 'Angelina.Li@feisu.com', '客户下单Trustpilot邮件Angelina.Li@feisu.com' . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $zf_insert_id);
            }
        }
    }

    function send_fs_order_email($order_id, $complete_mail = false)
    {
        global $currencies, $order_totals, $db;
        //低库存邮件
        if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL == '1') {
            // send an email
            $email_html = zen_get_corresponding_languages_email_common();
            $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
            $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];

            $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;
            $html_msg['EMAIL_MESSAGE_HTML'] = nl2br($email_low_stock);

            zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, $html_msg, 'low_stock_to_us');
        }

        $email_warehouse_info = get_email_langpac();

        //自提标识 $is_local_pickup
        $shipping_method = zen_get_order_shipping_method_by_code($this->info['shipping_method'], $order_id);
        $is_local_pickup = false;
        if ($shipping_method == 'Local Pickup') {
            $is_local_pickup = true;
        }
        //$is_local_pickup = true;
        //PO订单标识 $purchase_order_num
        $orderResult = $db->getAll("select purchase_order_num,customers_po,payment_module_code,customers_id,orders_number from orders where orders_id = " . $order_id . " limit 1");

        $this->info['orders_number'] = $orderResult[0]['orders_number'];
        $purchase_order_num = $orderResult[0]['purchase_order_num'];

        //Add Order Comments标识
        $customers_po_num = $orderResult[0]['customers_po'];
        $purchase = trim($orderResult[0]['payment_module_code']);

        //游客标识 $is_customer
        $is_customer = $orderResult[0]['customers_id'];

        /* 第一部分 */
        $son_order = array();
        if ($order_id) $son_order = zen_get_all_son_order_id($order_id);
        if (!count($son_order)) {
            $son_order[] = $order_id;
        }
        $html_number = "";
        foreach ($son_order as $key => $value) {
            if ($key == 0) {
                $html_number .= '<a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $value, 'SSL') . '">#' . zen_get_orders_number_by_id($value) . '</a>';
            } else {
                $html_number .= ' & <a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $value, 'SSL') . '">#' . zen_get_orders_number_by_id($value) . '</a>';
                if (!$this->isCCAndPPPayment()) {
                    $de_msg = "";
                    if ($_SESSION['languages_code'] == 'de') {
                        $de_msg = FS_ORDER_EMAIL_09_3;
                    }
                    if ($_SESSION['languages_code'] == 'jp') {
                        $html_number .= '<br>';
                    } else {
                        $html_number .= $de_msg . FS_EMAIL_POINT . '<br>';
                    }
                }
            }
        }

        $purchase_order_num_html = '';
        if ($customers_po_num) {
            $purchase_order_num_html = ' (' . FS_SEND_EMAIL_71 . '<a href="javascript:;" style="color: #232323;text-decoration: none">' . $customers_po_num . '</a>)';
        }

        $order_num = count($son_order);
        $order_number = '';
        $divided_order = '';
        $two_sentence = '';
        $html_msg['MANAGE_ORDERS'] = '';
        if ($order_num === 1) {
            $order_number = $orderResult[0]['orders_number'];
            if (!$complete_mail) {
                $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_02;
                if ($this->info['payment_module_code'] == 'purchase') {
                    $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_46;
                }
                if (!$is_customer) {
                    $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_02;
                    if ($this->info['payment_module_code'] == 'purchase') {
                        $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_46;
                    }
                }
            } else {
                $first_sentence = FS_ORDER_EMAIL_03 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_04;
                if (!$is_customer) {
                    $first_sentence = FS_ORDER_EMAIL_03 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_04;
                }
                if ($is_local_pickup) {
                    $first_sentence = FS_ORDER_EMAIL_05 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a> ' . $purchase_order_num_html . FS_ORDER_EMAIL_06;
                    if (!$is_customer) {
                        $first_sentence = FS_ORDER_EMAIL_05 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a> ' . $purchase_order_num_html . FS_ORDER_EMAIL_06;
                    }
                }
                $two_sentence = '<tr>
                    <td bgcolor="#fff" style="border-collapse: collapse" height="10">
                    </td>
                    </tr>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDER_EMAIL_69 . '<a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('manage_orders') . '">' . FS_ORDER_EMAIL_70 . '</a>' . FS_ORDER_EMAIL_71 . '
                        </td>
                    </tr>';
            }
        } else {
            if (!$complete_mail) {
                $first_sentence = FS_ORDER_EMAIL_07;
                if ($this->info['payment_module_code'] == 'purchase') {
                    $first_sentence = FS_ORDER_EMAIL_01 . FS_ORDER_EMAIL_46;
                }
            } else {
                if ($is_local_pickup) {
                    $first_sentence = FS_ORDER_EMAIL_08;
                } else {
                    if ($son_order) {
//                        $html_number="";
//                        foreach ($son_order as $key=>$value){
//                            if($key==0){
//                                $html_number .='<a style="color: #0681d3;text-decoration: none" href="'.zen_href_link('account_history_info','orders_id='.$value,'SSL').'">#'.zen_get_orders_number_by_id($value).'</a>';
//                            }else{
//                                $de_msg="";
//                                if($_SESSION['languages_code']=='de'){
//                                    $de_msg =FS_ORDER_EMAIL_09_3;
//                                }
//                                if($_SESSION['languages_code']=='jp'){
//                                    $html_number .=' & <a style="color: #0681d3;text-decoration: none" href="'.zen_href_link('account_history_info','orders_id='.$value,'SSL').'">#'.zen_get_orders_number_by_id($value).'</a><br>';
//                                }else{
//                                    $html_number .=' & <a style="color: #0681d3;text-decoration: none" href="'.zen_href_link('account_history_info','orders_id='.$value,'SSL').'">#'.zen_get_orders_number_by_id($value).'</a>'.$de_msg.FS_EMAIL_POINT.'<br>';
//                                }
//                            }
//                        }
                        $first_sentence = FS_ORDER_EMAIL_09_1 . $html_number . FS_ORDER_EMAIL_09_2;
                    } else {
                        $first_sentence = FS_ORDER_EMAIL_09;
                    }
                }

                $two_sentence = '<tr>
                    <td bgcolor="#fff" style="border-collapse: collapse" height="10">
                    </td>
                    </tr>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDER_EMAIL_69 . '<a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('manage_orders') . '">' . FS_ORDER_EMAIL_70 . '</a>' . FS_ORDER_EMAIL_71 . '
                        </td>
                    </tr>';
            }
            $divided_order = '';

        }


        /* 第一部分结束 */

        /* 第二部分 */
        if (!$complete_mail && $order_num > 1) {
            $html = $this->email_text_spacing(30, 'border-top: 1px solid #f7f7f7;');
        } else {
            $html = '';
        }

        $html .= $divided_order;
        $order_fraction = '';
        $order_number_html = '';
        $purchase_order_num_muti = '';
        $orderNumerHtml = '';
        $orderKey = 0;
        //是否为德国仓发货
        $isReissueDe = false;
        if ($order_id) {
            foreach ($son_order as $key => $id) {
                $orderKey++;
                $fields = array('orders_number', 'currency', 'currency_value', 'shipping_method', 'is_reissue');
                $order_data = fs_get_data_from_db_fields_array($fields, 'orders', 'orders_id=' . $id, 'limit 1');
                $series_time = self::get_email_series_time($this->info['date_purchased'], $id, $this->delivery['postcode']);

                //判断发货仓是否德国
                if (in_array($order_data[0][4], [6 ,8 ,20])) {
                    $isReissueDe = true;
                }

                $order_fraction = $orderKey . '/' . $order_num;
                $order_num_href = zen_href_link('account_history_info', 'orders_id=' . $id, 'SSL');
                if (!$is_customer) $order_num_href = 'javascript:;';
                $order_number_html = '#' . $order_data[0][0];
                $orderNumerHtml .= '#' . $order_data[0][0] . ' & ';

                if ($order_num > 1) {
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                ' . FS_ORDER_EMAIL_14 . ' ' . $order_fraction . ' <a style="color: #0070BC;text-decoration: none" href="' . $order_num_href . '">' . FS_ORDER_EMAIL_10 . $order_number_html . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
                    if ($customers_po_num) {
                        $html .= $this->email_text_spacing(10);
                        $html .=
                            '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                    ' . FS_SEND_EMAIL_71 . '<a style="text-decoration: none;color: #232323" href="javascript:;">' . $customers_po_num . '</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                    }
                    if ($complete_mail) {
                        $html .= $this->email_text_spacing(30);
                    }
                }
                //cc和pp支付方式不再这里展示流程轴
                if ($complete_mail && !$this->isCCAndPPPayment()) {
                    if (in_array($order_data[0][4], array(1, 4, 6, 9, 12, 22, 23, 24))) {
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="35%" style="border-collapse: collapse;font-size: 14px;color: #333;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="right">
                                            ' . FS_ORDER_EMAIL_72 . '
                                            </td>
                                                <td width="30%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                            ' . FS_ORDER_EMAIL_74 . '
                                            </td>
                                                <td width="35%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;text-indent: 20px">
                                            ' . FS_ORDER_EMAIL_75 . '
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                        $html .= $this->email_text_spacing(15);
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                            <img style="display: inline-block;max-width: 100%" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/progress-line-three01.png" alt="">
                        </td>
                    </tr>
                    </tbody>
                </table>';
                        $html .= $this->email_text_spacing(30);
                    } else {
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #333;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                   ' . FS_ORDER_EMAIL_72 . '
                                                </td>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                    ' . FS_ORDER_EMAIL_73 . '
                                                </td>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                    ' . FS_ORDER_EMAIL_74 . '
                                                </td>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                    ' . FS_ORDER_EMAIL_75 . '
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                        $html .= $this->email_text_spacing(15);
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                            <img style="display: inline-block;max-width: 100%" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/progress-line-four01.png" alt="">
                        </td>
                    </tr>
                    </tbody>
                </table>';
                        $html .= $this->email_text_spacing(30);
                    }
                }
                $products = zen_get_products_by_order_id($id, $order_data[0][1]);
                $products_count = count($products);
                foreach ($products as $kk => $product) {
                    if ($kk == $products_count - 1) $product_border = 'border-bottom: 1px solid #f7f7f7;';
                    $border_top = 'border-top: 1px solid #f7f7f7;';
                    if (!$complete_mail && $order_num > 1) {
                        $border_top = '';
                    }
                    //获取订单产品图片和标题HTML
                    $productHtml = $this->create_product_html($product, $order_data[0][4]);
                    $image_html = $productHtml['image_html'];
                    $title_html = $productHtml['title_html'];
                    $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                              <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;' . $border_top . $product_border . '">';
                    $html .=
                        '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>
                        
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td width="60" valign="middle" style="border-collapse: collapse;">
                            ' . $image_html . '
                        </td>
                        <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #232323;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                            ' . $title_html . '
                            <br>
                            ' . FS_SEND_EMAIL_8 . $product['qty'] . '
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>';

                    $html .= '</td></tr></tbody></table>';
                }
                if ($orderKey == $order_num) {
                    $html .= $this->email_text_spacing(20);
                } else {
                    $html .= $this->email_text_spacing(30);
                }
            }
        }
        $html_msg['PRODUCTS_INFO'] = $html;
        /* 第二部分结束 */

        /* 第三部分 */
        if ($this->billing['street_address']) {
            $billing_info = ucwords($this->billing['name'] . ' ' . $this->billing['lastname'])
                . '<br>' .
                $this->billing['street_address'] . ' ' . $this->billing['suburb']
                . '<br>' .
                $this->billing['city'] . ', ' . $this->billing['postcode']
                . '<br>' .
                $this->billing['country']
                . '<br>' .
                $this->customer['email_address']
                . '<br>' .
                $this->billing['tel_prefix'] . '-' . $this->billing['telephone'];
        } else {
            $billing_info = 'Not set yet';
        }

        $shipping_info = ucwords($this->delivery['name'] . ' ' . $this->delivery['lastname'])
            . '<br>' .
            (($this->delivery['company']) ? $this->delivery['company'] . '<br />' : '')
            . $this->delivery['street_address'] . ' ' . $this->delivery['suburb']
            . '<br>' .
            $this->delivery['city'] . ', ' . $this->delivery['postcode']
            . '<br>' .
            $this->delivery['country'];

        $customer_info = ucwords($this->customer['name'] . ' ' . $this->customer['lastname'])
            . '<br>' .
            $this->customer['email_address']
            . '<br>' .
            ($this->customer['telephone'] ? $this->customer['telephone'] : $this->billing['tel_prefix'] . '-' . $this->billing['telephone']);

        $html_msg['SHIPPING_INFO'] = $shipping_info;
        $html_msg['BILLING_INFO'] = $billing_info;
        $html_msg['CUSTOMER_INFO'] = $customer_info;

        //自提显示仓库信息
        if ($is_local_pickup) {
            $warehouse = fs_get_data_from_db_fields('warehouse', 'orders', 'orders_id=' . $order_id, 'limit 1');
            $html_msg['SHIPPING_INFO'] = zen_get_orders_warehouse_address($warehouse);
            $customer_pickself_info = fs_get_data_from_db_fields_array(['photo_name', 'email_address', 'phone'], 'order_pickbyself_info', 'order_id=' . $order_id, 'limit 1');
            $html_msg['CUSTOMER_INFO'] = ucfirst($customer_pickself_info[0][0])
                . '<br>' .
                $customer_pickself_info[0][1]
                . '<br>' .
                $customer_pickself_info[0][2];
        }
        //add by ternence paypal默认邮件模板
        if (!$complete_mail) {
            $email_template = "checkout_paypal_or_credit_card";
        } else {
            $email_template = "checkout_payment_sucess";
        }
        //支付方式
        $html_msg['PAYMENT_METHOD'] = EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_PAYPAL;
        $html_msg['MAKE_PAYMENT'] = '';
        switch (1) {

            case preg_match('/paypal/i', $this->info['payment_method']):

                if (!$complete_mail) {
                    $html_msg['MAKE_PAYMENT'] = $this->ccAndPpEmailPaymentButton();
                    $html_msg['INSTRUCTION'] = '
  				<p>Dear ' . $name . ',</p>
            <p>' . FS_WAREHOUSE_AREA_17 . '</p>
  				';
                    $html_msg['DESCRIPTION'] = 'Order Received, Awaiting Processing';
                    $html_msg['EMAIL_TOP_TITLE'] = FS_EMAIL_OPTIMIZE_07;
                    $email_template = "checkout_paypal_or_credit_card_new";
                } else {

                    $html_msg['INSTRUCTION'] = '
	  					<p>Dear ' . $name . ',</p>
	            <p>' . FS_WAREHOUSE_AREA_18 . $this->info['orders_number'] . FS_WAREHOUSE_AREA_19 . $date . FS_WAREHOUSE_AREA_20 . '<br />
				' . FS_WAREHOUSE_AREA_21 . '<a style=" color:#363636;" href="mailto:service.us@fs.comlegal@fs.com">service.us@fs.comlegal@fs.com</a>. </p>
	  					';
                    $html_msg['DESCRIPTION'] = 'Order received, pending';
                    $html_msg['NEW_TOP'] = $this->ccAndPpPayedNewTop($html_number, count($son_order));
                    $email_template = "checkout_payment_sucess_cc_pp";
                }
                break;

            case preg_match('/purchase/i', $this->info['payment_module_code']):
                $email_template = "checkout_payment_sucess";
                $html_msg['PAYMENT_METHOD'] = FS_CHECKOUT_NEW34;
                if ($complete_mail) {
                    $email_template = "checkout_payment_sucess_cc_pp";
                    $html_msg['NEW_TOP'] = $this->ccAndPpPayedNewTop($html_number, count($son_order));
                } else {
                    $html_msg['EMAIL_TOP_TITLE'] = FS_EMAIL_OPTIMIZE_07;
                    $html_msg['MAKE_PAYMENT'] = $this->ccAndPpEmailPaymentButton();
                    $email_template = "checkout_paypal_or_credit_card_new";
                }
                break;
        }

        $cost_data = zen_get_order_cost_by_order($order_id, true);
        //小计
        $html_msg['SUBTOTAL'] = $cost_data['ot_subtotal']['text'];
        //总计
        $html_msg['TOTAL'] = $cost_data['ot_total']['text'];
        //运费
        $shipping_charge = $this->info['shipping_text'];

        $is_au_gsp = $this->info['delivery_country_id'] == 13 ? true : false;
        //如果收货地址为澳大利亚  展示税后价
        if($is_au_gsp){
            $tax_data = zen_get_order_au_tax_order($order_id);
            if($tax_data){
                $html_msg['SUBTOTAL'] = $tax_data['tax_subtotal']['text'];
                $html_msg['TOTAL'] = $tax_data['tax_total']['text'];
                $shipping_charge = $tax_data['tax_shipping']['text'];
            }
        }

        $html_msg['SHIPPING_CHARGE'] = $shipping_charge;
        //税（判断是否显示）
        $vat_html = '';
        if ($cost_data['ot_tax']) {
            if ($is_au_gsp) {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    '.FS_BLANKET_33.':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } elseif (strtolower($this->delivery["country"]) == 'monaco') {     // 2019-7-11 potato 添加摩纳哥的税率
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST_FR . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } elseif (strtolower($this->delivery["country"]) == 'united states') {
                $vaxTitle = $complete_mail ? FS_VAX_TITLE_US_TAX : FS_VAX_TITLE_US;
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . $vaxTitle . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } else {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            }
        }
        $html_msg['VAT_TEXT'] = $vat_html;
        /* 第三部分结束 */

        if ($is_customer) {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_18 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_20;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_21 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_22;
        } else {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_23;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_24;
        }


        //邮件预设
        if (!$complete_mail) {
            $fs_title = FS_ORDER_EMAIL_26;
            $display_none_title = FS_ORDER_EMAIL_25;
            if ($this->info['payment_module_code'] == 'paypal') {
                $fs_title = FS_EMAIL_OPTIMIZE_01;
            } elseif ($this->info['payment_module_code'] == 'purchase') {
                if ($_SESSION['languages_code'] == 'jp') {
                    $fs_title = 'POを添付';
                } else {
                    $fs_title = FS_CHECKOUT_PAYMENT_PO;
                }
            }
        } else {
            if ($this->isCCAndPPPayment()) {
                $fs_title = FS_EMAIL_OPTIMIZE_05;
            } else {
                $fs_title = FS_ORDER_EMAIL_27;
            }
            $display_none_title = FS_ORDER_EMAIL_42;
        }
        $html = common_email_header_and_footer($fs_title, $display_none_title, $email_warehouse_info, $isReissueDe);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $customer_name = ucwords($this->customer['name'] . ($this->customer['lastname'] ? ' ' . $this->customer['lastname'] : ''));
        $html_msg['CUSTOMER_NAME'] = $customer_name;
        $html_msg['COMMON_DEAR'] = FS_ORDER_EMAIL_28;
        $html_msg['EMAIL_TEXT_01'] = $first_sentence;
        $html_msg['EMAIL_TEXT_48'] = $two_sentence;
        $html_msg['FS_ORDER_EMAIL_29'] = FS_ORDER_EMAIL_29;
        if ($is_local_pickup) {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_44;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_45;
        } else {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_30;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_31;
        }
        $html_msg['FS_ORDER_EMAIL_32'] = FS_ORDER_EMAIL_32;
        $html_msg['FS_ORDER_EMAIL_33'] = FS_ORDER_EMAIL_33;
        $html_msg['FS_ORDER_EMAIL_34'] = FS_ORDER_EMAIL_34;
        $html_msg['FS_ORDER_EMAIL_35'] = FS_ORDER_EMAIL_35;
        $html_msg['FS_ORDER_EMAIL_36'] = FS_ORDER_EMAIL_36;
        $html_msg['FS_ORDER_EMAIL_37'] = FS_ORDER_EMAIL_37;
        $html_msg['FS_ORDER_EMAIL_38'] = FS_ORDER_EMAIL_38;
        $html_msg['FS_ORDER_EMAIL_39'] = FS_ORDER_EMAIL_39;
        $html_msg['FS_ORDER_EMAIL_40'] = FS_ORDER_EMAIL_40;
        $html_msg['FS_ORDER_EMAIL_41'] = FS_ORDER_EMAIL_41;
        $html_msg['FS_EMAIL_COMMA'] = FS_EMAIL_COMMA;

        if($is_au_gsp){
            $html_msg['FS_ORDER_EMAIL_38'] = FS_BLANKET_34;
        }
        $orderNumerHtml = trim($orderNumerHtml);
        $orderNumerHtml = trim($orderNumerHtml, '&');
        $orderNumerHtml = trim($orderNumerHtml);
        if ($purchase_order_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$purchase_order_num.')';
        } elseif ($customers_po_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$customers_po_num.')';
        }
        $email_title = sprintf(FS_ORDER_EMAIL_43, $orderNumerHtml);
        if ($complete_mail) {
            $email_title = sprintf(FS_ORDER_EMAIL_47, $orderNumerHtml);
            if ($this->info['payment_module_code'] == 'purchase' && $_SESSION['languages_code'] == 'jp') {
                $email_title = sprintf('ご注文%sありがとうございます。', $orderNumerHtml);
            }
        }
        $oid = 0;
        if (!$complete_mail) {
            $oid = $order_id;
        }
        sendwebmail($customer_name, $this->customer['email_address'], '游客订单邮件发送给客户' . $this->customer['email_address'] . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);

        // $cost_value = zen_get_order_value_by_order($order_id);
        // //判断是否需要密送trustpilot
        // if($this->is_bcc_to_trustpilot($order_id,$cost_value,$complete_mail)){
        //     $bcc_email = ['468638a060@invite.trustpilot.com','fs.angelinali@gmail.com'];
        //     zen_mail($customer_name, $this->customer['email_address'], $email_title, '', STORE_NAME, EMAIL_FROM, $html_msg, $email_template, $this->attachArray,$bcc_email);
        // }else{
        //     sendwebmail($customer_name, $this->customer['email_address'],'游客订单邮件发送给客户'.$this->customer['email_address'].date('Y-m-d H:i:s', time()),STORE_NAME,$email_title, $html_msg, $email_template,81,$this->attachArray);
        // }

        if ($_SESSION['customer_id']) {
            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
        } else {
            //游客下单不注册给销售发送订单提醒邮件
            $admin_id = zen_get_customer_order_has_admin_id($order_id);
        }

        if ($admin_id) {
            define('EMAIL_SUBJECT', 'FS.COM Order# ' . $this->info['orders_number']);
            $admin_data = fs_get_data_from_db_fields_array(['admin_name', 'admin_email'], 'admin', 'admin_id=' . $admin_id, 'limit 1');
            $admin_name = $admin_data[0][0];
            $admin_email = $admin_data[0][1];
            sendwebmail($admin_name, $admin_email, '游客订单邮件发送给销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
        }

        //SG、AU自提付款成功邮件发送到客户区域邮箱 sg@fs.com au@fs.com
        if ($complete_mail && $is_local_pickup) {
            $regional_sales = '';
            if (in_array(strtolower($this->delivery["country"]), ['australia', 'singapore'])) {
                if (strtolower($this->delivery["country"]) == 'australia') {
                    $regional_sales = 'au@fs.com';
                } else {
                    $regional_sales = 'sg@fs.com';
                }
            }
            if (!empty($regional_sales)) {
                sendwebmail($regional_sales, $regional_sales, '发送给区域销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
            }
        }
        //如果是de-en 发送密送邮件到trustpilot
        if ($_SESSION['languages_code'] == 'dn' && $this->is_send_trustpilot) {
            $bcc_email = 'fs.com+468638a060@invite.trustpilot.com';
            if ($cost_data['ot_total']['value'] > 540) {
                sendwebmail('Angelina.Li', $bcc_email, '客户下单Trustpilot邮件' . $bcc_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
                sendwebmail('Angelina.Li', 'Angelina.Li@feisu.com', '客户下单Trustpilot邮件Angelina.Li@feisu.com' . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
            }
        }
    }


    function send_fs_credit_card_order_email($order_id, $complete_mail = true)
    {
        global $currencies, $order_totals, $db;
        //如果new order没有拿到构造方法的信息，则再查一遍信息
        if (empty($this->info['shipping_method'])) {
            $shipping_method_query_data = "select title, text, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_shipping'";
            $shipping_method_data = $db->Execute($shipping_method_query_data);

            $customer_infomation = $db->getAll('select * from orders where orders_id =' . (int)$order_id . ' limit 1');
            $customer_infomation = $customer_infomation[0];

            $this->info['shipping_text'] = $shipping_method_data->fields['text'];
            $this->info['shipping_method'] = $customer_infomation['shipping_method'];
            $this->info['date_purchased'] = $customer_infomation['date_purchased'];
            $this->delivery["country"] = $customer_infomation['delivery_country'];
            $this->delivery['postcode'] = $customer_infomation['delivery_postcode'];
            $this->customer['email_address'] = $customer_infomation['customers_email_address'];
            $this->customer['name'] = $customer_infomation['customers_name'];
            $this->customer['lastname'] = $customer_infomation['customers_lastname'];

            $billing_info = ucwords($customer_infomation['billing_name'] . ' ' . $customer_infomation['billing_lastname'])
                . '<br>' .
                $customer_infomation['billing_street_address'] . ' ' . $customer_infomation['billing_suburb']
                . '<br>' .
                $customer_infomation['billing_city'] . ', ' . $customer_infomation['billing_postcode']
                . '<br>' .
                $customer_infomation['billing_country']
                . '<br>' .
                $customer_infomation['customers_email_address']
                . '<br>' .
                $customer_infomation['b_tel_prefix'] . '-' . $customer_infomation['billing_telephone'];

            $shipping_info = ucwords($customer_infomation['delivery_name'] . ' ' . $customer_infomation['delivery_lastname'])
                . '<br>' .
                (($customer_infomation['delivery_company']) ? $customer_infomation['delivery_company'] . '<br />' : '')
                . $customer_infomation['delivery_street_address'] . ' ' . $customer_infomation['delivery_suburb']
                . '<br>' .
                $customer_infomation['delivery_city'] . ', ' . $customer_infomation['delivery_postcode']
                . '<br>' .
                $customer_infomation['delivery_country'];

            $customer_info = ucwords($customer_infomation['customers_name'] . ' ' . $customer_infomation['customers_lastname'])
                . '<br>' .
                $customer_infomation['customers_email_address']
                . '<br>' .
                ($customer_infomation['customers_telephone'] ? $customer_infomation['customers_telephone'] : $customer_infomation['b_tel_prefix'] . '-' . $customer_infomation['billing_telephone']);
        } else {
            if ($this->billing['street_address']) {
                $billing_info = ucwords($this->billing['name'] . ' ' . $this->billing['lastname'])
                    . '<br>' .
                    $this->billing['street_address'] . ' ' . $this->billing['suburb']
                    . '<br>' .
                    $this->billing['city'] . ', ' . $this->billing['postcode']
                    . '<br>' .
                    $this->billing['country']
                    . '<br>' .
                    $this->customer['email_address']
                    . '<br>' .
                    $this->billing['tel_prefix'] . '-' . $this->billing['telephone'];
            } else {
                $billing_info = 'Not set yet';
            }

            $shipping_info = ucwords($this->delivery['name'] . ' ' . $this->delivery['lastname'])
                . '<br>' .
                (($this->delivery['company']) ? $this->delivery['company'] . '<br />' : '')
                . $this->delivery['street_address'] . ' ' . $this->delivery['suburb']
                . '<br>' .
                $this->delivery['city'] . ', ' . $this->delivery['postcode']
                . '<br>' .
                $this->delivery['country'];

            $customer_info = ucwords($this->customer['name'] . ' ' . $this->customer['lastname'])
                . '<br>' .
                $this->customer['email_address']
                . '<br>' .
                ($this->customer['telephone'] ? $this->customer['telephone'] : $this->billing['tel_prefix'] . '-' . $this->billing['telephone']);
        }

        //低库存邮件
        if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL == '1') {
            // send an email
            $email_html = zen_get_corresponding_languages_email_common();
            $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
            $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];

            $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;
            $html_msg['EMAIL_MESSAGE_HTML'] = nl2br($email_low_stock);

            zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, $html_msg, 'low_stock_to_us');
        }

        $email_warehouse_info = get_email_langpac();

        //自提标识 $is_local_pickup
        $shipping_method = zen_get_order_shipping_method_by_code($this->info['shipping_method'], $order_id);
        $is_local_pickup = false;
        if ($shipping_method == 'Local Pickup') {
            $is_local_pickup = true;
        }

        //PO订单标识 $purchase_order_num
        $orderRes = $db->getAll("select purchase_order_num,customers_po,payment_module_code,customers_id,orders_number from orders where orders_id = " . $order_id . " limit 1");
        $this->info['orders_number'] = $orderRes[0]['orders_number'];
        $purchase_order_num = $orderRes[0]['purchase_order_num'];

        //Add Order Comments标识
        $customers_po_num = $orderRes[0]['customers_po'];
        $purchase = trim($orderRes[0]['payment_module_code']);

        //游客标识 $is_customer
        $is_customer = $orderRes[0]['customers_id'];

        /* 第一部分 */
        $son_order = array();
        if ($order_id) $son_order = zen_get_all_son_order_id($order_id);
        if (!count($son_order)) {
            $son_order[] = $order_id;
        }
        //
        $html_number = "";
        foreach ($son_order as $key => $value) {
            if ($key == 0) {
                $html_number .= '<a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $value, 'SSL') . '">#' . zen_get_orders_number_by_id($value) . '</a>';
            } else {
                $html_number .= ' & <a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $value, 'SSL') . '">#' . zen_get_orders_number_by_id($value) . '</a>';
                if (!$this->isCCAndPPPayment()) {
                    $de_msg = "";
                    if ($_SESSION['languages_code'] == 'de') {
                        $de_msg = FS_ORDER_EMAIL_09_3;
                    }
                    if ($_SESSION['languages_code'] == 'jp') {
                        $html_number .= '<br>';
                    } else {
                        $html_number .= $de_msg . FS_EMAIL_POINT . '<br>';
                    }
                }
            }
        }

        $purchase_order_num_html = '';
        if ($customers_po_num) {
            $purchase_order_num_html = ' (' . FS_SEND_EMAIL_71 . '<a href="javascript:;" style="color: #232323;text-decoration: none">' . $customers_po_num . '</a>)';
        }

        $order_num = count($son_order);
        $order_number = '';
        $divided_order = '';
        $two_sentence = '';
        if ($order_num === 1) {
            $order_number = $orderRes[0]['orders_number'];
            if (!$complete_mail) {
                $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_02;
                if (!$is_customer) {
                    $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_02;
                }
            } else {
                $first_sentence = FS_ORDER_EMAIL_03 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_04;
                if (!$is_customer) {
                    $first_sentence = FS_ORDER_EMAIL_03 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_04;
                }
                if ($is_local_pickup) {
                    $first_sentence = FS_ORDER_EMAIL_05 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a> ' . $purchase_order_num_html . FS_ORDER_EMAIL_06;
                    if (!$is_customer) {
                        $first_sentence = FS_ORDER_EMAIL_05 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a> ' . $purchase_order_num_html . FS_ORDER_EMAIL_06;
                    }
                }
                $two_sentence = '<tr>
                    <td bgcolor="#fff" style="border-collapse: collapse" height="10">
                    </td>
                    </tr>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDER_EMAIL_69 . '<a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('manage_orders') . '">' . FS_ORDER_EMAIL_70 . '</a>' . FS_ORDER_EMAIL_71 . '
                        </td>
                    </tr>';
            }
        } else {
            if (!$complete_mail) {
                $first_sentence = FS_ORDER_EMAIL_07;
            } else {
                if ($is_local_pickup) {
                    $first_sentence = FS_ORDER_EMAIL_08;
                } else {
                    if ($son_order) {
                        $first_sentence = FS_ORDER_EMAIL_09_1 . $html_number . FS_ORDER_EMAIL_09_2;
                    } else {
                        $first_sentence = FS_ORDER_EMAIL_09;
                    }
                }
                $two_sentence = '<tr>
                    <td bgcolor="#fff" style="border-collapse: collapse" height="10">
                    </td>
                    </tr>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDER_EMAIL_69 . '<a style="color: #0681d3;text-decoration: none" href="' . zen_href_link('manage_orders') . '">' . FS_ORDER_EMAIL_70 . '</a>' . FS_ORDER_EMAIL_71 . '
                        </td>
                    </tr>';
            }
            $divided_order = '';
        }

        $html_msg['MANAGE_ORDERS'] = '';

        /* 第一部分结束 */

        /* 第二部分 */
        if (!$complete_mail && $order_num > 1) {
            $html = $this->email_text_spacing(30, 'border-top: 1px solid #f7f7f7;');
        } else {
            $html = '';
        }

        $html .= $divided_order;
        $order_fraction = '';
        $order_number_html = '';
        $purchase_order_num_muti = '';
        $orderNumerHtml = '';
        $orderKey = 0;
        //是否为德国仓发货
        $isReissueDe = false;
        if ($order_id) {
            foreach ($son_order as $key => $id) {
                $orderKey++;
                $fields = array('orders_number', 'currency', 'currency_value', 'shipping_method', 'is_reissue');
                $order_data = fs_get_data_from_db_fields_array($fields, 'orders', 'orders_id=' . $id, 'limit 1');
                $series_time = self::get_email_series_time($this->info['date_purchased'], $id, $this->delivery['postcode']);

                //判断发货仓是否德国
                if (in_array($order_data[0][4], [6 ,8 ,20])) {
                    $isReissueDe = true;
                }

                $order_fraction = $orderKey . '/' . $order_num;
                $order_num_href = zen_href_link('account_history_info', 'orders_id=' . $id, 'SSL');
                if (!$is_customer) $order_num_href = 'javascript:;';
                $order_number_html = '#' . $order_data[0][0];
                $orderNumerHtml .= '#' . $order_data[0][0] . ' & ';
                if ($order_num > 1) {
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                ' . FS_ORDER_EMAIL_14 . ' ' . $order_fraction . ' <a style="color: #0070BC;text-decoration: none" href="' . $order_num_href . '">' . FS_ORDER_EMAIL_10 . $order_number_html . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
                    if ($customers_po_num) {
                        $html .= $this->email_text_spacing(10);
                        $html .=
                            '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                    ' . FS_SEND_EMAIL_71 . '<a style="text-decoration: none;color: #232323" href="javascript:;">' . $customers_po_num . '</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                    }
                    if ($complete_mail) {
                        $html .= $this->email_text_spacing(30);
                    }
                }
                //cc和pp不再位于这里展示流程轴
                if ($complete_mail && !$this->isCCAndPPPayment()) {
                    if (in_array($order_data[0][4], array(1, 4, 6, 9, 12, 22, 23, 24))) {
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="35%" style="border-collapse: collapse;font-size: 14px;color: #333;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="right">
                                            ' . FS_ORDER_EMAIL_72 . '
                                            </td>
                                                <td width="30%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                            ' . FS_ORDER_EMAIL_74 . '
                                            </td>
                                                <td width="35%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;text-indent: 20px">
                                            ' . FS_ORDER_EMAIL_75 . '
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                        $html .= $this->email_text_spacing(15);
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                            <img style="display: inline-block;max-width: 100%" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/progress-line-three01.png" alt="">
                        </td>
                    </tr>
                    </tbody>
                </table>';
                        $html .= $this->email_text_spacing(30);
                    } else {
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #333;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                   ' . FS_ORDER_EMAIL_72 . '
                                                </td>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                    ' . FS_ORDER_EMAIL_73 . '
                                                </td>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                    ' . FS_ORDER_EMAIL_74 . '
                                                </td>
                                                <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #999;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                                    ' . FS_ORDER_EMAIL_75 . '
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                        $html .= $this->email_text_spacing(15);
                        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                            <img style="display: inline-block;max-width: 100%" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/progress-line-four01.png" alt="">
                        </td>
                    </tr>
                    </tbody>
                </table>';
                        $html .= $this->email_text_spacing(30);
                    }
                }
                $products = zen_get_products_by_order_id($id, $order_data[0][1]);
                $products_count = count($products);
                foreach ($products as $kk => $product) {
                    if ($kk == $products_count - 1) $product_border = 'border-bottom: 1px solid #f7f7f7;';
                    $border_top = 'border-top: 1px solid #f7f7f7;';
                    if (!$complete_mail && $order_num > 1) {
                        $border_top = '';
                    }
                    //获取订单产品图片和标题HTML
                    $productHtml = $this->create_product_html($product, $order_data[0][4]);
                    $image_html = $productHtml['image_html'];
                    $title_html = $productHtml['title_html'];
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;' . $border_top . $product_border . '">';

                    $html .=
                        '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>
                        
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td width="60" valign="middle" style="border-collapse: collapse;">
                            ' . $image_html . '
                        </td>
                        <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #232323;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                            ' . $title_html . '
                            <br>
                            ' . FS_SEND_EMAIL_8 . $product['qty'] . '
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>';

                    $html .= '</td></tr></tbody></table>';
                }
                if ($orderKey == $order_num) {
                    $html .= $this->email_text_spacing(20);
                } else {
                    $html .= $this->email_text_spacing(30);
                }
            }
        }
        $html_msg['PRODUCTS_INFO'] = $html;
        /* 第二部分结束 */

        /* 第三部分 */
        $html_msg['SHIPPING_INFO'] = $shipping_info;
        $html_msg['BILLING_INFO'] = $billing_info;
        $html_msg['CUSTOMER_INFO'] = $customer_info;
        //$this->info['payment_method'] = 'payeezy';

        //自提显示仓库信息
        if ($is_local_pickup) {
            $warehouse = fs_get_data_from_db_fields('warehouse', 'orders', 'orders_id=' . $order_id, 'limit 1');
            $html_msg['SHIPPING_INFO'] = zen_get_orders_warehouse_address($warehouse);
            $customer_pickself_info = fs_get_data_from_db_fields_array(['photo_name', 'email_address', 'phone'], 'order_pickbyself_info', 'order_id=' . $order_id, 'limit 1');
            $html_msg['CUSTOMER_INFO'] = ucfirst($customer_pickself_info[0][0])
                . '<br>' .
                $customer_pickself_info[0][1]
                . '<br>' .
                $customer_pickself_info[0][2];
        }
        //2019/8/7 ternence 添加信用卡付款默认邮件模板
        if (!$complete_mail) {
            $email_template = "checkout_paypal_or_credit_card";
        } else {
            $email_template = "checkout_payment_sucess";
        }
        switch (1) {
            case preg_match('/globalcollect/i', $this->info['payment_method']):
            case preg_match('/payeezy/i', $this->info['payment_method']):
                if (!$complete_mail) {
                    $html_msg['INSTRUCTION'] = '
  				<p>Dear ' . $name . ',</p>
            <p>' . FS_WAREHOUSE_AREA_17 . '</p>
  				';
                    $html_msg['DESCRIPTION'] = 'Order Received, Awaiting Processing';
                    $html_msg['EMAIL_TOP_TITLE'] = FS_EMAIL_OPTIMIZE_07;
                    $email_template = "checkout_paypal_or_credit_card_new";
                } else {
                    $html_msg['INSTRUCTION'] = '
	  					<p>Dear ' . $name . ',</p>
	            <p>' . FS_WAREHOUSE_AREA_18 . $this->info['orders_number'] . FS_WAREHOUSE_AREA_19 . $date . " " . FS_WAREHOUSE_AREA_24 . '<br />
				' . FS_WAREHOUSE_AREA_25 . ' <a style=" color:#363636;" href="mailto:service.us@fs.comlegal@fs.com">service.us@fs.comlegal@fs.com</a>. </p>
	  					';
                    $html_msg['DESCRIPTION'] = FS_WAREHOUSE_AREA_26;
                    $html_msg['NEW_TOP'] = $this->ccAndPpPayedNewTop($html_number, count($son_order));
                    $email_template = "checkout_payment_sucess_cc_pp";
                }
                break;
        }

        //支付方式
        $html_msg['PAYMENT_METHOD'] = EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_CARD;

        $cost_data = zen_get_order_cost_by_order($order_id, true);
        //小计
        $html_msg['SUBTOTAL'] = $cost_data['ot_subtotal']['text'];
        //总计
        $html_msg['TOTAL'] = $cost_data['ot_total']['text'];
        //运费
        $shipping_charge = $this->info['shipping_text'];

        $is_au_gsp = $this->info['delivery_country_id'] == 13 ? true : false;
        //如果收货地址为澳大利亚  展示税后价
        if($is_au_gsp){
            $tax_data = zen_get_order_au_tax_order($order_id);
            if($tax_data){
                $html_msg['SUBTOTAL'] = $tax_data['tax_subtotal']['text'];
                $html_msg['TOTAL'] = $tax_data['tax_total']['text'];
                $shipping_charge = $tax_data['tax_shipping']['text'];
            }
        }

        $html_msg['SHIPPING_CHARGE'] = $shipping_charge;
        //税（判断是否显示）
        $vat_html = '';
        if ($cost_data['ot_tax']) {
            if ($is_au_gsp) {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    '.FS_BLANKET_33.':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } elseif (strtolower($this->delivery["country"]) == 'monaco') {     // 2019-7-11 potato 添加摩纳哥的税率
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST_FR . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } elseif (strtolower($this->delivery["country"]) == 'united states') {
                $vaxTitle = $complete_mail ? FS_VAX_TITLE_US_TAX : FS_VAX_TITLE_US;
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . $vaxTitle . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } else {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            }
        }
        $html_msg['VAT_TEXT'] = $vat_html;
        /* 第三部分结束 */

        if ($is_customer) {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_18 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_20;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_21 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_22;
        } else {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_23;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_24;
        }

        //邮件预设
        if (!$complete_mail) {
            $fs_title = FS_ORDER_EMAIL_26;
            $display_none_title = FS_ORDER_EMAIL_25;
            if ($this->isCCAndPPPayment()) {
                $fs_title = FS_EMAIL_OPTIMIZE_01;
            } else {
                $fs_title = FS_ORDER_EMAIL_26;
            }
        } else {
            if ($this->isCCAndPPPayment()) {
                $fs_title = FS_EMAIL_OPTIMIZE_05;
            } else {
                $fs_title = FS_ORDER_EMAIL_27;
            }
            $display_none_title = FS_ORDER_EMAIL_42;
        }
        $html = common_email_header_and_footer($fs_title, $display_none_title, $email_warehouse_info, $isReissueDe);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];

        $customer_name = ucwords($this->customer['name'] . ($this->customer['lastname'] ? ' ' . $this->customer['lastname'] : ''));
        $html_msg['CUSTOMER_NAME'] = $customer_name;
        $html_msg['COMMON_DEAR'] = FS_ORDER_EMAIL_28;
        $html_msg['EMAIL_TEXT_01'] = $first_sentence;
        if (!$complete_mail && $this->isCCAndPPPayment()) {
            $html_msg['MAKE_PAYMENT'] = $this->ccAndPpEmailPaymentButton();
        } else {
            $html_msg['MAKE_PAYMENT'] = '';
        }
        $html_msg['EMAIL_TEXT_48'] = $two_sentence;
        $html_msg['FS_ORDER_EMAIL_29'] = FS_ORDER_EMAIL_29;
        if ($is_local_pickup) {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_44;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_45;
        } else {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_30;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_31;
        }
        $html_msg['FS_ORDER_EMAIL_32'] = FS_ORDER_EMAIL_32;
        $html_msg['FS_ORDER_EMAIL_33'] = FS_ORDER_EMAIL_33;
        $html_msg['FS_ORDER_EMAIL_34'] = FS_ORDER_EMAIL_34;
        $html_msg['FS_ORDER_EMAIL_35'] = FS_ORDER_EMAIL_35;
        $html_msg['FS_ORDER_EMAIL_36'] = FS_ORDER_EMAIL_36;
        $html_msg['FS_ORDER_EMAIL_37'] = FS_ORDER_EMAIL_37;
        $html_msg['FS_ORDER_EMAIL_38'] = FS_ORDER_EMAIL_38;
        $html_msg['FS_ORDER_EMAIL_39'] = FS_ORDER_EMAIL_39;
        $html_msg['FS_ORDER_EMAIL_40'] = FS_ORDER_EMAIL_40;
        $html_msg['FS_ORDER_EMAIL_41'] = FS_ORDER_EMAIL_41;
        $html_msg['FS_EMAIL_COMMA'] = FS_EMAIL_COMMA;

        if($is_au_gsp){
            $html_msg['FS_ORDER_EMAIL_38'] = FS_BLANKET_34;
        }
        $orderNumerHtml = trim($orderNumerHtml);
        $orderNumerHtml = trim($orderNumerHtml, '&');
        $orderNumerHtml = trim($orderNumerHtml);

        if ($purchase_order_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$purchase_order_num.')';
        } elseif ($customers_po_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$customers_po_num.')';
        }

        $email_title = sprintf(FS_ORDER_EMAIL_43, $orderNumerHtml);
        if ($complete_mail) {
            $email_title = sprintf(FS_ORDER_EMAIL_47, $orderNumerHtml);
        }
        $oid = 0;
        if (!$complete_mail) {
            $oid = $order_id;
        }
        sendwebmail($customer_name, $this->customer['email_address'], '信用卡订单邮件发送给客户' . $this->customer['email_address'] . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);

        // $cost_value = zen_get_order_value_by_order($order_id);
        // //判断是否需要密送trustpilot
        // if($this->is_bcc_to_trustpilot($order_id,$cost_value,$complete_mail)){
        //     $bcc_email = ['468638a060@invite.trustpilot.com','fs.angelinali@gmail.com'];
        //     zen_mail($customer_name, $this->customer['email_address'], $email_title, '', STORE_NAME, EMAIL_FROM, $html_msg, $email_template, $this->attachArray,$bcc_email);
        // }else{
        //     sendwebmail($customer_name, $this->customer['email_address'],'信用卡订单邮件发送给客户'.$this->customer['email_address'].date('Y-m-d H:i:s', time()),STORE_NAME,$email_title, $html_msg, $email_template,81,$this->attachArray);
        // }

        if ($_SESSION['customer_id']) {
            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
        } else {
            //游客下单不注册给销售发送订单提醒邮件
            $admin_id = zen_get_customer_order_has_admin_id($order_id);
        }

        if ($admin_id) {
            define('EMAIL_SUBJECT', 'FS.COM Order# ' . $this->info['orders_number']);
            $admin_data = fs_get_data_from_db_fields_array(['admin_name', 'admin_email'], 'admin', 'admin_id=' . $admin_id, 'limit 1');
            $admin_name = $admin_data[0][0];
            $admin_email = $admin_data[0][1];
            sendwebmail($admin_name, $admin_email, '信用卡订单邮件发送给销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
        }

        //SG、AU自提付款成功邮件发送到客户区域邮箱 sg@fs.com au@fs.com
        if ($complete_mail && $is_local_pickup) {
            $regional_sales = '';
            if (in_array(strtolower($this->delivery["country"]), ['australia', 'singapore'])) {
                if (strtolower($this->delivery["country"]) == 'australia') {
                    $regional_sales = 'au@fs.com';
                } else {
                    $regional_sales = 'sg@fs.com';
                }
            }
            if (!empty($regional_sales)) {
                sendwebmail($regional_sales, $regional_sales, '发送给区域销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
            }
        }
        //如果是de-en 发送密送邮件到trustpilot
        if ($_SESSION['languages_code'] == 'dn' && $this->is_send_trustpilot) {
            $bcc_email = 'fs.com+468638a060@invite.trustpilot.com';
            if ($cost_data['ot_total']['value'] > 540) {
                sendwebmail('Angelina.Li', $bcc_email, '客户下单Trustpilot邮件' . $bcc_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
                sendwebmail('Angelina.Li', 'Angelina.Li@feisu.com', '客户下单Trustpilot邮件Angelina.Li@feisu.com' . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, $email_template, 81, $this->attachArray, $oid);
            }
        }
    }

    function send_fs_gc_order_email($order_id, $payment)
    {
        global $currencies, $order_totals, $db;

        //低库存邮件
        if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL == '1') {
            // send an email
            $email_html = zen_get_corresponding_languages_email_common();
            $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
            $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];

            $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;
            $html_msg['EMAIL_MESSAGE_HTML'] = nl2br($email_low_stock);

            zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, $html_msg, 'low_stock_to_us');
        }

        $email_warehouse_info = get_email_langpac();

        //自提标识 $is_local_pickup
        $shipping_method = zen_get_order_shipping_method_by_code($this->info['shipping_method'], $order_id);
        $is_local_pickup = false;
        if ($shipping_method == 'Local Pickup') {
            $is_local_pickup = true;
        }

        //PO订单标识 $purchase_order_num
        $orderRes = $db->getAll("select purchase_order_num,customers_po,payment_module_code,customers_id,orders_number from orders where orders_id = " . $order_id . " limit 1");
        $this->info['orders_number'] = $orderRes[0]['orders_number'];
        $purchase_order_num = $orderRes[0]['purchase_order_num'];

        //Add Order Comments标识
        $customers_po_num = $orderRes[0]['customers_po'];
        $purchase = trim($orderRes[0]['payment_module_code']);

        //游客标识 $is_customer
        $is_customer = $orderRes[0]['customers_id'];

        /* 第一部分 */
        $son_order = array();
        if ($order_id) $son_order = zen_get_all_son_order_id($order_id);
        if (!count($son_order)) {
            $son_order[] = $order_id;
        }

        $purchase_order_num_html = '';
        if ($customers_po_num) {
            $purchase_order_num_html = ' (' . FS_SEND_EMAIL_71 . '<a href="javascript:;" style="color: #232323;text-decoration: none">' . $customers_po_num . '</a>)';
        }

        $order_num = count($son_order);
        $order_number = '';
        $divided_order = '';
        if ($order_num === 1) {
            $order_number = $orderRes[0]['orders_number'];
            $first_sentence = FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $order_id, 'SSL') . '">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_02;
            if (!$is_customer) {
                FS_ORDER_EMAIL_01 . '<a style="color: #0070BC;text-decoration: none" href="javascript:;">#' . $order_number . '</a>' . $purchase_order_num_html . FS_ORDER_EMAIL_02;
            }
            // if($is_local_pickup){
            //     $first_sentence = FS_ORDER_EMAIL_05.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('account_history_info','orders_id='.$order_id,'SSL').'">#'.$order_number.'</a> '.$purchase_order_num_html.FS_ORDER_EMAIL_06;
            // }
        } else {
            $first_sentence = FS_ORDER_EMAIL_07;
            // if($is_local_pickup){
            //     $first_sentence = FS_ORDER_EMAIL_08;
            // }
            $divided_order =
                '<table width="640" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                    ' . FS_ORDER_EMAIL_11 . $order_num . FS_ORDER_EMAIL_12 . '
                    </td>
                </tr>
                </tbody>
            </table>' . $this->email_text_spacing(10);
        }
        $manage_orders =
            '<table width="640" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="center">
                    <a style="font-size: 14px;display: inline-block;text-decoration: none;color: #0070BC;padding: 10px 12px;border: 1px solid #0070BC;border-radius:2px;" href="' . zen_href_link(FILENAME_MANAGE_ORDERS, '', 'SSL') . '">' . FS_ORDER_EMAIL_13 . '</a>
                </td>
            </tr>
            </tbody>
        </table>';
        if ($is_customer) {
            $html_msg['MANAGE_ORDERS'] = $manage_orders . $this->email_text_spacing(30);
        } else {
            $html_msg['MANAGE_ORDERS'] = '';
        }
        /* 第一部分结束 */

        /* 第二部分 */
        //$html_msg['DIVIDED_ORDER'] = $divided_order;
        //$date_time = date('m-d-Y H:i:s A',strtotime(trim($this->info['date_purchased'])));
        //$date = date('F j, Y H:i:s',strtotime($this->info['date_purchased']));

        if ($order_num > 1) {
            $html = $this->email_text_spacing(30, 'border-top: 1px solid #f7f7f7;');
        } else {
            $html = '';
        }

        $html .= $divided_order;
        $order_fraction = '';
        $order_number_html = '';
        $purchase_order_num_muti = '';
        $orderNumerHtml = '';
        $orderKey = 0;
        //是否为德国仓发货
        $isReissueDe = false;
        if ($order_id) {
            foreach ($son_order as $key => $id) {
                $orderKey++;
                $fields = array('orders_number', 'currency', 'currency_value', 'shipping_method', 'is_reissue');
                $order_data = fs_get_data_from_db_fields_array($fields, 'orders', 'orders_id=' . $id, 'limit 1');
                $series_time = self::get_email_series_time($this->info['date_purchased'], $id, $this->delivery['postcode']);

                //判断发货仓是否德国
                if (in_array($order_data[0][4], [6 ,8 ,20])) {
                    $isReissueDe = true;
                }

                $order_fraction = $orderKey . '/' . $order_num;
                $order_num_href = zen_href_link('account_history_info', 'orders_id=' . $id, 'SSL');
                if (!$is_customer) $order_num_href = 'javascript:;';
                $order_number_html = '#' . $order_data[0][0];
                $orderNumerHtml .= '#' . $order_data[0][0] . ' & ';
                if ($order_num > 1) {
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                ' . FS_ORDER_EMAIL_14 . ' ' . $order_fraction . ' <a style="color: #0070BC;text-decoration: none" href="' . $order_num_href . '">' . FS_ORDER_EMAIL_10 . $order_number_html . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
                    if ($customers_po_num) {
                        $html .= $this->email_text_spacing(10);
                        $html .=
                            '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                    ' . FS_SEND_EMAIL_71 . '<a style="text-decoration: none;color: #232323" href="javascript:;">' . $customers_po_num . '</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                    }
                    $html .= $this->email_text_spacing(30);
                }

                $products = zen_get_products_by_order_id($id, $order_data[0][1]);
                $products_count = count($products);
                foreach ($products as $kk => $product) {
                    $product_border = '';
                    if ($kk == $products_count - 1) $product_border = 'border-bottom: 1px solid #f7f7f7;';
                    //获取订单产品图片和标题HTML
                    $productHtml = $this->create_product_html($product, $order_data[0][4]);
                    $image_html = $productHtml['image_html'];
                    $title_html = $productHtml['title_html'];
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;border-top: 1px solid #f7f7f7;' . $product_border . '">';

                    $html .=
                        '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>

                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td width="60" valign="middle" style="border-collapse: collapse;">
                            ' . $image_html . '
                        </td>
                        <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #232323;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                            ' . $title_html . '
                            <br>
                            ' . FS_SEND_EMAIL_8 . $product['qty'] . '
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>';

                    $html .= '</td></tr></tbody></table>';
                }
                if ($orderKey == $order_num) {
                    $html .= $this->email_text_spacing(20);
                } else {
                    $html .= $this->email_text_spacing(30);
                }
            }
        }
        $html_msg['PRODUCTS_INFO'] = $html;
        /* 第二部分结束 */

        /* 第三部分 */

        $html_msg['PAYMENT_INFO'] = '';

        if ($this->billing['street_address']) {
            $billing_info = ucwords($this->billing['name'] . ' ' . $this->billing['lastname'])
                . '<br>' .
                $this->billing['street_address'] . ' ' . $this->billing['suburb']
                . '<br>' .
                $this->billing['city'] . ', ' . $this->billing['postcode']
                . '<br>' .
                $this->billing['country']
                . '<br>' .
                $this->customer['email_address']
                . '<br>' .
                $this->billing['tel_prefix'] . '-' . $this->billing['telephone'];
        } else {
            $billing_info = 'Not set yet';
        }

        $shipping_info = ucwords($this->delivery['name'] . ' ' . $this->delivery['lastname'])
            . '<br>' .
            (($this->delivery['company']) ? $this->delivery['company'] . '<br />' : '')
            . $this->delivery['street_address'] . ' ' . $this->delivery['suburb']
            . '<br>' .
            $this->delivery['city'] . ', ' . $this->delivery['postcode']
            . '<br>' .
            $this->delivery['country'];

        $customer_info = ucwords($this->customer['name'] . ' ' . $this->customer['lastname'])
            . '<br>' .
            $this->customer['email_address']
            . '<br>' .
            ($this->customer['telephone'] ? $this->customer['telephone'] : $this->billing['tel_prefix'] . '-' . $this->billing['telephone']);

        $html_msg['SHIPPING_INFO'] = $shipping_info;
        $html_msg['BILLING_INFO'] = $billing_info;
        $html_msg['CUSTOMER_INFO'] = $customer_info;

        //自提显示仓库信息
        if ($is_local_pickup) {
            $warehouse = fs_get_data_from_db_fields('warehouse', 'orders', 'orders_id=' . $order_id, 'limit 1');
            $html_msg['SHIPPING_INFO'] = zen_get_orders_warehouse_address($warehouse);
            $customer_pickself_info = fs_get_data_from_db_fields_array(['photo_name', 'email_address', 'phone'], 'order_pickbyself_info', 'order_id=' . $order_id, 'limit 1');
            $html_msg['CUSTOMER_INFO'] = ucfirst($customer_pickself_info[0][0])
                . '<br>' .
                $customer_pickself_info[0][1]
                . '<br>' .
                $customer_pickself_info[0][2];
        }

        //支付方式
        $html_msg['PAYMENT_METHOD'] = $payment;

        $cost_data = zen_get_order_cost_by_order($order_id, true);
        //小计
        $html_msg['SUBTOTAL'] = $cost_data['ot_subtotal']['text'];
        //总计
        $html_msg['TOTAL'] = $cost_data['ot_total']['text'];
        //运费
        $shipping_charge = $this->info['shipping_text'];

        $is_au_gsp = $this->info['delivery_country_id'] == 13 ? true : false;
        //如果收货地址为澳大利亚  展示税后价
        if($is_au_gsp){
            $tax_data = zen_get_order_au_tax_order($order_id);
            if($tax_data){
                $html_msg['SUBTOTAL'] = $tax_data['tax_subtotal']['text'];
                $html_msg['TOTAL'] = $tax_data['tax_total']['text'];
                $shipping_charge = $tax_data['tax_shipping']['text'];
            }
        }

        $html_msg['SHIPPING_CHARGE'] = $shipping_charge;
        //税（判断是否显示）
        $vat_html = '';
        if ($cost_data['ot_tax']) {
            if ($is_au_gsp) {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    '.FS_BLANKET_33.':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } elseif (strtolower($this->delivery["country"]) == 'monaco') {     // 2019-7-11 potato 添加摩纳哥的税率
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST_FR . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            } else {
                $vat_html =
                    '<tr>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #818181;line-height: 22px;font-family:Open Sans,arial,sans-serif;" align="left">
                    ' . EMAIL_CHECKOUT_COMMON_VAT_COST . ':
                    </td>
                    <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family:Open Sans,arial,sans-serif;padding-right: 18px;white-space: nowrap" align="right">
                    ' . $cost_data['ot_tax']['text'] . '
                    </td>
                </tr>';
            }
        }
        $html_msg['VAT_TEXT'] = $vat_html;
        /* 第三部分结束 */

        if ($is_customer) {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_18 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_20;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_21 . '<a style="color: #0070BC;text-decoration:none" href="' . zen_href_link(FILENAME_MY_DASHBOARD, '', 'SSL') . '">' . FS_ORDER_EMAIL_19 . '</a>' . FS_ORDER_EMAIL_22;
        } else {
            $html_msg['EMAIL_TEXT_02'] = FS_ORDER_EMAIL_23;
            $html_msg['EMAIL_TEXT_03'] = FS_ORDER_EMAIL_24;
        }

        //邮件隐藏标题
        $display_none_title = FS_ORDER_EMAIL_25;

        $html = common_email_header_and_footer(FS_ORDER_EMAIL_26, $display_none_title, $email_warehouse_info, $isReissueDe);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];

        $customer_name = ucwords($this->customer['name'] . ($this->customer['lastname'] ? ' ' . $this->customer['lastname'] : ''));
        $html_msg['CUSTOMER_NAME'] = $customer_name;
        $html_msg['COMMON_DEAR'] = FS_ORDER_EMAIL_28;
        $html_msg['EMAIL_TEXT_01'] = $first_sentence;
        $html_msg['FS_ORDER_EMAIL_29'] = FS_ORDER_EMAIL_29;
        $html_msg['MAKE_PAYMENT'] = '';
        if ($is_local_pickup) {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_44;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_45;
        } else {
            $html_msg['FS_ORDER_EMAIL_30'] = FS_ORDER_EMAIL_30;
            $html_msg['FS_ORDER_EMAIL_31'] = FS_ORDER_EMAIL_31;
        }
        $html_msg['FS_ORDER_EMAIL_32'] = FS_ORDER_EMAIL_32;
        $html_msg['FS_ORDER_EMAIL_33'] = FS_ORDER_EMAIL_33;
        $html_msg['FS_ORDER_EMAIL_34'] = FS_ORDER_EMAIL_34;
        $html_msg['FS_ORDER_EMAIL_35'] = FS_ORDER_EMAIL_35;
        $html_msg['FS_ORDER_EMAIL_36'] = FS_ORDER_EMAIL_36;
        $html_msg['FS_ORDER_EMAIL_37'] = FS_ORDER_EMAIL_37;
        $html_msg['FS_ORDER_EMAIL_38'] = FS_ORDER_EMAIL_38;
        $html_msg['FS_ORDER_EMAIL_39'] = FS_ORDER_EMAIL_39;
        $html_msg['FS_ORDER_EMAIL_40'] = FS_ORDER_EMAIL_40;
        $html_msg['FS_ORDER_EMAIL_41'] = FS_ORDER_EMAIL_41;
        $html_msg['FS_EMAIL_COMMA'] = FS_EMAIL_COMMA;

        if($is_au_gsp){
            $html_msg['FS_ORDER_EMAIL_38'] = FS_BLANKET_34;
        }
        $orderNumerHtml = trim($orderNumerHtml);
        $orderNumerHtml = trim($orderNumerHtml, '&');
        $orderNumerHtml = trim($orderNumerHtml);

        if ($purchase_order_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$purchase_order_num.')';
        } elseif ($customers_po_num) {
            $orderNumerHtml = $orderNumerHtml.'('. FS_ACCOUNT_PO_NUMBER.$customers_po_num.')';
        }

        $email_title = sprintf(FS_ORDER_EMAIL_43, $orderNumerHtml);

        sendwebmail($customer_name, $this->customer['email_address'], '订单邮件发送给客户' . $this->customer['email_address'] . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $order_id);

        // $cost_value = zen_get_order_value_by_order($order_id);
        // if($this->is_bcc_to_trustpilot($order_id,$cost_value)){
        //     $bcc_email = ['468638a060@invite.trustpilot.com','fs.angelinali@gmail.com'];
        //     zen_mail($customer_name, $this->customer['email_address'], $email_title, '', STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_westernunion_or_wiretransfer', $this->attachArray,$bcc_email);
        // }else{
        //     sendwebmail($customer_name, $this->customer['email_address'],'订单邮件发送给客户'.$this->customer['email_address'].date('Y-m-d H:i:s', time()),STORE_NAME,$email_title, $html_msg, 'checkout_westernunion_or_wiretransfer',81,$this->attachArray);
        // }

        if ($_SESSION['customer_id']) {
            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
        }

        if ($admin_id) {
            define('EMAIL_SUBJECT', 'Fiberstore' . $purchase_str . ' Order# ' . $this->info['orders_number']);
            $admin_data = fs_get_data_from_db_fields_array(['admin_name', 'admin_email'], 'admin', 'admin_id=' . $admin_id, 'limit 1');
            $admin_name = $admin_data[0][0];
            $admin_email = $admin_data[0][1];
            sendwebmail($admin_name, $admin_email, '订单邮件发送给销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $order_id);
        }
        //如果是de-en 发送密送邮件到trustpilot
        if ($_SESSION['languages_code'] == 'dn' && $this->is_send_trustpilot) {
            $bcc_email = 'fs.com+468638a060@invite.trustpilot.com';
            if ($cost_data['ot_total']['value'] > 540) {
                sendwebmail('Angelina.Li', $bcc_email, '客户下单Trustpilot邮件' . $bcc_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray);
                sendwebmail('Angelina.Li', 'Angelina.Li@feisu.com', '客户下单Trustpilot邮件Angelina.Li@feisu.com' . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_westernunion_or_wiretransfer', 81, $this->attachArray, $order_id);
            }
        }
    }

    function zen_get_order_delay_products($zf_insert_id)
    {
        $products = array();
        $is_seattle_order = fs_get_data_from_db_fields('is_seattle_order', 'orders', 'orders_id=' . $zf_insert_id, 'limit 1');
        if ($is_seattle_order != 1) {
            $orders_arr = fs_get_data_from_db_fields_array(array('products_id', 'is_seattle_warehouse'), 'orders_products', 'orders_id=' . $zf_insert_id, '');
            if ($orders_arr) {
                foreach ($orders_arr as $order) {
                    if ($order[1] != 1) {
                        $products[] = $order[0];
                    }
                }
            }
        }
        return $products;
    }


    function send_order_delay_shipping_email($zf_insert_id, $products)
    {
        $order = fs_get_data_from_db_fields_array(array('customers_id', 'orders_number'), 'orders', 'orders_id=' . $zf_insert_id, 'limit 1');
        $customer_id = $order[0][0];
        $order_number = $order[0][1];
        $product_str = '';
        foreach ($products as $pid) {
            $product_str .= '#' . $pid . ', ';
        }
        $product_str = substr($product_str, 0, strlen($product_str) - 2);
        if ($customer_id) {
            $customer_arr = fs_get_data_from_db_fields_array(array('customers_firstname', 'customers_lastname', 'customers_email_address'), 'customers', 'customers_id=' . $customer_id, 'limit 1');
            $admin_id = zen_get_customer_has_allot_to_admin($customer_id);
        }
        $to_name = $customer_arr[0][0] . ' ' . $customer_arr[0][1];
        $to_email = $customer_arr[0][2];
        $email_html = zen_get_corresponding_languages_email_common();
//      if(in_array($this->delivery['country'],array('United States','Canada','Mexico'))){
//          $html_msg['THANKSGIVING'] = 'Kind note: Due to the Thanksgiving Day, all orders will be delayed to be shipped out until Nov. 27th PST. Thanks for your understanding.';
//      }else{
        $html_msg['THANKSGIVING'] = '';
//      }
        $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
        $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];
        $html_msg['EMAIL_BODY'] = '<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
				<tbody>
		
				<tr>
					<td style="padding:0 30px; font-size:11px;" colspan="2">
						<p style=" display:block; padding-bottom:10px;"><br><br>' . EMAIL_BODY_COMMON_DEAR . ' ' . $to_name . ',</p>
						<p style="padding-bottom:10px; height:0">' . sprintf(ORDER_DELAY_EMAIL_WE, $order_number) . '</p><br>
						<p style="padding-bottom:10px; height:0">' . sprintf(ORDER_DELAY_EMAIL_THIS, $product_str) . '</p><br><br>
						<p style="padding-bottom:10px; height:0">' . ORDER_DELAY_EMAIL_PLEASE . '</p><br><br>
						<p style="padding-bottom:10px; height:0">' . ORDER_DELAY_EMAIL_THANKS . '</p><br><br>
						
						<span style="color: #232323;padding-bottom:10px;">FS.COM</span><br><br>
						
					</td>
				</tr>
				</tbody>
			</table>';
        sendwebmail($to_name, $to_email, '订单延迟发货邮件发送给客户' . $to_email . date('Y-m-d H:i:s', time()), STORE_NAME, ORDER_DELAY_TITLE, $html_msg, 'update_address', $zf_insert_id);
//        zen_mail($to_name, $to_email,ORDER_DELAY_TITLE, $text_message,'service@fiberstore.net',EMAIL_FROM, $html_msg, 'update_address');
        if ($admin_id) {
            $admin_name = zen_get_admin_name_of_id($admin_id);
            $admin_email = zen_get_admin_email_of_name($admin_name);
            sendwebmail($admin_name, $admin_email, '订单延迟发货邮件发送给销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, ORDER_DELAY_TITLE, $html_msg, 'update_address', $zf_insert_id);
//            zen_mail($admin_name, $admin_email,ORDER_DELAY_TITLE, $text_message,'service@fiberstore.net',EMAIL_FROM, $html_msg, 'update_address');
        }
    }

    /**
     * add by aron
     * 获取分单信息
     * @return array  num => 分单数量 data=>订单标识
     */
    function get_order_num()
    {
        if (!empty($this->local_info["products_arr"]) && !empty($this->delay_info['products_arr']) && !empty($this->global_info["products_arr"]) && !empty($this->gift_info['products_arr'])) {
            return array("num" => 4, "data" => "local-delay-global-gift");
        } elseif (!empty($this->local_info["products_arr"]) && !empty($this->delay_info['products_arr']) && !empty($this->global_info["products_arr"])) {
            return array("num" => 3, "data" => "local-delay-global");
        } elseif (!empty($this->local_info["products_arr"]) && !empty($this->delay_info['products_arr']) && !empty($this->gift_info["products_arr"])) {
            return array("num" => 3, "data" => "local-delay-gift");
        } elseif (!empty($this->local_info["products_arr"]) && !empty($this->global_info['products_arr']) && !empty($this->gift_info["products_arr"])) {
            return array("num" => 3, "data" => "local-global-gift");
        } elseif (!empty($this->delay_info["products_arr"]) && !empty($this->global_info['products_arr']) && !empty($this->gift_info["products_arr"])) {
            return array("num" => 3, "data" => "delay-global-gift");
        } elseif (!empty($this->local_info["products_arr"]) && !empty($this->delay_info['products_arr'])) {
            return array("num" => 2, "data" => "local-delay");
        } elseif (!empty($this->local_info["products_arr"]) && !empty($this->global_info["products_arr"])) {
            return array("num" => 2, "data" => "local-global");
        } elseif (!empty($this->delay_info['products_arr']) && !empty($this->global_info['products_arr'])) {
            return array("num" => 2, "data" => "delay-global");
        } elseif (!empty($this->gift_info['products_arr']) && !empty($this->global_info['products_arr'])) {
            return array("num" => 2, "data" => "global-gift");
        } elseif (!empty($this->gift_info['products_arr']) && !empty($this->delay_info['products_arr'])) {
            return array("num" => 2, "data" => "delay-gift");
        } elseif (!empty($this->local_info['products_arr']) && !empty($this->gift_info['products_arr'])) {
            return array("num" => 2, "data" => "local-gift");
        } else {
            if (!empty($this->local_info['products_arr'])) {
                $data = "local";
            } elseif (!empty($this->delay_info['products_arr'])) {
                $data = "delay";
            } elseif (!empty($this->gift_info['products_arr'])) {
                $data = "gift";
            } else {
                $data = "global";
            }
            return array("num" => 1, "data" => $data);
        }
    }

    /**
     * 判断客户是否首次下单
     * @return bool
     */
    function new_customer_orders()
    {
        global $db;
        $customerId = $_SESSION['customer_id'];
        if (empty($customerId)) {
            return false;
        }
        $order_count = $db->getAll("SELECT COUNT(orders_id) FROM " . TABLE_ORDERS . " WHERE customers_id =" . $customerId . " and main_order_id in (0,1) and orders_status NOT IN (1,5)");
        if ($order_count[0]['COUNT(orders_id)'] == 0) {
            return 3;
        } else {
            return false;
        }

    }

    /**
     * 判断地址是否首5天内多次下单
     * @return bool
     */
    function many_times_order($street_address)
    {
        global $db;
        $time = date('Y-m-d h:i;s', strtotime('-5 day'));
        $order_count = $db->getAll("SELECT COUNT(orders_id) FROM " . TABLE_ORDERS . " WHERE delivery_street_address ='" . $street_address . "' and date_purchased >'" . $time . "' and main_order_id in(0,1)");
        if ((int)$order_count[0]['COUNT(orders_id)'] >= 2) {
            return 4;
        } else {
            return false;
        }
    }


    /**
     * 判断客户ip是否首5天内多次下单
     * @return bool
     */
    function number_of_ip_orders()
    {
        global $db;
        $ip_address = $_SESSION['customers_ip_address'] . ' - ' . getCustomersIP();
        $time = date('Y-m-d h:i;s', strtotime('-5 day'));
        $order_count = $db->getAll("SELECT COUNT(orders_id) FROM " . TABLE_ORDERS . " WHERE ip_address ='" . $ip_address . "' and date_purchased >'" . $time . "' and main_order_id in(0,1)");
        if ($order_count[0]['COUNT(orders_id)'] >= 2) {
            return 5;
        } else {
            return false;
        }
    }

    /**
     * 判断客户是否首5天内多次下单
     * @return bool
     */
    function many_times_order_user()
    {
        global $db;
        if (empty($_SESSION['customer_id'])) {
            return false;
        }
        $customerId = $_SESSION['customer_id'];
        $time = date('Y-m-d h:i;s', strtotime('-5 day'));
        $order_count = $db->getAll("SELECT COUNT(orders_id) FROM " . TABLE_ORDERS . " WHERE customers_id =" . $customerId . " and date_purchased >'" . $time . "' and main_order_id in(0,1)");
        if ((int)$order_count[0]['COUNT(orders_id)'] >= 2) {
            return 9;
        } else {
            return false;
        }


    }

    /**
     * 判断所有订单产品中是否有重货类
     */
    function is_buck_in_all_products()
    {
        $local_products = $this->local_cart_products ? array_column($this->local_cart_products,'id') : [];
        $delay_products =  $this->delay_cart_products ? array_column($this->delay_cart_products,'id'): [];
        $global_products = $this->global_cart_products ? array_column($this->global_cart_products,'id') : [];
        $product_combine = array_merge((array)$local_products,(array)$delay_products);
        if(in_array($this->local_warehouse,array(3,40)) && !empty($global_products)){
            $product_combine = array_merge($product_combine,$global_products);
        }

        foreach ($delay_products as $delay_product_id) {
            if (in_array((int)$delay_product_id, $this->spec_heavy_arr)) {
                $this->special_heavy = true;
                break;
            }
        }

        if ($this->special_heavy) {
            $heavy_products_local = get_heavy_products($local_products, $this->local_warehouse);
            $heavy_products_delay = get_heavy_products($delay_products, $this->global_warehouse);
            $this->heavy_products = array_merge($heavy_products_delay['heavy_products'], $heavy_products_local['heavy_products']);
            $this->heavy_products_tag = array_merge($heavy_products_delay['heavy_products_tag'], $heavy_products_local['heavy_products_tag']);
            if ($heavy_products_local['is_heavy_free']) {
                $this->is_heavy_free = $heavy_products_local['is_heavy_free'];
            }
        } else {
            $heavy_products_l = get_heavy_products($product_combine, $this->local_warehouse);
            $heavy_products_d = get_heavy_products($product_combine, $this->global_warehouse);

            $this->heavy_products = array_merge($heavy_products_l['heavy_products'], $heavy_products_d['heavy_products']);
            $this->heavy_products_tag = $heavy_products_d['heavy_products_tag'];
            $this->is_heavy_free = $heavy_products_l['is_heavy_free'];

            $heavy_products_local = get_heavy_products($local_products, $this->local_warehouse);
            $this->local_heavy_products = $heavy_products_local['heavy_products'];
        }
        $this->heavy_products = array_unique($this->heavy_products);
        //这里去重会导致一个订单里面只有一个重货标识
//        $this->heavy_products_tag = array_unique($this->heavy_products_tag);
        $status = $this->heavy_products ? true : false;
        return $status;
    }

    /**
     * 密送trustpilot
     */
    function is_bcc_to_trustpilot($order_id, $cost_value, $complete_mail = false)
    {
        global $db;
        if (!$_SESSION['customer_id']) return false;

        //只针对pending邮件
        if ($complete_mail == true) return false;

        //如果是fs.com,feisu.com的域名则不密送trustpilot
        $is_reissue = fs_get_data_from_db_fields('is_reissue', 'orders', 'orders_id=' . $order_id, 'limit 1');
        $company_domain = trim(explode('@', $this->customer['email_address'])[1]);
        if (in_array($company_domain, ['fs.com', 'feisu.com'])) return false;

        //3个月内有2个以上订单的为忠诚客户
        $sql = 'SELECT count(*) as count FROM orders WHERE orders_status = 4 and now()>DATE_SUB(CURDATE(), INTERVAL 3 MONTH) and customers_id = ' . (int)$_SESSION['customer_id'] . ' and (main_order_id = 1 or main_order_id = 0)';
        $count_order = $db->getAll($sql);
        $count_order = $count_order[0]['count'];
        if ($count_order < 2) return false;

        //是否订阅
        $is_subscribe = fs_get_data_from_db_fields('customers_newsletter', 'customers', 'customers_id=' . (int)$_SESSION['customer_id'], 'limit 1');
        if ($is_subscribe) {
            //如果是美国订单，金额大于500发送
            if (in_array($is_reissue, [1, 2, 3, 12, 13, 14])) {
                if ($cost_value['ot_total'] > 500) return true;
                //如果是德国订单，金额大于200发送
            } elseif (in_array($is_reissue, [6, 7, 8])) {
                if ($cost_value['ot_total'] * $this->info['currency_value'] > 200) return true;
            }
        }
        return false;
    }

    /**
     * 更新俄罗斯对公支付账户信息
     */
    function update_alfa_info($orders_id)
    {
        $alfa_data = array();
        if (!empty($_SESSION['alfa_info']) && $this->info['payment_module_code'] == "alfa" && $orders_id) {
            $service = new \App\Services\Payments\RuPaymentServices();
            $service->setInformationAddress();
            if (!empty($_SESSION['alfa_info'])) {
                $data = $service->firstData($_SESSION['alfa_info']);
            } else {
                $data = $service->lastPaymentInformation();
            }

            $alfa_data = $service->insertData($data);
            if (empty($alfa_data)) {
                $alfa_data = $_SESSION['alfa_info'];
                unset($alfa_data['ru_mgb_pro_id']);
                if (isset($alfa_data['primaryKeyId'])) {
                    unset($alfa_data['primaryKeyId']);
                }
            }
            $alfa_data['orders_id'] = $orders_id;
            zen_db_perform('orders_alfa_account', $alfa_data);
        }
    }

    /**
     * 给产品添加重货标记
     * add by rebirth   2019/05/09
     *
     * @param $products
     */
    function add_heavy_tag(&$products, $type = '')
    {

        if (!is_array($products) || !count($products)) {
            return;
        }

        foreach ($products as &$product) {
            if (isset($this->heavy_products_tag[(int)$product['id']])) {
                //特殊重货产品有库存时，显示为标准产品且免运费
                if ($type == 'local' && in_array((int)$product['id'], $this->spec_heavy_arr)) {
                    $product['heavy_tag'] = 0;
                } else {
                    $product['heavy_tag'] = $this->heavy_products_tag[(int)$product['id']];
                }
            } else {
                $product['heavy_tag'] = 0;
            }

            //是否是有库存计划产品
            $productData = self::is_lithium_battery_product((int)$product['id']);
            $product['is_lithium_battery'] = $productData[0][0];
            $product['is_stock_plan'] = $productData[0][1];
            if ($product['is_lithium_battery'] == 1) {
                $this->is_lithium_battery_order[] = (int)$product['id'];
            }
        }
        //锂电池判断
        $this->is_lithium_battery_order = array_unique($this->is_lithium_battery_order);
    }

    function is_lithium_battery_product($product_id)
    {
        $res = fs_get_data_from_db_fields_array(array('is_lithium_battery', 'in_cn'), 'products', 'products_id =' . $product_id);
        return $res;
    }

    /**
     * add by quest 2019-04-09
     * 判断所有订单产品中是否有特殊机柜
     */
    function is_cabinet_in_order()
    {
        if ($this->local_warehouse == 40) {//美国仓本地有库存才有对机柜的处理
            $state = $this->delivery['state'];
            $country_id = $this->delivery['country_id'];
            $state = $state ?: 'Washington';
            foreach ($this->local_info['products_arr'] as $local_products_id) {
                if (in_array($local_products_id, array(75869, 70973, 73579, 73958, 73984))) {
                    $states_code_price = fs_get_data_from_db_fields('price', 'shipping_ups_ltl', 'products_id = ' . $local_products_id . ' AND country_id ="' . $country_id . '" AND (state = "' . $state . '" OR state_abb = "' . $state . '")');

                    if (!empty($states_code_price)) {
                        $this->local_cabinet[$local_products_id] = array('products_id' => $local_products_id, 'shipping_price' => $states_code_price);
                    }
                }
            }
        }
    }

    /**
     * 获取当前总订单价格信息
     *
     * @return array
     * @author  aron
     * @date 2019.6.16
     */
    public function getCurrentOrderInfo($type = 'all')
    {
        global $currencies;
        $total_info = $this->createTotal($type);
        $shipping = 0;
        $tax = 0;
        $total = 0;
        $insurance = 0;
        foreach ($total_info as $k) {
            if ($k['code'] == 'ot_shipping') {
                $shipping = $currencies->fs_format_new($k['value'], true, $this->info['currency'], $this->info['currency_value']);
            }
            if ($k['code'] == 'ot_tax') {
                $tax = $currencies->fs_format_new($k['value'], true, $this->info['currency'], $this->info['currency_value']);
            }
            if ($k['code'] == 'ot_total') {
                $total = $currencies->fs_format_new($k['value'], true, $this->info['currency'], $this->info['currency_value']);
            }
            if ($k['code'] == 'ot_subtotal') {
                $subtotal = $currencies->fs_format_new($k['value'], true, $this->info['currency'], $this->info['currency_value']);
            }
            if ($k['code'] == 'ot_insurance') {
                $insurance = $currencies->fs_format_new($k['value'], true, $this->info['currency'], $this->info['currency_value']);
            }
        }
        $info = [
            'total' => $total,
            'shipping' => $shipping,
            'subtotal' => $subtotal,
            'vat' => $tax,
            'insurance' => $insurance
        ];
        return $info;
    }

    /**
     * 获取当前总订单税后价格信息
     *
     * @author  aron
     * @date 2019.6.16
     * @return array
     */
    public function getAfterTaxCurrentOrderInfo()
    {
        global $currencies;
        $aftertax_shipping = $currencies->fs_format_new($this->info['aftertax_shipping_cost'],
            true, $this->info['currency'], $this->info['currency_value']);
        $aftertax_subtotal = $currencies->fs_format_new($this->info['aftertax_subtotal'],
            true, $this->info['currency'], $this->info['currency_value']);
        $info =  [
            'aftertax_shipping' => $aftertax_shipping,
            'aftertax_subtotal' => $aftertax_subtotal,
        ];
        return $info;
    }


    /**
     * ery 2019.7.17 邮件中产品图片板块和标题公共板块展示
     * @param $product
     * @param $is_reissue
     * @return array
     */
    public function create_product_html($product, $is_reissue)
    {
        $data = [];
        if (!empty($product)) {
            $product_category_status = get_product_category_status((int)$product['id']);
            if ($product_category_status == 1) {
                $image_stock = '<img src="https://img-en.fs.com/includes/templates/fiberstore/images/logo_trad.jpg" width="60" height="60">';
            } else {
                $image_stock = get_resources_img($product['id'], 60, 60, '', '', '', ' style="" ');
            }

            //展示产品属性
            $attrHtml = '';
            if (isset($product['attribute']) && sizeof($product['attribute'])) {
                foreach ($product['attribute'] as $xx => $attr) {
                    if ($attr['value'] != 'length') {
                        if ($attr['price'] > 0) {
                            $attr_price = $attr['price'];
                            $attr_prefix = $attr['prefix'];
                        } else {
                            $attr_price = '0';
                            $attr_prefix = '';
                        }
                        if (!preg_match('/option/i', $attr['value'])) {
                            $attrHtml .= '<div style="font-size:12px;">' . ($attr['option']) . ': ' . ($attr['value']) . '&nbsp;&nbsp;</div>';
                        }
                    } else {
                        $attrHtml .= '<div style="font-size:12px;">' . FS_ORDER_EMAIL_68 . ': ' . ($attr['option']) . ' </div>';
                    }
                }

            }
            $product_href = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['id']);
            if (in_array($is_reissue, [22, 23])) {
                //赠品单产品不给A链接
                $image_html = $image_stock;
                $title_html = FS_GIFT_TITLE_FREE_EMAIL . '<span style="color: #232323;text-decoration: none;font-size: 14px;line-height: 22px;font-family: Open Sans,arial,sans-serif;margin-bottom: 5px;display: inline-block">
                                    ' . $product['products_name'] . '
                                            <span style="color: #999;font-family: Open Sans,arial,sans-serif;">#' . $product['id'] . '</span>
                                            <div style="padding:5px 0 0 0;color: #616265;">' . $attrHtml . '</div>
                                        </span>';
            } else {
                $image_html = '<a style="text-decoration: none" href="' . $product_href . '">' . $image_stock . '</a>';
                $title_html = '<a style="color: #232323;text-decoration: none;font-size: 14px;line-height: 22px;font-family: Open Sans,arial,sans-serif;margin-bottom: 5px;display: inline-block" href="' . $product_href . '">
                                            ' . $product['products_name'] . '
                                            <span style="color: #999;font-family: Open Sans,arial,sans-serif;">#' . $product['id'] . '</span>
                                            <div style="padding:5px 0 0 0;color: #616265;">' . $attrHtml . '</div>
                                        </a>';
            }
            $data['image_html'] = $image_html;
            $data['title_html'] = $title_html;
        }
        return $data;
    }

    /**
     *
     * add by rebirth
     * 2019/08/14
     * @param $id int  主单id
     * @param $timeCanPay int  支付有效时间/秒
     */
    public function insert_ns_orders($orders_id)
    {
        $data = [
            'orders_id' => $orders_id,
            'addtime' => time(),
            'num' => 0,
        ];
        zen_db_perform('customer_ns_transfer_queue', $data);
    }

    /**
     *
     * add by helun
     * 2020/07/09
     * @param string $customers_number_new 销售编号
     */
    public function update_tax_sale($customers_number_new)
    {
        global $db;
        if ($customers_number_new) {
            $db->Execute('DELETE FROM customer_tax_sale WHERE sale_number_new = "' . $customers_number_new . '"');
        }
    }

    /**
     * add by rebirth  2020.04.08
     *
     * TT支付(即银行转账) 下单时触发的pending邮件
     *
     * @param $mainOrderId
     */
    public function sendTTOrderPendingEmail($mainOrderId)
    {
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/manage_orders.php'); // 订单语言包  解决语言包缺失问题
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/my_dashboard.php');
        $html_msg = [];

        //3.产品获取
        $son_order = zen_get_all_son_order_id($mainOrderId);
        $orderNum = count($son_order);
        if (!$orderNum) {
            $son_order[] = $mainOrderId;
            $orderNum = 1;
        }
        $html = '';
        $orderKey = 0;
        $is_customer = $this->customer['id'];
        $orderNumber = [];
        $orderNumberLink = [];
        //是否为德国仓发货
        $isReissueDe = false;
        foreach ($son_order as $key => $id) {
            $orderKey++;
            $fields = array('orders_number', 'currency', 'currency_value', 'shipping_method', 'is_reissue', 'customers_po');
            $orderData = fs_get_data_from_db_fields_array($fields, 'orders', 'orders_id=' . $id, 'limit 1');

            //判断发货仓是否德国
            if (in_array($orderData[0][4], [6 ,8 ,20])) {
                $isReissueDe = true;
            }

            $orderFraction = $orderKey . '/' . $orderNum;
            $orderNumHref = ($is_customer) ? zen_href_link('account_history_info', 'orders_id=' . $id, 'SSL') : 'javascript:;';
            $orderNumber[] = $orderData[0][0];
            $orderNumberLink[] = '<a style="color: #0070BC;text-decoration: none" href="' . zen_href_link('account_history_info', 'orders_id=' . $id, 'SSL') . '">' . $orderData[0][0] . '</a>';
            if ($orderNum > 1) {
                $html .=
                    '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                ' . FS_ORDER_EMAIL_14 . ' ' . $orderFraction . ' <a style="color: #0070BC;text-decoration: none" href="' . $orderNumHref . '">' . FS_ORDER_EMAIL_10 . '#' . $orderData[0][0] . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
                if ($orderData[0][5]) {
                    $html .= $this->email_text_spacing(10);
                    $html .=
                        '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px" align="center">
                                    ' . FS_SEND_EMAIL_71 . '<a style="text-decoration: none;color: #232323" href="javascript:;">' . $orderData[0][5] . '</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                }
                $html .= $this->email_text_spacing(30);
            }
            $products = zen_get_products_by_order_id($id, $orderData[0][1]);
            $products_count = count($products);
            foreach ($products as $kk => $product) {
                $product_border = ($kk == $products_count - 1) ? 'border-bottom: 1px solid #f7f7f7;' : '';
                if ($orderKey == $orderNum) {
                    $product_border = '';
                }
                //获取订单产品图片和标题HTML
                $productHtml = $this->create_product_html($product, $orderData[0][4]);
                $image_html = $productHtml['image_html'];
                $title_html = $productHtml['title_html'];
                $html .=
                    '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px;border-top: 1px solid #f7f7f7;' . $product_border . '">';

                $html .=
                    '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>
                        
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td width="60" valign="middle" style="border-collapse: collapse;">
                                ' . $image_html . '
                            </td>
                            <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #232323;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                                ' . $title_html . '
                                <br>
                                ' . FS_SEND_EMAIL_8 . $product['qty'] . '
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#ffffff" border-collapse: "collapse" height="30">
        
                            </td>
                        </tr>
                        </tbody>
                    </table>';

                $html .= '</td></tr></tbody></table>';
            }
            if ($orderKey < $orderNum) {
                $html .= $this->email_text_spacing(30);
            }
        }
        $html_msg['PRODUCT'] = $html;

        //1.公用头部尾部
        $email_warehouse_info = get_email_langpac();
        $html = common_email_header_and_footer(FS_EMAIL_OPTIMIZE_01, FS_ORDER_EMAIL_25, $email_warehouse_info, $isReissueDe);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];

        //2.邮件主体头部以及描述
        $html_msg['EMAIL_TOP_TITLE'] = FS_EMAIL_OPTIMIZE_07;
        $html_msg['EMAIL_TOP_DES'] = FS_EMAIL_OPTIMIZE_08;

        //4,Make Payment 部分
        $html_msg['MAKE_PAYMENT_TITLE'] = FS_EMAIL_OPTIMIZE_01;
        if ($orderNum < 2) {
            $detailsLink = zen_href_link('account_history_info', 'orders_id=' . $mainOrderId, 'SSL');
            $downloadLink = zen_href_link(FILENAME_PRINT_BLANKET_ORDER, '&orders_id=' . $mainOrderId, 'SSL');
        } else {
            //多单均跳转到列表页带搜索
            $detailsLink = $downloadLink = zen_href_link(FILENAME_MANAGE_ORDERS, 'search=' . ($this->info['orders_number']), 'SSL');
        }
        if ($_SESSION['languages_code'] == 'de') {
            $downloadDes = 'Rechnung';
        } else {
            $downloadDes = FS_DOWNLOAD;
        }
        $html_msg['MAKE_PAYMENT_DOWNLOAD'] = '<a href="' . $downloadLink . '" target="_blank">' . $downloadDes . '</a>';
        $html_msg['MAKE_PAYMENT_ORDER_NUMBER_DES'] = FS_CANCEL_ORDER_6;
        $html_msg['MAKE_PAYMENT_TOTAL_DES'] = ACCOUNT_OF_TOTAL;
        $costData = zen_get_order_cost_by_order($mainOrderId, true);
        //小计
        $html_msg['SUBTOTAL'] = FS_ORDER_EMAIL_36.' '.$costData['ot_subtotal']['text'];
        //总计
        $html_msg['MAKE_PAYMENT_TOTAL'] = $costData['ot_total']['text'];
        //运费
        $shipping_charge = $this->info['shipping_text'];

        $is_au_gsp = $this->info['delivery_country_id'] == 13 ? true : false;
        //如果收货地址为澳大利亚  展示税后价
        if($is_au_gsp){
            $tax_data = zen_get_order_au_tax_order($mainOrderId);
            if($tax_data){
                $html_msg['SUBTOTAL'] = FS_ORDER_EMAIL_36.' '.$tax_data['tax_subtotal']['text'];
                $html_msg['MAKE_PAYMENT_TOTAL'] = $tax_data['tax_total']['text'];
                $shipping_charge = $tax_data['tax_shipping']['text'];
            }
        }
        $html_msg['SHIPPING_CHARGE'] = FS_ORDER_EMAIL_37.' '.$shipping_charge;
        //税（判断是否显示）
        $vat_html = '';
        if ($costData['ot_tax']) {
            if ($is_au_gsp) {
                $vat_html = FS_BLANKET_33 .' '.$costData['ot_tax']['text'];
            } elseif (strtolower($this->delivery["country"]) == 'monaco') {     // 2019-7-11 potato 添加摩纳哥的税率
                $vat_html = EMAIL_CHECKOUT_COMMON_VAT_COST_FR. ' '.$costData['ot_tax']['text'];
            } else {
                $vat_html = EMAIL_CHECKOUT_COMMON_VAT_COST .' '.$costData['ot_tax']['text'];
            }
        }
        $html_msg['VAT_TEXT'] = $vat_html;

        $html_msg['MAKE_PAYMENT_ORDER_NUMBER'] = implode(FS_EMAIL_PAUSE . ' ', $orderNumber);
        $html_msg['MAKE_PAYMENT_ORDER_DETAILS'] = '<a href="' . $detailsLink . '"  style="font-family: Open Sans,arial,sans-serif;font-size: 13px;color: #0070bc;line-height: 24px;text-decoration: none;" target="_blank">' . MANAGE_ORDER_DETAILS . '</a>';
        $html_msg['MAKE_PAYMENT_INSTRUCTION_TITLE'] = FS_EMAIL_OPTIMIZE_09;
//        $FSEmail = get_mail_site_and_country();

        $FSEmail = 'finance@feisu.com';
        $infoHtml = '';
        //5.bank 信息部分
        $code = strtoupper($this->delivery['countries_iso_code_2']);
        if (in_array($code, array('US', 'PR', 'MX', 'CA'))) {
            $FSEmail = 'finance@fs.com';
            $html_msg['MAKE_PAYMENT_BANK_TITLE'] = PAYMENT_BANK_OF_US;
            $infoHtml .= getTTAccounthtml($code);
        } else {
            $html_msg['MAKE_PAYMENT_BANK_TITLE'] = getTTAccountTitle($code);
            $TTAccountInfo = getTTAccountInfo($code, $this->info['currency']);

            $infoLen = count($TTAccountInfo);
            $index = 0;
            $high = 5;
            foreach ($TTAccountInfo as $item => $value) {
                $index++;
                if ($index >= $infoLen) {
                    $high = 20;
                }
                $infoHtml .= '<tr>
                            <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 24px;padding-right: 20px;" align="right">
                                ' . $item . '
                            </td>
                            <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #616265;font-family: Open Sans,arial,sans-serif;line-height: 24px;">
                                ' . $value . '
                            </td>
                        </tr>
                        <tr>
                            <td style="border-collapse: collapse;" height="' . $high . '">
                                
                            </td>
                        </tr>';
            }
        }

        $html_msg['MAKE_PAYMENT_INSTRUCTION_DES'] = str_replace('$FS_EMAIL', '<a href="mailto:' . $FSEmail . '" style="color: #0070bc;text-decoration: none;">' . $FSEmail . '</a>', FS_EMAIL_OPTIMIZE_10);
        $html_msg['MAKE_PAYMENT_BANK_INFO'] = $infoHtml;
        $html_msg['MAKE_PAYMENT_BANK_DES'] = str_replace('$ORDER_NUMBER', implode(FS_EMAIL_PAUSE . ' ', $orderNumberLink), FS_EMAIL_OPTIMIZE_11);

        //6.邮件主体信息底部
        $html_msg['POLICY_TITLE'] = FS_EMAIL_OPTIMIZE_12;
        $html_msg['POLICY_DES_01'] = FS_EMAIL_OPTIMIZE_13;
        $html_msg['POLICY_DES_02'] = FS_EMAIL_OPTIMIZE_14;


        $customer_name = ucwords($this->customer['name'] . ($this->customer['lastname'] ? ' ' . $this->customer['lastname'] : ''));

        $poNum = '';
        if ($purchase_order_num) {
            $poNum = '('. FS_ACCOUNT_PO_NUMBER.$purchase_order_num.')';
        } elseif ($customers_po_num) {
            $poNum = '('. FS_ACCOUNT_PO_NUMBER.$customers_po_num.')';
        }

        $email_title = sprintf(FS_ORDER_EMAIL_43, '#' . implode(' & #', $orderNumber) . $poNum);
        sendwebmail($customer_name, $this->customer['email_address'], '订单邮件发送给客户' . $this->customer['email_address'] . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_TT', 81, $this->attachArray, $mainOrderId);

        if ($_SESSION['customer_id']) {
            $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
        }
        if (!$admin_id) {
            //根据订单分配对应销售获取admin_id
            $admin_id = zen_get_customer_order_has_admin_id($mainOrderId);
        }
        if ($admin_id) {
            $admin_data = fs_get_data_from_db_fields_array(['admin_name', 'admin_email'], 'admin', 'admin_id=' . $admin_id, 'limit 1');
            $admin_name = $admin_data[0][0];
            $admin_email = $admin_data[0][1];
            sendwebmail($admin_name, $admin_email, '订单邮件发送给销售' . $admin_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_TT', 81, $this->attachArray, $mainOrderId);
        }
        //如果是de-en 发送密送邮件到trustpilot
        //密送邮件开关,如果当月条数满100 直接改 is_send_trustpilot
        if ($_SESSION['languages_code'] == 'dn' && $this->is_send_trustpilot) {
            $bcc_email = 'fs.com+468638a060@invite.trustpilot.com';
            if ($costData['ot_total']['value'] > 540) {
                sendwebmail('Angelina.Li', $bcc_email, '客户下单Trustpilot邮件' . $bcc_email . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_TT', 81, $this->attachArray, $mainOrderId);
                sendwebmail('Angelina.Li', 'Angelina.Li@feisu.com', '客户下单Trustpilot邮件Angelina.Li@feisu.com' . date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg, 'checkout_TT', 81, $this->attachArray, $mainOrderId);
            }
        }
    }

    /**
     * add by rebirth 2020.04.06
     *
     * credit card 和 paypal 邮件里的支付按钮
     * @param $order_count 订单数量  只有purchase需要
     * @return string
     */
    public function ccAndPpEmailPaymentButton($order_count = 1)
    {
        //只有pending单且是指定支付方式(CC&PP&purchase)才能触发
        if (!$this->isInStatusOrder(1) || !$this->isCCAndPPPayment()) {
            return '';
        }
        $code = strtolower($this->info['payment_module_code']);
        $oid = $this->info['orders_id'];
        $button = FS_EMAIL_OPTIMIZE_01;
        $note = FS_EMAIL_OPTIMIZE_02;
        if ($code == 'payeezy' || $code == 'globalcollect') {
            $inquiry_id = fs_get_data_from_db_fields('id', 'customer_inquiry', ' order_id=' . $oid . ' ');
            $link = zen_href_link(FILENAME_CHECKOUT_GLOBALCOLLECT_BILLING, '', 'SSL') . '&req_qreoid=' . $oid . '&payType=' . $code;
            if ($inquiry_id) {
                $link .= '&inquiry_id=' . $inquiry_id;
            }
        } else if ($code == 'paypal') {
            $link = zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST, 'orders_id=' . $oid, 'SSL');
        } else if ($code == 'purchase') {
            $oNumber = $this->info['orders_number'];
            if ($order_count < 2) {
                $link = zen_href_link('account_history_info', 'orders_id=' . $oid, 'SSL');
            } else {
                $link = zen_href_link(FILENAME_MANAGE_ORDERS, 'search=' . $oNumber, 'SSL');
            }
            $button = FS_CHECKOUT_PAYMENT_PO;
            $note = FS_EMAIL_OPTIMIZE_06;
        } else {
            // 非信用卡和paypal不展示make payment 按钮
            return '';
        }
        $html = $this->email_text_spacing(25);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="center">
                                <a style="font-size: 14px;display: inline-block;text-decoration: none;color: #fff;padding: 5px 12px;border: 1px solid #0681d3;border-radius:2px;background-color: #007FC2;" href="' . $link . '" target="_blank">' . $button . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        $html .= $this->email_text_spacing(25);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                ' . $note . '
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        return $html;
    }

    /**
     * add by rebirth 2020.04.07
     *
     * credit cart 和 PayPal 的支付成功邮件的新头部
     * 以及po上传
     *
     * @param $order_number string  订单编号
     * @param $order_count string   订单数量
     * @return string
     */
    public function ccAndPpPayedNewTop($order_number, $order_count)
    {
        //只有已经付款的且是指定支付方式(CC&PP)才能触发   !$this->isInStatusOrder(2) ||
        if (!$this->isCCAndPPPayment()) {
            return '';
        }
        $oid = $this->info['orders_id'];
        $oNumber = $this->info['orders_number'];
        if ($order_count < 2) {
            $link = zen_href_link('account_history_info', 'orders_id=' . $oid, 'SSL');
        } else {
            $link = zen_href_link(FILENAME_MANAGE_ORDERS, 'search=' . $oNumber, 'SSL');
        }
        $html = $this->email_text_spacing(50);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse" align="center">
                                <span style="font-size:26px;color:#232323;line-height: 26px;display: inline-block;vertical-align: middle;">' . FS_EMAIL_OPTIMIZE_03 . '</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        $html .= $this->email_text_spacing(50);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                ' . str_replace('#ORDER_NUMBER', $order_number, FS_EMAIL_OPTIMIZE_04) . '
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        $html .= $this->email_text_spacing(25);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="center">
                                <a style="font-size: 14px;display: inline-block;text-decoration: none;color: #fff;padding: 5px 12px;border: 1px solid #0681d3;border-radius:2px;background-color: #007FC2;" href="' . $link . '" target="_blank">' . FS_EMAIL_OPTIMIZE_05 . '</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        $html .= $this->email_text_spacing(25);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                                <img style="display: inline-block;max-width: 100%" src="https://img-en.fs.com/includes/templates/fiberstore/images/email/email-line.png">
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        $html .= $this->email_text_spacing(15);
        $html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="center">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                        <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                            ' . FS_ORDER_EMAIL_15 . '
                                        </td>
                                        <td width="50%" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                            ' . FS_ORDER_SHIPPED . '
                                        </td>
                                        <td width="25%" style="border-collapse: collapse;font-size: 14px;color: #232323;font-family: Open Sans,arial,sans-serif;line-height: 22px;" align="center">
                                            ' . GLOBAL_EXPECTED_DELIVERY . '
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        $html .= $this->email_text_spacing(25);
        return $html;
    }

    /**
     * add by rebirth  2020.04.07
     *
     * @return bool
     *
     * 检测是否是PayPal或者Credit Cart 或者 purchase 支付方式  true代表符合
     */
    public function isCCAndPPPayment()
    {
        return in_array(strtolower($this->info['payment_module_code']), ['payeezy', 'globalcollect', 'paypal', 'purchase']);
    }

    /**
     * add by rebirth  2020.04.07
     *
     * 检测是否是指定状态单  true代表符合
     *
     * @param $status
     * @return bool
     */
    public function isInStatusOrder($status)
    {
        return !(abs(strcmp((string)$this->info['orders_status_id'], $status)));
    }


    /**
     * 记录下单时初始的账单地址信息
     *
     * @param $oid
     */
    public function insert_billing_address_init_date($oid)
    {
        if (!empty($oid)) {
            (new \App\Models\OrdersFirstBillingData())->insert(
                [
                    'orders_id' => $oid,  //只记录主单id
                    'country_id' => (!empty($this->billing['country_id'])) ? $this->billing['country_id'] : 0,
                    'delivery_country_id' => (!empty($this->delivery['country_id'])) ? $this->delivery['country_id'] : 0,
                    'company_type' => (!empty($this->billing['company_type'])) ? $this->billing['company_type'] : '',
                    'vax_number' => (!empty($this->billing['tax_number'])) ? $this->billing['tax_number'] : '',
                ]
            );
        }
    }

    /**
     * 批判断英文站港澳台国家地址栏是否包含中文字符判断
     *
     * @param $country_id ,$address
     * @return bool
     */
    public function chineseAddressDetermination($country_id, $address)
    {
        if (is_numeric($country_id) && !empty($address)) {
            if (in_array($country_id, array(96, 125, 206))) {
                if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $address)) {
                    //包含汉字
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Notes: 针对新加坡的处理
     * User: LiYi
     * Date: 2020/6/30 0030
     * Time: 10:33
     * @param $orderId
     * @return bool
     */
    public function createSgTicketNumber($orderId)
    {
        $server = new \App\Services\Orders\OrderMiddleField();
        $res = false;
        try {
            $temp = $_SESSION['delivery_array'];
            if (!empty($temp)) {
                $data = [
                    'orders_id' => $orderId,
                    'delivery_ticket_number' => $temp,
                ];

                $server->create($data);
                if (isset($_SESSION['delivery_array'])) {
                    unset($_SESSION['delivery_array']);
                }
                $res = true;
            }
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }

    /**
     * Notes: 自提和Use my own快递��式运费表达
     * User: Jeremy
     * Date: 2020/7/16
     * @param $local_shipping_method
     * @param $delay_shipping_method
     * @return bool
     */
    function handleFreeShippingPrice($local_shipping_method = '', $delay_shipping_method = '')
    {
        $is_show_free = true;
        $free_shipping_method = array('customzones', 'selfreferencezones');
        if ($local_shipping_method == '' && $delay_shipping_method == '') {
            $local_shipping_method = $_SESSION['shipping_local']['id'];
            $delay_shipping_method = $_SESSION['shipping_delay']['id'];
            $free_shipping_method = array('customzones_customzones', 'selfreferencezones_selfreferencezones');
        }
        $order_num_info = $this->get_order_num();
        $order_type = $order_num_info['data'];
        if (in_array($order_type,['local','local-delay']) && in_array($local_shipping_method, $free_shipping_method)) {
            $is_show_free = false;
        }
        if (in_array($order_type,['delay','local-delay']) && in_array($delay_shipping_method, $free_shipping_method)) {
            $is_show_free = false;
        }
        return $is_show_free;
    }


    /**
     * Notes: 判断当前产品中是否有超尺寸产品
     *
     * @User: Aron
     * @Date: 2020/7/15
     * @param array $productsInfo
     * @return bool
     */
    public function isOverSize($productsInfo = [])
    {
        $overSizeProduct = [76880, 76880, 97949, 73579, 73958, 73984, 75869, 74126, 76887, 70855, 70856, 96682];
        $return = false;
        if (!empty($productsInfo)) {
            foreach ($productsInfo as $v) {
                if (in_array((int)$v['id'], $overSizeProduct)) {
                    $return = true;
                    break;
                }
            }
        }
        return $return;
    }

    /**
     * $Notes: 获取中国大陆限制产品
     *
     * $author: Quest
     * $Date: 2021/3/16
     * $Time: 15:46
     * @param $country_code
     * @param array $products
     */
    public function getChinaLimitProducts($country_code, $products = [])
    {
        $limit_products = [
            101488, 101484, 101483, 101476, 101472, 101468, 101464, 101460, 101456, 35348, 35610, 100957,
            100957, 93418, 93419, 93420, 93421, 32827, 32623, 32751, 70104, 35990, 70105, 36017, 36019, 69131, 36024,
            69132, 69133, 36026, 36030, 69136, 36021, 69137, 69138, 36022, 36023, 36032, 36031, 36033, 36038, 36040,
            36039, 36034, 36035, 36036, 72299, 72298, 72300, 72302, 72301, 72303, 69121, 69119, 72297, 69126, 69125,
            69127, 69128, 69129, 36000, 69363, 36001, 36003, 36013, 69141, 69142, 69143, 36016, 62312, 36005, 69145,
            69146, 69147, 69148, 36009, 36012, 36041, 36027, 36042, 35986, 35985, 69197, 120419, 75874, 93486, 93487,
            120420, 109920, 109921, 109922, 120421, 109929, 109930, 109931, 96982, 80365, 83325, 90132, 90130,
            103011, 90131, 84912, 72944, 72945, 69404, 69378, 73467, 108718, 115386, 115387, 115383, 110478,
            110479, 110481, 115382, 108712, 108714, 115384, 115388, 108710, 115385, 108716, 110480, 90923, 74158,
            74157, 74156, 74155, 74154, 84026, 84027, 84028, 108704, 108706, 72941, 71172, 65989, 65988, 65994,
            70395, 72834, 72835, 72836, 72833, 72773, 84029, 108708, 90593, 117728, 117729, 90594, 117730, 117731,
            97356, 117732, 117733
        ];

        foreach ($products as $p_val) {
            $pid = $p_val['id'];
            if (in_array($pid, $limit_products)) {
                $this->cn_limit_products[] = $pid;
            }
        }

        if(!empty($this->cn_limit_products) && $country_code == 'CN'){
            setcookie('cn_limit_products', json_encode($this->cn_limit_products), time() + 60 * 30, '/');
        }
    }

}
