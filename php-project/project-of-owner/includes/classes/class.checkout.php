<?php
/**
 * Created by Aron 小哥哥
 * User: yaowei
 * Date: 2018/11/30
 * Time: 下午9:35
 */
use App\Services\Avatax\AvaTaxService;

use App\Services\Common\Upload\UploadService;
use Upload\Storage\FileSystem;


use App\Services\HelpCustomerPlaceOrder\HelpCustomerPlaceOrderService;

require_once DIR_WS_CLASSES . 'customer_account_info.php';
require_once DIR_WS_CLASSES . 'shipping.php';
require_once(DIR_WS_CLASSES . 'order.php');
require_once(DIR_WS_CLASSES . 'FSCompositeProductsClass.php');

class Checkout
{
    private static $_instance = null;
    private static $class_prefix = "aron_carr_barry";
    public static $address = "";
    private static $customer_info = "";
    private static $options = [
        "validate_format" => "php",
        "main_page" => "checkout",
        "state_format" => "php"
    ];

    private function __construct($options = [])
    {
        if (!empty($options)) {
            self::$options = array_merge(self::$options, $options);
        }
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance($options=[])
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }


    /**
     * 获取地址form表单
     * type 1: add  2: update
     * shipping_type  1: 运输新增 2:billing地址 3.运输更新
     * @param $type
     * @return string
     */
    public static function getAddressForm($type = 1, $shipping_type = 1,$is_show_email = false ,$order = '')
    {
        global $db;
        if($order){
            $billing_state = trim($order->billing['state']);
        }
        $class_prefix = self::$class_prefix;
        $option = "<option value=''>".FS_CHECK_OUT_STATE."</option>";
        $state = self::getState(strtoupper($_SESSION['countries_iso_code']));
        $tpl_prefix = self::getCountriesTelPhonePrefix(strtoupper($_SESSION['countries_iso_code']));

        foreach ($state as $k => $v) {
            if ( in_array($billing_state,[$v['name'],$v['code']])  && $type == 2 && $shipping_type == 2) {
                $option .= '<option value="' . $v['name'] . '" selected>' . $v['name'] . '</option>';
            } else {
                $option .= '<option value="' . $v['name'] . '">' . $v['name'] . '</option>';
            }
        }
        $button_name = FS_SAVE_AND_CONTINUE;
        $po_notice = ' <p class="checkout_Npro_theContxt1 checkout_Npro_mt10">'.FS_POBOX_NOTICE.'</p>';
        $class_for_padding = "checkout_Npro_pad3";
        if ($shipping_type == 1) {
            $shipping_form = "shipping_address";
        } elseif ($shipping_type == 2) {
            $shipping_form = "billing_address";
            //$button_name = FS_COMMON_SAVE;
            $po_notice = '';
            //如果是type是edit 显示默认数据
            if($type == 2){
                $firstname = $order->billing['name'] ? $order->billing['name'] : '';
                $lastname = $order->billing['lastname'] ? $order->billing['lastname'] : '';
                $company_type = $order->billing['company_type'] ? $order->billing['company_type'] :'';
                $company = $order->billing['company'] ? $order->billing['company'] : '';
                $street_address = $order->billing['street_address'] ? $order->billing['street_address'] : '';
                $suburb = $order->billing['suburb'] ? $order->billing['suburb'] : '';
                $city = $order->billing['city'] ? $order->billing['city'] : '';
                $postcode = $order->billing['postcode'] ? $order->billing['postcode'] : '';
                $telephone = $order->billing['telephone'] ? $order->billing['telephone'] : '';
                $orders_id = $order->info['orders_id'] ? $order->info['orders_id'] : '';
                $order_billing_country = $order->billing['country'] ? $order->billing['country'] : '';
                $tax_number = $order->billing['tax_number'] ? $order->billing['tax_number'] : '';
                $hidden_html = '<input type="hidden" id="req_qreoid" name="req_qreoid" value="'.$orders_id. '" />';
                //$field_name = zen_get_countries_fields();
                $billing_country_id = '';
                if($order_billing_country){
                    $result = $db->Execute("SELECT countries_id FROM countries WHERE countries_name = '".$order_billing_country."' LIMIT 1");
                    $billing_country_id = $result->fields['countries_id'] ? $result->fields['countries_id'] : '' ;
                }
            }
        } else {
            $class_for_padding = "";
            $shipping_form = "shippingAdd_address";
        }
        if($is_show_email){
            $email_form = '<li class="checkout_Npro_echeckListLi" id="checkout_Npro_email">
                               <p class="checkout_Npro_theContxt3">'.FS_RELATED_EMAIl.'*</p>
                               <input type="text" name="entry_email" class="checkout_Npro_Input entry_email" style="border-color: rgb(221, 221, 221);">
                                <label class="error_prompt"></label>
                          </li>';
        }
        $state_show = !empty($state) ? true : false;
        $bg_html = '<div class="question_bg tax_bubbles"></div>';
        if($billing_country_id==13){
            $bg_html='<div class="question_bg tax_bubbles" style="display:none;"></div>';
        }

        if ($billing_country_id == 188) {
            $sgPlace = FS_CHECKOUT_ERROR_SG_02;
            $sgTitle = FS_ADDRESS2 . '*';
        } else {
            $sgPlace = ADDRESS_PLACE_HODLER2;
            $sgTitle = FS_ADDRESS2;
        }
        $html = '
           <form class="' . $class_prefix . '_' . $shipping_form . '_form">
           <input type="hidden"   class="rebirth_entry_state" value="'.$billing_state.'">
                                <div class="' . $class_for_padding . '  showPad">
                                    <div id="common_checkout">
                                        <ul class="checkout_Npro_echeckList">
                                            <li class="checkout_Npro_echeckListLi firstLi_z">
                                                <p class="checkout_Npro_theContxt3">'.FIBERSTORE_FIRST_NAME.'*</p>
                                                <input type="text" name="entry_firstname" class="checkout_Npro_Input" firstname value="'.$firstname.'">
                                                <label class="error_prompt"></label>
                                            </li>
                                            <li class="checkout_Npro_echeckListLi firstLi_z">
                                                <p class="checkout_Npro_theContxt3">'.FIBERSTORE_LAST_NAME.'*</p>
                                                <input type="text" name="entry_lastname" class="checkout_Npro_Input" lastname value="'.$lastname.'">
                                                <label class="error_prompt"></label>
                                            </li>
                                            <li class="checkout_Npro_echeckListLi">
                                                <p class="checkout_Npro_theContxt3">'.FS_CHECK_COUNTRY_REGION.'*</p>
                                                ' . ( ($shipping_type == 2 && $type == 2) ? zen_draw_countries_pull_for_checkout_common('entry_country_id', array("country_box" => "billingCountry", "entry_country_id" => "entry_country_id"),$billing_country_id,true) : zen_draw_countries_pull_for_checkout_common('entry_country_id', array("country_box" => "billingCountry", "entry_country_id" => "entry_country_id")) ) . '
                                                <label class="error_prompt"></label>
                                            </li>
                                            <li class="checkout_Npro_echeckListLi">
                                                <p class="checkout_Npro_theContxt3 CompanyTypeTitle">'.ADDRESSTYPE.'*</p>
                                                <select  name="AddressType" class="checkout_Npro_select AddressType" onchange="initAddressForm(this,' . $shipping_type . ')">
                                                    <option value="">' . FS_CHECK_OUT_SELECT . '</option>
                                                    <option value=\'BusinessType\' '.($company_type=="BusinessType"? "selected":"").'>' . FS_CHECK_OUT_BUSINESS . '</option>
                                                    <option value=\'IndividualType\' '.($company_type=="IndividualType"? "selected":"").'>' . FS_CHECK_OUT_INDIVIDUAL . '</option>
                                                </select>
                                                <label class="error_prompt"></label>
                                            </li>
                                            <li class="checkout_Npro_echeckListLi aron_helun_star">
                                                <p class="checkout_Npro_theContxt3">'.FS_COMPANT_NAME.'<span class="aron_carr_star" style="display: none">*</span></p>
                                                <input type="text" name="entry_company" class="checkout_Npro_Input Company" value="'.$company.'">
                                                <label class="error_prompt"></label>
                                            </li>
                                             <li class="checkout_Npro_echeckListLi tax_box" style="display: none">
                                                <p class="checkout_Npro_theContxt3 tax_title">VAT ID</p>
                                                <div class="track_orders_wenhao aron_Muggles"> '.$bg_html.' <div class="question_text_01 leftjt"> <div class="arrow"></div><div class="popover-content content_guest_f" style="display:none;">'. FS_TAXT_TITLE_NOTICE_OTHER.'<p></p> </div> </div> </div>
                                                <input type="text" name="tax_number" class="checkout_Npro_Input tax_number" '.(!empty($tax_number) ? 'data-val = "'.$tax_number.'"' : '').'>
                                                <label class="error_prompt"></label>
                                            </li>
                                        </ul>
                                        <div class="checkout_Npro_btnBox">
                                            <div class="checkout_Npro_line"></div>
                                            <ul class="checkout_Npro_echeckList" id="pro_canInsertEmail">
                                                <li class="checkout_Npro_echeckListLi">
                                                    <p class="checkout_Npro_theContxt3 address1Title">'.FS_ADDRESS.'*</p>
                                                    <input type="text" name="entry_street_address" class="checkout_Npro_Input Address_Line1" value="'.$street_address.'" placeholder="'.ADDRESS_PLACE_HODLER.'" onblur="changePlace(this,\'blur\')" onfocus="changePlace(this,\'focus\')">
                                                    <label class="error_prompt"></label>    
                                                </li>
                                                <li class="checkout_Npro_echeckListLi">
                                                    <p class="checkout_Npro_theContxt3 address2Title">'.$sgTitle.'</p>
                                                    <input type="text" name="entry_suburb" class="checkout_Npro_Input Address_Line2" value="'.$suburb.'" placeholder="'.$sgPlace.'" onblur="changePlace(this,\'blur\')" onfocus="changePlace(this,\'focus\')">
                                                    <label class="error_prompt"></label>
                                                </li>
                                                <li class="checkout_Npro_echeckListLi">
                                                    <p class="checkout_Npro_theContxt3 CityTitle">'.FS_CITY.'*</p>
                                                    <input type="text" name="entry_city" class="checkout_Npro_Input City" value="'.$city.'">
                                                    <label class="error_prompt"></label>
                                                </li>
                                                <li class="checkout_Npro_echeckListLi" style="display: '.($state_show ? 'block' : 'none').'">
                                                    <p class="checkout_Npro_theContxt3 StateTitle">'.FS_STATE.'*</p>
                                                    <select name="entry_state" class="checkout_Npro_select shipping_us_state state_select">
                                                        ' . $option . '
                                                    </select>
                                                    <label class="error_prompt"></label>
                                                </li>
                                                <li class="checkout_Npro_echeckListLi '.($state_show ? '' : 'no_margin_left').'">
                                                    <p class="checkout_Npro_theContxt3 Zip_Code">'.FS_ZIP_CODE.'*</p>
                                                    <input type="text" name="entry_postcode" class="checkout_Npro_Input Postal_Code" value="'.$postcode.'" oninput="AutoMatchAddress(this,' . $shipping_type . ')">
                                                    <label class="error_prompt"></label>
                                                </li>
                                                <li class="checkout_Npro_echeckListLi enter_tel_Box">
                                                    <p class="checkout_Npro_theContxt3">'.FS_PHONE_NUMBER.'*</p>
                                                    <b class="checkout_Npro_areaCode checkout_Npro_areaCode_shipping">'.$tpl_prefix.'</b>
                                                    <input type="text" name="entry_telephone" class="checkout_Npro_Input entry_telephone enter_telephone" value="'.$telephone.'">
      
                                                    <label class="error_prompt"></label>
                                                </li>
                                                '. $email_form.'
                                            </ul>
                                        </div>
                                       '.$po_notice.'
                                    </div>
                                    <div class="checkout_Npro_btnBox">
                                        <input type="hidden" class="address_book_id" name="address_book_id" value="">
                                        <button type="button"  class="checkout_Npro_btn1 aron_barry_carr_step_one" onclick="changeAddress(' . $type . ',' . $shipping_type . ',this,0)">' . $button_name . '</button>
                                    </div>
                                </div>'.$hidden_html.'
                            </form>  
                    ';
        return $html;
        /**
         * <li class="checkout_Npro_echeckListLi sg_li_ticket_number_mgb" style="display: none">
        <p class="checkout_Npro_theContxt3 tax_title">'.FS_CHECKOUT_ERROR_SG_03.'</p>
        <div class="track_orders_wenhao aron_Muggles"> <div class="question_bg"></div> <div class="question_text_01 leftjt"> <div class="arrow"></div><div class="popover-content content_guest_f">' . FS_CHECKOUT_ERROR_SG_04 . '<p></p> </div> </div> </div>
        <input type="text" name="ticket_number" class="checkout_Npro_Input ticket_number" ' . (!empty($tax_number) ? 'data-val = "' . $tax_number . '"' : '') . '>
        <label class="error_prompt"></label>
        </li>
         */
    }

