<?php

namespace App\Services\Categories;

use App\Models\Categories;
use App\Models\CategoriesDescription;
use App\Models\CategoriesLeftDisplay;
use App\Models\Product;
use App\Services\BaseService;
use App\Services\Common\AmericanBritishSpellings;
use App\Services\Common\Redis\RedisService;

class CategoryService extends BaseService
{
    private $categories;
    private $categoriesDescription;
    private $americanBritishSpellings;
    private $product;
    private $redis;
    /**
     * 默认查询字段
     * @var array
     */
    private $fields = [
        'categories_id',
        'categories_name',
        'compatible_url'
    ];
    public $is_custom;
    public $flag;

    public function __construct($is_custom = true, $flag = true)
    {
        parent::__construct();
        $this->categories = new Categories();
        $this->categoriesDescription = new CategoriesDescription();
        $this->americanBritishSpellings = new AmericanBritishSpellings();
        $this->product = new Product();
        $this->redis = new RedisService();
        $this->is_custom = $is_custom; //是否定制
        $this->flag = $flag; //是否查询更下层子级
    }

    /**
     * 设置查询字段
     * @param array $field
     * @return $this
     */
    public function setField($field = [])
    {
        if (!is_array($field)) {
            $field = [$field];
        }
        $this->fields = array_merge($this->fields, $field);
        return $this;
    }

    /**
     * 获取分类信息
     * @param $pid int
     * @param $level int
     * @return array
     */
    public function getCategories($pid = 0, $level = 1)
    {
        switch ($level) {
            case 1:
                $result = $this->getSecondCategories($pid);
                break;
            case 2:
            case 3:
                if ($this->is_custom) {
                    $result = $this->getSecondCategoriesOfCustom($pid, (int)$level);
                } else {
                    $result = $this->getSecondCategories($pid);
                }
                if ($this->flag) {
                    foreach ($result as $k => $v) {
                        $third_arr = $this->getSecondCategoriesOfCustom($v['cid'], 3);
                        if (empty($third_arr)) {
                            $third_arr = $this->getSecondCategoriesOfCustom($v['categories_id'], 3);
                        }
                        $result[$k]['third'] = $third_arr;
                    }
                }
                break;
            default:
                $result = $this->getSecondCategories($pid);
                foreach ($result as $k => $v) {
                    $second_arr = $this->getCategories($v['categories_id'], 2);
                    $result[$k]['second'] = $second_arr;
                }
                break;
        }
        return $result;
    }

    /**
     * 根据分类ID获取自定义分类相关信息
     * @param $cid int or array
     * @return array
     */
    public function getCategoriesDescriptions($cid)
    {
        $categories_info_arr = [];
        if ($cid) {
            $categories_names =  $this->categoriesDescription
                ->where('language_id', $this->language_id);
            if (!is_array($cid)) {
                $categories_names = $categories_names->where('categories_id', $cid);
            } else {
                $categories_names = $categories_names->whereIn('categories_id', $cid);
            }
            $categories_info = $categories_names->select($this->fields)->get()->toArray();
            foreach ($categories_info as $k => $v) {
                foreach ($this->fields as $field) {
                    //uk/au/dn转换成英式英语
                    if ($field == 'categories_name' && in_array($this->language_code, array('au','uk','dn'))) {
                        $categories_info_arr[$v['categories_id']][$field] = $this->americanBritishSpellings
                            ->swapAmericanToBritain($v[$field]);
                    } else {
                        $categories_info_arr[$v['categories_id']][$field] = $v[$field];
                    }
                }
            }
            return $categories_info_arr;
        }
        return $categories_info_arr;
    }

    /**
     * 获取子级分类信息
     * @param $pid int 父级ID
     * @return array
     */
    public function getSecondCategories($pid = 0)
    {
        $result = [];
        $cate_arr = $this->categories
                        ->where('categories_status', 1)
                        ->where('parent_id', (int)$pid)
                        ->where('categories_id', '<>', 3387)
                        ->orderBy('sort_order', 'asc')
                        ->lists('categories_id');
        $info_arr = $this->getCategoriesDescriptions($cate_arr);
        foreach ($cate_arr as $v) {
            $result[$v] = $info_arr[$v];
        }
        return $result;
    }

    /**
     * 获取定制的子级分类内容
     * @param $pid int
     * @param $level int
     * @return array
     */
    public function getSecondCategoriesOfCustom($pid, $level)
    {
        $result = [];
        if ($pid && $level) {
            $categoriesLeftDisplay = new CategoriesLeftDisplay();
            $result = $categoriesLeftDisplay
                ->leftJoin('categories as c', 'c.categories_id', '=', 'cld.categories_id')
                ->leftJoin('categories_description as cd', 'cd.categories_id', '=', 'cld.categories_id')
                ->where('cld.language_id', $this->language_id)
                ->where('cd.language_id', $this->language_id)
                ->where('cld.status', 1)
                ->where('cld.parent_id', (int)$pid)
                ->where('cld.level_id', (int)$level)
                ->whereRaw('IFNULL( c.is_clearing, 0 ) = 0')
                ->orderBy('sort', 'asc')
                ->select(
                    [
                        'cld.cid',
                        'cld.parent_id',
                        'cld.categories_id',
                        'cld.categories_name',
                        'cld.categories_url',
                        'cld.sort',
                        'cld.categories_red',
                        'cld.is_has_new_products',
                        'c.categories_of_image',
                        'c.warranty_period',
                        'c.return_period',
                        'c.change_period',
                        'cd.warranty_note',
                    ]
                )
                ->get()
                ->toArray();
            foreach ($result as $k => $v) {
                if (in_array($this->language_code, array('au','uk','dn'))) {
                    $result[$k]['categories_name'] = $this->americanBritishSpellings
                            ->swapAmericanToBritain($v['categories_name']);
                }
            }
            if (empty($result)) {
                return $this->getSecondCategories($pid);
            }
        }
        return $result;
    }

    /**
     * 根据子级分类ID获取父级分类ID
     * @param $cid int
     * @param $custom bool
     * @return int
     */
    public function getParentIdOfCid($cid, $custom = true)
    {
        $origin_pid = $this->categories->find($cid)->getAttribute('parent_id');
        if ($custom) {
            $categoriesLeftObj = new CategoriesLeftDisplay();
            $custom_pid = $categoriesLeftObj
                ->where('language_id', $this->language_id)
                ->where('level_id', 3)
                ->where('categories_id', (int)$cid)
                ->limit(1)
                ->pluck('parent_id');
            $pid = $categoriesLeftObj
                ->where('language_id', $this->language_id)
                ->where('level_id', 2)
                ->where('cid', $custom_pid)
                ->limit(1)
                ->pluck('categories_id');
            if ($pid) {
                return $pid;
            }
        }
        return $origin_pid;
    }

    /**
     * Note: 获取单个产品当前分类id
     * @author: Dylan
     * @Date: 2020/6/30
     *
     * @param string $products_id
     * @return string
     */
    public function getProductCurrentCategories($products_id = '')
    {
        $currentCategories = '';
        if (!$products_id) {
            return $currentCategories;
        }

        $currentCategories = $this->product
            ->where('products_id', $products_id)
            ->where('products_status', 1)
                ->lists('master_categories_id');
        return $currentCategories;
    }
}
