<?php

namespace App\ProjectManage\Repositories;

use App\Enums\ProjectManage\BugExamineStatus;
use App\Enums\ProjectManage\BugStatus;
use App\Enums\ProjectManage\OperationPlatform;
use App\Enums\ProjectManage\ProductStatus;
use App\Enums\WsGateway\WsNotificationType;
use App\Exceptions\System\InvalidParameterException;
use App\Models\Department;
use App\Models\User;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Models\BugAccept;
use App\ProjectManage\Models\BugPrincipal;
use App\ProjectManage\Models\Product;
use App\Support\WsGateway;
use Illuminate\Support\Facades\Auth;

class BugsRepository
{
    /**
     * 提bug
     * @param $data
     * @throws InvalidParameterException
     */
    public function store($data)
    {
        // 发布人名称、部门
        $user = Auth::user();
        $data['promulgator_id'] = $user->id;
        $data['promulgator_name'] = $user->name;
        if (isset($data['dept_id'])) {
            $dept = Department::query()->find($data['dept_id']);
        } else {
            $dept = $user->basicDepartment;
        }
        $data['dept_id'] = $dept->id;
        $data['dept_name'] = $dept->name;
        $data['status'] = BugStatus::STATUS_TO_ASSIGN;

        // 负责人
        $principals = BugPrincipal::query()->where('dept_id', $dept->id)->first();
        if (empty($principals)) {
            throw new InvalidParameterException('部门负责人不能为空，请先绑定部门负责人');
        }
        // 产品负责人
        $productPrincipal = $this->getProductPrincipal($principals, $data['operation_platform']);
        $data['product_principal_id'] = $productPrincipal->id;
        $data['product_principal_name'] = $productPrincipal->name;
        // 程序负责人
        $programPrincipal = $this->getProgramPrincipal($principals, $data['operation_platform']);
        $data['program_principal_id'] = $programPrincipal->id;
        $data['program_principal_name'] = $programPrincipal->name;
        // 测试负责人
        if (empty($principals->test_user_id)) {
            throw new InvalidParameterException('测试负责人不能为空！');
        }
        $data['test_principal_id'] = $principals->test_user_id;
        $data['test_principal_name'] = $principals->test_user_name;

        $bug = Bug::query()->create($data);

        // 上传附件
        if (isset($data['media'])) {
            $bug->addMedias($data['media']);
        }

        // 关联产品
        if (isset($data['product_line'])) {
            $bug->products()->attach($data['product_line'], ['type' => ProductStatus::TypeLine]);
        }
        if (isset($data['product_id'])) {
            $bug->products()->attach($data['product_id'], ['type' => ProductStatus::TypeProduct]);
        }
    }

    /**
     * 根据操作平台判断是否是后端负责
     * @param int $platform
     * @return bool
     */
    private function isBackend(int $platform)
    {
        return in_array($platform, [
            OperationPlatform::BACKEND_PC,
            OperationPlatform::APP,
            OperationPlatform::ARMS,
            OperationPlatform::PDA,
        ]);
    }

    /**
     * 产品负责人
     * @param BugPrincipal $principal
     * @param $platform
     * @return User
     * @throws InvalidParameterException
     */
    public function getProductPrincipal(BugPrincipal $principal, $platform)
    {
        $isBackend = $this->isBackend($platform);
        $userId = $isBackend ? $principal->backend_product_user_id : $principal->frontend_product_user_id;
        $productUser = User::query()->find($userId);
        if (empty($productUser)) {
            throw new InvalidParameterException('产品负责人不能为空！');
        }
        return $productUser;
    }

    /**
     * 程序负责人
     * @param BugPrincipal $principal
     * @param $platform
     * @return User
     * @throws InvalidParameterException
     */
    public function getProgramPrincipal(BugPrincipal $principal, $platform)
    {
        $isBackend = $this->isBackend($platform);
        $userId = $isBackend ? $principal->backend_program_user_id : $principal->frontend_program_user_id;
        $programUser = User::query()->find($userId);
        if (empty($programUser)) {
            throw new InvalidParameterException('程序负责人不能为空！');
        }
        return $programUser;
    }

