<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 2020/6/30
 * Time: 17:44
 */

namespace App\Services\Reviews;

//use App\Services\Products\ProductService;
use App\Services\Common\CommonService;
use App\Services\Products\ProductAttributeService;
use App\Services\BaseService;

class ReviewAttributeService extends BaseService
{
//    private $productsService;
    private $reviewServices;
    private $productAttributeService;
    private $commonService;
    public function __construct()
    {
        parent::__construct();
        $this->productAttributeService = new ProductAttributeService();
    }

    /**
     * Note: 是否展示Equipment Mode版块的分类
     * @author: Dylan
     * @Date: 2020/6/24
     *
     * @param string $products_id
     * @return bool
     */
    public function getReviewIsShowModel($products_id = '')
    {
        $modelCate = false;
        if ($products_id) {
            $this->commonService = new CommonService();
//            $cPath = $this->productsService->getProductsCategories($products_id);
            $cPath_array =  $this->commonService->getProductsCategories($products_id);
            $cPath = explode('_', $cPath_array);
            if (in_array($cPath[1], [3859,889,56,57,1113,2688,3857,106]) ||
                in_array($cPath[2], [3682,3683,3897,3798,3684,3685,3686,3874,2757,2845])) {
                $modelCate = true;
            }
        }
        return $modelCate;
    }

    /**
     * Note: 获取模块产品的评论属性
     * @author: Dylan
     * @Date: 2020/7/20
     *
     * @param array $relatedArr
     * @return array
     */
    public function getModelProductCategories($relatedArr = [])
    {
        $relatedArr = $relatedArr ? $relatedArr : [];
        $productsToCategories = [];
        if (!$relatedArr) {
            return $productsToCategories;
        }
        $productsToCategories = $this->productAttributeService->getModuleModelRelated($relatedArr);
        return $productsToCategories;
    }
}
