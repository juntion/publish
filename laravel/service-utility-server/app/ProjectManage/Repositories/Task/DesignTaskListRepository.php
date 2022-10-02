<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\ProjectManage\Models\DesignTask;
use App\Repositories\BaseRepository;
use App\Traits\RemindTrait;

class DesignTaskListRepository extends BaseRepository
{
    use RemindTrait;

    protected $model;
    protected $allowedSearches = [
        'promulgator_id', 'principal_user_id', 'priority', 'parts.subTasks.handler_id', 'status', 'source_project_id',
        'parts.type', 'review', 'subTasks.status',
    ];
    protected $allowedScopeSearches = ['keyword', 'created_at', 'related_project', 'principal_user', 'subTaskStatus'];

    protected $allowedAppends = ['products', 'product_category'];
    protected $shouldAppends = [
        'products',
        'product_category',
        'policies',
        'parts.policies',
        'parts.subTasks.policies',
    ];

    protected $allowedMust = ['number', 'demand.number', 'demand.name', 'priority', 'promulgator_id', 'principal_user_id', 'parts.principal_user_id', 'parts.subTasks.handler_id', 'design_type', 'content', 'created_at', 'finish_time', 'verify_time'];
    protected $allowedScopeMust = ['productLine', 'productName', 'productModule', 'productCategory', 'status', 'finishTime',];
    protected $allowedIncludes = ['parts', 'parts.mainSubtask', 'parts.otherSubtasks', 'media', 'demand', 'demand.media', 'demand.products', 'demand.demandLinks'];
    protected $allowedSorts = ['priority', 'created_at'];

    protected $showRemindData = [
        DesignTaskStatus::STATUS_CLOSED,
        DesignTaskStatus::STATUS_TO_AUDIT,
        DesignTaskStatus::STATUS_TO_ASSIGN,
        DesignTaskStatus::STATUS_NO_BEGIN,
        DesignTaskStatus::STATUS_IN_PROGRESS,
        DesignTaskStatus::STATUS_SUBMIT,
        DesignTaskStatus::STATUS_PAUSED,
    ];

    protected $showReviewData = [
        DesignTaskStatus::REVIEW_NO_BEGIN,
    ];

    public function __construct(DesignTask $designTask)
    {
        $this->model = $designTask;
    }

    public function getList($limit)
    {
        $search = request()->input('search');
        // 角色环节筛选
        $partType = $search['parts.type'] ?? false;

        if (!request()->has('sort')) {
            $this->orderBy('verify_time', 'desc')->orderBy('id', 'desc');
        }
        $result = $this->getModelsList($limit);
        $result->load(['ownProducts', 'media', 'versions.product',
            'activityLogs' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'parts' => function ($query) {
                $query->orderBy('stage')->orderBy('type')
                    ->with(['subTasks', 'statusLogs', 'subTasks.media', 'subTasks.statusLogs', 'subTasks.version', 'subTasks.version.product.admins']);
            },
            'demand', 'demand.media', 'demand.products', 'demand.versions.product', 'demand.appeals.labels', 'project',
            'demand.demandLinks' => function ($query) {
                $query->where('type', DemandLinksType::TYPE_DESIGN);
            },
        ]);
        $this->handleAppends($result);

        foreach ($result as $designTask) {
            // 处理操作日志
            $designTask->operation_log = $designTask->activityLogs->map($designTask->getOperationLog());
            unset($designTask->activityLogs);
            // 预计纳入版本
            $designTask->expected_versions = [];
            if ($designTask->demand_id) {
                $designTask->expected_versions = $designTask->demand->versions;
                unset($designTask->demand->versions);
            } else {
                $designTask->expected_versions = $designTask->versions;
            }
            unset($designTask->versions);
            // 压测
            $designTask->stress_test = 0;
            // 任务纳入版本
            $taskVersions = [];

            // 处理环节type筛选
            /*if ($partType !== false) {
                $filerParts = $designTask->parts->filter(function ($part) use ($partType) {
                    return $part->type == $partType;
                });
                unset($designTask->parts);
                $designTask->parts = $filerParts->values();
            }*/

            // 处理主|其他子任务
            foreach ($designTask->parts as $part) {
                // 环节最后备注
                $partLastLog = $part->statusLogs->sortByDesc('id')->first();
                $part->last_comment = $partLastLog ? $partLastLog->comment : '';
                unset($part->statusLogs);

                $subTasks = collect();
                foreach ($part->subTasks as $subTask) {
                    $subTask->principal_user_id = $part->principal_user_id;
                    $subTask->principal_user_name = $part->principal_user_name;
                    $subTask->part_status = $part->status;
                    $subTask->part_status_desc = $part->status_desc;
                    $subTask->part_type = $part->type;
                    $subTask->part = $part;
                    $subTask->task = $designTask;
                    $subTask->hasDemand = $designTask->demand;
                    // 提交备注
                    $lastSubmitLog = $subTask->statusLogs->sortByDesc('id')->where('new_status', DesignSubTaskStatus::STATUS_SUBMIT)->first();
                    $subTask->submit_comment = $lastSubmitLog ? $lastSubmitLog->comment : '';
                    // 最后备注
                    $lastLog = $subTask->statusLogs->sortByDesc('id')->first();
                    $subTask->last_comment = $lastLog ? $lastLog->comment : '';
                    unset($subTask->statusLogs);
                    // 发版版本信息
                    if ($subTask->stress_test == 1) {
                        $designTask->stress_test = 1;
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
                    unset($subTaskArr['part']);
                    unset($subTaskArr['task']);
                    unset($subTaskArr['hasDemand']);
                    $subTasks = $subTasks->merge([$subTaskArr]);
                }
                $part->main_subtask = $subTasks->where('is_main', 1)->values();
                $part->other_subtasks = $subTasks->where('is_main', 0)->values();
                unset($part->subTasks);
            }
            $designTask->task_versions = $taskVersions;
            // 处理需求标签
            if ($demand = $designTask->demand) {
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
            $this->orderBy('verify_time', 'desc')->orderBy('id', 'desc');
        }
        $result = $this->getModels();
        $result->load(['promulgatorUser.departments', 'demand.products',
            'parts' => function ($query) {
                $query->orderBy('stage')->orderBy('type')->with(['subTasks']);
            },
        ]);
        return $result;
    }
}