    /**
     * 更新bug
     * @param Bug $bug
     * @param array $data
     * @throws InvalidParameterException
     */
    public function update(Bug $bug, array $data)
    {
        $this->relatedUpdate($bug, $data);

        // 操作平台变更
        if ($data['operation_platform'] != $bug->operation_platform) {
            // 负责人相关
            $principals = BugPrincipal::query()->where('dept_id', $bug->dept_id)->first();
            if (empty($principals)) {
                throw new InvalidParameterException('部门负责人不能为空，请先绑定部门负责人');
            }
            // 产品负责人
            $productPrincipal = $this->getProductPrincipal($principals, $data['operation_platform']);
            $data['product_principal_id'] = $productPrincipal->id;
            $data['product_principal_name'] = $productPrincipal->name;
            // 程序负责人
            $programPrincipal = $this->getProgramPrincipal($principals, $data['operation_platform']);
            $data['program_principal_id'] = $programPrincipal->id;
            $data['program_principal_name'] = $programPrincipal->name;
        }

        if (!isset($data['source_project_id'])) {
            $data['source_project_id'] = 0;
            $data['source_project_name'] = '';
        }
        if (!isset($data['source_demand_id'])) {
            $data['source_demand_id'] = 0;
            $data['source_demand_name'] = '';
        }

        $bug->updated_at = now();
        $bug->update($data);
    }

    /**
     * 关联更新
     * @param Bug $bug
     * @param $data
     */
    protected function relatedUpdate(Bug $bug, $data)
    {
        $changes = [];

        // 上传新增附件
        $oldMedias = $bug->media()->get();
        if (isset($data['old_media'])) {
            // $oldMedia 是要保留的附件
            $deleteMedias = $oldMedias->pluck('id')->reject(function ($item) use ($data) {
                return in_array($item, $data['old_media']);
            })->toArray();
            $bug->media()->whereIn('id', $deleteMedias)->delete();
        } else {
            $oldMedias->each(function ($media) {
                $media->delete();
            });
        }
        if (isset($data['new_media'])) {
            $medias = collect($data['new_media'])->map(function ($item) {
                return $item->getClientOriginalName();
            });
            $changes[] = [
                'name' => '更新附件',
                'old' => implode(',', $oldMedias->pluck('name')->toArray()),
                'new' => implode(',', $medias->toArray()),
            ];
            $bug->addMedias($data['new_media']);
        }

        // 关联产品
        $oldProducts = $bug->products();
        $productChanges = [
            'name' => '所属产品线或产品',
            'old' => implode(',', $oldProducts->pluck('name')->toArray()),
        ];
        $bug->products()->detach();
        if (isset($data['product_line'])) {
            $productChanges['new'] = Product::query()->find($data['product_line'])->name;
            $bug->products()->attach($data['product_line'], ['type' => ProductStatus::TypeLine]);
        }
        if (isset($data['product_id'])) {
            $bug->products()->attach($data['product_id'], ['type' => ProductStatus::TypeProduct]);
            $productChanges['new'] .= ',' . Product::query()->find($data['product_id'])->name;
        }
        if (!isset($data['product_line'])) {
            $productChanges['new'] = '';
        }
        if ($productChanges['new'] != $productChanges['old']) {
            $changes[] = $productChanges;
        }

        // 将修改写入缓存
        $bug->getUpdatedCacheInstance()->put($bug->getUpdatedCacheKey(), json_encode($changes), 600);
    }

    /**
     * @param Bug $bug
     * @return Bug
     */
    public function detail(Bug $bug)
    {
        $bug->load(['reason', 'media', 'products', 'handlers', 'project', 'demand', 'bugAccept.media', 'labels', 'appeals', 'demands',
            'activityLogs' => function ($query) {
                $query->orderBy('id', 'desc');
            }
        ]);
        $bug->append(['policies', 'product_category']);

        // 验收附件
        $mediaAccept = [];
        $bug->bugAccept->map(function ($bugAccept) use (&$mediaAccept) {
            $mediaAccept = $bugAccept->media->merge($mediaAccept);
        });
        $bug->media_accept = $mediaAccept;

        $bug->operation_log = $bug->activityLogs->map($bug->getOperationLog());
        unset($bug->activityLogs);
        return $bug;
    }

    /**
     * @param Bug $bug
     */
    public function revocation(Bug $bug)
    {
        $bug->update(['status' => BugStatus::STATUS_REVOCATION]);
    }

