<?php
/**
 * Notes:
 * File name:SolutionServices
 * Create by: Quest.Wu
 * Created on: 2020/06/18 0007 16:18
 */


namespace App\Services\Solution;

use App\Models\Solution;
use App\Models\SolutionProduct;
use App\Models\SolutionDescription;
use App\Models\SolutionDetailDescription;
use App\Models\SolutionSiteSkuProductBind;
use App\Models\SolutionSiteProductBind;
use App\Models\SolutionProductStationaryAttrBind;
use App\Services\Common\CurrencyService;
use App\Services\Customers\CustomerService;
use App\Services\Products\ProductService;
use Illuminate\Database\Capsule\Manager as DB;
use App\Services\Solution\SolutionAttrServices;
use App\Services\BaseService;
use Exception;

class SolutionServices extends BaseService
{
    protected $sl_m;
    private $sl_skup_m;
    private $sl_sitep_m;
    private $sl_spsa_m;
    private $sl_products_m;
    private $sl_attr_s;
    private $product_s;
    private $curr;
    private $currency_value;
    private $decimal;
    private $channel_num;
    private $special_products; //特殊产品数组标识
    private $sl_trans_table;
    private $sl_other_trans_table;
    private $cust_s;
    private $custer_rate;

    public function __construct()
    {
        parent::__construct();

        $this->sl_m = new Solution();
        $this->sl_attr_s = new SolutionAttrServices();
        $this->sl_skup_m = new SolutionSiteSkuProductBind();
        $this->sl_sitep_m = new SolutionSiteProductBind();
        $this->sl_spsa_m = new SolutionProductStationaryAttrBind();
        $this->sl_products_m = new SolutionProduct();
        $this->product_s = new ProductService();
        $this->curr = new CurrencyService();
        $this->cust_s = new CustomerService();

        $language_code = $this->getTableLanguageCode($this->language_code);
        $this->sl_trans_table = 'solution_new_trans_' . $language_code;
        $this->sl_other_trans_table = 'solution_new_other_trans_' . $language_code;

        if (!empty($this->customer_id)) {
            $this->custer_rate = $this->cust_s->getCustomerRate();
        } else {
            $this->custer_rate = 1;
        }

        $this->currency_value = $this->curr->currencies[$this->currency]['value'];
        $this->decimal = $this->curr->currencies[$this->currency]['decimal_places'];
        $this->channel_num = 4;
    }

    /**
     * 获取方案默认主信息
     * author Quest.Wu 2020-06-19
     * @param $s_id 方案id
     * @return array|int
     */
    public function getSolutionMainInfo($s_id)
    {
        //获取方案属性
        $solution_attr_info = $this->sl_attr_s->getSolutionAttr($s_id);
        $solution_atrr = $solution_attr_info['solution_attr'];
        $sku_type = $solution_attr_info['sku_type'];
        $sku_str = $solution_attr_info['default_sku'];
        if (!empty($solution_attr_info['default_channel'])) {
            $this->channel_num = $solution_attr_info['default_channel'];
        }
        //获取方案产品
        $solution_products = $this->getSolutionProducts($s_id, $sku_str);
        $solution_main = array(
            's_total' => $solution_products['s_total'],
            's_total_text' => $solution_products['s_total_text'],
            'site_body' => $solution_products['site_body'],
            's_attr' => $solution_atrr,
            'sku_type' => $sku_type,
            'channel_num' => $this->channel_num
        );

        return $solution_main;
    }

