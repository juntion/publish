<?php


namespace App\Services\Common;

use App\Services\BaseService;
use App\Models\Categories;
use App\Models\ProductsToCategories;

class CommonService extends BaseService
{
    private $cate_m;
    private $ptc_m;

    public function __construct()
    {
        parent::__construct();
        $this->cate_m = new Categories();
        $this->ptc_m = new ProductsToCategories();
    }

    /**
     * 根据产品id获取对应的所有分类
     * @param $products_id
     * @return string
     */
    public function getProductsCategories($products_id)
    {
        $categories = array();
        $categories_str = '';
        $categories_arr = $this->ptc_m->where('products_id', (int)$products_id)->first(['categories_id']);
        if (empty($categories_arr)) {
            return $categories_str;
        }
        $categories_arr = $categories_arr->toArray();

        if (!empty($categories_arr)) {
            $categories_id = $categories_arr['categories_id'];
            $this->getAllCategories($categories, $categories_id);

            $categories = array_reverse($categories);
            $categories_str = implode('_', $categories);
            $categories_str = !empty($categories_str) ? $categories_str . '_' . $categories_id : $categories_id;
        }

        return $categories_str;
    }

    /**
     * 根据分类id获取父级分类
     * @param $categories
     * @param $categories_id
     */
    public function getAllCategories(&$categories, $categories_id)
    {
        $p_categories_id = $this->cate_m->find($categories_id)->getAttribute('parent_id');

        if ($p_categories_id != 0) {
            $categories[] = $p_categories_id;
            if ($categories_id != $p_categories_id) {
                $this->getAllCategories($categories, $p_categories_id);
            }
        }
    }
}
