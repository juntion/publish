<?php


namespace App\Services\Products;

use App\Models\Products;
use App\Models\ProductsAttributes;
use App\Models\ProductRelatedAttributes;
use App\Models\ProductRelatedAttributesRelation;
use App\Models\ProductsLength;
use App\Models\ProductsThumbImages;
use App\Models\ProductsComposite;
use App\Models\ProductsInstockCodeRelated;
use App\Models\ProductsToCategory;
use App\Models\ResourcesDownloadProducts;
use App\Services\BaseService;
use App\Models\ProductsInstockAddRelated;
use App\Models\ProductsInstock;
use App\Traits\ProductsTrait;
use App\Models\ProductsInstockCustomizedRelated;
use App\Models\AttributeCustomColumn;
use App\Traits\TableSuffixTrait;
use App\Traits\ProductsPriceTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use voku\helper\ASCII;

class BaseProductsService extends BaseService
{
    /**
     * @var object
     */
    protected $Products; //产品主表
    /**
     * @var object
     */
    protected $ProductsLength; //产品长度属性表
    /**
     * @var object
     */
    protected $ProductsAttributes; //产品属性表
    /**
     * @var object
     */
    protected $ProductsThumbImages; //产品描述
    /**
     * @var object
     */
    protected $ProductsInstockAddRelated; //主产品id 关联表
    /**
     * @var object
     */
    protected $ProductsInstock; //产品库存表
    /**
     * @var object
     */
    protected $ProductsInstockCustomizedRelated;//半成品关联表
    /**
     * @var object
     */
    protected $ProductsInstockCodeRelated; //改码关联产品表
    /**
     * @var object
     */
    protected $ProductComposite; //组合产品表
    /**
     * @var object
     */
    protected $ProductRelatedAttributes;//关联属性表
    /**
     * @var object
     */
    protected $ProductRelatedAttributesRelation;//关联属性表
    /**
     * @var object
     */
    protected $AttributeCustomColumn;//层级属性表
    /**
     * @var object
     */
    protected $ProductsToCategories;   // 产品分类表
    /**
     * @var object
     */
    protected $ResourcesDownloadProducts;   // 产品资源下载表

    public function __construct()
    {
        parent::__construct();
        $this->registerModel();
    }

    /**
     * @Notes: 将原始产品id 转换成主产品id
     *
     * @param mixed $products
     * @return array
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 11:18
     */
    protected function transMainId($products)
    {
        //$products = Arr::wrap($products);

        //如果当前 产品已经关联了主产品id 直接返回
        /*if ($this->checkIsRelatedMainId($products)) {
            return $products;
        }*/
        $products = $this->filterProducts($products);

        try {
            $data = $this->ProductsInstockAddRelated->select('model_id', 'products_id')->with(['relatedMainId' => function($query){
                $query->select(['products_id', 'model_id']);}]);

            $result = $data->whereIn('products_id', $products)->get();


            if (!$result->isEmpty()) {
                $result = $result->toArray();
                $add = [];
                $result_trans = [];
                foreach ($result as $k => $item) {
                    $result_trans[$item['products_id']] = $this->formatMainId(
                        $item['products_id'],
                        $item['related_main_id']['products_id']
                    );
                }
                if (count($result_trans) != count($products)) {
                    $selectProducts = array_keys($result_trans);
                    foreach ($products as $v) {
                        if (!in_array($v, $selectProducts)) {
                            $add[$v] = $this->formatMainId($v);
                        }
                    }
                }
                $result = $add + $result_trans;
            } else {
                $result = [];
                foreach ($products as $v) {
                    $result[$v] = $this->formatMainId($v);
                }
            }
        } catch (\Throwable $exception) {
            $result = [];
            foreach ($products as $v) {
                $result[$v] = $this->formatMainId((int)$v);
            }
        }

        return $result;
    }


    /**
     * @Notes: 检查当前产品是否有关联主产品id
     *
     * @param mixed $products
     * @return bool
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 10:12
     */
    private function checkIsRelatedMainId($products)
    {
        if (is_array($products)) {
            $check = data_get($products, '*.related_main_id');
            foreach ($check as $v) {
                if (empty($v)) {
                    return false;
                }
            }
            return true;
        }
        return true;
    }


    /**
     * @Notes: 对主产品id 进行去重处理
     *
     * @param array $products
     * @return array
     * @author: aron
     * @Date: 2020-08-17
     * @Time: 10:59
     */
    protected function uniqueRelatedId($products)
    {
        $related_main_products = array_column($products, 'related_main_id');
        $related_main_products = array_unique($related_main_products);
        return $related_main_products;
    }

    /**
     * @Notes: 注册库存查询时 使用model
     *
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 11:46
     */
    private function registerInventoryModel()
    {
        $this->ProductsInstockAddRelated = new ProductsInstockAddRelated();
        $this->ProductsInstock = new ProductsInstock();
        $this->ProductsInstockCustomizedRelated = new ProductsInstockCustomizedRelated();
        $this->ProductsInstockCodeRelated = new ProductsInstockCodeRelated();
        $this->ProductComposite = new ProductsComposite();
    }

    protected function registerModel()
    {
        // TODO: Implement registerModel() method.
        $this->registerInventoryModel();
    }


    /**
     * @Notes: 对当前产品进行 过滤 取整操作
     *
     * @param mixed $products
     * @return mixed
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 11:08
     */
    protected function filterProducts($products)
    {
        if (is_array($products)) {
            return array_map('intval', $products);
        }
        if (is_string($products) || is_numeric($products)) {
            return (int)$products;
        }
        return $products;
    }

    /**
     * @Notes: 格式化主产品id 格式
     *
     * @param int $product_id
     * @param int $related_main_id
     * @return array
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 11:08
     */
    protected function formatMainId($product_id,  $related_main_id = 0)
    {
        if (empty($related_main_id)) {
            $related_main_id = $product_id;
        }
        return [
            'related_main_id' => $related_main_id
        ];
    }

}
