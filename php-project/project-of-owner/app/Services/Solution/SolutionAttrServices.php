<?php
/**
 * Notes:
 * File name:SolutionServices
 * Create by: Quest.Wu
 * Created on: 2020/06/18 0007 16:18
 */


namespace App\Services\Solution;

use App\Models\Solution;
use App\Models\SolutionAttrBind;
use App\Models\SolutionSite;
use App\Models\SolutionSiteSpecialDescription;
use App\Services\BaseService;
use App\Services\Common\CurrencyService;
use Illuminate\Database\Capsule\Manager as DB;
use App\Services\Solution\SolutionServices;

class SolutionAttrServices extends BaseService
{
    private $sl_m;
    private $sl_attr_m;
    private $sl_site_m;
    private $sl_spedesc_m;
    private $curr_s;
    private $channel_num;
    private $sl_trans_table;
    private $sl_attr_table;
    private $sl_other_trans_table;

    public function __construct()
    {
        parent::__construct();
        $this->sl_m = new Solution();
        $this->sl_attr_m = new SolutionAttrBind();
        $this->sl_site_m = new SolutionSite();
        $this->sl_spedesc_m = new SolutionSiteSpecialDescription();
        $this->curr_s = new CurrencyService();
        $this->channel_num = 4;
        $language_code = $this->getTableLanguageCode($this->language_code);
        $this->sl_attr_table = 'solution_new_attr_trans_'.$language_code;
        $this->sl_other_trans_table = 'solution_new_other_trans_' . $language_code;
    }

    /**
     * 获取品牌属性
     * @param $site_id
     * @param int $tag_id
     * @param array $name_id 品牌的name_id一定为5, 波段可能为6,9,10
     * @param int $channel_num
     * @param int $title_type 模块描述的标题类型
     * @param bool $brand_type 区分solution_id为5的MUX
     * @return array|int
     */
    public function getSolutionSiteBrands(
        $site_id,
        $tag_id,
        $channel_num = 4,
        $name_id = [],
        $title_type = 0,
        $brand_type = false
    ) {
        $obj = $this->sl_m->select(
            'ssta.site_id',
            'ssta.tag_id',
            'sanvb.name_id as type',
            'sanvb.value_id',
            'svtr.contents as text'
        )->from('solution_new_special_site_tag_attr_bind as ssta')
            ->leftJoin('solution_new_attr_name_value_bind as sanvb', 'ssta.attr_bind_id', '=', 'sanvb.id')
            ->leftJoin('solution_new_attr_value as sav', 'sanvb.value_id', '=', 'sav.id')
            ->leftJoin($this->sl_attr_table.' as svtr', 'sav.attr_value_des', '=', 'svtr.relate_id')
            ->where('ssta.site_id', $site_id)
            ->where('ssta.tag_id', $tag_id);

        if (!empty($name_id)) {
            $obj->wherein('sanvb.name_id', $name_id);
        }

        $data = $obj->orderby('sanvb.name_id', 'desc')
            ->orderby('ssta.sort')
            ->get();
        if (empty($data)) {
            return 0;
        }
        $data = $data->toArray();

        $brand_res = $this->getSolutionBrandJumperFormat($data, $tag_id, $channel_num, $brand_type);
        if (in_array($tag_id, [4, 8])) {
            $spe_title = $this->sl_spedesc_m->select(
                'so.contents',
                'so.relate_id',
                'sd.img_link'
            )
                ->from('solution_new_site_special_description as sd')
                ->leftJoin($this->sl_other_trans_table .' as so', 'sd.title', '=', 'so.relate_id')
                ->where('sd.site_id', $site_id)
                ->where('sd.special_type', $title_type)
                ->first();

            if (empty($spe_title)) {
                $brand_res['res_arr']['title'] = [];
            } else {
                $data_spe = $spe_title->toArray();
                $brand_res['res_arr']['title'] = array(
                    'title_des' => $data_spe['contents'],
                    'title_img' => $data_spe['img_link']
                );
            }
        }
        return $brand_res;
    }

