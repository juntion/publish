<?php

namespace Modules\Tag\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Support\Response\ResponseTrait;
use Modules\ERP\Contracts\CategoryRepository;
use Modules\ERP\Contracts\ProductRepository;

class ProductController extends Controller
{
    use ResponseTrait;

    /**
     * 产品分类下拉列表
     * @param Request $request
     * @param CategoryRepository $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryList(Request $request, CategoryRepository $repository)
    {
        $result = $repository->categoryLimitList($request->input('keyword'));
        return $this->successWithData($result->pluck('description'));
    }

    /**
     * 产品下拉列表
     * @param Request $request
     * @param ProductRepository $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function productList(Request $request, ProductRepository $repository)
    {
        $result = $repository->productLimitList($request->input('keyword'));
        return $this->successWithData($result->pluck('description'));
    }
}