    /**
     * 获取方案所有产品信息
     * @param $s_id 方案id
     * @param $sku_str 属性组合
     * @param int $channel_num 通道数量
     * @param int $is_oeo 是否包含oeo产品
     * @return array
     */
    public function getSolutionProducts($s_id, $sku_str, $channel_num = 0, $is_oeo = 1)
    {
        $site_body = $this->getSolutionSiteBody($s_id);

        if ($channel_num != 0) {
            $this->channel_num = $channel_num;
        }
        $solution_total = 0;
        $site_class_k = 0;
        foreach ($site_body as $k => $v) {
            $site_id = $v['site_id'];
            $tag_all_arr = $v['tag_arr'];
            $site_body[$k]['site_class'] = $site_class_k == 0 ? 'SiteA' : 'SiteB';
            $site_body[$k]['label'] = [];
            $site_class_k++;

            //获取品牌组数据
            $brand_all = $this->sl_attr_s->getSolutionSiteBrands($site_id, 4, $this->channel_num);
            if (empty($brand_all['default_arr'])) {
                $sku_arr = explode('_', $sku_str);
                $brand_name_id = [5, 9];//默认是40km
                $title_type = in_array($site_id, [9, 10]) ? 40 : 0;
                foreach ($sku_arr as $sku_id) {
                    if (in_array($sku_id, [92, 128])) {//80km的name_id为101,132
                        $brand_name_id = [5, 10];
                        $title_type = 80;
                        break;
                    }
                }

                $brand_type = false;
                if ($title_type == 40 && !in_array(94, $sku_arr)) {
                    $brand_type = true;
                }
                $brand_all = $this->sl_attr_s->getSolutionSiteBrands(
                    $site_id,
                    8,
                    $this->channel_num,
                    $brand_name_id,
                    $title_type,
                    $brand_type
                );
            }
            $site_body[$k]['brand_arr'] = $brand_all['res_arr'];
            $default_brand = $brand_all['default_arr'];

            //获取单跳线数据
            $jumper_single_all = $this->sl_attr_s->getSolutionSiteBrands($site_id, 6);
            $default_s_jumper = $jumper_single_all['default_arr'];
            $site_body[$k]['jumper_s_arr'] = $jumper_single_all['res_arr'];

            //获取双跳线数据
            $jumper_double_all = $this->sl_attr_s->getSolutionSiteBrands($site_id, 7);
            $default_d_jumper = $jumper_double_all['default_arr'];
            $site_body[$k]['jumper_d_arr'] = $jumper_double_all['res_arr'];

            $products_site = [];
            $site_total = 0;
            foreach ($tag_all_arr as $tag_id_str) {
                $tag_arr = explode('_', $tag_id_str);
                $products_arr = [];
                foreach ($tag_arr as $tag_id) {
                    $default_arr = ($tag_id == 4 || $tag_id == 8) ? $default_brand :
                        ($tag_id == 6 ? $default_s_jumper : $default_d_jumper);
                    //获取站点产品
                    $products_info = $this->getSolutionSiteProducts(
                        $site_id,
                        $tag_id,
                        $sku_str,
                        $default_arr,
                        $is_oeo
                    );
                    $products = $products_info['products_data'];
                    $site_body[$k]['label'] = array_merge($site_body[$k]['label'], $products_info['short_label']);

                    if (!empty($products)) {
                        if (in_array($tag_id, [2, 3])) {
                            array_push($products_arr[0], $products);
                        } else {
                            $products_arr[] = $products;
                        }
                        $site_total += $products_info['total_price'];
                    }
                }

                switch ($tag_id_str) {
                    case '1_2_3':
                        $products_site['devices'] = $products_arr;
                        break;
                    case '4_5':
                    case '8_5':
                        $products_site['trans'] = $products_arr;
                        break;
                    case '6_7':
                    case '7':
                        $products_site['access'] = $products_arr;
                        break;
                }
            }
            $site_body[$k]['default_products'] = $products_site;
            $site_body[$k]['site_total'] = $site_total;
            $site_body[$k]['site_total_text'] = $this->curr->format(
                $site_total,
                2,
                true,
                $this->currency
            );
            $solution_total += $site_total;
        }

        $s_total_text = $this->curr->format(
            $solution_total,
            2,
            true,
            $this->currency
        );
        $solution_products = array(
            's_total' => $solution_total,
            's_total_text' => $s_total_text,
            'site_body' => $site_body
        );

        return $solution_products;
    }


    /**
     * 获取方案主体信息
     * author Quest.Wu 2020-06-20
     * @param $s_id 方案id
     * @return array|int
     */
    public function getSolutionSiteBody($s_id)
    {

        $data = $this->sl_m->select(
            'sl.id',
            'ss.id AS site_id',
            'ss.img_link',
            'spt.tag_id_str',
            'stat.contents as site_title',
            'stad.contents as site_des'
        )->from('solution_new as sl')
            ->leftJoin('solution_new_site_bind as ssb', 'sl.id', '=', 'ssb.solution_id')
            ->leftJoin('solution_new_site as ss', 'ssb.site_id', '=', 'ss.id')
            ->leftJoin('solution_new_site_product_type as spt', 'ss.id', '=', 'spt.site_id')
            ->leftJoin($this->sl_trans_table . ' as stad', 'stad.relate_id', '=', 'ss.solution_site_des')
            ->leftJoin($this->sl_trans_table . ' as stat', 'stat.relate_id', '=', 'ss.solution_site_title')
            ->where('sl.id', $s_id)
            ->get();
        if (empty($data)) {
            return [];
        }
        $data = $data->toArray();

        //格式化数据
        $main_data = [];
        foreach ($data as $v) {
            if (isset($main_data[$v['site_id']])) {
                $main_data[$v['site_id']]['tag_arr'][] = $v['tag_id_str'];
            } else {
                $main_data[$v['site_id']] = array(
                    'solution_id' => $v['id'],
                    'site_id' => $v['site_id'],
                    'site_title' => $v['site_title'],
                    'site_des' => $v['site_des'],
                    'img_link' => $v['img_link'],
                    'tag_arr' => []
                );
                $main_data[$v['site_id']]['tag_arr'][] = $v['tag_id_str'];
            }
        }

        return $main_data;
    }

