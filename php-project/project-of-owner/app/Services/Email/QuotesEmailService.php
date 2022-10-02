<?php


namespace App\Services\Email;

use App\Services\BaseService;
use App\Services\Common\CurrencyService;

class QuotesEmailService extends BaseService
{
    public function getShareEmailBtn()
    {
        $html = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;" align="center">
                            <a style="font-size: 14px;display: inline-block;text-decoration: none;color: #0681d3;padding: 10px 20px;border: 1px solid #0681d3;border-radius:2px;font-family: Open Sans,arial,sans-serif;" href="'.zen_href_link('quotes_list').'">'.EMAIL_QUOTES_SUCCESS_05.'</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="10">

                        </td>
                    </tr>
                    </tbody>
                </table>';

        return $html;
    }

    public function getQuotesProductsHtml($quotes_products = [], $attributes_arr = [])
    {
        $html = '';
        $num = 1;
        foreach ($quotes_products as $p_val){
            $p_img = get_resources_img($p_val['products_id'],60,60);
            $html .= '<tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;border-top: 1px solid #e5e5e5;padding: 20px 0 ;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tbody>';
            if($num == 1) {
                $html .= '<tr>
                                        <td colspan="3" style="border-collapse: collapse;padding: 0px 0 20px 20px;font-size: 16px;font-weight: 600;color: #232323;">'.self::trans('FS_SEND_EMAIL_6').'</td>
                                            <td></td>
                                            <td></td>
                                    </tr>';
            }
            $html .=                '<tr>
                                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0px 0 20px 20px;">
                                            <a style="text-decoration: none;" href="'.zen_href_link('product_info','products_id='.$p_val['products_id']).'">
                                                '.$p_img.'
                                            </a>
                                        </td>
                                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0px 20px;">
                                            <a style="text-decoration: none;color: #232323;" href="'.zen_href_link('product_info','products_id='.$p_val['products_id']).'">
                                                <span>
                                                '.$p_val['products_name'].'
                                                </span>
                                            </a>
                                            <span style="text-decoration: none;color: #999;font-size: 13px;display: inline-block;margin-top: 5px;line-height: 22px;">#'.$p_val['products_id'].'</span>';

            if(isset($attributes_arr[$p_val['products_prid']]) && !empty($attributes_arr[$p_val['products_prid']])){
                $attributes_info = $attributes_arr[$p_val['products_prid']];

                foreach ($attributes_info as $attr_key => $attr_val){
                    if(strval($attr_key) === 'length') {
                        $html .=            '<p style="font-size: 13px;color: #8D8D8F;padding: 0;margin: 5px 0 0;line-height: 22px;">'.FS_LENGTH.': '.$attr_val['length_name'].'</p>';
                    }else{
                        $html .=            '<p style="font-size: 13px;color: #8D8D8F;padding: 0;margin: 5px 0 0;line-height: 22px;">'.$attr_val['products_options'].': '.$attr_val['products_options_values'].'</p>';
                    }
                }

            }

            $html .=                    '<p style="font-size: 14px;margin: 10px 0 0;padding:0">'.FS_INQUIRY_LIST_9.' '.$p_val['products_qty'].'</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>';
            $num++;
        }
        return $html;
    }

    public function getQuotesProductsHtmlNew($quotes_products,$currency,$currency_value)
    {
        $html = '';
        $currency_s = new CurrencyService();
        foreach ($quotes_products as $k => $p_val) {
            $p_img = get_resources_img($p_val['products_id'],60,60);
            $p_url = zen_href_link('product_info','products_id='.$p_val['products_id']);

            $products_quotes_price = $currency == 'AUD' ? $p_val['products_quotes_price'] * 1.1 : $p_val['products_quotes_price'];
            $total_quotes_price=$currency_s->format($products_quotes_price * $p_val['products_qty'],2,true,$currency,$currency_value);

            $attributes='';

            if($p_val['attributes']){
                foreach ($p_val['attributes'] as $attr_key => $attr_val){
                    $attributes.=' <p style="font-size: 13px;margin: 5px 0 0;padding:0;font-size: 13px;color: #8D8D8F;font-family: Open Sans,arial,sans-serif;line-height: 22px;"> '.$attr_val['products_options'].': '.$attr_val['products_options_values'].' </p>';
                }
            }

            $length='';

            if ($p_val['length']) {
                foreach ($p_val['length'] as $length_val) {
                    $length.=' <p style="font-size: 13px;margin: 5px 0 0;padding:0;font-size: 13px;color: #8D8D8F;font-family: Open Sans,arial,sans-serif;line-height: 22px;"> '.FS_LENGTH.': '.$length_val['length_name'].' </p>';
                }
            }

            $html.='  <tr style="border-bottom: 1px solid #f7f7f7;">
                                                    <td bgcolor="#fff" width="10.5%" align="left" valign="top"
                                                        style="border-collapse: collapse;font-family: Open Sans,arial,sans-serif;border-bottom: 1px solid #F7F7F7;padding: 15px 0;">
                                                        <a style="text-decoration: none;"
                                                            href="'.$p_url.'">
                                                            '.$p_img.'
                                                        </a>
                                                    </td>
                                                    <td bgcolor="#fff" width="40%" valign="top"
                                                        style="border-collapse: collapse;font-size: 14px;color: #19191a;line-height: 24px;font-family: Open Sans,arial,sans-serif;border-bottom: 1px solid #F7F7F7;padding: 15px 0;">
                                                        <a style="text-decoration: none;color: #19191a;"
                                                            href="'.$p_url.'">
                                                            <span>
                                                                '.$p_val['products_name'].'
                                                            </span>
                                                        </a>

                                                        '.$attributes.$length.'
                                                        <p
                                                            style="font-size: 14px;margin: 8px 0 0;padding:0;font-size: 13px;color: #646466;font-family: Open Sans,arial,sans-serif;">
                                                            #'.$p_val['products_id'].'</p>
                                                    </td>
                                                     <td bgcolor="#fff" width="9%" align="center" valign="top"
                                                        style="border-collapse: collapse;color: #19191a; font-size: 14px;line-height: 24px;font-family: Open Sans,arial,sans-serif;border-bottom: 1px solid #F7F7F7;padding: 15px 0;">
                                                        '.$p_val['products_qty'].'
                                                    </td>
                                                    <td bgcolor="#fff" width="18%" align="right" valign="top"
                                                        style="border-collapse: collapse;color: #19191a; font-size: 14px;line-height: 24px;font-family: Open Sans,arial,sans-serif;border-bottom: 1px solid #F7F7F7;padding: 15px 0;    white-space: nowrap;">
                                                       '.$p_val['products_quotes_price_text'].'
                                                    </td>
                                                   <td bgcolor="#fff" width="20%" align="right" valign="top"
                                                        style="border-collapse: collapse;color: #19191a; font-size: 14px;line-height: 24px;font-family: Open Sans,arial,sans-serif;border-bottom: 1px solid #F7F7F7;padding: 15px 0;    white-space: nowrap;">
                                                        '.$total_quotes_price.'
                                                    </td>
                                                </tr>';
        }
        return $html;
    }


}