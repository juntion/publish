<?php


namespace App\Traits;

use App\Enums\ProjectManage\ProductStatus;
use Illuminate\Support\Collection;

trait ProductTrait
{
    protected $allProducts;

    /**
     * @return array
     */
    public function getProductTreeAttribute()
    {
        $this->allProducts = $this->products;
        if (!$this->allProducts) {
            return null;
        }
        $productLine = $this->allProducts->where('type', ProductStatus::TypeLine);
        return $this->getTree($productLine);
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
     * @return array|null
     */
    public function getProductCategoryAttribute()
    {
        $this->allProducts = $this->products;
        if (!$this->allProducts) {
            return null;
        }
        return $this->formatProducts();
    }

    /**
     * @return array
     */
    protected function formatProducts()
    {
        $result = [
            'product_line' => null,
            'product' => null,
            'product_modules' => [],
        ];
        foreach ($this->allProducts as $product) {
            if ($product->type == ProductStatus::TypeLine) {
                $result['product_line'] = $this->filterProductFields($product);
            }
            if ($product->type == ProductStatus::TypeProduct) {
                $result['product'] = $this->filterProductFields($product);
            }
            if ($product->type == ProductStatus::TypeModule) {
                $productLabels = $this->allProducts->where('parent_id', $product->id);
                $productLabels = $productLabels->map(function ($item) {
                    return $this->filterProductFields($item);
                })->values();
                $result['product_modules'][] = array_merge($this->filterProductFields($product), ['product_labels' => $productLabels]);
            }
        }
        return $result;
    }

    /**
     * @param $product
     * @return array
     */
    protected function filterProductFields($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'parent_id' => $product->parent_id,
        ];
    }
}
