<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\Task\FrontendSubTaskStatus;
use App\Enums\ProjectManage\Task\FrontendTaskStatus;
use App\Enums\ProjectManage\TeamType;
use App\ProjectManage\Models\FrontendTask;
use App\Repositories\BaseRepository;
use App\Traits\RemindTrait;

class FrontendTaskListRepository extends BaseRepository
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
        FrontendTaskStatus::STATUS_CLOSED,
        FrontendTaskStatus::STATUS_TO_ASSIGN,
        FrontendTaskStatus::STATUS_NO_BEGIN,
        FrontendTaskStatus::STATUS_IN_PROGRESS,
        FrontendTaskStatus::STATUS_SUBMIT,
        FrontendTaskStatus::STATUS_PAUSED,
        FrontendTaskStatus::STATUS_TO_AUDIT,
    ];

    public function __construct(FrontendTask $task)
    {
        $this->model = $task;
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
                $query->where('type', TeamType::TYPE_FRONTEND);
            },
            'demand.demandLinks' => function ($query) {
                $query->where('type', DemandLinksType::TYPE_FRONTEND);
            },
        ]);
        $this->handleAppends($result);

        foreach ($result as $task) {
            // 处理操作日志
            $task->operation_log = $task->activityLogs->map($task->getOperationLog());
            unset($task->activityLogs);
            // 预计纳入版本
            $task->expected_versions = [];
            if ($task->demand_id) {
                $task->expected_versions = $task->demand->versions;
                unset($task->demand->versions);
            } else {
                $task->expected_versions = $task->versions;
            }
            unset($task->versions);
            $task->stress_test = 0;
            $taskVersions = [];
            // 处理主|其他子任务
            $subTasks = collect();
            foreach ($task->subTasks as $subTask) {
                $subTask->task = $task;
                $subTask->hasDemand = $task->demand;
                $subTask->principal_user_id = $task->principal_user_id;
                $subTask->principal_user_name = $task->principal_user_name;
                $lastSubmitLog = $subTask->statusLogs->sortByDesc('id')->where('new_status', FrontendSubTaskStatus::STATUS_SUBMIT)->first();
                $subTask->submit_comment = $lastSubmitLog ? $lastSubmitLog->comment : '';
                // 最后备注
                $lastLog = $subTask->statusLogs->sortByDesc('id')->first();
                $subTask->last_comment = $lastLog ? $lastLog->comment : '';
                unset($subTask->statusLogs);
                // 子任务纳入版本
                if ($subTask->stress_test == 1) {
                    $task->stress_test = 1;
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
            $task->task_versions = $taskVersions;
            $task->main_subtask = $subTasks->where('is_main', 1)->values();
            $task->other_subtasks = $subTasks->where('is_main', 0)->values();
            unset($task->subTasks);

            // 处理需求标签
            if ($demand = $task->demand) {
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
