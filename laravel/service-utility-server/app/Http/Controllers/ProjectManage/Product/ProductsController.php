<?php

namespace App\Http\Controllers\ProjectManage\Product;

use App\Enums\ProjectManage\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManage\Product\ProductTeamMemberBinding;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Repositories\ProductRepository;
use App\ProjectManage\Repositories\ProductTreeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $product;

    public function __construct(ProductRepository $product)
    {
        parent::__construct();

        $this->product = $product;
    }

    /**
     * 添加产品线
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'products' => 'array',
            'products.*.name' => 'string',
            'products.*.description' => 'string',
        ]);
        $this->product->create($data);

        return $this->success();
    }

    /**
     * 添加产品线的产品
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProducts(Request $request, Product $product)
    {
        if ($product->type != ProductStatus::TypeLine) {
            return $this->failedWithMessage('请输入正确的产品线ID');
        }
        $data = $request->validate([
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.description' => 'required|string',
        ]);
        $this->product->addProducts($product, $data);

        return $this->success();
    }

    /**
     * 产品排序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        $data = $request->validate([
            'products_sort' => 'required|array',
            'products_sort.*.product_id' => 'required|integer|exists:pm_products,id',
            'products_sort.*.sort' => 'required|integer',
        ]);
        $this->product->sort($data['products_sort']);

        return $this->success();
    }

    /**
     * 产品团队负责人绑定
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function teams(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_user_id' => 'integer|exists:users,id',
            'design_user_id' => 'integer|exists:users,id',
            'dev_user_id' => 'integer|exists:users,id',
            'test_user_id' => 'integer|exists:users,id',
            'frontend_user_id' => 'integer|exists:users,id',
            'mobile_user_id' => 'integer|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $this->product->teams($product, $data);
        } catch (\Exception $e) {
            logger()->error($e);
            DB::rollBack();
            return $this->failedWithMessage($e->getMessage());
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 获取产品负责人或团队绑定数据
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeams(Product $product)
    {
        $result = $this->product->getTeams($product);
        return $this->successWithData($result);
    }

    /**
     * 获取默认设计团队成员
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDesignTeamMembers(Request $request, Product $product)
    {
        $users = $this->product->getDefaultDesignTeamMembers($product);
        return $this->successWithData(compact('users'));
    }

    /**
     * 产品团队负责人和成员绑定
     * @param ProductTeamMemberBinding $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function members(ProductTeamMemberBinding $request, Product $product)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $this->product->members($product, $data);
        } catch (\Exception $e) {
            logger()->error($e);
            DB::rollBack();
            return $this->failedWithMessage($e->getMessage());
        }
        DB::commit();

        return $this->success();
    }

    /**
     * 编辑产品名称
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function name(Request $request, Product $product)
    {
        $data = $request->validate(['name' => 'required|string']);
        $this->product->update($product, $data);
        return $this->success();
    }

    /**
     * 编辑产品线或产品的说明
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function description(Request $request, Product $product)
    {
        $data = $request->validate(['description' => 'required|string']);
        $this->product->update($product, $data);
        return $this->success();
    }

    /**
     * 添加产品线的模块
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function modules(Request $request, Product $product)
    {
        if ($product->type != ProductStatus::TypeProduct) {
            return $this->failedWithMessage('请输入正确的产品ID');
        }
        $data = $request->validate([
            'modules' => 'required|array',
            'modules.*.name' => 'required|string',
            'modules.*.description' => 'required|string',
        ]);
        $this->product->modules($product, $data['modules']);

        return $this->success();
    }

    /**
     * 编辑产品模块
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyModules(Request $request, Product $product)
    {
        if ($product->type != ProductStatus::TypeModule) {
            return $this->failedWithMessage('请输入正确的模块ID');
        }
        $data = $request->validate([
            'status' => 'required|integer|in:0,1',
            'description' => 'required|string',
        ]);
        $this->product->status($product, $data);

        return $this->success();
    }

    /**
     * 添加产品模块分类标签
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function labels(Request $request, Product $product)
    {
        if ($product->type != ProductStatus::TypeModule) {
            return $this->failedWithMessage('请输入正确的模块ID');
        }
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $this->product->labels($product, $data);

        return $this->success();
    }

    /**
     * 编辑产品模块分类标签名称
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function labelName(Request $request, Product $product)
    {
        if ($product->type != ProductStatus::TypeCategory) {
            return $this->failedWithMessage('请输入正确的分类标签ID');
        }
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $this->product->update($product, $data);

        return $this->success();
    }

    /**
     * 删除产品模块分类标签
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteLabel(Product $product)
    {
        if ($product->type != ProductStatus::TypeCategory) {
            return $this->failedWithMessage('请输入正确的产品分类标签ID');
        }
        if ($product->appeals()->exists()) {
            return $this->failedWithMessage('该产品分类标签已与诉求关联，无法删除！');
        }
        if ($product->demands()->exists()) {
            return $this->failedWithMessage('该产品分类标签已与需求关联，无法删除！');
        }
        $product->delete();

        return $this->success();
    }

    /**
     * 获取产品状态变更日志
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusLogs(Product $product)
    {
        return $this->successWithData(['status_logs' => $product->logs()]);
    }

    /**
     * 产品线和产品的开启或关闭
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, Product $product)
    {
        $data = $request->validate([
            'status' => 'required|integer|in:0,1',
            'comment' => 'string|max:255',
        ]);
        $this->product->status($product, $data);

        return $this->success();
    }

    /**
     * 获取产品线数据
     * @param ProductTreeRepository $productTree
     * @return \Illuminate\Http\JsonResponse
     */
    public function tree(ProductTreeRepository $productTree)
    {
        $products = $productTree->tree();
        return $this->successWithData(compact('products'));
    }

    /**
     * 获取产品线列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $request->validate([
            'product_id' => 'integer|exists:pm_products,id',
        ]);
        $products = $this->product->list($request);
        return $this->successWithData(compact('products'));
    }
}
