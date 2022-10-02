<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\ProductStatus;
use App\ProjectManage\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class ProductTreeRepository extends BaseRepository
{
    protected $model;

    private $allProducts;

    protected $allowedScopeSearches = ['keyword'];
    protected $allowedMust = ['status', 'created_at', 'description'];
    protected $allowedScopeMust = ['productLine', 'productName', 'productModule', 'productCategory', 'productManager', 'designMainManager', 'devManager', 'testManager', 'productMembers', 'interactionManager', 'visualManager', 'frontEndManager', 'mobileManager', 'UIManager'];

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    // 获取产品线数据
    public function tree()
    {
        $columns = ['id', 'name', 'status', 'description', 'type', 'parent_id', 'sort'];
        $products = $this->select($columns)
            ->with('teams')
            ->orderBy('status', 'desc')
            ->orderBy('sort', 'asc')
            ->getModels();
        if (request()->anyFilled(['may', 'must', 'search'])) {
            $this->allProducts = collect($this->allProducts)
                ->merge($products)
                ->merge($this->getChildren($products, $columns, 'teams'))
                ->merge($this->getParents($products, $columns, 'teams'))
                ->unique('id');
        } else {
            $this->allProducts = $products;
        }
        $productLines = $this->allProducts->where('type', ProductStatus::TypeLine);
        return $this->getTree($productLines);
    }

    /**
     * 产品线树结构
     * @param Collection $collection
     * @param string $keySub
     * @return array
     */
    protected function getTree(Collection $collection, $keySub = 'children')
    {
        $tree = [];
        foreach ($collection as $item) {
            $item->team_principal_users = $item->getTeamPrincipalUsers($item->teams);
            $tmp = [];
            if ($item->type != ProductStatus::TypeCategory) {
                $children = $this->allProducts->where('parent_id', $item->id);
                $tmp = $this->getTree($children);
            }
            $tree[] = array_merge($item->toArray(), [$keySub => $tmp]);
        }
        return $tree;
    }

    /**
     * 查找产品维护数据父级
     * @param Collection $products
     * @param array $select
     * @param array $with
     * @return Collection
     * @author: King
     * @version: 2019/12/26 10:19
     */
    public function getParents(Collection $products, $select = ['*'], $with = [])
    {
        return $this->recursionProducts($products, 'parent_id', 'id', $select, $with);
    }

    /**
     * 查找产品维护数据子级
     * @param Collection $products
     * @param array $select
     * @param array $with
     * @return Collection
     * @author: King
     * @version: 2019/12/26 10:19
     */
    public function getChildren(Collection $products, $select = ['*'], $with = [])
    {
        return $this->recursionProducts($products, 'id', 'parent_id', $select, $with);
    }

    /**
     * 递归查找产品维护数据
     * @param Collection $products
     * @param $pluck
     * @param $column
     * @param array $select
     * @param array $with
     * @return Collection
     * @author: King
     * @version: 2019/12/26 10:18
     */
    public function recursionProducts(Collection $products, $pluck, $column, $select = ['*'], $with = [])
    {
        $data = collect();
        $ids = $products->pluck($pluck)->unique();
        if ($ids->count() > 1 || ($ids->count() == 1 && $ids->first() > 0)) {
            $products = $this->model->newQuery()
                ->select($select)
                ->with($with)
                ->whereIn($column, $ids)
                ->get();
            $data = $data->merge($products);
            $data = $data->merge($this->recursionProducts($products, $pluck, $column, $select, $with));
        }
        return $data;
    }
}
