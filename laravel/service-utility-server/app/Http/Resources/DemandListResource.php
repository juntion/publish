<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DemandListResource extends JsonResource
{
    /**
     * 需求子任务纳入版本号
     * @var array
     */
    protected $taskVersions = [];

    /**
     * 压测
     * @var int
     */
    protected $stress_test = 0;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $demand = parent::toArray($request);
        $demand['media'] = MediaResource::collection($this->media);
        // $demand['products'] = DemandProductsResource::collection($this->products);
        $demand['project_principal_name'] = is_null($this->project) ? "" : $this->project->principal_user_name;
        $demand['task_num'] = $this->getTaskNum();
        $demand['labels'] = $this->getLabels();
        $demand['appeals'] = DemandAppealResource::collection($this->appeals);
        $demand['is_attention'] = $this->isAttention();
        $demand['expected_versions'] = $demand['versions'];
        $this->getTaskVersions();
        $demand['task_versions'] = collect($this->taskVersions)->unique('id')->values();
        $demand['stress_test'] = $this->stress_test;
        unset($demand['products']);
        unset($demand['versions']);
        unset($demand['project']);
        unset($demand['design_subtasks']);
        unset($demand['dev_subtasks']);
        unset($demand['test_subtasks']);
        unset($demand['frontend_subtasks']);
        unset($demand['mobile_sub_tasks']);
        unset($demand['attention_able']);
        unset($demand['design_tasks']);
        unset($demand['design_part']);
        unset($demand['dev_tasks']);
        unset($demand['test_tasks']);
        unset($demand['frontend_tasks']);
        unset($demand['mobile_tasks']);
        return $demand;
    }

    protected function getTaskNum()
    {
        $count = 0;
        if ($this->designPart->isEmpty() && $this->designTasks->isNotEmpty()) {
            $count = 1;
        }
        $this->designPart->map(function ($item) use (&$count) {
            $num = $item->subTasks->count();
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        $this->devTasks->map(function ($item) use (&$count) {
            $num = $item->subTasks->count();
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        $this->testTasks->map(function ($item) use (&$count) {
            $num = $item->subTasks->count();
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        $this->frontendTasks->map(function ($item) use (&$count) {
            $num = $item->subTasks->count();
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        $this->mobileTasks->map(function ($item) use (&$count) {
            $num = $item->subTasks->count();
            if ($num) {
                $count += $num;
            } else {
                $count += 1;
            }
        });
        return $count;
    }

    protected function getLabels()
    {
        $labels = [];
        $this->appeals->map(function ($item) use (&$labels) {
            $labels = array_merge($labels, $item->labels->toArray());
        });
        return collect($labels)->unique('id')->toArray();
    }

    public function isAttention()
    {
        return $this->attentionAble->where('user_id', Auth::id())->isNotEmpty();
    }

    protected function getTaskVersions()
    {
        $this->designSubtasks->map($this->mapSubTasks());
        $this->devSubtasks->map($this->mapSubTasks());
        $this->frontendSubtasks->map($this->mapSubTasks());
        $this->mobileSubTasks->map($this->mapSubTasks());
    }

    protected function mapSubTasks()
    {
        return function ($subTask) {
            if ($subTask->stress_test == 1) {
                $this->stress_test = 1;
            }
            // 发布类型：0：跟随版本发布；1：hotfix上线；2：无需发布
            if ($subTask->release_type === 0 && !empty($subTask->version)) {
                $version = $subTask->version->toArray();
                $version['release_type'] = $subTask->release_type;
                $version['release_comment'] = $subTask->release_comment;
                $this->taskVersions[] = $version;
            } elseif (in_array($subTask->release_type, [1, 2])) {
                $version = [];
                $version['release_type'] = $subTask->release_type;
                $version['release_comment'] = $subTask->release_comment;
                $this->taskVersions[] = $version;
            }
        };
    }
}
