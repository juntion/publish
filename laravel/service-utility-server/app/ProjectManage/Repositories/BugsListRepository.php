<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\BugStatus;
use App\ProjectManage\Models\Bug;
use App\Repositories\BaseRepository;
use App\Traits\RemindTrait;

class BugsListRepository extends BaseRepository
{
    use RemindTrait;

    protected $model;

    protected $shouldAppends = ['policies', 'product_category'];

    protected $allowedSearches = ['id', 'number', 'status', 'dept_id', 'operation_platform', 'product_principal_id',
        'promulgator_id', 'program_principal_id', 'test_principal_id', 'handlers.handler_id', 'examine_status',
        'erp_bug_id', 'erp_bug_number',
    ];
    protected $allowedScopeSearches = ['keyword', 'duration_date', 'created_at', 'status'];
    protected $allowedSorts = ['created_at'];

    protected $allowedMust = ['number', 'productLine', 'productName', 'demand.number', 'demand.name', 'project.number',
        'project.name', 'finish_time', 'created_at', 'dept_id', 'promulgator_id', 'operation_platform', 'product_principal_id',
        'program_principal_id', 'test_principal_id', 'handlers.handler_id', 'reason_id', 'data_restore', 'expiration_date',
        'status', 'labels.name'
    ];
    protected $allowedScopeMust = ['productLine', 'productName'];

    protected $showRemindData = [
        BugStatus::STATUS_TO_ASSIGN,
        BugStatus::STATUS_TO_ACCEPT,
        BugStatus::STATUS_IN_PROGRESS,
        BugStatus::STATUS_TO_REEXAMINE,
        BugStatus::STATUS_SCHEDULING,
        BugStatus::STATUS_APPLY_EXAMINE => [BugStatus::STATUS_TO_FINANCIAL_EXAMINE, BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE]
    ];

    public function __construct(Bug $bug)
    {
        $this->model = $bug;
    }

    public function getList($limit)
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }

        $result = $this->getModelsList($limit);
        $result->load(['products', 'reason', 'handlers', 'media', 'appeals', 'demands',
            'bugAccept' => function ($query) {
                $query->orderBy('type', 'asc')->with('media');
            },
            'labels' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'statusLogs' => function ($query) {
                $query->orderBy('id', 'desc');
            },
        ]);
        $this->handleAppends($result);

        foreach ($result as $bug) {
            // 验收附件
            $mediaAccept = [];
            $bug->bugAccept->map(function ($bugAccept) use (&$mediaAccept) {
                $mediaAccept = $bugAccept->media->merge($mediaAccept);
            });
            $bug->media_accept = $mediaAccept;
            // 财务审批意见
            $financialApprovalLog = $bug->statusLogs->where('new_status', BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE)->first();
            $bug->financial_approval_comment = $financialApprovalLog ? $financialApprovalLog->comment : '';
            unset($bug->statusLogs);
        }

        $result = $result->toArray();
        $result['remind'] = $this->getRemind();
        return $result;
    }

    public function getRemind()
    {
        $countSql = ' COUNT(IF(status = ?, 1, null)) ';
        $countSql2 = ' COUNT(IF(status in(?,?), 1, null)) ';
        $reviewSql = ' COUNT(IF(review = ?, 1, null ))';
        $statusArr = $this->showRemindData;
        $showDataKeys = [];
        // request 删除status
        $search = request()->input('search', []);
        if (array_key_exists('status', $search)) {
            unset($search['status']);
        }
        if (array_key_exists('review', $search)) {
            unset($search['review']);
        }
        request()->offsetSet('search', $search);
        $selectRaw = collect($statusArr)->map(function ($item, $key) use ($countSql, $countSql2, &$showDataKeys) {
            if (is_array($item)) {
                $showDataKeys[] = 'status' . $key;
                return $countSql2 . 'AS status' . $key;

            } else {
                $showDataKeys[] = 'status' . $item;
                return $countSql . 'AS status' . $item;
            }
        });
        $review = [];
        if (isset($this->showReviewData)) {
            $review = $this->showReviewData;
            collect($this->showReviewData)->map(function ($item) use ($reviewSql, &$selectRaw, &$showDataKeys) {
                $showDataKeys[] = 'review' . $item;
                $selectRaw[] = $reviewSql . "AS review" . $item;
            });
        }
        $selectRaw = $selectRaw->implode(',');
        $countRes = $this->queryBuilder()
            ->selectRaw($selectRaw, array_merge($statusArr, $review))
            ->where(function ($q) use ($review, $statusArr) {
                if ($review) {
                    $q->whereIn('status', $statusArr)->orWhereIn('review', $review);
                } else {
                    $statusArr = collect($statusArr)->flatten()->toArray();
                    $q->whereIn('status', $statusArr);
                }
            })
            ->first()->only($showDataKeys);
        return $countRes;
    }

    public function exportData()
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }

        $result = $this->getModels();
        $result->load(['reason', 'handlers', 'labels' => function ($query) {
            $query->orderBy('id', 'desc');
        }]);
        return $result;
    }
}
