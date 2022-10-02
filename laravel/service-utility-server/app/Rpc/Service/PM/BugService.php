<?php

namespace App\Rpc\Service\PM;

use App\Enums\ProjectManage\BugExamineStatus;
use App\Enums\ProjectManage\BugStatus;
use App\Enums\ProjectManage\ProductStatus;
use App\Models\User;
use App\ProjectManage\Models\Bug;
use App\ProjectManage\Models\BugPrincipal;
use App\ProjectManage\Repositories\BugsRepository;
use App\Rpc\Traits\RpcTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BugService
{
    use RpcTrait;

    /**
     * 创建 bug
     * 以下用户ID均为 uums 系统中用户ID
     * @param int $operationUserId 操作人ID
     * @param int $bugPromulgatorId bug发布人ID
     * @param int $erpBugId erp系统中bug_id    // 2021.4.7 与erp关联改成erp_bug_number字段
     * @param array $data bug数据
     * @param array $auditData erp审批结果数据(二维数组)
     * @return array
     */
    public function store(int $operationUserId, int $bugPromulgatorId, int $erpBugId, array $data, array $auditData = [])
    {
        // 发布人名称、部门
        $user = User::query()->find($bugPromulgatorId);
        if (empty($user)) {
            return self::failed('发布人不存在');
        }
        // 操作人
        $operationUser = User::query()->find($operationUserId);
        if (empty($operationUser)) {
            return self::failed('操作人不存在');
        }
        Auth::login($operationUser);

        $data['erp_bug_id'] = $erpBugId;

        // 数据验证
        $validator = Validator::make($data, [
            'operation_account' => 'required|array',
            'operation_account.*' => 'required|exists:users,id',
            'browser' => 'required|array',
            'browser.*' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'operation_platform' => 'required|integer|between:1,7',
            'is_urgent' => 'integer|between:0,1',
            'links' => 'array',
            'links.*' => 'string',
            'version' => 'string',
            'description' => 'required|string',
            'media' => 'array',
            'media.*.name' => 'required_with:media|string',
            'media.*.content' => 'required_with:media|url',
            'media.*.user_id' => 'integer|exists:users,id',
            'media.*.upload_time' => 'date',
            'product_line' => 'integer|exists:pm_products,id',
            'product_id' => 'integer|exists:pm_products,id',
            'source_project_id' => 'integer|exists:pm_projects,id',
            'source_project_name' => 'string',
            'source_demand_id' => 'integer|exists:pm_demands,id',
            'source_demand_name' => 'string',
            'erp_bug_number' => 'required|string',
        ], [], [
            'operation_account' => '操作账号',
            'operation_account.*' => '操作账号',
            'browser' => '浏览器',
            'browser.*' => '浏览器',
            'start_time' => '故障开始时间',
            'end_time' => '故障结束时间',
            'operation_platform' => '操作平台',
            'is_urgent' => '是否加急',
            'links' => '页面链接',
            'links.*' => '页面链接',
            'version' => '软件版本号',
            'description' => '故障描述',
            'media' => '附件',
            'media.*.name' => '附件名',
            'media.*.content' => '附件地址',
            'media.*.user_id' => '附件上传人',
            'media.*.upload_time' => '附件上传时间',
            'product_line' => '所属产品线',
            'product_id' => '所属产品',
            'source_project_id' => '所属项目ID',
            'source_project_name' => '所属项目名称',
            'source_demand_id' => '所属需求ID',
            'source_demand_name' => '所属需求名称',
            'erp_bug_number' => 'Bug编号',
        ]);
        if ($validator->fails()) {
            return self::failed($validator->errors()->first());
        }

        if (Bug::query()->where('erp_bug_number', $data['erp_bug_number'])->exists()) {
            return self::failed('此Bug已推送至PMS，请勿重复推送！');
        }

        // 验证审批信息
        if ($auditData) {
            $auditValidator = Validator::make($auditData, [
                '*.audit_type' => 'required|integer|between:1,2', // 审批类型：1:财务审批；2：内控审批
                '*.audit_user_id' => 'required|exists:users,id',    // 审批人
                '*.audit_remark' => 'string',                       // 审批意见（备注）
            ], [], [
                '*.audit_type' => '审批类型',
                '*.audit_user_id' => '审批人ID',
                '*.audit_remark' => '审批备注',
            ]);
            if ($auditValidator->fails()) {
                return self::failed($auditValidator->errors()->first());
            }
        }

        // 过滤字段 去掉空字符串 “无”
        if (isset($data['browser'])) {
            $data['browser'] = collect($data['browser'])->reject(function ($item) {
                return empty($item) || $item == '无';
            })->values()->toArray();
            if (empty($data['browser'])) {
                unset($data['browser']);
            }
        }
        if (isset($data['links'])) {
            $data['links'] = collect($data['links'])->reject(function ($item) {
                return empty($item) || $item == '无';
            })->values()->toArray();
            if (empty($data['links'])) {
                unset($data['links']);
            }
        }

        DB::beginTransaction();
        try {
            // 登录发布人账号
            $data['promulgator_id'] = $user->id;
            $data['promulgator_name'] = $user->name;
            $dept = $user->basicDepartment;
            $data['dept_id'] = $dept->id;
            $data['dept_name'] = $dept->name;
            $data['status'] = BugStatus::STATUS_TO_ASSIGN;
            if ($auditData) {
                $data['examine_status'] = collect($auditData)->where('audit_type', 2)->isNotEmpty() ?
                    BugExamineStatus::INTERNAL_CONTROL_EXAMINE_PASS :
                    BugExamineStatus::FINANCIAL_EXAMINE_PASS;
            }

            // 负责人
            $principals = BugPrincipal::query()->where('dept_id', $dept->id)->first();
            if (empty($principals)) {
                return self::failed('部门负责人不能为空，请先绑定部门负责人');
            }
            $bugRepository = app()->make(BugsRepository::class);
            // 产品负责人
            $productPrincipal = $bugRepository->getProductPrincipal($principals, $data['operation_platform']);
            $data['product_principal_id'] = $productPrincipal->id;
            $data['product_principal_name'] = $productPrincipal->name;
            // 程序负责人
            $programPrincipal = $bugRepository->getProgramPrincipal($principals, $data['operation_platform']);
            $data['program_principal_id'] = $programPrincipal->id;
            $data['program_principal_name'] = $programPrincipal->name;
            // 测试负责人
            if (empty($principals->test_user_id)) {
                return self::failed('测试负责人不能为空！');
            }
            $data['test_principal_id'] = $principals->test_user_id;
            $data['test_principal_name'] = $principals->test_user_name;

            $bug = Bug::query()->create($data);

            // 添加审批标签
            if ($auditData) {
                foreach ($auditData as $item) {
                    $this->addLabel($bug, $item);
                }
            }

            // 上传附件
            if (isset($data['media'])) {
                $this->addMedias($bug, $data['media']);
            }

            // 关联产品
            if (isset($data['product_line'])) {
                $bug->products()->attach($data['product_line'], ['type' => ProductStatus::TypeLine]);
            }
            if (isset($data['product_id'])) {
                $bug->products()->attach($data['product_id'], ['type' => ProductStatus::TypeProduct]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return self::failed($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return self::success(['bug' => $bug->toArray()]);
    }

    /**
     * 添加审批标签
     * @param Bug $bug
     * @param $auditData
     */
    protected function addLabel(Bug $bug, $auditData)
    {
        if ($auditData['audit_type'] == 1) {
            $name = '财务审批通过';
        } else if ($auditData['audit_type'] == 2) {
            $name = '内控审批通过';
        }
        $user = User::query()->find($auditData['audit_user_id']);
        $bug->labels()->create([
            'name' => $name,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'comment' => $auditData['audit_remark'],
        ]);
    }

    /**
     * 保存附件
     * @param Bug $bug
     * @param array $medias
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    protected function addMedias(Bug $bug, array $medias)
    {
        foreach ($medias as $media) {
            $properties = [];
            if (isset($media['user_id'])) {
                $properties['user_id'] = $media['user_id'];
                $properties['user_name'] = getUserNameById($media['user_id']);
            }
            if (isset($media['upload_time'])) {
                $properties['created_at'] = $media['upload_time'];
            }
            if (Str::contains($media['name'], '/')) {
                $media['name'] = Arr::last(explode('/', $media['name']));
            }
            $tmpFileName = now()->toDateString() . '/' . Auth::id() . '/' . $media['name'];
            Storage::disk('tmp')->put($tmpFileName, file_get_contents($media['content']));
            $path = storage_path('app/tmp/' . $tmpFileName);
            $saveFileName = Str::uuid()->getHex() . '.' . pathinfo($path, PATHINFO_EXTENSION);
            $bug->addMedia($path)
                ->usingName($media['name'])
                ->usingFileName($saveFileName)
                ->withProperties($properties)
                ->toMediaCollection($bug->getMediaCollectionName());
        }
    }
}