    /**
     * 获取方案各个类型的产品
     * @param $site_id
     * @param $tag_id
     * @param string $sku_str
     * @param array $default_brand
     * @param int $is_oeo
     * @param int $jump_num
     * @return mixed
     */
    public function getSolutionSiteProducts(
        $site_id,
        $tag_id,
        $sku_str = '',
        $default_brand = [],
        $is_oeo = 1,
        $jump_num = 0
    ) {
        $total_price = 0;
        $short_label = [];
        $p_data = [];
        switch ($tag_id) {
            case 1://标准产品
                $res_data = $this->sl_skup_m->select('products_str')
                    ->where('tag_id', $tag_id)
                    ->where('site', $site_id)
                    ->where('sku', $sku_str)
                    ->first();
                if (!empty($res_data)) {
                    $res_data = $res_data->toArray();
                    $res_data = $res_data['products_str'];
                    $res_data = json_decode($res_data, true);
                    foreach ($res_data as $pid => $num) {
                        $p_info = $this->product_s->getOneProductInfo($pid);
                        if (!empty($p_info)) {
                            $p_info['qty'] = $num;
                            $p_info['products_price'] = $this->getFormatProductsPrice(
                                $p_info['products_price'],
                                $p_info['integer_state'],
                                $this->currency_value,
                                $this->custer_rate,
                                $this->decimal
                            );
                            $p_data[] = $p_info;

                            $specialCloum = $this->getSolutionProductsShortLabel($pid);
                            $short_label[] = $p_info['qty'] . ' x ' . $specialCloum['label'];
                            if (isset($specialCloum['special']) && $specialCloum['special']['type']) {
                                //获取EDFA 和 CMD RB 产品的数组
                                $power = $specialCloum['special']['power'] ? $specialCloum['special']['power'] : 0;
                                if (isset($this->special_products[$specialCloum['special']['type']]) &&
                                    $this->special_products[$specialCloum['special']['type']]) {
                                    $this->special_products[$specialCloum['special']['type']]['qty'] += $num;
                                    $this->special_products[$specialCloum['special']['type']]['power'] += $power;
                                } else {
                                    $this->special_products[$specialCloum['special']['type']]['qty'] = $num;
                                    $this->special_products[$specialCloum['special']['type']]['power'] = $power;
                                }
                            }
                            $total_price += $p_info['products_price'] * $p_info['qty'];
                        }
                    }
                }
                break;
            case 2://OEO产品
                //查询OEO产品
                if ($is_oeo == 1) {
                    $res_data = $this->sl_sitep_m->select('product_id')
                        ->where('tag_id', $tag_id)
                        ->where('site_id', $site_id)
                        ->first();
                    if ($res_data) {
                        $this->special_products['OEO']['qty'] = ceil($this->channel_num / 4);
                        $oeoPower = $this->getSolutionProductsShortLabel($res_data['product_id']);
                        $short_label[] = $this->special_products['OEO']['qty'] . ' x ' . $oeoPower['label'];
                        $this->special_products['OEO']['power'] = $oeoPower['special']['power'] ?
                            $oeoPower['special']['power'] : 0;
                        $p_data = $this->product_s->getOneProductInfo($res_data['product_id']);
                        if (!empty($p_data)) {
                            $p_data['products_price'] = $this->getFormatProductsPrice(
                                $p_data['products_price'],
                                $p_data['integer_state'],
                                $this->currency_value,
                                $this->custer_rate,
                                $this->decimal
                            );
                            $p_data['qty'] = ceil($this->channel_num / 4); //oeo的数量
                            $total_price += $p_data['products_price'] * $p_data['qty'];
                        }
                    }
                }
                break;
            case 5://模块单品 例:50000
                if ($is_oeo == 1) {
                    $res_data = $this->sl_sitep_m->select('product_id')
                        ->where('tag_id', $tag_id)
                        ->where('site_id', $site_id)
                        ->first()->toArray();
                    $p_data = $this->product_s->getOneProductInfo($res_data['product_id']);
                    if (!empty($p_data)) {
                        $p_data['products_price'] = $this->getFormatProductsPrice(
                            $p_data['products_price'],
                            $p_data['integer_state'],
                            $this->currency_value,
                            $this->custer_rate,
                            $this->decimal
                        );
                        $p_data['qty'] = $this->channel_num;
                        $p_label = $this->getSolutionProductsShortLabel($res_data['product_id']);
                        $short_label[] = $p_data['qty'] . ' x ' . $p_label['label'];

                        $total_price += $p_data['products_price'] * $p_data['qty'];
                    }
                }
                break;
            case 3://机箱产品
                $res_data = $this->sl_sitep_m
                    ->select('product_id')
                    ->where('tag_id', $tag_id)
                    ->where('site_id', $site_id)
                    ->get();
                $selectPro = array(); //选择产品的形式
                foreach ($res_data as $key => $val) {
                    $specialCloum = $this->getSolutionProductsShortLabel($val['product_id']);
                    if ($specialCloum['special'] && isset($specialCloum['special']['chassis'])) {
                        $selectPro[$specialCloum['special']['chassis']] = [
                            'products_id' => $val['product_id'],
                            'power' => $specialCloum['special']['power']
                        ];
                    }
                }
                //存在特殊品 EDAF CMD
                if ($this->special_products) {
                    //数量没有默认为0 计算过程中可过滤
                    $EDFA = $this->special_products['EDFA']['qty'] ? $this->special_products['EDFA']['qty'] : 0;
                    $DCM = $this->special_products['DCM']['qty'] ? $this->special_products['DCM']['qty'] : 0;
                    $OEO = $this->special_products['OEO']['qty'] ? $this->special_products['OEO']['qty'] : 0;
                    $RB = $this->special_products['RB']['qty'] ? $this->special_products['RB']['qty'] : 0;
                    //功率默认
                    $EDFAPOWER = $this->special_products['EDFA']['power'] ? $this->special_products['EDFA']['power'] : 0;
                    $DCMPOWER = $this->special_products['DCM']['power'] ? $this->special_products['DCM']['power'] : 0;
                    $OEOPOWER = $this->special_products['OEO']['power'] ? $this->special_products['OEO']['power'] : 0;
                    $RBPOWER = $this->special_products['RB']['power'] ? $this->special_products['RB']['power'] : 0;
                    //计算机箱数量
                    $classes = $OEO + $EDFA + $RB + 2 * (int)$DCM;
                    //计算其他设备的最大功率
                    $Apower = $OEO * $OEOPOWER + $EDFA * $EDFAPOWER + $RB * $RBPOWER + $DCM * $DCMPOWER;

                    if ($classes <= 4) {
                        $crateArr = $selectPro['1U']; //1U机箱数组
                    } else {
                        $crateArr = $selectPro['4U'] ? $selectPro['4U'] : array(); //4U机箱数组  有可能没有
                    }
                    //功率计算 获取机箱的功率
                    $Bpower = 1 * $crateArr['power'];
                    //可能是1U或者4U机箱的功率
                    if ($Apower > $Bpower) {
                        if ($selectPro['4U']) { //这地方存在特殊情况 solution=6 的不存在4U机箱
                            $crateArr = $selectPro['4U'];
                            //再次更新power
                            $Bpower = $crateArr['power'];
                        }
                    }

                    $p_data = $this->product_s->getOneProductInfo($crateArr['products_id']);
                    if (!empty($p_data)) {
                        $p_data['products_price'] = $this->getFormatProductsPrice(
                            $p_data['products_price'],
                            $p_data['integer_state'],
                            $this->currency_value,
                            $this->custer_rate,
                            $this->decimal
                        );
                        $p_label = $this->getSolutionProductsShortLabel($crateArr['products_id']);

                        //卡槽数量计算公式
                        if ($classes > 16) {
                            $p_data['qty'] = ceil($classes / 16);
                        } else {
                            $p_data['qty'] = 1;
                        }

                        // $Bpower 为4U机箱的功率 判断其他设备功率大于机箱功率则 +1
                        if ($selectPro['4U'] && $Apower > $Bpower*$p_data['qty']) {
                            $p_data['qty'] += 1;
                        }

                        $short_label[] = $p_data['qty'] . ' x ' . $p_label['label'];
                        $total_price += $p_data['products_price'] * $p_data['qty'];
                    }
                    $this ->special_products = []; //计算完机箱之后数组置空
                }
                break;
            case 4://模块组产品即品牌与波长的组合
            case 6://单工组产品
            case 7://双工组产品
            case 8:
                if (in_array($tag_id, [4, 8])) {
                    $add_sku = 0;
                    switch (true) {
                        case in_array($site_id, [1, 2, 3, 4]):
                            $add_sku = 130;
                            break;
                        case in_array($site_id, [5, 6, 7, 8]):
                            $add_sku = 131;
                            break;
                        case in_array($site_id, [9, 10, 11, 12]):
                            $add_sku = 132;
                            break;
                    }
                    $default_brand = $this->getCompleteBrandSku($default_brand, $add_sku);
                }

                $res_data = $this->sl_spsa_m->select('product_id')
                    ->wherein('sku', $default_brand)
                    ->get()->toArray();

                $qty = in_array($tag_id, [4, 8]) ? 1 : $this->channel_num;
                if ($tag_id == 7) {
                    $qty = empty($jump_num) ? $qty : $jump_num;
                }
                if ($tag_id == 6) {
                    $res_qty = $this->sl_skup_m->select('products_str')
                        ->where('tag_id', $tag_id)
                        ->where('site', $site_id)
                        ->where('sku', $sku_str)
                        ->first();
                    if (empty($res_qty)) {
                        $qty = $this->channel_num;
                    } else {
                        $res_qty = $res_qty->toArray();
                        $qty = $res_qty['products_str'];
                    }
                }
                $p_data = [];
                foreach ($res_data as $v) {
                    $p_info = $this->product_s->getOneProductInfo($v['product_id']);
                    if (!empty($p_info)) {
                        $p_info['products_price'] = $this->getFormatProductsPrice(
                            $p_info['products_price'],
                            $p_info['integer_state'],
                            $this->currency_value,
                            $this->custer_rate,
                            $this->decimal
                        );
                        $p_info['qty'] = $qty;
                        $p_data[] = $p_info;
                        $short_info = $this->getSolutionProductsShortLabel($v['product_id']);
                        $short_label[] = $qty . ' x ' . $short_info['label'];

                        $total_price += $p_info['products_price'] * $p_info['qty'];
                    }
                }
                break;
        }

        $result = array(
            'products_data' => $p_data,
            'short_label' => $short_label,
            'total_price' => $total_price
        );
        return $result;
    }

