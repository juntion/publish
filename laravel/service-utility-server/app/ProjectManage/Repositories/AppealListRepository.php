<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\AppealStatus;
use App\ProjectManage\Models\Appeal;
use App\Repositories\BaseRepository;
use App\Traits\RemindTrait;
use Illuminate\Support\Facades\Auth;

class AppealListRepository extends BaseRepository
{
    use RemindTrait;

    protected $model;

    protected $allowedAppends = ['is_updated', 'product_category'];
    protected $shouldAppends = [
        'policies',
        'product_category',
    ];

    protected $allowedSearches = ['status', 'dept_id', 'follower_id', 'promulgator_id', 'principal_user_id', 'products.teams.members.id', 'demand.id'];
    protected $allowedScopeSearches = ['keyword', 'created_at'];
    protected $allowedIncludes = ['labels', 'products', 'attentionAble', 'statusLogs', 'media', 'demand'];

    protected $allowedMust = ['number', 'demand.number', 'name', 'type', 'dept_id', 'source_project_id', 'source_project_name', 'promulgator_id', 'principal_user_id', 'follower_id', 'status', 'created_at', 'finish_time', 'content', 'attentionAble.user_id'];
    protected $allowedScopeMust = ['productLine', 'productName', 'productModule', 'productCategory', 'isImportant'];
    protected $allowedSorts = ['created_at'];

    protected $showRemindData = [
        AppealStatus::STATUS_TO_ACCEPT,
        AppealStatus::STATUS_FOLLOWING,
        AppealStatus::STATUS_SCHEDULING,
        AppealStatus::STATUS_PENDING_REVIEW,
        AppealStatus::STATUS_HAS_PROJECT,
        AppealStatus::STATUS_TO_DISTRIBUTION
    ];

    public function __construct(Appeal $appeal)
    {
        $this->model = $appeal;
    }

    public function getList($limit)
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $result = $this->getModelsList($limit);
        $result->load(['labels', 'products', 'products.teams.members', 'media', 'demand', 'attentionAble']);
        $this->handleAppends($result);

        foreach ($result as $appeal) {
            $appeal->is_attention = $this->isAttention($appeal->attentionAble);
            unset($appeal->attentionAble);
        }
        $result = $result->toArray();
        $result['remind'] = $this->getRemind();
        return $result;
    }

    private function isAttention($attentionAble)
    {
        return $attentionAble->where('user_id', Auth::id())->isNotEmpty();
    }

    public function exportData()
    {
        if (!request()->has('sort')) {
            $this->orderBy('id', 'desc');
        }
        $res = $this->getModels();
        $res->load('demand', 'products', 'project');
        return $res;
    }
}