    /**
     * @param Bug $bug
     * @param $userId
     */
    public function testPrincipal(Bug $bug, $userId)
    {
        $user = User::query()->find($userId);
        $bug->update([
            'test_principal_id' => $user->id,
            'test_principal_name' => $user->name,
        ]);
    }

    /**
     * @param Bug $bug
     * @param $userId
     */
    public function productPrincipal(Bug $bug, $userId)
    {
        $user = User::query()->find($userId);
        $bug->update([
            'product_principal_id' => $user->id,
            'product_principal_name' => $user->name,
        ]);
    }

    /**
     * @param Bug $bug
     * @param $userId
     */
    public function programPrincipal(Bug $bug, $userId)
    {
        $user = User::query()->find($userId);
        $bug->update([
            'program_principal_id' => $user->id,
            'program_principal_name' => $user->name,
        ]);
    }

    /**
     * 申请审批
     * @param Bug $bug
     */
    public function applyExamine(Bug $bug)
    {
        $bug->update([
            'status' => BugStatus::STATUS_TO_FINANCIAL_EXAMINE,
            'examine_status' => BugExamineStatus::TO_FINANCIAL_EXAMINE,
        ]);
    }

    /**
     * 撤销审批申请
     * @param Bug $bug
     */
    public function applyExamineCancel(Bug $bug)
    {
        $data['status'] = $this->getBeforeApplyExamineStatus($bug);
        $data['examine_status'] = 0;
        $bug->update($data);
    }

    /**
     * 查询审批之前的状态
     * @param Bug $bug
     * @return
     * @throws \Exception
     */
    protected function getBeforeApplyExamineStatus(Bug $bug)
    {
        $statusLogs = $bug->statusLogs()->orderBy('id', 'desc')->get();
        foreach ($statusLogs as $statusLog) {
            if (!in_array($statusLog->new_status, [BugStatus::STATUS_TO_FINANCIAL_EXAMINE, BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE])) {
                return $statusLog->new_status;
            }
        }
        throw new \Exception('查询审批之前的状态异常');
    }

    /**
     * 分配跟进人
     * @param Bug $bug
     * @param $data
     */
    public function follow(Bug $bug, $data)
    {
        $data['status'] = BugStatus::STATUS_TO_ACCEPT;
        $bug->update($data);
        $bug->handlers()->delete();
        foreach ($data['follower_ids'] as $followerId) {
            $handler = User::query()->find($followerId);
            $bug->handlers()->create([
                'handler_id' => $handler->id,
                'handler_name' => $handler->name,
            ]);
        }

        $this->notifyFollower($data['follower_ids']);
    }

    /**
     * 通知跟进人
     * @param array $users
     */
    protected function notifyFollower($users)
    {
        $data = [
            'type' => WsNotificationType::NOTIFICATION,
            'title' => 'pms有分配bug提醒',
            'content' => '你的负责人分配一个bug任务需要处理，请及时前往pms进行处理！',
        ];
        WsGateway::sendToUid($users, $data);
    }

    /**
     * 财务审批
     * @param Bug $bug
     * @param $data
     */
    public function financeExamine(Bug $bug, $data)
    {
        // 审批驳回
        if ($data['result'] == 0) {
            $bug->update([
                'status' => BugStatus::STATUS_NO_HANDLE,
                'examine_status' => BugExamineStatus::FINANCIAL_EXAMINE_REJECTED,
            ]);
            if ($bug->labels()->where('name', '财务审批通过')->exists()) {
                $bug->labels()->where('name', '财务审批通过')->delete();
            }
            $bug->addLabel('财务审批驳回');
        } else {
            // 审批通过
            $needInternalControl = $data['required_internal_control'] ?? 0;
            // 需要内控审批
            if ($needInternalControl) {
                $bug->update([
                    'status' => BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE,
                    'examine_status' => BugExamineStatus::TO_INTERNAL_CONTROL_EXAMINE,
                ]);
            } else {
                $bug->update([
                    'status' => $this->getBeforeApplyExamineStatus($bug),
                    'examine_status' => BugExamineStatus::FINANCIAL_EXAMINE_PASS,
                ]);
            }
            $bug->addLabel('财务审批通过');
        }
    }

