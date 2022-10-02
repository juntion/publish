<?php

namespace App\Traits\Task;

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Events\PM\Task\SubTaskVersionInTest;
use App\Exceptions\System\InvalidParameterException;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\ReleaseVersion;
use Illuminate\Http\Request;

trait TaskRepositoryTrait
{
    /**
     * 任务关联产品及产品模块
     * @param $task
     * @param Product $product
     * @param array $productModules
     * @throws InvalidParameterException
     */
    protected function attachProducts($task, $product, $productModules = [])
    {
        // 关联产品
        if (empty($product))
            return;
        $this->taskAttachProduct($task, $product);
        // 关联产品模块及标签
        foreach ($productModules as $productModule) {
            $task->ownProducts()->attach($productModule['module_id'], ['type' => ProductStatus::TypeModule]);
            if (isset($productModule['label_ids'])) {
                $task->ownProducts()->attach($productModule['label_ids'], ['type' => ProductStatus::TypeCategory]);
            }
        }
    }

    /**
     * 任务递归关联产品
     * @param $task
     * @param Product $product
     * @throws InvalidParameterException
     */
    protected function taskAttachProduct($task, Product $product)
    {
        if ($product->status == ProductStatus::STATUS_OFF) {
            throw new InvalidParameterException('不能关联已关闭的产品线');
        }
        $task->ownProducts()->attach($product, ['type' => $product->type]);
        if ($parent = $product->parent) {
            $this->taskAttachProduct($task, $parent);
        }
    }

    /**
     * @param $task
     * @param $product
     * @param Request $request
     * @throws InvalidParameterException
     */
    protected function relatedUpdate($task, $product, Request $request)
    {
        $changes = [];

        if ($productChanges = $this->productsChange($task, $request)) {
            $changes[] = $productChanges;
        }

        $task->ownProducts()->detach();
        $this->attachProducts($task, $product, $request->input('product_modules', []));

        // 处理附件
        $oldMedias = $task->media()->get();
        if ($oldMedia = $request->old_media) {
            // $oldMedia 是要保留的附件
            $deleteMedias = $oldMedias->pluck('id')->reject(function ($item) use ($oldMedia) {
                return in_array($item, $oldMedia);
            })->toArray();
            $task->media()->whereIn('id', $deleteMedias)->delete();
        } else {
            $oldMedias->each(function ($media) {
                $media->delete();
            });
        }
        if ($newMedias = $request->new_media) {
            $medias = collect($newMedias)->map(function ($item) {
                return $item->getClientOriginalName();
            });
            $changes[] = [
                'name' => '更新附件',
                'old' => implode(',', $oldMedias->pluck('name')->toArray()),
                'new' => implode(',', $medias->toArray()),
            ];
            $task->addMedias($newMedias);
        }

        // 将修改写入缓存
        $task->getUpdatedCacheInstance()->put($task->getUpdatedCacheKey(), json_encode($changes), 600);
    }

    /**
     * 产品变更信息
     * @param $task
     * @param Request $request
     * @return array
     */
    protected function productsChange($task, Request $request)
    {
        // 原始关联产品
        $oldProductNames = '';
        $oldProducts = $task->ownProducts()->wherePivot('type', '!=', ProductStatus::TypeCategory)->get();
        if ($oldProducts->isNotEmpty()) {
            $oldProductNames = implode(',', $oldProducts->pluck('name')->toArray());
        }

        // 新传过来的产品类别
        $newProductNames = '';
        if ($request->has('product_id')) {
            $product = Product::query()->find($request->input('product_id'));
            $productLine = $product->parent;
            $modulesIds = collect($request->input('product_modules'))->map(function ($item) {
                return $item['module_id'];
            });
            $productModules = Product::query()->whereIn('id', $modulesIds->toArray())->get();
            $newProducts = collect([$productLine])->merge([$product])->merge($productModules);
            $newProductNames = implode(',', $newProducts->pluck('name')->toArray());
        }

        if ($oldProductNames != $newProductNames) {
            return [
                'name' => '所属产品或模块',
                'old' => $oldProductNames,
                'new' => $newProductNames,
            ];
        }
        return [];
    }

    /**
     * 提交任务选择测试中的版本号触发事件
     * @param $subTask
     */
    protected function submitOrUpdateVersion($subTask)
    {
        $version = ReleaseVersion::query()->find($subTask->release_version_id);
        if ($version->status == ReleaseVersionStatus::IN_TEST) {
            event(new SubTaskVersionInTest($subTask, $version));
        }
    }

    /**
     * 任务考核数据
     * @param $workload
     * @return array
     * @throws InvalidParameterException
     */
    public function subTaskAppraisalData($workload)
    {
        [$performanceLevel, $standardFactor] = DevSubTask::getPerformanceLevelAndFactor($workload);
        return [
            'standard_workload' => $workload,
            'standard_factor' => $standardFactor,
            'performance_level' => $performanceLevel,
        ];
    }
}
