<?php

namespace App\Services\OfflineProductEOS;

use App\Services\BaseService;
use App\Models\Categories;
use App\Models\Product;


class EosService extends BaseService
{
    private $categories;
    private $productObj;
    private $keyword;
    private $warehouseCode;
    private $cid;
    public $per_nums = 9;
    public $where;
    public $block_search_categories = [3067, 3139, 3387, 3433, 3058];//搜索产品时屏蔽显示的分类
    public $block_categories = [3058];//分类显示时屏蔽显示的分类

    public function __construct($cid, $warehouseCode, $keyword = '', $per_nums = '')
    {
        parent::__construct();
        $this->cid = $cid;
        $this->keyword = $keyword;
        $this->warehouseCode = $warehouseCode;
        $this->categories = new Categories();
        $this->productObj = new Product();
        $per_nums && $this->per_nums = $per_nums;

        $this->get_sql_where();
    }

    /**
     * Note: 设置sql查询的条件
     * @Author: Bona
     * @Date: 2021/3/17
     * @Time: 11:00
     */
    public function get_sql_where()
    {
        $warehouseWhere = $this->warehouseCode . '_status';

        $where = "(p.products_status = 0 or p." . $warehouseWhere . "=0) and pd.products_name !='' and p.products_model !='' and p.products_last_modified!='' ";
        if ($this->keyword) {

            //获取被屏蔽分类下的所有子分类，在搜索关键词
            $block_Categories_arr = implode(',', $this->getSonCategoriesId($this->block_search_categories));

            $where .= ' and pc.categories_id not in (' . $block_Categories_arr . ') ';

            if (strpos($this->keyword, ',')) {
                foreach (explode(',', $this->keyword) as $v) {
                    $ids[] = (int)$v;
                }
                $where .= " and (p.products_model like '%" . $this->keyword . "%' or p.products_id in (" . implode(',', $ids) . "))";
            } elseif (is_numeric($this->keyword)) {
                $where .= " and (p.products_model like '%" . $this->keyword . "%' or p.products_id = " . (int)$this->keyword . ")";
            } else {
                $where .= " and p.products_model like '%" . $this->keyword . "%' ";
            }
        } else {
            $cid_son_arr = $this->getSonCategoriesId($this->cid, 1);

            $cid_son_arr= array_diff($cid_son_arr,$this->block_categories);

            array_unshift($cid_son_arr, (int)$this->cid);

            if (!empty($cid_son_arr)) {
                $cid_son_arr = implode(',', $cid_son_arr);
                    $where .= ' and p.master_categories_id in (' . $cid_son_arr . ')';
                    $where .= ' and pc.categories_id in (' . $cid_son_arr . ')   ';
            }
        }

        $this->where = $where;
    }

    /**
     * Note: 获取可查询到数据总条数
     * @Author: Bona
     * @Date: 2021/3/17
     * @Time: 10:41
     * @return int
     */
    public function get_total_num()
    {
        global $db;
        $sql = "select count(*) as total from products as p 
                left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id
                left join products_to_categories as pc on p.products_id = pc.products_id
                  where" . $this->where;
        $res_count = $db->Execute($sql);
        $total_num = $res_count->fields['total'];//总条数
        return (int)$total_num;
    }

    /**
     * Note: 查询下架产品
     * @Author: Bona
     * @Date: 2021/3/17
     * @Time: 10:50
     * @param $page  当前所在页面数
     * @return array
     */
    public function get_offline_products($page)
    {
        global $db;

        $begain_limit = $this->per_nums * ($page - 1);

        //默认产品图
        $image_degault_src = HTTPS_PRODUCTS_SERVER . 'includes/templates/fiberstore/images/logo_trad.jpg';
        //$image_degault_src = HTTPS_PRODUCTS_SERVER . DIR_WS_IMAGES . 'no_picture.gif';

        $sql = "select p.products_id,p.products_model,p.products_image,p.offline_replace_products_id,p.products_last_modified,pd.products_name,pc.categories_id from products as p 
                left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id
                left join products_to_categories as pc on p.products_id = pc.products_id
                where " . $this->where . " 
                order by p.products_id desc
                limit " . $begain_limit . "," . $this->per_nums;
        $result = $db->getAll($sql);
        $offlineProducts = [];

        foreach ($result as $v) {
            $offline_replace_products_arr = $this->get_replace_products_id($v['offline_replace_products_id']);
            $offline_time = $this->get_offline_time($v['products_id'], $v['products_last_modified']);
            $offlineProducts[] = [
                'products_id' => $v['products_id'],
                'products_model' => $v['products_model'],
                'products_image' => $v['products_image'] ? HTTPS_PRODUCTS_SERVER . DIR_WS_IMAGES . $v['products_image'] : $image_degault_src,
                //'products_image' =>get_resources_img($v['products_id'], 80, 80,'','','','',true),
                'products_name' => $v['products_name'],
                'categories_id' => $v['categories_id'],
                'offline_replace_products_id' => $offline_replace_products_arr['offline_replace_products_id'],
                'offline_replace_products_url' => $offline_replace_products_arr['offline_replace_products_url'],
                'offline_time' => $offline_time,
            ];
        }

        return $offlineProducts;
    }