    /**
     * 内控审批
     * @param Bug $bug
     * @param $data
     */
    public function internalControlExamine(Bug $bug, $data)
    {
        // 审批驳回
        if ($data['result'] == 0) {
            $bug->update([
                'status' => BugStatus::STATUS_NO_HANDLE,
                'examine_status' => BugExamineStatus::INTERNAL_CONTROL_EXAMINE_REJECTED,
            ]);
            $bug->addLabel('内控审批驳回');
        } else {
            $bug->update([
                'status' => $this->getBeforeApplyExamineStatus($bug),
                'examine_status' => BugExamineStatus::INTERNAL_CONTROL_EXAMINE_PASS
            ]);
            $bug->addLabel('内控审批通过');
        }
    }

    /**
     * 补充信息
     * @param Bug $bug
     * @param $data
     */
    public function appendInfo(Bug $bug, $data)
    {
        $this->productsChanges($bug, $data);

        if (!isset($data['source_project_id'])) {
            $data['source_project_id'] = 0;
            $data['source_project_name'] = '';
        }
        if (!isset($data['source_demand_id'])) {
            $data['source_demand_id'] = 0;
            $data['source_demand_name'] = '';
        }

        $bug->updated_at = now();
        $bug->update($data);
    }

    /**
     * 补充信息变更
     * @param Bug $bug
     * @param $data
     */
    protected function productsChanges(Bug $bug, $data)
    {
        $changes = [];

        // 关联产品
        $oldProducts = $bug->products();
        $productChanges = [
            'name' => '所属产品线或产品',
            'old' => implode(',', $oldProducts->pluck('name')->toArray()),
        ];
        // 清除关联
        $bug->products()->detach();

        if (isset($data['product_line'])) {
            $productChanges['new'] = Product::query()->find($data['product_line'])->name;
            $bug->products()->attach($data['product_line'], ['type' => ProductStatus::TypeLine]);
        }
        if (isset($data['product_id'])) {
            $bug->products()->attach($data['product_id'], ['type' => ProductStatus::TypeProduct]);
            $productChanges['new'] .= ',' . Product::query()->find($data['product_id'])->name;
        }
        if (!isset($data['product_line'])) {
            $productChanges['new'] = '';
        }
        if ($productChanges['new'] != $productChanges['old']) {
            $changes[] = $productChanges;
        }
        if (!empty($changes)) {
            // 将修改写入缓存
            $bug->getUpdatedCacheInstance()->put($bug->getUpdatedCacheKey(), json_encode($changes), 600);
        }
    }

    /**
     * @param Bug $bug
     * @param $data
     */
    public function close(Bug $bug, $data)
    {
        unset($data['comment']);

        $this->productsChanges($bug, $data);

        if (!isset($data['source_project_id'])) {
            $data['source_project_id'] = 0;
            $data['source_project_name'] = '';
        }
        if (!isset($data['source_demand_id'])) {
            $data['source_demand_id'] = 0;
            $data['source_demand_name'] = '';
        }
        $bug->updated_at = now();
        $bug->update($data);
        // 添加关闭标签
        $bug->addLabel('Bug已关闭');
    }

    /**
     * @param Bug $bug
     * @param array $data
     */
    public function submitHandleResult(Bug $bug, array $data)
    {
        $data['reason_analyse'] = $data['reason_analyse'] ?? '';
        $data['data_restore_comment'] = $data['data_restore_comment'] ?? '';
        $data['inquiry_progress'] = $data['inquiry_progress'] ?? '';

        $isProgramPrincipal = Auth::id() == $bug->program_principal_id;
        if ($isProgramPrincipal) {
            if (empty($bug->expiration_date)) {
                throw new InvalidParameterException('请选择处理时限');
            }
            // 程序负责人提交不用复核
            $data['status'] = $data['resolve_status'];
            if (in_array($data['status'], [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])) {
                $data['finish_time'] = now();
                // 处理完成 过如果存在验收不合格标签就删除
                if ($bug->labels()->where('name', '验收不合格')->exists()) {
                    $bug->labels()->where('name', '验收不合格')->delete();
                }
            }
        } else {
            // 处理人提交: 已处理/不处理，状态改为待复核
            if (in_array($data['resolve_status'], [BugStatus::STATUS_NO_HANDLE, BugStatus::STATUS_COMPLETED])) {
                $data['status'] = BugStatus::STATUS_TO_REEXAMINE;
                $data['submit_time'] = now();
            } else if (in_array($data['resolve_status'], [BugStatus::STATUS_SCHEDULING, BugStatus::STATUS_IN_PROGRESS])) {
                $data['status'] = $data['resolve_status'];
            }
        }
        // 已处理和不处理时，问题解决状态不可更改，其他信息可以更改
        if (in_array($bug->status, [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])) {
            unset($data['resolve_status']);
            unset($data['status']);
        }
        $bug->update($data);
    }

