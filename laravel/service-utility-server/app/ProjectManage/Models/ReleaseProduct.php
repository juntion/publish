<?php

namespace App\ProjectManage\Models;

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Releases\ReleaseCycle;
use App\Enums\ProjectManage\Releases\ReleaseProductStatus;
use App\Models\BaseModel;
use App\Traits\PolicyTrait;
use App\Traits\StatusLogTrait;

/**
 * 发版产品
 */
class ReleaseProduct extends BaseModel
{
    use StatusLogTrait, PolicyTrait;

    protected $table = 'pm_release_products';

    protected $fillable = [
        'name', 'status', 'release_type', 'release_day', 'online_address', 'testing_address', 'description', 'creator_id',
        'creator_name', 'updater_id', 'updater_name',
    ];

    protected $casts = [
        'online_address' => 'json',
        'testing_address' => 'json',
    ];

    protected $appends = ['status_desc', 'release_cycle'];

    // 管理员
    public function admins()
    {
        return $this->hasMany(ReleaseProductAdmin::class);
    }

    // 产品版本号
    public function versions()
    {
        return $this->hasMany(ReleaseVersion::class);
    }

    // 发版产品关联的pms产品(线)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pm_release_product_has_products');
    }

    /**
     * 返回关联的产品
     * @return $this
     */
    public function getFriendlyProducts()
    {
        $allProducts = $this->products;
        $productLines = $allProducts->where('type', ProductStatus::TypeLine)->pluck('id')->toArray();
        $result = $allProducts->filter(function ($product) use ($productLines) {
            return !in_array($product->parent_id, $productLines);
        })->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->type,
                'parent_id' => $product->parent_id,
            ];
        })->values();
        $this->friendly_products = $result;
        return $this;
    }

    public function getStatus($status)
    {
        return ReleaseProductStatus::getStatusDesc($status);
    }

    public function getReleaseCycleAttribute()
    {
        return ReleaseCycle::getReleaseCycleDesc($this);
    }
}
