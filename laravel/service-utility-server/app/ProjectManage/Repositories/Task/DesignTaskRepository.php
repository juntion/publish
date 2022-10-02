<?php

namespace App\ProjectManage\Repositories\Task;

use App\Enums\ProjectManage\DemandLinksType;
use App\Enums\ProjectManage\DesignPartStatus;
use App\Enums\ProjectManage\DesignPartType;
use App\Enums\ProjectManage\DesignSubTaskStatus;
use App\Enums\ProjectManage\DesignTaskDesignType;
use App\Enums\ProjectManage\DesignTaskReview;
use App\Enums\ProjectManage\DesignTaskStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseStatus;
use App\Enums\ProjectManage\Releases\SubTaskReleaseType;
use App\Enums\ProjectManage\TeamType;
use App\Events\PM\Task\TaskSetHandler;
use App\Events\PM\Task\TaskSubmit;
use App\Exceptions\System\InvalidParameterException;
use App\Exceptions\System\InvalidStatusException;
use App\Models\System\Media;
use App\Models\User;
use App\ProjectManage\Models\DesignPart;
use App\ProjectManage\Models\DesignSubTask;
use App\ProjectManage\Models\DesignTask;
use App\ProjectManage\Models\Product;
use App\ProjectManage\Models\Team;
use App\ProjectManage\Repositories\TeamRepository;
use App\Traits\Task\TaskFinishTrait;
use App\Traits\Task\TaskMediaTrait;
use App\Traits\Task\TaskRepositoryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class DesignTaskRepository
{
    use TaskMediaTrait, TaskFinishTrait, TaskRepositoryTrait;

    protected $teams;

    public function __construct(TeamRepository $teams)
    {
        $this->teams = $teams;
    }

    /**
     * 发布内部任务
     * @param Request $request
     * @throws InvalidParameterException
     */
    public function store(Request $request)
    {
        $formData = $request->validated();
        // 主任务发布人、主负责人、负责人
        $promulgatorUser = $principalUser = $mainPrincipalUser = Auth::user();
        $formData['promulgator_id'] = $promulgatorUser->id;
        $formData['promulgator_name'] = $promulgatorUser->name;
        $formData['principal_user_id'] = $principalUser->id;
        $formData['principal_user_name'] = $principalUser->name;
        $formData['main_principal_user_id'] = $mainPrincipalUser->id;
        $formData['main_principal_user_name'] = $mainPrincipalUser->name;
        $formData['content'] = $formData['description'];
        $formData['status'] = DesignTaskStatus::STATUS_TO_ASSIGN;
        $formData['share_address'] = isset($formData['share_address']) ? json_encode($formData['share_address']) : null;
        $task = DesignTask::create($formData);
        // 创建环节任务
        $this->createPartAndSubTask($task, $formData);

        // 关联产品
        $product = Product::query()->find($request->input('product_id'));
        if ($product->type != ProductStatus::TypeProduct) {
            throw new InvalidParameterException('产品选择有误！');
        }
        $this->attachProducts($task, $product, $request->input('product_modules', []));

        // 处理附件
        if ($medias = $request->media) {
            $task->addMedias($medias, $task);
        }
        // 纳入版本
        if ($versionIds = $request->input('release_version_ids')) {
            $task->versions()->attach($versionIds);
        }
    }

    /**
     * 生成环节和子任务
     * @param DesignTask $task
     * @param $data
     */
    protected function createPartAndSubTask(DesignTask $task, $data)
    {
        $parts = collect($data['parts'])->sortBy('type')->values();

        // 设计阶段
        $stage = 1;

        foreach ($parts as $part) {
            // 设计优先
            if ($data['design_type'] == DesignTaskDesignType::DESIGN_FIRST) {
                // 设计stage都是1，否则为2
                $stage = $this->isDesignPart($part['type']) ? 1 : 2;
            }
            // 环节负责人
            $partHandler = User::find($part['user_id']);
            $this->createPart($task, $part['type'], $partHandler, $stage);

            // 分阶段设计 stage 递增
            if ($data['design_type'] == DesignTaskDesignType::BY_STAGES) {
                $stage++;
            }
        }
    }

    /**
     * 编辑任务
     * @param DesignTask $task
     * @param Request $request
     * @throws InvalidParameterException
     */
    public function updateTask(DesignTask $task, Request $request)
    {
        $data = $request->validated();
        // 环节负责人可能会变
        $taskParts = $task->parts()->get();
        foreach ($data['parts'] as $item) {
            if ($part = $taskParts->where('type', $item['type'])->first()) {
                $partPrincipal = User::query()->find($item['user_id']);
                $part->update([
                    'principal_user_id' => $partPrincipal->id,
                    'principal_user_name' => $partPrincipal->name,
                ]);
            }
        }

        // 产品和附件关联更新
        $product = Product::query()->find($request->input('product_id'));
        if ($product->type != ProductStatus::TypeProduct) {
            throw new InvalidParameterException('产品选择有误！');
        }
        $this->relatedUpdate($task, $product, $request);

        $data['content'] = $data['description'];
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $data['source_project_id'] = $data['source_project_id'] ?? 0;
        $task->updated_at = now();
        $task->update($data);
        // 纳入版本
        if ($versionIds = $request->input('release_version_ids')) {
            $task->versions()->sync($versionIds);
        } else {
            $task->versions()->detach();
        }
    }

    /**
     * 是否是设计环节
     * @param $partType
     * @return bool
     */
    protected function isDesignPart($partType): bool
    {
        return in_array($partType, [DesignPartType::INTERACTIVE, DesignPartType::VISUAL, DesignPartType::ARTIST]);
    }

    /**
     * 创建任务环节
     * @param DesignTask $task
     * @param $partType
     * @param $principalUser
     * @param $stage
     * @param null $status
     * @return \Illuminate\Database\Eloquent\Model
     * @throws InvalidParameterException
     */
    public function createPart(DesignTask $task, $partType, $principalUser, $stage, $status = null)
    {
        if (is_null($status)) {
            $status = $this->getPartStatus($task, $stage);
        }
        $data = [
            'type' => $partType,
            'stage' => $stage,
            'status' => $status,
        ];
        if (empty($principalUser)) {
            throw new InvalidParameterException(DesignPartType::getDesc($partType) . '角色负责人不能为空，请绑定');
        }
        $data['principal_user_id'] = $principalUser instanceof User ? $principalUser->id : $principalUser->user_id;
        $data['principal_user_name'] = $principalUser instanceof User ? $principalUser->name : $principalUser->user_name;

        $newPart = $task->parts()->create($data);
        // 生成空子任务
        $this->createEmptyMainSubTask($newPart);
        return $newPart;
    }

    /**
     * 创建空主子任务
     * @param $part
     */
    protected function createEmptyMainSubTask($part)
    {
        $part->subTasks()->create([
            'task_id' => $part->task_id,
            'is_main' => 1,
            'status' => DesignSubTaskStatus::STATUS_CLOSED,
        ]);
    }

    /**
     * 第一阶段待分配，大于第一阶段 判断上一个环节是否都完成，如果完成状态变为待指派
     * @param DesignTask $task
     * @param int $stage
     * @return int
     */
    protected function getPartStatus(DesignTask $task, int $stage)
    {
        if ($stage > 1) {
            $previousPartsHasFinished = $task->parts()->where('stage', ($stage - 1))
                ->whereNotIn('status', [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])
                ->exists();
            // 未完成
            if ($previousPartsHasFinished) {
                return DesignPartStatus::STATUS_CLOSED;
            }
        }
        return DesignPartStatus::STATUS_TO_ASSIGN;
    }

    /**
     * @param DesignPart $part
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createNewSubTask(DesignPart $part, array $data)
    {
        $data['task_id'] = $part->task_id;
        $subTask = $part->subTasks()->create($data);
        // 邮件通知处理人
        event(new TaskSetHandler($subTask, User::query()->find($subTask->handler_id)));
        return $subTask;
    }

    /**
     * 更新任务信息
     * @param DesignTask $task
     * @param $data
     * @return bool
     */
    public function update(DesignTask $task, $data)
    {
        return $task->update($data);
    }

    /**
     * 更改负责人
     * @param DesignTask $task
     * @param $teamId
     */
    public function principal(DesignTask $task, $teamId)
    {
        $principalUser = Team::find($teamId);
        $data['principal_user_id'] = $principalUser->user_id;
        $data['principal_user_name'] = $principalUser->user_name;
        $this->update($task, $data);

        if ($demand = $task->demand()->first()) {
            $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_DESIGN)->first();
            // 更新demand_links的设计环节负责人
            $demandLik->update($data);
        }

        // 重新生成环节
        // 未审核没有设计环节，跳过生成环节的步骤
        $parts = $task->parts();
        if ($parts->get()->isNotEmpty()) {
            $partArray = $parts->pluck('type')->toArray();
            $parts->delete();
            $this->generateParts($task, $task->design_type, $partArray);
        }
    }

    /**
     * @param DesignTask $task
     * @return array
     */
    public function getPrincipal(DesignTask $task)
    {
        // 有搜索条件
        if (request()->has('user_name')) {
            $teams = Team::query()
                ->where('type', TeamType::TYPE_DESIGN)
                ->search('user_name', request()->input('user_name'))
                ->with('members')
                ->get();
            return $this->teams->formatDesignTeams($teams);
        }

        // 需求设计任务
        if ($demand = $task->demand()->first()) {
            return $this->teams->getDesignTeamsByProducts($demand);
        }

        //设计内部任务
        // 有产品
        $products = $task->ownProducts()->get();
        if ($products->isNotEmpty()) {
            $product = $products->where('type', ProductStatus::TypeProduct)->first();
            return $this->teams->getDesignTeamsByProducts($product);
        }
        // 无产品
        $teams = Team::query()->where('type', TeamType::TYPE_DESIGN)->with('members')->get();
        return $this->teams->formatDesignTeams($teams);
    }

    /**
     * 设计走查
     * @param DesignTask $task
     * @param $data
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function review(DesignTask $task, $data)
    {
        // 当走查结果未无差异或差异已调整，review字段改成已确认
        if (in_array($data['review_result'], [DesignTaskReview::REVIEW_RESULT_OK, DesignTaskReview::REVIEW_RESULT_ADJUSTED])) {
            $data['review'] = DesignTaskReview::REVIEW_CONFIRMED;
        } else if ($data['review_result'] == DesignTaskReview::REVIEW_RESULT_DIFFERENCE) {
            $data['review'] = DesignTaskReview::REVIEW_TO_CONFIRM;
        }
        $reviewUser = Auth::user();
        $data['reviewer_id'] = $reviewUser->id;
        $data['reviewer_name'] = $reviewUser->name;
        $data['review_time'] = now();
        $this->update($task, $data);

        if (isset($data['media'])) {
            $task->addMedias($data['media']);
        }
    }

    /**
     * 审核任务（生成环节）
     * @param DesignTask $task
     * @param $data
     */
    public function verify(DesignTask $task, $data)
    {
        $data['status'] = DesignTaskStatus::STATUS_TO_ASSIGN;
        $this->update($task, $data);
        $this->generateParts($task, $data['design_type'], $data['parts']);
    }

    /**
     * 获取任务设计团队成员
     * @param DesignTask $task
     * @return |null
     * @throws InvalidParameterException
     */
    protected function getTaskTeamMembersByProduct(DesignTask $task)
    {
        // 查找设计团队
        // 如果传了team_id直接查，否则查关联的需求产品对应的设计团队
        if ($teamId = request()->input('team_id')) {
            $team = Team::query()->find($teamId);
        } else {
            // 根据关联产品查找设计团队
            // 需求任务
            if ($demand = $task->demand()->first()) {
                $products = $demand->products()->get();
                // 需求的设计环节
                $demandLik = $demand->demandLinks()->where('type', DemandLinksType::TYPE_DESIGN)->first();
            } else {
                // 内部任务
                $products = $task->ownProducts()->get();
                if ($products->isEmpty()) {
                    return null;
                }
            }
            $product = $products->where('type', ProductStatus::TypeProduct)->first();
            // 查找设计团队及成员
            $team = Team::query()->where('type', TeamType::TYPE_DESIGN)->where('product_id', $product->id);
            if (isset($demandLik)) {
                $team = $team->where('user_id', $demandLik->principal_user_id)->first();
            } else {
                $team = $team->where('is_default', 1)->first();
            }
        }
        if (empty($team)) {
            info('负责人产品团队不能为空');
            throw new InvalidParameterException('该负责人下未绑定完成各角色负责人，请绑定');
        }
        return $team->members()->get()->keyBy('type');
    }

    /**
     * 生成设计环节
     * @param DesignTask $task
     * @param int $designType 设计类型
     * @param array $parts 环节
     * @throws InvalidParameterException
     */
    protected function generateParts(DesignTask $task, int $designType, array $parts)
    {
        // 文档 https://git.whgxwl.com:10025/King.Li/document/blob/master/%E6%96%B0%E7%89%88%E9%A1%B9%E7%9B%AE%E7%AE%A1%E7%90%86/%E7%BB%86%E8%8A%82%E6%96%B9%E9%9D%A2%E8%AF%B4%E6%98%8E.md#%E4%BB%BB%E5%8A%A1
        // 要根据 demand_links.principal_user_id 字段 和需求所绑定的产品模块，在 teams 表中找到设计负责人，并找到其 team_members，
        // 再将其更新到设计任务各环节的负责人字段上
        $teamMembers = $this->getTaskTeamMembersByProduct($task);
        if (empty($teamMembers)) {
            info('负责人产品团队成员不能为空');
            throw new InvalidParameterException('该负责人下未绑定完成各角色负责人，请绑定');
        }

        // 环节；0：交互；1：视觉；2：美工 3：前端；4：移动端
        sort($parts);

        // 设计阶段
        $stage = 1;

        try {
            foreach ($parts as $part) {
                // 设计优先
                if ($designType == DesignTaskDesignType::DESIGN_FIRST) {
                    //设计stage都是1，否则为2
                    $stage = in_array($part, [DesignPartType::INTERACTIVE, DesignPartType::VISUAL, DesignPartType::ARTIST]) ? 1 : 2;
                }

                $teamMember = $teamMembers->get(DesignPartType::partTypeTeamMemberMapping[$part]);
                if (empty($teamMember)) {
                    throw new InvalidParameterException('该负责人下未绑定完成各角色负责人，请绑定');
                }
                $this->createPart($task, $part, $teamMember, $stage);

                // 分阶段设计 stage递增
                if ($designType == DesignTaskDesignType::BY_STAGES) {
                    $stage++;
                }
            }
        } catch (\Exception $e) {
            logger()->error('生成设计环节异常', [Route::currentRouteName(), $task->id, $designType, $parts]);
            info('负责人产品团队信息不完整');
            throw new InvalidParameterException('该负责人下未绑定完成各角色负责人，请绑定');
        }
    }

    /**
     * 更改设计环节顺序（更改审核）
     * @param DesignTask $task
     * @param $data
     * @throws InvalidParameterException
     * @throws InvalidStatusException
     */
    public function sequence(DesignTask $task, $data)
    {
        $task->update($data);
        $parts = $task->parts()->get();
        $parts->each(function (DesignPart $part) {
            $part->subTasks()->get()->each(function ($subTask) {
                if ($subTask->status == DesignSubTaskStatus::STATUS_SUBMIT) {
                    throw new InvalidStatusException('任务已提交无法更改，可撤销提交后操作');
                }
            });
        });
        $originParts = $parts->where('status', '!=', DesignPartStatus::STATUS_REVOCATION)->pluck('type')->toArray();

        $designType = $data['design_type'];
        $designParts = $data['parts'];
        // 环节；0：交互；1：视觉；2：美工 3：前端；4：移动端
        sort($designParts);

        // 新增的环节
        $addParts = array_diff($designParts, $originParts);
        // 删除的环节
        $deleteParts = array_diff($originParts, $designParts);

        // 删除的环节变为撤销
        $parts->whereIn('type', $deleteParts)->map(function ($part) {
            if (!in_array($part->status, [DesignPartStatus::STATUS_COMPLETED, DesignPartStatus::STATUS_REVOCATION])) {
                // 撤销环节
                $part->update(['status' => DesignPartStatus::STATUS_REVOCATION]);
                $subTasks = $part->subTasks()->get();
                // 撤销子任务
                $subTasks->map(function ($subTask) {
                    $subTask->update(['status' => DesignSubTaskStatus::STATUS_REVOCATION]);
                });
            }
        });

        // 设计阶段
        $stage = 1;

        foreach ($designParts as $part) {
            // 设计优先
            if ($designType == DesignTaskDesignType::DESIGN_FIRST) {
                //设计stage都是1，否则为2
                $stage = in_array($part, [DesignPartType::INTERACTIVE, DesignPartType::VISUAL, DesignPartType::ARTIST]) ? 1 : 2;
            }

            // 新增的环节创建
            if (in_array($part, $addParts)) {
                $teamMembers = $this->getTaskTeamMembersByProduct($task);
                if (empty($teamMembers)) {
                    info('负责人产品团队成员不能为空');
                    throw new InvalidParameterException('该负责人下未绑定完成各角色负责人，请绑定');
                }
                $principalUser = $teamMembers->get(DesignPartType::partTypeTeamMemberMapping[$part]);
                $this->createPart($task, $part, $principalUser, $stage);
            } else {
                // 修改保留环节的阶段、状态
                // 更新stage字段
                $currentPart = $parts->where('type', $part)
                    ->where('status', '!=', DesignPartStatus::STATUS_REVOCATION)
                    ->first();
                $currentPartSubTask = $currentPart->subTasks()->get();
                $partData = ['stage' => $stage];

                // 进行中、提交、完成、撤销的环节，因为已经在处理了 就不变状态
                if (!in_array($currentPart->status, [
                    DesignPartStatus::STATUS_IN_PROGRESS,
                    DesignPartStatus::STATUS_SUBMIT,
                    DesignPartStatus::STATUS_COMPLETED,
                    DesignPartStatus::STATUS_REVOCATION,
                ])) {
                    if ($currentPartSubTask->isNotEmpty()) {
                        $hasHandler = $currentPartSubTask->where('handler_id', '>', 0)->isNotEmpty();
                        //有处理人是未开始
                        $partStatus = $hasHandler ? DesignPartStatus::STATUS_NO_BEGIN : DesignPartStatus::STATUS_TO_ASSIGN;
                        $partData['status'] = $stage > 1 ? $this->getPartStatus($task, $stage) : $partStatus;
                    } else {
                        $partData['status'] = $this->getPartStatus($task, $stage);  //没有子任务是待分配
                    }
                }
                $currentPart->update($partData);
                // 修改环节的子任务状态
                if ($currentPartSubTask->isNotEmpty() && $currentPart->wasChanged('status')) {
                    if ($currentPart->status == DesignPartStatus::STATUS_CLOSED) {
                        $currentPartSubTask->each(function ($item) {
                            if (in_array($item->status, [
                                DesignSubTaskStatus::STATUS_NO_BEGIN,
                                DesignSubTaskStatus::STATUS_IN_PROGRESS,
                                DesignSubTaskStatus::STATUS_PAUSED,
                            ])) {
                                $item->update([
                                    'status' => DesignSubTaskStatus::STATUS_CLOSED,
                                ]);
                            }
                        });
                    } else {
                        $currentPartSubTask->each(function ($item) {
                            if ($item->status == DesignSubTaskStatus::STATUS_CLOSED && $item->handler_id) {
                                $item->update([
                                    'status' => DesignSubTaskStatus::STATUS_NO_BEGIN,
                                ]);
                            }
                        });
                    }
                }
            }

            // 分阶段设计 stage递增
            if ($designType == DesignTaskDesignType::BY_STAGES) {
                $stage++;
            }
        }

        $this->sequenceSyncStatus($task);
    }

    /**
     * 更改排序状态同步处理
     * @param DesignTask $task
     */
    protected function sequenceSyncStatus(DesignTask $task)
    {
        // 这里状态变化应该只要撤销和新增的环节
        // 不能全删全撤销
        $parts = $task->parts()->get();

        $otherParts = $parts->whereNotIn('status', [DesignPartStatus::STATUS_REVOCATION, DesignPartStatus::STATUS_NO_BEGIN]);
        if ($otherParts->isEmpty()) {
            if (in_array($task->status, [DesignTaskStatus::STATUS_IN_PROGRESS, DesignTaskStatus::STATUS_SUBMIT])) {
                $task->update(['status' => DesignTaskStatus::STATUS_NO_BEGIN]);
            }
        }
    }

    /**
     * 更改任务预计交付日期
     * @param DesignTask $task
     * @param $expirationDate
     */
    public function expirationDate(DesignTask $task, $expirationDate)
    {
        $task->update(['expiration_date' => $expirationDate]);
    }

    /**
     * 设计任务详情
     * @param DesignTask $task
     * @return DesignTask
     */
    public function details(DesignTask $task)
    {
        $result = $task->load([
            'demand', 'demand.products', 'demand.versions', 'project', 'ownProducts', 'media', 'parts', 'versions', 'parts.subTasks.version'])
            ->append(['product_category', 'policies']);
        // 预计纳入版本
        $result->expected_versions = [];
        if ($result->demand_id) {
            $result->expected_versions = $result->demand->versions;
            unset($result->demand->versions);
        } else {
            $result->expected_versions = $result->versions;
        }
        unset($result->versions);
        $result->stress_test = 0;
        $taskVersions = [];
        // 处理主|其他子任务
        $subTasks = collect();
        foreach ($result->parts as $part) {
            foreach ($part->subTasks as $subTask) {
                $subTask->part_type = $part->type;
                $subTask->append(['policies']);
                $subTask->part = $part;
                $subTask->task = $task;
                $subTask->hasDemand = $task->demand;
                if ($releaseVersion = $subTask->version) {
                    if ($subTask->stress_test == 1) {
                        $result->stress_test = 1;
                    }
                    if ($subTask->release_type === 0 && !empty($subTask->version)) {
                        $version = $subTask->version->toArray();
                        $version['release_type'] = $subTask->release_type;
                        $taskVersions[] = $version;
                    } elseif (in_array($subTask->release_type, [1, 2])) {
                        $version['release_type'] = $subTask->release_type;
                        $taskVersions[] = $version;
                    }
                }
                $subTaskArr = $subTask->toArray();
                unset($subTaskArr['version']);
                unset($subTaskArr['part']);
                unset($subTaskArr['task']);
                unset($subTaskArr['hasDemand']);
                $subTasks = $subTasks->merge([$subTaskArr]);
            }
            $part->main_subtask = $subTasks->where('is_main', 1)->first();
            $part->other_subtasks = $subTasks->where('is_main', 0)->values();
            unset($part->subTasks);
        }
        $result->task_versions = $taskVersions;
        return $result;
    }

    /**
     * 设置处理人，生成子任务（主）
     * @param DesignPart $part
     * @param $data
     */
    public function partHandler(DesignPart $part, $data)
    {
        if (request()->has('comment')) {
            $data['description'] = request()->input('comment');
            request()->request->remove('comment');
        }
        // 如果part状态为关闭中，那子任务默认关闭中，否则默认未开始；
        $status = $part->status == DesignPartStatus::STATUS_CLOSED ? DesignSubTaskStatus::STATUS_CLOSED : DesignSubTaskStatus::STATUS_NO_BEGIN;
        $handler = User::find($data['user_id']);
        $data['handler_id'] = $handler->id;
        $data['handler_name'] = $handler->name;
        $data['status'] = $status;
        $mainSubTask = $part->subTasks()->where('is_main', 1)->first();
        if ($mainSubTask) {
            if ($handler->id == $mainSubTask->handler_id) {
                unset($data['status']);
            }
            $mainSubTask->update($data);
            // 修改邮件通知处理人
            if ($mainSubTask->wasChanged('handler_id')) {
                event(new TaskSetHandler($mainSubTask, $handler));
            }
        } else {
            $data['is_main'] = 1;
            $this->createNewSubTask($part, $data);
        }
    }

    /**
     * 创建子任务(添加次要跟进人)
     * @param DesignPart $part
     * @param $data
     */
    public function subTask(DesignPart $part, $data)
    {
        foreach ($data as $item) {
            $handler = User::find($item['user_id']);
            $item['is_main'] = 0;
            $item['handler_id'] = $handler->id;
            $item['handler_name'] = $handler->name;
            $item['status'] = $part->status == DesignPartStatus::STATUS_CLOSED ? DesignSubTaskStatus::STATUS_CLOSED : DesignSubTaskStatus::STATUS_NO_BEGIN;
            $this->createNewSubTask($part, $item);
        }
        // 角色任务已提交状态，再次添加次要跟进人，角色任务变成已提交之前的状态；
        if ($part->status == DesignPartStatus::STATUS_SUBMIT) {
            $part->update(['status' => DesignPartStatus::STATUS_IN_PROGRESS]);
        }
    }

    /**
     * @param DesignSubTask $subTask
     * @param $data
     * @throws InvalidParameterException
     */
    public function subTaskSubmitUpdate(DesignSubTask $subTask, $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $subTask->update($data);
        $this->updateMedia($subTask, $data);
        // 更新提交日志备注
        if (isset($data['comment'])) {
            $lastSubmitLog = $subTask->statusLogs()->where('new_status', DesignSubTaskStatus::STATUS_SUBMIT)->orderBy('id', 'desc')->first();
            $lastSubmitLog->update(['comment' => $data['comment']]);
        }
    }

    /**
     * 提交子任务
     * @param DesignSubTask $subTask
     * @param $data
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function subTaskSubmit(DesignSubTask $subTask, $data)
    {
        $data['share_address'] = isset($data['share_address']) ? json_encode($data['share_address']) : null;
        $data['status'] = DesignSubTaskStatus::STATUS_SUBMIT;
        $data['submit_time'] = now();
        $data['release_type'] = $data['release_type'] ?? null;
        $data['branch_name'] = $data['branch_name'] ?? '';
        $data['has_sql'] = $data['has_sql'] ?? null;
        $data['release_version_id'] = $data['release_version_id'] ?? null;
        $data['stress_test'] = $data['stress_test'] ?? null;
        $data['release_comment'] = $data['release_comment'] ?? '';
        $data['product_confirmed'] = isset($data['release_version_id']) ? 0 : null;
        $data['release_status'] = $data['release_version_id'] ? SubTaskReleaseStatus::NO_RELEASE_TEST : null;
        $subTask->update($data);
        // 保存附件
        if (isset($data['media'])) {
            $subTask->addMedias($data['media']);
        }

        // 邮件通知负责人验收
        event(new TaskSubmit($subTask));

        if ($subTask->release_version_id) {
            $this->submitOrUpdateVersion($subTask);
        }
    }

    /**
     * 撤销提交子任务
     * @param DesignSubTask $subTask
     */
    public function subTaskSubmitCancel(DesignSubTask $subTask)
    {
        $subTask->update([
            'status' => DesignSubTaskStatus::STATUS_IN_PROGRESS,
            'share_address' => null,
            'release_type' => null,
            'branch_name' => '',
            'has_sql' => null,
            'release_version_id' => null,
            'stress_test' => null,
            'release_comment' => '',
            'release_status' => null,
        ]);

        $medias = $subTask->media()->get();
        $medias->each(function (Media $media) {
            try {
                if (Storage::disk($media->disk)->exists($media->getPath())) {
                    Storage::disk($media->disk)->delete($media->getPath());
                }
                $media->delete();
            } catch (\Exception $e) {
                logger()->warning($e->getMessage());
            }
        });
    }

    /**
     * 修改子任务状态
     * @param DesignSubTask $subTask
     * @param $status
     * @return bool
     */
    public function subTaskStatus(DesignSubTask $subTask, $status)
    {
        return $subTask->update(['status' => $status]);
    }

    /**
     * 开始子任务
     * @param DesignSubTask $subTask
     */
    public function subTaskStart(DesignSubTask $subTask)
    {
        $subTask->update([
            'status' => DesignSubTaskStatus::STATUS_IN_PROGRESS,
            'start_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * 完成子任务
     * @param DesignSubTask $subTask
     * @param array $data
     */
    public function subTaskComplete(DesignSubTask $subTask, $data)
    {
        if ($data['result'] == 0) {
            $subTask->update(['status' => DesignSubTaskStatus::STATUS_IN_PROGRESS]);
        } else {
            if (!isset($data['finish_type'])) {
                throw new InvalidParameterException('请选择任务完成情况');
            }
            $subTaskData = [
                'status' => DesignSubTaskStatus::STATUS_COMPLETED,
                'finish_time' => now()->toDateTimeString(),
                'finish_type' => $data['finish_type'],
            ];

            $shouldFinishType = $this->shouldFinishType($subTask->expiration_date);
            if ($shouldFinishType != $data['finish_type']) {
                if (!isset($data['difference_reason'])) {
                    throw new InvalidParameterException('请填写差异原因说明');
                } else {
                    $subTaskData['difference_reason'] = $data['difference_reason'];
                }
            }
            $subTask->update($subTaskData);
        }
    }

    /**
     * 暂停子任务
     * @param DesignSubTask $subTask
     */
    public function subTaskPause(DesignSubTask $subTask)
    {
        $subTask->update([
            'status' => DesignSubTaskStatus::STATUS_PAUSED,
            'pause_time' => now(),
        ]);
    }

    /**
     * 撤销子任务
     * @param DesignSubTask $subTask
     */
    public function subTaskRevocation(DesignSubTask $subTask)
    {
        $this->subTaskStatus($subTask, DesignSubTaskStatus::STATUS_REVOCATION);
        $subTask->clearMedias();
    }

    /**
     * 更改版本信息
     * @param DesignSubTask $subTask
     * @param $data
     */
    public function subTaskUpdateVersion(DesignSubTask $subTask, $data)
    {
        if ($data['release_type'] == SubTaskReleaseType::FOLLOW_VERSION) {
            $data['branch_name'] = $data['branch_name'] ?? '';
            $data['release_version_id'] = $data['release_version_id'] ?? null;
            // 修改了版本，需要重新确认
            if ($subTask->release_version_id != $data['release_version_id']) {
                // 新加入版本的子任务都是未确认，且发布状态未发布测试
                $data['product_confirmed'] = 0;
                $data['release_status'] = SubTaskReleaseStatus::NO_RELEASE_TEST;
            }
            $data['has_sql'] = $data['has_sql'] ?? null;
            $data['stress_test'] = $data['stress_test'] ?? null;
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

        // 修改版本号
        if ($subTask->wasChanged('release_version_id') && $subTask->release_version_id) {
            $this->submitOrUpdateVersion($subTask);
        }
    }
}