    /**
     * 获取运输地址州
     * @param string $country_code
     * @param string $format
     * @return array
     */
    public static function getState($country_code = "US", $format = "php")
    {
        $data = array();
        $format = $format ? $format : self::$options["state_format"];
        switch ($country_code) {
            case "US":
                $states = zen_get_countries_us_states();
                break;
            case "CA":
                $states = zen_get_countries_ca_states();
                break;
            case "MX":
                $states = zen_get_countries_mx_states();
                break;
            case "AU";
                $states = array(
                    array(
                        'states_code' => 'ACT',
                        'states' => 'ACT'
                    ),
                    array(
                        'states_code' => 'NSW',
                        'states' => 'NSW'
                    ),
                    array(
                        'states_code' => 'NT',
                        'states' => "NT"
                    ),
                    array(
                        'states_code' => 'QLD',
                        'states' => 'QLD'
                    ),
                    array(
                        'states_code' => 'SA',
                        'states' => 'SA'
                    ),
                    array(
                        'states_code' => 'TAS',
                        'states' => 'TAS'
                    ),
                    array(
                        'states_code' => 'VIC',
                        'states' => 'VIC'
                    ),
                    array(
                        'states_code' => 'WA',
                        'states' => 'WA'
                    )
                );
                break;
        }
        if (!empty($states)) {
            foreach ($states as $k => $v) {
                $data[$k]['code'] = $v['states_code'];
                $data[$k]['name'] = $v['states'];
            }
        }
        return $data;
    }

    /**
     * 获取所有国家
     * @return array
     */
    public static function getCountries()
    {
        $countries = zen_get_countries();
        return $countries;
    }

    /**
     * 获取不同国家电话号码前缀
     * @param bool $is_json
     * @return array|string
     */
    public static function getTelPhonePrefix($is_json = true)
    {
        $countries = self::getCountries();
        $data = array();
        foreach ($countries as $i => $country) {
            $data[$country['countries_id']] = $country['tel_prefix'];
        }
        if ($is_json) {
            $data = json_encode($data);
        }
        return $data;
    }


    /**
     * 获取某个国家电话号码前缀
     * @param bool $is_json
     * @return array|string
     */
    public static function getCountriesTelPhonePrefix($country_name)
    {
        $countries = self::getCountries();
        $tel_prefix = '+1';
        foreach ($countries as $i => $country) {
            if($country_name == $country['countries_iso_code_2']){
                $tel_prefix = $country['tel_prefix'];
            }
        }
        return $tel_prefix;
    }

    /**
     * 获取结账页面 javascript 语言包
     * @return string
     */
    public static function getLangugePack($is_json = true)
    {
        global $currencies;
        $language_pack = array(
            "related_email" => FS_RELATED_EMAIl,
            "related_name" => FS_RELATED_NAME,
            "currency_left" => $currencies->currencies[$_SESSION['currency']]['symbol_left'],
            "currency_right" => $currencies->currencies[$_SESSION['currency']]['symbol_right'],
            "currency" => $_SESSION['currency'],
            "default" => FS_CHECKOUT_DEFAULT,
            "none_choose_address" => FS_CHECKOUT_ERROR18,
            "none_choose_country" => FS_CHECKOUT_ERROR19,
            "none_choose_phone" => FS_CHECKOUT_ERROR20,
            "none_choose_tax" => FS_CHECKOUT_ERROR21,
            "none_choose_pobox" => FS_CHECKOUT_ERROR16,
            "more" => FIBER_CHECK_MORE,
            "less" => FIBER_CHECK_LESS,
            "fs_account" => FS_CHECK_ACCOUNT,
            "edit" => FS_CHECKOUT_EDIT,
            "fs_js_tit_one" => FS_JS_TIT_CHECK1,
            "fs_js_tit_two" => FS_JS_TIT_CHECK4,
            "fs_js_tit_three" => FS_JS_TIT_CHECK5,
            "fs_js_tit_dylan" => FS_JS_TIT_CHECK_US,
            "time_zone_us" => FS_TIME_ZONE_RULE_US,
            "time_zone_eu" => FS_TIME_ZONE_RULE_EU,
            "pick_info_one" => FS_JS_TIT_CHECK6,
            "pick_info_two" => FS_JS_TIT_CHECK7,
            "pick_info_three" => FS_JS_TIT_CHECK8,
            "pick_info_four" => FS_JS_TIT_CHECK9,
            "error_some" => FS_NETWORK_ERROR,
            "account_error" => FS_CHECKOUT_ERROR22,
            "pick_self_photo" => FS_CHECKOUT_ERROR23,
            "pick_self_phone" => FS_CHECKOUT_ERROR24,
            "pick_self_time" => FS_CHECKOUT_ERROR25,
            "pick_self_email" => FS_CHECKOUT_ERROR26,
            "tax_de_tit" => CHECKOUT_TAXE_DE_TIT,
            "tax_de_tit_front" => CHECKOUT_TAXE_DE_FRONT,
            "tax_de_tit_back" => CHECKOUT_TAXE_DE_BACK,
            "tax_us_tit" => CHECKOUT_TAXE_US_TIT,
            "tax_us_tit_front" => CHECKOUT_TAXE_US_FRONT,
            "tax_us_tit_back" => CHECKOUT_TAXE_US_BACK,
            "tax_cn_tit" => CHECKOUT_TAXE_CN_TIT,
            "tax_cn_tit1" => CHECKOUT_TAXE_CN_TIT1,
            "tax_cn_tit_front1" => CHECKOUT_TAXE_CN_FRONT1,
            "tax_cn_tit_front2" => CHECKOUT_TAXE_CN_FRONT2,
            "tax_cn_tit_front" => CHECKOUT_TAXE_CN_FRONT,
            "tax_clear_cn_tit_front" => CHECKOUT_TAXE_CLEARANCE_CN_FRONT,
            "no_free_tax" => FS_CHECK_OUT_EXCLUDING,
            "no_free_tax1" => FS_CHECK_OUT_EXCLUDING1,
            "no_free_tax_for_ru_nature" => FS_CHECK_OUT_EXCLUDING_RU_NATURE,
            "free_tax" => FS_CHECK_OUT_INCLUDEING,
            "limit_money" => FS_LIMIT_MONEY,
            "limit_money_15000" => FS_LIMIT_MONEY_15000,
            "limit_money_10000" => FS_LIMIT_MONEY_10000,
            "us_shipping_tip" => FS_WAREHOSE_CA_TIP,
            "de_shipping_tip" => FS_WAREHOSE_EU_TIP,
            "tax_title_au" => FS_CHECK_OUT_TAX_AU,
            "tax_title" => FS_CHECK_OUT_TAX,
            "tax_title_ru" => FS_CHECK_OUT_TAX_RU,
            "no_free_tax_au" => FS_CHECK_OUT_EXCLUDING_AU,
            "free_tax_au" => FS_CHECK_OUT_INCLUDING_AU,
            "tax_au_tit" => CHECKOUT_TAXE_AU_TIT,
            "tax_au_content" => CHECKOUT_TAXE_AU_CONTENT,
            "au_shipping_tip" => FREE_SHIPPING_TEXT3,
            "login_expired" => FS_CHECKOUT_EXPIRED,
            "confirm" => FS_CHECKOUT_EXPIRED_CONFIRM,
            "address_new" => FS_ADDRESS_NEW,
            "address_edit" => FS_ADDRESS_EDIT_TITLE,
            "vax_title_de" => FS_CHECK_OUT_TAX_DE,
            "vax_title_sg" => FS_CHECK_OUT_TAX_SG,
            "post_code_none" => FS_CHECKOUT_ERROR27,
            "post_code_invalid" => FS_CHECKOUT_ERROR29,
            "unvalid_country" => FS_CHECKOUT_ERROR35,
            "vat_error" => FS_CHECKOUT_ERROR36,
            "tax_number_none" => FS_CHECKOUT_ERROR37,
            "search" => CHECK_SEARCH,
            "checkout_url" => zen_href_link('checkout'),
            "pick_up_address_us" => FS_TIME_ZONE_ADDRESS_US,
            "pick_up_address_de" => FS_TIME_ZONE_ADDRESS_DE,
            "pick_up_address_us_es" => FS_TIME_ZONE_ADDRESS_US_ES,
            "time_zone_us_es" => FS_TIME_ZONE_RULE_US_ES,
            "time_zone_au" => FS_TIME_ZONE_RULE_AU,
            "time_zone_area_au" => FS_JS_TIT_CHECK_AU,
            "time_zone_sg" => FS_TIME_ZONE_RULE_SG,
            "time_zone_area_sg" => FS_JS_TIT_CHECK_SG,
            "pick_up_address_sg" => FS_TIME_ZONE_ADDRESS_SG,
            "tax_nz_content" => FS_VAT_NUMBER,
            "tax_nz_content" => CHECKOUT_TAX_NZ_CONTENT,
            "pick_up_address_au" => FS_TIME_ZONE_ADDRESS_AU,
            "overnight_title" => FS_OVERNIGHT_TITLE,
            "no_free_heavy_us" => FS_NO_FREE_SHIPPING_US_HEAVY,
            "no_free_heavy_deau" => FS_NO_FREE_SHIPPING_DEAU_HEAVY,
            "no_free_remote_au" => FS_NO_FREE_SHIPPING_AU_REMOTE,
            "us_ca_shipping_tip" => FS_USCA_SHIPPING_TIP,
            "us_mx_shipping_tip" => FS_USMX_SHIPPING_TIP,
            "de_ca_shipping_tip" => FS_DECA_SHIPPING_TIP,
            "de_mx_shipping_tip" => FS_DEMX_SHIPPING_TIP,
            "empty_billing_error" => FS_CHECKOUT_NEW10,
            "vat_title" => FS_VAT_NUMBER,
            "vat_sg_title" => FS_SG_VAT_NUMBER,
            "FS_SHIP_MENT" => FS_SHIP_MENT,
            "FS_SHIP_MENT_OF" => FS_SHIP_MENT_OF,
            "FS_SEE_OPTION" => FS_SEE_OPTION,
            "FS_HIDE_OPTION" => FS_HIDE,
            "regist_one" => FIBERSTORE_ORDER_CONFIRM,
            "check_password_text1" => REGITS_FROM_GUEST_PASSWORD_ERROR1,
            "check_password_text2" => REGITS_FROM_GUEST_PASSWORD_ERROR2,
            "check_password_text3" => REGIST_NUM_LEAST,
            "password_show"=>FS_LOGIN_POPUP8,
            "password_hide"=>FS_LOGIN_POPUP9,
            "system_error" => FS_SYSTME_BUSY,
            "Continue" => FS_CHECKOUT_NEW29,
            "hsbc_bank_au" => PAYMENT_BANK_AU,
            "select_state" => FS_CHECK_OUT_STATE,
            "tax_new_us_content" => CHECKOUT_TAXE_NEW_CN_CONTENT,
            "tax_new_ca_content" => CHECKOUT_TAXE_NEW_CA_CONTENT,
            "tax_new_mx_content" => CHECKOUT_TAXE_NEW_MX_CONTENT,
            "customer_account_warning_one" => CHECKOUT_CUSTOMER_ACCOUNT1,
            "customer_account_warning_two" => CHECKOUT_CUSTOMER_ACCOUNT2,
            "PREORDER_DESPRCTION" => PREORDER_DESPRCTION,
            "FREE_MONEY_NOTICE_PRE1" => FREE_MONEY_NOTICE_PRE1,
            "FREE_MONEY_NOTICE_PRE2" => FREE_MONEY_NOTICE_PRE2,
            "FREE_MONEY_NOTICE_PRE3" => FREE_MONEY_NOTICE_PRE3,
            "BANTRANSFER_AU" => BANTRANSFER_AU,
            "BANTRANSFER_OTHER" => FS_COMMON_CHECKOUT_HSBC,
            "FS_CHECKOUT_SOONER_HIDE"=>ucfirst(FS_HIDE),
            "FS_CHECKOUT_SOONER"=>FIBER_CHECK_MORE,
            "company_title" => ADDRESSTYPE,
            "company_title_ru" => FS_CHECKOUT_ALFA_14,
            "company_type_please" => FS_CHECK_OUT_SELECT,
            "company_type_business" => FS_CHECK_OUT_BUSINESS,
            "company_type_individual" => FS_CHECK_OUT_INDIVIDUAL,
            "company_type_business_ru" => FS_CHECKOUT_ALFA_15,
            "company_type_individual_ru" => FS_CHECKOUT_ALFA_16,
            "tax_ru_font" => CHECKOUT_TAXE_RU_TIT,
            "tax_ru_font_for_natural" => CHECKOUT_TAXE_RU_TIT_FOR_NATURAL,
            'fs_checkout_monday_to_friday' => FS_CHECKOUT_MONDAY_TO_FRIDAY,
            "lengthName" => FS_LENGTH_NAME,
            "FS_ITEM_INCLUDES_PRODUCTS" => FS_ITEM_INCLUDES_PRODUCTS,
            "FS_PRODUCT_PRICE_EA" => FS_PRODUCT_PRICE_EA,
            "gift_title" => FS_GIFT_TITLE_FREE,
            "GLOABL_EDIT_BILLING" => GLOABL_EDIT_BILLING,
            "FS_ADD_BILLING_ADDRESS" => FS_ADD_BILLING_ADDRESS,
            "original_city_title" => FS_CITY,     // 2019-7-18 potato  地址表单原来的city的title
            "city_title" => FS_CITY_AU,       // 2019-7-18 potato  地址表单澳大利亚的city的title
            "original_state_title" => FS_STATE,       // 2019-7-18 potato  地址表单原来的state的title
            "state_title" => FS_STATE_AU,       // 2019-7-18 potato  地址表单澳大利亚的state的title
            "original_zip_code" => FS_ZIP_CODE,       // 2019-7-18 potato  地址表单澳大利亚的zip code的title
            "zip_code" => FS_ZIP_CODE_AU,       // 2019-7-18 potato  地址表单澳大利亚的zip code的title
            "tax_title_new_ru" => FS_CHECK_OUT_TAX_NEW_RU,       // 2019-9-2 potato 俄罗斯Tax改为VAT
            "free_tax_ru" => FS_CHECK_OUT_INCLUDEING_RU,       // 2019-9-2 potato 俄罗斯Tax改为VAT
            "no_free_tax_ru" => FS_CHECK_OUT_EXCLUDING_RU,      // 2019-9-2 potato 俄罗斯Tax改为VAT
            "no_free_tax_ca" => FS_CHECK_OUT_EXCLUDING_CA,
            "original_entry_address1_title" => FS_ADDRESS,
            "original_entry_address2_title" => FS_ADDRESS2,
            "entry_address1_title" => FS_ADDRESS_EU,
            "entry_address2_title" => FS_ADDRESS2_EU,
            "entry_city_title_eu" => ACCOUNT_EDIT_CITY_EU,
            "entry_zip_code_eu" => FS_ZIP_CODE_EU,
            "company_type_error" => CHECKOUT_COMPANY_TYPE,

            "tax_sg_tit"          => CHECKOUT_TAXE_SG_TIT, //2019-09-17 liang.zhu 新加坡的税收提示信息
            "tax_sg_front"        => CHECKOUT_TAXE_SG_FRONT,//2019-09-17 liang.zhu 新加坡的税收提示信息
            "tax_sg_others_tit"   => CHECKOUT_TAXE_SG_OTHERS_TIT,//2019-09-17 liang.zhu 新加坡其余十国的税收提示信息
            "tax_sg_others_front" => CHECKOUT_TAXE_SG_OTHERS_FRONT, //2019-09-17 liang.zhu 新加坡其余十国的税收提示信息
            "FS_SG_CALENDAR_5" => FS_SG_CALENDAR_5, //新加坡安装tag
            'FS_SG_CALENDAR_11' => FS_SG_CALENDAR_11, //新加坡安装分仓提醒
            'FS_CHECKOUT_GSP_4' => FS_CHECKOUT_GSP_4,
            'FS_CHECKOUT_GSP_3' => FS_CHECKOUT_GSP_3,
            'FS_CHECKOUT_GSP_10' => FS_CHECKOUT_GSP_10,
            'FS_CHECKOUT_NEW22' => FS_CHECKOUT_NEW22,
            'FS_CHECKOUT_NEW41' => FS_CHECKOUT_NEW41,
            'FS_COMMON_GSP_2' => FS_COMMON_GSP_2,
            'FS_COMMON_GSP_3' => FS_COMMON_GSP_3,
            'FS_COMMON_GSP_4' => FS_COMMON_GSP_4,
            'FS_CHECKOUT_GSP_2' => FS_CHECKOUT_GSP_2,
            'FS_COMMON_10' => FS_COMMON_10,
            'FS_CHECKOUT_GSP_13' => FS_CHECKOUT_GSP_13,
            'FS_CHECKOUT_GSP_14' => FS_CHECKOUT_GSP_14,
            'FS_CHECKOUT_GSP_15' => FS_CHECKOUT_GSP_15,
            'FS_CHECKOUT_GSP_16' => FS_CHECKOUT_GSP_16,
            'FS_SAVE_AND_CONTINUE' => FS_SAVE_AND_CONTINUE,
            'FS_VAT_ERROR' => FS_VAT_ERROR,
            'FS_SHOP_CART_EXCL_AU_VAT' => FS_SHOP_CART_EXCL_AU_VAT,
            'FS_OUTBREAK_READ_MORE' => FS_OUTBREAK_READ_MORE,
            'FS_ADDRESS_PO' => FS_ACCOUNT_PO_NUMBER,
            'FS_CHECKOUT_PO' => FS_CHECKOUT_PO,
            'FS_OUTBREAK_GSP_US' => FS_GSP_STOCK_9,
            'FS_OUTBREAK_GSP_OTHER' => FS_GSP_STOCK_7,
            'FS_CHECKOUT_US_VAT' => FS_VAX_TITLE_US,
            'FS_VAX_US_TIPS' => FS_VAX_US_TIPS,
            'FS_MOBILE_CLOSE' => FS_MOBILE_CLOSE,

            'fs_share_title' => FS_SHARE_ORDER_TITLE,
            'fs_share_ph_name' => FS_SHARE_ORDER_PH_NAME,
            'fs_share_ph_email' => FS_SHARE_ORDER_PH_EMAIL,
            'fs_share_text' => FS_SHARE_ORDER_TEXT,
            'fs_share_email_error' => FS_SHARE_ORDER_EMAIL_ERROR,
            'fs_share_email_empty' => FS_SHARE_ORDER_EMAIL_EMPTY,
            'fs_share_name_empty' => FS_SHARE_ORDER_NAME_EMPTY,
            'fs_sg_placeholder' => FS_CHECKOUT_ERROR_SG_06,

            'au_gsp_op_title' => FS_CHECKOUT_ORDERPRODUCTS_GSP_TITLE,
            'au_gsp_ori_text' => FS_CHECKOUT_GSP_ORI_TEXT,
            'au_gsp_ori_items' => FS_CHECKOUT_GSP_ORI_ITEMS,
            'au_gsp_ori_delivery' => FS_CHECKOUT_GSP_ORI_DELIVERY,
            'au_gsp_ori_total_before' => FS_CHECKOUT_GSP_ORI_TOTAL_BEFORE,
            'au_gsp_ori_total_tax' => FS_CHECKOUT_GSP_ORI_TAX,
            'au_gsp_ori_total' => FS_CHECKOUT_GSP_ORI_TOTAL,
            'au_gsp_ori_title' => FS_CHECKOUT_GSP_ORI_TITLE,
            'au_gsp_ori_see_details' => FS_CHECKOUT_GSP_SEE_DETAILS,
            'FS_DELIVERY_TITLE' => FS_DELIVERY_TITLE,
            'FS_DELIVERY_TICKET_NUMBER' => FS_DELIVERY_TICKET_NUMBER,
            'FS_DELIVERY_OTHER_INFO' => FS_DELIVERY_OTHER_INFO,
            'FS_DELIVERY_PROMPT' => FS_DELIVERY_PROMPT,
            'CARD_NOT_SUPPORT' => CARD_NOT_SUPPORT
        );
        if ($is_json) {
            return json_encode($language_pack);
        } else {
            return $language_pack;
        }
    }

