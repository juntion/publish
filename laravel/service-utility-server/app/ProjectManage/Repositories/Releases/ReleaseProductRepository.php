<?php

namespace App\ProjectManage\Repositories\Releases;

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Releases\ReleaseProductStatus;
use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Models\User;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\ReleaseProduct;
use App\ProjectManage\Models\ReleaseProductAdmin;
use App\ProjectManage\Models\ReleaseVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReleaseProductRepository
{
    /**
     * 添加发版产品
     * @param array $data
     */
    public function store($data)
    {
        $user = Auth::user();
        $data['status'] = ReleaseProductStatus::ON;
        $data['online_address'] = isset($data['online_address']) ? collect($data['online_address'])->unique()->toArray() : null;
        $data['testing_address'] = isset($data['testing_address']) ? collect($data['testing_address'])->unique()->toArray() : null;
        $data['creator_id'] = $user->id;
        $data['creator_name'] = $user->name;
        $data['updater_id'] = $user->id;
        $data['updater_name'] = $user->name;
        $releaseProduct = ReleaseProduct::create($data);
        $this->relationUpdate($data, $releaseProduct);
    }

    /**
     * 管理员和产品关联更新
     * @param $data
     * @param ReleaseProduct $releaseProduct
     */
    protected function relationUpdate($data, ReleaseProduct $releaseProduct): void
    {
        // 管理员
        $admins = User::query()->whereIn('id', $data['admin_ids'])->get();
        $admins->map(function (User $admin) use ($releaseProduct) {
            $releaseProduct->admins()->create([
                'user_id' => $admin->id,
                'user_name' => $admin->name,
            ]);
        });
        // 关联产品
        // 产品线的产品全选时，需要把产品线ID也传过来；没有全选产品，不要传产品线ID
        // 返回产品关联时，产品线全选的只返回产品线，该产品线下的产品不展示
        $products = Product::query()->whereIn('id', $data['product_ids'])->get();
        $products->map(function (Product $product) use ($releaseProduct) {
            $this->attachProduct($releaseProduct, $product);
        });
    }

    /**
     * 关联pms产品
     * @param ReleaseProduct $releaseProduct
     * @param Product $product
     * @throws InvalidParameterException
     */
    protected function attachProduct(ReleaseProduct $releaseProduct, Product $product)
    {
        if ($product->status == ProductStatus::STATUS_OFF) {
            throw new InvalidParameterException('不能关联已关闭的产品');
        }
        $releaseProduct->products()->attach($product, ['product_type' => $product->type]);
    }

    /**
     * 更新发版产品
     * @param ReleaseProduct $releaseProduct
     * @param array $data
     */
    public function update(ReleaseProduct $releaseProduct, array $data)
    {
        $user = Auth::user();
        $data['online_address'] = isset($data['online_address']) ? collect($data['online_address'])->unique()->toArray() : null;
        $data['testing_address'] = isset($data['testing_address']) ? collect($data['testing_address'])->unique()->toArray() : null;
        $data['updater_id'] = $user->id;
        $data['updater_name'] = $user->name;
        $releaseProduct->update($data);
        // 关联更新
        $releaseProduct->admins()->delete();
        $releaseProduct->products()->detach();
        $this->relationUpdate($data, $releaseProduct);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(Request $request)
    {
        $query = ReleaseProduct::query();
        if ($request->has('is_open')) {
            $query->where('status', $request->input('is_open'));
        }
        if ($adminId = $request->input('admin_id')) {
            $query->whereHas('admins', function ($q) use ($adminId) {
                $q->where('user_id', $adminId);
            });
        }
        $releaseProducts = $query->with(['admins', 'products'])->orderBy('status', 'desc')->orderBy('id', 'desc')->get();
        foreach ($releaseProducts as $releaseProduct) {
            $releaseProduct->append(['policies']);
            $releaseProduct->getFriendlyProducts();
            $releaseProduct->product_ids = $releaseProduct->products->pluck('id')->toArray();
            unset($releaseProduct->products);
        }
        return $releaseProducts;
    }

    /**
     * 发版产品详情
     * @param ReleaseProduct $releaseProduct
     * @return ReleaseProduct
     */
    public function details(ReleaseProduct $releaseProduct)
    {
        $releaseProduct->load(['admins', 'products',
            'versions' => function ($query) {
                $query->orderBy('id', 'desc');
            }]);
        $releaseProduct->append(['policies']);
        $releaseProduct->getFriendlyProducts();
        $releaseProduct->product_ids = $releaseProduct->products->pluck('id')->toArray();
        unset($releaseProduct->products);
        return $releaseProduct;
    }

    /**
     * 删除发版产品及其版本信息
     * @param ReleaseProduct $releaseProduct
     * @return bool
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function delete(ReleaseProduct $releaseProduct)
    {
        // 判断该产品下是否存在已纳入的功能点
        $releaseProduct->load(['versions' => function ($query) {
            $query->whereHas('designSubTasks')->orWhereHas('devSubTasks');
        }]);
        if ($releaseProduct->versions->isNotEmpty()) {
            $versionsNum = $releaseProduct->versions->map(function ($item) {
                return $item->full_version;
            })->toArray();
            $errMsg = '该发版产品下，' . implode('、', $versionsNum) . ' 已纳入功能点，请先将功能点移除.';
            throw new InvalidStatusException($errMsg);
        }
        // 二次确认
        /*$isConfirmed = request()->input('is_confirmed');
        if (!$isConfirmed) {
            throw new InvalidParameterException("确认后将删除{$releaseProduct->name}及其所有版本号信息，且无法撤销操作！");
        }*/
        $releaseProduct->versions()->delete();
        $releaseProduct->delete();
        return true;
    }

    /**
     * @param ReleaseProduct $releaseProduct
     * @param $data
     * @throws InvalidStatusException
     */
    public function status(ReleaseProduct $releaseProduct, $data)
    {
        if ($data['status'] == ReleaseProductStatus::OFF) {
            $releaseProduct->load(['versions' => function ($query) {
                $query->where('status', '!=', ReleaseVersionStatus::ONLINE);
            }]);
            if ($releaseProduct->versions->isNotEmpty()) {
                $versionsNum = $releaseProduct->versions->map(function ($version) {
                    return $version->full_version;
                })->toArray();
                $errMsg = "存在" . implode('、', $versionsNum) . "版本未完成发布上线，不可关闭";
                throw new InvalidStatusException($errMsg);
            }
        }
        $releaseProduct->update($data);
    }

    /**
     * 添加发版计划
     * @param ReleaseProduct $releaseProduct
     * @param $data
     */
    public function addVersions(ReleaseProduct $releaseProduct, $data)
    {
        $creator = Auth::user();
        $versionPlan = $data['version_plan'];
        foreach ($versionPlan as $item) {
            $item['creator_id'] = $creator->id;
            $item['creator_name'] = $creator->name;
            $item['status'] = ReleaseVersionStatus::TO_TEST;
            $versionInfo = collect($item)->only(['main_version', 'second_version', 'third_version'])->toArray();
            $exists = $releaseProduct->versions()->where($versionInfo)->exists();
            if ($exists) {
                throw new InvalidParameterException('版本不能重复');
            }
            $releaseProduct->versions()->create($item);
        }
    }

    /**
     * 发版产品的版本号记录
     * @param ReleaseProduct $releaseProduct
     * @return array
     */
    public function versionList(ReleaseProduct $releaseProduct)
    {
        $releaseProduct->load([
            'versions' => function ($query) {
                if ($releaseYear = request()->input('year')) {
                    $query->where(function ($q) use ($releaseYear) {
                        $date = [
                            $releaseYear . '-01-01 00:00:00',
                            $releaseYear . '-12-31 23:59:59',
                        ];
                        $q->whereBetween('created_at', $date)->orWhereBetween('release_online_time', $date);
                    });
                }
                $query->orderByVersion();
            },
            'versions.product.admins',
        ]);
        $versions = [];
        foreach ($releaseProduct->versions as $version) {
            $version->append('policies');
            $version = $version->toArray();
            unset($version['product']);
            $versions[] = $version;
        }
        return $versions;
    }

    /**
     * 管理员下拉选项
     */
    public function admins()
    {
        return ReleaseProductAdmin::query()->select(['user_id', 'user_name',])->distinct()
            ->orderBy('user_name', 'asc')->get();
    }

    /**
     * 发版产品统计
     * @return array
     */
    public function statistics()
    {
        $productCount = ReleaseProduct::query()
            ->selectRaw('count(*) as total, count(if(status=0, 1, null)) as close, count(if(status=1, 1, null)) as open')
            ->get();
        $productCount->map(function (ReleaseProduct $product) {
            $product->setAppends([]);
        });
        $versions = ReleaseVersion::query()->where(function ($query) {
            $query->whereHas('designSubTasks', function ($query) {
                $query->where('product_confirmed', 0)->whereHas('task', function ($q) {
                    $q->where($q->qualifyColumn('promulgator_id'), Auth::id());
                });
            })->orWhereHas('devSubTasks', function ($query) {
                $query->where('product_confirmed', 0)->whereHas('task', function ($q) {
                    $q->where($q->qualifyColumn('promulgator_id'), Auth::id());
                });
            });
        })->with('product')->get();
        $versionIds = $versions->pluck('id')->toArray();
        $productIds = $versions->map(function ($version) {
            return $version->product->id;
        })->unique()->values()->toArray();
        $needConfirm = ReleaseProduct::query()->whereIn('id', $productIds)
            ->with(['versions' => function ($query) use ($versionIds) {
                $query->whereIn('id', $versionIds);
            }])->get();
        return [
            'release_products_count' => $productCount->first(),
            'need_confirm' => $needConfirm,
            'need_confirm_count' => count($versionIds),
        ];
    }
}
