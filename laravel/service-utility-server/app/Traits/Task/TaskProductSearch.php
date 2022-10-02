<?php

namespace App\Traits\Task;

use App\Enums\ProjectManage\ProductStatus;
use App\Support\QueryBuilder\Filters\MayFilter;
use App\Support\QueryBuilder\Filters\MustFilter;
use Illuminate\Database\Eloquent\Builder;

Trait TaskProductSearch
{
    /**
     * 产品线的筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductLine(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeLine, $searchType);
    }

    /**
     * 产品筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductName(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeProduct, $searchType);
    }

    /**模块筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductModule(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeModule, $searchType);
    }

    /**
     * 标签筛选
     * @param Builder $builder
     * @param mixed ...$data
     * @return Builder
     */
    public function scopeProductCategory(Builder $builder, ...$data)
    {
        $type = $data[0];
        $val = $data[1];
        $searchType = $data[2];
        return $this->searchProduct($builder, $val, $type, ProductStatus::TypeCategory, $searchType);
    }

    /**
     * 产品相关
     * @param Builder $builder
     * @param $val
     * @param $type
     * @param $product_type
     * @param $searchType
     * @return Builder
     */
    protected function searchProduct(Builder $builder, $val, $type, $product_type, $searchType)
    {
        if ($searchType == 'may'){
            $builder = $builder->orWhereHas('demand', function($query)use($type, $val, $product_type){
                $query->WhereHas('products', function($q)use($type, $val, $product_type){
                    $q->where($q->qualifyColumn('type'), $product_type)->where(function ($q1)use($type, $val){
                        (new MayFilter())->getSqlByTypeAndVal($q1, $type, $val, $q1->qualifyColumn('name'));
                    });
                });
            });
        } else {
            $builder = $builder->WhereHas('demand', function($query)use($type, $val, $product_type){
                $query->WhereHas('products', function($q)use($type, $val, $product_type){
                    $q->where($q->qualifyColumn('type'), $product_type)->where(function ($q1)use($type, $val){
                        (new MustFilter())->getSqlByTypeAndVal($q1, $type, $val, $q1->qualifyColumn('name'));
                    });
                });
            });
        }
        return $builder;
    }
}