    /**
     * @param Bug $bug
     */
    public function submitHandleResultCancel(Bug $bug)
    {
        $bug->update(['status' => BugStatus::STATUS_IN_PROGRESS, 'submit_time' => null]);
    }

    /**
     * @param Bug $bug
     * @param $data
     */
    public function updateHandleResult(Bug $bug, $data)
    {
        if (!isset($data['reason_analyse'])) {
            $data['reason_analyse'] = '';
        }
        if (!isset($data['data_restore_comment'])) {
            $data['data_restore_comment'] = '';
        }
        if (!isset($data['inquiry_progress'])) {
            $data['inquiry_progress'] = '';
        }
        $bug->update($data);
    }

    /**
     * 复核
     * @param Bug $bug
     * @param array $data
     */
    public function reexamine(Bug $bug, array $data)
    {
        // 复核不合格改为进行中
        if ($data['is_qualified'] == 0) {
            $bug->update([
                'status' => BugStatus::STATUS_IN_PROGRESS,
                'submit_time' => null,
            ]);
            $bug->addLabel('验收不合格');
        } else {
            // 复核通过，修改状态
            $data['status'] = $data['resolve_status'];
            if (in_array($data['status'], [BugStatus::STATUS_COMPLETED, BugStatus::STATUS_NO_HANDLE])) {
                $data['finish_time'] = now();
            }
            $bug->update($data);

            // 新增验收合格标签
            // $bug->addLabel('已验收');
            // 复核通过如果存在验收不合格标签就删除
            if ($bug->labels()->where('name', '验收不合格')->exists()) {
                $bug->labels()->where('name', '验收不合格')->delete();
            }
        }
        // 复核添加验收日志
        $this->addBugAccept($bug, BugAccept::TYPE_PROGRAM_PRINCIPAL, $data['is_qualified']);
    }

    /**
     * 验收
     * @param Bug $bug
     * @param $data
     * @throws InvalidParameterException
     */
    public function accept(Bug $bug, $data, $type)
    {
        if ($data['result'] == 0) {
            $bug->update(['status' => BugStatus::STATUS_IN_PROGRESS]);
            $bugAccept = $this->addBugAccept($bug, $type, $data['result']);
            $bug->addLabel('验收不合格');
        } else {
            $bugAccept = $this->addBugAccept($bug, $type, $data['result']);
            $bug->addLabel('已验收');
        }
        if (isset($data['media'])) {
            $bugAccept->addMedias($data['media']);
        }
    }

    /**
     * 添加验收记录
     * @param Bug $bug
     * @param $type
     * @param $result
     * @return \Illuminate\Database\Eloquent\Model | BugAccept
     */
    protected function addBugAccept(Bug $bug, $type, $result)
    {
        $comment = request()->input('comment', '') ?? '';
        $user = Auth::user();
        $data = [
            'result' => $result,
            'type' => $type,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'comment' => $comment,
        ];
        return $bug->bugAccept()->updateOrCreate(['type' => $type], $data);
    }

    /**
     * 开始处理：跟进人开始 或 程序负责人开始
     * @param Bug $bug
     */
    public function start(Bug $bug)
    {
        $users = $bug->handlers->pluck('handler_id')->toArray();
        if (empty($users)) {
            $handler = Auth::user();
            $bug->handlers()->create([
                'handler_id' => $handler->id,
                'handler_name' => $handler->name,
            ]);
        }
        $bug->update([
            'status' => BugStatus::STATUS_IN_PROGRESS,
            'start_handle_time' => now(),
            'expiration_date' => now()->toDateString(),
        ]);
    }
}