    /**
     * 获取改变品牌或跳线属性后的总产品
     * @param $site_body
     * @param $sku_str
     * @param int $channel_num
     * @return array
     */
    public function getSolutionBrandsProducts($site_body, $sku_str, $channel_num = 4)
    {

        $solution_label = [];
        if (empty($site_body)) {
            return $solution_label;
        }

        $total_price = 0;
        $site_price = [];
        foreach ($site_body as $site_k => $site) {
            $solution_label[$site_k] = [];
            $site_label = [];

            $solution_label[$site_k]['label'] = &$site_label[$site_k];
            $solution_label[$site_k]['price'] = &$site_price[$site_k];
            $solution_label[$site_k]['jump_arr'] = ['s_title' => '', 'd_title' => ''];
            $site_id = $site['site_id'];

            foreach ($site as $m_key => $site_module) {
                switch ($m_key) {
                    case 'devies':
                        foreach ($site_module as $p_val) {
                            $p_info = $this->product_s->getOneProductInfo($p_val['pid']);
                            $p_info['products_price'] = $this->getFormatProductsPrice(
                                $p_info['products_price'],
                                $p_info['integer_state'],
                                $this->currency_value,
                                $this->custer_rate,
                                $this->decimal
                            );

                            $p_qty = $p_val['qty'];
                            $p_label_info = $this->getSolutionProductsShortLabel($p_val['pid']);
                            $p_label = $p_qty . ' x ' . $p_label_info['label'];
                            $site_label[$site_k][] = $p_label;
                            $site_price[$site_k] += $p_info['products_price'] * $p_qty;
                        }
                        break;
                    case 'trans':
                        $brand = $site_module['brand'];
                        $brand_str = [];
                        foreach ($brand as $brand_v) {
                            asort($brand_v);
                            $brand_str[] = implode('_', $brand_v);
                        }
                        //这里默认tag_id为4, 4和8的产品查询方式一样，只是品牌参数不同而已,该场景品牌参数已确定
                        $trans_label_arr = $this->getSolutionSiteProducts(
                            $site_id,
                            4,
                            $sku_str,
                            $brand_str
                        );
                        $trans_label = $trans_label_arr['short_label'];

                        if (isset($site_module['module']) && !empty($site_module['module'])) {
                            $single_module = $site_module['module'];
                            $single_info = $this->product_s->getOneProductInfo($single_module['pid']);
                            $single_info['products_price'] = $this->getFormatProductsPrice(
                                $single_info['products_price'],
                                $single_info['integer_state'],
                                $this->currency_value,
                                $this->custer_rate,
                                $this->decimal
                            );

                            $single_qty = $single_module['qty'];
                            $single_price = $single_qty * $single_info['products_price'];
                            $single_label_info = $this->getSolutionProductsShortLabel($single_module['pid']);
                            $single_label = $single_qty . ' x ' . $single_label_info['label'];

                            array_push($trans_label, $single_label);
                            $trans_price = $trans_label_arr['total_price'] + $single_price;
                        }

                        $site_label[$site_k] = array_merge($site_label[$site_k], $trans_label);
                        $site_price[$site_k] += $trans_price;
                        break;
                    case 'access':
                        foreach ($site_module as $jump_k => $jump_info) {
                            if (!empty($jump_info)) {
                                $combo_f = $jump_k == 'jump_s' ? 96 : 97;
                                $combo_arr = [$combo_f, $jump_info['id']];
                                asort($combo_arr);
                                $combo = [implode('_', $combo_arr)];

                                $tag_id = $jump_k == 'jump_s' ? 6 : 7;
                                $jump_num = $jump_info['qty'];
                                $jump_label_arr = $this->getSolutionSiteProducts(
                                    $site_id,
                                    $tag_id,
                                    $sku_str,
                                    $combo,
                                    1,
                                    $jump_num
                                );

                                if ($jump_k == 'jump_s') {
                                    $solution_label[$site_k]['jump_arr']['s_title'] =
                                        $jump_label_arr['products_data'][0]['product_description']['products_name'];
                                } else {
                                    $solution_label[$site_k]['jump_arr']['d_title'] =
                                        $jump_label_arr['products_data'][0]['product_description']['products_name'];
                                }

                                $jump_label = $jump_label_arr['short_label'];
                                $site_label[$site_k] = array_merge($site_label[$site_k], $jump_label);
                                $site_price[$site_k] += $jump_label_arr['total_price'];
                            }
                        }
                        break;
                }
            }
            $total_price += $site_price[$site_k];
            $solution_label[$site_k]['price_text'] = $this->curr->format(
                $site_price[$site_k],
                2,
                true,
                $this->currency
            );
        }

        $total_price_text = $this->curr->format(
            $total_price,
            2,
            true,
            $this->currency
        );

        $return = array(
            'total_price' => $total_price,
            'total_price_text' => $total_price_text,
            'label' => $solution_label
        );
        return $return;
    }

