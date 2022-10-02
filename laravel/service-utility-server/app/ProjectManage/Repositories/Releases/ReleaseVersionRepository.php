<?php

namespace App\ProjectManage\Repositories\Releases;

use App\Enums\ProjectManage\DemandStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\Releases\ReleaseCycle;
use App\Enums\ProjectManage\Releases\ReleaseProductStatus;
use App\Enums\ProjectManage\Releases\ReleaseVersionStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Enums\ProjectManage\Task\FrontendTaskStatus;
use App\Enums\ProjectManage\Task\MobileTaskStatus;
use App\Enums\ProjectManage\TaskType;
use App\Enums\ProjectManage\TestTaskStatus;
use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DevSubTask;
use App\ProjectManage\Models\FrontendSubTask;
use App\ProjectManage\Models\MobileSubTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\ReleaseProduct;
use App\ProjectManage\Models\ReleaseVersion;
use App\ProjectManage\Models\TestTask;
use App\ProjectManage\Repositories\DemandRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReleaseVersionRepository
{
    /**
     * @param ReleaseVersion $releaseVersion
     * @param array $data
     */
    public function update(ReleaseVersion $releaseVersion, array $data)
    {
        $versionInfo = collect($data)->only(['main_version', 'second_version', 'third_version'])->toArray();
        $exists = ReleaseVersion::query()->where('id', '!=', $releaseVersion->id)
            ->where('release_product_id', $releaseVersion->release_product_id)->where($versionInfo)->exists();
        if ($exists) {
            throw new InvalidParameterException('版本号不能重复');
        }
        $releaseVersion->update($data);
    }

    /**
     * @param ReleaseVersion $releaseVersion
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function delete(ReleaseVersion $releaseVersion)
    {
        $hasDesignTask = $releaseVersion->designSubTasks()->exists();
        $hasDevTask = $releaseVersion->devSubTasks()->exists();
        if ($hasDesignTask || $hasDevTask) {
            throw new InvalidStatusException('此版本号已存在待发布的功能信息，不可删除！');
        }
        /*if (!request()->input('is_confirmed')) {
            throw new InvalidParameterException("确认后将删除{$releaseVersion->full_version}版本号信息，且无法撤销操作！");
        }*/
        $releaseVersion->delete();
    }

    /**
     * 根据pms产品关联的发版产品查询未发布上线的版本
     * @param Request $request
     * @return mixed
     */
    public function getVersionsByProduct(Request $request)
    {
        if ($productId = $request->input('product_id')) {
            $product = Product::query()->find($productId);
            $releaseProducts = $product->releaseProducts()->where('status', ReleaseProductStatus::ON)->get();
            // 当pms产品没有找到关联发版产品，返回所有发版产品
            if ($releaseProducts->isEmpty()) {
                $releaseProducts = ReleaseProduct::query()->where('status', ReleaseProductStatus::ON)->get();
            }
        } else {
            $releaseProducts = ReleaseProduct::query()->where('status', ReleaseProductStatus::ON)->get();
        }
        $releaseProducts->load([
            'admins', 'products',
            'versions' => function ($query) {
                $query->where('status', '!=', ReleaseVersionStatus::ONLINE)->orderByVersion();
            },
        ]);
        foreach ($releaseProducts as $releaseProduct) {
            $releaseProduct->getFriendlyProducts();
            $releaseProduct->product_ids = $releaseProduct->products->pluck('id')->toArray();
            unset($releaseProduct->products);
            foreach ($releaseProduct->versions as $version) {
                $version->product_name_full_version = "{$releaseProduct->name}($version->full_version)";
            }
        }
        return $releaseProducts;
    }

    /**
     * 版本功能清单
     * 功能清单包括设计任务和开发任务，合并搜索结果之后按创建时间倒序，然后手动分页
     * @param ReleaseVersion $releaseVersion
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function features(ReleaseVersion $releaseVersion, Request $request)
    {
        $result = $this->getVersionFeatures($releaseVersion);
        $perPage = (int)request()->input('limit', 20);
        $page = (int)request()->input('page', 1);
        $items = array_slice($result->toArray(), ($page - 1) * $perPage, $perPage);
        return new LengthAwarePaginator($items, $result->count(), $perPage);
    }

    /**
     * 版本功能点（子任务）
     * @return array
     */
    protected function versionHasSubTasks(): array
    {
        return [
            new DesignSubTask(),
            new DevSubTask(),
            new FrontendSubTask(),
            new MobileSubTask(),
        ];
    }

    /**
     * 查询纳入版本的设计、开发、前端、移动端 (子)任务
     * @param ReleaseVersion $releaseVersion
     * @param bool $loadPolicies
     * @return Collection
     */
    public function getVersionFeatures(ReleaseVersion $releaseVersion, $loadPolicies = true): Collection
    {
        $releaseVersion->load(['product.admins']);
        $versionSubTasks = $this->versionHasSubTasks();
        $allTasks = collect();
        // 查询
        $search = request()->input('search');
        foreach ($versionSubTasks as $subTask) {
            $subTask = $subTask->query()->where('release_version_id', $releaseVersion->id);
            if (isset($search['keyword'])) {
                $keyword = $search['keyword'];
                $subTask->where(function ($query) use ($keyword) {
                    $query->search('branch_name', $keyword)
                        ->orWhereHas('task', function ($query) use ($keyword) {
                            $query->search('number', $keyword)
                                ->orWhereHas('demand', function ($query) use ($keyword) {
                                    $query->search('number', $keyword);
                                });
                        });
                });
            }
            if (isset($search['handler_id'])) {
                $subTask->where('handler_id', $search['handler_id']);
            }
            if (isset($search['stress_test'])) {
                $subTask->where('stress_test', $search['stress_test']);
            }
            if (isset($search['product_confirmed'])) {
                $subTask->where('product_confirmed', $search['product_confirmed']);
            }
            if (isset($search['release_status'])) {
                $subTask->where('release_status', $search['release_status']);
            }
            if (isset($search['promulgator_id'])) {
                $promulgatorId = $search['promulgator_id'];
                $subTask->whereHas('task', function ($query) use ($promulgatorId) {
                    $query->where('promulgator_id', $promulgatorId)
                        ->orWhereHas('demand', function ($query) use ($promulgatorId) {
                            $query->where('promulgator_id', $promulgatorId);
                        });
                });
            }
            // 搜索任务的测试跟进人
            if (isset($search['test_handler_id'])) {
                $testHandlerId = $search['test_handler_id'];
                $subTask->whereHas('hasDemand', function ($query) use ($testHandlerId) {
                    $query->whereHas('testSubtasks', function ($q) use ($testHandlerId) {
                        $q->where('handler_id', $testHandlerId);
                    });
                });
            }
            if ($subTask instanceof DesignSubTask) {
                $subTasks = $subTask->with(['part', 'task.demand.appeals', 'task.demand.testSubtasks',])->get();
            } else {
                $subTasks = $subTask->with(['task.demand.appeals', 'task.demand.testSubtasks'])->get();
            }
            $allTasks = $allTasks->merge($subTasks);
        }
        // 排序
        $order = request()->input('sort', []);
        if (!empty($order)) {
            $order = explode(',', $order);
            if (in_array('handler_name', $order, true)) {
                $allTasks = $allTasks->sortBy(function ($row, $key) {
                    return $row['handler_name'] . $row['submit_time'];
                })->values();
            } elseif (in_array('-handler_name', $order, true)) {
                $allTasks = $allTasks->sortByDesc(function ($row, $key) {
                    return $row['handler_name'] . $row['submit_time'];
                })->values();
            } elseif (in_array('submit_time', $order, true)) {
                $allTasks = $allTasks->sortByDesc('submit_time')->values();
            }
        } else {
            $allTasks = $allTasks->sortByDesc('submit_time')->values();
        }
        $result = collect();
        foreach ($allTasks as $subTask) {
            if ($loadPolicies) {
                $subTask->onlyPolicies(['modifyVersion', 'confirmVersion', 'cancelConfirmVersion', 'releaseTest'])
                    ->append(['policies']);
            }
            $subTask->version = clone $releaseVersion;
            $task = $subTask->task;
            // 任务标题
            $subTask->task_title = $task->title;
            // 诉求人
            $subTask->appeal_users = [];
            // 测试人员
            $subTask->test_handlers = [];
            $demand = $task->demand;
            $subTask->hasDemand = $demand;
            if ($demand) {
                $subTask->appeal_users = $demand->appeals->pluck('promulgator_name')->unique()->toArray();
                unset($demand->appeals);
                $subTask->test_handlers = $demand->testSubtasks->pluck('handler_name')->filter()->toArray();
                unset($demand->testSubtasks);
            }
            // 任务需求
            $subTask->demand = $demand;
            $subTaskArr = $subTask->toArray();
            unset($subTaskArr['version']['product']);
            unset($subTaskArr['task']);
            unset($subTaskArr['part']);
            unset($subTaskArr['hasDemand']);
            $result = $result->merge([$subTaskArr]);
        }
        return $result;
    }

    /**
     * 版本管理员修改子任务版本
     * @param $id
     * @param $data
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function modifyVersion($id, $data)
    {
        $taskType = $data['task_type'];
        $subTask = $this->findSubTask($taskType, $id);
        if (!Auth::user()->can(__FUNCTION__, $subTask)) {
            throw new InvalidStatusException('当前状态不允许该操作');
        }
        if ($data['release_type'] == SubTaskReleaseType::FOLLOW_VERSION) {
            $data['release_version_id'] = $data['release_version_id'] ?? null;
            // 修改了版本，需要重新确认
            if ($subTask->release_version_id != $data['release_version_id']) {
                $data['product_confirmed'] = 0;
                $data['release_status'] = SubTaskReleaseStatus::NO_RELEASE_TEST;
            }
        } else {
            $data['branch_name'] = '';
            $data['release_version_id'] = null;
            $data['product_confirmed'] = null;
            $data['has_sql'] = null;
            $data['stress_test'] = null;
            $data['release_status'] = null;
        }
        $data['release_comment'] = $data['release_comment'] ?? '';
        $subTask->update($data);
    }

    /**
     * @param $taskType
     * @param $id
     * @throws InvalidParameterException
     */
    private function findSubTask($taskType, $id)
    {
        $subTask = null;
        if ($taskType == TaskType::TASK_TYPE_DESIGN) {
            $subTask = DesignSubTask::query()->find($id);
        }
        if ($taskType == TaskType::TASK_TYPE_DEV) {
            $subTask = DevSubTask::query()->find($id);
        }
        if ($taskType == TaskType::TASK_TYPE_MOBILE) {
            $subTask = MobileSubTask::query()->find($id);
        }
        if ($taskType == TaskType::TASK_TYPE_FRONTEND) {
            $subTask = FrontendSubTask::query()->find($id);
        }
        if (!$subTask) {
            throw new InvalidParameterException('任务不存在');
        }
        return $subTask;
    }

    /**
     * 确认版本
     * @param $id
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function confirmVersion($id)
    {
        $subTask = $this->findSubTask(request()->input('task_type'), $id);
        if (!Auth::user()->can(__FUNCTION__, $subTask)) {
            throw new InvalidStatusException('当前状态不允许该操作');
        }
        $subTask->product_confirmed = 1;
        $subTask->save();
    }

    /**
     * 取消确认版本
     * @param $id
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function cancelConfirmVersion($id)
    {
        $subTask = $this->findSubTask(request()->input('task_type'), $id);
        if (!Auth::user()->can(__FUNCTION__, $subTask)) {
            throw new InvalidStatusException('当前状态不允许该操作');
        }
        $subTask->product_confirmed = 0;
        $subTask->save();
    }

    /**
     * 任务发布测试
     * @param $id
     * @return array
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function taskReleaseTest($id)
    {
        $taskType = request()->input('task_type');
        $subTask = $this->findSubTask($taskType, $id);
        if (!Auth::user()->can('releaseTest', $subTask)) {
            throw new InvalidStatusException();
        }
        $errMsg = '';
        $errData = [];
        $subTasks = collect([$subTask]);
        $hasFinish = $this->featuresHasFinish($subTasks);
        if (!$hasFinish) {
            $errMsg = '无法发布，以下功能未满足条件！请联系对应人员操作后，再次发布！';
            $notFinishTasks = collect();
            if (!in_array($subTask->task->status, [
                constant($this->mainTaskStatusClass($taskType) . '::STATUS_REVOCATION'),
                constant($this->mainTaskStatusClass($taskType) . '::STATUS_COMPLETED'),
            ])) {
                $notFinishTasks = $notFinishTasks->merge([$subTask->task]);
            }
            $notConfirmed = $this->friendlyErrData($subTasks->where('product_confirmed', '!=', 1));
            $notFinished = $this->friendlyErrData($notFinishTasks->unique());
            $errData = [
                'not_confirmed' => $notConfirmed,
                'not_finished' => $notFinished,
            ];
            return [$errMsg, $errData];
        }
        if (!request()->input('is_confirmed')) {
            throw new InvalidParameterException('功能点满足发布测试条件，请确认！');
        }
        DB::transaction(function () use ($subTask) {
            $demand = $subTask->demand();
            $demandRepository = app()->make(DemandRepository::class);
            if ($demand && $demand->status == DemandStatus::STATUS_SUBMIT) {
                $demandRepository->beginTest($demand);
            }
            $subTask->release_status = SubTaskReleaseStatus::RELEASED_TEST;
            $subTask->save();
        });
        return [$errMsg, $errData];
    }

    /**
     * @param $taskType
     * @return string
     */
    public function mainTaskStatusClass($taskType): string
    {
        $class = 'App\\Enums\\ProjectManage\\';
        if (in_array($taskType, [TaskType::TASK_TYPE_FRONTEND, TaskType::TASK_TYPE_MOBILE], true)) {
            $class .= 'Task\\';
        }
        return $class . ucfirst($taskType) . 'TaskStatus';
    }

    /**
     * 版本发布测试
     * @param ReleaseVersion $releaseVersion
     * @return array
     * @throws InvalidParameterException
     */
    public function releaseTest(ReleaseVersion $releaseVersion)
    {
        $errMsg = '';
        $errData = [];
        // 加载任务和需求
        $releaseVersion->load(['designSubTasks.task', 'designSubTasks.hasDemand', 'devSubTasks.task', 'devSubTasks.hasDemand',
            'frontendSubTasks.task', 'frontendSubTasks.hasDemand', 'mobileSubTasks.task', 'mobileSubTasks.hasDemand',
        ]);
        $subTasks = $releaseVersion->designSubTasks
            ->merge($releaseVersion->devSubTasks)
            ->merge($releaseVersion->frontendSubTasks)
            ->merge($releaseVersion->mobileSubTasks);
        $hasFinish = $this->featuresHasFinish($subTasks);
        if (!$hasFinish) {
            $errMsg = '无法发布，以下功能未满足条件！请联系对应人员操作后，再次发布！';
            // 未完成主任务
            $notFinishTasks = $this->notFinishTasks($releaseVersion);
            $notFinished = $this->friendlyErrData($notFinishTasks);
            $notConfirmed = $this->friendlyErrData($subTasks->where('product_confirmed', '!=', 1));
            $errData = [
                'not_confirmed' => $notConfirmed,
                'not_finished' => $notFinished,
            ];
            return [$errMsg, $errData];
        }
        if (!request()->input('is_confirmed')) {
            throw new InvalidParameterException('所有功能均满足发布测试条件，确认后该版本状态将变为"版本测试中"，关联需求将批量更新测试！不可撤销，谨慎操作！');
        }
        // 更新版本到测试中
        $user = Auth::user();
        $data = [
            'status' => ReleaseVersionStatus::IN_TEST,
            'release_test_user_id' => $user->id,
            'release_test_user_name' => $user->name,
            'release_test_time' => now(),
            'release_test_comment' => request()->input('comment') ?? '',
        ];
        $releaseVersion->update($data);
        //需求更新测试
        $demandRepository = app()->make(DemandRepository::class);
        $demands = collect();
        foreach ($subTasks as $subTask) {
            if ($demand = $subTask->hasDemand) {
                $demands = $demands->merge([$demand]);
            }
            if ($subTask->release_status == SubTaskReleaseStatus::NO_RELEASE_TEST) {
                $subTask->update([
                    'release_status' => SubTaskReleaseStatus::RELEASED_TEST,
                ]);
            }
        }
        $demands = $demands->unique('id');
        $demands->map(function ($demand) use ($demandRepository) {
            if ($demand->status == DemandStatus::STATUS_SUBMIT) {
                $demandRepository->beginTest($demand);
            }
        });
        return [$errMsg, $errData];
    }

    /**
     * 找出版本关联的未完成的主任务
     * @param ReleaseVersion $releaseVersion
     * @return Collection
     */
    protected function notFinishTasks(ReleaseVersion $releaseVersion)
    {
        $notFinishTasks = collect();
        $releaseVersion->designSubTasks->map(function ($designSubTask) use (&$notFinishTasks) {
            if (!in_array($designSubTask->task->status, [DesignTaskStatus::STATUS_REVOCATION, DesignTaskStatus::STATUS_COMPLETED])) {
                $notFinishTasks = $notFinishTasks->merge([$designSubTask->task]);
            }
        });
        $releaseVersion->devSubTasks->map(function ($devSubTask) use (&$notFinishTasks) {
            if (!in_array($devSubTask->task->status, [DevTaskStatus::STATUS_REVOCATION, DevTaskStatus::STATUS_COMPLETED])) {
                $notFinishTasks = $notFinishTasks->merge([$devSubTask->task]);
            }
        });
        $releaseVersion->frontendSubTasks->map(function ($frontendSubTask) use (&$notFinishTasks) {
            if (!in_array($frontendSubTask->task->status, [FrontendTaskStatus::STATUS_REVOCATION, FrontendTaskStatus::STATUS_COMPLETED])) {
                $notFinishTasks = $notFinishTasks->merge([$frontendSubTask->task]);
            }
        });
        $releaseVersion->mobileSubTasks->map(function ($mobileSubTask) use (&$notFinishTasks) {
            if (!in_array($mobileSubTask->task->status, [MobileTaskStatus::STATUS_REVOCATION, MobileTaskStatus::STATUS_COMPLETED])) {
                $notFinishTasks = $notFinishTasks->merge([$mobileSubTask->task]);
            }
        });
        return $notFinishTasks->unique();
    }

    /**
     * @param Collection $subTasks
     * @return array
     */
    protected function friendlyErrData(Collection $subTasks): array
    {
        $result = [];
        $subTasks->map(function ($task) use (&$result) {
            $demand = null;
            if ($task->demand_id) {
                $demand = $task->demand;
            } elseif (!empty($task->hasDemand)) {
                $demand = $task->hasDemand;
            }
            if ($demand) {
                $result[$demand->id]['demand_number'] = $demand->number;
                $result[$demand->id]['task_number'][] = $task->number;
            } else {
                $result['tasks']['task_number'][] = $task->number;
            }
        });

        return collect($result)->values()->toArray();
    }

    /**
     * 创建新版本
     * @param ReleaseVersion $releaseVersion
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createNewVersion(ReleaseVersion $releaseVersion)
    {
        // 获取发版产品
        $product = $releaseVersion->product()->first();
        $lastVersion = $product->versions()->orderByVersion()->first();
        $status = ReleaseVersionStatus::TO_TEST;
        $creator = Auth::user();
        [$releaseTestTime, $releaseOnlineTime] = $this->getExpectedReleaseTime($product, $lastVersion);
        return $product->versions()->create([
            'creator_id' => $creator->id,
            'creator_name' => $creator->name,
            'status' => $status,
            'main_version' => $lastVersion->main_version,
            'second_version' => $lastVersion->second_version + 1,
            'third_version' => 0,
            'expected_release_test_time' => $releaseTestTime,
            'expected_release_online_time' => $releaseOnlineTime,
        ]);
    }

    /**
     * 根据产品周期获取下一个预计发布时间
     * @param $product
     * @param $lastVersion
     * @return array
     */
    protected function getExpectedReleaseTime($product, $lastVersion)
    {
        if ($product->release_type == ReleaseCycle::RELEASE_TYPE_WEEKLY) {
            $releaseTestTime = $lastVersion->expected_release_test_time ?
                Carbon::parse($lastVersion->expected_release_test_time)->addWeek()->toDateTimeString() : null;
            $releaseOnlineTime = $lastVersion->expected_release_online_time ?
                Carbon::parse($lastVersion->expected_release_online_time)->addWeek()->toDateTimeString() : null;
        }
        if ($product->release_type == ReleaseCycle::RELEASE_TYPE_TWO_WEEKS) {
            $releaseTestTime = $lastVersion->expected_release_test_time ?
                Carbon::parse($lastVersion->expected_release_test_time)->addDays(14)->toDateTimeString() : null;
            $releaseOnlineTime = $lastVersion->expected_release_online_time ?
                Carbon::parse($lastVersion->expected_release_online_time)->addDays(14)->toDateTimeString() : null;
        }
        if ($product->release_type == ReleaseCycle::RELEASE_TYPE_MONTHLY) {
            $releaseTestTime = $lastVersion->expected_release_test_time ?
                Carbon::parse($lastVersion->expected_release_test_time)->addMonth()->toDateTimeString() : null;
            $releaseOnlineTime = $lastVersion->expected_release_online_time ?
                Carbon::parse($lastVersion->expected_release_online_time)->addMonth()->toDateTimeString() : null;
        }
        return [$releaseTestTime, $releaseOnlineTime];
    }

    /**
     * 能否发布测试|上线
     * @param $subTasks
     * @return boolean
     */
    protected function featuresHasFinish($subTasks)
    {
        // 任务全部完成；所有功能点都已确认版本
        $hasFinish = true;
        $hasConfirmed = true;
        foreach ($subTasks as $subTask) {
            if (!empty($subTask->release_version_id) && $subTask->product_confirmed != 1) {
                $hasConfirmed = false;
                break;
            }
            $task = $subTask instanceof TestTask ? $subTask : $subTask->task;
            if ($task->task_type == TaskType::TASK_TYPE_DEV &&
                !in_array($task->status, [DevTaskStatus::STATUS_COMPLETED, DevTaskStatus::STATUS_REVOCATION])) {
                $hasFinish = false;
                break;
            }
            if ($task->task_type == TaskType::TASK_TYPE_DESIGN &&
                !in_array($task->status, [DesignTaskStatus::STATUS_REVOCATION, DesignTaskStatus::STATUS_COMPLETED])) {
                $hasFinish = false;
                break;
            }
            if ($task->task_type == TaskType::TASK_TYPE_TEST &&
                !in_array($task->status, [TestTaskStatus::STATUS_REVOCATION, TestTaskStatus::STATUS_COMPLETED])) {
                $hasFinish = false;
                break;
            }
            if ($task->task_type == TaskType::TASK_TYPE_FRONTEND &&
                !in_array($task->status, [FrontendTaskStatus::STATUS_COMPLETED, FrontendTaskStatus::STATUS_REVOCATION])) {
                $hasFinish = false;
                break;
            }
            if ($task->task_type == TaskType::TASK_TYPE_MOBILE &&
                !in_array($task->status, [MobileTaskStatus::STATUS_COMPLETED, MobileTaskStatus::STATUS_REVOCATION])) {
                $hasFinish = false;
                break;
            }
        }
        return $hasFinish && $hasConfirmed;
    }

    /**
     * 版本发布上线
     * @param ReleaseVersion $releaseVersion
     * @return array
     * @throws InvalidParameterException
     * @throws \App\Exceptions\Demand\InvaildParameterException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function releaseOnline(ReleaseVersion $releaseVersion)
    {
        $errMsg = '';
        $errData = [];
        // 加载任务和需求
        $releaseVersion->load([
            'designSubTasks.task', 'designSubTasks.hasDemand.testTasks',
            'devSubTasks.task', 'devSubTasks.hasDemand.testTasks',
            'frontendSubTasks.task', 'frontendSubTasks.hasDemand.testTasks',
            'mobileSubTasks.task', 'mobileSubTasks.hasDemand.testTasks',
        ]);
        $subTasks = $releaseVersion->designSubTasks
            ->merge($releaseVersion->devSubTasks)
            ->merge($releaseVersion->frontendSubTasks)
            ->merge($releaseVersion->mobileSubTasks);
        // 需求关联的测试主任务
        $testTasks = collect();
        foreach ($subTasks as $subTask) {
            if ($subTask->hasDemand) {
                $testTasks = $testTasks->merge($subTask->hasDemand->testTasks);
            }
        }
        $testTasks = $testTasks->unique()->values();
        $allSubTasks = $subTasks->merge($testTasks);
        $hasFinish = $this->featuresHasFinish($allSubTasks);
        if (!$hasFinish) {
            $errMsg = '无法发布，以下功能未满足条件！请联系对应人员操作后，再次发布！';
            // 未完成主任务
            $notFinishTasks = $this->notFinishTasks($releaseVersion);
            $notFinishTasks = $notFinishTasks->merge($testTasks->whereNotIn('status', [TestTaskStatus::STATUS_REVOCATION, TestTaskStatus::STATUS_COMPLETED]));
            $notFinished = $this->friendlyErrData($notFinishTasks->unique());
            $notConfirmed = $this->friendlyErrData($subTasks->where('product_confirmed', '!=', 1));
            $errData = [
                'not_confirmed' => $notConfirmed,
                'not_finished' => $notFinished,
            ];
            return [$errMsg, $errData, null];
        }
        if (!request()->input('is_confirmed')) {
            throw new InvalidParameterException('所有功能均满足发布上线条件，确认后该版本状态将变为"已发布上线"，关联需求将批量验收完成！不可撤销，谨慎操作！');
        }
        // 更新版本到已上线
        $user = Auth::user();
        $data = [
            'status' => ReleaseVersionStatus::ONLINE,
            'release_online_user_id' => $user->id,
            'release_online_user_name' => $user->name,
            'release_online_time' => now(),
            'release_online_comment' => request()->input('comment') ?? '',
        ];
        $releaseVersion->update($data);
        // 批量确认需求、诉求
        $demandRepository = app()->make(DemandRepository::class);
        $demands = collect();
        foreach ($subTasks as $subTask) {
            if ($demand = $subTask->hasDemand) {
                $demands = $demands->merge([$demand]);
            }
        }
        $demands = $demands->unique('id');
        $demands->map(function ($demand) use ($demandRepository) {
            if ($demand->status == DemandStatus::STATUS_IN_TEST) {
                $demandRepository->complete($demand);
            }
        });
        return [$errMsg, $errData, $demands];
    }
}
