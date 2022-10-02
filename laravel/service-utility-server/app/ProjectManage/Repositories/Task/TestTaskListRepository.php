<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\TestSubTaskStatus;
use App\Enums\ProjectManage\TestTaskStatus;
use App\ProjectManage\Models\TestTask;
use App\Repositories\BaseRepository;
use App\Traits\RemindTrait;

class TestTaskListRepository extends BaseRepository
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
    protected $allowedScopeMust = ['productLine', 'productName', 'productModule', 'productCategory', 'status', 'finishTime'];
    protected $allowedSorts = ['priority', 'created_at'];

    protected $showRemindData = [
        TestTaskStatus::STATUS_CLOSED,
        TestTaskStatus::STATUS_TO_ASSIGN,
        TestTaskStatus::STATUS_NO_BEGIN,
        TestTaskStatus::STATUS_IN_TEST,
        TestTaskStatus::STATUS_PAUSED,
        TestTaskStatus::STATUS_SUBMIT,
        TestTaskStatus::STATUS_TO_RELEASE,
        TestTaskStatus::STATUS_TO_AUDIT,
    ];

    public function __construct(TestTask $task)
    {
        $this->model = $task;
    }

    public function getList($limit)
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $result = $this->getModelsList($limit);
        $result->load(['ownProducts', 'subTasks', 'subTasks.media', 'subTasks.statusLogs', 'media',
            'demand', 'demand.media', 'demand.products', 'demand.appeals.labels', 'project',
            'demand.versions.product', 'demand.designSubtasks.version.product', 'demand.devSubtasks.version.product',
            'activityLogs' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'demand.demandLinks' => function ($query) {
                $query->where('type', DemandLinksType::TYPE_TEST);
            },
        ]);
        $this->handleAppends($result);

        foreach ($result as $testTask) {
            // 处理操作日志
            $testTask->operation_log = $testTask->activityLogs->map($testTask->getOperationLog());
            unset($testTask->activityLogs);
            // 预计纳入版本
            $testTask->expected_versions = [];
            // 压测
            $testTask->stress_test = 0;
            // 任务纳入版本
            $taskVersions = [];
            if ($testTask->demand_id) {
                $testTask->expected_versions = $testTask->demand->versions;
                unset($testTask->demand->versions);
                $subTasks = $testTask->demand->designSubtasks->merge($testTask->demand->devSubtasks);
                foreach ($subTasks as $subTask) {
                    if ($subTask->stress_test == 1) {
                        $testTask->stress_test = 1;
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
                }
                unset($testTask->demand->designSubtasks);
                unset($testTask->demand->devSubtasks);
            }
            $testTask->task_versions = collect($taskVersions)->unique('id')->toArray();

            // 处理主|其他子任务
            $subTasksCol = collect();
            foreach ($testTask->subTasks as $subTask) {
                $subTask->task = $testTask;
                $subTask->hasDemand = $testTask->demand;
                $subTask->principal_user_id = $testTask->principal_user_id;
                $subTask->principal_user_name = $testTask->principal_user_name;
                $lastSubmitLog = $subTask->statusLogs->sortByDesc('id')->where('new_status', TestSubTaskStatus::STATUS_SUBMIT)->first();
                $subTask->submit_comment = $lastSubmitLog ? $lastSubmitLog->comment : '';
                // 最后备注
                $lastLog = $subTask->statusLogs->sortByDesc('id')->first();
                $subTask->last_comment = $lastLog ? $lastLog->comment : '';
                unset($subTask->statusLogs);
                $subTaskArr = $subTask->toArray();
                unset($subTaskArr['task']);
                unset($subTaskArr['hasDemand']);
                $subTasksCol = $subTasksCol->merge([$subTaskArr]);
            }
            $testTask->main_subtask = $subTasksCol->where('is_main', 1)->values();
            $testTask->other_subtasks = $subTasksCol->where('is_main', 0)->values();
            unset($testTask->subTasks);

            // 处理需求标签
            if ($demand = $testTask->demand) {
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