    /**
     * 获取改变品牌或跳线属性后的总产品
     * @param $site_body
     * @param $sku_str
     * @return array
     * @throws Exception
     */
    public function solutionAddProductsDataCheck($site_body, $sku_str)
    {
        if (empty($site_body) || !is_array($site_body)) {
            $this->solutionAddProductsDataCheckThrow();
        }
        $products = [];
        foreach ($site_body as $site_k => $site) {
            $site_id = $site['site_id'];
            foreach ($site as $m_key => $site_module) {
                switch ($m_key) {
                    case 'devies':
                        foreach ($site_module as $p_val) {
                            $products = $this->solutionAddProductsDataAdd($products, $p_val['pid'], $p_val['qty']);
                        }
                        break;
                    case 'trans':
                        $brand = $site_module['brand'];
                        $brand_str = [];
                        foreach ($brand as $brand_v) {
                            asort($brand_v);
                            $brand_str[] = implode('_', $brand_v);
                        }
                        //这里默认tag_id为4, 4和8的产品查询方式一样，只是品牌参数不同而已,该场景品牌参数已确定
                        $trans_label_arr = $this->getSolutionSiteProducts(
                            $site_id,
                            4,
                            $sku_str,
                            $brand_str
                        );
                        if (!empty($trans_label_arr)) {
                            foreach ($trans_label_arr['products_data'] as $product) {
                                $products = $this->solutionAddProductsDataAdd(
                                    $products,
                                    $product['products_id'],
                                    $product['qty']
                                );
                            }
                        }
                        if (isset($site_module['module']) && !empty($site_module['module'])) {
                            $products = $this->solutionAddProductsDataAdd(
                                $products,
                                $site_module['module']['pid'],
                                $site_module['module']['qty']
                            );
                        }
                        break;
                    case 'access':
                        foreach ($site_module as $jump_k => $jump_info) {
                            if (!empty($jump_info)) {
                                $combo_f = $jump_k == 'jump_s' ? 96 : 97;
                                $combo_arr = [$combo_f, $jump_info['id']];
                                asort($combo_arr);
                                $combo = [implode('_', $combo_arr)];

                                $tag_id = $jump_k == 'jump_s' ? 6 : 7;
                                $jump_num = $jump_info['qty'];
                                $jump_label_arr = $this->getSolutionSiteProducts(
                                    $site_id,
                                    $tag_id,
                                    $sku_str,
                                    $combo,
                                    1,
                                    $jump_num
                                );
                                if (!empty($jump_label_arr)) {
                                    foreach ($jump_label_arr['products_data'] as $product) {
                                        $products = $this->solutionAddProductsDataAdd(
                                            $products,
                                            $product['products_id'],
                                            $product['qty']
                                        );
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        }
        return $products;
    }

    /**
     * solution 产品添加
     * @param $products
     * @param $pid
     * @param $qty
     * @return array
     */
    private function solutionAddProductsDataAdd($products, $pid, $qty)
    {
        $pid = (int)$pid;
        $qty = (int)$qty;
        if (isset($products[$pid])) {
            $products[$pid] += $qty;
        } else {
            $products[$pid] += $qty;
        }
        return $products;
    }

    /**
     * solution 批量加购错误抛出
     *
     * @param $msg
     * @throws Exception
     */
    public function solutionAddProductsDataCheckThrow($msg = '')
    {
        if (empty($msg)) {
            $msg = 'error';
        }
        throw new \Exception($msg);
    }


    /**
     * 获取产品短标签
     * @param $products_id
     * @return string
     */
    public function getSolutionProductsShortLabel($products_id)
    {
        $p_data = $this->sl_products_m
            ->select('so.contents', 'so.relate_id', 'sp.special')
            ->from('solution_new_product as sp')
            ->leftJoin($this->sl_other_trans_table . ' as so', 'so.relate_id', '=', 'sp.short_desc')
            ->where('sp.product_id', $products_id)->first();
        if (empty($p_data)) {
            $outData = '';
            $p_short_desc = 'There is no short label for this product';
        } else {
            $p_data = $p_data->toArray();
            $outData = json_decode($p_data['special'], true);
            $p_short_desc = $p_data['contents'];
        }
        $res = array(
            'label' => $p_short_desc,
            'special' => $outData
        );

        return $res;
    }

    /***
     * @note:判断是否为普通产品中的特殊产品标识 EDFA,CDM 产品
     *
     * protected function getCommonSpecialProducts($pid,$cloum = ''){
     * $proData = $this ->sl_products_m
     * ->select('special')
     * ->where('product_id',$pid)
     * ->first();
     *
     * if (!$proData || !$proData['special']){
     * return [];
     * }
     *
     * $outData = json_decode($proData['special'],true);
     * if ($cloum){
     * return $outData[$cloum] ? $outData[$cloum] : 0;
     * }
     * return $outData; //返回特殊产品相关属性值数组
     * }*/

    /***
     * @note 获取翻译描述信息 paul add
     */
    protected function getTranDescription($object, $colum = '')
    {
        if (!is_object($object)) {
            return '';
        }
        //判断对象是否归属于SolutionDescription则
        $modelActionArr = array();
        if ($object instanceof SolutionDescription) {
            $modelActionArr = array(
                'en' => 'SolutionTransEn',
                'jp' => 'SolutionTransJp',
                'es' => 'SolutionTransEs',
                'mx' => 'SolutionTransEs',
                'fr' => 'SolutionTransFr',
                'de' => 'SolutionTransDe',
                'ru' => 'SolutionTransRu',
                'it' => 'SolutionTransIt',
            );
        }
        //判断对象是否归属于Solution则
        if ($object instanceof Solution) {
            if ($colum == 'model') {
                $modelActionArr = array(
                    'en' => 'SolutionModelTransEn',
                    'jp' => 'SolutionModelTransJp',
                    'es' => 'SolutionModelTransEs',
                    'mx' => 'SolutionModelTransEs',
                    'fr' => 'SolutionModelTransFr',
                    'de' => 'SolutionModelTransDe',
                    'ru' => 'SolutionModelTransRu',
                    'it' => 'SolutionModelTransIt',
                );
            } else {
                $modelActionArr = array(
                    'en' => 'SolutionTransEn',
                    'jp' => 'SolutionTransJp',
                    'es' => 'SolutionTransEs',
                    'mx' => 'SolutionTransEs',
                    'fr' => 'SolutionTransFr',
                    'de' => 'SolutionTransDe',
                    'ru' => 'SolutionTransRu',
                    'it' => 'SolutionTransIt',
                );
            }
        }
        //判断对象是否归属于SolutionDetailDescription则
        if ($object instanceof SolutionDetailDescription) {
            $modelActionArr = array(
                'en' => 'SolutionOtherTransEn',
                'jp' => 'SolutionOtherTransJp',
                'es' => 'SolutionOtherTransEs',
                'mx' => 'SolutionOtherTransEs',
                'fr' => 'SolutionOtherTransFr',
                'de' => 'SolutionOtherTransDe',
                'ru' => 'SolutionOtherTransRu',
                'it' => 'SolutionOtherTransIt',
            );
        }
        //可增加绑定其他类

        if (empty($modelActionArr)) {
            return '';
        }

        $modelAction = isset($modelActionArr[$_SESSION['languages_code']]) ?
            $modelActionArr[$_SESSION['languages_code']] : $modelActionArr['en'];

        $outContent = $object->$modelAction()->first()->contents;
        return $outContent ? $outContent : '';
    }

    /**
     * 获取方案下的所有站点和产品
     *
     * @param $sid
     * @return array
     */
    public function getSolutionAllSiteAndProducts($sid)
    {
        $warehouseWhere = self::fsProductsWarehouseWhere($this->countries_iso_code)['code'] . '_status';
        $products = $this->sl_m
            ->select(
                'sl.id',
                'ssb.site_id',
                'sspb.product_id'
            )->from('solution_new as sl')
            ->leftJoin('solution_new_site_bind as ssb', 'sl.id', '=', 'ssb.solution_id')
            ->leftJoin('solution_new_site_product_bind as sspb', 'ssb.site_id', '=', 'sspb.site_id')
            ->leftJoin('products as p', 'sspb.product_id', '=', 'p.products_id')
            ->where('sl.id', $sid)
            ->where('sl.is_show', 1)
            ->where('p.' . $warehouseWhere, 1)
            ->where('p.products_status', 1)
            ->where('p.show_type', 0)
            ->get();
        $return = [];
        foreach ($products as $product) {
            $return[$product->site_id][] = $product->product_id;
        }
        return $return;
    }


    public function getCompleteBrandSku($brand_arr, $add_sku)
    {
        if (empty($add_sku)) {
            return $brand_arr;
        }

        $res_arr = [];
        foreach ($brand_arr as $b_value) {
            $b_arr = explode('_', $b_value);
            $b_arr[] = $add_sku;
            sort($b_arr);
            $res_arr[] = implode($b_arr, '_');
        }
        return $res_arr;
    }

    /**
     * 获取solutions页面
     * @param $solution_id
     * @return array
     */
    public function getSolutionMetaDes($solution_id)
    {
        $metaData = array();
        if (!$solution_id) {
            return [];
        }
        switch ($solution_id) {
            case '1':
                $title = self::trans('FS_SOLUTION_META_TITLE_O1');
                $description = self::trans('FS_SOLUTION_META_DESCRIPTION_O1');
                break;
            case '2':
                $title = self::trans('FS_SOLUTION_META_TITLE_O2');
                $description = self::trans('FS_SOLUTION_META_DESCRIPTION_O2');
                break;
            case '3':
                $title = self::trans('FS_SOLUTION_META_TITLE_O3');
                $description = self::trans('FS_SOLUTION_META_DESCRIPTION_O3');
                break;
            case '4':
                $title = self::trans('FS_SOLUTION_META_TITLE_O4');
                $description = self::trans('FS_SOLUTION_META_DESCRIPTION_O4');
                break;
            case '5':
                $title = self::trans('FS_SOLUTION_META_TITLE_O5');
                $description = self::trans('FS_SOLUTION_META_DESCRIPTION_O5');
                break;
            case '6':
                $title = self::trans('FS_SOLUTION_META_TITLE_O6');
                $description = self::trans('FS_SOLUTION_META_DESCRIPTION_O6');
                break;
            default:
                $title = '';
                $description = '';
                break;
        }
        $metaData = array(
            'meta_title' => $title,
            'meta_description' => $description,
        );
        return $metaData;
    }
}
