<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DevSubTaskStatus;
use App\Enums\ProjectManage\DevTaskStatus;
use App\Enums\ProjectManage\TeamType;
use App\ProjectManage\Models\DevTask;
use App\Repositories\BaseRepository;
use App\Traits\RemindTrait;

class DevTaskListRepository extends BaseRepository
{
    use RemindTrait;

    protected $model;

    protected $allowedSearches = [
        'promulgator_id', 'principal_user_id', 'priority', 'subTasks.handler_id', 'status', 'source_project_id', 'subTasks.status',
    ];
    protected $allowedScopeSearches = ['keyword', 'created_at', 'related_project', 'subTaskStatus', 'principal_user_id'];
    protected $allowedAppends = ['products', 'product_category'];
    protected $shouldAppends = [
        'products',
        'product_category',
        'policies',
        'subTasks.policies',
    ];

    protected $allowedIncludes = ['mainSubtask', 'otherSubtasks', 'media', 'demand', 'demand.media', 'demand.products', 'demand.demandLinks'];

    protected $allowedMust = ['number', 'demand.number', 'demand.name', 'priority', 'promulgator_id',
        'main_principal_user_id', 'principal_user_id', 'subTasks.handler_id', 'created_at', 'finish_time', 'content'];
    protected $allowedScopeMust = ['productLine', 'productName', 'productModule', 'productCategory', 'status', 'finishTime',];
    protected $allowedSorts = ['priority', 'created_at'];
    protected $showRemindData = [
        DevTaskStatus::STATUS_CLOSED,
        DevTaskStatus::STATUS_TO_ASSIGN,
        DevTaskStatus::STATUS_NO_BEGIN,
        DevTaskStatus::STATUS_IN_PROGRESS,
        DevTaskStatus::STATUS_SUBMIT,
        DevTaskStatus::STATUS_PAUSED,
        DevTaskStatus::STATUS_TO_AUDIT,
    ];

    public function __construct(DevTask $devTask)
    {
        $this->model = $devTask;
    }

    public function getList($limit)
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $result = $this->getModelsList($limit);
        $result->load(['ownProducts', 'media', 'versions.product', 'project',
            'subTasks', 'subTasks.media', 'subTasks.statusLogs', 'subTasks.version', 'subTasks.version.product.admins',
            'demand', 'demand.media', 'demand.products', 'demand.appeals.labels', 'demand.versions.product',
            'activityLogs' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'demand.products.teams' => function ($query) {
                $query->where('type', TeamType::TYPE_DEVELOP);
            },
            'demand.demandLinks' => function ($query) {
                $query->where('type', DemandLinksType::TYPE_DEVELOP);
            },
        ]);
        $this->handleAppends($result);

        foreach ($result as $devTask) {
            // 处理操作日志
            $devTask->operation_log = $devTask->activityLogs->map($devTask->getOperationLog());
            unset($devTask->activityLogs);
            // 预计纳入版本
            $devTask->expected_versions = [];
            if ($devTask->demand_id) {
                $devTask->expected_versions = $devTask->demand->versions;
                unset($devTask->demand->versions);
            } else {
                $devTask->expected_versions = $devTask->versions;
            }
            unset($devTask->versions);
            $devTask->stress_test = 0;
            $taskVersions = [];
            // 处理主|其他子任务
            $subTasks = collect();
            foreach ($devTask->subTasks as $subTask) {
                $subTask->task = $devTask;
                $subTask->hasDemand = $devTask->demand;
                $subTask->principal_user_id = $devTask->principal_user_id;
                $subTask->principal_user_name = $devTask->principal_user_name;
                $lastSubmitLog = $subTask->statusLogs->sortByDesc('id')->where('new_status', DevSubTaskStatus::STATUS_SUBMIT)->first();
                $subTask->submit_comment = $lastSubmitLog ? $lastSubmitLog->comment : '';
                // 最后备注
                $lastLog = $subTask->statusLogs->sortByDesc('id')->first();
                $subTask->last_comment = $lastLog ? $lastLog->comment : '';
                unset($subTask->statusLogs);
                // 子任务纳入版本
                if ($subTask->stress_test == 1) {
                    $devTask->stress_test = 1;
                }
                if ($subTask->release_type === 0 && !empty($subTask->version)) {
                    $version = $subTask->version->toArray();
                    $version['release_type'] = $subTask->release_type;
                    $version['release_comment'] = $subTask->release_comment;
                    $taskVersions[] = $version;
                } elseif (in_array($subTask->release_type, [1, 2])) {
                    $version = [];
                    $version['release_type'] = $subTask->release_type;
                    $version['release_comment'] = $subTask->release_comment;
                    $taskVersions[] = $version;
                }

                $subTaskArr = $subTask->toArray();
                unset($subTaskArr['task']);
                unset($subTaskArr['hasDemand']);
                $subTasks = $subTasks->merge([$subTaskArr]);
            }
            $devTask->task_versions = $taskVersions;
            $devTask->main_subtask = $subTasks->where('is_main', 1)->values();
            $devTask->other_subtasks = $subTasks->where('is_main', 0)->values();
            unset($devTask->subTasks);

            // 处理需求标签
            if ($demand = $devTask->demand) {
                if ($demand->appeals) {
                    $labels = [];
                    $demand->appeals->map(function ($item) use (&$labels) {
                        $labels = array_merge($labels, $item->labels->toArray());
                    });
                    $demand->labels = collect($labels)->unique('id')->toArray();
                }
                unset($demand->appeals);
            }
        }

        $result = $result->toArray();
        $result['remind'] = $this->getRemind();
        return $result;
    }

    /**
     * @return \App\Support\QueryBuilder\QueryBuilder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function exportData()
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $result = $this->getModels();
        $result->load(['demand.products', 'subTasks', 'promulgatorUser.departments']);
        return $result;
    }
}
