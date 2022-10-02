<?php

namespace App\Http\Controllers\ProjectManage\Appeal;

use App\Http\Controllers\Controller;
use App\ProjectManage\Models\LabelCategory;
use App\ProjectManage\Repositories\LabelCategoryRepository;
use Illuminate\Http\Request;

// 权限：产品负责人可管理标签

class LabelCategoriesController extends Controller
{
    /**
     * @var LabelCategoryRepository
     */
    private $labelCategory;

    public function __construct(LabelCategoryRepository $labelCategory)
    {
        parent::__construct();

        $this->labelCategory = $labelCategory;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'is_open' => 'required|integer|in:0,1',
            'style' => 'required|string',
            'sort' => 'integer',
        ]);
        $this->labelCategory->create($validatedData);

        return $this->success();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param LabelCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, LabelCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'is_open' => 'required|integer|in:0,1',
            'style' => 'required|string',
        ]);
        $this->labelCategory->update($category, $validatedData);

        return $this->success();
    }

    /**
     * @param LabelCategory $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(LabelCategory $category)
    {
        if ($category->labels()->exists()) {
            return $this->failedWithMessage('该分类下存在标签！');
        }
        $category->delete();
        return $this->success();
    }

    /**
     * 标签分类排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        $data = $request->validate([
            'label_categories_sort' => 'required|array',
            'label_categories_sort.*.label_category_id' => 'required|integer|exists:pm_label_categories,id',
            'label_categories_sort.*.sort' => 'required|integer',
        ]);
        $this->labelCategory->sort($data['label_categories_sort']);

        return $this->success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = $this->labelCategory->getCategories($request->input('is_open', 0));
        return $this->successWithData(compact('categories'));
    }

    /**
     * 获取分类和标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tree(Request $request)
    {
        $categories = $this->labelCategory->getCategories($request->input('is_open', 0), true);
        return $this->successWithData(compact('categories'));
    }
}
