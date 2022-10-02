<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductThumbImage;
use App\Models\Categories;
use App\Services\Common\CurrencyService;
use App\Services\BaseService;
use Illuminate\Database\Capsule\Manager;

class ProductService extends BaseService
{
    private $productObj;
    private $productDesObj;
    private $productThumb;
    private $categories;
    private $curr;
    private $fields=[ //主表的字段
      'products_id',
      'integer_state',
      'products_price',
      'products_image',
      'products_tax_class_id',
    ];
    private $defaultImageZie =['size_w'=>60,'size_h'=>60];
    public function __construct()
    {
        parent::__construct();
        $this->productObj = new Product();
        $this->productDesObj = new ProductDescription;
        $this->productThumb = new ProductThumbImage();
        $this->categories = new Categories();
        $this->curr = new CurrencyService();
    }
    public function setField($fields = [])
    {
        if ($fields) {
            if (!is_array($fields)) {
                $fields = [$fields];
            }
        }
        $this->fields =  array_merge($this->fields, $fields);
        return $this;
    }

    /**
     * 获取产品基本信息
     *
     * @param int $products_id
     * @param bool $is_need_thumb_image
     * @param bool $is_status
     * @return string
     */
    public function getOneProductInfo($products_id = 0, $is_need_thumb_image = false, $is_status = true)
    {
        if ($products_id) {
            $products_obj = $this->productObj
                ->with(
                    [
                        'productDescription'=>function ($query) {
                        //可以添加多个字段
                            $query->select(['products_id','products_name'])
                            ->where('language_id', $this->language_id);
                        }
                    ]
                )
                ->select($this->fields)
                ->where('products_id', $products_id);
                if($is_status){
                    $products_obj->where('products_status', 1)
                        ->where('show_type', 0);
                }
                $products_data = $products_obj->first();
            if ($products_data) {
                $products_data = $products_data->toArray();
                if ($is_need_thumb_image) {
                    $products_data['source_image'] = $this->productThumb
                        ->getThumbImagesBySize($products_id, $size_w = ['60','550'], $size_h = ['60','550']);
                } else {
                    $products_data['source_image'] = $this->productThumb
                        ->setThumbImage($this->defaultImageZie)
                        ->getResourceImage($products_data['products_id'], true);
                }

                return $products_data;
            }
        }
        return '';
    }

    /**
     * 批量获取产品的一些信息
     *
     * @param array $pids
     * @return array
     */
    public function getProductsInfo($pids = [])
    {
        if (!is_array($pids) || empty($pids)) {
            return [];
        }
        $warehouseWhere = self::fsProductsWarehouseWhere($this->countries_iso_code)['code'] . '_status';
        return $this->productObj
            ->select($this->fields)
            ->whereIn('products_id', $pids)
            ->where($warehouseWhere, 1)
            ->where('products_status', 1)
            ->where('show_type', 0)
            ->get();
    }

    /**
     * Note: 获取当前分类的所有父级分类
     * @author: Dylan
     * @Date: 2020/7/27
     *
     * @param $categories
     * @param string $categories_id
     */
    public function getAllParentsCategories(&$categories, $categories_id = '')
    {
        if ($categories_id) {
            $parent_id = $this->categories->where('categories_id', $categories_id)->first(['parent_id']);
            if ($parent_id['parent_id']) {
                $categories[sizeof($categories)] = $parent_id['parent_id'];
                if ($parent_id['parent_id'] != $categories_id) {
                    $this->getAllParentsCategories($categories, $parent_id['parent_id']);
                }
            }
        }
    }

    /**
     * Note: 得到产品当前分类
     * @author: Dylan
     * @Date: 2020/7/27
     *
     * @param string $products_id
     * @return int
     */
    public function getCurrentCategories($products_id = '')
    {
        $masterCategoriesId = 0;

        if (!$products_id) {
            return $masterCategoriesId;
        }

        $masterCategoriesId = $this->productObj
            ->where('products_status', 1)
            ->where('products_id', $products_id)
            ->get(['master_categories_id'])
            ->toArray();
        return $masterCategoriesId;
    }