    /**
     * 获取地址验证规则
     * @param array $add_valid
     * @param string $country_id
     * @return array|string
     */
    public static function getValidate($add_valid = array(), $country_id = 0)
    {
        $type = self::$options["validate_format"];
        $entry_suburb = false;
        if ($country_id == 188) {
            $entry_suburb = true;
        }

        $shipping_validate = array(
            "rules" => array(
                "AddressType" => [
                    "required" => true,
                ],
                "entry_company" => [
                    "maxlength" => 100,
                    "required" => false,
                ],
                "entry_firstname" => [
                    "required" => true,
                    "minlength" => $_SESSION['languages_code'] =='jp' ? 1 :2,
                    "maxlength" => 35
                ],
                "entry_lastname" => [
                    "required" => true,
                    "minlength" => $_SESSION['languages_code'] =='jp' ? 1 :2,
                    "maxlength" => 35
                ],
                "entry_street_address" => [
                    "required" => true,
                    "minlength" => 4,
                    "maxlength" => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? 35 : 300,
                ],
                "entry_suburb" => [
                    "minlength" => 4,
                    "maxlength" => 35,
                    "required" => $entry_suburb,
                ],
                "entry_postcode" => [
                    "required" => true,
                    "minlength" => 3
                ],
                "entry_city" => [
                    "required" => true
                ],
                "entry_telephone" => [
                    "required" => true
                ],
                "entry_country_id" => [
                    "required" => true
                ],
                "entry_state" => [
                    "required" => false
                ],
                'entry_tax_number' => [
                    'required' => false
                ]
            ),
            "messages" => array(
                "AddressType" => array(
                    "required" => FS_CHECKOUT_ERROR17
                ),
                "entry_company" => [
                    "maxlength" => FS_COMPANY_MAXLENGTH_ERROR,
                    'required' => FS_MANAGE_ORDERS_43
                ],
                "entry_firstname" => [
                    "required" => FS_CHECKOUT_ERROR1,
                    "minlength" => FS_CHECKOUT_ERROR13,
                    "maxlength" => FS_FIRSTNAME_MAXLENGTH_ERROR
                ],
                "entry_lastname" => [
                    "required" => FS_CHECKOUT_ERROR2,
                    "minlength" => FS_CHECKOUT_ERROR14,
                    "maxlength" => FS_LASTNAME_MAXLENGTH_ERROR
                ],
                "entry_street_address" => [
                    "required" => FS_CHECKOUT_ERROR3,
                    "minlength" => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? str_replace(300, 35, FS_CHECKOUT_ERROR12) : FS_CHECKOUT_ERROR12,
                    "maxlength" => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? str_replace(300, 35, FS_CHECKOUT_ERROR12) : FS_CHECKOUT_ERROR12,
                ],
                "entry_suburb" => [
                    "minlength" => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? str_replace(300, 35, FS_ADDRESS_LINE_TWO_MIN_MAX_TIP) : FS_ADDRESS_LINE_TWO_MIN_MAX_TIP,
                    "maxlength" => in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg')) ? str_replace(300, 35, FS_ADDRESS_LINE_TWO_MIN_MAX_TIP) : FS_ADDRESS_LINE_TWO_MIN_MAX_TIP,
                    "required" => FS_CHECKOUT_ERROR_SG_01,
                ],
                "entry_postcode" => [
                    "required" => FS_CHECKOUT_ERROR4,
                    "minlength" => FS_CHECKOUT_ERROR15
                ],
                "entry_city" => [
                    "required" => FS_CHECKOUT_ERROR5
                ],
                "entry_telephone" => [
                    "required" => FS_CHECKOUT_ERROR7
                ],
                "entry_country_id" => [
                    "required" => FS_CHECKOUT_ERROR6
                ],
                "entry_state" => [
                    "required" => FS_CHECKOUT_ERROR9
                ],
                'entry_tax_number' => [
                    'required' => FS_CHECKOUT_ERROR8
                ]
            )
        );
        if(!empty($add_valid['email'])){
            $shipping_validate['rules']['entry_email'] = [
                "required" => true,
                "FSemail" => true
            ];
            $shipping_validate['messages']['entry_email'] = [
                "required" => FS_CHECKOUT_ERROR30,
                "email" => FS_RELATED_EMAIL_ERROR,
                "FSemail"=>FS_RELATED_EMAIL_ERROR
            ];
        }
        if ($type == "html") {
            return json_encode($shipping_validate);
        }
        return $shipping_validate;
    }