    /**
     * 获取方案属性组
     * author Quest.Wu 2020-06-19
     * @param $s_id 方案id
     * @return array|int
     */
    public function getSolutionAttr($s_id)
    {

        $data = $this->sl_m->select(
            's.id as solutin_id',
            's.default_sku',
            's.attr_name_sku',
            'sanvb.id as attr_bind_id',
            'sa.id as attr_id',
            'sa.pid as attr_pid',
            'sanvb.value_id as attr_value_id',
            'san.attr_name_des as type_id',
            'strb.contents as bubble_text',
            'svtra.contents as attr_value',
            'sntra.contents as attr_name'
        )->from('solution_new as s')
            ->leftJoin('solution_new_attr_bind as sa', 's.id', '=', 'sa.solution_id')
            ->leftJoin('solution_new_attr_name_value_bind as sanvb', 'sa.attr_bind_id', '=', 'sanvb.id')
            ->leftJoin('solution_new_attr_name as san', 'sanvb.name_id', '=', 'san.id')
            ->leftJoin('solution_new_attr_value as sav', 'sanvb.value_id', '=', 'sav.id')
            ->leftJoin('solution_new_attr_name_bind as sanb', 'sanvb.name_id', '=', 'sanb.attr_name_id')
            ->leftJoin($this->sl_attr_table.' as svtra', 'sav.attr_value_des', '=', 'svtra.relate_id')
            ->leftJoin($this->sl_attr_table.' as sntra', 'san.attr_name_des', '=', 'sntra.relate_id')
            ->leftJoin($this->sl_attr_table.' as strb', 'san.bubble_display', '=', 'strb.relate_id')
            ->where('sanb.solution_id', $s_id)
            ->where('s.id', $s_id)
            ->orderby('sanb.sort')
            ->orderby('sa.pid')
            ->orderby('sa.sort')
            ->get();
        if (empty($data)) {
            return [];
        }
        $data = $data->toArray();

        $default_sku = $data[0]['default_sku'];
        //1对应sku为两个字符,2对应sku为三个字符
        $sku_type = $data[0]['attr_name_sku'] == '1_2' ? 1 : 2;
        $default_sku_arr = explode('_', $default_sku);
        $default_channel = 4;
        $attr_arr = [];
        $attr_info_arr = [];
        $name_id = '';

        //重新构造属性数组
        foreach ($data as $s_key => $s_value) {
            $is_default = 0;

            if ($name_id != $s_value['type_id']) {
                $attr_info_arr = [];
                $name_id = $s_value['type_id'];
                $is_default = 1;
            }

            if ($name_id == 4) {
                if ($s_value['attr_pid'] == 0) {
                    $s_l_key = $s_key + 1;
                    //默认选中最后一个通道
                    if ($name_id != $data[$s_l_key]['type_id']) {
                        $is_default = 1;
                    } else {
                        $is_default = 0;
                    }
                } else {
                    if (in_array($s_value['attr_bind_id'], $default_sku_arr)) {
                        $is_default = 1;
                    } else {
                        $is_default = 0;
                    }
                }
                if ($is_default == 1) {
                    $default_channel = intval($s_value['attr_value']);
                }
            }

            switch ($name_id) {
                case 1:
                    $name_key = 'distance';
                    break;
                case 2:
                    $name_key = 'fiber';
                    break;
                case 3:
                    $name_key = 'wave';
                    break;
                case 4:
                    $name_key = 'pass';
                    break;
            };
            if ($s_value['attr_pid'] == 0) {
                $attr_arr[$name_key] = array(
                    'attr_title' => $s_value['attr_name'],
                    'bubble_display' => $s_value['bubble_text']
                );
                $is_default = $name_id == 1 ?
                    ((in_array($s_value['attr_bind_id'], $default_sku_arr)) ? 1 : 0) : $is_default;
                $attr_info_arr[] = array(
                    'attr_id' => $s_value['attr_id'],
                    'attr_value_id' => $s_value['attr_value_id'],
                    'attr_bind_id' => $s_value['attr_bind_id'],
                    'attr_info' => $s_value['attr_value'],
                    'is_default' => $is_default,
                    'fiber_info' => []
                );
                $attr_arr[$name_key]['attr_info_arr'] = $attr_info_arr;
            } else {
                //定义子属性
                foreach ($attr_arr['distance']['attr_info_arr'] as $k => $v) {
                    //损耗子属性
                    if ($name_key == 'fiber') {
                        if ($v['attr_id'] == $s_value['attr_pid']) {
                            $attr_arr['distance']['attr_info_arr'][$k]['fiber_info'][] = array(
                                'attr_id' => $s_value['attr_id'],
                                'attr_value_id' => $s_value['attr_value_id'],
                                'attr_bind_id' => $s_value['attr_bind_id'],
                                'attr_info' => $s_value['attr_value'],
                                'channel_info' => [],
                                'is_default' => (in_array($s_value['attr_bind_id'], $default_sku_arr)) ? 1 : 0
                            );
                            if ($v['is_default'] == 1) {
                                $attr_arr[$name_key] = array(
                                    'attr_title' => $s_value['attr_name'],
                                    'bubble_display' => $s_value['bubble_text']
                                );
                                $attr_info_arr[] = array(
                                    'attr_id' => $s_value['attr_id'],
                                    'attr_value_id' => $s_value['attr_value_id'],
                                    'attr_bind_id' => $s_value['attr_bind_id'],
                                    'attr_info' => $s_value['attr_value'],
                                    'is_default' => (in_array($s_value['attr_bind_id'], $default_sku_arr)) ? 1 : 0,
                                );
                                $attr_arr[$name_key]['attr_info_arr'] = $attr_info_arr;
                            }
                        }
                    }

                    //通道子属性
                    if ($name_key == 'pass') {
                        if (!empty($attr_arr['distance']['attr_info_arr'][$k]['fiber_info'])) {
                            $fiber_attr = $attr_arr['distance']['attr_info_arr'][$k]['fiber_info'];
                            foreach ($fiber_attr as $f_key => $f_info) {
                                if ($f_info['attr_id'] == $s_value['attr_pid']) {
                                    $attr_arr['distance']['attr_info_arr'][$k]['fiber_info'][$f_key]['channel_info'][] =
                                        array(
                                            'attr_id' => $s_value['attr_id'],
                                            'attr_value_id' => $s_value['attr_value_id'],
                                            'attr_bind_id' => $s_value['attr_bind_id'],
                                            'attr_info' => $s_value['attr_value'],
                                            'is_default' => (in_array($s_value['attr_bind_id'], $default_sku_arr)) ? 1 : 0
                                        );

                                    if ($f_info['is_default'] == 1 &&
                                        $attr_arr['distance']['attr_info_arr'][$k]['is_default'] == 1) {
                                        $attr_arr[$name_key] = array(
                                            'attr_title' => $s_value['attr_name'],
                                            'bubble_display' => $s_value['bubble_text']
                                        );
                                        $attr_info_arr[] = array(
                                            'attr_id' => $s_value['attr_id'],
                                            'attr_value_id' => $s_value['attr_value_id'],
                                            'attr_bind_id' => $s_value['attr_bind_id'],
                                            'attr_info' => $s_value['attr_value'],
                                            'is_default' => (in_array($s_value['attr_bind_id'], $default_sku_arr)) ? 1 : 0,
                                        );
                                        $attr_arr[$name_key]['attr_info_arr'] = $attr_info_arr;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $solution_arr = [
            'default_sku' => $default_sku,
            'solution_attr' => $attr_arr,
            'sku_type' => $sku_type,
            'default_channel' => $default_channel
        ];
        return $solution_arr;
    }

    /**
     * 方案模块跳线产品数据格式化
     * @param $data
     * @param $tag_id
     * @param $channel_num
     * @return array
     */
    public function getSolutionBrandJumperFormat($data, $tag_id, $channel_num, $brand_type = false)
    {
        if (in_array($tag_id, [4, 8])) {
            $brand_data = array(
                'wavelen' => [],
                'brand' => []
            );
            $default_brand = array();
            $default_key = 1;
            $pb_arr = [98, 99, 100, 101, 102, 103, 104, 105, 106, 107];
            foreach ($data as $v) {
                if ($tag_id == 8 && $brand_type && in_array($v['value_id'], $pb_arr)) {
                    continue;
                }
                if (in_array($v['type'], [6,9,10])) {
                    $brand_data['wavelen'][] = array(
                        'type' => $v['type'],
                        'value' => $v['value_id'],
                        'text' => $v['text'],
                        'is_default' => $default_key <= $channel_num ? 1 : 0
                    );

                    //默认前4个波段
                    if ($default_key <= $channel_num) {
                        $default_brand[] = array(
                            'w_value' => $v['value_id'],
                            'w_text' => $v['text'],
                        );
                        $default_key++;
                    }
                } else {
                    $brand_data['brand'][] = array(
                        'type' => $v['type'],
                        'value' => $v['value_id'],
                        'text' => $v['text'],
                        'is_default' => 0
                    );
                }
            }
            //默认品牌
            $brand_data['brand'][0]['is_default'] = 1;
            $default_brand_res = [];
            foreach ($default_brand as $d_k => $d_v) {
                $sort_arr = array($d_v['w_value'], $brand_data['brand'][0]['value']);
                asort($sort_arr);
                $default_brand_res[] = implode('_', $sort_arr);
            }
            $res = array(
                'res_arr' => $brand_data,
                'default_arr' => $default_brand_res
            );
        } else {
            $jumper_data = [];
            $default_jumper = [];
            if (!empty($data)) {
                foreach ($data as $v) {
                    $jumper_data[] = array(
                        'type' => $v['type'],
                        'value' => $v['value_id'],
                        'text' => $v['text'],
                        'is_default' => 0
                    );
                }

                $jumper_data[0]['is_default'] = 1;
                //单工跳线name_id为96,双工跳线name_id为97
                $default_jumper_attr = $tag_id == 6 ? 96 : 97;
                $sort_arr = array($default_jumper_attr, $jumper_data[0]['value']);
                asort($sort_arr);
                $default_jumper =  [implode('_', $sort_arr)];
            }

            $res = array(
                'res_arr' => $jumper_data,
                'default_arr' => $default_jumper
            );
        }

        return $res;
    }
}
