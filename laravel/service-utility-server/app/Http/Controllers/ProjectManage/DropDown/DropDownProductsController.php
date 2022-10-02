<?php

namespace App\Http\Controllers\ProjectManage\DropDown;

use App\Enums\ProjectManage\ProductStatus;
use App\Http\Controllers\Controller;
use App\ProjectManage\Repositories\DropDownProductRepository;

class DropDownProductsController extends Controller
{
    private $dropDownProduct;

    public function __construct(DropDownProductRepository $repository)
    {
        parent::__construct();

        $this->dropDownProduct = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productLine()
    {
        $products = $this->dropDownProduct->getProductsByType();
        return $this->successWithData(compact('products'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productName()
    {
        $products = $this->dropDownProduct->getProductsByType(ProductStatus::TypeProduct);
        return $this->successWithData(compact('products'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function productModule()
    {
        $products = $this->dropDownProduct->getProductsByType(ProductStatus::TypeModule);
        return $this->successWithData(compact('products'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function moduleCategory()
    {
        $products = $this->dropDownProduct->getProductsByType(ProductStatus::TypeCategory);
        return $this->successWithData(compact('products'));
    }
}