    /**
     * Note: 获取第一个推荐产品id
     * @Author: Bona
     * @Date: 2021/3/17
     * @Time: 11:01
     * @param $offline_replace_products_id products主表中的字段
     * @return array
     */
    public function get_replace_products_id($offline_replace_products_id)
    {

        $res = [];
        if ($offline_replace_products_id) {
            $arr = explode(',', $offline_replace_products_id);
            //var_dump($arr);die;
            $products_id = $this->check_product_staus($arr);
            if ($products_id && is_numeric($products_id)) {
                $res['offline_replace_products_id'] = $products_id;
                $res['offline_replace_products_url'] = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $products_id, 'NONSSL');
            }

        }
        return $res;
    }

    /**
     * Note: 获取产品的下架时间，若无记录则获取最近的产品更新时间
     * @Author: Bona
     * @Date: 2021/3/17
     * @Time: 11:01
     * @param $products_id
     * @param $products_last_modified 当前产品最近的更新时间
     * @return string
     */
    public function get_offline_time($products_id, $products_last_modified)
    {
        global $db;
        $sql = "select time from table_upload_record where upload_url = '" . $products_id . "' order by created_at desc limit 1";
        $res = $db->getAll($sql);

        $data_formart = 'm/d/Y';
        if ($_SESSION['languages_code'] == 'de') {
            $data_formart = 'd.m.Y';
        } elseif (in_array($_SESSION['languages_code'], ['fr', 'es', 'ru', 'it'])) {
            $data_formart = 'd/m/Y';
        } elseif ($_SESSION['languages_code'] == 'jp') {
            $data_formart = 'Y-m-d';
        }

        if (!empty($res)) {//产品状态修改记录表有记录
            $offline_time = getTime($data_formart, $res[0]['time'], $_SESSION['countries_iso_code_en']);
        } else {//产品状态修改记录表无记录，获取铲平最近更新时间
            $products_last_modified = get_common_cn_time($products_last_modified);
            $offline_time = getTime($data_formart, $products_last_modified, $_SESSION['countries_iso_code_en']);
        }
        return $offline_time;
    }

    /**
     * Note: 获取当前分类下的所有子分类id
     * @Author: Bona
     * @Date: 2021/3/17
     * @Time: 11:02
     * @param string $categories_id
     * @return array
     */
    public function getSonCategoriesId($categories_id = [], $categories_status)
    {
        //判断是否为数组
        if (!is_array($categories_id)) {
            $categories_id = [(int)$categories_id];
        }

        if ($categories_status) {
            $categories_arr_son = $this->categories->where('categories_status', $categories_status)->whereIn('parent_id', $categories_id)->lists('categories_id');
        } else {
            $categories_arr_son = $this->categories->whereIn('parent_id', $categories_id)->lists('categories_id');
        }

        if (sizeof($categories_arr_son) > 0) {
            $categories_arr_son2 = $this->getSonCategoriesId($categories_arr_son);
            $categories_arr_son = array_merge($categories_arr_son, $categories_arr_son2);
        }

        $categories_arr = array_unique(array_merge($categories_id, $categories_arr_son));

        return $categories_arr;
    }

    /**
     * Note: 判断推荐产品是否下架
     * @Author: Bona
     * @Date: 2021/3/19
     * @Time: 11:22
     * @param array $products_id
     * @return bool
     */
    public function check_product_staus($products_id = [])
    {
        if (empty($products_id)) {
            return false;
        }

        $warehouseWhere = $this->warehouseCode . '_status';

        $data = $this->productObj
            ->whereIn('products_id', $products_id)
            ->get(['products_id', 'products_status', 'de_status', 'us_status', 'au_status', 'sg_status', 'ru_status'])
            ->toArray();

        foreach ($data as $v) {
            if ($v['products_status'] == 1 && $v[$warehouseWhere] == 1) {
                return $v['products_id'];
            }
        }
        return false;
    }
}