    /**
     * address validate
     * @param $address
     * @param $vat_check
     * @return array
     */
    public static function validate($address,$vat_check = true)
    {
        global $db;
        $validate_rule = self::getValidate();
        $country_id = $address['entry_country_id'];
        if (in_array($country_id, array(223, 13, 129))) {
            $validate_rule['rules']['entry_postcode']['zip_valid'] = true;
            $validate_rule['messages']['entry_postcode']['zip_valid'] = FS_CHECKOUT_ERROR28;

            if($country_id == 223){
                $validate_rule['rules']['entry_state']['state_valid'] = true;
                if(isset($address['error_type']) && $address['error_type']== 2){
                    $validate_rule['messages']['entry_state']['state_valid'] = FS_CHECKOUT_ERROR39;
                }else {
                    $validate_rule['messages']['entry_state']['state_valid'] = FS_CHECKOUT_ERROR38;
                }
            }
            if ($country_id== 13) {
                $validate_rule['messages']['entry_postcode']['zip_valid'] = FS_CHECKOUT_ERROR28_AU;
            }
        }
        //Vat验证
        $EU_country = array(21,73,81,105,150,124,57,103,195,84,171,14,203,72,132,55,170,97,56,189,190,67,117,123,175,33,53,141,222);
        $company_type = $address['company_type'];
        $address_type = $address['address_type'];
        $is_ireland = $country_id == 222 && checkNorthIrelandPostcode($address['entry_postcode'],$country_id);
        if(in_array($country_id, $EU_country) && $company_type == 'BusinessType' && $vat_check){
            $country_code = fs_get_country_code_of_id($country_id);
            $code_tips = getEUVatTips($country_code);
            $code_tips = $is_ireland ? str_replace('GB','XI',$code_tips) : $code_tips;
            $validate_rule['rules']['entry_tax_number']['remote_validate_tax_number'] = true;
            $validate_rule['messages']['entry_tax_number']['remote_validate_tax_number'] = str_replace('$VAT',$code_tips,FS_CHECKOUT_ERROR_VAT);
        }
        $validate_rule['rules']['AddressType']['in'] = true;
        $validate_rule['messages']['AddressType']['in'] = CHECKOUT_COMPANY_TYPE;
        if (in_array($country_id, array(223, 13, 38, 138))) {
            $validate_rule['rules']['entry_state']['required'] = true;
        }
        if($country_id==96){
            $validate_rule['rules']['entry_postcode']['required'] = false;
            $validate_rule['rules']['entry_postcode']['minlength'] = false;
        }
        if ($country_id == 188) {
            $validate_rule['rules']['entry_suburb']['required'] = true;
        }
        if($address_type!==0){
            $validate_rule['rules']['entry_street_address']['disallow_pobox'] = false;
            $validate_rule['rules']['entry_suburb']['disallow_pobox'] = false;
        }
        $error = array();
        foreach ($validate_rule as $validate_key => $validate_val) {
            if ($validate_key == "rules") {
                foreach ($address as $address_key => $address_val) {
                    if ($address_key == "company_type") {
                        $address_key = "AddressType";
                    }
                    if ($validate_val[$address_key]) {
                        foreach ($validate_val[$address_key] as $rule_key => $rule) {
                            switch ($rule_key) {
                                case "in":
                                    if(!in_array($address_val, ['BusinessType', 'IndividualType'])) {
                                        $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                    }
                                    break;
                                case "required":
                                    if ($rule) {
                                        if (empty($address_val)) {
                                            $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                        }
                                    }
                                case "minlength":
                                    $length = mb_strlen($address_val);
                                    if ($length<$rule && $validate_val[$address_key]['required'] == true) {
                                        $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                    }
                                    break;
                                case "maxlength":
                                    $length = mb_strlen($address_val);
                                    if ($length>$rule) {
                                        $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                    }
                                    break;
                                case "disallow_pobox":
                                    if($rule){
                                        $po_dis_allow = "POBOX";
                                        $address_val = strtoupper(preg_replace("/\s./", "", $address_val)); //去掉所有字母和数字
                                        if (strpos($address_val, $po_dis_allow) !== false) {
                                            $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                        }
                                    }
                                    break;
                                case "zip_valid":
                                    if ($rule) {
                                        $address_val = $address_val ? $address_val : 0;
                                        switch ($country_id) {
                                            case 223:
                                                //波多黎各排除出美国的州
                                                $sql = "SELECT zip FROM `countries_to_zip_new`  WHERE zip = '$address_val'";
                                                $ret = $db->Execute($sql);
                                                if (empty($ret->fields['zip'])) {
                                                    $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                                }
                                                break;
                                              //澳大利亚开启验证
                                            case 13:
                                                $zip_code = (int)$address_val;
                                                $au_sql = "SELECT id FROM `shipping_au_code` WHERE value =".$zip_code." AND type = 2";
                                                $au_ret = $db->Execute($au_sql);
                                                $check_flag = empty($au_ret->fields['id']) ? false : true;
                                                if(!$check_flag){
                                                    $au_array = fs_get_data_from_db_fields_array(array('value'),'shipping_au_code','type = 0');
                                                    $check_flag = check_au_zip_code($zip_code,$au_array,',');
                                                    if(!$check_flag){
                                                        $au_array = fs_get_data_from_db_fields_array(array('value'),'shipping_au_code','type = 1');
                                                        $check_flag = check_au_zip_code($zip_code,$au_array,':');
                                                        if(!$check_flag){
                                                            $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                                        }
                                                    }
                                                }
                                                break;
                                            case 129:
                                                $my_sql = "SELECT post_zip FROM `fs_shipping_sameday_post`  WHERE post_zip = '$address_val' AND shipping_type=4";
                                                $my_ret = $db->Execute($my_sql);
                                                if (empty($my_ret->fields['post_zip'])) {
                                                    $error[$address_key][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                                }
                                                break;
                                        }
                                    }
                                    break;
                                case  "state_valid":
                                    $state_valid = $address['entry_state'];
                                    if($country_id == 223 && $state_valid == 'Puerto Rico'){
                                        $error['entry_state'][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                        $error['error_state'] = 'pr';
                                    };
                                    break;
                                case  "remote_validate_tax_number":
                                    $tax_number = $address['entry_tax_number'];
                                    $res = $db->execute("select countries_iso_code_2 from countries where countries_id = $country_id");
                                    $tax_is_code = $res->fields['countries_iso_code_2'];
                                    if($tax_is_code == 'GB' && !$is_ireland){
                                        continue;
                                    }
                                    if(!vat_validate($tax_number,$country_id,$tax_is_code,$is_ireland)){
                                        $error['entry_tax_number'][$rule_key] = $validate_rule['messages'][$address_key][$rule_key];
                                    };
                                    break;
                            }
                        }
                    }
                }
            }
        };
        return $error;
    }


    public function get_address_records()
    {
        global $db;
        $get_customer_info = $db->Execute("select count(address_book_id) as total from " . TABLE_ADDRESS_BOOK . " WHERE customers_id = " . intval($_SESSION['customer_id']));
        return $get_customer_info->fields['total'];
    }

    /**
     * @param bool $is_avaTaxCheck 是否更新$is_avaTaxCheck 字段
     * 结算登录 新增地址
     * @return bool|int
     */
    public static function addCustomersAddress($is_avaTaxCheck = false)
    {
        $address = self::$address;
        if($is_avaTaxCheck){
            $address['is_avaTax_check'] = 1;
        }
        if (empty($address) || empty($_SESSION['customer_id'])) {
            return false;
        }
        global $db;
        $address['customers_id'] = intval($_SESSION['customer_id']);
        zen_db_perform(TABLE_ADDRESS_BOOK, $address);
        $shipping_id = $db->insert_ID();
        $type = $address['address_type'];
        if ($type == 2) {
            $db->Execute("update " . TABLE_CUSTOMERS . " 
                          SET customers_default_billing_address_id = " . $shipping_id . " 
                          WHERE customers_id = " . intval($_SESSION['customer_id']));
        }
        return $shipping_id;
    }


    /**
     * @param string $address_book_id
     * @return bool
     */
    public static function deleteCustomersAddress($address_book_id = "")
    {
        global $db;
        if (empty($address_book_id)) {
            return false;
        }
        $handle = $db->Execute("DELETE FROM address_book WHERE  address_book_id = " . $address_book_id);
        return $handle;
    }

    public static function get_customers_address($shipping_type)
    {
        self::$customer_info = new  customer_account_info();
        if ($shipping_type == 1) {
            $use_address = self::$customer_info->get_customers_shipping_address();
        } else {
            $use_address = self::$customer_info->get_customers_billing_address();
        }
        return $use_address;
    }

    public static function get_post_address_data()
    {
        $entry_firstname = zen_db_prepare_input($_POST['entry_firstname']);

        $entry_lastname = zen_db_prepare_input($_POST['entry_lastname']);

        $entry_company = zen_db_prepare_input($_POST['entry_company']);

        $entry_street_address = zen_db_prepare_input($_POST['entry_street_address']);

        $entry_suburb = zen_db_prepare_input($_POST['entry_suburb']);

        $entry_city = zen_db_prepare_input($_POST['entry_city']);

        $entry_country_id = zen_db_prepare_input($_POST['entry_country_id']);

        $entry_state = zen_db_prepare_input($_POST['entry_state']);

        $company_type = zen_db_prepare_input($_POST['AddressType']);

        $entry_postcode = zen_db_prepare_input($_POST['entry_postcode']);
        $entry_telephone = zen_db_prepare_input($_POST['entry_telephone']);
        $entry_tax_number = zen_db_prepare_input($_POST['entry_tax_number']);
        //$ticket_number = empty(zen_db_prepare_input($_POST['ticket_number'])) ? '' : zen_db_prepare_input($_POST['ticket_number']);
        $address_type = (int)$_POST['address_type'] ? (int)$_POST['address_type'] : (int)$_POST['editType'];

        $shipping_address = array(

            'entry_company' => $entry_company,

            'entry_firstname' => $entry_firstname,

            'entry_lastname' => $entry_lastname,

            'entry_street_address' => $entry_street_address,

            'entry_suburb' => $entry_suburb,

            'entry_postcode' => $entry_postcode,

            'entry_state' => $entry_state,

            'entry_city' => $entry_city,

            'entry_country_id' => (int)$entry_country_id,

            'entry_zone_id' => (int)0,

            'entry_telephone' => $entry_telephone,
            'entry_tax_number' => $entry_tax_number,
            'company_type' => $company_type,
            'address_type' => $address_type,
            //'ticket_number' => $ticket_number
        );
        return $shipping_address;
    }

    public static function Address_format($data)
    {
        if (!$data) {
            return array();
        }

        $entry_company_html = $data['entry_company'];
        if (strlen($data['entry_company']) > 50) {
            $entry_company_html = '<p title="'.$data['entry_company'].'">'.substr($data['entry_company'], 0 , 50) . '...</p>';
        }

        $address_book_id = $data['address_book_id'];
        $entry_company = $data['entry_company'] ? '<em class="checkout_Npro_titLine1"></em>' . $entry_company_html : "";
        $entry_firstname = $data['entry_firstname'];
        $entry_lastname = $data['entry_lastname'];
        $entry_street_address = $data['entry_street_address'] ? $data['entry_street_address'] . ", " : "";
        $entry_suburb = $data['entry_suburb'] ? $data['entry_suburb'] . ", " : " ";
        $entry_postcode = $data['entry_postcode'] ? $data['entry_postcode'] . ", " : "";
        $entry_city = $data['entry_city'] ? $data['entry_city'] . " " : "";
        $entry_state = $data['entry_state'] ? $data['entry_state'] . " " : "";
        $entry_tax_number = $data['entry_tax_number'] ? $data['entry_tax_number'] : "";
        $entry_country_id = $data["entry_country"]['entry_country_id'];
        $entry_country_name = $data["entry_country"]['entry_country_name'];
        $tel_prefix = $data["entry_country"]['tel_prefix'];
        $entry_code = $data["entry_country"]['country_code'];
        $company_type = $data['company_type'];
        $entry_telephone = $data['entry_telephone'] ? " (" . $tel_prefix . " " . $data['entry_telephone'] . ")" : "";
        $entry_zone_id = $data['entry_zone_id'];
        if ($entry_country_id == 223) {
            $info_entry_state = zen_get_countries_us_states_code($data['entry_state']) . " ";
        } else {
            $info_entry_state = $entry_state;
        }

        $address_title = $entry_firstname . " " . $entry_lastname . $entry_company;
        $address_info =  $entry_street_address . $entry_suburb . $entry_city . $info_entry_state . $entry_postcode . $entry_country_name;

        return array(
            "address_title" => $address_title,
            "entry_country_id" => $entry_country_id,
            "address_info" => $address_info,
            "tax_number" => $entry_tax_number,
            "address_book_id" => $address_book_id,
            "address_telephone" => $entry_telephone,
            "company_type" => $company_type,
            "address_billing_info" =>  $entry_street_address . $entry_suburb . $entry_city . $info_entry_state . $entry_postcode .$entry_country_name,
        );
    }

    /**
     * @param string $address
     * @param string $default_address
     * @param int $type 1：shipping 2:billing
     * @return string
     */
    public static function getAddressList($address = "", $default_address = "", $type = 1,$po="")
    {
        if (empty($address)) {
            return "";
        }
        $format = self::Address_format($address);
        $entry_suburb = $format['entry_suburb'];
        $title = $format['address_title'];
        $info = $format['address_info'];
        $tel_phone = $format['address_telephone'];
        $tax_number = $format['tax_number'];
        $address_book_id = $format["address_book_id"];
        $company = $format["company_type"];
        $continue_name = FS_COMMON_7;
        $entry_country_id = $format['entry_country_id'];
        $address_billing_info = $format['address_billing_info'];
        $edit = '<div class="checkout_Npro_addAddress_icBox">
                      <span class="addAddress_editIc iconfont icon" onclick="showEditForm(this,' . $address_book_id . ',event)">&#xf044;</span>
                      <span class="addAddress_deleteIc iconfont icon" data-address-id="' . $address_book_id . '" onclick="confirm_del_window(3,1,' . $address_book_id . ')">&#xf027;</span>
                 </div>';
        if($po){
            $edit = "";
        }
        if ($type == 1) {
            if ($address_book_id == $default_address) {
                $show_class = "showBox choosez1 checkout_Npro_defaultDev";
                $choose_tag = "&#xf021;";
            } else {
                $show_class = "hideBox";
                $choose_tag = "&#xf022;";
            }
            $html = '<div class="address_tag_' . $address_book_id . ' checkout_Npro_checkedBox address_children checkout_Npro_theContLi ' . $show_class . '" data-entry-country="'.$entry_country_id. '" data-entry-address="'.$address_book_id. '" data-entry-company="'.$company. '" data-entry-suburb="'.$entry_suburb.'">
                   <div class="checkout_Npro_checkedMain checkout_Npro_theContit1">
                         <div class="checkout_Npro_checkedRadio">
                            <span class="iconfont icon">'.$choose_tag.'</span>
                         </div>
                         <div class="checkout_Npro_checkedAdd">
                                <div class="checkout_Npro_checkedTxt">
                                        ' . $title . $po . '
                                        '.$edit.'
                                </div>
                                <p class="checkout_Npro_theContxt1">' . $info . '</p>
                                <p class="checkout_Npro_theContxt1">' . $tel_phone . '</p>
                                <p class="checkout_Npro_theContxt1">' . $tax_number . '</p>
                         </div>
                  </div>
                  <div class="checkout_Npro_pad3 checkoutedit_dev checkout_NproEnb shipping_edit_form  checkout_Npro_hideDev" style="display: none">
                  </div>
                  <div class="checkout_Npro_pad3 checkout_Npro_btnBox1 checkout_Npro_hideDev confirm_address">
                         <button type="submit" class="checkout_Npro_btn1 address_btn1" onclick="confirm_address(this,' . $address_book_id . ')">'.FS_COMMON_6.'</button>
                  </div>
               </div>';
        }elseif($type == 2){
                $html = <<<EOF
                    <div class="checkout_Npro_checkedMain checkout_Npro_theContit1">
                            <div class="checkout_Npro_checkedRadio">
                                <span class="iconfont icon">&#xf022;</span>
                            </div>
                            <div class="checkout_Npro_checkedAdd">
                                <div class="checkout_Npro_checkedTxt">
                                    {$title}
                                </div>
                                <p class="checkout_Npro_theContxt1">{$info}</p>
                                <p class="checkout_Npro_theContxt1">{$tel_phone}</p>
                            </div>

                    </div>
                    <div class="checkout_Npro_pad3 checkout_Npro_btnBox1 checkout_Npro_hideDev confirm_address">
                         <button onclick="confirm_billing_address(this,event,{$address_book_id})" type="submit" class="checkout_Npro_btn1 address_btn1">$continue_name</button>
                    </div>  
EOF;

        } else {
            $html = $address_billing_info;
        }
        return $html;
    }


    /**
     * @param string $address_book_id
     * @param bool $is_valide
     * @param bool $is_guest
     * @param array $error_param
     * @param $order
     * @param $shipping_data
     * @return array
     */
    public static function handlerShippingAddress($address_book_id = "",$is_valide = false,$is_guest = false,$error_param = [],$order, $shipping_data)
    {
        global $currencies;
        $shipping_list = array();
        if (empty($address_book_id)) {
            return $shipping_list;
        }
        $shipping_address = self::getShippingAddress($order);
        if($is_valide){
            if(isset($error_param['error_type'])){
                $shipping_address['error_type'] = $error_param['error_type'];
            }
            $validate = self::validate($shipping_address);
            if(!empty($validate)){
                return array("error" => $validate);
            }
        }
        //当前订单地址信息
        $country_id = $order->delivery['country_id'];
        $company_type = $order->delivery['company_type'];
        $country_code = $order->delivery['country']['iso_code_2'];
        $entry_postcode = $order->delivery['postcode'] ? $order->delivery['postcode'] : "";

        //当前地址仓库
        $warehouse = $order->local_warehouse;

        //是否转运
        $is_need_transhipment = false;


        //当前地址服务电话
        $phone = fs_new_get_phone($country_code);
        $symbol = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
        $symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
        $order_info = $order->getCurrentOrderInfo();
        //获取默认运费价格
        $total_cost = $order->info["shipping_cost"];
        $shipping_price = $symbol . $currencies->fs_format_number($order_info['shipping']) . $symbol_right;
        $total_before_tax = $currencies->fs_format_number($order_info['subtotal'] + $order_info['shipping']);

        //税后价
        $order_info_tax = $order->getAfterTaxCurrentOrderInfo();
        $subtotal_tax = $currencies->fs_format_number($order_info_tax['aftertax_subtotal']);
        $shipping_price_tax = $symbol . $currencies->fs_format_number($order_info_tax['aftertax_shipping']) . $symbol_right;

        $is_shipping_free = false;
        if ($total_cost == 0) {
            $shipping_price_tax = FIBER_CHECK_FREE;
            $is_shipping_free = true;
            if($order->handleFreeShippingPrice()){
                $shipping_price = FIBER_CHECK_FREE;
            }
        }

        $current_free_info = $order->get_free_shipping_money();
        $outPutTextPre = $current_free_info['outPutTextPre'];
        $is_global_shipping_free = false;
        if($order->global_products && !$order->is_remote_post_code && $order->local_warehouse != 2 && !in_array($order->delivery['country_id'],[153,176])){
            $is_global_shipping_free = true;
        }
        //获取收税
        $vat = $order_info['vat'];
        $insurance = $order_info['insurance'];
        //总价 = 产品总价+运费+税
        $origin_total = $order_info['total'];
        $total = $currencies->fs_format_number($origin_total);
        $total_text = $symbol.$total.$symbol_right;
        $subtotal = $currencies->fs_format_number($order_info['subtotal']);
        $subtotal_text = $symbol.$subtotal.$symbol_right;

        $vat = $currencies->fs_format_number($vat);
        $vat_text = $symbol.$vat.$symbol_right;
        $insurance = $currencies->fs_format_number($insurance);
        $insurance_text = $symbol.$insurance.$symbol_right;
        $shipping_text = $shipping_price;

        $origin_total_us = $order->info['total'];

        /**
         * 判断所有产品中时否有重货类
         */
        $is_buck_in_products = $order->is_buck_in_products;

        $au_zone = 0;
        if ($entry_postcode && $country_code == "AU") {
            $au_entry_postcode = substr(trim($entry_postcode), 0, 4);
            $au_zone = zen_get_shipping_au_code($au_entry_postcode, 'zone');
        }

        //PAYEEZY_STATUS 是否开启payeezy 付款 国家为美国 货币为美元 信用卡用payeez渠道 否则用globalcollect
        if ($_SESSION['currency'] == "USD" && $country_id == 223) {
            $is_show_echeck = true;
        } else {
            $is_show_echeck = false;
        }
        if(is_show_payeezy($_SESSION['currency'],$country_id)){
            $payment_method_credit_cart = "payeezy";
        }else{
            $payment_method_credit_cart = "globalcollect";
        }
        //俄罗斯对公支付方式
        $is_show_alfa = false;
        if($country_id==176 && $company_type=='BusinessType'){
            $is_show_alfa = true;
        }
        $is_uk_business_address = false;
        if($order->billing['company_type'] == 'BusinessType' && in_array($order->billing['country']['id'],[222,244]) && $country_id !=81) {
            $is_uk_business_address = true;
        }
        $is_bill_company = false;
        if ($order->billing['company_type'] == 'BusinessType' &&
            (!german_warehouse('country_number', $order->billing['country_id']) ||
                $order->billing['country_id'] == 81)) {
            $is_bill_company = true;
        }
        if ($order->delivery['country_id'] == 21 && $order->billing['country_id'] == 223 &&
            $order->billing['company_type'] != 'BusinessType') {
            $is_bill_company = false;
        }
        $price_data = array(
            "is_vax" => $order->is_vax,
            "shipping_cost" => $shipping_price,
            "shipping_cost_tax" => $shipping_price_tax,
            "total_before_tax" => $total_before_tax,
            "is_shipping_free" => $is_shipping_free,
            "origin_total" => $origin_total,
            "origin_total_us" => $origin_total_us,
            'subtotal_tax' => $subtotal_tax,
            "vat_title" => get_checkout_vat_title($order->delivery['country']['iso_code_2'],2,$is_bill_company,'',$is_uk_business_address),
            //产品价格信息
            'shipping' => $order_info['shipping'],
            'total' => $order_info['total'],
            'vat' => $order_info['vat'],
            'subtotal' => $order_info['subtotal'],
            'insurance' => $order_info['insurance'],
            'after_sub_total_text' => $symbol.$subtotal_tax.$symbol_right,
            'after_shipping_text' => $shipping_price_tax == FIBER_CHECK_FREE ? FIBER_CHECK_FREE : $shipping_price_tax,
            'shipping_text' => $shipping_text,
            'total_text' => $total_text,
            'vat_text' => $vat_text,
            'subtotal_text' => $subtotal_text,
            'insurance_text' => $insurance_text,
            'total_before_tax_text' => $symbol.$total_before_tax.$symbol_right
        );
        $message = array(
            "phone" => $phone
        );
        $uncheck = "";
        //账期地址
        if(!$is_guest){
//            $purchaseInfo = getPurchaseInfo();
//            $Po_address_arr = $purchaseInfo['Po_address_arr'];
//            if (in_array($address_book_id, $Po_address_arr)) {
//                $uncheck = 1;
//                $_SESSION['uncheck'] = 1;
//            } else {
            $uncheck = 0;
            $_SESSION['uncheck'] = 2;
//            }
        }

        /**
         * 当前国家是否允许使用credit card信息
         */
        $is_show_credit_card = true;
        $shield_country = array("BJ", "BF", "BI", "TD", "CD", "CG", "ET", "GH", "GW", "LR", "LY", "MG", "MW", "MZ", "NE", "NG", "KP", "RW", "ST", "SN", "SL", "SD", "TZ", "TG", "UG", "ZM");
        if (in_array(strtoupper($country_code), $shield_country)) {
            $is_show_credit_card = false;
        }
        $languages_code = $_SESSION['languages_code'];
        $countries_iso_code = $_SESSION['countries_iso_code'];

        $is_show_gsp_vat = is_gsp_checkout_order() ? 1 : 0;

        $currency = $_SESSION['currency'];
        $product_info = self::productInfo($order);
        $data = array(
            "status" => 1,
            "message" => $message,
            "warehouse" => $warehouse,
            "price_data" => $price_data,
            "is_need_transhipment" => $is_need_transhipment,
            "country_id" => $country_id,
            "uncheck" => $uncheck,
            "payment_method_credit_cart" => $payment_method_credit_cart,
            "is_show_credit_card" => $is_show_credit_card,
            "is_show_echeck" => $is_show_echeck,
            "is_show_alfa" => $is_show_alfa,
            "is_buck_in_products" => $is_buck_in_products,
            "au_zone" => $au_zone,
            "languages_code" => $languages_code,
            "countries_iso_code" => $countries_iso_code,
            "currency" => $currency,
            "currency_left" => $currencies->currencies[$_SESSION['currency']]['symbol_left'],
            "currency_right" => $currencies->currencies[$_SESSION['currency']]['symbol_right'],
            "product_info" => $product_info,
            "shipping_data" => $shipping_data,
            "is_global_shipping_free" => $is_global_shipping_free,
            "outPutTextPre" => $outPutTextPre,
            "companyType" => $order->delivery['company_type'],
            "is_buck" => $order->is_buck,
            "is_show_gsp_vat" => $is_show_gsp_vat,
            "delivery_country" => $order->delivery['country']['title']
        );
        return $data;
    }

    public static function setShippingCost($shipping_data, $initQuote = []){
        $shipping_arr = ["local","delay","global",'gift'];
        foreach ($shipping_arr as $e){
            $default_shipping_index = 0;
            if($shipping_data[$e]){
                $shipping_cost = $shipping_data[$e];
                if(!empty($initQuote)){
                    $localQuoteShipping = $initQuote['shipping_local_method_code'] ? $initQuote['shipping_local_method_code'] : '';
                    $delayQuoteShipping = $initQuote['shipping_delay_method_code'] ? $initQuote['shipping_delay_method_code'] : '';
                    foreach ($shipping_cost as $jj => $mm) {
                        if ($e == 'local' && !empty($localQuoteShipping)) {
                            if ($mm['methods'] . '_' . $mm['methods'] == $localQuoteShipping) {
                                $default_shipping_index = $jj;
                            }
                        } elseif ($e == 'delay' && !empty($delayQuoteShipping)) {
                            if ($mm['methods'] . '_' . $mm['methods'] == $delayQuoteShipping) {
                                $default_shipping_index = $jj;
                            }
                        }
                    }
                }
                $_SESSION['shipping_'.$e] = array('id' => $shipping_cost[$default_shipping_index]['methods'] . '_' . $shipping_cost[$default_shipping_index]['methods'],

                    'title' => $shipping_cost[$default_shipping_index]['title'],

                    'cost' => $shipping_cost[$default_shipping_index]['s_price'],

                    'origin_price' => $shipping_cost[$default_shipping_index]['origin_price'],
                );
            }else{
                unset($_SESSION['shipping_'.$e]);
            }
        }
    }

    public function getShippingAddress($order){
        $shipping_address = array(

            'entry_company' => $order->delivery['company'],

            'entry_firstname' => $order->delivery['firstname'],

            'entry_lastname' =>  $order->delivery['lastname'],

            'entry_street_address' => $order->delivery['street_address'],

            'entry_suburb' => $order->delivery['suburb'],

            'entry_postcode' => $order->delivery['postcode'],

            'entry_state' => $order->delivery['state'],

            'entry_city' =>  $order->delivery['city'],

            'entry_country_id' => $order->delivery['country_id'],

            'entry_telephone' => $order->delivery['telephone'],
            'entry_tax_number' => $order->delivery['tax_number'],
            'company_type' => $order->delivery['company_type'],

            'is_avaTax_check' => $order->delivery["is_avaTax_check"],

            'address_type' => 0
        );
        return $shipping_address;
    }

    /**
     * @param $order
     * @param array $shipping_address
     * @param int $address_book_id
     * @param string $action
     * @param bool $calculateVax
     * @return array
     * @throws Throwable
     */
    public static function avaTaxHandle($order, $shipping_address = [], $address_book_id = 0, $action = '', $calculateVax = true)
    {
        global $db,$currencies;
        if(!AUTOAVATAX){
            return ['status'=>'success'];
        }
        if($shipping_address['entry_country_id'] == 223){
            $avaTax = new AvaTaxService();
            $helpService = new HelpCustomerPlaceOrderService();
            $local_products = [];
            $delay_products = [];
            if(!empty($order->local_products)){
                $local_products = $order->local_products;
                $local_products[] = [
                    'qty' => 1,
                    'type' => 'shipping',
                    'name' => $_SESSION['shipping_local']['title'],
                    'id' => $_SESSION['shipping_local']['id'],
                    'paypal_price' => $currencies->total_format_new($order->handleShippingCost($_SESSION['shipping_local']['cost']),
                        true, $order->info['currency'], $order->info['currency_value'])
                ];
            }
            if(!empty($order->delay_products)){
                $delay_products = $order->delay_products;
                $delay_products[] = [
                    'qty' => 1,
                    'type' => 'shipping',
                    'name' => $_SESSION['shipping_delay']['title'],
                    'id' => $_SESSION['shipping_delay']['id'],
                    'paypal_price' => $currencies->total_format_new($order->handleShippingCost($_SESSION['shipping_delay']['cost']),
                        true, $order->info['currency'], $order->info['currency_value'])
                ];
            }
            $avaTax->setAddress([
                'address_book_id' => $address_book_id,
                'postalCode' => $shipping_address['entry_postcode'],
                'line1' => $shipping_address['entry_street_address'],
                'region' => zen_get_countries_us_states_code($shipping_address['entry_state']),
                'city' => $shipping_address['entry_city'],
                'country' => zen_get_country_iso_code($shipping_address['entry_country_id']),
                'line2' => $shipping_address['entry_suburb'],
            ])->setCreatedOrderInfo([
                'customerCode' => $helpService->getRelatedCustomerCode($order->customer['customers_number_new']),
                'currency' => $_SESSION['currency'],
                'currency_value' => $order->info['currency_value']
            ])->setOrders(['local'=>$local_products,'delay' => $delay_products]);
            //验证地址
            if ($action != 'calculateVax') {
                $_SESSION['useUpsDefaultAddress'] = 0;
            }
            if(!in_array($action,['calculateVax'])){
                if($action != 'calculateVax'){
                    $avaTaxCheck =  $avaTax->resolveAddress();
                    if ($avaTaxCheck['status'] == false) {
                        if($avaTaxCheck['type'] == 'validate'){
                            return ['status' => 'error', 'avaTaxError' => $avaTaxCheck, 'type' => 1];
                        }else{
                            $_SESSION['useUpsDefaultAddress'] = 1;
                            $avaTax->changeShipToAddress('line1',$avaTax->defaultLine);
                        }
                    } else {
                        if ($address_book_id && $_SESSION['customer_id']) {
                            $db->Execute("update address_book set is_avaTax_check = 1
                        where address_book_id = " . $address_book_id . " and customers_id=" . $_SESSION['customer_id']);
                        }
                    }
                }
            }

            //计算税收
            if($calculateVax){
                if($_SESSION['useUpsDefaultAddress']){
                    $avaTax->changeShipToAddress('line1',$avaTax->defaultLine);
                }
                $data = $avaTax->createTransition('SalesOrder');
                if ($data['status']) {
                    $orderVat = [
                        'local' => 0,
                        'delay' => 0,
                        'total' => 0
                    ];
                    $total_tax  = 0;
                    foreach ($data['data'] as $k => $v) {
                        if(isset($v['totalTax'])){
                            $orderVat[$k] = $v['totalTax'];
                            $total_tax += $v['totalTax'];
                        }
                    }
                    $orderVat['total'] = $total_tax;
                    $_SESSION['avaTaxRecord'] = @json_encode($data['data']);
                    $_SESSION['orderVat'] = $orderVat;
                } else {
                    unset($_SESSION['avaTaxRecord']);
                    $message = $data['message'];
                    $code = 0;
                    if(!empty($message)){
                        $message = @json_decode($message,true);
                        if(!empty($message['error']['code']) && $message['error']['code'] == 'GetTaxError'){
                            if(!empty($message['error']['details']) && is_array($message['error']['details'])){
                                foreach($message['error']['details'] as $v){
                                    if(!empty($v['faultSubCode']) && in_array(strtolower($v['faultSubCode']),$avaTax->addressError())){
                                        $message = FS_ADDRESS_ERROR6;
                                        $code = 1;
                                        break;
                                    }
                                }
                            }else{
                                $message = $message['error']['message'] ? $message['error']['message']: FS_SYSTME_BUSY;
                            }
                        }elseif (!empty($message['error']['message'])){
                            $message = $message['error']['message'];
                            $code = 0;
                        }
                    }else{
                        $message = FS_SYSTME_BUSY;
                    }
                    return ['status' => 'error', 'avaTaxError' => ['message' => $message], 'type' => 2,'code'=>$code];
                }
            }
        }
        return ['status'=>'success'];
    }

    /**
     * @param $order
     * @return array
     */
    public static function productInfo($order="")
    {
        global $currencies;
        //当前地址仓库
        if(empty($order)){
            $order = new order();
        }
        $warehouse = $order->local_warehouse;
        $country_id = $order->delivery['country_id'];
        //是否转运
        $is_need_transhipment = false;
        $local_products = self::create_products_for_checkout($order->local_products,$order, 'local');
        $global_products = self::create_products_for_checkout($order->global_products,$order, 'global');
        $delay_products = self::create_products_for_checkout($order->delay_products,$order, 'delay');
        $gift_products = self::create_products_for_checkout($order->gift_products,$order, 'gift');
        $country_code = $order->delivery['country']['iso_code_2'];
        //订单分单信息
        $order_num_info = $order->get_order_num();
        $order_num = $order_num_info['num'];
        $buck = $order->is_buck;//delay
        $local_buck = $order->is_local_buck;//local
        $local_products_total_us =  $order->local_info['total']; //local
        $global_warehouse_title = "";
        $delay_warehouse_title = "";
        $local_warehouse_title = "";
        $gift_warehouse_title = "";
        $local_time = "";
        $global_time = "";
        $delay_time = "";
        $delay_buck_tips = "";
        $local_buck_tips = "";
        $delay_customs_tips = "";
        $local_customs_tips = "";
        $shipping_method = "";
        $remote_tips = "";
        $is_has_spec = CheckOrderSuperSpecProducts();

        $gift_message = "";
        $gift_num = count($gift_products);
        //$result = zen_get_us_en_site($country_code,$warehouse);
        $en_us_data = [];
        $tax_description_local = "";
        $tax_description_delay = "";
        $data = array();
        switch ($warehouse){
            case 40:
                if(!empty($local_products)){
                    $local_warehouse_title = lcfirst(FS_WAREHOUSE_AREA_2);
                    $delivery_info = array(
                        'shipping_local' => $_SESSION['shipping_local'],
                        'local_products' => $local_products,
                        'warehouse' => $warehouse,
                        'country_code' => $country_code,
                        'order' => $order,
                    );
                    $localInfo = zen_get_checkout_delivery($delivery_info);
                    $shipping_method = $localInfo['shipping_method'];
                    $local_time = $localInfo['local_time'];
                    if ($shipping_method == 'selfreferencezones') {
                        $local_warehouse_title = '';
                    } else {
                        $local_warehouse_title = $localInfo['local_warehouse_title'] ? $localInfo['local_warehouse_title'] : $local_warehouse_title;
                    }
                }
                if(!empty($delay_products)){
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_1;
                    if(in_array($country_code,['US','PR'])){
                        $delay_warehouse_title = lcfirst(FS_WAREHOUSE_AREA_1);
                    }
                }
                if(!empty($global_products)){
                    $global_warehouse_title = FS_WAREHOUSE_AREA_1;
                }
                if(!empty($gift_products)){
                    $gift_warehouse_title = FS_WAREHOUSE_AREA_37;
                }
                break;
            case 20:
                if(!empty($local_products)){
                    $local_warehouse_title = FS_WAREHOUSE_AREA_3;

                    //本地有库存交期
                    $delivery_info = array(
                        'shipping_local' => $_SESSION['shipping_local'],
                        'local_products' => $local_products,
                        'warehouse' => $warehouse,
                        'country_code' => $country_code,
                        'order' => $order,
                    );
                    $localInfo = zen_get_checkout_delivery($delivery_info);
                    $shipping_method = $localInfo['shipping_method'];
                    $local_time = $localInfo['local_time'];
                    if ($shipping_method == 'selfreferencezones') {
                        $local_warehouse_title = '';
                    } else {
                        $local_warehouse_title = $localInfo['local_warehouse_title'] ? $localInfo['local_warehouse_title'] : $local_warehouse_title;
                    }

                    //判断清关补充提示语
                    if(other_eu_warehouse($country_id) && !$order->is_ireland_zones){
                        $local_customs_tips = FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS;
                    }
                }
                if(!empty($delay_products)){
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_3;

                    //判断清关补充提示语
                    if(other_eu_warehouse($country_id) && !$order->is_ireland_zones){
                        $delay_customs_tips = FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS;
                    }
                }
                if(!empty($global_products)){
                    $global_warehouse_title = FS_WAREHOUSE_AREA_3;
                }
                if(!empty($gift_products)){
                    $gift_warehouse_title = FS_WAREHOUSE_AREA_3;
                }
                break;
            case 37:
                if(!empty($local_products)){
                    $local_warehouse_title = FS_WAREHOUSE_AREA_AU;
                    //本地有库存交期
                    $delivery_info = array(
                        'shipping_local' => $_SESSION['shipping_local'],
                        'local_products' => $local_products,
                        'warehouse' => $warehouse,
                        'country_code' => $country_code,
                        'order' => $order,
                    );
                    $localInfo = zen_get_checkout_delivery($delivery_info);
                    $shipping_method = $localInfo['shipping_method'];
                    $local_time = $localInfo['local_time'];
                    if ($shipping_method == 'selfreferencezones') {
                        $local_warehouse_title = '';
                    } else {
                        $local_warehouse_title = $localInfo['local_warehouse_title'] ? $localInfo['local_warehouse_title'] : $local_warehouse_title;
                    }
                }
                $remote_tips = get_step_tips($order);
                if(!empty($delay_products)){
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_AU;
                    if($order->is_buck){
                        $remote_tips = '';
                    }
                }
                if(!empty($global_products)){
                    $global_warehouse_title = FS_WAREHOUSE_AREA_AU;
                }
                if(!empty($gift_products)){
                    $gift_warehouse_title = FS_WAREHOUSE_AREA_AU;
                }
                break;
            case 2:
                if(!empty($global_products)){
                    $global_warehouse_title = FS_WAREHOUSE_AREA_1;
                    $global_time = FS_WAREHOUSE_AREA_4;
                }
                if(!empty($delay_products)){
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_1;
                }
                if(!empty($local_products)){
                    $local_warehouse_title = FS_WAREHOUSE_AREA_1;
                    //本地有库存交期
                    $delivery_info = array(
                        'shipping_local' => $_SESSION['shipping_local'],
                        'local_products' => $local_products,
                        'warehouse' => $warehouse,
                        'country_code' => $country_code,
                        'order' => $order,
                    );
                    $localInfo = zen_get_checkout_delivery($delivery_info);
                    $shipping_method = $localInfo['shipping_method'];
                    $local_time = $localInfo['local_time'];
                    if ($shipping_method == 'selfreferencezones') {
                        $local_warehouse_title = '';
                    } else {
                        $local_warehouse_title = $localInfo['local_warehouse_title'] ? $localInfo['local_warehouse_title'] : $local_warehouse_title;
                    }
                }
                if(!empty($gift_products)){
                    $gift_warehouse_title = FS_WAREHOUSE_AREA_1;
                }
                break;
            case 71:
                if(!empty($global_products)){
                    $global_warehouse_title = FS_WAREHOUSE_AREA_1;
                    $global_time = FS_WAREHOUSE_AREA_4;
                }
                if(!empty($delay_products)){
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_1;
                    $tax_description_delay = FS_TAX_DESCRIPTION_EX;
                }
                if(!empty($local_products)){
                    $local_warehouse_title = FS_WAREHOUSE_AREA_SG;
                    $delivery_info = array(
                        'shipping_local' => $_SESSION['shipping_local'],
                        'local_products' => $local_products,
                        'warehouse' => $warehouse,
                        'country_code' => $country_code,
                        'order' => $order,
                    );
                    $localInfo = zen_get_checkout_delivery($delivery_info);
                    $shipping_method = $localInfo['shipping_method'];
                    $local_time = $localInfo['local_time'];
                    if ($shipping_method == 'selfreferencezones') {
                        $local_warehouse_title = '';
                    } else {
                        $local_warehouse_title = $localInfo['local_warehouse_title'] ? $localInfo['local_warehouse_title'] : $local_warehouse_title;
                    }
                }
                if(!empty($gift_products)){
                    $gift_warehouse_title = FS_WAREHOUSE_AREA_SG;
                }
                break;
            case 67:
                if(!empty($local_products)){
                    $local_warehouse_title = FS_WAREHOUSE_AREA_RU;
                    //本地有库存交期
                    $delivery_info = array(
                        'shipping_local' => $_SESSION['shipping_local'],
                        'local_products' => $local_products,
                        'warehouse' => $warehouse,
                        'country_code' => $country_code,
                        'order' => $order,
                    );
                    $localInfo = zen_get_checkout_delivery($delivery_info);
                    $shipping_method = $localInfo['shipping_method'];
                    $local_time = $localInfo['local_time'];
                    if ($shipping_method == 'selfreferencezones') {
                        $local_warehouse_title = '';
                    } else {
                        $local_warehouse_title = $localInfo['local_warehouse_title'] ? $localInfo['local_warehouse_title'] : $local_warehouse_title;
                    }
                };
                if(!empty($delay_products)){
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_RU;
                }
                if(!empty($global_products)){
                    $global_warehouse_title = FS_WAREHOUSE_AREA_RU;
                }
                if(!empty($gift_products)){
                    $gift_warehouse_title = FS_WAREHOUSE_AREA_RU;
                }
                break;
        }
        if(!empty($delay_products)){
            //获取延迟发货的最长交期
            $new_delay_products = [];
            $delayHasHeavy = false;
            foreach($delay_products as $key=>$value){
                if(sizeof($value['composite_no_stock'])){
                    //当前产品是组合产品，且存在无库存的子产品 获取子产品中最长的交期
                    $new_delay_products = array_merge($new_delay_products, $value['composite_no_stock']);
                }else{
                    $new_delay_products[] = $value;
                }
                if(in_array($value['heavy_tag'],[1,2])){
                    $delayHasHeavy = true;
                }
            }
            if($_SESSION['shipping_delay']['id']){
                $shipping_method_arr = explode('_',$_SESSION['shipping_delay']['id']);
                $shipping_method = $shipping_method_arr[0];
            }
            $transport_time = zen_get_transport_limitation($warehouse,$shipping_method,$country_code);//运输时间+2个工作日
            $en_us_data = array(
                'is_en_us' => true,
                'transport_time' => $transport_time, //运输时间+2个工作日
                'shipping_method' => $shipping_method,
            );
            $time_info = get_max_date($new_delay_products,$warehouse,$country_code,$en_us_data,$delayHasHeavy);
            $delay_time = $time_info['delay_time'].(!empty($transport_time) ? FS_EMAIL_PAUSE : "");
            if (empty($transport_time)) {
                if ($warehouse == 20) {
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_SHIP_DE;
                } elseif ($warehouse == 37) {
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_SHIP_AU;
                } elseif ($warehouse == 67) {
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_SHIP_RU;
                } else {
                    $delay_warehouse_title = FS_WAREHOUSE_AREA_SHIP_CN;
                }
            }
        }

        if(($buck && !empty($delay_products) && !in_array($warehouse, [37, 67])) || ($country_code == "NZ"&& !empty($delay_products))){
            $delay_warehouse_title = (!empty($transport_time) ? FS_WAREHOUSE_AREA_1 : FS_WAREHOUSE_AREA_SHIP_CN);
        }

        if($country_code == "NZ" && !empty($global_products)){
            $global_warehouse_title = FS_WAREHOUSE_AREA_1;
        }
        if($warehouse == 20 && !empty($delay_products)){
            $delay_warehouse_title = (!empty($transport_time) ? FS_WAREHOUSE_AREA_3 : FS_WAREHOUSE_AREA_SHIP_DE);
        }
        if(!empty($global_products)){
            $time_info = get_max_date($global_products,$warehouse,$country_code);
            $global_time =  $time_info['delay_time'];
        }
        if($buck){
            $delay_buck_tips = get_buck_tips($order,false,$buck);
        }
        if($local_buck){
            $local_buck_tips = get_buck_tips($order,$local_buck,false);
        }
        $EUR_local_products_total = $currencies->total_value($local_products_total_us,true,'EUR','');
        if($warehouse ==20 && !empty($order->local_products) &&  (!german_warehouse('country_code',$country_code))){
            $local_products_tip  = LOCAl_PRODUCTS_DELAY_REASON;
        }
        $products = array(
            "local" => $local_products,
            "delay" => $delay_products,
            "global" => $global_products,
            'gift' => $gift_products
        );
        $data['products'] = $products;
        $data['number'] = $order_num;
        $data['global']['time'] = $global_time;
        $data['delay']['time'] = $delay_time;
        $data['local']['time'] = $local_time;
        $data['gift']['time'] = FS_WAREHOUSE_AREA_4;

        $currency_symbol_left = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
        $currency_symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
        $data['global']['subtotal'] = $order->global_info['subtotal'];
        $data['delay']['subtotal'] = $currency_symbol_left . $currencies->fs_format($order->getCurrentOrderInfo('delay')['total'], false, $order->info['currency']
                , $order->info['currency_value'])." ".$currency_symbol_right;
        $data['local']['subtotal'] = $currency_symbol_left . $currencies->fs_format($order->getCurrentOrderInfo('local')['total'], false, $order->info['currency']
                , $order->info['currency_value'])." ".$currency_symbol_right;
        $data['gift']['subtotal'] =  $order->gift_info['subtotal'];

        $data['delay']['vat'] = $order->getCurrentOrderInfo('delay')['vat'] || ($country_code == "US") ? $currency_symbol_left . $currencies->fs_format($order->getCurrentOrderInfo('delay')['vat'], false, $order->info['currency']
                , $order->info['currency_value'])." ".$currency_symbol_right : 0;
        $data['local']['vat'] = $order->getCurrentOrderInfo('local')['vat'] || ($country_code == "US") ? $currency_symbol_left . $currencies->fs_format($order->getCurrentOrderInfo('local')['vat'], false, $order->info['currency']
                , $order->info['currency_value'])." ".$currency_symbol_right : 0;

        $data['local']['vat_origin'] = $order->getCurrentOrderInfo('local')['vat'];
        $data['delay']['vat_origin'] = $order->getCurrentOrderInfo('delay')['vat'];

        $data['global']['title'] = $global_warehouse_title ;
        $data['delay']['title'] = $delay_warehouse_title;
        $data['local']['title'] = $local_warehouse_title;
        $data['gift']['title'] = $gift_warehouse_title;

        if (in_array($country_code, ['ES', 'LU', 'AT', 'PT', 'FR', 'MD', 'ME'])) {
            $data['local']['epidemic_tips'] = FS_CHECKOUT_EPIDEMIC_TIPS;
            $data['delay']['epidemic_tips'] = FS_CHECKOUT_EPIDEMIC_TIPS;
        }
        $data['local']['customs_tips'] = $local_customs_tips;
        $data['delay']['customs_tips'] = $delay_customs_tips;

        $data['local']['spec_tips'] = $is_has_spec['local_spec'] ? FS_CHECKOUT_SPEC_PRODUCTS_TIPS : '';
        $data['delay']['spec_tips'] = $is_has_spec['delay_spec'] ? FS_CHECKOUT_SPEC_PRODUCTS_TIPS : '';
        $data['delay']['buck_tips'] = $delay_buck_tips;
        $data['delay']['remote_tips'] = $remote_tips;
        $data['local']['buck_tips'] = $local_buck_tips;
        $data['local']['local_reason'] = $local_products_tip;
        $data['local']['remote_tips'] = $remote_tips;
        $data['order_num_info'] =  $order_num_info;
        $data['gift_message'] = $gift_message;
        $data['new_delay_products'] = $new_delay_products;
        $data['local_warehouse'] = $order->local_warehouse;
        $data['local']['tax_description'] = $tax_description_local;
        $data['delay']['tax_description'] = $tax_description_delay;
        return $data;
    }

    /**
     * 格式化产品信息
     * @param $products
     * @return array
     */
    public static function create_products_for_checkout($products, $order, $tag)
    {
        global $currencies;
        $productArray = array();
        if (empty($products)) {
            return $productArray;
        }
        foreach ($products as $k => $v) {
            $productArray[$k]['model'] = $v['model'];
            $productArray[$k]['qty'] = $v['qty'];
            $productArray[$k]['id'] = $v['id'];
            $productArray[$k]['heavy_tag'] = $v['heavy_tag'];
            $productArray[$k]['heavy_tag_des'] = self::get_products_heavy_tag_des($v['heavy_tag']);
            $productArray[$k]['name'] = $v['name'];
            $productArray[$k]['is_show_import_fee'] = self::isImportShow($v, $order, $tag);
            $productArray[$k]['instock'] = self::instockHtml($v,$order,$tag);
            $productArray[$k]["originPrice"] = zen_round(($v['paypal_price'] *
                $currencies->currencies[$_SESSION['currency']]['value']), 2);
            //产品税前价
            $productsPriceEach = $currencies->display_price_rate(zen_round(($v['paypal_price'] *
                    $currencies->currencies[$_SESSION['currency']]['value']), 2), $v['tax'], 1) . ($v['onetime_charges'] != 0 ? '<br />' .
                    $currencies->display_price($v['onetime_charges'], zen_get_tax_rate($v['tax_class_id']), 1) : '');
            $productArray[$k]['price'] = $productsPriceEach;

            //产品税后价
            $aftertax_products_price = $v['aftertax_price'];
            $productsPriceEach_tax = $currencies->display_price_rate(zen_round(($aftertax_products_price *
                    $currencies->currencies[$_SESSION['currency']]['value']), 2), $v['tax'], 1) . ($v['onetime_charges'] != 0 ? '<br />' .
                    $currencies->display_price($v['onetime_charges'], zen_get_tax_rate($v['tax_class_id']), 1) : '');
            $productArray[$k]['price_tax'] = $productsPriceEach_tax;

            $product_category_status = get_product_category_status((int)$v['id']);

            $product_status = get_product_staus((int)$v['id']);

            if ($product_category_status == 1 || $product_status == false) {
                $image = '<img src="' . HTTPS_IMAGE_SERVER . 'includes/templates/fiberstore/images/logo_trad.jpg" width="80" height="80">';
            } else {
                $image_src = file_exists(DIR_WS_IMAGES . $v['productImageSrc']) ? $v['productImageSrc'] : 'no_picture.gif';
                $image = get_resources_img((int)$v['id'], 80, 80, $image_src, $v['name']);
            }

            $productArray[$k]['image'] = $image;
            //把属性值存放到一个数组 组合产品有属性时查询子产品使用
            $combination_attr = array();
            if (!empty($v['attributes'])) {
                foreach ($v['attributes'] as $vv => &$kk) {
                    if ($kk['value'] == "length") {
                        $length = zen_show_product_length($kk['option'], (int)$v['id']);
                        $kk['option'] = FS_LENGTH_NAME;
                        $kk['value'] = $length;
                    }
                    if ($_SESSION['languages_code'] == 'it') {
                        $kk['value'] = '';
                    }
                    $combination_attr[] = (int)$kk['value_id'];
                }
            }
            $productArray[$k]['attributes'] = $v['attributes'];
            $option_values = '';
            if($combination_attr){
                $option_values = reorder_options_values($combination_attr);
            }
            $CompositeProducts = new classes\CompositeProducts(intval($v['id']),'',$option_values);
            $is_tax = $order->delivery['country_id'] == 13 ? true : false;
            $composite_son_product_arr = $CompositeProducts->show_products_composite($v['qty'],0,60,'',$is_tax);
            if ($composite_son_product_arr) {
                $productArray[$k]['composite'] = $composite_son_product_arr;
                //获取组合产品中无库存的所有子产品
                $CompositeProducts->CompositeRelatedInstock($order->local_warehouse,true);
                $productArray[$k]['composite_no_stock'] = $CompositeProducts->no_stock_id;
            }
        }
        return $productArray;
    }

    private static function instockHtml($products,$order,$tag){
        $warehouseName = self::warehouseName($order->local_warehouse);
        $country = $order->delivery['country_id'];
        $instock_html = '';
        $dot = $_SESSION['languages_code'] == "jp" ?  '、':", ";
        if(in_array($country,[223,172])){
            if($tag == 'local'){
                $instock_html = FS_INSTOCK.', '.$warehouseName;
            }else{
                if(sizeof($products['attributes'])){
                    $combination_attr = reorder_options_values($products['attributes']);
                    $composite_data = ['attr'=>$combination_attr];
                }
                $instock = fs_products_instock_qty_of_products_id($products['id'],
                    "CN", true, $pcs = $products['qty'], true, $composite_data);
                if($instock){
                    $instock_html = FS_INSTOCK.$dot.FS_CN_APAC;
                }else{
                    if(!empty($products['attributes'])){
                        $title = FS_CUSTOMIZED;
                    }else{
                        $title = FS_AVAILABLE;
                    }
                    $instock_html = $title.$dot.FS_CN_APAC;
                }
            }
        }
        return $instock_html;
    }
    private static function isImportShow($products,$order,$tag){
        $country = $order->delivery['country_id'];
        $instock_html = '';
        if(in_array($country,[223,172])){
            if($tag == 'local'){
                return false;
            }else{
               /*if(!$products['heavy_tag'] && !$products['is_lithium_battery']){
                   return true;
               }*/
               return true;
            }
        }
        return $instock_html;
    }

    private static function warehouseName($warehouse){
        $data = [
          40 => FS_WAREHOUSE_US,
          37 => FS_WAREHOUSE_AU,
          20 => FS_WAREHOUSE_EU,
          71 => FS_WAREHOUSE_SG,
          67 => FS_WAREHOUSE_RU,
          2 => FS_COMMON_GSP_1
        ];
        return $data[$warehouse];
    }
    /**
     * 获取产品重货描述
     * add by rebirth 2019/05/09
     *
     * @param $tag
     * @return string
     */
    private static function get_products_heavy_tag_des($tag){
        switch ($tag){
            case 1:
                return FS_HEAVY;
                break;
            case 2:
                return FS_OVERSIZED;
                break;
            default:
                return '';
        }
    }

    /**
     * @param $shippingList
     * @return string
     * 生成运费信息
     */
    public static function createShipping($shippingList, $warehouse, $country_id)
    {
        if (empty($shippingList)) {
            return "";
        }
        $html = "";
        $active = "";
        $overnight_test = "/fedexovernight|upsovernight|fedexpriorityovernight/";
        $language_pack = self::getLangugePack(false);
        $option = "";
        $defalut = "";
        $select = "";
        $languages_code = $_SESSION['languages_code'];
        if ($warehouse == 20) {
            $time_zone = $language_pack['time_zone_eu'];
            $pick_up_address = $language_pack['pick_up_address_de'];
            $time_area_morning = $language_pack['fs_js_tit_two'];
            $time_area_afternoon = $language_pack['fs_js_tit_three'];
        } else if ($warehouse == 37) {
            $time_zone = $language_pack['time_zone_au'];
            $time_area_morning = $language_pack['time_zone_area_au'];
            $pick_up_address = $language_pack['pick_up_address_au'];
            $time_area_afternoon = "";
        } else if ($warehouse == 3) {
            $time_zone = $language_pack['time_zone_us'];
            $pick_up_address = $language_pack['pick_up_address_us'];
            $time_area_morning = $language_pack['fs_js_tit_two'];
            $time_area_afternoon = $language_pack['fs_js_tit_three'];
        } else if ($warehouse == 40) {
            $time_zone = $language_pack['time_zone_us_es'];
            $pick_up_address = $language_pack['pick_up_address_us_es'];
            if($country_id == 223){
                $time_area_morning = $language_pack['fs_js_tit_dylan'].' ';
            }else{
                $time_area_morning = $language_pack['fs_js_tit_two'];
                $time_area_afternoon = $language_pack['fs_js_tit_three'];
            }
        } else {
            $time_zone = $language_pack['time_zone_us'];
            $pick_up_address = $language_pack['pick_up_address_us'];
            $time_area_morning = $language_pack['fs_js_tit_two'];
            $time_area_afternoon = $language_pack['fs_js_tit_three'];
            //选择uk 结算页面和de-en 展示一致 展示UTC/GMT+2  Yoyo 2020-04-13
//            if ($country_id == 222 && $languages_code == 'uk' || $languages_code == 'dn') {
//                $time_zone = $language_pack['time_zone_eu'];
//            }
//            if ($country_id == 222) {
//                $pick_up_address = $language_pack['pick_up_address_de'];
//            }
        }
        foreach ($shippingList as $k => $v) {
            if ($k == 0) {
                $active = "choosez choosez1";
                $tag = "&#xf021";
            } else {
                $tag = "&#xf022";
                $active = "";
            }
            if ($v['methods'] == "selfreferencezones") {
                $tit = '<div class="track_orders_wenhao"> <div class="question_bg"></div> <div class="question_text_01 leftjt"> <div class="arrow"></div> <div class="popover-content">' . $pick_up_address . '<p class="pick_title">' . FS_JS_TIT_CHECK1 . '</p> <p>' . $time_area_morning . $time_zone . '</p> <p>' . $time_area_afternoon . ($time_area_afternoon ? $time_zone : "") . '</p> </div> </div> </div>';
            } else {
                $tit = "";
            }
            if ($v['methods'] == "customzones") {
                foreach ($v['custom'] as $index=>$cutom){
                    if($index == 0){
                        $defalut = "selected";
                    }else{
                        $defalut = "";
                    }

                    if(preg_match("/fedex/i",$cutom)){
                        $freight_c = 'fedex';
                    }elseif (preg_match("/ups/i",$cutom)){
                        $freight_c = 'ups';
                    }elseif (preg_match("/dhl/i",$cutom)){
                        $freight_c = 'dhl';
                    }else{
                        $freight_c = '';
                    }

                    $option .= '<option '.$defalut.' value="'.$cutom.'" data-cop = "'.$freight_c.'">' .$cutom . '</option>';
                }
            }
            if (preg_match($overnight_test, $v['methods'])) {
                if(US_WAREHOUSE_UP){
                   $overnight_title = FS_OVERNIGHT_TITLE_UP;
                }else{
                   $overnight_title = FS_OVERNIGHT_TITLE;
                }
                $overnight_zone = '<div class="track_orders_wenhao"> 
                <div class="question_bg iconfont icon">&#xf071;</div> ' .
                    '<div class="question_text_01 leftjt"> <div class="arrow"></div> <div class="popover-content">' . $overnight_title . '</p> </div> </div> </div>';
            } else {
                $overnight_zone = "";
            }
            $img_src = self::getShippingImage($v['methods']);

            $html .= '
        <li onclick="changeShipping(this)"  data-src="' . $img_src . '" data-method="' . $v['methods'] . '" class="' . $active . ' checkout_Npro_OrderLi">   
            <div class="checkout_Npro_OrderLiTa logistics_select choosez">
                <div class="checkout_Npro_OrderLiL">          
                <span class="iconfont icon">' . $tag . '</span><span class="logistics_subTxt">' . $v["price"] . '</span>
                </div>
                <div class="checkout_Npro_OrderLiR">
                    <span class="logistics_subTxt1">' . $v['title'] . '</span>' . $tit . $overnight_zone  . '
                </div>
             </div>
        </li>';
        }
        $select = '<ul class="checkout_wap_02 checkout_only_01 checkout_Npro_OrderList02 had_checklist checkout_Npro_hideDev"><li class="checkout_Npro_echeckListLi1"><select class="checkout_Npro_select cutome_select_val" onchange="check_user_freight()" style="border-color: rgb(221, 221, 221);">'.$option.'</select></li><li> 
        <input class="cutome_account_val checkout_Npro_Input" onblur="check_user_freight()" type="text" placeholder="'.FS_CHECK_ACCOUNT.'"><div class="error_prompt"></div></li></ul>';
        return $html.$select;
    }

    /**
     * @param $shipping_method
     * @return mixed|string
     */
    public static function getShippingImage($shipping_method)
    {
        $image_reg = [
            "dhl" => "/^dhl/",
            "ems" => "/^ems/",
            "fedexground" => "/^fedexground/",
            "fedex" => "/^fedex/",
            "sf" => "/^sf/",
            "startrack" => "/^startrack/",
            "tnt" => "/^tnt/",
            "ups" => "/^ups/"
        ];
        $img = "";
        foreach ($image_reg as $k => $v) {
            if (preg_match($v, $shipping_method)) {
                $img = $k;
                break;
            }
        }
        return $img;
    }
    /**
     * 后端验证俄罗斯对公账户信息
     */
    public static function alfa_account_validate()
    {
        $data = [];
        //俄罗斯对公支付验证
        $alfa_phone = zen_db_prepare_input($_POST['alfa_phone']);
        $alfa_email = zen_db_prepare_input($_POST['alfa_email']);
        $alfa_organization = zen_db_prepare_input($_POST['alfa_organization']);
        $alfa_inn = zen_db_prepare_input($_POST['alfa_inn']);
        $alfa_kpp = zen_db_prepare_input($_POST['alfa_kpp']);
        $alfa_bic = zen_db_prepare_input($_POST['alfa_bic']);
        $alfa_legal = zen_db_prepare_input($_POST['alfa_legal_address']);
        $alfa_bank = zen_db_prepare_input($_POST['alfa_bank_name']);
        if (empty($alfa_phone) || empty($alfa_email) || empty($alfa_organization) || empty($alfa_inn)|| empty($alfa_kpp) || empty($alfa_bic) || empty($alfa_legal) || empty($alfa_bank)) {
            $data = array("status" => 403, "data" => FS_SYSTME_BUSY);
        }
        return $data;
    }

    public static function fileValidate($config)
    {
        $upload = new UploadService();

        try {
            $upload = $upload->setConfig($config);
            $savePath = $upload->getSavePath();
            if (is_dir($savePath) == false) {
                mkdir($savePath, 0777, true);
            }
            $file = new \Upload\File('paymentUploadFile', new FileSystem($savePath));
            $resValidate = $upload->newValidate($file);
            if (!$resValidate) {
                throw new \Exception('upload file error!');
            }
            $result = [];
        } catch (\Exception $e) {
            $result = ['status' => 406, "message" => FS_CHECKOUT_RU_FILE_TIPS_2];
        }

        return $result;
    }
    
    public static function fileExists($inputName = 'paymentUploadFile')
    {
        if (!isset($_FILES[$inputName])) {
            return false;
        }

        if (empty($_FILES[$inputName]['name'])) {
            return false;
        }

        if (empty($_FILES[$inputName]['size'])) {
            return false;
        }
        if (empty($_FILES[$inputName]['tmp_name'])) {
            return false;
        }

        return true;
    }
}