    /**
     * Note: 获取产品的所有分类
     * @author: Dylan
     * @Date: 2020/6/24
     *
     * @param string $products_id
     * @return array
     */
    public function getProductsCategories($products_id = '')
    {
        $categories = [];
        if ($products_id) {
            $data = $this->getCurrentCategories($products_id);
            if ($data['master_categories_id']) {
                $this->getAllParentsCategories($categories, $data['master_categories_id']);
                $categories = array_reverse($categories);
                $categories[] = $data['master_categories_id'];
            }
        }
        return $categories;
    }

    public function getProductsModel($products_id = [])
    {
        if (!$products_id) {
            return [];
        }
        $data = $this->productObj
            ->whereIn('products_id', $products_id)
            ->get(['products_MFG_PART', 'products_model', 'products_id'])
            ->toArray();
        return $data;
    }

    public function findProductInfo($where)
    {
        $result = $this->productObj->newQuery()->where($where)->first($this->fields);

        if (!empty($result)) {
            $result = $result->toArray();
        }

        return $result;
    }


    public function getCompositeSonProducts($fms_products, $currency, $currency_value = '', $discount_rate = 1)
    {
        $son_products = explode(',', $fms_products);
        $son_products = array_filter($son_products);
        $new_son_products = array(); // 子产品数据
        $son_product_id_array = array(); // 子产品id数组
        foreach ($son_products as $key => $val) {
            $one = explode(':', $val);
            $buy_info = explode('-', $one[1]);
            $price[$key] = $this->getFormatNmber($buy_info[1], $discount_rate);

            $son_product_id_array[] = $one[0];
            $new_son_products[$one[0]] = array(
                'products_id' => $one[0],
                'qty' => $buy_info[0], //子产品数量
                'products_price' => $price[$key], //订单币种价格-单价
                'products_price_str' =>
                    $this->curr->format(
                        $price[$key],
                        2,
                        false,
                        $currency,
                        $currency_value
                    ),//订单币种格式化价格
                'image' => $this->productThumb->setThumbImage($this->defaultImageZie)
                    ->getResourceImage($one[0]),
                'products_name' => $this->getOneProductDesc($one[0]),
            );
        }

        return $new_son_products;
    }

    /**
     * $Notes: 获取澳大利亚税后价的组合子产品价格
     *
     * $author: Quest
     * $Date: 2021/1/5
     * $Time: 16:11
     * @param $fms_products
     * @param $currency
     * @param string $currency_value
     * @param int $discount_rate
     * @return array
     */
    public function getAuCompositeSonProducts($fms_products, $currency, $currency_value = '', $discount_rate = 1)
    {
        $son_products = explode(',', $fms_products);
        $son_products = array_filter($son_products);
        $new_son_products = array(); // 子产品数据
        $son_product_id_array = array(); // 子产品id数组
        foreach ($son_products as $key => $val) {
            $one = explode(':', $val);
            $buy_info = explode('-', $one[1]);
            $price[$key] = $this->getFormatNmber($buy_info[1], $discount_rate);

            $son_product_id_array[] = $one[0];
            $new_son_products[$one[0]] = array(
                'products_id' => $one[0],
                'qty' => $buy_info[0], //子产品数量
                'products_price' => $price[$key], //订单币种价格-单价
                'products_price_str' =>
                    $this->curr->format(
                        $price[$key] * 1.1,
                        2,
                        false,
                        $currency,
                        $currency_value
                    ),//订单币种格式化价格
                'image' => $this->productThumb->setThumbImage($this->defaultImageZie)
                    ->getResourceImage($one[0]),
                'products_name' => $this->getOneProductDesc($one[0]),
            );
        }

        return $new_son_products;
    }


    /**
     * 获取单个产品对应的描述信息
     *
     * @param $product_id
     * @param array $desc_filed
     * @return string
     */
    public function getOneProductDesc($product_id, $desc_filed = ['products_name'])
    {
        $p_obj = $this->productDesObj
            ->select($desc_filed)
            ->where('products_id', $product_id)
            ->where('language_id', $this->language_id)
            ->first();
        return $p_obj ? $p_obj->products_name : '';
    }

    public function getOneProductField($product_id)
    {
        return $this->productObj->select()->where('products_id', $product_id)->first($this->fields);
    }
}
